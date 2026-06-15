<?php
declare(strict_types=1);

namespace Repository;

use Gfiedler\ToDoAPI\Model\Tarefa;
use Gfiedler\ToDoAPI\Repository\TarefaRepository;
use PHPUnit\Framework\TestCase;

class TarefaRepositoryTest extends TestCase
{
    private TarefaRepository $repository;

    protected function setUp(): void
    {
        $pdo = new \PDO('sqlite::memory:');
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        $pdo->exec("CREATE TABLE tarefas (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            titulo TEXT NOT NULL,
            descricao TEXT,
            status TEXT NOT NULL DEFAULT 'Pendente',
            prioridade TEXT NOT NULL DEFAULT 'Media',
            criado_em TEXT NOT NULL DEFAULT (datetime('now'))
        )");
        $this->repository = new TarefaRepository($pdo);
    }

    public function testCriarEBuscarPorId(): void
    {
        $id = $this->repository->criar('Título', 'Descrição');
        $this->assertGreaterThan(0, $id);
        $tarefa = $this->repository->buscarPorId($id);
        $this->assertInstanceOf(Tarefa::class, $tarefa);
        $this->assertEquals('Título', $tarefa->getTitulo());
    }

    public function testBuscarIdInexistenteRetornaNull(): void
    {
        $this->assertNull($this->repository->buscarPorId(99999));
    }

    public function testListar(): void
    {
        $this->repository->criar('T1', 'D1');
        $this->repository->criar('T2', 'D2');
        $this->assertCount(2, $this->repository->listar());
    }
}