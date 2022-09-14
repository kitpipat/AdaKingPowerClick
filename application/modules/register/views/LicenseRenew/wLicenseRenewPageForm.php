<style>
.xFontWeightBold{
	font-weight: bold;
}
</style>
<div class="main-content">
	<div class="panel panel-headline">
		<input type="hidden" name="tUserCode" id="tUserCode" value="<?=$this->session->userdata('tSesUserCode')?>">
		<div class="row">
			<div class="col-md-12">
				<div class="panel-body">

					<!--ตารางแผนการใช้งาน-->
					<div class="row">
							<div class="col-md-12">
								<label class="xFontWeightBold"><?php echo language('register/register','tLicensePackageAddOn') ?></label>
									<div class="table-responsive">
										<table class="table table-striped" style="width:100%">
											<thead>
												<tr>
													<th  width="5%" class="text-center"><?php echo language('register/register','tSrvTBChoose') ?></th>
													<th  width="5%" class="text-center"><?php echo language('register/register','tIMRSeq') ?></th>
													<th  width="15%" class="text-left"><?php echo language('register/register','tPtyName') ?></th>
													<th  class="text-left"><?php echo language('register/register','tPdtCode') ?></th>
													<th  class="text-center" width="20%"><?php echo language('register/register','tLicStart') ?></th>
													<th  class="text-center" width="20%"><?php echo language('register/register','tLicFinish') ?></th>
												</tr>
											</thead>
											<tbody id="otbIMRBchDataTable">
											<?php 
											if(!empty($aLicensePackageAddOn)){ 
														foreach($aLicensePackageAddOn as $nK => $aData){
														?>
												<tr>
												<?php if($aData['rtPtyCode']=='00001'){ ?>
													<td class="text-center">
														<label class="fancy-checkbox">
															<input id="ocbListItem<?=$nK?>" type="checkbox" class="ocbPackageLicCode" name="ocbPackageLicCode[]" value="<?=$aData['rtPdtCode']?>" checked>
															<span>&nbsp;</span>
														</label>
													</td>
													<?php }else{ ?>
													<td class="text-center">
														<label class="fancy-checkbox">
															<input id="ocbListItem<?=$nK?>" type="checkbox" class="ocbFeatureLicCode" name="ocbFeatureLicCode[]" value="<?=$aData['rtPdtCode']?>" checked>
															<span>&nbsp;</span>
														</label>
													</td>
												<?php } ?>
													<td align="center"><?=($nK+1)?></td>
													<td><?=$aData['rtPtyName']?></td>
													<td><?=$aData['rtPdtName']?></td>
													<!-- <td align="center"><?=$aData['rtLicRefUUID']?></td> -->
													<td align="center"><?=date('d/m/Y',strtotime($aData['rtLicStart']))?></td>
													<td align="center"><?=date('d/m/Y',strtotime($aData['rtLicFinish']))?></td>
												</tr>

											<?php
														}
												}else{
											?>
												<tr id="otrIMRDataNotFound">
													<td colspan="6" align="center"><?php echo language('register/register','tIMRNotFound') ?></td>
												
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
							</div>
					</div>
					<hr>

					<!--ตารางจุดขาย-->
					<div class="row">
							<div class="col-md-12">
								<label class="xFontWeightBold"><?php echo language('register/register','ะLicenseClientPos') ?></label>
									<div class="table-responsive">
										<table class="table table-striped" style="width:100%">
											<thead>
												<tr>
													<th  width="5%" class="text-center"><?php echo language('register/register','tSrvTBChoose') ?></th>
													<th  width="5%" class="text-center"><?php echo language('register/register','tIMRSeq') ?></th>
													<th  width="15%" class="text-left"><?php echo language('register/register','tPtyName') ?></th>
													<th  class="text-left"><?php echo language('register/register','tPdtCode') ?></th>
													<th  class="text-left" width="10%"><?php echo language('register/register','tLicRefUUID') ?></th>
													<th  class="text-center" width="20%"><?php echo language('register/register','tLicStart') ?></th>
													<th  class="text-center" width="20%"><?php echo language('register/register','tLicFinish') ?></th>
												</tr>
											</thead>
											<tbody id="otbIMRBchDataTable">
											<?php 
											if(!empty($aLicenseClientPos)){ 
														foreach($aLicenseClientPos as $nK => $aData){

														?>
												<tr>
												<td class="text-center">
														<label class="fancy-checkbox">
															<input id="ocbListItem<?=$nK?>" type="checkbox" class="ocbClientLicCode" name="ocbClientLicCode[]" value="<?=$aData['rtPdtCode']?>" data-uuid="<?=$aData['rnLicUUIDSeq']?>" checked>
															<span>&nbsp;</span>
														</label>
													</td>
													<td align="center"><?=($nK+1)?></td>
													<td><?=$aData['rtPtyName']?></td>
													<td><?=$aData['rtPdtName']?></td>
													<td align="center"><?=( $aData['rtLicRefUUID']  == '') ? '-' : $aData['rtLicRefUUID']?></td>
													<td align="center"><?=date_format(date_create($aData['rtLicStart']),'d/m/Y')?></td>
													<td align="center"><?=date_format(date_create($aData['rtLicFinish']),'d/m/Y')?></td>
												</tr>

											<?php
														}
												}else{
											?>
												<tr id="otrIMRDataNotFound">
													<td colspan="7" align="center"><?php echo language('register/register','tIMRNotFound') ?></td>
												
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
							</div>
					</div>

					<!--ปุ่มสรุปบิล-->
					<div class="row">
						<div class="col-md-9" align="right" >
							<label style="margin-top: 5px;"><b><?php echo language('register/register','tIMRRenew') ?></b></label>
						</div>
							
						<div class="col-md-2" align="right" >
							<select name="ocmRenewmonth"  id="ocmRenewmonth" class="form-control">
							<?php if(!empty($aUnitPdtPackge)){ 
									foreach($aUnitPdtPackge as $aDataUnit){
								?>
								<option value="<?=$aDataUnit['rtPunCode']?>"><?=$aDataUnit['rtPunName']?></option>
								<?php 
									}
									}else{ ?>
									<option value=""><?php echo language('register/register','tIMRRenewCheckAdjPri') ?></option>
								<?php } ?>
							</select>
						</div>

						<div class="col-md-1">
							<button style="width: 100%;" type="button" class="btn btn-primary" name="obtCheckBill" id="obtCheckBill" onclick="FSxLRNCallCheckBill()" ><?php echo language('register/register','tIMRRenewCheckBill') ?></button>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

