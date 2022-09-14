<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cCreditNote extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("file");
        $this->load->model('authen/user/mUser');
        $this->load->model('company/company/mCompany');
        $this->load->model('company/branch/mBranch');
        $this->load->model('company/shop/mShop');
        $this->load->model('payment/rate/mRate');
        $this->load->model('company/vatrate/mVatRate');
        $this->load->model('document/creditnote/mCreditNote');
        $this->load->model('document/creditnote/mCreditNoteDisChgModal');
    }

    public function index($nBrowseType, $tBrowseOption)
    {

        $aData['nBrowseType'] = $nBrowseType;
        $aData['tBrowseOption'] = $tBrowseOption;
        $aData['aAlwEvent'] = FCNaHCheckAlwFunc('creditNote/0/0'); // Controle Event
        $aData['vBtnSave'] = FCNaHBtnSaveActiveHTML('creditNote/0/0'); // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        // Get Option Show Decimal
        $aData['nOptDecimalShow'] = FCNxHGetOptionDecimalShow();
        $aData['nOptDecimalSave'] = FCNxHGetOptionDecimalSave();

        $this->load->view('document/creditnote/wCreditNote', $aData);
    }

    // Function : get ร้านค้า ใน สาขา
    public function FSvCCreditNoteGetShpByBch()
    {

        $tBchCode = $this->input->post('ptBchCode');

        // Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TCNMShop_L');
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

        $aData  = array(
            'FTBchCode'     => $tBchCode,
            'FTShpCode'     => '',
            'nPage'         => 1,
            'nRow'          => '9999',
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => ''
        );

        $aShpData = $this->mShop->FSaMSHPList($aData);

        echo json_encode($aShpData);
    }

    // Function : Get สินค้า ตาม Pdt BarCode
    public function FSvCCreditNoteGetPdtBarCode()
    {
        $tBarCode = $this->input->post('tBarCode');
        $tSplCode = $this->input->post('tSplCode');

        $aPdtBarCode =  FCNxHGetPdtBarCode($tBarCode, $tSplCode);

        if ($aPdtBarCode != 0) {
            $jPdtBarCode = json_encode($aPdtBarCode);
            $aData  = array(
                'aData' => $jPdtBarCode,
                'tMsg'     => 'OK',
            );
        } else {
            $aData  = array(
                'aData' => 0,
                'tMsg'     => language('document/browsepdt/browsepdt', 'tPdtNotFound'),
            );
        }

        $jData = json_encode($aData);

        echo $jData;
    }

    // Function : Add Temp to DT
    public function FSaMCreditNoteAddTmpToDT($ptXphDocNo = '')
    {
        $aDataWhere = array(
            'FTXphDocNo' => $ptXphDocNo,
            'FTXthDocKey' => 'TAPTPcHD',
        );
        $aResInsDT = $this->mCreditNote->FSaMCreditNoteInsertTmpToDT($aDataWhere);
        if ($aResInsDT['rtCode'] == '1') {
            $this->mCreditNote->FSxMClearPdtInTmp();
        }
    }

    // Function : แก้ไข Pdt DT
    public function FSvCCreditNoteEditPdtIntoTableDT()
    {
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCode = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");
        $tDocNo = $this->input->post('tDocNo');
        $tSplVatType = $this->input->post('tSplVatType');
        $nSeqNo = $this->input->post('tSeqNo');
        $tFieldName = $this->input->post('tFieldName');
        $tValue = $this->input->post('tValue');
        $tIsDelDTDis = $this->input->post('tIsDelDTDis');
        $tSessionID = $this->session->userdata('tSesSessionID');

        $aDataWhere = array(
            'tBchCode'      => $tBchCode,
            'tDocNo'        => $tDocNo,
            'nSeqNo'        => $nSeqNo,
            'tSessionID' => $tSessionID,
            'tDocKey'       => 'TAPTPcHD',
        );

        $aDataUpdateDT = [
            'tFieldName' => $tFieldName,
            'tValue' => $tValue
        ];

        /*foreach($aField as $key => $FieldName){
            $aDataUpdateDT[$FieldName] = $aValue[$key];
        }*/

        $this->db->trans_begin();

        // แก้ไขรายการสินค้า
        $this->mCreditNote->FSaMCreditNoteUpdateInlineDTTemp($aDataUpdateDT, $aDataWhere);

        if ($tIsDelDTDis == '1') { // ยืนยันการลบ DTDis ส่วนลดรายการนี้
            $this->mCreditNoteDisChgModal->FSaMCreditNoteDeleteDTDisTemp($aDataWhere);
            $this->mCreditNoteDisChgModal->FSaMCreditNoteClearDisChgTxtDTTemp($aDataWhere);
        }

        // Prorat Call
        FCNaHCalculateProrate('TAPTPcHD', $tDocNo);

        $aCalcDTParams = [
            'tDataDocEvnCall' => '1',
            'tDataVatInOrEx' => $tSplVatType,
            'tDataDocNo' => $tDocNo,
            'tDataDocKey' => 'TAPTPcHD',
            'tDataSeqNo' => ''
        ];
        FCNbHCallCalcDocDTTemp($aCalcDTParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess process"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'        => '1',
                'tStaMessg'        => 'Success process'
            );
        }
        echo json_encode($aReturn);
    }

    // Function : Add Pdt ลง Dt (File)
    public function FSvCCreditNoteAddPdtIntoTableDT()
    {
        $tUserLevel = $this->session->userdata('tSesUsrLevel');

        $tDocNo = $this->input->post('tDocNo');
        $tIsRefPI = $this->input->post('tIsRefPI');
        $tSplVatType = $this->input->post('tSplVatType');
        $tSplCode = $this->input->post('tSplCode');
        $tBchCode = $this->session->userdata('tSesUsrBchCodeDefault');
        $nCreditNoteOptionAddPdt = $this->input->post('tCreditNoteOptionAddPdt');
        $tPdtData = $this->input->post('tPdtData');
        $tIsByScanBarCode = $this->input->post('tIsByScanBarCode');
        $tBarCodeByScan = $this->input->post('tBarCodeByScan');
        $aPdtData = json_decode($tPdtData);

        if ($tIsByScanBarCode != '1') { // ทำงานเมื่อไม่ใช่การแสกนบาร์โค้ดมา

            if ($tIsRefPI == '1') { // หากนำเข้าจากการอ้างอิงใบ PI ต้องลบรายการสินค้าเดิมก่อน
                $this->mCreditNote->FSxMClearPdtInTmp();
                $this->mCreditNote->FSxMClearDTDisTmp();
                $this->mCreditNote->FSxMClearHDDisTmp();
            }

            // $nCounts = $this->mCreditNote->FSaMCreditNoteGetCountDTTemp($aDataWhere);

            // ทำทีรายการ ตามรายการสินค้าที่เพิ่มเข้ามา
            for ($nI = 0; $nI < FCNnHSizeOf($aPdtData); $nI++) {
                $pnPdtCode  = $aPdtData[$nI]->pnPdtCode;
                $ptBarCode  = $aPdtData[$nI]->ptBarCode;
                $ptPunCode  = $aPdtData[$nI]->ptPunCode;
                $pcPrice    = $aPdtData[$nI]->packData->Price;
                $pcQty      = $aPdtData[$nI]->packData->Qty;
                $tVatrate   = $aPdtData[$nI]->packData->Vatrate;
                $tVatcode   = $aPdtData[$nI]->packData->vatcode;

                $aDataWhere = array(
                    'tDocNo'    => $tDocNo,
                    'tDocKey'   => 'TAPTPcHD',
                );
                $nMaxSeqNo = $this->mCreditNote->FSaMCreditNoteGetMaxSeqDTTemp($aDataWhere);

                $aDataPdtParams = array(
                    'tDocNo'                    => $tDocNo,
                    'tSplCode'                  => $tSplCode,
                    'tBchCode'                  => $tBchCode,   // จากสาขาที่ทำรายการ
                    'tPdtCode'                  => $pnPdtCode,  // จาก Browse Pdt
                    'tPunCode'                  => $ptPunCode,  // จาก Browse Pdt
                    'tBarCode'                  => $ptBarCode,  // จาก Browse Pdt
                    'pcPrice'                   => $pcPrice,    // ราคาสินค้าจาก Browse Pdt
                    'nMaxSeqNo'                 => $nMaxSeqNo + 1, // จำนวนล่าสุด Seq
                    'nLngID'                    => $this->session->userdata("tLangID"), // รหัสภาษาที่ login
                    'tSessionID'                => $this->session->userdata('tSesSessionID'),
                    'tDocKey'                   => 'TAPTPcHD',
                    'nQty'                      => $pcQty,
                    'nCreditNoteOptionAddPdt'   => $nCreditNoteOptionAddPdt,
                    'tVatrate'                  => $tVatrate,
                    'tVatcode'                  => $tVatcode
                );

                $aDataPdtMaster = $this->mCreditNote->FSaMCreditNoteGetDataPdt($aDataPdtParams); // Data Master Pdt ข้อมูลรายการสินค้าที่เพิ่มเข้ามา
                if ($aDataPdtMaster['rtCode'] == '1') {
                    $this->mCreditNote->FSaMCreditNoteInsertPDTToTemp($aDataPdtMaster, $aDataPdtParams); // นำรายการสินค้าเข้า DT Temp
                }
            }
        }

        // นำเข้ารายการสินค้าจากการแสกนบาร์โค้ด
        if ($tIsByScanBarCode == '1') {
            $aGetPunCodeByBarCodeParams = [
                'tBarCode' => $tBarCodeByScan,
                'tSplCode' => $tSplCode
            ];
            $aPdtData = $this->mCreditNote->FSaMCreditNoteGetPunCodeByBarCode($aGetPunCodeByBarCodeParams);

            if ($aPdtData['rtCode'] == '1') {

                $aDataWhere = array(
                    'tDocNo'    => $tDocNo,
                    'tDocKey'   => 'TAPTPcHD',
                );
                $nMaxSeqNo = $this->mCreditNote->FSaMCreditNoteGetMaxSeqDTTemp($aDataWhere);

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

                $aDataPdtMaster = $this->mCreditNote->FSaMCreditNoteGetDataPdt($aDataPdtParams); // Data Master Pdt ข้อมูลรายการสินค้าที่เพิ่มเข้ามา
                if ($aDataPdtMaster['rtCode'] == '1') {
                    $nStaInsPdtToTmp = $this->mCreditNote->FSaMCreditNoteInsertPDTToTemp($aDataPdtMaster, $aDataPdtParams); // นำรายการสินค้าเข้า DT Temp
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

        // Prorat Call
        FCNaHCalculateProrate('TAPTPcHD', $tDocNo);

        $aCalcDTParams = [
            'tDataDocEvnCall' => '',
            'tDataVatInOrEx' => $tSplVatType,
            'tDataDocNo' => $tDocNo,
            'tDataDocKey' => 'TAPTPcHD',
            'tDataSeqNo' => ''
        ];
        FCNbHCallCalcDocDTTemp($aCalcDTParams);
        echo $this->session->userdata("tSesUsrBchCodeDefault");
    }

    // Function : Remove Master Pdt Intable (File)
    public function FSvCCreditNoteRemovePdtInDTTmp(){
        $aDataWhere = array(
            'tDocNo'        => $this->input->post('tDocNo'),
            'tPdtCode'      => $this->input->post('tPdtCode'),
            'nSeqNo'        => $this->input->post('nSeqNo'),
            'tSessionID'    => $this->session->userdata('tSesSessionID'),
        );

        $aResDel = $this->mCreditNote->FSnMCreditNoteDelDTTmp($aDataWhere);

        //ถ้าลบสินค้า ต้องวิ่งไปเช็คด้วยว่า มีท้ายบิล ไหม ถ้าสินค้าที่เหลืออยู่ไม่อนุญาติลด ท้ายบิลก็ต้องลบทิ้งด้วย
        $aPackDataCalCulate = array(
            'tDocNo'        => $this->input->post('tDocNo'),
            'tBchCode'      => $this->input->post('tBchCode'),
            'nB4Dis'        => '',
            'tSplVatType'   => $this->input->post('tSplVatType')
        );
        FSaCCNDocumentUpdateHDDisAgain($aPackDataCalCulate);
        
        $tDocNo = $this->input->post('tDocNo');
        FCNaHCalculateProrate('TAPTPcHD', $tDocNo);

    }

    // Function : เรียกหน้า  Add 
    public function FSxCCreditNoteAddPage()
    {

        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCode = $this->session->userdata('tSesUsrBchCodeDefault');

        $aParams = array(
            'nSeqNo'        => '',
            'nStaDis'       => '',
            'tDocNo'        => '',
            'tBchCode'      => $tBchCode,
            'tSessionID'    => $this->session->userdata('tSesSessionID')
        );

        // Clear in temp
        $this->mCreditNote->FSxMClearPdtInTmp();
        $this->mCreditNoteDisChgModal->FSaMCENDeletePDTInTmp($aParams);
        $this->mCreditNoteDisChgModal->FSaMCreditNoteDeleteHDDisTemp($aParams);
        $this->mCreditNoteDisChgModal->FSaMCreditNoteDeleteDTDisTemp($aParams);

        // Get Option Show Decimal  
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        // Get Option Scan SKU
        $nOptDocSave = FCNnHGetOptionDocSave();
        // Get Option Scan SKU
        $nOptScanSku = FCNnHGetOptionScanSku();

        // Lang ภาษา
        $nLangId = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");
        $aLangHave = FCNaHGetAllLangByTable('TFNMRate_L');
        $nLangHave = FCNnHSizeOf($aLangHave);

        if ($nLangHave > 1) {
            if ($nLangEdit != '') {
                $nLangEdit = $nLangEdit;
            } else {
                $nLangEdit = $nLangId;
            }
        } else {
            if (@$aLangHave[0]->nLangList == '') {
                $nLangEdit = '1';
            } else {
                $nLangEdit = $aLangHave[0]->nLangList;
            }
        }

        $aData  = array(
            'FNLngID' => $nLangEdit,
            'FTUsrCode' => $this->session->userdata('tSesUsername')
        );

        $aPermission = FCNaHCheckAlwFunc("creditNote/0/0");

        $aDataUserLogin = $this->mCreditNote->FStCreditNoteGetUsrByCode($aData);
        $nDocType = $this->input->post('nDocType');

        // var_dump($aDataUserLogin);
        $aDataAdd = array(
            'nOptDecimalShow'   => $nOptDecimalShow,
            'nOptDocSave'       => $nOptDocSave,
            'nOptScanSku'       => $nOptScanSku,
            'aResult'           => array('rtCode' => '99'),
            'aUserCreated'      => ['rtCode' => '99'],
            'aUserApv'          => ['rtCode' => '99'],
            'aPermission'       => $aPermission,
            'tUserCode'         => $aDataUserLogin['FTUsrCode'],
            'tUserName'         => $aDataUserLogin['FTUsrName'],
            'tUserMchCode'      => $aDataUserLogin['FTMerCode'],
            'tUserMchCode'      => $aDataUserLogin['FTMerCode'],
            'tUserMchName'      => $aDataUserLogin['FTMerName'],
            'tUserShpCode'      => $aDataUserLogin['FTShpCode'],
            'tUserShpName'      => $aDataUserLogin['FTShpName'],
            'tUserWahCode'      => $aDataUserLogin['FTWahCode'],
            'tUserWahName'      => $aDataUserLogin['FTWahName'],
            'tUserBchCode'      => $aDataUserLogin['FTBchCode'],
            'tUserBchName'      => $aDataUserLogin['FTBchName'],
            'tUserDptCode'      => $aDataUserLogin['FTDptCode'],
            'tUserDptName'      => $aDataUserLogin['FTDptName'],
            'nDocType'          => $nDocType
        );
        $this->load->view('document/creditnote/wCreditNoteAdd', $aDataAdd);
    }

    // Functionality : Event Add Master
    public function FSaCCreditNoteAddEvent()
    {
        try {

            $nOptDecimalShow = FCNxHGetOptionDecimalShow();
            $tDocDate        = $this->input->post('oetCreditNoteXphDocDate') . " " . $this->input->post('oetCreditNoteDocTime');
            $tUserLevel      = $this->session->userdata('tSesUsrLevel');
            $tLoginDpt       = $this->session->userdata('tSesUsrDptCode');
            $tBchCode        = $this->input->post("oetCreditNoteBchCode");
            $tLoginUser      = $this->session->userdata('tSesUsername');
            $tSessionID      = $this->session->userdata('tSesSessionID');
            $tSplVatType     = $this->input->post('ocmCreditNoteXphVATInOrEx');

            $aCalDTTempParams = [
                'tDocNo'        => '',
                'tBchCode'      => $tBchCode,
                'tSessionID'    => $tSessionID,
                'tDocKey'       => 'TAPTPcHD'
            ];
            $aCalDTTempForHD = $this->FSaCCreditNoteCalDTTempForHD($aCalDTTempParams);
            $aCalInHDDisTemp = $this->mCreditNote->FSaMCreditNoteCalInHDDisTemp($aCalDTTempParams);

            $aDataMaster = array(
                'tIsAutoGenCode' => $this->input->post('ocbCreditNoteAutoGenCode'), // ต้องการรัน DocNo อัตโนมัติหรือไม่

                'FTBchCode' => $tBchCode, // รหัสสาขาที่สร้างเอกสาร
                'FTXphDocNo' => $this->input->post('oetCreditNoteDocNo'), // เลขที่เอกสาร
                'FNXphDocType' => $this->input->post('ohdCreditNoteDocType'), // ประเภทเอกสาร (ใบลดหนี้มีสินค้า หรือ ไม่มีสินค้า)
                'FDXphDocDate' => $tDocDate, // วันที่สร้างเอกสาร
                'FTShpCode' => $this->input->post('oetCreditNoteShpCode'), // รหัสร้านค้า
                'FTXphCshOrCrd' => $this->input->post('ocmCreditNoteXphCshOrCrd'), // ประเภทการชำระเงิน (เงินสด หรือ เชื่อ)
                'FTXphVATInOrEx' => $tSplVatType, // ประเภทภาษี (แยกนอก หรือ รวมใน)
                'FTDptCode' => $tLoginDpt, // รหัสแผนกผู้ที่สร้างเอกสาร
                'FTWahCode' => $this->input->post('oetCreditNoteWahCode'), // รหัสคลังสินค้า
                'FTUsrCode' => $tLoginUser, // รหัสผู้สร้างเอกสาร
                'FTXphApvCode' => NULL, // รหัสผู้อนุมัติ
                'FTSplCode' => $this->input->post('oetCreditNoteSplCode'), // รหัสผู้จำหน่าย
                'FTXphRefExt' => $this->input->post('oetCreditNoteXphRefExt'), // อ้างอิง เลขที่เอกสาร ภายนอก
                'FDXphRefExtDate' => empty($this->input->post('oetCreditNoteXphRefExtDate')) ? NULL : $this->input->post('oetCreditNoteXphRefExtDate'), // อ้างอิง วันที่เอกสาร ภายนอก
                'FTXphRefInt' => $this->input->post('oetCreditNoteRefPICode'), // อ้างอิง เลขที่เอกสาร ภายใน
                'FDXphRefIntDate' => empty($this->input->post('oetCreditNoteXphRefIntDate')) ? NULL : $this->input->post('oetCreditNoteXphRefIntDate'), // อ้างอิง วันที่เอกสาร ภายใน
                'FTXphRefAE' => NULL,
                'FNXphDocPrint' => NULL,
                'FTRteCode' => NULL,
                'FCXphRteFac' => NULL,
                'FCXphTotal' => $aCalDTTempForHD['FCXphTotal'],
                'FCXphTotalNV' => $aCalDTTempForHD['FCXphTotalNV'],
                'FCXphTotalNoDis' => $aCalDTTempForHD['FCXphTotalNoDis'],
                'FCXphTotalB4DisChgV' => $aCalDTTempForHD['FCXphTotalB4DisChgV'],
                'FCXphTotalB4DisChgNV' => $aCalDTTempForHD['FCXphTotalB4DisChgNV'],
                'FTXphDisChgTxt' => isset($aCalInHDDisTemp['FTXphDisChgTxt']) ? $aCalInHDDisTemp['FTXphDisChgTxt'] : '',
                'FCXphDis' => isset($aCalInHDDisTemp['FCXphDis']) ? $aCalInHDDisTemp['FCXphDis'] : NULL,
                'FCXphChg' => isset($aCalInHDDisTemp['FCXphChg']) ? $aCalInHDDisTemp['FCXphChg'] : NULL,
                'FCXphTotalAfDisChgV' => $aCalDTTempForHD['FCXphTotalAfDisChgV'],
                'FCXphTotalAfDisChgNV' => $aCalDTTempForHD['FCXphTotalAfDisChgNV'],
                'FCXphRefAEAmt' => NULL,
                'FCXphAmtV' => $aCalDTTempForHD['FCXphAmtV'],
                'FCXphAmtNV' => $aCalDTTempForHD['FCXphAmtNV'],
                'FCXphVat' => $aCalDTTempForHD['FCXphVat'],
                'FCXphVatable' => $aCalDTTempForHD['FCXphVatable'],
                'FTXphWpCode' => $aCalDTTempForHD['FTXphWpCode'],
                'FCXphWpTax' => $aCalDTTempForHD['FCXphWpTax'],
                'FCXphGrand' => $aCalDTTempForHD['FCXphGrand'],
                'FCXphRnd' => NULL, // $aCalDTTempForHD['FCXphRnd'], ใบลดหนี้ไม่มีการปัดเศษ เนื่องจากเป็นการขายส่งเท่านั้น
                'FTXphGndText' => $aCalDTTempForHD['FTXphGndText'],
                'FCXphPaid' => NULL,
                'FCXphLeft' => NULL,
                'FTXphRmk' => $this->input->post('otaCreditNoteXphRmk'),
                'FTXphStaRefund' => NULL,
                'FTXphStaDoc' => '1', // สถานะเอกสาร (1:สมบูรณ์, 2:ไม่สมบูรณ์, 3:ยกเลิก)
                'FTXphStaApv' => NULL,
                'FTXphStaPrcStk' => NULL,
                'FTXphStaPaid' => NULL,
                'FNXphStaDocAct' => $this->input->post('ocbCreditNoteXphStaDocAct'),
                'FNXphStaRef' => $this->input->post('ocmCreditNoteXphStaRef'), // สถานะอ้างอิง (0:ไม่เคยอ้างอิง, 1:อ้างอิงบางส่วน, 2:อ้างอิงหมดแล้ว)

                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FTCreateBy' => $tLoginUser,
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTLastUpdBy' => $tLoginUser
            );

            if ($aDataMaster['tIsAutoGenCode'] == '1') { 
                $aStoreParam = array(
                    "tTblName" => 'TAPTPcHD',
                    "tDocType" => $aDataMaster['FNXphDocType'],
                    "tBchCode" => $aDataMaster["FTBchCode"],
                    "tShpCode" => "",
                    "tPosCode" => "",
                    "dDocDate" => date("Y-m-d")
                );
                $aAutogen = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTXphDocNo'] = $aAutogen[0]["FTXxhDocNo"];
            }

            // TAPTPcHDSpl
            $aDataSpl = array(
                'FTBchCode'             => $tBchCode,
                'FTXphDocNo'            => $aDataMaster['FTXphDocNo'],
                'FTXphDstPaid'          => $this->input->post('ocmCreditNoteHDPcSplXphDstPaid'), // 1:ชำระต้นทาง, 2:ชำระปลายทาง
                'FNXphCrTerm'           => $this->input->post('oetCreditNoteHDPcSplXphCrTerm'), // ระยะเครดิต
                'FDXphDueDate'          => empty($this->input->post('oetCreditNoteHDPcSplXphDueDate')) ? NULL : $this->input->post('oetCreditNoteHDPcSplXphDueDate'), // วันที่ครบกำหนด
                'FDXphBillDue'          => empty($this->input->post('oetCreditNoteHDPcSplXphBillDue')) ? NULL : $this->input->post('oetCreditNoteHDPcSplXphBillDue'), // วันที่จะรับ/วางบิล
                'FTXphCtrName'          => $this->input->post('oetCreditNoteHDPcSplXphCtrName'), // ชื่อผู้ตืดต่อ
                'FDXphTnfDate'          => empty($this->input->post('oetCreditNoteHDPcSplXphTnfDate')) ? NULL : $this->input->post('oetCreditNoteHDPcSplXphTnfDate'), // วันที่ส่งของ
                'FTXphRefTnfID'         => $this->input->post('oetCreditNoteHDPcSplXphRefTnfID'), // เลขที่ ใบขนส่ง
                'FTXphRefVehID'         => $this->input->post('oetCreditNoteHDPcSplXphRefVehID'), // อ้างอิง เลขที่ ยานพาหนะ ขนส่ง
                'FTXphRefInvNo'         => $this->input->post('oetCreditNoteHDPcSplXphRefInvNo'), // เลขที่บัญชีราคาสินค้า
                'FTXphQtyAndTypeUnit'   => $this->input->post('oetCreditNoteHDPcSplXphQtyAndTypeUnit'), // จำนวนและลักษณะหีบห่อ
                'FNXphShipAdd'          => NULL, // อ้างอิง ที่อยู่ ส่งของ
                'FNXphTaxAdd'           => NULL, // อ้างอิง ที่อยู่ออกใบกำกับภาษี
            );

            // เตรียมข้อมูลสำหรับ HD ใบลดหนี้ไม่มีสินค้า
            $tPdtCode               = $this->input->post('tPdtCode');
            $tPdtName               = $this->input->post('tPdtName');
            $tCalEndOfBillNonePdt   = $this->input->post('tCalEndOfBillNonePdt');
            $aCalEndOfBillNonePdt   = json_decode($tCalEndOfBillNonePdt, true);

            if ($aDataMaster['FNXphDocType'] == '7') { // ใบลดหนี้ไม่มีสินค้า
                $aDataMaster['FCXphTotal'] = FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cTotalValue']); // ยอดรวม
                $aDataMaster['FCXphTotalNV'] = NULL; // ยอดรวมสินค้าไม่มีภาษี
                $aDataMaster['FCXphTotalNoDis'] = NULL; // ยอดรวมสินค้าห้ามลด
                $aDataMaster['FCXphTotalB4DisChgV'] = NULL; // ยอมรวมสินค้าลดได้ และมีภาษี
                $aDataMaster['FCXphTotalB4DisChgNV'] = NULL; // ยอมรวมสินค้าลดได้ และไม่มีภาษี
                $aDataMaster['FTXphDisChgTxt'] = NULL; // ข้อความมูลค่าลดชาร์จ
                $aDataMaster['FCXphDis'] = NULL; // มูลค่ารวมส่วนลด
                $aDataMaster['FCXphChg'] = NULL; // มูลค่ารวมส่วนชาร์จ
                $aDataMaster['FCXphTotalAfDisChgV'] = NULL; // ยอดรวมหลังลด และมีภาษี
                $aDataMaster['FCXphTotalAfDisChgNV'] = NULL; // ยอดรวมหลังลด และไม่มีภาษี
                $aDataMaster['FCXphAmtV'] = FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cTotalValue']); // ยอดรวมเฉพาะภาษี
                $aDataMaster['FCXphAmtNV'] = NULL; // ยอดรวมเฉพาะไม่มีภาษี
                $aDataMaster['FCXphVat'] = FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cVat']); // ยอดภาษี
                $aDataMaster['FCXphVatable'] = FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cVatable']); // ยอดแยกภาษี
                $aDataMaster['FTXphWpCode'] = FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['tVatCode']); // รหัสอัตราภาษี ณ ที่จ่าย
                $aDataMaster['FCXphWpTax'] = FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cVat']); // ภาษีหัก ณ ที่จ่าย
                $aDataMaster['FCXphGrand'] = FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cTotalValue']); // ยอดรวม
                $aDataMaster['FCXphRnd'] = NULL; // ยอดปัดเศษ
                $aDataMaster['FTXphGndText'] = number_format($aDataMaster['FCXphGrand'], $nOptDecimalShow); // ข้อความ ยอดรวมสุทธิ

                // เตรียมข้อมูลสำหรับ DT ใบลดหนี้ไม่มีสินค้า
                $aDataDT = [
                    'FTBchCode'     => $aDataMaster['FTBchCode'], // สาขาสร้าง
                    'FTXphDocNo'    => $aDataMaster['FTXphDocNo'], // เลขที่เอกสาร
                    'FNXpdSeqNo'    => 1, // ลำดับ
                    'FTPdtCode'     => $tPdtCode, // รหัสสินค้า
                    'FTXpdPdtName'  => $tPdtName, // ชื่อสินค้า
                    'FCXpdFactor'   => 1, // อัตราส่วนต่อหน่วย
                    'FTXpdVatType'  => $tSplVatType, // ประเภทภาษี 1:มีภาษี, 2:ไม่มีภาษี
                    'FTVatCode'     => $aCalEndOfBillNonePdt['tVatCode'], // รหัสภาษี ณ. ซื้อ
                    'FCXpdVatRate'  => FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['nVatrate']), // อัตราภาษี ณ. ซื้อ
                    'FCXpdQty'      => 1, // จำนวนชื้น ตาม หน่วย
                    'FCXpdQtyAll'   => 1, // จำนวนรวมหน่วยเล็กสุด
                    'FCXpdSetPrice' => FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['tValue']), // ราคาซื้อ ตาม หน่วย * อัตราแลกเปลี่ยน
                    'FCXpdAmtB4DisChg' => FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['tValue']), // มูลค่ารวมก่อนลด
                    'FCXpdNet'      => FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['tValue']), // มูลค่าสุทธิก่อนท้ายบิล
                    'FCXpdNetAfHD'  => FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cTotalValue']), // มูลค่าสุทธิหลังท้ายบิล
                    'FCXpdVat'      => FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cVat']), // มูลค่าภาษี
                    'FCXpdVatable'  => FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cVatable']), // มูลค่าแยกภาษี
                    'FCXpdCostIn'   => floatval(FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cVat'])) + floatval(FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cVatable'])), // ต้นทุนรวมใน 
                    'FCXpdCostEx'   => FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cVatable']), // ต้นทุนแยกนอก
                    'FTXpdRmk'      => 'ใบลดหนี้ไม่มีสินค้า', 
                    'FDCreateOn'    => date('Y-m-d H:i:s'),
                    'FTCreateBy'    => $tLoginUser,
                    'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'   => $tLoginUser
                ];
            }

            $aParams = array(
                'tSessionID'    => $tSessionID,
                'tDocNo'        => $aDataMaster['FTXphDocNo'],
                'tBchCode'      => $tBchCode,
                'tDocKey'       => 'TAPTPcHD',
                'tIsUpdatePage' => '0'
            );

            $this->db->trans_begin();

            /*======================= Begin Data Process =====================*/

            if ($aDataMaster['FNXphDocType'] == '6') { // ใบลดหนี้แบบมีสินค้า
                $this->mCreditNote->FSaMCreditNoteAddUpdateHDHavePdt($aDataMaster);
                $this->mCreditNote->FSaMCreditNoteInsertTmpToDT($aParams);
                $this->mCreditNote->FSaMCreditNoteInsertTmpToDTDis($aParams);
                $this->mCreditNote->FSaMCreditNoteInsertTmpToHDDis($aParams);
            }

            if ($aDataMaster['FNXphDocType'] == '7') { // ใบลดหนี้แบบไม่มีสินค้า
                $this->mCreditNote->FSaMCreditNoteAddUpdateHDNonePdt($aDataMaster);
                $this->mCreditNote->FSaMCreditNoteAddUpdateDTNonePdt($aDataDT);
            }

            $this->mCreditNote->FSaMCreditNoteAddUpdatePCHDSpl($aDataSpl);

            // $this->mCreditNote->FSaMCreditNoteAddUpdateDocNoInDocTemp($aDataWhere); // Update DocNo ในตาราง Doctemp
            // $this->mCreditNote->FSaMCreditNoteInsertTmpToDT($aDataWhere); // Insert DT Temp to DT
            // $this->mCreditNote->FSxMClearPdtInTmp();
            // $this->mCreditNote->FSxMClearDTDisTmp();
            // $this->mCreditNote->FSxMClearHDDisTmp();

            /*========================= End Data Process =====================*/

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add"
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'    => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'    => $aDataMaster['FTXphDocNo'],
                    'nStaEvent'        => '1',
                    'tStaMessg'        => 'Success Add'
                );
            }

            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aReturn));
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    // คำนวณค่าจาก DT Temp ให้ HD
    private function FSaCCreditNoteCalDTTempForHD($paParams)
    {
        $aCalDTTemp = $this->mCreditNote->FSaMCreditNoteCalInDTTemp($paParams);
        if (!empty($aCalDTTemp)) {
            $aCalDTTempItems = $aCalDTTemp[0];
            // คำนวณหา ยอดปัดเศษ ให้ HD(FCXphRnd)
            /*$pCalRoundParams = [
                'FCXphAmtV' => $aCalDTTempItems['FCXphAmtV'],
                'FCXphAmtNV' => $aCalDTTempItems['FCXphAmtNV']
            ];
            $aRound = $this->FSaCCreditNoteCalRound($pCalRoundParams);*/

            // คำนวณหา ยอดรวม ให้ HD(FCXphGrand)
            $nRound = NULL; // $aRound['nRound'];
            $cGrand = $aCalDTTempItems['FCXphAmtV'] + $aCalDTTempItems['FCXphAmtNV']; // $aRound['cAfRound'];

            // จัดรูปแบบข้อความ จากตัวเลขเป็นข้อความ HD(FTXphGndText)
            $tGndText = FCNtNumberToTextBaht(number_format($cGrand, 2));

            $aCalDTTempItems['FCXphRnd'] = $nRound;
            $aCalDTTempItems['FCXphGrand'] = $cGrand;
            $aCalDTTempItems['FTXphGndText'] = $tGndText;

            /*echo $tGndText;
            
            echo '<pre>';
            var_dump($aCalDTTempItems);
            echo '</pre>';*/

            return $aCalDTTempItems;
        }
    }

    // หาค่าปัดเศษ HD(FCXphRnd)
    private function FSaCCreditNoteCalRound($paParams)
    {

        $tOptionRound = '1'; // ปัดขึ้น

        $cAmtV = $paParams['FCXphAmtV'];
        $cAmtNV = $paParams['FCXphAmtNV'];

        $cBath = $cAmtV + $cAmtNV;

        // ตัดเอาเฉพาะทศนิยม
        $nStang = explode('.', number_format($cBath, 2))[1];


        $nPoint = 0;
        $nRound = 0;

        /*====================== ปัดขึ้น ================================*/
        if ($tOptionRound == '1') {
            if ($nStang >= 1 and $nStang < 25) {
                $nPoint = 25;
                $nRound = $nPoint - $nStang;
            }
            if ($nStang > 25 and $nStang < 50) {
                $nPoint = 50;
                $nRound = $nPoint - $nStang;
            }
            if ($nStang > 50 and $nStang < 75) {
                $nPoint = 75;
                $nRound = $nPoint - $nStang;
            }
            if ($nStang > 75 and $nStang < 100) {
                $nPoint = 100;
                $nRound = $nPoint - $nStang;
            }
        }
        /*====================== ปัดขึ้น ================================*/

        /*====================== ปัดลง ================================*/
        if ($tOptionRound != '1') {
            if ($nStang >= 1 and $nStang < 25) {
                $nPoint = 1;
                $nRound = $nPoint - $nStang;
            }
            if ($nStang > 25 and $nStang < 50) {
                $nPoint = 25;
                $nRound = $nPoint - $nStang;
            }
            if ($nStang > 50 and $nStang < 75) {
                $nPoint = 50;
                $nRound = $nPoint - $nStang;
            }
            if ($nStang > 75 and $nStang < 100) {
                $nPoint = 75;
                $nRound = $nPoint - $nStang;
            }
        }
        /*====================== ปัดลง ================================*/
        $cAfRound = floatval($cBath) + floatval($nRound / 100);

        /*echo 'Bath: '; echo $cBath; echo '<br>';
        echo 'Point: '; echo $nPoint; echo '<br>';
        echo 'Stang: '; echo $nStang; echo '<br>';
        echo 'Round: '; echo $nRound; echo '<br>';
        echo 'After Round: '; echo $cAfRound;*/

        return [
            'tRoundType' => $tOptionRound,
            'cBath' => $cBath,
            'nPoint' => $nPoint,
            'nStang' => $nStang,
            'nRound' => $nRound,
            'cAfRound' => $cAfRound
        ];
    }

    // Function : เรียกหน้า  Edit  
    public function FSvCCreditNoteEditPage()
    {

        // Lang ภาษา
        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");
        $aLangHave = FCNaHGetAllLangByTable('TFNMRate_L');
        $nLangHave = FCNnHSizeOf($aLangHave);
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

        $tUserLevel = $this->session->userdata('tSesUsrLevel');

        $tDocNo = $this->input->post('tDocNo');
        $tBchCode = $this->session->userdata("tSesUsrBchCodeDefault");
        $tSessionID = $this->session->userdata('tSesSessionID');

        $aData = array(
            'FTXphDocNo' => $tDocNo,
            'FNLngID' => $nLangEdit,
            'FTUsrCode' => $this->session->userdata('tSesUsername')
        );

        $aPermission = FCNaHCheckAlwFunc("creditNote/0/0");
        // Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        // Get Option Scan SKU
        $nOptDocSave = FCNnHGetOptionDocSave();
        // Get Option Scan SKU
        $nOptScanSku = FCNnHGetOptionScanSku();

        $aUser = $this->mUser->FSaMUSRByID($aData);
        $aDataUserLogin = $this->mCreditNote->FStCreditNoteGetUsrByCode($aData); // Get ข้อมูลสาขา และร้านค้าของ User ที่ login
        $aCreditNoteHD = $this->mCreditNote->FSaMCreditNoteGetHD($aData); // Data TAPTPcHD

        $aHDSplParams = [
            'tDocNo' => $aCreditNoteHD['raItems']['FTXphDocNo']
        ];
        $aHDSpl = $this->mCreditNote->FSaMCreditNoteGetHDSpl($aHDSplParams); // ข้อมูลผู้จำหน่าย TAPTPcHDSpl

        $aSplParams = [
            'tSplCode' => $aCreditNoteHD['raItems']['FTSplCode']
        ];
        $aSpl = $this->mCreditNote->FSaMCreditNoteGetSplVatCode($aSplParams); // ข้อมูลผู้จำหน่าย TCNMSpl

        $aData['FTUsrCode'] = $aCreditNoteHD['raItems']['FTUsrCode'];
        $aUserCreated = $this->mUser->FSaMUSRByID($aData);

        $aData['FTUsrCode'] = $aCreditNoteHD['raItems']['FTXphApvCode'];
        $aUserApv = $this->mUser->FSaMUSRByID($aData);

        $aData['FTBchCode'] = $aCreditNoteHD['raItems']['FTBchCode'];

        $aData['nRow'] = 10000;
        $aData['nPage'] = 1;
        $aData['FTXthDocKey'] = 'TAPTPcHD';

        // Get Data
        if ($aCreditNoteHD['raItems']['FNXphDocType'] == '6') { // ใบลดหนี้มีสินค้า
            $aInsertTmpParams = [
                'tDocNo' => $tDocNo,
                'tBchCode' => $tBchCode,
                'tSessionID' => $tSessionID,
                'tDocKey' => 'TAPTPcHD'
            ];
            $this->mCreditNote->FSaMCreditNoteInsertDTToTemp($aInsertTmpParams);
            $this->mCreditNote->FSaMCreditNoteInsertDTDisToTmp($aInsertTmpParams);
            $this->mCreditNote->FSaMCreditNoteInsertHDDisToTmp($aInsertTmpParams);
        }



        /*echo '<pre>';
        var_dump($aCreditNoteHD);
        echo '</pre>';*/

        $aDataEdit = array(
            'nOptDecimalShow' => $nOptDecimalShow,
            'nOptDocSave' => $nOptDocSave,
            'nOptScanSku' => $nOptScanSku,
            'aResult' => $aCreditNoteHD,
            'aPermission' => $aPermission,
            'aUser' => $aUser,
            'aUserCreated' => $aUserCreated,
            'aUserApv' => $aUserApv,
            'aHDSpl' => $aHDSpl,
            'aSpl' => $aSpl,
            'tUserCode' => $aDataUserLogin['FTUsrCode'],
            'tUserName' => $aDataUserLogin['FTUsrName'],
            'tUserMchCode' => $aDataUserLogin['FTMerCode'],
            'tUserMchCode' => $aDataUserLogin['FTMerCode'],
            'tUserMchName' => $aDataUserLogin['FTMerName'],
            'tUserShpCode' => $aDataUserLogin['FTShpCode'],
            'tUserShpName' => $aDataUserLogin['FTShpName'],
            'tUserWahCode' => $aDataUserLogin['FTWahCode'],
            'tUserWahName' => $aDataUserLogin['FTWahName'],
            'tUserBchCode' => $aDataUserLogin['FTBchCode'],
            'tUserBchName' => $aDataUserLogin['FTBchName'],
            'tUserDptCode' => $aDataUserLogin['FTDptCode'],
            'tUserDptName' => $aDataUserLogin['FTDptName'],
        );

        $this->load->view('document/creditnote/wCreditNoteAdd', $aDataEdit);
    }

    // Functionality : Event Edit Master
    public function FSaCCreditNoteEditEvent()
    {
        try {
            // Get Option Show Decimal  
            $nOptDecimalShow = FCNxHGetOptionDecimalShow();

            $tDocNo = $this->input->post('oetCreditNoteDocNo');
            $tDocType = $this->input->post('ohdCreditNoteDocType');
            $tDocDate = $this->input->post('oetCreditNoteXphDocDate') . " " . $this->input->post('oetCreditNoteDocTime');
            $tUserLevel = $this->session->userdata('tSesUsrLevel');
            $tLoginDpt = $this->session->userdata('tSesUsrDptCode');
            $tBchCode = $this->input->post("oetCreditNoteBchCode"); // ทำรายการได้เฉพาะในสาขาที่เข้าใช้งานเท่านั้น
            $tLoginUser = $this->session->userdata('tSesUsername');
            $tSessionID = $this->session->userdata('tSesSessionID');
            $tSplVatType = $this->input->post('ocmCreditNoteXphVATInOrEx');

            $aCalDTTempParams = [
                'tDocNo' => $tDocNo,
                'tBchCode' => $tBchCode,
                'tSessionID' => $tSessionID,
                'tDocKey' => 'TAPTPcHD'
            ];
            $aCalDTTempForHD = $this->FSaCCreditNoteCalDTTempForHD($aCalDTTempParams);

            $aCalInHDDisTemp = $this->mCreditNote->FSaMCreditNoteCalInHDDisTemp($aCalDTTempParams);

            // var_dump($aCalInHDDisTemp);

            // TAPTPcHD
            $aDataMaster = array(
                'tIsAutoGenCode' => $this->input->post('ocbCreditNoteAutoGenCode'), // ต้องการรัน DocNo อัตโนมัติหรือไม่

                'FTBchCode' => $tBchCode, // รหัสสาขาที่สร้างเอกสาร
                'FTXphDocNo' => $tDocNo, // เลขที่เอกสาร
                'FNXphDocType' => $tDocType, // ประเภทเอกสาร (ใบลดหนี้มีสินค้า หรือ ไม่มีสินค้า)
                'FDXphDocDate' => $tDocDate, // วันที่สร้างเอกสาร
                'FTShpCode' => $this->input->post('oetCreditNoteShpCode'), // รหัสร้านค้า
                'FTXphCshOrCrd' => $this->input->post('ocmCreditNoteXphCshOrCrd'), // ประเภทการชำระเงิน (เงินสด หรือ เชื่อ)
                'FTXphVATInOrEx' => $tSplVatType, // ประเภทภาษี (แยกนอก หรือ รวมใน)
                'FTDptCode' => $tLoginDpt, // รหัสแผนกผู้ที่สร้างเอกสาร
                'FTWahCode' => $this->input->post('oetCreditNoteWahCode'), // รหัสคลังสินค้า
                'FTUsrCode' => $tLoginUser, // รหัสผู้สร้างเอกสาร
                'FTXphApvCode' => NULL, // รหัสผู้อนุมัติ
                'FTSplCode' => $this->input->post('oetCreditNoteSplCode'), // รหัสผู้จำหน่าย
                'FTXphRefExt' => $this->input->post('oetCreditNoteXphRefExt'), // อ้างอิง เลขที่เอกสาร ภายนอก
                'FDXphRefExtDate' => empty($this->input->post('oetCreditNoteXphRefExtDate')) ? NULL : $this->input->post('oetCreditNoteXphRefExtDate'), // อ้างอิง วันที่เอกสาร ภายนอก
                'FTXphRefInt' => $this->input->post('oetCreditNoteRefPICode'), // อ้างอิง เลขที่เอกสาร ภายใน
                'FDXphRefIntDate' => empty($this->input->post('oetCreditNoteXphRefIntDate')) ? NULL : $this->input->post('oetCreditNoteXphRefIntDate'), // อ้างอิง วันที่เอกสาร ภายใน
                'FTXphRefAE' => NULL,
                'FNXphDocPrint' => NULL,
                'FTRteCode' => NULL,
                'FCXphRteFac' => NULL,
                'FCXphTotal' => $aCalDTTempForHD['FCXphTotal'],
                'FCXphTotalNV' => $aCalDTTempForHD['FCXphTotalNV'],
                'FCXphTotalNoDis' => $aCalDTTempForHD['FCXphTotalNoDis'],
                'FCXphTotalB4DisChgV' => $aCalDTTempForHD['FCXphTotalB4DisChgV'],
                'FCXphTotalB4DisChgNV' => $aCalDTTempForHD['FCXphTotalB4DisChgNV'],
                'FTXphDisChgTxt' => isset($aCalInHDDisTemp['FTXphDisChgTxt']) ? $aCalInHDDisTemp['FTXphDisChgTxt'] : '',
                'FCXphDis' => isset($aCalInHDDisTemp['FCXphDis']) ? $aCalInHDDisTemp['FCXphDis'] : NULL,
                'FCXphChg' => isset($aCalInHDDisTemp['FCXphChg']) ? $aCalInHDDisTemp['FCXphChg'] : NULL,
                'FCXphTotalAfDisChgV' => $aCalDTTempForHD['FCXphTotalAfDisChgV'],
                'FCXphTotalAfDisChgNV' => $aCalDTTempForHD['FCXphTotalAfDisChgNV'],
                'FCXphRefAEAmt' => NULL,
                'FCXphAmtV' => $aCalDTTempForHD['FCXphAmtV'],
                'FCXphAmtNV' => $aCalDTTempForHD['FCXphAmtNV'],
                'FCXphVat' => $aCalDTTempForHD['FCXphVat'],
                'FCXphVatable' => $aCalDTTempForHD['FCXphVatable'],
                'FTXphWpCode' => $aCalDTTempForHD['FTXphWpCode'],
                'FCXphWpTax' => $aCalDTTempForHD['FCXphWpTax'],
                'FCXphGrand' => $aCalDTTempForHD['FCXphGrand'],
                'FCXphRnd' => $aCalDTTempForHD['FCXphRnd'],
                'FTXphGndText' => $aCalDTTempForHD['FTXphGndText'],
                'FCXphPaid' => NULL,
                'FCXphLeft' => NULL,
                'FTXphRmk' => $this->input->post('otaCreditNoteXphRmk'),
                'FTXphStaRefund' => NULL,
                'FTXphStaDoc' => '1', // สถานะเอกสาร (1:สมบูรณ์, 2:ไม่สมบูรณ์, 3:ยกเลิก)
                'FTXphStaApv' => NULL,
                'FTXphStaPrcStk' => NULL,
                'FTXphStaPaid' => NULL,
                'FNXphStaDocAct' => $this->input->post('ocbCreditNoteXphStaDocAct'),
                'FNXphStaRef' => $this->input->post('ocmCreditNoteXphStaRef'), // สถานะอ้างอิง (0:ไม่เคยอ้างอิง, 1:อ้างอิงบางส่วน, 2:อ้างอิงหมดแล้ว)

                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FTCreateBy' => $tLoginUser,
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTLastUpdBy' => $tLoginUser
            );

            // TAPTPcHDSpl
            $aDataSpl = array(
                'FTBchCode' => $tBchCode,
                'FTXphDocNo' => $aDataMaster['FTXphDocNo'],
                'FTXphDstPaid' => $this->input->post('ocmCreditNoteHDPcSplXphDstPaid'), // 1:ชำระต้นทาง, 2:ชำระปลายทาง
                'FNXphCrTerm' => $this->input->post('oetCreditNoteHDPcSplXphCrTerm'), // ระยะเครดิต
                'FDXphDueDate' => empty($this->input->post('oetCreditNoteHDPcSplXphDueDate')) ? NULL : $this->input->post('oetCreditNoteHDPcSplXphDueDate'), // วันที่ครบกำหนด
                'FDXphBillDue' => empty($this->input->post('oetCreditNoteHDPcSplXphBillDue')) ? NULL : $this->input->post('oetCreditNoteHDPcSplXphBillDue'), // วันที่จะรับ/วางบิล
                'FTXphCtrName' => $this->input->post('oetCreditNoteHDPcSplXphCtrName'), // ชื่อผู้ตืดต่อ
                'FDXphTnfDate' => empty($this->input->post('oetCreditNoteHDPcSplXphTnfDate')) ? NULL : $this->input->post('oetCreditNoteHDPcSplXphTnfDate'), // วันที่ส่งของ
                'FTXphRefTnfID' => $this->input->post('oetCreditNoteHDPcSplXphRefTnfID'), // เลขที่ ใบขนส่ง
                'FTXphRefVehID' => $this->input->post('oetCreditNoteHDPcSplXphRefVehID'), // อ้างอิง เลขที่ ยานพาหนะ ขนส่ง
                'FTXphRefInvNo' => $this->input->post('oetCreditNoteHDPcSplXphRefInvNo'), // เลขที่บัญชีราคาสินค้า
                'FTXphQtyAndTypeUnit' => $this->input->post('oetCreditNoteHDPcSplXphQtyAndTypeUnit'), // จำนวนและลักษณะหีบห่อ
                'FNXphShipAdd' => NULL, // อ้างอิง ที่อยู่ ส่งของ
                'FNXphTaxAdd' => NULL, // อ้างอิง ที่อยู่ออกใบกำกับภาษี
            );

            /*echo '<pre>';
            var_dump($aDataMaster); 
            echo '</pre>';
            return;*/

            // เตรียมข้อมูลสำหรับ HD ใบลดหนี้ไม่มีสินค้า
            $tPdtCode = $this->input->post('tPdtCode');
            $tPdtName = $this->input->post('tPdtName');
            $tCalEndOfBillNonePdt = $this->input->post('tCalEndOfBillNonePdt');
            $aCalEndOfBillNonePdt = json_decode($tCalEndOfBillNonePdt, true);

            if ($aDataMaster['FNXphDocType'] == '7') { // ใบลดหนี้ไม่มีสินค้า
                $aDataMaster['FCXphTotal'] = FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cTotalValue']); // ยอดรวม
                $aDataMaster['FCXphTotalNV'] = NULL; // ยอดรวมสินค้าไม่มีภาษี
                $aDataMaster['FCXphTotalNoDis'] = NULL; // ยอดรวมสินค้าห้ามลด
                $aDataMaster['FCXphTotalB4DisChgV'] = NULL; // ยอมรวมสินค้าลดได้ และมีภาษี
                $aDataMaster['FCXphTotalB4DisChgNV'] = NULL; // ยอมรวมสินค้าลดได้ และไม่มีภาษี
                $aDataMaster['FTXphDisChgTxt'] = NULL; // ข้อความมูลค่าลดชาร์จ
                $aDataMaster['FCXphDis'] = NULL; // มูลค่ารวมส่วนลด
                $aDataMaster['FCXphChg'] = NULL; // มูลค่ารวมส่วนชาร์จ
                $aDataMaster['FCXphTotalAfDisChgV'] = NULL; // ยอดรวมหลังลด และมีภาษี
                $aDataMaster['FCXphTotalAfDisChgNV'] = NULL; // ยอดรวมหลังลด และไม่มีภาษี
                $aDataMaster['FCXphAmtV'] = FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cTotalValue']); // ยอดรวมเฉพาะภาษี
                $aDataMaster['FCXphAmtNV'] = NULL; // ยอดรวมเฉพาะไม่มีภาษี
                $aDataMaster['FCXphVat'] = FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cVat']); // ยอดภาษี
                $aDataMaster['FCXphVatable'] = FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cVatable']); // ยอดแยกภาษี
                $aDataMaster['FTXphWpCode'] = FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['tVatCode']); // รหัสอัตราภาษี ณ ที่จ่าย
                $aDataMaster['FCXphWpTax'] = FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cVat']); // ภาษีหัก ณ ที่จ่าย

                $aDataMaster['FCXphGrand'] = FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cTotalValue']); // ยอดรวม
                $aDataMaster['FCXphRnd'] = NULL; // ยอดปัดเศษ
                $aDataMaster['FTXphGndText'] = number_format($aDataMaster['FCXphGrand'], $nOptDecimalShow); // ข้อความ ยอดรวมสุทธิ

                // เตรียมข้อมูลสำหรับ DT ใบลดหนี้ไม่มีสินค้า
                $aDataDT = [
                    'FTBchCode' => $aDataMaster['FTBchCode'], // สาขาสร้าง
                    'FTXphDocNo' => $aDataMaster['FTXphDocNo'], // เลขที่เอกสาร
                    'FNXpdSeqNo' => 1, // ลำดับ
                    'FTPdtCode' => $tPdtCode, // รหัสสินค้า
                    'FTXpdPdtName' => $tPdtName, // ชื่อสินค้า
                    'FCXpdFactor' => 1, // อัตราส่วนต่อหน่วย
                    'FTXpdVatType' => $tSplVatType, // ประเภทภาษี 1:มีภาษี, 2:ไม่มีภาษี
                    'FTVatCode' => $aCalEndOfBillNonePdt['tVatCode'], // รหัสภาษี ณ. ซื้อ
                    'FCXpdVatRate' => FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['nVatrate']), // อัตราภาษี ณ. ซื้อ
                    'FCXpdQty' => 1, // จำนวนชื้น ตาม หน่วย
                    'FCXpdQtyAll' => 1, // จำนวนรวมหน่วยเล็กสุด
                    'FCXpdSetPrice' => FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['tValue']), // ราคาซื้อ ตาม หน่วย * อัตราแลกเปลี่ยน
                    'FCXpdAmtB4DisChg' => FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['tValue']), // มูลค่ารวมก่อนลด
                    'FCXpdNet' => FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['tValue']), // มูลค่าสุทธิก่อนท้ายบิล
                    'FCXpdNetAfHD' => FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cTotalValue']), // มูลค่าสุทธิหลังท้ายบิล
                    'FCXpdVat' => FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cVat']), // มูลค่าภาษี
                    'FCXpdVatable' => FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cVatable']), // มูลค่าแยกภาษี
                    'FCXpdCostIn' => floatval(FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cVat'])) + floatval(FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cVatable'])), // ต้นทุนรวมใน 
                    'FCXpdCostEx' => FCNcUnFormatMoneyToFloat($aCalEndOfBillNonePdt['cVatable']), // ต้นทุนแยกนอก
                    'FTXpdRmk' => 'ใบลดหนี้ไม่มีสินค้า', // หมายเหตุรายการ

                    'FDCreateOn' => date('Y-m-d H:i:s'),
                    'FTCreateBy' => $tLoginUser,
                    'FDLastUpdOn' => date('Y-m-d H:i:s'),
                    'FTLastUpdBy' => $tLoginUser
                ];
            }

            $aParams = array(
                'tSessionID' => $tSessionID,
                'tDocNo' => $aDataMaster['FTXphDocNo'],
                'tBchCode' => $tBchCode,
                'tDocKey' => 'TAPTPcHD',
                'tIsUpdatePage' => '1'
            );

            $this->db->trans_begin();

            /*======================= Begin Data Process =====================*/

            if ($tDocType == '6') { // ใบลดหนี้แบบมีสินค้า
                $this->mCreditNote->FSaMCreditNoteAddUpdateHDHavePdt($aDataMaster);
                $this->mCreditNote->FSaMCreditNoteInsertTmpToDT($aParams);
                $this->mCreditNote->FSaMCreditNoteInsertTmpToDTDis($aParams);
                $this->mCreditNote->FSaMCreditNoteInsertTmpToHDDis($aParams);
            }

            if ($tDocType == '7') { // ใบลดหนี้แบบไม่มีสินค้า
                $this->mCreditNote->FSaMCreditNoteAddUpdateHDNonePdt($aDataMaster);
                $this->mCreditNote->FSaMCreditNoteAddUpdateDTNonePdt($aDataDT);
            }

            $this->mCreditNote->FSaMCreditNoteAddUpdatePCHDSpl($aDataSpl);


            // $this->mCreditNote->FSaMCreditNoteAddUpdateDocNoInDocTemp($aDataWhere); // Update DocNo ในตาราง Doctemp
            // $this->mCreditNote->FSaMCreditNoteInsertTmpToDT($aDataWhere); // Insert DT Temp to DT
            // $this->mCreditNote->FSxMClearPdtInTmp();
            // $this->mCreditNote->FSxMClearDTDisTmp();
            // $this->mCreditNote->FSxMClearHDDisTmp();

            /*========================= End Data Process =====================*/

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add"
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'    => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'    => $aDataMaster['FTXphDocNo'],
                    'nStaEvent'        => '1',
                    'tStaMessg'        => 'Success Add'
                );
            }

            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aReturn));
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    // Functionality : Function Call DataTables List Master
    public function FSxCCreditNoteDataTable()
    {

        $tAdvanceSearch = $this->input->post('tAdvanceSearch');
        $nPage = $this->input->post('nPageCurrent');

        // Controle Event
        $aAlwEvent = FCNaHCheckAlwFunc('creditNote/0/0');

        // Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }

        // Lang ภาษา
        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");
        // $aLangHave = FCNaHGetAllLangByTable('TSysPmt_L');
        // $nLangHave = FCNnHSizeOf($aLangHave);
        // if($nLangHave > 1){
        //     if($nLangEdit != ''){
        //         $nLangEdit = $nLangEdit;
        //     }else{
        //         $nLangEdit = $nLangResort;
        //     }
        // }else{
        //     if(@$aLangHave[0]->nLangList == ''){
        //         $nLangEdit = '1';
        //     }else{
        //         $nLangEdit = $aLangHave[0]->nLangList;
        //     }
        // }

        $aData  = array(
            'FNLngID' => $nLangEdit,
            'nPage' => $nPage,
            'nRow' => 10,
            'aAdvanceSearch' => json_decode($tAdvanceSearch, true)
        );
        $aResList = $this->mCreditNote->FSaMCreditNoteList($aData);

        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow
        );
        $this->load->view('document/creditnote/wCreditNoteDataTable', $aGenTable);
    }

    // Function : Adv Table Load Data
    public function FSvCCreditNotePdtAdvTblLoadData()
    {
        $tSearchAll = $this->input->post('tSearchAll');
        $tDocNo = $this->input->post('tDocNo');
        $tStaApv = $this->input->post('tStaApv');
        $tStaDoc = $this->input->post('tStaDoc');
        $tSplVatType = $this->input->post('tSplVatType');
        $nPage = $this->input->post('nPageCurrent');

        $aDataWhere = array(
            'tSearchAll'    => $tSearchAll,
            'tDocNo'        => $tDocNo,
            'tDocKey'       => 'TAPTPcHD',
            'nPage'         => $nPage,
            'nRow'          => 10,
            'tSessionID'    => $this->session->userdata('tSesSessionID'),
        );

        // คำนวน DT ใหม่
        // $aResCalDTTmp = $this->FSnCCreditNoteCalulateDTTemp($tXphDocNo, $tXthVATInOrEx);

        // Edit in line
        $tPdtCode = $this->input->post('ptPdtCode');
        $tPunCode = $this->input->post('ptPunCode');

        // Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $aColumnShow = FCNaDCLGetColumnShow('TAPTPcDT');

        // Calcurate Document DT Temp Array Parameter
        $aCalcDTParams = [
            'tDataDocEvnCall' => '1',
            'tDataVatInOrEx' => $tSplVatType,
            'tDataDocNo' => $tDocNo,
            'tDataDocKey' => 'TAPTPcHD',
            'tDataSeqNo' => ''
        ];
        FCNbHCallCalcDocDTTemp($aCalcDTParams);

        $aEndOfBillParams = [
            'tSplVatType'   => $tSplVatType,
            'tDocNo'        => $tDocNo,
            'tDocKey'       => 'TAPTPcHD',
            'nLngID'        => FCNaHGetLangEdit(),
            'tSesSessionID' => $this->session->userdata('tSesSessionID'),
            'tBchCode'      => $this->session->userdata('tSesUsrLevel') == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata('tSesUsrBchCodeDefault')
        ];

        // คำนวณส่วนลดใหม่อีกครั้ง ถ้าหากมีส่วนลดท้ายบิล supawat 03-04-2020 
        $aEndOfBill['aEndOfBillVat']    = FCNaDOCEndOfBillCalVat($aEndOfBillParams);
        $aEndOfBill['aEndOfBillCal']    = FCNaDOCEndOfBillCal($aEndOfBillParams);
        $aEndOfBill['tTextBath']        = FCNtNumberToTextBaht($aEndOfBill['aEndOfBillCal']['cCalFCXphGrand']);

        $aPackDataCalCulate = array(
            'tDocNo'        => $tDocNo,
            'tBchCode'      => '',
            'nB4Dis'        => $aEndOfBill['aEndOfBillCal']['cSumFCXtdNet'],
            'tSplVatType'   => $tSplVatType
        );
        $tCalculateAgain = FSaCCNDocumentUpdateHDDisAgain($aPackDataCalCulate);

        if ($tCalculateAgain == 'CHANGE') {
            $aCalcDTParams = [
                'tDataDocEvnCall'   => '1',
                'tDataVatInOrEx'    => $tSplVatType,
                'tDataDocNo'        => $tDocNo,
                'tDataDocKey'       => 'TAPTPcHD',
                'tDataSeqNo'        => ''
            ];
            $aStaCalcDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTParams);
            if ($aStaCalcDTTemp === TRUE) {
                FCNaHCalculateProrate('TAPTPcHD', $aPackDataCalCulate['tDocNo']);
                FCNbHCallCalcDocDTTemp($aCalcDTParams);
            }
            $aEndOfBill['aEndOfBillVat']    = FCNaDOCEndOfBillCalVat($aEndOfBillParams);
            $aEndOfBill['aEndOfBillCal']    = FCNaDOCEndOfBillCal($aEndOfBillParams);
            $aEndOfBill['tTextBath']        = FCNtNumberToTextBaht($aEndOfBill['aEndOfBillCal']['cCalFCXphGrand']);
        }

        $aDataDT = $this->mCreditNote->FSaMCreditNoteGetDTTempListPage($aDataWhere);
        $aDataDTSum = $this->mCreditNote->FSaMCreditNoteSumDTTemp($aDataWhere);
        
        $aData['nOptDecimalShow']   = $nOptDecimalShow;
        $aData['aColumnShow']       = $aColumnShow;
        $aData['tPdtCode']          = $tPdtCode;
        $aData['tPunCode']          = $tPunCode;
        $aData['aDataDT']           = $aDataDT;
        $aData['aDataDTSum']        = $aDataDTSum;
        $aData['tStaApv']           = $tStaApv;
        $aData['tStaDoc']           = $tStaDoc;
        $aData['nPage']             = $nPage;
        $tTableHtml = $this->load->view('document/creditnote/advancetable/wCreditNotePdtAdvTableData', $aData, true);

        $aResult['tTalbleHtml'] = $tTableHtml;
        $aResult['aEndOfBill'] = $aEndOfBill;
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResult));
    }

    // Function : Adv Table Load Data
    public function FSvCCreditNoteNonePdtAdvTblLoadData()
    {
        $tSearchAll     = $this->input->post('tSearchAll');
        $tDocNo         = $this->input->post('tDocNo');
        $tSplVatType    = $this->input->post('tSplVatType');
        $tStaApv        = $this->input->post('tStaApv');
        $tStaDoc        = $this->input->post('tStaDoc');
        $nPage          = $this->input->post('nPageCurrent');

        $aDataWhere = array(
            'tSearchAll'    => $tSearchAll,
            'tDocNo'        => $tDocNo,
            'tDocKey'       => 'TAPTPcHD',
            'nPage'         => $nPage,
            'nRow'          => 10,
            'tSessionID'    => $this->session->userdata('tSesSessionID'),
        );

        // คำนวน DT ใหม่
        // $aResCalDTTmp = $this->FSnCCreditNoteCalulateDTTemp($tXphDocNo, $tXthVATInOrEx);

        // Edit in line
        $tPdtCode = $this->input->post('ptPdtCode');
        $tPunCode = $this->input->post('ptPunCode');

        // Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();

        $aColumnShow = FCNaDCLGetColumnShow('TAPTPcDT');
        $aTSysPdtParams = [
            'tPdtCode'      => 'Credit Note',
            'tPdtSysTable'  => 'TAPTPcHD',
            'nLngID'        => FCNaHGetLangEdit()
        ];
        $aDataDT        = FCNoHDOCGetTSysPdt($aTSysPdtParams); // $this->mCreditNote->FSaMCreditNoteGetDTTempListPage($aDataWhere);
        $aDataDTSum     = $this->mCreditNote->FSaMCreditNoteSumDTTemp($aDataWhere);

        $aData['nOptDecimalShow']   = $nOptDecimalShow;
        $aData['aColumnShow']       = $aColumnShow;
        $aData['tPdtCode']          = $tPdtCode;
        $aData['tPunCode']          = $tPunCode;
        $aData['oDataDT']           = $aDataDT;
        $aData['aDataDTSum']        = $aDataDTSum;
        $aData['tStaApv']           = $tStaApv;
        $aData['tStaDoc']           = $tStaDoc;
        $aData['nPage']             = $nPage;

        $aDTNontPdtParams = [
            'tDocNo'                => $tDocNo
        ];
        $aDataDTNonePdt             = $this->mCreditNote->FSaMCreditNoteGetDTNonePdt($aDTNontPdtParams); // Data TAPTPcDT
        $aData['aDataDTNonePdt']    = $aDataDTNonePdt;

        $tTableHtml = $this->load->view('document/creditnote/advancetable/wCreditNoteNonePdtAdvTableData', $aData, true);

        $aEndOfBillParams = [
            'tDocNo'        => $tDocNo,
            'tSplVatType'   => $tSplVatType,
            'tDocKey'       => 'TAPTPcHD',
            'nLngID'        => FCNaHGetLangEdit(),
            'tSesSessionID' => $this->session->userdata('tSesSessionID'),
            'tBchCode'      => $this->session->userdata('tSesUsrBchCodeDefault')
        ];
        $aEndOfBill['aEndOfBillVat']    = FCNaDOCEndOfBillCalVat($aEndOfBillParams);
        $aEndOfBill['aEndOfBillCal']    = FCNaDOCEndOfBillCal($aEndOfBillParams);
        $aEndOfBill['tTextBath']        = FCNtNumberToTextBaht($aEndOfBill['aEndOfBillCal']['cCalFCXphGrand']);
        $aResult['tTalbleHtml']         = $tTableHtml;
        $aResult['aEndOfBill']          = $aEndOfBill;
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResult));
    }

    // Function : Adv Table Save
    public function FSvCCreditNoteShowColSave()
    {

        FCNaDCLSetShowCol('TAPTPcDT', '', '');

        $aColShowSet = $this->input->post('aColShowSet');
        $aColShowAllList = $this->input->post('aColShowAllList');
        $aColumnLabelName = $this->input->post('aColumnLabelName');
        $nStaSetDef = $this->input->post('nStaSetDef');

        if ($nStaSetDef == 1) {
            FCNaDCLSetDefShowCol('TAPTPcDT');
        } else {
            for ($i = 0; $i < FCNnHSizeOf($aColShowSet); $i++) {
                FCNaDCLSetShowCol('TAPTPcDT', 1, $aColShowSet[$i]);
            }
        }

        // Reset Seq
        FCNaDCLUpdateSeq('TAPTPcDT', '', '', '');
        $q = 1;
        for ($n = 0; $n < FCNnHSizeOf($aColShowAllList); $n++) {
            FCNaDCLUpdateSeq('TAPTPcDT', $aColShowAllList[$n], $q, $aColumnLabelName[$n]);
            $q++;
        }
    }

    // Function : Adv Table Show
    public function FSvCCreditNoteAdvTblShowColList()
    {

        $aAvailableColumn = FCNaDCLAvailableColumn('TAPTPcDT');
        $aData['aAvailableColumn'] = $aAvailableColumn;
        $this->load->view('document/creditnote/advancetable/wPurchaseTableShowColList', $aData);
    }

    // Function : ค้นหา รายการ
    public function FSxCCreditNoteFormSearchList()
    {

        // Lang ภาษา
        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");
        $aLangHave = FCNaHGetAllLangByTable('TCNMBranch_L');
        $nLangHave = FCNnHSizeOf($aLangHave);

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

        $aData  = array(
            'FTBchCode' => $this->session->userdata("tSesUsrBchCodeDefault"),
            'FTShpCode'    => '',
            'nPage' => 1,
            'nRow' => 9999,
            'FNLngID' => $nLangEdit,
            'tSearchAll' => ''
        );

        $aBchData = $this->mBranch->FSnMBCHList($aData);
        $aShpData = $this->mShop->FSaMSHPList($aData);

        $aDataMaster = array(
            'aBchData' => $aBchData,
            'aShpData' => $aShpData
        );

        $this->load->view('document/creditnote/wCreditNoteFormSearchList', $aDataMaster);
    }

    /**
     * Functionality : Event Delete Product
     * Parameters : Ajax jReason()
     * Creator : 22/05/2019 Piya
     * Return : Status Delete Event
     * Return Type : String
     */
    public function FSvCCreditNotePdtMultiDeleteEvent()
    {
        $tDocNo = $this->input->post('tDocNo');
        $tPdtCode  = $this->input->post('tPdtCode');
        $tPunCode  = $this->input->post('tPunCode');
        $aSeqCode   = $this->input->post('tSeqCode');
        $tSession   = $this->session->userdata('tSesSessionID');
        $nCount     = FCNnHSizeOf($aSeqCode);

        if ($nCount > 1) {

            for ($i = 0; $i < $nCount; $i++) {

                $aDataMaster = array(
                    'tDocNo'    => $tDocNo,
                    'nSeqNo'    => $aSeqCode[$i],
                    'tDocKey'   => 'TAPTPcHD',
                    'tSessionID'   => $tSession
                );
                $aResDel = $this->mCreditNote->FSaMCreditNotePdtTmpMultiDel($aDataMaster);
            }
        } else {

            $aDataMaster = array(
                'tDocNo'    => $tDocNo,
                'nSeqNo'    => $aSeqCode[0],
                'tDocKey'   => 'TAPTPcHD',
                'tSessionID'   => $tSession
            );
            $aResDel = $this->mCreditNote->FSaMCreditNotePdtTmpMultiDel($aDataMaster);
        }

        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    /**
     * Functionality : Approve Doc
     * Parameters : $tSelect "docCreditNoteCode"
     * Creator : 28/05/2019 piya
     * Last Modified : -
     * Return : Check status true or false
     * Return Type : String
     */
    public function FSvCCreditNoteApprove()
    {

        $tDocNo  = $this->input->post('tDocNo');
        $tStaApv = $this->input->post('tStaApv');
        $tDocType = $this->input->post('tDocType');
        $tBchCode = $this->input->post('tBchCode');

        $aDataUpdate = array(
            'tDocNo' => $tDocNo,
            'tApvCode' => $this->session->userdata('tSesUsername')
        );

        if ($tDocType == '6') { // ใบลดหนี้มีสินค้า

            $this->db->trans_begin();

            $aStaApv = $this->mCreditNote->FSaMCreditNoteHavePdtApprove($aDataUpdate);
            $tUsrBchCode = $tBchCode;

            try {
                $aMQParams = [
                    "queueName" => "PURCHASECN",
                    "params" => [
                        "ptBchCode"     => $tUsrBchCode,
                        "ptDocNo"       => $tDocNo,
                        "ptDocType"     => $tDocType,
                        "ptUser"        => $this->session->userdata('tSesUsername')
                    ]
                ];
                FCNxCallRabbitMQ($aMQParams);

                $this->db->trans_commit();
            } catch (\ErrorException $err) {

                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => language('common/main/main', 'tApproveFail')
                );
                // echo json_encode($aReturn);
                $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aReturn));
                return;
            }
        }

        if ($tDocType == '7') { // ใบลดหนี้ไม่มีสินค้า
            $aStaApv = $this->mCreditNote->FSaMCreditNoteNonePdtApprove($aDataUpdate);
        }
    }

    /**
     * Functionality : Cancel Doc
     * Parameters : $tSelect "docCreditNoteCode"
     * Creator : 28/05/2019 piya
     * Last Modified : -
     * Return : Check status true or false
     * Return Type : String
     */
    public function FSvCCreditNoteCancel()
    {

        $tDocNo = $this->input->post('tDocNo');

        $aDataUpdate = array(
            'tDocNo' => $tDocNo,
        );

        $aStaApv = $this->mCreditNote->FSaMCreditNoteCancel($aDataUpdate);

        if ($aStaApv['rtCode'] == 1) {
            $aApv = array(
                'nSta' => 1,
                'tMsg' => "Cancel done.",
            );
        } else {
            $aApv = array(
                'nSta' => 2,
                'tMsg' => "Not Cancel.",
            );
        }
        echo json_encode($aApv);
    }

    /**
     * Functionality : Doc credit note code unique check
     * Parameters : $tSelect "docCreditNoteCode"
     * Creator : 28/05/2019 piya
     * Last Modified : -
     * Return : Check status true or false
     * Return Type : String
     */
    public function FStCCreditNoteUniqueValidate($tSelect = '')
    {

        if ($this->input->is_ajax_request()) { // Request check
            if ($tSelect == 'docCreditNoteCode') {

                $tCreditNoteDocCode = $this->input->post('tCreditNoteCode');
                $oCreditNoteDoc = $this->mCreditNote->FSnMCreditNoteCheckDuplicate($tCreditNoteDocCode);

                $tStatus = 'false';
                if ($oCreditNoteDoc[0]->counts > 0) { // If have record
                    $tStatus = 'true';
                }
                echo $tStatus;
            }
            echo 'Param not match.';
        } else {
            echo 'Method Not Allowed';
        }
    }

    /**
     * Functionality : Cal End Of Bill ใบลดหนี้ไม่สินค้า
     * Parameters : input params
     * Creator : 28/06/2019 piya
     * Last Modified : -
     * Return : Check status true or false
     * Return Type : String
     */
    public function FSoCreditNoteCalEndOfBillNonePdt()
    {
        // Get Option Show Decimal  
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();

        $tSplVatType = $this->input->post('tSplVatType');
        $tVatCode = $this->input->post('tVatCode');
        $tValue = empty($this->input->post('tValue')) ? 0 : $this->input->post('tValue');
        $oVatActive = FCNoHVatActiveList($tVatCode);

        $aCalEndOfBill = [];

        if (empty($oVatActive)) {
            return;
        }

        try {

            /** ======================== Begin Process ==========================*/
            $cVatrate = $oVatActive->FCVatRate; // อัตราภาษี

            if ($tSplVatType == '1') { // ภาษีรวมใน
                $cCalVat = floatval($tValue) - ((floatval($tValue) * 100) / (100 + floatval($cVatrate))); // คำนวณภาษี
            }

            if ($tSplVatType == '2') { // ภาษีแยกนอก
                $cCalVat = ((floatval($tValue) * (100 + floatval($cVatrate)) / 100)) - floatval($tValue); // คำนวณภาษี
            }


            $tVatrateText = number_format($cVatrate) . '%'; // อัตราภาษี
            $cVat = floatval($cCalVat); // ภาษี
            $cValue = floatval($tValue); // มูลค่า
            $cVatable = floatval($tValue) - floatval($cCalVat);

            $cCostIn = floatval($cCalVat) + floatval($cVatable);
            $cCostEx = floatval($cVatable);

            $cTotalValueVatEx = floatval($cValue) + floatval($cCalVat); // มูลค่าหลังรวมภาษี ภาษีแยกนอก
            $cTotalValueVatIn = floatval($cValue); // มูลค่าหลังรวมภาษี ภาษีรวมใน

            $cTotalValue = 0.00;
            if ($tSplVatType == '1') { // ภาษีรวมใน
                $cTotalValue = $cTotalValueVatIn;
            }

            if ($tSplVatType == '2') { // ภาษีแยกนอก
                $cTotalValue = $cTotalValueVatEx;
            }

            $tTotalValueText = FCNtNumberToTextBaht(number_format($cTotalValue, $nOptDecimalShow));

            $aCalEndOfBill['tSplVatType'] = $tSplVatType; // ประเภทภาษี
            $aCalEndOfBill['tVatCode'] = $tVatCode; // รหัสภาษี
            $aCalEndOfBill['cVat'] = number_format($cVat, $nOptDecimalShow);
            $aCalEndOfBill['nVatrate'] = number_format($cVatrate); // อัตราภาษี
            $aCalEndOfBill['tVatrateText'] = $tVatrateText;
            $aCalEndOfBill['cTotalValue'] = number_format($cTotalValue, $nOptDecimalShow);
            $aCalEndOfBill['tValue'] = number_format($cValue, $nOptDecimalShow); // มูลค่า
            $aCalEndOfBill['cVatable'] = number_format($cVatable, $nOptDecimalShow); // มูลค่าแยกภาษี
            $aCalEndOfBill['tTotalValueText'] = $tTotalValueText;
            $aCalEndOfBill['cCostIn'] = number_format($cCostIn, $nOptDecimalShow); // ต้นทุนรวมใน
            $aCalEndOfBill['cCostEx'] = number_format($cCostEx, $nOptDecimalShow); // ต้นทุนแยกนอก
            /** ======================== End Process ============================*/
            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aCalEndOfBill));
        } catch (\ErrorException $err) {
            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode('{}'));
        }
    }

    /**
     * Functionality : Multi Delete Doc
     * Parameters : Ajax Function Delete Vatrate
     * Creator : 14/06/2018 piya
     * Last Modified : -
     * Return : Status Delete Doc
     * Return Type : object
     */
    public function FSoCreditNoteDeleteMultiDoc()
    {
        $aDocNo = $this->input->post('aDocNo');

        $this->db->trans_begin();

        foreach ($aDocNo as $aItem) {
            $aDelMasterParams = [
                'tDocNo' => trim($aItem)
            ];
            echo $aDelMasterParams['tDoNo'];
            $this->mCreditNote->FSaMCreditNoteDelMaster($aDelMasterParams);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Cannot Delete Item.',
            );
        } else {
            $this->db->trans_commit();
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Delete Complete.',
            );
        }
        return json_encode($aStatus);
    }

    /**
     * Functionality : Delete Doc
     * Parameters : -
     * Creator : 27/08/2018 piya
     * Last Modified : -
     * Return : Vat code
     * Return Type : Object
     */
    public function FSoCreditNoteDeleteDoc()
    {

        $tDocNo = $this->input->post('tDocNo');

        $this->db->trans_begin();

        $aDelMasterParams = [
            'tDocNo' => trim($tDocNo)
        ];
        $this->mCreditNote->FSaMCreditNoteDelMaster($aDelMasterParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Cannot Delete Item.',
            );
        } else {
            $this->db->trans_commit();
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Delete Complete.',
            );
        }
        return json_encode($aStatus);
    }

    /**
     * Functionality : Clear Temp
     * Parameters : -
     * Creator : 27/08/2018 piya
     * Last Modified : -
     * Return : Status Clear Temp
     * Return Type : Array
     */
    public function FSaCreditNoteClearTemp()
    {

        $this->db->trans_begin();

        /*======================= Begin Data Process =====================*/

        $this->mCreditNote->FSxMClearPdtInTmp();
        $this->mCreditNote->FSxMClearDTDisTmp();
        $this->mCreditNote->FSxMClearHDDisTmp();

        /*========================= End Data Process =====================*/

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Unsucess Clear Temp"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaCallBack' => $this->session->userdata('tBtnSaveStaActive'),
                'nStaEvent' => '1',
                'tStaMessg' => 'Success Clear Temp'
            );
        }
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

     //ทุกครั้งที่เปลี่ยน SPL จะส่งผล ให้เกิดการคำนวณ VAT ใหม่
     public function FSoCCreditNoteChangeSPLAffectNewVAT(){
        $tCNDocNo       = $this->input->post('tCNDocNo');
        $tBCHCode       = $this->input->post('tBCHCode');
        $tVatCode       = $this->input->post('tVatCode');
        $tVatRate       = $this->input->post('tVatRate');

        $aItem = [
            'tCNDocNo'      => $tCNDocNo,
            'tBCHCode'      => $tBCHCode,
            'tSessionID'    => $this->session->userdata('tSesSessionID'),
            'tDocKey'       => 'TAPTPcHD',
            'FTVatCode'     => $tVatCode,
            'FCXtdVatRate'  => $tVatRate
        ];
        $this->mCreditNote->FSaMCNChangeSPLAffectNewVAT($aItem);
    }

}
