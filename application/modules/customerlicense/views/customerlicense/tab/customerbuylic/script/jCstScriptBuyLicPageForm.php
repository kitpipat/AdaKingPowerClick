<script type="text/javascript">

$('#oliCstBuyLic').unbind().click(function(){
	JSvCBLCstBuyLicGetPageList();
});

// DATE
$('#otbLicStart').click(function(){
event.preventDefault();
$('#oedLicStart').datepicker('show');
});

// DATE
$('#obtLicFinish').click(function(){
event.preventDefault();
$('#oedLicFinish').datepicker('show');
});


//เนลแก้ไขให้เลือกวันที่น้อยกว่าวันปัจจุบัน
$('.xCNDatePicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    startDate:'1900-01-01',
});

$('#obtPosActivate').on('click',function(){


    var rtCstCode    = $('#oetCstCode').val();
    var rnLicUUIDSeq = $('#ohdLicUUIDSeq').val();
    var rtLicRefUUID = $('#oetLicRefUUID').val();
    var rtCbrRefBch = $('#oetCbrRefBch').val();
    
    var nValidater = 0;
    if($('#oetCbrRefBch').val()==''){
        FSvCMNSetMsgWarningDialog($('#oetCbrRefBch').data('validate'));
        nValidater = 1;
    }

    if($('#oetLicRefUUID').val()==''){
        FSvCMNSetMsgWarningDialog($('#oetLicRefUUID').data('validate'));
        nValidater = 3;
    }
    if(nValidater==0){
        JCNxOpenLoading();
      $.ajax({
          type: "POST",
          url: 'customerBuyLicActivatePos',
          cache: false,
          timeout: 0,
          data:{rtCstCode:rtCstCode ,rtLicRefUUID:rtLicRefUUID,rnLicUUIDSeq:rnLicUUIDSeq,rtCbrRefBch:rtCbrRefBch },
          success: function(tResult) {
            var aReturn = JSON.parse(tResult);
            if(aReturn['rtCode']=='001'){
                var oBlob=new Blob([tResult]);
                    var oLink=document.createElement('a');
                    oLink.href=window.URL.createObjectURL(oBlob);
                    oLink.download=rtCstCode+"ActiveDevice.json";
                    oLink.click();
                FSvCMNSetMsgSucessDialog('Success');
                // JSxCBLCstBuyLicAddUpdateEvent();
                JSvCBLCstBuyLicGetPageList();
            }else{
                FSvCMNSetMsgSucessDialog(aReturn['rtDesc']);
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
          }
      });
    }
});



$('#ocmCbrRefBc').on('change',function(){
   var tBchRefCode = $(this).val();
   $('#oetCbrRefBch').val(tBchRefCode);
});
</script>
