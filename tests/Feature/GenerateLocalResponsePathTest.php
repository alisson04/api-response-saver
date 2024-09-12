<?php

use Alisson04\ApiResponseSaver\GenerateLocalReponsePath;

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

    $this->service = new GenerateLocalReponsePath($mapUris, $mapParams, $mapUriNecessaryParams);
});

it('should generate path for references', function () {
    $path = $this->service->run('ConsultarTabelaDeReferencia', []);
    expect($path)->toEqual('references');
});

it('should generate path for brands', function () {
    $path = $this->service->run('ConsultarMarcas', ['codigoTabelaReferencia' => 1, 'codigoTipoVeiculo' => 1]);
    expect($path)->toEqual('brands/reference1/vehicle-type1');
});

it('throws exception by wrong uri', function () {
    $this->service->run('ConsultarTabelaDeReferencia1', []);
})->throws('Uri not found: ConsultarTabelaDeReferencia1');

it('throws exception by wrong params', function () {
    $this->service->run('ConsultarTabelaDeReferencia', ['wrongParam' => 'wrongValue', 'reference' => 1]);
})->throws('Invalid params found: wrongParam');

it('throws exception by wrong params for uri', function () {
    $this->service->run('ConsultarTabelaDeReferencia', ['reference' => 1]);
})->throws('Invalid params for uri(ConsultarTabelaDeReferencia) was found: reference');

it('throws exception by missing params for uri', function () {
    $path = $this->service->run('ConsultarMarcas', []);
    expect($path)->toEqual('references');
})->throws('Missing params for uri(ConsultarMarcas): codigoTabelaReferencia, codigoTipoVeiculo');
