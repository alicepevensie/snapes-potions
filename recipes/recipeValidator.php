<?php
require_once "./recipeIngredient.php";
require_once "./recipeInstruction.php";
class RecipeValidator
{

    public function validateRecipeIngredients($data, $ingredientRep)
    {
        $errors = [];
        $errors['allGood'] = true;
        $ingredients = $data['ingredients'];
        $amounts = $data['ingredientAmounts'];
        if (count($ingredients) != count($amounts)) {
            $errors['missmatch'] = "You have missmatching ingredients and amounts!";
            $errors['allGood'] = false;
        }
        if (count($ingredients)<=0 || count($amounts)<=0) {
            $errors['addOne'] = "You have to add at least one ingredient!";
            $errors['allGood'] = false;
        }
        foreach ($ingredients as $ingredient) {
            if ($ingredientRep->ingredientExists($ingredient) === false) {
                $errors['nonExistentIngredient'] = "$ingredient you selected doesn't exist (somehow)!";
                $errors['allGood'] = false;
            }
        }
        foreach($amounts as $amount){
            if(!is_numeric($amount)){
                $errors['amountError'][] = "HOW DID YOU ENTER SOMETHING THAT IS NOT A NUMBER??";
                $errors['allGood'] = false;
            }
            $amount = intval($amount);
            if($amount<=0){
                $errors['amountError'][] = "Amount mustn't be less than 1!";
                $errors['allGood'] = false;
            }
        }
        $recipeIngredients = [];
        for($i = 0; $i<count($ingredients); $i++){
            $recipeIngredient = new RecipeIngredient($ingredients[$i], $amounts[$i]);
            $recipeIngredients[] = $recipeIngredient;
        }
        $errors['recipeIngredients'] = $recipeIngredients;
        return $errors;
    }
    public function validateRecipeInstructions($data)
    {
        $errors = [];
        $errors['allGood'] = true;
        $instructions = $data['instructionInput'];
        if(count($instructions)<=0){
            $errors['addOnePls'] = "You must add at least one instruction!";
            $errors['allGood'] = false;
        }
        foreach ($instructions as $instruction) {
            if(strlen($instruction)<=10){
                $errors['instructionLength'] = "Instruction must be at least 10 characters long!";
                $errors['allGood'] = false;
            }
        }
        $recipeInstructions = [];
        for($i = 0; $i<count($instructions); $i++){
            $recipeInstruction = new RecipeInstruction($i+1, $instructions[$i]);
            $recipeInstructions[] = $recipeInstruction;
        }
        $errors['recipeInstructions'] = $recipeInstructions;
        return $errors;
    }
}
