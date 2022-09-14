<div class="xCNMrgNavMenu">
    <div class="row xCNavRow" style="width:inherit;">
        <div class="xCNBchVMaster">
            <div class="col-xs-8 col-md-8">
                <ol id="oliMenuNav" class="breadcrumb">
                    <li id="oliBCHTitle" class="xCNLinkClick"><?= language('ticket/verification/verification','tCheckTransfer')?></li>
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
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tBank')?></label>
                                        <select class="selectpicker form-control"  name="ocmFTBnkCode" id="ocmFTBnkCode" style="width: 100%">
                                            <option value=""><?= language('ticket/bank/bank','tSelectBank')?></option>
                                            <?php foreach ($oBank as $key => $oValue): ?>
                                            <option value="<?=$oValue->FTBnkCode?>"><?=$oValue->FTBnkName?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                                <div class="col-md-4">
                                    <div class="form-group"> 
                                        <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tPaymentDate')?></label>
                                            <div class="input-group">
                                            <input class="form-control" type="text" id="oetFDDate" name="oetFDDate">
                                            <span class="input-group-btn">
                                            <button class="btn xCNBtnSearch" type="button"  id="obtFDDate" >
                                            <img  class="xCNIconAddOn" src="<?php echo base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                                <div class="col-md-4">
                                    <div class="form-group"> 
                                        <label class="xCNLabelFrm"><?= language('ticket/verification/verification','tOrderIDs')?></label>
                                            <div class="input-group">
                                            <input class="form-control" type="text" id="oetFTShdDocNo" name="oetFTShdDocNo" onkeyup="javascript: if (event.keyCode == 13) {event.preventDefault();}">
                                            <span class="input-group-btn">
                                            <button class="btn xCNBtnSearch" type="button" onclick="JSxVerCount();">
                                            <img class="xCNIconAddOn"  src="<?php echo base_url().'application/modules/common/assets/images/icons/search-24.png'?>">
                                            </button>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="col-md-2"></div>
                    </div>
                <div id="oResultVer"></div>
            <div class="row">
                <div class="col-md-4 text-left grid-resultpage"><?=language('ticket/zone/zone','tFound')?><span id="ospTotalRecordVer">0</span> <?= language('ticket/zone/zone', 'tList') ?> <a class="xWBoxLocPark" style="color: rgb(51, 51, 51); text-decoration: none;"><?= language('ticket/zone/zone', 'tShowpage') ?> <span id="ospPageActiveVer">0</span> / <span id="ospTotalPageVer">0</span></a></div>
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

<script type="text/javascript" src="<?php echo base_url() ?>application/modules/ticket/assets/src/verification/jVerification.js"></script>
<script type="text/javascript">
    $('.selectpicker').selectpicker();
        $('#obtFDDate').click(function(){
            event.preventDefault();
            $('#oetFDDate').datetimepicker('show');
        });
    JSxVerCount();
    FSxDecimal(".xWDecimal", 2);
    $(function() {
     $('#oetFDDate').datetimepicker({
        format : 'DD-MM-YYYY',
        locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
    });
 });
</script>

