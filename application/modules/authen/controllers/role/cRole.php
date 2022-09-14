<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cRole extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('authen/role/mRole');
        $this->load->model('authen/user/mUser');
        $this->load->model('authen/login/mLogin');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nRoleBrowseType, $tRoleBrowseOption)
    {
        /** ========================================== Option การตั้งค่าหน้าจอ ==========================================
         * nRoleBrowseType      : สถานะการเข้าถึงข้อมูล 0 => จากการกดเมนูซ้ายมือ 1 => จากการกดเพิ่มที่ Modal Browse ข้อมูล
         * tRoleBrowseOption    : ชื่อออฟชั่นก่อนหน้าในการเข้าถึงข้อมูลจาก Modal เกี่ยวข้องกับ Modal Center
         * aAlwEvent            : อเรย์ข้อมูล Allow Authen => Full,Add,Edit,Delete,Appove,Reprint,Cancel
         * vBtnSave             : ออฟชั่นปุ่ม Save
         * nOptDecimalShow      : Degit ที่แสดงข้อมูลทศนิยมในกรณีดูข้อมูล
         * nOptDecimalSave      : Degit ที่แสดงข้อมูลทศนิยมในกรณีเซฟ
         * ==========================================================================================================
         */
        $aDataConfigView    = [
            'nRoleBrowseType'   => $nRoleBrowseType,
            'tRoleBrowseOption' => $tRoleBrowseOption,
            'aAlwEvent'         => FCNaHCheckAlwFunc('role/0/0'),
            'vBtnSave'          => FCNaHBtnSaveActiveHTML('role/0/0'),
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave()
        ];
        $this->load->view('authen/role/wRole', $aDataConfigView);
    }

    // Functionality : Call Page From Search List
    // Parameters : Ajax and Function Parameter
    // Creator : 17/06/2019 wasin (Yoshi AKA: Mr.JW)
    // LastUpdate: 13/08/2019 Wasin(Yoshi)
    // Return : 
    // Return Type : View
    public function FStCCallPageRoleList(){
        $aDataConfigView    = ['aAlwEvent' => FCNaHCheckAlwFunc('role/0/0')];
        $this->load->view('authen/role/wRoleList', $aDataConfigView);
    }

    // Functionality : Call DataTables Role List
    // Parameters : Ajax Function Call Page
    // Creator : 22/06/2018 wasin
    // LastUpdate: 13/08/2019 Wasin(Yoshi)
    // Return : object Data Table
    // Return Type : object
    public function FSoCCallPageRoleDataTable(){
        try {
            $tSearchAll     = $this->input->post('ptSearchAll');
            $nPage          = ($this->input->post('pnPageCurrent') == '' || null) ? 1 : $this->input->post('pnPageCurrent');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aDataWhere = array(
                'nPage'                 => $nPage,
                'nRow'                  => 10,
                'FNLngID'               => $nLangEdit,
                'tSearchAll'            => $tSearchAll,
                'tSesUsrRoleCodeMulti'  => $this->session->userdata('tSesUsrRoleCodeMulti'),//tSesUsrRoleCodeMulti //tSesUsrRoleSpcCodeMulti
                'tSesUsrCode'           => $this->session->userdata("tSesUserCode")
            );
            $aDataRoleList  = $this->mRole->FSaMGetDataRoleList($aDataWhere);
            $aAlwEvent      = FCNaHCheckAlwFunc('role/0/0');
            $aConfigView    = array(
                'nPage'     => $nPage,
                'aAlwEvent' => $aAlwEvent,
                'aDataList' => $aDataRoleList
            );
            $tRoleViewDataTableList   = $this->load->view('authen/role/wRoleDataTable', $aConfigView, true);
            $aReturnData = array(
                'tRoleViewDataTableList'    => $tRoleViewDataTableList,
                'nStaEvent' => 1,
                'tStaMessg' => 'Success'
            );
        } catch (ErrorException $Error) {
            $aReturnData = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Call Page Add Role
    // Parameters : Ajax Function Call Page
    // Creator : 22/06/2018 wasin
    // LastUpdate: 27/08/2019 Wasin(Yoshi)
    // Return : object Data Table
    // Return Type : object
    public function FSoCCallPageRoleAdd(){
        try {
            $nLangEdit = $this->session->userdata("tLangEdit");
            $tSesUsrRoleCodeMulti = $this->session->userdata('tSesUsrRoleCodeMulti');
            $aParams = array(
                'FNLngID' => $nLangEdit,
                'FTRolCode' => '',
                'tSesUsrRoleCodeMulti' => $tSesUsrRoleCodeMulti
            );
            $aDataMenuList          = $this->mRole->FSaMRoleMenuList($aParams);
            $aDataMenuRptList       = $this->mRole->FSaMRptListMenu($aParams);
            $aDataFuncSettingList   = $this->mRole->FSaMGetFuncSettingList($aParams);
            $aDataNotiSettingList   = $this->mRole->FSaMGetNotiSettingList($aParams);
            $aDataConfigViewForm = array(
                'nStaCallView'          => 1, // 1 = Call View Add , 2 = Call View Edits
                'aDataMenuList'         => $aDataMenuList,
                'aDataMenuReport'       => $aDataMenuRptList,
                'aDataFuncSettingList'  => $aDataFuncSettingList,
                'aDataNotiSettingList'  => $aDataNotiSettingList,
                'tSesAgnCode'           => $this->session->userdata("tSesUsrAgnCode"),
                'tSesAgnName'           => $this->session->userdata("tSesUsrAgnName"),
            );
            $tRoleViewPageForm = $this->load->view('authen/role/wRoleAdd', $aDataConfigViewForm, true);
            $aReturnData = array(
                'tRoleViewPageAdd'  => $tRoleViewPageForm,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //Functionality : page edit - success
    //Parameters : 
    //Creator : 28/06/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSoCCallPageRoleEdit(){
        try {
            $tRolCode       = $this->input->post('tRolCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMUsrRole_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if ($nLangHave > 1) {
                if ($nLangEdit != '') {
                    $nLangEdit = $nLangEdit;
                } else {
                    $nLangEdit = $nLangResort;
                }
            } else {
                if (@$aLangHave[0]->nLangList == '') {
                    $nLangEdit = '1';
                } else {
                    $nLangEdit = $aLangHave[0]->nLangList;
                }
            }
            $tSesUsrRoleCodeMulti = $this->session->userdata('tSesUsrRoleCodeMulti');
            $aParams  = array(
                'FNLngID'               => $nLangEdit,
                'FTRolCode'             => $tRolCode,
                'tSesUsrRoleCodeMulti'  => $tSesUsrRoleCodeMulti
            );
            // Get Data User Role
            $aDataUsrRole = $this->mRole->FSaMRoleGetDataMaster($aParams);

            // ***************************************************************************************
            // Create By Witsarut 190620
            //GetData UsrRoleSpc
            $aDataUsrRoleSpc    = $this->mRole->FSaMUsrRoleSpcGetDataMaster($aParams);
            @$aDataRoleCode     = $aDataUsrRoleSpc['raItems']['FTRolCode'];
            @$aDataAgnCode      = $aDataUsrRoleSpc['raItems']['FTAgnCode'];
            @$aDataBchCode      = $aDataUsrRoleSpc['raItems']['FTBchCode'];
            // นับจำนวนของ Branch ถ้า Branch ที่อยู่ภายใต้ ตัวแทนขาย นับมากกว่า 1 ให้หน้า Edit Browse Branch ไม่ต้องโชว์
            // แต่ ถ้านับแล้วมีแค่ 1 ให้ เอา Browse Branch มาโชว
            $aDataCountRoleCode = $this->mRole->FSaMRoleCountNRolCodeFromUsrSpc($aDataAgnCode, $aDataBchCode, $aDataRoleCode);
            $aGetDataBranch     = $this->mRole->FSaMRoleGetBchFromAgnCode($aDataAgnCode);

            // ***************************************************************************************
            if (isset($aDataUsrRole['rtRoleImgObj']) && !empty($aDataUsrRole['rtRoleImgObj'])) {
                $tImgObj        = $aDataUsrRole['rtRoleImgObj'];
                $aImgObjPath    = explode("application/modules/", $tImgObj);
                $aImgObjName    = explode("/", $tImgObj);
                $tImgObjPath    = end($aImgObjPath);
                $tImgObjName    = end($aImgObjName);
            } else {
                $tImgObjPath    = "";
                $tImgObjName    = "";
            }

            // Get Data Report Menu
            $aDataMenuList          = $this->mRole->FSaMRoleMenuList($aParams);
            $aDataMenuReport        = $this->mRole->FSaMRptListMenu($aParams);
            $aDataFuncSettingList   = $this->mRole->FSaMGetFuncSettingList($aParams);
            $aDataNotiSettingList   = $this->mRole->FSaMGetNotiSettingList($aParams);
            $aDataConfigViewForm    = array(
                'nStaCallView' => 2, // 1 = Call View Add , 2 = Call View Edits
                'aDataMenuList' => $aDataMenuList,
                'aDataMenuReport' => $aDataMenuReport,
                'aDataFuncSettingList' => $aDataFuncSettingList,
                'aDataNotiSettingList' => $aDataNotiSettingList,
                'aDataUsrRole' => $aDataUsrRole,
                'tImgObjPath' => $tImgObjPath,
                'tImgObjName' => $tImgObjName,
                'aDataUsrRoleSpc' => $aDataUsrRoleSpc,
                'aDataCountRoleCode' => $aDataCountRoleCode,
            );
            $tRoleViewPageForm      = $this->load->view('authen/role/wRoleAdd', $aDataConfigViewForm, true);
            // Get Data Report Menu Edit
            $aDataRoleMenuEdit      = $this->mRole->FSaMGetDataRoleMenuEdit($aParams);
            $aDataRoleMenuRptEdit   = $this->mRole->FSaMGetDataRoleMenuRptEdit($aParams);
            $aReturnData = array(
                'nStaEvent'             => '1',
                'tStaMessg'             => 'Success',
                'tRoleViewPageEdit'     => $tRoleViewPageForm,
                'aDataRoleMenuEdit'     => $aDataRoleMenuEdit,
                'aDataRoleMenuRptEdit'  => $aDataRoleMenuRptEdit,
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //Functionality : Add Event Role - Success
    //Parameters : Ajax Route Parameter
    //Creator : 29/06/2019 Saharat(Golf)
    //Last Modified : -
    //Return : Status CallBack Add Event
    //Return Type : object
    public function FSoRoleAddEvent(){
        try {
            $this->db->trans_begin();

            // Master Add/Update Table (TCNMUsrRole,TCNMUsrRole_L)
            $aDataMaster = array(
                'tIsAutoGenCode' => $this->input->post('ptRoleAutoGenCode'),
                'FTRolCode'     => $this->input->post('ptRoleCode'),
                'FNRolLevel'    => $this->input->post('ptRoleLevel'),
                'FTRolName'     => $this->input->post('ptRoleName'),
                'FTRolRmk'      => $this->input->post('ptRoleRemark'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );

            if ($aDataMaster['tIsAutoGenCode'] == '1') {
                $aStoreParam = array(
                    "tTblName"   => 'TCNMUsrRole',                           
                    "tDocType"   => 0,                                          
                    "tBchCode"   => "",                                 
                    "tShpCode"   => "",                               
                    "tPosCode"   => "",                     
                    "dDocDate"   => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTRolCode']  = $aAutogen[0]["FTXxhDocNo"];
            }


            //simput Imge
            $tImageUplodeOld    = trim($this->input->post('ptImageOld'));
            $tImageUplode       = trim($this->input->post('ptImageNew'));

            // ******************************************************************************************************************************************

            $tSpcAgnCode        = $this->input->post('ptSpcAgnCode');
            $tSpcBchCode        = $this->input->post('ptSpcBchCode');


            // Insert  Table TCNMUsrRoleSpc
            $aDataMasterRoleSpc = array(
                'FTRolCode'         => $aDataMaster['FTRolCode'],
                'FTAgnCode'         => (empty($tSpcAgnCode) ? '' : $tSpcAgnCode),
                'FTBchCode'         => (empty($tSpcBchCode) ? '' : $tSpcBchCode),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'tSpcAgncyCodeOld'  => $this->input->post('ptSpcAgncyCodeOld'),
                'tSpcBranchCodeOld' => $this->input->post('ptSpcBranchCodeOld'),
            );

            if( !empty($tSpcAgnCode) || !empty($tSpcBchCode) ){
                $this->mRole->FSxMRoleAddUpdateUsrRoleSpc($tSpcBchCode , $aDataMasterRoleSpc);
            }

            // ********************************************************************************************************************************

            $this->mRole->FSxMRoleAddUpdateUsrRole($aDataMaster);

            $this->mRole->FSxMRoleAddUpdateUsrRoleLang($aDataMaster);
            
            $this->mRole->FSxMRoleAddUpdateUsrRoleChain($aDataMaster); // Create By Napat(Jame) 07/01/2021

            $aRoleMnuData       = $this->input->post('paRoleMnuData');
            $aRoleRptMnuData    = $this->input->post('paRoleRptData');

            // Add Data User Menu
            $this->mRole->FSxMRoleAddUpdateUsrMenu($aDataMaster, $aRoleMnuData, $aRoleRptMnuData);

            // Add Data Report Menu
            $this->mRole->FSxMRoleAddUpdateUsrRptMenu($aDataMaster, $aRoleRptMnuData);

            /*===== Begin Add Data FuncSetting =========================================*/
            $aRoleFuncSettingData = $this->input->post('paRoleFuncSetting');
            $aRoleFuncSettingNotCheckedData = $this->input->post('paRoleFuncSettingNotChecked');

            if (!empty($aRoleFuncSettingData)) {
                foreach ($aRoleFuncSettingData as $aRoleFuncSettingItem) {
                    $aAddRoleFuncSettingParams = [
                        "tRoleCode" => $aDataMaster['FTRolCode'],
                        "tGhdApp" => $aRoleFuncSettingItem["tGhdApp"],
                        "tGhdCode" => $aRoleFuncSettingItem["tGhdCode"],
                        "tSysCode" => $aRoleFuncSettingItem["tSysCode"],
                        "tUfrStaAlw" => "1",
                        "tUserLoginCode" => $this->session->userdata('tSesUsername')
                    ];
                    $this->mRole->FSxMAddRoleFuncSetting($aAddRoleFuncSettingParams);
                }

                if (!empty($aRoleFuncSettingNotCheckedData)) {
                    foreach ($aRoleFuncSettingNotCheckedData as $aRoleFuncSettingItem) {
                        $aAddRoleFuncNotCheckSettingParams = [
                            "tRoleCode" => $this->input->post('ptRoleCode'),
                            "tGhdApp" => $aRoleFuncSettingItem["tGhdApp"],
                            "tGhdCode" => $aRoleFuncSettingItem["tGhdCode"],
                            "tSysCode" => $aRoleFuncSettingItem["tSysCode"],
                            "tUfrStaAlw" => "0",
                            "tUserLoginCode" => $this->session->userdata('tSesUsername')
                        ];
                        $this->mRole->FSxMAddRoleFuncSetting($aAddRoleFuncNotCheckSettingParams);
                    }
                }
            }else{
                $aClearUsrFuncSettingParams = [
                    "tRoleCode" => $aDataMaster['FTRolCode'],
                ];
                $this->mRole->FSxClearRoleFuncSetting($aClearUsrFuncSettingParams);
            }

            /*===== Begin Add Data NotiSetting =========================================*/
            $aRoleNotiSettingData = $this->input->post('paRoleNotiSetting');
            $this->mRole->FSxMAddRoleNotiSetting($aDataMaster,$aRoleNotiSettingData);
                
            
            /*===== End Add Data FuncSetting ===========================================*/
            // Set session on Add Data
            //26-10-2020 nale เพิ่มเก็บสิทใน session เพื่อแสดงในหน้าจอสิทหลังบันทึก
            if($this->session->userdata('nSesUsrBchCount')!=0){
                $tSesUsrRoleCodeMultiSpc 	= "";
                $aDataWhereChain            = array(
                    'tUsrRoleMulti'	=> $this->session->userdata("tSesUsrRoleCodeMulti"),
                    'tLoginLevel' 	=> $this->session->userdata("tSesUsrLoginLevel"),
                    'tAgnCode'		=> $this->session->userdata("tSesUsrAgnCode"),
                    'tBchCodeMulti'	=> $this->session->userdata("tSesUsrBchCodeMulti")
                );
                $aDataUsrRoleChain  		= $this->mLogin->FSaMLOGGetUserRoleChain($aDataWhereChain);
                if( $aDataUsrRoleChain['tCode'] == '1' ){
                    $tSesUsrRoleCodeMultiSpc = $this->mLogin->FStMLOGMakeArrayToString($aDataUsrRoleChain['aItems'],'FTRolCode','value');
                }
                $this->session->set_userdata("tSesUsrRoleSpcCodeMulti", $tSesUsrRoleCodeMultiSpc);
            }
            // Check Trancetion Event Menu
            if ($this->db->trans_status() !== FALSE) {
                $this->db->trans_commit();
                $aDataUpload = array(
                    'tModuleName'    => 'authen',
                    'tImgFolder'     => 'role',
                    'tImgRefID'      => $aDataMaster['FTRolCode'],
                    'tImgObj'        => $tImageUplode,
                    'tImgTable'      => 'TCNMUsrRole',
                    'tTableInsert'   => 'TCNMImgObj',
                    'tImgKey'        => 'main',
                    'dDateTimeOn'    => date('Y-m-d H:i:s'),
                    'tWhoBy'         => $this->session->userdata('tSesUsername')
                );
                $aImgReturn = FCNnHAddImgObj($aDataUpload);
                $aReturnData = array(
                    'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTRolCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Update'
                );
            } else {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent'    => '500',
                    'tStaMessg'    => "Error Not Add/Update Data Role."
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => $Error['nCodeReturn'],
                'tStaMessg' => $Error['tTextStaMessg']
            );
        }
        echo json_encode($aReturnData);
    }

    //Functionality : Edit Event Role 
    //Parameters : Ajax Route Parameter
    //Creator : 29/06/2019 Saharat(Golf)
    //Last Modified : -
    //Return : Status CallBack Add Event
    //Return Type : object
    public function FSoRoleEditEvent()
    {
        try {
            $this->db->trans_begin();
            //imput Imge
            $tImageUplodeOld = trim($this->input->post('ptImageOld'));
            $tImageUplode = trim($this->input->post('ptImageNew'));
            // Master Add/Update Table (TCNMUsrRole,TCNMUsrRole_L)
            $aDataMaster = array(
                'FTRolCode'     => $this->input->post('ptRoleCode'),
                'FNRolLevel'    => $this->input->post('ptRoleLevel'),
                'FTRolName'     => $this->input->post('ptRoleName'),
                'FTRolRmk'      => $this->input->post('ptRoleRemark'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );
            // ********************************************************************************************************************************
            $tSpcAgnCode    =  $this->input->post('ptSpcAgnCode');
            $tSpcBchCode    =  $this->input->post('ptSpcBchCode');
            $tRoleCode      =  $this->input->post('ptRoleCode');

            // Insert  Table TCNMUsrRoleSpc
            $aDataMasterRoleSpc = array(
                'FTRolCode'         => $tRoleCode,
                'FTAgnCode'         => (empty($tSpcAgnCode) ? '' : $tSpcAgnCode),
                'FTBchCode'         => (empty($tSpcBchCode) ? '' : $tSpcBchCode),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'tSpcAgncyCodeOld'  => $this->input->post('ptSpcAgncyCodeOld'),
                'tSpcBranchCodeOld' => $this->input->post('ptSpcBranchCodeOld'),
            );

            //Del RoleCode Table TCNMUsrRoleSpc
            $this->mRole->FSaMDelRoleCode($tRoleCode);
            if( !empty($tSpcAgnCode) || !empty($tSpcBchCode) ){
                $this->mRole->FSxMRoleAddUpdateUsrRoleSpc($tSpcBchCode , $aDataMasterRoleSpc);
            }

            // ********************************************************************************************************************************
            $this->mRole->FSxMRoleAddUpdateUsrRole($aDataMaster);
            $this->mRole->FSxMRoleAddUpdateUsrRoleLang($aDataMaster);

            $aRoleMnuData       = $this->input->post('paRoleMnuData');
            $aRoleRptMnuData    = $this->input->post('paRoleRptData');

            // Add Data User Menu
            $this->mRole->FSxMRoleAddUpdateUsrMenu($aDataMaster, $aRoleMnuData, $aRoleRptMnuData);

            // Add Data Report Menu
            $this->mRole->FSxMRoleAddUpdateUsrRptMenu($aDataMaster, $aRoleRptMnuData);

            /*===== Begin Add Data FuncSetting =========================================*/
            $aRoleFuncSettingData = $this->input->post('paRoleFuncSetting');
            $aRoleFuncSettingNotCheckedData = $this->input->post('paRoleFuncSettingNotChecked');

            if (!empty($aRoleFuncSettingData)) {
                $aClearUsrFuncSettingParams = [
                    "tRoleCode" => $this->input->post('ptRoleCode')
                ];
                $this->mRole->FSxClearRoleFuncSetting($aClearUsrFuncSettingParams);

                foreach ($aRoleFuncSettingData as $aRoleFuncSettingItem) {
                    $aAddRoleFuncSettingParams = [
                        "tRoleCode" => $this->input->post('ptRoleCode'),
                        "tGhdApp" => $aRoleFuncSettingItem["tGhdApp"],
                        "tGhdCode" => $aRoleFuncSettingItem["tGhdCode"],
                        "tSysCode" => $aRoleFuncSettingItem["tSysCode"],
                        "tUfrStaAlw" => "1",
                        "tUserLoginCode" => $this->session->userdata('tSesUsername')
                    ];
                    $this->mRole->FSxMAddRoleFuncSetting($aAddRoleFuncSettingParams);
                }

                if (!empty($aRoleFuncSettingNotCheckedData)) {
                    foreach ($aRoleFuncSettingNotCheckedData as $aRoleFuncSettingItem) {
                        $aAddRoleFuncNotCheckSettingParams = [
                            "tRoleCode" => $this->input->post('ptRoleCode'),
                            "tGhdApp" => $aRoleFuncSettingItem["tGhdApp"],
                            "tGhdCode" => $aRoleFuncSettingItem["tGhdCode"],
                            "tSysCode" => $aRoleFuncSettingItem["tSysCode"],
                            "tUfrStaAlw" => "0",
                            "tUserLoginCode" => $this->session->userdata('tSesUsername')
                        ];
                        $this->mRole->FSxMAddRoleFuncSetting($aAddRoleFuncNotCheckSettingParams);
                    }
                }

            }else{
                $aClearUsrFuncSettingParams = [
                    "tRoleCode" => $this->input->post('ptRoleCode')
                ];
                $this->mRole->FSxClearRoleFuncSetting($aClearUsrFuncSettingParams);
            }
            /*===== End Add Data FuncSetting ===========================================*/


            /*===== Begin Add Data NotiSetting =========================================*/
            $aRoleNotiSettingData = $this->input->post('paRoleNotiSetting');
            $this->mRole->FSxMAddRoleNotiSetting($aDataMaster,$aRoleNotiSettingData);

            // Check Trancetion Event Menu
            if ($this->db->trans_status() !== FALSE) {
                $this->db->trans_commit();
                // Set สิทธิในการมองเห็นร้านค้า
                FCNbLoadConfigIsShpEnabled();
                // Set สิทธิในการมองเห็นตัวแทนขาย
                FCNbLoadConfigIsAgnEnabled();
                $aDataUpload = array(
                    'tModuleName'     => 'authen',
                    'tImgFolder'      => 'role',
                    'tImgRefID'       => $this->input->post('ptRoleCode'),
                    'tImgObj'         => $tImageUplode,
                    'tImgTable'       => 'TCNMUsrRole',
                    'tTableInsert'    => 'TCNMImgObj',
                    'tImgKey'         => 'main',
                    'dDateTimeOn'     => date('Y-m-d H:i:s'),
                    'tWhoBy'          => $this->session->userdata('tSesUsername')
                );
                $aImgReturn = FCNnHAddImgObj($aDataUpload);
                $aReturnData = array(
                    'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTRolCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Update'
                );
            } else {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent'    => '500',
                    'tStaMessg'    => "Error Not Add/Update Data Role."
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => $Error['nCodeReturn'],
                'tStaMessg' => $Error['tTextStaMessg']
            );
        }
        echo json_encode($aReturnData);
    }

    //Functionality : Function Event Delete Rol
    //Parameters : Route Parameter
    //Creator : 04/07/2018 wasin
    //Last Modified : -
    //Return : Status Delete Role
    //Return Type : object
    public function FSoRoleDeleteEvent()
    {
        try {
            $tDeleteIDCode  = $this->input->post('ptDeleteIDCode');
            $aDataMaster    = array(
                'FTRolCode' => $tDeleteIDCode
            );
            $aStaDelRole    = $this->mRole->FSaMRoleDeleteData($aDataMaster);
            if ($aStaDelRole['rtCode'] == '1') {
                $nNumRowRolLoc  = $this->mRole->FSnMCountDataRole();
                $aReturnData    = array(
                    'nStaEvent'     => $aStaDelRole['rtCode'],
                    'tStaMessg'     => $aStaDelRole['rtDesc'],
                    'nNumRowRolLoc' => $nNumRowRolLoc
                );
            } else {
                throw new Exception(array(
                    'tCodeReturn'   => $aStaDelRole['rtCode'],
                    'tTextStaMessg' => $aStaDelRole['rtDesc'],
                ));
            }
        } catch (Exception $Error) {
            $aReturnData    = array(
                'nStaEvent' => $Error['tCodeReturn'],
                'tStaMessg' => $Error['tTextStaMessg']
            );
        }
        echo json_encode($aReturnData);
    }


    // ===============================================  ExportData  ============================================= ExportData ===========================
        
    // function export data ต้องเป็นขา Edit ถึงมีค่า
    // create By Witsarut 27-10-202
    public function FSxRoleExport(){
        $paPackData = array(
            'tRoleCode'     => $this->input->post('tRoleCode'),
            'tRolName'      => $this->input->post('tRolName'),
            'tRoleLev'      => $this->input->post('tRoleLev'),
            'tAgnCode'      => $this->input->post('tAgnCode'),
            'tSpcBchCode'   => $this->input->post('tSpcBchCode'),
        );

        // เอาข้อมูล จากตารางที่เกี่ยวข้อง มาทำการ exportหรือ ส่งออก
        // TCNMUsrRole/L เอา UsrRole ไป where 
        // TCNTUsrMenu  * สิทธิ์การใช้งานเมนู ระบบ
        // TCNTUsrFuncRpt  * สิทธิ์การใช้งานเมนู Report *
        // TPSMFuncHD  *สิทธิ์การใช้งานฟังก์ชั่น*

        //GetData TCNTUsrMenu
        $aPackDataUsrMenu       = $this->mRole->FSaMROlExportDetailUsrMenu($paPackData);

        //Get Data TCNTUsrFuncRpt
        $aPackDataMenuReport    = $this->mRole->FSaMROlExportDetailRptMenu($paPackData);

        //Get Data TPSMFuncHD
        $aPackDataFuncSetting   = $this->mRole->FSaMROlExportDetailFuncSetting($paPackData);

        //GetData AgnCode
        $aPackDataUsrRoleSpc    = $this->mRole->FSaMROlExportDetailUsrRoleSpc($paPackData);


        $aItemUsrMenu      = $aPackDataUsrMenu['raItems'];
        $aItemRptMenu      = $aPackDataMenuReport['raItems'];
        $aItemFuncSetting  = $aPackDataFuncSetting['raItems'];
        $aItemUsrRoleSpc   = $aPackDataUsrRoleSpc['raItems'];

    
        $aWriteData      = array();
        $nKeyIndexImport = 0;
        $nCntModCode     = 999;
        
        $aDataArray = array(
            'tTable'  => 'TCNTUsrMenu',
            'tItem'    => array(),
        );    

        for($i=0; $i<FCNnHSizeOf($aItemUsrMenu); $i++){
                $aParam = [
                    'tTable'            => 'TCNTUsrMenu',
                    'FTRolCode'         => $aItemUsrMenu[$i]['FTRolCode'],
                    'FTGmnModCode'      => $aItemUsrMenu[$i]['FTGmnModCode'],
                    'FTGmnModName'      => $aItemUsrMenu[$i]['FTGmnModName'],
                    'FNGmnModShwSeq'    => $aItemUsrMenu[$i]['FNGmnModShwSeq'],
                    'FTGmnCode'         => $aItemUsrMenu[$i]['FTGmnCode'],
                    'FTGmnName'         => $aItemUsrMenu[$i]['FTGmnName'],
                    'FNGmnShwSeq'       => $aItemUsrMenu[$i]['FNGmnShwSeq'],
                    'FTMnuCode'         => $aItemUsrMenu[$i]['FTMnuCode'],
                    'FTMnuName'         => $aItemUsrMenu[$i]['FTMnuName'],
                    'FNMnuSeq'          => $aItemUsrMenu[$i]['FNMnuSeq'],
                    'FNMnuLevel'        => $aItemUsrMenu[$i]['FNMnuLevel'],
                    'FTAutStaRead'      => $aItemUsrMenu[$i]['FTAutStaRead'],
                    'FTAutStaAdd'       => $aItemUsrMenu[$i]['FTAutStaAdd'],
                    'FTAutStaDelete'    => $aItemUsrMenu[$i]['FTAutStaDelete'],
                    'FTAutStaEdit'      => $aItemUsrMenu[$i]['FTAutStaEdit'],
                    'FTAutStaCancel'    => $aItemUsrMenu[$i]['FTAutStaCancel'],
                    'FTAutStaAppv'      => $aItemUsrMenu[$i]['FTAutStaAppv'],
                    'FTAutStaPrint'     => $aItemUsrMenu[$i]['FTAutStaPrint'],
                    'FTAutStaPrintMore' => $aItemUsrMenu[$i]['FTAutStaPrintMore']
                ];

            array_push($aDataArray['tItem'], $aParam);
        }


        $aDataArrayRpt = array(
            'tTable'  => 'TCNTUsrFuncRpt',
            'tItem'    => array(),
        );    

        for($j=0; $j<FCNnHSizeOf($aItemRptMenu); $j++){
            $aParam = [
                'tTable'            => 'TCNTUsrFuncRpt',
                'FTGrpRptModCode'   => $aItemRptMenu[$j]['FTGrpRptModCode'],
                'FNGrpRptModShwSeq' => $aItemRptMenu[$j]['FNGrpRptModShwSeq'],
                'FNGrpRptShwSeq'    => $aItemRptMenu[$j]['FNGrpRptShwSeq'],
                'FNGrpRptModName'   => $aItemRptMenu[$j]['FNGrpRptModName'],
                'FTGrpRptCode'      => $aItemRptMenu[$j]['FTGrpRptCode'],
                'FTGrpRptName'      => $aItemRptMenu[$j]['FTGrpRptName'],
                'FTRptCode'         => $aItemRptMenu[$j]['FTRptCode'],
                'FTRptName'         => $aItemRptMenu[$j]['FTRptName']
            ];

            array_push($aDataArrayRpt['tItem'], $aParam);
        }

        $aDataArrayfuncHD = array(
            'tTable'  => 'TPSMFuncHD',
            'tItem'    => array(),
        );    

        for($k=0; $k<FCNnHSizeOf($aItemFuncSetting); $k++){
            $aParam   = [
                'tTable'            => 'TPSMFuncHD',
                'FTGhdApp'          => $aItemFuncSetting[$k]['FTGhdApp'],
                'FTKbdScreen'       => $aItemFuncSetting[$k]['FTKbdScreen'],
                'FTAppName'         => $aItemFuncSetting[$k]['FTAppName'],
                'FTGdtName'         => $aItemFuncSetting[$k]['FTGdtName'],
                'FTGhdCode'         => $aItemFuncSetting[$k]['FTGhdCode'],
                'FTSysCode'         => $aItemFuncSetting[$k]['FTSysCode'],
                'FTGdtCallByName'   => $aItemFuncSetting[$k]['FTGdtCallByName'],
                'FNGdtFuncLevel'    => $aItemFuncSetting[$k]['FNGdtFuncLevel'],
                'FTGdtStaUse'       => $aItemFuncSetting[$k]['FTGdtStaUse'],
                'FTUfrStaAlw'       => $aItemFuncSetting[$k]['FTUfrStaAlw']
            ];

            array_push($aDataArrayfuncHD['tItem'], $aParam);
        }

        $aDataArrayUsrSpc = array(
            'tTable'  => 'TCNMUsrRoleSpc',
            'tItem'    => array(),
        ); 

        for($n=0; $n<FCNnHSizeOf($aItemUsrRoleSpc); $n++){
            $aParam   = [
                'tTable'        => 'TCNMUsrRoleSpc',
                'FTRolCode'     => $aItemUsrRoleSpc[$n]['FTRolCode'],
                'FTAgnCode'     => '',
                // 'FTAgnCode'     => $aItemUsrRoleSpc[$n]['FTAgnCode'],
                'FTBchCode'     => $aItemUsrRoleSpc[$n]['FTBchCode'],
                'FTAgnName'     => $aItemUsrRoleSpc[$n]['FTAgnName'],
                'FTBchName'     => $aItemUsrRoleSpc[$n]['FTBchName']
            ];

            array_push($aDataArrayUsrSpc['tItem'], $aParam);
        }


        array_push($aWriteData,$aDataArray,$aDataArrayRpt,$aDataArrayfuncHD,$aDataArrayUsrSpc);

        $aResultWrite   = json_encode($aWriteData, JSON_PRETTY_PRINT);
        $tFileName      = "ExportRole".$this->session->userdata('tSesUsername').date('His');
        $tPATH          = APPPATH . "modules/authen/views/role/Export//".$tFileName.".json";

        $handle         = fopen($tPATH, 'w+');

        if($handle){
            if(!fwrite($handle, $aResultWrite))  die("couldn't write to file."); 
        }

        //ส่งชื่อไฟล์ออกไป
        $aReturn = array(
            'tStatusReturn' => '1',
            'tFilename'     => $tFileName
        );
        echo json_encode($aReturn);
    }


    //Function InsertData Role
    //Create By Witsarut 30-10-2020
    function FSxRoleInsertData(){
        $tDataJSon = $this->input->post('aData');
        // Master Add/Update Table (TCNMUsrRole,TCNMUsrRole_L)
        $aDataMaster = array(
            'tIsAutoGenCode'    => $this->input->post('tRoleAutoGenCode'),
            'FTRolCode'         => $this->input->post('tRoleCode'),
            'FNRolLevel'        => $this->input->post('tRolRev'),
            'FTRolName'         => $this->input->post('tRolName'),
            'FTRolRmk'          => $this->input->post('tRemark'),
            'FDLastUpdOn'       => date('Y-m-d H:i:s'),
            'FDCreateOn'        => date('Y-m-d H:i:s'),
            'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
            'FTCreateBy'        => $this->session->userdata('tSesUsername'),
            'FNLngID'           => $this->session->userdata("tLangEdit")
        );

        if ($aDataMaster['tIsAutoGenCode'] == '1') {
            $aStoreParam = array(
                "tTblName"   => 'TCNMUsrRole',                           
                "tDocType"   => 0,                                          
                "tBchCode"   => "",                                 
                "tShpCode"   => "",                               
                "tPosCode"   => "",                     
                "dDocDate"   => date("Y-m-d")       
            );
            $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
            $aDataMaster['FTRolCode']  =  $aAutogen[0]["FTXxhDocNo"];
        }

        $aDataSpc = array(
            'FTRolCode'     => $aDataMaster['FTRolCode'],
            'FTAgnCode'     => $this->input->post('tRoleSpcAgnCode'),
            'FTBchCode'     => $this->input->post('tRoleSpcBchCode'),
            'FDLastUpdOn'   => date('Y-m-d H:i:s'),
            'FDCreateOn'    => date('Y-m-d H:i:s'),
            'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
            'FTCreateBy'    => $this->session->userdata('tSesUsername'),
        );

        $this->mRole->FSxMRoleAddUpdateUsrRole($aDataMaster);
        $this->mRole->FSxMRoleAddUpdateUsrRoleLang($aDataMaster);

        if( !empty($aDataSpc['FTAgnCode']) || !empty($aDataSpc['FTBchCode']) ){
            $this->mRole->FSxMRoleAddUpdateUsrRoleSpc($aDataSpc['FTBchCode'],$aDataSpc); // Last Update : Napat(Jame) 11/01/2021 ดึง spc จาก form
        }

        // Call Fucntion Jame RoelChan 11-1-2021
        $this->mRole->FSxMRoleAddUpdateUsrRoleChain($aDataMaster);

        //Insert ตาราง TCNTUsrMenu
        if(!empty($tDataJSon[0]['tItem'])){
            foreach($tDataJSon[0]['tItem'] AS $key=>$aValue){
                $aDataInsUseMenu = array(
                    'FTRolCode'         => $aDataMaster['FTRolCode'],
                    'FTGmnModCode'      => $aValue['FTGmnModCode'],
                    'FTGmnModName'      => $aValue['FTGmnModName'],
                    'FNGmnModShwSeq'    => $aValue['FNGmnModShwSeq'], 
                    'FTGmnCode'         => $aValue['FTGmnCode'],
                    'FTGmnName'         => $aValue['FTGmnName'],
                    'FNGmnShwSeq'       => $aValue['FNGmnShwSeq'],
                    'FTMnuCode'         => $aValue['FTMnuCode'],
                    'FTMnuName'         => $aValue['FTMnuName'],
                    'FNMnuSeq'          => $aValue['FNMnuSeq'],
                    'FNMnuLevel'        => $aValue['FNMnuLevel'],
                    'FTAutStaRead'      => $aValue['FTAutStaRead'],
                    'FTAutStaAdd'       => $aValue['FTAutStaAdd'],
                    'FTAutStaDelete'    => $aValue['FTAutStaDelete'],
                    'FTAutStaEdit'      => $aValue['FTAutStaEdit'],
                    'FTAutStaCancel'    => $aValue['FTAutStaCancel'],
                    'FTAutStaAppv'      => $aValue['FTAutStaAppv'],
                    'FTAutStaPrint'     => $aValue['FTAutStaPrint'],
                    'FTAutStaPrintMore' => $aValue['FTAutStaPrintMore'],
                );

                $aDataInsUsrMenu    = $this->mRole->FSaMROlInsertUsrMenu($aDataInsUseMenu);
            }
        }

        //Insert ตาราง TCNTUsrFuncRpt
        if(!empty($tDataJSon[1]['tItem'])){
            foreach($tDataJSon[1]['tItem'] AS $key => $aValue){
                $aDataInsRptMenu  = array(
                    'FTRolCode'             => $aDataMaster['FTRolCode'],
                    'FTGrpRptModCode'       => $aValue['FTGrpRptModCode'],
                    'FNGrpRptModShwSeq'     => $aValue['FNGrpRptModShwSeq'], 
                    'FNGrpRptShwSeq'        => $aValue['FNGrpRptShwSeq'],
                    'FNGrpRptModName'       => $aValue['FNGrpRptModName'],
                    'FTGrpRptCode'          => $aValue['FTGrpRptCode'],
                    'FTGrpRptName'          => $aValue['FTGrpRptName'],
                    'FTRptCode'             => $aValue['FTRptCode'],
                    'FTRptName'             => $aValue['FTRptName'],
                );

                $aDataInsUsrFuncRpt    = $this->mRole->FSaMROlInsertUsrFuncRpt($aDataInsRptMenu);
            }
        }

        //Insert ตาราง TPSMFuncHD
        if(!empty($tDataJSon[2]['tItem'])){
            foreach($tDataJSon[2]['tItem'] AS $key => $aValue){
                $aDataInsfuncHD = array(
                    'FTRolCode'         => $aDataMaster['FTRolCode'],
                    'FTGhdApp'          => $aValue['FTGhdApp'],
                    'FTKbdScreen'       => $aValue['FTKbdScreen'],
                    'FTAppName'         => $aValue['FTAppName'],
                    'FTGdtName'         => $aValue['FTGdtName'],
                    'FTGhdCode'         => $aValue['FTGhdCode'],
                    'FTSysCode'         => $aValue['FTSysCode'],
                    'FTGdtCallByName'   => $aValue['FTGdtCallByName'],
                    'FNGdtFuncLevel'    => $aValue['FNGdtFuncLevel'],
                    'FTGdtStaUse'       => $aValue['FTGdtStaUse'],
                    'FTUfrStaAlw'       => $aValue['FTUfrStaAlw'],

                );
                $aDataInsFuncHD    = $this->mRole->FSaMROlInsertFuncHD($aDataInsfuncHD);
            }
        }

        if($this->session->userdata('nSesUsrBchCount')!=0){
            $tSesUsrRoleCodeMultiSpc 	= "";
            $aDataWhereChain = array(
                'tUsrRoleMulti'	=> $this->session->userdata("tSesUsrRoleCodeMulti"),
                'tLoginLevel' 	=> $this->session->userdata("tSesUsrLoginLevel"),
                'tAgnCode'		=> $this->session->userdata("tSesUsrAgnCode"),
                'tBchCodeMulti'	=> $this->session->userdata("tSesUsrBchCodeMulti")
            );
            $aDataUsrRoleChain  		= $this->mLogin->FSaMLOGGetUserRoleChain($aDataWhereChain);

            if( $aDataUsrRoleChain['tCode'] == '1' ){
                $tSesUsrRoleCodeMultiSpc = $this->mLogin->FStMLOGMakeArrayToString($aDataUsrRoleChain['aItems'],'FTRolCode','value');
            }

            $this->session->set_userdata("tSesUsrRoleSpcCodeMulti", $tSesUsrRoleCodeMultiSpc);
        }


        $aReturn = array(
            'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
            'tCodeReturn'	=> $aDataMaster['FTRolCode'],
            'nStaEvent'	    => '1',
            'tStaMessg'		=> 'Success Update'
        );
        echo json_encode($aReturn);
    }

    // ===============================================  ExportData  ============================================= ExportData ===========================


}
