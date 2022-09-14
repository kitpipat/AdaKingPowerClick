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

<div id="odvControlEventButtonTitle" class="row"> 
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p style="font-weight: bold;"><?=language('company/rack/rack','tRckDataTitle')?></p>
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
                        <a data-toggle="modal" data-target="#odvModalDelRack"><?=language('common/main/main','tDelAll')?></a>
                    </li>
                </ul>
            </div>
        <button id="obtSMLLayout" name="obtSMLLayout" class="xCNBTNPrimeryPlus" type="button" style="margin-left: 20px; margin-top: 0px;" onclick="SHPSmartLockerrackPageAdd()">+</button>
	</div>
	
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
	</div>
    <!--content-->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="odvContentRackDataTable" class="row"></div>
    </div>
</div>
<?php include "script/jSmartlockerRackMain.php"; ?>
