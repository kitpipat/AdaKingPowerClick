<input id="oetVocStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetVocCallBackOption" type="hidden" value="<?=$tBrowseOption?>">


<?php if(isset($nBrowseType) && $nBrowseType == 0) : ?>
	<div id="odvVocMainMenu" class="main-menu clearfix">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('coupontype/0/0');?> 
						<li id="oliVocTitle" class="xCNLinkClick" style="cursor:pointer" onclick="JSvCallPageCouponTypeList()"><?= language('coupon/coupontype/coupontype','tCPTTitle')?></li>
						<li id="oliVocTitleAdd" class="active"><a><?= language('coupon/coupontype/coupontype','tCPTTitleAdd')?></a></li>
						<li id="oliVocTitleEdit" class="active"><a><?= language('coupon/coupontype/coupontype','tCPTTitleEdit')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
					<div id="odvBtnVocInfo">
						<?php if($aAlwEventVoucher['tAutStaFull'] == 1 || $aAlwEventVoucher['tAutStaAdd'] == 1) : ?>
							<button id="obtVocAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageCoupontypeAdd()">+</button>
						<?php endif; ?>
					</div>
					<div id="odvBtnAddEdit">
						<button onclick="JSvCallPageCouponTypeList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"><?= language('common/main/main', 'tBack')?></button>
						<?php if($aAlwEventVoucher['tAutStaFull'] == 1 || ($aAlwEventVoucher['tAutStaAdd'] == 1 || $aAlwEventVoucher['tAutStaEdit'] == 1)) : ?>
							<div class="btn-group"  id="obtBarSubmitCpn">
								<div class="btn-group">
									<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitCoupontype').click()"><?= language('common/main/main', 'tSave')?></button>
									<?=$vBtnSave?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="xCNMenuCump xCNVocBrowseLine" id="odvMenuCump">
		&nbsp;
	</div>
	<div class="main-content">
		<div id="odvContentPageCoupontype" class="panel panel-headline">
		</div>
	</div>
<?php else: ?>
	<div class="modal-header xCNModalHead">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<a onclick="JCNxBrowseData('<?php echo $tBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
					<i class="fa fa-arrow-left xCNIcon"></i>	
				</a>
				<ol id="oliShpNavBrowse" class="breadcrumb xCNMenuModalBrowse">
					<li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('coupon/coupontype/coupontype','tCPTTitle')?></a></li>
					<li class="active"><a><?php echo  language('coupon/coupontype/coupontype','tCPTTitleAdd')?></a></li>
				</ol>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
				<div id="odvShpBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
					<button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCoupontype').click()"><?php echo  language('common/main/main', 'tSave')?></button>
				</div>
			</div>
		</div>
	</div>
	<div id="odvModalBodyBrowse" class="modal-body">
	</div>
<?php endif;?>

<script src="<?php echo base_url('application/modules/coupon/assets/src/Coupontype/jCoupontype.js')?>"></script>
