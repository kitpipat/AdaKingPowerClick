<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <!-- <th class="xCNTextBold text-center" style="width:5%;"><?= language('customer/customer/customer','tCSTChoose')?></th> -->
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('customerlicense/customerlicense/customerlicense','tCBLSeq')?></th>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('customerlicense/customerlicense/customerlicense','tAPCRegDate')?></th>
                        <th class="xCNTextBold text-left" style="width:9%;"><?= language('customerlicense/customerlicense/customerlicense','tAPCRegBusName')?></th>
                        <th class="xCNTextBold text-left" style="width:6%;"><?= language('customerlicense/customerlicense/customerlicense','tAPCRegQtyBch')?></th>
                        <th class="xCNTextBold text-left" style="width:10%;"><?= language('customerlicense/customerlicense/customerlicense','tAPCRegLicGroup')?></th>
                        <th class="xCNTextBold text-left" style="width:15%;"><?= language('customerlicense/customerlicense/customerlicense','tAPCRegLicType')?></th>
                        <th class="xCNTextBold text-left" style="width:15%;"><?= language('customerlicense/customerlicense/customerlicense','tAPCRegBusType')?></th>
                        <th class="xCNTextBold text-left" style="width:8%;"><?= language('customerlicense/customerlicense/customerlicense','tAPCRegStaActive')?></th>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('customerlicense/customerlicense/customerlicense','tCBLEdit')?></th>
                    </tr>
                </thead>
                <tbody id="">
                        <?php
                            if(!empty($aDataList['raItems'])){
                                foreach($aDataList['raItems'] as $nKey => $aData){
                        ?>
                        <tr class="text-center xCNTextDetail2 otrCustomer" >
                            <td class="text-center"><?=($nKey+1)?></td>
                  
                            <td class="text-left"><?=date('d/m/Y',strtotime($aData['FDCreateOn']))?></td>
                            <td class="text-left"><?=$aData['FTRegBusName']?></td>
                            <td class="text-right"><?=$aData['FNRegQtyBch']?></td>
                            <td class="text-left"><?php
                            if(!empty($aData['FTRegLicGroup'])){
                            echo  language('customerlicense/customerlicense/customerlicense','tAPCRegLicGroup'.$aData['FTRegLicGroup']);
                            }
                            ?></td>
                            <td class="text-left"><?=language('customerlicense/customerlicense/customerlicense','tAPCRegLicType'.$aData['FTRegLicType'])?></td>
                            <td class="text-left"><?=$aData['FTRegBusOth']?></td>
                            <td class="text-left">
                                <?php
                                if($aData['FTRegStaActive']=='1'){
                                    echo '<span  style="color:green">'.language('customerlicense/customerlicense/customerlicense','tRegStaActive1').'</span>';
                                }else{
                                    echo '<span  style="color:red">'.language('customerlicense/customerlicense/customerlicense','tRegStaActive2').'</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvAPVCallPageApproveCstEdit(<?=$aData['FNRegID']?>)">
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