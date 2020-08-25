<?php

declare(strict_types=1);

namespace App\Repository\Criteria;

use DateTimeInterface;

class ReviewCriteria
{
    /**
     * @var int|null
     */
    private $hotelId;

    /**
     * @var DateTimeInterface|null
     */
    private $startDateTime;

    /**
     * @var DateTimeInterface|null
     */
    private $endDateTime;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $offset;

    public function getHotelId(): ?int
    {
        return $this->hotelId;
    }

    public function setHotelId(int $hotelId): ReviewCriteria
    {
        $this->hotelId = $hotelId;
        return $this;
    }

    public function getStartDateTime(): ?DateTimeInterface
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(DateTimeInterface $startDateTime): ReviewCriteria
    {
        $this->startDateTime = $startDateTime;
        return $this;
    }

    public function getEndDateTime(): ?DateTimeInterface
    {
        return $this->endDateTime;
    }

    public function setEndDateTime(DateTimeInterface $endDateTime): ReviewCriteria
    {
        $this->endDateTime = $endDateTime;
        return $this;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): ReviewCriteria
    {
        $this->limit = $limit;
        return $this;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function setOffset(int $offset): ReviewCriteria
    {
        $this->offset = $offset;
        return $this;
    }
}
