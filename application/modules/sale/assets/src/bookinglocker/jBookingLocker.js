var nBKLBrowseType      = $("#ohdBKLBrowseType").val();
var tBKLBrowseOption    = $("#ohdBKLBrowseOption").val();

$("document").ready(function(){
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose();
    if(typeof(nBKLBrowseType) != 'undefined' && nBKLBrowseType == 0){
        // Event Click Navigater Title
        $("#oliBKLTitle").unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvBKLCallPageMain();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
        JSxBKLNavDefult();
        JSvBKLCallPageMain();
    }else{
        JSvBKLCallPageMain();
    }
});

// Function: Set Defult Nav Menu
// Parameters: Document Ready Or Parameter Event
// Creator: 29/10/2019 wasin(Yoshi)
// Return: Set Default Nav Menu
// ReturnType: -
function JSxBKLNavDefult(){
    if(typeof(nBKLBrowseType) != 'undefined' && nBKLBrowseType == 0) {
        // Title Label Hide/Show
        $('#oliBKLTitleAdd').hide();
        $('#oliBKLTitle').show();
    }else{

    }
}

// Function: Call Page Booking Locker Main
// Parameters: Document Redy And Function Call Back Event
// Creator:	29/10/2019 wasin(Yoshi)
// Return: View Main Home
// ReturnType: View
function JSvBKLCallPageMain(){
    JCNxOpenLoading();
    localStorage.tStaPageNow = 'JSvBKLCallPageMain';
    $.ajax({
        type: "GET",
        url: "salBookingLockerPageMain",
        success: function(tResult){
            $('#odvContentPageBKL').html(tResult);
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function: Fucntion Call Data Rack Status 
// Parameters: Document Redy And Function Call Back Event
// Creator:	29/10/2019 wasin(Yoshi)
// Return: View Main Home
// ReturnType: View
function JSoBKLGetDataViewStatusRack(){
    $('#ofmBKLConditionFilter').validate().destroy();
    $('#ofmBKLConditionFilter').validate({
        focusInvalid: false,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
            oetBKLBchName : {"required" :{}},
            oetBKLShpName : {"required" :{}},
            oetBKLPosName : {"required" :{}},
        },
        messages: {
            oetBKLBchName   : {
                "required"  : $('#oetBKLBchName').attr('data-validate-required'),
            },
            oetBKLShpName   : {
                "required"  : $('#oetBKLShpName').attr('data-validate-required'),
            },
            oetBKLPosName   : {
                "required"  : $('#oetBKLPosName').attr('data-validate-required'),
            },
        },
        errorElement: "em",
        errorPlacement: function(error, element) {
            error.addClass("help-block");
            if (element.prop("type") === "checkbox") {
                error.appendTo(element.parent("label"));
            } else {
                var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                if (tCheck == 0) {
                    error.appendTo(element.closest('.form-group')).trigger('change');
                }
            }
        },
        highlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
        },
        unhighlight: function(element, errorClass, validClass) {
            var nStaCheckValid = $(element).parents('.form-group').find('.help-block').length
            if (nStaCheckValid != 0) {
                $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
            }
        },
        submitHandler: function (form){
            JCNxOpenLoading();
            $.ajax({
                type: 'POST',
                url: "salBookingLockerGetViewRack",
                data: $('#ofmBKLConditionFilter').serialize(),
                success: function(tViewRockerStatus){
                    $('#odvBKLPanelViewLocker #odvBKLViewLockerData').html(tViewRockerStatus);
                    var nViewPanelResolution    = $('#ohdBKLViewHeightResolution').val()-40;
                    $('#odvBKLDataViewRackStatus').css('height',nViewPanelResolution);
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown){
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    });
}

// Function: Fucntion Call View Modal Add
// Parameters: Document Redy And Function Call Back Event
// Creator:	29/10/2019 wasin(Yoshi)
// Return: View Main Home
// ReturnType: View
function JCNoBKLCallPageAddBooking(){
    $('#ofmBKLConditionFilter').validate().destroy();
    $('#ofmBKLConditionFilter').validate({
        focusInvalid: false,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
            oetBKLBchName : {"required" :{}},
            oetBKLShpName : {"required" :{}},
            oetBKLPosName : {"required" :{}},
        },
        messages: {
            oetBKLBchName   : {
                "required"  : $('#oetBKLBchName').attr('data-validate-required'),
            },
            oetBKLShpName   : {
                "required"  : $('#oetBKLShpName').attr('data-validate-required'),
            },
            oetBKLPosName   : {
                "required"  : $('#oetBKLPosName').attr('data-validate-required'),
            },
        },
        errorElement: "em",
        errorPlacement: function(error, element) {
            error.addClass("help-block");
            if (element.prop("type") === "checkbox") {
                error.appendTo(element.parent("label"));
            } else {
                var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                if (tCheck == 0) {
                    error.appendTo(element.closest('.form-group')).trigger('change');
                }
            }
        },
        highlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
        },
        unhighlight: function(element, errorClass, validClass) {
            var nStaCheckValid = $(element).parents('.form-group').find('.help-block').length
            if (nStaCheckValid != 0) {
                $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
            }
        },
        submitHandler: function (form){
            JCNxOpenLoading();
            $.ajax({
                type: 'POST',
                url: "salBookingLockerGetModalBooking",
                data:  $('#ofmBKLConditionFilter').serialize(),
                success: function(tViewRockerStatus){
                    JSxCheckPinMenuClose();
                    setTimeout(function(){
                        $('#odvBKLModalDataContent').html(tViewRockerStatus);
                        $('#odvBKLModalBooking').modal({backdrop: 'static', keyboard: false});  
                        $('#odvBKLModalBooking').modal('show');
                        JCNxCloseLoading();
                    },1000)
                },
                error: function (jqXHR, textStatus, errorThrown){
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    });
    $('#ofmBKLConditionFilter').submit();
}

// Function: Confrim Save Booking Locker 
// Parameters: Event Click Button Save
// Creator:	04/11/2019 Wasin(Yoshi)
// Return: View Main Home
// ReturnType: View
function JCNoBKLConfirmBookingLocker(){
    $('#odvBKLModalBooking #ofmBKLModalFormAddCancelBooking').validate().destroy();
    $('#odvBKLModalBooking #ofmBKLModalFormAddCancelBooking').validate({
        focusInvalid: false,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
            'oetBKLRthName'         : {"required" :{}},
            'oetBKLBkgRefCst'       : {"required" :{}},
            'oetBKLBkgRefCstDoc'    : {"required" :{}},
            'oetBKLBkgRefCstLogin'  : {"required" :{}},
        },
        messages: {
            oetBKLRthName           : {
                "required"  : $('#oetBKLRthName').attr('data-validate-required'),
            },
            oetBKLBkgRefCst         : {
                "required"  : $('#oetBKLBkgRefCst').attr('data-validate-required'),
            },
            oetBKLBkgRefCstDoc      : {
                "required"  : $('#oetBKLBkgRefCstDoc').attr('data-validate-required'),
            },
            oetBKLBkgRefCstLogin    : {
                "required"  : $('#oetBKLBkgRefCstLogin').attr('data-validate-required'),
            },
        },
        errorElement: "em",
        errorPlacement: function(error, element) {
            error.addClass("help-block");
            if (element.prop("type") === "checkbox") {
                error.appendTo(element.parent("label"));
            } else {
                var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                if (tCheck == 0) {
                    error.appendTo(element.closest('.form-group')).trigger('change');
                }
            }
        },
        highlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
        },
        unhighlight: function(element, errorClass, validClass) {
            var nStaCheckValid = $(element).parents('.form-group').find('.help-block').length
            if (nStaCheckValid != 0) {
                $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
            }
        },
        submitHandler: function (form){
            $.ajax({
                type: 'POST',
                url: "salBookingLockerConfirmBookingLocker",
                data: $(form).serialize(),
                success: function(oResponsBooking){
                    let aResponsBooking = JSON.parse(oResponsBooking);
                    if(aResponsBooking['ptStatusSendMQ'] == 1){
                        $('#odvBKLModalBooking').hide();
                        $('.modal-backdrop').remove();
                        $('body').removeClass( "modal-open" );
                        setTimeout(function(){
                            // Call Subscript Booking Locker
                            JCNxSubscriptConfirmBookingLocker(aResponsBooking);
                        },500);
                    }else{
                        let tMessageError   = aResponsBooking['ptTextResponse'];
                        FSvCMNSetMsgErrorDialog(tMessageError);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown){
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    });
    $('#odvBKLModalBooking #ofmBKLModalFormAddCancelBooking').submit();
}

// Function: Subscript Booking Locker
// Parameters: Event Click Button Save
// Creator:	04/11/2019 Wasin(Yoshi)
// Return: View Main Home
// ReturnType: View
function JCNxSubscriptConfirmBookingLocker(paResponsBooking){
    let aDataSubScribe      = paResponsBooking.paDataSubScribe;
    let tBKLSubScribeQueues = aDataSubScribe.tSubScribeQueues;
    let oBKLMQConfig        = {
        host        : "ws://" + oBKLSTOMMQConfig.host + ":15674/ws",
        username    : oBKLSTOMMQConfig.user,
        password    : oBKLSTOMMQConfig.password,
        vHost       : oBKLSTOMMQConfig.vhost
    };
    // Listening rabbit mq server
    var oClient     = Stomp.client(oBKLMQConfig.host);
    var on_connect  = function (x) {
        oClient.subscribe(tBKLSubScribeQueues,function(oResponeBooking) {
            let tDataResBookingMQ   = oResponeBooking.body;
            let oDataResBookingMQ   = jQuery.parseJSON(tDataResBookingMQ);
            // Check Function Return
            if(oDataResBookingMQ.ptFunction == 'Booking'){
                if(oDataResBookingMQ.ptSource == 'AdaSmartLocker' && oDataResBookingMQ.ptDest == 'AdaStoreBack'){
                    if(oDataResBookingMQ.ptData.pbSuccess == '200'){
                        setTimeout(function(){
                            $('#odvBKLModalStatusResponse').modal('hide');
                            $('.modal-backdrop').remove();
                            $('body').removeClass( "modal-open" );
                            $('#obtBKLFilterData').trigger('click');
                            JCNxDeleteBookingQueuesLocker(tBKLSubScribeQueues);
                            oClient.disconnect();
                        },2000)
                    }else{
                        $('#odvBKLModalStatusResponse').modal('hide');
                        $('.modal-backdrop').remove();
                        $('body').removeClass( "modal-open" );
                        let tMessageError   = oDataResBookingMQ.ptData.ptDesc;
                        FSvCMNSetMsgErrorDialog(tMessageError);
                        JCNxDeleteBookingQueuesLocker(tBKLSubScribeQueues);
                        $('#obtBKLFilterData').trigger('click');
                        oClient.disconnect();
                    }
                }
            }
        });
    };
    var on_error = function () {
        JCNxResponseError('Error Process Subscribe Report Export.');
    };
    $('#odvBKLModalStatusResponse #ospBKLBookingHeader').text(aDataSubScribe.tTitleModalResponse);
    $('#odvBKLModalStatusResponse .xCNMessage').text(aDataSubScribe.tLabelModalResponse);
    $('#odvBKLModalStatusResponse #odvBKLLoadingBar').attr('class','progress-bar progress-bar-striped active');
    $('#odvBKLModalStatusResponse #odvBKLLoadingBar').css('background-color','#179BFD');
    $('#odvBKLModalStatusResponse').modal({backdrop: 'static', keyboard: false}); 
    $('#odvBKLModalStatusResponse').modal('show');
    oClient.connect(oBKLMQConfig.username,oBKLMQConfig.password, on_connect, on_error,oBKLMQConfig.vHost);

    // Settime Out Limit Disconnect Rabbit MQ
    setTimeout(function(){
        $('#odvBKLModalStatusResponse').modal('hide');
        $('.modal-backdrop').remove();
        $('body').removeClass( "modal-open" );
        $('#obtBKLFilterData').trigger('click');
        oClient.disconnect();
        $('#obtBKLFilterData').trigger('click');
    },120000);
}

// Function: Confrim Ca Booking Locker 
// Parameters: Event Click Button Save
// Creator:	04/11/2019 Wasin(Yoshi)
// Return: View Main Home
// ReturnType: View
function JCNoBKLCancelBookingLocker(){
    $('#odvBKLModalBooking #ofmBKLModalFormAddCancelBooking').validate().destroy();
    $('#odvBKLModalBooking #ofmBKLModalFormAddCancelBooking').validate({
        focusInvalid: false,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
            'oetBKLRthName'         : {"required" :{}},
            'oetBKLBkgRefCst'       : {"required" :{}},
            'oetBKLBkgRefCstDoc'    : {"required" :{}},
            'oetBKLBkgRefCstLogin'  : {"required" :{}},
        },
        messages: {
            oetBKLRthName           : {
                "required"  : $('#oetBKLRthName').attr('data-validate-required'),
            },
            oetBKLBkgRefCst         : {
                "required"  : $('#oetBKLBkgRefCst').attr('data-validate-required'),
            },
            oetBKLBkgRefCstDoc      : {
                "required"  : $('#oetBKLBkgRefCstDoc').attr('data-validate-required'),
            },
            oetBKLBkgRefCstLogin    : {
                "required"  : $('#oetBKLBkgRefCstLogin').attr('data-validate-required'),
            },
        },
        errorElement: "em",
        errorPlacement: function(error, element) {
            error.addClass("help-block");
            if (element.prop("type") === "checkbox") {
                error.appendTo(element.parent("label"));
            } else {
                var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                if (tCheck == 0) {
                    error.appendTo(element.closest('.form-group')).trigger('change');
                }
            }
        },
        highlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
        },
        unhighlight: function(element, errorClass, validClass) {
            var nStaCheckValid = $(element).parents('.form-group').find('.help-block').length
            if (nStaCheckValid != 0) {
                $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
            }
        },
        submitHandler: function (form){
            $.ajax({
                type: 'POST',
                url: "salBookingLockerCancelBookingLocker",
                data:  $(form).serialize(),
                success: function(oResponsBooking){
                    let aResponsBooking = JSON.parse(oResponsBooking);
                    if(aResponsBooking['ptStatusSendMQ'] == 1){
                        $('#odvBKLModalBooking').hide();
                        $('.modal-backdrop').remove();
                        $('body').removeClass( "modal-open" );
                        setTimeout(function(){
                            // Call Subscript Booking Locker
                            JCNxSubscriptCancelBookingLocker(aResponsBooking);
                        },500);
                    }else{
                        let tMessageError   = aResponsBooking['ptTextResponse'];
                        FSvCMNSetMsgErrorDialog(tMessageError);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown){
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    });
    $('#odvBKLModalBooking #ofmBKLModalFormAddCancelBooking').submit();
}

// Function: Subscript Cancel Booking Locker
// Parameters: Event Click Button Save
// Creator:	04/11/2019 Wasin(Yoshi)
// Return: View Main Home
// ReturnType: View
function JCNxSubscriptCancelBookingLocker(paResponsBooking){
    let aDataSubScribe      = paResponsBooking.paDataSubScribe;
    let tBKLSubScribeQueues = aDataSubScribe.tSubScribeQueues;
    let oBKLMQConfig        = {
        host        : "ws://" + oBKLSTOMMQConfig.host + ":15674/ws",
        username    : oBKLSTOMMQConfig.user,
        password    : oBKLSTOMMQConfig.password,
        vHost       : oBKLSTOMMQConfig.vhost
    };
    // Listening rabbit mq server
    var oClient     = Stomp.client(oBKLMQConfig.host);
    var on_connect  = function (x) {
        oClient.subscribe(tBKLSubScribeQueues,function(oResponeCancel) {
            let tDataResCancalMQ    = oResponeCancel.body;
            let oDataResCancalMQ    = jQuery.parseJSON(tDataResCancalMQ);
            // Check Function Return 
            if(oDataResCancalMQ.ptFunction == 'Cancel'){
                if(oDataResCancalMQ.ptSource == 'AdaSmartLocker' && oDataResCancalMQ.ptDest == 'AdaStoreBack'){
                    if(oDataResCancalMQ.ptData.pbSuccess == '200'){                       
                        setTimeout(function(){
                            $('#odvBKLModalStatusResponse').modal('hide');
                            $('.modal-backdrop').remove();
                            $('body').removeClass( "modal-open" );
                            $('#obtBKLFilterData').trigger('click');
                            JCNxDeleteBookingQueuesLocker(tBKLSubScribeQueues);
                            oClient.disconnect();
                        },2000)
                    }else{
                        $('#odvBKLModalStatusResponse').modal('hide');
                        $('.modal-backdrop').remove();
                        $('body').removeClass( "modal-open" );
                        let tMessageError   = oDataResCancalMQ.ptData.ptDesc;
                        FSvCMNSetMsgErrorDialog(tMessageError);
                        JCNxDeleteBookingQueuesLocker(tBKLSubScribeQueues);
                        $('#obtBKLFilterData').trigger('click');
                        oClient.disconnect();
                    }
                }
            }
        });
    };
    var on_error = function () {
        JCNxResponseError('Error Process Subscribe Report Export.');
    };
    $('#odvBKLModalStatusResponse #ospBKLBookingHeader').text(aDataSubScribe.tTitleModalResponse);
    $('#odvBKLModalStatusResponse .xCNMessage').text(aDataSubScribe.tLabelModalResponse);
    $('#odvBKLModalStatusResponse #odvBKLLoadingBar').attr('class','progress-bar progress-bar-striped active');
    $('#odvBKLModalStatusResponse #odvBKLLoadingBar').css('background-color','#179BFD');
    // $('#odvBKLModalStatusResponse #odvBKLLoadingBar').attr('class','progress-bar progress-bar-danger progress-bar-striped active');
    // $('#odvBKLModalStatusResponse #odvBKLLoadingBar').css('background-color','');
    $('#odvBKLModalStatusResponse').modal({backdrop: 'static', keyboard: false}); 
    $('#odvBKLModalStatusResponse').modal('show');
    oClient.connect(oBKLMQConfig.username,oBKLMQConfig.password, on_connect, on_error,oBKLMQConfig.vHost);

    // Settime Out Limit Disconnect Rabbit MQ
    setTimeout(function(){
        $('#odvBKLModalStatusResponse').modal('hide');
        $('.modal-backdrop').remove();
        $('body').removeClass( "modal-open" );
        $('#obtBKLFilterData').trigger('click');
        oClient.disconnect();
    },120000);
}

// Function: Delete Queues
// Parameters: Event Click Button Save
// Creator:	04/11/2019 Wasin(Yoshi)
// Return: View Main Home
// ReturnType: View
function JCNxDeleteBookingQueuesLocker(ptQueuesName){
    $.ajax({
        type: 'POST',
        url: "salBookingLockerDeleteQueues",
        data: {'ptQueuesName':ptQueuesName},
        success: function(oResponsBooking){
            return;
        },
        error: function (jqXHR, textStatus, errorThrown){
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}