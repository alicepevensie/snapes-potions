<?php
require_once "../ingredients/ingredient_repository.php";
class RecipeStorage{
    private $repository;
    private $validator;

    public function __construct($repository, $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function storeRecipe($data)
    {
        $ingredientRep = new IngredientRepository($this->repository->getDb());
        $errorsIngredients = $this->validator->validateRecipeIngredients($data, $ingredientRep);

        $errorsInstructions = $this->validator->validateRecipeInstructions($data);

        if($errorsIngredients['allGood'] === false){
            return $errorsIngredients;
        }
        if($errorsInstructions['allGood'] === false){
            return $errorsInstructions;
        }

        if($this->repository->recipeExists($data['potionName'])){
            $errors['allGood'] = false;
            $errors['recipeExists'] = "The recipe for this potion already exists!";
            return $errors;
        }

        $recipeIngredients = $errorsIngredients['recipeIngredients'];
        $recipeInstructions = $errorsInstructions['recipeInstructions'];
        $potion = $data['potionName'];
        foreach($recipeIngredients as $recipeIngredient){
            $this->repository->addIngredientForPotion($potion, $recipeIngredient);
        }
        foreach($recipeInstructions as $recipeInstruction){
            $this->repository->addInstructionForPotion($potion, $recipeInstruction);
        }
        $errors['allGood'] = true;
        $errors['success'] = "Recipe added successfully";
        return $errors;


        
    }
}