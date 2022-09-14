<?php
if($aResult['rtCode'] == "1"){
    $tCstLevCode       = $aResult['raItems']['rtCstLevCode'];
    $tCstLevName       = $aResult['raItems']['rtCstLevName'];
    $tCstLevRtePntAge  = $aResult['raItems']['rtCstLevRtePntAge'];

    $tCstLevPplCode  = $aResult['raItems']['rtCstLevPplCode'];
    $tCstLevPplName  = $aResult['raItems']['rtCstLevPplName'];
    $tCstLevRtePntAmt  = $aResult['raItems']['rtCstLevRtePntAmt'];
    $tCstLevRtePntQty  = $aResult['raItems']['rtCstLevRtePntQty'];
    $tCstLevStaAlwPnt  = $aResult['raItems']['rtCstLevStaAlwPnt'];

    $tCstLevRmk        = $aResult['raItems']['rtCstLevRmk'];
    $tRoute         = "customerLevelEventEdit";

    $tCstLevAgnCode   = $aResult['raItems']['rtAgnCode'];
    $tCstLevAgnName   = $aResult['raItems']['rtAgnName'];
}else{
    $tCstLevCode        = "";
    $tCstLevName        = "";
    $tCstLevRmk         = "";
    $tCstLevRtePntAge   = 0;
    $tCstLevPplCode     = "";
    $tCstLevPplName     = "";
    $tCstLevRtePntAmt   = 0;
    $tCstLevRtePntQty   = 0;
    $tCstLevStaAlwPnt   = "";
    $tRoute             = "customerLevelEventAdd";

    $tCstLevAgnCode   = $aResult['tSesAgnCode'];
    $tCstLevAgnName   = $aResult['tSesAgnName'];
}
?>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCstLev">
    <button style="display:none" type="submit" id="obtSubmitCstLev" onclick="JSnAddEditCstLev('<?= $tRoute?>')"></button>
    <div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('customer/customerLevel/customerLevel','tCstLevCode'); ?><?= language('customer/customerLevel/customerLevel','tCstLevTitle')?></label>
                <div id="odvCstLevAutoGenCode" class="form-group">
                <div class="validate-input">
                <label class="fancy-checkbox">
                    <input type="checkbox" id="ocbCustomerLevelAutoGenCode" name="ocbCustomerLevelAutoGenCode" checked="true" value="1">
                    <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                </label>
            </div>
        </div>
            <div id="odvCstLevCodeForm" class="form-group">
                <input type="hidden" id="ohdCheckDuplicateCstLevCode" name="ohdCheckDuplicateCstLevCode" value="1">  
                        <div class="validate-input">
                        <input 
                        type="text" 
                        class="form-control xCNGenarateCodeTextInputValidate" 
                        maxlength="5" 
                        id="oetCstLevCode" 
                        name="oetCstLevCode"
                        data-is-created="<?php echo $tCstLevCode;?>"
                        placeholder="<?php echo language('customer/customerLevel/customerLevel','tCstLevTBCode'); ?>"
                        value="<?= $tCstLevCode; ?>" 
                        data-validate-required = "<?= language('customer/customerLevel/customerLevel','tCstLevValidCode')?>"
                        data-validate-dublicateCode = "<?= language('customer/customerLevel/customerLevel','tCstLevValidCheckCode')?>"
                    >
                </div>
            </div>
        </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">

            <?php
                if ($tRoute ==  "pdtgroupEventAdd") {
                    $tCstLevAgnCode   = $tSesAgnCode;
                    $tCstLevAgnCode   = $tSesAgnName;
                    $tDisabled     = '';
                    $tNameElmIDAgn = 'oimBrowseAgn';
                } else {
                    $tCstLevAgnCode    = $tCstLevAgnCode;
                    $tCstLevAgnCode    = $tCstLevAgnCode;
                    $tDisabled      = '';
                    $tNameElmIDAgn  = 'oimBrowseAgn';
                }
                ?>


                <!-- เพิ่ม AD Browser -->
                <div class="form-group  <?php if (!FCNbGetIsAgnEnabled()) : echo 'xCNHide';
                                        endif; ?>">
                    <label class="xCNLabelFrm"><?php echo language('product/pdtgroup/pdtgroup', 'tPGPAgency') ?></label>
                    <div class="input-group"><input type="text" class="form-control xCNHide" id="oetCstLevAgnCode" name="oetCstLevAgnCode" maxlength="5" value="<?= @$tCstLevAgnCode; ?>">
                        <input type="text" class="form-control xWPointerEventNone" id="oetCstLevAgnName" name="oetCstLevAgnName" maxlength="100" placeholder="<?php echo language('interface/connectionsetting/connectionsetting', 'tTBAgency') ?>" value="<?= @$tCstLevAgnName; ?>" readonly>
                        <span class="input-group-btn">
                            <button id="<?= @$tNameElmIDAgn; ?>" type="button" class="btn xCNBtnBrowseAddOn <?= @$tDisabled ?>">
                                <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
                </div>

                <!--ชื่อระดับลูกค้า -->
                <div class="form-group">
                    <div class="validate-input" data-validate="Please Insert Name">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('customer/customerLevel/customerLevel','tCstLevName')?><?= language('customer/customerLevel/customerLevel','tCstLevCustomer')?></label>
                        <input type="text" class="input100" maxlength="100" id="oetCstLevName" name="oetCstLevName" value="<?= $tCstLevName ?>"
                        data-validate-required = "<?= language('customer/customerLevel/customerLevel','tCstLevvalidateName')?>">
                    </div>
                </div>

                <!-- รหัสกลุ่มราคา -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('product/pdtgroup/pdtgroup', 'กลุ่มราคา') ?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNHide" id="oetCstLevPplCode" name="oetCstLevPplCode" maxlength="5" value="<?= $tCstLevPplCode; ?>">
                        <input type="text" class="form-control xWPointerEventNone" id="oetCstLevPplName" name="oetCstLevPplName" maxlength="100" value="<?= $tCstLevPplName; ?>" readonly>
                        <span class="input-group-btn">
                            <button id="oimBrowsePpl" type="button" class="btn xCNBtnBrowseAddOn">
                                <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
                </div>

                <!-- อัตราส่วน มูลค่าเงิน -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('customer/customerLevel/customerLevel','tCstRtePntAmt')?></label>
                    <?php 
                        
                        if ($tCstLevRtePntAmt != "") {
                            $nRtePntAmt = number_format($tCstLevRtePntAmt, $nOptDecimalShow, '.', '');
                        }else {
                            $nRtePntAmt = 0;
                        }  
                    ?>
                    <input type="text" class="input100 xCNInputNumericWithDecimal text-right" maxlength="18" id="oetCstLevRtePntAmt" name="oetCstLevRtePntAmt" value="<?=$nRtePntAmt?>"
                    data-validate-required = "<?= language('customer/customerLevel/customerLevel','tCstLevvalidateName')?>">
                </div>

                <!-- อัตราส่วน แต้มได้รับ -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('customer/customerLevel/customerLevel','tCstRtePntQty')?></label>
                    <?php 
                        
                        if ($tCstLevRtePntQty != "") {
                            $nRtePntQty = number_format($tCstLevRtePntQty, $nOptDecimalShow, '.', '');
                        }else {
                            $nRtePntQty = 0;
                        }  
                    ?>
                    <input type="text" class="input100 xCNInputNumericWithDecimal text-right" maxlength="18" id="oetCstLevRtePntQty" name="oetCstLevRtePntQty" value="<?=$nRtePntQty?>"
                    data-validate-required = "<?= language('customer/customerLevel/customerLevel','tCstLevvalidateName')?>">
                </div>

                <!-- อายุแต้ม (วัน) -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('customer/customerLevel/customerLevel','tCstPointExp')?></label>
                    <?php 
                        
                        if ($tCstLevRtePntAge != "") {
                            $nStaPoint = number_format($tCstLevRtePntAge, $nOptDecimalShow, '.', '');
                        }else {
                            $nStaPoint = 0;
                        }  
                    ?>
                    <input type="text" class="input100 xCNInputNumericWithDecimal text-right" maxlength="100" id="oetCstPointExp" name="oetCstPointExp" value="<?=$nStaPoint?>">
                </div>

                <!-- หมายเหตุ -->
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><?= language('customer/customerLevel/customerLevel','tCstLevNote')?></label>
                                <textarea maxlength="100" rows="4" id="otaCstLevRemark" name="otaCstLevRemark"><?= $tCstLevRmk ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- สถานะอนุญาตให้สะสมแต้ม -->
                <div class="form-group">
                    <label class="fancy-checkbox">
                        <?php
                        if (isset($tCstLevStaAlwPnt) && $tCstLevStaAlwPnt == 1) {
                            $tChecked   = 'checked';
                        } else {
                            $tChecked   = '';
                        }
                        ?>
                        <input type="checkbox" id="ocbCstLevStaAlwAccPoint" name="ocbCstLevStaAlwAccPoint" <?php echo $tChecked; ?>>
                        <span> <?php echo language('payment/recivespc/recivespc', 'tRcvSpcStaAlwAccPoint'); ?></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js');?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js');?>"></script>
<?php include "script/jCustomerLevelAdd.php";?>
<script type="text/javascript">
    $('.xWTooltipsBT').tooltip({'placement': 'bottom'});
    $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});

    $('#oimCstLevBrowseProvince').click(function(){
        JCNxBrowseData('oPvnOption');
    });

    if(JCNCstLevIsUpdatePage()){
        $("#obtGenCodeCstLev").attr("disabled", true);
    }

     //BrowseAgn 
     $('#oimBrowseAgn').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oBrowseAgn({
                'tReturnInputCode': 'oetCstLevAgnCode',
                'tReturnInputName': 'oetCstLevAgnName',
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

    //Browse กลุ่มมราคา
    $('#oimBrowsePpl').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oBrowsePpl({
                'tReturnInputCode': 'oetCstLevPplCode',
                'tReturnInputName': 'oetCstLevPplName',
            });
            JCNxBrowseData('oPdtBrowseAgencyOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;

    //option กลุ่มมราคา
    var oBrowsePpl = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;

        var oOptionReturn = {
            Title: ['customer/customer/customer', 'tCSTPplRet'],
            Table: {
                Master: 'TCNMPdtPriList',
                PK: 'FTPplCode'
            },
            Join: {
                Table: ['TCNMPdtPriList_L'],
                On: ['TCNMPdtPriList_L.FTPplCode = TCNMPdtPriList.FTPplCode AND TCNMPdtPriList_L.FNLngID = ' + nLangEdits]
            },
            GrideView: {
                ColumnPathLang: 'document/conditionredeem/conditionredeem',
                ColumnKeyLang: ['tRDHTabCouponHDCstPriCode', 'tRDHTabCouponHDCstPriName'],
                ColumnsSize: ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TCNMPdtPriList.FTPplCode', 'TCNMPdtPriList_L.FTPplName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMPdtPriList.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMPdtPriList.FTPplCode"],
                Text: [tInputReturnName, "TCNMPdtPriList_L.FTPplName"],
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
