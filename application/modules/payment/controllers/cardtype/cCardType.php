<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cCardType extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('payment/cardtype/mCardType');
    }

    public function index($nCtyBrowseType,$tCtyBrowseOption){
        $nMsgResp   = array('title'=>"CardType");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('cardtype/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventCardtype	    = FCNaHCheckAlwFunc('cardtype/0/0');
        $this->load->view('payment/cardtype/wCardType', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nCtyBrowseType'    => $nCtyBrowseType,
            'tCtyBrowseOption'  => $tCtyBrowseOption,
            'aAlwEventCardtype' => $aAlwEventCardtype
        ));
    }

    //Functionality : Function Call CardType Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 05/10/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCCTYListPage(){ 
        $aAlwEventCardtype	    = FCNaHCheckAlwFunc('cardtype/0/0');
		$aNewData  			    = array( 'aAlwEventCardtype' => $aAlwEventCardtype );
        $this->load->view('payment/cardtype/wCardTypeList', $aNewData);
    }

    /**
     * Functionality : Call DataTables CardType
     * Parameters : Ajax Call View DataTable
     * Creator : 05/10/2018 Witsarut (Bell)
     * Last Modified : 11/1/2019 Piya 
     * Return : view
     * Return Type : view
     */
    public function FSvCCTYDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TFNMCardType_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }
            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll
            );
            $aCtyDataList   = $this->mCardType->FSaMCTYList($aData); 
            $aAlwEvent      = FCNaHCheckAlwFunc('cardtype/0/0'); //Controle Event
            $aGenTable  = array(
                'aCtyDataList'      => $aCtyDataList,
                'nPage'             => $nPage,
                'tSearchAll'        => $tSearchAll,
                'aAlwEventCardtype' => $aAlwEvent
            );
            $this->load->view('payment/cardtype/wCardTypeDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage CardType Add
    //Parameters : Ajax Call View Add
    //Creator : 05/10/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCCTYAddPage(){
        try{
            $nOptDecimalShow = FCNxHGetOptionDecimalShow();
            $aDataCardType = array(
                'nStaAddOrEdit'     => 99,
                'nOptDecimalShow'   => $nOptDecimalShow
            );
            $this->load->view('payment/cardtype/wCardTypeAdd',$aDataCardType);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage CardType Edits
    //Parameters : Ajax Call View Add
    //Creator : 05/10/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCCTYEditPage(){
        try{
            $tCtyCode        = $this->input->post('tCtyCode');
            $nLangResort     = $this->session->userdata("tLangID");
            $nLangEdit       = $this->session->userdata("tLangEdit");
            $aLangHave       = FCNaHGetAllLangByTable('TFNMCardType_L');
            $nOptDecimalShow = FCNxHGetOptionDecimalShow();
            $nLangHave       = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }

            $aData  = array(
                'FTCtyCode' => $tCtyCode,
                'FNLngID'   => $nLangEdit
            );
                                                
            $aCtyData       = $this->mCardType->FSaMCTYGetDataByID($aData);
            $aDataCardType   = array(
                'nStaAddOrEdit'     => 1,
                'aCtyData'          => $aCtyData,
                'nOptDecimalShow'   => $nOptDecimalShow
            );
            $this->load->view('payment/cardtype/wCardTypeAdd',$aDataCardType);
        }catch(Exception $Error){
            echo $Error;
        }
    }


     //Functionality : Event Add CardType
    //Parameters : Ajax Event
    //Creator : 05/10/2018 Witsarut (Bell)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCCTYAddEvent(){ 
        try{

            $tIsAutoGenCode = $this->input->post('ocbCardtypeAutoGenCode');

            // Setup Reason Code
            $tCtyCode = "";
            if(isset($tIsAutoGenCode) && $tIsAutoGenCode == '1'){


                $aStoreParam = array(
                    "tTblName"    => 'TFNMCardType',
                    "tDocType"    => 0,
                    "tBchCode"    => "",
                    "tShpCode"    => "",
                    "tPosCode"    => "",
                    "dDocDate"    => date("Y-m-d")
                );
                $aAutogen           = FCNaHAUTGenDocNo($aStoreParam);
                $tCtyCode           = $aAutogen[0]["FTXxhDocNo"];

                // $aGenCode = FCNaHGenCodeV5('TFNMCardType');
                // if($aGenCode['rtCode'] == '1'){
                //     $tCtyCode = $aGenCode['rtCtyCode'];
                // }

            }else{
                $tCtyCode = $this->input->post('oetCtyCode');
            }

            $aDataCardType   = array(
                'FTCtyCode'         => $tCtyCode,
                'FTCtyName'         => $this->input->post('oetCtyName'),
                'FCCtyDeposit'      => str_replace(',','',$this->input->post('oetCtyDeposit')),
                'FCCtyTopupAuto'    => str_replace(',','',$this->input->post('oetCtyTopupAuto')),
                'FNCtyExpiredType'  => $this->input->post('ocmCtyExpireType'),
                'FNCtyExpirePeriod' => $this->input->post('oetCtyExpirePeriod'),
                'FTCtyStaShift'     => $this->input->post('ohdCtyStaType'),
                'FTCtyStaAlwRet'    => (!empty($this->input->post('ocbCtyStaAlwRet')))? '1':'2',
                'FTCtyStaPay'       => $this->input->post('ocmCtyStatusPay'), // เพิ่มมาใหม่
                'FCCtyCreditLimit'  => str_replace(',','',$this->input->post('oetCtyPaylimit')),
                'FTCtyRmk'          => $this->input->post('otaCtyRmk'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),

                'FTAgnCode'         => $this->input->post('oetCTYUsrAgnCode'),
            );
            $oCountDup      = $this->mCardType->FSnMCTYCheckDuplicate($aDataCardType['FTCtyCode']);
            $nStaDup        = $oCountDup['counts'];
            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaCtyMaster  = $this->mCardType->FSaMCTYAddUpdateMaster($aDataCardType);
                $aStaCtyLang    = $this->mCardType->FSaMCTYAddUpdateLang($aDataCardType);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add CardType"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataCardType['FTCtyCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add CardType'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => language('common/main/main','tDataDuplicate')
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Edit CardType
    //Parameters : Ajax Event
    //Creator : 05/10/2018 Witsarut(Bell)
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCCTYEditEvent(){ 
        try{
            $this->db->trans_begin();
            $aDataCardType   = array(
                'FTCtyCode'          => $this->input->post('oetCtyCode'),
                'FTCtyName'          => $this->input->post('oetCtyName'),
                'FCCtyDeposit'       => str_replace(',','',$this->input->post('oetCtyDeposit')),
                'FCCtyTopupAuto'     => str_replace(',','',$this->input->post('oetCtyTopupAuto')),
                'FNCtyExpiredType'   => $this->input->post('ocmCtyExpireType'),
                'FNCtyExpirePeriod'  => $this->input->post('oetCtyExpirePeriod'),
                'FTCtyStaAlwRet'     => (!empty($this->input->post('ocbCtyStaAlwRet')))? '1':'2',
                'FTCtyStaShift'      => $this->input->post('ohdCtyStaType'),
                'FTCtyStaPay'        => $this->input->post('ocmCtyStatusPay'),  // เพิ่มมาใหม่
                'FCCtyCreditLimit'  => str_replace(',','',$this->input->post('oetCtyPaylimit')),
                'FTCtyRmk'           => $this->input->post('otaCtyRmk'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'         => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'        => $this->session->userdata('tSesUsername'),
                'FNLngID'            => $this->session->userdata("tLangEdit"),

                'FTAgnCode'          => $this->input->post('oetCTYUsrAgnCode'),
            );
            $aStaCtyMaster  = $this->mCardType->FSaMCTYAddUpdateMaster($aDataCardType);
            $aStaCtyLang    = $this->mCardType->FSaMCTYAddUpdateLang($aDataCardType);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit CardType"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataCardType['FTCtyCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit CardType'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Delete CardType
    //Parameters : Ajax jReason()
    //Creator : 05/10/2018 Witsarut(Bell)
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCCTYDeleteEvent(){
        try{
            $tIDCode = $this->input->post('tIDCode');
            $aDataMaster = array(
                'FTCtyCode' => $tIDCode
            );
            $aResDel     = $this->mCardType->FSaMCTYDelAll($aDataMaster);
            // $nNumRowCtyLoc = $this->mCardType->FSnMLOCGetAllNumRow();

            // if($nNumRowCtyLoc){
                $aReturn    = array(
                    'nStaEvent' => $aResDel['rtCode'],
                    'tStaMessg' => $aResDel['rtDesc'],
                    // 'nNumRowCtyLoc' => $nNumRowCtyLoc
                );
            // }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }
}
 