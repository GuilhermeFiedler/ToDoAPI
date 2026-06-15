<?php
declare(strict_types=1);

use Gfiedler\ToDoAPI\Http\Router;
use Gfiedler\ToDoAPI\Model\Tarefa;
use Gfiedler\ToDoAPI\Repository\TarefaRepository;
use Gfiedler\ToDoAPI\Service\TarefaService;
use Gfiedler\ToDoAPI\config\Database;
header('Content-Type: application/json; charset=utf-8');

$router  = new Router();
$pdo     = Database::getConnection();
$repo    = new TarefaRepository($pdo);
$service = new TarefaService($repo);

$router->get('/api/tarefas', function () use ($service): array {
    return ['data' => array_map(fn(Tarefa $t) => $t->toArray(), $service->listar())];
});

$router->get('/api/tarefas/{id}', function (array $params) use ($service): array {
    $tarefa = $service->buscar((int) $params['id']);
    if (!$tarefa) { http_response_code(404); return ['erro' => 'Tarefa não encontrada']; }
    return ['data' => $tarefa->toArray()];
});

$router->post('/api/tarefas', function () use ($service): array {
    $raw = file_get_contents('php://input');

    try {
        $dados = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException) {
        http_response_code(400);
        return ['erro' => 'JSON inválido'];
    }

    $tarefa = $service->criar($dados);

    http_response_code(201);
    return ['data' => $tarefa->toArray()];
});

$router->put('/api/tarefas/{id}', function (array $params) use ($service): array {
    $raw = file_get_contents('php://input');

    try {
        $dados = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException) {
        http_response_code(400);
        return ['erro' => 'JSON inválido'];
    }

    $ok = $service->atualizar((int) $params['id'], $dados);

    if (!$ok) {
        http_response_code(404);
        return ['erro' => 'Tarefa não encontrada'];
    }

    return [
        'data' => $service->buscar((int) $params['id'])->toArray()
    ];
});

$router->delete('/api/tarefas/{id}', function (array $params) use ($service): array {
    $ok = $service->excluir((int) $params['id']);
    if (!$ok) { http_response_code(404); return ['erro' => 'Tarefa não encontrada']; }
    return ['mensagem' => 'Tarefa removida'];
});

$router->dispatch();