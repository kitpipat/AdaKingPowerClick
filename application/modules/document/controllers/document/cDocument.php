<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class cDocument extends MX_Controller {

    public function __construct() {

        parent::__construct ();
        $this->load->helper('url');

    }

    //Function : Get Image Product
    public function FMvCDOCGetPdtImg(){

        $tPdtCode = $this->input->post('tPdtCode');

        $aDataSearch = array(
            'tPdtCode' => $this->input->post('tPdtCode'),
        );

        $aPdtImgList =  FCNxHDOCGetPdtImg($aDataSearch);
        
        $aData = array(
            'aPdtImgList'  =>  $aPdtImgList,
        );

        $this->load->view('document/document/wDocumentPdtImgList',$aData);

    }

}