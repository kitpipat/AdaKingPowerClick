<?php
namespace koolreport\pivot;
use \koolreport\core\Utility;

class PivotUtil
{
  protected $dataStore;
  protected $params;
  
	protected $measures;
	protected $rowDimension;
	protected $columnDimension;
	protected $rowSort;
	protected $columnSort;
	protected $headerMap;
	protected $dataMap;
	protected $totalName;
	protected $hideTotalRow;
	protected $hideTotalColumn;
	protected $paging;
  
  protected $FieldsNodesIndexes;
  
  public function __construct($dataStore, $params) {
    $this->dataStore = $dataStore;
    $this->params = $params;

    $this->rowDimension = Utility::get($this->params, 'rowDimension', 'row');
		$this->columnDimension = Utility::get($this->params, 'columnDimension', 'column');
		$this->rowSort = Utility::get($this->params, 'rowSort', array());
    $this->columnSort = Utility::get($this->params, 'columnSort', array());
		$this->headerMap = Utility::get($this->params, 'headerMap', 
      function($v, $f){return $v;});
		$this->dataMap = Utility::get($this->params, 'dataMap', null);
    $this->totalName = Utility::get($this->params, 'totalName', 'Total');
    $this->hideTotalRow = Utility::get($this->params, 'hideTotalRow', false);
    $this->hideTotalColumn = Utility::get($this->params, 'hideTotalColumn', false);
    
		
		//Get the measure field and settings in format
		$measures = array();
    $mSettings = Utility::get($this->params,'measures',array());
    $meta = $dataStore->meta()['columns'];
		foreach($mSettings as $cKey=>$cValue) {
			if(gettype($cValue)=='array')
				$measures[$cKey] = $cValue;
			else
				$measures[$cValue] = isset($meta[$cValue]) ? $meta[$cValue] : null;
		}
    if (empty($measures)) {
      $dataStore->popStart();
      $row = $dataStore->pop();
      $columns = array_keys($row);
      foreach ($columns as $c)
        if ($meta[$c]['type'] !== 'dimension')
          $measures[$c] = $meta[$c];
    }
    $this->measures = $measures;

    $this->waitingFields = Utility::get($this->params, 'waitingFields', array());
    
    $this->read();
  }
  
  public function sort(& $index, $nodes, $fields, 
      $nameToIndex, $dimIndexToData, $sort, $dataFields) 
  {
    usort($index, function($a, $b) use ($nodes, $fields, 
        $nameToIndex, $dimIndexToData, $dataFields, $sort) {
      $cmp = 0;
      $parentNode = array();
      foreach ($fields as $field)
        $parentNode[$field] = '{{all}}';
      foreach ($fields as $field) {
        $value1 = $nodes[$a][$field];
        $value2 = $nodes[$b][$field];
        $node1 = $node2 = $parentNode;
        $node1[$field] = $value1;
        $node2[$field] = $value2;
        if ($value1 === $value2) {
          $parentNode[$field] = $value1;
          continue;
        }
        else if ($value1 === '{{all}}')
          return 1;
        else if ($value2 === '{{all}}')
          return -1;
        else {
          $cmp =is_numeric($value1) && is_numeric($value2) ? 
            $value1 - $value2 :  strcmp($value1, $value2);
          $sortField = isset($sort[$field]) ? $sort[$field] : null;
          if (is_string($sortField))
            $cmp = $sortField === 'desc' ? - $cmp : $cmp;
          else if (is_callable($sortField)) {
            $cmp = $sortField($value2, $value1);
          }
        }
        if ($cmp !== 0)
          break;
      }
      $dataCmp = $cmp;
      foreach ($dataFields as $field)
        if (isset($sort[$field]) && $sort[$field] !== 'ignore') {
          $dataSortField = $field;
          $dataSortDirection = $sort[$field];
          break;
        }
      $index1 = $nameToIndex[implode(' - ', $node1)];
      $index2 = $nameToIndex[implode(' - ', $node2)];
      if (isset($dataSortField) && 
        isset($dimIndexToData[$index1][$dataSortField])) {
        $sortValue1 = isset($dimIndexToData[$index1]) ? 
            $dimIndexToData[$index1][$dataSortField] : 0;
        $sortValue2 = isset($dimIndexToData[$index2]) ? 
            $dimIndexToData[$index2][$dataSortField] : 0;
        $diff = $sortValue1 - $sortValue2;
        if ($dataSortDirection === 'asc')
          $dataCmp = $diff;
        else if ($dataSortDirection === 'desc')
          $dataCmp = - $diff;  
        else if (is_callable($dataSortDirection))
          $dataCmp = $dataSortDirection($sortValue1, $sortValue2);
      }
      return $dataCmp;
    });
  }
  
  private function read() {
    if(!$this->dataStore) return array();
    
    $dataStore = $this->dataStore;
    $meta = $dataStore->meta()['columns'];
    $data = $dataStore->data();
    
    $rowDimension = isset($meta[$this->rowDimension]) ?
        $this->rowDimension : null;
    $columnDimension = isset($meta[$this->columnDimension]) ? 
        $this->columnDimension : null;
    
    $rowNodes = isset($rowDimension) ?
        $meta[$rowDimension]['index'] : null;
    $colNodes = isset($columnDimension) ? 
        $meta[$columnDimension]['index'] : null;
    if (empty($rowNodes) || empty($rowNodes[0])) 
      $rowNodes = array(array('root' => '{{all}}'));
    if (empty($colNodes) || empty($colNodes[0]))
      $colNodes = array(array('root' => '{{all}}'));
    
    $rowFields = array_keys($rowNodes[0]);
    $colFields = array_keys($colNodes[0]);
    // $dataFields = $this->measures;
    $dataFields = array_keys($this->measures);
      
    $nameToIndexRow = array();
    foreach($rowNodes as $i => $node) 
      $nameToIndexRow[implode(' - ', $node)] = $i;
    $nameToIndexCol = array();
    foreach($colNodes as $i => $node) 
      $nameToIndexCol[implode(' - ', $node)] = $i;
    
    $rowIndexToData = array();
    $colIndexToData = array();
    $indexToData = array();
    foreach ($data as $dataRow) {
      $rowIndex = (int) Utility::get($dataRow, $rowDimension, 0);
      $colIndex = (int) Utility::get($dataRow, $columnDimension, 0);
      if (isset($rowDimension) && $colIndex === 0)
        $rowIndexToData[$rowIndex] = $dataRow;
      if (isset($columnDimension) && $rowIndex === 0)
        $colIndexToData[$colIndex] = $dataRow;
      $indexToData[$rowIndex][$colIndex] = $dataRow;
    }
    
    $rowIndexes = range(0, count($rowNodes) - 1);
    $this->sort($rowIndexes, $rowNodes, $rowFields,
        $nameToIndexRow, $rowIndexToData, $this->rowSort, $dataFields);
    $colIndexes = range(0, count($colNodes) - 1);
    $this->sort($colIndexes, $colNodes, $colFields, 
        $nameToIndexCol, $colIndexToData, $this->columnSort, $dataFields);
        
    $rowNodesMark = array_fill(0, count($rowNodes), array());
    $rowspan = array_fill_keys($rowFields, 1);
    $nullNode = array_fill_keys($rowFields, null);
    $lastSameNodeField = array_fill_keys($rowFields, $rowIndexes[0]);
    array_push($rowIndexes, count($rowIndexes));
    foreach ($rowIndexes as $i => $index) {
      $node = isset($rowNodes[$index]) ? $rowNodes[$index] : $nullNode;
      $prevNode = isset($rowIndexes[$i - 1]) ? 
          $rowNodes[$rowIndexes[$i - 1]] : $nullNode;
      $firstAllCell = -1;
      foreach ($rowFields as $j => $f) {
        if ($node[$f] !== $prevNode[$f]) {
          if ($rowNodes[$lastSameNodeField[$f]][$f] !== '{{all}}') {
            $rowNodesMark[$lastSameNodeField[$f]][$f . '_rowspan'] = $rowspan[$f];
            $rowNodesMark[$lastSameNodeField[$f]][$f . '_colspan'] = 1;
          }
          $lastSameNodeField[$f] = $index;
          $rowspan[$f] = 1;
        }
        else {
          $rowspan[$f] += 1;
        }
        if ($firstAllCell === -1 && $node[$f] === '{{all}}') {
          $firstAllCell = $j;
          $rowNodesMark[$index][$f . '_colspan'] = count($rowFields) - $j;
          $rowNodesMark[$index][$f . '_rowspan'] = 1;
        }
      }
    }
    array_pop($rowIndexes);
    if ($this->hideTotalRow)
      array_pop($rowIndexes);

    $colNodesMark = array_fill(0, count($colNodes), array());
    $colspan = array_fill_keys($colFields, 1);
    $nullNode = array_fill_keys($colFields, null);
    $lastSameNodeField = array_fill_keys($colFields, $colIndexes[0]);
    array_push($colIndexes, count($colIndexes));
    foreach ($colIndexes as $i => $index) {
      $node = isset($colNodes[$index]) ? $colNodes[$index] : $nullNode;
      $prevNode = isset($colIndexes[$i - 1]) ? 
          $colNodes[$colIndexes[$i - 1]] : $nullNode;
      $firstAllCell = -1;
      foreach ($colFields as $j => $f) {
        if ($node[$f] !== $prevNode[$f]) {
          if ($colNodes[$lastSameNodeField[$f]][$f] !== '{{all}}') {
            $colNodesMark[$lastSameNodeField[$f]][$f . '_colspan'] = 
              $colspan[$f] * (count($dataFields) > 0 ? count($dataFields) : 1);
            $colNodesMark[$lastSameNodeField[$f]][$f . '_rowspan'] = 1;
          }
          $lastSameNodeField[$f] = $index;
          $colspan[$f] = 1;
        }
        else {
          $colspan[$f] += 1;
        }
        if ($firstAllCell === -1 && $node[$f] === '{{all}}') {
          $firstAllCell = $j;
          $colNodesMark[$index][$f . '_rowspan'] = count($colFields) - $j;
          $colNodesMark[$index][$f . '_colspan'] = count($dataFields);
        }
      }
    }
    array_pop($colIndexes);
    if ($this->hideTotalColumn)
      array_pop($colIndexes);
    
    // Utility::prettyPrint($rowNodes);
    $totalName = $this->totalName;
    $headerMap = $this->headerMap;
    $headerMap = function($v, $f) use ($headerMap, $totalName) {
      if ($v === '{{all}}') return $totalName;
      if (is_array($headerMap))
        return isset($headerMap[$v]) ? $headerMap[$v] : $v;
      return $headerMap($v, $f);
    };
    $mappedRowNodes = array();
    foreach ($rowNodes as $i => $node) 
      $mappedRowNodes[$i] = array_combine($rowFields,
        array_map($headerMap, $node, $rowFields));
    $mappedColNodes = array();
    foreach ($colNodes as $i => $node)
      $mappedColNodes[$i] = array_combine($colFields,
        array_map($headerMap, $node, $colFields));

    // Utility::prettyPrint($colFields);
    $mappedDataFields = array_combine($dataFields,
        array_map($headerMap, $dataFields, array()));
    $mappedColFields = $colFields[0] !== 'root' ? array_combine($colFields,
        array_map($headerMap, $colFields, array())) : array();
    $mappedRowFields = $rowFields[0] !== 'root' ? array_combine($rowFields,
        array_map($headerMap, $rowFields, array())) : array();
    $waitingFields = array_keys($this->waitingFields);
    $mappedWaitingFields = array_combine($waitingFields,
    array_map($headerMap, $waitingFields, array()));

    $waitingFieldsType = array_values($this->waitingFields);
    $dataFieldsType = array_fill(0, count($dataFields), 'data');
    $columnFieldsType = array_fill(0, count($colFields), 'column');
    $rowFieldsType = array_fill(0, count($rowFields), 'row');

    $waitingFieldsSort = array_fill(0, count($this->waitingFields), 'noSort');
    $dataFieldsSort = array_fill(0, count($dataFields), 'noSort');
    $columnFieldsSort = array_fill(0, count($colFields), 'noSort');
    $rowFieldsSort = array_fill(0, count($rowFields), 'noSort');
    $colSortDataField = null;
    foreach ($this->columnSort as $field => $dir) {
        foreach ($dataFields as $i => $dataField)
            if ($dataField === $field && ($dir === 'asc' || $dir === 'desc')) {
                $dataFieldsSort[$i] .= ' columnsort' . $dir;
                $colSortDataField = $field;
            }
    }
    $rowSortDataField = null;
    foreach ($this->rowSort as $field => $dir) {
        foreach ($dataFields as $i => $dataField)
            if ($dataField === $field && ($dir === 'asc' || $dir === 'desc')) {
                $dataFieldsSort[$i] .= ' rowsort' . $dir;
                $rowSortDataField = $field;
            }
    }
    
    if (! $colSortDataField) {
        foreach ($this->columnSort as $field => $dir) 
            foreach ($colFields as $i => $colField)
                if ($colField == $field && ($dir === 'asc' || $dir === 'desc')) 
                    $columnFieldsSort[$i] = 'columnsort' . $dir;
    }
    if (! $rowSortDataField) {
        foreach ($this->rowSort as $field => $dir) 
            foreach ($rowFields as $i => $rowField)
                if ($rowField === $field && ($dir === 'asc' || $dir === 'desc')) 
                    $rowFieldsSort[$i] = 'rowsort' . $dir;
    }

    $dataMap = $this->dataMap;
    if (is_array($dataMap)) 
      $dataMap = function($v) use ($dataMap) {
        return isset($dataMap[$v]) ? $dataMap[$v] : $v;
      };
    $indexToDataRaw = $indexToData;  
    foreach ($indexToData as $r => $cs)
      foreach ($cs as $c => $d)
        if (is_callable($dataMap))
          $indexToData[$r][$c] = array_combine(array_keys($d), 
            array_map($dataMap, $d, array_keys($d)));
        else 
          foreach ($d as $df => $v) {
            // $indexToData[$r][$c][$df] = Utility::format($v, $meta[$df]);
            $indexToData[$r][$c][$df] = Utility::format($v, 
              isset($this->measures[$df]) ? $this->measures[$df] : $meta[$df]);
          }

    $numRow = count($rowNodes);
        
    // Utility::prettyPrint($pageSizeSelect);
    // Utility::prettyPrint($rowNodes);
    $this->FieldsNodesIndexes = array(
      'waitingFields' => $waitingFields,
      'dataFields' => $dataFields,
      'colFields' => $colFields,
      'rowFields' => $rowFields,
      'waitingFieldsType' => $waitingFieldsType,
      'dataFieldsType' => $dataFieldsType,
      'columnFieldsType' => $columnFieldsType,
      'rowFieldsType' => $rowFieldsType,
      'waitingFieldsSort' => $waitingFieldsSort,
      'dataFieldsSort' => $dataFieldsSort,
      'columnFieldsSort' => $columnFieldsSort,
      'rowFieldsSort' => $rowFieldsSort,
      'mappedDataFields' => $mappedDataFields,
      'mappedColFields' => $mappedColFields,
      'mappedRowFields' => $mappedRowFields,
      'mappedWaitingFields' => $mappedWaitingFields,
      'dataNodes' => $mappedDataFields,
      'colNodes' => $colNodes,
      'rowNodes' => $rowNodes,
      'mappedColNodes' => $mappedColNodes,
      'mappedRowNodes' => $mappedRowNodes,
      'colIndexes' => $colIndexes,
      'rowIndexes' => $rowIndexes,
      'colNodesMark' => $colNodesMark,
      'rowNodesMark' => $rowNodesMark,
      'indexToDataRaw' => $indexToDataRaw,
      'indexToData' => $indexToData,
      'numRow' => $numRow,
    );
  }

  public function getFieldsNodesIndexes() {
    return $this->FieldsNodesIndexes;
  }
}