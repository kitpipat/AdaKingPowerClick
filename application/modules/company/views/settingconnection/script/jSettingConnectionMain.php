<script type="text/javascript">

    $('#oetBchServerip').on('keypress',function(){
        // $('#ohdValidateDuplicate').val()
        $('#ohdValidateDuplicate').val('0');
    });

    $(document).ready(function () {
        JSvBchSetConnectionList(1);
        switch ($("#ocmUrlConnecttype").val()){
            case '1' :
                // ซ่อน Panel 1,2,3,4,5
                JSxBchSettingConControlPanalHide();
            break;
            case '2' : 
                JSxBchSettingConControlPanalShow();
            break;
            case '3' :
                JSxBchSettingConControlPanalShowMQ();
            break;
            case '4' :
                JSxBchSettingConControlPanalHide();
            break;
            case '5' :
                JSxBchSettingConControlPanalHide();
            break;
            case '6' :
                JSxBchSettingConControlPanalHide();
            break;
            case '7' : 
                JSxBchSettingConControlPanalHide();
            break;
            case '8' :
                JSxBchSettingConControlPanalHide();
            break;
            case '12' :
            // ซ่อน Panel 1,2,3,4,5
                JSxBchSettingConControlPanalHide();
            break;
            case '13' :
                 // ซ่อน Panel 1,3,4,5
                JSxBchSettingConControlPanalShowMQMember();
            break;
            case '16' : 
                JSxBchSettingConControlPanalShow();
            break;
            
            default:
                // Default ซ่อน Panel 1,2,3,4,5
                JSxBchSettingConControlPanalHide();
        }
    });


    //function : Call PosAds Page list  
    //Parameters : Document Redy And Event Button
    //Creator :	19/08/2019 Witsarut (Bell)
    //Return : View
    //Return Type : View
    function JSvBchSetConnectionList(nPage){
        var ptBchCode  = $('#ohdBchCode').val();
        var tSearchAll = $('#oetSearchAll').val();
        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "BchSettingConDataTable",
            data    : {
                tBchCode    : ptBchCode,
                tSearchAll  : tSearchAll,
                nPageCurrent  : nPage
            },
            cache : false,
            timeout  : 0,
            success  : function (tResult){
                $('#odvContentBchSetConnectionDataTable').html(tResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }


    //Functionality : Call BchSettingConnection Page Add  
    //Parameters : -
    //Creator : 11/09/2019 Witsarut(Bell)
    //Return : View
    //Return Type : View
    function JSvCallPageBchSetConnectionAdd(){
        var ptBchCode = $('#ohdBchCode').val();

        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "BchSettingConPageAdd",
            data    : {
                tBchCode   :  ptBchCode
            },
            cache: false,
            timeout: 5000,
            success: function(tResult){
                $('#odvInforSettingConTab').html(tResult);
                $('#odvlevType').hide();
                JSxBchSettingConControlPanalHide();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Functionality : Call Credit Page Edit  
    //Parameters : -
    //Creator : 12/09/2019 witsarut (Bell)
    //Return : View
    //Return Type : View
    function JSvCallPageBchSettingConnectEdit(ptUrlID){
        
        JCNxOpenLoading();
        var ptBchCode = $('#ohdBchCode').val();

        $.ajax({
            type : "POST",
            url  : "BchSettingConPageEdit",
            data: {
                tBchCode : ptBchCode,
                tUrlID   : ptUrlID
            },
            cache: false,
            timeout: 5000,
            success: function(tResult){
                $('#odvInforSettingConTab').html(tResult);
                $('#odvlevType').hide();
                // $('.xWPageAdd').removeClass('hidden');
                // $('.xWPageEdit').addClass('hidden');
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }


    //Functionality: (event) Delete
    //Parameters: Button Event [tIDCode tUsrCode]
    //Creator: 12/09/2019 Witsarut (Bell)
    //Update: -
    //Return: Event Delete Reason List
    //Return Type: -
    function JSxBchSettingConnectDelete(ptUrlType,ptUrlAddress,ptUrlID,tYesOnNo){
        $('#odvModalDeleteSingle').modal('show');
        $('#odvModalDeleteSingle #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptUrlID + ' (' + ptUrlAddress  + ') ' + tYesOnNo );
        $('#odvModalDeleteSingle #osmConfirmDelete').on('click', function(evt) {
            $.ajax({
                type: "POST",
                url:  "BchSettingConEventDelete",
                data: {
                    tUrlAddress : ptUrlAddress,
                    tUrlID      : ptUrlID,
                    tUrlType    : ptUrlType,
                    tBchCode    : $('#oetBchCode').val()
                },
                cache: false,
                success: function(tResult){
                    $('#odvModalDeleteSingle').modal('hide');
                    setTimeout(function(){
                        JSvBchSetConnectionList(1);
                    },500);
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
    function  JSxBchSettingConDeleteMutirecord(pnPage,ptUrlType,ptUrlAddress,ptUrlID){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JCNxOpenLoading();
                var aDataUrlId =  $('#ohdConfirmIDDeleteMutirecordUrlId').val();
                var aDataUrlAddress =  $('#ohdConfirmIDDeleteMutirecordAddress').val();
                var aUrlId = aDataUrlId.substring(0, aDataUrlId.length - 2);
                var aAddress  = aDataUrlAddress.substring(0, aDataUrlAddress.length - 2);
                var aDataSplitUrlId    = aUrlId.split(" , ");
                var aDataSplitAddr     = aAddress.split(" , ");
                var aDataSplitlength   = aDataSplitAddr.length;
                var aNewUrlIdDelete  = [];
                var aNewAddrDelete   = [];
                for ($i = 0; $i < aDataSplitlength; $i++) {
                    aNewUrlIdDelete.push(aDataSplitUrlId[$i]);
                    aNewAddrDelete.push(aDataSplitAddr[$i]);
                }
                if(aDataSplitlength > 1){
                    localStorage.StaDeleteArray = '1';
                    $.ajax({
                        type: "POST",
                        url: "BchSettingConEventDeleteMultiple",
                        data : {
                            'tUrlID'   : aNewUrlIdDelete,
                            'tAddress' : aNewAddrDelete
                        },
                        success: function(aReturn){
                            aReturn = aReturn.trim();
                            var aReturn = $.parseJSON(aReturn);
                            if(aReturn['nStaEvent'] == '1'){
                                $('#odvModalDeleteMutirecord').modal('hide');
                                $('#odvModalDeleteMutirecord #ospConfirmDelete').text($('#ohdConfirmIDDeleteMutirecord').val());
                                $('#ohdConfirmIDDeleteMutirecordUrlId').val('');
                                $('#ohdConfirmIDDeleteMutirecordAddress').val('');
                                localStorage.removeItem('LocalItemDataAds');
                                $('.modal-backdrop').remove();
                                setTimeout(function() {
                                    JSvBchSetConnectionList(1)
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
                }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }    


    //Functionality : Add Data BchSettingConnection Add/Edit  
    //Parameters : from ofmAddEditBchSettingConnect
    //Creator : 12/09/2019 witsarut (Bell)
    //Return : View
    //Return Type : View
    function JSxBchSettingConnectSaveAddEdit(ptRoute){

        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#ofmAddEditBchSettingConnect').validate().destroy();
            $.validator.addMethod('dublicateCode', function(value, element) {
                if($("#ohdValidateDuplicate").val()==1){
                    if($("#ocmUrlConnecttype").val()==1 || $("#ocmUrlConnecttype").val()==2 || $("#ocmUrlConnecttype").val()==3 || $("#ocmUrlConnecttype").val()==4 || $("#ocmUrlConnecttype").val()==5 || $("#ocmUrlConnecttype").val()==6 || $("#ocmUrlConnecttype").val()==7 || $("#ocmUrlConnecttype").val()==8 || $("#ocmUrlConnecttype").val()==12 || $("#ocmUrlConnecttype").val()==13){
                        if($(element).attr("id")=="oetBchServerip"){
                            return false;
                        }else{
                            return true;
                        }
                    }
                }else{
                    return true;
                }
            });
            $('#ofmAddEditBchSettingConnect').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetBchServerip  : {
                        "required" :{
                            depends: function (oElement) {
                                if($("#ohdTRoute").val()=="BchSettingConEventAdd"){
                                    return true;
                                }else{
                                    return false;
                                }
                            }
                        }, 
                        "dublicateCode":{}
                    },
                    oetBchUsrAccount : { "required": {} },
                    oetBchPassword : { "required": {} },

                    // MQMain
                    oetBchMQMainUsrAccount : { "required": {} },
                    oetBchMQMainPassword   : { "required": {} },
                    
                    //MQDoc
                    oetBchMQDocUsrAccount  : { "required": {} },
                    oetBchMQDocPassword    : { "required": {} },

                    //MQSale
                    oetBchMQSaleUsrAccount : { "required": {} },
                    oetBchMQSalePassword   : { "required": {} },

                    //MQReport
                    oetBchMQReportUsrAccount : { "required": {} },
                    oetBchMQReportPassword   : { "required": {} },

                },
                messages: {

                    oetBchServerip: {
                        "required": $('#oetBchServerip').attr('data-validate-required'),
                        "dublicateCode" : "มีข้อมูลซ้ำกันกรุณากรอกข้อมูลใหม่"
                        // "dublicateCode": $('#oetBchServerip').attr('data-validate-dublicateCode')
                    },

                    //User Account
                    oetBchUsrAccount: {
                        "required": $('#oetBchUsrAccount').attr('data-validate-required'),
                        "dublicateCode": $('#oetBchUsrAccount').attr('data-validate-dublicateCode')
                    },
                    oetBchPassword: {
                        "required": $('#oetBchPassword').attr('data-validate-required'),
                        "dublicateCode": $('#oetBchPassword').attr('data-validate-dublicateCode')
                    },

                    //MQMain
                    oetBchMQMainUsrAccount: {
                        "required": $('#oetBchMQMainUsrAccount').attr('data-validate-required'),
                        "dublicateCode": $('#oetBchMQMainUsrAccount').attr('data-validate-dublicateCode')
                    },
                    oetBchMQMainPassword: {
                        "required": $('#oetBchMQMainPassword').attr('data-validate-required'),
                        "dublicateCode": $('#oetBchMQMainPassword').attr('data-validate-dublicateCode')
                    },

                    //MQDoc
                    oetBchMQDocUsrAccount: {
                        "required": $('#oetBchMQDocUsrAccount').attr('data-validate-required'),
                        "dublicateCode": $('#oetBchMQDocUsrAccount').attr('data-validate-dublicateCode')
                    },
                    oetBchMQDocPassword: {
                        "required": $('#oetBchMQDocPassword').attr('data-validate-required'),
                        "dublicateCode": $('#oetBchMQDocPassword').attr('data-validate-dublicateCode')
                    },

                    // MQSale
                    oetBchMQSaleUsrAccount: {
                        "required": $('#oetBchMQSaleUsrAccount').attr('data-validate-required'),
                        "dublicateCode": $('#oetBchMQSaleUsrAccount').attr('data-validate-dublicateCode')
                    },
                    oetBchMQSalePassword: {
                        "required": $('#oetBchMQSalePassword').attr('data-validate-required'),
                        "dublicateCode": $('#oetBchMQSalePassword').attr('data-validate-dublicateCode')
                    },
                    
                    // MQReport
                    oetBchMQReportUsrAccount: {
                        "required": $('#oetBchMQReportUsrAccount').attr('data-validate-required'),
                        "dublicateCode": $('#oetBchMQReportUsrAccount').attr('data-validate-dublicateCode')
                    },
                    oetBchMQReportPassword: {
                        "required": $('#oetBchMQReportPassword').attr('data-validate-required'),
                        "dublicateCode": $('#oetBchMQReportPassword').attr('data-validate-dublicateCode')
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
                    $.ajax({
                        type: "POST",
                        url: ptRoute,
                        data:  $('#ofmAddEditBchSettingConnect').serialize(),
                        cache: false,
                        timeout: 0,
                        success: function (tResult){
                            var aData = JSON.parse(tResult);
                            if(aData["nStaEvent"] == 900){
                                $("#ohdValidateDuplicate").val(1);
                                JSxBchSettingConnectSaveAddEdit(ptRoute);
                                $('#ofmAddEditBchSettingConnect').submit();
                                JCNxCloseLoading();
                            }else if(aData["nStaEvent"] == 1){
                                JSxBranchSetingConnection();
                            }else if(aData["nStaEvent"] == 800){
                                JSxSaveAgain();
                                JCNxCloseLoading();
                            }else{
                                var tMsgErrorFunction   = aDataReturn['tStaMessg'];
                                FSvCMNSetMsgErrorDialog('<p class="text-left">'+tMsgErrorFunction+'</p>');
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

    function JSxSaveAgain(){
        $.ajax({
            type: "POST",
            url: 'BchSettingConEventAdd',
            data:  $('#ofmAddEditBchSettingConnect').serialize(),
            cache: false,
            timeout: 0,
            success: function (tResult){
                var aData = JSON.parse(tResult);
                console.log(aData);
                if(aData["nStaEvent"] == 900){
                    JCNxCloseLoading();
                }else if(aData["nStaEvent"] == 1){
                    JSxBranchSetingConnection();
                }else{
                
                    var tMsgErrorFunction   = aDataReturn['tStaMessg'];
                    FSvCMNSetMsgErrorDialog('<p class="text-left">'+tMsgErrorFunction+'</p>');
                }
            },

            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }


    //Functionality: Insert Text In Modal Delete
    //Parameters: LocalStorage Data
    //Creator: 19/09/2019 witsarut (Bell)
    //Return: -
    //Return Type: -
    function JSxBchSettingConPaseCodeDelInModal() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {

            var tUrlid = '';
            var tUrlAddr = '';

            for ($i = 0; $i < aArrayConvert[0].length; $i++) {
                tUrlid += aArrayConvert[0][$i].nUrlid;
                tUrlid += ' , ';
                tUrlAddr += aArrayConvert[0][$i].tUrlAddr;
                tUrlAddr += ' , ';
            }
            $('#odvModalDeleteMutirecord #ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
            $('#ohdConfirmIDDeleteMutirecordUrlId').val(tUrlid);
            $('#ohdConfirmIDDeleteMutirecordAddress').val(tUrlAddr);
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


    //Functionality: Function Chack And Show Button Delete All
    //Parameters: LocalStorage Data
    //Creator: 05/07/2019 witsarut (Bell)
    //Return: - 
    //Return Type: -
    function JSxBchSettingConShowButtonChoose() {
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



    // Functionality : Control Input User/Password From Selected
    // Parameters : -
    // Create By : Witsarut
    // Creator: 12/09/2019
    // Return : -
    // Return Type : -
    function JSxBchSettingConTypeUsed(ptType){
      
        //  ดึงค่าตัวเลือกจากตัวเลือกประเภทการเข้าใช้งาน
        nSelectType = $('#ocmUrlConnecttype').val();
      
        /* กรณีเปลี่ยนประเภทการเข้าใช้งานรูปแบบการกรอกข้อมูล  จะเปลี่ยนไปดังนี้
                Select Type :
                1 URl/2 URl + Authorized/3 URl MQ
            -----------------------
                1 Panel UserAccount
                2 Panel MQ ข้อมูลหลัก
                3 Panel MQ เอกสาร
                4 Panel MQ การขาย
                5 Panel MQ รายงาน
            -----------------------
            1 กรณีเลือก URl เป็น Default ไม่ต้อง Show Panel 1,2,3,4,5 
            2 กรณีเลือก URl + Authorized  Show 1
            3 กรณีเลือก URl + MQ Show 2,3,4,5
        */

        switch (nSelectType){

            case '1' :
                // ซ่อน Panel 1,2,3,4,5
                JSxBchSettingConControlPanalHide();
            break;
            case '2' : 
                JSxBchSettingConControlPanalShow();
            break;
            case '3' :
                JSxBchSettingConControlPanalShowMQ();
            break;
            case '4' :
                // ซ่อน Panel 1,2,3,4,5
                JSxBchSettingConControlPanalHide();
            break;
            case '5' :
                // ซ่อน Panel 1,2,3,4,5
                JSxBchSettingConControlPanalHide();
            break;
            case '6' :
                // ซ่อน Panel 1,2,3,4,5
                JSxBchSettingConControlPanalHide();
            break;
            case '7' :
                // ซ่อน Panel 1,2,3,4,5
                JSxBchSettingConControlPanalHide();
            break;
            case '8' :
                // ซ่อน Panel 1,2,3,4,5
                JSxBchSettingConControlPanalHide();
            break;
            case '12' :
            // ซ่อน Panel 1,2,3,4,5
                JSxBchSettingConControlPanalHide();
            break;
            case '13' :
                 // ซ่อน Panel 1,3,4,5
                JSxBchSettingConControlPanalShowMQMember();
            break;
            case '16' :
                 // ซ่อน Panel 1,3,4,5
                 JSxBchSettingConControlPanalShow();
            break;
            default:
                // Default ซ่อน Panel 1,2,3,4,5
                JSxBchSettingConControlPanalHide();
        }


        // Reset ค่า User / Passwrod ทุกครั้งกรณีมีการเปลี่ยนประเภทการล็อกอิน
        if(ptType == 'insert'){
            JSxBchControlInputResetVal();
        }


    }

    // Create By : Witsarut
    // Functionality : Hide Panel 1,2,3,4,5
    // Parameters : -
    // Creator: 12/09/2019
    // Return : -
    // Return Type : 
    function JSxBchSettingConControlPanalHide(){
        $('#odvPanelUserAccount').hide(); 
        $('#odvPanelMQMain').hide();
        $('#odvPanelMQDocument').hide();
        $('#odvPanelMQSale').hide();
        $('#odvPanelReport').hide();
    }


    // Create By : Witsarut
    // Functionality : Show Panel 1
    // Parameters : -
    // Creator: 12/09/2019
    // Return : -
    // Return Type : 
    function JSxBchSettingConControlPanalShow(){
        $('#odvPanelUserAccount').show(); 
        $('#odvPanelMQMain').hide();
        $('#odvPanelMQDocument').hide();
        $('#odvPanelMQSale').hide();
        $('#odvPanelReport').hide();
        
    }

    // Create By : Witsarut
    // Functionality : Show Panel 2,3,4,5
    // Parameters : -
    // Creator: 12/09/2019
    // Return : -
    // Return Type : 
    function JSxBchSettingConControlPanalShowMQ(){
        $('#odvPanelUserAccount').hide(); 
        $('#odvPanelMQMain').show();
        $('#odvPanelMQDocument').show();
        $('#odvPanelMQSale').show();
        $('#odvPanelReport').show();
    }


     // Create By : Nattakit
    // Functionality : Show Panel 2,3,4,5
    // Parameters : -
    // Creator: 12/09/2019
    // Return : -
    // Return Type : 
    function JSxBchSettingConControlPanalShowMQMember(){
        $('#odvPanelUserAccount').hide(); 
        $('#odvPanelMQMain').show();
        $('#odvPanelMQDocument').hide();
        $('#odvPanelMQSale').hide();
        $('#odvPanelReport').hide();
    }

    // Reset ค่า User / Passwrod ทุกครั้งกรณีมีการเปลี่ยน ชื่อผู้ใช้ และ รหัส
    function JSxBchControlInputResetVal(){

        //  ดึงค่าตัวเลือกจากตัวเลือกประเภทการเข้าใช้งาน
        nSelectType = $('#ocmUrlConnecttype').val();

        switch(nSelectType){
            case '2' :

                $('#oetBchVulHost').val('');
                $('#oetBchUsrAccount').val('');
                $('#oetBchPassword').val('');
                $('#oetBchRemark').val('');
            break;
            case '3' :

                // MQMain
                $('#oetBchMQMainVulHost').val('');
                $('#oetBchMQMainUsrAccount').val('');
                $('#oetBchMQMainPassword').val('');
                $('#oetBchMQMainRemark').val('');

                //MQDoc
                $('#oetBchMQDocVulHost').val('');
                $('#oetBchMQDocUsrAccount').val('');
                $('#oetBchMQDocPassword').val('');
                $('#oetBchMQDocRemark').val('');

                //MQSale
                $('#oetBchMQSaleVulHost').val('');
                $('#oetBchMQSaleUsrAccount').val('');
                $('#oetBchMQSalePassword').val('');
                $('#oetBchMQSaleRemark').val('');

                //MQReport
                $('#oetBchMQReportVulHost').val('');
                $('#oetBchMQReportUsrAccount').val('');
                $('#oetBchMQReportPassword').val('');
                $('#oetBchMQReportRemark').val('');
            break;
        }
    }

    //Functionality : เปลี่ยนหน้า pagenation
    //Parameters : Event Click Pagenation
    //Creator : 13/09/2018 Witsarut
    //Return : View
    //Return Type : View
    function JSvBchSettingConClickPage(ptPage){
        var nPageCurrent = '';
        switch (ptPage){
            case 'next' :  //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPageSetCon .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous' :  //กดปุ่ม Previous
                nPageOld = $('.xWPageSetCon .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }
        JCNxOpenLoading();
        JSvBchSetConnectionList(nPageCurrent);
    }


    //Select Type 1,2,3
    $('#ocmUrlConnecttype').selectpicker();


   /*===== Begin Browse ===============================================================*/
   var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;

    var tUsrLevel        = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
    var tBchCodeMulti    = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var nCountBch        = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";

    if(nCountBch == 1){
        $('#obtBrowseSettingBch').attr('disabled',true);
    }

    if(tUsrLevel != "HQ"){
        tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
    }else{
        tWhere = "";
    }

    $("#obtBrowseSettingBch").click(function(){
        // option 
        window.oBrowseSettingBch = {
            Title: ['authen/user/user', 'tBrowseBCHTitle'],
            Table: {
                Master: 'TCNMBranch',
                PK: 'FTBchCode'
            },
            Join: {
                Table: ['TCNMBranch_L'],
                On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [
                  tWhere
                ]
            },
            GrideView: {
                ColumnPathLang: 'authen/user/user',
                ColumnKeyLang: ['tBrowseBCHCode', 'tBrowseBCHName'],
                ColumnsSize: ['10%', '75%'],
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMBranch.FTBchCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetSettingBchCode", "TCNMBranch.FTBchCode"],
                Text: ["oetSettingBchName", "TCNMBranch_L.FTBchName"]
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oBrowseSettingBch');
    });



   


</script>