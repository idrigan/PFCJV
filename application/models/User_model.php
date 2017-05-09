<?php

/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 10/05/17
 * Time: 0:21
 */
class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function check_credentials($user,$password){
        if (isempty($user) || isempty($password)){
            return FALSE;
        }

        $user = $this->db->escape($user);
        $password = $this->db->escape(sha1($password));

        $sql = "";

        $query = $this->db->query($sql);

        if ($query->num_rows() >0){
            $result = $query->result('array');
            return $result[0];
        }

        return FALSE;
    }
}