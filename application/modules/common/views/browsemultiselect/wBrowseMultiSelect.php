<style>
    #odvDataTableMultiBrowse .table-responsive {
        max-height: calc(100vh - 200px);
        overflow-x: auto;
    }
</style>
<input type="hidden" id="ohdMultiBrowseOptionName" name="ohdMultiBrowseOptionName" value="<?php echo $tOptionName; ?>">
<input type="hidden" id="ohdMultiBrowseCallBackStaAll" name="ohdMultiBrowseCallBackStaAll" value="<?php echo $tOldCallBackStaAll; ?>">
<input type="hidden" id="ohdMultiBrowseCallBackValue" name="ohdMultiBrowseCallBackValue" value="<?php echo $tOldCallBackVal; ?>">
<input type="hidden" id="ohdMultiBrowseCallBackText" name="ohdMultiBrowseCallBackText" value="<?php echo $tOldCallBackText; ?>">
<div class="modal-header xCNModalHead">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('common/main/main', 'tShowData') . ' : ' . $tTitleHeader; ?></label>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
            <button id="obtMultiBrowseConfirmSelect" class="btn xCNBTNPrimery xCNBTNPrimery2Btn"><?php echo language('common/main/main', 'tModalAdvChoose'); ?></button>
            <button id="obtMultiBrowseCancelSelect" class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('common/main/main', 'tCMNClose'); ?></button>
        </div>
    </div>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-5 col-lg-5">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" id="oetMultiBrowseInputFilterSerch" class="form-control" value="<?php echo $tFilterSearch; ?>" autocomplete="off" placeholder="<?php echo language('common/main/main', 'tPlaceholder'); ?>">
                    <span class="input-group-btn">
                        <button type="button" id="obtMultiBrowseInputFilterSerch" class="btn xCNBtnSearch"><img class="xCNIconSearch"></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div id="odvDataTableMultiBrowse" class="row">
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
            <div class="table-responsive">
                <table id="otbMultiBrowseDataTable" class='table table-striped' style="width:100%">
                    <thead>
                        <tr>
                            <th class='xCNTextBold' style='text-align:center' width="10%">
                                <label class="fancy-checkbox">
                                    <input id="ocbCheckSelectAllData" type="checkbox" name="ocbCheckSelectAllData">
                                    <span>&nbsp;</span>
                                </label>
                            </th>
                            <?php echo $tHtmlTableHeard; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $tHtmlTableData; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // Check Data Set Default
        let nStatusCheckAll = $('#ohdMultiBrowseCallBackStaAll').val();
        let tOldCallBackVal = $('#ohdMultiBrowseCallBackValue').val();
        let tOldCallBackText = $('#ohdMultiBrowseCallBackText').val();
        if (nStatusCheckAll != '' && nStatusCheckAll == 1) {

            $('.xWMultiSelectItems').prop('checked', true);
            $('#ocbCheckSelectAllData').prop('checked', true);
            $('#ohdMultiBrowseCallBackStaAll').val(1);
            JCNxLoopSetInputDataValueAndText();
        } else {
            if (tOldCallBackVal != '' && tOldCallBackText != '') {
                let aOldCallBackVal = tOldCallBackVal.split(',');
                $.each(aOldCallBackVal, function(nKey, tValue) {
                    $('#odvModalBrowseMulti #otbMultiBrowseDataTable .xWMultiDataItems[data-code="' + tValue + '"]').find('.xWMultiSelectItems').prop('checked', true);
                });
            }
        }
    });

    // Event Check All Data In Table
    $('#ocbCheckSelectAllData').unbind().click(function() {
        let nStatusCheckAll = $('#ohdMultiBrowseCallBackStaAll').val();
        if (nStatusCheckAll == '') {
            $('.xWMultiSelectItems').prop('checked', true);
            $('#ohdMultiBrowseCallBackStaAll').val(1);
            JCNxLoopSetInputDataValueAndText();
        } else {
            $('.xWMultiSelectItems').prop('checked', false);
            $('#ohdMultiBrowseCallBackStaAll').val('');
            JCNxLoopSetInputDataValueAndText();
        }
        //กดเลือกทั้งหมด ใช้หรับหน้าจอ Dashboard
        if ($('#ohdDSHSALFilterKey').val() != '' || $('#ohdDSHSALFilterKey').val() != null || $('#ohdDSHSALFilterKey').val() != undefined) {
            if ($('#ohdDSHSALFilterKey').val() == 'RCSPBT' || $('#ohdDSHSALFilterKey').val() == 'RCSPBT2' || $('#ohdDSHSALFilterKey').val() == 'RPTComSalePdt' || $('#ohdDSHSALFilterKey').val() == 'RPTComSalePdt2') {
                $('.xWMultiSelectItems').prop('checked', false);



                if (nStatusCheckAll == '') {
                    for (var i = 0; i < 10; i++) {
                        if (i < 10) {
                            $('#otbMultiBrowseDataTable tbody .xWMultiDataItems:eq(' + i + ')').find('.xWMultiSelectItems').prop('checked', true);

                        } else {
                            alert('เลือกได้มากสุด 10 ตัว');
                        }
                    }
                    JCNxLoopSetInputDataValueAndText();
                } else {
                    $('#ocbCheckSelectAllData').prop('checked', false);
                    $('#ohdMultiBrowseCallBackStaAll').val('');
                    // Send Function Loop Set Data To Inpue
                    JCNxLoopSetInputDataValueAndText();
                }

            }
        }
    });


    // Event Enter Serch Input Modal 
    $('#oetMultiBrowseInputFilterSerch').bind('keypress', function(Evn) {
        if (Evn.keyCode == 13) {
            let tOptionModal = $('#odvModalBrowseMulti #ohdMultiBrowseOptionName').val();
            JCNxSearchMultiBrowse(tOptionModal);
        }
    });

    // Event Click Serch Input Modal 
    $('#obtMultiBrowseInputFilterSerch').unbind().click(function() {
        let tOptionModal = $('#odvModalBrowseMulti #ohdMultiBrowseOptionName').val();
        JCNxSearchMultiBrowse(tOptionModal);
    });

    // Event Click Button Confirm Select
    $('#obtMultiBrowseConfirmSelect').unbind().click(function() {
        let tOptionModal = $('#odvModalBrowseMulti #ohdMultiBrowseOptionName').val();
        JCNxMultiBrowseConfirmSelected(tOptionModal);
    });


    // Event Click Single Select Multi Browse
    var nLimitBrowse = 11;
    var nCheck = 0;
    var nCountLoopMultiShowDashboard = 0;
    $('.xWMultiSelectItems').unbind().click(function() {
        //กดเลือก ใช้สำหรับหน้าจอ Dashboard
        if ($('#ohdDSHSALFilterKey').val() != '' || $('#ohdDSHSALFilterKey').val() != null || $('#ohdDSHSALFilterKey').val() != undefined) {
            if ($('#ohdDSHSALFilterKey').val() == 'RCSPBT' || $('#ohdDSHSALFilterKey').val() == 'RCSPBT2' || $('#ohdDSHSALFilterKey').val() == 'RPTComSalePdt' || $('#ohdDSHSALFilterKey').val() == 'RPTComSalePdt2') {

                var nCheckBoxBefore = 0;
                $('#otbMultiBrowseDataTable .xWMultiDataItems').each(function() {
                    var nStaChk = ($(this).find('.xWMultiSelectItems').is(":checked")) ? 1 : 0;
                    if (nStaChk == 1) {
                        nCheckBoxBefore++;
                    }
                });

                //ถ้าวนลูปเเล้วจำนวนที่มีก่อนหน้าเท่ากับ จำนวนที่เลือกได้ จะไม่สามารถเลือกได้อีก
                if (nCheckBoxBefore == nLimitBrowse) {
                    $(this).prop('checked', false);
                    alert('เลือกได้มากสุด 10 ตัว');
                } else {
                    if ($(this).is(":checked") == true) {
                        nCheck = nCountLoopMultiShowDashboard + 1;
                    } else {
                        nCheck = nCountLoopMultiShowDashboard - 1;
                    }

                    if (nCheck >= nLimitBrowse) {
                        $(this).prop('checked', false);
                        alert('เลือกได้มากสุด 10 ตัว');
                        nCheck = nLimitBrowse - 1;
                        nCountLoopMultiShowDashboard = nLimitBrowse - 1;
                    } else {
                        nCountLoopMultiShowDashboard = nCheck;
                    }
                    JCNxLoopSetInputDataValueAndText();
                }

            } else {
                // Clear Check Boox All And Clear Input Sta Check All
                $('#ocbCheckSelectAllData').prop('checked', false);
                $('#ohdMultiBrowseCallBackStaAll').val('');
                // Send Function Loop Set Data To Inpue
                JCNxLoopSetInputDataValueAndText();
            }
        }
    });
</script>