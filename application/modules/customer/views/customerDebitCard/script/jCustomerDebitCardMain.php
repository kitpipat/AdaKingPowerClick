<script type="text/javascript">


    //Functionality : Call CustomerDebitCard Page Add  
    //Parameters : -
    //Creator : 11/09/2019 Witsarut(Bell)
    //Return : View
    //Return Type : View
    function JSvCallPageCustomerDebitCardAdd(){
        var ptCstCode = $('#ohdCstCode').val();
        JCNxOpenLoading();

        $.ajax({
            type   : "POST",
            url    : "DebitCardPageAdd",
            data   : {
                tCstCode : ptCstCode
            },
            cache: false,
            timeout: 5000,
            success : function (tResult){
                $('#odvTabDebitCard').html(tResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }   

    //Functionality : Call Credit Page Edit  
    //Parameters : -
    //Creator : 19/10/2019 witsarut (Bell)
    //Return : View
    //Return Type : View

    function JSvCallPageCustomerDebitCardEdit(){

        var ptCstCode = $('#ohdCstCode').val();
        JCNxOpenLoading();
        $.ajax({
            type   : "POST",
            url    : "DebitCardPageEdit",
            data   : {
                tCstCode : ptCstCode
            },
            cache: false,
            timeout: 5000,
            success : function (tResult){
                $('#odvTabDebitCard').html(tResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Functionality: (event) Delete
    //Parameters: Button Event [tIDCode tUsrCode]
    //Creator: 19/09/2019 Witsarut (Bell)
    //Update: -
    //Return: Event Delete Reason List
    //Return Type: -
    function JSxCustomerDebitCardDelete(ptRefCode,ptCrdCode,tYesOnNo){
        $('#odvModalDeleteSingle1').modal('show');
        $('#odvModalDeleteSingle1 #ospConfirmDelete1').html($('#oetTextComfirmDeleteSingle').val() + ptCrdCode + ' ' + tYesOnNo );
        $('#odvModalDeleteSingle1 #osmConfirmDelete1').on('click', function(evt) {
            $.ajax({
                type: "POST",
                url:  "DebitCardEventDelete",
                data: {
                    tCrdCode : ptCrdCode,
                    tRefCode : ptRefCode
                },
                cache: false,
                success: function(tResult){
                    var aData = JSON.parse(tResult);

                    //ถ้าลบบัตรเดบิตใบนั้นออก ข้อมูลสมาชิก ต้องเอาออกด้วย
                    if(aData["aResult"].bClearCstCard == true){
                        $('#oetCstCardNo').val('');
                        $('#oetCSTApply').val('');
                        $('#oetCSTCardIssue').val('');
                        $('#oetCSTCardExpire').val('');
                        $('#ocbCstCardStaAge').attr('checked',false);
                        $('#oetCstCardBchName').val('');
                    }

                    $('#odvModalDeleteSingle1').modal('hide');
                    setTimeout(function(){
                        JSvCustomerDebitCardList(1)
                    },500);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    }


    //Functionality : Add Data CstDebitCArd Add/Edit  
    //Parameters : from ofmAddEditCustomerDebitCard
    //Creator : 04/07/2019 witsarut (Bell)
    //Return : View
    //Return Type : View
    function JSxCstDebitCardSaveAddEdit(ptRoute){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#ofmAddEditCustomerDebitCard').validate().destroy();
            $('#ofmAddEditCustomerDebitCard').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetCstCrdCtyName:  {"required" :{}},
                    oetCstCrdCode : {"required" :{}},
                    
                },
                messages: {
                    oetCstCrdCtyName : {
                        "required"      : $('#oetCstCrdCtyName').attr('data-validate'),
                    },
                    oetCstCrdCode : {
                        "required"      : $('#oetCstCrdCode').attr('data-validate'),
                    }
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
                        data: $('#ofmAddEditCustomerDebitCard').serialize(),
                        cache: false,
                        timeout: 0,
                        success: function(tResult) {
                            var aData = JSON.parse(tResult);
                            if(aData["nStaEvent"]==1){
                                JSvCustomerDebitCardList(1)
                                JCNxCloseLoading();
                            }else if(aData["nStaEvent"]==900){
                                JSxCstDebitCardSaveAddEdit(ptRoute);
                                JCNxCloseLoading();
                            }else{
                                var tMsgErrorFunction   = aData['tStaMessg'];
                                FSvCMNSetMsgErrorDialog('<p class="text-left">'+tMsgErrorFunction+'</p>');
                            }

                            //ถ้ามันเอาไป insert ที่ ข้อมูลบัตรสมาชิก จะต้องเอาค่ามา default ทิ้งไว้
                            if(aData["aResult"].bInsertCstCard == true){
                                $('#oetCstCardNo').val(aData["aResult"].rtCardCode);
                                $('#oetCSTApply').val('<?=date('Y-m-d')?>');
                                $('#oetCSTCardIssue').val('<?=date('Y-m-d')?>');
                                $('#oetCSTCardExpire').val('<?=date('Y-m-d', strtotime("+1 year"))?>');
                                $('#ocbCstCardStaAge').attr('checked',true);
                                $('#oetCstCardBchName').val('<?=$this->session->userdata("tSesUsrBchNameDefault")?>');
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


    //Functionality : เปลี่ยนหน้า pagenation
    //Parameters : Event Click Pagenation
    //Creator : 17/10/2018 witsarut
    //Return : View
    //Return Type : View
    function  JSvCstDebitCardClickPage(ptPage){
        var nPageCurrent = '';
        switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWCstPage').addClass('disabled');
            nPageOld = $('.xWCstPage .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWCstPage .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
        JCNxOpenLoading();
        JSvBntDataTable(nPageCurrent);
    }


    

</script>