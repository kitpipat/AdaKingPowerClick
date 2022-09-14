<div class="modal fade" id="odvSMLKAdjStaAddRackChannelPanel" style="max-width: 1700px; margin: 1.75rem auto; width: 85%;">
    <div class="modal-dialog" style="width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaSelectChannel')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Rack Channel Table -->
                <div class="row">
                    <div class="col-md-12"><div id="odvSMLKAdjStaRackChannelTable"></div></div>
                </div>
                <!-- Rack Channel Table -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaCancel')?>
                </button>
                <button onclick="JSvSMLKAdjStaAddRackChannelToTemp()" type="button" class="btn xCNBTNPrimery">
                    <?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaOk')?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php include('script/jAdjustStatusRackChannelModal.php'); ?>
