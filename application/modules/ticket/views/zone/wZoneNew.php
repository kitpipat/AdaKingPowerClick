    <div class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="xCNBchVMaster">
                    <div class="col-xs-8 col-md-8">
                        <ol id="oliMenuNav" class="breadcrumb">
                            <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>/EticketBranchNew')" ><?= language('ticket/park/park', 'tBranchInformation') ?></li>
                            <!-- <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>EticketLocationNew/<?= $oHeader[0]->FNPmoID ?>')"><?= language('ticket/zone/zone', 'tManagelocations') ?></li> -->
                            <li  class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url() ?>EticketEditBranch/<?= $oHeader[0]->FNPmoID ?>')"><?= language('ticket/park/park', 'tEditPark') ?></li> 
                            <li id="oliBCHTitle" class="xCNLinkClick"><?= language('ticket/zone/zone', 'tZoneInformation') ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="main-content">
            <div class="panel panel-headline">
                <div class="panel-heading">
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
                                        <?php if (@$oHeader[0]->FTLocName): ?>
                                            <?= $oHeader[0]->FTLocName ?>
                                        <?php else: ?>
                                            <?= language('ticket/zone/zone', 'tNoData') ?>
                                        <?php endif; ?>
                                    </b> 
                                    <br>
                                    <div class="xWLocation-Detail">
                                        <?= language('ticket/zone/zone', 'tLocation') ?> <?php if (@$oArea) : ?>
                                            <?php foreach (@$oArea AS $aValue): ?>
                                                <?php echo $aValue->FTDstName . ' - ' . $aValue->FTPvnName; ?>
                                                <br>
                                            <?php endforeach; ?> 
                                        <?php endif ?>
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
                    </div>
                    <hr>
                    <div class="xWwrapBox">
                        <div class="row">
                            <div class="col-md-8">
                                <h4>
                                    <?= language('ticket/zone/zone', 'tZoneInformation') ?>
                                </h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <?php if (@$oAuthen['tAutStaDelete'] == '1'): ?>					
                                    <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn obtChoose" style="display: none;" type="button" onclick="FSxDelAllOnCheck();"> <?= language('common/main/main', 'tCMNDeleteAll') ?></button>&nbsp;
                                    <input type="hidden" id="ohdIDCheckDel">					
                                <?php endif; ?>
                                <?php if ($oAuthen['tAutStaAdd'] == '1'): ?>
                                    <button class="xCNBTNPrimeryPlus" type="button" onclick="JSxCallPage('<?= base_url() ?>EticketAddZoneNew/<?php echo $nLocID; ?>')">+</button>
                                <?php endif; ?>	
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                                    <label class="xCNLabelFrm"><?= language('common/main/main', 'tSearch') ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSCHFTZneName" name="oetSCHFTZneName" onkeyup="javascript: if (event.keyCode == 13) {event.preventDefault();JSxZneCount();}" value="">
                                        <span class="input-group-btn">
                                            <button class="btn xCNBtnSearch" type="button" onclick="JSxZneCount()">
                                                <img onclick="JSxZneCount();" class="xCNIconBrowse" src="<?= base_url(); ?>application/modules/common/assets/images/icons/search-24.png">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4"></div>			
                            <div class="col-md-4"></div>			
                        </div>
                        <hr>
                        <div id="oResultZne"></div>       
                        <div class="row">
                            <div class="col-md-4 text-left grid-resultpage">
                                <?= language('ticket/zone/zone', 'tFound') ?><span id="ospTotalRecordZne"> 0</span> <?= language('ticket/zone/zone', 'tList') ?> <a class="xWBoxLocPark" style="color: rgb(51, 51, 51); text-decoration: none;"><?= language('ticket/zone/zone', 'tShowpage') ?> <span id="ospPageActiveZne">0</span> / <span id="ospTotalPageZne">0</span></a>
                            </div>
                            <div class="col-md-8 text-right xWGridFooter xWBoxLocPark"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<input type="hidden" value="<?php echo $nLocID; ?>" id="ohdGetLocID">
<input type="hidden" value="<?php echo $oHeader[0]->FNPmoID; ?>" id="ohdGetPrkID">

<!-- Load Lang Eticket -->
<?php if ($_SESSION['lang'] == 'en'):?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jEN.js"></script>
<?php else:?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jTH.js"></script>
<?php endif?>

<script type="text/javascript" src="<?php echo base_url() ?>application/modules/ticket/assets/src/zone/jZoneNew.js"></script>
<script>
    window.onload = JSxZneCount();
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