<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clientes extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('genetic');
        $this->load->model('Model_Genetic');
        $this->load->model('Model_Customers');
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
            <script src="' . base_url() . 'assets/js/Admin/components/pages/customersTableSection.js"></script>'
        );

        $section_data = array(
            'page_title' => 'Clientes',
            'section' => 'Clientes'
        );

        $this->load->view('Admin/layouts/header', $header_data);
        $this->load->view('Admin/layouts/navigation');
        $this->load->view('Admin/pages/clientes', $section_data);
        $this->load->view('Admin/layouts/footer', $footer_data);
    }

    function data_table()
    {
        header('Content-Type: application/json');

        $output = array();

        switch ($this->input->post('requestType')) {
            case 'all':
                $all_data = $this->Model_Customers->all('table');
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
                $one_data = $this->Model_Customers->one($this->input->post('id'));
                $output[] = array(
                    'status' => true,
                    'response' => 'Los datos se hallaron correctamente'
                );
                $output[] = array(
                    'tableData' => $one_data
                );
                break;
        }

        echo json_encode($output);
        exit();
    }

    function delete()
    {

        header('Content-Type: application/json');

        $output = array();

        if (!$this->Model_Customers->delete($this->input->post('id'))) {
            $output[] = array(
                'status' => false,
                'response' => 'No fue posible eliminar el cliente.'
            );
        } else {
            $output[] = array(
                'status' => true,
                'response' => 'Se elimino el cliente correctamente.'
            );
        }

        echo json_encode($output);
        exit();
    }

    function active()
    {

        header('Content-Type: application/json');

        $output = array();

        if (!$this->Model_Customers->active($this->input->post('id'))) {
            $output[] = array(
                'status' => false,
                'response' => 'No fue posible activar el cliente.'
            );
        } else {
            $output[] = array(
                'status' => true,
                'response' => 'El cliente se activo correctamente.'
            );
        }

        echo json_encode($output);
        exit();
    }

    function create_pdf()
    {
        $this->load->library('Pdf');
        $pdf = $this->pdf->load();

        $table_data = $this->Model_Customers->all();

        $pdf_table_body = '';
        foreach ($table_data as $data) {
            $pdf_table_body .= '<tr>';
            $pdf_table_body .= '<th>' . $data->id . '</th>';
            $pdf_table_body .= '<th>' . $data->name . '</th>';
            $pdf_table_body .= '<th>' . $data->document . '</th>';
            $pdf_table_body .= '<th>' . $data->document_type . '</th>';
            $pdf_table_body .= '<th>' . $data->email . '</th>';
            $pdf_table_body .= '<th>' . $data->phone . '</th>';
            $pdf_table_body .= '</tr>';
        }

        $pdf_data = array(
            'fecha' => date('Y-m-d H:i:s'),
            'title' => 'Clientes',
            'thead' => array('ID', 'Nombre', 'Documento', 'Tipo', 'Email', 'Telefono'),
            'tbody' => $pdf_table_body
        );

        $html = $this->genetic->create_html_to_pdf($pdf_data);

        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream();
    }
}
