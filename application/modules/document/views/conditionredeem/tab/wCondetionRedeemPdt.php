
<div id="odvTabConditionRedeemHDPdt" >
<!-- <div class="col-md-12"> -->
        <div class="table-responsive">

            <div  style="padding-bottom: 20px;">
              <?php if($tRDHStaApv!=1){ ?>
                  <button id="obtTabConditionRedeemHDPdtInclude" class="xCNBTNPrimeryPlus xCNInputWhenStaCancelDoc" type="button">+</button>
              <?php } ?>
            </div>

            <div>
                <label  class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem',' ')?></label>
            </div> 
             <table class="table xWPdtTableFont">
                <thead>
                    <tr class="xCNCenter">
                        <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/conditionredeem/conditionredeem','tRdhNumberList')?></th>
                        <th nowrap class="xCNTextBold" style="width:60%;"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupName')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupDelete')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupEdit')?></th>
                    </tr>
                </thead>
                <tbody id="otbConditionRedeemHDPdtInclude">
                    <tr><td colspan ="4"  align="center"> <?php echo language('document/conditionredeem/conditionredeem','tRdhGroupNotFound')?> </td></tr>
                </tbody>
            </table>
        </div>
    <!-- </div> -->
</div>



<div  class="modal fade" id="odvRDHConditionRedeemHDPdt" role="dialog"  data-backdrop="static" data-keyboard="true" tabindex="-1" style="overflow: hidden auto;"  >
<Input type="hidden" name="ohdRDHModalType" id="ohdRDHModalType"  value="1">
  <div class="modal-dialog" role="document" style="width:950px">
    <div class="modal-content">
    <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('document/conditionredeem/conditionredeem','tRdhGroupConditionRedeemCreate')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
      <div class="modal-body">
    <input  type="hidden" name="ohdRDHConditionRedeemModalTypeIncludeHDPdt" id="ohdRDHConditionRedeemModalTypeIncludeHDPdt">
        <div class='row'>
        <div class="col-lg-12" style="padding-bottom: 5px;" align="right"> 
        <?php if($tRDHStaApv!=1){ ?>
        <button type="button" class="btn xCNBTNDefult" data-dismiss="modal" id="obtRDHConditionRedeemClearTmp"><?=language('common/main/main','tModalAdvClose')?></button>
        <button type="button"  class="btn xCNBTNPrimery" id="obtRDHConditionRedeemSelectPdt" ><?=language('document/conditionredeem/conditionredeem','tRdhGroupConditionRedeemSave')?></button>
        <?php } ?>
      </div>

            <div class='col-lg-12' style="padding: 10px;">
                    <div class='col-lg-2'>
                    <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupConditionRedeemName')?></label>
                    </div>
                    <div class='col-lg-10'>                    
                    <input type='text' class='form-control' id='oetRDDGrpName' name='oetRDDGrpName' >
                    <input type='hidden' class='form-control' id='oetRDDGrpCode' name='oetRDDGrpCode' >
                </div>
            </div>
            <div class='col-lg-12' style="padding: 10px;">
                <div class='col-lg-2'>
                   <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupConditionRedeemGroupType')?></label>
                </div>

                    <div class='col-lg-6'>
                        <select class="selectpicker form-control xCNInputWhenStaCancelDoc" id="ocmRDDStaType" name="ocmRDDStaType" >
                            <option value="1"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupConditionRedeemTypeInclude'); ?></option>
                            <option value="2"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupConditionRedeemTypeExclude'); ?></option>
                        </select>
                    </div>
                </div>


            <div class='col-lg-12' style="padding: 5px;">
                <hr>
             </div>
             <div class='col-lg-12' style="padding-right: 10px;">
             <?php if($tRDHStaApv!=1){ ?>
                <button id="obtTabPdtRDHDocBrowsePdt" class="xCNBTNPrimeryPlus xCNInputWhenStaCancelDoc" type="button">+</button>
             <?php } ?>
            </div>
                <div class='col-lg-12' id="otbConditionRedeemHDPdtTab" style="padding: 5px;">
                

              
                </div>



            </div>
    
      </div>

    </div>
  </div>
</div>


<script>


$('#obtRDHConditionRedeemSelectPdt').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxRDHSaveGrpNameDTTemp();
            }else{  
                JCNxShowMsgSessionExpired();
            }
});

$('#obtRDHConditionRedeemClearTmp').unbind().click(function(){
    JSxRDHClearConditionRedeemTmp();
})

$('#obtTabPdtRDHDocBrowsePdt').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                // $('#oetRDDGrpName').val('');
                JCNvRDHBrowsePdt();
            
            }else{
                JCNxShowMsgSessionExpired();
            }
        });


  // =========================================== Event Browse Multi Branch ===========================================
  $('#obtTabConditionRedeemHDPdtInclude').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#oetRDDGrpName').val('');
            $('#oetRDDGrpCode').val('');
            $('#ohdRDHModalType').val(1);
            JSvRDHLoadPdtDataTableHtml();
            JSxCheckPinMenuClose(); // Hidden Pin Menu

            $("#odvRDHConditionRedeemHDPdt").modal({backdrop: "static", keyboard: false});
             $("#odvRDHConditionRedeemHDPdt").modal({show: true});
        }else{
            JCNxShowMsgSessionExpired();
        }
    });



    
  // =========================================== Event Browse Multi Branch ===========================================
  $('#obtTabConditionRedeemHDPdtExclude').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            $('#oetRDHConditionRedeemPdtCode').val('');
            $('#oetRDHConditionRedeemPdtName').val('');
            $('#ohdRDHPdtUnitCode').val('');
            $('#ohdRDHPdtUnitName').val('');
            $('#ohdRDHConditionRedeemModalTypeIncludeHDPdt').val(2);
            $('#obtRDHAddProductUnit').attr('disabled',true);
            $('#ohdRDHModalType').val(1);
            $("#odvRDHConditionRedeemHDPdt").modal({backdrop: "static", keyboard: false});
             $("#odvRDHConditionRedeemHDPdt").modal({show: true});
        }else{
            JCNxShowMsgSessionExpired();
        }
    });



    
function JSnCHPCheckDuplicationRowHDPdt(paData){

let nLenIn = $('input[name^="ohdRDHConditionRedeemIncludePdtCode["]').length
let aEchDataIn = JSxCreateArray(nLenIn,2);
//Include
$('input[name^="ohdRDHConditionRedeemIncludePdtCode["]').each(function(index){
    let tPdtCode = $(this).val();
    aEchDataIn[index][0]=tPdtCode;
});
$('input[name^="ohdRDHConditionRedeemIncludePdtUnitCode["]').each(function(index){
    let tUnitCode = $(this).val();
    aEchDataIn[index][1]=tUnitCode;
});

let nLenEx = $('input[name^="ohdRDHConditionRedeemExcludePdtCode["]').length
let aEchDataEx = JSxCreateArray(nLenEx,3);
//Exclude
$('input[name^="ohdRDHConditionRedeemExcludePdtCode["]').each(function(index){
    let tPdtCode = $(this).val();
    aEchDataEx[index][0]=tPdtCode;
});
$('input[name^="ohdRDHConditionRedeemExcludePdtUnitCode["]').each(function(index){
    let tUnitCode = $(this).val();
    aEchDataEx[index][1]=tUnitCode;
});
// console.log("aEchDataIn",aEchDataIn);
// console.log("aEchDataEx",aEchDataEx);

let nAproveAppend = 0;
for(i=0;i<aEchDataIn.length;i++){
    if(aEchDataIn[i][0]==paData.tRDHConditionRedeemPdtCode && aEchDataIn[i][1]==paData.tRDHPdtUnitCode){
        nAproveAppend++;
    }
}
for(i=0;i<aEchDataEx.length;i++){
    if(aEchDataEx[i][0]==paData.tRDHConditionRedeemPdtCode && aEchDataEx[i][1]==paData.tRDHPdtUnitCode){
        nAproveAppend++;
    }
}
// console.log(nAproveAppend);
return nAproveAppend;

}
        /*===== Begin Event Next Function Browse ========================================== */
    // Functionality : 
    // Parameter : Event Next Func Modal
    // Create : 11/02/2020 Nattakit(Nale)
    // Return : Set Element And value
    // Return Type : -
    function JSxConsNextFuncBrowsePdtInclude(poDataNextFunc){
        if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){

            var i = Date.now();
            var tMarkUp ="";
                    tMarkUp +="<tr class='otrInclude' id='otrRDHConditionRedeemIncludePdt"+i+"'>";
                    tMarkUp +="<td><input type='hidden' name='ohdRDHConditionRedeemIncludePdtCode["+i+"]' class='ohdRDHConditionRedeemIncludePdtCode' value='"+poDataNextFunc.tRDHConditionRedeemPdtCode+"'>"+poDataNextFunc.tRDHConditionRedeemPdtCode+"</td>";
                    tMarkUp +="<td>"+poDataNextFunc.tRDHConditionRedeemPdtName+"</td>";
                    tMarkUp +="<td><input type='hidden' name='ohdRDHConditionRedeemIncludePdtUnitCode["+i+"]' class='ohdRDHConditionRedeemIncludePdtUnitCode' value='"+poDataNextFunc.tRDHPdtUnitCode+"'>"+poDataNextFunc.tRDHPdtUnitName+"</td>";
                    tMarkUp +="<td align='center'><img onclick='JSxRDHConditionRedeemRemoveTRIncludePdt("+i+")' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>";
                    tMarkUp +="</tr>";
                
                $('#otbConditionRedeemHDPdtInclude').append(tMarkUp);
            }

    }

    function JSxRDHConditionRedeemRemoveTRIncludePdt(ptCode){
        $('#otrRDHConditionRedeemIncludePdt'+ptCode).remove();

    }

       /*===== Begin Event Next Function Browse ========================================== */
    // Functionality : 
    // Parameter : Event Next Func Modal
    // Create : 11/02/2020 Nattakit(Nale)
    // Return : Set Element And value
    // Return Type : -
    function JSxConsNextFuncBrowsePdtExclude(poDataNextFunc){
        if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){

            var i = Date.now();
            var tMarkUp ="";
                    tMarkUp +="<tr class='otrExclude' id='otrRDHConditionRedeemExcludePdt"+i+"'>";
                    tMarkUp +="<td><input type='hidden' name='ohdRDHConditionRedeemExcludePdtCode["+i+"]' class='ohdRDHConditionRedeemExcludePdtCode' value='"+poDataNextFunc.tRDHConditionRedeemPdtCode+"'>"+poDataNextFunc.tRDHConditionRedeemPdtCode+"</td>";
                    tMarkUp +="<td>"+poDataNextFunc.tRDHConditionRedeemPdtName+"</td>";
                    tMarkUp +="<td><input type='hidden' name='ohdRDHConditionRedeemExcludePdtUnitCode["+i+"]' class='ohdRDHConditionRedeemExcludePdtUnitCode' value='"+poDataNextFunc.tRDHPdtUnitCode+"'>"+poDataNextFunc.tRDHPdtUnitName+"</td>";
                    tMarkUp +="<td align='center'><img onclick='JSxRDHConditionRedeemRemoveTRExcludePdt("+i+")' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>";
                    tMarkUp +="</tr>";
                
                $('#otbConditionRedeemHDPdtExclude').append(tMarkUp);
            }

    }

    function JSxRDHConditionRedeemRemoveTRExcludePdt(ptCode){
        $('#otrRDHConditionRedeemExcludePdt'+ptCode).remove();

    }





</script>