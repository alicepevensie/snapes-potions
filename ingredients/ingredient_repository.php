<?php

require_once "ingredient.php";
require_once "../database.php";
class IngredientRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function numberOfIngredients()
    {
        $sql = "SELECT COUNT(*) FROM ingredients";
        $result = $this->db->query($sql);
        $row = $result->fetch_row();
        return $row[0];
    }
    public function getAllNames()
    {
        $sql = "SELECT `name`, `unit` FROM ingredients";
        $result = $this->db->query($sql);
        if ($result === false) {
            die($this->db->error);
        }
        $ingredients = [];
        while ($row = $result->fetch_assoc()) {
            $name = $row['name'];
            $unit = $row['unit'];
            $ingredients[] = array("name" => $name, "unit"=>$unit);
        }

        echo json_encode($ingredients);
    }
    public function getAll()
    {
        $sql = "SELECT * FROM ingredients";
        $result = $this->db->query($sql);
        if ($result === false) {
            die($this->db->error);
        }
        $ingredients = [];
        while ($row = $result->fetch_assoc()) {
            $ingredient = new Ingredient(
                $row['name'],
                $row['image'],
                $row['description'],
                $row['amount'],
                $row['unit'],
            );
            $ingredients[] = $ingredient;
        }

        return $ingredients;
    }
    public function selectIngredient($ingredientName)
    {
        $ingredientName = $this->db->real_escape_string($ingredientName);
        $sql = "SELECT * FROM ingredients WHERE `name`='$ingredientName'";
        $result = $this->db->query($sql);
        if ($result === false) {
            die($this->db->error);
        }
        $row = $result->fetch_row();
        $ingredient = new Ingredient(
            $row[0],
            $row[1],
            $row[2],
            $row[3],
            $row[4],
        );
        return $ingredient;
    }
    public function ingredientExists($ingredientName)
    {
        $ingredientName = $this->db->real_escape_string($ingredientName);
        $sql = "SELECT COUNT(1) FROM ingredients WHERE `name`='$ingredientName'";
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

        $sql = "SELECT COUNT(1) FROM ingredients WHERE `image`='$image'";
        $result = $this->db->query($sql);
        $row = $result->fetch_row();
        if ($row[0] >= 1) {
            return true;
        } else {
            return false;
        }
    }
    public function add($ingredient)
    {
        $ingredient->setName($this->db->real_escape_string($ingredient->getName()));
        $ingredient->setImage($this->db->real_escape_string($ingredient->getImage()));
        $ingredient->setDescription($this->db->real_escape_string($ingredient->getDescription()));
        $ingredient->setAmount($this->db->real_escape_string($ingredient->getAmount()));
        $ingredient->setUnit($this->db->real_escape_string($ingredient->getUnit()));

        $sql = "INSERT INTO `ingredients` (`name`, `image`, `description`, `amount`, `unit`)"
            . "VALUES ('{$ingredient->getName()}', '{$ingredient->getImage()}', '{$ingredient->getDescription()}', '{$ingredient->getAmount()}', '{$ingredient->getUnit()}')";
        $result = $this->db->query($sql);
        if ($result === FALSE) {
            die($this->db->error);
        }
    }
    public function updateAmount($ingredient, $amount)
    {
        $name = $this->db->real_escape_string($ingredient->getName());
        $amount = $this->db->real_escape_string($amount + $ingredient->getAmount());
        $sql = "UPDATE ingredients SET `amount`='$amount' WHERE `name`='$name'";
        $result = $this->db->query($sql);
        if ($result === FALSE) {
            die($this->db->error);
        }
        $ingredient->setAmount($amount);
    }
    public function ingredientsForPage($offset, $ingredientsPerPage)
    {
        $offset = $this->db->real_escape_string($offset);
        $ingredientsPerPage = $this->db->real_escape_string($ingredientsPerPage);
        $sql = "SELECT * FROM ingredients ORDER BY `name` ASC LIMIT $offset, $ingredientsPerPage";
        $result = $this->db->query($sql);
        if ($result === false) {
            die($this->db->error);
        }
        $ingredients = [];
        while ($row = $result->fetch_assoc()) {
            $ingredient = new Ingredient(
                $row['name'],
                $row['image'],
                $row['description'],
                $row['amount'],
                $row['unit'],
            );
            $ingredients[] = $ingredient;
        }

        return $ingredients;
    }

    /**
     * Get the value of db
     */ 
    public function getDb()
    {
        return $this->db;
    }
}
