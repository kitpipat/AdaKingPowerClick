<?php 
    if($aDptDataList['rtCode'] == '1'){
        $nCurrentPage = $aDptDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>
<div class="row">
    <div class="col-md-12">
    <input type="hidden" id="nCurrentPageTB" value="<?=$nCurrentPage;?>">
        <div class="table-responsive">
            <table id="otbPbnDataList" class="table table-striped"> <!-- เปลี่ยน -->
                <thead>
                    <tr>
                    <?php if($aAlwEventDepartment['tAutStaFull'] == 1 || ($aAlwEventDepartment['tAutStaAdd'] == 1 || $aAlwEventDepartment['tAutStaEdit'] == 1)) : ?>   
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('authen/department/department','tDPTTBChoose'); ?></th>
                    <?php endif;?>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('authen/department/department','tDPTTBCode'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:50%;"><?php echo language('authen/department/department','tDPTTBName'); ?></th>
                    <?php if($aAlwEventDepartment['tAutStaFull'] == 1 || ($aAlwEventDepartment['tAutStaAdd'] == 1 || $aAlwEventDepartment['tAutStaEdit'] == 1)) : ?> 
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('authen/department/department','tDPTTBDelete'); ?></th>
                    <?php endif;?>
                    <?php if($aAlwEventDepartment['tAutStaFull'] == 1 || ($aAlwEventDepartment['tAutStaAdd'] == 1 || $aAlwEventDepartment['tAutStaEdit'] == 1)) : ?>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('authen/department/department','tDPTTBEdit'); ?></th>
                    <?php endif;?>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aDptDataList['rtCode'] == 1 ):?>
                        <?php foreach($aDptDataList['raItems'] AS $nKey => $aValue):?>
                            <tr class="text-center xCNTextDetail2 otrDpt" id="otrDpt<?=$nKey?>" data-code="<?=$aValue['rtDptCode']?>" data-name="<?=$aValue['rtDptName']?>">
                            <?php if($aAlwEventDepartment['tAutStaFull'] == 1 || ($aAlwEventDepartment['tAutStaAdd'] == 1 || $aAlwEventDepartment['tAutStaEdit'] == 1)) : ?>
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?=$nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                            <?php endif;?>
                                <td class="text-left"><?=$aValue['rtDptCode']?></td>
                                <td class="text-left"><?=$aValue['rtDptName']?></td>
                                <?php if($aAlwEventDepartment['tAutStaFull'] == 1 || ($aAlwEventDepartment['tAutStaAdd'] == 1 || $aAlwEventDepartment['tAutStaEdit'] == 1)) : ?>
                                <td>
                                    <!-- เปลี่ยน -->
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoDptDel('<?=$nCurrentPage?>','<?=$aValue['rtDptName']?>','<?php echo $aValue['rtDptCode']?>')">
                                </td>
                                <?php endif;?>
                                <?php if($aAlwEventDepartment['tAutStaFull'] == 1 || ($aAlwEventDepartment['tAutStaAdd'] == 1 || $aAlwEventDepartment['tAutStaEdit'] == 1)) : ?>
                                <td>
                                    <!-- เปลี่ยน -->
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageDptEdit('<?php echo $aValue['rtDptCode']?>')">
                                </td>
                                <?php endif;?>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='5'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDptDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDptDataList['rnCurrentPage']?> / <?=$aDptDataList['rnAllPage']?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPageDpt btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvDptClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDptDataList['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvDptClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDptDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvDptClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDelDpt">
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
				<button id="osmConfirm" onClick="JSoDptDelChoose('<?=$nCurrentPage?>')" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
					<?php echo language('common/main/main', 'tModalConfirm')?>
				</button>
				<!-- แก้ -->
				<button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
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
            JSxPaseCodeDelInModal();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxPaseCodeDelInModal();
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
                JSxPaseCodeDelInModal();
            }
        }
        JSxShowButtonChoose();
    })
</script>