<?php

class PotionsForPageService{
    private $repository;
    private $validator;

    public function __construct($repository, $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
    public function potionsForPage($offset, $potionsPerPage, $category)
    {
        if($this->validator->validateCategory($category)){
            return $this->repository->categorizedPotionsForPage($offset, $potionsPerPage, $category);
        }
        return $this->repository->potionsForPage($offset, $potionsPerPage);
    }
}