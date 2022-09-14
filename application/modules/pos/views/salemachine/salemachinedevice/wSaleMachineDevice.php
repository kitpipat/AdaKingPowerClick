<input id="oetPhwStaBrowse" type="hidden" value="<?=$nPhwBrowseType?>">
<input id="oetPhwCallBackOption" type="hidden" value="<?=$tPhwBrowseOption?>">
<input id="ohdPosCode" type="hidden" value="<?=$tPosCode ?>" >

<div id="odvPhwMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNPhwVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <li id="oliPhwTitle" class="xCNLinkClick" onclick="JSvCallPageSaleMachineIndex()" style="cursor:pointer"><?= language('pos/salemachine/salemachine','tPOSTitle')?></li>
                        <li id="oliPhwTitleDevice" class="active" onclick="JSvCallPageSaleMachineDeviceList('<?=$tPosCode ?>')" style="cursor:pointer"><a><?= language('pos/salemachine/salemachine','tPOSTitleDevice')?></a></li> 
                        <li id="oliPhwTitleEdit" class="active"><a><?= language('pos/salemachine/salemachine','tPOSTitleEdit')?></a></li>
                        <li id="oliPhwTitleAdd" class="active"><a><?= language('pos/salemachine/salemachine','tPOSTitleAdd')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0">
                    <div id="odvBtnPhwInfo">
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageSaleMachineDeviceAdd()">+</button>
                    </div>
                    <div id="odvBtnAddEdit">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button onclick="JSvCallPageSaleMachineDeviceList('<?=$tPosCode ?>')" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                            <div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitSaleMachineDevice').click()"> <?php echo language('common/main/main', 'tSave')?></button>
								<?php echo $vBtnSave?>
							</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="xCNPhwVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?php echo $tPhwBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
						<i class="fa fa-arrow-left xCNBackBowse"></i>	
					</a>
                    <ol id="oliPunNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tPhwBrowseOption?>')"><a><?php echo  language('common/main/main', 'tShowData')?> <?php echo language('pos/salemachine/salemachine','tPOSTitle')?></a></li>
                        <li class="active"><a><?php echo  language('pos/salemachine/salemachine','tPOSTitleAdd')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitSaleMachineDevice').click()"><?php echo  language('common/main/main', 'tSave')?></button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="xCNMenuCump xCNPhwBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPageSaleMachineDevice"></div>
</div>

<script src="<?= base_url('application/modules/pos/assets/src/salemachine/jSaleMachine.js')?>"></script>
<script src="<?= base_url('application/modules/pos/assets/src/salemachinedevice/jSaleMachineDevice.js')?>"></script>
