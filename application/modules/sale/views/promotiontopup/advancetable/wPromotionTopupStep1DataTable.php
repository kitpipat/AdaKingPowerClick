<div class="table-responsive">

    <input type="text" class="xCNHide" id="oetPTUStep1NumRow" value="<?=$aDataList['nNumRow']?>">
    <table class="table table-striped xWPdtTableFont" id="otbPTUStep1Table">
        <thead>
            <tr>
                <th width="5%" class="text-center"><?php echo language('sale/promotiontopup/promotiontopup', 'tTBNo'); ?></th>
                <th width="45%" class="text-center"><?php echo language('sale/promotiontopup/promotiontopup', 'tPTUTBCtyName'); ?></th>
                <th width="20%" class="text-center"><?php echo language('sale/promotiontopup/promotiontopup', 'tGroup'); ?></th>
                <th width="5%" class="text-center xWPTUHideOnApvOrCancel"><?php echo language('sale/promotiontopup/promotiontopup', 'tTBDelete'); ?></th>
                <th width="5%" class="text-center xWPTUHideOnApvOrCancel"><?php echo language('sale/promotiontopup/promotiontopup', 'tTitleEdit'); ?></th>
                
            </tr>
        </thead>
        <tbody>
            <?php if ($aDataList['tCode'] == 1) { ?>
                <?php foreach ($aDataList['aItems'] as $key => $aValue) { ?>
                    <tr class="xCNTextDetail2" 
                        data-ctycode="<?php echo $aValue['FTCtyCode']; ?>" 
                        data-ctyname="<?php echo $aValue['FTCtyName']; ?>"
                        data-statype="<?php echo $aValue['FTPmdStaType']; ?>"
                        data-seq="<?php echo $aValue['FNPmdSeq']; ?>"
                    >
                        <td class="text-center"><?php echo $key+1; ?></td>
                        <td class="text-left"><?php echo $aValue['FTCtyName']; ?></td>
                        <td class="text-left"><?php echo language('sale/promotiontopup/promotiontopup', 'tStaType'.$aValue['FTPmdStaType']); ?></td>
                        <td class="text-center xWPTUHideOnApvOrCancel">
                            <img class="xCNIconTable xCNIconDel xWPTUStep1Del" src="<?= base_url('application/modules/common/assets/images/icons/delete.png') ?>">
                        </td>
                        <td class="text-center xWPTUHideOnApvOrCancel">
                            <img class="xCNIconTable xCNIconEdit xWPTUStep1Edit" src="<?= base_url('application/modules/common/assets/images/icons/edit.png') ?>">
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

    $('.xWPTUStep1Del').off('click');
    $('.xWPTUStep1Del').on('click',function(){
        JSxPTUEventStep1Delete($(this));
    });

    // Create By : Napat(Jame) 23/09/2020
    $('.xWPTUStep1Edit').off('click');
    $('.xWPTUStep1Edit').on('click',function(){
        JSxPTUEventStep1Edit($(this));
    });

    $(document).ready(function(){
        if(bIsApvOrCancel){
            $('.xWPTUHideOnApvOrCancel').hide();
        }
    });
</script>