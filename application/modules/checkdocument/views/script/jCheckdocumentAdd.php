<script type="text/javascript">
        // Click Browse Agency
        $('#oimMNTBrowseAgn').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oMntPdtBrowseAgencyOption = oMntPdtBrowseAgency({
                'tReturnInputCode': 'oetMNTAgnCode',
                'tReturnInputName': 'oetMNTAgnName'
            });
            JCNxBrowseData('oMntPdtBrowseAgencyOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });


    // Click Browse Branch
    $('#oimMNTBrowseBch').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oMntPdtBrowseBranchOption = oMntPdtBrowseBranch({
                'tReturnInputCode': 'oetMntInBcnCode',
                'tReturnInputName': 'oetMntInBcnName',
                'tAgnCodeWhere': $('#oetMNTAgnCode').val(),
            });
            JCNxBrowseData('oMntPdtBrowseBranchOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    

    //เลือกสาขา
    var oMntPdtBrowseAgency = function(poReturnInput) {
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
            NextFunc: {
                FuncName: 'JSxMntClearBrowseConditionAgn',
            },
            BrowseLev : 1
        }
        return oOptionReturn;
    }

   //เลือกสาขา
   var oMntPdtBrowseBranch = function(poReturnInput) {
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
            BrowseLev : 1
        }
        return oOptionReturn;
    }


    function JSxMntClearBrowseConditionAgn(){
        $('#oetMntInBcnCode').val('');
        $('#oetMntInBcnName').val('');
    }


    /*
    * Functionality : Crete Array javascript
    * Parameters : 
    * Creator : 13/02/2020 nattakit(nale)
    * Last Modified : -
    * Return : -
    * Return Type : -
    */  

    function JSxCreateArray(length) {
    var arr = new Array(length || 0),
        i = length;

    if (arguments.length > 1) {
        var args = Array.prototype.slice.call(arguments, 1);
        while(i--) arr[length-1 - i] = JSxCreateArray.apply(this, args);
    }

    return arr;
    }   

$('#obtCPHBrowseAgnTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oMntAgencyOptionTo   = undefined;
            oMntAgencyOptionTo          = oMntAgencyOption({
                'tReturnInputCode'  : 'oetMntAgnCodeTo',
                'tReturnInputName'  : 'oetMntAgnNameTo',
        
            });
            JCNxBrowseData('oMntAgencyOptionTo');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });


$('#obtMntBrowseBchTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oMntBranchOptionTo   = undefined;
            oMntBranchOptionTo          = oMntBranchOption({
                'tReturnInputCode'  : 'oetMntBchCodeTo',
                'tReturnInputName'  : 'oetMntBchNameTo',
                'tNextFuncName'     : 'JSxMntConsNextFuncBrowseBch',
            });
            JCNxBrowseData('oMntBranchOptionTo');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });


    
          
    //เลือกสาขา
    var oMntAgencyOption = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;
        var tBchCodeWhere = poReturnInput.tBchCodeWhere;

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
            BrowseLev: 0,
            NextFunc: {
                FuncName: 'JSxClearBrowseConditionAgn',
                ArgReturn: ['FTAgnCode']
            }
        }
        return oOptionReturn;
    }

    function JSxClearBrowseConditionAgn(ptData) {
        // aData = JSON.parse(ptData);
        if (ptData != '' || ptData != 'NULL') {

            $('#oetMntBchCodeTo').val('');
            $('#oetMntBchNameTo').val('');

        }
    }



      /*===== Begin Browse Option ======================================================= */
      var oMntBranchOption = function(poMntReturnInputBch){
        let tMntNextFuncNameBch    = poMntReturnInputBch.tNextFuncName;
        let aMntArgReturnBch       = poMntReturnInputBch.aArgReturn;
        let tMntInputReturnCodeBch = poMntReturnInputBch.tReturnInputCode;
        let tMntInputReturnNameBch = poMntReturnInputBch.tReturnInputName;

        var tUsrLevel     = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
        var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        var nCountBch     = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
        var tMerCode = $('#oetMntMerCodeTo').val();
        var tWhere = "";

        // if(nCountBch == 1){
        //     $('#obtMntBrowseBchTo').attr('disabled',true);
        // }
        // if(tUsrLevel != "HQ"){
        //     tWhere += " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
        // }else{
        //     tWhere += "";
        // }

       var tMntAgnCodeTo =  $('#oetMntAgnCodeTo').val();
       if(tMntAgnCodeTo!=''){
             tWhere += " AND TCNMBranch.FTAgnCode ='"+tMntAgnCodeTo+"' ";
       }
        // if(tMerCode!=''){
        //     tWhere += " AND TCNMBranch.FTMerCode = '"+tMerCode+"' ";
        // }

        let oMntOptionReturnBch    = {
            Title: ['company/branch/branch','tBCHTitle'],
            Table:{Master:'TCNMBranch',PK:'FTBchCode'},
            Join :{
                Table:	['TCNMBranch_L'],
                On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
            },
            Where : {
                        Condition : [tWhere]
                    },
            GrideView:{
                ColumnPathLang	: 'company/branch/branch',
                ColumnKeyLang	: ['tBCHCode','tBCHName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TCNMBranch_L.FTBchCode ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tMntInputReturnCodeBch,"TCNMBranch.FTBchCode"],
                Text		: [tMntInputReturnNameBch,"TCNMBranch_L.FTBchName"]
            },
            RouteAddNew: 'branch',
            BrowseLev: 0
        };
        return oMntOptionReturnBch;
    };


    $('#obtTabConditionChkDocHDCRBch').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                $('#oetMntBchCodeTo').val('');
                $('#oetMntBchNameTo').val('');
                $("#odvMntConditionChkDocCRModalBch").modal({backdrop: "static", keyboard: false});
                $("#odvMntConditionChkDocCRModalBch").modal({show: true});
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    $('#obtMntCreateBch').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxMNTConsAppendRowAndCheckDuplicateDataBch();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });



          /*===== Begin Event Next Function Browse ========================================== */
    // Functionality : 
    // Parameter : Event Next Func Modal
    // Create : 11/02/2020 Nattakit(Nale)
    // Return : Set Element And value
    // Return Type : -
    function JSxMNTConsAppendRowAndCheckDuplicateDataBch(){
        // แจ้งนัด ประชุม Sit Ext ทีม FitAuto คืนนี้เวลา 20.00 น ตามเวลาประเทศไทย
        var tSesUsrLevel = '<?=$this->session->userdata("tSesUsrLevel")?>';

        if(tSesUsrLevel=='HQ'){ //กรณีเป็นผู้ใช้ AD
            var tValidateElement =  $('#oetMntAgnCodeTo').val();
        }else{
            var tValidateElement =  $('#oetMntBchCodeTo').val();
        }
        // alert(tValidateElement);
        if($('#oetMntAgnCodeTo').val()!='' || $('#oetMntBchCodeTo').val() != "NULL"){
            let nMntBchModalType = $('#ocmMntBchModalType').val();
            var tMntBchModalTypeText = $("#ocmMntBchModalType option:selected").html();
            let tMntAgnCodeTo      = $('#oetMntAgnCodeTo').val();
            let tMntAgnNameTo      = $('#oetMntAgnNameTo').val();
            let tMntBchCodeTo      = $('#oetMntBchCodeTo').val();
            let tMntBchNameTo      = $('#oetMntBchNameTo').val();
            // console.log(aData);
            let aDataApr = { 
                        tMntAgnCodeTo:tMntAgnCodeTo,
                        tMntAgnNameTo:tMntAgnNameTo,
                        tMntBchCodeTo:tMntBchCodeTo,
                        tMntBchNameTo:tMntBchNameTo,
                        }

        let nAproveSta = JSnMntConditionChkDocBchDuplicate(aDataApr);
        let nLenIn = $('input[name^="ohdMntConditionChkDocBchCode["]').length + 1;
        if(nAproveSta==0){
            $('#otrRemoveTrBch').remove();
        var tMarkUp =  '';
        var i = Date.now();
        tMarkUp +="<tr class='otrInclude' id='otrMntBchRowID"+i+"'>";
                    tMarkUp +="<td align='center' class='otdColRowID_Bch' >"+nLenIn+"</td>";
                    tMarkUp +="<td >"+tMntBchModalTypeText+"</td>";
                    tMarkUp +="<td>";
                    tMarkUp +="<input type='hidden' name='ohdMntConditionChkDocAgnCode["+i+"]' class='ohdMntConditionChkDocAgnCode' tMntAgnName='"+aDataApr.tMntAgnNameTo+"' value='"+aDataApr.tMntAgnCodeTo+"'>";
                    tMarkUp +="<input type='hidden' name='ohdMntConditionChkDocBchCode["+i+"]' class='ohdMntConditionChkDocBchCode' tMntBchName='"+aDataApr.tMntBchNameTo+"' value='"+aDataApr.tMntBchCodeTo+"'>";
                    tMarkUp +="<input type='hidden' name='ohdMntBchModalType["+i+"]' class='ohdMntBchModalType' value='"+nMntBchModalType+"'>";
                    tMarkUp +=aDataApr.tMntAgnNameTo+"</td>";
                    tMarkUp +="<td>"+aDataApr.tMntBchNameTo+"</td>";
                    tMarkUp +="<td align='center'><img onclick='JSxMntBchRemoveRow("+i+")' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>";
                    tMarkUp +="</tr>";

                $('#otbConditionChkDocHDCRBch').append(tMarkUp);
                $('#odvMntConditionChkDocCRModalBch').modal('hide');
            }else{

            alert('Data Select Duplicate.');

            }

            }else{

                alert('กรุณาเลือกเงื่อนไข');

            }
    }


    function JSnMntConditionChkDocBchDuplicate(paData){


        let nLenIn = $('input[name^="ohdMntConditionChkDocBchCode["]').length
        let aEchDataIn = JSxCreateArray(nLenIn,2);
        //Include
        $('input[name^="ohdMntConditionChkDocAgnCode["]').each(function(index){
            let tAgnCode = $(this).val();
            aEchDataIn[index][0]=tAgnCode;
        });
        $('input[name^="ohdMntConditionChkDocBchCode["]').each(function(index){
            let tBchCode = $(this).val();
            aEchDataIn[index][1]=tBchCode;
        });



        // console.log("aEchDataIn",aEchDataIn);
        // console.log("aEchDataEx",aEchDataEx);

        let nAproveAppend = 0;
        for(i=0;i<aEchDataIn.length;i++){
            if(aEchDataIn[i][0]==paData.tMntAgnCodeTo && aEchDataIn[i][1]==paData.tMntBchCodeTo){
                nAproveAppend++;
            }
        }

        // console.log(nAproveAppend);
        return nAproveAppend;
    }

    function JSxMntBchRemoveRow(ptCode){

        $('#otrMntBchRowID'+ptCode).remove();

        $('.otdColRowID_Bch').each(function(index){

        $(this).text(index+1);

        });


    }

</script>