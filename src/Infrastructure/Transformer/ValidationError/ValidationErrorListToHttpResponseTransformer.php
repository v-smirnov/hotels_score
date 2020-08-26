<?php

declare(strict_types=1);

namespace App\Infrastructure\Transformer\ValidationError;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

interface ValidationErrorListToHttpResponseTransformer
{
    public function transform(ConstraintViolationListInterface $errorList): Response;
}
