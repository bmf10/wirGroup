<?php

class Model_merchant extends CI_Model
{
    function getTransaction($id)
    {
        return $this->db->query('SELECT
    `transaction`.*
    , `user`.`name` AS customer
FROM
    `transaction`
    INNER JOIN `user` 
        ON (`transaction`.`id_customer` = `user`.`id`)
        WHERE id_merchant = 8
        ORDER BY `transaction`.`date` DESC;');
    }
}
