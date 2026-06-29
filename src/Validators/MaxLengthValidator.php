<?php

namespace App\Validators;

class MaxLengthValidator implements Validator
{
     public function __construct(
        private string $field,
        private int $max,
        private string $message
    )
    {
    }

    public function validate(array $input): array{
        if(($input[$this->field] ?? '') !== '' && mb_strlen($input[$this->field])>$this->max){
            return [$this->field => $this->message];
        }

        return [];
    }

}