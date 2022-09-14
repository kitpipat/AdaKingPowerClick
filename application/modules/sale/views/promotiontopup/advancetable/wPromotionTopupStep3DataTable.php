<div class="table-responsive">

    <input type="text" class="xCNHide" id="oetPTUStep3NumRow" value="<?=$aDataList['nNumRow']?>">
    <table class="table table-striped xWPdtTableFont" id="otbPTUStep3Table">
        <thead>
            <tr>
                <th width="5%" class="text-center"><?php echo language('sale/promotiontopup/promotiontopup', 'tTBNo'); ?></th>
                <th class="text-center"><?php echo language('sale/promotiontopup/promotiontopup', 'tPTUStep3Agency'); ?></th>
                <th class="text-center"><?php echo language('sale/promotiontopup/promotiontopup', 'tBCH'); ?></th>
                <!-- <th class="text-center"><?php echo language('sale/promotiontopup/promotiontopup', 'tBusinessGroup'); ?></th>
                <th class="text-center"><?php echo language('sale/promotiontopup/promotiontopup', 'tTBShp'); ?></th> -->
                <th class="text-center"><?php echo language('sale/promotiontopup/promotiontopup', 'tGroup'); ?></th>
                <th width="5%" class="text-center xWPTUHideOnApvOrCancel"><?php echo language('sale/promotiontopup/promotiontopup', 'tTBDelete'); ?></th>
                <th width="5%" class="text-center xWPTUHideOnApvOrCancel"><?php echo language('sale/promotiontopup/promotiontopup', 'tTitleEdit'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($aDataList['tCode'] == 1) { ?>
                <?php foreach ($aDataList['aItems'] as $key => $aValue) { ?>
                    <tr class="xCNTextDetail2 xWPTUStep3Tr" 
                        data-seq      = "<?php echo $aValue['FNPmdSeq']; ?>"
                        data-agn-code = "<?php echo $aValue['FTPmhAgnTo']; ?>"
                        data-agn-name = "<?php echo $aValue['FTAgnName']; ?>"
                        data-bch-code = "<?php echo $aValue['FTPmhBchTo']; ?>"
                        data-bch-name = "<?php echo $aValue['FTBchName']; ?>"
                        data-shp-code = "<?php echo $aValue['FTPmhShpTo']; ?>"
                        data-shp-name = "<?php echo $aValue['FTShpName']; ?>"
                        data-mer-code = "<?php echo $aValue['FTPmhMerTo']; ?>"
                        data-mer-name = "<?php echo $aValue['FTMerName']; ?>"
                        data-type     = "<?php echo $aValue['FTPmhStaType']; ?>"
                    >
                        <td class="text-center"><?php echo $key+1; ?></td>
                        <td class="text-left"><?php echo ($aValue['FTAgnName'] == "" ? language('sale/promotiontopup/promotiontopup', 'tNull') : $aValue['FTAgnName']); ?></td>
                        <td class="text-left"><?php echo ($aValue['FTBchName'] == "" ? language('sale/promotiontopup/promotiontopup', '') : $aValue['FTBchName']); ?></td>
                        <!-- <td class="text-left"><?php echo ($aValue['FTMerName'] == "" ? language('sale/promotiontopup/promotiontopup', 'tNull') : $aValue['FTMerName']); ?></td>
                        <td class="text-left"><?php echo ($aValue['FTShpName'] == "" ? language('sale/promotiontopup/promotiontopup', 'tNull') : $aValue['FTShpName']); ?></td> -->
                        <td class="text-left"><?php echo language('sale/promotiontopup/promotiontopup', 'tPTUStep3Sta'.$aValue['FTPmhStaType']); ?></td>
                        <td class="text-center xWPTUHideOnApvOrCancel">
                            <img class="xCNIconTable xCNIconDel xWPTUStep3Del" src="<?= base_url('application/modules/common/assets/images/icons/delete.png') ?>">
                        </td>
                        <td class="text-center xWPTUHideOnApvOrCancel">
                            <img class="xCNIconTable xCNIconEdit xWPTUStep3Edit" src="<?= base_url('application/modules/common/assets/images/icons/edit.png') ?>">
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                </tr>
            <?php }; ?>
        </tbody>
    </table>
</div>
<script>

    $('.xWPTUStep3Del').off('click');
    $('.xWPTUStep3Del').on('click',function(){
        JSxPTUEventStep3Delete($(this));
    });

    // Create By : Napat(Jame) 23/09/2020
    $('.xWPTUStep3Edit').off('click');
    $('.xWPTUStep3Edit').on('click',function(){
        JSxPTUEventStep3Edit($(this));
    });

    $(document).ready(function(){
        if(bIsApvOrCancel){
            $('.xWPTUHideOnApvOrCancel').hide();
        }
    });
</script>