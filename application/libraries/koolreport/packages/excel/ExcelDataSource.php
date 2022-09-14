<?php
/**
 * This file contains class to pull data from Microsoft Excel
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 */

/*
 * The ExcelDataSource will load the Excel data, breaking down to columns and try to determine
 * the type for the columns, the precision contain number of rows to run to determine
 * the meta data for columns.
 * 
 * $firstRowData: is the first row data, usually is false, first row is column name
 * if the firstRowData is true, name column as column 1, column 2
 * 
 */
namespace koolreport\excel;
use \koolreport\core\DataSource;
use \koolreport\core\Utility;

class ExcelDataSource extends DataSource
{
	protected $filePath;
	protected $charset;
	protected $firstRowData;
	protected $sheetName;
	protected $sheetIndex;
	
	protected function onInit()
	{
		$this->filePath = Utility::get($this->params,"filePath");
		$this->charset = Utility::get($this->params,"charset","utf8");
		$this->firstRowData = Utility::get($this->params,"firstRowData",false);
		$this->sheetName = Utility::get($this->params,"sheetName",null);
		$this->sheetIndex = Utility::get($this->params,"sheetIndex",null);
	}
  
  protected function guessType($value)
	{
		$map = array(
			"float"=>"number",
			"double"=>"number",
			"int"=>"number",
			"integer"=>"number",
			"bool"=>"number",
			"numeric"=>"number",
			"string"=>"string",
		);

		$type = strtolower(gettype($value));
		foreach($map as $key=>$value)
		{
			if(strpos($type,$key)!==false)
			{
				return $value;
			}			
		}
		return "unknown";
	}
	
	public function start()
	{
    $excelReader = \PHPExcel_IOFactory::createReaderForFile($this->filePath);
    if (isset($this->sheetName))
      $excelReader->setLoadSheetsOnly($this->sheetName);
    else if (isset($this->sheetIndex)) {
      $sheetNames = $excelReader->listWorksheetNames($this->filePath);
      $excelReader->setLoadSheetsOnly($sheetNames[$this->sheetIndex]);
    }
    $excelObj = $excelReader->load($this->filePath);
    
    $sheet = $excelObj->getSheet(0);
    $highestRow = $sheet->getHighestRow(); 
    $highestColumn = $sheet->getHighestColumn();
    
    $firstRow = $sheet->rangeToArray(
        'A1:' . $highestColumn . '1',
        NULL,TRUE,FALSE
    )[0];
    $colNum = 0;
    foreach ($firstRow as $col => $text)
      if (empty($text)) {
        $colNum = $col;
        break;
      }
    $colNum = \PHPExcel_Cell::stringFromColumnIndex($colNum - 1);
    $rowNum = $highestRow;
    
    $i = 1;
    $row = $sheet->rangeToArray(
      "A1:" . $colNum . "1", NULL,TRUE,FALSE
    )[0];
    if (is_array($row)) {
      if (! $this->firstRowData) {
        $columnNames = $row;
        $row = $sheet->rangeToArray(
          "A2:" . $colNum . "2", NULL,TRUE,FALSE
        )[0];
      }
      else {
        $columnNames = array();
        for ($i=0; $i<count($row); $i++)
          array_push($columnNames, 'Column ' . $i);
      }
      
      $metaData = array("columns"=>array());
      for($i=0;$i<count($columnNames);$i++) {						
        $metaData["columns"][$columnNames[$i]] = array(
          "type"=>(isset($row)) ? $this->guessType($row[$i]) : "unknown");
      }
      $this->sendMeta($metaData,$this);
      $this->startInput(null);
      
      if ($this->firstRowData)
        $this->next(array_combine($columnNames, $row), $this);
    }
    
    for($i=2; $i<$rowNum+1; $i++) {
      $row = $sheet->rangeToArray(
        "A$i:" . $colNum . $i, NULL,TRUE,FALSE
      )[0];
      $this->next(array_combine($columnNames, $row), $this);	
    }
    $this->endInput(null);
	}
}
