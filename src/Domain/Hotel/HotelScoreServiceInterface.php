<?php

declare(strict_types=1);

namespace App\Domain\Hotel;

use App\Dto\HotelScore\HotelScoreRequest;
use App\Dto\HotelScore\HotelScoreResponse;

interface HotelScoreServiceInterface
{
    public function getHotelScoreList(HotelScoreRequest $request): HotelScoreResponse;
}
