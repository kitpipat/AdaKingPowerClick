<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cFuncSetting extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('setting/func_setting/mFuncSetting');
    }
    
    public function index($nBrowseType, $tBrowseOption){

        $aData['nBrowseType'] = $nBrowseType;
        $aData['tBrowseOption'] = $tBrowseOption;
        $aData['aAlwEvent'] = FCNaHCheckAlwFunc('functionSetting/0/0'); // Controle Event
        $aData['vBtnSave'] = FCNaHBtnSaveActiveHTML('functionSetting/0/0'); // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        // Get Option Show Decimal
        $aData['nOptDecimalShow'] = FCNxHGetOptionDecimalShow(); 
        $aData['nOptDecimalSave'] = FCNxHGetOptionDecimalSave(); 

        $this->load->view('setting/func_setting/wFuncSetting', $aData);

    }
    
    /**
     * Functionality : ค้นหา รายการ หน้าแรก
     * Parameters : Ajax Input
     * Creator : 04/09/2019 Piya
     * Return : -
     * Return Type : -
     */
    public function FSxCFuncSettingSearchList(){
        
        $aGetSystemAppAllParams = [
            'FNLngID' => FCNaHGetLangEdit()
        ];
        $aSystemApp = $this->mFuncSetting->FSaMFuncSettingGetSystemAppAll($aGetSystemAppAllParams);
        // Controle Event
        $aAlwEvent = FCNaHCheckAlwFunc('funcSetting/0/0'); 
        $aViewParams = [
            'aSystemApp' => $aSystemApp,
            'aAlwEvent' => $aAlwEvent
        ];
        $this->load->view('setting/func_setting/wFuncSettingSearchList', $aViewParams);
    }
    
    /**
     * Functionality : หน้าแก้ไข
     * Parameters : Ajax Input
     * Creator : 04/09/2019 Piya
     * Return : -
     * Return Type : -
     */
    public function FSxCFuncSettingEditPage(){
        
        $aGetSystemAppAllParams = [
            'FNLngID' => FCNaHGetLangEdit()
        ];
        $aSystemApp = $this->mFuncSetting->FSaMFuncSettingGetSystemAppAll($aGetSystemAppAllParams);
        
        $aViewParams = [
            'aSystemApp' => $aSystemApp
        ];
        $this->load->view('setting/func_setting/wFuncSettingEdit', $aViewParams);
    }
    
    /**
     * Functionality : Call DataTable List HD
     * Parameters : Ajax Input
     * Creator : 04/09/2019 Piya
     * Return : Status Delete Event
     * Return Type : 
     */
    public function FSxCFuncSettingGetDataTableInHD(){

        $tGhdApp = $this->input->post('tGhdApp');
        $nGdtFuncLevel = $this->input->post('nGdtFuncLevel');
        $tGdtStaUse = $this->input->post('tGdtStaUse');
        
        $nPage = $this->input->post('nPageCurrent');

        // Controle Event
        $aAlwEvent = FCNaHCheckAlwFunc('funcSetting/0/0'); 
    
        if($nPage == '' || $nPage == null){
            $nPage = 1;
        }else{
            $nPage = $this->input->post('nPageCurrent');
        }
        
        $aGetDataParams  = array(
            'FNLngID' => FCNaHGetLangEdit(),
            'nPage' => $nPage,
            'nRow' => 20,
            'tGhdApp' => $tGhdApp,
            'nGdtFuncLevel' => $nGdtFuncLevel,
            'tGdtStaUse' => $tGdtStaUse
        );
        $aResList = $this->mFuncSetting->FSaMFuncSetingGetDataHD($aGetDataParams);
        
        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage
        );
        $this->load->view('setting/func_setting/table/wFuncSettingDataTableHD', $aGenTable);
    }
    
    /**
     * Functionality : Insert FuncDT to Temp
     * Parameters : Ajax Input
     * Creator : 04/09/2019 Piya
     * Return : 
     * Return Type : 
     */
    public function FSxCFuncSettingInsertDTToTemp(){
        
        $tGhdApp = $this->input->post('tGhdApp');
        
        $this->db->trans_begin();
        
        /*===== Begin Insert FuncDT to Temp ==================================*/
        $aInsertDTToTempParams  = array(
            'FNLngID' => FCNaHGetLangEdit(),
            'tGhdApp' => $tGhdApp,
            'tMttTableKey' => 'TPSMFuncHD',
            'tMttRefKey' => 'TPSMFuncDT',
            'tUserSessionID' => $this->session->userdata('tSesSessionID')
        );
        $this->mFuncSetting->FSaMFuncSettingInsertDTToTemp($aInsertDTToTempParams);
        /*===== End Insert FuncDT to Temp ====================================*/
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess process"
            );
        }else{
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'	    => '1',
                'tStaMessg'		=> 'Success process'
            );
        }
        
    }
    
    /**
     * Functionality : Call DataTable List Temp
     * Parameters : Ajax Input
     * Creator : 04/09/2019 Piya
     * Return : 
     * Return Type : 
     */
    public function FSxCFuncSettingGetDataTableInTemp(){
        
        $tGhdApp = $this->input->post('tGhdApp');
        $nPage = $this->input->post('nPageCurrent');

        // Controle Event
        $aAlwEvent = FCNaHCheckAlwFunc('funcSetting/0/0'); 
        
        if($nPage == '' || $nPage == null){
            $nPage = 1;
        }else{
            $nPage = $this->input->post('nPageCurrent');
        }
        
        $aGetDataParams  = array(
            'FNLngID' => FCNaHGetLangEdit(),
            'nPage' => $nPage,
            'nRow' => 20,
            'tMttTableKey' => 'TPSMFuncHD',
            'tMttRefKey' => 'TPSMFuncDT',
            'tUserSessionID' => $this->session->userdata('tSesSessionID')
        );
        $aResList = $this->mFuncSetting->FSaMFuncSetingGetDataInTemp($aGetDataParams);
        
        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage
        );
        $this->load->view('setting/func_setting/table/wFuncSettingDataTableTemp', $aGenTable);
    }
    
    /**
     * Functionality : Save Temp to FuncDT
     * Parameters : Ajax Input
     * Creator : 04/09/2019 Piya
     * Return : Status Save Event
     * Return Type : 
     */
    public function FSxCFuncSettingSaveEvent(){
        
        $tGhdApp = $this->input->post('tGhdApp');
        $tUserLoginCode = $this->session->userdata('tSesUsername');
        $tUserSessionID = $this->session->userdata('tSesSessionID');

        $this->db->trans_begin();
        
        /*===== Begin Store DB ===============================================*/
        $aUpdateTmpToDTParams = [
            'tGhdApp' => $tGhdApp,
            'tMttTableKey' => 'TPSMFuncHD',
            'tMttRefKey' => 'TPSMFuncDT',
            'tUserSessionID' => $tUserSessionID
        ];
        $this->mFuncSetting->FSaMFuncSettingUpdateTmpToDT($aUpdateTmpToDTParams);

        $aUpdateFuncInHDParams = [
            'tGhdApp' => $tGhdApp,
            'tMttTableKey' => 'TPSMFuncHD',
            'tMttRefKey' => 'TPSMFuncDT',
            'tUserSessionID' => $tUserSessionID,
            'tUserLoginCode' => $tUserLoginCode
        ];
        $this->mFuncSetting->FSaMFuncSettingUpdateFuncInHD($aUpdateFuncInHDParams);
        /*===== End Store DB =================================================*/
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess process"
            );
        }else{
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'	    => '1',
                'tStaMessg'		=> 'Success process'
            );
        }
        
    }
    
    /**
     * Functionality : Update FuncDT in Temp
     * Parameters : Ajax Input
     * Creator : 04/09/2019 Piya
     * Return : Status Update Event
     * Return Type : 
     */
    public function FSxCFuncSettingUpdateFuncInTmp(){
        
        $tGhdApp = $this->input->post('tGhdApp');
        $tGhdCode = $this->input->post('tGhdCode');
        $tSysCode = $this->input->post('tSysCode');
        $nGdtFuncLevel = $this->input->post('nGdtFuncLevel');
        $tGdtStaUse = $this->input->post('tGdtStaUse');
        $tGdtCallByName = $this->input->post('tGdtCallByName');
        
        $this->db->trans_begin();

        $aUpdateFuncInTempParams = [
            'tGhdApp' => $tGhdApp,
            // 'nGdtFuncLevel' => $nGdtFuncLevel,
            'tGhdCode' => $tGhdCode,
            'tSysCode' => $tSysCode,
            'tGdtStaUse' => $tGdtStaUse,
            'tGdtCallByName' => $tGdtCallByName,
            'tMttTableKey' => 'TPSMFuncHD',
            'tMttRefKey' => 'TPSMFuncDT',
            'tUserSessionID' => $this->session->userdata('tSesSessionID')
        ];
        $this->mFuncSetting->FSaMFuncSettingUpdateFuncInTmp($aUpdateFuncInTempParams);

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
        }
    }

    /**
     * Functionality : Update FuncDT All in Temp
     * Parameters : Ajax Input
     * Creator : 04/09/2019 Piya
     * Return : Status Update Event
     * Return Type : 
     */
    public function FSxCFuncSettingUpdateFuncAllInTmp(){
        
        $aFuncUsedItem = $this->input->post('aFuncUsedItem');

        if(isset($aFuncUsedItem) && !empty($aFuncUsedItem)){
            $this->db->trans_begin();

            foreach($aFuncUsedItem as $item){
                $aUpdateFuncInTempParams = [
                    'tGhdApp' => $item["tGhdApp"],
                    'tGhdCode' => $item["tGhdCode"],
                    'tSysCode' => $item["tSysCode"],
                    // 'nGdtFuncLevel' => $item["nGdtFuncLevel"],
                    'tGdtStaUse' => $item["tGdtStaUse"],
                    'tGdtCallByName' => $item["tGdtCallByName"],
                    'tMttTableKey' => 'TPSMFuncHD',
                    'tMttRefKey' => 'TPSMFuncDT',
                    'tUserSessionID' => $this->session->userdata('tSesSessionID')
                ];
                $this->mFuncSetting->FSaMFuncSettingUpdateFuncInTmp($aUpdateFuncInTempParams);
            }

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
            }else{
                $this->db->trans_commit();
            }
        }
    }
}
