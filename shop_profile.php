<?php
session_start();
include("functions.php");
$pdo = connect_to_db();

$id = 10;  //テスト用   
$member_id = 2;  //テスト用
// $id = $_GET['id];  //本番はこっち
// $member_id = $_SESSION['id'];  //本番はこっち

//店舗情報のデータを持ってくる処理
$sql = 'SELECT * FROM shop WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    //店舗情報の定義
    $shop = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = $shop["name"];
    $img = 'image/' . $shop['img'];
    $tell = $shop['tell'];
    $place = $shop['place'];
    $info = $shop['info'];
    $time = $shop['start'] . '〜' . $shop['end'];
    $budget = $shop['budget'];
    $score = $shop['score'];
}
//レビューのデータを持ってくる処理
$sql = 'SELECT title,text,score,name FROM posts 
        LEFT OUTER JOIN user ON posts.member_id=user.id WHERE shop_id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();
if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $reviews = $stmt->fetchall(PDO::FETCH_ASSOC);
};

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $name ?></title>
    <style>
        th {
            text-align: left;
        }
    </style>
</head>

<body>
    <div>
        <h2><?= $name ?></h2>
        <img src="<?= $img ?>" alt="" width="300px">
        <table>
            <tr>
                <th>電話番号</th>
                <td>：</td>
                <td><?= $tell ?></td>
            </tr>
            <tr>
                <th>住所</th>
                <td>：</td>
                <td><?= $place ?></td>
            </tr>
            <tr>
                <th>情報</th>
                <td>：</td>
                <td><?= $info ?></td>
            </tr>
            <tr>
                <th>営業時間</th>
                <td>：</td>
                <td><?= $time ?></td>
            </tr>
            <tr>
                <th>予算</th>
                <td>：</td>
                <td><?= $budget ?>円</td>
            </tr>
        </table>

    </div>

    <!-- レビューの表示 -->
    <div class="review">
        <?php foreach ($reviews as $review) : ?>
            <?php
            $title = $review['title'];
            $text = $review['text'];
            $score = $review['score'];
            $name = $review['name'];
            ?>
            <div>
                <h3><?= $title ?></h3>
                <p><?= $text ?></p>
                <p><?= $score ?>点</p>
                <p><?= $name ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- member_idが空ではない時（ログインしている時）表示 -->
    <?php if ($member_id !== '') : ?>
        <form action="review.php" method="POST">
            <h3>レビュー投稿</h3>
            <input type="hidden" name="shop_id" value="<?= $id ?>">
            <input type="hidden" name="memeber_id" value="<?= $member_id ?>">
            <p><input type="text" name="title"></p>
            <p><textarea name="text" id="" cols="30" rows="10"></textarea></p>
            <input type="radio" name="score" value="1" id="score1"><label for="score1">1</label>
            <input type="radio" name="score" value="2" id="score2"><label for="score2">2</label>
            <input type="radio" name="score" value="3" id="score3"><label for="score3">3</label>
            <input type="radio" name="score" value="4" id="score4"><label for="score4">4</label>
            <input type="radio" name="score" value="5" id="score5"><label for="score5">5</label>
            <p><button type="submit">レビュー投稿</button></p>
        </form>
    <?php endif; ?>

    <a href="shoplist.php">一覧に戻る</a>
</body>

</html>