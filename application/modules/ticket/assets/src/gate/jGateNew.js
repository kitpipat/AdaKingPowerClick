// ข้อมูลหน้า ก่อนหน้า
function JSxGatePreviousPage() {
    var nCurrentPage = $('#ospPageActiveGate').text();
    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }
    $('#ospPageActiveGate').text(nPreviousPage);
    JSxGateListView();
}

// ข้อมูลหน้า หน้าถัดไป
function JSxGateForwardPage() {
    var nCurrentPage = $('#ospPageActiveGate').text();
    var nTotalPage = $('#ospTotalPageGate').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageActiveGate').text(nForwardPage);
    JSxGateListView();
}
function JSvPClickPage(tNumPage) {
    $('#ospPageActiveGate').text(tNumPage);
    JSxGateListView();
}

// แสดงข้อมูลสาขา
function JSxGateListView(nPageNo) {
    JCNxOpenLoading();
    var tFTGateName = $('#oetSCHFTGateName').val();
    var nPageNo = $('#ospPageActiveGate').text();
    var tLocID = $('#ohdGetLocID').val();	
    $('.icon-loading').show();
    $.ajax({
        type: "POST",
        url: "EticketGateListNew",
        data: {tFTGateName: tFTGateName, nLocID: tLocID, nPageNo: nPageNo},
        cache: false,
        success: function (msg) {
           $('#oResultGate').html(msg);
           var  ospPageActiveGate = $('#ospPageActiveGate').text();
           var  ospTotalPageGate = $('#ospTotalPageGate').text();
           var  tHtml = '';
                tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
                tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxGatePreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
                var i;
                var l;
                for (i = 0; i < parseInt(ospTotalPageGate); i++) {
                    l = i + 1;
                    if (parseInt(ospPageActiveGate) == l) {
                        tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                    } else {
                        tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                    }
                }
                tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxGateForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
                tHtml += '</div>';

                $('.xWGridFooter').html(tHtml);
                if (ospPageActiveGate == '1') {
                    $('#oPreviousPage').attr('disabled',true);
                } else {
                    $('#oPreviousPage').attr('disabled',false);
                }
                if (ospPageActiveGate == ospTotalPageGate) {
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

// นับจำนวนค้นหาสาขา
function JSxGateCount(pnPage) {
    var tFTGateName = $('#oetSCHFTGateName').val();
    var tLocID = $('#ohdGetLocID').val();
    var nLocID = $('#ohdGetLocID').val();	
    $.ajax({
        type: "POST",
        url: "EticketGateCount",
        data: {tFTGateName: tFTGateName, nLocID: tLocID},
        cache: false,
        success: function (msg) {
            $('#oLocGateCount').text(msg);
            $('#ospPageActiveGate').text('1');
            $('#ospTotalPageGate').text(Math.ceil(parseInt(msg) / 5));
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
            if(pnPage != 1 && pnPage != $('#ospTotalPage').text()){
                var nPageAll = pnPage;
                var nPageTotal = nPageAll - 1 ;
                pnPage = nPageTotal;
                $('#ospPageActiveGate').text(pnPage);
            }else{
                $('#ospPageActiveGate').text(pnPage);
			}
			
            JSxGateListView(pnPage);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

/**
* FS แก้ไขโซน
*/
function JSxEditGate(tFNGteID, tFTGteName, nZneID) {
	$('#oetHDFNGteIDEditGate').val(tFNGteID);
	$('#oetEditFTGteName').val(tFTGteName);
	$('#ohdZneIDEditCheck').val(nZneID);	
	var tLocID = $('#oetHDFNLocIDAddZone').val();
	$.ajax({
		type : "POST",
		url : "EticketLoadZoneSlc/" + tLocID,
		data : {
			tLocID : tLocID
		},
		cache : false,
		success : function(data) {
			$('#ocmSlcListZoneLoad').html(data);
			$('select[id=ocmSlcListZoneLoad]').val(nZneID);
		},
		error : function(data) {
			console.log(data);
		}
	});
	
	
	
}

/**
* FS ลบทางเข้า
*/
function JSxDelGate(pnPage,tGteID, tMsg) {	
    var nLocID = $('#ohdGetLocID').val();	
    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + tMsg+' ('+tGteID+')',
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
                url: "EticketDelGateNew",
                data: {tGteID: tGteID},
                cache: false,
                success: function (msg) {
                    window.onload = JSxGateCount(pnPage);
                },
                error: function (data) {
                    console.log(data);
                }
            });
           }           
       }
   });
}

/**
* FS load ทางเข้า
*/
function FSxLoadGate() {
	$('#xWNameMngLocs').removeAttr("style").css({'font-weight': 'bold', 'margin-top': '10px'});
	$('#oTbList2').hide();
	$('#oResultHoliday').html('');
	JSxGateCount();
}
$('.modal').on(
  'hidden.bs.modal',
  function(e) {
   $(this).find("input[type=text],textarea").val('').end().find(
     "input[type=text], input[type=checkbox], input[type=radio]").prop("checked",
     "").end();
     $('.modal').removeClass('input-invalid');

});


//Functionality: Function Chack ลบข้อมูลทั้งหมด ของ ลูกค้า
//Parameters: เลขหน้า
//Creator: 23/01/2019 saharat
//Return: - 
//Return Type: -
function FSxDelAllOnCheck(pnPage) {
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
                    url: "EticketDelGateNew",
                    data: {
                        'tGteID': ocbListItem.join()
                    },
                    cache: false,
                    success: function (msg) {
                        $('#ospPageActiveGate').text(pnPage);
                        JSxGateCount(pnPage);
                        
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
//Parameters: Event Select List Gate
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