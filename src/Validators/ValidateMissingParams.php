<?php

declare(strict_types=1);

namespace Alisson04\ApiResponseSaver\Validators;

final class ValidateMissingParams extends RequestValidator
{
    /**
     * @param array<string, int|string> $params
     */
    public function validate(string $uri, array $params): void
    {
        $uriRequiredParams = $this->mapUriRequiredParams[$uri];
        $paramKeys = array_keys($params);
        $missingRequired = array_diff($uriRequiredParams, $paramKeys);

        if (count($missingRequired)) {
            $paramsString = implode(', ', $missingRequired);

            throw new \Exception(
                "Missing params for uri({$uri}): {$paramsString}"
            );
        }
    }
}
