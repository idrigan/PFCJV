<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class Login_controller extends Default_template_controller {
	
	
	public function __construct(){
		parent::__construct();
	}
	
	protected function renderHeader($head){
		
	}
	
	
	protected function renderHeader($header){
		
	}
	
	protected function renderView($nameView , $params = array()){
		$this->load->view();
	}
	
	protected function renderFooter($footer){
		
	}
}