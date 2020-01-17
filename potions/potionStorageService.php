<?php
require_once "potion.php";
class PotionStorageService
{

    private $repository;
    private $validator;

    public function __construct($repository, $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function storePotion($data, $files)
    {
        $feedback = $this->validator->validatePotion($data, $files);
        if ($feedback['somethingWrong']) {
            return $feedback;
        }

        $image = $this->addPhoto($data['name'], $files);
        $potion = new Potion(
            $data['name'],
            $image,
            $data['description'],
            $data['effect'],
            $data['category'],
            $data['amount'],
        );
        $this->repository->add($potion);
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
        move_uploaded_file($files["image"]["tmp_name"], "../photos/potions/{$newfilename}");
        return $newfilename;
    }
}
