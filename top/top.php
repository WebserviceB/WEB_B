<?php
session_start();
include("../functions.php");
$pdo = connect_to_db();

//店舗情報のデータを持ってくる処理
$sql = 'SELECT * FROM shop LEFT OUTER JOIN 
(SELECT SUM(score)/COUNT(score) AS scores ,shop_id FROM posts GROUP BY shop_id) AS scores 
ON shop.id=scores.shop_id ORDER BY scores DESC LIMIT 3';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  //店舗情報の定義
  $shops = $stmt->fetchall(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="top.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>


  <div class="page">
    <header>
      <div class="nav">
        <nav>
          <ul class="main-nav">
            <li>
             
            </li>

            <li>
              <a href="../content/shop_list.php" class="top_menu">
                <p class="menu_text"><span class="material-icons">local_dining</span>店舗一覧</p>
              </a>
            </li>
            <li>
              <a href="#" class="top_menu">
                <p class="menu_text"><span class="material-icons">where_to_vote</span>エリア</p>
              </a>
            </li>
            <li>
              <a href="#" class="top_menu">
                <p class="menu_text"><span class="material-icons">login</span>login</p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </header>

    <main>
      <section class="top_text">
        <div class="main_container">
          <div class="main_inner">
            <p class="main_inner_text">
              FUKUOKA <p class="item_text">YATAI MAP</p>
              <div class="search_input_box">
                <form action="">
                  <input class="search_textbox" type="text" />
                  <label class="search-label" for="Username"><span class="material-icons">
                      search
                    </span>探す</label>
                </form>
              </div>

            </p>
          </div>
          <div class="main_img"></div>
          <div class="main_mask"></div>
        </div>
      </section>


      <section class="event">
        <div class="event_btn">
          <div class="event_btn_a">
            <a href=""><span class="material-icons">
                place
              </span><br>
              <p>天神駅から徒歩１０分</p>
            </a>
          </div>
          <div class="event_btn_b">
            <a href=""><span class="material-icons">
                rice_bowl
              </span><br>
              <p>中洲</p>
            </a>
          </div>
          <div class="event_btn_c">
            <a href=""><span class="material-icons">
                star
              </span><br>
              <p>隠れ人気店</p>
            </a>
          </div>
        </div>
      </section>
      <section class="main_content">

        <div class="map">
          <h1>マップで探す</h1>
          <div data-aos="zoom-in">
            <div class="map_box">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13293.89536922801!2d130.39905034999998!3d33.59300800000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3541918dd8b0a675%3A0x43ab58c2e521e67!2z44CSODEwLTAwMDEg56aP5bKh55yM56aP5bKh5biC5Lit5aSu5Yy65aSp56We!5e0!3m2!1sja!2sjp!4v1608275851737!5m2!1sja!2sjp" width="1400" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
          </div>
        </div>
      </section>

      <section class="ranking_box">
        <div class="ranking">
          <h1>ランキング</h1>
          <!-- カード -->
          <div class="ranking_card_box">
            <?php foreach ($shops as $shop) : ?>
              <?php
              $id = $shop['id'];
              $name = $shop['name'];
              $acsess = $shop['place'];
              $tell = $shop['tell'];
              $image = $shop['img'];
              $time = $shop['start'] . '〜' . $shop['end'];
              if ($shop['scores'] !== '') {
                $score = $shop['scores'];
              } else {
                $score = 0;
              }
              ?>
              <a href="../detail/shop_profile.php?id=<?= $id ?>" class="card_link">
                <div class="card">
                  <div class="thumb"><img src="../image/<?= $image ?>" alt=""></div>
                  <div class="card_inner">
                    <h2><?= $name ?></h2>
                    <p><?= $acsess ?></p>
                    <p><?= $tell ?></p>
                    <p><?= $time ?></p>
                    <span>カテゴリー</span>
                    <p><?= round($score, 1) ?>点</p>
                  </div>
                </div>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </section>
    </main>
    <a href="#" class="scrolltop">
      top
    </a>
  </div>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="top.js"></script>
</body>

</html>