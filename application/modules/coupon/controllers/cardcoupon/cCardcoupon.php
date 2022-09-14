<?php 
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cCardcoupon extends MX_Controller {

	public function __construct() {
            parent::__construct ();
            $this->load->model('cardcoupon/mCardcoupon');
    }

    public function index($nBrowseType,$tBrowseOption){

        $aData['nBrowseType']           = $nBrowseType;
        $aData['tBrowseOption']         = $tBrowseOption;
		$aData['aAlwEventCardCoupon']   = FCNaHCheckAlwFunc('cardcoupon/0/0'); //Controle Event
        $aData['vBtnSave']              = FCNaHBtnSaveActiveHTML('cardcoupon/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน

        $this->load->view('coupon/cardcoupon/wCardCoupon',$aData);

    }


    public function FSxCCCLAddPage(){

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave = FCNaHGetAllLangByTable('TFNMCrdCpnList_L');
        $nLangHave = FCNnHSizeOf($aLangHave);
        if($nLangHave > 1){
	        if($nLangEdit != ''){
	            $nLangEdit = $nLangEdit;
	        }else{
	            $nLangEdit = $nLangResort;
	        }
	    }else{
	        if(@$aLangHave[0]->nLangList == ''){
	            $nLangEdit = '1';
	        }else{
	            $nLangEdit = $aLangHave[0]->nLangList;
	        }
        }
        
        $aData  = array(
            'FNLngID'   => $nLangEdit,
        );

        $aDataAdd = array(
            'aResult'   => array('rtCode'=>'99')
        );

        $this->load->view('coupon/cardcoupon/wCardCouponAdd',$aDataAdd);
    }

    public function FSxCCCLFormSearchList(){
        $this->load->view('coupon/cardcoupon/wCardCouponFormSearchList');
    }

    //Functionality : Event Add Coupon
    //Parameters : Ajax jReason()
    //Creator : 03/07/2018 Krit(Krit)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaCCCLAddEvent(){
        
        date_default_timezone_set("Asia/Bangkok");
        $oetCclAmt    = $this->input->post('oetCclAmt');
        $oetCclStartDate     = $this->input->post('oetCclStartDate');
        $oetCclEndDate   = $this->input->post('oetCclEndDate');
        $nCheck           = $this->input->post('ocbCclcheck');

        if($nCheck        == ''){ $nCheck = 2; }
        if($oetCclAmt     == ''){ $oetCclAmt = 0; }
        if($oetCclStartDate   == ''){ $oetCclStartDate = date('Y-m-d'); }
        if($oetCclEndDate == ''){ $oetCclEndDate = date('Y-m-d'); }

        try{
            $aDataMaster = array(
                'tIsAutoGenCode' => $this->input->post('ocbCardCouponAutoGenCode'),
                'FTCclCode'      => $this->input->post('oetCclCode'),
                'FCCclAmt'       => $this->input->post('oetCclAmt'),
                'FDCclStartDate' => $oetCclStartDate,
                'FDCclEndDate'   => $oetCclEndDate,
                'FTCclStaUse'    => $nCheck,
                'FTCclName'      => $this->input->post('oetCclName'),
                'FTCclPrnCond'   => $this->input->post('otaCclPrnCond'),
                'FDCreateOn'     => date("Y-m-d H:i:s"),
                'FDLastUpdOn'    => date("Y-m-d H:i:s"),
                'FTCreateBy'     => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'        => $this->session->userdata("tLangEdit"),
            );
        
            if($aDataMaster['tIsAutoGenCode'] == '1'){ // Check Auto Gen Department Code?
                // Auto Gen Department Code
                $aStoreParam = array(
                    "tTblName"    => 'TFNMCrdCpnList',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTCclCode']   = $aAutogen[0]["FTXxhDocNo"];

                // $aGenCode = FCNaHGenCodeV5('TFNMCrdCpnList','0');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataMaster['FTCclCode'] = $aGenCode['rtCclCode'];
                // }
            }

            $oCountDup  = $this->mCardcoupon->FSnMCPNCheckDuplicate($aDataMaster['FTCclCode']);
            $nStaDup    = $oCountDup[0]->counts;

     

            if($nStaDup == 0){
                $this->db->trans_begin();
                $aStaEventMaster  = $this->mCardcoupon->FSaMCCLAddUpdateMaster($aDataMaster);
                $aStaEventLang    = $this->mCardcoupon->FSaMCCLAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTCclCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Event'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => "Data Code Duplicate"
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Edit Coupon
    //Parameters : Ajax jReason()
    //Creator : 02/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaCCCLEditEvent(){

        date_default_timezone_set("Asia/Bangkok");
        $oetCclAmt    = $this->input->post('oetCclAmt');
        $oetCclStartDate     = $this->input->post('oetCclStartDate');
        $oetCclEndDate   = $this->input->post('oetCclEndDate');
        $nCheck           = $this->input->post('ocbCclcheck');

        if($nCheck        == ''){ $nCheck = 2; }
        if($oetCclAmt     == ''){ $oetCclAmt = 0; }
        if($oetCclStartDate   == ''){ $oetCclStartDate = date('Y-m-d'); }
        if($oetCclEndDate == ''){ $oetCclEndDate = date('Y-m-d'); }

        
        try{
            $aDataMaster = array(
                'FTCclCode'      => $this->input->post('oetCclCode'),
                'FCCclAmt'       => $this->input->post('oetCclAmt'),
                'FDCclStartDate' => $oetCclStartDate,
                'FDCclEndDate'   => $oetCclEndDate,
                'FTCclStaUse'    => $nCheck,
                'FTCclName'      => $this->input->post('oetCclName'),
                'FTCclPrnCond'   => $this->input->post('otaCclPrnCond'),
                'FDCreateOn'     => date("Y-m-d H:i:s"),
                'FDLastUpdOn'    => date("Y-m-d H:i:s"),
                'FTCreateBy'     => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'        => $this->session->userdata("tLangEdit"),
            );
            
            $this->db->trans_begin();
            $aStaEventMaster  = $this->mCardcoupon->FSaMCCLAddUpdateMaster($aDataMaster);
            $aStaEventLang    = $this->mCardcoupon->FSaMCCLAddUpdateLang($aDataMaster);
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTCclCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
      
    }

    //Functionality : Event Delete Coupon
    //Parameters : Ajax jReason()
    //Creator : 03/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCCCLDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTCclCode' => $tIDCode
        );

        $aResDel    = $this->mCardcoupon->FSnMCCLDel($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }


    public function FSvCCCLEditPage(){

		$aAlwEventCoupon	= FCNaHCheckAlwFunc('cardcoupon/0/0'); //Controle Event

        $tCclCode       = $this->input->post('tCclCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TFNMCrdCpnList_L');
        $nLangHave      = FCNnHSizeOf($aLangHave);
        
        if($nLangHave > 1){
	        if($nLangEdit != ''){
	            $nLangEdit = $nLangEdit;
	        }else{
	            $nLangEdit = $nLangResort;
	        }
	    }else{
	        if(@$aLangHave[0]->nLangList == ''){
	            $nLangEdit = '1';
	        }else{
	            $nLangEdit = $nLangEdit;
	        }
        }
        
        $aData  = array(
            'tCclCode' => $tCclCode,
            'FNLngID'   => $nLangEdit
        );

        $aResult        = $this->mCardcoupon->FSaMCCLSearchByID($aData);
        $aDataEdit      = array('aResult'           => $aResult,
                                'aAlwEventCoupon'   => $aAlwEventCoupon
                            );
        $this->load->view('coupon/cardcoupon/wCardCouponAdd',$aDataEdit);

    }


    //Functionality : Function Call DataTables Coupon
    //Parameters : Ajax jBranch()
    //Creator : 03/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSxCCCLDataTable(){

        $aAlwEvent = FCNaHCheckAlwFunc('cardcoupon/0/0'); //Controle Event
        
        $nPage = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
	    $aLangHave      = FCNaHGetAllLangByTable('TFNMCrdCpnList_L');
        $nLangHave      = FCNnHSizeOf($aLangHave);
        if($nLangHave > 1){
	        if($nLangEdit != ''){
	            $nLangEdit = $nLangEdit;
	        }else{
	            $nLangEdit = $nLangResort;
	        }
	    }else{
	        if(@$aLangHave[0]->nLangList == ''){
	            $nLangEdit = '1';
	        }else{
	            $nLangEdit = $aLangHave[0]->nLangList;
            }
            
        }
    
        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );

        $aResList   = $this->mCardcoupon->FSaMCCLList($aData);
        $aGenTable  = array(

            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage'     => $nPage,
            'tSearchAll'    => $tSearchAll
        );  
    
        $this->load->view('coupon/cardcoupon/wCardCouponDataTable',$aGenTable);
    }


}