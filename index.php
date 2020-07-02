<?php

require_once("config/config.php");
require_once("model/DB.php");
require_once("model/User.php");

session_start();

// ログイン画面を経由しているかの判別
if (empty($_SESSION['User'])) {
    header("Location: hero.php");
    exit;
}

// PDO接続
try {
    $dbh = new User($host, $dbname, $lang, $user, $pass);
    $dbh->connectDb();

    // ムービー追加
    if (!empty($_POST["addMovie"])) {
        $arr = [
            "title" => $_POST["title"],
            "link" => $_POST["link"],
            "category_id" => $_POST["category_id"]
        ];
        $dbh->addMovie($arr);
    }

    // カテゴリー追加
    if (!empty($_POST["addCategory"]) && !empty($_POST["category"])) {
        $arr = [
            "category" => $_POST["category"],
            "user_id" => $_SESSION["User"]["id"]
        ];
        $dbh->addCategory($arr);
    }

    // ムービー参照
    if (!empty($_POST["category_id"])) {
        $arr = [
            "category_id" => $_POST["category_id"],
        ];
        $movie = $dbh->findMovieByCategoryId($arr);
    }

    // カテゴリー参照
    if (!empty($_SESSION["User"]["id"])) {
        $arr = ["user_id" => $_SESSION["User"]["id"]];
        $category = $dbh->findCategoryById($arr);
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
    <link rel="stylesheet" href="styles/index.min.css">
    <link rel="stylesheet" href="styles/reset.css">
</head>

<body>

    <!-- header ▼-->
    <header class="header">
        <div class="header__inner">
            <div class="header__left">
                <div class="header__nav-btn-wrap">
                    <div class="header__nav-btn" id="header__nav-btn-js">
                        <span class="header__nav-btn-bar"></span>
                        <span class="header__nav-btn-bar"></span>
                        <span class="header__nav-btn-bar"></span>
                    </div>
                </div>
                <a class="header__logo-title" href="index.php">
                    <img class="header__logo" src="images/subscriptions-24px.svg" alt="StudyTubeのロゴ画像">
                    <p class="header__title">StudyTube</p>
                </a>
            </div>
            <div class="header__center"></div>
            <div class="header__right">
                <button class="header__post-btn" id="header__post-btn-js">
                    <p class="header__post-btn-title">動画を投稿</p>
                </button>
                <img class="header__user-icon" id="header__user-icon-js" src="images/oden.png" alt="ユーザーのアイコン画像">
            </div>
        </div>
    </header>
    <!-- header End ▲-->

    <div class="container" id="container-js">

        <!-- nav ▼-->
        <nav class="nav" id="nav-js">
            <div class="nav__inner">
                <div class="nav__top">
                    <h2 class="nav__top-heading">カテゴリ</h2>
                    <img class="nav__top-add-btn" id="nav__top-add-btn-js" src="images/add-icon.png" alt="カテゴリ追加画像">
                </div>
                <div class="nav__form-wrap" id="nav__form-wrap-add-js">
                    <form class="nav__form">
                        <input class="nav__form-input" id="word_id1" type="text" name="category">
                        <input id="word_id2" type="hidden" name="addCategory" value="addCategory">
                        <div class="nav__form-btn-wrap">
                            <button class="nav__form-btn" id="nav__form-btn-js">追加する</button>
                        </div>
                    </form>
                </div>
                <div class="nav__list-wrap" id="nav__list-wrap-js">
                    <?php if (!empty($category)) foreach ($category as $row) : ?>
                        <form class="nav__list-form" name="form1">
                            <input class="category_id" type="hidden" name="category_id" value="<?php echo $row["id"]; ?>">
                            <input class="category" type="hidden" name="category" value="<?php echo $row["category"]; ?>">
                            <a class="nav__list" href="javascript:form1.submit()">
                                <p class="nav__list-line">#</p>
                                <p class="nav__list-detail"><?php echo $row["category"]; ?></p>
                            </a>
                        </form>
                    <?php endforeach; ?>
                </div>
                <footer class="footer">
                    <small class="footer__detail">Copyright ©2020 StudyTube.</small>
                </footer>
            </div>
        </nav>
        <!-- nav End ▲-->

        <!-- main ▼-->
        <main class="content" id="content-js">
            <?php if (!empty($_POST)) : ?>
                <div class="content__heading-wrap">
                    <h1 class="content__heading"><?php echo "#  ", $_POST["category"]; ?></h1>
                    <div class="content__heading-edit-btn-wrap">
                        <button class="content__heading-edit-btn">一括編集</button>
                    </div>
                </div>
                <div class="grid">
                    <?php foreach ($movie as $row) : ?>
                        <div class="grid__item">
                            <div class="grid__item-movie">
                                <?php echo $row["link"]; ?>
                            </div>
                            <div class="grid__item-detail">
                                <h3 class="grid__item-detail-title"><?php echo $row["title"]; ?></h3>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
        <!-- main End ▲-->

    </div>

    <!-- add-movie ▼-->
    <div class="post" id="post-js">
        <img class="post__close-btn" id="post__close-btn-js" src="images/batu.png" alt="動画投稿画面を閉じるボタン">
        <form class="post__form" action="" method="post">
            <h4 class="post__form-title">動画投稿</h4>
            <div class="post__form-item">
                <p>タイトル</p>
                <input class="post__form-item-input" type="text" name="title" required="required">
            </div>
            <div class="post__form-item">
                <p>カテゴリ選択</p>
                <select class="post__form-item-select" name="category_id" required="required">
                    <?php foreach ($category as $row) : ?>
                        <option value="<?php echo $row["id"]; ?>"><?php echo $row["category"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="post__form-item">
                <p>リンク貼り付け</p>
                <textarea class="post__form-item-textarea" name="link" rows="10" required="required"></textarea>
            </div>
            <button class="post__form-btn" type="method">投稿する</button>
            <input class="addMovie" type="hidden" name="addMovie" value="addMovie">
        </form>
    </div>
    <!-- add-movie  End ▲-->

    <!-- account-menu ▼-->
    <div class="account-menu" id="account-menu-js">
        <a class="account-menu__list" href="">
            <img class="account-menu__list-icon" src="images/profile-icon.png" alt="">
            <p class="account-menu__list-detail">プロフィール変更</p>
        </a>
        <a class="account-menu__list account-menu__list--bottom" href="">
            <img class="account-menu__list-icon" src="images/logout-icon.png" alt="">
            <p class="account-menu__list-detail">ログアウト</p>
        </a>
        <a class="account-menu__list" href="">
            <img class="account-menu__list-icon" src="images/hatena-icon.png" alt="">
            <p class="account-menu__list-detail">ご利用ガイド</p>
        </a>
    </div>
    <!-- account-menu ▲-->

    <!-- edit-menu ▼-->
    <div class="edit-menu">
        <div class="edit-menu__heading">
            <div class="edit-menu__heading-detail"></div>
            <img class="edit-menu__heading-btn" src="" alt="">
        </div>
        <?php if (!empty($movie)) foreach ($movie as $row) : ?>
            <div class="edit-menu__list">
                <div class="edit-menu__list-detail"></div>
                <img class="edit-menu__list-btn" src="" alt="">
            </div>
        <?php endforeach; ?>
    </div>
    <!-- edit-menu End ▲-->

    <!-- scripts ▼-->
    <script src="scripts/jquery-3.5.1.min.js"></script>
    <script src="scripts/jquery-ui.min.js"></script>
    <script src="scripts/index.js"></script>
    <!-- scripts End ▲-->

</body>

</html>
