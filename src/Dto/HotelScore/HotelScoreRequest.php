<?php

declare(strict_types=1);

namespace App\Dto\HotelScore;

use App\Dto\RequestObjectInterface;
use DateTime;
use DateTimeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class HotelScoreRequest implements RequestObjectInterface
{
    private const DEFAULT_OFFSET = 0;

    private const DEFAULT_LIMIT = 10;

    /**
     * @var int|null
     *
     * @Assert\NotNull()
     * @Assert\Type("numeric")
     */
    private $hotelId;

    /**
     * @var DateTimeInterface
     *
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $startDateTime;

    /**
     * @var DateTimeInterface
     *
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $endDateTime;

    /**
     * @var int
     *
     * @Assert\NotNull()
     * @Assert\Type("numeric")
     */
    private $offset;

    /**
     * @var int
     *
     * @Assert\NotNull()
     * @Assert\Type("numeric")
     * @Assert\LessThanOrEqual(100)
     */
    private $limit;

    public function getHotelId(): int
    {
        return (int) $this->hotelId;
    }

    public function getStartDateTime(): DateTimeInterface
    {
        return new DateTime($this->startDateTime);
    }

    public function getEndDateTime(): DateTimeInterface
    {
        return new DateTime($this->endDateTime);
    }

    public function getOffset(): int
    {
        return (int) $this->offset;
    }

    public function getLimit(): int
    {
        return (int) $this->limit;
    }

    public static function createFromHttpRequest(Request $request): HotelScoreRequest
    {
        $requestDto = new static();

        $requestDto->hotelId = $request->get('hotelId');
        $requestDto->startDateTime = $request->get('startDateTime');
        $requestDto->endDateTime = $request->get('endDateTime');
        $requestDto->offset = $request->get('offset', self::DEFAULT_OFFSET);
        $requestDto->limit = $request->get('limit', self::DEFAULT_LIMIT);

        return $requestDto;
    }

    public static function createFromArray(array $payload): HotelScoreRequest
    {
        $requestDto = new static();

        $requestDto->hotelId = $payload['hotelId'];
        $requestDto->startDateTime = $payload['startDateTime'];
        $requestDto->endDateTime = $payload['endDateTime'];
        $requestDto->offset = $payload['offset'];
        $requestDto->limit = $payload['limit'];

        return $requestDto;
    }
}
