<?php 
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cPurchaseorder extends MX_Controller {

	public function __construct() {
            parent::__construct ();
            $this->load->helper("file");
            $this->load->model('company/company/mCompany');
            $this->load->model('company/branch/mBranch');
            $this->load->model('company/shop/mShop');
            $this->load->model('payment/rate/mRate');
            $this->load->model('company/vatrate/mVatRate');
            $this->load->model('document/purchaseorderNew/mPurchaseorder');
    }

    public function index($nBrowseType,$tBrowseOption){

            // $aStoreParam = array(
            //         "tTblName"=>'TAPTPiHD',
            //         "tDocType"=>4,
            //         "tBchCode"=>"00001",
            //         "tShpCode"=>"00001",
            //         "tPosCode"=>"00001",
            //         "dDocDate"=>date("Y-m-d")
            // );
       
            // $aAutogen = FCNaHAUTGenDocNo($aStoreParam);
            // echo $aAutogen[0]["FTXxhDocNo"];
            // exit;

        $aData['nBrowseType']       = $nBrowseType;
        $aData['tBrowseOption']     = $tBrowseOption;
		$aData['aPermission']       = FCNaHCheckAlwFunc('docPO/0/0'); 
        $aData['vBtnSave']          = FCNaHBtnSaveActiveHTML('docPO/0/0'); 
        $this->load->view('document/purchaseorderNew/wPurchaseorder',$aData);
    }

    //List 
    public function FSxCDPODocumentList(){
        $this->load->view('document/purchaseorderNew/wPurchaseorderSearchList');    
    }

    //Datatable
    public function FSxCDPODocumentDataTable(){
        $tAdvanceSearchData     = $this->input->post('oAdvanceSearch');
        $nPage                  = $this->input->post('nPageCurrent');
        $aAlwEvent              = FCNaHCheckAlwFunc('docPO/0/0');
        $nOptDecimalShow        = FCNxHGetOptionDecimalShow();

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }

        $nLangResort            = $this->session->userdata("tLangID");
        $nLangEdit              = $this->session->userdata("tLangEdit");
        $aData = array(
            'FNLngID'           => $nLangEdit,
            'nPage'             => $nPage,
            'nRow'              => 10,
            'aAdvanceSearch'    => $tAdvanceSearchData
        );

        $aList      = $this->mPurchaseorder->FSaMDPOList($aData);
        $aGenTable  = array(
            'aAlwEvent'         => $aAlwEvent,
            'aDataList'         => $aList,
            'nPage'             => $nPage,
            'nOptDecimalShow'   => $nOptDecimalShow
        );

        $tTWIViewDataTable = $this->load->view('document/purchaseorderNew/wPurchaseorderDataTable', $aGenTable ,true);
        $aReturnData = array(
            'tViewDataTable'    => $tTWIViewDataTable,
            'nStaEvent'         => '1',
            'tStaMessg'         => 'Success'
        );
        echo json_encode($aReturnData);
    }

    //Page เพิ่มข้อมูล หรือ แก้ไขข้อมูล
    public function FSxCDPODocumentPageAdd(){
        try{
            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

            //Lang ภาษา
            $nLangEdit          = $this->session->userdata("tLangEdit");

            $aDataConfigViewAdd = array(
                'nOptDecimalShow'   => $nOptDecimalShow,
                'aDataDocHD'        => array('rtCode'=>'99')
            );

            $tViewPageAdd       = $this->load->view('document/purchaseorderNew/wPurchaseorderPageAdd',$aDataConfigViewAdd,true);
            $aReturnData        = array(
                'tViewPageAdd'      => $tViewPageAdd,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //โหลดข้อมูล Tmp
    public function FSxCDPODocumentLoadPDTTmp(){
        //สิทธิการทำงาน
        $aAlwEvent                  = FCNaHCheckAlwFunc('docPO/0/0');

        //Call Advance Table
        $tTableGetColumeShow        = 'TAPTPoHD';
        $aColumnShow                = FCNaDCLGetColumnShow($tTableGetColumeShow);

        //Get Option Show Decimal
        $nOptDecimalShow            = FCNxHGetOptionDecimalShow();

        //ข้อมูล
        $aDataList                  = array();

        $aDataView = array(
            'nOptDecimalShow'       => $nOptDecimalShow,
            'aColumnShow'           => $aColumnShow,
            'aAlwEvent'             => $aAlwEvent,
            'aDataList'             => $aDataList
        );

        $tTableHtml     = $this->load->view('document/purchaseorderNew/wPurchaseorderPDTTmp', $aDataView, true);
        $aReturnData    = array(
            'tTableHtml'            => $tTableHtml,
            'nStaEvent'             => '1',
            'tStaMessg'             => "Fucntion Success Return View."
        );
        echo json_encode($aReturnData);
    }

}

