var nDSHSALBrowseType = $("#ohdDSHSALBrowseType").val();
var tDSHSALBrowseOption = $("#ohdDSHSALBrowseOption").val();

$("document").ready(function() {
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose();
    if (typeof(nDSHSALBrowseType) != 'undefined' && nDSHSALBrowseType == 0) {

        $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            disableTouchKeyboard: true,
            autoclose: true
        });

        // Event Click Button Filter Date Data Form
        $('#obtDSHSALDateDataForm').unbind().click(function() {
            $('#oetDSHSALDateDataForm').datepicker('show');
        });

        // Event Click Button Filter Date Data To
        $('#obtDSHSALDateDataTo').unbind().click(function() {
            $('#oetDSHSALDateDataTo').datepicker('show');
        });


        $('#oetDSHSALDateDataForm').change(function() {
            JCNxOpenLoading();
            JSvDSHSALPageDashBoardMain();
        });

        $('#oetDSHSALDateDataTo').change(function() {
            JCNxOpenLoading();
            JSvDSHSALPageDashBoardMain();
        });

        // Event Click Navigater Title (คลิก Title ของเอกสาร)
        $('#oliDSHSALTitle').unbind().click(function() {
            let nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvDSHSALPageDashBoardMain();
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        JCNxOpenLoading();
        JSvDSHSALPageDashBoardMain();
    }
});

// Function: Call Main Page DashBoard
// Parameters: Document Ready Or Parameter Event
// Creator: 14/01/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JSvDSHSALPageDashBoardMain() {
    JCNxOpenLoading();
    const tDateDataForm = $('#oetDSHSALDateDataForm').val();
    const tDateDataTo = $('#oetDSHSALDateDataTo').val();
    const tAlwDashBoard = $('#ocmDSHSALAllows').val();
    $.ajax({
        type: "POST",
        url: "dashboardsaleMainPage",
        cache: false,
        data: {
            'ptDateDataForm': tDateDataForm,
            'ptDateDataTo': tDateDataTo,
            'ptAlwDashBoard' : tAlwDashBoard
        },
        timeout: 0,
        success: function(tResult) {
            $("#odvDSHSALContentPage").html(tResult);
            // Left Panel
            JSvDSHSALCallViewBillAllAndTotalSale();
            JSvDSHSALCallViewTotalSaleByRecive();
            // JSvDSHSALCallViewStockBarlance();
            JSvDSHSALCallViewTop10NewPdt();
            JSvDSHSALCallViewTop10BestSellerByValue();
            // Right Panel
            JSvDSHSALCallViewTotalSaleByPdtGrp();
            JSvDSHSALCallViewTotalSaleByPdtPty();
            JSvDSHSALCallViewTop10BestSeller();

            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function: Call Modal Option Modal Filter
// Parameters: Document Ready Or Parameter Event
// Creator: 31/01/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JSvDSHSALCallModalFilterDashBoard(ptFilterDataKey, ptFilterDataGrp) {
    $.ajax({
        type: "POST",
        url: "dashboardsaleCallModalFilter",
        data: {
            'ptFilterDataKey': ptFilterDataKey,
            'ptFilterDataGrp': ptFilterDataGrp,
        },
        cache: false,
        timeout: 0,
        success: function(ptViewModalHtml) {
            $('#odvDSHSALModalFilterHTML').html(ptViewModalHtml);
            $('#odvDSHSALModalFilter').modal({ backdrop: 'static', keyboard: false })
            $('#odvDSHSALModalFilter').modal('show');
        },
        error: function(xhr, status, error) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function: Confirm Filter DashBoard
// Parameters: Document Ready Or Parameter Event
// Creator: 06/02/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JCNxDSHSALConfirmFilter(ptFilterKey) {
    const tDateDataForm = $('#oetDSHSALDateDataForm').val();
    const tDateDataTo = $('#oetDSHSALDateDataTo').val();
    const tAlwDashBoard = $('#ocmDSHSALAllows').val();
    $.ajax({
        type: "POST",
        url: "dashboardsaleConfirmFilter",
        data: $('#odvDSHSALModalFilter #ofmDSHSALFormFilter').serialize() + "&ptDateDataForm=" + tDateDataForm + "&ptDateDataTo=" + tDateDataTo + "&ptAlwDashBoard="+tAlwDashBoard,
        cache: false,
        timeout: 0,
        success: function(paDataReturn) {
            const aDataReturn = JSON.parse(paDataReturn);
            $('#odvDSHSALModalFilter').modal('hide');
            JCNxDSHSALOpenLodingChart(ptFilterKey);
            setTimeout(function() {
                switch (aDataReturn['rtDSHSALTypeKey']) {
                    case 'FBA':
                        {
                            // จำนวนบิลขาย
                            JSvDSHSALCallViewBillAllAndTotalSale();
                            break;
                        }
                    case 'FTS':
                        {
                            // ยอดขายรวม
                            JSvDSHSALCallViewBillAllAndTotalSale();
                            break;
                        }
                    case 'FSR':
                        {
                            // ยอดขายตามการชำะเงิน
                            JSvDSHSALCallViewTotalSaleByRecive();
                            break;
                        }
                    case 'FSB':
                        {
                            // มูลค่าสินค้าคงเหลือ
                            //JSvDSHSALCallViewStockBarlance();
                            break;
                        }
                    case 'FNP':
                        {
                            // 10 รายการสินค้าใหม่
                            JSvDSHSALCallViewTop10NewPdt();
                            break;
                        }
                    case 'FPG':
                        {
                            // ยอดขายตามกลุ่มสินค้า
                            JSvDSHSALCallViewTotalSaleByPdtGrp();
                            break;
                        }
                    case 'FPT':
                        {
                            // ยอดขายตามประเภทสินค้า
                            JSvDSHSALCallViewTotalSaleByPdtPty();
                            break;
                        }
                    case 'FTB':
                        {
                            // 10 อันดับสินค้าขายดีตามจำนวน
                            JSvDSHSALCallViewTop10BestSeller();
                            break;
                        }
                    case 'FTV':
                        {
                            // 10 อันดับสินค้าขายดีตามมูลค่า
                            JSvDSHSALCallViewTop10BestSellerByValue();
                            break;
                        }
                }
            }, 1000)
            setTimeout(function() {
                JCNxDSHSALCloseLodingChart(aDataReturn['rtDSHSALTypeKey']);
            }, 2000)
        },
        error: function(xhr, status, error) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function: Open Loding DashBoard
// Parameters: Document Ready Or Parameter Event
// Creator: 13/02/2020 Wasin(Yoshi)
// Return: View Open Loding
// ReturnType: Open Loding
function JCNxDSHSALOpenLodingChart(ptFilterKey) {
    $(".xWOverlayLodingChart[data-keyfilter='" + ptFilterKey + "']").delay(5).fadeIn();
}

// Function: Close Loding DashBoard
// Parameters: Document Ready Or Parameter Event
// Creator: 13/02/2020 Wasin(Yoshi)
// Return: View Open Loding
// ReturnType: Open Loding
function JCNxDSHSALCloseLodingChart(ptFilterKey) {
    $(".xWOverlayLodingChart[data-keyfilter='" + ptFilterKey + "']").delay(10).fadeOut();
}


// ============================================== Show View DashBoard ==============================================


// Function: Get Cookie JS
// Parameters: Document Ready Or Parameter Event
// Creator: 22/06/2020 Worakorn
// Return: 
// ReturnType: String
function JSvDSHSALGetCookieJS(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

// Function: Call Data Bill All And Total Sale
// Parameters: Document Ready Or Parameter Event
// Creator: 31/01/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JSvDSHSALCallViewBillAllAndTotalSale() {
    const oetDSHSALUserCode = $('#oetDSHSALUserCode').val();
    const nCookie = JSvDSHSALGetCookieJS("Cookie_SKC" + oetDSHSALUserCode);

    if (nCookie[2] != 0) {

        $.ajax({
            type: "POST",
            url: "dashboardsaleBillAllAndTotalSale",
            cache: false,
            timeout: 0,
            success: function(poResult) {
                let aDataReturn = JSON.parse(poResult);
                let nOptDecimalShow = aDataReturn['nOptDecimalShow'];
                // Set Data Bill All
                let aDataBillAll = aDataReturn['aDataFilesBillAll'];
                $('#odvDSHSALPanelLeft1 #olbDSHSALTotalSaleBill').empty().text(accounting.formatNumber(aDataBillAll['FNXshCountSalAll'], 0));
                $('#odvDSHSALPanelLeft1 #olbDSHSALTotalRefundBill').empty().text(accounting.formatNumber(aDataBillAll['FNXshCountRefundAll'], 0));
                $('#odvDSHSALPanelLeft1 #olbDSHSALTotalAllBill').empty().text(accounting.formatNumber(aDataBillAll['FNXshCountAll'], 0));
                // Set Data Total Sale All
                let aDataTotalSale = aDataReturn['aDataFilesTotalSale'];
                $('#odvDSHSALPanelLeft1 #olbDSHSALTotalSaleAll').empty().text(accounting.formatNumber(aDataTotalSale['FCXshTotalSaleAll'], nOptDecimalShow, ','));
                $('#odvDSHSALPanelLeft1 #olbDSHSALTotalRefundAll').empty().text(accounting.formatNumber(aDataTotalSale['FCXshTotalRefundAll'], nOptDecimalShow, ','));
                $('#odvDSHSALPanelLeft1 #olbDSHSALTotalAll').empty().text(accounting.formatNumber(aDataTotalSale['FCXshTotalAll'], nOptDecimalShow, ','));
            },
            error: function(xhr, status, error) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

}

// Function: Call View Chart Total Sale Recive
// Parameters: Document Ready Or Parameter Event
// Creator: 24/01/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JSvDSHSALCallViewTotalSaleByRecive() {
    const oetDSHSALUserCode = $('#oetDSHSALUserCode').val();
    const nCookie = JSvDSHSALGetCookieJS("Cookie_SKC" + oetDSHSALUserCode);

    if (nCookie[6] != 0) {
        $.ajax({
            type: "POST",
            url: "dashboardsaleTotalSaleByRecive",
            cache: false,
            timeout: 0,
            success: function(ptResult) {
                $('#odvDSHSALPanelLeft2 .xWDSHSALDataPanel').html(
                    "<iframe src=\"" + $("#ohdBaseURL").val() + "dashboardsaleTotalSaleByRecive\" style=\"width:100%;height:20vw;padding-top:20px;\"></iframe>"
                )
            },
            error: function(xhr, status, error) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

// Function: Call View Chart Total Sale Payment
// Parameters: Document Ready Or Parameter Event
// Creator: 04/02/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JSvDSHSALCallViewStockBarlance() {
    // $.ajax({
    //     type: "POST",
    //     url: "dashboardsalePdtStockBarlance",
    //     cache: false,
    //     timeout: 0,
    //     success : function(ptResult){
    //         $('#odvDSHSALPanelLeft3 .xWDSHSALDataPanel').html(
    //             "<iframe src=\""+$("#ohdBaseURL").val()+"dashboardsalePdtStockBarlance\" style=\"width:100%;height:20vw;padding-top:20px;\"></iframe>"
    //         )
    //     },
    //     error : function(xhr, status,error) {
    //         JCNxResponseError(jqXHR,textStatus,errorThrown);
    //     }
    // });
}

// Function: Call View Chart Top 10 New Product
// Parameters: Document Ready Or Parameter Event
// Creator: 23/01/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JSvDSHSALCallViewTop10NewPdt() {
    const oetDSHSALUserCode = $('#oetDSHSALUserCode').val();
    const nCookie = JSvDSHSALGetCookieJS("Cookie_SKC" + oetDSHSALUserCode);

    if (nCookie[10] != 0) {
        $.ajax({
            type: "POST",
            url: "dashboardsaleTopTenNewPdt",
            cache: false,
            timeout: 0,
            success: function(ptResult) {
                $('#odvDSHSALPanelLeft4 .xWDSHSALDataPanel').html(ptResult);
            },
            error: function(xhr, status, error) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

// Function: Call View Chart Total Sale By Product Group
// Parameters: Document Ready Or Parameter Event
// Creator: 24/01/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JSvDSHSALCallViewTotalSaleByPdtGrp() {
    const oetDSHSALUserCode = $('#oetDSHSALUserCode').val();
    const nCookie = JSvDSHSALGetCookieJS("Cookie_SKC" + oetDSHSALUserCode);

    if (nCookie[14] != 0) {
        $.ajax({
            type: "POST",
            url: "dashboardsaleTotalSaleByPdtGrp",
            cache: false,
            timeout: 0,
            success: function(ptResult) {
                $('#odvDSHSALPanelRight1 .xWDSHSALDataPanel').html(
                    "<iframe src=\"" + $("#ohdBaseURL").val() + "dashboardsaleTotalSaleByPdtGrp\" style=\"width:100%;height:27vw;padding-top:20px;\"></iframe>"
                )
            },
            error: function(xhr, status, error) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

// Function: Call View Chart Total Sale By Product Type
// Parameters: Document Ready Or Parameter Event
// Creator: 24/01/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JSvDSHSALCallViewTotalSaleByPdtPty() {
    const oetDSHSALUserCode = $('#oetDSHSALUserCode').val();
    const nCookie = JSvDSHSALGetCookieJS("Cookie_SKC" + oetDSHSALUserCode);

    if (nCookie[18] != 0) {
        $.ajax({
            type: "POST",
            url: "dashboardsaleTotalSaleByPdtPty",
            cache: false,
            timeout: 0,
            success: function(ptResult) {
                $('#odvDSHSALPanelRight2 .xWDSHSALDataPanel').html(
                    "<iframe src=\"" + $("#ohdBaseURL").val() + "dashboardsaleTotalSaleByPdtPty\" style=\"width:100%;height:27vw;padding-top:20px;\"></iframe>"
                )
            },
            error: function(xhr, status, error) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

// Function: Call View Chart Top 10 Best Seller
// Parameters: Document Ready Or Parameter Event
// Creator: 24/01/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JSvDSHSALCallViewTop10BestSeller() {
    const oetDSHSALUserCode = $('#oetDSHSALUserCode').val();
    const nCookie = JSvDSHSALGetCookieJS("Cookie_SKC" + oetDSHSALUserCode);

    if (nCookie[22] != 0) {
        $.ajax({
            type: "POST",
            url: "dashboardsaleTopTenBestSeller",
            cache: false,
            timeout: 0,
            success: function(ptResult) {
                $('#odvDSHSALPanelRight3 .xWDSHSALDataPanel').html(
                    "<iframe src=\"" + $("#ohdBaseURL").val() + "dashboardsaleTopTenBestSeller\" style=\"width:100%;height:26vw;\"></iframe>"
                );
            },
            error: function(xhr, status, error) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

// Function: Call View Chart Top 10 Best Seller By Value
// Parameters: Document Ready Or Parameter Event
// Creator: 17/07/2020 Worakorn
// Return: View Page Main
// ReturnType: View
function JSvDSHSALCallViewTop10BestSellerByValue() {
    const oetDSHSALUserCode = $('#oetDSHSALUserCode').val();
    const nCookie = JSvDSHSALGetCookieJS("Cookie_SKC" + oetDSHSALUserCode);

    if (nCookie[30] != 0) {
        $.ajax({
            type: "POST",
            url: "dashboardsaleTopTenBestSellerByValue",
            cache: false,
            timeout: 0,
            success: function(ptResult) {
                $('#odvDSHSALPanelLeft6 .xWDSHSALDataPanel').html(
                    "<iframe src=\"" + $("#ohdBaseURL").val() + "dashboardsaleTopTenBestSellerByValue\" style=\"width:100%;height:26vw;\"></iframe>"
                );
            },
            error: function(xhr, status, error) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

// ============================================== Show View DashBoard ==============================================