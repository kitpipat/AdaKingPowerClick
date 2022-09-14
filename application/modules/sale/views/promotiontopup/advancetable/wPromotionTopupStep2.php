<?php if(!$bIsApvOrCancel) { ?>
    <div class="row">
        <div class="col-md-4">

            <label id="olbPTUStep2AutoGen" class="fancy-checkbox" style="margin-top:10px;">
                <input type="checkbox" id="ocbPTURefExAutoGen" name="ocbPTURefExAutoGen" checked="true" value="1">
                <span><?= language('sale/promotiontopup/promotiontopup', 'สร้างหมายเลขอ้างอิงอัตโนมัติ'); ?></span>
            </label>

        </div>
        <div class="col-md-8">
            <button type="button" class="xCNBTNPrimeryPlus pull-right" id="obtPTUStep2AddCondition" style="margin-bottom: 10px;">+</button>
        </div>
    </div>
<?php } ?>

<div class="row">
    <div class="col-md-12">
        <div id="odvPTUDataTableStep2"></div>
    </div>
</div>
    
<?php include_once('script/jPromotionTopupStep2.php'); ?>