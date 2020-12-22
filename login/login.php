<?php

session_start();
error_reporting(E_ALL & ~E_NOTICE);
include('../functions.php');


if (!empty($_POST)) {

  $email = $_POST['email'];
  $password = $_POST['password'];

  $pdo = connect_to_db();

  $sql = 'SELECT * FROM user WHERE email=:email AND password=:password';

  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':email', $email, PDO::PARAM_STR);
  $stmt->bindValue(':password', $password, PDO::PARAM_STR);
  $status = $stmt->execute();

  if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
  } else {
    $val = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$val) { // 該当データがないときはログインページへのリンクを表示
      // echo "<p>ログイン情報に誤りがあります.</p>";
      $error = "入力内容が間違っています。";
      // echo '<a href="login.php">戻る</a>';
      // exit();
    } else {
      $_SESSION = array();
      $_SESSION["session_id"] = session_id();
      $_SESSION["id"] = $val["id"];
      $_SESSION["name"] = $val["name"];
      $_SESSION["email"] = $val["email"];
      header('Location:shop_list.php');
    }
  }
}



?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
</head>

<body>
  <form action="" method="POST">
    <fieldset>
      <legend>ログイン画面</legend>
      <div>
        メールアドレス: <input type="email" name="email" required>
      </div>
      <div>
        パスワード: <input type="text" name="password" required>
      </div>
      <p class="error"><?= $error ?></p>
      <div>
        <button>Login</button>
      </div>
      <a href="createuser.php">ユーザー登録画面</a>
    </fieldset>
  </form>
</body>

</html>