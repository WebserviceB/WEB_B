<?php
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];


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
          <p>name:</p><input type="hidden" name="name" value="<?= $name ?>">
          <p><?= $name ?></p>
          <p>Email:</p><input type="hidden" name="email" value="<?= $email ?>">
          <p><?= $email ?></p>
          <p>password:</p><input type="hidden" name="password" value="<?= $password ?>">
          <p>パスワードは表示されません。</p>

          <div class="submit">
            <p><input type="submit" value="登録" id="submit"></p>
            <p><a href="user.php">戻る</a></p>
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