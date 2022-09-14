<script type="text/javascript">
    $(document).ready(function () {
        JSvShpWahList(1);
    });


  
    //function : Call PosAds Page list  
    //Parameters : Document Redy And Event Button
    //Creator :	19/08/2019 Witsarut (Bell)
    //Return : View
    //Return Type : View
    function JSvShpWahList(nPage){
        var ptShopCode    =   $('#oetShopCode').val();
        var ptBchCode     =   $('#oetBchCode').val();

        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "ShpWahDataTable",
            data    : {
                tShopCode         : ptShopCode,
                tBchCode          : ptBchCode,
                nPageCurrent      : nPage,
                tSearchAll        : ''
            },
            cache   : false,
            Timeout : 0,
            async   : false,
            success : function(tView){
                $('#odvContentShpWahDataTable').html(tView);
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
    function JSvCallPageShpWahAdd(){
        var ptShopCode    =   $('#oetShopCode').val();
        var ptBchCode    =   $('#oetBchCode').val();
        JCNxOpenLoading();
        $.ajax({
            type   : "POST",
            url    : "ShpWahPageAdd",
            data   : {
                tShopCode : ptShopCode,
                tBchCode  : ptBchCode  
            },
            cache: false,
            timeout: 5000,
            success: function(tResult){
                $('#odvSHPWah').html(tResult);
                $('.xWPageAdd').removeClass('hidden');
                $('.xWPageEdit').addClass('hidden');
                JCNxCloseLoading(); 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }


    //Functionality : Add Data ShpWah Add/Edit  
    //Parameters : from ofmAddEditShpWah
    //Creator : 04/07/2019 witsarut (Bell)
    //Return : View
    //Return Type : View
    function JSxShpWahSaveAddEdit(ptRoute){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#ofmAddEditShpWah').validate().destroy();
            $('#ofmAddEditShpWah').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetShpWahName:  {"required" :{}},
                },
                messages: {
                    oetCstCrdCtyName : {
                        "required"      : $('#oetShpWahName').attr('data-validate'),
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
                        type    : "POST",
                        url     : ptRoute,
                        data    : $('#ofmAddEditShpWah').serialize(),
                        cache   :false,
                        timeout :0,
                        success: function (tResult){
                            var aData = JSON.parse(tResult);
            
                            if(aData["nStaEvent"]==1){
                                JSxShpWahGetContent();
                                JCNxCloseLoading();
                            }else{
                                var tMsgErrorFunction   = aData['tStaMessg'];
                                FSvCMNSetMsgErrorDialogShpWah('<p class="text-left">'+tMsgErrorFunction+'</p>');
                                JCNxCloseLoading();
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

    function FSvCMNSetMsgErrorDialogShpWah(tMsgBody) {
        $('#odvModalBodyError .modal-body ').html(tMsgBody);
        $('#odvModalError').modal({ backdrop: 'static', keyboard: false })
        JCNxCloseLoading();
        $('#odvModalError').modal({ show: true });
    }

    //Functionality: (event) Delete
    //Parameters: Button Event Delete
    //Creator: 10/05/2018 Witsarut (Bell)
    //Update: -
    //Return: Event Delete Reason List
    //Return Type: -
    function JSxShpWahDelete(ptBchCode,ptShpCode,ptWahCode,tYesOnNo){
        $('#odvModalDeleteSingle').modal('show');
        $('#odvModalDeleteSingle #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptWahCode + ' '+ tYesOnNo );
        $('#odvModalDeleteSingle #osmConfirmDelete').on('click', function(evt) {
            $.ajax({
                type:   "POST",
                url:    "ShpWahEventDelete",
                data: {
                    tShpCode  : ptShpCode,
                    tWahCode  : ptWahCode,
                    tBchCode : ptBchCode
                },
                cache: false,
                success: function(tResult){
                    $('#odvModalDeleteSingle').modal('hide');
                    setTimeout(function(){
                        JSvShpWahList(1);
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
    function JSxSHPWAHDeleteMutirecord(pnPage){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            var aDataBchCode    =[];
            var aDataShpCode    =[];
            var aDataWahCode    =[];
            var ocbListItem     = $(".ocbListItem");

            for(var nI = 0;nI<ocbListItem.length;nI++){
                if($($(".ocbListItem").eq(nI)).prop('checked')){
                    aDataBchCode.push($($(".ocbListItem").eq(nI)).attr("ohdBchCodeDelete"));
                    aDataShpCode.push($($(".ocbListItem").eq(nI)).attr("ohdShopCodeDelete"));
                    aDataWahCode.push($($(".ocbListItem").eq(nI)).attr("ohdWahCodeDelete"));
                }
            }

            $.ajax({
                type: "POST",
                url : "ShpWahEventDeleteMultiple",
                data: {
                    'paDataBchCode'   : aDataBchCode,
                    'paDataShpCode'   : aDataShpCode,
                    'paDataWahCode'   : aDataWahCode,
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
                            JSvShpWahList(pnPage);
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

    //Set Lang Edit 
    var nLangEdits = <?php echo $this->session->userdata("tLangEdit")?>;

    // Browse Wahhoure
    $('#oimBrowseShopWah').click(function(){JCNxBrowseData('oBrowseShopWah')});

    // Browse Wahehours
    $('#oimBrowseShopWah').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu

            // alert( 'BCH: ' + $('#oetShpBchCode').val() );
            // alert( 'SHP: ' + $('#oetShpCode').val() );

            window.oShpWahOption    = undefined;
            oShpWahOption           = oBrowseShopWah({
                'tShpWahBchCode'       : $('#oetShpBchCode').val(),
                'tShpWahShpCode'       : $('#oetShpCode').val(),
                'tReturnInputBchCode'  : 'oetBchCode1',
                'tReturnInputWahCode'  : 'oetShpWahCode1',
                'tReturnInputWahName'  : 'oetShpWahName',
                'tNextFuncName'     : 'JSxConsNextFuncBrowseShpWah',
                'aArgReturn'        : ['FTBchCode','FTWahCode','FTWahName']
            });
            JCNxBrowseData('oShpWahOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });


    function JSxConsNextFuncBrowseShpWah(poDataNextFunc){
        if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
            var aDataNextFunc   = JSON.parse(poDataNextFunc);
            // console.log(aDataNextFunc);
            var tBchCode        = aDataNextFunc[0];
            var tWahCode        = aDataNextFunc[1];
            var tWahName        = aDataNextFunc[2];

            $('#oetBchCode1').val(tBchCode);
            $('#oetShpWahCode1').val(tWahCode);
            $('#oetShpWahName').val(tWahName);
        }
    }

    //GetBchCode 26/02/2020
    // Create By Witsarut 26/02/2020
    var  tBchCode =  $('#oetBchCode').val();

    var oBrowseShopWah = function(poReturnInputShpWah){
        let tShpWahInputReturnBchCode   = poReturnInputShpWah.tReturnInputBcnCode;
        let tShpWahInputReturnWahCode   = poReturnInputShpWah.tReturnInputWahCode;
        let tShpWahInputReturnWahName   = poReturnInputShpWah.tReturnInputWahName;
        let tShpWahNextFuncName         = poReturnInputShpWah.tNextFuncName;
        let aShpWahArgReturn            = poReturnInputShpWah.aArgReturn;
        let tShpWahBchCode              = poReturnInputShpWah.tShpWahBchCode;
        let tShpWahShpCode              = poReturnInputShpWah.tShpWahShpCode;

        let oShpWahOptionReturn         = {
            Title : ['company/shop/shop','tSHPWah'],
            Table:{Master:'TCNMWaHouse',PK:'FTWahCode'},
            Join :{
                Table   : ['TCNMWaHouse_L','TCNMShpWah'],
                On      : [
                    'TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = '+nLangEdits,
                    " TCNMShpWah.FTBchCode = '"+tShpWahBchCode+"' AND TCNMShpWah.FTShpCode = '"+tShpWahShpCode+"' AND TCNMShpWah.FTWahCode = TCNMWaHouse.FTWahCode "
                ]
            },
            Where : {
                Condition : [
                    " AND TCNMWaHouse.FTBchCode = '"+tBchCode+"' ",
                    " AND TCNMWaHouse.FTWahStaType IN ('1','2') ",  // Create By : Napat(Jame) 26/11/2020 เอาเฉพาะหลังมาตรฐานและคลังทั่วไป ( คลังสาขา, คลังร้านค้า )
                    " AND TCNMShpWah.FTWahCode IS NULL "            // Create By : Napat(Jame) 26/11/2020 ไม่แสดงคลังที่เลือกไปแล้ว
                ]
            },
                GrideView:{
                ColumnPathLang  : 'company/shop/shop',
                ColumnKeyLang   : ['tBchCode','tWahCode','tWahName'],
                ColumnsSize     : ['','15%','75%'],
                WidthModal      : 50,
                DataColumns     : ['TCNMWaHouse.FTBchCode','TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'],
                DataColumnsFormat : ['','',''],
                DisabledColumns	: [0],
                Perpage			: 10,
                OrderBy			: ['TCNMWaHouse.FDCreateOn DESC'],

            },
            NextFunc : {
                FuncName    : tShpWahNextFuncName,
                ArgReturn   : aShpWahArgReturn
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: ["oetShpWahCode1","TCNMWaHouse.FTWahCode"],
                Text		: ["oetShpWahName","TCNMWaHouse_L.FTWahName"],
            },
            // DebugSQL : true
        };
        return oShpWahOptionReturn;
    }


    //Functionality: Function Chack And Show Button Delete All
    //Parameters: LocalStorage Data
    //Creator: 05/07/2019 witsarut (Bell)
    //Return: - 
    //Return Type: -
    function JSxShpWahShowButtonChoose() {
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


    //Functionality: Insert Text In Modal Delete
    //Parameters: LocalStorage Data
    //Creator: 05/07/2019 witsarut (Bell)
    //Return: -
    //Return Type: -
    function JSxShpWahPaseCodeDelInModal() {
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
    //Creator: 09/05/2018 Witsarut
    //Update: -
    //Return: View
    //Return Type: View
    function JSvShpWahClickPage(ptPage){
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xWBtnNext").addClass("disabled");
                nPageOld = $(".xWShpWahPaging .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
            break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xWShpWahPaging .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
            break;
            default:
            nPageCurrent = ptPage;
        }
        JSvUsrloginList(nPageCurrent);
    }



</script>