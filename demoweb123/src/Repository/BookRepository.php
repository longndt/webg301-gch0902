<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
    * @return Book[]  
    */
    public function searchBook($keyword)
    {
        return $this->createQueryBuilder('book')
            ->andWhere('book.title LIKE :k')
            ->setParameter('k', '%' . $keyword . '%')
            ->orderBy('book.title', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Book[]
     */
    public function viewBookList()    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.id','DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
