<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th class="xCNTextBold text-center" style="width:5%;"><?=language('customer/HisBuyLicense/HisBuyLicense','tHisTBNumber')?></th>
                        <th class="xCNTextBold text-center" style="width:10%;"><?=language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocument')?></th>
                        <th class="xCNTextBold text-center" style="width:10%;"><?=language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentDate')?></th>
                        <th class="xCNTextBold text-center" style="width:10%;"><?=language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentType')?></th>
                        <th class="xCNTextBold text-center" style="width:10%;"><?=language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentStatusPayment')?></th>
                        <th class="xCNTextBold text-center" ><?=language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentCustomerName')?></th>
                        <th class="xCNTextBold text-center" style="width:8%;"><?=language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentTotal')?></th>
                        <th class="xCNTextBold text-center" style="width:8%;"><?=language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentDiscount')?></th>
                        <th class="xCNTextBold text-center" style="width:8%;"><?=language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentVat')?></th>
                        <th class="xCNTextBold text-center" style="width:8%;"><?=language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentGrand')?></th>
                        <th class="xCNTextBold text-center" style="width:5%;"><?=language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentPreview')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aDataList['rtCode'] == 1 ):?>
                        <?php foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
                            <tr>
                                <td class="text-center"><?=$aValue['rtRowID']?></td>
                                <td class="text-left"><?=$aValue['FTXshDocNo']?></td>
                                <td class="text-center"><?=$aValue['FDXshDocDate']?></td>

                                <?php   
                                    //ประเภทเอกสาร	
                                    if($aValue['FNXshDocType'] == 1){
                                        $tStaType = language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentTypeSell');
                                    }else{
                                        $tStaType = language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentTypeReturn');
                                    }
                                ?>

                                <?php 
                                    //สถานะชำระเงิน		
                                    if($aValue['FTXshStaPaid'] == 1){
                                        $tClassPaid         = 'text-danger';
                                        $tTextStaPaid       = language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentStatusPaymentFail');
                                    }else if($aValue['FTXshStaPaid'] == 2){
                                        $tClassPaid         = 'text-warning';
                                        $tTextStaPaid       = language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentStatusPaymentSome');
                                    }else{
                                        $tClassPaid         = 'text-success';
                                        $tTextStaPaid       = language('customer/HisBuyLicense/HisBuyLicense','tHisTBDocumentStatusPaymentSuccess');
                                    }
                                ?>

                                <td class="text-left"><?=$tStaType?></td>
                                <td class="text-left"><label class="<?= $tClassPaid;?>"><?=$tTextStaPaid?></label></td>
                                <td class="text-left"><?=($aValue['FTCstName'] == '' ) ? '-' : $aValue['FTCstName']?></td>
                                <td class="text-right"><?=number_format($aValue['FCXshTotal'],2)?></td>
                                <td class="text-right"><?=number_format($aValue['FCXshDis'],2)?></td>
                                <td class="text-right"><?=number_format($aValue['FCXshVat'],2)?></td>
                                <td class="text-right"><?=number_format($aValue['FCXshGrand'],2)?></td>
                                <td class="text-center"><img class="xCNIconTable" onClick="JSvCallPageHisBuyPreview('<?=$aValue['FTXshDocNo']?>')" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/view2.png'?>" ></td>
                            </tr>
                        <?php } ?>
                        <!--แสดงผลรวมหน้าสุดท้าย-->
                        <?php if($aDataList['rnCurrentPage'] == $aDataList['rnAllPage']){ ?>
                            <tr>
                                <td colspan="8"></td>
                                <td class="text-right" style="font-weight: bold;">รวมทั้งสิ้น</td>
                                <td class="text-right" style="font-weight: bold;"><?=number_format($aDataSumFooter[0]->Sumtotal,2)?></td>
                                <td></td>
                            </tr>
                        <?php } ?> 
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='99'><?= language('common/main/main','tMainRptNotFoundDataInDB')?></td></tr>
                    <?php endif;?>
                </tbody>
			</table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?>  <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPageBuyLicense btn-toolbar pull-right"> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSxHisBuyClickPage('Fisrt','1')" class="btn btn-white btn-sm xCNBtnPagenation" <?=$tDisabledLeft ?> style="padding: 5px 10px;">
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i><i class="fa fa-chevron-left f-s-14 t-plus-1" style="margin-left: -3px;"></i>
            </button>
            <button onclick="JSxHisBuyClickPage('previous','')" class="btn btn-white btn-sm" <?=$tDisabledLeft ?>> 
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
                <button onclick="JSxHisBuyClickPage('number','<?=$i?>')" type="button" class="btn xCNBTNNumPagenation <?=$tActive ?>" <?=$tDisPageNumber ?>><?=$i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSxHisBuyClickPage('next','')" class="btn btn-white btn-sm" <?=$tDisabledRight ?>> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
            <button onclick="JSxHisBuyClickPage('Last','<?=$aDataList['rnAllPage']?>')" class="btn btn-white btn-sm xCNBtnPagenation" <?=$tDisabledRight ?> style="padding: 5px 10px;">
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i><i class="fa fa-chevron-right f-s-14 t-plus-1" style="margin-left: -3px;"></i>
            </button>
        </div>
    </div>
</div>
