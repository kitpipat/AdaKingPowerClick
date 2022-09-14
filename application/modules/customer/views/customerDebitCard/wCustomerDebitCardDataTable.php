<style>
    .xWCardActive {
        color: #007b00 !important;
        font-weight: bold;
        cursor: default;
    }

    .xWCardInActive {
        color: #7b7f7b !important;
        font-weight: bold;
        cursor: default;
    }

    .xWCardCancle {
        color: #f60a0a !important;
        font-weight: bold;
        cursor: default;
    }
</style>
<?php
if ($aDataList['rtCode'] == '1') {
    $nCurrentPage = $aDataList['rnCurrentPage'];
} else {
    $nCurrentPage = '1';
}
//Decimal Show
$tDecShow = FCNxHGetOptionDecimalShow();
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
        <button id="obtCompSetConnection" name="obtCompSetConnection" class="xCNBTNPrimeryPlus" type="button" style="margin-left: 20px; margin-top: 0px;" onclick="JSvCallPageCustomerDebitCardAdd()">+</button>
        <div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" id="nCurrentPageTB" value="<?= $nCurrentPage; ?>">
                <div class="table-responsive">
                    <table class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('customer/customer/customer', 'tCstDebitCardCode') ?></th>
                                <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('customer/customer/customer', 'tCstDebitCardCodeType') ?></th>
                                <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('customer/customer/customer', 'tCstDebitCardValue') ?></th>
                                <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('customer/customer/customer', 'tCstDebitCrdAllowedAmount') ?></th>
                                <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('customer/customer/customer', 'tCstDebitCardDateExpire') ?></th>
                                <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('customer/customer/customer', 'tCstDebitCardStaUse') ?></th>
                                <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('customer/customer/customer', 'tCstDebitCardDelete') ?></th>
                                <!-- <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php //echo language('customer/customer/customer','tCstDebitCardEdit')
                                                                                                        ?></th> -->
                            </tr>
                        </thead>
                        <tbody id="odvCstDebitCardlist">
                            <?php if ($aDataList['rtCode'] === '1') : ?>
                                <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>

                                    <td nowrap class="text-left"><?= $aValue['FTCrdCode']; ?></td>
                                    <td nowrap class="text-left"><?= $aValue['FTCtyName']; ?></td>
                                    <?php
                                    $aDataCrdCode = array(
                                        'FTCrdCode' => $aValue['FTCrdCode']
                                    );
                                    $aValtotal = $this->mCustomerDebitCard->FSnMCstDataSumTotalCard($aDataCrdCode);

                                    ?>
                                    <td nowrap class="text-right"><?php echo number_format($aValtotal[0]['TotalAmount'], $tDecShow) ?></td>
                                    <!-- <td nowrap class="text-left"><?= $aValue['FCCrdValue']; ?></td> -->
                                    <td nowrap class="text-right"><?php echo number_format($aValtotal[0]['TotalUse'], $tDecShow) ?></td>

                                    <?php
                                    if (!empty($aValue['FDCrdExpireDate'])) {
                                        $dDateExpire = explode(" ", $aValue['FDCrdExpireDate']);
                                        $dDateExpire = $dDateExpire[0];
                                    } else {
                                        $dDateExpire = "-";
                                    }
                                    ?>
                                    <td nowrap class="text-center"><?php echo $dDateExpire ?></td>

                                    <?php
                                    switch ($aValue['FTCrdStaActive']) {
                                        case 1:
                                            $tStaCrdAct     = language('payment/card/card', 'tCRDFrmCrdActive');
                                            $tClassStaAtv   = 'xWCardActive';
                                            break;
                                        case 2:
                                            $tStaCrdAct     = language('payment/card/card', 'tCRDFrmCrdInactive');
                                            $tClassStaAtv   = 'xWCardInActive';
                                            break;
                                        case 3:
                                            $tStaCrdAct     = language('payment/card/card', 'tCRDFrmCrdCancel');
                                            $tClassStaAtv   = 'xWCardCancle';
                                            break;
                                        default:
                                            $tStaCrdAct     = "-";
                                            $tClassStaAtv   = '';
                                    }
                                    ?>
                                    <td nowrap class="text-center"><a class="<?php echo $tClassStaAtv ?>"><?php echo $tStaCrdAct; ?></a></td>


                                    <td nowrap class="text-center">
                                        <img class="xCNIconTable" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>" onClick="JSxCustomerDebitCardDelete('<?php echo $aValue['FTCrdRefCode'] ?>','<?php echo $aValue['FTCrdCode'] ?>','<?php echo language('common/main/main', 'tBCHYesOnNo') ?>')">
                                    </td>
                                    <!-- <td nowrap class="text-center">
                                    <img class="xCNIconTable" src="<?= base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>" onClick="JSvCallPageCustomerDebitCardEdit('<?= $aValue['FTCrdCode'] ?>');">
                                </td> -->
                                    </tr>
                                <?php } ?>
                            <?php else : ?>
                                <tr>
                                    <td class='text-center xCNTextDetail2' colspan='12'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Click Page -->
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left">
                <p><?= language('common/main/main', 'tResultTotalRecord') ?> <?= $aDataList['rnAllRow'] ?> <?= language('common/main/main', 'tRecord') ?> <?= language('common/main/main', 'tCurrentPage') ?> <?= $aDataList['rnCurrentPage'] ?> / <?= $aDataList['rnAllPage'] ?></p>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="xWCstPage btn-toolbar pull-right">
                    <?php if ($nPage == 1) {
                        $tDisabledLeft = 'disabled';
                    } else {
                        $tDisabledLeft = '-';
                    } ?>
                    <button onclick="JSvCstDebitCardClickPage('previous')" class="btn btn-white btn-sm" <?= $tDisabledLeft ?>>
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
                        <button onclick="JSvCstDebitCardClickPage('<?= $i ?>')" type="button" class="btn xCNBTNNumPagenation <?= $tActive ?>" <?= $tDisPageNumber ?>><?= $i ?></button>
                    <?php } ?>
                    <?php if ($nPage >= $aDataList['rnAllPage']) {
                        $tDisabledRight = 'disabled';
                    } else {
                        $tDisabledRight = '-';
                    } ?>
                    <button onclick="JSvCstDebitCardClickPage('next')" class="btn btn-white btn-sm" <?= $tDisabledRight ?>>
                        <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
                    </button>
                </div>
            </div>
        </div>

        <!--Modal Delete Single-->
        <div id="odvModalDeleteSingle1" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="overflow: hidden auto; z-index: 7000; display: none;">
            <div class="modal-dialog">
                <div class="modal-content text-left">
                    <div class="modal-header xCNModalHead">
                        <label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete') ?></label>
                    </div>
                    <div class="modal-body">
                        <span id="ospConfirmDelete1"> - </span>
                        <input type='hidden' id="ohdConfirmIDDelete">
                    </div>
                    <div class="modal-footer">
                        <button id="osmConfirmDelete1" type="button" class="btn xCNBTNPrimery"><?= language('common/main/main', 'tModalConfirm') ?></button>
                        <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel') ?></button>
                    </div>
                </div>
            </div>
        </div>


        <?php
        $tCstCode = $aCustomerDebitCard['tCstCode'];
        ?>
        <input type="hidden" id="ohdCstCode" name="ohdCstCode" value="<?php echo $tCstCode; ?>">
        <?php include "script/jCustomerDebitCardMain.php"; ?>