<?php

namespace App\Domain\Service;

use App\Dto\RequestObjectInterface;
use App\Dto\ResponseObjectInterface;

interface ServiceInterface
{
    public function performOperation(RequestObjectInterface $requestObject): ResponseObjectInterface;
}
