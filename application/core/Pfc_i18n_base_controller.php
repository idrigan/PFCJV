<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

abstract class Pfc_i18n_base_controller extends CI_Controller
{

    protected $translations;

    protected $header_files;

    protected $footer_files;

    protected $template;

    protected $available_locales;
    
    protected $session;

    function __construct ()
    {
        parent::__construct();
        // Load libraries
        $this->load->library(array(
                'parser'
        ));
        // Load helpers
        $this->load->helper(array(
                'var_helper',
                'url_helper',
                'redirect_helper',
        ));
        
        $CI = & get_instance();
      
       // $this->load_available_locales();
        
        $this->translations = array();
        $this->template_files = array();
        
        $this->session = new Session();
        
        $locale = $this->setLanguage($this->uri->segment(1));
      
        
        $this->session->changeLanguage($locale);
        //lang change detected
       /* $short_locale = $CI->input->get('lang', TRUE);
        if ($short_locale !== FALSE ) {
            $locale = "";
            
            switch ($short_locale) {
                case "es":
                    $locale = "es_ES";
                    break;
                case "en":
                    $locale = "en_GB";
                default:
                    break;
            }*/
            //check if $locale is available
//             $available_locale = safe_array_get($locale, $this->available_locales);
//             if (!isempty_array($available_locale)){
          //      self::set_language($locale);
//             }
            
            
             self::set_language($locale, FALSE);
  //      }
        
        
    }
    
   

    public function set_template ($template)
    {
        $this->template = $template;
        if (! isempty($this->template) && substr($this->template, - 1) != '/') {
            $this->template .= "/";
        }
    }

    public function set_template_header_files ($templates = array())
    {
        $this->header_files = $templates;
    }

    public function set_template_footer_files ($templates = array())
    {
        $this->footer_files = $templates;
    }
    
    protected function add_template_datavars($data){
        if (!isempty_array($data)){
            $this->translations = array_merge($this->translations, $data);
        }
    }

    public function load_language_file ($langfile)
    {
        if (! isempty($langfile)) {
            // Load language
            $language = $this->session->language();
            $data = $this->lang->load($langfile, $language, TRUE);
            if (is_array($data)) {
                $this->translations = array_merge($this->translations, $data);
            }
            unset($language);
            unset($data);
        }
    }

    public function load_template_language_file ($langfile)
    {
        if (! isempty($langfile)) {
            // Load language
            $language = $this->session->language();
            $data = $this->lang->load($this->template . $langfile, $language, TRUE);
            if (is_array($data)) {
                $this->translations = array_merge($this->translations, $data);
            }
            unset($language);
            unset($data);
        }
    }

    public function get_translation ($key = '')
    {
        if (isempty($key)) {
            return FALSE;
        }
        
        return $this->translations[$key];
    }

    private function protect_htmlentities (&$data = array())
    {
        array_walk_recursive($data, 
                function  (&$value)
                {
                    if (is_array($value)) {
                        $value = self::protect_htmlentities($value);
                    }
                    
                    if (strpos($value, "\"") || strpos($value, "'")) {
                        $value = htmlentities($value, ENT_QUOTES);
                    }
                });
    }

    /**
     * Construye la vista con los ficheros de cabecera y pie del template asignado
     *
     * @param array $templates
     *            array con los ficheros de vista que generan el contenido
     * @param array $data
     *            variables a pasar a los templates de contenido
     */
    public function parse_document ($templates, $data = array())
    {
        if (is_null($data)) {
            $data = array();
        }
        $data['var_available_locales'] = $this->available_locales;
        
        $temp_translations = array_merge($this->translations, $data);
        
        // REVIEW not really needeed
        // self::protect_htmlentities($temp_translations);
        
        if (is_array($this->header_files)) {
            foreach ($this->header_files as $template) {
                $this->parser->parse($this->template . $template, $temp_translations);
            }
        }
        
        if (is_array($templates)) {
            foreach ($templates as $template) {
                $this->parser->parse($template, $temp_translations);
            }
        }
        
        if (is_array($this->footer_files)) {
            foreach ($this->footer_files as $template) {
                $this->parser->parse($this->template . $template, $temp_translations);
            }
        }
    }

    /**
     * Construye la vista sin los ficheros de cabecera ni pie del template asignado
     *
     * @param array $templates
     *            array con los ficheros de vista a procesar que estan dentro de la carpeta del template asignado
     * @param array $data
     *            variables a pasar a los templates de contenido
     */
    public function parse_template ($templates, $data = array())
    {
        $result = "";
        
        if (is_null($data)) {
            $data = array();
        }
        $data['var_available_locales'] = $this->available_locales;
        
        $temp_translations = array_merge($this->translations, $data);
        
        if (is_array($templates)) {
            foreach ($templates as $template) {
                $result .= $this->parser->parse($this->template . $template, $temp_translations, TRUE);
            }
        }
        
        return $result;
    }

    /**
     * Construye la vista sin los ficheros de cabecera ni pie del template asignado
     *
     * @param array $templates
     *            array con los ficheros de vista.
     * @param array $data
     *            variables a pasar a los templates de contenido
     */
    public function parse_view ($templates, $data = array())
    {
        $result = "";
        
        if (is_null($data)) {
            $data = array();
        }
        $data['var_available_locales'] = $this->available_locales;
        
        $temp_translations = array_merge($this->translations, $data);
        
        if (is_array($templates)) {
            foreach ($templates as $template) {
                $result .= $this->parser->parse($template, $temp_translations, TRUE);
            }
        }
        
        return $result;
    }

    //Default redirection policy on language changed!
    public function after_language_set ($current_uri_segment){
        redirect(base_url($current_uri_segment));
    }
    

    public function set_language ($language, $trigger_after_language_set = TRUE)
    {
        // Default language
        /*if (isempty($language) || strlen($language) != 5) {
            $language = config_item('language');
        } else {
            // case insensitive params :(
            $language = substr($language, 0, 3) . strtoupper(substr($language, 3, 2));
        }
        // retrieve current route key
        $route_key = get_current_route_key();
        // store language in session
        $this->session->changeLanguage($language);
        
        // call trigger
        if ($trigger_after_language_set) {
            //$this->after_language_set(current_uri_segment());
            
            //get current route key
            $this->after_language_set(get_route($route_key));
        }*/
    }

    protected function not_found ()
    {
       show_404();
        
    }
    
    private function load_available_locales () {
        $this->load->model('locale_model', '', TRUE);
        $locales_temp = $this->locale_model->get_all_active_locale();
        
        $this->available_locales = array();
        
        foreach ($locales_temp as $locale) {
            $array = array();
            $array = $locale;
            $array['s_codigo_locale_corto'] = substr($locale['c_codigo_locale'], 0, 2);
            $this->available_locales[$locale['c_codigo_locale']] = $array;
        }
        
        $this->validate_available_locales();
    }

    private function validate_available_locales ()
    {
        $ruta = FCPATH . "application" . DIRECTORY_SEPARATOR . "language" . DIRECTORY_SEPARATOR;
        foreach ($this->available_locales as $locale) {
            $check_ruta = $ruta . $locale['c_codigo_locale'];
            if (! is_dir($check_ruta)) {
                unset($this->available_locales[$locale['c_codigo_locale']]);
            }
        }
    }
    
    
    private function setLanguage($lang){
    	if (!CONST_MOD_MULTILANGUAGE){
    		return "es";
    	}else{
    		return $lang;
    	}
    	
    }
    
}