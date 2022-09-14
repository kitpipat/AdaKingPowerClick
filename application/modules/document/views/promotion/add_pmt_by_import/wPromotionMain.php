<div class="custom-tabs-line tabs-line-bottom left-aligned">
    <ul class="nav" role="tablist">
        <li class="xCNBCHTab active" data-typetab="main" data-tabtitle="bchinfo">
            <a role="tab" data-toggle="tab" data-target="#odvSummaryHD" aria-expanded="true">
                Summary HD
            </a>
        </li>
        <li class="xCNBCHTab" data-typetab="sub" data-tabtitle="bchsetconnection">
            <a role="tab" data-toggle="tab" data-target="#odvPromotionGroup" aria-expanded="false" class="xCNPromotionGroup">
                Promotion Group
            </a>
        </li>
        <li class="xCNBCHTab" data-typetab="sub" data-tabtitle="bchaddress">
            <a role="tab" data-toggle="tab" data-target="#odvConditionBuy" aria-expanded="false" class="xCNPromotionConditionBuy">
                Condition-กลุ่มซื้อ
            </a>
        </li>
        <li class="xCNBCHTab" data-typetab="sub" data-tabtitle="bchaddress">
            <a role="tab" data-toggle="tab" data-target="#odvOption1" aria-expanded="false" class="xCNPromotionOption1">
                Option1-กลุ่มรับ(กรณีส่วนลด)
            </a>
        </li>
        <li class="xCNBCHTab" data-typetab="sub" data-tabtitle="bchaddress">
            <a role="tab" data-toggle="tab" data-target="#odvOption2" aria-expanded="false">
                Option2-กลุ่มรับ(กรณีcoupon)
            </a>
        </li>
        <li class="xCNBCHTab" data-typetab="sub" data-tabtitle="bchaddress">
            <a role="tab" data-toggle="tab" data-target="#odvOption3" aria-expanded="false">
                Option3-กลุ่มรับ(กรณีแต้ม)
            </a>
        </li>
    </ul>
</div>

<div class="tab-content">
    <div id="odvSummaryHD" class="tab-pane active in" style="margin-top:10px;" role="tabpanel" aria-expanded="true">
        <?php include('wPromotionHDTable.php'); ?>
    </div>

    <div id="odvPromotionGroup" class="tab-pane" style="margin-top:10px;" role="tabpanel" aria-expanded="true">
        <div class="row">
            <div class="col-xs-4 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('document/promotion/promotion','tLabel32'); ?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetPromotionImpPdtGroupSearchAll" name="oetPromotionImpPdtGroupSearchAll" onblur="JSxPromotionImportPdtGroupSearchDataInTable()" onkeyup="Javascript:if(event.keyCode==13) JSxPromotionImportPdtGroupSearchDataInTable()" value="" placeholder="กรอกคำค้นหา">
                        <span class="input-group-btn">
                            <button class="btn xCNBtnSearch" type="button" onclick="JSxPromotionImportPdtGroupSearchDataInTable()">
                                <img class="xCNIconAddOn" src="http://192.168.43.244/AdaSiamKubota/application/modules/common/assets/images/icons/search-24.png">
                            </button>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-xs-6 col-md-6 col-lg-6 text-right" style="margin-top:25px;">
                <span class="xCNPromotionPdtGroupSummaryImportText" style="display: block; font-weight: bold;"></span>
            </div>

            <div class="col-xs-2 col-md-2 col-lg-2 text-right" style="margin-top:25px;">
                <div class=""></div>
                <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown" aria-expanded="false">
                        ตัวเลือก <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li id="oliBtnDeleteAll" class="disabled" onclick="JSxPromotionImportPdtGroupConfirmDeleteInTempBySeqInTemp(this, 'M')">
                            <a>ลบทั้งหมด</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="odvPromotionImportExcelPdtGroupContainer"></div>
    </div>

    <div id="odvConditionBuy" class="tab-pane" style="margin-top:10px;" role="tabpanel" aria-expanded="true">
        <div class="row">
            <div class="col-xs-4 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('document/promotion/promotion','tLabel32'); ?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetPromotionImpCBSearchAll" name="oetPromotionImpCBSearchAll" onblur="JSxPromotionImportCBSearchDataInTable()" onkeyup="Javascript:if(event.keyCode==13) JSxPromotionImportCBSearchDataInTable()" value="" placeholder="<?php echo language('document/promotion/promotion','tLabel33'); ?>">
                        <span class="input-group-btn">
                            <button class="btn xCNBtnSearch" type="button" onclick="JSxPromotionImportCBSearchDataInTable()">
                                <img class="xCNIconAddOn" src="<?php echo base_url('application/modules/common/assets/images/icons/search-24.png'); ?>">
                            </button>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-xs-6 col-md-6 col-lg-6 text-right" style="margin-top:25px;">
                <span class="xCNPromotionCBSummaryImportText" style="display: block; font-weight: bold;"></span>
            </div>

            <div class="col-xs-2 col-md-2 col-lg-2 text-right" style="margin-top:25px;">
                <div class=""></div>
                <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown" aria-expanded="false">
                    <?php echo language('document/promotion/promotion','tOptions'); ?> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li id="oliBtnDeleteAll" class="disabled" onclick="JSxPromotionImportCBConfirmDeleteInTempBySeqInTemp(this, 'M')">
                            <a><?php echo language('document/promotion/promotion','tDeleteAll'); ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="odvPromotionImportExcelCBContainer"></div>
    </div>

    <div id="odvOption1" class="tab-pane" style="margin-top:10px;" role="tabpanel" aria-expanded="true">
        <div class="row">
            <div class="col-xs-4 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('document/promotion/promotion','tLabel32'); ?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetPromotionImpCGSearchAll" name="oetPromotionImpCGSearchAll" onblur="JSxPromotionImportCGSearchDataInTable()" onkeyup="Javascript:if(event.keyCode==13) JSxPromotionImportCGSearchDataInTable()" value="" placeholder="<?php echo language('document/promotion/promotion','tLabel33'); ?>">
                        <span class="input-group-btn">
                            <button class="btn xCNBtnSearch" type="button" onclick="JSxPromotionImportCGSearchDataInTable()">
                                <img class="xCNIconAddOn" src="<?php echo base_url('application/modules/common/assets/images/icons/search-24.png'); ?>">
                            </button>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-xs-6 col-md-6 col-lg-6 text-right" style="margin-top:25px;">
                <span class="xCNPromotionCGSummaryImportText" style="display: block; font-weight: bold;"></span>
            </div>

            <div class="col-xs-2 col-md-2 col-lg-2 text-right" style="margin-top:25px;">
                <div class=""></div>
                <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown" aria-expanded="false">
                    <?php echo language('document/promotion/promotion','tOptions'); ?> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li id="oliBtnDeleteAll" class="disabled" onclick="JSxPromotionImportCGConfirmDeleteInTempBySeqInTemp(this, 'M')">
                            <a><?php echo language('document/promotion/promotion','tDeleteAll'); ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="odvPromotionImportExcelCGContainer"></div>
    </div>

    <div id="odvOption2" class="tab-pane" style="margin-top:10px;" role="tabpanel" aria-expanded="true">
        <?php include('wPromotionCouponTable.php'); ?>
    </div>

    <div id="odvOption3" class="tab-pane" style="margin-top:10px;" role="tabpanel" aria-expanded="true">
        <?php include('wPromotionPointTable.php'); ?>
    </div>
</div>
<?php include('script/jPromotionMain.php'); ?>