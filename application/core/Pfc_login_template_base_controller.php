<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

abstract class Pfc_login_template_base_controller extends Pfc_i18n_base_controller {

	private $footer_vendor_js;

    private $footer_core_template_js;

    private $footer_page_js;

    private $head_css;

    private $head_js;

    function __construct ()
    {
        parent::__construct();
        parent::set_template("templates/login/");

        // set template files
        parent::set_template_header_files(array(
            'head',
            'header'
        ));
        parent::set_template_footer_files(array(
            'footer'
        ));

        // load templates' language files
        parent::load_template_language_file('header');
        parent::load_template_language_file('footer');

        // configure defaul head css
        $this->configure_default_head_css();

        // configure defaul head js
        $this->configure_default_head_js();

        // configure footer vendor js'
        $this->configure_default_footer_vendor_js();

        // configure footer core template js'
        $this->configure_default_footer_core_template_js();

        // configure footer page js'
        $this->configure_default_footer_page_js();


    }


    private function configure_default_head_css ()
    {
        // default head css' array
        $this->head_css = array(

        );
    }

    private function configure_default_head_js ()
    {
        // default head js' array
        $this->head_js = array(

        );
    }

    private function configure_default_footer_vendor_js ()
    {
        // default vendor js' array
        $this->footer_vendor_js = array(


        );

    }

    private function configure_default_footer_core_template_js ()
    {
        // default core template js' array
        $this->footer_core_template_js = array(

        );
    }

    private function configure_default_footer_page_js ()
    {
        // default page js' array
        $this->footer_page_js = array(


        );
    }

    private function build_template_datavars(){
        return array(
            'var_head_css' => $this->head_css,
            'var_head_js' => $this->head_js,
            'var_footer_vendor_js' => $this->footer_vendor_js,
            'var_footer_core_template_js' => $this->footer_core_template_js,
            'var_footer_page_js' => $this->footer_page_js
        );
    }

    private function add_data(&$var, $data){
        if (is_array($data)){
            if (!isempty_array($data)){
                $var = array_merge($var, $data);
            }
        } else {
            if (!isempty($data)){
                $var = array_merge($var, array($data));
            }
        }
    }

    protected function add_head_css($data){
        $this->add_data($this->head_css, $data);
    }

    protected function add_head_js($data){
        $this->add_data($this->head_js, $data);
    }

    protected function add_footer_vendor_js($data){
        $this->add_data($this->footer_vendor_js, $data);
    }

    protected function add_footer_core_template_js($data){
        $this->add_data($this->footer_core_template_js, $data);
    }

    protected function add_footer_page_js($data){
        $this->add_data($this->footer_page_js, $data);
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
        //add datavars to scope
        parent::add_template_datavars($this->build_template_datavars());
        //call to parent
        parent::parse_document($templates, $data);

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

        //add datavars to scope
        parent::add_template_datavars($this->build_template_datavars());

        //call to parent
        return parent::parse_template($templates, $data);
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
        //add datavars to scope
        parent::add_template_datavars($this->build_template_datavars());

        //call to parent
        return parent::parse_view($templates, $data);
    }
}