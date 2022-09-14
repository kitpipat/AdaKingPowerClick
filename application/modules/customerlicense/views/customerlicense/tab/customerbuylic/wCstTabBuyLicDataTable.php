<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="xCNTextBold text-center" style="width:2%;"><?= language('customerlicense/customerlicense/customerlicense','tCSTChoose')?></th>
                        <th class="xCNTextBold text-left" style="width:10%;"><?= language('customerlicense/customerlicense/customerlicense','tCLBCstBchCode')?></th>
                        <th class="xCNTextBold text-left" style="width:10%;"><?= language('customerlicense/customerlicense/customerlicense','tCLBCstPosCode')?></th>
                        <th class="xCNTextBold text-left" style="width:9%;"><?= language('customerlicense/customerlicense/customerlicense','tCBLPdtCode')?></th>
                        <th class="xCNTextBold text-left" style="width:15%;"><?= language('customerlicense/customerlicense/customerlicense','tCBLPdtName')?></th>
                        <th class="xCNTextBold text-left" style="width:10%;"><?= language('customerlicense/customerlicense/customerlicense','tCBLPdtType')?></th>
                        <th class="xCNTextBold text-left" style="width:10%;"><?= language('customerlicense/customerlicense/customerlicense','tCBLTLiveTime')?></th>
                        <th class="xCNTextBold text-left" style="width:15%;"><?= language('customerlicense/customerlicense/customerlicense','tCBLSaleDocNo')?></th>
                        <th class="xCNTextBold text-left" style="width:10%;"><?= language('customerlicense/customerlicense/customerlicense','tCBLStratDate')?></th>
                        <th class="xCNTextBold text-left" style="width:10%;"><?= language('customerlicense/customerlicense/customerlicense','tCBLEndDate')?></th>
                        <th class="xCNTextBold text-left" style="width:10%;"><?= language('customerlicense/customerlicense/customerlicense','tCBLUUID')?></th>
                        <th class="xCNTextBold text-left" style="width:6%;"><?= language('customerlicense/customerlicense/customerlicense','tCBLStatus')?></th>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('customerlicense/customerlicense/customerlicense','tCBLEdit')?></th>
                    </tr>
                </thead>
                <tbody id="">
                        <?php
                            if(!empty($aDataList['raItems'])){
                                foreach($aDataList['raItems'] as $nKey => $aData){
                        ?>
                        <tr class="text-center xCNTextDetail2 otrCustomer" >
                            <td class="text-center">
                            <label class="fancy-checkbox">
									<input id="ocbListItem<?=$nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" value="<?=$aData['rtCstCode']?>" data-refbch="<?=$aData['rtCbrRefBch']?>" data-uuidseq="<?=$aData['rnLicUUIDSeq']?>" data-license="<?=$aData['rtLicPdtCode']?>">
									<span>&nbsp;</span>
								</label>
                            </td>
                            <td class="text-left"><?=$aData['rtCbrRefBch']?></td>
                            <td class="text-left"><?=$aData['rtCbrRefPos']?></td>
                            <td class="text-left"><?=$aData['rtLicPdtCode']?></td>
                            <td class="text-left"><?=$aData['rtPdtName']?></td>
                            <td class="text-left"><?=$aData['rtPtyName']?></td>
                            <td class="text-left"><?=$aData['rnMonth']?> <?= language('customerlicense/customerlicense/customerlicense','tCBLMonth')?></td>
                            <td class="text-left"><?=$aData['rtLicRefSaleDoc']?></td>
                            <td class="text-left"><?=date_format(date_create($aData['rdLicStart']),'d/m/Y')?></td>
                            <td class="text-left"><?=date_format(date_create($aData['rdLicFinish']),'d/m/Y')?></td>
                            <td class="text-left"><?=$aData['rtLicRefUUID']?></td>
                            <td class="text-left">
                                <?php
                                            if($aData['rtLicStaUse']=='1'){
                                                if($aData['rdLicFinish']<date('Y-m-d')){
                                                    echo '<span  style="color:red">'.language('customerlicense/customerlicense/customerlicense','tCBLStatusExp').'</span>';
                                                }else{
                                                    echo '<span  style="color:green">'.language('customerlicense/customerlicense/customerlicense','tCBLStatus1').'</span>';
                                                }
                                            }else{
                                                echo '<span  style="color:red">'.language('customerlicense/customerlicense/customerlicense','tCBLStatus2').'</span>';
                                            }
                                ?>
                            </td>
                            <td>
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCBLCallPageCustomerBuyLicEdit('<?=$aData['rtCbrRefBch']?>','<?=$aData['rnLicUUIDSeq']?>','<?=$aData['rtLicPdtCode']?>')">
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
            <button onclick="JSvCBLClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvCBLClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCBLClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>


<script>
function JSfAPLRegExportJson(){

var aOjcChcked = [];
    $(".ocbListItem:checked").map(function(index){
        aOjcChcked[index] =  {
                        'tCstCode':$(this).val() , 
                        'tRefBch':$(this).data('refbch'), 
                        'nUidseq':$(this).data('uuidseq'),
                        'tLicense':$(this).data('license') 
                       }
    }).get(); // <----
    console.log(aOjcChcked);

    var tCstCode = $('#oetCstCode').val();

    $.ajax({
          type: "POST",
          url: "customerBuyEventExportJson",
          cache: false,
          timeout: 0,
          data:{ aOjcChcked:aOjcChcked , tCstCode:tCstCode},
          success: function(tResult) {
                 var oBlob=new Blob([tResult]);
                    var oLink=document.createElement('a');
                    oLink.href=window.URL.createObjectURL(oBlob);
                    oLink.download=tCstCode+"License.json";
                    oLink.click();
          },
          error: function(jqXHR, textStatus, errorThrown) {
              JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
          }
      });
}
</script>