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
        $('#oahCardShiftOutAdvanceSearch').on('click', function() {
            if ($('#odvCardShiftOutAdvanceSearchContainer').hasClass('hidden')) {
                JSxCMNVisibleComponent('#odvCardShiftOutAdvanceSearchContainer', true, 'slideUD');
            } else {
                JSxCMNVisibleComponent('#odvCardShiftOutAdvanceSearchContainer', false, 'slideUD');
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
    function JSxCardShiftOutClearSearchData() {
        try {
            $('#oetSearchAll').val("");
            $('#oetCardShiftOutSearchDocDateFrom').val("");
            $('#oetCardShiftOutSearchDocDateTo').val("");
            $('#oetCardShiftOutSearchCardQtyTo').val("");
            $(".selectpicker").val('0').selectpicker("refresh");
            JSvCardShiftOutCardShiftOutDataTable();
        } catch (err) {
            console.log("JSxCardShiftOutClearSearchData Error: ", err);
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
    function JSoCardShiftOutGetSearchData() {
        try {
            var oAdvanceSearchData = {
                tSearchAll: $('#oetSearchAll').val(),
                tSearchDocDateFrom: $('#oetCardShiftOutSearchDocDateFrom').val(),
                tSearchDocDateTo: $('#oetCardShiftOutSearchDocDateTo').val(),
                tSearchStaDoc: $('#ocmCardShiftOutStaDoc').val(),
                tSearchStaApprove: $('#ocmCardShiftOutStaApprove').val()
            };
            return oAdvanceSearchData;
        } catch (err) {
            console.log("JSoCardShiftOutGetSearchData Error: ", err);
        }
    }

    /**
     * Functionality : Delete Doc
     * Parameters : tCurrentPage, tDocNo
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftOutDocDel(tCurrentPage, tDocNo, tBchCode) {
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
                    url: "cardShifOutDelDoc",
                    data: {
                        tDocNo: tDocNo,
                        tBchCode: tBchCode
                    },
                    cache: false,
                    success: function(tResult) {
                        JSvCardShiftOutCardShiftOutDataTable(tCurrentPage);
                        JSxCardShiftOutCardShiftOutNavDefult();
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
    function JSxCardShiftOutDelChoose() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            $("#odvModalDel").addClass('more')
            $("#odvModalDel").removeClass('one')
            $("#odvModalDel").modal("show");
            $("#ospConfirmDelete").html("<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll'); ?>");

            $("#odvModalDel.more #osmConfirm").on("click", function(evt) {

                var oItem = $(".otrCardShiftOut .ocbListItem:checked");
                var nItemLength = oItem.length;
                var aDocData = [];

                $.each(oItem, function(){
                    var tDocNo = $(this).parents(".otrCardShiftOut").data('doc-no');
                    var tBchCode = $(this).parents(".otrCardShiftOut").data('bch-code');
                    aDocData.push({
                        tDocNo: tDocNo,
                        tBchCode: tBchCode
                    })
                });

                $("#odvModalDel").modal("hide");
                JCNxOpenLoading();

                $.ajax({
                    type: "POST",
                    url: "cardShiftOutDelDocMulti",
                    data: {
                        aDocData: JSON.stringify(aDocData)
                    },
                    success: function(tResult) {
                        JSvCardShiftOutCardShiftOutDataTable(1);
                        JSxCardShiftOutCardShiftOutNavDefult();
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