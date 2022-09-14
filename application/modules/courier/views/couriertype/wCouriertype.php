<input id="oetCtyStaBrowse" type="hidden" value="<?=$nCtyBrowseType?>">
<input id="oetCtyCallBackOption" type="hidden" value="<?=$tCtyBrowseOption?>">

<?php if(isset($nCtyBrowseType) && $nCtyBrowseType == 0) : ?>
<div id="odvCtyMainMenu" class="main-menu"> <!-- เปลี่ยน -->
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNCtyVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb"> <!-- เปลี่ยน -->
                        <?php FCNxHADDfavorite('courierType/0/0');?> 
                        <li id="oliCtyTitle" class="xCNLinkClick" onclick="JSvCallPageCtyList()" style="cursor:pointer"><?= language('courier/couriertype/couriertype','tCTYTitle')?></li> <!-- เปลี่ยน -->
                        <li id="oliCtyTitleAdd" class="active"><a><?= language('courier/couriertype/couriertype','tCTYTitleAdd')?></a></li>
                        <li id="oliCtyTitleEdit" class="active"><a><?= language('courier/couriertype/couriertype','tCTYTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0"> <!-- เปลี่ยน -->
                    <div id="odvBtnCtyInfo">
                        <?php if($aAlwEventCourierType['tAutStaFull'] == 1 || $aAlwEventCourierType['tAutStaAdd'] == 1) : ?>
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageCtyAdd()">+</button>
                        <?php endif;?>
                    </div>
                    <div id="odvBtnAddEdit">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button onclick="JSvCallPageCtyList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                            <?php if($aAlwEventCourierType['tAutStaFull'] == 1 || ($aAlwEventCourierType['tAutStaAdd'] == 1 || $aAlwEventCourierType['tAutStaEdit'] == 1)) : ?>
                            <div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="JSxSetStatusClickCtySubmit();$('#obtSubmitCty').click()"> <?php echo language('common/main/main', 'tSave')?></button>
								<?php echo $vBtnSave?>
							</div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xCNCtyVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?php echo $tCtyBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
						<i class="fa fa-arrow-left xCNBackBowse"></i>	
					</a>
                    <ol id="oliPunNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tCtyBrowseOption?>')"><a>แสดงข้อมูล : <?php echo language('courier/couriertype/couriertype','tCTYTitle')?></a></li>
                        <li class="active"><a><?php echo  language('courier/couriertype/couriertype','tCTYTitleAdd')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCty').click()"><?php echo  language('common/main/main', 'tSave')?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endif;?>
<div class="xCNMenuCump xCNCtyBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPageCty"></div>
</div>
<script src="<?= base_url('application/modules/courier/assets/src/couriertype/jCourierType.js')?>"></script>

