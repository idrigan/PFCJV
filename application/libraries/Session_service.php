<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Session_service
{

    const DATA_ADMIN_KEY = 'admin';
    const DATA_USER_KEY = 'user';
    
    const DATA_RAL_KEY = 'redirect_after_login';
    const MESSAGE_ERROR_KEY = "error";
    const MESSAGE_SUCCESS_KEY = "success";
    
    const LANGUAGE_KEY = "language";
    const FLASHDATA_KEY = "_flash_oo";
    
    
    private $session_data_keys = array(
            self::MESSAGE_ERROR_KEY,
            self::MESSAGE_SUCCESS_KEY,
            self::LANGUAGE_KEY,
            self::DATA_USER_KEY
    );
    
    private $backoffice_session_data_keys = array(
            self::MESSAGE_ERROR_KEY,
            self::MESSAGE_SUCCESS_KEY,
            self::LANGUAGE_KEY,
            self::DATA_ADMIN_KEY
    );

    private $code_igniter;

    private $session;

    public function __construct ()
    {
        $this->code_igniter = & get_instance();
        if (!isset($this->code_igniter->session)){
     	  $this->code_igniter->load->driver('session');
     	  log_message("DEBUG", "Loading Session driver");
        }
        $this->session = & $this->code_igniter->session;
    }
    
    

    public function get_language ()
    {
        if ($this->session->has_userdata(self::LANGUAGE_KEY)) {
            return $this->session->userdata(self::LANGUAGE_KEY);
        }
        
        return config_item('language');
    }
    
    public function set_language ($language = NULL) {
        if (!isempty($language)){
            $this->session->set_userdata(self::LANGUAGE_KEY, $language);
        }
    }

    public function get_html_language ()
    {
        $lang = $this->get_language();
        
        return preg_replace('/_/i', '-', $lang);
    }
    
    public function set_flash_data($data = NULL){
        $this->session->set_flashdata(self::FLASHDATA_KEY, $data);
    }
    
    public function get_flash_data() {
        return $this->session->flashdata(self::FLASHDATA_KEY);
    }
    
    
    public function destroy_session ()
    {
        $this->session->sess_destroy ();
    }
    
    
    public function set_error_message($message){
        return $this->session->set_userdata(self::MESSAGE_ERROR_KEY,$message);
    }
    
    public function has_error_message(){
        return $this->session->has_userdata(self::MESSAGE_ERROR_KEY);
    }
    
    public function get_error_message(){
         
        if ($this->session->has_userdata(self::MESSAGE_ERROR_KEY)){
             
            return $this->session->userdata(self::MESSAGE_ERROR_KEY);
        }
    }
    
    public function remove_error_message(){
        return $this->session->unset_userdata(self::MESSAGE_ERROR_KEY);
    }
     
    
    public function set_success_message($message){
        $this->session->set_userdata (self::MESSAGE_SUCCESS_KEY,$message);
    }
    
    
    public function get_success_message(){
        if ($this->session->has_userdata(self::MESSAGE_SUCCESS_KEY)){
            return $this->session->userdata(self::MESSAGE_SUCCESS_KEY);
        }
    }
    
    public function remove_success_message(){
        return  $this->session->unset_userdata(self::MESSAGE_SUCCESS_KEY);
    }
    
    
    public function has_success_message(){
        return $this->session->has_userdata(self::MESSAGE_SUCCESS_KEY);
    }
    
    public function set_redirect_after_login ($url)
    {
        $this->session->set_userdata(self::DATA_RAL_KEY, $url);
    }
    
    public function get_redirect_after_login ()
    {
        if ($this->session->has_userdata(self::DATA_RAL_KEY)) {
            return $this->session->userdata(self::DATA_RAL_KEY);
        }
    
        return NULL;
    }
    
    public function remove_redirect_after_login ()
    {
        $this->session->unset_userdata(self::DATA_RAL_KEY);
    }
    
    
    
    
    /*********************************************************************************************/
    /*                                BACKOFFICE                                                 */
    /*********************************************************************************************/
    
    private function build_admin_for_session(&$admin){
        if (isempty($admin) || isempty_array($admin)){
            return FALSE;
        }
    
        return array_extract_by_keys($admin, array ('i_id_administrador', 's_email', 'b_activo'));
    }
    
    public function set_admin ($array)
    {
        $this->session->set_userdata(self::DATA_ADMIN_KEY, $this->build_admin_for_session($array));
    }
    
    public function get_admin ()
    {
        if ($this->session->has_userdata(self::DATA_ADMIN_KEY)) {
            return $this->session->userdata(self::DATA_ADMIN_KEY);
        }
    
        return NULL;
    }
    
    public function remove_admin ()
    {
        $this->session->unset_userdata(self::DATA_ADMIN_KEY);
    }
    
    public function is_admin_logged_in () {
        $admin = $this->get_admin();
        return ((!isempty_array($admin)) && (!isempty(safe_array_get('i_id_administrador', $admin))));
    }
    
    public function clear_backoffice_session_data(){
        //clear session user data
        $this->session->unset_userdata($this->backoffice_session_data_keys);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    /*********************************************************************************************/
    /*                                     WEB                                                   */
    /*********************************************************************************************/
    
    private function build_user_for_session(&$user){
        if (isempty($user) || isempty_array($user)){
            return FALSE;
        }
    
        return array_extract_by_keys($user, array ('i_id_usuario', 's_username', 'b_activo'));
    }
    
    public function set_user ($array)
    {
        $this->session->set_userdata(self::DATA_USER_KEY, $this->build_user_for_session($array));
    }
    
    public function get_user ()
    {
        if ($this->session->has_userdata(self::DATA_USER_KEY)) {
            return $this->session->userdata(self::DATA_USER_KEY);
        }
    
        return NULL;
    }
    
    public function remove_user ()
    {
        $this->session->unset_userdata(self::DATA_USER_KEY);
    }
    
    public function is_user_logged_in () {
        $user = $this->get_user();
        return ((!isempty_array($user)) && (!isempty(safe_array_get('i_id_usuario', $user))));
    }
    
    public function clear_session_data(){
        //clear session user data
        $this->session->unset_userdata($this->session_data_keys);
    }
    
}