<style>
    .xCNBTNPrimeryDisChgPlus{
        border-radius: 50%;
        float: left;
        width: 20px;
        height: 20px;
        line-height: 20px;
        background-color: #1eb32a;
        text-align: center;
        margin-top: 6px;
        /* margin-right: -15px; */
        font-size: 22px;
        color: #ffffff;
        cursor: pointer;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
    }
</style>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="table-responsive">
        <table id="" class="table xWPdtTableFont">
            <thead>
                <tr class="xCNCenter">
                    <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/conditionredeem/conditionredeem','tRDHCpdSeqNo')?></th>
                    <th nowrap class="xCNTextBold" style="width:20%;"><?php echo language('document/conditionredeem/conditionredeem','tRDHTabCouponHDPdtCode')?></th>
                    <th nowrap class="xCNTextBold" style="width:30%;"><?php echo language('document/conditionredeem/conditionredeem','tRDHTabCouponHDPdtName')?></th>
                    <th nowrap class="xCNTextBold" style="width:15%;"><?php echo language('document/conditionredeem/conditionredeem','tRDHTabCouponHDPdtPunCode')?></th>
                    <th nowrap class="xCNTextBold" style="width:15%;"><?php echo language('document/conditionredeem/conditionredeem','tRDHTabCouponHDPdtBarCode')?></th>
                    <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupDelete')?></th>
                </tr>
            </thead>
            <tbody id="">
                <?php $nNumSeq  = 0;?>
                <?php if($aDataDocDTTemp['rtCode'] == 1):?>
                    <?php foreach($aDataDocDTTemp['raItems'] as $DataTableKey => $aDataTableVal): ?>
                        <tr class="xCNTextDetail2 nItem<?php echo $nNumSeq?> xWPdtItem" >
                             <td nowrap class="text-center"><label><?php echo $aDataTableVal['rtRowID']?></label></td>
                             <td nowrap class="text-left"><label><?php echo $aDataTableVal['FTPdtCode']?></label></td>
                             <td ><label><?php echo $aDataTableVal['FTPdtName']?></label></td>
                             <td ><label><?php echo $aDataTableVal['FTPunName']?></label></td>
                             <td nowrap class="text-left"><label><?php echo $aDataTableVal['FTRddBarCode']?></label></td>
                             <td nowrap class="text-center xCNPIBeHideMQSS">
                                <label class="xCNTextLink">
                    <?php if($tRDHStaApv!=1){ ?>
                                    <img 
                                         class="xCNIconTable" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>"
                                         title="Remove" 
                                         onclick="JSnRDHDelPdtInDTTempSingle('<?php echo $aDataTableVal['FNRddSeq']?>','<?php echo $aDataTableVal['FTSessionID']?>')"
                                     >
                    <?php  } ?>
                                </label>
                            </td>

                        </tr>
                        <?php $nNumSeq++; ?>
                    <?php endforeach;?>
                <?php else:?>
                    <tr><td class="text-center xCNTextDetail2 xWPITextNotfoundDataPdtTable" colspan="100%"><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                <?php endif;?>
            </tbody>
        </table>
    </div>
</div>
<?php if($aDataDocDTTemp['rnAllPage'] > 1) : ?>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aDataDocDTTemp['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aDataDocDTTemp['rnCurrentPage']?> / <?php echo $aDataDocDTTemp['rnAllPage']?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPagePIPdt btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvRDHPDTDocDTTempClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataDocDTTemp['rnAllPage'],$nPage+2)); $i++){?> 
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvRDHPDTDocDTTempClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataDocDTTemp['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvRDHPDTDocDTTempClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
<?php endif;?>

