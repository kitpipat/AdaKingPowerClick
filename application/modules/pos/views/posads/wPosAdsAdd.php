<?php
    if($nStaAddOrEdit == "1"){
        $tBchCode           = $aResult['raItems']['rtBchCode'];
        $tShpCode           = $aResult['raItems']['rtShpCode'];
        $tPosCode           = $aResult['raItems']['rtPosCode'];
        $tPsdSeq            = $aResult['raItems']['rtPsdSeq'];
        $tPsdPosition       = $aResult['raItems']['rtPsdPosition'];
        $tAdvertiseCode     = $aResult['raItems']['rtAdvCode'];
        $tAdvertiseName     = $aResult['raItems']['rtAdvName'];
        $tPsdWide           = $aResult['raItems']['rtPsdWide'];
        $tPsdHigh           = $aResult['raItems']['rtPsdHigh'];
        $dDateStart         = $aResult['raItems']['rtDateStart'];
        $dDateStop          = $aResult['raItems']['rtDateStop'];
        //route
        $tRoute         	= "posAdsEventEdit";
    }else{
        $tBchCode           = $tBchCodeMaster;
        $tShpCode           = $tShpCodeMaster;
        $tPosCode           = $tPosCodeMaster;
        $tPsdSeq            = "";
        $tPsdPosition       = "";
        $tAdvertiseCode     = "";
        $tAdvertiseName     = "";
        $tPsdWide           = "";
        $tPsdHigh           = "";
        $dDateStart         = "";
        $dDateStop          = "";
        //route
        $tRoute            = "posAdsEventAdd";
    }
?>
<input type="hidden" id="ohdPsdPosition" name="ohdPsdPosition" value="<?php echo $tPsdPosition?>">
<input type="hidden" id="ohdPsdWide"     name="ohdPsdWide"     value="<?php echo $tPsdWide?>">
<input type="hidden" id="ohdPsdHigh"     name="ohdPsdHigh"     value="<?php echo $tPsdHigh?>">
<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmPosAsd">
    <button style="display:none" type="submit" id="obtSubmitPosAds" onclick="JSoAddEditPosAds('<?php echo $tRoute; ?>')"></button>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-xs-5 col-sm-5">
                    <!-- เพิ่ม pk -->
                    <input type="hidden" id="ohdBchCodeAds"     name="ohdBchCodeAds"    value="<?php echo $tBchCode?>">
                    <input type="hidden" id="ohdAdsShpCodeAds"  name="ohdAdsShpCodeAds" value="<?php echo $tShpCode?>">
                    <input type="hidden" id="ohdAdsPosCodeAds"  name="ohdAdsPosCodeAds" value="<?php echo $tPosCode?>">
                    <input type="hidden" id="ohdAdsPsdSeq"      name="ohdAdsPsdSeq"     value="<?php echo $tPsdSeq?>">

                    <!-- เวลาเริ่ม สิ้นสุด -->
                    <input type="hidden" id="ohdAdsStart"  name="ohdAdsStart"  value="<?php echo $dDateStart ?>">
                    <input type="hidden" id="ohdAdsStop"   name="ohdAdsStop"   value="<?php echo $dDateStop  ?>">

                    <!-- โฆษณา -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('pos/posads/posads','tBAdsAdvertise')?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetPosAdvertiseCode" name="oetPosAdvertiseCode" value="<?php echo @$tAdvertiseCode; ?>" data-validate="<?php echo  language('pos/posads/posads','tADSValiAdvertiseCode');?>">
                            <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetPosAdvertiseName" name="oetPosAdvertiseName" value="<?php echo @$tAdvertiseName; ?>" data-validate="<?php echo  language('pos/posads/posads','tADSValiAdvertiseName');?>" readonly>
                            <span class="input-group-btn">
                                <button id="obtBrowseAdvertise" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>
                    <!-- ตำแหน่ง -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?=language('pos/posads/posads','tBAdsPosition')?></label>
                        <select class="selectpicker form-control" id="ocmPosition" name="ocmPosition" maxlength="1">
                            <option value = "TL"><?php echo language('pos/posads/posads','tAdsPositionTL');?></option>
                            <option value = "TM"><?php echo language('pos/posads/posads','tAdsPositionTM');?></option>
                            <option value = "TR"><?php echo language('pos/posads/posads','tAdsPositionTR');?></option>
                            <option value = "ML"><?php echo language('pos/posads/posads','tAdsPositionML');?></option>
                            <option value = "MM"><?php echo language('pos/posads/posads','tAdsPositionMM');?></option>
                            <option value = "MR"><?php echo language('pos/posads/posads','tAdsPositionMR');?></option>
                            <option value = "BL"><?php echo language('pos/posads/posads','tAdsPositionBL');?></option>
                            <option value = "BM"><?php echo language('pos/posads/posads','tAdsPositionBM');?></option>
                            <option value = "BR"><?php echo language('pos/posads/posads','tAdsPositionBR');?></option>
                            <option value = "AL"><?php echo language('pos/posads/posads','tAdsPositionAL');?></option>
                        </select>
                    </div>  
                    <!-- ความกว้าง -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?=language('pos/posads/posads','tAdsWidth')?></label>
                        <select class="selectpicker form-control" id="ocmPosWidth" name="ocmPosWidth" maxlength="1">
                            <option value= "1"><?php echo language('pos/posads/posads','tAdsWidth1') ?></option>
                            <option value= "2"><?php echo language('pos/posads/posads','tAdsWidth2') ?></option>
                            <option value= "3"><?php echo language('pos/posads/posads','tAdsWidth3') ?></option>
                            <option value= "4"><?php echo language('pos/posads/posads','tAdsWidth4') ?></option>
                            <option value= "5"><?php echo language('pos/posads/posads','tAdsWidth5') ?></option>
                            <option value= "6"><?php echo language('pos/posads/posads','tAdsWidth6') ?></option>
                            <option value= "7"><?php echo language('pos/posads/posads','tAdsWidth7') ?></option>
                            <option value= "8"><?php echo language('pos/posads/posads','tAdsWidth8') ?></option>
                        </select>
                    </div> 
                    <!-- ความสูง -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?=language('pos/posads/posads','tAdsHeigh')?></label>
                        <select class="selectpicker form-control" id="ocmPosHeigh" name="ocmPosHeigh" maxlength="1">
                            <option value= "1"><?php echo language('pos/posads/posads','tAdsHeigh1') ?></option>
                            <option value= "2"><?php echo language('pos/posads/posads','tAdsHeigh2') ?></option>
                            <option value= "3"><?php echo language('pos/posads/posads','tAdsHeigh3') ?></option>
                            <option value= "4"><?php echo language('pos/posads/posads','tAdsHeigh4') ?></option>
                            <option value= "5"><?php echo language('pos/posads/posads','tAdsHeigh5') ?></option>
                            <option value= "6"><?php echo language('pos/posads/posads','tAdsHeigh6') ?></option>
                            <option value= "7"><?php echo language('pos/posads/posads','tAdsHeigh7') ?></option>
                            <option value= "8"><?php echo language('pos/posads/posads','tAdsHeigh8') ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-5 col-sm-5">
                    <img style="margin-top: 25px;" id="oimImagePosition" src="<?=base_url().'/application/modules/common/assets/images/pos/posads/TL.png'?>"> 
                </div>
            </div>
        </div>
    </div>  
</form>    
<?php include "script/jPosAdsDataTable.php"; ?>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script>
    $('#ocmPosition').change(function(e) {
        var tValue      = $(this).val();
        var tFileName   = "<?=base_url()?>"+'/application/modules/common/assets/images/pos/posads/'+tValue+'.png';
        $('#oimImagePosition').attr('src',tFileName);
    });

</script>