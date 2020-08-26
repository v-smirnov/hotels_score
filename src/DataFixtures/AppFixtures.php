<?php

namespace App\DataFixtures;

use App\Entity\Hotel;
use App\Entity\Review;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTimeInterface;
use DateTime;

class AppFixtures extends Fixture
{
    private const TOTAL_REVIEW_COUNT = 100000;

    public function load(ObjectManager $manager)
    {
        $hotelList = $this->createHotels($manager);

        $this->createReviews($manager, $hotelList);

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     *
     * @return Hotel[]
     */
    private function createHotels(ObjectManager $manager): array
    {
        return
            array_map(
                function (string $name) use ($manager) {
                    $hotel = new Hotel($name);

                    $manager->persist($hotel);

                    return $hotel;
                },
                ['Viva', 'One', 'BBQ', 'Hilton', 'Royal', 'Sunny', 'Snowball', 'OldGrandpa', 'TomHotel', 'Natasha']
            );
    }

    private function createReviews(ObjectManager $manager, array $hotelList): void
    {
        for ($i = 0; $i < self::TOTAL_REVIEW_COUNT; $i++) {
            $manager->persist(
                $this->createReviewEntity($hotelList, new DateTime('-2 years'), new DateTime())
            );
        }
    }

    private function createReviewEntity(
        array $hotelList,
        DateTimeInterface $earliestReviewDateTime,
        DateTimeInterface $latestReviewDateTime
    ): Review {
        return
            (new Review())
                ->setHotel($hotelList[random_int(0, count($hotelList) - 1)])
                ->setScore(random_int(10, 100) / 10)
                ->setComment(random_int(0, 1) == 1 ? 'Awesome hotel' : null)
                ->setCreatedDate($this->getRandomDateTimeInRange($earliestReviewDateTime, $latestReviewDateTime));
    }

    private function getRandomDateTimeInRange(
        DateTimeInterface $earliestReviewDateTime,
        DateTimeInterface $latestReviewDateTime
    ): DateTimeInterface {
        $randomTimestamp = random_int($earliestReviewDateTime->getTimestamp(), $latestReviewDateTime->getTimestamp());

        return (new DateTime())->setTimestamp($randomTimestamp);
    }
}
