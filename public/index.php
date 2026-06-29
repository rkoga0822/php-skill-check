<?php

/**
 * フロントコントローラ（簡易ルータ）。
 * ?page=xxx でコントローラのメソッドに振り分けます。
 *
 * 例:
 *   /              → 書籍一覧（実装済みの見本）
 *   /?page=create  → 新規登録フォーム（★基礎課題で実装）
 *   /?page=store   → 登録処理        （★基礎/応用課題で実装）
 *   /?page=edit    → 編集フォーム      （★応用課題で実装）
 *   /?page=update  → 更新処理         （★応用課題で実装）
 *   /?page=delete  → 削除処理         （★応用課題で実装）
 *
 * 新しいページを足すときは、ここに分岐を追加してコントローラのメソッドを呼びます。
 */

require __DIR__ . '/../bootstrap.php';

use App\Controllers\AuthController;
use App\Controllers\BookController;

$page = $_GET['page'] ?? 'index';
$controller = new BookController();
$authController = new AuthController();

switch ($page) {
    case 'index':
        $controller->index();
        break;

    // ▼▼▼ ここから下は課題で実装します（コントローラ側の TODO を埋める）▼▼▼
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'update':
        $controller->update();
        break;
    case 'delete':
        $controller->delete();
        break;
    case 'register':
        $authController->register();
        break;
    case 'register_store':
        $authController->store();
        break;
    case 'login':
        $authController->login();
        break;
    case 'authenticate':
        $authController->authenticate();
        break;
    case 'logout':
        $authController->logout();
        break;
    // ▲▲▲ ここまで ▲▲▲

    default:
        http_response_code(404);
        echo 'Not Found';
}
