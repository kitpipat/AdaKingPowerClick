<style>
    .xCNClickTaxno{
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
            <table class="table table-striped"  id="otbSelectTaxno">
                <thead>
                    <tr class="xCNCenter">
                        <th class="xCNTextBold" style="text-align:center; width:50px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXNum')?></th>
                        <th class="xCNTextBold" style="text-align:center; width:120px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXNumber')?></th>
						<th class="xCNTextBold" style="text-align:center; width:120px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXCustomerName')?></th>
                        <th class="xCNTextBold" style="text-align:center; width:160px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXAddress1')?></th>
                        <th class="xCNTextBold" style="text-align:center; width:120px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXAddress2')?></th>
                        <th class="xCNTextBold" style="text-align:center; width:80px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXTelphone')?></th>
                        <th class="xCNTextBold" style="text-align:center; width:80px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXFax')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php 
                        if(FCNnHSizeOf($aDataList['raItems'])!=0){
                            foreach($aDataList['raItems'] AS $nKey => $aValue):?> 
                                <tr class="text-center xCNTextDetail2 xCNClickTaxno" data-taxno="<?=$aValue['FTAddTaxNo'];?>"> <!-- data-seqno="<?=$aValue['FNAddSeqNo'];?>" -->
                                    <td class="text-left"><?=$aValue['FNRowID'];?></td>
                                    <td class="text-left"><?=($aValue['FTAddTaxNo'] == '') ? '-' : $aValue['FTAddTaxNo'];?></td>
                                    <td class="text-left"><?=($aValue['FTAddName'] == '') ? '-' : $aValue['FTAddName'];?></td>
                                    <td class="text-left"><?=($aValue['FTAddV2Desc1'] == '') ? '-' : $aValue['FTAddV2Desc1'];?></td>
                                    <td class="text-left"><?=($aValue['FTAddV2Desc2'] == '') ? '-' : $aValue['FTAddV2Desc2'];?></td>
                                    <td class="text-left"><?=($aValue['FTAddTel'] == '') ? '-' : $aValue['FTAddTel'];?></td>
                                    <td class="text-left"><?=($aValue['FTAddFax'] == '') ? '-' : $aValue['FTAddFax'];?></td>
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
        <div class="xWPageTAXno btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvTAXClickPageTaxno('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvTAXClickPageTaxno('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>

            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvTAXClickPageTaxno('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<script>
    //เปลี่ยนหน้า 1 2 3 ..
    function JSvTAXClickPageTaxno(ptPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var nPageCurrent = "";
            switch (ptPage) {
                case "next": //กดปุ่ม Next
                    $(".xWBtnNext").addClass("disabled");
                    nPageOld        = $(".xWPageTAXno .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent    = nPageNew;
                    break;
                case "previous": //กดปุ่ม Previous
                    nPageOld        = $(".xWPageTAXno .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent    = nPageNew;
                    break;
                default:
                    nPageCurrent    = ptPage;
            }
            JCNxSearchBrowseTaxno(nPageCurrent);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //กดเลือกรหัส ABB
    $('.xCNClickTaxno').on('click',function(e){
        $('.xCNClickTaxno').removeClass('xCNActive');
        $('.xCNClickTaxno').children().attr('style','color : #232C3D !important;');

        $(this).addClass('xCNActive');
        $(this).children().attr('style','color : #FFFFFF !important;');
    });

     //กดเลือกรหัส
    //  $('.xCNClickTaxno').off();

    //ดับเบิ้ลคลิก
    $('.xCNClickTaxno').on('dblclick',function(e){
        // $('#odvTAXModalAddressMoreOne').modal('hide');
        $('.xCNClickTaxno').removeClass('xCNActive');
        $('.xCNClickTaxno').children().attr('style','color : #232C3D !important;');

        $(this).addClass('xCNActive');
        $(this).children().attr('style','color : #FFFFFF !important;');

        $('.xCNConfirmTaxno').click();
    });


</script>