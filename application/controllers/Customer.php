<?php

class Customer extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_product', 'product');
        $this->load->model('Model_customer', 'customer');
    }

    function index()
    {
        // $header = $this->input->get_request_header('authorization', TRUE);
        // $data = is_customer($header);
        $response = $this->product->getAllProduct()->result();
        response('success', $response, 200);
    }

    function addtransaction()
    {
        $header = $this->input->get_request_header('authorization', TRUE);
        $data = is_customer($header);

        $this->form_validation->set_rules('id_product', 'Product', 'required|trim|numeric');
        $this->form_validation->set_rules('qty', 'Quantity', 'required|trim|numeric');

        if ($this->form_validation->run() == FALSE) {
            response('error', $this->form_validation->error_array(), 200);
        } else {
            $id_product = $this->input->post('id_product', true);
            $qty = $this->input->post('qty', true);
            $product = $this->db->get_where('product', ['id' => $id_product])->row();

            $total = $product->price * $qty;
            $customer = $this->db->get_where('user', ['id' => $data->id])->row();

            if ($qty >= 5) {
                $reward = 40 + $customer->reward; //reward A
            } else {
                $reward = 20 + $customer->reward; //reward B
            }

            $dataInsert = [
                "id" => "TRX" . time(),
                "date" => date('Y-m-d H:i:s'),
                "id_customer" => $data->id,
                "id_product" => $id_product,
                "qty" => $qty,
                "total" => $total,
                "id_merchant" => $product->id_merchant
            ];

            $this->db->insert('transaction', $dataInsert);
            $this->db->update('user', ['reward' => $reward], ['id' => $data->id]);

            response('success', ['affected_rows' => $this->db->affected_rows()], 200);
        }
    }

    function transaction()
    {
        $header = $this->input->get_request_header('authorization', TRUE);
        $data = is_customer($header);

        $response = $this->customer->getTransaction($data->id)->result();

        response('success', $response, 200);
    }

    function profile()
    {
        $header = $this->input->get_request_header('authorization', TRUE);
        $data = is_customer($header);

        $response = $this->db->get_where('user', ['id' => $data->id])->row();
        response('success', $response, 200);
    }
}
