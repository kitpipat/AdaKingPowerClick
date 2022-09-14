<input id="oetCrdHisStaBrowse" type="hidden" value="<?php echo $nCrdHisBrowseType?>">
<input id="oetCrdHisCallBackOption" type="hidden" value="<?php echo $tCrdHisBrowseOption?>">


<?php if(isset($nCrdHisBrowseType) && $nCrdHisBrowseType == 0) : ?>
    <div id="odvCrdHisMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('cardhistory/0/0');?> 
                        <li id="oliCrdHisTitle" class="xCNLinkClick" onclick="JSvCallPageCardHistoryList()" style="cursor:pointer"><?php echo language('payment/card/card','tCardHistory')?></li> <!-- เปลี่ยน -->
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="xCNMenuCump xCNCrdBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>

    <div class="main-content">
        <div id="odvContentPageCardHis" class="panel panel-headline">
        </div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tCrdHisBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPvnNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tCrdHisBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('payment/card/card','tCardHistory')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPvnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif;?>

<script src="<?php echo base_url(); ?>application/modules/payment/assets/src/cardhistory/jCardhistory.js"></script>


