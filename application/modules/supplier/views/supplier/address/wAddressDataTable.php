<style>
    /* .xWSplAddressActive {
        color: #007b00 !important;
        font-weight: bold;
        cursor: default;
    }
    .xWSplAddressInActive {
        color: #7b7f7b !important;
        font-weight: bold;
        cursor: default;
    }
    .xWSplAddressCancle {
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
?>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbSplDataList" class="table table-striped">
                <thead>
                    <tr>
                        <th nowarp class="text-center xCNTextBold" width="15%"><?php echo  language('pos5/supplier','tName')?></th>
                        <th nowarp class="text-center xCNTextBold" width=""><?php echo  language('pos5/supplier','tAddress')?></th>
                        <th nowarp class="text-center xCNTextBold" width="15%"><?php echo  language('pos5/supplier','tAddWebsite')?></th>
                        <th nowarp class="text-center xCNTextBold" width="5%"><?php echo  language('pos5/supplier','tDelete')?></th>
                        <th nowarp class="text-center xCNTextBold" width="5%"><?php echo  language('pos5/supplier','tEdit')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aDataList['rtCode'] == 1 ):?>
                        <?php foreach($aDataList['raItems'] AS $nKey => $aValue):?>
                            <tr class="xCNTextDetail2 otrSplAddress" id="otrSplAddress<?php echo $nKey?>" data-code="<?php echo $aValue['rtSplCode']?>">
                                
                                <td nowarp><?php echo $aValue['rtAddName']?></td>
                                <td nowarp>
                                    <?php 
                                        $tFormat = FCNaHAddressFormat('TCNMSpl');//1 ที่อยู่ แบบแยก  ,2  แบบรวม
                                        if($tFormat == '1'){
                                            echo $aValue['rtAddV1No'].' '.$aValue['rtAddV1Soi'].' '.$aValue['rtAddV1Village'].' '.$aValue['rtAddV1Road'].' '.$aValue['rtAddV1SubDist'].' '.$aValue['rtAddV1DstCode'].' '.$aValue['rtAddV1PvnCode'].' '.$aValue['rtAddV1PostCode'];
                                        }else{
                                            echo $aValue['rtAddV2Desc1'];
                                        }
                                    ?>
                                </td>
                                <td nowarp><?php echo $aValue['rtAddWebsite']?></td>
                                
                                
                                <td nowarp class="text-center">
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/assets/icons/delete.png'?>" onClick="JSoSplAddressDel('<?php echo $aValue['rtAddName']?>','<?php echo $aValue['rtSplCode']?>','<?php echo $aValue['rtLngID']?>','<?php echo $aValue['rtAddGrpType']?>','<?php echo $aValue['rtAddSeqNo']?>')">
                                </td>
                                <td nowarp class="text-center">
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/assets/icons/edit.png'?>" onClick="JSvCallPageSplAddressEdit('<?php echo $aValue['rtSplCode']?>','<?php echo $aValue['rtLngID']?>','<?php echo $aValue['rtAddGrpType']?>','<?php echo $aValue['rtAddSeqNo']?>')">
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
        <div class="xWPageSplAddress btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvSplAddressClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvSplAddressClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvSplAddressClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
    

    <div class="modal fade" id="odvModalDelSplAddress">
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
                    <button id="osmConfirm" onClick="JSoSplAddressDel('<?php echo $nCurrentPage ?>')" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
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