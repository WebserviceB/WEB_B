<?php
// session_start();
// include("../functions.php");
// $pdo = connect_to_db();

// $title = $_POST['title'];
// $text = $_POST['text'];
// $score = $_POST['score'];
// $member_id = $_POST['member_id'];
// $shop_id = $_POST['shop_id'];

// $sql = 'INSERT INTO posts(id,title,text,score,memeber_id,shop_id) SET (NULL,:title,:text,:score,:m_id,:s_id,sysdate())';

// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(':title', $title, PDO::PARAM_STR);
// $stmt->bindValue(':text', $text, PDO::PARAM_STR);
// $stmt->bindValue(':score', $score, PDO::PARAM_STR);
// $stmt->bindValue(':m_id', $member_id, PDO::PARAM_STR);
// $stmt->bindValue(':s_id', $shop_id, PDO::PARAM_STR);
// $status = $stmt->execute();

// if ($status == false) {
//     $error = $stmt->errorInfo();
//     echo json_encode(["error_msg" => "{$error[2]}"]);
//     $title = "エラー";
//     exit();
// } else {
//     $title = '投稿完了';
//     $result = 'レビューの投稿が完了しました。';
// };
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>

        *{
            margin: 0;
            padding: 0;
        }
        main {
            width: 100%;
            background: rgb(230, 165, 69);
        }

        .review_card {
            width: 80%;
            background: #fff;
            margin: 0 auto;
        }

        .item_text {
            font-size: 70px;
            font-weight: bold;
            color: rgb(251, 200, 59);
            margin: 40px;
            margin-left: 300px;
            animation: key1 .3s ease infinite alternate;
            letter-spacing: 0.15em;

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
    </style>

</head>

<body>


    <!-- <?php if (isset($result)) : ?> -->
    <!-- <?= $result ?> -->

    <p class="item_text">

        投稿できました
    </p>
    <!-- <?php endif; ?> -->

    <main>
        <div class="review_card">

        </div>

        <div class="div">
            <p class="item_text">

                投稿できました
            </p>
        </div>

        <div class="top_logo"><a href="shop_profile.php?id=<?= $shop_id ?>"><img src="../image/ramenman.jpg" alt="">投稿を確認する</a></div>



    </main>
</body>

</html>