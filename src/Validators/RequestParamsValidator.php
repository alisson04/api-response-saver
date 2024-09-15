<?php

declare(strict_types=1);

namespace Alisson04\ApiResponseSaver\Validators;

final class RequestParamsValidator extends RequestValidator
{
    /**
     * @param array<string, int|string> $formParams
     */
    public function validate(string $uri, array $formParams): void
    {
        $this->uri = $uri;
        $this->formParams = $formParams;

        $formParamsKeys = array_keys($this->formParams);

        $this->validateInvalidParams($formParamsKeys);
        $this->validateInvalidParamsForUri($formParamsKeys);
        $this->validateMissingParamsForUri($formParamsKeys);
    }

    /**
     * @param array<int, string> $formParamsKeys
     */
    private function validateInvalidParamsForUri(array $formParamsKeys): void
    {
        $uriRequiredParams = $this->mapUriRequiredParams[$this->uri];

        $invalidParamsForUri = array_diff($formParamsKeys, $uriRequiredParams);
        if (count($invalidParamsForUri)) {
            $paramsString = implode(', ', $invalidParamsForUri);
            throw new \Exception(
                "Invalid params for uri({$this->uri}): {$paramsString}"
            );
        }
    }

    /**
     * @param array<int, string> $formParamsKeys
     */
    private function validateInvalidParams(array $formParamsKeys): void
    {
        $mapParamsKeys = array_keys($this->mapParams);
        $invalidParams = array_diff($formParamsKeys, $mapParamsKeys);
        if (count($invalidParams)) {
            $paramsString = implode(', ', $invalidParams);
            throw new \Exception("Invalid params found: {$paramsString}");
        }
    }

    /**
     * @param array<int, string> $formParamsKeys
     */
    private function validateMissingParamsForUri(array $formParamsKeys): void
    {
        $uriRequiredParams = $this->mapUriRequiredParams[$this->uri];
        $missingRequired = array_diff($uriRequiredParams, $formParamsKeys);
        if (count($missingRequired)) {
            $paramsString = implode(', ', $missingRequired);
            throw new \Exception(
                "Missing params for uri({$this->uri}): {$paramsString}"
            );
        }
    }
}
