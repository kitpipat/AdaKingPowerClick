// ลูกค้า
// ข้อมูลหน้า ก่อนหน้า
function JSxCstPreviousPage() {
    // alert('PreviousPage');
    var nCurrentPage = $('#ospPageCstActive').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageCstActive').text(nPreviousPage);
    JSxCstListView();
}
// ข้อมูลหน้า หน้าถัดไป
function JSxCstForwardPage() {
    // alert('ForwardPage');
    var nCurrentPage = $('#ospPageCstActive').text();
    var nTotalPage = $('#ospTotalCstPage').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageCstActive').text(nForwardPage);
    JSxCstListView();
}
function JSvPClickPage(tNumPage) {
    $('#ospPageCstActive').text(tNumPage);
    JSxCstListView();
}
function JSxCstListView(nPageNo) {
    var tCstName = $('#oetSCHFTCstName').val();
    var tCardID = $('#oetSCHFTCstCardID').val();
    var tPhone = $('#oetSCHFTCstPhone').val();
    var nPageNo = $('#ospPageCstActive').text();
    if(nPageNo == ''){
        nPageNo = 1;
    }
    JCNxOpenLoading();
    $('.icon-loading').show();
    $.ajax({
        type: "POST",
        url: "EticketCustomer/ajaxList",
        data: {
            tCstName: tCstName,
            tCardID: tCardID,
            tPhone: tPhone,
            nPageNo: nPageNo
        },
        cache: false,
        success: function (msg) {
            $('#oResultCst').html(msg);
            var ospPageCstActive = $('#ospPageCstActive').text();
            var ospTotalCstPage = $('#ospTotalCstPage').text();
            var tHtml = '';
            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxCstPreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalCstPage); i++) {
                l = i + 1;
                if (parseInt(ospPageCstActive) == l) {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxCstForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

            $('.xWGridFooter').html(tHtml);
            if (ospPageCstActive == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (ospPageCstActive == ospTotalCstPage) {
                $('#oForwardPage').attr('disabled',true);
            } else {
                $('#oForwardPage').attr('disabled',false);
            }
        JCNxCloseLoading();
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function JSxCstCount() {
    var tCstName = $('#oetSCHFTCstName').val();
    var tCardID = $('#oetSCHFTCstCardID').val();
    var tPhone = $('#oetSCHFTCstPhone').val();
    if (tCstName == "") {
        var tCstName = '';
    } else {
        var tCstName = tCstName;
    }
    $('.xCNOverlay').show();
    $.ajax({
        type: "POST",
        url: "EticketCustomer/count",
        data: {
            tCstName: tCstName,
            tCardID: tCardID,
            tPhone: tPhone
        },
        cache: false,
        success: function (msg) {
            $('#ospTotalCstRecord').text(msg);
            $('#ospPageCstActive').text('1');
            $('#ospTotalCstPage').text(Math.ceil(parseInt(msg) / 8));
            if (msg.trim() == '0') {
                $('.xWGridFooter').hide();
                $('.grid-resultpage').hide();
            } else {
                $('.xWGridFooter').show();
                $('.grid-resultpage').show();
            }
            JSxCstListView();
            JSxCheckPinMenuClose();
            $('.xCNOverlay').hide();
        },
        error: function (data) {
            console.log(data);
            $('.xCNOverlay').hide();
        }
    });
}
function FSxCstDel(pnPage,nFNCstID, tMsg) {
    
    //     title: aLocale['tConfirmDelete'],
    //     message: aLocale['tConfirmDeletionOf'] + ' ' + tMsg,
    //     buttons: {
    //         cancel: {
    //             label: '<i class="fa fa-times-circle" aria-hidden="true"></i> ' + aLocale['tBtnClose'],
    //             className: 'xCNBTNDefult'
    //         },
    //         confirm: {
    //             label: '<i class="fa fa-check-circle" aria-hidden="true"></i> ' + aLocale['tBtnConfirm'],
    //             className: 'xCNBTNPrimery'
    //         }
    //     },
    bootbox.confirm({
    title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + nFNCstID + ' ('+tMsg+')',
        buttons: {
            cancel: {
                label:  aLocale['tBtnConfirm'],
                className: 'xCNBTNPrimery'
            },
            confirm: {
                label: aLocale['tBtnClose'],
                className: 'xCNBTNDefult'
            }
        },
        callback: function (result) {
            if (result == false) {
                $.ajax({
                    type: "post",
                    url: "EticketCustomer/delete",
                    data: {
                        nFNCstID: nFNCstID
                    },
                    // success: function (data) {
                    //     JSxCstCount();
                    // },
                    success: function (tResult) {
                        aResult = JSON.parse(tResult);
                        console.log(aResult);
                        nStatus = aResult.status;
                        tMsg = aResult.msg;
                        if (nStatus == 1) {
                             $('#ospPageCstActive').text(pnPage);
                             JSxCstListView(pnPage);
                        }else{
                            bootbox.alert({
                                title: aLocale['tWarning'],
                                message: tMsg,
                                buttons: {
                                    ok: {
                                        label: aLocale['tOK'],
                                        className: 'xCNBTNPrimery'
                                    }
                                },
                                        
                                callback: function () {
                                    $('.bootbox').modal('hide');
                                }
                            });
                        }
    
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            }
        }
    });
}




/** *************** */
// ประเภทลูกค้า
// ข้อมูลหน้า ก่อนหน้า
function JSxCstCategoryPreviousPage() {
    // alert('PreviousPage');
    var nCurrentPage = $('#ospPageCstCategoryActive').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageCstCategoryActive').text(nPreviousPage);
    JSxCstCategoryListView();
}
// ข้อมูลหน้า หน้าถัดไป
function JSxCstCategoryForwardPage() {
    // alert('ForwardPage');
    var nCurrentPage = $('#ospPageCstCategoryActive').text();
    var nTotalPage = $('#ospTotalCstCategoryPage').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageCstCategoryActive').text(nForwardPage);
    JSxCstCategoryListView();
}
function JSvPCgrClickPage(tNumPage) {
    $('#ospPageCstCategoryActive').text(tNumPage);
    JSxCstCategoryListView();
}
function JSxCstCategoryListView(nPageNo) {
    JCNxOpenLoading();
    var tFTCtyName = $('#oetSCHFTCstCategoryName').val();
    var nPageNo = $('#ospPageCstCategoryActive').text();
    if(nPageNo == ''){
        nPageNo = 1;
    }
    $.ajax({
        type: "POST",
        url: "EticketCustomer/categoryAjaxList",
        data: {
            tFTCtyName: tFTCtyName,
            nPageNo: nPageNo
        },
        cache: false,
        success: function (msg) {
            $('#oResultCstCategory').html(msg);
            var ospPageCstCategoryActive = $('#ospPageCstCategoryActive').text();
            var ospTotalCstCategoryPage = $('#ospTotalCstCategoryPage').text();
            var tHtml = '';


        //     tHtml = '<ul class="pagination xWEticketPagination justify-content-center">';
        //     tHtml += '<li class="page-item previous"><a class="page-link xWBtnPrevious" id="oPreviousPage" onclick="return JSxCstCategoryPreviousPage();">'+aLocale['tPrevious']+'</a></li>';
        //     var i;
        //     var l;
        //     for (i = 0; i < parseInt(ospTotalCstCategoryPage); i++) {
        //         l = i + 1;
        //         if (parseInt(ospPageCstCategoryActive) == l) {
        //             tHtml += '<li class="page-item active"><a class="page-link" onclick="JSvPCgrClickPage(\'' + l + '\');">' + l + '</a></li>';
        //         } else {
        //             tHtml += '<li class="page-item"><a class="page-link" onclick="JSvPCgrClickPage(\'' + l + '\');">' + l + '</a></li>';
        //         }
        //     }
        //     tHtml += '<li class="page-item next"><a class="page-link xWBtnNext" id="oForwardPage" onclick="return JSxCstCategoryForwardPage();">'+aLocale['tNext']+'</a></li>';
        //     tHtml += '</ul>';
        //     $('.xWGridFooter').html(tHtml);
        //     if (ospPageCstCategoryActive == '1') {
        //         $('#oPreviousPage').addClass('xCNDisable');
        //     } else {
        //         $('#oPreviousPage').removeClass('xCNDisable');
        //     }
        //     if (ospPageCstCategoryActive == ospTotalCstCategoryPage) {
        //         $('#oForwardPage').addClass('xCNDisable');
        //     } else {
        //         $('#oForwardPage').removeClass('xCNDisable');
        //     }
        //     JSxCheckPinMenuClose();
        // },
        
        // เปลี่ยน 
            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxCstCategoryPreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalCstCategoryPage); i++) {
                l = i + 1;
                if (parseInt(ospPageCstCategoryActive) == l) {
                    tHtml += '<button onclick="JSvPCgrClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvPCgrClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxCstCategoryForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

            $('.xWGridFooter').html(tHtml);
            if (ospPageCstCategoryActive == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (ospPageCstCategoryActive == ospTotalCstCategoryPage) {
                $('#oForwardPage').attr('disabled',true);
            } else {
                $('#oForwardPage').attr('disabled',false);
            }   
        JCNxCloseLoading(); 
     },
    error: function (data) {
            console.log(data);
        }
    });
}
function JSxCstCategoryCount() {
    var tCstCategoryName = $('#oetSCHFTCstCategoryName').val();
    if (tCstCategoryName == "") {
        var tCstCategoryName = '';
    } else {
        var tCstCategoryName = tCstCategoryName;
    }
    $('.xCNOverlay').show();
    $.ajax({
        type: "POST",
        url: "EticketCustomer/categoryCount",
        data: {
            tFTCtyName: tCstCategoryName
        },
        cache: false,
        success: function (msg) {
            $('#ospTotalCstCategoryRecord').text(msg);
            $('#ospPageCstCategoryActive').text('1');
            $('#ospTotalCstCategoryPage').text(Math.ceil(parseInt(msg) / 8));
            if (msg.trim() == '0') {
                $('.xWGridFooter').hide();
                $('.grid-resultpage').hide();
            } else {
                $('.xWGridFooter').show();
                $('.grid-resultpage').show();
            }
            JSxCheckPinMenuClose();
            JSxCstCategoryListView();
            $('.xCNOverlay').hide();
        },
        error: function (data) {
            console.log(data);
            $('.xCNOverlay').hide();
        }
    });
}

//Functionality: Function Chack Delete Data
//Creator: 23/01/2019 saharat
//Return: - 
//Return Type: -
function FSxCstCategoryDel(pnPage,nFNCtyID, tMsg) {
    // bootbox.confirm({
    //     title: aLocale['tConfirmDelete'],
    //     message: aLocale['tConfirmDeletionOf'] + ' ' + tMsg,
    //     buttons: {
    //         cancel: {
    //             label: '<i class="fa fa-times-circle" aria-hidden="true"></i> ' + aLocale['tBtnClose'],
    //             className: 'xCNBTNDefult'
    //         },
    //         confirm: {
    //             label: '<i class="fa fa-check-circle" aria-hidden="true"></i> ' + aLocale['tBtnConfirm'],
    //             className: 'xCNBTNPrimery'
    //         }
    //     },
    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + nFNCtyID + ' ('+tMsg+')',
        buttons: {
            cancel: {
                label:  aLocale['tBtnConfirm'],
                className: 'xCNBTNPrimery'
            },
            confirm: {
                label: aLocale['tBtnClose'],
                className: 'xCNBTNDefult'
            }
        },
        callback: function (result) {
            if (result == false) {
                $.ajax({
                    type: "post",
                    url: "EticketCustomer/deleteCategory",
                    data: {
                        nFNCtyID: nFNCtyID
                    },
                    success: function (tResult) {
                        aResult = JSON.parse(tResult);
                        console.log(aResult);
                        nCount = aResult.count;
                        tMsg = aResult.msg;
                        if (nCount == 1) {
                            $('#ospPageCstCategoryActive').text(pnPage);
                            JSxCstCategoryListView(pnPage);
                        }else{
                            bootbox.alert({
                                title: aLocale['tWarning'],
                                message: tMsg,
                                buttons: {
                                    ok: {
                                        label: aLocale['tOK'],
                                        className: 'xCNBTNPrimery'
                                    }
                                },
                                        
                                callback: function () {
                                    $('.bootbox').modal('hide');
                                }
                            });
                        }

                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            }
        }
    });
}


//Functionality: Function Chack Delete All
//Parameters: pnPage Data
//Creator: 23/01/2019 saharat
//Return: - 
//Return Type: -
function FSxDelAllOnCheckCategory(pnPage) {
//     var ocbListItem = [];
//     var ocbListName = [];
//     $('.ocbListItem:checked').each(function (i, e) {
//         ocbListName.push($(this).data('name'));
//     });
//     bootbox.confirm({
//         title: aLocale['tConfirmDelete'],
//         message: aLocale['tConfirmDeletionOf'] + ' ' + ocbListName.join(),
//         buttons: {
//             cancel: {
//                 label: '<i class="fa fa-times-circle" aria-hidden="true"></i> ' + aLocale['tBtnClose'],
//                 className: 'xCNBTNDefult'
//             },
//             confirm: {
//                 label: '<i class="fa fa-check-circle" aria-hidden="true"></i> ' + aLocale['tBtnConfirm'],
//                 className: 'xCNBTNPrimery'
//             }
//         },
//         callback: function (result) {
//             if (result == true) {
//                 $('.ocbListItem:checked').each(function (i, e) {
//                     ocbListItem.push($(this).val());
//                 });
//                 $.ajax({
//                     type: "POST",
//                     url: "EticketCustomer/deleteCategory",
//                     data: {
//                         'nFNCtyID': ocbListItem.join()
//                     },
//                     cache: false,
//                     success: function (msg) {
//                         JSxCstCategoryCount();
//                         $('.obtChoose').hide();
//                     },
//                     error: function (data) {
//                         console.log(data);
//                     }
//                 });
//             }
//         }
//     });
// }
    //เปลี่ยน
        var ocbListItem = [];
        var ocbListName = [];
        $('.ocbListItem:checked').each(function (i, e) {
            ocbListName.push($(this).data('name'));
        });

        $('.ocbListItem:checked').each(function (i, e) {
            ocbListItem.push($(this).val());
        });
        $.ajax({
            type: "POST",
            url: "EticketCustomer/deleteCategory",
            data: {
                'nFNCtyID': ocbListItem.join()
            },
            cache: false,
            success: function (msg) {
                $('#ospPageCstCategoryActive').text(pnPage);
                JSxCstCategoryListView(pnPage);
                
                $('.modal-backdrop').remove(); 
                $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
            },
            error: function (data) {
                console.log(data);
            }
        });
    }




/******************/
//กลุ่มลูกค้า
//ข้อมูลหน้า ก่อนหน้า
function JSxCstGroupPreviousPage() {
    // alert('PreviousPage');
    var nCurrentPage = $('#ospPageCstGroupActive').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageCstGroupActive').text(nPreviousPage);
    JSxCstGroupListView();
}
//ข้อมูลหน้า หน้าถัดไป
function JSxCstGroupForwardPage() {
    // alert('ForwardPage');
    var nCurrentPage = $('#ospPageCstGroupActive').text();
    var nTotalPage = $('#ospTotalCstGroupPage').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageCstGroupActive').text(nForwardPage);
    JSxCstGroupListView();
}
function JSvPGClickPage(tNumPage) {
    $('#ospPageCstGroupActive').text(tNumPage);
    JSxCstGroupListView();
}
function JSxCstGroupListView(nPageNo) {
    JCNxOpenLoading();
    var tFTCgpName = $('#oetSCHFTCstGroupName').val();
    var nPageNo = $('#ospPageCstGroupActive').text();
    if(nPageNo == ''){
        nPageNo = 1;
    }
    JCNxOpenLoading();
    $('.icon-loading').show();
    $.ajax({
        type: "POST",
        url: "EticketCustomer/groupAjaxList",
        data: {
            tFTCgpName: tFTCgpName,
            nPageNo: nPageNo
        },
        cache: false,
        success: function (msg) {
            $('#oResultCstGroup').html(msg);
            var ospPageCstGroupActive = $('#ospPageCstGroupActive').text();
            var ospTotalCstGroupPage = $('#ospTotalCstGroupPage').text();
            var tHtml = '';
        //     tHtml = '<ul class="pagination xWEticketPagination justify-content-center">';
        //     tHtml += '<li class="page-item previous"><a class="page-link xWBtnPrevious" id="oPreviousPage" onclick="return JSxCstGroupPreviousPage();">'+aLocale['tPrevious']+'</a></li>';
        //     var i;
        //     var l;
        //     for (i = 0; i < parseInt(ospTotalCstGroupPage); i++) {
        //         l = i + 1;
        //         if (parseInt(ospPageCstGroupActive) == l) {
        //             tHtml += '<li class="page-item active"><a class="page-link" onclick="JSvPGClickPage(\'' + l + '\');">' + l + '</a></li>';
        //         } else {
        //             tHtml += '<li class="page-item"><a class="page-link" onclick="JSvPGClickPage(\'' + l + '\');">' + l + '</a></li>';
        //         }
        //     }
        //     tHtml += '<li class="page-item next"><a class="page-link xWBtnNext" id="oForwardPage" onclick="return JSxCstGroupForwardPage();">'+aLocale['tNext']+'</a></li>';
        //     tHtml += '</ul>';
        //     $('.xWGridFooter').html(tHtml);
        //     if (ospPageCstGroupActive == '1') {
        //         $('#oPreviousPage').addClass('xCNDisable');
        //     } else {
        //         $('#oPreviousPage').removeClass('xCNDisable');
        //     }
        //     if (ospPageCstGroupActive == ospTotalCstGroupPage) {
        //         $('#oForwardPage').addClass('xCNDisable');
        //     } else {
        //         $('#oForwardPage').removeClass('xCNDisable');
        //     }
        //     JSxCheckPinMenuClose();
        // },
        // เปลี่ยน 

            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxCstGroupPreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalCstGroupPage); i++) {
                l = i + 1;
                if (parseInt(ospPageCstGroupActive) == l) {
                    tHtml += '<button onclick="JSvPGClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvPGClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxCstGroupForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

            $('.xWGridFooter').html(tHtml);
            if (ospPageCstGroupActive == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (ospPageCstGroupActive == ospTotalCstGroupPage) {
                $('#oForwardPage').attr('disabled',true);
            } else {
                $('#oForwardPage').attr('disabled',false);
            }
        JCNxCloseLoading();
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function JSxCstGroupCount() {
    var tCstGroupName = $('#oetSCHFTCstGroupName').val();
    if (tCstGroupName == "") {
        var tCstGroupName = '';
    } else {
        var tCstGroupName = tCstGroupName;
    }
    $('.xCNOverlay').show();
    $.ajax({
        type: "POST",
        url: "EticketCustomer/groupCount",
        data: {
            tFTCgpName: tCstGroupName
        },
        cache: false,
        success: function (msg) {
            $('#ospTotalCstGroupRecord').text(msg);
            $('#ospPageCstGroupActive').text('1');
            $('#ospTotalCstGroupPage').text(Math.ceil(parseInt(msg) / 8));
            if (msg.trim() == '0') {
                $('.xWGridFooter').hide();
                $('.grid-resultpage').hide();
            } else {
                $('.xWGridFooter').show();
                $('.grid-resultpage').show();
            }
            JSxCstGroupListView();
            JSxCheckPinMenuClose();
            $('.xCNOverlay').hide();
        },
        error: function (data) {
            console.log(data);
            $('.xCNOverlay').hide();
        }
    });
}

//Functionality: Function Chack Delete DataGroup
//Creator: 23/01/2019 saharat
//Return: - 
//Return Type: -
function FSxCstGroupDel(pnPage,nFNCgpID, tMsg) {
    // bootbox.confirm({
    //     title: aLocale['tConfirmDelete'],
    //     message: aLocale['tConfirmDeletionOf'] + ' ' + tMsg,
    //     buttons: {
    //         cancel: {
    //             label: '<i class="fa fa-times-circle" aria-hidden="true"></i> ' + aLocale['tBtnClose'],
    //             className: 'xCNBTNDefult'
    //         },
    //         confirm: {
    //             label: '<i class="fa fa-check-circle" aria-hidden="true"></i> ' + aLocale['tBtnConfirm'],
    //             className: 'xCNBTNPrimery'
    //         }
    //     },
    //     callback: function (result) {
    //         if (result == true) {
    //             $.ajax({
    //                 type: "post",
    //                 url: "EticketCustomer/deleteGroup",
    //                 data: {
    //                     nFNCgpID: nFNCgpID
    //                 },
    //                 success: function (oData) {
    //                     oBj = JSON.parse(oData);
    //                     if (oBj.count == 1) {                           
    //                         bootbox.alert({
    //                             title: aLocale['tWarning'],
    //                             message: oBj.msg,
    //                             buttons: {
    //                                 ok: {
    //                                     label: aLocale['tOK'],
    //                                     className: 'xCNBTNPrimery'
    //                                 }
    //                             },
    //                             callback: function () {
    //                                 $('.bootbox').modal('hide');
    //                             }
    //                         });
    //                     } else {
    //                         JSxCstGroupCount();
    //                     }
    //                 },


    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + nFNCgpID + ' ('+tMsg+')',
        buttons: {
            cancel: {
                label:  aLocale['tBtnConfirm'],
                className: 'xCNBTNPrimery'
            },
            confirm: {
                label: aLocale['tBtnClose'],
                className: 'xCNBTNDefult'
            }
        },
        callback: function (result) {
            if (result == false) {
                $.ajax({
                    type: "post",
                    url: "EticketCustomer/deleteGroup",
                    data: {
                        nFNCgpID: nFNCgpID
                    },
                    success: function (tResult) {
                        aResult = JSON.parse(tResult);
                        console.log(aResult);
                        nCount = aResult.count;
                        tMsg = aResult.msg;
                        if (nCount == 1) {
                            $('#ospPageCstGroupActive').text(pnPage);
                            JSxCstGroupListView(pnPage);
                        }else{
                            bootbox.alert({
                                title: aLocale['tWarning'],
                                message: tMsg,
                                buttons: {
                                    ok: {
                                        label: aLocale['tOK'],
                                        className: 'xCNBTNPrimery'
                                    }
                                },
                                        
                                callback: function () {
                                    $('.bootbox').modal('hide');
                                }
                            });
                        }

                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            }
        }
    });
}

//Functionality: Function Chack Delete All Data Group 
//Creator: 23/01/2019 saharat
//Return: - 
//Return Type: -
function FSxDelAllOnCheckGroup(pnPage) {
    // var ocbListItem = [];
    // var ocbListName = [];
    // $('.ocbListItem:checked').each(function (i, e) {
    //     ocbListName.push($(this).data('name'));
    // });
    // bootbox.confirm({
    //     title: aLocale['tConfirmDelete'],
    //     message: aLocale['tConfirmDeletionOf'] + ' ' + ocbListName.join(),
    //     buttons: {
    //         cancel: {
    //             label: '<i class="fa fa-times-circle" aria-hidden="true"></i> ' + aLocale['tBtnClose'],
    //             className: 'xCNBTNDefult'
    //         },
    //         confirm: {
    //             label: '<i class="fa fa-check-circle" aria-hidden="true"></i> ' + aLocale['tBtnConfirm'],
    //             className: 'xCNBTNPrimery'
    //         }
    //     },
    //     callback: function (result) {
    //         if (result == true) {
    //             $('.ocbListItem:checked').each(function (i, e) {
    //                 ocbListItem.push($(this).val());
    //             });
    //             $.ajax({
    //                 type: "POST",
    //                 url: "EticketCustomer/deleteGroup",
    //                 data: {
    //                     'nFNCgpID': ocbListItem.join()
    //                 },
    //                 cache: false,
    //                 success: function (msg) {
    //                     JSxCstGroupCount();
    //                     $('.obtChoose').hide();
    //                 },
    //                 error: function (data) {
    //                     console.log(data);
    //                 }
    //             });
    //         }
    //     }
    // });

        //เปลี่ยน
        var ocbListItem = [];
        var ocbListName = [];
        $('.ocbListItem:checked').each(function (i, e) {
            ocbListName.push($(this).data('name'));
        });

        $('.ocbListItem:checked').each(function (i, e) {
            ocbListItem.push($(this).val());
        });
        $.ajax({
            type: "POST",
            url: "EticketCustomer/deleteGroup",
            data: {
                'nFNCgpID': ocbListItem.join()
            },
            cache: false,
            success: function (msg) {
                $('#ospPageCstGroupActive').text(pnPage);
                JSxCstGroupListView(pnPage);
                
                $('.modal-backdrop').remove(); 
                $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
            },
            error: function (data) {
                console.log(data);
            }
        });
    }



//Functionality: Function Chack ลบข้อมูลทั้งหมด ของ ลูกค้า
//Parameters: เลขหน้า
//Creator: 23/01/2019 saharat
//Return: - 
//Return Type: -
function FSxDelAllOnCheckCst(pnPage) {
    var ocbListItem = [];
            var ocbListName = [];
            $('.ocbListItem:checked').each(function (i, e) {
                ocbListName.push($(this).data('name'));
            });
        
            $('.ocbListItem:checked').each(function (i, e) {
                ocbListItem.push($(this).val());
            });
                $.ajax({
                    type: "POST",
                    url: "EticketCustomer/delete",
                    data: {
                        nFNCstID: ocbListItem.join()
                    },
                    cache: false,
                    success: function (msg) {
                        $('#ospPageCstActive').text(pnPage);
                        JSxCstListView(pnPage);
                        
                        $('.modal-backdrop').remove(); 
                        $('.obtChoose').hide(); 
                        $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
 



//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 22/01/2019 saharat
//Return: - 
//Return Type: -
function JSxShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
        $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $('#odvMngTableList #oliBtnDeleteAll').removeClass('disabled');
        } else {
             $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        }
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 22/01/2019 saharat
//Return: -
//Return Type: -
function JSxTextinModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tText = '';
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tText += aArrayConvert[0][$i].tName + '(' + aArrayConvert[0][$i].nCode + ') ';
            tText += ' , ';
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
        }
        var tTexts = tText.substring(0, tText.length - 2);
        $('#ospConfirmDelete').text('ท่านต้องการลบข้อมูลทั้งหมดหรือไม่ ?');
        $('#ospConfirmIDDelete').val(tTextCode);
    }
}


//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 22/01/2019 saharat
//Return: Duplicate/none
//Return Type: string
function findObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return 'Dupilcate';
        }
    }
    return 'None';
}


//Functionality: Function ลบรูปลูกค้าหน้า แก้ไขข้อมูล
//Parameters: pnFNImgID/รหัสรูป,ptImgObj/ชื่อรูป  จากฟอร์มแก้ไขข้อมูล
//Creator: 25/01/2019 saharat
//Return: -
//Return -
function JSxCSTDelImg(pnFNImgID, ptImgObj, tMsg) {
    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirm'],
        buttons: {
            confirm: {
                label:  aLocale['tBtnConfirm'],
                className: 'xCNBTNPrimery'
            },
            cancel: {
                label: aLocale['tBtnClose'],
                className: 'xCNBTNDefult'
            }
           
        },
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    type: "POST",
                    url: "EticketCustomer/DelImg",
                    data: {
                        tImgID : pnFNImgID,
                        tNameImg : ptImgObj,
                    },
                    cache: false,
                    success: function (msg) {
                        $('#oimImgMasterMain').attr("src", "application/modules/common/assets/images/Noimage.png");
                        $('#oDelImgRoom').hide();
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    });
}
