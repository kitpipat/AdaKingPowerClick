<script>
    $(function () {
        $(".xWEditLocation").validate({
            rules: {
                oetFTLocNameEdit: "required",
                oetFNLocEditLimit: "required"
            },
            messages: {
                oetFTLocNameEdit: "",
                oetFNLocEditLimit: ""
            },
            errorClass: "input-invalid",
            validClass: "input-valid",
            highlight: function (element, errorClass, validClass) {
                $(element).addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass(errorClass).addClass(validClass);
            },
            submitHandler: function (form) {
                $('button[type=submit]').attr('disabled', true);
                $('.xCNOverlay').show();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>EticketEditLocAjax",
                    data: $(".xWEditLocation").serialize(),
                    cache: false,
                    success: function (msg) {
                        var oetFTLocNameEdit = $('#oetFTLocNameEdit').val();
                        JSxCallPage('<?php echo base_url() ?>EticketLocation/<?= $aLocModel[0]->FNPmoID ?>/' + decodeURI(oetFTLocNameEdit) + '');
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

        $('#ocmFNPvnID').on('change', function () {
            $tID = this.value;
            JSxPRKDistrict($tID);
        });
        $('#oetFTLocTimeEditOpening').timepicker({
            showMeridian: false,
            showInputs: false
        });
        $('#oetFTLocTimeEditClosing').timepicker({
            showMeridian: false,
            showInputs: false
        });
        $('[title]').tooltip();
    });
</script>
<div class="row">
    <div class="xCNBCMenu xWHeaderMenu">
        <div class="row">
            <div class="col-md-8">
                <span onclick="JSxCallPage('<?php echo base_url('EticketBranch') ?>')">ข้อมูลสาขา</span> / <span onclick="JSxCallPage('<?php echo base_url() ?>EticketLocation/<?= $aLocModel[0]->FNPmoID ?>/<?= $aLocModel[0]->FTPmoName ?>')"><?= $aLocModel[0]->FTPmoName ?></span> / แก้ไขสถานที่
            </div>
        </div>
    </div>
    <form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" class="xWEditLocation">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">		
                <div class="upload-img" id="oImgUpload" style="margin-bottom: 10px;">
                    <?php if ($oEdit[0]->FTImgObj != ""): ?>
                        <a href="javascript:void(0)" id="oDelImgLoc" onclick="JSxLOCDelImg('<?php echo $oEdit[0]->FNImgID; ?>')" style="border: 0 !important; position: absolute; right: 5px; top: 5px;"><i class="fa fa-times" style="color: red; font-size: 18px;"></i></a>
                        <img src="<?= base_url() ?><?php echo $oEdit[0]->FTImgObj; ?>" style="width: 100%;" id="oImageThumbnail" class="xWimageLoc">
                    <?php else : ?>
                        <img src="<?php echo base_url('application/modules/common/assets/images/Noimage.png'); ?>" style="width: 100%;" id="oImageThumbnail">
                    <?php endif; ?>						
                    <span class="btn-file"> 
                        <img src="<?php echo base_url('application/modules/common/assets/images/icons/icons8-Camera.png'); ?>" style="width: 24px;">				
                        <input type="file" accept="image/*" id="ofilePhotoAdd" onchange="FCNCropper(this, 5 / 3);"> 
                        <input type="hidden" name="ohdLocImgEdit" id="ohdPhotoAdd">
                    </span>
                    <div class="text-center" style="margin-top: -30px;">
                        <span><?= language('ticket/park/park', 'tPrk_Picture') ?></span>
                    </div>
                </div>				
            </div>
            <div class="col-md-8 col-sm-4 col-xs-12">
                <input type="hidden" name="ohdEditLocID" id="ohdEditLocID" value="<?= $oEdit[0]->FNLocID ?>">				
                <input type="hidden" name="ohdFNPmoID" id="ohdFNPmoID" value="<?= $aLocModel[0]->FNPmoID ?>">				
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="ชื่อสถานที่" value="<?= $oEdit[0]->FTLocName ?>" name="oetFTLocNameEdit" id="oetFTLocNameEdit" />
                </div>
                <div class="form-group">
                    <input type="number" min="0" class="form-control" placeholder="จำนวนรองรับ" value="<?= $oEdit[0]->FNLocLimit ?>" name="oetFNLocEditLimit" id="oetFNLocEditLimit" />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" value="<?= $oEdit[0]->FTLocTimeOpening ?>" placeholder="เวลาเปิดทำการ" name="oetFTLocTimeEditOpening" id="oetFTLocTimeEditOpening" />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" value="<?= $oEdit[0]->FTLocTimeClosing ?>" placeholder="เวลาปิดทำการ" name="oetFTLocTimeEditClosing" id="oetFTLocTimeEditClosing" />
                </div>
                <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <select class="form-control" name="ocmFNAreID" id="ocmFNAreID">
                            <?php foreach ($aArea AS $value): ?>
                                <option value="<?= $value->FNAreID ?>"><?= $value->FTAreName ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <select class="form-control" name="ocmFNPvnID" id="ocmFNPvnID">
                            <?php foreach ($aProvince AS $value): ?>
                                <option value="<?= $value->FNPvnID ?>"><?= $value->FTPvnName ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-4 col-xs-6">
                        <select class="form-control" name="ocmFNDstID" id="ocmFNDstID">
                            <?php foreach ($aDistrict AS $value): ?>
                                <option value="<?= $value->FNDstID ?>"><?= $value->FTDstName ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-2 col-xs-6">
                        <button type="button" class="btn btn-outline-primary pull-right" onclick="JSxPRKAddAre();" data-toggle="modal" data-target="#modal-area">
                            <span>+ เพิ่ม</span>
                        </button>
                    </div>
                </div>
                <table class="table table-hover" id="otbAre" style="margin-top: 15px;">
                    <thead>
                        <tr>
                            <th>ภาค</th>
                            <th>จังหวัด</th>
                            <th>อำเภอ</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (@$oAreas[0]->FNLpvID == ""): ?>
                            <tr id="otr">
                                <th colspan="4"><div style="text-align: center; padding: 20px;">ไม่พบข้อมูล</div></th>
                            </tr>						
                        <?php else: ?>
                            <?php foreach (@$oAreas AS $aValue): ?>
                                <tr id="otr<?= $aValue->FNLpvID ?>">
                                    <td><?= $aValue->FTAreName ?></td>
                                    <td><?= $aValue->FTPvnName ?></td>
                                    <td><?= $aValue->FTDstName ?></td>
                                    <td style="text-align: center;"><a href="javascript:void(0)" onclick="JSxLOCDelAre('<?= $aValue->FNLpvID ?>');"><i class="fa fa-trash-o fa-lg"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <div class="pull-right">
            <button type="button" onclick="JSxCallPage('<?php echo base_url() ?>EticketLocation/<?= $aLocModel[0]->FNPmoID ?>/<?= $aLocModel[0]->FTPmoName ?>');" class="btn btn btn-default"><?= language('common/main/main', 'tBack') ?></button>
            <button type="submit" class="btn btn-outline-primary"><?= language('ticket/user/user', 'tSave') ?></button>			
        </div>
    </form>
    <input type="hidden" id="ohdGetParkId" value="<?= $nPrk ?>">
</div>

<script type="text/javascript" src="<?php echo base_url('application/modules/ticket/assets/src/branch/jPark.js');?>"></script>