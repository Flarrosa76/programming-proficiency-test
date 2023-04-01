<?php

namespace App;

class ArabicToRoman
{
    /**
     * Receive an arabic number and return a string with its roman counterpart
     *
     * @param int $arabicNumber Arabic number to be transformed (e.g. 121)
     *
     * @return string The roman number equivalent (e.g. CXXI)
     */
    public static function transform(int $arabicNumber): string
    {
        $romanNumber = '';
        
    /** I generate an array associating the Roman numerals with the Arabic value. Numbers above 5000 would 
     * require a special treatment because their representation involves special characters, 
     * I used one of the possible conventions */
        $romanValues = [
            '_M' => 1000000,
            '_D' => 500000,
            '_C' => 100000,
            '_L' => 50000,
            '_X' => 10000,
            '_V'=> 5000,
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1
        ];
    /** For each Roman numeral, I compare its value with the parameter and if it is 
     * smaller I concatenate the Roman numeral to the return string and subtract the value of the parameter. */

        foreach ($romanValues as $key => $value) {
            while ($arabicNumber >= $value) {
                $romanNumber .= $key;
                $arabicNumber -= $value;
            }
        }
    
        return $romanNumber;
    }
}