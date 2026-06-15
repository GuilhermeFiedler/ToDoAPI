<?php
declare(strict_types=1);
namespace Gfiedler\ToDoAPI\Enum;
enum StatusTarefa: string {
    case Pendente = 'Pendente';
    case EmProgresso = 'Em Progresso';

    case Concluida = 'Concluida';

    public function podeTransicionarPara(self $novo): bool {
        return match ($this) {
            self::Pendente    => $novo === self::EmProgresso,
            self::EmProgresso => $novo === self::Concluida,
            self::Concluida   => false,
        };
    }

    public function label(): string
    {
        return $this->value;
    }
}