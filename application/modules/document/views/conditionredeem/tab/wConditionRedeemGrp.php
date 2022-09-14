<div id="odvTabConditionRedeemHDGrp" >
<!-- <div class="col-md-12"> -->
            <div class="table-responsive">

              <div  style="padding-bottom: 20px;">
              <?php if($tRDHStaApv!=1){ ?>
                  <button id="obtTabConditionRedeemHDGrp"  class="xCNBTNPrimeryPlus hideGrpNameColum" type="button">+</button>
                  <?php } ?>
                </div>
               <div>
               <div class="form-group">

                <label class="fancy-checkbox">
                    <input type="checkbox" id="ocbRddStaAutoGenCode" name="ocbRddStaAutoGenCode" maxlength="1" checked="checked">
                    <span>&nbsp;</span>
                    <span class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRdhGenCodeAuto');?></span>
                </label>
                </div>
               </div> 
        
             <table  class="table xWPdtTableFont">
                    <thead>
                    <tr class="xCNCenter">
                            <th nowrap class="xCNTextBold hideGrpNameColum" style="width:20%;"  ><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupConditionRedeemName')?></th>
                            <th nowrap class="xCNTextBold" style="width:50%;"><?php echo language('document/conditionredeem/conditionredeem','tRdhGenCodeRedeem')?></th>
                            <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/conditionredeem/conditionredeem','tRdhGenCodeRedeemPointUse')?></th>
                            <th nowrap class="xCNTextBold" id="ospRddWording1" style="width:10%;"><?php echo language('document/conditionredeem/conditionredeem','tRdhGenCodeRedeemMoney')?></th>
                            <th nowrap class="xCNTextBold" id="ospRddWording2" hidden style="width:10%;"><?php echo language('document/conditionredeem/conditionredeem','tRdhGenCodeRedeemValue')?></th>
                            <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/conditionredeem/conditionredeem','tRdhGenCodeRedeemLimitBill')?></th>
                            <th nowrap class="xCNTextBold othColumDelete" style="width:10%;"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupDelete')?></th>
                        </tr>
                    </thead>
                    <tbody id="otbConditionRedeemHDGrp">
                        <?php
                                if(!empty($aDataDocCD)){
                                        foreach($aDataDocCD as $nKey => $aData){
                                    ?>
                        <tr class="otrConditionRedeemCDGROUP" id='otrGrpRowID_<?=$nKey?>'>
                            <td class='hideGrpNameColum textGroupName' id="textGroupSeq_<?=$aData['FNRdcSeq']?>" ><?=$aData['FTRddGrpName']?></td>
                            <td><input type='text' class='form-control' name='oetRdcRefCode[]' readonly value="<?=$aData['FTRdcRefCode']?>" ></td>
                            <td><input type='text' class='form-control xCNInputNumericWithDecimal  text-right'  name='oetRdcUsePoint[]' value='<?=number_format($aData['FCRdcUsePoint'],$nDecimalShow)?>' ></td>
                            <td><input type='text' class='form-control xCNInputNumericWithDecimal xCNInputMaskCurrencyRdh  text-right'  name='oetRdcUseMny[]'  value='<?=number_format($aData['FCRdcUseMny'],$nDecimalShow)?>' ></td>
                            <td><input type='text' class='form-control xCNInputNumericWithDecimal xCNInputMaskCurrencyRdh  text-right'  name='oetRdcMinTotBill[]' value='<?=number_format($aData['FCRdcMinTotBill'],$nDecimalShow)?>' ></td>
                            <td align='center' class="othColumDelete"><img class='xCNIconTable' src='application/modules/common/assets/images/icons/delete.png' title='Remove' onclick='JSxRDHDelGroupCondition(<?=$nKey?>)'></td>
                        </tr>
                             <?php
                                        }
                                }else{ ?>
                                 <tr><td  colspan="5" align="center"> <?php echo language('document/conditionredeem/conditionredeem','tRdhGroupNotFound')?> </td></tr>
                             <?php   }

                        ?>
                    </tbody>
                </table>
                </div>


                <div class="col-md-12 odvHideGroupNameCol" style="padding: 0px;padding-bottom: 15px;" >
                         
                            <div class="col-md-12">
                                <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRDHPdtGrpExclude')?></label>
                            </div>
                            <div class="col-md-12 odvRddPdtGrp2" id="odvRddPdtGrp2" >
                            
                            </div>
                        
                    </div>

            <!-- </div> -->
</div>





<script>
$('.xCNInputMaskCurrencyRdh').on("blur", function() {
                    var tInputVal = $(this).val();
                    tInputVal += '';
                    tInputVal = tInputVal.replace(',', '');
                    tInputVal = tInputVal.split('.');
                    tValCurency = tInputVal[0];
                    tDegitInput = tInputVal.length > 1 ? '.' + tInputVal[1] : '';
                    var tCharecterComma = /(\d+)(\d{3})/;
                    while (tCharecterComma.test(tValCurency))
                        tValCurency = tValCurency.replace(tCharecterComma, '$1' + ',' + '$2');
                    var tInputReplaceComma = tValCurency + tDegitInput;
                    var tSearch = ".";
                    var tStrinreplace = ".00";
                    var tInputCommaDegit = ""
                    if (tInputReplaceComma.indexOf(tSearch) == -1 && tInputReplaceComma != "") {
                        tInputCommaDegit = tInputReplaceComma.concat(tStrinreplace);
                    } else {
                        tInputCommaDegit = tInputReplaceComma;
                    }
                    $(this).val(tInputCommaDegit);
                });
                
$('#obtTabConditionRedeemHDGrp').unbind().click(function(){

        JSxRDHGenGroupAddRowHtml();
 
});


$('#ocbRddStaAutoGenCode').unbind().click(function(){
 
    if($(this).prop('checked')==true){
        $('input[name^="oetRdcRefCode"]').attr('readonly',true);
    }else{
        $('input[name^="oetRdcRefCode"]').attr('readonly',false);
    }
});


</script>