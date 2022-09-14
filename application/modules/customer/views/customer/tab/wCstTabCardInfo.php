<?php 
$tCstCrdNo = empty($aResult['raCardInfo']['rtCstCrdNo']) ? "" : $aResult['raCardInfo']['rtCstCrdNo'];
$tCstApply = empty($aResult['raCardInfo']['rtCstApply']) ? "" : date('Y-m-d', strtotime($aResult['raCardInfo']['rtCstApply']));
$tCstCrdIssue = empty($aResult['raCardInfo']['rtCstCrdIssue']) ? "" : date('Y-m-d', strtotime($aResult['raCardInfo']['rtCstCrdIssue']));
$tCstCrdExpire = empty($aResult['raCardInfo']['rtCstCrdExpire']) ? "" : date('Y-m-d', strtotime($aResult['raCardInfo']['rtCstCrdExpire']));
$tCstBchCode = empty($aResult['raCardInfo']['rtBchCode']) ? $this->session->userdata('tSesUsrBchCodeDefault') : $aResult['raCardInfo']['rtBchCode'];
$tCstStaAge = empty($aResult['raCardInfo']['rtCstStaAge']) ? "" : $aResult['raCardInfo']['rtCstStaAge'];
$tCstBchName = empty($aResult['raCardInfo']['rtBchName']) ? $this->session->userdata('tSesUsrBchNameDefault') : $aResult['raCardInfo']['rtBchName'];
?>
<div id="odvTabCardInfo" class="tab-pane fade">
    <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCustomerCardInfo">
        <button style="display:none" type="submit" id="obtSave_oliCstCardInfo" onclick="JSnCSTAddEditCustomerCardInfo('<?=$tCardInfoRoute?>')"></button>
        <button style="display:none" type="submit" id="obtCancel_oliCstCardInfo" onclick="JSnCSTCancelCustomerCardInfo()"></button>
        <input type="hidden" name="oetCstCode" value="<?=$tCstCode?>">
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('customer/customer/customer','tCSTCardNo')?></label>
                    <input 
                        type="text" 
                        class="form-control" 
                        maxlength="50" 
                        id="oetCstCardNo" 
                        name="oetCstCardNo" 
                        data-validate="<?php echo language('customer/customer/customer','tCSTVAlidateDetailCard');?>"
                        autocomplete ="off";
                        value="<?=$tCstCrdNo?>">
                </div>

                <!-- วันที่สมัคร -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTApply')?></label>
                    <div class="input-group">
                        <input
                            class="form-control input100 xCNDatePicker" 
                            type="text" 
                            name="oetCSTApply" 
                            id="oetCSTApply" 
                            aria-invalid="false" 
                            value="<?php echo $tCstApply;?>"
                            data-validate="Please Insert Doc Date"
                        >
                        <span class="input-group-btn">
                            <button type="button" class="btn xCNBtnDateTime" onclick="$('#oetCSTApply').focus()"><img class="xCNIconCalendar"></button>
                        </span>
                    </div>
                </div>

                <!-- วันที่ออกบัตร -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTCardIssue')?></label>
                    <div class="input-group"> 
                        <input 
                            class="form-control  input100 xCNDatePicker" 
                            type="text" 
                            name="oetCSTCardIssue" 
                            id="oetCSTCardIssue" 
                            aria-invalid="false"
                            value="<?=$tCstCrdIssue?>" 
                            data-validate="Please Insert Card Issue">
                            <span class="input-group-btn">
                                <button type="button" class="btn xCNBtnDateTime" onclick="$('#oetCSTCardIssue').focus()"><img class="xCNIconCalendar"></button>
                            </span>
                    </div>
                </div>

                <!-- วันหมดอายุ -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTCardExpire')?></label>
                    <div class="input-group">
                        <input 
                            class="form-control  input100 xCNDatePicker" 
                            type="text" 
                            name="oetCSTCardExpire" 
                            id="oetCSTCardExpire" 
                            value="<?=$tCstCrdExpire?>" 
                            aria-invalid="false"
                            data-validate="Please Insert Card Expire">
                            <span class="input-group-btn">
                                <button type="button" class="btn xCNBtnDateTime" onclick="$('#oetCSTCardExpire').focus()"><img class="xCNIconCalendar"></button>
                            </span>
                    </div>
                </div>

                <!-- Browse Brach สาขาที่ออกบัตร -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('customer/customer/customer','tCSTCardBch')?></label>
                    <div class="input-group">
                        <input type="hidden" id="oetCstCardBchCode" name="oetCstCardBchCode" maxlength="5" value="<?=$tCstBchCode?>">
                        <input class="input100 xWPointerEventNone" type="text" id="oetCstCardBchName" name="oetCstCardBchName" placeholder="" value="<?=$tCstBchName?>" readonly>
                        <span class="input-group-btn">
                            <button id="oimCstBrowseCardBch" type="button" class="btn xCNBtnBrowseAddOn">
                                <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="">
                        <label class="fancy-checkbox">
                            <?php $tCardStaAgeChecked = $tCstStaAge == "1" ? "checked" : ""?>
                            <input type="checkbox" name="ocbCstCardStaAge" id="ocbCstCardStaAge" <?=$tCardStaAgeChecked?> value="1">
                            <span> <?php echo language('customer/customer/customer','tCSTCardStaAge'); ?></span>
                        </label>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

