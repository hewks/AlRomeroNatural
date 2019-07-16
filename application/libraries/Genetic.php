<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Genetic
{
    function validate_array($array)
    {
        $errors = 0;
        foreach ($array as $value) {
            if ($value == '') {
                $errors++;
            }
        }
        return ($errors > 0) ? false : true;
    }
}
