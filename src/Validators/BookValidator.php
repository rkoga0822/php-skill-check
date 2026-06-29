<?php
namespace App\Validators;

class BookValidator implements Validator
{
    
    private array $validators;
    
    public function __construct(array $categoryIds)
    {
        $this->validators = [
            new RequiredValidator('title','タイトルを入力してください'),
            new MaxLengthValidator('title',100,'タイトルは１００文字以内で入力してください'),
            new RequiredValidator('author','著者を入力してください'),
            new RequiredValidator('category_id','カテゴリを選択してください'),
            new CategoryExistsValidator('category_id',$categoryIds,'正しいカテゴリを選択してください'),
            new RequiredValidator('price','価格を入力してください'),
            new NumericMinValidator('price',0,'価格は０以上の数値で入力してください'),
        ];
    }

    public function validate(array $input): array
    {
        $errors = [];

        foreach($this->validators as $validator){
            $errors += $validator->validate($input);
        }

        return $errors;
    }
    
}