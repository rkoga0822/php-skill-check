<?php

namespace App\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Validators\BookValidator;

class BookController
{
    public function index(): void
    {
        $books = Book::all();
        view('books/index', ['books' => $books]);
    }


    public function create(): void
    {
        require_login();

        $categories = Category::all();
        view('books/create', ['categories' => $categories, 'errors' => [], 'old' => []]);
    }

    public function store(): void
    {
        require_login();

        $categories = Category::all();
        $categoryIds = array_map('intval', array_column($categories, 'id'));
        $old = [
            'title' => trim($_POST['title'] ?? ''),
            'author' => trim($_POST['author'] ?? ''),
            'category_id' => trim($_POST['category_id'] ?? ''),
            'price' => trim($_POST['price'] ?? ''),
        ];
        $errors = (new BookValidator($categoryIds))->validate($old);

        if ($errors !== []) {
            view('books/create', [
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

    public function edit(): void
    {
        require_login();

        $id = $_GET['id'] ?? '';

        //idが数字じゃないなら
        if (!ctype_digit($id)) {
            http_response_code(404);
            echo 'Book Not Found';
            return;
        }

        $book = Book::find((int) $id);

        //DBに存在しないなら
        if ($book === null) {
            http_response_code(404);
            echo 'Book Not Found';
            return;
        }

        view('books/edit', [
            'book' => $book,
            'categories' => Category::all(),
            'errors' => [],
            'old' => []
        ]);
    }

    public function update(): void
    {
        require_login();

        $id = $_POST['id'] ?? '';

        if (!ctype_digit($id)) {
            http_response_code(404);
            echo 'Book Not Found';
            return;
        }

        $book = Book::find((int) $id);

        if ($book === null) {
            http_response_code(404);
            echo 'Book Not Found';
            return;
        }

        $categories = Category::all();
        $categoryIds = array_map('intval', array_column($categories, 'id'));
        $old = [
            'title' => trim($_POST['title'] ?? ''),
            'author' => trim($_POST['author'] ?? ''),
            'category_id' => trim($_POST['category_id'] ?? ''),
            'price' => trim($_POST['price'] ?? ''),
        ];

        $errors = (new BookValidator($categoryIds))->validate($old);


        if ($errors !== []) {
            view('books/edit', [
                'book' => $book,
                'categories' => $categories,
                'errors' => $errors,
                'old' => $old,
            ]);
            return;
        }

        Book::update((int)$id, [
            'title' => $old['title'],
            'author' => $old['author'],
            'category_id' => (int)$old['category_id'],
            'price' => (int)$old['price'],
        ]);

        header('Location: /?page=index&updated=1');
        exit;
    }

    public function delete(): void
    {
        require_login();
        
        $id = $_POST['id'] ?? '';

        if (!ctype_digit($id)) {
            http_response_code(404);
            echo 'Book Not Found';
            return;
        }

        $book = Book::find((int) $id);

        if ($book === null) {
            http_response_code(404);
            echo 'Book Not Found';
            return;
        }

        Book::delete((int) $id);
        header('Location: /?page=index&deleted=1');
    }
}
