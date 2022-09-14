<style>
    .xWImgSalePerson {
        max-width: 50px;
    }
</style>

<?php
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage =  $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }


?>

<div class="row">
    <div class="col-md-12">
        <input type="hidden" id="nCurrentPageTB" value="<?=$nCurrentPage;?>">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('pos/saleperson/saleperson','tSPNChoose')?></th>
                        <th class="xCNTextBold text-left" style="width:5%;"><?= language('pos/saleperson/saleperson','tSPNCode')?></th>
                        <th class="xCNTextBold text-left" style="width:5%;"><?= language('pos/saleperson/saleperson','tSPNImg')?></th>
                        <th class="xCNTextBold text-left" style="width:20%;"><?= language('pos/saleperson/saleperson','tSPNName')?></th>
                        <th class="xCNTextBold text-left" style="width:20%;"><?= language('company/branch/branch','tBCHTitle')?></th>
                        <th class="xCNTextBold text-left" style="width:20%;"><?= language('company/shop/shop','tSHPTitle')?></th>
                        <th class="xCNTextBold text-left" style="width:15%;"><?= language('pos/saleperson/saleperson','tSPNTel')?></th>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('pos/saleperson/saleperson','tSPNDelete')?></th>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('pos/saleperson/saleperson','tSPNEdit')?></th>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php if(!empty($aDataList['raItems'])) { ?>
                        <?php foreach($aDataList['raItems'] as $key => $aValue){ ?>
                            <tr class="text-center xCNTextDetail2 otrSalePerson" id="otrSalePerson<?=$key?>" data-code="<?=$aValue['rtSpnCode']?>" data-name="<?=$aValue['rtSpnName']?>">
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" onchange="JSxSalePersonVisibledDelAllBtn(this, event)">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                                <td class="text-left otdSpnCode"><?=$aValue['rtSpnCode']?></td>
        
                                    <?php
                                        if (isset($aValue['rtImgObj']) && !empty($aValue['rtImgObj'])) {
                                            $tFullPatch = './application/modules/' . $aValue['rtImgObj'];
                                            if (file_exists($tFullPatch)) {
                                                $tPatchImg = base_url() . '/application/modules/' . $aValue['rtImgObj'];
                                            } else {
                                                $tPatchImg = base_url() . 'application/modules/common/assets/images/Noimage.png';
                                            }
                                        } else {
                                            $tPatchImg = base_url() . 'application/modules/common/assets/images/Noimage.png';
                                        }
                                    ?>

                                <td><img class="" src="<?php echo $tPatchImg?>" style="width:50px;"></td>
                                <td class="text-left"><?=$aValue['rtSpnName']?></td>    
                                <td class="text-left"><?=$aValue['rtBchName']?></td>
                                <?php $tShpName; $aValue['rtShpName'] == "" ? $tShpName = 'ทั้งหมด' : $tShpName = $aValue['rtShpName'] ?>
                                <td class="text-left"><?php echo $tShpName; ?></td>
                                <td class="text-left"><?=$aValue['rtSpnTel']?></td>
                                <td>
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSaSalePersonDelete('<?php echo $nCurrentPage?>','<?php echo $aValue['rtSpnCode']?>','<?php echo $aValue['rtSpnName']?>')">
                                </td>
                                <td>
                                    <img class="xCNIconTable" src="<?php echo  base_url().'//application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageSalePersonEdit('<?=$aValue['rtSpnCode']?>')" title="<?php echo language('customer/customerGroup/customerGroup', 'tCstGrpTBEdit'); ?>">
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='99'><?=language('common/main/main', 'tCMNNotFoundData')?></td></tr>
                <?php endif;?>
                </tbody>
			</table>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aDataList['rnCurrentPage']?> / <?php echo $aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageSalePerson btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvSalePersonClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvSalePersonClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvSalePersonClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>



<div class="modal fade" id="odvModalDelSalePerson">
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
                <button id="osmConfirm" onClick="JSnSalePersonDelChoose('<?php echo $nCurrentPage ?>')" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
                    <?php echo language('common/main/main', 'tModalConfirm')?>
                </button>
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
	});
	
</script>


<script type="text/javascript">
    $('ducument').ready(function(){});
</script>
