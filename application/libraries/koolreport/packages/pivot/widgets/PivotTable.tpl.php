<?php 
use \koolreport\core\Utility;
$chClass = Utility::get($cssClass, "columnHeader", "");
if (is_string($chClass)) $chClass = function() use ($chClass) {return $chClass;};
$rhClass = Utility::get($cssClass, "rowHeader", "");
if (is_string($rhClass)) $rhClass = function() use ($rhClass) {return $rhClass;};
$dcClass = Utility::get($cssClass, "dataCell", "");
if (is_string($dcClass)) $dcClass = function() use ($dcClass) {return $dcClass;};
?>
<style>
.fa {
    cursor: pointer;
}
.pivot-row {
    white-space: nowrap;
}
</style>
<table id='<?=$uniqueId?>' class='pivot-table table table-bordered' style='width:<?= $width ?>; visibility: hidden'>
    <tbody>
        <?php $isTotalColumn = array_fill(0, count($colIndexes), false);
        foreach ($colFields as $i => $cf) { ?>
            <tr class='pivot-column'>
            <?php if ($i === 0) { ?>
                <td class='pivot-data-field-zone'
                    colspan=<?= count($rowFields); ?>
                    rowspan=<?= count($colFields); ?>>
                <?php echo implode(' | ', $dataNodes); ?>
                </td>
            <?php }
            
            foreach ($colIndexes as $c => $j) {
                $node = $colNodes[$j];
                $mappedNode = $mappedColNodes[$j];
                $nodeMark = $colNodesMark[$j];
                if (isset($nodeMark[$cf . '_colspan'])) { ?>
                    <td class="pivot-column-header 
                        <?php 
                            if ($mappedNode[$cf] === $totalName) {
                                echo ' pivot-column-header-total'; 
                                $isTotalColumn[$c] = true;
                            } 
                            echo ' ' . $chClass($cf,  $node[$cf]);
                        ?>"
                        data-column-field=<?=$i?>
                        data-column-index=<?=$c;?>
                        data-layer=1
                        rowspan=<?= $nodeMark[$cf . '_rowspan']; ?> 
                        colspan=<?= $nodeMark[$cf . '_colspan']; ?>>
                        <?php if ($i < count($colFields) - 1 
                            && $mappedNode[$cf] !== $totalName)  { ?>
                        <i class='fa fa-minus-square-o' aria-hidden='true'
                            onclick='expandCollapseColumn(this, <?= $uniqueId; ?>)'></i>
                        <?php } ?>
                        <?= $mappedNode[$cf]; ?>
                    </td>
                <?php }
            } ?>
            </tr>
            <?php
        }
        $isTotalRow = array_fill(0, count($rowIndexes), false);
        foreach($rowIndexes as $r => $i) {
            $node = $rowNodes[$i];
            $mappedNode = $mappedRowNodes[$i];
            $nodeMark = $rowNodesMark[$i]; ?>
            <tr class='pivot-row'>
                <?php 
                    foreach($rowFields as $j => $rf) {
                    if (isset($nodeMark[$rf . '_rowspan'])) { ?>
                        <td class='pivot-row-header 
                            <?php 
                                if ($mappedNode[$rf] === $totalName) {
                                    echo ' pivot-row-header-total'; 
                                    $isTotalRow[$r] = true;
                                }
                                echo ' ' . $rhClass($rf,  $node[$rf]);
                            ?>'
                            data-row-field=<?=$j?>
                            data-row-index=<?=$r?>
                            data-layer=1
                            rowspan=<?= $nodeMark[$rf . '_rowspan']; ?> 
                            colspan=<?= $nodeMark[$rf . '_colspan']; ?>>
                            <?php if ($j < count($rowFields) - 1 
                                && $mappedNode[$rf] !== $totalName)  { ?>
                            <i class='fa fa-minus-square-o' aria-hidden='true'
                                onclick='expandCollapseRow(this, <?=$uniqueId?>)'></i>
                            <?php } ?>
                            <?= $mappedNode[$rf]; ?>
                        </td>
                        <?php					
                    }
                }
                foreach ($colIndexes as $c => $j) 
                {
                    $dataRow = isset($indexToData[$i][$j]) ? 
                        $indexToData[$i][$j] : array();
                    $dataRowRaw = isset($indexToDataRaw[$i][$j]) ? 
                        $indexToDataRaw[$i][$j] : array();
                    foreach($dataFields as $df)
                    {
                        $value = isset($dataRowRaw[$df]) ? $dataRowRaw[$df] : null;
                        ?>
                        <td class='pivot-data-cell  
                            <?php 
                                if ($isTotalColumn[$c]) 
                                    echo ' pivot-data-cell-column-total';  
                                if ($isTotalRow[$r]) 
                                    echo ' pivot-data-cell-row-total';
                                echo ' ' . $dcClass($df, $value);
                            ?>' 
                            data-row-index=<?=$r;?>
                            data-column-index=<?=$c;?>
                            data-layer=1>
                            <?php 
                                echo isset($dataRow[$df]) ? 
                                    $dataRow[$df] : $emptyValue; ?>
                        </td>
                        <?php					
                    }
                }
                ?>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script type='text/javascript'>
    var rowCollapseLevels = <?php echo json_encode($rowCollapseLevels); ?>;
    rowCollapseLevels.sort(function(a,b){ return b-a;});
    var colCollapseLevels = <?php echo json_encode($colCollapseLevels); ?>;
    colCollapseLevels.sort(function(a,b){ return b-a;});
    var <?=$uniqueId?> = {
        id: "<?=$uniqueId?>",
        rowCollapseLevels: rowCollapseLevels,
        colCollapseLevels: colCollapseLevels,
        numRowFields: <?php echo count($rowFields); ?>,
        numColFields: <?php echo count($colFields); ?>,
        numDataFields: <?php echo count($dataFields); ?>,
    }
    initPivot(<?=$uniqueId?>);
</script>
