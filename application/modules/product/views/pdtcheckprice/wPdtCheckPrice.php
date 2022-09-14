<input id="oetPCPCheckpriceBrowse" type="hidden" value="<?php echo $nPIBrowseType ?>">
<input id="oetPCPCallBackOption" type="hidden" value="<?php echo $tPIBrowseOption ?>">
<div id="odvPCPMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <ol id="oliPCPMenuNav" class="breadcrumb">
                    <?php FCNxHADDfavorite('dasPDTCheckProductPrice/0/0');?>
                    <li id="oliPCPTitle" style="cursor:pointer;" onclick="JSxPCPFromSearchList()"> 
                        <?php echo language('product/pdtcheckprice/pdtcheckprice', 'tPCPTitle'); ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="xCNMenuCump xCNPIBrowseLine" id="odvPCPMenuCump">&nbsp;</div>
<div class="main-content">
    <div id="odvPCPContentPageDocument">
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url('application/modules/product/assets/src/pdtcheckprice/jPdtcheckprice.js'); ?>"></script>