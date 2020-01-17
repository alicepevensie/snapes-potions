<?php
class LoginService
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
    public function logIn(array $data)
    {
        $possibleId = $this->repository->userValid($data['username'], MD5($data['password']));
        if ($possibleId) {
            return $possibleId;
        } else {
            return false;
        }
    }
}
