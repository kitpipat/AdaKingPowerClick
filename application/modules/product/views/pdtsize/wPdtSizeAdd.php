<?php
if (isset($nStaAddOrEdit) && $nStaAddOrEdit == 1) {
    $tRoute     = "pdtsizeEventEdit";
    $tPszCode   = $aPszData['raItems']['rtPszCode'];
    $tPszName   = $aPszData['raItems']['rtPszName'];
    $tPszRmk    = $aPszData['raItems']['rtPszRmk'];

    $tPszAgnCode   = $aPszData['raItems']['rtAgnCode'];
    $tPszAgnName   = $aPszData['raItems']['rtAgnName'];
} else {
    $tRoute     = "pdtsizeEventAdd";
    $tPszCode   = "";
    $tPszName   = "";
    $tPszRmk    = "";


    $tPszAgnCode   = $tSesAgnCode;
    $tPszAgnName   = $tSesAgnName;
}
?>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddPdtPsz">
    <!-- <input type="hidden" id="ohdPdtGroupRoute" value="<?php echo $tRoute; ?>"> -->
    <button style="display:none" type="submit" id="obtSubmitPdtPsz" onclick="JSoAddEditPdtPsz('<?= $tRoute ?>')"></button>
    <div class="panel panel-headline">
        <!-- เพิ่มมาใหม่ -->
        <div class="panel-body" style="padding-top:20px !important;">
            <!-- เพิ่มมาใหม่ -->
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5">
                    <!-- เปลี่ยน Col Class -->
                    <div class="form-group">
                        <input type="hidden" value="0" id="ohdCheckPszClearValidate" name="ohdCheckPszClearValidate">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdtsize/pdtsize', 'tPSZCode') ?></label> <!-- เปลี่ยนชื่อ Class -->
                        <?php
                        if ($tRoute == "pdtsizeEventAdd") {
                        ?>
                            <div class="form-group" id="odvPgpAutoGenCode">
                                <div class="validate-input">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbPszAutoGenCode" name="ocbPszAutoGenCode" checked="true" value="1">
                                        <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group" id="odvPunCodeForm">
                                <input type="text" class="form-control xCNInputWithoutSpcNotThai" maxlength="5" id="oetPszCode" name="oetPszCode" data-is-created="<?php  ?>" placeholder="<?= language('product/pdtsize/pdtsize', 'tPSZCode') ?>" value="<?php  ?>" data-validate-required="<?php echo language('product/pdtgroup/pdtgroup', 'tPSZValidCode') ?>" data-validate-dublicateCode="<?php echo language('product/pdtsize/pdtsize', 'tPSZVldCodeDuplicate') ?>" readonly onfocus="this.blur()">
                                <input type="hidden" value="2" id="ohdCheckDuplicatePszCode" name="ohdCheckDuplicatePszCode">
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="form-group" id="odvPunCodeForm">
                                <div class="validate-input">
                                    <label class="fancy-checkbox">
                                        <input type="text" class="form-control xCNInputWithoutSpcNotThai" maxlength="5" id="oetPszCode" name="oetPszCode" data-is-created="<?php  ?>" placeholder="<?= language('product/pdtsize/pdtsize', 'tPSZCode') ?>" value="<?php echo $tPszCode; ?>" readonly onfocus="this.blur()">
                                    </label>
                                </div>
                            <?php
                        }
                            ?>
                            </div>

                            <?php
                            if ($tRoute ==  "pdtgroupEventAdd") {
                                $tPszAgnCode   = $tSesAgnCode;
                                $tPszAgnName   = $tSesAgnName;
                                $tDisabled     = '';
                                $tNameElmIDAgn = 'oimBrowseAgn';
                            } else {
                                $tPszAgnCode    = $tPszAgnCode;
                                $tPszAgnName    = $tPszAgnName;
                                $tDisabled      = '';
                                $tNameElmIDAgn  = 'oimBrowseAgn';
                            }
                            ?>


                            <!-- เพิ่ม AD Browser -->
                            <div class="form-group  <?php if (!FCNbGetIsAgnEnabled()) : echo 'xCNHide';
                                                    endif; ?>">
                                <label class="xCNLabelFrm"><?php echo language('product/pdtgroup/pdtgroup', 'tPGPAgency') ?></label>
                                <div class="input-group"><input type="text" class="form-control xCNHide" id="oetPszAgnCode" name="oetPszAgnCode" maxlength="5" value="<?= @$tPszAgnCode; ?>">
                                    <input type="text" class="form-control xWPointerEventNone" id="oetPszAgnName" name="oetPszAgnName" maxlength="100" placeholder="<?php echo language('interface/connectionsetting/connectionsetting', 'tTBAgency') ?>" value="<?= @$tPszAgnName; ?>" readonly>
                                    <span class="input-group-btn">
                                        <button id="<?= @$tNameElmIDAgn; ?>" type="button" class="btn xCNBtnBrowseAddOn <?= @$tDisabled ?>">
                                            <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdtsize/pdtsize', 'tPSZFrmPszName') ?></label> <!-- เปลี่ยนชื่อ Class -->
                                <input type="text" class="form-control xCNInputWithoutSingleQuote" maxlength="50" id="oetPszName" name="oetPszName" autocomplete="off" value="<?= $tPszName ?>" placeholder="<?= language('product/pdtsize/pdtsize', 'tPSZFrmPszName') ?>" autocomplete="off" data-validate-required="<?= language('product/pdtsize/pdtsize', 'tPSZValidName') ?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?= language('product/pdtsize/pdtsize', 'tPSZFrmPszRmk') ?></label> <!-- เปลี่ยนชื่อ Class -->
                                <textarea class="form-control" maxlength="100" rows="4" id="otaPszRmk" name="otaPszRmk"><?= $tPszRmk ?></textarea>
                            </div>
                    </div>
                </div>
            </div>
        </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>
<script>
    $('#obtGenCodePdtPsz').click(function() {
        JStGeneratePdtPszCode();
    });


    //BrowseAgn 
    $('#oimBrowseAgn').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oBrowseAgn({
                'tReturnInputCode': 'oetPszAgnCode',
                'tReturnInputName': 'oetPszAgnName',
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