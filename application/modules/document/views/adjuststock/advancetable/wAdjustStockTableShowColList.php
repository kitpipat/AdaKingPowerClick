<div style="max-height:350px;overflow:auto;">
    <table id="otbASTOrderListDetail" class="table table-bordered table-striped">
        <thead>
            <tr class="xCNCenter">
                <th style="width:20px;"><?php echo language('common/main/main','tModalAdvNo')?></th>
                <th><?php echo language('common/main/main','tModalAdvColName')?></th>
                <th class="text-center" style="width:20px;"><?php echo language('common/main/main','tModalAdvChoose')?></th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($aAvailableColumn) && !empty($aAvailableColumn)):?>
                <?php $i = 1; ?>
                <?php foreach($aAvailableColumn as $nAdvTblKey => $aDataAdvTbl):?>
                    <?php 
                        if($aDataAdvTbl->FTShwFedSetByUsr == '1'){
                            $tChecked   = 'checked';
                        }else{
                            $tChecked   = '';
                        }
                    ?>
                    <?php if($aDataAdvTbl->FTShwNameUsr != '' && $aDataAdvTbl->FTShwFedShw != ""): ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><label contenteditable="true" class="xWASTLabelColumnName"><?php echo $aDataAdvTbl->FTShwNameUsr;?></label></td>
                            <td class="text-center">
                                <input class="xWASTInputColStaShow" type="checkbox" <?php echo $tChecked?> data-id="<?php echo $aDataAdvTbl->FTShwFedShw;?>">
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else:?>
                <tr><td class='text-center xCNTextDetail2' colspan='100'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
            <?php endif;?>
        </tbody>
    </table>
</div>
<div style="padding:10px 0px;"><input type="checkbox" id="ocbASTSetDefAdvTable"> <?php echo language('common/main/main','tModalAdvUseDefOption')?></div>
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.tablednd.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#otbASTOrderListDetail").tableDnD();
    });
</script>
