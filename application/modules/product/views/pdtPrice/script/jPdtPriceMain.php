<script type="text/javascript">
    var tPriDtBaseURL        = '<?php echo base_url(); ?>';
    var nPriDtLangEdits      = '<?php echo $this->session->userdata("tLangEdit")?>';

    $(document).ready(function(){
        $('.xWPdtSelectBox').selectpicker();

        $('.xWModalPriDTDate').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            // startDate: new Date(),
        });

        $('#obtPdtPriDTFilterDateStart').click(function(){
            $('#ocmPdtPriDTFilterDateStart').datepicker('show')
        });

        JSxSetShowPriceListFilter();
    });

    // Option Browse Customer Group
    var oPdtBrowseCstGrp    = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tNextFuncName       = poReturnInput.tNextFuncName;
        var oOptionReturn       = {
            Title: ['customer/customerGroup/customerGroup','tCstGrpTitle'],
            Table: {Master:'TCNMCstGrp',PK:'FTCgpCode'},
            Join: {
                Table: ['TCNMCstGrp_L'],
                On: ['TCNMCstGrp_L.FTCgpCode = TCNMCstGrp.FTCgpCode AND TCNMCstGrp_L.FNLngID = '+ nPriDtLangEdits,]
            },
            GrideView:{
                ColumnPathLang	: 'customer/customerGroup/customerGroup',
                ColumnKeyLang	: ['tCstGrpTBCode','tCstGrpTBName'],
                ColumnsSize     : ['15%','75%'],
                DataColumns		: ['TCNMCstGrp.FTCgpCode','TCNMCstGrp_L.FTCgpName'],
                DataColumnsFormat : ['',''],
                WidthModal      : 50,
                Perpage			: 20,
                OrderBy			: ['TCNMCstGrp_L.FTCgpName'],
                SourceOrder		: "ASC"
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMCstGrp.FTCgpCode"],
                Text		: [tInputReturnName,"TCNMCstGrp_L.FTCgpName"],
            },
            NextFunc:{
                FuncName: tNextFuncName,
            },
            RouteAddNew : 'customergroup',
            BrowseLev : nStaPdtBrowseType
        }
        return oOptionReturn;
    }

    // Option Browse Zone Group
    var oPdtBrowseZone      = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tNextFuncName       = poReturnInput.tNextFuncName;
        var oOptionReturn       = {
            Title: ['address/zone/zone','tZNETitle'],
            Table: {Master:'TCNMZone',PK:'FTZneChain'},
            Join: {
                Table: ['TCNMZone_L'],
                On: ['TCNMZone_L.FTZneChain = TCNMZone.FTZneChain AND TCNMZone_L.FNLngID = '+ nPriDtLangEdits,]
            },
            GrideView:{
                ColumnPathLang	: 'address/zone/zone',
                ColumnKeyLang	: ['tZNECode','tZNEName','tZNEChainName'],
                ColumnsSize     : ['15%','30%','45%'],
                DataColumns		: ['TCNMZone.FTZneChain','TCNMZone_L.FTZneName','TCNMZone_L.FTZneChainName'],
                DataColumnsFormat : ['','',''],
                WidthModal      : 50,
                Perpage			: 20,
                OrderBy			: ['TCNMZone_L.FTZneChainName'],
                SourceOrder		: "ASC"
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMZone.FTZneChain"],
                Text		: [tInputReturnName,"TCNMZone_L.FTZneChainName"],
            },
            NextFunc:{
                FuncName: tNextFuncName,
            },
            RouteAddNew : 'zone',
            BrowseLev : nStaPdtBrowseType
        };
        return oOptionReturn;
    }

    // Option Browse Branch Group
    var oPdtBrowseBranch    = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tNextFuncName       = poReturnInput.tNextFuncName;
        var oOptionReturn       = {
            Title: ['company/branch/branch','tBCHTitle'],
            Table: {Master:'TCNMBranch',PK:'FTBchCode'},
            Join: {
                Table: ['TCNMBranch_L'],
                On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+ nPriDtLangEdits,]
            },
            GrideView:{
                ColumnPathLang	: 'company/branch/branch',
                ColumnKeyLang	: ['tBCHCode','tBCHName'],
                ColumnsSize     : ['15%','75%'],
                DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                DataColumnsFormat : ['',''],
                WidthModal      : 50,
                Perpage			: 20,
                OrderBy			: ['TCNMBranch_L.FTBchName'],
                SourceOrder		: "ASC"
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMBranch.FTBchCode"],
                Text		: [tInputReturnName,"TCNMBranch_L.FTBchName"],
            },
            NextFunc:{
                FuncName: tNextFuncName,
            },
            RouteAddNew : 'branch',
            BrowseLev : nStaPdtBrowseType
        };
        return oOptionReturn;
    }
    
    // Option Browse Agency
    var oPdtBrowseAgency    = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tNextFuncName       = poReturnInput.tNextFuncName;
        var oOptionReturn       = {
            Title: ['ticket/agency/agency','tAggTitle'],
            Table: {Master:'TCNMAgency',PK:'FTAgnCode'},
            Join: {
                Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = '+ nPriDtLangEdits,]
            },
            GrideView:{
                ColumnPathLang	: 'ticket/agency/agency',
                ColumnKeyLang	: ['tAggCode','tAggName'],
                ColumnsSize     : ['15%','75%'],
                DataColumns		: ['TCNMAgency.FTAgnCode','TCNMAgency_L.FTAgnName'],
                DataColumnsFormat : ['',''],
                WidthModal      : 50,
                Perpage			: 20,
                OrderBy			: ['TCNMAgency_L.FTAgnName'],
                SourceOrder		: "ASC"
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMAgency.FTAgnCode"],
                Text		: [tInputReturnName,"TCNMAgency_L.FTAgnName"],
            },
            NextFunc:{
                FuncName: tNextFuncName,
            },
            RouteAddNew : 'agency',
            BrowseLev : nStaPdtBrowseType
        };
        return oOptionReturn;
    }

    // Click Browse Customer Group
    $('#obtBrowsePriDTCstGrp').click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#odvModallAllPriceList #odvModalPdtPriceDetail').modal('hide');
            window.oPdtBrowseCstGrpOption = oPdtBrowseCstGrp({
                'tReturnInputCode'  : 'oetPdtPriDTCstGrpCode',
                'tReturnInputName'  : 'oetPdtPriDTCstGrpName',
                'tNextFuncName'     : 'JCNxShowModalPriceBehideBrowse'
            });
            JCNxBrowseData('oPdtBrowseCstGrpOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Click Browse Customer Zone
    $('#obtBrowsePriDTZone').click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#odvModallAllPriceList #odvModalPdtPriceDetail').modal('hide');
            window.oPdtBrowseZoneOption = oPdtBrowseZone({
                'tReturnInputCode'  : 'oetPdtPriDTZoneCode',
                'tReturnInputName'  : 'oetPdtPriDTZoneName',
                'tNextFuncName'     : 'JCNxShowModalPriceBehideBrowse'
            });
            JCNxBrowseData('oPdtBrowseZoneOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Click Browse Customer Branch
    $('#obtBrowsePriDTBranch').click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#odvModallAllPriceList #odvModalPdtPriceDetail').modal('hide');
            window.oPdtBrowseBranchOption = oPdtBrowseBranch({
                'tReturnInputCode'  : 'oetPdtPriDTBchCode',
                'tReturnInputName'  : 'oetPdtPriDTBchName',
                'tNextFuncName'     : 'JCNxShowModalPriceBehideBrowse'
            });
            JCNxBrowseData('oPdtBrowseBranchOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Click Browse Customer Agency
    $('#obtBrowsePriDTAgency').click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#odvModallAllPriceList #odvModalPdtPriceDetail').modal('hide');
            window.oPdtBrowseAgencyOption = oPdtBrowseAgency({
                'tReturnInputCode'  : 'oetPdtPriDTAGGCode',
                'tReturnInputName'  : 'oetPdtPriDTAGGName',
                'tNextFuncName'     : 'JCNxShowModalPriceBehideBrowse'
            });
            JCNxBrowseData('oPdtBrowseAgencyOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });




    $('.xWPriDTTab').click(function(){
        var tMenuType   = $(this).data('menutype');
        $('#odvPriceDetailPdtFrmFilter #ohdPriDTTabTableSlt').val(tMenuType);
        JSxSetShowPriceListFilter();
    });
    
    // Function: Call Back Modal Hide Show Modal Again
    // Parameters: Object In Next Funct Modal Browse
    // Creator:	27/02/2019 wasin(Yoshi)
    // Return: View Modal Price Detail
    // ReturnType: View
    function JCNxShowModalPriceBehideBrowse(){
        $('#odvModallAllPriceList #odvModalPdtPriceDetail').modal('show');
    }

    // Function: Set Input Filter Where Tab Select
    // Parameters: Document ready And Event Click Tab
    // Creator:	27/02/2019 wasin(Yoshi)
    // Return: Show Hide Input Filter
    // ReturnType: -
    function JSxSetShowPriceListFilter(){
        var tDataTabSlt = $("#ohdPriDTTabTableSlt").val();
        JSxClearValueInInput();
        switch(tDataTabSlt){
            case 'PRI4PDT':
                // Show Filter
                $('#odvPdtUnitFilter').show();
                $('#odvPdtPriTypeFilter').show();
                $('#odvPdtDateStartFilter').show();
                $('#odvPdtButtomClickFilter').show();
                // Hide Filter
                $('#odvPdtCstGroupFilter').hide();
                $('#odvPdtZoneFilter').hide();
                $('#odvPdtBarnchFilter').hide();
                $('#odvPdtAgencyFilter').hide();
            break;
            case 'PRI4CST':
                // Show Filter
                $('#odvPdtUnitFilter').show();
                $('#odvPdtPriTypeFilter').show();
                $('#odvPdtDateStartFilter').show();
                $('#odvPdtButtomClickFilter').show();
                $('#odvPdtCstGroupFilter').show();
                // Hide Filter
                $('#odvPdtZoneFilter').hide();
                $('#odvPdtBarnchFilter').hide();
                $('#odvPdtAgencyFilter').hide();
            break;
            case 'PRI4ZNE':
                // Show Filter
                $('#odvPdtUnitFilter').show();
                $('#odvPdtPriTypeFilter').show();
                $('#odvPdtDateStartFilter').show();
                $('#odvPdtButtomClickFilter').show();
                $('#odvPdtZoneFilter').show();
                // Hide Filter
                $('#odvPdtCstGroupFilter').hide();
                $('#odvPdtBarnchFilter').hide();
                $('#odvPdtAgencyFilter').hide();
            break;
            case 'PRI4BCH':
                // Show Filter
                $('#odvPdtUnitFilter').show();
                $('#odvPdtPriTypeFilter').show();
                $('#odvPdtDateStartFilter').show();
                $('#odvPdtButtomClickFilter').show();
                $('#odvPdtBarnchFilter').show();
                // Hide Filter
                $('#odvPdtCstGroupFilter').hide();
                $('#odvPdtZoneFilter').hide();
                $('#odvPdtAgencyFilter').hide();
            break;
            case 'PRI4AGG':
                // Show Filter
                $('#odvPdtUnitFilter').show();
                $('#odvPdtPriTypeFilter').show();
                $('#odvPdtDateStartFilter').show();
                $('#odvPdtButtomClickFilter').show();
                $('#odvPdtAgencyFilter').show();
                // Hide Filter
                $('#odvPdtCstGroupFilter').hide();
                $('#odvPdtZoneFilter').hide();
                $('#odvPdtBarnchFilter').hide();
            break;
            default:
                // Show Filter
                $('#odvPdtUnitFilter').show();
                $('#odvPdtPriTypeFilter').show();
                $('#odvPdtDateStartFilter').show();
                $('#odvPdtButtomClickFilter').show();
                // Hide Filter
                $('#odvPdtCstGroupFilter').hide();
                $('#odvPdtZoneFilter').hide();
                $('#odvPdtBarnchFilter').hide();
                $('#odvPdtAgencyFilter').hide();
                $("#ohdPriDTTabTableSlt").val('PRI4PDT');
        }
        JSvPdtCallModalPriceDataTable();
    }

    // Function: Clear Value In Input Filter
    // Parameters: Object In Next Funct Modal Browse
    // Creator:	27/02/2019 wasin(Yoshi)
    // Return: Reset Value In Input
    // ReturnType: -
    function JSxClearValueInInput(){
        // Clear Value Product Unit
        $('#ocmPdtPriDTFilterPriUnit').val('');
        $('#ocmPdtPriDTFilterPriUnit').selectpicker('refresh');
        
        // Clear Value Product Type
        $('#ocmPdtPriDTFilterPriType').val('');
        $('#ocmPdtPriDTFilterPriType').selectpicker('refresh');

        // Clear Value Date Start
        $('#ocmPdtPriDTFilterDateStart').val('');

        // Clear Value Customer Group
        $('#oetPdtPriDTCstGrpCode').val('');
        $('#oetPdtPriDTCstGrpName').val('');

        // Clear Value Zone
        $('#oetPdtPriDTZoneCode').val('');
        $('#oetPdtPriDTZoneName').val('');

        // Clear Value Branch
        $('#oetPdtPriDTBchCode').val('');
        $('#oetPdtPriDTBchName').val('');

        // Clear Value Agency 
        $('#oetPdtPriDTAGGCode').val('');
        $('#oetPdtPriDTAGGName').val('');
    }

    $('#obtPdtPriDTSummitFilter').click(function(){
        JSvPdtCallModalPriceDataTable();
    });

    // Function: ฟังก์ชั่น Call Data Product Price List Table
    // Parameters: Object In Next Funct Modal Browse
    // Creator:	27/02/2019 wasin(Yoshi)
    // Return: View Modal Price Detail
    // ReturnType: View
    function JSvPdtCallModalPriceDataTable(pnPage){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tDataTabSlt     = $("#ohdPriDTTabTableSlt").val();
            var tPriceDTPdtCode = $('#oetPdtCode').val();
            var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
            var aDataPriListFilter  = {
                'nPageCurrent'          : nPageCurrent,
                'tPriceDTPdtCode'       : tPriceDTPdtCode,
                'tPriceDTTabSlt'        : $('#ohdPriDTTabTableSlt').val(),
                'tPriceDTPriUnit'       : $('#ocmPdtPriDTFilterPriUnit').val(),
                'tPriceDTPriType'       : $('#ocmPdtPriDTFilterPriType').val(),
                'tPriceDTPriCstGrpCode' : $('#oetPdtPriDTCstGrpCode').val(),
                'tPriceDTPriZneCode'    : $('#oetPdtPriDTZoneCode').val(),
                'tPriceDTPriBchCode'    : $('#oetPdtPriDTBchCode').val(),
                'tPriceDTPriAggCode'    : $('#oetPdtPriDTAGGCode').val(),
                'tPriceDTPriDateStart'  : $('#ocmPdtPriDTFilterDateStart').val()
            };
            $.ajax({
                type: "POST",
                url: "productPriceTable"+tDataTabSlt,
                data: {'aDataPriListFilter' : aDataPriListFilter},
                cache: false,
                timeout: 0,
                async: false,
                success: function(oResult){
                    var aReturnData = JSON.parse(oResult);
                    if(aReturnData['nStaEvent'] == 1){
                        switch(aReturnData['tPriceDTTabSlt']){
                            case 'PRI4PDT':
                                $('#odvPdtPriDTContentTab #odvPriDT4PDTContent').html(aReturnData['tViewTable4PDT']);
                            break;
                            case 'PRI4CST':
                                $('#odvPdtPriDTContentTab #odvPriDT4CSTContent').html(aReturnData['tViewTable4CST']);
                            break;
                            case 'PRI4ZNE':
                                $('#odvPdtPriDTContentTab #odvPriDT4ZNEContent').html(aReturnData['tViewTable4ZNE']);
                            break;
                            case 'PRI4BCH':
                                $('#odvPdtPriDTContentTab #odvPriDT4BCHContent').html(aReturnData['tViewTable4BCH']);
                            break;
                            case 'PRI4AGG':
                                $('#odvPdtPriDTContentTab #odvPriDT4AGGContent').html(aReturnData['tViewTable4AGG']);
                            break;
                        }
                    }else{
                        var tMessageError = aReturnData['tStaMessg'];
                        FSvCMNSetMsgErrorDialog(tMessageError);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // Function: ฟังก์ชั่น Call Page Nation Click
    // Parameters: Object In Next Funct Modal Browse
    // Creator:	11/03/2019 wasin(Yoshi)
    // Return: View Modal Price Detail
    // ReturnType: View
    function JSvPdtPriceListClickPage(ptPage){
        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPagePriceList .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWPagePriceList .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }
        JSvPdtCallModalPriceDataTable(nPageCurrent);
    }
</script>