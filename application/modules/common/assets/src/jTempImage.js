///function : Funtion Call Image Temp
//Parameters : Event Button
//Creator :	12/04/2018 (Wasin)
//Return :  -
//Return Type : -
function JSvImageCallTemp(ptPage, pnBrowseType) {
    var nWinHeight = $(window).height();
    var nh = parseInt(nWinHeight) - 250;
    var nHeightCropCanvasBox = nh-30;
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "ImageCallTemp",
        data: {
            nPageCurrent: ptPage,
            nBrowseType: pnBrowseType
        },
        cache: false,
        timeout: 0,
        success: function (oResult) {
            var aDataImg = JSON.parse(oResult);
            // console.log('JSvImageCallTemp');
            // console.log(aDataImg);
            if (aDataImg != "") {
                $('#odlModalTempImg .modal-body').css('max-height',nHeightCropCanvasBox);
                $('#odvImgItemsList').empty();
                $('#odvImgItemsList').html(aDataImg.rtImgData);
                $('#odvImgTotalPage').html(aDataImg.rtTotalPage);
                $('#odvImgPagenation').html(aDataImg.rtPaging);
                $('#odlModalTempImg').modal('show');
                var waterfall = new Waterfall({
                    containerSelector: '.wf-container',
                    boxSelector: '.wf-box',
                    minBoxWidth: 220
                });
            }
            JCNxCloseLoading();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

///function : Fuction Image Uplode and Resize file
//Parameters : Event Button
//Creator : 12/04/2018 (Wasin)
//Return : 
//Return Type : 
function JSxImageUplodeResize(poImg, ptRetio) {
    var oImgData = poImg.files[0];
    var oImgFrom = new FormData();
    oImgFrom.append('file', oImgData);
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "ImageUplode",
        cache: false,
        contentType: false,
        processData: false,
        data: oImgFrom,
        datatype: "JSON",
        timeout: 50000,
        success: function (tResult) {
            if (tResult != "") {
                JSxImageCrop(tResult, ptRetio);
            }
            JCNxCloseLoading();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

///function : Function Crop Image
//Parameters : Function Paramiter (JSoImagUplodeResize)
//Creator : 12/04/2018 (Wasin)
//Return : -
//Return Type : -
function JSxImageCrop(poImgData, ptRetion) {
    var aImgData = JSON.parse(poImgData);
    if (aImgData.tImgBase64 != "") {
        $('#odvModalCrop').empty();
        $('#odvModalCrop')
                .append('<div class="modal fade" id="oModalCropper" aria-labelledby="modalLabel" role="dialog" tabindex="-1" style="z-index:2000;"> <div class="modal-dialog" role="document" style="z-index:9000; margin-top: 60px;"> <div class="modal-content"> <div class="modal-header" style="padding-bottom:10px;"> <label class="modal-title xCNTextModalHeard" id="modalLabel" style="font-weight:bold; margin:0px 0px 0px 0px; float:left;"> ' + $('#ohdTextCrop').val() + ' </label> <button id="oModalCropperdelete" style="float:right;" type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div> <div class="modal-body" style="min-height:500px;height:500px;overflow-y:auto;"> <div> <img id="oImageCropper" style="max-width: 60%;" src="' +
                        aImgData.tImgBase64 + '" alt="Picture"> </div> </div> <div class="modal-footer"> <div class="pull-left"> <div class="btn-group"> <button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper\').cropper(\'zoom\', 0.1)" title="Zoom In"> <span class="docs-tooltip"> <span class="fa fa-search-plus"></span> </span> </button> <button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper\').cropper(\'zoom\', -0.1)" title="Zoom Out"> <span class="docs-tooltip"> <span class="fa fa-search-minus"></span> </span> </button> </div> <div class="btn-group"> <button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper\').cropper(\'move\', -10, 0)" title="Move Left"> <span class="docs-tooltip"> <span class="fa fa-arrow-left"></span> </span> </button> <button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper\').cropper(\'move\', 10, 0)" title="Move Right"> <span class="docs-tooltip"> <span class="fa fa-arrow-right"></span> </span> </button> <button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper\').cropper(\'move\', 0, -10)" title="Move Up"> <span class="docs-tooltip"> <span class="fa fa-arrow-up"></span> </span> </button> <button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper\').cropper(\'move\', 0, 10)" title="Move Down"> <span class="docs-tooltip"> <span class="fa fa-arrow-down"></span> </span> </button> </div> </div> <button type="button" class="btn btn-outline-primary pull-right xWBtnCropImage" title="Crop"> <span> ' + $('#ohdTextBTNCrop').val() + ' </span> </button> </div> </div> </div> </div>');
    }
    setTimeout(function () {
        $('#odlModalTempImg').modal('hide');
        $('#oModalCropper').modal({backdrop: 'static', keyboard: false});
        $('#oModalCropper').modal("show");
        var $image = $('#oImageCropper');
        var $button = $('.xWBtnCropImage');

        var cropBoxData;
        var canvasData;
        $('#oModalCropper').on('shown.bs.modal', function () {
            $image.cropper({
                width : 215,
                height : 130,
                viewMode : 1,
                dragMode : 'move',
                autoCropArea : 0.8,
                restore : true,
                guides : true,
                highlight : false,
                cropBoxMovable : true,
                cropBoxResizable : true,
                strict: true,
                background: false,
                zoomable: false,
                aspectRatio: 16 / 9,
                built: function () {
                    $image.cropper("setCropBoxData", {width: "215", height: "130"});
                },
                ready: function () {
                    $image.cropper('setCanvasData', canvasData);
                    $image.cropper('setCropBoxData', cropBoxData);
                }
            });
        }).on('hidden.bs.modal', function () {
            cropBoxData = $image.cropper('getCropBoxData');
            canvasData = $image.cropper('getCanvasData');
            $image.cropper('destroy');
            $('#oModalCropper').remove();
            $('#ofilePhotoAdd').val('');
            $('#oetInputUplode').val('');
        });
        $button.on('click', function () {
            var croppedCanvas;
            var roundedCanvas;
            croppedCanvas = $image.cropper('getCroppedCanvas');
            roundedCanvas = croppedCanvas.toDataURL();
            $.ajax({
                type: "POST",
                url: "ImageConvertCrop",
                cache: false,
                data: {
                    'tBase64': roundedCanvas,
                    'tImgName': aImgData.tImgName,
                    'tImgtype': aImgData.tImgType,
                    'tImgPath': aImgData.tImgFullPath
                },
                success: function (tResult) {
                    if (tResult != "") {
                        $('#oModalCropper').modal("hide");
                        JSvImageCallTemp();
                    }
                    $('#oetInputUplode').val('');
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
        $('#oModalCropperdelete').click(function () {
            JSxImageDelete(aImgData.tImgName);
            $('#odlModalTempImg').modal('show');

        });
    }, 500);
}

///function : Function Crop Image
//Parameters : Function Paramiter (JSoImagUplodeResize)
//Creator : 12/04/2018 (Wasin)
//Return : -
//Return Type : -
function JSxImageDelete(ptImgName) {
    if (ptImgName != "") {
        $.ajax({
            type: "POST",
            url: "ImageDeleteFile",
            cache: false,
            data: {tImageName: ptImgName},
            success: function (tResult) {
                var aDataImg = JSON.parse(tResult);
                if (aDataImg != "") {
                    $('#odvImgTempData').html(aDataImg.rtImgData);
                    $('#odvImgTotalPage').html(aDataImg.rtTotalPage);
                    $('#odvImgPagenation').html(aDataImg.rtPaging);
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
    }
}

///function : Function Click Page Temp
//Parameters : Event Button
//Creator : 18/04/2018 (Wasin)
//Return : -
//Return Type : -
function JSvClickPageTemp(ptPage) {
    if (ptPage == '1') {
        var nPage = 'previous';
    } else if (ptPage == '2') {
        var nPage = 'next';
    }
    var nPageCurrent = '';
    switch (nPage) {
        case 'next': //กดปุ่ม Next
            $('.next').addClass('disabled');
            nPageOld = $('.pagination .active a').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous 
            nPageOld = $('.pagination .active a').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = 1
    }
    JSvImageCallTemp(nPageCurrent);
}

///function : Function Choose Image
//Parameters : Event Button
//Creator : 18/04/2018 (Wasin)
//Return : -
//Return Type : -
function JSxChooseImage(ptFullPatch, ptImgName, pnBrowseType) {
    var tImgName = "";
    var tImgShow = "";
    if (ptFullPatch == "") {
        tImgShow = "http://www.bagglove.com/images/400X200.gif"
    } else {
        tImgShow = ptFullPatch + '/' + ptImgName;
        tImgName = ptImgName;
    }

    if (pnBrowseType == '1') {
        $('#oimImgMaster').attr('src', tImgShow);
        $('#oetImgInput').val(ptImgName);
    } else {

        $('#oimImgMaster').attr('src', tImgShow);
        // oImageTumblr = '<li style="width:auto">';
        // oImageTumblr += '<img src="' + tImgShow + '" class="img img-respornsive" style="width:120px;"><br>';
        // oImageTumblr += '<a onclick="JCNxRemoveTumblr(' + "'" + tImgShow + "'" + ')">ลบ</a>';
        // oImageTumblr += '</li>';
        var nMinNumber = 1; // le minimum
        var nMaxNumber = 100; // le maximum
        var nImgIdx = Math.floor(Math.random() * (nMaxNumber + 1) + nMinNumber);
        $("#otbImageList").find('tbody > tr')
                .append($('<td>').attr('id', 'otdTumblr' + nImgIdx)
                        .append($('<img>')
                                .attr('id', 'oimTumblr' + nImgIdx)
                                .attr('src', tImgShow)
                                .attr('data-img', tImgName)
                                .attr('data-tumblr', nImgIdx)
                                .text('Image cell')
                                .css('z-index', '100')
                                .addClass('xCNImgTumblr img img-respornsive')
                                .click(function () {
                                    $('#oimImgMaster').attr('src', $(this).attr('src'));
                                    return false;
                                })
                                .hover(function () {
                                    $('#odvImgDelBnt' + $(this).data('tumblr')).show();
                                    //JCNxRemoveImgTumblr(this, tImgShow);
                                })
                                .mouseleave(function () {
                                    $('#odvImgDelBnt' + $(this).data('tumblr')).hide();
                                })
                                )
                        .append($('<div class="xCNImgDelIcon"></div>')
                                .attr('id', 'odvImgDelBnt' + nImgIdx)
                                .attr('data-id', nImgIdx)
                                .css('z-index', '500')
                                .hover(function () {
                                    $(this).show();
                                    $('#' + nImgIdx).addClass('xCNImgHover');
                                    //JCNxRemoveImgTumblr(this, tImgShow);
                                })
                                .append('<i class="fa fa-times" aria-hidden="true"></i> ลบรูป ')
                                .mouseleave(function () {
                                    $(this).hide();
                                })
                                .click(function () {
                                    JCNxRemoveImgTumblr(this);
                                })
                                )
                        );

    }
    $('#odlModalTempImg').modal('hide');

}

///function : Function Choose Remove Image 
//Parameters : Event Button
//Creator : 18/04/2018 (Wasin)
//Return : -
//Return Type : -
function JCNxRemoveImgTumblr(poTumblrID) {
    nDataId = $(poTumblrID).data('id');

    tCurrentShowPath = $('#oimImgMaster').attr('src');
    tCurrentRemovingPath = $('#oimTumblr' + nDataId).attr('src');
    $('#otdTumblr' + nDataId).remove();
    if (tCurrentShowPath === tCurrentRemovingPath) {
        $('#oimImgMaster').attr('src', 'http://www.bagglove.com/images/400X200.gif');
    }
    //tTumblrPathFrist = $("#otbImageList >  tr > td:nth-child(1)").text();
    tTumblrPathFrist = jQuery("#otbImageList").find("td:eq(1) > img").attr('src');

    if (tTumblrPathFrist != '' || tTumblrPathFrist != undefined) {
        $('#oimImgMaster').attr('src', tTumblrPathFrist);
    }
}

// function: Funtion Call Image Temp
// Parameters: Event Button
// Creator:	12/04/2018 Wasin(Yoshi)
// LastModify: 26/02/2019 Wasin(Yoshi)
// Return:  View Modal Temp Image
// ReturnType: View
function JSvImageCallTempNEW(ptPage,pnBrowseType,ptMasterName,ptRetion){
    JSxCheckPinMenuClose();
    $('.xCNModalTempImgNew').remove(); //ลบ modal ทุกครั้งก่อนสร้างใหม่ เพราะเจอปัญหามันเรียกซ้อนกัน Napat(Jame) 09/092019
    $.ajax({
        type: "POST",
        url: "ImageCallMaster",
        data: {
            ptMasterName: ptMasterName,
            pnBrowseType: pnBrowseType
        },
        cache: false,
        timeout: 0,
        success: function (tResult) {
            $('body').append(tResult);
            JSvImageCallTempNEWStep2(ptPage, pnBrowseType, ptMasterName,ptRetion);
            if (ptRetion == '') {
                $('#ohdRetionCropper').val('16 / 9');
            } else {
                $('#ohdRetionCropper').val(ptRetion);
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}


///function : Funtion Call Image Temp
//Parameters : Event Button
//Creator :	12/04/2018 (Wasin)
//Return :  -
//Return Type : -
function JSvImageCallTempNEWStep2(ptPage, pnBrowseType, ptMasterName,ptRetion) {
    var nWinHeight = $(window).height();
    var nh = parseInt(nWinHeight) - 250;
    var nHeightCropCanvasBox = nh-30;
    JCNxOpenLoadingInModal();
    $.ajax({
        type: "POST",
        url: "ImageCallTempNEW",
        data: {
            nPageCurrent: ptPage,
            nBrowseType: pnBrowseType,
            ptMasterName: ptMasterName,
            ptRetion: ptRetion
        },
        cache: false,
        timeout: 0,
        success: function (tResult) {
            var aDataImg = JSON.parse(tResult);
            console.log(aDataImg);
            if (aDataImg != "") {
                $('#odlModalTempImg'+ptMasterName+' .modal-body').css('max-height',nHeightCropCanvasBox);
                $('#odvImgTempData' + ptMasterName).html(aDataImg.rtImgData);
                $('#odvImgTotalPage' + ptMasterName).html(aDataImg.rtTotalPage);
                $('#odvImgPagenation' + ptMasterName).html(aDataImg.rtPaging);
                $('#odlModalTempImg' + ptMasterName).modal('show');
                setTimeout(function(){
                    var waterfall   = new Waterfall({
                        containerSelector: '.wf-container1',
                        boxSelector: '.wf-box1',
                        minBoxWidth: 220,
                    });
                    JCNxCloseLoadingInModal();
                },2000);
            }else{
                JCNxCloseLoadingInModal();
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxChooseImageNEW(oImgBase64, ptImgName, pnBrowseType, ptMasterName) {
    var tImgName = "";
    var tImgShow = "";
    // ตรวจสอบว่า เป็น paramiter จาก สินค้าหรือไม่
    // if(ptMasterName == "Product"){
        $('.xCNColor'+ptMasterName).hide();
        $('.xCNCheckedORB').prop('checked',false);
        // $("#oimImgMaster"+ptMasterName).css({ 'width' : '100%' });
        // $('#oetPdtColor').val('#000000'); 
        // $('#oetPdtColor').attr("disabled", true); 
    // }

    // if (ptFullPatch == "") {
    //     tImgShow = tBaseURL+"application/modules/common/assets/images/NoPic.png";
    // } else {
        tImgShow = oImgBase64/*ptFullPatch*/ /*+ '/' + ptImgName*/;
        tImgName = ptImgName;
    // }

    $('#oimImgMaster'+ptMasterName).show();

    if (pnBrowseType == '1') {
        // Single Brows Image Choose
        $('#oimImgMaster' + ptMasterName).attr('src', tImgShow);
        $('#oetImgInput' + ptMasterName).val(oImgBase64).trigger('change');
        // $('#oetImgInput' + ptMasterName).val(ptImgName).trigger('change');
    }else if(pnBrowseType == '99'){
        //Case นี้คือเอาไว้ใช้สำหรับลงทะเบียนผ่านใบหน้า ทุกครั้งที่เลือกรูปเสร็จเเล้วจะมีการ call API ตรวจสอบว่าสำเร็จ หรือ ล้มเหลว (วัฒน์ 22-ตุลา-2019)
        $('#oimImgMaster' + ptMasterName).attr('src', tImgShow);
        $('#oetImgInput' + ptMasterName).val(oImgBase64).trigger('change');
        // $('#oetImgInput' + ptMasterName).val(ptImgName).trigger('change');
        JSxOnCallNextFunction(oImgBase64,ptImgName,ptMasterName);
    }else if(pnBrowseType == '3') {
        //Multi Brows Img AdMessage

        var nMinNumber = 1; // le minimum
        var nMaxNumber = 100; // le maximum
        var nImgIdx = Math.floor(Math.random() * (nMaxNumber + 1) + nMinNumber);

        $('#odvImageList'+ptMasterName).append($('<div>')
        .attr('id', 'odvADMTumblr'+ptMasterName+nImgIdx)
        .attr('class','xWADMImgDataItem xWADMImgParent')
            .append(
                $('<div>')
                .attr('id','oimTumblr'+ptMasterName+nImgIdx)
                .attr('class','thumbnail xWADMImg xWADMImgStyle')
                .attr('data-img',tImgName)
                .attr('data-tumblr',nImgIdx)
                .css("background-image", "url('" + tImgShow + "')")
            )
            .append(
                $('<input>')
                .attr('type','hidden')
                .attr('id','oetTumblr'+ptMasterName+nImgIdx)
                .attr('name','oetTumblr'+ptMasterName+nImgIdx)
                .attr('class','xWImgCanvas')
                .attr('value',tImgShow)
            )
            .append(
                $('<div>')
                .attr('class','xWADMImgChild xWADMImgDel')
                .css('display','none')
                .append($('<button>')
                .attr('class','btn xCNBTNDefult xCNBTNDefult2Btn xWADMBtnImgDel')
                .attr('type','button')
                .text('ลบรูป')
                )
            )
        );

        FSxADMImgHoverEvent();
                
    }else{
        $('#oimImgMaster' + ptMasterName).attr('src', tImgShow);
        var nMinNumber = 1; 
        var nMaxNumber = 100; 
        var nImgIdx = Math.floor(Math.random() * (nMaxNumber + 1) + nMinNumber);
        $('#oimImgMaster'+ptMasterName).attr('src',tImgShow);
        $('#otbImageList'+ptMasterName).find('tbody > tr')
        .append($('<td>')
        .attr('id', 'otdTumblr'+ptMasterName+nImgIdx)
        .attr('class','xWTDImgDataItem')
            .append($('<img>')
            .attr('id','oimTumblr'+ptMasterName+nImgIdx)
            .attr('src', tImgShow)
            // .attr('data-img',tImgShow)
            // .attr('data-newimg', 'yes')
            .attr('data-tumblr',nImgIdx)
            .text('Image cell')
            .css('z-index', '100')
            .css('width','80px')
            .css('height','80px')
            .addClass('xCNImgTumblr img img-respornsive')
                .click(function(){
                    $('#oimImgMaster'+ptMasterName).attr('src',$(this).attr('src'));
                    return false;
                })
                .hover(function () {
                    $('#odvImgDelBnt'+ ptMasterName + $(this).data('tumblr')).show();
                    //JCNxRemoveImgTumblr(this, tImgShow);
                })
                .mouseleave(function () {
                    $('#odvImgDelBnt'+ ptMasterName + $(this).data('tumblr')).hide();
                })
            )
            .append($('<div class="xCNImgDelIcon"></div>')
            .attr('id', 'odvImgDelBnt'+ ptMasterName + nImgIdx)
            .attr('data-id', nImgIdx)
            .css('z-index', '500')
            .css('cursor','pointer')
            .css('text-align','center')
                .hover(function(){
                    $(this).show();
                    $('#' + nImgIdx).addClass('xCNImgHover');
                })
                .append('<i class="fa fa-times" aria-hidden="true"></i> ลบรูป ')
                .mouseleave(function () {
                    $(this).hide();
                })
                .click(function (){
                    JCNxRemoveImgTumblrNEW(this,ptMasterName);
                })
            )
        );
    }
    $('#odlModalTempImg' + ptMasterName).modal('hide');
    $('.xCNColor' + ptMasterName).hide();
}

function JCNxRemoveImgTumblrNEW(poTumblrID, ptMasterName) {
    nDataId                 = $(poTumblrID).data('id');
    tCurrentShowPath        = $('#oimImgMaster'+ptMasterName).attr('src');
    tCurrentRemovingPath    = $('#oimTumblr'+ptMasterName+nDataId).attr('src');
    $('#otdTumblr'+ ptMasterName + nDataId).remove();
    if (tCurrentShowPath === tCurrentRemovingPath) {
        $('#oimImgMaster' + ptMasterName).attr('src',tBaseURL+"application/modules/common/assets/images/NoPic.png");
    }
    
    tTumblrPathFrist = $("#otbImageList >  tr > td:nth-child(1)").text();
    tTumblrPathFrist = jQuery("#otbImageList" + ptMasterName).find("td:eq(1) > img").attr('src');

    if (tTumblrPathFrist != '' || tTumblrPathFrist != undefined) {
        $('#oimImgMaster' + ptMasterName).attr('src', tTumblrPathFrist);
    }
}

//ลบรูปภาพในหน้าจอ คลังรูปภาพ ออก 
function JSxImageDeleteNEW(ptImgName, ptMasterName,pnBrowseType) {
    if (ptImgName != "") {
        $.ajax({
            type    : "POST",
            url     : "ImageDeleteFileNEW",
            cache   : false,
            data    : {
                tImageName      : ptImgName,
                tMasterName     : ptMasterName,
                nBrowseType     : pnBrowseType
            },
            success: function (tResult) {
                var aDataImg = JSON.parse(tResult);
                if (aDataImg != "") {
                    $('#odvImgTempData' + ptMasterName).html(aDataImg.rtImgData);
                    $('#odvImgTotalPage' + ptMasterName).html(aDataImg.rtTotalPage);
                    $('#odvImgPagenation' + ptMasterName).html(aDataImg.rtPaging);
                    var waterfall = new Waterfall({
                        containerSelector: '.wf-container1',
                        boxSelector: '.wf-box1',
                        minBoxWidth: 220
                    });
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
    }
}

///function : Function Click Page Temp
//Parameters : Event Button
//Creator : 18/04/2018 (Wasin)
//Return : -
//Return Type : -
function JSvClickPageTempNEW(ptPage, ptMasterName) {

    if (ptPage == '1') {
        var nPage = 'previous';
    } else if (ptPage == '2') {
        var nPage = 'next';
    }
    var nPageCurrent = '';
    switch (nPage) {
        case 'next': //กดปุ่ม Next
            $('.next').addClass('disabled');
            nPageOld = $('.pagination' + ' .' + ptMasterName + '.active a').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous 
            nPageOld = $('.pagination' + ' .' + ptMasterName + '.active a').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = 1
    }

    JSvImageCallTempNEW(nPageCurrent, '', ptMasterName);
}

///function : Fuction Image Uplode and Resize file
//Parameters : Event Button
//Creator : 12/04/2018 (Wasin)
//Return : 
//Return Type : 
function JSxImageUplodeResizeNEW(poImg, ptRetio, ptMasterName,pnBrowseType) {
    // var oImgData = poImg.files[0];
    // var oImgFrom = new FormData();

    // console.log(poImg);
    // console.log( JSON.parse(oImgData) );
    // console.log( oImgData.toDataURL() );

    var oReader = new FileReader();
    var oFile   = poImg.files;
    oReader.onloadend = function () {
        const oImg = new Image();
        oImg.src = oReader.result;
        oImg.onload = function() {
            const nImgWidth  = oImg.naturalWidth;
            const nImgHeight = oImg.naturalHeight;

            if( ( nImgWidth + nImgHeight) > 1000 && pnBrowseType != 3 ){
                FSvCMNSetMsgWarningDialog('รูปภาพมีขนาดใหญ่เกินกำหนด กรุณาตรวจสอบ ขนาดต้องไม่เกิน 500 x 500 พิกเซล');
            }else{
                var aResult = {
                    'tImgBase64'   : oReader.result,
                    'tImgName'     : poImg.files[0].name,
                    'tImgType'     : poImg.files[0].type
                };
                JSxImageCropNEW(JSON.stringify(aResult), ptRetio, ptMasterName,pnBrowseType);
            }
        };
    }
    oReader.readAsDataURL(oFile[0]);

    


    // oImgFrom.append('file', oImgData);
    // JCNxOpenLoading();
    // $.ajax({
    //     type: "POST",
    //     url: "ImageUplode",
    //     cache: false,
    //     contentType: false,
    //     processData: false,
    //     data: oImgFrom,
    //     datatype: "JSON",
    //     timeout: 0,
    //     success: function (oResult) {
    //         // console.log(tResult);
    //         if ( oResult != "" ) {
    //             JSxImageCropNEW(oResult, ptRetio, ptMasterName,pnBrowseType);
    //         }
    //         JCNxCloseLoading();
    //     },
    //     error: function (jqXHR, textStatus, errorThrown) {
    //         JCNxCloseLoading();
    //         JCNxResponseError(jqXHR, textStatus, errorThrown);
    //     }
    // });
}

///function : Function Crop Image
//Parameters : Function Paramiter (JSoImagUplodeResize)
//Creator : 12/04/2018 (Wasin)
//Return : -
//Return Type : -
function JSxImageCropNEW(poImgData, ptRetion, ptMasterName,pnBrowseType){
    var nWinHeight = $(window).height();
    var nh = parseInt(nWinHeight) - 250;
    var nHeightCropCanvasBox = nh-30;
    var aImgData = JSON.parse(poImgData);
    if (aImgData.tImgBase64 != "") {
        $('#odvModalCrop').empty();
        // $("#odvModalCrop" + ptMasterName)
        $('#odvModalCrop')
        .append(
            '<div class="modal fade" id="oModalCropper' + ptMasterName + '" aria-labelledby="modalLabel" role="dialog" tabindex="-1" style="z-index:2000;">'+
                '<div class="modal-dialog" role="document" style="z-index:2000; margin-top: 60px;"> <div class="modal-content">'+
                    '<div class="modal-header" style="padding-bottom:10px;">'+
                        '<label class="modal-title xCNTextModalHeard" id="modalLabel" style="font-weight:bold; margin:0px 0px 0px 0px; float:left;"> ' + $('#ohdTextCrop').val() + ' </label>'+
                        '<button id="oModalCropperdelete' + ptMasterName + '" style="float:right;" type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                        '<span aria-hidden="true">&times;</span> </button>'+
                    '</div>'+
                    '<div class="modal-body" style="max-height:'+nHeightCropCanvasBox+'px;overflow-y:auto;">'+
                        '<div>'+
                            '<img id="oImageCropper' + ptMasterName + '" style="max-width: 60%;" src="' +aImgData.tImgBase64 + '" alt="Picture">'+
                        '</div>'+
                    '</div>'+
                    '<div class="modal-footer">'+
                        '<div class="pull-left">'+
                            '<div class="btn-group">'+
                                '<button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper' + ptMasterName + '\').cropper(\'zoom\', 0.1)" title="Zoom In">'+
                                    '<span class="docs-tooltip">'+
                                        '<span class="fa fa-search-plus">'+
                                        '</span>'+
                                    '</span>'+
                                '</button>'+
                                '<button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper' + ptMasterName + '\').cropper(\'zoom\', -0.1)" title="Zoom Out">'+
                                    '<span class="docs-tooltip">'+
                                        '<span class="fa fa-search-minus">'+
                                        '</span>'+
                                    '</span>'+
                                '</button>'+
                            '</div>'+
                            '<div class="btn-group">'+
                                '<button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper' + ptMasterName + '\').cropper(\'move\', -10, 0)" title="Move Left">'+
                                    '<span class="docs-tooltip">'+
                                        '<span class="fa fa-arrow-left">'+
                                        '</span>'+
                                    '</span>'+
                                '</button>'+
                                '<button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper' + ptMasterName + '\').cropper(\'move\', 10, 0)" title="Move Right">'+
                                    '<span class="docs-tooltip">'+
                                        '<span class="fa fa-arrow-right">'+
                                        '</span>'+
                                    '</span>'+
                                '</button>'+
                                '<button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper' + ptMasterName + '\').cropper(\'move\', 0, -10)" title="Move Up">'+
                                    '<span class="docs-tooltip">'+
                                        '<span class="fa fa-arrow-up">'+
                                        '</span>'+
                                    '</span>'+
                                '</button>'+
                                '<button type="button" class="btn btn-outline-primary" onclick="$(\'#oImageCropper' + ptMasterName + '\').cropper(\'move\', 0, 10)" title="Move Down">'+
                                    '<span class="docs-tooltip">'+
                                        '<span class="fa fa-arrow-down">'+
                                        '</span>'+
                                    '</span>'+
                                '</button>'+
                            '</div>'+
                        '</div>'+
                        '<button type="button" class="btn btn-outline-primary pull-right xWBtnCropImage' + ptMasterName + '" title="Crop">'+
                            '<span> ' + $('#ohdTextBTNCrop').val() + ' </span>'+
                        '</button>'+
                    '</div>'+
                '</div>'+
            '</div>'+
        '</div>');
    }
    setTimeout(function () {
        $('#odlModalTempImg' + ptMasterName).modal('hide');
        $('#oModalCropper' + ptMasterName).modal({backdrop: 'static', keyboard: false});
        $('#oModalCropper' + ptMasterName).modal("show");
        var $image = $('#oImageCropper' + ptMasterName);
        var $button = $('.xWBtnCropImage' + ptMasterName);
        var cropBoxData;
        var canvasData;
        var tRetionCropper = $('#ohdRetionCropper').val();		
        var aRetionCropper = tRetionCropper.split("/");
        $('#oModalCropper' + ptMasterName).on('shown.bs.modal', function () {
            $image.cropper({
                width : 215,
                height : 130,
                viewMode : 1,
                dragMode : 'move',
                autoCropArea : 1,
                // restore : true,
                // guides : true,
                // highlight : false,
                // cropBoxMovable : true,
                // cropBoxResizable : true,
                // strict: true,
                // background: false,
                // zoomable: false,
                aspectRatio: aRetionCropper[0]/aRetionCropper[1],
                built: function () {
                    $image.cropper("setCropBoxData", {width: "215", height: "130"});
                },
                ready: function () {
                    $image.cropper('setCanvasData', canvasData);
                    $image.cropper('setCropBoxData', cropBoxData);
                }
            });
        }).on('hidden.bs.modal', function () {
            cropBoxData = $image.cropper('getCropBoxData');
            canvasData = $image.cropper('getCanvasData');
            $image.cropper('destroy');
            $('#oModalCropper' + ptMasterName).remove();
            $('#ofilePhotoAdd').val('');
            $('#oetInputUplode' + ptMasterName).val('');
        });
        $button.on('click', function () {
            var croppedCanvas;
            var roundedCanvas;
            croppedCanvas = $image.cropper('getCroppedCanvas');
            roundedCanvas = croppedCanvas.toDataURL();

            JSxChooseImageNEW(roundedCanvas, aImgData.tImgName, pnBrowseType, ptMasterName);
            $('#oModalCropper' + ptMasterName).modal("hide");
            $('#oetInputUplode' + ptMasterName).val('');

            // $.ajax({
            //     type: "POST",
            //     url: "ImageConvertCrop",
            //     cache: false,
            //     data: {
            //         'tBase64':  roundedCanvas,
            //         'tImgName': aImgData.tImgName,
            //         'tImgtype': aImgData.tImgType,
            //         // 'tImgPath': aImgData.tImgFullPath
            //     },
            //     success: function (oResult) {
            //         var aResult = JSON.parse(oResult);
            //         // console.log(aResult);
            //         if ( aResult['tReturnCode'] == "1" ) {
                        
            //             // if( pnBrowseType == 3 ){
            //                 JSxChooseImageNEW(aResult['oImgBase64'], aResult['tImgName'], pnBrowseType, ptMasterName,roundedCanvas);
            //             // }else{
            //             //     $('#oimImgMaster' + ptMasterName).attr('src',aResult['tImgPath']);
            //             //     $('#oetImgInput' + ptMasterName).val(roundedCanvas).trigger('change');
            //             // }

            //             $('#oModalCropper' + ptMasterName).modal("hide");
            //             // JSvImageCallTempNEW('', pnBrowseType, ptMasterName);
            //         }
            //         $('#oetInputUplode' + ptMasterName).val('');
            //     },
            //     error: function (jqXHR, textStatus, errorThrown) {
            //         JCNxResponseError(jqXHR, textStatus, errorThrown);
            //     }
            // });
        });
        $('#oModalCropperdelete' + ptMasterName).click(function () {
            // JSxImageDeleteNEW(aImgData.tImgName, ptMasterName);
            $('#odlModalTempImg' + ptMasterName).modal('show');

        });
    }, 500);
}

function JCNxImgLoadScript(ptMasterName){
    // $(document).ready(function() {

        $('#oImgUpload').append('<span class="xCNColor'+ptMasterName+'" style="width:100%;cursor:pointer;"></span>');

        $(function() {
            $('.xCNSltColor').colorpicker({
                align       : 'left',
                customClass : 'colorpicker-2x',
            });
            $('.colorpicker-alpha').remove();
        });

        $('#oetImgColor'+ptMasterName).attr("readonly", true);
        let tImgObj = $('#ohdImgObj').val();
        let tcolor  = $('#ohdImgObj').data('color');
        //ตรวจสอบว่าเป็นสีหรือเปล่า
        if (tcolor == "#") {
            $(".xWTDImgDataItem").remove();
            $('#oetImgInput'+ptMasterName).val('');
            $('#ohdImgObjOld').val(tImgObj);
            $('#oimImgMaster'+ptMasterName).removeAttr('src');
            $('#oimImgMaster'+ptMasterName).hide();
            $(".xCNColor"+ptMasterName).css({
                'height': '230px',
                'width': '100%',
                'background-color': tImgObj,
                'display': 'inline-block'
            });

            // ตรวจสอบค่า checked ของสี default
            switch (tImgObj) {
                case '#2184c7': //ฟ้า
                    $('#orbChecked01').attr("checked", true);
                    break;
                case '#2f499e': //น้ำเงิน
                    $('#orbChecked02').attr("checked", true);
                    break;
                case '#9d4c2e': // น้ำตาล
                    $('#orbChecked03').attr("checked", true);
                    break;
                case '#319845': // เขียว
                    $('#orbChecked04').attr("checked", true);
                    break;
                case '#e45b25': // ส้ม
                    $('#orbChecked05').attr("checked", true);
                    break;
                case '#582979': // ม่วง
                    $('#orbChecked06').attr("checked", true);
                    break;
                case '#ee2d24': // แดง
                    $('#orbChecked07').attr("checked", true);
                    break;
                case '#000000': // ดำ
                    $('#orbChecked08').attr("checked", true);
                    break;
                default:
                    $('#oetImgColor'+ptMasterName).val(tImgObj);
                    $('#oetImgColor'+ptMasterName).attr("readonly", true);
            }
        }

        // ยกเลิก checked
        $("#ospColor").click(function() {
            $('.xCNCheckedORB').prop('checked', false);
            $('#oetImgColor'+ptMasterName).attr("readonly", false);
        });


        $("#oimImgMaster"+ptMasterName).change(function() {
            // console.log('4');
            $("#oimImgMaster"+ptMasterName).css({
                'width': ''
            });
        });

        //เซต แสดงรูป
        $("#oimTumblr"+ptMasterName).change(function() {
            $("#oimImgMaster"+ptMasterName).css({
                'width': ''
            });
        });

        //แสดงสีแทนรูป เมื่อ Checked
        $(".xCNCheckedORB").change(function() {
            let tNameColor = $(this).data('name');
            $(".xCNColor"+ptMasterName).hide();
            $(".xWTDImgDataItem").remove();
            $('#oetImgInput'+ptMasterName).val('');
            $("#oimImgMaster"+ptMasterName).css({
                'width': ''
            });
            $("#oimImgMaster"+ptMasterName).css({
                'width': '50%'
            });
            $('#oimImgMaster'+ptMasterName).removeAttr('src');
            $('#oimImgMaster'+ptMasterName).hide();
            $(".xCNColor"+ptMasterName).css({
                'height': '230px',
                'width': '100%',
                'background-color': tNameColor,
                'display': 'inline-block'
            });

            $('#oetImgColor'+ptMasterName).val('#000000');
            $('#oetImgColor'+ptMasterName).attr("readonly", true);
        });

        $('#oetImgColor'+ptMasterName).change(function() {
            let tCodeColor = $(this).val();
            $('#oimImgMaster'+ptMasterName).removeAttr('src');
            $('#oimImgMaster'+ptMasterName).hide();
            $(".xCNColor"+ptMasterName).css({
                'height': '230px',
                'width': '100%',
                'background-color': tCodeColor,
                'display': 'inline-block'
            });
            $(".xWTDImgDataItem").remove();
            $('#oetImgInput'+ptMasterName).val('');
        });

    // });
    
}

// Create By : Napat(Jame) 02/03/2021
function JCNxImgWarningMessage(paData){
    JCNxCloseLoading();
    console.log(paData); // พี่รัน Req ต้องการให้มันแสดง log call api return
    if( paData['nStaEvent'] != '001' && paData['nStaEvent'] != '1' ){
        FSvCMNSetMsgWarningDialog(paData['tStaMessg']);
    }
}