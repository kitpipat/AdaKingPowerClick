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
        $('#oahCardShiftStatusAdvanceSearch').on('click', function() {
            if ($('#odvCardShiftStatusAdvanceSearchContainer').hasClass('hidden')) {
                JSxCMNVisibleComponent('#odvCardShiftStatusAdvanceSearchContainer', true, 'slideUD');
            } else {
                JSxCMNVisibleComponent('#odvCardShiftStatusAdvanceSearchContainer', false, 'slideUD');
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
    function JSxCardShiftStatusClearSearchData() {
        try {
            $('#oetSearchAll').val("");
            $('#oetCardShiftStatusSearchDocDateFrom').val("");
            $('#oetCardShiftStatusSearchDocDateTo').val("");
            $('#oetCardShiftStatusSearchCardQtyTo').val("");
            $(".selectpicker").val('0').selectpicker("refresh");
            JSvCardShiftStatusCardShiftStatusDataTable();
        } catch (err) {
            console.log("JSxCardShiftStatusClearSearchData Error: ", err);
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
    function JSoCardShiftStatusGetSearchData() {
        try {
            let oAdvanceSearchData = {
                tSearchAll: $('#oetSearchAll').val(),
                tSearchDocDateFrom: $('#oetCardShiftStatusSearchDocDateFrom').val(),
                tSearchDocDateTo: $('#oetCardShiftStatusSearchDocDateTo').val(),
                tSearchStaDoc: $('#ocmCardShiftStatusStaDoc').val(),
                tSearchStaApprove: $('#ocmCardShiftStatusStaApprove').val(),
                tSearchStaPrc: $('#ocmCardShiftStaPrcDoc').val(),
                tSearchStaAct: $('#ocmCardShiftStaDocAct').val()
            };
            return oAdvanceSearchData;
        } catch (err) {
            console.log("JSoCardShiftStatusGetSearchData Error: ", err);
        }
    }

    /**
     * Functionality : Delete Doc
     * Parameters : tCurrentPage, tDocNo
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftStatusDocDel(tCurrentPage, tDocNo, tBchCode) {
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
                    url: "cardShifStatusDelDoc",
                    data: {
                        tDocNo: tDocNo,
                        tBchCode: tBchCode
                    },
                    cache: false,
                    success: function(tResult) {
                        JSvCardShiftStatusCardShiftStatusDataTable(tCurrentPage);
                        JSxCardShiftStatusCardShiftStatusNavDefult();
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
    function JSxCardShiftStatusDelChoose() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            $("#odvModalDel").addClass('more')
            $("#odvModalDel").removeClass('one')
            $("#odvModalDel").modal("show");
            $("#ospConfirmDelete").html("<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll'); ?>");

            $("#odvModalDel.more #osmConfirm").on("click", function(evt) {

                var oItem = $(".otrCardShiftStatus .ocbListItem:checked");
                var nItemLength = oItem.length;
                var aDocData = [];

                $.each(oItem, function() {
                    var tDocNo = $(this).parents(".otrCardShiftStatus").data('doc-no');
                    var tBchCode = $(this).parents(".otrCardShiftStatus").data('bch-code');
                    aDocData.push({
                        tDocNo: tDocNo,
                        tBchCode: tBchCode
                    })
                });

                $("#odvModalDel").modal("hide");
                JCNxOpenLoading();

                $.ajax({
                    type: "POST",
                    url: "cardShiftStatusDelDocMulti",
                    data: {
                        aDocData: JSON.stringify(aDocData)
                    },
                    success: function(tResult) {
                        JSvCardShiftStatusCardShiftStatusDataTable(1);
                        JSxCardShiftStatusCardShiftStatusNavDefult();
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