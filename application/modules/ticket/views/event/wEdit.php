<script type="text/javascript">

    $('.selectpicker').selectpicker();

    //Btn Datetime Click
    $('#obtFDEvnStartSale').click(function(){
		event.preventDefault();
        $('#oetFDEvnStartSale').datetimepicker('show');
    });

    $('#obtFDEvnStopSale').click(function(){
		event.preventDefault();
        $('#oetFDEvnStopSale').datetimepicker('show');
    });

    $('#obtFDEvnStart').click(function(){
		event.preventDefault();
        $('#oetFDEvnStart').datetimepicker('show');
    });

    $('#obtFDEvnFinish').click(function(){
		event.preventDefault();
        $('#oetFDEvnFinish').datetimepicker('show');
    });

    $('#obtFDEvnSuggBegin').click(function(){
		event.preventDefault();
        $('#oetFDEvnSuggBegin').datetimepicker('show');
    });

    $('#obtFDEvnSuggEnd').click(function(){
		event.preventDefault();
        $('#oetFDEvnSuggEnd').datetimepicker('show');
    });
    //Btn Datetime Click


    $(function () {
        $('#ocbFTEvnStaSuggest').on('click', function () {
            if ($(this).is(':checked')) {
                $('#oetFDEvnSuggBegin').attr("disabled", false);
                $('#oetFDEvnSuggEnd').attr("disabled", false);
                $('.xWe88588').show();
            } else {
                $('#oetFDEvnSuggBegin').attr("disabled", true);
                $('#oetFDEvnSuggEnd').attr("disabled", true);
                $('#oetFDEvnSuggBegin').val('');
                $('#oetFDEvnSuggEnd').val('');
                $('.xWe88588').hide();
            }
        });
        if ($('#ocbFTEvnStaSuggest').is(':checked')) {
            $('#oetFDEvnSuggBegin').attr("disabled", false);
            $('#oetFDEvnSuggEnd').attr("disabled", false);
            $('.xWe88588').show();
        } else {
            $('#oetFDEvnSuggBegin').attr("disabled", true);
            $('#oetFDEvnSuggEnd').attr("disabled", true);
            $('.xWe88588').hide();
        }
        $(".xWEditEvent").validate({
            rules: {
                oetFTEvnName: "required",
                oetFDEvnStart: "required",
                oetFDEvnStartSale: "required"
            },
            messages: {
                oetFTEvnName: "",
                oetFDEvnStart: "",
                oetFDEvnStartSale: "required"
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
                    url: "<?php echo base_url(); ?>EticketEditEventAjax",
                    data: $(".xWEditEvent").serialize(),
                    cache: false,
                    success: function (msg) {
                        var nDataId = $('.xWBtnSaveActive').data('id');
                        if (nDataId == '1') {
                            JSxCallPage('<?php echo base_url(); ?>EticketEditEvent/<?= $oShow[0]->FNEvnID ?>');
                                                    } else if (nDataId == '2') {
                                                        JSxCallPage('<?= base_url() ?>EticketAddEvent');
                                                    } else if (nDataId == '3') {
                                                        JSxCallPage('<?php echo base_url() ?>EticketEvent');
                                                    }
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
                                    $('#oetFDEvnSuggBegin').datetimepicker({
                                        format: 'DD-MM-YYYY HH:mm',
                                        locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
                                    });
                                    $('#oetFDEvnSuggEnd').datetimepicker({
                                        format: 'DD-MM-YYYY HH:mm',
                                        locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
                                    });
                                    $('#ocmFTEvnStaExpire').change(function () {
                                        if (!$(this).is(':checked')) {
                                            $("#oetFDEvnFinish").prop('disabled', true);
                                            $("#oetFDEvnFinish").val('');
                                        } else {
                                            $("#oetFDEvnFinish").prop('disabled', false);
                                            $("#oetFDEvnFinish").val('');
                                        }
                                    });
                                   
                                    $('[title]').tooltip();
                                    $('#oetFDEvnStartSale').datetimepicker({
                                        format: 'DD-MM-YYYY HH:mm',
                                        locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
                                    });
                                    $('#oetFDEvnStopSale').datetimepicker({
                                        format: 'DD-MM-YYYY HH:mm',
                                        locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
                                    });
                                    $('#oetFDEvnStart').datetimepicker({
                                        format: 'DD-MM-YYYY HH:mm',
                                        locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
                                    });
                                    $('#oetFDEvnFinish').datetimepicker({
                                        format: 'DD-MM-YYYY HH:mm',
                                        locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
                                    });
                                });
</script>
    <form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" class="xWEditEvent">

            <div id="odvBchMainMenu" class="main-menu">
                <div class="xCNMrgNavMenu">
                    <div class="row xCNavRow" style="width:inherit;">
                        <div class="xCNBchVMaster">
                            <div class="col-xs-8 col-md-8">
                                <ol id="oliMenuNav" class="breadcrumb">
                                    <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url('EticketEvent') ?>')"><?= language('ticket/event/event', 'tEventInformation') ?></li>
                                    <li class="xCNLinkClick"><?= language('ticket/event/event', 'tEditEvent') ?></li>
                                </ol>
                            </div>
                            <div class="col-xs-12 col-md-4 text-right p-r-0">
                                <button type="button" onclick="JSxCallPage('<?php echo base_url('EticketEvent') ?>')" class="btn btn-default xCNBTNDefult"><?= language('common/main/main', 'tBack') ?></button>	
                                <?php if ($oAuthen['tAutStaAppv'] == '1'): ?>
                                    <?php if ($oShow[0]->FTEvnStaPrcDoc == '1'): ?>
                                        <?php
                                        $tDisabled = ' disabled';
                                        ?> 
                                        <button type="button" class="btn btn-default xCNBTNPrimery"><?= language('ticket/event/event', 'tAccepted') ?></button>
                                        <input type="hidden" id="ohdnStaAppv" name="ohdnStaAppv" value="1">
                                    <?php else: ?>
                                        <button type="button" class="btn btn-default xCNBTNDefult" onclick="JSxEVTApv('<?php echo $oShow[0]->FNEvnID; ?>')"><?= language('ticket/event/event', 'tAccept') ?></button>
                                        <?php
                                        $tDisabled = '';
                                        ?>  
                                        <input type="hidden" id="ohdnStaAppv" name="ohdnStaAppv" value="0">
                                    <?php endif; ?>
                                <?php else: ?> 
                                <?php endif; ?> 
                                <div class="btn-group">                            
                                    <button class="btn btn-default xWBtnGrpSaveLeft" type="submit"><?= language('ticket/user/user', 'tSave') ?></button>
                                    <button type="button" class="btn btn-default xWBtnGrpSaveRight dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu xWDrpDwnMenuMargLft">
                                        <li class="xWolibtnsave1 xWBtnSaveActive" data-id="1" onclick="JSvChangeBtnSaveAction(1)"><a href="#"><?= language('common/main/main', 'tCMNSaveAndView') ?></a></li>
                                        <li class="xWolibtnsave2" data-id="2" onclick="JSvChangeBtnSaveAction(2)"><a href="#"><?= language('common/main/main', 'tCMNSaveAndNew') ?></a></li>
                                        <li class="xWolibtnsave3" data-id="3" onclick="JSvChangeBtnSaveAction(3)"><a href="#"><?= language('common/main/main', 'tCMNSaveAndBack') ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-content">
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">	
                                <div class="upload-img" id="oImgUpload">
                                    <?php if ($oShow[0]->FTImgObj != ''): ?>
                                        <a href="javascript:void(0)" id="oDelImgRoom" onclick="JSxEVTDelImg('<?php echo $oShow[0]->FNEvnID; ?>', '<?php echo $oShow[0]->FTImgObj; ?>', '<?= language('ticket/center/center', 'Confirm') ?>')" style="border: 0 !important; position: absolute; right: 5px; top: 5px;"><i class="fa fa-times" style="color: red; font-size: 18px;"></i></a>					
                                    <?php endif; ?>
                                    <?php
                                        if(isset($oShow[0]->FTImgObj) && !empty($oShow[0]->FTImgObj)){
                                            $tFullPatch = './application/modules/'.$oShow[0]->FTImgObj;
                                            if (file_exists($tFullPatch)){
                                                $tPatchImg = base_url().'/application/modules/'.$oShow[0]->FTImgObj;
                                            }else{
                                                $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                            }
                                        }else{
                                            $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                        }
                                    ?>
                                    <img src="<?= $tPatchImg; ?>" style="width: 100%;" id="oimImgMasterMain">
                                    <span class="btn-file"> 
                                        <input type="hidden" name="ohdEventImg[]" id="oetImgInputMain">
                                    </span>
                                </div>	
                                <div class="xCNUplodeImage">
                                    <button type="button" class="btn xCNBTNDefult"<?= $tDisabled ?> onclick="JSvImageCallTempNEW('', '', 'Main', '4/5')"><i class="fa fa-camera"></i> เลือกรูป</button>
                                </div>

                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="hidden" name="ohdFNEvnID" value="<?= $oShow[0]->FNEvnID ?>">
                                <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                                    <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tEventName') ?></label>
                                    <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetFTEvnName" name="oetFTEvnName" value="<?= $oShow[0]->FTEvnName ?>" data-validate="<?= language('ticket/event/event', 'tPleaseEnterEventName') ?>">
                                </div>

                                <div class="form-group">
                                    <span class="label-input100"><?= language('ticket/room/room', 'tSelectGroup') ?></span>
                                    <select class="selectpicker form-control" id="ocmFNTcgID" name="ocmFNTcgID" style="width: 100%"<?= $tDisabled ?>>
                                        <option value=""><?= language('ticket/room/room', 'tSelectGroup') ?></option>
                                        <?php foreach ($oTcg AS $oValue): ?>
                                            <?php if ($oValue->FNTcgID == $oShow[0]->FNTcgID): ?>
                                                <option selected="selected" value="<?= $oValue->FNTcgID ?>"><?= $oValue->FTTcgName ?> ( <?php
                                                    if ($oValue->FNPmoID == "") {
                                                        echo language('ticket/event/event', 'tGlobal');
                                                    } else {
                                                        echo $oValue->FTPmoName;
                                                    }
                                                    ?> )</option>							
                                            <?php else : ?>
                                                <option value="<?= $oValue->FNTcgID ?>"><?= $oValue->FTTcgName ?> ( <?php
                                                    if ($oValue->FNPmoID == "") {
                                                        echo language('ticket/event/event', 'tGlobal');
                                                    } else {
                                                        echo $oValue->FTPmoName;
                                                    }
                                                    ?> )</option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>			       
                                    </select>
                                </div>

                                <div class="form-group" style="width: 49%; float: left;">
                                    <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tStartDateOfSale') ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="oetFDEvnStartSale" name="oetFDEvnStartSale" value="<?= date("d-m-Y H:i", strtotime($oShow[0]->FDEvnStartSale)); ?>" data-validate="<?= language('ticket/event/event', 'tPleaseEnterDate') ?>">
                                        <span class="input-group-btn">
                                            <button id="obtFDEvnStartSale" type="button" class="btn xCNBtnDateTime">
                                                <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group" style="width: 49%; float: right;">
                                    <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tEndDateOfSale') ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="oetFDEvnStopSale" name="oetFDEvnStopSale" value="<?= ($oShow[0]->FDEvnStopSale == "" ? "" : date("d-m-Y H:i", strtotime($oShow[0]->FDEvnStopSale))) ?>">
                                        <span class="input-group-btn">
                                            <button id="obtFDEvnStopSale" type="button" class="btn xCNBtnDateTime">
                                                <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <div style="clear: both;"></div>

                                <div class="form-group" style="width: 49%; float: left;">
                                    <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tStartEventDate') ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="oetFDEvnStart" name="oetFDEvnStart" value="<?= date("d-m-Y H:i", strtotime($oShow[0]->FDEvnStart)); ?>" data-validate="<?= language('ticket/event/event', 'tPleaseEnterDate') ?>" <?= $tDisabled ?>>
                                        <span class="input-group-btn">
                                            <button id="obtFDEvnStart" type="button" class="btn xCNBtnDateTime">
                                                <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group" style="width: 49%; float: right;">
                                    <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tEventDateExpires') ?></label>
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="checkbox" value="1" id="ocmFTEvnStaExpire" name="ocmFTEvnStaExpire" <?php if ($oShow[0]->FTEvnStaExpire == "1"): ?>checked="checked"<?php endif ?><?= $tDisabled ?>>
                                    </span>
                                        <input type="text" class="form-control" <?php if ($oShow[0]->FTEvnStaExpire == "" || $oShow[0]->FTEvnStaExpire == "2"): ?>disabled<?php endif ?> value="<?= ($oShow[0]->FDEvnFinish == "" ? "" : date("d-m-Y H:i", strtotime($oShow[0]->FDEvnFinish))) ?>" id="oetFDEvnFinish" name="oetFDEvnFinish" id="oetFDEvnFinish" style="width: 90%;"<?= $tDisabled ?>>
                                        <span class="input-group-btn">
                                            <button id="obtFTEvnStaExpire" type="button" class="btn xCNBtnDateTime">
                                                <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <div style="clear: both;"></div>

                                <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                                    <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tDescription') ?></label>
                                    <input type="text" class="form-control" id="otaFTEvnDesc1" name="otaFTEvnDesc1" maxlength="100" value="<?= $oShow[0]->FTEvnDesc1 ?>" <?= $tDisabled ?>>
                                </div>

                                <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                                    <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tDescription') ?>(2)</label>
                                    <input type="text" class="form-control" id="otaFTEvnDesc2" name="otaFTEvnDesc2" maxlength="100" value="<?= $oShow[0]->FTEvnDesc2 ?>" <?= $tDisabled ?>>
                                </div>

                                <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                                    <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tDescription') ?>(3)</label>
                                    <input type="text" class="form-control" id="otaFTEvnDesc3" name="otaFTEvnDesc3" maxlength="100" value="<?= $oShow[0]->FTEvnDesc3 ?>" <?= $tDisabled ?>>
                                </div>

                                <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                                    <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tDescription') ?>(4)</label>
                                    <input type="text" class="form-control" id="otaFTEvnDesc4" name="otaFTEvnDesc4" maxlength="100" value="<?= $oShow[0]->FTEvnDesc4 ?>" <?= $tDisabled ?>>
                                </div>

                                <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                                    <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tDescription') ?>(5)</label>
                                    <input type="text" class="form-control" id="otaFTEvnDesc5" name="otaFTEvnDesc5" maxlength="100" value="<?= $oShow[0]->FTEvnDesc5 ?>" <?= $tDisabled ?>>
                                </div>


                                <div class="form-group">
                                    <label style="font-weight: normal; margin-bottom: 0;"><input value="1" name="ocbFTEvnStaUse" type="checkbox" <?php
                                        if ($oShow[0]->FTEvnStaUse == '1') {
                                            echo ' checked="checked"';
                                        }
                                        ?> style="float: left; margin-right: 5px;"> <?= language('ticket/room/room', 'tOpening') ?></label>
                                </div>

                                <div class="form-group">
                                    <label style="font-weight: normal; margin-bottom: 0;"><input value="1" <?php
                                        if ($oShow[0]->FTEvnStaSuggest == '1') {
                                            echo ' checked="checked"';
                                        }
                                        ?> name="ocbFTEvnStaSuggest" id="ocbFTEvnStaSuggest" type="checkbox" style="float: left; margin-right: 5px;"> <?= language('ticket/event/event', 'tRecommendEvents') ?></label>
                                </div>

                                <div class="form-group" style="width: 49%; float: left;">
                                    <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tSuggestedDateRangeFrom') ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="oetFDEvnSuggBegin" name="oetFDEvnSuggBegin" disabled="disabled" value="<?= ($oShow[0]->FDEvnSuggBegin == "" ? "" : date("d-m-Y H:i", strtotime($oShow[0]->FDEvnSuggBegin))) ?>">
                                        <span class="input-group-btn">
                                            <button id="obtFDEvnSuggBegin" type="button" class="btn xCNBtnDateTime">
                                                <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group" style="width: 49%; float: right;">
                                    <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tSuggestedDateRangeTo') ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="oetFDEvnSuggEnd" name="oetFDEvnSuggEnd" disabled="disabled" value="<?= ($oShow[0]->FDEvnSuggEnd == "" ? "" : date("d-m-Y H:i", strtotime($oShow[0]->FDEvnSuggEnd))) ?>">
                                        <span class="input-group-btn">
                                            <button id="obtFDEvnSuggEnd" type="button" class="btn xCNBtnDateTime">
                                                <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <div style="clear: both;"></div>
                                <div class="form-group" style="width: 49%;">
                                    <div class="xWe88588" style="display: none;">
                                        <div class="row" style="margin-left: -15px; margin-right: -15px;">
                                            <div class="col-md-6">
                                                <?php if (@$oImgBanner[0]->FTImgObj != ''): ?>
                                                    <a href="javascript:void(0)" id="oDelImg<?= $oImgBanner[0]->FNImgID; ?>" onclick="JSxEVTDelImgSub('<?= $oImgBanner[0]->FNImgID; ?>', '<?= $oImgBanner[0]->FTImgObj; ?>');" style="border: 0 !important; position: absolute; right: 22px; top: 0px;"><i class="fa fa-times" style="color: red; font-size: 18px;"></i></a>
                                                <?php endif; ?>

                                                <?php
                                                    if(isset($oImgBanner[0]->FTImgObj) && !empty($oImgBanner[0]->FTImgObj)){
                                                        $tFullPatch = './application/modules/common/assets/system/systemimage/'.$oImgBanner[0]->FTImgObj;
                                                        if (file_exists($tFullPatch)){
                                                            $tPatchImg = base_url().'/application/modules/common/assets/system/systemimage/'.$oImgBanner[0]->FTImgObj;
                                                            $xWImg = "xWImg".$oImgBanner[0]->FNImgID;
                                                        }else{
                                                            $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                                            $xWImg = "";
                                                        }
                                                    }else{
                                                        $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                                        $xWImg = "";
                                                    }
                                                ?>
                                                <img src="<?= $tPatchImg; ?>" id="oimImgMasterRecommend1" class="<?= $xWImg; ?>" style="width: 100%; border: 1px solid #eceeef;">

                                                <input type="hidden" name="ohdEventImg[]" id="oetImgInputRecommend1">
                                                <button type="button" style="width: 100%; margin-top: 10px;" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('', '', 'Recommend1', '16/5')"><i class="fa fa-camera"></i> Images Banner</button>
                                            </div>	
                                            <div class="col-md-6">

                                                <?php if (@$oImgSub[0]->FTImgObj != ''): ?>
                                                    <a href="javascript:void(0)" id="oDelImg<?= $oImgSub[0]->FNImgID; ?>" onclick="JSxEVTDelImgSub('<?= $oImgSub[0]->FNImgID; ?>', '<?= $oImgSub[0]->FTImgObj; ?>');" style="border: 0 !important; position: absolute; right: 22px; top: 0px;"><i class="fa fa-times" style="color: red; font-size: 18px;"></i></a>
                                                <?php endif; ?>

                                                <?php
                                                    if(isset($oImgSub[0]->FTImgObj) && !empty($oImgSub[0]->FTImgObj)){
                                                        $tFullPatch = './application/modules/common/assets/system/systemimage/'.$oImgSub[0]->FTImgObj;
                                                        if (file_exists($tFullPatch)){
                                                            $tPatchImg = base_url().'/application/modules/common/assets/system/systemimage/'.$oImgSub[0]->FTImgObj;
                                                            $xWImg = "xWImg".$oImgSub[0]->FNImgID;
                                                        }else{
                                                            $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                                            $xWImg = "";
                                                        }
                                                    }else{
                                                        $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                                        $xWImg = "";
                                                    }
                                                ?>
                                                <img src="<?= $tPatchImg; ?>" id="oimImgMasterRecommend2" class="<?= $xWImg; ?>" style="width: 100%; border: 1px solid #eceeef;">

                                                <input type="hidden" name="ohdEventImg[]" id="oetImgInputRecommend2">
                                                <button type="button" style="width: 100%; margin-top: 10px;" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('', '', 'Recommend2', '4/3')"><i class="fa fa-camera"></i> Images Right</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="clear: both;"></div>

                                 <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('ticket/zone/zone', 'tRemarks') ?></label>
                                    <textarea class="form-control" name="otaFTEvnRemark" <?= $tDisabled ?>><?= $oShow[0]->FTEvnRemark ?></textarea>
                                </div>
                                            
                            </div>
                        </div>	
                    </div>	
                </div>	
            </div>
    </form>