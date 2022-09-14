<?php 
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <th class="xCNTextBold"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaBch')?></th>
                        <th class="xCNTextBold"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaShop')?></th>
                        <th class="xCNTextBold"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaChannelGroup')?></th>
                        <th class="xCNTextBold"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaAdjDate')?></th>
                        <th class="xCNTextBold"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaDetailView')?></th>
                    </tr>
                </thead>
                <tbody>
                <?php if($aDataList['rtCode'] == 1 ) { ?>
                    <?php foreach($aDataList['raItems'] AS $key => $aItem) { ?>
                        <tr class="text-center xCNTextDetail2 xWSMLKAdminHisItems"
                            data-his-bchcode="<?=$aItem['FTBchCode']?>"
                            data-his-bchname="<?=$aItem['FTBchName']?>"
                            data-his-shpcode="<?=$aItem['FTShpCode']?>"
                            data-his-poscode="<?=$aItem['FTPosCode']?>"
                            data-his-rackcode="<?=$aItem['FTRakCode']?>"
                            data-his-rackname="<?=$aItem['FTRakName']?>"
                            data-his-stause="<?=$aItem['FTLayStaUse']?>"
                            data-his-usrcode="<?=$aItem['FTHisUsrCode']?>"
                            data-his-usrname="<?=$aItem['FTHisUsrName']?>"
                            data-his-date="<?=$aItem['FDHisDateTime']?>">
                            
                            <td class="text-left"><?=$aItem['FTBchName']?></td>
                            <td class="text-left"><?=$aItem['FTShpName']?></td>
                            <td class="text-left"><?=$aItem['FTRakName']?></td>
                            <td class="text-left"><?=date_format(date_create($aItem['FDHisDateTime']), 'Y-m-d H:i:s')?></td>
                            <td class="text-left"><label class="xCNTextLink" onclick="JSxSMLKAdjStaCallViewPage(this)"><i class="fa fa-eye"></i> <?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaDetailView')?></label></td>                          
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

<?php if($aDataList['rnAllPage'] > 1) { ?>
<div class="row">
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPage btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvSMLKAdjStaDataTableClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvSMLKAdjStaDataTableClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvSMLKAdjStaDataTableClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<?php } ?>
