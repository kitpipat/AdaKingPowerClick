<?php
if ($aResult['rtCode'] == "1") {
    $tCstTypeCode       = $aResult['raItems']['rtCstTypeCode'];
    $tCstTypeName       = $aResult['raItems']['rtCstTypeName'];
    $tCstTypeRmk        = $aResult['raItems']['rtCstTypeRmk'];
    $tRoute         = "customerTypeEventEdit";

    $tCstTypeAgnCode   = $aResult['raItems']['rtAgnCode'];
    $tCstTypeAgnName   = $aResult['raItems']['rtAgnName'];
} else {
    $tCstTypeCode       = "";
    $tCstTypeName       = "";
    $tCstTypeRmk        = "";
    $tRoute         = "customerTypeEventAdd";

    $tCstTypeAgnCode   = $aResult['tSesAgnCode'];
    $tCstTypeAgnName   = $aResult['tSesAgnName'];
}
?>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCstType">
    <button style="display:none" type="submit" id="obtSubmitCstType" onclick="JSnAddEditCstType('<?= $tRoute ?>')"></button>
    <div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('customer/customerType/customerType', 'tCstTypeCode') ?><?= language('customer/customerType/customerType', 'tCstTypeTitle') ?></label>
                    <div id="odvCstTypeAutoGenCode" class="form-group">
                        <div class="validate-input">
                            <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbCstTypeAutoGenCode" name="ocbCstTypeAutoGenCode" checked="true" value="1">
                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                            </label>
                        </div>
                    </div>
                    <div id="odvCustomerTypeCodeForm" class="form-group">
                        <input type="hidden" id="ohdCheckDuplicateCstTypeCode" name="ohdCheckDuplicateCstTypeCode" value="1">
                        <div class="validate-input">
                            <input type="text" class="form-control xCNGenarateCodeTextInputValidate" maxlength="5" id="oetCstTypeCode" name="oetCstTypeCode" data-is-created="<?php echo $tCstTypeCode; ?>" placeholder="<?= language('customer/customerType/customerType', 'tCstTypeTBCode') ?>" value="<?php echo $tCstTypeCode; ?>" data-validate-required="<?= language('customer/customerType/customerType', 'tCstTypeValidCode') ?>" data-validate-dublicateCode="<?= language('customer/customerType/customerType', 'tCstTypeValidCheckCode') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php
                if ($tRoute ==  "pdtgroupEventAdd") {
                    $tCstTypeAgnCode   = $tSesAgnCode;
                    $tCstTypeAgnName   = $tSesAgnName;
                    $tDisabled     = '';
                    $tNameElmIDAgn = 'oimBrowseAgn';
                } else {
                    $tCstTypeAgnCode    = $tCstTypeAgnCode;
                    $tCstTypeAgnName    = $tCstTypeAgnName;
                    $tDisabled      = '';
                    $tNameElmIDAgn  = 'oimBrowseAgn';
                }
                ?>


                <!-- เพิ่ม AD Browser -->
                <div class="form-group  <?php if (!FCNbGetIsAgnEnabled()) : echo 'xCNHide';
                                        endif; ?>">
                    <label class="xCNLabelFrm"><?php echo language('product/pdtgroup/pdtgroup', 'tPGPAgency') ?></label>
                    <div class="input-group"><input type="text" class="form-control xCNHide" id="oetCstTypeAgnCode" name="oetCstTypeAgnCode" maxlength="5" value="<?= @$tCstTypeAgnCode; ?>">
                        <input type="text" class="form-control xWPointerEventNone" id="oetCstTypeAgnName" name="oetCstTypeAgnName" maxlength="100" placeholder="<?php echo language('interface/connectionsetting/connectionsetting', 'tTBAgency') ?>" value="<?= @$tCstTypeAgnName; ?>" readonly>
                        <span class="input-group-btn">
                            <button id="<?= @$tNameElmIDAgn; ?>" type="button" class="btn xCNBtnBrowseAddOn <?= @$tDisabled ?>">
                                <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
                </div>


                <div class="form-group">
                    <div class="validate-input" data-validate="<?= language('customer/customerType/customerType', 'tCstTypeValidName') ?>">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('customer/customerType/customerType', 'tCstTypeName') ?><?= language('customer/customerType/customerType', 'tCstTypeTitle') ?></label>
                        <input type="text" class="input100" maxlength="100" id="oetCstTypeName" name="oetCstTypeName" value="<?= $tCstTypeName ?>" placeholder="<?= language('customer/customerType/customerType', 'tCstTypeValidName') ?>" data-validate-required="<?= language('customer/customerType/customerType', 'tCstTypeValidName') ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><?= language('customer/customerType/customerType', 'tCstTypeNote') ?></label>
                                <textarea maxlength="100" rows="4" id="otaCstTypeRemark" name="otaCstTypeRemark"><?= $tCstTypeRmk ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php include "script/jCustomerTypeAdd.php"; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>

<script type="text/javascript">
    $('.xWTooltipsBT').tooltip({
        'placement': 'bottom'
    });
    $('[data-toggle="tooltip"]').tooltip({
        'placement': 'top'
    });

    $('#oimCstTypeBrowseProvince').click(function() {
        JCNxBrowseData('oPvnOption');
    });

    if (JCNbCstTypeIsUpdatePage()) {
        $("#obtGenCodeCstType").attr("disabled", true);
    }


     //BrowseAgn 
     $('#oimBrowseAgn').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oBrowseAgn({
                'tReturnInputCode': 'oetCstTypeAgnCode',
                'tReturnInputName': 'oetCstTypeAgnName',
            });
            JCNxBrowseData('oPdtBrowseAgencyOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;

    //Option Agn
    var oBrowseAgn = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;

        var oOptionReturn = {
            Title: ['ticket/agency/agency', 'tAggTitle'],
            Table: {
                Master: 'TCNMAgency',
                PK: 'FTAgnCode'
            },
            Join: {
                Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits]
            },
            GrideView: {
                ColumnPathLang: 'ticket/agency/agency',
                ColumnKeyLang: ['tAggCode', 'tAggName'],
                ColumnsSize: ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMAgency.FTAgnCode"],
                Text: [tInputReturnName, "TCNMAgency_L.FTAgnName"],
            },
            RouteAddNew: 'agency',
            BrowseLev: 1,
        }
        return oOptionReturn;
    }

    var tStaUsrLevel = '<?php echo $this->session->userdata("tSesUsrLevel"); ?>';


    if (tStaUsrLevel == 'BCH' || tStaUsrLevel == 'SHP') {
        $('#oimBrowseAgn').attr("disabled", true);

    }
</script>