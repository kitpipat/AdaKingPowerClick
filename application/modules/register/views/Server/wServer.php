<input id="oetSrvStaBrowse" type="hidden" value="<?php echo $nSrvBrowseType?>">
<input id="oetSrvCallBackOption" type="hidden" value="<?php echo $tSrvBrowseOption?>">

<?php if(isset($nSrvBrowseType) && $nSrvBrowseType == 0) : ?>
	<div id="odvSrvMenuTitle" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <ol id="oliMenuNav" class="breadcrumb">
                            <?php FCNxHADDfavorite('Server/0/0');?> 
                            <li id="oliSrvTitle" class="xCNLinkClick" onclick="JSvCallPageServerList()" style="cursor:pointer"><?php echo language('register/register','tSrvTitle')?></li>
                            <li id="oliSrvTitleAdd" class="active"><a><?php echo language('register/register','tSrvTitleAdd')?></a></li>
                            <li id="oliSrvTitleEdit" class="active"><a><?php echo language('register/register','tSrvTitleEdit')?></a></li>
                        </ol>
					</div>
                        <div class="col-xs-12 col-md-4 text-right p-r-0">
                        <div id="odvBtnSrvInfo">
                            <?php if($aAlwEventServer['tAutStaFull'] == 1 || $aAlwEventServer['tAutStaAdd'] == 1) : ?>
                            <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageServerAdd()">+</button>
                            <?php endif; ?>
                        </div>
                        <div id="odvBtnAddEdit" style="margin-top:3px">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button onclick="JSvCallPageServerList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                                
                                <?php if($aAlwEventServer['tAutStaFull'] == 1 || ($aAlwEventServer['tAutStaAdd'] == 1 || $aAlwEventServer['tAutStaEdit'] == 1)) : ?>
                                <div class="btn-group">
                                    <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="JSxSetStatusClickServerSubmit();$('#obtSubmitServer').click();"> <?php echo language('common/main/main', 'tSave')?></button>
                                    <?php echo $vBtnSave?>
                                </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
					</div>
				</div>
			</div>
		</div>
	<div class="xCNMenuCump xCNPtyBrowseLine" id="odvMenuCump">
		&nbsp;
	</div>
	<div class="main-content">
		<div id="odvContentPageServer" class="panel panel-headline"></div>
	</div>
	<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">
    <?php else: ?>
        <div class="modal-header xCNModalHead">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <a onclick="JCNxBrowseData('<?php echo $tSrvBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                        <i class="fa fa-arrow-left xCNIcon"></i>	
                    </a>
                    <ol id="oliSrvNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tSrvBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('register/register','tSrvTitle')?></a></li>
                        <li class="active"><a><?php echo language('register/register','tSrvTitleAdd')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                    <div id="odvSrvBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="JSxSetStatusClickServerSubmit();$('#obtSubmitServer').click();"><?php echo language('common/main/main', 'tSave')?></button>
                    </div>
                </div>
            </div>
        </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
</div>
<?php endif;?>	
<script src="<?php echo  base_url('application/modules/register/assets/src/Server/jServer.js')?>"></script>

