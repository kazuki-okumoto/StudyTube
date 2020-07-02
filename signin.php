<?php

require_once("config/config.php");
require_once("model/User.php");

session_start();

// Userセッション情報を初期化
$_SESSION["User"] = array();

//　ログイン、新規登録間を行き来可能
$_SESSION["hero"] = time();

// heroページを経由しているかの判別
if (empty($_SESSION["hero"])) {
    header("Location: hero.php");
}

// アカウント作成完了！通知
if (!empty($_SESSION["login"])) {
    $notice = "アカウント作成完了！";
    if ($_POST) {
        // loginセッション情報を初期化
        $_SESSION["login"] = array();
    }
}

// PDO接続
try {
    $dbh = new User($host, $dbname, $lang, $user, $pass);
    $dbh->connectDb();

    // ログイン
    if (!empty($_POST)) {
        $result = $dbh->login($_POST);
        if (!empty($result)) {
            $_SESSION['User'] = $result;
            header("Location: index.php");
            exit;
        } else {
            $message = "ログインできませんでした...";
        }
    }
}

// PDO接続エラー
catch (PDOException $e) {
    echo "エラー！:" . $e->getMessage() . "<br/gt;";
    die();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyTube</title>
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/signin.min.css">
</head>

<body>

    <!-- header ▼-->
    <header class="header">
        <div class="header__inner">
            <div class="header__left">
                <a class="header__logo-title" href="index.php">
                    <img class="header__logo" src="images/subscriptions-24px.svg" alt="StudyTubeのロゴ画像">
                    <p class="header__title">StudyTube</p>
                </a>
            </div>
        </div>
    </header>
    <!-- header End ▲-->

    <!-- account-created-notice ▼-->
    <?php if (!empty($_SESSION["login"])) : ?>
        <div class="login-notice" id="login-notice-js">
            <img class="login-notice__image" src="images/icon18.png" alt="アカウント作成完了画像">
            <p class="login-notice__message"> <?php echo $notice ?> </p>
        </div>
    <?php endif; ?>
    <!-- account-created-notice End ▲-->

    <!-- form ▼-->
    <div class="hero">
        <div class="form">
            <div class="form__inner">
                <h1 class="form__heading">ログイン</h1>
                <?php if (!empty($message)) : ?>
                    <p class="error"><?php echo $message; ?></p>
                <?php endif; ?>
                <form class="form__wrap" action="" method="post">
                    <div class="form__item">
                        <label class="form__item-label" for="email">メールアドレス</label>
                        <input class="form__item-input" id="email" type="email" name="email" required="required" autocomplete="email"></input>
                    </div>
                    <div class="form__item form__item--bottom">
                        <label class="form__item-label" for="password">パスワード</label>
                        <input class="form__item-input" id="password" type="password" name="password" required="required" autocomplete="password"></input>
                    </div>
                    <input class="form__btn" type="submit" value="ログインする">
                </form>
                <div class="form__footer">
                    <a class="form__footer-link" href="signup.php">アカウントをお持ちでない方はこちら</a>
                </div>
            </div>
        </div>
    </div>
    <!-- form End ▲-->

    <!-- footer ▼-->
    <footer class="footer">
        <small class="footer__inner">Copyright ©2020 StudyTube, All Rights Reserved.</small>
    </footer>
    <!-- footer End ▲-->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="scripts/index.js"></script>
</body>

</html>
