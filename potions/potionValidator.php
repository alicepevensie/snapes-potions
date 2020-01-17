<?php

class PotionValidator
{
    private $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }
    public function validatePotion(array $data, array $files)
    {
        $errors = [];
        $errors['somethingWrong'] = false;
        if ($this->validateName($data['name']) === false) {
            $errors['name'] = "Name not valid!";
            $errors['somethingWrong'] = true;
        }
        if ($this->nameExists($data['name']) === false) {
            $errors['nameExists'] = "That potion already exists!";
            $errors['somethingWrong'] = true;
        }
        if ($this->validateDescriptionEffect($data['description']) === false) {
            $errors['description'] = "Description field can not be empty!";
            $errors['somethingWrong'] = true;
        }
        if ($this->validateDescriptionEffect($data['effect']) === false) {
            $errors['effect'] = "Effect field can not be empty!";
            $errors['somethingWrong'] = true;
        }
        if ($this->validateCategory($data['category']) === false) {
            $errors['category'] = "Category field can not be empty!";
            $errors['somethingWrong'] = true;
        }
        if ($this->validateAmount($data['amount']) === false) {
            $errors['amount'] = "Amount must be a whole number and can not be less than 0!";
            $errors['somethingWrong'] = true;
        }
        if ($this->validateImage($files) === false) {
            $errors['image'] = "Something wrong with provided image!";
            $errors['somethingWrong'] = true;
        }
        if($this->repository->imageExists($files["image"]["name"])){
            $errors['imageExists'] = "This image or the image with the same name already exists!";
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
    public function nameExists($name)
    {
        if ($this->repository->potionExists($name))
            return false;
    }
    public function validateDescriptionEffect($text)
    {
        if (strlen($text) <= 0)
            return false;
    }
    public function validateCategory($category)
    {
        $categories = [
            "potion", "draught", "antidote", "elixir", "paste", "pomade",
            "secretion", "balm", "solution", "essence", "mixture", "gas",
            "concoction", "unclassified"
        ];
        return in_array($category, $categories, true);
    }
    public function validateAmount($amount)
    {
        if (intval($amount) < 0)
            return false;
        if (!is_numeric($amount))
            return false;
    }
    public function validateImage(array $files)
    {
        $target_dir = "../photos/potions";
        $target_file = $target_dir . basename($files["image"]["name"]);
        $uploadOk = true;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if(!$imageFileType){
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
