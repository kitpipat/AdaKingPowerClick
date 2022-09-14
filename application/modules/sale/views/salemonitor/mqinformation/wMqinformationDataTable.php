<div class="table-responsive ">
    <table id="otbMQIDataList" class="table table-striped">
        <thead>
            <tr>
            <?php if($bChkRoleButton==1){?>
                <!-- <th nowarp class="text-center xCNTextBold " >
                   <label class="fancy-checkbox ">
                        <input type="checkbox" class="" id="ocbListItemAll" name="ocbListItemAll">
                        <span class="">&nbsp;</span>
                    </label>
                </th> -->
            <?php } ?>
                <th nowarp class="text-center xCNTextBold " ><?=language('sale/salemonitor/salemonitor', 'tMQVirtualhost')?></th>
                <th nowarp class="text-center xCNTextBold " ><?=language('sale/salemonitor/salemonitor', 'tMQQeueuName')?></th>
                <th nowarp class="text-center xCNTextBold " ><?=language('sale/salemonitor/salemonitor', 'tMQMassage')?></th>
                <th nowarp class="text-center xCNTextBold " ><?=language('sale/salemonitor/salemonitor', 'tMQMassageUnAck')?></th>
                <th nowarp class="text-center xCNTextBold " ><?=language('sale/salemonitor/salemonitor', 'tMQMassageTotal')?></th>
                </th>
            </tr>
        </thead>
        <!-- <td nowarp class="text-center"><?php echo $tFNXshDocType ?></td> -->
        <tbody>
            <?php if (!empty($aListByQueue)) { ?>
                <?php foreach ($aListByQueue as $nKey => $aValue) :

                if(empty($aValue['name'])){
                        continue;
                }
                
                ?>
                    <tr>
                    <?php if($bChkRoleButton==1){?>
                        <!-- <td nowarp  class="text-center">
                            <label class="fancy-checkbox ">
                              <input  type="checkbox" class="ocbListItem" name="ocbListItem[]" value="<?php echo @$aValue['name'] ?>">
                                 <span class="">&nbsp;</span>
                            </label>
                        </td> -->
                        <?php } ?>
                        <td nowarp class="text-left"><?php echo @$aValue['vhost'] ?></td>
                        <td nowarp class="text-left"><?php echo @$aValue['name'] ?></td>
                        <td nowarp class="text-right"><?php echo @$aValue['messages_ready'] ?></td>
                        <td nowarp class="text-right"><?php echo @$aValue['messages_unacknowledged'] ?></td>
                        <td nowarp class="text-right"><?php echo @$aValue['messages'] ?></td>
        
                    </tr>
                <?php endforeach; ?>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function(){
  $("#oetMQISearch").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#otbMQIDataList tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$('#ocbListItemAll').click(function(){
            if($(this).prop('checked')==true){
                $('.ocbListItem').prop('checked',true);
            }else{
                $('.ocbListItem').prop('checked',false);
            }
});
</script>