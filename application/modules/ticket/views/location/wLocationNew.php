        <div class="main-content">
            <!-- <div class="panel panel-headline">
                <div class="panel-heading"> เพิ่ม -->
                    <div class="container-fluid">
                        <div class="row xWLocation" id="odvModelData">
                            <div class="col-md-3">		
                                <?php
                                if(isset($oModelImg[0]->FTImgObj) && !empty($oModelImg[0]->FTImgObj)){
                                    $tFullPatch = './application/modules/'.$oModelImg[0]->FTImgObj;
                               
                                    if (file_exists($tFullPatch)){
                                        $tPatchImg = base_url().'/application/modules/'.$oModelImg[0]->FTImgObj;
                                    }else{
                                        $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                    }
                                    }else{
                                        $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                    }  
                                ?>
                                <img class="img-reponsive" style="width: 100%;" src="<?php echo $tPatchImg; ?>">
                            </div>
                            <div class="col-md-5">
                                <div>
                                    <b>
                                        <?php if ($oModelImg[0]->FTPmoName): ?>
                                            <?= $oModelImg[0]->FTPmoName ?>
                                        <?php else: ?>
                                            <?= language('ticket/zone/zone', 'tNoData') ?>
                                        <?php endif; ?>				
                                    </b>
                                    <br>
                                    <div class="xWLocation-Detail">
                                        <?= language('ticket/zone/zone', 'tLocation') ?>            <?php if (@$oArea) : ?>
                                            <?php foreach (@$oArea AS $aValue): ?>
                                                <?php echo $aValue->FTDstName . ' - ' . $aValue->FTPvnName; ?>
                                                <br>
                                            <?php endforeach; ?> 
                                        <?php endif ?>            
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" style="text-align: right">				
                                <a class="link-pop" onclick="JSxCallPage('<?php echo base_url(); ?>EticketTchGroup/<?= @$oModelImg[0]->FNPmoID ?>')">
                                    <i class="fa fa-cog"></i> <?= language('ticket/location/location', 'tProductGroupInformation') ?>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-6 col-sm-6">
                                <div class="xWNameSlider" style="display: none;"><?= @$oModelImg[0]->FTPmoName ?></div>
                            </div>
                            <div class="col-md-6 col-xs-6 col-sm-6 text-right" onclick="JSxMODHidden()">
                                <span id="ospSwitchPanelModel">
                                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                        <div style="margin-right: 15px; margin-left: 15px;"><hr style="margin-top: 15px; margin-bottom: 15px;"></div>
                        <div class="row">
                            <div class="col-md-8">
                                <h4>
                                    <?= language('ticket/location/location', 'tLocationInformation') ?>
                                </h4>							
                            </div>
                            <div class="col-md-4 text-right">
                                <!-- <?php if (@$oAuthen['tAutStaDelete'] == '1'): ?>					
                                    <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn obtChoose" style="display: none;" type="button" onclick="FSxDelAllOnCheck();"> <?= language('common/main/main', 'tCMNDeleteAll') ?></button>
                                    <input type="hidden" id="ohdIDCheckDel">					
                                <?php endif; ?> -->
                                <?php if ($oAuthen['tAutStaAdd'] == '1'): ?>	    
                                    <button class="xCNBTNPrimeryPlus" type="button" onclick="JSxCallPage('<?= base_url() ?>EticketAddLocNew/<?php echo $nID; ?>')">+</button>        
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                                    <label class="xCNLabelFrm"><?= language('common/main/main', 'tSearch') ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSCHFTLocName" name="oetSCHFTLocName" onkeyup="javascript: if (event.keyCode == 13) {event.preventDefault();JSxLocCountSearch();}" value="">
                                        <span class="input-group-btn">
                                            <button class="btn xCNBtnSearch" type="button" onclick="JSxLocCountSearch()">
                                                <img onclick="JSxLocCountSearch();" class="xCNIconBrowse" src="<?= base_url(); ?>application/modules/common/assets/images/icons/search-24.png">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
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
                    </div>

                    <hr style="margin-top: 15px; margin-bottom: 15px;">

                    <div id="oResultLocation"></div>       
                    <div class="row">
                        <div class="col-md-4 text-left grid-resultpage">
                            <?= language('ticket/zone/zone', 'tFound') ?> <span id="ospTotalRecord"> 0</span> <?= language('ticket/zone/zone', 'tList') ?> <a	class="xWBoxLocPark" style="color: rgb(51, 51, 51); text-decoration: none;"><?= language('ticket/zone/zone', 'tShowpage') ?> <span id="ospPageActive">0</span> / <span id="ospTotalPage">0</span></a>
                        </div>
                        <div class="col-md-8 text-right xWGridFooter xWBoxLocPark"></div>
                    </div>
                </div> 
            </div>
        </div>

<input type="hidden" value="<?php echo $nID; ?>" id="ohdGetParkId">

<!-- Load Lang Eticket -->
<?php if ($_SESSION['lang'] == 'en'):?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jEN.js"></script>
<?php else:?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jTH.js"></script>
<?php endif?>

<script type="text/javascript" src="<?php echo base_url() ?>application/modules/ticket/assets/src/location/jLocationNew.js"></script>
<script>
    window.onload = JSxLocCountSearch();
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