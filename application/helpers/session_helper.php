<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Façade for Session_service.php
 * Session helper to simplify access to session service, especially for views.
 */


function &_initialize_session_service() {
    
    $_ci = & get_instance();
    if (!isset($_ci->session_service)){
        log_message("DEBUG", "session_helper->session_service not loaded, loading now. POSIBLE PERFORMANCE DEGRADATION!!! ");
        $_ci->load->library('session_service');
    }
    
    return $_ci->session_service;
    
}

if (! function_exists('session_get_language')) {

    function session_get_language ()
    {
        $ss = _initialize_session_service();
        return $ss->get_language();
    }
}

if (! function_exists('session_get_html_language')) {

    function session_get_html_language ()
    {
        $ss = _initialize_session_service();
        return $ss->get_html_language();
        
    }
}

if (! function_exists('session_get_short_language')) {

	function session_get_short_language ()
	{
		$ss = _initialize_session_service();
		return substr($ss->get_language(),0,2);

	}
}

if (! function_exists('session_destroy_session')) {

    function session_destroy_session()
    {
        $ss = _initialize_session_service();
        $ss->destroy_session();
    }
}



if (! function_exists('session_get_user')) {

    function session_get_user()
    {
        $ss = _initialize_session_service();
        return $ss->get_user();
    }
}

if (! function_exists('session_get_admin')) {

    function session_get_admin()
    {
        $ss = _initialize_session_service();
        return $ss->get_admin();
    }
}

if (!function_exists('session_get_error_message')){
    function session_get_error_message(){
        $ss = _initialize_session_service();
        return $ss->get_error_message();
    }
}

if (!function_exists('session_has_error_message')){
    function session_has_error_message(){
        $ss = _initialize_session_service();
        return $ss->has_error_message();
    }
}

if (!function_exists('session_remove_error_message')){
    function session_remove_error_message(){
        $ss = _initialize_session_service();
        return $ss->remove_error_message();
    }
}




if (!function_exists('session_get_success_message')){
    function session_get_success_message(){
        $ss = _initialize_session_service();
        return $ss->get_success_message();
    }
}

if (!function_exists('session_has_success_message')){
    function session_has_success_message(){
        $ss = _initialize_session_service();
        return $ss->has_success_message();
    }
}

if (!function_exists('session_remove_success_message')){
    function session_remove_success_message(){
        $ss = _initialize_session_service();
        return $ss->remove_success_message();
    }
}

