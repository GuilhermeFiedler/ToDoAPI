<?php


class TarefaRepository {
    public function __construct(
        private readonly PDO $pdo
    ) {}

    // CREATE
    public function criar(string $titulo, string $descricao): int {
        $stmt = $this->pdo->prepare(
            'INSERT INTO tarefas (titulo, descricao, criado_em) 
             VALUES (:titulo, :descricao, NOW())'
        );
        $stmt->execute([
            ':titulo'       => $titulo,
            ':descricao'      => $descricao
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    // READ
    public function listar(): ?array {
        $stmt = $this->pdo->prepare(
            'SELECT id, titulo, descricao, criado_em FROM tarefas ORDER BY criado_em DESC'
        );
        $stmt->execute();
        return $stmt->fetch() ?: null;
    }


    // READ por id
    public function buscarPorId(int $id): ?array {
        $stmt = $this->pdo->prepare(
            'SELECT id, titulo, descricao, criado_em $ FROM tarefas WHERE id = :id'
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
    }

    // UPDATE
    public function atualizar(int $id, string $titulo, string $descricao): bool {
        $stmt = $this->pdo->prepare(
            'UPDATE tarefas SET titulo = :titulo, descricao = :descricao WHERE id = :id'
        );
        $stmt->execute([':id' => $id, ':titulo' => $titulo, ':descricao' => $descricao]);
        return $stmt->rowCount() > 0;
    }

    // DELETE
    public function excluir(int $id): bool {
        $stmt = $this->pdo->prepare('DELETE FROM tarefas WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}