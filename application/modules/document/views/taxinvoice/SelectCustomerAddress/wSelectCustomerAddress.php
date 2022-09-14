<style>
    .xCNClickCustomerAddress{
        cursor          : pointer;
    }

    .xCNActive{
        background-color: #179bfd !important;
        color           : #FFFFFF !important;
    }
</style>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped"  id="otbSelectCustomerAddress">
                <thead>
                    <tr class="xCNCenter">
                        <th class="xCNTextBold" style="text-align:center; width:50px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXNum')?></th>
                        <th class="xCNTextBold" style="text-align:center; width:120px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXNoCustomerName')?></th>
						<th class="xCNTextBold" style="text-align:center; width:120px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXCustomerName')?></th>
                        <th class="xCNTextBold" style="text-align:center; width:160px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXAddress1')?></th>
                        <th class="xCNTextBold" style="text-align:center; width:120px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXAddress2')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php 
                        if(FCNnHSizeOf($aDataList['raItems'])!=0){
                            foreach($aDataList['raItems'] AS $nKey => $aValue):?> 
                                <tr class="text-center xCNTextDetail2 xCNClickCustomerAddress" data-cstcode="<?=$aValue['FTCstCode'];?>" data-seqno="<?=$aValue['FNAddSeqNo'];?>">
                                    <td class="text-left"><?=$aValue['FNRowID'];?></td>
                                    <td class="text-left"><?=($aValue['FTCstName'] == '') ? '-' : $aValue['FTCstName'];?></td>
                                    <td class="text-left"><?=($aValue['FTAddName'] == '') ? '-' : $aValue['FTAddName'];?></td>
                                    <td class="text-left"><?=($aValue['FTAddV2Desc1'] == '') ? '-' : $aValue['FTAddV2Desc1'];?></td>
                                    <td class="text-left"><?=($aValue['FTAddV2Desc2'] == '') ? '-' : $aValue['FTAddV2Desc2'];?></td>
                                </tr>
                            <?php endforeach;
                        } else{ ?>
                        <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php } ?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aDataList['rnCurrentPage']?> / <?php echo $aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageCustomerAddress btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvTAXClickPageCustomerAddress('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvTAXClickPageCustomerAddress('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>

            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvTAXClickPageCustomerAddress('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<script>
    //เปลี่ยนหน้า 1 2 3 ..
    function JSvTAXClickPageCustomerAddress(ptPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var nPageCurrent = "";
            switch (ptPage) {
                case "next": //กดปุ่ม Next
                    $(".xWBtnNext").addClass("disabled");
                    nPageOld        = $(".xWPageCustomerAddress .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent    = nPageNew;
                    break;
                case "previous": //กดปุ่ม Previous
                    nPageOld        = $(".xWPageCustomerAddress .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent    = nPageNew;
                    break;
                default:
                    nPageCurrent    = ptPage;
            }
            JCNxSearchBrowseSelectAddressCustomer(nPageCurrent);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //เลือกที่อยู่
    $('.xCNClickCustomerAddress').on('click',function(e){
        $('.xCNClickCustomerAddress').removeClass('xCNActive');
        $('.xCNClickCustomerAddress').children().attr('style','color : #232C3D !important;');

        $(this).addClass('xCNActive');
        $(this).children().attr('style','color : #FFFFFF !important;');
    });

    //เลือกที่อยู่
    // $('.xCNClickCustomerAddress').off();

    //ดับเบิ้ลคลิก
    $('.xCNClickCustomerAddress').on('dblclick',function(e){
        // $('#odvTAXModalAddressMoreOne').modal('hide');
        $('.xCNClickCustomerAddress').removeClass('xCNActive');
        $('.xCNClickCustomerAddress').children().attr('style','color : #232C3D !important;');

        $(this).addClass('xCNActive');
        $(this).children().attr('style','color : #FFFFFF !important;');

        $('.xCNComfirmAddressCustomer').click();
    });


</script>