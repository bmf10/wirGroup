<?php

class Merchant extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_merchant', 'merchant');
    }

    function index()
    {
        $header = $this->input->get_request_header('authorization', TRUE);
        $data = is_merchant($header);

        $response = $this->db->get_where('product', ['id_merchant' => $data->id])->result();
        response('success', $response, 200);
    }

    function addproduct()
    {
        $header = $this->input->get_request_header('authorization', TRUE);
        $data = is_merchant($header);

        $this->form_validation->set_rules('product_name', 'Product name', 'required|trim');
        $this->form_validation->set_rules('product_desc', 'Product Description', 'required|trim');
        $this->form_validation->set_rules('price', 'Price', 'required|trim');


        if ($this->form_validation->run() == FALSE) {
            response('error', $this->form_validation->error_array(), 200);
        } else {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = 1024 * 5; //5mb
            $config['file_name'] = "image-" . time();

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image')) {
                $deleteChar = ['<p>', '</p>'];
                $error = str_replace($deleteChar, '', $this->upload->display_errors());
                response('error', $error, 200);
            } else {
                $upload_data = $this->upload->data();
                $image = $upload_data['file_name'];

                $dataInsert = [
                    'product_name' => $this->input->post('product_name', true),
                    'product_desc' => $this->input->post('product_desc', true),
                    'image' => $image,
                    'stock' => $this->input->post('stock', true) ? $this->input->post('stock', true) : 0,
                    'id_merchant' => $data->id,
                    'price' => $this->input->post('price', true)
                ];

                $this->db->insert('product', $dataInsert);
                response('success', ['affected_rows' => $this->db->affected_rows()], 200);
            }
        }
    }

    function product($id)
    {
        $header = $this->input->get_request_header('authorization', TRUE);
        $data = is_merchant($header);

        $result = $this->db->get_where('product', ['id_merchant' => $data->id, 'id' => $id])->result();
        response('success', $result, 200);
    }

    function delete($id)
    {
        $header = $this->input->get_request_header('authorization', TRUE);
        $data = is_merchant($header);

        $dataProduct = $this->db->get_where('product', ['id' => $id, 'id_merchant' => $data->id])->row();

        if ($dataProduct) {

            if (!$this->db->delete('product', ['id' => $id])) {
                response('error', "Cannot delete this product, You have transaction with this product", 200);
            } else {
                unlink('./uploads/' . $dataProduct->image);
                response('success', ['affected_rows' => $this->db->affected_rows()], 200);
            }
        } else {
            response('error', "Product not found", 200);
        }
    }

    function update($id)
    {
        $header = $this->input->get_request_header('authorization', TRUE);
        $data = is_merchant($header);
        $dataProduct = $this->db->get_where('product', ['id' => $id, 'id_merchant' => $data->id])->row();

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 1024 * 5; //5mb
        $config['file_name'] = "image-" . time();

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('image')) {
            $dataInsert = [
                'product_name' => $this->input->post('product_name', true) ? $this->input->post('product_name', true) : $dataProduct->product_name,
                'product_desc' => $this->input->post('product_desc', true) ? $this->input->post('product_desc', true) : $dataProduct->product_desc,
                'image' => $dataProduct->image,
                'stock' => $this->input->post('stock', true) ? $this->input->post('stock', true) : $dataProduct->stock,
                'id_merchant' => $data->id,
                'price' => $this->input->post('price', true) ? $this->input->post('price', true) : $dataProduct->price,
            ];

            $this->db->update('product', $dataInsert, ['id' => $id]);
            response('success', ['affected_rows' => $this->db->affected_rows()], 200);
        } else {
            unlink('./uploads/' . $dataProduct->image);
            $upload_data = $this->upload->data();
            $image = $upload_data['file_name'];

            $dataInsert = [
                'product_name' => $this->input->post('product_name', true) ? $this->input->post('product_name', true) : $dataProduct->product_name,
                'product_desc' => $this->input->post('product_desc', true) ? $this->input->post('product_desc', true) : $dataProduct->product_desc,
                'image' => $image,
                'stock' => $this->input->post('stock', true) ? $this->input->post('stock', true) : $dataProduct->stock,
                'id_merchant' => $data->id,
                'price' => $this->input->post('price', true) ? $this->input->post('price', true) : $dataProduct->price,
            ];

            $this->db->update('product', $dataInsert, ['id' => $id]);
            response('success', ['affected_rows' => $this->db->affected_rows()], 200);
        }
    }

    function transaction()
    {
        $header = $this->input->get_request_header('authorization', TRUE);
        $data = is_merchant($header);

        $response = $this->merchant->getTransaction($data->id)->result();

        response('success', $response, 200);
    }

    function profile()
    {
        $header = $this->input->get_request_header('authorization', TRUE);
        $data = is_merchant($header);

        $response = $this->db->get_where('user', ['id' => $data->id])->row();
        response('success', $response, 200);
    }
}
