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