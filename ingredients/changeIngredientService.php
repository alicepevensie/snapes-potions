<?php

require_once "../ingredients/ingredient.php";
require_once "../recipes/recipe_repository.php";
require_once "../potions/potion_repository.php";
class ChangeIngredientService
{

    private $repository;
    private $validator;
    public function __construct($repository, $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
    public function changeAmount($data)
    {
        if ($this->repository->ingredientExists($data['name']) === false) {
            return false;
        }
        if (!$this->validator->validateUpdateAmount($data['amount']) === false) {
            return false;
        }
        $ingredient = $this->repository->selectIngredient($data['name']);
        if ((intval($ingredient->getAmount()) + intval($data['amount'])) < 0)
            return false;
        $this->repository->updateAmount($ingredient, $data['amount']);
        return true;
    }
    public function storeIngredient($data, $files)
    {
        $feedback = $this->validator->validateIngredient($data, $files);
        if ($feedback['somethingWrong']) {
            return $feedback;
        }

        $image = $this->addPhoto($data['name'], $files);
        $ingredient = new Ingredient(
            $data['name'],
            $image,
            $data['description'],
            $data['amount'],
            $data['unit'],
        );
        $this->repository->add($ingredient);
        return $feedback;
    }
    public function prevValues($data)
    {
        return $prevData = $data;
    }

    public function addPhoto($name, $files)
    {

        $photo = $files["image"]["name"];
        $file_ext = strtolower(substr($photo, strripos($photo, '.')));
        $newfilename = MD5($name) . $file_ext;
        move_uploaded_file($files["image"]["tmp_name"], "../photos/ingredients/{$newfilename}");
        return $newfilename;
    }
    public function removeFromStock($potionName, $amount)
    {
        $allGood = true;
        $potionRep = new PotionRepository($this->repository->getDb());
        $recipeRep = new RecipeRepository($this->repository->getDb());
        if ($potionRep->potionExists($potionName) === false) {
            $allGood = false;
            return $allGood;
        }

        if (!is_numeric($amount)) {
            $allGood = false;
            return $allGood;
        }
        if (intval($amount) <= 0) {
            $allGood = false;
            return $allGood;
        }

        $ingredientsForPotion = $recipeRep->getIngredientsForPotion($potionName);
        foreach ($ingredientsForPotion as $ingredientForPotion) {
            $ingredient = $this->repository->selectIngredient($ingredientForPotion->getIngredient_name());
            $newAmount = intval($ingredientForPotion->getIngredient_amount()) * intval($amount);
            if ($ingredient->getAmount() < $newAmount) {
                $allGood = false;
                return $allGood;
            }
            $newAmount = $newAmount * (-1);
            $this->repository->updateAmount($ingredient, $newAmount);
            return $allGood;
        }
    }
}
