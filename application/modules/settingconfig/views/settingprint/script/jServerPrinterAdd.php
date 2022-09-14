<script type="text/javascript">
    $(document).ready(function() {

        if (JSbSrvPriIsCreatePage()) {
            //Server Printer Code
            $("#oetSrvPriCode").attr("disabled", true);
            $('#ocbSrvPriAutoGenCode').change(function() {
                if ($('#ocbSrvPriAutoGenCode').is(':checked')) {
                    $('#oetSrvPriCode').val('');
                    $("#oetSrvPriCode").attr("disabled", true);
                    $('#odvSrvPriCodeForm').removeClass('has-error');
                    $('#odvSrvPriCodeForm em').remove();
                } else {
                    $("#oetSrvPriCode").attr("disabled", false);
                }
            });
            JSxSrvPriVisibleComponent('#odvSrvPriAutoGenCode', true);
        }

        if (JSbSrvPriIsUpdatePage()) {

            // Server Printer  Code
            $("#oetSrvPriCode").attr("readonly", true);
            $('#odvSrvPriAutoGenCode input').attr('disabled', true);
            JSxSrvPriVisibleComponent('#odvSrvPriAutoGenCode', false);
        }
    });

    // $('#oetSrvPriCode').blur(function(){
    //     JSxCheckDepartmentCodeDupInDB();
    // });

    //Functionality : Event Check Server Printer 
    //Parameters : Event Blur Input Server Printer  Code
    //Creator : 21/12/2021 Worakorn
    //Return : -
    //Return Type : -
    function JSxCheckServerPrinterCodeDupInDB(ptRoute) {
        if (!$('#ocbSrvPriAutoGenCode').is(':checked')) {
            // alert($("#oetSrvPriCode").val())
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: {
                    tTableName: "TCNMPrnServer",
                    tFieldName: "FTSrvCode",
                    tCode: $("#oetSrvPriCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateSrvPriCode").val(aResult["rtCode"]);
                    // $('#ofmAddSrvPri').validate().destroy();
                    // Set Validate Server Printer  Code
                    $.validator.addMethod('dublicateCode', function(value, element) {
                        if ($("#ohdCheckDuplicateSrvPriCode").val() == 1) {
                            return false;
                        } else {
                            return true;
                        }
                    }, '');

                    // From Summit Validate
                    $('#ofmAddSrvPri').validate({

                        rules: {
                            oetSrvPriCode: {
                                "required": {
                                    // ตรวจสอบเงื่อนไข validate
                                    depends: function(oElement) {
                                        if ($('#ocbSrvPriAutoGenCode').is(':checked')) {
                                            return false;
                                        } else {
                                            return true;
                                        }
                                    }
                                },
                                "dublicateCode": {}
                            },
                            oetSrvPriName: {
                                "required": {}
                            },
                        },
                        messages: {
                            oetSrvPriCode: {
                                "required": $('#oetSrvPriCode').attr('data-validate-required'),
                                "dublicateCode": $('#oetSrvPriCode').attr('data-validate-dublicateCode')
                            },
                            oetSrvPriName: {
                                "required": $('#oetSrvPriName').attr('data-validate-required'),
                            },
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
                            $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
                        },
                        submitHandler: function(form) {
                            alert('submitHandler');
                            JSxSrvPriAddUpdateInTable(ptRoute);
                        }
                    });

                    // Submit From
                    $('#ofmAddSrvPri').submit();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }
</script>