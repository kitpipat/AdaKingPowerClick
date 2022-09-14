<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cPdtNoSleByEvn extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('product/pdtnoslebyevn/mPdtNoSleByEvn');
    }
    
    public function index($nEvnBrowseType,$tEvnBrowseOption){
        $nMsgResp   = array('title'=>"ProductNoSaleEvent");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }

        $vBtnSave                   = FCNaHBtnSaveActiveHTML('pdtnoslebyevn/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventPdtNoSieByEvn	    = FCNaHCheckAlwFunc('pdtnoslebyevn/0/0');
        $this->load->view('product/pdtnoslebyevn/wPdtNoSleByEvn', array (
            'nMsgResp'                  => $nMsgResp,
            'vBtnSave'                  => $vBtnSave,
            'nEvnBrowseType'            => $nEvnBrowseType,
            'tEvnBrowseOption'          => $tEvnBrowseOption,
            'aAlwEventPdtNoSieByEvn'    => $aAlwEventPdtNoSieByEvn
        ));
    }

    //Functionality : Function Call Page List Product NoSale By Event
    //Parameters : Ajax and Function Parameter
    //Creator : 21/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCEVNListPage(){
        $aAlwEventPdtNoSieByEvn	    = FCNaHCheckAlwFunc('pdtnoslebyevn/0/0');
        $this->load->view('product/pdtnoslebyevn/wPdtNoSleByEvnList', array(
            'aAlwEventPdtNoSieByEvn'    => $aAlwEventPdtNoSieByEvn
        ));
    }

    //Functionality : Function Call DataTables Product NoSale By Event
    //Parameters : Ajax Call View DataTable
    //Creator : 21/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCEVNDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtNoSleByEvn_L');
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
            $aEvnDataList               = $this->mPdtNoSleByEvn->FSaMEVNList($aData);
            $aAlwEventPdtNoSieByEvn	    = FCNaHCheckAlwFunc('pdtnoslebyevn/0/0');
            $aGenTable  = array(
                'aEvnDataList'  => $aEvnDataList,
                'nPage'         => $nPage,
                'tSearchAll'    => $tSearchAll,
                'aAlwEventPdtNoSieByEvn'    => $aAlwEventPdtNoSieByEvn
            );
            $this->load->view('product/pdtnoslebyevn/wPdtNoSleByEvnDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Add Product NoSale By Event 
    //Parameters : Ajax Call View Add
    //Creator : 24/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCEVNAddPage(){
        try{
            $aDataPdtNoSleByEvn = array(
                'nStaAddOrEdit'   => 99
            );
            $this->load->view('product/pdtnoslebyevn/wPdtNoSleByEvnAdd',$aDataPdtNoSleByEvn);
        }catch(Exception $Error){
            echo $Error;
        }
    }
  
    //Functionality : Function CallPage Edit Product NoSale By Event 
    //Parameters : Ajax Call View Add
    //Creator : 27/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCEVNEditPage(){
        try{
            $tEvnCode       = $this->input->post('tEvnCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtNoSleByEvn_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }

            $aData  = array(
                'FTEvnCode' => $tEvnCode,
                'FNLngID'   => $nLangEdit
            );
            $aEvnData       = $this->mPdtNoSleByEvn->FSaMEVNGetDataByID($aData);
            $aDataPdtNoSleByEvn   = array(
                'nStaAddOrEdit' => 1,
                'aEvnData'      => $aEvnData
            );
            $this->load->view('product/pdtnoslebyevn/wPdtNoSleByEvnAdd',$aDataPdtNoSleByEvn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Add Product NoSale By Event 
    //Parameters : Ajax Event
    //Creator : 27/09/2018 wasin
    //Update : 22/04/2019 pap
    //Return : Status Add Event
    //Return Type : String
    public function FSoCEVNAddEvent(){
        try{
            $aDataMaster   = array(
                'tIsAutoGenCode'    => $this->input->post('ocbEvnAutoGenCode'),
                'oetEvnCode'     => $this->input->post('oetEvnCode'),
                'oetEvnName'     => $this->input->post('oetEvnName'),
                'otaEvnRmk'      => $this->input->post('otaEvnRmk'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'ocmEvnTypeSend'    => $this->input->post("ocmEvnTypeSend"),
                'ocbEvnStaAllDay'    => $this->input->post("ocbEvnStaAllDay"),
                'oetEvnDStartSend'    => $this->input->post("oetEvnDStartSend"),
                'oetEvnDFinishSend'    => $this->input->post("oetEvnDFinishSend"),
                'oetEvnTStartSend'    => $this->input->post("oetEvnTStartSend"),
                'oetEvnTFinishSend'    => $this->input->post("oetEvnTFinishSend")
            );
            // Setup Reason Code
            if($aDataMaster['tIsAutoGenCode'] == '1'){ // Check Auto Gen Reason Code?
                // Auto Gen Reason Code
                $aStoreParam = array(
                    "tTblName"    => 'TCNMPdtNoSleByEvn',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['oetEvnCode']   = $aAutogen[0]["FTXxhDocNo"];


                // $aGenCode = FCNaHGenCodeV5('TCNMPdtNoSleByEvn');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataMaster['oetEvnCode'] = $aGenCode['rtEvnCode'];
                // }
            }

            $this->db->trans_begin();
            $aStaEvnMaster  = $this->mPdtNoSleByEvn->FSaMEVNAddUpdateMaster($aDataMaster);
            $aStaEvnLang    = $this->mPdtNoSleByEvn->FSaMEVNAddUpdateLang($aDataMaster);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Error Add Product NoSale By Event."
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['oetEvnCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Product NoSale By Event.'
                );
            }
            
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Edit Product NoSale By Event 
    //Parameters : Ajax Event
    //Creator : 27/09/2018 wasin
    //Update : 23/09/2019 pap
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCEVNEditEvent(){
        try{
            $nOcmEvnTypeSend = $this->input->post("ocmEvnTypeSend");
            $nOcbEvnStaAllDay = $this->input->post("ocbEvnStaAllDay");
            $tOetEvnDStartSend  = $this->input->post("oetEvnDStartSend");
            $tOetEvnDFinishSend = $this->input->post("oetEvnDFinishSend");
            $tOetEvnTStartSend = $this->input->post("oetEvnTStartSend");
            $tOetEvnTFinishSend = $this->input->post("oetEvnTFinishSend");
            $bLastValidDateTimeEVN = true;
            if($nOcmEvnTypeSend!=null){
                $bCheckTimeCompare = true;
                $bCheckDateAllCompare = true;
                $bCheckDateNoAllCompare = true;
                $aEVNListTimeLine = $this->mPdtNoSleByEvn->FSaMGetEVNListTime($this->input->post("oetEvnCode"));
                $aEVNListDate = $this->mPdtNoSleByEvn->FSaMGetEVNListDate($this->input->post("oetEvnCode"));
                $aEVNListDateTime = $this->mPdtNoSleByEvn->FSaMGetEVNListDateTime($this->input->post("oetEvnCode"));
                for($nI=0;$nI<FCNnHSizeOf($nOcmEvnTypeSend);$nI++){
                    if($nOcmEvnTypeSend[$nI]==1){
                       if($aEVNListTimeLine){
                            $tOetEvnTStartVal = $tOetEvnTStartSend[$nI];
                            $tOetEvnTFinishVal = $tOetEvnTFinishSend[$nI];
                            for($nJ = 0;$nJ<FCNnHSizeOf($aEVNListTimeLine);$nJ++){
                                $tCompareTStartSend = $aEVNListTimeLine[$nJ]["FTEvnTStart"];
                                $tCompareTFinishSend = $aEVNListTimeLine[$nJ]["FTEvnTFinish"];
                                if($tOetEvnTStartVal<=$tCompareTStartSend){
                                    if($tOetEvnTFinishVal<=$tCompareTStartSend){
                                        if($tOetEvnTStartVal==$tCompareTStartSend && 
                                        $tOetEvnTFinishVal==$tCompareTFinishSend){
                                            $bCheckTimeCompare = false;
                                            break;
                                        }else{
                                            if($tOetEvnTStartVal<$tOetEvnTFinishVal){
                                                $bCheckTimeCompare = true;
                                            }else{
                                                $bCheckTimeCompare = false;
                                                break;
                                            }
                                        }
                                    }else{
                                        if($tOetEvnTStartVal>=$tCompareTFinishSend){
                                            if($tOetEvnTFinishVal>=$tCompareTFinishSend){
                                                if($tOetEvnTStartVal==$tCompareTStartSend && 
                                                $tOetEvnTFinishVal==$tCompareTFinishSend){
                                                    $bCheckTimeCompare = false;
                                                    break;
                                                }else{
                                                    if($tOetEvnTStartVal<$tOetEvnTFinishVal){
                                                        $bCheckTimeCompare = true;
                                                    }else{
                                                        $bCheckTimeCompare = false;
                                                        break;
                                                    }
                                                }
                                            }else{
                                                $bCheckTimeCompare = false;
                                                break;
                                            }
                                        }else{
                                            $bCheckTimeCompare = false;
                                            break;
                                        }
                                    }
                                }else if($tOetEvnTStartVal>$tCompareTStartSend){
                                    if($tOetEvnTStartVal>=$tCompareTFinishSend){
                                        if($tOetEvnTFinishVal>=$tCompareTFinishSend){
                                            if($tOetEvnTStartVal==$tCompareTStartSend && 
                                            $tOetEvnTFinishVal==$tCompareTFinishSend){
                                                $bCheckTimeCompare = false;
                                                break;
                                            }else{
                                                if($tOetEvnTStartVal<$tOetEvnTFinishVal){
                                                    $bCheckTimeCompare = true;
                                                }else{
                                                    $bCheckTimeCompare = false;
                                                    break;
                                                }
                                            }
                                        }else{
                                            $bCheckTimeCompare = false;
                                            break;
                                        }
                                    }else{
                                        $bCheckTimeCompare = false;
                                        break;
                                    }
                                }
                            
                            }
                        }
                        if($bCheckTimeCompare == false){
                            break;
                        }
                    }else{
                        if($nOcbEvnStaAllDay[$nI]==1){
                            if($aEVNListDate){
                                $tOetEvnDStartVal = $tOetEvnDStartSend[$nI];
                                $tOetEvnDFinishVal = $tOetEvnDFinishSend[$nI];
                                for($nJ = 0;$nJ<FCNnHSizeOf($aEVNListDate);$nJ++){
                                    $tCompareDStartSend = $aEVNListDate[$nJ]["FDEvnDStart"];
                                    $tCompareDFinishSend = $aEVNListDate[$nJ]["FDEvnDFinish"];
                                    if($tOetEvnDStartVal<=$tCompareDStartSend){
                                        if($tOetEvnDFinishVal<=$tCompareDStartSend){
                                            if($tOetEvnDStartVal==$tCompareDStartSend && 
                                            $tOetEvnDFinishVal==$tCompareDFinishSend){
                                                $bCheckDateAllCompare = false;
                                                break;
                                            }else{
                                                if($tOetEvnDStartVal<$tOetEvnDFinishVal){
                                                    $bCheckDateAllCompare = true;
                                                }else{
                                                    $bCheckDateAllCompare = false;
                                                    break;
                                                }
                                            }
                                        }else{
                                            if($tOetEvnDStartVal>=$tCompareDFinishSend){
                                                if($tOetEvnDFinishVal>=$tCompareDFinishSend){
                                                    if($tOetEvnDStartVal==$tCompareDStartSend && 
                                                    $tOetEvnDFinishVal==$tCompareDFinishSend){
                                                        $bCheckDateAllCompare = false;
                                                        break;
                                                    }else{
                                                        if($tOetEvnDStartVal<$tOetEvnDFinishVal){
                                                            $bCheckDateAllCompare = true;
                                                        }else{
                                                            $bCheckDateAllCompare = false;
                                                            break;
                                                        }
                                                    }
                                                }else{
                                                    $bCheckDateAllCompare = false;
                                                    break;
                                                }
                                            }else{
                                                $bCheckDateAllCompare = false;
                                                break;
                                            }
                                        }
                                    }else if($tOetEvnDStartVal>$tCompareDStartSend){
                                        if($tOetEvnDStartVal>=$tCompareDFinishSend){
                                            if($tOetEvnDFinishVal>=$tCompareDFinishSend){
                                                if($tOetEvnDStartVal==$tCompareDStartSend && 
                                                $tOetEvnDFinishVal==$tCompareDFinishSend){
                                                    $bCheckDateAllCompare = false;
                                                    break;
                                                }else{
                                                    if($tOetEvnDStartVal<$tOetEvnDFinishVal){
                                                        $bCheckDateAllCompare = true;
                                                    }else{
                                                        $bCheckDateAllCompare = false;
                                                        break;
                                                    }
                                                }
                                            }else{
                                                $bCheckDateAllCompare = false;
                                                break;
                                            }
                                        }else{
                                            $bCheckDateAllCompare = false;
                                            break;
                                        }
                                    }
                                    
                                }
                            }
                            if($bCheckDateAllCompare == false){
                                break;
                            }
                        }else{


                            if($aEVNListDateTime){
                                $tOetEvnTStartVal = $tOetEvnTStartSend[$nI];
                                $tOetEvnTFinishVal = $tOetEvnTFinishSend[$nI];
                                $tOetEvnDStartVal = $tOetEvnDStartSend[$nI];
                                $tOetEvnDFinishVal = $tOetEvnDFinishSend[$nI];
                                if($tOetEvnDStartVal!=$tOetEvnDFinishVal){
                                    $bCheckDateSecCompare = true;
                                    for($nJ = 0;$nJ<FCNnHSizeOf($aEVNListDateTime);$nJ++){
                                        $tCompareDStartSend = $aEVNListDateTime[$nJ]["FDEvnDStart"];
                                        $tCompareDFinishSend = $aEVNListDateTime[$nJ]["FDEvnDFinish"];
                                        if($tOetEvnDStartVal<$tCompareDStartSend){
                                            if($tOetEvnDFinishVal<$tCompareDStartSend){
                                                if($tOetEvnDStartVal==$tCompareDStartSend && 
                                                $tOetEvnDFinishVal==$tCompareDFinishSend){
                                                    $bCheckDateSecCompare = false;
                                                    break;
                                                }else{
                                                    if($tOetEvnDStartVal<=$tOetEvnDFinishVal){
                                                        $bCheckDateSecCompare = true;
                                                    }else{
                                                        $bCheckDateSecCompare = false;
                                                        break;
                                                    }
                                                }
                                            }else{
                                                if($tOetEvnDStartVal>$tCompareDFinishSend){
                                                    if($tOetEvnDFinishVal>$tCompareDFinishSend){
                                                        if($tOetEvnDStartVal==$tCompareDStartSend && 
                                                        $tOetEvnDFinishVal==$tCompareDFinishSend){
                                                            $bCheckDateSecCompare = false;
                                                            break;
                                                        }else{
                                                            if($tOetEvnDStartVal<=$tOetEvnDFinishVal){
                                                                $bCheckDateSecCompare = true;
                                                            }else{
                                                                $bCheckDateSecCompare = false;
                                                                break;
                                                            }
                                                        }
                                                    }else{
                                                        $bCheckDateSecCompare = false;
                                                        break;
                                                    }
                                                }else{
                                                    $bCheckDateSecCompare = false;
                                                    break;
                                                }
                                            }
                                        }else if($tOetEvnDStartVal>$tCompareDStartSend){
                                            if($tOetEvnDStartVal>$tCompareDFinishSend){
                                                if($tOetEvnDFinishVal>$tCompareDFinishSend){
                                                    if($tOetEvnDStartVal==$tCompareDStartSend && 
                                                    $tOetEvnDFinishVal==$tCompareDFinishSend){
                                                        $bCheckDateSecCompare = false;
                                                        break;
                                                    }else{
                                                        if($tOetEvnDStartVal<=$tOetEvnDFinishVal){
                                                            $bCheckDateSecCompare = true;
                                                        }else{
                                                            $bCheckDateSecCompare = false;
                                                            break;
                                                        }
                                                    }
                                                }else{
                                                    $bCheckDateSecCompare = false;
                                                    break;
                                                }
                                            }else{
                                                $bCheckDateSecCompare = false;
                                                break;
                                            }
                                        }else if($tOetEvnDStartVal==$tCompareDStartSend){
                                            $bCheckDateSecCompare = false;
                                            break;
                                        }
                                        
                                    }
                                    $bCheckTimeSecCompare = true;
                                    for($nJ = 0;$nJ<FCNnHSizeOf($aEVNListDateTime);$nJ++){
                                        $tCompareTStartSend = $aEVNListDateTime[$nJ]["FTEvnTStart"];
                                        $tCompareTFinishSend = $aEVNListDateTime[$nJ]["FTEvnTFinish"];
                                        if($tOetEvnTStartVal<=$tCompareTStartSend){
                                            if($tOetEvnTFinishVal<=$tCompareTStartSend){
                                                if($tOetEvnTStartVal==$tCompareTStartSend && 
                                                $tOetEvnTFinishVal==$tCompareTFinishSend){
                                                    $bCheckTimeSecCompare = false;
                                                    break;
                                                }else{
                                                    if($tOetEvnTStartVal<$tOetEvnTFinishVal){
                                                        $bCheckTimeSecCompare = true;
                                                    }else{
                                                        $bCheckTimeSecCompare = false;
                                                        break;
                                                    }
                                                }
                                            }else{
                                                if($tOetEvnTStartVal>=$tCompareTFinishSend){
                                                    if($tOetEvnTFinishVal>=$tCompareTFinishSend){
                                                        if($tOetEvnTStartVal==$tCompareTStartSend && 
                                                        $tOetEvnTFinishVal==$tCompareTFinishSend){
                                                            $bCheckTimeSecCompare = false;
                                                            break;
                                                        }else{
                                                            if($tOetEvnTStartVal<$tOetEvnTFinishVal){
                                                                $bCheckTimeSecCompare = true;
                                                            }else{
                                                                $bCheckTimeSecCompare = false;
                                                                break;
                                                            }
                                                        }
                                                    }else{
                                                        $bCheckTimeSecCompare = false;
                                                        break;
                                                    }
                                                }else{
                                                    $bCheckTimeSecCompare = false;
                                                    break;
                                                }
                                            }
                                        }else if($tOetEvnTStartVal>$tCompareTStartSend){
                                            if($tOetEvnTStartVal>=$tCompareTFinishSend){
                                                if($tOetEvnTFinishVal>=$tCompareTFinishSend){
                                                    if($tOetEvnTStartVal==$tCompareTStartSend && 
                                                    $tOetEvnTFinishVal==$tCompareTFinishSend){
                                                        $bCheckTimeSecCompare = false;
                                                        break;
                                                    }else{
                                                        if($tOetEvnTStartVal<$tOetEvnTFinishVal){
                                                            $bCheckTimeSecCompare = true;
                                                        }else{
                                                            $bCheckTimeSecCompare = false;
                                                            break;
                                                        }
                                                    }
                                                }else{
                                                    $bCheckTimeSecCompare = false;
                                                    break;
                                                }
                                            }else{
                                                $bCheckTimeSecCompare = false;
                                                break;
                                            }
                                        }
                                        
                                    }
                                    if($bCheckDateSecCompare || $bCheckTimeSecCompare){
                                        $bCheckDateNoAllCompare = true;
                                    }else{
                                        $bCheckDateNoAllCompare = false;
                                    }
                                }else{
                                    $bCheckTimeSecCompare = true;
                                    for($nJ = 0;$nJ<FCNnHSizeOf($aEVNListDateTime);$nJ++){
                                        $tCompareDStartSend = $aEVNListDateTime[$nJ]["FDEvnDStart"];
                                        $tCompareDFinishSend = $aEVNListDateTime[$nJ]["FTEvnTFinish"];
                                        $tCompareTStartSend = $aEVNListDateTime[$nJ]["FTEvnTStart"];
                                        $tCompareTFinishSend = $aEVNListDateTime[$nJ]["FTEvnTFinish"];
                                        if(($tOetEvnDStartVal==$tCompareDStartSend)||($tOetEvnDStartVal==$tCompareDFinishSend)){
                                            if($tOetEvnTStartVal<=$tCompareTStartSend){
                                                if($tOetEvnTFinishVal<=$tCompareTStartSend){
                                                    if($tOetEvnTStartVal==$tCompareTStartSend && 
                                                    $tOetEvnTFinishVal==$tCompareTFinishSend){
                                                        $bCheckTimeSecCompare = false;
                                                        break;
                                                    }else{
                                                        if($tOetEvnTStartVal<$tOetEvnTFinishVal){
                                                            $bCheckTimeSecCompare = true;
                                                        }else{
                                                            $bCheckTimeSecCompare = false;
                                                            break;
                                                        }
                                                    }
                                                }else{
                                                    if($tOetEvnTStartVal>=$tCompareTFinishSend){
                                                        if($tOetEvnTFinishVal>=$tCompareTFinishSend){
                                                            if($tOetEvnTStartVal==$tCompareTStartSend && 
                                                            $tOetEvnTFinishVal==$tCompareTFinishSend){
                                                                $bCheckTimeSecCompare = false;
                                                                break;
                                                            }else{
                                                                if($tOetEvnTStartVal<$tOetEvnTFinishVal){
                                                                    $bCheckTimeSecCompare = true;
                                                                }else{
                                                                    $bCheckTimeSecCompare = false;
                                                                    break;
                                                                }
                                                            }
                                                        }else{
                                                            $bCheckTimeSecCompare = false;
                                                            break;
                                                        }
                                                    }else{
                                                        $bCheckTimeSecCompare = false;
                                                        break;
                                                    }
                                                }
                                            }else if($tOetEvnTStartVal>$tCompareTStartSend){
                                                if($tOetEvnTStartVal>=$tCompareTFinishSend){
                                                    if($tOetEvnTFinishVal>=$tCompareTFinishSend){
                                                        if($tOetEvnTStartVal==$tCompareTStartSend && 
                                                        $tOetEvnTFinishVal==$tCompareTFinishSend){
                                                            $bCheckTimeSecCompare = false;
                                                            break;
                                                        }else{
                                                            if($tOetEvnTStartVal<$tOetEvnTFinishVal){
                                                                $bCheckTimeSecCompare = true;
                                                            }else{
                                                                $bCheckTimeSecCompare = false;
                                                                break;
                                                            }
                                                        }
                                                    }else{
                                                        $bCheckTimeSecCompare = false;
                                                        break;
                                                    }
                                                }else{
                                                    $bCheckTimeSecCompare = false;
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                    if($bCheckTimeSecCompare){
                                        $bCheckDateNoAllCompare = true;
                                    }else{
                                        $bCheckDateNoAllCompare = false;
                                    }
                                }
                            }
                            if($bCheckDateNoAllCompare == false){
                                break;
                            }





                            
                            




























                        }
                    }
                }
            }
            if($bCheckTimeCompare && $bCheckDateAllCompare && $bCheckDateNoAllCompare){

                $aDataMaster   = array(
                    'oetEvnCode'     => $this->input->post('oetEvnCode'),
                    'oetEvnName'     => $this->input->post('oetEvnName'),
                    'otaEvnRmk'      => $this->input->post('otaEvnRmk'),
                    'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                    'FDCreateOn'    => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                    'FNLngID'       => $this->session->userdata("tLangEdit"),
                    'ocmEvnTypeSend'    => $this->input->post("ocmEvnTypeSend"),
                    'ocbEvnStaAllDay'    => $this->input->post("ocbEvnStaAllDay"),
                    'oetEvnDStartSend'    => $this->input->post("oetEvnDStartSend"),
                    'oetEvnDFinishSend'    => $this->input->post("oetEvnDFinishSend"),
                    'oetEvnTStartSend'    => $this->input->post("oetEvnTStartSend"),
                    'oetEvnTFinishSend'    => $this->input->post("oetEvnTFinishSend")
                );
                $this->db->trans_begin();
                $aStaEvnMaster  = $this->mPdtNoSleByEvn->FSaMEVNAddUpdateMaster($aDataMaster);
                $aStaEvnLang    = $this->mPdtNoSleByEvn->FSaMEVNAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Error Add Product NoSale By Event."
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['oetEvnCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Product NoSale By Event.'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '901',
                    'tCodeReturn'	=> $this->input->post('oetEvnCode'),
                    'tStaMessg'    => "ไม่สามารถเพิ่มหรือแก้ไขข้อมูลได้เนื่องจากข้อมูลทับซ้อนกันในฐานข้อมูล"
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : ตรวจสอบข้อมูลรายการช่วงเวลาซ้ำ ประเภท ช่วงเวลา่
    //Parameters : -
    //Creator : 24/09/2019 pap
    //Return : -
    //Return Type : object
    public function FStCEVNCheckTimeDaplicate(){
        $aEVNListTimeLine = $this->mPdtNoSleByEvn->FSaMGetEVNListTime($this->input->post("tOetEvnCode"));
        if($aEVNListTimeLine){
            $tOetEvnTStartVal = $this->input->post("tOetEvnTStartVal");
            $tOetEvnTFinishVal = $this->input->post("tOetEvnTFinishVal");
            $bCheckTimeCompare = true;
            for($nI = 0;$nI<FCNnHSizeOf($aEVNListTimeLine);$nI++){
                $tCompareTStartSend = $aEVNListTimeLine[$nI]["FTEvnTStart"];
                $tCompareTFinishSend = $aEVNListTimeLine[$nI]["FTEvnTFinish"];
                if($tOetEvnTStartVal<=$tCompareTStartSend){
                    if($tOetEvnTFinishVal<=$tCompareTStartSend){
                        if($tOetEvnTStartVal==$tCompareTStartSend && 
                        $tOetEvnTFinishVal==$tCompareTFinishSend){
                            $bCheckTimeCompare = false;
                            break;
                        }else{
                            if($tOetEvnTStartVal<$tOetEvnTFinishVal){
                                $bCheckTimeCompare = true;
                            }else{
                                $bCheckTimeCompare = false;
                                break;
                            }
                        }
                    }else{
                        if($tOetEvnTStartVal>=$tCompareTFinishSend){
                            if($tOetEvnTFinishVal>=$tCompareTFinishSend){
                                if($tOetEvnTStartVal==$tCompareTStartSend && 
                                $tOetEvnTFinishVal==$tCompareTFinishSend){
                                    $bCheckTimeCompare = false;
                                    break;
                                }else{
                                    if($tOetEvnTStartVal<$tOetEvnTFinishVal){
                                        $bCheckTimeCompare = true;
                                    }else{
                                        $bCheckTimeCompare = false;
                                        break;
                                    }
                                }
                            }else{
                                $bCheckTimeCompare = false;
                                break;
                            }
                        }else{
                            $bCheckTimeCompare = false;
                            break;
                        }
                    }
                }else if($tOetEvnTStartVal>$tCompareTStartSend){
                    if($tOetEvnTStartVal>=$tCompareTFinishSend){
                        if($tOetEvnTFinishVal>=$tCompareTFinishSend){
                            if($tOetEvnTStartVal==$tCompareTStartSend && 
                            $tOetEvnTFinishVal==$tCompareTFinishSend){
                                $bCheckTimeCompare = false;
                                break;
                            }else{
                                if($tOetEvnTStartVal<$tOetEvnTFinishVal){
                                    $bCheckTimeCompare = true;
                                }else{
                                    $bCheckTimeCompare = false;
                                    break;
                                }
                            }
                        }else{
                            $bCheckTimeCompare = false;
                            break;
                        }
                    }else{
                        $bCheckTimeCompare = false;
                        break;
                    }
                }
            
            }
            if($bCheckTimeCompare){
                echo json_encode(true);
            }else{
                echo json_encode(false);
            }
        }else{
            echo json_encode(true);
        }
    }

    //Functionality : ตรวจสอบข้อมูลรายการช่วงวันที่ซ้ำ ประเภท ช่วงวันที่ แบบทั้งวัน
    //Parameters : -
    //Creator : 24/09/2019 pap
    //Return : -
    //Return Type : object
    public function FStCEVNCheckDateDaplicate(){
        $aEVNListDate = $this->mPdtNoSleByEvn->FSaMGetEVNListDate($this->input->post("tOetEvnCode"));
        if($aEVNListDate){
            $tOetEvnDStartVal = $this->input->post("tOetEvnDStartVal");
            $tOetEvnDFinishVal = $this->input->post("tOetEvnDFinishVal");
            $bCheckDateAllCompare = true;
            for($nI = 0;$nI<FCNnHSizeOf($aEVNListDate);$nI++){
                $tCompareDStartSend = $aEVNListDate[$nI]["FDEvnDStart"];
                $tCompareDFinishSend = $aEVNListDate[$nI]["FDEvnDFinish"];
                if($tOetEvnDStartVal<=$tCompareDStartSend){
                    if($tOetEvnDFinishVal<=$tCompareDStartSend){
                        if($tOetEvnDStartVal==$tCompareDStartSend && 
                        $tOetEvnDFinishVal==$tCompareDFinishSend){
                            $bCheckDateAllCompare = false;
                            break;
                        }else{
                            if($tOetEvnDStartVal<$tOetEvnDFinishVal){
                                $bCheckDateAllCompare = true;
                            }else{
                                $bCheckDateAllCompare = false;
                                break;
                            }
                        }
                    }else{
                        if($tOetEvnDStartVal>=$tCompareDFinishSend){
                            if($tOetEvnDFinishVal>=$tCompareDFinishSend){
                                if($tOetEvnDStartVal==$tCompareDStartSend && 
                                $tOetEvnDFinishVal==$tCompareDFinishSend){
                                    $bCheckDateAllCompare = false;
                                    break;
                                }else{
                                    if($tOetEvnDStartVal<$tOetEvnDFinishVal){
                                        $bCheckDateAllCompare = true;
                                    }else{
                                        $bCheckDateAllCompare = false;
                                        break;
                                    }
                                }
                            }else{
                                $bCheckDateAllCompare = false;
                                break;
                            }
                        }else{
                            $bCheckDateAllCompare = false;
                            break;
                        }
                    }
                }else if($tOetEvnDStartVal>$tCompareDStartSend){
                    if($tOetEvnDStartVal>=$tCompareDFinishSend){
                        if($tOetEvnDFinishVal>=$tCompareDFinishSend){
                            if($tOetEvnDStartVal==$tCompareDStartSend && 
                            $tOetEvnDFinishVal==$tCompareDFinishSend){
                                $bCheckDateAllCompare = false;
                                break;
                            }else{
                                if($tOetEvnDStartVal<$tOetEvnDFinishVal){
                                    $bCheckDateAllCompare = true;
                                }else{
                                    $bCheckDateAllCompare = false;
                                    break;
                                }
                            }
                        }else{
                            $bCheckDateAllCompare = false;
                            break;
                        }
                    }else{
                        $bCheckDateAllCompare = false;
                        break;
                    }
                }
                
            }
            if($bCheckDateAllCompare){
                echo json_encode(true);
            }else{
                echo json_encode(false);
            }
        }else{
            echo json_encode(true);
        }
    }

    //Functionality : ตรวจสอบข้อมูลรายการช่วงวันที่ซ้ำ ประเภท ช่วงวันที่ แบบไม่ทั้งวัน
    //Parameters : -
    //Creator : 24/09/2019 pap
    //Return : -
    //Return Type : object
    public function FStCEVNCheckDateTimeDaplicate(){
        $aEVNListDateTime = $this->mPdtNoSleByEvn->FSaMGetEVNListDateTime($this->input->post("tOetEvnCode"));
        if($aEVNListDateTime){
            $tOetEvnTStartVal = $this->input->post("tOetEvnTStartVal");
            $tOetEvnTFinishVal = $this->input->post("tOetEvnTFinishVal");
            $tOetEvnDStartVal = $this->input->post("tOetEvnDStartVal");
            $tOetEvnDFinishVal = $this->input->post("tOetEvnDFinishVal");
            if($tOetEvnDStartVal!=$tOetEvnDFinishVal){
                $bCheckDateSecCompare = true;
                for($nI = 0;$nI<FCNnHSizeOf($aEVNListDateTime);$nI++){
                    $tCompareDStartSend = $aEVNListDateTime[$nI]["FDEvnDStart"];
                    $tCompareDFinishSend = $aEVNListDateTime[$nI]["FDEvnDFinish"];
                    if($tOetEvnDStartVal<$tCompareDStartSend){
                        if($tOetEvnDFinishVal<$tCompareDStartSend){
                            if($tOetEvnDStartVal==$tCompareDStartSend && 
                            $tOetEvnDFinishVal==$tCompareDFinishSend){
                                $bCheckDateSecCompare = false;
                                break;
                            }else{
                                if($tOetEvnDStartVal<=$tOetEvnDFinishVal){
                                    $bCheckDateSecCompare = true;
                                }else{
                                    $bCheckDateSecCompare = false;
                                    break;
                                }
                            }
                        }else{
                            if($tOetEvnDStartVal>$tCompareDFinishSend){
                                if($tOetEvnDFinishVal>$tCompareDFinishSend){
                                    if($tOetEvnDStartVal==$tCompareDStartSend && 
                                    $tOetEvnDFinishVal==$tCompareDFinishSend){
                                        $bCheckDateSecCompare = false;
                                        break;
                                    }else{
                                        if($tOetEvnDStartVal<=$tOetEvnDFinishVal){
                                            $bCheckDateSecCompare = true;
                                        }else{
                                            $bCheckDateSecCompare = false;
                                            break;
                                        }
                                    }
                                }else{
                                    $bCheckDateSecCompare = false;
                                    break;
                                }
                            }else{
                                $bCheckDateSecCompare = false;
                                break;
                            }
                        }
                    }else if($tOetEvnDStartVal>$tCompareDStartSend){
                        if($tOetEvnDStartVal>$tCompareDFinishSend){
                            if($tOetEvnDFinishVal>$tCompareDFinishSend){
                                if($tOetEvnDStartVal==$tCompareDStartSend && 
                                $tOetEvnDFinishVal==$tCompareDFinishSend){
                                    $bCheckDateSecCompare = false;
                                    break;
                                }else{
                                    if($tOetEvnDStartVal<=$tOetEvnDFinishVal){
                                        $bCheckDateSecCompare = true;
                                    }else{
                                        $bCheckDateSecCompare = false;
                                        break;
                                    }
                                }
                            }else{
                                $bCheckDateSecCompare = false;
                                break;
                            }
                        }else{
                            $bCheckDateSecCompare = false;
                            break;
                        }
                    }else if($tOetEvnDStartVal==$tCompareDStartSend){
                        $bCheckDateSecCompare = false;
                        break;
                    }
                    
                }
                $bCheckTimeSecCompare = true;
                for($nI = 0;$nI<FCNnHSizeOf($aEVNListDateTime);$nI++){
                    $tCompareTStartSend = $aEVNListDateTime[$nI]["FTEvnTStart"];
                    $tCompareTFinishSend = $aEVNListDateTime[$nI]["FTEvnTFinish"];
                    if($tOetEvnTStartVal<=$tCompareTStartSend){
                        if($tOetEvnTFinishVal<=$tCompareTStartSend){
                            if($tOetEvnTStartVal==$tCompareTStartSend && 
                            $tOetEvnTFinishVal==$tCompareTFinishSend){
                                $bCheckTimeSecCompare = false;
                                break;
                            }else{
                                if($tOetEvnTStartVal<$tOetEvnTFinishVal){
                                    $bCheckTimeSecCompare = true;
                                }else{
                                    $bCheckTimeSecCompare = false;
                                    break;
                                }
                            }
                        }else{
                            if($tOetEvnTStartVal>=$tCompareTFinishSend){
                                if($tOetEvnTFinishVal>=$tCompareTFinishSend){
                                    if($tOetEvnTStartVal==$tCompareTStartSend && 
                                    $tOetEvnTFinishVal==$tCompareTFinishSend){
                                        $bCheckTimeSecCompare = false;
                                        break;
                                    }else{
                                        if($tOetEvnTStartVal<$tOetEvnTFinishVal){
                                            $bCheckTimeSecCompare = true;
                                        }else{
                                            $bCheckTimeSecCompare = false;
                                            break;
                                        }
                                    }
                                }else{
                                    $bCheckTimeSecCompare = false;
                                    break;
                                }
                            }else{
                                $bCheckTimeSecCompare = false;
                                break;
                            }
                        }
                    }else if($tOetEvnTStartVal>$tCompareTStartSend){
                        if($tOetEvnTStartVal>=$tCompareTFinishSend){
                            if($tOetEvnTFinishVal>=$tCompareTFinishSend){
                                if($tOetEvnTStartVal==$tCompareTStartSend && 
                                $tOetEvnTFinishVal==$tCompareTFinishSend){
                                    $bCheckTimeSecCompare = false;
                                    break;
                                }else{
                                    if($tOetEvnTStartVal<$tOetEvnTFinishVal){
                                        $bCheckTimeSecCompare = true;
                                    }else{
                                        $bCheckTimeSecCompare = false;
                                        break;
                                    }
                                }
                            }else{
                                $bCheckTimeSecCompare = false;
                                break;
                            }
                        }else{
                            $bCheckTimeSecCompare = false;
                            break;
                        }
                    }
                    
                }
                if($bCheckDateSecCompare || $bCheckTimeSecCompare){
                    echo json_encode(true);
                }else{
                    echo json_encode(false);
                    
                }
            }else{
                $bCheckTimeSecCompare = true;
                for($nI = 0;$nI<FCNnHSizeOf($aEVNListDateTime);$nI++){
                    $tCompareDStartSend = $aEVNListDateTime[$nI]["FDEvnDStart"];
                    $tCompareDFinishSend = $aEVNListDateTime[$nI]["FDEvnDFinish"];
                    $tCompareTStartSend = $aEVNListDateTime[$nI]["FTEvnTStart"];
                    $tCompareTFinishSend = $aEVNListDateTime[$nI]["FTEvnTFinish"];
                    if(($tOetEvnDStartVal==$tCompareDStartSend)||($tOetEvnDStartVal==$tCompareDFinishSend)){
                        if($tOetEvnTStartVal<=$tCompareTStartSend){
                            if($tOetEvnTFinishVal<=$tCompareTStartSend){
                                if($tOetEvnTStartVal==$tCompareTStartSend && 
                                   $tOetEvnTFinishVal==$tCompareTFinishSend){
                                    $bCheckTimeSecCompare = false;
                                    break;
                                }else{
                                    if($tOetEvnTStartVal<$tOetEvnTFinishVal){
                                        $bCheckTimeSecCompare = true;
                                    }else{
                                        $bCheckTimeSecCompare = false;
                                        break;
                                    }
                                }
                            }else{
                                if($tOetEvnTStartVal>=$tCompareTFinishSend){
                                    if($tOetEvnTFinishVal>=$tCompareTFinishSend){
                                        if($tOetEvnTStartVal==$tCompareTStartSend && 
                                        $tOetEvnTFinishVal==$tCompareTFinishSend){
                                            $bCheckTimeSecCompare = false;
                                            break;
                                        }else{
                                            if($tOetEvnTStartVal<$tOetEvnTFinishVal){
                                                $bCheckTimeSecCompare = true;
                                            }else{
                                                $bCheckTimeSecCompare = false;
                                                break;
                                            }
                                        }
                                    }else{
                                        $bCheckTimeSecCompare = false;
                                        break;
                                    }
                                }else{
                                    $bCheckTimeSecCompare = false;
                                    break;
                                }
                            }
                        }else if($tOetEvnTStartVal>$tCompareTStartSend){
                            if($tOetEvnTStartVal>=$tCompareTFinishSend){
                                if($tOetEvnTFinishVal>=$tCompareTFinishSend){
                                    if($tOetEvnTStartVal==$tCompareTStartSend && 
                                    $tOetEvnTFinishVal==$tCompareTFinishSend){
                                        $bCheckTimeSecCompare = false;
                                        break;
                                    }else{
                                        if($tOetEvnTStartVal<$tOetEvnTFinishVal){
                                            $bCheckTimeSecCompare = true;
                                        }else{
                                            $bCheckTimeSecCompare = false;
                                            break;
                                        }
                                    }
                                }else{
                                    $bCheckTimeSecCompare = false;
                                    break;
                                }
                            }else{
                                $bCheckTimeSecCompare = false;
                                break;
                            }
                        }
                    }
                }
                
                if($bCheckTimeSecCompare){
                    echo json_encode(true);
                }else{
                    echo json_encode(false);
                }
            }
        }else{
            echo json_encode(true);
        }
    }

    //Functionality : Event Delete Product NoSale By Event 
    //Parameters : Ajax jReason()
    //Creator : 24/09/2018 wasin
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCEVNDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTEvnCode' => $tIDCode
        );
        $aResDel    = $this->mPdtNoSleByEvn->FSaMEVNDelAll($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }
}