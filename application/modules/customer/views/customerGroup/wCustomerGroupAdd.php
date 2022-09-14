<?php
if ($aResult['rtCode'] == "1") {
    $tCstGrpCode       = $aResult['raItems']['rtCstGrpCode'];
    $tCstGrpName       = $aResult['raItems']['rtCstGrpName'];
    $tCstGrpRmk        = $aResult['raItems']['rtCstGrpRmk'];
    $tRoute         = "customerGroupEventEdit";
    $tCstAgnCode   = $aResult['raItems']['rtAgnCode'];
    $tCstAgnName   = $aResult['raItems']['rtAgnName'];
} else {
    $tCstGrpCode       = "";
    $tCstGrpName       = "";
    $tCstGrpRmk        = "";
    $tRoute         = "customerGroupEventAdd";

    $tCstAgnCode   = $aResult['tSesAgnCode'];
    $tCstAgnName   = $aResult['tSesAgnName'];
}
?>
<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCstGrp">
    <button style="display:none" type="submit" id="obtSubmitCstGrp" onclick="JSnAddEditCstGrp('<?= $tRoute ?>')"></button>
    <div style="margin-top:15px;">
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('customer/customerGroup/customerGroup', 'tCstGrpCode'); ?><?= language('customer/customerGroup/customerGroup', 'tCstGrpTitle') ?></label>
                    <div id="odvCstGrpAutoGenCode" class="form-group">
                        <div class="validate-input">
                            <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbCustomerGroupAutoGenCode" name="ocbCustomerGroupAutoGenCode" checked="true" value="1">
                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                            </label>
                        </div>
                    </div>
                    <div id="odvCstGrpCodeForm" class="form-group">
                        <input type="hidden" id="ohdCheckDuplicateCstGrpCode" name="ohdCheckDuplicateCstGrpCode" value="1">
                        <div class="validate-input">
                            <input type="text" class="form-control xCNGenarateCodeTextInputValidate" maxlength="5" id="oetCstGrpCode" name="oetCstGrpCode" data-is-created="<?php echo $tCstGrpCode; ?>" placeholder="<?php echo language('customer/customerGroup/customerGroup', 'tCstGrpTBCode'); ?>" value="<?= $tCstGrpCode; ?>" autocomplete="off" data-validate-required="<?= language('customer/customerGroup/customerGroup', 'tCstValidCode') ?>" data-validate-dublicateCode="<?= language('customer/customerGroup/customerGroup', 'tCstValidCheckCode') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <?php
                if ($tRoute ==  "pdtgroupEventAdd") {
                    $tCstAgnCode   = $tSesAgnCode;
                    $tCstAgnName   = $tSesAgnName;
                    $tDisabled     = '';
                    $tNameElmIDAgn = 'oimBrowseAgn';
                } else {
                    $tCstAgnCode    = $tCstAgnCode;
                    $tCstAgnName    = $tCstAgnName;
                    $tDisabled      = '';
                    $tNameElmIDAgn  = 'oimBrowseAgn';
                }
                ?>


                <!-- เพิ่ม AD Browser -->
                <div class="form-group  <?php if (!FCNbGetIsAgnEnabled()) : echo 'xCNHide';
                                        endif; ?>">
                    <label class="xCNLabelFrm"><?php echo language('product/pdtgroup/pdtgroup', 'tPGPAgency') ?></label>
                    <div class="input-group"><input type="text" class="form-control xCNHide" id="oetCstAgnCode" name="oetCstAgnCode" maxlength="5" value="<?= @$tCstAgnCode; ?>">
                        <input type="text" class="form-control xWPointerEventNone" id="oetCstAgnName" name="oetCstAgnName" maxlength="100" placeholder="<?php echo language('interface/connectionsetting/connectionsetting', 'tTBAgency') ?>" value="<?= @$tCstAgnName; ?>" readonly>
                        <span class="input-group-btn">
                            <button id="<?= @$tNameElmIDAgn; ?>" type="button" class="btn xCNBtnBrowseAddOn <?= @$tDisabled ?>">
                                <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
                </div>



                <div class="form-group">
                    <div class="validate-input" data-validate="<?php echo language('customer/customerGroup/customerGroup', 'tCstName'); ?>">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('customer/customerGroup/customerGroup', 'tCstGrpName') ?><?= language('customer/customerGroup/customerGroup', 'tCstGrpTitle') ?></label>
                        <input type="text" class="form-control" maxlength="100" id="oetCstGrpName" name="oetCstGrpName" placeholder="<?= language('customer/customerGroup/customerGroup', 'tCstGrpName') ?><?= language('customer/customerGroup/customerGroup', 'tCstGrpTitle') ?>" autocomplete="off" value="<?= $tCstGrpName ?>" data-validate-required="<?= language('customer/customerGroup/customerGroup', 'tCstValidName') ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><?= language('customer/customerGroup/customerGroup', 'tCstGrpRemark') ?></label>
                                <textarea maxlength="100" rows="4" id="otaCstGrpRemark" name="otaCstGrpRemark"><?= $tCstGrpRmk ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include "script/jCustomerGroupAdd.php"; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>

<script type="text/javascript">
    $('.xWTooltipsBT').tooltip({
        'placement': 'bottom'
    });
    $('[data-toggle="tooltip"]').tooltip({
        'placement': 'top'
    });

    $('#oimCstGrpBrowseProvince').click(function() {
        JCNxBrowseData('oPvnOption');
    });

    if (JCNCstGrpIsUpdatePage()) {
        $("#obtGenCodeCstGrp").attr("disabled", true);
    }

    //BrowseAgn 
    $('#oimBrowseAgn').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oBrowseAgn({
                'tReturnInputCode': 'oetCstAgnCode',
                'tReturnInputName': 'oetCstAgnName',
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