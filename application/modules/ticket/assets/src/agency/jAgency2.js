function JSnAgnBtnGen() {
    $.ajax({
        type: "POST",
        url: "EticketAgency_GenAPI",
        data: {},
        cache: false,
        success: function (msg) {
            msg = msg.trim();
            $('#oetAgnKeyAPI').val(msg);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxAGNDelImg(nImgID,tImgObj,tMsg) {
    bootbox.confirm({
        title: 'ยืนยันการลบข้อมูล',
        message: tMsg,
        buttons: {
            cancel: {
                label: aLocale['tBtnConfirm'],
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
                    type: "POST",
                    url: "EticketAgency_DelImg",
                    data: {
                        tImgID: nImgID,
                        tNameImg: tImgObj
                    },
                    cache: false,
                    success: function (msg) {
                        $('#oimImgMasterMain').attr("src","application/modules/common/assets/images/Noimage.png");
                        $('#oDelImgAgn').hide();
                        $('.xWimageLoc').attr("src", "application/modules/common/assets/images/NoPic.png");
                        $('#olaDelImgAgn').hide();
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });

            }
        }
    });
}

// ข้อมูลหน้า หน้าถัดไป
function JSxAGNForwardPage() {
	// alert('PreviousPage');
    var nCurrentPage = $('#ospPageActive').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageActive').text(nPreviousPage);
    JSxAGNSearchListView();
}

function JSvPClickPage(tNumPage) {
	$('#ospPageActive').text(tNumPage);
	JSxAGNSearchListView();
}
// ข้อมูลหน้า ก่อนหน้า
function JSxAGNPreviousPage() {
	// alert('ForwardPage');
	var nCurrentPage = $('#ospPageActive').text();
	var nTotalPage = $('#ospTotalPage').text();
	var nForwardPage
	if (nCurrentPage == nTotalPage) {
		nForwardPage = nTotalPage;
	} else {
		nForwardPage = parseInt(nCurrentPage) + 1;
	}
	$('#ospPageActive').text(nForwardPage);
	JSxAGNSearchListView();
}

function FSxDelAgn(nAgnID, tMsg) {
    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + tMsg,
        buttons: {
            cancel: {
                label: '<i class="fa fa-times-circle" aria-hidden="true"></i> ' + aLocale['tBtnClose'],
                className: 'xCNBTNDefult'
            },
            confirm: {
                label: '<i class="fa fa-check-circle" aria-hidden="true"></i> ' + aLocale['tBtnConfirm'],
                className: 'xCNBTNPrimery'
            }
        },
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    type: "POST",
                    url: "EticketAgency_Del",
                    data: {
                        nAgnID: nAgnID
                    },
                    cache: false,
                    success: function (tResult) {
                        tResult = tResult.trim();
                        JSxCallPage('EticketAgency');
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    });
}


function JSxUsrDistrict(nPvnID) {

    $.ajax({
        type: "POST",
        url: "EticketDistrict",
        data: {
            ocmFNPvnID: nPvnID
        },
        cache: false,
        success: function (msg) {
            $('#ocmAgnDstID').html(msg);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSvAPClickPage(tNumPage) {
    $('#ospPageActive').text(tNumPage);
    JSxAGNSearchListView();
    //alert(tNumPage);
}

// แสดง Agency
function JSxAGNSearchListView(nPageNo) {
    JCNxOpenLoading();
    var tAgnName = $('#oetAgnName').val();
    var nPageNo  = $('#ospPageActive').text();
    $.ajax({
        type: "POST",
        url: "EticketAgency_List",
        data: {
            tAgnName: tAgnName,
            nPageNo: nPageNo
        },
        cache: false,
        success: function (msg) {
            $('#oResultAgency').html(msg);
            var tTotalPage  =  $('#ospTotalPage').text();
            var tPageActive =  $('#ospPageActive').text(); 
            var tHtml = '';
            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxAGNForwardPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(tTotalPage); i++) {
                l = i + 1;
                if (parseInt(tPageActive) == l) {
                    tHtml += '<button onclick="JSvAPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled>' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvAPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxAGNPreviousPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

            $('.xWGridFooter').html(tHtml);
            if (tPageActive == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (tPageActive == tTotalPage) {
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

function JSxAGECount(nPageNo) {
    var tAgnName = $('#oetAgnName').val();
    if (tAgnName == "") {
        var tAgnName = '';
    } else {
        var tAgnName = tAgnName;
    }
    $('.xCNOverlay').show();
    $.ajax({
        type: "POST",
        url: "EticketAgency_Count",
        data: {
            tAgnName: tAgnName
        },
        cache: false,
        success: function (msg) {
            $('#ospTotalRecord').text(msg);
            $('#ospPageActive').text('1');
            $('#ospTotalPage').text(Math.ceil(parseInt(msg) / 8));
            if (msg.trim() == '0') {
                $('.xWGridFooter').hide();
                $('.grid-resultpage').hide();
            } else {
                $('.xWGridFooter').show();
                $('.grid-resultpage').show();
            }
            
            if(nPageNo == '' || nPageNo == undefined || nPageNo == null){
                nPageNo = 1;
            }
            if(nPageNo != 1 && nPageNo != $('#ospTotalPage').text()){
                var nPageAll = nPageNo;
                var nPageTotal = nPageAll - 1 ;
                nPageNo = nPageTotal;
                $('#ospPageActive').text(nPageNo);
            }else{
                $('#ospPageActive').text(nPageNo);
            }
     
            JSxAGNSearchListView(nPageNo);
            JSxCheckPinMenuClose(nPageNo);
            $('.xCNOverlay').hide();
        },
        error: function (data) {
            console.log(data);
            $('.xCNOverlay').hide();
        }
    });
}
// กดปุ่ม เลือกทั้งหมด ในฟอร์มกำหนดสิทธิ์การเข้าถึง API
function JSxAPICheckAllPvl() {
    if ($('#ocbCheckAllApiPvl').is(':checked')) {

        $('.ocbAPIList').prop('checked', true);
    } else {
        $('.ocbAPIList').prop('checked', false);
    }
}

// ดึงข้อมูลสิทธิ์การเข้าถึง API ของตัวแทนขายที่เลือก
// แล้วนำมาแสดงในฟอร์มกำหนดสิทธิ์การเข้าถึง API
function JSxAGESetPvl(ptAgenId, ptAgenName, ptAgnKeyAPI) {

    $('#ocbCheckAllApiPvl').prop('checked', false);// เคลียร์ค่า checkbox
    // เลือกทั้งหมดในฟอร์มแสดงสิทธิ์การเข้าถึง
    // API
    $('.ocbAPIList').prop('checked', false); // เคลียร์ค่า checkbox
    // ที่ถูกเลือกอยู่ในฟอร์มแสดงสิทธิ์การเข้าถึง
    // API

    $('#ospAgenId').text(ptAgenId); // เติมรหัสตัวแทนขายในฟอร์ม
    $('#ospAgenName').text(ptAgenName);// เติมชื่อตัวแทนขายในฟอร์ม
    $('#oetAgnKeyAPI').val(ptAgnKeyAPI);

    var tAgencyId = $('#ospAgenId').text().trim(); // ดึงรหัสตัวแทนขาย

    // ดึงข้อมูลสิทธิ์การเข้าถึง API ของตัวแทนขายที่เลือก
    $.ajax({
        url: 'EticketGetAPIFuncAgency',
        data: {
            tAgencyId: ptAgnKeyAPI
        },
        method: "POST"
    }).done(function (tResult) {
        var tAPIAcc = tResult.trim();
        var aAPIAcc = tAPIAcc.split(',');
        // alert(tResult);
        // แสดงข้อมูลสิทธิ์การเข้าถึง API ของตัวแทนขายที่เลือก
        for (var i = 0; i < aAPIAcc.length; i++) {
            $('.ocbAPIList[value="' + aAPIAcc[i] + '"]').prop('checked', true);
        }
    }).fail(function (jqXHR, textStatus) {
        alert('Error:' + jqXHR + ' ' + textStatus);
    });
}

// บันทึกข้อมูลข้อมูลหลัก Agency
function JSxAGESaveMaster() {
    // alert('Enter Save Agency');
    if ($('#oetFTAgcUserName').val().length == 0) {
        $('#oetFTAgcUserName').focus();
    } else if ($('#oetFTAgcPass').val().length == 0) {
        $('#oetFTAgcPass').focus();
    } else if ($('#oetFTAgcName').val().length == 0) {
        $('#oetFTAgcName').focus();
    } else if ($('#oetAgcLastName').val().length == 0) {
        $('#oetAgcLastName').focus();
    } else if ($('#oetAgcEmail').val().length == 0) {
        $('#oetAgcEmail').focus();
    } else {
        $.ajax({
            url: 'EticketSaveAgency',
            data: $("#ofmAgency").serialize(),
            method: "POST"
        }).done(function (tResult) {
            // alert(tResult);
            // $('#odvMainContent').html(tResult);
            $('#modal-add-agency').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            // JSxProductGroup();
            JSxAGEListView();

        }).fail(function (jqXHR, textStatus) {
            alert('Error:' + jqXHR + ' ' + textStatus);
        });
    }

}

// บันทึกสิทธิ์การเข้าถึง API ของตัวแทนขาย
function JSxAGESaveAPIPvl() {

    // ดึงข้อมูลสิทธิ์การเข้าถึง API เอาเฉพาะค่าที่เลือกไว้ Checkbox Checked
    // เก็บในรูปแบบ Array
    var aAPIFun = [];
    $('.ocbAPIList:checked').each(function () {
        aAPIFun.push($(this).val());
    });

    var tAgencyId = $('#oetAgnKeyAPI').val(); // รหัสตัวแทนขาย

    $.ajax({
        url: 'EticketSaveAccessAPI',
        data: {
            tAgencyId: tAgencyId,
            aAPIFun: aAPIFun
        },
        method: "POST"
    }).done(function (tResult) {
        // bootbox.alert(tResult);
        bootbox.alert("บันทึกข้อมูลเรียบร้อย!");
    }).fail(function (jqXHR, textStatus) {
        alert('Error:' + jqXHR + ' ' + textStatus);
    });

}

// เติมข้อมูลในฟอร์มตรวจสอบข้อมูลตัวแทนขาย
function JSxAGEEditInfo(ptAgenId, ptAgenName, ptAgenAddress, ptAgenSubDist,
        ptAgenDistric, ptAgenProvince, ptAgenTel, ptEmail, ptAgenCmp, pnStaApv) {

    $('#ocbAgeApprove').prop('checked', false);
    $('#ohdAgencyIdInf').val(ptAgenId);
    $('#oetAgencyName').val(ptAgenName);
    $('#oetAgencyAddressInf').val(ptAgenAddress);
    $('#oetAgencySubDistricInf').val(ptAgenSubDist);
    $('#oetAgencyDistricInf').val(ptAgenDistric);
    $('#oetAgencyProvinceInf').val(ptAgenProvince);
    $('#oetAgencyTelInf').val(ptAgenTel);
    $('#oetAgencyEmailInf').val(ptEmail);
    $('#oetAgencyCmpInf').val(ptAgenCmp);
    if (pnStaApv == '1') {
        $('#ocbAgeApprove').prop('checked', true);
    } else {
        $('#ocbAgeApprove').prop('checked', false);
    }
}

// บันทึกข้อมูลในฟอร์มแก้ไขข้อมูลตัวแทนขาย
function JSxAGEEdit() {
    var tAgencyId = $('#ohdAgencyIdInf').val();
    var tAgencyName = $('#oetAgencyName').val();
    var tAgencyAddress = $('#oetAgencyAddressInf').val();
    var tAgencySubDistric = $('#oetAgencySubDistricInf').val();
    var tAgencyDistric = $('#oetAgencyDistricInf').val();
    var tAgencyProvince = $('#oetAgencyProvinceInf').val();
    var tAgencyTel = $('#oetAgencyTelInf').val();
    var tAgencyEmail = $('#oetAgencyEmailInf').val();
    var tAgencyCmp = $('#oetAgencyCmpInf').val();
    var nAgenApv;
    if ($("#ocbAgeApprove").is(":checked")) {
        nAgenApv = 1;
    } else {
        nAgenApv = 2;
    }
    $('.xCNOverlay').show();
    $.ajax({
        url: 'EticketEditAgencyData',
        data: {
            tAgencyId: tAgencyId,
            tAgencyAddress: tAgencyAddress,
            tAgencySubDistric: tAgencySubDistric,
            tAgencyDistric: tAgencyDistric,
            tAgencyProvince: tAgencyProvince,
            tAgencyTel: tAgencyTel,
            tAgencyEmail: tAgencyEmail,
            tAgencyCmp: tAgencyCmp,
            nAgenApv: nAgenApv
        },
        method: "POST"
    }).done(function (tResult) {
        // alert(tResult);
        // bootbox.alert("บันทึกข้อมูลเรียบร้อย!");
        JSxAGEListView();
        $('.xCNOverlay').hide();

    }).fail(function (jqXHR, textStatus) {
        alert('Error:' + jqXHR + ' ' + textStatus);
        $('.xCNOverlay').hide();
    });
}

// ข้อมูลหน้า ก่อนหน้า
function JSxAgencyPreviousPage() {
    // alert('PreviousPage');
    var nCurrentPage = $('#ospPageActive').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageActive').text(nPreviousPage);

    JSxAGEListView();
}

// ข้อมูลหน้า หน้าถัดไป
function JSxAgencyForwardPage() {
    // alert('ForwardPage');
    var nCurrentPage = $('#ospPageActive').text();
    var nTotalPage = $('#ospTotalPage').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageActive').text(nForwardPage);

    JSxAGEListView();
}

// แสดงข้อมูลตัวแทนจำหน่าย
function JSxAGEListView() {

    var tAgencyNameFilter = $('#oetAgencyNameFilter').val();
    var tAgencyEmailFilter = $('#oetAgencyEmailFilter').val();
    var tAgencyStaFilter = $('#ocbAgencyStaFilter').val();
    var nPageNo = $('#ospPageActive').text();

    $.ajax({
        url: 'EticketAgency',
        data: {
            tAgencyNameFilter: tAgencyNameFilter,
            tAgencyEmailFilter: tAgencyEmailFilter,
            tAgencyStaFilter: tAgencyStaFilter,
            nPageNo: nPageNo
        },
        method: "POST"
    }).done(function (tResult) {
        $('#odvMainContent').html(tResult);
        $('#modal-edit-agency').modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        // JSxProductGroup();
        JSxCheckPinMenuClose();
    }).fail(function (jqXHR, textStatus) {
        alert('Error:' + jqXHR + ' ' + textStatus);
    });

}


//Functionality: Function Chack ลบข้อมูลตัวแทนขาย
//Creator: 23/01/2019 saharat
//Return: - 
//Return Type: -
function JSxAGEDelete(pnPage,ptFTAgnCode, tMsg) {
    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + ptFTAgnCode + ' ('+tMsg+') ',
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
                url: "EticketDeleteAgency",
                data: {
                    ptAgenId : ptFTAgnCode
                },
                success: function (tResult) {
                    aResult = JSON.parse(tResult);
                    nCount = aResult.count;
                    // tMsg = aResult.msg;
                    if (nCount == 1) {
                        $('#ospPageActive').text(pnPage);
                        JSxAGECount(pnPage);
                    }else{
                        bootbox.alert({
                            title: aLocale['tWarning'],
                            // message: tMsg,
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
// กลุ่มลูกค้า
// ข้อมูลหน้า ก่อนหน้า
function JSxAGEGroupPreviousPage() {
    // alert('PreviousPage');
    var nCurrentPage = $('#ospPageGroupActive').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageGroupActive').text(nPreviousPage);
    JSxAGEGroupListView();
}
// ข้อมูลหน้า หน้าถัดไป
function JSxAGEGroupForwardPage() {
    // alert('ForwardPage');
    var nCurrentPage = $('#ospPageGroupActive').text();
    var nTotalPage = $('#ospTotalGroupPage').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageGroupActive').text(nForwardPage);
    JSxAGEGroupListView();
}

function JSvPClickPage(tNumPage) {
    $('#ospPageGroupActive').text(tNumPage);
    JSxAGEGroupListView();
}

function JSxAGEGroupListView(nPageNo) {
    JCNxOpenLoading();
    var tFTAggName = $('#oetSCHFTGroupName').val();
    var nPageNo = $('#ospPageGroupActive').text();
    $.ajax({
        type: "POST",
        url: "EticketAgency/groupAjaxList",
        data: {
            tFTAggName: tFTAggName,
            nPageNo: nPageNo
        },
        cache: false,
        success: function (msg) {
            $('#oResultGroup').html(msg);
            var ospPageGroupActive = $('#ospPageGroupActive').text();
            var ospTotalGroupPage = $('#ospTotalGroupPage').text();
            var tHtml = '';
            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxAGEGroupPreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalGroupPage); i++) {
                l = i + 1;
                if (parseInt(ospPageGroupActive) == l) {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxAGEGroupForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

            $('.xWGridFooter').html(tHtml);
            if (ospPageGroupActive == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (ospPageGroupActive == ospTotalGroupPage) {
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

function JSxAGEGroupCount(pnPage) {
    var tFTAggName = $('#oetSCHFTGroupName').val();
    if (tFTAggName == "") {
        var tFTAggName = '';
    } else {
        var tFTAggName = tFTAggName;
    }
    $('.xCNOverlay').show();
    $.ajax({
        type: "POST",
        url: "EticketAgency/groupCount",
        data: {
            tFTAggName: tFTAggName
        },
        cache: false,
        success: function (msg) {
            $('#ospPageGroupActive').text('1');
            $('#ospTotalGroupRecord').text(msg);
            $('#ospTotalGroupPage').text(Math.ceil(parseInt(msg) / 8));
            if (msg.trim() == '0') {
                $('.xWGridFooter').hide();
                $('.grid-resultpage').hide();
            } else {
                $('.xWGridFooter').show();
                $('.grid-resultpage').show();

            }
            
            if(pnPage == '' || pnPage == undefined || pnPage == null){
                pnPage = 1;
            }
            if(pnPage != 1 && pnPage != $('#ospTotalGroupPage').text()){
                var nPageAll = pnPage;
                var nPageTotal = nPageAll - 1 ;
                pnPage = nPageTotal;
                $('#ospPageGroupActive').text(pnPage);
            }else{
                $('#ospPageGroupActive').text(pnPage);
            }

            JSxAGEGroupListView(pnPage);
            JSxCheckPinMenuClose();
            $('.xCNOverlay').hide();
        },
        error: function (data) {
            console.log(data);
            $('.xCNOverlay').hide();
        }
    });
}

// ลบ Group ธรรมดา
function JSxAGEGroupDel(pnPage,pnFTAggCode, tMsg) {
        bootbox.confirm({
            title: aLocale['tConfirmDelete'],
            message: aLocale['tConfirmDeletionOf'] + ' ' + pnFTAggCode + ' ('+tMsg+')',
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
                        url: "EticketAgency/deleteGroup",
                        data: {
                            nFTAggCode: pnFTAggCode
                        },
                        success: function (tResult) {
                            aResult = JSON.parse(tResult);
                            // console.log(aResult);
                            nStatus = aResult.status;
                            tMsg = aResult.msg;
                            if (nStatus == 1) {
                                $('#ospPageGroupActive').text(pnPage);
                                JSxAGEGroupCount(pnPage);
                            }else{
                                bootbox.alert({
                                    title: aLocale['tWarning'],
                                    // message: tMsg,
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

//Functionality: Function Chack Delete All  CheckGroup
//Parameters: pnPage หน้าที่ลบจากฟอร์ม Group
//Creator: 23/01/2019 saharat
//Return: - 
//Return Type: -
function FSxDelAllOnCheckGroup(pnPage) {
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
        url: "EticketAgency/deleteGroup",
        data: {
            'nFTAggCode': ocbListItem.join()
        },
        cache: false,
        success: function (msg) {
            $('#ospPageGroupActive').text(pnPage);
            JSxAGEGroupCount(pnPage);
            
            $('.modal-backdrop').remove(); 
            $('.obtChoose').hide(); 
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        },
        error: function (data) {
            console.log(data);
        }
    });
}
/** *************** */
// ประเภทลูกค้า
// ข้อมูลหน้า ก่อนหน้า
function JSxAGETypePreviousPage() {
    // alert('PreviousPage');
    var nCurrentPage = $('#ospPageTypeActive').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageTypeActive').text(nPreviousPage);
    JSxAGETypeListView();
}
// ข้อมูลหน้า หน้าถัดไป
function JSxAGETypeForwardPage() {
    // alert('ForwardPage');
    var nCurrentPage = $('#ospPageTypeActive').text();
    var nTotalPage = $('#ospTotalTypePage').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageTypeActive').text(nForwardPage);
    JSxAGETypeListView();
}

function JSvPTypeClickPage(tNumPage) {
    $('#ospPageTypeActive').text(tNumPage);
    JSxAGETypeListView();
}

function JSxAGETypeListView(pnPage) {
    JCNxOpenLoading();
    var tFTAtyName = $('#oetSCHFTTypeName').val();
    var nPageNo = $('#ospPageTypeActive').text();
    $.ajax({
        type: "POST",
        url: "EticketAgency/TypeAjaxList",
        data: {
            tFTAtyName: tFTAtyName,
            nPageNo: nPageNo
        },
        cache: false,
        success: function (msg) {
            $('#oResultType').html(msg);
            var ospPageTypeActive = $('#ospPageTypeActive').text();
            var ospTotalTypePage = $('#ospTotalTypePage').text();
            var tHtml = '';
            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxAGETypePreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalTypePage); i++) {
                l = i + 1;
                if (parseInt(ospPageTypeActive) == l) {
                    tHtml += '<button onclick="JSvPTypeClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvPTypeClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxAGETypeForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

            $('.xWGridFooter').html(tHtml);
            if (ospPageTypeActive == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (ospPageTypeActive == ospTotalTypePage) {
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

function JSxAGETypeCount(pnPage) {
    var tFTAtyName = $('#oetSCHFTTypeName').val();
    if (tFTAtyName == "") {
        var tFTAtyName = '';
    } else {
        var tFTAtyName = tFTAtyName;
    }
    $('.xCNOverlay').show();
    $.ajax({
        type: "POST",
        url: "EticketAgency/TypeCount",
        data: {
            tFTAtyName: tFTAtyName
        },
        cache: false,
        success: function (msg) {
            $('#ospTotalTypeRecord').text(msg);
            $('#ospPageTypeActive').text('1');
            $('#ospTotalTypePage').text(Math.ceil(parseInt(msg) / 8));
            if (msg.trim() == '0') {
                $('.xWGridFooter').hide();
                $('.grid-resultpage').hide();
            } else {
                $('.xWGridFooter').show();
                $('.grid-resultpage').show();
            }

            if(pnPage == '' || pnPage == undefined || pnPage == null){
                pnPage = 1;
            }
            if(pnPage != 1 && pnPage != $('#ospTotalTypePage').text()){
                var nPageAll = pnPage;
                var nPageTotal = nPageAll - 1 ;
                pnPage = nPageTotal;
                $('#ospPageTypeActive').text(pnPage);
            }else{
                $('#ospPageTypeActive').text(pnPage);
            }

            JSxAGETypeListView(pnPage);
            JSxCheckPinMenuClose();
            $('.xCNOverlay').hide();
        },
        error: function (data) {
            console.log(data);
            $('.xCNOverlay').hide();
        }
    });
}




// ลบ Type ธรรมดา
function JSxAGETypeDel(pnPage,pnFTAtyCode, tMsg) {
        bootbox.confirm({
            title: aLocale['tConfirmDelete'],
            message: aLocale['tConfirmDeletionOf'] + ' ' + pnFTAtyCode + ' ('+tMsg+')',
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
                    url: "EticketAgency/deleteType",
                    data: {
                        nFTAtyCode : pnFTAtyCode
                    },
                    success: function (tResult) {
                        aResult = JSON.parse(tResult);
                        nCount = aResult.count;
                        tMsg = aResult.msg;
                        if (nCount == 1) {
                            $('#ospPageTypeActive').text(pnPage);
                            JSxAGETypeCount(pnPage);
                        }else{
                            bootbox.alert({
                                title: aLocale['tWarning'],
                                // message: tMsg,
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
//Parameters: pnPage หน้าของรายการType
//Creator: 23/01/2019 saharat
//Return: - 
//Return Type: -
function FSxDelAllOnCheckType(pnPage) {
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
        url: "EticketAgency/deleteType",
        data: {
            'nFTAtyCode': ocbListItem.join()
        },
        cache: false,
        success: function (msg) {
            $('#ospPageTypeActive').text(pnPage);
            JSxAGETypeCount(pnPage);
            
            $('.modal-backdrop').remove(); 
            $('.obtChoose').hide(); 
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        },
        error: function (data) {
            console.log(data);
        }
    });
}



function FSxDelAllOnCheckAgn(pnPage) {
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
            url: "EticketAgency_Del",
            data: {
                'nAgnID': ocbListItem.join()
            },
            cache: false,
            success: function (msg) {
                $('#ospPageActive').text(pnPage);
                JSxAGECount(pnPage);
                
                $('.modal-backdrop').remove(); 
                $('.obtChoose').hide(); 
                $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
            },
            error: function (data) {
                console.log(data);
            }
        });
    }


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



function findObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return 'Dupilcate';
        }
    }
    return 'None';
}


// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 07/06/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbAgencyIsCreatePage(){
    try{
        const tAgnCode = $('#oetAgnCode').data('is-created');    
        var bStatus = false;
        if(tAgnCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbAgencyIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 07/06/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbAgencyIsUpdatePage(){
    try{
        const tAgnCode = $('#oetAgnCode').data('is-created');
        var bStatus = false;
        if(!tAgnCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbAgencyIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator: 07/06/2019 saharat(Golf)
// Return : -
// Return Type : -
function JSxAgencyVisibleComponent(ptComponent, pbVisible, ptEffect){
    try{
        if(pbVisible == false){
            $(ptComponent).addClass('hidden');
        }
        if(pbVisible == true){

            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    }catch(err){
        console.log('JSxAgencyVisibleComponent Error: ', err);
    }
}
