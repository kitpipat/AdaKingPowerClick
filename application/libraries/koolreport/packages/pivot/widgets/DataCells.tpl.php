<div class='krpmDataZoneDiv'>
    <table class='table'>
        <colgroup>
            <?php foreach ($colIndexes as $c => $j) { 
                foreach ($dataFields as $df) { ?>
                <col>
            <?php } } ?>
        </colgroup>
        <tbody>
            <?php foreach($rowIndexes as $r => $i) {
                // $node = $rowNodes[$i];
                // $nodeMark = $rowNodesMark[$i]; ?>
                <tr class='krpmRow  <?php if ($isTotalRow[$r] !== -1) 
                    echo ' krpmDataCellRowTotalTr'; ?>' style='display:none'>
                    <?php foreach ($colIndexes as $c => $j) {
                        $dataRowRaw = isset($indexToDataRaw[$i][$j]) ? 
                        $indexToDataRaw[$i][$j] : array();
                        $dataRow = isset($indexToData[$i][$j]) ? 
                            $indexToData[$i][$j] : array();
                        foreach($dataFields as $df) { 
                            $value = isset($dataRowRaw[$df]) ? $dataRowRaw[$df] : null;?>
                            <td class='krpmDataCell <?php
                                    if ($isTotalRow[$r] !== -1) echo ' krpmDataCellRowTotal';
                                    if ($isTotalColumn[$c] !== -1) echo ' krpmDataCellColumnTotal';
                                    echo ' ' . $dcClass($df, $value);
                                ?>' 
                                <?php
                                    if ($isTotalRow[$r] !== -1) 
                                        echo " data-row-field='$isTotalRow[$r]'";
                                    if ($isTotalColumn[$c] !== -1) 
                                        echo " data-column-field='$isTotalColumn[$c]'";
                                ?>
                                data-row-index=<?=$r;?>
                                data-column-index=<?=$c;?>
                                data-row-layer=1
                                data-column-layer=1
                                data-page-layer=1
                                style='display:none' >
                            <?php 
                                echo isset($dataRow[$df]) ? 
                                $dataRow[$df] : $emptyValue; ?>
                            </td>
                        <?php } ?>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>