<script type="text/javascript">
    $(document).ready(function () {
        JSvCrdloginList(1);

        var tloginType = $('#ocmlogintype').val();
        if(tloginType == 0){
            $('#oetCrdlogRemark').val('ไม่ตรวจสอบ');
        }
    });

  
    //function : Call PosAds Page list  
    //Parameters : Document Redy And Event Button
    //Creator :	25/11/2019 Witsarut (Bell)
    //Return : View
    //Return Type : View
    function JSvCrdloginList(nPage){
        var tCrdlogCode    =   $('#ohdCrdLogCode').val();
        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "cardloginDataTable",
            data    : {
                tCrdCode      : tCrdlogCode,
                nPageCurrent  : nPage,
                tSearchAll    : ''
            },
            cache   : false,
            Timeout : 0,
            async   : false,
            success : function(tView){
                $('#odvContentCardloginDataTable').html(tView);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Functionality : Call Credit Page Add  
    //Parameters : -
    //Creator : 25/11/2019 Witsarut(Bell)
    //Return : View
    //Return Type : View
    function JSvCallPageCardloginAdd(){
        var tCrdCode =  $('#ohdCrdLogCode').val();
        JCNxOpenLoading();

        $.ajax({
            type    : "POST",
            url     : "cardloginPageAdd",
            data  : {
                tCrdCode  : tCrdCode
            },
            cache: false,
            timeout: 5000,
            success: function(tResult){
                $('#odvCrdloginData').html(tResult);
                $('.xWPageAdd').removeClass('hidden');
                $('.xWPageEdit').addClass('hidden');
                $('#odvCRDLLoginID').hide();
                $('#odvCRDLPwsPanel').hide();
                $('#odvCRDFace').hide();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }


    //Functionality : Call Credit Page Edit  
    //Parameters : -
    //Creator : 26/11/2019 witsarut (Bell)
    //Return : View
    //Return Type : View
    function JSvCallPageCrdloginEdit(ptCrdLogin, ptCrdPwdStart){
        JCNxOpenLoading();
        var  tCrdCode   =   $('#ohdCrdLogCode').val();
        $.ajax({
            type : "POST",
            url: "cardloginPageEdit",
            data: {
                tCrdCode : tCrdCode,
                tCrdLogin : ptCrdLogin,
                tCrdPwdStart : ptCrdPwdStart
            },
            cache: false,
            timeout: 5000,
            success:  function(tResult){
                $('#odvCrdloginData').html(tResult);
                $('.xWPageAdd').hide();
                $('.xWPageEdit').show();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }


    //Functionality : Add Data Agency Add/Edit  
    //Parameters : from ofmAddEditCrdLogin
    //Creator : 04/07/2019 witsarut (Bell)
    //Return : View
    //Return Type : View
    function JSxCrdSaveAddEdit(ptRoute){
        $('#ospChkTypePassword').hide();
        $('#ospChkTypePin').hide();

        var tChkDegit =  JSxCheckDegitPassword();
        if(tChkDegit == 1){
            return;
        }
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#ofmAddEditCrdLogin').validate().destroy();
            $.validator.addMethod('dublicateCode', function(value, element) {
                if($("#ohdValidateDuplicate").val()==1){
                    if($("#ocmlogintype").val()==1 || $("#ocmlogintype").val()==2){
                        if($(element).attr("id")=="oetidCrdlogin"){
                            return false;
                        }else{
                            return true;
                        }
                    }else{
                        if($(element).attr("id")=="oetidCrdlogPw"){
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

            $('#ofmAddEditCrdLogin').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetidCrdlogin  : {
                        "required" :{
                            depends: function (oElement) {
                                if($("#ohdTRoute").val()=="cardloginEventAdd"){
                                    return true;
                                }else{
                                    return false;
                                }
                            }
                        },
                        "dublicateCode":{}
                    },
                    oetidCrdlogPw  : {
                        "required" :{
                            depends: function (oElement) {
                                if($("#ohdTRoute").val()=="cardloginEventAdd"){
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
                    oetidCrdlogin : {
                        "required"      : $('#oetidCrdlogin').attr('data-validate-required'),
                        "dublicateCode" : "มีโค๊ดซ้ำกัน"
                    },
                    oetidCrdlogPw : {
                        "required"      : $('#oetidCrdlogPw').attr('data-validate-required'),
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
                        $("#oetCrdloginPasswordOld").val(JCNtAES128EncryptData($("#oetidCrdlogin").val(),tKey,tIV));
                    }else{
                        $("#oetCrdloginPasswordOld").val(JCNtAES128EncryptData($("#oetidCrdlogPw").val(),tKey,tIV));
                    }

                    let tCrdlogPw       = $('#oetidCrdlogPw').val();
                    let tPasswordCheck  = $('#oetCrdloginPasswordCheck').val();
                    let tPasswordOld    = $('#oetCrdloginPasswordOld').val();
                    
                    // ตรวจสอบค่าเดิม /16/03/2020 saharat
                    if(tCrdlogPw == tPasswordCheck ){
                        $("#oetCrdloginPasswordOld").val(tPasswordCheck);
                    }

                    // Check Date
                    // Create By napat(jame) 08/06/2020
                    let dDateStart  = new Date($('#oetCrdlogStart').val());
                    let dDateEnd    = new Date($('#oetCrdlogStop').val());
                    if(Date.parse(dDateStart) > Date.parse(dDateEnd)){
                        FSvCMNSetMsgErrorDialog('วันหมดอายุ ต้องมากกว่า วันที่เริ่มใช้งาน');
                        return false;
                    }
                    $.ajax({
                        type: "POST",
                        url: ptRoute,
                        data:  $('#ofmAddEditCrdLogin').serialize(),
                        cache: false,
                        timeout: 0,
                        success: function(tResult) {
                            var aData = JSON.parse(tResult);
                            if(aData["nStaEvent"]==1){
                                JSxCrdloginGetContent();
                            }else{
                                FSvCMNSetMsgErrorDialog("ชื่อเข้าใช้งานซ้ำ");
                                // $("#ohdValidateDuplicate").val(1);
                                // JSxCrdSaveAddEdit(ptRoute);
                                // $('#ofmAddEditCrdLogin').submit();
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


    //Functionality: (event) Delete
    //Parameters: Button Event [tIDCode tCrdCode]
    //Creator: 26/11/2019 Witsarut (Bell)
    //Update: -
    //Return: Event Delete Reason List
    //Return Type: -
    function JSxCRDLDelete(ptCrdloginCode, ptCrdCode, ptPwdStart, tYesOnNo){
        $('#odvModalDeleteSingle').modal('show');
        $('#odvModalDeleteSingle #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptCrdloginCode + ' '+ tYesOnNo );
        $('#odvModalDeleteSingle #osmConfirmDelete').on('click', function(evt) {
            $.ajax({
                type: "POST",
                url: "cardloginEventDelete",
                data: {
                    tCrdloginCode : ptCrdloginCode,
                    tCrdCode : ptCrdCode,
                    tPwdStart : ptPwdStart
                },
                cache: false,
                success: function (tResult){
                    $('#odvModalDeleteSingle').modal('hide');
                    setTimeout(function(){
                        JSvCrdloginList(1);
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
    function JSxCRDLDeleteMutirecord(pnPage){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            var aDataCrdCode    =[];
            var aDataLogType    =[];
            var aDataPwStart    =[];
            var ocbListItem     = $(".ocbListItem");

            for(var nI = 0;nI<ocbListItem.length;nI++){
                if($($(".ocbListItem").eq(nI)).prop('checked')){
                    aDataCrdCode.push($($(".ocbListItem").eq(nI)).attr("ohdConfirmCrdCodeDelete"));
                    aDataLogType.push($($(".ocbListItem").eq(nI)).attr("ohdConfirmLogTypeDelete"));
                    aDataPwStart.push($($(".ocbListItem").eq(nI)).attr("ohdConfirmPwdStartDelete"));
                }
            }
            
            $.ajax({
                type: "POST",
                url:  "cardloginEventDeleteMultiple",
                data: {
                    'paDataCrdCode'   : aDataCrdCode,
                    'paDataLogType'   : aDataLogType,
                    'paDataPwStart'   : aDataPwStart,
                },
                cache: false,
                success: function(tResult){
                    tResult = tResult.trim();
                    var aReturn = $.parseJSON(tResult);
                    if(aReturn['nStaEvent'] == '1'){
                        $('#odvModalDeleteMutirecord').modal('hide');
                        $('#ospConfirmDelete').empty();
                        localStorage.removeItem('LocalItemData');
                        setTimeout(function(){
                            JSvCrdloginList(pnPage);
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
    //Creator: 11/26/2019 witsarut (Bell)
    //Return: - 
    //Return Type: -
    function JSxCRDLShowButtonChoose() {
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
    //Parameters: Event Select List Branch
    //Creator: 26/11/2019 witsarut (Bell)
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

    //Functionality: Insert Text In Modal Delete
    //Parameters: LocalStorage Data
    //Creator: 05/07/2019 witsarut (Bell)
    //Return: -
    //Return Type: -
    function JSxCRDLPaseCodeDelInModal() {
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
    //Parameters: -
    //Creator: 26/11/2019 Witsarut
    //Update: -
    //Return: View
    //Return Type: View
    function JSvCRDLClickPage(ptPage){
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xWBtnNext").addClass("disabled");
                nPageOld = $(".xWCRDLPaging .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
            break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xWCRDLPaging .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
            break;
            default:
            nPageCurrent = ptPage;
        }
        JSvCrdloginList(nPageCurrent);
    }



    // Create By : Witsarut
    // Functionality : Control Input User/Password From Login Type Selected
    // Parameters : -
    // Creator: 26/11/2019
    // Return : -
    // Return Type : -
    function JSxCRDLCheckLoginTypeUsed(ptType){

        //  ดึงค่าตัวเลือกจากตัวเลือกประเภทการเข้าใช้งาน
        nLoginType = $('#ocmlogintype').val();

        /* กรณีเปลี่ยนประเภทการเข้าใช้งานรูปแบบการกรอกข้อมูล Username/Password จะเปลี่ยนไปดังนี้
            1 รหัสผ่าน ให้กรอก ชื่อผู้ใช้ และ รหัสผ่าน
            2 PIN ให้กรอกเบอร์โทรศัพท์ และ PIN
            3 RFID ให้กรอก RFID Code และทำการ Coppy ไปลงคอลัม รหัสผ่าน(Password)
            4 QR ให้กรอก QR Code และทำการ Coppy ไปลงคอลัม รหัสผ่าน(Password) 
        */
       
        switch (nLoginType){
            case '0' :
                JSxCRDLControlInputTypeCard();
                JSxCRDLControlCrdPanalShow();
            break;
                  
            case '1' : 
                JSxCRDLControlInputTypePassword();
                // แสดง Input Password
                JSxCRDLControlPwsPanalShow();
            break;
            case '2' :
                JSxCRDLControlInputTypePIN();
                // แสดง Input Password
                JSxCRDLControlPwsPanalShow();
            break;
            case '3' :
                JSxCRDLControlInputTypeRFID();
                // ซ่อน Input Password กรณีที่เลือกประเภท RFID
                JSxCRDLControlPwsPanalHide();
            break;
            case '4' :
                JSxCRDLControlInputTypeQRCODE();
                // ซ่อน Input Password กรณีที่เลือกประเภท RFID
                JSxCRDLControlPwsPanalHide();
            break;
            case '5' :
                JSxCRDLControlInputTypeFace();
                JSxCRDLControlFacePanalShow();
            break;

            default:
                JSxCRDLControlInputTypeCard();
                JSxCRDLControlCrdPanalShow();
        }

        // Reset ค่า User / Passwrod ทุกครั้งกรณีมีการเปลี่ยนประเภทการล็อกอิน
        if(ptType == 'insert'){
            JSxCRDLControlInputResetVal();
        }

        if(ptType == 'edit'){
            JSxCRDLControlInputEdit();
        }

    }


    // Create By : Witsarut
    // Functionality : ถ้าเป็น Type 0 ให้ไป Disabled
    function JSxCRDLControlInputEdit(){
        var tChkloginType = $('#ocmlogintype').val();
        if(tChkloginType == 0){
            $('#ocmlogintype').attr("disabled", true); 
        }
    }

    // Create By : Witsarut
    // Functionality : Hidden Face Panel
    function JSxCRDLControlFacePanalShow(){
        $('#odvCRDFace').show();
        $('#odvCRDCardCode').hide();
        $('#odvCRDLPwsPanel').hide();
        $('#odvCRDLLoginID').hide();
    }

    // Create By : Witsarut
    // Functionality : Hidden Card Panel
    function JSxCRDLControlCrdPanalShow(){
        $('#odvCRDCardCode').show();
        $('#odvCRDLPwsPanel').hide();
        $('#odvCRDLLoginID').hide();
        $('#odvCRDFace').hide();
    }

    // Create By : Witsarut
    // Functionality : Hidden Password Panel
    function JSxCRDLControlPwsPanalHide(){
        $('#odvCRDLPwsPanel').hide();  // Password Panel
        $('#odvCRDCardCode').hide();
        $('#odvCRDLLoginID').show();
        $('#odvCRDFace').hide();
    }

    
    // Create By : Witsarut
    // Functionality : Show Password Panel
    function JSxCRDLControlPwsPanalShow(){
        $('#odvCRDLPwsPanel').show();  // Password Panel
        $('#odvCRDCardCode').hide();
        $('#odvCRDLLoginID').show();
        $('#odvCRDFace').hide();
    }

    // Create By : Witsarut
        // Functionality : Control Input  Type Face
    function JSxCRDLControlInputTypeFace(){
        $('#olbCRDLLocinFace').show();

        //ซ่อน
        $('#olbCRDLLocinAcc').hide(); // Label ชื่อผู้ใช้
        $('#olbCRDLPassword').hide(); // Label รหัสผ่าน
        $('#olbCRDLTelNo').hide(); // Label เบอร์โทรศัพท์
        $('#olbCRDLQRCode').hide();  // Label QR Code
        $('#olbCRDLRFID').hide();  // Label RFID
    }


    // Create By : Witsarut
    // Functionality : Control Input Type Card
    function JSxCRDLControlInputTypeCard(){
        $('#olbCRDLLocinCardCode').show();


        //ซ่อน
        $('#olbCRDLLocinAcc').hide(); // Label ชื่อผู้ใช้
        $('#olbCRDLPassword').hide(); // Label รหัสผ่าน
        $('#olbCRDLTelNo').hide(); // Label เบอร์โทรศัพท์
        $('#olbCRDLQRCode').hide();  // Label QR Code
        $('#olbCRDLRFID').hide();  // Label RFID
    }

    // Create By : Witsarut
    // Functionality : Control Input User/Password Type Password
    // Parameters : -
    // Creator: 26/11/2019
    // Return : -
    // Return Type :
    function JSxCRDLControlInputTypePassword(){
        //เลือกประเภท Password
        //แสดง
        $('#olbCRDLLocinAcc').show(); // Label ชื่อผู้ใช้
        $('#olbCRDLPassword').show(); // Label รหัสผ่าน

        //Placeholder
        tHolderLocAcc = $('#olbCRDLLocinAcc').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidCrdlogin").attr("placeholder",tHolderLocAcc);

        tHolderLocPw = $('#olbCRDLPassword').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidCrdlogPw").attr("placeholder",tHolderLocPw);

        //Validate Input Account
        $('#oetidCrdlogin').removeClass('xCNInputNumericWithoutDecimal');

        //ซ่อน
        $('#olbCRDLTelNo').hide(); // Label เบอร์โทรศัพท์
        $('#olbCRDLRFID').hide();  // Label RFID
        $('#olbCRDLQRCode').hide(); // Label QR Code
        $('#olbCRDLPin').hide();   // Label PIN
        $('#olbCRDLLocinCardCode').hide();  
    }

    // Create By : Witsarut
    // Functionality : Control Input User/Password Type Password
    // Parameters : -
    // Creator: 26/08/2019
    // Return : -
    // Return Type :
    function JSxCRDLControlInputTypePIN(){
     
        $('#olbCRDLTelNo').show(); // Label เบอร์โทรศัพท์
        $('#olbCRDLPin').show();   // Label PIN

         //Placeholder Input UsrLoginID
        tHolderLocAcc = $('#olbCRDLTelNo').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidCrdlogin").attr("placeholder",tHolderLocAcc);

        //Placeholder Input UsrLoginPassword
        tHolderLocPw = $('#olbCRDLPin').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidCrdlogPw").attr("placeholder",tHolderLocPw);

        //Validate Input Account
        $('#oetidCrdlogin').addClass('xCNInputNumericWithoutDecimal');

        //ซ่อน
        $('#olbCRDLLocinAcc').hide(); // Label ชื่อผู้ใช้
        $('#olbCRDLPassword').hide(); // Label รหัสผ่าน
        $('#olbCRDLRFID').hide();  // Label RFID
        $('#olbCRDLQRCode').hide();  // Label QR Code
        $('#olbCRDLLocinCardCode').hide();  
    }


    // Create By : Witsarut
    // Functionality : Control Input User/Password Type RFID
    // Parameters : -
    // Creator: 26/11/2019
    // Return : -
    // Return Type : 
    function JSxCRDLControlInputTypeRFID(){
        //เลือกประเภท RFID    
        //แสดง
        $('#olbCRDLRFID').show();  // Label RFID

        //Placeholder Input UsrLoginID
        tHolderLocAcc = $('#olbCRDLRFID').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidCrdlogin").attr("placeholder",tHolderLocAcc);

        //Placeholder Input UsrLoginPassword
        tHolderLocPw = $('#olbCRDLRFID').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidCrdlogPw").attr("placeholder",tHolderLocPw);

        //Validate Input Account
        $('#oetidCrdlogin').removeClass('xCNInputNumericWithoutDecimal');

        //ซ่อน
        $('#olbCRDLLocinAcc').hide(); // Label ชื่อผู้ใช้
        $('#olbCRDLTelNo').hide(); // Label เบอร์โทรศัพท์
        $('#olbCRDLQRCode').hide();  // Label QR Code
        $('#olbCRDLLocinCardCode').hide();  
    }


    // Create By : Witsarut
    // Functionality : Control Input User/Password Type QRCODE
    // Parameters : -
    // Creator: 26/11/2019
    // Return : -
    // Return Type : 
    function JSxCRDLControlInputTypeQRCODE(){
     
        $('#olbCRDLQRCode').show();  // Label RFID

        //Placeholder Input UsrLoginID
        tHolderLocAcc = $('#olbCRDLQRCode').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidCrdlogin").attr("placeholder",tHolderLocAcc);

        //Placeholder Input UsrLoginPassword
        tHolderLocPw = $('#olbCRDLQRCode').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidCrdlogPw").attr("placeholder",tHolderLocPw);

        //Validate Input Account
        $('#oetidCrdlogin').removeClass('xCNInputNumericWithoutDecimal');

        //ซ่อน
        $('#olbCRDLLocinAcc').hide(); // Label ชื่อผู้ใช้
        $('#olbCRDLTelNo').hide(); // Label เบอร์โทรศัพท์
        $('#olbCRDLRFID').hide();  // Label RFID
        $('#olbCRDLLocinCardCode').hide();  
    }

    // Create By : Witsarut
    // Functionality : Reset Password Type Password
    // Parameters : -
    // Creator: 26/11/2019
    // Return : -
    // Return Type : 
    function JSxCRDLControlInputResetVal(){
        var tChkloginType = $('#ocmlogintype').val();
        $('#oetidCrdlogPw').val('');
        $('#oetidCrdlogin').val('');
        if(tChkloginType == 0){
            $('#oetCrdlogRemark').val('ไม่ตรวจสอบ');
        }else{
            $('#oetCrdlogRemark').val('');
        }
    }

    $('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });

    $('#obtCrdlogStart').click(function(event){
        $('#oetCrdlogStart').datepicker('show');
    });

    $('#obtCrdlogStop').click(function(event){
        $('#oetCrdlogStop').datepicker('show');
    });

    $('#ocmlogintype').selectpicker();

    $('#ocmCrdlogStaUse').selectpicker();




</script>