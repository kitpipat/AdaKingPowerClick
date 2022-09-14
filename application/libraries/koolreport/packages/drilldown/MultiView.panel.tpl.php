<?php
    use \koolreport\core\Utility;
    $css = Utility::get($this->options,"css");
?>
<div id="<?php echo $this->name; ?>" class="multiview panel panel-default" style="<?php echo Utility::get($css,"panel"); ?>">
    <div class="panel-heading">
        <span class="multiview-title"><?php echo $this->title; ?></span>
    </div>
    <div class="panel-body multiview-body" style="<?php echo Utility::get($css,"container"); ?>">
        <div class="multiview-header text-right" style="<?php echo Utility::get($css,"header"); ?>">
            <div class="btn-group" data-toggle="buttons">
            <?php
            foreach($this->views as $index=>$view)
            {
            ?>
                <label data-value="<?php echo $index; ?>" class="multiview-handler multiview-handler-<?php echo $index; ?> btn btn-sm btn-<?php echo Utility::get($this->options,"handlerStyle","primary") ?><?php echo ($index==$this->viewIndex)?" active":""; ?>">
                    <input  type="radio" autocomplete="off">
                    <?php echo $view["handler"]; ?>
                </label>
            <?php    
            }
            ?>
            </div>        
        </div>
        <div class="multiview-content" style="<?php echo Utility::get($css,"content"); ?>">
        <?php
        foreach($this->views as $index=>$view)
        {
        ?>
            <div class="multiview-widget multiview-widget-<?php echo $index; ?>" style="<?php echo ($index==$this->viewIndex)?"":"display:none;" ?>">
                <?php 
                    $widgets[$index]->render();
                ?>
            </div>
        <?php    
        }
        ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    var <?php echo $this->name; ?> = new MultiView("<?php echo $this->name; ?>",<?php echo json_encode($settings); ?>)
    <?php
    foreach($this->clientEvents as $event=>$function)
    {
    ?>
        <?php echo $this->name; ?>.on("<?php echo $event ?>",<?php echo $function; ?>);
    <?php
    }
    ?>
</script>