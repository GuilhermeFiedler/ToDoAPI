<?php

namespace Gfiedler\ToDoAPI\Model;
class Tarefa {
    const int TITULO_MAX_LENGTH = 200;
    const int DESCRICAO_MAX_LENGTH = 2000;

    public function __construct(
        private readonly ?int $id,
        private string $titulo,
        private string $descricao,
        private StatusTarefa $status = StatusTarefa::Pendente,
        private Prioridade $prioridade = Prioridade::Media,
        private readonly DateTimeImmutable $criado_em = new DateTimeImmutable(),
    ) {
        $this->validar();
    }

    private function validar(): void {
        if (empty(trim($this->titulo))) {
            throw new InvalidArgumentException('Título não pode ser vazio.');
        }
        if (mb_strlen($this->titulo) > self::TITULO_MAX_LENGTH) {
            throw new InvalidArgumentException(
                "Título excede " . self::TITULO_MAX_LENGTH . " caracteres."
            );
        }
        if (empty(trim($this->descricao))) {
            throw new InvalidArgumentException('Descrição não pode ser vazia.');
        }
        if (mb_strlen($this->descricao) > self::DESCRICAO_MAX_LENGTH) {
            throw new InvalidArgumentException(
                "Descrição excede " . self::DESCRICAO_MAX_LENGTH . " caracteres."
            );
        }
    }
    public function atualizarStatus(StatusTarefa $novo): void {
        if (!$this->status->podeTransicionarPara($novo)) {
            throw new DomainException(
                "Não é possível mudar de {$this->status->label()} para {$novo->label()}"
            );
        }
        $this->status = $novo;
    }

    public function toArray(): array {
        return [
            'id'         => $this->id,
            'titulo'     => $this->titulo,
            'descricao'  => $this->descricao,
            'status'     => $this->status->value,
            'prioridade' => $this->prioridade->value,
            'criado_em'  => $this->criado_em->format('c'),
        ];
    }
}