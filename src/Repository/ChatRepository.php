<?php

namespace App\Repository;

use App\Entity\Chat;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Chat>
 */
class ChatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry){
        parent::__construct($registry, Chat::class);
    }

    public function getUserChats(User $user): mixed{
        $qb = $this -> createQueryBuilder('c');

        return $qb -> join('c.users', 'u')
            -> andWhere(':id MEMBER OF c.users')
            -> setParameter('id', $user -> getId())
            -> getQuery()
            -> getResult();
    }

    public function getActiveChats(User $user): mixed{
        $qb = $this -> createQueryBuilder('c');

        return $qb -> join('c.users', 'u')
            -> andWhere(':id NOT MEMBER OF c.users')
            -> setParameter('id', $user -> getId())
            -> getQuery()
            -> getResult();
    }
//    /**
//     * @return Chat[] Returns an array of Chat objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Chat
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
