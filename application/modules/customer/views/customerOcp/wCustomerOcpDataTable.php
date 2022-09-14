<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('customer/customerOcp/customerOcp','tCstOcpTBChoose')?></th>
                        <th class="xCNTextBold text-left" style="width:20%;"><?= language('customer/customerOcp/customerOcp','tCstOcpTBCode')?></th>
                        <th class="xCNTextBold text-left" style="width:60%;"><?= language('customer/customerOcp/customerOcp','tCstOcpTBName')?></th>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('customer/customerOcp/customerOcp','tCstOcpTBDelete')?></th>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('customer/customerOcp/customerOcp','tCstOcpTBEdit')?></th>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
                        <tr class="text-center xCNTextDetail2 otrCstOcp" id="otrCstOcp<?=$key?>" data-code="<?=$aValue['rtCstOcpCode']?>" data-name="<?=$aValue['rtCstOcpName']?>">
							<td class="text-center">
								<label class="fancy-checkbox">
									<input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" onchange="JSxCstOcpVisibledDelAllBtn(this, event)">
									<span>&nbsp;</span>
								</label>
							</td>
                            <td class="text-left otdCstOcpCode"><?=$aValue['rtCstOcpCode']?></td>
                            <td class="text-left"><?=$aValue['rtCstOcpName']?></td>
                            <td>
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSaCstOcpDelete(this, event)" title="<?php echo language('customer/customerOcp/customerOcp', 'tCstOcpTBDelete'); ?>">
                            </td>
                            <td>
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageCstOcpEdit('<?=$aValue['rtCstOcpCode']?>')" title="<?php echo language('customer/customerOcp/customerOcp', 'tCstOcpTBEdit'); ?>">
                            </td>
                        </tr>
                    <?php } ?>
                <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='6'>ไม่พบข้อมูล</td></tr>
                <?php endif;?>
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
        <div class="xWPageCstGrp btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvCstOcpClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvCstOcpClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCstOcpClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>