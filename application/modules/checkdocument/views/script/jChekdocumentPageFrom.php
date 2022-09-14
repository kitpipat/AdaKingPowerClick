<script type="text/javascript">
    $(document).ready(function(){

        $('.selectpicker').selectpicker('refresh');
        $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            disableTouchKeyboard : true,
            autoclose: true
        });

        
        // var dCurrentDate    = new Date();
        // if($('#oetMNTDocDate').val() == ''){
        //         $('#oetMNTDocDate').datepicker("setDate",dCurrentDate); 
        //     }
            
            $('#obtMNTDocDateFrom').unbind().click(function(){
                $('#oetMNTDocDateFrom').datepicker('show');
            });

            $('#obtMNTDocDateTo').unbind().click(function(){
                $('#oetMNTDocDateTo').datepicker('show');
            });

            JSxMNTGetPageSumary();
            JSxMNTGetPageDataTable();
    });

    $('#obtMainAdjustProductFilter').click(function(e) {
            JSxMNTGetPageSumary();
            JSxMNTGetPageDataTable();
    });
    
    var tBaseURL = '<?php echo base_url(); ?>';
    var nLangEdits = '<?php echo $this->session->userdata("tLangEdit") ?>';
    function JSxMNTClearConditionAll(){
        $('#oetMNTAgnCode').val('');
        $('#oetMNTAgnName').val('');
        $('#oetMNTDocDateFrom').val('');
        $('#oetMNTDocDateTo').val('');
        $('#ocmMNTDocType').val('');
        JSxMNTGetPageSumary();
        JSxMNTGetPageDataTable();

    }

    // Click Browse Agency
    $('#obtMNTBrowsAgn').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oPdtBrowseAgency({
                'tReturnInputCode': 'oetMNTAgnCode',
                'tReturnInputName': 'oetMNTAgnName'
            });
            JCNxBrowseData('oPdtBrowseAgencyOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });


    // Click Browse Branch
    $('#obtMNTBrowsBch').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oPdtBrowseBranchOption = oPdtBrowseBranch({
                'tReturnInputCode': 'oetMNTBchCode',
                'tReturnInputName': 'oetMNTBchName',
                'tAgnCodeWhere': $('#oetMNTAgnCode').val(),
            });
            JCNxBrowseData('oPdtBrowseBranchOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    




    //เลือกสาขา
    var oPdtBrowseAgency = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;

        var oOptionReturn = {
            Title: ['ticket/agency/agency', 'tAggTitle'],
            Table: {
                Master: 'TCNMAgency',
                PK: 'FTAgnCode'
            },
            Join: {
                Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits]
            },
            GrideView: {
                ColumnPathLang: 'ticket/agency/agency',
                ColumnKeyLang: ['tAggCode', 'tAggName'],
                ColumnsSize: ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMAgency.FTAgnCode"],
                Text: [tInputReturnName, "TCNMAgency_L.FTAgnName"],
            },
            RouteAddNew: 'agency',
            NextFunc: {
                FuncName: 'JSxClearBrowseConditionAgn',
                ArgReturn: ['FTAgnCode']
            },
            BrowseLev : 1
        }
        return oOptionReturn;
    }




    function JSxClearBrowseConditionAgn(ptData) {
        // aData = JSON.parse(ptData);
        if (ptData != '' || ptData != 'NULL') {

            $('#oetMNTBchCode').val('');
            $('#oetMNTBchName').val('');

        }
    }



    //เลือกสาขา
    var oPdtBrowseBranch = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;
        var tAgnCodeWhere = poReturnInput.tAgnCodeWhere;

        var nCountBCH = '<?= $this->session->userdata('nSesUsrBchCount') ?>';
        // alert(nCountBCH);
        if (nCountBCH != '0') {
            //ถ้าสาขามากกว่า 1
            tBCH = "<?= $this->session->userdata('tSesUsrBchCodeMulti'); ?>";
            tWhereBCH = " AND TCNMBranch.FTBchCode IN ( " + tBCH + " ) ";
        } else {
            tWhereBCH = '';
        }

        if (tAgnCodeWhere == '' || tAgnCodeWhere == null) {
            tWhereAgn = '';
        } else {
            tWhereAgn = " AND TCNMBranch.FTAgnCode = '" + tAgnCodeWhere + "'";
        }


        var oOptionReturn = {
            Title: ['company/branch/branch', 'tBCHTitle'],
            Table: {
                Master: 'TCNMBranch',
                PK: 'FTBchCode'
            },
            Join: {
                Table: ['TCNMBranch_L', 'TCNMAgency_L'],
                On: [
                    'TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits,
                    'TCNMAgency_L.FTAgnCode = TCNMBranch.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits,
                ]
            },
            Where: {
                Condition: [tWhereBCH + tWhereAgn]
                // Condition: [tWhereAgn]
            },
            GrideView: {
                ColumnPathLang: 'company/branch/branch',
                ColumnKeyLang: ['tBCHCode', 'tBCHName'],
                ColumnsSize: ['15%', '75%'],
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName', 'TCNMAgency_L.FTAgnName', 'TCNMBranch.FTAgnCode'],
                DataColumnsFormat: ['', '', '', ''],
                DisabledColumns: [2, 3],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMBranch.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMBranch.FTBchCode"],
                Text: [tInputReturnName, "TCNMBranch_L.FTBchName"],
            },
            RouteAddNew: 'branch',
            BrowseLev : 1
        }
        return oOptionReturn;
    }

</script>