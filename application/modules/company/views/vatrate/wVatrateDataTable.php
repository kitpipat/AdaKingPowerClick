<?php 
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>

<?php 
// echo '<pre>';
// echo print_r($aAlwEventVatrate); 
// echo '</pre>';
?>

<style>
.xCNBorderRight{
 border-right:1px solid #cccccc;
}
.xCNNonBorder{
 border-top:0px!important;
}
.xCNBorderBottom{
 border-bottom:1px solid #cccccc;
}

.table > tr > th {
     vertical-align: middle!important;
     font-size: 13px!important;
}
.table > tbody > tr > td {
     vertical-align: middle;
     font-size: 13px;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                    <?php if($aAlwEventVatrate['tAutStaFull'] == 1 || ($aAlwEventVatrate['tAutStaAdd'] == 1 || $aAlwEventVatrate['tAutStaEdit'] == 1)) : ?>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('company/vatrate/vatrate','tVATTBChoose'); ?></th>
                    <?php endif;?>
                        <th nowrap class="xCNTextBold text-center" style="width:45%;"><?php echo language('company/vatrate/vatrate','tVATRateCode'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;"><?php echo language('company/vatrate/vatrate','tVATTBRate'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('company/vatrate/vatrate','tVATTBDateStart'); ?></th>
                    <?php if($aAlwEventVatrate['tAutStaFull'] == 1 || ($aAlwEventVatrate['tAutStaAdd'] == 1 || $aAlwEventVatrate['tAutStaEdit'] == 1)) : ?>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('company/vatrate/vatrate','tVATTBDelete'); ?></th>
                    <?php endif;?>
                    <?php if($aAlwEventVatrate['tAutStaFull'] == 1 || ($aAlwEventVatrate['tAutStaAdd'] == 1 || $aAlwEventVatrate['tAutStaEdit'] == 1)) : ?>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('company/vatrate/vatrate','tVATTBManage'); ?></th>
                    <?php endif;?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if($aDataList['rtCode'] == 1 ): ?>
                        <?php 
                            $tVatCode = ''; 
                            foreach ($aDataList['raItems'] as $key => $aValue):
                            if($tVatCode != $aValue['rtVatCode']):
                        ?>
                            <tr id="otrVatrate<?php echo $key; ?>" class="otrVatrate xCNTextDetail2 " data-code="<?php echo $aValue['rtVatCode']; ?>" data-name="<?php echo $aValue['rtVatCode']; ?>">
                            <?php if($aAlwEventVatrate['tAutStaFull'] == 1 || ($aAlwEventVatrate['tAutStaAdd'] == 1 || $aAlwEventVatrate['tAutStaEdit'] == 1)) : ?>
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?php echo $key; ?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?php if( $aValue['FTStaRef'] == '1' ){ echo 'disabled'; } ?> onchange="JSxVatrateVisibledDelAllBtn(this, event)">
                                        <span class="<?php if( $aValue['FTStaRef'] == '1' ){ echo 'xCNDocDisabled'; } ?>" >&nbsp;</span>
                                    </label>
                                </td>
                            <?php endif;?>
                                <td nowrap class="otdVatCode text-left"><?php echo $aValue['rtVatCode']; ?></td>
                                <td nowrap class="text-right"><?php echo number_format($aValue['rtVatRate'], 0)." %"; ?></td>
                                <td nowrap class="text-center"><?php echo date("Y-m-d", strtotime($aValue['rtVatDateStart'])) ?></td>
                                <?php if($aAlwEventVatrate['tAutStaFull'] == 1 || ($aAlwEventVatrate['tAutStaAdd'] == 1 || $aAlwEventVatrate['tAutStaEdit'] == 1)) : ?>
                                    <td nowrap class="text-center">
                                        <img class="xCNIconTable xCNIconDel <?php if( $aValue['FTStaRef'] == '1' ){ echo 'xCNDocDisabled'; } ?>" src="<?php echo  base_url('/application/modules/common/assets/images/icons/delete.png'); ?>" <?php if( $aValue['FTStaRef'] == '2' ){ ?> onclick="JSaVatrateDelete('<?php echo $nCurrentPage; ?>','<?php echo $aValue['rtVatCode']; ?>','<?= language('common/main/main','tModalConfirmDeleteItemsYN')?>')" <?php } ?> >
                                    </td>
                                <?php endif;?>
                                <?php if($aAlwEventVatrate['tAutStaFull'] == 1 || ($aAlwEventVatrate['tAutStaAdd'] == 1 || $aAlwEventVatrate['tAutStaEdit'] == 1)) : ?>
                            
                                <td class="text-center">
                                    <img class="xCNIconTable" src="<?php echo  base_url('/application/modules/common/assets/images/icons/edit.png'); ?>" onClick="JSvCallPageVatrateEdit('<?php echo $aValue['rtVatCode']?>')">
                                </td>    
                                <?php endif;?>
                            </tr>
                        <?php  $tVatCode = $aValue['rtVatCode']; elseif($tVatCode == $aValue['rtVatCode']): ?>
                           <tr id="otrVatrate<?php echo $key; ?>" class="otrVatrate xCNTextDetail2" data-code="<?=$aValue['rtVatCode']?>" data-name="<?= $aValue['rtVatCode']?>">
                                <td nowrap colspan ="2" class="xCNNonBorder text-left"></td>
                                <td nowrap class="xCNNonBorder text-right"><?php echo number_format($aValue['rtVatRate'],0)." %"; ?></td>
                                <td nowrap class="xCNNonBorder text-center"><?php echo date("Y-m-d", strtotime($aValue['rtVatDateStart'])); ?></td>
                                <td nowrap class="xCNNonBorder"></td>
                                <td nowrap class="xCNNonBorder"></td>
                           </tr>
                            <?php endif;?> 
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='6'><?php echo language('common/main/main','tCMNNotFoundData'); ?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <p><?php echo language('common/main/main','tResultTotalRecord'); ?> <?php echo $aDataList['rnAllRow']; ?> <?php echo language('common/main/main','tRecord'); ?> <?php echo language('common/main/main','tCurrentPage'); ?> <?php echo $aDataList['rnCurrentPage']; ?> / <?php echo $aDataList['rnAllPage']; ?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPageVatrate btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvVatrateClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i = max($nPage-2, 1); $i <= max(0, min($aDataList['rnAllPage'], $nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvVatrateClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvVatrateClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDelVatrate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ospConfirmIDDelete">
            </div>
            <div class="modal-footer">
                <button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSaVatrateDelChoose('<?php echo $nCurrentPage; ?>')">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$('document').ready(function() {
    $('.xWVatDelete').attr('title', '<?php echo language('common/main/main', 'tCMNActionDelete'); ?>');
    $('.xWVatEdit').attr('title', '<?php echo language('common/main/main', 'tCMNActionEdit'); ?>');
    $('.xWVatSave').attr('title', '<?php echo language('common/main/main', 'tSave'); ?>');
    $('.xWVatCancel').attr('title', '<?php echo language('common/main/main', 'tCancel'); ?>');
});
</script>


