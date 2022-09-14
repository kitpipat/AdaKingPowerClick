/**
 * FS โหลดข้อมูลหน้าสาขา
 */
 function JSxParkDetail(ptParkId) {
	// JCNhtmlLoadController('ParkDetail','odvMainContent');
	var tParkId = ptParkId;
	$.ajax({
		url : 'EticketBranchDetail',
		data : {
			tParkId : tParkId
		},
		method : "POST"
	}).success(function(tResault) {
		$('#odvMainContent').html(tResault);
	}).error(function(data) {
		console.log(data);
	});
}
function FSSetShow() {
	$('#modal-show-seat').modal('show');
}

/**
 * ลบสาขา
 */
 function JSxPRKDel(ptParkId, tMsg) {
 	bootbox.confirm({
 		title: aLocale['tConfirmDelete'],
		message: aLocale['tConfirmDeletionOf'] + ' ' + $(tMsg).data('name'),
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
 					url: "EticketDeleteBranch",
 					data: {
 						tParkId : ptParkId
 					},
 					cache: false,
 					success: function (oData) {
 						oBj = JSON.parse(oData);
 						if (oBj.count == 1) {
 							alert(oBj.msg);
 						} else {
 							JSxCallPage('EticketBranch');
 						}
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
 * สาขา pagination และ ค้นหา
 */

// ข้อมูลหน้า ก่อนหน้า
function JSxPRKPreviousPage() {
	// alert('PreviousPage');
	var nCurrentPage = $('#ospPageActive').text();
	var nPreviousPage
	if (nCurrentPage == 1) {
		nPreviousPage = 1;
	} else {
		nPreviousPage = parseInt(nCurrentPage) - 1;
	}
	$('#ospPageActive').text(nPreviousPage);
	JSxPRKListView();
}
function JSvPClickPage(tNumPage) {
	$('#ospPageActive').text(tNumPage);
	JSxPRKListView();
}
// ข้อมูลหน้า หน้าถัดไป
function JSxPRKForwardPage() {
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
	JSxPRKListView();
}
// แสดงข้อมูลสาขา
function JSxPRKListView() {
	var tFTPmoName = $('#oetFTPmoName').val();
	var nPageNo = $('#ospPageActive').text();
	$('.icon-loading').show();
	$.ajax({
		type : "POST",
		url : "EticketBranchAjax",
		data : {
			tFTPmoName : tFTPmoName,
			nPageNo : nPageNo
		},
		cache : false,
		success : function(msg) {
			$('#oResultPark').html(msg);
			var ospPageActive = $('#ospPageActive').text();
			var ospTotalPage = $('#ospTotalPage').text();
			var tHtml = '';
			tHtml = '<ul class="pagination xWEticketPagination justify-content-center">';
			tHtml += '<li class="page-item previous"><a class="page-link xWBtnPrevious" id="oPreviousPage" onclick="return JSxPRKPreviousPage();">'+aLocale['tPrevious']+'</a></li>';
			var i;
			var l;
			for (i = 0; i < parseInt(ospTotalPage); i++) { 
				l = i + 1;
				if (parseInt(ospPageActive) == l) {
					tHtml += '<li class="page-item active"><a class="page-link" onclick="JSvPClickPage(\''+l+'\');">'+ l +'</a></li>';
				} else {
					tHtml += '<li class="page-item"><a class="page-link" onclick="JSvPClickPage(\''+l+'\');">'+ l +'</a></li>';
				}				
			}
			tHtml += '<li class="page-item next"><a class="page-link xWBtnNext" id="oForwardPage" onclick="return JSxPRKForwardPage();">'+aLocale['tNext']+'</a></li>';
			tHtml += '</ul>';
			$('.xWGridFooter').html(tHtml);
			if (ospPageActive == '1') {
				$('#oPreviousPage').addClass('xCNDisable');
			} else {
				$('#oPreviousPage').removeClass('xCNDisable');
			}
			if (ospPageActive == ospTotalPage) {
				$('#oForwardPage').addClass('xCNDisable');
			} else {
				$('#oForwardPage').removeClass('xCNDisable');
			}
		},
		error : function(data) {
			console.log(data);
		}
	});
}
// นับจำนวนค้นหาสาขา
function JSxPRKCountSearch() {
	var tFTMcrCode = $('#oetFTMcrCode').val();
	var tFTPmoName = $('#oetFTPmoName').val();
	$.ajax({
		type : "POST",
		url : "EticketBranchAjaxSearch",
		data : {
			tFTMcrCode : tFTMcrCode,
			tFTPmoName : tFTPmoName
		},
		cache : false,
		success : function(msg) {
			$('#ospTotalRecord').text(msg);
			$('#ospPageActive').text('1');
			$('#ospTotalPage').text(Math.ceil(parseInt(msg) / 8));
			JSxPRKListView();
			if (msg == 0) {
				$('.xWBoxLocPark').hide();
			} else if (msg == 1) {
				$('.xWGridFooter.xWBoxLocPark').hide();
			} else {
				$('.xWBoxLocPark').show();
			}
			if (msg.trim() == '0') {
				$('.xWGridFooter').hide();
				$('.grid-resultpage').hide();
			} else {
				$('.xWGridFooter').show();
				$('.grid-resultpage').show();
			}
			JSxCheckPinMenuClose();
		},
		error : function(data) {
			console.log(data);
		}
	});
}
// โหลดอำเภอ
function JSxPRKDistrict(tID) {
	$.ajax({
		type : "POST",
		url : "EticketDistrict",
		data : {
			ocmFNPvnID : tID
		},
		cache : false,
		success : function(msg) {
			$('#ocmFNDstID').html(msg);
		},
		error : function(data) {
			console.log(data);
		}
	});
}
function JSxPRKProvince(tID) {
	$.ajax({
		type : "POST",
		url : "EticketProvince",
		data : {
			ocmFNAreID : tID
		},
		cache : false,
		success : function(msg) {
			$('#ocmFNPvnID').html(msg);
		},
		error : function(data) {
			console.log(data);
		}
	});
}
function JSxPRKAddAre() {
	$tFNAreID = $('#ocmFNAreID :selected');
	$tFNPvnID = $('#ocmFNPvnID :selected');
	$tFNDstID = $('#ocmFNDstID :selected');
	if ($('#otbAre #otdFNDstID:contains(' + $tFNDstID.text() + ')').length == 0) {
		$tHtml = '<tr id="otr'
		+ $tFNAreID.val()
		+ $tFNPvnID.val()
		+ $tFNDstID.val()
		+ '"><td>'
		+ $tFNAreID.text()
		+ '<input type="hidden" name="ohdFNAreID[]" value="'
		+ $tFNAreID.val()
		+ '"></td><td>'
		+ $tFNPvnID.text()
		+ '<input type="hidden" name="ohdFNPvnID[]" value="'
		+ $tFNPvnID.val()
		+ '"></td><td id="otdFNDstID">'
		+ $tFNDstID.text()
		+ '<input type="hidden" name="ohdFNDstID[]" value="'
		+ $tFNDstID.val()
		+ '"></td><td style="text-align: center;"><a href="javascript:void(0)" onclick="javascript: $(\'#otr'
		+ $tFNAreID.val()
		+ $tFNPvnID.val()
		+ $tFNDstID.val()
		+ '\').remove();"><i class="fa fa-trash-o fa-lg"></i></a></td></tr>';
		$('#otbAre tbody').append($tHtml);
		$('#otbAre tbody #otr').hide();
	}
}
function FSxDelImgPrk(nImgID, tImgObj, tMsg) {
	bootbox.confirm({
		title: aLocale['tConfirmDelete'],
		message: 'Are you sure to delete this item?',
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
					type : "POST",
					url : "EticketDelImgBranch",
					data : {
						tImgID : nImgID,
						tNameImg : tImgObj,
						tImgType: 1
					},
					cache : false,
					success : function(msg) {
						$('#oimImgMasterbranch').attr("src", "application/modules/common/assets/images/Noimage.png");
						$('#oDelImgPrk').hide();
					},
					error : function(data) {
						console.log(data);
					}
				});
			}           
		}
	});
}
function JSxLOCDelAre(tID, tMsg) {
	bootbox.confirm({
		title: aLocale['tConfirmDelete'],
		message: 'Are you sure to delete this item?',
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
					type : "POST",
					url : "EticketDelAre",
					data : {
						tID : tID
					},
					cache : false,
					success : function(msg) {
						$('#otr' + tID).remove();
					},
					error : function(data) {
						console.log(data);
					}
				});
			}           
		}
	});

}




