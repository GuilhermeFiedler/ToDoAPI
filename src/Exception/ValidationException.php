<?php
declare(strict_types=1);

namespace Gfiedler\ToDoAPI\Exception;
use InvalidArgumentException;

class ValidationException extends InvalidArgumentException
{
    public function __construct(private readonly array $errors, string $message = 'Dados inválidos')
    {
        parent::__construct($message);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}