<style>
    .xWCardActive {
        color: #007b00 !important;
        font-weight: bold;
        cursor: default;
    }
    .xWCardInActive {
        color: #7b7f7b !important;
        font-weight: bold;
        cursor: default;
    }
    .xWCardCancle {
        color: #f60a0a !important;
        font-weight: bold;
        cursor: default;
    }
</style>
<?php 
    if($aCtyDataList['rtCode'] == '1'){
        $nCurrentPage = $aCtyDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }

    //Decimal Show
    $tDecShow = FCNxHGetOptionDecimalShow();
?>
<div class="row">
    <div class="col-md-12">
        <input type="hidden" id="nCurrentPageTB" value="<?=$nCurrentPage;?>">
        <div class="table-responsive">
            <table id="otbCtyDataList" class="table table-striped"> <!-- เปลี่ยน -->
                <thead>
                    <tr>
                        <?php if($aAlwEventCardtype['tAutStaFull'] == 1 || $aAlwEventCardtype['tAutStaDelete'] == 1) : ?>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('payment/cardtype/cardtype','tCTYChoose'); ?></th>
                        <?php endif; ?>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('payment/cardtype/cardtype','tCTYCode'); ?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('payment/cardtype/cardtype','tCTYName'); ?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('payment/cardtype/cardtype','tCTYDeposit'); ?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('payment/cardtype/cardtype','tCTYExpireCardlife'); ?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('payment/cardtype/cardtype','tCTYStaPay');?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('payment/cardtype/cardtype','tCTYPaylimit');?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('payment/cardtype/cardtype','TCTYStaAlwRet'); ?></th>
                        <?php if($aAlwEventCardtype['tAutStaFull'] == 1 || $aAlwEventCardtype['tAutStaDelete'] == 1) : ?>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('payment/cardtype/cardtype','tCTYDelete'); ?></th>
                        <?php endif; ?>
                        <?php if($aAlwEventCardtype['tAutStaFull'] == 1 || ($aAlwEventCardtype['tAutStaEdit'] == 1 || $aAlwEventCardtype['tAutStaRead'] == 1))  : ?>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('payment/cardtype/cardtype','tCTYEdit'); ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aCtyDataList['rtCode'] == 1 ):?>
                        <?php foreach($aCtyDataList['raItems'] AS $nKey => $aValue) : ?>
                            <tr class="text-center xCNTextDetail2 otrCardType" id="otrCardType<?php echo $nKey; ?>" data-code="<?php echo $aValue['rtCtyCode']; ?>" data-name="<?php echo $aValue['rtCtyName']; ?>">
                                <?php if($aAlwEventCardtype['tAutStaFull'] == 1 || $aAlwEventCardtype['tAutStaDelete'] == 1) : ?>
                                <td nowrap class="text-center">
                                    <label class="fancy-checkbox">
                                        <?php if(!FCNbIsHaveCardInCardType($aValue['rtCtyCode'])) : // No have card in card ?>
                                            <input id="ocbListItem<?php echo $nKey; ?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <?php else : // have card in card type ?>
                                            <input type="checkbox" class="ocbListItem" disabled="true">
                                        <?php endif; ?>
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                                <?php endif; ?>
                                <td nowrap  class="text-left"><?php echo $aValue['rtCtyCode']; ?></td>
                                <td nowrap class="text-left"><?php echo $aValue['rtCtyName']; ?></td>
                                <td nowrap class="text-right"><?php echo number_format($aValue['rtCtyDeposit'], $tDecShow)?></td>
                             
                               <?php
                                    if($aValue['rtCtyExpiredType']=="1"){
                                       $tExpireType = language('payment/cardtype/cardtype','tCTYFrmHour');  
                                    }elseif($aValue['rtCtyExpiredType']=="2"){
                                       $tExpireType = language('payment/cardtype/cardtype','tCTYFrmDay');
                                    }elseif($aValue['rtCtyExpiredType']=="3"){
                                       $tExpireType = language('payment/cardtype/cardtype','tCTYFrmMonth');
                                    }elseif($aValue['rtCtyExpiredType']=="4"){
                                        $tExpireType = language('payment/cardtype/cardtype','tCTYFrmYear');
                                    }
                               ?>
    
                                <td nowrap class="text-left"><?php echo $aValue['rtCtyExpirePeriod']; ?>&nbsp;<?php echo $tExpireType; ?></td>


                                <?php
                                    if($aValue['rtCtyStaAlwRet']=="1"){
                                       $tStatusAlw = language('payment/cardtype/cardtype','tCTYAllow');
                                    }elseif($aValue['rtCtyStaAlwRet']=="2"){   
                                        $tStatusAlw = language('payment/cardtype/cardtype','tCTYNotAllow');
                                    }                                     
                                ?>

                                <?php 
                                    if($aValue['rtCtyStaPay'] == "1"){
                                        $tStatusPay = language('payment/cardtype/cardtype','tCTYTopupfirst');
                                    }else{
                                        $tStatusPay = language('payment/cardtype/cardtype','tCTYPayLater');
                                    }
                                ?>


                                <td nowrap  class="text-left"><?php echo $tStatusPay;?></td>
                                <td nowrap class="text-right"><?php echo number_format($aValue['rtCtyCreditLimit'], $tDecShow)?></td>
                                

                                <td nowrap class="text-left"><?php echo $tStatusAlw;?></td>
                                
                                <?php if($aAlwEventCardtype['tAutStaFull'] == 1 || $aAlwEventCardtype['tAutStaDelete'] == 1) : ?>
                                <td nowrap>
                                    <?php if(!FCNbIsHaveCardInCardType($aValue['rtCtyCode'])) : ?>
                                        <!-- No have card in card -->
                                        <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoCardTypeDel('<?php echo $nCurrentPage?>','<?php echo $aValue['rtCtyCode']?>','<?php echo $aValue['rtCtyName']?>')">
                                    <?php else : ?>
                                        <!-- Have card in card type -->
                                        <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" style="opacity: 0.2;">
                                    <?php endif; ?>
                                </td>
                                <?php endif; ?>
                                
                                <?php if($aAlwEventCardtype['tAutStaFull'] == 1 || ($aAlwEventCardtype['tAutStaEdit'] == 1 || $aAlwEventCardtype['tAutStaRead'] == 1)) : ?>
                                <td nowrap>
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageCardTypeEdit('<?php echo $aValue['rtCtyCode']?>')">
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
    <!-- เปลี่ยน -->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aCtyDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord'); ?> <?php echo language('common/main/main','tCurrentPage'); ?> <?php echo $aCtyDataList['rnCurrentPage']; ?> / <?php echo $aCtyDataList['rnAllPage']; ?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageCardType btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvCardTypeClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i = max($nPage-2, 1); $i <= max(0, min($aCtyDataList['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <button onclick="JSvCardTypeClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aCtyDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCardTypeClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDelCardType">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ohdConfirmIDDelete">
            </div>
            <div class="modal-footer">
                <button id="osmConfirm" onClick="JSoCardTypeDelChoose('<?php echo $nCurrentPage ?>')" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
                    <?php echo language('common/main/main', 'tModalConfirm') ?>
                </button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel') ?>
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
        }else{}
        
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
    })
</script>
