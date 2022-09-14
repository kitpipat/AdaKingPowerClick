<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cReprintEJ extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('ejtool');
        $this->load->model('sale/reprintej/mReprintEJ');
    }

    public function index($nEJBrowseType,$tEJBrowseOption){
        $aDataConfigView    =  [
            'nEJBrowseType'     => $nEJBrowseType,
            'tEJBrowseOption'   => $tEJBrowseOption,
            'aAlwEventEJ'       => FCNaHCheckAlwFunc('dcmReprintEJ/0/0'),
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave()
        ];
        $this->load->view('sale/reprintej/wReprintEJ',$aDataConfigView);
    }

    // Functionality: Function Call Page EJ Main Form Print
    // Parameters: Ajax and Function Parameter
    // Creator: 09/10/2019 wasin(Yoshi)
    // Last Update: -
    // Return: String View
    // ReturnType: View
    public function FSvCEJCallPageMainFormPrint(){
        $aDataConfigView    =  [
            'aAlwEventEJ'       => FCNaHCheckAlwFunc('dcmReprintEJ/0/0'),
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave()
        ];
        $this->load->view('sale/reprintej/wReprintEJPageMainForm',$aDataConfigView);
    }

    // Functionality: Get Data ABB In Database
    // Parameters: Ajax and Function Parameter
    // Creator: 11/10/2019 wasin(Yoshi)
    // Return: Data View ABB
    // ReturnType: object
    public function FSoCEJGetDataAbbInDB(){
        $aDataFilterEJ  = $this->input->post();
        $nPageCurrent   = $aDataFilterEJ['nPageCurrent'];
        if($nPageCurrent == '' || $nPageCurrent == null){
            $nPage  = 1;
        }else{
            $nPage  = $nPageCurrent;
        }
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aDataWhere = [
            'nPage'         => $nPage,
            'nRow'          => 2,
            'nLangEdit'     => $nLangEdit,
            'aDataFilterEJ' => $aDataFilterEJ
        ];
        $aDataListEJ        = $this->mReprintEJ->FSaMGetListDataEJ($aDataWhere);
        $aDataConfigVuew    = [
            'aDataListEJ'   => $aDataListEJ,
            'nPage'         => $nPage,
        ];
        $this->load->view('sale/reprintej/wReprintEJPageShowAbb',$aDataConfigVuew);
    }

    // Functionality: Call Page Render Print ABB
    // Parameters: Ajax and Function Parameter
    // Creator: 15/10/2019 wasin(Yoshi)
    // Return: Data View ABB
    // ReturnType: object
    public function FSoCEJCallPageRenderPrintABB(){
        $aDataFilterEJ      = $this->input->post();
        $aDataListEJ        = $this->mReprintEJ->FSaMGetDataRenderPrintABB($aDataFilterEJ);
        if(isset($aDataListEJ) && !empty($aDataListEJ)){
            // Update Print Count
            $this->mReprintEJ->FSnMUpdPrintCount($aDataFilterEJ);
            $aDataConfigVuew    = [
                'aDataListEJ'   => $aDataListEJ,
            ];
            $tViewImageHtml = $this->load->view('sale/reprintej/wReprintEJPageRenderABB',$aDataConfigVuew,true);
            $aDataReturn    = [
                'nStaCallPage'      => 1,
                'tStaMessg'         => 'Event Render Success',
                'tViewImageHtml'    => $tViewImageHtml,
            ];
        }else{
            $aDataReturn    = [
                'nStaCallPage'      => 800,
                'tStaMessg'         => 'Not Found Data.',
            ];
        }
        echo json_encode($aDataReturn);
    }
}
