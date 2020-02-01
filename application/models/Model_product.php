<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_product extends CI_Model
{
    function getAllProduct()
    {
        return $this->db->query('SELECT
    `product`.*
    , `user`.`name` AS merchant
FROM
    `product`
    INNER JOIN `user` 
        ON (`product`.`id_merchant` = `user`.`id`);');
    }
}
