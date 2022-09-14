<style>
    .xCNBTNPrimeryDisChgPlus {
        border-radius: 50%;
        float: left;
        width: 20px;
        height: 20px;
        line-height: 20px;
        background-color: #1eb32a;
        text-align: center;
        margin-top: 6px;
        font-size: 22px;
        color: #ffffff;
        cursor: pointer;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
    }
</style>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="table-responsive">
        <input type="text" class="xCNHide" id="ohdBrowseDataPdtCode" value="">
        <input type="text" class="xCNHide" id="ohdBrowseDataPunCode" value="">
        <input type="text" class="xCNHide" id="ohdEditInlinePdtCode" value="<?= $tTWOPdtCode; ?>">
        <input type="text" class="xCNHide" id="ohdEditInlinePunCode" value="<?= $tTWOPunCode; ?>">

        <table id="otbTWODocPdtAdvTableList" class="table xWPdtTableFont">
            <thead>
                <tr class="xCNCenter">
                    <?php if ((@$tTWOStaApv == '') && @$tTWOStaDoc != 3) { ?>
                        <th><?= language('document/purchaseinvoice/purchaseinvoice', 'tPITBChoose') ?></th>
                    <?php } ?>
                    <th><?= language('document/purchaseinvoice/purchaseinvoice', 'tPITBNo') ?></th>
                    <?php foreach ($aColumnShow as $HeaderColKey => $HeaderColVal) : ?>
                        <th nowrap title="<?= iconv_substr($HeaderColVal->FTShwNameUsr, 0, 30, "UTF-8"); ?>">
                            <?= iconv_substr($HeaderColVal->FTShwNameUsr, 0, 30, "UTF-8"); ?>
                        </th>
                    <?php endforeach; ?>
                    <?php if ((@$tTWOStaApv == '') && @$tTWOStaDoc != 3) { ?>
                        <th class="xCNTWOBeHideMQSS"><?= language('document/purchaseinvoice/purchaseinvoice', 'tPITBDelete'); ?></th>
                        <th class="xCNTWOBeHideMQSS xWTWODeleteBtnEditButtonPdt"><?php echo language('document/saleorder/saleorder', 'tSOTBEdit'); ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody id="odvTBodyTWOPdtAdvTableList">
                <?php $nNumSeq  = 0; ?>
                <?php if ($aDataDocDTTemp['rtCode'] == 1) : ?>
                    <?php foreach ($aDataDocDTTemp['raItems'] as $DataTableKey => $aDataTableVal) : ?>
                        <tr class="text-center xCNTextDetail2 nItem<?= $nNumSeq ?> xWPdtItem" data-index="<?= $aDataTableVal['rtRowID']; ?>" data-docno="<?= $aDataTableVal['FTXthDocNo']; ?>" data-seqno="<?= $aDataTableVal['FNXtdSeqNo'] ?>" data-pdtcode="<?= $aDataTableVal['FTPdtCode']; ?>" data-pdtname="<?= $aDataTableVal['FTXtdPdtName']; ?>" data-puncode="<?= $aDataTableVal['FTPunCode']; ?>" data-qty="<?= $aDataTableVal['FCXtdQty']; ?>" data-setprice="<?= $aDataTableVal['FCXtdSetPrice']; ?>" data-stadis="<?= $aDataTableVal['FTXtdStaAlwDis'] ?>" data-netafhd="<?= $aDataTableVal['FCXtdNetAfHD']; ?>">
                            <?php if ((@$tTWOStaApv == '') && @$tTWOStaDoc != 3) { ?>
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?= $aDataTableVal['rtRowID'] ?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <span></span>
                                    </label>
                                </td>
                            <?php } ?>
                            <td><label><?= $aDataTableVal['rtRowID'] ?></label></td>
                            <?php foreach ($aColumnShow as $DataKey => $DataVal) : ?>
                                <?php
                                $tColumnName        = $DataVal->FTShwFedShw;
                                $nColWidth          = $DataVal->FNShwColWidth;
                                $tColumnDataType    = substr($tColumnName, 0, 2);
                                if ($tColumnDataType == 'FC') {
                                    $tMaxlength     = '11';
                                    $tAlignFormat   = 'text-right';
                                    $tDataCol       =  $aDataTableVal[$tColumnName] != '' ? number_format($aDataTableVal[$tColumnName], $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', ',');
                                    $InputType      = 'text';
                                    $tValidateType  = 'xCNInputNumericWithDecimal';
                                }
                                if ($tColumnDataType == 'FN') {
                                    $tMaxlength     = '';
                                    $tAlignFormat   = 'text-right';
                                    $tDataCol       = $aDataTableVal[$tColumnName] != '' ? number_format($aDataTableVal[$tColumnName], $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', ',');
                                    $InputType      = 'number';
                                    $tValidateType  = '';
                                }
                                if ($tColumnDataType == 'FD') {
                                    $tMaxlength     = '';
                                    $tAlignFormat   = 'text-left';
                                    $tDataCol       = date('Y-m-d H:i:s');
                                    $InputType      = 'text';
                                    $tValidateType  = '';
                                }
                                if ($tColumnDataType == 'FT') {
                                    $tMaxlength     = '';
                                    $tAlignFormat   = 'text-left';
                                    $tDataCol       = $aDataTableVal[$tColumnName];
                                    $InputType      = 'text';
                                    $tValidateType  = '';
                                }
                                ?>
                                <td nowrap class="<?= $tAlignFormat ?>">
                                    <?php if ($bAlwEditQty === true) { ?>
                                        <?php if ($DataVal->FTShwStaAlwEdit == 1 && in_array($tColumnName, ['FCXtdSetPrice', 'FCXtdQty']) && (empty($tTWOStaApv) && $tTWOStaDoc != 3) && ($aDataTableVal['FTTmpStatus'] != 5)) : ?>
                                            <label data-field="<?= $tColumnName ?>" data-seq="<?= $aDataTableVal['FNXtdSeqNo'] ?>" data-demo="TextDEmo" class="xCNPdtFont xWShowInLine<?= $aDataTableVal['rtRowID'] ?> xWShowValue<?= $tColumnName ?><?= $aDataTableVal['rtRowID'] ?>">
                                                <?= $tDataCol != '' ? "" . $tDataCol : '1'; ?>
                                            </label>
                                            <div class="xCNHide xWEditInLine<?= $aDataTableVal['FNXtdSeqNo'] ?>">
                                                <input type="<?= $InputType ?>" class="form-control xCNPdtEditInLine xWValueEditInLine<?= $aDataTableVal['rtRowID'] ?> <?= $tValidateType ?> <?= $tAlignFormat; ?>" id="ohd<?= $tColumnName ?><?= $aDataTableVal['rtRowID'] ?>" name="ohd<?= $tColumnName ?><?= $aDataTableVal['rtRowID'] ?>" maxlength="<?= $tMaxlength ?>" value="<?= $tDataCol; ?>" <?= $tColumnName == 'FTXtdDisChgTxt' ? 'readonly' : '' ?> <?= $tColumnName == 'FCXtdQty'; ?>>
                                            </div>
                                        <?php else : ?>
                                            <?php if ($aDataTableVal['FTTmpStatus'] != 5) { ?>
                                                <label class="xCNPdtFont xWShowInLine xWShowValue<?= $tColumnName ?><?= $aDataTableVal['rtRowID'] ?>"><?= $tDataCol ?></label>
                                            <?php } else { ?>
                                                <?php
                                                if ((empty($tTWOStaApv) && $tTWOStaDoc != 3)) {
                                                    if ($tColumnName == 'FCXtdQty') {
                                                        $tClassName = 'xCNTextLink';
                                                        $tIconEdit = " <img class='xCNIconTable' src=" . base_url('application/modules/common/assets/images/icons/edit.png') . " title='Edit'>";
                                                    } else {
                                                        $tClassName = 'xCNTextLink';
                                                        $tIconEdit = "";
                                                    }
                                                } else {
                                                    $tClassName = 'xCNTextLink';
                                                    $tIconEdit  = "";
                                                }
                                                $aOptionFashion = array(
                                                    'tDocumentBranch'     => $aDataTableVal['FTBchCode'],
                                                    'tDocumentNumber'     => $aDataTableVal['FTXthDocNo'],
                                                    'tDocumentProduct'    => $aDataTableVal['FTPdtCode'],
                                                    'tDocumentDocKey'     => 'TCNTPdtTwoHD',
                                                    'nDTSeq'              => $aDataTableVal['FNXtdSeqNo'],
                                                    'tDTBarCode'          => $aDataTableVal['FTXtdBarCode'],
                                                    'tDTPunCode'          => $aDataTableVal['FTPunCode'],
                                                    'tNextFunc'           => 'FSvTWOPDTAddPdtIntoTableDT',
                                                    'tSpcControl'         => 0,                    //0:จำนวน //1:ตรวจนับครั้งที่หนึ่ง //2:ตรวจนับครั้งที่สอง //3:ตรวจนับย่อย
                                                    'tStaEdit'            => ($tTWOStaApv == '1' || $tTWOStaDoc == '3' ? '2' : '1')
                                                );
                                                $aOption = json_encode($aOptionFashion);
                                                ?>
                                                <label class="<?= $tClassName ?> xCNPdtFont xWShowInLine xWShowValue<?= $tColumnName ?><?= $aDataTableVal['rtRowID'] ?>" onclick='JSxUpdateProductSerialandFashion(<?= $aOption ?>)'><?= $tDataCol ?> <?= $tIconEdit ?></label>
                                            <?php } ?>
                                        <?php endif; ?>
                                    <?php } else { ?>
                                        <label class="xCNPdtFont xWShowValue<?= $tColumnName ?><?= $aDataTableVal['FNXtdSeqNo'] ?>"><?= $tDataCol ?></label>
                                    <?php } ?>

                                </td>
                            <?php endforeach; ?>
                            <?php if ((@$tTWOStaApv == '') && @$tTWOStaDoc != 3) { ?>
                                <td nowrap class="text-center xCNTWOBeHideMQSS">
                                    <label class="xCNTextLink">
                                        <img class="xCNIconTable" src="<?= base_url('application/modules/common/assets/images/icons/delete.png'); ?>" title="Remove" onclick="JSnTWODelPdtInDTTempSingle(this)">
                                    </label>
                                </td>
                            <?php } ?>
                        </tr>
                        <?php $nNumSeq++; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td class="text-center xCNTextDetail2 xWTWOTextNotfoundDataPdtTable" colspan="100%"><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<input id="ohdTWOPageCurrent" type="hidden" value="<?=$aDataDocDTTemp['rnCurrentPage']?>">

<?php if ($aDataDocDTTemp['rnAllPage'] > 1) : ?>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main', 'tResultTotalRecord') ?> <?php echo $aDataDocDTTemp['rnAllRow'] ?> <?php echo language('common/main/main', 'tRecord') ?> <?php echo language('common/main/main', 'tCurrentPage') ?> <?php echo $aDataDocDTTemp['rnCurrentPage'] ?> / <?php echo $aDataDocDTTemp['rnAllPage'] ?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageTWOPdt btn-toolbar pull-right">
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSvTWOPDTDocDTTempClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for ($i = max($nPage - 2, 1); $i <= max(0, min($aDataDocDTTemp['rnAllPage'], $nPage + 2)); $i++) { ?>
                <?php
                if ($nPage == $i) {
                    $tActive = 'active';
                    $tDisPageNumber = 'disabled';
                } else {
                    $tActive = '';
                    $tDisPageNumber = '';
                }
                ?>
                <button onclick="JSvTWOPDTDocDTTempClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aDataDocDTTemp['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvTWOPDTDocDTTempClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
<?php endif; ?>

<!-- ============================================ Modal Confirm Delete Documet Detail Dis ============================================ -->
<div id="odvPIModalConfirmDeleteDTDis" class="modal fade" style="z-index: 7000;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('common/main/main', 'tPIMsgNotificationChangeData') ?></label>
            </div>
            <div class="modal-body">
                <label><?php echo language('document/purchaseinvoice/purchaseinvoice', 'tPIMsgTextNotificationChangeData'); ?></label>
            </div>
            <div class="modal-footer">
                <button id="obtPIConfirmDeleteDTDis" type="button" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tModalConfirm'); ?></button>
                <button id="obtPICancelDeleteDTDis" type="button" class="btn xCNBTNDefult"><?php echo language('common/main/main', 'ยกเลิก'); ?></button>
            </div>
        </div>
    </div>
</div>
<!-- ================================================================================================================================= -->

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>

<script>
    //ลบสินค้าใน Tmp - หลายตัว
    $('#otbTWODocPdtAdvTableList #odvTBodyTWOPdtAdvTableList .ocbListItem').unbind().click(function() {
        var tTWODocNo = $('#oetTWODocNo').val();
        var tTWOSeqNo = $(this).parents('.xWPdtItem').data('seqno');
        var tTWOPdtCode = $(this).parents('.xWPdtItem').data('pdtcode');
        var tTWOPunCode = $(this).parents('.xWPdtItem').data('puncode');
        $(this).prop('checked', true);
        let oLocalItemDTTemp = localStorage.getItem("TWO_LocalItemDataDelDtTemp");
        let oDataObj = [];
        if (oLocalItemDTTemp) {
            oDataObj = JSON.parse(oLocalItemDTTemp);
        }
        let aArrayConvert = [JSON.parse(localStorage.getItem("TWO_LocalItemDataDelDtTemp"))];
        if (aArrayConvert == '' || aArrayConvert == null) {
            oDataObj.push({
                'tDocNo': tTWODocNo,
                'tSeqNo': tTWOSeqNo,
                'tPdtCode': tTWOPdtCode,
                'tPunCode': tTWOPunCode,
            });
            localStorage.setItem("TWO_LocalItemDataDelDtTemp", JSON.stringify(oDataObj));
            JSxTWOTextInModalDelPdtDtTemp();
        } else {
            var aReturnRepeat = JStTWOFindObjectByKey(aArrayConvert[0], 'tSeqNo', tTWOSeqNo);
            if (aReturnRepeat == 'None') {
                //ยังไม่ถูกเลือก
                oDataObj.push({
                    'tDocNo': tTWODocNo,
                    'tSeqNo': tTWOSeqNo,
                    'tPdtCode': tTWOPdtCode,
                    'tPunCode': tTWOPunCode,
                });
                localStorage.setItem("TWO_LocalItemDataDelDtTemp", JSON.stringify(oDataObj));
                JSxTWOTextInModalDelPdtDtTemp();
            } else if (aReturnRepeat == 'Dupilcate') {
                localStorage.removeItem("TWO_LocalItemDataDelDtTemp");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for ($i = 0; $i < nLength; $i++) {
                    if (aArrayConvert[0][$i].tSeqNo == tTWOSeqNo) {
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata = [];
                for ($i = 0; $i < nLength; $i++) {
                    if (aArrayConvert[0][$i] != undefined) {
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("TWO_LocalItemDataDelDtTemp", JSON.stringify(aNewarraydata));
                JSxTWOTextInModalDelPdtDtTemp();
            }
        }
        JSxTWOShowButtonDelMutiDtTemp();
    });

    $(document).ready(function() {
        if ((tTWOStaDoc == 3) || (tTWOStaApvDoc == 1 && tTWOStaPrcStkDoc == 1)) {
            $('#otbTWODocPdtAdvTableList .xCNPIBeHideMQSS').hide();
        } else {
            var oParameterEditInLine = {
                "DocModules"                    : "",
                "FunctionName"                  : "JSxTWOSaveEditInline",
                "DataAttribute"                 : ['data-field', 'data-seq'],
                "TableID"                       : "otbTWODocPdtAdvTableList",
                "NotFoundDataRowClass"          : "xWTWOTextNotfoundDataPdtTable",
                "EditInLineButtonDeleteClass"   : "xWTWODeleteBtnEditButtonPdt",
                "LabelShowDataClass"            : "xWShowInLine",
                "DivHiddenDataEditClass"        : "xWEditInLine"
            }
            JCNxSetNewEditInline(oParameterEditInLine);

            $(".xWEditInlineElement").eq(nIndexInputEditInline).focus();
            $(".xWEditInlineElement").eq(nIndexInputEditInline).select();
            $(".xWEditInlineElement").removeAttr("disabled");

            let oElement = $(".xWEditInlineElement");
            for (let nI = 0; nI < oElement.length; nI++) {
                $(oElement.eq(nI)).val($(oElement.eq(nI)).val().trim());
            }
        }
    });
</script>