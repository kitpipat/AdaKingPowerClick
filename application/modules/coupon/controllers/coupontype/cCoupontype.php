<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cCoupontype extends MX_Controller {

	public function __construct() {
            parent::__construct ();
            $this->load->model('Coupontype/mCoupontype');
    }

    public function index($nBrowseType,$tBrowseOption){

        $aData['nBrowseType']        = $nBrowseType;
        $aData['tBrowseOption']      = $tBrowseOption;
				$aData['aAlwEventVoucher']   = FCNaHCheckAlwFunc('coupontype/0/0'); //Controle Event
        $aData['vBtnSave']           = FCNaHBtnSaveActiveHTML('coupontype/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน

        $this->load->view('coupon/coupontype/wCoupontype',$aData);


    }

    //Functionality : Event AddPage
    //Parameters : -
    //Creator : 19/12/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : AddPage
    //Return Type : view
    public function FSxCCPTAddPage(){

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave = FCNaHGetAllLangByTable('TFNMCouponType_L');
		if ($aLangHave != false) {
			$nLangHave = FCNnHSizeOf($aLangHave);
		}else {
			$nLangHave = 0;
		}

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
        $this->load->view('coupon/coupontype/wCoupontypeAdd',$aDataAdd);
    }

     //Functionality : load page wCoupontypeFormSearchList
    //Parameters : -
    //Creator : 19/12/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : view
    //Return Type : veiw
    public function FSxCCPTFormSearchList(){
        $this->load->view('coupon/coupontype/wCoupontypeFormSearchList');
    }

    //Functionality : Event Add CouponType
    //Parameters : Ajax jReason()
    //Creator : 19/12/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaCCPTAddEvent(){

        date_default_timezone_set("Asia/Bangkok");

        try{
            $aDataMaster = array(
                'tIsAutoGenCode' => $this->input->post('ocbCoupontypeAutoGenCode'),
                'FTCptCode'      => $this->input->post('oetCptCode'),
                'FTCptName'      => $this->input->post('oetCptName'),
                'FTCptType'      => $this->input->post('ocmCptStatus'),
                'FTCptStaChk'    => $this->input->post('ocmCptStatusChk'),
                'FTCptStaChkHQ'  => $this->input->post('ocmCptStatusChkHq'),
                'FTCptRemark'    => $this->input->post('otaCptRemark'),
                'FTCptStaUse'    => ($this->input->post('ocbCptcheck') == "1")?"1":"2",
                'FDCreateOn'     => date("Y-m-d H:i:s"),
                'FTLastUpdBy'    => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'    => date("Y-m-d H:i:s"),
                'FTCreateBy'     => $this->session->userdata('tSesUsername'),
                'FNLngID'        => $this->session->userdata("tLangEdit"),

                //เพิ่ม AD Create By :Non
                'FTAgnCode'     => $this->input->post('oetCPTUsrAgnCode'),
            );

            if($aDataMaster['tIsAutoGenCode'] == '1'){ // Check Auto Gen Coupontype Code?
                // Auto Gen Coupontype Code
                // $aGenCode = FCNaHGenCodeV5('TFNMCouponType','0');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataMaster['FTCptCode'] = $aGenCode['rtCptCode'];
                // }
                // 15/05/2020 Nattakit(Nale)
                $aStoreParam = array(
                    "tTblName"    => 'TFNMCouponType',
                    "tDocType"    => 0,
                    "tBchCode"    => "",
                    "tShpCode"    => "",
                    "tPosCode"    => "",
                    "dDocDate"    => date("Y-m-d H:i:s")
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTCptCode'] = $aAutogen[0]["FTXxhDocNo"];
            }

            $oCountDup  = $this->mCoupontype->FSnMCPTCheckDuplicate($aDataMaster['FTCptCode']);
            $nStaDup    = $oCountDup[0]->counts;

            if($nStaDup == 0){
                $this->db->trans_begin();
                $aStaEventMaster  = $this->mCoupontype->FSaMCPTAddUpdateMaster($aDataMaster);
                $aStaEventLang    = $this->mCoupontype->FSaMCPTAddUpdateLang($aDataMaster);
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
                        'tCodeReturn'	=> $aDataMaster['FTCptCode'],
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


    //Functionality : Event Edit VoucherType
    //Parameters : Ajax jReason()
    //Creator : 19/12/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaCCPTEditEvent(){

        date_default_timezone_set("Asia/Bangkok");

        try{
            $aDataMaster = array(
                'tIsAutoGenCode' => $this->input->post('ocbCoupontypeAutoGenCode'),
                'FTCptCode'     => $this->input->post('oetCptCode'),
                'FTCptName'     => $this->input->post('oetCptName'),
                'FTCptType'     => $this->input->post('ocmCptStatus'),
                'FTCptStaChk'   => $this->input->post('ocmCptStatusChk'),
                'FTCptStaChkHQ' => $this->input->post('ocmCptStatusChkHq'),
                'FTCptRemark'   => $this->input->post('otaCptRemark'),
                'FTCptStaUse'    => ($this->input->post('ocbCptcheck') == "1")?"1":"2",
                'FDCreateOn'    => date("Y-m-d H:i:s"),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date("Y-m-d H:i:s"),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),

                //เพิ่ม AD Create By :Non
                'FTAgnCode'     => $this->input->post('oetCPTUsrAgnCode'),
            );

            $this->db->trans_begin();

            $aStaEventMaster  = $this->mCoupontype->FSaMCPTAddUpdateMaster($aDataMaster);
            $aStaEventLang    = $this->mCoupontype->FSaMCPTAddUpdateLang($aDataMaster);

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
                    'tCodeReturn'	=> $aDataMaster['FTCptCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }

    }

    //Functionality : Event Delete Voucher
    //Parameters : Ajax jReason()
    //Creator : 19/12/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCCPTDeleteEvent(){

        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTCptCode' => $tIDCode
        );
        $aResDel   = $this->mCoupontype->FSnMCPTDel($aDataMaster);
        $nNumRowCPTType = $this->mCoupontype->FSnMLOCGetAllNumRow();
        if($nNumRowCPTType !==false){
            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
                'nNumRowCouponType' => $nNumRowCPTType
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }
    }


    public function FSvCCPTEditPage(){

		$aAlwEventVoucher	= FCNaHCheckAlwFunc('vouchertype/0/0'); //Controle Event

        $tCptCode       = $this->input->post('tCptCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TFNMCouponType_L');
		if ($aLangHave != false) {
			$nLangHave = FCNnHSizeOf($aLangHave);
		}else {
			$nLangHave = 0;
		}

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
            'FTCptCode' => $tCptCode,
            'FNLngID'   => $nLangEdit
        );

        $aResult       = $this->mCoupontype->FSaMCPTSearchByID($aData);
        $aDataEdit      = array('aResult'           => $aResult,
                                'aAlwEventVoucher'   => $aAlwEventVoucher
                            );
        $this->load->view('coupon/coupontype/wCoupontypeAdd',$aDataEdit);

    }


    //Functionality : Function Call DataTables coupontype
    //Parameters : Ajax jBranch()
    //Creator : 19/12/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSxCCPTDataTable(){

        $aAlwEvent = FCNaHCheckAlwFunc('coupontype/0/0'); //Controle Event

        $nPage = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
		    $nLangEdit      = $this->session->userdata("tLangEdit");
		    $aLangHave      = FCNaHGetAllLangByTable('TFNMCouponType_L');
			if ($aLangHave != false) {
				$nLangHave = FCNnHSizeOf($aLangHave);
			}else {
				$nLangHave = 0;
			}
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

        $aResList   = $this->mCoupontype->FSaMCPTList($aData);
        $aGenTable  = array(

            'aAlwEvent'  => $aAlwEvent,
            'aDataList'  => $aResList,
            'nPage'      => $nPage,
            'tSearchAll' => $tSearchAll
        );

        $this->load->view('coupon/coupontype/wCoupontypeDataTable',$aGenTable);
    }


}
