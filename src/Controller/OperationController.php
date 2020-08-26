<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Service\ServiceInterface;
use App\Dto\HotelScore\HotelScoreRequest;
use App\Infrastructure\Transformer\Request\HttpRequestToRequestObjectTransformerInterface;
use App\Infrastructure\Transformer\Response\ResponseObjectToHttpResponseTransformerInterface;
use App\Infrastructure\Transformer\ValidationError\ValidationErrorListToHttpResponseTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OperationController extends AbstractController
{
    private HttpRequestToRequestObjectTransformerInterface $httpRequestToRequestObjectTransformer;

    private ValidatorInterface $validator;

    private ValidationErrorListToHttpResponseTransformer $validationErrorsToHttpResponseTransformer;

    private ServiceInterface $service;

    private ResponseObjectToHttpResponseTransformerInterface $responseObjectToHttpResponseTransformer;

    public function __construct(
        HttpRequestToRequestObjectTransformerInterface $httpRequestToRequestObjectTransformer,
        ValidatorInterface $validator,
        ValidationErrorListToHttpResponseTransformer $validationErrorsToHttpResponseTransformer,
        ServiceInterface $service,
        ResponseObjectToHttpResponseTransformerInterface $responseObjectToHttpResponseTransformer
    ) {
        $this->httpRequestToRequestObjectTransformer = $httpRequestToRequestObjectTransformer;
        $this->validator = $validator;
        $this->validationErrorsToHttpResponseTransformer = $validationErrorsToHttpResponseTransformer;
        $this->service = $service;
        $this->responseObjectToHttpResponseTransformer = $responseObjectToHttpResponseTransformer;
    }

    public function performAction(Request $request): Response
    {
        $requestObject = $this->httpRequestToRequestObjectTransformer->transform($request, HotelScoreRequest::class);

        $errors = $this->validator->validate($requestObject);

        if ($errors->count() > 0) {
            return $this->validationErrorsToHttpResponseTransformer->transform($errors);
        }

        $responseObject = $this->service->performOperation($requestObject);

        return $this->responseObjectToHttpResponseTransformer->transform($responseObject);
    }
}
