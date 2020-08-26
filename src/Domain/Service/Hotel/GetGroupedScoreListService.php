<?php

declare(strict_types=1);

namespace App\Domain\Service\Hotel;

use App\Domain\Service\ServiceInterface;
use App\Dto\HotelScore\GroupedScore;
use App\Dto\HotelScore\HotelScoreRequest;
use App\Dto\HotelScore\HotelScoreResponse;
use App\Dto\RequestObjectInterface;
use App\Dto\ResponseObjectInterface;
use App\Repository\Criteria\ReviewCriteria;
use App\Repository\ReviewRepositoryInterface;
use DateTimeInterface;

class GetGroupedScoreListService implements ServiceInterface
{
    private ReviewRepositoryInterface $reviewRepository;

    /**
     * @var mixed[]
     */
    private array $daysToGroupingPeriodMap;

    public function __construct(ReviewRepositoryInterface $reviewRepository, array $daysToGroupingPeriodMap)
    {
        $this->reviewRepository = $reviewRepository;
        $this->daysToGroupingPeriodMap = $daysToGroupingPeriodMap;
    }

    /**
     * @param RequestObjectInterface|HotelScoreRequest $request
     *
     * @return ResponseObjectInterface|HotelScoreResponse
     */
    public function performOperation(RequestObjectInterface $request): ResponseObjectInterface
    {
        $criteria =  $this->createCriteria($request);
        $groupingPeriod = $this->getGroupingPeriod($request);

        return
            new HotelScoreResponse(
                $this->reviewRepository->getTotalCountByCriteria($criteria, $groupingPeriod),
                $request->getOffset(),
                $request->getLimit(),
                $this->getGroupedScoreList($criteria, $groupingPeriod)
            );
    }

    private function createCriteria(HotelScoreRequest $request): ReviewCriteria
    {
        return
            (new ReviewCriteria())
                ->setHotelId($request->getHotelId())
                ->setStartDateTime($request->getStartDateTime())
                ->setEndDateTime($request->getEndDateTime())
                ->setOffset($request->getOffset())
                ->setLimit($request->getLimit())
            ;
    }

    private function getGroupingPeriod(HotelScoreRequest $request): string
    {
        $difference = $this->getDifferenceInDaysBetweenDates($request->getStartDateTime(), $request->getEndDateTime());

        foreach ($this->daysToGroupingPeriodMap as $item) {
            if ($item['upperLimit'] >= $difference) {
                return $item['groupingPeriod'];
            }
        }

        return 'month';
    }

    private function getDifferenceInDaysBetweenDates(DateTimeInterface $start, DateTimeInterface $end): int
    {
        return $start->diff($end)->days;
    }

    /**
     * @param ReviewCriteria $criteria
     * @param string $groupingPeriod
     *
     * @return GroupedScore[]
     */
    private function getGroupedScoreList(ReviewCriteria $criteria, string $groupingPeriod): array
    {
        return
            array_map(
                function (array $item) {
                    return new GroupedScore((int) $item['review_count'], (float) $item['average_score'], $item['date_group']);
                },
                $this->reviewRepository->findGroupedByCriteria($criteria, $groupingPeriod)
            );
    }
}
