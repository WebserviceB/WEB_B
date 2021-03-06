<?php

session_start();
include('../functions.php');

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
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
  $output = "";
  // <tr><td>deadline</td><td>todo</td><tr>の形になるようにforeachで順番に$outputへデータを追加
  // `.=`は後ろに文字列を追加する，の意味
  foreach ($result as $record) {
    $output .= "<a href='shop_profile.php?id={$record["id"]}'><div>";
    $output .= "<div><img src='../image/{$record["img"]}'></div>";
    $output .= "<div>{$record["name"]}</div>";
    $output .= "<div>{$record["start"]} ~ {$record["end"]}</div>";
    $output .= "</div></a>";
  }
  // var_dump($output);
  // exit();
  // $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
  // 今回は以降foreachしないので影響なし
  unset($value);
}
?>


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
          <li><a href="#" class="logo">屋台</a></li>
          <li><a href="#">top</a></li>
          <li><a href="#">login</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <main>
    <!-- カテゴリーメニュー -->
    <div class="category_menu">
      <nav>
        <h1>category</h1>
        <ul>
          <li>ラーメン</li>
          <li>焼き鳥</li>
          <li>多国籍</li>
        </ul>
      </nav>
    </div>
    <!-- カード -->
    <div class="card_box">
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