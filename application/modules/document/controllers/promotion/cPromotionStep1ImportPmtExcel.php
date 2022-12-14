<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php');
require_once(APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php');
require_once(APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

class cPromotionStep1ImportPmtExcel extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('document/promotion/mPromotionStep1ImportPmtExcel');
        $this->load->model('document/promotion/mPromotionStep1PmtPdtDt');
        $this->load->model('document/promotion/mPromotionStep1PmtDt');
        $this->load->model('document/promotion/mPromotionStep1PmtBrandDt');
        $this->load->model('document/promotion/mPromotion');
    }

    /**
     * Functionality : Import Promotion Group From Excel
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FStPromotionImportFromExcel()
    {
        $tUserSessionID = $this->session->userdata('tSesSessionID');
        $tUserSessionDate = $this->session->userdata('tSesSessionDate');
        $tUserLoginCode = $this->session->userdata('tSesUsername');
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserLevel = $this->session->userdata('tSesUsrLevel');
        $tBchCodeLogin = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCodeDefault");

        $tPmtGroupTypeTmp = $this->input->post('tPmtGroupTypeTmp');
        $tPmtGroupListTypeTmp = $this->input->post('tPmtGroupListTypeTmp');
        $tPmtGroupNameTmp = $this->input->post('tPmtGroupNameTmp');
        $tPmtGroupNameTmpOld = $this->input->post('tPmtGroupNameTmpOld');

        $aDataFiles = (isset($_FILES['oefPromotionStep1PmtFileExcel']) && !empty($_FILES['oefPromotionStep1PmtFileExcel']))? $_FILES['oefPromotionStep1PmtFileExcel'] : null;
        
        $aReturn = array(
            'nStaEvent' => '',
            'tStaMessg' => ""
        );

        if(isset($aDataFiles) && !empty($aDataFiles) && is_array($aDataFiles)){
            // Insert
            $aDataFiles = (isset($_FILES['aFile']) && !empty($_FILES['aFile']))? $_FILES['aFile'] : null;
            
            // var_dump($aDataFiles);
            // return;

            $this->db->trans_begin();

            $oLoadExcel         = PHPExcel_IOFactory::load($aDataFiles['tmp_name']);
            $oExcelSheet        = null;
            $aDataImportFail    = array();

            if($tPmtGroupListTypeTmp == "1"){ // Product
                /*===== Begin Product Process ==============================================*/
                $oExcelSheet = $oLoadExcel->getSheetByName('Product');
                $aProductDataSheet = $oExcelSheet->toArray();
                
                // echo "<pre>"; print_r($aProductDataSheet); echo "</pre>";

                $aClearPmtPdtDtInTmpParams = [
                    'tPmtGroupNameTmpOld' => $tPmtGroupNameTmpOld,
                    'tUserSessionID' => $tUserSessionID
                ];
                $this->mPromotionStep1PmtDt->FSbClearPmtDtInTmp($aClearPmtPdtDtInTmpParams);

                foreach($aProductDataSheet as $nIndex => $aProduct){
                    if($nIndex == 0){continue;} // ข้ามแถวที่ 1 หัวตารางไป

                    $tPdtCode = trim($aProduct[0]);
                    $tPunCode = trim($aProduct[1]);
                    $tBarCode = trim($aProduct[2]);

                    if( !empty($tPdtCode) && !empty($tPunCode) ){
                        $aGetDataPdtParams = [
                            'tPdtCode'              => $tPdtCode,
                            'tPunCode'              => $tPunCode,
                            'tBarCode'              => $tBarCode,
                            'nLngID'                => $nLangEdit,
                            'tUserSessionID'        => $tUserSessionID,
                            'tPmtGroupNameTmpOld'   => $tPmtGroupNameTmpOld
                        ];
                        $aDataProduct = $this->mPromotionStep1ImportPmtExcel->FSaMGetDataPdt($aGetDataPdtParams);
                        $tStaComplete = $aDataProduct['FTStaComplete'];

                        // ถ้าในเบสมีบาร์โค้ด ก็ใช้บาร์โค้ดในเบส ถ้าไม่มีแล้วใน excel ระบุมา ให้ใช้บาร์โค้ดใน excel ถ้าไม่มีในเบส ไม่มีใน excel ให้แสดง N/A
                        if( $aDataProduct['FTBarCode'] != "" ){
                            $tNewBarCode = $aDataProduct['FTBarCode'];
                        }else{
                            if($tBarCode != "" ){
                                $tNewBarCode = $tBarCode;
                            }else{
                                $tNewBarCode = "N/A";
                            }
                        }

                        if( !empty($aDataProduct) && $tStaComplete == 'COMPLETE' ){
                            $aPmtPdtDtToTempParams = [
                                'tPmtGroupNameTmpOld'   => $tPmtGroupNameTmpOld,
                                'tBchCodeLogin'         => $tBchCodeLogin,
                                'tUserSessionID'        => $tUserSessionID,
                                'tUserSessionDate'      => $tUserSessionDate,
                                'tDocNo'                => 'PMTDOCTEMP',
                                'tPmtGroupTypeTmp'      => $tPmtGroupTypeTmp,
                                'tPmtGroupListTypeTmp'  => $tPmtGroupListTypeTmp,
                                'tPdtCode'              => $aDataProduct['FTPdtCode'],
                                'tPdtName'              => $aDataProduct['FTPdtName'],
                                'tPunCode'              => $aDataProduct['FTPunCode'],
                                'tPunName'              => $aDataProduct['FTPunName'],
                                'tBarCode'              => $aDataProduct['FTBarCode']
                            ];
                            $this->mPromotionStep1PmtPdtDt->FSaMPmtPdtDtToTemp($aPmtPdtDtToTempParams);    
                        }else{
                            if( strlen($tPdtCode) > 20 ){
                                $tMsgFail = "รหัสสินค้ายาวเกินกำหนด";
                            }else if( strlen($tPunCode) > 5 ){
                                $tMsgFail = "รหัสหน่วยยาวเกินกำหนด";
                            }else if( strlen($tBarCode) > 20 ){
                                $tMsgFail = "รหัสบาร์โค้ดยาวเกินกำหนด";
                            }else if( $tStaComplete == '1' ){
                                $tMsgFail = "ไม่พบรหัสหน่วยในระบบ";
                            }else if( $tStaComplete == '2' ){
                                $tMsgFail = "ไม่พบรหัสบาร์โค้ดในระบบ";
                            }else if( $tStaComplete == '3' ){
                                $tMsgFail = "บาร์โค้ดสถานะไม่ใช้งาน";
                            }else if( $tStaComplete == '4' ){
                                $tMsgFail = "สินค้านี้มีอยู่แล้วในกลุ่มนี้";
                            }else{
                                $tMsgFail = "ไม่พบสินค้าในระบบ";
                            }

                            $aDataFail = array(
                                'tHeader'       => 'Product',
                                'FTPdtCode'     => $tPdtCode,
                                'FTPunCode'     => $tPunCode,
                                'FTBarCode'     => $tNewBarCode,
                                'tMsgFail'      => $tMsgFail
                            );
                            array_push($aDataImportFail,$aDataFail);
                        }
                    }else{
                        if( !empty($tPdtCode) && empty($tPunCode) ){
                            $tMsgFail = "ต้องกำหนดรหัสหน่วย";
                            $aDataFail = array(
                                'tHeader'       => 'Product',
                                'FTPdtCode'     => $tPdtCode,
                                'FTPunCode'     => ($tPunCode != "" ? $tPunCode : "N/A"),
                                'FTBarCode'     => ($tBarCode != "" ? $tBarCode : "N/A"),
                                'tMsgFail'      => $tMsgFail
                            );
                            array_push($aDataImportFail,$aDataFail);
                        }else if( empty($tPdtCode) && !empty($tPunCode) ){
                            $tMsgFail = "ต้องกำหนดรหัสสินค้า";
                            $aDataFail = array(
                                'tHeader'       => 'Product',
                                'FTPdtCode'     => ($tPdtCode != "" ? $tPdtCode : "N/A"),
                                'FTPunCode'     => $tPunCode,
                                'FTBarCode'     => ($tBarCode != "" ? $tBarCode : "N/A"),
                                'tMsgFail'      => $tMsgFail
                            );
                            array_push($aDataImportFail,$aDataFail);
                        }
                    }
                }
                /*===== End Product Process ================================================*/
            }else if($tPmtGroupListTypeTmp == "2"){ // Brand
                /*===== Begin Brand Process ================================================*/
                $oExcelSheet = $oLoadExcel->getSheetByName('Brand');
                $aBrandDataSheet = $oExcelSheet->toArray();

                $aClearPmtPdtDtInTmpParams = [
                    'tPmtGroupNameTmpOld' => $tPmtGroupNameTmpOld,
                    'tUserSessionID' => $tUserSessionID
                ];
                $this->mPromotionStep1PmtDt->FSbClearPmtDtInTmp($aClearPmtPdtDtInTmpParams);

                foreach($aBrandDataSheet as $nIndex => $aBrand){
                    if($nIndex == 0){continue;} // ข้ามแถวที่ 1 หัวตารางไป

                    $tBrandCode = trim($aBrand[0]);
                    // $tModelCode = trim($aBrand[1]);
                    if( !empty($tBrandCode) /*&& !empty($aBrand[1])*/ ){

                        $aGetDataBrandParams = [
                            'tBrandCode'            => (isset($tBrandCode) && !empty($tBrandCode) ? $tBrandCode : ''),
                            // 'tModelCode'            => (isset($tModelCode) && !empty($tModelCode) ? $tModelCode : ''),
                            'nLngID'                => $nLangEdit,
                            'tUserSessionID'        => $tUserSessionID,
                            'tPmtGroupNameTmpOld'   => $tPmtGroupNameTmpOld
                        ];
                        $aDataBrand = $this->mPromotionStep1ImportPmtExcel->FSaMGetDataBrand($aGetDataBrandParams);
                        
                        if( isset($aDataBrand['FTPbnCode']) && isset($aDataBrand['FTPbnName']) ){ /*&& isset($aDataBrand['FTPmoCode']) && isset($aDataBrand['FTPmoName'])*/
                            $aPmtBrandDtToTempParams = [
                                'tPmtGroupNameTmpOld'   => $tPmtGroupNameTmpOld,
                                'tBchCodeLogin'         => $tBchCodeLogin,
                                'tUserSessionID'        => $tUserSessionID,
                                'tUserSessionDate'      => $tUserSessionDate,
                                'tDocNo'                => 'PMTDOCTEMP',
                                'tPmtGroupTypeTmp'      => $tPmtGroupTypeTmp,
                                'tPmtGroupListTypeTmp'  => $tPmtGroupListTypeTmp,
                                'tBrandCode'            => $aDataBrand['FTPbnCode'],
                                'tBrandName'            => $aDataBrand['FTPbnName'],
                                'tModelCode'            => NULL,
                                'tModelName'            => NULL
                                // 'tModelCode'            => (isset($aDataBrand['FTPmoCode']) ? $aDataBrand['FTPmoCode'] : NULL ),
                                // 'tModelName'            => (isset($aDataBrand['FTPmoName']) ? $aDataBrand['FTPmoName'] : NULL )
                            ];
                            $this->mPromotionStep1PmtBrandDt->FSaMPmtBrandDtToTemp($aPmtBrandDtToTempParams);    
                        }else{
                            if( strlen($tBrandCode) > 5 ){
                                $tMsgFail = "รหัสยี่ห้อยาวเกินกำหนด";
                            }else{
                                $tMsgFail = "ไม่พบรหัสยี่ห้อในระบบ";
                            }

                            $aDataFail = array(
                                'tHeader'   => 'Brand',
                                'FTPbnCode' => $tBrandCode,
                                'tMsgFail'  => $tMsgFail
                            );
                            array_push($aDataImportFail,$aDataFail);
                        }
                    }
                }
                /*===== End Brand Process ==================================================*/
            }else if($tPmtGroupListTypeTmp == "4"){ // Model
                 /*===== Begin Model Process ================================================*/
                $oExcelSheet        = $oLoadExcel->getSheetByName('Model');
                $aModelDataSheet    = $oExcelSheet->toArray();

                // echo "<pre>"; print_r($aModelDataSheet); echo "</pre>"; exit;

                $aClearPmtPdtDtInTmpParams = [
                    'tPmtGroupNameTmpOld'   => $tPmtGroupNameTmpOld,
                    'tUserSessionID'        => $tUserSessionID
                ];
                $this->mPromotionStep1PmtDt->FSbClearPmtDtInTmp($aClearPmtPdtDtInTmpParams);

                foreach($aModelDataSheet as $nIndex => $aModel){
                    if($nIndex == 0){continue;} // ข้ามแถวที่ 1 หัวตารางไป

                    $tModelCode = trim($aModel[0]);
                    if( !empty($tModelCode) ){
                        $aGetDataModelParams = [
                            'tModelCode'            => (isset($tModelCode) && !empty($tModelCode) ? $tModelCode : ''),
                            'nLngID'                => $nLangEdit,
                            'tUserSessionID'        => $tUserSessionID,
                            'tPmtGroupNameTmpOld'   => $tPmtGroupNameTmpOld
                        ];
                        $aDataModel = $this->mPromotionStep1ImportPmtExcel->FSaMPMTGetDataModel($aGetDataModelParams);
                        
                        if( isset($aDataModel['FTPmoCode']) && isset($aDataModel['FTPmoName']) ){
                            $aPmtModelDtToTempParams = [
                                'tPmtGroupNameTmpOld'   => $tPmtGroupNameTmpOld,
                                'tBchCodeLogin'         => $tBchCodeLogin,
                                'tUserSessionID'        => $tUserSessionID,
                                'tUserSessionDate'      => $tUserSessionDate,
                                'tDocNo'                => 'PMTDOCTEMP',
                                'tPmtGroupTypeTmp'      => $tPmtGroupTypeTmp,
                                'tPmtGroupListTypeTmp'  => $tPmtGroupListTypeTmp,
                                'tModelCode'            => $aDataModel['FTPmoCode'],
                                'tModelName'            => $aDataModel['FTPmoName']
                            ];
                            $this->mPromotionStep1PmtBrandDt->FSaMPMTModelDtToTemp($aPmtModelDtToTempParams);    
                        }else{
                            if( strlen($tModelCode) > 5 ){
                                $tMsgFail = "รหัสรุ่นยาวเกินกำหนด";
                            }else{
                                $tMsgFail = "ไม่พบรหัสรุ่นในระบบ";
                            }

                            $aDataFail = array(
                                'tHeader'   => 'Model',
                                'FTPmoCode' => $tModelCode,
                                'tMsgFail'  => $tMsgFail
                            );
                            array_push($aDataImportFail,$aDataFail);
                        }
                    }
                }
                /*===== End Model Process ==================================================*/
            }else{
                // กรณีนำเข้าไฟล์ที่ยังไม่รองรับ
            }
            

            // echo "<pre>"; print_r($aDataImportFail); echo "</pre>"; exit;
            $aReturn['aDataImpFail'] = $aDataImportFail;

            
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturn['nStaEvent'] = '900';
                $aReturn['tStaMessg'] = "Unsucess Add by Import File";
            } else {
                $this->db->trans_commit();
                $aReturn['nStaEvent'] = '1';
                $aReturn['tStaMessg'] = "Success Add by Import File";
            }
    
            
        }else{
            $aReturn['nStaEvent'] = '900';
            $aReturn['tStaMessg'] = "File Fail";
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));

    }

    /*===== Begin Create Promotion By Import ========================================== */
    /**
     * Functionality : Excel To Temp
     * Parameters : -
     * Creator : 04/08/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FStPromotionImportExcelToTmp()
    {
        $tUserSessionID = $this->session->userdata('tSesSessionID');
        $tUserSessionDate = $this->session->userdata('tSesSessionDate');
        $nLangEdit = $this->session->userdata("tLangEdit");
        $tUserBchCodeDef = $this->session->userdata("tSesUsrBchCodeDefault");

        $aPackData = $this->input->post('aPackData');
        // echo '<pre>';
        // var_dump($aPackData);

        $this->db->trans_begin();

        $aImportExcelDeleteAllInTmpParams = [
            'tUserSessionID' => $tUserSessionID,
        ];
        $this->mPromotionStep1ImportPmtExcel->FSxMImportExcelDeleteAllInTmp($aImportExcelDeleteAllInTmpParams);

        $aImportExcelToTmpParams = [
            'tUserBchCodeDef' => $tUserBchCodeDef,
            'tUserSessionID' => $tUserSessionID,
            'nLangID' => $nLangEdit,
            'tUserSessionDate' => $tUserSessionDate,
            'aPackData' => $aPackData
        ];
        $this->mPromotionStep1ImportPmtExcel->FSxMImportExcelToTmp($aImportExcelToTmpParams);

        /*===== Begin Validate in DB(DT) ===============================================*/

        $aPmdStaTypeCon = [1,2];
        foreach($aPmdStaTypeCon as $tPmdStaType) {
            $aPmtChkCodeDupOnTypeInTempParams = [
                'tTableKey' => 'PMT_DT',
                'tUserSessionID' => $tUserSessionID,
                'tFieldName' => 'FTBarCode',
                'tPmdStaType' => $tPmdStaType
            ];
            FCNnMasTmpPmtChkCodeDupOnTypeInTemp($aPmtChkCodeDupOnTypeInTempParams);
        }

        $aPmtChkCodeInDBParams = [
            'tTableKey' => 'PMT_DT',
            'tTableName' => 'TCNMPdtBar',
            'tUserSessionID' => $tUserSessionID,
            'tFieldName' => 'FTBarCode',
            'tErrMsg' => 'ไม่พบสินค้า'
        ];
        FCNnMasTmpPmtChkCodeInDB($aPmtChkCodeInDBParams);
        
        $aChkCodeInDBDTParams = [
            'tTableKey' => 'PMT_DT',
            'tTableName' => 'TCNMPdtBar',
            'tUserSessionID' => $tUserSessionID,
            'tFieldName' => 'FTPunCode',
            'tErrMsg' => 'ไม่พบหน่วยสินค้า'
        ];
        FCNnMasTmpChkCodeInDB($aChkCodeInDBDTParams);
        /*===== End Validate in DB(DT) =================================================*/

        /*===== Begin Validate in DB(CB) ===============================================*/
        $aPmtChkCodeInTempCBParams = [
            'tTableKey' => 'PMT_CB',
            'tTableKeyIn' => 'PMT_DT',
            'tTableName' => 'TCNTImpMasTmp',
            'tUserSessionID' => $tUserSessionID,
            'tFieldName' => 'FTPmdGrpName',
            'tErrMsg' => 'กลุ่มรายการไม่ถูกต้อง'
        ];
        FCNnMasTmpPmtChkCodeInTemp($aPmtChkCodeInTempCBParams);
        /*===== End Validate in DB(CB) =================================================*/

        /*===== Begin Validate in DB(CG) ===============================================*/
        $aPmtChkCodeInTempCGParams = [
            'tTableKey' => 'PMT_CG',
            'tTableKeyIn' => 'PMT_DT',
            'tTableName' => 'TCNTImpMasTmp',
            'tUserSessionID' => $tUserSessionID,
            'tFieldName' => 'FTPmdGrpName',
            'tErrMsg' => 'กลุ่มรายการไม่ถูกต้อง'
        ];
        FCNnMasTmpPmtChkCodeInTemp($aPmtChkCodeInTempCGParams);
        /*===== End Validate in DB(CG) =================================================*/

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Insert to Temp Fail"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Insert to Temp Success'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Get Main Page
     * Parameters : -
     * Creator : 04/08/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FStPromotionGetImportExcelMainPage()
    {
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $tUserSessionID = $this->session->userdata('tSesSessionID');

        $aImportGetHDDataInTmpParams = [
            'tUserSessionID' => $tUserSessionID,
        ];
        $aImportGetHDDataInTmp = $this->mPromotionStep1ImportPmtExcel->FSaMImportGetHDDataInTmp($aImportGetHDDataInTmpParams);

        $aImportGetCouponDataInTmpParams = [
            'tUserSessionID' => $tUserSessionID,
        ];
        $aImportGetCouponDataInTmp = $this->mPromotionStep1ImportPmtExcel->FSaMImportGetCouponDataInTmp($aImportGetCouponDataInTmpParams);

        $aImportGetPointDataInTmpParams = [
            'tUserSessionID' => $tUserSessionID,
        ];
        $aImportGetPointDataInTmp = $this->mPromotionStep1ImportPmtExcel->FSaMImportGetPointDataInTmp($aImportGetPointDataInTmpParams);

        $aParams = [
            'aDataListHD' => $aImportGetHDDataInTmp,
            'aDataListCoupon' => $aImportGetCouponDataInTmp,
            'aDataListPoint' => $aImportGetPointDataInTmp,
            'nOptDecimalShow' => $nOptDecimalShow
        ];
        $tHtml = $this->load->view('document/promotion/add_pmt_by_import/wPromotionMain', $aParams, true);
        
        $aResponse = [
            'html' => $tHtml
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResponse));
    }

    /**
     * Functionality : Temp to Master
     * Parameters : Ajax
     * Creator : 04/08/2020 Piya
     * Last Modified : -
     * Return : Status
     * Return Type : Json Object
     */
    public function FSoCImportTempToMaster()
    {
        $tUserBchCodeDef = $this->session->userdata("tSesUsrBchCodeDefault");

        $this->db->trans_begin();

        // Call Auto Gencode Helper
        $aStoreParam = array(
            "tTblName" => 'TCNTPdtPmtHD',
            "tDocType" => 8,
            "tBchCode" => $tUserBchCodeDef,
            "tShpCode" => "",
            "tPosCode" => "",
            "dDocDate" => date("Y-m-d")
        );
        $aAutogen = FCNaHAUTGenDocNo($aStoreParam);
        $tDocNo = $aAutogen[0]["FTXxhDocNo"];

        $aDataMaster = array(
            'nLangEdit'	=> $this->session->userdata("tLangEdit"),
            'tUserSessionID' => $this->session->userdata("tSesSessionID"),
            'tCreatedOn' => date('Y-m-d H:i:s'),
            'tCreatedBy' => $this->session->userdata("tSesUsername"),
            'tTypeCaseDuplicate' => $this->input->post('tTypeCaseDuplicate'),
            'tDocNo' => $tDocNo
        );

        $this->mPromotionStep1ImportPmtExcel->FSxMImportTempToMaster($aDataMaster);
        $this->mPromotionStep1ImportPmtExcel->FSxMImportExcelDeleteAllInTmp($aDataMaster);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $aReturn = array(
                'tCode' => '99',
                'tDesc' => 'Insert Temp to Master Fail'
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'tCode' => '1',
                'tDesc' => 'Insert Temp to Master Success'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Clear Temp
     * Parameters : Ajax
     * Creator : 04/08/2020 Piya
     * Last Modified : -
     * Return : Status
     * Return Type : Json Object
     */
    public function FSoCImportClearInTemp()
    {
        $aDataMaster = array(
            'tUserSessionID' => $this->session->userdata("tSesSessionID"),
        );

        $this->db->trans_begin();

        $this->mPromotionStep1ImportPmtExcel->FSxMImportExcelDeleteAllInTmp($aDataMaster);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $aReturn = array(
                'tCode' => '99',
                'tDesc' => 'Clear Temp Fail'
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'tCode' => '1',
                'tDesc' => 'Clear Temp Success'
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

/*===== Begin Summary HD =======================================================*/
    
/*===== End Summary HD =========================================================*/

/*===== Begin Product Group ====================================================*/
    /**
     * Functionality : Get Import Data in Temp
     * Parameters : Ajax
     * Creator : 04/08/2020 Piya
     * Last Modified : -
     * Return : Import Data
     * Return Type : Json Object
     */
    public function FSoCImportGetPdtGroupInTmp(){
        $aParams = [];
        $tHtml = $this->load->view('document/promotion/add_pmt_by_import/wPromotionPdtGroupTable', $aParams, true);
        
        $aResponse = [
            'html' => $tHtml
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResponse));
    }

    /**
     * Functionality : Get Import Data in Temp (JSON)
     * Parameters : Ajax
     * Creator : 04/08/2020 Piya
     * Last Modified : -
     * Return : Import Data
     * Return Type : Json Object
     */
    public function FSoCImportGetPdtGroupDataJsonInTmp(){
        $aImportGetPdtGroupDataInTmpParams = array(
			'nPageNumber' => ($this->input->post('nPageNumber') == 0) ? 1 : $this->input->post('nPageNumber'),
			'nLangID' => $this->session->userdata("tLangEdit"),
			'tTableKey'	=> 'PROMOTION_IMPORT',
			'tUserSessionID' => $this->session->userdata("tSesSessionID"),
			'tTextSearch' => $this->input->post('tSearch') 
		);
		$aDataInTemp = $this->mPromotionStep1ImportPmtExcel->FSaMImportGetPdtGroupDataInTmp($aImportGetPdtGroupDataInTmpParams);
        
        $aData['draw'] = ($this->input->post('nPageNumber') == 0) ? 1 : $this->input->post('nPageNumber');
        $aData['recordsTotal'] = $aDataInTemp['nNumrow'];
        $aData['recordsFiltered'] = $aDataInTemp['nNumrow'];
        $aData['data'] = $aDataInTemp;
        $aData['error'] = array();
        $aData['tTextSearch'] = $aImportGetPdtGroupDataInTmpParams['tTextSearch'];
        
        $this->output->set_content_type('application/json')->set_output(json_encode($aData));
    }

    /**
     * Functionality : Delete in Temp by SeqNo
     * Parameters : Ajax
     * Creator : 04/08/2020 Piya
     * Last Modified : -
     * Return : Status
     * Return Type : Json Object
     */
	public function FSoCImportDeletePdtGroupInTempBySeqNo(){
        $aImportDataItem = json_decode($this->input->post('tDataItem'), JSON_FORCE_OBJECT);
        $tUserSessionID = $this->session->userdata('tSesSessionID');

        $this->db->trans_begin();

        $aImportDeletePdtGroupInTempBySeqParams = array(
            'tUserSessionID' => $tUserSessionID,
            'aSeqNo' => $aImportDataItem['aSeqNo']
        );
        $aResDel = $this->mPromotionStep1ImportPmtExcel->FSaMImportDeletePdtGroupInTempBySeq($aImportDeletePdtGroupInTempBySeqParams);

        foreach($aImportDataItem['aItems'] as $aItem){
            // ตรวจสอบกรอกข้อมูลซ้ำ Temp
            if($aItem['tSta'] == "5"){ 
                $aParams = [
                    'tTableKey' => 'PMT_DT',
                    'tUserSessionID' => $tUserSessionID, 
                    'tFieldName' => 'FTBarCode',
                    'tFieldValue' => $aItem['tPmdBarCode']
                ];
                FCNnMasTmpPmtChkInlineCodeDupInTemp($aParams);
            }
        }

        $aPmdStaTypeCon = [1,2];
        foreach($aPmdStaTypeCon as $tPmdStaType) {
            $aPmtChkCodeDupOnTypeInTempParams = [
                'tTableKey' => 'PMT_DT',
                'tUserSessionID' => $tUserSessionID,
                'tFieldName' => 'FTBarCode',
                'tPmdStaType' => $tPmdStaType
            ];
            FCNnMasTmpPmtChkCodeDupOnTypeInTemp($aPmtChkCodeDupOnTypeInTempParams);
        }

        if($this->db->trans_status() === false){
            // not success
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Unsucess Add SaleMachine Group"
            );
        }else{
            // success
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent' => $aResDel['tCode'],
                'tStaMessg' => $aResDel['tDesc']
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Get Status in Temp
     * Parameters : Ajax
     * Creator : 04/08/2020 Piya
     * Last Modified : -
     * Return : Status
     * Return Type : Json Object
     */
    public function FSoCImportGetStaPdtGroupInTemp(){
        $aData = [];

        $aGetStaInTempParams = array(
            'tUserSessionID' => $this->session->userdata("tSesSessionID"),
        );
        $aGetStaInTemp = $this->mPromotionStep1ImportPmtExcel->FSaMImportGetStaPdtGroupInTemp($aGetStaInTempParams);
        
        $aData['nRecordTotal'] = isset($aGetStaInTemp[0]['nRecordTotal'])?$aGetStaInTemp[0]['nRecordTotal']:0;
        $aData['nStaSuccess'] = isset($aGetStaInTemp[0]['nStaSuccess'])?$aGetStaInTemp[0]['nStaSuccess']:0;
        $aData['nStaNewOrUpdate'] = isset($aGetStaInTemp[0]['nStaNewOrUpdate'])?$aGetStaInTemp[0]['nStaNewOrUpdate']:0;
        
        $this->output->set_content_type('application/json')->set_output(json_encode($aData));
    }
/*===== End Product Group ======================================================*/

/*===== Begin Condition กลุ่มซื้อ =================================================*/
    /**
     * Functionality : Get Import Data in Temp
     * Parameters : Ajax
     * Creator : 04/08/2020 Piya
     * Last Modified : -
     * Return : Import Data
     * Return Type : Json Object
     */
    public function FSoCImportGetCBInTmp(){
        $aParams = [];
        $tHtml = $this->load->view('document/promotion/add_pmt_by_import/wPromotionCBTable', $aParams, true);
        
        $aResponse = [
            'html' => $tHtml
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResponse));
    }

    /**
     * Functionality : Get Import Data in Temp (JSON)
     * Parameters : Ajax
     * Creator : 04/08/2020 Piya
     * Last Modified : -
     * Return : Import Data
     * Return Type : Json Object
     */
    public function FSoCImportGetCBDataJsonInTmp(){
        $aImportGetCBDataInTmpParams = array(
			'nPageNumber' => ($this->input->post('nPageNumber') == 0) ? 1 : $this->input->post('nPageNumber'),
			'nLangID' => $this->session->userdata("tLangEdit"),
			'tTableKey'	=> 'PROMOTION_IMPORT',
			'tUserSessionID' => $this->session->userdata("tSesSessionID"),
			'tTextSearch' => $this->input->post('tSearch') 
		);
		$aDataInTemp = $this->mPromotionStep1ImportPmtExcel->FSaMImportGetCBDataInTmp($aImportGetCBDataInTmpParams);
        
        $aData['draw'] = ($this->input->post('nPageNumber') == 0) ? 1 : $this->input->post('nPageNumber');
        $aData['recordsTotal'] = $aDataInTemp['nNumrow'];
        $aData['recordsFiltered'] = $aDataInTemp['nNumrow'];
        $aData['data'] = $aDataInTemp;
        $aData['error'] = array();
        $aData['tTextSearch'] = $aImportGetCBDataInTmpParams['tTextSearch'];
        
        $this->output->set_content_type('application/json')->set_output(json_encode($aData));
    }

    /**
     * Functionality : Delete in Temp by SeqNo
     * Parameters : Ajax
     * Creator : 04/08/2020 Piya
     * Last Modified : -
     * Return : Status
     * Return Type : Json Object
     */
	public function FSoCImportDeleteCBInTempBySeqNo(){
        $aImportDataItem = json_decode($this->input->post('tDataItem'), JSON_FORCE_OBJECT);
        $tUserSessionID = $this->session->userdata('tSesSessionID');

        $this->db->trans_begin();

        $aImportDeleteCBInTempBySeqParams = array(
            'tUserSessionID' => $tUserSessionID,
            'aSeqNo' => $aImportDataItem['aSeqNo']
        );
        $aResDel = $this->mPromotionStep1ImportPmtExcel->FSaMImportDeleteCBInTempBySeq($aImportDeleteCBInTempBySeqParams);

        foreach($aImportDataItem['aItems'] as $aItem){
            // ตรวจสอบกรอกข้อมูลซ้ำ Temp
            // if($aItem['tSta'] == "5"){ 
            //     $aParams = [
            //         'tTableKey' => 'PMT_CB',
            //         'tUserSessionID' => $tUserSessionID, 
            //         'tFieldName' => 'FTPmdBarCode',
            //         'tFieldValue' => $aItem['tPmdBarCode']
            //     ];
            //     FCNnMasTmpChkInlineCodeDupInTemp($aParams);
            // }
        }

        if($this->db->trans_status() === false){
            // not success
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Unsucess Add SaleMachine Group"
            );
        }else{
            // success
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent' => $aResDel['tCode'],
                'tStaMessg' => $aResDel['tDesc']
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Get Status in Temp
     * Parameters : Ajax
     * Creator : 04/08/2020 Piya
     * Last Modified : -
     * Return : Status
     * Return Type : Json Object
     */
    public function FSoCImportGetStaCBInTemp(){
        $aData = [];

        $aGetStaInTempParams = array(
            'tUserSessionID' => $this->session->userdata("tSesSessionID"),
        );
        $aGetStaInTemp = $this->mPromotionStep1ImportPmtExcel->FSaMImportGetStaCBInTemp($aGetStaInTempParams);
        
        $aData['nRecordTotal'] = isset($aGetStaInTemp[0]['nRecordTotal'])?$aGetStaInTemp[0]['nRecordTotal']:0;
        $aData['nStaSuccess'] = isset($aGetStaInTemp[0]['nStaSuccess'])?$aGetStaInTemp[0]['nStaSuccess']:0;
        $aData['nStaNewOrUpdate'] = isset($aGetStaInTemp[0]['nStaNewOrUpdate'])?$aGetStaInTemp[0]['nStaNewOrUpdate']:0;
        
        $this->output->set_content_type('application/json')->set_output(json_encode($aData));
    }
/*===== End Condition กลุ่มซื้อ ===================================================*/

/*===== Begin Option1-กลุ่มรับ(กรณีส่วนลด) =========================================*/
    /**
     * Functionality : Get Import Data in Temp
     * Parameters : Ajax
     * Creator : 04/08/2020 Piya
     * Last Modified : -
     * Return : Import Data
     * Return Type : Json Object
     */
    public function FSoCImportGetCGInTmp(){
        $aParams = [];
        $tHtml = $this->load->view('document/promotion/add_pmt_by_import/wPromotionCGTable', $aParams, true);
        
        $aResponse = [
            'html' => $tHtml
        ];

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($aResponse));
    }

    /**
     * Functionality : Get Import Data in Temp (JSON)
     * Parameters : Ajax
     * Creator : 04/08/2020 Piya
     * Last Modified : -
     * Return : Import Data
     * Return Type : Json Object
     */
    public function FSoCImportGetCGDataJsonInTmp(){
        $aImportGetCGDataInTmpParams = array(
			'nPageNumber' => ($this->input->post('nPageNumber') == 0) ? 1 : $this->input->post('nPageNumber'),
			'nLangID' => $this->session->userdata("tLangEdit"),
			'tTableKey'	=> 'PROMOTION_IMPORT',
			'tUserSessionID' => $this->session->userdata("tSesSessionID"),
			'tTextSearch' => $this->input->post('tSearch') 
		);
		$aDataInTemp = $this->mPromotionStep1ImportPmtExcel->FSaMImportGetCGDataInTmp($aImportGetCGDataInTmpParams);
        
        $aData['draw'] = ($this->input->post('nPageNumber') == 0) ? 1 : $this->input->post('nPageNumber');
        $aData['recordsTotal'] = $aDataInTemp['nNumrow'];
        $aData['recordsFiltered'] = $aDataInTemp['nNumrow'];
        $aData['data'] = $aDataInTemp;
        $aData['error'] = array();
        $aData['tTextSearch'] = $aImportGetCGDataInTmpParams['tTextSearch'];
        
        $this->output->set_content_type('application/json')->set_output(json_encode($aData));
    }

    /**
     * Functionality : Delete in Temp by SeqNo
     * Parameters : Ajax
     * Creator : 04/08/2020 Piya
     * Last Modified : -
     * Return : Status
     * Return Type : Json Object
     */
	public function FSoCImportDeleteCGInTempBySeqNo(){
        $aImportDataItem = json_decode($this->input->post('tDataItem'), JSON_FORCE_OBJECT);
        $tUserSessionID = $this->session->userdata('tSesSessionID');

        $this->db->trans_begin();

        $aImportDeleteCGInTempBySeqParams = array(
            'tUserSessionID' => $tUserSessionID,
            'aSeqNo' => $aImportDataItem['aSeqNo']
        );
        $aResDel = $this->mPromotionStep1ImportPmtExcel->FSaMImportDeleteCGInTempBySeq($aImportDeleteCGInTempBySeqParams);

        foreach($aImportDataItem['aItems'] as $aItem){
            // ตรวจสอบกรอกข้อมูลซ้ำ Temp
            if($aItem['tSta'] == "5"){ 
                $aParams = [
                    'tTableKey' => 'PMT_DT',
                    'tUserSessionID' => $tUserSessionID, 
                    'tFieldName' => 'FTPmdBarCode',
                    'tFieldValue' => $aItem['tPmdBarCode']
                ];
                FCNnMasTmpChkInlineCodeDupInTemp($aParams);
            }
        }

        if($this->db->trans_status() === false){
            // not success
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => "Unsucess Add SaleMachine Group"
            );
        }else{
            // success
            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent' => $aResDel['tCode'],
                'tStaMessg' => $aResDel['tDesc']
            );
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aReturn));
    }

    /**
     * Functionality : Get Status in Temp
     * Parameters : Ajax
     * Creator : 04/08/2020 Piya
     * Last Modified : -
     * Return : Status
     * Return Type : Json Object
     */
    public function FSoCImportGetStaCGInTemp(){
        $aData = [];

        $aGetStaInTempParams = array(
            'tUserSessionID' => $this->session->userdata("tSesSessionID"),
        );
        $aGetStaInTemp = $this->mPromotionStep1ImportPmtExcel->FSaMImportGetStaCGInTemp($aGetStaInTempParams);
        
        $aData['nRecordTotal'] = isset($aGetStaInTemp[0]['nRecordTotal'])?$aGetStaInTemp[0]['nRecordTotal']:0;
        $aData['nStaSuccess'] = isset($aGetStaInTemp[0]['nStaSuccess'])?$aGetStaInTemp[0]['nStaSuccess']:0;
        $aData['nStaNewOrUpdate'] = isset($aGetStaInTemp[0]['nStaNewOrUpdate'])?$aGetStaInTemp[0]['nStaNewOrUpdate']:0;
        
        $this->output->set_content_type('application/json')->set_output(json_encode($aData));
    }
/*===== End Option1-กลุ่มรับ(กรณีส่วนลด) ===========================================*/

/*===== Begin Option2-กลุ่มรับ(กรณีcoupon) ========================================*/

/*===== End Option2-กลุ่มรับ(กรณีcoupon) ==========================================*/

/*===== Begin Option3-กลุ่มรับ(กรณีแต้ม) ===========================================*/

/*===== End Option3-กลุ่มรับ(กรณีแต้ม) =============================================*/

    /*===== End Create Promotion By Import ============================================ */
}
