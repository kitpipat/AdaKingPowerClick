<div class="xCNBnkVMaster">
  <div class="col-xs-12 col-md-12 text-right">
    <div id="odvBtnBnkInfo" style="display: block;">
      <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageBnkAddInfo2()">+</button>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:20px !important;">
        <div class="table-responsive col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <table id="otbBnkDataList" class="table table-striped">
                <thead>
                    <tr>
                      <th class="text-center xCNTextBold" style="width:5%;"><?php echo language('bank/bank/bank', 'tBNKTitleTableNo'); ?></th>
                      <th class="text-center xCNTextBold" style="width:55%;"><?php echo language('bank/bank/bank', 'tBNKTitleTableStmName'); ?></th>
                      <th class="text-center xCNTextBold" style="width:10%;"><?php echo language('bank/bank/bank', 'tBNKTitleTableStmLimit'); ?></th>
                      <th class="text-center xCNTextBold" style="width:10%;"><?php echo language('bank/bank/bank', 'tBNKTitleTableStmQty'); ?></th>
                      <th class="text-center xCNTextBold" style="width:10%;"><?php echo language('bank/bank/bank', 'tBNKTitleTableStaUnit'); ?></th>
                      <th class="text-center xCNTextBold" style="width:5%;"><?php echo language('bank/bank/bank', 'tBNKTBDelete'); ?></th>
                      <th class="text-center xCNTextBold" style="width:5%;"><?php echo language('bank/bank/bank', 'tBNKTBEdit'); ?></th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                  $aStaUnit =  array(
                    '1' => language('bank/bank/bank', 'tBNKd'),
                    '2' => language('bank/bank/bank', 'tBNKm'),
                    '3' => language('bank/bank/bank', 'tBNKy')
                  );
                  if (isset($aBnkData['raItems'])) {
                    for ($n=0; $n < count($aBnkData['raItems']); $n++) { ?>
                      <tr>
                        <td class="text-center"><?php echo $aBnkData['raItems'][$n]['FNStmSeq']; ?></td>
                        <td><?php echo $aBnkData['raItems'][$n]['FTStmName']; ?></td>
                        <td class="text-right"><?php echo $aBnkData['raItems'][$n]['FCStmLimit']; ?></td>
                        <td class="text-right"><?php echo $aBnkData['raItems'][$n]['FCStmQty']; ?></td>
                        <td class="text-center"><?php echo $aStaUnit[$aBnkData['raItems'][$n]['FTStmStaUnit']]; ?></td>
                        <td class="text-center">
                          <img class="xCNIconTable" src="<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoBankInfo2Del('<?php echo $aBnkData['raItems'][$n]['FNStmSeq']?>','<?php echo $aBnkData['raItems'][$n]['FTBnkCode']?>','<?=$aBnkData['raItems'][$n]['FTStmName'];?>')">
                        </td>
                        <td class="text-center">
                          <img class="xCNIconTable" src="<?=base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageBankEditInfo2('<?php echo $aBnkData['raItems'][$n]['FNStmSeq']?>','<?php echo $aBnkData['raItems'][$n]['FTBnkCode']?>')">
                        </td>
                      </tr>
                      <?php
                    }
                  }else {
                    echo "<tr class='text-center'><td colspan='7'> ".language('common/main/main', 'tCMNNotFoundData')." </td></tr>";
                  }?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDelInstallment">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDeleteInstallment"> - </span>
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery xCNDeleteInstallment"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

    function JSvCallPageBankEditInfo2(pnStmSeq,ptBnkCode) {
      $.ajax({
          type    : "POST",
          url     : "bankPageBnkAddInfo2",
          data    : {nStmSeq:pnStmSeq,tBnkCode:ptBnkCode},
          cache   : false,
          timeout : 0,
          success: function(vResult){
              $("#odvBtnAddEdit").hide();
              $("#odvBnkContentInfo2").html(vResult);
              $("#oetBnkCodeInfo2").val(ptBnkCode);
          },
          error: function(jqXHR, textStatus, errorThrown) {
              JCNxResponseError(jqXHR, textStatus, errorThrown);
          }
      });
    }

    function JSoBankInfo2Del(pnStmSeq,ptBnkCode,ptTextname) {
        $('#odvModalDelInstallment').modal('show');
        $('#ospConfirmDeleteInstallment').html($('#oetTextComfirmDeleteSingle').val() + pnStmSeq + ' ( ' + ptTextname + ' ) '+ '<?= language('common/main/main','tModalConfirmDeleteItemsYN')?>' );

        $('.xCNDeleteInstallment').off();
        $('.xCNDeleteInstallment').on('click', function(evt) {
          $.ajax({
              type    : "POST",
              url     : "bankEventDeleteinfo2",
              data    : {nStmSeq:pnStmSeq , tBnkCode:ptBnkCode},
              cache   : false,
              timeout : 0,
              success : function(vResult){
                  $('#odvModalDelInstallment').modal('hide');

                  setTimeout(function(){ 
                    $("#odvBtnAddEdit").hide();
                    $('#oliBnkDataAddInfo2').click();
                  }, 1000);
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  JCNxResponseError(jqXHR, textStatus, errorThrown);
              }
          });
        });
    }
</script>
