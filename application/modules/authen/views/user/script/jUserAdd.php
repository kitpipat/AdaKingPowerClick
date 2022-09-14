<script type="text/javascript">

    $(document).ready(function(){

        // ตรวจสอบระดับของ User  12/03/2020 Saharat(Golf)
        // Laster Update By Napat 07/05/2020
        var tStaUsrLevel    = '<?php  echo $this->session->userdata("tSesUsrLevel"); ?>';
        var tTypePage       = '<?php  echo $aResult['rtCode']; ?>';

        $( "#oliUsrloginDetail" ).click(function() {
            $('#odvBtnAddEdit').show();
        });

        // Create By Napat(Jame) 19/05/2020
        var tAgnCode = $('#oetUsrAgnCode').val();
        var tBchCode = $('#oetBranchCode').val();
        var tMerCode = $('#oetUsrMerCode').val();
        var tShpCode = $('#oetShopCode').val();

        // $('#obtUsrBrowseMerchant').attr("disabled", true);
        // $('#oimBrowseShop').attr("disabled", false);

        if(tAgnCode != ''){
            // $('#oimBrowseBranch').attr('disabled',false);
        }

        if(tBchCode != ''){
            // $('#obtUsrBrowseMerchant').attr('disabled',false);
        }

        if(tMerCode != ''){
            $('#oimBrowseShop').attr('disabled',false);
        }

        // ถ้ามีหลาย Branch ปิด Browse Merchant , Shop
        var nCountBchMulti = $("#odvBranchShow").children("span").size();
        if(nCountBchMulti > 1){
            // $('#obtUsrBrowseMerchant').attr("disabled", true);
            $('#oimBrowseShop').attr("disabled", true);
        }

        if(tStaUsrLevel == 'BCH' || tStaUsrLevel == 'SHP'){
            $('#obtUsrBrowseAgency').attr("disabled", true);
            // $('#oimBrowseBranch').attr("disabled", true);
        }

        if(tStaUsrLevel == 'SHP'){
            // $('#obtUsrBrowseMerchant').attr("disabled", true);
            $('#oimBrowseShop').attr("disabled", true);
        }



        // ตรวจสอบระดับUser banch  12/03/2020 Saharat(Golf)
        //  if(tUsrBchCode != ""){
        //     $('#oetBranchCode').val(tUsrBchCode);
        //     $('#oetBranchName').val(tUsrBchName);
        //     $('#oimBrowseBranch').attr("disabled", true);
        // }

        // ตรวจสอบระดับUser shop  12/03/2020 Saharat(Golf)
        // if(tUsrShpCode != ""){
        //     $('#oetShopCode').val(tUsrShpCode);
        //     $('#oetShopName').val(tUsrShpName);
        //     $('#oimBrowseShop').attr("disabled", true);
        // }

        // $ShpCheck = $('#oetBranchCode').val();
        // if($ShpCheck != '' && tUsrShpCode == "" ){
        //     $('#oimBrowseShop').prop('disabled',false);
        // }else{
        //     $('#oimBrowseShop').prop('disabled',true);
        // }




        // $('.xCNDatePicker').datepicker({
        //     format: 'yyyy-mm-dd',
        // autoclose: true,
        //     todayHighlight: true,
        //     startDate: new Date()
        // });
        $('.xWTooltipsBT').tooltip({'placement': 'bottom'});
        $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});

        // Event Browse
        $('#oimBrowseDepart').click(function(){
            // Create By Witsarut 04/10/2019
                JSxCheckPinMenuClose();
            // Create By Witsarut 04/10/2019
            JCNxBrowseData('oBrowseDepart');
        });

        // $('#oimBrowseShop').click(function(){
        //     // Create By Witsarut 04/10/2019
        //       JSxCheckPinMenuClose();
        //     // Create By Witsarut 04/10/2019
        //     JCNxBrowseData('oBrowseShop');
        // });

        $('#obtUsrDateStart').click(function(event){
                $('#oetUsrDateStart').datepicker('show');
        });

        $('#obtUsrDateStop').click(function(event){
                $('#oetUsrDateStop').datepicker('show');
        });

        if(JSbUsrIsCreatePage()){
            // Usr Code
            $("#oetUsrCode").attr("disabled", true);
            $('#ocbUserAutoGenCode').change(function(){
                if($('#ocbUserAutoGenCode').is(':checked')) {
                    $('#oetUsrCode').val('');
                    $("#oetUsrCode").attr("disabled", true);
                    $('#odvUserCodeForm').removeClass('has-error');
                    $('#odvUserCodeForm em').remove();
                }else{
                    $("#oetUsrCode").attr("disabled", false);
                }
            });
            JSxUsrVisibleComponent('#odvUserAutoGenCode', true);
        }

        if(JSbUsrIsUpdatePage()){
            // Sale Person Code
            $("#oetUsrCode").attr("readonly", true);
            $('#odvUserAutoGenCode input').attr('disabled', true);
            JSxUsrVisibleComponent('#odvUserAutoGenCode', false);
        }

        $('#oetUsrCode').blur(function(){
            JSxCheckUsrCodeDupInDB();
        });

        JSxUsrGetRoleCodeWhereBrows();


});

// Lang Edit In Browse
var nLangEdits = <?php echo $this->session->userdata("tLangEdit")?>;
// Set Option Browse
// ************************************************************************************
        // Create By Witsarut 24/04/2020
        // Last Updated By Napat 07/05/2020 โปรเจค Kubota ไม่ใช้ Shp Multi
        // กำหนด 1 ผู้ใช้มีได้หลาย ร้านค้า (Multi-select boxes)
        $('#oimBrowseShop').unbind().click(function(){
            var nStaSession  = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oShpOption       =  undefined;
                oShpOption              = oBrowseShop({
                    'tReturnInputShopCode'      : 'oetShopCode',
                    'tReturnInputShopName'      : 'oetShopName',
                    'tGetInputMerCode'          : $('#oetUsrMerCode').val(),
                    'tGetInputBchCode'          : $('#oetBranchCode').val(),
                    'tNextFuncName'             : 'JSxConsNextFuncBrowseUsrShop',
                    'aArgReturn'                : ['FTShpCode','FTShpName']
                });
                JCNxBrowseMultiSelect('oShpOption');
                // JCNxBrowseData('oShpOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        function JSxConsNextFuncBrowseUsrShop(poDataNextFunc){
            console.log('LOG >>> choose shop');
            $('#odvShopShow').html('');
            if(typeof(poDataNextFunc)!= 'undefined' && poDataNextFunc != "NULL"){
                var tHtml = '';
                for($i=0; $i < poDataNextFunc.length; $i++ ){
                    var aText   = JSON.parse(poDataNextFunc[$i]);
                    tHtml       += '<span class="label label-info m-r-5">'+aText[1]+'</span>';
                }
                $('#odvShopShow').html(tHtml);
            }
        }
        // Option Browse Shop
        var oBrowseShop = function(poReturnInputShop){
            let tInputReturnShopCode    = poReturnInputShop.tReturnInputShopCode;
            let tInputReturnShopName    = poReturnInputShop.tReturnInputShopName;
            let tShopNextFunc           = poReturnInputShop.tNextFuncName;
            let aShopArgReturn          = poReturnInputShop.aArgReturn;

            let tGetInputMerCode        = poReturnInputShop.tGetInputMerCode;
            let tGetInputBchCode        = poReturnInputShop.tGetInputBchCode;

            let tWhere                  = "";

            let oShopOptionReturn       = {
                Title : ['authen/user/user','tBrowseSHPTitle'],
                Table:{Master:'TCNMShop',PK:'FTShpCode'},
                Join :{
                    Table:	['TCNMShop_L'],
                    On:[
                        'TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = '+nLangEdits,
                    ]
                },
                Where :{
                    Condition : []
                },
                GrideView:{
                    ColumnPathLang	: 'authen/user/user',
                    ColumnKeyLang	: ['tBrowseSHPCode','tBrowseSHPName'],
                    ColumnsSize     : ['10%','75%'],
                    WidthModal      : 50,
                    DataColumns		: ['TCNMShop.FTShpCode','TCNMShop_L.FTShpName'],
                    DataColumnsFormat : ['',''],
                    Perpage			: 10,
                    OrderBy		    : ['TCNMShop.FDCreateOn DESC'],
                },
                NextFunc : {
                    FuncName  : tShopNextFunc,
                    ArgReturn : aShopArgReturn
                },
                CallBack:{
                    ReturnType	: 'S',
                    Value		: [tInputReturnShopCode,"TCNMShop.FTShpCode"],
                    Text		: [tInputReturnShopName,"TCNMShop_L.FTShpName"]
                },
                RouteAddNew : 'shop',
                BrowseLev : nStaUsrBrowseType
            };

            if(tGetInputBchCode != ""){
                var tBCHCode = tGetInputBchCode.replace(/,/g, "','");
                tWhere += " AND TCNMShop.FTBchCode IN('"+tBCHCode+"')";
            }
            if(tGetInputMerCode != ""){
                tWhere += " AND TCNMShop.FTMerCode IN('"+tGetInputMerCode+"')";
            }

            oShopOptionReturn.Where.Condition = [ tWhere ];

            return oShopOptionReturn;
        }

        // Create By Witsarut 23/04/2020
        // Last Updated By Napat 07/05/2020 โปรเจค Kubota ไม่ใช้ Bch Multi
        // กำหนด 1 ผู้ใช้มีได้หลาย สาขา (Multi-select boxes)
        $('#oimBrowseBranch').unbind().click(function(){
            var nStaSession  = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oBchOption       =  undefined;
                oBchOption              = oBrowseBranch({
                    'tReturnInputBranchCode'    : 'oetBranchCode',
                    'tReturnInputBranchName'    : 'oetBranchName',
                    'tNextFuncName'             : 'JSxConsNextFuncBrowseUsrBranch',
                    'aArgReturn'                : ['FTBchCode','FTBchName'] //,'FTMerCode','FTMerName'
                });
                JCNxBrowseMultiSelect('oBchOption');
                // JCNxBrowseData('oBchOption');

            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        function JSxConsNextFuncBrowseUsrBranch(poDataNextFunc){

            console.log('LOG >>> choose branch');
            // if(poDataNextFunc != 'NULL'){
            //     var aText = JSON.parse(poDataNextFunc);
            //     if(aText[2] != null){
            //         $('#oetUsrMerCode').val(aText[2]);
            //         $('#oetUsrMerName').val(aText[3]);
            //     }
            //     $('#oimBrowseShop').attr('disabled',false); // ถ้าเลือก สาขา ให้เปิดปุ่มร้านค้า
            // }else{
            //     $('#oimBrowseShop').attr('disabled',true); // ถ้าไม่เลือก สาขา ให้ปิดปุ่มร้านค้า
            // }

            // // Clear Input Browse Shop
            // $('#oetShopCode').val('');
            // $('#oetShopName').val('');

            $('#odvBranchShow').html('');
            if(typeof(poDataNextFunc[0])!= 'undefined' && poDataNextFunc[0] != null){ //poDataNextFunc[0] != "NULL"
                var tHtml = '';
                var tBchCodeStr = '';
                for($i=0; $i < poDataNextFunc.length; $i++ ){
                    var aText   = JSON.parse(poDataNextFunc[$i]);
                    tHtml       += '<span class="label label-info m-r-5">'+aText[1]+'</span>';

                }

                var tNumChk     = $("input[type=checkbox]:checked").length;

                var tDataNumChk = tNumChk - 1;


                // กรณีเลือก 1 สาขา
                if(tDataNumChk == 1){
                    $('#oimBrowseShop').prop('disabled', false);
                }else{
                    $('#oimBrowseShop').prop('disabled', true);
                }
                $('#odvBranchShow').html(tHtml);

            }else{

                // $('#obtUsrBrowseMerchant').prop('disabled',true);
                $('#oimBrowseShop').prop('disabled',true);
            }

            $('#oetUsrMerCode').val('');
            $('#oetUsrMerName').val('');

            $('#oetRoleCode').val('');
            $('#oetRoleName').val('');
 			$('#odvUsrRoleShow').html('');

            $('#oetShopName').val('');
            $('#oetShopCode').val('');
            $('#odvShopShow').html('');


            JSxUsrGetRoleCodeWhereBrows();

        }



    function JSxUsrGetRoleCodeWhereBrows(){

        // console.log($('#oetBranchCode').val());
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $.ajax({
            type: "POST",
            url: "userEventGetRoleUsr",
            data: {
                tBchCodeUsr: $('#oetBranchCode').val()
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                // if (tResult != "") {
                    $('#ohdURSRolMultiAccess').val(tResult);
                // }
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
        // Option Browse Branch
        var oBrowseBranch = function(poReturnInputBranch){
            let tInputReturnBranchCode   = poReturnInputBranch.tReturnInputBranchCode;
            let tInputReturnBranchName   = poReturnInputBranch.tReturnInputBranchName;
            let tBranchNextFunc          = poReturnInputBranch.tNextFuncName;
            let aBranchArgReturn         = poReturnInputBranch.aArgReturn;

            let tSesUsrBchCodeMulti     =  "<?=$this->session->userdata('tSesUsrBchCodeMulti')?>";
            let tSesUsrLevel            =  "<?=$this->session->userdata('tSesUsrLevel')?>";
            let tWhereCondiotion        = "";

            if( tSesUsrLevel != "HQ" ){
                tWhereCondiotion = " AND TCNMBranch.FTBchCode IN ("+tSesUsrBchCodeMulti+") ";
            }

            let oBranchOptionReturn      = {
                Title : ['authen/user/user','tBrowseBCHTitle'],
                Table :{Master:'TCNMBranch',PK:'FTBchCode'},
                Join :{
                    Table       : ['TCNMBranch_L'], //,'TCNMMerchant_L'
                    On          : [
                        'TCNMBranch.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits
                        // 'TCNMBranch.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = '+nLangEdits
                    ]
                },
                Where:{
                    Condition: [ tWhereCondiotion ]
                },
                Filter:{
                    Selector    : 'oetUsrAgnCode',
                    Table       : 'TCNMBranch',
                    Key         : 'FTAgnCode'
                },
                GrideView:{
                    ColumnPathLang	: 'authen/user/user',
                    ColumnKeyLang	: ['tBrowseBCHCode','tBrowseBCHName'],
                    ColumnsSize     : ['10%','75%'],
                    DataColumns	    : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'], //,'TCNMBranch.FTMerCode','TCNMMerchant_L.FTMerName'
                    DataColumnsFormat : ['',''],
                    // DisabledColumns	: [2,3],
                    WidthModal      : 50,
                    Perpage			: 10,
                    OrderBy			: ['TCNMBranch.FDCreateOn DESC'],
                },
                NextFunc : {
                    FuncName  : tBranchNextFunc,
                    ArgReturn : aBranchArgReturn
                },
                CallBack:{
                    ReturnType	: 'S',
                    Value		: [tInputReturnBranchCode,"TCNMBranch.FTBchCode"],
                    Text		: [tInputReturnBranchName,"TCNMBranch_L.FTBchName"]
                },
            };
            return oBranchOptionReturn;
        }

        // Create By Napat 07/05/2020
        $('#obtUsrBrowseMerchant').off('click');
        $('#obtUsrBrowseMerchant').on('click',function(){
            var nStaSession  = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oUsrMerOption       = undefined;
                oUsrMerOption              = oUsrBrowseMerchant({
                    'tUsrBchCode'               : $('#oetBranchCode').val(),
                    'tReturnInputCode'          : 'oetUsrMerCode',
                    'tReturnInputName'          : 'oetUsrMerName',
                    'tNextFuncName'             : 'JSxUSRNextFuncBrowseUsrMerchant',
                    'aArgReturn'                : ['FTMerCode','FTMerName']
                });
                JCNxBrowseData('oUsrMerOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Option Browse Merchant
        var oUsrBrowseMerchant = function(poReturnInputMerchant){
            let tUsrBchCode                = poReturnInputMerchant.tUsrBchCode;
            let tInputReturnMerchantCode   = poReturnInputMerchant.tReturnInputCode;
            let tInputReturnMerchantName   = poReturnInputMerchant.tReturnInputName;
            let tMerchantNextFunc          = poReturnInputMerchant.tNextFuncName;
            let aMerchantArgReturn         = poReturnInputMerchant.aArgReturn;

            // let tJoinBranch = " LEFT JOIN ( SELECT FTMerCode FROM TCNMBranch GROUP BY FTMerCode ) B ON TCNMMerchant.FTMerCode = B.FTMerCode ";
            // let tJoinShop   = " LEFT JOIN ( SELECT FTMerCode FROM TCNMShop GROUP BY FTMerCode ) S ON TCNMMerchant.FTMerCode = S.FTMerCode ";

            let tJoinShop   = " INNER JOIN ( SELECT FTMerCode,FTBchCode FROM TCNMShop GROUP BY FTMerCode,FTBchCode ) S ON S.FTMerCode = TCNMMerchant.FTMerCode AND S.FTBchCode = '"+tUsrBchCode+"' "

            let oMercgantOptionReturn = {
                Title : ['authen/user/user','tBrowseMERTitle'],
                Table :{Master:'TCNMMerchant',PK:'FTMerCode'},
                Join :{
                    Table:	['TCNMMerchant_L'],
                    // On:['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = ' + nLangEdits + tJoinShop] //+ tJoinBranch
                    On:['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = ' + nLangEdits] //+ tJoinBranch
                },
                // Where :{
                //     Condition : [" AND ( ISNULL(B.FTMerCode,'') != '' OR ISNULL(S.FTMerCode,'') != '') "]
                // },
                GrideView:{
                    ColumnPathLang	: 'authen/user/user',
                    ColumnKeyLang	: ['tBrowseMERCode','tBrowseMERName'],
                    ColumnsSize     : ['10%','75%'],
                    DataColumns	    : ['TCNMMerchant.FTMerCode','TCNMMerchant_L.FTMerName'],
                    DataColumnsFormat : ['',''],
                    WidthModal      : 50,
                    Perpage			: 10,
                    OrderBy			: ['TCNMMerchant.FDCreateOn DESC'],
                },
                NextFunc : {
                    FuncName  : tMerchantNextFunc,
                    ArgReturn : aMerchantArgReturn
                },
                CallBack:{
                    ReturnType	: 'S',
                    Value		: [tInputReturnMerchantCode,"TCNMMerchant.FTMerCode"],
                    Text		: [tInputReturnMerchantName,"TCNMMerchant_L.FTMerName"]
                },
                // DebugSQL: true,
            };
            return oMercgantOptionReturn;
        }

        function JSxUSRNextFuncBrowseUsrMerchant(poDataNextFunc){
            console.log('LOG >>> choose merchant');

            if(poDataNextFunc != 'NULL'){
                // ถ้าเลือกรายการ
                // $('#oimBrowseBranch').attr('disabled',false);
                $('#oimBrowseShop').attr('disabled',false);
            }else{
                // ถ้าไม่ได้เลือกรายการใดๆ
                // $('#oimBrowseBranch').attr('disabled',true);
                $('#oimBrowseShop').attr('disabled',true);
            }

            // Clear Input Browse Branch
            // $('#oetBranchCode').val('');
            // $('#oetBranchName').val('');

            // Clear Input Browse Shop
            $('#oetShopCode').val('');
            $('#oetShopName').val('');

            // Claer Bch and Shp Multi
            // $('#odvBranchShow').html('');
            $('#odvShopShow').html('');

        }

        // Create By Napat 19/05/2020
        $('#obtUsrBrowseAgency').off('click');
        $('#obtUsrBrowseAgency').on('click',function(){
            var nStaSession  = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oUsrAgnOption       = undefined;
                oUsrAgnOption              = oUsrBrowseAgency({
                    'tReturnInputCode'          : 'oetUsrAgnCode',
                    'tReturnInputName'          : 'oetUsrAgnName',
                    'tNextFuncName'             : 'JSxUSRNextFuncBrowseAgency',
                    'aArgReturn'                : ['FTAgnCode','FTAgnName']
                });
                JCNxBrowseData('oUsrAgnOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Option Browse Merchant
        var oUsrBrowseAgency = function(poReturnInputAgency){
            let tInputReturnAgnCode   = poReturnInputAgency.tReturnInputCode;
            let tInputReturnAgnName   = poReturnInputAgency.tReturnInputName;
            let tAgencyNextFunc       = poReturnInputAgency.tNextFuncName;
            let aAgencyArgReturn      = poReturnInputAgency.aArgReturn;

            // let tJoinBranch = " LEFT JOIN ( SELECT FTMerCode FROM TCNMBranch GROUP BY FTMerCode ) B ON TCNMMerchant.FTMerCode = B.FTMerCode ";
            // let tJoinShop   = " LEFT JOIN ( SELECT FTMerCode FROM TCNMShop GROUP BY FTMerCode ) S ON TCNMMerchant.FTMerCode = S.FTMerCode ";

            let oAgencyOptionReturn = {
                Title : ['authen/user/user','tBrowseAgnTitle'],
                Table :{Master:'TCNMAgency',PK:'FTAgnCode'},
                Join :{
                    Table:	['TCNMAgency_L'],
                    On:[' TCNMAgency.FTAgnCode = TCNMAgency_L.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits] //+ tJoinBranch + tJoinShop
                },
                // Where :{
                //     Condition : [" AND ( ISNULL(B.FTMerCode,'') != '' OR ISNULL(S.FTMerCode,'') != '') "]
                // },
                GrideView:{
                    ColumnPathLang	: 'authen/user/user',
                    ColumnKeyLang	: ['tBrowseAgnCode','tBrowseAgnName'],
                    ColumnsSize     : ['10%','75%'],
                    DataColumns	    : ['TCNMAgency.FTAgnCode','TCNMAgency_L.FTAgnName'],
                    DataColumnsFormat : ['',''],
                    WidthModal      : 50,
                    Perpage			: 10,
                    OrderBy			: ['TCNMAgency.FDCreateOn DESC'],
                },
                NextFunc : {
                    FuncName  : tAgencyNextFunc,
                    ArgReturn : aAgencyArgReturn
                },
                CallBack:{
                    ReturnType	: 'S',
                    Value		: [tInputReturnAgnCode,"TCNMAgency.FTAgnCode"],
                    Text		: [tInputReturnAgnName,"TCNMAgency_L.FTAgnName"]
                },
                //DebugSQL: true,
            };
            return oAgencyOptionReturn;
        }

        function JSxUSRNextFuncBrowseAgency(poDataNextFunc){
            console.log('LOG >>> choose agency');

            if(poDataNextFunc != 'NULL'){
                $('#oimBrowseBranch').attr('disabled',false);
                // $('#obtUsrBrowseMerchant').attr('disabled',true);
                $('#oimBrowseShop').attr('disabled',true);

                // Clear Input Browse Merchant
                $('#oetUsrMerName').val('');
                $('#oetUsrMerCode').val('');
                // Clear Input Browse Branch
                $('#oetBranchCode').val('');
                $('#oetBranchName').val('');
                // Clear Input Browse Shop
                $('#oetShopCode').val('');
                $('#oetShopName').val('');

                // Claer Bch and Shp Multi
                $('#odvBranchShow').html('');
                $('#odvShopShow').html('');

                $('#oetRoleCode').val('');
                $('#oetRoleName').val('');
                $('#odvUsrRoleShow').html('');
            }


            // if(poDataNextFunc != 'NULL'){
            //     // ถ้าเลือกรายการ ให้เปิดปุ่ม Browse
            //     $('#oimBrowseBranch').attr('disabled',false);
            //     $('#obtUsrBrowseMerchant').attr('disabled',true);
            //     $('#oimBrowseShop').attr('disabled',true);

            //     // Clear Input Browse Branch
            //     $('#oetBranchCode').val('');
            //     $('#oetBranchName').val('');
            //     // Clear Input Browse Shop
            //     $('#oetShopCode').val('');
            //     $('#oetShopName').val('');

            //     // Claer Bch and Shp Multi
            //     $('#odvBranchShow').html('');
            //     $('#odvShopShow').html('');
            // }else{
            //     // ถ้าไม่ได้เลือกรายการใดๆ ให้ปิด Browse อื่นๆ
            //     // $('#oimBrowseBranch').attr('disabled',true);
            //     $('#oimBrowseShop').attr('disabled',true);
            // }



        }

        // Create By Witsarut 20/02/2020
        // กำหนดสิทธิ  1 สิทธิ์มีได้หลาย UserCode (Multi-select boxes)
        $('#oimBrowseRole').unbind().click(function(){
            var nStaSession  = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oRoleOPtion      = undefined;
                oRoleOPtion             = oBrowseRole({
                    'tReturnInputRoleCode'  : 'oetRoleCode',
                    'tReturnInputRoleName'  : 'oetRoleName',
                    'tNextFuncName'     : 'JSxConsNextFuncBrowseUsrRole',
                    'aArgReturn'        : ['FTRolCode','FTRolName']
                });

                JCNxBrowseMultiSelect('oRoleOPtion');
                // JCNxBrowseData('oRoleOPtion');
            }else{
                JCNxShowMsgSessionExpired();
            }

        });

        function JSxConsNextFuncBrowseUsrRole(poDataNextFunc){
            $('#odvUsrRoleShow').html('');
            if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
                var tHtml = '';
                for($i=0; $i < poDataNextFunc.length; $i++ ){
                    var aText   = JSON.parse(poDataNextFunc[$i]);
                    tHtml       += '<span class="label label-info m-r-5">'+aText[1]+'</span>';
                }
                $('#odvUsrRoleShow').html(tHtml);
                $('#oetRoleName').closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                $('#oetRoleName').parents('.form-group').find(".help-block").fadeOut('slow').remove();
            }
        }

        // Option Browse Role
        // Last Update By : Napat(Jame) 18/12/2020 สิทธิ์การใช้งานต้องเห็นเฉพาะสิทธิ์ที่ตัวเองได้รับมา และสิทธิ์ที่ตัวเองสร้าง
        var oBrowseRole = function(poReturnInputRole){
            let tInputReturnRoleCode    = poReturnInputRole.tReturnInputCode;
            let tInputReturnRoleName    = poReturnInputRole.tReturnInputName;
            let tRoleNextFunc           = poReturnInputRole.tNextFuncName;
            let aRoleArgReturn          = poReturnInputRole.aArgReturn;
            let tSesUsrBchCodeMulti     =  "<?=$this->session->userdata('tSesUsrBchCodeMulti')?>";
            let nSesUsrBchCount         =  '<?=$this->session->userdata('nSesUsrBchCount')?>';
            // let tRoleAccess             = $('#ohdURSRolMultiAccess').val();
            let nSesUsrRoleLevel        =  parseInt('<?=$this->session->userdata('nSesUsrRoleLevel')?>');
            let tSesUsrRoleSpcCodeMulti =  "<?=$this->session->userdata('tSesUsrRoleSpcCodeMulti')?>";
            let tCondition              = '';
            let tSesUsrCode             = "<?=$this->session->userdata("tSesUserCode")?>";
            let tSesUsrRoleCodeMulti    = "<?=$this->session->userdata('tSesUsrRoleCodeMulti')?>";

            // ถ้าไม่ใช่ระดับ HQ
            // ไปหา FTRolCode จากตาราง TCNMUsrRoleSpc Where ด้วยสาขาที่ Login
            if(nSesUsrBchCount != 0){
                if(tSesUsrRoleSpcCodeMulti == ''){
                    tCondition += " AND TCNMUsrRole.FTRolCode IN ('"+ tSesUsrRoleSpcCodeMulti +"')";
                }else{
                    tCondition += " AND TCNMUsrRole.FTRolCode IN ("+ tSesUsrRoleSpcCodeMulti +")";
                }

            }

            let oRoleOptionReturn       = {
                Title : ['authen/user/user','tBrowseROLTitle'],
                Table:{Master:'TCNMUsrRole',PK:'FTRolCode'},
                Join :{
                    Table:	['TCNMUsrRole_L'],
                    On:['TCNMUsrRole_L.FTRolCode = TCNMUsrRole.FTRolCode AND TCNMUsrRole_L.FNLngID = ' + nLangEdits ]
                },
                Where :{
                  Condition : [tCondition]
                },
                GrideView:{
                    ColumnPathLang	: 'authen/user/user',
                    ColumnKeyLang	: ['tBrowseROLCode','tBrowseROLName'],
                    ColumnsSize     : ['15%','75%'],
                    WidthModal      : 50,
                    DataColumns		: ['TCNMUsrRole.FTRolCode','TCNMUsrRole_L.FTRolName'],
                    DataColumnsFormat : ['',''],
                    // Perpage         : 5,
                    // OrderBy			: ['TCNMUsrRole.FTRolCode'],
                    // SourceOrder		: "ASC"
                    Perpage			: 10,
                    OrderBy			: ['TCNMUsrRole.FDCreateOn DESC'],

                    // DisabledColumns	: [0],
                },
                NextFunc : {
                    FuncName  : tRoleNextFunc,
                    ArgReturn : aRoleArgReturn
                },
                CallBack:{
                    Value		: ["oetRoleCode","TCNMUsrRole.FTRolCode"],
                    Text		: ["oetRoleName","TCNMUsrRole_L.FTRolName"],
                },
                // DebugSQL: true,

            };
            return oRoleOptionReturn;
        }


// ************************************************************************************
    var tStaUsrLevel    = '<?php  echo $this->session->userdata("tSesUsrLevel"); ?>';
    if (tStaUsrLevel=="HQ") {
      tCondition = " AND TCNMUsrDepart.FTAgnCode ='' OR TCNMUsrDepart.FTAgnCode !='' ";
    }else {
      tCondition = " AND TCNMUsrDepart.FTAgnCode ='<?php echo $this->session->userdata("tSesUsrAgnCode"); ?>' AND TCNMUsrDepart.FTAgnCode !='' ";
    }
    // Option Department
    var oBrowseDepart = {
        Title : ['authen/user/user','tBrowseDPTTitle'],
        Table:{Master:'TCNMUsrDepart',PK:'FTDptCode'},
        Join :{
            Table:	['TCNMUsrDepart_L'],
            On:['TCNMUsrDepart_L.FTDptCode = TCNMUsrDepart.FTDptCode AND TCNMUsrDepart_L.FNLngID = '+nLangEdits]
        },
        Where :{
          Condition : [tCondition]
        },
        GrideView:{
            ColumnPathLang	: 'authen/user/user',
            ColumnKeyLang	: ['tBrowseDPTCode','tBrowseDPTName'],
            DataColumns		: ['TCNMUsrDepart.FTDptCode','TCNMUsrDepart_L.FTDptName'],
            ColumnsSize     : ['10%','75%'],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy		    : ['TCNMUsrDepart.FDCreateOn DESC'],
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetDepartCode","TCNMUsrDepart.FTDptCode"],
            Text		: ["oetDepartName","TCNMUsrDepart_L.FTDptName"]
        },
        NextFunc:{
            FuncName:'JSxChekDisableAddress',
            ArgReturn:['FTDptCode',]
        },
        RouteAddNew : 'department',
        BrowseLev : nStaUsrBrowseType
    };

    function JSxChekDisableAddress(paTest){
        tBchCode    = $('#oetBranchCode').val();
        tShpCode    = $('#oetShopCode').val();

        // $('#oetShopCode').val('');
        // $('#oetShopName').val('');
        // if(tBchCode == '' || tBchCode == null){
        //     $('#oimBrowseShop').prop('disabled',false);
        // }else{
        //     $('#oimBrowseShop').prop('disabled',true);
		// }
    }

    //Functionality: Set Validate Event Blur
    //Parameters: Validate Event Blur
    //Creator: 26/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxUsrSetValidEventBlur(){
        $('#ofmAddEditUser').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if($("#ohdCheckDuplicateUsrCode").val() == 1){
                return false;
            }else{
                return true;
            }
        },'');

        // From Summit Validate
        $('#ofmAddEditUser').validate({
            rules: {
                oetUsrCode : {
                    "required" :{
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if($('#ocbUserAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode" :{}
                },
            },

            messages: {
                oetUsrCode : {
                    "required"      : $('#oetUsrCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetUsrCode').attr('data-validate-dublicateCode')
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
            highlight: function ( element, errorClass, validClass ) {
                $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function(element, errorClass, validClass) {
                var nStaCheckValid  = $(element).parents('.form-group').find('.help-block').length
                if(nStaCheckValid != 0){
                    $(element).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                }
            },
            submitHandler: function(form){}
        });
    }


    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckUsrCodeDupInDB(){
        if(!$('#ocbUserAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: {
                    tTableName: "TCNMUser",
                    tFieldName: "FTUsrCode",
                    tCode: $("#oetUsrCode").val()
                },
                async : false,
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateUsrCode").val(aResult["rtCode"]);
                    JSxUsrSetValidEventBlur();
                    $('#ofmAddEditUser').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }

    // CML = CourierMan Login
    function JSxUsrloginGetContent(){
        var tRoutepage = '<?=$tRoute?>';

        if(tRoutepage == 'userEventAdd'){
            return;
        }else{
            var ptUsrCode    =  '<?php echo $tUsrCode;?>';

            // Check Login Expried
            var nStaSession = JCNxFuncChkSessionExpired();

            // If has Session
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                $("#odvUsrloginContentInfoDT").attr("class","tab-pane fade out");
                $.ajax({
                    type    : "POST",
                    url     : "userlogin",
                    data    : {
                        tUsrCode    : ptUsrCode
                    },
                    cache	: false,
                    timeout	: 0,
                    success	: function(tResult){
                        $('#odvBtnAddEdit').hide();
                        $('#odvUsrloginData').html(tResult);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        }
    }

</script>
