<?php
if($aResult['rtCode'] == "1"){
    $tAjhDocNo           = $aResult['raItems']['FTAjhDocNo'];
    $tAjhDocDate         = date('Y-m-d', strtotime($aResult['raItems']['FDAjhDocDate']));
    $tAjhDocTime         = date('H:i:s', strtotime($aResult['raItems']['FDAjhDocDate']));
    $tCreateBy           = $aResult['raItems']['FTCreateBy'];
    $tAjhStaDoc          = $aResult['raItems']['FTAjhStaDoc'];
    $nAjhStaDocAct       = $aResult['raItems']['FNAjhStaDocAct'];
    $tAjhStaApv          = $aResult['raItems']['FTAjhStaApv'];
    $tAjhApvCode         = $aResult['raItems']['FTAjhApvCode'];
    $tAjhApvName         = $aResult['raItems']['FTAjhApvName'];
    $tAjhStaPrcStk       = $aResult['raItems']['FTAjhStaPrcStk'];
    $tBchCode            = $aResult['raItems']['FTBchCode'];
    $tBchName            = $aResult['raItems']['FTBchName'];
    $tUserDptCode        = $aResult['raItems']['FTDptCode'];
    $tUserCode           = $aResult['raItems']['FTCreateBy'];
    $tUserName           = $aResult['raItems']['FTCreateByName'];
    $tRsnCode            = $aResult['raItems']['FTRsnCode'];
    $tRsnName            = $aResult['raItems']['FTRsnName'];
    $tAjhRmk             = $aResult['raItems']['FTAjhRmk'];
    $tUserMchCode        = '';
    $tUserMchName        = '';
    $tUserShpCode        = '';
    $tUserShpName        = '';
    $tUserPosCode        = '';
    $tUserPosName        = '';
    $tRoute              = "adjStkSubEventEdit";
    $tAjhBchCodeTo       = $aResult['raItems']['FTAjhBchTo'];
    $tAjhBchNameTo       = $aResult['raItems']['FTAjhBchNameTo'];
    $tAjhWahCodeTo       = $aResult['raItems']['FTAjhWhTo'];
    $tAjhWahNameTo       = $aResult['raItems']['FTAjhWhNameTo'];
}else{
    $tAjhDocNo          = "";
    $tAjhDocDate        = date('Y-m-d');
    $tAjhDocTime        = date('H:i:s');
    $tCreateBy          = $this->session->userdata('tSesUsrUsername');
    $tAjhStaDoc         = "";
    $nAjhStaDocAct      = "99";
    $tAjhStaApv         = "";
    $tAjhApvCode        = "";
    $tAjhApvName        = "";
    $tAjhStaPrcStk      = "";
    $tBchCode           = $this->session->userdata("tSesUsrBchCodeDefault");
    $tBchName           = $this->session->userdata("tSesUsrBchNameDefault");
    $tUserDptCode       = $this->session->userdata("tSesUsrDptCode");
    $tUserCode          = $this->session->userdata("tSesUserCode");
    $tUserName          = $this->session->userdata("tSesUsername");
    $tRsnCode           = "";
    $tRsnName           = "";
    $tAjhRmk            = "";
    $tRoute             = "adjStkSubEventAdd";
    $tAjhBchCodeTo      = $this->session->userdata("tSesUsrBchCodeDefault");
    $tAjhBchNameTo      = $this->session->userdata("tSesUsrBchNameDefault");
    $tUserMchCode       = '';
    $tUserMchName       = '';
    $tUserShpCode       = '';
    $tUserShpName       = '';
    $tUserPosCode       = '';
    $tUserPosName       = '';
    $tAjhWahCodeTo      = $this->session->userdata("tSesUsrWahCode");
    $tAjhWahNameTo      = $this->session->userdata("tSesUsrWahName");
}

$tUserLevel   = $this->session->userdata('tSesUsrLevel');

?>
<form id="ofmAddAdjStkSub">
    <input type="hidden" id="ohdBaseUrl" name="ohdBaseUrl" value="<?php echo base_url(); ?>">
    <input type="hidden" id="ohdAdjStkSubUsrLevel" name="ohdAdjStkSubUsrLevel" value="<?php echo $tUserLevel; ?>">
    <input type="hidden" id="ohdAdjStkSubAjhStaApv" name="ohdAdjStkSubAjhStaApv" value="<?php echo $tAjhStaApv; ?>">
    <input type="hidden" id="ohdAdjStkSubAjhStaDoc" name="ohdAdjStkSubAjhStaDoc" value="<?php echo $tAjhStaDoc; ?>">
    <input type="hidden" id="ohdAdjStkSubAjhStaPrcStk" name="ohdAdjStkSubAjhStaPrcStk" value="<?php echo $tAjhStaPrcStk; ?>">
    <input type="hidden" id="ohdAdjStkSubDptCode" name="ohdAdjStkSubDptCode" maxlength="5" value="<?php echo $tUserDptCode;?>">
    <!-- <input type="hidden" id="ohdAdjStkSubUsrCode" name="ohdAdjStkSubUsrCode" maxlength="20" value="<?php echo $tUserCode?>"> -->
    <button style="display:none" type="submit" id="obtSubmitAdjStkSub" onclick="JSnAddEditAdjStkSub();"></button>
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/document/document', 'tDocLabel'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvAdjStkSubSubHeadDocPanel" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvAdjStkSubSubHeadDocPanel" class="panel-collapse collapse" role="tabpanel">
                    <div class="panel-body xCNPDModlue">
                        <div class="form-group xCNHide" style="text-align: right;">
                            <label class="xCNTitleFrom "><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubApproved'); ?></label>
                        </div>
                        <label class="xCNLabelFrm"><span style = "color:red">*</span><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubDocNo'); ?></label>

                        <div class="form-group" id="odvAdjStkSubSubAutoGenDocNoForm">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbAdjStkSubSubAutoGenCode" name="ocbAdjStkSubSubAutoGenCode" checked="true" value="1">
                                    <span> <?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubAutoGenCode'); ?></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group" id="odvAdjStkSubSubDocNoForm">
                            <div class="validate-input">
                                <input
                                    type="text"
                                    class="form-control input100 xCNInputWithoutSpcNotThai"
                                    id="oetAdjStkSubAjhDocNo"
                                    aria-invalid="false"
                                    name="oetAdjStkSubAjhDocNo"
                                    data-validate-required="<?= language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubPlsEnterOrRunDocNo') ?>"
                                    data-validate-dublicateCode="<?= language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubMsgDuplicate') ?>"
                                    data-is-created="<?php echo $tAjhDocNo; ?>"
                                    placeholder="<?= language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubDocNo') ?>"
                                    value="<?php echo $tAjhDocNo; ?>"
                                    data-validate="Plese Generate Code">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubDocDate'); ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNDatePicker xCNInputMaskDate xWASTDisabledOnApv" id="oetAdjStkSubAjhDocDate" name="oetAdjStkSubAjhDocDate" value="<?php echo $tAjhDocDate; ?>" data-validate-required="<?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubPlsEnterDocDate'); ?>">
                                <span class="input-group-btn">
                                    <button id="obtAdjStkSubDocDate" type="button" class="btn xCNBtnDateTime xWASTDisabledOnApv" onclick="$('#oetAdjStkSubAjhDocDate').focus()">
                                        <img src="<?php echo base_url('/application/modules/common/assets/images/icons/icons8-Calendar-100.png'); ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubDocTime'); ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNTimePicker xWASTDisabledOnApv" id="oetAdjStkSubAjhDocTime" name="oetAdjStkSubAjhDocTime" value="<?php echo $tAjhDocTime; ?>" data-validate-required="<?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubPlsEnterDocTime'); ?>">
                                <span class="input-group-btn">
                                    <button id="obtAdjStkSubAjhDocTime" type="button" class="btn xCNBtnDateTime xWASTDisabledOnApv" onclick="$('#oetAdjStkSubAjhDocTime').focus()">
                                        <img src="<?php echo base_url('/application/modules/common/assets/images/icons/icons8-Calendar-100.png'); ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubCreateBy'); ?></label>
                            </div>
                            <div class="col-md-6 text-right">
                                <input type="text" class="xCNHide" id="oetAdjStkSubAjhCreateBy" name="oetAdjStkSubAjhCreateBy" value="<?php echo $tUserCode ?>">
                                <label><?php echo $tUserName; ?></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubTBStaDoc'); ?></label>
                            </div>
                            <div class="col-md-6 text-right">
                                <label><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubStaDoc' . $tAjhStaDoc); ?></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubTBStaApv'); ?></label>
                            </div>
                            <div class="col-md-6 text-right">
                                <label><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubStaApv' . $tAjhStaApv); ?></label>
                            </div>
                        </div>

                        <?php if($tAjhDocNo != '') { ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubApvBy'); ?></label>
                                </div>
                                <div class="col-md-6 text-right">
                                    <input type="text" class="xCNHide" id="oetAdjStkSubAjhApvCode" name="oetAdjStkSubAjhApvCode" maxlength="20" value="<?php echo $tAjhApvCode?>">
                                    <label><?php echo $tAjhApvName != '' ? $tAjhApvName : language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubStaDoc'); ?></label>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/document/document', 'tDocCondition'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvAdjStkSubSubWarehousePanel" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvAdjStkSubSubWarehousePanel" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body xCNPDModlue">
                        <!-- สาขา -->
                        <?php
                            if($tRoute == "adjStkSubEventAdd"){
                                $tDisabledBch = '';
                            }else{
                                $tDisabledBch = 'disabled';
                            }
                        ?>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubBranch'); ?></label>
                            <div class="input-group">
                                <input type="hidden" id="ohdAdjStkSubBchCodeCreate" name="ohdAdjStkSubBchCodeCreate" value="<?php echo $tBchCode; ?>">
                                <input class="form-control xCNHide" id="ohdAdjStkSubBchCodeTo" name="ohdAdjStkSubBchCodeTo" maxlength="5" value="<?php echo $tAjhBchCodeTo; ?>">
                                <input
                                    class="form-control xWPointerEventNone"
                                    type="text"
                                    id="ohdAdjStkSubBchNameTo"
                                    name="ohdAdjStkSubBchNameTo"
                                    value="<?php echo $tAjhBchNameTo; ?>"
                                    readonly
                                    data-validate-required="<?php echo language('document/adjuststocksub/adjuststocksub', 'tASTPlsEnterBchCode'); ?>"
                                >
                                <span class="input-group-btn">
                                    <button id="obtAdjStkSubBrowseBchTo" type="button" class="btn xCNBtnBrowseAddOn" <?=$tDisabledBch?>>
                                        <img src="<?php echo  base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                        <!-- สาขา -->

                        <!-- กลุ่มร้านค้า -->
                        <div class="form-group" style="display:none;">
                            <label class="xCNLabelFrm">กลุ่มร้านค้า</label>
                            <div class="input-group">
                                <input class="form-control xCNHide" id="oetAdjStkSubMchCode" name="oetAdjStkSubMchCode" value="<?php echo $tUserMchCode; ?>">
                                <input class="form-control xWPointerEventNone" type="text" id="oetAdjStkSubMchName" name="oetAdjStkSubMchName" value="<?php echo $tUserMchName; ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="obtAdjStkSubBrowseMch" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo  base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                        <!-- กลุ่มร้านค้า -->

                        <!-- ร้านค้า -->
                        <div class="form-group" style="display:none;">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubShop'); ?></label>
                            <div class="input-group">
                                <!-- <input type="hidden" id="ohdAdjStkSubWahCodeInShp" name="ohdAdjStkSubWahCodeInShp" value="<?php echo $tUserWahCode; ?>">
                                <input type="hidden" id="ohdAdjStkSubWahNameInShp" name="ohdAdjStkSubWahNameInShp" value="<?php echo $tUserWahName; ?>"> -->
                                <input class="form-control xCNHide" id="oetAdjStkSubShpCode" name="oetAdjStkSubShpCode" value="<?php echo $tUserShpCode; ?>">
                                <input class="form-control xWPointerEventNone" type="text" id="oetAdjStkSubShpName" name="oetAdjStkSubShpName" value="<?php echo $tUserShpName; ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="obtAdjStkSubBrowseShp" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                        <!-- ร้านค้า -->

                        <!-- เครื่องจุดขาย -->
                        <div class="form-group" style="display:none;">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubPos'); ?></label>
                            <div class="input-group">
                                <input type="text" class="input100 xCNHide" id="oetAdjStkSubPosCode" name="oetAdjStkSubPosCode" value="<?php echo $tUserPosCode; ?>">
                                <input class="form-control xWPointerEventNone" type="text" id="oetAdjStkSubPosName" name="oetAdjStkSubPosName" value="<?php echo $tUserPosName; ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="obtAdjStkSubBrowsePos" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                        <!-- เครื่องจุดขาย -->

                        <!-- ที่เก็บ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'ที่เก็บ'); ?></label>
                            <div class="xCNCheckBoxList">
                                <?php
                                    if($aLocationList['tCode'] == '1'){
                                        $nChkFirstRow = 1;
                                        foreach($aLocationList['aResult'] as $aValueLoc){
                                            // echo gettype($aValueLoc['FTPlcStaActive']);
                                ?>
                                            <div class="form-check">
                                                <input name="ocbAdjStkSubPlcCode[]" class="form-check-input xWASTCheckBoxLocation xWASTDisabledOnApv" type="checkbox" <?php if(isset($aValueLoc['FTPlcStaActive']) && $aValueLoc['FTPlcStaActive'] == '1'){ echo 'checked'; } ?> value="<?php echo $aValueLoc['FTPlcCode']; ?>" id="ocbAdjStkSubPlcCode<?php echo $aValueLoc['FTPlcCode']; ?>">
                                                <label class="form-check-label" for="ocbAdjStkSubPlcCode<?php echo $aValueLoc['FTPlcCode']; ?>"><?php echo $aValueLoc['FTPlcName']; ?></label>
                                            </div>
                                <?php
                                            $nChkFirstRow++;
                                        }
                                    }else{
                                        echo "ไม่พบที่เก็บ";
                                    }
                                ?>

                            </div>

                        </div>
                        <!-- ที่เก็บ -->

                        <!-- เหตุผล -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubReason'); ?></label>
                            <div class="input-group">
                                <input type="text" class="input100 xCNHide" id="oetAdjStkSubReasonCode" name="oetAdjStkSubReasonCode" value="<?php echo $tRsnCode; ?>">
                                <input class="form-control xWPointerEventNone" type="text" id="oetAdjStkSubReasonName" name="oetAdjStkSubReasonName" value="<?php echo $tRsnName; ?>" readonly data-validate-required="<?php echo language('document/adjuststocksub/adjuststocksub', 'tASTPlsEnterRsnCode'); ?>">
                                <span class="input-group-btn xWConditionSearchPdt">
                                    <button id="obtAdjStkSubBrowseReason" type="button" class="btn xCNBtnBrowseAddOn xWConditionSearchPdt">
                                        <img src="<?php echo base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                        <!-- เหตุผล -->

                        <!-- หมายเหตุ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubNote'); ?></label>
                            <textarea class="form-control xWASTDisabledOnApv" id="otaAdjStkSubAjhRmk" name="otaAdjStkSubAjhRmk" maxlength="200"><?=$tAjhRmk;?></textarea>
                        </div>
                        <!-- หมายเหตุ -->

                        <!-- สถานะเคลื่อนไหว-->
                        <div class="form-group">
                            <label class="fancy-checkbox">
                                <input type="checkbox" value="1" id="ocbAdjStkSubStaDocAct" name="ocbAdjStkSubStaDocAct" mexlength="1"
                                    <?php if($nAjhStaDocAct == '1' && $nAjhStaDocAct != 0){
                                        echo 'checked';
                                    } else if($nAjhStaDocAct == 99){
                                        echo 'checked';
                                    }?>>
                                <span>&nbsp;</span>
                                <span class="xCNLabelFrm"><?= language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubStaDocAct'); ?></span>
                            <label>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <!-- Right Panel -->
        <div class="col-md-9" id="odvAdjStkSubRightPanal">
            <!-- Pdt -->
            <div class="panel panel-default" style="margin-bottom: 25px;position: relative;min-height: 200px;">
                <!-- <div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition"> -->
                    <div class="panel-body xCNPDModlue">
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <!-- คลัง -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubWarehouse'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="input100 xCNHide" id="oetAdjStkSubWahCodeTo" name="oetAdjStkSubWahCodeTo" value="<?php echo $tAjhWahCodeTo; ?>">
                                        <input class="form-control xWPointerEventNone" type="text" id="oetAdjStkSubWahNameTo" name="oetAdjStkSubWahNameTo" value="<?php echo $tAjhWahNameTo; ?>" readonly data-validate-required="<?php echo language('document/adjuststocksub/adjuststocksub', 'tASTPlsEnterWahCode'); ?>">
                                        <span class="input-group-btn">
                                            <button id="obtAdjStkSubBrowseWah" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img src="<?php echo base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- คลัง -->
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-6 no-padding">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                class="form-control"
                                                maxlength="100"
                                                id="oetAdjStkSubSearchPdtHTML"
                                                name="oetAdjStkSubSearchPdtHTML"
                                                onchange="JSvAdjStkSubLoadPdtDataTableHtml()"
                                                onkeyup="javascript:if(event.keyCode==13) JSvAdjStkSubLoadPdtDataTableHtml()"
                                                placeholder="<?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubSearchPdt'); ?>">
                                            <input
                                                type="text"
                                                class="form-control"
                                                maxlength="100"
                                                id="oetAdjStkSubScanPdtHTML"
                                                name="oetAdjStkSubScanPdtHTML"
                                                onkeyup="javascript:if(event.keyCode==13) JSvAdjStkSubScanPdtHTML()"
                                                placeholder="<?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubScanPdt'); ?>"
                                                style="display:none;"
                                                data-validate="ไม่พบข้อมูลที่แสกน">
                                            <span class="input-group-btn">
                                                <div id="odvAdjStkSubMngTableList" class="xCNDropDrownGroup input-group-append">
                                                    <button id="oimAdjStkSubMngPdtIconSearch" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" onclick="JSvAdjStkSubLoadPdtDataTableHtml()">
                                                        <img  src="<?php echo base_url('application/modules/common/assets/images/icons/search-24.png'); ?>" style="width:20px;">
                                                    </button>
                                                    <!-- <button id="oimAdjStkSubMngPdtIconScan" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" style="display:none;" onclick="JSvAdjStkSubScanPdtHTML()">
                                                        <img class="oimMngPdtIconScan" src="<?php echo base_url('application/modules/common/assets/images/icons/scanner.png'); ?>" style="width:20px;">
                                                    </button>
                                                    <button type="button" class="btn xCNDocDrpDwn xCNBtnDocSchAndScan" data-toggle="dropdown">
                                                        <i class="fa fa-chevron-down f-s-14 t-plus-1" style="font-size: 12px;"></i>
                                                    </button> -->
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a id="oliAdjStkSubMngPdtSearch"><label><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubSearchPdt'); ?></label></a>
                                                            <a id="oliAdjStkSubMngPdtScan"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubScanPdt'); ?></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="right">
                                    <div class="btn-group xCNDropDrownGroup">
                                        <button type="button" class="btn xCNBTNMngTable xWASTDisabledOnApv" data-toggle="dropdown">
                                            <?php echo language('common/main/main', 'tCMNOption') ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li id="oliAdjStkSubBtnDeleteAll" class="disabled">
                                                <a data-toggle="modal" data-target="#odvModalDelPdtAdjStkSub"><?php echo language('common/main/main', 'tDelAll') ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="btn-group">
                                        <button id="obtAdjStkSubFilterDataCondition" type="button" class="btn btn-primary xWASTDisabledOnApv" style="font-size: 16px;">กรองข้อมูลตามเงื่อนไข</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="odvAdjStkSubPdtTablePanal"></div>
                        <!--div id="odvPdtTablePanalDataHide"></div-->
                    </div>
                <!-- </div> -->
            </div>
            <!-- Pdt -->
        </div>
        <!-- Right Panel -->
    </div>
</form>

<div class="modal fade xCNModalApprove" id="odvAdjStkSubPopupApv">
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
                <button onclick="JSnAdjStkSubApprove(true)" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Alert Date/Time in Product Not has -->
<div class="modal fade" id="odvASTModalAlertDateTime">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block">แจ้งเตือน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn xCNBTNPrimery xWASTModalConfirmAlertDateTime">
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

<div class="modal fade" id="odvAdjStkSubPopupCancel">
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
                <button onclick="JSnAdjStkSubCancel(true)" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="odvAdjStkSubFilterDataCondition">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead"><label class="xCNTextModalHeard"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubFilterTitle'); ?></label></div>
            <div class="modal-body" style="height: 450px;overflow-y: auto;">

                <form id="ofmASTFilterDataCondition">

                    <div class="xCNTabCondition">
                        <label class="xCNTabConditionHeader xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tASTFilterTitleProduct'); ?></label>
                        <!-- Browse Pdt -->
                        <div class="row">
                            <div class="col-md-6">
                                <!-- จากรหัสสินค้า -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubFilterCodeFrom'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="input100 xCNHide" id="oetASTFilterPdtCodeFrom" name="oetASTFilterPdtCodeFrom" value="">
                                        <input class="form-control xWPointerEventNone" type="text" id="oetASTFilterPdtNameFrom" name="oetASTFilterPdtNameFrom" value="" readonly="">
                                        <span class="input-group-btn xWConditionSearchPdt">
                                            <button id="obtASTBrowseFilterProductFrom" type="button" class="btn xCNBtnBrowseAddOn xWConditionSearchPdt">
                                                <img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- จากรหัสสินค้า -->
                            </div>
                            <div class="col-md-6">
                                <!-- ถึงรหัสสินค้า -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubFilterCodeTo'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="input100 xCNHide" id="oetASTFilterPdtCodeTo" name="oetASTFilterPdtCodeTo" value="">
                                        <input class="form-control xWPointerEventNone" type="text" id="oetASTFilterPdtNameTo" name="oetASTFilterPdtNameTo" value="" readonly="">
                                        <span class="input-group-btn xWConditionSearchPdt">
                                            <button id="obtASTBrowseFilterProductTo" type="button" class="btn xCNBtnBrowseAddOn xWConditionSearchPdt">
                                                <img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- ถึงรหัสสินค้า -->
                            </div>
                        </div>
                        <!-- Browse Pdt -->
                    </div>

                    <div class="xCNTabCondition">
                        <label class="xCNTabConditionHeader xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tASTFilterTitleSpl'); ?></label>
                        <!-- Browse Supplier -->
                        <div class="row">
                            <div class="col-md-6">
                                <!-- จากรหัส -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubFilterCodeFrom'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="input100 xCNHide" id="oetASTFilterSplCodeFrom" name="oetASTFilterSplCodeFrom" value="">
                                        <input class="form-control xWPointerEventNone" type="text" id="oetASTFilterSplNameFrom" name="oetASTFilterSplNameFrom" value="" readonly="">
                                        <span class="input-group-btn xWConditionSearchPdt">
                                            <button id="obtASTBrowseFilterSupplierFrom" type="button" class="btn xCNBtnBrowseAddOn xWConditionSearchPdt">
                                                <img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- จากรหัส -->
                            </div>
                            <div class="col-md-6">
                                <!-- ถึงรหัส -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubFilterCodeTo'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="input100 xCNHide" id="oetASTFilterSplCodeTo" name="oetASTFilterSplCodeTo" value="">
                                        <input class="form-control xWPointerEventNone" type="text" id="oetASTFilterSplNameTo" name="oetASTFilterSplNameTo" value="" readonly="">
                                        <span class="input-group-btn xWConditionSearchPdt">
                                            <button id="obtASTBrowseFilterSupplierTo" type="button" class="btn xCNBtnBrowseAddOn xWConditionSearchPdt">
                                                <img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- ถึงรหัส -->
                            </div>
                        </div>
                        <!-- Browse Supplier -->
                    </div>

                    <div class="xCNTabCondition" style="display:none;">
                        <label class="xCNTabConditionHeader xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tASTFilterTitleUserPI'); ?></label>
                        <!-- Browse User -->
                        <div class="row">
                            <div class="col-md-6">
                                <!-- จากรหัส -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubFilterCodeFrom'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="input100 xCNHide" id="oetASTFilterUsrCodeFrom" name="oetASTFilterUsrCodeFrom" value="">
                                        <input class="form-control xWPointerEventNone" type="text" id="oetASTFilterUsrNameFrom" name="oetASTFilterUsrNameFrom" value="" readonly="">
                                        <span class="input-group-btn xWConditionSearchPdt">
                                            <button id="obtASTBrowseFilterUserFrom" type="button" class="btn xCNBtnBrowseAddOn xWConditionSearchPdt">
                                                <img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- จากรหัส -->
                            </div>
                            <div class="col-md-6">
                                <!-- ถึงรหัส -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubFilterCodeTo'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="input100 xCNHide" id="oetASTFilterUsrCodeTo" name="oetASTFilterUsrCodeTo" value="">
                                        <input class="form-control xWPointerEventNone" type="text" id="oetASTFilterUsrNameTo" name="oetASTFilterUsrNameTo" value="" readonly="">
                                        <span class="input-group-btn xWConditionSearchPdt">
                                            <button id="obtASTBrowseFilterUserTo" type="button" class="btn xCNBtnBrowseAddOn xWConditionSearchPdt">
                                                <img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- ถึงรหัส -->
                            </div>
                        </div>
                        <!-- Browse User -->
                    </div>

                    <div class="xCNTabCondition">
                        <label class="xCNTabConditionHeader xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tASTFilterTitlePdtGroup'); ?></label>
                        <!-- Browse Product Group -->
                        <div class="row">
                            <div class="col-md-6">
                                <!-- จากรหัส -->
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="input100 xCNHide" id="oetASTFilterPgpCode" name="oetASTFilterPgpCode" value="">
                                        <input class="form-control xWPointerEventNone" type="text" id="oetASTFilterPgpName" name="oetASTFilterPgpName" value="" readonly="">
                                        <span class="input-group-btn xWConditionSearchPdt">
                                            <button id="obtASTBrowseFilterProductGroup" type="button" class="btn xCNBtnBrowseAddOn xWConditionSearchPdt">
                                                <img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- จากรหัส -->
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <!-- Browse Product Group -->
                    </div>

                    <!-- Browse Product Location Seq -->
                    <div class="xCNTabCondition">
                        <label class="xCNTabConditionHeader xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tASTFilterTitleLocation'); ?></label>
                        <div class="row">

                            <div class="col-md-6">
                                <!-- จากรหัส -->
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="input100 xCNHide" id="oetASTFilterPlcCode" name="oetASTFilterPlcCode" value="">
                                        <input class="form-control xWPointerEventNone" type="text" id="oetASTFilterPlcName" name="oetASTFilterPlcName" value="" readonly="">
                                        <span class="input-group-btn xWConditionSearchPdt">
                                            <button id="obtASTBrowseFilterProductLocation" type="button" class="btn xCNBtnBrowseAddOn xWConditionSearchPdt">
                                                <img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- จากรหัส -->
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input name="ocbASTPdtLocChkSeq" class="form-check-input xWASTDisabledOnApv" type="checkbox" value="1" id="ocbASTPdtLocChkSeq">
                                        <label class="form-check-label" for="ocbASTPdtLocChkSeq"><?php echo language('document/adjuststocksub/adjuststocksub', 'tASTFilterTextPdtLocSeqOnly'); ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6"></div>
                        </div>
                    </div>
                    <!-- Browse Product Location Seq -->

                    <!-- Product StockCard -->
                    <div class="xCNTabCondition">
                        <label class="xCNTabConditionHeader xCNLabelFrm"><?php echo language('document/adjuststocksub/adjuststocksub', 'tASTFilterTitlePdtStkCard'); ?></label>
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <div class="form-check">
                                        <input name="ocbASTUsePdtStkCard" class="form-check-input xWASTDisabledOnApv" type="checkbox" id="ocbASTUsePdtStkCard">
                                        <label class="form-check-label" for="ocbASTUsePdtStkCard"><?php echo language('document/adjuststocksub/adjuststocksub', 'tASTFilterTextUsePdtStkCard'); ?></label>
                                    </div>
                                </div>

                                <div class="form-group" style="margin-left: 20px;margin-top: -10px;">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input xWASTDisabledOnCheckUsePdtStkCard" id="orbASTPdtStkCard_1" name="orbASTPdtStkCard" value="1" disabled>
                                        <label class="custom-control-label" for="orbASTPdtStkCard_1"><?php echo language('document/adjuststocksub/adjuststocksub', 'tASTFilterTextPdtNotMove'); ?></label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input xWASTDisabledOnCheckUsePdtStkCard" id="orbASTPdtStkCard_2" name="orbASTPdtStkCard" value="2" disabled>
                                        <label class="custom-control-label" for="orbASTPdtStkCard_2">
                                            <?php echo language('document/adjuststocksub/adjuststocksub', 'tASTFilterTextPrePdtMove'); ?>
                                            <input class="form-control xWASTDisabledOnCheckUsePdtStkCard" type="number" id="onbASTPdtStkCardBack" name="onbASTPdtStkCardBack" min="1" style="width: 60px;display: inline;" disabled>
                                            <?php echo language('document/adjuststocksub/adjuststocksub', 'tASTFilterTextMonth'); ?>
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Product StockCard -->

                </form>

            </div>
            <div class="modal-footer">
                <button id="obtAdjStkSubConfirmFilter" type="button" class="btn xCNBTNPrimery xWASTDisabledOnApv"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubBtnFilterConfirm'); ?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel'); ?></button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include('script/jAdjustStockSubAdd.php')?>
