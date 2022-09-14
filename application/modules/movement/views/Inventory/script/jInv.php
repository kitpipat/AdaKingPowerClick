<script type="text/javascript">
    var nLangEdits      = '<?php echo $this->session->userdata("tLangEdit");?>';
    var tStaUsrLevel    = '<?php  echo $this->session->userdata("tSesUsrLevel"); ?>';

    function JSxChqConsNextFuncBrowseBch(poDataNextfunc) {
        if (poDataNextfunc == 'NULL') {
            $('#obtInvMultiBrowseWaHouse').attr('disabled',true);
            $('#obtInvMultiBrowseProduct').attr('disabled',true);
        } else {
            $('#obtInvMultiBrowseWaHouse').removeAttr('disabled');
            $('#obtInvMultiBrowseProduct').removeAttr('disabled');
        }
        return;
    }

      // =========================================== Event Browse Multi Branch ===========================================
      $('#obtInvMultiBrowseBranch').unbind().click(function(){
        // เซตค่าว่าง คลังสินค้า
        $('#oetInvWahStaSelectAll').val('');
        $('#oetInvWahCodeSelect').val('');
        $('#oetInvWahNameSelect').val('');

        //เซตค่าว่าง สินค้า
        $('#oetInvPdtStaSelectAll').val('');
        $('#oetInvPdtCodeSelect').val('');
        $('#oetInvPdtNameSelect').val('');

        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

            var tUsrLevel     = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
            var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
            var nCountBch     = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
            let tWhere		     = "";

            if(tUsrLevel != "HQ"){
                tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
            }else{
                tWhere = "";
            }

            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oBranchBrowseMultiOption = undefined;
            oBranchBrowseMultiOption        = {
                Title: ['company/branch/branch','tBCHTitle'],
                Table:{Master:'TCNMBranch',PK:'FTBchCode'},
                Join :{
                    Table:	['TCNMBranch_L'],
                    On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
                },
                Where: {
                    Condition: [tWhere]
                },
                GrideView:{
                    ColumnPathLang  	: 'company/branch/branch',
                    ColumnKeyLang	    : ['tBCHCode','tBCHName'],
                    ColumnsSize         : ['15%','75%'],
                    WidthModal          : 50,
                    DataColumns		    : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                    DataColumnsFormat   : ['',''],
                    OrderBy			    : ['TCNMBranch.FDCreateOn DESC'],
                    Perpage: 10,
                },
                CallBack:{
                    ReturnType: 'S',
                    Value		: ['oetInvBchCodeSelect','TCNMBranch.FTBchCode'],
                    Text		: ['oetInvBchNameSelect','TCNMBranch_L.FTBchName']
                },
                NextFunc: {
                    FuncName: 'JSxChqConsNextFuncBrowseBch',
                    ArgReturn: ['FTBchCode','FTBchName']
                }
            };
            JCNxBrowseData('oBranchBrowseMultiOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    // =========================================== Event Browse Multi Branch ===========================================


    // =========================================== Event Browse Multi Branch ===========================================
    $('#obtInvMultiBrowseProduct').unbind().click(function(){
        // $('#oetInvWahStaSelectAll').val('');
        // $('#oetInvWahCodeSelect').val('');
        // $('#oetInvWahNameSelect').val('');

        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oProductBrowseMultiOptionInv = undefined;

            let tBchCodeSess = $('#oetInvBchCodeSelect').val();
            let tCondition ='';
            if(tBchCodeSess!=''){
                tCondition +=  " AND ( TCNMPdtSpcBch.FTBchCode = '"+tBchCodeSess+"' OR ( TCNMPdtSpcBch.FTBchCode IS NULL OR TCNMPdtSpcBch.FTBchCode ='' ) )";
            }

            let tAgnCode        = '<?php echo $this->session->userdata("tSesUsrAgnCode"); ?>';
            if( tAgnCode != '' ){
                tCondition += " AND TCNMPdtSpcBch.FTAgnCode = '"+tAgnCode+"' ";
            }

            oProductBrowseMultiOptionInv         = {
                Title : ['product/product/product','tPDTTitle'],
                Table:{Master:'TCNMPdt',PK:'FTPdtCode'},
                Join :{
                    Table:	['TCNMPdt_L','TCNMPdtSpcBch'],
                    On:[
                        'TCNMPdt_L.FTPdtCode = TCNMPdt.FTPdtCode AND TCNMPdt_L.FNLngID = '+nLangEdits,
                        'TCNMPdtSpcBch.FTPdtCode = TCNMPdt.FTPdtCode'
                        ]
                }, 
                Where:{
                        Condition : [tCondition]
                },
                GrideView:{
                    ColumnPathLang	: 'product/product/product',
                    ColumnKeyLang	: ['tPDTCode','tPDTName'],
                    ColumnsSize     : ['10%','75%'],
                    WidthModal      : 50,
                    DataColumns		: ['TCNMPdt.FTPdtCode','TCNMPdt_L.FTPdtName'],
                    DataColumnsFormat : ['',''],
                    Perpage			: 10,
                    OrderBy			: ['TCNMPdt.FDCreateOn DESC'],
                    // SourceOrder		: "ASC"
                },
                CallBack:{
                    StaSingItem : '1',
                    ReturnType	: 'M',
                    Value		: ['oetInvPdtCodeSelect',"TCNMPdt.FTPdtCode"],
                    Text		: ['oetInvPdtNameSelect',"TCNMPdt_L.FTPdtName"],
                },
                BrowseLev : 1
            }
            JCNxBrowseData('oProductBrowseMultiOptionInv');


            $('#obtInvMultiBrowseProduct').attr("disabled", false);
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    // =========================================== Event Browse Multi Branch ===========================================


    // =========================================== Event Browse Multi WaHouse ===========================================
    $('#obtInvMultiBrowseWaHouse').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        let tBchcode    = $('#oetInvBchCodeSelect').val();
        let tShpcode    = $('#oetMmtShpCodeSelect').val();

        let tTable      = "TCNMWaHouse";   

        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oWaHouseBrowseMultiOption = undefined;
            tWahWherWah                = "";
            
            if(tBchcode != ""){
                tTable  = "TCNMWaHouse";
                tBchcode = tBchcode.replace(/,/g, "','");
                tWahWherWah = "AND TCNMWaHouse.FTBchCode  IN ('"+tBchcode+"') ";
            }

            // if(tShpcode != ""){
            //     tTable                      = "TCNMShpWah";
            //     tShpcode = tShpcode.replace(/,/g, "','");
            //     tWahWherWah                = "AND TCNMShpWah.FTShpCode  IN ('"+tShpcode+"') ";
            // }

            var tOrderBy    = tTable + ".FDCreateOn DESC";

            oWaHouseBrowseMultiOption        = {
                Title: ['company/warehouse/warehouse','tWAHSubTitle'],
                Table:{Master:tTable,PK:'FTWahCode'},
                Join :{
                    Table:	['TCNMWaHouse_L', 'TCNMBranch_L'],
                    On:['TCNMWaHouse_L.FTWahCode = "'+tTable+'".FTWahCode AND "'+tTable+'".FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = '+nLangEdits,
                        'TCNMBranch_L.FTBchCode = "'+tTable+'".FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
                },
                Where :{
                    Condition : [tWahWherWah]
                },
                GrideView:{
                    ColumnPathLang  	: 'company/warehouse/warehouse',
                    ColumnKeyLang	    : ['tWahCode','tWahName'],
                    ColumnsSize         : ['25%', '50%'],
                    WidthModal          : 50,
                    DataColumns		    : [ '"'+tTable+'".FTWahCode','TCNMWaHouse_L.FTWahName'],
                    DataColumnsFormat   : ['',''],
                    OrderBy			    : [ tOrderBy, 'TCNMBranch_L.FTBchName ASC, TCNMWaHouse_L.FTWahCode ASC'],
                    Perpage             : 10,
                },
                CallBack:{
                    StausAll    : ['oetInvWahStaSelectAll'],
                    Value		: ['oetInvWahCodeSelect','"'+tTable+'".FTWahCode'],
                    Text		: ['oetInvWahNameSelect','TCNMWaHouse_L.FTWahName']
                }
            };
            JCNxBrowseMultiSelect('oWaHouseBrowseMultiOption');
            $('#obtInvMultiBrowseWaHouse').attr("disabled", false);
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    // =========================================== Event Browse Multi WaHouse ===========================================



</script>