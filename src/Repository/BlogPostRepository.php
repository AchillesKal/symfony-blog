<?php

namespace App\Repository;

use App\Entity\BlogPost;
use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BlogPost>
 *
 * @method BlogPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogPost[]    findAll()
 * @method BlogPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogPost::class);
    }

    public function createOrderByPublishedAtQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('bp')
            ->andWhere('bp.publishedAt IS NOT NULL')
            ->orderBy('bp.publishedAt', 'DESC');
    }

    public function createFilteredByTagOrderByPublishedAtQueryBuilder(Tag $tag): QueryBuilder
    {
        return $this->createQueryBuilder('bp')
            ->innerJoin('bp.tags', 't')
            ->andWhere('bp.publishedAt IS NOT NULL')
            ->andWhere('t = :tag')
            ->setParameter('tag', $tag)
            ->orderBy('bp.publishedAt', 'DESC');
    }

    //    /**
    //     * @return BlogPost[] Returns an array of BlogPost objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?BlogPost
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
