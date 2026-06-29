<?php
$title = 'ログイン';
$errors = $errors ?? [];
$old = $old ?? [];
?>

<?php if (!empty($_GET['registerd'])): ?>
    <p class="flash">ユーザー登録が完了しました。ログインしてください</p>
<?php endif; ?>
<?php if (!empty($_GET['logged_out'])): ?>
    <p class="flash">ログアウトしました</p>
<?php endif; ?>

<h2>ログイン</h2>
<?php if (!empty($errors['login'])): ?>
    <p><?= e($errors['login']) ?></p>
<?php endif; ?>

<form action="/?page=authenticate" method="post">
    <label for="email">メールアドレス</label>
    <input type="email" name="email" value="<?= e($old['email'] ?? '') ?>"><br>
    <?php if (!empty($errors['email'])): ?>
        <p><?= e($errors['email']) ?></p>
    <?php endif; ?>

    <label for="password">パスワード</label>
    <input type="password" name="password" value="<?= e($old['password'] ?? '') ?>"><br>
    <?php if (!empty($errors['password'])): ?>
        <p><?= e($errors['password']) ?></p>
    <?php endif; ?>

    <button type="submit">ログインする</button>
    <a href="/?page=register" class="btn">ユーザー登録へ</a>

</form>