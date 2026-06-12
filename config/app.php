<?php
declare(strict_types=1);

use Gfiedler\ToDoAPI\config\Database;
use Gfiedler\ToDoAPI\Model\Tarefa;

header('Content-Type: application/json; charset=utf-8');

$router = new Router();
$pdo = Database::getConnection();
$repo = new TarefaRepository($pdo);
$service = new TarefaService($repo);

// Listar tarefa
$router->get('/api/tarefas', function () use ($service): array {

    return [
        'data' => array_map(
            fn(Tarefa $t) => $t->toArray(),
            $service->listar()
        )
    ];
});


// Buscar tarefa por ID
$router->get('/api/tarefas/{id}',
    function(array $params) use ($service): array {

        $tarefa = $service->buscar(
            (int)$params['id']
        );

        if (!$tarefa) {
            http_response_code(404);

            return [
                'erro' => 'Tarefa não encontrada'
            ];
        }

        return [
            'data' => $tarefa->toArray()
        ];
    });

// Criar tarefa
$router->post('/api/tarefas',
    function() use ($service): array {

        $raw = file_get_contents(
            'php://input'
        );

        if (!json_validate($raw)) {

            http_response_code(400);

            return [
                'erro' => 'JSON inválido'
            ];
        }

        $input = json_decode(
            $raw,
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $tarefa = $service->criar(
            $input
        );

        http_response_code(201);

        return [
            'data' => $tarefa->toArray()
        ];
    });

$router->dispatch();

