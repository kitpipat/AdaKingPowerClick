<?php
defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH.'third_party/PHPExcel/Classes/PHPExcel.php';
include APPPATH.'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';
include APPPATH.'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

require APPPATH.'libraries/phpwkhtmltopdf/vendor/autoload.php';
use mikehaertl\wkhtmlto\Pdf;

class cRptCardActiveDetail extends CI_Controller {

    private $tComName;
    private $tRptName;
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('reportanalysis/mReportAnalysis');
        $this->load->model('pos5/company/mCompany');

        $this->load->model('reportanalysis/mReportAnalysis');
        $this->load->model('reportanalysis/mReportCardCallProcedure');
        $this->tComName = gethostname();
        $this->tRptName = 'CardActiveDetail';
    }

    //Functionality: ฟังก์ชั่น Export Excel
    //Parameters:  Function Parameter
    //Creator: 19/12/2018 Wasin(Yoshi)
    //Return: object Status Export Excel
    //ReturnType: Object
    public function FSoCExportExcel(){
        $aDataInputReport   = $this->input->post('oInputCondition');
        $aFilterReport = array(
            // สาขา
            'tBchCodeFrom'  => $aDataInputReport['tBchCodeFrom'],
            'tBchNameFrom'  => $aDataInputReport['tBchNameFrom'],
            'tBchCodeTo'    => $aDataInputReport['tBchCodeTo'],
            'tBchNameTo'    => $aDataInputReport['tBchNameTo'],
            // รหัสบัตร
            'tCrdCodeFrom'  => $aDataInputReport['tCrdCodeFrom'],
            'tCrdNameFrom'  => $aDataInputReport['tCrdNameFrom'],
            'tCrdCodeTo'    => $aDataInputReport['tCrdCodeTo'],
            'tCrdNameTo'    => $aDataInputReport['tCrdNameTo'],
            // วันที่
            'tDateFrom'     => $aDataInputReport['tDateFrom'],
            'tDateTo'       => $aDataInputReport['tDateTo'],
            
            'tCompName'         => $this->tComName,
            'tRptName'         => $this->tRptName,
            'FNLngID'           => FCNaHGetLangEdit(),
            'nRow'              => 100000, // Limit 100000
            'nPage'             => 1
        );
        
        // Get data in temp
        $aDataReport = $this->mReportAnalysis->FSaMRptCardActiveDetail($aFilterReport, $aFilterReport['nRow']);

        $aReportData = $this->FSaCExportReportExcel($aDataReport['raItems'], $aFilterReport);
        echo json_encode($aReportData);
    }
    
    //Functionality: ฟังก์ชั่น Render Export Excel
    //Parameters:  Function Parameter
    //Creator: 19/12/2018 Wasin(Yoshi)
    //Return: Array Data Report
    //ReturnType: Array
    private function FSaCExportReportExcel($paDataReport,$paFilterReport){
        try{
            if(is_array($paDataReport) && !empty($paDataReport)){

                /** ข้อมูลบริษัท */
                $aDataWhere = array('FNLngID' => FCNaHGetLangEdit());
                $tAPIReq    = "";
                $tMethodReq = "GET";
                $aCompData	= $this->mCompany->FSaMCMPList($tAPIReq,$tMethodReq,$aDataWhere);
                if($aCompData['rtCode'] == '1'){
                    $tCompName      = $aCompData['raItems']['rtCmpName'];
                    $tBchCode       = $aCompData['raItems']['rtCmpBchCode'];
                    $tBchName       = $aCompData['raItems']['rtCmpBchName'];
                    $tBchTaxNo      = $this->mReportAnalysis->FSaMRPAGetAddTaxNo($tBchCode);
                    $aCompAddress   = FCNxHADDGetAddress($tBchCode);
                    $tAddressLine1  = $aCompAddress['tAddressLine1'];
                    $tAddressLine2  = $aCompAddress['tAddressLine2'];
                }else{
                    $tCompName      = "-";
                    $tBchCode       = "-";
                    $tBchName       = "-";
                    $tBchTaxNo      = "-";
                    $tAddressLine1  = "";
                    $tAddressLine2  = "";
                }

                $tTitleReport   = language('reportanalysis/reportanalysis','tRPATitleRptCardActiveDetail');
                $dDateExport    = date('Y-m-d');
                $tTime          = date('H:i:s');
                $tAddressComp   = $tAddressLine1.' '.$tAddressLine2;
                $tTextDetail    = language('reportanalysis/reportanalysis','tRPATaxNo').' : '.$tBchTaxNo.'  '.language('reportanalysis/reportanalysis','tRPADatePrint').' : '.$dDateExport.'  '.language('reportanalysis/reportanalysis','tRPATimePrint').' : '.$tTime;

                /** ตั้งค่า Font Size */
                $aStyleRptName      = array('font'  => array('size' => 14,'bold' => true,));
                $aStyleHeadder      = array('font'  => array('size' => 12,'bold' => true,'color' => array('rgb' => 'FFFFFF')));
                $style3             = array('font'  => array('size' => 12,'bold' => true,'color' => array('rgb' => 'FFFFFF')));
                $StyleCompFont      = array('font'  => array('size' => 12));
                $StyleAddressFont   = array('font'  => array('size' => 11));
                $StyleFont          = array('font'  => array('name' => 'TH Sarabun New'));

                // Initiate PHPExcel cache
                $oCacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
                $aCacheSettings = array(' memoryCacheSize ' => '8000MB', 'cacheTime' => 3600 * 120);
                PHPExcel_Settings::setCacheStorageMethod($oCacheMethod, $aCacheSettings);
                
                /** เริ่ม phpExcel */
                $objPHPExcel = new PHPExcel();

                /** A4 ตั้งค่าหน้ากระดาษ */
                $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                
                /** ตั้งค่า Zoom */
                $objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(80);

                /** Set Font */
                $objPHPExcel->getActiveSheet()->getStyle('A1:Z1000')->applyFromArray($StyleFont);

                /** จัดความกว้างของคอลัมน์ */
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);

                /** ชื่อ Conpany */
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $tCompName."(".$tBchName.")")->getStyle('A1')->applyFromArray($StyleCompFont);

                /** ที่อยู่ Company */
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2',trim($tAddressComp))->getStyle('A2')->applyFromArray($StyleAddressFont);

                /** ชื่อหัวรายงาน */
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:E1');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', $tTitleReport);
                $objPHPExcel->getActiveSheet()->getStyle("B1")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($aStyleRptName);

                /** กำหนกหัวตาราง */
                $nStartRowHeadder   = 5;
                $nStartRowFillter   = 3;

                $tFillterColumLEFT  = "D";
                $tFillterColumRIGHT = "E";

                /** Fillter Branch */
                if(!empty($paFilterReport['tBchCodeFrom']) && !empty($paFilterReport['tBchCodeTo'])){

                    /** Left Filter */
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT.$nStartRowFillter, language('reportanalysis/reportanalysis','tRPABchFrom').' : '.$paFilterReport['tBchNameFrom']);
                    $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT.$nStartRowFillter)
                    ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    /** Right Filter */
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumRIGHT.$nStartRowFillter, language('reportanalysis/reportanalysis','tRPABchTo').' : '.$paFilterReport['tBchNameTo']);
                    $objPHPExcel->getActiveSheet()->getStyle($tFillterColumRIGHT.$nStartRowFillter)
                    ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    if($nStartRowFillter>3){
                        $nStartRowHeadder += 1;
                    }
                    $nStartRowFillter += 1;
                }
                
                /** Fillter CardCode */
                if(!empty($paFilterReport['tCrdCodeFrom']) && !empty($paFilterReport['tCrdCodeTo'])){
                    /** Left Filter */
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT.$nStartRowFillter, language('reportanalysis/reportanalysis','tCrdCodeFrom').' : '.$paFilterReport['tCrdNameFrom']);
                    $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT.$nStartRowFillter)
                    ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    /** Right Filter */
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumRIGHT.$nStartRowFillter, language('reportanalysis/reportanalysis','tCrdCodeTo').' : '.$paFilterReport['tCrdNameTo']);
                    $objPHPExcel->getActiveSheet()->getStyle($tFillterColumRIGHT.$nStartRowFillter)
                    ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    
                    if($nStartRowFillter>3){
                        $nStartRowHeadder += 1;
                    }
                    $nStartRowFillter += 1;
                }


                /** Filter Date */
                if(!empty($paFilterReport['tDateFrom']) && !empty($paFilterReport['tDateTo'])){

                    /** Left Filter */
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT.$nStartRowFillter, language('reportanalysis/reportanalysis','tRPADateFrom').' : '.$paFilterReport['tDateFrom']);
                    $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT.$nStartRowFillter)
                    ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    /** Right Filter */
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumRIGHT.$nStartRowFillter, language('reportanalysis/reportanalysis','tRPADateTo').' : '.$paFilterReport['tDateTo']);
                    $objPHPExcel->getActiveSheet()->getStyle($tFillterColumRIGHT.$nStartRowFillter)
                    ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    if($nStartRowFillter>3){
                        $nStartRowHeadder += 1;
                    }
                    $nStartRowFillter += 1;
                }


                /** รายละเอียดการออกรายงาน */
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.($nStartRowHeadder-1).':J'.($nStartRowHeadder-1));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($nStartRowHeadder-1),$tTextDetail);
                $objPHPExcel->getActiveSheet()->getStyle('A'.($nStartRowHeadder-1))->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                /**  หัวตาราง */
                $objPHPExcel->getActiveSheet()->getStyle('A'.$nStartRowHeadder.':J'.$nStartRowHeadder)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('306384');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$nStartRowHeadder.':N'.$nStartRowHeadder)->applyFromArray($aStyleHeadder);

                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$nStartRowHeadder, language('reportanalysis/reportanalysis','tRPA4TBBarchCode'))
                ->setCellValue('B'.$nStartRowHeadder, language('reportanalysis/reportanalysis','tRPA4TBBarchName'))
                ->setCellValue('C'.$nStartRowHeadder, language('reportanalysis/reportanalysis','tRPA4TBCardCode'))
                ->setCellValue('D'.$nStartRowHeadder, language('reportanalysis/reportanalysis','tRPA4TBCardName'))
                ->setCellValue('E'.$nStartRowHeadder, language('reportanalysis/reportanalysis','tRPA4TBDocDate'))
                ->setCellValue('F'.$nStartRowHeadder, language('reportanalysis/reportanalysis','tRPA4TBDocTime'))
                ->setCellValue('G'.$nStartRowHeadder, language('reportanalysis/reportanalysis','tRPA4TBDocType'))
                ->setCellValue('H'.$nStartRowHeadder, language('reportanalysis/reportanalysis','tRPA4TBCrdHoderID'))
                ->setCellValue('I'.$nStartRowHeadder, language('reportanalysis/reportanalysis','tRPA4TBPosCode'))
                ->setCellValue('J'.$nStartRowHeadder, language('reportanalysis/reportanalysis','tRPA4TBTxtCrdValue'));

                //ตัวอักษร Head Center
                $objPHPExcel->getActiveSheet()->getStyle("A".$nStartRowHeadder.":J".$nStartRowHeadder)
                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                /** ลูบข้อมูล */
                $nStartRowData      = $nStartRowHeadder+1;
                $nNum               = 0;
                $nLastRowNuber      = 0;
                $tBranchCurrent     = '';
                $tCrdCodeCurrent    = '';
                
                // Summary
                $cSumTxnCrdValue = 0.00;
                
                foreach($paDataReport AS $nKey => $aValue){
                    $nNum++;

                    /** Check Branch Row Duplicate */ 
                    if($tBranchCurrent != $aValue['rtBchCode']){
                        $tBranchCurrent = $aValue['rtBchCode'];
                        $tBchCode       = $aValue['rtBchCode'];
                        $tBchName       = $aValue['rtBchName'];
                    }else{
                        $tBchCode = '';
                        $tBchName = '';
                    }

                    /** Check Card Code Row Duplicate */
                    if($tCrdCodeCurrent != $aValue['rtCrdCode']){
                        $tCrdCodeCurrent    = $aValue['rtCrdCode'];
                        $tCrdCode   = $aValue['rtCrdCode'];
                    }else{
                        $tCrdCode   = "";
                    }

                    $aTxnDocType = explode(";",$aValue['rtTxnDocTypeName']);
                    if($paFilterReport['FNLngID'] == '1'){
                        $tTxtDocType    = $aTxnDocType[0];
                    }else{
                        $tTxtDocType    = $aTxnDocType[1];
                    }
                    
                    // Summary
                    $cSumTxnCrdValue += floatval($aValue['rtTxnValue']);
                
                    /** เซ็ทข้อมูลในตาราง */
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$nStartRowData, '  '.$tBchCode)
                    ->setCellValue('B'.$nStartRowData, '  '.$tBchName)
                    ->setCellValue('C'.$nStartRowData, '  '.$tCrdCode)
                    ->setCellValue('D'.$nStartRowData, '  '.$aValue['rtCrdName'])
                    ->setCellValue('E'.$nStartRowData, '  '.$aValue['rtTxnDocDate'])
                    ->setCellValue('F'.$nStartRowData, '  '.$aValue['rtTxnDocTime'])
                    ->setCellValue('G'.$nStartRowData, '  '.$tTxtDocType)
                    ->setCellValue('H'.$nStartRowData, '  '.$aValue['rtCrdHolderID'])
                    ->setCellValue('I'.$nStartRowData, '  '.$aValue['rtTxnPosCode'])
                    ->setCellValue('J'.$nStartRowData, '  '.number_format(floatval($aValue['rtTxnValue']),2));

                    /** จัดตัวอักษรข้อมูลกลาง */
                    $objPHPExcel->getActiveSheet()->getStyle("A".$nStartRowData.":I".$nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    /** จัดตัวอักษรชิดขวา */
                    $objPHPExcel->getActiveSheet()->getStyle("J".$nStartRowData.":J".$nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $nLastRowNuber  =   $nStartRowData;
                    $nStartRowData++;
                }
                
                // Set Last Row Total Amount
                $nRowLastNum = $nLastRowNuber+1;
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('I'.$nRowLastNum, '  '.language('reportcard/reportcard','tRPCTBFooterSumAll'))
                /*->setCellValue('B'.$nRowLastNum, '  '.$nNum.'   '.language('reportcard/reportcard','tRPCTBFooterList'))
                ->setCellValue('C'.$nRowLastNum, '  '.'')
                ->setCellValue('D'.$nRowLastNum, '  '.'')
                ->setCellValue('E'.$nRowLastNum, '  '.'')
                ->setCellValue('F'.$nRowLastNum, '  '.'')
                ->setCellValue('G'.$nRowLastNum, '  '.'')
                ->setCellValue('H'.$nRowLastNum, '  '.'')
                ->setCellValue('I'.$nRowLastNum, '  '.'')*/
                ->setCellValue('J'.$nRowLastNum, '  '.number_format(floatval($cSumTxnCrdValue),2));
                //ตัวอักษรชิดขวา
                $objPHPExcel->getActiveSheet()->getStyle("I".$nRowLastNum.":J".$nRowLastNum)
                ->getAlignment()
                ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                //ใส่สี Last Row
                /*$objPHPExcel->getActiveSheet()->getStyle('A'.$nRowLastNum.':J'.$nRowLastNum)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB('306384');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$nRowLastNum.':J'.$nRowLastNum)->applyFromArray($aStyleHeadder);*/
                
                //Export File Excel
                $tFilename       = 'ReportAnalysis4-'.date("dmYhis").'.xlsx';

                header("Pragma: public");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Content-Type: application/force-download");
                header("Content-Type: application/octet-stream");
                header("Content-Type: application/download");;
                header("Content-Disposition: attachment;filename=$tFilename");
                header("Content-Transfer-Encoding: binary ");
                
                $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

                $tSesUsername = $this->session->userdata('tSesUsername');

                // Cheack Folder Session In Folder exportexcel
                if(!is_dir(APPPATH.'assets/exportexcel/'.$tSesUsername)){
                    mkdir(APPPATH.'assets/exportexcel/'.$tSesUsername);
                }

                $tPathExport = APPPATH.'assets/exportexcel/'.$tSesUsername.'/';

                $oFiles = glob($tPathExport.'*');
                foreach($oFiles as $tFile){
                    if(is_file($tFile))
                    unlink($tFile);
                }

                $objWriter->save($tPathExport.$tFilename);

                $aResponse =  array(
                    'nStaExport'    => '1',
                    'tFileName'     => $tFilename,
                    'tPathFolder'   => 'application/assets/exportexcel/'.$tSesUsername.'/',
                    'tMessage'      => "Export File Successfully."
                );
            }else{
                $aResponse =  array(
                    'nStaExport'    => '800',
                    'tMessage'      => language('reportanalysis/reportanalysis','tRPANotiChkDataReportNotFound'),
                );
            }
        }catch(Exception $Error){
            $aResponse =  array(
                'nStaExport'    => '500',
                'tMessage'      => $Error->getMessage()
            );
        }
        return $aResponse;
    }


    //Functionality: เช็ค Data Export PDF In DataBase
    //Parameters:  Function Parameter
    //Creator: 14/12/2018 Wasin(Yoshi)
    //Return: object Status Check In DB
    //ReturnType: Object
    public function FSoChkDataExport($pIsReturnJson = true){
        try{
            $aDataInputReport   = $this->input->post('oInputCondition');
            $aFilterReport = array(
                // สาขา
                'tBchCodeFrom'  => $aDataInputReport['tBchCodeFrom'],
                'tBchNameFrom'  => $aDataInputReport['tBchNameFrom'],
                'tBchCodeTo'    => $aDataInputReport['tBchCodeTo'],
                'tBchNameTo'    => $aDataInputReport['tBchNameTo'],
                // รหัสบัตร
                'tCrdCodeFrom'  => $aDataInputReport['tCrdCodeFrom'],
                'tCrdNameFrom'  => $aDataInputReport['tCrdNameFrom'],
                'tCrdCodeTo'    => $aDataInputReport['tCrdCodeTo'],
                'tCrdNameTo'    => $aDataInputReport['tCrdNameTo'],
                //วันที่
                'tDateFrom'     => $aDataInputReport['tDateFrom'],
                'tDateTo'       => $aDataInputReport['tDateTo'],
                
                'tCompName'         => $this->tComName,
                'tRptName'         => $this->tRptName,
                'FNLngID'       => FCNaHGetLangEdit()
            );

            if($this->mReportCardCallProcedure->FSnMExecStoreCardActiveDetail($aFilterReport)) { // Call Store Procedure
                // Get count in temp
                $nCountDataReport = $this->mReportAnalysis->FSaMRptCardActiveDetailCount($aFilterReport);
                $aDataReturn = array(
                    'tCountNumber' => $nCountDataReport,
                    'tMsgReportNotFound' => language('reportanalysis/reportanalysis','tRPANotiChkDataReportNotFound')
                );
            }else{
                $aDataReturn = array(
                    'tCountNumber' => 0,
                    'tMsgReportNotFound' => language('reportanalysis/reportanalysis','tRPANotiChkDataReportNotFound')
                );   
            }

            if($pIsReturnJson){
                echo json_encode($aDataReturn);
            }else{
                return $aDataReturn;
            }
            
        }catch(Exception $Error){
            echo "Eror cRptCardActiveDetail Function(FSoChkDataExport) => ".$Error;
        }
    }

    //Functionality: รับค่า เพื่อ Export PDF
    //Parameters:  Function Parameter
    //Creator: 14/12/2018 Wasin (Yoshi)
    //Return : object view or File
    //Return Type: Object
    public function FSoCExportRptPDF(){
        try{
            /** ข้อมูลบริษัท */
            $aDataWhere = array('FNLngID' => FCNaHGetLangEdit());
            $tAPIReq    = "";
            $tMethodReq = "GET";
            $aCompData	= $this->mCompany->FSaMCMPList($tAPIReq,$tMethodReq,$aDataWhere);
            if($aCompData['rtCode'] == '1'){
                $tCompName      = $aCompData['raItems']['rtCmpName'];
                $tBchCode       = $aCompData['raItems']['rtCmpBchCode'];
                $tBchName       = $aCompData['raItems']['rtCmpBchName'];
                $tBchTaxNo      = $this->mReportAnalysis->FSaMRPAGetAddTaxNo($tBchCode);
                $aCompAddress   = FCNxHADDGetAddress($tBchCode);
                $tAddressLine1  = $aCompAddress['tAddressLine1'];
                $tAddressLine2  = $aCompAddress['tAddressLine2'];
            }else{
                $tCompName      = "-";
                $tBchCode       = "-";
                $tBchName       = "-";
                $tBchTaxNo      = "-";
                $tAddressLine1  = "-";
                $tAddressLine2  = "-";
            }

            /** รับค่าจาก View Input */
            $nStaOverLimit      = $this->input->get('nStaOverLimit');
            $tDataSendConsRpt   = $this->input->get('tdatacons');
            $nPage              = empty($this->input->get('nPage')) ? 1 : $this->input->get('nPage');
            /** Decode Base64 To String */
            $tDecodeBase64      = base64_decode($tDataSendConsRpt);
            /** Decode URL */
            $tDecoedUTF8        = urldecode($tDecodeBase64);
            /** Decode Json */
            $aDataFilter        = json_decode($tDecoedUTF8,true);

            $aFilterReport = array(
                // สาขา
                'tBchCodeFrom'  => $aDataFilter['tBchCodeFrom'],
                'tBchNameFrom'  => $aDataFilter['tBchNameFrom'],
                'tBchCodeTo'    => $aDataFilter['tBchCodeTo'],
                'tBchNameTo'    => $aDataFilter['tBchNameTo'],
                // รหัสบัตร
                'tCrdCodeFrom'  => $aDataFilter['tCrdCodeFrom'],
                'tCrdNameFrom'  => $aDataFilter['tCrdNameFrom'],
                'tCrdCodeTo'    => $aDataFilter['tCrdCodeTo'],
                'tCrdNameTo'    => $aDataFilter['tCrdNameTo'],
                //วันที่
                'tDateFrom'     => $aDataFilter['tDateFrom'],
                'tDateTo'       => $aDataFilter['tDateTo'],
                //ภาษา
                'tCompName'         => $this->tComName,
                'tRptName'         => $this->tRptName,
                'FNLngID'           => FCNaHGetLangEdit(),
                'nRow'              => 100,
                'nPage'             => $nPage
            );
            
            /** array ข้อมูลภาษาที่เกี่ยวข้องกับรายงาน */
            $aDataTextRef = array(
                'tTitleReport'          => language('reportanalysis/reportanalysis','tRPATitleRptCardActiveDetail'),
                'tRPATaxNo'             => language('reportanalysis/reportanalysis','tRPATaxNo'),
                'tRPADatePrint'         => language('reportanalysis/reportanalysis','tRPADatePrint'),
                'tRPATimePrint'         => language('reportanalysis/reportanalysis','tRPATimePrint'),
                'tRPAPrintHtml'         => language('reportanalysis/reportanalysis','tRPAPrintHtml'),
                /** Filter */
                'tRPABchFrom'           => language('reportanalysis/reportanalysis','tRPABchFrom'),
                'tRPABchTo'             => language('reportanalysis/reportanalysis','tRPABchTo'),
                'tRPACardCodeFrom'      => language('reportanalysis/reportanalysis','tRPACardCodeFrom'),
                'tRPACardCodeTo'        => language('reportanalysis/reportanalysis','tRPACardCodeTo'),
                'tRPADateFrom'          => language('reportanalysis/reportanalysis','tRPADateFrom'),
                'tRPADateTo'            => language('reportanalysis/reportanalysis','tRPADateTo'),
                /** Table Report */
                'tRPA4TBBarchCode'      => language('reportanalysis/reportanalysis','tRPA4TBBarchCode'),
                'tRPA4TBBarchName'      => language('reportanalysis/reportanalysis','tRPA4TBBarchName'),
                'tRPA4TBCardCode'       => language('reportanalysis/reportanalysis','tRPA4TBCardCode'),
                'tRPA4TBCardName'       => language('reportanalysis/reportanalysis','tRPA4TBCardName'),
                'tRPA4TBDocDate'        => language('reportanalysis/reportanalysis','tRPA4TBDocDate'),
                'tRPA4TBDocTime'        => language('reportanalysis/reportanalysis','tRPA4TBDocTime'),
                'tRPA4TBDocType'        => language('reportanalysis/reportanalysis','tRPA4TBDocType'),
                'tRPA4TBCrdHoderID'     => language('reportanalysis/reportanalysis','tRPA4TBCrdHoderID'),
                'tRPA4TBPosCode'        => language('reportanalysis/reportanalysis','tRPA4TBPosCode'),
                'tRPA4TBTxtCrdValue'    => language('reportanalysis/reportanalysis','tRPA4TBTxtCrdValue'),
                'tRPA4TBTotalAll'       => language('reportanalysis/reportanalysis','tRPA4TBTotalAll')
            );

            $tCallView  = $aDataFilter['tCallViewType'];

            // Get data in temp
            if($tCallView == 'html'){
                @$aDataReport = $this->mReportAnalysis->FSaMRptCardActiveDetail($aFilterReport, '');
                
                if(@$aDataReport['rnCurrentPage'] == @$aDataReport['rnAllPage']){ // เรียก Summary เฉพาะหน้าสุดท้าย
                    @$aSumDataReport = $this->mReportAnalysis->FSaMRptCardActiveDetailSum($aFilterReport);
                }
            }
            if($tCallView == 'pdf'){
                $aFilterReport['nRow'] = 20000;
                @$aDataReport = $this->mReportAnalysis->FSaMRptCardActiveDetail($aFilterReport, 20000);
            }

            /** Ref File Kool Report */
            require_once APPPATH.'reportanalysis\rptCardActiveDetail\rRptCardActiveDetail.php';

            /** Set Parameter To Report */
            $oRptCardActiveDetail  =   new rRptCardActiveDetail(array(
                'tBaseUrl'       => base_url(),
                'tCallView'      => $tCallView,
                'tCompName'      => $tCompName,
                'tBchName'       => $tBchName,
                'tBchTaxNo'      => $tBchTaxNo,
                'tAddressLine1'  => $tAddressLine1,
                'tAddressLine2'  => $tAddressLine2,
                'aFilterReport'  => $aFilterReport,
                'aDataTextRef'   => $aDataTextRef,
                'aDataReport'    => $aDataReport,
                'aSumDataReport' => isset($aSumDataReport) ? $aSumDataReport : []
            ));

            if($tCallView == 'html'){
                // Run View Before Print
                $oRptCardActiveDetail->run();
                $oRptCardActiveDetail->render('wRptCardActiveDetail');
            }elseif($tCallView == 'pdf'){
                set_time_limit(0);
                ini_set('memory_limit', '-1');

                /** Run Export PDF */
                $tFileExportName    = "ReportAnalysis4-".date('dmYhis');
                $oRptCardActiveDetail->run();
                $tViewRpt   = $oRptCardActiveDetail->render('wRptCardActiveDetail', true);
                // $tTagRemove = 'script';
                // $tHtmlRemoverTagDom = FCNtRemoveDomHtml($tViewRpt,$tTagRemove);

                $oPdf   = new Pdf(array(
                    'ignoreWarnings' => true,
                    'commandOptions' => array(
                        // Can help if generation fails without a useful error message
                        'useExec' => true,      
                        'procEnv' => array(
                            // Check the output of 'locale' on your system to find supported languages
                            'LANG' => 'en_US.utf-8',
                        )
                    )
                ));
                
                $oPdf->addPage($tViewRpt);

                $oPdf->setOptions(array(
                    'javascript-delay' => 3000,
                    'orientation'       => 'landscape',
                    'margin-top'        => 5,
                    'margin-right'      => 5,
                    'margin-bottom'     => 5,
                    'margin-left'       => 5,
                    'footer-right'      => 'Page [page] of [toPage]',
                    'footer-font-size'  => 6
                ));

                $oPdf->binary = APPPATH."libraries\phpwkhtmltopdf\wkhtmltox\bin\wkhtmltopdf.exe";
                $tSesUsername = $this->session->userdata('tSesUsername');

                if(!is_dir(APPPATH.'assets/exportpdf/'.$tSesUsername)){
                    mkdir(APPPATH.'assets/exportpdf/'.$tSesUsername);
                }

                $tPathExport = APPPATH.'assets/exportpdf/'.$tSesUsername.'/';

                $oFiles = glob($tPathExport.'*');

                foreach($oFiles as $tFile){
                    if(is_file($tFile))
                    unlink($tFile);
                }

                $tFilePath = $tPathExport . $tFileExportName . '.pdf';
                if($oPdf->saveAs($tFilePath)) {
                    $tFileUrl = base_url("application/assets/exportpdf/$tSesUsername/" . $tFileExportName . ".pdf");
                    $aResponse =  array(
                        'nStaExport'    => '1',
                        'tFileName'     => $tFileExportName,
                        'tFileUrl'      => $tFileUrl,
                        'tMessage'      => "Export File Successfully."
                    );
                }else{
                    $aResponse =  array(
                        'nStaExport'    => '800',
                        'tMessage'      => "Data Export Error: " . $pdf->getError()
                    );
                }
                echo json_encode($aResponse);
            }else{}
        }catch(Exception $Error){
            echo "Eror cRptCardActiveDetail Function(FSoCExportRptPDF) => ".$Error;
        }
    }
}









