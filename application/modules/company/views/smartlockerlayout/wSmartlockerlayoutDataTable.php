<?php 
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <?php if($aAlwEventSML['tAutStaFull'] == 1 || $aAlwEventSML['tAutStaDelete'] == 1) : ?>
						<th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?=language('company/shop/shop','tSHPTBChoose')?></th>
						<?php endif; ?>

                        <?php 
                        $tSesUserLevel = $this->session->userdata("tSesUsrLevel");
                        if($tSesUserLevel == 'HQ'){ ?>
                        <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableBch')?></th>
                        <?php } ?>

                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTitleGroup')?></th>
						<th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableBox')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableSize')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableScaleHorizontal')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableScaleVertical')?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableFloor')?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTitleColumn')?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableStatus')?></th>
                        <!--BTN Edit-->
                        <?php if($aAlwEventSML['tAutStaFull'] == 1 || $aAlwEventSML['tAutStaDelete'] == 1):?>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?=language('company/shop/shop','tSHPTBDelete')?></th>
						<?php endif; ?>
                        <!--BTN Delete-->
						<?php if($aAlwEventSML['tAutStaFull'] == 1 || ($aAlwEventSML['tAutStaEdit'] == 1 || $aAlwEventShop['tAutStaRead'] == 1)):?>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?=language('company/shop/shop','tSHPTBEdit')?></th>
						<?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
                        <tr class="text-center xCNTextDetail2" id="otrSMLLayout<?=$key?>" data-bch="<?=$aValue['FTBchCode']?>" data-shp="<?=$aValue['FTShpCode']?>" data-layno="<?=$aValue['FNLayNo']?>">
                            <?php if($aAlwEventSML['tAutStaFull'] == 1 || $aAlwEventSML['tAutStaDelete'] == 1) : ?>
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                            <?php endif; ?>  

                            <?php 
                            $tSesUserLevel = $this->session->userdata("tSesUsrLevel");
                            if($tSesUserLevel == 'HQ'){ ?>
                            <td nowrap class="text-left"><?=$aValue['FTBchName'] ?></td>
                            <?php } ?>
                            
                            <td nowrap class="text-left"><?=$aValue['FTRakName'] ?></td>
                            <td nowrap class="text-right"><?=$aValue['FNLayNo'] ?></td>
                            <td nowrap class="text-left"><?=$aValue['FTSizName'] ?></td>
                            <td nowrap class="text-right"><?=$aValue['FNLayScaleX'] ?></td>
                            <td nowrap class="text-right"><?=$aValue['FNLayScaleY'] ?></td>
                            <td nowrap class="text-right"><?=$aValue['FNLayRow'] ?></td>
                            <td nowrap class="text-right"><?=$aValue['FNLayCol'] ?></td>
                            <td nowrap class="text-left"><?=($aValue['FTLayStaUse'] == 1) ? language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutModalFlagStatus') : language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutModalFlagNoStatus')  ?></td>
                            <?php if($aAlwEventSML['tAutStaFull'] == 1 || $aAlwEventSML['tAutStaDelete'] == 1): ?>
                                <td nowrap class="text-center">
                                    <img class="xCNIconTable xCNIconDel" src="<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSxSMLDelete('<?=$aValue['FNLayNo']?>','<?=$aValue['FTBchCode']?>','<?=$aValue['FTShpCode']?>')">
                                </td>
                            <?php endif; ?>
                            <?php if($aAlwEventSML['tAutStaFull'] == 1 || ($aAlwEventSML['tAutStaEdit'] == 1 || $aAlwEventSML['tAutStaRead'] == 1)) : ?>
                                <td nowrap class="text-center">
                                    <?php 
                                        $aPackData = array(
                                            'FTBchName'     => $aValue['FTBchName'],
                                            'FTBchCode'     => $aValue['FTBchCode'],
                                            'FTShpCode'     => $aValue['FTShpCode'],
                                            'FNLayNo'       => $aValue['FNLayNo'],
                                            'FTLayName'     => $aValue['FTLayName'],
                                            'FTLayRemark'   => $aValue['FTLayRemark'],
                                            'FNLayScaleX'   => $aValue['FNLayScaleX'],
                                            'FNLayScaleY'   => $aValue['FNLayScaleY'],
                                            'FNLayRow'      => $aValue['FNLayRow'],
                                            'FNLayCol'      => $aValue['FNLayCol'],
                                            'FTPzeCode'     => $aValue['FTPzeCode'],
                                            'FTSizName'     => $aValue['FTSizName'],
                                            'FTRakCode'     => $aValue['FTRakCode'],
                                            'FTRakName'     => $aValue['FTRakName'],
                                            'FTLayStaUse'   => $aValue['FTLayStaUse']
                                        ); 
                                        $aPackDataJson  = JSON_encode($aPackData);
                                        $tEventClick    = 'JSxSMLEdit('.$aPackDataJson.')';
                                    ?>
                                    <img class="xCNIconTable xWIMGShpShopEdit" src="<?=base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick='<?=$tEventClick?>'>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php } ?>
                <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='12'><?=language('common/main/main','tCMNNotFoundData')?></td></tr>
                <?php endif;?>
                </tbody>
			</table>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p><?=language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?=language('common/main/main','tRecord')?> <?=language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWSMLPagePaging btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvSMLClickPage('previous')" class="btn btn-white btn-sm" <?=$tDisabledLeft ?>> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?> 
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvSMLClickPage('<?=$i?>')" type="button" class="btn xCNBTNNumPagenation <?=$tActive ?>" <?=$tDisPageNumber ?>><?=$i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvSMLClickPage('next')" class="btn btn-white btn-sm" <?=$tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<script>
    // Select List Shop Table Item
    localStorage.removeItem("LocalItemData");
    $('.ocbListItem').unbind().click(function(){
        var nbch        = $(this).parent().parent().parent().data('bch');  //bch
        var nshp        = $(this).parent().parent().parent().data('shp');  //shp
        var nlayno      = $(this).parent().parent().parent().data('layno');  //layno

        $(this).prop('checked', true);
        var LocalItemData   = localStorage.getItem("LocalItemData");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }

        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"nbch": nbch, "nshp": nshp , "nlayno":nlayno });
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxSMLPaseCodeDelInModal();
        }else{
            var aReturnRepeat   = findObjectByKeySML(aArrayConvert[0],'nlayno',nlayno,'nbch',nbch);
            if(aReturnRepeat == 'None' ){//ยังไม่ถูกเลือก
                obj.push({"nbch": nbch, "nshp": nshp , "nlayno":nlayno });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxSMLPaseCodeDelInModal();
            }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].nlayno == nlayno){
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
                JSxSMLPaseCodeDelInModal();
            }
        }
        JSxSMLShowButtonChoose();
    });

    //ค้นหาค่าซ้ำ
    function findObjectByKeySML(array, key, value , key2 , value2) {
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value && array[i][key2] === value2) {
            return "Dupilcate";
            }
        }
        return "None";
    }

</script>

