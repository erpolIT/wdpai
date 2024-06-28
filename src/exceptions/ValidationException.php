<?php

namespace exceptions;

use Exception;

class ValidationException extends \Exception
{
    protected array $errors;

    public function __construct(array $errors, $message = "Validation errors occurred", $code = 422, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public function getErrors(): array {
        return $this->errors;
    }
}