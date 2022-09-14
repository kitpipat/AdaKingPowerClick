<?php use \koolreport\core\Utility; ?>
<div id="<?php echo $this->name; ?>" style="<?php echo Utility::get($this->css,"panel"); ?>" class="custom-drilldown panel panel-<?php echo $this->panelStyle; ?>">
    <div class="panel-heading">
        <div class="pull-right">
            <?php
            if($this->btnBack)
            {
            ?>
            <button style="<?php echo Utility::get($this->css,"btnBack"); ?>" type="button" onclick="<?php echo $this->name ?>.back()" class="btnBack <?php echo Utility::get($this->btnBack,"class","btn btn-xs btn-primary") ?>"><?php echo Utility::get($this->btnBack,"text","Back") ?></button>
            <?php    
            }
            ?>
        </div>
        <span class="custom-drilldown-title" style="<?php echo Utility::get($this->css,"title"); ?>"><?php echo $this->title; ?></span>    
    </div>
    <div class="panel-body custom-drilldown-body" style="<?php echo Utility::get($this->css,"content"); ?>">
        <?php
        if($this->showLevelTitle)
        {
        ?>
            <ol class="breadcrumb"  style="<?php echo Utility::get($this->css,"levelTitle"); ?>"></ol>
        <?php    
        }
        ?>        
        <?php $this->report->subReport($this->subReports[0],array_merge($this->scope,array(
            "@drilldown"=>$this->name,
        ))); ?>
        <?php 
        for($i=1;$i<count($this->subReports);$i++)
        {
        ?>
            <sub-report id="<?php echo $this->subReports[$i]; ?>" name="<?php echo $this->subReports[$i]; ?>"></sub-report>
        <?php    
        }
        ?>    
    </div>
</div>
<script type="text/javascript">
    var <?php echo $this->name; ?> = new CustomDrillDown("<?php echo $this->name; ?>",<?php echo json_encode($options); ?>)
    <?php
    foreach($this->clientEvents as $event=>$function)
    {
    ?>
        <?php echo $this->name; ?>.on("<?php echo $event ?>",<?php echo $function; ?>);
    <?php
    }
    ?>
</script>