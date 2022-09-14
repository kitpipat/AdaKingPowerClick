<style>
.xFontWeightBold{
	font-weight: bold;
}
</style>
<input type="hidden" name="oetCstKey" id="oetCstKey" value="<?=$aResultPdtHD['raItems']['FTCstCode']?>" >
<input type="hidden" name="oetDocNo" id="oetDocNo" value="<?=$aResultPdtHD['raItems']['FTXshDocNo']?>" >
<div class="panel panel-headline">
    <div class="panel-body" style="padding-top:20px !important;">

        <div class="col-xl-12 col-lg-12 col-md-12" id="odvContentContainer">

		<div class="row">

							<div class="col-md-2"   style="border-right:1px solid #eee;" >
							<div class="col-md-12" >
								 	<label class="xFontWeightBold"><?php echo language('customerlicense/customerlicense/customerlicense','tAplThBchName') ?></label>
								 </div>
							   <div class="col-md-12" >
								 	<label class="xFontWeightBold"><?php echo language('customerlicense/customerlicense/customerlicense','tAplThDocNo') ?></label>
								 </div>
								 <div class="col-md-12" >
								 	<label class="xFontWeightBold"><?php echo language('customerlicense/customerlicense/customerlicense','tAplThDate') ?></label>
								 </div>
								 <div class="col-md-12" >
								 	<label class="xFontWeightBold"><?php echo language('register/register','tIMRRefCodeCstKey') ?></label>
								 </div>
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
							<div class="col-md-6">


							<div class="col-md-12">
								 	<label class=""><?=$aResultPdtHD['raItems']['FTBchCode']?></label>
								 </div>
				
						      <div class="col-md-12">
								 	<label class=""><?=$aResultPdtHD['raItems']['FTXshDocNo']?></label>
								 </div>
								 <div class="col-md-12">
								 	<label class=""><?=date('d/m/Y',strtotime($aResultPdtHD['raItems']['FDXshDocDate']))?></label>
								 </div>
								<div class="col-md-12">
								 	<label class=""><?=$aResultPdtHD['raItems']['FTCstCode']?></label>
								 </div>
				
								 <div class="col-md-12">
								 	<label class=""><?=$aResultPdtHD['raItems']['FTRegBusName']?></label>
								 </div>
								 <div class="col-md-12">
								 	<label class=""><?=$aResultPdtHD['raItems']['FTRegBusOth']?></label>
								 </div>
								 <div class="col-md-12">
								 	<label class=""><?=$aResultPdtHD['raItems']['FTRegTel']?></label>
								 </div>
								 <div class="col-md-12">
								 	<label class=""><?=$aResultPdtHD['raItems']['FTRegEmail']?></label>
								 </div>
							</div>

		</div>

	    <hr>

        <div class="row">



	<?php
	   $tPtyName = "";
		if(!empty($aResultPdtDT['raItems'])){
			foreach($aResultPdtDT['raItems'] as $nKey => $aDataDetail){
	?>

	<?php  if($tPtyName!=$aDataDetail['FTPtyName']){     ?>
				<div class="col-xs-12 col-md-12 col-lg-12">
						<label class="xCNLabelFrm"><?= $aDataDetail['FTPtyName']?></label>
						<div class="table-responsive">
							<table id="otbRecheckPackage" class="table table-striped">
								<thead>
									<tr>
										<th class="text-center xCNTextBold" style="width:5%;"><?= language('common/main/main','tModalAdvNo')?></th>
										<th class="text-center xCNTextBold"><?= $aDataDetail['FTPtyName']?></th>
										<th class="text-center xCNTextBold" style="width:15%;"><?= language('customerlicense/customerlicense/customerlicense','tTBTime')?></th>
										<th class="text-center xCNTextBold text-right" style="width:15%;"><?= language('customerlicense/customerlicense/customerlicense','tTBTotal')?></th>
									</tr>
								</thead>
								<tbody>
								<?php  } ?>

												<tr>
													<td class="text-center"><?=$aDataDetail['row_num']?></td>
													<td class="text-left"><?=$aDataDetail['FTBuyLicenseTextPackage']?></td>
													<td class="text-center"><?=$aDataDetail['FTBuyLicenseTextPackageMonth']?></td>
													<td class="text-right"><?=number_format($aDataDetail['LicenseTextPackagePrice'],$nDecimalShow)?></td>
												</tr>


								<?php  if($aDataDetail['row_num']==$aDataDetail['LastPdtPty']){  ?>
								</tbody>
							</table>
						</div>
					</div>
			<?php  } ?>


				<?php 

				$tPtyName = $aDataDetail['FTPtyName'];
			
					}
	  		}
				   ?>
				   
   <!--สรุปบิลรวมเงิน-->
   <div class="col-xs-12 col-md-12 col-lg-12" style="margin-top:10px;">
            <div class="row">
                <div class="col-xs-8 col-md-8 col-lg-8"></div>
                <!--รวมเงิน-->
                <div class="col-xs-4 col-md-4 col-lg-4">
                    <div class="table-responsive">
                        <table id="otbTotalPrice" class="table">
                           <tbody>
                                <?php if($aResultPdtHD['rtCode'] == 1){ ?>
                                    <tr>
                                        <?php $cXshTotal = $aResultPdtHD['raItems']['FCXshTotal']; ?>
                                        <td class='text-left'><?= language('customerlicense/customerlicense/customerlicense','tTBMoneyTotal')?></td>
                                        <td class='text-right'><?=number_format($cXshTotal,$nDecimalShow)?></td>
                                    </tr>
									<tr>
										<?php $cXddValue = $aResultPdtHD['raItems']['FCXddValue']; ?>
                                        <td class='text-left'><?= language('customerlicense/customerlicense/customerlicense','tTBMoneyDiscount')?></td>
                                        <td class='text-right'><?=number_format($cXddValue,$nDecimalShow)?></td>
                                    </tr>
                                    <tr>
										<?php $cXshVat = $aResultPdtHD['raItems']['FCXshVat']; ?>
                                        <td class='text-left'><?= language('customerlicense/customerlicense/customerlicense','tTBMoneyVat')?>%</td>
                                        <td class='text-right'><?=number_format($cXshVat,$nDecimalShow)?></td>
                                    </tr>
                                    <tr>
									<?php $cXshGrand = $aResultPdtHD['raItems']['FCXshGrand']; ?>
                                        <td class='text-left'><?= language('customerlicense/customerlicense/customerlicense','tTBMoneyGrand')?></td>
                                        <td class='text-right'><?=number_format($cXshGrand,$nDecimalShow)?></td>
                                    </tr>
                                <?php }else{ ?>
                                    <tr>
                                        <td class='text-left'><?= language('customerlicense/customerlicense/customerlicense','tTBMoneyTotal')?></td>
                                        <td class='text-right'><?=number_format(0.00,$nDecimalShow)?></td>
                                    </tr>
                                    <tr>
                                        <td class='text-left'><?= language('customerlicense/customerlicense/customerlicense','tTBMoneyVat')?>%</td>
                                        <td class='text-right'><?=number_format(0.00,$nDecimalShow)?></td>
                                    </tr>
                                    <tr>
                                        <td class='text-left'><?= language('customerlicense/customerlicense/customerlicense','tTBMoneyGrand')?></td>
                                        <td class='text-right'><?=number_format(0.00,$nDecimalShow)?></td>
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
</div>
<?php Include 'script/jApproveLicPageForm.php'; ?>
