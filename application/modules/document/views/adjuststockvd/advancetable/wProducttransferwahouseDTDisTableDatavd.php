
  
  
  <input type="text" class="xCNHide" id="ohdnKey" value="<?=$nKey?>">
  <input type="text" class="xCNHide" id="ohdXpdSeqNo" value="<?=$nXpdSeqNo?>">
  <input type="text" class="xCNHide" id="ohdPdtCode" value="<?=$nPdtCode?>">
  <input type="text" class="xCNHide" id="ohdPunCode" value="<?=$nPunCode?>">
  <input type="text" class="xCNHide" id="ohdSeqNo" value="<?=$nSeqNo?>">
  <input type="text" class="xCNHide" id="ohdXpdDisChgAvi" value="<?=$cXpdDisChgAvi?>">
  <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr class="xCNCenter">
            <th><?= language('document/purchaseorder/purchaseorder','tPOTBNo')?></th>
            <th><?= language('document/purchaseorder/purchaseorder','tPOTBBefore')?></th>
            <th><?= language('document/purchaseorder/purchaseorder','tPOTBCalDis')?></th>
            <th><?= language('document/purchaseorder/purchaseorder','tPOTBCalChg')?></th>
            <th><?= language('document/purchaseorder/purchaseorder','tPOTBAfter')?></th>
            <th><?= language('document/purchaseorder/purchaseorder','tPOTBType')?></th>
            <th><?= language('document/purchaseorder/purchaseorder','tPOTBValue')?></th>
            <th><?= language('document/purchaseorder/purchaseorder','tPOTBDelete')?></th>
            <th><?= language('document/purchaseorder/purchaseorder','tPOTBEdit')?></th>
          </tr>
        </thead>
        <tbody id="odvTBodyPODTDis">
          <?php //echo "<pre>"; ?>
          <?php //print_r($aDTDiscount); ?>
          <?php //echo "<pre>"; ?>
          <?php 
            $cXpdDisSUM = 0;
            $cXpdChgSUM = 0;
            $tXpdDisChgTxt = '';
            
            $cXpdDisChgAvi  = $aDataFile[$nKey]['FCXpdDisChgAvi'];
            $cXpdNet        = $aDataFile[$nKey]['FCXpdNet'];
            $cB4Dis         = $aDataFile[$nKey]['FCXpdQty']*$cXpdSetPrice;
            $i = 0;
          ?>

          <!-- Check Have Item DTDis -->
          <?php $nStaHaveDT = 0; /*Check Have Item DTDis*/ ?>
          <?php foreach($aDTDiscount AS $key=>$aValue){ ?>
                  <?php 
                    if($aValue['FNXpdStaDis'] == 1){
                      $nStaHaveDT  = 1;
                    }
                  ?>
          <?php } ?>

          <!-- Check Have Item DTDis -->
          <?php if($nStaHaveDT == 1):?>
                  <?php foreach($aDTDiscount AS $key=>$aValue){ ?>
                    
                    <!-- StaDIs = 1 ลดท้ายรายการ -->
                    <?php if($aValue['FNXpdStaDis'] == 1) {?>
                      <tr class="text-center xCNTextDetail2" id="otrDTDis<?=$key?>" data-index="<?=$key?>" data-doccode="<?=$aValue['FTXphDocNo']?>">
                        <td ><?=$i+1?></td>                      <!--  ลำดับ -->   				
                        <td class="text-right"><?= $cB4Dis != '' ? number_format($cB4Dis, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', ',') ?></td> <!--  ก่อน -->
                        <?php 
                          // คำนวน
                          if($aValue['FTXddDisChgTxt'] != ''){
                            $nLen  = strlen($aValue['FTXddDisChgTxt']);

                            $tStrlast = substr($aValue['FTXddDisChgTxt'],$nLen-1);
                            $tStr1    = $aValue['FTXddDisChgTxt'][0];

                            if($tStrlast != '%'){

                              if($tStr1 != '+'){
                                //ลด
                                $nCalucateDis = $aValue['FTXddDisChgTxt'];
                                $nCalucateChg = 0;
                                $cAFCalPrice  = $cB4Dis - $aValue['FTXddDisChgTxt'];
                                $tDisChgTxt   = '3';
                                $tDisChgValue = $aValue['FTXddDisChgTxt'];
                              }else{
                                //ชาร์จ
                                $nDistext = explode("+",$aValue['FTXddDisChgTxt']);
                                $nCalucateDis = 0;
                                $nCalucateChg = $nDistext[1];
                                $cAFCalPrice  = $cB4Dis + $nDistext[1];
                                $tDisChgTxt   = '1';
                                $tDisChgValue = $nDistext[1];
                              }
                              $cB4Dis = $cAFCalPrice; 

                            }else{

                              $nDistext = explode("%",$aValue['FTXddDisChgTxt']);
                              $nCalucatePercent = ($nDistext[0]*$cB4Dis)/100;
                              
                              if($tStr1 != '+'){
                                //ลด
                                $nCalucateDis = $nCalucatePercent;
                                $nCalucateChg = 0;
                                $cAFCalPrice  = $cB4Dis - $nCalucatePercent;
                                $tDisChgTxt   = '4';
                                $tDisChgValue = $nDistext[0];
                              }else{
                                //ชาร์จ
                                $nCalucateDis = 0;
                                $nCalucateChg = $nCalucatePercent;
                                $cAFCalPrice = $cB4Dis + $nCalucatePercent;
                                $tDisChgTxt   = '2';
                                $tDisChgValue = substr($nDistext[0],1) ;
                              }
                              $cB4Dis = $cAFCalPrice; 

                            }

                            // บวก Dis และ Charge
                            $cXpdDisSUM = $cXpdDisSUM+$nCalucateDis;
                            $cXpdChgSUM = $cXpdChgSUM+$nCalucateChg;
                            //DisCharge Text
                            $tXpdDisChgTxt .= $aValue['FTXddDisChgTxt'].",";
                            
                          }
                          $cXpdDisChgAvi = $cXpdDisChgAvi;
                          

                        ?>
                        <td class="text-right"><?= $nCalucateDis != '0' ? "-".number_format($nCalucateDis, $nOptDecimalShow, '.', ',') : '-' ?></td>                          <!--  คำนวน ลด-->
                        <td class="text-right"><?= $nCalucateChg != '0' ? "+".number_format($nCalucateChg, $nOptDecimalShow, '.', ',') : '-' ?></td>                          <!--  คำนวน ชาร์จ-->
                        <td class="text-right"><?= $cB4Dis != '' ? number_format($cB4Dis, $nOptDecimalShow, '.', ',') : '-' ?></td>                                           <!--  หลัง -->
                        <td class="text-left xWAlwEditXpdDTDisChgType" data-distype="<?=$tDisChgTxt?>"><?= language('document/purchaseorder/purchaseorder','tDisChgTxt'.$tDisChgTxt)?></td>             <!--  ประเภท -->
                        <td class="text-right xWAlwEditXpdDTDisChgValue" data-distype="<?=$tDisChgTxt?>" data-disvalue="<?= $tDisChgValue != '0' ? number_format($tDisChgValue, $nOptDecimalShow, '.', '') : '0' ?>"><?= $tDisChgValue != '0' ? number_format($tDisChgValue, $nOptDecimalShow, '.', ',') : '0' ?></td>    <!--  มูลค่า -->
                        <td class="text-center">
                            <lable class="xCNTextLink">
                              <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" title="Delete" onclick="JSnRemoveDTDisRow(this)">
                            </lable>
                        </td>
                        <td class="text-center">
                            <lable class="xCNTextLink">
                              <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" title="Edit" onclick="JSnEditDTDisRow(this)">
                            </lable>
                        </td>
                      </tr>
                      
                    <?php $i++; ?>
                    <?php  } ?>
                  <?php  } ?>
              <?php else:?>
                  <tr><td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
              <?php endif;?>
        </tbody>
      </table>
      <input type="text" class="xCNHide" id="ohdFCXpdDisChgAvi" value="<?= $cXpdDisChgAvi != '' ? number_format($cXpdDisChgAvi, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', ',') ?>">
      <input type="text" class="xCNHide" id="ohdFCXpdDisSUM" value="<?= $cXpdDisSUM != '' ? number_format($cXpdDisSUM, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', ',') ?>">
      <input type="text" class="xCNHide" id="ohdFCXpdChgSUM" value="<?= $cXpdChgSUM != '' ? number_format($cXpdChgSUM, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', ',') ?>">
      <input type="text" class="xCNHide" id="ohdFCXpdNet" value="<?= $cXpdNet != '' ? number_format($cXpdNet, $nOptDecimalShow, '.', ',') :  number_format(0, $nOptDecimalShow, '.', ',') ?>">
      <input type="text" class="xCNHide" id="ohdFCXpdDisChgTxt" value="<?= substr($tXpdDisChgTxt, 0, -1); ?>">
      

      <!-- div Dropdownbox -->
      <div id="dropDownSelect1"></div>
  </div>

  <!-- Div Dropdown ใช้สำหรับ EditInLine เลือก ประเภท่วนลด -->
  <div class="form-group xCNDivDTDisTypePanal" style="display:none">
      <select class="xWWidth100selectpicker form-control" id="" name="">
      <option value="1"><?= language('document/purchaseorder/purchaseorder','tDisChgTxt1')?></option>
      <option value="2"><?= language('document/purchaseorder/purchaseorder','tDisChgTxt2')?></option>
      <option value="3"><?= language('document/purchaseorder/purchaseorder','tDisChgTxt3')?></option>
      <option value="4"><?= language('document/purchaseorder/purchaseorder','tDisChgTxt4')?></option>
      </select> 
  </div>


<script>

  tSeqNo = $('#ohdSeqNo').val();

  cXpdDisChgAvi   = $('#ohdFCXpdDisChgAvi').val();
  cDisSUM         = $('#ohdFCXpdDisSUM').val();
  cChgSUM         = $('#ohdFCXpdChgSUM').val();
  cXpdNet         = $('#ohdFCXpdNet').val();

  tXpdDisChgTxt = $('#ohdFCXpdDisChgTxt').val();
  $('#ohdFTXpdDisChgTxt'+tSeqNo).val(tXpdDisChgTxt);

  //Check ว่ามีส่วนลดรายการหรือไม่ถ้ามีจะ Disabled input FCXpdQty,FCXpdSetPrice
  if(tXpdDisChgTxt != ''){
    $('#ohdFCXpdQty'+tSeqNo).attr('disabled',true);
    $('#ohdFCXpdSetPrice'+tSeqNo).attr('disabled',true);
  }else{
    $('#ohdFCXpdQty'+tSeqNo).attr('disabled',false);
    $('#ohdFCXpdSetPrice'+tSeqNo).attr('disabled',false);
  }

  $('.xWShowValueFCXpdDisChgAvi'+tSeqNo).text(cXpdDisChgAvi);
  $('#ohdFCXpdDisChgAvi'+tSeqNo).val(cXpdDisChgAvi);

  $('.xWShowValueFCXpdDis'+tSeqNo).text(cDisSUM);
  $('#ohdFCXpdDis'+tSeqNo).val(cDisSUM);

  $('.xWShowValueFCXpdChg'+tSeqNo).text(cChgSUM);
  $('#ohdFCXpdChg'+tSeqNo).val(cChgSUM);

  $('.xWShowValueFCXpdNet'+tSeqNo).text(cXpdNet);
  $('#ohdFCXpdNet'+tSeqNo).val(cXpdNet);

  function JSnRemoveDTDisRow(ele){

    var nIndex = $(ele).parent().parent().parent().attr('data-index');
    JSnPORemoveDTDisInFile(nIndex);
    $(ele).parent().parent().parent().remove();

  }

  function JSnPORemoveDTDisInFile(nIndex){

    nKey      = $('#ohdnKey').val();
    ptXphDocNo = $('#oetXphDocNo').val();
    tSeqNo    = $('#ohdSeqNo').val();

    $.ajax({
        type: "POST",
        url: "PORemoveDTDisInFile",
        data: { 
                ptXphDocNo : ptXphDocNo,
                nKey : nKey,
                nIndex : nIndex 
              },
        cache: false,
        timeout: 5000,
        success: function(tResult){

            JSvPOCallGetDTDisTableData(nKey,tXphDocNo,tSeqNo);

        },
        error: function(data) {
            console.log(data);
        }
    });

  }


//Function Call Edit DTDis In Row
function JSnEditDTDisRow(event){

  var nRowID = $(event).parents().eq(2).attr('id');
  var tIndex = $(event).parents().eq(2).attr('data-index');

  $('#'+nRowID).each(function(ele) {

      tDisTypePanal = $('.xCNDivDTDisTypePanal').html();
      tDisType        = $('#'+nRowID+' .xWAlwEditXpdDTDisChgType').data('distype');
      tValue          = $('#'+nRowID+' .xWAlwEditXpdDTDisChgValue').data('disvalue');

      $(this).find(".xWAlwEditXpdDTDisChgType").html(tDisTypePanal);
      $(this).find(".xWAlwEditXpdDTDisChgType .xWWidth100selectpicker").attr('id','ostDTDisChgType'+tIndex);
      $("#ostDTDisChgType"+tIndex+" option[value='" + tDisType + "']").attr('selected', true).trigger('change');

      // $(this).find(".xWAlwEditXpdDTDisChgValue").html('<input type="number" class="input100" id="oetDTDisChgValue'+tIndex+'" name="oetDTDisChgValue'+tIndex+'" value="'+tValue+'">');
      $(this).find(".xWAlwEditXpdDTDisChgValue").html('')
                                                    .append($('<input>')
                                                    .attr('type','text')
                                                    .attr('class','form-control xCNInputNumericWithDecimal')
                                                    .attr('id','oetDTDisChgValue'+tIndex)
                                                    .attr('maxlength','11')
                                                    .val(tValue)
                                                    )
    });

    $.getScript( "application/assets/src/jFormValidate.js" )
    
    $(event).parent().empty().append($('<img>')
                              .attr('class','xCNIconTable')
                              .attr('title','Save')
                              .attr('src',tBaseURL+'/application/modules/common/assets/images/icons/save.png')
                                .click(function(){
                                    JSxDTDisEditSave(this);
                                })
                              );
                              // .append($('<img>')
                              // .attr('class','xCNIconTable')
                              // .attr('title','Cancel')
                              // .attr('style','margin-left:5px')
                              // .attr('src',tBaseURL+'application/assets/icons/reply.png')
                              //   .click(function(){
                              //     nKey = $('#ohdnKey').val();
                              //     tDocNo = $('#oetXphDocNo').val();
                              //     nSeqNo = $('#ohdSeqNo').val();

                              //     JSvPOCallGetDTDisTableData(nKey,tDocNo,nSeqNo);
                              //   })
                              // );

    $('#ostDTDisChgType'+tIndex).selectpicker();

}


//Function Save Pdt Set Qty
function JSxDTDisEditSave(event){

  var nRowID = $(event).parents().eq(2).attr('id');
  var tIndex = $(event).parents().eq(2).attr('data-index');

  //HD
  nKey      = $('#ohdnKey').val();
  tDocNo    = $('#oetXphDocNo').val();
  nSeqNo = $('#ohdSeqNo').val();

  //DT
  tDTDisChgType   = $('#ostDTDisChgType'+tIndex).val();
  tDTDisChgValue  = $('#oetDTDisChgValue'+tIndex).val();

  	nPlusOld = '';
    nPercentOld = '';
    tPlusNew = '';
	  nPercentNew = '';
    tOldDisDTChgLength = '';

    if(tDTDisChgType == 1 || tDTDisChgType == 2){
      tPlusNew = '+';
    }
      if(tDTDisChgType == 2 || tDTDisChgType == 4){
      nPercentNew = '%';
    }

    $('.xWAlwEditXpdDTDisChgValue').each(function(e){
        if($(this).text() != ''){
            nDistypeOld = $(this).data('distype');
            if(nDistypeOld == 1 || nDistypeOld == 2){
                nPlusOld = '+';
            }
            if(nDistypeOld == 2 || nDistypeOld == 4){
                nPercentOld = '%';
            }
            tOldDisDTChgLength += nPlusOld+$(this).text()+nPercentOld+','
        }
    });

    tNewDisDTChgLength = tPlusNew+accounting.formatNumber(tDTDisChgValue, nOptDecimalSave,"")+nPercentNew;
      //เอาทั้งสองมาต่อกัน
      tCurDisDTChgLength = tOldDisDTChgLength+tNewDisDTChgLength
        //หาจำนวนตัวอักษร
    nCurDisDTChgLength = tCurDisDTChgLength.length;

      if(tDTDisChgValue == ''){
      $('#oetDTDisChgValue'+tIndex).focus();
    }else{
      //Check ขนาดของ Text DisChgText
      if(nCurDisDTChgLength <= 20){
        $.ajax({
            type: "POST",
            url: "POEditDTDis",
            data: { 
                    nKey            : nKey,
                    tDocNo          : tDocNo,
                    tIndex          : tIndex,
                    tDTDisChgType   : tDTDisChgType,
                    tDTDisChgValue  : tDTDisChgValue
            },
            cache: false,
            timeout: 5000,
            success: function(tResult){

              JSvPOCallGetDTDisTableData(nKey,tDocNo,nSeqNo);
                
            },
            error: function(data) {
                console.log(data);
            }
        });
      }else{
        alert('ไม่สามารถเพิ่มได้ จำนวนขนาดเกิน 20');
      }
    }



}


</script>


