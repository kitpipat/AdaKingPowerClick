<script type="text/javascript">
    $(function () {
        $(".xWAddPkg").validate({
            rules: {
                ocmFNPkgID: "required"
            },
            messages: {
                ocmFNPkgID: ""
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
                $('button[type=submit]').attr('disabled', true);
                $('.xCNOverlay').show();
                $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>EticketShowTimeAddPackageAjax",
                data: $(".xWAddPkg").serialize(),
                cache: false,
                success: function (msg) {
                    JSxCallPage('<?php echo base_url() ?>EticketShowTimePackageList/<?= $nEvnID ?>/<?= $nLocID; ?>');
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
        });
    </script>
<div class="main-menu">
    <form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" class="xWAddPkg">  	
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="xCNBchVMaster">
                    <div class="col-xs-8 col-md-8">
                        <ol id="oliMenuNav" class="breadcrumb">
                            <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>/EticketEvent')"><?= language('ticket/event/event', 'tEventInformation') ?></li>
                            <li class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>/EticketShowTime/<?php echo $nEvnID; ?>')"><?= language('ticket/event/event', 'tManageEvents') ?></li>
                            <li class="xCNLinkClick" onclick="JSxCallPage('<?= base_url(); ?>EticketShowTimePackageList/<?= $nEvnID ?>/<?= $nLocID ?>');"><?= language('ticket/event/event', 'tPackageList') ?></li>
                            <li class="xCNLinkClick" ><?= language('ticket/event/event', 'tAddPackage') ?></li>
                        </ol>      
                            </div>
                        <div class="col-xs-12 col-md-4 text-right p-r-0">
                            <button type="button" onclick="JSxCallPage('<?= base_url(); ?>EticketShowTimePackageList/<?= $nEvnID ?>/<?= $nLocID ?>');" class="btn btn-default xCNBTNDefult"><?= language('common/main/main', 'tBack') ?></button>
                            <button type="submit" class="btn btn-default xCNBTNPrimery"><?= language('ticket/user/user', 'tSave') ?></button>
                        </div>
                    </div>
                </div>
            </div>
    <div class="main-content">
        <div class="panel panel-headline">
            <div class="panel-heading"> 
                <div class="row xWLocation" id="odvModelData" style="display: none;">
                    <?php
                        if(isset($oEvent->FTImgObj) && !empty($aValue->FTImgObj)){
                            $tFullPatch = './application/modules/common/assets/system/systemimage/'.$oEvent->FTImgObj;
                                if (file_exists($tFullPatch)){
                                    $tPatchImg = base_url().'/application/modules/common/assets/system/systemimage/'.$oEvent->FTImgObj;
                                }else{
                                    $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                }
                                }else{
                                    $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                }
                            ?>
                        <div class="col-md-3">		
                    <img class="" src="<?=$tPatchImg?>">
                        </div>
                            <div class="col-md-5">
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
                                <?= $oEvent[0]->FTEvnDesc1 ?><br>
                                <?= date("Y-m-d H:i", strtotime($oEvent[0]->FDEvnStart)) ?> - <?= date("Y-m-d H:i", strtotime($oEvent[0]->FDEvnFinish)) ?><br>           
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6 col-xs-6 col-sm-6">
                        <div class="xWNameSlider xWshow"><?= @$oEvent[0]->FTEvnName ?></div>
                    </div>
                    <div class="col-md-6 col-xs-6 col-sm-6 text-right" onclick="JSxMODHidden()">
                    <span id="ospSwitchPanelModel">
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </span>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-8">	
                        <label class="xCNLabelFrm">
                            <?= language('ticket/event/event', 'tAddPackage') ?>
                        </label>
                    </div>
                    <input type="hidden" name="ohdFNEvnID" value="<?= $nEvnID ?>" />
                    <input type="hidden" name="ohdFNLocID" value="<?= $nLocID ?>" />
                    <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <select class="selectpicker form-control" name="ocmFNPkgID[]" id="ocmFNPkgID" multiple="multiple" title="<?= language('ticket/event/event', 'tSelectPackage') ?>">
                        <option value=""><?= language('ticket/event/event', 'tSelectPackage') ?></option>
                        <?php foreach ($oPkgList as $key => $value): ?>
                        <option value="<?php echo $value->FNPkgID ?>"><?php echo $value->FTPkgName ?></option>
                        <?php endforeach; ?>
                        </select>
                        </div>		
                    </div>	
                </div>				
            </div>	
        </div>
    </form>	
</div>

<input type="hidden" value="<?php echo $nEvnID; ?>" id="ohdGetEventId">
<script>
    $('.selectpicker').selectpicker();
    function JSxMODHidden() {
        $('#odvModelData').slideToggle();
        setTimeout(function () {
            if ($('#odvModelData').css('display') == 'block') {

                $('#ospSwitchPanelModel').html('<i class="fa fa-chevron-up" aria-hidden="true"></i>');
            } else if ($('#odvModelData').css('display') == 'none') {

                $('#ospSwitchPanelModel').html('<i class="fa fa-chevron-down" aria-hidden="true"></i>');
            }
        }, 800);
        $('.xWNameSlider').toggleClass('xWshow');
    }
</script>