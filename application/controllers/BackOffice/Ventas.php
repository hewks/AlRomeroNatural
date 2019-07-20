<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ventas extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('genetic');
        $this->load->model('Model_Genetic');
        $this->load->model('Model_Product');
        $this->load->model('Model_Sells');
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
            <script src="' . base_url() . 'assets/js/Admin/components/pages/sellsTableSection.js"></script>'
        );

        $section_data = array(
            'page_title' => 'Ventas',
            'section' => 'Ventas'
        );

        $this->load->view('Admin/layouts/header', $header_data);
        $this->load->view('Admin/layouts/navigation');
        $this->load->view('Admin/pages/ventas-chart', $section_data);
        $this->load->view('Admin/pages/ventas', $section_data);
        $this->load->view('Admin/layouts/footer', $footer_data);
    }

    function data_table()
    {
        header('Content-Type: application/json');

        $output = array();

        switch ($this->input->post('requestType')) {
            case 'all':
                $all_data = $this->Model_Sells->all('table');
                $product = $this->Model_Sells->search_custom('product_name,stock,id', 'product_register');
                $output[] = array(
                    'status' => true,
                    'response' => 'Los datos se hallaron correctamente'
                );
                $output[] = array(
                    'tableData' => $all_data,
                    'selectData' => array(
                        'selects' => 'productSelect',
                        'data' => $product
                    )
                );
                break;
            case 'one':
                $one_data = $this->Model_Sells->one($this->input->post('id'));
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
                $request_data = 'total_price, created_at';
                $chart_data = $this->Model_Sells->chart_data_request($table, $request_data, $time);
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

        $product_id = $this->input->post('product');
        $product_data = $this->Model_Product->search_product_data($product_id);
        $quantity = $this->input->post('quantity');
        $discount = $product_data['discount'];
        $total_price = ($product_data['price'] * $quantity) - ($product_data['price'] * $quantity * $discount);

        $new_data = array(
            'products_id' => $this->input->post('product'),
            'products_quantity' => $quantity,
            'total_price' => $total_price,
            'discount' => $discount,
            'created_at' => $fecha,
            'user_id' => $this->session->userdata('id')
        );

        if (!$this->genetic->validate_data($new_data)) {
            $output[] = array(
                'status' => false,
                'response' => 'No fue posible validar el formulario'
            );
        } else {
            if ($this->Model_Product->search_product_stock($product_id) < $new_data['products_quantity']) {
                $output[] = array(
                    'status' => false,
                    'response' => 'No hay suficiente producto en el inventario'
                );
            } else {
                if (!$this->Model_Product->change_product_stock($product_id, 'sell', $new_data['products_quantity'])) {
                    $output[] = array(
                        'status' => false,
                        'response' => 'No fue posible cambiar el stock del producto, contacta con el programador'
                    );
                } else {
                    if (!$this->Model_Sells->create($new_data)) {
                        $output[] = array(
                            'status' => false,
                            'response' => 'No se pudo registrar la venta'
                        );
                    } else {
                        $output[] = array(
                            'status' => true,
                            'response' => 'La venta se registró.'
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
            case 'products':
                $table_data = $this->Model_Sells->all();
                $pdf_table_body = '';
                foreach ($table_data as $data) {
                    $pdf_table_body .= '<tr>';
                    $pdf_table_body .= '<th>' . $data->id . '</th>';
                    $pdf_table_body .= '<th>' . $data->product_name . '</th>';
                    $pdf_table_body .= '<th>' . $data->category_id . '</th>';
                    $pdf_table_body .= '<th> $' . number_format($data->price, 0, ',', '.') . '</th>';
                    $pdf_table_body .= '<th> $' . number_format($data->last_buy, 0, ',', '.') . '</th>';
                    $pdf_table_body .= '<th> %' . $data->discount . '</th>';
                    $pdf_table_body .= '<th>' . $data->stock . '</th>';
                    $pdf_table_body .= '</tr>';
                }
                $pdf_data = array(
                    'fecha' => date('Y-m-d H:i:s'),
                    'title' => 'Productos',
                    'thead' => array('ID', 'Producto', 'Categoria', 'Valor', 'Ultima Compra', 'Descuento', 'Inventario'),
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
