<?php

declare(strict_types=1);

namespace Alisson04\ApiResponseSaver;

final class GenerateLocalReponsePath
{
    /**
     * @var array<string, string> $mapUris
     */
    private array $mapUris;

    /**
     * @var array<string, string> $mapParams
     */
    private array $mapParams;

    /**
     * @var array<string, string> $mapUriNecessaryParams
     */
    private array $mapUriNecessaryParams;

    private string $uri;

    /**
     * @var array<string, int|string> $formParams
     */
    private array $formParams;

    /**
     * @param array<string, string> $mapUris
     * @param array<string, string> $mapParams
     * @param array<string, string> $mapUriNecessaryParams
     */
    public function __construct(
        array $mapUris,
        array $mapParams,
        array $mapUriNecessaryParams
    ) {
        $this->mapUris = $mapUris;
        $this->mapParams = $mapParams;
        $this->mapUriNecessaryParams = $mapUriNecessaryParams;
    }

    /**
     * @param array<string, int|string> $formParams
     */
    public function run(string $uri, array $formParams = []): string
    {
        $this->uri = $uri;
        $this->formParams = $formParams;

        $this->validate();

        $filePath = $this->mapUris[$uri];

        foreach ($formParams as $key => $value) {
            $filePath .= '/' . $this->mapParams[$key] . "{$value}";
        }

        return $filePath;
    }

    private function validate(): void
    {
        $this->validateUri($this->uri);

        $formParamsKeys = array_keys($this->formParams);

        $this->validateInvalidParams($formParamsKeys);
        $this->validateInvalidParamsForUri($formParamsKeys);
        $this->validateMissingParamsForUri($formParamsKeys);
    }

    private function validateUri(): void
    {
        $invalidUri = ! isset($this->mapUris[$this->uri]);

        if ($invalidUri) {
            throw new \Exception("Uri not found: {$this->uri}");
        }
    }

    /**
     * @param array<int, string> $formParamsKeys
     */
    private function validateInvalidParamsForUri(array $formParamsKeys): void
    {
        $uriNecessaryParams = $this->mapUriNecessaryParams[$this->uri];

        $invalidParamsForUri = array_diff($formParamsKeys, $uriNecessaryParams);
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
        $uriNecessaryParams = $this->mapUriNecessaryParams[$this->uri];
        $missingRequired = array_diff($uriNecessaryParams, $formParamsKeys);
        if (count($missingRequired)) {
            $paramsString = implode(', ', $missingRequired);
            throw new \Exception(
                "Missing params for uri({$this->uri}): {$paramsString}"
            );
        }
    }
}
