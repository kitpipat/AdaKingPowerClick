/**
 * สาขา pagination และ ค้นหา
 */
// ข้อมูลหน้า ก่อนหน้า
function JSxDayoffPreviousPage() {
    // alert('PreviousPage');
    var nCurrentPage = $('#ospPageActiveDayoff').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageActiveDayoff').text(nPreviousPage);
    JSxDayoffListView();
}

// ข้อมูลหน้า หน้าถัดไป
function JSxDayoffForwardPage() {
    // alert('ForwardPage');
    var nCurrentPage = $('#ospPageActiveDayoff').text();
    var nTotalPage = $('#ospTotalPageDayoff').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageActiveDayoff').text(nForwardPage);
    JSxDayoffListView();
}
function JSvPClickPage(tNumPage) {
    $('#ospPageActiveDayoff').text(tNumPage);
    JSxDayoffListView();
}

// แสดงข้อมูลสาขา
function JSxDayoffListView() {
	var tFDLdoDateFrm = $('#oetSCHFDLdoDateFrm').val();
    var nPageNo = $('#ospPageActiveDayoff').text();
    var nLocID = $('#ohdGetLocID').val();	
    $.ajax({
        type: "POST",
        url: "EticketLocDayOffList",
        data: {nLocID: nLocID, tFDLdoDateFrm: tFDLdoDateFrm, nPageNo: nPageNo},
        cache: false,
        success: function (msg) {
         $('#oResultDayoff').html(msg);
         var ospPageActiveDayoff = $('#ospPageActiveDayoff').text();
         var ospTotalPageDayoff = $('#ospTotalPageDayoff').text(); 
         var tHtml = '';

            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxDayoffPreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalPageDayoff); i++) {
                l = i + 1;
                if (parseInt(ospPageActiveDayoff) == l) {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxDayoffForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

            $('.xWGridFooter').html(tHtml);

        if (ospPageActiveDayoff == '1') {
           $('#oPreviousPage').attr('disabled',true);
        } else {
           $('#oPreviousPage').attr('disabled',false);
        }
        if (ospPageActiveDayoff == ospTotalPageDayoff) {
           $('#oForwardPage').attr('disabled',true);
        } else {
           $('#oForwardPage').attr('disabled',false);
        }
   },
   error: function (data) {
    console.log(data);
}
});
}

// นับจำนวนค้นหาสาขา
function JSxDayoffCountSearch() {
    var nLocID = $('#ohdGetLocID').val();
    var oetSCHFDLdoDateFrm = $('#oetSCHFDLdoDateFrm').val();
    if (oetSCHFDLdoDateFrm == "") {
      var tFDLdoDateFrm = '';		
  } else {
      var tFDLdoDateFrm = oetSCHFDLdoDateFrm;
  }
  $('.xCNOverlay').show();
  $.ajax({
    type: "POST",
    url: "EticketLocDayOffCount",
    data: {nLocID: nLocID, tFDLdoDateFrm: tFDLdoDateFrm},
    cache: false,
    success: function (msg) {
        $('#ospTotalRecordDayoff').text(msg);
        $('#ospPageActiveDayoff').text('1');
        $('#ospTotalPageDayoff').text(Math.ceil(parseInt(msg) / 5));	
        if (msg.trim() == '0') {
            $('.xWGridFooter').hide();
            $('.grid-resultpage').hide();
        } else {
            $('.xWGridFooter').show();	
            $('.grid-resultpage').show();	
        }					
        JSxDayoffListView();
         $('.xCNOverlay').hide();
    },
    error: function (data) {
        console.log(data);
    }
});
}

/**
Functionality : ลบวันหยุด
Create : P'Nut
Edit : 10/01/2019 Krit(Copter)
Paramitter : tDayOffID รหัส , tMsg ข้อความ
*/
function JSxDOFDel(tDayOffID, tMsg) {	
    bootbox.confirm({
        title:aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + tMsg,
        buttons: {
            cancel: {
                label: aLocale['tBtnConfirm'],
                className: 'xCNBTNPrimery'
            },
            confirm: {
                label: aLocale['tBtnCancel'],
                className: 'xCNBTNDefult'
            }
            
        },
        callback: function (result) {
            if (result == false) {
                $.ajax({
                    type: "POST",
                    url: "EticketLocDayOffDel",
                    data: {nFNLdoID: tDayOffID},
                    cache: false,
                    success: function (msg) {
                        JSxDayoffCountSearch();
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }           
        }
    });
}