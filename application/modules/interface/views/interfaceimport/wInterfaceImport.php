<input id="oetInterfaceImportStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetInterfaceImportCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<div id="odvCpnMainMenu" class="main-menu clearfix">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<ol id="oliMenuNav" class="breadcrumb">
					<?php FCNxHADDfavorite('interfaceimport/0/0');?>
					<li id="oliInterfaceImportTitle" class="xCNLinkClick" style="cursor:pointer" ><?php echo language('interface/interfaceimport/interfaceimport','tIFSTitle') ?></li>

				</ol>
			</div>

			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
			<div id="odvBtnCmpEditInfo">
			<button id="obtInterfaceImportConfirm"   class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('interface/interfaceimport/interfaceimport','tIFSTConfirm')  ?></button>
				</div>

			</div>
		</div>
	</div>
</div>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmInterfaceImport">
<div class="main-content">
	<div class="panel panel-headline">
<input type="hidden" name="tUserCode" id="tUserCode" value="<?=$this->session->userdata('tSesUserCode')?>">
	<div class="row">
    <div class="col-md-12">

		<div class="panel-body">
				<div class="table-responsive" style="padding:20px">
						<table id="otbCtyDataList" class="table table-striped"> <!-- เปลี่ยน -->
							<thead>
								<tr>
									<th width="7%" nowrap class="text-center xCNTextBold"><?php echo language('interface/interfaceimport/interfaceimport','tIFSID'); ?></th>
									<th width="7%" nowrap class="text-center xCNTextBold"><?php echo language('interface/interfaceimport/interfaceimport','tIFSSelect'); ?></th>
									<th nowrap class="text-center xCNTextBold"><?php echo language('interface/interfaceimport/interfaceimport','tIFSList'); ?></th>
									<th nowrap class="text-center xCNTextBold"><?php echo language('interface/interfaceimport/interfaceimport','tImpotLastDate'); ?></th>
									<!-- <th width="20%" nowrap class="text-center xCNTextBold"><?php echo language('interface/interfaceimport/interfaceimport','tIFSTStatus'); ?></th> -->
								</tr>
							</thead>
							<tbody>
							<?php if(!empty($aDataMasterImport)){
								foreach($aDataMasterImport AS $nK => $aData){ ?>
								<tr>
									<td align="center"><?=($nK+1)?></td>
									<td align="center">
										<input type="checkbox" class="progress-bar-chekbox" name="ocmINMImport[<?=$aData['FTApiCode']?>]" value="<?=$aData['FTApiCode']?>" checked idpgb="xWINM<?=$aData['FTApiCode']?>TextDisplay"  >
									</td>
									<td><?=$aData['FTApiName']?></td>
									<td  class="text-center"><?=$aData['FDLogCreate']?></td>
									<!-- <td >   -->
										<!-- <span id="ospINM<?=$aData['FTApiCode']?>ProgressBar" style="color:green;display:none" distext="<?=language('interface/interfaceimport/interfaceimport','tIFSImportSuccess')?>" ><?=language('interface/interfaceimport/interfaceimport','tIFSImportSuccess')?></span> -->

										<!-- <div class="xWINM<?=$aData['FTApiCode']?>TextDisplay xWINMTextDisplay" style="display:none;"
											 data-status 	= "2"
											 data-success	= "<?=language('interface/interfaceimport/interfaceimport','tIFSImportSuccess')?>"
											 data-fail		= "<?=language('interface/interfaceimport/interfaceimport','tIFSImportFail')?>">
										</div>

										<div class="row xWINMProgress xWINM<?=$aData['FTApiCode']?>Progress" style="display:none;">
											<div class="col-md-1">
												<div class="loader simple-circle"></div>
											</div>
											<div class="col-md-9">
												<div class="odvINM<?=$aData['FTApiCode']?>TextProgress text-primary"><?=language('interface/interfaceimport/interfaceimport','tIFSImportProcess')?></div>
											</div>
											<div class="col-md-1"></div>
										</div> -->

										<!-- <button class="btn btn-primary" type="button" disabled>
											<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
											Loading...
										</button> -->
										<!-- <div class="progress" id="otdINM<?=$aData['FTApiCode']?>ProgressBar" style="margin-bottom:0px">
											<div class="progress-bar" id="odvINM<?=$aData['FTApiCode']?>ProgressBar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%" status='1'>
												0%
											</div>
										</div> -->
  									<!-- </td> -->
								</tr>
							<?php } } ?>
								<!-- <tr>
									<td align="center">2</td>
									<td align="center"><input type="checkbox" class="progress-bar-chekbox" name="ocmINMImport[]" id="ocmINMImport2" value="2" idpgb="INMImpAdjProgressBar"  ></td>
									<td><?php echo language('interface/interfaceimport/interfaceimport','tIFSDataDpi'); ?></td>
									<td >
									<span id="ospINMImpAdjProgressBar" style="color:green;display:none" distext="<?=language('interface/interfaceimport/interfaceimport','tIFSImportSuccess')?>"><?=language('interface/interfaceimport/interfaceimport','tIFSImportSuccess')?></span>
									<div class="progress" id="otdINMImpAdjProgressBar" style="margin-bottom:0px" >
									  <div class="progress-bar" id="odvINMImpAdjProgressBar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%" status='1'>
										0%
									  </div>
									  </div>
  									</td>
								</tr> -->
							</tbody>
						</table>

						<!-- <input type="checkbox" name="ocmINMChkAll" id="ocmINMChkAll" value="1" > <?php echo language('interface/interfaceimport/interfaceimport','tIFSSelectAll'); ?> -->
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
</form>

<!--Modal Success-->
<div class="modal fade" id="odvInterfaceImportSuccess">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('interface/interfaceimport/interfaceimport','tStatusProcess'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?=language('interface/interfaceimport/interfaceimport','tContentProcess'); ?></p>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" type="button"  id="obtIFIModalMsgConfirm" class="btn xCNBTNPrimery">
                    <?=language('common/main/main', 'tModalConfirm'); ?>
                </button>
				<button type="button" id="obtIFIModalMsgCancel" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('application/modules/interface/assets/src/interfaceimport/jInterfaceImport.js')?>"></script>
<script>
	// Create By : Napat(Jame) 17/08/2020 เมื่อกดปุ่มยืนยันให้วิ่งไปที่หน้า ประวัตินำเข้า-ส่งออก
	$('#obtIFIModalMsgConfirm').off('click');
	$('#obtIFIModalMsgConfirm').on('click',function(){
		// ใส่ timeout ป้องกัน modal-backdrop
		setTimeout(function(){
			$.ajax({
				type    : "POST",
				url     : "interfacehistory/0/0",
				data    : {},
				cache   : false,
				Timeout : 0,
				success: function(tResult){
					$('.odvMainContent').html(tResult);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					JCNxResponseError(jqXHR, textStatus, errorThrown);
				}
			});
		}, 100);
	});
</script>
