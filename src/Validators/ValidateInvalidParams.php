<?php

declare(strict_types=1);

namespace Alisson04\ApiResponseSaver\Validators;

final class ValidateInvalidParams extends RequestValidator
{
    /**
     * @param array<string, int|string> $params
     */
    public function validate(string $uri, array $params): void
    {
        $paramKeys = array_keys($params);
        $uriRequiredParams = $this->mapUriRequiredParams[$uri];
        $invalidParams = array_diff($paramKeys, $uriRequiredParams);

        if (count($invalidParams)) {
            $paramsString = implode(', ', $invalidParams);
            throw new \Exception(
                "Invalid params for uri({$uri}): {$paramsString}"
            );
        }
    }
}
