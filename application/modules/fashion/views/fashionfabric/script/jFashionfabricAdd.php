<script type="text/javascript">
    $('.selection-2').selectpicker();

    $(document).ready(function() {
        if (JSbChnIsCreatePage()) { 
            // Chn Code
            $("#oetFabCode").attr("disabled", true);
            $('#ocbFashionFabricAutoGenCode').change(function() {
                if ($('#ocbFashionFabricAutoGenCode').is(':checked')) {
                    $('#oetFabCode').val('');
                    $("#oetFabCode").attr("disabled", true);
                    $('#odvFashionfabricCodeForm').removeClass('has-error');
                    $('#odvFashionfabricCodeForm em').remove();
                } else {
                    $("#oetFabCode").attr("disabled", false);
                }
            });
            JSxChnVisibleComponent('#odvFashionFabricAutoGenCode', true);
        }

        if (JSbChnIsUpdatePage()) {
            // Sale Person Code
            $("#oetFabCode").attr("readonly", true);
            $('#odvFashionFabricAutoGenCode input').attr('disabled', true);
            JSxChnVisibleComponent('#odvFashionFabricAutoGenCode', false);
        }

        $('#oetFabCode').blur(function() {
            JSxCheckChnCodeDupInDB();
        });

    });

    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckChnCodeDupInDB() {
        if (!$('#ocbFashionFabricAutoGenCode').is(':checked')) {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: {
                    tTableName: "TFHMPdtFabric",
                    tFieldName: "FTFabCode",
                    tCode: $("#oetFabCode").val()
                },
                async: false,
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateFabCode").val(aResult["rtCode"]);
                    JSxChnSetValidEventBlur();
                    $('#ofmAddChanel').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }

    //Functionality: Set Validate Event Blur
    //Parameters: Validate Event Blur
    //Creator: 26/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxChnSetValidEventBlur() {
        $('#ofmAddChanel').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if ($("#ohdCheckDuplicateFabCode").val() == 1) {
                return false;
            } else {
                return true;
            }
        }, '');

        // From Summit Validate
        $('#ofmAddChanel').validate({
            rules: {
                oetFabCode: {
                    "required": {
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if ($('#ocbFashionFabricAutoGenCode').is(':checked')) {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    },
                    "dublicateCode": {}
                },
                oetChnTitle: {
                    "required": {}
                },
                // ocmRcnGroup:    {"required" :{}},
            },
            messages: {
                oetFabCode: {
                    "required": $('#oetFabCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetFabCode').attr('data-validate-dublicateCode')
                },
                oetChnTitle: {
                    "required": $('#oetChnTitle').attr('data-validate-required'),
                }
                // ocmRcnGroup: {
                //     "required"      : $('#osmSelect').attr('data-validate-required'),
                // }
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
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
            highlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
            },
            unhighlight: function(element, errorClass, validClass) {
                var nStaCheckValid = $(element).parents('.form-group').find('.help-block').length
                if (nStaCheckValid != 0) {
                    $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
                }
            },
            submitHandler: function(form) {}
        });
    }


</script>