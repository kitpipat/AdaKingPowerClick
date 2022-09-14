<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cSmartLockerAdjustStatus extends MX_Controller {
    
    public function __construct() {
        parent::__construct ();
        $this->load->model('company/branch/mBranch');
        $this->load->model('company/shop/mShop');
        $this->load->model('company/smart_locker_adjust_status/mSmartLockerAdjustStatus');
    }
    
    /**
     * Functionality : หน้าหลักของ การปรับสถานะช่องตู้ Locker
     * Parameters : -
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : view
     * Return Type : view
     */
    public function FSvCAdjustStatusMainPage() {
        
        $tRefCode = $this->input->post('tRefCode');
        $aRefCode = json_decode($tRefCode, true);
        
        $aBchCode = $aRefCode['tPSHBchCode'];
        $tShpCode = $aRefCode['tPSHShpCode'];
        
        $aOneBch = [];
        if(FCNnHSizeOf($aBchCode) == 1){ // ร้านค้ามีสาขาเดียว
            $aBchParams = [
                'nLngID' => FCNaHGetLangEdit(),
                'tBchCode' => $aBchCode[0]
            ];
            $aOneBch = $this->mSmartLockerAdjustStatus->FSnMSMLKAdjStaGetBchByCode($aBchParams); // ดึงข้อมูลสาขาที่มีชื่อสาขามาด้วย
        }
        
        $aGetRackParams = [
            'tBchCode' => "'" . implode("','", $aBchCode) . "'",
            'tShpCode' => $tShpCode
        ];
        $aRack = $this->mSmartLockerAdjustStatus->FSaMSMLKAdjStatusGetRack($aGetRackParams);
        
        $aViewData = [
            'aRefCode' => $aRefCode,
            'aOneBch' => $aOneBch,
            'aRack' => $aRack
        ];
        $this->load->view('company/smart_locker_adjust_status/wAdjustStatusMain', $aViewData);
        
    }
    
    /**
     * Functionality : แสดงรายการ ประวัติการปรับสถานะ
     * Parameters : -
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : view
     * Return Type : view
     */
    public function FSvCAdjustStatusDataTable() {
        
        $nPage = $this->input->post('nPageCurrent');
        $tBchCode = $this->input->post('tBchCode');
        $tShpCode = $this->input->post('tShpCode');
        $tPosCode = $this->input->post('tPosCode');
        $tRackCode = $this->input->post('tRackCode');
        $tDate = $this->input->post('tDate');
        
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        // Lang ภาษา
	$nLngID = FCNaHGetLangEdit();

        $aAdminHisParams = array(
            'nPage' => $nPage,
            'nRow' => 10,
            'nLngID' => $nLngID,
            'tBchCode' => $tBchCode,
            'tShpCode' => $tShpCode,
            'tPosCode' => $tPosCode,
            'tRackCode' => $tRackCode,
            'tDate' => $tDate
        );
        
        /*======================= Begin Data Process =====================*/
        
        $aAdminHisList = $this->mSmartLockerAdjustStatus->FSaMSMLKAdjStaAdminHisList($aAdminHisParams);

        /*========================= End Data Process =====================*/
        
        $aGenTable = array(
            'aDataList' => $aAdminHisList,
            'nPage' => $nPage
        );
        $this->load->view('company/smart_locker_adjust_status/wAdjustStatusDataTable', $aGenTable);
        
    }
    
    /**
     * Functionality : แสดงรายการ ช่องตู้ตาม  Rack
     * Parameters : -
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : view
     * Return Type : view
     */
    public function FSvCAdjustStatusRackChannelDataTable() {
        
        $nPage = $this->input->post('nPageCurrent');
        $tBchCode = $this->input->post('tBchCode');
        $tShpCode = $this->input->post('tShpCode');
        $tPosCode = $this->input->post('tPosCode');
        $tRackCode = $this->input->post('tRackCode');
        
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        // Lang ภาษา
	$nLngID = FCNaHGetLangEdit();

        $aRackChannelParams = array(
            'nPage' => $nPage,
            'nRow' => 200,
            'nLngID' => $nLngID,
            'tBchCode' => $tBchCode,
            'tShpCode' => $tShpCode,
            'tPosCode' => $tPosCode,
            'tRackCode' => $tRackCode,
            'tSessionID' => $this->session->userdata('tSesSessionID')
        );
        
        /*======================= Begin Data Process =====================*/

        $aAdminHisList = $this->mSmartLockerAdjustStatus->FSaMSMLKAdjStaRackChannelList($aRackChannelParams);

        /*========================= End Data Process =====================*/
        
        $aGenTable = array(
            'aDataList' => $aAdminHisList,
            'nPage' => $nPage
        );
        $this->load->view('company/smart_locker_adjust_status/rack/wAdjustStatusRackChannelDataTable', $aGenTable);
        
    }
    
    /**
     * Functionality : แสดงรายการ Temp
     * Parameters : -
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : view
     * Return Type : view
     */
    public function FSvCAdjustStatusTempDataTable() {
        
        $nPage = $this->input->post('nPageCurrent');
        $tBchCode = $this->input->post('tBchCode');
        $tShpCode = $this->input->post('tShpCode');
        $tRackCode = $this->input->post('tRackCode');
        $tIsView = $this->input->post('tIsView');
        
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        // Lang ภาษา
	$nLngID = FCNaHGetLangEdit();

        $aTempParams = array(
            'nPage' => $nPage,
            'nRow' => 200,
            'nLngID' => $nLngID,
            'tBchCode' => $tBchCode,
            'tShpCode' => $tShpCode,
            'tRackCode' => $tRackCode,
            'tTableKey' => 'TRTMShopLayout',
            'tSessionID' => $this->session->userdata('tSesSessionID')
        );
        
        /*======================= Begin Data Process =====================*/

        $aTempList = $this->mSmartLockerAdjustStatus->FSaMSMLKAdjStaTempList($aTempParams);

        /*========================= End Data Process =====================*/
        
        $aGenTable = array(
            'aDataList' => $aTempList,
            'nPage' => $nPage,
            'tIsView' => $tIsView
        );
        $this->load->view('company/smart_locker_adjust_status/temp/wAdjustStatusTempDataTable', $aGenTable);
        
    }
    
    /**
     * Functionality : นำรายการช่องตาม Rack ให้กับ Temp
     * Parameters : -
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : view
     * Return Type : view
     */
    public function FSvCAdjustStatusRackChannelToTemp() {
        
        $tPosCode = $this->input->post('tPosCode');
        $tLockerCode = $this->input->post('tLockerCode');
        $tBchCode = $this->input->post('tBchCode');
        $tShpCode = $this->input->post('tShpCode');
        $tRackCode = $this->input->post('tRackCode');
        $tRackItems = $this->input->post('tRackItems');
        $aRackItems = json_decode($tRackItems, true);
        $tAdjChannelStatus = $this->input->post('tAdjChannelStatus');
        
        // Lang ภาษา
	$nLngID = FCNaHGetLangEdit();
        
        $this->db->trans_begin();
        
        /*======================= Begin Data Process =====================*/
        
        foreach($aRackItems as $aItem) {
            $aRackChannelTempParams = array(
                'nLngID' => $nLngID,
                'tAdjChannelStatus' => $tAdjChannelStatus,
                'aData' => [
                    'FTMttTableKey' => 'TRTMShopLayout',
                    'FTBchCode' => $aItem['tBchCode'],
                    'FTMerCode' => $aItem['tMerCode'],
                    'FTShpCode' => $aItem['tShpCode'],
                    'FTPosCode' => $tPosCode,
                    'FTRakCode' => $tRackCode,
                    'FNLayNo' => $aItem['nLayNo'],
                    'FNLayRow' => $aItem['nLayRow'],
                    'FNLayCol' => $aItem['nLayCol'],
                    'FTLayStaUse' => $aItem['tLayStaUse'],
                    'FTMttSessionID' => $this->session->userdata('tSesSessionID'),
                    
                    'FDCreateOn' => date('Y-m-d H:i:s'),
                    'FTCreateBy' => $this->session->userdata('tSesUsername'),
                    'FDCreateOn' => date('Y-m-d H:i:s'),
                    'FTCreateBy' => $this->session->userdata('tSesUsername')
                ]
            );
            $this->mSmartLockerAdjustStatus->FSnMSMLKAdjStaRackChannelToTemp($aRackChannelTempParams);
        }

        /*========================= End Data Process =====================*/
        
        if($this->db->trans_status() === false){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess Add Rack Channel to Temp"
            );
        }else{
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'	=> '1',
                'tStaMessg'     => 'Success Add Rack Channel to Temp'
            );
        }
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aReturn));
    }
    
    /**
     * Functionality : ปรับปรุง สถานะการใช้ ใน Temp
     * Parameters : -
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : view
     * Return Type : view
     */
    public function FSaCAdjustStatusUpdateStaUseInTemp() {
        
        $tPosCode = $this->input->post('tPosCode');
        $tLockerCode = $this->input->post('tLockerCode');
        $tBchCode = $this->input->post('tBchCode');
        $tShpCode = $this->input->post('tShpCode');
        $tRackCode = $this->input->post('tRackCode');
        $tAdjChannelStatus = $this->input->post('tAdjChannelStatus');
        
        // Lang ภาษา
	$nLngID = FCNaHGetLangEdit();
        
        $aUpdateStaUseParams = [
            'tBchCode' => $tBchCode,
            'tShpCode' => $tShpCode,
            'tRackCode' => $tRackCode,
            'tTableKey' => 'TRTMShopLayout',
            'tSessionID' => $this->session->userdata('tSesSessionID'),
            'tAdjStaUse' => $tAdjChannelStatus
        ];
        
        $this->db->trans_begin();
        
        /*======================= Begin Data Process =====================*/
        
        $this->mSmartLockerAdjustStatus->FSaMSMLKAdjStaUpdateStaUseInTemp($aUpdateStaUseParams);

        /*========================= End Data Process =====================*/
        
        if($this->db->trans_status() === false){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess Update StaUse in Temp"
            );
        }else{
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'	=> '1',
                'tStaMessg'     => 'Success Update StaUse in Temp'
            );
        }
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aReturn));
    }
    
    /**
     * Functionality : ลบรายการช่องต่อแถวใน Temp
     * Parameters : -
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : view
     * Return Type : view
     */
    public function FSvCAdjustStatusDeleteRackChannelInTemp() {
        
        $tPosCode = $this->input->post('tPosCode');
        $tLockerCode = $this->input->post('tLockerCode');
        $tBchCode = $this->input->post('tBchCode');
        $tShpCode = $this->input->post('tShpCode');
        $tRackCode = $this->input->post('tRackCode');
        $nLayNo = $this->input->post('nLayNo');
        $nLayRow = $this->input->post('nLayRow');
        $nLayCol = $this->input->post('nLayCol');
        
        // Lang ภาษา
	$nLngID = FCNaHGetLangEdit();
        
        $this->db->trans_begin();
        
        /*======================= Begin Data Process =====================*/
        
        $aDelRackChannelTempParams = array(
            'nLngID' => $nLngID,
            'tTableKey' => 'TRTMShopLayout',
            'tBchCode' => $tBchCode,
            'tShpCode' => $tShpCode,
            'tPosCode' => $tPosCode,
            'tRackCode' => $tRackCode,
            'nLayNo' => $nLayNo,
            'nLayRow' => $nLayRow,
            'nLayCol' => $nLayCol,
            'tSessionID' => $this->session->userdata('tSesSessionID')
        );
        
        $this->mSmartLockerAdjustStatus->FSnMSMLKAdjStaDelRackChannelInTemp($aDelRackChannelTempParams);

        /*========================= End Data Process =====================*/
        
        if($this->db->trans_status() === false){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess Delete Rack Channel in Temp"
            );
        }else{
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'	=> '1',
                'tStaMessg'     => 'Success Delete Rack Channel in Temp'
            );
        }
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aReturn));
    }
    
    /**
     * Functionality : แสดงหน้าเพิ่มการปรับสถานะ
     * Parameters : -
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : view
     * Return Type : view
     */
    public function FSvCAdjustStatusPageAdd() {
        $aUserLogin = $this->session->userdata('tSesUsrInfo');
        $tRefCode = $this->input->post('tRefCode');
        $tLockerCode = $this->input->post('tLockerCode');
        $aRefCode = json_decode($tRefCode, true);
        
        $aBchCode = $aRefCode['tPSHBchCode'];
        $tShpCode = $aRefCode['tPSHShpCode'];
        
        $aClearRackChannelTempParams = array(
            'tTableKey' => 'TRTMShopLayout',
            'tSessionID' => $this->session->userdata('tSesSessionID')
        );
        $this->mSmartLockerAdjustStatus->FSnMSMLKAdjStaClearRackChannelInTemp($aClearRackChannelTempParams);
        
        $aOneBch = [];
        if(FCNnHSizeOf($aBchCode) == 1){ // ร้านค้ามีสาขาเดียว
            $aBchParams = [
                'nLngID' => FCNaHGetLangEdit(),
                'tBchCode' => $aBchCode[0]
            ];
            $aOneBch = $this->mSmartLockerAdjustStatus->FSnMSMLKAdjStaGetBchByCode($aBchParams); // ดึงข้อมูลสาขาที่มีชื่อสาขามาด้วย
        }
        
        $aGetRackParams = [
            'tBchCode' => "'" . implode("','", $aBchCode) . "'",
            'tShpCode' => $tShpCode
        ];
        $aRack = $this->mSmartLockerAdjustStatus->FSaMSMLKAdjStatusGetRack($aGetRackParams);
        
        $aViewData = [
            'aRefCode' => $aRefCode,
            'tLockerCode' => $tLockerCode,
            'aOneBch' => $aOneBch,
            'aRack' => $aRack,
            'aUserLogin' => $aUserLogin
        ];
        $this->load->view('company/smart_locker_adjust_status/wAdjustStatusAdd', $aViewData);
        
    }
    
    /**
     * Functionality : ทำรายการให้กับ TRTTAdminHis, TRTTLockerStatus (เพิ่มหรือปรับปรุงข้อมูล)
     * Parameters : -
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FSaCAdjustStatusAddEvent() {
        
        $tPosCode = $this->input->post('tPosCode');
        $tLockerCode = $this->input->post('tLockerCode');
        $tBchCode = $this->input->post('tBchCode');
        $tShpCode = $this->input->post('tShpCode');
        $tRackCode = $this->input->post('tRackCode');
        $tAdjChannelStatus = $this->input->post('tAdjChannelStatus');
        
        // Lang ภาษา
	$nLngID = FCNaHGetLangEdit();
        
        $aRackChannelParams = array(
            'nLngID' => $nLngID,
            'tTableKey' => 'TRTMShopLayout',
            'tBchCode' => $tBchCode,
            'tShpCode' => $tShpCode,
            'tPosCode' => $tPosCode,
            'tRackCode' => $tRackCode,
            'tAdjChannelStatus' => $tAdjChannelStatus,
            'tSessionID' => $this->session->userdata('tSesSessionID'),
            'dLastUpdOn' => date('Y-m-d H:i:s'),
            'dLastUpdBy' => $this->session->userdata('tSesUsername'),
            'dCreateOn' => date('Y-m-d H:i:s'),
            'dCreateBy' => $this->session->userdata('tSesUsername')
        );
        
        $aRackChannelInTemp = $this->mSmartLockerAdjustStatus->FSaMSMLKAdjStatusGetRackChannelInTemp($aRackChannelParams);
        
        $this->db->trans_begin();
        
        /*======================= Begin Data Process =====================*/
            if($aRackChannelInTemp['rtCode'] == '1') {
                
                foreach($aRackChannelInTemp['aItems'] as $nKey => $aItem){
                    $this->mSmartLockerAdjustStatus->FSaMCreditNoteInsertOrUpdateToLockerStatus($aItem, $aRackChannelParams);
                    $this->mSmartLockerAdjustStatus->FSaMCreditNoteInsertToAdminHis($aItem, $aRackChannelParams);
                }
                
            }
        /*========================= End Data Process =====================*/
        
        if($this->db->trans_status() === false){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess Add Rack Channel to Temp"
            );
        }else{
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'	=> '1',
                'tStaMessg'     => 'Success Add Rack Channel to Temp'
            );
        }
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aReturn));
    }
    
    /**
     * Functionality : แสดงหน้าเพื่อดูอย่างเดียว
     * Parameters : -
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : view
     * Return Type : view
     */
    public function FSvCAdjustStatusPageView() {
        
        $tBchCode = $this->input->post('tBchCode');
        $tBchName = $this->input->post('tBchName');
        $tShpCode = $this->input->post('tShpCode');
        $tPosCode = $this->input->post('tPosCode');
        $tRackCode = $this->input->post('tRackCode');
        $tRackName = $this->input->post('tRackName');
        $tHisDate = $this->input->post('tHisDate');
        $tHisUserCode = $this->input->post('tHisUserCode');
        $tHisUserName = $this->input->post('tHisUserName');
        $tHisStaUse = $this->input->post('tHisStaUse');
        
        // Lang ภาษา
	$nLngID = FCNaHGetLangEdit();
        
        $this->db->trans_begin();
        
        /*======================= Begin Data Process =====================*/
        
        $aClearRackChannelTempParams = array(
            'tTableKey' => 'TRTMShopLayout',
            'tSessionID' => $this->session->userdata('tSesSessionID')
        );
        $this->mSmartLockerAdjustStatus->FSnMSMLKAdjStaClearRackChannelInTemp($aClearRackChannelTempParams);
        
        $aAdminHisToTempParams = [
            'nLngID' => $nLngID,
            'tTableKey' => 'TRTMShopLayout',
            'tBchCode' => $tBchCode,
            'tShpCode' => $tShpCode,
            'tPosCode' => $tPosCode,
            'tRackCode' => $tRackCode,
            'tHisDate' => $tHisDate,
            'tSessionID' => $this->session->userdata('tSesSessionID')
        ];
        
        $this->mSmartLockerAdjustStatus->FSnMSMLKAdjStaAdminHisToTemp($aAdminHisToTempParams);
        
        /*======================= End Data Process =====================*/
        
        if($this->db->trans_status() === false){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess Clear Temp"
            );
        }else{
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'	=> '1',
                'tStaMessg'     => 'Success Clear Temp'
            );
        }
        
        $aViewData = [
            'tBchCode' => $tBchCode,
            'tBchName' => $tBchName,
            'tPosCode' => $tPosCode,
            'tRackCode' => $tRackCode,
            'tRackName' => $tRackName,
            'tHisDate' => $tHisDate,
            'tHisUserCode' => $tHisUserCode,
            'tHisUserName' => $tHisUserName,
            'tHisStaUse' => $tHisStaUse
            
        ];
        $this->load->view('company/smart_locker_adjust_status/wAdjustStatusView', $aViewData);
    }
    
    /**
     * Functionality : Clear Temp
     * Parameters : -
     * Creator : 10/07/2019 Piya
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FSaCAdjustStatusClearTemp() {
        
        $aClearTempParams = array(
            'tTableKey' => 'TRTMShopLayout',
            'tSessionID' => $this->session->userdata('tSesSessionID')
        );
        
        $this->db->trans_begin();
        
        /*======================= Begin Data Process =====================*/
        
        $this->mSmartLockerAdjustStatus->FSnMSMLKAdjStaClearRackChannelInTemp($aClearTempParams);
        
        /*======================= End Data Process =====================*/
        
        if($this->db->trans_status() === false){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess Clear Temp"
            );
        }else{
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'	=> '1',
                'tStaMessg'     => 'Success Clear Temp'
            );
        }
        
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aReturn));
    }
    
}















