<?php

/*  Function : Delete Data All DocTemp
    create : 05-03-2019 Krit(Copter)
*/
include APPPATH . 'libraries/spout-3.1.0/src/Spout/Autoloader/autoload.php';
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Common\Entity\Style\CellAlignment;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

// Functionality: ส่งออกแบบคิวรี่
// Parameters: array
// Creator: 22/06/2021 Nattakit (Nale) 
// Return: ข้อมูลสินค้าแบบ Array
// ReturnType: Object Array
function FCNxEXCExportByQuery($paParam){
    $ci = &get_instance();
    $ci->load->database();

    $tFileName          = $paParam['tFileName'];
    $tSheetName         = $paParam['tSheetName'];
    $aHeader            = $paParam['aHeader'];
    $tQuery             = $paParam['tQuery'];
    $tFileName          = $tFileName.'.xlsx';
    $aResult            = FCNaEXCQueryResult($tQuery);
    $oWriter            = WriterEntityFactory::createXLSXWriter();

    $oWriter->openToBrowser($tFileName); 

    $oBorder = (new BorderBuilder())
        ->setBorderTop(Color::BLACK, Border::WIDTH_THIN)
        ->setBorderBottom(Color::BLACK, Border::WIDTH_THIN)
        ->setBorderLeft(Color::BLACK, Border::WIDTH_THIN)
        ->setBorderRight(Color::BLACK, Border::WIDTH_THIN)
        ->build();

    $oBorderTop = (new BorderBuilder())
        ->setBorderTop(Color::BLACK, Border::WIDTH_THIN)
        ->build();

    $oStyleColums = (new StyleBuilder())
        ->setBorder($oBorder)
        ->setFontBold()
        ->build();

    $oStyleFonts = (new StyleBuilder())
        ->setFontBold()
        ->build();

    $oStyleFontsWrap = (new StyleBuilder())
        ->build();

    $oStyleBorderTop = (new StyleBuilder())
        ->setBorder($oBorderTop)
        ->build();

    if(!empty($aResult)){

        //nOptionExcel : 1 เอาข้อมูลดิบ ไม่โชว์ title 
        //nOptionExcel : 2 ตกแต่งข้อมูล โชว์ title และ วันที่พิมพ์เอกสาร
        if($paParam['nOptionExcel'] == 2){ //โชว์ให้เหมือนรายงาน
            //ชื่อของ sheet 
            $tTitleSheet  = $paParam['tTitleSheet'];
            $nCountCenter = (floor(count($aHeader) / 2) - 1);
            $aTitleCell   = array();
            for($i=0; $i<$nCountCenter; $i++){
                $aTitleCell[] = '';
                if($i == ($nCountCenter - 1)){
                    $aTitleCell[] = $tTitleSheet;
                }
            }
            $aMultiRows[] = WriterEntityFactory::createRowFromArray($aTitleCell,$oStyleFonts);

            //วันที่พิมพ์เอกสาร
            $tTitlePrint  = $paParam['tTitlePrint'];
            $nCountCenter = count($aHeader) - 1;
            $aPrintCell   = array();
            for($i=0; $i<$nCountCenter; $i++){
                $aPrintCell[] = '';
                if($i == ($nCountCenter - 1)){
                    $aPrintCell[] = $tTitlePrint;
                }
            }
            $aMultiRows[] = WriterEntityFactory::createRowFromArray($aPrintCell,$oStyleFonts);
        }

        //หัวตาราง
        if(!empty($aHeader)){
            $aHeaderName = $aHeader;
        }else{
            $aHeaderName = FCNaEXCCreateHeader($aResult[0]);
        }
        $aMultiRows[] = WriterEntityFactory::createRowFromArray($aHeaderName, $oStyleColums);

        if($paParam['nOptionExcel'] == 2){ //โชว์ให้เหมือนรายงาน
            $aCoulmn    = $paParam['aCoulmn'];
            foreach($aResult as $nKey => $aValue){
                switch ($paParam['tName']){
                    case 'BlueCard';
                        //สถานะปิดรอบ	
                        if($aValue[$aCoulmn[9]] == 1){
                            $aValue[$aCoulmn[9]] = language('sale/salemonitor/salemonitor', 'tBCMBatStaClosed1'); 
                        }else{
                            $aValue[$aCoulmn[9]] = language('sale/salemonitor/salemonitor', 'tBCMBatStaClosed2'); 
                        }

                        //สถานะซ่อมข้อมูล	
                        if($aValue[$aCoulmn[10]] == 1 || $aValue[$aCoulmn[10]] == '' || $aValue[$aCoulmn[10]] == null){
                            $aValue[$aCoulmn[11]] = '-';
                        }else{
                            if($aValue[$aCoulmn[11]] == 1){ 
                                $aValue[$aCoulmn[11]] = language('sale/salemonitor/salemonitor', 'tBCMBatStaInsBat1'); 
                            }else{ 
                                $aValue[$aCoulmn[11]] = language('sale/salemonitor/salemonitor', 'tBCMBatStaInsBat2'); 
                            } 
                        }

                        //สถานะตรวจสอบ	
                        if(!empty($aValue[$aCoulmn[10]])){
                            if($aValue[$aCoulmn[10]] == 1){
                                $aValue[$aCoulmn[10]] = language('sale/salemonitor/salemonitor', 'tBCMBatStaVerify1'); 
                            }else{
                                $aValue[$aCoulmn[10]] = language('sale/salemonitor/salemonitor', 'tBCMBatStaVerify2'); 
                            }
                        }else{
                            $aValue[$aCoulmn[10]] = language('sale/salemonitor/salemonitor', 'tBCMBatStaVerify3'); 
                        }
                    break;
                    case 'StandCard';

                        //ประเภท		
                        if(!empty($aValue[$aCoulmn[5]])){
                            if($aValue[$aCoulmn[5]] == 1){
                                $aValue[$aCoulmn[5]] = language('sale/salemonitor/salemonitor', 'tBCMBatTabStdType1'); 
                            }else if($aValue[$aCoulmn[5]] == 4){
                                $aValue[$aCoulmn[5]] = language('sale/salemonitor/salemonitor', 'tBCMBatTabStdType4'); 
                            }else{
                                $aValue[$aCoulmn[5]] = language('sale/salemonitor/salemonitor', 'tBCMBatTabStdType2'); 
                            }
                        }else{
                            $aValue[$aCoulmn[5]] = '-'; 
                        }

                        //โหมด	
                        if(!empty($aValue[$aCoulmn[6]])){
                            if($aValue[$aCoulmn[6]] == 1){
                                $aValue[$aCoulmn[6]] = language('sale/salemonitor/salemonitor', 'tBCMBatTabStdMode1'); 
                            }else{
                                $aValue[$aCoulmn[6]] = language('sale/salemonitor/salemonitor', 'tBCMBatTabStdMode2'); 
                            }
                        }else{
                            $aValue[$aCoulmn[6]] = '-'; 
                        }

                        //สถานะส่งยอด		
                        if(!empty($aValue[$aCoulmn[7]])){
                            if($aValue[$aCoulmn[7]] == 1){
                                $aValue[$aCoulmn[7]] = language('sale/salemonitor/salemonitor', 'tBCMBatTabStdUpd1'); 
                            }else{
                                $aValue[$aCoulmn[7]] = language('sale/salemonitor/salemonitor', 'tBCMBatTabStdUpd2'); 
                            }
                        }else{
                            $aValue[$aCoulmn[7]] = '-'; 
                        }

                        //หมายเหตุ		
                        if(!empty($aValue[$aCoulmn[8]])){
                            $aValue[$aCoulmn[8]] = $aValue[$aCoulmn[8]]; 
                        }else{
                            $aValue[$aCoulmn[8]] = '-'; 
                        }
                    break;
                }   

                $values = [
                    WriterEntityFactory::createCell(@$aValue[@$aCoulmn[0]]),
                    WriterEntityFactory::createCell(@$aValue[@$aCoulmn[1]]),
                    WriterEntityFactory::createCell(@$aValue[@$aCoulmn[2]]),
                    WriterEntityFactory::createCell(@$aValue[@$aCoulmn[3]]),
                    WriterEntityFactory::createCell(@$aValue[@$aCoulmn[4]]),
                    WriterEntityFactory::createCell(@$aValue[@$aCoulmn[5]]),
                    WriterEntityFactory::createCell(@$aValue[@$aCoulmn[6]]),
                    WriterEntityFactory::createCell(@$aValue[@$aCoulmn[7]]),
                    WriterEntityFactory::createCell(@$aValue[@$aCoulmn[8]]),
                    WriterEntityFactory::createCell(@$aValue[@$aCoulmn[9]]),
                    WriterEntityFactory::createCell(@$aValue[@$aCoulmn[10]]),
                    WriterEntityFactory::createCell(@$aValue[@$aCoulmn[11]])
                ];
                $aMultiRows[]  = WriterEntityFactory::createRow($values,$oStyleFontsWrap);
            }
        }else{ //เอาข้อมูลดิบ
            foreach($aResult as $nKey => $aRows){
                $aMultiRows[] = WriterEntityFactory::createRowFromArray($aRows);
            }
        }

    }

    //ขีดเส้นใต้ที่ตารางข้อมูล
    $nCountColumn  = count($aHeader);
    $aNullTable   = array();
    for($i=0; $i<$nCountColumn; $i++){
        $aNullTable[] = ' ';
    }
    $aMultiRows[] = WriterEntityFactory::createRowFromArray($aNullTable,$oStyleBorderTop);

    $oWriter->addRows($aMultiRows);
    if(!empty($tSheetName)){
        $sheet = $oWriter->getCurrentSheet();
        $sheet->setName($tSheetName);
    }
    $oWriter->close();
}


// Functionality: ส่งออกแบบอาเรย์
// Parameters: array
// Creator: 22/06/2021 Nattakit (Nale) 
// Return: ข้อมูลสินค้าแบบ Array
// ReturnType: Object Array
function FCNaEXCQueryResult($ptQuery){
    $ci = &get_instance();
    $ci->load->database();

    if($ptQuery){
        $oQuery = $ci->db->query($ptQuery);
        $aResult = $oQuery->result_array();
    }else{
        $aResult = array();
    }
    return $aResult;
}

// Functionality: ส่งออกแบบอาเรย์
// Parameters: array
// Creator: 22/06/2021 Nattakit (Nale) 
// Return: ข้อมูลสินค้าแบบ Array
// ReturnType: Object Array
function FCNaEXCCreateHeader($paRows){
    $aCellsHeader = array();
    if(!empty($paRows)){
        foreach($paRows as $tKey => $aCells){
            $aCellsHeader[] = $tKey;
        }
    }
    return $aCellsHeader;
}

