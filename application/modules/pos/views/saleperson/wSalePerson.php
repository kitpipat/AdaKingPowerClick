<input id="oetSpnStaBrowse" type="hidden" value="<?php echo $nSpnBrowseType; ?>">
<input id="oetSpnCallBackOption" type="hidden" value="<?php echo $tSpnBrowseOption; ?>">

<?php if(isset($nSpnBrowseType) && $nSpnBrowseType == 0) :?>
<div id="odvSpnMainMenu" class="main-menu">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">
			<div class="xCNSpnVMaster">
				<div class="col-xs-12 col-md-8">
					<ol id="oliMenuNav" class="breadcrumb xCNBCMenu">
						<li id="oliSpnTitle" class="xCNLinkClick" onclick="JSvCallPageSalePerson('')"><?php echo language('pos/saleperson/saleperson','tSPNTitle'); ?></li>
						<li id="oliSpnTitleAdd" class="active"><a><?php echo language('pos/saleperson/saleperson','tSPNTitleAdd'); ?></a></li>
						<li id="oliSpnTitleEdit" class="active"><a><?php echo language('pos/saleperson/saleperson','tSPNTitleEdit'); ?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-md-4 text-right">
					<div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvBtnSpnInfo">
                            <button id="obtCstGrpAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageSalePersonAdd()" title="<?php echo language('common/main/main', 'tAdd'); ?>">+</button>
						</div>
						<div id="odvBtnAddEdit">
							<button onclick="JSvCallPageSalePerson()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
							<div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitSalePerson').click()"> <?php echo language('common/main/main', 'tSave'); ?></button>
								<?php echo $vBtnSave; ?>
							</div>
						</div>
					</div>
				</div>
			</div>			
		</div>
	</div>
</div>
<?php else:?>
<div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?=$tSpnBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliBchNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?=$tSpnBrowseOption?>')"><a><?= language('common/main/main', 'tShowData')?> : <?= language('pos/saleperson/saleperson','tSPNTitle')?></a></li>
                    <li class="active"><a><?= language('pos/saleperson/saleperson','tSPNTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvSpnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitSalePerson').click()"><?= language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>

<?php endif;?>
<div id="odvContentPageSalePerson"  class="modal-bodody"></div>

<script src="<?php echo base_url('application/modules/pos/assets/src/saleperson/jSalePerson.js'); ?>"></script>



