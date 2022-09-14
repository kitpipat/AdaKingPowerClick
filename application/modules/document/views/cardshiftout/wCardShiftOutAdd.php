<?php
if($aResult['rtCode'] == "1"){
    $tCardShiftOutDocNo = $aResult['raItems']['rtCardShiftOutDocNo'];
    $tCardShiftOutDocDate = date('Y-m-d', strtotime($aResult['raItems']['rtCardShiftOutDocDate']));
    $tCardShiftOutCardQty = $aResult['raItems']['rtCardShiftOutCardQty'];
    $tCardShiftOutCardStaPrcDoc = $aResult['raItems']['rtCardShiftOutStaPrcDoc'];
    $tCardShiftOutStaDelMQ = $aResult['raItems']['rtCardShiftOutStaDelMQ'];
    $tCardShiftOutCardStaDoc = $aResult['raItems']['rtCardShiftOutStaDoc'];
    $tRoute = "cardShiftOutEventEdit";
}else{
    $tCardShiftOutDocNo = "";
    $tCardShiftOutDocDate = date('Y-m-d');
    $tCardShiftOutCardQty = "";
    $tCardShiftOutCardStaPrcDoc = "";
    $tCardShiftOutStaDelMQ = "";
    $tCardShiftOutCardStaDoc = "";
    $tRoute = "cardShiftOutEventAdd";
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
            <label class="xCNTextDetail1"><?php echo language('document/card/cardout','tCardShiftOutDocumentation'); ?></label>
            <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvCardShiftoutInfo" aria-expanded="true">
                <i class="fa fa-plus xCNPlus"></i>
            </a>
        </div>
        <div id="odvCardShiftoutInfo" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
            <div class="panel-body">
                <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCardShiftOutMainForm" name="ofmAddCardShiftOutMainForm">
                    <button style="display:none" type="submit" id="obtSubmitCardShiftOutMainForm" onclick="JSnCardShiftOutAddEditCardShiftOut('<?php echo $tRoute; ?>')"></button>

                    <input type="hidden" id="ohdCardShiftOutLangCode" name="ohdCardShiftOutLangCode" value="<?=$nLangEdit; ?>">
                    <input type="hidden" id="ohdCardShiftOutUsrBchCode" name="ohdCardShiftOutUsrBchCode" value="<?=$tUserBchCode; ?>">

                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/card/cardout','tCardShiftOutTBDocNo'); ?></label>
                    <div class="form-group" id="odvCardShiftOutAutoGenCode">
                        <div class="">
                            <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbCardShiftOutAutoGenCode" name="ocbCardShiftOutAutoGenCode" checked="true" value="1">
                                <span class="xCNLabelFrm"><?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group" id="odvCardShiftOutDocNoForm">
                        <div class="validate-input">
                            <input
                                type="text"
                                class="form-control input100 xCNInputWithoutSpcNotThai"
                                id="oetCardShiftOutCode"
                                aria-invalid="false"
                                name="oetCardShiftOutCode"
                                data-is-created="<?php echo $tCardShiftOutDocNo; ?>"
                                placeholder="<?php echo language('document/card/cardout','tCardShiftOutTBDocNo'); ?>"
                                value="<?php echo $tCardShiftOutDocNo; ?>"
                                data-validate="Plese Generate Code">
                        </div>
                    </div>

                    <!--วันที่เอกสาร -->
                    <div class="form-group">
                        <div class="validate-input">
                            <label class="xCNLabelFrm"><?php echo language('document/card/cardout','tCardShiftOutTBDocDate'); ?></label>
                            <div class="input-group">
                                <input
                                    class="form-control input100 xCNDatePicker"
                                    type="text"
                                    name="oetCardShiftOutDocDate"
                                    id="oetCardShiftOutDocDate"
                                    aria-invalid="false"
                                    value="<?php echo $tCardShiftOutDocDate; ?>"
                                    data-validate="Please Insert Doc Date">
                                <span class="input-group-btn">
                                    <button id="obtShiftOutDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <script>
                        $('#obtShiftOutDocDate').unbind().click(function(){
                            $('#oetCardShiftOutDocDate').focus()
                        });
                    </script>

                    <div class="form-group">
                        <input type="hidden" id="ohdCardShiftOutCardStaPrcDoc" name="ohdCardShiftOutCardStaPrcDoc" value="<?php echo $tCardShiftOutCardStaPrcDoc; ?>">
                        <input type="hidden" id="ohdCardShiftOutCardStaDoc" name="hdCardShiftOutCardStaDoc" value="<?php echo $tCardShiftOutCardStaDoc; ?>">
                        <input type="hidden" id="ohdCardShiftOutStaDelQname" name="ohdCardShiftOutStaDelQname" value="<?php echo $tCardShiftOutStaDelMQ; ?>">
                        <?php
                        $tDocStatus = "";
                        if(empty($tCardShiftOutCardStaPrcDoc) && !empty($tCardShiftOutDocNo)){
                            $tDocStatus = language('document/card/cardout','tCardShiftOutTBPending');
                        }

                        if($tCardShiftOutCardStaPrcDoc == "2" || $tCardShiftOutCardStaPrcDoc == "1"){ // Processing or approved
                            if($tCardShiftOutCardStaPrcDoc == "2"){
                                $tDocStatus = language('document/card/cardout','tCardShiftOutTBProcessing');
                            }else{
                                $tDocStatus = language('document/card/cardout','tCardShiftOutTBApproved');
                            }
                        }else{
                            // if($tStaDoc == "1"){$tRowType = "xWDocComplete";} // Process to pending
                            if($tCardShiftOutCardStaDoc == "2"){$tDocStatus = language('document/card/cardout','tCardShiftOutTBIncomplete');}
                            if($tCardShiftOutCardStaDoc == "3"){$tDocStatus = language('document/card/cardout','tCardShiftOutTBCancel');}
                        }
                        ?>
                        <label class="xCNLabelFrm"><?php echo language('document/card/cardout','tCardShiftOutTBDocStatus'); ?> <span><?php echo $tDocStatus; ?></span></label>
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="ohdCardShiftOutUsrCode" name="ohdCardShiftOutUsrCode" value="<?php echo $tUserCode; ?>">
                        <input type="hidden" id="ohdCardShiftOutUserCreatedCode" name="ohdCardShiftOutUserCreatedCode" value="<?php if(empty($tUserCreatedCode)){echo $tUserCode;}else{echo $tUserCreatedCode;} ?>">
                        <label class="xCNLabelFrm"><?php echo language('document/card/cardout','tCardShiftOutCreator'); ?> <span><?php if(empty($tUserCreatedName)){echo $tUserName;}else{echo $tUserCreatedName;} ?></span></label>
                        <div class="clearfix"></div>
                        <?php if($aResult['rtCode'] == "1") : ?>
                            <input type="hidden" id="ohdCardShiftOutApvCode" name="ohdCardShiftOutApvCode" value="<?php if(empty($tUserApvCode)){echo $tUserCode;}else{echo $tUserApvCode;} ?>">
                            <label class="xCNLabelFrm"><?php echo language('document/card/cardout','tCardShiftOutApprover'); ?>
                                <span id="ospCardShiftOutApvName" class="hidden"><?php if(empty($tUserApvName)){echo $tUserName;}else{echo $tUserApvName;} ?></span>
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
            <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvCardShiftOutCondition" aria-expanded="true">
                <i class="fa fa-plus xCNPlus"></i>
            </a>
        </div>
        <div id="odvCardShiftOutCondition" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
            <div class="panel-body">
                <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmSearchCard" name="ofmSearchCard">
                    <button style="display:none" type="submit" id="obtSubmitCardShiftOutSearchCardForm" onclick="JSxCardShiftOutImportFileValidate();"></button>
                    <?php
                        if ($this->session->userdata("tSesUsrLevel") != "HQ") {
                            if ($this->session->userdata("nSesUsrBchCount") <= 1) {
                                $tBrowseBchDisabled = 'disabled';
                            } else {
                                $tBrowseBchDisabled = '';
                            }
                        } else {
                            $tBrowseBchDisabled = '';
                        }
                        ?>
                        <!--INPUT : สาขา-->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?= language('document/topupvending/topupvending', 'tBCH'); ?></label>
                                <div class="input-group">
                                    <input name="oetBCHName_CardShiftOutAdd" id="oetBCHName_CardShiftOutAdd" class="form-control" value="<?=$tUserBchName?>" type="text" readonly="">
                                    <input name="oetBCHCode_CardShiftOutAdd" id="oetBCHCode_CardShiftOutAdd" value="<?=$tUserBchCode?>" class="form-control xCNHide" type="text">
                                    <span class="input-group-btn">
                                        <button <?=$tBrowseBchDisabled?> class="btn xCNBtnBrowseAddOn" id="obtBrowseBCH_CardShiftOutAdd" type="button">
                                            <img src="<?= base_url('application/modules/common/assets/images/icons/find-24.png') ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-10 col-xs-10 no-padding">
                            <div class="form-group">
                                <div class="validate-input" data-validate="Please Insert Name">
                                    <label class="xCNLabelFrm"><?php echo language('document/card/main','tDocumentQtyCardSuccess'); ?></label>
                                    <input type="text" class="input100 xWPointerEventNone" id="oetCardShiftOutCountNumber" name="oetCardShiftOutCountNumber" placeholder="<?php echo language('document/card/cardout','tCardShiftOutNumber'); ?>" value="<?php echo $tCardShiftOutCardQty; ?>" readonly="true">
                                    <span class="" style="    position: absolute; right: -40px; bottom: -6px;"><?php echo language('document/card/cardout','tCardShiftOutCardUnit'); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php if(empty($tCardShiftOutCardStaPrcDoc) && $tCardShiftOutCardStaDoc != "3") : ?>
                            <div class="clearfix"></div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/card/cardout','tCardShiftOutDataSource'); ?></label>
                                </div>
                                <div class="form-group">
                                    <div class="fancy-radio">
                                        <label>
                                            <input type="radio" name="orbCardShiftOutSourceMode" value="file" onchange="JSxCardShiftOutVisibleDataSourceMode(this, event)">
                                            <span><i></i> <?php echo language('document/card/cardout','tCardShiftOutFile'); ?></span>
                                        </label>
                                        <label>
                                            <input type="radio" name="orbCardShiftOutSourceMode" checked="" value="range" onchange="JSxCardShiftOutVisibleDataSourceMode(this, event)">
                                            <span><i></i> <?php echo language('document/card/cardout','tCardShiftOutChooseFromDataRanges'); ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="odvCardShiftOutFileContainer" class="hidden">
                                <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                    <div class="form-group">
                                        <!--label class="xCNLabelFrm">Input Browse File/Vedio</label-->
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="oetCardShiftOutFileTemp" name="oetCardShiftOutFileTemp" placeholder="<?php echo language('document/card/cardout','tCardShiftNewCardChooseFile'); ?>" readonly>
                                            <input type="file" class="form-control" style="visibility: hidden; position: absolute;" id="oefCardShiftOutImport" name="oefCardShiftOutImport" onchange="JSxCardShiftOutSetImportFile(this, event)">
                                            <span class="input-group-btn">
                                                <button id="obtFile" type="button" class="btn btn-primary" onclick="$('#oefCardShiftOutImport').click()">
                                                    + <?php echo language('document/card/newcard','tSelectFile');?>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <a id="oahCardShiftOutDataLoadMask" class="btn xCNBTNDefult xCNBTNDefult1Btn" style="margin-bottom: 20px;" target="_blank" href="<?php echo base_url('application/modules/document/assets/carddocfile/Temp_Requisition.xlsx'); ?>"><?php echo language('document/card/cardout','tCardShiftOutDownloadTemplate'); ?></a>
                                </div>
                            </div>

                            <div id="odvCardShiftOutRangeContainer">
                                <div class="col-xl-6 col-lg-6 col-md-6 no-padding"> <!--จากประเภท   -->
                                    <div class="form-group padding-right5">
                                        <label class="xCNLabelFrm"><?php echo language('document/card/cardout','tCardShiftOutFromType');?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetCardShiftOutFromCardTypeCode" name="oetCardShiftOutFromCardTypeCode" >
                                            <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetCardShiftOutFromCardTypeName" name="oetCardShiftOutFromCardTypeName" placeholder="<?php echo language('document/card/cardout','tCardShiftOutFrom'); ?>" readonly="">
                                            <span class="input-group-btn">
                                                <button id="oimCardShiftOutFromCardType" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img src="<?php echo base_url('/application/modules/common/assets/images/icons/find-24.png'); ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 no-padding"> <!--ถึงประเภท -->
                                    <div class="form-group padding-right5">
                                        <label class="xCNLabelFrm"><?php echo language('document/card/cardout','tCardShiftOutToType');?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetCardShiftOutToCardTypeCode" name="oetCardShiftOutToCardTypeCode" >
                                            <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetCardShiftOutToCardTypeName" name="oetCardShiftOutToCardTypeName" placeholder="<?php echo language('document/card/cardout','tCardShiftOutTo'); ?>" readonly="">
                                            <span class="input-group-btn">
                                                <button id="oimCardShiftOutToCardType" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img src="<?php echo base_url('/application/modules/common/assets/images/icons/find-24.png'); ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 no-padding"> <!--จากหมายเลขบัตร -->
                                    <div class="form-group padding-right5">
                                        <label class="xCNLabelFrm"><?php echo language('document/card/cardout','tCardShiftOutFromCardNumber');?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetCardShiftOutFromCardNumberCode" name="oetCardShiftOutFromCardNumberCode" >
                                            <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetCardShiftOutFromCardNumberName" name="oetCardShiftOutFromCardNumberName" placeholder="<?php echo language('document/card/cardout','tCardShiftOutFrom'); ?>" readonly="">
                                            <span class="input-group-btn">
                                                <button id="oimCardShiftOutFromCardNumber" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img src="<?php echo base_url('/application/modules/common/assets/images/icons/find-24.png'); ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 no-padding"> <!--ถึงหมายเลขบัตร -->
                                    <div class="form-group padding-right5">
                                        <label class="xCNLabelFrm"><?php echo language('document/card/cardout','tCardShiftOutToCardNumber');?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetCardShiftOutToCardNumberCode" name="oetCardShiftOutToCardNumberCode" >
                                            <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetCardShiftOutToCardNumberName" name="oetCardShiftOutToCardNumberName" placeholder="<?php echo language('document/card/cardout','tCardShiftOutFrom'); ?>" readonly="">
                                            <span class="input-group-btn">
                                                <button id="oimCardShiftOutToCardNumber" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img src="<?php echo base_url('/application/modules/common/assets/images/icons/find-24.png'); ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <div id="odvCardShiftOutAlert" class="pull-left">
                                    <label class="xWMsgConditonErr xWNotFound hidden"><?php echo language('document/card/cardout','tCardShiftOutDataNotFound'); ?></label>
                                    <label class="xWMsgConditonErr xWCheckCondition hidden"><?php echo language('document/card/cardout','tCardShiftOutPleaseCheckTheDataImportConditions'); ?></label>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 no-padding">
                                <button type="button" class="btn xCNBTNPrimery xCNBTNPrimery2Btn pull-right" onclick="JSxCardShiftOutSetDataSourceFilter()"> <?php echo language('document/card/cardout','tCardShiftOutBringDataIntoTheTable'); ?></button>
                            </div>
                        <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-8 col-lg-8 col-md-8">
    <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCardShiftOutDataSource">
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
                                    id="oetCardShiftOutDataSearch"
                                    name="oetCardShiftOutDataSearch"
                                    onkeypress="javascript:if(event.keyCode==13) JSxCardShiftOutSearchDataSourceTable()"
                                    onkeyup="//JSxCardShiftOutSearchDataSourceTable()"
                                    placeholder="<?=language('common/main/main','tSearch'); ?>">
                                <span class="input-group-btn">
                                    <button id="obtSearch" type="button" class="btn xCNBtnSearch" onclick="JSxCardShiftOutSearchDataSourceTable()">
                                        <img src="<?=base_url('application/modules/common/assets/images/icons/search-24.png'); ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!--ยิงสแกนเนอร์ และเพิ่มข้อมูล-->
                    <?php if(empty($tCardShiftOutCardStaPrcDoc) && $tCardShiftOutCardStaDoc != "3") : ?>
                        <div class="col-xl-4 col-lg-4 col-md-2 col-sm-4 col-xs-0" ></div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-4 col-xs-12" >
                            <div class="row">
                                <div class="col-xl-10 col-lg-10 col-md-9 col-sm-10 col-xs-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="oetCardShiftOutDataScannerID"
                                                name="oetCardShiftOutDataScannerID"
                                                maxlength="50"
                                                placeholder="<?=language('common/main/main','tFilterCardScanner'); ?>"
                                                onkeypress="Javascript:if(event.keyCode==13) JSxCardShiftOutScanner(event,this);" >
                                            <span class="input-group-btn">
                                                <button id="obtSearchID" type="button" class="btn xCNBtnSearch" onclick="JSxCardShiftOutScanner()">
                                                    <img src="<?=base_url('application/modules/common/assets/images/icons/scanner.png'); ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-2 col-xs-12">
                                    <input type="hidden" id="testCode" value="">
                                    <input type="hidden" id="testName" value="">
                                    <button id="obtCardShiftOutAddDataSource" class="xCNBTNPrimeryPlus pull-right" type="button" title="<?php echo language('document/card/cardout','tCardShiftOutBringDataIntoTheTable'); ?>">+</button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div id="odvCardShiftOutDataSource"></div>
                <input type="hidden" id="ohdCardShiftOutCardCodeTemp">
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="odvCardShiftOutModalEmptyCardAlert">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/card/cardout', 'tCardShiftOutApproveTheDocument'); ?></label>
            </div>
            <div class="modal-body">
                <?php echo language('document/card/cardout', 'tCardShiftEmptyRecordAlert'); ?>
            </div>
            <div class="modal-footer">
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="odvCardShiftOutModalImportFileConfirm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/card/cardout', 'tCardShiftOutBringDataIntoTheTable') ?></label>
            </div>
            <div class="modal-body">
                <?php echo language('document/card/cardout', 'tCardShiftOutImportFileConfirm'); ?>
            </div>
            <div class="modal-footer">
                <!-- แก้ -->
                <button id="osmCardShiftOutBtnImportFileConfirm" onClick="" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
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

<div class="modal fade xCNModalApprove" id="odvCardShiftOutPopupApv">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/card/cardout', 'tCardShiftOutApproveTheDocument'); ?></h5>
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
                <button id="obtCardShiftOutPopupApvConfirm" onclick="JSxCardShiftOutStaApvDoc(true)" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="odvCardShiftOutPopupStaDoc">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/card/cardout', 'tCardShiftOutCancelTheDocument'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo language('document/card/newcard', 'tCardShiftNewCardCancelAlert'); ?></p>
                <strong><?php echo language('document/card/newcard', 'tCardShiftNewCardCancelAlert1'); ?></strong>
            </div>
            <div class="modal-footer">
                <button id="obtCardShiftOutPopupStaDocConfirm" onclick="JSxCardShiftOutStaDoc(true)" type="button" class="btn xCNBTNPrimery">
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
<?php include "script/jCardShiftOutAdd.php"; ?>
