<?php
	use \koolreport\core\Utility;
	$tableCss = Utility::get($this->cssClass,"table");
	$trClass = Utility::get($this->cssClass,"tr");
	$tdClass = Utility::get($this->cssClass,"td");
	$thClass = Utility::get($this->cssClass,"th");
	$tfClass = Utility::get($this->cssClass,"tf");
?>
<table id="<?php echo $this->name; ?>" 
<?php echo ($tableCss)?" class='$tableCss'":" class='table display'"; ?> >
    <thead>
        <tr>
        <?php
        foreach($showColumnKeys as $cKey)
        {
            $cMeta = Utility::get($meta["columns"],$cKey);
            $label = Utility::get($cMeta?$cMeta:array(),"label",$cKey);
        ?>
            <th <?php if($thClass){echo " class='".((gettype($thClass)=="string")?$thClass:$thClass($cKey))."'";} ?>>
                <?php echo $label; ?>
            </th>
        <?php    
        }
        ?>  
        </tr>  
    </thead>
    <tbody>
        <?php
        $this->dataStore->popStart();
        while($row = $this->dataStore->pop())
        {
            $i=$this->dataStore->getPopIndex();
        ?>
            <tr <?php if($trClass){echo " class='".((gettype($trClass)=="string")?$trClass:$trClass($row))."'";} ?>>
            <?php
            foreach($showColumnKeys as $cKey)
            {
            ?>
                <td <?php if($tdClass){echo "class='".((gettype($tdClass)=="string")?$tdClass:$tdClass($row,$cKey))."'";} ?>>
                    <?php echo $this->formatValue(($cKey!=="#")?$row[$cKey]:($i+$meta["columns"][$cKey]["start"]),$meta["columns"][$cKey],$row);?>
                </td>
            <?php    
            }
            ?>    
            </tr>
        <?php    
        }
        ?>
    </tbody>
    <?php
    if($this->showFooter)
    {
    ?>
    <tfoot>
        <tr>
            <?php
            foreach($showColumnKeys as $cKey)
            {
            ?>
                <td <?php if($tfClass){echo " class='".((gettype($tfClass)=="string")?$tfClass:$tfClass($cKey))."'";} ?>>
                <?php
                $footerMethod = strtolower(Utility::get($meta["columns"][$cKey],"footer"));
                $footerText = Utility::get($meta["columns"][$cKey],"footerText");
                $footerValue = null;
                switch($footerMethod)
                {
                    case "sum":
                    case "min":
                    case "max":
                    case "avg":
                        $footerValue = $this->dataStore->$footerMethod($cKey);
                    break;
                    case "count":
                        $footerValue = $this->dataStore->countData();
                    break;
                }
                $footerValue = ($footerValue)?$this->formatValue($footerValue,$meta["columns"][$cKey]):"";
                if($footerText)
                {
                    echo str_replace("@value",$footerValue,$footerText);
                }
                else
                {
                    echo $footerValue;
                }
                ?>
                </td>
            <?php    
            }
            ?>
        </tr>
    </tfoot>
    <?php
    }
    ?>
</table>
<script type="text/javascript">
    <?php echo $this->name; ?> = $('#<?php echo $this->name; ?>').DataTable(<?php echo ($this->options==array())?"":json_encode($this->options); ?>);
    <?php
    if($this->clientEvents)
    {
        foreach($this->clientEvents as $eventName=>$function)
        {
        ?>
            <?php echo $this->name; ?>.on("<?php echo $eventName; ?>",<?php echo $function; ?>)
        <?php    
        }
    }
    ?>
</script>