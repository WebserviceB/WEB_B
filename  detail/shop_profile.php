<?php
session_start();
include("../functions.php");
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
    $img = '../image/' . $shop['img'];
    $tell = $shop['tell'];
    $place = $shop['place'];
    $info = $shop['info'];
    $time = $shop['start'] . '〜' . $shop['end'];
    $budget = $shop['budget'];
    $score = $shop['score'];
}

//レビューのデータを持ってくる処理
$sql = 'SELECT p.title,p.text,p.score,u.name,p.created FROM posts as p 
        LEFT OUTER JOIN user as u ON p.member_id=u.id WHERE p.shop_id=:id ORDER BY p.created DESC';
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

//レビューの評価の平均点を出す処理
$sql = 'SELECT COUNT(score),SUM(score) FROM posts WHERE shop_id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();
if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $scores = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_score = $scores['SUM(score)'] / $scores['COUNT(score)'];
    $score_count = $scores['COUNT(score)'];
};


?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="detail.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title><?= $name ?></title>
</head>

<body>
    <header>
        <div class="category_menu_btn">
            <button>登録</button>
        </div>
    </header>
    <main>
        <div class="ditail_manu">
            <!-- 詳細カードスタート -->
            <section class="info">
                <div class="info_text">
                    <h1><?= $name ?></h1>
                    <p>エリア</p>
                    <p>カテゴリー</p>
                </div>
                <!-- 店舗写真 -->
                <div class="info_box">
                    <img src="<?= $img ?>" alt="">
                    <div class="info_text_box">
                        <table>
                            <tr>
                                <th>評価</th>
                                <td>：</td>
                                <td><?= $total_score ?>点　（<?= $score_count ?>人の評価）</td>
                            </tr>
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

                    <!-- 店舗マップ -->
                    <div class="map_box">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13293.89536922801!2d130.39905034999998!3d33.59300800000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3541918dd8b0a675%3A0x43ab58c2e521e67!2z44CSODEwLTAwMDEg56aP5bKh55yM56aP5bKh5biC5Lit5aSu5Yy65aSp56We!5e0!3m2!1sja!2sjp!4v1608275851737!5m2!1sja!2sjp" width="600" height="250" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div>
            </section>

            <!-- レビュー -->
            <section class="review">
                <!-- レビューボックス -->
                <?php foreach ($reviews as $review) : ?>
                    <?php
                    $title = $review['title'];
                    $text = $review['text'];
                    $score = $review['score'];
                    $name = $review['name'];
                    $time = $review['created'];
                    ?>
                    <div class="review_box">
                        <p>name:<?= $name ?></p>
                        <h1><?= $title ?></h1>
                        <div class="review_text">
                            <p><?= $text ?></p>
                            <p><?= $time ?> <span class="material-icons">delete</span></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>

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
        </div>
    </main>
    <footer>
        <a href="shoplist.php">一覧に戻る</a>
    </footer>

</body>

</html>