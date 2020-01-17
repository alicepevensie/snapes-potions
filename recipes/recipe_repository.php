<?php

require_once "../database.php";
require_once "recipeIngredient.php";
require_once "recipeInstruction.php";
class RecipeRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getIngredientsForPotion($potion_name)
    {
        $potion_name = $this->db->real_escape_string($potion_name);

        $sql = "SELECT * FROM recipes WHERE `potion_name` = '$potion_name'";
        $result = $this->db->query($sql);
        if ($result === false) {
            die($this->db->error);
        }
        $recipeIngredients = [];
        while ($row = $result->fetch_assoc()) {
            $recipeIngredient = new RecipeIngredient(
                $row['ingredient_name'],
                $row['ingredient_amount'],
            );
            
            $recipeIngredients[] =  $recipeIngredient;
        }

        return $recipeIngredients;
    }
    public function getInstructionsForPotion($potion_name)
    {
        
        $potion_name = $this->db->real_escape_string($potion_name);

        $sql = "SELECT * FROM recipe_instructions WHERE `potion_recipe` = '$potion_name'";
        $result = $this->db->query($sql);
        if ($result === false) {
            die($this->db->error);
        }
        $recipeInstructionss = [];
        while ($row = $result->fetch_assoc()) {
            $recipeInstruction = new RecipeInstruction(
                $row['step'],
                $row['step_description'],
            );
            $recipeInstructionss[] =  $recipeInstruction;
        }

        return $recipeInstructionss;
    }
    public function recipeExists($potion_name)
    {
        $potion_name = $this->db->real_escape_string($potion_name);

        $sql = "SELECT COUNT(*) FROM recipes WHERE `potion_name`='$potion_name'";
        $result = $this->db->query($sql);
        $row = $result->fetch_row();
        if ($row[0] >= 1) {
            return true;
        } else {
            return false;
        }
    }
    public function instructionsExists($potion_name)
    {
        $potion_name = $this->db->real_escape_string($potion_name);

        $sql = "SELECT COUNT(*) FROM recipe_instructions WHERE `potion_recipe`='$potion_name'";
        $result = $this->db->query($sql);
        $row = $result->fetch_row();
        if ($row[0] >= 1) {
            return true;
        } else {
            return false;
        }
    }
    public function addIngredientForPotion($potion_name, $recipeIngredient)
    {
        $potion_name = $this->db->real_escape_string($potion_name);
        $recipeIngredient->setIngredient_name($this->db->real_escape_string($recipeIngredient->getIngredient_name()));
        $recipeIngredient->setIngredient_amount($this->db->real_escape_string($recipeIngredient->getIngredient_amount()));
        $sql = "INSERT INTO `recipes` (`potion_name`, `ingredient_name`, `ingredient_amount`)"
            . "VALUES ('{$potion_name}', '{$recipeIngredient->getIngredient_name()}', '{$recipeIngredient->getIngredient_amount()}')";
        $result = $this->db->query($sql);
        if ($result === FALSE) {
            die($this->db->error);
        }
    }
    public function addInstructionForPotion($potion_name, $recipeInstruction)
    {
        $potion_name = $this->db->real_escape_string($potion_name);
        $recipeInstruction->setStep($this->db->real_escape_string($recipeInstruction->getStep()));
        $recipeInstruction->setStep_description($this->db->real_escape_string($recipeInstruction->getStep_description()));
        $sql = "INSERT INTO `recipe_instructions` (`potion_recipe`, `step`, `step_description`)"
            . "VALUES ('{$potion_name}', '{$recipeInstruction->getStep()}', '{$recipeInstruction->getStep_description()}')";
        $result = $this->db->query($sql);
        if ($result === FALSE) {
            die($this->db->error);
        }
    }
}
