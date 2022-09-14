<style>
    .xWImgCustomer{
        width: 50px;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('customer/customer/customer','tCSTChoose')?></th>
                        <?php if(false) : ?><th class="xCNTextBold text-left" style="width:5%;"><?= language('customer/customer/customer','tCSTCode')?></th><?php endif; ?>
                        <th class="xCNTextBold text-center" style="width:10%;"><?= language('customer/customer/customer','tCSTImg')?></th>
                        <th class="xCNTextBold text-center" style="width:20%;"><?= language('customer/customer/customer','tCSTName')?></th>
                        <th class="xCNTextBold text-center" style="width:15%;"><?= language('customer/customer/customer','tCSTTel')?></th>
                        <th class="xCNTextBold text-center" style="width:15%;"><?= language('customer/customer/customer','tCSTEmail')?></th>
                        <th class="xCNTextBold text-center" style="width:20%;"><?= language('company/branch/branch','tCSTGroup')?></th>
                        <?php if(false) : ?><th class="xCNTextBold text-left" style="width:20%;"><?= language('company/shop/shop','tSHPTitle')?></th><?php endif; ?>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('customer/customer/customer','tCSTDelete')?></th>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('customer/customer/customer','tCSTEdit')?></th>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] as $key => $aValue){ ?>
                        <tr class="text-center xCNTextDetail2 otrCustomer" id="otrCustomer<?=$key?>" data-code="<?=$aValue['rtCstCode']?>" data-name="<?=$aValue['rtCstName']?>">
							<td class="text-center">
								<label class="fancy-checkbox">
									<input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]"><!-- onchange="JSxCSTVisibledDelAllBtn(this, event)" -->
									<span>&nbsp;</span>
								</label>
							</td>
                            <input type="hidden" class="xWCustomerCode" value="<?php echo $aValue['rtCstCode']; ?>">
                            <?php if(false) : ?><td class="text-left otdCstCode"><?php echo $aValue['rtCstCode']; ?></td><?php endif; ?>
                            <td class="text-center">
                                <?php echo  FCNtHGetImagePageList($aValue['rtImgObj'], '38px'); ?>
                            </td>
                            <td class="text-left"><?=$aValue['rtCstName']?></td>
                            <td class="text-left"><?=$aValue['rtCstTel']?></td>
                            <td class="text-left"><?=$aValue['rtCstEmail']?></td>
                            <td class="text-left"><?=$aValue['rtCgpName']?></td>
                            <?php if(false) : ?><td class="text-left"></td><?php endif; ?>
                            <td>
                                <img class="xCNIconTable xCNIconDel" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSaCSTDelete('<?php echo $aValue['rtCstCode']; ?>')">
                            </td>
                            <td>
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCSTCallPageCustomerEdit('<?=$aValue['rtCstCode']?>')">
                            </td>
                        </tr>
                    <?php } ?>
                <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='8'><?= language('common/main/main','tCMNNotFoundData')?> </td></tr>
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
        <div class="xWPageCst btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ -->
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvCSTClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
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
                <button onclick="JSvCSTClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCSTClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<script type="text/javascript">
$('ducument').ready(function(){});
</script>

<script type="text/javascript">
    $('.ocbListItem').click(function(){
        var nCode = $(this).parent().parent().parent().data('code');  //code
        var tName = $(this).parent().parent().parent().data('name');  //code
        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{ }
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"nCode": nCode, "tName": tName });
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxTextinModal();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxTextinModal();
            }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].nCode == nCode){
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata = [];
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
                JSxTextinModal();
            }
        }
        JSxShowButtonChoose();
    })
</script>
