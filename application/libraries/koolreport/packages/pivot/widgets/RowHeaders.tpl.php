<div class='krpmRowHeaderZoneDiv'>
    <table class='table'>
        <tbody>
            <?php 
            $isTotalRow = array_fill(0, count($rowIndexes), -1);
            foreach($rowIndexes as $r => $i) {
                $mappedNode = $mappedRowNodes[$i];
                $node = $rowNodes[$i];
                $nodeMark = $rowNodesMark[$i]; ?>
                <tr class='krpmRow'>
                    <?php foreach ($rowFields as $j => $rf) {
                        if (isset($nodeMark[$rf . '_rowspan'])) { ?>
                            <td class='krpmRowHeader
                                <?php
                                    if ($mappedNode[$rf] === $totalName) {
                                        echo ' krpmRowHeaderTotal';
                                        $isTotalRow[$r] = $j;
                                    }
                                    echo ' ' . $rhClass($cf, $node[$rf]);
                                ?>'
                                data-row-field=<?=$j?>
                                data-row-index=<?=$r?>
                                data-row-layer=1
                                data-column-layer=1
                                data-page-layer=1
                                data-node = '<?= htmlspecialchars($node[$rf], ENT_QUOTES) ?>'
                                rowspan=<?= $nodeMark[$rf . '_rowspan']; ?> 
                                colspan=<?= $nodeMark[$rf . '_colspan']; ?>
                                style='display:none' >
                            <?php if ($j < count($rowFields) - 1 
                                && $mappedNode[$rf] !== $totalName)  { ?>
                                <i class='fa fa-minus-square-o' aria-hidden='true'
                                    onclick='KoolReport.<?=$uniqueId?>.expandCollapseRow(this);'></i>
                            <?php } ?>
                                <span class='krpmHeaderText' onclick='KoolReport.<?=$uniqueId?>.headerTextClicked(this)'>
                                    <?= $mappedNode[$rf]; ?>
                                </span>
                            </td>
                        <?php }   
                    } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>