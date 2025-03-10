$(document).ready(function () {
    // バリデーションの結果を追跡するオブジェクト
    var validationResults = {
        name: true,
        detail: true,
        category: true,
        tag: true,
        participation_condition: true,
        external_link: true,
        place: true,
        number_of_recruits: true,
        image_path: true,
    };

    // イベント名
    $("#name").blur(function () {
        var name = $(this).val();
        if (name === "") {
            showError($(this), "イベント名は必須です。");
            validationResults.name = false;
        } else if (name.length > 20) {
            showError($(this), "イベント名は20文字以下である必要があります。");
            validationResults.name = false;
        } else {
            removeError($(this));
            validationResults.name = true;
        }
        checkValidation();
    });

    // 詳細
    $("#detail").blur(function () {
        var detail = $(this).val();
        if (detail === "") {
            showError($(this), "詳細は必須です。");
            validationResults.detail = false;
        } else if (detail.length > 1000) {
            showError($(this), "詳細は1000文字以下である必要があります。");
            validationResults.detail = false;
        } else {
            removeError($(this));
            validationResults.detail = true;
        }
        checkValidation();
    });

    // カテゴリ
    $("#category").blur(function () {
        var category = $(this).val();
        if (category === "") {
            showError($(this), "カテゴリは必須です。");
            validationResults.category = false;
        } else {
            removeError($(this));
            validationResults.category = true;
        }
        checkValidation();
    });

    // 場所
    $("#place").blur(function () {
        var place = $(this).val();
        if (place === "") {
            showError($(this), "場所は必須です。");
            validationResults.place = false;
        } else if (place.length > 50) {
            showError($(this), "場所は50文字以下である必要があります。");
            validationResults.place = false;
        } else {
            removeError($(this));
            validationResults.place = true;
        }
        checkValidation();
    });

    // 募集人数
    $("#number_of_recruits").blur(function () {
        var number = $(this).val();
        if (number === "") {
            showError($(this), "募集人数は必須です。");
            validationResults.number_of_recruits = false;
        } else if (isNaN(number) || parseInt(number) < 1) {
            showError($(this), "募集人数は1以上の数値である必要があります。");
            validationResults.number_of_recruits = false;
        } else {
            removeError($(this));
            validationResults.number_of_recruits = true;
        }
        checkValidation();
    });

    // 画像
    $("#image_path").change(function () {
        var file = $(this).prop("files")[0];
        var fileExt = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        if (file.size > 5000000) {
            // 5MB
            showError($(this), "画像ファイルは5MB以下である必要があります。");
            validationResults.image_path = false;
        } else if (!fileExt.exec(file.name)) {
            showError(
                $(this),
                "有効な画像形式をアップロードしてください（jpg, jpeg, png, gif）。"
            );
            validationResults.image_path = false;
        } else {
            removeError($(this));
            validationResults.image_path = true;
        }
        checkValidation();
    });

    // エラーメッセージの表示と削除のための関数
    function showError(element, message) {
        removeError(element);
        element.after(
            '<span class="error" style="color: red;">' + message + "</span>"
        );
    }

    function removeError(element) {
        element.next(".error").remove();
    }

    // 全てのバリデーションが成功したかどうかを確認
    function checkValidation() {
        var allValid = Object.values(validationResults).every(function (
            result
        ) {
            return result;
        });

        if (allValid) {
            // 全てのバリデーションが成功した場合、送信ボタンを有効にする
            $('button[type="submit"]').prop("disabled", false);
        } else {
            // 一つでもバリデーションに失敗していたら、送信ボタンを無効にする
            $('button[type="submit"]').prop("disabled", true);
        }
    }
});
