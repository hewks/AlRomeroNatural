<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Productos extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('genetic');
        $this->load->model('Model_Genetic');
        $this->load->model('Model_Product');
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
            <script src="' . base_url() . 'assets/js/Admin/components/pages/productTableSection.js"></script>'
        );

        $section_data = array(
            'page_title' => 'Productos',
            'section' => 'Productos'
        );

        $this->load->view('Admin/layouts/header', $header_data);
        $this->load->view('Admin/layouts/navigation');
        //$this->load->view('pages/productos-chart', $section_data);
        $this->load->view('Admin/pages/productos', $section_data);
        $this->load->view('Admin/layouts/footer', $footer_data);
    }

    function data_table()
    {
        header('Content-Type: application/json');

        $output = array();

        switch ($this->input->post('requestType')) {
            case 'all':
                $all_data = $this->Model_Product->all('table');
                $select_categories_data = $this->Model_Product->search_custom('id,category', 'category_register');
                $output[] = array(
                    'status' => true,
                    'response' => 'Los datos se hallaron correctamente'
                );
                $output[] = array(
                    'tableData' => $all_data,
                    'selectData' => array(
                        'selects' => 'categoriesSelect',
                        'data' => $select_categories_data
                    )
                );
                break;
            case 'one':
                $one_data = $this->Model_Product->one($this->input->post('id'));
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
                $chart_data = $this->Model_Product->chart_data_request($table, $request_data, $time);
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
            'product_name' => $this->input->post('product'),
            'category_id' => $this->input->post('category'),
            'price' => $this->input->post('price'),
            'discount' => $this->input->post('discount'),
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
            if ($this->Model_Product->search_by('product_name', $new_data['product_name'])) {
                $output[] = array(
                    'status' => false,
                    'response' => 'El producto ya se encuentra en la base de datos.'
                );
            } else {
                if (!isset($_FILES['image'])) {
                    $output[] = array(
                        'status' => false,
                        'response' => 'No se encontró ninguna imagen, prueba con una más pequeña.'
                    );
                } else {
                    $image_name = $_FILES['image']['name'];
                    $image_destiny = FCPATH . 'assets/images/productos/' . $image_name;
                    if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_destiny)) {
                        $output[] = array(
                            'status' => false,
                            'response' => 'No se pudo copiar la imagen al servidor.'
                        );
                    } else {
                        $new_data['image_url'] = $image_name;
                        if (!$this->Model_Product->create($new_data)) {
                            $output[] = array(
                                'status' => false,
                                'response' => 'No fue posible agregar el producto.'
                            );
                        } else {
                            $output[] = array(
                                'status' => true,
                                'response' => 'El producto se registró correctamente.'
                            );
                        }
                    }
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

        if (!$this->Model_Product->delete($this->input->post('id'))) {
            $output[] = array(
                'status' => false,
                'response' => 'No fue posible eliminar el producto.'
            );
        } else {
            $output[] = array(
                'status' => true,
                'response' => 'Se elimino el producto correctamente.'
            );
        }

        echo json_encode($output);
        exit();
    }

    function active()
    {

        header('Content-Type: application/json');

        $output = array();

        if (!$this->Model_Product->active($this->input->post('id'))) {
            $output[] = array(
                'status' => false,
                'response' => 'No fue posible activar el producto.'
            );
        } else {
            $output[] = array(
                'status' => true,
                'response' => 'El producto se activo correctamente.'
            );
        }

        echo json_encode($output);
        exit();
    }

    function fav()
    {
        header('Content-Type: application/json');

        $output = array();

        if (!$this->Model_Product->change_fav($this->input->post('id'))) {
            $output[] = array(
                'status' => false,
                'response' => 'Tu producto se quitó de los favoritos.'
            );
        } else {
            $output[] = array(
                'status' => true,
                'response' => 'El producto esta en favoritos.'
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
            'product_name' => $this->input->post('product'),
            'category_id' => $this->input->post('category'),
            'price' => $this->input->post('price'),
            'discount' => $this->input->post('discount'),
            'stock' => $this->input->post('stock'),
            'large_description' => $this->input->post('largeDescription'),
            'short_description' => $this->input->post('shortDescription'),
            'updated_at' => $fecha
        );

        if (!$this->genetic->validate_data($edit_data)) {
            $output[] = array(
                'status' => false,
                'response' => 'No fue posible validar los datos.'
            );
        } else {
            if (!isset($_FILES['image'])) {
                if (!$this->Model_Product->edit($edit_data)) {
                    $output[] = array(
                        'status' => false,
                        'response' => 'No fue posible editar al producto.'
                    );
                } else {
                    $output[] = array(
                        'status' => true,
                        'response' => 'El producto fue editado correctamente.'
                    );
                }
            } else {
                $image_name = $_FILES['image']['name'];
                $image_destiny = FCPATH . 'assets/images/productos/' . $image_name;
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_destiny)) {
                    $output[] = array(
                        'status' => false,
                        'response' => 'No se pudo copiar la imagen al servidor.'
                    );
                } else {
                    $edit_data['image_url'] = $image_name;
                    if (!$this->Model_Product->edit($edit_data)) {
                        $output[] = array(
                            'status' => false,
                            'response' => 'No fue posible editar al producto.'
                        );
                    } else {
                        $output[] = array(
                            'status' => true,
                            'response' => 'El producto fue editado correctamente.'
                        );
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
                    $table_data = $this->Model_Product->all();
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
}
