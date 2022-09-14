<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cSupplierLev extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('supplier/supplierlev/mSupplierLev');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nSlvBrowseType,$tSlvBrowseOption){
        $nMsgResp   = array('title'=>"SupplierLevel");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave                   = FCNaHBtnSaveActiveHTML('supplierlev/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventSupplierLevel	    = FCNaHCheckAlwFunc('supplierlev/0/0');
        $this->load->view('supplier/supplierlev/wSupplierLev', array (
            'nMsgResp'                  => $nMsgResp,
            'vBtnSave'                  => $vBtnSave,
            'nSlvBrowseType'            => $nSlvBrowseType,
            'tSlvBrowseOption'          => $tSlvBrowseOption,
            'aAlwEventSupplierLevel'    => $aAlwEventSupplierLevel
        ));
    }

    //Functionality : Function Call SupplierLevel Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 09/10/2018 witsarut
    //Return : String View
    //Return Type : View
    public function FSvCSLVListPage(){
        $aAlwEventSupplierLevel	    = FCNaHCheckAlwFunc('supplierlev/0/0');
        $this->load->view('supplier/supplierlev/wSupplierLevList', array(
            'aAlwEventSupplierLevel'    => $aAlwEventSupplierLevel
        ));
    }

    //Functionality : Function Call DataTables SupplierLevel
    //Parameters : Ajax Call View DataTable
    //Creator : 09/10/2018 witsarut
    //Return : String View
    //Return Type : View
    public function FSvCSLVDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMSplLev_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            // }
            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll
            );

            $aSlvDataList               = $this->mSupplierLev->FSaMSLVList($aData);
            $aAlwEventSupplierLevel	    = FCNaHCheckAlwFunc('supplierlev/0/0');
            $aGenTable  = array(
                'aSlvDataList'              => $aSlvDataList,
                'nPage'                     => $nPage,
                'tSearchAll'                => $tSearchAll,
                'aAlwEventSupplierLevel'    => $aAlwEventSupplierLevel
            );
            $this->load->view('supplier/supplierlev/wSupplierLevDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage SupplierLevel Add
    //Parameters : Ajax Call View Add
    //Creator : 09/10/2018 witsarut
    //Return : String View
    //Return Type : View
    public function FSvCSLVAddPage(){
        try{
            $aDataSupplierLevel = array(
                'nStaAddOrEdit'   => 99
            );
            $this->load->view('supplier/supplierlev/wSupplierLevAdd',$aDataSupplierLevel);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage SupplierLevel Edits
    //Parameters : Ajax Call View Add
    //Creator : 09/10/2018 witsarut
    //Return : String View
    //Return Type : View
    public function FSvCSLVEditPage(){
        try{
            $tSlvCode       = $this->input->post('tSlvCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMSplLev_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            // }

            $aData  = array(
                'FTSlvCode' => $tSlvCode,
                'FNLngID'   => $nLangEdit
            );

            $aSlvData       = $this->mSupplierLev->FSaMSLVGetDataByID($aData);
            $aDataSupplierLevel   = array(
                'nStaAddOrEdit' => 1,
                'aSlvData'      => $aSlvData
            );
            $this->load->view('supplier/supplierlev/wSupplierLevAdd',$aDataSupplierLevel);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Add SupplierLevel
    //Parameters : Ajax Event
    //Creator : 09/10/2018 witsarut
    //Return : Status Add Event
    //Return Type : String
    public function FSoCSLVAddEvent(){
        
        try{
            date_default_timezone_set("Asia/Bangkok");
            $aDataSupplierLevel   = array(
                'tIsAutoGenCode' => $this->input->post('ocbSupplierlevAutoGenCode'),
                'FTSlvCode'     => $this->input->post('oetSlvCode'),
                'FTSlvName'     => $this->input->post('oetSlvName'),
                'FTSlvRmk'      => $this->input->post('otaSlvRmk'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );
 
            // Check Auto Gen Department Code? 15/05/2020 Saharat(Golf)
            if($aDataSupplierLevel['tIsAutoGenCode'] == '1'){ 
                $aStoreParam = array(
                    "tTblName"   => 'TCNMSplLev',                           
                    "tDocType"   => 0,                                          
                    "tBchCode"   => "",                                 
                    "tShpCode"   => "",                               
                    "tPosCode"   => "",                     
                    "dDocDate"   => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataSupplierLevel['FTSlvCode']   = $aAutogen[0]["FTXxhDocNo"];
            }
      
            $oCountDup      = $this->mSupplierLev->FSnMSLVCheckDuplicate($aDataSupplierLevel['FTSlvCode']);
            $nStaDup        = $oCountDup['counts'];


            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaSlvMaster  = $this->mSupplierLev->FSaMSLVAddUpdateMaster($aDataSupplierLevel);
                $aStaSlvLang    = $this->mSupplierLev->FSaMSLVAddUpdateLang($aDataSupplierLevel);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add SupplierLevel"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataSupplierLevel['FTSlvCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add SupplierLevel'
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

    //Functionality : Event Edit SupplierLevel
    //Parameters : Ajax Event
    //Creator : 09/10/2018 witsarut
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCSLVEditEvent(){
        try{
            $this->db->trans_begin();
            $aDataSupplierLevel   = array(
                'FTSlvCode'     => $this->input->post('oetSlvCode'),
                'FTSlvName'     => $this->input->post('oetSlvName'),
                'FTSlvRmk'      => $this->input->post('otaSlvRmk'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );
            $aStaSlvMaster  = $this->mSupplierLev->FSaMSLVAddUpdateMaster($aDataSupplierLevel);
            $aStaSlvLang    = $this->mSupplierLev->FSaMSLVAddUpdateLang($aDataSupplierLevel);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit SupplierLevel"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataSupplierLevel['FTSlvCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit SupplierLevel'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Delete SupplierLevel
    //Parameters : Ajax jReason()
    //Creator : 09/10/2018 witsarut
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCSLVDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTSlvCode' => $tIDCode
        );
        $aResDel    = $this->mSupplierLev->FSaMSLVDelAll($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }



}