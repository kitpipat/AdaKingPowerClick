
<div id="odvCstMainMenu" class="main-menu">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">

			<div class="xCNCstVMaster">
				<div class="col-xs-12 col-md-6">
					<ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('ApproveLic');?>
						<li id="oliCstTitle" class="xCNLinkClick" style="cursor:pointer" onclick="JSvAPCApproveLicGetPageList('')"><?= language('customerlicense/customerlicense/customerlicense','tAPlTitle')?></li>
						<li id="oliCstTitleEdit" class="active"><a><?= language('customerlicense/customerlicense/customerlicense','tCSTTitleEdit')?></a></li>
					</ol>
				</div>
                <div class="col-xs-12 col-md-3 p-r-0 text-right xCNDateApprove " style="padding-top: 5px;display:none">
                <label class="xCNLabelFrm"><?php echo language('customerlicense/customerlicense/customerlicense','tCbrLicLabelFrmDate');?></label>
                </div>
                <div class="col-xs-12 col-md-2 p-r-0 xCNDateApprove " style="display:none">
                         <!-- วันที่ในการออกเอกสาร -->
                         <div class="form-group">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate"
                                            id="oetCbrLicStrDate"
                                            name="oetCbrLicStrDate"
                                            value="<?=date('Y-m-d')?>"
                                        
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtCbrLicStrDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
				</div >
           
				<div class="col-xs-12 col-md-1 text-right p-r-0 ">
					<div class="demo-button xCNBtngroup" style="width:100%;">
						<!-- <div id="odvBtnCstInfo">
                            <button id="obtCstAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCLNCallPageCustomerAdd()">+</button>
						</div> -->
						<button id="obtAPCApproveLic" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" style="display:none"> <?php echo language('common/main/main', 'tCMNApprove'); ?></button> 
                        <!-- <button id="obtAPCApproveLicSave" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" onclick="JSxAPCApproveLicAddUpdateEvent();"> <?php echo language('common/main/main', 'tSave'); ?></button>                                                              -->
            
						</div>
					</div>
                    <div class="col-xs-12 col-md-12 text-right p-r-0 xCNDateApprove" style="display:none">
                    <p style="color:red"><strong>**<?php echo language('common/main/main','tCbrLicLabelRemark'); ?> : <?php echo language('common/main/main','tCbrLicLabelRemarkRow'); ?></strong></p>
                  
                    </div>
				</div>
			</div>


			
		</div>
	</div>
</div>

<div class="main-content">
	<div id="odvContentPageApproveLic"></div>
</div>

<!-- ======================================================================== View Modal Appove Document  ======================================================================== -->
<div id="odvAPCModalAppoveLic" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('common/main/main','tApproveTheDocument'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
                    <button onclick="JSxAPCApproveLic(true)" type="button" class="btn xCNBTNPrimery">
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

<?php Include 'script/jApproveLic.php'; ?>

