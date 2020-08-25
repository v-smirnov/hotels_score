<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\Criteria\ReviewCriteria;

interface ReviewRepositoryInterface
{
    /**
     * @param ReviewCriteria $criteria
     * @param string $groupingPeriod
     *
     * @return mixed[]
     */
    public function findGroupedByCriteria(ReviewCriteria $criteria, string $groupingPeriod): array;

    /**
     * @param ReviewCriteria $criteria
     * @param string $groupingPeriod
     *
     * @return int
     */
    public function getTotalCountByCriteria(ReviewCriteria $criteria, string $groupingPeriod): int;
}
