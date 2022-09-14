<?php
if($aResult['rtCode'] == "1"){
    $tCardShiftReturnDocNo = $aResult['raItems']['rtCardShiftReturnDocNo'];
    $tCardShiftReturnDocDate = date('Y-m-d', strtotime($aResult['raItems']['rtCardShiftReturnDocDate']));
    $tCardShiftReturnCardQty = $aResult['raItems']['rtCardShiftReturnCardQty'];
    $tCardShiftReturnCardStaPrcDoc = $aResult['raItems']['rtCardShiftReturnStaPrcDoc'];
    $tCardShiftReturnStaDelMQ = $aResult['raItems']['rtCardShiftReturnStaDelMQ'];
    $tCardShiftReturnCardStaDoc = $aResult['raItems']['rtCardShiftReturnStaDoc'];
    $tRoute = "cardShiftReturnEventEdit";
}else{
    $tCardShiftReturnDocNo = "";
    $tCardShiftReturnDocDate = date('Y-m-d');
    $tCardShiftReturnCardQty = "";
    $tCardShiftReturnCardStaPrcDoc = "";
    $tCardShiftReturnStaDelMQ = "";
    $tCardShiftReturnCardStaDoc = "";
    $tRoute = "cardShiftReturnEventAdd";
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
            <div id="odvPIHeadStatusInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('document/card/cardrefund','tCardShiftRefundDocumentation'); ?></label>
                <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvCardShiftReturnInfo" aria-expanded="true">
                    <i class="fa fa-plus xCNPlus"></i>
                </a>
            </div>
            <div id="odvCardShiftReturnInfo" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                <div class="panel-body">
                    <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCardShiftReturnMainForm" name="ofmAddCardShiftReturnMainForm">
                        <button style="display:none" type="submit" id="obtSubmitCardShiftReturnMainForm" onclick="JSnCardShiftReturnAddEditCardShiftReturn('<?php echo $tRoute; ?>')"></button>
                        <input type="hidden" id="ohdCardShiftReturnLangCode" id="ohdCardShiftReturnLangCode" value="<?php echo $nLangEdit; ?>">
                        <input type="hidden" id="ohdCardShiftReturnUsrBchCode" name="ohdCardShiftReturnUsrBchCode" value="<?php echo $tUserBchCode; ?>">
                        <div>
                            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/card/cardreturn','tCardShiftReturnTBDocNo'); ?></label>
                            <div class="form-group" id="odvCardShiftReturnAutoGenCode">
                                <div class="validate-input">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbCardShiftReturnAutoGenCode" name="ocbCardShiftReturnAutoGenCode" checked="true" value="1">
                                        <span class="xCNLabelFrm"><?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group" id="odvCardShiftReturnDocNoForm">
                                <div class="validate-input">
                                    <input
                                        type="text"
                                        class="form-control input100 xCNInputWithoutSpcNotThai"
                                        id="oetCardShiftReturnCode"
                                        aria-invalid="false"
                                        name="oetCardShiftReturnCode"
                                        data-is-created="<?php echo $tCardShiftReturnDocNo; ?>"
                                        placeholder="<?php echo language('document/card/cardreturn','tCardShiftReturnTBDocNo'); ?>"
                                        value="<?php echo $tCardShiftReturnDocNo; ?>"
                                        data-validate="Plese Generate Code">
                                </div>
                            </div>

                            <!-- modifly by Witsarut 28/10/2019 -->
                            <div class="form-group">
                                <div class="validate-input">
                                    <label class="xCNLabelFrm"><?php echo language('document/card/cardreturn','tCardShiftReturnTBDocDate'); ?></label>
                                    <div class="input-group">
                                        <input
                                            class="form-control input100 xCNDatePicker"
                                            type="text"
                                            name="oetCardShiftReturnDocDate"
                                            id="oetCardShiftReturnDocDate"
                                            aria-invalid="false"
                                            value="<?php echo $tCardShiftReturnDocDate; ?>"
                                            data-validate="Please Insert Doc Date">
                                        <span class="input-group-btn">
                                            <button id="obtShiftReturnDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- modifly by Witsarut 28/10/2019 -->
                            <script>
                                $('#obtShiftReturnDocDate').unbind().click(function(){
                                    $('#oetCardShiftReturnDocDate').focus()
                                });
                            </script>

                            <div class="form-group">
                                <input type="hidden" id="ohdCardShiftReturnCardStaPrcDoc" name="ohdCardShiftReturnCardStaPrcDoc" value="<?php echo $tCardShiftReturnCardStaPrcDoc; ?>">
                                <input type="hidden" id="ohdCardShiftReturnCardStaDoc" name="hdCardShiftReturnCardStaDoc" value="<?php echo $tCardShiftReturnCardStaDoc; ?>">
                                <input type="hidden" id="tCardShiftReturnStaDelMQturn" name="tCardShiftReturnStaDelMQturn" value="<?php echo $tCardShiftReturnStaDelMQ; ?>">
                                <?php
                                $tDocStatus = "";
                                if(empty($tCardShiftReturnCardStaPrcDoc) && !empty($tCardShiftReturnDocNo)){
                                    $tDocStatus = language('document/card/cardreturn','tCardShiftReturnTBPending');
                                }

                                if($tCardShiftReturnCardStaPrcDoc == "2" || $tCardShiftReturnCardStaPrcDoc == "1"){ // Processing or approved
                                    if($tCardShiftReturnCardStaPrcDoc == "2"){
                                        $tDocStatus = language('document/card/cardreturn','tCardShiftReturnTBProcessing');
                                    }else{
                                        $tDocStatus = language('document/card/cardreturn','tCardShiftReturnTBApproved');
                                    }
                                }else{
                                    // if($tStaDoc == "1"){$tRowType = "xWDocComplete";} // Process to pending
                                    if($tCardShiftReturnCardStaDoc == "2"){$tDocStatus = language('document/card/cardreturn','tCardShiftReturnTBIncomplete');}
                                    if($tCardShiftReturnCardStaDoc == "3"){$tDocStatus = language('document/card/cardreturn','tCardShiftReturnTBCancel');}
                                }
                                ?>
                                <label class="xCNLabelFrm"><?php echo language('document/card/cardreturn','tCardShiftReturnTBDocStatus'); ?> <span><?php echo $tDocStatus; ?></span></label>
                            </div>
                            <div class="form-group">
                                <input type="hidden" id="ohdCardShiftReturnUsrCode" name="ohdCardShiftReturnUsrCode" value="<?php echo $tUserCode; ?>">
                                <input type="hidden" id="ohdCardShiftReturnUserCreatedCode" name="ohdCardShiftReturnUserCreatedCode" value="<?php if(empty($tUserCreatedCode)){echo $tUserCode;}else{echo $tUserCreatedCode;} ?>">
                                <label class="xCNLabelFrm"><?php echo language('document/card/cardreturn','tCardShiftReturnCreator'); ?> <span><?php if(empty($tUserCreatedName)){echo $tUserName;}else{echo $tUserCreatedName;} ?></span></label>
                                <div class="clearfix"></div>
                                <?php if($aResult['rtCode'] == "1") : ?>
                                    <input type="hidden" id="ohdCardShiftReturnApvCode" name="ohdCardShiftReturnApvCode" value="<?php if(empty($tUserApvCode)){echo $tUserCode;}else{echo $tUserApvCode;} ?>">
                                    <label class="xCNLabelFrm"><?php echo language('document/card/cardreturn','tCardShiftReturnApprover'); ?>
                                        <span id="ospCardShiftReturnApvName" class="hidden"><?php if(empty($tUserApvName)){echo $tUserName;}else{echo $tUserApvName;} ?></span>
                                    </label>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Panel เลือกข้อมูลตามเงื่อนไข-->
        <div class="panel panel-default" style="margin-bottom: 25px;">
            <div id="odvPIHeadStatusInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('document/card/cardreturn','tCardShiftReturnSelectConditionalInformation'); ?></label>
                <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvCardShiftReturnCondition" aria-expanded="true">
                    <i class="fa fa-plus xCNPlus"></i>
                </a>
            </div>
            <div id="odvCardShiftReturnCondition" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                <div class="panel-body">
                    <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmSearchCard" name="ofmSearchCard">
                        <button style="display:none" type="submit" id="obtSubmitCardShiftReturnSearchCardForm" onclick="JSxCardShiftReturnImportFileValidate();"></button>

                        <!--INPUT : สาขา-->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                            <script>
                                var tUsrLevel = '<?=$this->session->userdata('tSesUsrLevel')?>';
                                if( tUsrLevel != "HQ" ){
                                    var tBchCount = '<?=$this->session->userdata("nSesUsrBchCount");?>';
                                    if(tBchCount < 2){
                                        $('#obtBrowseBCH_CardShiftReturn').attr('disabled',true);
                                    }
                                }
                            </script>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?= language('document/topupvending/topupvending', 'tBCH'); ?></label>
                                <div class="input-group">
                                    <input name="oetBCHName_CardShiftReturn" id="oetBCHName_CardShiftReturn" class="form-control" value="<?=$tUserBchName?>" type="text" readonly="">
                                    <input name="oetBCHCode_CardShiftReturn" id="oetBCHCode_CardShiftReturn" value="<?=$tUserBchCode?>" class="form-control xCNHide" type="text">
                                    <span class="input-group-btn">

                                        <?php
                                        if(empty($tCardShiftReturnCardStaPrcDoc) && $tCardShiftReturnCardStaDoc != "3"){
                                            $tDisabled_CardShiftReturn = '';
                                        }else{
                                            $tDisabled_CardShiftReturn = 'disabled';
                                        }
                                        ?>

                                        <button <?=$tDisabled_CardShiftReturn?> class="btn xCNBtnBrowseAddOn" id="obtBrowseBCH_CardShiftReturn" type="button">
                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-10 col-xs-10 no-padding">
                            <div class="form-group">
                                <div class="validate-input" data-validate="Please Insert Name">
                                    <label class="xCNLabelFrm"><?php echo language('document/card/main','tDocumentQtyCardSuccess'); ?></label>
                                    <input type="text" class="input100 xWPointerEventNone" id="oetCardShiftReturnCountNumber" name="oetCardShiftReturnCountNumber" placeholder="<?php echo language('document/card/cardreturn','tCardShiftReturnNumber'); ?>" value="<?php echo $tCardShiftReturnCardQty; ?>" readonly="true">
                                    <span class="" style="    position: absolute; right: -40px; bottom: -6px;"><?php echo language('document/card/cardreturn','tCardShiftReturnCardUnit'); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php if(empty($tCardShiftReturnCardStaPrcDoc) && $tCardShiftReturnCardStaDoc != "3") : ?>
                            <div class="clearfix"></div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/card/cardreturn','tCardShiftReturnDataSource'); ?></label>
                                </div>
                                <div class="form-group">
                                    <div class="fancy-radio">
                                        <label>
                                            <input type="radio" name="orbCardShiftReturnSourceMode" value="file" onchange="JSxCardShiftReturnVisibleDataSourceMode(this, event)">
                                            <span><i></i> <?php echo language('document/card/cardreturn','tCardShiftReturnFile'); ?></span>
                                        </label>
                                        <label>
                                            <input type="radio" name="orbCardShiftReturnSourceMode" checked="" value="range" onchange="JSxCardShiftReturnVisibleDataSourceMode(this, event)">
                                            <span><i></i> <?php echo language('document/card/cardreturn','tCardShiftReturnChooseFromDataRanges'); ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="odvCardShiftReturnFileContainer" class="hidden">
                                <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                    <div class="form-group">
                                        <!--label class="xCNLabelFrm">Input Browse File/Vedio</label-->
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="oetCardShiftReturnFileTemp" name="oetCardShiftReturnFileTemp" placeholder="<?php echo language('document/card/cardreturn','tCardShiftNewCardChooseFile'); ?>" readonly>
                                            <input type="file" class="form-control" style="visibility: hidden; position: absolute;" id="oefCardShiftReturnImport" name="oefCardShiftReturnImport" onchange="JSxCardShiftReturnSetImportFile(this, event)">
                                            <span class="input-group-btn">
                                                <button id="obtFile" type="button" class="btn btn-primary" onclick="$('#oefCardShiftReturnImport').click()">
                                                    + <?php echo language('document/card/newcard','tSelectFile');?>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <a id="oahCardShiftReturnDataLoadMask" class="btn xCNBTNDefult xCNBTNDefult1Btn" style="margin-bottom: 20px;" target="_blank" href="<?php echo base_url('application/modules/document/assets/carddocfile/Temp_Return.xlsx'); ?>"><?php echo language('document/card/cardreturn','tCardShiftReturnDownloadTemplate'); ?></a>
                                </div>
                            </div>
                            <div id="odvCardShiftReturnRangeContainer">
                                <div class="col-xl-6 col-lg-6 col-md-6 no-padding">  <!--จากประเภท-->
                                    <div class="form-group">
                                        <div class="validate-input" data-validate="Please Enter">
                                            <label class="xCNLabelFrm"><?php echo language('document/card/cardreturn','tCardShiftReturnFromType'); ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetCardShiftReturnFromCardTypeCode" name="oetCardShiftReturnFromCardTypeCode">
                                                <input class="form-control xWPointerEventNone" type="text" id="oetCardShiftReturnFromCardTypeName" name="oetCardShiftReturnFromCardTypeName" placeholder="<?php echo language('document/card/cardreturn','tCardShiftReturnFrom'); ?>" readonly="">
                                                <span class="xWConditionSearchPdt input-group-btn">
                                                    <button id="oimCardShiftReturnFromCardType" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
                                                        <img class="xCNIconFind">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 no-padding"> <!--ถึงประเภท-->
                                    <div class="form-group padding-left5">
                                        <div class="validate-input" data-validate="Please Enter">
                                            <label class="xCNLabelFrm"><?php echo language('document/card/cardreturn','tCardShiftReturnToType'); ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetCardShiftReturnToCardTypeCode" name="oetCardShiftReturnToCardTypeCode">
                                                <input class="form-control xWPointerEventNone" type="text" id="oetCardShiftReturnToCardTypeName" name="oetCardShiftReturnToCardTypeName" placeholder="<?php echo language('document/card/cardreturn','tCardShiftReturnTo'); ?>" readonly="">
                                                <span class="xWConditionSearchPdt input-group-btn">
                                                    <button id="oimCardShiftReturnToCardType" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
                                                        <img class="xCNIconFind">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 no-padding"> <!--จากหมายเลขบัตร-->
                                    <div class="form-group">
                                        <div class="validate-input" data-validate="Please Enter">
                                            <label class="xCNLabelFrm"><?php echo language('document/card/cardreturn','tCardShiftReturnFromCardNumber'); ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetCardShiftReturnFromCardNumberCode" name="oetCardShiftReturnFromCardNumberCode">
                                                <input class="form-control xWPointerEventNone" type="text" id="oetCardShiftReturnFromCardNumberName" name="oetCardShiftReturnFromCardNumberName" placeholder="<?php echo language('document/card/cardreturn','tCardShiftReturnFrom'); ?>" readonly="">
                                                <span class="xWConditionSearchPdt input-group-btn">
                                                    <button id="oimCardShiftReturnFromCardNumber" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
                                                        <img class="xCNIconFind">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 no-padding"> <!--ถึงหมายเลขบัตร-->
                                    <div class="form-group padding-left5">
                                        <div class="validate-input" data-validate="Please Enter">
                                            <label class="xCNLabelFrm"><?php echo language('document/card/cardreturn','tCardShiftReturnToCardNumber'); ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetCardShiftReturnToCardNumberCode" name="oetCardShiftReturnToCardNumberCode">
                                                <input class="form-control xWPointerEventNone" type="text" id="oetCardShiftReturnToCardNumberName" name="oetCardShiftReturnToCardNumberName" placeholder="<?php echo language('document/card/cardreturn','tCardShiftReturnTo'); ?>" readonly="">
                                                <span class="xWConditionSearchPdt input-group-btn">
                                                    <button id="oimCardShiftReturnToCardNumber" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
                                                        <img class="xCNIconFind">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <div id="odvCardShiftReturnAlert" class="pull-left">
                                    <label class="xWMsgConditonErr xWNotFound hidden"><?php echo language('document/card/cardreturn','tCardShiftReturnDataNotFound'); ?></label>
                                    <label class="xWMsgConditonErr xWCheckCondition hidden"><?php echo language('document/card/cardreturn','tCardShiftReturnPleaseCheckTheDataImportConditions'); ?></label>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <button type="button" class="btn xCNBTNPrimery xCNBTNPrimery2Btn pull-right" onclick="JSxCardShiftReturnSetDataSourceFilter()"> <?php echo language('document/card/cardreturn','tCardShiftReturnBringDataIntoTheTable'); ?></button>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
<div class="col-xl-8 col-lg-8 col-md-8">
    <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCardShiftReturnDataSource">
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
                                    id="oetCardShiftReturnDataSearch"
                                    name="oetCardShiftReturnDataSearch"
                                    onkeypress="javascript:if(event.keyCode==13) JSxCardShiftReturnSearchDataSourceTable()"
                                    onkeyup="//JSxCardShiftReturnSearchDataSourceTable()"
                                    placeholder="<?=language('common/main/main','tSearch'); ?>">
                                <span class="input-group-btn">
                                    <button id="obtSearch" type="button" class="btn xCNBtnSearch" onclick="JSxCardShiftReturnSearchDataSourceTable()">
                                        <img src="<?=base_url('application/modules/common/assets/images/icons/search-24.png'); ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!--ยิงสแกนเนอร์ และเพิ่มข้อมูล-->
                    <?php if(empty($tCardShiftReturnCardStaPrcDoc) && $tCardShiftReturnCardStaDoc != "3") : ?>
                        <div class="col-xl-4 col-lg-4 col-md-2 col-sm-4 col-xs-0" ></div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-4 col-xs-12" >
                            <div class="row">
                                <div class="col-xl-10 col-lg-10 col-md-9 col-sm-10 col-xs-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="oetCardShiftReturnDataScannerID"
                                                name="oetCardShiftReturnDataScannerID"
                                                maxlength="50"
                                                placeholder="<?=language('common/main/main','tFilterCardScanner'); ?>"
                                                onkeypress="Javascript:if(event.keyCode==13) JSxCardShiftReturnScanner(event,this);" >
                                            <span class="input-group-btn">
                                                <button type="button" class="btn xCNBtnSearch" onclick="JSxCardShiftReturnScanner()">
                                                    <img src="<?=base_url('application/modules/common/assets/images/icons/scanner.png'); ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-2 col-xs-12">
                                    <input type="hidden" id="testCode" value="">
                                    <input type="hidden" id="testName" value="">
                                    <button id="obtCardShiftReturnAddDataSource" class="xCNBTNPrimeryPlus pull-right" type="button" title="<?php echo language('document/card/cardreturn','tCardShiftReturnBringDataIntoTheTable'); ?>">+</button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div id="odvCardShiftReturnDataSource"></div>
                <input type="hidden" id="ohdCardShiftReturnCardCodeTemp">
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="odvCardShiftReturnModalEmptyCardAlert">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/card/cardreturn', 'tCardShiftReturnApproveTheDocument'); ?></label>
            </div>
            <div class="modal-body">
                <?php echo language('document/card/cardreturn', 'tCardShiftEmptyRecordAlert'); ?>
            </div>
            <div class="modal-footer">
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="odvCardShiftReturnModalImportFileConfirm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/card/cardreturn', 'tCardShiftReturnBringDataIntoTheTable') ?></label>
            </div>
            <div class="modal-body">
                <?php echo language('document/card/cardreturn', 'tCardShiftReturnImportFileConfirm'); ?>
            </div>
            <div class="modal-footer">
                <!-- แก้ -->
                <button id="osmCardShiftReturnBtnImportFileConfirm" onClick="" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
                    <?php echo language('common/main/main', 'tModalConfirm') ?>
                </button>
                <!-- แก้ -->
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade xCNModalApprove" id="odvCardShiftReturnPopupApv">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/card/cardreturn', 'tCardShiftReturnApproveTheDocument'); ?></h5>
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
                <button id="obtCardShiftReturnPopupApvConfirm" onclick="JSxCardShiftReturnStaApvDoc(true)" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="odvCardShiftReturnPopupStaDoc">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/card/cardreturn', 'tCardShiftReturnCancelTheDocument'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo language('document/card/newcard', 'tCardShiftNewCardCancelAlert'); ?></p>
                <strong><?php echo language('document/card/newcard', 'tCardShiftNewCardCancelAlert1'); ?></strong>
            </div>
            <div class="modal-footer">
                <button id="obtCardShiftReturnPopupStaDocConfirm" onclick="JSxCardShiftReturnStaDoc(true)" type="button" class="btn xCNBTNPrimery">
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

<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js'); ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js'); ?>"></script>
<?php include "script/jCardShiftReturnAdd.php"; ?>
