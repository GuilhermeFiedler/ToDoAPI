<?php

namespace Repository;


use Gfiedler\ToDoAPI\Model\Tarefa;

$id = $repository->criar(
    'Título',
    'Descrição'
);

$this->assertGreaterThan(
    0,
    $id
);

$tarefa = $repository->buscarPorId(
    $id
);

$this->assertInstanceOf(
    Tarefa::class,
    $tarefa
);

$this->assertNull(
    $repository->buscarPorId(99999)
);

$this->assertTrue(
    $repository->excluir($id)
);