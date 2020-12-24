<?php
session_start();
include("../functions.php");
$pdo = connect_to_db();

//レビューのDBへの登録
$title = $_POST['title'];
$text = $_POST['text'];
$score = $_POST['score'];
$member_id = $_POST['member_id'];
$shop_id = $_POST['shop_id'];
$sql = 'INSERT INTO posts(id,title,text,score,member_id,shop_id,created) VALUES (NULL,:title,:text,:score,:m_id,:s_id,sysdate())';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':text', $text, PDO::PARAM_STR);
$stmt->bindValue(':score', $score, PDO::PARAM_STR);
$stmt->bindValue(':m_id', $member_id, PDO::PARAM_STR);
$stmt->bindValue(':s_id', $shop_id, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    $title = "エラー";
    exit();
} else {
    $title = '投稿完了';
    $result = 'レビューの投稿が完了しました。';
};
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <title>Document</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    .card_box {
        margin: 0 auto;
        margin-top: 100px;
        width: 60%;
        padding: 40px;
        background: rgb(243, 228, 68);
    }

    .card {
        height: 400px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .item_text {
        text-align: center;
        font-size: 45px;
        font-weight: bold;
        margin: 40px;
        animation: key1 .3s ease infinite alternate;
        letter-spacing: 0.15em;
        margin: 0 auto;
        letter-spacing: 0.15em;
        -webkit-text-stroke: 1.3px #6e4602;
        color: transparent;
    }

    @keyframes key1 {
        0% {
            transform: translateY(0px);

        }

        100% {
            transform: translateY(-10px);
        }
    }


    .top_logo img {
        margin-top: 20px;
        margin-left: 20px;
        mix-blend-mode: multiply;
        width: 60px;
    }

    .top_logo a {
        font-size: 18px;
        font-weight: bold;
        color: rgb(122, 49, 3);
        text-decoration: none;
        transition: all .3s ease-in-out;
    }

    .top_logo a:hover {
        font-size: 20px;
        font-weight: bold;
        color: rgb(224, 94, 13);
        text-decoration: none;
    }

    .card_img {
        width: 50%;
        text-align: right;
    }

    .card_img img {
        mix-blend-mode: multiply;
        width: 300px;
    }

    .card_img p {
        font-weight: bold;
        font-size: 14px;
        transition: all .3s ease-in-out;
    }

    .card_img a {
        text-decoration: none;
        transition: all .3s ease-in-out;
        color: rgb(211, 114, 45);
    }

    .card_img p:hover {
        font-weight: bold;
        font-size: 16px;
        color: rgb(255, 107, 1);
    }
</style>

<body>

    <div class="card_box">

        <div class="card">


            <?php if (isset($result)) : ?><p class="item_text"><?= $result ?> </p><?php endif;
                                                                                    ?>


            <div class="card_img">
                <img src="../image/ramenman.jpg" alt="">

                <a href="../detail/shop_profile.php?id=<?= $shop_id ?>">
                    <p>店舗ページへ戻る</p>
                </a>
            </div>

        </div>


    </div>

</body>

</html>