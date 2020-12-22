<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
</head>

<body>
  <form action="login_act.php" method="POST">
    <fieldset>
      <legend>ログイン画面</legend>
      <div>
        メールアドレス: <input type="email" name="email">
      </div>
      <div>
        パスワード: <input type="text" name="password">
      </div>
      <div>
        <button>Login</button>
      </div>
      <a href="createuser.php">ユーザー登録画面</a>
    </fieldset>
  </form>

</body>

</html>