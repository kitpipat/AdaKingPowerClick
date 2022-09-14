<script type="text/javascript">

    $(document).ready(function(){
        $('.selectpicker').selectpicker('refresh');

        /** ================== Check Box Auto GenCode ===================== */
        $('#ocbPriRntLkAutoGenCode').on('change', function (e) {
            if($('#ocbPriRntLkAutoGenCode').is(':checked')){
                $("#oetPriRntLkRthCode").val('');
                $("#oetPriRntLkRthCode").attr("readonly", true);
                $('#oetPriRntLkRthCode').closest(".form-group").css("cursor","not-allowed");
                $('#oetPriRntLkRthCode').css("pointer-events","none");
                $("#oetPriRntLkRthCode").attr("onfocus", "this.blur()");
                // Remove HD Validate
                $('#ofmPriRntLkFormHDAdd').removeClass('has-error');
                $('#ofmPriRntLkFormHDAdd .form-group').closest('.form-group').removeClass("has-error");
                $('#ofmPriRntLkFormHDAdd em').remove();
                 // Remove DT Validate
                $('#ofmPriRntLkFormDTAdd').removeClass('has-error');
                $('#ofmPriRntLkFormDTAdd .form-group').closest('.form-group').removeClass("has-error");
                $('#ofmPriRntLkFormDTAdd em').remove();
            }else{
                $('#oetPriRntLkRthCode').closest(".form-group").css("cursor","");
                $('#oetPriRntLkRthCode').css("pointer-events","");
                $('#oetPriRntLkRthCode').attr('readonly',false);
                $("#oetPriRntLkRthCode").removeAttr("onfocus");
            }
        });

        /** ======================== Event Add DT ========================= */
        $('#obtPriRntLkAddDataDT').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof nStaSession !== "undefined" && nStaSession == 1){
                JSxPriceRentLockerValidateFromAddDT();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
    });

    //Functionality: Validate From Add DT
    //Parameters: Event Select List Branch
    //Creator: 08/07/2019 wasin (AKA: MR.JW)
    //Return: Duplicate/none
    //Return Type: string
    function JSxPriceRentLockerValidateFromAddDT(){
        $('#ofmPriRntLkFormDTAdd').validate({
            rules: {
                ocmPriRntLkRtdTmeType   : {"required" : true},
                oenPriRntLkRtdMinQty    : {
                    "required"  : true,
                    "min"       : 1,
                },
                oetPriRntLkRtdPrice     : {"required" : true},
            },
            messages: {
                ocmPriRntLkRtdTmeType   : {"required"  : $('#ocmPriRntLkRtdTmeType').attr('data-validate-required')},
                oenPriRntLkRtdMinQty    : {
                    "required"  : $('#oenPriRntLkRtdMinQty').attr('data-validate-required'),
                    "min"       : $('#oenPriRntLkRtdMinQty').attr('data-validate-zero')
                },
                oetPriRntLkRtdPrice     : {
                    "required"  : $('#oetPriRntLkRtdPrice').attr('data-validate-required'),
                },
            },
            errorElement: "em",
            errorPlacement: function (error, element) {
                error.addClass("help-block");
                if(element.prop("type") === "checkbox") {
                    error.appendTo(element.parent("label"));
                }else{
                    var tCheck  = $(element.closest('.form-group')).find('.help-block').length;
                    if(tCheck == 0) {
                        error.appendTo(element.closest('.form-group')).trigger('change');
                    }
                }
            },
            highlight: function (element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-error");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).closest('.form-group').removeClass("has-error");
            },
            submitHandler: function (form){
                JSxPriceRentLockerAddDataDTInTbl();
            }
        });
        $('#ofmPriRntLkFormDTAdd').submit();
    }

    //Functionality: ฟังก์ชั่น Render Tr Template
    //Parameters: Event Select List Branch
    //Creator: 08/07/2019 wasin (AKA: MR.JW)
    //Return: Duplicate/none
    //Return Type: string
    function JStPriRntLkRenderTemplate(ptTemplate,poDataRender){
        String.prototype.fmt    = function (hash) {
            let tString = this, nKey; 
            for(nKey in hash){
                tString = tString.replace(new RegExp('\\{' + nKey + '\\}', 'gm'), hash[nKey]); 
            }
            return tString;
        };
        let tRender = "";
        tRender = ptTemplate.fmt(poDataRender);
        return tRender;
    }

    //Functionality: Validate From Add DT
    //Parameters: Event Select List Branch
    //Creator: 08/07/2019 wasin (AKA: MR.JW)
    //Return: Duplicate/none
    //Return Type: string
    function JSxPriceRentLockerAddDataDTInTbl(){
        var tPriRntLkDocNo              = $('#oetPriRntLkRthCode').val();
        var tPriRntLkRtdTmeType         = $('#ocmPriRntLkRtdTmeType').val();
        var nPriRntLkRtdMinQty          = $('#oenPriRntLkRtdMinQty').val();
        var nPriRntLkRtdPrice           = $('#oetPriRntLkRtdPrice').val();
        var tCountDataInTbl             = $('#otbPriRntLkTabelDataDT tbody .xCNPriRntLkItem').length;
        var tSeqNo                      = tCountDataInTbl+1;
        var tPriRntLkRtdTmeTypeName     = "";
        
        // เช็ค ประเภทการให้เช่า 
        switch(tPriRntLkRtdTmeType){
            case '1' :
                tPriRntLkRtdTmeTypeName = "<?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkRtdTmeType1');?>";
            break;
            case '2' :
                tPriRntLkRtdTmeTypeName = "<?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkRtdTmeType2');?>";
            break;
            case '3' :
                tPriRntLkRtdTmeTypeName = "<?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkRtdTmeType3');?>";
            break;
            case '4' :
                tPriRntLkRtdTmeTypeName = "<?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkRtdTmeType4');?>";
            break;
            case '5' :
                tPriRntLkRtdTmeTypeName = "<?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkRtdTmeType5');?>";
            break;
        }

        var tTemplateTr = $("#oscPriRntLkTemplateTr").html();
        var oDataRender = {
            'tPriRntLkRtdSeqNo'         : tSeqNo,
            'tPriRntLkRtdDocNo'         : tPriRntLkDocNo,
            'tPriRntLkRtdTmeType'       : tPriRntLkRtdTmeType,
            'tPriRntLkRtdMinQty'        : nPriRntLkRtdMinQty,
            'tPriRntLkRtdPrice'         : nPriRntLkRtdPrice,
            'tPriRntLkRtdTmeTypeName'   : tPriRntLkRtdTmeTypeName
        };
        var tPriRntLkRenderTr   = JStPriRntLkRenderTemplate(tTemplateTr,oDataRender);

        $('#ocmPriRntLkRtdTmeType').val(tPriRntLkRtdTmeType).prop("disabled",true);
        $('#ocmPriRntLkRtdTmeType').selectpicker('refresh');
        $('#otbPriRntLkTabelDataDT .xWPriRntLkTextNotfoundDataDT').parent().remove();
        $('#otbPriRntLkTabelDataDT tbody').append(tPriRntLkRenderTr);

        JSxPriRntLkCalMinDataDT();

        $('#oenPriRntLkRtdMinQty').val('');
        $('#oetPriRntLkRtdPrice').val('');
        $('#oenPriRntLkRtdMinQty').focus();
    }

    //Functionality: ฟังกชั่นคำนวนจากหน่วย
    //Parameters: Event Select List Branch
    //Creator: 08/07/2019 wasin (AKA: MR.JW)
    //Return: Duplicate/none
    //Return Type: string
    function JSxPriRntLkCalMinDataDT(){
        var tCountDataInTbl = $('#otbPriRntLkTabelDataDT tbody .xCNPriRntLkItem').length;
        if(tCountDataInTbl > 0){
            $('#otbPriRntLkTabelDataDT tbody .xCNPriRntLkItem').each(function(){
                var tPriRntLkIndex = $(this).data('index');
                if(typeof tPriRntLkIndex !== "undefined" && tPriRntLkIndex == 1){
                    var tDataCalMin = 1;
                    $(this).attr('data-calmin',tDataCalMin);
                    $(this).data('calmin',tDataCalmin);
                    $(this).find('.xWPriRntLkRtdCalMin label').text(tDataCalMin);
                }else{
                    var tDataCalmin         = "";
                    var tIndexParent        = tPriRntLkIndex-1;
                    var tDataMinQtyParent   = $(this).parents('.xWPriRntLkTableBody').find('tr[data-index="'+tIndexParent+'"]').data('minqty');
                    var tDataCalMinParent   = $(this).parents('.xWPriRntLkTableBody').find('tr[data-index="'+tIndexParent+'"]').data('calmin');
                    tDataCalmin = parseInt(tDataMinQtyParent+tDataCalMinParent);
                    $(this).attr('data-calmin',tDataCalmin);
                    $(this).data('calmin',tDataCalmin);
                    $(this).find('.xWPriRntLkRtdCalMin label').text(tDataCalmin);
                }
            });
        }
    }

    //Functionality: ฟังกชั่นจัดเรียง Seq New
    //Parameters: Event Select List Branch
    //Creator: 08/07/2019 wasin (AKA: MR.JW)
    //Return: Duplicate/none
    //Return Type: string
    function JSxPriRntLkRenderNewSeq(){
        var tCountDataInTbl = $('#otbPriRntLkTabelDataDT tbody .xCNPriRntLkItem').length;
        if(tCountDataInTbl > 0){
            var nNewSeq = 1;
            $('#otbPriRntLkTabelDataDT tbody .xCNPriRntLkItem').each(function(){
                $(this).attr('data-index',nNewSeq);
                $(this).attr('data-seqno',nNewSeq);
                $(this).data('index',nNewSeq);
                $(this).data('seqno',nNewSeq);
                nNewSeq++;
            });
        }
    }

    //Functionality: ฟังก์ชั่น Delete Row Data DT
    //Parameters: Event Select List Branch
    //Creator: 08/07/2019 wasin (AKA: MR.JW)
    //Return: Duplicate/none
    //Return Type: string
    function JSnPriRntLkRemoveDocDTTempRow(event){
        $(event).parents('tr').remove();
        JSxPriRntLkRenderNewSeq();
        JSxPriRntLkCalMinDataDT();
        var tCountDataInTbl = $('#otbPriRntLkTabelDataDT tbody .xCNPriRntLkItem').length;
        if(tCountDataInTbl == '0'){
            var tGetTamplateNoDataDT = $('#oscPriRntLkNoDataInTableDT').html();
            $('#otbPriRntLkTabelDataDT .xWPriRntLkTableBody').html(tGetTamplateNoDataDT);
            $('#ocmPriRntLkRtdTmeType').prop("disabled",false);
            $('#ocmPriRntLkRtdTmeType').selectpicker('refresh');
        }
    }

    //เลือกตัวแทนขาย
    var nLangEdits = <?php echo $this->session->userdata("tLangEdit");?>;
    $('#obtPrnBrowseAgency').off('click');
    $('#obtPrnBrowseAgency').on('click',function(){
        var nStaSession  = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPrnAgnOption        = undefined;
            oPrnAgnOption               = oPrnBrowseAgency({
                'tReturnInputCode'          : 'oetPrnAgnCode',
                'tReturnInputName'          : 'oetPrnAgnName',
                'tNextFuncName'             : 'JSxPrnNextFuncBrowseAgency',
                'aArgReturn'                : ['FTAgnCode','FTAgnName']
            });
            JCNxBrowseData('oPrnAgnOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oPrnBrowseAgency = function(poReturnInputAgency){
        let tInputReturnAgnCode   = poReturnInputAgency.tReturnInputCode;
        let tInputReturnAgnName   = poReturnInputAgency.tReturnInputName;
        let tAgencyNextFunc       = poReturnInputAgency.tNextFuncName;
        let aAgencyArgReturn      = poReturnInputAgency.aArgReturn;

        let oAgencyOptionReturn = {
            Title : ['authen/user/user','tBrowseAgnTitle'],
            Table :{Master:'TCNMAgency',PK:'FTAgnCode'},
            Join :{
                Table:	['TCNMAgency_L'],
                On:[' TCNMAgency.FTAgnCode = TCNMAgency_L.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits]
            },
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

    //หลังจากเลือก AGN
    function JSxSPLNextFuncBrowseAgency(){
        //ไม่ทำอะไร
    }


</script>