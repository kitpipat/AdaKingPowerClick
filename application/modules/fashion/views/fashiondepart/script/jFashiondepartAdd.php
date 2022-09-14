<script type="text/javascript">
    $('.selection-2').selectpicker();

    $(document).ready(function() {
        if (JSbChnIsCreatePage()) {
            // Chn Code
            $("#oetDepCode").attr("disabled", true);
            $('#ocbFashionDepartAutoGenCode').change(function() {
                if ($('#ocbFashionDepartAutoGenCode').is(':checked')) {
                    $('#oetDepCode').val('');
                    $("#oetDepCode").attr("disabled", true);
                    $('#odvFashionDepartCodeForm').removeClass('has-error');
                    $('#odvFashionDepartCodeForm em').remove();
                } else {
                    $("#oetDepCode").attr("disabled", false);
                }
            });
            JSxChnVisibleComponent('#odvFashionDepartAutoGenCode', true);
        }

        if (JSbChnIsUpdatePage()) {
            // Sale Person Code
            $("#oetDepCode").attr("readonly", true);
            $('#odvFashionDepartAutoGenCode input').attr('disabled', true);
            JSxChnVisibleComponent('#odvFashionDepartAutoGenCode', false);
        }

        $('#oetDepCode').blur(function() {
            JSxCheckChnCodeDupInDB();
        });

    });

    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckChnCodeDupInDB() {
        if (!$('#ocbFashionDepartAutoGenCode').is(':checked')) {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: {
                    tTableName: "TFHMPdtF1Depart",
                    tFieldName: "FTDepCode",
                    tCode: $("#oetDepCode").val()
                },
                async: false,
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateDepCode").val(aResult["rtCode"]);
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
            if ($("#ohdCheckDuplicateDepCode").val() == 1) {
                return false;
            } else {
                return true;
            }
        }, '');

        // From Summit Validate
        $('#ofmAddChanel').validate({
            rules: {
                oetDepCode: {
                    "required": {
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if ($('#ocbFashionDepartAutoGenCode').is(':checked')) {
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
                oetDepCode: {
                    "required": $('#oetDepCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetDepCode').attr('data-validate-dublicateCode')
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