<?php

declare(strict_types=1);

namespace Alisson04\ApiResponseSaver;

use Alisson04\ApiResponseSaver\Validators\RequestParamsValidator;
use Alisson04\ApiResponseSaver\Validators\RequestUriValidator;

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

    private RequestUriValidator $requestUriValidator;
    private RequestParamsValidator $requestParamsValidator;

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

        $this->requestUriValidator = new RequestUriValidator(
            $mapUris,
            $mapParams,
            $mapUriRequiredParams
        );
        $this->requestParamsValidator = new RequestParamsValidator(
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
        $this->requestUriValidator->validate($uri);
        $this->requestParamsValidator->validate($uri, $params);

        $filePath = $this->mapUris[$uri];

        $joinKeyValue = fn (int $v, string $k) => "{$this->mapParams[$k]}{$v}";
        $pathPieces = array_map($joinKeyValue, $params, array_keys($params));

        if (count($pathPieces)) {
            return $filePath . '/' . implode('/', $pathPieces);
        }

        return $filePath;
    }
}
