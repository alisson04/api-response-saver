<?php

namespace Alisson04\ApiResponseSaver;

class GenerateLocalReponsePath
{
    private array $mapUris;
    private array $mapParams;
    private array $mapUriNecessaryParams;

    public function __construct(
        array $mapUris,
        array $mapParams,
        array $mapUriNecessaryParams
    ) {
        $this->mapUris = $mapUris;
        $this->mapParams = $mapParams;
        $this->mapUriNecessaryParams = $mapUriNecessaryParams;
    }

    public function run(string $uri, array $formParams = []): string
    {
        $this->validate($uri, $formParams);

        $filePath = $this->mapUris[$uri];

        foreach ($formParams as $key => $value) {
            $filePath .= '/' . $this->mapParams[$key] . "{$value}";
        }

        return $filePath;
    }

    private function validate(string $uri, array $formParams): void
    {
        $this->validateUri($uri);

        $formParamsKeys = array_keys($formParams);

        $this->validateInvalidParams($formParamsKeys);
        $this->validateInvalidParamsForUri($uri, $formParamsKeys);
        $this->validateMissingParamsForUri($uri, $formParamsKeys);
    }

    private function validateUri(string $uri): void
    {
        $invalidUri = ! isset($this->mapUris[$uri]);

        if ($invalidUri) {
            throw new \Exception("Uri not found: {$uri}");
        }
    }

    private function validateInvalidParamsForUri(
        string $uri,
        array $formParamsKeys
    ): void {
        $uriNecessaryParams = $this->mapUriNecessaryParams[$uri];

        $invalidParamsForUri = array_diff($formParamsKeys, $uriNecessaryParams);
        if (! empty($invalidParamsForUri)) {
            $paramsString = implode(', ', $invalidParamsForUri);
            throw new \Exception(
                "Invalid params for uri({$uri}): {$paramsString}"
            );
        }
    }

    private function validateInvalidParams(array $formParamsKeys): void
    {
        $mapParamsKeys = array_keys($this->mapParams);
        $invalidParams = array_diff($formParamsKeys, $mapParamsKeys);
        if (! empty($invalidParams)) {
            $paramsString = implode(', ', $invalidParams);
            throw new \Exception("Invalid params found: {$paramsString}");
        }
    }

    private function validateMissingParamsForUri(
        string $uri,
        array $formParamsKeys
    ): void {
        $uriNecessaryParams = $this->mapUriNecessaryParams[$uri];
        $missingRequired = array_diff($uriNecessaryParams, $formParamsKeys);
        if (! empty($missingRequired)) {
            $paramsString = implode(', ', $missingRequired);
            throw new \Exception(
                "Missing params for uri({$uri}): {$paramsString}"
            );
        }
    }
}
