<?php

use Alisson04\ApiResponseSaver\Validators\ValidateInvalidParams;

beforeEach(function () {
    $mapUris = [
        'ConsultarTabelaDeReferencia' => 'references',
        'ConsultarMarcas' => 'brands',
    ];

    $mapParams = [
        'codigoTabelaReferencia' => 'reference',
        'codigoTipoVeiculo' => 'vehicle-type',
    ];

    $mapUriNecessaryParams = [
        'ConsultarTabelaDeReferencia' => [],
        'ConsultarMarcas' => ['codigoTabelaReferencia', 'codigoTipoVeiculo'],
    ];

    $this->service = new ValidateInvalidParams(
        $mapUris,
        $mapParams,
        $mapUriNecessaryParams
    );
});

it('throws exception by wrong params', function () {
    $this->service->validate(
        'ConsultarMarcas',
        ['wrongParam' => 'wrongValue', 'reference' => 1]
    );
})->throws('Invalid params for uri(ConsultarMarcas): wrongParam, reference');
