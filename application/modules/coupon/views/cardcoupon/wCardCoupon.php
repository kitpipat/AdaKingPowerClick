<input id="oetVocStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetVocCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<div id="odvVocMainMenu" class="main-menu clearfix">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<ol id="oliMenuNav" class="breadcrumb">
					<li id="oliVocTitle" class="xCNLinkClick" style="cursor:pointer" onclick="JSvCallPageCouponTypeList()"><?= language('coupon/cardcoupon/cardcoupon','tCPNTitle')?></li>
					<li id="oliVocTitleAdd" class="active"><a><?= language('coupon/cardcoupon/cardcoupon','tCPNTitleAdd')?></a></li>
					<li id="oliVocTitleEdit" class="active"><a><?= language('coupon/cardcoupon/cardcoupon','tCPNTitleEdit')?></a></li>
				</ol>
			</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
			<div class="demo-button xCNBtngroup" style="width:100%;">
				<div id="odvBtnVocInfo">
					<?php if($aAlwEventCardCoupon['tAutStaFull'] == 1 || $aAlwEventCardCoupon['tAutStaAdd'] == 1) : ?>
						<button id="obtVocAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageCardCouponAdd()">+</button>
					<?php endif; ?>
				</div>
					<div id="odvBtnAddEdit">
						<button onclick="JSvCallPageCouponTypeList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"><?= language('common/main/main', 'tBack')?></button>
						<?php if($aAlwEventCardCoupon['tAutStaFull'] == 1 || ($aAlwEventCardCoupon['tAutStaAdd'] == 1 || $aAlwEventVoucher['tAutStaEdit'] == 1)) : ?>
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
</div>
<div class="xCNMenuCump" id="odvMenuCump">
	&nbsp;
</div>
<div class="main-content">
	<div id="odvContentPageCardCoupontype" class="panel panel-headline">
	</div>
</div>

<script src="<?php echo base_url('application/modules/coupon/assets/src/Cardconpon/jCardcoupon.js')?>"></script>
