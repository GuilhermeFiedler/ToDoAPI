<?php

declare(strict_types=1);

namespace Gfiedler\ToDoAPI\Service;

use Gfiedler\ToDoAPI\Enum\Prioridade;
use Gfiedler\ToDoAPI\Enum\StatusTarefa;
use Gfiedler\ToDoAPI\Model\Tarefa;
use Gfiedler\ToDoAPI\Repository\TarefaRepository;
use InvalidArgumentException;

class TarefaService
{
    public function __construct(private readonly TarefaRepository $repository)
    {
    }

    public function criar(array $dados): Tarefa
    {
        $titulo = trim($dados['titulo'] ?? '');
        $descricao = trim($dados['descricao'] ?? '');
        $status = StatusTarefa::tryFrom($dados['status'] ?? '') ?? StatusTarefa::Pendente;
        $prioridade = Prioridade::tryFrom($dados['prioridade'] ?? '') ?? Prioridade::Media;
        if ($titulo === '') throw new InvalidArgumentException('Título é obrigatório');
        $id = $this->repository->criar($titulo, $descricao, $status, $prioridade);
        return $this->repository->buscarPorId($id);
    }

    public function atualizar(int $id, array $dados): bool
    {
        $titulo = trim($dados['titulo'] ?? '');
        $descricao = trim($dados['descricao'] ?? '');
        $status = StatusTarefa::tryFrom($dados['status'] ?? '') ?? StatusTarefa::Pendente;
        $prioridade = Prioridade::tryFrom($dados['prioridade'] ?? '') ?? Prioridade::Media;
        if ($titulo === '') throw new InvalidArgumentException('Título é obrigatório');
        return $this->repository->atualizar($id, $titulo, $descricao, $status, $prioridade);
    }

    public function excluir(int $id): bool
    {
        return $this->repository->excluir($id);
    }

    public function buscar(int $id): ?Tarefa
    {
        return $this->repository->buscarPorId($id);
    }

    public function listar(): array
    {
        return $this->repository->listar();
    }
}