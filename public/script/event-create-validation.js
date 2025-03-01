$(document).ready(function () {
    // バリデーションの結果を追跡するオブジェクト
    var validationResults = {
        name: false,
        detail: false,
        category: true,
        date: false,
        deadline_date: false,
        place: false,
        number_of_recruits: false,
        image_path: false,
    };

    //一度blurさせてバリデーションを実行
    $("#category").blur();

    // 送信ボタンを無効にする
    $('button[type="submit"]').prop("disabled", true);

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

    function validateDateAndDeadline() {
        var date = $("#date").val();
        var dateObj = new Date(date);
        var deadline = $("#deadline_date").val();
        var deadlineObj = new Date(deadline);
        var now = new Date();
        now.setHours(0, 0, 0, 0);

        if (date === "") {
            showError($("#date"), "日付は必須です。");
            validationResults.date = false;
        } else if (dateObj < now) {
            showError($("#date"), "未来の日付を選択してください。");
            validationResults.date = false;
        } else {
            removeError($("#date"));
            validationResults.date = true;
        }

        if (deadline === "") {
            showError($("#deadline_date"), "締切日は必須です。");
            validationResults.deadline_date = false;
        } else if (deadlineObj < now) {
            showError($("#deadline_date"), "未来の日付を選択してください。");
            validationResults.deadline_date = false;
        } else if (deadlineObj >= dateObj) {
            showError(
                $("#deadline_date"),
                "締切日はイベント開始日より前に設定してください。"
            );
            validationResults.deadline_date = false;
        } else {
            removeError($("#deadline_date"));
            validationResults.deadline_date = true;
        }

        checkValidation();
    }

    $("#date").blur(validateDateAndDeadline);
    $("#date").change(validateDateAndDeadline);
    $("#deadline_date").blur(validateDateAndDeadline);
    $("#deadline_date").change(validateDateAndDeadline);

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

    $("#image_path").change(function () {
        var file = $(this).prop("files")[0];
        var fileExt = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        if (file === undefined) {
            showError($(this), "画像ファイルは必須です。");
            validationResults.image_path = false;
        } else if (file.size > 5000000) {
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

    function showError(element, message) {
        removeError(element);
        element.after(
            '<span class="error" style="color: red;">' + message + "</span>"
        );
    }

    function removeError(element) {
        element.next(".error").remove();
    }

    function checkValidation() {
        // 全てのバリデーションが成功したかどうかを確認

        console.log(validationResults);

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
