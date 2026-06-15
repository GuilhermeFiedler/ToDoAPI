<?php

declare(strict_types=1);
namespace Gfiedler\ToDoAPI\Model;
use DateTimeImmutable;
use Gfiedler\ToDoAPI\Enum\StatusTarefa;
use Gfiedler\ToDoAPI\Enum\Prioridade;
use InvalidArgumentException;

class Tarefa {

    public function __construct(
        private readonly ?int $id,
        private string $titulo,
        private string $descricao,
        private StatusTarefa $status     = StatusTarefa::Pendente,
        private Prioridade   $prioridade = Prioridade::Media,
        private readonly DateTimeImmutable $criadoEm = new DateTimeImmutable(),
    ) { $this->validar(); }
    private function validar(): void {
        if (trim($this->titulo) === '') throw new InvalidArgumentException('Título é obrigatório');
    }
    public function getId(): ?int                      { return $this->id; }
    public function getTitulo(): string                { return $this->titulo; }
    public function getDescricao(): string             { return $this->descricao; }
    public function getStatus(): StatusTarefa          { return $this->status; }
    public function getPrioridade(): Prioridade        { return $this->prioridade; }
    public function getCriadoEm(): DateTimeImmutable   { return $this->criadoEm; }
    public function setTitulo(string $t): void         { $this->titulo = $t; }
    public function setDescricao(string $d): void      { $this->descricao = $d; }
    public function setStatus(StatusTarefa $s): void   { $this->status = $s; }
    public function setPrioridade(Prioridade $p): void { $this->prioridade = $p; }
    public static function fromArray(array $d): self {
        return new self(
            id:         (int) $d['id'],
            titulo:     $d['titulo'],
            descricao:  $d['descricao'] ?? '',
            status:     StatusTarefa::from($d['status']     ?? StatusTarefa::Pendente->value),
            prioridade: Prioridade::from($d['prioridade']   ?? Prioridade::Media->value),
            criadoEm:   new DateTimeImmutable($d['criado_em'] ?? 'now'),
        );
    }
    public function toArray(): array {
        return [
            'id'         => $this->id,
            'titulo'     => $this->titulo,
            'descricao'  => $this->descricao,
            'status'     => $this->status->value,
            'prioridade' => $this->prioridade->value,
            'criado_em'  => $this->criadoEm->format('Y-m-d H:i:s'),
        ];
    }
}