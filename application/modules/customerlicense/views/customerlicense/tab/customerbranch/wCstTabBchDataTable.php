<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="xCNTextBold text-center" style="width:10%;"><?= language('customerlicense/customerlicense/customerlicense','tCLBCstSeq')?></th>
                        <th class="xCNTextBold text-left" style="width:15%;"><?= language('customerlicense/customerlicense/customerlicense','tCLBCstBchCode')?></th>
                        <th class="xCNTextBold text-left" style="width:30%;"><?= language('customerlicense/customerlicense/customerlicense','tCLBCstBchName')?></th>
                        <th class="xCNTextBold text-left" style="width:20%;"><?= language('customerlicense/customerlicense/customerlicense','tCLBCstBcServer')?></th>
                        <th class="xCNTextBold text-left" style="width:20%;"><?= language('customerlicense/customerlicense/customerlicense','tCLBCbrQtyPos')?></th>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('customerlicense/customerlicense/customerlicense','tCSTEdit')?></th>
                        <th class="xCNTextBold text-center" style="width:5%;"><?= language('customerlicense/customerlicense/customerlicense','tCSTDelete')?></th>
                    </tr>
                </thead>
                <tbody id="">
                        <?php
                            if(!empty($aDataList['raItems'])){
                                foreach($aDataList['raItems'] as $nKey => $aData){
                        ?>
                        <tr class="text-center xCNTextDetail2 otrCustomer" >
                            <td class="text-center"><?//$aData['rnCbrSeq']?><?=($nKey+1)?></td>
                            <td class="text-left"><?=$aData['rtCbrRefBch']?></td>
                            <td class="text-left"><?=$aData['rtCbrRefBchName']?></td>
                            <td class="text-left"><?=$aData['rtSrvName']?></td>
                            <td class="text-left"><?=$aData['rnCbrQtyPos']?></td>
                            <td>
                                <img class="xCNIconTable xCNIconDel" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSaCLBDelete(<?=$aData['rnCbrSeq']?>)">
                            </td>
                            <td>
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCLBCallPageCustomerBranchEdit(<?=$aData['rnCbrSeq']?>)">
                            </td>
                        </tr>
               
                        <?php 
                                }
                            }else{ ?>
                            <tr><td class='text-center xCNTextDetail2' colspan='7'><?= language('common/main/main','tCMNNotFoundData')?> </td></tr>
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
            <button onclick="JSvCLBClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvCLBClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCLBClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<script>

/**
 * Functionality : Delete one select
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 18/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSaCLBDelete(pnCbrSeq){
    try{
   
        $('#ohdConfirmIDDeleteCstBch').val(pnCbrSeq);
        $('#ospConfirmDeleteCstBch').text($('#oetTextComfirmDeleteSingle').val() + " " + pnCbrSeq);
        $('#odvModalDelCustomerBranch').modal('show');

    
    }catch(err){
        console.log('JSaCLNDelete Error: ', err);
    }
}


/**
 * Functionality : Delete one select
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 18/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSaCLBCstBchDelete(){

    var oDataCstBch = {
        rtCstCode : $('#oetCstCode').val(),
        rnCbrSeq :$('#ohdConfirmIDDeleteCstBch').val()
    }

    $.ajax({
          type: "POST",
          url: "customerbranchDelete",
          cache: false,
          timeout: 0,
          data:oDataCstBch,
          success: function(tResult) {
            var aReturn = JSON.parse(tResult);
            $('#odvModalDelCustomerBranch').modal('hide');
            if(aReturn['nStaEvent']=='01'){
                JSvCLNCshBchGetDataTable();
            }else{
                FSvCMNSetMsgSucessDialog('Error');
            }
      
          },
          error: function(jqXHR, textStatus, errorThrown) {
              JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
          }
      });

}
</script>
