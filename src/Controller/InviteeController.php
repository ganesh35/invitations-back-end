<?php
namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

use App\Lib\Paginator;
use App\Entity\Invitee;
use App\Entity\Invitation;
use App\Repository\InviteeRepository;

use App\Controller\TokenAuthenticatedController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    /**
    * @Route("/invitees")
    */
class InviteeController extends Controller implements TokenAuthenticatedController
{
    /**
    * @var InviteeRepository InviteeRepository
    */
    private $inviteeRepository;

    /**
    * @var entityManager EntityManagerInterface
    */
    private $entityManager;

    /**
    * @var serializer SerializerInterface
    */
    private $serializer;

    public function __construct(
        InviteeRepository $inviteeRepository,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ){
        $this->inviteeRepository = $inviteeRepository;
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }


    /**
     * @Route("/{id}", name="list", methods={"GET"})
     */
    public function list(Invitation $invitation, Request $request)
    {

        $token = $request->attributes->get('auth_token');
        if($token['email'] != $invitation->getCreatedBy()){
            return $this->json(['error' => 'You not the owner of this invitation.']);            
        }

        // sort
        $sort = [];
        $sortby = $request->query->get('sortby', 'createdAt');
        $orderby = strtoupper($request->query->get('orderby', 'DESC') ); 
        $sort[$sortby] = $orderby;

        // search
        $where = [];
        $search_key = $request->query->get('search_key', 'title');
        $search_val = $request->query->get('search_val');
        if(!empty($search_key) && !empty($search_val)){
            $where[$search_key] = $search_val;
        }

        $where['invitationId'] = $invitation->getId();
        

        $paginator = new Paginator($request, $this->container);
        list($count, $res)   = $this->inviteeRepository->getResultAndCount( $where, $sort, $paginator->getRecordsPerPage(), $paginator->getCurrentPage() );
        $paginator->setTotalPages($count);
        return $this->json([
            'items' => $this->serializer->serialize($res, 'json'),
            'paginator' => $paginator,
            'sortby' => $sortby,
            'orderby' => $orderby,
            'search_key' => $search_key,
            'search_val' => $search_val,
            'sortFields' => ['status' => 'Status', 'invitationTo' => 'Invitee', 'createdAt' => 'Date created', 'updatedAt' => 'Date updated' ],
            'searchFields' => ['status' => 'Status', 'invitationTo' => 'Invitee']
        ]);
    }



    /**
     * Create a new record
     * @Route("/{id}", name="create", methods={"POST"})
     */
    public function create(Invitation $invitation, Request $request)
    {
        $token = $request->attributes->get('auth_token');
        if($token['email'] != $invitation->getCreatedBy()){
            return $this->json(['error' => 'You not the owner of this invitation.']);            
        }

        $content = json_decode($request->getContent(), true);
        $str = preg_replace('#\s+#',',',trim($content['invitees']));
        $mailIds = array_map('trim', explode(',', $str));

        $ignored = [];
        $invalid = [];
        $valid = [];
        foreach($mailIds as $mailId){
            if (filter_var($mailId, FILTER_VALIDATE_EMAIL)) {

                $entity = $this->inviteeRepository->findOneBy(['invitationTo' => $mailId, 'invitationId' => $invitation->getId()]);
                if ($entity == null)
                {
                    $valid[] = $mailId;
                    $item = new Invitee();
                    $item->setCreatedAt(new \DateTime());
                    $item->setUpdatedAt(new \DateTime());
                    $item->setInvitationTo($mailId);
                    $item->setStatus('Invited');
                    $item->setInvitationId($invitation->getId());
                    $this->entityManager->persist($item);
                    $this->entityManager->flush();
                }
                else {
                    $ignored[] = $mailId;
                }

            } else {
                $invalid[] = $mailId;
            }
        }

        return $this->json([
            'message' => 'Invitation processed',
            'valid' => $valid,
            'invalid' => $invalid,
            'ignored' => $ignored
            
        ]);
    }

}