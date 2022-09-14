<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cTransferBchOutPdt extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/transfer_branch_out/mTransferBchOutPdt');
        $this->load->model('document/transfer_branch_out/mTransferBchOut');
    }

    /**
     * Functionality : Get Pdt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSxCTransferBchOutGetPdtInTmp()
    {
        $tSearchAll = $this->input->post('tSearchAll');
        $tIsApvOrCancel = $this->input->post('tIsApvOrCancel');
        $nPage = $this->input->post('nPageCurrent');
        $aAlwEvent = FCNaHCheckAlwFunc('docTransferBchOut/0/0');
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tDocNo = 'TBODOCTEMP';
        $tDocKey = 'TCNTPdtTboHD';
        $tStaPrcDoc = $this->input->post('ptStaPrcDoc');

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }
        $nLangEdit = $this->session->userdata("tLangEdit");

        // $aColumnShow = FCNaDCLGetColumnShow('TCNTPdtTboDT');

        $bIsAddPage = $this->input->post('pbIsAddPage');
        $tTBODocNo  = $this->input->post('ptDocNo');

        // ตรวจสอบว่าใบจ่ายโอน-สาขา มีการสร้างใบจัดสินค้าไหม ?
        // ถ้ามีใบจัด จะแสดง คอลัม จำนวนสั่ง, จำนวนจัด
        $aChkHDDocRef = $this->mTransferBchOutPdt->FSbMTBOChkHaveHDDocRef($tTBODocNo);
        
        // var_dump($bIsAddPage);exit;
        if( $bIsAddPage == 'false' && $aChkHDDocRef === true ){
            $aColumnShow = array(
                (object) array('FNShwSeq' => 1,  'FTShwFedShw' => 'FNXtdSeqNo',         'FTShwNameUsr' => 'ลำดับ',     'FTShwFedStaUsed' => '1','FNShwColWidth' => 0,'FTShwStaAlwEdit' => 0),
                (object) array('FNShwSeq' => 2,  'FTShwFedShw' => 'FTPdtCode',          'FTShwNameUsr' => 'รหัสสินค้า',     'FTShwFedStaUsed' => '1','FNShwColWidth' => 0,'FTShwStaAlwEdit' => 0),
                (object) array('FNShwSeq' => 3,  'FTShwFedShw' => 'FTXtdPdtName',       'FTShwNameUsr' => 'ชื่อสินค้า',  'FTShwFedStaUsed' => '1','FNShwColWidth' => 0,'FTShwStaAlwEdit' => 0),
                (object) array('FNShwSeq' => 4,  'FTShwFedShw' => 'FTXtdBarCode',       'FTShwNameUsr' => 'บาร์โค้ด',    'FTShwFedStaUsed' => '1','FNShwColWidth' => 0,'FTShwStaAlwEdit' => 0),
                (object) array('FNShwSeq' => 5,  'FTShwFedShw' => 'FTPunName',          'FTShwNameUsr' => 'หน่วยสินค้า',  'FTShwFedStaUsed' => '1','FNShwColWidth' => 0, 'FTShwStaAlwEdit' => 0),
                
                (object) array('FNShwSeq' => 6,  'FTShwFedShw' => 'FCXtdQtyOrd',        'FTShwNameUsr' => 'จำนวนสั่ง',  'FTShwFedStaUsed' => '1','FNShwColWidth' => 0, 'FTShwStaAlwEdit' => 0),
                (object) array('FNShwSeq' => 7,  'FTShwFedShw' => 'FCXtdQtyPick',       'FTShwNameUsr' => 'จำนวนจัด',  'FTShwFedStaUsed' => '1','FNShwColWidth' => 0, 'FTShwStaAlwEdit' => 0),

                (object) array('FNShwSeq' => 8,  'FTShwFedShw' => 'FCXtdQty',           'FTShwNameUsr' => 'จำนวน',     'FTShwFedStaUsed' => '1','FNShwColWidth' => 0, 'FTShwStaAlwEdit' => 1)
            );
        }else{
            $aColumnShow = array(
                (object) array('FNShwSeq' => 1,  'FTShwFedShw' => 'FNXtdSeqNo',         'FTShwNameUsr' => 'ลำดับ',     'FTShwFedStaUsed' => '1','FNShwColWidth' => 0,'FTShwStaAlwEdit' => 0),
                (object) array('FNShwSeq' => 2,  'FTShwFedShw' => 'FTPdtCode',          'FTShwNameUsr' => 'รหัสสินค้า',     'FTShwFedStaUsed' => '1','FNShwColWidth' => 0,'FTShwStaAlwEdit' => 0),
                (object) array('FNShwSeq' => 3,  'FTShwFedShw' => 'FTXtdPdtName',       'FTShwNameUsr' => 'ชื่อสินค้า',  'FTShwFedStaUsed' => '1','FNShwColWidth' => 0,'FTShwStaAlwEdit' => 0),
                (object) array('FNShwSeq' => 4,  'FTShwFedShw' => 'FTXtdBarCode',       'FTShwNameUsr' => 'บาร์โค้ด',    'FTShwFedStaUsed' => '1','FNShwColWidth' => 0,'FTShwStaAlwEdit' => 0),
                (object) array('FNShwSeq' => 5,  'FTShwFedShw' => 'FTPunName',          'FTShwNameUsr' => 'หน่วยสินค้า',  'FTShwFedStaUsed' => '1','FNShwColWidth' => 0, 'FTShwStaAlwEdit' => 0),
                (object) array('FNShwSeq' => 6,  'FTShwFedShw' => 'FCXtdQty',           'FTShwNameUsr' => 'จำนวน',     'FTShwFedStaUsed' => '1','FNShwColWidth' => 0, 'FTShwStaAlwEdit' => 1)
            );
        }

        // echo "<pre>";
        // print_r($aColumnShow);
        // exit;

        // Calcurate Document DT Temp
        $aCalcDTParams = [
            'tDataDocEvnCall'   => '',
            'tDataVatInOrEx'    => '2',
            'tDataDocNo'        => $tDocNo,
            'tDataDocKey'       => $tDocKey,
            'tDataSeqNo'        => ''
        ];
        FCNbHCallCalcDocDTTemp($aCalcDTParams);

        $aEndOfBillParams = [
            'tSplVatType' => '2',
            'tDocNo' => $tDocNo,
            'tDocKey' => $tDocKey,
            'nLngID' => FCNaHGetLangEdit(),
            'tSesSessionID' => $this->session->userdata('tSesSessionID'),
            'tBchCode' => $this->session->userdata('tSesUsrLevel') == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata('tSesUsrBchCode')
        ];
        $aEndOfBill['aEndOfBillVat'] = FCNaDOCEndOfBillCalVat($aEndOfBillParams);
        $aEndOfBill['aEndOfBillCal'] = FCNaDOCEndOfBillCal($aEndOfBillParams);
        $aEndOfBill['tTextBath'] = FCNtNumberToTextBaht($aEndOfBill['aEndOfBillCal']['cCalFCXphGrand']);

        $aGetPdtInTmpParams  = array(
            'FNLngID'           => $nLangEdit,
            'nPage'             => $nPage,
            'nRow'              => 10,
            'tSearchAll'        => $tSearchAll,
            'tUserSessionID'    => $tUserSessionID,
            'tDocKey'           => $tDocKey,
            'tTBODocNo'         => $tTBODocNo
        );
        $aResList       = $this->mTransferBchOutPdt->FSaMGetPdtInTmp($aGetPdtInTmpParams);
        $aWhere = array(
            'FTUfrGrpRef'   => '068',
            'FTUfrRef'      => 'KB037'
        );
        $bAlwEditQty    = FCNbGetUsrFuncRpt($aWhere); //ตรวจสอบสิทธิ์การแก้ไขจำนวน

        $aGenTable = array(
            'aAlwEvent'         => $aAlwEvent,
            'aDataList'         => $aResList,
            'bIsApvOrCancel'    => ($tIsApvOrCancel=="1")?true:false,
            'bIsPacking'        => ( $tStaPrcDoc != "" && $tStaPrcDoc != "1" ? true : false ),
            'bIsPacked'         => ( $tStaPrcDoc != "" && $tStaPrcDoc == "4" ? true : false ),
            'aColumnShow'       => $aColumnShow,
            'nPage'             => $nPage,
            'nOptDecimalShow'   => $nOptDecimalShow,
            'bAlwEditQty'       => $bAlwEditQty
        );
        $tHtml = $this->load->view('document/transfer_branch_out/advance_table/wTransferBchOutPdtDatatable', $aGenTable, true);

        $aResponse = [
            'aEndOfBill' => $aEndOfBill,
            'html' => $tHtml
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResponse));
    }

    /**
     * Functionality : Insert Pdt to Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCTransferBchOutInsertPdtToTmp()
    {
        $tDocNo             = 'TBODOCTEMP';
        $tDocKey            = 'TCNTPdtTboHD';
        $nLngID             = $this->session->userdata("tLangID");
        $tUserSessionID     = $this->session->userdata('tSesSessionID');
        $tUserLevel         = $this->session->userdata('tSesUsrLevel');
        $tBchCode           = $this->input->post('ptBchCode');

        $tTransferBchOutOptionAddPdt = $this->input->post('tTransferBchOutOptionAddPdt');
        $tIsByScanBarCode = $this->input->post('tIsByScanBarCode');
        $tBarCodeByScan = $this->input->post('tBarCodeByScan');
        $tPdtData = $this->input->post('tPdtData');
        $aPdtData = json_decode($tPdtData);

        $this->db->trans_begin();

        if ($tIsByScanBarCode != '1') { // ทำงานเมื่อไม่ใช่การแสกนบาร์โค้ดมา

            // ทำทีรายการ ตามรายการสินค้าที่เพิ่มเข้ามา
            foreach ($aPdtData as $nKey => $oItem) {
                $oPackData = $oItem->packData;

                $tPdtCode = $oPackData->PDTCode;
                $tBarCode = $oPackData->Barcode;
                $tPunCode = $oPackData->PUNCode;
                $cPrice = $oPackData->Price;

                $aGetMaxSeqDTTempParams = array(
                    'tDocNo' => $tDocNo,
                    'tDocKey' => $tDocKey,
                    'tUserSessionID' => $tUserSessionID
                );
                $nMaxSeqNo = $this->mTransferBchOutPdt->FSnMGetMaxSeqDTTemp($aGetMaxSeqDTTempParams);

                $aDataPdtParams = array(
                    'tDocNo' => $tDocNo,
                    'tBchCode' => $tBchCode, // จากสาขาที่ทำรายการ
                    'tPdtCode' => $tPdtCode, // จาก Browse Pdt
                    'tPunCode' => $tPunCode, // จาก Browse Pdt
                    'tBarCode' => $tBarCode, // จาก Browse Pdt
                    'pcPrice' => $cPrice, // ราคาสินค้าจาก Browse Pdt
                    'nMaxSeqNo' => $nMaxSeqNo + 1, // จำนวนล่าสุด Seq
                    // 'nCounts' => $nCounts,
                    'nLngID' => $nLngID, // รหัสภาษาที่ login
                    'tUserSessionID' => $tUserSessionID,
                    'tDocKey' => $tDocKey,
                    'tOptionAddPdt' => $tTransferBchOutOptionAddPdt
                );

                $aDataPdtMaster = $this->mTransferBchOutPdt->FSaMGetDataPdt($aDataPdtParams); // Data Master Pdt ข้อมูลรายการสินค้าที่เพิ่มเข้ามา

                if ($aDataPdtMaster['rtCode'] == '1') {
                    $this->mTransferBchOutPdt->FSaMInsertPDTToTemp($aDataPdtMaster, $aDataPdtParams); // นำรายการสินค้าเข้า DT Temp
                }
            }
        }

        // นำเข้ารายการสินค้าจากการแสกนบาร์โค้ด
        if ($tIsByScanBarCode == '1') {
            $aGetPunCodeByBarCodeParams = [
                'tBarCode' => $tBarCodeByScan,
                'tSplCode' => $tSplCode
            ];
            $aPdtData = $this->mTransferBchOutPdt->FSaMCreditNoteGetPunCodeByBarCode($aGetPunCodeByBarCodeParams);

            if ($aPdtData['rtCode'] == '1') {

                $aDataWhere = array(
                    'tDocNo'    => $tDocNo,
                    'tDocKey'   => 'TAPTPcHD',
                );
                $nMaxSeqNo = $this->mTransferBchOutPdt->FSaMCreditNoteGetMaxSeqDTTemp($aDataWhere);

                $aPdtItems = $aPdtData['raItem'];
                // Loop
                $aDataPdtParams = array(
                    'tDocNo' => $tDocNo,
                    'tSplCode' => $tSplCode,
                    'tBchCode' => $tBchCode,   // จากสาขาที่ทำรายการ
                    'tPdtCode' => $aPdtItems['FTPdtCode'],  // จาก Browse Pdt
                    'tPunCode' => $aPdtItems['FTPunCode'],  // จาก Browse Pdt
                    'tBarCode' => $aPdtItems['FTBarCode'],  // จาก Browse Pdt
                    'pcPrice' => $aPdtItems['cCost'],
                    'nMaxSeqNo' => $nMaxSeqNo + 1, // จำนวนล่าสุด Seq
                    // 'nCounts' => $nCounts,
                    'nLngID' => $this->session->userdata("tLangID"), // รหัสภาษาที่ login
                    'tSessionID' => $this->session->userdata('tSesSessionID'),
                    'tDocKey' => 'TAPTPcHD',
                    'nCreditNoteOptionAddPdt' => $nCreditNoteOptionAddPdt
                );

                $aDataPdtMaster = $this->mTransferBchOutPdt->FSaMCreditNoteGetDataPdt($aDataPdtParams); // Data Master Pdt ข้อมูลรายการสินค้าที่เพิ่มเข้ามา
                if ($aDataPdtMaster['rtCode'] == '1') {
                    $nStaInsPdtToTmp = $this->mTransferBchOutPdt->FSaMCreditNoteInsertPDTToTemp($aDataPdtMaster, $aDataPdtParams); // นำรายการสินค้าเข้า DT Temp
                }
                // Loop
            } else {
                $aStatus = array(
                    'rtCode' => '800',
                    'rtDesc' => 'Data not found.',
                );
                $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aStatus));
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess InsertPdtToTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success InsertPdtToTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Update Pdt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCTransferBchOutUpdatePdtInTmp()
    {
        $tFieldName = $this->input->post('tFieldName');
        $tValue = $this->input->post('tValue');
        $nSeqNo = $this->input->post('nSeqNo');
        $tDocNo = 'TBODOCTEMP';
        $tDocKey = 'TCNTPdtTboHD';
        $tBchCode = $this->input->post('tBchCode');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");

        $this->db->trans_begin();

        $aUpdatePdtInTmpBySeqParams = [
            'tFieldName' => $tFieldName,
            'tValue' => $tValue,
            'tUserSessionID' => $tUserSessionID,
            'tDocNo' => $tDocNo,
            'tDocKey' => $tDocKey,
            'nSeqNo' => $nSeqNo,
        ];
        $this->mTransferBchOutPdt->FSbUpdatePdtInTmpBySeq($aUpdatePdtInTmpBySeqParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess UpdatePdtInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success UpdatePdtInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Delete Pdt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCTransferBchOutDeletePdtInTmp()
    {
        $nSeqNo = $this->input->post('nSeqNo');
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        $this->db->trans_begin();

        $aDeleteInTmpBySeqParams = [
            'tUserSessionID' => $tUserSessionID,
            'tDocNo' => 'TBODOCTEMP',
            'tDocKey' => 'TCNTPdtTboHD',
            'nSeqNo' => $nSeqNo,
        ];
        $this->mTransferBchOutPdt->FSbDeletePdtInTmpBySeq($aDeleteInTmpBySeqParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess DeletePdtInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success DeletePdtInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Delete More Pdt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : Napat(Jame) 31/07/2020
     * Return : -
     * Return Type : -
     */
    public function FSxCTransferBchOutDeleteMorePdtInTmp()
    {
        // $tSeqNo = $this->input->post('paSeqNo');
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        $this->db->trans_begin();

        $aDeleteInTmpBySeqParams = [
            'tUserSessionID' => $tUserSessionID,
            'tDocNo' => 'TBODOCTEMP',
            'tDocKey' => 'TCNTPdtTboHD',
            'aSeqNo' => $this->input->post('paSeqNo'),
        ];
        $this->mTransferBchOutPdt->FSbDeleteMorePdtInTmpBySeq($aDeleteInTmpBySeqParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess DeleteMorePdtInTmp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success DeleteMorePdtInTmp'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Clear Pdt in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCTransferBchOutClearPdtInTmp()
    {
        $tUserSessionID = $this->session->userdata("tSesSessionID");

        $aClearPdtInTmpParams = [
            'tUserSessionID' => $tUserSessionID
        ];
        $this->mTransferBchOutPdt->FSbClearPdtInTmp($aClearPdtInTmpParams);
    }

    /**
     * Functionality : Get Pdt Column List
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FStCTransferBchOutGetPdtColumnList()
    {

        $aAvailableColumn = FCNaDCLAvailableColumn('TCNTPdtTboDT');
        $aData['aAvailableColumn'] = $aAvailableColumn;
        $this->load->view('document/transfer_branch_out/advance_table/wTransferBchOutPdtColList', $aData);
    }

    /**
     * Functionality : Update Pdt Column
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FStCTransferBchOutUpdatePdtColumn()
    {

        $aColShowSet = $this->input->post('aColShowSet');
        $aColShowAllList = $this->input->post('aColShowAllList');
        $aColumnLabelName = $this->input->post('aColumnLabelName');
        $nStaSetDef = $this->input->post('nStaSetDef');

        $this->db->trans_begin();

        FCNaDCLSetShowCol('TCNTPdtTboDT', '', '');

        if ($nStaSetDef == 1) {
            FCNaDCLSetDefShowCol('TCNTPdtTboDT');
        } else {
            for ($i = 0; $i < FCNnHSizeOf($aColShowSet); $i++) {

                FCNaDCLSetShowCol('TCNTPdtTboDT', 1, $aColShowSet[$i]);
            }
        }

        // Reset Seq
        FCNaDCLUpdateSeq('TCNTPdtTboDT', '', '', '');
        $q = 1;
        for ($n = 0; $n < FCNnHSizeOf($aColShowAllList); $n++) {
            FCNaDCLUpdateSeq('TCNTPdtTboDT', $aColShowAllList[$n], $q, $aColumnLabelName[$n]);
            $q++;
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess UpdatePdtColumn"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg' => 'Success UpdatePdtColumn'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    //////////////////////////////////////////// อ้างอิงเอกสารภายใน //////////////////////////

    //อ้างอิงเอกสารภายใน
    public function FSoCTransferBchOutRefIntDoc(){
        $tBCHCode   = $this->input->post('tBCHCode');
        $tBCHName   = $this->input->post('tBCHName');

        $aDataParam = array(
            'tBCHCode' => $tBCHCode,
            'tBCHName' => $tBCHName
        );

        $this->load->view('document/transfer_branch_out/refintdocument/wTransferBchOutRefDoc', $aDataParam);

    }

    // เลขที่เอกสารอ้างอิงมาแสดงในตาราง browse & Search
    public function FSoCTransferBchOutCallRefIntDocDataTable(){

        $nPage                              = $this->input->post('nTransferBchOutRefIntPageCurrent');
        $tTransferBchOutRefIntBchCode       = $this->input->post('tTransferBchOutRefIntBchCode');
        $tTransferBchOutRefIntDocNo         = $this->input->post('tTransferBchOutRefIntDocNo');
        $tTransferBchOutRefIntDocDateFrm    = $this->input->post('tTransferBchOutRefIntDocDateFrm');
        $tTransferBchOutRefIntDocDateTo     = $this->input->post('tTransferBchOutRefIntDocDateTo');
        $tTransferBchOutRefIntStaDoc        = $this->input->post('tTransferBchOutRefIntStaDoc');

        // Page Current
        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nTransferBchOutRefIntPageCurrent');
        }

        // Lang ภาษา
        $nLangEdit = $this->session->userdata("tLangEdit");


        $aDataParamFilter = array(
            'tTransferBchOutRefIntBchCode'      => $tTransferBchOutRefIntBchCode,
            'tTransferBchOutRefIntDocNo'        => $tTransferBchOutRefIntDocNo,
            'tTransferBchOutRefIntDocDateFrm'   => $tTransferBchOutRefIntDocDateFrm,
            'tTransferBchOutRefIntDocDateTo'    => $tTransferBchOutRefIntDocDateTo,
            'tTransferBchOutRefIntStaDoc'       => $tTransferBchOutRefIntStaDoc,
        );

        // Data Conditon Get Data Document
        $aDataCondition = array(
            'FNLngID'        => $nLangEdit,
            'nPage'          => $nPage,
            'nRow'           => 10,
            'aAdvanceSearch' => $aDataParamFilter
        );
        
        $aDataParam = $this->mTransferBchOutPdt->FSoMTransferBchOutCallRefIntDocDataTable($aDataCondition);

        $aConfigView = array(
            'nPage'     => $nPage,
            'aDataList' => $aDataParam,
        );

            $this->load->view('document/transfer_branch_out/refintdocument/wTransferBchOutRefDocDataTable', $aConfigView);
    }

    // เอารายการจากเอกสารอ้างอิงมาแสดงในตาราง browse
    public function FSoCTransferBchOutCallRefIntDocDetailDataTable(){

        $nLangEdit          = $this->session->userdata("tLangEdit");
        $tBchCode           = $this->input->post('ptBchCode');
        $tDocNo             = $this->input->post('ptDocNo');
        $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
        $aDataCondition = array(
            'FNLngID'   => $nLangEdit,
            'tBchCode'  => $tBchCode,
            'tDocNo'    => $tDocNo
        );
        $aDataParam = $this->mTransferBchOutPdt->FSoMTransferBchOutCallRefIntDocDTDataTable($aDataCondition);

        $aConfigView = array(
            'aDataList'         => $aDataParam,
            'nOptDecimalShow'   => $nOptDecimalShow
            );
        $this->load->view('document/transfer_branch_out/refintdocument/wTransferBchOutRefDocDetailDataTable', $aConfigView);
    }

    // เอารายการที่เลือกจากเอกสารอ้างอิงภายในลงตาราง temp dt
    public function FSoCTransferBchOutCallRefIntDocInsertDTToTemp(){
        $tTransferBchOutDocNo           =  $this->input->post('tTransferBchOutDocNo');
        $tTransferBchOutFrmBchCode      =  $this->input->post('tTransferBchOutFrmBchCode');
        $tRefIntDocNo                   =  $this->input->post('tRefIntDocNo');
        $tRefIntBchCode                 =  $this->input->post('tRefIntBchCode');
        $aSeqNo                         =  $this->input->post('aSeqNo');
        $tSplStaVATInOrEx               = $this->input->post('tSplStaVATInOrEx');

        $aDataParam = array(
            'tTransferBchOutDocNo'       => $tTransferBchOutDocNo,
            'tTransferBchOutFrmBchCode'  => $tTransferBchOutFrmBchCode,
            'tRefIntDocNo'   => $tRefIntDocNo,
            'tRefIntBchCode' => $tRefIntBchCode,
            'aSeqNo'         => $aSeqNo,
        );

        $aDataResult = $this->mTransferBchOutPdt->FSoMTransferBchOutCallRefIntDocInsertDTToTemp($aDataParam);

        // Calcurate Document DT Temp Array Parameter
        $aCalcDTParams = [
            'tDataDocEvnCall'   => '12',
            'tDataVatInOrEx'    => $tSplStaVATInOrEx,
            'tDataDocNo'        => $tTransferBchOutDocNo,
            'tDataDocKey'       => 'TAPTPiDT',
            'tDataSeqNo'        => ''
        ];

        return  $aDataResult;
    }
}
