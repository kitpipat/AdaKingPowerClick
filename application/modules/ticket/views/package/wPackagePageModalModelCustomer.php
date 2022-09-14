<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <label class="xCNTextModalHeard" id="myModalLabel"><span class="xWNameTitleMod"></span> / <?= language('ticket/package/package', 'tPkg_AllowVisit') ?></label>
    <input type="text" class="hidden" id="oetHidePmoID" value="<?= $nPmoID; ?>">
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_SelectLocation') ?></label>
                        <div>
                        <input type="text" class="hide" id="ohdPkgType" value="<?= $oPkgDetail[0]->FTPkgType ?>">
                        <input type="text" class="hide" id="ohdPkgEvnID" value="<?= $oPkgDetail[0]->FNEvnID ?>">
                        <select class="selectpicker form-control"  name="ocmPkgLocation" id="ocmPkgLocation">
                            <option value=""><?= language('ticket/package/package', 'tPkg_SelectLocation') ?></option>
                            <?php if (isset($oLocationList[0]->FNLocID)): ?>
                                <?php foreach ($oLocationList AS $aValue): ?>
                                    <option value="<?= $aValue->FNLocID ?>"><?= $aValue->FTLocName ?></option>
                                <?php endforeach; ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="nav-tab-pills-image">
            <div class="col-md-12">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item active" id="oliTabPkgZone">
                        <a class="nav-link flat-buttons active" id="olaTabPkgZone" data-toggle="tab" href="#odvTabZone" role="tab" aria-expanded="false">
                            <?= language('ticket/package/package', 'tPkg_Zone') ?>
                        </a>
                    </li>
                    <?php if ($oPkgDetail[0]->FNEvnID != ''): ?>
                        <li class="nav-item" id="oliTabPkgProduct">
                            <a class="nav-link flat-buttons" id="olaTabPkgShowTime" data-toggle="tab" href="#odvTabShowTime" role="tab" aria-expanded="false">
                                <?= language('ticket/package/package', 'tPkg_ShowTime') ?>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="odvTabZone" role="tabpanel" aria-expanded="true" style="overflow: hidden;margin-top:10px; padding-left: 0; padding-right: 0;" >
                        <div id="odvModalZonePanal"></div>
                </div>
                <div class="tab-pane" id="odvTabShowTime" role="tabpanel" aria-expanded="true" style="overflow: hidden;margin-top:10px; padding-left: 0; padding-right: 0;" >
                    <?php if (isset($oPkgDetail[0]->FNEvnID)): ?>
                        <div id="odvModalShowTimePanal"></div>
                    <?php endif ?>
                </div>
                </div>
            </div>			
            <div class="col-md-12 text-right">
                <button type="button" class="btn xCNBTNPrimery xWBtnAddPkgModel" onclick="JSxCheckAddPkgModalZone()"><?= language('ticket/user/user', 'tSave') ?></button>
            </div>	 
        </div>		
        <!-- Dialog Msg -->
        <div>
            <input type="text" class="hidden" id="ohdMsgDontHaveLocation" value="<?= language('ticket/package/package', 'tPkg_MsgDontHaveLocation') ?>">
            <input type="text" class="hidden" id="ohdMsgPlsSelectZone" value="<?= language('ticket/package/package', 'tPkg_MsgPlsSelectZone') ?>">
            <input type="text" class="hidden" id="ohdMsgPlsEnterPrice" value="<?= language('ticket/package/package', 'tPkg_MsgPlsEnterPrice') ?>">
            <input type="text" class="hidden" id="ohdMsgPlsSelZneSameTypePrevious" value="<?= language('ticket/package/package', 'tPkg_MsgPlsSelectZoneSameTypePrevious') ?>">		
        </div>               
    </div>
    <script>
        $('.selectpicker').selectpicker();
        //ลบ Validate เมื่อมีการกรอกราคา
        $("#oetEditPpkPrice").change(function () {
            $('#oetEditPpkPrice').removeClass('input-invalid');
        });
        //เมื่อเลือก Select box 
        $("#ocmPkgLocation").change(function () {
            nPkgID = $('#oetHidePkgID').val();
            nLocID = this.value;
            JSxCallPagePkgModalCstZone(nLocID, nPkgID);
            JSxCallPagePkgModalCstShowTime(nLocID, nPkgID);
        });
        $('#olaTabPkgZone').click(function () {
            $('.xWBtnAddPkgModel').attr('onclick', 'JSxCheckAddPkgModalZone()');
        });
        $('#olaTabPkgShowTime').click(function () {
            nLocID = $('#ocmPkgLocation').val();
            if (nLocID == '') {
                // 			alert('ว่าง');
                setTimeout(function () {
                    $('#olaTabPkgZone').click();
                    $('#oliTabPkgZone').click();
                }, 100);
            } else {

            }
        });
        //nHeight = $(window).height()-320;
        $('#odvModalZonePanal').css('min-height', '90px');
        $('#odvModalShowTimePanal').css('min-height', '90px');
    </script>