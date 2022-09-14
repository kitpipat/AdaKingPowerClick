<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cPromotion extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('company/company/mCompany');
        $this->load->model('document/promotion/mPromotion');
        $this->load->model('document/promotion/mPromotionStep1PmtDt');
        $this->load->model('document/promotion/mPromotionStep4BchCondition');
        $this->load->model('document/promotion/mPromotionStep1PmtBrandDt');
        $this->load->model('payment/rate/mRate');
        $this->load->model('company/vatrate/mVatRate');
        $this->load->model('company/branch/mBranch');
        $this->load->model('company/shop/mShop');
        $this->load->model('authen/login/mLogin');
    }

    public function index($nBrowseType, $tBrowseOption)
    {
        $aData['nBrowseType'] = $nBrowseType;
        $aData['tBrowseOption'] = $tBrowseOption;
        $aData['aAlwEvent'] = FCNaHCheckAlwFunc('promotion/0/0');
        $aData['vBtnSave'] = FCNaHBtnSaveActiveHTML('promotion/0/0');
        $aData['nOptDecimalShow'] = FCNxHGetOptionDecimalShow();
        $aData['nOptDecimalSave'] = FCNxHGetOptionDecimalSave();
        $this->load->view('document/promotion/wPromotion', $aData);
    }

    /**
     * Functionality : Main Page List
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : List Page
     * Return Type : View
     */
    public function FSxCPromotionList()
    {
        $nLangResort = $this->session->userdata("tLangID");
        $nLangEdit = $this->session->userdata("tLangEdit");
        $aData = array(
            'FTBchCode'    => $this->session->userdata("tSesUsrBchCode"),
            'FTShpCode'    => '',
            'nPage' => 1,
            'nRow' => 50,
            'FNLngID' => $nLangEdit,
            'tSearchAll' => ''
        );

        $aBchData = $this->mBranch->FSnMBCHList($aData);
        $aShpData = $this->mShop->FSaMSHPList($aData);
        $aDataMaster = array(
            'aBchData' => $aBchData,
            'aAlwEventBranch' => FCNaHCheckAlwFunc('promotion/0/0'),
            'aShpData' => $aShpData
        );
        $this->load->view('document/promotion/wPromotionList', $aDataMaster);
    }

    /**
     * Functionality : Get HD Table List
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : HD Table List
     * Return Type : View
     */
    public function FSxCPromotionDataTable()
    {
        $tAdvanceSearchData = $this->input->post('oAdvanceSearch');
        $nPage = $this->input->post('nPageCurrent');
        $aAlwEvent = FCNaHCheckAlwFunc('promotion/0/0');
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

        $aResList = $this->mPromotion->FSaMHDList($aData);
        $aGenTable = array(
            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow
        );

        $this->load->view('document/promotion/wPromotionDatatable', $aGenTable);
    }

    /**
     * Functionality : Add Page
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Add Page
     * Return Type : View
     */
    public function FSxCPromotionAddPage()
    {
        $tUserSessionID = $this->session->userdata('tSesSessionID');
        $tUserSessionDate = $this->session->userdata('tSesSessionDate');
        $tUserLevel = $this->session->userdata("tSesUsrLevel");
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $nOptDocSave = FCNnHGetOptionDocSave();
        $nOptScanSku = FCNnHGetOptionScanSku();
        $nLangEdit = $this->session->userdata("tLangEdit");

        $aClearInTmpParams = [
            'tUserSessionID' => $tUserSessionID
        ];
        $this->mPromotion->FSxMClearInTmp($aClearInTmpParams);

        if ($tUserLevel != "HQ") { // In BCH or SHP
            $aGetPdtPmtHDBchInTmpPageAllParams = [
                'tUserSessionID' => $tUserSessionID,
            ];
            $bIsNoRecord = $this->mPromotionStep4BchCondition->FSnMGetPdtPmtHDBchInTmpPageAll($aGetPdtPmtHDBchInTmpPageAllParams) <= 0;
            $tSesUsrAgnCode = $this->session->userdata("tSesUsrAgnCode");
            $tSesUsrAgnName = $this->session->userdata("tSesUsrAgnName");
            $tBchCodeLogin = $this->session->userdata("tSesUsrBchCodeDefault");
            $tBchNameLogin = $this->session->userdata("tSesUsrBchNameDefault");

            if ($bIsNoRecord) {
                if(!FCNbUsrIsAgnLevel()){
                $aPdtPmtHDBchToTempParams = [
                    'tBchCodeLogin' => $tBchCodeLogin,
                    'tUserSessionID' => $tUserSessionID,
                    'tUserSessionDate' => $tUserSessionDate,
                    'tDocNo' => 'PMTDOCTEMP',
                    'tAgnCode' => $tSesUsrAgnCode,
                    'tBchCode' => $tBchCodeLogin,
                    'tMerCode' => '',
                    'tShpCode' => '',
                    'tAgnName' => $tSesUsrAgnName,
                    'tBchName' => $tBchNameLogin,
                    'tMerName' => '',
                    'tShpName' => ''
                ];
            }else{
                $aPdtPmtHDBchToTempParams = [
                    'tBchCodeLogin' => $tBchCodeLogin,
                    'tUserSessionID' => $tUserSessionID,
                    'tUserSessionDate' => $tUserSessionDate,
                    'tDocNo' => 'PMTDOCTEMP',
                    'tAgnCode' => $tSesUsrAgnCode,
                    'tBchCode' => '',
                    'tMerCode' => '',
                    'tShpCode' => '',
                    'tAgnName' => $tSesUsrAgnName,
                    'tBchName' => '',
                    'tMerName' => '',
                    'tShpName' => ''
                ];
            }
                $this->mPromotionStep4BchCondition->FSaMPdtPmtHDBchToTemp($aPdtPmtHDBchToTempParams);
            }
        }

        $aGetPmtPdtConditionParams = [
            'nLngID' => $nLangEdit,
        ];
        $aPdtCond = $this->mPromotionStep1PmtBrandDt->FSaMGetPmtPdtCondition($aGetPmtPdtConditionParams);

        $aDataAdd = array(
            'aResult' =>  array('rtCode' => '99'),
            'aPdtCond' => $aPdtCond
        );
        $this->load->view('document/promotion/wPromotionPageadd', $aDataAdd);
    }

    /**
     * Functionality : Add Event
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCPromotionAddEvent()
    {
        try {
            $tUserSessionID = $this->session->userdata('tSesSessionID');
            $tUserLoginCode = $this->session->userdata('tSesUsername');
            $tDocDate = $this->input->post('oetPromotionDocDate') . " " . $this->input->post('oetPromotionDocTime');
            $nLangEdit = $this->session->userdata("tLangEdit");
            $tUserLevel = $this->session->userdata('tSesUsrLevel');

            $bIsPmhStaGetPdtByUser = $this->input->post('ocmPromotionPmhStaGetPdt') == "3"; // เงื่อนไขการเลือกสินค้ากรณี>1รายการในบิล 1:ราคามากกว่า 2:ราคาน้อยกว่า 3:user เลือก
            $bIsPmhStaLimitGetActive = $this->input->post('ocbPromotionPmhStaLimitGet') == "1"; // สถานะใช้งาน กำหนด จำนวนครั้ง ต่อวัน ต่อเดือน (1:ใช้งาน,2:ไม่ใช้งาน)
            $bIsPmhStaChkCstActive = $this->input->post('ocbPromotionPmhStaChkCst') == "1"; // สถานะใช้งาน กำหนด เงื่อนไขเฉพาะสมาชิก (1:ใช้งาน,2:ไม่ใช้งาน)

            $aDataMaster = array(
                'tIsAutoGenCode' => $this->input->post('ocbPromotionAutoGenCode'),
                'FTBchCode' => $this->input->post('oetPromotionBchCode'),
                'FTPmhDocNo' => $this->input->post('oetPromotionDocNo'),
                'FDPmhDStart' => $this->input->post('oetPromotionPmhDStart'), // วันที่เริ่ม
                'FDPmhDStop' => $this->input->post('oetPromotionPmhDStop'), // วันที่สิ้นสุด
                'FDPmhTStart' => empty($this->input->post('oetPromotionPmhTStart')) ? '00:00:00' : $this->input->post('oetPromotionPmhTStart'), // เวลาเริ่ม
                'FDPmhTStop' => empty($this->input->post('oetPromotionPmhTStop')) ? '23:59:59' : $this->input->post('oetPromotionPmhTStop'), // เวลาสิ้นสุด
                'FTPmhStaLimitCst' => empty($this->input->post('ocmPromotionPmhStaLimitCst')) ? "1" : $this->input->post('ocmPromotionPmhStaLimitCst'), // คิดต่อสมาชิก/ทั้งหมด 1:ทั้งหมด 2: สมาชิก
                'FTPmhStaClosed' => ($this->input->post('ocbPromotionPmhStaClosed') == "1") ? '1' : '0', // หยุดรายการ 0: เปิดใช้  1: หยุด
                'FTPmhStaDoc' => '1', // สถานะเอกสาร ว่าง:ยังไม่สมบูรณ์, 1:สมบูรณ์
                'FTPmhStaApv' => '', // สถานะ อนุมัติ เอกสาร ว่าง:ยังไม่ทำ, 1:อนุมัติแล้ว
                'FTPmhStaPrcDoc' => '', // สถานะ prc เอกสาร ว่าง:ยังไม่ทำ, 1:ทำแล้ว
                'FNPmhStaDocAct' => ($this->input->post('ocbPromotionPmhStaDocAct') == "1") ? 1 : 0, // สถานะ เคลื่อนไหว 0:NonActive, 1:Active
                'FTUsrCode' => $tUserLoginCode, // รหัสผู้บันทึก
                'FTPmhUsrApv' => '', // รหัสผู้อนุมัติ

                'FTPmhStaGrpPriority' => $this->input->post('ocmPromotionPmhStaGrpPriority'), // สถานะกลุ่มคำนวนโปรโมชั่น  (0.Price Group  1.The Best  2.Forced)
                'FTPmhStaGetPri' => $this->input->post('ocmPromotionPmhStaGetPri'), // สถานะการใช้งานยอดเพื่อคำนวน (1=ราคาหลังส่วนลด(Ontop)  2=ราคาก่อนส่วนลด(Reg Price)
                'FTPmhStaChkQuota' => ($this->input->post('ocbPromotionPmhStaChkQuota') == "1") ? "1" : "2", // สถานะเช็คเงื่อนนไข Limit Quota จากระบบ อื่น (1=เช็ค  2=ไม่เช็ค)
                'FTPmhStaOnTopDis' => ($this->input->post('ocbPromotionPmhStaOnTopDis') == "1") ? "1" : "2", // สถานะอนุญาต มีส่วนลดแล้ว สามารถคำนวนโปรนี้ได้   (1=อนุญาต 2=ไม่อนุญาต)
                'FTPmhStaOnTopPmt' => ($this->input->post('ocbPromotionPmhStaOnTopPmt') == "1") ? "1" : "2", // สถานะอนุญาต คำนวนสินค้าซ้อนโปรโมชั่น 1:อนญาต 2:ไม่อนญาต
                // 'FTPmhStaSpcGrpDis' => ($this->input->post('ocbPromotionPmhStaSpcGrpDis') == "1") ? "1" : "2", // สถานะการให้ส่วนลดเฉพาะกลุ่มทีได้รับ  (1=ให้ส่วนลดเฉพาะกลุ่ม 2=ให้ทั้งหมด รวมไม่เกิน 100%)

                'FTPmhStaAlwCalPntStd' => ($this->input->post('ocbPromotionPmhStaAlwCalPntStd') == "1") ? "1" : "2", // สถานะอนุญาตให้นำยอด ไปคำนวนแต้ม ปกติ 1:อนญาต 2:ไม่อนญาต
                'FTPmhStaRcvFree' => $this->input->post('ocmPromotionPmhStaRcvFree'), // สถานะรับของแถม 1:จุดขายคำนวนอัตโนมัติ 2:จุดขายเลือกได้ 3:จุดบริการ
                'FTPmhStaLimitGet' => ($this->input->post('ocbPromotionPmhStaLimitGet') == "1") ? "1" : "2", // สถานะใช้งาน กำหนด จำนวนครั้ง ต่อวัน ต่อเดือน (1:ใช้งาน,2:ไม่ใช้งาน)
                'FTPmhStaLimitTime' => ($bIsPmhStaLimitGetActive) ? $this->input->post('ocmPromotionPmhStaLimitTime') : '', // คิดต่อวัน/เดือน 1:ต่อวัน 2: ต่อเดือน 3:ต่อปี
                'FTPmhStaGetPdt' => $this->input->post('ocmPromotionPmhStaGetPdt'), // เงื่อนไขการเลือกสินค้ากรณี>1รายการในบิล 1:ราคามากกว่า 2:ราคาน้อยกว่า 3:user เลือก
                'FTPmhRefAccCode' => $this->input->post('oetPromotionPmhRefAccCode'), // รหัสอ้างอิงบัญชีของโปรโมชั่น
                'FTPmhStaPdtExc' => '', // เก็บสถานะของกลุ่มยกเว้น ว่าเป็น 1:สินค้า หรือ 2:แบรนด์
                'FTRolCode' => ($bIsPmhStaGetPdtByUser) ? $this->input->post('oetPromotionRoleCode') : '', // กลุ่มที่มีสิทธิอนุมัติ  ว่าง: ได้ Auto  ไม่ว่าง: popup user login
                'FNPmhLimitQty' => ($bIsPmhStaLimitGetActive) ? $this->input->post('oetPromotionPmhLimitQty') : 0, // จำกัดจำนวนครั้งที่จะได้รับ โปรโมชั่น
                'FTPmhStaChkLimit' => ($bIsPmhStaLimitGetActive) ? $this->input->post('ocmPromotionPmhStaChkLimit') : '', // เงื่อนไขจำกัดจำนวน 1:ต่อสาขา 2: ต่อบริษัท
                'FTPmhStaChkCst' => ($this->input->post('ocbPromotionPmhStaChkCst') == "1") ? $this->input->post('ocbPromotionPmhStaChkCst') : '2', // สถานะใช้งาน กำหนด เงื่อนไขเฉพาะสมาชิก (1:ใช้งาน,2:ไม่ใช้งาน)
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTLastUpdBy' => $tUserLoginCode,
                'FDCreateOn' => $tDocDate,
                'FTCreateBy' => $tUserLoginCode,
                // HD_L
                'FNLngID' => $nLangEdit,
                'FTPmhName' => $this->input->post('oetPromotionPmhName'),
                'FTPmhNameSlip' => $this->input->post('oetPromotionPmhNameSlip'),
                'FTPmhRmk' => $this->input->post('otaPromotionPmhRmk'),
                // PdtPmtHDCst
                'FTSpmStaLimitCst' => ($bIsPmhStaChkCstActive) ? $this->input->post('ocmPromotionSpmStaLimitCst') : '', // เงื่อนไขอายุสมาชิก 1: น้อยกว่า 2: น้อยกว่าหรือเท่ากับ 3: เท่ากับ 4:มากกว่า หรือเท่ากับ 5:มากกว่า
                'FNSpmMemAgeLT' => ($bIsPmhStaChkCstActive) ? $this->input->post('oetPromotionSpmMemAgeLT') : '', // อายุการเป็นสมาชิก(day) เช่น 365 :  ภายใน1 ปี  ,0: ไม่จำกัด
                'FTSpmStaChkCstDOB' => ($bIsPmhStaChkCstActive) ? $this->input->post('ocmPromotionSpmStaChkCstDOB') : '', // เงื่อนไขเฉพาะสมาชิกที่ตรงกับวันเกิด (1:ใช้งาน,2:ไม่ใช้งาน)
                'FNPmhCstDobPrev' => ($bIsPmhStaChkCstActive) ? $this->input->post('oetPromotionPmhCstDobPrev') : '', // เก็บจำนวนเดือนก่อนหน้าเดือนเกิด ที่จะเริ่มต้นได้รับโปรโมชั่น
                'FNPmhCstDobNext' => ($bIsPmhStaChkCstActive) ? $this->input->post('oetPromotionPmhCstDobNext') : '', // เก็บจำนวนเดือนหลังจากเดือนเกิด ที่จะสิ้นสุดได้รับโปรโมชั่น
            );

            $this->db->trans_begin();

            // Setup Doc No.
            if ($aDataMaster['tIsAutoGenCode'] == '1') { // Check Auto Gen Code?
                // Call Auto Gencode Helper
                $aStoreParam = array(
                    "tTblName" => 'TCNTPdtPmtHD',
                    "tDocType" => 8,
                    "tBchCode" => $aDataMaster["FTBchCode"],
                    "tShpCode" => "",
                    "tPosCode" => "",
                    "dDocDate" => date("Y-m-d")
                );
                $aAutogen = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTPmhDocNo'] = $aAutogen[0]["FTXxhDocNo"];

                // Auto Gen Code
                /* $aGenCode = FCNaHGenCodeV5('TCNTPdtPmtHD', '8');
                if ($aGenCode['rtCode'] == '1') {
                    $aDataMaster['FTPmhDocNo'] = $aGenCode['rtPmhDocNo'];
                } */
            }

            $this->mPromotion->FSaMAddUpdateHD($aDataMaster);
            $this->mPromotion->FSaMAddUpdateHDL($aDataMaster);
            $this->mPromotion->FSaMAddUpdatePdtPmtHDCst($aDataMaster);

            $aUpdatePgtStaGetPdtInTmpFromHDParams = [
                'tStaGetPdt' => $aDataMaster['FTPmhStaGetPdt'],
                'tUserSessionID' => $tUserSessionID
            ];
            $this->mPromotion->FSaMUpdatePgtStaGetPdtInTmpFromHD($aUpdatePgtStaGetPdtInTmpFromHDParams);

            $aUpdateDocNoInTmpParams = [
                'tDocNo' => $aDataMaster['FTPmhDocNo'],
                'tUserSessionID' => $tUserSessionID
            ];
            $this->mPromotion->FSaMUpdateDocNoInTmp($aUpdateDocNoInTmpParams); // Update DocNo ในตาราง Doctemp

            $aTempToTBParams = [
                'tDocNo' => $aDataMaster['FTPmhDocNo'],
                'tUserSessionID' => $tUserSessionID,
                'tBchCode' => $aDataMaster['FTBchCode']
            ];
            $this->mPromotion->FSaMTempToPdtPmtDT($aTempToTBParams); // คัดลอกข้อมูลจาก Temp to PdtPmtDT
            $this->mPromotion->FSaMTempToPdtPmtCB($aTempToTBParams); // คัดลอกข้อมูลจาก Temp to PdtPmtCB
            $this->mPromotion->FSaMTempToPdtPmtCG($aTempToTBParams); // คัดลอกข้อมูลจาก Temp to PdtPmtCG
            $this->mPromotion->FSaMTempToPdtPmtHDBch($aTempToTBParams); // คัดลอกข้อมูลจาก Temp to PdtPmtHDBch
            $this->mPromotion->FSaMTempToPdtPmtHDCstPri($aTempToTBParams); // คัดลอกข้อมูลจาก Temp to PdtPmtHDCstPri
            $this->mPromotion->FSaMTempToPdtPmtHDChn($aTempToTBParams); // คัดลอกข้อมูลจาก Temp to PdtPmtHDChn
            $this->mPromotion->FSaMTempToPdtPmtHDCstLev($aTempToTBParams); // คัดลอกข้อมูลจาก Temp to PdtPmtHDCstLev 

            /*===== Begin Update FTPmhStaPdtExc in HD ==================================*/
            $aGetPmtDtStaListTypeOnExcudeTypeInTmpParams = [
                'tDocNo' => $aDataMaster['FTPmhDocNo'],
                'tUserSessionID' => $tUserSessionID,
            ];
            $tPmdStaListType = $this->mPromotionStep1PmtDt->FStMGetPmtDtStaListTypeOnExcudeTypeInTmp($aGetPmtDtStaListTypeOnExcudeTypeInTmpParams);

            $aUpdatePmhStaPdtExcInHDParams = [
                'tDocNo' => $aDataMaster['FTPmhDocNo'],
                'tPmhStaPdtExc' => $tPmdStaListType,
            ];
            $this->mPromotion->FSbUpdatePmhStaPdtExcInHD($aUpdatePmhStaPdtExcInHDParams);
            /*===== End Update FTPmhStaPdtExc in HD ====================================*/

            $aClearInTmpParams = [
                'tUserSessionID' => $tUserSessionID,
            ];
            $this->mPromotion->FSxMClearInTmp($aClearInTmpParams); // ล้าง Temp

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Unsucess Add"
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack' => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn' => $aDataMaster['FTPmhDocNo'],
                    'nStaEvent' => '1',
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
    public function FSvCPromotionEditPage()
    {
        $tDocNo = $this->input->post('tDocNo');
        $nLangEdit = $this->session->userdata("tLangEdit");
        $nLangResort = $this->session->userdata("tLangID");
        $aLangHave = FCNaHGetAllLangByTable('TFNMRate_L');
        // $tUsrLogin = $this->session->userdata('tSesUsername');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserSessionDate = $this->session->userdata("tSesSessionDate");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        // $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");

        $aAlwEvent = FCNaHCheckAlwFunc('promotion/0/0'); // Access Control
        // Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        // Get Option Scan SKU
        $nOptDocSave = FCNnHGetOptionDocSave();
        // Get Option Scan SKU
        $nOptScanSku = FCNnHGetOptionScanSku();

        // Lang ภาษา
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

        $aClearInTmpParams = [
            'tUserSessionID' => $tUserSessionID
        ];
        $this->mPromotion->FSxMClearInTmp($aClearInTmpParams);

        /*===== Begin Data to Temp =====================================================*/
        $this->db->trans_begin();

        $aDataToTempParams = array(
            'tDocNo' => $tDocNo,
            'nLngID' => $nLangEdit,
            'tUserSessionID' => $tUserSessionID,
            'tUserSessionDate' => $tUserSessionDate
        );
        $this->mPromotion->FSaMPdtPmtHDBchToTemp($aDataToTempParams);

        if ($tUserLevel != "HQ") { // In BCH or SHP
            $aGetPdtPmtHDBchInTmpPageAllParams = [
                'tUserSessionID' => $tUserSessionID,
            ];
            $bIsNoRecord = $this->mPromotionStep4BchCondition->FSnMGetPdtPmtHDBchInTmpPageAll($aGetPdtPmtHDBchInTmpPageAllParams) <= 0;

            if ($bIsNoRecord) {
                $tBchCodeLogin = $this->session->userdata("tSesUsrBchCodeDefault");
                $tBchNameLogin = $this->session->userdata("tSesUsrBchNameDefault");
                $tSesUsrAgnCode = $this->session->userdata("tSesUsrAgnCode");
                $tSesUsrAgnName = $this->session->userdata("tSesUsrAgnName");
                $aPdtPmtHDBchToTempParams = [
                    'tBchCodeLogin' => $tBchCodeLogin,
                    'tUserSessionID' => $tUserSessionID,
                    'tUserSessionDate' => $tUserSessionDate,
                    'tDocNo' => 'PMTDOCTEMP',
                    'tAgnCode' => $tSesUsrAgnCode,
                    'tAgnName' => $tSesUsrAgnName,
                    'tBchCode' => $tBchCodeLogin,
                    'tMerCode' => '',
                    'tShpCode' => '',
                    'tBchName' => $tBchNameLogin,
                    'tMerName' => '',
                    'tShpName' => ''
                ];
                $this->mPromotionStep4BchCondition->FSaMPdtPmtHDBchToTemp($aPdtPmtHDBchToTempParams);
            }
        }

        $this->mPromotion->FSaMPdtPmtDTToTemp($aDataToTempParams);
        $this->mPromotion->FSaMPdtPmtCBToTemp($aDataToTempParams);
        $this->mPromotion->FSaMPdtPmtCGToTemp($aDataToTempParams);
        $this->mPromotion->FSaMPdtPmtHDCstPriToTemp($aDataToTempParams);
        $this->mPromotion->FSaMPdtPmtHDChnToTemp($aDataToTempParams);
        $this->mPromotion->FSaMPdtPmtHDCstLevToTemp($aDataToTempParams); // คัดลอกข้อมูลจาก Temp to PdtPmtHDCstLev 

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        /*===== End Data to Temp =======================================================*/

        /*===== Begin Get Data =========================================================*/
        $aGetHDParams = array(
            'tDocNo' => $tDocNo,
            'nLngID' => $nLangEdit
        );
        $aResult = $this->mPromotion->FSaMGetHD($aGetHDParams); // Data TCNTPdtPmtHD

        $aGetPdtPmtHDCstParams = array(
            'tDocNo' => $tDocNo,
            'nLngID' => $nLangEdit
        );
        $aPdtPmtHDCstResult = $this->mPromotion->FSaMGetPdtPmtHDCst($aGetPdtPmtHDCstParams); // Data TCNTPdtPmtHDCst

        $aGetPmtPdtConditionParams = [
            'nLngID' => $nLangEdit,
        ];
        $aPdtCond = $this->mPromotionStep1PmtBrandDt->FSaMGetPmtPdtCondition($aGetPmtPdtConditionParams);
        /*===== End Get Data ===========================================================*/

        $aDataEdit = array(
            'aResult' => $aResult,
            'aPdtPmtHDCstResult' => $aPdtPmtHDCstResult,
            'aAlwEvent' => $aAlwEvent,
            'aPdtCond' => $aPdtCond
        );
        $this->load->view('document/promotion/wPromotionPageadd', $aDataEdit);
    }

    /**
     * Functionality : Edit Event
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCPromotionEditEvent()
    {
        try {
            $tUserSessionID = $this->session->userdata('tSesSessionID');
            $tUserLoginCode = $this->session->userdata('tSesUsername');
            $tDocDate = $this->input->post('oetPromotionDocDate') . " " . $this->input->post('oetPromotionDocTime');
            $nLangEdit = $this->session->userdata("tLangEdit");
            $tUserLevel = $this->session->userdata('tSesUsrLevel');
            $tDocNo = $this->input->post('oetPromotionDocNo');

            $aGetHDParams = [
                'tDocNo' => $tDocNo,
                'nLngID' => $nLangEdit
            ];
            $aHDData = $this->mPromotion->FSaMGetHD($aGetHDParams);
            $tBchCodeLogin = $aHDData['raItems']['FTBchCode'];
            $bIsStaApv = empty($aHDData['raItems']['FTPmhStaApv']) ? false : true;

            $bIsPmhStaGetPdtByUser = $this->input->post('ocmPromotionPmhStaGetPdt') == "3"; // เงื่อนไขการเลือกสินค้ากรณี>1รายการในบิล 1:ราคามากกว่า 2:ราคาน้อยกว่า 3:user เลือก
            $bIsPmhStaLimitGetActive = $this->input->post('ocbPromotionPmhStaLimitGet') == "1"; // สถานะใช้งาน กำหนด จำนวนครั้ง ต่อวัน ต่อเดือน (1:ใช้งาน,2:ไม่ใช้งาน)
            $bIsPmhStaChkCstActive = $this->input->post('ocbPromotionPmhStaChkCst') == "1"; // สถานะใช้งาน กำหนด เงื่อนไขเฉพาะสมาชิก (1:ใช้งาน,2:ไม่ใช้งาน)

            $aDataMaster = array(
                'tIsAutoGenCode' => $this->input->post('ocbPromotionAutoGenCode'),
                'FTBchCode' => $tBchCodeLogin,
                'FTPmhDocNo' => $tDocNo,
                'FDPmhDStart' => $this->input->post('oetPromotionPmhDStart'), // วันที่เริ่ม
                'FDPmhDStop' => $this->input->post('oetPromotionPmhDStop'), // วันที่สิ้นสุด
                'FDPmhTStart' => empty($this->input->post('oetPromotionPmhTStart')) ? '00:00:00' : $this->input->post('oetPromotionPmhTStart'), // เวลาเริ่ม
                'FDPmhTStop' => empty($this->input->post('oetPromotionPmhTStop')) ? '23:59:59' : $this->input->post('oetPromotionPmhTStop'), // เวลาสิ้นสุด
                'FTPmhStaLimitCst' => empty($this->input->post('ocmPromotionPmhStaLimitCst')) ? "1" : $this->input->post('ocmPromotionPmhStaLimitCst'), // คิดต่อสมาชิก/ทั้งหมด 1:ทั้งหมด 2: สมาชิก
                'FTPmhStaClosed' => ($this->input->post('ocbPromotionPmhStaClosed') == "1") ? '1' : '0', // หยุดรายการ 0: เปิดใช้  1: หยุด
                'FTPmhStaDoc' => '1', // สถานะเอกสาร ว่าง:ยังไม่สมบูรณ์, 1:สมบูรณ์
                'FTPmhStaApv' => '', // สถานะ อนุมัติ เอกสาร ว่าง:ยังไม่ทำ, 1:อนุมัติแล้ว
                'FTPmhStaPrcDoc' => '1', // สถานะ prc เอกสาร ว่าง:ยังไม่ทำ, 1:ทำแล้ว
                'FNPmhStaDocAct' => ($this->input->post('ocbPromotionPmhStaDocAct') == "1") ? 1 : 0, // สถานะ เคลื่อนไหว 0:NonActive, 1:Active
                'FTUsrCode' => $tUserLoginCode, // รหัสผู้บันทึก
                'FTPmhUsrApv' => '', // รหัสผู้อนุมัติ

                'FTPmhStaGrpPriority' => $this->input->post('ocmPromotionPmhStaGrpPriority'), // สถานะกลุ่มคำนวนโปรโมชั่น  (0.Price Group  1.The Best  2.Forced)
                'FTPmhStaGetPri' => $this->input->post('ocmPromotionPmhStaGetPri'), // สถานะการใช้งานยอดเพื่อคำนวน (1=ราคาหลังส่วนลด(Ontop)  2=ราคาก่อนส่วนลด(Reg Price)
                'FTPmhStaChkQuota' => ($this->input->post('ocbPromotionPmhStaChkQuota') == "1") ? "1" : "2", // สถานะเช็คเงื่อนนไข Limit Quota จากระบบ อื่น (1=เช็ค  2=ไม่เช็ค)
                'FTPmhStaOnTopDis' => ($this->input->post('ocbPromotionPmhStaOnTopDis') == "1") ? "1" : "2", // สถานะอนุญาต มีส่วนลดแล้ว สามารถคำนวนโปรนี้ได้   (1=อนุญาต 2=ไม่อนุญาต)
                'FTPmhStaOnTopPmt' => ($this->input->post('ocbPromotionPmhStaOnTopPmt') == "1") ? "1" : "2", // สถานะอนุญาต คำนวนสินค้าซ้อนโปรโมชั่น 1:อนญาต 2:ไม่อนญาต
                // 'FTPmhStaSpcGrpDis' => ($this->input->post('ocbPromotionPmhStaSpcGrpDis') == "1") ? "1" : "2", // สถานะการให้ส่วนลดเฉพาะกลุ่มทีได้รับ  (1=ให้ส่วนลดเฉพาะกลุ่ม 2=ให้ทั้งหมด รวมไม่เกิน 100%)

                'FTPmhStaAlwCalPntStd' => ($this->input->post('ocbPromotionPmhStaAlwCalPntStd') == "1") ? "1" : "2", // สถานะอนุญาตให้นำยอด ไปคำนวนแต้ม ปกติ 1:อนญาต 2:ไม่อนญาต
                'FTPmhStaRcvFree' => $this->input->post('ocmPromotionPmhStaRcvFree'), // สถานะรับของแถม 1:จุดขายคำนวนอัตโนมัติ 2:จุดขายเลือกได้ 3:จุดบริการ
                'FTPmhStaLimitGet' => ($this->input->post('ocbPromotionPmhStaLimitGet') == "1") ? "1" : "2", // สถานะใช้งาน กำหนด จำนวนครั้ง ต่อวัน ต่อเดือน (1:ใช้งาน,2:ไม่ใช้งาน)
                'FTPmhStaLimitTime' => ($bIsPmhStaLimitGetActive) ? $this->input->post('ocmPromotionPmhStaLimitTime') : '', // คิดต่อวัน/เดือน 1:ต่อวัน 2: ต่อเดือน 3:ต่อปี
                'FTPmhStaGetPdt' => $this->input->post('ocmPromotionPmhStaGetPdt'), // เงื่อนไขการเลือกสินค้ากรณี>1รายการในบิล 1:ราคามากกว่า 2:ราคาน้อยกว่า 3:user เลือก
                'FTPmhRefAccCode' => $this->input->post('oetPromotionPmhRefAccCode'), // รหัสอ้างอิงบัญชีของโปรโมชั่น
                'FTPmhStaPdtExc' => '', // เก็บสถานะของกลุ่มยกเว้น ว่าเป็น 1:สินค้า หรือ 2:แบรนด์
                'FTRolCode' => ($bIsPmhStaGetPdtByUser) ? $this->input->post('oetPromotionRoleCode') : '', // กลุ่มที่มีสิทธิอนุมัติ  ว่าง: ได้ Auto  ไม่ว่าง: popup user login
                'FNPmhLimitQty' => ($bIsPmhStaLimitGetActive) ? $this->input->post('oetPromotionPmhLimitQty') : 0, // จำกัดจำนวนครั้งที่จะได้รับ โปรโมชั่น
                'FTPmhStaChkLimit' => ($bIsPmhStaLimitGetActive) ? $this->input->post('ocmPromotionPmhStaChkLimit') : '', // เงื่อนไขจำกัดจำนวน 1:ต่อสาขา 2: ต่อบริษัท
                'FTPmhStaChkCst' => ($this->input->post('ocbPromotionPmhStaChkCst') == "1") ? $this->input->post('ocbPromotionPmhStaChkCst') : '2', // สถานะใช้งาน กำหนด เงื่อนไขเฉพาะสมาชิก (1:ใช้งาน,2:ไม่ใช้งาน)
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTLastUpdBy' => $tUserLoginCode,
                'FDCreateOn' => $tDocDate,
                'FTCreateBy' => $tUserLoginCode,
                // HD_L
                'FNLngID' => $nLangEdit,
                'FTPmhName' => $this->input->post('oetPromotionPmhName'),
                'FTPmhNameSlip' => $this->input->post('oetPromotionPmhNameSlip'),
                'FTPmhRmk' => $this->input->post('otaPromotionPmhRmk'),
                // PdtPmtHDCst
                'FTSpmStaLimitCst' => ($bIsPmhStaChkCstActive) ? $this->input->post('ocmPromotionSpmStaLimitCst') : '', // เงื่อนไขอายุสมาชิก 1: น้อยกว่า 2: น้อยกว่าหรือเท่ากับ 3: เท่ากับ 4:มากกว่า หรือเท่ากับ 5:มากกว่า
                'FNSpmMemAgeLT' => ($bIsPmhStaChkCstActive) ? $this->input->post('oetPromotionSpmMemAgeLT') : '', // อายุการเป็นสมาชิก(day) เช่น 365 :  ภายใน1 ปี  ,0: ไม่จำกัด
                'FTSpmStaChkCstDOB' => ($bIsPmhStaChkCstActive) ? $this->input->post('ocmPromotionSpmStaChkCstDOB') : '', // เงื่อนไขเฉพาะสมาชิกที่ตรงกับวันเกิด (1:ใช้งาน,2:ไม่ใช้งาน)
                'FNPmhCstDobPrev' => ($bIsPmhStaChkCstActive) ? $this->input->post('oetPromotionPmhCstDobPrev') : '', // เก็บจำนวนเดือนก่อนหน้าเดือนเกิด ที่จะเริ่มต้นได้รับโปรโมชั่น
                'FNPmhCstDobNext' => ($bIsPmhStaChkCstActive) ? $this->input->post('oetPromotionPmhCstDobNext') : '', // เก็บจำนวนเดือนหลังจากเดือนเกิด ที่จะสิ้นสุดได้รับโปรโมชั่น
            );

            $this->db->trans_begin();

            if ($bIsStaApv) { // อนุมัติแล้ว แต่ต้องการ เปิด-ปิด โปรโมชั่น
                $this->mPromotion->FSbMAddUpdatePmhStaClosedHD($aDataMaster);
            } else { // ขั้นตอนปกติ
                $this->mPromotion->FSaMAddUpdateHD($aDataMaster);
                $this->mPromotion->FSaMAddUpdateHDL($aDataMaster);
                $this->mPromotion->FSaMAddUpdatePdtPmtHDCst($aDataMaster);

                $aUpdatePgtStaGetPdtInTmpFromHDParams = [
                    'tStaGetPdt' => $aDataMaster['FTPmhStaGetPdt'],
                    'tUserSessionID' => $tUserSessionID
                ];
                $this->mPromotion->FSaMUpdatePgtStaGetPdtInTmpFromHD($aUpdatePgtStaGetPdtInTmpFromHDParams);

                $aUpdateDocNoInTmpParams = [
                    'tDocNo' => $aDataMaster['FTPmhDocNo'],
                    'tUserSessionID' => $tUserSessionID
                ];
                $this->mPromotion->FSaMUpdateDocNoInTmp($aUpdateDocNoInTmpParams); // Update DocNo ในตาราง Doctemp

                $aTempToTBParams = [
                    'tDocNo' => $aDataMaster['FTPmhDocNo'],
                    'tUserSessionID' => $tUserSessionID,
                    'tBchCode' => $aDataMaster['FTBchCode']
                ];
                $this->mPromotion->FSaMTempToPdtPmtDT($aTempToTBParams); // คัดลอกข้อมูลจาก Temp to PdtPmtDT
                $this->mPromotion->FSaMTempToPdtPmtCB($aTempToTBParams); // คัดลอกข้อมูลจาก Temp to PdtPmtCB
                $this->mPromotion->FSaMTempToPdtPmtCG($aTempToTBParams); // คัดลอกข้อมูลจาก Temp to PdtPmtCG
                $this->mPromotion->FSaMTempToPdtPmtHDBch($aTempToTBParams); // คัดลอกข้อมูลจาก Temp to PdtPmtHDBch
                $this->mPromotion->FSaMTempToPdtPmtHDCstPri($aTempToTBParams); // คัดลอกข้อมูลจาก Temp to PdtPmtHDCstPri
                $this->mPromotion->FSaMTempToPdtPmtHDChn($aTempToTBParams); // คัดลอกข้อมูลจาก Temp to PdtPmtHDChn
                $this->mPromotion->FSaMTempToPdtPmtHDCstLev($aTempToTBParams); // คัดลอกข้อมูลจาก Temp to PdtPmtHDCstLev 

                /*===== Begin Update FTPmhStaPdtExc in HD ==================================*/
                $aGetPmtDtStaListTypeOnExcudeTypeInTmpParams = [
                    'tDocNo' => $aDataMaster['FTPmhDocNo'],
                    'tUserSessionID' => $tUserSessionID,
                ];
                $tPmdStaListType = $this->mPromotionStep1PmtDt->FStMGetPmtDtStaListTypeOnExcudeTypeInTmp($aGetPmtDtStaListTypeOnExcudeTypeInTmpParams);

                $aUpdatePmhStaPdtExcInHDParams = [
                    'tDocNo' => $aDataMaster['FTPmhDocNo'],
                    'tPmhStaPdtExc' => $tPmdStaListType,
                ];
                $this->mPromotion->FSbUpdatePmhStaPdtExcInHD($aUpdatePmhStaPdtExcInHDParams);
                /*===== End Update FTPmhStaPdtExc in HD ====================================*/
            }

            $aClearInTmpParams = [
                'tUserSessionID' => $tUserSessionID,
            ];
            $this->mPromotion->FSxMClearInTmp($aClearInTmpParams); // ล้าง Temp

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit"
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack' => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn' => $aDataMaster['FTPmhDocNo'],
                    'nStaEvent'    => '1',
                    'tStaMessg' => 'Success Edit'
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
    public function FStCPromotionUniqueValidate()
    {
        $aStatus = ['bStatus' => false];

        if ($this->input->is_ajax_request()) { // Request check
            $tPromotionDocCode = $this->input->post('tPromotionCode');
            $bIsDocNoDup = $this->mPromotion->FSbMCheckDuplicate($tPromotionDocCode);

            if ($bIsDocNoDup) { // If have record
                $aStatus['bStatus'] = true;
            }
        }
        $aStatus["code"] = $tPromotionDocCode;
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
    public function FStCPromotionDocCancel()
    {

        $tDocNo = $this->input->post('tDocNo');

        $this->db->trans_begin();

        $aDocCancelParams = array(
            'tDocNo' => $tDocNo,
        );
        $aStaCancel = $this->mPromotion->FSaMDocCancel($aDocCancelParams);

        if ($aStaCancel['rtCode'] == 1) {
            $this->db->trans_commit();
            $aCancel = array(
                'nSta' => 1,
                'tMsg' => "Cancel Success",
            );
        } else {
            $this->db->trans_rollback();
            $aCancel = array(
                'nSta' => 2,
                'tMsg' => "Cancel Fail",
            );
        }
        echo json_encode($aCancel);
    }

    /**
     * Functionality : Approve Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStCPromotionDocApprove()
    {

        $tDocNo  = $this->input->post('tDocNo');
        $tUsrBchCode = FCNtGetBchInComp();

        $this->db->trans_begin();

        $aDocApproveParams = array(
            'tDocNo' => $tDocNo,
            'tApvCode' => $this->session->userdata('tSesUsername')
        );
        $aStaApv = $this->mPromotion->FSaMDocApprove($aDocApproveParams);

        $aReturn = array(
            'nStaEvent' => '200',
            'tStaMessg' => language('common/main/main', '')
        );

        if ($aStaApv['rtCode'] == "1") {
            $this->db->trans_commit();
        } else {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => language('common/main/main', 'tApproveFail')
            );
        }
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aReturn));

        /* try {
            $aMQParams = [
                "queueName" => "BR_QTransfer".$tUsrBchCode,
                "params" => [
                    "ptFunction" => "BankPromotionSlip", // ชื่อ Function
                    "ptSource" => "BCH.AdaStoreBack", // ต้นทาง
                    "ptDest" => "BCH.MQ_Rcv", // ปลายทาง
                    "ptFilter" => $tUsrBchCode, // รหัสสาขาตัวเอง
                    "ptData" => [
                        "ptFTBchCode" => $tUsrBchCode, // Branchcode
                        "ptFTBdhDocNo" => $tDocNo, // เลขที่เอกสาร
                    ]
                ]
            ];
            FCNxCallRabbitMQ($aMQParams);

            $this->db->trans_commit();
        } catch (\ErrorException $err) {

            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => language('common/main/main', 'tApproveFail')
            );
            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aReturn));
        } */
    }

    /**
     * Functionality : Delete Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStPromotionDeleteDoc()
    {

        $tDocNo = $this->input->post('tDocNo');

        $this->db->trans_begin();

        $aDelMasterParams = [
            'tDocNo' => trim($tDocNo)
        ];
        $this->mPromotion->FSaMDelMaster($aDelMasterParams);

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
    public function FStPromotionDeleteMultiDoc()
    {
        $aDocNo = $this->input->post('aDocNo');

        $this->db->trans_begin();

        foreach ($aDocNo as $aItem) {
            $aDelMasterParams = [
                'tDocNo' => trim($aItem)
            ];
            $this->mPromotion->FSaMDelMaster($aDelMasterParams);
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

    //Functionality : คัดลอกเอกสาร
    //LastUpdate: 23/05/2022 Napat(Jame)
    public function FStPromotionCopyDoc(){
        try {
            $tBchCode           = $this->input->post('tBchCode');
            $tDocumentNumber    = $this->input->post('tDocumentNumber');
            
            $this->db->trans_begin();
            $aStoreParam = array(
                "tTblName" => 'TCNTPdtPmtHD',
                "tDocType" => 8,
                "tBchCode" => $tBchCode,
                "tShpCode" => "",
                "tPosCode" => "",
                "dDocDate" => date("Y-m-d")     
            );
            $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
            $tPromotionDocNo   = $aAutogen[0]["FTXxhDocNo"];
            $this->mPromotion->FSaMPromotionCopyHD($tDocumentNumber,$tPromotionDocNo);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aStatus = array(
                    'nStaEvent' => '905',
                    'tStaMessg' => $this->db->error()['message'],
                );
            } else {
                $this->db->trans_commit();
                $aStatus = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Copy Documents Success.',
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
}
