<?php
declare(strict_types=1);
namespace Gfiedler\ToDoAPI\Enum;
enum Prioridade: string {
    case Baixa = 'Baixa';
    case Media = 'Media';
    Case Alta = 'Alta';
    case Urgente = 'Urgente';
}