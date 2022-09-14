<input type="hidden" id="ohdDocType" value="<?=$nDocType?>">
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th nowrap class="text-center" width="5%"><?= language('monitor/monitor/monitor','tSDTSeq')?></th>
                    <th nowrap class="text-center" width="10%"><?= language('monitor/monitor/monitor','tSDTBch')?></th>
                    <th nowrap class="text-center" width="10%"><?= language('monitor/monitor/monitor','tSDTDocDate')?></th>
                    <th nowrap class="text-center" width="10%"><?= language('monitor/monitor/monitor','tSDTDocNo')?></th>
                    <th nowrap class="text-center" width="5%"><?= language('monitor/monitor/monitor','tSDTStaDoc')?></th>
                    <th class="text-center " width="10%"><?= language('monitor/monitor/monitor','tSDTBchFrm')?></th>
                    <th class="text-center " width="10%"><?= language('monitor/monitor/monitor','tSDTBchTo')?></th>
                    <th nowrap class="text-center " width="10%"><?= language('monitor/monitor/monitor','tSDTTRDocNo')?></th>
                    <th nowrap class="text-center " width="10%"><?= language('monitor/monitor/monitor','tSDTTBODocNo')?></th>
                    <th nowrap class="text-center " width="10%"><?= language('monitor/monitor/monitor','tSDTTPDocNo')?></th>
                    <th nowrap class="text-center " width="10%"><?= language('monitor/monitor/monitor','tSDTTBIDocNo')?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($aSDTDataList['aItems'])) { ?>
                    <?php foreach ($aSDTDataList['aItems'] as $nKey => $aValue) { ?>
                        <tr>
                            <?php if ($aValue['PARTITION_HDDocNo'] == 1) { ?>
                                <td class="text-center" rowspan="<?=$aValue['MAX_HDDocNo']?>"><?=$aValue['FTRowSeq']?></td>
                                <td class="text-left" rowspan="<?=$aValue['MAX_HDDocNo']?>"><?=$aValue['FTBchName']?></td>
                                <td class="text-center" rowspan="<?=$aValue['MAX_HDDocNo']?>"><?=date_format(new DateTime($aValue['FDXthDocDate']),"d/m/Y")?></td>
                                <td class="text-left" rowspan="<?=$aValue['MAX_HDDocNo']?>"><?=$aValue['FTXthDocNo']?></td>
                                <td class="text-left" rowspan="<?=$aValue['MAX_HDDocNo']?>">
                                    <?php 
                                        if ($aValue['FTXthStaDoc'] == 3) {
                                            $tClassStaDoc = 'text-danger';
                                            $tStaDoc = language('common/main/main', 'tStaDoc3');
                                        }else{
                                            if ($aValue['FTXthStaDoc'] == 1 && $aValue['FTXthStaApv'] == '') {
                                                $tClassStaDoc = 'text-warning';
                                                $tStaDoc = language('common/main/main', 'tStaDoc');
                                            }else{
                                                $tClassStaDoc = 'text-success';
                                                $tStaDoc = language('common/main/main', 'tStaDoc1');
                                            }
                                        }
                                    ?>    
                                    <label class="xCNTDTextStatus <?php echo $tClassStaDoc;?>">
                                        <?php echo $tStaDoc;?>
                                    </label>    
                                </td>

                                <td class="text-left" rowspan="<?=$aValue['MAX_HDDocNo']?>">
                                    <?=$aValue['FTBchNameFrm']?>
                                </td>

                                <td class="text-left" rowspan="<?=$aValue['MAX_HDDocNo']?>">
                                    <?=$aValue['FTBchNameTo']?>
                                </td>
                                
                                <!-- ใบขอโอน -->
                                <td class="text-left" rowspan="<?=$aValue['MAX_HDDocNo']?>">
                                    <?php if (!empty($aValue['TR']) && $aValue['TR'] != '') { ?>
                                        <P class="DrillDown" onClick="JSxGotoDocTransferPage('<?= @$aValue['FTAgnCodeTR'] ?>','<?= $aValue['FTBchCodeTR'] ?>','<?= $aValue['TR'] ?>','TR')"><?=$aValue['TR'];?></P>
                                    <?php }else{ ?>
                                        <p><?= "-";?></p>   
                                    <?php }?>
                                </td>
                                
                                <!-- ใบจ่ายโอน -->
                                <td class="text-left" rowspan="<?=$aValue['MAX_HDDocNo']?>">
                                    <?php if (!empty($aValue['TBO']) && $aValue['TBO'] != '') { ?>
                                        <p class="DrillDown" onClick="JSxGotoDocTransferPage('<?= @$aValue['FTAgnCodeTBO'] ?>','<?= $aValue['FTBchCodeTBO'] ?>','<?= $aValue['TBO'] ?>','TBO')"><?=$aValue['TBO'];?></p>
                                    <?php }else{ ?>
                                        <p><?= "-";?></p>   
                                    <?php } ?>
                                </td>
                            <?php } ?>
                            <!-- ใบจัดสินค้า -->
                            <td class="text-left">
                                <?php if (!empty($aValue['PdtPick']) && $aValue['PdtPick'] != '') { ?>
                                    <p class="DrillDown" onClick="JSxGotoDocTransferPage('<?= @$aValue['FTAgnCodePdtPick'] ?>','<?= $aValue['FTBchCodePdtPick'] ?>','<?= $aValue['PdtPick'] ?>','PdtPick')"><?=$aValue['PdtPick'];?></p>
                                <?php }else{ ?>
                                    <p><?= "-";?></p>  
                                <?php } ?>
                            </td>
                            <?php if ($aValue['PARTITION_HDDocNo'] == 1) { ?>
                                <!-- ใบรับโอน -->
                                <td class="text-left" rowspan="<?=$aValue['MAX_HDDocNo']?>">
                                    <?php if (!empty($aValue['TBI']) && $aValue['TBI'] != '') { ?>
                                        <p class="DrillDown" onClick="JSxGotoDocTransferPage('<?= @$aValue['FTAgnCodeTBI'] ?>','<?= $aValue['FTBchCodeTBI'] ?>','<?= $aValue['TBI'] ?>','TBI')"><?=$aValue['TBI'];?></p>
                                    <?php }else{ ?>
                                        <p><?= "-";?></p>   
                                    <?php }?>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                        <tr>
                            <td colspan="15" class="text-center"><?php echo language('bank/bank/bank','tBnkNoData'); ?></td>
                        </tr>
                <?php } ?>
            </tbody>
        </table>
        </div>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <p>พบข้อมูลทั้งหมด <?=$aSDTDataList['rnAllRow']?> รายการ แสดงหน้า <?=$aSDTDataList['rnCurrentPage']?> / <?=$aSDTDataList['rnAllPage']?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPageSdt btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ -->
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvSDTClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aSDTDataList['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ -->
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
                <button onclick="JSvSDTClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aSDTDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvSDTClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<script>
    function JSvSDTClickPage(ptPage) {
        try{
            var nPageCurrent = '';
            var nPageNew;
            switch (ptPage) {
                case 'next': //กดปุ่ม Next
                    $('.xWBtnNext').addClass('disabled');
                    nPageOld = $('.xWPageSdt .active').text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                case 'previous': //กดปุ่ม Previous
                    nPageOld = $('.xWPageSdt .active').text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                default:
                    nPageCurrent = ptPage;
            }
            $('#oetSDTPage').val(nPageCurrent);
            JSxSDTSearchData(nPageCurrent);
        }catch(err){
            console.log('JSvSDTClickPage Error: ', err);
        }
    }
    
    //กดเพื่อไปยังเอกสารอื่น
    function JSxGotoDocTransferPage(ptSDTAgnCode, ptSDTBchCode, ptDocNo, ptSite){
        if (ptSite != '') {
            if (ptSite == 'TR') { //ใบขอโอน
                var tRoute = 'docTRB/2/0';
            }else if (ptSite == 'TBO') { //ใบจ่ายโอน
                var tRoute = 'docTransferBchOut/2/0';
            }else if(ptSite == 'TBI'){ //ใบรับโอน
                var tRoute = 'docTBI/2/0/5';
            }else if(ptSite == 'PdtPick'){ //ใบจัดสินค้า
                var tRoute = 'docPAM/2/0';
            }else{
                return;
            }
        }else{
            return;
        }
        
        var aValues = {
            tBchCode : $('#oetSDTBchCode').val(),
            tBchCodeFrm : $('#oetSDTBchCodeForm').val(),
            tBchNameFrm : $('#oetSDTBchNameForm').val(),
            tBchCodeTo : $('#oetSDTBchCodeTo').val(),
            tBchNameTo : $('#oetSDTBchNameTo').val(),
            tDocType : $('#ocmSDTDocType').val(),
            tStaDoc : $('#ocmStaDoc').val(),
            tStaDocTBI : $('#ocmStaDocTBI').val(),
            tDocNo : $('#oetSDTDocNo').val(),
            tDocDateForm : $('#oetSDTDocDateForm').val(),
            tDocDateTo : $('#oetSDTDocDateTo').val(),    
            nBackPage : $('#oetSDTPage').val()  
        };
        localStorage.setItem("aValues", JSON.stringify(aValues));

        $.ajax({
            type    : "POST",
            url     : tRoute,
            data    : {
                        tDocNo : ptDocNo,
                        tBchCode : ptSDTBchCode,
                        tAgnCode : ptSDTAgnCode
                    },
            cache   : false,
            timeout : 5000,
            success: function (tResult) {
                $(window).scrollTop(0);
                $('.odvMainContent').html(tResult);
                localStorage.tCheckBackStage = 'monDocTransfer';
                localStorage.tCheckBackStageData = 'monDocTransferData';
            }
        });
    }

</script>