<?php

class Model_customer extends CI_Model
{
    function getTransaction($id)
    {
        return $this->db->query('SELECT
    `transaction`.*
    , `user`.`name` AS merchant
FROM
    `transaction`
    INNER JOIN `user` 
        ON (`transaction`.`id_merchant` = `user`.`id`)
        WHERE id_merchant = 8
        ORDER BY `transaction`.`date` DESC;');
    }
}
