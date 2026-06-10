<?php
declare(strict_types=1);

use Gfiedler\ToDoAPI\config\Database;

header('Content-Type: application/json; charset=utf-8');

$router = new Router();
$pdo = Database::getConnection();
$repo = new TarefaRepository($pdo);

// Listar tarefa
$router->get('/api/tarefas', function () use ($repo): array {
    return ['data' => $repo->listar()];

});


// Buscar tarefa por ID
$router->get('/api/tarefas/{id}', function (array $params) use ($repo): array {
    $tarefa = $repo->buscarPorId((int) $params['id']);
    if (!$tarefa) {
        http_response_code(404);
        return ['erro' => 'Tarefa não encontrada'];
    }
    return ['data' => $tarefa];
});

// Criar tarefa
$router->post('/api/tarefas', function () use ($repo): array {
    $input = json_decode(file_get_contents('php://input'), true);
    $raw = file_get_contents('php://input');
    if (!json_validate($raw)) {
        http_response_code(400);
        return ['erro' => 'JSON inválido'];
    }

    $titulo = trim($input['titulo'] ?? '');
    if (empty($titulo)) {
        http_response_code(422);
        return ['erro' => 'Título obrigatório'];
    }

    $id = $repo->criar($titulo, $input['descricao'] ?? '');
    http_response_code(201);
    return ['data' => $repo->buscarPorId($id)];
});

$router->dispatch();

