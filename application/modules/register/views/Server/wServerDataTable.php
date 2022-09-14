<?php 
    if($aSrvDataList['rtCode'] == '1'){
        $nCurrentPage = $aSrvDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>


<div class="row">
    <div class="col-md-12">
        <input type="hidden" id="nCurrentPageTB" value="<?=$nCurrentPage?>">
       <div class="table-responsive">
            <table id="otbSrvDataList" class="table table-striped">
                <thead>
                    <tr>
                        <?php if($aAlwEventServer['tAutStaFull'] == 1 || $aAlwEventServer['tAutStaDelete'] == 1) : ?>
                        <th class="text-center" style="width:10%;"><?php echo language('register/register','tSrvTBChoose')?></th>
                        <?php endif; ?>
                        <th class="text-left" style="width:10%;"><?php echo language('register/register','tSrvTBCode')?></th>
                        <th class="text-left"><?php echo language('register/register','tSrvTBName')?></th>
                        <th class="text-left"><?php echo language('register/register','tSrvFrmSrvStaCenter')?></th>
                        <th class="text-left"><?php echo language('register/register','tSrvFrmSrvRefAPIMaste')?></th>
                        <th class="text-left"><?php echo language('register/register','tSrvFrmSrvGroup')?></th>
                        <?php if($aAlwEventServer['tAutStaFull'] == 1 || $aAlwEventServer['tAutStaDelete'] == 1) : ?>
                        <th class="text-center" style="width:10%;"><?php echo language('register/register','tSrvTBDelete')?></th>
                        <?php endif; ?>
                        <?php if($aAlwEventServer['tAutStaFull'] == 1 || ($aAlwEventServer['tAutStaEdit'] == 1 || $aAlwEventServer['tAutStaRead'] == 1))  : ?>
                        <th class="text-center" style="width:10%;"><?php echo language('register/register','tSrvTBEdit')?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aSrvDataList['rtCode'] == 1 ):?>
                        <?php foreach($aSrvDataList['raItems'] AS $nKey => $aValue):?>
                            <tr class="otrServer" id="otrServer<?php echo $nKey?>" data-code="<?php echo $aValue['rtSrvCode']?>" data-name="<?php echo $aValue['rtSrvName']?>">
                                <?php if($aAlwEventServer['tAutStaFull'] == 1 || $aAlwEventServer['tAutStaDelete'] == 1) : ?>
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?php echo $nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" value="<?=$aValue['rtSrvRefAPIMaste']?>" data-synlst="<?=$aValue['rtSyncLast']?>" >
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                                <?php endif; ?>
                                <td><?php echo $aValue['rtSrvCode']?></td>
                                <td class="text-left"><?php echo $aValue['rtSrvName']?></td>
                                <td><?php echo $aValue['rtSrvStaCenter']?></td>
                                <td><?php echo $aValue['rtSrvRefAPIMaste']?></td>
                                <td><?php echo $aValue['rtSrvGroup']?></td>
                                <?php if($aAlwEventServer['tAutStaFull'] == 1 || $aAlwEventServer['tAutStaDelete'] == 1) : ?>
                                <td class="text-center"><img class="xCNIconTable xCNIconDel" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoServerDel('<?=$nCurrentPage?>','<?php echo $aValue['rtSrvCode']?>','<?=$aValue['rtSrvName']?>','<?= language('common/main/main','tModalConfirmDeleteItemsYN')?>')"></td>
                                <?php endif; ?>
                                <?php if($aAlwEventServer['tAutStaFull'] == 1 || ($aAlwEventServer['tAutStaEdit'] == 1 || $aAlwEventServer['tAutStaRead'] == 1))  : ?>
                                <td class="text-center"><img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageServerEdit('<?php echo $aValue['rtSrvCode']?>')"></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='5'><?php echo  language('register/register','tSrvTBNoData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aSrvDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aSrvDataList['rnCurrentPage']?> / <?=$aSrvDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPageServer btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvServerClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aSrvDataList['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvServerClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aSrvDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvServerClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
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