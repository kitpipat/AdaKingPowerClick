<?php 
$tCstCrTerm = empty($aResult['raCredit']['rtCstCrTerm']) ? "" : $aResult['raCredit']['rtCstCrTerm'];
$tCstCrLimit = empty($aResult['raCredit']['rtCstCrLimit']) ? "" : $aResult['raCredit']['rtCstCrLimit'];
$tCstStaAlwOrdMon = empty($aResult['raCredit']['rtCstStaAlwOrdMon']) ? "" : $aResult['raCredit']['rtCstStaAlwOrdMon'];
$tCstStaAlwOrdTue = empty($aResult['raCredit']['rtCstStaAlwOrdTue']) ? "" : $aResult['raCredit']['rtCstStaAlwOrdTue'];
$tCstStaAlwOrdWed = empty($aResult['raCredit']['rtCstStaAlwOrdWed']) ? "" : $aResult['raCredit']['rtCstStaAlwOrdWed'];
$tCstStaAlwOrdThu = empty($aResult['raCredit']['rtCstStaAlwOrdThu']) ? "" : $aResult['raCredit']['rtCstStaAlwOrdThu'];
$tCstStaAlwOrdFri = empty($aResult['raCredit']['rtCstStaAlwOrdFri']) ? "" : $aResult['raCredit']['rtCstStaAlwOrdFri'];
$tCstStaAlwOrdSat = empty($aResult['raCredit']['rtCstStaAlwOrdSat']) ? "" : $aResult['raCredit']['rtCstStaAlwOrdSat'];
$tCstStaAlwOrdSun = empty($aResult['raCredit']['rtCstStaAlwOrdSun']) ? "" : $aResult['raCredit']['rtCstStaAlwOrdSun'];
$tCstPayRmk = empty($aResult['raCredit']['rtCstPayRmk']) ? "" : $aResult['raCredit']['rtCstPayRmk'];
$tCstBillRmk = empty($aResult['raCredit']['rtCstBillRmk']) ? "" : $aResult['raCredit']['rtCstBillRmk'];
$tCstViaRmk = empty($aResult['raCredit']['rtCstViaRmk']) ? "" : $aResult['raCredit']['rtCstViaRmk'];
$tCstViaTime = empty($aResult['raCredit']['rtCstViaTime']) ? "" : $aResult['raCredit']['rtCstViaTime'];
$tViaCode = empty($aResult['raCredit']['rtViaCode']) ? "" : $aResult['raCredit']['rtViaCode'];
$tViaName = empty($aResult['raCredit']['rtViaName']) ? "" : $aResult['raCredit']['rtViaName'];
$tCstTspPaid = empty($aResult['raCredit']['rtCstTspPaid']) ? "" : $aResult['raCredit']['rtCstTspPaid'];
$tCstStaApv = empty($aResult['raCredit']['rtCstStaApv']) ? "" : $aResult['raCredit']['rtCstStaApv'];
?>
<div id="odvTabCredit" class="tab-pane fade">
    <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCustomerCredit">
        <button style="display:none" type="submit" id="obtSave_oliCstCredit" onclick="JSnCSTAddEditCustomerCredit('<?=$tCreditRoute?>')"></button>
        <button style="display:none" type="submit" id="obtCancel_oliCstCredit" onclick="JSnCSTCancelCustomerCredit()"></button>
        <input type="hidden" name="oetCstCode" value="<?php echo $tCstCode; ?>">
        <div class="row">
            <div class="col-xl-6 col-lg-6">

                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('customer/customer/customer', 'tCSTCreditTerm')?></label>
                    <input 
                        type="text" 
                        class="form-control" 
                        maxlength="100" 
                        id="oetCstCreditTerm" 
                        name="oetCstCreditTerm" 
                        value="<?=$tCstCrTerm?>"
                        data-validate="<?php echo language('customer/customer/customer','tCSTVAlidateCreditdays');?>"
                        >
                </div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('customer/customer/customer', 'tCSTCreditLimit')?></label>
                    <input 
                        type="text" 
                        maxlength="100" 
                        id="oetCstCreditLimit" 
                        name="oetCstCreditLimit" 
                        value="<?=$tCstCrLimit?>"
                        data-validate="<?php echo language('customer/customer/customer','tCSTValidateCreditlimit');?>"
                        >
                </div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('customer/customer/customer', 'tCSTCreditDailyContact')?></label>
                    <div class="">
                        <label class="fancy-checkbox custom-bgcolor-blue">
                            <?php $tMonChecked = $tCstStaAlwOrdMon == "1" ? "checked" : ""?>
                            <input type="checkbox" name="ocbCstStaAlwOrdMon" <?=$tMonChecked?> value="1" >
                            <span> <?=language('customer/customer/customer','tCSTStaAlwOrdMon')?></span>
                        </label>
                        <label class="fancy-checkbox custom-bgcolor-blue">
                            <?php $tTueChecked = $tCstStaAlwOrdTue == "1" ? "checked" : ""?>
                            <input type="checkbox" name="ocbCstStaAlwOrdTue" <?=$tTueChecked?> value="1">
                            <span> <?=language('customer/customer/customer','tCSTStaAlwOrdTue')?></span>
                        </label>
                        <label class="fancy-checkbox custom-bgcolor-blue">
                            <?php $tWedChecked = $tCstStaAlwOrdWed == "1" ? "checked" : ""?>
                            <input type="checkbox" name="ocbCstStaAlwOrdWed" <?=$tWedChecked?> value="1">
                            <span> <?=language('customer/customer/customer','tCSTStaAlwOrdWed')?></span>
                        </label>
                        <label class="fancy-checkbox custom-bgcolor-blue">
                            <?php $tThuChecked = $tCstStaAlwOrdThu == "1" ? "checked" : ""?>
                            <input type="checkbox" name="ocbCstStaAlwOrdThu" <?=$tThuChecked?> value="1">
                            <span> <?=language('customer/customer/customer','tCSTStaAlwOrdThu')?></span>
                        </label>
                        <label class="fancy-checkbox custom-bgcolor-blue">
                            <?php $tFriChecked = $tCstStaAlwOrdFri == "1" ? "checked" : ""?>
                            <input type="checkbox" name="ocbCstStaAlwOrdFri" <?=$tFriChecked?> value="1">
                            <span> <?=language('customer/customer/customer','tCSTStaAlwOrdFri')?></span>
                        </label>
                        <label class="fancy-checkbox custom-bgcolor-blue">
                            <?php $tSatChecked = $tCstStaAlwOrdSat == "1" ? "checked" : ""?>
                            <input type="checkbox" name="ocbCstStaAlwOrdSat" <?=$tSatChecked?> value="1">
                            <span> <?=language('customer/customer/customer','tCSTStaAlwOrdSat')?></span>
                        </label>
                        <label class="fancy-checkbox custom-bgcolor-blue">
                            <?php $tSunChecked = $tCstStaAlwOrdSun == "1" ? "checked" : ""?>
                            <input type="checkbox" name="ocbCstStaAlwOrdSun" <?=$tSunChecked?> value="1">
                            <span> <?=language('customer/customer/customer','tCSTStaAlwOrdSun')?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><?=language('customer/customer/customer', 'tCSTPayRmk')?></label>
                                <textarea maxlength="100" rows="4" id="otaCstPayRmk" name="otaCstPayRmk"><?=$tCstPayRmk?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><?=language('customer/customer/customer', 'tCSTBillRmk')?></label>
                                <textarea maxlength="100" rows="4" id="otaCstBillRmk" name="otaCstBillRmk"><?=$tCstBillRmk?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><?=language('customer/customer/customer', 'tCSTViaRmk')?></label>
                                <textarea maxlength="100" rows="4" id="otaCstViaRmk" name="otaCstViaRmk"><?=$tCstViaRmk?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('customer/customer/customer','tCSTViaTime')?></label>
                    <input 
                        type="text" 
                        class="form-control" 
                        maxlength="100" 
                        id="oetCstViaTime" 
                        name="oetCstViaTime" 
                        value="<?=$tCstViaTime?>"
                        data-validate="<?php echo language('customer/customer/customer','tCSTVAlidateShippingdays');?>">
                </div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTShipVia')?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNHide" id="oetCstShipViaCode" name="oetCstShipViaCode" maxlength="5" value="">
                        <input class="input100 xWPointerEventNone" type="text" id="oetCstShipViaName" name="oetCstShipViaName" placeholder=""  value="<?=$tViaName?>" readonly>
                        <span class="input-group-btn">
                            <button id="oimCstBrowseShipVia" type="button" class="btn xCNBtnBrowseAddOn">
                                <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="fancy-radio">
                        <label>
                            <?php $tTspPaid1Select = $tCstTspPaid == "1" ? "checked" : ""?>
                            <input type="radio" name="orbCstTspPaid" <?=$tTspPaid1Select?> value="1">
                            <span><i></i><?= language('customer/customer/customer', 'tCSTTspPaid1')?></span>
                        </label>
                        <label>
                            <?php $tTspPaid2Select = $tCstTspPaid == "2" ? "checked" : ""?>
                            <input type="radio" name="orbCstTspPaid" <?=$tTspPaid2Select?> value="2">
                            <span><i></i><?= language('customer/customer/customer', 'tCSTTspPaid2')?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="">
                        <label class="fancy-checkbox">
                            <?php $tCreStaApvChecked = $tCstStaApv == "1" ? "checked" : ""?>
                            <input type="checkbox" name="orbCstCreStaApv" <?=$tCreStaApvChecked?> value="1"> 
                            <span> <?= language('customer/customer/customer', 'tCSTCreditStaApv')?></span>
                        </label>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

