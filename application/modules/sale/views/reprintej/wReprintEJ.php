<input type="hidden" id="ohdEJBrowseType"   value="<?php echo $nEJBrowseType;?>">
<input type="hidden" id="ohdEJBrowseOption" value="<?php echo $tEJBrowseOption;?>">
<!-- Title Bar Menu EJ -->
<div id="odvEJMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <ol id="oliEJMenuNav" class="breadcrumb">
                    <?php FCNxHADDfavorite('dcmReprintEJ/0/0');?>
                    <li id="oliEJTitle" style="cursor:pointer;"><?php echo language('sale/reprintej/reprintej', 'tEJTitleMenu'); ?></li>
                </ol>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
                <div class="demo-button xCNBtngroup" style="width:100%;">
                    <?php if($aAlwEventEJ['tAutStaPrint'] == 1 || $aAlwEventEJ['tAutStaPrintMore'] == 1):?>
                        <button id="obtEJReprintAbb" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('common/main/main', 'tCMNPrint'); ?></button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Menu Cump EJ -->
<div class="xCNMenuCump xCNEJBrowseLine" id="odvMenuCump">&nbsp;</div>
<!-- Div Content EJ -->
<div class="main-content">
    <div id="odvContentPageEJ"></div>
</div>
<script type="text/javascript" src="<?php echo base_url();?>application/modules/sale/assets/src/reprintej/jReprintEJ.js"></script>