<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Genetic
{
    // Main Functions
    // New Version
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

    // Back Version

    function validate_data($data)
    {
        $error = 0;
        foreach ($data as $dt) {
            $error += ($dt == '') ? 1 : 0;
        }
        return ($error > 0) ? false : true;
    }

    function validate_date($date, $plus)
    {
        return ($date >= $plus) ? false : true;
    }

    function create_html_to_pdf($pdf_data)
    {
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset=\'utf-8\'>
            <style>
                body {font-size: 16px;color: black;margin-top: 25px;}
                * { padding: 0;margin: 0;box-sizing: border-box;font-family: Arial, Helvetica, sans-serif;font-weight: lighter;}
                table {clear: both;margin-top: 6px !important;margin-bottom: 6px !important;max-width: none !important;border-collapse: separate !important;border-spacing: 0;width: 70%;margin: 0 auto;display: table;text-align: center;}
                table td,table th {border: 1px solid grey;}
                table thead {font-weight: bold !important;}
            </style>
            <title>' . $pdf_data['title'] . '</title>
        </head>
        <body>
        <h1 style="text-align: center;font-size:22px; ">' . $pdf_data['title']  . '</h1>
        <p style="text-align: center;font-size:18px;margin-bottom:15px; ">' . $pdf_data['fecha'] . '</p>
        <table class="table">
        <thead>
        <tr>';
        foreach ($pdf_data['thead'] as $value) {
            $html .= ' <td> ' . $value . ' </td>';
        }
        $html .= '
        </tr>
        </thead>
        <tbody> 
        ' . $pdf_data['tbody'] . '
        </tbody>
        </table>
        </body>
        </html>';

        return $html;
    }
}
