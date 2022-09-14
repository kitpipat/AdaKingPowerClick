<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class CcabinetType extends MX_Controller {
    public function __construct(){
        parent::__construct ();
        $this->load->model('vending/cabinettype/mCabinettype');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nCBNBrowseType,$tCBNBrowseOption){
        $nMsgResp   = array('title'=>"Cabinet Type");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }

        $vBtnSave   = FCNaHBtnSaveActiveHTML('CabinetType/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventCabinetType	    = FCNaHCheckAlwFunc('CabinetType/0/0');

        $this->load->view('vending/cabinettype/wCabinetType', array(
            'nMsgResp'              => $nMsgResp,
            'vBtnSave'              => $vBtnSave,
            'nCBNBrowseType'        => $nCBNBrowseType,
            'tCBNBrowseOption'      => $tCBNBrowseOption,
            'aAlwEventCabinetType'  => $aAlwEventCabinetType
        ));
    }    

    //Functionality : Function Call cabinetType Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 05/10/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCCBNListPage(){

       $aAlwEventCabinetType =  FCNaHCheckAlwFunc('CabinetType/0/0');
       $aNewData     = array(
            'aAlwEventCabinetType' => $aAlwEventCabinetType
       );
       $this->load->view('vending/cabinettype/wCabinetTypeList',$aNewData);
    }

    /**
     * Functionality : Call DataTables cabinetType
     * Parameters : Ajax Call View DataTable
     * Creator : 05/10/2018 Witsarut (Bell)
     * Last Modified : 26/02//2019 Witsarut
     * Return : view
     * Return Type : view
     */
    public function FSvCCBNDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = $this->input->post('nPageCurrent');
            
            if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage  = $this->input->post('nPageCurrent');}
            if(!$tSearchAll){$tSearchAll='';}

            //Lang ภาษา
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            
            $aAlwEventCabinetType   = FCNaHCheckAlwFunc('CabinetType/0/0'); //Controle Event

            $aData = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll
            );

            $aCBNDataList     =   $this->mCabinettype->FSaMCBNList($aData);

            $aGenTable  = array(
                'aCBNDataList'          => $aCBNDataList,
                'nPage'                 => $nPage,
                'tSearchAll'            => $tSearchAll,
                'aAlwEventCabinetType'  => $aAlwEventCabinetType
            );
           
            $this->load->view('vending/cabinettype/wCabinetTypeDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage CabinetType  Add
    //Parameters : Ajax Call View Add
    //Creator : 05/10/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCCBNAddPage(){
        try{
            $aDataCabinetType = array(
                'nStaAddOrEdit'   => 99
            );
            $this->load->view('vending/cabinettype/wCabinetTypeAdd',$aDataCabinetType);

        }catch(Exception $Error){
            echo $Error;
        }
    }

     //Functionality : Function CallPage CardType Edits
    //Parameters : Ajax Call View Add
    //Creator : 05/10/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCCBNEditPage(){
        try{
            $tCBNCode       = $this->input->post('tCBNCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TVDMShopType_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);

            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }

            $aData  = array(
                'FTShtCode' => $tCBNCode,
                'FNLngID'   => $nLangEdit
            );

            $aCBNData       = $this->mCabinettype->FSaMCBNGetDataByID($aData);
            
            $aDataCabinetType   = array(
                'nStaAddOrEdit' => 1,
                'aCBNData'      => $aCBNData
            );

            $this->load->view('vending/cabinettype/wCabinetTypeAdd',$aDataCabinetType);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Add CabinetType
    //Parameters : Ajax Event
    //Creator : 05/10/2018 Witsarut (Bell)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCCBNAddEvent(){
        try{
            $tIsAutoGenCode = $this->input->post('ocbCabinetTypeAutoGenCode');

            $tShtCode  = "";
            if(isset($tIsAutoGenCode) && $tIsAutoGenCode == '1'){
                $aStoreParam = array(
                    "tTblName"    => 'TVDMShopType',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $tShtCode   = $aAutogen[0]["FTXxhDocNo"];

                // $aGenCode = FCNaHGenCodeV5('TVDMShopType','0'); 
                // if($aGenCode['rtCode'] == '1'){
                //     $tShtCode = $aGenCode['rtShtCode'];
                // }
            }else{
                    $tShtCode = $this->input->post('oetCBNCode');
            }

            $aDataCabinetType = array(
                'FTShtCode'      => $tShtCode,
                'FTShtName'     => $this->input->post('oetCBNName'),
                'FTShtType'     => $this->input->post('ocmSelectSrcType'),
                'FNShtValue'    => $this->input->post('oetCBNTempAgg'),    
                'FNShtMin'      => $this->input->post('oetCBNTempMin'),
                'FNShtMax'      => $this->input->post('oetCBNTempMax'),
                'FTShtRemark'   => $this->input->post('oetCBNRemark'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );

            $oCountDup      = $this->mCabinettype->FSnMCBNCheckDuplicate($aDataCabinetType['FTShtCode']);
            $nStaDup        = $oCountDup['counts'];
            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaCBNMaster  = $this->mCabinettype->FSaMCBNAddUpdateMaster($aDataCabinetType);
                $aStaCBNLang    = $this->mCabinettype->FSaMCBNAddUpdateLang($aDataCabinetType);
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
                        'tCodeReturn'	=> $aDataCabinetType['FTShtCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Cabinet Type'
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


    //Functionality : Event Edit CAbinetType
    //Parameters : Ajax Event
    //Creator : 05/10/2018 Witsarut(Bell)
    //Return : Status Edit Event
    //Return Type : String
    public function  FSoCCBNEditEvent(){
        try{
            $this->db->trans_begin();
            $aDataCabinetType = array(
                'FTShtCode'     => $this->input->post('oetCBNCode'),
                'FTShtName'     => $this->input->post('oetCBNName'),
                'FTShtType'     => $this->input->post('ocmSelectSrcType'),
                'FNShtValue'    => $this->input->post('oetCBNTempAgg'),    
                'FNShtMin'      => $this->input->post('oetCBNTempMin'),
                'FNShtMax'      => $this->input->post('oetCBNTempMax'),
                'FTShtRemark'   => $this->input->post('oetCBNRemark'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );

            $aStaCBNMaster  = $this->mCabinettype->FSaMCBNAddUpdateMaster($aDataCabinetType);
            $aStaCBNLang    = $this->mCabinettype->FSaMCBNAddUpdateLang($aDataCabinetType);
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
                    'tCodeReturn'	=> $aDataCabinetType['FTShtCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit CardType'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Delete Userlogin
    //Parameters : Ajax jReason()
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCCBNDeleteEvent(){
       try{
            $tShtID    = $this->input->post('tIDCode');
            $aDataDel = array(
                'FTShtCode' => $tShtID
            );

            $aResDel     = $this->mCabinettype->FSnMCBNDel($aDataDel);
            $nNumRowRsnLoc  = $this->mCabinettype->FSnMLOCGetAllNumRow();

            if($nNumRowRsnLoc){
                $aReturn    = array(
                    'nStaEvent' => $aResDel['rtCode'],
                    'tStaMessg' => $aResDel['rtDesc'],
                    'nNumRowRsnLoc' => $nNumRowRsnLoc
                );
                echo json_encode($aReturn);
            }else{
                echo "database error";
            }
       }catch(Exception $Error){
           echo $Error;
       }
    }

    //Functionality : Delete Userlogin Ads Multiple
    //Parameters : Ajax jUserlogin()
    //Creator : 20/08/2019 Witsarut
    //Return : array Data Return Status Delete
    //Return Type : array
    public function FSoCCBNDelMultipleEvent(){
        try{
            $this->db->trans_begin();

            $aDataDelete    = array(
                'FTShtCode'  => $this->input->post('tIDCode'),
            );

            $tResult    = $this->mCabinettype->FSaMCBNDeleteMultiple($aDataDelete);

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $aDataReturn    = array(
                    'nStaEvent' => 500,
                    'tStaMessg' => 'Error Not Delete Data Pos Ads Multiple'
                );
            }else{
                $this->db->trans_commit();
                $aDataReturn     = array(
                    'nStaEvent' => 1,
                    'tStaMessg' => 'Success Delete Pos Ads Multiple'
                );
            }
        }catch(Exception $Error){
            $aDataReturn     = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error
            );
        }
        echo json_encode($aDataReturn);
    }

}