<?php 
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped" style="width:100%" id="otbZenobj">
                <thead>
					<tr class="xCNCenter">
					<?php if($aAlwEventZoneObj['tAutStaFull'] == 1 || $aAlwEventZoneObj['tAutStaDelete'] == 1) : ?>
                        <th class="xCNTextBold" style="width:1%;"><?php echo  language('address/zone/zone','tZneSequence')?></th>
						<?php endif; ?>
						<th class="xCNTextBold" style="width:5%;"><?php echo  language('address/zone/zone','tZneTypeRefer')?></th>
						<th class="xCNTextBold" style="width:3%;"><?php echo  language('address/zone/zone','tZneCodeTypeRefer')?></th>
                        <th class="xCNTextBold" style="width:15%;"><?php echo  language('address/zone/zone','tZneNameTypeRefer')?></th>
                        <th class="xCNTextBold" style="width:3%;"><?php echo  language('address/zone/zone','tZneKeyRefer')?></th>
						<?php if($aAlwEventZoneObj['tAutStaFull'] == 1 || $aAlwEventZoneObj['tAutStaDelete'] == 1) : ?>
						<th class="xCNTextBold" style="width:2%;"><?= language('common/main/main','tCMNActionDelete')?></th>
						<?php endif; ?>
						<?php if($aAlwEventZoneObj['tAutStaFull'] == 1 || $aAlwEventZoneObj['tAutStaRead'] == 1) : ?>
						<th class="xCNTextBold xWDeleteBtnEditButton" style="width:2%;"><?= language('common/main/main','tCMNActionEdit')?></th>
						<?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
				<?php if($aDataList['rtCode'] == 1 ):?>
                    <?php $i = 1; foreach($aDataList['raItems'] AS $key=> $aValue){ ?>
                        <?php 
                            switch ($aValue['rtZneTable']) {
                                case 'TCNMBranch':
                                        $tZneTable = language('address/zone/zone','tZneSltBranch');
                                    break;
                                case 'TCNMUser':
                                        $tZneTable = language('address/zone/zone','tZneSleUSer');
                                    break;
                                case 'TCNMSpn':
                                        $tZneTable = language('address/zone/zone','tZneSltSaleman');
                                    break;
                                case 'TCNMShop':
                                    $tZneTable = language('address/zone/zone','tZneSltShop');
                                    break;   
                                case 'TCNMPos':
                                    $tZneTable = language('address/zone/zone','tZneSltPos');
                                    break;       
                                default:
                                    $tZneTable = language('common/main/main','tCMNBlank-NA');
                            }    
                        ?>
                        <tr class="text-center xCNTextDetail2  xWZoneObjDataSource" id="otrZen<?=$key?>" data-key="<?=$key;?>" data-name="<?=$aValue['rtZneRefName']?>">
							<?php if($aAlwEventZoneObj['tAutStaFull'] == 1 || $aAlwEventZoneObj['tAutStaDelete'] == 1) : ?>
								<td class="text-center">
									<label class="fancy-checkbox">
                                            <?php echo $i; ?>
										<span>&nbsp;</span>
									</label>
								</td>
							<?php endif; ?>
                            <td nowrap class="text-left xCNFieldZneTable">
                                <div class="form-group selectpickerotrZen<?=$key?> xCNHide" id="ocmTypeReferEditotrZen<?=$key?>">
                                    <select class="selectpicker form-control xWInputEditInLine" id="ocmTypeReferEditReferotrZen<?=$key?>" name="ocmTypeReferEditReferotrZen<?=$key?>" maxlength="1">
                                        <option value="TCNMBranch"><?php echo language('address/zone/zone','tZneSltBranch');?></option>
                                        <option value="TCNMUser"><?php echo language('address/zone/zone','tZneSleUSer');?></option>
                                        <option value="TCNMSpn"><?php echo language('address/zone/zone','tZneSltSaleman');?></option>
                                        <option value="TCNMShop"><?php echo language('address/zone/zone','tZneSltShop');?></option>
                                        <option value="TCNMPos"><?php echo language('address/zone/zone','tZneSltPos');?></option>
                                    </select>
                                </div>
                            <div class="form-group xWInpuTextLineotrZenotrZen<?=$key?>" id="odvZneReTable<?=$key?>"><?= $tZneTable; ?></div>
                        </td>
                            <td nowrap class="text-left xCNFieldZneRefCode">
                                <div id="oetZneBchCodeotrZen<?=$key?>"><?=$aValue['rtZneRefCode']?></div>
                                    <div class="col-xs-12 col-lg-12 col-md-12 xCNZneReferEditCode" id="odvZneReferCodeotrZen<?=$key?>">
                                    <input type="text" class="form-control xCNHide" id="oetZneEditotrZen<?=$key?>" name="oetZneEditotrZen<?=$key?>" value="<?php echo @$tZneBranchCode;?>" disabled>
                                    <input type="text" class="form-control xCNHide" id="oetZneUSerCodeotrZen<?=$key?>" name="oetZneUSerCodeotrZen<?=$key?>" value="<?php echo @$tZneUSerCode;?>" disabled>
                                    <input type="text" class="form-control xCNHide" id="oetZneSpnCodeotrZen<?=$key?>" name="oetZneSpnCodeotrZen<?=$key?>" maxlength="5" value="<?php echo @$tZneSpnCode?>" disabled>
                                    <input type="text" class="form-control xCNHide" id="oetZneShopCodeotrZen<?=$key?>" name="oetZneShopCodeotrZen<?=$key?>" value="<?php echo @$tZneShpCode?>" disabled>
                                    <input type="text" class="form-control xCNHide" id="oetZnePosCodeotrZen<?=$key?>" name="oetZnePosCodeotrZen<?=$key?>" maxlength="5" value="<?php echo @$tZnePosCode?>" disabled>
                                </div>
                            </td>
                            <td nowrap class="text-left xCNFieldZneRefName">
                                <div class="form-group xWInpuTextLineZenReferNameotrZen<?=$key?>" id="odvZneRefNameotrZen<?=$key?>"><?=$aValue['rtZneRefName']?></div>
                                    <!-- ฺBrowse Branch (สาขา) -->
									    <div class="col-xs-12 col-lg-6 col-md-6 xCNZneReferBranch xCNHide" id="odvZneReferBranchotrZen<?=$key?>" >
											<div class="input-group">
												<input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetZneBchNameotrZen<?=$key?>" name="oetZneBchNameotrZen<?=$key?>" placeholder="<?php echo language('address/zone/zone','tZneSltBranch');?>" value="<?php echo @$tZneBranchName;?>" readonly>
												<span class="input-group-btn">
													<button id="obtBrowseBranchZen" type="button" class="btn xCNBtnBrowseAddOn">
														<img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
													</button>
												</span>
											</div>
									    </div>
                                    <!-- End Browse Branch (สาขา) -->   
                                    <!-- Browse User (ผู้ใช้)-->
									<div class="col-xs-12 col-lg-6 col-md-6 xCNZneReferZneUSerotrZen<?=$key?> xCNHide"  id="odvZneRefUSerotrZen<?=$key?>">
										<div class="form-group">
											<div class="input-group">
                                            <!-- <input type="hidden" class="form-control xCNHide" id="oetZneUSerCodeotrZen<?=$key?>" name="oetZneUSerCodeotrZen<?=$key?>" value="<?php echo @$tZneUSerCode;?>"> -->
												<input type="text" class="from-control xCNInputWithoutSpcNotThai" id="oetZneUSerNameotrZen<?=$key?>"  name="oetZneUSerNameotrZen<?=$key?>"  placeholder="<?php echo language('address/zone/zone','tZneSleUSer');?>" value="<?php echo @$tZneUserName;?>" readonly>
												<span class="input-group-btn">
													<button id="obtBrowseUSer" type="button" class="btn xCNBtnBrowseAddOn">
														<img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
													</button>
												</span>
											</div>
										</div>
									</div>
                                 <!-- End Browse User (ผู้ใช้) -->
                                 <!-- Browse SaleMan พนักงานขาย -->
									<div class="col-xs-12 col-lg-6 col-md-6 xCNZneSpnCodeotrZen<?=$key?> xCNHide" id="odvZneSaleManotrZen<?=$key?>">
										<div class="form-group">
											<div class="input-group">
												<input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetZneSpnNameotrZen<?=$key?>" name="oetZneSpnNameotrZen<?=$key?>" maxlength="100" placeholder="<?php echo language('address/zone/zone','tZneSltSaleman');?>" value="<?php echo @$tZneSpnName?>" readonly>
												<span class="input-group-btn">
													<button id="obtBrowseSaleMan" type="button" class="btn xCNBtnBrowseAddOn">
														<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
													</button>
												</span>
											</div>
										</div>
									</div>
                                <!--End Browse SaleMan พนักงานขาย -->
                                <!-- Browse Shop (ร้านค้า) -->
									<div class="col-xs-12 col-lg-6 col-md-6 xCNHide" id="odvZneShopotrZen<?=$key?>">
										<div class="form-group" >
											<div class="input-group">
												<input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetZneShopNameotrZen<?=$key?>" name="oetZneShopNameotrZen<?=$key?>"  placeholder="<?php echo language('address/zone/zone','tZneSltShop');?>" value="<?php echo @$tZneShpName?>" readonly>
												<span class="input-group-btn">
													<button id="obtBrowseShop" type="button" class="btn xCNBtnBrowseAddOn">
														<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
													</button>
												</span>
											</div>
										</div>
									</div>
                                <!--End Browse Shop (ร้านค้า) -->    
                                <!-- Browse Pos (เครื่องจุดขาย) -->
									<div class="col-xs-12 col-lg-6 col-md-6 xCNHide" id="odvZnePosotrZen<?=$key?>">	
										<div class="form-group" >
											<div class="input-group" >
												<input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetZnePosNameotrZen<?=$key?>" name="oetZnePosNameotrZen<?=$key?>"  placeholder="<?php echo language('address/zone/zone','tZneSltPos');?>" value="<?php echo @$tZneComName?>" readonly>
												<span class="input-group-btn">
													<button id="obtBrowsePOS" type="button" class="btn xCNBtnBrowseAddOn">
														<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
													</button>
												</span>
											</div>
										</div>
									</div>
                                <!-- End Browse Pos (เครื่องจุดขาย) -->    
                            </td>
                            <td nowrap class="text-left xCNFieldZneKey">
                                    <input type="text" class="form-group xWInputEditInLine xCNHide" id="oetZneKeyotrZen<?=$key;?>" name="oetZneKeyotrZen<?=$key;?>" value="<?=$aValue['rtZneKey']?>" readonly>
                                    <div class="form-group xWInpuTextLineotrZenotrZen<?=$key?>" id="odvZneKeyotrZen<?=$key?>"><?=$aValue['rtZneKey']?></div>
                            </td>
							<?php if($aAlwEventZoneObj['tAutStaFull'] == 1 || $aAlwEventZoneObj['tAutStaDelete'] == 1) : ?>
								<td>
                                <label class="xCNTextLink">
                                    <img class="xCNIconTable xCNIconDel" src="<?= base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSnZoneObjDel('<?=$nCurrentPage?>','<?=$aValue['rtZneRefName']?>','<?=$aValue['rtZneID']?>','<?=$aValue['rtZneTable']?>','<?= language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                </label>
                                </td>
							<?php endif; ?>
							<?php if($aAlwEventZoneObj['tAutStaFull'] == 1 || $aAlwEventZoneObj['tAutStaRead'] == 1) : ?>
								<td>
                                    <img class="xCNIconTable xWIMGZoneReferEdit" id="oimGpShopRowEdit"  src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onclick="JSvCallPageZoneReferClickEdit(this,event,'<?=$aValue['rtZneRefCode']?>')"> 
                                    <img class="xCNIconTable xWIMGZoneReferSave hidden"id="oimZoneReferotrZen<?=$key?>" src="<?php echo  base_url(); ?>/application/modules/common/assets/images/icons/save.png" onclick="JSxZenReferDataSourceSaveOperator(this, event,'<?=$aValue['rtZneID']?>','<?=$nCurrentPage?>')">
                                    <img class="xCNIconTable xWIMGZoneReferCancel hidden" src="<?php echo  base_url(); ?>/application/modules/common/assets/images/icons/reply_new.png" onclick="JSxPageShpShopDataSourceCancelOperator(this, event,<?=$nCurrentPage?>)"> 
                                </td>
							<?php endif; ?>
                        </tr>
                    <?php $i++; } ?>
                <?php else:?>
                    <tr><td class='text-center xCNTextDetail2 xWTextNotfoundDataTableZoneRefer' colspan='8'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                <?php endif;?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
<div class="row"> 
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWCDCPaging btn-toolbar pull-right">
			<?php if($nPage == 1){ $tDisabled = 'disabled'; }else{ $tDisabled = '-';} ?>
            <button onclick="JSvCPNClickPage('previous')" class="btn btn-white btn-sm" <?=$tDisabled?>><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>

			<?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?>
				<?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
            		<button onclick="JSvCPNClickPage('<?=$i?>')" type="button" class="btn xCNBTNNumPagenation <?=$tActive?>" <?=$tDisPageNumber ?>><?=$i?></button>
			<?php } ?>

            <?php if($nPage >= $aDataList['rnAllPage']){ $tDisabled = 'disabled'; }else{ $tDisabled = '-'; } ?>
			<button onclick="JSvCPNClickPage('next')" class="btn btn-white btn-sm" <?=$tDisabled?>><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDelZoneObj">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete"> - </span>
				<input type='hidden' id="ohdConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>
<?php include "script/jZoneRefer.php"; ?>
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>



