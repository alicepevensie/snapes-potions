<?php

require_once "potion.php";
require_once "../database.php";
class PotionRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM potions";
        $result = $this->db->query($sql);
        if ($result === false) {
            die($this->db->error);
        }
        $potions = [];
        while ($row = $result->fetch_assoc()) {
            $potion = new Potion(
                $row['name'],
                $row['image'],
                $row['description'],
                $row['effect'],
                $row['category'],
                $row['amount'],
            );
            $potions[] = $potion;
        }

        return $potions;
    }
    public function numberOfPotions()
    {
        $sql = "SELECT COUNT(*) FROM potions";
        $result = $this->db->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }
    public function potionsForAutocomplete($searchTerm)
    {
        $sql = "SELECT * FROM potions WHERE `name` LIKE '" . $searchTerm . "%' ORDER BY `name` ASC";
        $result = $this->db->query($sql);
        if ($result === false) {
            die($this->db->error);
        }
        $potionsForAutocomplete = [];
        while ($row = $result->fetch_assoc()) {

            $potionsForAutocomplete[] = $row['name'];
        }
        return $potionsForAutocomplete;
    }
    public function potionsForPage($offset, $potionsPerPage)
    {
        $offset = $this->db->real_escape_string($offset);
        $potionsPerPage = $this->db->real_escape_string($potionsPerPage);
        $sql = "SELECT * FROM potions ORDER BY `name` LIMIT $offset, $potionsPerPage";
        $result = $this->db->query($sql);
        if ($result === false) {
            die($this->db->error);
        }
        $potions = [];
        while ($row = $result->fetch_assoc()) {
            $potion = new Potion(
                $row['name'],
                $row['image'],
                $row['description'],
                $row['effect'],
                $row['category'],
                $row['amount'],
            );
            $potions[] = $potion;
        }

        return $potions;
    }
    public function categorizedPotionsForPage($offset, $potionsPerPage, $category)
    {
        $offset = $this->db->real_escape_string($offset);
        $potionsPerPage = $this->db->real_escape_string($potionsPerPage);
        $category = $this->db->real_escape_string($category);
        $sql = "SELECT * FROM potions WHERE `category`='$category' ORDER BY `name` LIMIT $offset, $potionsPerPage";
        $result = $this->db->query($sql);
        if ($result === false) {
            die($this->db->error);
        }
        $potions = [];
        while ($row = $result->fetch_assoc()) {
            $potion = new Potion(
                $row['name'],
                $row['image'],
                $row['description'],
                $row['effect'],
                $row['category'],
                $row['amount'],
            );
            $potions[] = $potion;
        }

        return $potions;
    }
    public function selectPotionsCategory($category)
    {
        $category = $this->db->real_escape_string($category);
        $sql = "SELECT * FROM users WHERE `category`='$category'";
        $result = $this->db->query($sql);
        if ($result === false) {
            die($this->db->error);
        }
        $potions = [];
        while ($row = $result->fetch_assoc()) {
            $potion = new Potion(
                $row['name'],
                $row['image'],
                $row['description'],
                $row['effect'],
                $row['category'],
                $row['amount'],
            );
            $potions[] = $potion;
        }


        return $potions;
    }
    public function potionExists($potionName)
    {
        $potionName = $this->db->real_escape_string($potionName);

        $sql = "SELECT COUNT(1) FROM potions WHERE `name`='$potionName'";
        $result = $this->db->query($sql);
        $row = $result->fetch_row();
        if ($row[0] >= 1) {
            return true;
        } else {
            return false;
        }
    }
    public function imageExists($image)
    {
        $image = $this->db->real_escape_string($image);

        $sql = "SELECT COUNT(1) FROM potions WHERE `image`='$image'";
        $result = $this->db->query($sql);
        $row = $result->fetch_row();
        if ($row[0] >= 1) {
            return true;
        } else {
            return false;
        }
    }
    public function add($potion)
    {
        $potion->setName($this->db->real_escape_string($potion->getName()));
        $potion->setImage($this->db->real_escape_string($potion->getImage()));
        $potion->setDescription($this->db->real_escape_string($potion->getDescription()));
        $potion->setEffect($this->db->real_escape_string($potion->getEffect()));
        $potion->setCategory($this->db->real_escape_string($potion->getCategory()));
        $potion->setAmount($this->db->real_escape_string($potion->getAmount()));
        $sql = "INSERT INTO `potions` (`name`, `image`, `description`, `effect`, `category`, `amount`)"
            . "VALUES ('{$potion->getName()}', '{$potion->getImage()}', '{$potion->getDescription()}', '{$potion->getEffect()}', '{$potion->getCategory()}', '{$potion->getAmount()}')";
        $result = $this->db->query($sql);
        if ($result === FALSE) {
            die($this->db->error);
        }
    }
    public function getPotion($potionName)
    {
        $potionName = $this->db->real_escape_string($potionName);

        $sql = "SELECT * FROM potions WHERE `name`='$potionName'";
        $result = $this->db->query($sql);
        if ($result === FALSE) {
            die($this->db->error);
        }
        $row = $result->fetch_row();
        $potion = new Potion($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
        return $potion;
    }
    public function updateAmount($potion, $amount)
    {   
        $potion->setName($this->db->real_escape_string($potion->getName()));
        $amount = intval($this->db->real_escape_string($amount)) + intval($this->db->real_escape_string($potion->getAmount()));
        
        $sql = "UPDATE potions SET `amount` = $amount WHERE `name` = '{$potion->getName()}'";
        $result = $this->db->query($sql);
        if ($result === FALSE) {
            die($this->db->error);
        }
    }
}
