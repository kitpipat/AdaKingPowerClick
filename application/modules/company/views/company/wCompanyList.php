<?php
	if(isset($aCompData) && $aCompData['rtCode'] == '1'){
		$tImgRate       = $aCompData['raItems']['rtCmpRteImage'];
		$tCmpCode       = $aCompData['raItems']['rtCmpCode'];
		$tCmpName       = $aCompData['raItems']['rtCmpName'];
		$tCmpBchName    = $aCompData['raItems']['rtCmpBchName'];
		$tBchStaHQ      = $aCompData['raItems']['rtCmpBchStaHQ'];
		$tCmpShop       = $aCompData['raItems']['rtCmpShop'];
		$tCmpDirector   = $aCompData['raItems']['rtCmpDirector'];
		$tCmpEmail      = $aCompData['raItems']['rtCmpEmail'];
		$tCmpFax        = $aCompData['raItems']['rtCmpFax'];
		$tCmpTel        = $aCompData['raItems']['rtCmpTel'];
		$tCmpVatCode	= $aCompData['raItems']['rtVatCodeUse'];
		$tCmpRetInOrEx  = ($aCompData['raItems']['rtCmpRetInOrEx']=='1')? language('company/company/company', 'tCMPInclusive') : language('company/company/company', 'tCMPExclusive');
		$tCmpWhsInOrEx  = ($aCompData['raItems']['rtCmpWhsInOrEx']=='1')? language('company/company/company', 'tCMPInclusive') : language('company/company/company', 'tCMPExclusive');
		$tCmpRteCode    = $aCompData['raItems']['rtCmpRteCode'];
		$tCmpRteName    = $aCompData['raItems']['rtCmpRteName'];
	}else{
		$tImgRate       = "";
		$tCmpCode       = "";
		$tCmpName       = "";
		$tCmpBchName    = "";
		$tBchStaHQ		= "";
		$tCmpShop       = "";
		$tCmpDirector   = "";
		$tCmpEmail      = "";
		$tCmpFax        = "";
		$tCmpTel        = "";
		$tCmpVatCode	= "";
		$tCmpRetInOrEx  = "";
		$tCmpWhsInOrEx  = "";
		$tCmpRteCode    = "";
	}
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/company/assets/css/localcss/ada.utilitycompany.css">
<div id="divCompany" class="panel panel-headline">
	<div class="panel-body" style="padding-top:20px !important;">
		<div class="custom-tabs-line tabs-line-bottom left-aligned">
			<ul class="nav" role="tablist">
                <li class="nav-item  active" id="oliInforGeneralTap">
                    <a class="nav-link flat-buttons active" data-toggle="tab" href="#odvInforGeneralTap" role="tab" aria-expanded="false" onclick="">
                        <?php echo language('company/company/company','tPageAddTabNameGeneral');?> 
                    </a>
                </li>

                <li class="nav-item" id="oliInforAddressTap">
                    <a class="nav-link flat-buttons" data-toggle="tab" href="#odvInforAddressTap" role="tab" aria-expanded="false">
                        <?php echo language('company/company/company', 'tPageAddTabNameAddress');?>
                    </a>
                </li>

				<!-- Create By Witsarut 19/10/2019 -->
				<!-- เพิ่ม Tab SettingCOnnection -->
				<li class="nav-item" id="oliInforSettingConTab">
                    <a class="nav-link flat-buttons" data-toggle="tab" href="#odvInforSettingConTab" role="tab" aria-expanded="false">
                        <?php //echo language('company/company/company', 'tPageAddTabSettingConnection');?>
                    </a>
                </li>

			</ul>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="tab-content">
					<div id="odvInforGeneralTap" class="tab-pane active" style="margin-top:10px;" role="tabpanel" aria-expanded="true">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
								<?php echo  FCNtHGetImagePageList($tImgComp, '400px'); ?>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
								<div class="row p-t-10 p-b-20">
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPSecInfor');?></label>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
										<?php
											if(isset($tBchStaHQ) && $tBchStaHQ == 1){
												$tTextCompStaHQ = language('company/company/company','tCmpStaHQ');
											}else{
												$tTextCompStaHQ = language('company/company/company','tCmpStaSubBch');
											}
										?>
										<label class="xCNLabelFrm" style="font-size:25px !important;color:green !important;">[ <?php echo $tTextCompStaHQ;?> ]</label>
									</div>
								</div>
								<div class="row p-l-40">
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<div class='form-group'>
											<label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPName') ?></label>
											<p class="xCNTextDetail">
												<?php
													if(isset($tCmpName) && !empty($tCmpName)){
														echo @$tCmpName;
													}else{
														echo language('company/company/company','tCmpNotFoundData');
													}
												?>
											</p>
										</div>
									</div>
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<div class='form-group'>
											<label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPBranch');?></label>
											<p class="xCNTextDetail">
												<?php
													if(isset($tCmpName) && !empty($tCmpName)){
														echo @$tCmpBchName;
													}else{
														echo language('company/company/company','tCmpNotFoundData');
													}
												?>
											</p>
										</div>
									</div>
								</div>
								<div class="row p-l-40 ">
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 <?= !FCNbGetIsShpEnabled()? 'xCNHide' : ''; ?>">
										<div class="form-group">
											<label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPShop');?></label>
											<p class="xCNTextDetail">
												<?php
													if(isset($tCmpShop) && !empty($tCmpShop)){
														echo @$tCmpShop;
													}else{
														echo language('company/company/company','tCmpNotFoundData');
													}
												?>
											</p>
										</div>
									</div>
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<div class="form-group">
											<label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPDirector');?></label>
											<p class="xCNTextDetail">
												<?php
													if(isset($tCmpDirector) && !empty($tCmpDirector)){
														echo @$tCmpDirector;
													}else{
														echo language('company/company/company','tCmpNotFoundData');
													}
												?>
											</p>
										</div>
									</div>
								</div>
								<div class="row p-l-40">
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPTel');?></label>
										<p class="xCNTextDetail">
											<?php
												if(isset($tCmpTel) && !empty($tCmpTel)){
													echo @$tCmpTel;
												}else{
													echo language('company/company/company','tCmpNotFoundData');
												}
											?>
										</p>
									</div>
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPFax');?></label>
										<p class="xCNTextDetail">
											<?php
												if(isset($tCmpFax) && !empty($tCmpFax)){
													echo @$tCmpFax;
												}else{
													echo language('company/company/company','tCmpNotFoundData');
												}
											?>
										</p>
									</div>
								</div>
								<div class="row p-t-10 p-b-20">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPSecTax') ?></label>
									</div>
								</div>
								<div class="row p-l-40">
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPRetInOrEx');?></label>
										<p class="xCNTextDetail">
											<?php
												if(isset($tCmpRetInOrEx) && !empty($tCmpRetInOrEx)){
													echo @$tCmpRetInOrEx;
												}else{
													echo language('company/company/company','tCmpNotFoundData');
												}
											?>
										</p>
									</div>
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<!-- <label class="xCNLabelFrm"><?php //echo language('company/company/company','tCMPWhsInOrEx');?></label>
										<p class="xCNTextDetail">
											<?php
												//if(isset($tCmpWhsInOrEx) && !empty($tCmpWhsInOrEx)){
													//echo @$tCmpWhsInOrEx;
												//}else{
													//echo language('company/company/company','tCmpNotFoundData');
												//}
											?>
										</p> -->
									</div>
								</div>
								<div class="row p-l-40">
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPVatRate');?></label>
										<p class="xCNTextDetail">
											<?php
												if(isset($tCmpVatCode) && !empty($tCmpVatCode)){
													for($i=0; $i<FCNnHSizeOf($aVatRate['FTVatCode']); $i++){
														if($aVatRate['FTVatCode'][$i] == $tCmpVatCode){
															echo number_format($aVatRate['FCVatRate'][$i],0)." %";
														}
													}
												}else{
													echo language('company/company/company','tCmpNotFoundData');
												}
											?>
										</p>
									</div>
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPCurrency');?></label>
										<p class="xCNTextDetail">
											<?php
												if(isset($tCmpRteName) && !empty($tCmpRteName)){
													echo $tCmpRteName;
												}else{
													echo language('company/company/company','tCmpNotFoundData');
												}
											?>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div id="odvInforAddressTap" class="tab-pane" style="margin-top:10px;" role="tabpanel" aria-expanded="true">
						<div class="row p-b-20">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label class="xCNLabelFrm"><?php echo language('company/company/company','tPageAddTabNameAddressHead');?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="table-responsive">
									<table id="otbCompanyAddrBch" class="table table-striped" style="width:100%">
										<thead>
											<th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('company/company/company','tCmpAddrNo');?></th>
											<th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('company/company/company','tCmpAddrName');?></th>
											<th nowrap class="xCNTextBold text-center" style="width:15%;"><?php echo language('company/company/company','tCmpAddrTaxNo');?></th>
											<th nowrap class="xCNTextBold text-center"><?php echo language('company/company/company','tCmpAddrWebsite');?></th>
											<th nowrap class="xCNTextBold text-center"><?php echo language('company/company/company','tCmpAddrRemark');?></th>
											<th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('company/company/company','tCmpAddrDetail');?></th>
										</thead>
										<tbody>
											<?php if(isset($aCompAddress) && !empty($aCompAddress)):?>
												<?php foreach($aCompAddress AS $nKey => $aDataAddress):?>
													<tr class="xWCompDataAddr"
														data-addrlngid	="<?php echo $aDataAddress['rtAddLngID'];?>"
														data-addrgrptpe	="<?php echo $aDataAddress['rtAddGrpType'];?>"
														data-addrefcode="<?php echo $aDataAddress['rtAddRefCode'];?>"
														data-addrseqno="<?php echo $aDataAddress['rtAddSeqNo'];?>"
													>
														<td nowrap class="text-center"><?php echo (!empty($aDataAddress['rtRowID']))	? $aDataAddress['rtRowID']		: '-';?></td>
														<td nowrap class="text-left"><?php echo (!empty($aDataAddress['rtAddName']))	? $aDataAddress['rtAddName']	: '-';?></td>
														<td nowrap class="text-center"><?php echo (!empty($aDataAddress['rtAddTaxNo']))	? $aDataAddress['rtAddTaxNo']	: '-';?></td>
														<td nowrap class="text-center"><?php echo (!empty($aDataAddress['rtAddWebsite']))	? $aDataAddress['rtAddWebsite']	: '-';?></td>
														<td nowrap class="text-left"><?php echo (!empty($aDataAddress['rtAddRmk']))		? $aDataAddress['rtAddRmk']		: '-';?></td>
														<td nowrap class="text-center xCNTextDetail2">
															<img class="xCNIconTable xCNIconSearch xWCmpAddrDetail">
														</td>
													</tr>
												<?php endforeach;?>
											<?php else:?>
												<tr><td class='text-center xCNTextDetail2' colspan='6'><?php echo language('common/main/main', 'tCMNNotFoundData')?></td></tr>
											<?php endif;?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

					<!-- Create By Witsarut 19/10/2019 -->
					<!-- Tab SetingConection ตั้งค่าการเชื่อมต่อ -->							
					<div id="odvInforSettingConTab" class="tab-pane" style="margin-top:10px;" role="tabpanel" aria-expanded="true">
						<div class="row" style="margin-right:-30px; margin-left:-30px;">
							<div class="main-content" style="padding-bottom:0px !important;">
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<div id="odvModalAddressList" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<label class="xCNTextModalHeard" style="font-weight:bold;font-size:20px;"><?php echo language('company/company/company','tCmpAddrDetailInfo'); ?></label>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
						<button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="panel-body no-padding">
					<div class="custom-tabs-line tabs-line-bottom left-aligned">
						<ul class="nav" role="tablist">
							<li class="nav-item  active" id="oliInforGeneralTap">
								<a class="nav-link flat-buttons active" data-toggle="tab" href="#odvCompDataAddressInfo" role="tab" aria-expanded="false" onclick="">
									<?php echo language('company/company/company','tCmpAddrInfo');?> 
								</a>
							</li>
							<li class="nav-item" id="oliInforAddressTap">
								<a class="nav-link flat-buttons" data-toggle="tab" href="#odvCompDataAddressMap" role="tab" aria-expanded="false">
									<?php echo language('company/company/company', 'tCmpAddrMap');?>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="tab-content">
							<div id="odvCompDataAddressInfo" class="tab-pane active" style="margin-top:10px;" role="tabpanel" aria-expanded="true">
							</div>
							<div id="odvCompDataAddressMap" class="tab-pane" style="margin-top:10px;" role="tabpanel" aria-expanded="true">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'script/jCompanyList.php';?>