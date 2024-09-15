<?php

declare(strict_types=1);

namespace Alisson04\ApiResponseSaver\Validators;

abstract class RequestValidator
{
    /**
     * @var array<string, string> $mapUris
     */
    protected array $mapUris;

    /**
     * @var array<string, string> $mapParams
     */
    protected array $mapParams;

    /**
     * @var array<string, string> $mapUriRequiredParams
     */
    protected array $mapUriRequiredParams;

    protected string $uri;

    /**
     * @var array<string, int|string> $formParams
     */
    protected array $formParams;

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
        $this->mapUriRequiredParams = $mapUriRequiredParams;
    }
}
