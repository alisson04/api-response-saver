<?php

declare(strict_types=1);

namespace Alisson04\ApiResponseSaver\Validators;

final class RequestUriValidator extends RequestValidator
{
    public function validate(string $uri): void
    {
        $invalidUri = ! isset($this->mapUris[$uri]);

        if ($invalidUri) {
            throw new \Exception("Uri not found: {$uri}");
        }
    }
}
