<!-- H I S T O R Y -->



<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="otbStyDataList" class="table table-striped"> <!-- เปลี่ยน -->
                <thead>
                    <tr>
                        <th class="text-center xCNTextBold" style="width:20%;"><?= language('time/timeStamp/timeStamp','tMsgTimeStampTableTime')?></th>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('time/timeStamp/timeStamp','tMsgTimeStampTableCode')?></th>
                        <th class="text-center xCNTextBold" style="width:20%;"><?= language('time/timeStamp/timeStamp','tMsgTimeStampTableName')?></th>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('time/timeStamp/timeStamp','tMsgTimeStampTableType')?></th>
                        <!-- <th class="text-center xCNTextBold" style="width:10%;"></th> -->
                    </tr>
                </thead>
                <tbody>

                    <?php if($aResultHistory['rtCode'] == 1 ):?>
                        <?php foreach($aResultHistory['raItems'] AS $nKey => $aValue):?>

                            <?php 

                            if($aValue['FTWrtType'] == 'OUT'){
                                //checkout
                                $tTypeCheckInorCheckout = 2;
                                $tTextCheckinorCheckout = language('time/timeStamp/timeStamp','tMsgTimeStampCheckout');
                                $tTimeandDate           = $aValue['FDWrtDateOut'];
                                $tStyleCheckin          = 'width:15px; height:15px; background:#f7f12b; margin: 5px auto; border-radius: 50%;';
                            }else{
                                //checkin
                                $tTypeCheckInorCheckout = 1;
                                $tTextCheckinorCheckout = language('time/timeStamp/timeStamp','tMsgTimeStampCheckin');
                                $tTimeandDate           = $aValue['FDWrtDate'];
                                $tStyleCheckin          = 'width:15px; height:15px; background:#1aa532; margin: 5px auto; border-radius: 50%;';
                            }
                            ?>

                            <tr class="text-center xCNTextDetail2">
                                <td><?=$tTimeandDate?></td>
                                <td><?=$aValue['FTUsrCode']?></td>
                                <td><?=$aValue['FTUsrName']?></td>
                                <td><?=$tTextCheckinorCheckout?></td>
                                <!-- <td><div style="<?=$tStyleCheckin?>"></div></td> -->
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='5'><?= language('time/timeStamp/timeStamp','tMsgTimeStampNofoundData')?></td></tr>
                    <?php endif;?>

                </tbody>
            </table>
        </div>
    </div>
</div>



