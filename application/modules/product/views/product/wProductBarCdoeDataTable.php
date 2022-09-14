<table class="table" style="width:100%;">
    <thead>
        <tr>
            <th nowrap class="xCNTextBold text-center"><?php echo language('product/product/product','tPDTViewPackMDSplBarCode')?></th>
            <th nowrap class="xCNTextBold text-center"><?php echo language('product/product/product','tPDTViewPackMDSplSupplier')?></th>
            <th nowrap class="xCNTextBold text-center"><?php echo language('product/product/product','tPDTViewPackMDBarLocation')?></th>
            <th nowrap class="xCNTextBold text-center"><?php echo language('product/product/product','tPDTTBDelete')?></th>
            <th nowrap class="xCNTextBold text-center"><?php echo language('product/product/product','tPDTTBEdits')?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if(isset($raItems)){
            foreach($raItems AS $nKey => $aValue){
        ?>
            <tr>
                <td nowrap>
                    <?php 
                        echo $aValue['FTBarCode']; 
                        $tIDBarCode = htmlspecialchars(str_replace(' ','-',$aValue['FTBarCode']));
                    ?>
                    <input type="hidden" id="ohdModalFTBarCode<?=$tIDBarCode; ?>" class="form-control" value="<?php echo $aValue['FTBarCode']; ?>">
                    <input type="hidden" id="ohdModalFTPlcCode<?=$tIDBarCode; ?>" class="form-control" value="<?php echo $aValue['FTPlcCode']; ?>">
                    <input type="hidden" id="ohdModalFTPlcName<?=$tIDBarCode; ?>" class="form-control" value="<?php echo $aValue['FTPlcName']; ?>">
                    <input type="hidden" id="ohdModalFTSplCode<?=$tIDBarCode; ?>" class="form-control" value="<?php echo $aValue['FTSplCode']; ?>">
                    <input type="hidden" id="ohdModalFTSplName<?=$tIDBarCode; ?>" class="form-control" value="<?php echo $aValue['FTSplName']; ?>">
                    <input type="hidden" id="ohdModalFTSplStaAlwPO<?=$tIDBarCode; ?>" class="form-control" value="<?php echo $aValue['FTSplStaAlwPO']; ?>">
                    <input type="hidden" id="ohdModalFTBarStaUse<?=$tIDBarCode; ?>" class="form-control" value="<?php echo $aValue['FTBarStaUse']; ?>">
                    <input type="hidden" id="ohdModalFTBarStaAlwSale<?=$tIDBarCode; ?>" class="form-control" value="<?php echo $aValue['FTBarStaAlwSale']; ?>">
                </td>
                <td nowrap><?php echo $aValue['FTSplName']; ?></td>
                <td nowrap><?php echo $aValue['FTPlcName']; ?></td>
                <td nowrap class="text-center"><img class="xCNIconTable xWPdtDelBarCodeItem xCNIconDelete" onclick="JSxModalPdtBarCodeDelete('<?php echo $aValue['FTBarCode']; ?>')"></td>
                <td nowrap class="text-center"><img class="xCNIconTable xCNIconEdit xWPdtBarCodeEdit" onclick="JSxModalPdtBarCodeEdit('<?=$tIDBarCode;?>')"></td>
            </tr>
        <?php
            }
        }else{
        ?>
            <tr><td nowrap colspan="5" class="text-center"><?php echo language('product/product/product','tPDTViewPackMDMsgSplBarCodeNotFound')?></td></tr>
        <?php
        }
        ?>
    </tbody>
</table>