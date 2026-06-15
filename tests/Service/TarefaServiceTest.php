<?php
declare(strict_types=1);

namespace Service;

use Gfiedler\ToDoAPI\Model\Tarefa;
use Gfiedler\ToDoAPI\Repository\TarefaRepository;
use Gfiedler\ToDoAPI\Service\TarefaService;
use PHPUnit\Framework\TestCase;

class TarefaServiceTest extends TestCase
{
    public function testCriarComSucesso(): void
    {
        $repo = $this->createMock(TarefaRepository::class);
        $repo->method('criar')->willReturn(1);
        $repo->method('buscarPorId')->willReturn(new Tarefa(1, 'Teste', 'Descrição'));
        $tarefa = (new TarefaService($repo))->criar(['titulo' => 'Teste', 'descricao' => 'Descrição']);
        $this->assertInstanceOf(Tarefa::class, $tarefa);
        $this->assertEquals(1, $tarefa->getId());
    }

    public function testCriarSemTituloLancaExcecao(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new TarefaService($this->createMock(TarefaRepository::class)))->criar(['titulo' => '']);
    }

    public function testListar(): void
    {
        $repo = $this->createMock(TarefaRepository::class);
        $repo->method('listar')->willReturn([new Tarefa(1, 'T1', 'D1'), new Tarefa(2, 'T2', 'D2')]);
        $this->assertCount(2, (new TarefaService($repo))->listar());
    }

    public function testExcluir(): void
    {
        $repo = $this->createMock(TarefaRepository::class);
        $repo->method('excluir')->willReturn(true);
        $this->assertTrue((new TarefaService($repo))->excluir(1));
    }
}