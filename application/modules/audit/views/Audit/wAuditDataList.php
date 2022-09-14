<div class="panel panel-headline">
    <?php if ($this->session->userdata('tSesUsrLevel') != "HQ") { ?>
    <div class="panel-body">
      <div>
        <div>
          <div class="row" style="padding-left:27px">
            <strong><?= language('audit/audit/audit','tAUDTitleBankForm')?> : <?php echo $this->session->userdata('tSesUsrAgnName'); ?></strong>
            <input type="hidden" name="" id="oetAudCode" value="<?php echo $this->session->userdata('tSesUsrAgnCode'); ?>">
          </div>
          <div class="wrapper">
            <ul class="StepProgress">
              <li class="StepProgress-item is-done"></li>
              <li class="StepProgress-item" style="padding-top:10px"></li>
            </ul>
          </div>
          <div class="row" style="padding-left:27px">
            <strong><?= language('audit/audit/audit','tAUDTitleBankTo')?> : <?php if(isset($aAudDataList['raItems'][0]['FTAgnNameTo'])){ echo $aAudDataList['raItems'][0]['FTAgnNameTo']; }else{ echo language('audit/audit/audit','tAUDNoDataBankTo'); } ?></strong>
          </div>
        </div>
      </div>
    </div>
  <?php }else if ($this->session->userdata('tSesUsrLevel')=="HQ") { ?>
      <div class="panel-heading">
        <div class="row"> <!-- เพิ่ม -->
          <div class="col-xs-12 col-md-4 col-lg-4">
            <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
              <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDTitleSearch')?> </label>
              <div class="input-group">
                <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAll" name="oetSearchAll" onkeyup="Javascript:if(event.keyCode==13) JSvBranchDataTable()" value="" placeholder="กรอกคำค้นหา">
                <span class="input-group-btn">
                  <button class="btn xCNBtnSearch" type="button" onclick="JSvBranchDataTable()">
                    <img class="xCNIconAddOn" src="<?php echo base_url();?>/application/modules/common/assets/images/icons/search-24.png">
                  </button>
                </span>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
          </div>
        </div>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th nowrap="" class="xCNTextBold" style="width:5%;text-align:center;"><?= language('audit/audit/audit','tAUDTitleNo')?></th>
                    <th nowrap="" class="xCNTextBold" style="width:45%;text-align:center;"><?= language('audit/audit/audit','tAUDTitleBankForm')?></th>
                    <th nowrap="" class="xCNTextBold" style="width:40%;text-align:center;"><?= language('audit/audit/audit','tAUDTitleBankTo')?></th>
                    <th nowrap="" class="xCNTextBold" style="width:5%;text-align:center;"><?= language('audit/audit/audit','tAUDTitleDel')?></th>
                    <th nowrap="" class="xCNTextBold" style="width:5%;text-align:center;"><?= language('audit/audit/audit','tAUDTitleEdit')?></th>
                  </tr>
                </thead>
                <tbody id="otbAUDList"><?php
                if (isset($aAudDataList['raItems'])) {
                  foreach ($aAudDataList['raItems'] as $nkey => $aValue) { ?>
                    <tr>
                      <td class="text-center"><?php echo $aValue['rtRowID']; ?></td>
                      <td><?php echo $aValue['FTAgnNameFrm']; ?></td>
                      <td><?php echo $aValue['FTAgnNameTo']; ?></td>
                      <td class="text-center">
                        <button type="button" name="button" onclick="JSnAuditDel('<?php echo $aValue['FTAgnFrm']; ?>','<?php echo $aValue['FTAgnTo']; ?>');">
                          <img class="xCNIconTable xCNIconDel" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>">
                        </button>
                      </td>
                      <td class="text-center">
                        <button type="button" name="button" onclick="JSnAuditEdit('<?php echo $aValue['FTAgnFrm']; ?>','<?php echo $aValue['FTAgnTo']; ?>');">
                          <img class="xCNIconTable xCNIconEdit xWPdtCallPageEdit">
                        </button>
                      </td>
                    </tr>
                  <?php } }else { ?>
                      <tr><td class='text-center xCNTextDetail2' colspan='5'><?= language('bank/bank/bank','tBnkNoData')?></td></tr>
                      <?php
                  }?>
                </tbody>
               </table>
            </div>
          </div>
        </div>

        <div class="row" >
          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <p><?= language('audit/audit/audit','tAudPadinationData')?> <?php if(isset($aAudDataList['raItems'])){ echo count($aAudDataList['raItems']); } ?> <?= language('audit/audit/audit','tAudPadinationDataPage')?> 1 / 1</p>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <div class="xWPageBank btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ -->
                  <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
                  <button onclick="JSvBankClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                      <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
                  </button>
                  <?php if(isset($aAudDataList['raItems'])){ for($i=max($nPage-2, 1); $i<=max(0, min($aAudDataList['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ -->
                      <?php
                          if($nPage == $i){
                              $tActive = 'active';
                              $tDisPageNumber = 'disabled';
                          }else{
                              $tActive = '';
                              $tDisPageNumber = '';
                          }
                      ?>
                      <button onclick="JSvBankClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                  <?php }  } ?>
                  <?php if(isset($aAudDataList['raItems'])){ if($nPage >= $aAudDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } } ?>
                  <button onclick="JSvBankClickPage('next')" class="btn btn-white btn-sm" <?php if(isset($aAudDataList['raItems'])){ echo $tDisabledRight;  } ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                      <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
                  </button>
              </div>
          </div>
        </div>
      </div>
    <?php } ?>
</div>
