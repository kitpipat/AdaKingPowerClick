<?php
/**
 * This file contains class to export data to Microsoft Excel
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 
  $report = new myReport();
  $report->run()
  ->exportToExcel(array(
    "dataStores" => array(
      'sales' => array(
        // 'rowDimension' => 'column',
        // 'columnDimension' => 'row',
        "measures"=>array(
          "dollar_sales - sum", 
          // 'dollar_sales - count',
        ),
        'rowSort' => array(
          // 'orderMonth' => function($a, $b) {
            // return (int)$a > (int)$b;
          // }, 
          // 'orderDay' => function($a, $b) {
            // return (int)$a > (int)$b;
          // },
          'dollar_sales - sum' => 'desc',
        ),
        'columnSort' => array(
          'orderMonth' => function($a, $b) {
            return (int)$a < (int)$b;
          },
          // 'dollar_sales - sum' => 'desc',
          // 'orderYear' => 'desc', 
        ),
        // 'headerMap' => array(
          // 'dollar_sales - sum' => 'Sales (in USD)',
          // 'dollar_sales - count' => 'Number of Sales',
        // ),
        'headerMap' => function($v, $f) {
          if ($v === 'dollar_sales - sum')
            $v = 'Sales (in USD)';
          if ($v === 'dollar_sales - count')
            $v = 'Number of Sales';
          if ($f === 'orderYear')
            $v = 'Year ' . $v;
          return $v;
        },
        // 'dataMap' => function($v, $f) {return $v;},
      )
    ),
  ))
  ->toBrowser("myReport.xlsx");
 */

namespace koolreport\pivot;
// use \koolreport\pivot\widgets\PivotTable;
use \koolreport\core\Utility;

class PivotExcelExport {
  
  public function saveDataStoreToSheet($dataStore, $sheet, $option) {
    $totalName = Utility::get($option, 'totalName', 'Total');
    $emptyValue = Utility::get($option, 'emptyValue', '-');
    $headerMap = Utility::get($option, 'headerMap', array());
    $dataMap = Utility::get($option, 'dataMap', array());
    $meta = $dataStore->meta()['columns'];
    
    $pivotUtil = new PivotUtil($dataStore, $option);
    $fni = $pivotUtil->getFieldsNodesIndexes();
    $rowNodes = $fni['rowNodes'];
    $rowNodesMark = $fni['rowNodesMark'];
    $rowIndexes = $fni['rowIndexes'];
    $rowFields = $fni['rowFields'];
    $colNodes = $fni['colNodes'];
    $colNodesMark = $fni['colNodesMark'];
    $colIndexes = $fni['colIndexes'];
    $colFields = $fni['colFields'];
    $dataNodes = $fni['dataNodes'];
    $dataFields = $fni['dataFields'];
    $indexToData = $fni['indexToData'];
    
    $cell = \PHPExcel_Cell::stringFromColumnIndex(0) . 1;
    $endCell = \PHPExcel_Cell::stringFromColumnIndex(
      count($rowFields) - 1) . count($colFields);
    $sheet->setCellValue($cell, implode(' | ', $dataNodes));
    $sheet->mergeCells($cell . ":" . $endCell);
    $sheet->getStyle($cell)->getAlignment()->setHorizontal(
      \PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle($cell)->getAlignment()->setVertical(
      \PHPExcel_Style_Alignment::VERTICAL_TOP);
    
    foreach ($colFields as $i => $f) {
      foreach ($colIndexes as $c => $j) {
        $node = $colNodes[$j];
        $nodeMark = $colNodesMark[$j];
        if (isset($nodeMark[$f . '_colspan'])) {
          $rowspan = $nodeMark[$f . '_rowspan'] - 1; 
          $colspan = $nodeMark[$f . '_colspan'] - 1;
          $cell = \PHPExcel_Cell::stringFromColumnIndex(
            count($rowFields) + $c * count($dataFields))
            . ($i + 1);
          $endCell = \PHPExcel_Cell::stringFromColumnIndex(
            count($rowFields) + $c * count($dataFields) + $colspan) 
            . ($i + 1 + $rowspan);
          $sheet->mergeCells($cell . ":" . $endCell);
          $sheet->getCell($cell)->setValue($node[$f]);
          $sheet->getStyle($cell)->getAlignment()->setHorizontal(
            \PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
          $sheet->getStyle($cell)->getAlignment()->setVertical(
            \PHPExcel_Style_Alignment::VERTICAL_TOP);
        }
      }
    }
    
    $maxLength = array_fill(0, count($rowFields), 0);
    foreach($rowIndexes as $r => $i) {
      $node = $rowNodes[$i];
      $nodeMark = $rowNodesMark[$i];
      foreach ($rowFields as $j => $rf) {
        if (isset($nodeMark[$rf . '_rowspan'])) {
          $rowspan = $nodeMark[$rf . '_rowspan'] - 1; 
          $colspan = $nodeMark[$rf . '_colspan'] - 1;
          $cell = \PHPExcel_Cell::stringFromColumnIndex(
            $j)
            . (count($colFields) + $r + 1);
          $endCell = \PHPExcel_Cell::stringFromColumnIndex(
            $j + $colspan) 
            . (count($colFields) + $r + 1 + $rowspan);
          $sheet->mergeCells($cell . ":" . $endCell);
          $text = $node[$rf];
          $sheet->getCell($cell)->setValue($text);
          $sheet->getStyle($cell)->getAlignment()->setVertical(
            \PHPExcel_Style_Alignment::VERTICAL_CENTER);
          if ($maxLength[$j] < strlen($text)) 
            $maxLength[$j] = strlen($text);
        }
      }
      
      
      foreach ($colIndexes as $c => $j) {
        $dataRow = isset($indexToData[$i][$j]) ? 
            $indexToData[$i][$j] : array();
        foreach($dataFields as $k => $df) {
          $cell = \PHPExcel_Cell::stringFromColumnIndex(
            count($rowFields) + $c * count($dataFields) + $k)
            . (count($colFields) + $r + 1);
          $sheet->getCell($cell)->setValue(isset($dataRow[$df]) ? 
              $dataRow[$df] : $emptyValue);
          $sheet->getStyle($cell)->getAlignment()->setHorizontal(
            \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        }
      }
		}
    for ($i = 0; $i < sizeof($maxLength); $i++) 
      $sheet->getColumnDimensionByColumn($i)->setWidth($maxLength[$i]);
  }
  
}
