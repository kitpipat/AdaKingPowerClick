<style>
    .xCNClickABB{
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
            <table class="table table-striped"  id="otbSelectABB">
                <thead>
                    <tr class="xCNCenter">
                        <th class="xCNTextBold"><?=language('document/taxinvoice/taxinvoice','tTAXNum')?></th>
						<th class="xCNTextBold"><?=language('document/taxinvoice/taxinvoice','tTAXBusiness2')?></th>
                        <th class="xCNTextBold"><?=language('document/taxinvoice/taxinvoice','tTAXABB')?></th>
                        <th class="xCNTextBold"><?=language('document/taxinvoice/taxinvoice','tTAXRefExt')?></th>
                        <th class="xCNTextBold"><?=language('document/taxinvoice/taxinvoice','tTAXDocumentType')?></th>
                        <th class="xCNTextBold"><?=language('document/taxinvoice/taxinvoice','tTAXDocumentDate')?></th>
                        <th class="xCNTextBold"><?=language('document/taxinvoice/taxinvoice','tTAXDocumentPOS')?></th>
                        <th class="xCNTextBold"><?=language('document/taxinvoice/taxinvoice','tTAXCustomer')?></th>
                        <th class="xCNTextBold"><?=language('document/taxinvoice/taxinvoice','tTAXDocumentTotal')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php 
                        if(FCNnHSizeOf($aDataList['raItems'])!=0){
                            foreach($aDataList['raItems'] AS $nKey => $aValue):?>
                                <tr class="text-center xCNTextDetail2 xCNClickABB" data-documentabb="<?=$aValue['FTXshDocNo'];?>" data-customer="<?=$aValue['FTCstCode'];?>" data-customername="<?=$aValue['FTCstName'];?>" >
                                    <td class="text-center"><?=$aValue['FNRowID'];?></td>
                                    <td class="text-left"><?=$aValue['FTBchName'];?></td>
                                    <td class="text-left"><?=$aValue['FTXshDocNo'];?></td>
                                    <td class="text-left"><?=$aValue['FTXshRefExt'];?></td>
                                    <?php   if($aValue['FNXshDocType'] == 1){
                                                $tDocType = language('document/taxinvoice/taxinvoice','tTAXDocumentType1');
                                            }else if($aValue['FNXshDocType'] == 9){
                                                $tDocType = language('document/taxinvoice/taxinvoice','tTAXDocumentType9');
                                            }else{
                                                $tDocType = 'N/A';
                                            }?>
                                    <td class="text-left"><?=$tDocType;?></td>
                                    <td class="text-left"><?=$aValue['FDXshDocDate'];?></td>
                                    <td class="text-left"><?=$aValue['FTPosCode'];?></td>
                                    <td class="text-left"><?=($aValue['FTCstCode'] == '' ) ? '-' : $aValue['FTCstCode'];?></td>
                                    <td class="text-right"><?=$aValue['FCXshGrand'];?></td>
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
        <div class="xWPageTAXABB btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvTAXClickPageABB('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvTAXClickPageABB('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>

            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvTAXClickPageABB('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<script>
    //เปลี่ยนหน้า 1 2 3 ..
    function JSvTAXClickPageABB(ptPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var nPageCurrent = "";
            switch (ptPage) {
                case "next": //กดปุ่ม Next
                    $(".xWBtnNext").addClass("disabled");
                    nPageOld        = $(".xWPageTAXABB .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent    = nPageNew;
                    break;
                case "previous": //กดปุ่ม Previous
                    nPageOld        = $(".xWPageTAXABB .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent    = nPageNew;
                    break;
                default:
                    nPageCurrent    = ptPage;
            }
            JCNxSearchBrowseABB(nPageCurrent);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //กดเลือกรหัส ABB
    $('.xCNClickABB').on('click',function(e){
        $('.xCNClickABB').removeClass('xCNActive');
        $('.xCNClickABB').children().attr('style','color : #232C3D !important;');

        $(this).addClass('xCNActive');
        $(this).children().attr('style','color : #FFFFFF !important;');
    });

    //กดเลือกรหัส
    // $('.xCNClickABB').off();

    //ดับเบิ้ลคลิก
    $('.xCNClickABB').on('dblclick',function(e){
        // $('#odvTAXModalAddressMoreOne').modal('hide');
        $('.xCNClickABB').removeClass('xCNActive');
        $('.xCNClickABB').children().attr('style','color : #232C3D !important;');

        $(this).addClass('xCNActive');
        $(this).children().attr('style','color : #FFFFFF !important;');

        $('.xCNConfrimABB').click();
    });


</script>