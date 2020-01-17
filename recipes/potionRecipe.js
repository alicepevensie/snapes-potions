$(document).ready(function () {
    var calculateIngredients = $("#calculateIngredients");
    var table = $("#ingredientTable");
    var rows = table.find("tbody").find("tr");
    calculateIngredients.click(function () {
        let potionAmount = $("#potionAmount").val();
        rows.each(function () {
            let ingAmount = $(this).find("td:eq(1)").text();
            let ingAmountCalc = ingAmount * potionAmount;
            $(this).find("td:last").text(ingAmountCalc);
        });
    });

    var addPotionsBtn = $("#addPotionsBtn");
    addPotionsBtn.click(function(){
        let potionAmount = $("#potionAmount").val();
        let potionName = $("#potionName").val();
        
        data = {
            name: potionName,
            amount: potionAmount,
        }

        $.post("./potions/updatePotion.php", data, function(response){
            alert("You have successfully added "+response.amount+" new potion/s!");
        }).fail(res){
            alert("Something went wrong!");
        };

    })

    var form = $("#recipeForm");
    form.hide();
    $("#addRecipeBtn").click(function () {
        form.toggle();
    });
    var addBtn = $("#addIngredientBtn");
    addBtn.click(function () {

        //making dropdown list and input amount field for every new ingredient
        var wrapper = $("#wrapper");
        let divDropdown = $("<div></div>");
        divDropdown.addClass("form-group");
        divDropdown.attr("id", "dropdownDiv");
        let labelSelect = $("<label></label>");
        labelSelect.attr("id", "ingredients");
        labelSelect.text("Select ingredient:");
        let dropdown = $("<select></select>");
        dropdown.addClass("form-control");
        dropdown.attr("id", "ingredients");
        dropdown.attr("name", "ingredients[]");
        divDropdown.append(labelSelect);
        //populating dropdown list
        $.ajax({
            url: 'getIngredientsForDropdown.php',
            type: 'post',
            data: { ingredients: 1 },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                dropdown.empty();
                for (var i = 0; i < len; i++) {
                    var name = response[i]['name'];
                    var unit = response[i]['unit'];
                    dropdown.append("<option value='" + name + "'>" + "Name: " + name + " / Unit: " + unit + "</option>");

                }
            }
        });
        divDropdown.append(dropdown);



        let divAmount = $("<div></div>");
        divAmount.addClass("form-group");
        divAmount.attr("id", "amountDiv");

        let labelAmount = $("<label></label>");
        labelAmount.text("Needed amount of the selected ingredient:");
        labelAmount.attr("id", "ingredientAmount");
        let inputAmount = $("<input/>");
        inputAmount.addClass("form-control");
        inputAmount.attr("id", "ingredientAmount");
        inputAmount.attr("type", "number");
        inputAmount.attr("name", "ingredientAmounts[]");
        inputAmount.attr("min", "1");
        inputAmount.attr("step", "1");
        divAmount.append(labelAmount);
        divAmount.append(inputAmount);

        wrapper.append(divDropdown);
        wrapper.append(divAmount);

    });

    //removing last ingredient added
    var removeIngredient = $("#removeIngredientBtn");
    removeIngredient.click(function () {
        var wrapper = $("#wrapper");
        let dropdownDiv = wrapper.find("#dropdownDiv:last");
        let amountDiv = wrapper.find("#amountDiv:last");
        dropdownDiv.remove();
        amountDiv.remove();
    });


});