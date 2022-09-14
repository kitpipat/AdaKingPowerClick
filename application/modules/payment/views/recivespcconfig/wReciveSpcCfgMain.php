
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p style="font-weight: bold;">ตั้งค่าการเชื่อมต่อ</p>
    </div>

    <!--ปุ่มเพิ่ม-->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
	<?php if($aAlwEventRcvSpc['tAutStaFull'] == 1 || $aAlwEventRcvSpc['tAutStaDelete'] == 1 ) : ?>
            <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                    <?php echo language('common/main/main','tCMNOption')?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li id="oliBtnDeleteAll" class="disabled">
                        <a data-toggle="modal" data-target="#odvModalDeleteMutirecordCfg"><?=language('common/main/main','tDelAll')?></a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
        <button id="obtSMLLayout" name="obtSMLLayout" class="xCNBTNPrimeryPlus" type="button" style="margin-left: 20px; margin-top: 0px;" onclick="JSvCallPageReciveSpcCfgAdd()">+</button>
	</div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>

    <!--content-->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="odvContentRcvSpcCfgDataTable"></div>
    </div>
</div>

<!-- RcvCode -->
<?php 
    $tRcvCode   = $aRcvCode['tRcvCode'];
    $tRcvName   = $aRcvName['tRcvName'];
?>
<input type="hidden" id= "ohdRcvSpcCode" name="ohdRcvSpcCode" value="<?=$tRcvCode;?>">
<input type="hidden" id= "ohdRcvSpcName" name="ohdRcvSpcName" value="<?=$tRcvName;?>">
<?php include "script/jReciveSpcCfgMain.php"; ?>
