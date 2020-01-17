<?php

require_once "./ingredient.php";
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
        if((intval($ingredient->getAmount())+intval($data['amount']))<0)
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
}
