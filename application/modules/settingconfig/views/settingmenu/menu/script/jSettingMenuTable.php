<script type="text/javascript">
$(document).ready(function() {
    // ============== Module List Role =================
    $('#otbModuleMenu .xCNMenuGrpModule').unbind().one().click(function() {
        var nMenuKey = $(this).data('mgm');
        if ($('#otbModuleMenu .xCNDataMenuGrpModule[data-mgm=' + nMenuKey + ']').hasClass(
                'hidden')) {
            $('#otbModuleMenu .xCNDataMenuGrpModule[data-mgm=' + nMenuKey + ']').removeClass(
                'hidden').slideDown(500);
            $('#otbModuleMenu .xCNPlusMenuGrpModule[data-mgm=' + nMenuKey + ']').removeClass(
                'fa fa-plus');
            $('#otbModuleMenu .xCNPlusMenuGrpModule[data-mgm=' + nMenuKey + ']').addClass(
                'fa fa-minus');
        } else {
            $('#otbModuleMenu .xCNDataMenuGrpModule[data-mgm=' + nMenuKey + ']').slideUp(100,
                function() {
                    $(this).addClass('hidden');
                    $('#otbModuleMenu .xCNDataRole[data-mgm=' + nMenuKey + ']').addClass(
                        'hidden');
                    $('#otbModuleMenu .xCNDataRole[data-smc=' + nMenuKey + ']').addClass(
                        'hidden');
                    $('#otbModuleMenu .xCNPlusMenuGrp[data-smc=' + nMenuKey + ']').removeClass(
                        'fa fa-minus');
                    $('#otbModuleMenu .xCNPlusMenuGrp[data-smc=' + nMenuKey + ']').addClass(
                        'fa fa-plus');
                    $('#otbModuleMenu .xCNPlusMenuGrpModule[data-mgm=' + nMenuKey + ']')
                        .removeClass('fa fa-minus');
                    $('#otbModuleMenu .xCNPlusMenuGrpModule[data-mgm=' + nMenuKey + ']')
                        .addClass('fa fa-plus');
                    $('#otbModuleMenu .xCNPlusMenuGrp[data-mgm=' + nMenuKey + ']').removeClass(
                        'fa fa-minus');
                    $('#otbModuleMenu .xCNPlusMenuGrp[data-mgm=' + nMenuKey + ']').addClass(
                        'fa fa-plus');
                });
        }
    });

    // ============== Menugroup List Role =================
    $('#otbModuleMenu .xCNMenuGrp').unbind().one().click(function() {
        var nMenuKey = $(this).data('mgm');
        if ($('#otbModuleMenu .MenuList[data-mgm=' + nMenuKey + ']').hasClass('hidden')) {
            $('#otbModuleMenu .MenuList[data-mgm=' + nMenuKey + ']').removeClass('hidden')
                .slideDown(500);
            $('#otbModuleMenu .xCNPlusMenuGrp[data-mgm=' + nMenuKey + ']').removeClass(
                'fa fa-plus');
            $('#otbModuleMenu .xCNPlusMenuGrp[data-mgm=' + nMenuKey + ']').addClass('fa fa-minus');
        } else {
            $('#otbModuleMenu .xCNDataRole[data-mgm=' + nMenuKey + ']').slideUp(100, function() {
                $(this).addClass('hidden');
                $('#otbModuleMenu .xCNPlusMenuGrp[data-mgm=' + nMenuKey + ']').removeClass(
                    'fa fa-minus');
                $('#otbModuleMenu .xCNPlusMenuGrp[data-mgm=' + nMenuKey + ']').addClass(
                    'fa fa-plus');
            });
        }
    });

    // ========== Event Search Menu ==========
    $("#otbModuleMenu #oetSearchAll").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        console.log(value);
        $("#otbSMPDataBody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

//Functionality: Update StaUse
//Parameters: ส่งมาจากการคลิกปุ่มเปิดสถานะ
//Creator: 27/08/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function FSxSMUUpdateStaUse(status, tTableName, tFieldWhere, tFieldName, tCode) {
    JCNxOpenLoading();
    var nValueStaUse = '';

    switch (status) {
        case 1:
            if ($('input[menulist=' + tCode + ']').prop("checked") == true) {
                nValueStaUse = 1;
            } else {
                nValueStaUse = 0;
            }
            break;
        case 2:
            if ($('input[menulist=' + tCode + ']').prop("checked") == true) {
                nValueStaUse = 1;
            } else {
                nValueStaUse = 0;
            }
            break;
        case 3:
            if ( $('input[menulist=' + tCode + ']').prop("checked") == true ) {
                nValueStaUse = 1;
            } else {
                nValueStaUse = 0;
            }
            break;
        default:
            // code block
    }

    $.ajax({
        type: "POST",
        url: "UpdateStaUse",
        data: {
            tTableName: tTableName,
            tFieldWhere: tFieldWhere,
            tFieldName: tFieldName,
            tCode: tCode,
            nValue: nValueStaUse
        },
        async: false,
        cache: false,
        timeout: 0,
        success: function(tResult) {
            var aResult = JSON.parse(tResult);
            if (aResult['nStaEvent'] == 1) {

                switch (status) {
                    //Module
                    case 1:
                        if ($('input[module=' + tCode + ']').is(':checked')) {
                            $('input[test=' + tCode + ']').each(function() {
                                var tMenugrp= ($(this).attr("menugrp"))
                                if ($('input[menugrp=' + tMenugrp + ']').is(':checked')) {
                                    $('[data-id=' + tMenugrp + ']').removeClass('hidden');
                                    $('[data-mod=' + tMenugrp + ']').show();
                                    $('[data-td-delmenugrp=' + tMenugrp + ']').addClass('xWTdDisable');
                                    $('[data-img-delmenugrp=' + tMenugrp + ']').addClass(
                                        'xWImgDisable');
                                } else {
                                    $('[data-id=' + tMenugrp + ']').addClass('hidden');
                                    $('[data-mod=' + tMenugrp + ']').hide();
                                    $('[data-td-delmenugrp=' + tMenugrp + ']').removeClass(
                                        'xWTdDisable');
                                    $('[data-img-delmenugrp=' + tMenugrp + ']').removeClass(
                                        'xWImgDisable');
                                }
                                // console.log($(this).input('menugrp'));
                            });
                            $('[data-id=' + tCode + ']').removeClass('hidden');
                            $('[data-grp=' + tCode + ']').removeClass('hidden');
                            $('[data-mod=' + tCode + ']').show();
                            $('[data-td-delmod=' + tCode + ']').addClass('xWTdDisable');
                            $('[data-img-delmod=' + tCode + ']').addClass('xWImgDisable');
                        } else {
                            $('[data-id=' + tCode + ']').addClass('hidden');
                            $('[data-grp=' + tCode + ']').addClass('hidden');
                            $('[data-mod=' + tCode + ']').hide();
                            $('[data-td-delmod=' + tCode + ']').removeClass('xWTdDisable');
                            $('[data-img-delmod=' + tCode + ']').removeClass('xWImgDisable');
                        }
                        break;
                    //กลุ่มเมนู
                    case 2:
                        if ($('input[menugrp=' + tCode + ']').is(':checked')) {
                            $('[data-id=' + tCode + ']').removeClass('hidden');
                            $('[data-mod=' + tCode + ']').show();
                            $('[data-td-delmenugrp=' + tCode + ']').addClass('xWTdDisable');
                            $('[data-img-delmenugrp=' + tCode + ']').addClass('xWImgDisable');
                        } else {
                            $('[data-id=' + tCode + ']').addClass('hidden');
                            $('[data-mod=' + tCode + ']').hide();
                            $('[data-td-delmenugrp=' + tCode + ']').removeClass('xWTdDisable');
                            $('[data-img-delmenugrp=' + tCode + ']').removeClass('xWImgDisable');
                        }
                        break;
                    //เมนู
                    case 3:
                        if ($('input[menulist=' + tCode + ']').is(':checked')) {
                            $('[data-td-delmenulist=' + tCode + ']').addClass('xWTdDisable');
                            $('[data-img-delmenulist=' + tCode + ']').addClass('xWImgDisable');
                        } else {
                            $('[data-td-delmenulist=' + tCode + ']').removeClass('xWTdDisable');
                            $('[data-img-delmenulist=' + tCode + ']').removeClass('xWImgDisable');
                        }
                        break;
                    default:
                        // code block
                }
                JCNxCloseLoading();
            } else {
                alert(aResult['tStaMessg'])
            }

        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


//Functionality: Call Max sequence
//Parameters: from function
//Creator: 27/08/2020 Sooksanti(Non)
//Return: -
//ReturnType: -
function FSxSMUMaxSequence(tTableName, tFieldWhere, tFieldName, tCode) {
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "CallMaxValueSequence",
        data: {
            tTableName: tTableName,
            tFieldWhere: tFieldWhere,
            tFieldName: tFieldName,
            tCode: tCode,
        },
        async: false,
        cache: false,
        timeout: 0,
        success: function(tResult) {
            var aResult = JSON.parse(tResult);
            if (aResult['nStaEvent'] == 1) {
                JCNxCloseLoading();
                nMaxsequence = parseInt(aResult['aData'][0][tFieldName])
                if (aResult['aData'][0][tFieldName] == null) {
                    nMaxsequence = 0;
                }
                return nMaxsequence;
            } else {
                alert(aResult['tStaMessg'])
            }

        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}
</script>
