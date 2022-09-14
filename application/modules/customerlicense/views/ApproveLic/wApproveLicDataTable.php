<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('customerlicense/customerlicense/customerlicense','tAplThDate')?></th>
                        <th class="xCNTextBold text-left" style="width:20%;"><?= language('customerlicense/customerlicense/customerlicense','tAplThDocNo')?></th>
                        <th class="xCNTextBold text-left" style="width:20%;"><?= language('customerlicense/customerlicense/customerlicense','tAplThBchName')?></th>
                        <th class="xCNTextBold text-left" style="width:10%;"><?= language('customerlicense/customerlicense/customerlicense','tAplThCstName')?></th>
                        <th class="xCNTextBold text-left" style="width:10%;"><?= language('customerlicense/customerlicense/customerlicense','tAplThStatus')?></th>
                        <th class="xCNTextBold text-right" style="width:10%;"><?= language('customerlicense/customerlicense/customerlicense','tAplThDiscount')?></th>
                        <th class="xCNTextBold text-right" style="width:10%;"><?= language('customerlicense/customerlicense/customerlicense','tAplThGrand')?></th>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('customerlicense/customerlicense/customerlicense','tCBLEdit')?></th>
                    </tr>
                </thead>
                <tbody id="">
                        <?php
                            if(!empty($aDataList['raItems'])){
                                foreach($aDataList['raItems'] as $nKey => $aData){
                        ?>
                        <tr class="text-center xCNTextDetail2 otrCustomer" >
              
                            <td class="text-left"><?=date('d/m/Y',strtotime($aData['FDXshDocDate']))?></td>
                            <td class="text-left"><?=$aData['FTXshDocNo']?></td>
                            <td class="text-left"><?=$aData['FTBchCode']?></td>
                            <td class="text-left"><?=$aData['FTCstName']?></td>
                            <td class="text-left"><?php
                            if(!empty($aData['FTXshStaPaid'])){
                            echo  language('customerlicense/customerlicense/customerlicense','tAplThStatus'.$aData['FTXshStaPaid']);
                            }
                            ?></td>
                            <td class="text-right"><?=number_format($aData['FCXddValue'],$nDecimalShow)?></td>
                            <td class="text-right"><?=number_format($aData['FCXshGrand'],$nDecimalShow)?></td>
                            <td>
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvAPVCallPageApproveLicEdit('<?=$aData['FTXshDocNo']?>')">
                            </td>
                        </tr>
               
                        <?php 
                                }
                            }else{ ?>
                            <tr><td class='text-center xCNTextDetail2' colspan='12'><?= language('common/main/main','tCMNNotFoundData')?> </td></tr>
                      <?php } ?>
                </tbody>
			</table>
        </div>
    </div>
</div>

<div class="row">
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <p>พบข้อมูลทั้งหมด <?=$aDataList['rnAllRow']?> รายการ แสดงหน้า <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPageCstBch btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvAPVClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvAPVClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvAPVClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>