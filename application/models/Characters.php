<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Characters extends CI_Model {

    public function createRandomChars(int $maxLength = 20, Bool $withSymbol = true)
    {
        if ($withSymbol) {
            $seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789$_');
        } else {
            $seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
        }
        
        shuffle($seed);
        $rand = '';
        foreach (array_rand($seed, $maxLength) as $k) $rand .= $seed[$k];
        return $rand;
    }

    public function isValidEmail(String $stringGiven)
    {
        return filter_var($stringGiven, FILTER_VALIDATE_EMAIL);
    }

    public function isValidDate(String $dateString, String $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $dateString);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $dateString;
    }

}

/* End of file Characters.php */
