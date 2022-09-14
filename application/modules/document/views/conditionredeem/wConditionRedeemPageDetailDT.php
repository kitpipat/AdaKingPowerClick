<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="table-responsive">
        <table id="otbRDHDataDetailDT" class="table xWPdtTableFont">
            <thead>
                <tr>
                    <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/conditionredeem/conditionredeem','tRDHCpdSeqNo')?></th>
                    <th nowrap class="xCNTextBold" style="width:60%;"><?php echo language('document/conditionredeem/conditionredeem','tRDHCpdBarCpn')?></th>
                    <th nowrap class="xCNTextBold" style="width:20%;"><?php echo language('document/conditionredeem/conditionredeem','tRDHCpdHisQtyUse')?></th>
                    <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1):?>
                        <?php if($tRDHStaDoc == 1 && $tRDHStaApv == ""): ?>
                            <th nowrap class="xCNTextBold" style="width:5%;"><?php echo language('common/main/main','tCMNActionDelete')?></th>
                        <?php endif;?>
                    <?php endif;?>
                </tr>
            </thead>
                <?php if(isset($aDataDetailDT['rtCode']) && $aDataDetailDT['rtCode'] == 1):?>
                    <?php foreach($aDataDetailDT['raItems'] as $nKeys => $aDataValue):?>
                        <?php
                            $tPathImage = $aDataValue['FTImgObj'];
                            $aExplode   = explode('/',$tPathImage);
                            $tImageName = end($aExplode);
                        ?>

                        <tr 
                            class="xWRDHDataDetailItems"
                            data-imageold="<?php echo @$tImageName;?>"
                            data-imagenew="<?php echo @$tImageName;?>"
                            data-cpdbarcpn="<?php echo @$aDataValue['FTCpdBarCpn'];?>"
                        >
                            <td nowrap class="text-center xWRDHNumberSeq"><?php echo @$nKeys+1;?></td>
                            <td nowrap class="text-let"><?php echo @$aDataValue['FTCpdBarCpn'];?></td>
                            <td nowrap>
                                <input type="text" class="form-control text-right xWCpdAlwMaxUse xCNInputWhenStaCancelDoc" value="<?php echo @$aDataValue['FNCpdAlwMaxUse'];?>">
                            </td>
                
                            <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1):?>
                                <?php if($tRDHStaDoc == 1 && $tRDHStaApv == ""): ?>
                                    <td nowrap class="text-center">
                                        <label class="xCNTextLink">
                                            <img class="xCNIconTable xWRDHRemoveDetailTD" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" title="Remove" onclick="JSxRDHDeleteRowDTItems(this)">
                                        </label>
                                    </td>
                                <?php endif;?>
                            <?php endif;?>
                        </tr>
                    <?php endforeach;?>
                <?php else:?>
                    <tr><td class="text-center xCNTextDetail2 xWRDHTextNotfoundData" colspan="100%"><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                <?php endif;?>
        </table>
    </div>
</div>