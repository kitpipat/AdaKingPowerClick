<div class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNBchVMaster">
                <div class="col-xs-8 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>/EticketBranchNew')" ><?= language('ticket/park/park', 'tBranchInformation') ?></li>
                        <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>EticketEditBranch/<?= $oHeader[0]->FNPmoID ?>')"><?= language('ticket/zone/zone', 'tEditPark') ?></li>
                        <li id="oliBCHTitle" class="xCNLinkClick"><?= language('ticket/gate/gate', 'tGateInformation') ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="main-content">
        <div class="panel panel-headline">
            <div style="padding:20px;">
                <div class="container-fluid">
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
                                    <?= language('ticket/zone/zone', 'tLocation') ?>                     
                                    <?php if (@$oArea) : ?>
                                    <?php foreach (@$oArea AS $aValue): ?>
                                        <?php echo $aValue->FTDstName . ' - ' . $aValue->FTPvnName; ?>
                                        <br>
                                    <?php endforeach; ?> 
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                <div class="col-md-4" style="text-align: right"></div>
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
                </div>
                    <hr>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-8">										
                                    <h4>
                                    <?= language('ticket/gate/gate', 'tGatelInformation') ?>
                                </h4>
                            </div>
                                <div class="col-md-4 text-right">
                                    <!-- <?php if (@$oAuthen['tAutStaDelete'] == '1'): ?>					
                                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn obtChoose" style="margin-top:4px;display: none;" type="button" onclick="FSxDelAllOnCheck();"> <?= language('common/main/main', 'tCMNDeleteAll') ?></button>&nbsp;
                                        <input type="hidden" id="ohdIDCheckDel">					
                                    <?php endif; ?> -->
                                    <?php if ($oAuthen['tAutStaAdd'] == '1'): ?>            
                                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSxCallPage('<?= base_url() ?>EticketAddGateNew/<?php echo $nLocID; ?>')">+</button>
                                    <?php endif; ?>	
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('common/main/main', 'tSearch') ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSCHFTGateName" name="oetSCHFTGateName" onkeyup="javascript: if (event.keyCode == 13) {event.preventDefault();JSxGateCount();}" value="">
                                        <span class="input-group-btn">
                                            <button class="btn xCNBtnSearch" type="button" onclick="JSxGateCount()">
                                                <img onclick="JSxGateCount();" class="xCNIconBrowse" src="<?=base_url()?>application/modules/common/assets/images/icons/search-24.png">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <div class="col-md-4"></div>
                    <div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:25px;">
                        <?php if (@$oAuthen['tAutStaDelete'] == '1'): ?>
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
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <div class="container-fluid">
                            <div id="oResultGate"></div>       
                                <div class="row">
                                    <div class="col-md-4 text-left grid-resultpage">
                                    <?= language('ticket/zone/zone', 'tFound') ?> <span id="oLocGateCount"> 0</span> <?= language('ticket/zone/zone', 'tList') ?> <a class="xWBoxLocPark" style="color: rgb(51, 51, 51); text-decoration: none;"><?= language('ticket/zone/zone', 'tShowpage') ?> <span id="ospPageActiveGate">0</span> / <span id="ospTotalPageGate">0</span></a>
                                </div>
                            <div class="col-md-8 text-right xWGridFooter xWBoxLocPark"></div>
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

<script type="text/javascript" src="<?php echo base_url() ?>application/modules/ticket/assets/src/gate/jGateNew.js"></script>
<script>
    window.onload = JSxGateCount();
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