<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cShipVia extends MX_Controller {
    public function __construct(){
        parent::__construct ();
        $this->load->model('shipvia/shipvia/mShipVia');
    }

    public function index($nViaBrowseType,$tViaBrowseOption){
        $nMsgResp   = array('title'=>"ShipVia");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave       = FCNaHBtnSaveActiveHTML('shipvia/0/0');
        $aAlwEvent      = FCNaHCheckAlwFunc('shipvia/0/0');
        $this->load->view('shipvia/shipvia/wShipVia', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nViaBrowseType'    => $nViaBrowseType,
            'tViaBrowseOption'  => $tViaBrowseOption,
            'aAlwEvent'         => $aAlwEvent
        ));
    }

    //Functionality : Function Call ShipVia Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 04/10/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCVIAListPage(){ 
        $aAlwEvent	        = FCNaHCheckAlwFunc('shipvia/0/0');
        $aNewData  		    = array( 'aAlwEvent' => $aAlwEvent);
        $this->load->view('shipvia/shipvia/wShipViaList',$aNewData);
    }

    
    //Functionality : Function Call DataTables ShipVia
    //Parameters : Ajax Call View DataTable
    //Creator : 04/10/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCVIADataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMShipVia_L');
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
            $aViaDataList   = $this->mShipVia->FSaMVIAList($aData); 
            $aGenTable  = array(
                'aViaDataList'  => $aViaDataList,
                'nPage'         => $nPage,
                'tSearchAll'    => $tSearchAll
            );
            $this->load->view('shipvia/shipvia/wShipViaDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage ShipVia Add
    //Parameters : Ajax Call View Add
    //Creator : 04/10/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCVIAAddPage(){
        try{
            $aDataShipVia = array(
                'nStaAddOrEdit'   => 99
            );
            $this->load->view('shipvia/shipvia/wShipViaAdd',$aDataShipVia);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage ShipVia Edits
    //Parameters : Ajax Call View Add
    //Creator : 04/10/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCVIAEditPage(){
        try{
            $tViaCode       = $this->input->post('tViaCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMShipVia_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }

            $aData  = array(
                'FTViaCode' => $tViaCode,
                'FNLngID'   => $nLangEdit
            );
                                                
            $aViaData       = $this->mShipVia->FSaMVIAGetDataByID($aData);
            $aDataShipVia   = array(
                'nStaAddOrEdit' => 1,
                'aViaData'      => $aViaData
            );
            $this->load->view('shipvia/shipvia/wShipViaAdd',$aDataShipVia);
        }catch(Exception $Error){
            echo $Error;
        }
    }


     //Functionality : Event Add ShipVia
    //Parameters : Ajax Event
    //Creator : 07/05/2019 Witsarut (Bell)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCVIAAddEvent(){ 
        try{
            date_default_timezone_set("Asia/Bangkok");
            $aDataShipVia   = array(
                'tIsAutoGenCode' => $this->input->post('ocbShipviaAutoGenCode'),
                'FTViaCode' => $this->input->post('oetViaCode'),
                'FTViaName' => $this->input->post('oetViaName'),
                // 'FTViaRmk'  => $this->input->post('otaViaRmk'),
                'FDCreateOn' => date('Y-m-d'),
                'FDLastUpdOn' => date('Y-m-d'),
                'FTCreateBy'  => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'  => $this->session->userdata('tSesUsername'),
                'FNLngID'   => $this->session->userdata("tLangEdit")
            );
     
            if($aDataShipVia['tIsAutoGenCode'] == '1'){ // Check Auto Gen Department Code?
                // Auto Gen Department Code
                $aStoreParam = array(
                    "tTblName"    => 'TCNMShipVia',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataShipVia['FTViaCode']   = $aAutogen[0]["FTXxhDocNo"];

                // $aGenCode = FCNaHGenCodeV5('TCNMShipVia','0');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataShipVia['FTViaCode'] = $aGenCode['rtViaCode'];
                // }
            }
       
            $oCountDup      = $this->mShipVia->FSnMVIACheckDuplicate($aDataShipVia['FTViaCode']);
            $nStaDup        = $oCountDup['counts'];

            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaViaMaster  = $this->mShipVia->FSaMVIAAddUpdateMaster($aDataShipVia);
                $aStaViaLang    = $this->mShipVia->FSaMVIAAddUpdateLang($aDataShipVia);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add ShipVia"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataShipVia['FTViaCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add ShipVia'
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


    //Functionality : Event Edit ShipVia
    //Parameters : Ajax Event
    //Creator : 04/10/2018 Witsarut(Bell)
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCVIAEditEvent(){ 
        try{
            $this->db->trans_begin();
            $aDataShipVia   = array(
                'FTViaCode' => $this->input->post('oetViaCode'),
                'FTViaName' => $this->input->post('oetViaName'),
                // 'FTViaRmk'  => $this->input->post('otaViaRmk'),
                'FDCreateOn' => date('Y-m-d'),
                'FDLastUpdOn' => date('Y-m-d'),
                'FTCreateBy'  => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'  => $this->session->userdata('tSesUsername'),
                'FNLngID'   => $this->session->userdata("tLangEdit")
            );
            $aStaViaMaster  = $this->mShipVia->FSaMVIAAddUpdateMaster($aDataShipVia);
            $aStaViaLang    = $this->mShipVia->FSaMVIAAddUpdateLang($aDataShipVia);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit ShipVia"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataShipVia['FTViaCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit ShipVia'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Delete ShipVia
    //Parameters : Ajax jReason()
    //Creator : 04/09/2018 Witsarut(Bell)
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCVIADeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTViaCode' => $tIDCode
        );
        $aResDel    = $this->mShipVia->FSaMVIADelAll($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

}