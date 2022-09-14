
		
<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddMntDoc">
	<button style="display:none" type="submit" id="obtSubmitMntDoc" onclick="JSnAddEditMntDoc('mntStaDocEventAdd')"></button>
	<div class="main-content">

	<!--ส่วนของรายละเอียดด้านบน-->
	<div class="col-md-6"  style="padding-bottom:20px !important;">
	<div class="row">
	<div class="panel panel-default">
	<div id="odvMntConditionDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('checkdocument/checkdocument', 'tChkDocForm'); ?></label>
                </div>
	<div class="panel-body"  style="padding-top:20px !important;padding-bottom:20px !important;">
	

		<!-- เพิ่ม Browser AD  -->
	
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="form-group ">
					<label class="xCNLabelFrm"></span><?php echo language('checkdocument/checkdocument','tMntAgency')?></label>	
					<div class="input-group"><input class="form-control xCNHide" type="text" id="oetMNTAgnCode" name="oetMNTAgnCode" maxlength="5" value="<?=$this->session->userdata('tSesUsrAgnCode')?>">
						<input type="text" class="form-control xWPointerEventNone" 
							id="oetMNTAgnName" 
							name="oetMNTAgnName" 
							maxlength="100" 
							placeholder ="<?php echo language('checkdocument/checkdocument','tMntAgency');?>"
							value="<?=$this->session->userdata('tSesUsrAgnName')?>" readonly>
						<span class="input-group-btn">
							<button id="oimMNTBrowseAgn" type="button" class="btn xCNBtnBrowseAddOn " <?php if($this->session->userdata('tSesUsrAgnName')!=''){ echo 'disabled'; } ?>>
								<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
							</button>
						</span>
					</div>
				</div>	
			</div>
		
		<?php 
                // if(!FCNbUsrIsAgnLevel() && $this->session->userdata('tSesUsrLevel')!='HQ'){
                    $tBchCode       = $this->session->userdata("tSesUsrBchCodeDefault");
                    $tBchName       = $this->session->userdata("tSesUsrBchNameDefault");
                //     }else{
                //     $tBchCode       = '';
                //     $tBchName       = '';
                // }
                ?>

			<div class="col-xs-12 col-md-12 col-lg-12">
			<div class="form-group">
					<label class="xCNLabelFrm"><?php echo language('checkdocument/checkdocument','tChkDocFilBchCode');?></label>	
					<div class="input-group"><input class="form-control xCNHide" type="text" id="oetMntInBcnCode" name="oetMntInBcnCode" maxlength="5" value="<?=$tBchCode?>">
						<input type="text" class="form-control xWPointerEventNone" 
							id="oetMntInBcnName" 
							name="oetMntInBcnName" 
							maxlength="100" 
							data-validate-required ="<?php echo language('checkdocument/checkdocument','tChkDocFilValidateBchCode');?>"
							placeholder ="<?php echo language('checkdocument/checkdocument','tChkDocFilBchCode');?>"
							value="<?=$tBchName?>" readonly>
						<span class="input-group-btn">
							<button id="oimMNTBrowseBch" type="button" class="btn xCNBtnBrowseAddOn">
								<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
							</button>
						</span>
					</div>
				</div>
				
				<div class="form-group">
					<div class="validate-input">
						<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('checkdocument/checkdocument','tChkDocDesc1')?></label>
						<input
							type="text"
							class="form-control"
							maxlength="200"
							id="oetMNTDesc1"
							name="oetMNTDesc1"
							placeholder="<?php echo language('checkdocument/checkdocument','tChkDocDesc1')?>"
							value=""
							data-validate-required="<?php echo language('checkdocument/checkdocument','tChkDocDesc1Validate')?>"
						>
					</div>
				</div>
		

				<div class="form-group">
						<label class="xCNLabelFrm"><?= language('checkdocument/checkdocument','tChkDocDesc2')?></label>
						<textarea class="form-control" rows="4" maxlength="255" id="oetMNTDesc2" name="oetMNTDesc2" data-validate-required="<?php echo language('checkdocument/checkdocument','tChkDocDesc2Validate');?>"></textarea>
				</div>


				<div class="form-group">
					<div class="validate-input">
						<label class="xCNLabelFrm"><?php echo language('checkdocument/checkdocument','tChkDocUrlRef')?></label>
						<input
							type="text"
							class="form-control"
							maxlength="200"
							id="oetMNTUsrRef"
							name="oetMNTUsrRef"
							
							placeholder="<?php echo language('checkdocument/checkdocument','tChkDocUrlRef')?>"
							value=""
							data-validate-required="<?php echo language('checkdocument/checkdocument','tMntValidName')?>"
						>
					</div>
				</div>
			</div>
		</div>
	</div>
	

</div>
</div>

<div class="col-md-6" >
		<div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvMntConditionDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('checkdocument/checkdocument', 'tChkDocTo'); ?></label>
                </div>

                <div id="odvMntConditionChkDocCRBch" class=" panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="col-md-12">

                            <div class="table-responsive">

                            <div  style="padding-bottom: 20px;">    
          
                                <button id="obtTabConditionChkDocHDCRBch"  class="xCNBTNPrimeryPlus hideCRNameColum" type="button">+</button>
                   
                                </div>
                            <div>
                            <br>
                            </div> 
                        
							<table  class="table xWPdtTableFont">
									<thead>
									<tr class="xCNCenter">
											<th nowrap class="xCNTextBold" style="width:10%;"  ><?php echo language('checkdocument/checkdocument','tMntNumberList')?></th>
											<th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('checkdocument/checkdocument','tMntGroupName')?></th>
											<th nowrap class="xCNTextBold" style="width:20%;"><?php echo language('checkdocument/checkdocument','tMntAgency')?></th>
											<th nowrap class="xCNTextBold" style="width:20%;"><?php echo language('checkdocument/checkdocument','tMntBchName')?></th>
											<th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('checkdocument/checkdocument','tMntGroupDelete')?></th>
										</tr>
									</thead>
									<tbody id="otbConditionChkDocHDCRBch">
									<tr id="otrRemoveTrBch"><td   colspan="5" align="center"> <?php echo language('checkdocument/checkdocument','tMntGroupNotFound')?> </td></tr>
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
</div>
</form>




<div  class="modal fade" id="odvMntConditionChkDocCRModalBch" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('checkdocument/checkdocument','tMntCreateGroupCrBch')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
      <div class="modal-body">
  
        <div class='row'>

		<div class='col-lg-12'>
                        <div class='form-group'>
                        <label class="xCNLabelFrm"><?php echo language('checkdocument/checkdocument','tMntGroupConditionChkDocGroupType')?></label>
                      
                                        <select class="form-control" name="ocmMntBchModalType" id="ocmMntBchModalType">
                                        <option value="1"><?php echo language('checkdocument/checkdocument','tMntGroupConditionChkDocTypeInclude')?></optoion>
                                        <option value="2"><?php echo language('checkdocument/checkdocument','tMntGroupConditionChkDocTypeExclude')?></optoion>
                                        </select>
                           
                        </div>
                    </div>

                <div class='col-lg-12'>
                        <div class='form-group'>
                            <label class="xCNLabelFrm"><?=language('document/couponsetup/couponsetup','tCPHAgency')?></label>
                            <div class='input-group'>
                                <input type='text' class='form-control xCNHide xWCPHAllInput' id='oetMntAgnCodeTo' name='oetMntAgnCodeTo' value="<?=$this->session->userdata('tSesUsrAgnCode')?>" maxlength='5'>
                                <input type='text' class='form-control xWPointerEventNone xWCPHAllInput' id='oetMntAgnNameTo' name='oetMntAgnNameTo'  value="<?=$this->session->userdata('tSesUsrAgnName')?>" readonly>
                                <span class='input-group-btn'>
                                    <button id='obtCPHBrowseAgnTo' type='button' class='btn xCNBtnBrowseAddOn' ><img class='xCNIconFind'></button>
                                </span>
                            </div>
                        </div>
                    </div>


                <div class='col-lg-12'>
                        <div class='form-group'>
                            <label class="xCNLabelFrm"><?=language('company/branch/branch','tBCHTitle')?></label>
                            <div class='input-group'>
                                <input type='text' class='form-control xCNHide xWMntAllInput' id='oetMntBchCodeTo' name='oetMntBchCodeTo'  maxlength='5'>
                                <input type='text' class='form-control xWPointerEventNone xWMntAllInput' id='oetMntBchNameTo' name='oetMntBchNameTo' readonly>
                                <span class='input-group-btn'>
                                    <button id='obtMntBrowseBchTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                </span>
                            </div>
                        </div>
                    </div>


            </div>
    
      </div>
      <div class="modal-footer">
        <button type="button"  class="btn xCNBTNPrimery" id="obtMntCreateBch" ><?=language('common/main/main','เพิ่ม')?></button>
        <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main','ปิด')?></button>
      </div>
    </div>
  </div>
</div>

<?php include "script/jCheckdocumentAdd.php"; ?>