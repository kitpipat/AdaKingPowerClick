
<div id="odvCstMainMenu" class="main-menu">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">

			<div class="xCNCstVMaster">
				<div class="col-xs-12 col-md-8">
					<ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('ApproveCst');?>
						<li id="oliCstTitle" class="xCNLinkClick" style="cursor:pointer" onclick="JSvAPCApproveCstGetPageList('')"><?= language('customerlicense/customerlicense/customerlicense','tAPCRegTitle')?></li>
						<li id="oliCstTitleEdit" class="active"><a><?= language('customerlicense/customerlicense/customerlicense','tCSTTitleEdit')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-md-4 text-right p-r-0">
					<div class="demo-button xCNBtngroup" style="width:100%;">
						<!-- <div id="odvBtnCstInfo">
                            <button id="obtCstAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCLNCallPageCustomerAdd()">+</button>
						</div> -->
						<div >
						<button id="obtAPCApproveCst" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('common/main/main', 'tCMNApprove'); ?></button> 
                        <button id="obtAPCApproveCstSave" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" onclick="JSxAPCApproveCstAddUpdateEvent();"> <?php echo language('common/main/main', 'tSave'); ?></button>                                                             
            
						</div>
					</div>
				</div>
			</div>


			
		</div>
	</div>
</div>

<div class="main-content">
	<div id="odvContentPageApproveCst"></div>
</div>

<!-- ======================================================================== View Modal Appove Document  ======================================================================== -->
<div id="odvAPCModalAppoveCst" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('common/main/main','tApproveTheDocument'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                
                <div class="form-group">
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tCLBCstBcServer')?></label>
					<div class="input-group">
						<input type="text" id="oetAPCSrvCode" class="form-control xCNHide" name="oetSrvCode" value="">
						<input type="text" id="oetAPCSrvName" class="form-control" name="oetSrvName" value="" readonly>
						<span class="input-group-btn">
							<button id="obtBrowseAPCSrvCode" type="button" class="btn xCNBtnBrowseAddOn">
								<img class="xCNIconFind">
							</button>
						</span>
					</div>
				</div>

                    <p><?php echo language('common/main/main','tMainApproveStatus'); ?></p>
                        <ul>
                            <li><?php echo language('common/main/main','tMainApproveStatus1'); ?></li>
                            <li><?php echo language('common/main/main','tMainApproveStatus2'); ?></li>
                            <li><?php echo language('common/main/main','tMainApproveStatus3'); ?></li>
                            <li><?php echo language('common/main/main','tMainApproveStatus4'); ?></li>
                        </ul>
                    <p><?php echo language('common/main/main','tMainApproveStatus5'); ?></p>
                    <p><strong><?php echo language('common/main/main','tMainApproveStatus6'); ?></strong></p>
                </div>
                <div class="modal-footer">
                    <button onclick="JSxAPCApproveCst(true)" type="button" class="btn xCNBTNPrimery">
                        <?php echo language('common/main/main', 'tModalConfirm'); ?>
                    </button>
                    <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                        <?php echo language('common/main/main', 'tModalCancel'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
<!-- ============================================================================================================================================================================= -->

<?php Include 'script/jApproveCst.php'; ?>

