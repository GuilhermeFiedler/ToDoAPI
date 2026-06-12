<?php

use Gfiedler\ToDoAPI\Model\Tarefa;
class TarefaService
{
    public function __construct(
        private readonly TarefaRepository $repository
    )
    {
    }

    public function criar(array $dados): \Tarefa
    {
        $titulo = trim($dados['titulo'] ?? '');
        $descricao = trim($dados['descricao'] ?? '');

        if ($titulo === '') {
            throw new InvalidArgumentException(
                'Título obrigatório'
            );
        }

        $id = $this->repository->criar(
            $titulo,
            $descricao
        );

        return $this->repository->buscarPorId($id);
    }

    public function atualizar(int $id, array $dados): bool
    {
        $titulo = trim($dados['titulo'] ?? '');
        $descricao = trim($dados['descricao'] ?? '');


        if (!ValidatorService::descricao($descricao)) {
            throw new InvalidArgumentException('Descrição inválida');
        }

        return $this->repository->atualizar($id,$titulo, $descricao);
    }

    public function excluir(int $id): bool
    {
        return $this->repository->excluir($id);
    }

    public function buscar(int $id): \Tarefa
    {
        return $this->repository->buscarPorId($id);
    }

    public function listar(): array
    {
        return $this->repository->listar();
    }

    private function toArray(Tarefa $tarefa): array
    {
        return [
            'id' => $tarefa->getId(),
            'titulo' => $tarefa->getTitulo(),
            'descricao' => $tarefa->getDescricao(),
        ];
    }
}