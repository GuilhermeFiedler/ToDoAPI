<?php

namespace Gfiedler\ToDoAPI\Exception;
use RuntimeException;

class NotFoundException extends RuntimeException
{
    public function __construct(
        string $message = 'Recurso não encontrado', int $code = 404
    )
    {
        parent::__construct($message, $code);
    }
}
