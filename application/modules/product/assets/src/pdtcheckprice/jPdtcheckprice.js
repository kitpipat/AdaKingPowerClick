$("document").ready(function() {
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose();
    JSxPCPFromSearchList();
});


// Functionality : auto rowspan
// Parameters : Element
// Creator : 02/09/2020 Sooksanti(Nont)
// LastUpdate: -
// Return : -
// Return Type :-
function JSxPCPAutoRowSpan(tSelector,ptDisplayType) {
    tSelector.each(function() {
        var tValuesTr1 = $(this).find("tr>td:first-of-type");
        var tValuesTr2 = $(this).find("tr>td:nth-of-type(2)");
        var tValuesTr3 = $(this).find("tr>td:nth-of-type(3)");
        var tValuesTr4 = $(this).find("tr>td:nth-of-type(4)");
        var nLimit = 0;
        var nRun = 1;
        var tCount = '';

        if( ptDisplayType == '1' ){
            nLimit = 4;
        }else{
            nLimit = 5;
        }

        for (var nJ = 1; nJ < nLimit; nJ++) {
            switch (nJ) {
                case 1:
                    tCount = tValuesTr1;
                    break;
                case 2:
                    tCount = tValuesTr2;
                    break;
                case 3:
                    tCount = tValuesTr3;
                    break;
                case 4:
                    tCount = tValuesTr4;
                    break;
                default:
            }
            for (var nI = tCount.length - 1; nI > -1; nI--) {
                if (nJ == 2) {
                    if ( tValuesTr1.eq(nI).text() === tValuesTr1.eq(nI - 1).text() && tValuesTr2.eq(nI).text() === tValuesTr2.eq(nI - 1).text() ) {
                        tValuesTr2.eq(nI).remove()
                        nRun++
                    } else {
                        tValuesTr2.eq(nI).attr("rowspan", nRun)
                        nRun = 1
                    }
                }
                else if (nJ == 3) {
                    if ( tValuesTr1.eq(nI).text() === tValuesTr1.eq(nI - 1).text() && tValuesTr2.eq(nI).text() === tValuesTr2.eq(nI - 1).text() && tValuesTr3.eq(nI).text() === tValuesTr3.eq(nI - 1).text() ) {
                        tValuesTr3.eq(nI).remove()
                        nRun++
                    } else {
                        tValuesTr3.eq(nI).attr("rowspan", nRun)
                        nRun = 1
                    }
                }
                else if ( nJ == 4 && ptDisplayType == '2' ) {
                    if ( tValuesTr1.eq(nI).text() === tValuesTr1.eq(nI - 1).text() && tValuesTr2.eq(nI).text() === tValuesTr2.eq(nI - 1).text() && tValuesTr3.eq(nI).text() === tValuesTr3.eq(nI - 1).text() && tValuesTr4.eq(nI).text() === tValuesTr4.eq(nI - 1).text()) {
                        tValuesTr4.eq(nI).remove()
                        nRun++
                    } else {
                        tValuesTr4.eq(nI).attr("rowspan", nRun)
                        nRun = 1
                    }
                } 
                else {
                    if (tCount.eq(nI).text() === tCount.eq(nI - 1).text()) {
                        tCount.eq(nI).remove()
                        nRun++
                    } else {
                        tCount.eq(nI).attr("rowspan", nRun)
                        nRun = 1
                    }
                }

            }
        }
    })
}
// //Functionality : เรียก From Search มาแสดง
// //Parameters : -
// //Creator : 02/09/2020 Sooksanti(Non)
// //Last Update:
// //Return : 
// //Return Type :
function JSxPCPFromSearchList() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');
            $.ajax({
                type: "POST",
                url: "dasPCPPageList",
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $("#odvPCPContentPageDocument").html(tResult);
                    JSxPCPGetListPageTable();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } catch (err) {
            console.log('JSxSMUSettingMenuCallPage Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// //Functionality : เรียกข้อมูลตรวจสอบราคาสินค้าลงตาราง
// //Parameters : -
// //Creator : 03/09/2020 Sooksanti(Non)
// //Last Update:
// //Return : 
// //Return Type :
function JSxPCPGetListPageTable(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            JCNxOpenLoading();
            var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
            var tDisplayType = $('#ocmPCPDisplayType').val();
            var oAdvanceSearch = JSoPCPAdvanceSearchData();
            localStorage.removeItem('LocalItemData');

            // console.log(tDisplayType);

            $.ajax({
                type: "POST",
                url: "dasPCPPageDataTable",
                data: {
                    nPageCurrent    : nPageCurrent,
                    nPagePDTAll     : $('#ohdPCPProductAllRow').val(),
                    oAdvanceSearch  : oAdvanceSearch,
                    tDisplayType    : tDisplayType
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $("#ostPCPDataTableDocument").html(tResult);
                    JSxPCPAutoRowSpan($("table"),tDisplayType);
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } catch (err) {
            console.log('JSxPCPGetListPageTable Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// //Functionality : เก็บค่าจาก input AdvanceSearch
// //Parameters : -
// //Creator : 03/09/2020 Sooksanti(Non)
// //Last Update:
// //Return : ค่า input AdvanceSearch
// //Return Type : obj
function JSoPCPAdvanceSearchData() {
    
    var nStaSession = JCNxFuncChkSessionExpired();
    var tSearchAll = $('#oetPCPSearchAll').val();
    var tPdtCodeFrom = $('#oetPCPPdtCodeFrom').val();
    var tPdtCodeTo = $('#oetPCPPdtCodeTo').val();
    var tSearchDocDateFrom = $('#oetPCPSearchDocDateFrom').val();
    var tSearchDocDateTo = $('#oetPCPSearchDocDateTo').val();
    var tPunCodeFrom = $('#oetPCPPunCodeFrom').val();
    var tPunCodeTo = $('#oetPCPPunCodeTo').val();
    var tSearchDateStart = $('#oetPCPSearchDateStart').val();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            let oAdvanceSearchData = {
                tSearchAll: tSearchAll,
                tPdtCodeFrom: tPdtCodeFrom,
                tPdtCodeTo: tPdtCodeTo,
                tSearchDocDateFrom: tSearchDocDateFrom,
                tSearchDocDateTo: tSearchDocDateTo,
                tPunCodeFrom: tPunCodeFrom,
                tPunCodeTo: tPunCodeTo,
                tSearchDateStart: tSearchDateStart,
                tPplCodeFrom: $('#oetPCPPplCodeFrom').val(),
                tPplCodeTo: $('#oetPCPPplCodeTo').val()
            };
            return oAdvanceSearchData;
        } catch (err) {
            console.log("JSoPCPAdvanceSearchData Error: ", err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Functionality : Function Check Data Search And Add In Tabel
// Parameters : Event Click Buttom
// Creator : 03/09/2020 Sooksanti(Nont)
// LastUpdate: -
// Return : 
// Return Type :
function JSxPCPClickPageList(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPIPageDataTable .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPIPageDataTable .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSxPCPGetListPageTable(nPageCurrent);
}

