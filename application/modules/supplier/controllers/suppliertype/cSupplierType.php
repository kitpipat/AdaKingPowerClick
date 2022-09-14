<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cSupplierType extends MX_Controller {
    public function __construct(){
        parent::__construct ();
        $this->load->model('supplier/suppliertype/mSupplierType');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nStyBrowseType,$tStyBrowseOption){
        $nMsgResp   = array('title'=>"SupplierType");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('suppliertype/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('supplier/suppliertype/wSupplierType', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nStyBrowseType'    => $nStyBrowseType,
            'tStyBrowseOption'  => $tStyBrowseOption
        ));
    }

    //Functionality : Function Call SupplierType Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 04/10/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCSTYListPage(){ 
        $this->load->view('supplier/suppliertype/wSupplierTypeList');
    }

    
    //Functionality : Function Call DataTables SupplierType
    //Parameters : Ajax Call View DataTable
    //Creator : 04/10/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCSTYDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMSplType_L');
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
            $aStyDataList   = $this->mSupplierType->FSaMSTYList($aData); 
            $aGenTable  = array(
                'aStyDataList'  => $aStyDataList,
                'nPage'         => $nPage,
                'tSearchAll'    => $tSearchAll
            );
            $this->load->view('supplier/suppliertype/wSupplierTypeDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage SupplierType
    //Parameters : Ajax Call View Add
    //Creator : 04/10/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCSTYAddPage(){
        try{
            $aDataSupplierType = array(
                'nStaAddOrEdit'   => 99
            );
            $this->load->view('supplier/suppliertype/wSupplierTypeAdd',$aDataSupplierType);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage SupplierType Edits
    //Parameters : Ajax Call View Add
    //Creator : 04/10/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCSTYEditPage(){
        try{
            $tStyCode       = $this->input->post('tStyCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMSplType_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            // }

            $aData  = array(
                'FTStyCode' => $tStyCode,
                'FNLngID'   => $nLangEdit
            );
                                                
            $aStyData       = $this->mSupplierType->FSaMSTYGetDataByID($aData);
            $aDataSupplierType   = array(
                'nStaAddOrEdit' => 1,
                'aStyData'      => $aStyData
            );
            $this->load->view('supplier/suppliertype/wSupplierTypeAdd',$aDataSupplierType);
        }catch(Exception $Error){
            echo $Error;
        }
    }


     //Functionality : Event Add SupplierType
    //Parameters : Ajax Event
    //Creator : 04/10/2018 Witsarut (Bell)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCSTYAddEvent(){ 
        try{
            date_default_timezone_set("Asia/Bangkok");
            $aDataSupplierType   = array(
                'tIsAutoGenCode' => $this->input->post('ocbSupplierTypeAutoGenCode'),
                'FTStyCode'      => $this->input->post('oetStyCode'),
                'FTStyName'      => $this->input->post('oetStyName'),
                'FTStyRmk'       => $this->input->post('otaStyRmk'),
                'FDCreateOn'     => date('Y-m-d H:i:s'),
                'FDLastUpdOn'    => date('Y-m-d H:i:s'),
                'FTCreateBy'     => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'        => $this->session->userdata("tLangEdit")
            );

            // Check Auto Gen Department Code? 15/05/2020 Saharat(Golf)
            if($aDataSupplierType['tIsAutoGenCode'] == '1'){ 
                $aStoreParam = array(
                    "tTblName"   => 'TCNMSplType',                           
                    "tDocType"   => 0,                                          
                    "tBchCode"   => "",                                 
                    "tShpCode"   => "",                               
                    "tPosCode"   => "",                     
                    "dDocDate"   => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataSupplierType['FTStyCode']   = $aAutogen[0]["FTXxhDocNo"];
            }

            $oCountDup      = $this->mSupplierType->FSnMSTYCheckDuplicate($aDataSupplierType['FTStyCode']);
            $nStaDup        = $oCountDup['counts'];

            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaStyMaster  = $this->mSupplierType->FSaMSTYAddUpdateMaster($aDataSupplierType);
                $aStaStyLang    = $this->mSupplierType->FSaMSTYAddUpdateLang($aDataSupplierType);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add SupplierType"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataSupplierType['FTStyCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add SupplierType'
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


    //Functionality : Event Edit SupplierType
    //Parameters : Ajax Event
    //Creator : 04/10/2018 Witsarut(Bell)
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCSTYEditEvent(){ 
        try{
            $this->db->trans_begin();
            date_default_timezone_set("Asia/Bangkok");
            $aDataSupplierType   = array(
                'FTStyCode'   => $this->input->post('oetStyCode'),
                'FTStyName'   => $this->input->post('oetStyName'),
                'FTStyRmk'    => $this->input->post('otaStyRmk'),
                'FDCreateOn'  => date('Y-m-d H:i:s'),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTCreateBy'  => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FNLngID'     => $this->session->userdata("tLangEdit")
            );
            $aStaStyMaster  = $this->mSupplierType->FSaMSTYAddUpdateMaster($aDataSupplierType);
            $aStaStyLang    = $this->mSupplierType->FSaMSTYAddUpdateLang($aDataSupplierType);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit SupplierType"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataSupplierType['FTStyCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit SupplierType'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Delete SupplierType
    //Parameters : Ajax jReason()
    //Creator : 04/10/2018 Witsarut(Bell)
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCSTYDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTStyCode' => $tIDCode
        );
        $aResDel    = $this->mSupplierType->FSaMSTYDelAll($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

}