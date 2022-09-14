<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cMerpdtgroup extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('product/merpdtgroup/mMerpdtgroup');
    }

    public function index($nMgpBrowseType,$tMgpBrowseOption){
        $nMsgResp   = array('title'=>"Product Group");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $vBtnSave               = FCNaHBtnSaveActiveHTML('MerPdtGrp/0/0'); 
        $aAlwEventMgpGroup	    = FCNaHCheckAlwFunc('MerPdtGrp/0/0');
        $this->load->view('product/merpdtgroup/wMerpdtgroup', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nMgpBrowseType'    => $nMgpBrowseType,
            'tMgpBrowseOption'  => $tMgpBrowseOption,
            'aAlwEventMgp'      => $aAlwEventMgpGroup
        ));
    }
    
    //Functionality : Function Call Product Group Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 26/07/2017 Saharat(Golf)
    //Return : String View
    //Return Type : View
    public function FSvCMGPListPage(){
        $tMgpCode = $this->input->post('tMgpCode');
        $aAlwEventMgpGroup	    = FCNaHCheckAlwFunc('MerPdtGrp/0/0');
        $this->load->view('product/merpdtgroup/wMerpdtgroupList', array(
            'aAlwEventMgp' => $aAlwEventMgpGroup,
            'tMgpCode'     => $tMgpCode
        ));
    }

    //Functionality : Function Call DataTables Product Group
    //Parameters : Ajax Call View DataTable
    //Creator : 18/09/2018 Saharat(Golf)
    //Return : String View
    //Return Type : View
    public function FSvCMgpDataList(){
        try{
            $tMerCode       = $this->input->post('tMerCode');
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll,
                'tMerCode'      => $tMerCode 
            );
            $aMgpDataList           = $this->mMerpdtgroup->FSaMMGPList($aData);
            $aAlwEventPdtGroup	    = FCNaHCheckAlwFunc('merchant/0/0');
            $aGenTable  = array(
                'aMgpDataList'      => $aMgpDataList,
                'nPage'             => $nPage,
                'tSearchAll'        => $tSearchAll,
                'aAlwEventProductGroup' => $aAlwEventPdtGroup
            );
            $this->load->view('product/merpdtgroup/wMerpdtgroupDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Group Page Add
    //Parameters : Ajax Call View Add
    //Creator :26/07/2019 Saharat(Golf)
    //Return : String View
    //Return Type : View
    public function FSvCMGPAddPage(){
        try{
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aData  = array(
                'FNLngID'   => $nLangEdit,
            );
            $aDataAdd = array(
                'aResult'   => array('rtCode'=>'99'),
                'tMerCode'  => $this->input->post('tMerCode')
            );
            $this->load->view('product/merpdtgroup/wMerpdtgroupAdd',$aDataAdd);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Group Page Edit
    //Parameters : Ajax Call View Add
    //Creator : 30/07/2019 Saharat(Golf)
    //Return : String View
    //Return Type : View
    public function FSvCMGPEditPage(){
        try{
            $tMgpCode       = $this->input->post('tMgpCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMMerPdtGrp_L');
            $aAlwEventMgp	= FCNaHCheckAlwFunc('agency/0/0'); //Controle Event
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }
            $aData  = array(
                'FTMgpCode' => $tMgpCode, 
                'FNLngID'   => $nLangEdit
            );
            $aResult       = $this->mMerpdtgroup->FSaMMGPGetDataByID($aData);
            $aDataEdit     = array(
            'aResult'           => $aResult,
            'aAlwEventMgp'      => $aAlwEventMgp
            );
            $this->load->view('product/merpdtgroup/wMerpdtgroupAdd',$aDataEdit);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Add Product Group
    //Parameters : Ajax Event
    //Creator : 26/07/2019 Saharat(Golf)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCMGPAddEvent(){
        try{
            date_default_timezone_set("Asia/Bangkok");
            $aDataMaster = array(
                'tIsAutoGenCode'    => $this->input->post('ocbMgpAutoGenCode'),
                'FTMgpCode'         => $this->input->post('oetMgpCode'),
                'FTMerCode'         => $this->input->post('ohdMerchantcode'),                
                'FTMgpName'         => $this->input->post('oetMgpName'),   
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTCreateBy'        => $this->session->userdata('tSesUsername')             
            );
                    
            if($aDataMaster['tIsAutoGenCode'] == '1'){ 
                $aStoreParam = array(
                    "tTblName"    => 'TCNMMerPdtGrp',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTMgpCode']   = $aAutogen[0]["FTXxhDocNo"];

                // $aGenCode = FCNaHGenCodeV5('TCNMMerPdtGrp','0');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataMaster['FTMgpCode'] = $aGenCode['rtMgpCode'];
                // }
            }

            //ตรวจสอบบค่าซ้ำ
            $oCountDup  = $this->mMerpdtgroup->FSnMMGPCheckDuplicate($aDataMaster['FTMgpCode']);
            $nStaDup    = $oCountDup[0]->counts;

            if($nStaDup == 0){
                $this->db->trans_begin();
                $aStaEventMaster  = $this->mMerpdtgroup->FSaMMGPAddUpdateMaster($aDataMaster);
                $aStaEventLang    = $this->mMerpdtgroup->FSaMMGPAddUpdateLang($aDataMaster);
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
                        'tCodeReturn'	=> $aDataMaster['FTMgpCode'],
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

    //Functionality : Event Edit Product Group
    //Parameters : Ajax Event
    //Creator : 19/09/2018 wasin
    //Update : 26/03/2019 pap
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCMGPEditEvent(){
        try{
            date_default_timezone_set("Asia/Bangkok");
            $aDataMaster = array(
                'FTMgpCode'         => $this->input->post('oetMgpCode'),
                'FTMerCode'         => $this->input->post('ohdMerchantcode'),                
                'FTMgpName'         => $this->input->post('oetMgpName'),   
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTCreateBy'        => $this->session->userdata('tSesUsername')             
            );
               
            $this->db->trans_begin();
            $aStaEventMaster  = $this->mMerpdtgroup->FSaMMGPAddUpdateMaster($aDataMaster);
            $aStaEventLang    = $this->mMerpdtgroup->FSaMMGPAddUpdateLang($aDataMaster);
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
                    'tCodeReturn'	=> $aDataMaster['FTMgpCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
            
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Delete Product Group
    //Parameters : Ajax jReason()
    //Creator : 19/09/2018 wasin
    //Update: 1/04/2019 pap
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCMgpDeleteEvent(){
        try{
            $tIDCode    = $this->input->post('tIDCode');
            $aDataMaster = array(
                'FTMgpCode' => $tIDCode,
            );
            $aDataDelete = $this->mMerpdtgroup->FSaMGetChainForDelete($aDataMaster);
            $aResDel    = $this->mMerpdtgroup->FSaMMgpDelAll($aDataDelete);
            $nNumRowPdtPGP = $this->mMerpdtgroup->FSnMPGPGetAllNumRow();
            if($nNumRowPdtPGP!==false){
                $aReturn    = array(
                    'nStaEvent' => $aResDel['rtCode'],
                    'tStaMessg' => $aResDel['rtDesc'],
                    'nNumRowPdtPgp' => $nNumRowPdtPGP
                );
                echo json_encode($aReturn);
            }else{
                echo "database error!";
            }
        }catch(Exception $Error){
            echo $Error;
        }
    }








}