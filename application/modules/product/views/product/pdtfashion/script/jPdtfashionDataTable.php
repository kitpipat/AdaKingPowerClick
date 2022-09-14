<script>
$('#obtPdtClrSzeAdd').unbind().click(function(){
    JSvFhnPdtCallPageAdd();
});

$('#obtPdtClrSzeBack').unbind().click(function(){
    JSvFhnPdtClrPszLoadDataTable();
});

$('#olbFhnPdtClrSzeTitle').unbind().click(function(){
    JSvFhnPdtClrPszLoadDataTable();
});


function JSvFhnPdtCallPageAdd(){
    var ptPdtCode = $('#oetPdtCode').val();
         // Check Login Expried
    var nStaSession = JCNxFuncChkSessionExpired();
    JCNxOpenLoading();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
    $.ajax({
        type: "POST",
        url: 'pdtFashionPageAdd',
        data: {
                    tPdtCode: ptPdtCode
                },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvPdtColorSizeDataTable').html(tResult);
            JSvFhnPdtBtnControl();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

    } else {
            JCNxShowMsgSessionExpired();
    }

}

//JSvFhnPdtBtnControl
function JSvFhnPdtBtnControl(){

    if($('#ohdPdtClrSzeEvent').val()=='pdtFashionEventAdd'){
              $('#olbPdtClrSzeAdd').removeClass('xCNHide');
            }else{
              $('#olbPdtClrSzeEdit').removeClass('xCNHide');
            }
            $('#obtPdtFashionBack').addClass('xCNHide');
            $('#obtPdtFashionSave').addClass('xCNHide');
            $('#obtPdtClrSzeAdd').addClass('xCNHide');
            $('.odvPdtClrSzePanelSheach').addClass('xCNHide');
            $('#obtPdtClrSzeBack').removeClass('xCNHide');
            $('#obtPdtClrSzeSave').removeClass('xCNHide');
            $('#olbFhnPdtClrSzeTitle').removeClass('xCNLabelFrm');
            
            $('#olbFhnPdtClrSzeTitle').css('color','#0081c2');
            $('#ofmAddEditProductFashion').hide();
            

}



function JSvFhnPdtClrSzePageEdit(ptPdtCode,ptRefCode,pnSeq){
   // Check Login Expried
    var nStaSession = JCNxFuncChkSessionExpired();
    JCNxOpenLoading();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
    $.ajax({
        type: "POST",
        url: 'pdtFashionPageEdit',
        data: {
                    tPdtCode:  ptPdtCode,
                    tRefCode:  ptRefCode,
                    nSeq    :  pnSeq
                },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvPdtColorSizeDataTable').html(tResult);
            JSvFhnPdtBtnControl();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

    } else {
            JCNxShowMsgSessionExpired();
    }
}


function JSvFhnPdtClrSzePageDelete(ptPdtCode, ptRefCode , pnSeq) {
var nStaSession = JCNxFuncChkSessionExpired();
if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
    $('#odvModalDeletePdtFashion #ospTextConfirmDelPdtFashion').html($('#oetTextComfirmDeleteSingle').val()  + ' (' + ptRefCode + ')');
    $('#odvModalDeletePdtFashion').modal('show');
    $('#odvModalDeletePdtFashion #osmConfirmDelPdtFashion').unbind().click(function() {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "pdtFashionEvenDelete",
            data: {
                ptPdtCode: ptPdtCode,
                ptRefCode: ptRefCode,
                pnSeq : pnSeq,
            },
            async: false,
            cache: false,
            timeout: 0,
            success: function(oReslut) {
                var aReslut = JSON.parse(oReslut);
      
                    JSvFhnPdtClrPszLoadDataTable();
                    $('.modal-backdrop').remove();
                    if(aReslut['nStaEvent']!='1'){
                    alert(aReslut['tStaMessg']);
                    }
             
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    });
} else {
    JCNxShowMsgSessionExpired();
}
}

// Function: Func. Add BarCode In Unit Pack
// Parameters: Obj Event Click
// Creator:	12/02/2019 wasin(Yoshi)
// LastUpdate: 13/02/2019 wasin(Yoshi)
// Return: -
// Return Type: -
function JSxPdtFhnCallModalAddEditBardCode(oEvent,tCallAddOrEdit){
    var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxFhnPdtModalBarCodeClear();
            $('.xWModalBarCodeDataTable').html('');
            // Set Add/Edit In Input Hidden In Modal Add Bracode
            // $('#ohdModalAebStaCallAddOrEdit').val(tCallAddOrEdit);
            if (tCallAddOrEdit == 'Add') {
                // Get Data Unit Pack Size And Add Value Into Input And Append Text Label Unit Title
                var tAebPdtCode = $('#oetPdtCode').val();
                var tAebRefCode = $(oEvent).data('refcode');
                var tAebRefSeq = $(oEvent).data('refseq');
                var tFabname    = $(oEvent).data('fabname');
                var tSeaname    = $(oEvent).data('seaname');
                var tClrname    = $(oEvent).data('clrname');
                var tPszname = $(oEvent).data('pszname');

                
                JCNxOpenLoading();
                JSxFhnPdtGetBarCodeDataByID(tAebPdtCode, tAebRefCode,tAebRefSeq);

                $('#ohdFhnModalFTRefCode').val(tAebRefCode);
                $('#ohdFhnModalFTPdtCode').val(tAebPdtCode);
                $('#ohdFhnModalFTRefSeq').val(tAebRefSeq);
                $('#ospFhnTxtPdtCode').text(tAebPdtCode);
                $('#ospFhnTxtPdtName').text($('#odvFnhPdtName').text());
                $('#ospFhnTxtPdtFabric').text(tFabname);
                $('#ospFhnTxtPdtSeason').text(tSeaname);
                $('#ospFhnTxtPdtColor').text(tClrname);
                $('#ospFhnTxtPdtSize').text(tPszname);
                $('#ospFhnTxtRefCode').text(tAebRefCode);
                // $('#ospFhnTxtPunName').text(tAebUnitName);

                $("#odvModalPdtFashionAddEditBarCode #olbFhnModalAebUnitTitle").text('<?php echo language("product/product/product", "tPDTViewPackMDUnit"); ?>' + " : " + tAebRefCode);
       

                // Show Modal
                $('#odvModalPdtFashionAddEditBarCode').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#odvModalPdtFashionAddEditBarCode').modal('show');
                $.getScript("application/modules/common/assets/src/jFormValidate.js");
            } else if (tCallAddOrEdit == 'Edit') {
     
            } else {}
        } else {
            JCNxShowMsgSessionExpired();
        }

}


function JSxFhnPdtGetBarCodeDataByID(ptPdtCode, ptRefCode , ptRefSeq) {
    $.ajax({
        type: "POST",
        url: "pdtFashionBarCodeGetDataTable",
        data: {
            'ptPdtCode': ptPdtCode,
            'ptRefCode': ptRefCode,
            'ptRefSeq' : ptRefSeq,
        },
        async: false,
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('.xWModalBarCodeDataTable').html(tResult);
            // $('#oetFhnModalAebBarCode').focus();
            JCNxCloseLoading();
            JSxPdtModalBarCodeClear();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


function JSxFhnPdtModalBarCodeClear() {
    $('#oetFhnEditData').val('0');
    $('#oetFhnModalAebBarCode').val('');
    $('#oetFhnModalAebOldBarCode').val('');
    $('#oetFhnModalAebPunCode').val('');
    $('#oetFhnModalAebPunName').val('');
    $('#oetFhnModalAebPlcCode').val('');
    $('#oetFhnModalAebPlcName').val('');
    $('#oetFhnModalAesSplCode').val('');
    $('#oetFhnModalAesSplName').val('');
    $('#ocbFhnModalAebBarStaUse').prop("checked", true);
    $('#ocbFhnModalAebBarStaAlwSale').prop("checked", true);
    $('#ocbFhnModalAesSplStaAlwPO').prop("checked", true);
    $('#oetFhnModalAebBarCode').parents('.form-group').removeClass("has-error");
    $('#oetFhnModalAebBarCode').parents('.form-group').removeClass("has-success");
    $('#oetFhnModalAebBarCode').parents('.form-group').find(".help-block").fadeOut('slow').remove();
}





$('.xWFhnPDTSubmitAddBar').off('click');
    $('.xWFhnPDTSubmitAddBar').on('click', function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxPhnPdtSaveBarCodeInUnitPack();
        } else {
            JCNxShowMsgSessionExpired();
        }
    });



    // Function: Func.Save BarCode In Unit Pack
    // Parameters: Obj Event Click
    // Creator:	12/02/2019 wasin(Yoshi)
    // LastUpdate: 13/02/2019 wasin(Yoshi)
    // Return: -
    // Return Type: -
    // ohdErrMsgNotHasUnitSmall
    function JSxPhnPdtSaveBarCodeInUnitPack() {
        $('#ofmFhnModalAebBarCode').validate({
            rules: {
                oetFhnModalAebBarCode: "required",
                oetFhnModalAebPunName: "required",
                // oetFhnModalAebUnitFact: "required"
            },
            messages: {
                oetFhnModalAebBarCode: {
                    "required": $('#oetFhnModalAebBarCode').attr('data-validate-required'),
                },
                oetFhnModalAebPunName: {
                    "required": $('#oetFhnModalAebPunName').attr('data-validate-required'),
                },
                // oetFhnModalAebUnitFact: {
                //     "required": $('#oetFhnModalAebUnitFact').attr('data-validate-required'),
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
            submitHandler: function(form) {

                var tBarStaUse = 0;
                var tBarStaAlwSale = 0;
                var tSplStaAlwPO = 0;

                if ($('#ocbFhnModalAebBarStaUse').prop("checked")==true) {
                    tBarStaUse = '1';
                } else {
                    tBarStaUse = '';
                }
                if ($('#ocbFhnModalAebBarStaAlwSale').prop("checked")==true) {
                    tBarStaAlwSale = '1';
                } else {
                    tBarStaAlwSale = '';
                }
                if ($('#ocbFhnModalAesSplStaAlwPO').prop("checked")==true) {
                    tSplStaAlwPO = '1';
                } else {
                    tSplStaAlwPO = '';
                }

                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "pdtFashionUpdateBarCode",
                    data: {
                        'FTPdtCode': $('#ohdFhnModalFTPdtCode').val(),
                        'FTBarCode': $('#oetFhnModalAebBarCode').val(),
                        'tOldBarCode': $('#oetFhnModalAebOldBarCode').val(),
                        'FTFhnPdtRefCode': $('#ohdFhnModalFTRefCode').val(),
                        'FNBarRefSeq':$('#ohdFhnModalFTRefSeq').val(),
                        'FTPunCode': $('#oetFhnModalAebPunCode').val(),
                        // 'FCPdtUnitFact': $('#oetFhnModalAebUnitFact').val(),
                        'FTPlcCode': $('#oetFhnModalAebPlcCode').val(),
                        'FTPlcName': $('#oetFhnModalAebPlcName').val(),
                        'FTSplCode': $('#oetFhnModalAesSplCode').val(),
                        'FTSplName': $('#oetFhnModalAesSplName').val(),
                        'StatusAddEdit': $('#oetFhnEditData').val(),
                        'FTBarStaUse': tBarStaUse,
                        'FTBarStaAlwSale': tBarStaAlwSale,
                        'FTSplStaAlwPO': tSplStaAlwPO
                    },
                    async: false,
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aReturn = JSON.parse(oResult);

                        if (aReturn['nStaQuery'] == 1) {
                            var PdtCode = $('#ohdFhnModalFTPdtCode').val();
              
                            JSxFhnPdtGetBarCodeDataByID($('#ohdFhnModalFTPdtCode').val(), $('#ohdFhnModalFTRefCode').val(),$('#ohdFhnModalFTRefSeq').val());
    
                            var nCount = parseInt($('#ohdFhnPdtBarCodeRow' + $('#ohdFhnModalFTRefCode').val()).val());
                            $('#ohdFhnPdtBarCodeRow' + $('#ohdFhnModalFTRefCode').val()).val(nCount + 1);
                            JSxFhnPdtModalBarCodeClear();
                            JCNxCloseLoading();
                        } else {
                            JCNxCloseLoading();
                            alert(aReturn['tStaMessg']);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
    }
    



        // Event Browse Location In Modal
        $('#obtFhnModalAebBrowsePdtLocation').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            // Create By Witsarut 04/10/2019
            JSxCheckPinMenuClose();
            // Create By Witsarut 04/10/2019
            $('#odvModalPdtFashionAddEditBarCode').modal("hide");
            window.oPdtBrowseLocationOption = oPdtBrowseLocation({
                'tReturnInputCode': 'oetFhnModalAebPlcCode',
                'tReturnInputName': 'oetFhnModalAebPlcName',
                'tNextFuncName': 'JSxFhnShowModalAddBarCode'
            })
            JCNxBrowseData('oPdtBrowseLocationOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });



    // Function: Func. Call Back Show Modal Add BarCode
    // Parameters: Obj Event Click
    // Creator:	12/02/2019 wasin(Yoshi)
    // Return: Open Pop Up Modal Manage PackSize Unit
    // Return Type: -
    function JSxFhnShowModalAddBarCode() {
        // Clear Validate BarCode Input
        $('#odvModalPdtFashionAddEditBarCode').parents('.form-group').removeClass("has-error");
        $('#odvModalPdtFashionAddEditBarCode').parents('.form-group').removeClass("has-success");
        $('#odvModalPdtFashionAddEditBarCode').parents('.form-group').find(".help-block").fadeOut('slow').remove();
        // Clear Validate Product Location Input
        $('#oetFhnModalAebPlcName').parents('.form-group').removeClass("has-error");
        $('#oetFhnModalAebPlcName').parents('.form-group').removeClass("has-success");
        $('#oetFhnModalAebPlcName').parents('.form-group').find(".help-block").fadeOut('slow').remove();
        $('#odvModalPdtFashionAddEditBarCode').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#odvModalPdtFashionAddEditBarCode').modal("show");
    }



        // Event Browse Supplier In Modal
        $('#obtFhnModalAebBrowsePdtSupplier').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            $('#odvModalPdtFashionAddEditBarCode').modal("hide");
            window.oPdtBrowseSupplierOption = oPdtBrowseSupplier({
                'tReturnInputCode': 'oetFhnModalAesSplCode',
                'tReturnInputName': 'oetFhnModalAesSplName',
                'tNextFuncName': 'JSxFhnShowModalAddEditSupplier'
            })
            JCNxBrowseData('oPdtBrowseSupplierOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
        });




        
        // Event Browse PackSize In Modal
        $('#obtFhnModalAebBrowsePdtPackSize').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            $('#odvModalPdtFashionAddEditBarCode').modal("hide");
            window.oPdtBrowsePackSizeOption = oPdtBrowsePackSize({
                'tReturnInputCode': 'oetFhnModalAebPunCode',
                'tReturnInputName': 'oetFhnModalAebPunName',
                'tNextFuncName': 'JSxFhnShowModalAddEditPackSize'
            })
            JCNxBrowseData('oPdtBrowsePackSizeOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
        });



            // Option Add Browse Product Event Not Sale
    var oPdtBrowsePackSize = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;
        var tNextFuncName = poReturnInput.tNextFuncName;
        var tFhnPdtCode =  $('#oetFhnPdtCode').val();
        var oOptionReturn = {
            Title: ['product/product/product', 'tPDTTBUnit'],
            Table: {
                Master: 'TCNMPdtPackSize',
                PK: 'FTPunCode',
            },
            Join: {
                Table: ['TCNMPdtUnit_L'],
                On: [
                    'TCNMPdtPackSize.FTPunCode = TCNMPdtUnit_L.FTPunCode AND TCNMPdtUnit_L.FNLngID = ' + nLangEdits,
                ]
        },
            Where: {
                Condition: ["AND TCNMPdtPackSize.FTPdtCode = '" + tFhnPdtCode + " '"]
            },
            GrideView: {
                ColumnPathLang: 'product/product/product',
                ColumnKeyLang: ['tPDTTBCode', 'tPDTTBUnit'],
                ColumnsSize: ['20%', '80%'],
                DataColumns: ['TCNMPdtPackSize.FTPunCode', 'TCNMPdtUnit_L.FTPunName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMPdtPackSize.FTPunCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMPdtPackSize.FTPunCode"],
                Text: [tInputReturnName, "TCNMPdtUnit_L.FTPunName"],
            },
            NextFunc: {
                FuncName: tNextFuncName
            },
            BrowseLev: 1
        }
        return oOptionReturn;
    }




    // Function: Func. Call Back In Browse Show Modal Add Edit Supplier
    // Parameters: Obj Event Click
    // Creator:	12/02/2019 wasin(Yoshi)
    // Return: Open Pop Up Modal Manage PackSize Unit
    // Return Type: -
    function JSxFhnShowModalAddEditSupplier() {
        $('#odvModalPdtFashionAddEditBarCode #oetFhnModalAesSplName').parents('.form-group').removeClass("has-error");
        $('#odvModalPdtFashionAddEditBarCode #oetFhnModalAesSplName').parents('.form-group').removeClass("has-success");
        $('#odvModalPdtFashionAddEditBarCode #oetFhnModalAesSplName').parents('.form-group').find(".help-block").fadeOut('slow').remove();

        $('#odvModalPdtFashionAddEditBarCode').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#odvModalPdtFashionAddEditBarCode').modal("show");
    }



    // Function: Func. Call Back In Browse Show Modal Add Edit Supplier
    // Parameters: Obj Event Click
    // Creator:	12/02/2019 wasin(Yoshi)
    // Return: Open Pop Up Modal Manage PackSize Unit
    // Return Type: -
    function JSxFhnShowModalAddEditPackSize() {
        $('#odvModalPdtFashionAddEditBarCode #oetFhnModalAebPunName').parents('.form-group').removeClass("has-error");
        $('#odvModalPdtFashionAddEditBarCode #oetFhnModalAebPunName').parents('.form-group').removeClass("has-success");
        $('#odvModalPdtFashionAddEditBarCode #oetFhnModalAebPunName').parents('.form-group').find(".help-block").fadeOut('slow').remove();

        $('#odvModalPdtFashionAddEditBarCode').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#odvModalPdtFashionAddEditBarCode').modal("show");
    }




    function JSxFhnModalPdtBarCodeEdit(ptBarCode) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            var FTBarStaUse = $('#ohdFhnModalFTBarStaUse' + ptBarCode).val();
            var FTBarStaAlwSale = $('#ohdFhnModalFTBarStaAlwSale' + ptBarCode).val();
            var FTSplStaAlwPO = $('#ohdFhnModalFTSplStaAlwPO' + ptBarCode).val();
            $('#oetFhnEditData').val(1);
            $('#oetFhnModalAebBarCode').val(ptBarCode);
            $('#oetFhnModalAebOldBarCode').val(ptBarCode);
            $('#oetFhnModalAebPunCode').val($('#ohdFhnModalFTPunCode' + ptBarCode).val());
            $('#oetFhnModalAebPunName').val($('#ohdFhnModalFTPunName' + ptBarCode).val());
            $('#ohdFhnModalFCPdtUnitFact').val($('#ohdFhnModalFCPdtUnitFact' + ptBarCode).val());
            $('#oetFhnModalAebPlcCode').val($('#ohdFhnModalFTPlcCode' + ptBarCode).val());
            $('#oetFhnModalAebPlcName').val($('#ohdFhnModalFTPlcName' + ptBarCode).val());
            $('#oetFhnModalAesSplCode').val($('#ohdFhnModalFTSplCode' + ptBarCode).val());
            $('#oetFhnModalAesSplName').val($('#ohdFhnModalFTSplName' + ptBarCode).val());

            if (FTBarStaUse == 1) {
                $('#ocbFhnModalAebBarStaUse').prop("checked", true);
            } else {
                $('#ocbFhnModalAebBarStaUse').prop("checked", false);
            }

            if (FTBarStaAlwSale == 1) {
                $('#ocbFhnModalAebBarStaAlwSale').prop("checked", true);
            } else {
                $('#ocbFhnModalAebBarStaAlwSale').prop("checked", false);
            }

            if (FTSplStaAlwPO == 1) {
                $('#ocbFhnModalAesSplStaAlwPO').prop("checked", true);
            } else {
                $('#ocbFhnModalAesSplStaAlwPO').prop("checked", false);
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }


    function JSxFhnModalPdtBarCodeDelete(ptBarCode) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            var tPdtCode = $('#ohdFhnModalFTPdtCode').val();
            var tFhnRefCode = $('#ohdFhnModalFTRefCode').val();
            var tFhnRefSeq = $('#ohdFhnModalFTRefSeq').val();
            $.ajax({
                type: "POST",
                url: "pdtFashionDeleteBarCode",
                data: {
                    FTBarCode: ptBarCode,
                    FTPdtCode: tPdtCode,
                    FNBarRefSeq: tFhnRefSeq
                },
                cache: false,
                timeout: 0,
                async: false,
                success: function(tResult) {
                    JSxFhnPdtGetBarCodeDataByID(tPdtCode, tFhnRefCode,tFhnRefSeq);
                    // $('.xWModalBarCodeDataTable').html(tResult);
                    var nCount = parseInt($('#ohdFhnPdtBarCodeRow' + tFhnRefCode).val());
                    $('#ohdFhnPdtBarCodeRow' + tFhnRefCode).val(nCount - 1);
                    JCNxCloseLoading();

        
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }



    $('#obtModalPdtFashionAddEditBarCodeClose').on('click', function () {
        // do something…
    
            JSvFhnPdtClrPszLoadDataTable();
        
    });
</script>