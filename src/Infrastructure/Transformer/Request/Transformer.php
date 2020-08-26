<?php

declare(strict_types=1);

namespace App\Infrastructure\Transformer\Request;

use App\Dto\RequestObjectInterface;
use Symfony\Component\HttpFoundation\Request;

class Transformer implements HttpRequestToRequestObjectTransformerInterface
{
    public function transform(Request $httpRequest, string $requestObjectClass): RequestObjectInterface
    {
        return $requestObjectClass::createFromHttpRequest($httpRequest);
    }
}
