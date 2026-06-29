<?php
namespace App\Controllers;

use App\Models\User;

class AuthController
{
    public function register(): void
    {
        view('auth/register',['errors' => [],'old' =>[]]);
    }

    public function store(): void
    {
        $old = [
            'name' =>trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
        ];
        $password = $_POST['password'] ?? '';
        $errors = [];

        if($old['name'] === ''){
            $errors['name'] = '名前を入力してください'; 
        }

        if($old['email'] === ''){
            $errors['email'] = ' メールアドレスを入力してください';
        }elseif(!filter_var($old['email'],FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'メールアドレスの形式が正しくありません';
        }elseif(User::findByEmail($old['email']) !== null){
            $errors['email'] = 'このメールアドレスは登録済みです';
        }

        if($password !== []){
            view('auth/register',['errors' => $errors,'old' => $old]);
        }

        User::create([
            'name' => $old['name'],
            'email' => $old['email'],
            'password' => password_hash($password,PASSWORD_DEFAULT),
        ]);

        header('Location: /?page=login&registered=1');
        exit;
    }
}