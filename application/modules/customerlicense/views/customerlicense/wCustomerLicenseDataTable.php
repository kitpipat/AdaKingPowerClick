<style>
    .xWImgCustomer{
        width: 50px;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>

                        <?php if(false) : ?><th class="xCNTextBold text-center" style="width:5%;"><?= language('customerlicense/customerlicense/customerlicense','tCSTCode')?></th><?php endif; ?>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('customerlicense/customerlicense/customerlicense','tCSTImg')?></th>
                        <th class="xCNTextBold text-center" style="width:20%;"><?= language('customerlicense/customerlicense/customerlicense','tCSTName')?></th>
                        <th class="xCNTextBold text-center" style="width:15%;"><?= language('customerlicense/customerlicense/customerlicense','tCSTTel')?></th>
                        <th class="xCNTextBold text-center" style="width:15%;"><?= language('customerlicense/customerlicense/customerlicense','tCSTEmail')?></th>
                        <th class="xCNTextBold text-center" style="width:20%;"><?= language('company/branch/branch','tCSTGroup')?></th>
                        <?php if(false) : ?><th class="xCNTextBold text-center" style="width:20%;"><?= language('company/shop/shop','tSHPTitle')?></th><?php endif; ?>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('customerlicense/customerlicense/customerlicense','tCSTEdit')?></th>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] as $key => $aValue){ ?>
                        <tr class="text-center xCNTextDetail2 otrCustomer" id="otrCustomer<?=$key?>" data-code="<?=$aValue['rtCstCode']?>" data-name="<?=$aValue['rtCstName']?>">

                            <input type="hidden" class="xWCustomerCode" value="<?php echo $aValue['rtCstCode']; ?>">
                            <?php if(false) : ?><td class="text-left otdCstCode"><?php echo $aValue['rtCstCode']; ?></td><?php endif; ?>
                            <?php
                                // $tImgObjPath = $aValue['rtImgObj'];
                                // if(isset($tImgObjPath) && !empty($tImgObjPath)){
                                //     $aImgObj    = explode("application",$tImgObjPath);
                                //     $tFullPatch = './application'.$aImgObj[1];
                                //     if (file_exists($tFullPatch)){
                                //         $tPatchImg = base_url().'/application'.$aImgObj[1];
                                //     }else{
                                //         $tPatchImg = base_url().'application/modules/common/assets/images/200x200.png';
                                //     }
                                // }else{
                                //     $tPatchImg = base_url().'application/modules/common/assets/images/200x200.png';
                                // }
                            ?>

                            <td class="text-center"><?=FCNtHGetImagePageList($aValue['rtImgObj'],'40px');?></td>
                            <td class="text-left"><?=$aValue['rtCstName']?></td>
                            <td class="text-left"><?=$aValue['rtCstTel']?></td>
                            <td class="text-left"><?=$aValue['rtCstEmail']?></td>
                            <td class="text-left"><?=$aValue['rtCgpName']?></td>
                            <?php if(false) : ?><td class="text-left"></td><?php endif; ?>

                            <td>
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCLNCallPageCustomerEdit('<?=$aValue['rtCstCode']?>')">
                            </td>
                        </tr>
                    <?php } ?>
                <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='7'><?= language('common/main/main','tCMNNotFoundData')?> </td></tr>
                <?php endif;?>
                </tbody>
			</table>
        </div>
    </div>
</div>

<div class="row">
    <!-- ????????????????????? -->
    <div class="col-md-6">
        <p>????????????????????????????????????????????? <?=$aDataList['rnAllRow']?> ?????????????????? ???????????????????????? <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <!-- ????????????????????? -->
    <div class="col-md-6">
        <div class="xWPageCst btn-toolbar pull-right"> <!-- ????????????????????????????????? Class ?????????????????????????????????????????????????????? -->
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvCLNClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- ????????????????????????????????? Onclick ?????????????????????????????????????????????????????? -->
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?> <!-- ????????????????????????????????? Parameter Loop ?????????????????????????????????????????????????????? -->
                <?php
                    if($nPage == $i){
                        $tActive = 'active';
                        $tDisPageNumber = 'disabled';
                    }else{
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <!-- ????????????????????????????????? Onclick ?????????????????????????????????????????????????????? -->
                <button onclick="JSvCLNClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCLNClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- ????????????????????????????????? Onclick ?????????????????????????????????????????????????????? -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<script type="text/javascript">
$('ducument').ready(function(){});
</script>

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
            if(aReturnRepeat == 'None' ){           //??????????????????????????????????????????
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxTextinModal();
            }else if(aReturnRepeat == 'Dupilcate'){	//?????????????????????????????????????????????
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
