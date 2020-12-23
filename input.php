<?php
try {
    $db = new PDO('mysql:dbname=web-b;host=localhost;charset=utf8', 'root', '');
} catch (PDOException $e) {
    print('接続エラー' . $e->getMessage());
}
if (isset($_POST['name'])) {
    $img = date('YmdHis') . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], 'image/' . $img);
    $image = htmlspecialchars('image/' . $img, ENT_QUOTES);
    var_dump($_POST);
    exit();
    if ($_POST['name'] !== '' || $_POST['place'] !== '') {
        $message = $db->prepare('INSERT INTO shop SET id=?,name=?,tell=?,place=?,info=?,start=?,end=?,budget=?,img=?');
        $message->execute(array(NULL, $_POST['name'], $_POST['tell'], $_POST['place'], $_POST['info'], $_POST['start'], $_POST['end'], $_POST['budget'], $image));
        echo "{$_POST['name']}登録完了！";
    } else {
        echo ('失敗');
    }
} else {
};
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>店舗情報登録ページ</title>
    <style>
        body {
            padding: 1rem 3rem;
        }

        input {
            width: 500px;
            height: 40px;
            line-height: 40px;
            font-size: 30px;
            margin-bottom: 0.5rem;
        }

        .img {
            font-size: 20px;
        }

        button {
            height: 100px;
            width: 500px;
            font-size: 3rem;
        }
    </style>
</head>

<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <p><input type="text" name="name" placeholder="店名"></p>
        <p><input type="text" name="tell" placeholder="電話番号">//000-0000-0000</p>
        <p><input type="text" name="place" placeholder="住所"></p>
        <p><input type="text" name="info" placeholder="情報"></p>
        <p><input type="text" name="start" placeholder="開店時間">//00:00</p>
        <p><input type="text" name="end" placeholder="閉店時間">//00:00</p>
        <p><input type="text" name="budget" placeholder="予算">//0000</p>
        <p><input type="file" name="image" class="img"></p>
        <p><button type="submit">登録！</button></p>
    </form>
</body>

</html>