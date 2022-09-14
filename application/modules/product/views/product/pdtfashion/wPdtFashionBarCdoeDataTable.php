<table class="table" style="width:100%;">
    <thead>
        <tr>
            <th nowrap class="xCNTextBold"><?php echo language('product/product/product','tPDTViewPackMDSplBarCode')?></th>
            <th nowrap class="xCNTextBold"><?php echo language('product/product/product','tPDTTabPackSizeUnit')?></th>
            <!-- <th nowrap class="xCNTextBold"><?php echo language('product/product/product','tPDTUnitFact')?></th> -->
            <th nowrap class="xCNTextBold"><?php echo language('product/product/product','tPDTViewPackMDSplSupplier')?></th>
            <th nowrap class="xCNTextBold"><?php echo language('product/product/product','tPDTViewPackMDBarLocation')?></th>
            <th nowrap class="xCNTextBold"><?php echo language('product/product/product','tPDTTBDelete')?></th>
            <th nowrap class="xCNTextBold"><?php echo language('product/product/product','tPDTTBEdits')?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $nDecimalShow  =  FCNxHGetOptionDecimalShow();
         if(isset($raItems)){
             foreach($raItems AS $nKey => $aValue){
        ?>
            <tr>
                <td nowrap>
                    <?php echo $aValue['FTBarCode']; ?>
                    <input type="hidden" id="ohdFhnModalFTBarCode<?php echo $aValue['FTBarCode']; ?>" class="form-control" value="<?php echo $aValue['FTBarCode']; ?>">
                    <input type="hidden" id="ohdFhnModalFTPunCode<?php echo $aValue['FTBarCode']; ?>" class="form-control" value="<?php echo $aValue['FTPunCode']; ?>">
                    <input type="hidden" id="ohdFhnModalFTPunName<?php echo $aValue['FTBarCode']; ?>" class="form-control" value="<?php echo $aValue['FTPunName']; ?>">
                    <!-- <input type="hidden" id="ohdFhnModalFCPdtUnitFact<?php echo $aValue['FTBarCode']; ?>" class="form-control" value="<?php echo number_format($aValue['FCPdtUnitFact'],$nDecimalShow); ?>"> -->
                    <input type="hidden" id="ohdFhnModalFTPlcCode<?php echo $aValue['FTBarCode']; ?>" class="form-control" value="<?php echo $aValue['FTPlcCode']; ?>">
                    <input type="hidden" id="ohdFhnModalFTPlcName<?php echo $aValue['FTBarCode']; ?>" class="form-control" value="<?php echo $aValue['FTPlcName']; ?>">
                    <input type="hidden" id="ohdFhnModalFTSplCode<?php echo $aValue['FTBarCode']; ?>" class="form-control" value="<?php echo $aValue['FTSplCode']; ?>">
                    <input type="hidden" id="ohdFhnModalFTSplName<?php echo $aValue['FTBarCode']; ?>" class="form-control" value="<?php echo $aValue['FTSplName']; ?>">
                    <input type="hidden" id="ohdFhnModalFTSplStaAlwPO<?php echo $aValue['FTBarCode']; ?>" class="form-control" value="<?php echo $aValue['FTSplStaAlwPO']; ?>">
                    <input type="hidden" id="ohdFhnModalFTBarStaUse<?php echo $aValue['FTBarCode']; ?>" class="form-control" value="<?php echo $aValue['FTBarStaUse']; ?>">
                    <input type="hidden" id="ohdFhnModalFTBarStaAlwSale<?php echo $aValue['FTBarCode']; ?>" class="form-control" value="<?php echo $aValue['FTBarStaAlwSale']; ?>">
                </td>
                <td nowrap><?php echo $aValue['FTPunName']; ?></td>
                <!-- <td nowrap align="right"><?php echo number_format($aValue['FCPdtUnitFact'],$nDecimalShow); ?></td> -->
                <td nowrap><?php echo $aValue['FTSplName']; ?></td>
                <td nowrap><?php echo $aValue['FTPlcName']; ?></td>
                <td nowrap class="text-center"><img class="xCNIconTable xWPdtDelBarCodeItem xCNIconDelete" onclick="JSxFhnModalPdtBarCodeDelete('<?php echo $aValue['FTBarCode'];?>')"></td>
                <td nowrap class="text-center"><img class="xCNIconTable xCNIconEdit xWPdtBarCodeEdit" onclick="JSxFhnModalPdtBarCodeEdit('<?php echo $aValue['FTBarCode'];?>')"></td>
            </tr>
        <?php
             }
         }else{
        ?>
             <tr><td nowrap colspan="6" class="text-center"><?php echo language('product/product/product','tPDTViewPackMDMsgSplBarCodeNotFound')?></td></tr> 
        <?php
         }
        ?>
    </tbody>
</table>