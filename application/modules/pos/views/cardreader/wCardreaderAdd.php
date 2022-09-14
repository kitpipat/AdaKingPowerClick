<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddEdc">
	<button style="display:none" type="submit" id="obtSubmitCardReader" onclick="JSnAddEditEdc('EdcEventAdd')"></button>
		<div class="panel-body" style="padding-top:20px !important;">
			<div class="row">

                <!-- gencode -->
                <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('pos/salemachine/salemachine', 'tPOSCodeDevice'); ?><?= language('pos/salemachine/salemachine', 'tPOSModelEDCName'); ?></label>
                        <div id="odvEdcAutoGenCode" class="form-group">
                            <div class="validate-input">
                            <label class="fancy-checkbox">
                            <input type="checkbox" id="ocbEdcAutoGenCode" name="ocbEdcAutoGenCode" checked="true" value="1">
                            <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                        </label>
                    </div>
                </div>
                    <div id="odvEdcCodeForm" class="form-group">
                        <input type="hidden" id="ohdCheckDuplicateEdcCode" name="ohdCheckDuplicateEdcCode" value="1"> 
                            <div class="validate-input">
                                <input 
                                type="text" 
                                class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                                maxlength="5" 
                                id="oetEdcCode" 
                                name="oetEdcCode"
                                data-is-created=""
                                placeholder="<?= language('ticket/agency/agency','tAGNValidCode')?>"
                                data-validate-required = "<?= language('ticket/agency/agency','tAGNValidCheckCode')?>"
                                data-validate-dublicateCode = "<?= language('ticket/agency/agency','tAGNValidCheckCode')?>"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end gencode -->

            <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                 <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo  language('pos/salemachine/salemachine', 'tPOSModelEDC'); ?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetEdcCodeBrowse" name="oetEdcCodeBrowse">
                                <input type="text" class="form-control xWPointerEventNone" id="oetEdcName" name="oetEdcName" readonly>
                                <span class="input-group-btn">
                                <button id="oimBrowseEdc" type="button" class="btn xCNBtnBrowseAddOn">
                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>
            </div>   
            </div>  


            <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                 <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('bank/bank/bank','tBNKTitle')?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetBnkCode" name="oetBnkCode" value="">
                                <input type="text" class="form-control xWPointerEventNone" id="oetBnkName" name="oetBnkName" value="" readonly>
                                <span class="input-group-btn">
                                <button id="oimBrowsebank" type="button" class="btn xCNBtnBrowseAddOn">
                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>
            </div>  
        </div> 

        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <label class="xCNLabelFrm"><?php echo language('pos/salemachine/salemachine','tPOSModelEDCNameColorShowing')?></label>
                <div class="form-group">
                    <input type="color" class="form-control " id="oetShwFont" name="oetShwFont">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <label class="xCNLabelFrm"><?php echo language('pos/salemachine/salemachine','tPOSModelEDCBackgroundColor')?></label>
                <div class="form-group">
                    <input type="color"  class="form-control xCNide" id="oetEdcShwBkg" name="oetEdcShwBkg">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <label class="xCNLabelFrm"><?php echo language('pos/salemachine/salemachine','tPOSModelEDCOtherValues')?></label>
                <input type="text" class="form-control"  id="oetEdcOther" name="oetEdcOther">
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <label class="xCNLabelFrm">หมายเหตุ</label>
                <textarea class="input100" rows="4" maxlength="100" id="otaEdcRemark" name="otaEdcRemark"></textarea>
            </div>
        </div>

        </div>
    </div>
</form>

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jCardreaderAdd.php"; ?>

