<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cArea extends MX_Controller {
    public function __construct(){
        parent::__construct ();
        $this->load->model('address/area/mArea');
    }

    public function index($nAreBrowseType,$tAreBrowseOption){
        $nMsgResp   = array('title' => "Area");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave           = FCNaHBtnSaveActiveHTML('area/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventArea	    = FCNaHCheckAlwFunc('area/0/0');
        $this->load->view('address/area/wArea', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nAreBrowseType'    => $nAreBrowseType,
            'tAreBrowseOption'  => $tAreBrowseOption,
            'aAlwEventArea'     => $aAlwEventArea
        ));
    }

    //Functionality : Function Call Area Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 22/11/2018 Witsarut
    //Return : String View
    //Return Type : View
    public function FSvCAREListPage(){ 
        $aAlwEventArea	    = FCNaHCheckAlwFunc('area/0/0');
		$aNewData  			= array( 'aAlwEventArea' => $aAlwEventArea );
        $this->load->view('address/area/wAreaList',$aNewData);
    }

    
    //Functionality : Function Call DataTables Area
    //Parameters : Ajax Call View DataTable
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCAREDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMArea_L');
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
            $aAreDataList   = $this->mArea->FSaMAREList($aData); 
            $aAlwEvent      = FCNaHCheckAlwFunc('area/0/0'); 
            $aGenTable  = array(
                'aAlwEventArea' 	    => $aAlwEvent,
                'aAreDataList'          => $aAreDataList,
                'nPage'                 => $nPage,
                'tSearchAll'            => $tSearchAll
            );
            $this->load->view('address/area/wAreaDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product  Brand Add
    //Parameters : Ajax Call View Add
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCAREAddPage(){
        try{
            $aDataAre = array(
                'nStaAddOrEdit'   => 99
            );
            $this->load->view('address/area/wAreaAdd',$aDataAre);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage Area Edits
    //Parameters : Ajax Call View Add
    //Creator : 22/11/2018 Witsarut
    //Return : String View
    //Return Type : View
    public function FSvCAREEditPage(){
        try{
            $tAreCode       = $this->input->post('tAreCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMArea_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }

            $aData  = array(
                'FTAreCode' => $tAreCode,
                'FNLngID'   => $nLangEdit
            );
                                                
            $aAreData       = $this->mArea->FSaMAREGetDataByID($aData);
            $aDataAre   = array(
                'nStaAddOrEdit' => 1,
                'aAreData'      => $aAreData
            );
            $this->load->view('address/area/wAreaAdd',$aDataAre);
        }catch(Exception $Error){
            echo $Error;
        }
    }


     //Functionality : Event Add Area
    //Parameters : Ajax Event
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCAREAddEvent(){ 
        try{

            $tIsAutoGenCode =   $this->input->post('ocbAreAutoGenCode');
            // Setup Reason Code
            $tAreCode = "";
            if(isset($tIsAutoGenCode) && $tIsAutoGenCode == '1'){
                $aStoreParam = array(
                    "tTblName"    => 'TCNMArea',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $tAreCode   = $aAutogen[0]["FTXxhDocNo"];

                // Call Auto Gencode Helper
                //  $aGenCode = FCNaHGenCodeV5('TCNMArea');
                //  if($aGenCode['rtCode'] == '1'){
                //     $tAreCode = $aGenCode['rtAreCode'];
                //  }
            }else{
                $tAreCode = $this->input->post('oetAreCode');
            }


            $aDataAre   = array(
                'FTAreCode'     => $tAreCode,
                'FTAreName'     => $this->input->post('oetAreName'),
                'FDCreateOn'    => date('Y-m-d'),
                'FDLastUpdOn'   => date('Y-m-d'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );


            $oCountDup      = $this->mArea->FSnMARECheckDuplicate($aDataAre['FTAreCode']);
            $nStaDup        = $oCountDup['counts'];
            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaAreMaster  = $this->mArea->FSaMAREAddUpdateMaster($aDataAre);
                $aStaAreLang    = $this->mArea->FSaMAREAddUpdateLang($aDataAre);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Area"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataAre['FTAreCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Area'
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


    //Functionality : Event Edit Area
    //Parameters : Ajax Event
    //Creator : 22/11/2018 Witsarut
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCAREEditEvent(){ 
        try{
            $this->db->trans_begin();
            $aDataAre   = array(
                'FTAreCode' => $this->input->post('oetAreCode'),
                'FTAreName' => $this->input->post('oetAreName'),
                'FDCreateOn' => date('Y-m-d'),
                'FDLastUpdOn' => date('Y-m-d'),
                'FTCreateBy'  => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'  => $this->session->userdata('tSesUsername'),
                'FNLngID'   => $this->session->userdata("tLangEdit")
            );
            $aStaAreMaster  = $this->mArea->FSaMAREAddUpdateMaster($aDataAre);
            $aStaAreLang    = $this->mArea->FSaMAREAddUpdateLang($aDataAre);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit Area"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataAre['FTAreCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit Area'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Delete Area
    //Parameters : Ajax jReason()
    //Creator : 22/11/2018 Witsarut
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCAREDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTAreCode' => $tIDCode
        );
        $aResDel    = $this->mArea->FSaMAREDelAll($aDataMaster);
        $nNumRowAreLoc  = $this->mArea->FSnMLOCGetAllNumRow();
        
        if($nNumRowAreLoc){
            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
                'nNumRowAreLoc' => $nNumRowAreLoc,
            );
            echo json_encode($aReturn);
        }else{
            echo "database error";
        }
    }

}