<?php

require_once("config/config.php");
require_once("model/User.php");

session_start();

// Userセッション情報を初期化
$_SESSION["User"] = array();

// アカウント作成完了通知セッション情報を初期化
$_SESSION["login"] = array();


// hero.phpを経由しているかの判別
if (empty($_SESSION["hero"])) {
    header("Location: hero.php");
}

// ログイン、新規登録間を行き来可能
$_SESSION["hero"] = time();

// PDO接続
try {
    $user = new User($host, $dbname, $lang, $user, $pass);
    $user->connectDb();

    // 新規登録
    if (!empty($_POST)) {
        if ($_POST["password"] == $_POST["password-check"]) {
            $user->createAccount($_POST);
            $_SESSION['login'] = time();
            header("Location: signin.php");
            exit;
        } else {
            $error = "パスワードが一致していません...";
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
    <link rel="stylesheet" href="styles/signup.min.css">
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

    <!-- form ▼-->
    <div class="hero">
        <div class="form">
            <div class="form__inner">
                <h1 class="form__heading">新規登録</h1>
                <?php if (!empty($error)) : ?>
                    <p class="error"> <?php echo $error; ?></p>
                <?php endif; ?>
                <form class="form__wrap" action="" method="post">
                    <div class="form__item">
                        <label class="form__item-label" for="name">お名前</label>
                        <input class="form__item-input" id="name" type="name" name="name" required="required" autocomplete="name"></input>
                    </div>
                    <div class="form__item">
                        <label class="form__item-label" for="email">メールアドレス</label>
                        <input class="form__item-input" id="email" type="email" name="email" required="required" autocomplete="email"></input>
                    </div>
                    <div class="form__item">
                        <label class="form__item-label" for="password">パスワード</label>
                        <input class="form__item-input" id="password" type="password" name="password" required="required" autocomplete="password"></input>
                    </div>
                    <div class="form__item form__item--bottom">
                        <label class="form__item-label" for="password-check">パスワード（再確認）</label>
                        <input class="form__item-input" id="password-check" type="password" name="password-check" required="required"></input>
                    </div>
                    <input class="form__btn" type="submit" value="アカウントを作成する"></input>
                </form>
                <div class="form__footer">
                    <a class="form__footer-link" href="signin.php">アカウントをお持ちの方はこちら</a>
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

</body>

</html>
