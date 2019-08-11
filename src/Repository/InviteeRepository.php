<?php

namespace App\Repository;

use App\Entity\Invitee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Invitee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invitee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invitee[]    findAll()
 * @method Invitee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InviteeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Invitee::class);
    }
    public function getResultAndCount(array $where=[], array $sort = [], $limit = 10, $offset=0){
        if($offset >= 1) $offset = $offset-1;
        return [
            $this->countBy($where), 
            self::findBy($where, $sort, $limit, $offset)
        ];
    }

    public function countBy(array $criteria)
    {
        $persister = $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName);
        return $persister->count($criteria);
    }
}
