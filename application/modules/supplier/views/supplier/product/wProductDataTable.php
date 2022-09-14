<style>
    /* .xWSplProductActive {
        color: #007b00 !important;
        font-weight: bold;
        cursor: default;
    }
    .xWSplProductInActive {
        color: #7b7f7b !important;
        font-weight: bold;
        cursor: default;
    }
    .xWSplProductCancle {
        color: #f60a0a !important;
        font-weight: bold;
        cursor: default;
    } */
</style>
<?php 
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
    // echo '<pre>';
    // print_r($aDataList['raItems']);
    // exit;
?>
    <input type="hidden" id="ohdSplCode" value="<?php echo $tSplCode;?>">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbSplDataList" class="table table-striped">
                <thead>
                    <tr>
                        <th nowarp class="text-center xCNTextBold" width="15%"><?php echo  language('pos5/supplier','tCode')?></th>
                        <th nowarp class="text-center xCNTextBold" width=""><?php echo  language('pos5/supplier','tName')?></th>
                        <th nowarp class="text-center xCNTextBold" width="15%"><?php echo  language('pos5/supplier','tBarCode')?></th>
                        <th nowarp class="text-center xCNTextBold" width="15%"><?php echo  language('pos5/supplier','tUsrName')?></th>
                        <th nowarp class="text-center xCNTextBold" width="5%"><?php echo  language('pos5/supplier','tDelete')?></th>
                        <th nowarp class="text-center xCNTextBold" width="5%"><?php echo  language('pos5/supplier','tEdit')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aDataList['rtCode'] == 1 ):?>
                        <?php foreach($aDataList['raItems'] AS $nKey => $aValue):?>
                            <tr class="xCNTextDetail2 otrSplProduct" id="otrSplProduct<?php echo $nKey?>" data-code="<?php echo $aValue['rtSplCode']?>">
                                
                                <td nowarp><?php echo $aValue['rtPdtCode']?></td>
                                <td nowarp><?php echo $aValue['rtPdtName']?></td>
                                <td nowarp><?php echo $aValue['rtBarCode']?></td>
                                <td nowarp><?php echo $aValue['rtUsrName']?></td>
                                <td nowarp class="text-center">
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/assets/icons/delete.png'?>" onClick="JSoSplProductDel('<?php echo $aValue['rtPdtName']?>','<?php echo $aValue['rtSplCode']?>','<?php echo $aValue['rtLngID']?>','<?php echo $aValue['rtBarCode']?>','<?php echo $aValue['rtPdtCode']?>')">
                                </td>
                                <td nowarp class="text-center">
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/assets/icons/edit.png'?>" onClick="JSvCallPageSplProductEdit('<?php echo $aValue['rtSplCode']?>','<?php echo $aValue['rtLngID']?>','<?php echo $aValue['rtBarCode']?>','<?php echo $aValue['rtPdtCode']?>')">
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='9'><?php echo language('pos5/supplier','tSPLTBNoData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p>พบข้อมูลทั้งหมด <?php echo $aDataList['rnAllRow']?> รายการ แสดงหน้า <?php echo $aDataList['rnCurrentPage']?> / <?php echo $aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageSplProduct btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvSplProductClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvSplProductClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvSplProductClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
    

    <div class="modal fade" id="odvModalDelSplProduct">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
                </div>
                <div class="modal-body">
                    <span id="ospConfirmDeleteSplProduct" class="xCNTextModal"></span>
                    <input type='hidden' id="ohdConfirmIDDeleteSplProduct">
                </div>
                <div class="modal-footer">
                    <button id="osmConfirmSplProduct" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
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
    });
    
</script>