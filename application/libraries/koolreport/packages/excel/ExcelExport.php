<?php
/**
 * This file contains class to export data to Microsoft Excel
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 
 */

namespace koolreport\excel;
use \koolreport\core\Utility;

class ExcelExport {

    public function saveDataStoreToSheet($dataStore, $sheet) {
        $dataStore->popStart();
        $row = $dataStore->pop();
        $columns = array_keys($row);
        $maxlength = array();
        $meta = $dataStore->meta();
        foreach ($columns as $i => $column) {
            $cell = \PHPExcel_Cell::stringFromColumnIndex($i) . 1;
            $label = Utility::get($meta["columns"][$column],"label",$column);
            $sheet->setCellValue($cell, $label);
            $sheet->getStyle($cell)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle($cell)->getFont()->setBold(true);
            $maxlength[$i] = strlen($column);
        }
        
        $rows = $dataStore->data();
        foreach ($rows as $j => $row) {
            foreach ($columns as $i => $column) {
                $text = Utility::format($row[$column],$meta["columns"][$column]);
                $cell = \PHPExcel_Cell::stringFromColumnIndex($i) . ($j + 2);
                $sheet->setCellValue($cell, $text);
                $sheet->getStyle($cell)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                if ($maxlength[$i] < strlen($text)) {
                    $maxlength[$i] = strlen($text);
                }
            }
        }
        
        for ($i = 0; $i < sizeof($maxlength); $i++) 
        $sheet->getColumnDimensionByColumn($i)->setWidth($maxlength[$i] + 2);
    }
  
}
