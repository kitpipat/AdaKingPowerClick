<div class='krpmColumnHeaderZoneDiv'>
    <table class='table'>
        <colgroup>
            <?php 
                $numDf = count($dataFields);
                foreach ($colIndexes as $c => $j) { 
                    foreach ($dataFields as $df) { ?>
                        <col>
                    <?php }
                } 
            ?>
        </colgroup>
        <tbody>
            <?php $isTotalColumn = array_fill(0, count($colIndexes), -1);
            foreach ($colFields as $i => $cf) { ?>
                <tr>
                    <?php foreach ($colIndexes as $c => $j) {
                        $node = $colNodes[$j];
                        $mappedNode = $mappedColNodes[$j];
                        $nodeMark = $colNodesMark[$j];
                        if (isset($nodeMark[$cf . '_colspan'])) { ?>
                            <td class='krpmColumnHeader
                                <?php
                                    if ($mappedNode[$cf] === $totalName) {
                                        echo ' krpmColumnHeaderTotal';
                                        $isTotalColumn[$c] = $i;
                                    }
                                    echo ' ' . $chClass($cf, $node[$cf]);
                                ?>'
                                data-column-field=<?=$i?>
                                data-column-index=<?=$c;?>
                                data-column-layer=1
                                data-row-layer=1
                                data-page-layer=1
                                data-node = '<?= htmlspecialchars($node[$cf], ENT_QUOTES) ?>'
                                rowspan=<?= $nodeMark[$cf . '_rowspan']; ?> 
                                colspan=<?= $nodeMark[$cf . '_colspan']; ?>>
                                <?php if ($i < count($colFields) - 1 
                                    && $mappedNode[$cf] !== $totalName)  { ?>
                                <i class='fa fa-minus-square-o' aria-hidden='true'
                                    onclick='KoolReport.<?=$uniqueId?>.expandCollapseColumn(this)'></i>
                                <?php } ?>
                                <span class='krpmHeaderText' onclick='KoolReport.<?=$uniqueId?>.headerTextClicked(this)'>
                                    <?= $mappedNode[$cf]; ?>
                                </span>
                            </td>
                        <?php } ?>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>