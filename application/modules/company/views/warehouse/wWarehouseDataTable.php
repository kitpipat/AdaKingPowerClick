<?php
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
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
        <input type="hidden" id="nCurrentPageTB" value="<?=$nCurrentPage;?>">
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
                        <?php if($aAlwEventWarehouse['tAutStaFull'] == 1 || $aAlwEventWarehouse['tAutStaDelete'] == 1) : ?>
						<th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo  language('common/main/main','tCMNChoose')?></th>
						<?php endif; ?>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo  language('company/warehouse/warehouse','tWahCode')?></th>
						<th nowrap class="xCNTextBold" style="width:20%;text-align:center;"><?php echo  language('company/warehouse/warehouse','tWahName')?></th>
						<th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo  language('company/warehouse/warehouse','tWahStaType')?></th>
                        <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo  language('company/warehouse/warehouse','tBrowseBCHName')?></th>
						<th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo  language('company/warehouse/warehouse','tWahRefCode')?></th>
                        <?php if($aAlwEventWarehouse['tAutStaFull'] == 1 || $aAlwEventWarehouse['tAutStaDelete'] == 1) : ?>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo  language('common/main/main','tCMNActionDelete')?></th>
						<?php endif; ?>
                        <?php if($aAlwEventWarehouse['tAutStaFull'] == 1 || ($aAlwEventWarehouse['tAutStaEdit'] == 1 || $aAlwEventWarehouse['tAutStaRead'] == 1))  : ?>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo  language('common/main/main','tCMNActionEdit')?></th>
                        <?php endif; ?>
                    </tr>
				</thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
                        <?php
                            if($aValue['rtWahStaType'] == '1' || $aValue['rtWahRefCode'] != '' ){
                                $tDisableTD     = "xWTdDisable";
                                $tDisableImg    = "xWImgDisable";
                                $tDisabledItem  = "disabled ";
                            }else{
                                $tDisableTD     = "";
                                $tDisableImg    = "";
                                $tDisabledItem  = "";
                            }
                        ?>
                        <tr class="text-center xCNTextDetail2 otrWarehouse" id="otrWarehouse<?php echo $key?>" data-code="<?php echo $aValue['rtWahCode']?>" data-bchcode='<?php echo $aValue['rtBchCode']?>' data-name="<?php echo $aValue['rtWahName']?>">
                            <?php if($aAlwEventWarehouse['tAutStaFull'] == 1 || $aAlwEventWarehouse['tAutStaDelete'] == 1) : ?>
                            <td class="text-center">
								<label class="fancy-checkbox">
									<input id="ocbListItem<?php echo $key?>" type="checkbox" class="ocbListItem " name="ocbListItem[]" <?php echo $tDisabledItem ;?>>
									<span>&nbsp;</span>
								</label>
							</td>
                            <?php endif; ?>

                            <td class="text-left"><?php echo $aValue['rtWahCode']?></td>
                            <td nowrap class="text-left"><?php echo $aValue['rtWahName']?></td>
                            <td nowrap class="text-left"><?php echo  language('company/warehouse/warehouse','tWahStaTypeSEL'.$aValue['rtWahStaType'])?></td>
                            <td class="text-left"><?php echo $aValue['rtBchName']?></td>
                            <td nowrap class="text-left"><?php echo  $aValue['rtWahRefCode']?></td>
                            <?php if($aAlwEventWarehouse['tAutStaFull'] == 1 || $aAlwEventWarehouse['tAutStaDelete'] == 1) : ?>
                                <td nowrap class="text-center <?php echo $tDisableTD;?>">
                                    <img class="xCNIconTable xCNIconDelete <?php echo $tDisableImg;?>" onClick="JSnWarehouseDel('<?php echo $nCurrentPage?>','<?php echo $aValue['rtWahCode']?>','<?php echo $aValue['rtBchCode']?>','<?php echo $aValue['rtWahName']?>','<?= language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                </td>
                            <?php endif; ?>

                            <?php if($aAlwEventWarehouse['tAutStaFull'] == 1 || ($aAlwEventWarehouse['tAutStaEdit'] == 1 || $aAlwEventWarehouse['tAutStaRead'] == 1)) : ?>
                            <td>
								<img class="xCNIconTable xCNIconEdit" onClick="JSvCallPageWarehouseEdit('<?php echo $aValue['rtWahCode']?>','<?php echo $aValue['rtBchCode']?>')">
							</td>
                            <?php endif; ?>
                        </tr>
                    <?php } ?>
                <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='99'><?php echo language('common/main/main', 'tCMNNotFoundData')?></td></tr>
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
        <div class="xWPageWah btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
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
                <button onclick="JSvClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDelWarehouse">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete"> - </span>
				<input type='hidden' id="ohdConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSnWarehouseDelChoose('<?php echo $nCurrentPage?>')">
        			<?php echo language('common/main/main', 'tModalConfirm')?>
				</button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
        			<?php echo language('common/main/main', 'tModalCancel')?>
				</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
    $('.ocbListItem').click(function(){
        var nCode = $(this).parent().parent().parent().data('code');  //code
        var nBchCode = $(this).parent().parent().parent().data('bchcode');  //code
        var tName = $(this).parent().parent().parent().data('name');  //code
        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{ }
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"nCode": nCode, "nBchCode": nBchCode , "tName": tName });
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxPaseCodeDelInModal();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "nBchCode": nBchCode , "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxPaseCodeDelInModal();
            }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].nCode == nCode && aArrayConvert[0][$i].nBchCode == nBchCode ){
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
                JSxPaseCodeDelInModal();
            }
        }
        JSxShowButtonChoose();
	});

</script>
