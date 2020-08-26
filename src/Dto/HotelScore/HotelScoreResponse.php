<?php

declare(strict_types=1);

namespace App\Dto\HotelScore;

use App\Dto\ResponseObjectInterface;

class HotelScoreResponse implements ResponseObjectInterface
{
    /**
     * @var int
     */
    private $totalCount;

    /**
     * @var int
     */
    private $offset;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var GroupedScore[]
     */
    private $groupedScoreList;

    /**
     * @param int $totalCount
     * @param int $offset
     * @param int $limit
     * @param array $groupedScoreList
     */
    public function __construct(int $totalCount, int $offset, int $limit, array $groupedScoreList)
    {
        $this->totalCount = $totalCount;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->groupedScoreList = $groupedScoreList;
    }

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    /**
     * @return GroupedScore[]
     */
    public function getGroupedScoreList(): array
    {
        return $this->groupedScoreList;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
