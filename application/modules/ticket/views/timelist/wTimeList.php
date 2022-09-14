<?php if (@$_GET['dow'] == '1') : ?>
<script>  $('.nav-tabs a[href="#oShowTimeDOW"]').tab('show');</script>
        <?php endif; ?>
         <?php if (@$_GET['hld'] == '1') : ?>
         <script>      $('.nav-tabs a[href="#oTimeHoliday"]').tab('show');</script>
        <?php endif; ?>
<script>
    $(function () {
        $('.orbFNTmhIDS').change(function () {
            orbFNTmhID = this.value;
            $('.xCNMultiselect label').removeClass('active');
            $('#otbRadios' + orbFNTmhID).addClass('active');
            $.ajax({
                type: "POST",
                url: "EticketTimeTable/TimeTablePickList",
                data: {orbFNTmhID: orbFNTmhID},
                cache: false,
                success: function (msg) {
                    $('#oTimeDOWPickList').html(msg);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
        $('.orbFNTmhIDH').change(function () {
            orbFNTmhID = this.value;
            $('.xCNMultiselect label').removeClass('active');
            $('#otbRadioH' + orbFNTmhID).addClass('active');
            $.ajax({
                type: "POST",
                url: "EticketTimeTable/TimeTablePickList",
                data: {orbFNTmhID: orbFNTmhID},
                cache: false,
                success: function (msg) {
                    $('#oTimeHolidayPickList').html(msg);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
        $("#oFmTimeDOWList").validate({
            rules: {
                orbFNTmhID: "required"
            },
            messages: {
                orbFNTmhID: ""
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
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>EticketTimeTable/TimeDOWAddList",
                    data: $("#oFmTimeDOWList").serialize(),
                    cache: false,
                    success: function (msg) {
                        var ohdGetEventId = $('#ohdGetEventId').val();
                        var ohdGetLocId = $('#ohdGetLocId').val();
                        $('.modal-backdrop').remove();
                        JSxCallPage('<?= base_url() ?>EticketTimeTable/TimeTableList/' + ohdGetEventId + '/' + ohdGetLocId + '?dow=1');
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
                return false;
            }
        });
        $("#oFmTimeHolidayList").validate({
            rules: {
                orbFNTmhID: "required"
            },
            messages: {
                orbFNTmhID: ""
            },
            errorClass: "input-invalid",
            validClass: "input-valid",
            highlight: function (element, errorClass, validClass) {
                $(element).addClass(errorClass).removeClass(validClass);
                $(element).parent().addClass('focused');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass(errorClass).addClass(validClass);
            },
            submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>EticketTimeTable/TimeHolidayAddList",
                    data: $("#oFmTimeHolidayList").serialize(),
                    cache: false,
                    success: function (msg) {
                        var ohdGetEventId = $('#ohdGetEventId').val();
                        var ohdGetLocId = $('#ohdGetLocId').val();
                        JSxCallPage('<?= base_url() ?>EticketTimeTable/TimeTableList/' + ohdGetEventId + '/' + ohdGetLocId + '?hld=1');
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
                return false;
            }
        });
     
    
        $('.nav-tabs a[href="#oTimeHoliday"]').on('shown.bs.tab', function (e) {
            $('.icon-loading').show();
            $('.calendar').fullCalendar({
                dayClick: function (date, jsEvent, view) {
                    $(this).css('background-color', 'yellow');
                    var dDateSelecte = date.format();
                    JSxSHTWeekend(dDateSelecte, $(this));
                },
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                defaultDate: '<?= date('Y-m-d') ?>',
                navLinks: false,
                editable: true,
                eventLimit: true,
                events: {
                    url: '<?= base_url() ?>EticketTimeTable/FullCalendarEvent',
                    type: 'POST',
                    data: {nEvnID: '<?= $nEvnID ?>', nLocID: '<?= $nLocID ?>'},
                    success: function (msg) {
                        $('.icon-loading').hide();
                    },
                    error: function () {
                        $('.icon-loading').hide();
                        //alert('There was an error while fetching events.');
                    }
                },
                eventClick: function (event) {
                    $.ajax({
                        type: "POST",
                        url: "EticketTimeTable/FullCalendarEventList",
                        data: {nFNTmhID: event.id, nFNEvnID: '<?= $nEvnID ?>', nFNLocID: '<?= $nLocID ?>', tDate: event.datetime},
                        cache: false,
                        success: function (msg) {
                            $('#odvDate_Selected').html(msg);
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                }
            });
        });
        function JSxSHTWeekend(ptDateSelected, elm) {
            aDateSelected = ptDateSelected.split('-');
            tDateSelected = aDateSelected[0] + '-' + aDateSelected[1] + '-' + aDateSelected[2];
            $('#ohdFDSthCheckIn').val(tDateSelected);
            $('#oModalTimeHoliday').modal('show');
        }
        $('#oModalTimeDOW').on('hidden.bs.modal', function () {
            $('.xCNMultiselect label').removeClass('active');
            $('#oTimeDOWPickList').html('');
            $('#onbFNShwCallB4Start').val('');
            $('#onbFNShwDuration').val('');
        });
        $('#oModalTimeHoliday').on('hidden.bs.modal', function () {
            $('.xCNMultiselect label').removeClass('active');
            $('#oTimeHolidayPickList').html('');
            $('#onbFNShwCallB4Start').val('');
            $('#onbFNShwDuration').val('');
        });
        $('#oetFDShwStartDate').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
        });
        $('#oetFDShwEndDate').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
        });
        /// check แสดงรอบปกติ
        $('.nav-tabs a[href="#oTimeTable"]').on('shown.bs.tab', function (e) {
            //JSxTLTSTCount();
        });
        $('[title]').tooltip();
    });
</script>

<div class="xCNMrgNavMenu">
    <div class="row xCNavRow" style="width:inherit;">
        <div class="xCNBchVMaster">
            <div class="col-xs-8 col-md-8">
                <ol id="oliMenuNav" class="breadcrumb">
                    <li class="xCNLinkClick" id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>/EticketEvent')"><?= language('ticket/event/event', 'tEventInformation') ?></li>
                    <li class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>/EticketShowTime/<?php echo $nEvnID; ?>')"><?= language('ticket/event/event', 'tManageEvents') ?></li>
                    <li class="xCNLinkClick"> <?= language('ticket/event/event', 'tShowTime') ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="main-content">
    <div class="panel panel-headline">
        <div class="panel-heading"> 
            <div class="container-fluid">
                <div class="row xWLocation" id="odvModelData">
                    <div class="col-md-2">		
                        <!-- <?php if ($oEvent[0]->FTImgObj != ""): ?>
                            <img class="img-reponsive" src="<?= base_url('/application/modules/') ?><?= $oEvent[0]->FTImgObj ?>">
                        <?php else : ?>
                            <img class="img-reponsive"	src="<?php echo base_url('application/modules/common/assets/images/NoPic.png'); ?>">
                        <?php endif ?> -->
                        <?php
                        if(isset($oEvent->FTImgObj) && !empty($oEvent->FTImgObj)){
                            $tFullPatch = './application/modules/'.$oEvent->FTImgObj;
                            if (file_exists($tFullPatch)){
                                $tPatchImg = base_url().'/application/modules/'.$oEvent->FTImgObj;
                            }else{
                                $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                            }
                        }else{
                            $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                        }
                        ?>
                        <img class="img-reponsive" src="<?=$tPatchImg?>" style="width:200px;height:144px;">
                    </div>
                    <div class="col-md-4">
                        <div>
                            <b>
                                <?php if (@$oEvent[0]->FTEvnName): ?>
                                    <?= $oEvent[0]->FTEvnName ?>
                                <?php else: ?>
                                    <?= language('ticket/zone/zone', 'tNoData') ?>
                                <?php endif; ?>
                            </b> 
                            <br>
                            <div class="xWLocation-Detail">
                                <?= date("d-m-Y H:i", strtotime($oEvent[0]->FDEvnStartSale)) ?><?php
                                if ($oEvent[0]->FDEvnStopSale != "") {
                                    echo ' - ' . date("d-m-Y H:i", strtotime($oEvent[0]->FDEvnStopSale));
                                }
                                ?><br>           
                            </div>
                        </div>
                    </div>		
                    <div class="col-md-1">
                        <img src="<?php echo base_url('application/modules/common/assets/images/icons/icons8-Sort.png'); ?>" style="margin-top: 10px;">
                    </div>		
                    <div class="col-md-2">		
                        <!-- <?php if ($oLoc[0]->FTImgObj != ""): ?>
                            <img class="img-reponsive" src="<?= base_url('/application/modules/') ?><?= $oLoc[0]->FTImgObj ?>">
                        <?php else : ?>
                            <img class="img-reponsive" src="<?php echo base_url('application/modules/common/assets/images/NoPic.png'); ?>">
                        <?php endif ?> -->
                        <?php
                        if(isset($oLoc->FTImgObj) && !empty($oLoc->FTImgObj)){
                            $tFullPatch = './application/modules/'.$oLoc->FTImgObj;
                            if (file_exists($tFullPatch)){
                                $tPatchImgLoc = base_url().'/application/modules/'.$oLoc->FTImgObj;
                            }else{
                                $tPatchImgLoc = base_url().'application/modules/common/assets/images/Noimage.png';
                            }
                        }else{
                            $tPatchImgLoc = base_url().'application/modules/common/assets/images/Noimage.png';
                        }
                        ?>
                        <img class="img-reponsive" src="<?=$tPatchImgLoc?>" style="width:200px;height:144px;">
                    </div>
                    <div class="col-md-3">
                        <div>
                            <b>
                                <?php if (@$oLoc[0]->FTLocName): ?>
                                    <?= $oLoc[0]->FTLocName ?>
                                <?php else: ?>
                                    <?= language('ticket/zone/zone', 'tNoData') ?>
                                <?php endif; ?>
                            </b> 
                            <br>
                            <div class="xWLocation-Detail">
                                <?= language('ticket/zone/zone', 'tAmountLimit') ?>      <?php echo @$oLoc[0]->FNLocLimit; ?> <?= language('ticket/zone/zone', 'tPersons') ?><br>
                                <?= language('ticket/zone/zone', 'tOpeninghours') ?>      <?php echo @$oLoc[0]->FTLocTimeOpening; ?> - <?php echo @$oLoc[0]->FTLocTimeClosing; ?><br>          
                            </div>
                        </div>			
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="main-content">
            <div class="panel panel-headline">
                <div class="panel-heading">	
                    <div style="margin-left: 15px; margin-right: 15px;">
                          <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item  active">
                            <a class="nav-link flat-buttons active" data-toggle="tab" href="#oTimeTable" role="tab" aria-expanded="false">
                            <?= language('ticket/event/event', 'tTimeTable') ?>
                            </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link flat-buttons" data-toggle="tab" href="#oShowTimeDOW" role="tab" aria-expanded="false">
                                <?= language('ticket/event/event', 'tDayOfWeek') ?> 
                                </a>
                        </li>
                        <li class="nav-item">
                                <a class="nav-link flat-buttons" data-toggle="tab" href="#oTimeHoliday" role="tab" aria-expanded="false">
                                <?= language('ticket/event/event', 'tHoliday') ?>
                                </a>
                        </li>
                        </ul> 
                        </div>
                    </div>	

                    <div class="tab-content" style="position: relative;">		
                        <!-- TimeTable -->
                        <div id="oTimeTable" class="tab-pane fade in active">
                            <?php if ($oAuthen['tAutStaAdd'] == '1'): ?>
                                <button type="button" class="xCNBTNPrimeryPlus" id="oBTNTLTST" style="position: absolute; right: 15px; top: -44px;" onclick="JSxCallPage('<?php echo base_url(); ?>EticketTimeTable/AddTimeTableST/<?= $nEvnID; ?>/<?= $nLocID; ?>');">+</button>
                            <?php endif; ?>
                            <div style="margin-top: 20px;">
                                <div class="row" style="display: none;">
                                    <div class="col-md-8">
                                        <div class="form-group input-group">
                                            <input type="text" id="oetSCHFTTLTSTName" onkeypress="javascript: if (event.keyCode == 13) {
                                                        event.preventDefault();
                                                        JSxTLTSTCount();}" name="oetSCHFTTLTSTName" class="form-control" placeholder="<?= language('ticket/event/event', 'tSearchShowTime') ?>">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default btn_search" style="padding: 6px 15px;" onclick="JSxTLTSTCount();" type="button">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                <div id="oResultTimeTable"></div>	
                                <div class="row" style="display: none;"> 
                                    <div class="col-md-4 text-left grid-resultpage"><?= language('ticket/zone/zone', 'tFound') ?> <span id="ospTotalTLTSTRecord"> 0</span> <?= language('ticket/zone/zone', 'tList') ?> <a class="xWBoxLocPark" style="color: rgb(51, 51, 51); text-decoration: none;"><?= language('ticket/zone/zone', 'tShowpage') ?> <span id="ospPageTLTSTActive">0</span> / <span id="ospTotalTLTSTPage">0</span></a></div>	                     
                                    <div class="col-md-8 text-right xWGridFooter xWBoxLocPark">
                                        <button type="button" id="oPreviousPage" onclick="return JSxTLTSTPreviousPage();" class="btn btn-default" data-toggle="tooltip" data-placement="left" data-original-title="Tooltip on left">
                                            <i class="fa fa-angle-left"></i> <?= language('ticket/zone/zone', 'tPrevious') ?>
                                        </button>
                                        <button type="button" id="oForwardPage" onclick="return JSxTLTSTForwardPage();" class="btn btn-default" data-toggle="tooltip" data-placement="left" data-original-title="Tooltip on left">
                                            <?= language('ticket/zone/zone', 'tForward') ?> <i class="fa fa-angle-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div> 																																																	
                        </div>	
                        <!-- TimeDOW -->
                        <div id="oShowTimeDOW" class="tab-pane fade">				
                            <div id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="card">						
                                    <?php $oDOW1 = $this->mTimeList->FSxMTLTShowTimeDOW($nEvnID, $nLocID, '1') ?>
                                    <div class="card-header" role="tab" id="heading1">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#day1" aria-expanded="true">
                                            <?= language('ticket/event/event', 'tMonday') ?>
                                        </a>
                                        <div class="pull-right" style="margin-top: -7px;">	
                                            <?php if (@$oDOW1[0]->FNStdDayOfWeek == ""): ?>
                                                <?php if ($oAuthen['tAutStaAdd'] == '1'): ?>
                                                    <a href="#" style=" margin-top: 9px; float: left; " data-toggle="modal" data-target="#oModalTimeDOW" onclick="javascript: $('#ohdFNTmeDayOfWeek').val('1');"><i class="fa fa-plus"></i></a>		                		                	
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                                                    <a href="#" style="margin-right: 10px; margin-top: 9px; float: left; " onclick="JSxTLTDelTimeDOW('<?= $nEvnID ?>', '<?= $nLocID ?>', '1');"><img class="xCNIconTable" src="<?php echo base_url().'application/modules/common/assets/images/icons/delete.png'?>"></a>
                                                <?php endif; ?>
                                                <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                                                    <a href="#" style=" margin-top: 9px; float: left; " data-toggle="modal" data-target="#oModalTimeDOW" onclick="javascript: $('#ohdFNTmeDayOfWeek').val('1'); $('#otbRadios<?= $oDOW1[0]->FNTmhID; ?>').addClass('active'); $('#orbFNTmhID<?= $oDOW1[0]->FNTmhID; ?>').attr('checked', true).prop('checked', true);
                                                                    $('#oModalTimeDOW #onbFNShwCallB4Start').val('<?= $oDOW1[0]->FNStdCallB4Start; ?>');
                                                                    $('#oModalTimeDOW #onbFNShwDuration').val('<?= $oDOW1[0]->FNStdDuration; ?>');"><img class="xCNIconTable" src="<?php echo base_url().'application/modules/common/assets/images/icons/edit.png'?>"></a>
                                                   <?php endif; ?>
                                               <?php endif; ?>
                                        </div>
                                    </div>
                                    <div id="day1" class="collapse" role="tabpanel" aria-expanded="true">
                                        <div class="card-block"> 
                                            <?php if (@$oDOW1[0]->FNStdDayOfWeek == ""): ?>
                                                <div style="padding: 10px;"> 
                                                    <?= language('ticket/zone/zone', 'tNoData') ?>
                                                </div>	
                                            <?php else: ?>
                                                <?php foreach ($oDOW1 AS $oValue): ?>	
                                                    <div style="padding-top: 5px; padding-bottom: 5px;"><?php echo $oValue->FTTmdName ?> <?php echo $oValue->FTTmdStartTime ?> - <?php echo $oValue->FTTmdEndTime ?></div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div> 
                                    <?php $oDOW2 = $this->mTimeList->FSxMTLTShowTimeDOW($nEvnID, $nLocID, '2') ?>
                                    <div class="card-header" role="tab" id="heading1">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#day2" aria-expanded="true">
                                            <?= language('ticket/event/event', 'tTuesday') ?>
                                        </a>
                                        <div class="pull-right" style="margin-top: -7px;">
                                            <?php if (@$oDOW2[0]->FNStdDayOfWeek == ""): ?>
                                                <?php if ($oAuthen['tAutStaAdd'] == '1'): ?>
                                                    <a href="#" style=" margin-top: 9px; float: left; " data-toggle="modal" data-target="#oModalTimeDOW" onclick="javascript: $('#ohdFNTmeDayOfWeek').val('2');"><i class="fa fa-plus"></i></a>		                		                	
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                                                    <a href="#" style="margin-right: 10px; margin-top: 9px; float: left; " onclick="JSxTLTDelTimeDOW('<?= $nEvnID ?>', '<?= $nLocID ?>', '2');"><img class="xCNIconTable" src="<?php echo base_url().'application/modules/common/assets/images/icons/delete.png'?>"></a>
                                                <?php endif; ?>
                                                <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                                                    <a href="#" style=" margin-top: 9px; float: left; " data-toggle="modal" data-target="#oModalTimeDOW" onclick="javascript: $('#ohdFNTmeDayOfWeek').val('2');
                                                                    $('#otbRadios<?= $oDOW2[0]->FNTmhID; ?>').addClass('active');
                                                                    $('#orbFNTmhID<?= $oDOW2[0]->FNTmhID; ?>').attr('checked', true).prop('checked', true);
                                                                    $('#oModalTimeDOW #onbFNShwCallB4Start').val('<?= $oDOW2[0]->FNStdCallB4Start; ?>');
                                                                    $('#oModalTimeDOW #onbFNShwDuration').val('<?= $oDOW2[0]->FNStdDuration; ?>');"><img class="xCNIconTable" src="<?php echo base_url().'application/modules/common/assets/images/icons/edit.png'?>"></a>
                                                   <?php endif; ?>
                                               <?php endif; ?>
                                        </div>
                                    </div>
                                    <div id="day2" class="collapse" role="tabpanel" aria-expanded="true">
                                        <div class="card-block"> 
                                            <?php if (@$oDOW2[0]->FNStdDayOfWeek == ""): ?>
                                                <div style="padding: 10px;"> 
                                                    <?= language('ticket/zone/zone', 'tNoData') ?>
                                                </div>	
                                            <?php else: ?>
                                                <?php foreach ($oDOW2 AS $oValue): ?>	
                                                    <div style="padding-top: 5px; padding-bottom: 5px;"><?php echo $oValue->FTTmdName ?> <?php echo $oValue->FTTmdStartTime ?> - <?php echo $oValue->FTTmdEndTime ?></div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php $oDOW3 = $this->mTimeList->FSxMTLTShowTimeDOW($nEvnID, $nLocID, '3') ?>
                                    <div class="card-header" role="tab" id="heading1">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#day3" aria-expanded="true">
                                            <?= language('ticket/event/event', 'tWednesday') ?>
                                        </a>
                                        <div class="pull-right" style="margin-top: -7px;">
                                            <?php if (@$oDOW3[0]->FNStdDayOfWeek == ""): ?>
                                                <?php if ($oAuthen['tAutStaAdd'] == '1'): ?>
                                                    <a href="#" style=" margin-top: 9px; float: left; " data-toggle="modal" data-target="#oModalTimeDOW" onclick="javascript: $('#ohdFNTmeDayOfWeek').val('3');"><i class="fa fa-plus"></i></a>		                		                	
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                                                    <a href="#" style="margin-right: 10px; margin-top: 9px; float: left; " onclick="JSxTLTDelTimeDOW('<?= $nEvnID ?>', '<?= $nLocID ?>', '3');"><img class="xCNIconTable" src="<?php echo base_url().'application/modules/common/assets/images/icons/delete.png'?>"></i></a>
                                                <?php endif; ?>
                                                <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                                                    <a href="#" style=" margin-top: 9px; float: left; " data-toggle="modal" data-target="#oModalTimeDOW" onclick="javascript: $('#ohdFNTmeDayOfWeek').val('3');
                                                                    $('#otbRadios<?= $oDOW3[0]->FNTmhID; ?>').addClass('active');
                                                                    $('#orbFNTmhID<?= $oDOW3[0]->FNTmhID; ?>').attr('checked', true).prop('checked', true);
                                                                    $('#oModalTimeDOW #onbFNShwCallB4Start').val('<?= $oDOW3[0]->FNStdCallB4Start; ?>');
                                                                    $('#oModalTimeDOW #onbFNShwDuration').val('<?= $oDOW3[0]->FNStdDuration; ?>');"><img class="xCNIconTable" src="<?php echo base_url().'application/modules/common/assets/images/icons/edit.png'?>"></a>
                                                   <?php endif; ?>
                                               <?php endif; ?>
                                        </div>
                                    </div>
                                    <div id="day3" class="collapse" role="tabpanel" aria-expanded="true">
                                        <div class="card-block"> 	
                                            <?php if (@$oDOW3[0]->FNStdDayOfWeek == ""): ?>
                                                <div style="padding: 10px;"> 
                                                    <?= language('ticket/zone/zone', 'tNoData') ?>
                                                </div>	
                                            <?php else: ?>
                                                <?php foreach ($oDOW3 AS $oValue): ?>	
                                                    <div style="padding-top: 5px; padding-bottom: 5px;"><?php echo $oValue->FTTmdName ?> <?php echo $oValue->FTTmdStartTime ?> - <?php echo $oValue->FTTmdEndTime ?></div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>	
                                    <?php $oDOW4 = $this->mTimeList->FSxMTLTShowTimeDOW($nEvnID, $nLocID, '4') ?>            
                                    <div class="card-header" role="tab" id="heading1">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#day4" aria-expanded="true">
                                            <?= language('ticket/event/event', 'tThursday') ?>
                                        </a>
                                        <div class="pull-right" style="margin-top: -7px;">
                                            <?php if (@$oDOW4[0]->FNStdDayOfWeek == ""): ?>
                                                <?php if ($oAuthen['tAutStaAdd'] == '1'): ?>
                                                    <a href="#" style=" margin-top: 9px; float: left; " data-toggle="modal" data-target="#oModalTimeDOW" onclick="javascript: $('#ohdFNTmeDayOfWeek').val('4');"><i class="fa fa-plus"></i></a>		                		                	
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                                                    <a href="#" style="margin-right: 10px; margin-top: 9px; float: left; " onclick="JSxTLTDelTimeDOW('<?= $nEvnID ?>', '<?= $nLocID ?>', '4');"><img class="xCNIconTable" src="<?php echo base_url().'application/modules/common/assets/images/icons/delete.png'?>"></i></a>
                                                <?php endif; ?>
                                                <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                                                    <a href="#" style=" margin-top: 9px; float: left; " data-toggle="modal" data-target="#oModalTimeDOW" onclick="javascript: $('#ohdFNTmeDayOfWeek').val('4');
                                                                    $('#otbRadios<?= $oDOW4[0]->FNTmhID; ?>').addClass('active');
                                                                    $('#orbFNTmhID<?= $oDOW4[0]->FNTmhID; ?>').attr('checked', true).prop('checked', true); $('#oModalTimeDOW #onbFNShwCallB4Start').val('<?= $oDOW4[0]->FNStdCallB4Start; ?>'); $('#oModalTimeDOW #onbFNShwDuration').val('<?= $oDOW4[0]->FNStdDuration; ?>');"><img class="xCNIconTable" src="<?php echo base_url().'application/modules/common/assets/images/icons/edit.png'?>"></a>
                                                   <?php endif; ?>
                                               <?php endif; ?>
                                        </div>
                                    </div>
                                    <div id="day4" class="collapse" role="tabpanel" aria-expanded="true">
                                        <div class="card-block"> 
                                            <?php if (@$oDOW4[0]->FNStdDayOfWeek == ""): ?>
                                                <div style="padding: 10px;"> 
                                                    <?= language('ticket/zone/zone', 'tNoData') ?>
                                                </div>	
                                            <?php else: ?>
                                                <?php foreach ($oDOW4 AS $oValue): ?>	
                                                    <div style="padding-top: 5px; padding-bottom: 5px;"><?php echo $oValue->FTTmdName ?> <?php echo $oValue->FTTmdStartTime ?> - <?php echo $oValue->FTTmdEndTime ?></div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php $oDOW5 = $this->mTimeList->FSxMTLTShowTimeDOW($nEvnID, $nLocID, '5') ?>
                                    <div class="card-header" role="tab" id="heading1">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#day5" aria-expanded="true">
                                            <?= language('ticket/event/event', 'tFriday') ?>
                                        </a>
                                        <div class="pull-right" style="margin-top: -7px;">
                                            <?php if (@$oDOW5[0]->FNStdDayOfWeek == ""): ?>
                                                <?php if ($oAuthen['tAutStaAdd'] == '1'): ?>
                                                    <a href="#" style=" margin-top: 9px; float: left; " data-toggle="modal" data-target="#oModalTimeDOW" onclick="javascript: $('#ohdFNTmeDayOfWeek').val('5');"><i class="fa fa-plus"></i></a>		                		                	
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                                                    <a href="#" style="margin-right: 10px; margin-top: 9px; float: left; " onclick="JSxTLTDelTimeDOW('<?= $nEvnID ?>', '<?= $nLocID ?>', '5');"><img class="xCNIconTable" src="<?php echo base_url().'application/modules/common/assets/images/icons/delete.png'?>"></i></a>
                                                <?php endif; ?>
                                                <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                                                    <a href="#" style=" margin-top: 9px; float: left; " data-toggle="modal" data-target="#oModalTimeDOW" onclick="javascript: $('#ohdFNTmeDayOfWeek').val('5');
                                                                    $('#otbRadios<?= $oDOW5[0]->FNTmhID; ?>').addClass('active');
                                                                    $('#orbFNTmhID<?= $oDOW5[0]->FNTmhID; ?>').attr('checked', true).prop('checked', true);
                                                                    $('#oModalTimeDOW #onbFNShwCallB4Start').val('<?= $oDOW5[0]->FNStdCallB4Start; ?>');
                                                                    $('#oModalTimeDOW #onbFNShwDuration').val('<?= $oDOW5[0]->FNStdDuration; ?>');"><img class="xCNIconTable" src="<?php echo base_url().'application/modules/common/assets/images/icons/edit.png'?>"></a>
                                                   <?php endif; ?>
                                               <?php endif; ?>
                                        </div>
                                    </div>
                                    <div id="day5" class="collapse" role="tabpanel" aria-expanded="true">
                                        <div class="card-block"> 
                                            <?php if (@$oDOW5[0]->FNStdDayOfWeek == ""): ?>
                                                <div style="padding: 10px;"> 
                                                    <?= language('ticket/zone/zone', 'tNoData') ?>
                                                </div>	
                                            <?php else: ?>
                                                <?php foreach ($oDOW5 AS $oValue): ?>	
                                                    <div style="padding-top: 5px; padding-bottom: 5px;"><?php echo $oValue->FTTmdName ?> <?php echo $oValue->FTTmdStartTime ?> - <?php echo $oValue->FTTmdEndTime ?></div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>		
                                    <?php $oDOW6 = $this->mTimeList->FSxMTLTShowTimeDOW($nEvnID, $nLocID, '6') ?>               
                                    <div class="card-header" role="tab" id="heading1">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#day6" aria-expanded="true">
                                            <?= language('ticket/event/event', 'tSaturday') ?> 
                                        </a>
                                        <div class="pull-right" style="margin-top: -7px;">
                                            <?php if (@$oDOW6[0]->FNStdDayOfWeek == ""): ?>
                                                <?php if ($oAuthen['tAutStaAdd'] == '1'): ?>
                                                    <a href="#" style=" margin-top: 9px; float: left; " data-toggle="modal" data-target="#oModalTimeDOW" onclick="javascript: $('#ohdFNTmeDayOfWeek').val('6');"><i class="fa fa-plus"></i></a>		                		                	
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                                                    <a href="#" style="margin-right: 10px; margin-top: 9px; float: left; " onclick="JSxTLTDelTimeDOW('<?= $nEvnID ?>', '<?= $nLocID ?>', '6');"><img class="xCNIconTable" src="<?php echo base_url().'application/modules/common/assets/images/icons/delete.png'?>"></i></a>
                                                <?php endif; ?>
                                                <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                                                    <a href="#" style=" margin-top: 9px; float: left; " data-toggle="modal" data-target="#oModalTimeDOW" onclick="javascript: $('#ohdFNTmeDayOfWeek').val('6');
                                                                    $('#otbRadios<?= $oDOW6[0]->FNTmhID; ?>').addClass('active');
                                                                    $('#orbFNTmhID<?= $oDOW6[0]->FNTmhID; ?>').attr('checked', true).prop('checked', true);
                                                                    $('#oModalTimeDOW #onbFNShwCallB4Start').val('<?= $oDOW6[0]->FNStdCallB4Start; ?>'); $('#oModalTimeDOW #onbFNShwDuration').val('<?= $oDOW6[0]->FNStdDuration; ?>');"><img class="xCNIconTable" src="<?php echo base_url().'application/modules/common/assets/images/icons/edit.png'?>">/a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                        </div>
                                    </div>
                                    <div id="day6" class="collapse" role="tabpanel" aria-expanded="true">
                                        <div class="card-block">  
                                            <?php if (@$oDOW6[0]->FNStdDayOfWeek == ""): ?>
                                                <div style="padding: 10px;"> 
                                                    <?= language('ticket/zone/zone', 'tNoData') ?>
                                                </div>	
                                            <?php else: ?>
                                                <?php foreach ($oDOW6 AS $oValue): ?>	
                                                    <div style="padding-top: 5px; padding-bottom: 5px;"><?php echo $oValue->FTTmdName ?> <?php echo $oValue->FTTmdStartTime ?> - <?php echo $oValue->FTTmdEndTime ?></div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>		
                                    <?php $oDOW0 = $this->mTimeList->FSxMTLTShowTimeDOW($nEvnID, $nLocID, '0') ?>                
                                    <div class="card-header" role="tab" id="heading1">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#day7" aria-expanded="true">
                                            <?= language('ticket/event/event', 'tSunday') ?>
                                        </a>
                                        <div class="pull-right" style="margin-top: -7px;">
                                            <?php if (@$oDOW0[0]->FNStdDayOfWeek == '0'): ?>
                                                <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                                                    <a href="#" style="margin-right: 10px; margin-top: 9px; float: left; " onclick="JSxTLTDelTimeDOW('<?= $nEvnID ?>', '<?= $nLocID ?>', '0');"><img class="xCNIconTable" src="<?php echo base_url().'application/modules/common/assets/images/icons/delete.png'?>"></i></a>
                                                <?php endif; ?>
                                                <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                                                    <a href="#" style=" margin-top: 9px; float: left; " data-toggle="modal" data-target="#oModalTimeDOW" onclick="javascript: $('#ohdFNTmeDayOfWeek').val('0');
                                                                    $('#otbRadios<?= @$oDOW0[0]->FNTmhID; ?>').addClass('active');
                                                                    $('#orbFNTmhID<?= @$oDOW0[0]->FNTmhID; ?>').attr('checked', true).prop('checked', true);
                                                                    $('#oModalTimeDOW #onbFNShwCallB4Start').val('<?= @$oDOW0[0]->FNStdCallB4Start; ?>');
                                                                    $('#oModalTimeDOW #onbFNShwDuration').val('<?= @$oDOW0[0]->FNStdDuration; ?>');"><img class="xCNIconTable" src="<?php echo base_url().'application/modules/common/assets/images/icons/edit.png'?>"></a>
                                                   <?php endif; ?>
                                               <?php else: ?>
                                                   <?php if ($oAuthen['tAutStaAdd'] == '1'): ?>
                                                    <a href="#" style=" margin-top: 9px; float: left; " style=" margin-top: 9px; float: left;" data-toggle="modal" data-target="#oModalTimeDOW" onclick="javascript: $('#ohdFNTmeDayOfWeek').val('0');"><i class="fa fa-plus"></i></a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div id="day7" class="collapse" role="tabpanel" aria-expanded="true">
                                        <div class="card-block"> 
                                            <?php if (@$oDOW0[0]->FNStdDayOfWeek == ""): ?>
                                                <div style="padding: 10px;"> 
                                                    <?= language('ticket/zone/zone', 'tNoData') ?>
                                                </div>	
                                            <?php else: ?>
                                                <?php foreach ($oDOW0 AS $oValue): ?>	
                                                    <div style="padding-top: 5px; padding-bottom: 5px;"><?php echo $oValue->FTTmdName ?> <?php echo $oValue->FTTmdStartTime ?> - <?php echo $oValue->FTTmdEndTime ?></div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div> 											
                                </div>																																																	
                            </div>									
                        </div>		  	  
                        <!-- TimeHoliday -->
                        <div id="oTimeHoliday" class="tab-pane fade">	  
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="calendar"></div>			  		
                                </div>
                                <div class="col-md-3">
                                    <div style="min-height: 438px; overflow-x: hidden; overflow-y: auto;">
                                        <div id="odvDate_Selected" style="padding-top: 55px;"></div>
                                    </div>			  		
                                </div>
                            </div>
                        </div>
                    </div>
                </div>	
            </div>	
        </div>	
    </div>
    <div class="modal fade" id="oModalTimeDOW" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="z-index:2000; margin-top: 60px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h5 class="xCNTextModalHeard" id="myModalLabel"><?= language('ticket/event/event', 'tShowTime') ?></h5>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="oFmTimeDOWList"> 
                        <input type="hidden" name="ohdFNTmeDayOfWeek" id="ohdFNTmeDayOfWeek" />           
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                
                                        <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tDoorOpeningPeriodBeforeShow') ?><?= language('ticket/event/event', 'tMinute') ?></label>
                                        <input class="form-control" type="number" min="0" value="0" name="onbFNShwCallB4Start" id="onbFNShwCallB4Start">
                                        <span class="focus-input100"></span>
                               
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                   
                                        <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tDuration') ?><?= language('ticket/event/event', 'tMinute') ?></label>
                                        <input class="form-control" type="number" min="0" value="0" name="onbFNShwDuration" id="onbFNShwDuration">
                                        <span class="focus-input100"></span>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="xCNMultiselect">
                                    <?php foreach ($oHD as $key => $tValue) : ?>
                                        <label id="otbRadios<?= $tValue->FNTmhID; ?>"><input type="radio" class="orbFNTmhIDS" name="orbFNTmhID" id="orbFNTmhID<?= $tValue->FNTmhID; ?>" value="<?= $tValue->FNTmhID; ?>" /><?= $tValue->FTTmhName; ?></label>
                                    <?php endforeach ?>						    
                                    <input type="hidden" name="ohdGetEventId" value="<?php echo $nEvnID; ?>">
                                    <input type="hidden" name="ohdGetLocId" value="<?php echo $nLocID; ?>">						
                                </div>	                 	                 	
                            </div>
                            <div class="col-md-6">
                                <div id="oTimeDOWPickList" style="background-color: #f4f4f4; height: 20em; padding: 10px;"></div>
                            </div>
                        </div>
                        <hr>
                        <div style="overflow: hidden;">
                            <div class="pull-right">
                                <button type="button" class="btn btn-default xCNBTNDefult" data-dismiss="modal"><?= language('ticket/user/user', 'tCancel') ?></button> &nbsp; <button type="submit" class="btn btn-default xCNBTNPrimery pull-right"><?= language('ticket/user/user', 'tSave') ?></button>
                            </div>
                        </div>                 
                    </form>                 
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class="modal fade" id="oModalTimeHoliday" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="z-index:2000; margin-top: 60px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h5 class="xCNTextModalHeard" id="myModalLabel"><?= language('ticket/event/event', 'tShowTime') ?></h5>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="oFmTimeHolidayList"> 
                    <input type="hidden" name="ohdFDSthCheckIn" id="ohdFDSthCheckIn" />           
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="wrap-input100">
                                    <span class="label-input100"><?= language('ticket/event/event', 'tDoorOpeningPeriodBeforeShow') ?><?= language('ticket/event/event', 'tMinute') ?></span>
                                    <input class="input100" type="number" min="0" value="0" name="onbFNShwCallB4Start" id="onbFNShwCallB4Start">
                                    <span class="focus-input100"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="wrap-input100">
                                    <span class="label-input100"><?= language('ticket/event/event', 'tDuration') ?><?= language('ticket/event/event', 'tMinute') ?></span>
                                    <input class="input100" type="number" min="0" value="0" name="onbFNShwDuration" id="onbFNShwDuration">
                                    <span class="focus-input100"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="xCNMultiselect">
                                <?php foreach ($oHD as $key => $tValue) : ?>
                                    <label id="otbRadioH<?= $tValue->FNTmhID; ?>"><input type="radio" class="orbFNTmhIDH" name="orbFNTmhID" id="orbFNTmhID<?= $tValue->FNTmhID; ?>" value="<?= $tValue->FNTmhID; ?>" /><?= $tValue->FTTmhName; ?></label>
                                <?php endforeach ?>						    
                                <input type="hidden" name="ohdGetEventId" value="<?php echo $nEvnID; ?>">
                                <input type="hidden" name="ohdGetLocId" value="<?php echo $nLocID; ?>">						
                            </div>	                 	                 	
                        </div>
                        <div class="col-md-6">
                            <div id="oTimeHolidayPickList" style="background-color: #f4f4f4; height: 20em; padding: 10px;"></div>
                        </div>
                    </div>
                    <hr>
                    <div style="overflow: hidden;">
                        <div class="pull-right">
                            <button type="button" class="btn btn-default xCNBTNDefult" data-dismiss="modal"><?= language('ticket/user/user', 'tCancel') ?></button> &nbsp; <button type="submit" class="btn btn-default xCNBTNPrimery pull-right"><?= language('ticket/user/user', 'tSave') ?></button>
                        </div>
                    </div>                 
                </form>                 
            </div>
        </div>
    </div>
</div>
<input type="hidden" value="<?php echo $nEvnID; ?>" id="ohdGetEventId">
<input type="hidden" value="<?php echo $nLocID; ?>" id="ohdGetLocId">


<?php if ($_SESSION['lang'] == 'en'):?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jEN.js"></script>
<?php else:?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jTH.js"></script>
<?php endif?>
<script type="text/javascript" src="<?php echo base_url('application/modules/ticket/assets/src/timelist/jTimeList.js'); ?>"></script>