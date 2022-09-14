<input id="oetPmoStaBrowse" type="hidden" value="<?=$nPmoBrowseType?>">
<input id="oetPmoCallBackOption" type="hidden" value="<?=$tPmoBrowseOption?>">

<?php if(isset($nPmoBrowseType) && $nPmoBrowseType == 0) : ?>
<div id="odvPmoMainMenu" class="main-menu"> <!-- เปลี่ยน -->
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNPmoVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb"> <!-- เปลี่ยน -->
                        <?php FCNxHADDfavorite('pdtmodel/0/0');?> 
                        <li id="oliPmoTitle" class="xCNLinkClick" onclick="JSvCallPagePdtPmoList()" style="cursor:pointer"><?= language('product/pdtmodel/pdtmodel','tPMOTitle')?></li> <!-- เปลี่ยน -->
                        <li id="oliPmoTitleAdd" class="active"><a><?= language('product/pdtmodel/pdtmodel','tPMOTitleAdd')?></a></li>
                        <li id="oliPmoTitleEdit" class="active"><a><?= language('product/pdtmodel/pdtmodel','tPMOTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0"> <!-- เปลี่ยน -->
                    <div id="odvBtnPmoInfo">
                        <?php if($aAlwEventPdtModel['tAutStaFull'] == 1 || $aAlwEventPdtModel['tAutStaAdd'] == 1) : ?>
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPagePdtPmoAdd()">+</button>
                        <?php endif; ?>
                    </div>
                    <div id="odvBtnAddEdit">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button onclick="JSvCallPagePdtPmoList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                            <?php if($aAlwEventPdtModel['tAutStaFull'] == 1 || ($aAlwEventPdtModel['tAutStaAdd'] == 1 || $aAlwEventPdtModel['tAutStaEdit'] == 1)) : ?>
                            <div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="JSxSetStatusClickPmoSubmit();$('#obtSubmitPdtPmo').click()"> <?php echo language('common/main/main', 'tSave')?></button>
								<?php echo $vBtnSave?>
							</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="xCNPmoVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?php echo $tPmoBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
						<i class="fa fa-arrow-left xCNBackBowse"></i>	
					</a>
                    <ol id="oliPunNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tPmoBrowseOption?>')"><a>แสดงข้อมูล : <?php echo language('product/pdtmodel/pdtmodel','tPMOTitle')?></a></li>
                        <li class="active"><a><?php echo  language('product/pdtmodel/pdtmodel','tPMOTitleAdd')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitPdtPmo').click()"><?php echo  language('common/main/main', 'tSave')?></button>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tPmoBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPunNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tPmoBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?= language('product/pdtmodel/pdtmodel','tPMOTitle')?></a></li>
                    <li class="active"><a><?= language('product/pdtmodel/pdtmodel','tPMOTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="JSxSetStatusClickPmoSubmit();$('#obtSubmitPdtPmo').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd"></div>
<?php endif;?>
<div class="xCNMenuCump xCNPmoBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPagePdtPmo"></div>
</div>
<script src="<?= base_url('application/modules/product/assets/src/pdtmodel/jPdtModel.js')?>"></script>