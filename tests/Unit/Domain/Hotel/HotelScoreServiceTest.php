<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Hotel;

use App\Domain\Hotel\HotelScoreService;
use App\Domain\Hotel\HotelScoreServiceInterface;
use App\Dto\HotelScore\GroupedScore;
use App\Dto\HotelScore\HotelScoreRequest;
use App\Dto\HotelScore\HotelScoreResponse;
use App\Repository\Criteria\ReviewCriteria;
use App\Repository\ReviewRepositoryInterface;
use PHPUnit\Framework\TestCase;
use DateTime;

class HotelScoreServiceTest extends TestCase
{
    private const TOTAL_RECORD_COUNT = 10;

    private const DAYS_TO_GROUPING_PERIOD_MAP = [['upperLimit' => 10, 'groupingPeriod' => 'day']];

    private const HOTEL_ID = 1;

    private const OFFSET = 0;

    private const LIMIT = 10;

    private const GROUPING_PERIOD = 'day';

    private const START_DATE_TIME = '2020-08-20 00:00:00';

    private const END_DATE_TIME = '2020-08-26 00:00:00';

    public function testGettingHotelScoreList(): void
    {
        $service = $this->createService();

        $response = $service->getHotelScoreList($this->createHotelScoreRequest());

        self::assertEquals($this->createExpectedResponse(), $response);
    }

    private function createService(): HotelScoreServiceInterface
    {
        return new HotelScoreService($this->createReviewRepositoryMock(), self::DAYS_TO_GROUPING_PERIOD_MAP);
    }

    private function createReviewRepositoryMock(): ReviewRepositoryInterface
    {
        $mock = $this->createMock(ReviewRepositoryInterface::class);

        $mock
            ->expects(self::once())
            ->method('getTotalCountByCriteria')
            ->with($this->createCriteria(), self::GROUPING_PERIOD)
            ->willReturn(self::TOTAL_RECORD_COUNT)
        ;

        $mock
            ->expects(self::once())
            ->method('findGroupedByCriteria')
            ->with($this->createCriteria(), self::GROUPING_PERIOD)
            ->willReturn(
                [
                    [
                        'review_count' => 10,
                        'average_score' => 5.5,
                        'date_group' => 'd-1-2020',
                    ],
                    [
                        'review_count' => 12,
                        'average_score' => 6.5,
                        'date_group' => 'd-2-2020',
                    ]
                ]
            )
        ;

        return $mock;
    }

    private function createHotelScoreRequest(): HotelScoreRequest
    {
        return
            HotelScoreRequest::createFromArray(
                [
                    'hotelId' => self::HOTEL_ID,
                    'startDateTime' => self::START_DATE_TIME,
                    'endDateTime' => self::END_DATE_TIME,
                    'offset' => self::OFFSET,
                    'limit' => self::LIMIT,
                ]
            );
    }

    private function createCriteria(): ReviewCriteria
    {
        return
            (new ReviewCriteria())
                ->setHotelId(self::HOTEL_ID)
                ->setStartDateTime(new DateTime(self::START_DATE_TIME))
                ->setEndDateTime(new DateTime(self::END_DATE_TIME))
                ->setOffset(self::OFFSET)
                ->setLimit(self::LIMIT)
            ;
    }

    private function createExpectedResponse(): HotelScoreResponse
    {
        return
            new HotelScoreResponse(
                self::TOTAL_RECORD_COUNT,
                self::OFFSET,
                self::LIMIT,
                [
                    new GroupedScore(10, 5.5, 'd-1-2020'),
                    new GroupedScore(12, 6.5, 'd-2-2020'),
                ]
            );
    }
}
