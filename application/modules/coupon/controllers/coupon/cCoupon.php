<?php 
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cCoupon extends MX_Controller {

	public function __construct() {
            parent::__construct ();
            $this->load->model('coupon/mCoupon');
    }

    public function index($nBrowseType,$tBrowseOption){

        $aData['nBrowseType']       = $nBrowseType;
        $aData['tBrowseOption']     = $tBrowseOption;
		$aData['aAlwEventAgency']   = FCNaHCheckAlwFunc('coupon/0/0'); //Controle Event
        $aData['vBtnSave']          = FCNaHBtnSaveActiveHTML('coupon/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        
        $this->load->view('coupon/coupon/wCoupon',$aData);

    }


    public function FSxCCPNAddPage(){
        $aDataAdd = array(
            'nStaAddOrEdit'   => 99
        );
        $this->load->view('coupon/coupon/wCouponAdd',$aDataAdd);
    }

    public function FSxCCPNFormSearchList(){
        $this->load->view('coupon/coupon/wCouponFormSearchList');
    }

    //Functionality : Event Add Coupon
    //Parameters : Ajax jReason()
    //Creator : 03/07/2018 Krit(Krit)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaCCPNAddEvent(){
 
        $oetCpnValue = $this->input->post('oetCpnValue');
        $oetCpnSalePri = $this->input->post('oetCpnSalePri');
        $oedCpnExpired = $this->input->post('oedCpnExpired');
        if($oetCpnValue == ''){ $oetCpnValue = 0; }
        if($oetCpnSalePri == ''){ $oetCpnSalePri = 0; }
        if($oedCpnExpired == ''){ $oedCpnExpired = date('Y-m-d'); }

        try{
            $aDataMaster = array(
                'tIsAutoGenCode'=> $this->input->post('ocbCouponAutoGenCode'),
                'FTCpnCode' => $this->input->post('oetCpnCode'),
                'FTCpnName' => $this->input->post('oetCpnName'),
                'FTCpnRemark' => $this->input->post('otaCpnRemark'),
                'FTCpnBarCode' => $this->input->post('oetCpnBarCode'),
                'FDCpnExpired' => $oedCpnExpired,
                // 'FTCptCode' => $this->input->post('ohdCptCode'),
                'FCCpnValue' => $oetCpnValue,
                'FCCpnSalePri' => $oetCpnSalePri,
                'FCCpnBalance' => $this->input->post('oetCpnBalance'),
                'FTCpnComBook' => $this->input->post('oetCpnComBook'),
                'FTCpnStaBook' => $this->input->post('oetCpnStaBook'),
                'FTCpnStaSale' => $this->input->post('oetCpnStaSale'),
                'FTCpnStaUse' => $this->input->post('oetCpnStaUse'),
                'FDDateIns' => date('Y-m-d'),
                'FDDateUpd' => date('Y-m-d'),
                'FTTimeIns' => date('h:i:s'),
                'FTTimeUpd' => date('h:i:s'),
                'FTWhoIns'  => $this->session->userdata('tSesUsername'),
                'FTWhoUpd'  => $this->session->userdata('tSesUsername'),
                'FNLngID'   => $this->session->userdata("tLangEdit"),
            );
    
            if($aDataMaster['tIsAutoGenCode'] == '1'){ // Check Auto Gen Department Code?
                $aStoreParam = array(
                    "tTblName"    => 'TFNMCoupon',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTCpnCode']   = $aAutogen[0]["FTXxhDocNo"];

                // Auto Gen Department Code
                // $aGenCode = FCNaHGenCodeV5('TFNMCoupon','0');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataMaster['FTCpnCode'] = $aGenCode['rtCpnCode'];
                // }
            }
          

            $oCountDup  = $this->mCoupon->FSnMCPNCheckDuplicate($aDataMaster['FTCpnCode']);
            $nStaDup    = $oCountDup[0]->counts;



            if($nStaDup == 0){
                $this->db->trans_begin();
                $aStaEventMaster  = $this->mCoupon->FSaMCPNAddUpdateMaster($aDataMaster);
                $aStaEventLang    = $this->mCoupon->FSaMCPNAddUpdateLang($aDataMaster);
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
                        'tCodeReturn'	=> $aDataMaster['FTCpnCode'],
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
    public function FSaCCPNEditEvent(){

        $oetCpnValue = $this->input->post('oetCpnValue');
        $oetCpnSalePri = $this->input->post('oetCpnSalePri');
        $oedCpnExpired = $this->input->post('oedCpnExpired');
        if($oetCpnValue == ''){ $oetCpnValue = 0; }
        if($oetCpnSalePri == ''){ $oetCpnSalePri = 0; }
        if($oedCpnExpired == ''){ $oedCpnExpired = date('Y-m-d'); }
        
        try{
            $aDataMaster = array(
                'FTCpnCode' => $this->input->post('oetCpnCode'),
                'FTCpnName' => $this->input->post('oetCpnName'),
                'FTCpnRemark' => $this->input->post('otaCpnRemark'),
                'FTCpnBarCode' => $this->input->post('oetCpnBarCode'),
                'FDCpnExpired' => $oedCpnExpired,
                'FTCptCode' => $this->input->post('ohdCptCode'),
                'FCCpnValue' => $oetCpnValue,
                'FCCpnSalePri' => $oetCpnSalePri,
                'FCCpnBalance' => $this->input->post('oetCpnBalance'),
                'FTCpnComBook' => $this->input->post('oetCpnComBook'),
                'FTCpnStaBook' => $this->input->post('oetCpnStaBook'),
                'FTCpnStaSale' => $this->input->post('oetCpnStaSale'),
                'FTCpnStaUse' => $this->input->post('oetCpnStaUse'),
                'FDDateIns' => date('Y-m-d'),
                'FDDateUpd' => date('Y-m-d'),
                'FTTimeIns' => date('h:i:s'),
                'FTTimeUpd' => date('h:i:s'),
                'FTWhoIns'  => $this->session->userdata('tSesUsername'),
                'FTWhoUpd'  => $this->session->userdata('tSesUsername'),
                'FNLngID'   => $this->session->userdata("tLangEdit"),
            );
            $this->db->trans_begin();
            $aStaEventMaster  = $this->mCoupon->FSaMCPNAddUpdateMaster($aDataMaster);
            $aStaEventLang    = $this->mCoupon->FSaMCPNAddUpdateLang($aDataMaster);
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
                    'tCodeReturn'	=> $aDataMaster['FTCpnCode'],
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
    public function FSaCCPNDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTCpnCode' => $tIDCode
        );

        $aResDel    = $this->mCoupon->FSnMCPNDel($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }


    public function FSvCCPNEditPage(){

		$aAlwEventCoupon	= FCNaHCheckAlwFunc('coupon/0/0'); //Controle Event
        $tCpnCode       = $this->input->post('tCpnCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TFNMCoupon_L');
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
            'FTCpnCode' => $tCpnCode,
            'FNLngID'   => $nLangEdit
        );

        $aResult       = $this->mCoupon->FSaMCPNSearchByID($aData);
        $aDataEdit      = array('aResult'           => $aResult,
                                'aAlwEventCoupon'   => $aAlwEventCoupon
                            );
        $this->load->view('coupon/coupon/wCouponAdd',$aDataEdit);

    }


    //Functionality : Function Call DataTables Coupon
    //Parameters : Ajax jBranch()
    //Creator : 03/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSxCCPNDataTable(){

        $aAlwEvent = FCNaHCheckAlwFunc('coupon/0/0'); //Controle Event
        $nPage = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
	    $aLangHave      = FCNaHGetAllLangByTable('TFNMCoupon_L');
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

        $aResList   = $this->mCoupon->FSaMCPNList($aData);
        $aGenTable  = array(

            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage'     => $nPage,
            'tSearchAll'    => $tSearchAll
        );

        $this->load->view('coupon/coupon/wCouponDataTable',$aGenTable);
    }


}