<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cAdjustStock extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('company/company/mCompany');
        $this->load->model('company/branch/mBranch');
        $this->load->model('company/shop/mShop');
        $this->load->model('payment/rate/mRate');
        $this->load->model('company/vatrate/mVatRate');
        $this->load->model('document/adjuststock/mAdjustStock');
    }

    public function index($nBrowseType,$tBrowseOption){
        $aDataConfigView    = array(
            'nBrowseType'       => $nBrowseType,    // nBrowseType สถานะการเข้าเมนู 0 :เข้ามาจากการกด Menu / 1 : เข้ามาจากการเพิ่มข้อมูลจาก Modal Browse ข้อมูล
            'tBrowseOption'     => $tBrowseOption,  // 
            'aAlwEvent'         => FCNaHCheckAlwFunc('dcmAST/0/0'), // Controle Event
            'vBtnSave'          => FCNaHBtnSaveActiveHTML('dcmAST/0/0'), // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(), // Setting Config การโชว์จำนวนเลขทศนิยม
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave() // Setting Config การ Saveจ ำนวนเลขทศนิยม
        );
        $this->load->view('document/adjuststock/wAdjustStock',$aDataConfigView);
    }

    // Functionality : Function Call Page From Search List
    // Parameters : Ajax and Function Parameter
    // Creator : 06/06/2019 Wasin (Yoshi)
    // Return : String View
    // ReturnType : View
    public function FSvCASTFormSearchList(){
        $this->load->view('document/adjuststock/wAdjustStockFormSearchList');    
    }

    // Functionality : Function Call Page Data Table
    // Parameters : Ajax and Function Parameter
    // Creator : 06/06/2019 wasin (Yoshi)
    // Return : Object View Data Table
    // ReturnType : object
    public function FSoCASTDataTable(){
        try{
            $aAdvanceSearch     = $this->input->post('oAdvanceSearch');
            $nPage              = $this->input->post('nPageCurrent');

            // Controle Event
            $aAlwEvent          = FCNaHCheckAlwFunc('dcmAST/0/0');

            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

            // Page Current 
            if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}

            // Lang ภาษา
            $nLangEdit          = $this->session->userdata("tLangEdit");

            // Data Conditon Get Data Document
            $aDataCondition  = array(
                'FNLngID'           => $nLangEdit,
                'nPage'             => $nPage,
                'nRow'              => 10,
                'aAdvanceSearch'    => $aAdvanceSearch
            );

            $aDataList  = $this->mAdjustStock->FSaMASTGetDataTable($aDataCondition);

            $aConfigView    = array(
                'nPage'             => $nPage,
                'nOptDecimalShow'   => $nOptDecimalShow,
                'aAlwEvent'         => $aAlwEvent,
                'aDataList'         => $aDataList,
            );

            $tASTViewDataTable = $this->load->view('document/adjuststock/wAdjustStockDataTable',$aConfigView,true);
            $aReturnData = array(
                'tViewDataTable'    => $tASTViewDataTable,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality: Function Delete Document Adjust Stock
    // Parameters: Ajax and Function Parameter
    // Creator: 07/06/2019 wasin (Yoshi)
    // Return: Object View Data Table
    // ReturnType: object
    public function FSoCASTDeleteEventDoc(){
        try{    
            $tASTDocNo  = $this->input->post('tASTDocNo');
            $aDataMaster = array(
                'tASTDocNo'     => $tASTDocNo
            );
            $aResDelDoc = $this->mAdjustStock->FSnMASTDelDocument($aDataMaster);
            if($aResDelDoc['rtCode'] == '1'){
                $aDataStaReturn  = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success'
                );
            }else{
                $aDataStaReturn  = array(
                    'nStaEvent' => $aResDelDoc['rtCode'],
                    'tStaMessg' => $aResDelDoc['rtDesc']
                );
            }
        }catch(Exception $Error){
            $aDataStaReturn = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataStaReturn);
    }

    // Functionality : Function Call Page Add Adjust Stock
    // Parameters : Ajax and Function Parameter
    // Creator : 07/06/2019 wasin (Yoshi)
    // Return : Object View Page Add
    // ReturnType : object
    public function FSoCASTAddPage(){
        try{
            // Clear Product List IN Doc Temp
            $tTblSelectData = "TCNTPdtAdjStkHD";
            $this->mAdjustStock->FSxMASTClearPdtInTmp($tTblSelectData);

            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
            // Get Option Doc Save
            $nOptDocSave        = FCNnHGetOptionDocSave();
            // Get Option Scan SKU
            $nOptScanSku        = FCNnHGetOptionScanSku();
            //Lang ภาษา
            $nLangEdit          = $this->session->userdata("tLangEdit");

            $aDataWhere = array('FNLngID' => $nLangEdit);

            $tAPIReq    = "";
            $tMethodReq = "GET";
            $aCompData  = $this->mCompany->FSaMCMPList($tAPIReq,$tMethodReq,$aDataWhere);  

           
            $tCmpCode       = $aCompData['raItems']['rtCmpCode'];

            if($aCompData['rtCode'] == '1'){
                $tBchCode       = $aCompData['raItems']['rtCmpBchCode'];
                $tCmpRteCode    = $aCompData['raItems']['rtCmpRteCode'];
                $tVatCode       = $aCompData['raItems']['rtVatCodeUse'];
                $aVatRate       = FCNoHCallVatlist($tVatCode); 
                $cVatRate       = $aVatRate['FCVatRate'][0];
                $aDataRate      = array(
                    'FTRteCode' => $tCmpRteCode,
                    'FNLngID'   => $nLangEdit
                );
                $aResultRte     = $this->mRate->FSaMRTESearchByID($aDataRate);
                if($aResultRte['rtCode'] == 1){
                    $cXthRteFac = $aResultRte['raItems']['rcRteRate'];
                }else{
                    $cXthRteFac = "";
                }
            }else{
                $tBchCode       = FCNtGetBchInComp();
                $tCmpRteCode    = "";
                $tVatCode       = "";
                $cVatRate       = "";
                $cXthRteFac     = "";
            }

            // Get Department Code
            // $tUsrLogin  = $this->session->userdata('tSesUsername');
            // $tDptCode   = FCNnDOCGetDepartmentByUser($tUsrLogin);

            // Get ข้อมูลสาขา และ ร้านค้าของ User ที่ login
            // $aDataShp   = array(
            //     'FNLngID'   => $nLangEdit,
            //     'tUsrLogin' => $tUsrLogin
            // );
            // $this->mAdjustStock->FSaMASTGetShpCodeForUsrLogin($aDataShp);
            // $aDataUserGroup = $this->mAdjustStock->FSaMASTGetShpCodeForUsrLogin($aDataShp);
            // if(empty($aDataUserGroup)){
                
                // $tBchCode   = "";
                // $tBchName   = "";
                $tMerCode   = "";
                $tMerName   = "";
                $tShpType   = "";
                $tShpCode   = "";
                $tShpName   = "";
                $tWahCode   = "";
                $tWahName   = "";

                // if($this->session->userdata("tSesUsrLevel") == "HQ"){
                //     $tBchCode = $this->session->userdata("tSesUsrBchCom");
                //     $tBchName = $this->session->userdata("tSesUsrBchNameCom");
                // }else{
                //     $tBchCode = $this->session->userdata("tSesUsrBchCode");
                //     $tBchName = $this->session->userdata("tSesUsrBchName");
                //     if($this->session->userdata("tSesUsrLevel") == "SHP"){
                //         $tShpCode = $this->session->userdata("tSesUsrShpCode");
                //         $tShpName = $this->session->userdata("tSesUsrShpName");
                //         $tMerCode = $this->session->userdata("tSesUsrMerCode");
                //         $tMerName = $this->session->userdata("tSesUsrMerName");
                //     }
                // }

            // }else{
            //     $tBchCode   = "";
            //     $tBchName   = "";
            //     $tMerCode   = "";
            //     $tMerName   = "";
            //     $tShpType   = "";
            //     $tShpCode   = "";
            //     $tShpName   = "";
            //     $tWahCode   = "";
            //     $tWahName   = "";

                // เช็ค user ว่ามีการผูกสาขาไว้หรือไม่
                // if(isset($aDataUserGroup["FTBchCode"]) && !empty($aDataUserGroup["FTBchCode"])){
                //     $tBchCode   = $aDataUserGroup["FTBchCode"];
                //     $tBchName   = $aDataUserGroup["FTBchName"];
                // }

                // เช็ค user ว่ามีการผูกกลุ่มร้านค้าไว้หรือไม่
                // if(isset($aDataUserGroup["FTMerCode"]) && !empty($aDataUserGroup["FTMerCode"])){
                //     $tMerCode   = $aDataUserGroup["FTMerCode"];
                //     $tMerName   = $aDataUserGroup["FTMerName"];
                // }

                // เช็ค user ว่ามีการผูกร้านค้าไว้หรือไม่
                // $tShpType   = $aDataUserGroup["FTShpType"];
                // if(isset($aDataUserGroup["FTShpCode"]) && !empty($aDataUserGroup["FTShpCode"])){
                //     $tShpCode   = $aDataUserGroup["FTShpCode"];
                //     $tShpName   = $aDataUserGroup["FTShpName"];
                // }

                // if(isset($aDataUserGroup["FTWahCode"]) && !empty($aDataUserGroup["FTWahCode"])){
                //     $tWahCode   = $aDataUserGroup["FTWahCode"];
                //     $tWahName   = $aDataUserGroup["FTWahName"];
                // }
            // }

            $aDataConfigViewAdd = array(
                'nOptDecimalShow'   => $nOptDecimalShow,
                'nOptDocSave'       => $nOptDocSave,
                'nOptScanSku'       => $nOptScanSku,
                'tCmpRteCode'       => $tCmpRteCode,
                'tVatCode'          => $tVatCode,
                'cVatRate'          => $cVatRate,
                'cXthRteFac'        => $cXthRteFac,
                // 'tDptCode'          => $tDptCode,
                // 'tBchCode'          => $tBchCode,
                // 'tBchName'          => $tBchName,
                // 'tMerCode'          => $tMerCode,
                // 'tMerName'          => $tMerName,
                // 'tShpType'          => $tShpType,
                // 'tShpCode'          => $tShpCode,
                // 'tShpName'          => $tShpName,
                // 'tWahCode'          => $tWahCode,
                // 'tWahName'          => $tWahName,
                'aDataDocHD'        => array('rtCode'=>'99'),
                'tBchCompCode'      => FCNtGetBchInComp(),
                'tBchCompName'      => FCNtGetBchNameInComp(),
                'tCmpCode'          => $tCmpCode
            );

            $tASTViewPageAdd    = $this->load->view('document/adjuststock/wAdjustStockAdd',$aDataConfigViewAdd,true);
            $aReturnData        = array(
                'tASTViewPageAdd'   => $tASTViewPageAdd,
                'tUsrLevel'         => $this->session->userdata("tSesUsrLevel"),
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Function Call Page Product Advance Table Adjust Stock
    // Parameters : Ajax and Function Parameter
    // Creator : 10/06/2019 wasin(Yoshi)
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCASTPdtAdvTblLoadData(){
        try{
            $tSearchAll         = $this->input->post('ptSearchAll');
            $tASTDocNo          = $this->input->post('ptASTDocNo');
            $tASTStaApv         = $this->input->post('ptASTStaApv');
            $tASTStaDoc         = $this->input->post('ptASTStaDoc');
            $nASTApvSeqChk      = $this->input->post('pnASTApvSeqChk');
            $nASTPageCurrent    = $this->input->post('pnASTPageCurrent');

            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

            // Call Advance Table
            // $tTableTransferOut  = "TCNTPdtAdjStkDT";
            // $aColumnShow        = FCNaDCLGetColumnShow($tTableTransferOut);

            // print_r($aColumnShow);
            // exit;

            $aColumnShow = array(
            
                (object) array('FNShwSeq' => 1,  'FTShwFedShw' => 'FTPdtCode',          'FTShwNameUsr' => 'รหัสสินค้า',     'FTShwFedStaUsed' => '1','FNShwColWidth' => 0,'FTShwStaAlwEdit' => 0),
                (object) array('FNShwSeq' => 2,  'FTShwFedShw' => 'FTXtdPdtName',       'FTShwNameUsr' => 'ชื่อสินค้า',     'FTShwFedStaUsed' => '1','FNShwColWidth' => 0,'FTShwStaAlwEdit' => 0),
                (object) array('FNShwSeq' => 3,  'FTShwFedShw' => 'FTXtdBarCode',       'FTShwNameUsr' => 'รหัสบาร์โค้ด',  'FTShwFedStaUsed' => '1','FNShwColWidth' => 0,'FTShwStaAlwEdit' => 0),
                (object) array('FNShwSeq' => 4,  'FTShwFedShw' => 'FCPdtUnitFact',      'FTShwNameUsr' => 'อัตราส่วน',    'FTShwFedStaUsed' => '1','FNShwColWidth' => 0,'FTShwStaAlwEdit' => 0),
    
                (object) array('FNShwSeq' => 5,  'FTShwFedShw' => 'FCAjdWahB4Adj',      'FTShwNameUsr' => 'ก่อนตรวจนับ',  'FTShwFedStaUsed' => '1','FNShwColWidth' => 0, 'FTShwStaAlwEdit' => 0),
                (object) array('FNShwSeq' => 6,  'FTShwFedShw' => 'FCAjdUnitQtyC1',     'FTShwNameUsr' => 'ตรวจนับ',     'FTShwFedStaUsed' => '1','FNShwColWidth' => 0, 'FTShwStaAlwEdit' => 1),
                (object) array('FNShwSeq' => 7,  'FTShwFedShw' => 'FCAfterCount',       'FTShwNameUsr' => 'หลังตรวจนับ',  'FTShwFedStaUsed' => '1','FNShwColWidth' => 0, 'FTShwStaAlwEdit' => 0)
            );

            $aDataWhere         = array(
                'tSearchAll'    => $tSearchAll,
                'FTXthDocNo'    => $tASTDocNo,
                'FTXthDocKey'   => "TCNTPdtAdjStkHD",
                'nPage'         => $nASTPageCurrent,
                'nRow'          => 10,
                'FTSessionID'   => $this->session->userdata('tSesSessionID'),
            );
            // Edit in line
            $tPdtCode       = $this->input->post('ptPdtCode');
            $tPunCode       = $this->input->post('ptPunCode');
            $aDataDTList    = $this->mAdjustStock->FSaMASTGetDTTempListPage($aDataWhere);
            // $aDataDTSum     = $this->mAdjustStock->FSaMASTSumDTTemp($aDataWhere);

            $aDataView          = array(
                'tASTStaApv'        => $tASTStaApv,
                'tASTStaDoc'        => $tASTStaDoc,
                'nASTApvSeqChk'     => $nASTApvSeqChk,
                'nOptDecimalShow'   => $nOptDecimalShow,
                'aColumnShow'       => $aColumnShow,
                'aDataDTList'       => $aDataDTList,
                // 'aDataDTSum'        => $aDataDTSum,
                'nPage'             => $nASTPageCurrent,
                'tPunCode'          => $tPunCode,
                'tPdtCode'          => $tPdtCode,
            );
            
            $tASTPdtAdvTableView    = $this->load->view('document/adjuststock/advancetable/wAdjustStockPdtAdvTableData',$aDataView,true);
            $aReturnData = array(
                'tASTPdtAdvTableView'   => $tASTPdtAdvTableView,
                'nStaEvent'             => '1',
                'tStaMessg'             => 'Success View',
                'nASTPageCurrent'  => $nASTPageCurrent
            );
        }catch(Exception $Error){
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function: Call View Table Manage Advance Table
    // Parameters: Document Type
    // Creator: 12/06/2019 wasin (Yoshi)
    // LastUpdate: -
    // Return: Object View Advance Table
    // ReturnType: Object
    public function FSoCASTAdvTblShowColList(){
        try{
            $tTableShowColums   = "TCNTPdtAdjStkDT";
            $aAvailableColumn   = FCNaDCLAvailableColumn($tTableShowColums);
            $aDataViewAdvTbl    = array(
                'aAvailableColumn'  => $aAvailableColumn
            );
            
            $tViewTableShowCollist  = $this->load->view('document/adjuststock/advancetable/wAdjustStockTableShowColList',$aDataViewAdvTbl,true);
            $aReturnData = array(
                'tViewTableShowCollist' => $tViewTableShowCollist,
                'nStaEvent'             => '1',
                'tStaMessg'             => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function: Save Columns Advance Table List
    // Parameters: Data Save Colums Advance Table
    // Creator: 12/06/2018 wasin
    // LastUpdate: -
    // Return: Object Sta Save Advance Table
    // ReturnType: Object
    public function FSoCASTShowColSave(){
        try{
            $this->db->trans_begin();

            $aASTColShowSet         = $this->input->post('aASTColShowSet');
            $aASTColShowAllList     = $this->input->post('aASTColShowAllList');
            $aASTColumnLabelName    = $this->input->post('aASTColumnLabelName');
            $nASTStaSetDef          = $this->input->post('nASTStaSetDef');

            // Table Set Show Colums
            $tTableShowColums   = "TCNTPdtAdjStkDT";
            FCNaDCLSetShowCol($tTableShowColums,'','');
            if($nASTStaSetDef == '1'){
                FCNaDCLSetDefShowCol($tTableShowColums);
            }else{
                for($i = 0; $i < FCNnHSizeOf($aASTColShowSet); $i++){
                    FCNaDCLSetShowCol($tTableShowColums,1,$aASTColShowSet[$i]);
                }
            }

            // Reset Seq Advannce Table
            FCNaDCLUpdateSeq($tTableShowColums,'','','');
            $q  = 1;
            for($n = 0; $n<FCNnHSizeOf($aASTColShowAllList); $n++){
                FCNaDCLUpdateSeq($tTableShowColums,$aASTColShowAllList[$n],$q,$aASTColumnLabelName[$n]);
                $q++;
            }

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturnData    = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Eror Not Save Colums'
                );
            }else{
                $this->db->trans_commit();
                $aReturnData    = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success'
                );
            }
        }catch(Exception $Error){
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }


    public function FSbCheckHaveProductForTransfer(){
        $tDocNo = $this->input->post("tDocNo");
        $nNumPdt = $this->mAdjustStock->FSnMTFWCheckPdtTempForTransfer($tDocNo);
        if($nNumPdt>0){
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }

    }

    // Function : Add Pdt ลง Dt (File)
    // Creator: 21/06/2019 Bell
    // LastUpdate: -
    // Return: Object Sta Save Advance Table
    // ReturnType: Object
    public function FSvCASTAddPdtIntoTableDT(){

        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCode   = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCode");
        $tAjhDocNo  = $this->input->post('ptAjhDocNo');
        $nAdjStkOptionAddPdt = $this->input->post('pnAdjStkSubOptionAddPdt');
        $pjPdtData  = $this->input->post('pjPdtData');
        $aPdtData   = json_decode($pjPdtData);



        $aDataWhere = array(
            'FTAjhDocNo'    => $tAjhDocNo,
            'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
        );
        $nCounts  =  $this->mAdjustStock->FSaMAdjStkGetCountDTTemp($aDataWhere);

        // วนตามรายการสินค้าที่เพิ่มเข้ามา
        for ($nI=0;$nI<FCNnHSizeOf($aPdtData);$nI++){
                 
            $pnPdtCode  = $aPdtData[$nI]->pnPdtCode;
            $ptBarCode  = $aPdtData[$nI]->ptBarCode; 
            $ptPunCode  = $aPdtData[$nI]->ptPunCode;
            $pcPrice    = $aPdtData[$nI]->packData->Price;
            $ptPlcCode  = $aPdtData[$nI]->packData->LOCSEQ;
            $nCounts    = $nCounts+1;

            $aDataPdtWhere = array(
                'FTAjhDocNo'    => $tAjhDocNo,  
                'FTBchCode'     => $tBchCode,   // จากสาขาที่ทำรายการ
                'FTPdtCode'     => $pnPdtCode,  // จาก Browse Pdt
                'FTPunCode'     => $ptPunCode,  // จาก Browse Pdt
                'FTBarCode'     => $ptBarCode,  // จาก Browse Pdt
                'pcPrice'       => $pcPrice,    // ราคาสินค้าจาก Browse Pdt
                'FTPlcCode'     => $ptPlcCode,
                'nCounts'       => $nCounts,    //จำนวนล่าสุด Seq
                'FNLngID'       => $this->session->userdata("tLangID"), //รหัสภาษาที่ login
                'FTSessionID'   => $this->session->userdata('tSesSessionID'),
                'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
                'nAdjStkSubOptionAddPdt' => $nAdjStkOptionAddPdt,
            );

            // echo '<pre>';
            // print_r($aDataPdtWhere);
            // exit();

            $aDataPdtMaster = $this->mAdjustStock->FSaMAdjStkGetDataPdt($aDataPdtWhere); // Data Master Pdt
            $nStaInsPdtToTmp = $this->mAdjustStock->FSaMAdjStkInsertPDTToTemp($aDataPdtMaster, $aDataPdtWhere);
        }
    }

    //Functionality : การบันทึกข้อมูลลงฐานข้อมูล
    //Parameters : -
    //Creator : -
    //Update : 21/06/2019 Bell
    //Return : view
    //Return Type : View
    public function FSaCASTAddEvent(){
        try{
            $aDataDocument = $this->input->post();

 

            $tAjhDocDate    = $this->input->post('oetASTDocDate')." ".$this->input->post('oetASTDocTime');
            $tAdjStkBch     = $this->input->post('oetASTBchCode');  // นับได้เฉพาะในสาขาที่เข้าใช้งานเท่านั้น (สาขาสร้าง = สาขาที่นับ)
            $tUserLogin     = $this->session->userdata('tSesUsername');
            
            $aDataMaster = array(
                'tIsAutoGenCode'  => $this->input->post('ocbASTStaAutoGenCode'), // ต้องการรัน DocNo อัตโนมัติหรือไม่ 
                'FTBchCode'       => $tAdjStkBch,
                'FTAjhDocNo'      => $this->input->post('oetASTDocNo'),
                'FNAjhDocType'    => 11, // ประเภทใบนับสต๊อก
                'FTAjhDocType'    => '3', // ประเภทใบนับย่อย
                'FDAjhDocDate'    => $tAjhDocDate,
                'FTAjhBchTo'      => $tAdjStkBch,  //นับภายใต้สาขา
                'FTAjhMerchantTo' => $this->input->post('oetASTMerCode'), // นับภายใต้กลุ่มร้านค้า
                'FTAjhShopTo'     => $this->input->post('oetASTShopCode'), //นับภายใต้ร้านค้า
                'FTAjhPosTo'      => $this->input->post('oetASTPosCode'), // นับภายใต้เครื่องจุดขาย
                'FTAjhWhTo'       => $this->input->post('oetASTWahCode'), //นับภายใต้คลังสินค้า
                'FTAjhPlcCode'    => NULL, // เก็บข้อมูลของที่เก็บ
                'FTDptCode'       => $this->input->post('ohdASTDptCode'), //แผนกผู้ใช้ login
                'FTUsrCode'       => $tUserLogin, // User Login
                'FTRsnCode'       => $this->input->post('oetASTRsnCode'), // เหตุผลการตรวจนับ
                'FTAjhRmk'        => $this->input->post('otaASTRmk'),  // ข้อมูลหมายเหตุ
                'FNAjhDocPrint'   => '1',
                'FTAjhApvSeqChk'  => '1', //$this->input->post('ostASTApvSeqChk')  //ใช้การตรวจนับ 1:นับ 1  2:นับ2  3:กำหนดเอง
                'FTAjhApvCode'    => NULL,
                'FTAjhStaApv'     => NULL,
                'FTAjhStaPrcStk'  => NULL,
                'FNAjdLayRow'     => '',
                'FNAjdLayCol'     => '',
                'FTAjhStaDoc'     => 1, //สถานะ เอกสาร  1:สมบูรณ์, 2:ไม่สมบูรณ์, 3:ยกเลิก
                'FNAjhStaDocAct' => !empty($aDataDocument['ocbASTStaDocAct']) ? $aDataDocument['ocbASTStaDocAct'] : 0,
                'FTAjhDocRef'     => NULL,
                'FDLastUpdOn'     => date('Y-m-d H:i:s'),
                'FTLastUpdBy'     => $tUserLogin,
                'FDCreateOn'      => date('Y-m-d H:i:s'),
                'FTCreateBy'      => $tUserLogin,
            );
     
            //Setup Doc No
            if($aDataMaster['tIsAutoGenCode'] == '1'){
                //Auto Gen ADjustStock
                // $aGenCode = FCNaHGenCodeV5('TCNTPdtAdjStkHD','3');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataMaster['FTAjhDocNo'] = $aGenCode['rtAjhDocNo'];
                // }

                // Update new gencode
                // 18/05/2020 Napat(Jame)
                $aStoreParam = array(
                    "tTblName"    => 'TCNTPdtAdjStkHD',                           
                    "tDocType"    => '3',                                          
                    "tBchCode"    => $tAdjStkBch,                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen                   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTAjhDocNo']  = $aAutogen[0]["FTXxhDocNo"];
            }

            $aDataWhere = array(
                'FTAjhDocNo'    => $aDataMaster['FTAjhDocNo'],
                'FTBchCode'     => $aDataMaster['FTBchCode'],  
                'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
            );

            $this->db->trans_begin();

            $this->mAdjustStock->FSaMASTAddUpdateDocNoInDocTemp($aDataWhere);   // Update DocNo ในตาราง Doctemp
            $this->mAdjustStock->FSaMASTAddUpdateHD($aDataMaster);  // ยังไม่ได้ update
            $this->FSaMASTAddTmpToDT($aDataMaster['FTAjhDocNo']);  // Temp to DT and Clear Temp       

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'     => '900',
                    'tStaMessg'     => "Unsuccess Add"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'   => $aDataMaster['FTAjhDocNo'],
                    'nStaEvent'     => '1',
                    'tStaMessg'     => 'Success Add'
                );
            }
            echo json_encode($aReturn);

        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : การบันทึกข้อมูลลงฐานข้อมูล
    //Parameters : -
    //Creator : -
    //Update : 21/06/2019 Bell
    //Return : view
    //Return Type : View
    public function FSaCASTEditEvent(){
        try{
            $aDataDocument  = $this->input->post();

            $tAjhDocDate    = $this->input->post('oetASTDocDate')." ".$this->input->post('oetASTDocTime');
            $tAdjStkBch     = $this->input->post('oetASTBchCode');  // นับได้เฉพาะในสาขาที่เข้าใช้งานเท่านั้น (สาขาสร้าง = สาขาที่นับ)
            $tUserLogin     = $this->session->userdata('tSesUsername');
            $aDataMaster = array(
                'FTBchCode'       => $tAdjStkBch,
                'FTAjhDocNo'      => $this->input->post('oetASTDocNo'),
                'FNAjhDocType'    => 11, // ประเภทใบนับสต๊อก
                'FTAjhDocType'    => '3', // ประเภทใบนับย่อย
                'FDAjhDocDate'    => $tAjhDocDate,
                'FTAjhBchTo'      => $tAdjStkBch,  //นับภายใต้สาขา
                'FTAjhMerchantTo' => $this->input->post('oetASTMerCode'), // นับภายใต้กลุ่มร้านค้า
                'FTAjhShopTo'     => $this->input->post('oetASTShopCode'), //นับภายใต้ร้านค้า
                'FTAjhPosTo'      => $this->input->post('oetASTPosCode'), // นับภายใต้เครื่องจุดขาย
                'FTAjhWhTo'       => $this->input->post('oetASTWahCode'), //นับภายใต้คลังสินค้า
                'FTAjhPlcCode'    => NULL, // เก็บข้อมูลของที่เก็บ
                'FTDptCode'       => $this->input->post('ohdASTDptCode'), //แผนกผู้ใช้ login
                'FTUsrCode'       => $tUserLogin, // User Login
                'FTRsnCode'       => $this->input->post('oetASTRsnCode'), // เหตุผลการตรวจนับ
                'FTAjhRmk'        => $this->input->post('otaASTRmk'),  // ข้อมูลหมายเหตุ
                'FNAjhDocPrint'   => '1',
                'FTAjhApvSeqChk'  => $this->input->post('ostASTApvSeqChk'),  //ใช้การตรวจนับ 1:นับ 1  2:นับ2  3:กำหนดเอง
                'FTAjhApvCode'    => NULL,
                'FTAjhStaApv'     => NULL,
                'FTAjhStaPrcStk'  => NULL,
                'FNAjdLayRow'     => '',
                'FNAjdLayCol'     => '',
                'FTAjhStaDoc'     => 1, //สถานะ เอกสาร  1:สมบูรณ์, 2:ไม่สมบูรณ์, 3:ยกเลิก
                'FNAjhStaDocAct' => !empty($aDataDocument['ocbASTStaDocAct']) ? $aDataDocument['ocbASTStaDocAct'] : 0,
                'FTAjhDocRef'     => NULL,
                'FDLastUpdOn'     => date('Y-m-d H:i:s'),
                'FTLastUpdBy'     => $tUserLogin,
                'FDCreateOn'      => date('Y-m-d H:i:s'),
                'FTCreateBy'      => $tUserLogin
            );
            $aDataWhere = array(
                'FTAjhDocNo'    => $aDataMaster['FTAjhDocNo'],
                'FTBchCode'     => $aDataMaster['FTBchCode'],  
                'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
            );
            $this->db->trans_begin();   

            $this->mAdjustStock->FSaMASTAddUpdateDocNoInDocTemp($aDataWhere);   // Update DocNo ในตาราง Doctemp 
            $this->mAdjustStock->FSaMASTAddUpdateHD($aDataMaster);  // ยังไม่ได้ update
            $this->FSaMASTAddTmpToDT($aDataMaster['FTAjhDocNo']);  // Temp to DT and Clear Temp       
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'     => '900',
                    'tStaMessg'     => "Unsuccess Add"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'   => $aDataMaster['FTAjhDocNo'],
                    'nStaEvent'     => '1',
                    'tStaMessg'     => 'Success Add'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    
    // Function : Add Temp to DT
    public function FSaMASTAddTmpToDT($ptAjhDocNo = ''){
        $aDataWhere = array(
            'FTAjhDocNo'    => $ptAjhDocNo,
            'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
        );

        // Insert Temp ลง DT
        $aResInsDT = $this->mAdjustStock->FSaMASTInsertTmpToDT($aDataWhere);
    }

    // Function : แก้ไข Pdt DT
    public function FSvCASTEditPdtIntoTableDT(){

        $tXthDocNo    = $this->input->post('ptXthDocNo');
        $tEditSeqNo   = $this->input->post('ptEditSeqNo');
        $aField       = $this->input->post('paField');
        $aValue       = $this->input->post('paValue');      
        

        $aDataWhere = array(
            'FTAjhDocNo'    => $tXthDocNo,
            'FNXtdSeqNo'    => $tEditSeqNo,
            'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
        );
        
        $aDataUpdateDT  = array();

        foreach($aField as $key => $FieldName){
            $aDataUpdateDT[$FieldName] = $aValue[$key];   
        }

        //edit In line
        $aResUpdDTTmpInline = $this->mAdjustStock->FSnMASTUpdateInlineDTTemp($aDataUpdateDT, $aDataWhere);
    }

    //Functionality : Remove PDTInDTTemp
    //Parameters : -
    //Creator : -
    //Update : 24/06/2019 Bell
    //Return : view
    //Return Type : View
    public function FSvCASTRemovePdtInDTTmp(){

        $ptRoute    = $this->input->post('ptRoute');
        $tDocNo     = $this->input->post('ptXthDocNo');
        
        if($ptRoute == 'dcmASTEventAdd'){
            $tDocNo = "";
        }

        $aDataWhere = array(
            'FTXthDocNo'    => $tDocNo,
           'FTPdtCode'      => $this->input->post('ptPdtCode'),
           'FNXtdSeqNo'     => $this->input->post('ptSeqno'),
           'FTXthDocKey'    => 'TCNTPdtAdjStkHD',
           'FTSessionID'    => $this->session->userdata('tSesSessionID'),
        );

        $aResDel = $this->mAdjustStock->FSnMASTDelDTTmp($aDataWhere);
    }


    //Functionality : Event Delete Product
    //Parameters : Ajax jReason()
    //Creator : 24/05/2019 Witsarut(BEll)
    //Return : Status Delete Event
    //Return Type : String
    public function FSvCASTPdtMultiDeleteEvent(){
        $FTXthDocNo = $this->input->post('tDocNo');
        $FTPdtCode  = $this->input->post('tPdtCode');
        $FTPunCode  = $this->input->post('tPunCode');
        $aSeqCode   = $this->input->post('tSeqCode');
        $tSession   = $this->session->userdata('tSesSessionID');
        $nCount     = FCNnHSizeOf($aSeqCode);

        if($nCount > 1){
            for($i=0; $i<$nCount; $i++){

                $aDataMaster = array(
                    'FTXthDocNo'    => $FTXthDocNo,
                    'FNXtdSeqNo'    => $aSeqCode[$i],
                    'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
                    'FTSessionID'   => $tSession
                );
                $aResDel = $this->mAdjustStock->FSaMASTPdtTmpMultiDel($aDataMaster);
            }
        }else{
                $aDataMaster = array(
                    'FTXthDocNo'    => $FTXthDocNo,
                    'FNXtdSeqNo'    => $aSeqCode[0],
                    'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
                    'FTSessionID'   => $tSession
                );
            $aResDel = $this->mAdjustStock->FSaMASTPdtTmpMultiDel($aDataMaster);
        }

        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    //Functionality : Update In Line
    //Parameters : Ajax jReason()
    //Creator : 26/06/2019 Witsarut(BEll)
    //Last Update : 30/07/2020 Napat(Jame)
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCASTUpdateDataInline(){
        // $tASTDocNo      = $this->input->post('tASTDocNo');
        // $tASTSeqNo      = $this->input->post('tASTSeqUpd');
        // $tASTBchCode    = $this->input->post('tASTBchCode');
        // $aASTDataUpdate = $this->input->post('aASTDataEditInLine');
        // $tASTSessionID  = $this->session->userdata('tSesSessionID');
        // $FDAjdDateTime  = date('Y-m-d H:i:s');

        // $this->db->trans_begin();

        $aDataUpdateInLine  = array(
            'tField'        => $this->input->post('ptField'),
            'tValue'        => $this->input->post('pnVal')
        );

        $aDataWhereUpdInLine    = array(
            'FTXthDocNo'    => $this->input->post('ptDocNo'),
            'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
            'FNXtdSeqNo'    => $this->input->post('pnSeq'),
            'FTSessionID'   => $this->session->userdata('tSesSessionID')
        );
        $aResUpd = $this->mAdjustStock->FSaMUpdateDocDTInLine($aDataUpdateInLine,$aDataWhereUpdInLine);

        // if($this->db->trans_status() === FALSE){
        //     $this->db->trans_rollback();
        //     $aDataReturn = array(
        //         'tStaCode'      => '500',
        //         'tStaMsgErr'    => 'Error Not Update In Line'
        //     );
        // }else{
        //     $this->db->trans_commit();
        //     $aDataReturn = array(
        //         'tStaCode'      => '1',
        //         'tStaMsgErr'    => 'Update Inline Success'
        //     );
        // }
        echo json_encode($aResUpd);
    }


    //Function : เรียกหน้า  Edit
    //Parameters : Call Page Edits
    //Creator : 28/06/2019 Witsarut(BEll)
    //Return : Array Data Page Edits
    //Return Type : Array
    public function FSoCASTEditPage(){
        $tXthDocNo          = $this->input->post('ptXthDocNo');
        // Get Option Show Decimal
        $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
        // Get Option Doc Save
        $nOptDocSave        = FCNnHGetOptionDocSave();
        // Get Option Scan SKU
        $nOptScanSku        = FCNnHGetOptionScanSku();
        //Lang ภาษา
        $nLangEdit          = $this->session->userdata("tLangEdit");
        // Get ข้อมูลสาขา และ ร้านค้าของ User ที่ login
        // $tUsrLogin  = $this->session->userdata('tSesUsername');
        // $aDataShp  = array(
        //     'FNLngID'   => $nLangEdit,
        //     'tUsrLogin' => $tUsrLogin
        // );
        // Get ข้อมูลสาขา และร้านค้าของ User ที่ login
        // $aDataUserGroup = $this->mAdjustStock->FSaMASTGetShpCodeForUsrLogin($aDataShp);
        // if(empty($aDataUserGroup)){
        //     $tBchCode   = '';
        //     $tMchCode   = '';
        //     $tShpCode   = '';
        //     $tShpType   = '';
        // }else{
        //     $tShpType   = $aDataUserGroup["FTShpType"];

        //     // เช็ค user ว่ามีการผูกสาขาไว้หรือไม่
        //     if(empty($aDataUserGroup["FTBchCode"])){
        //         $tBchCode   = '';
        //     }else{
        //         $tBchCode   = $aDataUserGroup["FTBchCode"];
        //     }
        //     // เช็ค user ว่ามีการผูกร้านค้าไว้หรือไม่
        //     if(empty($aDataUserGroup["FTShpCode"])){
        //         $tMchCode   = '';
        //         $tShpCode   = '';
        //     }else{
        //         $tMchCode   = $aDataUserGroup["FTMerCode"];
        //         $tShpCode   = $aDataUserGroup["FTShpCode"];
        //     }
        // }

        // Control Event 
        $aAlwEvent          = FCNaHCheckAlwFunc('dcmAST/0/0'); 



        //Data Master
        $aDataWhere  = array(
            'FTAjhDocNo'    => $tXthDocNo,
            'FNLngID'       => $nLangEdit,
            'nRow'          => 10000,
            'nPage'         => 1,
            'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
        );
        
        $aResult    = $this->mAdjustStock->FSaMASTGetHD($aDataWhere);  //TCNTPdtAdjStkHD


        // $aDataDT    = $this->mAdjustStock->FSaMASTGetDT($aDataWhere);   //TCNTPdtAdjStkDT
        $this->mAdjustStock->FSaMASTInsertDTToTemp($aDataWhere); //MoveDT to Temp
        
        // ========================= Create By Witsarut 27/08/2019 =========================
        // $tAPIReq    = "";
        // $tMethodReq = "GET";
        // $aCompData  = $this->mCompany->FSaMCMPList($tAPIReq,$tMethodReq,$aDataWhere);  

        // $tCmpCode       = $aCompData['raItems']['rtCmpCode'];

        // ========================= Create By Witsarut 27/08/2019 =========================
        $aDataEdit = array(
            'nOptDecimalShow'   => $nOptDecimalShow,
            'nOptDocSave'       => $nOptDocSave,
            'nOptScanSku'       => $nOptScanSku,
            'aDataDocHD'        => $aResult,
            'tBchCompCode'      => $this->session->userdata("tSesUsrBchCodeDefault"), //FCNtGetBchInComp()
            'tBchCompName'      => $this->session->userdata("tSesUsrBchNameDefault")
            // 'tCmpCode'          => $tCmpCode
        );
        $this->load->view('document/adjuststock/wAdjustStockAdd',$aDataEdit);
    }


    //Function : Cancel ApproveDoc
    //Parameters : Cancel ApproveDoc
    //Creator : 28/06/2019 Witsarut(BEll)
    //Return : Array 
    //Return Type : Array
    public function FSvCASTCancel(){
    
        $tXthDocNo =  $this->input->post('tXthDocNo');
        
        $aDataUpdate    =  array(
            'FTAjhDocNo'  => $tXthDocNo,
        );

            $aStaApv = $this->mAdjustStock->FSVMASTCancel($aDataUpdate);

            if($aStaApv['rtCode'] == 1 ){
                $aApv = array(
                    'nSta'  => 1,
                    'tMsg'  => "Cancel done",
                );
            }else{
                $aApv = array(
                    'nSta' => 2,
                    'tMsg' => "Not Cancel",
                );
            }
            echo json_encode($aApv);
    }

    // Function : Approve Doc
    // LastUpdate: 30/07/2019 Wasin(Yoshi)
    // LastUpdate: 29/07/2020 Napat(Jame)
    // Last Update: 18/08/2020 Napat(Jame) อัพเดท FCAjdWahB4Adj ก่อนอนุมัติ
    public function FSvCASTApprove(){
        try{
            // $nLangEdit          = $this->session->userdata("tLangEdit");
            // //Data Master
            // $aDataWhere  = array(
            //     'FTAjhDocNo'    => $tXthDocNo,
            //     'FNLngID'       => $nLangEdit,
            //     'nRow'          => 10000,
            //     'nPage'         => 1,
            //     'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
            // );
            
            // $aResult    = $this->mAdjustStock->FSaMASTGetHD($aDataWhere);  //TCNTPdtAdjStkHD
            // $aDataDT    = $this->mAdjustStock->FSaMASTGetDT($aDataWhere);   //TCNTPdtAdjStkDT
            
            $tXthDocNo          = $this->input->post('tXthDocNo');
            $tUsrBchCode        = $this->input->post('tBchCode');
            // $tXthStaApv = $this->input->Post('tXthStaApv');

            $aReturnUpdDTBal = $this->mAdjustStock->FSaMUpdateDTBal($tXthDocNo);
            if( $aReturnUpdDTBal['tCode'] == '1' ){
                $aDataUpdate = array(
                    'FTAjhDocNo'    => $tXthDocNo,
                    'FTAjhApvCode'  => $this->session->userdata('tSesUsername')
                );
                $aASTStaApv = $this->mAdjustStock->FSvMASTApprove($aDataUpdate);

                if($aASTStaApv['rtCode'] == '1'){
                    $aMQParams = [
                        "queueName"  =>  "ADJUSTSTOCK",
                        "params"   => [
                            "ptBchCode"      => $tUsrBchCode,
                            "ptDocNo"        => $tXthDocNo,
                            "ptDocType"      => '3',
                            "ptUser"         => $this->session->userdata('tSesUsername')
                        ]
                    ];
                    FCNxCallRabbitMQ($aMQParams);

                    $aReturn = array(
                        'nStaEvent'    => '1',
                        'tStaMessg'    => 'ok'
                    );
                }else{
                    $aReturn = array(
                        'nStaEvent'    => '99',
                        'tStaMessg'    => 'Not Approve'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '99',
                    'tStaMessg'    => $aReturnUpdDTBal['tDesc']
                );
            }
            echo json_encode($aReturn);
            
        }catch(\ErrorException $err){

            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => language('common/main/main', 'tApproveFail')
            );
            echo json_encode($aReturn);
            return;
        }
    }

    //Function : Get สินค้า ตาม Pdt BarCode
    public function FSvCASTGetPdtBarCode(){

        $tBarCode = $this->input->post('tBarCode');
        $tSplCode = $this->input->post('tSplCode');

        $aPdtBarCode  = FCNxHGetPdtBarCode($tBarCode,$tSplCode);

        if($aPdtBarCode != 0){
            $jPdtBarCode = json_encode($aPdtBarCode);
            $aData = array(
                'aData' => $jPdtBarCode,
                'tMsg' 	=> 'OK',
            );
        }else{
            $aData = array(
                'aData' => 0,
                'tMsg' 	=> language('document/browsepdt/browsepdt', 'tPdtNotFound'),
            );
        }

        $jData = json_encode($aData);
        echo $jData;
    }

    public function FSvCAdjStkEventAddProducts(){
        try{

            $this->db->trans_begin();

            // Clear Temp Before Insert
            $aDataClear = array(
                'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
                'FTSessionID'   => $this->session->userdata('tSesSessionID'),
                'tDeleteType'   => '1'
            );
            $this->mAdjustStock->FSxMAdjStkClearDTTmp($aDataClear);

            // settings variable
            $aDataCondition = $this->input->post('paCondition');
            $aGetDataInsert = $this->input->post('paDataInsert');

            $aDataInsert = array(
                'FTBchCode'     => $aGetDataInsert['tBchCode'],
                'FTXthDocNo'    => $aGetDataInsert['tDocNo'],
                'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
                'FTSessionID'   => $this->session->userdata('tSesSessionID'),
                'tUser'         => $this->session->userdata('tSesUsername'),
            );
            $aResultPDT = $this->mAdjustStock->FSaMAdjStkEventAddProducts($aDataCondition,$aDataInsert);
            

            // tCode = 1 insert สำเร็จ
            if($aResultPDT['tCode'] == '1'){
                $this->db->trans_commit();
            }else{
                $this->db->trans_rollback();
            }
            echo json_encode($aResultPDT);
            
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Create By : Napat(Jame) 23/09/2022
    // เคลียร์ DT Temp
    public function FSxCASTEventClearDataDTTemp(){
        // Clear Temp Before Insert
        $aDataClear = array(
            'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
            'FTSessionID'   => $this->session->userdata('tSesSessionID'),
            'tDeleteType'   => '1'
        );
        $this->mAdjustStock->FSxMAdjStkClearDTTmp($aDataClear);
    }

}
