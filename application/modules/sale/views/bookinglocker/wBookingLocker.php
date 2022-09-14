<input type="hidden" id="ohdBKLBrowseType"    value="<?php echo $nBKLBrowseType;?>">
<input type="hidden" id="ohdBKLBrowseOption"  value="<?php echo $tBKLBrowseOption;?>">

<div id="odvBKLMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <ol id="oliBKLMenuNav" class="breadcrumb">
                    <?php FCNxHADDfavorite('salBookingLocker/0/0');?>
                    <li id="oliBKLTitle" style="cursor:pointer;"><?php echo language('sale/bookinglocker/bookinglocker','tBKLTitleMenu');?></li>
                    <li id="oliBKLTitleAdd" class="active"><a><?php echo language('sale/bookinglocker/bookinglocker','tBKLTitleMenuAdd');?></a></li>
                </ol>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
                <div class="demo-button xCNBtngroup" style="width:100%;">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="xCNMenuCump xCNBKLBrowseLine" id="odvMenuCump">&nbsp;</div>
<div class="main-content">
    <div id="odvContentPageBKL"></div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>application/modules/sale/assets/src/bookinglocker/jBookingLocker.js"></script>