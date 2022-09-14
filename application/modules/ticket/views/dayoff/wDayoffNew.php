<script>
    $(function () {
        $('#oetSCHFDLdoDateFrm').datetimepicker({
            format: 'DD-MM-YYYY',
            locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
        });
    });
</script>

    <div class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="xCNBchVMaster">
                    <div class="col-xs-8 col-md-8">
                        <ol id="oliMenuNav" class="breadcrumb">
                            <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>/EticketBranchNew')" ><?= language('ticket/park/park', 'tBranchInformation') ?></li>
                            <!-- <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>EticketLocationNew/<?= $oHeader[0]->FNPmoID ?>')"><?= $oHeader[0]->FTPmoName ?></li> -->
                            <li  class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url() ?>EticketEditBranch/<?= $oHeader[0]->FNPmoID ?>')"><?= language('ticket/park/park', 'tEditPark') ?></li> 
                            <li id="oliBCHTitle" class="xCNLinkClick"><?= language('ticket/location/location', 'tHolidayDeal') ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content">
         <div class="panel panel-headline">
            <div style="padding:20px;">
                <div class="row xWLocation" id="odvModelData">
                    <div class="col-md-3">		
                            <?php
                                if(isset($oHeader[0]->FTImgObj) && !empty($oHeader[0]->FTImgObj)){
                                    $tFullPatch = './application/modules/'.$oHeader[0]->FTImgObj;
                                    if (file_exists($tFullPatch)){
                                        $tPatchImg = base_url().'/application/modules/'.$oHeader[0]->FTImgObj;
                                    }else{
                                        $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                    }
                                }else{
                                    $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                }
                            ?>
                        <img class="img-reponsive" style="width: 100%;" src="<?= $tPatchImg; ?>">
                    </div>
                    <div class="col-md-5">
                        <div>
                            <b>
                                <?php if ($oHeader[0]->FTLocName): ?>
                                    <?= $oHeader[0]->FTLocName ?>
                                <?php else: ?>
                                    <?= language('ticket/zone/zone', 'tNoData') ?>
                                <?php endif; ?>
                            </b> 
                            <br>
                            <div class="xWLocation-Detail">
                                <?= language('ticket/zone/zone', 'tLocation') ?>            <?php if (@$oArea[0]->FTPvnName != ""): ?>          
                                    <?php foreach (@$oArea AS $aValue): ?>
                                        <?php echo $aValue->FTDstName . ' - ' . $aValue->FTPvnName; ?>
                                        <br>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-6 col-sm-6">
                        <div class="xWNameSlider" style="display: none;"><?= $oHeader[0]->FTLocName ?></div>
                    </div>
                    <div class="col-md-6 col-xs-6 col-sm-6 text-right" onclick="JSxMODHidden()">
                        <span id="ospSwitchPanelModel">
                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
                <hr>
                <div class="container-fluid">
                    <div class="col-md-8">
                        <h4>
                            <?= language('ticket/dayoff/dayoff', 'tDayoffinformation') ?>
                        </h4>
                    </div>
                    <div class="col-md-4 text-right">
                        <?php if ($oAuthen['tAutStaAdd'] == '1'): ?>
                                <button class="xCNBTNPrimeryPlus" type="submit" onclick="JSxCallPage('<?= base_url() ?>EticketLocDayOffAddNew/<?php echo $nLocID; ?>');">+</button>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('common/main/main', 'tSearch') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSCHFDLdoDateFrm" name="oetSCHFDLdoDateFrm" onkeyup="javascript: if (event.keyCode == 13) {event.preventDefault();JSxDayoffCountSearch();}" value="">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnSearch" type="button" onclick="JSxDayoffCountSearch()">
                                        <img onclick="JSxDayoffCountSearch();" class="xCNIconBrowse" src="<?= base_url(); ?>application/modules/common/assets/images/icons/search-24.png">
                                    </button>
                                </span>
                            </div>
                        </div>	
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>		
                </div>
                <hr>
                <div class="container-fluid">
                    <div id="oResultDayoff" style="margin-left: 15px; margin-right: 15px;"></div>       
                    <div class="row">
                        <div class="col-md-4 text-left grid-resultpage">
                            <?= language('ticket/zone/zone', 'tFound') ?> <span id="ospTotalRecordDayoff"> 0</span> <?= language('ticket/zone/zone', 'tList') ?> <a	class="xWBoxLocPark" style="color: rgb(51, 51, 51); text-decoration: none;"><?= language('ticket/zone/zone', 'tShowpage') ?> <span id="ospPageActiveDayoff">0</span> / <span id="ospTotalPageDayoff">0</span></a>
                        </div>
                        <div class="col-md-8 text-right xWGridFooter xWBoxLocPark">
                            <button type="button" id="oPreviousPage" onclick="return JSxDayoffPreviousPage();" class="btn btn-default" data-toggle="tooltip" data-placement="left" data-original-title="Tooltip on left">
                                <i class="fa fa-angle-left"></i> <?= language('ticket/zone/zone', 'tPrevious') ?>
                            </button>
                            <button type="button" id="oForwardPage" onclick="return JSxDayoffForwardPage();"	class="btn btn-default" data-toggle="tooltip" data-placement="left"	data-original-title="Tooltip on left">
                                <?= language('ticket/zone/zone', 'tForward') ?> <i class="fa fa-angle-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<input type="hidden" value="<?php echo $nLocID; ?>" id="ohdGetLocID">

<!-- Load Lang Eticket -->
<?php if ($_SESSION['lang'] == 'en'):?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jEN.js"></script>
<?php else:?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jTH.js"></script>
<?php endif?>

<script type="text/javascript" src="<?php echo base_url() ?>application/modules/ticket/assets/src/dayoff/jDayoffNew.js"></script>
<script>
    window.onload = JSxDayoffCountSearch();
    function JSxMODHidden() {
        $('#odvModelData').slideToggle();
        setTimeout(function () {
            if ($('#odvModelData').css('display') == 'block') {
                $('#ospSwitchPanelModel').html('<i class="fa fa-chevron-up" aria-hidden="true"></i>');
            } else if ($('#odvModelData').css('display') == 'none') {
                $('#ospSwitchPanelModel').html('<i class="fa fa-chevron-down" aria-hidden="true"></i>');
            }

        }, 800);
        $('.xWNameSlider').toggleClass('xWshow');
    }
</script>