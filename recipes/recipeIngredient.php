<?php

class RecipeIngredient
{
    private $ingredient_name;
    private $ingredient_amount;

    public function __construct($ingredient_name, $ingredient_amount)
    {
        $this->ingredient_name = $ingredient_name;
        $this->ingredient_amount = $ingredient_amount;
    }
    
    /**
     * Get the value of ingredient_name
     */ 
    public function getIngredient_name()
    {
        return $this->ingredient_name;
    }

    /**
     * Set the value of ingredient_name
     *
     * @return  self
     */ 
    public function setIngredient_name($ingredient_name)
    {
        $this->ingredient_name = $ingredient_name;

        return $this;
    }

    /**
     * Get the value of ingredient_amount
     */ 
    public function getIngredient_amount()
    {
        return $this->ingredient_amount;
    }

    /**
     * Set the value of ingredient_amount
     *
     * @return  self
     */ 
    public function setIngredient_amount($ingredient_amount)
    {
        $this->ingredient_amount = $ingredient_amount;

        return $this;
    }
}