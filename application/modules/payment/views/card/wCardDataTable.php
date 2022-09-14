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
if ($aCrdDataList['rtCode'] == '1') {
    $nCurrentPage = $aCrdDataList['rnCurrentPage'];
} else {
    $nCurrentPage = '1';
}
//Decimal Show
$tDecShow = FCNxHGetOptionDecimalShow();
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbCrdDataList" class="table table-striped">
                <thead>
                    <tr>
                        <?php if ($aAlwEventCard['tAutStaFull'] == 1 || $aAlwEventCard['tAutStaDelete'] == 1) : ?>
                            <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo  language('payment/card/card', 'tCRDTBChoose') ?></th>
                        <?php endif; ?>
                        <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo  language('payment/card/card', 'tCRDTBImage') ?></th>
                        <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo  language('payment/card/card', 'tCRDTBCode') ?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo  language('payment/card/card', 'tCRDTBHolderID') ?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo  language('payment/card/card', 'tCRDTBName') ?></th>
                        <th nowrap class="text-center xCNTextBold" style="min-width: 110px;"><?php echo  language('payment/card/card', 'tCRDTBType') ?></th>
                        <th nowrap class="text-center xCNTextBold" style="min-width: 120px;"><?php echo  language('payment/card/card', 'tCRDTBValue') ?></th>
                        <th nowrap class="text-center xCNTextBold" style="min-width: 120px;"><?php echo  language('payment/card/card', 'tCRDTBExpireDate') ?></th>

                        <th nowrap class="text-center xCNTextBold" style="min-width: 100px;"><?php echo  language('payment/card/card', 'tCardStaCard') ?></th>

                        <th nowrap class="text-center xCNTextBold" style="min-width: 100px;"><?php echo  language('payment/card/card', 'tCRDTBStaActive') ?></th>
                        <?php if ($aAlwEventCard['tAutStaFull'] == 1 || $aAlwEventCard['tAutStaDelete'] == 1) : ?>
                            <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo  language('payment/card/card', 'tCRDTBDelete') ?></th>
                        <?php endif; ?>
                        <?php if ($aAlwEventCard['tAutStaFull'] == 1 || ($aAlwEventCard['tAutStaEdit'] == 1 || $aAlwEventCard['tAutStaRead'] == 1)) : ?>
                            <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo  language('payment/card/card', 'tCRDTBEdit') ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($aCrdDataList['rtCode'] == '1') : ?>
                        <?php foreach ($aCrdDataList['raItems'] as $nKey => $aValue) : ?>

                            <tr class="text-center xCNTextDetail2 otrCard" id="otrCard<?php echo $nKey ?>" data-code="<?php echo $aValue['rtCrdCode'] ?>" data-name="<?php echo $aValue['rtCrdName'] ?>">
                                <?php if ($aAlwEventCard['tAutStaFull'] == 1 || $aAlwEventCard['tAutStaDelete'] == 1) : ?>
                                    <td class="text-center">
                                        <label class="fancy-checkbox">
                                            <input id="ocbListItem<?php echo $nKey ?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                            <span>&nbsp;</span>
                                        </label>
                                    </td>
                                <?php endif; ?>
                                <td nowrap class="text-center"><?=FCNtHGetImagePageList($aValue['FTImgObj'],'40px')?></td>
                                <td nowrap class="text-left"><?php echo $aValue['rtCrdCode'] ?></td>
                                <td nowrap class="text-left"><?php echo $aValue['rtCrdHolderID'] ?></td>
                                <td nowrap class="text-left" style="word-break: break-all;"><?php echo $aValue['rtCrdName'] ?></td>
                                <td nowrap class="text-left"><?php echo $aValue['rtCrdCtyName'] ?></td>
                                <?php
                                $aDataCrdCode = array(
                                    'FTCrdCode' => $aValue['rtCrdCode']
                                );
                                $aValtotal = $this->mCard->FSnMCRDDataSumTotalCard($aDataCrdCode);

                                ?>
                                <td nowrap class="text-right"><?php echo number_format($aValtotal[0]['TotalAmount'], $tDecShow) ?></td>
                                <?php
                                if (!empty($aValue['rtCrdExpireDate'])) {
                                    $dDateExpire = explode(" ", $aValue['rtCrdExpireDate']);
                                    $dDateExpire = $dDateExpire[0];
                                } else {
                                    $dDateExpire = "-";
                                }
                                ?>
                                <td nowrap class="text-center"><?php echo $dDateExpire ?></td>

                                <?php
                                    // สถานะเบิกบัตร 1 : ยังไม่ถูกเบิก, 2 : เบิกไปแล้ว
                                    switch($aValue['rtCrdStaShif']){
                                        case 1:
                                            $tStaCrd   = language('payment/card/card', 'ยังไม่ถูกเบิก');
                                        break;
                                        case 2:
                                            $tStaCrd   = language('payment/card/card', 'เบิกไปแล้ว');
                                        break;
                                    }
                                ?>


                                <td nowrap class="text-left"><?php echo $tStaCrd ?></td>

                                <?php
                                switch ($aValue['rtCrdStaActive']) {
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

                                $tExpireDate  = date_create($aValue['rtCrdExpireDate']);
                                $dExpireDate  = date_format($tExpireDate,'Y-m-d');
                                $dCurrentDate = date("Y-m-d");

                                if( $dCurrentDate > $dExpireDate ){
                                    $tStaCrdAct     = language('payment/card/card', 'tCRDFrmCrdExpire');
                                    $tClassStaAtv   = 'xWCardCancle';
                                }

                                ?>
                                <td class="text-left"><a class="<?php echo $tClassStaAtv ?>"><?php echo $tStaCrdAct; ?></a></td>
                                <?php if ($aAlwEventCard['tAutStaFull'] == 1 || $aAlwEventCard['tAutStaDelete'] == 1) : ?>
                                    <td>
                                        <img class="xCNIconTable" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>" onClick="JSoCardDel('<?php echo $nCurrentPage ?>','<?php echo $aValue['rtCrdCode'] ?>','<?php echo $aValue['rtCrdHolderID'] ?>')">
                                    </td>
                                <?php endif; ?>
                                <?php if ($aAlwEventCard['tAutStaFull'] == 1 || ($aAlwEventCard['tAutStaEdit'] == 1 || $aAlwEventCard['tAutStaRead'] == 1)) : ?>
                                    <td>
                                        <img class="xCNIconTable" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>" onClick="JSvCallPageCardEdit('<?php echo $aValue['rtCrdCode'] ?>')">
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td class='text-center xCNTextDetail2' colspan='99'><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main', 'tResultTotalRecord') ?> <?php echo $aCrdDataList['rnAllRow'] ?> <?php echo language('common/main/main', 'tRecord') ?> <?php echo language('common/main/main', 'tCurrentPage') ?> <?php echo $aCrdDataList['rnCurrentPage'] ?> / <?php echo $aCrdDataList['rnAllPage'] ?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageCard btn-toolbar pull-right">
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSvCardClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for ($i = max($nPage - 2, 1); $i <= max(0, min($aCrdDataList['rnAllPage'], $nPage + 2)); $i++) { ?>
                <?php
                if ($nPage == $i) {
                    $tActive = 'active';
                    $tDisPageNumber = 'disabled';
                } else {
                    $tActive = '';
                    $tDisPageNumber = '';
                }
                ?>
                <button onclick="JSvCardClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aCrdDataList['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvCardClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<div class="modal fade" id="odvModalDelCard">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ohdConfirmIDDelete">
            </div>
            <div class="modal-footer">
                <button id="osmConfirm" onClick="JSoCardDelChoose('<?php echo $nCurrentPage ?>')" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
                    <?php echo language('common/main/main', 'tModalConfirm') ?>
                </button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel') ?>
                </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.ocbListItem').click(function() {
        var nCode = $(this).parent().parent().parent().data('code'); //code
        var tName = $(this).parent().parent().parent().data('name'); //code
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
            JSxPaseCodeDelInModal();
        } else {
            var aReturnRepeat = findObjectByKey(aArrayConvert[0], 'nCode', nCode);
            if (aReturnRepeat == 'None') { //ยังไม่ถูกเลือก
                obj.push({
                    "nCode": nCode,
                    "tName": tName
                });
                localStorage.setItem("LocalItemData", JSON.stringify(obj));
                JSxPaseCodeDelInModal();
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
                JSxPaseCodeDelInModal();
            }
        }
        JSxShowButtonChoose();
    })
</script>