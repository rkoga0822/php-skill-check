<?php
namespace App\Models;

class User
{
    public static function create(array $data): void
    {
        $sql = 'insert into users (name,email,password) values (:name,:email,:password)';
        $stmt = db()->prepare($sql);
        $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }

    public static function findByEmail(string $email): ?array
    {
        $stmt = db()->prepare('select * from users where email = ?');
        $stmt -> execute([$email]);
        $user = $stmt -> fetch();

        return $user ?: null;
    }
}