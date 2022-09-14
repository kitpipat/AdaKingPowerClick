
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p style="font-weight: bold;"><?=language('courier//courier/courier','tCurloginTitle')?></p>
    </div>
	
    <!--ปุ่มเพิ่ม-->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
	<?php if($aAlwEventCURL['tAutStaFull'] == 1 || $aAlwEventCURL['tAutStaDelete'] == 1 ) : ?>
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
        <?php endif; ?>
        <button id="obtSMLLayout" name="obtSMLLayout" class="xCNBTNPrimeryPlus" type="button" style="margin-left: 20px; margin-top: 0px;" onclick="JSvCallPageCourierloginAdd()">+</button>
	</div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>

    <!--content-->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="odvContentCURLDataTable"></div>
    </div>
</div>

<!--Courier Man ที่กำลังจะสร้างข้อมูลล็อกอิน -->
<?php 
    $tCryLogCode    = $aCryManSetAuthen['tCryCode'];
    $tCryManCardID  = $aCryManSetAuthen['tCryManCardID'];
?>
<input type="hidden" id="ohdCryLogCode" name="ohdCryLogCode" value="<?=$tCryLogCode?>">
<input type="hidden" id="ohdCryLogCryManCardID" name="ohdCryLogCryManCardID" value="<?=$tCryManCardID?>">
<?php include "script/jCourierloginMain.php"; ?>
