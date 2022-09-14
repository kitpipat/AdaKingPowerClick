<div class="row">
    <div class="col-xs-12 col-md-4">
        <div class="form-group" id="odvBtnMacPhwSearch">
            <label class="xCNLabelFrm"><?php echo language('common/main/main','tSearchNew')?></label>
            <div class="input-group">
                <input type="text" class="form-control xCNInputWithoutSpc" id="oetSearchPosAds" name="oetSearchPosAds" onkeypress="Javascript:if(event.keyCode==13) JSvPosAdsDataTable()" autocomplete="off"  placeholder="<?php echo language('common/main/main','tPlaceholder'); ?>">
                <span class="input-group-btn">
                    <button class="btn xCNBtnSearch" type="button" onclick="JSvPosAdsDataTable()" id="obtSearchPosAds" name="obtSearchPosAds">
                        <img class="xCNIconBrowse" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                    </button>
                </span>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-8 text-right">
        <div class="text-right" style="width:100%; margin-top: 25px;">
            <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                    <?= language('common/main/main','tCMNOption')?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li id="oliBtnDeleteAll" class="disabled">
                    <a data-toggle="modal" data-target="#odvModalDeleteMutirecord"><?= language('common/main/main','tDelAll')?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div id="ostDataPosAds"></div>
