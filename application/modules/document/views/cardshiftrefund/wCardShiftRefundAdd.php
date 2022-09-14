<?php
if($aResult['rtCode'] == "1"){
    $tCardShiftRefundDocNo = $aResult['raItems']['rtCardShiftRefundDocNo'];
    $tCardShiftRefundDocDate = date('Y-m-d', strtotime($aResult['raItems']['rtCardShiftRefundDocDate']));
    $tCardShiftRefundCardQty = $aResult['raItems']['rtCardShiftRefundCardQty'];
    $tCardShiftRefundCardStaPrcDoc = $aResult['raItems']['rtCardShiftRefundStaPrcDoc'];
    $tCardShiftRefundStaDelMQ = $aResult['raItems']['rtCardShiftRefundStaDelMQ'];
    $tCardShiftRefundCardStaDoc = $aResult['raItems']['rtCardShiftRefundStaDoc'];
    $tCardShiftRefundAmtTP = number_format($aResult['raItems']['rtCardShiftRefundAmtTP'], 0, "", "");
    $tCardShiftRefundTotalTP = $aResult['raItems']['rtCardShiftRefundTotalTP'];
    $tRoute = "cardShiftRefundEventEdit";

    $tUsrBchCode = $aResult['raItems']['rtCardShiftRefundBchCode'];

    // $tUserCode = $aResult['raItems']['FTUsrCode'];
    // $tUserName = $aResult['raItems']['FTUsrName'];

    $tUserCreatedCode = $aResult['raItems']['FTUsrCodeCreate'];
    $tUserCreatedName = $aResult['raItems']['FTUsrNameCreate'];

    $tUserApvCode = $aResult['raItems']['FTUsrCodeApv'];
    $tUserApvName = $aResult['raItems']['FTUsrNameApv'];

}else{
    $tCardShiftRefundDocNo = "";
    $tCardShiftRefundDocDate = date('Y-m-d');
    $tCardShiftRefundCardQty = "";
    $tCardShiftRefundCardStaPrcDoc = "";
    $tCardShiftRefundCardStaDoc = "";
    $tCardShiftRefundStaDelMQ = "";
    $tRoute = "cardShiftRefundEventAdd";
    $tCardShiftRefundAmtTP = "";
    $tCardShiftRefundTotalTP = "";

    $tUsrBchCode = $this->session->userdata("tSesUsrBchCodeDefault");

    // $tUserCode = $this->session->userdata("tSesUserCode");
    // $tUserName = $this->session->userdata("tSesUsername");

    // $tUserCreatedCode = $this->session->userdata("tSesUserCode");
    // $tUserCreatedName = $this->session->userdata("tSesUsername");

    // $tUserApvCode = "";
    // $tUserApvName = "";
}

if($aUser["rtCode"] == "1"){
    $tUserCode = $aUser["raItems"]["rtUsrCode"];
    $tUserName = $aUser["raItems"]["rtUsrName"];
}else{
    $tUserCode = "";
    $tUserName = "";
}

if($aUserCreated["rtCode"] == "1"){
    $tUserCreatedCode = $aUserCreated["raItems"]["rtUsrCode"];
    $tUserCreatedName = $aUserCreated["raItems"]["rtUsrName"];
}else{
    $tUserCreatedCode = "";
    $tUserCreatedName = "";
}

if($aUserApv["rtCode"] == "1"){
    $tUserApvCode = $aUserApv["raItems"]["rtUsrCode"];
    $tUserApvName = $aUserApv["raItems"]["rtUsrName"];
}else{
    $tUserApvCode = "";
    $tUserApvName = "";
}

$nVateRate = $aActiveVatrate['rtVatRate'];
if($aResult['rtCode'] == "1"){
    $nVat = 0;
    $nVat = ($tCardShiftRefundTotalTP * $nVateRate) / 100; // Cale vate
    $nNetVat = $tCardShiftRefundTotalTP + $nVat;
}else{
    $nNetVat = "";
}

if($aResult['rtCode'] == "1"){
    //Page : EDIT
    $tUserBchName = $aResult['raItems']['FTBchName'];
    $tUserBchCode = $aResult['raItems']['FTBchCode'];
}else{
    //Page : ADD
    $tUserBchName = $this->session->userdata('tSesUsrBchNameDefault');
    $tUserBchCode = $this->session->userdata('tSesUsrBchCodeDefault');
}


?>
<style>
    .fancy-radio label {
        width: 150px;
    }
    .xWMsgConditonErr {
        color: red !important;
        font-size: 18px !important;
    }
    .table tbody tr.text-danger,
    .table>tbody>tr.text-danger>td{
        color: #F9354C !important;
    }
</style>

<div class="row">
    <div class="xWLeftContainer col-xl-4 col-lg-4 col-md-4">
        <!--Panel ข้อมูลเอกสาร-->
        <div class="panel panel-default" style="margin-bottom: 25px;">
            <div id="odvPIHeadStatusInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('document/card/cardrefund','tCardShiftRefundDocumentation'); ?></label>
                <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvCardShiftRefundInfo" aria-expanded="true">
                    <i class="fa fa-plus xCNPlus"></i>
                </a>
            </div>
            <div id="odvCardShiftRefundInfo" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                <div class="panel-body">
                    <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCardShiftRefundMainForm" name="ofmAddCardShiftRefundMainForm">
                        <button style="display:none" type="submit" id="obtSubmitCardShiftRefundMainForm" onclick="JSnCardShiftRefundAddEditCardShiftRefund('<?php echo $tRoute; ?>')"></button>
                        <input type="hidden" id="oetCardShiftRefundRoute" name="oetCardShiftRefundRoute" value="<?php echo $tRoute; ?>">
                        <input type="hidden" id="oetCardShiftRefundTotalValue" name="oetCardShiftRefundTotalValue" value="">
                        <input type="hidden" id="ohdCardShiftRefundLangCode" name="ohdCardShiftRefundLangCode" value="<?php echo $nLangEdit; ?>">
                        <input type="hidden" id="ohdCardShiftRefundUsrBchCode" name="ohdCardShiftRefundUsrBchCode" value="<?php echo $tUserBchCode; ?>">
                        <input type="hidden" id="oetCardShiftRefundCardType" name="oetCardShiftRefundCardType" value="">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/card/cardrefund','tCardShiftRefundTBDocNo'); ?></label>
                        <div class="form-group" id="odvCardShiftRefundAutoGenCode">
                            <div class="">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbCardShiftRefundAutoGenCode" name="ocbCardShiftRefundAutoGenCode" checked="true" value="1">
                                    <span class="xCNLabelFrm"> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group" id="odvCardShiftRefundDocNoForm">
                            <div class="validate-input">
                                <input
                                    type="text"
                                    class="form-control input100 xCNInputWithoutSpcNotThai"
                                    id="oetCardShiftRefundCode"
                                    aria-invalid="false"
                                    name="oetCardShiftRefundCode"
                                    data-is-created="<?php echo $tCardShiftRefundDocNo; ?>"
                                    placeholder="<?php echo language('document/card/cardrefund','tCardShiftRefundTBDocNo'); ?>"
                                    value="<?php echo $tCardShiftRefundDocNo; ?>"
                                    data-validate="Plese Generate Code">
                            </div>
                        </div>

                        <!--วันที่เอกสาร supawat 28-10-2019 -->
                        <div class="form-group">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><?php echo language('document/card/cardrefund','tCardShiftRefundTBDocDate'); ?></label>
                                <div class="input-group">
                                    <input
                                        class="form-control input100 xCNDatePicker"
                                        type="text"
                                        name="oetCardShiftRefundDocDate"
                                        id="oetCardShiftRefundDocDate"
                                        aria-invalid="false"
                                        value="<?php echo $tCardShiftRefundDocDate; ?>"
                                        data-validate="Please Insert Doc Date">
                                    <span class="input-group-btn">
                                        <button id="obtRefundDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <script>
                            $('#obtRefundDocDate').unbind().click(function(){
                                $('#oetCardShiftRefundDocDate').focus()
                            });
                        </script>

                        <div class="form-group">
                            <input type="hidden" id="ohdCardShiftRefundCardStaPrcDoc" name="ohdCardShiftRefundCardStaPrcDoc" value="<?php echo $tCardShiftRefundCardStaPrcDoc; ?>">
                            <input type="hidden" id="ohdCardShiftRefundCardStaDoc" name="hdCardShiftRefundCardStaDoc" value="<?php echo $tCardShiftRefundCardStaDoc; ?>">
                            <input type="hidden" id="ohdCardShiftRefundStaDelQname" name="ohdCardShiRefundStaDelQname" value="<?php echo $tCardShiftRefundStaDelMQ; ?>">
                            <?php
                            $tDocStatus = "";
                            if(empty($tCardShiftRefundCardStaPrcDoc) && !empty($tCardShiftRefundDocNo)){
                                $tDocStatus = language('document/card/cardrefund','tCardShiftRefundTBPending');
                            }

                            if($tCardShiftRefundCardStaPrcDoc == "2" || $tCardShiftRefundCardStaPrcDoc == "1"){ // Processing or approved
                                if($tCardShiftRefundCardStaPrcDoc == "2"){
                                    $tDocStatus = language('document/card/cardrefund','tCardShiftRefundTBProcessing');
                                }else{
                                    $tDocStatus = language('document/card/cardrefund','tCardShiftRefundTBApproved');
                                }
                            }else{
                                // if($tStaDoc == "1"){$tRowType = "xWDocComplete";} // Process to pending
                                if($tCardShiftRefundCardStaDoc == "2"){$tDocStatus = language('document/card/cardrefund','tCardShiftRefundTBIncomplete');}
                                if($tCardShiftRefundCardStaDoc == "3"){$tDocStatus = language('document/card/cardrefund','tCardShiftRefundTBCancel');}
                            }
                            ?>
                            <label class="xCNLabelFrm"><?php echo language('document/card/cardrefund','tCardShiftRefundTBDocStatus'); ?> <span><?php echo $tDocStatus; ?></span></label>
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="ohdCardShiftRefundUsrCode" name="ohdCardShiftRefundUsrCode" value="<?php echo $tUserCreatedCode; ?>">
                            <input type="hidden" id="ohdCardShiftRefundUserCreatedCode" name="ohdCardShiftRefundUserCreatedCode" value="<?php if(empty($tUserCreatedCode)){echo $tUserCreatedCode;}else{echo $tUserCreatedCode;} ?>">
                            <input type="hidden" id="ohdCardShiftRefundUserCreatedName" name="ohdCardShiftRefundUserCreatedName" value="<?php if(empty($tUserCreatedName)){echo $tUserCreatedName;}else{echo $tUserCreatedName;} ?>">
                            <label class="xCNLabelFrm"><?php echo language('document/card/cardrefund','tCardShiftRefundCreator'); ?> <span><?php if(empty($tUserCreatedName)){echo $tUserName;}else{echo $tUserCreatedName;} ?></span></label>
                            <div class="clearfix"></div>
                            <?php if($aResult['rtCode'] == "1") : ?>
                                <input type="hidden" id="ohdCardShiftRefundApvCode" name="ohdCardShiftRefundApvCode" value="<?php if(empty($tUserApvCode)){echo $tUserCreatedCode;}else{echo $tUserApvCode;} ?>">
                                <label class="xCNLabelFrm"><?php echo language('document/card/cardrefund','tCardShiftRefundApprover'); ?>
                                    <span id="ospCardShiftRefundApvName" class="hidden"><?php if(empty($tUserApvName)){echo $tUserCreatedName;}else{echo $tUserApvName;} ?></span>
                                </label>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Panel เลือกข้อมูลตามเงื่อนไข-->
        <div class="panel panel-default" style="margin-bottom: 25px;">
            <div id="odvPIHeadStatusInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('document/card/cardrefund','tCardShiftRefundSelectConditionalInformation'); ?></label>
                <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvCardShiftRefundCondition" aria-expanded="true">
                    <i class="fa fa-plus xCNPlus"></i>
                </a>
            </div>
            <div id="odvCardShiftRefundCondition" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                <div class="panel-body">
                    <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmSearchCard" name="ofmSearchCard">
                        <button style="display:none" type="submit" id="obtSubmitCardShiftRefundSearchCardForm" onclick="JSxCardShiftRefundImportFileValidate();"></button>

                        <!--INPUT : สาขา-->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                            <script>
                                var tUsrLevel = '<?=$this->session->userdata('tSesUsrLevel')?>';
                                if( tUsrLevel != "HQ" ){
                                    var tBchCount = '<?=$this->session->userdata("nSesUsrBchCount");?>';
                                    if(tBchCount < 2){
                                        $('#obtBrowseBCH_cardshiftrefund').attr('disabled',true);
                                    }
                                }
                            </script>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?= language('document/topupvending/topupvending', 'tBCH'); ?></label>
                                <div class="input-group">
                                    <input name="oetBCHName_cardshiftrefund" id="oetBCHName_cardshiftrefund" class="form-control" value="<?=$tUserBchName?>" type="text" readonly="">
                                    <input name="oetBCHCode_cardshiftrefund" id="oetBCHCode_cardshiftrefund" value="<?=$tUserBchCode?>" class="form-control xCNHide" type="text">
                                    <span class="input-group-btn">

                                        <?php
                                        if(empty($tCardShiftRefundCardStaPrcDoc) && $tCardShiftRefundCardStaDoc != "3"){
                                            $tDisabled_cardshiftrefund = '';
                                        }else{
                                            $tDisabled_cardshiftrefund = 'disabled';
                                        }
                                        ?>

                                        <button <?=$tDisabled_cardshiftrefund?> class="btn xCNBtnBrowseAddOn" id="obtBrowseBCH_cardshiftrefund" type="button">
                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-10 col-xs-10 no-padding">
                            <div class="form-group">
                                <div class="validate-input">
                                    <label class="xCNLabelFrm"><?php echo language('document/card/main','tDocumentQtyCardSuccess'); ?></label>
                                    <input type="text" class="input100 xWPointerEventNone" id="oetCardShiftRefundCountNumber" name="oetCardShiftRefundCountNumber" placeholder="<?php echo language('document/card/cardrefund','tCardShiftRefundNumber'); ?>" value="<?php echo $tCardShiftRefundCardQty; ?>" readonly="true">
                                    <span class="" style="position: absolute; right: -40px; bottom: -6px;"><?php echo language('document/card/cardrefund','tCardShiftRefundCardUnit'); ?></span>
                                </div>
                            </div>
                            <?php if(false) : ?>
                            <div class="form-group">
                                <div class="validate-input">
                                    <label class="xCNLabelFrm"><?php echo language('document/card/cardrefund','tCardShiftRefundCardRefundValue'); ?></label>
                                    <input
                                        type="text"
                                        class="input100 form-control"
                                        id="oetCardShiftRefundCardValue"
                                        name="oetCardShiftRefundCardValue"
                                        data-validate="Please Insert Value"
                                        onchange="JSnCardShiftRefundCardValueValidate(); JSxCardShiftRefundSetTotalVat();"
                                        value="<?php echo $tCardShiftRefundAmtTP; ?>">
                                    <span class="" style="position: absolute; right: -40px; bottom: -6px;"><?php echo language('document/card/cardrefund','tCardShiftRefundBaht'); ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php if(empty($tCardShiftRefundCardStaPrcDoc) && $tCardShiftRefundCardStaDoc != "3") : ?>
                            <div class="clearfix"></div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/card/cardrefund','tCardShiftRefundDataSource');?></label>
                                </div>
                                <div class="form-group">
                                    <div class="fancy-radio">
                                        <label>
                                            <input type="radio" name="orbCardShiftRefundSourceMode" value="file" onchange="JSxCardShiftRefundVisibleDataSourceMode(this, event)">
                                            <span><i></i> <?php echo language('document/card/cardrefund','tCardShiftRefundFile'); ?></span>
                                        </label>
                                        <label>
                                            <input type="radio" name="orbCardShiftRefundSourceMode" checked="" value="range" onchange="JSxCardShiftRefundVisibleDataSourceMode(this, event)">
                                            <span><i></i> <?php echo language('document/card/cardrefund','tCardShiftRefundChooseFromDataRanges'); ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="odvCardShiftRefundFileContainer" class="hidden">
                                <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                    <div class="form-group">
                                        <!--label class="xCNLabelFrm">Input Browse File/Vedio</label-->
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="oetCardShiftRefundFileTemp" name="oetCardShiftRefundFileTemp" placeholder="<?php echo language('document/card/cardrefund','tCardShiftNewCardChooseFile'); ?>" readonly>
                                            <input type="file" class="form-control" style="visibility: hidden; position: absolute;" id="oefCardShiftRefundImport" name="oefCardShiftRefundImport" onchange="JSxCardShiftRefundSetImportFile(this, event)">
                                            <span class="input-group-btn">
                                                <button id="obtFile" type="button" class="btn btn-primary" onclick="$('#oefCardShiftRefundImport').click()">
                                                    + <?php echo language('document/card/newcard','tSelectFile');?>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <a id="oahCardShiftRefundDataLoadMask" class="btn xCNBTNDefult xCNBTNDefult1Btn" style="margin-bottom: 20px;" target="_blank" href="<?php echo base_url('application/modules/document/assets/carddocfile/Temp_Card Refund.xlsx'); ?>"><?php echo language('document/card/cardrefund','tCardShiftRefundDownloadTemplate'); ?></a>
                                </div>
                            </div>
                            <div id="odvCardShiftRefundRangeContainer">
                                <div class="col-xl-6 col-lg-6 col-md-6 no-padding">
                                    <div class="form-group padding-right5">
                                        <div class="validate-input" data-validate="Please Enter">
                                            <label class="xCNLabelFrm"><?php echo language('document/card/cardrefund','tCardShiftRefundFromType'); ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetCardShiftRefundFromCardTypeCode" name="oetCardShiftRefundFromCardTypeCode">
                                                <input class="form-control xWPointerEventNone" type="text" id="oetCardShiftRefundFromCardTypeName" name="oetCardShiftRefundFromCardTypeName" placeholder="<?php echo language('document/card/cardrefund','tCardShiftRefundFrom'); ?>" readonly="">
                                                <span class="xWConditionSearchPdt input-group-btn">
                                                    <button id="oimCardShiftRefundFromCardType" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
                                                        <img class="xCNIconFind">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 no-padding">
                                    <div class="form-group padding-left5">
                                        <div class="validate-input" data-validate="Please Enter">
                                            <label class="xCNLabelFrm"><?php echo language('document/card/cardrefund','tCardShiftRefundToType'); ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetCardShiftRefundToCardTypeCode" name="oetCardShiftRefundToCardTypeCode">
                                                <input class="form-control xWPointerEventNone" type="text" id="oetCardShiftRefundToCardTypeName" name="oetCardShiftRefundToCardTypeName" placeholder="<?php echo language('document/card/cardrefund','tCardShiftRefundTo'); ?>" readonly="">
                                                <span class="xWConditionSearchPdt input-group-btn">
                                                    <button id="oimCardShiftRefundToCardType" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
                                                        <img class="xCNIconFind">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 no-padding">
                                    <div class="form-group padding-right5">
                                        <div class="validate-input" data-validate="Please Enter">
                                            <label class="xCNLabelFrm"><?php echo language('document/card/cardrefund','tCardShiftRefundFromCardNumber'); ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetCardShiftRefundFromCardNumberCode" name="oetCardShiftRefundFromCardNumberCode">
                                                <input class="form-control xWPointerEventNone" type="text" id="oetCardShiftRefundFromCardNumberName" name="oetCardShiftRefundFromCardNumberName" placeholder="<?php echo language('document/card/cardrefund','tCardShiftRefundFrom'); ?>" readonly="">
                                                <span class="xWConditionSearchPdt input-group-btn">
                                                    <button id="oimCardShiftRefundFromCardNumber" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
                                                        <img class="xCNIconFind">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 no-padding">
                                    <div class="form-group padding-left5">
                                        <div class="validate-input" data-validate="Please Enter">
                                            <label class="xCNLabelFrm"><?php echo language('document/card/cardrefund','tCardShiftRefundToCardNumber'); ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetCardShiftRefundToCardNumberCode" name="oetCardShiftRefundToCardNumberCode">
                                                <input class="form-control xWPointerEventNone" type="text" id="oetCardShiftRefundToCardNumberName" name="oetCardShiftRefundToCardNumberName" placeholder="<?php echo language('document/card/cardrefund','tCardShiftRefundTo'); ?>" readonly="">
                                                <span class="xWConditionSearchPdt input-group-btn">
                                                    <button id="oimCardShiftRefundToCardNumber" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
                                                        <img class="xCNIconFind">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <div id="odvCardShiftRefundAlert" class="pull-left">
                                    <label class="xWMsgConditonErr xWNotFound hidden"><?php echo language('document/card/cardrefund','tCardShiftRefundDataNotFound'); ?></label>
                                    <label class="xWMsgConditonErr xWCheckCondition hidden"><?php echo language('document/card/cardrefund','tCardShiftRefundPleaseCheckTheDataImportConditions'); ?></label>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <button type="button" class="btn xCNBTNPrimery xCNBTNPrimery2Btn pull-right" onclick="JSxCardShiftRefundSetDataSourceFilter()"> <?php echo language('document/card/cardrefund','tCardShiftRefundBringDataIntoTheTable'); ?></button>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-8 col-md-8">
        <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCardShiftRefundDataSource">
            <div class="panel">
                <div class="panel-body" style="padding:20px !important;">
                    <div class="row"> 

                        <!--ค้นหา-->
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="oetCardShiftRefundDataSearch"
                                        name="oetCardShiftRefundDataSearch"
                                        onkeypress="javascript:if(event.keyCode==13) JSxCardShiftRefundSearchDataSourceTable()"
                                        placeholder="<?php echo language('common/main/main','tSearch'); ?>">
                                    <span class="input-group-btn">
                                        <button id="obtSearch" type="button" class="btn xCNBtnSearch" onclick="JSxCardShiftRefundSearchDataSourceTable()">
                                            <img src="<?php echo base_url('application/modules/common/assets/images/icons/search-24.png'); ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!--ยิงสแกนเนอร์ และเพิ่มข้อมูล-->
                        <?php if(empty($tCardShiftRefundCardStaPrcDoc) && $tCardShiftRefundCardStaDoc != "3") : ?>
                            <div class="col-xl-4 col-lg-4 col-md-2 col-sm-4 col-xs-0" ></div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-4 col-xs-12" >
                                <div class="row">
                                    <div class="col-xl-10 col-lg-10 col-md-9 col-sm-10 col-xs-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="oetCardShiftRefundDataScannerID"
                                                    name="oetCardShiftRefundDataScannerID"
                                                    maxlength="50"
                                                    placeholder="<?=language('common/main/main','tFilterCardScanner'); ?>"
                                                    onkeypress="Javascript:if(event.keyCode==13) JSxCardShiftRefundScanner(event,this);" >
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn xCNBtnSearch" onclick="JSxCardShiftRefundScanner()">
                                                        <img src="<?=base_url('application/modules/common/assets/images/icons/scanner.png'); ?>">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-2 col-xs-12">
                                        <input type="hidden" id="testCode" value="">
                                        <input type="hidden" id="testName" value="">
                                        <button id="obtCardShiftRefundAddDataSource" class="xCNBTNPrimeryPlus pull-right" type="button" title="<?php echo language('document/card/cardrefund','tCardShiftRefundBringDataIntoTheTable'); ?>">+</button>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div id="odvCardShiftRefundDataSource"></div>
                    <input type="hidden" id="ohdCardShiftRefundCardCodeTemp">
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="odvCardShiftRefundModalImportFileConfirm">
	<div class="modal-dialog">
		<div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/card/cardreturn', 'tCardShiftReturnBringDataIntoTheTable')?></label>
            </div>
            <div class="modal-body">
                <?php echo language('document/card/cardreturn', 'tCardShiftReturnImportFileConfirm'); ?>
            </div>
			<div class="modal-footer">
				<!-- แก้ -->
				<button id="osmCardShiftRefundBtnImportFileConfirm" onClick="" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
					<?php echo language('common/main/main', 'tModalConfirm')?>
				</button>
				<!-- แก้ -->
				<button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel')?>
				</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="odvCardShiftRefundModalEmptyCardAlert">
	<div class="modal-dialog">
		<div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/card/cardrefund','tCardShiftRefundApproveTheDocument'); ?></label>
            </div>
            <div class="modal-body">
                <?php echo language('document/card/cardrefund', 'tCardShiftEmptyRecordAlert'); ?>
            </div>
			<div class="modal-footer">
				<button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel')?>
				</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade xCNModalApprove" id="odvCardShiftRefundPopupApv">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/card/cardrefund','tCardShiftRefundApproveTheDocument'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <p><?php echo language('document/card/newcard','tCardShiftApproveStatus'); ?></p>
                    <ul>
                        <li><?php echo language('document/card/newcard','tCardShiftApproveStatus1'); ?></li>
                        <li><?php echo language('document/card/newcard','tCardShiftApproveStatus2'); ?></li>
                        <li><?php echo language('document/card/newcard','tCardShiftApproveStatus3'); ?></li>
                        <li><?php echo language('document/card/newcard','tCardShiftApproveStatus4'); ?></li>
                    </ul>
                <p><?php echo language('document/card/newcard','tCardShiftApproveStatus5'); ?></p>
                <p><strong><?php echo language('document/card/newcard','tCardShiftApproveStatus6'); ?></strong></p>
			</div>
			<div class="modal-footer">
                <button id="obtCardShiftRefundPopupApvConfirm" onclick="JSxCardShiftRefundStaApvDoc(true)" type="button" class="btn xCNBTNPrimery">
					<?php echo language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="odvCardShiftRefundPopupStaDoc">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/card/cardrefund','tCardShiftRefundCancelTheDocument'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <p><?php echo language('document/card/newcard','tCardShiftNewCardCancelAlert'); ?></p>
                <strong><?php echo language('document/card/newcard','tCardShiftNewCardCancelAlert1'); ?></strong>
			</div>
			<div class="modal-footer">
                <button id="obtCardShiftRefundPopupStaDocConfirm" onclick="JSxCardShiftRefundStaDoc(true)" type="button" class="btn xCNBTNPrimery">
					<?php echo language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Delete Table Temp -->
<div class="modal fade" id="odvModalDelExcelRecord">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDeleteExcelRecord" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
				<input type='hidden' id="ohdConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirmExcelRecord" type="button" class="btn xCNBTNPrimery">
					<?php echo language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>
<!-- End Modal Delete Table Temp -->

<input type="hidden" id="ohdCardShiftRefundVat" value="<?php echo $nVateRate; ?>">
<script id="oscCardShiftRefundTotalTopUpTemplate" type="text/html">
<tr id="otrCardShiftRefundTotalVat" style="display: none;">
    <td nowrap class='text-right xCNTextDetail2' colspan='8' style="padding-right: 20%;">
        <div class="col-4 pull-right text-right" style="padding-left: 15%;">
            <label>{totalValue}</label>
        </div>
        <div class="col-4 pull-right text-left">
            <label><?php echo language('common/main/main', 'tCardShiftRefundNetReturnValue'); ?></label>
        </div>
    </td>
</tr>
</script>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js'); ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js'); ?>"></script>
<?php include "script/jCardShiftRefundAdd.php"; ?>
