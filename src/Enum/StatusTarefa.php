<?php

enum StatusTarefa: string {
    case Pendente = 'Pendente';
    case EmProgresso = 'Em Progresso';

    case Concluida = 'Concluida';

    public function podeTransicionarPara(
        self $novo
    ): bool {
        return true;
    }

    public function label(): string
    {
        return $this->value;
    }
}