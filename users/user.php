<?php


class User
{
    private $id;
    private $name;
    private $surname;
    private $username;
    private $birth_date;
    private $created_at;
    private $house;
    private $status;
    private $access;


    public function __construct($id, $name, $surname, $username, $birth_date, $created_at, $house, $status, $access)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->username = $username;
        $this->birth_date = $birth_date;
        $this->created_at = $created_at;
        $this->house = $house;
        $this->status = $status;
        $this->access = $access;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of surname
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set the value of surname
     *
     * @return  self
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get the value of username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of birth_date
     */
    public function getBirth_date()
    {
        return $this->birth_date;
    }

    /**
     * Set the value of birth_date
     *
     * @return  self
     */
    public function setBirth_date($birth_date)
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    /**
     * Get the value of created_at
     */
    public function getCreated_at()
    {
        return $this->created_at;
    }
    /**
     * Set the value of created_at
     *
     * @return  self
     */
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }
    /**
     * Get the value of house
     */
    public function getHouse()
    {
        return $this->house;
    }

    /**
     * Set the value of house
     *
     * @return  self
     */
    public function setHouse($house)
    {
        $this->house = $house;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of access
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * Set the value of access
     *
     * @return  self
     */
    public function setAccess($access)
    {
        $this->access = $access;

        return $this;
    }
}
