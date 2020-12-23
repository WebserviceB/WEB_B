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

        <form action="user_check.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="size" value="1000000">
          <p>name:</p><input type="text" name="name" value="" required>
          <p>Email:</p><input type="text" name="email" value="" required>
          <p>password:</p><input type="password" name="password" value="" required>
          <div class="submit">
          <p><input type="submit" value="登録" id="submit"></p>
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