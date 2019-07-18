<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Servicios extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('genetic');
        $this->load->model('Model_Genetic');
        $this->load->model('Model_Service');
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
            <script src="' . base_url() . 'assets/js/Admin/components/pages/servicesTableSection.js"></script>'
        );

        $section_data = array(
            'page_title' => 'Servicios',
            'section' => 'Servicios'
        );

        $this->load->view('Admin/layouts/header', $header_data);
        $this->load->view('Admin/layouts/navigation');
        $this->load->view('Admin/pages/servicios-chart', $section_data);
        $this->load->view('Admin/pages/servicios', $section_data);
        $this->load->view('Admin/layouts/footer', $footer_data);
    }

    function data_table()
    {
        header('Content-Type: application/json');

        $output = array();

        switch ($this->input->post('requestType')) {
            case 'all':
                $all_data = $this->Model_Service->all('table');
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
                $one_data = $this->Model_Service->one($this->input->post('id'));
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
            case 'chart':
                $table = $this->input->post('table');
                $time = $this->input->post('time');
                $request_data = 'pay, created_at';
                $chart_data = $this->Model_Service->chart_data_request($table, $request_data, $time);
                $new_chart_data = array();
                if (!$this->genetic->validate_data($chart_data)) {
                    $output[] = array(
                        'status' => false,
                        'response' => 'No fue posible hallar los datos'
                    );
                } else {
                    $output[] = array(
                        'status' => true,
                        'response' => 'Los datos se hallaron correctamente'
                    );
                    foreach ($chart_data as $data) {
                        array_push($new_chart_data, array(
                            'price' => $data->pay,
                            'year' => date('Y', strtotime($data->created_at)),
                            'month' => date('m', strtotime($data->created_at)),
                            'day' => date('d', strtotime($data->created_at)),
                            'hour' => date('H', strtotime($data->created_at)),
                        ));
                    }
                    $output[] = array(
                        'chartData' => $new_chart_data
                    );
                }
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
            'service' => $this->input->post('service'),
            'price' => $this->input->post('price'),
            'created_at' => $fecha,
            'updated_at' => $fecha
        );

        if (!$this->genetic->validate_data($new_data)) {
            $output[] = array(
                'status' => false,
                'response' => 'No fue posible validar el formulario'
            );
        } else {
            if ($this->Model_Service->search_by('service', $new_data['service'])) {
                $output[] = array(
                    'status' => false,
                    'response' => 'El Servicio ya se encuentra en la base de datos.'
                );
            } else {
                if (!$this->Model_Service->create($new_data)) {
                    $output[] = array(
                        'status' => false,
                        'response' => 'No fue posible agregar el servicio.'
                    );
                } else {
                    $output[] = array(
                        'status' => true,
                        'response' => 'El servicio se registró correctamente.'
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

        if (!$this->Model_Service->delete($this->input->post('id'))) {
            $output[] = array(
                'status' => false,
                'response' => 'No fue posible eliminar el servicio.'
            );
        } else {
            $output[] = array(
                'status' => true,
                'response' => 'Se elimino el servicio correctamente.'
            );
        }

        echo json_encode($output);
        exit();
    }

    function active()
    {

        header('Content-Type: application/json');

        $output = array();

        if (!$this->Model_Service->active($this->input->post('id'))) {
            $output[] = array(
                'status' => false,
                'response' => 'No fue posible activar el servicio.'
            );
        } else {
            $output[] = array(
                'status' => true,
                'response' => 'El servicio se activo correctamente.'
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
            'service' => $this->input->post('service'),
            'price' => $this->input->post('price'),
            'updated_at' => $fecha
        );

        if (!$this->genetic->validate_data($edit_data)) {
            $output[] = array(
                'status' => false,
                'response' => 'No fue posible validar los datos.'
            );
        } else {
            if (!$this->Model_Service->edit($edit_data)) {
                $output[] = array(
                    'status' => false,
                    'response' => 'No fue posible editar al servicio.'
                );
            } else {
                $output[] = array(
                    'status' => true,
                    'response' => 'El servicio fue editado correctamente.'
                );
            }
        }

        echo json_encode($output);
        exit();
    }

    function pay()
    {
        header('Content-Type: application/json');

        $fecha = date('Y-m-d H:i:s');
        $output = array();

        $id = $this->input->post('id');

        $new_data = array(
            'ref' => $fecha . '-' . $id,
            'service' => (int)$id,
            'pay' => $this->Model_Service->get_payment($id, 'price'),
            'created_at' => $fecha
        );

        if (!$this->genetic->validate_data($new_data)) {
            $output[] = array(
                'status' => false,
                'response' => 'No fue posible validar los datos.'
            );
        } else {
            if (strtotime($this->Model_Service->get_payment_date($new_data['service'])) >= strtotime($fecha . '- 1 month')) {
                $output[] = array(
                    'status' => false,
                    'response' => 'Ya pagaste el servicio durante este mes.'
                );
            } else {
                if (!$this->Model_Service->create_custom($new_data, 'service_payment')) {
                    $output[] = array(
                        'status' => false,
                        'response' => 'No fue posible realizar el pago.'
                    );
                } else {
                    if (!$this->Model_Service->change_payment_status($new_data['service'])) {
                        $output[] = array(
                            'status' => false,
                            'response' => 'Se realizó el pago pero no se actualizó la informacion del empleado. Contacta con el programador.'
                        );
                    } else {
                        $output[] = array(
                            'status' => true,
                            'response' => 'El pago se realizó correctamente.'
                        );
                    }
                }
            }
        }

        echo json_encode($output);
        exit();
    }

    function create_pdf()
    {
        $this->load->library('Pdf');
        $pdf = $this->pdf->load();

        switch ($this->input->get('type')) {
            case 'servicios':
                $services_data = $this->Model_Service->all();
                $pdf_table_body = '';
                foreach ($services_data as $data) {
                    $pdf_table_body .= '<tr>';
                    $pdf_table_body .= '<th>' . $data->id . '</th>';
                    $pdf_table_body .= '<th>' . $data->service . '</th>';
                    $pdf_table_body .= '<th> $' . number_format($data->price, 0, ',', '.') . '</th>';
                    $pdf_table_body .= '</tr>';
                }
                $pdf_data = array(
                    'fecha' => date('Y-m-d H:i:s'),
                    'title' => 'Servicios',
                    'thead' => array('ID', 'Servicio', 'Valor'),
                    'tbody' => $pdf_table_body
                );
                $html = $this->genetic->create_html_to_pdf($pdf_data);
                $pdf->loadHtml($html);
                $pdf->setPaper('A4', 'landscape');
                $pdf->render();
                $pdf->stream();
                break;
            case 'pagos':
                $select_data = 'id,ref,service,pay';
                $table_data = $this->Model_Service->chart_data_request('service_payment', $select_data, 'Year');
                $pdf_table_body = '';
                foreach ($table_data as $data) {
                    $pdf_table_body .= '<tr>';
                    $pdf_table_body .= '<th>' . $data->id . '</th>';
                    $pdf_table_body .= '<th>' . $data->ref . '</th>';
                    $pdf_table_body .= '<th>' . $data->service . '</th>';
                    $pdf_table_body .= '<th> $' . number_format($data->pay, 0, ',', '.') . '</th>';
                    $pdf_table_body .= '</tr>';
                }
                $pdf_data = array(
                    'fecha' => date('Y-m-d H:i:s'),
                    'title' => 'Servicios (Pagos)',
                    'thead' => array('ID', 'Ref', 'Servicio', 'Valor'),
                    'tbody' => $pdf_table_body
                );
                $html = $this->genetic->create_html_to_pdf($pdf_data);
                $pdf->loadHtml($html);
                $pdf->setPaper('A4', 'landscape');
                $pdf->render();
                $pdf->stream();
                break;
        }
    }
}
