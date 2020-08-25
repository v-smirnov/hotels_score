<?php

declare(strict_types=1);

namespace App\Dto\HotelScore;

class GroupedScore
{
    /**
     * @var int
     */
    private $reviewCount;

    /**
     * @var float
     */
    private $averageScore;

    /**
     * @var string
     */
    private $dateGroup;

    public function __construct(int $reviewCount, float $averageScore, string $dateGroup)
    {
        $this->reviewCount = $reviewCount;
        $this->averageScore = $averageScore;
        $this->dateGroup = $dateGroup;
    }

    public function getReviewCount(): int
    {
        return $this->reviewCount;
    }

    public function getAverageScore(): float
    {
        return $this->averageScore;
    }

    public function getDateGroup(): string
    {
        return $this->dateGroup;
    }
}
