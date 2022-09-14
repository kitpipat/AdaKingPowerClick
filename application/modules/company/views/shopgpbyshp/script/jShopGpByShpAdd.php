<script type="text/javascript">
    var tAlwEventShopGpByShp    = '<?php echo json_encode($aAlwEventShopGpByShp) ?>;'
    var aAlwEventShopGpByShp    = JSON.parse(tAlwEventShopGpByShp.replace(';',''));
    $(document).ready(function () {
        //JSxSHPNavDefult();
        // Hide Btn Add
        $('.selectpicker').selectpicker();
        // Set Date Picker

    });
 
    //เลือก สาขา
    $('#ocmShopGpByShpBchCode').bind('change', function(ev) {
        $ptOcmBchCode            =  $("#ocmShopGpByShpBchCode option:selected" ).text();
        $pnPageShpCallBack       =  $("ohdShopGpByShpPageShpCallBack").val();  
        JSvCallPageShopGpByShpDataTable($pnPageShpCallBack,$ptOcmBchCode);
    });

    //เช็ค ปุ่ม
    $('#obtAddShopGpToTable').click(function(even){
        FSvSHPValidatorAddGpByShp();
    });

    //เช็ค ปุ่ม
    function FSvSHPValidatorAddGpByShp(){
            $('#ofmAddGpByShp').validate({
                focusInvalid: true,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetShopGpByShpDateStart : {
                    "required": true
                    }
                },
                messages: {
                    oetShopGpByShpDateStart : {
                    "required": "กรุณากรอกวันที่มีผล!"
                    }
                },
                errorElement: "em",
                errorPlacement: function (error, element) {
                    error.addClass("help-block");
                    if (element.prop("type") === "checkbox") {
                    error.appendTo(element.parent("label"));
                    } else {
                    var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                    if (tCheck == 0) {
                        error.appendTo(element.closest('.form-group')).trigger('change');
                    }
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).closest('.form-group').addClass("has-error");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).closest('.form-group').removeClass("has-error");
                },
                submitHandler: function (form)
                {
                    JSoAddGpByShop();
            }    
        });
        $("#ofmAddGpByShp").submit();
    }

    //Page Add product Shop GP By SHOP
    // $('#obtShopGpByShp').click(function(){
    function  JSvCallPageShopByGpAdd(){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "CmpShopGpByShppageAdd",
            data: {
                tBchCode           : $('#ohdShopGpByShpBchCode').val(),
                tShpCode           : $('#ohdShopGpByShpShpCode').val(),
                tPageEvent         : 'PageAdd'
            },
            success: function (oResult) {
                $('#odvSetionShopGPByShp').html(oResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
    // });

</script>