<style>
    .xWSupplierActive {
        color: #007b00 !important;
        font-weight: bold;
        cursor: default;
    }
    .xWSupplierInActive {
        color: #7b7f7b !important;
        font-weight: bold;
        cursor: default;
    }
    .xWSupplierCancle {
        color: #f60a0a !important;
        font-weight: bold;
        cursor: default;
    }
</style>
<?php 
    if($aSplDataList['rtCode'] == '1'){
        $nCurrentPage = $aSplDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbSplDataList" class="table table-striped">
                <thead>
                    <tr>
                        <th nowarp class="text-center xCNTextBold" width="10%"><?php echo  language('supplier/supplier/supplier','tChoose')?></th>
                        <th nowarp class="text-center xCNTextBold" width="5%"><?php echo  language('supplier/supplier/supplier','tSPLTBImage')?></th>
                        <th nowarp class="text-center xCNTextBold" width="15%"><?php echo  language('supplier/supplier/supplier','tCode')?></th>
                        <th nowarp class="text-center xCNTextBold"><?php echo  language('supplier/supplier/supplier','tName')?></th>
                        <th nowarp class="text-center xCNTextBold"><?php echo  language('supplier/supplier/supplier','tTel')?></th>
                        <th nowarp class="text-center xCNTextBold"><?php echo  language('supplier/supplier/supplier','tEmail')?></th>
                        <th nowarp class="text-center xCNTextBold" width="5%"><?php echo  language('supplier/supplier/supplier','tDelete')?></th>
                        <th nowarp class="text-center xCNTextBold" width="5%"><?php echo  language('supplier/supplier/supplier','tEdit')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aSplDataList['rtCode'] == 1 ):?>
                        <?php if(!empty($aSplDataList['raItems'])) { ?>
                        <?php foreach($aSplDataList['raItems'] AS $nKey => $aValue):?>
                            <tr class=" xCNTextDetail2 otrSupplier" id="otrSupplier<?php echo $nKey?>" data-code="<?php echo $aValue['rtSplCode']?>" data-name="<?php echo $aValue['rtSplName']?>">
                                <td  nowarp class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?=$nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                                <td class="text-center" nowarp><?=FCNtHGetImagePageList($aValue['FTImgObj'],'40px')?></td>
                                <td nowarp><?php echo $aValue['rtSplCode']?></td>
                                <td nowarp><?php echo $aValue['rtSplName']?></td>
                                <td nowarp><?php echo $aValue['rtSplTel']?></td>
                                <td nowarp><?php echo $aValue['rtSplEmail']?></td>
                                
                                
                                <td nowarp class="text-center">
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoSupplierDel('<?php echo $aValue['rtSplCode']?>','<?php echo $aValue['rtSplName']?>')">
                                </td>
                                <td nowarp class="text-center">
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageSupplierEdit('<?php echo $aValue['rtSplCode']?>')">
                                </td>
                            </tr>
                           
                        <?php endforeach;?>
                    
                        <?php } ?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='9'><?php echo language('supplier/supplier/supplier','tSPLTBNoData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aSplDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?php echo $aSplDataList['rnCurrentPage']?> / <?php echo $aSplDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageSupplier btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvSupplierClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aSplDataList['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvSupplierClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aSplDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvSupplierClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<div class="modal fade" id="odvModalDelSupplier">
	<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <span id="ospConfirmDelete" class="xCNTextModal"></span>
                <input type='hidden' id="ohdConfirmIDDelete">
            </div>
            <div class="modal-footer">
                <button id="osmConfirm" onClick="JSoSupplierDelChoose('<?php echo $nCurrentPage ?>')" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
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