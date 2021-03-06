<?php

include("functions.php");
$pdo = connect_to_db();
$sql = "SELECT * FROM shop";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {

    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $maps = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        function generateInfobox(lat, lng, title, tell, id, now) {
            const location = new Microsoft.Maps.Location(lat, lng)
            let infobox = new Microsoft.Maps.Infobox(location, {
                title: title,
                description: tell,
                height: 80,
                width: 160,
                showPointer: false,
                showCloseButton: false,
                actions: [{
                    label: title,
                    eventHandler: function() {
                        window.location.href = 'detail/shop_profile.php?id=' + id;
                    }
                }]

            });
            infobox.setMap(now);
        };


        function mapsInit(position) {
            const lat = 33.591021;
            const lng = 130.404782;
            map = new Microsoft.Maps.Map('#map', {
                center: {
                    latitude: lat,
                    longitude: lng,
                },
                zoom: 16,
            });

            <?php foreach ($maps as $map) : ?>
                <?php
                $id = $map['id'];
                $lat = $map['lat'];
                $lng = $map['lng'];
                $name = "'" . $map["name"] . "'";
                $tell = "'" . $map["tell"] . "'";
                ?>
                pushPin(<?= $lat ?>, <?= $lng ?>, map);
                generateInfobox(<?= $lat ?>, <?= $lng ?>, <?= $name ?>, <?= $tell ?> <?= $id ?>, map);
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
</body>

</html>