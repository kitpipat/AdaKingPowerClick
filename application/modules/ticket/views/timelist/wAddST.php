<script type="text/javascript">
    $(function () {
        $('.selectpicker').selectpicker();

        $('#oetFDShwStartDate').click(function(){
            event.preventDefault();
            $('#oetFDShwStartDate').datetimepicker('show');
        });
        $(".xWAddTimeTable").validate({
            rules: {
                ocmFNTmhID: "required",
                oetFDShwStartDate: "required"
            },
            messages: {
                ocmFNTmhID: "",
                oetFDShwStartDate: ""
            },
            errorClass: "alert-validate",
            validClass: "",
            highlight: function (element, errorClass, validClass) {
                $(element).parent('.validate-input').addClass(errorClass).removeClass(validClass);
                $(element).parent().parent('.validate-input').addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parent('.validate-input').removeClass(errorClass).addClass(validClass);
                $(element).parent().parent('.validate-input').removeClass(errorClass).addClass(validClass);
            },
            submitHandler: function (form) {
                $('button[type=submit]').attr('disabled', true);
                $('.xCNOverlay').show();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>EticketTimeTable/AddTimeTableSTAjax",
                    data: $(".xWAddTimeTable").serialize(),
                    cache: false,
                    success: function (msg) {
                        console.log(msg);
                        JSxCallPage('EticketTimeTable/TimeTableList/<?php echo $nEvnID; ?>/<?php echo $nLocID; ?>');
                        $('.xCNOverlay').hide();
                    },
                    error: function (data) {
                        console.log(data);
                        $('.xCNOverlay').hide();
                    }
                });
                return false;
            }
        });
        $('[title]').tooltip();
        // $('#ocmFNTmhID').select2({
        //     placeholder: '<?= language('ticket/event/event', 'tSelectShowTime') ?>',
        // });
        $('#ocmFNTmhID').change(function () {
            $('.btn-outline-primary').attr('disabled', false);
            nFNTmhID = this.value;
            $.ajax({
                type: "POST",
                url: "EticketTimeTable/TimeTableSTPickList",
                data: {nFNTmhID: nFNTmhID},
                cache: false,
                success: function (msg) {
                    $('#oDivShowTimeST').html(msg);
                    var oCheckTime = $('#oCheckTime').val();
                    if (oCheckTime == '2') {
                        var oetFDShwStartDate = $('#oetFDShwStartDate').val();
                        var oetFDShwEndDate = $('#oetFDShwEndDate').val();
                        if (oetFDShwStartDate != "") {
                            if (oetFDShwStartDate == oetFDShwEndDate) {
                                $('.btn-outline-primary').attr('disabled', true);
                                alert('<?= language('ticket/event/event', 'tPleaseSelectADateRangeFor2Days') ?>');
                            } else {
                                $('.btn-outline-primary').attr('disabled', false);
                            }
                        }
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

        $('#obtFDShwStartDate').click(function(){
            event.preventDefault();
            $('#oetFDShwStartDate').datetimepicker('show');
        });

        $('#obtFDShwEndDate').click(function(){
            event.preventDefault();
            $('#oetFDShwEndDate').datetimepicker('show');
        });


        $('#oetFDShwStartDate').datetimepicker({
            format: 'DD-MM-YYYY',
            locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
        });
        $('#oetFDShwEndDate').datetimepicker({
            format: 'DD-MM-YYYY',
            locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
        });
    });
</script>
 <div class="main-menu">
    <form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" class="xWAddTimeTable"> 	
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="xCNBchVMaster">
                    <div class="col-xs-8 col-md-8">
                        <ol id="oliMenuNav" class="breadcrumb">
                            <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>/EticketEvent')"><?= language('ticket/event/event', 'tEventInformation') ?></li>
                            <li class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>/EticketShowTime/<?php echo $nEvnID; ?>')"><?= language('ticket/event/event', 'tManageEvents') ?></li>
                            <li class="xCNLinkClick" onclick="JSxCallPage('EticketTimeTable/TimeTableList/<?php echo $nEvnID; ?>/<?php echo $nLocID; ?>');"><?= language('ticket/event/event', 'tShowTime') ?></li>
                            <li class="xCNLinkClick" ><?= language('ticket/event/event', 'tAddShowTime') ?></li>
                        </ol>      
                            </div>
                            <div class="col-xs-12 col-md-4 text-right p-r-0">
                            <div class="demo-button xCNBtngroup">
                            <button type="button" onclick="JSxCallPage('EticketTimeTable/TimeTableList/<?php echo $nEvnID; ?>/<?php echo $nLocID; ?>');" class="btn btn-default xCNBTNDefult"><?= language('common/main/main', 'tBack') ?></button>
                            <button type="submit" class="btn btn-default xCNBTNPrimery"><?= language('ticket/user/user', 'tSave') ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="main-content">
<div class="panel panel-headline">
    <div class="panel-heading"> 
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8">
                    <div class="form-group">
                    <input type="hidden" value="<?php echo $nEvnID; ?>" name="ohdEventId" id="ohdEventId">
                    <input type="hidden" value="<?php echo $nLocID; ?>" name="ohdLocId" id="ohdLocId">	
                    <div class="form-group">
                    <div class="validate-input" data-validate="กรุณาเลือกรอบ">
                    <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tSelectShowTime') ?></label>
                    <div>
                    <select class="selectpicker form-control" id="ocmFNTmhID" name="ocmFNTmhID" title="<?= language('ticket/event/event', 'tSelectShowTime') ?>" style="width: 100%">
                    <option value=""><?= language('ticket/event/event', 'tSelectShowTime') ?></option>
                    <?php foreach ($oHD AS $oValue): ?>
                    <option value="<?= $oValue->FNTmhID ?>"><?= $oValue->FTTmhName ?></option>
                    <?php endforeach; ?>			       
                    </select>
                </div>
                <span class="focus-input100"></span>
            </div>
        </div>
    <div id="oDivShowTimeST" style="width: 100%;"></div>
        </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tStartDate') ?></label>
                            <div class="input-group">
                            <input type="text" class="form-control xCNDatepicker xCNInputMaskDate" id="oetFDShwStartDate" name="oetFDShwStartDate" value="" maxlength="10">
                            <span class="input-group-btn">
                            <button id="obtFDShwStartDate" type="button" class="btn xCNBtnDateTime">
                            <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tEndDate') ?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNDatepicker xCNInputMaskDate" id="oetFDShwEndDate" name="oetFDShwEndDate" value="" maxlength="10">
                            <span class="input-group-btn">
                            <button id="obtFDShwEndDate" type="button" class="btn xCNBtnDateTime">
                            <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>  
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="wrap-input100 bootstrap-timepicker">
                            <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tDoorOpeningPeriodBeforeShow') ?><?= language('ticket/event/event', 'tMinute') ?></label>
                            <input class="form-control" type="number" min="0" value="0" name="onbFNShwCallB4Start" id="onbFNShwCallB4Start">
                        <span class="focus-input100"></span>
                    </div>
                </div>
            </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="wrap-input100 bootstrap-timepicker input-group">
                    <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tDuration') ?><?= language('ticket/event/event', 'tMinute') ?></label>							
                        <input class="form-control" type="number" min="0" value="0" name="onbFNShwDuration" id="onbFNShwDuration">
                        <span class="focus-input100"></span>
                    </div>						
                </div>
            </div>
        </div>
            <div class="col-md-4"></div>
                </div>
                    </div>
                        </div>
                        </div>
                    </div>
                </div>  
            </div>
        </form>
    </div>
<script>
    function FsMinMax(oValue, nMin, nMax) {
        if (oValue <= 0) {
            return 0;
        } else {
            if (parseInt(oValue) < nMin || isNaN(parseInt(oValue))) {
                return parseInt(nMin);
            } else if (parseInt(oValue) > nMax) {
                return parseInt(nMax);
            } else {
                return parseInt(oValue);
            }
        }
    }
</script>