<?php
declare(strict_types=1);
class ValidatorService
{
    public static function descricao(
        string $descricao
    ): bool {
        return mb_strlen(
                trim($descricao)
            ) > 0;
    }
}