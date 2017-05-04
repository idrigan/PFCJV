<?php

class AjaxDatatableController extends PcfAjaxTemplateBaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getData(){
        //ESTOS SON LOS DATOS GENERICOS QUE MANDAN LOS DATATABLE
        $start = $this->input->get('start');
        $limit = $this->input->get('length');
        $search = $this->input->get('search');
        $search  = safe_array_get('value',$search);
        $order = $this->input->get('order');

        //PARAMETROS QUE ENVIAMOS NOSOTROS

    }
}