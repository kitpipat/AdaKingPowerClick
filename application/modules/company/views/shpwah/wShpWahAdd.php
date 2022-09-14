<?php
    if($aResult['rtCode'] == 1){

        $tShpWahCode       	= $aResult['raItems']['FTWahCode'];
        $tShpWahName        = $aResult['raItems']['FTWahName'];

        //route edit
        $tRoute      = "ShpWahEventEdit";

    }else{

        $tShpWahCode    = "";
        $tShpWahName    = "";

        //route  add
        $tRoute     = "ShpWahEventAdd";
    }

?>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddEditShpWah">
    <input type="hidden" value="<?php echo $tRoute; ?>" id="ohdTRoute">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <label class="xCNLabelFrm" style="color: #179bfd !important; cursor:pointer;" onclick="JSxShpWahGetContent();" ><?php echo language('company/shop/shop','tShpWahTitle')?></label>
            <label class="xCNLabelFrm xWPageAdd" style="color: #aba9a9 !important;"> / <?php echo language('company/shop/shop','tShpWahAdd')?> </label> 
            <label class="xCNLabelFrm xWPageEdit hidden" style="color: #aba9a9 !important;"> / <?php echo language('company/shop/shop','tShpWahEdit')?> </label>   
        </div>

        <!--ปุ่มเพิ่ม-->
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  text-right">
            <button type="button" onclick="JSxShpWahGetContent();" class="btn" style="background-color: #D4D4D4; color: #000000;">
                <?php echo language('common/main/main', 'tCancel')?>
            </button>
                <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" id="obtUsrloginSave" onclick="JSxShpWahSaveAddEdit('<?=$tRoute?>')"> <?php echo  language('common/main/main', 'tSave')?></button>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <!-- Browse คลังสินค้า Type 4 only -->
                <div class="form-group" id="odvWhaShop">
                    <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPWah')?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNHide" id="oetBchCode1" name="oetBchCode1">
                        <input type="text" class="form-control xCNHide" id="oetShpWahCode1" name="oetShpWahCode1" value="<?=@$tShpWahCode?>">
                        <input type="text" class="form-control xWPointerEventNone" id="oetShpWahName" name="oetShpWahName" value="<?php echo @$tShpWahName?>" 
                        placeholder="<?php echo language('company/shop/shop','tSHPWah')?>"
                        data-validate-required = "<?php echo language('company/warehouse/warehouse','tWAHValidbch')?>"
                        readonly>
                        <span class="input-group-btn">
                            <button id="oimBrowseShopWah" type="button" class="btn xCNBtnBrowseAddOn">
                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        $tShopCode   = $aDataShp['tShopCode'];
        $tBchCode    = $aDataShp['tBchCode'];
    ?>
    <input  type="hidden" id="oetShopCode" name="oetShopCode" value="<?=$tShopCode?>">
    <input type="hidden" id="oetBchCode" name="oetBchCode" value="<?=$tBchCode?>">
</form>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jShpWahMain.php";?>