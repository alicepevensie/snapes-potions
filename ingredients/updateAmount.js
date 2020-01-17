$(document).ready(function() {
    var amountUpdate = $(".update-amount");
    amountUpdate.hide();
    $('.updateBtn').click(function() {
        let updateBtn = $(this);
        let updateDiv = $(updateBtn).closest('td').find(".update-amount");
        updateDiv.show();
        $(updateBtn).hide();
        let saveBtn = $(updateBtn).closest('tr').find("td:last").find("#updateAmountBtn");
        saveBtn.click(function() {
            let inputAmount = saveBtn.closest('div').find("#updateAmountInput").val();
            let ingredient = saveBtn.closest('tr').find('td:eq(1)').text();
            let page = $("#pagination").find(".page-item.active").find(".page-link").text();
            let data = {
                name: ingredient,
                amount: inputAmount,
                page: page,

            };
            updateDiv.hide();
            $(updateBtn).show();
            $.post("updateAmount.php", data, function(response) {
                window.location = "ingredients.php?page=" + response.page;
            }).fail(function(res) {
                if (res.status == 422) {
                    alert("Something went wrong!");
                }
            });
        });
        let cancelBtn = $(updateBtn).closest('tr').find("td:last").find("#cancelBtn");
        cancelBtn.click(function(){
            updateDiv.hide();
            updateBtn.show();
        })
    });
});