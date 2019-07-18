<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Compras extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('genetic');
        $this->load->model('Model_Genetic');
        $this->load->model('Model_Buy');
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
            <script src="' . base_url() . 'assets/js/Admin/components/pages/buysTableSection.js"></script>'
        );

        $section_data = array(
            'page_title' => 'Compras',
            'section' => 'Compras'
        );

        $this->load->view('Admin/layouts/header', $header_data);
        $this->load->view('Admin/layouts/navigation');
        $this->load->view('Admin/pages/compras-chart', $section_data);
        $this->load->view('Admin/pages/compras', $section_data);
        $this->load->view('Admin/layouts/footer', $footer_data);
    }

    function data_table()
    {
        header('Content-Type: application/json');

        $output = array();

        switch ($this->input->post('requestType')) {
            case 'all':
                $all_data = $this->Model_Buy->all('table');
                $select_categories_data = $this->Model_Buy->search_custom('id,product_name,stock', 'product_register');
                $output[] = array(
                    'status' => true,
                    'response' => 'Los datos se hallaron correctamente'
                );
                $output[] = array(
                    'tableData' => $all_data,
                    'selectData' => array(
                        'selects' => 'productSelect',
                        'data' => $select_categories_data
                    )
                );
                break;
            case 'chart':
                $table = $this->input->post('table');
                $time = $this->input->post('time');
                $request_data = 'total_price, created_at';
                $chart_data = $this->Model_Buy->chart_data_request($table, $request_data, $time);
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
                            'price' => $data->total_price,
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

        $product = $this->input->post('product');
        $quantity = $this->input->post('quantity');
        $product_price = $this->input->post('buyPrice');
        $total_price = $quantity * $product_price;

        $new_data = array(
            'ref' => $fecha . '-' . $product,
            'product_id' => $product,
            'product_quantity' => $quantity,
            'product_buy_price' => $product_price,
            'total_price' => $total_price,
            'user_id' => $this->session->userdata('id'),
            'created_at' => $fecha
        );

        if (!$this->genetic->validate_data($new_data)) {
            $output[] = array(
                'status' => false,
                'response' => 'No fue posible validar el formulario'
            );
        } else {
            if (!$this->Model_Buy->change_product_stock($product, 'buy', $quantity)) {
                $output[] = array(
                    'status' => false,
                    'response' => 'No fue posible agregar el producto al inventario. Contacta con el programador.'
                );
            } else {
                if (!$this->Model_Buy->change_product_last_buy($product, $product_price)) {
                    $output[] = array(
                        'status' => false,
                        'response' => 'No se actualizó la ultima compra. Contacta con el programador.'
                    );
                } else {
                    if (!$this->Model_Buy->create($new_data)) {
                        $output[] = array(
                            'status' => false,
                            'response' => 'No fue posible agregar la compra.'
                        );
                    } else {
                        $output[] = array(
                            'status' => true,
                            'response' => 'La compra se registró correctamente.'
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
            case 'compras':
                $table_data = $this->Model_Buy->all();
                $pdf_table_body = '';
                foreach ($table_data as $data) {
                    $pdf_table_body .= '<tr>';
                    $pdf_table_body .= '<th>' . $data->id . '</th>';
                    $pdf_table_body .= '<th>' . $data->ref . '</th>';
                    $pdf_table_body .= '<th>' . $data->product_id . '</th>';
                    $pdf_table_body .= '<th>' . $data->product_quantity . '</th>';
                    $pdf_table_body .= '<th> $' . number_format($data->product_buy_price, 2, ',', '.') . '</th>';
                    $pdf_table_body .= '<th> $' . number_format($data->total_price, 2, ',', '.') . '</th>';
                    $pdf_table_body .= '<th>' . $data->user_id . '</th>';
                    $pdf_table_body .= '<th>' . $data->created_at . '</th>';
                    $pdf_table_body .= '</tr>';
                }
                $pdf_data = array(
                    'fecha' => date('Y-m-d H:i:s'),
                    'title' => 'Nomina',
                    'thead' => array('ID', 'Referencia', 'Producto', 'Cantidad', 'Precio (Unidad)', 'Precio total', 'Usuario', 'Fecha'),
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
