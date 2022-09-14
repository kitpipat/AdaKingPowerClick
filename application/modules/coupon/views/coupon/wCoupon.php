<input id="oetCpnStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetCpnCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<div id="odvCpnMainMenu" class="main-menu clearfix">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<ol id="oliMenuNav" class="breadcrumb">
					<li id="oliCpnTitle" class="xCNLinkClick" style="cursor:pointer" onclick="JSvCallPageCouponList()"><?= language('coupon/coupon/coupon','tCPNTitle')?></li>
					<li id="oliCpnTitleAdd" class="active"><a><?= language('coupon/coupon/coupon','tCPNTitleAdd')?></a></li>
					<li id="oliCpnTitleEdit" class="active"><a><?= language('coupon/coupon/coupon','tCPNTitleEdit')?></a></li>
				</ol>
			</div>
			
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
				<div class="demo-button xCNBtngroup" style="width:100%;">
					<div id="odvBtnCpnInfo">
						<?php if($aAlwEventCoupon['tAutStaFull'] == 1 || $aAlwEventCoupon['tAutStaAdd'] == 1) : ?>
							<button id="obtCpnAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageCouponAdd()">+</button>
						<?php endif; ?>
					</div>
					<div id="odvBtnAddEdit">
						<button onclick="JSvCallPageCouponList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"><?= language('common/main/main', 'tBack')?></button>
						<?php if($aAlwEventCoupon['tAutStaFull'] == 1 || ($aAlwEventCoupon['tAutStaAdd'] == 1 || $aAlwEventCoupon['tAutStaEdit'] == 1)) : ?>
							<div class="btn-group"  id="obtBarSubmitCpn">
								<div class="btn-group">
									<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitCoupon').click()"><?= language('common/main/main', 'tSave')?></button>
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
	<div id="odvContentPageCoupon" class="panel panel-headline">
	</div>
</div>
<script src="<?php echo base_url('application/modules/Coupon/assets/src/Coupon/jCoupon.js')?>"></script>