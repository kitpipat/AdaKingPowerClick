<table class="table">
    <thead>
        <tr>
            <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product','tPDTEvnCode')?></th>
            <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product','tPDTEvnType')?></th>
            <th nowrap class="text-center xCNTextBold" style="width:20%;"><?php echo language('product/product/product','tPDTEvnName')?></th>
            <th nowrap class="text-center xCNTextBold" style="width:15%;"><?php echo language('product/product/product','tPDTEvnDateStart')?></th>
            <th nowrap class="text-center xCNTextBold" style="width:15%;"><?php echo language('product/product/product','tPDTEvnTimeStart')?></th>
            <th nowrap class="text-center xCNTextBold" style="width:15%;"><?php echo language('product/product/product','tPDTEvnDateStop')?></th>
            <th nowrap class="text-center xCNTextBold" style="width:15%;"><?php echo language('product/product/product','tPDTEvnTimeStop')?></th>
        </tr>
    </thead>
    <tbody>
        <?php if(is_array($aDataList) && $aDataList['rtCode'] == 1):?>
            <?php $tEvnCode = "";?>
            <?php foreach($aDataList['raItems'] AS $key => $aValue):?>
                <?php if($tEvnCode != $aValue['FTEvnCode']): ?>
                    <?php $tEvnCode = $aValue['FTEvnCode'];?>
                    <tr class="xWEvnNotSaleRow">
                        <td nowrap class="text-center"><?php echo $aValue['FTEvnCode']?></td>
                        <td nowrap class="text-center">
                            <?php echo ($aValue['FTEvnType'] == 1)? language('product/product/product','tPDTEvnNotSaleLangTime') : language('product/product/product','tPDTEvnNotSaleLangDate') ?>
                        </td>
                        <td nowrap class="text-left"><?php echo $aValue['FTEvnName']?></td>
                        <td nowrap class="text-center"><?php echo ($aValue['FTEvnType'] == 1)? '-' : date("Y-m-d",strtotime($aValue['FDEvnDStart']))?></td>
                        <td nowrap class="text-center"><?php echo ($aValue['FTEvnType'] == 1)? date("H:i:s",strtotime($aValue['FTEvnTStart'])) : '-'?></td>
                        <td nowrap class="text-center"><?php echo ($aValue['FTEvnType'] == 1)? '-' : date("Y-m-d",strtotime($aValue['FDEvnDFinish']))?></td>
                        <td nowrap class="text-center"><?php echo ($aValue['FTEvnType'] == 1)? date("H:i:s",strtotime($aValue['FTEvnTFinish'])) : '-'?></td>
                    </tr>
                <?php else: ?>
                    <tr class="xWEvnNotSaleRow">
                        <td nowrap class="text-center"></td>
                        <td nowrap class="text-center">
                            <?php echo ($aValue['FTEvnType'] == 1)? language('product/product/product','tPDTEvnNotSaleLangTime') : language('product/product/product','tPDTEvnNotSaleLangDate') ?>
                        </td>
                        <td nowrap class="text-left"><?php echo $aValue['FTEvnName']?></td>
                        <td nowrap class="text-center"><?php echo ($aValue['FTEvnType'] == 1)? '-' : date("Y-m-d",strtotime($aValue['FDEvnDStart']))?></td>
                        <td nowrap class="text-center"><?php echo ($aValue['FTEvnType'] == 1)? date("H:i:s",strtotime($aValue['FTEvnTStart'])) : '-'?></td>
                        <td nowrap class="text-center"><?php echo ($aValue['FTEvnType'] == 1)? '-' : date("Y-m-d",strtotime($aValue['FDEvnDFinish']))?></td>
                        <td nowrap class="text-center"><?php echo ($aValue['FTEvnType'] == 1)? date("H:i:s",strtotime($aValue['FTEvnTFinish'])) : '-'?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach;?>
        <?php else: ?>
            <tr class="xWPdtEvnNoSaleNoData"><td class="text-center xCNTextDetail2" colspan="99"><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
        <?php endif; ?> 
    </tbody>
</table>


