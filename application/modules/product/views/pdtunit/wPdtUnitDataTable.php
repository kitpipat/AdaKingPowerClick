<?php 
    if($aPunDataList['rtCode'] == '1'){
        $nCurrentPage = $aPunDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>


<div class="row">
    <div class="col-md-12">
        <input type="hidden" id="nCurrentPageTB" value="<?=$nCurrentPage?>">
       <div class="table-responsive">
            <table id="otbPunDataList" class="table table-striped">
                <thead>
                    <tr>
                        <?php if($aAlwEventPdtUnit['tAutStaFull'] == 1 || $aAlwEventPdtUnit['tAutStaDelete'] == 1) : ?>
                        <th class="text-center" style="width:10%;"><?php echo language('product/pdtunit/pdtunit','tPUNTBChoose')?></th>
                        <?php endif; ?>
                        <th class="text-center" style="width:10%;"><?php echo language('product/pdtunit/pdtunit','tPUNTBCode')?></th>
                        <th class="text-center"><?php echo language('product/pdtunit/pdtunit','tPUNTBName')?></th>
                        <?php if($aAlwEventPdtUnit['tAutStaFull'] == 1 || $aAlwEventPdtUnit['tAutStaDelete'] == 1) : ?>
                        <th class="text-center" style="width:10%;"><?php echo language('product/pdtunit/pdtunit','tPUNTBDelete')?></th>
                        <?php endif; ?>
                        <?php if($aAlwEventPdtUnit['tAutStaFull'] == 1 || ($aAlwEventPdtUnit['tAutStaEdit'] == 1 || $aAlwEventPdtUnit['tAutStaRead'] == 1))  : ?>
                        <th class="text-center" style="width:10%;"><?php echo language('product/pdtunit/pdtunit','tPUNTBEdit')?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aPunDataList['rtCode'] == 1 ):?>
                        <?php foreach($aPunDataList['raItems'] AS $nKey => $aValue):?>
                            <tr class="text-center otrPdtUnit" id="otrPdtUnit<?php echo $nKey?>" data-code="<?php echo $aValue['rtPunCode']?>" data-name="<?php echo $aValue['rtPunName']?>">
                                <?php if($aAlwEventPdtUnit['tAutStaFull'] == 1 || $aAlwEventPdtUnit['tAutStaDelete'] == 1) : ?>
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?php echo $nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                                <?php endif; ?>
                                <td class="text-left"><?php echo $aValue['rtPunCode']?></td>
                                <td class="text-left"><?php echo $aValue['rtPunName']?></td>
                                <?php if($aAlwEventPdtUnit['tAutStaFull'] == 1 || $aAlwEventPdtUnit['tAutStaDelete'] == 1) : ?>
                                <td><img class="xCNIconTable xCNIconDel" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoPdtUnitDel('<?=$nCurrentPage?>','<?php echo $aValue['rtPunCode']?>','<?=$aValue['rtPunName']?>','<?= language('common/main/main','tModalConfirmDeleteItemsYN')?>')"></td>
                                <?php endif; ?>
                                <?php if($aAlwEventPdtUnit['tAutStaFull'] == 1 || ($aAlwEventPdtUnit['tAutStaEdit'] == 1 || $aAlwEventPdtUnit['tAutStaRead'] == 1))  : ?>
                                <td><img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPagePdtUnitEdit('<?php echo $aValue['rtPunCode']?>')"></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='5'><?php echo  language('product/pdtunit/pdtunit','tPUNTBNoData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aPunDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aPunDataList['rnCurrentPage']?> / <?=$aPunDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPagePdtUnit btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvPdtUnitClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aPunDataList['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvPdtUnitClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aPunDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvPdtUnitClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
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
    });
</script>