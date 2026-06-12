<?php

namespace Gfiedler\ToDoAPI\Model;
use Prioridade;
use StatusTarefa;

class Tarefa {
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getStatus(): StatusTarefa
    {
        return $this->status;
    }

    public function getPrioridade(): Prioridade
    {
        return $this->prioridade;
    }

    public function getCriadoEm(): DateTimeImmutable
    {
        return $this->criado_em;
    }
    public function __construct(
        private readonly ?int $id,
        private string $titulo,
        private string $descricao,
        private StatusTarefa $status = StatusTarefa::Pendente,
        private Prioridade $prioridade = Prioridade::Media,
        private readonly DateTimeImmutable $criadoEm = new DateTimeImmutable(),
    ) {
        $this->validar();
    }
    public static function toArray(array $dados): self
    {
        return new self(
            id: (int)$dados['id'],
            titulo: $dados['titulo'],
            descricao: $dados['descricao'],
            status: StatusTarefa::from(
                $dados['status'] ?? StatusTarefa::Pendente->value
            ),
            prioridade: Prioridade::from(
                $dados['prioridade'] ?? Prioridade::Media->value
            ),
            criadoEm: new DateTimeImmutable(
                $dados['criado_em']
            )
        );
    }
}