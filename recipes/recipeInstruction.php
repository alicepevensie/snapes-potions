<?php

class RecipeInstruction{
    
    private $step;
    private $step_description;

    public function __construct($step, $step_description)
    {
        $this->step = $step;
        $this->step_description = $step_description;
    }

    /**
     * Get the value of step
     */ 
    public function getStep()
    {
        return $this->step;
    }

    /**
     * Set the value of step
     *
     * @return  self
     */ 
    public function setStep($step)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * Get the value of step_description
     */ 
    public function getStep_description()
    {
        return $this->step_description;
    }

    /**
     * Set the value of step_description
     *
     * @return  self
     */ 
    public function setStep_description($step_description)
    {
        $this->step_description = $step_description;

        return $this;
    }
}