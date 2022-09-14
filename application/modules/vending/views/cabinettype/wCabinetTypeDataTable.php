<?php

    if($aCBNDataList['rtCode'] == '1'){
      $nCurrentPage  =   $aCBNDataList['rnCurrentPage'];
    }else{
       $nCurrentPage = '1'; 
    }

?>
<div class="row">
    <div class="col-md-12">
        <input type="hidden" id="nCurrentPageTB" value="<?php echo $nCurrentPage;?>">
        <div class="table-responsive"> 
            <table id="otbCBNDataList" class="table table-striped">
                <thead>
                    <tr>
                        <?php if($aAlwEventCabinetType['tAutStaFull'] == 1 || $aAlwEventCabinetType['tAutStaDelete'] == 1) : ?>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('vending/cabinettype/cabinettype','tCBNChoose');?></th>
                        <?php endif;?>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('vending/cabinettype/cabinettype','tCBNCode');?></th>
                        <th nowrap class="text-center xCNTextBold" width="20%"><?php echo language('vending/cabinettype/cabinettype','tCBNName');?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('vending/cabinettype/cabinettype','tCBNCabinettype');?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('vending/cabinettype/cabinettype','tCBNTemperature');?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('vending/cabinettype/cabinettype','tCBNLowtemp');?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('vending/cabinettype/cabinettype','tCBNHighttemp');?></th>
                        <?php if($aAlwEventCabinetType['tAutStaFull'] == 1 || $aAlwEventCabinetType['tAutStaDelete'] == 1) : ?>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('vending/cabinettype/cabinettype','tCBNDelete');?></th>  
                        <?php endif;?>
                        <?php if($aAlwEventCabinetType['tAutStaFull'] == 1 || ($aAlwEventCabinetType['tAutStaEdit'] == 1 || $aAlwEventCabinetType['tAutStaRead'] == 1))  : ?>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('vending/cabinettype/cabinettype','tCBNEdit'); ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvCBNTypelist">
                    <?php if($aCBNDataList['rtCode'] == 1):?>
                         <?php foreach($aCBNDataList['raItems'] AS $nKey => $aValue) : ?>
                            <tr class="text-center xCNTextDetail2 otrCBNType" id="otrCBNType<?php echo $nKey; ?>" data-code="<?php echo $aValue['rtShtCode']; ?>" data-name="<?php echo $aValue['rtShtName']; ?>">
                                <?php if($aAlwEventCabinetType['tAutStaFull'] == 1 || $aAlwEventCabinetType['tAutStaDelete'] == 1) : ?>
                                    <td nowrap class="text-center">
                                        <label class="fancy-checkbox">
											<input id="ocbListItem<?=$nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" 
                                            ohdConfirmShtCodeDelete="<?=$aValue['rtShtCode'];?>">
											<span>&nbsp;</span>
										</label>
                                    </td> 
                                <?php endif; ?>
                                <td nowrap class="text-left"><?php echo $aValue['rtShtCode'];?></td>
                                <td nowrap class="text-left"><?php echo $aValue['rtShtName'];?> </td>
                                
                                <?php
                                    switch ($aValue['rtShtType']) {
                                        case 1:
                                            $tStaShtType   = language('vending/cabinettype/cabinettype','tCBNCool');
                                        break;
                                        case 2:
                                            $tStaShtType   = language('vending/cabinettype/cabinettype','tCBNHeatCabinet');
                                        break;
                                        case 3:
                                            $tStaShtType   = language('vending/cabinettype/cabinettype','tCBNHeatCool');
                                        break;
                                        default:
                                            $tStaShtType   = language('vending/cabinettype/cabinettype','tCBNCool');
                                    }
                                ?>
                                <td nowrap class="text-left"><?php echo $tStaShtType;?></td>
                                <td nowrap class="text-right"><?php echo $aValue['rtShtValue'];?></td>
                                <td nowrap class="text-right"><?php echo $aValue['rtShtMin'];?></td>
                                <td nowrap class="text-right"><?php echo $aValue['rtShtMax'];?></td>
                                <?php if($aAlwEventCabinetType['tAutStaFull'] == 1 || $aAlwEventCabinetType['tAutStaDelete'] == 1) : ?>
                                <td nowrap>
                                    <?php if(!FCNbIsHaveCardInCardType($aValue['rtShtCode'])) : ?>
                                        <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoCabinetTypeDel('<?php echo $nCurrentPage?>','<?php echo $aValue['rtShtCode']?>','<?php echo $aValue['rtShtName']?>','<?= language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                    <?php endif; ?>
                                </td>
                                <?php endif; ?>
                                <?php if($aAlwEventCabinetType['tAutStaFull'] == 1 || ($aAlwEventCabinetType['tAutStaEdit'] == 1 || $aAlwEventCabinetType['tAutStaRead'] == 1)) : ?>
                                <td nowrap>
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageCabinetTypeEdit('<?php echo $aValue['rtShtCode']?>')">
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td nowrap class='text-center xCNTextDetail2' colspan='99'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p><?=language('common/main/main','tResultTotalRecord')?> <?=$aCBNDataList['rnAllRow']?> <?=language('common/main/main','tRecord')?> <?=language('common/main/main','tCurrentPage')?> <?=$aCBNDataList['rnCurrentPage']?> / <?=$aCBNDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageCabinet btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvCabinetClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aCBNDataList['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvCabinetClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aCBNDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCabinetClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>


<div class="modal fade" id="odvModalDeleteMutirecord">
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
                <button id="osmConfirm" onClick="JSoCabinetTypeDelChoose('<?php echo $nCurrentPage ?>')" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
                    <?php echo language('common/main/main', 'tModalConfirm')?>
                </button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel')?>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Select List Userlogin Table Item
    $(function() {
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
        });
    });
</script>

