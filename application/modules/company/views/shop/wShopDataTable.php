<?php
if ($aDataList['rtCode'] == '1') {
    $nCurrentPage = $aDataList['rnCurrentPage'];
} else {
    $nCurrentPage = '1';
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <?php if ($aAlwEventShop['tAutStaFull'] == 1 || $aAlwEventShop['tAutStaDelete'] == 1) : ?>
                            <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('company/shop/shop', 'tSHPTBChoose') ?></th>
                        <?php endif; ?>
                        <th nowrap class="xCNTextBold" style="width:10%; text-align:center;"><?php echo language('company/shop/shop', 'tSHPTBCode') ?></th>
                        <th nowrap class="xCNTextBold" style="width:15%; text-align:center;"><?php echo language('company/shop/shop', 'tSHPTBName') ?></th>
                        <th nowrap class="xCNTextBold" style="width:10%; text-align:center;"><?php echo language('company/shop/shop', 'tSHPTBType') ?></th>
                        <th nowrap class="xCNTextBold" style="width:20%; text-align:center;"><?php echo language('company/shop/shop', 'tSHPTBBranch') ?></th>
                        <!-- Head Edit Pos Shop -->
                        <?php if ($aAlwEventShop['tAutStaFull'] == 1 || ($aAlwEventShop['tAutStaEdit'] == 1 || $aAlwEventShop['tAutStaRead'] == 1)) : ?>
                            <!-- <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('company/shop/shop', 'tSHPTBPOSSHOP') ?></th> -->
                        <?php endif; ?>
                        <!-- Head Edit Vending LayOut -->
                        <?php if ($aAlwEventShop['tAutStaFull'] == 1 || ($aAlwEventShop['tAutStaEdit'] == 1 || $aAlwEventShop['tAutStaRead'] == 1)) : ?>
                            <!-- <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('company/shop/shop', 'tSHPTBVDLayOut') ?></th> -->
                        <?php endif; ?>
                        <!-- Head Edit GP By PDT -->
                        <?php if ($aAlwEventShop['tAutStaFull'] == 1 || ($aAlwEventShop['tAutStaEdit'] == 1 || $aAlwEventShop['tAutStaRead'] == 1)) : ?>
                            <!-- <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('company/shop/shop', 'tSHPTBGPByPdt') ?></th> -->
                        <?php endif; ?>
                        <!-- Head Edit GP By SHP -->
                        <?php if ($aAlwEventShop['tAutStaFull'] == 1 || ($aAlwEventShop['tAutStaEdit'] == 1 || $aAlwEventShop['tAutStaRead'] == 1)) : ?>
                            <!-- <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('company/shop/shop', 'tSHPTBGPByShop') ?></th> -->
                        <?php endif; ?>
                        <!-- Head Delete Shop -->
                        <?php if ($aAlwEventShop['tAutStaFull'] == 1 || $aAlwEventShop['tAutStaDelete'] == 1) : ?>
                            <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('company/shop/shop', 'tSHPTBDelete') ?></th>
                        <?php endif; ?>
                        <!-- Head Edits Shop -->
                        <?php if ($aAlwEventShop['tAutStaFull'] == 1 || ($aAlwEventShop['tAutStaEdit'] == 1 || $aAlwEventShop['tAutStaRead'] == 1)) : ?>
                            <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('company/shop/shop', 'tSHPTBEdit') ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if ($aDataList['rtCode'] == 1) : ?>
                        <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                            <?php
                            if ($tNameMenuGroup == 'LAYOUT') {
                                if ($aValue['SUMSTK'] != null) {
                                    $tCheckboxDisabled = "disabled";
                                    $tClassDisabled     = "xCNDocDisabled";
                                    $tOnclick           = "";
                                } else {
                                    $tCheckboxDisabled = "";
                                    $tClassDisabled     = "";
                                }
                            } else {
                                $tCheckboxDisabled = "";
                                $tClassDisabled         = "";
                            }
                            ?>

                            <tr class="text-center xCNTextDetail2 otrShop" id="otrShop<?php echo $key ?>" data-code="<?php echo $aValue['rtShpCode'] ?>" data-name="<?php echo $aValue['rtShpName'] ?>">
                                <?php if ($aAlwEventShop['tAutStaFull'] == 1 || $aAlwEventShop['tAutStaDelete'] == 1) : ?>
                                    <td nowrap class="text-center">
                                        <label class="fancy-checkbox">
                                            <input id="ocbListItem<?php echo $key ?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?= $tCheckboxDisabled ?>>
                                            <span class="<?= $tClassDisabled ?>">&nbsp;</span>
                                        </label>
                                    </td>
                                <?php endif; ?>
                                <td nowrap class="text-left"><?php echo $aValue['rtShpCode'] ?></td>
                                <td nowrap class="text-left"><?php echo $aValue['rtShpName'] ?></td>
                                <?php
                                $ShpType = "";
                                switch ($aValue['rtShpType']) {
                                    case 1:
                                        $ShpType = language('company/shop/shop', 'tShpType1');
                                        break;
                                    case 2:
                                        $ShpType = language('company/shop/shop', 'tShpType2');
                                        break;
                                    case 3:
                                        $ShpType = language('company/shop/shop', 'tShpType3');
                                        break;
                                    case 4:
                                        $ShpType = language('company/shop/shop', 'tShpType4');
                                        break;
                                    case 5:
                                        $ShpType = language('company/shop/shop', 'tShpType5');
                                        break;
                                    case 6:
                                        $ShpType = language('company/shop/shop', 'tShpType6');
                                        break;
                                    default:
                                        $ShpType = 'N/A';
                                }
                                // if( $aValue['rtShpType'] == 1 ) 
                                //     $ShpType = language('company/shop/shop', 'tShpType1');
                                // else if( $aValue['rtShpType'] == 2 )
                                //     $ShpType = language('company/shop/shop', 'tShpType2');
                                // else if( $aValue['rtShpType'] == 3 )
                                //     $ShpType = language('company/shop/shop', 'tShpType3');
                                // else if( $aValue['rtShpType'] == 4 )
                                //     $ShpType = language('company/shop/shop', 'tShpType4');
                                // else if( $aValue['rtShpType'] == 5 )
                                //     $ShpType = language('company/shop/shop', 'tShpType5');
                                // else
                                //     $ShpType = 'N/A';
                                ?>
                                <td nowrap class="text-left"><?php echo $ShpType; ?></td>
                                <td nowrap class="text-left"><?php echo $aValue['rtBchName'] ?></td>
                                <!-- Edit Manage POS SHOP -->
                                <?php if ($aAlwEventShop['tAutStaFull'] == 1 || ($aAlwEventShop['tAutStaEdit'] == 1 || $aAlwEventShop['tAutStaRead'] == 1)) : ?>
                                    <!-- <td nowrap class="text-center">
                                <button class="btn xCNBTNDefult xCNBTNDefult1Btn xWBtnSetPOSSHOP" data-bchcode="<?php echo $aValue['rtBchCode'] ?>" data-shpcode="<?php echo $aValue['rtShpCode']; ?>" data-npage="<?php echo $nPage; ?>" data-shpname="<?php echo $aValue['rtShpName'] ?>">
                                    <?php echo language('company/shop/shop', 'tSHPBTNSet') ?>
                                </button>
                            </td> -->
                                <?php endif; ?>
                                <!-- Edit Manage Vending LayOut -->
                                <?php if ($aAlwEventShop['tAutStaFull'] == 1 || ($aAlwEventShop['tAutStaEdit'] == 1 || $aAlwEventShop['tAutStaRead'] == 1)) : ?>
                                    <!-- <td nowrap class="text-center">
                                <button class="btn xCNBTNDefult xCNBTNDefult1Btn xWBtnSetVDLayOut" data-bchcode="<?php echo $aValue['rtBchCode'] ?>" data-shpcode="<?php echo $aValue['rtShpCode']; ?>">
                                    <?php echo language('company/shop/shop', 'tSHPBTNSet') ?>
                                </button>
                            </td> -->
                                <?php endif; ?>
                                <!-- Edit Manage GP PDT -->
                                <?php if ($aAlwEventShop['tAutStaFull'] == 1 || ($aAlwEventShop['tAutStaEdit'] == 1 || $aAlwEventShop['tAutStaRead'] == 1)) : ?>
                                    <!-- <td nowrap class="text-center">
                                <button class="btn xCNBTNDefult xCNBTNDefult1Btn xWBtnSetGPPdt" data-bchcode="<?php echo $aValue['rtBchCode'] ?>" data-shpcode="<?php echo $aValue['rtShpCode']; ?>" data-shpname="<?php echo $aValue['rtShpName'] ?>"  data-npage="<?php echo $nPage; ?>">
                                    <?php echo language('company/shop/shop', 'tSHPBTNSet') ?>
                                </button>
                            </td> -->
                                <?php endif; ?>
                                <!-- End Manage GP PDT -->
                                <!-- Edit Manage GP SHOP -->
                                <?php if ($aAlwEventShop['tAutStaFull'] == 1 || ($aAlwEventShop['tAutStaEdit'] == 1 || $aAlwEventShop['tAutStaRead'] == 1)) : ?>
                                    <!-- <td nowrap class="text-center">
                                <button class="btn xCNBTNDefult xCNBTNDefult1Btn xWBtnSetGPShp" data-bchcode="<?php echo $aValue['rtBchCode'] ?>" data-shpcode="<?php echo $aValue['rtShpCode']; ?>" data-npage="<?php echo $nPage; ?>">
                                    <?php echo language('company/shop/shop', 'tSHPBTNSet') ?>
                                </button>
                            </td> -->
                                <?php endif; ?>
                                <!-- End Manage GP SHOP -->

                                <!-- Delete Shop -->
                                <?php if ($aAlwEventShop['tAutStaFull'] == 1 || $aAlwEventShop['tAutStaDelete'] == 1) : ?>

                                    <?php
                                    if ($tNameMenuGroup == 'LAYOUT') {
                                        if ($aValue['SUMSTK'] != null) {
                                            $tClassDisabled     = "xCNDocDisabled";
                                            $tOnclick           = "";
                                        } else {
                                            $tClassDisabled     = "";
                                            $tOnclick           = 'onclick=JSoShopDeleteSingle("' . $nCurrentPage . '","' . $aValue['rtShpCode'] . '","' . str_replace(" ", "-", $aValue['rtShpName']) . '","' . $aValue['rtBchCode'] . '")';
                                        }
                                    } else {
                                        $tClassDisabled         = "";
                                        $tOnclick               = 'onclick=JSoShopDeleteSingle("' . $nCurrentPage . '","' . $aValue['rtShpCode'] . '","' . str_replace(" ", "-", $aValue['rtShpName']) . '","' . $aValue['rtBchCode'] . '")';
                                    }
                                    ?>
                                    <td nowrap class="text-center">
                                        <img class="xCNIconTable xCNIconDelete <?= $tClassDisabled ?>" <?= $tOnclick ?>>
                                    </td>
                                <?php endif; ?>

                                <!-- Edit Shop -->
                                <?php if ($aAlwEventShop['tAutStaFull'] == 1 || ($aAlwEventShop['tAutStaEdit'] == 1 || $aAlwEventShop['tAutStaRead'] == 1)) : ?>
                                    <td nowrap class="text-center"><img class="xCNIconTable" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>" onClick="JSvSHPEditPage('<?php echo $aValue['rtBchCode'] ?>','<?php echo $aValue['rtShpCode'] ?>')"></td>
                                <?php endif; ?>
                            </tr>
                        <?php } ?>
                    <?php else : ?>
                        <tr>
                            <td class='text-center xCNTextDetail2' colspan='7'><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main', 'tResultTotalRecord') ?> <?php echo $aDataList['rnAllRow'] ?> <?php echo language('common/main/main', 'tRecord') ?> <?php echo language('common/main/main', 'tCurrentPage') ?> <?php echo $aDataList['rnCurrentPage'] ?> / <?php echo $aDataList['rnAllPage'] ?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWSHPPaging btn-toolbar pull-right">
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSvSHPClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for ($i = max($nPage - 2, 1); $i <= max(0, min($aDataList['rnAllPage'], $nPage + 2)); $i++) { ?>
                <?php
                if ($nPage == $i) {
                    $tActive = 'active';
                    $tDisPageNumber = 'disabled';
                } else {
                    $tActive = '';
                    $tDisPageNumber = '';
                }
                ?>
                <button onclick="JSvSHPClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aDataList['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvSHPClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<script type="text/javascript">
    var tSHPMsgUseGPShp = '<?php echo language("company/shop/shop", "tSHPMsgUseGPShp"); ?>';
    var tSHPMsgUseGPPdt = '<?php echo language("company/shop/shop", "tSHPMsgUseGPPdt"); ?>';

    // Select List Shop Table Item
    $('.ocbListItem').unbind().click(function() {
        var nCode = $(this).parent().parent().parent().data('code'); //code
        var tName = $(this).parent().parent().parent().data('name'); //Name
        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if (LocalItemData) {
            obj = JSON.parse(LocalItemData);
        } else {}
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert == '' || aArrayConvert == null) {
            obj.push({
                "nCode": nCode,
                "tName": tName
            });
            localStorage.setItem("LocalItemData", JSON.stringify(obj));
            JSxShopPaseCodeDelInModal();
        } else {
            var aReturnRepeat = findObjectByKey(aArrayConvert[0], 'nCode', nCode);
            if (aReturnRepeat == 'None') { //ยังไม่ถูกเลือก
                obj.push({
                    "nCode": nCode,
                    "tName": tName
                });
                localStorage.setItem("LocalItemData", JSON.stringify(obj));
                JSxShopPaseCodeDelInModal();
            } else if (aReturnRepeat == 'Dupilcate') { //เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for ($i = 0; $i < nLength; $i++) {
                    if (aArrayConvert[0][$i].nCode == nCode) {
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata = [];
                for ($i = 0; $i < nLength; $i++) {
                    if (aArrayConvert[0][$i] != undefined) {
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("LocalItemData", JSON.stringify(aNewarraydata));
                JSxShopPaseCodeDelInModal();
            }
        }
        JSxShopShowButtonChoose();
    });
</script>