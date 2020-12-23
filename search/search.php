<?php
session_start();
include("../functions.php");
$pdo = connect_to_db();

$keyword = $_GET['keyword'];
date_default_timezone_set('Asia/Tokyo');
$time = date('Y/n/d/H:i');
$sql = 'SELECT * FROM shop WHERE name LIKE :key or place LIKE :key or category LIKE :key';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':key', '%' . $keyword . '%', PDO::PARAM_STR);
$status = $stmt->execute();


if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  //店舗情報の定義
  $shops = $stmt->fetchall(PDO::FETCH_ASSOC);
};


?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="search.css">
</head>

<body>
  <div class="search_box flex">

    <!-- サーチワード -->
    <section class="info">
      <div class="info_text">
        <h1>Today</h1>
        <p><?= $time ?></p>
      </div>
      <div class="info_text">
        <h1>Search word</h1>
        <p><?= $keyword ?></p>
      </div>

      <!-- なび -->
      <div class="category_menu">
        <nav>
          <h1>キーワード</h1>
          <ul>
            <li><a href="search.php?keyword=ラーメン">ラーメン</a></li>
            <li><a href="search.php?keyword=焼き鳥">焼き鳥</a></li>
            <li><a href="search.php?keyword=博多">博多</a></li>
            <li><a href="search.php?keyword=天神">天神</a></li>
            <li><a href="search.php?keyword=中洲">中洲</a></li>
          </ul>
        </nav>
      </div>
      <a href="../top/top.php">TOP</a>
    </section>
    <!-- ナビ終わり -->
    <section class="card right">
      <!-- ここからカードスタート -->
      <?php foreach ($shops as $shop) : ?>
        <?php
        $id = $shop['id'];
        $name = $shop["name"];
        $img = '../image/' . $shop['img'];
        $tell = $shop['tell'];
        $place = $shop['place'];
        $info = $shop['info'];
        $category = $shop['category'];
        $time = $shop['start'] . '〜' . $shop['end'];
        $budget = $shop['budget'];
        $score = $shop['score'];
        ?>
        <a href="../detail/shop_profile.php?id=<?= $id ?>">
          <div class="card-item left">
            <img src="<?= $img ?>" alt="">
            <div class="right">
              <h1><?= $name ?></h1>
              <p>平均単価
                <span><?= $budget ?>yen</span>
              </p>
              <p><?= $tell ?></p>
              <p><?= $category ?></p>
              <p><?= $time ?></p>
              <p><?= $place ?></p>
              <p class="upper in-blo">read more
                <button class="btn">veiw</button></p>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </section>
  </div>


</body>

</html>