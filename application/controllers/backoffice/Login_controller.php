<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_controller extends Pfc_login_template_base_controller {
	
	
	public function __construct(){
		parent::__construct();
	}

	public function index($form_data = array()){

        $this->load_language_file('backoffice/login');

        $this->load->helper('messages_helper');

		$this->parse_document(array(
				'backoffice/login_view'
		),array(
				'var_user' => safe_array_get('user',$form_data)
		));
    }

    public function authenticate(){
        $this->load->library('form_validation');

        $this->form_validation->set_rules('user', '{user}','trim|required');
		$this->form_validation->set_rules('password', '{password}','trim|required|callback_check_credentials');


		if ($this->form_validation->run() == FALSE)
        {

            $this->session_service->set_error_message($this->form_validation->error_array());
            $this->index(array('user'=>$this->input->post('user',TRUE)));
        }
        else
        {
            redirect(base_url(get_route_backoffice_home()));
        }
    }

    public function check_credentials($password)
    {
        $user = $this->input->post('user');

        $this->load->model('user_model', '', TRUE);

        $user = $this->user_model->check_credentials($user, $password);

        if ($user !== FALSE){
            $this->session_service->set_admin($user);
            return TRUE;
        }
        $this->form_validation->set_message('check_credentials','{error-incorrect-user}');
        return FALSE;
    }

}