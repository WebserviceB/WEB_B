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



// if (
//   !isset($_POST['name']) || $_POST['name'] == '' ||
//   !isset($_POST['email']) || $_POST['email'] == '' ||
//   !isset($_POST['password']) || $_POST['password'] == '' 
// ) {
//   // 項目が入力されていない場合はここでエラーを出力し，以降の処理を中止する
//   echo json_encode(["error_msg" => "no input"]);
//   exit();
// }

// // 受け取ったデータを変数に入れる
// $name = $_POST['name'];
// $email = $_POST['email'];
// $password = $_POST['password'];

// // DB接続の設定
// // DB名は`gsacf_x00_00`にする
// include('functions.php');
// $pdo = connect_to_db();

// // データ登録SQL作成
// // `created_at`と`updated_at`には実行時の`sysdate()`関数を用いて実行時の日時を入力する
// $sql = 'INSERT INTO user(id, name, email ,password, created) VALUES(NULL, :name, :email , :password, sysdate())';

// // SQL準備&実行
// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(':name', $name, PDO::PARAM_STR);
// $stmt->bindValue(':email', $email, PDO::PARAM_STR);
// $stmt->bindValue(':password', $password, PDO::PARAM_STR);
// $status = $stmt->execute();

// // データ登録処理後
// if ($status == false) {
//   // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
//   $error = $stmt->errorInfo();
//   echo json_encode(["error_msg" => "{$error[2]}"]);
//   exit();
// } else {
//   // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
//   header("Location:createuser_success.php");
//   exit();
// }







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