<?php
    if(isset($nStaCallView) && $nStaCallView == 1){
        $tRoute = "posEdcEventAdd";
    }else{
        $tRoute = "posEdcEventEdit";
    }

    if(isset($aDataPosEdc) && $aDataPosEdc['rtCode'] == '1'){
        $tPosEdcCode        = $aDataPosEdc['raItems']['FTEdcCode'];
        $tPosEdcName        = $aDataPosEdc['raItems']['FTEdcName'];
        $tPosEdcSedCode     = $aDataPosEdc['raItems']['FTSedCode'];
        $tPosEdcSedModel    = $aDataPosEdc['raItems']['FTSedModel'];
        $tPosEdcBnkCode     = $aDataPosEdc['raItems']['FTBnkCode'];
        $tPosEdcBnkName     = $aDataPosEdc['raItems']['FTBnkName'];
        $tPosEdcShwFont     = $aDataPosEdc['raItems']['FTEdcShwFont'];
        $tPosEdcShwBkg      = $aDataPosEdc['raItems']['FTEdcShwBkg'];
        $tPosEdcOther       = $aDataPosEdc['raItems']['FTEdcOther'];
        $tPosEdcRmk         = $aDataPosEdc['raItems']['FTEdcRmk'];

        $tUsrAgnCode        = $aDataPosEdc['raItems']['rtAgnCode'];
        $tUsrAgnName        = $aDataPosEdc['raItems']['rtAgnName'];
    }else{
        $tPosEdcCode        = "";
        $tPosEdcName        = "";
        $tPosEdcSedCode     = "";
        $tPosEdcSedModel    = "";
        $tPosEdcBnkCode     = "";
        $tPosEdcBnkName     = "";
        $tPosEdcShwFont     = "";
        $tPosEdcShwBkg      = "";
        $tPosEdcOther       = "";
        $tPosEdcRmk         = "";

        $tUsrAgnCode = $this->session->userdata("tSesUsrAgnCode");
        $tUsrAgnName = $this->session->userdata("tSesUsrAgnName");
    }
?>
<form id="ofmAddEditPosEdc" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <button class="xCNHide" id="obtPosEdcAddEditEvent" type="submit" onclick="JSxAddEditPosEdc()"></button>
    <input type="hidden" id="ohdPosEdcRouteData" name="ohdPosEdcRouteData" value="<?php echo $tRoute;?>">
    <div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('pos/posedc/posedc', 'tPosEdcCode');?></label>
                <?php if(isset($tPosEdcCode) && empty($tPosEdcCode)):?>
                    <div id="odvPosEdcAutoGenCode" class="form-group">
                        <div class="validate-input">
                            <label class="fancy-checkbox xWAutoGenCode ">
                            <input type="checkbox" id="ocbPosEdcAutoGenCode" name="ocbPosEdcAutoGenCode" checked="true" value="1">
                            <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                        </div>
                    </div>
                <?php endif;?>
                <div id="odvPosEdcCode" class="form-group">
                    <input type="hidden" id="ohdCheckDuplicatePosEdcCode" name="ohdCheckDuplicatePosEdcCode" value="1">
                    <div class="validate-input">
                        <input
                            type="text"
                            class="form-control xCNGenarateCodeTextInputValidate" 
                            maxlength="5"
                            id="oetPosEdcCode" 
                            name="oetPosEdcCode"
                            value="<?php echo @$tPosEdcCode;?>"
                            data-is-created=""
                            placeholder="<?php echo language('pos/posedc/posedc','tPosEdcCode');?>"
                            data-validate-required= "<?php echo language('pos/posedc/posedc','tPosEdcValidateCode');?>"
                            data-validate-dublicateCode="<?php echo language('pos/posedc/posedc','tPosEdcValidCodeDup');?>"
                        >
                    </div>
                </div>

                <!-- Agency -->
                <div class="<?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('common/main/main','tAgency')?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetEDCUsrAgnCode"
                                name="oetEDCUsrAgnCode" value="<?=@$tUsrAgnCode?>">
                            <input type="text" class="form-control xWPointerEventNone" id="oetEDCUsrAgnName"
                                name="oetEDCUsrAgnName"
                                placeholder="<?php echo language('common/main/main','tAgency')?>"
                                value="<?=@$tUsrAgnName?>" readonly>
                            <span class="input-group-btn">
                                <button id="obtEDCUsrBrowseAgency" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img
                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- end Agency -->

                <div class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span>  <?php echo  language('pos/posedc/posedc','tPosEdcName'); ?></label>
                    <input type="text" class="form-control" id="oetPosEdcName" name="oetPosEdcName" maxlength="100" value="<?php echo @$tPosEdcName;?>"
                    placeholder="<?php echo  language('pos/posedc/posedc','tPosEdcName'); ?>" autocomplete="off"
                    data-validate-required= "<?php echo language('pos/posedc/posedc','tPosEdcValidateName');?>"
                    >
                </div>    
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo  language('pos/posedc/posedc','tPosEdcSysModel'); ?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNHide" id="oetPosEdcSedCode" name="oetPosEdcSedCode" value="<?php echo @$tPosEdcSedCode;?>">
                        <input type="text" class="form-control xWPointerEventNone" id="oetPosEdcSedName" name="oetPosEdcSedName" value="<?php echo @$tPosEdcSedModel;?>" readonly>
                        <span class="input-group-btn">
                            <button id="oimPosEdcSysModelBrowse" type="button" class="btn xCNBtnBrowseAddOn">
                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo  language('pos/posedc/posedc','tPosEdcBank');?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNHide" id="oetPosEdcBnkCode" name="oetPosEdcBnkCode" value="<?php echo @$tPosEdcBnkCode;?>">
                        <input type="text" class="form-control xWPointerEventNone" id="oetPosEdcBnkName" name="oetPosEdcBnkName" value="<?php echo @$tPosEdcBnkName;?>" readonly>
                        <span class="input-group-btn">
                            <button id="oimPosEdcBankBrowse" type="button" class="btn xCNBtnBrowseAddOn">
                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo  language('pos/posedc/posedc','tPosEdcShwFont');?></label>
                    <input type="color" class="form-control" id="oetPosEdcShwFont" name="oetPosEdcShwFont" maxlength="50" value="<?php echo @$tPosEdcShwFont;?>">
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo  language('pos/posedc/posedc','tPosEdcShwBkg');?></label>
                    <input type="color" class="form-control" id="oetPosEdcShwBkg" name="oetPosEdcShwBkg" maxlength="50" value="<?php echo @$tPosEdcShwBkg;?>">
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo  language('pos/posedc/posedc','tPosEdcOther');?></label>
                    <input type="text" class="form-control" id="oetPosEdcOther" name="oetPosEdcOther" maxlength="255" value="<?php echo @$tPosEdcOther;?>">
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo  language('pos/posedc/posedc','tPosEdcRmk');?></label>
                    <textarea class="form-control" maxlength="100" rows="4" id="otaPosEdcRemark" name="otaPosEdcRemark"><?php echo @$tPosEdcRmk;?></textarea>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jPosEdcAdd.php";?>