<?php

declare(strict_types=1);

namespace Alisson04\ApiResponseSaver;

final class GenerateReponsePath
{
    private GenerateReponsePath $generateReponsePath;

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
        $this->generateReponsePath = new GenerateReponsePath(
            $mapUris,
            $mapParams,
            $mapUriRequiredParams
        );
    }

    /**
     * @param array<string, int|string> $params
     */
    public function saveResponse(
        string $uri,
        array $params,
        string $response
    ): void {
        $filePath = $this->generateReponsePath->run($uri, $params);

        if (! file_exists($filePath)) {
            file_put_contents($filePath, $response);
        }
    }
}
