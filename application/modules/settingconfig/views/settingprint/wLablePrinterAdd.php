<?php
if ($aResult['rtCode'] == "1") {
    $tLabPriCode       = $aResult['raItems']['rtPrnLabCode'];
    $tLabPriName       = $aResult['raItems']['rtPrnLabName'];
    $tLabPriRmk        = $aResult['raItems']['rtPrnLabRmk'];
    $tRoute         = "LablePrinterEventEdit";
    $tLabPriStaUse = $aResult['raItems']['rtPrnLabStaUse'];
    $tLabPriPortPrnCode = $aResult['raItems']['rtPortPrnCode'];
    $tLabPriPortPrnName = $aResult['raItems']['rtPortPrnName'];
    $tLabPriLabFrtCode = $aResult['raItems']['rtLabFrtCode'];
    $tLabPriLabFrtName = $aResult['raItems']['rtLabFrtName'];

    $tUsrAgnCode    = $aResult['raItems']['FTAgnCode'];
    $tUsrAgnName    = $aResult['raItems']['FTAgnName'];
} else {
    $tLabPriCode       = "";
    $tLabPriName       = "";
    $tLabPriRmk        = "";
    $tRoute         = "LablePrinterEventAdd";
    $tLabPriStaUse = 1;
    $tLabPriPortPrnCode = '';
    $tLabPriPortPrnName = '';
    $tLabPriLabFrtCode = '';
    $tLabPriLabFrtName = '';

    $tUsrAgnCode    = $this->session->userdata("tSesUsrAgnCode");
    $tUsrAgnName    = $this->session->userdata("tSesUsrAgnName");
}
?>
<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddLabPri">
    <button style="display:none" type="submit" id="obtSubmitLabPri" onclick="JSnAddEditLabPri('<?= $tRoute ?>')"></button>
    <div style="margin-top:15px;">
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('product/settingprinter/settingprinter', 'tLPTBCode') ?></label>
                    <div id="odvLabPriAutoGenCode" class="form-group">
                        <div class="validate-input">
                            <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbLabPriAutoGenCode" name="ocbLabPriAutoGenCode" checked="true" value="1">
                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                            </label>
                        </div>
                    </div>
                    <div id="odvLabPriCodeForm" class="form-group">
                        <input type="hidden" id="ohdCheckDuplicateLabPriCode" name="ohdCheckDuplicateLabPriCode" value="1">
                        <div class="validate-input">
                            <input type="text" class="form-control xCNGenarateCodeTextInputValidate" maxlength="5" id="oetLabPriCode" name="oetLabPriCode" data-is-created="<?php echo $tLabPriCode; ?>" placeholder="<?php echo language('product/settingprinter/settingprinter', 'tLPTBCode') ?>" value="<?= $tLabPriCode; ?>" autocomplete="off" data-validate-required="<?php echo language('product/settingprinter/settingprinter', 'tLPValidLPCode') ?>" data-validate-dublicateCode="<?php echo language('product/settingprinter/settingprinter', 'tSPVldCodeDuplicate') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">

                <!-- Agency -->
                <div class="<?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                    <div class="form-group">
                        <label
                            class="xCNLabelFrm"><?php echo language('common/main/main','tAgency')?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetLabPriAgnCode" 
                                name="oetLabPriAgnCode" 
                                value="<?=@$tUsrAgnCode?>">
                            <input type="text" class="form-control xWPointerEventNone" id="oetLabPriAgnName"
                                name="oetLabPriAgnName"
                                placeholder="<?php echo language('common/main/main','tAgency')?>"
                                value="<?=@$tUsrAgnName?>" readonly>
                            <span class="input-group-btn">
                                <button id="obtLabPriBrowseAgency" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img
                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- end Agency -->

                <?php
                if ($tRoute ==  "pdtgroupEventAdd") {
                    $tDisabled     = '';
                    $tNameElmIDAgn = 'oimBrowseAgn';
                } else {
                    $tDisabled      = '';
                    $tNameElmIDAgn  = 'oimBrowseAgn';
                }
                ?>


                <div class="form-group">
                    <div class="validate-input" data-validate="<?php echo language('product/settingprinter/settingprinter', 'tLPTBName') ?>">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('product/settingprinter/settingprinter', 'tLPTBName') ?></label>
                        <input type="text" class="form-control" maxlength="100" id="oetLabPriName" name="oetLabPriName" placeholder="<?php echo language('product/settingprinter/settingprinter', 'tLPTBName') ?>" autocomplete="off" value="<?= $tLabPriName ?>" data-validate-required="<?php echo language('product/settingprinter/settingprinter', 'tLPValidLPName') ?>">
                    </div>
                </div>


                <div id="odvLableFormatName" class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('product/settingprinter/settingprinter', 'tLPTBLableFormat') ?></label>
                    <div class="input-group">
                        <input type="text" autocomplete="off" class="form-control xCNHide" id="oetLableFormatCode" name="oetLableFormatCode" value="<?php echo $tLabPriLabFrtCode;  ?>">
                        <div class="validate-input">
                            <input type="text" class="form-control xWPointerEventNone" id="oetLableFormatName" name="oetLableFormatName" placeholder="" value="<?php echo $tLabPriLabFrtName;  ?>" data-validate-required="<?php echo language('product/settingprinter/settingprinter', 'tLPTBValidLableFormat') ?>" readonly>
                        </div>
                        <span class="input-group-btn">
                            <button id="oimLableFormatBrowse" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                        </span>
                    </div>
                </div>

    

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><?php echo language('product/settingprinter/settingprinter', 'tSPFrmSPRmk') ?></label>
                                <textarea maxlength="100" rows="4" id="otaLabPriRemark" name="otaLabPriRemark"><?= $tLabPriRmk ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="fancy-checkbox">
                        <?php
                        if (isset($tLabPriStaUse) && $tLabPriStaUse == 1) {
                            $tChecked   = 'checked';
                        } else {
                            $tChecked   = '';
                        }
                        ?>
                        <input type="checkbox" id="ocbLabPriStatusUse" name="ocbLabPriStatusUse" <?php echo $tChecked; ?>>
                        <span> <?php echo language('common/main/main', 'tStaUse'); ?></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include "script/jLablePrinterAdd.php"; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>

<script type="text/javascript">
    $('.xWTooltipsBT').tooltip({
        'placement': 'bottom'
    });
    $('[data-toggle="tooltip"]').tooltip({
        'placement': 'top'
    });

    $('#oimLabPriBrowseProvince').click(function() {
        JCNxBrowseData('oPvnOption');
    });

    if (JCNLabPriIsUpdatePage()) {
        $("#obtGenCodeLabPri").attr("disabled", true);
    }

    //Browse TCNSLabelFmt
    $('#oimLableFormatBrowse').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oPdtBrowseLableFormatOption = oBrowseLableFormat({
                'tReturnInputCode': 'oetLableFormatCode',
                'tReturnInputName': 'oetLableFormatName',
            });
            JCNxBrowseData('oPdtBrowseLableFormatOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    //Browse TsysPortPrn
    $('#oimPortPrnBrowse').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oPdtBrowsePortPrnOption = oBrowsePortPrn({
                'tReturnInputCode': 'oetPortPrnCode',
                'tReturnInputName': 'oetPortPrnName',
            });
            JCNxBrowseData('oPdtBrowsePortPrnOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    //Browse Agn  
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




    //Option LableFormat 
    var oBrowseLableFormat = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;

        var oOptionReturn = {
            Title: ['product/settingprinter/settingprinter', 'tLPTBLableTitle'],
            Table: {
                Master: 'TCNSLabelFmt',
                PK: 'FTLblCode'
            },
            Join: {
                Table: ['TCNSLabelFmt_L'],
                On: ['TCNSLabelFmt_L.FTLblCode = TCNSLabelFmt.FTLblCode AND TCNSLabelFmt_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [" AND TCNSLabelFmt.FTLblStaUse = '1' "]
            },
            GrideView: {
                ColumnPathLang: 'product/settingprinter/settingprinter',
                ColumnKeyLang: ['tLPTBLableCode', 'tLPTBLableName'],
                ColumnsSize: ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TCNSLabelFmt.FTLblCode', 'TCNSLabelFmt_L.FTLblName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNSLabelFmt.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNSLabelFmt.FTLblCode"],
                Text: [tInputReturnName, "TCNSLabelFmt_L.FTLblName"],
            },
            NextFunc: {
                FuncName: 'JSxNextFuncFormatValidateLbl',
                ArgReturn: ['FTLblCode']
            },
            RouteAddNew: 'agency',
            BrowseLev: 1,
        }
        return oOptionReturn;
    }


    function JSxNextFuncFormatValidateLbl(ptLblCode) {
        if (ptLblCode != 'NULL') {
            $('#oetLableFormatName').removeAttr('data-validate-required')
            $('#oetLableFormatName').removeAttr('aria-describedby')
            $("#oetLableFormatName-error").css({
                "display": "none"
            })
            $('#odvLableFormatName').removeClass("has-error")
            $('#odvLableFormatName').addClass("has-success")
        } else {
            $('#odvLableFormatName').removeClass("has-success")
            $('#odvLableFormatName').addClass("has-error")
            $("#oetLableFormatName-error").removeAttr("style")
        }
    }

    //Option LableFormat 
    var oBrowsePortPrn = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;

        var oOptionReturn = {
            Title: ['product/settingprinter/settingprinter', 'tLPTBPortTitle'],
            Table: {
                Master: 'TSysPortPrn',
                PK: 'FTSppCode'
            },
            Join: {
                Table: ['TSysPortPrn_L'],
                On: ['TSysPortPrn_L.FTSppCode = TSysPortPrn.FTSppCode AND TSysPortPrn_L.FNLngID = ' + nLangEdits]
            },
            GrideView: {
                ColumnPathLang: 'product/settingprinter/settingprinter',
                ColumnKeyLang: ['tLPTBPortCode', 'tLPTBPortName'],
                ColumnsSize: ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TSysPortPrn.FTSppCode', 'TSysPortPrn_L.FTSppName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TSysPortPrn.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TSysPortPrn.FTSppCode"],
                Text: [tInputReturnName, "TSysPortPrn_L.FTSppName"],
            },
            NextFunc: {
                FuncName: 'JSxNextFuncFormatValidatePort',
                ArgReturn: ['FTSppCode']
            },
            RouteAddNew: 'agency',
            BrowseLev: 1,
        }
        return oOptionReturn;
    }


    function JSxNextFuncFormatValidatePort(ptLblCode) {
        if (ptLblCode != 'NULL') {
            $('#oetPortPrnName').removeAttr('data-validate-required')
            $('#oetPortPrnName').removeAttr('aria-describedby')
            $("#oetPortPrnName-error").css({
                "display": "none"
            })
            $('#odvPortPrnName').removeClass("has-error")
            $('#odvPortPrnName').addClass("has-success")
        } else {
            $('#odvPortPrnName').removeClass("has-success")
            $('#odvPortPrnName').addClass("has-error")
            $("#oetPortPrnName-error").removeAttr("style")
        }
    }



    var tStaUsrLevel = '<?php echo $this->session->userdata("tSesUsrLevel"); ?>';


    if (tStaUsrLevel == 'BCH' || tStaUsrLevel == 'SHP') {
        $('#oimBrowseAgn').attr("disabled", true);

    }

    var tStaUsrLevel    = "<?php  echo $this->session->userdata("tSesUsrLevel");?>";
    if( tStaUsrLevel != "HQ" ){
        $('#obtLabPriBrowseAgency').attr("disabled", true);
    }else{
        if( '<?=$tRoute?>' == "LablePrinterEventEdit" ){
            $('#obtLabPriBrowseAgency').attr("disabled", true);
        }else{
            $('#obtLabPriBrowseAgency').attr("disabled", false);
        }
    }


    $('#obtLabPriBrowseAgency').on('click',function(){
        var nStaSession  = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oUsrAgnOption       = undefined;
            oUsrAgnOption              = oUsrBrowseAgency({
                'tReturnInputCode'          : 'oetLabPriAgnCode',
                'tReturnInputName'          : 'oetLabPriAgnName',
                'aArgReturn'                : ['FTAgnCode','FTAgnName']
            });
            JCNxBrowseData('oUsrAgnOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    
    // Option Browse Merchant
    var oUsrBrowseAgency = function(poReturnInputAgency){
        let tInputReturnAgnCode   = poReturnInputAgency.tReturnInputCode;
        let tInputReturnAgnName   = poReturnInputAgency.tReturnInputName;
        let tAgencyNextFunc       = poReturnInputAgency.tNextFuncName;
        let aAgencyArgReturn      = poReturnInputAgency.aArgReturn;
        let nLangEdits            = "<?php echo $this->session->userdata("tLangEdit")?>";

        // let tJoinBranch = " LEFT JOIN ( SELECT FTMerCode FROM TCNMBranch GROUP BY FTMerCode ) B ON TCNMMerchant.FTMerCode = B.FTMerCode ";
        // let tJoinShop   = " LEFT JOIN ( SELECT FTMerCode FROM TCNMShop GROUP BY FTMerCode ) S ON TCNMMerchant.FTMerCode = S.FTMerCode ";

        let oAgencyOptionReturn = {
            Title : ['authen/user/user','tBrowseAgnTitle'],
            Table :{Master:'TCNMAgency',PK:'FTAgnCode'},
            Join :{
                Table:	['TCNMAgency_L'],
                On:[' TCNMAgency.FTAgnCode = TCNMAgency_L.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits] //+ tJoinBranch + tJoinShop
            },
            // Where :{
            //     Condition : [" AND ( ISNULL(B.FTMerCode,'') != '' OR ISNULL(S.FTMerCode,'') != '') "]
            // },
            GrideView:{
                ColumnPathLang	: 'authen/user/user',
                ColumnKeyLang	: ['tBrowseAgnCode','tBrowseAgnName'],
                ColumnsSize     : ['10%','75%'],
                DataColumns	    : ['TCNMAgency.FTAgnCode','TCNMAgency_L.FTAgnName'],
                DataColumnsFormat : ['',''],
                WidthModal      : 50,
                Perpage			: 10,
                OrderBy			: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnAgnCode,"TCNMAgency.FTAgnCode"],
                Text		: [tInputReturnAgnName,"TCNMAgency_L.FTAgnName"]
            },
            //DebugSQL: true,
        };
        return oAgencyOptionReturn;
    }

</script>