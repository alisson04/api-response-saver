<?php

use Alisson04\ApiResponseSaver\Validators\RequestParamsValidator;

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

    $this->service = new RequestParamsValidator(
        $mapUris,
        $mapParams,
        $mapUriNecessaryParams
    );
});

it('throws exception by wrong params', function () {
    $this->service
        ->validate('ConsultarTabelaDeReferencia', ['wrongParam' => 'wrongValue', 'reference' => 1]);
})->throws('Invalid params found: wrongParam');

it('throws exception by wrong params for uri', function () {
    $this->service
        ->validate('ConsultarTabelaDeReferencia', ['codigoTabelaReferencia' => 1]);
})->throws('Invalid params for uri(ConsultarTabelaDeReferencia): codigoTabelaReferencia');

it('throws exception by missing params for uri', function () {
    $path = $this->service->validate('ConsultarMarcas', []);
    expect($path)->toEqual('references');
})->throws('Missing params for uri(ConsultarMarcas): codigoTabelaReferencia, codigoTipoVeiculo');
