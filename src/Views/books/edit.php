<?php
/**
 * ★応用課題: 編集フォームのビュー
 *
 * 既存の値をフォームに初期表示し、/?page=update へ送信して更新します。
 * 用意されている変数（BookController::edit() から渡す想定）:
 *   $book       : 編集対象の書籍（Book::find($id) の結果）
 *   $categories : カテゴリ一覧
 *   $errors     : バリデーションエラー（任意）
 *
 * ヒント:
 *   - <form method="post" action="/?page=update"> に <input type="hidden" name="id" value="...">
 *   - 既存値を value= に入れて初期表示（必ず e(...) でエスケープ）
 */
$title = '編集';
$categories = $categories ?? [];
$errors = $errors ?? [];
$old = $old ?? [];

$form = [
    'title' => $old['title'] ?? $book['title'] ?? '',
    'author' => $old['author'] ?? $book['author'] ?? '',
    'category_id' => $old['category_id'] ?? $book['category_id'] ?? '',
    'price' => $old['price'] ?? $book['price'] ?? '',
];
?>

<h2>書籍の編集</h2>
<form action="/?page=update" method="post">
    <input type="hidden" name="id" value="<?= e($book['id'] ?? '') ?>">

    <label for="title">タイトル</label>
    <input type="text" id="title" name="title" value="<?= e($form['title']) ?>"><br>
    <?php if (!empty($errors['title'])): ?>
        <p style="color:red"><?= e($errors['title']) ?></p>
    <?php endif; ?>
    

    <label for="author">著者</label>
    <input type="text" name="author" value="<?= e($form['author']) ?>"><br>
    <?php if (!empty($errors['author'])): ?>
        <p style="color:red"><?= e($errors['author']) ?></p>
    <?php endif; ?>

    <label for="category_id">カテゴリ</label>
    <select name="category_id" id="category_id">
        <option value="">選択してください</option>
        <?php foreach($categories as $category): ?>
            <option value="<?= e($category['id']) ?>" <?= (string) $form['category_id'] === (string)$category['id'] ? 'selected' : '' ?>>
                <?= e($category['name']) ?>
            </option>
        <?php endforeach ?>
    </select>
    <br>
    <?php if(!empty($errors['category_id'])): ?>
        <p style="color:red"><?= e($errors['category_id']) ?></p>
    <?php endif ?>

    <label for="price">価格</label>
    <input type="number" name="price" value="<?= e($form['price']) ?>" min="0" step="1"><br>
    <?php if(!empty($errors['price'])) : ?>
        <p style="color:red"><?= e($errors['price']) ?></p>
    <?php endif ?>

    <button type="submit">更新する</button>
    <p><a class="btn" href="/">← 一覧へ戻る</a></p>
</form>
