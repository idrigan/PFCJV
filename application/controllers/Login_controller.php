<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_controller extends Pfc_login_template_base_controller {
	
	
	public function __construct(){
		parent::__construct();
	}

	public function index(){

        $this->load_language_file('login');

		$this->parse_document(array(
				'login_view'
		),array(
				//'var_user' => session_get_admin()
		));
    }

    public function authenticate(){

    }

}