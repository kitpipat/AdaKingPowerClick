<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cAdjustStockSub extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->helper("file");
        $this->load->model('company/company/mCompany');
        $this->load->model('company/branch/mBranch');
        $this->load->model('company/shop/mShop');
        $this->load->model('payment/rate/mRate');
        $this->load->model('company/vatrate/mVatRate');
        $this->load->model('document/adjuststocksub/mAdjustStockSub');
    }

    public function index($nBrowseType, $tBrowseOption){

        $aData['nBrowseType'] = $nBrowseType;
        $aData['tBrowseOption'] = $tBrowseOption;
	    $aData['aAlwEvent'] = FCNaHCheckAlwFunc('adjStkSub/0/0'); // Controle Event
        $aData['vBtnSave'] = FCNaHBtnSaveActiveHTML('adjStkSub/0/0'); // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        // Get Option Show Decimal
        $aData['nOptDecimalShow'] = FCNxHGetOptionDecimalShow();
        $aData['nOptDecimalSave'] = FCNxHGetOptionDecimalSave();

        $this->load->view('document/adjuststocksub/wAdjustStockSub', $aData);

    }

    // Function : Add Temp to DT
    public function FSaCAdjStkSubAddTmpToDT($ptAjhDocNo = ''){

        $aDataWhere = array(
            'FTAjhDocNo'    => $ptAjhDocNo,
            'FTXthDocKey'   => 'TCNTPdtAdjStkDT',
            'FTSessionID'   => $this->session->userdata('tSesSessionID'),
            'tDeleteType'   => '1'
        );
        $aResInsDT = $this->mAdjustStockSub->FSaMAdjStkSubInsertTmpToDT($aDataWhere);
    
        if($aResInsDT['rtCode'] == '1'){
            $this->mAdjustStockSub->FSxMAdjStkSubClearDTTmp($aDataWhere);
        }

        $aResInsDTFhn = $this->mAdjustStockSub->FSaMAdjStkSubInsertTmpToDTFhn($aDataWhere);
        if($aResInsDTFhn['rtCode'] == '1'){
            $this->mAdjustStockSub->FSxMAdjStkSubClearDTFhnTmp($aDataWhere);
        }

    }

    // Functionality : Event Delete Master
    public function FSaCASTDeleteEvent(){

        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTAjhDocNo' => $tIDCode
        );
        $aResDel    = $this->mAdjustStockSub->FSnMAdjStkSubDel($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);

    }

    // Function : Remove Master Pdt Intable (File)
    public function FSvCAdjStkSubRemovePdtInDTTmp(){

        $aDataWhere = array(
            'FTAjhDocNo'    => $this->input->post('ptXthDocNo'),
            'FTPdtCode'     => $this->input->post('ptPdtCode'),
            'FNXtdSeqNo'    => $this->input->post('ptSeqno'),
            'FTSessionID'   => $this->session->userdata('tSesSessionID'),
            'FTXthDocKey'   => 'TCNTPdtAdjStkDT'
        );

        $aResDel = $this->mAdjustStockSub->FSnMAdjStkSubDelDTTmp($aDataWhere);
        echo json_encode($aResDel);
    }

    // Function : เรียกหน้า  Add
    public function FSxCAdjStkSubAddPage(){

        // Clear in temp
        $aDataClearTmp = array(
            'FTAjhDocNo'    => '',
            'FTSessionID'   => $this->session->userdata('tSesSessionID'),
            'FTXthDocKey'   => 'TCNTPdtAdjStkDT',
            'tDeleteType'   => '1'
        );
        $this->mAdjustStockSub->FSxMAdjStkSubClearDTTmp($aDataClearTmp);
        $this->mAdjustStockSub->FSxMAdjStkSubClearDTFhnTmp($aDataClearTmp);
        
        $aLocationList = $this->mAdjustStockSub->FSaMAdjStkSubGetLocation($aDataClearTmp);

        // Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        // Get Option Scan SKU
        $nOptDocSave = FCNnHGetOptionDocSave();
        // Get Option Scan SKU
        $nOptScanSku = FCNnHGetOptionScanSku();

        $aPermission = FCNaHCheckAlwFunc("adjStkSub/0/0");
        $aDataRenderView = array(
            'nOptDecimalShow'   => $nOptDecimalShow,
            'nOptDocSave'       => $nOptDocSave,
            'nOptScanSku'       => $nOptScanSku,
            'aResult'           => array('rtCode' => '99'),
            'aPermission'       => $aPermission,
            'aLocationList'     => $aLocationList
        );
        $this->load->view('document/adjuststocksub/wAdjustStockSubAdd', $aDataRenderView);

    }

    // Functionality : Event Add Master
    // Last Update : Napat(Jame) 2020/07/17
    public function FSaCAdjStkSubAddEvent(){
        try{
            $aDataDocument = $this->input->post();

            $tAjhDocDate    = $this->input->post('oetAdjStkSubAjhDocDate')." ".$this->input->post('oetAdjStkSubAjhDocTime');
            $tUserCode      = $this->session->userdata('tSesUserCode');
            $tUserName      = $this->session->userdata('tSesUsername');
            $tIsAutoGenCode = $this->input->post('ocbAdjStkSubSubAutoGenCode'); // ต้องการรัน DocNo อัตโนมัติหรือไม่
            $aDataLocation  = $this->input->post('ocbAdjStkSubPlcCode');

            $nCheckDateTime = $this->mAdjustStockSub->FSnMASTCheckDateTimeTmpDT();
            if( $nCheckDateTime > 0 ){
                $aReturn = array(
                    'nStaEvent'    => '905',
                    'tStaMessg'    => "มีสินค้าบางรายการ ยังไม่ระบุวันเวลาตรวจนับ ต้องการให้ระบุเป็นวันที่ปัจจุบันหรือไม่ ?"
                );
                echo json_encode($aReturn);
                return false;
            }

            if(FCNnHSizeOf($aDataLocation) == 1){
                $tPlcCode = $aDataLocation[0];
            }else{
                $tPlcCode = "NULL";
            }

            $aDataMaster = array(
                'FTBchCode'             => $this->input->post('ohdAdjStkSubBchCodeTo'),
                'FTAjhDocNo'            => $this->input->post('oetAdjStkSubAjhDocNo'),
                'FNAjhDocType'          => 11, // ประเภทใบนับสต๊อก
                'FTAjhDocType'          => '1', // ประเภทใบนับย่อย
                'FDAjhDocDate'          => $tAjhDocDate,
                'FTAjhBchTo'            => $this->input->post('ohdAdjStkSubBchCodeTo'), // นับภายใต้สาขา
                // 'FFAjhMerchantTo'       => $this->input->post('oetAdjStkSubMchCode'), // นับภายใต้กลุ่มร้านค้า
                // 'FTAjhShopTo'           => $this->input->post('oetAdjStkSubShpCode'), // นับภายใต้ร้านค้า
                // 'FTAjhPosTo'            => $this->input->post('oetAdjStkSubPosCode'), // นับภายใต้เครื่องจุดขาย
                'FTAjhWhTo'             => $this->input->post('oetAdjStkSubWahCodeTo'), // นับภายใตัคลัง
                'FTAjhPlcCode'          => $tPlcCode, // นับภายใต้ Location
                'FTDptCode'             => $this->session->userdata("tSesUsrDptCode"), // แผนกที่ ผู้ใช้ login
                'FTUsrCode'             => $tUserCode, // User Login
                'FTRsnCode'             => $this->input->post('oetAdjStkSubReasonCode'), // เหตุผลการตรวจนับ
                'FTAjhRmk'              => $this->input->post('otaAdjStkSubAjhRmk'), // หมายเหตุ
                'FTAjhApvSeqChk'        => NULL, // ใช้การตรวจนับ 1:นับ 1, 2:นับ2, 3:กำหนดเอง
                // 'FTAjhApvSeqChk'        => $this->input->post('ocmAdjStkSubCheckTime'), // ใช้การตรวจนับ 1:นับ 1, 2:นับ2, 3:กำหนดเอง
                'FTAjhApvCode'          => NULL,
                'FTAjhStaApv'           => NULL,
                'FTAjhStaPrcStk'        => NULL,
                'FTAjhStaDoc'           => '1', // สถานะเอกสาร สมบูรณ์
                'FNAjhStaDocAct'        => !empty($aDataDocument['ocbAdjStkSubStaDocAct']) ? $aDataDocument['ocbAdjStkSubStaDocAct'] : 0,
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FTCreateBy'            => $tUserName,
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FTLastUpdBy'           => $tUserName
            );

            // Check Auto GenCode
            if( isset($tIsAutoGenCode) && $tIsAutoGenCode == '1' ){
                $aStoreParam = array(
                    "tTblName"    => 'TCNTPdtAdjStkHD',
                    "tDocType"    => '1',
                    "tBchCode"    => $this->input->post('ohdAdjStkSubBchCodeTo'),
                    "tShpCode"    => "",
                    "tPosCode"    => "",
                    "dDocDate"    => date("Y-m-d")
                );
                $aAutogen                   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTAjhDocNo']  = $aAutogen[0]["FTXxhDocNo"];
            }else{
                $aDataMaster['FTAjhDocNo'] = $this->input->post('oetAdjStkSubAjhDocNo');
            }

            // Check Duplicate In HD
            // $aChkDup = $this->FSnMAdjStkSubCheckDuplicate($aDataMaster['FTAjhDocNo']);
            // if( FCNnHSizeOf($aChkDup) > 0 ){
            //     $aReturn = array(
            //         'nStaEvent'	    => '900',
            //         'tStaMessg'		=> 'รหัสซ้ำ'
            //     );
            //     echo json_encode($aReturn);
            //     exit;
            // }


            $aDataWhere = array(
                'FTAjhDocNo'    => $aDataMaster['FTAjhDocNo'],
                'FTXthDocKey'   => 'TCNTPdtAdjStkDT'
            );
          
            $this->db->trans_begin();
            /*======================= Begin Data Process =====================*/

            $this->mAdjustStockSub->FSaMAdjStkSubAddUpdateHD($aDataMaster);
            $this->mAdjustStockSub->FSaMAdjStkSubAddUpdateDocNoInDocTemp($aDataWhere); // Update DocNo ในตาราง Doctemp
            $this->FSaCAdjStkSubAddTmpToDT($aDataMaster['FTAjhDocNo']); // Temp to DT and Clear Temp

            /*========================= End Data Process =====================*/

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTAjhDocNo'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Function : เรียกหน้า  Edit
    public function FSvCAdjStkSubEditPage(){

        // Lang ภาษา
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $aDataSearch = array(
            'FTAjhDocNo'    => $this->input->post('ptAjhDocNo'),
            'FNLngID'       => $nLangEdit,
            'FTUsrCode'     => $this->session->userdata('tSesUsername'),
            'FTXthDocKey'   => 'TCNTPdtAdjStkDT',
            'FTSessionID'   => $this->session->userdata("tSesSessionID"),
            'nRow'          => 10000,
            'nPage'         => 1
        );

        $aPermission = FCNaHCheckAlwFunc("adjStkSub/0/0");
        // Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        // Get Option Scan SKU
        $nOptDocSave = FCNnHGetOptionDocSave();
        // Get Option Scan SKU
        $nOptScanSku = FCNnHGetOptionScanSku();

        // Get All Location
        $aLocationList = $this->mAdjustStockSub->FSaMAdjStkSubGetLocation($aDataSearch);

        // Get Data
        $aAdjStkSubHD = $this->mAdjustStockSub->FSaMAdjStkSubGetHD($aDataSearch); // GET Data TCNTPdtAdjStkHD
        $this->mAdjustStockSub->FSaMAdjStkSubInsertDTToTemp($aDataSearch); // Insert Data DocTemp
        $this->mAdjustStockSub->FSaMAdjStkSubInsertDTFhnToTemp($aDataSearch); // Insert Data DocTemp

        $aDataEdit = array(
            'nOptDecimalShow'   => $nOptDecimalShow,
            'nOptDocSave'       => $nOptDocSave,
            'nOptScanSku'       => $nOptScanSku,
            'aResult'           => $aAdjStkSubHD,
            'aPermission'       => $aPermission,
            'aLocationList'     => $aLocationList
        );
        $this->load->view('document/adjuststocksub/wAdjustStockSubAdd', $aDataEdit);

    }

    // Functionality : Event Edit Master
    public function FSaCAdjStkSubEditEvent(){
        try{
            $aDataDocument = $this->input->post();
            $tUserCode      = $this->session->userdata('tSesUserCode');
            $tUserName      = $this->session->userdata('tSesUsername');

            $aDataLocation  = $this->input->post('ocbAdjStkSubPlcCode');

            if(FCNnHSizeOf($aDataLocation) == 1){
                $tPlcCode = $aDataLocation[0];
            }else{
                $tPlcCode = "NULL";
            }

            $aDataMaster    = array(
                'FTBchCode'             => $this->input->post('ohdAdjStkSubBchCodeTo'), //$this->input->post('ohdAdjStkSubBchCodeCreate')
                'FTAjhDocNo'            => $this->input->post('oetAdjStkSubAjhDocNo'),
                'FNAjhDocType'          => 11, // ประเภทใบนับสต๊อก
                'FTAjhDocType'          => '1', // ประเภทใบนับย่อย
                'FDAjhDocDate'          => $this->input->post('oetAdjStkSubAjhDocDate')." ".$this->input->post('oetAdjStkSubAjhDocTime'),
                'FTAjhBchTo'            => $this->input->post('ohdAdjStkSubBchCodeTo'), // นับภายใต้สาขา
                // 'FFAjhMerchantTo'       => $this->input->post('oetAdjStkSubMchCode'), // นับภายใต้กลุ่มร้านค้า
                // 'FTAjhShopTo'           => $this->input->post('oetAdjStkSubShpCode'), // นับภายใต้ร้านค้า
                // 'FTAjhPosTo'            => $this->input->post('oetAdjStkSubPosCode'), // นับภายใต้เครื่องจุดขาย
                'FTAjhWhTo'             => $this->input->post('oetAdjStkSubWahCodeTo'), // นับภายใตัคลัง
                'FTAjhPlcCode'          => $tPlcCode, // นับภายใตั Location
                'FTDptCode'             => $this->session->userdata("tSesUsrDptCode"), // แผนกที่ ผู้ใช้ login
                'FTUsrCode'             => $tUserCode, // User Login
                'FTRsnCode'             => $this->input->post('oetAdjStkSubReasonCode'), // เหตุผลการตรวจนับ
                'FTAjhRmk'              => $this->input->post('otaAdjStkSubAjhRmk'), // หมายเหตุ
                'FTAjhApvSeqChk'        => NULL, // ใช้การตรวจนับ 1:นับ 1, 2:นับ2, 3:กำหนดเอง
                // 'FTAjhApvSeqChk'        => $this->input->post('ocmAdjStkSubCheckTime'), // ใช้การตรวจนับ 1:นับ 1, 2:นับ2, 3:กำหนดเอง
                'FTAjhApvCode'          => NULL,
                'FTAjhStaApv'           => NULL,
                'FTAjhStaPrcStk'        => NULL,
                'FTAjhStaDoc'           => '1', // สถานะเอกสาร สมบูรณ์
                'FNAjhStaDocAct'        => !empty($aDataDocument['ocbAdjStkSubStaDocAct']) ? $aDataDocument['ocbAdjStkSubStaDocAct'] : 0,
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FTCreateBy'            => $tUserName,
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FTLastUpdBy'           => $tUserName
            );

            $this->db->trans_begin();

            $this->mAdjustStockSub->FSaMAdjStkSubAddUpdateHD($aDataMaster);
            $this->FSaCAdjStkSubAddTmpToDT($aDataMaster['FTAjhDocNo']);

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTAjhDocNo'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }


    }

    //////////////////////////////////////////////////////////////////////////   Zone Advacne Table
    // Functionality : Function Call DataTables List Master
    public function FSxCAdjStkSubDataTable(){

        $oAdvanceSearch     = $this->input->post('oAdvanceSearch');
        $nPage              = $this->input->post('nPageCurrent');

        // Lang ภาษา
        $nLangEdit          = $this->session->userdata("tLangEdit");
        // Controle Event
        $aAlwEvent          = FCNaHCheckAlwFunc('AdjStkSub/0/0');
        // Get Option Show Decimal
        $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

        if($nPage == '' || $nPage == null){
            $nPage = 1;
        }else{
            $nPage = $this->input->post('nPageCurrent');
        }

        $aDataSearch  = array(
            'FNLngID'           => $nLangEdit,
            'nPage'             => $nPage,
            'nRow'              => 10,
            'oAdvanceSearch'    => $oAdvanceSearch
        );
        $aResList   = $this->mAdjustStockSub->FSaMAdjStkSubList($aDataSearch);
        $aGenTable  = array(
            'aAlwEvent'     => $aAlwEvent,
            'aDataList'     => $aResList,
            'nPage'         => $nPage,
            'nOptDecimalShow'=> $nOptDecimalShow
        );
        $this->load->view('document/adjuststocksub/wAdjustStockSubDataTable',$aGenTable);
    }

    // Function : Adv Table Load Data
    public function FSvCAdjStkSubPdtAdvTblLoadData(){
        $tSearchAll     = $this->input->post('tSearchAll');
        $tAjhDocNo      = $this->input->post('tAjhDocNo');
        $tAjhStaApv     = $this->input->post('tAjhStaApv');
        $tAjhStaDoc     = $this->input->post('tAjhStaDoc');
        $nPage          = $this->input->post('nPageCurrent');

        $aDataWhere = array(
            'tSearchAll'    => $tSearchAll,
            'FTAjhDocNo'    => $tAjhDocNo,
            'FTXthDocKey'   => 'TCNTPdtAdjStkDT',
            'nPage'         => $nPage,
            'nRow'          => 20,
            'FTSessionID'   => $this->session->userdata('tSesSessionID')
        );

        // Edit in line
        $tPdtCode = $this->input->post('ptPdtCode');
        $tPunCode = $this->input->post('ptPunCode');

        // Get Option Show Decimal
        $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

        $aColumnShow = array(

            (object) array('FNShwSeq' => 1,  'FTShwFedShw' => 'FTXtdPdtName',       'FTShwNameUsr' => 'ชื่อสินค้า',     'FTShwFedStaUsed' => '1','FNShwColWidth' => 0,'FTShwStaAlwEdit' => 0),
            // (object) array('FNShwSeq' => 2,  'FTShwFedShw' => 'FTXtdBarCode',       'FTShwNameUsr' => 'รหัสบาร์โค้ด',  'FTShwFedStaUsed' => '1','FNShwColWidth' => 0,'FTShwStaAlwEdit' => 0),
            (object) array('FNShwSeq' => 2,  'FTShwFedShw' => 'FTAjdPlcCode',       'FTShwNameUsr' => 'ที่เก็บ',       'FTShwFedStaUsed' => '1','FNShwColWidth' => 0,'FTShwStaAlwEdit' => 0),
            (object) array('FNShwSeq' => 3,  'FTShwFedShw' => 'FTPunName',          'FTShwNameUsr' => 'หน่วย',       'FTShwFedStaUsed' => '1','FNShwColWidth' => 0,'FTShwStaAlwEdit' => 0),
            (object) array('FNShwSeq' => 4,  'FTShwFedShw' => 'FCPdtUnitFact',      'FTShwNameUsr' => 'อัตราส่วน',    'FTShwFedStaUsed' => '1','FNShwColWidth' => 0,'FTShwStaAlwEdit' => 0),

            (object) array('FNShwSeq' => 5,  'FTShwFedShw' => 'FTAjdUnitDateC1',    'FTShwNameUsr' => 'วันที่นับ 1',    'FTShwFedStaUsed' => '1','FNShwColWidth' => 100, 'FNDiffTableFixed' => 460,'FTShwStaAlwEdit' => 1, 'FTStaFocusEdit' => 0),
            (object) array('FNShwSeq' => 6,  'FTShwFedShw' => 'FTAjdUnitTimeC1',    'FTShwNameUsr' => 'เวลานับ 1',    'FTShwFedStaUsed' => '1','FNShwColWidth' => 100, 'FNDiffTableFixed' => 360,'FTShwStaAlwEdit' => 1, 'FTStaFocusEdit' => 0),
            (object) array('FNShwSeq' => 7,  'FTShwFedShw' => 'FCAjdUnitQtyC1',     'FTShwNameUsr' => 'นับ 1',       'FTShwFedStaUsed' => '1','FNShwColWidth' => 80, 'FNDiffTableFixed' => 280,'FTShwStaAlwEdit' => 1, 'FTStaFocusEdit' => 1),

            (object) array('FNShwSeq' => 8,  'FTShwFedShw' => 'FTAjdUnitDateC2',    'FTShwNameUsr' => 'วันที่นับ 2',    'FTShwFedStaUsed' => '1','FNShwColWidth' => 100, 'FNDiffTableFixed' => 180,'FTShwStaAlwEdit' => 1, 'FTStaFocusEdit' => 0),
            (object) array('FNShwSeq' => 9, 'FTShwFedShw' => 'FTAjdUnitTimeC2',    'FTShwNameUsr' => 'เวลานับ 2',    'FTShwFedStaUsed' => '1','FNShwColWidth' => 100, 'FNDiffTableFixed' => 80,'FTShwStaAlwEdit' => 1, 'FTStaFocusEdit' => 0),
            (object) array('FNShwSeq' => 10, 'FTShwFedShw' => 'FCAjdUnitQtyC2',     'FTShwNameUsr' => 'นับ 2',       'FTShwFedStaUsed' => '1','FNShwColWidth' => 80, 'FNDiffTableFixed' => 0,'FTShwStaAlwEdit' => 1, 'FTStaFocusEdit' => 1),

        );

        $aDataDT = $this->mAdjustStockSub->FSaMAdjStkSubGetDTTempListPage($aDataWhere);
        $aData['nOptDecimalShow']   = $nOptDecimalShow;
        $aData['aColumnShow']       = $aColumnShow;
        $aData['tPdtCode']          = $tPdtCode;
        $aData['tPunCode']          = $tPunCode;
        $aData['aDataDT']           = $aDataDT;
        $aData['tAjhStaApv']        = $tAjhStaApv;
        $aData['tAjhStaDoc']        = $tAjhStaDoc;
        $aData['nPage']             = $nPage;

        $this->load->view('document/adjuststocksub/advancetable/wAdjustStockSubPdtAdvTableData', $aData);

    }

    // Function : ค้นหา รายการ
    // Last Update By : Napat(Jame) 2020/07/23
    public function FSxCAdjStkSubFormSearchList(){
        $this->load->view('document/adjuststocksub/wAdjustStockSubFormSearchList');
    }

    /**
     * Functionality : Event Delete Product
     * Parameters : Ajax jReason()
     * Creator : 22/05/2019 Piya
     * Return : Status Delete Event
     * Return Type : String
     */
    public function FSvCAdjStkSubPdtMultiDeleteEvent(){
        $FTAjhDocNo = $this->input->post('tDocNo');
        // $FTPdtCode  = $this->input->post('tPdtCode');
        // $FTPunCode  = $this->input->post('tPunCode');
        $aSeqCode   = $this->input->post('tSeqCode');
        $tSession   = $this->session->userdata('tSesSessionID');
        $nCount     = FCNnHSizeOf($aSeqCode);

        if($nCount > 1){

            for($i=0; $i<$nCount; $i++){

                $aDataMaster = array(
                    'FTAjhDocNo'    => $FTAjhDocNo,
                    'FNXtdSeqNo'    => $aSeqCode[$i],
                    'FTXthDocKey'   => 'TCNTPdtAdjStkDT',
                    'FTSessionID'   => $tSession
                );
                $aResDel = $this->mAdjustStockSub->FSaMAdjStkSubPdtTmpMultiDel($aDataMaster);
            }

        }else{

            $aDataMaster = array(
                'FTAjhDocNo'    => $FTAjhDocNo,
                'FNXtdSeqNo'    => $aSeqCode[0],
                'FTXthDocKey'   => 'TCNTPdtAdjStkDT',
                'FTSessionID'   => $tSession
            );
            $aResDel = $this->mAdjustStockSub->FSaMAdjStkSubPdtTmpMultiDel($aDataMaster);
        }

        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    // Function : Cancel Doc
    // Last Update By : Napat(Jame) 2020/07/23
    public function FSvCAdjStkSubCancel(){

        $aDataUpdate = array(
            'FTAjhDocNo' => $this->input->post('tXthDocNo'),
        );
        $aStaApv = $this->mAdjustStockSub->FSvMAdjStkSubCancel($aDataUpdate);
        if($aStaApv['rtCode'] == 1){
            $aApv = array(
                'nSta' => 1,
                'tMsg' => "Cancel done.",
            );
        }else{
            $aApv = array(
                'nSta' => 2,
                'tMsg' => "Not Cancel.",
            );
        }
        echo json_encode($aApv);

    }

    // Create By Napat(Jame) 2020/07/17
    // นำสินค้าจาก Filter Condition เพิ่มลงตาราง TCNTDocDTTmp
    public function FSaCASTEventAddProducts(){
        try{

            $this->db->trans_begin();

            // Clear Temp Before Insert
            $aDataClear = array(
                'FTXthDocKey'   => 'TCNTPdtAdjStkDT',
                'FTSessionID'   => $this->session->userdata('tSesSessionID'),
                'tDeleteType'   => '1'
            );
            $this->mAdjustStockSub->FSxMAdjStkSubClearDTTmp($aDataClear);

            // settings variable
            $aDataCondition = $this->input->post('paCondition');
            $aDataLocation  = $this->input->post('paLocation');
            $aGetDataInsert = $this->input->post('paDataInsert');

            // ถ้าเลือก Condition ที่เก็บ ฝั่งซ้ายมือ ก็ให้ทำการ loop insert location
            // ถ้าเลือก ที่เก็บ จาก Filter Condition Data ให้ข้ามขั้นตอนการ loop
            if( isset($aDataLocation) && !empty($aDataLocation) && FCNnHSizeOf($aDataLocation) > 0 && empty($aDataCondition['oetASTFilterPlcCode'])){
                for($i=0;FCNnHSizeOf($aDataLocation) > $i;$i++){
                    $aDataInsert = array(
                        'FTBchCode'     => $aGetDataInsert['tBchCode'],
                        'FTXthDocNo'    => $aGetDataInsert['tDocNo'],
                        'FTXthDocKey'   => 'TCNTPdtAdjStkDT',
                        'FTSessionID'   => $this->session->userdata('tSesSessionID'),
                        'tUser'         => $this->session->userdata('tSesUsername'),
                        'FTAjdPlcCode'  => $aDataLocation[$i]
                    );
                    $aResultPDT = $this->mAdjustStockSub->FSaMASTEventAddProducts($aDataCondition,$aDataInsert);
                }
            }else{
                $aDataInsert = array(
                    'FTBchCode'     => $aGetDataInsert['tBchCode'],
                    'FTXthDocNo'    => $aGetDataInsert['tDocNo'],
                    'FTXthDocKey'   => 'TCNTPdtAdjStkDT',
                    'FTSessionID'   => $this->session->userdata('tSesSessionID'),
                    'tUser'         => $this->session->userdata('tSesUsername'),
                    'FTAjdPlcCode'  => ''
                );
                $aResultPDT = $this->mAdjustStockSub->FSaMASTEventAddProducts($aDataCondition,$aDataInsert);
            }

            $aPdtCallBackFunction = $this->FSaCAdjStkCreateForamatReturn($aResultPDT['aPDtList']);
            $aResultPDT['aPdtCallBackFunction'] = $aPdtCallBackFunction;
            // tCode = 1 insert สำเร็จ
            // tCode = 2 insert สำเร็จ และเคลียร์ checkbox location condition ซ้ายมือ
            if($aResultPDT['tCode'] == '1' || $aResultPDT['tCode'] == '2'){
                $this->db->trans_commit();
            }else{
                $this->db->trans_rollback();
            }
            echo json_encode($aResultPDT);

        }catch(Exception $Error){
            echo $Error;
        }
    }



    // Create By Nattakit(Nale) 2021/05/13
    // นำสินค้าจาก Filter Condition เพิ่มลงตาราง TCNTDocDTTmpFhn
    public function FSaCASTEventAddProductsFashion(){
        try{

            // $this->db->trans_begin();

            // Clear Temp Before Insert
            $aDataClear = array(
                'FTXthDocKey'   => 'TCNTPdtAdjStkDT',
                'FTSessionID'   => $this->session->userdata('tSesSessionID'),
                'tDeleteType'   => '1'
            );
            $this->mAdjustStockSub->FSxMAdjStkSubClearDTFhnTmp($aDataClear);

            // settings variable
            $aDataDTFhn  = $this->input->post('paDataDTFhn');
            $aGetDataInsert = $this->input->post('paDataInsert');

            if($aDataDTFhn['tType']=='confirm'){
                if(!empty($aDataDTFhn['aResult']['tPDTCode'])){
                        foreach($aDataDTFhn['aResult']['tPDTCode'] as $aDataDtFhn){
                            if(!empty($aDataDtFhn)){
                                    foreach($aDataDtFhn as $nKey => $aDataPDtRefCode){
                               

                                        $aDataInsert = array(
                                            'FTBchCode'       => $aGetDataInsert['tBchCode'],
                                            'FTXshDocNo'      => $aGetDataInsert['tDocNo'],
                                            'FTXthDocKey'     => 'TCNTPdtAdjStkDT',
                                            'FTPdtCode'       => $aDataPDtRefCode['FTPdtCode'],
                                            'FTFhnRefCode'    => $aDataPDtRefCode['FTFhnRefCode'],
                                            'FTXtdPdtName'    => $aDataPDtRefCode['FTPdtName'],
                                            'FTXtdBarCode'    => $aDataPDtRefCode['RetBarCode'],
                                            'FDAjdDateTimeC1' => date('Y-m-d H:i:s'),
                                            'FCAjdUnitQtyC1'  => 0 ,
                                            'FCAjdQtyAllC1'   => 0 ,
                                            'FDAjdDateTimeC2' => date('Y-m-d H:i:s'),
                                            'FCAjdUnitQtyC2'  => 0 ,
                                            'FCAjdQtyAllC2'   => 0 ,
                                            'FTSessionID'     => $this->session->userdata('tSesSessionID'),
                                            'FDCreateOn'      => date('Y-m-d H:i:s'),
                                            'FTCreateBy'      => $this->session->userdata('tSesUsername'),
                                        );
                                        $aDataGetSeq = array(
                                            'FTBchCode'       => $aGetDataInsert['tBchCode'],
                                            'FTXshDocNo'      => $aGetDataInsert['tDocNo'],
                                            'FTXthDocKey'     => 'TCNTPdtAdjStkDT',
                                            'FTPdtCode'       => $aDataPDtRefCode['FTPdtCode'],
                                            'FTPunCode'       => $aDataPDtRefCode['RetPunCode'],
                                            'FTXtdBarCode'    => $aDataPDtRefCode['RetBarCode'],
                                            'FTSessionID'     => $this->session->userdata('tSesSessionID'),
                                        );
                                        $nDTTempSeq = $this->mAdjustStockSub->FSnMASTGetSeqDTTemp($aDataGetSeq);
                                        $aDataInsert['FNXsdSeqNo'] = $nDTTempSeq;
                                        // echo '<pre>';
                                        // print_r($aDataInsert);
                                        // echo '</pre>';
                                        // echo '<hr>';
                                        $aResultPDT = $this->mAdjustStockSub->FSaMASTEventAddProductsFashion($aDataInsert);
                                        // echo '<pre>';
                                        // print_r($aResultPDT);
                                        // echo '</pre>';
                                }



                            }
                        }

                }
            }

            // tCode = 1 insert สำเร็จ
            // tCode = 2 insert สำเร็จ และเคลียร์ checkbox location condition ซ้ายมือ
            if($aResultPDT['rtCode'] == '1'){
                $this->db->trans_commit();
                // echo 1;
            }else{
                // echo 2;
                $this->db->trans_rollback();
            }
            echo json_encode($aResultPDT);

        }catch(Exception $Error){
            echo $Error;
        }
    }

 // Create By Nattakit(Nale) 2021/05/14
    public function FSaCASTEventEditProductsFashion(){

            // settings variable
            $aDataDTFhn  = $this->input->post('paDataDTFhn');
            $aGetDataInsert = $this->input->post('paDataInsert');
            $nCout = $this->input->post('pnCout');
            $nSumQty = 0;
            if($aDataDTFhn['tType']=='confirm'){
                if(!empty($aDataDTFhn['aResult'])){
                        foreach($aDataDTFhn['aResult'] as $aDataPdtFhn){
                            $aDataInsert = array(
                                'FTBchCode'     => $aGetDataInsert['tBchCode'],
                                'FTXshDocNo'    => $aGetDataInsert['tDocNo'],
                                'FTXthDocKey'   => 'TCNTPdtAdjStkDT',
                                'FTPdtCode'     => $aDataPdtFhn['tPDTCode'],
                                'FNXsdSeqNo'    => $aDataPdtFhn['nDTSeq'],
                                'FTFhnRefCode'  => $aDataPdtFhn['tRefCode'],
                                'FTXtdBarCode'  => $aDataPdtFhn['tBarCode'],
                                'FTSessionID'   => $this->session->userdata('tSesSessionID'),
                                'FDCreateOn'    => date('Y-m-d H:i:s'),
                                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                            );
                                //หา factor ของ DT
                             $nPdtUnitFact =  $this->mAdjustStockSub->FSnMASTGetPdtUnitFactDTTemp($aDataInsert);

                              $nSumQty = $nSumQty + $aDataPdtFhn['nQtyAdj'];
                            if($nCout==1){
                              $aDataInsert['FDAjdDateTimeC1'] = $aDataPdtFhn['tDateAdj'].' '.$aDataPdtFhn['tTimeAdj'];
                              $aDataInsert['FCAjdUnitQtyC1']  = $aDataPdtFhn['nQtyAdj'];
                              $aDataInsert['FCAjdQtyAllC1']   = $aDataPdtFhn['nQtyAdj'] * $nPdtUnitFact;
                            }else if($nCout==2){
                              $aDataInsert['FDAjdDateTimeC2'] = $aDataPdtFhn['tDateAdj'].' '.$aDataPdtFhn['tTimeAdj'];
                              $aDataInsert['FCAjdUnitQtyC2']  = $aDataPdtFhn['nQtyAdj'];
                              $aDataInsert['FCAjdQtyAllC2']   = $aDataPdtFhn['nQtyAdj'] * $nPdtUnitFact;
                            }
                
                            $aResultPDT = $this->mAdjustStockSub->FSaMASTEventAddProductsFashion($aDataInsert);
                        }

                        $aDataUpdateDTTmp = array(
                            'FTBchCode'     => $aGetDataInsert['tBchCode'],
                            'FTXthDocNo'    => $aGetDataInsert['tDocNo'],
                            'FTXthDocKey'   => 'TCNTPdtAdjStkDT',
                            'FTPdtCode'     => $aDataInsert['FTPdtCode'],
                            'FNXtdSeqNo'    => $aDataInsert['FNXsdSeqNo'],
                            'FTSessionID'   => $this->session->userdata('tSesSessionID'),
                            'FDCreateOn'    => date('Y-m-d H:i:s'),
                            'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        );
                        if($nCout==1){
                            $aDataUpdateDTTmp['FDAjdDateTimeC1'] = $aDataInsert['FDAjdDateTimeC1'];
                            $aDataUpdateDTTmp['FCAjdUnitQtyC1']  = $nSumQty;
                            $aDataUpdateDTTmp['FCAjdQtyAllC1']   = $nSumQty * $nPdtUnitFact;
                          }else if($nCout==2){
                            $aDataUpdateDTTmp['FDAjdDateTimeC2'] = $aDataInsert['FDAjdDateTimeC2'];
                            $aDataUpdateDTTmp['FCAjdUnitQtyC2']  = $nSumQty;
                            $aDataUpdateDTTmp['FCAjdQtyAllC2']   = $nSumQty * $nPdtUnitFact;
                          }
                        $aResultPDT = $this->mAdjustStockSub->FSaMASTEventUpdateDTTmp($aDataUpdateDTTmp);
                }
            }
    }

  // Create By Nattakit(Nale) 2021/05/13
    public function FSaCAdjStkCreateForamatReturn($paPDtList){
        $aPdtCallBackFunction = array();
        if(!empty($paPDtList)){
            foreach($paPDtList as $nKey => $aDataPdtList ){
                    $aPdtCallBackFunction[$nKey]['pnPdtCode'] = $aDataPdtList['FTPdtCode'];
                    $aPdtCallBackFunction[$nKey]['ptPunCode'] = $aDataPdtList['FTPunCode'];
                    $aPdtCallBackFunction[$nKey]['ptBarCode'] = $aDataPdtList['FTBarCode'];
                    $aPdtCallBackFunction[$nKey]['packData'] = array(
                        "PDTCode" => $aDataPdtList['FTPdtCode'],
                        'PUNCode' => $aDataPdtList['FTPunCode'],
                        'Barcode' => $aDataPdtList['FTBarCode'],
                        "PDTName" => $aDataPdtList['FTPdtName'],
                        "PDTSpc" => $aDataPdtList['PDTSpc'],
                    );
            }

        }
        return $aPdtCallBackFunction;
    }

    // Create By Napat(Jame) 2020/07/20
    public function FSxCASTEditInLine(){


        if( $this->input->post('pdDate') == "" || $this->input->post('ptTime') == "" ){
            $dDateTime = '';
        }else{
            $dDateTime = $this->input->post('pdDate').' '.$this->input->post('ptTime');
        }

        $aDataQuery = array(
            'FTIuhDocNo'            => $this->input->post('ptDocNo'),
            'FTXthDocKey'           => 'TCNTPdtAdjStkDT',
            'FTSessionID'           => $this->session->userdata('tSesSessionID'),

            'tField'                => $this->input->post('ptField'),
            'nSeq'                  => $this->input->post('pnSeq'),
            'tValue'                => $this->input->post('pnVal'),
            'tChkDateTime'          => $dDateTime
        );
        $aEditInLine = $this->mAdjustStockSub->FSaMASTEditInLine($aDataQuery);
        echo json_encode($aEditInLine);
    }

    // Function : Approve Doc
    // Create By : Napat(Jame) 2020/07/20
    public function FSaCASTApprove(){

        $aDataUpdate = array(
            'FTAjhStaPrcStk' => '1',
            'FTAjhDocNo'    => $this->input->post('tXthDocNo'),
            'FTAjhStaApv'   => 1,
            'FTAjhApvCode'  => $this->session->userdata('tSesUsername'),
            'FDLastUpdOn'   => date('Y-m-d H:i:s'),
            'FTLastUpdBy'   => $this->session->userdata('tSesUsername')
        );
        $aStaApv = $this->mAdjustStockSub->FSaMAdjStkSubApprove($aDataUpdate);
        echo json_encode($aStaApv);

    }

    // Create By : Napat(Jame) 2020/07/23
    public function FSaCASTUpdateDateTime(){
        $aStaApv = $this->mAdjustStockSub->FSaMASTUpdateDateTime();
        echo json_encode($aStaApv);
    }

}
