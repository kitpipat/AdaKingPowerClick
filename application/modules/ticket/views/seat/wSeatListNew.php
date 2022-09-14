<script>
    $(function () {
        /**
         * validate EditRowChr
         */
        $("#oFmEditRowChr").validate({
            rules: {
                'oetFTSetRowChr[]': {
                    required: true,
                    remote: {
                        url: "<?php echo base_url(); ?>EticketZoneCheckSeat",
                        type: "post",
                        data: {
                            oetFTSetRowChr: function () {
                                return $("#oetFTSetRowChr").val();
                            },
                            ohdFNLocID: function () {
                                return $("#ohdFNLocIDSet").val();
                            },
                            ohdFNLevID: function () {
                                return $("#ohdFNLevIDSet").val();
                            },
                            ohdFNZneID: function () {
                                return $("#ohdFNZneIDSet").val();
                            }
                        },
                        complete: function (data) {
                            /*
                             if (data.responseText != "") {
                             if(data.responseText.trim() != 'true') {
                             alert("ชื่อแถวนี้มีอยู่ระบบแล้ว");
                             }
                             }*/
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    }
                }
            },
            messages: {
                oetFTSetRowChr: ""
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
                $('.xCNOverlay').show();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>EticketEditRowChr",
                    data: $("#oFmEditRowChr").serialize(),
                    cache: false,
                    success: function (msg) {
                        $nFNLocID = $('#ohdFNLocIDSet').val();
                        $nFNLevID = $('#ohdFNLevIDSet').val();
                        $nFNZneID = $('#ohdFNZneIDSet').val();
                        JSxZNESeat($nFNLocID, $nFNLevID, $nFNZneID);
                        $('#oDivRow').html('');
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
        $('#oFmEditRowChr').keydown(function () {
            $('#oBkBnt').show();
        });
        /**
         * validate แก้ไขที่นั่ง
         */
        $("#ofmEditSeat").validate({
            rules: {
                oetFTSetName: "required"
            },
            messages: {
                oetFTSetName: "",
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
                $('.xCNOverlay').show();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>EticketEditSeat",
                    data: $("#ofmEditSeat").serialize(),
                    cache: false,
                    success: function (msg) {
                        $("#ofmEditSeat")[0].reset();
                        $('#modal-set-seat').modal('hide');
                        $tFNLocID = $('#ohdFNLocIDSet').val();
                        $tFNLevID = $('#ohdFNLevIDSet').val();
                        $tFNZneID = $('#ohdFNZneIDSet').val();
                        JSxZNESeat($tFNLocID, $tFNLevID, $tFNZneID);
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
        $('#ocmType').change(function () {
            var ocmType = $(this).val();
            if (ocmType == '1') {
                $('#oDivRowSeat').show();
                $('#oDivZneRow').hide();
                $('#oDivZneColStart').hide();
            } else if (ocmType == '2') {
                $('#oDivRowSeat').hide();
                $('#oDivZneRow').show();
                $('#oDivZneColStart').show();
            }
        });
        $("#oFmAddNewSeat").validate({
            rules: {
                oetFNZneRow: "required",
                oetFNZneCol: "required",
                oetFNZneColStart: "required"
            },
            messages: {
                oetFNZneRow: "",
                oetFNZneCol: "",
                oetFNZneColStart: ""
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
                    url: "<?php echo base_url(); ?>EticketAjaxSaveSeat",
                    data: $("#oFmAddNewSeat").serialize(),
                    cache: false,
                    success: function (msg) {
                        console.log(msg);
                        $("#oFmAddNewSeat")[0].reset();
                        $('#modal-add-seat').modal('hide');
                        $tFNLocID = $('#ohdFNLocIDSet').val();
                        $tFNLevID = $('#ohdFNLevIDSet').val();
                        $tFNZneID = $('#ohdFNZneIDSet').val();
                        JSxZNESeat($tFNLocID, $tFNLevID, $tFNZneID);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
                return false;
            }
        });
    });
</script>
<?php if (@$oRow[0]->FNLocID != ""): ?>
    <div style="overflow-x: auto;">
        <table class="table text-center xWtableShowSeat" style="margin-right: 15px; margin-left: 15px;">
            <thead>
                <tr>
                    <th style="width: 50px;"></th>
                    <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                        <th style="width: 50px;"></th>
                    <?php endif; ?>
                    <?php foreach ($oShow AS $tValue): ?>
                        <th style="text-align: center;">
                            <?= $tValue->FNSetColSeq ?>
                        </th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($oRow AS $tValue): ?>
                    <?php
                    $oSeat = $this->mZone->FSxMZNEShowSeat($tValue->FNSetRowSeq, $tValue->FTSetRowChr, $tValue->FNLocID, $tValue->FNLevID, $tValue->FNZneID);
                    ?>
                    <tr>
                        <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                            <td style="vertical-align: middle;">
                                <a href="javascript:void(0)" title="<?= language('ticket/room/room', 'tEdit') ?>" style="font-size: 16px;" onclick="javascript:var html = $('#oDivEditRow<?= $tValue->FTSetRowChr ?>').html();
                                                    $('#oDivRow').html(html);
                                                    $('#oetFTSetRowChr').val('<?= $tValue->FTSetRowChr ?>');" data-toggle="modal" data-target="#modal-seat-row"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <div id="oDivEditRow<?= $tValue->FTSetRowChr ?>">
                                    <input type="hidden" name="ohdFTSetRowChr" value="<?= $tValue->FTSetRowChr ?>">
                                    <input type="hidden" name="ohdFNLocID" value="<?= $tValue->FNLocID ?>">
                                    <input type="hidden" name="ohdFNLevID" value="<?= $tValue->FNLevID ?>">
                                    <input type="hidden" name="ohdFNZneID" value="<?= $tValue->FNZneID ?>">	
                                    <?php foreach ($oSeat AS $tSeat): ?>
                                        <input type="hidden" name="ohdFNSetID[]" value="<?= $tSeat->FNSetID ?>">	
                                    <?php endforeach ?>
                                </div>
                            </td>
                        <?php endif; ?>
                        <td style="vertical-align: middle;">	
                            <b style="text-align: center; font-weight: 600; font-size: 13px;"><?= $tValue->FTSetRowChr ?></b>
                        </td>                   				
                        <?php foreach ($oSeat AS $tSeat): ?>
                            <td>
                                <a href="javascript:void(0)" style="color: #cccccc; text-decoration: none; font-size: 13px;" onclick="javascript: $('#modal-set-seat #myModalLabel').text('<?= language('ticket/zone/zone', 'tEditSeat') ?> <?= $tSeat->FTSetName ?>');
                                                    JSxEditSeat('<?= $tSeat->FNSetID ?>', '<?= $tSeat->FTSetName ?>', '<?= $tSeat->FTSetStaAlw ?>');" <?php //if ($oAuthen[0]->FTGadStaAlwW == '1'): ?>data-toggle="modal" data-target="#modal-set-seat"<?php //endif; ?>>
                                       <?php if ($tSeat->FTSetStaAlw == '1'): ?>
                                        <img title="<?= language('ticket/room/room', 'tOpening') ?>" src="<?php echo base_url('application/modules/common/assets/images/icons/icons8-Armchair-100.png'); ?>" style="width: 20px;">
                                    <?php elseif ($tSeat->FTSetStaAlw == '3'): ?>
                                        <img title="<?= language('ticket/room/room', 'tWasteRepair') ?>" src="<?php echo base_url('application/modules/common/assets/images/icons/icons8-Armchair-1001.png'); ?>" style="width: 20px;">
                                    <?php elseif ($tSeat->FTSetStaAlw == '4'): ?>
                                        <img title="<?= language('ticket/zone/zone', 'tDeactivate') ?>" src="<?php echo base_url('application/modules/common/assets/images/icons/icons8-Armchair-1001.png'); ?>" style="width: 20px;">
                                    <?php endif; ?>
                                    <br>
                                    <?= $tSeat->FTSetName ?>
                                </a>
                            </td>					
                        <?php endforeach ?>	
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>	
    </div>
    <hr style="margin-right: 15px; margin-left: 15px;">
    <div style="overflow: hidden; margin-bottom: 10px; margin-right: 15px; margin-left: 15px;">
        <div class="pull-right">
            <button type="button" onclick="javascript: var nLocID = $('#ohdGetLocID').val();
                        JSxCallPage('<?php echo base_url(); ?>EticketZoneNew/' + nLocID + '');" class="btn btn-default xCNBTNDefult"><?= language('ticket/user/user', 'tCancel') ?></button>
        </div>
    </div>
<?php else: ?>
    <div style="margin-left: 15px; margin-right: 15px;">
        <div style="padding: 100px; text-align: center; background-color: #f4f4f4;"><h5><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?= language('ticket/user/user', 'tDataNotFound') ?></h5></div>
    </div>
    <hr style="margin-right: 15px; margin-left: 15px;">
    <div style="overflow: hidden; margin-bottom: 10px;">
        <div class="pull-right" style="margin-left: 15px; margin-right: 15px;">
            <button type="button" onclick="javascript: var nLocID = $('#ohdGetLocID').val();
                        JSxCallPage('<?php echo base_url(); ?>EticketZoneNew/' + nLocID + '');" class="btn btn-default xCNBTNDefult"><?= language('ticket/user/user', 'tCancel') ?></button>
                    <?php if ($oAuthen['tAutStaAdd'] == '1'): ?>
                <button type="button" onclick="JSxZNECreateSeat();" class="btn btn-default xCNBTNPrimery"><?= language('ticket/zone/zone', 'tCreateSeat') ?></button>
            <?php endif; ?>	        
        </div>
    </div>
<?php endif; ?>
<!-- ตั้งค้าที่นั่ง -->
<div class="modal fade" id="modal-set-seat" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="z-index:2000; margin-top: 60px;">
        <div class="modal-content">
            <form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmEditSeat">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="myModalLabel"><?= language('ticket/zone/zone', 'tEditSeat') ?></h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="ohdFNSetID" id="ohdFNSetID" />
                    <input type="hidden" value="<?= $oSeat[0]->FNLocID ?>" />
                    <input type="hidden" value="<?= $oSeat[0]->FNLevID ?>" />
                    <input type="hidden" value="<?= $oSeat[0]->FNZneID ?>" />				
                    <label class="label-modify"><?= language('ticket/room/room', 'tStatus') ?></label>
                    <div class="form-group" style="height: 35px;">
                        <select class="form-control" name="ocmFTSetStaAlw" id="ocmFTSetStaAlw">
                            <option value="1"><?= language('ticket/room/room', 'tOpening') ?></option>
                            <option value="3"><?= language('ticket/room/room', 'tWasteRepair') ?></option>
                            <option value="4"><?= language('ticket/zone/zone', 'tDeactivate') ?></option>
                        </select>
                    </div>
                    <hr style="margin-right: 15px; margin-left: 15px;">
                    <div style="overflow: hidden;">
                        <div class="pull-right">
                            <button type="button" class="btn btn-default xCNBTNDefult" data-dismiss="modal"><?= language('ticket/user/user', 'tCancel') ?></button> &nbsp; <button type="submit" class="btn btn-default xCNBTNPrimery"><?= language('ticket/user/user', 'tSave') ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ตั้งค้าที่นั่ง -->
<div class="modal fade" id="modal-seat-row" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="z-index:2000; margin-top: 60px;">
        <div class="modal-content">
            <form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="oFmEditRowChr">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="myModalLabel"><?= language('ticket/zone/zone', 'tEditRow') ?></h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="<?= language('ticket/zone/zone', 'tRowName') ?> *" title="<?= language('ticket/zone/zone', 'tRowName') ?> *" name="oetFTSetRowChr" id="oetFTSetRowChr">
                    </div>
                    <div id="oDivRow"></div>
                    <hr style="margin-right: 15px; margin-left: 15px;">
                    <div style="overflow: hidden;">
                        <div class="pull-right">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?= language('ticket/user/user', 'tCancel') ?></button> &nbsp; <button type="submit" class="btn btn-outline-primary"><?= language('ticket/user/user', 'tSave') ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- เพิ่มเก้าอี้เสริม -->
<div class="modal fade" id="modal-add-seat" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="z-index:2000; margin-top: 60px;">
        <div class="modal-content">
            <form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="oFmAddNewSeat">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="myModalLabel"><?= language('ticket/zone/zone', 'tAddExtraChair') ?></h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="ohdFNLocID" value="<?= $oSeat[0]->FNLocID ?>" />
                    <input type="hidden" name="ohdFNLevID" value="<?= $oSeat[0]->FNLevID ?>" />
                    <input type="hidden" name="ohdFNZneID" value="<?= $oSeat[0]->FNZneID ?>" />
                    <div class="form-group">
                        <select class="form-control" name="ocmType" id="ocmType" title="<?= language('ticket/zone/zone', 'tCategory') ?>">
                            <option value="1"><?= language('ticket/zone/zone', 'tAddSeatRow') ?></option>
                            <option value="2"><?= language('ticket/zone/zone', 'tAddRowNew') ?></option>
                        </select>
                    </div>
                    <div class="form-group" id="oDivRowSeat">
                        <select class="form-control" name="ocmFNSetRowChr" id="ocmFNSetRowChr" title="<?= language('ticket/zone/zone', 'tRow') ?>">
                            <?php foreach ($oRow AS $tValue): ?>
                                <option value="<?= $tValue->FTSetRowChr ?>"><?= $tValue->FTSetRowChr ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>                    
                    <div class="form-group" id="oDivZneRow" style="display: none;">
                        <input type="number" min="0" class="form-control" placeholder="<?= language('ticket/zone/zone', 'tZoneRow') ?>" title="<?= language('ticket/zone/zone', 'tZoneRow') ?>" name="oetFNZneRow" id="oetFNZneRow">
                    </div>
                    <div class="form-group" id="oDivZneCol">
                        <input type="number" min="0" class="form-control" placeholder="<?= language('ticket/zone/zone', 'tSeatsAmount') ?>" title="<?= language('ticket/zone/zone', 'tSeatsAmount') ?>" name="oetFNZneCol" id="oetFNZneCol">
                    </div>
                    <div class="form-group" id="oDivZneColStart" style="display: none;">
                        <input type="number" min="0" class="form-control" placeholder="<?= language('ticket/zone/zone', 'tSeatingCountStartingFrom') ?>" title="<?= language('ticket/zone/zone', 'tSeatingCountStartingFrom') ?>" name="oetFNZneColStart" id="oetFNZneColStart">
                    </div>
                    <hr style="margin-right: 15px; margin-left: 15px;">
                    <div style="overflow: hidden;">
                        <div class="pull-right">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?= language('ticket/user/user', 'tCancel') ?></button> &nbsp; <button type="submit" class="btn btn-outline-primary"><?= language('ticket/user/user', 'tSave') ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>