<?php

session_start();

// heroセッション情報を初期化
$_SESSION["hero"] = array();

// Userセッション情報を初期化
$_SESSION["User"] = array();

// loginセッション情報を初期化
$_SESSION["login"] = array();

// signin,signup画面へURLから行けない判別
if (!empty($_POST["signin"])) {
    $_SESSION["hero"] = time();
    header("Location: signin.php");
    exit;
} elseif (!empty($_POST["signup"])) {
    $_SESSION["hero"] = time();
    header("Location: signup.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyTube</title>
    <link rel="stylesheet" href="styles/hero.min.css">
    <link rel="stylesheet" href="styles/reset.css">
</head>

<body>

    <!-- header ▼-->
    <header class="header">
        <div class="header__inner">
            <div class="header__left">
                <a class="header__logo-title" href="index.php">
                    <img class="header__logo" src="images/subscriptions-24px.svg" alt="FavoTubeのロゴ画像">
                    <p class="header__title">StudyTube</p>
                </a>
            </div>
        </div>
    </header>
    <!-- header End ▲-->

    <!-- hero ▼-->
    <div class="hero">
        <div class="hero__inner">
            <h1 class="hero__title hero__title--bottom">StudyTubeをはじめよう</h1>
            <p class="hero__concept">YouTube学習を効率よく行えるサイトです。</p>
            <p class="hero__concept">動画を登録して、カテゴライズすることも可能です。</p>
            <p class="hero__concept">さっそく学習を始めましょう。</p>
            <div class="hero__btn">
                <form action="" method="post">
                    <button class="hero__btn-item hero__btn-item--right" type="submit" name="signin" value="signin">ログイン</button>
                    <button class="hero__btn-item" type="submit" name="signup" value="signup">新規登録</button>
                </form>
            </div>
        </div>
    </div>
    <!-- hero End ▲-->

    <footer class="footer">
        <small class="footer__inner">Copyright ©2020 StudyTube, All Rights Reserved.</small>
    </footer>
</body>

</html>
