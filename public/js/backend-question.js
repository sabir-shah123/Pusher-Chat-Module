const baseUrl = $("meta[name='baseUrl']").attr("content");

$(document).on("click", ".mark-correct", function () {
    let elm = $(this);
    let parent = elm.closest(".row");
    let close_parent = elm.closest(".form-group");
    parent.find(".form-group textarea").removeClass("bg-success");
    parent.find('[type="hidden"]').val("0");
    close_parent.find("textarea").addClass("bg-success");
    close_parent.find('[type="hidden"]').val("1");
});

function checkQuestionValidation(elm) {
    if (elm.find(".not-valid-elm").length > 0) {
        elm.find(".error").show();
    } else {
        elm.find(".error").hide();
    }
}

function calcTotalScore(get = false) {
    var sum = 0;
    $(".score").each(function (index, element) {
        sum += +$(this).val();
    });

    if (get) {
        return sum;
    }
    $(".total-score span").html(sum);
}

$(".question-body").on("shown.bs.collapse", function () {
    var target = $(this).find("textarea").attr("id");
    initTinymice("#" + target);
});

$(".question-body").on("hidden.bs.collapse", function () {
    var target = $(this).find("textarea").attr("id");
    destroyTinymice("#" + target);
});

$(document).on("keyup blur", ".score", function () {
    let elm = $(this);
    let parent = elm.closest(".question-wrapper");

    if (elm.val().length > 0) {
        elm.removeClass("not-valid-elm");
        elm.removeClass("error-border");
    } else {
        if (!elm.hasClass("not-valid-elm")) {
            elm.addClass("not-valid-elm");
        }
        elm.addClass("error-border");
    }

    checkQuestionValidation(parent);
    calcTotalScore();
});

$(document).on("keyup blur", ".options", function () {
    let elm = $(this);
    let parent = elm.closest(".question-wrapper");

    if (elm.val().length > 0) {
        elm.removeClass("not-valid-elm");
        elm.removeClass("error-border");
    } else {
        if (!elm.hasClass("not-valid-elm")) {
            elm.addClass("not-valid-elm");
        }
        elm.addClass("error-border");
    }

    checkQuestionValidation(parent);
});

$(document).on("click", ".question-save", function (e) {
    e.preventDefault();
    let elm = $(this);
    let parent = elm.closest(".question-wrapper");

    let title = tinymce.get("title_" + parent.data("seq")).getContent().length;
    let correct = parent.find(".bg-success").length;
    let nonValidElm = parent.find(".not-valid-elm").length;

    if (title > 0 && correct > 0 && nonValidElm == 0) {
        if (!parent.hasClass("valid")) {
            parent.addClass("valid");

            parent.find(".card-header").removeClass("bg-danger");
            parent.find(".error").hide();
        }
    } else {
        parent.find(".card-header").addClass("bg-danger");
        parent.find(".error").show();
        parent.removeClass("valid");
    }

    if (parent.hasClass("valid")) {
        var values = parent.find("form").serializeArray();
        values.find((input) => input.name == "title").value = tinymce
            .get("title_" + parent.data("seq"))
            .getContent();

        values = jQuery.param(values);
        values += "&total_score=" + calcTotalScore(true);
        $.ajax({
            type: "POST",
            url: "/admin/questions/save",
            data: values,
            success: function (response) {
                if (response.statusCode == 200) {
                    toastr.success(response.message);
                    parent.find("[name='test_question_id']").val(response.data);
                } else {
                    toastr.error("Something went wrong!");
                }
            },
            error: function (xhr, status, error) {
                toastr.error("Something went wrong!");
            },
        });
    }
});
