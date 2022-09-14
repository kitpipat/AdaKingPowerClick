<input id="oetCpgStaBrowse" type="hidden" value="<?=$nCpgBrowseType?>">
<input id="oetCpgCallBackOption" type="hidden" value="<?=$tCpgBrowseOption?>">

<?php if(isset($nCpgBrowseType) && $nCpgBrowseType == 0) : ?>
<div id="odvCpgMainMenu" class="main-menu"> <!-- เปลี่ยน -->
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNCpgVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb"> <!-- เปลี่ยน -->
                        <?php FCNxHADDfavorite('courierGrp/0/0');?> 
                        <li id="oliCpgTitle" class="xCNLinkClick" onclick="JSvCallPageCpgList()" style="cursor:pointer"><?= language('courier/couriergrp/couriergrp','tCPGTitle')?></li> <!-- เปลี่ยน -->
                        <li id="oliCpgTitleAdd" class="active"><a><?= language('courier/couriergrp/couriergrp','tCPGTitleAdd')?></a></li>
                        <li id="oliCpgTitleEdit" class="active"><a><?= language('courier/couriergrp/couriergrp','tCPGTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0"> <!-- เปลี่ยน -->
                    <div id="odvBtnCpgInfo">
                        <?php if($aAlwEventCourierGrp['tAutStaFull'] == 1 || $aAlwEventCourierGrp['tAutStaAdd'] == 1) : ?>
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageCpgAdd()">+</button>
                        <?php endif;?>
                    </div>
                    <div id="odvBtnAddEdit">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button onclick="JSvCallPageCpgList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                            <?php if($aAlwEventCourierGrp['tAutStaFull'] == 1 || ($aAlwEventCourierGrp['tAutStaAdd'] == 1 || $aAlwEventCourierGrp['tAutStaEdit'] == 1)) : ?>
                            <div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="JSxSetStatusClickCpgSubmit();$('#obtSubmitCpg').click()"> <?php echo language('common/main/main', 'tSave')?></button>
								<?php echo $vBtnSave?>
							</div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xCNCpgVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?php echo $tCpgBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
						<i class="fa fa-arrow-left xCNBackBowse"></i>	
					</a>
                    <ol id="oliPunNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tCpgBrowseOption?>')"><a>แสดงข้อมูล : <?php echo language('courier/couriergrp/couriergrp','tCpgTitle')?></a></li>
                        <li class="active"><a><?php echo  language('courier/couriergrp/couriergrp','tCPGTitleAdd')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCpg').click()"><?php echo  language('common/main/main', 'tSave')?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>
<div class="xCNMenuCump xCNCpgBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPageCpg"></div>
</div>
<script src="<?= base_url('application/modules/courier/assets/src/couriergrp/jCourierGrp.js')?>"></script>
