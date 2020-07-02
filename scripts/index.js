// アカウント作成完了の通知
$(function noticeAccount() {
    $("#login-notice-js").fadeIn();
    $("#login-notice-js").on("click", function () {
        $("#login-notice-js").fadeOut(200);
    });
});

// ハンバーガーメニュー
$(function hamburgerMenu() {
    let cancelFlag = 0;
    $("#header__nav-btn-js").on("click", function () {
        if (cancelFlag == 0) {
            cancelFlag = 1;
            $("#nav-js").toggleClass("nav--close");
            $("#content-js").toggleClass("content--wide");
            setTimeout(function () {
                cancelFlag = 0;
            }, 200);
        };
    });
});

// カテゴリ名追加画面のオープン＆クローズ
$(function slideAddCategory() {
    let cancelFlag = 0;
    $("#nav__top-add-btn-js").on("click", function () {
        if (cancelFlag == 0) {
            cancelFlag = 1;
            $("#nav__form-wrap-add-js").slideToggle(200);
            setTimeout(function () {
                cancelFlag = 0;
            }, 200);
        };
    });
});

// 動画投稿画面のオープン
$(function openPostMovie() {
    let cancelFlag = 0;
    $("#header__post-btn-js").on("click", function () {
        if (cancelFlag == 0) {
            cancelFlag = 1;
            $("#post-js").fadeIn(200);
            $("#container-js").fadeOut(200);
            setTimeout(function () {
                cancelFlag = 0;
            }, 200);
        };
    });
});

// 動画投稿画面のクローズ
$(function closePostMovie() {
    let cancelFlag = 0;
    $("#post__close-btn-js").on("click", function () {
        if (cancelFlag == 0) {
            cancelFlag = 1;
            $("#post-js").fadeOut(200);
            $("#container-js").fadeIn(200);
            setTimeout(function () {
                cancelFlag = 0;
            }, 200);
        };
    });
});

// アカウントメニューのオープン＆クローズ
$(function slideAccountMenu() {
    let cancelFlag = 0;
    $("#header__user-icon-js").on("click", function () {
        if (cancelFlag == 0) {
            cancelFlag = 1;
            $("#account-menu-js").fadeToggle(200);
            setTimeout(function () {
                cancelFlag = 0;
            }, 200);
        };
    });
});

// ajaxでカテゴリ追加・参照
$(function editCategoryAjax() {
    $("#nav__form-btn-js").on("click", function (event) {

        // form送信処理をキャンセル
        event.preventDefault();

        // formの内容取得
        const word_val1 = $("#word_id1").val();
        const word_val2 = $("#word_id2").val();

        // ajax
        $.ajax({
            type: "POST",
            url: "./index.php",
            data: {
                "category": word_val1,
                "addCategory": word_val2,
            },
        }).done(function (data) {
            $("#nav__list-wrap-js").html($("#nav__list-wrap-js", data).html());
            $("#post__form-item-select-js").html($(".post__form-item-select", data).html());
        }).fail(function () {
            alert("リンク先に問題がありました。");
        });

        // 入力内容を削除
        $("#word_id1").val("");
    });
});

// ajaxでムービー参照
$(function findMovieAjax() {

    $(".nav__list").on('click', function (event) {

        // url送信処理を無効化
        event.preventDefault();

        // リンク先情報の取得
        const form = $(this).parent();
        const category_id_temp = form.find(".category_id");
        const category_id = category_id_temp.val();
        const category_temp = form.find(".category");
        const category = category_temp.val();

        // ajax
        $.ajax({
            type: 'POST',
            url: './index.php',
            data: {
                'category_id': category_id,
                'category': category
            },
        }).done(function (data) {
            $("#content-js").html($("#content-js", data).html());
        }).fail(function () {
            alert('リンク先に問題がありました。');
        });
    });
});

// ajaxでムービー追加
$(function addMovieAjax() {
    $(".post__form-btn").on('click', function (event) {

        // form送信処理をキャンセル
        event.preventDefault();

        //
        $("#post-js").fadeOut(200);
        $("#container-js").fadeIn(200);

        // formの内容取得
        const title = $(".post__form-item-input").val();
        const category_id = $(".post__form-item-select").val();
        const link = $(".post__form-item-textarea").val();
        const addMovie = $(".addMovie").val();

        // ajax
        $.ajax({
            type: 'POST',
            url: './index.php',
            data: {
                'title': title,
                'category_id': category_id,
                'link': link,
                'addMovie': addMovie
            },
        }).done(function (data) {
            $(".grid").html($(".grid", data).html());
        }).fail(function () {
            alert('リンク先に問題がありました。');
        });

        // 入力内容を削除
        $(".post__form-item-input").val('');
        $(".post__form-item-textarea").val('');

    });
});
