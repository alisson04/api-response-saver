<?php

namespace Alisson04\ApiResponseSaver;

class GenerateLocalReponsePath
{
    private array $mapUris;
    private array $mapParams;
    private array $mapUriNecessaryParams;

    public function __construct($mapUris, $mapParams, $mapUriNecessaryParams) {
        $this->mapUris = $mapUris;
        $this->mapParams = $mapParams;
        $this->mapUriNecessaryParams = $mapUriNecessaryParams;
    }

    public function run(string $uri, array $formParams = []): string
    {
        $this->validateUri($uri, $formParams);
        $this->validateParams($uri, $formParams);

        $filePath = $this->mapUris[$uri];

        foreach ($formParams as $key => $value) {
            $filePath .= '/' . $this->mapParams[$key] . "{$value}";
        }

        return $filePath;
    }

    private function validateUri(string $uri): void
    {
        $invalidUri = ! isset($this->mapUris[$uri]);

        if ($invalidUri) {
            throw new \Exception("Uri not found: {$uri}");
        }
    }

    private function validateParams(string $uri, array $formParams): void
    {
        $formParamsKeys = array_keys($formParams);

        $invalidParams = array_diff($formParamsKeys, array_keys($this->mapParams));
        if (! empty($invalidParams)) {
            throw new \Exception("Invalid params found: " . implode(', ', $invalidParams));
        }

        $uriNecessaryParams = $this->mapUriNecessaryParams[$uri];

        $invalidParamsForUri = array_diff($formParamsKeys, $uriNecessaryParams);
        if (! empty($invalidParamsForUri)) {
            throw new \Exception("Invalid params for uri({$uri}) was found: " . implode(', ', $invalidParamsForUri));
        }

        $missingRequiredParams = array_diff($uriNecessaryParams, $formParamsKeys);
        if (! empty($missingRequiredParams)) {
            throw new \Exception("Missing params for uri({$uri}): " . implode(', ', $missingRequiredParams));
        }
    }
}
