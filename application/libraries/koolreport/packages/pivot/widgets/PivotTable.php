<?php
/* Usage
  PivotTable::create(array(
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

class PivotTable extends Widget
{
  protected $uniqueId;
  
	protected $dataStore;
  protected $emptyValue;
  protected $totalName;
  // protected $topRow;
  // protected $topColumn;
  protected $rowCollapseLevels;
  protected $colCollapseLevels;
  protected $width;
  protected $cssClass;
	
	protected function onInit()
	{
    $this->uniqueId = 'pivottable_'.Utility::getUniqueId();
    
		$this->dataStore = Utility::get($this->params,'dataStore',null);
		$this->emptyValue = Utility::get($this->params, 'emptyValue', '-');
		$this->totalName = Utility::get($this->params,'totalName','Total');
		// $this->topRow = Utility::get($this->params,'topRow',null);
		// $this->topColumn = Utility::get($this->params,'topColumn',null);
		$this->rowCollapseLevels = Utility::get($this->params,'rowCollapseLevels',array());
		$this->colCollapseLevels = Utility::get($this->params,'columnCollapseLevels',array());
		$this->width = Utility::get($this->params,'width',null);
		$this->cssClass = Utility::get($this->params,'cssClass',array());
	}
  
	public function render()
	{
		if (!$this->dataStore) return array();
    $dataStore = $this->dataStore;
    $meta = $dataStore->meta()['columns'];
    
    $pivotUtil = new PivotUtil($this->dataStore, $this->params);
    $FieldsNodesIndexes = $pivotUtil->getFieldsNodesIndexes();
        
    $this->getAssetManager()->publish('assets');
    $scriptUrl = $this->getAssetManager()->getAssetUrl("PivotTable.js");
    $this->getReport()->getResourceManager()
      ->addScriptFileOnBegin($scriptUrl);
      
    // $this->getReport()->registerEvent('OnBeforeRender',function(){
      // $assetUrl = $this->getReport()->publishAssetFolder(dirname(__FILE__)."../../../clients/font-awesome");
      // $this->getReport()->getResourceManager()->addCssFile($assetUrl."/css/font-awesome.min.css");
    // });
      
    $this->getAssetManager()->publish('../../../clients/font-awesome');
    $cssUrl = $this->getAssetManager()->getAssetUrl("css/font-awesome.min.css");
    $this->getReport()->getResourceManager()
      ->addCssFile($cssUrl);

    $this->paging = Utility::get($this->params, 'paging', array());
    $paging = $this->paging;
    $pageSize = Utility::get($this->paging, 'size', 10);
    $pageSizeSelect = Utility::get($this->paging, 'sizeSelect', array(5, 10, 20, 50, 100));
        
    // Utility::prettyPrint($meta);
    // Utility::prettyPrint($dataStore->data());
    // Utility::prettyPrint($FieldsNodesIndexes);
		$this->template('PivotTable', array_merge(
      array(
        'uniqueId' => $this->uniqueId,
        'totalName' => $this->totalName,
        'emptyValue' => $this->emptyValue,
        'rowCollapseLevels' => $this->rowCollapseLevels,
        'colCollapseLevels' => $this->colCollapseLevels,
        'width' => $this->width,
        'pageSize' => $pageSize,
        'pageSizeSelect' => $pageSizeSelect,
        'cssClass' => $this->cssClass,
      ),
      $FieldsNodesIndexes
    ));
	}	
}