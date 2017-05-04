<?php

abstract class PcfAjaxTemplateBaseController extends CI_Controller{

    public function __construct(){
        parent::__construct();

        //TODO:cargaas helpers
    }


    public function response_ko($error){
        //TODO: cambiar cabeceras para json
        //TODO: enviar el error en json
    }

    protected function response_ok ($data = array(), $total_records = 0, $total_display_records=0)
    {
        //ESTO SON PARA LOS DATATABLES

        $this->write_headers_no_cache();

        header('Content-Type: application/json');
        echo json_encode(array(
            "resultado" => "OK",
            "error" => "",
            "descripcion" => "",
            "data" => $data,
            "iTotalRecords" => $total_records,
            "iTotalDisplayRecords" => $total_display_records
        ));
        die(); // <--cleanup
        exit(); // and exit
    }

}






