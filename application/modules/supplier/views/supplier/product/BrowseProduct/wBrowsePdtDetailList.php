
<?php foreach($aPdtDetailList as $Key=>$Value){?>
    <tr class="panel-collapse collapse in xWPdtlistDetail<?php echo $Value->FTPdtCode?>" data-pdtcode="<?php echo $Value->FTPdtCode?>" onclick="JSxPDTPushMultiSelection('<?php echo $Value->FTPdtCode?>','<?php echo $Value->FTPunCode?>','<?php echo $Value->FTBarCode?>',this);">
        <td class="text-left"></td>
        <td class="text-left"></td>
        <td class="text-left"><?php echo $Value->FTBarCode?></td>
        <td class="text-left"><?php echo $Value->FTPunName?></td>
        <td class="text-left"><?php echo '-'; ?></td>
        <td class="text-left"><?= $Value->FCPgdPriceRet != '' ? number_format($Value->FCPgdPriceRet, $nOptDecimalShow, '.', ' ') : '-' ?>   </td>
    </tr>
<?php } ?>