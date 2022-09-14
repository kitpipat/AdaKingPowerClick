<?php
if($aResult['rtCode'] == "1"){
    $tBdtCode       	= $aResult['raItems']['rtBdtCode'];
	$tBdtName       	= $aResult['raItems']['rtBdtName'];

    $tUsrAgnCode        = $aResult['raItems']['rtAgnCode'];
    $tUsrAgnName        = $aResult['raItems']['rtAgnName'];
    //route
	$tRoute         	= "bankdeptypeupdateevent";
	//Event Control
	if(isset($aAlwEventBankdeptype)){
		if($aAlwEventBankdeptype['tAutStaFull'] == 1 || $aAlwEventBankdeptype['tAutStaEdit'] == 1){
			$nAutStaEdit = 1;
		}else{
			$nAutStaEdit = 0;
		}
	}else{
		$nAutStaEdit = 0;
	}
}else{
    $tBdtCode       	= "";
	$tBdtName       	= "";

    $tUsrAgnCode = $this->session->userdata("tSesUsrAgnCode");
    $tUsrAgnName = $this->session->userdata("tSesUsrAgnName");

    //route
	$tRoute         = "bankdeptypeaddevent";
	$nAutStaEdit = 0; //Event Control
}
?>

                    <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddBdt">
                        <button style="display:none" type="submit" id="obtSubmitBdt" onclick="JSnAddEditBdt('<?php echo $tRoute ?>')"></button>
                        <div class="panel-body" style="padding-top:20px !important;">
                        <div class="row">

                            <div class="col-xs-12 col-md-8 col-lg-4">
                                <!-- รหัสสมุดบัญชี -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo  language('bankdeptype/bankdeptype/bankdeptype', 'tBdtCode'); ?></label>
                                    <div id="odvBdtAutoGenCode" class="form-group">
                                        <div class="validate-input">
                                            <label class="fancy-checkbox">
                                                <input type="checkbox" id="ocbBdtAutoGenCode" name="ocbBdtAutoGenCode" checked="true" value="1">
                                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div id="odvBdtCodeForm" class="form-group">
                                        <input type="hidden" id="ohdCheckDuplicateBdtCode" name="ohdCheckDuplicateBdtCode" value="1">
                                            <div class="validate-input">
                                            <input
                                            type="text"
                                            class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
                                            maxlength="5"
                                            id="oetBdtCode"
                                            name="oetBdtCode"
                                            value="<?php echo $tBdtCode;?>"
                                            autocomplete="off"
                                            data-is-created="<?php echo $tBdtCode;?>"
                                            placeholder="<?= language('bankdeptype/bankdeptype/bankdeptype','tBdtCode')?>"
                                            data-validate-required = "<?php echo  language('bankdeptype/bankdeptype/bankdeptype','tBdtValidCode')?>"
                                            data-validate-dublicateCode = "<?php echo  language('bankdeptype/bankdeptype/bankdeptype','tBdtValidCheckCode')?>"
                                            >
                                        </div>
                                    </div>
                                </div>

                                <!-- Agency -->
                                <div class="<?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('common/main/main','tAgency')?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetBDTUsrAgnCode"
                                                name="oetBDTUsrAgnCode" value="<?=@$tUsrAgnCode?>">
                                            <input type="text" class="form-control xWPointerEventNone" id="oetBDTUsrAgnName"
                                                name="oetBDTUsrAgnName"
                                                placeholder="<?php echo language('common/main/main','tAgency')?>"
                                                value="<?=@$tUsrAgnName?>" readonly>
                                            <span class="input-group-btn">
                                                <button id="obtBDTUsrBrowseAgency" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img
                                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- end Agency -->

									<div class="form-group">
                                        <div class="validate-input">
                                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('bankdeptype/bankdeptype/bankdeptype','tBdtName')?></label>
                                            <input type="text" class="form-control" maxlength="200" id="oetBdtName" name="oetBdtName" placeholder="<?= language('bankdeptype/bankdeptype/bankdeptype','tBdtName')?>" autocomplete="off" value="<?php echo $tBdtName ?>" data-validate-required="<?php echo  language('bankdeptype/bankdeptype/bankdeptype','tBdtValidName')?> ">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>

<!-- div Dropdownbox -->
<?php include "script/jBankdeptypeAdd.php"; ?>
