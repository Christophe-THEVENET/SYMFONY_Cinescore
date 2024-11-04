<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movie>
 *
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }



    // -------------------------- get movies by genre --------------------------------------

    public function findMoviesByGenre($genreId = null): array|null
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->leftJoin('m.genres', 'g');

        if ($genreId != null) {
            $queryBuilder->where('g.id = :genreId')
                ->setParameter('genreId', $genreId);
        }
        return $queryBuilder->getQuery()->getResult();
    }


    public function findMoviesWithAverageRating(int $limit = null): array
    {
        $qb = $this->createQueryBuilder('m')
            ->select('m', 'AVG(r.rate) as avgRating')
            ->leftJoin('m.reviews', 'r')
            ->groupBy('m.id')
            ->orderBy('m.id', 'DESC');
        if ($limit !== null) {
            $qb->setMaxResults($limit);
        }
        return $qb->getQuery()->getResult();
    }

    public function findMoviesWithCriteria($genreId = null, int $limit = null): array
    {
        $qb = $this->createQueryBuilder('m')
            ->select('m', 'AVG(r.rate) as avgRating')
            ->leftJoin('m.reviews', 'r')
            ->leftJoin('m.genres', 'g')
            ->groupBy('m.id')
            ->orderBy('m.id', 'DESC');

        if ($genreId !== null) {
            $qb->where('g.id = :genreId')
                ->setParameter('genreId', $genreId);
        }

        if ($limit !== null) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }



    //    public function findOneBySomeField($value): ?Movie
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
