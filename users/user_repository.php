<?php

require_once "user.php";
class UserRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function numberOfUsers()
    {
        $sql = "SELECT COUNT(*) FROM users";
        $result = $this->db->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }
    public function getAll()
    {
        $sql = "SELECT * FROM users";
        $result = $this->db->query($sql);
        if ($result === false) {
            die($this->db->error);
        }
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $user = new User(
                intval($row['id']),
                $row['name'],
                $row['surname'],
                $row['username'],
                $row['birth_date'],
                $row['created_at'],
                $row['house'],
                $row['status'],
                $row['access'],
            );
            $users[] = $user;
        }

        return $users;
    }
    public function selectUser($userId)
    {
        $userId = $this->db->real_escape_string($userId);
        $sql = "SELECT * FROM users WHERE id='$userId'";
        $result = $this->db->query($sql);
        if ($result === false) {
            die($this->db->error);
        }
        $row = $result->fetch_row();
        $user = new User(
            intval($row[0]),
            $row[1],
            $row[2],
            $row[3],
            $row[4],
            $row[5],
            $row[6],
            $row[7],
            $row[8],
        );
        return $user;
    }
    public function userExists($userId)
    {
        $userId = $this->db->real_escape_string($userId);

        $sql = "SELECT COUNT(1) FROM users WHERE id='$userId'";
        $result = $this->db->query($sql);
        $row = $result->fetch_row();
        if ($row[0] >= 1) {
            return true;
        } else {
            return false;
        }
    }
    public function usernameExists($username)
    {
        $username = $this->db->real_escape_string($username);
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = $this->db->query($sql);
        $row = $result->fetch_row();
        if ($row[0] >= 1) {
            return true;
        } else {
            return false;
        }
    }
    public function userValid($username, $password)
    {
        $username = $this->db->real_escape_string($username);
        $password = $this->db->real_escape_string($password);
        $sql = "SELECT * FROM users WHERE username='$username' and `password`='$password'";
        $result = $this->db->query($sql);
        $row = $result->fetch_row();
        if ($row[0] >= 1) {
            return $row[0];
        } else {
            return false;
        }
    }
    public function usersForPage($offset, $usersPerPage)
    {
        $offset = $this->db->real_escape_string($offset);
        $usersPerPage = $this->db->real_escape_string($usersPerPage);
        $sql = "SELECT * FROM users ORDER BY `created_at` DESC LIMIT $offset, $usersPerPage";
        $result = $this->db->query($sql);
        if ($result === false) {
            die($this->db->error);
        }
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $user = new User(
                intval($row['id']),
                $row['name'],
                $row['surname'],
                $row['username'],
                $row['birth_date'],
                $row['created_at'],
                $row['house'],
                $row['status'],
                $row['access'],
            );
            $users[] = $user;
        }

        return $users;
    }
    public function add($user, $password)
    {
        $user->setName($this->db->real_escape_string($user->getName()));
        $user->setSurname($this->db->real_escape_string($user->getSurname()));
        $user->setUsername($this->db->real_escape_string($user->getUsername()));
        $user->setBirth_date($this->db->real_escape_string($user->getBirth_date()));
        $user->setHouse($this->db->real_escape_string($user->getHouse()));
        $user->setStatus($this->db->real_escape_string($user->getStatus()));
        $user->setAccess($this->db->real_escape_string(0));
        $password = $this->db->real_escape_string($password);
        $sql = "INSERT INTO `users` (`id`, `name`, `surname`, `username`, `birth_date`, `created_at`, `house`, `status`, `access`, `password`)"
            . "VALUES (NULL, '{$user->getName()}', '{$user->getSurname()}', '{$user->getUsername()}', '{$user->getBirth_date()}', CURRENT_DATE(), '{$user->getHouse()}', '{$user->getStatus()}', '{$user->getAccess()}', '{$password}')";
        $result = $this->db->query($sql);
        if ($result === FALSE) {
            die($this->db->error);
        }

        $user->setId($this->db->insert_id);
    }
    public function grantAccess($user)
    {
        $user->setId($this->db->real_escape_string($user->getId()));
        $sql = "UPDATE users SET access = 1 WHERE id = {$user->getId()}";
        $result = $this->db->query($sql);
        if ($result === FALSE) {
            die($this->db->error);
        }
        $user->setAccess(1);
    }
    public function revokeAccess($user)
    {
        $user->setId($this->db->real_escape_string($user->getId()));
        $sql = "UPDATE users SET access = 0 WHERE id = {$user->getId()}";
        $result = $this->db->query($sql);
        if ($result === FALSE) {
            die($this->db->error);
        }
        $user->setAccess(1);
    }
}
