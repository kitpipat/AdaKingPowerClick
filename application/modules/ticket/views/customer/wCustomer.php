<div class="xCNMrgNavMenu">
    <div class="row xCNavRow" style="width:inherit;">
        <div class="xCNBchVMaster">
            <div class="col-xs-8 col-md-8">
                <ol id="oliMenuNav" class="breadcrumb">
                    <li id="oliBCHTitle" class="xCNLinkClick"><?= language('ticket/customer/customer', 'tCustomerInformation') ?></li>
                        </ol>
                            </div>
                                <div class="col-xs-12 col-md-4 text-right p-r-0">
                            <div class="demo-button xCNBtngroup">
                        <button class="xCNBTNPrimeryPlus" type="submit" onclick="JSxCallPage('<?= base_url() ?>EticketCustomer/add')">+</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="main-content">
    <div class="panel panel-headline">
        <div class="panel-heading"> 
            <div class="row">
                <div class="col-xs-8 col-md-4 col-lg-4">
                    <div class="form-group"> 
                        <label class="xCNLabelFrm"><?= language('common/main/main','tSearch')?></label>
                            <div class="input-group">
                                <input class="form-control" type="text" id="oetSCHFTCstName" name="oetSCHFTCstName" onkeyup="javascript: if (event.keyCode == 13) {event.preventDefault(); JSxCstCount(); }">
                                    <span class="input-group-btn">
                                        <button class="btn xCNBtnSearch" type="button" onclick="JSxCstCount()">
                                    <img  class="xCNIconAddOn" src="<?php echo base_url().'application/modules/common/assets/images/icons/search-24.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>       
                </div>
            <div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
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
            <div id="oResultCst"></div>			
            <div class="row"> 	      
            <div class="col-md-4 text-left grid-resultpage"><?= language('ticket/zone/zone', 'tFound') ?> <span id="ospTotalCstRecord">0</span> <?= language('ticket/zone/zone', 'tList') ?> <a class="xWBoxLocPark" style="color: rgb(51, 51, 51); text-decoration: none;"><?= language('ticket/zone/zone', 'tShowpage') ?> <span id="ospPageCstActive">0</span> / <span id="ospTotalCstPage">0</span></a></div>               
            <div class="col-md-8 text-right xWGridFooter xWBoxLocPark"></div>
            </div>
        </div>
    </div>
</div>

<!-- Load Lang Eticket -->
<?php if ($_SESSION['lang'] == 'en'):?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jEN.js"></script>
<?php else:?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jTH.js"></script>
<?php endif?>
<!-- END Load Lang Eticket -->

<script type="text/javascript" src="<?php echo base_url() ?>application/modules/ticket/assets/src/customer/jCustomer.js"></script>
<script>
window.onload = JSxCstCount();
</script>  
