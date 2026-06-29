<?php
namespace App\Validators;

class CategoryExistsValidator implements Validator
{
    public function __construct(
        private string $field,
        private array $categoryIds,
        private string $message
    )
    {
    }

    public function validate(array $input): array
    {
        if(($input[$this->field] ?? '') === ''){
            return [];
        }

        if(!in_array((int)$input[$this->field],$this->categoryIds,true)){
            return [$this->field => $this->message];
        }
        return [];
    }
}