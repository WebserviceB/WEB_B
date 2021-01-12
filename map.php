<?php
// session_start();

// アババッババスバなさあ

include("functions.php");
// check_session_id();

// // ユーザ名取得
// $user_id = $_SESSION['id'];

// DB接続
$pdo = connect_to_db();

// データ取得SQL作成
$sql = "SELECT * FROM shop";
// $sql = 'SELECT * FROM shop LEFT OUTER JOIN (SELECT todo_id, COUNT(id) AS cnt FROM like_table GROUP BY todo_id) AS likes ON todo_table.id = likes.todo_id';
// SQL準備&実行
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();


$tempo = array(
    array(
        $shop['lat'], $shop['lng'], $shop['name'], $tell['tell']

    )
);


// データ登録処理後
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
    // fetchAll()関数でSQLで取得したレコードを配列で取得できる
    $shops = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定

    // <tr><td>deadline</td><td>todo</td><tr>の形になるようにforeachで順番に$outputへデータを追加
    // `.=`は後ろに文字列を追加する，の意味
    // foreach ($result as $record) {
    //     $output .= "<tr>";
    //     $output .= "<td>{$record["deadline"]}</td>";
    //     $output .= "<td>{$record["todo"]}</td>";
    //     // edit deleteリンクを追加
    //     $output .= "<td><a href='like_create.php?todo_id={$record["id"]}&user_id={$user_id}'>like{$record["cnt"]}</a></td>";
    //     $output .= "<td><a href='todo_edit.php?id={$record["id"]}'>edit</a>
    // </td>";
    //     $output .= "<td><a href='todo_delete.php?id={$record["id"]}'>delete</a></td>";
    //     $output .= "</tr>";
}
// $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
// 今回は以降foreachしないので影響なし
unset($value);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div id="map"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AnQJZrQy1wiLpy2Cxz-5hv-7pacTy0UigtldvZQiKCr3TotjOU7nZUiKGxVIV9Oz' async defer></script>

    <script>
        let tempo = <?php echo $sampleJson ?>;
        let map;
        let name = '';
        let tell = '';

        // オプション
        // オブジェクトの形
        // 位置情報取得した際に実行されるようにする






        const set = {
            enableHighAccuracy: true,
            maximumAge: 20000,
            timeout: 1000000,
        };


        <?php foreach ($shops as $shop) : ?>
            <?php
            $lat = $shop['lat'];
            $lng = $shop['lng'];
            $name = $shop['name'];
            $tell = $shop['tell'];
            ?>



        <?php endforeach; ?>


        function pushPin(lat, lng, now) {
            const location = new Microsoft.Maps.Location(lat, lng)
            const pin = new Microsoft.Maps.Pushpin(location, {
                color: 'navy', // 色の設定
                visible: true, // これ書かないとピンが見えない
            });
            now.entities.push(pin);
        };

        function generateInfobox(lat, lng, now) {
            const location = new Microsoft.Maps.Location(lat, lng)
            const infobox = new Microsoft.Maps.Infobox(location, {
                title: name,
                description: tell
            });
            infobox.setMap(now);
        }

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
            name.push(<?= $name ?>);
            tell.push(<?= $tell ?>);

            pushPin(lat, lng, map);
            generateInfobox(lat, lng, map);

            pushPin(<?= $lat ?>, <?= $lng ?>, map);
            generateInfobox(<?= $lat ?>, <?= $lng ?>, map);
        }






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
        }


        function GetMap() {
            navigator.geolocation.getCurrentPosition(mapsInit, mapsError, set);

        }
        // 他のファイルの読み込みが終わったら{}内を実行する
        window.onload = function() {
            GetMap();
        }
    </script>

</body>

</html>