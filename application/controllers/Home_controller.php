<?php

class Home_controller extends Pfc_default_template_base_controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){

        $this->parse_document(array(
            'home_view'
        ),array(
            //'var_user' => session_get_admin()
        ));
    }
}