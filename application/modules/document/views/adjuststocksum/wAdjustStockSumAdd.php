<?php
if($aDataDocHD['rtCode'] == "1"){

    $tAjhDocNo = $aDataDocHD['raItems']['FTAjhDocNo'];
    $tAjhDocDate = date('Y-m-d', strtotime($aDataDocHD['raItems']['FDAjhDocDate']));
    $tAjhDocTime = date('H:i:s', strtotime($aDataDocHD['raItems']['FDAjhDocDate']));
    $tCreateBy = $aDataDocHD['raItems']['FTCreateBy'];
    $tAjhStaDoc = $aDataDocHD['raItems']['FTAjhStaDoc'];
    $nAjhStaDocAct = $aDataDocHD['raItems']['FNAjhStaDocAct'];
    $tAjhStaApv = $aDataDocHD['raItems']['FTAjhStaApv'];
    $tAjhApvCode = $aDataDocHD['raItems']['FTAjhApvCode'];
    $tAjhStaPrcStk = $aDataDocHD['raItems']['FTAjhStaPrcStk'];
    $tBchCode = $aDataDocHD['raItems']['FTBchCode'];
    $tBchName = $aDataDocHD['raItems']['FTBchName'];
    // $tMchCode = $aDataDocHD['raItems']['FTXthMerCode'];
    // $tMchName = $aDataDocHD['raItems']['FTMerName'];

    // Event Control
    $tRoute = "docSMEventEdit";
    $tAjhApvSeqChk = $aDataDocHD['raItems']['FTAjhApvSeqChk'];
    $tUserBchCode = $aDataDocHD['raItems']['FTAjhBchTo'];
    $tUserBchName = $aDataDocHD['raItems']['FTAjhBchNameTo'];

    $tUserWahCode = $aDataDocHD['raItems']['FTAjhWhTo'];
    $tUserWahName = $aDataDocHD['raItems']['FTAjhWhNameTo'];
    $tXthUsrNameApv = $aDataDocHD['raItems']['FTAjhStaApvName'];

    $tAjhRmk = $aDataDocHD['raItems']['FTAjhRmk'];
    $tRsnCode = $aDataDocHD['raItems']['FTRsnCode'];
    $tRsnName = $aDataDocHD['raItems']['FTRsnName'];

    $tUserCode = $this->session->userdata('tSesUserCode');
    $tUserName = $this->session->userdata('tSesUserName');
}else{
    $tAjhDocNo = "";
    $tAjhDocDate = date('Y-m-d');
    $tAjhDocTime = date('H:i:s');
    $tCreateBy = $this->session->userdata('tSesUsrUsername');
    $tAjhStaDoc = "";
    $nAjhStaDocAct = "99";
    $tAjhStaApv = "";
    $tAjhApvCode = "";
    $tAjhStaPrcStk = "";
    $tBchCode = "";
    $tBchName = "";
    $tMchCode = "";
    $tMchName = "";
    $tAjhRmk = "";
    $tRsnCode = "";
    $tRsnName = "";
    $tAjhApvSeqChk =  1;
    // Event Control
    $tRoute = "docSMEventAdd";


    if($this->session->userdata('tSesUsrLevel') == 'HQ' || $this->session->userdata('tSesUsrLevel') == 'BCH' || $this->session->userdata('tSesUsrLevel') == 'SHP'){
        $tUserWahCode = '';
        $tUserWahName = '';
    }

    $tUserBchCode     = $this->session->userdata('tSesUsrBchCodeDefault');
    $tUserBchName     = $this->session->userdata('tSesUsrBchNameDefault');
    $tUserMchCode     = $this->session->userdata('tSesUsrMerCode');
    $tUserMchName     = $this->session->userdata('tSesUsrMerName');
    $tUserShpCode     = $this->session->userdata('tSesUsrShpCodeDefault');
    $tUserShpName     = $this->session->userdata('tSesUsrShpNameMulti');

    $tUserCode = 'N/A';
    $tUserName = 'N/A';
}

?>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddAdjStkSum">
    <input type="hidden" id="ohdAdjStkSumAjhStaApv" name="ohdAdjStkSumAjhStaApv" value="<?php echo $tAjhStaApv; ?>">
    <input type="hidden" id="ohdAdjStkSumAjhStaDoc" name="ohdAdjStkSumAjhStaDoc" value="<?php echo $tAjhStaDoc; ?>">
    <input type="hidden" id="ohdAdjStkSumAjhStaPrcStk" name="ohdAdjStkSumAjhStaPrcStk" value="<?php echo $tAjhStaPrcStk; ?>">
    <input type="hidden" id="ohdAdjStkSumDptCode" name="ohdAdjStkSumDptCode" maxlength="5" value="<?php ?>">
    <input type="hidden" id="ohdAdjStkSumUsrCode" name="ohdAdjStkSumUsrCode" maxlength="20" value="<?php echo $tUserCode?>">
    <input type="hidden" id="ohdGetOptionDecimalShow" name="ohdGetOptionDecimalShow" value="<?=FCNxHGetOptionDecimalShow();?>" >

    <div id="ohddocSMDocRef" >

    </div>
    <button style="display:none" type="submit" id="obtSubmitAdjStkSum" onclick="JSnAddEditAdjStkSum();"></button>
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/document/document', 'tDocLabel'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvAdjStkSumSubHeadDocPanel" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvAdjStkSumSubHeadDocPanel" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body xCNPDModlue">
                        <div class="form-group xCNHide" style="text-align: right;">
                            <label class="xCNTitleFrom "><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumApproved'); ?></label>
                        </div>
                        <label class="xCNLabelFrm"><span style = "color:red">*</span><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumDocNo'); ?></label>

                        <div class="form-group" id="odvAdjStkSumSubAutoGenDocNoForm">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbAdjStkSumSubAutoGenCode" name="ocbAdjStkSumSubAutoGenCode" checked="true" value="1">
                                    <span> <?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumAutoGenCode'); ?></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group" id="odvAdjStkSumSubDocNoForm">
                            <div class="validate-input">
                                <input
                                    type="text"
                                    class="form-control input100 xCNInputWithoutSpcNotThai"
                                    id="oetAdjStkSumAjhDocNo"
                                    aria-invalid="false"
                                    name="oetAdjStkSumAjhDocNo"
                                    data-is-created="<?php echo $tAjhDocNo; ?>"
                                    data-validate-required="<?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumPlsEnterOrRunDocNo'); ?>"
                                    data-validate-duplicate="<?php echo language('document/adjuststock/adjuststock', 'tASTPlsDocNoDuplicate'); ?>"
                                    placeholder="<?= language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumDocNo') ?>"
                                    value="<?php echo $tAjhDocNo; ?>"
                                    data-validate="Plese Generate Code">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumDocDate'); ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetAdjStkSumAjhDocDate" name="oetAdjStkSumAjhDocDate" value="<?php echo $tAjhDocDate; ?>" data-validate-required="<?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumPlsEnterDocDate'); ?>">
                                <span class="input-group-btn">
                                    <button id="obtAdjStkSumDocDate" type="button" class="btn xCNBtnDateTime" onclick="$('#oetAdjStkSumAjhDocDate').focus()">
                                        <img src="<?php echo base_url('/application/modules/common/assets/images/icons/icons8-Calendar-100.png'); ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumDocTime'); ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNTimePicker" id="oetAdjStkSumAjhDocTime" name="oetAdjStkSumAjhDocTime" value="<?php echo $tAjhDocTime; ?>" data-validate-required="<?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumPlsEnterDocTime'); ?>">
                                <span class="input-group-btn">
                                    <button id="obtAdjStkSumAjhDocTime" type="button" class="btn xCNBtnDateTime" onclick="$('#oetAdjStkSumAjhDocTime').focus()">
                                        <img src="<?php echo base_url('/application/modules/common/assets/images/icons/icons8-Calendar-100.png'); ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="xCNLabelFrm"><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumCreateBy'); ?></label>
                            </div>
                            <div class="col-md-6 text-right">
                                <input type="text" class="xCNHide" id="oetAdjStkSumAjhCreateBy" name="oetAdjStkSumAjhCreateBy" value="<?php echo $tUserCode ?>">
                                <label><?php echo $tUserName; ?></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="xCNLabelFrm"><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumTBStaDoc'); ?></label>
                            </div>
                            <div class="col-md-6 text-right">
                                <label><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumStaDoc' . $tAjhStaDoc); ?></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="xCNLabelFrm"><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumTBStaApv'); ?></label>
                            </div>
                            <div class="col-md-6 text-right">
                                <label><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumStaApv' . $tAjhStaApv); ?></label>
                            </div>
                        </div>

                        <?php if($tAjhDocNo != '') { ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="xCNLabelFrm"><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumApvBy'); ?></label>
                                </div>
                                <div class="col-md-6 text-right">
                                    <input type="text" class="xCNHide" id="oetAdjStkSumAjhApvCode" name="oetAdjStkSumAjhApvCode" maxlength="20" value="<?php echo $tAjhApvCode?>">
                                    <label><?php echo $tXthUsrNameApv != '' ? $tXthUsrNameApv : language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumStaDoc'); ?></label>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/document/document', 'tDocCondition'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvAdjStkSumSubWarehousePanel" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvAdjStkSumSubWarehousePanel" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body xCNPDModlue">
                        <!-- สาขา -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumBranch'); ?></label>
                            <div class="input-group">
                                <input type="hidden" id="ohdAdjStkSumBchCode" name="ohdAdjStkSumBchCode" value="<?php echo $tUserBchCode; ?>">
                                <input class="form-control xCNHide" id="oetAdjStkSumBchCode" name="oetAdjStkSumBchCode" maxlength="5" value="<?php echo $tUserBchCode; ?>">
                                <input
                                    class="form-control xWPointerEventNone"
                                    type="text"
                                    id="oetAdjStkSumBchName"
                                    name="oetAdjStkSumBchName"
                                    value="<?php echo $tUserBchName; ?>"
                                    readonly>
                                <span class="input-group-btn">
                                    <button id="obtAdjStkSumBrowseBch" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo  base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                        <!-- สาขา -->

                        <!-- กลุ่มร้านค้า -->
                        <!-- <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumMerName'); ?></label>
                            <div class="input-group">
                                <input class="form-control xCNHide" id="oetAdjStkSumMchCode" name="oetAdjStkSumMchCode" maxlength="5" value="<?php echo $tUserMchCode; ?>">
                                <input class="form-control xWPointerEventNone" type="text" id="oetAdjStkSumMchName" name="oetAdjStkSumMchName" value="<?php echo $tUserMchName; ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="obtAdjStkSumBrowseMch" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo  base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                    </button>
                                </span>
                            </div>
                        </div> -->
                        <!-- กลุ่มร้านค้า -->

                        <!-- ร้านค้า -->
                        <!-- <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumShop'); ?></label>
                            <div class="input-group">
                                <input type="hidden" id="ohdAdjStkSumWahCodeInShp" name="ohdAdjStkSumWahCodeInShp" value="<?php echo $tUserWahCode; ?>">
                                <input type="hidden" id="ohdAdjStkSumWahNameInShp" name="ohdAdjStkSumWahNameInShp" value="<?php echo $tUserWahName; ?>">
                                <input class="form-control xCNHide" id="oetAdjStkSumShpCode" name="oetAdjStkSumShpCode" maxlength="5" value="">
                                <input class="form-control xWPointerEventNone" type="text" id="oetAdjStkSumShpName" name="oetAdjStkSumShpName" value="" readonly>
                                <span class="input-group-btn">
                                    <button id="obtAdjStkSumBrowseShp" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div> -->
                        <!-- ร้านค้า -->

                        <!-- เครื่องจุดขาย -->
                        <!-- <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumPos'); ?></label>
                            <div class="input-group">
                                <input type="text" class="input100 xCNHide" id="oetAdjStkSumPosCode" name="oetAdjStkSumPosCode" maxlength="5" value="<?php echo $tUserPosCode; ?>">
                                <input class="form-control xWPointerEventNone" type="text" id="oetAdjStkSumPosName" name="oetAdjStkSumPosName" value="<?php echo $tUserPosName; ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="obtAdjStkSumBrowsePos" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div> -->
                        <!-- เครื่องจุดขาย -->



                        <!-- เหตุผล -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumReason'); ?></label>
                            <div class="input-group">
                                <input type="text" class="input100 xCNHide" id="oetAdjStkSumReasonCode" name="oetAdjStkSumReasonCode" maxlength="5" value="<?=$tRsnCode?>">
                                <input class="form-control xWPointerEventNone" type="text" id="oetAdjStkSumReasonName" name="oetAdjStkSumReasonName" value="<?=$tRsnName?>" readonly>
                                <span class="input-group-btn xWConditionSearchPdt">
                                    <button id="obtAdjStkSumBrowseReason" type="button" class="btn xCNBtnBrowseAddOn xWConditionSearchPdt">
                                        <img src="<?php echo base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                        <!-- เหตุผล -->

                        <!-- หมายเหตุ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumNote'); ?></label>
                            <textarea class="form-control xCNInputWithoutSpc" id="otaAdjStkSumAjhRmk" name="otaAdjStkSumAjhRmk" maxlength="200"><?=$tAjhRmk?></textarea>
                        </div>
                        <!-- หมายเหตุ -->

                        <!-- สถานะเคลื่อนไหว-->
                        <div class="form-group">
                            <label class="fancy-checkbox">
                                <input type="checkbox" value="1" id="ocbAdjStkSumStaDocAct" name="ocbAdjStkSumStaDocAct" maxlength ="1"
                                <?php if($nAjhStaDocAct == '1' && $nAjhStaDocAct != 0){
                                    echo 'checked';
                                }else if($nAjhStaDocAct == 99){
                                    echo 'checked';
                                }?>>
                                <span>&nbsp;</span>
                                <span class="xCNLabelFrm"><?= language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumStaDocAct'); ?></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <!-- Right Panel -->
        <div class="col-md-9" id="odvAdjStkSumRightPanal">
            <!-- Pdt -->
            <div class="panel panel-default" style="margin-bottom: 25px;position: relative;min-height: 200px;">
                <div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
                    <div class="panel-body xCNPDModlue">
                        <div class="row" style="margin-top: 10px;">

                        <div class="col-md-12 no-padding">
                        <div class="col-md-4">
                       <!-- คลัง -->
                       <div class="form-group">
                            <div class="input-group">
                                <input type="hidden" id="ohdAdjStkSumWahCode" name="ohdAdjStkSumWahCode" value="<?php echo $tUserWahCode; ?>">
                                <input type="hidden" id="ohdAdjStkSumWahName" name="ohdAdjStkSumWahName" value="<?php echo $tUserWahName; ?>">
                                <input type="text" class="input100 xCNHide" id="oetAdjStkSumWahCode" name="oetAdjStkSumWahCode" maxlength="5" value="<?php echo $tUserWahCode; ?>">
                                <input class="form-control xWPointerEventNone" type="text" id="oetAdjStkSumWahName" name="oetAdjStkSumWahName" placeholder="<?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumWarehouse'); ?>" value="<?php  if(!empty($tUserWahName)){  echo $tUserWahName; }?>" readonly>
                                <span class="input-group-btn">
                                    <button id="obtAdjStkSumBrowseWah" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                        <!-- คลัง -->
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <button id="obtSMLoadDTStkSubToTemp" onclick="JSxDocSMLoadDTStkSubToTemp()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> รวมเอกสารตรวจนับสินค้า</button>
                                    </div>
                                </div>
                        <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="selectpicker form-control" id="ocmAdjStkSumCheckTime" name="ocmAdjStkSumCheckTime" maxlength="1">
                                            <option value="C1"  <?php if($tAjhApvSeqChk==1){ echo 'selected'; } ?>><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumUseDesion1'); ?></option>
                                            <option value="C2" <?php if($tAjhApvSeqChk==2){ echo 'selected'; } ?>><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumUseDesion2'); ?></option>
                                            <option value="" <?php if($tAjhApvSeqChk==3){ echo 'selected'; } ?>><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumUseDesionMy'); ?></option>
                                        </select>
                                    </div>
                                </div>

                        </div>


                            <div class="col-md-12 no-padding">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                class="form-control"
                                                maxlength="100"
                                                id="oetAdjStkSumSearchPdtHTML"
                                                name="oetAdjStkSumSearchPdtHTML"
                                                onchange="JSvAdjStkSumDOCSearchPdtHTML()"
                                                onkeyup="javascript:if(event.keyCode==13) JSvAdjStkSumDOCSearchPdtHTML()"
                                                placeholder="<?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumSearchPdt'); ?>">
                                            <input
                                                type="text"
                                                class="form-control"
                                                maxlength="100"
                                                id="oetAdjStkSumScanPdtHTML"
                                                name="oetAdjStkSumScanPdtHTML"
                                                onkeyup="javascript:if(event.keyCode==13) JSvAdjStkSumScanPdtHTML()"
                                                placeholder="<?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumScanPdt'); ?>"
                                                style="display:none;"
                                                data-validate="ไม่พบข้อมูลที่แสกน">
                                            <span class="input-group-btn">
                                                <div id="odvAdjStkSumMngTableList" class="xCNDropDrownGroup input-group-append">
                                                    <button id="oimAdjStkSumMngPdtIconSearch" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" onclick="JSvAdjStkSumDOCSearchPdtHTML()">
                                                        <img  src="<?php echo base_url('application/modules/common/assets/images/icons/search-24.png'); ?>" style="width:20px;">
                                                    </button>
                                                    <button id="oimAdjStkSumMngPdtIconScan" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" style="display:none;" onclick="JSvAdjStkSumScanPdtHTML()">
                                                        <img class="oimMngPdtIconScan" src="<?php echo base_url('application/modules/common/assets/images/icons/scanner.png'); ?>" style="width:20px;">
                                                    </button>

                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a id="oliAdjStkSumMngPdtSearch"><label><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumSearchPdt'); ?></label></a>
                                                            <a id="oliAdjStkSumMngPdtScan"><?php echo language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumScanPdt'); ?></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </span>
                                        </div>
                                    </div>


                                </div>

                                <div class="col-md-5">
                                    <div class="btn-group xCNDropDrownGroup right">
                                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                                        <?php echo language('common/main/main', 'tCMNOption') ?>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li id="oliAdjStkSumBtnDeleteAll" class="disabled">
                                            <a data-toggle="modal" data-target="#odvModalDelPdtAdjStkSum"><?php echo language('common/main/main', 'tDelAll') ?></a>
                                        </li>
                                    </ul>
                                    </div>
                                    </div>


                            </div>

                            <!-- <div class="col-md-5">
                            </div> -->
                            <!-- <div class="col-md-5">
                                <div class="btn-group xCNDropDrownGroup right">
                                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                                        <?php echo language('common/main/main', 'tCMNOption') ?>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li id="oliAdjStkSumBtnDeleteAll" class="disabled">
                                            <a data-toggle="modal" data-target="#odvModalDelPdtAdjStkSum"><?php echo language('common/main/main', 'tDelAll') ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div> -->

                            <div class="col-md-1">
                                <!-- <div class="form-group">
                                    <div style="position: absolute;right: 15px;top:-5px;">
                                        <button id="obtAdjStkSumDocBrowsePdt" class="xCNBTNPrimeryPlus xCNDocBrowsePdt
                                        <?php
                                        if ($tRoute == "docSMEventAdd") {
                                        ?>
                                            disabled
                                        <?php
                                        } else {
                                            if ($tMchCode != "") {
                                        ?>
                                                disabled
                                        <?php
                                            }
                                        }
                                        ?>" onclick="JCNvAdjStkSumBrowsePdt()" type="button">+</button>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <div id="odvAdjStkSumPdtTablePanal"></div>
                        <!--div id="odvPdtTablePanalDataHide"></div-->
                    </div>
                </div>
            </div>
            <!-- Pdt -->
        </div>
        <!-- Right Panel -->
    </div>
</form>

<div class="modal fade xCNModalApprove" id="odvAdjStkSumPopupApv">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('common/main/main', 'tApproveTheDocument'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo language('common/main/main', 'tMainApproveStatus'); ?></p>
                <ul>
                    <li><?php echo language('common/main/main', 'tMainApproveStatus1'); ?></li>
                    <li><?php echo language('common/main/main', 'tMainApproveStatus2'); ?></li>
                    <li><?php echo language('common/main/main', 'tMainApproveStatus3'); ?></li>
                    <li><?php echo language('common/main/main', 'tMainApproveStatus4'); ?></li>
                </ul>
                <p><?php echo language('common/main/main', 'tMainApproveStatus5'); ?></p>
                <p><strong><?php echo language('common/main/main', 'tMainApproveStatus6'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button onclick="JSnAdjStkSumApprove(true)" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="odvShowOrderColumn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo language('common/main/main', 'tModalAdvTable'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo language('common/main/main', 'tModalAdvClose'); ?></button>
                <button type="button" class="btn btn-primary" onclick="JSxSaveColumnShow()"><?php echo language('common/main/main', 'tModalAdvSave'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalEditAdjStkSumDisHD">
    <div class="modal-dialog xCNDisModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="display:inline-block"><label class="xCNLabelFrm"><?php echo language('common/main/main', 'tAdjStkSumDisEndOfBill'); ?></label></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('common/main/main', 'tAdjStkSumDisType'); ?></label>
                            <select class="selectpicker form-control" id="ostXthHDDisChgText" name="ostXthHDDisChgText">
                                <option value="3"><?php echo language('document/adjuststocksum/adjuststocksum', 'tDisChgTxt3') ?></option>
                                <option value="4"><?php echo language('document/adjuststocksum/adjuststocksum', 'tDisChgTxt4') ?></option>
                                <option value="1"><?php echo language('document/adjuststocksum/adjuststocksum', 'tDisChgTxt1') ?></option>
                                <option value="2"><?php echo language('document/adjuststocksum/adjuststocksum', 'tDisChgTxt2') ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="xCNLabelFrm"><?php echo language('common/main/main', 'tAdjStkSumValue'); ?></label>
                        <input type="text" class="form-control xCNInputNumericWithDecimal" id="oetXddHDDis" name="oetXddHDDis" maxlength="11" placeholder="">
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary xCNBtnAddDis" onclick="FSvAdjStkSumAddHDDis()">
                                <label class="xCNLabelAddDis">+</label>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="odvHDDisListPanal"></div>
                <input type='hidden' id="ohdConfirmIDDelete">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="odvAdjStkSumPopupCancel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard">ยกเลิกเอกสาร</label>
            </div>
            <div class="modal-body">
                <p id="obpMsgApv">เอกสารใบนี้ทำการประมวลผล หรือยกเลิกแล้ว ไม่สามารถแก้ไขได้</p>
                <p><strong>คุณต้องการที่จะยกเลิกเอกสารนี้หรือไม่?</strong></p>
            </div>
            <div class="modal-footer">
                <button onclick="JSnAdjStkSumCancel(true)" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include('script/jAdjustStockSumAdd.php')?>
