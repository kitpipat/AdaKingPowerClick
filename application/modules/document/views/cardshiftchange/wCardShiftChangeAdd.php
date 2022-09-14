<?php
if($aResult['rtCode'] == "1"){
    $tCardShiftChangeDocNo = $aResult['raItems']['rtCardShiftChangeDocNo'];
    $tCardShiftChangeDocDate = date('Y-m-d', strtotime($aResult['raItems']['rtCardShiftChangeDocDate']));
    $tCardShiftChangeCardQty = $aResult['raItems']['rtCardShiftChangeCardQty'];
    $tCardShiftChangeCardStaPrcDoc = $aResult['raItems']['rtCardShiftChangeStaPrcDoc'];
    $tCardShiftChangeStaDelMQ = $aResult['raItems']['rtCardShiftChangeStaDelMQ'];
    $tCardShiftChangeCardStaDoc = $aResult['raItems']['rtCardShiftChangeStaDoc'];
    $tCardShiftStaCrdActive = $aResult['raItems']['rtCardShiftStaCrdActive'];
    $tRoute = "cardShiftChangeEventEdit";
}else{
    $tCardShiftStaCrdActive = "1";
    $tCardShiftChangeDocNo = "";
    $tCardShiftChangeDocDate = date('Y-m-d');
    $tCardShiftChangeCardQty = "";
    $tCardShiftChangeCardStaPrcDoc = "";
    $tCardShiftChangeStaDelMQ = "";
    $tCardShiftChangeCardStaDoc = "";
    $tRoute = "cardShiftChangeEventAdd";
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
    .xWCardShiftChangeBackDrop {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1040;
        background-color: #000;
        filter: alpha(opacity=50);
        opacity: .5;
    }
    #xWCardShiftChangeCardChangeContainer{
        max-height: calc(100vh - 300px);
        overflow-x: auto;
    }
</style>

<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
        <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCardShiftChangeMainForm" name="ofmAddCardShiftChangeMainForm">
            <button style="display:none" type="submit" id="obtSubmitCardShiftChangeMainForm" onclick="JSnCardShiftChangeAddEditCardShiftChange('<?php echo $tRoute; ?>')"></button>
            <input type="hidden" id="ohdCardShiftChangeLangCode" name="ohdCardShiftChangeLangCode" value="<?php echo $nLangEdit;?>">
            <input type="hidden" id="ohdCardShiftChangeUsrBchCode" name="ohdCardShiftChangeUsrBchCode" value="<?php echo $tUserBchCode;?>">
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label><?php echo language('document/card/cardchange','tCardShiftChangeDocumentation'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvCardShiftChangeDocumentation" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvCardShiftNewInfo" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <label class="xCNLabelFrm"><span style="color:red">*</span> <?php echo language('document/card/cardchange','tCardShiftChangeTBDocNo'); ?></label>
                        <div class="form-group" id="odvCardShiftChangeAutoGenCode">
                            <div class="">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbCardShiftChangeAutoGenCode" name="ocbCardShiftChangeAutoGenCode" checked="true" value="1">
                                    <span class="xCNLabelFrm"> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group" id="odvCardShiftChangeDocNoForm">
                            <div class="validate-input">
                                <input
                                    type="text"
                                    class="form-control input100 xCNInputWithoutSpcNotThai"
                                    id="oetCardShiftChangeCode"
                                    aria-invalid="false"
                                    name="oetCardShiftChangeCode"
                                    data-is-created="<?php echo $tCardShiftChangeDocNo; ?>"
                                    placeholder="<?php echo language('document/card/cardchange','tCardShiftChangeTBDocNo'); ?>"
                                    value="<?php echo $tCardShiftChangeDocNo; ?>"
                                    data-validate="Plese Generate Code">
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/card/cardchange','tCardShiftChangeTBDocDate'); ?></label>
                                <div class="input-group">
                                    <input
                                        class="form-control input100 xCNDatePicker"
                                        type="text"
                                        name="oetCardShiftChangeDocDate"
                                        id="oetCardShiftChangeDocDate"
                                        aria-invalid="false"
                                        value="<?php echo $tCardShiftChangeDocDate; ?>"
                                        data-validate="Please Insert Doc Date"
                                    >
                                    <span class="input-group-btn">
                                        <button type="button" class="btn xCNBtnDateTime" onclick="$('#oetCardShiftChangeDocDate').focus()"><img class="xCNIconCalendar"></button>
                                    </span>
                                </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="ohdCardShiftChangeCardStaPrcDoc" name="ohdCardShiftChangeCardStaPrcDoc" value="<?php echo $tCardShiftChangeCardStaPrcDoc; ?>">
                            <input type="hidden" id="ohdCardShiftChangeCardStaDoc" name="ohdCardShiftChangeCardStaDoc" value="<?php echo $tCardShiftChangeCardStaDoc; ?>">
                            <input type="hidden" id="ohdCardShiftChangeStaDelQname" name="ohdCardShiftChangeStaDelQname" value="<?php echo $tCardShiftChangeStaDelMQ; ?>">
                            <?php
                            $tDocStatus = "";
                            if(empty($tCardShiftChangeCardStaPrcDoc) && !empty($tCardShiftChangeDocNo)){
                                $tDocStatus = language('document/card/cardchange','tCardShiftChangeTBPending');
                            }

                            if($tCardShiftChangeCardStaPrcDoc == "2" || $tCardShiftChangeCardStaPrcDoc == "1"){ // Processing or approved
                                if($tCardShiftChangeCardStaPrcDoc == "2"){
                                    $tDocStatus = language('document/card/cardchange','tCardShiftChangeTBProcessing');
                                }else{
                                    $tDocStatus = language('document/card/cardchange','tCardShiftChangeTBApproved');
                                }
                            }else{
                                // if($tStaDoc == "1"){$tRowType = "xWDocComplete";} // Process to pending
                                if($tCardShiftChangeCardStaDoc == "2"){$tDocStatus = language('document/card/cardchange','tCardShiftChangeTBIncomplete');}
                                if($tCardShiftChangeCardStaDoc == "3"){$tDocStatus = language('document/card/cardchange','tCardShiftChangeTBCancel');}
                            }
                            ?>
                            <label class="xCNLabelFrm"><?php echo language('document/card/cardchange','tCardShiftChangeTBDocStatus'); ?> <span><?php echo $tDocStatus; ?></span></label>
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="ohdCardShiftChangeUsrCode" name="ohdCardShiftChangeUsrCode" value="<?php echo $tUserCode; ?>">
                            <input type="hidden" id="ohdCardShiftChangeUserCreatedCode" name="ohdCardShiftChangeUserCreatedCode" value="<?php if(empty($tUserCreatedCode)){echo $tUserCode;}else{echo $tUserCreatedCode;} ?>">
                            <label class="xCNLabelFrm"><?php echo language('document/card/cardchange','tCardShiftChangeCreator'); ?> <span><?php if(empty($tUserCreatedName)){echo $tUserName;}else{echo $tUserCreatedName;} ?></span></label>
                            <div class="clearfix"></div>
                            <?php if($aResult['rtCode'] == "1") : ?>
                                <input type="hidden" id="ohdCardShiftChangeApvCode" name="ohdCardShiftChangeApvCode" value="<?php if(empty($tUserApvCode)){echo $tUserCode;}else{echo $tUserApvCode;} ?>">
                                <label class="xCNLabelFrm"><?php echo language('document/card/cardchange','tCardShiftChangeApprover'); ?>
                                    <span id="ospCardShiftChangeApvName" class="hidden"><?php if(empty($tUserApvName)){echo $tUserName;}else{echo $tUserApvName;} ?></span>
                                </label>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmSearchCard" name="ofmSearchCard">
            <button style="display:none" type="submit" id="obtSubmitCardShiftChangeSearchCardForm" onclick="JSxCardShiftChangeImportFileValidate();"></button>
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label><?php echo language('document/card/cardchange','tCardShiftChangeSelectConditionalInformation'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvCardShiftChangeInfomation" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvCardShiftChangeInfomation" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">

                         <!--INPUT : สาขา-->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                            <script>
                                var tUsrLevel = '<?=$this->session->userdata('tSesUsrLevel')?>';
                                if( tUsrLevel != "HQ" ){
                                    var tBchCount = '<?=$this->session->userdata("nSesUsrBchCount");?>';
                                    if(tBchCount < 2){
                                        $('#obtBrowseBCH_CardShiftChange').attr('disabled',true);
                                    }
                                }
                            </script>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?= language('document/topupvending/topupvending', 'tBCH'); ?></label>
                                <div class="input-group">
                                    <input name="oetBCHName_CardShiftChange" id="oetBCHName_CardShiftChange" class="form-control" value="<?=$tUserBchName?>" type="text" readonly="">
                                    <input name="oetBCHCode_CardShiftChange" id="oetBCHCode_CardShiftChange" value="<?=$tUserBchCode?>" class="form-control xCNHide" type="text">
                                    <span class="input-group-btn">

                                        <?php
                                        if(empty($tCardShiftChangeCardStaPrcDoc) && $tCardShiftChangeCardStaDoc != "3"){
                                            $tDisabled_CardShiftChange = '';
                                        }else{
                                            $tDisabled_CardShiftChange = 'disabled';
                                        }
                                        ?>

                                        <button <?=$tDisabled_CardShiftChange?> class="btn xCNBtnBrowseAddOn" id="obtBrowseBCH_CardShiftChange" type="button">
                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-10 col-xs-10 no-padding">
                            <div class="form-group">
                                <div class="validate-input" data-validate="Please Insert Name">
                                    <label class="xCNLabelFrm"><?php echo language('document/card/cardchange','tCardShiftChangeCardChange'); ?></label>
                                    <input type="text" class="input100 xWPointerEventNone" id="oetCardShiftChangeCountNumber" name="oetCardShiftChangeCountNumber" placeholder="<?php echo language('document/card/cardchange','tCardShiftChangeNumber'); ?>" value="<?php echo $tCardShiftChangeCardQty; ?>" readonly="true">
                                    <span class="" style="    position: absolute; right: -40px; bottom: -6px;"><?php echo language('document/card/cardchange','tCardShiftChangeCardUnit'); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php if(empty($tCardShiftChangeCardStaPrcDoc) && $tCardShiftChangeCardStaDoc != "3") : ?>
                            <div class="clearfix"></div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/card/cardchange','tCardShiftChangeDataSource'); ?></label>
                                </div>
                                <div class="form-group">
                                    <div class="fancy-radio">
                                        <label>
                                            <input type="radio" name="orbCardShiftChangeSourceMode" value="file" onchange="JSxCardShiftChangeVisibleDataSourceMode(this, event)">
                                            <span><i></i> <?php echo language('document/card/cardchange','tCardShiftChangeFile'); ?></span>
                                        </label>
                                        <label>
                                            <input type="radio" name="orbCardShiftChangeSourceMode" checked="" value="range" onchange="JSxCardShiftChangeVisibleDataSourceMode(this, event)">
                                            <span><i></i> <?php echo language('document/card/cardchange','tCardShiftChangeChooseFromDataRanges'); ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="odvCardShiftChangeFileContainer" class="hidden">
                                <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                    <div class="form-group">
                                        <!--label class="xCNLabelFrm">Input Browse File/Vedio</label-->
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="oetCardShiftChangeFileTemp" name="oetCardShiftChangeFileTemp" placeholder="<?php echo language('document/card/cardchange','tCardShiftNewCardChooseFile'); ?>" readonly>
                                            <input type="file" class="form-control" style="visibility: hidden; position: absolute;" id="oefCardShiftChangeImport" name="oefCardShiftChangeImport" onchange="JSxCardShiftChangeSetImportFile(this, event)">
                                            <span class="input-group-btn">
                                                <button id="obtFile" type="button" class="btn btn-primary" onclick="$('#oefCardShiftChangeImport').click()">
                                                    + <?php echo language('document/card/newcard','tSelectFile');?>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('document/card/cardchange','tCardShiftChangeReason'); ?></label>
                                        <div class="input-group">
                                            <input type="text" class="xCNHide" id="oetCardShiftChangeReasonCodeFile" name="oetCardShiftChangeReasonCodeFile">
                                            <input
                                                type="text"
                                                class="form-control xWPointerEventNone"
                                                id="oetCardShiftChangeReasonNameFile"
                                                name="oetCardShiftChangeReasonNameFile"
                                                readonly
                                            >
                                            <span class="input-group-btn">
                                                <button id="oimCardShiftChangeReasonFile" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
                                                    <img class="xCNIconFind">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <a id="oahCardShiftChangeDataLoadMask" class="btn xCNBTNDefult xCNBTNDefult1Btn" style="margin-bottom: 20px;" target="_blank" href="<?php echo base_url('application/modules/document/assets/carddocfile/Temp_CardTrf.xlsx'); ?>"><?php echo language('document/card/cardchange','tCardShiftChangeDownloadTemplate'); ?></a>
                                </div>
                            </div>
                            <div id="odvCardShiftChangeRangeContainer">
                                <div class="col-xl-6 col-lg-6 col-md-6 no-padding">
                                    <div class="form-group padding-right5">
                                        <label class="xCNLabelFrm"><?php echo language('document/card/cardchange','tCardShiftChangeFromType'); ?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetCardShiftChangeFromCardTypeCode" name="oetCardShiftChangeFromCardTypeCode">
                                            <input
                                                type="text"
                                                class="form-control xWPointerEventNone"
                                                id="oetCardShiftChangeFromCardTypeName"
                                                name="oetCardShiftChangeFromCardTypeName"
                                                placeholder="<?php echo language('document/card/cardchange','tCardShiftChangeFrom');?>"
                                                readonly
                                            >
                                            <span class="input-group-btn">
                                                <button id="oimCardShiftChangeFromCardType" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
                                                    <img class="xCNIconFind">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 no-padding">
                                    <div class="form-group padding-left5">
                                        <label class="xCNLabelFrm"><?php echo language('document/card/cardchange','tCardShiftChangeToType'); ?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetCardShiftChangeToCardTypeCode" name="oetCardShiftChangeToCardTypeCode">
                                            <input
                                                type="text"
                                                class="form-control xWPointerEventNone"
                                                id="oetCardShiftChangeToCardTypeName"
                                                name="oetCardShiftChangeToCardTypeName"
                                                placeholder="<?php echo language('document/card/cardchange','tCardShiftChangeTo');?>"
                                                readonly
                                            >
                                            <span class="input-group-btn">
                                                <button id="oimCardShiftChangeToCardType" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
                                                    <img class="xCNIconFind">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 no-padding">
                                    <div class="form-group padding-right5">
                                        <label class="xCNLabelFrm"><?php echo language('document/card/cardchange','tCardShiftChangeFromCardNumber'); ?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetCardShiftChangeFromCardNumberCode" name="oetCardShiftChangeFromCardNumberCode">
                                            <input
                                                type="text"
                                                class="form-control xWPointerEventNone"
                                                id="oetCardShiftChangeFromCardNumberName"
                                                name="oetCardShiftChangeFromCardNumberName"
                                                placeholder="<?php echo language('document/card/cardchange','tCardShiftChangeFrom'); ?>"
                                                readonly
                                            >
                                            <span class="input-group-btn">
                                                <button id="oimCardShiftChangeFromCardNumber" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
                                                    <img class="xCNIconFind">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 no-padding">
                                    <div class="form-group padding-left5">
                                        <label class="xCNLabelFrm"><?php echo language('document/card/cardchange','tCardShiftChangeToCardNumber'); ?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetCardShiftChangeToCardNumberCode" name="oetCardShiftChangeToCardNumberCode">
                                            <input
                                                type="text"
                                                class="form-control xWPointerEventNone"
                                                id="oetCardShiftChangeToCardNumberName"
                                                name="oetCardShiftChangeToCardNumberName"
                                                placeholder="<?php echo language('document/card/cardchange','tCardShiftChangeTo');?>"
                                                readonly
                                            >
                                            <span class="input-group-btn">
                                                <button id="oimCardShiftChangeToCardNumber" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">
                                                    <img class="xCNIconFind">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <div id="odvCardShiftChangeAlert" class="pull-left">
                                    <label class="xWMsgConditonErr xWNotFound hidden"><?php echo language('document/card/cardchange','tCardShiftChangeDataNotFound'); ?></label>
                                    <label class="xWMsgConditonErr xWCheckCondition hidden"><?php echo language('document/card/cardchange','tCardShiftChangePleaseCheckTheDataImportConditions'); ?></label>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <button type="button" class="btn xCNBTNPrimery xCNBTNPrimery2Btn pull-right" onclick="JSxCardShiftChangeSetDataSourceFilter()"> <?php echo language('document/card/cardchange','tCardShiftChangeBringDataIntoTheTable'); ?></button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-9">
        <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCardShiftChangeDataSource">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default" style="margin-bottom:25px;position:relative;">
                        <div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
                            <div class="panel-body">
                                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-xs-7 p-t-10 p-l-0">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="oetCardShiftChangeDataSearch"
                                                name="oetCardShiftChangeDataSearch"
                                                onkeypress="javascript:if(event.keyCode==13) JSxCardShiftChangeSearchDataSourceTable()"
                                                onkeyup="// JSxCardShiftChangeSearchDataSourceTable()"
                                                placeholder="<?php echo language('common/main/main', 'tSearch'); ?>">
                                            <span class="input-group-btn">
                                                <button id="obtSearch" type="button" class="btn xCNBtnSearch" onclick="JSxCardShiftChangeSearchDataSourceTable()">
                                                    <img src="<?php echo base_url('application/modules/common/assets/images/icons/search-24.png'); ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <?php if(empty($tCardShiftChangeCardStaPrcDoc) && $tCardShiftChangeCardStaDoc != "3") : ?>
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-5 no-padding">
                                        <input type="hidden" id="testCode" value="">
                                        <input type="hidden" id="testName" value="">
                                        <button id="obtCardShiftChangeAddDataSource" class="xCNBTNPrimeryPlus pull-right" type="button" title="<?php echo language('document/card/cardchange','tCardShiftChangeBringDataIntoTheTable'); ?>">+</button>
                                    </div>
                                <?php endif; ?>
                                <div id="odvCardShiftChangeDataSource"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="odvCardShiftChangeModalEmptyCardAlert">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/card/cardrefund', 'tCardShiftChangeApproveTheDocument'); ?></label>
            </div>
            <div class="modal-body">
                <?php echo language('document/card/cardrefund', 'tCardShiftEmptyRecordAlert'); ?>
            </div>
            <div class="modal-footer">
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="odvCardShiftChangeModalImportFileConfirm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/card/cardout', 'tCardShiftChangeBringDataIntoTheTable') ?></label>
            </div>
            <div class="modal-body">
                <?php echo language('document/card/cardout', 'tCardShiftChangeImportFileConfirm'); ?>
            </div>
            <div class="modal-footer">
                <!-- แก้ -->
                <button id="osmCardShiftChangeBtnImportFileConfirm" onClick="" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
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

<div class="modal fade xCNModalApprove" id="odvCardShiftChangePopupApv">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/card/cardchange', 'tCardShiftChangeApproveTheDocument'); ?></h5>
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
                <button id="obtCardShiftChangePopupApvConfirm" onclick="JSxCardShiftChangeStaApvDoc(true)" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="odvCardShiftChangePopupStaDoc">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/card/cardchange', 'tCardShiftChangeCancelTheDocument'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo language('document/card/newcard', 'tCardShiftNewCardCancelAlert'); ?></p>
                <strong><?php echo language('document/card/newcard', 'tCardShiftNewCardCancelAlert1'); ?></strong>
            </div>
            <div class="modal-footer">
                <button id="obtCardShiftChangePopupStaDocConfirm" onclick="JSxCardShiftChangeStaDoc(true)" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<div id="odvCardShiftChangePopUpCardChangeModal"></div>
<script id="oscCardShiftChangeModalTableTemplate" type="text/html">
<div class="modal fade" id="odvCardShiftChangePopupCardChange">
    <div class="modal-dialog modal-lg">
        <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCardShiftChangePopUpCardChangeForm">
            <button style="display:none" type="submit" id="obtSubmitCardShiftChangeCardChangeForm" onclick="JSnCardShiftChangePopUpCardChangeValidate();"></button>
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('document/card/cardchange', 'tCardShiftChangeNewCard'); ?></label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-6 col-lg-6 col-md-6 no-padding">
                        <div class="form-group">
                            <div class="validate-input" data-validate="Please Enter">
                                <label class="xCNLabelFrm"><?php echo language('document/card/cardchange', 'tCardShiftChangeReason'); ?></label>
                                <input type="text" class="xCNHide" id="oetCardShiftChangeReasonCode" name="oetCardShiftChangeReasonCode">
                                <input class="form-control xWPointerEventNone" type="text" id="oetCardShiftChangeReasonName" name="oetCardShiftChangeReasonName" readonly="" onchange="JSnCardShiftChangePopUpCardChangeValidate()">
                                <img id="oimCardShiftChangeReason" class="xCNIconBrowse" src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                            </div>
                        </div>
                    </div>
                    <{scriptTag}>
                        $('#oimCardShiftChangeReason').click(function(){console.log("Reson"); JCNxBrowseData('oCardShiftChangeBrowseReason');});
                    </{scriptTag}>
                    <div class="clearfix"></div>
                    <div id="xWCardShiftChangeCardChangeContainer">
                        <table class="table table-striped" id="otbCardShiftChangeCardTable">
                        <thead>
                            <tr>
                                <th nowrap class="xCNTextBold text-center" style="width:4%;"><?php echo language('common/main/main','tCMNSequence'); ?></th>
                                <th nowrap class="xCNTextBold text-left" style="width:48%;"><?php echo language('document/card/cardchange', 'tCardShiftChangeTBCode'); ?></th>
                                <th nowrap class="xCNTextBold text-left" style="width:48%;"><?php echo language('document/card/cardchange', 'tCardShiftChangeTBNewCode'); ?></th>
                            </tr>
                        </thead>
                            <tbody id="otbCardShiftChangeList">{trBody}</tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="obtCardShiftChangePopupSetConfirm" onclick="$('#obtSubmitCardShiftChangeCardChangeForm').click()" type="button" class="btn xCNBTNPrimery xCNBTNPrimery2Btn">
                        <?php echo language('common/main/main', 'tModalConfirm'); ?>
                    </button>
                    <button type="button" class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal">
                        <?php echo language('common/main/main', 'tModalCancel'); ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</script>

<script type="text/html" id="oscCardShiftChangeTrBodyTemplate">
<tr>
    <td nowrap class="text-center">{index}</td>
    <td nowrap class="xWCardShiftChangeOldCardCode">{oldCardCode}<input type="hidden" class="xWCardShiftChangeHolderID" value="{oldCardHolderID}"></td>
    <td nowrap>
        <div class="form-group" style="margin-bottom: 0px;">
            <div class="validate-input" data-validate="Please Enter">
                <input type="text" class="xWCardShiftChangeNewCardCode xWCardShiftChangeValidate form-control" maxlength="20" id="oetCardShiftChangeCardNumberCode{index}" name="oetCardShiftChangeCardNumberCode{index}">
                <input class="xWCardShiftChangeNewCardCode xWCardShiftChangeValidate form-control xWPointerEventNone_ xCNHide" type="text" id="oetCardShiftChangeCardNumberName{index}" name="oetCardShiftChangeCardNumberName{index}" readonly_>
                <img data-CtyStaPay = "{oldStaPay}" id="oimCardShiftChangeAddNewCardIcon{index}" class="xCNIconBrowse" src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
            </div>
        </div>
    </td>
</tr>
<{scriptTag}>

$(document).ready(function() {
    $("#oimCardShiftChangeAddNewCardIcon{index}").on("click", function(){
        window.CardShiftChangeGetPopUpCardCode = JSaCardShiftChangeGetCardCodeInPopUp("oldCardCode", true).toString();
    });
    $('#oimCardShiftChangeAddNewCardIcon{index}').click(function(){
        window.oCardShiftChangeBrowseNewCardOption{index} = oCardShiftChangeBrowseNewCard{index}(CardShiftChangeGetPopUpCardCode);
        JCNxBrowseData('oCardShiftChangeBrowseNewCardOption{index}');
    });
});

var oCardShiftChangeBrowseNewCard{index} = function(ptNotCardCode) {
    console.log("Not Card Code: ", ptNotCardCode);
    let tNotIn = "";
    if(!ptNotCardCode == ""){
        tNotIn = "AND TFNMCard.FTCrdCode NOT IN ('{oldCardCode}')";
    }
    var tCtyStaPay = $('#oimCardShiftChangeAddNewCardIcon'+{index}).attr('data-CtyStaPay');
    var tStaUsrLevel    = '<?php  echo $this->session->userdata("tSesUsrLevel"); ?>';
    var tCondition = '';
    if (tStaUsrLevel=="HQ") {
       tCondition = " AND (TFNMCard.FTAgnCode ='' OR TFNMCard.FTAgnCode !='') ";
     }else {
       tCondition = " AND TFNMCard.FTAgnCode ='<?php echo $this->session->userdata("tSesUsrAgnCode"); ?>' ";
       tCondition = " AND TFNMCard.FTAgnCode ='<?php echo $this->session->userdata("tSesUsrAgnCode"); ?>' AND TFNMCard.FTAgnCode !='' ";
     }
    var tWhereFCXsdAmt = "AND ((CASE TFNMCardType.FTCtyStapay WHEN '2' THEN TFNMCardType.FCCtyCreditLimit - ISNULL(dbo.F_GETnCardAmount(TFNMCard.FTCrdCode),0) ELSE ISNULL(dbo.F_GETnCardAmount(TFNMCard.FTCrdCode),0) END) = 0)";
    let oOptions = {
        //DebugSQL : true,
        Title : ['payment/card/card','tCRDTitle'],
        Table:{Master:'TFNMCard', PK:'FTCrdCode'},
        Join :{
            Table: ['TFNMCard_L', 'TFNMCardType'],
            On: [
                'TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits,
                'TFNMCardType.FTCtyCode = TFNMCard.FTCtyCode'
            ]
        },
        Where :{
            Condition : [" AND (TFNMCard.FTCrdStaShift = '2') AND (TFNMCardType.FTCtyStaPay = '"+tCtyStaPay+"') AND (TFNMCard.FTCrdStaActive = '1') AND (CONVERT(date, TFNMCard.FDCrdExpireDate) > CONVERT(date, GETDATE())) AND TFNMCard.FTCrdHolderID = '{oldCardHolderID}' " + tNotIn + tWhereFCXsdAmt  + tCondition]
        },
        GrideView:{
            ColumnPathLang	: 'payment/card/card',
            ColumnKeyLang	: ['tCRDTBCode', 'tCRDTBName', ''],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal      : 50,
            DataColumns		: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName'],
            DisabledColumns	:[],
            DataColumnsFormat : ['', ''],
            Perpage			: 500,
            OrderBy			: ['TFNMCard_L.FTCrdName'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetCardShiftChangeCardNumberCode{index}", "TFNMCard.FTCrdCode"],
            Text		: ["oetCardShiftChangeCardNumberName{index}", "TFNMCard_L.FTCrdCode"]
        },
        /*NextFunc:{
            FuncName: 'JSxCardShiftChangeCallBackValidate', // 'JSxCardShiftChangeSetDataSource',
            ArgReturn: ['FTCrdCode']
        },*/
        // RouteFrom : 'cardShiftChange',
        RouteAddNew : 'card',
        BrowseLev : nStaCardShiftChangeBrowseType,
         //DebugSQL:true,
    };
    return oOptions;
};
</{scriptTag}>
</script>

<div class="xWCardShiftChangeBackDrop hidden" style="z-index: 1039;"></div>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js'); ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js'); ?>"></script>
<?php include "script/jCardShiftChangeAdd.php"; ?>
