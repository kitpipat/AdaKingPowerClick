<?php
if($aResult['rtCode'] == "1"){
    $tCardShiftStatusDocNo = $aResult['raItems']['rtCardShiftStatusDocNo'];
    $tCardShiftStatusDocDate = date('Y-m-d', strtotime($aResult['raItems']['rtCardShiftStatusDocDate']));
    $tCardShiftStatusCardQty = $aResult['raItems']['rtCardShiftStatusCardQty'];
    $tCardShiftStatusCardStaPrcDoc = $aResult['raItems']['rtCardShiftStatusStaPrcDoc'];
    $tCardShiftStatusStaDelMQ = $aResult['raItems']['rtCardShiftStatusStaDelMQ'];
    $tCardShiftStatusCardStaDoc = $aResult['raItems']['rtCardShiftStatusStaDoc'];
    $tCardShiftStaCrdActive = $aResult['raItems']['rtCardShiftStaCrdActive'];
    $tRoute = "cardShiftStatusEventEdit";
}else{
    $tCardShiftStaCrdActive = "1";
    $tCardShiftStatusDocNo = "";
    $tCardShiftStatusDocDate = date('Y-m-d');
    $tCardShiftStatusCardQty = "";
    $tCardShiftStatusCardStaPrcDoc = "";
    $tCardShiftStatusStaDelMQ = "";
    $tCardShiftStatusCardStaDoc = "";
    $tRoute = "cardShiftStatusEventAdd";
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
            <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('document/card/cardstatus','tCardShiftStatusDocumentation'); ?></label>
                <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvCardShiftStatusInfo" aria-expanded="true">
                    <i class="fa fa-plus xCNPlus"></i>
                </a>
            </div>
            <div id="odvCardShiftStatusInfo" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                <div class="panel-body">
                    <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCardShiftStatusMainForm" name="ofmAddCardShiftStatusMainForm">
                        <button style="display:none" type="submit" id="obtSubmitCardShiftStatusMainForm" onclick="JSnCardShiftStatusAddEditCardShiftStatus('<?php echo $tRoute; ?>')"></button>
                        <input type="hidden" id="ohdCardShiftStatusLangCode" name="ohdCardShiftStatusLangCode" value="<?php echo $nLangEdit; ?>">
                        <input type="hidden" id="ohdCardShiftStatusUsrBchCode" name="ohdCardShiftStatusUsrBchCode" value="<?php echo $tUserBchCode; ?>">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/card/cardstatus','tCardShiftStatusTBDocNo'); ?></label>
                        <div class="form-group" id="odvCardShiftStatusAutoGenCode">
                            <div class="">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbCardShiftStatusAutoGenCode" name="ocbCardShiftStatusAutoGenCode" checked="true" value="1">
                                    <span class="xCNLabelFrm"> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group" id="odvCardShiftStatusDocNoForm">
                            <div class="validate-input">
                                <input
                                    type="text"
                                    class="form-control input100 xCNInputWithoutSpcNotThai"
                                    id="oetCardShiftStatusCode"
                                    aria-invalid="false"
                                    name="oetCardShiftStatusCode"
                                    data-is-created="<?php echo $tCardShiftStatusDocNo; ?>"
                                    placeholder="<?php echo language('document/card/cardstatus','tCardShiftStatusTBDocNo'); ?>"
                                    value="<?php echo $tCardShiftStatusDocNo; ?>"
                                    data-validate="Plese Generate Code">
                            </div>
                        </div>

                        <!--วันที่เอกสาร supawat 28-10-2019 -->
                        <div class="form-group">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><?php echo language('document/card/cardstatus','tCardShiftStatusTBDocDate'); ?></label>
                                <div class="input-group">
                                    <input
                                        class="form-control input100 xCNDatePicker"
                                        type="text"
                                        name="oetCardShiftStatusDocDate"
                                        id="oetCardShiftStatusDocDate"
                                        aria-invalid="false"
                                        value="<?php echo $tCardShiftStatusDocDate; ?>"
                                        data-validate="Please Insert Doc Date">
                                    <span class="input-group-btn">
                                        <button id="obtShiftStatusDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <script>
                            $('#obtShiftStatusDocDate').unbind().click(function(){
                                $('#oetCardShiftStatusDocDate').focus();
                            });
                        </script>


                        <div class="form-group">
                            <input type="hidden" id="ohdCardShiftStatusCardStaPrcDoc" name="ohdCardShiftStatusCardStaPrcDoc" value="<?php echo $tCardShiftStatusCardStaPrcDoc; ?>">
                            <input type="hidden" id="ohdCardShiftStatusCardStaDoc" name="hdCardShiftStatusCardStaDoc" value="<?php echo $tCardShiftStatusCardStaDoc; ?>">
                            <input type="hidden" id="ohdCardShiftStatusStaDelQname" name="ohdCardShiftStatusStaDelQname" value="<?php echo $tCardShiftStatusStaDelMQ; ?>">
                            <?php
                            $tDocStatus = "";
                            if(empty($tCardShiftStatusCardStaPrcDoc) && !empty($tCardShiftStatusDocNo)){
                                $tDocStatus = language('document/card/cardstatus','tCardShiftStatusTBPending');
                            }

                            if($tCardShiftStatusCardStaPrcDoc == "2" || $tCardShiftStatusCardStaPrcDoc == "1"){ // Processing or approved
                                if($tCardShiftStatusCardStaPrcDoc == "2"){
                                    $tDocStatus = language('document/card/cardstatus','tCardShiftStatusTBProcessing');
                                }else{
                                    $tDocStatus = language('document/card/cardstatus','tCardShiftStatusTBApproved');
                                }
                            }else{
                                // if($tStaDoc == "1"){$tRowType = "xWDocComplete";} // Process to pending
                                if($tCardShiftStatusCardStaDoc == "2"){$tDocStatus = language('document/card/cardstatus','tCardShiftStatusTBIncomplete');}
                                if($tCardShiftStatusCardStaDoc == "3"){$tDocStatus = language('document/card/cardstatus','tCardShiftStatusTBCancel');}
                            }
                            ?>
                            <label class="xCNLabelFrm"><?php echo language('document/card/cardstatus','tCardShiftStatusTBDocStatus'); ?> <span><?php echo $tDocStatus; ?></span></label>
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="ohdCardShiftStatusUsrCode" name="ohdCardShiftStatusUsrCode" value="<?php echo $tUserCode; ?>">
                            <input type="hidden" id="ohdCardShiftStatusUserCreatedCode" name="ohdCardShiftStatusUserCreatedCode" value="<?php if(empty($tUserCreatedCode)){echo $tUserCode;}else{echo $tUserCreatedCode;} ?>">
                            <label class="xCNLabelFrm"><?php echo language('document/card/cardstatus','tCardShiftStatusCreator'); ?> <span><?php if(empty($tUserCreatedName)){echo $tUserName;}else{echo $tUserCreatedName;} ?></span></label>
                            <div class="clearfix"></div>
                            <?php if($aResult['rtCode'] == "1") : ?>
                                <input type="hidden" id="ohdCardShiftStatusApvCode" name="ohdCardShiftStatusApvCode" value="<?php if(empty($tUserApvCode)){echo $tUserCode;}else{echo $tUserApvCode;} ?>">
                                <label class="xCNLabelFrm"><?php echo language('document/card/cardstatus','tCardShiftStatusApprover'); ?>
                                    <span id="ospCardShiftStatusApvName" class="hidden"><?php if(empty($tUserApvName)){echo $tUserName;}else{echo $tUserApvName;} ?></span>
                                </label>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Panel เลือกข้อมูลตามเงื่อนไข-->
        <div class="panel panel-default" style="margin-bottom: 25px;">
            <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('document/card/cardstatus','tCardShiftStatusSelectConditionalInformation'); ?></label>
                <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvCardShiftStatusCondition" aria-expanded="true">
                    <i class="fa fa-plus xCNPlus"></i>
                </a>
            </div>
            <div id="odvCardShiftStatusCondition" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                <div class="panel-body">
                    <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmSearchCard" name="ofmSearchCard">
                        <button style="display:none" type="submit" id="obtSubmitCardShiftStatusSearchCardForm" onclick="JSxCardShiftStatusImportFileValidate();"></button>

                        <!--INPUT : สาขา-->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                            <script>
                                var tUsrLevel = '<?=$this->session->userdata('tSesUsrLevel')?>';
                                if( tUsrLevel != "HQ" ){
                                    var tBchCount = '<?=$this->session->userdata("nSesUsrBchCount");?>';
                                    if(tBchCount < 2){
                                        $('#obtBrowseBCH_CardShiftStatus').attr('disabled',true);
                                    }
                                }
                            </script>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?= language('document/topupvending/topupvending', 'tBCH'); ?></label>
                                <div class="input-group">
                                    <input name="oetBCHName_CardShiftStatus" id="oetBCHName_CardShiftStatus" class="form-control" value="<?=$tUserBchName?>" type="text" readonly="">
                                    <input name="oetBCHCode_CardShiftStatus" id="oetBCHCode_CardShiftStatus" value="<?=$tUserBchCode?>" class="form-control xCNHide" type="text">
                                    <span class="input-group-btn">

                                        <?php
                                        if(empty($tCardShiftStatusCardStaPrcDoc) && $tCardShiftStatusCardStaDoc != "3"){
                                            $tDisabled_CardShiftStatus = '';
                                        }else{
                                            $tDisabled_CardShiftStatus = 'disabled';
                                        }
                                        ?>

                                        <button <?=$tDisabled_CardShiftStatus?> class="btn xCNBtnBrowseAddOn" id="obtBrowseBCH_CardShiftStatus" type="button">
                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-10 col-xs-10 no-padding">
                            <div class="form-group">
                                <div class="validate-input" data-validate="Please Insert Name">
                                    <label class="xCNLabelFrm"><?php echo language('document/card/cardstatus','tCardShiftStatusRequestedStatusCard'); ?></label>
                                    <input type="text" class="input100 xWPointerEventNone" id="oetCardShiftStatusCountNumber" name="oetCardShiftStatusCountNumber" placeholder="<?php echo language('document/card/cardstatus',''); ?>จำนวน" value="<?php echo $tCardShiftStatusCardQty; ?>" readonly="true">
                                    <span class="" style="    position: absolute; right: -40px; bottom: -6px;"><?php echo language('document/card/cardstatus','tCardShiftStatusCardUnit'); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php if(!empty($tCardShiftStatusCardStaPrcDoc) || $tCardShiftStatusCardStaDoc == "3") : ?>
                        <?php
                        $tStatus = "";
                        if($tCardShiftStaCrdActive == 1){
                            $tStatus = language('document/card/cardstatus','tCardShiftStatusActive');
                        }
                        if($tCardShiftStaCrdActive == 2){
                            $tStatus = language('document/card/cardstatus','tCardShiftStatusInactive');
                        }
                        if($tCardShiftStaCrdActive == 3){
                            $tStatus = language('document/card/cardstatus','tCardShiftStatusCancel');
                        }
                        ?>
                        <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/card/cardstatus','tCardShiftStatusTBCardStatus'); ?></label>
                                <input class="xWPointerEventNone" type="text" value="<?php echo $tStatus; ?>" readonly="true">
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if(empty($tCardShiftStatusCardStaPrcDoc) && $tCardShiftStatusCardStaDoc != "3") : ?>
                            <div class="clearfix"></div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/card/cardstatus','tCardShiftStatusTBCardStatus'); ?></label>
                                    <select class="selectpicker form-control xCNSelectBox" id="ocmCrdStaActive" name="ocmCrdStaActive">
                                        <option value='1' <?php echo ($tCardShiftStaCrdActive == 1)? 'selected':''?>><?php echo language('document/card/cardstatus','tCardShiftStatusActive'); ?></option>
                                        <option value='2' <?php echo ($tCardShiftStaCrdActive == 2)? 'selected':''?>><?php echo language('document/card/cardstatus','tCardShiftStatusInactive'); ?></option>
                                        <option value='3' <?php echo ($tCardShiftStaCrdActive == 3)? 'selected':''?>><?php echo language('document/card/cardstatus','tCardShiftStatusCancel'); ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/card/cardstatus','tCardShiftStatusDataSource'); ?></label>
                                </div>
                                <div class="form-group">
                                    <div class="fancy-radio">
                                        <label>
                                            <input type="radio" name="orbCardShiftStatusSourceMode" value="file" onchange="JSxCardShiftStatusVisibleDataSourceMode(this, event)">
                                            <span><i></i> <?php echo language('document/card/cardstatus','tCardShiftStatusFile'); ?></span>
                                        </label>
                                        <label>
                                            <input type="radio" name="orbCardShiftStatusSourceMode" checked="" value="range" onchange="JSxCardShiftStatusVisibleDataSourceMode(this, event)">
                                            <span><i></i> <?php echo language('document/card/cardstatus','tCardShiftStatusChooseFromDataRanges'); ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="odvCardShiftStatusFileContainer" class="hidden">
                                <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                    <div class="form-group">
                                        <!--label class="xCNLabelFrm">Input Browse File/Vedio</label-->
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="oetCardShiftStatusFileTemp" name="oetCardShiftStatusFileTemp" placeholder="<?php echo language('document/card/cardstatus','tCardShiftNewCardChooseFile'); ?>" readonly>
                                            <input type="file" class="form-control" style="visibility: hidden; position: absolute;" id="oefCardShiftStatusImport" name="oefCardShiftStatusImport" onchange="JSxCardShiftStatusSetImportFile(this, event)">
                                            <span class="input-group-btn">
                                                <button id="obtFile" type="button" class="btn btn-primary" onclick="$('#oefCardShiftStatusImport').click()">
                                                    + <?php echo language('document/card/newcard','tSelectFile');?>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <a id="oahCardShiftStatusDataLoadMask" class="btn xCNBTNDefult xCNBTNDefult1Btn" style="margin-bottom: 20px;" target="_blank" href="<?php echo base_url('application/modules/document/assets/carddocfile/Temp_Card Change Status.xlsx'); ?>"><?php echo language('document/card/cardstatus','tCardShiftStatusDownloadTemplate'); ?></a>
                                </div>
                            </div>
                            <div id="odvCardShiftStatusRangeContainer">
                                <div class="col-xl-6 col-lg-6 col-md-6 no-padding">
                                    <div class="form-group padding-right5">
                                        <div class="validate-input" data-validate="Please Enter">
                                            <label class="xCNLabelFrm"><?php echo language('document/card/cardstatus','tCardShiftStatusFromType'); ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetCardShiftStatusFromCardTypeCode" name="oetCardShiftStatusFromCardTypeCode">
                                                <input class="form-control xWPointerEventNone" type="text" id="oetCardShiftStatusFromCardTypeName" name="oetCardShiftStatusFromCardTypeName" placeholder="<?php echo language('document/card/cardstatus','tCardShiftStatusFrom'); ?>" readonly="">
                                                <span class="xWConditionSearchPdt input-group-btn">
                                                    <button id="oimCardShiftStatusFromCardType" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
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
                                            <label class="xCNLabelFrm"><?php echo language('document/card/cardstatus','tCardShiftStatusToType'); ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetCardShiftStatusToCardTypeCode" name="oetCardShiftStatusToCardTypeCode">
                                                <input class="form-control xWPointerEventNone" type="text" id="oetCardShiftStatusToCardTypeName" name="oetCardShiftStatusToCardTypeName" placeholder="<?php echo language('document/card/cardstatus','tCardShiftStatusTo'); ?>" readonly="">
                                                <span class="xWConditionSearchPdt input-group-btn">
                                                    <button id="oimCardShiftStatusToCardType" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
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
                                            <label class="xCNLabelFrm"><?php echo language('document/card/cardstatus','tCardShiftStatusFromCardNumber'); ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetCardShiftStatusFromCardNumberCode" name="oetCardShiftStatusFromCardNumberCode">
                                                <input class="form-control xWPointerEventNone" type="text" id="oetCardShiftStatusFromCardNumberName" name="oetCardShiftStatusFromCardNumberName" placeholder="<?php echo language('document/card/cardstatus','tCardShiftStatusFrom'); ?>" readonly="">
                                                <span class="xWConditionSearchPdt input-group-btn">
                                                    <button id="oimCardShiftStatusFromCardNumber" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
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
                                            <label class="xCNLabelFrm"><?php echo language('document/card/cardstatus','tCardShiftStatusToCardNumber'); ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetCardShiftStatusToCardNumberCode" name="oetCardShiftStatusToCardNumberCode">
                                                <input class="form-control xWPointerEventNone" type="text" id="oetCardShiftStatusToCardNumberName" name="oetCardShiftStatusToCardNumberName" placeholder="<?php echo language('document/card/cardstatus','tCardShiftStatusTo'); ?>" readonly="">
                                                <span class="xWConditionSearchPdt input-group-btn">
                                                    <button id="oimCardShiftStatusToCardNumber" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
                                                        <img class="xCNIconFind">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <div id="odvCardShiftStatusAlert" class="pull-left">
                                    <label class="xWMsgConditonErr xWNotFound hidden"><?php echo language('document/card/cardstatus','tCardShiftStatusDataNotFound'); ?></label>
                                    <label class="xWMsgConditonErr xWCheckCondition hidden"><?php echo language('document/card/cardstatus','tCardShiftStatusPleaseCheckTheDataImportConditions'); ?></label>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <button type="button" class="btn xCNBTNPrimery xCNBTNPrimery2Btn pull-right" onclick="JSxCardShiftStatusSetDataSourceFilter()"> <?php echo language('document/card/cardstatus','tCardShiftStatusBringDataIntoTheTable'); ?></button>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <div class="col-xl-8 col-lg-8 col-md-8">
        <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCardShiftStatusDataSource">
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
                                        id="oetCardShiftStatusDataSearch"
                                        name="oetCardShiftStatusDataSearch"
                                        onkeypress="javascript:if(event.keyCode==13) JSxCardShiftStatusSearchDataSourceTable()"
                                        placeholder="<?php echo language('common/main/main','tSearch'); ?>">
                                    <span class="input-group-btn">
                                        <button id="obtSearch" type="button" class="btn xCNBtnSearch" onclick="JSxCardShiftStatusSearchDataSourceTable()">
                                            <img src="<?php echo base_url('application/modules/common/assets/images/icons/search-24.png'); ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!--ยิงสแกนเนอร์ และเพิ่มข้อมูล-->
                        <?php if(empty($tCardShiftStatusCardStaPrcDoc) && $tCardShiftStatusCardStaDoc != "3") : ?>
                            <div class="col-xl-4 col-lg-4 col-md-2 col-sm-4 col-xs-0" ></div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-4 col-xs-12" >
                                <div class="row">
                                    <div class="col-xl-10 col-lg-10 col-md-9 col-sm-10 col-xs-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="oetCardShiftStatusDataScannerID"
                                                    name="oetCardShiftStatusDataScannerID"
                                                    maxlength="50"
                                                    placeholder="<?=language('common/main/main','tFilterCardScanner'); ?>"
                                                    onkeypress="Javascript:if(event.keyCode==13) JSxCardShiftStatusScanner(event,this);" >
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn xCNBtnSearch" onclick="JSxCardShiftStatusScanner()">
                                                        <img src="<?=base_url('application/modules/common/assets/images/icons/scanner.png'); ?>">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-2 col-xs-12">
                                        <input type="hidden" id="testCode" value="">
                                        <input type="hidden" id="testName" value="">
                                        <button id="obtCardShiftStatusAddDataSource" class="xCNBTNPrimeryPlus pull-right" type="button" title="<?php echo language('document/card/cardstatus','tCardShiftStatusBringDataIntoTheTable'); ?>">+</button>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div id="odvCardShiftStatusDataSource"></div>
                    <input type="hidden" id="ohdCardShiftStatusCardCodeTemp">
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="odvCardShiftStatusModalEmptyCardAlert">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/card/cardrefund','tCardShiftStatusApproveTheDocument'); ?></label>
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

<div class="modal fade" id="odvCardShiftStatusModalImportFileConfirm">
	<div class="modal-dialog">
		<div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/card/cardstatus', 'tCardShiftStatusBringDataIntoTheTable')?></label>
            </div>
            <div class="modal-body">
                <?php echo language('document/card/cardstatus', 'tCardShiftStatusImportFileConfirm'); ?>
            </div>
			<div class="modal-footer">
				<!-- แก้ -->
				<button id="osmCardShiftStatusBtnImportFileConfirm" onClick="" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
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

<div class="modal fade" id="odvCardShiftStatusPopupApv">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/card/cardstatus', 'tCardShiftStatusApproveTheDocument'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo language('document/card/newcard', 'tCardShiftApproveStatus'); ?></p>
                <ul>
                    <li><?php echo language('document/card/newcard', 'tCardShiftApproveStatus1'); ?></li>
                    <li><?php echo language('document/card/newcard', 'tCardShiftApproveStatus2'); ?></li>
                    <li><?php echo language('document/card/newcard', 'tCardShiftApproveStatus3'); ?></li>
                    <li><?php echo language('document/card/newcard', 'tCardShiftApproveStatus4'); ?></li>
                </ul>
                <p><?php echo language('document/card/newcard', 'tCardShiftApproveStatus5'); ?></p>
                <p><strong><?php echo language('document/card/newcard', 'tCardShiftApproveStatus6'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button id="obtCardShiftStatusPopupApvConfirm" onclick="JSxCardShiftStatusStaApvDoc(true)" type="button" class="btn xCNBTNPrimery">
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
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
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

<div class="modal fade" id="odvCardShiftStatusPopupStaDoc">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/card/cardstatus', 'tCardShiftStatusCancelTheDocument'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo language('document/card/newcard', 'tCardShiftNewCardCancelAlert'); ?></p>
                <strong><?php echo language('document/card/newcard', 'tCardShiftNewCardCancelAlert1'); ?></strong>
            </div>
            <div class="modal-footer">
                <button id="obtCardShiftStatusPopupStaDocConfirm" onclick="JSxCardShiftStatusStaDoc(true)" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jCardShiftStatusAdd.php"; ?>
