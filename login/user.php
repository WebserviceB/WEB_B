<?php

error_reporting(E_ALL & ~E_NOTICE);

if (!empty($_POST)) {
  if ($_POST['name'] === '') {
    $error['name'] = 'blank';
  }
  if ($_POST['email'] === '') {
    $error['email'] = 'blank';
  }
  if (strlen($_POST['password']) < 4) {
    $error['password'] = 'length';
  }
  if ($_POST['password'] === '') {
    $error['password'] = 'blank';
  }
}







?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="user.css">
</head>

<body>

  <section class="user_create">
    <div class="user_form">
      <div class="form">

        <form action="createuser_act.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="size" value="1000000">
          <p>name:</p>
          <input type="text" name="name" value="<?php echo (htmlspecialchars($_POST['name'], ENT_QUOTES)); ?>">
          <?php if ($error['name'] === 'blank') : ?>
            <p class="error">* 名前を入力してください</p>
          <?php endif; ?>
          <p>Email:</p><input type="text" name="email" value="<?php echo (htmlspecialchars($_POST['email'], ENT_QUOTES)); ?>">
          <?php if ($error['email'] === 'blank') : ?>
            <p class="error">* メールアドレスを入力してください</p>
          <?php endif; ?>
          <?php if ($error['email'] === 'duplicate') : ?>
            <p class="error">* 登録済みです</p>
          <?php endif; ?>

          <p>password:</p><input type="password" name="password" value="<?php echo (htmlspecialchars($_POST['password'], ENT_QUOTES)); ?>">
          <?php if ($error['password'] === 'blank') : ?>
            <p class="error">* パスワードを入力してください</p>
          <?php endif; ?>
          <?php if ($error['password'] === 'length') : ?>
            <p class="error">* 4文字以上で入力してください</p>
          <?php endif; ?>

          <div class="submit">
            <p>
              <input type="submit" value="登録" id="submit">
            </p>
        </form>
        <div class="login">
          <p><a href="login.php">ログインはこちらから</a></p>

        </div>
      </div>

    </div>
    </div>


  </section>



</body>

</html>