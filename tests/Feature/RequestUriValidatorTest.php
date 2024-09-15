<?php

use Alisson04\ApiResponseSaver\Validators\RequestUriValidator;

beforeEach(function () {
    $mapUris = [
        'ConsultarTabelaDeReferencia' => 'references',
        'ConsultarMarcas' => 'brands',
    ];

    $this->service = new RequestUriValidator($mapUris, [], []);
});

it('throws exception by wrong uri', function () {
    $this->service->validate('ConsultarTabelaDeReferencia1', []);
})->throws('Uri not found: ConsultarTabelaDeReferencia1');
