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

<input type="hidden" name="ohdSmartLockerTypeBCH" id="ohdSmartLockerTypeBCH"  value="<?=$tBchCode?>">
<input type="hidden" name="ohdSmartLockerTypeSHP" id="ohdSmartLockerTypeSHP"  value="<?=$tShpCode?>">

<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p style="font-weight: bold;"><?=language('company/shop/shop','tNameTabSmartLockerLayout')?></p>
    </div>
	
    <!--ปุ่มเพิ่ม-->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
    <?php if(@$tCheckShopType == ""){ ?>
        <button id="obtSMLLayout" name="obtSMLLayout" class="xCNBTNPrimeryPlus" type="button" style="margin-left: 20px; margin-top: 0px;" onclick="JSvCallPageSmartlockerTypeAdd()">+</button>
	<?php } ?>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>

    <!--content-->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="odvContentShopLayoutType"></div>
    </div>
</div>
<?php include "script/jSmartlockerType.php"; ?>
