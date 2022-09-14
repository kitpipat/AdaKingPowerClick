<script>

    $(document).ready(function(){

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });

        if(bIsApvOrCancel){
            $('form .xCNApvOrCanCelDisabledPmtPdtDt').attr('disabled', true);
            $('#otbPromotionStep1PmtPdtDtGroupNameTable .xCNIconDel').addClass('xCNDocDisabled');
            $('#otbPromotionStep1PmtPdtDtGroupNameTable .xCNIconDel').removeAttr('onclick', true);
            $('#otbPromotionStep1PmtPdtDtGroupNameTable .xCNIconView').removeClass('xCNHide');
            $('#otbPromotionStep1PmtPdtDtGroupNameTable .xCNIconEdit').addClass('xCNHide');
            // $('#otbPromotionStep1PmtPdtDtGroupNameTable .xCNIconEdit').addClass('xCNDocDisabled');
            // $('#otbPromotionStep1PmtPdtDtGroupNameTable .xCNIconEdit').removeAttr('onclick', true);
        }else{
            $('form .xCNApvOrCanCelDisabledPmtPdtDt').attr('disabled', false);
            $('#otbPromotionStep1PmtPdtDtGroupNameTable .xCNIconDel').removeClass('xCNDocDisabled');
            $('#otbPromotionStep1PmtPdtDtGroupNameTable .xCNIconDel').attr('onclick', 'JSxPromotionStep1PmtPdtDtGroupNameDataTableDeleteByGroupName(this)');
            $('#otbPromotionStep1PmtPdtDtGroupNameTable .xCNIconView').addClass('xCNHide');
            $('#otbPromotionStep1PmtPdtDtGroupNameTable .xCNIconEdit').removeClass('xCNHide');
            // $('#otbPromotionStep1PmtPdtDtGroupNameTable .xCNIconEdit').removeClass('xCNDocDisabled');
            // $('#otbPromotionStep1PmtPdtDtGroupNameTable .xCNIconEdit').attr('onclick', 'JSxPromotionStep1PmtPdtDtGroupNameDataTableEdit(this)');
        }

        $('#otbPromotionStep1PmtPdtDtGroupNameTable .xCNIconEdit, #otbPromotionStep1PmtPdtDtGroupNameTable .xCNIconView').attr('onclick', 'JSxPromotionStep1PmtPdtDtGroupNameDataTableEdit(this)');

    });

    /**
     * Functionality : เรียกหน้าของรายการ PmtPdtDt in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Table List
     * Return Type : View
     */
    function JSvPromotionStep1PmtPdtDtGroupNameDataTableClickPage(ptPage) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xCNPromotionPmtPdtDtGroupNamePage .xWBtnNext").addClass("disabled");
                nPageOld = $(".xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xCNPromotionPmtPdtDtGroupNamePage .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSxPromotionStep1GetPmtDtGroupNameInTmp(nPageCurrent, true);
    }

    /**
     * Functionality : Edit Inline PmtPdtDt in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep1PmtPdtDtGroupNameDataTableEdit(poElm) {
        var tGroupName = $(poElm).parents('.xCNPromotionPmtPdtDtGroupNameRow').data('group-name');
        var tStaType = $(poElm).parents('.xCNPromotionPmtPdtDtGroupNameRow').data('sta-type');
        var tStaListType = $(poElm).parents('.xCNPromotionPmtPdtDtGroupNameRow').data('sta-list-type');
        
        $('#oetPromotionGroupNameTmp').val(tGroupName);
        $('#ohdPromotionGroupNameTmpOld').val(tGroupName);
        $("#ocmPromotionGroupTypeTmp").val(tStaType).selectpicker("refresh");
        $("#ocmPromotionListTypeTmp").val(tStaListType).selectpicker("refresh");

        $.ajax({
            type: "POST",
            url: "promotionStep1PmtDtInTmpToBin",
            data: {
                tPmtGroupNameTmp: tGroupName
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if(tStaListType == "1"){
                    JSxPromotionStep1GetPmtPdtDtInTmp(1, false);
                }

                var aPdtCond = ["2","3","4","5","6","7"]
                if(aPdtCond.includes(tStaListType.toString())){
                    /* if(JCNbPromotionStep1PmtDtHasExcludeTypeInTemp()){
                        var tStaListType = $('#ohdPromotionPmtDtStaListTypeInTmp').val();
                        $("#ocmPromotionListTypeTmp").val(tStaListType); 
                        $("#ocmPromotionListTypeTmp").trigger('change'); 
                        $("#ocmPromotionListTypeTmp").prop('disabled', true);
                        $("#ocmPromotionListTypeTmp").selectpicker("refresh");
                    }else{
                        $("#ocmPromotionListTypeTmp").val("1");
                        $("#ocmPromotionListTypeTmp").trigger('change'); 
                        $("#ocmPromotionListTypeTmp").prop('disabled', false);
                        $("#ocmPromotionListTypeTmp").selectpicker("refresh"); 
                    } */
                    JSxPromotionStep1GetPmtBrandDtInTmp(1, false);
                }

                /*===== Begin Group Type Control =======================================*/
                JCNxPromotionStep1ControlExcept(tStaType);
                /*===== End Group Type Control =========================================*/

                $('#odvPromotionAddPmtGroupModal').modal({backdrop:'static', keyboard:false, show:true});
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
                JCNxCloseLoading();
            }
        });
    }

    /**
     * Functionality : Delete PmtPdtDt in Temp by Group Name
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep1PmtPdtDtGroupNameDataTableDeleteByGroupName(poElm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            var tGroupName = $(poElm).parents('.xCNPromotionPmtPdtDtGroupNameRow').data('group-name');

            $.ajax({
                type: "POST",
                url: "promotionStep1DeletePmtDtGroupNameInTmp",
                data: {
                    tGroupName: tGroupName
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $nCurrentPage = $('#odvPromotionPmtPdtDtGroupNameDataTable').find('.btn.xCNBTNNumPagenation.active').text();
                    JSxPromotionStep1GetPmtDtGroupNameInTmp($nCurrentPage, true);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                    JCNxCloseLoading();
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }
</script>