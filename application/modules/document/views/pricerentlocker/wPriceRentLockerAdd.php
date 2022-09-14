<?php
    if(isset($aDataList['rtCode']) && $aDataList['rtCode'] == '1'){
        $tPriRntLkRoute         = "dcmPriRntLkEventEdit";
        $tPriRntLkRthCode       = $aDataList['raItems']['FTRthCode'];
        $tPriRntLkRthCalType    = $aDataList['raItems']['FTRthCalType'];
        $tPriRntLkRthName       = $aDataList['raItems']['FTRthName'];
        $tAgnCode               = $aDataList['raItems']['FTAgnCode'];;
        $tAgnName               = $aDataList['raItems']['FTAgnName'];;
    }else{
        $tPriRntLkRoute         = "dcmPriRntLkEventAdd";
        $tPriRntLkRthCode       = "";
        $tPriRntLkRthCalType    = "";
        $tPriRntLkRthName       = "";
        $tAgnCode               = $this->session->userdata("tSesUsrAgnCode");
        $tAgnName               = $this->session->userdata("tSesUsrAgnName");
    }
?>
<style>
    .xWPriRntLkInputEdit {
        background: #F9F9F9 !important;
        border-top: 0px !important;
        border-left: 0px !important;
        border-right: 0px !important;
        box-shadow: inset 0 0px 0px;
    }
</style>
<div class="panel panel-headline">
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-4 col-lg-4 p-t-10">
                <form id="ofmPriRntLkFormHDAdd" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="ohdPriRntLkRoute" name="ohdPriRntLkRoute" value="<?php echo @$tPriRntLkRoute;?>">
                    <input type="hidden" id="ohdPriRntLkCheckClearValidate" name="ohdPriRntLkCheckClearValidate" value="0">
                    <input type="hidden" id="ohdPriRntLkCheckSubmitByButton" name="ohdPriRntLkCheckSubmitByButton" value="0">
                    <input type="hidden" id="ohdPriRntLkCheckDuplicateCode" name="ohdPriRntLkCheckDuplicateCode" value="2">
                    <button style="display:none" type="submit" id="obtPriRntLkSubmit" onclick="JSxPriRntLkValidateFormDocument()"></button>

                    <label class="xCNLabelFrm"><span style = "color:red">*</span> <?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkRthCode')?></label>
                    <?php if(isset($tPriRntLkRthCode) && empty($tPriRntLkRthCode)):?>
                        <div class="form-group">
                            <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbPriRntLkAutoGenCode" name="ocbPriRntLkAutoGenCode" maxlength="1" checked="checked">
                                <span>&nbsp;</span>
                                <span class="xCNLabelFrm"><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkAutoGenCode');?></span>
                            </label>
                        </div>
                    <?php endif;?>
                    <div class="form-group" style="cursor:not-allowed">
                        <input
                            type="text"
                            class="form-control xCNInputWithoutSpc xCNInputWithoutSingleQuote"
                            id="oetPriRntLkRthCode"
                            name="oetPriRntLkRthCode"
                            maxlength="5"
                            value="<?php echo @$tPriRntLkRthCode;?>"
                            data-validate-required="<?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkPlsEnterOrRunDocNo'); ?>"
                            data-validate-duplicate="<?php echo language('document/pricerentlocker/pricerentlocker','tPriEntLkPlsDocNoDuplicate'); ?>"
                            placeholder="<?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkRthCode');?>"
                            style="pointer-events:none"
                            readonly
                        >
                    </div>

                    <div class="form-group" <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>>
                        <label class="xCNLabelFrm"><?=language('supplier/supplier/supplier','tAGNName')?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetPrnAgnCode" name="oetPrnAgnCode" value="<?=$tAgnCode;?>">
                            <input type="text" class="form-control xWPointerEventNone" id="oetPrnAgnName" name="oetPrnAgnName" placeholder="<?=language('supplier/supplier/supplier','tAGNName')?>" value="<?=$tAgnName;?>" readonly>
                            <span class="input-group-btn">
                                <script>    
                                    //ถ้าเป็น BCH + SHP จะไม่สามารถเลือกได้
                                    var tStaUsrLevel = '<?=$this->session->userdata("tSesUsrLevel");?>';
                                    if(tStaUsrLevel == 'BCH' || tStaUsrLevel == 'SHP'){
                                        $('#obtPrnBrowseAgency').attr("disabled", true);
                                    }
                                </script>
                                <button id="obtPrnBrowseAgency" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img src="<?= base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style = "color:red">*</span> <?php echo language('document/purchaseinvoice/purchaseinvoice','tPriRntLkRthName')?></label>
                        <input
                            type="text"
                            class="form-control"
                            id="oetPriRntLkRthName"
                            name="oetPriRntLkRthName"
                            data-validate-required="<?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkPlsInsertRthName'); ?>"
                            value="<?php echo @$tPriRntLkRthName;?>"
                        >
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPriRntLkRthCalType')?></label>
                        <?php
                            switch($tPriRntLkRthCalType){
                                case '1':
                                    $tPriRntLkRthCalTypeSlt1 = "selected";
                                    $tPriRntLkRthCalTypeSlt2 = "";
                                    $tPriRntLkRthCalTypeSlt3 = "";
                                break;
                                case '2':
                                    $tPriRntLkRthCalTypeSlt1 = "";
                                    $tPriRntLkRthCalTypeSlt2 = "selected";
                                    $tPriRntLkRthCalTypeSlt3 = "";
                                break;
                                case '3':
                                    $tPriRntLkRthCalTypeSlt1 = "";
                                    $tPriRntLkRthCalTypeSlt2 = "";
                                    $tPriRntLkRthCalTypeSlt3 = "selected";
                                break;
                                default:
                                    $tPriRntLkRthCalTypeSlt1 = "selected";
                                    $tPriRntLkRthCalTypeSlt2 = "";
                                    $tPriRntLkRthCalTypeSlt3 = "";
                            }
                        ?>
                        <select class="selectpicker form-control" id="ocmPriRntLkRthCalType" name="ocmPriRntLkRthCalType" maxlength="1" data-test="<?php echo $tPriRntLkRthCalType;?>">
                            <option value="1" <?php echo $tPriRntLkRthCalTypeSlt1;?>><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkRthCalType1');?></option>
                            <option value="2" <?php echo $tPriRntLkRthCalTypeSlt2;?>><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkRthCalType2');?></option>
                            <option value="3" <?php echo $tPriRntLkRthCalTypeSlt3;?>><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkRthCalType3');?></option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-sm-6 col-sm-8 col-lg-8 p-t-25">
                <form id="ofmPriRntLkFormDTAdd" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                    <div id="odvPriRntLkMenuAddDataDT" class="row">
                        <!-- ปรเภทการให้เช่า -->
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkRtdTmeType');?></label>
                                <select
                                    class="selectpicker form-control"
                                    id="ocmPriRntLkRtdTmeType"
                                    name="ocmPriRntLkRtdTmeType"
                                    maxlength="1"
                                    data-validate-required="<?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkValidRtdTmeType');?>"
                                >
                                    <option value="1"><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkRtdTmeType1');?></option>
                                    <option value="2"><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkRtdTmeType2');?></option>
                                    <option value="3"><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkRtdTmeType3');?></option>
                                    <option value="4"><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkRtdTmeType4');?></option>
                                    <option value="5"><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkRtdTmeType5');?></option>
                                </select>
                            </div>
                        </div>
                        <!-- เงื่อนไขต่อหน่วย -->
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkRtdMinQty');?></label>
                                <input
                                    type="number"
                                    class="form-control xCNInputWithoutSingleQuote xCNInputNumericWithoutDecimal"
                                    id="oenPriRntLkRtdMinQty"
                                    name="oenPriRntLkRtdMinQty"
                                    data-validate-required="<?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkValidRtdMinQty');?>"
                                    data-validate-zero="<?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkValidRtdMinQtyNotZero');?>"
                                >
                            </div>
                        </div>
                        <!-- อัตราค่าเช่า -->
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkRtdPrice');?></label>
                                <input
                                    type="text"
                                    class="form-control xCNInputWithoutSingleQuote xCNInputNumericWithDecimal"
                                    id="oetPriRntLkRtdPrice"
                                    name="oetPriRntLkRtdPrice"
                                    data-validate-required="<?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkValidRtdPrice');?>"
                                >
                            </div>
                        </div>
                        <!-- เพิ่มอัตราเช่า -->
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group" style="width:100%;float:right;">
                                <label class="xCNLabelFrm">&nbsp;</label>
                                <button type="button" id="obtPriRntLkAddDataDT" class="btn btn-primary" style="width:100%">
                                   
                                    <label class="xCNLabelFrm" style="color : #FFF !important;">
                                        + <?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkAddDataDT');?>
                                    </label>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="odvPriRntLkDataDT" class="row">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ================================================================================ Script Html Append Data Row ================================================================================ -->
    <script type="text/html" id="oscPriRntLkTemplateTr">
        <tr 
            class="xCNPriRntLkItem"
            data-index="{tPriRntLkRtdSeqNo}"
            data-seqno="{tPriRntLkRtdSeqNo}"
            data-docno="{tPriRntLkRtdDocNo}"
            data-tmetype="{tPriRntLkRtdTmeType}"
            data-minqty="{tPriRntLkRtdMinQty}"
            data-calmin=""
            data-price="{tPriRntLkRtdPrice}"
        >
            <td nowrap class="text-left">{tPriRntLkRtdTmeTypeName}</td>
            <td nowrap class="text-center xCNPriRntLkEditInLine xWPriRntLKRtdMinQty">{tPriRntLkRtdMinQty}</td>
            <td nowrap class="text-center xWPriRntLkRtdCalMin"><label></label></td>
            <td nowrap class="text-center xCNPriRntLkEditInLine xWPriRntLKRtdPrice">{tPriRntLkRtdPrice}</td>
            <td nowrap class="text-center">
                <label class="xCNTextLink">
                    <img class="xCNIconTable" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" title="Remove" onclick="JSnPriRntLkRemoveDocDTTempRow(this)">
                </label>
            </td>
        </tr>
    </script>

    <script type="text/html" id="oscPriRntLkLoddingInput">
        <div class="xInputLoadding">
            <img style="width:20px;height:20px;position:absolute;left: 50%;transform: translate(-40%, 0);" class="xWImgLoading xWEditInlineLoadding" src="<?php echo base_url('application/modules/common/assets/images/ada.loading.gif');?>">
        </div>
    </script>

    <script type="text/html" id="oscPriRntLkNoDataInTableDT">
        <tr><td class="text-center xWPriRntLkTextNotfoundDataDT" colspan="100%"><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
    </script>

<!-- ============================================================================================================================================================================================= -->

<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include('script/jPriceRentLockerAdd.php');?>

