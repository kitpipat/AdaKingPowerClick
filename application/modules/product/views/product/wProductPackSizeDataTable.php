<style>
    .xWEditInlineElement {
        text-align: right !important;
    }
</style>

<?php
if (isset($aDataUnitPackSize)) {
    $tPdtPriceRet   =   "";
    $tPdtPriceWhs   =   "";
    $tPdtPriceNet   =   "";
} else {
    $tPdtPriceRet   =   0;
    $tPdtPriceWhs   =   0;
    $tPdtPriceNet   =   0;
}
?>
<?php
$tPunCode = "";
$tPunName = "";
if (isset($aDataUnitPackSize['raItems'])) {
    foreach ($aDataUnitPackSize['raItems'] as $nKey => $aValue) {
        if ($tPunCode == "") {
            $tPunCode = $aValue['FTPunCode'];
            $tPunName = $aValue['FTPunName'];
        } else {
            $tPunCode = $tPunCode . "," . $aValue['FTPunCode'];
            $tPunName = $tPunName . "," . $aValue['FTPunName'];
        }
    }
}
?>
<input type="hidden" id="ohdPdtUnitCode" class="form-control" value="<?php echo $tPunCode; ?>">
<input type="hidden" id="ohdPdtUnitName" class="form-control" value="<?php echo $tPunName; ?>">

<?php
//Decimal Show ลง 2 ตำแหน่ง
$nDecShow =  FCNxHGetOptionDecimalShow();
if($nPdtForSystem=='5'){
    $tHideClass4PdtFahsion = 'xCNHide';
}else{
    $tHideClass4PdtFahsion = ''; 
}
?>
<table class="table xWTablePackSize" id="otbTablePackSize">
    <thead>
        <tr>
            <th nowrap class="text-center xCNTextBold" style="width:15%;"><?php echo language('product/product/product', 'tPDTViewPackUnit') ?></th>
            <th nowrap class="text-center xCNTextBold" style="width:15%;"><?php echo language('product/product/product', 'tPDTUnitFact') ?></th>
            <th nowrap class="text-center xCNTextBold xWPDTViewPackBarcode <?=$tHideClass4PdtFahsion?>" style="width:15%;"><?php echo language('product/product/product', 'tPDTViewPackBarcode') ?></th>
            <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product', 'tPDTViewPackPriRet') ?></th>

            <?php if ($aAlwEventPdt['tAutStaFull'] == 1 || $aAlwEventPdt['tAutStaDelete'] == 1) : ?>
                <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/product/product', 'tPDTViewPackDelUnit') ?></th>
            <?php endif; ?>
            <th class="xWDeleteBtnEditButton"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($aDataUnitPackSize['raItems'])) {
            foreach ($aDataUnitPackSize['raItems'] as $nKey => $aValue) {
        ?>
                <tr id="otrPdtDataUnitRow<?php echo $aValue['FTPunCode']; ?>" class="xWPdtPackSizeRow xWPdtDataUnitRow" data-puncode="<?php echo $aValue['FTPunCode']; ?>" data-punname="<?php echo $aValue['FTPunName']; ?>" data-pdtcode="<?php echo $aValue['FTPdtCode']; ?>">
                    <td nowrap class="xCNBorderRight">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                            <input type="hidden" class="form-control xWPdtBarCode" id="ohdPdtBarCodeRow<?php echo $aValue['FTPunCode']; ?>" value="<?php echo $aValue['nCountBarCode']; ?>">
                            <input type="hidden" class="form-control xWPdtPunCode" id="ohdPdtPunCodeRow<?php echo $aValue['FTPunCode']; ?>" value="<?php echo $aValue['FTPunCode']; ?>">
                            <input type="hidden" class="form-control xWPdtGrade" id="ohdPdtGrandRow<?php echo $aValue['FTPunCode']; ?>" value="<?php echo $aValue['FTPdtGrade']; ?>">
                            <input type="hidden" class="form-control xWPdtWeight" id="ohdPdtWeightRow<?php echo $aValue['FTPunCode']; ?>" value="<?php echo number_format($aValue['FCPdtWeight'], $nDecShow); ?>">
                            <input type="hidden" class="form-control xWPdtClrCode" id="ohdPdtClrCodeRow<?php echo $aValue['FTPunCode']; ?>" value="<?php echo $aValue['FTClrCode']; ?>">
                            <input type="hidden" class="form-control xWPdtClrName" id="ohdPdtClrNameRow<?php echo $aValue['FTPunCode']; ?>" value="<?php echo $aValue['FTClrName']; ?>">
                            <input type="hidden" class="form-control xWPdtSizeCode" id="ohdPdtSizeCodeRow<?php echo $aValue['FTPunCode']; ?>" value="<?php echo $aValue['FTPszCode']; ?>">
                            <input type="hidden" class="form-control xWPdtSizeName" id="ohdPdtSizeNameRow<?php echo $aValue['FTPunCode']; ?>" value="<?php echo $aValue['FTPszName']; ?>">
                            <input type="hidden" class="form-control xWPdtUnitDim" id="ohdPdtUnitDimRow<?php echo $aValue['FTPunCode']; ?>" value="<?php echo $aValue['FTPdtUnitDim']; ?>">
                            <input type="hidden" class="form-control xWPdtPkgDim" id="ohdPdtPkgDimRow<?php echo $aValue['FTPunCode']; ?>" value="<?php echo $aValue['FTPdtPkgDim']; ?>">
                            <input type="hidden" class="form-control xWPdtStaAlwPick" id="ohdPdtStaAlwPickRow<?php echo $aValue['FTPunCode']; ?>" value="<?php echo $aValue['FTPdtStaAlwPick']; ?>">
                            <input type="hidden" class="form-control xWPdtStaAlwPoHQ" id="ohdPdtStaAlwPoHQRow<?php echo $aValue['FTPunCode']; ?>" value="<?php echo $aValue['FTPdtStaAlwPoHQ']; ?>">
                            <input type="hidden" class="form-control xWPdtStaAlwBuy" id="ohdPdtStaAlwBuyRow<?php echo $aValue['FTPunCode']; ?>" value="<?php echo $aValue['FTPdtStaAlwBuy']; ?>">
                            <input type="hidden" class="form-control xPdtStaAlwSale" id="ohdPdtStaAlwSaleRow<?php echo $aValue['FTPunCode']; ?>" value="<?php echo $aValue['FTPdtStaAlwSale']; ?>">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                                    <label><?php echo $aValue['FTPunName']; ?></label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <img style="float:right; margin-top:5px;" class="xCNIconTable xCNIconEdit xWPdtCallPageEdit xWMngPackSizeUnit" onclick="JSxPdtMngPszUnitInTable(this)">
                                </div>
                            </div>
                        </div>
                    </td>
                    <td nowrap class="text-right">
                        <label  class="xWShowInLine xCNInputNumericWithoutDecimal" dataPDT="<?php if (isset($aValue['FTPdtCode']) && $aValue['FTPdtCode'] != "") {
                                                                    echo $aValue['FTPdtCode'];
                                                                } else {
                                                                    echo 'NULL';
                                                                } ?>" dataPUN="<?php echo $aValue['FTPunCode']; ?>">
                            <?php echo number_format($aValue['FCPdtUnitFact'], $nDecShow); ?>
                        </label>
                        <div class="xWEditInLine xCNHide">
                            <input style="text-align: right !important;" type="text" class="form-control text-right xCNInputNumericWithoutDecimal xWPdtUnitFact" id="oetPdtUnitFact<?php echo $aValue['FTPunCode']; ?>" name="oetPdtUnitFact<?php echo $aValue['FTPunCode']; ?>" placeholder="<?php echo language('product/product/product', 'tPDTViewPackUnitFact'); ?>" autocomplete="off" value="<?php echo number_format($aValue['FCPdtUnitFact'], $nDecShow); ?>">
                        </div>
                    </td>
                    <td nowrap class="xWPDTViewPackBarcode <?=$tHideClass4PdtFahsion?>">
                        <?php $aData = array(
                            'FTMttTableKey'     => 'TCNMPdt',
                            'FTMttRefKey'       => 'TCNMPdtBar',
                            'FTPdtCode'         => $aValue['FTPdtCode'],
                            'FTPunCode'         => $aValue['FTPunCode'],
                            'FTMttSessionID'    => $this->session->userdata("tSesSessionID")
                        );

                        $aDataPdtBarCode            = $this->mProduct->FSaMPDTGetDataTableBarCodeByID($aData); ?>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">

                                    <?php
                                    
                                    if ($aDataPdtBarCode['rtCode']  == 1) {
                                        for($i=0; $i<count($aDataPdtBarCode['raItems']); $i++){
                                            echo '<p>' . $aDataPdtBarCode['raItems'][$i]['FTBarCode'] . '</p>';

                                            //โชว์เส้นคั้น
                                            if($i != count($aDataPdtBarCode['raItems']) - 1){
                                                echo '<hr style="margin: 0px;">';
                                            }
                                        }
                                    }

                                    ?>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                                    <label style="float:right; margin-top:5;" onclick="JSxPdtCallModalAddEditBardCode(this,'Add')" class="xCNTextLink xWAddBarPszUnit">
                                        <i class="fa fa-plus"></i> <?php echo language('product/product/product', 'tPDTViewPackMngBarCode'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </td>
                    <td nowrap class="xWTdPdtPriceRet text-right">
                        <label><?php echo number_format($aValue['FCPgdPriceRet'], $nDecShow); ?></label>
                    </td>

                    <?php if ($aAlwEventPdt['tAutStaFull'] == 1 || $aAlwEventPdt['tAutStaDelete'] == 1) : ?>
                        <td nowrap class="text-center">
                            <img onclick="JSxPdtDelPszUnitInTable(1,'<?= $aValue['FTPunCode']; ?>')" class="xCNIconTable xWPdtDelUnitPackSize" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>">
                        </td>
                    <?php endif; ?>
                    <td></td>
                </tr>
            <?php
            }
        } else {
            ?>
            <tr>
                <td nowrap colspan="7" class="text-center xWTextNotfoundDataTablePdt"><?php echo language('product/product/product', 'tPDTViewPackMDMsgSplBarCodeNotFound') ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
