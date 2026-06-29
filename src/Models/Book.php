<?php

namespace App\Models;

use PDO;

/**
 * 書籍モデル。DB アクセス（CRUD）をここに集約します。
 * all() は実装済みの見本です。find/create/update/delete を課題で実装してください。
 */
class Book
{
    /**
     * 書籍を全件取得（カテゴリ名つき）。実装済みの見本。
     * JOIN で categories.name を一緒に取得しています。
     */
    public static function all(): array
    {
        $sql = 'SELECT books.*, categories.name AS category_name
                FROM books
                JOIN categories ON categories.id = books.category_id
                ORDER BY books.id DESC';
        return db()->query($sql)->fetchAll();
    }

    /**
     * ★応用課題: ID で 1 件取得（編集フォームの初期表示などで使う）
     * ヒント: prepare() + execute([$id]) でプレースホルダにバインドし、fetch() で 1 件返す。
     */
    public static function find(int $id): ?array
    {
        // TODO: ここを実装する
        $stmt = db()->prepare('select * from books where id = ?');
        $stmt->execute([$id]);
        $book = $stmt->fetch();

        return $book ?: null;
    }

    /**
     * ★基礎/応用課題: 新規登録
     * ヒント: INSERT 文を prepare() し、execute() に連想配列 or 配列で値を渡す。
     */
    public static function create(array $data): void
    {
        // TODO: ここを実装する
        $sql = 'insert into books (title,author,category_id,price) values (:title,:author,:category_id,:price)';
        $stmt = db()->prepare($sql);
        $stmt->execute([
            'title' => $data['title'],
            'author' => $data['author'],
            'category_id' => $data['category_id'],
            'price' => $data['price'],
        ]);
    }

    /**
     * ★応用課題: 更新
     * ヒント: UPDATE ... WHERE id = ? を prepare()/execute()。
     */
    public static function update(int $id, array $data): void
    {
        // TODO: ここを実装する
        $sql = 'update books set title = :title, author = :author, category_id = :category_id, price = :price where id = :id';
        $stmt = db()->prepare($sql);
        $stmt -> execute([
            'title' => $data['title'],
            'author' => $data['author'],
            'category_id' => $data['category_id'],
            'price' => $data['price'],
            'id' => $id,
        ]);
    }

    /**
     * ★応用課題: 削除
     * ヒント: DELETE FROM books WHERE id = ? を prepare()/execute()。
     */
    public static function delete(int $id): void
    {
        // TODO: ここを実装する
        $stmt = db()->prepare('delete from books where id = ?');
        $stmt -> execute([$id]);
    }
}
