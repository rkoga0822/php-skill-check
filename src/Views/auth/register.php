<?php
$title = 'ユーザー登録';
$errors = $errors ?? [];
$old = $old ?? [];
?>

<h2>ユーザー登録</h2>
<form action="/?page=register_store" method="post">
    <label for="name">名前</label>
    <input type="text" name="name" value="<?= e($old['name'] ?? '') ?>"><br>
    <?php if(!empty($errors['name'])): ?>
        <p style="color:red"><?= e($errors['name']) ?></p>
    <?php endif; ?>

    <label for="email">メールアドレス</label>
    <input type="email" name="email" value="<?= e($old['email'] ?? '') ?>"><br>
    <?php if(!empty($errors['email'])): ?>
        <p style="color:red"><?= e($errors['email']) ?></p>
    <?php endif; ?>

    <label for="password">パスワード</label>
    <input type="password" name="password"><br>
    <?php if(!empty($errors['password'])): ?>
        <p style="color:red"><?= e($errors['password']) ?></p>
    <?php endif; ?>

    <button type="submit">登録する</button>
    <a href="/?page=login" class="btn">ログインへ</a>
</form>