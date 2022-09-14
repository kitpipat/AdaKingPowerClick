<script type="text/javascript">
$(document).ready(function() {
    // Initialise the table
    $("#otbOrderListDetail").tableDnD();
});
</script>
<div style="height:350px;overflow:auto;">
        <table class="table table-bordered table-striped" id="otbOrderListDetail">
                <tr class="xCNCenter">
                    <th style="width:20px;"><?= language('common/main/main','tModalAdvNo')?></th>
                    <th><?= language('common/main/main','tModalAdvColName')?></th>
                    <th class="text-center" style="width:20px;"><?= language('common/main/main','tModalAdvChoose')?></th>
                </tr> 
                <?php 
                     $i = 1;
                     foreach($aAvailableColumn as $ShowColKey=>$ShowColVal){
                     if($ShowColVal->FTShwFedSetByUsr == 1){
                        $tChecked = 'checked';
                     }else{
                        $tChecked = '';
                     }
                ?>
                <tr>
                    <td><?=$i?></td>
                    <td><label contenteditable="true" class="olbColumnLabelName"><?php echo $ShowColVal->FTShwNameUsr?></label></td>
                    <td class="text-center">        
                    <input class="ocbColStaShow" type="checkbox" <?=$tChecked?> data-id="<?=$ShowColVal->FTShwFedShw?>">
                    </td>
                </tr>
                <?php $i++; ?>
                <?php } ?>
        </table>
</div>

<div style="padding:10px 0px;"><input type="checkbox" id="ocbSetToDef"> <?= language('common/main/main','tModalAdvUseDefOption')?></div>