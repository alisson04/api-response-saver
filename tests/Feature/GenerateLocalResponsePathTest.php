<?php

use Alisson04\ApiResponseSaver\GenerateReponsePath;

beforeEach(function () {
    $mapUris = [
        'ConsultarTabelaDeReferencia' => 'ref',
        'ConsultarMarcas' => 'bra',
    ];

    $mapParams = [
        'codigoTabelaReferencia' => 'ref',
        'codigoTipoVeiculo' => 'vet',
    ];

    $mapUriNecessaryParams = [
        'ConsultarTabelaDeReferencia' => [],
        'ConsultarMarcas' => ['codigoTabelaReferencia', 'codigoTipoVeiculo'],
    ];

    $this->service = new GenerateReponsePath(
        $mapUris,
        $mapParams,
        $mapUriNecessaryParams
    );
});

it('should generate path for references', function () {
    $path = $this->service->run('ConsultarTabelaDeReferencia', []);
    expect($path)->toEqual('ref');
});

it('should generate path for brands', function () {
    $path = $this->service->run(
        'ConsultarMarcas',
        ['codigoTabelaReferencia' => 1, 'codigoTipoVeiculo' => 1]
    );
    expect($path)->toEqual('bra/ref1/vet1');
});