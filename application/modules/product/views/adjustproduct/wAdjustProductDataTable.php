<?php 
    if($aPdtDataList['rtCode'] == '1'){
        $nCurrentPage = $aPdtDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
    $nAPJColspan = 8;
?>

<div class="">
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="otbPbnDataList" class="table table-striped"> <!-- เปลี่ยน -->
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;">
                            <label class="fancy-checkbox">
                                <input type="checkbox" class="ocmCENCheckDeleteAll" id="ocmCENCheckDeleteAll" >
                                <span class="ospListItem">&nbsp;</span>
                            </label>
                        </th>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/product/product','tAdjPdtBranch')?></th>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/product/product','tAdjPdtCode').language('product/product/product','tAdjPdtProduct')?></th>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/product/product','tAdjPdtName').language('product/product/product','tAdjPdtProduct')?></th>
                        <?php if($aConditionAdjustProduct['tAJPSelectTable']=='TCNMPdtPackSize' || $aConditionAdjustProduct['tAJPSelectTable']=='TCNMPdtBar'): $nAPJColspan++; ?>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/product/product','tAdjPdtUnit')?></th>
                        <?php endif; ?>
                        <?php if($aConditionAdjustProduct['tAJPSelectTable']=='TCNMPdtBar'): $nAPJColspan++ ?>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/product/product','tAdjPdtBarCode')?></th>
                        <?php endif; ?>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/product/product','tAdjPdtGroup')?></th>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/product/product','tAdjPdtBrand')?></th>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/product/product','tAdjPdtModel')?></th>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/product/product','tAdjPdtType')?></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if($aPdtDataList['rtCode']=='1'){
                            foreach($aPdtDataList['raItems'] as $aData){
                ?>
                            <tr class="text-center xCNTextDetail2 otrPdtPbn">
                   
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" class="ocbListItem xCNCheckByPDT<?=$aData['FTPdtCode']?>" name="ocbListItem[<?=$aData['FNRowID']?>]"  value="<?=$aData['FNRowID']?>" 
                                        <?php 
                                        if($aData['FTStaAlwSet']=='1'){ echo 'checked'; } 
                                        ?>
                                        >
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                             
                                <td nowrap class="text-left"><?=$aData['FTBchName']?></td>
                                <td nowrap class="text-left"><?=$aData['FTPdtCode']?></td>
                                <td nowrap class="text-left"><?=$aData['FTPdtName']?></td>
                                <?php if($aConditionAdjustProduct['tAJPSelectTable']=='TCNMPdtPackSize' || $aConditionAdjustProduct['tAJPSelectTable']=='TCNMPdtBar'): ?>
                                <td nowrap class="text-left"><?=$aData['FTPunName']?></td>
                                <?php endif; ?>
                                <?php if($aConditionAdjustProduct['tAJPSelectTable']=='TCNMPdtBar'): ?>
                                <td nowrap class="text-left"><?=$aData['FTBarCode']?></td>
                                <?php endif; ?>
                                <td nowrap class="text-left"><?=$aData['FTPgpName']?></td>
                                <td nowrap class="text-left"><?=$aData['FTPbnName']?></td>
                                <td nowrap class="text-left"><?=$aData['FTPmoName']?></td>
                                <td nowrap class="text-left"><?=$aData['FTPtyName']?></td>
                            
                             
                            </tr>
                <?php 
                            }
                            
                         }else{ ?>
                        <tr><td class='text-center xCNTextDetail2' colspan='<?=$nAPJColspan?>'><?= language('product/product/product','tPBNNoData')?></td></tr>
                 <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<input type="hidden" id="ohdAJPCountSelectRow" value="<?=$aPdtDataList['rnAllRow']?>">
<input type="hidden" id="nPagePDTAll" value="<?=$aPdtDataList['rnAllRow']?>">
<div class="">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aPdtDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aPdtDataList['rnCurrentPage']?> / <?=$aPdtDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPagePdtPbn btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvAJPClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aPdtDataList['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvAJPClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aPdtDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvAJPClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDelPdtPbn">
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
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSoPdtPbnDelChoose('<?=$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>
<script>

$('#ocmCENCheckDeleteAll').on('change',function(){

    if(this.checked==true){
        var nStaAlwSet = 1;
        $('.ocbListItem').prop("checked", true);
    }else{
        var nStaAlwSet = 2;
        $('.ocbListItem').prop("checked", false);
    }

    let oPdtListChk = {
        nStaAlwSet : nStaAlwSet
    }
    JSxAPJUpdateStaAlwAll(oPdtListChk);

});

// var LocalItemData = localStorage.getItem("StaCheckAllAdjustProduct");
// if(LocalItemData == '1'){
//     $('.ocbListItem').prop("checked", true);
//     $('#ocmCENCheckDeleteAll').prop("checked", true);
// }else{
//     $('.ocbListItem').prop("checked", false);
//     $('#ocmCENCheckDeleteAll').prop("checked", false);
// }

//////////////////////
var obj = [];
// obj.push({"nCode": '00061'},{"nCode": '00064'},{"nCode": '00057'});
// localStorage.setItem("aItemCheckByProduct",JSON.stringify(obj));
// var aItem = [JSON.parse(localStorage.getItem("aItemCheckByProduct"))];
// for(i=0; i<aItem[0].length; i++){
//     $('.xCNCheckByPDT'+aItem[0][i].nCode).prop("checked", true);
// }




$('.ocbListItem').on('change',function(){
    // console.log(this.value);
    // console.log(this.checked);

    if(this.checked==true){
        var nStaAlwSet = 1;
    }else{
        var nStaAlwSet = 2;
        $('.ocmCENCheckDeleteAll').prop("checked", false);
    }

    let oPdtListChk = {
        nRowID : this.value,
        nStaAlwSet : nStaAlwSet
    }
    JSxAPJUpdateStaAlw(oPdtListChk);

});
</script>