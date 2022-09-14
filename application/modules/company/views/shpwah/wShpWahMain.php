<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p style="font-weight: bold;"><?=language('company/shop/shop','tShpWahTitle')?></p>
    </div>

    <!--ปุ่มเพิ่ม-->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
        <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
            <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                <?=language('common/main/main','tCMNOption')?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li id="oliBtnDeleteAll" class="disabled">
                    <a data-toggle="modal" data-target="#odvModalDeleteMutirecord"><?=language('common/main/main','tDelAll')?></a>
                </li>
            </ul>
        </div>
        <button id="obtShpWah" name="obtShpWah" class="xCNBTNPrimeryPlus" type="button" style="margin-left: 20px; margin-top: 0px;" onclick="JSvCallPageShpWahAdd()">+</button>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
     <!--content-->
     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="odvContentShpWahDataTable"></div>
    </div>
</div>
<!-- ShopCode  -->
<?php  $tShpCode  = $aShpWahCode['tShpCode'] ?>
<?php  $tBchCode  = $aShpWahCode['tBchCode'] ?>
<input type="hidden" id="oetShopCode" name="oetShopCode" value="<?=$tShpCode?>">
<input type="hidden" id="oetBchCode" name="oetBchCode" value="<?=$tBchCode?>">
<?php include "script/jShpWahMain.php";?>

