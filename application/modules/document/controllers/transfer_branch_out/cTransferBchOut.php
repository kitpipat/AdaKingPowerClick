<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cTransferBchOut extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('company/company/mCompany');
        $this->load->model('document/transfer_branch_out/mTransferBchOut');
        $this->load->model('document/transfer_branch_out/mTransferBchOutPdt');
        $this->load->model('payment/rate/mRate');
        $this->load->model('company/vatrate/mVatRate');
        $this->load->model('company/branch/mBranch');
        $this->load->model('company/shop/mShop');
        $this->load->model('authen/login/mLogin');
    }

    public function index($nBrowseType, $tBrowseOption)
    {
        $aParams=array(
            'tDocNo' => $this->input->post('tDocNo'),
            'tBchCode' => $this->input->post('tBchCode'),
            'tAgnCode' => $this->input->post('tAgnCode'),
        );
        
        $aData['nBrowseType'] = $nBrowseType;
        $aData['tBrowseOption'] = $tBrowseOption;
        $aData['aAlwEvent'] = FCNaHCheckAlwFunc('docTransferBchOut/0/0');
        $aData['vBtnSave'] = FCNaHBtnSaveActiveHTML('docTransferBchOut/0/0');
        $aData['nOptDecimalShow'] = FCNxHGetOptionDecimalShow();
        $aData['nOptDecimalSave'] = FCNxHGetOptionDecimalSave();
        $aData['aParams'] = $aParams;
        $this->load->view('document/transfer_branch_out/wTransferBchOut', $aData);
    }

    /**
     * Functionality : Main Page List
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : List Page
     * Return Type : View
     */
    public function FSxCTransferBchOutList()
    {
        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");
        $aData = array(
            'FTBchCode'    => $this->session->userdata("tSesUsrBchCode"),
            'FTShpCode'    => '',
            'nPage' => 1,
            'nRow' => 20,
            'FNLngID' => $nLangEdit,
            'tSearchAll' => ''
        );

        $aBchData = $this->mBranch->FSnMBCHList($aData);
        $aShpData = $this->mShop->FSaMSHPList($aData);
        $aDataMaster = array(
            'aBchData' => $aBchData,
            'aShpData' => $aShpData
        );

        $this->load->view('document/transfer_branch_out/wTransferBchOutList', $aDataMaster);
    }

    /**
     * Functionality : Get HD Table List
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : HD Table List
     * Return Type : View
     */
    public function FSxCTransferBchOutDataTable()
    {
        $tAdvanceSearchData = $this->input->post('oAdvanceSearch');
        $nPage = $this->input->post('nPageCurrent');
        $aAlwEvent = FCNaHCheckAlwFunc('docTransferBchOut/0/0');
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();



        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }

        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");
        $aData = array(
            'FNLngID' => $nLangEdit,
            'nPage' => $nPage,
            'nRow' => 10,
            'aAdvanceSearch' => json_decode($tAdvanceSearchData, true)
        );

        $aResList = $this->mTransferBchOut->FSaMHDList($aData);
        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow
        );

        $this->load->view('document/transfer_branch_out/wTransferBchOutDatatable', $aGenTable);
    }

    /**
     * Functionality : Add Page
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Add Page
     * Return Type : View
     */
    public function FSxCTransferBchOutAddPage()
    {
        $tUserSessionID = $this->session->userdata('tSesSessionID');
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $nOptDocSave = FCNnHGetOptionDocSave();
        $nOptScanSku = FCNnHGetOptionScanSku();

        $aClearInTmpParams = [
            'tUserSessionID' => $tUserSessionID,
            'tDocKey' => 'TCNTPdtTboHD'
        ];
        $this->mTransferBchOut->FSxMClearInTmp($aClearInTmpParams);

        $aDataAdd = array(
            'aResult'           =>  array('rtCode' => '99'),
            'aResultOrdDT'      =>  array('rtCode' => '99'),
            'nOptDecimalShow'   =>  $nOptDecimalShow,
            'nOptScanSku'       =>  $nOptScanSku,
            'nOptDocSave'       =>  $nOptDocSave,
            'tBchCompCode'      =>  FCNtGetBchInComp(),
            'tBchCompName'      =>  FCNtGetBchNameInComp()
        );
        $this->load->view('document/transfer_branch_out/wTransferBchOutPageadd', $aDataAdd);
    }

    /**
     * Functionality : Add Event
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCTransferBchOutAddEvent()
    {
        try {
            $aDataDocument  = $this->input->post();
            $tUserSessionID = $this->session->userdata('tSesSessionID');
            $tUserLoginCode = $this->session->userdata('tSesUsername');
            $tDocDate = $this->input->post('oetTransferBchOutDocDate') . " " . $this->input->post('oetTransferBchOutDocTime');
            $tUserLevel = $this->session->userdata('tSesUsrLevel');
            $tBchCode = $this->input->post('oetTransferBchOutBchCode');

            $aEndOfBillParams = [
                'tSplVatType' => '2', // ภาษีรวมใน
                'tDocNo' => 'TBODOCTEMP',
                'tDocKey' => 'TCNTPdtTboHD',
                'nLngID' => FCNaHGetLangEdit(),
                'tSesSessionID' => $tUserSessionID,
                'tBchCode' => $tBchCode
            ];
            $aEndOfBillCal = FCNaDOCEndOfBillCal($aEndOfBillParams);
            
            $aDataMaster = array(
                'tIsAutoGenCode' => $this->input->post('ocbTransferBchOutAutoGenCode'),
                'FTBchCode' => $tBchCode, // สาขาสร้าง
                'FTXthDocNo' => $this->input->post('oetTransferBchOutDocNo'), // เลขที่เอกสาร  XXYYMM-1234567
                'FDXthDocDate' => $tDocDate, // วันที่/เวลา เอกสาร dd/mm/yyyy H:mm:ss
                'FTXthVATInOrEx' => $this->input->post(''), // ภาษีมูลค่าเพิ่ม 1:รวมใน, 2:แยกนอก
                'FTDptCode' => $this->input->post(''), // แผนก
                'FTXthBchFrm' => $this->input->post('oetTransferBchOutXthBchFrmCode'), // รหัสสาขาต้นทาง
                'FTXthBchTo' => $this->input->post('oetTransferBchOutXthBchToCode'), // รหัสสาขาปลายทาง
                'FTXthMerchantFrm' => $this->input->post('oetTransferBchOutXthMerchantFrmCode'), // รหัสตัวแทน/เจ้าของดำเนินการ(ต้นทาง)
                'FTXthMerchantTo' => $this->input->post(''), // รหัสตัวแทน/เจ้าของดำเนินการ(ปลายทาง)
                'FTXthShopFrm' => $this->input->post('oetTransferBchOutXthShopFrmCode'), // ร้านค้า(ต้นทาง)
                'FTXthShopTo' => $this->input->post(''), // ร้านค้า(ปลายทาง)
                'FTXthWhFrm' => $this->input->post('oetTransferBchOutXthWhFrmCode'), // รหัสคลัง(ต้นทาง)
                'FTXthWhTo' => $this->input->post('oetTransferBchOutXthWhToCode'), // รหัสคลัง(ปลายทาง)
                'FTUsrCode' => $tUserLoginCode, // พนักงาน Key
                'FTSpnCode' => '', // พนักงานขาย
                'FTXthApvCode' => '', // ผู้อนุมัติ
                // 'FTXthRefExt' => $this->input->post('oetTransferBchOutXthRefExt'),
                // 'FDXthRefExtDate' => empty($this->input->post('oetTransferBchOutXthRefExtDate')) ? NULL : $this->input->post('oetTransferBchOutXthRefExtDate'),
                // 'FTXthRefInt' => $this->input->post('oetTransferBchOutXthRefInt'), 
                // 'FDXthRefIntDate' => empty($this->input->post('oetTransferBchOutXthRefIntDate')) ? NULL : $this->input->post('oetTransferBchOutXthRefIntDate'),
                'FNXthDocPrint' => 0, // จำนวนครั้งที่พิมพ์
                'FCXthTotal' => floatval(str_replace(',', '', $aEndOfBillCal['cSumFCXtdNet'])), // ยอดรวมก่อนลด
                'FCXthVat' => floatval(str_replace(',', '', $aEndOfBillCal['cSumFCXtdVat'])), // ยอดภาษี
                'FCXthVatable' => floatval(str_replace(',', '', $aEndOfBillCal['cSumFCXtdNet'])), // ยอดแยกภาษี
                'FTXthRmk' => $this->input->post('otaTransferBchOutXthRmk'), // หมายเหตุ
                'FTXthStaDoc' => '1', // สถานะ เอกสาร  1:สมบูรณ์, 2:ไม่สมบูรณ์, 3:ยกเลิก
                'FTXthStaApv' => '', // สถานะ อนุมัติ เอกสาร ว่าง:ยังไม่ทำ, 1:อนุมัติแล้ว
                'FTXthStaPrcStk' => '', // สถานะ ประมวลผลสต็อค ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FTXthStaDelMQ' => '', // สถานะลบ MQ ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FNXthStaDocAct' => (isset($aDataDocument['ocbTransferBchOutXthStaDocAct']) == "1") ? 1 : 0, // สถานะ เคลื่อนไหว 0:NonActive, 1:Active
                'FNXthStaRef' => intval($this->input->post('ostTransferBchOutXthStaRef')), // สถานะ อ้างอิง 0:ไม่เคยอ้างอิง, 1:อ้างอิงบางส่วน, 2:อ้างอิงหมดแล้ว
                'FTRsnCode' => $this->input->post('oetTransferBchOutRsnCode'), // รหัสเหตุผล
                // การขนส่ง(TCNTPdtTboHDRef)
                'FTXthCtrName' => $this->input->post('oetTransferBchOutXthCtrName'), // ชื่อผู้ตืดต่อ
                'FDXthTnfDate' => empty($this->input->post('oetTransferBchOutXthTnfDate')) ? NULL : $this->input->post('oetTransferBchOutXthTnfDate'), // วันที่ส่งของ
                'FTXthRefTnfID' => $this->input->post('oetTransferBchOutXthRefTnfID'), // อ้างอิง เลขที่ ใบขนส่ง
                'FTXthRefVehID' => $this->input->post('oetTransferBchOutXthRefVehID'), // อ้างอิง เลขที่ ยานพาหนะ ขนส่ง
                'FTXthQtyAndTypeUnit' => $this->input->post('oetTransferBchOutXthQtyAndTypeUnit'), // จำนวนและลักษณะหีบห่อ
                'FNXthShipAdd' => 0, // อ้างอิง ที่อยู่ ส่งของ null หรือ 0 ไม่กำหนด
                'FTViaCode' => $this->input->post('oetTransferBchOutShipViaCode'), // รหัสการขนส่ง
                'FDLastUpdOn' => date('Y-m-d H:i:s'), // วันที่ปรับปรุงรายการล่าสุด
                'FTLastUpdBy' => $tUserLoginCode, // ผู้ปรับปรุงรายการล่าสุด
                'FDCreateOn' => date('Y-m-d H:i:s'), // วันที่สร้างรายการ
                'FTCreateBy' => $tUserLoginCode, // ผู้สร้างรายการ
            );

            $this->db->trans_begin();

            // Setup Doc No.
            if ($aDataMaster['tIsAutoGenCode'] == '1') { // Check Auto Gen Reason Code?
                // Call Auto Gencode Helper
                $aStoreParam = array(
                    "tTblName" => 'TCNTPdtTboHD',
                    "tDocType" => 6,
                    "tBchCode" => $aDataMaster["FTBchCode"],
                    "tShpCode" => "",
                    "tPosCode" => "",
                    "dDocDate" => date("Y-m-d")
                );
                $aAutogen = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTXthDocNo'] = $aAutogen[0]["FTXxhDocNo"];
            }

            // [Update] ถ้ามีเอกสารอ้างอิงภายใน ต้องกลับไปอัพเดท
            // if($aDataDocument['oetTransferBchOutXthRefInt'] != '' || $aDataDocument['oetTransferBchOutXthRefIntOld'] != ''){

            //     //1: อ้างอิงถึง(ภายใน) => ใบรับของ
            //     $aDataWhereDocRef_Type1 = array(
            //         'FTAgnCode'         => ' ',
            //         'FTBchCode'         => $tBchCode,
            //         'FTXshDocNo'        => $aDataMaster['FTXthDocNo'],
            //         'FTXshRefType'      => 1,
            //         'FTXshRefDocNo'     => $aDataDocument['oetTransferBchOutXthRefInt'],
            //         'FTXshRefKey'       => 'TR',
            //         'FDXshRefDocDate'   => (!empty($aDataDocument['oetTransferBchOutXthRefIntDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetTransferBchOutXthRefIntDate'])) : NULL
            //     );
            //     $this->mTransferBchOut->FSxMBSUpdateRef('TCNTPdtTboHDDocRef',$aDataWhereDocRef_Type1);

            //     //2:ถูกอ้างอิง(ภายใน) => ใบสั่งซื้อ
            //     $aDataWhereDocRef_Type2 = array(
            //         'FTAgnCode'         => ' ',
            //         'FTBchCode'         => $tBchCode,
            //         'FTXshDocNo'        => $aDataDocument['oetTransferBchOutXthRefInt'],
            //         'FTXshRefType'      => 2,
            //         'FTXshRefDocNo'     => $aDataMaster['FTXthDocNo'],
            //         'FTXshRefKey'       => 'BS',
            //         'FDXshRefDocDate'   => (!empty($aDataDocument['oetTransferBchOutXthRefIntDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetTransferBchOutXthRefIntDate'])) : NULL
            //     );
            //     $this->mTransferBchOut->FSxMBSUpdateRef('TCNTPdtReqBchHDDocRef',$aDataWhereDocRef_Type2);
            // }

            // [Update] ถ้ามีเอกสารอ้างอิงภายนอก ต้องกลับไปอัพเดท
            // if($aDataDocument['oetTransferBchOutXthRefExt'] != '' ){

            //     //3: อ้างอิง ภายนอก => ใบวางบิล
            //     $aDataWhereDocRef_Type3 = array(
            //         'FTAgnCode'         => ' ',
            //         'FTBchCode'         => $tBchCode,
            //         'FTXshDocNo'        => $aDataMaster['FTXthDocNo'],
            //         'FTXshRefType'      => 3,
            //         'FTXshRefDocNo'     => $aDataDocument['oetTransferBchOutXthRefExt'],
            //         'FTXshRefKey'       => 'BillNote',
            //         'FDXshRefDocDate'   => (!empty($aDataDocument['oetTransferBchOutXthRefExtDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetTransferBchOutXthRefExtDate'])) : NULL
            //     );
            //     $this->mTransferBchOut->FSxMBSUpdateRef('TCNTPdtTboHDDocRef',$aDataWhereDocRef_Type3);
            // }


            $this->mTransferBchOut->FSaMAddUpdateHD($aDataMaster);
            $this->mTransferBchOut->FSaMAddUpdateHDRef($aDataMaster);

            $aUpdateDocNoInTmpParams = [
                'tDocNo' => $aDataMaster['FTXthDocNo'],
                'tDocKey' => 'TCNTPdtTboHD',
                'tUserSessionID' => $tUserSessionID
            ];
            $this->mTransferBchOut->FSaMUpdateDocNoInTmp($aUpdateDocNoInTmpParams); // Update DocNo ในตาราง Doctemp

            $aTempToDTParams = [
                'tDocNo' => $aDataMaster['FTXthDocNo'],
                'tBchCode' => $aDataMaster['FTBchCode'],
                'tDocKey' => 'TCNTPdtTboHD',
                'tUserSessionID' => $tUserSessionID,
                'tUserLoginCode' => $tUserLoginCode
            ];
            $this->mTransferBchOut->FSaMTempToDT($aTempToDTParams); // คัดลอกข้อมูลจาก Temp to DT

            // [Move] Doc TCNTDocHDRefTmp To TCNTPdtTboHDDocRef
            $this->mTransferBchOut->FSxMTBOMoveHDRefTmpToHDRef($aDataMaster);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add"
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack' => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn' => $aDataMaster['FTXthDocNo'],
                    'nStaEvent'    => '1',
                    'tStaMessg' => 'Success Add'
                );
            }

            $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    /**
     * Functionality : Edit Page
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Edit Page
     * Return Type : View
     */
    public function FSvCTransferBchOutEditPage()
    {
        $tDocNo         = $this->input->post('tDocNo');
        $nLangEdit      = $this->session->userdata("tLangEdit");
        // $nLangResort = $this->session->userdata("tLangID");
        // $aLangHave = FCNaHGetAllLangByTable('TFNMRate_L');
        // $tUsrLogin = $this->session->userdata('tSesUsername');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLevel     = $this->session->userdata('tSesUsrLevel');
        // $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCode");

        $aAlwEvent = FCNaHCheckAlwFunc('docTransferBchOut/0/0'); // Access Control
        // Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        // Get Option Scan SKU
        $nOptDocSave = FCNnHGetOptionDocSave();
        //Get Option Scan SKU
        $nOptScanSku = FCNnHGetOptionScanSku();

        $aClearInTmpParams = [
            'tUserSessionID' => $tUserSessionID,
            'tDocKey' => 'TCNTPdtTboHD'
        ];
        $this->mTransferBchOut->FSxMClearInTmp($aClearInTmpParams);

        // Get Data
        $aGetHDParams = array(
            'tDocNo' => $tDocNo,
            'nLngID' => $nLangEdit,
            'tDocKey' => 'TCNTPdtTboHD',
        );
        $aResult = $this->mTransferBchOut->FSaMGetHD($aGetHDParams); // Data TCNTPdtTboHD

        $aDTToTempParams = [
            'tDocNo' => $tDocNo,
            'tDocKey' => 'TCNTPdtTboHD',
            'tBchCode' => isset($aResult['raItems']['FTBchCode']) ? $aResult['raItems']['FTBchCode'] : '',
            'tUserSessionID' => $tUserSessionID,
            'nLngID' => $nLangEdit
        ];
        $this->mTransferBchOut->FSaMDTToTemp($aDTToTempParams);

        // Move Data HDDocRef TO HDRefTemp
        $this->mTransferBchOut->FSxMTBOMoveHDRefToHDRefTemp($aDTToTempParams);

        $aDataEdit = array(
            'nOptDecimalShow' => $nOptDecimalShow,
            'nOptDocSave' => $nOptDocSave,
            'nOptScanSku' => $nOptScanSku,
            'aResult' => $aResult,
            'aAlwEvent' => $aAlwEvent,
            'tBchCompCode' => FCNtGetBchInComp(),
            'tBchCompName' => FCNtGetBchNameInComp()
        );
        $this->load->view('document/transfer_branch_out/wTransferBchOutPageadd', $aDataEdit);
    }

    /**
     * Functionality : Edit Event
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCTransferBchOutEditEvent()
    {
        try {
            $aDataDocument          = $this->input->post();
            $this->db->trans_begin();
            if ( $aDataDocument['ohdTransferBchOutStaApv'] == 1 || ( !empty($aDataDocument['ohdTBOStaPrcDoc']) && $aDataDocument['ohdTBOStaPrcDoc'] != "1" ) ) { //ถ้าอนุมัติแล้ว อัพเดทแค่หมายเหตุ/สถานะเคลื่อนไหว ได้อย่างเดียว
                // Array Data update
                $tTWODocNo              = (isset($aDataDocument['oetTransferBchOutDocNo'])) ? $aDataDocument['oetTransferBchOutDocNo'] : '';
                $aDataMaster = array(
                    'FTBchCode'             => $aDataDocument['oetTransferBchOutBchCode'],
                    'FTXthDocNo'            => $tTWODocNo,
                    'FTXthRmk'              => $aDataDocument['otaTransferBchOutXthRmk'],
                    'FNXthStaDocAct'        => (isset($aDataDocument['ocbTransferBchOutXthStaDocAct']) == "1") ? 1 : 0,
                );
                // [Update] update หมายเหตุ
                $this->mTransferBchOut->FSaMHDUpdateRmk($aDataMaster);
            } else { //ถ้ายังไม่อนุมัติ ก็อัพเดทข้อมูลปกติ

                $tUserSessionID = $this->session->userdata('tSesSessionID');
                $tUserLoginCode = $this->session->userdata('tSesUsername');
                $tDocDate = $this->input->post('oetTransferBchOutDocDate') . " " . $this->input->post('oetTransferBchOutDocTime');
                $tUserLevel = $this->session->userdata('tSesUsrLevel');
                $tBchCode = $this->input->post('oetTransferBchOutBchCode');

                $aEndOfBillParams = [
                    'tSplVatType' => '2', // ภาษีรวมใน
                    'tDocNo' => 'TBODOCTEMP',
                    'tDocKey' => 'TCNTPdtTboHD',
                    'nLngID' => FCNaHGetLangEdit(),
                    'tSesSessionID' => $tUserSessionID,
                    'tBchCode' => $tBchCode
                ];
                $aEndOfBillCal = FCNaDOCEndOfBillCal($aEndOfBillParams);

                $aDataMaster = array(
                    'tIsAutoGenCode' => $this->input->post('ocbTransferBchOutAutoGenCode'),
                    'FTBchCode' => $tBchCode, // สาขาสร้าง
                    'FTXthDocNo' => $this->input->post('oetTransferBchOutDocNo'), // เลขที่เอกสาร  XXYYMM-1234567
                    'FDXthDocDate' => $tDocDate, // วันที่/เวลา เอกสาร dd/mm/yyyy H:mm:ss
                    'FTXthVATInOrEx' => $this->input->post(''), // ภาษีมูลค่าเพิ่ม 1:รวมใน, 2:แยกนอก
                    'FTDptCode' => $this->input->post(''), // แผนก
                    'FTXthBchFrm' => $this->input->post('oetTransferBchOutXthBchFrmCode'), // รหัสสาขาต้นทาง
                    'FTXthBchTo' => $this->input->post('oetTransferBchOutXthBchToCode'), // รหัสสาขาปลายทาง
                    'FTXthMerchantFrm' => $this->input->post('oetTransferBchOutXthMerchantFrmCode'), // รหัสตัวแทน/เจ้าของดำเนินการ(ต้นทาง)
                    'FTXthMerchantTo' => $this->input->post(''), // รหัสตัวแทน/เจ้าของดำเนินการ(ปลายทาง)
                    'FTXthShopFrm' => $this->input->post('oetTransferBchOutXthShopFrmCode'), // ร้านค้า(ต้นทาง)
                    'FTXthShopTo' => $this->input->post(''), // ร้านค้า(ปลายทาง)
                    'FTXthWhFrm' => $this->input->post('oetTransferBchOutXthWhFrmCode'), // รหัสคลัง(ต้นทาง)
                    'FTXthWhTo' => $this->input->post('oetTransferBchOutXthWhToCode'), // รหัสคลัง(ปลายทาง)
                    'FTUsrCode' => $tUserLoginCode, // พนักงาน Key
                    'FTSpnCode' => '', // พนักงานขาย
                    'FTXthApvCode' => '', // ผู้อนุมัติ
                    // 'FTXthRefExt' => $this->input->post('oetTransferBchOutXthRefExt'), // อ้างอิง เลขที่เอกสาร ภายนอก
                    // 'FDXthRefExtDate' => empty($this->input->post('oetTransferBchOutXthRefExtDate')) ? NULL : $this->input->post('oetTransferBchOutXthRefExtDate'), // อ้างอิง วันที่เอกสาร ภายนอก
                    // 'FTXthRefInt' => $this->input->post('oetTransferBchOutXthRefInt'), // อ้างอิง เลขที่เอกสาร ภายใน
                    // 'FDXthRefIntDate' => empty($this->input->post('oetTransferBchOutXthRefIntDate')) ? NULL : $this->input->post('oetTransferBchOutXthRefIntDate'), // อ้างอิง วันที่เอกสาร ภายใน
                    'FNXthDocPrint' => 0, // จำนวนครั้งที่พิมพ์
                    'FCXthTotal' => floatval(str_replace(',', '', $aEndOfBillCal['cSumFCXtdNet'])), // ยอดรวมก่อนลด
                    'FCXthVat' => floatval(str_replace(',', '', $aEndOfBillCal['cSumFCXtdVat'])), // ยอดภาษี
                    'FCXthVatable' => floatval(str_replace(',', '', $aEndOfBillCal['cSumFCXtdNet'])), // ยอดแยกภาษี
                    'FTXthRmk' => $this->input->post('otaTransferBchOutXthRmk'), // หมายเหตุ
                    'FTXthStaDoc' => '1', // สถานะ เอกสาร  1:สมบูรณ์, 2:ไม่สมบูรณ์, 3:ยกเลิก
                    'FTXthStaApv' => '', // สถานะ อนุมัติ เอกสาร ว่าง:ยังไม่ทำ, 1:อนุมัติแล้ว
                    'FTXthStaPrcStk' => '', // สถานะ ประมวลผลสต็อค ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                    'FTXthStaDelMQ' => '', // สถานะลบ MQ ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                    'FNXthStaDocAct' => (isset($aDataDocument['ocbTransferBchOutXthStaDocAct']) == "1") ? 1 : 0, // สถานะ เคลื่อนไหว 0:NonActive, 1:Active
                    'FNXthStaRef' => intval($this->input->post('ostTransferBchOutXthStaRef')), // สถานะ อ้างอิง 0:ไม่เคยอ้างอิง, 1:อ้างอิงบางส่วน, 2:อ้างอิงหมดแล้ว
                    'FTRsnCode' => $this->input->post('oetTransferBchOutRsnCode'), // รหัสเหตุผล

                    // การขนส่ง(TCNTPdtTboHDRef)
                    'FTXthCtrName' => $this->input->post('oetTransferBchOutXthCtrName'), // ชื่อผู้ตืดต่อ
                    'FDXthTnfDate' => empty($this->input->post('oetTransferBchOutXthTnfDate')) ? NULL : $this->input->post('oetTransferBchOutXthTnfDate'), // วันที่ส่งของ
                    'FTXthRefTnfID' => $this->input->post('oetTransferBchOutXthRefTnfID'), // อ้างอิง เลขที่ ใบขนส่ง
                    'FTXthRefVehID' => $this->input->post('oetTransferBchOutXthRefVehID'), // อ้างอิง เลขที่ ยานพาหนะ ขนส่ง
                    'FTXthQtyAndTypeUnit' => $this->input->post('oetTransferBchOutXthQtyAndTypeUnit'), // จำนวนและลักษณะหีบห่อ
                    'FNXthShipAdd' => 0, // อ้างอิง ที่อยู่ ส่งของ null หรือ 0 ไม่กำหนด
                    'FTViaCode' => $this->input->post('oetTransferBchOutShipViaCode'), // รหัสการขนส่ง

                    'FDLastUpdOn' => date('Y-m-d H:i:s'), // วันที่ปรับปรุงรายการล่าสุด
                    'FTLastUpdBy' => $tUserLoginCode, // ผู้ปรับปรุงรายการล่าสุด
                    'FDCreateOn' => date('Y-m-d H:i:s'), // วันที่สร้างรายการ
                    'FTCreateBy' => $tUserLoginCode, // ผู้สร้างรายการ
                );

                //  // [Update] ถ้ามีเอกสารอ้างอิงภายใน ต้องกลับไปอัพเดท
                // if($aDataDocument['oetTransferBchOutXthRefInt'] != '' || $aDataDocument['oetTransferBchOutXthRefIntOld'] != ''){

                //     //1: อ้างอิงถึง(ภายใน) => ใบรับของ
                //     $aDataWhereDocRef_Type1 = array(
                //         'FTAgnCode'         => ' ',
                //         'FTBchCode'         => $tBchCode,
                //         'FTXshDocNo'        => $aDataMaster['FTXthDocNo'],
                //         'FTXshRefType'      => 1,
                //         'FTXshRefDocNo'     => $aDataDocument['oetTransferBchOutXthRefInt'],
                //         'FTXshRefKey'       => 'TR',
                //         'FDXshRefDocDate'   => (!empty($aDataDocument['oetTransferBchOutXthRefIntDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetTransferBchOutXthRefIntDate'])) : NULL
                //     );
                //     $this->mTransferBchOut->FSxMBSUpdateRef('TCNTPdtTboHDDocRef',$aDataWhereDocRef_Type1);

                //     //2:ถูกอ้างอิง(ภายใน) => ใบสั่งซื้อ
                //     $aDataWhereDocRef_Type2 = array(
                //         'FTAgnCode'         => ' ',
                //         'FTBchCode'         => $tBchCode,
                //         'FTXshDocNo'        => $aDataDocument['oetTransferBchOutXthRefInt'],
                //         'FTXshRefType'      => 2,
                //         'FTXshRefDocNo'     => $aDataMaster['FTXthDocNo'],
                //         'FTXshRefKey'       => 'BS',
                //         'FDXshRefDocDate'   => (!empty($aDataDocument['oetTransferBchOutXthRefIntDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetTransferBchOutXthRefIntDate'])) : NULL
                //     );
                //     $this->mTransferBchOut->FSxMBSUpdateRef('TCNTPdtReqBchHDDocRef',$aDataWhereDocRef_Type2);
                // }

                // // [Update] ถ้ามีเอกสารอ้างอิงภายนอก ต้องกลับไปอัพเดท
                // if($aDataDocument['oetTransferBchOutXthRefExt'] != '' ){

                //     //3: อ้างอิง ภายนอก => ใบวางบิล
                //     $aDataWhereDocRef_Type3 = array(
                //         'FTAgnCode'         => ' ',
                //         'FTBchCode'         => $tBchCode,
                //         'FTXshDocNo'        => $aDataMaster['FTXthDocNo'],
                //         'FTXshRefType'      => 3,
                //         'FTXshRefDocNo'     => $aDataDocument['oetTransferBchOutXthRefExt'],
                //         'FTXshRefKey'       => 'BillNote',
                //         'FDXshRefDocDate'   => (!empty($aDataDocument['oetTransferBchOutXthRefExtDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetTransferBchOutXthRefExtDate'])) : NULL
                //     );
                //     $this->mTransferBchOut->FSxMBSUpdateRef('TCNTPdtTboHDDocRef',$aDataWhereDocRef_Type3);
                // }

                $this->mTransferBchOut->FSaMAddUpdateHD($aDataMaster);
                $this->mTransferBchOut->FSaMAddUpdateHDRef($aDataMaster);

                $aUpdateDocNoInTmpParams = [
                    'tDocNo' => $aDataMaster['FTXthDocNo'],
                    'tDocKey' => 'TCNTPdtTboHD',
                    'tUserSessionID' => $tUserSessionID
                ];
                $this->mTransferBchOut->FSaMUpdateDocNoInTmp($aUpdateDocNoInTmpParams); // Update DocNo ในตาราง Doctemp

                $aTempToDTParams = [
                    'tDocNo' => $aDataMaster['FTXthDocNo'],
                    'tBchCode' => $aDataMaster['FTBchCode'],
                    'tDocKey' => 'TCNTPdtTboHD',
                    'tUserSessionID' => $tUserSessionID,
                    'tUserLoginCode' => $tUserLoginCode
                ];
                $this->mTransferBchOut->FSaMTempToDT($aTempToDTParams); // คัดลอกข้อมูลจาก Temp to DT

                // [Move] Doc TCNTDocHDRefTmp To TCNTPdtTboHDDocRef
                $this->mTransferBchOut->FSxMTBOMoveHDRefTmpToHDRef($aDataMaster);

            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit Event"
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack' => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn' => $aDataMaster['FTXthDocNo'],
                    'nStaEvent'    => '1',
                    'tStaMessg' => 'Success Edit Event'
                );
            }

            $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    /**
     * Functionality : Check Doc No. Duplicate
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStCTransferBchOutUniqueValidate()
    {
        $aStatus = ['bStatus' => false];

        if ($this->input->is_ajax_request()) { // Request check
            $tTransferBchOutDocCode = $this->input->post('tTransferBchOutCode');
            $bIsDocNoDup = $this->mTransferBchOut->FSbMCheckDuplicate($tTransferBchOutDocCode);

            if ($bIsDocNoDup) { // If have record
                $aStatus['bStatus'] = true;
            }
        } else {
            echo 'Method Not Allowed';
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aStatus));
    }

    /**
     * Functionality : Cancel Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStCTransferBchOutDocCancel()
    {

        $tDocNo = $this->input->post('tDocNo');

        $this->db->trans_begin();

        $aDocCancelParams = array(
            'tDocNo' => $tDocNo,
        );
        $this->mTransferBchOut->FSxMDocCancel($aDocCancelParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aCancel = array(
                'nSta' => 2,
                'tMsg' => $this->db->error()['message'],
            );
        } else {
            $this->db->trans_commit();
            $aCancel = array(
                'nSta' => 1,
                'tMsg' => "Cancel Success",
            );
        }
        echo json_encode($aCancel);
    }

    /**
     * Functionality : Approve Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : Napat(Jame) 31/07/2020
     * Return : Status
     * Return Type : String
     */
    public function FStCTransferBchOutDocApprove()
    {
        $tDocNo         = $this->input->post('tDocNo');
        $tDocType       = $this->input->post('tDocType');
        // $tUserLevel = $this->session->userdata('tSesUsrLevel');
        // $tBchCode = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCode");
        $tUserLoginCode = $this->session->userdata('tSesUsername');
        $tBchCode       = $this->input->post('tBchCode');

        $this->db->trans_begin();
        $aDocApproveParams = array(
            'tDocNo'    => $tDocNo,
            'tApvCode'  => $tUserLoginCode
        );
        $this->mTransferBchOut->FSxMTBODocApprove($aDocApproveParams);

        try {
            $aMQParams = [
                "queueName" => "TNFBRANCHOUT",
                "params" => [
                    "ptBchCode"     => $tBchCode,
                    "ptDocNo"       => $tDocNo,
                    "ptDocType"     => "6",
                    "ptUser"        => $tUserLoginCode,
                ]
            ];
            FCNxCallRabbitMQ($aMQParams);

            $aDataGetDataHD     =   $this->mTransferBchOut->FSaMGetHD(array(
                'tDocNo'       => $tDocNo,
                'nLngID'       => $this->session->userdata("tLangEdit"),
                'tDocKey'      => 'TCNTPdtTboHD',
            ));
            if($aDataGetDataHD['rtCode']=='1'){
                $tNotiID = FCNtHNotiGetNotiIDByDocRef($aDataGetDataHD['raItems']['FTXthDocNo']);
                $aMQParamsNoti = [
                    "queueName" => "CN_SendToNoti",
                    "tVhostType" => "NOT",
                    "params"    => [
                        "oaTCNTNoti" => array(
                            "FNNotID"       => $tNotiID,
                            "FTNotCode"     => '00008',
                            "FTNotKey"      => 'TCNTPdtTboHD',
                            "FTNotBchRef"    => $aDataGetDataHD['raItems']['FTBchCode'],
                            "FTNotDocRef"   => $aDataGetDataHD['raItems']['FTXthDocNo'],
                        ),
                        "oaTCNTNoti_L" => array(
                            0 => array(
                                "FNNotID"       => $tNotiID,
                                "FNLngID"       => 1,
                                "FTNotDesc1"    => 'เอกสารใบจ่ายโอน #'.$aDataGetDataHD['raItems']['FTXthDocNo'],
                                "FTNotDesc2"    => 'รหัสสาขา '.$aDataGetDataHD['raItems']['FTBchCode'].' อนุมัติใบจ่ายโอนไปยังสาขา '.$aDataGetDataHD['raItems']['FTXthBchTo'],
                            ),
                            1 => array(
                                "FNNotID"       => $tNotiID,
                                "FNLngID"       => 2,
                                "FTNotDesc1"    => 'Transfer Branch Out #'.$aDataGetDataHD['raItems']['FTXthDocNo'],
                                "FTNotDesc2"    => 'Branch code '.$aDataGetDataHD['raItems']['FTBchCode'].' Approve document To Branch Code '.$aDataGetDataHD['raItems']['FTXthBchTo'],
                            )
                        ),
                        "oaTCNTNotiAct" => array(
                            0 => array(  
                                "FNNotID"       => $tNotiID,
                                "FDNoaDateInsert" => date('Y-m-d H:i:s'),
                                "FTNoaDesc"      => 'รหัสสาขา '.$aDataGetDataHD['raItems']['FTBchCode'].' อนุมัติใบจ่ายโอนไปยังสาขา '.$aDataGetDataHD['raItems']['FTXthBchTo'],
                                "FTNoaDocRef"    => $aDataGetDataHD['raItems']['FTXthDocNo'],
                                "FNNoaUrlType"   =>  1,
                                "FTNoaUrlRef"    => 'docTransferBchOut/2/0',
                            ),
                        ), 
                        "oaTCNTNotiSpc" => array(
                            0 => array(
                                "FNNotID"       => $tNotiID,
                                "FTNotType"    => '1',
                                "FTNotStaType" => '1',
                                "FTAgnCode"    => '',
                                "FTAgnName"    => '',
                                "FTBchCode"    => $aDataGetDataHD['raItems']['FTBchCode'],
                                "FTBchName"    => $aDataGetDataHD['raItems']['FTBchName'],
                            ),
                            1 => array(
                                "FNNotID"       => $tNotiID,
                                "FTNotType"    => '2',
                                "FTNotStaType" => '1',
                                "FTAgnCode"    => '',
                                "FTAgnName"    => '',
                                "FTBchCode"    => $aDataGetDataHD['raItems']['FTXthBchFrm'],
                                "FTBchName"    => $aDataGetDataHD['raItems']['FTXthBchFrmName'],
                            ),
                            2 => array(
                                "FNNotID"       => $tNotiID,
                                "FTNotType"    => '2',
                                "FTNotStaType" => '1',
                                "FTAgnCode"    => '',
                                "FTAgnName"    => '',
                                "FTBchCode"    => $aDataGetDataHD['raItems']['FTXthBchTo'],
                                "FTBchName"    => $aDataGetDataHD['raItems']['FTXthBchToName'],
                            ),
                        ),
                        "ptUser"        => $this->session->userdata('tSesUsername'),
                    ]
                ];
                // echo '<pre>';
                // print_r($aMQParamsNoti['params']);
                // echo '</pre>';
                // echo json_encode($aMQParamsNoti['params']);
                // die();
                FCNxCallRabbitMQ($aMQParamsNoti);
                $this->db->trans_commit();
            }
        } catch (\ErrorException $err) {

            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => language('common/main/main', 'tApproveFail')
            );
            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aReturn));
        }
    }

    /**
     * Functionality : Delete Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStTransferBchOutDeleteDoc()
    {

        $tDocNo = $this->input->post('tDocNo');

        $this->db->trans_begin();

        $aDelMasterParams = [
            'tDocNo' => trim($tDocNo)
        ];
        $this->mTransferBchOut->FSaMDelMaster($aDelMasterParams);

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
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aStatus));
    }

    /**
     * Functionality : Delete Multiple Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStTransferBchOutDeleteMultiDoc()
    {
        $aDocNo = $this->input->post('aDocNo');

        $this->db->trans_begin();

        foreach ($aDocNo as $aItem) {
            $aDelMasterParams = [
                'tDocNo' => trim($aItem)
            ];
            $this->mTransferBchOut->FSaMDelMaster($aDelMasterParams);
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
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aStatus));
    }


    
    // ค่าอ้างอิงเอกสาร - โหลดข้อมูล
    public function FSaCTBOPageHDDocRef(){
        try {
            $tDocNo = ( !empty($this->input->post('ptDocNo')) ? $this->input->post('ptDocNo') : '');

            $aDataWhere = [
                'tTableHDDocRef'    => 'TCNTPdtTboHDDocRef',
                'tTableTmpHDRef'    => 'TCNTDocHDRefTmp',
                'FTXthDocNo'        => $tDocNo,
                'FTXthDocKey'       => 'TCNTPdtTboHD',
                'FTSessionID'       => $this->session->userdata('tSesSessionID')
            ];

            $aDataDocHDRef = $this->mTransferBchOut->FSaMTBOGetDataHDRefTmp($aDataWhere);
            $aDataConfig = array(
                'aDataDocHDRef' => $aDataDocHDRef,
                'tStaApv'       => $this->input->post('ptStaApv'),
                'tStaPrcDoc'    => $this->input->post('ptStaPrcDoc')
            );
            $tViewPageHDRef = $this->load->view('document/transfer_branch_out/wTransferBchOutHDDocRef', $aDataConfig, true);
            $aReturnData = array(
                'tViewPageHDRef'    => $tViewPageHDRef,
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

    
    // ค่าอ้างอิงเอกสาร - เพิ่ม หรือ เเก้ไข
    public function FSaCTBOEventAddEditHDDocRef(){
        try {
            $aDataWhere = [
                'FTXthDocNo'        => $this->input->post('ptDocNo'),
                'FTXthDocKey'       => 'TCNTPdtTboHD',
                'FTSessionID'       => $this->session->userdata('tSesSessionID'),
                'tRefDocNoOld'      => $this->input->post('ptRefDocNoOld'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
            ];
            $aDataAddEdit = [
                'FTXthRefDocNo'     => $this->input->post('ptRefDocNo'),
                'FTXthRefType'      => $this->input->post('ptRefType'),
                'FTXthRefKey'       => $this->input->post('ptRefKey'),
                'FDXthRefDocDate'   => $this->input->post('pdRefDocDate'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
            ];
            $aReturnData = $this->mTransferBchOut->FSaMTBOAddEditHDRefTmp($aDataWhere,$aDataAddEdit);
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }
    
    // อ้างอิงเอกสาร - ลบ
    public function FSoCTBOEventDelHDDocRef(){
        try {
            $aData = [
                'FTXthDocNo'        => $this->input->post('ptDocNo'),
                'FTXthRefDocNo'     => $this->input->post('ptRefDocNo'),
                'FTXthDocKey'       => 'TCNTPdtTboHD',
                'FTSessionID'       => $this->session->userdata('tSesSessionID')
            ];
            $aReturnData = $this->mTransferBchOut->FSaMTBOEventDelHDDocRef($aData);
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Gen เอกสารใบจัดสินค้า
    public function FSxCTBOEventGenDocPacking(){
        try {

            $aCondition = ( !empty($this->input->post('paCondition')) ? $this->input->post('paCondition') : array() );
            
            // echo "<pre>";
            // var_dump($aCondition);

            // $aMQParams1 = [
            //     "queueName" => "CN_QReqGenDoc",
            //     "params"        => [
            //         "ptFunction"    =>  "TCNTPdtPickHD",    //ชื่อ Function
            //         "ptSource"      =>  "AdaStoreBack",     //ต้นทาง
            //         "ptDest"        =>  "MQReceivePrc",     //ปลายทาง
            //         "ptData"        =>  json_encode([
            //             "ptBchCode"     => $this->input->post('ptBchCode'),
            //             "ptDocNo"       => $this->input->post('ptDocNo'),
            //             "ptUserCode"    => $this->session->userdata("tSesUserCode"),
            //             "paCondition"   => $aCondition
            //         ])
            //     ]
            // ];
            // print_r($aMQParams1);

            $aMQParams = [
                "queueName" => "CN_QReqGenDoc",
                "params"        => [
                    "ptFunction"    =>  "TCNTPdtPickHD",    //ชื่อ Function
                    "ptSource"      =>  "AdaStoreBack",     //ต้นทาง
                    "ptDest"        =>  "MQReceivePrc",     //ปลายทาง
                    "ptData"        =>  json_encode([
                        "ptBchCode"     => $this->input->post('ptBchCode'),
                        "ptDocNo"       => $this->input->post('ptDocNo'),
                        "ptUserCode"    => $this->session->userdata("tSesUserCode"),
                        "paCondition"   => $aCondition,
                        "ptPickType"    => '1' // 1 : สำหรับการจ่ายโอน , 2 : สำหรับการขาย
                    ])
                ]
            ];
            // print_r($aMQParams);
            // exit;
            FCNxCallRabbitMQ($aMQParams);

            $aReturnData = array(
                'nStaEvent' => 1,
                'tStaMessg' => 'Send MQ Success.'
            );

            // {
            //     "ptFunction":"TCNTPdtPickHD",
            //     "ptSource":"AdaStoreBack",
            //     "ptDest":"MQReceivePrc",
            //     "ptFilter":"",
            //     "ptData":"{
            //                 "ptBchCode":"",  //รหัสสาขา
            //                 "ptDocNo":"",    //เลขที่เอกสารใบจ่ายโอน
            //                 "ptUserCode":"", //รหัสผู้ใช้
            //                 "paCondition":   // List เงื่อนไขที่ใช้ Split
            //                  [
            //                   {
            //                     "ptSplit":""
            //                   },
            //                   {
            //                     "ptSplit":""
            //                   }
            //                 ]
            //               }"
            //   }

        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // ตรวจสอบ จำนวนจัดสินค้าไม่เท่ากับจำนวนสั่งสินค้า
    public function FSaCTBOEventChkPdtB4Apv(){
        try {
            $tDocNo  = $this->input->post('ptDocNo');            
            $aChkQty = $this->mTransferBchOut->FSaMTBOChkQtyOnPack($tDocNo);
            if( $aChkQty['tCode'] == '1' ){
                $aReturnData = array(
                    'nStaEvent' => '700',
                    'tStaMessg' => 'มีจำนวนจัดสินค้าไม่เท่ากับจำนวนสั่งสินค้า คุณยืนยันที่จะทำต่อหรือไม่'
                );
            }else{
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'สินค้าทุกตัวสมบูรณ์'
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }
    
    // Create By : Napat(Jame) 12/01/2022
    // ดึง Config เงื่อนไขการสร้างใบจัดสินค้า
    public function FSoCTBOEventGetConfigGenDocPack(){
        try {           
            $aConfGenDocPack = $this->mTransferBchOut->FSaMTBOGetConfigGenDocPack();
            if( $aConfGenDocPack['tCode'] == '1' ){
                $aReturnData = array(
                    'aDataList' => $aConfGenDocPack['aItems'],
                    'nStaEvent' => '1',
                    'tStaMessg' => 'พบ Config'
                );
            }else{
                $aReturnData = array(
                    'nStaEvent' => '800',
                    'tStaMessg' => 'ไม่พบ Config'
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Create By : Napat(Jame) 12/01/2022
    // บันทึก Config เงื่อนไขการสร้างใบจัดสินค้า
    public function FSoCTBOEventSaveConfigGenDocPack(){
        try {          
            $aCondition     = ( !empty($this->input->post('paCondition')) ? $this->input->post('paCondition') : array() );
            $tCondWhereIn   = "";

            // ถ้า checkbox ให้ loop ใส่ where in
            if( FCNnHSizeOf($aCondition) > 0 ){
                $tCondWhereIn .= "'";
                foreach($aCondition as $nKey => $aValue){
                    if( $nKey != 0 ){
                        $tCondWhereIn .= "','";
                    }
                    $tCondWhereIn .= $aValue['ptSplit']; 
                }
                $tCondWhereIn .= "'";
                // echo $tCondWhereIn;
            }
            
            // echo "<pre>";
            // print_r($aCondition);
            // exit;
            $aReturnData = $this->mTransferBchOut->FSaMTBOSaveConfigGenDocPack($tCondWhereIn);
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }
    
    
    public function FSoCTBOEventCancelOnApv(){
        try {
            $tDocNo         = $this->input->post('ptDocNo');

            // ตรวจสอบว่าเอกสารใบจ่ายโอน-สาขา ถูกอ้างอิงไปแล้วหรือไม่ ?
            $aChkAlwCancel  = $this->mTransferBchOut->FSaMTBOChkAlwCancel($tDocNo);
            if( $aChkAlwCancel['tCode'] == '1' ){
                $aMQParams = [
                    "queueName" => "CN_QDocCancel",
                    "params"        => [
                        "ptFunction"    =>  "CANCELTBO",    //ชื่อ Function
                        "ptSource"      =>  "AdaStoreBack",     //ต้นทาง
                        "ptDest"        =>  "MQReceivePrc",     //ปลายทาง
                        "ptData"        =>  json_encode([
                            "ptBchCode"     => $this->input->post('ptBchCode'),
                            "ptDocNo"       => $tDocNo,
                            "ptDocType"     => "",
                            "ptUser"        => $this->session->userdata("tSesUserCode"),
                            "ptConnStr"     => DB_CONNECT
                        ])
                    ]
                ];
                FCNxCallRabbitMQ($aMQParams);

                $aReturnData = array(
                    'nStaEvent' => 1,
                    'tStaMessg' => 'Send MQ Success.'
                );
            }else{
                $aReturnData = array(
                    'nStaEvent' => 600,
                    'tStaMessg' => $aChkAlwCancel['tDesc']
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }
    

}
