<?php

namespace App\Controllers;

use App\Models\Book;
use App\Models\Category;

/**
 * 書籍コントローラ。リクエストを受けて Model を呼び、View を描画します。
 * index() は実装済みの見本です。残りのメソッドを課題で実装してください。
 */
class BookController
{
    /** 一覧表示（実装済みの見本） */
    public function index(): void
    {
        $books = Book::all();
        view('books/index', ['books' => $books]);
    }

    /**
     * ★基礎課題: 新規登録フォームの表示
     * ヒント: Category::all() を取得して view('books/create', [...]) を描画する。
     *        バリデーションエラーや入力値を ?page=store からのリダイレクトで
     *        受け取り、フォームに再表示できるようにする（$_GET 経由など）。
     */
    public function create(): void
    {
        // TODO: ここを実装する（下の仮表示を本実装に置き換える）
        //   $categories = Category::all();
        //   view('books/create', ['categories' => $categories, 'errors' => [], 'old' => []]);
        $categories = Category::all();
        view('books/create',['categories' => $categories,'errors' => [], 'old'=>[]]); // 仮表示（実装前の白画面防止。実装時に上記へ置き換える）
    }

    /**
     * ★基礎/応用課題: 登録処理（POST）
     * ヒント:
     *   - $_POST から値を受け取り trim()
     *   - 必須・文字数などをバリデーション（エラーは配列に貯める）
     *   - エラーがあれば create に戻す（PRG パターン: header('Location: ...'); exit;）
     *   - OK なら Book::create() して一覧へリダイレクト
     */
    public function store(): void
    {
        // TODO: ここを実装する
        $categories = Category::all();
        $categoryId = array_map('intval',array_column($categories,'id'));
        $old = [
            'title' => trim($_POST['title'] ?? ''),
            'author' => trim($_POST['author'] ?? ''),
            'category_id' => trim($_POST['category_id'] ?? ''),
            'price' => trim($_POST['price'] ?? ''),
        ];
        $errors = [];

        if($old['title'] === ''){
            $errors['title'] = 'タイトルを入力してください';
        }elseif(mb_strlen($old['title'])>100){
            $errors['title'] = 'タイトルは１００文字以内で入力してください';
        }

        if($old['author'] === ''){
            $errors['author'] = '著者を入力してください';
        }

        if($old['category_id'] === ''){
            $errors['category_id'] = 'カテゴリを選択してください';
        }

        if($old['price'] === ''){
            $errors['price'] = '価格を入力してください';
        }elseif(!ctype_digit($old['price'])){
            $errors['price'] = '価格は０以上の数値で入力してください';
        }

        if($errors !== []){
            view('books/create',[
                'categories' => $categories,
                'errors' => $errors,
                'old' => $old,
            ]);
            return;
        }

        Book::create([
            'title' => $old['title'],
            'author' => $old['author'],
            'category_id' => $old['category_id'],
            'price' => $old['price'],
        ]);

        header('Location: /?page=index&created=1');
        exit;
    }

    /** ★応用課題: 編集フォームの表示（?page=edit&id=...） */
    public function edit(): void
    {
        // TODO: ここを実装する（下の仮表示を本実装に置き換える）
        //   $book = Book::find($_GET['id'] ?? null);
        //   view('books/edit', ['book' => $book, 'categories' => Category::all(), 'errors' => []]);
        $id = $_GET['id'] ?? '';

        //idが数字じゃないなら
        if(!ctype_digit($id)){
            http_response_code(404);
            echo 'Book Not Found';
            return;
        }

        $book = Book::find((int) $id);

        //DBに存在しないなら
        if($book === null){
            http_response_code(404);
            echo 'Book Not Found';
            return;
        }

        view('books/edit',[
            'book' => $book,
            'categories' => Category::all(),
            'errors' => [],
            'old' => []
        ]); 
    }

    /** ★応用課題: 更新処理（POST） */
    public function update(): void
    {
        // TODO: ここを実装する
        $id = $_POST['id'] ?? '';

        if(!ctype_digit($id)){
            http_response_code(404);
            echo 'Book Not Found';
            return;
        }

        $book = Book::find((int) $id);

        if($book === null){
            http_response_code(404);
            echo 'Book Not Found';
            return;
        }

        $categories = Category::all();
        $categoryIds = array_map('intval',array_column($categories,'id'));
        $old = [
            'title' => trim($_POST['title'] ?? ''),
            'author' => trim($_POST['author'] ?? ''),
            'category_id' => trim($_POST['category_id'] ?? ''),
            'price' => trim($_POST['price'] ?? ''),
        ];

        $errors = [];

        if($old['title'] === ''){
            $errors['title'] = 'タイトルを入力してください';
        }elseif(mb_strlen($old['title']) > 100){
            $errors['title'] = 'タイトルは１００文字以内で入力してください';
        }

        if($old['author'] === ''){
            $errors['author'] = '著者を入力してください';
        }

        if($old['category_id'] === ''){
            $errors['category_id'] = 'カテゴリを選択してください';
        }

        if($old['price'] === ''){
            $errors['price'] = '価格を入力してください';
        }elseif(!ctype_digit($old['price'])){
            $errors['price'] = '価格は０以上の数値で入力してください';
        }


        if($errors !== []){
            view('books/edit',[
                'book' => $book,
                'categories' => $categories,
                'errors' => $errors,
                'old' => $old,
            ]);
            return;
        }

        Book::update((int)$id,[
            'title' =>$old['title'],
            'author' => $old['author'],
            'category_id' => (int)$old['category_id'],
            'price' => (int)$old['price'],
        ]);

        header('Location: /?page=index&updated=1');
        exit;
    }

    /** ★応用課題: 削除処理 */
    public function delete(): void
    {
        // TODO: ここを実装する
        $id = $_POST['id'] ?? '';

        if(!ctype_digit($id)){
            http_response_code(404);
            echo 'Book Not Found';
            return;
        }

        $book = Book::find((int) $id);

        if($book === null){
            http_response_code(404);
            echo 'Book Not Found';
            return;
        }

        Book::delete((int) $id);
        header('Location: /?page=index&deleted=1');
    }
}
