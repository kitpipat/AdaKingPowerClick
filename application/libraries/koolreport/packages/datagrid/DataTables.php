<?php

namespace koolreport\datagrid;

use \koolreport\core\Widget;
use \koolreport\core\Utility;
use \koolreport\core\DataStore;

class DataTables extends Widget
{
    protected $name;
    protected $columns;
    protected $data;
    protected $options;
    protected $showFooter;
    protected $clientEvents;

    protected function resourceSettings()
    {
        return array(
            "library"=>array("jQuery"),
            "folder"=>"DataTables",
            "js"=>array("datatables.min.js"),
            "css"=>array("datatables.min.css")
        );
    }

    protected function onInit()
    {
        $this->useLanguage();
        $this->useDataSource();
        $this->name = Utility::get($this->params,"name");
        $this->columns = Utility::get($this->params,"columns",array());
        $this->showFooter = Utility::get($this->params,"showFooter",false);
        $this->clientEvents = Utility::get($this->params,"clientEvents",false);
        if(!$this->name)
        {
            $this->name = "datatables".Utility::getUniqueId();
        }

        if($this->dataStore==null)
        {
            throw new \Exception("dataSource is required for DataTables");
            return;	
        }


        $this->options = array(
            "searching"=>false,
            "paging"=>false,
        );

        if($this->languageMap!=null)
        {
            $this->options["language"] = $this->languageMap;
        }
        
        $this->options = array_merge($this->options,
        Utility::get($this->params,"options",array()));
        $this->cssClass = Utility::get($this->params,"cssClass",array());
    }


	protected function formatValue($value,$format,$row=null)
	{
        $formatValue = Utility::get($format,"formatValue",null);

        if(is_string($formatValue))
        {
            eval('$fv="'.str_replace('@value','$value',$formatValue).'";');
            return $fv;
        }
        else if(is_callable($formatValue))
        {
            return $formatValue($value,$row);
        }
		else
		{
			return Utility::format($value,$format);
		}
	}
    public function onRender()
    {
        $meta = $this->dataStore->meta();

        $showColumnKeys = array();
        
        if($this->columns==array())
        {
            $this->dataStore->popStart();
            $row = $this->dataStore->pop();
            if($row)
            {
                $showColumnKeys = array_keys($row);
            }
        }
        else
        {
            foreach($this->columns as $cKey=>$cValue)
            {
                if(gettype($cValue)=="array")
                {
                    if($cKey==="#")
                    {
                        $meta["columns"][$cKey] = array(
                            "type"=>"number",
                            "label"=>"#",
                            "start"=>1,
                        );
                    }
    
                    $meta["columns"][$cKey] =  array_merge($meta["columns"][$cKey],$cValue);                
                    if(!in_array($cKey,$showColumnKeys))
                    {
                        array_push($showColumnKeys,$cKey);
                    }
                }
                else
                {
                    if($cValue==="#")
                    {
                        $meta["columns"][$cValue] = array(
                            "type"=>"number",
                            "label"=>"#",
                            "start"=>1,
                        );
                    }
                    if(!in_array($cValue,$showColumnKeys))
                    {
                        array_push($showColumnKeys,$cValue);
                    }
                }    
            }
        }

		$this->template("DataTables",array(
			"showColumnKeys"=>$showColumnKeys,
			"meta"=>$meta,
		));
    }
}