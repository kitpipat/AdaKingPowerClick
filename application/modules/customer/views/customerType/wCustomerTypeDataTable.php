<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('customer/customerType/customerType','tCstTypeTBChoose')?></th>
                        <th class="xCNTextBold text-center" style="width:15%;"><?= language('customer/customerType/customertype','tCstTypeTBCode')?></th>
                        <th class="xCNTextBold text-center" style="width:70%;"><?= language('customer/customerType/customerType','tCstTypeTBName')?></th>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('customer/customerType/customerType','tCstTypeTBDelete')?></th>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('customer/customerType/customerType','tCstTypeTBEdit')?></th>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
                        <tr class="text-center xCNTextDetail2 otrCstType" id="otrCstType<?=$key?>" data-code="<?=$aValue['rtCstTypeCode']?>" data-name="<?=$aValue['rtCstTypeName']?>">
							<td class="text-center">
								<label class="fancy-checkbox">
									<input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" onchange="JSxVisibledDelAllBtn(this, event)">
									<span>&nbsp;</span>
								</label>
							</td>
                            <td class="text-left otdCstTypeCode"><?=$aValue['rtCstTypeCode']?></td>
                            <td class="text-left otdCstTypeName"><?=$aValue['rtCstTypeName']?></td>
                            <td>
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSaCstTypeDelete(this, event)" title="<?php echo language('customer/customerType/customerType', 'tCstTypeTBDelete'); ?>">
                            </td>
                            <td>
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageCstTypeEdit('<?=$aValue['rtCstTypeCode']?>')" title="<?php echo language('customer/customerType/customerType', 'tCstTypeTBEdit'); ?>">
                            </td>
                        </tr>
                    <?php } ?>
                <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='6'><?= language('customer/customerType/customerType','tCstTypeSearch')?></td></tr>
                <?php endif;?>
                </tbody>
			</table>
        </div>
    </div>
</div>

<div class="row">
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?>  <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPageCstType btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ -->
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSCstTypevClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
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
                <button onclick="JSCstTypevClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSCstTypevClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<script type="text/javascript">
$('ducument').ready(function(){});
</script>
