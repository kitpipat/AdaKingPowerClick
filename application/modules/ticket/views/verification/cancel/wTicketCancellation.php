<div class="xCNMrgNavMenu">
    <div class="row xCNavRow" style="width:inherit;">
        <div class="xCNBchVMaster">
            <div class="col-xs-8 col-md-8">
                <ol id="oliMenuNav" class="breadcrumb">
                    <li id="oliBCHTitle" class="xCNLinkClick"><?= language('ticket/verification/verification','tTicketCancellationInformation')?></li>
                        </ol>
                        </div>
                        <div class="col-xs-12 col-md-4 text-right p-r-0">
                        <div class="demo-button xCNBtngroup">
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
                        <label class="xCNLabelFrm"><?= language('common/main/main','tSearch')?><?= language('ticket/verification/verification','tOrderNumber')?></label>
                        <div class="input-group">
                        <input class="form-control" type="text" id="oetFTShdDocNo" name="oetFTShdDocNo" onkeyup="javascript: if (event.keyCode == 13) { event.preventDefault(); }">
                        <span class="input-group-btn">
                        <button class="btn xCNBtnSearch" type="button" onclick="JSxAGECancellationCount()">
                        <img  class="xCNIconAddOn" src="<?php echo base_url().'application/modules/common/assets/images/icons/search-24.png'?>">
                    </button>
                </span>
            </div>
        </div>       
    </div>
</div>
    <div id="oResultTicketCancellation"></div>
        <div class="row"> 
            <div class="col-md-4 text-left grid-resultpage"><?= language('ticket/zone/zone','tFound') ?><span id="ospTclTotalRecord"></span>  <?= language('ticket/zone/zone', 'tList') ?> <a class="xWBoxLocPark" style="color: rgb(51, 51, 51); text-decoration: none;"><?= language('ticket/zone/zone', 'tShowpage') ?> <span id="ospPageActive">0</span> / <span id="ospTotalPage"></span></a></div>
            <div class="col-md-8 text-right xWGridFooter xWBoxLocPark"></div>
            </div>		
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

<script type="text/javascript" src="<?php echo base_url() ?>application/modules/ticket/assets/src/verification/jVerification.js"></script>
<script type="text/javascript">
    $('.selectpicker').selectpicker();
    JSxAGECancellationCount();
    JSxCheckPinMenuClose();
</script>