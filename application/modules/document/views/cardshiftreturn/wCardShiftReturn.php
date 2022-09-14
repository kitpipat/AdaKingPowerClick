<input id="oetCardShiftReturnStaBrowse" type="hidden" value="<?php echo $nCardShiftReturnBrowseType; ?>">
<input id="oetCardShiftReturnCallBackOption" type="hidden" value="<?php echo $tCardShiftReturnBrowseOption; ?>">

<div id="odvCardShiftReturnMainMenu" class="main-menu">
	<div class="xCNMrgNavMenu">
		<div class="xCNavRow" style="width:inherit;">

			<div class="xCNCardShiftReturnVMaster row">
				<div class="col-xs-12 col-md-7">
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('cardShiftReturn/0/0');?>
						<li id="oliCardShiftReturnTitle" class="xCNLinkClick" onclick="JSvCardShiftReturnCallPageCardShiftReturn('')"><?php echo language('document/card/cardreturn','tCardShiftReturnTitle'); ?></li>
						<li id="oliCardShiftReturnTitleAdd" class="active"><a href="javascrip:;"><?php echo language('document/card/cardreturn','tCardShiftReturnTitleAdd'); ?></a></li>
						<li id="oliCardShiftReturnTitleEdit" class="active"><a href="javascrip:;"><?php echo language('document/card/cardreturn','tCardShiftReturnTitleEdit'); ?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-md-5 text-right p-r-0">
					<div class="demo-button xCNBtngroup" style="width:100%;">
						<?php if($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAdd"] == "1") : ?>
						<div id="odvBtnCardShiftReturnInfo">
							<button id="obtCardShiftReturnAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCardShiftReturnCallPageCardShiftReturnAdd()">+</button>
						</div>
						<?php endif; ?>
						<div id="odvBtnAddEdit">
							<button onclick="JSvCardShiftReturnCallPageCardShiftReturn()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
							<?php if($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaPrint"] == "1") : ?>
							<button type="button" id="obtCardShiftReturnBtnDocMa" class="btn xCNBTNDefult xCNBTNDefult2Btn hidden" onclick="JSxCardShiftReturnPrint()"> <?php echo language('common/main/main', 'tCMNPrint'); ?></button>
							<?php endif; ?>
							<?php if($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaCancel"] == "1") : ?>
								<button id="obtCardShiftReturnBtnCancelApv" onclick="JSxCardShiftReturnStaDoc(false)" class="btn xCNBTNDefult xCNBTNDefult2Btn hidden" type="button"> <?php echo language('common/main/main', 'tCancel'); ?></button>
							<?php endif; ?>
							<?php if($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAppv"] == "1") : ?>
								<button id="obtCardShiftReturnBtnApv" onclick="JSxCardShiftReturnStaApvDoc(false)" class="btn xCNBTNPrimery xCNBTNDefult2Btn hidden" type="button"> <?php echo language('common/main/main', 'tCMNApprove'); ?></button>
							<?php endif; ?>
							<?php if($aPermission["tAutStaFull"] == "1" || $aPermission["tAutStaAdd"] || $aPermission["tAutStaEdit"]) : ?>
								<button type="button" id="obtCardShiftReturnBtnSave" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="$('#obtSubmitCardShiftReturnMainForm').click()"> <?php echo language('common/main/main', 'tSave'); ?></button>								
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>

			<div class="xCNCardShiftReturnVBrowse">
				<div class="col-xs-12 col-md-6">
					<a onclick="JCNxBrowseData('<?php echo $tCardShiftReturnBrowseOption; ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
						<i class="fa fa-arrow-left xCNIcon"></i>	
					</a>
					<ol id="oliCardShiftReturnNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
						<li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tCardShiftReturnBrowseOption; ?>')"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?php echo language('document/card/cardreturn','tCardShiftReturnTitle'); ?></a></li>
						<li class="active"><a><?php echo language('document/card/cardreturn','tCardShiftReturnTitleAdd'); ?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-md-6 text-right">
					<div id="odvCardShiftReturnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
						<button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCardShiftReturn').click()"><?php echo language('common/main/main', 'tSave'); ?></button>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<div class="xCNMenuCump xCNCardShiftReturnBrowseLine" id="odvMenuCump">
	&nbsp;
</div>
<div class="main-content" id="odvMainContent" style="background-color: #F0F4F7;">    
	<div id="odvContentPageCardShiftReturn"></div>
</div>
<script src="<?php echo base_url('application/modules/document/assets/src/cardshiftreturn/jCardShiftReturn.js'); ?>"></script>
