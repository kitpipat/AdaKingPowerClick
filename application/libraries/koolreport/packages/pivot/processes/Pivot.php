<?php
/* Usage
 * ->pipe(new Pivot(array(
 * 		"dimensions"=>array(
 *		  "row"=>"customerName, productLine",
 *	    "column"=>"productName"
 *		),
 *		"aggregates"=>array(
 *			"sum"=>"dollar_sales"
 *		)
 * )))
 * */
namespace koolreport\pivot\processes;
use \koolreport\core\Utility;

class Pivot extends \koolreport\core\Process
{
    private static $instanceId = 0;

    protected $pivotId;
    protected $dimensions = array();
    protected $dataFields = array();
    protected $data = array();
    protected $count = array();
    
    protected $nameToIndexD = array();
    protected $indexToNameD = array();
    protected $forwardMeta;
    
    protected $partialProcessing;
    protected $expandTrees;
    protected $command;
  
    public function onInit() 
    {
        // $this->index = 0;
        $this->pivotId = $this::$instanceId++;
        $this->partialProcessing = Utility::get($this->params, "partialProcessing", false);
        // if ($this->partialProcessing)
        //     echo 'partial processing<br>';
        // echo 'init pivot<br>';
        $isUpdate = false;
        if (isset($_POST['koolPivotConfig'])) {
            $config = json_decode($_POST['koolPivotConfig'], true);  
            if ($config['pivotId'] == $this->pivotId)
                $isUpdate = true;
        }
        if ($isUpdate) {
            $this->expandTrees = $config['expandTrees'];
            $this->command = json_decode($_POST['koolPivotCommand'], true);
            $columnFields = $config["columnFields"];
            $rowFields = $config["rowFields"];
            if ($columnFields[0] === 'root')
                $columnFields = array_slice($columnFields, 1);
            if ($rowFields[0] === 'root')
                $rowFields = array_slice($rowFields, 1);

            $dimensions = array(
                'column' => $columnFields,
                'row' => $rowFields
            );
            $this->dimensions = array();
            foreach ($dimensions as $d => $fields) {
                $this->dimensions[$d] = array();
                if (is_string($fields))
                    $fields = explode(',', $fields);
                foreach ($fields as $field) {
                    $field = trim($field);
                    if (! empty($field))
                        array_push($this->dimensions[$d], $field);
                }
            }
            $aggregates = array();
            $measures = $config["dataFields"];
            foreach ($measures as $measure) {
                $fieldAgg = explode(" - ", $measure);
                if (empty($aggregates[$fieldAgg[1]]))
                    $aggregates[$fieldAgg[1]] = $fieldAgg[0];
                else
                    $aggregates[$fieldAgg[1]] .= ", " . $fieldAgg[0];
            }
        
        }
        else {
            $this->dimensions = Utility::get($this->params, "dimensions", array());
            $this->expandTrees = array();
            $this->command = array();
            foreach ($this->dimensions as $d => $fields) {
                $this->expandTrees[$d] = array(
                    'name' => 'root',
                    'children' => array()
                );
                $this->command[$d] = array();
            }
            $dimensions = array();
            foreach ($this->dimensions as $d => $fields) {
                $dimensions[$d] = array();
                if (is_string($fields))
                $fields = explode(',', $fields);
                foreach ($fields as $field) {
                $field = trim($field);
                if (! empty($field))
                    array_push($dimensions[$d], $field);
                }
            }
            $this->dimensions = $dimensions;
            $aggregates = Utility::get($this->params, "aggregates", array());
        }
        
        $this->dataFields = array();
        $this->hasAvg = false;
        foreach ($aggregates as $aggregate => $fields) {
            if ($aggregate === 'avg')
                $this->hasAvg = true;
            $fields = explode(',', $fields);
            foreach ($fields as $field) {
                $field = trim($field);
                if (! isset($this->dataFields[$field]))
                $this->dataFields[$field] = array();
                array_push($this->dataFields[$field], trim($aggregate));    
            }
        }  
        
        foreach ($this->dimensions as $d => $dimension) {
            $this->nameToIndexD[$d] = array();
            $this->indexToNameD[$d] = array();
        }
        
    }

    protected function addToTree(& $expandTree, $fields, $node, $level) {
        $tree = & $expandTree;
        for ($i=0; $i<$level && $i<count($fields); $i++) {
            $field = $fields[$i];
            if ($node[$field] === '{{all}}') continue;
            $foundNode = false;
            foreach ($tree['children'] as & $child)
                if ($child['name'] === $node[$field]) {
                    $tree = & $child;
                    $foundNode = true;
                    break;
                }
            if (! $foundNode) {
                $newNode = array(
                    'name' => $node[$field],
                    'children' => array(),
                );
                array_push($tree['children'], $newNode);
                $tree = & $newNode;
            }
        }
        return true;
    }

    protected function isInTree(& $expandTree, $fields, $node) {
        $tree = & $expandTree;
        foreach ($fields as $i => $field) {
            if ($i === 0) continue;
            if ($node[$field] === '{{all}}') break;
            $parentField = $fields[$i-1];
            $foundParentNode = false;
            foreach ($tree['children'] as & $child)
                if ($child['name'] === $node[$parentField]) {
                    $tree = & $child;
                    $foundParentNode = true;
                    break;
                }
            if (! $foundParentNode)
                return false;
        }
        return true;
    }
  
    public function onInput($row)
    {
        // $this->index++;
        // if ($this->index % 10000 === 0)
        //     echo $this->index . '<br>';
        $dataFields = $this->dataFields;
        $data = & $this->data;
        $count = & $this->count;
        $nodesD = array();
        $rootNode = 'Root';

        foreach ($this->dimensions as $d => $fields) {
            $expandTree = & $this->expandTrees[$d];
            $command = & $this->command[$d];
            $nameToIndex = & $this->nameToIndexD[$d];
            $indexToName = & $this->indexToNameD[$d];
            $nodesD[$d] = array();
            
            $node = array();
            foreach ($fields as $i => $labelField) 
                $node[$labelField] = '{{all}}';
            $nodeName = implode(' - ', $node);
            if (! isset($nameToIndex[$nodeName])) {
                $index = count($indexToName);
                $nameToIndex[$nodeName] = $index;
                $indexToName[$index] = $node;
            }
            array_push($nodesD[$d], 0);
            foreach ($fields as $i => $labelField) {
                $node[$labelField] = isset($row[$labelField]) ? 
                    $row[$labelField] : '{{other}}';
                $expandLevel = Utility::get($command, "expand", -1);
                if (! $this->partialProcessing)
                    $expandLevel = count($fields);
                if ($expandLevel >= $i) 
                    $this->addToTree($expandTree, $fields, $node, $expandLevel);
                else if (! $this->isInTree($expandTree, $fields, $node))
                    continue;
                $nodeName = implode(' - ', $node);
                if (! isset($nameToIndex[$nodeName])) {
                    $index = count($indexToName);
                    $nameToIndex[$nodeName] = $index;
                    $indexToName[$index] = $node;
                }
                array_push($nodesD[$d], $nameToIndex[$nodeName]);
            }
        }
        
        $dataNodes = $this->buildDataNodes($nodesD);
        foreach ($dataNodes as $dataNode) {
            if (! isset($data[$dataNode])) {
                $data[$dataNode] = array();
                foreach ($dataFields as $dataField => $aggregates)
                    foreach ($aggregates as $aggregate)
                        $data[$dataNode][$dataField . ' - ' . $aggregate] = $this->initValue($aggregate);
                if ($this->hasAvg)
                    $count[$dataNode] = $this->initValue('count');
            }
            foreach ($dataFields as $dataField => $aggregates) {
                foreach ($aggregates as $aggregate) {
                    $aggName = $dataField . ' - ' . $aggregate;
                    $data[$dataNode][$aggName] =
                        $this->aggValue($aggregate, $data[$dataNode][$aggName], $row[$dataField]);
                }
                if ($this->hasAvg)
                    $count[$dataNode] = $this->aggValue('count', $count[$dataNode], $row[$dataField]);
            }
        }
	}
  
    private function buildDataNodes($nodesD) 
    {
        $dataNodes = array();
        $nodes1 = reset($nodesD);
        if (count($nodesD) <= 1) {
            foreach ($nodes1 as $node)
                // if ($node !== 0) //i.e node !== {{all}}
                array_push($dataNodes, $node);
            return $dataNodes;
        }
        $nodesD2 = array_slice($nodesD, 1);
        $dataNodes2 = $this->buildDataNodes($nodesD2);
        foreach ($nodes1 as $node1)
            foreach ($dataNodes2 as $dataNode2) 
            // if ($node1 !== 0) //i.e node1 !== {{all}}
            {
                $node = $node1 . ' : ' . $dataNode2;
                array_push($dataNodes, $node);
            }
        
        return $dataNodes;
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
        foreach ($this->dataFields as $dataField => $aggregates)
            foreach ($aggregates as $aggregate) 
                if ($aggregate === 'avg') {
                    $aggName = $dataField . ' - ' . $aggregate;
                    foreach ($this->data as $key => $datum) 
                        $this->data[$key][$aggName] = 
                            $this->data[$key][$aggName] / $this->count[$key];
                }
        
        $metaData = array();
        foreach ($this->dimensions as $d => $dimension) {
            $metaDimension = array();
            $indexToName = $this->indexToNameD[$d];
            foreach ($indexToName as $i => $name) {
                array_push($metaDimension, $name);
            }
            $metaData[$d] = array('type' => 'dimension', 'index' => $metaDimension);
        }
        // Utility::prettyPrint($metaData);
        $this->forwardMeta['columns'] = array_merge($this->forwardMeta['columns'], $metaData);

        $data = array();
        foreach ($this->data as $keys => $datum) {
            $row = array();
            $keys = explode(' : ', $keys);
            $i = 0;
            $dimensionKeys = array_keys($this->dimensions);
            foreach ($keys as $d => $key) {
                $dimensionKey = $dimensionKeys[$i];
                $row[$dimensionKeys[$i]] = $key;
                $i++;
            }
            $row = array_merge($row, $datum);
            array_push($data, $row);
        }
        $this->data = $data;
        // Utility::prettyPrint($this->data);
    }
    
    public function receiveMeta($metaData, $source) 
    {
        $this->metaData = array_merge($this->metaData, $metaData);
        $dataFields = $this->dataFields;
        $this->forwardMeta = $this->metaData;
        
        $columns = $this->forwardMeta['columns'];
        foreach ($dataFields as $dataField => $aggregates) 
        foreach ($columns as $col => $des)
            if ($col === $dataField) {
            foreach ($aggregates as $aggregate) {
                $aggField = $dataField . ' - ' . $aggregate;
                if ($aggregate !== 'count')
                $columns[$aggField] = $des;
                else
                $columns[$aggField] = array('type' => 'number');
            }
            }
        $this->forwardMeta['pivotId'] = $this->pivotId;   
        $this->forwardMeta['expandTrees'] = & $this->expandTrees;   
        $this->forwardMeta['columns'] = $columns; 
    }
    
    public function onInputEnd()
    {
        $this->finalize();

        // print_r($this->expandTrees);
            
        $this->sendMeta($this->forwardMeta);
        
        foreach($this->data as $row)
        {
            $this->next($row);
        }		
    }
}