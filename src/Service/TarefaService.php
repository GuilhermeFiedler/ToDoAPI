<?php

use Gfiedler\ToDoAPI\Model\Tarefa;
class TarefaService
{
    public function __construct(
        private readonly TarefaRepository $repository
    )
    {
    }

    public function criar(array $dados): array
    {
        $titulo = trim($dados['titulo'] ?? '');
        $descricao = trim($dados['descricao'] ?? '');

        if ($titulo === '') {
            throw new InvalidArgumentException('Titulo é obrigatório');
        }

        if (!ValidatorService::descricao($descricao)) {
            throw new InvalidArgumentException('Descrição inválida');
        }


        $tarefa = new Tarefa(
            id: $dados['id'] ?? 0,
            titulo : $titulo,
            descricao: $descricao,
        );
        $id = $this->repository->criar($tarefa);

        $tarefa = $this->repository->buscarPorId($id);

        return $this->toArray($tarefa);
    }

    public function atualizar(int $id, array $dados): bool
    {
        $titulo = trim($dados['titulo'] ?? '');
        $descricao = trim($dados['descricao'] ?? '');


        if (!ValidatorService::descricao($descricao)) {
            throw new InvalidArgumentException('Descrição inválida');
        }


        $tarefa = new Tarefa(
            titulo : $titulo,
            descricao: $descricao,
        );

        return $this->repository->atualizar($titulo, $descricao, $id);
    }

    public function excluir(int $id): bool
    {
        return $this->repository->excluir($id);
    }

    public function buscar(int $id): ?array
    {
        $tarefa = $this->repository->buscarPorId($id);

        if (!$tarefa) {
            return null;
        }
        return $this->toArray($tarefa);
    }

    public function listar(): array
    {
        $dados = $this->repository->listar();

        $dadosFormatados = array_map(fn (Tarefa $c) => $this->toArray($c), $dados);

        return $dadosFormatados;
    }

    private function toArray(Tarefa $tarefa): array
    {
        return [
            'id' => $tarefa->getId(),
            'nome' => $tarefa->getTitulo(),
            'email' => $tarefa->getDescricao(),
        ];
    }
}