<style>
    .xWDLKBoxBorder{
        border: 1px solid #ccc;
    }
</style>
<?php if(isset($aDataLockerStautus['rtCode']) && $aDataLockerStautus['rtCode'] == 1):?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="panel-body">
                <div class="row">
                    <?php foreach($aDataLockerStautus['raItems'] AS $nKey => $aValueData):?>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div id="odvDLKPosListBox" class="xWDLKBoxBorder">
                                
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>


<?php endif;?>