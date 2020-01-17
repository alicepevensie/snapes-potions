<?php

class IngredientValidator
{

    private $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }
    public function validateIngredient(array $data, array $files)
    {
        $errors = [];
        $errors['somethingWrong'] = false;
        if ($this->validateName($data['name']) === false) {
            $errors['name'][] = "Name not valid!";
            $errors['somethingWrong'] = true;
        }
        if ($this->ingredientExists($data['name']) === false) {
            $errors['name'][] = "That ingredient already exists!";
            $errors['somethingWrong'] = true;
        }
        if ($this->validateDescription($data['description']) === false) {
            $errors['description'] = "Description field can not be empty!";
            $errors['somethingWrong'] = true;
        }
        if ($this->validateAmount($data['amount']) === false) {
            $errors['amount'] = "Amount must be a whole number and can not be less than 0!";
            $errors['somethingWrong'] = true;
        }
        if ($this->validateUnit($data['unit']) === false) {
            $errors['unit'] = "Unit must be between 1-10 characters long!";
            $errors['somethingWrong'] = true;
        }
        if ($this->validateImage($files) === false) {
            $errors['image'][] = "Something wrong with provided image!";
            $errors['somethingWrong'] = true;
        }
        if ($this->repository->imageExists($files["image"]["name"])) {
            $errors['image'][] = "This image or the image with the same name already exists!";
            $errors['somethingWrong'] = true;
        }

        return $errors;
    }
    public function validateName($name)
    {
        if (strlen($name) <= 0 || strlen($name) > 254)
            return false;
        if (!preg_match("/^([a-zA-Z' ]+)$/", $name))
            return false;
    }
    public function ingredientExists($name)
    {
        if ($this->repository->ingredientExists($name))
            return false;
    }
    public function validateDescription($text)
    {
        if (strlen($text) <= 0)
            return false;
    }
    public function validateAmount($amount)
    {
        if (intval($amount) < 0)
            return false;
        if (!is_numeric($amount))
            return false;
    }
    public function validateUpdateAmount($amount)
    {
        if (!is_numeric($amount))
            return false;
    }
    public function validateUnit($unit)
    {
        if (strlen($unit) > 10 || strlen($unit) < 1)
            return false;
    }
    public function validateImage(array $files)
    {
        $target_dir = "../photos/ingredients";
        $target_file = $target_dir . basename($files["image"]["name"]);
        $uploadOk = true;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!$imageFileType) {
            $uploadOk = false;
        }
        if ($files["image"]["tmp_name"]) {
            $check = getimagesize($files["image"]["tmp_name"]);
            if ($check === false)
                $uploadOk = false;
        }
        if (file_exists($target_file))
            $uploadOk = false;

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif")
            $uploadOk = false;

        return $uploadOk;
    }
}
