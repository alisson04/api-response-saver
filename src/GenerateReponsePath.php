<?php

declare(strict_types=1);

namespace Alisson04\ApiResponseSaver;

use Alisson04\ApiResponseSaver\Validators\ValidateInvalidParams;
use Alisson04\ApiResponseSaver\Validators\ValidateMissingParams;

final class GenerateReponsePath
{
    /**
     * @var array<string, string> $mapUris
     */
    private array $mapUris;

    /**
     * @var array<string, string> $mapParams
     */
    private array $mapParams;

    private ValidateMissingParams $validateMissingParams;
    private ValidateInvalidParams $validateInvalidParams;

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

        $this->validateMissingParams = new ValidateMissingParams(
            $mapUris,
            $mapParams,
            $mapUriRequiredParams
        );
        $this->validateInvalidParams = new ValidateInvalidParams(
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
        $this->validateMissingParams->validate($uri, $params);
        $this->validateInvalidParams->validate($uri, $params);

        $filePath = $this->mapUris[$uri];

        $joinKeyValue = fn (int $v, string $k) => "{$this->mapParams[$k]}{$v}";
        $pathPieces = array_map($joinKeyValue, $params, array_keys($params));

        if (count($pathPieces)) {
            return $filePath . '/' . implode('/', $pathPieces);
        }

        return $filePath;
    }
}
