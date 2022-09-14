<?php
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage   = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage   = '1';
    }
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive" style="min-height: 300px; max-height: 300px; overflow-y: scroll;">
            <table id="otbPIDisChgDataDocHDList" class="table">
                <thead>
                    <tr class="xCNCenter">
                        <th class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPIsequence')?></th>
                        <th class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPIBeforereducing')?></th>
                        <th class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPIValuereducingcharging')?></th>
                        <th class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPIAfterReducing')?></th>
                        <th class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPIType')?></th>
                        <th class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPIDiscountcharge')?></th>
                        <th class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBDelete')?></th>
                    </tr>    
                </thead>
                <tbody>
                    <?php if($aDataList['rtCode'] == 1 ):?>
                        <?php $tHideClass = 'xCNHide';?>
                        <?php foreach($aDataList['raItems'] AS $nKey => $aValue):?>
                            <tr class="xWPIDisChgTrTag">
                                <input type="hidden" class="xWPIDisChgCreatedAt" value="<?php echo $aValue['FDXtdDateIns'];?>">
                                <td nowrap class="text-center"><label class="xWPIDisChgIndex"><?php echo $aValue['FNRowID']; ?></label></td>
                                <td nowrap class="text-right"><label class="xWPIDisChgBeforeDisChg"></label></td>
                                <td nowrap class="text-right"><label class="xWPIDisChgValue"></label></td>
                                <td nowrap class="text-right"><label class="xWPIDisChgAfterDisChg"><?php echo $aValue['FNRowID']; ?></label></td>
                                <td nowrap style="padding-left: 5px !important;">
                                    <div class="form-group" style="margin-bottom: 0px !important;">
                                        <select class="dischgselectpicker form-control xWPIDisChgType" onchange="JSxPICalcDisChg(this);" value="<?php echo $aValue['FNRowID']; ?>">
                                            <option value='1' <?php echo $aValue['FTXtdDisChgType'] == '1' ? 'selected="true"' : ''; ?>><?php echo language('common/main/main', 'ลดบาท'); ?></option>
                                            <option value='2' <?php echo $aValue['FTXtdDisChgType'] == '2' ? 'selected="true"' : ''; ?>><?php echo language('common/main/main', 'ลด %'); ?></option>
                                            <option value='3' <?php echo $aValue['FTXtdDisChgType'] == '3' ? 'selected="true"' : ''; ?>><?php echo language('common/main/main', 'ชาร์จบาท'); ?></option>
                                            <option value='4' <?php echo $aValue['FTXtdDisChgType'] == '4' ? 'selected="true"' : ''; ?>><?php echo language('common/main/main', 'ชาร์ท %'); ?></option>
                                        </select>
                                    </div>
                                </td>
                                <td nowrap style="padding-left: 5px !important;">
                                    <div class="form-group" style="margin-bottom: 0px !important;">
                                        <input 
                                            class="form-control 
                                            xCNInputNumericWithDecimal xWPIDisChgNum" 
                                            onchange="JSxPICalcDisChg(this); JCNxPIDisChgSetCreateAt(this)"
                                            onkeyup="javascript:if(event.keyCode==13) JSxPICalcDisChg(this);"
                                            value="<?php echo $aValue['FCXtdDisChg']; /*preg_replace("([-,+,%]+)", "", $aValue['FTXtdDisChgTxt']);*/ ?>"
                                            type="text">
                                    </div>
                                </td>
                                <td nowrap class="text-center">
                                    <label class="xCNTextLink">
                                        <img class="xCNIconTable xWPIDisChgRemoveIcon" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" title="Remove" onclick="JSxPIResetDisChgRemoveRow(this)">
                                    </label>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <?php $tHideClass = '';?>
                    <?php endif;?>
                        <tr id="otrPIDisChgHDNotFound" class="<?php echo $tHideClass; ?>"><td class="text-center xCNTextDetail2" colspan='100%'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php if($nPage > 1) : ?>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aDataList['rnCurrentPage']?> / <?php echo $aDataList['rnAllPage']?></p>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="xWPage btn-toolbar pull-right">
                <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
                <button onclick="JSvPIDisChgHDClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                    <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
                </button>

                <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?>
                    <?php 
                        if($nPage == $i){ 
                            $tActive = 'active'; 
                            $tDisPageNumber = 'disabled';
                        }else{ 
                            $tActive = '';
                            $tDisPageNumber = '';
                        }
                    ?>
                    <button onclick="JSvPIDisChgHDClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                <?php } ?>

                <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
                <button onclick="JSvPIDisChgHDClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                    <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
                </button>
            </div>
        </div>
    </div>
<?php endif; ?>
<script>
    $(document).ready(function(){
        $('.dischgselectpicker').selectpicker();
        JSxPICalcDisChg();
    });
</script>