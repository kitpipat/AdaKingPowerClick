<style>
    .table > tbody > tr > td > i {
        display : block;
    }
</style>

<?php 
    if($aPgpDataList['rtCode'] == '1'){
        $nCurrentPage = $aPgpDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>

<div class="row">
    <div class="col-md-12">
        <input type="hidden" id="nCurrentPageTB" value="<?=$nCurrentPage?>">
        <div class="table-responsive">
            <table id="otbPgpDataList" class="table table-striped">
                <thead>
                    <tr>
                        <?php if($aAlwEventPdtGroup['tAutStaFull'] == 1 || $aAlwEventPdtGroup['tAutStaDelete'] == 1 ) : ?>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/pdtgroup/pdtgroup','tPGPTBChoose')?></th>
                        <?php endif; ?>
                        <th class="text-center xCNTextBold"><?= language('product/pdtgroup/pdtgroup','tPGPFrmPgpImg')?></th>
                        <th class="text-center xCNTextBold"><?= language('product/pdtgroup/pdtgroup','tPGPTBCode')?></th>
                        <th class="text-center xCNTextBold"><?= language('product/pdtgroup/pdtgroup','tPGPTBChainCode')?></th>
                        <th class="text-center xCNTextBold"><?= language('product/pdtgroup/pdtgroup','tPGPTBName')?></th>
                        <th class="text-center xCNTextBold"><?= language('product/pdtgroup/pdtgroup','tPGPTBChainName')?></th>
                        <?php if($aAlwEventPdtGroup['tAutStaFull'] == 1 || $aAlwEventPdtGroup['tAutStaDelete'] == 1 ) : ?>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/pdtgroup/pdtgroup','tPGPTBDelete')?></th>
                        <?php endif; ?>
                        <?php if($aAlwEventPdtGroup['tAutStaFull'] == 1 || ($aAlwEventPdtGroup['tAutStaEdit'] == 1 || $aAlwEventPdtGroup['tAutStaRead'] == 1))  : ?>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/pdtgroup/pdtgroup','tPGPTBEdit')?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aPgpDataList['rtCode'] == 1 ):?>
                        <?php foreach($aPgpDataList['raItems'] AS $nKey => $aValue):?>
                            <tr class="text-center otrPdtGroup" id="otrPdtGroup<?php echo $nKey?>" data-code="<?php echo $aValue['rtPgpCode']?>" data-name="<?php echo $aValue['rtPgpName']?>">
                                <?php if($aAlwEventPdtGroup['tAutStaFull'] == 1 || $aAlwEventPdtGroup['tAutStaDelete'] == 1) : ?>
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?php echo $nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                                <?php endif; ?>
                                <td class="text-center">
                                    <?php echo FCNtHGetImagePageList($aValue['rtFTImgObj'], '38px');?>
                                </td>
                                <td><?php echo $aValue['rtPgpCode']?></td>
                                <td class="text-left"><?=$aValue['rtPgpChain']?></td>
                                <td class="text-left"><?php echo $aValue['rtPgpName']?></td>
                                <td class="text-left"><?=$aValue['rtPgpChainName']?></td>
                                <?php if($aAlwEventPdtGroup['tAutStaFull'] == 1 || $aAlwEventPdtGroup['tAutStaDelete'] == 1 ) : ?>
                                <td><img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoPdtGroupDel('<?=$nCurrentPage?>','<?php echo $aValue['rtPgpCode']?>','<?=$aValue['rtPgpName']?>')"></td>
                                <?php endif; ?>
                                <?php if($aAlwEventPdtGroup['tAutStaFull'] == 1 || ($aAlwEventPdtGroup['tAutStaEdit'] == 1 || $aAlwEventPdtGroup['tAutStaRead'] == 1))  : ?>
                                <td><img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPagePdtGroupEdit('<?php echo $aValue['rtPgpCode']?>')"></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='8'><?php echo  language('product/pdtgroup/pdtgroup','tPGPTBNoData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aPgpDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aPgpDataList['rnCurrentPage']?> / <?=$aPgpDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPagePdtGroup btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvPdtGroupClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aPgpDataList['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvPdtGroupClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aPgpDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvPdtGroupClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
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