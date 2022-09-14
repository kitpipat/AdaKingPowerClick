<script type="text/javascript">
    $(document).ready(function() {

        $('body').on('focus', ".xCNDatePicker", function() {
            $(this).datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                // startDate: new Date(),
                // startDate: '-3d',
                orientation: "bottom"
            });
        });

        $('.selectpicker').selectpicker();

        // Advance search display control
        $('#oahCardShiftChangeAdvanceSearch').on('click', function() {
            if ($('#odvCardShiftChangeAdvanceSearchContainer').hasClass('hidden')) {
                JSxCMNVisibleComponent('#odvCardShiftChangeAdvanceSearchContainer', true, 'slideUD');
            } else {
                JSxCMNVisibleComponent('#odvCardShiftChangeAdvanceSearchContainer', false, 'slideUD');
            }
        });

    });

    /**
     * Functionality : Clear search data
     * Parameters : -
     * Creator : 12/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeClearSearchData() {
        try {
            $('#oetSearchAll').val("");
            $('#oetCardShiftChangeSearchDocDateFrom').val("");
            $('#oetCardShiftChangeSearchDocDateTo').val("");
            $('#oetCardShiftChangeSearchCardQtyTo').val("");
            $(".selectpicker").val('0').selectpicker("refresh");
            JSvCardShiftChangeCardShiftChangeDataTable();
        } catch (err) {
            console.log("JSxCardShiftChangeClearSearchData Error: ", err);
        }
    }

    /**
     * Functionality : Get search data
     * Parameters : -
     * Creator : 12/12/2018 piya
     * Last Modified : -
     * Return : Search data
     * Return Type : Object
     */
    function JSoCardShiftChangeGetSearchData() {
        try {
            let oAdvanceSearchData = {
                tSearchAll: $('#oetSearchAll').val(),
                tSearchDocDateFrom: $('#oetCardShiftChangeSearchDocDateFrom').val(),
                tSearchDocDateTo: $('#oetCardShiftChangeSearchDocDateTo').val(),
                tSearchStaDoc: $('#ocmCardShiftChangeStaDoc').val(),
                tSearchStaApprove: $('#ocmCardShiftChangeStaApprove').val(),
                tSearchStaPrc: $('#ocmCardShiftChangeStaPrcDoc').val(),
                tSearchStaAct: $('#ocmCardShiftChangeStaDocAct').val()
            };
            return oAdvanceSearchData;
        } catch (err) {
            console.log("JSoCardShiftChangeGetSearchData Error: ", err);
        }
    }

    /**
     * Functionality : Delete Doc
     * Parameters : tCurrentPage, tDocNo
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeDocDel(tCurrentPage, tDocNo, tBchCode) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            $("#odvModalDel").addClass('one')
            $("#odvModalDel").removeClass('more')
            $("#odvModalDel").modal("show");
            $("#ospConfirmDelete").html("<?php echo language('common/main/main', 'tModalConfirmDeleteItemsNo'); ?> : " + tDocNo);

            $("#odvModalDel.one #osmConfirm").on("click", function(evt) {
                $("#odvModalDel").modal("hide");
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "cardShifChangeDelDoc",
                    data: {
                        tDocNo: tDocNo,
                        tBchCode: tBchCode
                    },
                    cache: false,
                    success: function(tResult) {
                        JSvCardShiftChangeCardShiftChangeDataTable(tCurrentPage);
                        JSxCardShiftChangeCardShiftChangeNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCloseLoading();
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Multi Delete Doc
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeDelChoose() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            $("#odvModalDel").addClass('more')
            $("#odvModalDel").removeClass('one')
            $("#odvModalDel").modal("show");
            $("#ospConfirmDelete").html("<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll'); ?>");

            $("#odvModalDel.more #osmConfirm").on("click", function(evt) {

                var oItem = $(".otrCardShiftChange .ocbListItem:checked");
                var nItemLength = oItem.length;
                var aDocData = [];

                $.each(oItem, function() {
                    var tDocNo = $(this).parents(".otrCardShiftChange").data('doc-no');
                    var tBchCode = $(this).parents(".otrCardShiftChange").data('bch-code');
                    aDocData.push({
                        tDocNo: tDocNo,
                        tBchCode: tBchCode
                    })
                });

                $("#odvModalDel").modal("hide");
                JCNxOpenLoading();

                $.ajax({
                    type: "POST",
                    url: "cardShiftChangeDelDocMulti",
                    data: {
                        aDocData: JSON.stringify(aDocData)
                    },
                    success: function(tResult) {
                        JSvCardShiftChangeCardShiftChangeDataTable(1);
                        JSxCardShiftChangeCardShiftChangeNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCloseLoading();
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }
</script>