<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script type="text/javascript">
    var nLangEdits      = '<?php echo $this->session->userdata("tLangEdit");?>';
    var tUsrApvName     = '<?php echo $this->session->userdata("tSesUsername");?>';
    var tSesUsrLevel    = '<?php echo $this->session->userdata('tSesUsrLevel');?>';
    var tUsrBchCode     = '<?php  echo $this->session->userdata("tSesUsrBchCodeDefault"); ?>';
    var tUsrBchName     = '<?php  echo $this->session->userdata("tSesUsrBchNameDefault"); ?>';

    $(document).ready(function () {
        // ตรวจสอบระดับUser banchFrom  24/03/2020 Saharat(Golf)
        if(tUsrBchCode  != ""){ 
            $('#oetBchCodeFrom').val(tUsrBchCode);
            $('#oetBchNameFrom').val(tUsrBchName);
        }

        // ระดับUser banchTo  24/03/2020 Saharat(Golf)
        if(tUsrBchCode  != ""){ 
            $('#oetBchCodeTo').val(tUsrBchCode);
            $('#oetBchNameTo').val(tUsrBchName);
        }

        $('#obtRDHCallBackPage').hide();
        $('#odvRDHBtnGrpSave').hide(); 
        $('.next-step').show();
        $('.olbTab_step').css('color',"#e0e0e0");
        $('#olbTab_step1').css('color','#1D2530');

        $('.nav-tabs > li a[title]').tooltip();
        
        //Wizard
        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

            $("#obtRDHApproveDoc").hide();
            $("#obtRDHCancelDoc").hide();
            $('#odvRDHBtnGrpSave').hide();
            let target = $(e.target);
            let nStep = target.attr('step');

            var nRedeemType = $('#ocmRDHDocType').val();
            if(nRedeemType==1){
                $('.othColumDelete').hide();
            }else{
                $('.othColumDelete').show();
            }

            if(nStep=='1' && nRedeemType=='1'){
                $('#ocmRDHDocType').attr('disabled',false);
            }

            if(nStep=='2' && nRedeemType=='2'){
                $('#ocmRDHDocType').attr('disabled',false);
            }

            if(target.parent().hasClass('disabled')) {
                return false;
            }
        
            if(nStep=='4'){
                //========กณรณีเป็น User ระดับสาขาต้องขึ้นให้เลือกสาขาที่มีผล=======//
                if(tSesUsrLevel!='HQ'){
                    var nCheckBchCodeSelect = 0;
                    if($('#ohdRDHUsrIsAgnLevel').val()==1){
                        $('.ohdRddConditionRedeemAgnCode').each(function(){
                            if($(this).val()!=''){
                                nCheckBchCodeSelect++;
                            }
                        });
                    }else{
                        $('.ohdRddConditionRedeemBchCode').each(function(){
                            if($(this).val()!=''){
                                nCheckBchCodeSelect++;
                            }
                        });
                    }

                    if(nCheckBchCodeSelect==0){
                        $('#oetRddBchCodeTo').val('');
                        $('#oetRddBchNameTo').val('');
                        $('#oetRddMerCodeTo').val('');
                        $('#oetRddMerNameTo').val('');
                        $('#oetRddShpCodeTo').val('');
                        $('#oetRddShpNameTo').val('');
                        $("#odvRddConditionRedeemCRModalBch").modal({backdrop: "static", keyboard: false});
                        $("#odvRddConditionRedeemCRModalBch").modal({show: true});
                        return false;
                    }
                }
                //===============================================//
                
                JSxRddPdtGroupPageFinal();
                $('.next-step').hide();
                $('#odvRDHBtnGrpSave').show();

                // Check สถานะอนุมัติ
                var nRDHStaDoc      = $("#ohdRDHStaDoc").val();
                var nRDHStaApv      = $("#ohdRDHStaApv").val();
                var tRDHStaPrcDoc   = $('#ohdRDHStaPrcDoc').val();
                let tCouponSetupPage = $('#ohdRDHRouteEvent').val();
                if(nRDHStaDoc == 1 && nRDHStaApv == 1 && tRDHStaPrcDoc == 1){
                    $('#odvRDHBtnGrpSave').hide();
                }
            }else{
                $('.next-step').show();
                $('#odvRDHBtnGrpSave').hide();
            }
            
            $('#ohdRDHNowTab').val(nStep);
            $('.oliTab_step').addClass('disabled');
            if($("#ocmRDHDocType").val() == '1'){
                if(nStep == '1'){
                    $('#ospTab_step1').css( "background-color", "#fff" );
                    $('#ospTab_step2').css( "background-color", "#d6d6d6" );
                    $('#ospTab_step3').css( "background-color", "#d6d6d6" );
                    $('#ospTab_step4').css( "background-color", "#d6d6d6" );

                    $('#ospTab_step1').css('border', '2px solid #000');
                    $('#ospTab_step2').css('border', '2px solid #d6d6d6');
                    $('#ospTab_step3').css('border', '2px solid #d6d6d6');
                    $('#ospTab_step4').css('border', '2px solid #d6d6d6');

                    $('.xWPromotionLine').css( "border-bottom","2px solid transparent" );
                    $('.xWPromotionLine').css( "border-image","linear-gradient(to right, black 0%, #d6d6d6 0% 40%)" );
                    $('.xWPromotionLine').css( "border-image-slice","1" );
                }

                if(nStep == '2'){
                    $('#ospTab_step1').css( "background-color", "#000" );
                    $('#ospTab_step2').css( "background-color", "#fff" );
                    $('#ospTab_step3').css( "background-color", "#d6d6d6" );
                    $('#ospTab_step4').css( "background-color", "#d6d6d6" );

                    $('#ospTab_step1').css('border', '2px solid #000');
                    $('#ospTab_step2').css('border', '2px solid #000');
                    $('#ospTab_step3').css('border', '2px solid #d6d6d6');
                    $('#ospTab_step4').css('border', '2px solid #d6d6d6');

                    $('.xWPromotionLine').css( "border-bottom","2px solid transparent" );
                    $('.xWPromotionLine').css( "border-image","linear-gradient(to right, black 33%, #d6d6d6 20% 40%)" );
                    $('.xWPromotionLine').css( "border-image-slice","1" );
                }

                if(nStep == '3'){
                    $('#ospTab_step1').css( "background-color", "#000" );
                    $('#ospTab_step2').css( "background-color", "#000" );
                    $('#ospTab_step3').css( "background-color", "#fff" );
                    $('#ospTab_step4').css( "background-color", "#d6d6d6" );

                    $('#ospTab_step1').css('border', '2px solid #000');
                    $('#ospTab_step2').css('border', '2px solid #000');
                    $('#ospTab_step3').css('border', '2px solid #000');
                    $('#ospTab_step4').css('border', '2px solid #d6d6d6');

                    $('.xWPromotionLine').css( "border-bottom","2px solid transparent" );
                    $('.xWPromotionLine').css( "border-image","linear-gradient(to right, black 65%, #d6d6d6 20% 40%)" );
                    $('.xWPromotionLine').css( "border-image-slice","1" );
                }

                if(nStep == '4'){
                    $('#ospTab_step1').css( "background-color", "#000" );
                    $('#ospTab_step2').css( "background-color", "#000" );
                    $('#ospTab_step3').css( "background-color", "#000" );
                    $('#ospTab_step4').css( "background-color", "#fff" );

                    $('#ospTab_step1').css('border', '2px solid #000');
                    $('#ospTab_step2').css('border', '2px solid #000');
                    $('#ospTab_step3').css('border', '2px solid #000');
                    $('#ospTab_step4').css('border', '2px solid #000');

                    $('.xWPromotionLine').css( "border-bottom","2px solid transparent" );
                    $('.xWPromotionLine').css( "border-image","linear-gradient(to right, black 100%, #d6d6d6 20% 40%)" );
                    $('.xWPromotionLine').css( "border-image-slice","1" );
                }
            }else{
                if(nStep == '2'){
                    $('#ospTab_step2').css( "background-color", "#fff" );
                    $('#ospTab_step3').css( "background-color", "#d6d6d6" );
                    $('#ospTab_step4').css( "background-color", "#d6d6d6" );

                    $('#ospTab_step2').css('border', '2px solid #000');
                    $('#ospTab_step3').css('border', '2px solid #d6d6d6');
                    $('#ospTab_step4').css('border', '2px solid #d6d6d6');

                    $('.xWPromotionLine').css( "border-bottom","2px solid transparent" );
                    $('.xWPromotionLine').css( "border-image","linear-gradient(to right, black 0%, #d6d6d6 0% 40%)" );
                    $('.xWPromotionLine').css( "border-image-slice","1" );
                }

                if(nStep == '3'){
                    $('#ospTab_step2').css( "background-color", "#000" );
                    $('#ospTab_step3').css( "background-color", "#fff" );
                    $('#ospTab_step4').css( "background-color", "#d6d6d6" );

                    $('#ospTab_step2').css('border', '2px solid #000');
                    $('#ospTab_step3').css('border', '2px solid #000');
                    $('#ospTab_step4').css('border', '2px solid #d6d6d6');

                    $('.xWPromotionLine').css( "border-bottom","2px solid transparent" );
                    $('.xWPromotionLine').css( "border-image","linear-gradient(to right, black 46%, #d6d6d6 20% 40%)" );
                    $('.xWPromotionLine').css( "border-image-slice","1" );
                }

                if(nStep == '4'){
                    $('#ospTab_step2').css( "background-color", "#000" );
                    $('#ospTab_step3').css( "background-color", "#000" );
                    $('#ospTab_step4').css( "background-color", "#fff" );

                    $('#ospTab_step2').css('border', '2px solid #000');
                    $('#ospTab_step3').css('border', '2px solid #000');
                    $('#ospTab_step4').css('border', '2px solid #000');

                    $('.xWPromotionLine').css( "border-bottom","2px solid transparent" );
                    $('.xWPromotionLine').css( "border-image","linear-gradient(to right, black 100%, #d6d6d6 20% 40%)" );
                    $('.xWPromotionLine').css( "border-image-slice","1" );
                }            
            }

            $('.olbTab_step').css('color',"#e0e0e0");
            $('#olbTab_step'+nStep).css('color','#1D2530');
            for(i=1;i<=nStep;i++){
                $('#oliTab_step'+i).removeClass('disabled');
            }
        });

        $('#oetRDHFrmRDHStaClosed').unbind().click(function(){
            var nRDHStaDoc      = $("#ohdRDHStaDoc").val();
            var nRDHStaApv      = $("#ohdRDHStaApv").val();
            if(nRDHStaDoc == 1 && nRDHStaApv == 1){
                if(confirm('คุณแน่ใจที่จะเปลี่ยนสถานะเอกสาร')==true){
                    JSxRDHChangStatusAfApv();
                }

            }
        });

        $('#oetRDHFrmRDHStaDocAct').unbind().click(function(){
            var nRDHStaDoc      = $("#ohdRDHStaDoc").val();
            var nRDHStaApv      = $("#ohdRDHStaApv").val();
            if(nRDHStaDoc == 1 && nRDHStaApv == 1){
                if(confirm('คุณแน่ใจที่จะเปลี่ยนสถานะเอกสาร')==true){
                    JSxRDHChangStatusAfApv();
                }

            }
        });

    });

    function JSxRDHChangStatusAfApv(){
        JCNxOpenLoading();
        // $('#oetRDHFrmRDHStaClosed').
        // console.log($('input[name="oetRDHFrmRDHStaClosed"]:checked').val());
        var nStaClosed = 0;
        if($('input[name="oetRDHFrmRDHStaClosed"]:checked').val()=='on'){
            nStaClosed = 1;
        }

        var nStaDocAct = 0;
        if($('input[name="oetRDHFrmRDHStaDocAct"]:checked').val()=='on'){
            nStaDocAct = 1;
        }
        var tRDHDocNo    = $("#oetRDHDocNo").val();
        var tBchCode        =  $('#ohdRDHUsrBchCode').val();
        $.ajax({
            type: "POST",
            url: "dcmRDHChangStatusAfApv",
            data: {
                nStaClosed  : nStaClosed,
                nStaDocAct  : nStaDocAct,
                tRDHDocNo   : tRDHDocNo,
                tBchCode    : tBchCode
            },
            cache: false,
            timeout: 0,
            success: function (oResult){
                var aReturnData = JSON.parse(oResult);
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    $('#ocmRDHDocType').unbind().change(function(){
        let nReDeemType = $(this).val();
        if(nReDeemType==1){

            JSvRDHLoadGroupListTable();
            $('#ohdRDHNowTab').val(1);
            $('#oliTab_step1').show();
            $('#step1').addClass('active');
            $('#step2').removeClass('active');
            $('#oliTab_step1').removeClass('disabled');
            $('#oliTab_step1').addClass('active');
            $('#oliTab_step2').addClass('disabled');
            $('#oliTab_step2').removeClass('active');
            $('#olbTab_step1').css('color','rgb(29, 37, 48)');
            $('#olbTab_step2').css('color','rgb(224, 224, 224)');
            $('.hideGrpNameColum').show();
            $('.othColumDelete').hide();
            $('.odvHideGroupNameCol').show();
            $('#obtTabConditionRedeemHDGrp').css('display','none');
            $('#ospRddWording1').show();
            $('#ospRddWording2').hide();

            $('#oliTab_step2').removeAttr('style');
            $('#oliTab_step3').removeAttr('style');
            $('#oliTab_step4').removeAttr('style');
            $('#oliTab_step2 a').css('right','68%');
            $('#olbTab_step4').css('margin-left','69%');

            $('.oliTab_step').addClass('disabled');
            $('.round-tab').css( "background-color", "#fff" );
            $('.olbTab_step').css('color',"#e0e0e0");
            // $('#olbTab_step'+1).css('color','#1D2530');
            // for(i=1;i<=1;i++){
            //     $('#oliTab_step'+i).removeClass('disabled');
            //     $('#ospTab_step'+i).css( "background-color", "#1D2530" );
            // }

            //แก้ไข CSS ตุ่มวิซาร์ด - supawat
            $('#oliTab_step2 a, #oliTab_step3 a, #oliTab_step4 a').css('margin-top','0px');
            $('#ospTab_step2, #ospTab_step3, #ospTab_step4').css("background-color", "#d6d6d6");
            $('#ospTab_step2, #ospTab_step3, #ospTab_step4').css('border', '2px solid #d6d6d6');
            $('#olbTab_step1').css("color", "#000");
        }else{
            $('#otbConditionRedeemHDPdtInclude').html('');
            $('#otbConditionRedeemHDGrp').html('');
            JSxRDHClearConditionRedeemTmp();
            $('#ohdRDHNowTab').val(2);
            $('#oliTab_step1').hide();
            $('#step1').removeClass('active');
            $('#step2').addClass('active');
            $('#oliTab_step1').addClass('disabled');
            $('#oliTab_step1').removeClass('active');
            $('#oliTab_step2').removeClass('disabled');
            $('#oliTab_step2').addClass('active');
            $('#oliTab_step2').css('width','7%');
            $('#oliTab_step2 a').css('right','81%');
            $('#oliTab_step3').css('width','49%');
            $('#oliTab_step3').css('left','8%');
            $('#oliTab_step4').css('left','0px');
            $('#oliTab_step4').css('width','44%');
            $('#olbTab_step4').css('margin-left','82%');
            $('#olbTab_step1').css('color','rgb(224, 224, 224)');
            $('#olbTab_step2').css('color','rgb(29, 37, 48)');
            $('.hideGrpNameColum').hide();
            $('.othColumDelete').show();
            $('.odvHideGroupNameCol').hide();
            $('#obtTabConditionRedeemHDGrp').css('display','block');
            $('#ospRddWording1').hide();
            $('#ospRddWording2').show();
            $('.oliTab_step').addClass('disabled');
            $('.round-tab').css( "background-color", "#fff" );
            $('.olbTab_step').css('color',"#e0e0e0");
            // $('#olbTab_step'+2).css('color','#1D2530');
            // for(i=1;i<=2;i++){
            //     $('#oliTab_step'+i).removeClass('disabled');
            //     $('#ospTab_step'+i).css( "background-color", "#1D2530" );
            // }

            //แก้ไข CSS ตุ่มวิซาร์ด - supawat
            $('#oliTab_step2 a, #oliTab_step3 a, #oliTab_step4 a').css('margin-top','-8px');
            $('#ospTab_step3, #ospTab_step4').css("background-color", "#d6d6d6");
            $('#ospTab_step3, #ospTab_step4').css('border', '2px solid #d6d6d6');
            $('#ospTab_step2').css('border', '2px solid #000');
            $('#olbTab_step2').css("color", "#000");
        }
    })

    $('#ostRDHFrmCphDisType').unbind().change(function(){
        var nValue = $(this).val();
        if(nValue==3){
    
        }else{
            $('#oetRDHHDCstPriCode').val('');
            $('#oetRDHHDCstPriName').val('');
        }
    });

    $('.selectpicker').selectpicker('refresh');

    $('.xCNMenuplus').unbind().click(function(){
        if($(this).hasClass('collapsed')){
            $('.xCNMenuplus').removeClass('collapsed').addClass('collapsed');
            $('.xCNMenuPanelData').removeClass('in');
        }
    }); 
    
    $('.xCNDatePicker').datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        enableOnReadonly: false,
        disableTouchKeyboard : true,
        autoclose: true
    });

    $('.xCNTimePicker').datetimepicker({
        format: 'HH:mm:ss'
    });

    // Event Click Date Start Coupon
    $('#obtRDHDocDate').unbind().click(function(){
        $('#oetRDHDocDate').datepicker('show');
    });

    // Event Click Date Stop Coupon
    $('#obtRDHDocTime').unbind().click(function(){
         $('#oetRDHDocTime').datetimepicker('show');
     });

    // Event Click Date Start Coupon
    $('#obtRDHFrmDateStart').unbind().click(function(){
        $('#oetRDHFrmRDHDateStart').datepicker('show');
    });

    // Event Click Date Stop Coupon
    $('#obtRDHFrmDateStop').unbind().click(function(){
        $('#oetRDHFrmRDHDateStop').datepicker('show');
    });


    /*===== Begin Browse Option ======================================================= */
    var oCHDCstPriOption = function(poReturnInputCstPri){
        let tNextFuncNameCstPri    = poReturnInputCstPri.tNextFuncName;
        let aArgReturnCstPri       = poReturnInputCstPri.aArgReturn;
        let tInputReturnCodeCstPri = poReturnInputCstPri.tReturnInputCode;
        let tInputReturnNameCstPri = poReturnInputCstPri.tReturnInputName;
        let oOptionReturnHDCstPri    = {
            Title: ['product/pdtpricelist/pdtpricelist','tPPLTitle'],
            Table:{Master:'TCNMPdtPriList',PK:'FTPplCode',PKName:'FTPplName'},
            Join :{
                Table:	['TCNMPdtPriList_L'],
                On:['TCNMPdtPriList_L.FTPplCode = TCNMPdtPriList.FTPplCode AND TCNMPdtPriList_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang	: 'product/pdtpricelist/pdtpricelist',
                ColumnKeyLang	: ['tPPLTBCode','tPPLTBName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMPdtPriList.FTPplCode','TCNMPdtPriList_L.FTPplName'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TCNMPdtPriList_L.FTPplCode ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCodeCstPri,"TCNMPdtPriList.FTPplCode"],
                Text		: [tInputReturnNameCstPri,"TCNMPdtPriList_L.FTPplName"]
            },
       
            RouteAddNew: 'pdtpricelist',
            BrowseLev: 0
        };
        return oOptionReturnHDCstPri;
    };

    // =========================================== Event Browse Multi Branch ===========================================
    $('#obtRDHBrowseHDCstPri').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRDHHDCstPriOptionFrom = undefined;
            oRDHHDCstPriOptionFrom        = oCHDCstPriOption({
                'tReturnInputCode'  : 'oetRDHHDCstPriCode',
                'tReturnInputName'  : 'oetRDHHDCstPriName',
                'tNextFuncName'     : '',
                'aArgReturn'        : ['FTPplCode','FTPplName']
            });
            JCNxBrowseData('oRDHHDCstPriOptionFrom');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Option Browse Coupon Type
    var oRDHBrowseCouponType    = function(poDataCPT){
        let tInputCPTReturnCode = poDataCPT.tReturnInputCode;
        let tInputCPTReturnName = poDataCPT.tReturnInputName;
        let oCPTOptionReturn    = {
            Title   : ['coupon/coupontype/coupontype','tCPTTitle'],
            Table   : {Master:'TFNMCouponType',PK:'FTCptCode'},
            Join    : {
                Table   : ['TFNMCouponType_L'],
                On      : ['TFNMCouponType.FTCptCode = TFNMCouponType_L.FTCptCode AND TFNMCouponType_L.FNLngID = '+nLangEdits]
            },
            Where : {
                Condition : [' AND (TFNMCouponType.FTCptStaUse = 1)']
            },
            GrideView : {
                ColumnPathLang	    : 'coupon/coupontype/coupontype',
                ColumnKeyLang	    : ['tCPTCode','tCPTName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns         : ['TFNMCouponType.FTCptCode','TFNMCouponType_L.FTCptName'],
                DataColumnsFormat   : ['',''],
                Perpage			    : 5,
                OrderBy			    : ['TFNMCouponType.FTCptCode ASC'],
            },
            CallBack : {
                ReturnType	: 'S',
                Value		: [tInputCPTReturnCode,"TFNMCouponType.FTCptCode"],
                Text		: [tInputCPTReturnName,"TFNMCouponType_L.FTCptName"],
            },
            RouteAddNew : 'coupontype',
            BrowseLev   : nRDHStaBrowseType,
        };
        return oCPTOptionReturn;
    }

    // Option Browse Product Price List
    var oRDHBrowsePdtPriListTo  = function(poDataPplTo){
        let tInputPplToReturnCode   = poDataPplTo.tReturnInputCode;
        let tInputPplToReturnName   = poDataPplTo.tReturnInputName;
        let oPplToOptionReturn      = {
            Title   : ['document/couponsetup/couponsetup','tRDHPplTitle'],
            Table   : {Master:'TCNMPdtPriList',PK:'FTPplCode'},
            Join    : {
                Table   : ['TCNMPdtPriList_L'],
                On      : ['TCNMPdtPriList.FTPplCode = TCNMPdtPriList_L.FTPplCode AND TCNMPdtPriList_L.FNLngID = '+nLangEdits]
            },
            GrideView: {
                ColumnPathLang	    : 'document/couponsetup/couponsetup',
                ColumnKeyLang	    : ['tRDHPplCode','tRDHPplName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns		    : ['TCNMPdtPriList.FTPplCode','TCNMPdtPriList_L.FTPplName'],
                DataColumnsFormat   : ['','',''],
                Perpage			    : 5,
                OrderBy			    : ['TCNMPdtPriList.FTPplCode ASC'],
            },
            CallBack : {
                ReturnType	: 'S',
                Value		: [tInputPplToReturnCode,"TCNMPdtPriList.FTPplCode"],
                Text		: [tInputPplToReturnName,"TCNMPdtPriList_L.FTPplName"],
            },
            RouteAddNew : 'productpricelist',
            BrowseLev   : 1,
        };
        return oPplToOptionReturn;
    }

    // Event Browse Coupon Type
    $('#obtRDHBrowseCouponType').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oRDHBrowseCouponTypeOption   = undefined;
            oRDHBrowseCouponTypeOption          = oRDHBrowseCouponType({
                'tReturnInputCode'  : 'oetRDHFrmCptCode',
                'tReturnInputName'  : 'oetRDHFrmCptName',
            });
            JCNxBrowseData('oRDHBrowseCouponTypeOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Product Price List
    $('#obtRDHBrowseCouponPriceGrpTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oRDHBrowsePdtPriListToOption = undefined;
            oRDHBrowsePdtPriListToOption        = oRDHBrowsePdtPriListTo({
                'tReturnInputCode'  : 'oetRDHFrmRDHPplToCode',
                'tReturnInputName'  : 'oetRDHFrmRDHPplToName',
            });
            JCNxBrowseData('oRDHBrowsePdtPriListToOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    
    $('#obtRDHAddCouponDT').unbind().click(function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            let tRDHTemplateModal   = $('#oscRDHTemplateModalCreate').html();
            $('#odvRDHAppendModalCreateHtml').html(tRDHTemplateModal);
            $('#odvRDHAppendModalCreateHtml #odvRDHFormAddCoupon').modal({backdrop: 'static', keyboard: false}) 
            $("#odvRDHAppendModalCreateHtml #odvRDHFormAddCoupon").modal('show');

            $('.xWRDHModalSelect').selectpicker('refresh');

            // Set Defult Div Show Data
            $('#odvRDHModalCouponTypeCreate1').show();
            $('#odvRDHModalCouponTypeCreate2').hide();
            $('#odvRDHModalInputCreateCoupon').hide();

            // Event Change นำเข้าคูปอง / สร้างคูปอง
            $('#ostRDHModalCouponTypeCreate').unbind().change(function(){
                // ล้างค่าข้อมูลเงื่อนไขในการสร้างคูปอง
                $('.xWRDHModalInputCreateCoupon input').val('');
                let nStaCouponTypeCreate    = $(this).val();
                if(nStaCouponTypeCreate == '1'){
                    $('#odvRDHModalCouponTypeCreate2').hide();
                    $('#odvRDHModalInputCreateCoupon').hide();
                    $('#odvRDHModalCouponTypeCreate1').show();
                    // แสดงปุ่มดาวน์โหลดแม่แบบ
                    $('#obtRDHModalDownloadTemplate').show();
                }else if(nStaCouponTypeCreate == '2'){
                    $('#odvRDHModalCouponTypeCreate1').hide();
                    $('#odvRDHModalInputCreateCoupon').show();
                    $('#odvRDHModalCouponTypeCreate2').show();

                    // Show Hide Input Codition Default
                    $('.xWRDHModalInputCreateCoupon').hide();
                    $('#odvRDHModalFormBarWidth').show();
                    $('#odvRDHModalFormBarStartCode').show();
                    $('#odvRDHModalFormBarQty').show();
                    $('#odvRDHModalFormBarHisQtyUse').show();
                    // ซ่อนปุ่มดาวน์โหลดแม่แบบ
                    $('#obtRDHModalDownloadTemplate').hide();
                }
                $('#ostRDHModalCouponTypeCreate').val(nStaCouponTypeCreate).selectpicker('refresh');
            });

            // Event Change สร้างคูปอง auto / customs
            $('#ostRDHModalCouponCreateMng').unbind().change(function(){
                // ล้างค่าข้อมูลเงื่อนไขในการสร้างคูปอง
                $('.xWRDHModalInputCreateCoupon input').val('');
                $('#odvRDHModalCouponTypeCreate1').hide();
                $('#odvRDHModalInputCreateCoupon').hide();
                $('#odvRDHModalCouponTypeCreate2').show();
                let nStaCouponCreateMng = $(this).val();
                if(nStaCouponCreateMng == '1'){
                    $('#odvRDHModalCouponCreateMng2').hide();
                    $('#odvRDHModalCouponCreateMng1').show();
                    
                    // Show Hide Input Codition Default
                    $('#odvRDHModalInputCreateCoupon').show();
                    $('.xWRDHModalInputCreateCoupon').hide();
                    $('#odvRDHModalFormBarWidth').show();
                    $('#odvRDHModalFormBarStartCode').show();
                    $('#odvRDHModalFormBarQty').show();
                    $('#odvRDHModalFormBarHisQtyUse').show();

                }else if(nStaCouponCreateMng == '2'){
                    $('#odvRDHModalCouponCreateMng1').hide();
                    $('#odvRDHModalCouponCreateMng2').show();

                    // Show Hide Input Codition Default
                    $('#odvRDHModalInputCreateCoupon').show();
                    $('.xWRDHModalInputCreateCoupon').hide();
                    $('#odvRDHModalFormCouponCode').show();
                    $('#odvRDHModalFormBarHisQtyUse').show();
                }
                $('#ostRDHModalCouponCreateMng').val(nStaCouponCreateMng).selectpicker('refresh');
            });

            // Event Change สร้างคูปอง auto ประเภทบาร์ฺโค๊ด
            $('#ostRDHModalCouponCreateMng1Bar').unbind().change(function(){
                // ล้างค่าข้อมูลเงื่อนไขในการสร้างคูปอง
                $('.xWRDHModalInputCreateCoupon input').val('');
                $('#odvRDHModalCouponTypeCreate1').hide();
                $('#odvRDHModalInputCreateCoupon').hide();
                $('#odvRDHModalCouponTypeCreate2').show();
                let nStaCouponCreateMng1Bar = $(this).val();
                switch(nStaCouponCreateMng1Bar){
                    case '1': {
                        // Show Hide Input Codition Default
                        $('#odvRDHModalInputCreateCoupon').show();
                        $('.xWRDHModalInputCreateCoupon').hide();
                        // Show Input Condition
                        $('#odvRDHModalFormBarWidth').show();
                        $('#odvRDHModalFormBarStartCode').show();
                        $('#odvRDHModalFormBarQty').show();
                        $('#odvRDHModalFormBarHisQtyUse').show();
                        break;
                    }
                    case '2': {
                        // Show Hide Input Codition Default
                        $('#odvRDHModalInputCreateCoupon').show();
                        $('.xWRDHModalInputCreateCoupon').hide();
                        // Show Input Condition
                        $('#odvRDHModalFormBarWidth').show();
                        $('#odvRDHModalFormBarPrefix').show();
                        $('#odvRDHModalFormBarStartCode').show();
                        $('#odvRDHModalFormBarQty').show();
                        $('#odvRDHModalFormBarHisQtyUse').show();
                        break;
                    }
                    case '3': {
                        // Show Hide Input Codition Default
                        $('#odvRDHModalInputCreateCoupon').show();
                        $('.xWRDHModalInputCreateCoupon').hide();
                        // Show Input Condition
                        $('#odvRDHModalFormBarWidth').show();
                        $('#odvRDHModalFormBarQty').show();
                        $('#odvRDHModalFormBarHisQtyUse').show();
                        break;
                    }
                }
                $('#ostRDHModalCouponCreateMng1Bar').val(nStaCouponCreateMng1Bar).selectpicker('refresh');
            });

            // Event Change สร้างคูปอง กำหนดเอง ประเภทบาร์ฺโค๊ด
            $('#ostRDHModalCouponCreateMng2Bar').unbind().change(function(){
                // ล้างค่าข้อมูลเงื่อนไขในการสร้างคูปอง
                $('.xWRDHModalInputCreateCoupon input').val('');
                $('#odvRDHModalCouponTypeCreate1').hide();
                $('#odvRDHModalInputCreateCoupon').hide();
                $('#odvRDHModalCouponTypeCreate2').show();
                let nStaCouponCreateMng2Bar = $(this).val();
                switch(nStaCouponCreateMng2Bar){
                    case '1': {
                        // Show Hide Input Codition Default
                        $('#odvRDHModalInputCreateCoupon').show();
                        $('.xWRDHModalInputCreateCoupon').hide();
                        // Show Input Condition
                        $('#odvRDHModalFormCouponCode').show();
                        $('#odvRDHModalFormBarHisQtyUse').show();
                        break;
                    }
                    case '2': {
                        // Show Hide Input Codition Default
                        $('#odvRDHModalInputCreateCoupon').show();
                        $('.xWRDHModalInputCreateCoupon').hide();
                        // Show Input Condition
                        $('#odvRDHModalFormBarPrefix').show();
                        $('#odvRDHModalFormCouponCode').show();
                        $('#odvRDHModalFormBarHisQtyUse').show();
                        break;
                    }
                }
                $('#ostRDHModalCouponCreateMng2Bar').val(nStaCouponCreateMng2Bar).selectpicker('refresh');
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    function JSxRDHModalFuncImportFile(poElement, poEvent) {
        try{
            console.log('Import run');
            var oFile = $(poElement)[0].files[0];
            $("#oetRDHModalFileShowName").val(oFile.name);
        }catch(err){
            console.log("JSxRDHModalFuncImportFile Error: ", err);
        }
    }

    function JSxValidateFileExcel(){
        //Reference the FileUpload element.
        var fileUpload  = $("#oetRDHModalFileInport")[0];
        //Validate whether File is valid Excel file.
        var regex       = /^([a-zA-Z0-9ก-ฮ ()\s_\\.\-:])+(.xls|.xlsx)$/;
        if (regex.test(fileUpload.value.toLowerCase())) {
            if (typeof (FileReader) != "undefined") {
                var reader  = new FileReader();
                //For Browsers other than IE.
                if (reader.readAsBinaryString) {
                    reader.onload = function (e) {
                        JSxProcessExcel(e.target.result);
                    };
                    reader.readAsBinaryString(fileUpload.files[0]);
                } else {
                    //For IE Browser.
                    reader.onload = function (e) {
                        var data = "";
                        var bytes = new Uint8Array(e.target.result);
                        for (var i = 0; i < bytes.byteLength; i++) {
                            data += String.fromCharCode(bytes[i]);
                        }
                        JSxProcessExcel(data);
                    };
                    reader.readAsArrayBuffer(fileUpload.files[0]);
                }
            }else{
                $tMsgWannigFileNotSupport   = "This browser does not support HTML5.";
                alert($tMsgWannigFileNotSupport);
            }
        }else{
            $tMsgWannigFileNotFoundFile = "<?php echo language('document/couponsetup/couponsetup','tRDHModalValidateExcelNotFound') ?>"
            alert($tMsgWannigFileNotFoundFile);
        }
    }

    // Function Behide Event Save Coupon Setup
    function JSxProcessExcel(data) {
        //Read the Excel File data.
        var workbook    = XLSX.read(data, {
            type: 'binary'
        });
        //Fetch the name of First Sheet.
        var firstSheet  = workbook.SheetNames[0];
        //Read all rows from First Sheet into an JSON array.
        var excelRows   = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);
        //Create a HTML Table element.
        var table       = $("<table />");
        table[0].border = "1";
        //Add the header row.
        var row         = $(table[0].insertRow(-1));
        //Add the header cells.
        var headerCell  = $("<th />");
        headerCell.html("Id");
        row.append(headerCell);
 
        var headerCell  = $("<th />");
        headerCell.html("Name");
        row.append(headerCell);
 
        var headerCell  = $("<th />");
        headerCell.html("Country");
        row.append(headerCell);
 
        let nCountDataInTableDT = $('#odvRDHDataPanelDetail #otbRDHDataDetailDT tbody .xWRDHDataDetailItems').length;
        $('#odvRDHDataPanelDetail #otbRDHDataDetailDT tbody').find('.xWRDHTextNotfoundData').parent().remove();
        //Add the data rows from Excel file.
        for (var i = 0; i < excelRows.length; i++) {
            //Add the Data Row Detail DT.
            nCountDataInTableDT++;
            let tTemplate   = $("#oscRDHTemplateDataDetailDT").html();
                let oData       = {
                    'tImgRDHCouponOld'  : $('#oetImgInputRDHModalCouponOld').val(),
                    'tImgRDHCouponNew'  : $('#oetImgInputRDHModalCoupon').val(),
                    'tTextCpdAlwMaxUse' : excelRows[i].MaxUse,
                    'tTextCpdBarCpn'    : excelRows[i].CouponCode,
                    'nKeyNumber'        : nCountDataInTableDT,
                };
                let tRenderAppend   = JStRDHRenderTemplateDetailDT(tTemplate,oData);
                $('#odvRDHDataPanelDetail #otbRDHDataDetailDT tbody').append(tRenderAppend);
        }
        setTimeout(function(){
            $('#odvRDHFormAddCoupon').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            JCNxCloseLoading();
        },500);
    };

    // Function Behide Event Save Coupon Setup
    function JSoRDHModalSaveCreateCoupon(){
        //เอา JCNxFuncChkSessionExpired เพื่อโหลดไฟล์เร็วขึ้น
        // let nStaSession = JCNxFuncChkSessionExpired();
        // if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tRDHModalCouponTypeCreate = $('#ostRDHModalCouponTypeCreate').val();
            if(tRDHModalCouponTypeCreate == 1){
                JSxValidateFileExcel();
            }else{
                $('#obtRDHSubmitFromSaveCondition').trigger('click');
            }
        // }else{
        //     JCNxShowMsgSessionExpired();
        // }
    }

    // Function Render Data Detail DT
    function JStRDHRenderTemplateDetailDT(tTemplate,oData){
        String.prototype.fmt    = function (hash) {
            let tString = this, nKey; 
            for(nKey in hash){
                tString = tString.replace(new RegExp('\\{' + nKey + '\\}', 'gm'), hash[nKey]); 
            }
            return tString;
        };
        let tRender = "";
        tRender     = tTemplate.fmt(oData);
        return tRender;
    }

    // Function Event Delete Row Data Table 
    function JSxRDHDeleteRowDTItems(oEvent){
        JCNxOpenLoading();
        // Remove Row Data DT 
        $(oEvent).parents('.xWRDHDataDetailItems').remove();
        setTimeout(function(){
            var nCountDataInTableDT = $('#otbRDHDataDetailDT tbody tr.xWRDHDataDetailItems').length;
            if(nCountDataInTableDT == 0){
                var tTextDataNotFound   = "<tr><td class='text-center xCNTextDetail2 xWRDHTextNotfoundData' colspan='100%'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>";
                $('#otbRDHDataDetailDT tbody').html(tTextDataNotFound);
            }else{
                var tNumberSeq  = 1;
                $( "#otbRDHDataDetailDT tbody tr.xWRDHDataDetailItems" ).each(function(){
                    $(this).find('.xWRDHNumberSeq').text(tNumberSeq);
                    tNumberSeq++;
                });
            }
            JCNxCloseLoading();
        },500)        
    }

    // Function Event Create Coupon DT And Validate Input
    function JSxRDHEventCreateCouponDT(){
        $('#ofmRDHModalCreateCouponForm').validate({
            focusInvalid: false,
            onclick: false,
            onfocusout: false,
            onkeyup: false,
            rules: {
                oetRDHModalInputBarWidth        : {"required" : true},
                oetRDHModalInputBarPrefix       : {"required" : true},
                oetRDHModalInputBarStartCode    : {"required" : true},
                oetRDHModalInputBarQty          : {"required" : true},
                oetRDHModalInputCouponCode      : {"required" : true},
                oetRDHModalInputBarHisQtyUse    : {"required" : true},
            },
            messages: {
                oetRDHModalInputBarWidth        : {"required" : 'กรุณาเพิ่มข้อมูลความกว้างบารโค๊ต.'},
                oetRDHModalInputBarPrefix       : {"required" : 'กรุณาเพิ่มข้อมูลตัวอักษร.'},
                oetRDHModalInputBarStartCode    : {"required" : 'กรุณาเพิ่มข้อมูลรหัสคูปองเริ่มต้น.'},
                oetRDHModalInputBarQty          : {"required" : 'กรุณาเพิ่มข้อมูลจำนวนคูปอง.'},
                oetRDHModalInputCouponCode      : {"required" : 'กรุณาเพิ่มข้อมูลรหัสคูปอง.'},
                oetRDHModalInputBarHisQtyUse    : {"required" : 'กรุณาเพิ่มข้อมูลจำนวนคูปองที่ใช้งานได้.'},
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
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "dcmCouponSetupEventAddCouponToDT",
                    data: $('#ofmRDHModalCreateCouponForm').serialize(),
                    success: function (oDataReturn) {
                        // สร้าง แบบ Custom
                        let aDataReturn         = JSON.parse(oDataReturn);
                        let tImgRDHCouponOld    = aDataReturn.ptImgRDHCouponOld;
                        let tImgRDHCouponNew    = aDataReturn.ptImgRDHCouponNew;
                        let tTextCpdAlwMaxUse   = aDataReturn.ptInputBarHisQtyUse;
                        let aDataCouponBar      = aDataReturn.paDataCouponBar;
                        let nCountDataInTableDT = $('#odvRDHDataPanelDetail #otbRDHDataDetailDT tbody .xWRDHDataDetailItems').length;
                        $('#odvRDHDataPanelDetail #otbRDHDataDetailDT tbody').find('.xWRDHTextNotfoundData').parent().remove();
                        $.each(aDataCouponBar,function(nKey,tTextCpdBarCpn){
                            nCountDataInTableDT++;
                            let tTemplate   = $("#oscRDHTemplateDataDetailDT").html();
                            let oData       = {
                                'tImgRDHCouponOld'  : tImgRDHCouponOld,
                                'tImgRDHCouponNew'  : tImgRDHCouponNew,
                                'tTextCpdAlwMaxUse' : tTextCpdAlwMaxUse,
                                'tTextCpdBarCpn'    : tTextCpdBarCpn,
                                'nKeyNumber'        : nCountDataInTableDT,
                            };
                            let tRenderAppend   = JStRDHRenderTemplateDetailDT(tTemplate,oData);
                            $('#odvRDHDataPanelDetail #otbRDHDataDetailDT tbody').append(tRenderAppend);
                        });
                        setTimeout(function(){
                            $('#odvRDHFormAddCoupon').modal('hide');
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                            JCNxCloseLoading();
                        },500);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            },
        });
    }

    // Event Search Menu
    $("#oetRDHSearchDataDT").on("keyup", function() {

        //flow : ใหม่ search by wat
        var value = $(this).val().toLowerCase();
        $("#otbRDHDataDetailDT tr").filter(function(index) {
            if (index !== 0) {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            }
        });

        //flow : เดิม search by yoshi
        // var value = $(this).val();
        // $("#otbRDHDataDetailDT tr").each(function(index) {
            // if (index !== 0) {
            //     $row = $(this);
            //     var $tdElement = $row.find("td:first");
            //     var id  = $tdElement.text();
            //     var matchedIndex = id.indexOf(value);
            //     if (matchedIndex != 0) {
            //         $row.hide();
            //     }
            //     else {
            //         $row.show();
            //     }
            // }
        // });
    });

    // Event Control Date Default
    $('#ocbRDHStaAutoGenCode').on('change', function (e) {
        if($('#ocbRDHStaAutoGenCode').is(':checked')){
            $("#oetRDHDocNo").val('');
            $("#oetRDHDocNo").attr("readonly", true);
            $('#oetRDHDocNo').closest(".form-group").css("cursor","not-allowed");
            $('#oetRDHDocNo').css("pointer-events","none");
            $("#oetRDHDocNo").attr("onfocus", "this.blur()");
            $('#ofmCouponSetupAddEditForm').removeClass('has-error');
            $('#ofmCouponSetupAddEditForm .form-group').closest('.form-group').removeClass("has-error");
            $('#ofmCouponSetupAddEditForm em').remove();
        }else{
            $('#oetRDHDocNo').closest(".form-group").css("cursor","");
            $('#oetRDHDocNo').css("pointer-events","");
            $('#oetRDHDocNo').attr('readonly',false);
            $("#oetRDHDocNo").removeAttr("onfocus");
        }
    });

    var dCurrentDate    = new Date();
    var tAmOrPm         = (dCurrentDate.getHours() < 12) ? "AM" : "PM";
    var tCurrentTime    = dCurrentDate.getHours() + ":" + dCurrentDate.getMinutes() + " " + tAmOrPm;

    if($('#oetRDHDocDate').val() == ''){
        $('#oetRDHDocDate').datepicker("setDate",dCurrentDate); 
    }

    if($('#oetRDHDocTime').val() == ''){
        $('#oetRDHDocTime').val(tCurrentTime);
    }


    $('#oimBrowseBch').click(function(){ JCNxBrowseData('oBrowseBch'); });

    var tUsrLevel     = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
    var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var nCountBch     = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
    var tWhere = "";
 
    if(nCountBch == 1){
        $('#oimBrowseBch').attr('disabled',true);
    }
    if(tUsrLevel != "HQ"){
        tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
    }else{
        tWhere = "";
    }

    var oBrowseBch = {
        Title   : ['company/branch/branch','tBCHTitle'],
        Table   : {Master:'TCNMBranch',PK:'FTBchCode',PKName:'FTBchName'},
        Join    : {
            Table   : ['TCNMBranch_L','TCNMWaHouse_L'],
            On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID ='+nLangEdits,
                        'TCNMBranch.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMBranch.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID ='+nLangEdits,
            ]
        },
        Where : {
            Condition : [tWhere]
        },
        GrideView:{
            ColumnPathLang    : 'company/branch/branch',
            ColumnKeyLang     : ['tBCHCode','tBCHName',''],
            ColumnsSize       : ['15%','75%',''],
            WidthModal        : 50,
            DataColumns       : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName','TCNMWaHouse_L.FTWahCode','TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat : ['',''],
            DisabledColumns   : [2,3],
            Perpage           : 10,
            OrderBy           : ['TCNMBranch.FDCreateOn DESC'],
        },
        CallBack:{
            ReturnType        : 'S',
            Value             : ["ohdRDHUsrBchCode","TCNMBranch.FTBchCode"],
            Text              : ["ohdRDHUsrBchName","TCNMBranch_L.FTBchName"],
        }
    }

    $(".next-step").click(function (e) {

        var nTab = $('#ohdRDHNowTab').val();
        var nRedeemType = $('#ocmRDHDocType').val();
        if(nTab==1 && nRedeemType==1){
        var nRddGroupNameInput = $('input[name^="ohdRddGroupNameInput"]').length;

            if(nRddGroupNameInput==0){
            let tMsgAlertvalidateGrpNamePdt = $('#ohdRDHValidatePromotionRedeem').attr('validateGrpNamePdt');
                alert(tMsgAlertvalidateGrpNamePdt);
                return false;
            }

            $('#ocmRDHDocType').attr('disabled',true);
            $('#obtTabConditionRedeemHDGrp').hide();
            $('.othColumDelete').hide();
            if($('#ohdRDHRouteEvent').val()=='dcmRDHEventAdd'){
            JSxRDHGenGroupForHtmlTab2();
            }

        }

        if(nTab==2 && nRedeemType==2){
            $('#ocmRDHDocType').attr('disabled',true);
        }

        if(nTab==2){
        let nRdcRefCode = $('input[name^="oetRdcRefCode"]').length;

        if(nRdcRefCode==0){
            let tMsgAlertvalidateGrpCondition = $('#ohdRDHValidatePromotionRedeem').attr('validateGrpCondition');
            alert(tMsgAlertvalidateGrpCondition);
            return false;
        }
        
            let nCheckRefCode = 0 ;
            let nCheckUsePointCode = 0 ;
            let nCheckUseMny = 0 ;
            let nCheckRdcMinTotBill = 0 ;
            let nDuplicateRefCode = 0 ;  
            let nNumberData = 0;
            if($('#ocbRddStaAutoGenCode').prop('checked')==false){
                    $('input[name^="oetRdcRefCode"]').each(function(){
                    
                        if($(this).val()==''){
                            nCheckRefCode++;
                        }{
                        let nNumberDataSub = 0;
                        let tRefCode = $(this).val();
                            $('input[name^="oetRdcRefCode"]').each(function(){
                                let tRefCodeSub = $(this).val();
                                if(tRefCodeSub==tRefCode && nNumberData!=nNumberDataSub ){
                                    nDuplicateRefCode++;
                                }

                                nNumberDataSub++;
                            });

                        }

                        nNumberData++;
                        
                    });


                
            }
            $('input[name^="oetRdcUsePoint"]').each(function(){
                if($(this).val()==''){
                    nCheckUsePointCode++;
                }
            });
            $('input[name^="oetRdcUseMny"]').each(function(){
                if($(this).val()==''){
                    nCheckUseMny++;
                }
            });
            $('input[name^="oetRdcMinTotBill"]').each(function(){
                if($(this).val()==''){
                    nCheckRdcMinTotBill++;
                }
            });
            
            if(nCheckRefCode>0){
                let tMsgAlertvalidateRdhRefCode = $('#ohdRDHValidatePromotionRedeem').attr('validateRdhRefCode');
                alert(tMsgAlertvalidateRdhRefCode);
                return false;
            }
            if(nCheckUsePointCode>0){
                let tMsgAlertvalidateRdhUsePoint = $('#ohdRDHValidatePromotionRedeem').attr('validateRdhUsePoint');
                alert(tMsgAlertvalidateRdhUsePoint);
                return false;
            }
            if(nCheckUseMny>0){
                let tMsgAlertvalidateRdhMoney = $('#ohdRDHValidatePromotionRedeem').attr('validateRdhMoney');
                alert(tMsgAlertvalidateRdhMoney);
                return false;
            }
            if(nCheckRdcMinTotBill>0){
                let tMsgAlertvalidateRdhLimitBill = $('#ohdRDHValidatePromotionRedeem').attr('validateRdhLimitBill');
                alert(tMsgAlertvalidateRdhLimitBill);
                return false;
            }

            if(nDuplicateRefCode>0){
                alert('Ref Code Dupclicate');
                return false;  
            }

        }


        let active = $('.wizard .nav-tabs li.active');
        active.next().removeClass('disabled');
        JSxnextTab(active);

    });
            
    $(".prev-step").click(function (e) {
        var $active = $('.wizard .nav-tabs li.active');
        JSxPrevTab($active);
    });

    function JSxnextTab(elem) {
        $(elem).next().find('a[data-toggle="tab"]').click();
        if($('#oliTab_step2').not("active") || $('#oliTab_step3').not("active") ||$('#oliTab_step4').not("active")){
            $('#obtRDHBackStepDoc').attr('disabled',false);
        }else{
            $('#obtRDHBackStepDoc').attr('disabled',true);
        }
    }
            
    function JSxPrevTab(elem) {
        $(elem).prev().find('a[data-toggle="tab"]').click();
        if($("#ocmRDHDocType").val() == '1'){
            if($('#oliTab_step2').hasClass("disabled")){
            $('#obtRDHBackStepDoc').attr('disabled',true);
            }else{
                $('#obtRDHBackStepDoc').attr('disabled',false);
            }
        }else{
            if($('#oliTab_step3').hasClass("disabled")){
                $('#obtRDHBackStepDoc').attr('disabled',true);
            }else{
                $('#obtRDHBackStepDoc').attr('disabled',false);
            }
        }
    }

    //พิมพ์
    function JSvRDHPrintDoc(){
        var aInfor = [
            {"Lang"         : '<?=FCNaHGetLangEdit(); ?>'}, // Lang ID
            {"ComCode"      : '<?=FCNtGetCompanyCode(); ?>'}, // Company Code
            {"BranchCode"   : '<?=FCNtGetAddressBranch($tRDHUsrBchCode); ?>' }, // สาขาที่ออกเอกสาร
            {"DocCode"      : $('#oetRDHDocNo').val()  }, // เลขที่เอกสาร
            {"DocBchCode" : '<?=$tRDHUsrBchCode;?>'}
        ];
        window.open('<?=base_url()?>'+"formreport/Frm_SQL_PSSRdPoint?infor="+JCNtEnCodeUrlParameter(aInfor), '_blank');
    }

</script>

