<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Errors
{

    public $errors;
    public $success;

    function __construct()
    {
        $errors = array();
        $success = array();

        // //////////Errors
        $errors['100001'] = array(
            'error_num' => '100001',
            'error_text' => 'No fue posible validar tus datos',
            'error_type' => 'error'
        );
        $errors['100002'] = array(
            'error_num' => '100002',
            'error_text' => 'No fue posible encontrar tu email.',
            'error_type' => 'fail'
        );
        $errors['100003'] = array(
            'error_num' => '100003',
            'error_text' => 'Tu contrase&ntilde;a es incorrecta.',
            'error_type' => 'fail'
        );
        $errors['100004'] = array(
            'error_num' => '100004',
            'error_text' => 'El email ya esta en uso.',
            'error_type' => 'fail'
        );
        $errors['100005'] = array(
            'error_num' => '100005',
            'error_text' => 'No fue posible el registro, intenta más tarde.',
            'error_type' => 'error'
        );

        // //////////Success
        $errors['200001'] = array(
            'error_num' => '200001',
            'error_text' => 'El usuario ingresó correctamente.',
            'error_type' => 'success'
        );
        $errors['200002'] = array(
            'error_num' => '200002',
            'error_text' => 'Tu registro se realizó correctamente.',
            'error_type' => 'success'
        );
        $errors['200003'] = array(
            'error_num' => '200003',
            'error_text' => 'El usuario cerró session.',
            'error_type' => 'success'
        );

        $this->errors = $errors;
    }

    function return_error($error_number)
    {
        return $this->errors[$error_number];
    }

    function create_error_data($error_number)
    {
        $fecha = date('Y-m-d H:i:s');
        $error = $this->return_error($error_number);
        $error_data = array(
            'type' => $error['error_type'],
            'error' => $error['error_num'],
            'error_text' => $error['error_text'],
            'created_at' => $fecha
        );
        return $error_data;
    }
}
