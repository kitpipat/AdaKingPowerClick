
<?php
$tRoute = "bankEventAddinfo2";

if (isset($aBnkData['raItems'])) {
  $nStmSeq      = $aBnkData['raItems']['FNStmSeq'];
  $tStmName     = $aBnkData['raItems']['FTStmName'];
  $tStmLimit    = number_format($aBnkData['raItems']['FCStmLimit'],2);
  $tStmQty      = number_format($aBnkData['raItems']['FCStmQty'],2);
  $tStmStaUnit  = $aBnkData['raItems']['FTStmStaUnit'];
  $tStmRate     = number_format($aBnkData['raItems']['FCStmRate'],2);
}else {
  $nStmSeq      = "";
  $tStmName     = "";
  $tStmLimit    = "";
  $tStmQty      = "";
  $tStmStaUnit  = "";
  $tStmRate     = 0;
}
 ?>
 
<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddBnkInfo2">
    <div class="row xCNavRow" style="width:inherit;">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8"></div>
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right">
            <div id="odvBtnPdtInfo" style="display: none;">
                <button id="obtPdtCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
            </div>
            <div id="odvBtnPdtAddEdit" style="display: block;">
            <button id="obtCallBackInfo2" onclick="$('#oliBnkDataAddInfo2').click();" class="btn" style="background-color: #D4D4D4; color: #000000;" type="button"><?php echo language('bank/bank/bank','tBNKCallBack')?> </button>
            <button id="obtBnkSaveInfo2" onclick="JSxSetStatusClickBnkSubmitInfo2('<?php echo $tRoute; ?>');" class="btn xCNBTNSubSave" type="submit"><?php echo language('bank/bank/bank','tBNKSave')?> </button>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-md-5 col-lg-5">
                <!-- ชื่อผ่อนชำระ -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('bank/bank/bank','tBNKTitleTableStmName')?></label>
                    <input
                      type="text"
                      class="form-control"
                      maxlength="100"
                      id="oetBnkStmName"
                      name="oetBnkStmName"
                      autocomplete="off"
                      placeholder="<?php echo language('bank/bank/bank','tBNKTitleTableStmName')?>"
                      data-validate-required ="<?php echo language('bank/bank/bank','tBNKTitleTableStmName')?>"
                      value="<?php echo $tStmName; ?>">
                      <input type="hidden" name="oetBnkCodeInfo2"  id="oetBnkCodeInfo2" value='<?=$tBnkCode?>' >
                      <input type="hidden" name="oetBnkStmSeq"  id="oetBnkStmSeq" value="<?php echo $nStmSeq; ?>" >
                </div>
                <!-- ชื่อผ่อนชำระ -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('bank/bank/bank','tBNKTitleTableStmLimit')?></label>
                    <input type="text" autocomplete="off" class="form-control text-right xCNInputNumericWithDecimal" maxlength="10" id="oetBnkStmLimit" name="oetBnkStmLimit"

                        placeholder="0"
                        value="<?php echo $tStmLimit; ?>"
                    >
                </div>
                <!-- จำนวนรอบการผ่อน -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('bank/bank/bank','tBNKTitleTableStmQty')?></label>
                    <input type="text" autocomplete="off" class="form-control text-right xCNInputNumericWithDecimal" maxlength="10" id="oetBnkStmQty" name="oetBnkStmQty"
                        placeholder="0"
                        value="<?php echo $tStmQty; ?>"
                    >
                </div>
                <!-- รูปแบบการผ่อน -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('bank/bank/bank','tBNKTitleTableStaUnit')?></label>
                    <select  required  class="selectpicker form-control" id="ocmBnkStmStaUnit" name="ocmBnkStmStaUnit">

                              <option value='1' <?php if ($tStmStaUnit=='1') { echo "selected"; } ?> >
                                  <?php echo language('bank/bank/bank','tBNKd')?>
                              </option>
                              <option value='2' <?php if ($tStmStaUnit=='2') { echo "selected"; } ?>>
                                  <?php echo language('bank/bank/bank','tBNKm')?>
                              </option>
                              <option value='3' <?php if ($tStmStaUnit=='3') { echo "selected"; } ?>>
                                  <?php echo language('bank/bank/bank','tBNKy')?>
                              </option>

                    </select>
                </div>

                <!-- อัตราดอกเบี้ย -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('bank/bank/bank','tBNKTitleTableStmRate')?></label>
                    <input type="text" class="form-control text-right xCNInputNumericWithDecimal" maxlength="100" min="0" id="oetBnkStmRate" name="oetBnkStmRate"
                        placeholder="0"
                        value="<?php echo $tStmRate; ?>"
                    >
                </div>
            </div>
        </div>
    </div>
</form>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
  $('#ocmBnkStmStaUnit').selectpicker();

  //กดยืนยัน
  function JSxSetStatusClickBnkSubmitInfo2(ptRoute){
    var nStaSession = JCNxFuncChkSessionExpired();

     if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
       $('#ofmAddBnkInfo2').validate().destroy();
       $('#ofmAddBnkInfo2').validate({
           rules: {
               oetBnkStmName:  {"required" :{}},
           },
           messages: {
               oetBnkStmName : {
                   "required"      : $('#oetBnkStmName').attr('data-validate-required'),
               },
           },
           errorElement: "em",
           errorPlacement: function (error, element ) {
               error.addClass( "help-block" );
               if ( element.prop( "type" ) === "checkbox" ) {
                   error.appendTo( element.parent( "label" ) );
               } else {
                   var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                   if(tCheck == 0){
                       error.appendTo(element.closest('.form-group')).trigger('change');
                   }
               }
           },
           highlight: function(element, errorClass, validClass) {
               $(element).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
           },
           unhighlight: function(element, errorClass, validClass) {
               $(element).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
           },
           submitHandler: function(form){
               $.ajax({
                   type     : "POST",
                   url      : ptRoute,
                   data     : $('#ofmAddBnkInfo2').serialize(),
                   cache    : false,
                   timeout  : 0,
                   success  : function(tResult){
                        JCNxCloseLoading();
                         var aReturn = JSON.parse(tResult);
                        if(aReturn['nStaEvent'] == 1){
                            $("#obtCallBackInfo2").click();
                        }else{
                            JCNxCloseLoading();
                            FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                        }
                   },
                   error: function(jqXHR, textStatus, errorThrown) {
                       JCNxResponseError(jqXHR, textStatus, errorThrown);
                   }
               });
           }
       });
     }else {
       JCNxShowMsgSessionExpired();
     }
  }
</script>
