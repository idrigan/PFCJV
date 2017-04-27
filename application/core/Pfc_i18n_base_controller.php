<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

abstract class Pfc_i18n_base_controller extends CI_Controller
{

    protected $translations;

    protected $header_files;

    protected $footer_files;

    protected $template;

    protected $page_title;

    const DEFAULT_PAGE_TITLE = "{page-title}";

    public function __construct ()
    {
        log_message('debug', "Loading Controller " . get_class($this));

        parent::__construct();
        // Load libraries
        $this->load->library(array(
            'session_service',
            'parser'
        ));
        // Load helpers
        $this->load->helper(array(
            'var_helper',
            'url_helper',
            'session_helper',
            'redirect_helper',
          //  'formatter_helper'


        ));

        $this->translations = array();
        $this->template_files = array();

        $this->set_default_page_title();

    }

    public function set_page_title($page_title){
        $this->page_title = $page_title;
        if (!isempty($this->page_title)){
            global $page_title;
            $page_title = $this->page_title;
        }
    }

    public function set_default_page_title(){
        $this->set_page_title($this::DEFAULT_PAGE_TITLE);
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
            $language = $this->session_service->get_language();
            $data = $this->lang->load($langfile, $language, TRUE);
            if (is_array($data)){
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
            $language = $this->session_service->get_language();
            $data = $this->lang->load($this->template . $langfile, $language, TRUE);
            if (is_array($data)){
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

        return safe_array_get($key, $this->translations);
    }

    private function protect_htmlentities(&$data = array()){
        array_walk_recursive($data, function (&$value){
            if (is_array($value)){
                $value = self::protect_htmlentities($value);
            }

            if (strpos($value, "\"") || strpos($value, "'")){
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
        $temp_translations = array_merge($this->translations, $data);

        //REVIEW not really needeed
        //self::protect_htmlentities($temp_translations);


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
        $temp_translations = array_merge($this->translations, $data);

        if (is_array($templates)) {
            foreach ($templates as $template) {
                $result .= $this->parser->parse($template, $temp_translations, TRUE);
            }
        }

        return $result;
    }

    //TODO: language change
    //public abstract function after_language_set ();

    public function set_language ($language, $trigger_after_language_set = TRUE)
    {
        // Default language
        if (isempty($language) || strlen($language) != 5) {
            $language = config_item('language');
        } else {
            // case insensitive params :(
            $language = substr($language, 0, 3).strtoupper(substr($language, 3, 2));
        }
        // FIXME store language in session
        $_SESSION['language'] = $language;

        // call trigger
        if ($trigger_after_language_set) {
            $this->after_language_set();
        }
    }

    protected function not_found ()
    {
        show_404();
    }
}
