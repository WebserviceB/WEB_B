<?php
// var_dump($_POST);
// exit();

session_start();
include('functions.php');
check_session_id();


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
  echo "<p>ログイン情報に誤りがあります.</p>";
  echo '<a href="login.php">戻る</a>';
  exit();
} else {
    $_SESSION = array(); 
    $_SESSION["session_id"] = session_id();
    $_SESSION["id"] = $val["id"];
    $_SESSION["name"] = $val["name"];
    $_SESSION["email"] = $val["email"];
    header('Location:shop_list.php'); 
  }
}
