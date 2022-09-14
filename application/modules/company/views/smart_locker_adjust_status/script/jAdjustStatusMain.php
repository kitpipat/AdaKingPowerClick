<script>
    
    $('ducument').ready(function () {
        $('.selectpicker').selectpicker();
        
        $('.selectpicker').selectpicker();
	
        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

        $('.xCNTimePicker').datetimepicker({
            format: 'HH:mm:ss'
        });
        
        JSvSMLKAdjStaCallPageDataTable(1);
    });
    
    /*========================= Begin Browse Options =============================*/

    // สาขา 
    $('#obtSMLKAdjStaBrowseBch').click(function () {
        JSoSMLKAdjStaGetBchCodeOnShop();
        tOldBchCkChange = $("#oetBchCode").val();
        // Lang Edit In Browse
        nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;
        // Option Branch
        oPmhBrowseBch = {
            Title: ['company/branch/branch', 'tBCHTitle'],
            Table: {Master: 'TCNMBranch', PK: 'FTBchCode'},
            Join: {
                Table: ['TCNMBranch_L'],
                On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: ['AND TCNMBranch.FTBchCode IN (' + JSoSMLKAdjStaGetBchCodeOnShop('wraptextonly') + ')']
            },
            GrideView: {
                ColumnPathLang: 'company/branch/branch',
                ColumnKeyLang: ['tBCHCode', 'tBCHName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                DataColumnsFormat: ['', ''],
                DisabledColumns: [],
                Perpage: 5,
                OrderBy: ['TCNMBranch_L.FTBchName'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetSMLKAdjStaBchCode", "TCNMBranch.FTBchCode"],
                Text: ["oetSMLKAdjStaBchName", "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName: 'JSxSMLKAdjStaCallbackAfterSelectBch',
                ArgReturn: ['FTBchCode', 'FTBchName']
            },
            RouteFrom: 'promotion',
            RouteAddNew: 'branch',
            BrowseLev: 2
        };
        // Option Branch
        JCNxBrowseData('oPmhBrowseBch');

    });
    
    /*========================= End Browse Options =============================*/
    
    /*=================== Begin Callback Browse ==================================*/
    /**
     * สาขา
     * Functionality : Process after shoose branch
     * Parameters : -
     * Creator : 09/07/2019 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxSMLKAdjStaCallbackAfterSelectBch(poJsonData) {}
    
    /*=================== End Callback Browse ==================================*/
    
    /**
     * Functionality : Get Bch Code (สาขาที่ร้านค้าผูกอยู่)
     * Parameters : ptFormatType : array, text, wraptext, wraptextonly
     * Creator : 09/07/2019 Piya
     * Last Modified : -
     * Return : Bch Code
     * Return Type : Object
     */
    function JSoSMLKAdjStaGetBchCodeOnShop(ptFormatType) {
        ptFormatType = (typeof ptFormatType == 'undefined') ? 'array' : ptFormatType;

        var tBchCode = $('#oetPshPSHBchCode').val().split(', ');

        var mixReturn;
        switch(ptFormatType){
            case 'array' : { 
                mixReturn = tBchCode;
                break;
            }
            case 'text' : {
                mixReturn = JSON.stringify(tBchCode);
                break;
            }
            case 'wraptext' : {
                var aWrap = [];
                tBchCode.forEach(function(el){
                    aWrap.push("'" + el + "'");
                });
                mixReturn = JSON.stringify(aWrap);
                break;
            }
            case 'wraptextonly' : {
                var tWrap = '';
                var nBchLength = tBchCode.length;
                tBchCode.forEach(function(value, index){
                    if(nBchLength == index + 1){
                        tWrap += "'" + value + "'";
                    }else{
                        tWrap += "'" + value + "',";
                    }
                });
                mixReturn = tWrap;    
                break;
            }
            case 'textonly' : {
                var tText = '';
                var nBchLength = tBchCode.length;
                tBchCode.forEach(function(value, index){
                    tText += value;
                });
                mixReturn = tText;    
                break;
            }
            defatul: {}
        }
        console.log('tBchCode: ', mixReturn);
        return mixReturn;
    }
    
    /**
     * Functionality : Get Shop Code (ร้านค้าที่เลือกเข้ามา)
     * Parameters : -
     * Creator : 09/07/2019 Piya
     * Last Modified : -
     * Return : Shop Code
     * Return Type : Object
     */
    function JStSMLKAdjStaGetShopCode() {
        var tShpCode = $('#oetPshPSHShpCod').val();
        return tShpCode;
    }
    
    /**
     * Functionality : Get Mer Code (กลุ่มร้านค้าที่ร้านค้าผูกอยู่)
     * Parameters : -
     * Creator : 09/07/2019 Piya
     * Last Modified : -
     * Return : Mer Code
     * Return Type : String
     */
    function JStSMLKAdjStaGetMerCode() {
        var tMerCode = $('#oetPshPSHMerCode').val();
        return tMerCode;
    }
    
    /**
     * Functionality : Get Locker Code (ตู้ Locker)
     * Parameters : -
     * Creator : 09/07/2019 Piya
     * Last Modified : -
     * Return : Locker Code
     * Return Type : Object
     */
    function JStSMLKAdjStaGetLockerCode() {
        var tLockerCode = $('#oetPosCodeSN').val();
        return tLockerCode;
    }
    
    /**
     * Functionality : Get AdminHis
     * Parameters : pnPage
     * Creator : 09/07/2019 Piya
     * Last Modified : -
     * Return : view
     * Return Type : view
     */
    function JSvSMLKAdjStaCallPageDataTable(pnPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            
            JCNxOpenLoading();

            var nPageCurrent = pnPage;
            if (nPageCurrent == undefined || nPageCurrent == "") {
                nPageCurrent = "1";
            }

            var tBchCode = $('#oetSMLKAdjStaBchCode').val();
            var tRackCode = $('#ocmSMLKAdjStaRackCode').val();
            var tPosCode = JStSMLKAdjStaGetLockerCode(); // $('#oetPosCode').val();
            var tDate = $('#oetSMLKAdjStaDate').val();

            $.ajax({
                type: "POST",
                url: "smartLockerAdjustStatusDataTable",
                data: {
                    nPageCurrent: nPageCurrent,
                    tBchCode: (tBchCode == '') ? JSoSMLKAdjStaGetBchCodeOnShop('wraptextonly') : "'" + tBchCode + "'",
                    tShpCode: JStSMLKAdjStaGetShopCode(),
                    tPosCode: tPosCode,
                    tRackCode: tRackCode,
                    tDate: tDate
                },
                cache: false,
                timeout: 5000,
                success: function (tResult) {
                    $("#odvSMLKAdjStatusDataTableList").html(tResult);
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
            
        }else {
            JCNxShowMsgSessionExpired();
        }
    }
    
    /**
    * Functionality : Clear search data
    * Parameters : -
    * Creator : 09/07/2019 Piya
    * Last Modified : -
    * Return : -
    * Return Type : -
    */
   function JSxSMLKAdjStaClearSearchData() {
       var nStaSession = JCNxFuncChkSessionExpired();
       if (typeof nStaSession !== "undefined" && nStaSession == 1) {
           
           try {
               $("#oetSMLKAdjStaBchCode").val("");
               $("#oetSMLKAdjStaBchName").val("");
               $(".xCNDatePicker").datepicker("setDate", null);
               $(".selectpicker")
                       .val("")
                       .selectpicker("refresh");
               JSvSMLKAdjStaCallPageDataTable(1);
           } catch (err) {
               console.log("JSxCreditNoteClearSearchData Error: ", err);
           }
           
       } else {
           JCNxShowMsgSessionExpired();
       }
   }

    /**
    * Functionality : เปลี่ยนหน้า pagenation
    * Parameters : -
    * Creator : 09/07/2019 Piya
    * Return : View
    * Return Type : View
    */
   function JSvSMLKAdjStaDataTableClickPage(ptPage) {
       var nPageCurrent = "";
       switch (ptPage) {
           case "next": //กดปุ่ม Next
               $(".xWBtnNext").addClass("disabled");
               nPageOld = $(".xWPage .active").text(); // Get เลขก่อนหน้า
               nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
               nPageCurrent = nPageNew;
               break;
           case "previous": //กดปุ่ม Previous
               nPageOld = $(".xWPage .active").text(); // Get เลขก่อนหน้า
               nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
               nPageCurrent = nPageNew;
               break;
           default:
               nPageCurrent = ptPage;
       }
       JSvSMLKAdjStaCallPageDataTable(nPageCurrent);
   }
   
   /**
    * Functionality : Call Add Page
    * Parameters : -
    * Creator : 09/07/2019 Piya
    * Return : View
    * Return Type : View
    */
   function JSxSMLKAdjStaCallAddPage(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            
            var tRefCode = $('#ospRefCode').text();
            $.ajax({
                type: "POST",
                url: "smartLockerAdjustStatusPageAdd",
                data: {
                    tRefCode: tRefCode,
                    tLockerCode: JStSMLKAdjStaGetLockerCode()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    $('#odvPSHContentInfoCG').html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
            
        }else{
            JCNxShowMsgSessionExpired();
        }
    }
    
    /**
    * Functionality : Call View Page
    * Parameters : -
    * Creator : 09/07/2019 Piya
    * Return : View
    * Return Type : View
    */
   function JSxSMLKAdjStaCallViewPage(poEl){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            
            var tBchCode = $(poEl).parents('.xWSMLKAdminHisItems').data('his-bchcode');
            var tBchName = $(poEl).parents('.xWSMLKAdminHisItems').data('his-bchname');
            var tShpCode = $(poEl).parents('.xWSMLKAdminHisItems').data('his-shpcode');
            var tPosCode = $(poEl).parents('.xWSMLKAdminHisItems').data('his-poscode');
            var tRackCode = $(poEl).parents('.xWSMLKAdminHisItems').data('his-rackcode');
            var tRackName = $(poEl).parents('.xWSMLKAdminHisItems').data('his-rackname');
            var tHisStaUse = $(poEl).parents('.xWSMLKAdminHisItems').data('his-stause');
            var tHisUserCode = $(poEl).parents('.xWSMLKAdminHisItems').data('his-usrcode');
            var tHisUserName = $(poEl).parents('.xWSMLKAdminHisItems').data('his-usrname');
            var tHisDate = $(poEl).parents('.xWSMLKAdminHisItems').data('his-date');
                
            $.ajax({
                type: "POST",
                url: "smartLockerAdjustStatusPageView",
                data: {
                    tBchCode: tBchCode,
                    tBchName: tBchName,
                    tShpCode: tShpCode,
                    tPosCode: tPosCode,
                    tRackCode: tRackCode,
                    tRackName: tRackName,
                    tHisDate: tHisDate,
                    tHisUserCode: tHisUserCode,
                    tHisUserName: tHisUserName,
                    tHisStaUse: tHisStaUse
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    $('#odvPSHContentInfoCG').html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
            
        }else{
            JCNxShowMsgSessionExpired();
        }
    }
</script>
