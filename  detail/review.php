<?php
session_start();
include("functions.php");
$pdo = connect_to_db();

$title = $_POST['title'];
$text = $_POST['text'];
$score = $_POST['score'];
$member_id = $_POST['member_id'];
$shop_id = $_POST['shop_id'];

$sql = 'INSERT INTO posts(id,title,text,score,memeber_id,shop_id) SET (NULL,:title,:text,:score,:m_id,:s_id,sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':text', $text, PDO::PARAM_STR);
$stmt->bindValue(':score', $score, PDO::PARAM_STR);
$stmt->bindValue(':m_id', $member_id, PDO::PARAM_STR);
$stmt->bindValue(':s_id', $shop_id, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    $title = "エラー";
    exit();
} else {
    $title = '投稿完了';
    $result = 'レビューの投稿が完了しました。';
};
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
</head>

<body>
    <?php if (isset($result)) : ?>
        <p><?= $result ?></p>
    <?php endif; ?>

    <a href="shop_profile.php?id=<?= $shop_id ?>">戻る</a>
</body>

</html>