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
    <tbody id="odvTBodyPOHDDis">
        <?php //echo "<pre>"; ?>
        <?php //print_r($aDataFile['HDData']); ?>
        <?php //echo "<pre>"; ?>
        <?php 
        //ประกาศตัวแปร

        //From Coltroller 
        $cXphTotalB4Dis = $cXphTotal;
        $nXphVATInOrEx = $nXphVATInOrEx; //รวมใน / แยกนอก
        $cXphRefAEAmt   = $cXphRefAEAmt; //มัดจำ
        $nXphVATRate   = $nXphVATRate;  //Vat
        $nXphWpTax   = $nXphWpTax;      //XphWpTax
        //From Coltroller 

        $tXphDisChgTxt = '';
        $cXphDis        = 0;
        $cXpdChg        = 0;
        $cDisTotal      = 0;
        $cXphAfDisChgAE = 0;
        $cXphVat        = 0;
        $cXphVatable    = 0;
        $cXphGrandB4Wht = 0;
        $cXphGrand      = 0;
        
        $i = 0;
        ?>

        <!-- คำนวน HDDis -->
        <?php 
                //ตัวแปรที่เก็บค่าคำนวน
                $nHDXphTotal = 0;
                $nHDDis = 0;
                $nHDNet = 0;
                $nHDVat = 0;
                if(is_array(@$aDataFile['DTData'])){
                    foreach($aDataFile['DTData'] as $key=>$val){
                        //จำนวนเงินรวมทั้งสิ้น
                        $nHDXphTotal  = $nHDXphTotal+$val['FCXpdNet'];
                        //ส่วนลด
                        $nHDDis       = $nHDDis+$val['FCXpdDis'];
                        //จำนวนเงินหลังลด
                        $nHDNet       = $nHDNet+$val['FCXpdNet'];
                        //ภาษีมูลค่าเพิ่ม
                        $nHDVat       = $nHDNet+$val['FCXpdVat'];
                    }
                }
                //ยอดรวมภาษี
                $nHDSumVat = $nHDNet+$nHDVat;
        
        ?>


        <?php if(FCNnHSizeOf($aDataFile['HDData']) > 0 ):?>
                <?php foreach($aDataFile['HDData'] AS $key=>$aValue){ ?>
                <tr class="text-center xCNTextDetail2" id="otrHDDis<?=$key?>" data-index="<?=$key?>" data-docno="<?=$aValue['FTXphDocNo']?>">
                    <td ><?=$i+1?></td>                      <!--  ลำดับ -->   				
                    <td class="text-right"><?= $cXphTotalB4Dis != '' ? number_format($cXphTotalB4Dis, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', ',') ?></td> <!--  ก่อน -->
                    <?php  
                    // คำนวน
                    if($aValue['FTXphDisChgTxt'] != ''){
                        $nLen  = strlen($aValue['FTXphDisChgTxt']);

                        $tStrlast = substr($aValue['FTXphDisChgTxt'],$nLen-1);
                        $tStr1    = $aValue['FTXphDisChgTxt'][0];

                        if($tStrlast != '%'){

                        if($tStr1 != '+'){
                            //ลด
                            $nCalucateDis = $aValue['FTXphDisChgTxt'];
                            $nCalucateChg = 0;
                            $cAFCalPrice  = $cXphTotalB4Dis - $aValue['FTXphDisChgTxt'];
                            $tDisChgTxt   = '3';
                            $tDisChgValue = $aValue['FTXphDisChgTxt'];

                            $cDisTotal = $cDisTotal+$aValue['FTXphDisChgTxt'];
                            $cXphDis = $cXphDis+$aValue['FTXphDisChgTxt'];
                        }else{
                            //ชาร์จ
                            $nDistext = explode("+",$aValue['FTXphDisChgTxt']);
                            $nCalucateDis = 0;
                            $nCalucateChg = $nDistext[1];
                            $cAFCalPrice  = $cXphTotalB4Dis + $nDistext[1];
                            $tDisChgTxt   = '1';
                            $tDisChgValue = $nDistext[1];

                            $cDisTotal = $cDisTotal-$nDistext[1];
                            $cXpdChg = $cXpdChg+$nDistext[1];
                        }
                        $cXphTotalB4Dis = $cAFCalPrice; 

                        }else{

                        $nDistext = explode("%",$aValue['FTXphDisChgTxt']);
                        $nCalucatePercent = ($nDistext[0]*$cXphTotalB4Dis)/100;
                        
                        if($tStr1 != '+'){
                            //ลด
                            $nCalucateDis = $nCalucatePercent;
                            $nCalucateChg = 0;
                            $cAFCalPrice  = $cXphTotalB4Dis - $nCalucatePercent;
                            $tDisChgTxt   = '4';
                            $tDisChgValue = $nDistext[0];

                            $cDisTotal = $cDisTotal+$nCalucatePercent;
                            $cXphDis = $cXphDis+$nCalucatePercent;
                        }else{
                            //ชาร์จ
                            $nCalucateDis = 0;
                            $nCalucateChg = $nCalucatePercent;
                            $cAFCalPrice = $cXphTotalB4Dis + $nCalucatePercent;
                            $tDisChgTxt   = '2';
                            $tDisChgValue = substr($nDistext[0],1) ;

                            $cDisTotal = $cDisTotal-$nCalucatePercent;
                            $cXpdChg = $cXpdChg+$nCalucatePercent;
                        }
                        $cXphTotalB4Dis = $cAFCalPrice; 

                        }

                        $tXphDisChgTxt .= $aValue['FTXphDisChgTxt'].",";


                    }




                    ?>
                    <td class="text-right"><?= $nCalucateDis != '0' ? "-".number_format($nCalucateDis, $nOptDecimalShow, '.', ',') : '-' ?></td>          <!--  คำนวน ลด-->
                    <td class="text-right"><?= $nCalucateChg != '0' ? "+".number_format($nCalucateChg, $nOptDecimalShow, '.', ',') : '-' ?></td>          <!--  คำนวน ชาร์จ-->
                    <td class="text-right"><?= $cXphTotalB4Dis != '' ? number_format($cXphTotalB4Dis, $nOptDecimalShow, '.', ',') : '-' ?></td>                     <!--  หลัง -->
                    <td class="text-left xWAlwEditXpdHDDisChgType" data-distype="<?=$tDisChgTxt?>"><?= language('document/purchaseorder/purchaseorder','tDisChgTxt'.$tDisChgTxt)?></td>             <!--  ประเภท -->
                    <td class="text-right xWAlwEditXpdHDDisChgValue" data-distype="<?=$tDisChgTxt?>" data-disvalue="<?= $tDisChgValue != '0' ? number_format($tDisChgValue, $nOptDecimalShow, '.', '') : '0' ?>"><?= $tDisChgValue != '0' ? number_format($tDisChgValue, $nOptDecimalShow, '.', ',') : '0' ?></td>    <!--  มูลค่า -->
                    <td class="text-center">
                        <lable class="xCNTextLink">
                            <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onclick="JSnRemoveHDDisRow(this)">
                        </lable>
                    </td>
                    <td class="text-center">
                        <lable class="xCNTextLink">
                            <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onclick="JSnEditHDDisRow(this)">
                        </lable>
                    </td>
                </tr>
                
                <?php $i++; ?>
                <?php  } ?>

            <?php else:?>
                <tr><td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
            <?php endif;?>

            <?php 
            
                //ยอดรวมส่วนลดชาร์จ
                $cDisTotal = $cXphDis-$cXpdChg;

                //ยอดรวมหลัง ลด-ชาร์จ+มัดจำ
                //(FCXphVatNoDisChg+FCXphNoVatNoDisChg)+(FCXphVatAfDisChg+FCXphNoVatAfDisChg)
                $cXphAfDisChgAE = $cXphTotal-$cDisTotal-$cXphRefAEAmt;

                //
                if($nXphVATInOrEx == 1){
                    //หาสูตรรวมใน
                    $cXphVat  = $cXphAfDisChgAE-(($cXphAfDisChgAE*100)/(100+$nXphVATRate));
                }else{
                    $cXphVat =  (($cXphAfDisChgAE*(100+$nXphVATRate))/100)-$cXphAfDisChgAE;
                }

                //ยอดแยกภาษี
                $cXphVatable = $cXphAfDisChgAE-$cXphVat;
                
                //ยอดรวมสุทธิ ก่อน ภาษี ณ ที่จ่าย  IN:FCXphVat+FCXphVatable , EX : FCXphAfDisChgAE+FCXphVat
                if($nXphVATInOrEx == 1){
                    //หาสูตรรวมใน
                    $cXphGrandB4Wht = $cXphVat+$cXphVatable;
                }else{
                    $cXphGrandB4Wht = $cXphAfDisChgAE+$cXphVat;
                }

                $cXphGrand = $cXphGrandB4Wht-$nXphWpTax;
            
            ?>
    </tbody>
    </table>
    
    <input type="text" class="xCNHide" id="ohdFCXphTotal" value="<?= $cXphTotal != '' ? number_format($cXphTotal, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', '') ?>">
    <input type="text" class="xCNHide" id="ohdFTXphDisChgTxt" value="<?= substr($tXphDisChgTxt, 0, -1); ?>">
    <input type="text" class="xCNHide" id="ohdFCXphDis" value="<?= $cDisTotal != '' ? number_format($cDisTotal, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', '') ?>">
    <input type="text" class="xCNHide" id="ohdFCXphAfDisChgAE" value="<?= $cXphAfDisChgAE != '' ? number_format($cXphAfDisChgAE, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', ' ') ?>">
    <input type="text" class="xCNHide" id="ohdFCXphRefAEAmt" value="<?= $cXphRefAEAmt != '' ? number_format($cXphRefAEAmt, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', ' ') ?>">
    <input type="text" class="xCNHide" id="ohdFCXphVat" value="<?= $cXphVat != '' ? number_format($cXphVat, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', ' ') ?>">
    <input type="text" class="xCNHide" id="ohdFCXphVatable" value="<?= $cXphVatable != '' ? number_format($cXphVatable, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', ' ') ?>">
    <input type="text" class="xCNHide" id="ohdFCXphGrandB4Wht" value="<?= $cXphGrandB4Wht != '' ? number_format($cXphGrandB4Wht, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', ' ') ?>">
    <input type="text" class="xCNHide" id="ohdFCXphGrandText" value="<?= $cXphGrand != '' ? FCNtoBaht(number_format($cXphGrand, 2, '.', ',')) : '' ?>">
   
</div>

  <!-- Div Dropdown ใช้สำหรับ EditInLine เลือก ประเภท่วนลด -->
  <div class="form-group xCNDivHDDisTypePanal" style="display:none">
      <select class="xWWidth100selectpicker form-control" id="" name="" style="width:100px;">
      <option value="1"><?= language('document/purchaseorder/purchaseorder','tDisChgTxt1')?></option>
      <option value="2"><?= language('document/purchaseorder/purchaseorder','tDisChgTxt2')?></option>
      <option value="3"><?= language('document/purchaseorder/purchaseorder','tDisChgTxt3')?></option>
      <option value="4"><?= language('document/purchaseorder/purchaseorder','tDisChgTxt4')?></option>
      </select> 
  </div>

<script>


    cXphTotal =  $('#ohdFCXphTotal').val();
    $('#othFCXphTotal').text(cXphTotal);

    tXphDisChgTxt = $('#ohdFTXphDisChgTxt').val();
    $('#oetFTXphDisChgTxt').val(tXphDisChgTxt);

    cXphDis = $('#ohdFCXphDis').val();
    $('#othFCXphDis').text(cXphDis);

    cXphAfDisChgAE = $('#ohdFCXphAfDisChgAE').val();
    $('#othFCXphAfDisChgAE').text(cXphAfDisChgAE);

    cXphRefAEAmt = $('#ohdFCXphRefAEAmt').val();
    $('#othFCXphRefAEAmt').text(cXphRefAEAmt);

    cXphVat = $('#ohdFCXphVat').val();
    $('#othFCXphVat').text(cXphVat);

    cXphVatable = $('#ohdFCXphVatable').val();
    $('#othFCXphVatable').text(cXphVatable);

    cXphGrandB4Wht = $('#ohdFCXphGrandB4Wht').val();
    $('#othFCXphGrandB4Wht').text(cXphGrandB4Wht);

    //หา FCXphGrand
    cXphWpTax = $('#oetFCXphWpTaxInput').val();

    if(cXphWpTax != undefined){
        $('#othFCXphWpTax').text(accounting.formatNumber(cXphWpTax, nOptDecimalShow,","));
        cXphGrand = cXphGrandB4Wht.replace(/,/g,'')-cXphWpTax.replace(/,/g,'');
        $('#othFCXphGrand').text(accounting.formatNumber(cXphGrand, nOptDecimalShow,","));
    }
    
    cXphGrandText = $('#ohdFCXphGrandText').val();
    $('#othFCXphGrandText').text(cXphGrandText);


function JSnRemoveHDDisRow(ele){

    var nIndex = $(ele).parent().parent().parent().attr('data-index');
    JSnPORemoveHDDisInFile(nIndex);
    $(ele).parent().parent().parent().remove();

}

function JSnPORemoveHDDisInFile(nIndex){
  
    ptXphDocNo = $('#oetXphDocNo').val();

    $.ajax({
        type: "POST",
        url: "PORemoveHDDisInFile",
        data: { 
                ptXphDocNo : ptXphDocNo,
                nIndex : nIndex
            },
        cache: false,
        timeout: 5000,
        success: function(tResult){
            
            JSvPOLoadPdtDataTableHtml();

        },
        error: function(data) {
            console.log(data);
        }
    });

}

//Function Call Edit HDDis In Row
function JSnEditHDDisRow(event){

    var nRowID = $(event).parents().eq(2).attr('id');
    var tIndex = $(event).parents().eq(2).attr('data-index');

    $('#'+nRowID).each(function(ele) {

        tDisTypePanal = $('.xCNDivHDDisTypePanal').html();
        tDisType        = $('#'+nRowID+' .xWAlwEditXpdHDDisChgType').data('distype');
        tValue          = $('#'+nRowID+' .xWAlwEditXpdHDDisChgValue').data('disvalue');
        
        $(this).find(".xWAlwEditXpdHDDisChgType").html(tDisTypePanal);
        $(this).find(".xWAlwEditXpdHDDisChgType .xWWidth100selectpicker").attr('id','ostHDDisChgType'+tIndex);
        $("#ostHDDisChgType"+tIndex+" option[value='" + tDisType + "']").attr('selected', true).trigger('change');

        $(this).find(".xWAlwEditXpdHDDisChgValue").html('')
                                                    .append($('<input>')
                                                    .attr('type','text')
                                                    .attr('class','form-control xCNInputNumericWithDecimal')
                                                    .attr('id','oetHDDisChgValue'+tIndex)
                                                    .attr('maxlength','11')
                                                    .val(tValue)
                                                    )
    });
    
    $.getScript( "application/assets/src/jFormValidate.js" )

    $(event).parent().empty().append($('<img>')
                            .attr('class','xCNIconTable')
                            .attr('src',tBaseURL+'/application/modules/common/assets/images/icons/save.png')
                                .click(function(){
                                    JSxHDDisEditSave(this);
                                })
                            );
    $('#ostHDDisChgType'+tIndex).selectpicker();

}

//Function Save Pdt Set Qty
function JSxHDDisEditSave(event){

    var nRowID = $(event).parents().eq(2).attr('id');
    var tIndex = $(event).parents().eq(2).attr('data-index');

    //DT
    tHDDisChgType   = $('#ostHDDisChgType'+tIndex).val();
    tHDDisChgValue  = $('#oetHDDisChgValue'+tIndex).val();

	nPlusOld = '';
    nPercentOld = '';
    tPlusNew = '';
	nPercentNew = '';
    tOldDisHDChgLength = '';

    if(tHDDisChgType == 1 || tHDDisChgType == 2){
		tPlusNew = '+';
	}
    if(tHDDisChgType == 2 || tHDDisChgType == 4){
		nPercentNew = '%';
	}

    $('.xWAlwEditXpdHDDisChgValue').each(function(e){
        if($(this).text() != ''){
            nDistypeOld = $(this).data('distype');
            if(nDistypeOld == 1 || nDistypeOld == 2){
                nPlusOld = '+';
            }
            if(nDistypeOld == 2 || nDistypeOld == 4){
                nPercentOld = '%';
            }
            tOldDisHDChgLength += nPlusOld+$(this).text()+nPercentOld+','
        }
    });
    tNewDisHDChgLength = tPlusNew+accounting.formatNumber(tHDDisChgValue, nOptDecimalSave,"")+nPercentNew;
    //เอาทั้งสองมาต่อกัน
    tCurDisHDChgLength = tOldDisHDChgLength+tNewDisHDChgLength
    	//หาจำนวนตัวอักษร
	nCurDisHDChgLength = tCurDisHDChgLength.length;

    if(tHDDisChgValue == ''){
		$('#oetHDDisChgValue'+tIndex).focus();
	}else{
		//Check ขนาดของ Text DisChgText
		if(nCurDisHDChgLength <= 20){
            $.ajax({
                type: "POST",
                url: "POEditHDDis",
                data: { 
                    tIndex          : tIndex,
                    tHDDisChgType   : tHDDisChgType,
                    tHDDisChgValue  : tHDDisChgValue
                },
                cache: false,
                timeout: 5000,
                success: function(tResult){

                    console.log(tResult);
                    JSvPOLoadPdtDataTableHtml();
                    
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