<div class="row">
    <div class="col-xs-4 col-md-4 col-lg-4">
        <div class="form-group">
            <label class="xCNLabelFrm"><?= language('common/main/main', 'tSearch') ?></label>
            <div class="input-group">
                <input 
                type="text" 
                class="form-control xCNInputWithoutSingleQuote" 
                id="oetPOSImpSearchAll" 
                name="oetPOSImpSearchAll"
                onblur="JSxPosImportSearchDataInTable()" 
                onkeyup="Javascript:if(event.keyCode==13) JSxPosImportSearchDataInTable()" 
                value="<?= $tSearch ?>" 
                placeholder="<?php echo language('common/main/main', 'tPlaceholder'); ?>">
                <span class="input-group-btn">
                    <button class="btn xCNBtnSearch" type="button" onclick="JSxPosImportSearchDataInTable()">
                        <img class="xCNIconAddOn" src="<?php echo base_url('/application/modules/common/assets/images/icons/search-24.png'); ?>">
                    </button>
                </span>
            </div>
        </div>
    </div>

    <div class="col-xs-5 col-md-3 col-lg-3">
        <div style="margin-bottom: 5px;">
            <label class="xCNLabelFrm">กรณีมีข้อมูลนี้อยู่แล้วในระบบ</label>
        </div>
        <div class="form-check form-check-inline" style="display: inline; margin-right: 20px;">
            <input class="form-check-input" type="radio" name="orbPOSCaseInsAgain" id="orbPOSCaseNew" value="1">
            <label class="form-check-label" for="orbPOSCaseNew">ใช้รายการใหม่</label>
        </div>
        <div class="form-check form-check-inline" style="display: inline; margin-right: 20px;">
            <input class="form-check-input" type="radio" name="orbPOSCaseInsAgain" id="orbPOSCaseUpdate" value="2" checked>
            <label class="form-check-label" for="orbPOSCaseUpdate">อัพเดทรายการเดิม</label>
        </div>
    </div>

    <div class="col-xs-3 col-md-3 col-lg-3 text-right" style="margin-top:25px;">
        <!-- <label>สถานะ: รอยืนยันการนำเข้า</label> <label class="xCNImportStaSucess text-success">0</label> / <label class="xCNImportStaTotal">0</label> -->
    </div>

    <div class="col-xs-2 col-md-2 col-lg-2 text-right" style="margin-top:25px;">
        <div class=""></div>
        <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
            <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                <?= language('common/main/main', 'tCMNOption') ?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li id="oliBtnDeleteAll" class="disabled" onclick="JSxPosImportConfirmDeleteInTempBySeqInTemp(this, 'M')">
                    <a><?= language('common/main/main', 'tDelAll') ?></a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped xCNPosImportTabble" id="otbPosImportTable">
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo  language('common/main/main', 'tCMNChoose'); ?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo  language('common/main/main', 'ลำดับ'); ?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('pos/salemachine/salemachine', 'tBchCode'); ?></th>
                        <!-- <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo language('pos/salemachine/salemachine', 'tBchName'); ?></th> -->
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('pos/salemachine/salemachine', 'tPOSCode'); ?></th>
                        <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo language('pos/salemachine/salemachine', 'tPOSName'); ?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('pos/salemachine/salemachine', 'tPOSType'); ?></th>
                        <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo language('pos/salemachine/salemachine', 'tRegisterID'); ?></th>
                        <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo  language('common/main/main', 'tRemark'); ?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo  language('common/main/main', 'tCMNActionDelete'); ?></th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDeleteImportPos">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ohdConfirmIDDelete">
                <input type='hidden' id='ohdConfirmCodeDelete'>
            </div>
            <div class="modal-footer">
                <button id="obtPOSImpConfirm" type="button" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                <button id="obtPOSImpCancel" class="btn xCNBTNDefult" type="button"><?php echo language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>

<?php include('script/jSaleMachineImportDataTable.php'); ?>