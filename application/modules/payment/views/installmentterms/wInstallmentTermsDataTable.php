<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="otbStmDataList" class="table table-striped"> <!-- เปลี่ยน -->
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;">
                            <label class="fancy-checkbox">
                                <input type="checkbox" class="ocmCENCheckDeleteAll" id="ocmCENCheckDeleteAll" >
                                <span class="ospListItem">&nbsp;</span>
                            </label>
                        </th>
                        <th nowrap class="text-center xCNTextBold" style="width:12%;"><?= language('payment/installmentterms/installmentterms','tSTMCode')?></th>
                        <th nowrap class="text-center xCNTextBold"><?= language('payment/installmentterms/installmentterms','tSTMName')?></th>
                        <th nowrap class="text-center xCNTextBold" style="width:12%;"><?= language('payment/installmentterms/installmentterms','tSTMMinimumBalance')?></th>
                        <th nowrap class="text-center xCNTextBold" style="width:12%;"><?= language('payment/installmentterms/installmentterms','tSTMNumInstallments')?></th>
                        <th nowrap class="text-center xCNTextBold" style="width:12%;"><?= language('payment/installmentterms/installmentterms','tSTMStaUnit')?></th>
                        <th nowrap class="text-center xCNTextBold" style="width:12%;"><?= language('payment/installmentterms/installmentterms','tSTMRate')?></th>
                        <th nowrap class="text-center xCNTextBold" style="width:7%;"><?= language('payment/installmentterms/installmentterms','tSTMDelete')?></th>
                        <th nowrap class="text-center xCNTextBold" style="width:7%;"><?= language('payment/installmentterms/installmentterms','tSTMEdit')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aStmDataList['rtCode'] == 1 ):?>
                        <?php foreach($aStmDataList['raItems'] AS $nKey => $aValue):?>
                            <tr class="text-left xCNTextDetail2 otrGroupSupplier" id="otrGroupSupplier<?=$nKey?>" data-code="<?=$aValue['FTStmCode']?>" data-name="<?=$aValue['FTStmName']?>">
                                <td nowrap class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?=$nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                                <td nowrap class="text-left"><?=$aValue['FTStmCode']?></td>
                                <td nowrap class="text-left"><?=$aValue['FTStmName']?></td>
                                <td nowrap class="text-right"><?=number_format($aValue['FCStmLimit'],$nOptDecimalShow)?></td>
                                <td nowrap class="text-right"><?=number_format($aValue['FNStmQty'],$nOptDecimalShow)?></td>
                                <td nowrap class="text-left"><?= language('payment/installmentterms/installmentterms','tSTMStaUnit'.$aValue['FTStmStaUnit'])?></td>
                                <td nowrap class="text-right"><?php echo number_format($aValue['FCStmRate'],$nOptDecimalShow)."%"; ?></td>
                                <td nowrap class="text-center">
                                    <!-- เปลี่ยน -->
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoStmDelete('<?php echo $aValue['FTStmCode']?>','<?php echo $aValue['FTStmName']?>')">
                                </td>
                                <td nowrap class="text-center">
                                    <!-- เปลี่ยน -->
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvStmCallPageEdit('<?php echo $aValue['FTStmCode']?>')">
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='100%'><?= language('payment/installmentterms/installmentterms','tSTMNoData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <!-- เปลี่ยน -->
    <div class="col-md-6">
    
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aStmDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aStmDataList['rnCurrentPage']?> / <?=$aStmDataList['rnAllPage']?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPageGroupSupplier btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSxStmClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aStmDataList['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSxStmClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aStmDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSxStmClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
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