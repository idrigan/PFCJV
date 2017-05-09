<?php


class Home_controller extends Pfc_secured_template_base_controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        echo "HOME BACKOFFICE";
    }
}