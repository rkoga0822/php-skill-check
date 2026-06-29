<?php

namespace App\Validators;

class NumericMinValidator implements Validator
{
    public function __construct(
        private string $field,
        private int $min,
        private string $message
    )
    {
    }

    public function validate(array $input): array{
        if(($input[$this->field] ?? '') === '' ){
            return [];
        }

        if(!ctype_digit($input[$this->field]) || (int)$input[$this->field] < $this->min){
            return [$this->field => $this->message];
        }

        return [];
    }
}