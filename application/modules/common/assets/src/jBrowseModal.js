var tModal = '<div class="modal fade xCNModalByModule" data-backdrop="static" data-keyboard="false"  id="myModal" tabindex="-1" role="dialog" style="overflow-x: hidden;overflow-y: auto;">';
tModal += '<div class="modal-dialog" id="modal-customs" role="document" >';
tModal += '<div id="odvModalContent" class="modal-content">';
tModal += '</div>';
tModal += '<div id="odvDataMultiSelection"></div>';
tModal += '</div>';
tModal += '</div>';

var tModal2 = '<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" style="overflow-x:hidden;overflow-y:auto;z-index:5000">';
tModal2 += '<div class="modal-dialog" id="modal-customs2" role="document" >';
tModal2 += '<div id="odvModalContent2" class="modal-content">';
tModal2 += '</div>';
tModal2 += '<div id="odvDataMultiSelection"></div>';
tModal2 += '</div>';
tModal2 += '</div>';

//ค้นหาแบบ HTML
function JCNxSearchBrowseHtml() {
    var tValue = $('#odvModalContent2 .oetTextFilter').val().toLowerCase();
    $("#otbBrowserList tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(tValue) > -1)
    });
}

//Browse สำหรับค้นหาสินค้า 
function JCNxBrowseProductData(ptOptions) {
    //เรื่อง Group Both multi Add
    nGrpBothNumItem = localStorage.GrpBothNumItem
    if (nGrpBothNumItem != '' || nGrpBothNumItem != undefined) {
        nGrpBothNumItem = nGrpBothNumItem
    } else {
        nGrpBothNumItem = '';
    }
    //เรื่อง Group Both multi Add

    //alert(window[ptOptions]);
    //var Browser = window[ptOptions];

    if (window[ptOptions].GrideView.WidthModal == '' || window[ptOptions].GrideView.WidthModal == null) {
        $nPercentWidth = '50';
    } else {
        $nPercentWidth = window[ptOptions].GrideView.WidthModal;
    }

    $max = jQuery(window).width();
    $min = jQuery(window).height();
    $nConvertopx = (($nPercentWidth / 100) * ($max - $min)) + $min;
    // $('.modal-backdrop').remove(); /*Krit 28/06/2018*/
    if (window[ptOptions].BrowseLev == 1) {
        // $('.modal-backdrop').remove();
        $('#myModal2').remove();
        $("body").append(tModal2);
        $('#modal-customs2').attr("style", 'min-width:' + $nConvertopx + 'px; margin: 1.75rem auto;');
        $('#myModal2').modal({ show: true });
    } else {
        $('.modal-backdrop').remove();
        $('#myModal').remove();
        $("body").append(tModal);
        $('#modal-customs').attr("style", 'min-width:' + $nConvertopx + 'px; margin: 1.75rem auto;');

        $('#myModal').modal({ show: true });
    }

    if (window[ptOptions] != undefined || window[ptOptions] != null) {

        //Chk Option Filter (undefined , Null)         
        if (window[ptOptions].Filter != undefined || window[ptOptions].Filter != null) {
            var tFileter = $('#' + window[ptOptions].Filter.Selector).val();
        } else {
            var tFileter = '';
        }

        //Chk Option Not In (undefined , Null) 
        if (window[ptOptions].NotIn != undefined || window[ptOptions].NotIn != null) {
            var tNotIn = $('#' + window[ptOptions].NotIn.Selector).val();
        } else {
            var tNotIn = '';
        }

        if (window[ptOptions].CallBack.Text != undefined || window[ptOptions].CallBack.Text != null) {
            var tCalBackSelector = window[ptOptions].CallBack.Text[0];
            var tCallText = $('#' + tCalBackSelector + nGrpBothNumItem).val();
        } else {
            //var tFileter = '';
            var tCallText = '';
        }

        if (window[ptOptions].CallBack.Value != undefined || window[ptOptions].CallBack.Value != null) {

            var tCalBackSelectorValue = window[ptOptions].CallBack.Value[0];
            var tCallVal = $('#' + tCalBackSelectorValue + nGrpBothNumItem).val();

        } else {
            //var tFileter = '';
            var tCallVal = '';
        }

        tCallBackType = window[ptOptions].CallBack.ReturnType;

        if (tCallBackType == 'S') {
            tOldCallVal = tCallVal;
            tOldCallText = tCallText;
        } else if (tCallBackType == 'M') {


            tOldCallVal = tCallVal.split(',');
            tOldCallText = tCallText.split(',');

            if (tOldCallVal.length > 0) {
                for (var x = 0; x < tOldCallVal.length; x++) {
                    if (tOldCallVal[x] != '') {
                        $('#odvDataMultiSelection').append($('<span>')
                            .append('<label>')
                            .attr('class', 'olbVal' + tOldCallVal[x])
                            .attr('data-val', tOldCallVal[x])
                            .attr('data-text', tOldCallText[x])
                        );
                    }
                }
            }

        } else {
            tOldCallVal = tCallVal;
            tOldCallText = tCallText;
        }

        $.ajax({
            type: "POST",
            url: 'BrowseData',
            cache: false,
            data: {
                paOptions: window[ptOptions],
                tFileter: tFileter,
                tNotIn: tNotIn,
                tOptions: ptOptions,
                tCallVal: tOldCallVal,
                tCallText: tOldCallText
            },
            dataType: "Text",
            success: function(tResult) {

                if (window[ptOptions].BrowseLev == 1) {

                    $('#odvModalContent2').html(tResult);

                } else {
                    $('#odvModalContent').html(tResult);
                }

                setTimeout(function() {
                    var tSelectionID = $('#oetCallBackVal').val();
                    $('#obtSelector' + tSelectionID).addClass("active");
                }, 100);
            },
            timeout: 0,
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    } else {
        $('#odvModalContent').html('Error : Do not set options or invalid options.');
    }
}

//Browse สำหรับข้อมูลทั่วไป
function JCNxBrowseData(ptOptions) {

    if (window[ptOptions].GrideView.WidthModal == '' || window[ptOptions].GrideView.WidthModal == null) {
        $nPercentWidth = '50';
    } else {
        $nPercentWidth = window[ptOptions].GrideView.WidthModal;
    }

    $max = jQuery(window).width();
    $min = jQuery(window).height();
    $nConvertopx = (($nPercentWidth / 100) * ($max - $min)) + $min;
    if (window[ptOptions].BrowseLev == 1) {
        $('#myModal2').remove();
        $("body").append(tModal2);
        $('#modal-customs2').attr("style", 'min-width:' + $nConvertopx + 'px; margin: 1.75rem auto;');
    } else {
        $('.modal-backdrop').remove();
        $('#myModal').remove();
        $("body").append(tModal);
        $('#modal-customs').attr("style", 'min-width:' + $nConvertopx + 'px; margin: 1.75rem auto;');
    }

    if (window[ptOptions] != undefined || window[ptOptions] != null) {
        //Chk Option Filter (undefined , Null)
        if (window[ptOptions].Filter != undefined || window[ptOptions].Filter != null) {
            var tFileter = $('#' + window[ptOptions].Filter.Selector).val();
        } else {
            var tFileter = '';
        }

        //Chk Option Not In (undefined , Null) 
        if (window[ptOptions].NotIn != undefined || window[ptOptions].NotIn != null) {
            var tNotIn = $('#' + window[ptOptions].NotIn.Selector).val();
        } else {
            var tNotIn = '';
        }

        if (window[ptOptions].CallBack.Text != undefined || window[ptOptions].CallBack.Text != null) {
            var tCalBackSelector = window[ptOptions].CallBack.Text[0];
            var tCallText = $('#' + tCalBackSelector).val();
        } else {
            var tCallText = '';
        }

        if (window[ptOptions].CallBack.Value != undefined || window[ptOptions].CallBack.Value != null) {
            var tCalBackSelectorValue = window[ptOptions].CallBack.Value[0];
            var tCallVal = $('#' + tCalBackSelectorValue).val();
        } else {
            var tCallVal = '';
        }

        tCallBackType = window[ptOptions].CallBack.ReturnType;

        if (tCallBackType == 'S') {
            tOldCallVal = tCallVal;
            tOldCallText = tCallText;
        } else if (tCallBackType == 'M') {
            tOldCallVal = tCallVal.split(',');
            tOldCallText = tCallText.split(',');
            if (tOldCallVal.length > 0) {
                for (var x = 0; x < tOldCallVal.length; x++) {
                    if (tOldCallVal[x] != '') {
                        var oKeepValue = JSON.stringify([tOldCallVal[x], tOldCallText[x]]);
                        $('#odvDataMultiSelection').append(
                            $('<span>').append('<label>').attr('class', 'olbVal' + tOldCallVal[x]).attr('data-val', tOldCallVal[x]).attr('data-text', tOldCallText[x]).attr('data-objectvalue', oKeepValue)
                        );
                    }
                }
            }
        } else {
            tOldCallVal = tCallVal;
            tOldCallText = tCallText;
        }

        $.ajax({
            type: "POST",
            url: 'BrowseData',
            cache: false,
            data: {
                paOptions: window[ptOptions],
                tFileter: tFileter,
                tNotIn: tNotIn,
                tOptions: ptOptions,
                tCallVal: tOldCallVal,
                tCallText: tOldCallText
            },
            dataType: "Text",
            timeout: 0,
            success: function(tResult) {

                if (window[ptOptions].BrowseLev == 1) {
                    $('#odvModalContent2').html(tResult);
                    $('#myModal2').modal({ show: true });
                } else {
                    $('#odvModalContent').html(tResult);
                    $('#myModal').modal({ show: true });
                }

                $('.xCNBody').css("padding-right", "0px");

                setTimeout(function() {
                    var tSelectionID = $('#oetCallBackVal').val();
                    $('#obtSelector' + tSelectionID).addClass("active");
                }, 100);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        $('#odvModalContent').html('Error : Do not set options or invalid options.');
    }

}

//กดที่ page 1 2 3 หรือ กดค้นหา
function JCNxSearchBrowse(pnCurentPage, ptOptions) {
    if (window[ptOptions] != undefined || window[ptOptions] != null) {

        var tFilerGride = $('#myModal .oetSearchTable').val(); // default value

        if (window[ptOptions].BrowseLev == 0) { // Main Level
            tFilerGride = $('#myModal .oetSearchTable').val();
        }
        if (window[ptOptions].BrowseLev == 1) { // Sub Level
            tFilerGride = $('#myModal2 .oetSearchTable').val();
        }

        //Chk Option Filter (undefined , Null) 
        if (window[ptOptions].Filter != undefined || window[ptOptions].Filter != null) {
            var tFileter = $('#' + window[ptOptions].Filter.Selector).val();
        } else {
            var tFileter = '';
        }

        //Chk Option Not In (undefined , Null) 
        if (window[ptOptions].NotIn != undefined || window[ptOptions].NotIn != null) {
            var tNotIn = $('#' + window[ptOptions].NotIn.Selector).val();
        } else {
            var tNotIn = '';
        }

        tCallBackType = window[ptOptions].CallBack.ReturnType;
        var tCallVal;
        var tCallText;

        if (tCallBackType == 'S') {
            tCallVal = $('#oetCallBackVal').val();
            tCallText = $('#oetCallBackText').val();
        } else if (tCallBackType == 'M') {
            var aCallBackVal = [];
            var aCallBackText = [];
            $('#odvDataMultiSelection span').each(function() {
                aCallBackVal.push($(this).data('val'));
                aCallBackText.push($(this).data('text'));
            });
            tCallVal = aCallBackVal;
            tCallText = aCallBackText;
        } else {
            tCallVal = $('#oetCallBackVal').val();
            tCallText = $('#oetCallBackText').val();
        }

        $.ajax({
            type: "POST",
            url: 'BrowseData',
            cache: false,
            data: {
                paOptions: window[ptOptions],
                tFileter: tFileter,
                tNotIn: tNotIn,
                tFilerGride: tFilerGride,
                nCurentPage: pnCurentPage,
                tOptions: ptOptions,
                tCallText: tCallText,
                tCallVal: tCallVal
            },
            dataType: "Text",
            success: function(tResult) {
                if (window[ptOptions].BrowseLev == 1) {
                    $('#odvModalContent2').html(tResult);
                } else {
                    $('#odvModalContent').html(tResult);
                }

                setTimeout(function() {
                    var tSelectionID = $('#oetCallBackVal').val();
                    $('#obtSelector' + tSelectionID).addClass("active");
                }, 100);
            },
            timeout: 0,
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        alert('Do not set options');
    }
}

//กดยืนยันมุุมขวา
function JCNxConfirmSelected(ptOptions) {
    //เรื่อง Group Both multi Add
    nGrpBothNumItem = localStorage.GrpBothNumItem
    if (nGrpBothNumItem != '' || nGrpBothNumItem != undefined) {
        nGrpBothNumItem = nGrpBothNumItem
    } else {
        nGrpBothNumItem = '';
    }
    //เรื่อง Group Both multi Add
    tCallBackType = window[ptOptions].CallBack.ReturnType;
    if (window[ptOptions].CallBack.Text != undefined || window[ptOptions].CallBack.Text != null) {
        var tCallBackText = window[ptOptions].CallBack.Text[0] + nGrpBothNumItem;
    } else {
        var tCallBackText = '';
    }

    if (window[ptOptions].CallBack.Value != undefined || window[ptOptions].CallBack.Value != null) {
        var tCallBackValue = window[ptOptions].CallBack.Value[0] + nGrpBothNumItem;
    } else {
        var tCallBackValue = '';
    }


    if (tCallBackType == 'S') { //Single Browse
        $('#' + tCallBackText).val($('#oetCallBackText').val());
        $('#' + tCallBackValue).val($('#oetCallBackVal').val()).trigger('change');
        //window["foo"](arg1, arg2);
        if (window[ptOptions].NextFunc != undefined || window[ptOptions].NextFunc != null) {
            var tMaster = window[ptOptions].Table.Master;
            tGotoFunction = (window[ptOptions].NextFunc.FuncName);
            tAgrRet = $('#ohdCallBackArg' + $('#oetCallBackVal').val() + tMaster).val();

            if (window[ptOptions].BrowseLev == '1') {
                $('#myModal2').modal('hide');
            } else {
                $('#myModal').modal('hide');
            }

            if (tAgrRet != undefined) {
                return window[tGotoFunction](tAgrRet);
            } else {
                return window[tGotoFunction]('NULL');
            }
        }
    } else { //Multiple Browse
        var aCallBackVal = [];
        var aCallBackText = [];
        $('#odvDataMultiSelection span').each(function() {
            aCallBackVal.push($(this).data('val'));
            aCallBackText.push($(this).data('text'));
        });

        console.log(aCallBackVal);
        console.log(aCallBackText);

        $('#' + tCallBackText).val(aCallBackText);
        $('#' + tCallBackValue).val(aCallBackVal);

        if (window[ptOptions].NextFunc != undefined || window[ptOptions].NextFunc != null) {
            tGotoFunction = (window[ptOptions].NextFunc.FuncName);
            tPKId = $('#' + tCallBackValue).val();
            aPKId = tPKId.split(',');
            var aCalBackVal = [];

            var tMaster = window[ptOptions].Table.Master;
            for (var i = 0; i < aPKId.length; i++) {
                aCalBackVal.push($('.olbVal' + aPKId[i]).data('objectvalue'));
            }

            var oJsonData = JSON.stringify(aCalBackVal);
            var oJsonCallBack = JSON.parse(oJsonData);
            if (window[ptOptions].BrowseLev == '1') {
                $('body #myModal2').modal('hide');
            } else {
                $('body #myModal').modal('hide');
            }
            $('#odvDataMultiSelection').empty();
            return window[tGotoFunction](oJsonCallBack);
        }
    }

    if (window[ptOptions].BrowseLev == '1') {
        $('#myModal2').modal('hide');
    } else {
        $('#myModal').modal('hide');
    }

    localStorage.GrpBothNumItem = ''; //Remove Local Storage
}

//กดปิดมุมขวา
function JCNxClearValueInModal() {
    $('#odvDataMultiSelection').empty();
}

//กดเลือกที่ record 'S'
function JCNxPushSelection(pnVal, elem, ptMasterTable) {
    $('.xCNTextDetail2').removeClass('active');
    if (pnVal == $('#oetCallBackVal').val()) {
        $(elem).removeClass('active');
        $('#oetCallBackVal').val('');
        $('#oetCallBackText').val('');
    } else {
        $('#oetCallBackVal').val(pnVal);
        $('#oetCallBackText').val($('#ohdCallBackText' + pnVal + ptMasterTable).val());
        $(elem).addClass('active');
    }
}

//กดเลือกที่ record 'M'
function JCNxPushMultiSelection(pnVal, ptText, elem) {
    var nDataSelected = $('span.olbVal' + pnVal).length;
    if (nDataSelected == 0 || !$(elem).hasClass('active')) {
        var oKeepValue = $('.xCNKeepValue' + pnVal).val();
        $('#odvDataMultiSelection').append(
            $('<span>').append('<label>').attr('class', 'olbVal' + pnVal).attr('data-val', pnVal).attr('data-text', ptText).attr('data-objectvalue', oKeepValue)
        );
        $(elem).addClass('active');
    } else {
        $('span.olbVal' + pnVal).remove();
        $(elem).removeClass('active');
    }
}

//กดปุ่ม '+' เพิ่มแบบ level
function JCNxAddNewData(ptRouteName, pnStaCallForm, ptOptionName, ptRouteFromName) {

    if (ptRouteFromName != 'EmptyRouteFrom') {
        ptRouteFromName = '-' + ptRouteFromName;
    } else {
        ptRouteFromName = '';
    }

    $.ajax({
        url: ptRouteName + "/1" + ptRouteFromName + "/" + ptOptionName,
        type: "POST",
        data: { pnStaCallForm: pnStaCallForm },
        timeout: 0,
        success: function(tView) {
            $('#odvModalContent').html(tView);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

function JCNnRandomInteger(min, max) {
    return Math.floor(min + Math.random() * (max + 1 - min))
}

//กด DB Click แบบ 'S'
function JCNxDoubleClickSelection(pnVal, poEvent, ptOption, ptMasterTable) {
    $('.xCNTextDetail2').removeClass('active');
    $('#oetCallBackVal').val(pnVal);
    $('#oetCallBackText').val($('#ohdCallBackText' + pnVal + ptMasterTable).val());
    $(poEvent).addClass('active');
    setTimeout(function() {
        JCNxConfirmSelected(ptOption);
    }, 100);
}

//กด DB Click แบบ 'M'
function JCNxDoubleClickMultiSelection(pnVal, ptText, poEvent, ptOption) {}




//Browse สำหรับข้อมูลทั่วไป
function JCNxBrowseDataChain(ptOptions) {

    if (window[ptOptions].GrideView.WidthModal == '' || window[ptOptions].GrideView.WidthModal == null) {
        $nPercentWidth = '50';
    } else {
        $nPercentWidth = window[ptOptions].GrideView.WidthModal;
    }

    $max = jQuery(window).width();
    $min = jQuery(window).height();
    $nConvertopx = (($nPercentWidth / 100) * ($max - $min)) + $min;
    if (window[ptOptions].BrowseLev == 1) {
        $('#myModal2').remove();
        $("body").append(tModal2);
        $('#modal-customs2').attr("style", 'min-width:' + $nConvertopx + 'px; margin: 1.75rem auto;');
    } else {
        $('.modal-backdrop').remove();
        $('#myModal').remove();
        $("body").append(tModal);
        $('#modal-customs').attr("style", 'min-width:' + $nConvertopx + 'px; margin: 1.75rem auto;');
    }

    if (window[ptOptions] != undefined || window[ptOptions] != null) {
        //Chk Option Filter (undefined , Null)
        if (window[ptOptions].Filter != undefined || window[ptOptions].Filter != null) {
            var tFileter = $('#' + window[ptOptions].Filter.Selector).val();
        } else {
            var tFileter = '';
        }

        //Chk Option Not In (undefined , Null) 
        if (window[ptOptions].NotIn != undefined || window[ptOptions].NotIn != null) {
            var tNotIn = $('#' + window[ptOptions].NotIn.Selector).val();
        } else {
            var tNotIn = '';
        }

        if (window[ptOptions].CallBack.Text != undefined || window[ptOptions].CallBack.Text != null) {
            var tCalBackSelector = window[ptOptions].CallBack.Text[0];
            var tCallText = $('#' + tCalBackSelector).val();
        } else {
            var tCallText = '';
        }

        if (window[ptOptions].CallBack.Value != undefined || window[ptOptions].CallBack.Value != null) {
            var tCalBackSelectorValue = window[ptOptions].CallBack.Value[0];
            var tCallVal = $('#' + tCalBackSelectorValue).val();
        } else {
            var tCallVal = '';
        }

        tCallBackType = window[ptOptions].CallBack.ReturnType;

        if (tCallBackType == 'S') {
            tOldCallVal = tCallVal;
            tOldCallText = tCallText;
        } else if (tCallBackType == 'M') {
            tOldCallVal = tCallVal.split(',');
            tOldCallText = tCallText.split(',');
            if (tOldCallVal.length > 0) {
                for (var x = 0; x < tOldCallVal.length; x++) {
                    if (tOldCallVal[x] != '') {
                        var oKeepValue = JSON.stringify([tOldCallVal[x], tOldCallText[x]]);
                        $('#odvDataMultiSelection').append(
                            $('<span>').append('<label>').attr('class', 'olbVal' + tOldCallVal[x]).attr('data-val', tOldCallVal[x]).attr('data-text', tOldCallText[x]).attr('data-objectvalue', oKeepValue)
                        );
                    }
                }
            }
        } else {
            tOldCallVal = tCallVal;
            tOldCallText = tCallText;
        }

        $.ajax({
            type: "POST",
            url: 'BrowseDataChain',
            cache: false,
            data: {
                paOptions: window[ptOptions],
                tFileter: tFileter,
                tNotIn: tNotIn,
                tOptions: ptOptions,
                tCallVal: tOldCallVal,
                tCallText: tOldCallText
            },
            dataType: "Text",
            timeout: 0,
            success: function(tResult) {

                if (window[ptOptions].BrowseLev == 1) {
                    $('#odvModalContent2').html(tResult);
                    $('#myModal2').modal({ show: true });
                } else {
                    $('#odvModalContent').html(tResult);
                    $('#myModal').modal({ show: true });
                }

                $('.xCNBody').css("padding-right", "0px");

                setTimeout(function() {
                    var tSelectionID = $('#oetCallBackVal').val();
                    $('#obtSelector' + tSelectionID).addClass("active");
                }, 100);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        $('#odvModalContent').html('Error : Do not set options or invalid options.');
    }

}


function JSvCallListChainModal(e) {
    try {
        JCNxOpenLoading();
        var bActive= $(e).data('active');
        var tValParent= $(e).data('parent');
        var tValLevel= parseFloat($(e).data('level'));
        var tValTable= $(e).data('table');
        // alert(bActive);
        if(bActive==2){
     
            // alert(1);
     
                // alert(tValParent);
                // var oParamCallChrildren = JSoCallChrildrenParam(tValParent,tValLevel);
                // JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "BrowsDataChrildren",
                    data: {
                        tValParent: tValParent,
                        tValLevel:tValLevel
                    },
                    dataType : "text", 
                    cache: false,
                    Timeout: 5000,
                    success: function(oResult) {
                       var aResult = JSON.parse(oResult);
                        $(e).data('active',1);
                        $('#oeiIconParent'+tValParent).attr('class','fa fa-angle-down');
                        // console.log("Naletes",oResult);
                        if(aResult['tDataTable'].trim()!=''){
                        $('.xCNParent'+tValParent).after("'"+aResult['tDataTable'].trim()+"'");
                        }
                        if(aResult['tDataInputHide'].trim()!=''){
                        $('#otbBrowserList').before(aResult['tDataInputHide'].trim());
                        
                        }
                        JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
        }else{
            // alert(2);
    
            $('.xCNTextDetail2').each(function(oElement){
                var tChain = $(this).data('chain');
                var nCHainLev = parseFloat($('.xCNParent'+tValParent).data('level'));
                var nLevel = parseFloat($(this).data('level'));
                var tCodePK = $(this).data('code');
                
                // alert(tChain+' = '+tValParent);
                var nCount = tChain.indexOf(tValParent);
              
                    if(nCount!='-1' && nLevel>nCHainLev){
                        $('.xCNChain'+tChain).remove();
                
                        $('#ohdCallBackArg'+tCodePK+tValTable).remove();
                        $('#ohdCallBackText'+tCodePK+tValTable).remove();
                        // console.log("nCount",nCount);
                        // console.log("nLevel",nLevel);
                        // console.log("tValLevel",tValLevel);
                    }
                
            });

            $(e).data('active',2);
            $('#oeiIconParent'+tValParent).attr('class','fa fa-angle-right');
            JCNxCloseLoading();
        }


    } catch (err) {
        console.log('JSvCallListSeasonChain Error: ', err);
    }


}

