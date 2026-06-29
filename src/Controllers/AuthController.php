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

    public function login(): void
    {
        view('auth/login',['errors' => [],'old' => []]);
    }

    public function authenticate(): void
    {
        $old = [
            'email' => trim($_POST['email'] ?? ''),
        ];
        $password = $_POST['password'] ?? '';
        $errors = [];

        if($old['email'] === ''){
            $errors['email'] = 'メールアドレスを入力してください';
        }

        if($old['password'] === ''){
            $errors['password'] = 'パスワードを入力してください';
        }

        $user = $old['email'] !== '' ? User::findByEmail($old['email']) : null;
        if($errors === [] && ($user === null || !password_verify($password,$user['password']))){
            $errors['login'] = 'メールアドレスまたはパスワードが正しくありません';
        }

        if($errors !== []){
            view('auth/login',['errors' => $errors,'old' => $old]);
            return;
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        header('Location: /');
        exit;
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();

        header('Location: /?page=login&logged_out=1');
        exit;
    }
    
}