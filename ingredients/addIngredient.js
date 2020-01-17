$(document).ready(function() {
    $('#saveIngredientBtn').click(function() {

        var form = document.getElementById("ingredient-form");
        var data = new FormData(form);
        $.ajax({
            url: 'store_ingredient.php',
            type: 'POST',
            cache: false,
            data: data,
            processData: false,
            contentType: false,
            success: function() {
                location.reload(true);
                alert("Ingredient successfully added!");
            }
        }).fail(function(res) {
            if (res.status == 422) {
                if (res.responseJSON.name) {
                    $("#nameErrorPlaceholder").text(res.responseJSON.name[0])
                        .addClass("alert alert-danger mt-1");
                }
                if (res.responseJSON.description) {
                    $("#descriptionErrorPlaceholder").text(res.responseJSON.description)
                        .addClass("alert alert-danger mt-1");
                }
                if (res.responseJSON.unit) {
                    $("#unitErrorPlaceholder").text(res.responseJSON.unit)
                        .addClass("alert alert-danger mt-1");
                }
                if (res.responseJSON.amount) {
                    $("#amountErrorPlaceholder").text(res.responseJSON.amount)
                        .addClass("alert alert-danger mt-1");
                }
                if (res.responseJSON.image) {
                    $("#imageErrorPlaceholder").text(res.responseJSON.image[0])
                        .addClass("alert alert-danger mt-1");
                }
                alert("Something went wrong!");

            }

        });
    });
});