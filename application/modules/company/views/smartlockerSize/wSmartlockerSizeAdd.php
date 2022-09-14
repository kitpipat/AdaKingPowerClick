<?php
    $nDecimalShow = FCNxHGetOptionDecimalShow();
    if($aResult['rtCode'] == "1"){
        //route
        $tRoute     = "SHPSmartLockerSizeEventEdit";
        $tPzeCode   = $aResult['raItems']['FTPzeCode'];
        $tPzeDim    = $aResult['raItems']['FCPzeDim'];
        $tPzeHigh   = $aResult['raItems']['FCPzeHigh'];
        $tPzeWide   = $aResult['raItems']['FCPzeWide'];
        $tSizName   = $aResult['raItems']['FTSizName'];
        $tRemark    = $aResult['raItems']['FTSizRemark'];
        //Event Control
        if(isset($aAlwEventSmartlockerSize)){
            if($aAlwEventSmartlockerSize['tAutStaFull'] == 1 || $aAlwEventSmartlockerSize['tAutStaEdit'] == 1){
                $nAutStaEdit = 1;
            }else{
                $nAutStaEdit = 0;
            }
        }else{
            $nAutStaEdit = 0;
        }
    }else{
        //route
        $tRoute         = "SHPSmartLockerSizeEventAdd";
        $tPzeCode       = "";
        $tPzeDim        = 0;
        $tPzeHigh       = 0;
        $tPzeWide       = 0;
        $tSizName       = "";
        $tRemark        = "";
        $nAutStaEdit    = 0; //Event Control
    }
?>
<style>
    .NumberDuplicate{
        font-size   : 15px !important;
        color       : red;
        font-style  : italic;
    }

    .xCNSearchpadding{
        padding     : 0px 3px;
    }
</style>
<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddSms">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <label class="xCNLabelFrm" style="color: #179bfd !important; cursor:pointer;" onclick="JSxGetSHPContentSmartLockerSize();" ><?php echo language('company/smartlockerSize/smartlockerSize','tSMSSize')?></label>
            <label class="xCNLabelFrm">
            <label class="xCNLabelFrm xWPageAdd" style="color: #aba9a9 !important;"> / <?php echo language('company/smartlockerSize/smartlockerSize','tSMSSizeAdd')?> </label> 
            <label class="xCNLabelFrm xWPageEdit hidden" style="color: #aba9a9 !important;"> / <?php echo language('company/smartlockerSize/smartlockerSize','tSMSSizeEdit')?> </label>   
        </div>

        <!--ปุ่มเพิ่ม-->
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  text-right">
            <button type="button" onclick="JSxGetSHPContentSmartLockerSize();" class="btn" style="background-color: #D4D4D4; color: #000000;">
                <?php echo language('company/shopgpbypdt/shopgpbypdt', 'tSGPPBTNCancel')?>
            </button>
            <?php if($aAlwEventSmartlockerSize['tAutStaFull'] == 1 || ($aAlwEventSmartlockerSize['tAutStaAdd'] == 1 || $aAlwEventSmartlockerSize['tAutStaEdit'] == 1)) : ?>
                    <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" id="obtGpShopBySHPSave" onclick="JSvSMSAddEdit('<?= $tRoute?>')"> <?php echo  language('common/main/main', 'tSave')?></button>
            <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
            <!-- Add image -->
            <div class="col-lg-4 col-md-4 col-xs-4">
                <div class="upload-img" id="oImgUpload">
                    <input type="hidden" name="oetImgInputMain" id="oetImgInputMain"   data-validate-required = "<?= language('company/smartlockerSize/smartlockerSize','tSMSVaSizeName')?>">
                        <?php
                            if(isset($tImgObjAll) && !empty($tImgObjAll)){
                                $tFullPatch = './application/modules/'.$tImgObjAll;
                                if (file_exists($tFullPatch)){
                                    $tPatchImg = base_url().'/application/modules/'.$tImgObjAll;
                                }else{
                                    $tPatchImg = base_url().'application/modules/common/assets/images/200x200.png';
                                }
                            }else{
                                $tPatchImg = base_url().'application/modules/common/assets/images/200x200.png';
                            }
                        ?>      
                    <img id="oimImgMasterSmartLockerSize"   class="img-responsive xCNImgCenter" style="width: 100%;" id="" src="<?php echo @$tPatchImg;?>">
                </div>
                <div class="xCNUplodeImage">	
                    <input type="text" class="xCNHide" id="oetImgInputSmartLockerSize"      name="oetImgInputSmartLockerSize"       value="<?php echo @$tImgName;?>">
                    <input type="text" class="xCNHide" id="oetImgInputSmartLockerSizeOld"   name="oetImgInputSmartLockerSizeOld"    value="<?php echo @$tImgName;?>">
                    <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('','','SmartLockerSize','4/4')">  <i class="fa fa-picture-o xCNImgButton"></i> <?php echo language('common/main/main','tSelectPic')?></button>
                </div>
            </div>

            <!-- End GenCode -->
            <div class="col-lg-6 col-md-6 col-xs-6">
                <div class="form-group">
                <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('company/smartlockerSize/smartlockerSize', 'tSizeCode'); ?><?= language('company/smartlockerSize/smartlockerSize', 'tSMSSize'); ?></label>                    
                        <div id="odvShopSizeAutoGenCode" class="form-group">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbShopSizeAutoGenCode" name="ocbShopSizeAutoGenCode" checked="true" value="1">
                                    <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                </label>
                            </div>
                        </div>
                    <div class="form-group" id="odvShopSizeCodeForm">
                        <input type="hidden" id="ohdCheckDuplicateSMSCode" name="ohdCheckDuplicateSMSCode" value="1"> 
                            <div class="validate-input">
                                <input 
                                    type="text" 
                                    class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                                    maxlength="5" 
                                    id="oetPzeCode" 
                                    name="oetPzeCode"
                                    data-is-created="<?php echo $tPzeCode;?>"
                                    autocomplete="off"
                                    placeholder="<?php echo language('company/smartlockerSize/smartlockerSize','tSizeCode')?>"
                                    value="<?php echo $tPzeCode;?>" 
                                    data-validate-required = "<?php echo language('company/smartlockerSize/smartlockerSize','tSMSVaSizeCode')?>"
                                    data-validate-dublicateCode = "<?php echo language('company/smartlockerSize/smartlockerSize','tSMSVaSizeCheckCode')?>"
                                >
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('company/smartlockerSize/smartlockerSize','tSizeName'); ?></label>
                    <input type="text" class="form-control" id="oetSizName" name="oetSizName" maxlength="30" autocomplete="off" value="<?php echo $tSizName; ?>" placeholder="<?php echo language('company/smartlockerSize/smartlockerSize','tSizeName')?>"
                    data-validate-required = "<?= language('company/smartlockerSize/smartlockerSize','tSMSVaSizeName')?>"
                    >
                </div>
                <div class="form-group">
                <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('company/smartlockerSize/smartlockerSize','tSizeDim'); ?> <?= language('company/smartlockerSize/smartlockerSize','tSizeMm'); ?></label>
                    <input type="text" class="form-control xCNInputNumericWithDecimal text-right" autocomplete="off" id="oetPzeDim" name="oetPzeDim" maxlength="30" value="<?php echo number_format($tPzeDim,$nDecimalShow); ?>" placeholder="<?php echo language('company/smartlockerSize/smartlockerSize','tSizeDim')?> <?= language('company/smartlockerSize/smartlockerSize','tSizeMm'); ?>"
                    data-validate-required = "<?= language('company/smartlockerSize/smartlockerSize','tSMSVaSizeDim')?>"
                    >
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('company/smartlockerSize/smartlockerSize','tSizeWidth'); ?> <?= language('company/smartlockerSize/smartlockerSize','tSizeMm'); ?></label>
                    <input type="text" class="form-control xCNInputNumericWithDecimal text-right"  autocomplete="off" id="oetPzeHigh" name="oetPzeHigh" maxlength="30" value="<?php echo number_format($tPzeHigh,$nDecimalShow); ?>" placeholder="<?php echo language('company/smartlockerSize/smartlockerSize','tSizeWidth')?> <?= language('company/smartlockerSize/smartlockerSize','tSizeMm'); ?>"
                    data-validate-required = "<?= language('company/smartlockerSize/smartlockerSize','tSMSVaSizeWidth')?>"
                    >
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('company/smartlockerSize/smartlockerSize','tSizeHeight'); ?> <?= language('company/smartlockerSize/smartlockerSize','tSizeMm'); ?></label>
                    <input type="text" class="form-control  xCNInputNumericWithDecimal text-right" id="oetPzeWide" autocomplete="off"  name="oetPzeWide" maxlength="30" value="<?php echo number_format($tPzeWide,$nDecimalShow); ?>" placeholder="<?php echo language('company/smartlockerSize/smartlockerSize','tSizeHeight')?> <?= language('company/smartlockerSize/smartlockerSize','tSizeMm'); ?>"
                    data-validate-required = "<?= language('company/smartlockerSize/smartlockerSize','tSMSVaSizeHeight')?>"
                    >
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('company/smartlockerSize/smartlockerSize','tSMSSizeRemark'); ?></label>
                    <textarea class="form-group" rows="4" maxlength="100" id="oetSizRemark" name="oetSizRemark" autocomplete="off" placeholder="<?php echo language('company/smartlockerSize/smartlockerSize','tSMSSizeRemark')?>"><?php echo $tRemark; ?></textarea>
                </div>

            </div>
        </div>
    </div>
</form>

<?php include "script/jSmartlockerSizeMain.php"; ?>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
