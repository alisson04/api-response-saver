<?php

use Alisson04\ApiResponseSaver\Validators\ValidateMissingParams;

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

    $this->service = new ValidateMissingParams(
        $mapUris,
        $mapParams,
        $mapUriNecessaryParams
    );
});

it('throws exception by missing params for uri', function () {
    $path = $this->service->validate('ConsultarMarcas', []);
    expect($path)->toEqual('references');
})->throws('Missing params for uri(ConsultarMarcas): codigoTabelaReferencia, codigoTipoVeiculo');
