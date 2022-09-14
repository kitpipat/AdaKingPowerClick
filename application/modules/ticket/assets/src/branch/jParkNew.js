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
 function JSxPRKDel(pnCurrentPage, ptParkId, tMsg) {
    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + ptParkId + ' ('+tMsg+')',
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
 					type: "POST",
 					url: "EticketDeleteBranch",
 					data: {
 						tParkId : ptParkId
 					},
 					cache: false,
 					success: function (tResult) {
						tResult = tResult.trim();
						var tData = $.parseJSON(tResult);
 						if (tData.count != 1) {
							 alert(tData);
 						} else {
							JSxPRKCountSearch(pnCurrentPage);
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
function JSxPRKListView(nPageNo) {
	JCNxOpenLoading();
	var tFTPmoName = $('#oetFTPmoName').val();
	var nPageNo    = $('#ospPageActive').text();
	$('.icon-loading').show();
	$.ajax({
		type : "POST",
		url : "EticketBranchAjaxNew",
		data : {
			tFTPmoName : tFTPmoName,
			nPageNo    : nPageNo
		},
		cache : false,
		success : function(msg) {
			$('#oResultPark').html(msg);
			var ospPageActive = $('#ospPageActive').text();
			var ospTotalPage = $('#ospTotalPage').text();
			var tHtml = '';
            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxPRKPreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalPage); i++) {
                l = i + 1;
                if (parseInt(ospPageActive) == l) {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxPRKForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

            $('.xWGridFooter').html(tHtml);
            if (ospPageActive == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (ospPageActive == ospTotalPage) {
                $('#oForwardPage').attr('disabled',true);
            } else {
                $('#oForwardPage').attr('disabled',false);
			}
		JCNxCloseLoading();  
		},
		error : function(data) {
			console.log(data);
		}
	});
}
// นับจำนวนค้นหาสาขา
function JSxPRKCountSearch(pnPage) {
	var tFTMcrCode = $('#oetFTMcrCode').val();
	var tFTPmoName = $('#oetFTPmoName').val();
	$.ajax({
		type : "POST",
		url : "EticketBranchAjaxSearchNew",
		data : {
			tFTMcrCode : tFTMcrCode,
			tFTPmoName : tFTPmoName
		},
		cache : false,
		success : function(msg) {
			$('#ospTotalRecord').text(msg);
			$('#ospPageActive').text('1');
			$('#ospTotalPage').text(Math.ceil(parseInt(msg) / 8));
			
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
			
            if(pnPage == '' || pnPage == undefined || pnPage == null){
                pnPage = 1;
            }
            if(pnPage != 1 && pnPage != $('#ospTotalPage').text()){
                var nPageAll = pnPage;
                var nPageTotal = nPageAll - 1 ;
                pnPage = nPageTotal;
                $('#ospPageActive').text(pnPage);
            }else{
                $('#ospPageActive').text(pnPage);
			}
			
			JSxPRKListView(pnPage);
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
			$('#ocmFNDstID').selectpicker('refresh');

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
			// $('#ocmFNPvnID').html(msg);
			$('#ocmFNPvnID').selectpicker('refresh');
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
		+ '\').remove();"><img class="xCNIconTable" src="application/modules/common/assets/images/icons/delete.png"></a></td></tr>';
		$('#otbAre tbody').append($tHtml);
		$('#otbAre tbody #otr').hide();
	}
}
function FSxDelImgPrk(nImgID, tImgObj, tMsg) {
    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
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


/**
 * Functionality : Is create page.
 * Parameters : -
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbUserIsCreatePage(){
    try{
        const tCardCode = $('#oetBchCode').data('is-created');
        var bStatus = false;
        if(tCardCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbUserIsCreatePage Error: ', err);
    }
}

/**
 * Functionality : Is update page.
 * Parameters : -
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbUserIsUpdatePage(){
    try{
        const tCardCode = $('#oetBchCode').data('is-created');
        var bStatus = false;
        if(!tCardCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbUserIsUpdatePage Error: ', err);
    }
}

/**
* Functionality : Show or Hide Component
* Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
* Creator : 09/10/2018 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxUserVisibleComponent(ptComponent, pbVisible, ptEffect){
    try{
        if(pbVisible == false){
            $(ptComponent).addClass('hidden');
        }
        if(pbVisible == true){
            // $(ptComponent).removeClass('hidden');
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    }catch(err){
        console.log('JSxUserVisibleComponent Error: ', err);
	}
}


function JSvPRKCallPageBranchEdit(tBchCode) {

		$.ajax({
			type : "POST",
			url : "EticketLocationNew/"+tBchCode,
			data : {
				tBchCode: tBchCode,
			},
			cache : false,
			success : function(tResault) {
			$('#odvCallEditLocation').html(tResault);
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
            url: "EticketDeleteBranch",
            data: {
                'tParkId': ocbListItem.join()
            },
            cache: false,
            success: function (msg) {
				
                JSxPRKCountSearch(pnPage);
                
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



