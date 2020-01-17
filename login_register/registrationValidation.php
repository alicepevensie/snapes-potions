<?php
class RegistrationValidator
{
    private $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }
    public function validateUser(array $data)
    {
        $feedback = [];
        $feedback['somethingWrong'] = false;
        if ($this->checkNameSurname($data['name']) === false) {
            $feedback['name'] = "Name not valid";
            $feedback['somethingWrong'] = true;
        }
        if ($this->checkNameSurname($data['surname']) === false) {
            $feedback['surname'] = "Surname not valid";
            $feedback['somethingWrong'] = true;
        }
        if ($this->checkUsername($data['username']) === false) {
            $feedback['username'] = "Username not valid";
            $feedback['somethingWrong'] = true;
        }
        if($this->repository->usernameExists($data['username'])){
            $feedback['usernameExists'] = "Username already exists!";
            $feedback['somethingWrong'] = true;
        }
        if ($this->passwordStrong($data['password']) === false) {
            $feedback['password'] = "Password is not strong enough";
            $feedback['somethingWrong'] = true;
        }
        if ($this->passwordConfirm($data['password'], $data['passwordConfirm']) === false) {
            $feedback['passwordMatch'] = "Passwords don't match";
            $feedback['somethingWrong'] = true;
        }
        if ($this->houseCheck($data['house']) === false) {
            $feedback['house'] = "House not valid";
            $feedback['somethingWrong'] = true;
        }
        if ($this->statusCheck($data['status']) === false) {
            $feedback['status'] = "Status not valid";
            $feedback['somethingWrong'] = true;
        }

        return $feedback;
    }
    public function checkNameSurname($name)
    {
        if (strlen($name) <= 0 || strlen($name) > 20)
            return false;
        if (!preg_match("/^([a-zA-Z' ]+)$/", $name))
            return false;
    }
    public function checkUsername($username)
    {
        if (strlen($username) <= 0 || strlen($username) > 20)
            return false;
    }
    public function passwordStrong($password)
    {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8)
            return false;
    }
    public function passwordConfirm($password, $password2)
    {
        if ($password === $password2)
            return true;
        else
            return false;
    }
    public function statusCheck($status)
    {
        if ($status === 'Student' || $status === 'Professor' || $status === 'Other')
            return true;
        else
            return false;
    }
    public function houseCheck($house)
    {
        if ($house === 'Slytherin' || $house === 'Ravenclaw' || $house === 'Hufflepuff' || $house === 'Gryffindor')
            return true;
        else
            return false;
    }
}
