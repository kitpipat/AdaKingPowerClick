<?php
if($aResult['rtCode'] == "1"){
    $tCardShiftNewCardDocNo         = $aResult['raItems']['rtCardShiftNewCardDocNo'];
    $tCardShiftNewCardDocDate       = date('Y-m-d', strtotime($aResult['raItems']['rtCardShiftNewCardDocDate']));
    $tCardShiftNewCardCardQty       = $aResult['raItems']['rtCardShiftNewCardQty'];
    $tCardShiftNewCardCardStaPrcDoc = $aResult['raItems']['rtCardShiftNewCardStaPrcDoc'];
    $tCardShiftNewCardStaDelMQ      = $aResult['raItems']['rtCardShiftNewCardStaDelMQ'];
    $tCardShiftNewCardCardStaDoc    = $aResult['raItems']['rtCardShiftNewCardStaDoc'];
    $tRoute                         = "cardShiftNewCardEventEdit";
}else{
    $tCardShiftNewCardDocNo         = "";
    $tCardShiftNewCardDocDate       = date('Y-m-d');
    $tCardShiftNewCardCardQty       = "";
    $tCardShiftNewCardCardStaPrcDoc = "";
    $tCardShiftNewCardStaDelMQ      = "";
    $tCardShiftNewCardCardStaDoc    = "";
    $tRoute                         = "cardShiftNewCardEventAdd";
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
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCardShiftNewCardMainForm" name="ofmAddCardShiftNewCardMainForm">
            <button style="display:none" type="submit" id="obtSubmitCardShiftNewCardMainForm" onclick="JSnCardShiftNewCardAddEditCardShiftNewCard('<?php echo $tRoute; ?>')"></button>


            <input type="hidden" id="ohdCardShiftNewCardLangCode" name="ohdCardShiftNewCardLangCode" value="<?=$nLangEdit; ?>">
            <input type="hidden" id="ohdCardShiftNewCardUsrBchCode" name="ohdCardShiftNewCardUsrBchCode" value="<?=$tUserBchCode; ?>">


            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label><?php echo language('document/card/newcard','tCardShiftNewCardDocumentation');?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvCardShiftNewInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvCardShiftNewInfo" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <label class="xCNLabelFrm"><span style="color:red">*</span> <?php echo language('document/card/newcard','tCardShiftNewCardTBDocNo'); ?></label>
                        <div class="form-group" id="odvCardShiftNewCardAutoGenCode">
                            <div class="">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbCardShiftNewCardAutoGenCode" name="ocbCardShiftNewCardAutoGenCode" checked="true" value="1">
                                    <span class="xCNLabelFrm"><?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group" id="odvCardShiftNewCardDocNoForm">
                            <div class="validate-input">
                                <input
                                    type="text"
                                    class="form-control input100 xCNInputWithoutSpcNotThai"
                                    id="oetCardShiftNewCardCode"
                                    aria-invalid="false"
                                    name="oetCardShiftNewCardCode"
                                    data-is-created="<?php echo $tCardShiftNewCardDocNo; ?>"
                                    placeholder="<?php echo language('document/card/newcard','tCardShiftNewCardTBDocNo'); ?>"
                                    value="<?php echo $tCardShiftNewCardDocNo; ?>"
                                    data-validate="Plese Generate Code">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/card/newcard','tCardShiftNewCardTBDocDate'); ?></label>
                            <div class="input-group">
                                <input
                                    class="form-control input100 xCNDatePicker"
                                    type="text"
                                    name="oetCardShiftNewCardDocDate"
                                    id="oetCardShiftNewCardDocDate"
                                    aria-invalid="false"
                                    value="<?php echo $tCardShiftNewCardDocDate;?>"
                                    data-validate="Please Insert Doc Date"
                                >
                                <span class="input-group-btn">
                                    <button type="button" class="btn xCNBtnDateTime" onclick="$('#oetCardShiftNewCardDocDate').focus()"><img class="xCNIconCalendar"></button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="ohdCardShiftNewCardCardStaPrcDoc" name="ohdCardShiftNewCardCardStaPrcDoc" value="<?php echo $tCardShiftNewCardCardStaPrcDoc; ?>">
                            <input type="hidden" id="ohdCardShiftNewCardCardStaDoc" name="hdCardShiftNewCardCardStaDoc" value="<?php echo $tCardShiftNewCardCardStaDoc; ?>">
                            <input type="hidden" id="ohdCardShiftNewCardStaDelQname" name="ohdCardShiftNewCardStaDelQname" value="<?php echo $tCardShiftNewCardStaDelMQ; ?>">
                            <?php
                            $tDocStatus = "";
                            if(empty($tCardShiftNewCardCardStaPrcDoc) && !empty($tCardShiftNewCardDocNo)){
                                $tDocStatus = language('document/card/newcard','tCardShiftNewCardTBPending');
                            }

                            if($tCardShiftNewCardCardStaPrcDoc == "2" || $tCardShiftNewCardCardStaPrcDoc == "1"){ // Processing or approved
                                if($tCardShiftNewCardCardStaPrcDoc == "2"){
                                    $tDocStatus = language('document/card/newcard','tCardShiftNewCardTBProcessing');
                                }else{
                                    $tDocStatus = language('document/card/newcard','tCardShiftNewCardTBApproved');
                                }
                            }else{
                                // if($tStaDoc == "1"){$tRowType = "xWDocComplete";} // Process to pending
                                if($tCardShiftNewCardCardStaDoc == "2"){$tDocStatus = language('document/card/newcard','tCardShiftNewCardTBIncomplete');}
                                if($tCardShiftNewCardCardStaDoc == "3"){$tDocStatus = language('document/card/newcard','tCardShiftNewCardTBCancel');}
                            }
                            ?>
                            <label class="xCNLabelFrm"><?php echo language('document/card/newcard','tCardShiftNewCardTBDocStatus'); ?> <span><?php echo $tDocStatus; ?></span></label>
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="ohdCardShiftNewCardUsrCode" name="ohdCardShiftNewCardUsrCode" value="<?php echo $tUserCode; ?>">
                            <input type="hidden" id="ohdCardShiftNewCardUserCreatedCode" name="ohdCardShiftNewCardUserCreatedCode" value="<?php if(empty($tUserCreatedCode)){echo $tUserCode;}else{echo $tUserCreatedCode;} ?>">
                            <label class="xCNLabelFrm"><?php echo language('document/card/newcard','tCardShiftNewCardCreator'); ?> <span><?php if(empty($tUserCreatedName)){echo $tUserName;}else{echo $tUserCreatedName;} ?></span></label>
                            <div class="clearfix"></div>
                            <?php if($aResult['rtCode'] == "1") : ?>
                                <input type="hidden" id="ohdCardShiftNewCardApvCode" name="ohdCardShiftNewCardApvCode" value="<?php if(empty($tUserApvCode)){echo $tUserCode;}else{echo $tUserApvCode;} ?>">
                                <label class="xCNLabelFrm"><?php echo language('document/card/newcard','tCardShiftNewCardApprover'); ?>
                                    <span id="ospCardShiftNewCardApvName" class="hidden"><?php if(empty($tUserApvName)){echo $tUserName;}else{echo $tUserApvName;} ?></span>
                                </label>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmSearchCard" name="ofmSearchCard">
            <button style="display:none" type="submit" id="obtSubmitCardShiftNewCardSearchCardForm" onclick="JSxCardShiftNewCardImportFileValidate();"></button>
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label><?php echo language('document/card/newcard','tCardShiftNewCardSelectConditionalInformation');?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvCrardShiftNewFilter" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvCrardShiftNewFilter" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">

                        <!--INPUT : สาขา-->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                            <script>
                                var tUsrLevel = '<?=$this->session->userdata('tSesUsrLevel')?>';
                                if( tUsrLevel != "HQ" ){
                                    var tBchCount = '<?=$this->session->userdata("nSesUsrBchCount");?>';
                                    if(tBchCount < 2){
                                        $('#obtBrowseBCH_CardShiftNewCard').attr('disabled',true);
                                    }
                                }
                            </script>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?= language('document/topupvending/topupvending', 'tBCH'); ?></label>
                                <div class="input-group">
                                    <input name="oetBCHName_CardShiftNewCard" id="oetBCHName_CardShiftNewCard" class="form-control" value="<?=$tUserBchName?>" type="text" readonly="">
                                    <input name="oetBCHCode_CardShiftNewCard" id="oetBCHCode_CardShiftNewCard" value="<?=$tUserBchCode?>" class="form-control xCNHide" type="text">
                                    <span class="input-group-btn">

                                        <?php
                                        if(empty($tCardShiftNewCardCardStaPrcDoc) && $tCardShiftNewCardCardStaDoc != "3"){
                                            $tDisabled_CardShiftNewCard = '';
                                        }else{
                                            $tDisabled_CardShiftNewCard = 'disabled';
                                        }
                                        ?>

                                        <button <?=$tDisabled_CardShiftNewCard?> class="btn xCNBtnBrowseAddOn" id="obtBrowseBCH_CardShiftNewCard" type="button">
                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-10 col-xs-10 no-padding">
                            <div class="form-group">
                                <div class="validate-input" data-validate="Please Insert Name">
                                    <label class="xCNLabelFrm"><?php echo language('document/card/newcard','tCardShiftNewCardCardOut'); ?></label>
                                    <input type="text" class="input100 xWPointerEventNone" id="oetCardShiftNewCardCountNumber" name="oetCardShiftNewCardCountNumber" placeholder="<?php echo language('document/card/newcard','tCardShiftNewCardNumber'); ?>" value="<?php echo $tCardShiftNewCardCardQty; ?>" readonly="true">
                                    <span class="" style="position: absolute; right: -40px; bottom: -6px;"><?php echo language('document/card/newcard','tCardShiftNewCardCardUnit'); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php if(empty($tCardShiftNewCardCardStaPrcDoc) && $tCardShiftNewCardCardStaDoc != "3") : ?>
                        <div class="clearfix"></div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/card/newcard','tCardShiftNewCardDataSource'); ?></label>
                                </div>
                                <div class="form-group">
                                    <div class="fancy-radio">
                                        <label>
                                            <input type="radio" name="orbCardShiftNewCardSourceMode" value="file" onchange="JSxCardShiftNewCardVisibleDataSourceMode(this, event)">
                                            <span><i></i> <?php echo language('document/card/newcard','tCardShiftNewCardFile'); ?></span>
                                        </label>
                                        <label>
                                            <input type="radio" name="orbCardShiftNewCardSourceMode" checked="" value="range" onchange="JSxCardShiftNewCardVisibleDataSourceMode(this, event)">
                                            <span><i></i> <?php echo language('document/card/newcard','tCardShiftNewCardChooseFromDataRanges'); ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="odvCardShiftNewCardFileContainer" class="hidden">
                                <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                    <div class="form-group">
                                        <!--label class="xCNLabelFrm">Input Browse File/Vedio</label-->
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="oetCardShiftNewCardFileTemp" name="oetCardShiftNewCardFileTemp" placeholder="<?php echo language('document/card/newcard','tCardShiftNewCardChooseFile'); ?>" readonly>
                                            <input type="file" class="form-control" style="visibility: hidden; position: absolute;" id="oefCardShiftNewCardImport" name="oefCardShiftNewCardImport" onchange="JSxCardShiftNewCardSetImportFile(this, event)">
                                            <span class="input-group-btn">
                                                <button id="obtFile" type="button" class="btn btn-primary" onclick="$('#oefCardShiftNewCardImport').click()">
                                                    + <?php echo language('document/card/newcard','tSelectFile');?>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <a id="oahCardShiftNewCardDataLoadMask" class="btn xCNBTNDefult xCNBTNDefult1Btn" style="margin-bottom: 20px;" target="_blank" href="<?php echo base_url('application/modules/document/assets/carddocfile/Temp_NewCard.xlsx'); ?>"><?php echo language('document/card/newcard','tCardShiftNewCardDownloadTemplate'); ?></a>
                                </div>
                            </div>
                            <div id="odvCardShiftNewCardRangeContainer">
                                <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                    <div class="custom-tabs-line tabs-line-bottom left-aligned" style="border-bottom:none;">
                                        <div id="odvCardShiftNewCardTabNavAdd" class="row">
                                            <ul class="nav" role="tablist">
                                                <li id="oliTabSingleData" class="active">
                                                    <a class="xCNCardShiftNewCardMenuTabCons xCNMenuTab" role="tab" data-tabname="DTS" data-toggle="tab" data-target="#odvCardShiftNewCardSingleAddCard" aria-expanded="false"><?php echo language('document/card/newcard','tCardShiftNewCardTabAddCard');?></a>
                                                </li>
                                                <li id="oliTabRangeData" class="">
                                                    <a class="xCNCardShiftNewCardMenuTabCons xCNMenuTab" role="tab" data-tabname="DTR" data-toggle="tab" data-target="#odvCardShiftNewCardRangeDataAddCard" aria-expanded="false"><?php echo language('document/card/newcard','tCardShiftNewCardTabAddCardRange');?></a>
                                                </li>
                                            </ul>
                                            <input type="hidden" id='ohdCardShiftNewCardStaSelectTabAdd' value="1">
                                        </div>
                                        <div id="odvCardShiftNewCardTabContentAdd" class="row">
                                            <div class="tab-content">
                                                <div id="odvCardShiftNewCardSingleAddCard" class="tab-pane fade active in">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?php echo language('document/card/newcard','tCardShiftNewCardCardCode'); ?></label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control xCNInputWithoutSpcNotThai" maxlength="30" id="oetSingleAddCardCode" name="oetSingleAddCardCode">
                                                                <span class="input-group-btn">
                                                                    <button id="obtSingleAddCardCode" type="button" class="btn xCNBtnGenCode" onclick="JSxCrdShiftNewCrdGenCardCode()">
                                                                        <i class="fa fa-magic"></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="odvCardShiftNewCardRangeDataAddCard" class="tab-pane fade">
                                                    <div class="col-xl-3 col-md-3 col-lg-3 p-l-0 p-r-0">
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?php echo language('document/card/newcard','tCardShiftNewCardPreFix'); ?></label>
                                                            <input type="text" class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" id="oetRangeDataAddPreFix" name="oetRangeAddPreFix" maxlength="5">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-lg-6 p-r-0">
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?php echo language('document/card/newcard','tCardShiftNewCardCardCodeStart'); ?></label>
                                                            <input type="text" class="form-control xCNInputNumericWithoutDecimal" id="oetRangeDataAddNumberCode" name="oetRangeAddNumberCode" maxlength="13">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-md-3 col-lg-3 p-r-0">
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?php echo language('document/card/newcard','tCardShiftNewCardCardCodeQtyStart'); ?></label>
                                                            <input type="text" class="form-control xCNInputNumericWithoutDecimal" id="oetRangeDataQtyCard" name="oetRangeDataQtyCard" maxlength="3" value="1">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('document/card/newcard','tCardShiftNewCardCardType');?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetCardShiftNewCardCtyCode" name="oetCardShiftNewCardCtyCode" >
                                            <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetCardShiftNewCardCtyName" name="oetCardShiftNewCardCtyName" readonly>
                                            <span class="input-group-btn">
                                                <button id="obtCardShiftNewCardBrowseCty" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img src="<?php echo base_url('/application/modules/common/assets/images/icons/find-24.png'); ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('document/card/newcard','tCardShiftNewCardDepart');?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetCardShiftNewCardDptCode" name="oetCardShiftNewCardDptCode" >
                                            <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetCardShiftNewCardDptName" name="oetCardShiftNewCardDptName" readonly>
                                            <span class="input-group-btn">
                                                <button id="obtCardShiftNewCardBrowseDpt" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img src="<?php echo base_url('/application/modules/common/assets/images/icons/find-24.png'); ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <div id="odvCardShiftNewCardAlert" class="pull-left">
                                    <label class="xWMsgConditonErr xWNotFound hidden"><?php echo language('document/card/newcard','tCardShiftNewCardDataNotFound'); ?></label>
                                    <label class="xWMsgConditonErr xWCheckCondition hidden"><?php echo language('document/card/newcard','tCardShiftNewCardPleaseCheckTheDataImportConditions'); ?></label>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <button type="button" class="btn xCNBTNPrimery xCNBTNPrimery2Btn pull-right" onclick="JSxCardShiftNewCardSetDataSourceFilter()"> <?php echo language('document/card/newcard','tCardShiftNewCardBringDataIntoTheTable'); ?></button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
        <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCardShiftNewCardDataSource">
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
                                                id="oetCardShiftNewCardDataSearch"
                                                name="oetCardShiftNewCardDataSearch"
                                                onkeypress="javascript:if(event.keyCode==13) JSxCardShiftNewCardSearchDataSourceTable()"
                                                placeholder="<?php echo language('common/main/main','tSearch'); ?>">
                                            <span class="input-group-btn">
                                                <button id="obtSearch" type="button" class="btn xCNBtnSearch" onclick="JSxCardShiftNewCardSearchDataSourceTable()">
                                                    <img src="<?php echo base_url('application/modules/common/assets/images/icons/search-24.png'); ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <?php if(/*empty($tCardShiftNewCardCardStaPrcDoc) && $tCardShiftNewCardCardStaDoc != "3"*/ false) : ?>
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-5 no-padding">
                                        <input type="hidden" id="testCode" value="">
                                        <input type="hidden" id="testName" value="">
                                        <button id="obtCardShiftNewCardAddDataSource" class="xCNBTNPrimeryPlus pull-right" type="button" title="<?php echo language('document/card/newcard','tCardShiftNewCardBringDataIntoTheTable'); ?>">+</button>
                                    </div>
                                <?php endif; ?>
                                <div id="odvCardShiftNewCardDataSource"></div>
                                <input type="hidden" id="ohdCardShiftNewCardCardCodeTemp">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="odvCardShiftNewCardModalEmptyCardAlert">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/card/cardrefund', 'tCardShiftNewCardApproveTheDocument'); ?></label>
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

<div class="modal fade" id="odvModalImportFileConfirm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/card/newcard', 'tCardShiftNewCardBringDataIntoTheTable') ?></label>
            </div>
            <div class="modal-body">
                <?php echo language('document/card/newcard', 'tCardShiftNewCardImportFileConfirm'); ?>
            </div>
            <div class="modal-footer">
                <!-- แก้ -->
                <button id="osmConfirm" onClick="" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
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

<div class="modal fade xCNModalApprove" id="odvCardShiftNewCardPopupApv">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/card/newcard', 'tCardShiftNewCardApproveTheDocument'); ?></h5>
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
                <button id="obtCardShiftNewCardPopupApvConfirm" onclick="JSxCardShiftNewCardStaApvDoc(true)" type="button" class="btn xCNBTNPrimery">
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

<div class="modal fade" id="odvCardShiftNewCardPopupStaDoc">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/card/newcard', 'tCardShiftNewCardCancelTheDocument'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p><?php echo language('document/card/newcard', 'tCardShiftNewCardCancelAlert'); ?></p>
                <strong><?php echo language('document/card/newcard', 'tCardShiftNewCardCancelAlert1'); ?></strong>
            </div>

            <div class="modal-footer">
                <button id="obtCardShiftNewCardPopupStaDocConfirm" onclick="JSxCardShiftNewCardStaDoc(true)" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js'); ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js'); ?>"></script>
<script type="text/javascript">
    $('.xCNCardShiftNewCardMenuTabCons').click(function(){
        var tDataTabType    = $(this).data('tabname');
        if(tDataTabType == 'DTR'){
            $('#ohdCardShiftNewCardStaSelectTabAdd').val(2);
        }else{
            $('#ohdCardShiftNewCardStaSelectTabAdd').val(1);
        }
    });

    var nLangEdit = <?php echo $this->session->userdata("tLangEdit"); ?>;
    var tAgenCode = '<?php echo $this->session->userdata('tSesUsrAgnCode'); ?>';

    var tWhereCardTypeByAgenCode = "";
    if(tAgenCode != ''){
        tWhereCardTypeByAgenCode = " AND TFNMCardType.FTAgnCode = '" + tAgenCode + "'";
    }

    var oOptionBrowsCardType  = {
        Title : ['payment/cardtype/cardtype', 'tCTYTitle'],
        Table:{Master:'TFNMCardType', PK:'FTCtyCode'},
        Join :{
            Table: ['TFNMCardType_L'],
            On: ['TFNMCardType_L.FTCtyCode = TFNMCardType.FTCtyCode AND TFNMCardType_L.FNLngID = ' + nLangEdit]
        },
        Where: {
            Condition: [tWhereCardTypeByAgenCode]
        },
        GrideView:{
            ColumnPathLang	: 'payment/cardtype/cardtype',
            ColumnKeyLang	: ['tCTYCode', 'tCTYName'],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal      : 50,
            DataColumns		: ['TFNMCardType.FTCtyCode', 'TFNMCardType_L.FTCtyName'],
            DisabledColumns	:[],
            DataColumnsFormat : ['', ''],
            Perpage			: 100,
            OrderBy			: ['TFNMCardType.FDCreateOn DESC']
            // SourceOrder		: "DESC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetCardShiftNewCardCtyCode", "TFNMCardType.FTCtyCode"],
            Text		: ["oetCardShiftNewCardCtyName", "TFNMCardType_L.FTCtyName"]
        },
        RouteAddNew : 'cardtype',
        BrowseLev : nStaCardShiftNewCardBrowseType,
        // DebugSQL : true
    }

    var oOptionBrowsDepart    = {
        Title : ['authen/department/department','tDPTTitle'],
        Table : {Master:'TCNMUsrDepart', PK:'FTDptCode'},
        Join :{
            Table: ['TCNMUsrDepart_L'],
            On: ['TCNMUsrDepart_L.FTDptCode = TCNMUsrDepart.FTDptCode AND TCNMUsrDepart_L.FNLngID = '+nLangEdit]
        },
        GrideView:{
            ColumnPathLang	: 'authen/department/department',
            ColumnKeyLang	: ['tDPTTBCode', 'tDPTTBName'],
            WidthModal      : 50,
            DataColumns		: ['TCNMUsrDepart.FTDptCode', 'TCNMUsrDepart_L.FTDptName'],
            DisabledColumns	:[],
            DataColumnsFormat : ['', ''],
            Perpage			: 100,
            OrderBy			: ['TCNMUsrDepart.FDCreateOn DESC']
            // SourceOrder		: "DESC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetCardShiftNewCardDptCode", "TCNMUsrDepart.FTDptName"],
            Text		: ["oetCardShiftNewCardDptName", "TCNMUsrDepart_L.FTDptName"]
        },
        RouteAddNew : 'department',
        BrowseLev : nStaCardShiftNewCardBrowseType
    }

    $('#obtCardShiftNewCardBrowseCty').click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxBrowseData('oOptionBrowsCardType');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    $('#obtCardShiftNewCardBrowseDpt').click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxBrowseData('oOptionBrowsDepart');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    function JSxCrdShiftNewCrdGenCardCode(){
        try{
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                $('.xCNOverlay').delay(5).fadeIn();
                var tTableName = 'TFNMCard';
                $.ajax({
                    type: "POST",
                    url: "generateCode_Card",
                    data: { tTableName: tTableName },
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aDataReturn = $.parseJSON(oResult);
                        if (aDataReturn.rtCode == '1') {
                            $('#oetSingleAddCardCode').val(aDataReturn.rtCrdCode);
                            // $('#oetSingleAddCardCode').addClass('xCNDisable');
                            // $('#oetSingleAddCardCode').attr('readonly', true);
                            // $('#obtSingleAddCardCode').attr('disabled', true);
                        }else{
                            $('#oetSingleAddCardCode').val(tData.rtDesc);
                        }
                        $('.xCNOverlay').delay(10).fadeOut();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftNewCardResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        }catch(Err){
            console.log('JSxCrdShiftNewCrdGenCardCode ERR:'+Err);
        }
    }
</script>
<?php include "script/jCardShiftNewCardAdd.php"; ?>
<script src="<?php echo base_url('application\modules\common\assets\src\jFormValidate.js'); ?>"></script>
