<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include('../functions.php');

//$_POSTがから出ない時の処理
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

    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
  } else {
    $val = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$val) {
      $error = "入力内容が間違っています。";
    } else {
      $_SESSION = array();
      $_SESSION["session_id"] = session_id();
      $_SESSION["id"] = $val["id"];
      $_SESSION["name"] = $val["name"];
      $_SESSION["email"] = $val["email"];
      header('Location:../top/top.php');
    }
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="login.css">
  <title>ログイン</title>
</head>

<div class="top_logo"><a href="../top/top.php"><img src="../image/ramenman.jpg" alt="">top</a></div>

<body>
  <section class="user_create">
    <div class="user_form">
      <div class="form">
        <form action="" method="post" enctype="multipart/form-data">
          <input type="hidden" name="size" value="1000000">
          <p>Email:</p><input type="text" name="email" value="" required>
          <p>password:</p><input type="password" name="password" value="" required>

          <p class="error"><?= $error ?></p>

          <div class="submit">
            <p><input type="submit" value="ログイン" id="submit"></p>
        </form>
        <div class="login">
          <p><a href="user.php">会員登録はこちらから</a></p>
        </div>
      </div>
    </div>
  </section>

</body>

</html>