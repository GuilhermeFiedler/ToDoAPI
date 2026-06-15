<?php
declare(strict_types=1);

namespace Gfiedler\ToDoAPI\Repository;

use Gfiedler\ToDoAPI\Enum\StatusTarefa;
use Gfiedler\ToDoAPI\Enum\Prioridade;
use Gfiedler\ToDoAPI\Model\Tarefa;
use PDO;

class TarefaRepository
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function criar(
        string $titulo,
        string $descricao,
        StatusTarefa $status = StatusTarefa::Pendente,
        Prioridade $prioridade = Prioridade::Media
    ): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO tarefas (titulo, descricao, status, prioridade)
         VALUES (:titulo, :descricao, :status, :prioridade)'
        );

        $stmt->execute([
            ':titulo' => $titulo,
            ':descricao' => $descricao,
            ':status' => $status->value,
            ':prioridade' => $prioridade->value
        ]);
        $id = $this->pdo->lastInsertId();

        if ($id === '0') {
            $id = $this->pdo->query("SELECT last_insert_rowid()")->fetchColumn();
        }

        return (int) $id;
    }


    public function listar(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM tarefas ORDER BY criado_em DESC');
        return array_map(fn(array $row) => Tarefa::fromArray($row), $stmt->fetchAll());
    }

    public function buscarPorId(int $id): ?Tarefa
    {
        $stmt = $this->pdo->prepare('SELECT * FROM tarefas WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $d = $stmt->fetch();
        return $d ? Tarefa::fromArray($d) : null;
    }

    public function atualizar(int $id, string $titulo, string $descricao, StatusTarefa $status, Prioridade $prioridade): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE tarefas SET titulo=:titulo, descricao=:descricao, status=:status, prioridade=:prioridade WHERE id=:id'
        );
        $stmt->execute([':id' => $id, ':titulo' => $titulo, ':descricao' => $descricao, ':status' => $status->value, ':prioridade' => $prioridade->value]);
        return $stmt->rowCount() > 0;
    }

    public function excluir(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM tarefas WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}