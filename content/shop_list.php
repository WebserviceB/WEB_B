<?php

session_start();
include('../functions.php');
// check_session_id();

// DB接続
$pdo = connect_to_db();

// データ取得SQL作成
$sql = 'SELECT * FROM shop ';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  // exit();
} else {
  // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
  // fetchAll()関数でSQLで取得したレコードを配列で取得できる
  $shops = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データ
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <!DOCTYPE html>
  <html lang="ja">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="content.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>

  <body>
    <header>
      <!-- トップナビ -->
      <div class="nav">
        <nav>
          <ul class="main-nav">
            <li><a href="#" class="logo">
                <p class="item_text">YATAI MAP</p>
              </a></li>
            <li><a href="#" class="top_menu">
                <p class="menu_text"><span class="material-icons">where_to_vote</span>エリア</p>
              </a></li>
            <li><a href="#" class="top_menu">
                <p class="menu_text"><span class="material-icons">where_to_vote</span>TOP</p>
              </a></li>
          </ul>
        </nav>
      </div>
    </header>

    <main>
      <!-- カテゴリーメニュー -->
      <div class="category_menu">
        <nav>

          <h1>カテゴリー</h1>
          <ul>
            <li><a href="#">ラーメン</a> </li>
            <li><a href="#">焼き鳥</a> </li>
            <li><a href="#">多国籍</a> </li>
            <li><a href="#">その他</a> </li>


          </ul>
        </nav>
      </div>


      <!-- カード -->
      <div class="card_box">
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

          <!-- カードスタート -->
          <div class="card">
            <a href="../detail/shop_profile.php?id=<?= $id ?>" class="card_link">
              <div class="thumb">
                <img src="../image/<?= $image ?>" alt="">
              </div>
              <div class="card_inner">
                <h1><?= $name ?></h1>
                <span>カテゴリー</span>
                <p>詳細</p>
                <div>
                  
                </div>
                <div class="inner_text">
                  <p>ラーメンが美味しいよ。おばちゃんがやってるよ。jjjjjjjjjjjjjjjjjjjj</p>
                </div>
                <div class="iine">
                  <p>いいね</p>
                </div>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
        <!-- カードスタート -->

        <div class="card">
          <a href="item-1" class="card_link">
            <div class="thumb">
              <img src="" alt="">
            </div>
            <div class="card_inner">
              <h1>店名</h1>
              <span>カテゴリー</span>
              <p>詳細</p>

              <div class="inner_text">
                <p>ラーメンが美味しいよ。おばちゃんがやってるよ。jjjjjjjjjjjjjjjjjjjj</p>
              </div>
              <div class="iine">
                <p>いいね</p>
              </div>
            </div>
          </a>
        </div>

        <!-- カードスタート -->

        <div class="card">
          <a href="item-1" class="card_link">
            <div class="thumb">
              <img src="" alt="">
            </div>
            <div class="card_inner">
              <h1>店名</h1>
              <span>カテゴリー</span>
              <p>詳細</p>

              <div class="inner_text">
                <p>ラーメンが美味しいよ。おばちゃんがやってるよ。jjjjjjjjjjjjjjjjjjjj</p>
              </div>
              <div class="iine">
                <p>いいね</p>
              </div>
            </div>
          </a>
        </div>

        <!-- 終わり -->
        <!-- カードスタート -->

        <div class="card">
          <a href="item-1" class="card_link">
            <div class="thumb">
              <img src="" alt="">
            </div>
            <div class="card_inner">
              <h1>店名</h1>
              <span>カテゴリー</span>
              <p>詳細</p>

              <div class="inner_text">
                <p>ラーメンが美味しいよ。おばちゃんがやってるよ。jjjjjjjjjjjjjjjjjjjj</p>
              </div>
              <div class="iine">
                <p>いいね</p>
              </div>
            </div>
          </a>
        </div>

        <!-- 終わり -->
        <!-- カードスタート -->

        <div class="card">
          <a href="item-1" class="card_link">
            <div class="thumb">
              <img src="" alt="">
            </div>
            <div class="card_inner">
              <h1>店名</h1>
              <span>カテゴリー</span>
              <p>詳細</p>

              <div class="inner_text">
                <p>ラーメンが美味しいよ。おばちゃんがやってるよ。jjjjjjjjjjjjjjjjjjjj</p>
              </div>
              <div class="iine">
                <p>いいね</p>
              </div>
            </div>
          </a>
        </div>

        <!-- 終わり -->
        <!-- カードスタート -->

        <div class="card">
          <a href="item-1" class="card_link">
            <div class="thumb">
              <img src="" alt="">
            </div>
            <div class="card_inner">
              <h1>店名</h1>
              <span>カテゴリー</span>
              <p>詳細</p>

              <div class="inner_text">
                <p>ラーメンが美味しいよ。おばちゃんがやってるよ。jjjjjjjjjjjjjjjjjjjj</p>
              </div>
              <div class="iine">
                <p>いいね</p>
              </div>
            </div>
          </a>
        </div>

        <!-- 終わり -->

      </div>
      </div>

    </main>



  </body>

  </html>