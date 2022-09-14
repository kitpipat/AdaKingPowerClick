<div class="row">
    <div class="col-xs-8 col-md-4 col-lg-4" style="position: absolute;top: -63px;left: 13%;">
        <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
            <div class="input-group">
                <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAll" name="oetSearchAll" onkeyup="Javascript:if(event.keyCode==13) JSvBchSetConnectionList()" value="<?=@$tSearch?>" placeholder="<?php echo language('common/main/main','tPlaceholder')?>">
                <span class="input-group-btn">
                    <button class="btn xCNBtnSearch" type="button" onclick="JSvBchSetConnectionList()">
                        <img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                    </button>
                </span>
            </div>
        </div>
    </div>

    <!--ปุ่มเพิ่ม-->
    <div class="col-xs-8 col-md-4 col-lg-4 text-right" style="position: absolute;top: -63px;right: 0px;">
        <?php if($aAlwEventBchSettingCon['tAutStaFull'] == 1 || $aAlwEventBchSettingCon['tAutStaDelete'] == 1 ) : ?>  
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
        <?php endif;?>
        <?php if($aAlwEventBchSettingCon['tAutStaFull'] == 1 || $aAlwEventBchSettingCon['tAutStaAdd'] == 1) : ?>
            <button id="obtBchSetConnection" name="obtBchSetConnection" class="xCNBTNPrimeryPlus" type="button" style="margin-left: 20px; margin-top: 0px;" onclick="JSvCallPageBchSetConnectionAdd()">+</button>
        <?php endif;?>
    </div>


    <!--content-->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="odvContentBchSetConnectionDataTable"></div>
    </div>
</div>

<!--SettingConnection  ที่กำลังจะสร้างข้อมูลการเชื่อมต่อ -->
<?php
    $tBchCode    = $aBchCodeSetConnect['tBchCode'];
?>
<input type="hidden" id="ohdBchCode" name="ohdBchCode" value="<?=$tBchCode?>">
<?php include "script/jSettingConnectionMain.php"; ?>
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>


