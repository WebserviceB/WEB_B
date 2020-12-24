<?php
session_start();
include("../functions.php");
error_reporting(E_ALL & ~E_NOTICE);
$pdo = connect_to_db();

// $id = 10;  //テスト用   
// $member_id = 2;  //テスト用
$id = $_GET['id'];  //本番はこっち
$member_id = $_SESSION['id'];  //本番はこっち

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
    if ($scores['COUNT(score)'] > 0) {
        $total_score = $scores['SUM(score)'] / $scores['COUNT(score)'];
        $score_count = $scores['COUNT(score)'];
    } else {
        $total_score = 0;
        $score_count = 0;
    }
};
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="detail.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <title><?= $name ?></title>
</head>


<body>
    <header>
        <div class="login_btn">
            <a href="../login/login.php" class="top_menu">
            <p class="menu_text"><span class="material-icons">login</span>login</p></a>
        </div>
        </header>
        

    <main>
        <div class="ditail_manu">
            <!-- 詳細カードスタート -->
            <section class="info">
                <div class="info_text">
                    <div class="info_title_name">
                        <span>店舗名</span>
                        <h1><?= $name ?></h1>
                    </div>
                    <div class="info_inner">
                        <ul>
                            <li><span>カテゴリ: </span>
                                <p>ラーメン</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- 店舗写真 -->
                <div class="info_box">
                    <div class="info_text_box">
                        <div class="info_text_box_img">
                            <div data-aos="zoom-in">
                                <img src="<?= $img ?>" alt="">
                            </div>
                        </div>
                        <div class="info_text_box_text">
                            <table cellspacing="14 15">
                                <tr>
                                    <th>評価</th>
                                    <td>：</td>
                                    <td><?= $total_score ?>点（<?= round($score_count, 1) ?>人の評価）</td>
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
                    </div>
                    <!-- 店舗マップ -->
                    <div class="map_box" data-aos="zoom-in">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13293.89536922801!2d130.39905034999998!3d33.59300800000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3541918dd8b0a675%3A0x43ab58c2e521e67!2z44CSODEwLTAwMDEg56aP5bKh55yM56aP5bKh5biC5Lit5aSu5Yy65aSp56We!5e0!3m2!1sja!2sjp!4v1608275851737!5m2!1sja!2sjp" width="900" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div>
            </section>
            <!-- レビュー -->
            <section class="review">
                <!-- レビューボックス -->
                <h3>レビュー（<?= $score_count ?>件）</h3>
                <?php foreach ($reviews as $review) : ?>
                    <?php
                    $title = $review['title'];
                    $text = $review['text'];
                    $score = $review['score'];
                    $name = $review['name'];
                    $time = $review['created'];
                    ?>
                    <div class="review_box">
                        <h1><?= $title ?> <span><?= $score ?>点</span></h1>
                        <div class="review_text">
                            <p><?= $text ?></p>
                            <p>name : <?= $name ?> <?= $time ?> <span class="material-icons">delete</span></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>

            <!-- member_idが空ではない時（ログインしている時）表示 -->
            <?php if ($member_id >= 1) : ?>
                <details>
                    <summary>レビュー投稿</summary>
                    <form action="review.php" method="POST">
                        <input type="hidden" name="shop_id" value="<?= $id ?>">
                        <input type="hidden" name="member_id" value="<?= $member_id ?>">
                        <p><input type="text" name="title" class="title-input" placeholder="タイトル">
                            <p class="score-select">
                                お店の評価
                                <input type="radio" name="score" value="1" id="score1"><label for="score1">1</label>
                                <input type="radio" name="score" value="2" id="score2"><label for="score2">2</label>
                                <input type="radio" name="score" value="3" id="score3"><label for="score3">3</label>
                                <input type="radio" name="score" value="4" id="score4"><label for="score4">4</label>
                                <input type="radio" name="score" value="5" id="score5"><label for="score5">5</label>
                            </p>
                        </p>
                        <p><textarea name="text" id="" cols="30" rows="10" placeholder="本文"></textarea></p>

                        <p><button type="submit" id="submit">レビュー投稿</button></p>
                    </form>
                </details>
            <?php endif; ?>

            <div class="search_logo"><a href="../search/search.php"><img src="../image/ramenman.jpg" alt="">店舗一覧へ</a></div>

        </div>
    </main>
    <footer>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="detail.js"></script>
</body>

</html>