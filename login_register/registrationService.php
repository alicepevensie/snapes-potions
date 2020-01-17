<?php
require_once "../users/user.php";

class RegistrationService
{

    private $repository;
    private $validator;
    public function __construct($repository, $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function register($data)
    {
        $feedback = $this->validator->validateUser($data);
        if ($feedback['somethingWrong'] === true) {
            return $feedback;
        }
        $user = new User(
            null,
            $data['name'],
            $data['surname'],
            $data['username'],
            $data['birthdate'],
            null,
            $data['house'],
            $data['status'],
            0
        );
        $password = MD5($data['password']);
        $this->repository->add($user, $password);
        return $feedback;
    }
}
