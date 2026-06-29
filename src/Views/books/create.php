<?php

/**
 * ★基礎課題: 新規登録フォームのビュー
 *
 * ここに登録フォームを実装してください。要件は README.md の「基礎課題」を参照。
 * 用意されている変数（BookController::create() から渡す想定）:
 *   $categories : カテゴリ一覧（Category::all() の結果）
 *   $errors     : バリデーションエラーの配列（再表示用、任意）
 *   $old        : 直前の入力値の配列（入力値保持用、任意）
 *
 * ヒント:
 *   - <form method="post" action="/?page=store"> で送信する
 *   - <input name="title">, <textarea>, <select name="category_id"> など
 *   - 値の出力は必ず e(...) でエスケープする（XSS 対策）
 *   - エラーがあれば <p class="error"> で表示する
 */
$title = '新規登録';
$categories = $categories ?? [];
$errors = $errors ?? [];
$old = $old ?? [];
?>

<h2>新規書籍登録</h2>
<form action="/?page=store" method="post">
    <label for="title">タイトル</label>
    <input type="text" id="title" name="title" value="<?= e($old['title'] ?? '') ?>"><br>
    <?php if (!empty($errors['title'])): ?>
        <p style="color:red"><?= e($errors['title']) ?></p>
    <?php endif; ?>
    

    <label for="author">著者</label>
    <input type="text" name="author" value="<?= e($old['author'] ?? '') ?>"><br>
    <?php if (!empty($errors['author'])): ?>
        <p style="color:red"><?= e($errors['author']) ?></p>
    <?php endif; ?>

    <label for="category_id">カテゴリ</label>
    <select name="category_id" id="category_id">
        <option value="">選択してください</option>
        <?php foreach($categories as $category): ?>
            <option value="<?= e($category['id']) ?>" <?= (string) ($old['category_id'] ?? '') === (string)$category['id'] ? 'selected' : '' ?>>
                <?= e($category['name']) ?>
            </option>
        <?php endforeach ?>
    </select>
    <br>
    <?php if(!empty($errors['category_id'])): ?>
        <p style="color:red"><?= e($errors['category_id']) ?></p>
    <?php endif ?>

    <label for="price">価格</label>
    <input type="number" name="price" value="<?= e($old['price'] ?? '') ?>" min="0" step="1"><br>
    <?php if(!empty($errors['price'])) : ?>
        <p style="color:red"><?= e($errors['price']) ?></p>
    <?php endif ?>

    <button type="submit">登録する</button>
    <p><a class="btn" href="/">← 一覧へ戻る</a></p>
</form>

