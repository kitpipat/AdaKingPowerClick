<div>
    <!--hidden page -->
    <input type="hidden" id="ohdPageCurrent" name="ohdPageCurrent" value="<?=$nPage?>">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center xCNTextBold" style="width:10%;"><?php echo  language('time/timeStamp/timeStamp','tMsgTimeStampDetailBranch')?></th>
                        <th class="text-center xCNTextBold"><?php echo  language('time/timeStamp/timeStamp','tMsgTimeStampDetailCode')?></th>
                        <th class="text-center xCNTextBold"><?php echo  language('time/timeStamp/timeStamp','tMsgTimeStampDetailUsername')?></th>
                        <th class="text-center xCNTextBold"><?php echo  language('time/timeStamp/timeStamp','tMsgTimeStampDetailCheckin')?></th>
                        <th class="text-center xCNTextBold"><?php echo  language('time/timeStamp/timeStamp','tMsgTimeStampDetailTimein')?></th>
                        <th class="text-center xCNTextBold"><?php echo  language('time/timeStamp/timeStamp','tMsgTimeStampDetailCheckout')?></th>
                        <th class="text-center xCNTextBold"><?php echo  language('time/timeStamp/timeStamp','tMsgTimeStampDetailTimeout')?></th>
                        <th class="text-center xCNTextBold"><?php echo  language('time/timeStamp/timeStamp','tMsgTimeStampDetailReason')?></th>
                        <th class="text-center xCNTextBold"><?php echo  language('time/timeStamp/timeStamp','tMsgTimeStampDetailEdit')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aResult['rtCode'] == '1'):?>
                        <?php foreach($aResult['raItems'] AS $nKey => $aValue):?>
                            <tr class="text-center xCNTextDetail2 xWTimeStampDataSource" id="otrTimeStampLocal<?=$aValue['FNWrtID'];?>" data-seq="<?=$aValue['FNWrtID'];?>">
                                <td class="text-left"><?php echo $aValue['FTBchName']?></td>
                                <td><?php echo $aValue['FTUsrCode']?></td>
                                <td class="text-left"><?php echo $aValue['FTUsrName']?></td>
                                <td><?php echo $aValue['FDWrtDate']?></td>
                                <td class="xWTimeStampClockIN">
                                    <?php $tDateIN = explode(" ",$aValue['FDWrtDate']); ?>
                                    <input id="oetTimeIN<?=$aValue['FNWrtID']; ?>" name="oetTimeIN<?=$aValue['FNWrtID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTWrtClockIn']; ?>">
                                    <input id="oetDateIN<?=$aValue['FNWrtID']; ?>" type="hidden" value="<?=$tDateIN[0];?>">
                                </td>
                                <td><?php echo $aValue['FDWrtDateOut']?></td>
                                <td class="xWTimeStampClockOut">
                                    <?php $tDateOut = explode(" ",$aValue['FDWrtDateOut']); ?> 
                                    <input id="oetTimeOut<?=$aValue['FNWrtID']; ?>" name="oetTimeOut<?=$aValue['FNWrtID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTWrtClockOut']; ?>">
                                    <input id="oetDateOut<?=$aValue['FNWrtID']; ?>" type="hidden" value="<?=$tDateOut[0];?>">
                                </td>
                                <td><?php echo $aValue['FTWrtRemark']?></td>
                                <td>
                                    <img class="xCNIconTable xWTimeStampEdit" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageTimeStampEdit(this, event,'<?php echo $aValue['FNWrtID']?>')">
                                    <img class="xCNIconTable xWTimeStampSave hidden" src="<?php echo  base_url(); ?>/application/modules/common/assets/images/icons/save.png" onclick="JSxTimeStampDataSourceSaveOperator(this, event)">
                                    <img class="xCNIconTable xWTimeStampCancel hidden" src="<?php echo  base_url(); ?>/application/modules/common/assets/images/icons/reply_new.png" onclick="JSxPageTimeStampDataSourceCancelOperator(this, event)">
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='99'><?= language('time/timeStamp/timeStamp','tMsgTimeStampNofoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p>พบข้อมูลทั้งหมด <?php echo $aResult['rnAllRow']?> รายการ แสดงหน้า <?php echo $aResult['rnCurrentPage']?> / <?php echo $aResult['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageTimeStamp btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvTimeStampClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aResult['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvTimeStampClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aResult['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvTimeStampClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jTimeStampDetailTable.php"; ?>