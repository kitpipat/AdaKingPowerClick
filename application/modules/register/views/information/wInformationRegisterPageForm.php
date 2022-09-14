<style>
	.xFontWeightBold{
		font-weight: bold;
	}

	.xCNBtnBuyLicence{
		height: 150px;
		width: 150px;
		margin-right: 10px;
		border-color: #179bfd;
		color : #179bfd;
		font-size: 20px;
		font-family: THSarabunNew-Bold;
		margin-top: 5px;
	}

	.xCNBtnBuyLicence:hover{
		background-color: #179bfd;
		color : #FFF;
	}

	img.xCNImageIconLast {
		display: none;  
	}
	.xCNBtnBuyLicence:hover img.xCNImageIconFisrt {
		display: none;  
	}

	.xCNBtnBuyLicence:hover .xCNImageIconLast {
		display: block;  
	}

	.xCNImageInformationBuy{
		width: 30px; 
		display: block; 
		margin: 0px auto; 
		margin-bottom: 10px;
	}

	@media (min-width:320px)  { .xCNDisplayButton{ padding: 15px; } }
    @media (min-width:1025px) { .xCNDisplayButton{ float: right; } }
    @media (min-width:1281px) { .xCNDisplayButton{ float: right; } }

</style>

<div class="main-content">

	<!--ส่วนของรายละเอียดด้านบน-->
	<div class="panel panel-headline">
		<div class="row">
			<div class="col-md-12">
				<div class="panel-body">
					
					<?php  if($nStaMassage==1){ ?>
						<div class="row">
							<div class="col-lg-2 col-md-2 col-sm-3" style="color:red">
								&nbsp;
							</div>
							<div class="col-lg-10 col-md-2 col-sm-3" style="color:red">
								<?=language('register/register','tIMRMassgeShowRegister') ?> 
								<label class="xFontWeightBold" style="cursor:pointer" onclick="FSvIMRCallPageRegister('BuyLicense/1')" >
									<?php echo language('register/register','tIMRMassgeClickToRegister') ?>
								</label>
							</div>
						</div>
					<?php } ?>
					
					<!--Table ข้อมูลส่วนตัว -->
					<div class="row" >
						<!-- <div class="col-md-4"> -->
							<?php //echo $tPatchImg;?>
						<!-- </div> -->

						<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6"  style="border-right:1px solid #eee; margin-top:20px;">
							<div class="col-md-12"  <?php if(empty($this->session->userdata('tSesCstKey'))){ ?> style="padding-bottom:13px"  <?php } ?>>
								<label class="xFontWeightBold"><?php echo language('register/register','tIMRRefCodeCstKey') ?></label>
							</div>
							<!-- <div class="col-md-12">
								<label class="xFontWeightBold"><?php echo language('register/register','tIMRCstName') ?></label>
							</div> -->
							<div class="col-md-12">
								<label class="xFontWeightBold"><?php echo language('register/register','tIMRMerName') ?></label>
							</div>
							<div class="col-md-12">
								<label class="xFontWeightBold"><?php echo language('register/register','tIMRMerType') ?></label>
							</div>
							<div class="col-md-12">
								<label class="xFontWeightBold"><?php echo language('register/register','tIMRPhone') ?></label>
							</div>
							<div class="col-md-12">
								<label class="xFontWeightBold"><?php echo language('register/register','tIMREmail') ?></label>
							</div>
						</div>

						<div class="col-lg-5 col-md-2 col-sm-6 col-xs-6" style="margin-top:20px;">
							<div class="row">
							<?php if(!empty($this->session->userdata('tSesCstKey'))){ ?>
								<div class="col-md-12">
									<label class=""><?=$this->session->userdata('tSesCstKey')?></label>	<input type="hidden" class="form-control" name="oetIMRCstKey" id="oetIMRCstKey" value="<?=$this->session->userdata('tSesCstKey')?>">
								</div>
								<input type="hidden" class="form-control" name="ohdStaUpdAcc" id="ohdStaUpdAcc" value="1">
							<?php }else{ ?>
								<div class="col-md-6" style="padding-bottom:10px">
								<input type="hidden" class="form-control" name="ohdStaUpdAcc" id="ohdStaUpdAcc" value="2">
									<input type="text" class="form-control" name="oetIMRCstKey" id="oetIMRCstKey" value="<?=$tIMRCstKey?>">
								</div>
								<div class="col-md-6">
									<button class="btn btn-success" onclick="JSxIMRGetPageFormAndCallAPI()" ><?php echo language('register/register','tIMRRefresh') ?></button>
								</div>
							<?php } ?>
								<!-- <div class="col-md-12">
									<label class=""><?=$tCstName?></label>
								</div> -->  
								<div class="col-md-12">
									<label class=""><?=$tRegBusName?></label>
								</div>
								<div class="col-md-12">
									<label class=""><?=$tRegBusType?></label>
								</div>
								<div class="col-md-12">
									<label class=""><?=$tCstTel?></label>
								</div>
								<div class="col-md-12">
									<label class=""><?=$tCstEmail?></label>
								</div>
							</div>
						</div>

						<!--ปุ่มด้านขวา-->
						<?php if(!empty($this->session->userdata('tSesCstKey'))){ ?>
							<div class="col-lg-5 col-md-8 col-sm-12 col-xs-12">
								<div class="row xCNDisplayButton">

									<!--ปุ่มต่ออายุการใช้งาน-->
									<?php if($this->session->userdata('bSesRegStaBuyPackage') != false){ ?>
										<button type="button" class="btn xCNBtnBuyLicence" name="obtIMRRenew" id="obtIMRRenew"  onclick="FSvIMRCallPageRegister('LicenseRenew')" >
											<img class='xCNImageInformationBuy xCNImageIconFisrt' style="width:50px;" src="<?=base_url().'/application/modules/common/assets/images/icons/Infor_renew.png'?>"> 
											<img class='xCNImageInformationBuy xCNImageIconLast' style="width:50px;" src="<?=base_url().'/application/modules/common/assets/images/icons/Infor_renew_White.png'?>"> 
											<label id="olbIMRRenew"><?=language('register/register','tIMRRenew') ?></label>
										</button>
									<?php } ?>
									
									<!--ปุ่มอัพเกรดแพ๊คเก็จ-->
									<?php // if($this->session->userdata('tSessionRegLicType')!='1'){ // Demo Package ยังไม่สามารถอัพเกรด ได้ ?>
										<button type="button" class="btn xCNBtnBuyLicence" name="obtIMRBuyicense" id="obtIMRBuyicense"  onclick="FSvIMRCallPageRegister('BuyLicense/0')" >
											<img class='xCNImageInformationBuy xCNImageIconFisrt' style="width:50px;" src="<?=base_url().'/application/modules/common/assets/images/icons/Infor_upgrade.png'?>"> 
											<img class='xCNImageInformationBuy xCNImageIconLast' style="width:50px;" src="<?=base_url().'/application/modules/common/assets/images/icons/Infor_upgrade_White.png'?>"> 
											<label id="olbIMRBuyicense"><?=language('register/register','tUpgradePackage') ?></label>
										</button>
									<?php //} ?>

									<!--ปุ่มซื้อเพิ่ม-->
									<?php if($this->session->userdata('tSessionRegLicType')!='1'){ // Demo Package ยังไม่สามารถอัพเกรด ได้ ?>
										<button type="button" class="btn xCNBtnBuyLicence" name="obtAddOnFeature" id="obtAddOnFeature"  onclick="FSvLRNCallPageRegisterStepAddOn()" >
											<img class='xCNImageInformationBuy xCNImageIconFisrt' style="width:50px;" src="<?=base_url().'/application/modules/common/assets/images/icons/Infor_addon.png'?>"> 
											<img class='xCNImageInformationBuy xCNImageIconLast' style="width:50px;" src="<?=base_url().'/application/modules/common/assets/images/icons/Infor_addon_White.png'?>"> 
											<label id="olbAddOnFeature"><?=language('register/register','tIMRChagePackedOrAddOn') ?></label>
										</button>
									<?php } ?>
								</div>
							</div>
						<?php } ?>


					</div>
				</div>
			</div>
		</div>
	</div>

	<!--ส่วนของตารางส่วนล่าง-->
	<div class="panel panel-headline">
		<input type="hidden" name="tUserCode" id="tUserCode" value="<?=$this->session->userdata('tSesUserCode')?>">
		<div class="row">
			<div class="col-md-12">
				<div class="panel-body">
					
					<!--Table แผนการใช้งาน -->
					<div class="row">
						<div class="col-md-12">
							<label class="xFontWeightBold"><?php echo language('register/register','tLicensePackageAddOn') ?></label>
							<div class="table-responsive">
								<table class="table table-striped" style="width:100%" id="otbFeatureAndPackage">
									<thead>
										<tr >
											<th  width="5%" class="text-center"><?php echo language('register/register','tIMRSeq') ?></th>
											<th  width="15%"><?php echo language('register/register','tPtyName') ?></th>
											<th  ><?php echo language('register/register','tPdtCode') ?></th>
											<!-- <th  width="20%"><?php echo language('register/register','tLicRefUUID') ?></th> -->
											<th  width="10%" class="text-center"><?php echo language('register/register','tLicStart') ?></th>
											<th  width="10%" class="text-center"><?php echo language('register/register','tLicFinish') ?></th>
											<th  width="10%"><?php echo language('register/register','tLicStatus') ?></th>
										</tr>
									</thead>
									<tbody id="otbIMRBchDataTable">
									<?php 
										if(!empty($aLicensePackageAddOn)){ 
											foreach($aLicensePackageAddOn as $nK => $aData){
												if($aData['rtLicFinish']<date('Y-m-d')){
													$dLicStaExp = '<span  style="color:red">'.language('customerlicense/customerlicense/customerlicense','tCBLStatusExp').'</span>';
												}else{
													$dLicStaExp = '<span  style="color:green">'.language('customerlicense/customerlicense/customerlicense','tCBLStatus1').'</span>';
												}
									?>
										<tr data-pdtcode='<?=$aData['rtPtyCode']?>'>
											<td align="center"><?=($nK+1)?></td>
											<td><?=$aData['rtPtyName']?></td>
											<td><?=($aData['rtPdtName'] == '') ? '-' : $aData['rtPdtName'] ?></td>
											<!-- <td align="center"><?=$aData['rtLicRefUUID']?></td> -->
											<td align="center"><?=date('d/m/Y',strtotime($aData['rtLicStart']))?></td>
											<td align="center"><?=date('d/m/Y',strtotime($aData['rtLicFinish']))?></td>
											<td><?=$dLicStaExp?></td>
										</tr>

									<?php }
										}else{ ?>
											<tr id="otrIMRDataNotFound">
												<td colspan="6" align="center"><?php echo language('register/register','tIMRNotFound') ?></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<!--Table ข้อมูลสาขา -->
					<hr>
					<div class="row">
						<div class="col-md-12">
						<label class="xFontWeightBold"><?php echo language('register/register','tIMRBranch') ?></label>
							<div class="table-responsive">
								<table class="table table-striped" style="width:100%">
									<thead>
										<tr >
											<th  width="5%" class="text-center"><?php echo language('register/register','tIMRSeq') ?></th>
											<th  width="15%"><?php echo language('register/register','tIMRBchCode') ?></th>
											<th  ><?php echo language('register/register','tIMRBchName') ?></th>
											<th  width="10%" class="text-right"><?php echo language('register/register','tIMRQtyPos') ?></th>
										</tr>
									</thead>
									<tbody id="otbIMRBchDataTable">
									<?php 
									if(!empty($oCstBch)){ 
												foreach($oCstBch as $aData){
												?>
										<tr>
											<td align="center"><?=$aData['rnCbrSeq']?></td>
											<td><?=$aData['rtCbrRefBch']?></td>
											<td><?=($aData['rtCbrRefBchName'] == '') ? '-' : $aData['rtCbrRefBchName'] ?></td>
											<td align="right"><?=$aData['rnCbrQtyPos']?></td>
										</tr>

									<?php }
										}else{ ?>
											<tr id="otrIMRDataNotFound">
												<td colspan="4" align="center"><?php echo language('register/register','tIMRNotFound') ?></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<!--Table จุดขาย -->					
					<hr>
					<div class="row">
						<div class="col-md-12">
							<label class="xFontWeightBold"><?php echo language('register/register','ะLicenseClientPos') ?></label>
							<div class="table-responsive">
								<table class="table table-striped" style="width:100%">
									<thead>
										<tr >
											<th  width="5%" class="text-center"><?php echo language('register/register','tIMRSeq') ?></th>
											<th  width="10%"><?php echo language('register/register','tRefBch') ?></th>
											<th  width="10%"><?php echo language('register/register','tRefPos') ?></th>
											<th  width="10%"><?php echo language('register/register','tPtyName') ?></th>
											<th  ><?php echo language('register/register','tPdtCode') ?></th>
											<th  width="10%"><?php echo language('register/register','tLicRefUUID') ?></th>
											<th  width="10%" class="text-center"><?php echo language('register/register','tLicStart') ?></th>
											<th  width="10%" class="text-center"><?php echo language('register/register','tLicFinish') ?></th>
											<th  width="10%"><?php echo language('register/register','tLicStatus') ?></th>
										</tr>
									</thead>
									<tbody id="otbIMRBchDataTable">
									<?php 
									if(!empty($aLicenseClientPos)){ 
										foreach($aLicenseClientPos as $nK => $aData){
											if($aData['rtLicFinish']<date('Y-m-d')){
												$dLicStaExp = '<span  style="color:red">'.language('customerlicense/customerlicense/customerlicense','tCBLStatusExp').'</span>';
											}else{
												$dLicStaExp = '<span  style="color:green">'.language('customerlicense/customerlicense/customerlicense','tCBLStatus1').'</span>';
											}
									?>
										<tr>
											<td align="center"><?=($nK+1)?></td>
											<td><?=$aData['rtRefBch']?></td>
											<td><?=$aData['rtCbrRefPos']?></td>
											<td><?=$aData['rtPtyName']?></td>
											<td><?=$aData['rtPdtName']?></td>
											<td align=""><?=( $aData['rtLicRefUUID']  == '') ? '-' : $aData['rtLicRefUUID']?></td>
											<td align="center"><?=date_format(date_create($aData['rtLicStart']),'d/m/Y')?></td>
											<td align="center" ><?=date_format(date_create($aData['rtLicFinish']),'d/m/Y')?></td>
											<td><?=$dLicStaExp?></td>
										</tr>
									<?php }
										}else{ ?>
										<tr id="otrIMRDataNotFound">
											<td colspan="9" align="center"><?php echo language('register/register','tIMRNotFound') ?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<script>

    var nFeatureAndPackage = $('#otbFeatureAndPackage tbody tr').length;
	var nCheckHavePacked = 0;

	for(var i=0; i<=nFeatureAndPackage; i++){
		var nPTYCode = $('#otbFeatureAndPackage tbody tr:eq('+i+')').data('pdtcode');
		if(nPTYCode == '00001'){
			nCheckHavePacked++;
		}
	}
	
	//เนลว์ ตรวจสอบว่ามีแพคเกจหรือไม่ 
	// alert(nCheckHavePacked);
	if(nCheckHavePacked>0){
		$('#obtAddOnFeature').show();
	}else{
		$('#obtAddOnFeature').hide();
		var tLangSelectPackage = '<?=language('register/buylicense/buylicense','tTextBTNPackage')?>';
		$('#olbIMRBuyicense').text(tLangSelectPackage);

	}

	
 	//Functionality : Event Add-On
    //Parameters    : URL
    //Creator       : 08/02/2021
    //Return        : -
    //Return Type   : -
    function FSvLRNCallPageRegisterStepAddOn(){
        $.ajax({
            url     : 'BuyLicense/3',
            type    : "POST",
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxCloseLoading();
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            },
            success: function (tView) {
                $(window).scrollTop(0);
                $('.odvMainContent').html(tView);
                setTimeout(function(){ JSxNextStepToPageAddOnExtend(); }, 1000);
            }
        });
    }
</script>