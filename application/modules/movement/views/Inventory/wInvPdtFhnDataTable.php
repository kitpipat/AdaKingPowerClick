<?php 
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>

<div class="">
    <div class="col-md-12">
        <!-- <input type="hidden" id="nCurrentPageTB" value="<?=$nCurrentPage;?>"> -->
        <div class="table-responsive">
             <table class="table table" style="width:100%">
					<thead>
						<tr style="background-color: #e8e3e3cc;">
                           <th nowrap class="xCNTextBold" style="width:7%;text-align:left;"><?= language('product/product/product', 'tFhnPdtDataTableRefCode')?></th>
							<th nowrap class="xCNTextBold" style="width:7%;text-align:left;border-left: hidden !important;"><?= language('product/product/product','tFhnPdtDataTableSeason')?></th>
                            <th nowrap class="xCNTextBold" style="width:7%;text-align:left;border-left: hidden !important;"><?= language('product/product/product','tFhnPdtDataTableColor')?></th>
                            <th nowrap class="xCNTextBold" style="width:7%;text-align:left;"><?= language('product/product/product','tFhnPdtDataTableSize')?></th>
                            <th nowrap class="xCNTextBold" style="width:7%;text-align:left;border-left: hidden !important;" colspan ="3"><?= language('product/product/product','tFhnPdtDataTableFabric')?></th>
                        </tr>
                        <tr style="background-color: #e8e3e3cc;">
							<th nowrap class="xCNTextBold" style="width:7%;text-align:left;padding-left: 60px !important;" colspan ="3"><?= language('movement/movement/movement','tMMTListBanch')?></th>
                            <th nowrap class="xCNTextBold" style="width:5%;text-align:left;"><?= language('movement/movement/movement','tINVInventoryWarehouse')?></th>
                            <th nowrap class="xCNTextBold" style="width:5%;text-align:right;border-left: hidden !important;"><?= language('movement/movement/movement','tINVInventoryAmount')?></th>
                            <th nowrap class="xCNTextBold" style="width:5%;text-align:right;border-left: hidden !important;"><?= language('movement/movement/movement','tINVInventoryTemporaryWarehouse')?></th>
                            <th nowrap class="xCNTextBold" style="width:5%;text-align:right;border-left: hidden !important;"><?= language('movement/movement/movement','tINVInventoryTotal')?></th>
                        </tr>
					</thead>
					<tbody id="">
                        <?php  if($aDataList['rtCode'] == 1 ):?>
                            <?php foreach($aDataList['raItems'] AS $key=>$aValue){ 
                                    if($aValue['RowNumber']==1){ 
                                            if(!empty($aDataPdtFhnByRefCode[$aValue['FTFhnRefCode']])){
                                                foreach($aDataPdtFhnByRefCode[$aValue['FTFhnRefCode']] as $nKey => $aDataColSiz){

                                                    if(($nKey+1) == FCNnHSizeOf($aDataPdtFhnByRefCode[$aValue['FTFhnRefCode']])){
                                                        $tClassLineBottom = '';
                                                    }else{
                                                        $tClassLineBottom = 'border-bottom: hidden !important;';
                                                    }
                                        ?>
                                <tr class="xCNTextDetail2 otrReason" >
                                    <td nowrap class="text-left" style="<?=$tClassLineBottom?>" ><?=$aDataColSiz['FTFhnRefCode']?></td>
                                    <td nowrap class="text-left" style="<?=$tClassLineBottom?>border-left: hidden !important;"><?=$aDataColSiz['FTSeaName']?></td>
                                    <td nowrap class="text-left" style="<?=$tClassLineBottom?>border-left: hidden !important;"><?=$aDataColSiz['FTClrName']?></td>
                                    <td nowrap class="text-left" style="<?=$tClassLineBottom?>"><?=$aDataColSiz['FTPszName']?></td>
                                    <td nowrap class="text-left" style="<?=$tClassLineBottom?>border-left: hidden !important;" colspan ="3"><?=$aDataColSiz['FTFabName']?></td>
                                </tr>
                                <?php    
                                                }
                                     }
                                }
                                ?>
                                <?php  

                    
                                 if($aValue['RowNumberByBch']==1){  
                                     
                                        $tSubTableBchName = !empty($aValue['FTBchName']) ? $aValue['FTBchName']: '';
                                  }else{
                                      
                                        $tSubTableBchName = '';
                                  }

                                  if($aValue['LastBchRowID']==$aValue['RowNumber']){ 
                                    $tClassHideLine = '';
                                  }else{
                                    $tClassHideLine = 'border-bottom: hidden !important;';
                                  }
                                //   if($aValue['rtRowID']==count($aDataList['raItems'])){
                                //        $tClassHideLine = '';
                                //   }
                                    ?>
                                <tr class="xCNTextDetail2 otrReason"  >
                                    <td nowrap class="text-left" style="<?=$tClassHideLine?>padding-left: 60px !important;" colspan ="3"><?= $tSubTableBchName; ?></td>
                                    <td nowrap class="text-left" style="<?=$tClassHideLine?>"><?=$aValue['FTWahName']?></td>
                                    <td nowrap class="text-right" style="border-left: hidden !important;<?=$tClassHideLine?>"><?php echo number_format($aValue['FCStfBal'], $nOptDecimalShow);?></td>
                                    <td nowrap class="text-right" style="border-left: hidden !important;<?=$tClassHideLine?>"><?php echo number_format($aValue['FCXtdQtyInt'], $nOptDecimalShow);?></td>
                                    <td nowrap class="text-right" style="border-left: hidden !important;<?=$tClassHideLine?>"><?php echo number_format($aValue['FCXtdQtyBal'], $nOptDecimalShow);?></td>
                                </tr>

                                <?php 

                                    if($aValue['LastBchRowID']==$aValue['RowNumber']){ ?>
                                        <tr style="background-color:#e8e3e3cc;" class="xCNTextDetail2 otrReason"  >
                                        <td nowrap class="text-left" style="border-top: 1px solid #dee2e6 !important;border-bottom: 1px solid #dee2e6 !important" colspan="3"><b><?=language('movement/movement/movement','tINVInventoryTotal')?></b></td>
                                        <td nowrap class="text-right" style="border-top: 1px solid #dee2e6 !important;border-bottom: 1px solid #dee2e6 !important"  colspan="2"><b><?php echo number_format($aValue['SumQtyBal'], $nOptDecimalShow);?></td>
                                        <td nowrap class="text-right" style="border-left: hidden !important;border-top: 1px solid #dee2e6 !important;border-bottom: 1px solid #dee2e6 !important"><b><?php echo number_format($aValue['SumStBalIntPdt'], $nOptDecimalShow);?></b></td>
                                        <td nowrap class="text-right" style="border-left: hidden !important;border-top: 1px solid #dee2e6 !important;border-bottom: 1px solid #dee2e6 !important"><b><?php echo number_format($aValue['SumQtyPdtBal'], $nOptDecimalShow);?></b></td>
                                    </tr>
                                 <?php   }
                                    ?>

                            <?php 
                          
                               } ?>
                        <?php else:?>
                            <tr><td class='text-center xCNTextDetail2' colspan='12' style="text-align: center;"><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                        <?php endif;?>
					</tbody>
			</table>
        </div>
    </div>
</div>

<div class="row" style="margin-bottom:10px;">
<div class="col-md-12">
	<!-- เปลี่ยน -->
	<div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
	<!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPageFhnPdt btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button id="obtInvFristPage" data-ngotopage="1"  onclick="JSvInvFhnPdtClickPage(1)" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i><i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <button id="obtInvPreviousPage" data-ngotopage="<?=$nCurrentPage - 1;?>"  onclick="JSvInvFhnPdtClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ --> 
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
                <button id="obtInvPageNumber<?php echo $i?>" data-npagenumber="<?php echo $i?>" onclick="JSvInvFhnPdtClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button id="obtInvNextPage"  data-ngotopage="<?=$nCurrentPage + 1;?>" onclick="JSvInvFhnPdtClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
            <button id="obtInvLastPage"  data-ngotopage="<?=$aDataList['rnAllPage']?>" onclick="JSvInvFhnPdtClickPage(<?=$aDataList['rnAllPage']?>)" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i><i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
</div>