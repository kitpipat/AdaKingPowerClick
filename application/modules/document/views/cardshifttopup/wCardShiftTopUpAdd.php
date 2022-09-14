<?php
if($aResult['rtCode'] == "1"){
    $tCardShiftTopUpDocNo = $aResult['raItems']['rtCardShiftTopUpDocNo'];
    $tCardShiftTopUpDocDate = date('Y-m-d', strtotime($aResult['raItems']['rtCardShiftTopUpDocDate']));
    $tCardShiftTopUpCardQty = $aResult['raItems']['rtCardShiftTopUpCardQty'];
    $tCardShiftTopUpCardStaPrcDoc = $aResult['raItems']['rtCardShiftTopUpStaPrcDoc'];
    $tCardShiftTopUpStaDelMQ = $aResult['raItems']['rtCardShiftTopUpStaDelMQ'];
    $tCardShiftTopUpCardStaDoc = $aResult['raItems']['rtCardShiftTopUpStaDoc'];
    $tCardShiftTopUpTotalTP = $aResult['raItems']['rtCardShiftTopUpTotalTP'];
    $tCardShiftXshStaApv = $aResult['raItems']['FTXshStaApv'];
    $tRoute = "cardShiftTopUpEventEdit";
}else{
    $tCardShiftTopUpDocNo = "";
    $tCardShiftTopUpDocDate = date('Y-m-d');
    $tCardShiftTopUpCardQty = "";
    $tCardShiftTopUpCardStaPrcDoc = "";
    $tCardShiftTopUpStaDelMQ = "";
    $tCardShiftTopUpCardStaDoc = "";
    $tRoute = "cardShiftTopUpEventAdd";
    $tCardShiftTopUpTotalTP = "";
    $tCardShiftXshStaApv = "";
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
    $nVat = ($tCardShiftTopUpTotalTP * $nVateRate) / 100; // Cale vate
    $nNetVat = $tCardShiftTopUpTotalTP + $nVat;
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
            <div  class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('document/card/cardrefund','tCardShiftRefundDocumentation'); ?></label>
                <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvCardShiftTopUpInfo" aria-expanded="true">
                    <i class="fa fa-plus xCNPlus"></i>
                </a>
            </div>
            <div id="odvCardShiftTopUpInfo" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                <div class="panel-body">
                    <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCardShiftTopUpMainForm" name="ofmAddCardShiftTopUpMainForm">
                        <button style="display:none" type="submit" id="obtSubmitCardShiftTopUpMainForm" onclick="JSnCardShiftTopUpAddEditCardShiftTopUp('<?php echo $tRoute; ?>')"></button>
                        <input type="hidden" id="ohdCardShiftTopUpLangCode" name="ohdCardShiftTopUpLangCode" value="<?php echo $nLangEdit; ?>">
                        <input type="hidden" id="ohdCardShiftTopUpUsrBchCode" name="ohdCardShiftTopUpUsrBchCode" value="<?php echo $tUserBchCode; ?>">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/card/cardtopup','tCardShiftTopUpTBDocNo'); ?></label>
                        <div class="form-group" id="odvCardShiftTopUpAutoGenCode">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbCardShiftTopUpAutoGenCode" name="ocbCardShiftTopUpAutoGenCode" checked="true" value="1">
                                    <span class="xCNLabelFrm"> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group" id="odvCardShiftTopUpDocNoForm">
                            <div class="validate-input">
                                <input
                                    type="text"
                                    class="form-control input100 xCNInputWithoutSpcNotThai"
                                    id="oetCardShiftTopUpCode"
                                    aria-invalid="false"
                                    name="oetCardShiftTopUpCode"
                                    data-is-created="<?php echo $tCardShiftTopUpDocNo; ?>"
                                    placeholder="<?php echo language('document/card/cardtopup','tCardShiftTopUpTBDocNo'); ?>"
                                    value="<?php echo $tCardShiftTopUpDocNo; ?>"
                                    data-validate="Plese Generate Code">
                            </div>
                        </div>

                        <!--วันที่เอกสาร supawat 28-10-2019 -->
                        <div class="form-group">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><?php echo language('document/card/cardtopup','tCardShiftTopUpTBDocDate'); ?></label>
                                <div class="input-group">
                                    <input
                                        class="form-control input100 xCNDatePicker"
                                        type="text"
                                        name="oetCardShiftTopUpDocDate"
                                        id="oetCardShiftTopUpDocDate"
                                        aria-invalid="false"
                                        value="<?php echo $tCardShiftTopUpDocDate; ?>"
                                        data-validate="Please Insert Doc Date">
                                    <span class="input-group-btn">
                                        <button id="obtRefundTopUpDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <script>
                            $('#obtRefundTopUpDocDate').unbind().click(function(){
                                $('#oetCardShiftTopUpDocDate').focus();
                            });
                        </script>


                        <div class="form-group">
                            <input type="hidden" id="ohdCardShiftXshStaApv" name="ohdCardShiftXshStaApv" value="<?php echo $tCardShiftXshStaApv; ?>">
                            <input type="hidden" id="ohdCardShiftTopUpCardStaPrcDoc" name="ohdCardShiftTopUpCardStaPrcDoc" value="<?php echo $tCardShiftTopUpCardStaPrcDoc; ?>">
                            <input type="hidden" id="ohdCardShiftTopUpCardStaDoc" name="hdCardShiftTopUpCardStaDoc" value="<?php echo $tCardShiftTopUpCardStaDoc; ?>">
                            <input type="hidden" id="ohdCardShiftTopUpStaDelQname" name="ohdCardShiftTopUpStaDelQname" value="<?php echo $tCardShiftTopUpStaDelMQ; ?>">

                            <?php
                            $tDocStatus = "";
                            if(empty($tCardShiftTopUpCardStaPrcDoc) && !empty($tCardShiftTopUpDocNo)){
                                $tDocStatus = language('document/card/cardtopup','tCardShiftTopUpTBPending');
                            }

                            if($tCardShiftTopUpCardStaPrcDoc == "2" || $tCardShiftTopUpCardStaPrcDoc == "1"){ // Processing or approved
                                if($tCardShiftTopUpCardStaPrcDoc == "2"){
                                    $tDocStatus = language('document/card/cardtopup','tCardShiftTopUpTBProcessing');
                                }else{
                                    $tDocStatus = language('document/card/cardtopup','tCardShiftTopUpTBApproved');
                                }
                            }else{
                                // if($tStaDoc == "1"){$tRowType = "xWDocComplete";} // Process to pending
                                if($tCardShiftTopUpCardStaDoc == "2"){$tDocStatus = language('document/card/cardtopup','tCardShiftTopUpTBIncomplete');}
                                if($tCardShiftTopUpCardStaDoc == "3"){$tDocStatus = language('document/card/cardtopup','tCardShiftTopUpTBCancel');}
                            }
                            ?>
                            <label class="xCNLabelFrm"><?php echo language('document/card/cardtopup','tCardShiftTopUpTBDocStatus'); ?> <span><?php echo $tDocStatus; ?></span></label>
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="ohdCardShiftTopUpUsrCode" name="ohdCardShiftTopUpUsrCode" value="<?php echo $tUserCode; ?>">
                            <input type="hidden" id="ohdCardShiftTopUpUserCreatedCode" name="ohdCardShiftTopUpUserCreatedCode" value="<?php if(empty($tUserCreatedCode)){echo $tUserCode;}else{echo $tUserCreatedCode;} ?>">
                            <input type="hidden" id="ohdCardShiftTopUpUserCreatedName" name="ohdCardShiftTopUpUserCreatedName" value="<?php if(empty($tUserCreatedName)){echo $tUserName;}else{echo $tUserCreatedName;} ?>">
                            <label class="xCNLabelFrm"><?php echo language('document/card/cardtopup','tCardShiftTopUpCreator'); ?> <span><?php if(empty($tUserCreatedName)){echo $tUserName;}else{echo $tUserCreatedName;} ?></span></label>
                            <div class="clearfix"></div>
                            <?php if($aResult['rtCode'] == "1") : ?>
                                <input type="hidden" id="ohdCardShiftTopUpApvCode" name="ohdCardShiftTopUpApvCode" value="<?php if(empty($tUserApvCode)){echo $tUserCode;}else{echo $tUserApvCode;} ?>">
                                <label class="xCNLabelFrm"><?php echo language('document/card/cardtopup','tCardShiftTopUpApprover'); ?>
                                    <span id="ospCardShiftTopUpApvName" class="hidden"><?php if(empty($tUserApvName)){echo $tUserName;}else{echo $tUserApvName;} ?></span>
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
                <label class="xCNTextDetail1"><?php echo language('document/card/cardtopup','tCardShiftTopUpSelectConditionalInformation'); ?></label>
                <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvCardTopUpCondition" aria-expanded="true">
                    <i class="fa fa-plus xCNPlus"></i>
                </a>
            </div>
            <div id="odvCardTopUpCondition" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                <div class="panel-body">

                    <!--INPUT : สาขา-->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                        <script>
                            var tUsrLevel = '<?=$this->session->userdata('tSesUsrLevel')?>';
                            if( tUsrLevel != "HQ" ){
                                var tBchCount = '<?=$this->session->userdata("nSesUsrBchCount");?>';
                                if(tBchCount < 2){
                                    $('#obtBrowseBCH_cardShiftTopUp').attr('disabled',true);
                                }
                            }
                        </script>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/topupvending/topupvending', 'tBCH'); ?></label>
                            <div class="input-group">
                                <input name="oetBCHName_cardShiftTopUp" id="oetBCHName_cardShiftTopUp" class="form-control" value="<?=$tUserBchName?>" type="text" readonly="">
                                <input name="oetBCHCode_cardShiftTopUp" id="oetBCHCode_cardShiftTopUp" value="<?=$tUserBchCode?>" class="form-control xCNHide" type="text">
                                <span class="input-group-btn">

                                    <?php
                                    if(empty($tCardShiftTopUpCardStaPrcDoc) && $tCardShiftTopUpCardStaDoc != "3"){
                                        $tDisabled_cardShiftTopUp = '';
                                    }else{
                                        $tDisabled_cardShiftTopUp = 'disabled';
                                    }
                                    ?>

                                    <button <?=$tDisabled_cardShiftTopUp?> class="btn xCNBtnBrowseAddOn" id="obtBrowseBCH_cardShiftTopUp" type="button">
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
                                <input type="text" class="input100 xWPointerEventNone" id="oetCardShiftTopUpCountNumber" name="oetCardShiftTopUpCountNumber" placeholder="<?php echo language('document/card/cardtopup','tCardShiftTopUpNumber'); ?>" value="<?php echo $tCardShiftTopUpCardQty; ?>" readonly="true">
                                <span class="" style="position: absolute; right: -40px; bottom: -6px;"><?php echo language('document/card/cardtopup','tCardShiftTopUpCardUnit'); ?></span>
                            </div>
                        </div>



                        <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmCardValue" name="ofmCardValue">
                            <!--button style="display:none" type="submit" id="obtSubmitCardValueForm" onclick="JSnCardShiftTopUpCardValueValidate()"></button-->
                            <div class="form-group">
                                <div class="validate-input">
                                    <label class="xCNLabelFrm"><?php echo language('document/card/cardtopup','tCardShiftTopUpCardTopUpValue'); ?></label>
                                    <input
                                        type="text"
                                        class="input100 form-control xCNInputNumeric"
                                        maxlength="15"
                                        id="oetCardShiftTopUpCardValue"
                                        name="oetCardShiftTopUpCardValue"
                                        data-validate="Please Insert Value"
                                        onchange="JSxCardShiftTopUpSetTotalVat();"
                                        value="">
                                    <span class="" style="position: absolute; right: -40px; bottom: -6px;"><?php echo language('document/card/cardtopup','tCardShiftTopUpBaht'); ?></span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php if(empty($tCardShiftTopUpCardStaPrcDoc) && $tCardShiftTopUpCardStaDoc != "3") : ?>
                        <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmSearchCard" name="ofmSearchCard">
                            <button style="display:none" type="submit" id="obtSubmitCardShiftTopUpSearchCardForm" onclick="JSxCardShiftTopUpImportFileValidate();"></button>
                            <div class="clearfix"></div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/card/cardtopup','tCardShiftTopUpDataSource'); ?></label>
                                </div>
                                <div class="form-group">
                                    <div class="fancy-radio">
                                        <label>
                                            <input type="radio" name="orbCardShiftTopUpSourceMode" value="file" onchange="JSxCardShiftTopUpVisibleDataSourceMode(this, event)">
                                            <span><i></i> <?php echo language('document/card/cardtopup','tCardShiftTopUpFile'); ?></span>
                                        </label>
                                        <label>
                                            <input type="radio" name="orbCardShiftTopUpSourceMode" checked="" value="range" onchange="JSxCardShiftTopUpVisibleDataSourceMode(this, event)">
                                            <span><i></i> <?php echo language('document/card/cardtopup','tCardShiftTopUpChooseFromDataRanges'); ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="odvCardShiftTopUpFileContainer" class="hidden">
                                <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                    <div class="form-group">
                                        <!--label class="xCNLabelFrm">Input Browse File/Vedio</label-->
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="oetCardShiftTopUpFileTemp" name="oetCardShiftTopUpFileTemp" placeholder="<?php echo language('document/card/cardtopup','tCardShiftNewCardChooseFile'); ?>" readonly>
                                            <input type="file" class="form-control" style="visibility: hidden; position: absolute;" id="oefCardShiftTopUpImport" name="oefCardShiftTopUpImport" onchange="JSxCardShiftTopUpSetImportFile(this, event)">
                                            <span class="input-group-btn">
                                                <button id="obtFile" type="button" class="btn btn-primary" onclick="$('#oefCardShiftTopUpImport').click()">
                                                    + <?php echo language('document/card/newcard','tSelectFile');?>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <a id="oahCardShiftTopUpDataLoadMask" class="btn xCNBTNDefult xCNBTNDefult1Btn" style="margin-bottom: 20px;" target="_blank" href="<?php echo base_url('application/modules/document/assets/carddocfile/Temp_TopUP.xlsx'); ?>"><?php echo language('document/card/cardtopup','tCardShiftTopUpDownloadTemplate'); ?></a>
                                </div>
                            </div>
                            <div id="odvCardShiftTopUpRangeContainer">
                                <div class="col-xl-6 col-lg-6 col-md-6 no-padding">
                                    <div class="form-group padding-right5">
                                        <div class="validate-input" data-validate="Please Enter">
                                            <label class="xCNLabelFrm"><?php echo language('document/card/cardtopup','tCardShiftTopUpFromType'); ?></label>
                                            <div class="input-group">
                                                <input type="hidden" class="form-control xCNHide" id="oetCardShiftTopUpFromCardTypeCode" name="oetCardShiftTopUpFromCardTypeCode">
                                                <input class="form-control xWPointerEventNone" type="text" id="oetCardShiftTopUpFromCardTypeName" name="oetCardShiftTopUpFromCardTypeName" placeholder="<?php echo language('document/card/cardtopup','tCardShiftTopUpFrom'); ?>" readonly="">
                                                <span class="xWConditionSearchPdt input-group-btn">
                                                    <button id="oimCardShiftTopUpFromCardType" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
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
                                            <label class="xCNLabelFrm"><?php echo language('document/card/cardtopup','tCardShiftTopUpToType'); ?></label>
                                            <div class="input-group">
                                                <input type="hidden" class="form-control xCNHide" id="oetCardShiftTopUpToCardTypeCode" name="oetCardShiftTopUpToCardTypeCode">
                                                <input class="form-control xWPointerEventNone" type="text" id="oetCardShiftTopUpToCardTypeName" name="oetCardShiftTopUpToCardTypeName" placeholder="<?php echo language('document/card/cardtopup','tCardShiftTopUpTo'); ?>" readonly="">
                                                <span class="xWConditionSearchPdt input-group-btn">
                                                    <button id="oimCardShiftTopUpToCardType" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
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
                                            <label class="xCNLabelFrm"><?php echo language('document/card/cardtopup','tCardShiftTopUpFromCardNumber'); ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetCardShiftTopUpFromCardNumberCode" name="oetCardShiftTopUpFromCardNumberCode">
                                                <input class="form-control xWPointerEventNone" type="text" id="oetCardShiftTopUpFromCardNumberName" name="oetCardShiftTopUpFromCardNumberName" placeholder="<?php echo language('document/card/cardtopup','tCardShiftTopUpFrom'); ?>" readonly="">
                                                <span class="xWConditionSearchPdt input-group-btn">
                                                    <button id="oimCardShiftTopUpFromCardNumber" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
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
                                            <label class="xCNLabelFrm"><?php echo language('document/card/cardtopup','tCardShiftTopUpToCardNumber'); ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetCardShiftTopUpToCardNumberCode" name="oetCardShiftTopUpToCardNumberCode">
                                                <input class="form-control xWPointerEventNone" type="text" id="oetCardShiftTopUpToCardNumberName" name="oetCardShiftTopUpToCardNumberName" placeholder="<?php echo language('document/card/cardtopup','tCardShiftTopUpTo'); ?>" readonly="">
                                                <span class="xWConditionSearchPdt input-group-btn">
                                                    <button id="oimCardShiftTopUpToCardNumber" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
                                                        <img class="xCNIconFind">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <div id="odvCardShiftTopUpAlert" class="pull-left">
                                    <label class="xWMsgConditonErr xWNotFound hidden"><?php echo language('document/card/cardtopup','tCardShiftTopUpDataNotFound'); ?></label>
                                    <label class="xWMsgConditonErr xWCheckCondition hidden"><?php echo language('document/card/cardtopup','tCardShiftTopUpPleaseCheckTheDataImportConditions'); ?></label>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <button type="button" class="btn xCNBTNPrimery xCNBTNPrimery2Btn pull-right" onclick="JSxCardShiftTopUpSetDataSourceFilter()"> <?php echo language('document/card/cardtopup','tCardShiftTopUpBringDataIntoTheTable'); ?></button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
    <div class="col-xl-8 col-lg-8 col-md-8">
        <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCardShiftTopUpDataSource">
            <div class="panel">
                <div class="panel-body" style="padding:20px !important;">
                  <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <div class="input-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="oetCardShiftTopUpDataSearch"
                                    name="oetCardShiftTopUpDataSearch"
                                    onkeypress="javascript:if(event.keyCode==13) JSxCardShiftTopUpSearchDataSourceTable()"
                                    onkeyup="//JSxCardShiftTopUpSearchDataSourceTable()"
                                    placeholder="<?php echo language('common/main/main','tSearch'); ?>">
                                <span class="input-group-btn">
                                    <button id="obtSearch" type="button" class="btn xCNBtnSearch" onclick="JSxCardShiftTopUpSearchDataSourceTable()">
                                        <img src="<?php echo base_url('application/modules/common/assets/images/icons/search-24.png'); ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!--ยิงสแกนเนอร์-->
                    <?php if(empty($tCardShiftTopUpCardStaPrcDoc) && $tCardShiftTopUpCardStaDoc != "3") : ?>
                        
                    <?php endif; ?>

                    <?php if(empty($tCardShiftTopUpCardStaPrcDoc) && $tCardShiftTopUpCardStaDoc != "3") : ?>
                        <div class="col-xl-4 col-lg-4 col-md-2 col-sm-4 col-xs-0" ></div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-4 col-xs-12" >
                            <div class="row">
                                <div class="col-xl-10 col-lg-10 col-md-9 col-sm-10 col-xs-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="oetCardShiftTopUpDataScannerID"
                                                name="oetCardShiftTopUpDataScannerID"
                                                maxlength="50"
                                                placeholder="<?=language('common/main/main','tFilterCardScanner'); ?>"
                                                onkeypress="Javascript:if(event.keyCode==13) JSxCardShiftTopUpScanner(event,this);" >
                                            <span class="input-group-btn">
                                                <button type="button" class="btn xCNBtnSearch" onclick="JSxCardShiftTopUpScanner()">
                                                    <img src="<?=base_url('application/modules/common/assets/images/icons/scanner.png'); ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-2 col-xs-12">
                                    <input type="hidden" id="testCode" value="">
                                    <input type="hidden" id="testName" value="">
                                    <button id="obtCardShiftTopUpAddDataSource" class="xCNBTNPrimeryPlus pull-right" type="button" title="<?php echo language('document/card/cardtopup','tCardShiftTopUpApprover'); ?>">+</button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    </div>
                    <div id="odvCardShiftTopUpDataSource"></div>
                    <input type="hidden" id="ohdCardShiftTopUpCardCodeTemp">
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="odvCardShiftTopUpPopupApv">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/card/cardtopup','tCardShiftTopUpApproveTheDocument'); ?></h5>
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
                <button id="obtCardShiftTopUpPopupApvConfirm" onclick="JSxCardShiftTopUpStaApvDoc(true)" type="button" class="btn xCNBTNPrimery">
					<?php echo language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="odvCardShiftTopUpModalImportFileConfirm">
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
				<button id="osmCardShiftTopUpBtnImportFileConfirm" onClick="" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
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

<div class="modal fade" id="odvCardShiftTopUpModalEmptyCardAlert">
	<div class="modal-dialog">
		<div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/card/cardtopup','tCardShiftTopUpApproveTheDocument'); ?></label>
            </div>
            <div class="modal-body">
                <?php echo language('document/card/cardtopup', 'tCardShiftEmptyRecordAlert'); ?>
            </div>
			<div class="modal-footer">
				<button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel')?>
				</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="odvCardShiftTopUpPopupStaDoc">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/card/cardtopup','tCardShiftTopUpCancelTheDocument'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <p><?php echo language('document/card/newcard','tCardShiftNewCardCancelAlert'); ?></p>
                <strong><?php echo language('document/card/newcard','tCardShiftNewCardCancelAlert1'); ?></strong>
			</div>
			<div class="modal-footer">
                <button id="obtCardShiftTopUpPopupStaDocConfirm" onclick="JSxCardShiftTopUpStaDoc(true)" type="button" class="btn xCNBTNPrimery">
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

<input type="hidden" id="ohdCardShiftTopUpVat" value="<?php echo $nVateRate; ?>">
<script id="oscCardShiftTopUpTotalTopUpTemplate" type="text/html">
<tr id="otrCardShiftTopUpTotalVat" style="display: none;">
    <td nowrap class='text-right xCNTextDetail2' colspan='8' style="padding-right: 20%;">
        <div class="col-4 pull-right text-right" style="padding-left: 15%;">
            <label>{totalValue}</label>
            <br>
            <label>{vat}%</label>
            <br>
            <label>{totalVat}</label>
        </div>
        <div class="col-4 pull-right text-left">
            <label><?php echo language('common/main/main', 'tCardShiftTopUpValueAdded'); ?></label>
            <br>
            <label><?php echo language('common/main/main', 'tCardShiftTopUpTaxRate'); ?></label>
            <br>
            <label><?php echo language('common/main/main', 'tCardShiftTopUpNetWorth'); ?></label>
        </div>
    </td>
</tr>
</script>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jCardShiftTopUpAdd.php"; ?>
