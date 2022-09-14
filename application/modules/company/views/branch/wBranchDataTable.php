<?php 
    $BchCode = $this->session->userdata("tSesUsrBchCodeOld");
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage ='1';
    }
?>

<style>
    .xWTdDisable {
        cursor: not-allowed !important;
        opacity: 0.4 !important;
    }

    .xWImgDisable {
        pointer-events: none;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>    
                        <?php if($aAlwEventBranch['tAutStaFull'] == 1 || $aAlwEventBranch['tAutStaDelete'] == 1 ) : ?>
						<th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo  language('company/branch/branch','tBCHChoose');?></th>
						<?php endif; ?>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo  language('company/branch/branch','tBCHLogo');?></th>
						<th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo  language('common/main/main','tCMNCode');?></th>
						<th nowrap class="xCNTextBold" style="text-align:center;"><?php echo  language('common/main/main','tCMNName');?></th>
						<th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo  language('company/branch/branch','tBCHDateStartStop');?></th>
                        <?php if($BchCode == '' || $BchCode == null) : ?><?php if($aAlwEventBranch['tAutStaFull'] == 1 || $aAlwEventBranch['tAutStaDelete'] == 1 ) : ?>
                            <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo  language('common/main/main','tCMNActionDelete');?></th>
						<?php endif; ?><?php endif; ?>
                        <?php if($aAlwEventBranch['tAutStaFull'] == 1 || ($aAlwEventBranch['tAutStaEdit'] == 1 || $aAlwEventBranch['tAutStaRead'] == 1)) : ?>
                            <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo  language('common/main/main','tCMNActionEdit');?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php if(!empty($aDataList['raItems'])) { ?>
                    <?php foreach($aDataList['raItems'] AS $key=>$aValue){ ?>

                        <?php
                            //ถ้าสาขามีบิลขายแล้ว จะลบสาขาไม่ได้
                            if($aValue['rtUseInSaleHD'] != '' || $aValue['rtUseInSaleHD'] != null ){
                                $tDisableTD     = "xWTdDisable";
                                $tDisableImg    = "xWImgDisable";
                                $tDisabledItem  = "disabled ";
                            }else{
                                $tDisableTD     = "";
                                $tDisableImg    = "";
                                $tDisabledItem  = "";
                            }
                        ?>

                        <tr class="text-center xCNTextDetail2 otrDistrict" id="otrBranch<?php echo $key?>" data-code="<?php echo $aValue['rtBchCode']?>" data-name="<?php echo $aValue['rtBchName']?>">
                            <?php if($aAlwEventBranch['tAutStaFull'] == 1 || $aAlwEventBranch['tAutStaDelete'] == 1 ) : ?>
                            <td class="text-center">
                                <label class="fancy-checkbox">
                                    <input id="ocbListItem<?php echo $key?>" type="checkbox" class="ocbListItem ocbListItem<?=$aValue['rtBchCode']?>" name="ocbListItem[]" <?=$tDisabledItem ;?>>
                                    <span class="xCNCheckBoxDeleteBranch xCNCheckBoxDeleteBranchByBCH<?=$aValue['rtBchCode']?>">&nbsp;</span>
                                </label>
                            </td>
                            <?php endif; ?>
                            <td class="text-center">
                                <?php echo  FCNtHGetImagePageList($aValue['rtImgObj'], '40px');?>
                            </td>
                            <td nowrap class="text-left"><?php echo $aValue['rtBchCode']?></td>
                            <td nowrap class="text-left"><?php echo $aValue['rtBchName']?></td>
                            <td nowrap class="text-center"><?php echo $aValue['rdBchStart'].' - '.$aValue['rdBchStop']?></td>
                            <?php if($BchCode == '' || $BchCode == null) : ?>
                                <?php if($aAlwEventBranch['tAutStaFull'] == 1 || $aAlwEventBranch['tAutStaDelete'] == 1 ) : ?>
                                    <td class="<?=$tDisableTD?>" >
                                        <img class="xCNIconTable xCNIconDel <?=$tDisableImg?>" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" id="oimBtnDelBch<?php echo $aValue['rtBchCode']?>" onClick="JSnBranchDel('<?php echo $nCurrentPage?>','<?php echo $aValue['rtBchCode']?>','<?php echo $aValue['rtBchName']?>','<?php echo language('common/main/main', 'tBCHYesOnNo')?>')">
                                    </td>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if($aAlwEventBranch['tAutStaFull'] == 1 || ($aAlwEventBranch['tAutStaEdit'] == 1 || $aAlwEventBranch['tAutStaRead'] == 1)) : ?>
                            <td>
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvBCHCallPageBranchEdit('<?php echo $aValue['rtBchCode']?>')">
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php } ?>
                    <?php } ?>
                <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData')?></td></tr>
                <?php endif;?>
                </tbody>
			</table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
		<p><?php echo  language('common/main/main','tResultTotalRecord')?> <?php echo $aDataList['rnAllRow']?> <?php echo  language('common/main/main','tRecord')?> <?php echo  language('common/main/main','tCurrentPage')?> <?php echo $aDataList['rnCurrentPage']?> / <?php echo $aDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPageBranch btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvBCHClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ --> 
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <button onclick="JSvBCHClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvBCHClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvmodaldeleteBranch">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
				<input type='hidden' id="ohdConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<!-- แก้ -->
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSnBranchDelChoose()">
					<?php echo language('common/main/main', 'tModalConfirm')?>
				</button>
				<!-- แก้ -->
				<button class="btn xCNBTNDefult" type="button"  data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel')?>
				</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
    $('.ocbListItem').click(function(){
        var nCode = $(this).parent().parent().parent().data('code');  //code
        var tName = $(this).parent().parent().parent().data('name');  //code
        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{ }
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"nCode": nCode, "tName": tName });
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxTextinModal();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxTextinModal();
            }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].nCode == nCode){
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata = [];
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
                JSxTextinModal();
            }
        }
        JSxShowButtonChoose();
    })
</script>