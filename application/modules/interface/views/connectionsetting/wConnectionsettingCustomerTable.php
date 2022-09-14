<div class="table-responsive">
  <table class="table table-striped" style="width:100%" id="otbTableForCheckbox">
      <thead>
        <tr class="xCNCenter">
          <th nowrap class="xCNTextBold"  style="width:5%;"><?php echo language('interface/connectionsetting/connectionsetting', 'tChoose'); ?></th>
          <th nowrap class="xCNTextBold"  style="width:25%;"><?php echo language('interface/connectionsetting/connectionsetting', 'tTBBanch'); ?></th>
          <th nowrap class="xCNTextBold"  style="width:30%;"><?php echo language('pos\poschannel\poschannel', 'tCHNTitle'); ?></th>
          <th nowrap class="xCNTextBold"  style="width:30%;"><?php echo language('interface/connectionsetting/connectionsetting', 'tTABthCustomer'); ?></th>
          <th nowrap class="xCNTextBold"  style="width:5%;"><?php echo language('interface/connectionsetting/connectionsetting', 'tTBDel'); ?></th>
          <th nowrap class="xCNTextBold"  style="width:5%;"><?php echo language('interface/connectionsetting/connectionsetting', 'tTBEdit'); ?></th>
        </tr>
      </thead>
      <tbody>
          <?php if($aCustomerLis['rtCode'] == 1 ):?>
              <?php foreach($aCustomerLis['raItems'] AS $key=>$aValue){ ?>
                  <tr class="text-center xCNTextDetail2"  data-code="<?php echo $aValue['FTBchCode']?>" data-codecus="<?php echo $aValue['FTCbrSoldTo']?>">
                      <td class="text-center">
                          <label class="fancy-checkbox">
                              <input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]"
                              data-code="<?php echo $aValue['FTBchCode']?>"
                              data-name="<?php echo $aValue['FTCbrSoldTo']?>"
                              ohdConfirmBchDelete="<?php echo $aValue['FTBchCode']?>"
                              ohdConfirmCusDelete="<?php echo $aValue['FTCbrSoldTo']?>"
                              >
                              <span>&nbsp;</span>
                          </label>
                      </td>
                      <td style="text-align:left;"><?=$aValue['FTBchName']?></td>
                      <td style="text-align:left;"><?=(empty($aValue['FTChnName']) ? '-' : $aValue['FTChnName'] )?></td>
                      <td style="text-align:left;"><?=$aValue['FTCbrSoldTo']?></td>
                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                    <td><img class="xCNIconTable xCNIconDel" src="<?= base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSxConSetDelete('<?=$aValue['FTBchCode'];?>','<?=$aValue['FTCbrSoldTo'];?>', '<?= language('common/main/main','tModalConfirmDeleteItemsYN')?>')"></td>
                <?php endif; ?>
                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                  <td><img class="xCNIconTable" src="<?= base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageEditConnectionSetting('<?=$aValue['FTBchCode'];?>','<?=$aValue['FTCbrSoldTo'];?>','<?=$aValue['FTChnCode']?>')"></td>
                <?php endif; ?>
                  </tr>
              <?php } ?>
          <?php else:?>
          <tr><td class='text-center xCNTextDetail2' colspan='100'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
          <?php endif;?>
      </tbody>
  </table>
</div>
