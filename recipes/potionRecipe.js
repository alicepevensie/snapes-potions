$(document).ready(function () {
    var calculateIngredients = $("#calculateIngredients");
    var table = $("#ingredientTable");
    var rows = table.find("tbody").find("tr");
    calculateIngredients.click(function () {
        let potionAmount = $("#potionAmount").val();
        rows.each(function () {
            let ingName = $(this).find("td:eq(0)").text();
            let ingAmount = $(this).find("td:eq(1)").text();
            let ingAmountCalc = ingAmount * potionAmount;
            data = {
                ingName: ingName,
                ingAmountCalc: ingAmountCalc,
            }
            let last = $(this).find("td:last");
            $.post("../ingredients/checkIngredients.php", data, function (response) {
                last.text(response.newAmount);

            });
        });
    });


    //update potions and ingredinents amount
    var addPotionsBtn = $("#addPotionsBtn");
    addPotionsBtn.click(function () {
        let potionAmount = $("#potionAmount").val();
        let potionName = $("#potionName2").val();

        data = {
            name: potionName,
            amount: potionAmount,
        }

        $.post("../potions/updatePotion.php", data, function (response) {
            alert("You have successfully added " + response.amount + " new potion/s!");
        }).fail(function (res) {
            alert("Something went wrong!");
        });




    })

    //toggle form
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

    //adding new instructions

    var instructionWrapper = $("#instructionsWrapper");
    var addInstructionBtn = $("#addInstructionBtn");
    addInstructionBtn.click(function () {
        let divInstruction = $("<div></div>");
        divInstruction.addClass("form-group");
        divInstruction.attr("id", "instructionDiv");

        let labelInstruction = $("<label></label>");
        labelInstruction.text("Enter an instruction for making this potion:");
        labelInstruction.attr("id", "instructionInput");
        let instructionInput = $("<textarea></textarea>");
        instructionInput.addClass("form-control");
        instructionInput.attr("id", "instructionInput");
        instructionInput.attr("name", "instructionInput[]");
        divInstruction.append(labelInstruction);
        divInstruction.append(instructionInput);

        instructionWrapper.append(divInstruction);
    });

    //removing last instruction added
    var removeInstruction = $("#removeInstructionBtn");
    removeInstruction.click(function () {
        let instructionDiv = instructionWrapper.find("#instructionDiv:last");
        instructionDiv.remove();
    });

    //show and hide instructions/ingredients
    var toggleIngredients = $("#toggleIngredientsBtn");
    var toggleInstructions = $("#toggleInstructionsBtn");
    var instructionsPart = $("#instructionsSection");
    var wrapper = $("#bigWrapper");
    instructionsPart.hide();
    toggleIngredients.click(function () {
        wrapper.toggle();
    });
    toggleInstructions.click(function () {
        instructionsPart.toggle();
    })

});