<style>
    .xWBKLTextStatus {
        color: black !important;
        width: 100% !important;
        text-align: center !important;
        vertical-align: top !important;
    }

    .xWBKLColorBooking {
        background-color: #f1d342;
        height: 20px;
        width: 30px;
        display: inline-block;
        margin-right: 5px;
    }

    .xWBKLColorEmpty{
        background-color: #0081c2;
        height: 20px;
        width: 30px;
        display: inline-block;
        margin-right: 5px;
    }

    .xWBKLColorUsing{
        background-color: #d63031;
        height: 20px;
        width: 30px;
        display: inline-block;
        margin-right: 5px;
    }

    .xWBKLColorNotUsing {
        background-color: #636e72;
        height: 20px;
        width: 30px;
        display: inline-block;
        margin-right: 5px;
    }

    #odvBKLBoxShowNumberLocker #odvContentDataNumberLocker{
       display: block;
       height: 290px;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading xCNPanelHeadColor">
                <label class="xCNTextDetail1"><?php echo language('sale/bookinglocker/bookinglocker','tBKLPanelCondition');?></label>
            </div>
            <div id="odvBKLPanelCondition" class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body">
                    <form id="ofmBKLConditionFilter" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                        <input type="text" class="form-control xCNHide" id="oetBKLDataLayNoSelect" name="oetBKLDataLayNoSelect">
                        <input type="text" class="form-control xCNHide" id="oetBKLDataStaPageEvent" name="oetBKLDataStaPageEvent">
                        <button style="display:none" type="submit" id="obtBKLSubmitGetDataRack" onclick="JSoBKLGetDataViewStatusRack()"></button>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <!-- Filter Condition Branch -->
                                <div id="odvBKLFilterBranch" class="form-group">
                                    <label class='xCNLabelFrm'><?php echo language('sale/bookinglocker/bookinglocker','tBKLFilterBranch');?></label>
                                    <div class='input-group'>
                                        <input type="text" class="form-control xCNHide xWInputBranch" id="oetBKLBchCodeOld"   name="oetBKLBchCodeOld" maxlength="5">
                                        <input type="text" class="form-control xCNHide xWInputBranch" id="oetBKLBchCode"      name="oetBKLBchCode"    maxlength="5">
                                        <input
                                            type="text"
                                            class="form-control xWPointerEventNone xWInputBranch"
                                            id="oetBKLBchName"
                                            name="oetBKLBchName"
                                            placeholder="<?php echo language('sale/bookinglocker/bookinglocker','tBKLFilterBranchPHD');?>"
                                            data-validate-required="<?php echo language('sale/bookinglocker/bookinglocker','tBKLValidateBranch');?>"
                                            readonly
                                        >
                                        <span class='input-group-btn'>
                                            <button id='obtBKLBrowseBranch' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Filter Condition Shop -->
                                <div id="odvBKLFilterShop" class="form-group <?php if(!FCNbGetIsShpEnabled()) : echo 'xCNHide';  endif;?>"> 
                                    <label class='xCNLabelFrm'><?php echo language('sale/bookinglocker/bookinglocker','tBKLFilterShop');?></label>
                                    <div class='input-group'>
                                        <input type="text" class="form-control xCNHide xWInputShop" id="oetBKLShpCodeOld"   name="oetBKLShpCodeOld" maxlength="5">
                                        <input type="text" class="form-control xCNHide xWInputShop" id="oetBKLShpCode"      name="oetBKLShpCode"    maxlength="5">
                                        <input
                                            type="text"
                                            class="form-control xWPointerEventNone xWInputShop"
                                            id="oetBKLShpName"
                                            name="oetBKLShpName"
                                            placeholder="<?php echo language('sale/bookinglocker/bookinglocker','tBKLFilterShopPHD');?>"
                                            data-validate-required="<?php echo language('sale/bookinglocker/bookinglocker','tBKLValidateShop');?>"
                                            readonly
                                        >
                                        <span class='input-group-btn'>
                                            <button id='obtBKLBrowseShop' type='button' class='btn xCNBtnBrowseAddOn' disabled><img class='xCNIconFind'></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Filter Condition Pos -->
                                <div id="odvBKLFilterPos" class="form-group">
                                    <label class='xCNLabelFrm'><?php echo language('sale/bookinglocker/bookinglocker','tBKLFilterPos');?></label>
                                    <div class='input-group'>
                                        <input type="text" class="form-control xCNHide xWInputPos" id="oetBKLPosCodeOld"   name="oetBKLPosCodeOld" maxlength="5">
                                        <input type="text" class="form-control xCNHide xWInputPos" id="oetBKLPosCode"      name="oetBKLPosCode"    maxlength="5">
                                        <input
                                            type="text"
                                            class="form-control xWPointerEventNone xWInputPos"
                                            id="oetBKLPosName"
                                            name="oetBKLPosName"
                                            placeholder="<?php echo language('sale/bookinglocker/bookinglocker','tBKLFilterPosPHD');?>"
                                            data-validate-required="<?php echo language('sale/bookinglocker/bookinglocker','tBKLValidatePos');?>"
                                            readonly
                                        >
                                        <span class='input-group-btn'>
                                            <button id='obtBKLBrowsePos' type='button' class='btn xCNBtnBrowseAddOn' <?php if(FCNbGetIsShpEnabled()) : echo 'disabled';  endif;?>><img class='xCNIconFind'></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Filter Condition Rack -->
                                <div id="odvBKLFilterRack" class="form-group">
                                    <label class='xCNLabelFrm'><?php echo language('sale/bookinglocker/bookinglocker','tBKLFilterRack');?></label>
                                    <div class='input-group'>
                                        <input type="text" class="form-control xCNHide xWInputRack" id="oetBKLRakCode"      name="oetBKLRakCode"    maxlength="5">
                                        <input
                                            type="text"
                                            class="form-control xWPointerEventNone xWInputRack"
                                            id="oetBKLRakName"
                                            name="oetBKLRakName"
                                            placeholder="<?php echo language('sale/bookinglocker/bookinglocker','tBKLFilterRackPHD');?>"
                                            data-validate-required="<?php echo language('sale/bookinglocker/bookinglocker','tBKLValidateRack');?>"
                                            readonly
                                        >
                                        <span class='input-group-btn'>
                                            <button id='obtBKLBrowseRack' type='button' class='btn xCNBtnBrowseAddOn'  <?php if(FCNbGetIsShpEnabled()) : echo 'disabled';  endif;?>><img class='xCNIconFind'></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-b-10">
                            <button type="button" id="obtBKLFilterData" class="btn btn-primary" style="font-size: 17px;width: 100%;">
                                <?php echo language('sale/bookinglocker/bookinglocker','tBKLBtnFilterData') ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading xCNPanelHeadColor">
                <label class="xCNTextDetail1"><?php echo language('sale/bookinglocker/bookinglocker','tBKLPanelViewLocker');?></label>
            </div>
            <div id="odvBKLPanelViewLocker" class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body">
                    <div id="odvBKLStatusLocker" class="row p-t-10 text-center">
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <div class="xWBKLColorBooking"></div>
                            <span class="xWBKLTextStatus"><?php echo language('sale/bookinglocker/bookinglocker','tBKLStaBooking');?></span>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <div class="xWBKLColorEmpty"></div>
                            <span class="xWBKLTextStatus"><?php echo language('sale/bookinglocker/bookinglocker','tBKLStaEmpty');?></span>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <div class="xWBKLColorUsing"></div>
                            <span class="xWBKLTextStatus"><?php echo language('sale/bookinglocker/bookinglocker','tBKLStaUsing');?></span>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <div class="xWBKLColorNotUsing"></div>
                            <span class="xWBKLTextStatus"><?php echo language('sale/bookinglocker/bookinglocker','tBKLStaNotUsing');?></span>
                        </div>
                    </div>
                    <div id="odvBKLViewLockerData" class="row p-t-10">
                        <div class="row" style="vertical-align:middle;display:grid;text-align:center;min-height:500px">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label id="olbBKLNotFoundRackStatus"> <?php echo language('sale/bookinglocker/bookinglocker','tBKLNotFoundDataRackStatus');?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading xCNPanelHeadColor">
                <label class="xCNTextDetail1"><?php echo language('sale/bookinglocker/bookinglocker','tBKLPanelNumberLocker');?></label>
            </div>
            <div id="odvBKLPanelViewNumberLocker" class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body">
                    <div class="row p-b-10">
                        <div id="odvBKLBoxShowNumberLocker" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div id="odvContentDataNumberLocker">
                                <div id="odvContentNumberLocker" style="border:1px solid #c7c7c7; width:100%; padding: 10px;height:100%">
                                    <label class="xCNLabelFrm" style="text-align: center; width: 100%; border-bottom: 1px solid #c7c7c7;">
                                        <?php echo language('sale/bookinglocker/bookinglocker','tBKLTextNumberLocker');?>
                                    </label>
                                    <label id="oliBKLLockerNumberIS" class="xCNLabelFrm" style="text-align:center;width:100%;font-size:8rem !important;"></label>
                                    <label id="oliBKLLockerStatus" class="xCNLabelFrm" style="text-align:center;width:100%;font-size:2rem !important;margin-top:-20px"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="odvBKLBoxButtonBookingGrp" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <button id="obtBKLBookingLockerAdd" type="button" class="btn btn-primary xCNHide" style="font-size:17px;width:100%;" disabled>
                                <?php echo language('sale/bookinglocker/bookinglocker','tBKLBtnBookingAdd');?>
                            </button>
                            <button id="obtBKLBookingLockerDetail" type="button" class="btn btn-primary xCNHide" style="font-size:17px;width:100%;" disabled>
                                <?php echo language('sale/bookinglocker/bookinglocker','tBKLBtnBookingDetail');?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="odvBKLModalDataContent"></div>
<?php include "script/jBookingLockerMain.php";?> 