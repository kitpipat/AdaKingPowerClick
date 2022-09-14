<?php 
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>
<style>
    .xWRackChannelItems:hover {
        cursor: pointer;
    }
    .xWRackChannelItems.xCNActive {
        background-color: #179bfd !important;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <th class="xCNTextBold"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaChannelNo')?></th>
                        <th class="xCNTextBold"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaRow')?></th>
                        <th class="xCNTextBold"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaCol')?></th>
                        <th class="xCNTextBold"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaAdjSta')?></th>
                    </tr>
                </thead>
                <tbody>
                <?php if($aDataList['rtCode'] == 1 ) { ?>
                    <?php foreach($aDataList['raItems'] AS $key => $aItem) { ?>
                        <tr 
                            class="text-center xCNTextDetail2 xWRackChannelItems"
                            data-rack-bchcode="<?=$aItem['FTBchCode']?>"
                            data-rack-mercode="<?=$aItem['FTMerCode']?>"
                            data-rack-shpcode="<?=$aItem['FTShpCode']?>"
                            data-rack-layno="<?=$aItem['FNLayNo']?>"
                            data-rack-layrow="<?=$aItem['FNLayRow']?>"
                            data-rack-laycol="<?=$aItem['FNLayCol']?>"
                            data-rack-laystause="<?=$aItem['FTLayStaUse']?>"
                            onclick="JSxSMLKAdjStaSelectRackChannel(this)">
                            
                            <td class="text-center"><?=$aItem['FNLayNo']?></td>
                            <td class="text-center"><?=$aItem['FNLayRow']?></td>
                            <td class="text-center"><?=$aItem['FNLayCol']?></td>
                            <?php 
                            $tLayStaUse = '';
                            if($aItem['FTLayStaUse'] == '1'){$tLayStaUse = language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaEmpty');}
                            if($aItem['FTLayStaUse'] == '2'){$tLayStaUse = language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaUse');}
                            if($aItem['FTLayStaUse'] == '3'){$tLayStaUse = language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaDisable');}
                            ?>
                            <td class="text-center"><?=$tLayStaUse?></td>   
                            
                        </tr>
                    <?php } ?>
                <?php }else {?>
                    <tr><td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if(false) { ?>
<div class="row">
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPage btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvSMLKAdjStaRackChannelDataTableClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'], $nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ --> 
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <button onclick="JSvSMLKAdjStaRackChannelDataTableClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvSMLKAdjStaRackChannelDataTableClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<?php } ?>
