<?php
if ($aResult['rtCode'] == "1") {
    $tSrvPriCode       = $aResult['raItems']['rtPrnSrvCode'];
    $tSrvPriName       = $aResult['raItems']['rtPrnSrvName'];
    $tSrvPriRmk        = $aResult['raItems']['rtPrnSrvRmk'];
    $tRoute         = "ServerPrinterEventEdit";
    $tSrvPriStaUse = $aResult['raItems']['rtPrnSrvStaUse'];
    $tSrvPriAgnCode   = $aResult['raItems']['rtPrnSrvAgnCode'];
    $tSrvPriAgnName   = $aResult['raItems']['rtPrnSrvAgnName'];

} else {
    $tSrvPriCode       = "";
    $tSrvPriName       = "";
    $tSrvPriRmk        = "";
    $tRoute         = "ServerPrinterEventAdd";
    $tSrvPriStaUse = 1;
    $tSrvPriAgnCode   = $this->session->userdata("tSesUsrAgnCode");
    $tSrvPriAgnName   = $this->session->userdata("tSesUsrAgnName");
}
?>
<!-- <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddSrvPri"> -->
<form id="ofmAddSrvPri" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">

<button style="display:none" type="submit" id="obtSubmitSrvPri" onclick="JSnAddEditSrvPri('<?= $tRoute ?>')"></button>
    <div style="margin-top:15px;">
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('product/settingprinter/settingprinter','tSPTBCode')?></label>
                    <div id="odvSrvPriAutoGenCode" class="form-group">
                        <div class="validate-input">
                            <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbSrvPriAutoGenCode" name="ocbSrvPriAutoGenCode" checked="true" value="1">
                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                            </label>
                        </div>
                    </div>
                    <div id="odvSrvPriCodeForm" class="form-group">
                        <input type="hidden" id="ohdCheckDuplicateSrvPriCode" name="ohdCheckDuplicateSrvPriCode" value="1">
                        <input type="hidden" id="ohdSrvPriCode" name="ohdSrvPriCode" value="<?= $tSrvPriCode; ?>">

                        <div class="validate-input">
                            <input type="text" class="form-control xCNGenarateCodeTextInputValidate" 
                            maxlength="5" 
                            id="oetSrvPriCode" 
                            name="oetSrvPriCode" 
                            value="<?= $tSrvPriCode; ?>" 
                            data-is-created="<?= $tSrvPriCode; ?>" 
                            placeholder="<?php echo language('product/settingprinter/settingprinter','tSPTBCode')?>" 
                            data-validate-required="<?php echo language('product/settingprinter/settingprinter','tSPValidSPCode')?>" 
                            data-validate-dublicateCode="<?php echo language('product/settingprinter/settingprinter','tSPVldCodeDuplicate')?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <?php
                if ($tRoute ==  "ServerPrinterEventAdd") {
                    $tDisabled     = '';
                    $tNameElmIDAgn = 'oimSrvPriBrowseAgn';
                } else {
                    $tDisabled      = 'disabled';
                    $tNameElmIDAgn  = 'oimSrvPriBrowseAgn';
                }
                ?>


                <!-- เพิ่ม AD Browser -->
              <div class="form-group  <?php if (!FCNbGetIsAgnEnabled()) : echo 'xCNHide';
                                                endif; ?>">
                    <label class="xCNLabelFrm"><?php echo language('product/settingprinter/settingprinter', 'tPRNAgency') ?></label>
                    <div class="input-group"><input type="text" class="form-control xCNHide" id="oetSrvPriAgnCode" name="oetSrvPriAgnCode" maxlength="10" value="<?= @$tSrvPriAgnCode; ?>">
                        <input type="text" class="form-control xWPointerEventNone" id="oetSrvPriAgnName" name="oetSrvPriAgnName" maxlength="100" placeholder="<?php echo language('interface/connectionsetting/connectionsetting', 'tTBAgency') ?>" value="<?= @$tSrvPriAgnName; ?>" readonly>
                        <span class="input-group-btn">
                            <button id="<?= @$tNameElmIDAgn; ?>" type="button" class="btn xCNBtnBrowseAddOn" <?= @$tDisabled ?>>
                                <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
                </div>



                <div class="form-group">
                    <div class="validate-input" data-validate="<?php echo language('product/settingprinter/settingprinter','tSPTBName')?>">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('product/settingprinter/settingprinter','tSPTBName')?></label>
                        <input type="text" class="form-control" maxlength="100" id="oetSrvPriName" name="oetSrvPriName" placeholder="<?php echo language('product/settingprinter/settingprinter','tSPTBName')?>" autocomplete="off" value="<?= $tSrvPriName ?>" data-validate-required="<?php echo language('product/settingprinter/settingprinter','tSPValidSPName')?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><?= language('customer/customerGroup/customerGroup', 'tSPFrmSPRmk') ?></label>
                                <textarea maxlength="100" rows="4" id="otaSrvPriRemark" name="otaSrvPriRemark"><?= $tSrvPriRmk ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="fancy-checkbox">
                        <?php
                        if (isset($tSrvPriStaUse) && $tSrvPriStaUse == 1) {
                            $tChecked   = 'checked';
                        } else {
                            $tChecked   = '';
                        }
                        ?>
                        <input type="checkbox" id="ocbSrvPriStatusUse" name="ocbSrvPriStatusUse" <?php echo $tChecked; ?>>
                        <span> <?php echo language('common/main/main', 'tStaUse'); ?></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include "script/jServerPrinterAdd.php"; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>

<script type="text/javascript">
    $('.xWTooltipsBT').tooltip({
        'placement': 'bottom'
    });
    $('[data-toggle="tooltip"]').tooltip({
        'placement': 'top'
    });

    $('#oimSrvPriBrowseProvince').click(function() {
        JCNxBrowseData('oPvnOption');
    });

    if (JCNSrvPriIsUpdatePage()) {
        $("#obtGenCodeSrvPri").attr("disabled", true);
    }

    //BrowseAgn 
    $('#oimSrvPriBrowseAgn').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oSrbPriBrowseAgencyOption = oSrvPriBrowseAgn({
                'tReturnInputCode': 'oetSrvPriAgnCode',
                'tReturnInputName': 'oetSrvPriAgnName',
            });
            JCNxBrowseData('oSrbPriBrowseAgencyOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;

    //Option Agn
    var oSrvPriBrowseAgn = function(poReturnInput) {
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
        $('#oimSrvPriBrowseAgn').attr("disabled", true);
    }
</script>