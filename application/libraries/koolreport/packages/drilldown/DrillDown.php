<?php

namespace koolreport\drilldown;

use \koolreport\core\Widget;
use \koolreport\core\Utility;
use \koolreport\processes\Filter;
use \koolreport\processes\Group;

class DrillDown extends Widget
{
    protected $name;
    protected $calculate;
    protected $levels;
    protected $currentLevel; 
    protected $btnBack;
    protected $title;
    protected $partialRender;
    protected $showLevelTitle;
    protected $css;//{"panel","btnBack","levelTitle","body"}
    protected $panelStyle;
    protected $processDataStoreRequired = true;
    protected $scope;
    protected $clientEvents;

    protected function resourceSettings()
    {
        return array(
            "library"=>array("jQuery"),
            "folder"=>"clients",
            "css"=>array("DrillDown.css"),
            "js"=>array("DrillDown.js")
        );
    }
    
    protected function onInit()
    {
        $this->name = Utility::get($this->params,"name");
        $this->partialRender = Utility::get($this->params,"partialRender",false);
        $currentLevel = Utility::get($this->params,"currentLevel");
        $levelIndex = Utility::get($currentLevel,0,0);
        $levelParams = Utility::get($currentLevel,1,array());
        $this->currentLevel = array($levelIndex,$levelParams);
        $this->clientEvents = Utility::get($this->params,"clientEvents",array());


        if(!$this->name)
        {
            throw new \Exception("[name] property is required in DrillDown");
        }

        $this->levels = Utility::get($this->params,"levels");
        if(!$this->levels || count($this->levels)==0)
        {
            throw new \Exception("Setup levels of DrillDown with [levels] property");
        }
        foreach($this->levels as $level)
        {
            if(!isset($level["widget"]))
            {
                throw new \Exception("[widget] property is required on each level of drilldown");
            }
        }

        $this->calculate = Utility::get($this->params,"calculate");
        if(!$this->calculate)
        {
            throw new \Exception("Please setup calculation for drill down");
        }

        $scope = Utility::get($this->params,"scope",array());
        $this->scope = is_callable($scope)?$scope():$scope;

        $this->POSTParamsBinding();
        $this->useDataSource($this->scope);
        if($this->dataStore==null)
        {
            throw new \Exception("[dataSource] property is required");
        }
        if($this->processDataStoreRequired)
        {
            $this->processDataStore();
        }
        $this->btnBack = Utility::get($this->params,"btnBack",true);
        $this->title = Utility::get($this->params,"title","Drill-down report");
        $this->showLevelTitle = Utility::get($this->params,"showLevelTitle",true);
        $this->css = Utility::get($this->params,"css");
        $this->panelStyle = Utility::get($this->params,"panelStyle","default");
    }


    protected function POSTParamsBinding()
    {
        $post = Utility::get($_POST,$this->name);
        if($post)
        {
            $this->currentLevel = Utility::get($post,"currentLevel",array(0,array()));
            $this->partialRender = Utility::get($post,"partialRender",false);
            $this->scope = Utility::get($post,"scope",$this->scope);
        }
    }

    protected function onFurtherProcessRequest($node)
    {
        $this->processDataStoreRequired = false;
        $levelIndex = Utility::get($this->currentLevel,0);
        $levelParams = Utility::get($this->currentLevel,1,array());

        $filter = array();
        foreach($levelParams as $key=>$value)
        {
            array_push($filter,array($key,"=",$value));
        }
        $group = array_merge($this->calculate,array(
            "by"=>$this->levels[$levelIndex]["groupBy"]
        ));
        return $node->pipe(new Filter($filter))->pipe(new Group($group));
    }
    protected function processDataStore()
    {
        $levelIndex = Utility::get($this->currentLevel,0);
        $levelParams = Utility::get($this->currentLevel,1,array());
        $filter = array();
        foreach($levelParams as $key=>$value)
        {
            array_push($filter,array($key,"=",$value));
        }
        $group = array_merge($this->calculate,array(
            "by"=>$this->levels[$levelIndex]["groupBy"]
        ));
        $this->dataStore = $this->dataStore->process(
            (new Filter($filter))->pipe(new Group($group))
        );        
    }

    protected function getCurrentLevelTitle()
    {
        $levelIndex = $this->currentLevel[0];
        $levelParams = $this->currentLevel[1];

        $level = $this->levels[$levelIndex];
        $title = Utility::get($level,"title");
        if($title==null)
        {
            if($levelIndex>0)
            {
                $value = "";
                $key = Utility::get($this->levels[$levelIndex-1],"groupBy");
                if($key)
                {
                    $value = Utility::get($levelParams,$key);
                    return ucfirst("$key $value");
                }
                return "Level $levelIndex";
            }
            else
            {
                return "Top";
            }
        }
        else
        {
            if(is_callable($title))
            {
                return $title($levelParams);
            }
            return $title;
        }
    }

    protected function renderCurrentLevel()
    {
        $index = $this->currentLevel[0];
        $filter = ($this->currentLevel[1]!==array())?json_encode($this->currentLevel[1]):"{}";

        $groupBy = $this->levels[$index]["groupBy"];
   
        $widgetClass = $this->levels[$index]["widget"][0];
        $widgetParams = $this->levels[$index]["widget"][1];
        $widgetParams["dataStore"] = $this->dataStore;

        if(strpos($widgetClass,'\widgets\google'))
        {
            if(!isset($widgetParams["clientEvents"]))
            {
                $widgetParams["clientEvents"] = array();
            }
            $widgetParams["clientEvents"]["itemSelect"] = "function(params){
                var _filter = $filter;
                _filter['$groupBy'] = params.selectedRow[0];
                $this->name.next(_filter);
            }";
            $widgetParams["width"] = "100%";
        }
        else if(strpos($widgetClass,'\koolphp\Table'))
        {
            // Be continue after getting table to return the associate array of selected row
            
        }

        if($this->partialRender)
        {
            $widget = new $widgetClass($widgetParams);
            $widget->renderResources();
            $widget->render();
            echo "<script type='text/javascript'>";
            $title = $this->getCurrentLevelTitle();
            echo "$this->name.levelTitle('$title');";
            echo "</script>";    
        }
        else
        {
            $widgetClass::create($widgetParams);
        }
    }

    protected function onRender()
    {
        $levelIndex = Utility::get($this->currentLevel,0,0);
        
        if($this->partialRender)
        {
            echo "<!--drilldown-partial-start-->";
            $this->renderCurrentLevel();
            echo "<!--drilldown-partial-end-->";
        }
        else
        {
            $this->template(array(
                "levelIndex"=>$levelIndex,
                "options"=>array(
                    "totalLevels"=>count($this->levels),
                    "currentLevel"=>$this->currentLevel,
                    "scope"=>$this->scope,
                ),
            ));    
        }
    }
}