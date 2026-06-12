<?php

use Gfiedler\ToDoAPI\Model\Tarefa;


$repo = $this->createMock(
    TarefaRepository::class
);

$repo->method('criar')
    ->willReturn(1);

$repo->method('buscarPorId')
    ->willReturn(
        new Tarefa(
            1,
            'Teste',
            'Descrição'
        )
    );

$service = new TarefaService($repo);

$tarefa = $service->criar([
    'titulo' => 'Teste',
    'descricao' => 'Descrição'
]);

$this->assertEquals(
    1,
    $tarefa->getId()
);

$this->expectException(
    InvalidArgumentException::class
);

$service->criar([
    'titulo' => '',
    'descricao' => 'Descrição'
]);