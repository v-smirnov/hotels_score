<?php

declare(strict_types=1);

namespace App\Infrastructure\Transformer\Response;

use App\Dto\ResponseObjectInterface;
use Symfony\Component\HttpFoundation\Response;

interface ResponseObjectToHttpResponseTransformerInterface
{
    public function transform(ResponseObjectInterface $responseObject): Response;
}
