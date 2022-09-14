<?php
/**
 * This file contains process to turn data into cross-tab table
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#regular-license
 * @license https://www.koolreport.com/license#extended-license
 */

/* Usage
 * ->pipe(new Pivot(array(
 * 		"dimensions"=>array(
 *		  "row"=>"customerName, productLine",
 *	    "column"=>"productName"
 *		),
 *		"sum"=>"dollar_sales",
 * )))
 * */
namespace koolreport\cube\processes;
use \koolreport\core\Utility;

class Cube extends \koolreport\core\Process
{
  protected $row;
  protected $column;
  protected $aggregate;
  protected $aggregates = array('sum', 'count', 'avg', 'min', 'max');
  protected $dimensions = array();
  protected $data = array();
  protected $count = array();
  
  protected $nameToIndex = array();
  protected $indexToName = array();
  protected $forwardMeta;
	
  public function onInit() {
    $this->row = Utility::get($this->params, "row", null);
    $this->column = Utility::get($this->params, "column", null);
    $keys = array_keys($this->params);
    foreach ($keys as $key)
      if (in_array($key, $this->aggregates)) {
        $this->aggregate = array(
          'operator' => $key, 
          'field' => $this->params[$key]);
        break;
      }
      
    if (isset($this->row))
      $this->dimensions['row'] = $this->row;
    if (isset($this->column))
      $this->dimensions['column'] = $this->column;
    foreach ($this->dimensions as $d => $field) {
      $this->nameToIndex[$d] = array();
      $this->indexToName[$d] = array();
    }
    
    $node = '{{all}}';
    $this->nameToIndex['column'][$node] = 0;
    $this->indexToName['column'][0] = $node;
    if (! isset($this->row)) {
      $this->nameToIndex['row'][$node] = 0;
      $this->indexToName['row'][0] = $node;
    }
  }
  
  public function onInput($row)
	{
    $nodes = array();
    foreach ($this->dimensions as $d => $field) {
      $nodeName = isset($row[$field]) ? $row[$field] : '{{others}}';
      if (! isset($this->nameToIndex[$d][$nodeName])) {
        $index = count($this->nameToIndex[$d]);
        $this->nameToIndex[$d][$nodeName] = $index;
        $this->indexToName[$d][$index] = $nodeName;
      }
      $nodes[$d] = $this->nameToIndex[$d][$nodeName];
    }
  
    $field = $this->aggregate['field'];
    $operator = $this->aggregate['operator'];
    if (! isset($row[$field]))
      return false;
    
    $dataNodes = array();
    $rowNode = isset($this->row) ? $nodes['row'] : 0;
    $colNodes = array(0);
    if (isset($this->column)) 
      array_push($colNodes, $nodes['column']);
    foreach ($colNodes as $colNode)
      array_push($dataNodes, $rowNode . ' : ' . $colNode);
    foreach ($dataNodes as $dataNode) {
      if (! isset($this->data[$dataNode])) {
        $this->data[$dataNode] = $this->initValue($operator);
        $this->count[$dataNode] = $this->initValue('count');
      }
      $this->data[$dataNode] = $this->aggValue($operator, 
        $this->data[$dataNode], $row[$field]);
      $this->count[$dataNode] = $this->aggValue('count', 
        $this->count[$dataNode], $row[$field]);
    }
	}
  
  private function initValue($aggregate) {
    switch ($aggregate) {
      case 'min':
        return PHP_INT_MAX; 
      case 'max':
        return PHP_INT_MIN;
      case 'sum':
      case 'count':
      case 'avg':
      default:
        return 0;
    }
  }
  
  private function aggValue($aggregate, $value1, $value2) {
    switch ($aggregate) {
      case 'min':
        return min($value1, $value2);
      case 'max':
        return max($value1, $value2);
      case 'count':
        return $value1 + 1;
      case 'avg':
      case 'sum':
      default:
        return (float) $value1 + (float) $value2;
    }
  }
  
  public function finalize() {
    //if aggregate operator is average, divide total sum by total count
    $operator = $this->aggregate['operator'];
    if ($operator === 'avg')
      foreach ($this->data as $key => $value)
        $this->data[$key] = $this->data[$key] / $this->count[$key];
    
    $metaData = array();
    $columns = array();
    $columnNames = array();
    if (isset($this->row)) {
      $columns[$this->row] = array('type' => 'string');
      array_push($columnNames, $this->row);
    }
    else {
      $columns['Label'] = array('type' => 'string');
      array_push($columnNames, 'Label');
    }
    foreach ($this->indexToName['column'] as $i => $colName) {
      $columns[$colName] = $this->metaData['columns'][$this->aggregate['field']];
      array_push($columnNames, $colName);
    }
    // $columns['{{all}}'] = array('type' => 'number');
    $columns['{{all}}'] = $this->metaData['columns'][$this->aggregate['field']];
    array_push($columnNames, '{{all}}');
    $this->forwardMeta = array('columns' => $columns);

    $data = array();
    // echo "<pre>";
    // echo json_encode($this->data, JSON_PRETTY_PRINT); 
    // echo "</pre>";
    // echo '<br>';
    foreach ($this->indexToName['row'] as $i => $rowName) {
      if (isset($this->row))
        $row = array($this->row => $rowName);
      else
        $row = array('Label' => 'Total');
      foreach ($this->indexToName['column'] as $j => $colName) {
        $position = $i . ' : ' . $j;
        $row[$colName] = isset($this->data[$position]) ? 
          $this->data[$position] : 0;
      }
      array_push($data, $row);
    }
    $this->data = $data;
    // echo "<pre>";
    // echo json_encode($this->data, JSON_PRETTY_PRINT); 
    // echo "</pre>";
    // echo '<br>';
  }
  
  public function receiveMeta($metaData, $source) 
  {
    $this->metaData = array_merge($this->metaData, $metaData);
  }
  
  public function onInputEnd()
	{
    $this->finalize();
        
    $this->sendMeta($this->forwardMeta);
    
    foreach($this->data as $row)
    {
      $this->next($row);
    }		
	}
}