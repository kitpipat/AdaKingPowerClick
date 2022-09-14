<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="table-responsive">
    </div>
    <table id="otbPriRntLkTabelDataDT" class="table">
        <thead>
            <tr class="xCNCenter">
                <th nowrap><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkTBRtdTmeType')?></th>
                <th nowrap><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkTBRtdMinQty')?></th>
                <th nowrap><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkTBRtdCalMin')?></th>
                <th nowrap><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkTBRtdPrice')?></th>
                <th nowrap style="width:10%;"><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkTBDelete')?></th>
            </tr>
        </thead>
        <tbody class="xWPriRntLkTableBody">
            <?php if(isset($aPriRntLkDataDT['rtCode']) && $aPriRntLkDataDT['rtCode'] == 1):?>
                <?php foreach($aPriRntLkDataDT['raItems'] AS $nKey => $aValue):?>
                    <tr class="xCNPriRntLkItem"
                        data-index="<?php   echo $aValue['FNRtdSeqNo'];?>"
                        data-seqno="<?php   echo $aValue['FNRtdSeqNo'];?>"
                        data-docno="<?php   echo $aValue['FTRthCode'];?>"
                        data-tmetype="<?php echo $aValue['FTRtdTmeType'];?>"
                        data-minqty="<?php  echo $aValue['FNRtdMinQty'];?>"
                        data-calmin="<?php  echo $aValue['FNRtdCalMin'];?>"
                        data-price="<?php   echo $aValue['FCRtdPrice'];?>"
                    >
                        <?php
                            $tPriRntLkTmeTypeName = "";
                            switch($aValue['FTRtdTmeType']){
                                case '1' :
                                    $tPriRntLkTmeTypeName = language('document/pricerentlocker/pricerentlocker','tPriRntLkRtdTmeType1');
                                break;
                                case '2' :
                                    $tPriRntLkTmeTypeName = language('document/pricerentlocker/pricerentlocker','tPriRntLkRtdTmeType2');
                                break;
                                case '3' :
                                    $tPriRntLkTmeTypeName = language('document/pricerentlocker/pricerentlocker','tPriRntLkRtdTmeType3');
                                break;
                                case '4' :
                                    $tPriRntLkTmeTypeName = language('document/pricerentlocker/pricerentlocker','tPriRntLkRtdTmeType4');
                                break;
                                case '5' :
                                    $tPriRntLkTmeTypeName = language('document/pricerentlocker/pricerentlocker','tPriRntLkRtdTmeType5');
                                break;
                            }
                        ?>
                        <td nowrap class="text-left"><?php echo $tPriRntLkTmeTypeName;?></td>
                        <td nowrap class="text-center xCNPriRntLkEditInLine xWPriRntLKRtdMinQty"><?php echo $aValue['FNRtdMinQty']?></td>
                        <td nowrap class="text-center xWPriRntLkRtdCalMin"><label><?php echo $aValue['FNRtdCalMin'];?></label></td>
                        <td nowrap class="text-center xCNPriRntLkEditInLine xWPriRntLKRtdPrice"><?php echo $aValue['FCRtdPrice'] ?></td>
                        <td nowrap class="text-center">
                            <label class="xCNTextLink">
                                <img class="xCNIconTable" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" title="Remove" onclick="JSnPriRntLkRemoveDocDTTempRow(this)">
                            </label>
                        </td>
                    </tr>
                <?php endforeach;?>
            <?php else:?>
                <tr><td class="text-center xWPriRntLkTextNotfoundDataDT" colspan="100%"><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
            <?php endif;?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        // Set Value Type
        if($('#ohdPriRntLkRoute').val() == 'dcmPriRntLkEventEdit'){
            var tCountDataInTbl = $('#otbPriRntLkTabelDataDT tbody .xCNPriRntLkItem').length;
            if(tCountDataInTbl > 0){
                var tPriRntLkTmeType    = $('#otbPriRntLkTabelDataDT tbody').children('tr:first').data('tmetype');
                $('#ocmPriRntLkRtdTmeType').val(tPriRntLkTmeType);
                $('#ocmPriRntLkRtdTmeType').prop("disabled",true);
                $('#ocmPriRntLkRtdTmeType').selectpicker('refresh');
            }
        }
    });
</script>