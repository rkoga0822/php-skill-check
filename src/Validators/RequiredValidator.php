<?php

namespace App\Validators;

class RequiredValidator implements Validator
{
    public function __construct(
        private string $field,
        private string $message
    )
    {
    }

    public function validate(array $input): array{
        if(($input[$this->field] ?? '') === '' ){
            return [$this->field => $this->message];
        }

        return [];
    }
}