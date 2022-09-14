<?php
defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH.'third_party/PHPExcel/Classes/PHPExcel.php';
include APPPATH.'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';
include APPPATH.'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

require APPPATH.'libraries/phpwkhtmltopdf/vendor/autoload.php';
use mikehaertl\wkhtmlto\Pdf;

class cRptUnExchangeBalance extends CI_Controller {

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
        $this->tRptName = 'UnExchangeBalance';
    }

    //Functionality: ฟังก์ชั่น Export Excel
    //Parameters:  Function Parameter
    //Creator: 19/12/2018 Wasin(Yoshi)
    //Return: object Status Export Excel
    //ReturnType: Object
    public function FSoCExportExcel(){
        
        $aDataInputReport   = $this->input->post('oInputCondition');
        $aFilterReport      = array(
            // รหัสบัตร
            'tCrdCodeFrom'      => $aDataInputReport['tCrdCodeFrom'],
            'tCrdNameFrom'      => $aDataInputReport['tCrdNameFrom'],
            'tCrdCodeTo'        => $aDataInputReport['tCrdCodeTo'],
            'tCrdNameTo'        => $aDataInputReport['tCrdNameTo'],
            //วันที่หมดอายุ
            'tDateExpiredFrom'  => $aDataInputReport['tDateExpiredFrom'],
            'tDateExpiredTo'    => $aDataInputReport['tDateExpiredTo'],
            
            'tCompName'         => $this->tComName,
            'tRptName'         => $this->tRptName,
            'FNLngID'           => FCNaHGetLangEdit(),
            'nRow'              => 100000, // Limit 100000
            'nPage'             => 1
        );
        
        // Get data in temp
        $aDataReport = $this->mReportAnalysis->FSaMRptUnExchangeBalance($aFilterReport, $aFilterReport['nRow']);

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

                $tTitleReport   = language('reportanalysis/reportanalysis','tRPATitleRptUnExchangeBalance');
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
                $objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(70);

                /** Set Font */
                $objPHPExcel->getActiveSheet()->getStyle('A1:Z1000')->applyFromArray($StyleFont);

                /** จัดความกว้างของคอลัมน์ */
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);

                /** ชื่อ Conpany */
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $tCompName."(".$tBchName.")")->getStyle('A1')->applyFromArray($StyleCompFont);

                /** ที่อยู่ Company */
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2',trim($tAddressComp))->getStyle('A2')->applyFromArray($StyleAddressFont);

                /** ชื่อหัวรายงาน */
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C1:F1');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', $tTitleReport);
                $objPHPExcel->getActiveSheet()->getStyle("C1")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($aStyleRptName);

                /** กำหนกหัวตาราง */
                $nStartRowHeadder   = 5;
                $nStartRowFillter   = 3;

                $tFillterColumLEFT  = "D";
                $tFillterColumRIGHT = "E";

                /** Fillter Card Code */
                if(!empty($paFilterReport['tCrdCodeFrom']) && !empty($paFilterReport['tCrdCodeTo'])){
                    /** Left Filter */
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT.$nStartRowFillter, language('reportanalysis/reportanalysis','tRPACardCodeFrom').' : '.$paFilterReport['tCrdNameFrom']);
                    $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT.$nStartRowFillter)
                    ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    
                    /** Right Filter */
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumRIGHT.$nStartRowFillter, language('reportanalysis/reportanalysis','tRPACardCodeTo').' : '.$paFilterReport['tCrdNameTo']);
                    $objPHPExcel->getActiveSheet()->getStyle($tFillterColumRIGHT.$nStartRowFillter)
                    ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    
                    if($nStartRowFillter>3){
                        $nStartRowHeadder += 1;
                    }
                    $nStartRowFillter += 1;
                }

                /** Fillter Date Expired Code */
                if(!empty($paFilterReport['tDateExpiredFrom']) && !empty($paFilterReport['tDateExpiredTo'])){
                    /** Left Filter */
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT.$nStartRowFillter, language('reportanalysis/reportanalysis','tRPACardCodeFrom').' : '.$paFilterReport['tCrdNameFrom']);
                    $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT.$nStartRowFillter)
                    ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    
                    /** Right Filter */
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumRIGHT.$nStartRowFillter, language('reportanalysis/reportanalysis','tRPACardCodeTo').' : '.$paFilterReport['tCrdNameTo']);
                    $objPHPExcel->getActiveSheet()->getStyle($tFillterColumRIGHT.$nStartRowFillter)
                    ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    
                    if($nStartRowFillter>3){
                        $nStartRowHeadder += 1;
                    }
                    $nStartRowFillter += 1;
                }

                /** รายละเอียดการออกรายงาน */
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.($nStartRowHeadder-1).':H'.($nStartRowHeadder-1));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($nStartRowHeadder-1),$tTextDetail);
                $objPHPExcel->getActiveSheet()->getStyle('A'.($nStartRowHeadder-1))->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $objPHPExcel->getActiveSheet()->getStyle('A'.$nStartRowHeadder.':H'.$nStartRowHeadder)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('306384');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$nStartRowHeadder.':H'.$nStartRowHeadder)->applyFromArray($aStyleHeadder);

                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$nStartRowHeadder, language('reportanalysis/reportanalysis','tRPA5TBCrdCode'))
                ->setCellValue('B'.$nStartRowHeadder, language('reportanalysis/reportanalysis','tRPA5TBCrdName'))
                ->setCellValue('C'.$nStartRowHeadder, language('reportanalysis/reportanalysis','tRPA5TBCrdTypeName'))
                ->setCellValue('D'.$nStartRowHeadder, language('reportanalysis/reportanalysis','tRPA5TBCrdExpireDate'))
                ->setCellValue('E'.$nStartRowHeadder, language('reportanalysis/reportanalysis','tRPA5TBCrdExpireDateQty'))
                ->setCellValue('F'.$nStartRowHeadder, language('reportanalysis/reportanalysis','tRPA5TBCrdExpiredValue'))
                ->setCellValue('F'.$nStartRowHeadder, language('reportanalysis/reportanalysis','tRPA5TBCrdReturnValue'))
                ->setCellValue('G'.$nStartRowHeadder, language('reportanalysis/reportanalysis','tRPA5TBCrdTotal'))
                ->setCellValue('H'.$nStartRowHeadder, language('reportanalysis/reportanalysis','tRPA5TBCrdTotalAll'));

                //ตัวอักษร Head Center
                $objPHPExcel->getActiveSheet()->getStyle("A".$nStartRowHeadder.":H".$nStartRowHeadder)
                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                /** ลูบข้อมูล */
                $nStartRowData      = $nStartRowHeadder+1;
                $nNum               = 0;
                $nLastRowNuber      = 0;
                
                // Summary
                $nSumCrdExpireDateQty = 0;
                $cSumCrdExpiredValue = 0.00;
                $cSumCrdReturnValue = 0.00;
                $cSumTotal = 0.00;
                
                foreach($paDataReport AS $nKey => $aValue){
                    $nNum++;

                    // Summary
                    $nSumCrdExpireDateQty += intval($aValue['rtCrdExpireDateQty']);
                    $cSumCrdExpiredValue += floatval($aValue['rcCrdExpiredValue']);
                    $cSumCrdReturnValue += floatval($aValue['rcCrdReturnValue']);
                    $cSumTotal += floatval($aValue['rcCrdExpiredValue'] - $aValue['rcCrdReturnValue']);
                
                    /** เซ็ทข้อมูลในตาราง */
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$nStartRowData, '  '.$aValue['rtCrdCode'])
                    ->setCellValue('B'.$nStartRowData, '  '.$aValue['rtCrdName'])
                    ->setCellValue('C'.$nStartRowData, '  '.$aValue['rtCtyName'])
                    ->setCellValue('D'.$nStartRowData, '  '.$aValue['rtCrdExpireDate'])
                    ->setCellValue('E'.$nStartRowData, '  '.$aValue['rtCrdExpireDateQty'])
                    ->setCellValue('F'.$nStartRowData, '  '.number_format(floatval($aValue['rcCrdExpiredValue']),2))
                    ->setCellValue('G'.$nStartRowData, '  '.number_format(floatval($aValue['rcCrdReturnValue']),2))
                    ->setCellValue('H'.$nStartRowData, '  '.number_format(floatval($aValue['rcCrdExpiredValue'] - $aValue['rcCrdReturnValue']),2));

                    /** จัดตัวอักษรข้อมูลกลาง */
                    $objPHPExcel->getActiveSheet()->getStyle("A".$nStartRowData.":E".$nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    /** จัดตัวอักษรชิดขวา */
                    $objPHPExcel->getActiveSheet()->getStyle("F".$nStartRowData.":H".$nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    
                    $nLastRowNuber  =   $nStartRowData;
                    $nStartRowData++;
                }
                
                // Set Last Row Total Amount
                $nRowLastNum = $nLastRowNuber+1;
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('D'.$nRowLastNum, '  '.language('reportcard/reportcard','tRPCTBFooterSumAll'))
                /*->setCellValue('B'.$nRowLastNum, '  '.$nNum.'   '.language('reportcard/reportcard','tRPCTBFooterList'))
                ->setCellValue('C'.$nRowLastNum, '  '.'')
                ->setCellValue('D'.$nRowLastNum, '  '.'')*/
                ->setCellValue('E'.$nRowLastNum, '  '.$nSumCrdExpireDateQty)
                ->setCellValue('F'.$nRowLastNum, '  '.number_format($cSumCrdExpiredValue,2))
                ->setCellValue('G'.$nRowLastNum, '  '.number_format($cSumCrdReturnValue,2))
                ->setCellValue('H'.$nRowLastNum, '  '.number_format($cSumTotal,2));
                //ตัวอักษรตรงกลาง
                /*$objPHPExcel->getActiveSheet()->getStyle("E".$nRowLastNum.":E".$nRowLastNum)
                ->getAlignment()
                ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/
                //ตัวอักษรชิดขวา
                $objPHPExcel->getActiveSheet()->getStyle("D".$nRowLastNum.":H".$nRowLastNum)
                ->getAlignment()
                ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                //ใส่สี Last Row
                /*$objPHPExcel->getActiveSheet()->getStyle('A'.$nRowLastNum.':H'.$nRowLastNum)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB('306384');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$nRowLastNum.':H'.$nRowLastNum)->applyFromArray($aStyleHeadder);*/
                
                //Export File Excel
                $tFilename   = 'ReportAnalysis5-'.date("dmYhis").'.xlsx';
                
                header("Pragma: public");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Content-Type: application/force-download");
                header("Content-Type: application/octet-stream");
                header("Content-Type: application/download");;
                header("Content-Disposition: attachment;filename=$tFilename");
                header("Content-Transfer-Encoding: binary ");

                $objWriter      = new PHPExcel_Writer_Excel2007($objPHPExcel);

                $tSesUsername   = $this->session->userdata('tSesUsername');

                // Cheack Folder Session In Folder exportexcel
                if(!is_dir(APPPATH.'assets/exportexcel/'.$tSesUsername)){
                    mkdir(APPPATH.'assets/exportexcel/'.$tSesUsername);
                }

                $tPathExport    = APPPATH.'assets/exportexcel/'.$tSesUsername.'/';

                $oFiles         = glob($tPathExport.'*');
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
    //Creator: 17/12/2018 Wasin(Yoshi)
    //Return: object Status Check In DB
    //ReturnType: Object
    public function FSoChkDataExport($pIsReturnJson = true){
        try{
            $aDataInputReport   = $this->input->post('oInputCondition');
            $aFilterReport      = array(
                // รหัสบัตร
                'tCrdCodeFrom'      => $aDataInputReport['tCrdCodeFrom'],
                'tCrdNameFrom'      => $aDataInputReport['tCrdNameFrom'],
                'tCrdCodeTo'        => $aDataInputReport['tCrdCodeTo'],
                'tCrdNameTo'        => $aDataInputReport['tCrdNameTo'],
                //วันที่หมดอายุ
                'tDateExpiredFrom'  => $aDataInputReport['tDateExpiredFrom'],
                'tDateExpiredTo'    => $aDataInputReport['tDateExpiredTo'],
                'tCompName'         => $this->tComName,
                'tRptName'         => $this->tRptName,
                'FNLngID'           => FCNaHGetLangEdit()
            );

            if($this->mReportCardCallProcedure->FSnMExecStoreUnExchangeBalance($aFilterReport)) { // Call Store Procedure
                // Get count in temp
                $nCountDataReport = $this->mReportAnalysis->FSaMRptUnExchangeBalanceCount($aFilterReport);
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
            echo "Eror cRptUnExchangeBalance Function(FSoChkDataExport) => ".$Error;
        }
    }

    //Functionality: รับค่า เพื่อ Export PDF
    //Parameters:  Function Parameter
    //Creator: 17/12/2018 Wasin (Yoshi)
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

            $aFilterReport      = array(
                // รหัสบัตร
                'tCrdCodeFrom'      => $aDataFilter['tCrdCodeFrom'],
                'tCrdNameFrom'      => $aDataFilter['tCrdNameFrom'],
                'tCrdCodeTo'        => $aDataFilter['tCrdCodeTo'],
                'tCrdNameTo'        => $aDataFilter['tCrdNameTo'],
                //วันที่หมดอายุ
                'tDateExpiredFrom'  => $aDataFilter['tDateExpiredFrom'],
                'tDateExpiredTo'    => $aDataFilter['tDateExpiredTo'],
                
                'tCompName'         => $this->tComName,
                'tRptName'         => $this->tRptName,
                'FNLngID'           => FCNaHGetLangEdit(),
                'nRow'              => 100,
                'nPage'             => $nPage
            );

            /** array ข้อมูลภาษาที่เกี่ยวข้องกับรายงาน */
            $aDataTextRef = array(
                'tTitleReport'              => language('reportanalysis/reportanalysis','tRPATitleRptUnExchangeBalance'),
                'tRPATaxNo'                 => language('reportanalysis/reportanalysis','tRPATaxNo'),
                'tRPADatePrint'             => language('reportanalysis/reportanalysis','tRPADatePrint'),
                'tRPATimePrint'             => language('reportanalysis/reportanalysis','tRPATimePrint'),
                'tRPAPrintHtml'             => language('reportanalysis/reportanalysis','tRPAPrintHtml'),
                /** Filter */
                'tRPACardCodeFrom'          => language('reportanalysis/reportanalysis','tRPACardCodeFrom'),
                'tRPACardCodeTo'            => language('reportanalysis/reportanalysis','tRPACardCodeTo'),
                'tRPADateExpiredFrom'       => language('reportanalysis/reportanalysis','tRPADateExpiredFrom'),
                'tRPADateExpiredTo'         => language('reportanalysis/reportanalysis','tRPADateExpiredTo'),
                /** Table Report */
                'tRPA5TBCrdCode'            => language('reportanalysis/reportanalysis','tRPA5TBCrdCode'),
                'tRPA5TBCrdName'            => language('reportanalysis/reportanalysis','tRPA5TBCrdName'),
                'tRPA5TBCrdTypeName'        => language('reportanalysis/reportanalysis','tRPA5TBCrdTypeName'),
                'tRPA5TBCrdExpireDate'      => language('reportanalysis/reportanalysis','tRPA5TBCrdExpireDate'),
                'tRPA5TBCrdExpireDateQty'   => language('reportanalysis/reportanalysis','tRPA5TBCrdExpireDateQty'),
                'tRPA5TBCrdExpiredValue'    => language('reportanalysis/reportanalysis','tRPA5TBCrdExpiredValue'),
                'tRPA5TBCrdReturnValue'     => language('reportanalysis/reportanalysis','tRPA5TBCrdReturnValue'),
                'tRPA5TBCrdTotal'           => language('reportanalysis/reportanalysis','tRPA5TBCrdTotal'),
                'tRPA5TBCrdTotalAll'        => language('reportanalysis/reportanalysis','tRPA5TBCrdTotalAll'),
            );

            $tCallView  = $aDataFilter['tCallViewType'];

            // Get data in temp
            if($tCallView == 'html'){
                @$aDataReport = $this->mReportAnalysis->FSaMRptUnExchangeBalance($aFilterReport, '');
                
                if(@$aDataReport['rnCurrentPage'] == @$aDataReport['rnAllPage']){ // เรียก Summary เฉพาะหน้าสุดท้าย
                    @$aSumDataReport = $this->mReportAnalysis->FSaMRptUnExchangeBalanceSum($aFilterReport);
                }
            }
            if($tCallView == 'pdf'){
                $aFilterReport['nRow'] = 20000;
                @$aDataReport = $this->mReportAnalysis->FSaMRptUnExchangeBalance($aFilterReport, 20000);
            }

            /** Ref File Kool Report */
            require_once APPPATH.'reportanalysis\rptUnExchangeBalance\rRptUnExchangeBalance.php';

             /** Set Parameter To Report */
             $oRptUnExchangeBalance  =   new rRptUnExchangeBalance(array(
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
                /** Run View Before Print */
                $oRptUnExchangeBalance->run();
                $oRptUnExchangeBalance->render('wRptUnExchangeBalance');
            }elseif($tCallView == 'pdf'){
                set_time_limit(0);
                ini_set('memory_limit', '-1');
                /** Run Export PDF */
                $tFileExportName    = "ReportAnalysis5-".date('dmYhis');
                $oRptUnExchangeBalance->run();
                $tViewRpt   = $oRptUnExchangeBalance->render('wRptUnExchangeBalance', true);

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
            echo "Eror cRptUnExchangeBalance Function(FSoCExportRptPDF) => ".$Error;
        }
    }

}



