<?php
    if($aCatDataList['rtCode'] == '1'){
        $nCurrentPage = $aCatDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>
<div class="row">
    <div class="col-md-12">
        <input type="hidden" id="nCurrentPageTB" value="<?=$nCurrentPage?>">
       <div class="table-responsive">
            <table id="otbCatDataList" class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center" style="width:5%;"><?php echo language('product/pdtcat/pdtcat','tCATTBChoose')?></th>
                        <th class="text-center" style="width:5%;"><?php echo language('product/pdtcat/pdtcat','tCATNo')?></th>
                        <th class="text-center" style="width:40%;"><?php echo language('product/pdtcat/pdtcat','tCATTBCode')?></th>
                        <th class="text-center" style="width:40%;"><?php echo language('product/pdtcat/pdtcat','tCATTBName')?></th>

                        <th class="text-center" style="width:5%;"><?php echo language('product/pdtcat/pdtcat','tCATTBDelete')?></th>

                        <th class="text-center" style="width:5%;"><?php echo language('product/pdtcat/pdtcat','tCATTBEdit')?></th>

                    </tr>
                </thead>
                <tbody>
                    <?php if($aCatDataList['rtCode'] == 1 ):?>
                        <?php foreach($aCatDataList['raItems'] AS $nKey => $aValue):?>
                            <tr class="text-center otrPdtCat" id="otrPdtCat<?php echo $nKey?>" data-code="<?php echo $aValue['tCatCode']?>" data-name="<?php echo $aValue['tCatName']?>">

                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?php echo $nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>

                                <td class="text-left"><?php echo $aValue['rtRowID']?></td>
                                <td class="text-left"><?php echo $aValue['tCatCode']?></td>
                                <td class="text-left"><?php echo $aValue['tCatName']?></td>
                                <td><img class="xCNIconTable xCNIconDel" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoPdtCatDel('<?=$nCurrentPage?>','<?php echo $aValue['tCatCode']?>','<?=$aValue['tCatName']?>','<?= language('common/main/main','tModalConfirmDeleteItemsYN')?>')"></td>

                                <td><img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPagePdtCatEdit('<?php echo $aValue['tCatCode']?>')"></td>

                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='5'><?php echo  language('product/pdtcat/pdtcat','tCATTBNoData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aCatDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aCatDataList['rnCurrentPage']?> / <?=$aCatDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPagePdtCat btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvPdtCatClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aCatDataList['rnAllPage'],$nPage+2)); $i++){?>
                <?php
                    if($nPage == $i){
                        $tActive = 'active';
                        $tDisPageNumber = 'disabled';
                    }else{
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvPdtCatClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aCatDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvPdtCatClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
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
