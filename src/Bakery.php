<?php

namespace App;

class Bakery
{
    /**
     * Calculate the output of cakes for a giver recipe
     *
     * @param array $recipe      Contains the necessary ingredients to make one cake
     * @param array $ingredients Contains the amount of ingredients you have available to bake
     *
     * @return int The number of cakes you can bake
     */

    /**
     * I preferred to set the $numberOfCakes to a very large number, to get de minimum. 
     * It then loops through each ingredient in the $recipe array, checks if it exists in the $ingredients array.
     * If an ingredient is missing, the method returns. Then calculates the number of cakes possible 
     * with the available ingredients and  minimum of its current value and the calculated ratio
     * indicating that no cakes can be made. Finally, the method returns $numberOfCakes, which is the maximum number 
     * of cakes that can be made given the available ingredients.
     */

     public static function calculateOutput(array $recipe, array $ingredients): int
    {
        $numberOfCakes = PHP_INT_MAX;

        foreach ($recipe as $ingredient => $quantity) {
            if (!isset($ingredients[$ingredient])) {
                return 0; // Missing ingredient, can't make any cakes
            }
            $cakes = intval($ingredients[$ingredient] / $quantity);
            $numberOfCakes = min($numberOfCakes, $cakes);
        }
    
        return $numberOfCakes;
    }
}