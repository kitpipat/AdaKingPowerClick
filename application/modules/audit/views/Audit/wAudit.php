<style>
.wrapper {
  width: 330px;
  font-family: 'Helvetica';
  font-size: 14px;
}
.StepProgress {
  position: relative;
  padding-left: 45px;
  list-style: none;
}
.StepProgress::before {
  display: inline-block;
  content: '';
  position: absolute;
  top: 0;
  left: 15px;
  width: 10px;
  height: 100%;
  border-left: 2px solid #CCC;
}
.StepProgress-item {
  position: relative;
  counter-increment: list;
}
.StepProgress-item:not(:last-child) {
  padding-bottom: 200px;
}
.StepProgress-item::before {
  display: inline-block;
  content: '';
  position: absolute;
  left: -30px;
  height: 100%;
  width: 10px;
}
.StepProgress-item::after {
  content: '';
  display: inline-block;
  position: absolute;
  top: 0;
  left: -35px;
  width: 12px;
  height: 12px;
  border: 2px solid #CCC;
  border-radius: 50%;
  background-color: #FFF;
}
.StepProgress-item.is-done::before {
  border-left: 2px solid black;
}
.StepProgress-item.is-done::after {
  font-size: 10px;
  color: #0000;
  text-align: center;
  border: 2px solid black;
  background-color: black;
}
.StepProgress-item.current::before {
  border-left: 2px solid black;
}
.StepProgress-item.current::after {
  content: counter(list);
  padding-top: 50px;
  width: 19px;
  height: 18px;
  top: -4px;
  left: -40px;
  font-size: 14px;
  text-align: center;
  color: green;
  border: 2px solid green;
  background-color: white;
}
.StepProgress strong {
  display: block;
}
.xCNPromotionCircle.active .xCNPromotionPopupSpan {
    font-weight: 900;
}
<style>
.xCNPromotionCircle .xCNPromotionPopupSpan {
    width: auto;
    height: auto;
    padding: 10px;
    white-space: nowrap;
    color: #1d2530;
    position: absolute;
    top: -36px;
    left: -10px;
    transition: all 0.1s ease-out;
}
</style>
<div id="odvAuditMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNDepositVMaster">
                <div class="col-xs-12 col-md-6">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <li style="cursor:pointer;" onclick="JSxAddfavorit('deposit/0/0')"><img id="oimImgFavicon" style="cursor:pointer; margin-top: -10px;" width="20px;" height="20px;" src="<?php echo base_url();?>application/modules/common/assets/images/icons/favorit.PNG" class="xCNDisabled xWImgDisable"></li>
                        <li id="oliAuditTitle" class="xCNLinkClick" onclick="JSxAuditDefult()"><?= language('audit/audit/audit','tAUDTitle')?></li>
                        <li id="oliAuditTitleAdd" class="active"><a><?= language('audit/audit/audit','tAUDTitleAdd')?></a></li>
                        <li id="oliAuditTitleEdit" class="active"><a><?= language('audit/audit/audit','tAUDTitleEdit')?></a></li>
                        <input type="hidden" id="oetSesUsrLevel" value="<?php echo $this->session->userdata('tSesUsrLevel'); ?>">
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <?php if ($this->session->userdata('tSesUsrLevel') != "HQ") { ?>
                          <button class="btn xCNBTNDefult xCNBTNDefult2Btn" id="obtAUDUpdate" onclick="JSwAuditAdd('edit')" type="button"><?= language('audit/audit/audit','tAUDTitleEdit')?></button>
                          <button class="btn xCNBTNDefult xCNBTNDefult2Btn" id="obtAUDback" onclick="JSxAuditDefult();"  type="button"><?= language('audit/audit/audit','tAUDTitleBack')?></button>
                          <button class="btn xWBtnGrpSaveLeft xCNBTNPrimery" id="obtAUDSave" onclick="JSxAudutSave();" type="button"><?= language('audit/audit/audit','tAUDTitleSave')?></button>
                        <?php } ?>
                        <?php if ($this->session->userdata('tSesUsrLevel')=="HQ") { ?>
                          <button class="xCNBTNPrimeryPlus" id="obtAUDCreate" onclick="JSwAuditAdd('add')" type="button">+</button>
                          <button class="btn xCNBTNDefult xCNBTNDefult2Btn" id="obtAUDback" onclick="JSxAuditDefult();" type="button"><?= language('audit/audit/audit','tAUDTitleBack')?></button>
                          <button class="btn xWBtnGrpSaveLeft xCNBTNPrimery" id="obtAUDSave" onclick="JSxAudutSave();" type="button"><?= language('audit/audit/audit','tAUDTitleSave')?></button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="main-content">
  <div id="odvAUDContentPage">
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
                    <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetAUDSearchAll" name="oetAUDSearchAll" value="" placeholder="กรอกคำค้นหา">
                    <span class="input-group-btn">
                      <button class="btn xCNBtnSearch" type="button" onclick="JSvAUDSearchDataTable()">
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
                  <table class="table table-striped" id="otbAUDDataTable">
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
                          <td><input type="hidden" name="oetRtRowID[]"/><?php echo $aValue['FTAgnNameFrm']; ?></td>
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
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="odvAUDNumrow">
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
                          <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
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
  </div>
</div>
<script type="text/javascript">

  $('document').ready(function(){
      $("#oliAuditTitleAdd").hide();
      $("#oliAuditTitleEdit").hide();
      $("#obtAUDback").hide();
      $("#obtAUDSave").hide();
      JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/

  });
  $("#oetAUDSearchAll").on("keyup", function() {

  });
  function JSvAUDSearchDataTable() {
    if ($("#oetAUDSearchAll").val()!="") {
      $.ajax({
          type: "POST",
          url: "AuditDataList",
          data : {tSearchAll:$("#oetAUDSearchAll").val()},
          cache: false,
          timeout: 0,
          success: function(wResult){
              $("#odvAUDContentPage").html(wResult);
          },
          error: function(jqXHR, textStatus, errorThrown) {
              JCNxResponseError(jqXHR, textStatus, errorThrown);
          }
      });
    }
  }
  function JSnAuditEdit(ptFTAgnFrm,ptFTAgnTo) {
    $("#oliAuditTitleAdd").hide();
    $("#oliAuditTitleEdit").show();
    $("#obtAUDCreate").hide();
    $("#obtAUDback").show();
    $("#obtAUDSave").show();
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "AuditPageEdit",
        data : {tFTAgnFrm:ptFTAgnFrm,tFTAgnTo:ptFTAgnTo},
        cache: false,
        timeout: 0,
        success: function(wResult){
            $("#odvAUDContentPage").html(wResult);
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
            JCNxCloseLoading();
        }
    });
  }
  function JSnAuditDel(ptFTAgnFrm,ptFTAgnTo) {
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "AuditDelete",
        data : {tFTAgnFrm:ptFTAgnFrm,tFTAgnTo:ptFTAgnTo},
        cache: false,
        timeout: 0,
        success: function(wResult){
            JCNxCloseLoading();
            JSxAuditDefult();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

  }
  function JSwAuditAdd(ptType) {
    JCNxOpenLoading();
    $("#obtAUDUpdate").hide();
    $("#obtAUDCreate").hide();
    $("#obtAUDback").show();
    $("#obtAUDSave").show();
    if (ptType == "edit") {
      $("#oliAuditTitleEdit").show();
      $("#oliAuditTitleAdd").hide();
    }else {
      $("#oliAuditTitleAdd").show();
      $("#oliAuditTitleEdit").hide();
    }
    if (ptType=="edit") {
      JSnAuditEdit($("#oetAudCode").val(),"0");
    }else {

      $.ajax({
          type: "POST",
          url: "AuditPageAdd",
          data : {tFTAgnFrm:"",tFTAgnTo:"1"},
          cache: false,
          timeout: 0,
          success: function(wResult){
              $("#odvAUDContentPage").html(wResult);
              JCNxCloseLoading();
          },
          error: function(jqXHR, textStatus, errorThrown) {
              JCNxResponseError(jqXHR, textStatus, errorThrown);
          }
      });
    }

  }

  function JSxAudutSave() {
    JCNxOpenLoading();
    if ($("#oetAudCode").val()=="") {
      FSvCMNSetMsgWarningDialog('กรุณาเลือก บัญชีต้นทาง');
      JCNxCloseLoading();
    }else if ($("#oetAudCodeT").val()=="") {
      FSvCMNSetMsgWarningDialog('กรุณาเลือก บัญชีปลายทาง');
      JCNxCloseLoading();
    }else {
      $.ajax({
          type: "POST",
          url: "AuditEventAdd",
          data :{tAudCode:$("#oetAudCode").val(),tAudCodeT:$("#oetAudCodeT").val()},
          cache: false,
          timeout: 0,
          success: function(aResult){
              var aObj = JSON.parse(aResult);
              if (aObj['rtCode']=='Add') {
                JSnAuditEdit(aObj['rtFTAgnFrm'],aObj['rtFTAgnTo']);
              }else if (aObj['rtCode']=='update') {
                JSnAuditEdit(aObj['rtFTAgnFrm'],aObj['rtFTAgnTo']);
              }else {
                alert(aObj['tStaMessg']);
              }
              //JSxAuditDefult();
              JCNxCloseLoading();
          },
          error: function(jqXHR, textStatus, errorThrown) {
              JCNxResponseError(jqXHR, textStatus, errorThrown);
              JCNxCloseLoading();
          }
      });
    }
  }
  function JSxAuditDefult() {

    $.ajax({
        type: "POST",
        url: "AuditDataList",
        cache: false,
        timeout: 0,
        success: function(wResult){
            $("#odvAUDContentPage").html(wResult);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
    if ($("#oetSesUsrLevel").val()=="HQ") {
      $("#obtAUDCreate").show();
    }else {
      $("#obtAUDUpdate").show();
    }

    $("#oliAuditTitleAdd").hide();
    $("#oliAuditTitleEdit").hide();
    $("#obtAUDback").hide();
    $("#obtAUDSave").hide();
  }
</script>
