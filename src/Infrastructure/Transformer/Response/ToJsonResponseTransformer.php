<?php

namespace App\Infrastructure\Transformer\Response;

use App\Dto\ResponseObjectInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ToJsonResponseTransformer implements ResponseObjectToHttpResponseTransformerInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function transform(ResponseObjectInterface $responseObject): Response
    {
        return
            new Response(
                $this->serializer->serialize($responseObject, 'json'),
                Response::HTTP_OK,
                ['Content-Type' => 'application/json']
            );
    }
}
