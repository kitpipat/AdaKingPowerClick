
<!--เนื้อหา-->
<div id="odvTabCstlogin" class="tab-pane fade" style="width: 100%;"></div>

<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p style="font-weight: bold;"><?=language('customer/customer/customer','tCSTTabDetailCstlogin')?></p>
    </div>


    <!--ปุ่มเพิ่ม-->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
        <?php //if($aAlwEventCstlogin['tAutStaFull'] == 1 || $aAlwEventCstlogin['tAutStaDelete'] == 1 ) : ?>
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
        <?php //endif; ?>
        <button id="obtSMLLayout" name="obtSMLLayout" class="xCNBTNPrimeryPlus" type="button" style="margin-left: 20px; margin-top: 0px;" onclick="JSvCallPageCstloginAdd()">+</button>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>

    <!--content-->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="odvContentCstloginDataTable"></div>
    </div>


    <input type="hidden" id="ohdCstLogCode" name="ohdCstLogCode" value="<?=$tCstCode;?>">
</div>

<?php include "script/jCstloginMain.php"; ?>
