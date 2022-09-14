<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cPermissionApvDoc extends MX_Controller {

    public function __construct(){
        date_default_timezone_set("Asia/Bangkok");
        parent::__construct ();
        $this->load->model('PermissionApvDoc/PermissionApvDoc/mPermissionApvDoc');
    }

    public function index($nBrowseType,$tBrowseOption){
        $aData['nBrowseType']                = $nBrowseType;
        $aData['tBrowseOption']              = $tBrowseOption;
		$aData['aAlwEventPermissionApv']     = FCNaHCheckAlwFunc('PermissionApproveDoc/0/0'); //Controle Event
        $aData['vBtnSave']                   = FCNaHBtnSaveActiveHTML('PermissionApproveDoc/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('PermissionApvDoc/PermissionApvDoc/wPermissionApvDoc',$aData);
    }

    //Functionality : call view List
    //Parameters : Ajax jPermissionApvDoc()
    //Creator : 17/02/2020 Saharat(Golf)
    //Last Modified : -
    //Return : view
    //Return Type : view
    public function FSxCPADCallPageList(){
        $this->load->view('PermissionApvDoc/PermissionApvDoc/wPermissionApvDocList');
    }

    //Functionality : โหลดข้อมูล สิทธิ์การอนุมัติเอกสาร 
    //Parameters : Ajax jPermissionApvDoc()
    //Creator : 17/02/2020 Saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSxCPADDataTable(){
   
        $aAlwEvent          = FCNaHCheckAlwFunc('PermissionApproveDoc/0/0'); //Controle Event
        $nPage              = $this->input->post('nPageCurrent');
        $tSearchAll         = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        
        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $this->session->userdata("tLangEdit"),
            'tSearchAll'    => $tSearchAll
        );

        $aResList   = $this->mPermissionApvDoc->FSaMPADListData($aData);
        $aGenTable  = array(
            'aAlwEvent'     => $aAlwEvent,
            'aDataList'     => $aResList,
            'nPage'         => $nPage,
            'tSearchAll'    => $tSearchAll
        );
        $this->load->view('PermissionApvDoc/PermissionApvDoc/wPermissionApvDocDataTable',$aGenTable);
    }

    //Functionality : Event call Page Edit 
    //Parameters : Ajax jPermissionApvDoc()
    //Creator : 17/02/2020 Saharat(Golf)
    //Last Modified : -
    //Return : String view
    //Return Type : view
    public function FSvCPADEditPage(){

		$aAlwEvent  	        = FCNaHCheckAlwFunc('PermissionApproveDoc/0/0'); //Controle Event
        $nLangEdit              = $this->session->userdata("tLangEdit");
        $nPage                  = $this->input->post('nPageCurrent');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        $aData  = array(
            'nPage'             => $nPage,
            'nRow'              => 10,
            'FTDapTable'        => $this->input->post('tDapTable'),
            'FTDapRefType'      => $this->input->post('tDapRefType'),
            'FNLngID'           => $this->session->userdata("tLangEdit"),
        );
        
        $aResult           = $this->mPermissionApvDoc->FSaMPADSearchByID($aData);
        $aDataEdit  = [
            'aResult'               => $aResult,
            'aAlwEventPad'          => $aAlwEvent,
            'nPage'                 => $nPage,
            'FTDapTable'            => $this->input->post('tDapTable'),
            'FTDapRefType'          => $this->input->post('tDapRefType'),
            'FTSdtDocName'          => $this->input->post('tSdtDocName')
        ];

        $this->load->view('PermissionApvDoc/PermissionApvDoc/wPermissionApvDocAdd',$aDataEdit);
    }

    //Functionality : Event Event Add/Edit 
    //Parameters : Ajax jPermissionApvDoc()
    //Creator : 17/02/2020 Saharat(Golf)
    //Last Modified : -
    //Return : String view
    //Return Type : view
    public function FSvCPADEventAdd(){
        $tDetailItems       = $this->input->post('aDetailItems');
        $aDetailItems       = json_decode($tDetailItems, true);
        $tPadDapTable       = $this->input->post('tPadDapTable');
        $tPadDapRefType     = $this->input->post('tPadDapRefType');

        

        $aDataMaster  = [
            'FTDarTable'        => $tPadDapTable,
            'FTDarRefType'      => $tPadDapRefType,
            'FDLastUpdOn'       => date('Y-m-d H:i:s'),
            'FDCreateOn'        => date('Y-m-d H:i:s'),
            'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
            'FNLngID'           => $this->session->userdata("tLangEdit"),
            'FTCreateBy'        => $this->session->userdata('tSesUsername'),
        ];


        $aResult            = $this->mPermissionApvDoc->FSaMPADAddUpdateMaster($aDetailItems,$aDataMaster);

    }





  
}
?>