<script type="text/javascript">

    //function : Call PosAds Page list  
    //Parameters : Document Redy And Event Button
    //Creator :	19/08/2019 Witsarut (Bell)
    //Return : View
    //Return Type : View
    function JSvUsrloginList(nPage){
        var tUsrLogCode    =   $('#ohdUsrLogCode').val();
        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "userloginDataTable",
            data    : {
                tUsrLogCode         : tUsrLogCode,
                nPageCurrent        : nPage,
                tSearchAll          : ''
            },
            cache   : false,
            Timeout : 0,
            async   : false,
            success : function(tView){
                $('#odvContentUsrloginDataTable').html(tView);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Functionality : Call Credit Page Add  
    //Parameters : -
    //Creator : 10/06/2019 Witsarut(Bell)
    //Return : View
    //Return Type : View
    function JSvCallPageUserloginAdd(){
        var tUsrLogCode    =   $('#ohdUsrLogCode').val();

        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "userloginPageAdd",
            data    : {
                tUsrCode    :  tUsrLogCode
            },
            cache: false,
            timeout: 5000,
            success: function(tResult){
                $('#odvUsrloginData').html(tResult);
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
    function JSvCallPageUserloginEdit(ptUsrLogin){
        JCNxOpenLoading();
        var tUsrLogCode    =   $('#ohdUsrLogCode').val();
        $.ajax({
            type: "POST",
            url:  "userloginPageEdit",
            data:{
                tUsrLogCode :  tUsrLogCode,
                tUsrLogin   :   ptUsrLogin
            },
            cache:  false,
            timeout: 5000,
            success: function(tResult){
                $('#odvUsrloginData').html(tResult);
                $('.xWPageAdd').addClass('hidden');
                $('.xWPageEdit').removeClass('hidden');
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    }

    //Functionality : Add Data Agency Add/Edit  
    //Parameters : from ofmAddEditUserLogin
    //Creator : 04/07/2019 witsarut (Bell)
    //Return : View
    //Return Type : View
    function JSxUSRLSaveAddEdit(ptRoute){
        $('#ospChkTypePassword').hide();
        $('#ospChkTypePin').hide();
        var tChkDegit =  JSxCheckDegitPassword();
        if(tChkDegit == 1){
            return;
        }
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
           $('#ofmAddEditUserLogin').validate().destroy();
           $.validator.addMethod('dublicateCode', function(value, element) {
                if($("#ohdValidateDuplicate").val()==1){
                    if($("#ocmlogintype").val()==1 || $("#ocmlogintype").val()==2){
                        if($(element).attr("id")=="oetidUsrlogin"){
                            return false;
                        }else{
                            return true;
                        }
                    }else{
                        if($(element).attr("id")=="oetidUsrlogPw"){
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
            $('#ofmAddEditUserLogin').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetidUsrlogin  : {
                        "required" :{
                            depends: function (oElement) {
                                if($("#ohdTRoute").val()=="userloginEventAdd"){
                                    return true;
                                }else{
                                    return false;
                                }
                            }
                        },
                        "dublicateCode":{}
                    },
                    oetidUsrlogPw  : {
                        "required" :{
                            depends: function (oElement) {
                                if($("#ohdTRoute").val()=="userloginEventAdd"){
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
                    oetidUsrlogin : {
                        "required"      : $('#oetidUsrlogin').attr('data-validate-required'),
                        "dublicateCode" : "มีโค๊ดซ้ำกัน"
                    },
                    oetidUsrlogPw : {
                        "required"      : $('#oetidUsrlogPw').attr('data-validate-required'),
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
                    JCNxOpenLoading();

                    if($("#ocmlogintype").val()==3 || $("#ocmlogintype").val()==4){
                        $("#oetUsrloginPasswordOld").val(JCNtAES128EncryptData($("#oetidUsrlogin").val(),tKey,tIV));
                    }else{
                        $("#oetUsrloginPasswordOld").val(JCNtAES128EncryptData($("#oetidUsrlogPw").val(),tKey,tIV));
                    }
                    
                    let tUsrlogPw       =  $('#oetidUsrlogPw').val();
                    let tPasswordCheck  =  $('#oetUsrloginPasswordCheck').val();
                    let tPasswordOld    =  $('#oetUsrloginPasswordOld').val();
                    // ตรวจสอบค่าเดิม /16/03/2020 saharat
                    if(tUsrlogPw == tPasswordCheck){
                        $("#oetUsrloginPasswordOld").val(tPasswordCheck);
                    }

                    // Check Date
                    // Create By napat(jame) 08/06/2020
                    let dDateStart = new Date($('#oetUsrlogStart').val());
                    let dDateEnd   = new Date($('#oetUsrlogStop').val());
                    if(Date.parse(dDateStart) > Date.parse(dDateEnd)){
                        FSvCMNSetMsgErrorDialog('วันหมดอายุ ต้องมากกว่า วันที่เริ่มใช้งาน');
                        return false;
                    }

                
                // ------------ Create by Witsarut 31/08/2019 -------------

                    $.ajax({
                        type: "POST",
                        url: ptRoute,
                        data:  $('#ofmAddEditUserLogin').serialize(),
                        cache: false,
                        timeout: 0,
                        success: function(tResult) {
                            var aData = JSON.parse(tResult);
                            if(aData["nStaEvent"]==1){
                                JSxUsrloginGetContent();
                            }else{
                                FSvCMNSetMsgErrorDialog("ชื่อเข้าใช้งานซ้ำ");
                                // $("#ohdValidateDuplicate").val(1);
                                // JSxUSRLSaveAddEdit(ptRoute);
                                // $('#ofmAddEditUserLogin').submit();
                            }
                            JCNxCloseLoading();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                },
            });
        }
    }


    //Functionality: (event) Delete
    //Parameters: Button Event [tIDCode tUsrCode]
    //Creator: 10/05/2018 Witsarut (Bell)
    //Update: -
    //Return: Event Delete Reason List
    //Return Type: -
    function JSxUSRLDelete(ptUsrloginCode, tYesOnNo , ptTypeUsrLogin){
        $('#odvModalDeleteSingle').modal('show');
        $('#odvModalDeleteSingle #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptUsrloginCode + ' '+ tYesOnNo );
        $('#odvModalDeleteSingle #osmConfirmDelete').on('click', function(evt) {

            $.ajax({
                type:   "POST",
                url:    "userloginEventDelete",
                data: {
                    tUsrloginCode   : ptUsrloginCode,
                    tTypeUsrLogin   : ptTypeUsrLogin
                },
                cache: false,
                success: function(tResult){
                    $('#odvModalDeleteSingle').modal('hide');
                    setTimeout(function(){
                        JSvUsrloginList(1);
                    }, 500);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    }

    //Functionality : (event) Delete All
    //Creator : 11/06/2019 Witsarut (Bell)
    function JSxUSRLDeleteMutirecord(pnPage){

        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            var aDataUsrLogin   =[];
            var aDataUsrCode    =[];
            var aDataLogType    =[];
            var aDataPwStart    =[];
            var ocbListItem     = $(".ocbListItem");
            for(var nI = 0;nI<ocbListItem.length;nI++){
                if($($(".ocbListItem").eq(nI)).prop('checked')){
                    aDataUsrLogin.push($($(".ocbListItem").eq(nI)).attr("ohdUsrLogin"));
                    aDataUsrCode.push($($(".ocbListItem").eq(nI)).attr("ohdConfirmUsrCodeDelete"));
                    aDataLogType.push($($(".ocbListItem").eq(nI)).attr("ohdConfirmLogTypeDelete"));
                    aDataPwStart.push($($(".ocbListItem").eq(nI)).attr("ohdConfirmPwdStartDelete"));
                }
            }

            $.ajax({
                type: "POST",
                url: "userloginEventDeleteMultiple",
                data: {
                    'paDataUsrLogin'  : aDataUsrLogin,
                    'paDataUsrCode'   : aDataUsrCode,
                    'paDataLogType'   : aDataLogType,
                    'paDataPwStart'   : aDataPwStart,
                },
                cache: false,
                success: function (tResult){
                    tResult = tResult.trim();
                    var aReturn = $.parseJSON(tResult);
                    if(aReturn['nStaEvent'] == '1'){
                        $('#odvModalDeleteMutirecord').modal('hide');
                        $('#ospConfirmDelete').empty();
                        localStorage.removeItem('LocalItemData');

                        setTimeout(function(){
                            JSvUsrloginList(pnPage);
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
    //Creator: 05/07/2019 witsarut (Bell)
    function JSxUSRLShowButtonChoose() {
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

    //Functionality: Function Chack Value LocalStorage
    //Creator: 05/07/2019 witsarut (Bell)
    function findObjectByKey(array, key, value) {
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return 'Dupilcate';
            }
        }
        return 'None';
    }

    //Functionality: Insert Text In Modal Delete
    //Creator: 05/07/2019 witsarut (Bell)
    function JSxUSRLPaseCodeDelInModal() {
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
   
    //Functionality: เปลี่ยนหน้า pagenation
    //Creator: 09/05/2018 Witsarut
    function JSvUSRLClickPage(ptPage){
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xWBtnNext").addClass("disabled");
                nPageOld = $(".xWUSRLPaging .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
            break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xWUSRLPaging .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
            break;
            default:
            nPageCurrent = ptPage;
        }
        JSvUsrloginList(nPageCurrent);
    }

    // Functionality : Control Input User/Password From Login Type Selected
    // Creator: 19/08/2019 Witsarut
    function JSxUSRLCheckLoginTypeUsed(ptType){

        //  ดึงค่าตัวเลือกจากตัวเลือกประเภทการเข้าใช้งาน
        nLoginType = $('#ocmlogintype').val();

        /* กรณีเปลี่ยนประเภทการเข้าใช้งานรูปแบบการกรอกข้อมูล Username/Password จะเปลี่ยนไปดังนี้
        1 รหัสผ่าน ให้กรอก ชื่อผู้ใช้ และ รหัสผ่าน
        2 PIN ให้กรอกเบอร์โทรศัพท์ และ PIN
        3 RFID ให้กรอก RFID Code และทำการ Coppy ไปลงคอลัม รหัสผ่าน(Password)
        4 QR ให้กรอก QR Code และทำการ Coppy ไปลงคอลัม รหัสผ่าน(Password) 
        */

        //password ทั่วไป
        $('#oetidUsrlogPw').attr('maxlength',50);

        switch (nLoginType){
            case '1' :
                JSxUSRLControlInputTypePassword();
                // แสดง Input Password
                JSxUSRLControlPwsPanalShow();
            break;

            case '2' :
                JSxUSRLControlInputTypePIN();
                // แสดง Input Password
                JSxUSRLControlPwsPanalShow();

                //Pin คือใส่ได้แค่ 6 ตัว
                $('#oetidUsrlogPw').attr('maxlength',6);
            break;

            case '3' :
                
                JSxUSRLControlInputTypeRFID();
                // ซ่อน Input Password กรณีที่เลือกประเภท RFID
                JSxUSRLControlPwsPanalHide();
            break;

            case '4' :
                JSxUSRLControlInputTypeQRCODE();
                // ซ่อน Input Password กรณีที่เลือกประเภท RFID
                JSxUSRLControlPwsPanalHide();
            break;
            
            default:
                JSxUSRLControlInputTypePassword();
                // แสดง Input Password
                JSxUSRLControlPwsPanalShow();
        }

        // Reset ค่า User / Passwrod ทุกครั้งกรณีมีการเปลี่ยนประเภทการล็อกอิน
        if(ptType == 'insert'){
            JSxUSRLControlInputResetVal();
        }
    }

    // Create By : Witsarut
    // Functionality : Control Input User/Password Type Password
    // Parameters : -
    // Creator: 19/08/2019
    // Return : -
    // Return Type :
    function JSxUSRLControlInputTypePassword(){
        //เลือกประเภท Password
        //แสดง
        $('#olbUSRLLocinAcc').show(); // Label ชื่อผู้ใช้
        $('#olbUSRLPassword').show(); // Label รหัสผ่าน

        //Placeholder
        tHolderLocAcc = $('#olbUSRLLocinAcc').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidUsrlogin").attr("placeholder",tHolderLocAcc);

        tHolderLocPw = $('#olbUSRLPassword').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidUsrlogPw").attr("placeholder",tHolderLocPw);

        //Validate Input Account
        $('#oetidUsrlogin').removeClass('xCNInputNumericWithoutDecimal');

        //ซ่อน
        $('#olbUSRLTelNo').hide(); // Label เบอร์โทรศัพท์
        $('#olbUSRLRFID').hide();  // Label RFID
        $('#olbUSRLQRCode').hide();  // Label QR Code
        $('#olbUSRLPin').hide();   // Label PIN
    }


    // Create By : Witsarut
    // Functionality : Control Input User/Password Type Password
    // Parameters : -
    // Creator: 10/08/2019
    // Return : -
    // Return Type :
    function JSxUSRLControlInputTypePIN(){
        //เลือกประเภท PIN    
        //แสดง
        $('#olbUSRLTelNo').show(); // Label เบอร์โทรศัพท์
        $('#olbUSRLPin').show();   // Label PIN

        //Placeholder Input UsrLoginID
        tHolderLocAcc = $('#olbUSRLTelNo').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidUsrlogin").attr("placeholder",tHolderLocAcc);

        //Placeholder Input UsrLoginPassword
        tHolderLocPw = $('#olbUSRLPin').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidUsrlogPw").attr("placeholder",tHolderLocPw);

        //Validate Input Account
        $('#oetidUsrlogin').addClass('xCNInputNumericWithoutDecimal');

        //ซ่อน
        $('#olbUSRLLocinAcc').hide(); // Label ชื่อผู้ใช้
        $('#olbUSRLPassword').hide(); // Label รหัสผ่าน
        $('#olbUSRLRFID').hide();  // Label RFID
        $('#olbUSRLQRCode').hide();  // Label QR Code

    }

    // Create By : Witsarut
    // Functionality : Control Input User/Password Type RFID
    // Parameters : -
    // Creator: 10/08/2019
    // Return : -
    // Return Type : 
    function JSxUSRLControlInputTypeRFID(){
        //เลือกประเภท RFID    
        //แสดง
        $('#olbUSRLRFID').show();  // Label RFID
        
        //Placeholder Input UsrLoginID
        tHolderLocAcc = $('#olbUSRLRFID').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidUsrlogin").attr("placeholder",tHolderLocAcc);

        //Placeholder Input UsrLoginPassword
        tHolderLocPw = $('#olbUSRLRFID').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidUsrlogPw").attr("placeholder",tHolderLocPw);

        //Validate Input Account
        $('#oetidUsrlogin').removeClass('xCNInputNumericWithoutDecimal');

        //ซ่อน
        $('#olbUSRLLocinAcc').hide(); // Label ชื่อผู้ใช้
        $('#olbUSRLTelNo').hide(); // Label เบอร์โทรศัพท์
        $('#olbUSRLQRCode').hide();  // Label QR Code

    }


    // Create By : Witsarut
    // Functionality : Control Input User/Password Type QRCODE
    // Parameters : -
    // Creator: 10/08/2019
    // Return : -
    // Return Type : 
    function JSxUSRLControlInputTypeQRCODE(){
        //เลือกประเภท QRCODE  
        //แสดง
        $('#olbUSRLQRCode').show();  // Label RFID
        //Placeholder Input UsrLoginID
        tHolderLocAcc = $('#olbUSRLQRCode').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidUsrlogin").attr("placeholder",tHolderLocAcc);

        //Placeholder Input UsrLoginPassword
        tHolderLocPw = $('#olbUSRLQRCode').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidUsrlogPw").attr("placeholder",tHolderLocPw);


        //Validate Input Account
        $('#oetidUsrlogin').removeClass('xCNInputNumericWithoutDecimal');

        //ซ่อน
        $('#olbUSRLLocinAcc').hide(); // Label ชื่อผู้ใช้
        $('#olbUSRLTelNo').hide(); // Label เบอร์โทรศัพท์
        $('#olbUSRLRFID').hide();  // Label RFID
    }


    // Create By : Witsarut
    // Functionality : Reset Password Type Password
    // Parameters : -
    // Creator: 10/08/2019
    // Return : -
    // Return Type : 
    function JSxUSRLControlInputResetVal(){

        $('#oetidUsrlogin').val('');
        $('#oetidUsrlogPw').val('');
    }

    // Create By : Witsarut
    // Functionality : Hidden Password Panel
    // Parameters : -
    // Creator: 10/08/2019
    // Return : -
    // Return Type : 
    function JSxUSRLControlPwsPanalHide(){
        $('#odvUSRLPwsPanel').hide();  // Password Panel
    }

    // Functionality : Show Password Panel
    // Creator: 10/08/2019 Witsarut
    function JSxUSRLControlPwsPanalShow(){
        $('#odvUSRLPwsPanel').show(); 
    }

    $('#obtUsrlogStart').click(function(event){
        $('#oetUsrlogStart').datepicker('show');
    });

    $('#obtUsrlogStop').click(function(event){
        $('#oetUsrlogStop').datepicker('show');
    });

    $('#ocmlogintype').selectpicker();
    $('#ocmUsrlogStaUse').selectpicker();

</script>