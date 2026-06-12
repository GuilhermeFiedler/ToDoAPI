<?php


class TarefaRepository {
    public function __construct(
        private readonly PDO $pdo
    ) {}

    // CREATE
    public function criar(
        string $titulo,
        string $descricao
    ): int {
        $stmt = $this->pdo->prepare(
            'INSERT INTO tarefas
        (
            titulo,
            descricao,
            criado_em
        )
        VALUES
        (
            :titulo,
            :descricao,
            NOW()
        )
        RETURNING id'
        );
        $stmt->execute([
            ':titulo' => $titulo,
            ':descricao' => $descricao
        ]);
        return (int)$stmt->fetchColumn();
    }

    // READ
    public function listar(): array
    {
        $stmt = $this->pdo->query(
            'SELECT * FROM tarefas
         ORDER BY criado_em DESC'
        );

        $dados = $stmt->fetchAll();

        return array_map(
            fn(array $row) => Tarefa::fromArray($row),
            $dados
        );
    }


    // READ por id
    public function buscarPorId(int $id): ?Tarefa
    {$stmt = $this->pdo->prepare(
     'SELECT * FROM tarefas WHERE id = :id'
        );
        $stmt->execute([
            ':id' => $id
        ]);
        $dados = $stmt->fetch();
        if (!$dados) {
            return null;
        }
        return Tarefa::fromArray($dados);
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