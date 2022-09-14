<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="xCNTextBold text-center" style="width:10%;"><?= language('customer/customerLevel/customerLevel','tCstLevTBChoose')?></th>
                        <th class="xCNTextBold text-center" style="width:30%;"><?= language('customer/customerLevel/customerLevel','tCstLevTBCode')?></th>
                        <th class="xCNTextBold text-center" style="width:30%;"><?= language('customer/customerLevel/customerLevel','tCstLevTBName')?></th>
                        <th class="xCNTextBold text-center" style="width:10%;"><?= language('customer/customerLevel/customerLevel','tCstLevTBDelete')?></th>
                        <th class="xCNTextBold text-center" style="width:10%;"><?= language('customer/customerLevel/customerLevel','tCstLevTBEdit')?></th>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
                        <tr class="text-center xCNTextDetail2 otrCstLev" id="otrCstLev<?=$key?>" data-code="<?=$aValue['rtCstLevCode']?>" data-name="<?=$aValue['rtCstLevName']?>">
							<td class="text-center">
								<label class="fancy-checkbox">
									<input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" onchange="JSxCstLevVisibledDelAllBtn(this, event)">
									<span>&nbsp;</span>
								</label>
							</td>
                            <td class="text-left otdCstLevCode"><?=$aValue['rtCstLevCode']?></td>
                            <td class="text-left otdCstLevName"><?=$aValue['rtCstLevName']?></td>
                            <td>
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSaCstLevDelete(this, event)" title="<?php echo language('customer/customerLevel/customerLevel', 'tCstLevTBDelete'); ?>">
                            </td>
                            <td>
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageCstLevEdit('<?=$aValue['rtCstLevCode']?>')" title="<?php echo language('customer/customerLevel/customerLevel', 'tCstLevTBEdit'); ?>">
                            </td>
                        </tr>
                    <?php } ?>
                <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='6'><?= language('customer/customerLevel/customerLevel','tCstLevSearch')?></td></tr>
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
        <div class="pagination btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ -->
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvCstLevClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
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
                <button onclick="JSvCstLevClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCstLevClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<script type="text/javascript">
$('ducument').ready(function(){});
</script>
