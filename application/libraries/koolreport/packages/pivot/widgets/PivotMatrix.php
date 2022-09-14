<?php
/* Usage
  PivotMatrix::create(array(
    'dataStore'=>$this->dataStore('sales'),
    'rowDimension'=>'row',
    'columnDimension'=>'column',
    'measures'=>array(
      'dollar_sales - sum', 
      'dollar_sales - count'
    ),
    'rowSort' => array(
      'orderMonth' => function($a, $b) {
        return (int)$a < (int)$b;
      }, 
      'orderDay' => function($a, $b) {
        return (int)$a < (int)$b;
      },
    ),
    'columnSort' => array(
      'dollar_sales - sum' => 'desc',
      'orderYear' => 'desc', 
    ),
    'rowCollapseLevels' => array(0),
    'columnCollapseLevels' => array(0, 1, 2),
    'headerMap' => array(
      'dollar_sales - sum' => 'Sales (in USD)',
      'dollar_sales - count' => 'Number of Sales',
    ),
    'headerMap' => function($v, $f) {
      if ($v === 'dollar_sales - sum')
        $v = 'Sales (in USD)';
      if ($v === 'dollar_sales - count')
        $v = 'Number of Sales';
      if ($f === 'orderYear')
        $v = 'Year ' . $v;
      return $v;
    },
    'dataMap' => function($v, $f) {return $v;},
    'totalName' => 'Total',
    'hideTotalRow' => true,
    'hideTotalColumn' => true,
    'width' => '100%',
  ));
 **/

namespace koolreport\pivot\widgets;
use \koolreport\pivot\PivotUtil;
use \koolreport\core\Widget;
use \koolreport\core\Utility;

class PivotMatrix extends Widget
{
    private static $instanceId = 0;
    protected $uniqueId;
    protected $width;
    protected $height;
    protected $emptyValue;
    protected $totalName;
    protected $rowCollapseLevels;
    protected $colCollapseLevels;
    protected $waitingFields;
    protected $scope;

    protected function resourceSettings()
    {
        return array(
            "library"=>array("font-awesome"),
            "folder"=>"assets",
            "js"=>array(
                "PivotMatrix.js",
            ),
            "css"=>array(
                "PivotMatrix.css",
                "animate.min.css",
            )
        );        
    }
	
	protected function onInit()
	{
        $this->pivotMatrixId = "krpm_" . Utility::get($this->params,'id', self::$instanceId++);
        $this->useDataSource();
        $this->uniqueId = Utility::get($this->params,'id', 'pivotMatrix_'.Utility::getUniqueId());
		$this->width = Utility::get($this->params, 'width', 'auto');
		$this->height = Utility::get($this->params, 'height', 'auto');
		$this->emptyValue = Utility::get($this->params, 'emptyValue', '-');
		$this->totalName = Utility::get($this->params,'totalName','Total');
		$this->rowCollapseLevels = Utility::get($this->params,'rowCollapseLevels',array());
		$this->colCollapseLevels = Utility::get($this->params,'columnCollapseLevels',array());
		$this->clientEvents = Utility::get($this->params,'clientEvents',array());
		$this->rowSort = Utility::get($this->params,'rowSort',array());
		$this->columnSort = Utility::get($this->params,'columnSort',array());
		$this->scope = Utility::get($this->params,'scope',array());
		$this->columnWidth = Utility::get($this->params,'columnWidth','70px');
		$this->cssClass = Utility::get($this->params,'cssClass',array());
	}
  
	public function onRender()
	{
		if (! $this->dataStore) return array();
        $dataStore = $this->dataStore;
        $meta = $dataStore->meta()['columns'];

        $paging = null;
        if (isset($this->params['paging'])) {
            $paging = $this->params['paging'];
            if (! is_array($paging)) $paging = array();
            $paging = array_merge(array(
                'page' => 1,
                'size' => 10,
                'maxDisplayedPages' => 5,
                'sizeSelect' => array(5, 10, 20, 50, 100)
            ), $paging);
        }
        $page = Utility::get($paging, 'page', null);
        $pageSize = Utility::get($paging, 'size', null);

        $scrollTopPercentage = $scrollLeftPercentage = 0;

        $isUpdate = false;
        if (isset($_POST['koolPivotConfig'])) {
            $config = json_decode($_POST['koolPivotConfig'], true);  
            if ($config['pivotMatrixId'] == $this->pivotMatrixId)
                $isUpdate = true;
        }

        if ($isUpdate) {
            // print_r($_POST['koolPivotConfig']); echo '<br><br>';
            // print_r($_POST['koolPivotViewstate']); echo '<br><br>';
            $this->params['measures'] = $config['dataFields'];
            $waitingFields = $config['waitingFields'];
            $waitingFieldsType = $config['waitingFieldsType'];
            $fs = array();
            foreach ($waitingFields as $i => $field)
                $fs[$field] = $waitingFieldsType[$i];
            $this->params['waitingFields'] = $fs;
            $viewstate = json_decode($_POST['koolPivotViewstate'], true);
            $paging = $viewstate["paging"];
            $scrollTopPercentage = $viewstate["scrollTopPercentage"];
            $scrollLeftPercentage = $viewstate["scrollLeftPercentage"];

            $this->rowSort = $this->params['rowSort'] = $config['rowSort'];
            $this->columnSort = $this->params['columnSort'] = $config['columnSort'];
            $this->columnWidth = $config['columnWidth'];
        }
        
        $pivotUtil = new PivotUtil($this->dataStore, $this->params);
        $FieldsNodesIndexes = $pivotUtil->getFieldsNodesIndexes();

        // Utility::prettyPrint($meta);
        // Utility::prettyPrint($dataStore->data());
        // Utility::prettyPrint($FieldsNodesIndexes);
        echo "<pivotmatrix id='$this->pivotMatrixId'>";
        $this->template('PivotMatrix', array_merge(
            array(
                'uniqueId' => $this->uniqueId,
                'width' => $this->width,
                'height' => $this->height,
                'totalName' => $this->totalName,
                'emptyValue' => $this->emptyValue,
                'rowCollapseLevels' => $this->rowCollapseLevels,
                'colCollapseLevels' => $this->colCollapseLevels,
                'clientEvents' => $this->clientEvents,
                'config' => array(
                    'pivotId' => $this->dataStore->meta()['pivotId'],
                    'expandTrees' => $this->dataStore->meta()['expandTrees'],
                    'pivotMatrixId' => $this->pivotMatrixId,
                    'waitingFields' => $FieldsNodesIndexes['waitingFields'],
                    'dataFields' => $FieldsNodesIndexes['dataFields'],
                    'columnFields' => $FieldsNodesIndexes['colFields'],
                    'rowFields' => $FieldsNodesIndexes['rowFields'],
                    'waitingFieldsType' => $FieldsNodesIndexes['waitingFieldsType'],
                    'dataFieldsType' => $FieldsNodesIndexes['dataFieldsType'],
                    'columnFieldsType' => $FieldsNodesIndexes['columnFieldsType'],
                    'rowFieldsType' => $FieldsNodesIndexes['rowFieldsType'],
                    'waitingFieldsSort' => $FieldsNodesIndexes['waitingFieldsSort'],
                    'dataFieldsSort' => $FieldsNodesIndexes['dataFieldsSort'],
                    'columnFieldsSort' => $FieldsNodesIndexes['columnFieldsSort'],
                    'rowFieldsSort' => $FieldsNodesIndexes['rowFieldsSort'],
                    'rowSort' => $this->rowSort,
                    'columnSort' => $this->columnSort,
                    'columnWidth' => $this->columnWidth,
                ),
                'viewstate' => array(
                    'paging' => $paging,
                    'scrollTopPercentage' => $scrollTopPercentage,
                    'scrollLeftPercentage' => $scrollLeftPercentage,
                ),
                'scope' => $this->scope
            ),
            $FieldsNodesIndexes
        ));
        echo "</pivotmatrix>";
        if ($isUpdate && isset($_POST['partialRender'])) exit;
	}	
}