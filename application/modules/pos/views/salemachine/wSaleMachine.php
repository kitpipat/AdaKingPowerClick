<input id="oetPosStaBrowse"      type="hidden" value="<?php echo $nPosBrowseType?>">
<input id="oetPosCallBackOption" type="hidden" value="<?php echo $tPosBrowseOption?>">
<input id="oetPosnRouteFrom"     type="hidden" value="<?php echo $tRouteFromName?>">

<?php if(isset($nPosBrowseType) && $nPosBrowseType == 0) : ?>
    <div id="odvPosMainMenu" class="main-menu"> <!-- เปลี่ยน -->
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="xCNPosVMaster">
                    <div class="col-xs-12 col-md-8">
                        <ol id="oliMenuNav" class="breadcrumb"> <!-- เปลี่ยน -->
                            <?php FCNxHADDfavorite('salemachine/0/0');?> 
                            <li id="oliPosTitle" class="xCNLinkClick" onclick="JSvCallPageSaleMachineList()" style="cursor:pointer"><?php echo language('pos/salemachine/salemachine','tPOSTitle')?></li> <!-- เปลี่ยน -->
                            <li id="oliPosTitleAdd" class="active"><a><?php echo language('pos/salemachine/salemachine','tPOSTitleAdd')?></a></li>
                            <li id="oliPosTitleEdit" class="active"><a><?php echo language('pos/salemachine/salemachine','tPOSTitleEdit')?></a></li>
                        </ol>
                    </div>
                    <div class="col-xs-12 col-md-4 text-right p-r-0"> <!-- เปลี่ยน -->
                        <div id="odvBtnPosInfo">
                            <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
                                <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageSaleMachineAdd()">+</button>
                            <?php endif; ?>
                        </div>
                        <div id="odvBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button onclick="JSvCallPageSaleMachineList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                                <div class="btn-group">
                                    <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitSaleMachine').click()"> <?php echo language('common/main/main', 'tSave')?></button>
                                    <?php echo $vBtnSave?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNPosBrowseLine" id="odvMenuCump">&nbsp;</div>
    <div class="main-content">
        <div id="odvContentPageSaleMachine" class="panel panel-headline"></div>
    </div>
<?php else: ?>
	<div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tPosBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPosNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tPosBrowseOption?>')"><a><?php echo language('common/main/main', 'tShowData')?> : <?php echo language('pos/salemachine/salemachine','tPOSTitle')?></a></li>
                    <li class="active"><a><?php echo language('pos/salemachine/salemachine','tPOSTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPosBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="JSxSetStatusClickPosSubmit();$('#obtSubmitSaleMachine').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd"></div>
<?php endif;?>

<script src="<?php echo  base_url('application/modules/pos/assets/src/salemachine/jSaleMachine.js')?>"></script>
<script src="<?php echo  base_url('application/modules/pos/assets/src/salemachinedevice/jSaleMachineDevice.js')?>"></script>


