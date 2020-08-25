<?php

namespace App\Repository;

use App\Entity\Review;
use App\Repository\Criteria\ReviewCriteria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository implements ReviewRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function findGroupedByCriteria(ReviewCriteria $criteria, string $groupingPeriod): array
    {
        $queryBuilder = $this->createQueryBuilder('r');

        if ($groupingPeriod === 'day') {
            $queryBuilder
                ->select("count(r.id) as review_count, avg(r.score) as average_score, concat('day-', dayofyear(r.createdDate), '-', extract(year from r.createdDate)) as date_group");
        } elseif ($groupingPeriod === 'week') {
            $queryBuilder
                ->select("count(r.id) as review_count, avg(r.score) as average_score, concat('week-', week(r.createdDate), '-', extract(year from r.createdDate)) as date_group");
        } else {
            $queryBuilder
                ->select("count(r.id) as review_count, avg(r.score) as average_score, concat('month-', month(r.createdDate), '-', extract(year from r.createdDate)) as date_group");
        }

        $queryBuilder
            ->groupBy('date_group')
            ->setFirstResult($criteria->getOffset())
            ->setMaxResults($criteria->getLimit())
        ;

        $this->addConditionsByCriteria($criteria, $queryBuilder);

        return $queryBuilder->getQuery()->getArrayResult();
    }

    public function getTotalCountByCriteria(ReviewCriteria $criteria, string $groupingPeriod): int
    {
        $queryBuilder = $this->createQueryBuilder('r');

        if ($groupingPeriod === 'day') {
            $queryBuilder
                ->select("count(r.id) as review_count, concat('day-', dayofyear(r.createdDate), '-', extract(year from r.createdDate)) as date_group");
        } elseif ($groupingPeriod === 'week') {
            $queryBuilder
                ->select("count(r.id) as review_count, concat('week-', week(r.createdDate), '-', extract(year from r.createdDate)) as date_group");
        } else {
            $queryBuilder
                ->select("count(r.id) as review_count, concat('month-', month(r.createdDate), '-', extract(year from r.createdDate)) as date_group");
        }

        $queryBuilder->groupBy('date_group');


        $this->addConditionsByCriteria($criteria, $queryBuilder);

        return count($queryBuilder->getQuery()->getResult());
    }

    private function addConditionsByCriteria(ReviewCriteria $criteria, QueryBuilder $queryBuilder): QueryBuilder
    {
        if ($criteria->getHotelId() !== null) {
            $queryBuilder
                ->andWhere('r.hotel = :hotelId')
                ->setParameter('hotelId', $criteria->getHotelId());
        }

        if ($criteria->getStartDateTime() !== null) {
            $queryBuilder
                ->andWhere('r.createdDate >= :startDateTime')
                ->setParameter('startDateTime', $criteria->getStartDateTime());
        }

        if ($criteria->getEndDateTime() !== null) {
            $queryBuilder
                ->andWhere('r.createdDate <= :endDateTime')
                ->setParameter('endDateTime', $criteria->getEndDateTime());
        }

        return $queryBuilder;
    }
}
