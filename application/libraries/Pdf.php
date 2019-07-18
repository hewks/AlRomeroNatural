<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;

class Pdf
{

    function load(){
        // Include PHPMailer library files
        require_once APPPATH.'third_party/dompdf/autoload.inc.php';
        
        $dompdf = new Dompdf();
        return $dompdf;
    }

}
