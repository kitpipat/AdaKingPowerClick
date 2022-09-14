<script type="text/javascript">
    
    $(document).ready(function () {
        JSvCstloginList(1);
        var tloginType = $('#ocmlogintype').val();
        if(tloginType == 0){
            $('#oetCstlogRemark').val('ไม่ตรวจสอบ');
        }
    });


    //function : Call Cstlogin Page list  
    //Parameters : Document Redy And Event Button
    //Creator :	15/09/2020 Witsarut (Bell)
    //Return : View
    //Return Type : View
    function JSvCstloginList(nPage){
        var tCstlogCode    =   $('#ohdCstLogCode').val();

        $.ajax({
            type    : "POST",
            url     : "customerloginDataTable",
            data    :  {
                tCstlogCode     : tCstlogCode,
                nPageCurrent    : nPage,
                tSearchAll      : '' 
            },
            cache   : false,
            Timeout : 0,
            async   : false,
            success : function(tView){
                $('#odvContentCstloginDataTable').html(tView);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }

        });
    }


    //Functionality : Call Cstlogin Page Add  
    //Parameters : -
    //Creator : 25/11/2019 Witsarut(Bell)
    //Return : View
    //Return Type : View
    function JSvCallPageCstloginAdd(){
        var tCstlogCode    =   $('#ohdCstLogCode').val();
        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "customerloginPageAdd",
            data  : {
                tCstlogCode  : tCstlogCode
            },
            cache: false,
            timeout: 5000,
            success: function(tResult){
                $('#odvTabCstlogin').html(tResult);
                $('.xWPageAdd').removeClass('hidden');
                $('.xWPageEdit').addClass('hidden');
                $('#odvCSTLLoginID').hide();
                $('#odvCSTLPwsPanel').hide();
                $('#odvCSTFace').hide();
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
    function JSvCallPageCstloginEdit(ptCstLogin, ptCstPwdStart){
        JCNxOpenLoading();
        var  tCstlogCode   =   $('#ohdCstLogCode').val();
        $.ajax({
            type : "POST",
            url: "customerloginPageEdit",
            data: {
                tCstlogCode     : tCstlogCode,
                tCstLogin       : ptCstLogin,
                tCstPwdStart    : ptCstPwdStart
            },
            cache: false,
            timeout: 5000,
            success:  function(tResult){
                $('#odvTabCstlogin').html(tResult);
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
    //Parameters : from ofmAddEditCstLogin
    //Creator : 04/07/2019 witsarut (Bell)
    //Return : View
    //Return Type : View
    function JSxCstSaveAddEdit(ptRoute){
        $('#ospChkTypePassword').hide();
        $('#ospChkTypePin').hide();

        var tChkDegit =  JSxCheckDegitPassword();
        if(tChkDegit == 1){
            return;
        }

        var nStaSession = JCNxFuncChkSessionExpired();

        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#ofmAddEditCstLogin').validate().destroy();
            $.validator.addMethod('dublicateCode', function(value, element) {
                if($("#ohdValidateDuplicate").val()==1){
                    if($("#ocmlogintype").val()==1 || $("#ocmlogintype").val()==2){
                        if($(element).attr("id")=="oetidCstlogin"){
                            return false;
                        }else{
                            return true;
                        }
                    }else{
                        if($(element).attr("id")=="oetidCstlogPw"){
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

            $('#ofmAddEditCstLogin').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetidCstlogin  : {
                        "required" :{
                            depends: function (oElement) {
                                if($("#ohdTRoute").val()=="customerEventAdd"){
                                    return true;
                                }else{
                                    return false;
                                }
                            }
                        },
                        "dublicateCode":{}
                    },
                    oetidCstlogPw  : {
                        "required" :{
                            depends: function (oElement) {
                                if($("#ohdTRoute").val()=="customerEventAdd"){
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
                    oetidCstlogin : {
                        "required"      : $('#oetidCstlogin').attr('data-validate-required'),
                        "dublicateCode" : "มีโค๊ดซ้ำกัน"
                    },
                    oetidCstlogPw : {
                        "required"      : $('#oetidCstlogPw').attr('data-validate-required'),
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
                        $("#oetCstloginPasswordOld").val(JCNtAES128EncryptData($("#oetidCstlogin").val(),tKey,tIV));
                    }else{
                        $("#oetCstloginPasswordOld").val(JCNtAES128EncryptData($("#oetidCstlogPw").val(),tKey,tIV));
                    }

                    let tCstlogPw       = $('#oetidCstlogPw').val();
                    let tPasswordCheck  = $('#oetCstloginPasswordCheck').val();
                    let tPasswordOld    = $('#oetCstloginPasswordOld').val();

                    // ตรวจสอบค่าเดิม /16/03/2020 saharat
                    if(tCstlogPw == tPasswordCheck ){
                        $("#oetCstloginPasswordOld").val(tPasswordCheck);
                    }

                    // Check Date
                    // Create By napat(jame) 08/06/2020
                    let dDateStart  = new Date($('#oetCstlogStart').val());
                    let dDateEnd    = new Date($('#oetCstlogStop').val());
                    if(Date.parse(dDateStart) > Date.parse(dDateEnd)){
                        FSvCMNSetMsgErrorDialog('วันหมดอายุ ต้องมากกว่า วันที่เริ่มใช้งาน');
                        return false;
                    }
                    $.ajax({
                        type: "POST",
                        url: ptRoute,
                        data:  $('#ofmAddEditCstLogin').serialize(),
                        cache: false,
                        timeout: 0,
                        success: function(tResult) {
                            var aData = JSON.parse(tResult);
                            if(aData["nStaEvent"]==1){
                                JSxCstloginGetContent();
                            }else{
                                FSvCMNSetMsgErrorDialog("ชื่อเข้าใช้งานซ้ำ");
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
    function JSxCSTLDelete(ptCstloginCode, ptCstCode, ptPwdStart, tYesOnNo){
        $('#odvModalCstloginDeleteSingle').modal('show');
        $('#odvModalCstloginDeleteSingle #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptCstloginCode + ' '+ tYesOnNo );
        $('#odvModalCstloginDeleteSingle #osmConfirmDelete').on('click', function(evt) {
            $.ajax({
                type: "POST",
                url: "customerloginEventDelete",
                data: {
                    tCstloginCode : ptCstloginCode,
                    tCstCode : ptCstCode,
                    tPwdStart : ptPwdStart
                },
                cache: false,
                success: function (tResult){
                    $('#odvModalCstloginDeleteSingle').modal('hide');
                    setTimeout(function(){
                        JSvCstloginList(1);
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
    function JSxCSTLDeleteMutirecord(pnPage){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            var aDataCstCode    =[];
            var aDataLogType    =[];
            var aDataPwStart    =[];
            var ocbListItem     = $(".ocbListItem");

            for(var nI = 0;nI<ocbListItem.length;nI++){
                if($($(".ocbListItem").eq(nI)).prop('checked')){
                    aDataCstCode.push($($(".ocbListItem").eq(nI)).attr("ohdConfirmCstCodeDelete"));
                    aDataLogType.push($($(".ocbListItem").eq(nI)).attr("ohdConfirmLogTypeDelete"));
                    aDataPwStart.push($($(".ocbListItem").eq(nI)).attr("ohdConfirmPwdStartDelete"));
                }
            }
            
            $.ajax({
                type: "POST",
                url:  "customerloginEventDeleteMultiple",
                data: {
                    'paDataCstCode'   : aDataCstCode,
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
                            JSvCstloginList(pnPage);
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
    function JSxCSTLShowButtonChoose() {
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
    function JSxCSTLPaseCodeDelInModal() {
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
    function JSvCSTLClickPage(ptPage){
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xWBtnNext").addClass("disabled");
                nPageOld = $(".xWCSTLPaging .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
            break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xWCSTLPaging .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
            break;
            default:
            nPageCurrent = ptPage;
        }
        JSvCstloginList(nPageCurrent);
    }

    // Create By : Witsarut
    // Functionality : Control Input User/Password From Login Type Selected
    // Parameters : -
    // Creator: 26/11/2019
    // Return : -
    // Return Type : -
    function JSxCSTLCheckLoginTypeUsed(ptType){

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
                JSxCSTLControlInputTypeCard();
                JSxCSTLControlCstPanalShow();
            break;
                
            case '1' : 
                JSxCSTLControlInputTypePassword();
                // แสดง Input Password
                JSxCSTLControlPwsPanalShow();
            break;
            case '2' :
                JSxCSTLControlInputTypePIN();
                // แสดง Input Password
                JSxCSTLControlPwsPanalShow();
            break;
            case '3' :
                JSxCSTLControlInputTypeRFID();
                // ซ่อน Input Password กรณีที่เลือกประเภท RFID
                JSxCSTLControlPwsPanalHide();
            break;
            case '4' :
                JSxCSTLControlInputTypeQRCODE();
                // ซ่อน Input Password กรณีที่เลือกประเภท RFID
                JSxCSTLControlPwsPanalHide();
            break;
            case '5' :
                JSxCSTLControlInputTypeFace();
                JSxCSTLControlFacePanalShow();
            break;

            default:
                JSxCSTLControlInputTypeCard();
                JSxCSTLControlCstPanalShow();
        }

        // Reset ค่า User / Passwrod ทุกครั้งกรณีมีการเปลี่ยนประเภทการล็อกอิน
        if(ptType == 'insert'){
            JSxCSTLControlInputResetVal();
        }

        if(ptType == 'edit'){
            JSxCSTLControlInputEdit();
        }
    }

    // Create By : Witsarut
    // Functionality : ถ้าเป็น Type 0 ให้ไป Disabled
    function JSxCSTLControlInputEdit(){
        var tChkloginType = $('#ocmlogintype').val();
        if(tChkloginType == 0){
            $('#ocmlogintype').attr("disabled", true); 
        }
    }

     // Create By : Witsarut
    // Functionality : Hidden Face Panel
    function JSxCSTLControlFacePanalShow(){
        $('#odvCSTFace').show();
        $('#odvCSTCardCode').hide();
        $('#odvCSTLPwsPanel').hide();
        $('#odvCSTLLoginID').hide();
    }

    // Create By : Witsarut
    // Functionality : Hidden Card Panel
    function JSxCSTLControlCstPanalShow(){
        $('#odvCSTCardCode').show();
        $('#odvCSTLPwsPanel').hide();
        $('#odvCSTLLoginID').hide();
        $('#odvCSTFace').hide();
    }

    // Create By : Witsarut
    // Functionality : Hidden Password Panel
    function JSxCSTLControlPwsPanalHide(){
        $('#odvCSTLPwsPanel').hide();  // Password Panel
        $('#odvCSTCardCode').hide();
        $('#odvCSTLLoginID').show();
        $('#odvCSTFace').hide();
    }

    // Create By : Witsarut
    // Functionality : Show Password Panel
    function JSxCSTLControlPwsPanalShow(){
        $('#odvCSTLPwsPanel').show();  // Password Panel
        $('#odvCSTCardCode').hide();
        $('#odvCSTLLoginID').show();
        $('#odvCSTFace').hide();
    }

    // Create By : Witsarut
    // Functionality : Control Input  Type Face
    function JSxCSTLControlInputTypeFace(){
        $('#olbCSTLLocinFace').show();

        //ซ่อน
        $('#olbCSTLLocinAcc').hide(); // Label ชื่อผู้ใช้
        $('#olbCSTLPassword').hide(); // Label รหัสผ่าน
        $('#olbCSTLTelNo').hide(); // Label เบอร์โทรศัพท์
        $('#olbCSTLQRCode').hide();  // Label QR Code
        $('#olbCSTLRFID').hide();  // Label RFID
    }

    // Create By : Witsarut
    // Functionality : Control Input Type Card
    function JSxCSTLControlInputTypeCard(){
        $('#olbCSTLLocinCardCode').show();


        //ซ่อน
        $('#olbCSTLLocinAcc').hide(); // Label ชื่อผู้ใช้
        $('#olbCSTLPassword').hide(); // Label รหัสผ่าน
        $('#olbCSTLTelNo').hide(); // Label เบอร์โทรศัพท์
        $('#olbCSTLQRCode').hide();  // Label QR Code
        $('#olbCSTLRFID').hide();  // Label RFID
    }

     // Create By : Witsarut
    // Functionality : Control Input User/Password Type Password
    // Parameters : -
    // Creator: 26/11/2019
    // Return : -
    // Return Type :
    function JSxCSTLControlInputTypePassword(){
        //เลือกประเภท Password
        //แสดง
        $('#olbCSTLLocinAcc').show(); // Label ชื่อผู้ใช้
        $('#olbCSTLPassword').show(); // Label รหัสผ่าน

        //Placeholder
        tHolderLocAcc = $('#olbCSTLLocinAcc').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidCstlogin").attr("placeholder",tHolderLocAcc);

        tHolderLocPw = $('#olbCSTLPassword').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidCstlogPw").attr("placeholder",tHolderLocPw);

        //Validate Input Account
        $('#oetidCstlogin').removeClass('xCNInputNumericWithoutDecimal');

        //ซ่อน
        $('#olbCSTLTelNo').hide(); // Label เบอร์โทรศัพท์
        $('#olbCSTLRFID').hide();  // Label RFID
        $('#olbCSTLQRCode').hide(); // Label QR Code
        $('#olbCSTLPin').hide();   // Label PIN
        $('#olbCSTLLocinCardCode').hide();  
    }


      // Create By : Witsarut
    // Functionality : Control Input User/Password Type Password
    // Parameters : -
    // Creator: 26/08/2019
    // Return : -
    // Return Type :
    function JSxCSTLControlInputTypePIN(){
        $('#olbCSTLTelNo').show(); // Label เบอร์โทรศัพท์
        $('#olbCSTLPin').show();   // Label PIN

        //Placeholder Input UsrLoginID
        tHolderLocAcc = $('#olbCSTLTelNo').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidCstlogin").attr("placeholder",tHolderLocAcc);

        //Placeholder Input UsrLoginPassword
        tHolderLocPw = $('#olbCSTLPin').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidCstlogPw").attr("placeholder",tHolderLocPw);

        //Validate Input Account
        $('#oetidCstlogin').addClass('xCNInputNumericWithoutDecimal');

        //ซ่อน
        $('#olbCSTLLocinAcc').hide(); // Label ชื่อผู้ใช้
        $('#olbCSTLPassword').hide(); // Label รหัสผ่าน
        $('#olbCSTLRFID').hide();  // Label RFID
        $('#olbCSTLQRCode').hide();  // Label QR Code
        $('#olbCSTLLocinCardCode').hide();  
    }


    // Create By : Witsarut
    // Functionality : Control Input User/Password Type RFID
    // Parameters : -
    // Creator: 26/11/2019
    // Return : -
    // Return Type : 
    function JSxCSTLControlInputTypeRFID(){
        //เลือกประเภท RFID    
        //แสดง
        $('#olbCSTLRFID').show();  // Label RFID

        //Placeholder Input UsrLoginID
        tHolderLocAcc = $('#olbCSTLRFID').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidCstlogin").attr("placeholder",tHolderLocAcc);

        //Placeholder Input UsrLoginPassword
        tHolderLocPw = $('#olbCSTLRFID').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidCstlogPw").attr("placeholder",tHolderLocPw);

        //Validate Input Account
        $('#oetidCstlogin').removeClass('xCNInputNumericWithoutDecimal');

        //ซ่อน
        $('#olbCSTLLocinAcc').hide(); // Label ชื่อผู้ใช้
        $('#olbCSTLTelNo').hide(); // Label เบอร์โทรศัพท์
        $('#olbCSTLQRCode').hide();  // Label QR Code
        $('#olbCSTLLocinCardCode').hide();  
    }


      // Create By : Witsarut
    // Functionality : Control Input User/Password Type QRCODE
    // Parameters : -
    // Creator: 26/11/2019
    // Return : -
    // Return Type : 
    function JSxCSTLControlInputTypeQRCODE(){
        $('#olbCSTLQRCode').show();  // Label RFID

        //Placeholder Input UsrLoginID
        tHolderLocAcc = $('#olbCSTLQRCode').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidCstlogin").attr("placeholder",tHolderLocAcc);

        //Placeholder Input UsrLoginPassword
        tHolderLocPw = $('#olbCSTLQRCode').first().contents().eq(2).text().trim(); //ดึงค่าจาก Label เพื่อไปเติมใน Input
        $("#oetidCstlogPw").attr("placeholder",tHolderLocPw);

        //Validate Input Account
        $('#oetidCstlogin').removeClass('xCNInputNumericWithoutDecimal');

        //ซ่อน
        $('#olbCSTLLocinAcc').hide(); // Label ชื่อผู้ใช้
        $('#olbCSTLTelNo').hide(); // Label เบอร์โทรศัพท์
        $('#olbCSTLRFID').hide();  // Label RFID
        $('#olbCSTLLocinCardCode').hide();  
    }


    // Create By : Witsarut
    // Functionality : Reset Password Type Password
    // Parameters : -
    // Creator: 26/11/2019
    // Return : -
    // Return Type : 
    function JSxCSTLControlInputResetVal(){
        var tChkloginType = $('#ocmlogintype').val();
        $('#oetidCstlogPw').val('');
        $('#oetidCstlogin').val('');
        if(tChkloginType == 0){
            $('#oetCstlogRemark').val('ไม่ตรวจสอบ');
        }else{
            $('#oetCstlogRemark').val('');
        }
    }


    $('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });

    $('#obtCstlogStart').click(function(event){
        $('#obtCstlogStart').datepicker('show');
    });

    $('#obtCstlogStop').click(function(event){
        $('#obtCstlogStop').datepicker('show');
    });

    $('#ocmlogintype').selectpicker();

    $('#ocmCstlogStaUse').selectpicker();

</script>