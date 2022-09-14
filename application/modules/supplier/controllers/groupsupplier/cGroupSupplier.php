<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cGroupSupplier extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('supplier/groupsupplier/mGroupSupplier');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nSgpBrowseType,$tSgpBrowseOption){
        $nMsgResp   = array('title'=>"GroupSupplier");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('groupsupplier/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('supplier/groupsupplier/wGroupSupplier', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nSgpBrowseType'    => $nSgpBrowseType,
            'tSgpBrowseOption'  => $tSgpBrowseOption
        ));
    }

    //Functionality : Function Call GroupSupplier Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 17/10/2018 witsarut
    //Return : String View
    //Return Type : View
    public function FSvCSGPListPage(){
        $this->load->view('supplier/groupsupplier/wGroupSupplierList');
    }

    //Functionality : Function Call DataTables GroupSupplier
    //Parameters : Ajax Call View DataTable
    //Creator : 17/10/2018 witsarut
    //Return : String View
    //Return Type : View
    public function FSvCSGPDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMSplGrp_L');
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
            $aSgpDataList   = $this->mGroupSupplier->FSaMSGPList($aData);
            $aGenTable  = array(
                'aSgpDataList'  => $aSgpDataList,
                'nPage'         => $nPage,
                'tSearchAll'    => $tSearchAll
            );
            $this->load->view('supplier/groupsupplier/wGroupSupplierDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage GroupSupplier Add
    //Parameters : Ajax Call View Add
    //Creator : 17/10/2018 witsarut
    //Return : String View
    //Return Type : View
    public function FSvCSGPAddPage(){
        try{
            $aDataSupplierLevel = array(
                'nStaAddOrEdit'   => 99
            );
            $this->load->view('supplier/groupsupplier/wGroupSupplierAdd',$aDataSupplierLevel);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage GroupSupplier Edits
    //Parameters : Ajax Call View Add
    //Creator : 17/10/2018 witsarut
    //Return : String View
    //Return Type : View
    public function FSvCSGPEditPage(){
        try{
            $tSgpCode       = $this->input->post('tSgpCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMSplGrp_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            // }

            $aData  = array(
                'FTSgpCode' => $tSgpCode,
                'FNLngID'   => $nLangEdit
            );

            $aSgpData       = $this->mGroupSupplier->FSaMSGPGetDataByID($aData);
            $aDataSupplierLevel   = array(
                'nStaAddOrEdit' => 1,
                'aSgpData'      => $aSgpData
            );
            $this->load->view('supplier/groupsupplier/wGroupSupplierAdd',$aDataSupplierLevel);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Add GroupSupplier
    //Parameters : Ajax Event
    //Creator : 17/10/2018 witsarut
    //Return : Status Add Event
    //Return Type : String
    public function FSoCSGPAddEvent(){
        try{
            $aDataSupplierLevel   = array(
                'tIsAutoGenCode' => $this->input->post('ocbGroupSupplierAutoGenCode'),
                'FTSgpCode'      => $this->input->post('oetSgpCode'),
                'FTSgpName'      => $this->input->post('oetSgpName'),
                'FTSgpRmk'       => $this->input->post('otaSgpRmk'),
                'FDLastUpdOn'    => date('Y-m-d H:i:s'),
                'FDCreateOn'     => date('Y-m-d H:i:s'),
                'FTLastUpdBy'    => $this->session->userdata('tSesUsername'),
                'FTCreateBy'     => $this->session->userdata('tSesUsername'),
                'FNLngID'        => $this->session->userdata("tLangEdit")
            );

            // Check Auto Gen GroupSupplier Code?  15/05/2020 Saharat(Golf)
            if($aDataSupplierLevel['tIsAutoGenCode'] == '1'){ 
                $aStoreParam = array(
                    "tTblName"   => 'TCNMSplGrp',                           
                    "tDocType"   => 0,                                          
                    "tBchCode"   => "",                                 
                    "tShpCode"   => "",                               
                    "tPosCode"   => "",                     
                    "dDocDate"   => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataSupplierLevel['FTSgpCode']   = $aAutogen[0]["FTXxhDocNo"];
            }
          
            $oCountDup      = $this->mGroupSupplier->FSnMSGPCheckDuplicate($aDataSupplierLevel['FTSgpCode']);
            $nStaDup        = $oCountDup['counts'];
            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaSgpMaster  = $this->mGroupSupplier->FSaMSGPAddUpdateMaster($aDataSupplierLevel);
                $aStaSgpLang    = $this->mGroupSupplier->FSaMSGPAddUpdateLang($aDataSupplierLevel);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add GroupSupplier"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataSupplierLevel['FTSgpCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add GroupSupplier'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => "Data Code Duplicate",
                    'Gencode'      => $aGenCode
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Edit GroupSupplier
    //Parameters : Ajax Event
    //Creator : 17/10/2018 witsarut
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCSGPEditEvent(){
        try{
            $this->db->trans_begin();
            $aDataSupplierLevel   = array(
                'FTSgpCode'     => $this->input->post('oetSgpCode'),
                'FTSgpName'     => $this->input->post('oetSgpName'),
                'FTSgpRmk'      => $this->input->post('otaSgpRmk'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );
            $aStaSgpMaster  = $this->mGroupSupplier->FSaMSGPAddUpdateMaster($aDataSupplierLevel);
            $aStaSgpLang    = $this->mGroupSupplier->FSaMSGPAddUpdateLang($aDataSupplierLevel);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit GroupSupplier"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataSupplierLevel['FTSgpCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit GroupSupplier'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Delete GroupSupplier
    //Parameters : Ajax jReason()
    //Creator : 17/10/2018 witsarut
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCSGPDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTSgpCode' => $tIDCode
        );
        $aResDel    = $this->mGroupSupplier->FSaMSGPDelAll($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

}