<input id="oetCardShiftTopUpStaBrowse" type="hidden" value="<?=$nCardShiftTopUpBrowseType?>">
<input id="oetCardShiftTopUpCallBackOption" type="hidden" value="<?=$tCardShiftTopUpBrowseOption?>">

<div id="odvCardShiftTopUpMainMenu" class="main-menu">
	<div class="xCNMrgNavMenu">
		<div class="xCNavRow" style="width:inherit;">

			<div class="xCNCardShiftTopUpVMaster row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">		
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('cardShiftTopUp/0/0');?>
						<li id="oliCardShiftTopUpTitle" class="xCNLinkClick" onclick="JSvCardShiftTopUpCallPageCardShiftTopUp('')"><?= language('document/card/cardtopup','tCardShiftTopUpTitle')?></li>
                        <li id="oliCardShiftTopUpTitleAdd" class="active"><a href="javascrip:;"><?= language('document/card/cardtopup','tCardShiftTopUpTitleAdd')?></a></li>
						<li id="oliCardShiftTopUpTitleEdit" class="active"><a href="javascrip:;"><?= language('document/card/cardtopup','tCardShiftTopUpTitleEdit')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
					<div class="demo-button xCNBtngroup" style="width:100%;">
                        <?php if($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAdd"] == "1") : ?>
						<div id="odvBtnCardShiftTopUpInfo">
							<button id="obtCardShiftTopUpAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCardShiftTopUpCallPageCardShiftTopUpAdd()">+</button>
						</div>
                        <?php endif; ?>
						<div id="odvBtnAddEdit">
							<button onclick="JSvCardShiftTopUpCallPageCardShiftTopUp()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
							<?php if($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaPrint"] == "1") : ?>
                            	<button type="button" id="obtCardShiftTopUpBtnDocMa" class="btn xCNBTNDefult xCNBTNDefult2Btn hidden" onclick="JSxCardShiftTopUpPrint()"> <?php echo language('common/main/main', 'tCMNPrint'); ?></button>
                            <?php endif; ?>
							<?php if($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaCancel"] == "1") : ?>
                                <button id="obtCardShiftTopUpBtnCancelApv" onclick="JSxCardShiftTopUpStaDoc(false)" class="btn xCNBTNDefult xCNBTNDefult2Btn hidden" type="button"> <?php echo language('common/main/main', 'tCancel'); ?></button>
                            <?php endif; ?>
							<?php if($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAppv"] == "1") : ?>
                                <button id="obtCardShiftTopUpBtnApv" onclick="JSxCardShiftTopUpStaApvDoc(false)" class="btn xCNBTNPrimery xCNBTNDefult2Btn hidden" type="button"> <?php echo language('common/main/main', 'tCMNApprove'); ?></button>
                            <?php endif; ?>
                            <?php if($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAdd"] || $aPermission["tAutStaEdit"]) : ?>
                                <button type="button" id="obtCardShiftTopUpBtnSave" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="$('#obtSubmitCardValueForm').click(); $('#obtSubmitCardShiftTopUpMainForm').click();"> <?php echo language('common/main/main', 'tSave'); ?></button>								
                            <?php endif; ?>
                        </div>
					</div>
				</div>
			</div>

			<div class="xCNCardShiftTopUpVBrowse">
				<div class="col-xs-12 col-md-6">
					<a onclick="JCNxBrowseData('<?=$tCardShiftTopUpBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
						<i class="fa fa-arrow-left xCNIcon"></i>	
					</a>
					<ol id="oliCardShiftTopUpNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
						<li class="xWBtnPrevious" onclick="JCNxBrowseData('<?=$tCardShiftTopUpBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?= language('document/card/cardtopup','tCardShiftTopUpTitle')?></a></li>
						<li class="active"><a><?= language('document/card/cardtopup','tCardShiftTopUpTitleAdd')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-md-6 text-right">
					<div id="odvCardShiftTopUpBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
						<button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCardShiftTopUp').click()"><?= language('common/main/main', 'tSave')?></button>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<div class="xCNMenuCump xCNCardShiftTopUpBrowseLine" id="odvMenuCump">
	&nbsp;
</div>
<div class="main-content" id="odvMainContent" style="background-color: #F0F4F7;">    
	<div id="odvContentPageCardShiftTopUp"></div>
</div>
<script src="<?= base_url('application/modules/document/assets/src/cardshifttopup/jCardShiftTopUp.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/vendor/rabbitmq/stomp.min.js'); ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/vendor/rabbitmq/sockjs.min.js'); ?>"></script>
