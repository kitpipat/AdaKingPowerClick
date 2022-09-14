<?php
if ($aResult['rtCode'] == "1") {

    $tSeaCode = $aResult['raHDItems']['rtSeaCode'];
    $tAgnCode = $aResult['raHDItems']['rtAgnCode'];
    $tSeaName = $aResult['raHDItems']['rtSeaName'];
    $tSeaRmk = $aResult['raHDItems']['rtSeaRmk'];
    $tAgnName = $aResult['raHDItems']['rtAgnName'];
    $nSeaLevel = $aResult['raHDItems']['rnSeaLevel'];
    $tSeaChain = $aResult['raHDItems']['rtSeaChain'];
    $tSeaParent = $aResult['raHDItems']['rtSeaParent'];
    $tSeaChainName = $aResult['raHDItems']['rtSeaChainName'];
    

    $tRoute = "fashionseasonEventEdit";
    $tDisabled  = 'disabled';
} else {


    $tSeaCode = '';
    $tAgnCode = '';
    $tSeaName = '';
    $tSeaRmk = '';
    $tAgnName = '';
    $nSeaLevel = 1;
    $tSeaChain = '';
    $tSeaParent = '';
    $tSeaChainName = '';

    $tRoute = "fashionseasonEventAdd";
    $tDisabled  = '';

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
        <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddFashionSeason">
            <button style="display:none" type="submit" id="obtSubmitFashionSeason" onclick="JSnAddEditFashionSeason('<?= $tRoute ?>')"></button>

            <div class="panel-body" style="padding-top:20px !important;">
                <div class="row">
                    <div class="col-xs-12 col-md-5 col-lg-5">

                        <input type="hidden" class="input100 xCNHide" id="oetSeaUsrLoginLevel" name="oetSeaUsrLoginLevel" value="<?php echo $this->session->userdata("tSesUsrLoginLevel"); ?>">



                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('fashion/fashionseason/fashionseason', 'tFashionSeasonCode'); ?></label>
                        <div class="form-group" id="odvFashionSeasonAutoGenCode">
                            <div class="validate-input">
                                <!-- <div class="col-xs-12 col-md-12 col-lg-12"> -->
                                <div class="row">
                                    <div class="col-xs-12 col-md-3 col-lg-3">
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbFashionSeasonAutoGenCode" name="ocbFashionSeasonAutoGenCode" checked="true" value="1">
                                            <span><?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                        </label>
                                    </div>
                                    <div class="col-xs-12 col-md-3 col-lg-3">
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbFashionSeasonLevel" name="ocbFashionSeasonLevel" checked="true" value="<?=$nSeaLevel?>">
                                            <span><?php echo language('fashion/fashionseason/fashionseason', 'tFashionSeasonLevel1'); ?></span>
                                        </label>
                                    </div>
                                </div>
                                <!-- </div> -->
                            </div>
                        </div>

                        <div class="form-group" id="odvFashionSeasonCodeForm">
                            <input type="hidden" id="ohdCheckDuplicateSeaCode" name="ohdCheckDuplicateSeaCode" value="1">
                            <div class="validate-input">
                                <input type="text" class="form-control xCNInputWithoutSpcNotThai" maxlength="3" id="oetSeaCode" name="oetSeaCode" data-is-created="<?php echo $tSeaCode; ?>" placeholder="<?php echo language('fashion/fashionseason/fashionseason', 'tFashionSeasonCode'); ?>" autocomplete="off" value="<?php echo $tSeaCode; ?>" data-validate-required="<?php echo language('fashion/fashionseason/fashionseason', 'tFashionSeasonValidCode') ?>" data-validate-dublicateCode="<?php echo language('fashion/fashionseason/fashionseason', 'tFashionSeasonValidCodeDup'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos/poschannel/poschannel', 'tCHNLabelAgency'); ?></label>
                            <div class="input-group">
                                <input type="text" id="oetSeaAgnCode" class="form-control xCNHide" name="oetSeaAgnCode" value="<?php echo $tAgnCode; ?>">
                                <input type="text" id="oetSeaAgnName" class="form-control" name="oetSeaAgnName" value="<?php echo $tAgnName; ?>" data-validate-required="กรุณากรอกตัวแทนขาย" readonly>
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
                                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('fashion/fashionseason/fashionseason', 'tFashionSeasonName'); ?></label>

                                <input type="text" class="form-control" maxlength="50" id="oetSeaName" name="oetSeaName" autocomplete="off" placeholder="<?php echo language('fashion/fashionseason/fashionseason', 'tFashionSeasonName'); ?>" value="<?php echo $tSeaName; ?>" data-validate-required="<?php echo language('fashion/fashionseason/fashionseason', 'tFashionSeasonValidName'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm xCWChainCode"><?php echo language('fashion/fashionseason/fashionseason', 'tFashionSeasonChain'); ?></label>
                            <div class="input-group">
                            <input type="text" id="oetSeaChainLev" class="form-control xCNHide" name="oetSeaChainLev" value="<?=$nSeaLevel?>">
                              <input type="text" id="oetSeaParentCode" class="form-control xCNHide" name="oetSeaParentCode" value="<?=$tSeaParent?>">
                                <input type="text" id="oetSeaChainCode" class="form-control xCNHide" name="oetSeaChainCode" value="<?=$tSeaChain?>">
                                <input type="text" id="oetSeaChainName" class="form-control" name="oetSeaChainName" value="<?php echo $tSeaChain; ?>" data-validate-required="กรุณากรอกรหัสลูกโซ่" readonly>
                                <span class="input-group-btn">
                                    <button id="obtBrowseChain" type="button" class="btn xCNBtnBrowseAddOn" <?=$tDisabled?>>
                                        <img class="xCNIconFind">
                                    </button>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="validate-input">
                                <input type="text" class="form-control" maxlength="100" id="oetSeaChainNameShow" name="oetSeaChainNameShow" value="<?php echo $tSeaChainName; ?>" readonly>
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('product/pdtmodel/pdtmodel', 'tPMOFrmPmoRmk') ?></label> <!-- เปลี่ยนชื่อ Class -->
                            <textarea class="form-control" maxlength="50" rows="4" id="otaSeaartRmk" name="otaSeaartRmk"><?= $tSeaRmk ?></textarea>
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
                <button class="btn pull-right xWChnBtn xWChnBtnDelete" onclick="JSxFashionSeasonDeleteRowHead(this, event)"><?php echo language('pos/slipMessage/slipmessage', 'tSMGDeleteRow'); ?></button>
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
                <button class="btn pull-right xWChnBtn xWChnBtnDelete" onclick="JSxFashionSeasonDeleteRowEnd(this, event)"><?php echo language('pos/slipMessage/slipmessage', 'tSMGDeleteRow'); ?></button>
            </span>
        </div>
    </div>
</script>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>
<?php include 'script/jFashionSeasonAdd.php'; ?>

<script type="text/javascript">
    $(document).ready(function() {
        // var nChk = $('#ocbFashionSeasonLevel').prop('checked', true);
        var nChk = $('#ocbFashionSeasonLevel').val();

        if (nChk == 1) {
            $('#oetSeaChainCode').hide();
            $('#oetSeaChainName').hide();
            $('#obtBrowseChain').hide();
            $('#oetSeaChainNameShow').hide();
            $('.xCWChainCode').hide();


        } else {
            $('#oetSeaChainCode').show();
            $('#oetSeaChainName').show();
            $('#oetSeaChainNameShow').show();
            $('#obtBrowseChain').show();
            $('.xCWChainCode').show();
        }

    });


    $('#ocbFashionSeasonLevel').change(function() {
        // var nChk = $('#ocbFashionSeasonLevel').val();
        // alert(nChk)
        if ($('#ocbFashionSeasonLevel').is(':checked')) {
            $('#oetSeaChainCode').hide();
            $('#oetSeaChainName').hide();
            $('#oetSeaChainNameShow').hide();
            $('#obtBrowseChain').hide();
            $('.xCWChainCode').hide();
        } else {
            $('#oetSeaChainCode').show();
            $('#oetSeaChainName').show();
            $('#oetSeaChainNameShow').show();
            $('#obtBrowseChain').show();
            $('.xCWChainCode').show();
        }
    });
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
                'tReturnInputCode': 'oetSeaAgnCode',
                'tReturnInputName': 'oetSeaAgnName',
                // 'tBchCodeWhere': $('#oetPdtBchCode').val(),
            });
            JCNxBrowseData('oPdtBrowseAgencyOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // Click Browse Season
    $('#obtBrowseChain').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oPdtBrowseSeasonOption = oPdtBrowseSeason({
                'tReturnInputCode': 'oetSeaChainCode',
                'tReturnInputName': 'oetSeaChainName',
                // 'tBchCodeWhere': $('#oetPdtBchCode').val(),
            });
            JCNxBrowseDataChain('oPdtBrowseSeasonOption');
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



    var oPdtBrowseSeason = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;
        // var tBchCodeWhere = poReturnInput.tBchCodeWhere;

        var tSesLev = '<?php echo $this->session->userdata('tSesUsrLevel'); ?>'
        var tSesAgenCde = '<?php echo $this->session->userdata('tSesUsrAgnCode'); ?>'

        var tWhereAgn = '';
        if (tSesLev != 'HQ') {
            tWhereAgn = " AND  ( TFHMPdtSeason.FTAgnCode = '" + tSesAgenCde + "' OR  ISNULL(TFHMPdtSeason.FTAgnCode,'') = '' )";
        } else {
            tWhereAgn = '';
        }

        var oOptionReturn = {
            Title: ['fashion/fashionseason/fashionseason', 'tFashionSeasonTitle'],
            Table: {
                Master: 'TFHMPdtSeason',
                PK: 'FTSeaCode',
                Chain:'FTSeaChain',
                Level:'FNSeaLevel',
                Parent:'FTSeaParent'
            },
            Join: {
                Table: ['TFHMPdtSeason_L'],
                On: ['TFHMPdtSeason_L.FTSeaCode = TFHMPdtSeason.FTSeaCode AND TFHMPdtSeason_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [
                    tWhereAgn 
                ]
            },
            GrideView: {
                ColumnPathLang: 'fashion/fashionseason/fashionseason',
                ColumnKeyLang: ['tFashionSeasonCode', 'tFashionSeasonName' , 'tFashionSeasonName' , 'tFashionSeasonName', 'tFashionSeasonName'],
                ColumnsSize: ['15%', '30%', '30%', '30%'],
                WidthModal: 50,
                DataColumns: ['TFHMPdtSeason.FTSeaCode', 'TFHMPdtSeason_L.FTSeaName', 'TFHMPdtSeason.FTSeaChain', 'TFHMPdtSeason_L.FTSeaChainName', 'TFHMPdtSeason.FNSeaLevel'],
                DisabledColumns	:[2,3,4],
                DataColumnsFormat: ['', '', '', '', ''],
                Perpage: 10,
                OrderBy: ['TFHMPdtSeason.FTSeaCode ASC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TFHMPdtSeason.FTSeaChain"],
                Text: [tInputReturnName, "TFHMPdtSeason.FTSeaChain"],
            },
            RouteAddNew: 'agency',
            BrowseLev: nStaPdtBrowseType,
            NextFunc: {
                FuncName: 'JSxBrowseConditionSea',
                ArgReturn: ['FTSeaCode','FTSeaName','FTSeaChain','FTSeaChainName','FNSeaLevel']
            }
        }
        return oOptionReturn;
    }

    function JSxBrowseConditionSea(ptData) {
        aData = JSON.parse(ptData);
        console.log(aData);
        if (aData != aData != 'NULL') {
            var tSeaCode = aData[0];
            var tSeaName = aData[1];
            var tSeaChain = aData[2];
            var tSeaChainName = aData[3];
            var nSeaLevel = parseInt(aData[4])+1;
            $('#oetSeaChainCode').val(tSeaChain);
            $('#oetSeaChainNameShow').val(tSeaChainName); 
            $('#oetSeaParentCode').val(tSeaCode);
            $('#oetSeaChainLev').val(nSeaLevel);
            // $('#oetSeaChainNameShow').val(tChainNameShow);

        }
    }
</script>