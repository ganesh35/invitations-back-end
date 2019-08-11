<?php

namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

use App\Lib\Paginator;
use App\Entity\Invitation;
use App\Repository\InvitationRepository;

use App\Controller\TokenAuthenticatedController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    /**
    * @Route("/invitations")
    */
class InvitationsController extends Controller implements TokenAuthenticatedController
{

    /**
    * @var InvitationRepository InvitationRepository
    */
    private $invitationRepository;

    /**
    * @var entityManager EntityManagerInterface
    */
    private $entityManager;

    /**
    * @var serializer SerializerInterface
    */
    private $serializer;

    public function __construct(
        InvitationRepository $invitationRepository,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ){
        $this->invitationRepository = $invitationRepository;
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/", name="invitation.list", methods={"GET"})
     */
    public function list(Request $request)
    {

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

        $token = $request->attributes->get('auth_token');
        if($token){
            $where['createdBy'] = $token['email'];
        }

        $paginator = new Paginator($request, $this->container);
        list($count, $res)   = $this->invitationRepository->getResultAndCount( $where, $sort, $paginator->getRecordsPerPage(), $paginator->getCurrentPage() );
        $paginator->setTotalPages($count);
        return $this->json([
            'items' => $this->serializer->serialize($res, 'json'),
            'paginator' => $paginator,
            'sortby' => $sortby,
            'orderby' => $orderby,
            'search_key' => $search_key,
            'search_val' => $search_val,
            'sortFields' => ['title' => 'Title', 'description' => 'Description', 'createdAt' => 'Date created', 'updatedAt' => 'Date updated' ],
            'searchFields' => ['title' => 'Title', 'description' => 'Description']
        ]);
    }


    /**
     * Create a new record
     * @Route("", name="invitation.create", methods={"POST"})
     */
    public function create(Request $request)
    {

        $content = json_decode($request->getContent(), true);
        $errs = [];
        if(empty($content['title'] ))$errs[] = "Invalid Field: Title";
        if(empty($content['description'] ))$errs[] = "Invalid Field: Description";

        if(count($errs)){
            return $this->json(['error' => $err]);            
        }

        // If no errors
        $item = new Invitation();
        $item->setCreatedAt(new \DateTime());
        $item->setUpdatedAt(new \DateTime());
        $item->setTitle($content['title']);
        $item->setDescription($content['description']);

        $token = $request->attributes->get('auth_token');
        if($token){
            $item->setCreatedBy($token['email']);
        }

        $this->entityManager->persist($item);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Invitation created successfully'
        ]);
    }

    /**
     * Replace entire record
     * @Route("/{id}", name="invitation.update", methods={"PUT"})
     */
    public function update(Invitation $item, Request $request)
    {
        $token = $request->attributes->get('auth_token');
        $content = json_decode($request->getContent(), true);
        $errs = [];
        if(empty($content['title'] ))$errs[] = "Invalid Field: Title";
        if(empty($content['description'] ))$errs[] = "Invalid Field: Description";
        if($token['email'] != $item->getCreatedBy()) $errs[] = "Not your Invitation";

        if(count($errs)){
            return $this->json(['error' => $err]);            
        }
        $item->setUpdatedAt(new \DateTime());
        $item->setTitle($content['title']);
        $item->setDescription($content['description']);
        $this->entityManager->persist($item);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Invitation updated successfully'
        ]);
    }    

    /**
     * Delete a specified record
     * @Route("/{id}", name="invitation.delete", methods={"DELETE"})
     */
    public function delete(Invitation $item)
    {
        $this->entityManager->remove($item);
        $this->entityManager->flush();
        return $this->json([
            'message' => 'Record deleted successfully'
        ]);
    }            

    /**
     * @Route("/{id}", name="invitation.read", methods={"GET"})
     */
    public function read(Invitation $item)
    {
        return $this->json([
            'item' => $item
        ]);
    }
}

