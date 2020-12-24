<?php
session_start();
include("../functions.php");
$pdo = connect_to_db();

//店舗情報のデータを持ってくる処理 スコアが高い順に３店舗まで
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



$sql1 = "SELECT * FROM shop";
$stmt1 = $pdo->prepare($sql1);
$status1 = $stmt1->execute();

// var_dump($stmt);
// exit;

// データ登録処理後
if ($status1 == false) {

  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $shops1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>トップページ</title>
  <link rel="stylesheet" href="top.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <style>
    #map {
      height: 300px;
      width: 100%;
    }
  </style>
</head>

<body>
  <div class="page">
    <header>
      <div class="nav">
        <nav>
          <ul class="main-nav">
            <li><img src="../image/ramenman.jpg" alt=""></li>

            <li>
              <a href="../search/search.php" class="top_menu">
                <p class="menu_text"><span class="material-icons">local_dining</span>一覧</p>
              </a>
            </li>
            <li>
              <a href="#" class="top_menu">
                <p class="menu_text"><span class="material-icons">where_to_vote</span>エリア</p>
              </a>
            </li>
            <li>
              <a href="../login/login.php" class="top_menu">
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
                <form action="../search/search.php">
                  <input class="search_textbox" type="text" name="keyword">
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
            <a href="../search/search.php?keyword=天神"><span class="material-icons">place</span><br>
              <p>天神エリア</p>
            </a>
          </div>
          <div class="event_btn_b">
            <a href="../search/search.php?keyword=中洲"><span class="material-icons">rice_bowl</span><br>
              <p>中洲エリア</p>
            </a>
          </div>
          <div class="event_btn_c">
            <a href="../search/search.php?keyword=長浜"><span class="material-icons">star</span><br>
              <p>長浜</p>
            </a>
          </div>
        </div>
      </section>
      <section class="main_content">
        <div class="map">
          <h1>マップで探す</h1>
          <div data-aos=“zoom-in” class=“map_box”>
            <div id="map"></div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AnQJZrQy1wiLpy2Cxz-5hv-7pacTy0UigtldvZQiKCr3TotjOU7nZUiKGxVIV9Oz' async defer></script>
            <script>
              let map;
              const set = {
                enableHighAccuracy: true,
                maximumAge: 20000,
                timeout: 1000000,
              };

              function pushPin(lat, lng, now) {
                const location = new Microsoft.Maps.Location(lat, lng)
                const pin = new Microsoft.Maps.Pushpin(location, {
                  color: 'navy', // 色の設定
                  visible: true, // これ書かないとピンが見えない
                });
                now.entities.push(pin);
              };

              function generateInfobox(lat, lng, title, tell, now) {
                const location = new Microsoft.Maps.Location(lat, lng)
                console.log(title);
                let infobox = new Microsoft.Maps.Infobox(location, {
                  title: title,
                  description: tell
                });
                infobox.setMap(now);
              };

              function mapsInit(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                map = new Microsoft.Maps.Map('#map', {
                  center: {
                    latitude: lat,
                    longitude: lng,
                  },
                  zoom: 16,
                });
                <?php foreach ($shops1 as $shop1) : ?>
                  <?php
                  $lat = $shop1['lat'];
                  $lng = $shop1['lng'];
                  $name = "'" . $shop1['name'] . "'";
                  $tell = "'" . $shop1['tell'] . "'";
                  ?>
                  pushPin(<?= $lat ?>, <?= $lng ?>, map);
                  generateInfobox(<?= $lat ?>, <?= $lng ?>, <?= $name ?>, <?= $tell ?>, map);
                <?php endforeach; ?>
              };

              function mapsError(error) {
                let e = '';
                if (error.code == 1) {
                  e = '位置情報が許可されてません';
                } else if (error.code == 2) {
                  e = '現在位置を特定できません';
                } else if (error.code == 3) {
                  e = '位置情報を取得する前にタイムアウトになりました';
                }
                alert('error:' + e);
              };

              function GetMap() {
                navigator.geolocation.getCurrentPosition(mapsInit, mapsError, set);
              }
              window.onload = function() {
                GetMap();
              };
            </script>
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
              $category = $shop['category'];
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
                    <p><?= round($score, 1) ?>点</p>
                    <h2><?= $name ?></h2>
                    <p><?= $acsess ?></p>
                    <p><?= $tell ?></p>
                    <p><?= $time ?></p>
                    <p><span>カテゴリー</span><br>
                      <?= $category ?></p>
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