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

    private RequestValidator $requestValidator;

    /**
     * @param array<string, string> $mapUris
     * @param array<string, string> $mapParams
     * @param array<string, string> $mapUriRequiredParams
     */
    public function __construct(
        array $mapUris,
        array $mapParams,
        array $mapUriRequiredParams
    ) {
        $this->mapUris = $mapUris;
        $this->mapParams = $mapParams;

        $this->requestValidator = new RequestValidator(
            $mapUris,
            $mapParams,
            $mapUriRequiredParams
        );
    }

    /**
     * @param array<string, int|string> $params
     */
    public function run(string $uri, array $params = []): string
    {
        $this->requestValidator->run($uri, $params);

        $filePath = $this->mapUris[$uri];

        $joinKeyValue = fn (int $v, string $k) => "{$this->mapParams[$k]}{$v}";
        $pathPieces = array_map($joinKeyValue, $params, array_keys($params));

        if (count($pathPieces)) {
            return $filePath . '/' . implode('/', $pathPieces);
        }

        return $filePath;
    }
}
