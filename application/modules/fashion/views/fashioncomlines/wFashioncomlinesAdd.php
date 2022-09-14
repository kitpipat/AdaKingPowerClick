<?php
if ($aResult['rtCode'] == "1") {

    $tCmlCode = $aResult['raHDItems']['rtCmlCode'];
    $tAgnCode = $aResult['raHDItems']['rtAgnCode'];
    $tCmlName = $aResult['raHDItems']['rtCmlName'];
    $tCmlRmk = $aResult['raHDItems']['rtCmlRmk'];
    $tAgnName = $aResult['raHDItems']['rtAgnName'];


    $tRoute = "fashioncomlinesEventEdit";
} else {


    $tCmlCode = '';
    $tAgnCode = '';
    $tCmlName = '';
    $tCmlRmk = '';
    $tAgnName = '';

    $tRoute = "fashioncomlinesEventAdd";


    $tSesUsrLev = $this->session->userdata("tSesUsrLevel");
    $tSesUsrBchMuti =   $this->session->userdata("tSesUsrBchCodeMulti");
    $tSesUsrBchCount = $this->session->userdata("nSesUsrBchCount");
    $tSesAgnCode =  $this->session->userdata('tSesUsrAgnCode');
    $tSesAgnName =  $this->session->userdata('tSesUsrAgnName');

    $tSesUsrBchName =   $this->session->userdata("tSesUsrBchNameDefault");
    $tSesUsrBchCode = $this->session->userdata("tSesUsrBchCodeDefault");



    if ($tSesUsrLev != 'HQ') {
        $tAgnCode =  $tSesAgnCode;
        $tAgnName = $tSesAgnName;
    }

    if ($this->session->userdata("tSesUsrLoginLevel") != "HQ" && $this->session->userdata("tSesUsrLoginLevel") != "AGN") {
        $tChnBchCode = $tSesUsrBchCode;
        $tChnBchName = $tSesUsrBchName;
    }
}



$tHeadReceiptPlaceholder = "Head of Receipt";
$tEndReceiptPlaceholder = "End of Receipt";

?>
<style>
    .xWChnMoveIcon {
        cursor: move !important;
        border-radius: 0px;
        box-shadow: none;
        padding: 0px 10px;
    }

    .dragged {
        position: absolute;
        opacity: 0.5;
        z-index: 2000;
    }

    .xWChnDyForm {
        border-radius: 0px;
        border: 0px;
    }

    .xWChnBtn {
        box-shadow: none;
    }

    .xWChnItemSelect {
        margin-bottom: 5px;
    }

    .alert-validate::before,
    .alert-validate::after {
        z-index: 100;
    }

    .input-group-addon:not(:first-child):not(:last-child),
    .input-group-btn:not(:first-child):not(:last-child),
    .input-group .form-control:not(:first-child):not(:last-child) {
        border-radius: 4px;
    }
</style>
<div class="panel panel-headline">
    <div class="panel-body">
        <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddFashionComlines">
            <button style="display:none" type="submit" id="obtSubmitFashionComlines" onclick="JSnAddEditFashionComlines('<?= $tRoute ?>')"></button>

            <div class="panel-body" style="padding-top:20px !important;">
                <div class="row">
                    <div class="col-xs-12 col-md-5 col-lg-5">

                        <input type="hidden" class="input100 xCNHide" id="oetCmlUsrLoginLevel" name="oetCmlUsrLoginLevel" value="<?php echo $this->session->userdata("tSesUsrLoginLevel"); ?>">



                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('fashion/fashioncomlines/fashioncomlines', 'tFashionComlinesCode'); ?></label>
                        <div class="form-group" id="odvFashionComlinesAutoGenCode">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbFashionComlinesAutoGenCode" name="ocbFashionComlinesAutoGenCode" checked="true" value="1">
                                    <span><?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group" id="odvFashionComlinesCodeForm">
                            <input type="hidden" id="ohdCheckDuplicateCmlCode" name="ohdCheckDuplicateCmlCode" value="1">
                            <div class="validate-input">
                                <input type="text" class="form-control xCNInputWithoutSpcNotThai" maxlength="5" id="oetCmlCode" name="oetCmlCode" data-is-created="<?php echo $tCmlCode; ?>" placeholder="<?php echo language('fashion/fashioncomlines/fashioncomlines', 'tFashionComlinesCode'); ?>" autocomplete="off" value="<?php echo $tCmlCode; ?>" data-validate-required="<?php echo language('fashion/fashioncomlines/fashioncomlines', 'tFashionComlinesValidCode') ?>" data-validate-dublicateCode="<?php echo language('fashion/fashioncomlines/fashioncomlines', 'tFashionComlinesValidCodeDup'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos/poschannel/poschannel', 'tCHNLabelAgency'); ?></label>
                            <div class="input-group">
                                <input type="text" id="oetCmlAgnCode" class="form-control xCNHide" name="oetCmlAgnCode" value="<?php echo $tAgnCode; ?>">
                                <input type="text" id="oetCmlAgnName" class="form-control" name="oetCmlAgnName" value="<?php echo $tAgnName; ?>" data-validate-required="กรุณากรอกตัวแทนขาย" readonly>
                                <span class="input-group-btn">
                                    <?php
                                    // Last Update : 21/05/2020 nale  ถ้าเข้ามาเป็น User ระดับ HQ ให้เลือก Agency ได้
                                    if (!empty($this->session->userdata('tSesUsrAgnCode')) || $this->session->userdata('nSesUsrBchCount') > 0) {
                                        $tDisableBrowseAgency = 'disabled';
                                    } else {
                                        $tDisableBrowseAgency = '';
                                    }
                                    ?>
                                    <button id="obtBrowseAgency" type="button" class="btn xCNBtnBrowseAddOn" <?php echo @$tDisableBrowseAgency; ?>>
                                        <img class="xCNIconFind">
                                    </button>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('fashion/fashioncomlines/fashioncomlines', 'tFashionComlinesName'); ?></label>

                                <input type="text" class="form-control" maxlength="50" id="oetCmlName" name="oetCmlName" autocomplete="off" placeholder="<?php echo language('fashion/fashioncomlines/fashioncomlines', 'tFashionComlinesName'); ?>" value="<?php echo $tCmlName; ?>" data-validate-required="<?php echo language('fashion/fashioncomlines/fashioncomlines', 'tFashionComlinesValidName'); ?>">
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('product/pdtmodel/pdtmodel', 'tPMOFrmPmoRmk') ?></label> <!-- เปลี่ยนชื่อ Class -->
                            <textarea class="form-control" maxlength="50" rows="4" id="otaCmlartRmk" name="otaCmlartRmk"><?= $tCmlRmk ?></textarea>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script type="text/html" id="oscSlipHeadRowTemplate">
    <div class="form-group xWChnItemSelect" id="{0}">
        <div class="input-group validate-input">
            <span class="input-group-btn">
                <div class="btn xWChnMoveIcon" type="button"><i class="icon-move fa fa-arrows"></i></div>
            </span>
            <input type="text" class="form-control xWChnDyForm" maxlength="50" id="oetChnSlipHead{0}" name="oetChnSlipHead[{0}]" value="" placeholder="<?php echo $tHeadReceiptPlaceholder; ?> {0}" data-validate="<?php echo language('pos/slipMessage/slipmessage', 'tSMGValidHead'); ?>">
            <span class="input-group-btn">
                <button class="btn pull-right xWChnBtn xWChnBtnDelete" onclick="JSxFashionComlinesDeleteRowHead(this, event)"><?php echo language('pos/slipMessage/slipmessage', 'tSMGDeleteRow'); ?></button>
            </span>
        </div>
    </div>
</script>
<script type="text/html" id="oscSlipEndRowTemplate">
    <div class="form-group xWChnItemSelect" id="{0}">
        <div class="input-group validate-input">
            <span class="input-group-btn">
                <div class="btn xWChnMoveIcon" type="button"><i class="icon-move fa fa-arrows"></i></div>
            </span>
            <input type="text" class="form-control xWChnDyForm" maxlength="50" id="oetChnSlipEnd{0}" name="oetChnSlipEnd[{0}]" value="" placeholder="<?php echo $tEndReceiptPlaceholder; ?> {0}">
            <span class="input-group-btn">
                <button class="btn pull-right xWChnBtn xWChnBtnDelete" onclick="JSxFashionComlinesDeleteRowEnd(this, event)"><?php echo language('pos/slipMessage/slipmessage', 'tSMGDeleteRow'); ?></button>
            </span>
        </div>
    </div>
</script>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>
<?php include 'script/jFashioncomlinesAdd.php'; ?>

<script type="text/javascript">
    $(function() {
        if (JCNbChanelIsCreatePage()) { // For create page

            // Set head of receipt default
            JSxChanelRowDefualt('head', 1);
            // Set end of receipt default
            JSxChanelRowDefualt('end', 1);

        } else { // for update page

            if (JCNnChanelCountRow('head') <= 0) {
                // Set head of receipt default
                JSxChanelRowDefualt('head', 1);
            }
            if (JCNnChanelCountRow('end') <= 0) {
                // Set end of receipt default
                JSxChanelRowDefualt('end', 1);
            }

        }
        JSaChanelGetSortData('head');
        // Remove sort data
        JSxChanelRemoveSortData('all');

        $('#odvChnSlipHeadContainer').sortable({
            items: '.xWChnItemSelect',
            opacity: 0.7,
            axis: 'y',
            handle: '.xWChnMoveIcon',
            update: function(event, ui) {
                var aToArray = $(this).sortable('toArray');
                var aSerialize = $(this).sortable('serialize', {
                    key: ".sort"
                });
                // JSxChanelSetRowSortData('head', aToArray);
                // JSoChanelSortabled('head', true);
            }
        });

        $('#odvChnSlipEndContainer').sortable({
            items: '.xWChnItemSelect',
            opacity: 0.7,
            axis: 'y',
            handle: '.xWChnMoveIcon',
            update: function(event, ui) {
                var aToArray = $(this).sortable('toArray');
                var aSerialize = $(this).sortable('serialize', {
                    key: ".sort"
                });
            }
        });

        $('.xWTooltipsBT').tooltip({
            'placement': 'bottom'
        });
        $('[data-toggle="tooltip"]').tooltip({
            'placement': 'top'
        });

        $('#oimChnBrowseProvince').click(function() {
            JCNxBrowseData('oPvnOption');
        });

        if (JCNbChanelIsUpdatePage()) {
            $("#obtGenCodeChanel").attr("disabled", true);
        }
    });

    var nLangEdits = '<?php echo $this->session->userdata("tLangEdit") ?>';
    var nStaPdtBrowseType = $('#ohdPdtStaBrowseType').val();

    // Click Browse Agency
    $('#obtBrowseAgency').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oPdtBrowseAgency({
                'tReturnInputCode': 'oetCmlAgnCode',
                'tReturnInputName': 'oetCmlAgnName',
                // 'tBchCodeWhere': $('#oetPdtBchCode').val(),
            });
            JCNxBrowseData('oPdtBrowseAgencyOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });



    //เลือกตัวแทนขาย
    var oPdtBrowseAgency = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;
        // var tBchCodeWhere = poReturnInput.tBchCodeWhere;

        var tSesLev = '<?php echo $this->session->userdata('tSesUsrLevel'); ?>'
        var tSesAgenCde = '<?php echo $this->session->userdata('tSesUsrAgnCode'); ?>'

        var tWhereAgn = '';
        if (tSesLev != 'HQ') {
            tWhereAgn = " AND TCNMBranch.FTAgnCode = '" + tSesAgenCde + "'";
        } else {
            tWhereAgn = '';
        }

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
            Where: {
                Condition: [
                    tWhereAgn
                ]
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
            BrowseLev: nStaPdtBrowseType,
            // NextFunc: {
            //     FuncName: 'JSxClearBrowseConditionAgn',
            //     ArgReturn: ['FTAgnCode']
            // }
        }
        return oOptionReturn;
    }

    // function JSxClearBrowseConditionAgn(ptData) {
    //     // aData = JSON.parse(ptData);
    //     if (ptData != '' || ptData != 'NULL') {

    //         $('#oetWahBchCodeCreated').val('');
    //         $('#oetWahBchNameCreated').val('');

    //         $('#oetBchWahCode').val('');
    //         $('#oetBchWahName').val('');
    //     }
    // }
</script>
