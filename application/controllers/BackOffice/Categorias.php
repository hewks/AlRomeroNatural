<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categorias extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('genetic');
        $this->load->model('Model_Genetic');
        $this->load->model('Model_Category');
    }

    function index()
    {

        $fecha = date('Y-m-d H:i:s');

        $user_data = $this->session->userdata();
        if (isset($user_data['login_date']) && strtotime($fecha) > strtotime($user_data['login_date'] . '+ 1 day')) {
            $unset_items = array('username', 'email', 'login_date');
            $this->session->unset_userdata($unset_items);
            redirect(base_url() . 'Main');
        }

        $header_data = array(
            'title' => 'BackSurface | Hewks',
            'description' => '',
            'keywords' => '',
            'author' => 'Hewks',
            'links' => ''
        );

        $footer_data = array(
            'scripts' => '<script src="' . base_url() . 'assets/vendor/md5.js"></script>
            <script src="' . base_url() . 'assets/js/Admin/components/pages/categoriasTableSection.js"></script>'
        );

        $section_data = array(
            'page_title' => 'Categorias',
            'section' => 'Categorias'
        );

        $this->load->view('Admin/layouts/header', $header_data);
        $this->load->view('Admin/layouts/navigation');
        $this->load->view('Admin/pages/categorias', $section_data);
        $this->load->view('Admin/layouts/footer', $footer_data);
    }

    function data_table()
    {
        header('Content-Type: application/json');

        $output = array();

        switch ($this->input->post('requestType')) {
            case 'all':
                $all_data = $this->Model_Category->all('table');
                if (!($this->genetic->validate_data($all_data))) {
                    $output[] = array(
                        'status' => false,
                        'response' => 'No fue posible hallar los datos'
                    );
                } else {
                    $output[] = array(
                        'status' => true,
                        'response' => 'Los datos se hallaron correctamente'
                    );
                    $output[] = array(
                        'tableData' => $all_data
                    );
                }
                break;
            case 'one':
                $one_data = $this->Model_Category->one($this->input->post('id'));
                if (!($this->genetic->validate_data($one_data))) {
                    $output[] = array(
                        'status' => false,
                        'response' => 'No fue posible hallar los datos'
                    );
                } else {
                    $output[] = array(
                        'status' => true,
                        'response' => 'Los datos se hallaron correctamente'
                    );
                    $output[] = array(
                        'tableData' => $one_data
                    );
                }
                break;
        }

        echo json_encode($output);
        exit();
    }

    function add()
    {

        header('Content-Type: application/json');

        $output = array();
        $fecha = date('Y-m-d H:i:s');

        $new_data = array(
            'category' => $this->input->post('category'),
            'large_description' => $this->input->post('largeDescription'),
            'short_description' => $this->input->post('shortDescription'),
            'created_at' => $fecha,
            'updated_at' => $fecha
        );

        if (!$this->genetic->validate_data($new_data)) {
            $output[] = array(
                'status' => false,
                'response' => 'No fue posible validar el formulario'
            );
        } else {
            if ($this->Model_Category->search_by('category', $new_data['category'])) {
                $output[] = array(
                    'status' => false,
                    'response' => 'El nombre de la categoria ya esta en uso.'
                );
            } else {
                if (!$this->Model_Category->create($new_data)) {
                    $output[] = array(
                        'status' => false,
                        'response' => 'No fue posible agregar la categoria.'
                    );
                } else {
                    $output[] = array(
                        'status' => true,
                        'response' => 'La categoria se registró correctamente.'
                    );
                }
            }
        }

        echo json_encode($output);
        exit();
    }

    function delete()
    {

        header('Content-Type: application/json');

        $output = array();

        if (!$this->Model_Category->delete($this->input->post('id'))) {
            $output[] = array(
                'status' => false,
                'response' => 'No fue posible eliminar la categoria.'
            );
        } else {
            $output[] = array(
                'status' => true,
                'response' => 'Se elimino la categoria correctamente.'
            );
        }

        echo json_encode($output);
        exit();
    }

    function active()
    {

        header('Content-Type: application/json');

        $output = array();

        if (!$this->Model_Category->active($this->input->post('id'))) {
            $output[] = array(
                'status' => false,
                'response' => 'No fue posible activar la categoria.'
            );
        } else {
            $output[] = array(
                'status' => true,
                'response' => 'La categoria se activo correctamente.'
            );
        }

        echo json_encode($output);
        exit();
    }

    function edit()
    {
        header('Content-Type: application/json');

        $fecha = date('Y-m-d H:i:s');
        $output = array();

        $edit_data = array(
            'id' => $this->input->post('id'),
            'category' => $this->input->post('category'),
            'large_description' => $this->input->post('largeDescription'),
            'short_description' => $this->input->post('shortDescription'),
            'updated_at' => $fecha
        );

        if (!$this->Model_Category->edit($edit_data)) {
            $output[] = array(
                'status' => false,
                'response' => 'No fue posible editar la categoria.'
            );
        } else {
            $output[] = array(
                'status' => true,
                'response' => 'La categoria fue editado correctamente.'
            );
        }

        echo json_encode($output);
        exit();
    }

    function create_pdf()
    {
        $this->load->library('Pdf');
        $pdf = $this->pdf->load();

        $table_data = $this->Model_Category->all();

        $pdf_table_body = '';
        foreach ($table_data as $data) {
            $pdf_table_body .= '<tr>';
            $pdf_table_body .= '<th>' . $data->id . '</th>';
            $pdf_table_body .= '<th>' . $data->category . '</th>';
            $pdf_table_body .= '</tr>';
        }

        $pdf_data = array(
            'fecha' => date('Y-m-d H:i:s'),
            'title' => 'Categorias',
            'thead' => array('ID', 'Categoria'),
            'tbody' => $pdf_table_body
        );

        $html = $this->genetic->create_html_to_pdf($pdf_data);

        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream();
    }
}