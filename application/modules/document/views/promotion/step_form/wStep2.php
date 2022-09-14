<style>
    #odvPromotionStep2 .panel-body.xCNPDModlue {
        max-height: 300px;
        min-height: 300px;
        overflow: scroll;
    }
    #odvPromotionStep2 .panel-body.xCNPDModlue.xCNAll {
        max-height: 1000px;
        min-height: 1000px;
        overflow: scroll;
    }
    .xCNPromotionStep2GroupNameType1 .xCNPromotionStep2GroupNameType1Item .close {
        display: none;
    }
    .xCNPromotionStep2GroupNameType2 .xCNPromotionStep2GroupNameType2Item .close {
        display: none;
    }
    .xCNPromotionStep2ActiveBackground {
        background-color: #f2f2f5;
    }
</style>
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <!--Section : กลุ่มร่วมรายการ-->
                <div class="panel panel-default" style="margin-bottom: 10px;">
                    <div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                        <label class="xCNTextDetail1"><?php echo language('document/promotion/promotion', 'tJoiningGroup'); ?></label>
                    </div>

                    <div class="panel-collapse collapse in" role="tabpanel">
                        <div class="panel-body xCNPDModlue xCNAll xCNPromotionStep2GroupNameType1">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <!--Section : กลุ่มซื้อ-->
                <div class="panel panel-default" style="margin-bottom: 10px;">
                    <div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                        <label class="xCNTextDetail1"><?php echo language('document/promotion/promotion', 'tBuyGroup'); ?></label>
                    </div>

                    <div class="panel-collapse collapse in" role="tabpanel">
                        <div class="panel-body xCNPDModlue xCNPromotionStep2GroupBuy">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <!--Section : กลุ่มรับ-->
                <div class="panel panel-default" style="margin-bottom: 10px;">
                    <div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                        <label class="xCNTextDetail1"><?php echo language('document/promotion/promotion', 'tGetGroup'); ?></label>
                    </div>

                    <div class="panel-collapse collapse in" role="tabpanel">
                        <div class="panel-body xCNPDModlue xCNPromotionStep2GroupGet">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <!--Section : กลุ่มยกเว้น-->
                <div class="panel panel-default" style="margin-bottom: 10px;">
                    <div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                        <label class="xCNTextDetail1"><?php echo language('document/promotion/promotion', 'tExclusionGroup'); ?></label>
                    </div>

                    <div class="panel-collapse collapse in" role="tabpanel">
                        <div class="panel-body xCNPDModlue xCNPromotionStep2GroupNameType2">
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>

<?php include_once('script/jStep2.php'); ?>