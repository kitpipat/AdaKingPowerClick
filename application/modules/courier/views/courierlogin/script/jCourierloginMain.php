<script type="text/javascript">
    $(document).ready(function () {
        JSvCURLList(1);
    });


    //Functionality : Add Data Agency Add/Edit  
    //Parameters : from ofmAddEditCourierManLogin
    //Creator : 04/07/2019 witsarut (Bell)
    //Return : View
    //Return Type : View
    function JSxCMLSaveAddEdit(ptRoute) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#ofmAddEditCourierManLogin').validate().destroy();
            $.validator.addMethod('dublicateCode', function(value, element) {
                if($("#ohdValidateDuplicate").val()==1){
                    if($("#ocmlogintype").val()==1 || $("#ocmlogintype").val()==2){
                        if($(element).attr("id")=="oetidCurlogin"){
                            return false;
                        }else{
                            return true;
                        }
                    }else{
                        if($(element).attr("id")=="oetidCurlogPw"){
                            return false;
                        }else{
                            return true;
                        }
                    }
                    return false;
                }else{
                    return true;
                }
            });
            $('#ofmAddEditCourierManLogin').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetidCurlogin  : {
                        "required" :{
                            depends: function (oElement) {
                                if($("#ohdTRoute").val()=="courierloginEventAdd"){
                                    return true;
                                }else{
                                    return false;
                                }
                            }
                        },
                        "dublicateCode":{}
                    },

                    oetidCurlogPw  : {
                        "required" :{
                            depends: function (oElement) {
                                if($("#ohdTRoute").val()=="courierloginEventAdd"){
                                    return true;
                                }else{
                                    return false;
                                }
                            }
                        },
                        "dublicateCode":{}
                    },
                },
                messages: {
                    oetidCurlogin : {
                        "required"      : $('#oetidCurlogin').attr('data-validate-required'),
                        "dublicateCode" : "มีโค๊ดซ้ำกัน"
                    },
                    oetidCurlogPw : {
                        "required"      : $('#oetidCurlogPw').attr('data-validate-required'),
                        "dublicateCode" : "มีโค๊ดซ้ำกัน"
                    },
                },
                errorElement: "em",
                errorPlacement: function (error, element ) {
                    error.addClass( "help-block" );
                    if ( element.prop( "type" ) === "checkbox" ) {
                        error.appendTo( element.parent( "label" ) );
                    } else {
                        var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                        if(tCheck == 0){
                            error.appendTo(element.closest('.form-group')).trigger('change');
                        }
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
                },
                unhighlight: function(element, errorClass, validClass) {
                    $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                },
            submitHandler: function(form) {

                // updated การเข้ารหัส
                // ------------ Create by Witsarut 31/08/2019 -------------
                if($("#ocmlogintype").val()==3 || $("#ocmlogintype").val()==4){
                    $("#oetCurloginPasswordOld").val(JCNtAES128EncryptData($("#oetidCurlogin").val(),tKey,tIV));
                }else{
                    $("#oetCurloginPasswordOld").val(JCNtAES128EncryptData($("#oetidCurlogPw").val(),tKey,tIV));
                }            
     
                // ------------ Create by Witsarut 31/08/2019 -------------

                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmAddEditCourierManLogin').serialize(),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        //console.log(tResult);
                        var aData = JSON.parse(tResult);
                        if(aData["nStaEvent"]==1){
                            //JSvCallPageCourierloginEdit(aData["tCodeReturn"]);
                            JSxCMLGetContent();
                        }else{
                            $("#ohdValidateDuplicate").val(1);
                            JSxCMLSaveAddEdit(ptRoute);
                            $('#ofmAddEditCourierManLogin').submit();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                },
            });
        }
    }


    //function : Call PosAds Page list  
    //Parameters : Document Redy And Event Button
    //Creator :	30/10/2018 Witsarut (Bell)
    //Return : View
    //Return Type : View
    function JSvCURLList(nPage){
        var tCryLogCode            =   $('#ohdCryLogCode').val();
        var tCryLogCryManCardID    =   $('#ohdCryLogCryManCardID').val();
        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "courierloginDataTable",
            data    : {
                tCryLogCode         : tCryLogCode,
                tCryLogCryManCardID : tCryLogCryManCardID,
                nPageCurrent        : nPage,
                tSearchAll          : ''
            },
            cache   : false,
            Timeout : 0,
            async   : false,
            success : function(tView){
                $('#odvContentCURLDataTable').html(tView);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //เปลี่ยนหน้า pagenation
    function JSvCURLClickPage(ptPage) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xWBtnNext").addClass("disabled");
                nPageOld = $(".xWSMLPaging .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
            break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xWSMLPaging .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
            break;
            default:
            nPageCurrent = ptPage;
        }
        JSvCURLList(nPageCurrent);
    }

    //Event ลบข้อมูลรายการเดียว
    function JSxCURLDelete(ptManloginCode, tYesOnNo){
        $('#odvModalDeleteSingle').modal('show');
        $('#odvModalDeleteSingle #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptManloginCode + ' '+ tYesOnNo );
        $('#odvModalDeleteSingle #osmConfirmDelete').on('click', function(evt) {
            $.ajax({
                type: "POST",
                url: "courierloginEventDelete",
                data: { 
                    tManloginCode   : ptManloginCode,
                },
                cache: false,
                success: function(tResult) {
                    $('#odvModalDeleteSingle').modal('hide');
                    setTimeout(function(){
                        JSvCURLList(1);
                    }, 500);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    }

    //Functionality : (event) Delete All
    //Parameters :
    //Creator : 11/06/2019 Witsarut (Bell)
    //Return : 
    //Return Type :
    function JSxCURLDeleteMutirecord(pnPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            var aDataCryCode    =[];
            var aDataCardId     =[];
            var aDataLogType    =[];
            var aDataPwStart    =[];
            var ocbListItem     = $(".ocbListItem");
            for(var nI = 0;nI<ocbListItem.length;nI++){
                if($($(".ocbListItem").eq(nI)).prop('checked')){
                    aDataCryCode.push($($(".ocbListItem").eq(nI)).attr("ohdconfirmcrycodedelete"));
                    aDataCardId.push($($(".ocbListItem").eq(nI)).attr("ohdconfirmcardiddelete"));
                    aDataLogType.push($($(".ocbListItem").eq(nI)).attr("ohdconfirmlogtypedelete"));
                    aDataPwStart.push($($(".ocbListItem").eq(nI)).attr("ohdconfirmpwdstartdelete"));
                }
            }
            
            $.ajax({
                type: "POST",
                url: "courierloginEventDeleteMultiple",
                data: {
                    'paDataCryCode'   : aDataCryCode,
                    'paDataCardId'    : aDataCardId,
                    'paDataLogType'   : aDataLogType,
                    'paDataPwStart'   : aDataPwStart,
                },
                cache: false,
                success: function(tResult){
                    tResult = tResult.trim();
                    var aReturn = $.parseJSON(tResult);
                    if (aReturn['nStaEvent'] == '1'){
                        $('#odvModalDeleteMutirecord').modal('hide');
                        $('#ospConfirmDelete').empty();
                        localStorage.removeItem('LocalItemData');
                        
                        setTimeout(function(){
                            JSvCURLList(pnPage);
                        }, 500);
                    }else{
                        alert(aReturn['tStaMessg']);
                    }
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

 
    //Functionality: Function Chack And Show Button Delete All
    //Parameters: LocalStorage Data
    //Creator: 05/07/2019 witsarut (Bell)
    //Return: - 
    //Return Type: -
    function JSxSMSShowButtonChoose() {
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
    //Creator: 05/07/2019 witsarut (Bell)
    //Return: -
    //Return Type: -
    function JSxSMSPaseCodeDelInModal() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
            var tTextCode = '';
            for ($i = 0; $i < aArrayConvert[0].length; $i++) {
                tTextCode += aArrayConvert[0][$i].nCode;
                tTextCode += ' , ';
            }
            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
            $('#ohdConfirmIDDelete').val(tTextCode);
        }
    }

    //Functionality: Function Chack Value LocalStorage
    //Parameters: Event Select List Branch
    //Creator: 05/07/2019 witsarut (Bell)
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

    //Functionality : Call Credit Page Add  
    //Parameters : -
    //Creator : 10/06/2019 Witsarut(Bell)
    //Return : View
    //Return Type : View
    function JSvCallPageCourierloginAdd() {
        
        tCryCode  = $('#ohdCryLogCode').val(); //รหัสบริษัทส่งของ
        tCryManCardID  = $('#ohdCryLogCryManCardID').val(); //รหัสพนักงานส่งของ

        JCNxOpenLoading();
        $.ajax({
            type: "GET",
            url: "courierloginPageAdd",
            data: {
                tCryCode:tCryCode,
                tCryManCardID : tCryManCardID
            },
            cache: false,
            timeout: 5000,
            success: function(tResult) {
                $('#odvCourierLoginData').html(tResult);
                $('.xWPageAdd').removeClass('hidden');
                $('.xWPageEdit').addClass('hidden');
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Functionality : Call Credit Page Edit  
    //Parameters : -
    //Creator : 10/06/2019 witsarut (Bell)
    //Return : View
    //Return Type : View
    function JSvCallPageCourierloginEdit(ptManlogin) {
    
        JCNxOpenLoading();
        tCryCode        = $('#ohdCryLogCode').val(); //รหัสบริษัทส่งของ
        tCryManCardID   = $('#ohdCryLogCryManCardID').val(); //รหัสพนักงานส่งของ

        $.ajax({
            type: "POST",
            url: "courierloginPageEdit",
            data:{
                tCryCode        : tCryCode,
                tCryManCardID   : tCryManCardID,
                tManlogin       : ptManlogin
            },
            cache: false,
            timeout: 5000,
            success: function(tResult) {
                $('#odvCourierLoginData').html(tResult);
                $('.xWPageAdd').addClass('hidden');
                $('.xWPageEdit').removeClass('hidden');
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    // Functionality: Function Check Is Create Page
    // Parameters: Event Documet Redy
    // Creator: 04/07/2019 witsarut (Bell)
    // Return: object Status Delete
    // ReturnType: boolean
    function JSbShopSizeIsCreatePage(){
        try{
            const tPzeCode = $('#oetPzeCode').data('is-created');    
            var bStatus = false;
            if(tPzeCode == ""){ // No have data
                bStatus = true;
            }
            return bStatus;
        }catch(err){
            console.log('JSbShopSizeIsCreatePage Error: ', err);
        }
    }

    // Functionality: Function Check Is Update Page
    // Parameters: Event Documet Redy
    // Creator: 04/07/2019 witsarut (Bell)
    // Return: object Status Delete
    // ReturnType: boolean
    function JSbShopSizeIsUpdatePage(){
        try{
            const tPzeCode = $('#oetPzeCode').data('is-created');
            var bStatus = false;
            if(!tPzeCode == ""){ // Have data
                bStatus = true;
            }
            return bStatus;
        }catch(err){
            console.log('JSbShopSizeIsUpdatePage Error: ', err);
        }
    }

  

    // Create By : Kitpipat
    // Functionality : Control Input User/Password From Login Type Selected
    // Parameters : -
    // Creator: 10/08/2019
    // Return : -
    // Return Type : -
    function JSxCLICheckLoginTypeUsed(ptType){
             
            //  ดึงค่าตัวเลือกจากตัวเลือกประเภทการเข้าใช้งาน
            nLoginType = $('#ocmlogintype').val();
            // alert(nLoginType);

            /* กรณีเปลี่ยนประเภทการเข้าใช้งานรูปแบบการกรอกข้อมูล Username/Password จะเปลี่ยนไปดังนี้
            1 รหัสผ่าน ให้กรอก ชื่อผู้ใช้ และ รหัสผ่าน
            2 PIN ให้กรอกเบอร์โทรศัพท์ และ PIN
            3 RFID ให้กรอก RFID Code และทำการ Coppy ไปลงคอลัม รหัสผ่าน(Password)
            4 QR ให้กรอก QR Code และทำการ Coppy ไปลงคอลัม รหัสผ่าน(Password) 
            */
            switch (nLoginType){
                case '1' :
                         JSxCLIControlInputTypePassword();
                         // แสดง Input Password
                         JSxCLIControlPwsPanalShow();
                break;
                case '2' :
                         JSxCLIControlInputTypePIN();
                         // แสดง Input Password
                         JSxCLIControlPwsPanalShow();
                break;
                case '3' :
                         JSxCLIControlInputTypeRFID();
                         // ซ่อน Input Password กรณีที่เลือกประเภท RFID
                         JSxCLIControlPwsPanalHide();
                break;
                case '4' :
                         JSxCLIControlInputTypeQRCODE();
                         // ซ่อน Input Password กรณีที่เลือกประเภท RFID
                         JSxCLIControlPwsPanalHide();
                break;
                
                default:
                        JSxCLIControlInputTypePassword();
                       // แสดง Input Password
                       JSxCLIControlPwsPanalShow();
                 
            }
             
            // Reset ค่า User / Passwrod ทุกครั้งกรณีมีการเปลี่ยนประเภทการล็อกอิน
            if(ptType == 'insert'){
                JSxCLIControlInputResetVal();
            }

    }

    // Create By : Kitpipat
    // Functionality : Control Input User/Password Type Password
    // Parameters : -
    // Creator: 10/08/2019
    // Return : -
    // Return Type : 
    function JSxCLIControlInputTypePassword(){
            //เลือกประเภท Password
                //แสดง
                $('#olbCLILocinAcc').show(); // Label ชื่อผู้ใช้
                $('#olbCLIPassword').show(); // Label รหัสผ่าน
                
                //Placeholder
                tHolderLocAcc = $('#olbCLILocinAcc').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
                $("#oetidCurlogin").attr("placeholder",tHolderLocAcc);
                
                tHolderLocPw = $('#olbCLIPassword').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
                $("#oetidCurlogPw").attr("placeholder",tHolderLocPw);

                //Validate Input Account
                $('#oetidCurlogin').removeClass('xCNInputNumericWithoutDecimal');

                //ซ่อน
                $('#olbCLITelNo').hide(); // Label เบอร์โทรศัพท์
                $('#olbCLIRFID').hide();  // Label RFID
                $('#olbCLIQRCode').hide();  // Label QR Code
                $('#olbCLIPin').hide();   // Label PIN

                
    }

    // Create By : Kitpipat
    // Functionality : Control Input User/Password Type Password
    // Parameters : -
    // Creator: 10/08/2019
    // Return : -
    // Return Type : 
    function JSxCLIControlInputTypePIN(){
            //เลือกประเภท PIN    
                //แสดง
                $('#olbCLITelNo').show(); // Label เบอร์โทรศัพท์
                $('#olbCLIPin').show();   // Label PIN

                //Placeholder Input CurLoginID
                tHolderLocAcc = $('#olbCLITelNo').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
                $("#oetidCurlogin").attr("placeholder",tHolderLocAcc);

                //Placeholder Input CurLoginPassword
                tHolderLocPw = $('#olbCLIPin').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
                $("#oetidCurlogPw").attr("placeholder",tHolderLocPw);

                //Validate Input Account
                $('#oetidCurlogin').addClass('xCNInputNumericWithoutDecimal');

                //ซ่อน
                $('#olbCLILocinAcc').hide(); // Label ชื่อผู้ใช้
                $('#olbCLIPassword').hide(); // Label รหัสผ่าน
                $('#olbCLIRFID').hide();  // Label RFID
                $('#olbCLIQRCode').hide();  // Label QR Code
    }

    // Create By : Kitpipat
    // Functionality : Control Input User/Password Type RFID
    // Parameters : -
    // Creator: 10/08/2019
    // Return : -
    // Return Type : 
    function JSxCLIControlInputTypeRFID(){

            //เลือกประเภท RFID    
                //แสดง
                $('#olbCLIRFID').show();  // Label RFID

                //Placeholder Input CurLoginID
                tHolderLocAcc = $('#olbCLIRFID').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
                $("#oetidCurlogin").attr("placeholder",tHolderLocAcc);

                //Placeholder Input CurLoginPassword
                tHolderLocPw = $('#olbCLIPin').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
                $("#oetidCurlogPw").attr("placeholder",tHolderLocPw);

                //Validate Input Account
                $('#oetidCurlogin').removeClass('xCNInputNumericWithoutDecimal');

                //ซ่อน
                $('#olbCLILocinAcc').hide(); // Label ชื่อผู้ใช้
                $('#olbCLITelNo').hide(); // Label เบอร์โทรศัพท์
                $('#olbCLIQRCode').hide();  // Label QR Code
    }


    // Create By : Witsarut
    // Functionality : Control Input User/Password Type QRCODE
    // Parameters : -
    // Creator: 10/08/2019
    // Return : -
    // Return Type : 
    function JSxCLIControlInputTypeQRCODE(){

            //เลือกประเภท RFID    
                //แสดง
                $('#olbCLIQRCode').show();  // Label RFID
                //Placeholder Input CurLoginID
                tHolderLocAcc = $('#olbCLIQRCode').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
                $("#oetidCurlogin").attr("placeholder",tHolderLocAcc);

                //Placeholder Input CurLoginPassword
                tHolderLocPw = $('#olbCLIQRCode').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
                $("#oetidCurlogPw").attr("placeholder",tHolderLocPw);

                //Validate Input Account
                $('#oetidCurlogin').removeClass('xCNInputNumericWithoutDecimal');

                //ซ่อน
                $('#olbCLILocinAcc').hide(); // Label ชื่อผู้ใช้
                $('#olbCLITelNo').hide(); // Label เบอร์โทรศัพท์
                $('#olbCLIRFID').hide();  // Label RFID
    }


    // Create By : Kitpipat
    // Functionality : Reset Password Type Password
    // Parameters : -
    // Creator: 10/08/2019
    // Return : -
    // Return Type : 
    function JSxCLIControlInputResetVal(){

             $('#oetidCurlogin').val('');
             $('#oetidCurlogPw').val('');
    }

    
    // Create By : Kitpipat
    // Functionality : Hidden Password Panel
    // Parameters : -
    // Creator: 10/08/2019
    // Return : -
    // Return Type : 
    function JSxCLIControlPwsPanalHide(){
        $('#odvCLIPwsPanel').hide();  // Password Panel
    }

    // Create By : Kitpipat
    // Functionality : Show Password Panel
    // Parameters : -
    // Creator: 10/08/2019
    // Return : -
    // Return Type : 
    function JSxCLIControlPwsPanalShow(){
        $('#odvCLIPwsPanel').show();  // Password Panel
    }


    $('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });


    $('#obtCurlogStart').click(function(event){
        $('#oetCurlogStart').datepicker('show');
    });

    $('#obtCurlogStop').click(function(event){
        $('#oetCurlogStop').datepicker('show');
    });

    $('#ocmlogintype').selectpicker();


    //ตรวจสอบหมายเลขเบอร์ซ้ำ
    $('#oetidCurlogin').blur(function(){
        JSxCheckTelCourieLoginDupInDB();
    });

    //Functionality : Event Check CourieLogin Tel
    //Parameters : Event Blur Input CourieLogin Tel
    //Creator : 28/08/2019 saharat (Golf)
    //Update : -
    //Return : -
    //Return Type : -
    function JSxCheckTelCourieLoginDupInDB(){
        var tloginCode = $("#oetidCurlogin").val();
        $('#ofmAddEditCourierManLogin').validate().destroy();
        $.ajax({
                type: "POST",
                url: "courierloginCheckInputGenCode",
                data: { 
                    ptloginCode : tloginCode,
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aReturn = JSON.parse(tResult);
                    $("#ohdValidateDuplicate").val(aReturn["rtCode"]);  
            }
        });
    }
</script>