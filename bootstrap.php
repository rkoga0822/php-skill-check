<?php

/**
 * 簡易オートローダ（PSR-4 相当）と共通読み込み。
 * App\Foo\Bar  ->  src/Foo/Bar.php に対応させる。
 * （「オブジェクト指向を学ぼう」で扱った namespace + オートローディングの最小版。
 *   composer がある場合は `composer dump-autoload` でも可。）
 */
session_start();
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }
    $relative = substr($class, strlen($prefix));
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $relative) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

require __DIR__ . '/config/db.php';

/**
 * ビューを描画する小さなヘルパー。
 * 指定したビューの出力を $content に詰めて layout.php で包んで表示する。
 */
function view(string $name, array $data = [], string $title = '書籍管理'): void
{
    extract($data);
    ob_start();
    require __DIR__ . '/src/Views/' . $name . '.php';
    $content = ob_get_clean();
    require __DIR__ . '/src/Views/layout.php';
}

/** 安全に出力するためのエスケープ（XSS 対策） */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// ログイン中かどうか判断
function is_logged_in(): bool
{
    return isset($_SESSION['user_id']);
}

//　未ログインならログイン画面に移動させる
function require_login(): void
{
    if(!is_logged_in()){
        header('Location: /?page=login');
        exit;
    }
}
