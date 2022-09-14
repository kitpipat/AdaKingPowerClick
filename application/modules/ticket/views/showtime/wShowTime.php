<div class="xCNMrgNavMenu">
    <div class="row xCNavRow" style="width:inherit;">
        <div class="xCNBchVMaster">
            <div class="col-xs-8 col-md-8">
                <ol id="oliMenuNav" class="breadcrumb">
                    <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('EticketEvent')"><?= language('ticket/event/event', 'tEventInformation') ?></li>
                     <li class="xCNLinkClick"><?= language('ticket/event/event', 'tManageEvents') ?></li>
                        </ol>
                            </div>
                                <div class="col-xs-12 col-md-4 text-right p-r-0">
                                    <div class="demo-button xCNBtngroup">
                                   
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
        <div class="xWPanalResult">     
    <div class="main-content">
<div class="panel panel-headline">
    <div class="panel-heading"> 
    <div class="row">
            <div class="col-xs-8 col-md-4 col-lg-4"></div>
                <div class="col-xs-4 col-md-8 col-lg-8 text-right">
                <?php if ($oAuthen['tAutStaAdd'] == '1'): ?>	            
                    <?php if ($oAuthen['tAutStaAdd'] == '1'): ?>
                        <?php if ($oEvent[0]->FDEvnFinish != ''): ?>
                            <?php if (date("Ymd") >= date("Ymd", strtotime($oEvent[0]->FDEvnFinish))): ?>				
                                <?php else: ?>		
                                    <button onclick="javascipt: JSxCallPageResult('<?= base_url() ?>EticketAddShowTime/<?php echo $nEvnID; ?>', '.xWPanalResult');" class="xCNBTNPrimeryPlus" type="button">+</button>
                                <?php endif; ?>
                            <?php else: ?>
                        <button onclick="javascipt: JSxCallPageResult('<?= base_url() ?>EticketAddShowTime/<?php echo $nEvnID; ?>', '.xWPanalResult');" class="xCNBTNPrimeryPlus" type="button">+</button>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>         
            </div>
            </div>
        <div class="row">
            <div class="col-xs-8 col-md-4 col-lg-4">
                <div class="form-group"> 
                    <label class="xCNLabelFrm"><?= language('common/main/main','tSearch')?><?= language('ticket/location/location', 'tLocationShow') ?></label>
                        <div class="input-group">
                            <input class="form-control" type="text" id="oetSHTLocName" name="oetSHTLocName" onkeyup="javascript: if (event.keyCode == 13) { event.preventDefault(); JSxShowTimeListView() }">
                            <span class="input-group-btn">
                            <button class="btn xCNBtnSearch" type="button" onclick="JSxShowTimeListView()">
                            <img  class="xCNIconAddOn" src="<?php echo base_url().'application/modules/common/assets/images/icons/search-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>       
        </div>
    <div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:36px;">
<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
        <?= language('common/main/main','tCMNOption')?>
            <span class="caret"></span>
                </button>
                    <ul class="dropdown-menu" role="menu">
                        <li id="oliBtnDeleteAll" class="disabled">
                            <a data-toggle="modal" data-target="#odvmodaldelete"><?= language('common/main/main','tDelAll')?></a>
                        </li>
                    </ul>
                </div>
            </div>	
        </div>
        <div id="oResultLocationShowTime"></div>			
        <div class="row"> 
        <div class="col-md-4 text-left grid-resultpage"><?= language('ticket/zone/zone', 'tFound') ?> <span id="ospTotalRecord"> 0</span> <?= language('ticket/zone/zone', 'tList') ?> <a	class="xWBoxLocPark" style="color: rgb(51, 51, 51); text-decoration: none;"><?= language('ticket/zone/zone', 'tShowpage') ?> <span id="ospPageActiveShowTime">0</span> / <span id="ospTotalPageShowTime">0</span></a></div>
        <div class="col-md-8 text-right xWGridFooter xWBoxLocPark"></div>
        </div>
        </div>
    </div>
  </div>
  </div>  



<input type="hidden" value="<?php echo $nEvnID; ?>" id="ohdGetEventId">

<!-- Load Lang Eticket -->
<?php if ($_SESSION['lang'] == 'en'):?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jEN.js"></script>
<?php else:?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jTH.js"></script>
<?php endif?>

<script type="text/javascript" src="<?php echo base_url('application/modules/ticket/assets/src/showtime/jShowTime.js'); ?>"></script>
<script>
    JSxSHTCount();
</script> 