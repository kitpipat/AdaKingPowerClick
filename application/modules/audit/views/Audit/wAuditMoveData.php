<style media="screen">
.datepicker {
   z-index:1190 !important;
}
</style>
<?php if ($tStatus==false): ?>
  <div id="odvDepositMainMenu" class="main-menu">
    <input type="hidden" name="" id="oetAudtStatus"  value="<?php echo $tStatus; ?>">
      <div class="xCNMrgNavMenu">
          <div class="row xCNavRow" style="width:inherit;">
              <div class="xCNDepositVMaster">
                  <div class="col-xs-12 col-md-6">
                      <ol id="oliMenuNav" class="breadcrumb">
                          <li style="cursor:pointer;" onclick="JSxAddfavorit('deposit/0/0')"><img id="oimImgFavicon" style="cursor:pointer; margin-top: -10px;" width="20px;" height="20px;" src="application/modules/common/assets/images/icons/favorit.PNG" class="xCNDisabled xWImgDisable"></li>
                          <li id="oliDepositTitle" class="xCNLinkClick"><?= language('audit/audit/audit','tAUDTitleMove')?></li>
                          <li id="oliDepositTitleAdd" class="active" style="display: none;"><a><?= language('audit/audit/audit','tAUDTitleCreate')?></a></li>
                          <li id="oliDepositTitleEdit" class="active" style="display: none;"><a><?= language('audit/audit/audit','tAUDTitleEdit')?></a></li>
                          <li id="oliDepositTitleDetail" class="active" style="display: none;"><a><?= language('audit/audit/audit','tAUDTitleDetail')?></a></li>
                      </ol>
                  </div>
                  <div class="col-xs-12 col-md-6 text-right p-r-0">
                      <div class="demo-button xCNBtngroup" style="width:100%;">
                        <?php if ($tStatus==true) { ?>
                            <button class="btn xCNBTNPrimery" id="obtAUDSave" type="button"><?= language('audit/audit/audit','tAUDTitleConfirm')?></button>
                        <?php } ?>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="main-content">
    <div id="odvDepositContentPage">
      <div class="panel panel-headline">
        <div class="panel-heading">
          <div class="row">
              <div class="col-xs-12 col-md-4 col-lg-4">
                <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                  <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDSelectCF')?> : </label>
                  <div class="input-group">
                    <input type="text" class="form-control xCNHide" id="oetAudCodeF" value="" name="oetAudCode" value="">
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-md-4 col-lg-4" >
                <div class="form-group">
                <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDSelectCT')?> : </label>
                 <input type="text" class="form-control xCNHide" id="oetAudCodeT" value="" name="oetAudCode" value="">
                </div>
              </div>
          </div>
          <div class="row"> <!-- เพิ่ม -->
            <div class="col-xs-12 col-md-4 col-lg-4">
              <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDTitleSearch')?></label>
                <div class="input-group">
                  <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAll" name="oetSearchAll" onkeyup="Javascript:if(event.keyCode==13) JSvBranchDataTable()" value="" placeholder="">
                  <span class="input-group-btn">
                    <button class="btn xCNBtnSearch" type="button" onclick="JSvBranchDataTable()">
                      <img class="xCNIconAddOn" src="<?php echo base_url();?>/application/modules/common/assets/images/icons/search-24.png">
                    </button>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-md-4 col-lg-4">
              <div class="form-group"  id="odvAUDDivdate">
                  <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDTitleDocDateSelect')?></label>
                  <div class="input-group">
                      <input id="oetAUDMoveDate" type="text" class="form-control xCNDatePicker xCNInputMaskDate text-center"
                      value="" maxlength="10">
                      <span class="input-group-btn">
                          <button  type="button" id="obtAUDBtnDate" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                      </span>
                  </div>
              </div>
            </div>
            <div class="col-xs-12 col-md-4 col-lg-4 text-right" style="margin-top:34px;">
              <label class="fancy-checkbox">
                <input class="" type="checkbox" id="ocbAUDCheckAfter" name="ocbAUDCheckAfter" >
                <span class="xCNLabelFrm"><label class="form-check-label" for="exampleCheck1"><?= language('audit/audit/audit','tAUDTitleTranferDataAgo')?></label></span>
              </label>
            </div>
          </div>
        </div>
      	<div class="panel-body">
          <section id="ostDataBranch">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th nowrap="" class="xCNTextBold" style="width:5%;text-align:center;">
                          <label class="fancy-checkbox">
                            <input class="" type="checkbox" id="ocbAUDCheckAll" name="ocbAUDCheckAll" >
                            <span class="xCNLabelFrm"></span>
                          </label>
                        </th>
            						<th nowrap="" class="xCNTextBold" style="width:85%;text-align:center;"><?= language('audit/audit/audit','tAUDTitleListTranfer')?></th>
            						<th nowrap="" class="xCNTextBold" style="width:10%;text-align:center;"><?= language('audit/audit/audit','tAUDTitleDateTranfer')?></th>
                      </tr>
                    </thead>
                    <tbody id="odvRGPList">
                    </tbody>
            			 </table>
                </div>
              </div>
            </div>
          </section>
      	</div>
      </div>
    </div>
  </div>
<?php endif; ?>
<?php if ($tStatus==true): ?>
<div id="odvDepositMainMenu" class="main-menu">
  <input type="hidden" name="" id="oetAudtStatus"  value="<?php echo $tStatus; ?>">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNDepositVMaster">
                <div class="col-xs-12 col-md-6">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <li style="cursor:pointer;" onclick="JSxAddfavorit('deposit/0/0')"><img id="oimImgFavicon" style="cursor:pointer; margin-top: -10px;" width="20px;" height="20px;" src="application/modules/common/assets/images/icons/favorit.PNG" class="xCNDisabled xWImgDisable"></li>
                        <li id="oliDepositTitle" class="xCNLinkClick"><?= language('audit/audit/audit','tAUDTitleMove')?></li>
                        <li id="oliDepositTitleAdd" class="active" style="display: none;"><a><?= language('audit/audit/audit','tAUDTitleCreate')?></a></li>
                        <li id="oliDepositTitleEdit" class="active" style="display: none;"><a><?= language('audit/audit/audit','tAUDTitleEdit')?></a></li>
                        <li id="oliDepositTitleDetail" class="active" style="display: none;"><a><?= language('audit/audit/audit','tAUDTitleDetail')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                      <?php if ($tStatus==true) { ?>
                          <button class="btn xCNBTNPrimery" id="obtAUDSave" type="button"><?= language('audit/audit/audit','tAUDTitleConfirm')?></button>
                      <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="main-content">
  <div id="odvDepositContentPage">
    <div class="panel panel-headline">
      <div class="panel-heading">
        <div class="row"> <!-- เพิ่ม -->
          <?php if ($this->session->userdata('tSesUsrLevel') != "HQ") { ?>
            <div class="col-xs-12 col-md-4 col-lg-4">
              <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDSelectCF')?> : <?php echo $aData[0]["FTAgnNameFrm"]; ?></label>
                <div class="input-group">
                  <input type="text" class="form-control xCNHide" id="oetAudCodeF" value="<?php echo $aData[0]['FTAgnFrm']; ?>" name="oetAudCode" value="">
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-md-4 col-lg-4" >
              <div class="form-group">
              <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDSelectCT')?> : <?php echo $aData[0]["FTAgnNameTo"]; ?></label>
               <input type="text" class="form-control xCNHide" id="oetAudCodeT" value="<?php echo $aData[0]['FTAgnTo']; ?>" name="oetAudCode" value="">
              </div>
            </div>
          <?php }else{ ?>
            <div class="col-xs-12 col-md-4 col-lg-4">
              <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDSelectCF')?></label>
                <div class="input-group">
                  <input type="text" class="form-control xCNHide" id="oetAudCodeF" name="oetAudCodeF" value="" onchange="JSaAUDChangCompany(this.value);">
                  <input type="text" class="form-control xWPointerEventNone" id="oetAudNameF" name="oetAudNameF" value="" readonly="" placeholder="<?= language('audit/audit/audit','tAUDSelectCF')?>">
                  <span class="input-group-btn">
                    <button id="oimAUDBrowseF" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-md-4 col-lg-4">
              <div class="form-group">
              <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDSelectCT')?></label>
               <input type="text" class="form-control xCNHide" id="oetAudCodeT" name="oetAudCodeT" value="">
               <input type="text" class="form-control " id="oetAudNameT" name="oetAudNameT" value="" readonly="" placeholder="<?= language('audit/audit/audit','tAUDSelectCT')?>">
              </div>
            </div>
          <?php } ?>
        </div>
        <div class="row">
          <div class="col-xs-12 col-md-4 col-lg-4">
            <div class="form-group">
                <label class="xCNLabelFrm">เลือกสาขา</label>
                <select class="selectpicker form-control" id="obtAUDSelectBch">
                  <option value="">--select--</option>
                  <?php
                      if (isset($aDataBch) && count($aDataBch)>0 ) {
                        foreach ($aDataBch as $nKey => $aValue) {
                          echo "<option value='".$aValue['FTBchCode']."'>".$aValue['FTBchName']."</option>";
                        }
                      }
                   ?>
                </select>
            </div>
          </div>
        </div>
        <div class="row"> <!-- เพิ่ม -->
          <div class="col-xs-12 col-md-4 col-lg-4">
            <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
              <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDTitleSearch')?></label>
              <div class="input-group">
                <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAll" name="oetSearchAll" onkeyup="Javascript:if(event.keyCode==13) JSvBranchDataTable()" value="" placeholder="">
                <span class="input-group-btn">
                  <button class="btn xCNBtnSearch" type="button" onclick="JSvBranchDataTable()">
                    <img class="xCNIconAddOn" src="<?php echo base_url();?>/application/modules/common/assets/images/icons/search-24.png">
                  </button>
                </span>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-md-4 col-lg-4">
            <div class="form-group"  id="odvAUDDivdate">
                <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDTitleDocDateSelect')?></label>
                <div class="input-group">
                    <input id="oetAUDMoveDate" type="text" class="form-control xCNDatePicker xCNInputMaskDate text-center"
                    value="" maxlength="10">
                    <span class="input-group-btn">
                        <button  type="button" id="obtAUDBtnDate" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                    </span>
                </div>
            </div>
          </div>
          <div class="col-xs-12 col-md-4 col-lg-4 text-right"  style="margin-top:34px;">
            <label class="fancy-checkbox">
              <input class="" type="checkbox" id="ocbAUDCheckAfter" name="ocbAUDCheckAfter" >
              <span class="xCNLabelFrm"><label class="form-check-label" for="exampleCheck1"><?= language('audit/audit/audit','tAUDTitleTranferDataAgo')?></label></span>
            </label>
          </div>
        </div>
      </div>
    	<div class="panel-body">
        <section id="ostDataBranch">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th nowrap="" class="xCNTextBold" style="width:5%;text-align:center;">
                        <label class="fancy-checkbox">
                          <input class="" type="checkbox" id="ocbAUDCheckAll" name="ocbAUDCheckAll" >
                          <span class="xCNLabelFrm"></span>
                        </label>
                      </th>
          						<th nowrap="" class="xCNTextBold" style="width:45%;text-align:center;"><?= language('audit/audit/audit','tAUDTitleListTranfer')?></th>
                      <th nowrap="" class="xCNTextBold" style="width:40%;text-align:center;">ประมวลผล</th>
          						<th nowrap="" class="xCNTextBold" style="width:10%;text-align:center;"><?= language('audit/audit/audit','tAUDTitleDateTranfer')?></th>
                    </tr>
                  </thead>
                  <tbody id="odvRGPList">
                  </tbody>
          			 </table>
              </div>
            </div>
          </div>
        </section>
    	</div>
    </div>
  </div>
</div>
<?php endif; ?>
<div class="modal fade" id="odvModalDelAre">
	<div class="modal-dialog">
		<div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalWarning')?></label>
            </div>
            <div class="modal-body">
                <span id="ospConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ohdConfirmIDDelete">
            </div>
			<div class="modal-footer">
				<!-- แก้ -->

				<!-- แก้ -->
				<button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel')?>
				</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
  $('document').ready(function(){
      $("#odvAUDDivdate").hide();
      $("#obtAUDSelectBch").selectpicker();
      $('.xCNDatePicker').datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
          todayHighlight: true,
          stopDate: new Date(),
      });
      JSxCheckPinMenuClose();
      var tStatus = $("#oetAudtStatus").val();
      if (tStatus==false) {
        //$("#odvModalDelAre").modal("show");
        $('.xWBtnOK').html("ตั้งค่าการเชื่อมต่อบัญชี");
        FSvCMNSetMsgWarningDialog('ไม่พบการตั้งค่าการเชื่อมต่อบัญชี');
      }else {
        $("#obtAUDSave").hide();
        if ($("#oetAudCodeF").val()!="" && $("#oetAudCodeT").val()!="") {
          JSaAUDGetTranferMaster($("#oetAudCodeF").val());
          $("#obtAUDSave").show();
        }
        $("#oetSearchAll").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#odvRGPList tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });
      }
  });
  $("#ocbAUDCheckAfter").click(function () {
    $("#oetAUDMoveDate").val("");
    if ($(this).prop("checked")==true) {
      $("#odvAUDDivdate").show();
    }else {
      $("#odvAUDDivdate").hide();
    }
  })
  $('#obtAUDBtnDate').click(function() {
      $("#oetAUDMoveDate").datepicker('show');
  });

  $('.xWBtnOK').click(function () {
    $.ajax({
        type: "GET",
        url: "Audit",
        data: {},
        cache: false,
        timeout: 5000,
        success: function(wResult) {
          $('.main').html(wResult);
            //$("#odvDepositContentPage").html(tResult);
            //JSxDepositNavDefult();
            //JSvDepositCallPageDataTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
  })
  $("#ocbAUDCheckAll").click(function () {
    var bStatus = $(this).prop("checked");
    if (bStatus == true) {
      $('.xWItems').prop("checked",true);
    }else {
      $('.xWItems').prop("checked",false);
    }
  })
  $('.xWItems').click(function () {
    $("#ocbAUDCheckAll").prop("checked",false);
  })
  var oAudBrowsePplF = {
      Title : ['audit/audit/audit', 'tAUDTitle'],
      Table:{Master:'VCN_AgenCyAuditLic', PK:'FTAgnCode'},
      Where :{
           Condition : ["AND VCN_AgenCyAuditLic.FNAgnType = '1'"]
      },
      GrideView:{
          ColumnPathLang	: 'audit/audit/audit',
          ColumnKeyLang	: ['tFTAgnCode', 'tFTAgnName'],
          ColumnsSize     : ['15%', '85%'],
          WidthModal      : 50,
          DataColumns		: ['VCN_AgenCyAuditLic.FTAgnCode', 'VCN_AgenCyAuditLic.FTAgnName'],
          DataColumnsFormat : ['', ''],
          Perpage			: 10,
          OrderBy			: ['VCN_AgenCyAuditLic.FTAgnCode DESC'],
      },
      CallBack:{
          ReturnType	: 'S', //S singel //m multi
          Value		: ["oetAudCodeF", "VCN_AgenCyAuditLic.FTAgnCode"],
          Text		: ["oetAudNameF", "VCN_AgenCyAuditLic.FTAgnName"]
      },
      NextFunc:{
          FuncName:'JSaAUDGetBchFrm',
          ArgReturn:['FTAgnCode']
      },
  };
  function JSaAUDGetBchFrm(paData) {
    var tAgnRefCode = "";
    if (typeof(paData) != 'undefined' && paData != "NULL") {
      var aDataNextFunc = JSON.parse(paData);
      tAgnCode = aDataNextFunc[0];
      $.ajax({
          type: "POST",
          url: "AuditGetBch",
          data:{tAgnCode:tAgnCode},
          cache: false,
          timeout: 0,
          success: function(oResult){
            var aResult =  JSON.parse(oResult);
            var tText = "";
            for (var i = 0; i < aResult['aDataBchCode'].length; i++) {
              if (i==0) {
                  tText+="<option selected value='"+aResult['aDataBchCode'][i]['FTBchCode']+"'>"+aResult['aDataBchCode'][i]['FTBchName']+"</option>";
              }else {
                  tText+="<option value='"+aResult['aDataBchCode'][i]['FTBchCode']+"'>"+aResult['aDataBchCode'][i]['FTBchName']+"</option>";
              }

            }

            $("#obtAUDSelectBch").append(tText);
            $("#obtAUDSelectBch").selectpicker("refresh");

          },
          error: function(jqXHR, textStatus, errorThrown) {
              JCNxResponseError(jqXHR, textStatus, errorThrown);
              JCNxCloseLoading();
          }
      });
    }
  }
  $('#oimAUDBrowseF').click(function(){
      JSxCheckPinMenuClose();
      JCNxBrowseData('oAudBrowsePplF');
  });
  function JSaAUDChangCompany(ptFTAgnTo) {
    $.ajax({
        type: "POST",
        url: "AuditSearchComB",
        data:{tFTAgnTo:ptFTAgnTo},
        cache: false,
        timeout: 0,
        success: function(oResult){
            var aResult =  JSON.parse(oResult);
            $("#odvRGPList").html("");
            if (aResult['aData'].length > 0) {
              $("#obtAUDSave").show();
              $("#oetAudCodeT").val(aResult['aData'][0]['FTAgnTo']);
              $("#oetAudNameT").val(aResult['aData'][0]['FTAgnNameTo']);
              JSaAUDGetTranferMaster(ptFTAgnTo);
            }else {
              $("#obtAUDSave").hide();
              $("#oetAudCodeT").val("");
              $("#oetAudNameT").val("");
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
            JCNxCloseLoading();
        }
    });
  }


  function JSaAUDGetTranferMaster(ptFTAgn) {
    $.ajax({
        type: "POST",
        url: "AuditGetTranferMaster",
        data:{tFTAgnTo:ptFTAgn},
        cache: false,
        timeout: 0,
        success: function(tResult){
            var aResult =  JSON.parse(tResult);
            var tRow = "";
            for (var i = 0; i < aResult['aTranferMaster'].length; i++) {
              tRow+="<tr>";
              tRow+="<td class='text-center'>";
              tRow+="<label class='fancy-checkbox'>";
              tRow+="<input class='xWItems' type='checkbox' name='ocbAUDCheck[]'  id='ocbAUDCheck"+i+"'><span class='xCNLabelFrm'></span>";
              tRow+="<input  type='hidden' value='"+aResult['aTranferMaster'][i]['FTSynTable']+"'   id='ocbAUDTable"+i+"' name='ocbAUDTable[]'>";
              tRow+="<input  type='hidden' value='"+aResult['aTranferMaster'][i]['FDSynLast']+"'    id='ocbAUDLast"+i+"'  name='ocbAUDLast[]'>";
              tRow+="</label></td>";
              tRow+="<td>"+aResult['aTranferMaster'][i]['FTSynName']+"</td>";
              tRow+="<td class='text-center' id='otdAUD"+aResult['aTranferMaster'][i]['FTSynTable']+"'></td>";
              if (aResult['aTranferMaster'][i]['FDSynLast']==null) {
                tRow+="<td></td>";
              }else {
                tRow+="<td>"+aResult['aTranferMaster'][i]['FDSynLast']+"</td>";
              }

              tRow+="</tr>";
            }
            $("#odvRGPList").html(tRow);

            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
            JCNxCloseLoading();
        }
    });
  }
  $("#obtAUDSave").click(function () {
    var aData = [];
    var tLast = $("#oetAUDMoveDate").val();
    aData['ptData'] = [];
    var tStaSyn = 1;
    if ($("#ocbAUDCheckAfter").prop("checked")==true) {
      tStaSyn = 2;
    }else {
      tStaSyn = 1;
    }
    var nlen = $('input[name="ocbAUDCheck[]"]').valueOf().length;
    for (var i = 0; i < nlen; i++) {
      if ($("#ocbAUDCheck"+i+"").prop("checked")==true) {
        var tTable = $("#ocbAUDTable"+i+"").val();

        // if ($("#ocbAUDLast"+i+"").val() == null || $("#ocbAUDLast"+i+"").val() == "" || $("#ocbAUDLast"+i+"").val() == "null") {
        //     tLast = null;
        // }else {
        //     tLast = $("#ocbAUDLast"+i+"").val();
        // }
        aData['ptData'].push( {
            ptAgnCodeFrm:$("#oetAudCodeF").val(),
            ptAgnCodeTo:$("#oetAudCodeT").val(),
            ptBchCodeFrm:$("#obtAUDSelectBch").val(),
            ptSynTable:tTable,
            ptStaSyn:tStaSyn,
            pdSynLast:tLast
          }
        );
      }
    }
    if ($("#ocbAUDCheckAfter").prop("checked") == true && $("#oetAUDMoveDate").val() =="") {
      FSvCMNSetMsgErrorDialog('เลือกวันที่');
    }else if ($("#obtAUDSelectBch").val()=="") {
      FSvCMNSetMsgErrorDialog('ยังไม่ได้เลือกสาขา');
    }else if (aData['ptData'].length >0) {
      var aResult =  aData['ptData'];
      JSaAUDGetMoverMaster(aResult);
    }else {
      FSvCMNSetMsgErrorDialog('ยังไม่ได้เลือกรายการ');
    }

  })
  function JSaAUDGetMoverMaster(paData) {
    $.ajax({
        type: "POST",
        url: "AuditGetMoverMaster",
        data:{aData:paData},
        cache: false,
        timeout: 0,
        success: function(tResult){
          //$('#odvModalInfoMessage').modal('show');
          JSoADCCallSubscribeMQ();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
            JCNxCloseLoading();
        }
    });
  }

  // Functionality : Call Data Subscript Document
  // Parameters : Event Click Buttom
  // Creator : 30/03/2564
  // LastUpdate: -
  // Return : Status Applove Document
  // Return Type : -
  function JSoADCCallSubscribeMQ() {
      // RabbitMQ
      /*===========================================================================*/
      // Document variable

      var tPrefix = "RESAUDIT";
      var tQName = tPrefix + "_" + $("#oetAudCodeF").val() + "_" + '<?php echo $this->session->userdata('tSesSessionID'); ?>';

      // MQ Message Config
      var poDocConfig = {
          tVhostType:"A",
          tProgress:"Bar",
          tPrefix: tPrefix,
          tQName: tQName
      };

      // RabbitMQ STOMP Config
      var poMqConfig = {
          host: "ws://" + oSTOMMQConfig.host + ":15672/ws",
          username: oSTOMMQConfig.user,
          password: oSTOMMQConfig.password,
          vHost: "AdaPos5.0Audit_PosDev"
      };

      // Update Status For Delete Qname Parameter
      //auto delete = default
      var poUpdateStaDelQnameParams = "";

      // Callback Page Control(function)
      var poCallback ="";

      // Check Show Progress %
      FSxCMNRabbitMQMessage(poDocConfig, poMqConfig, poUpdateStaDelQnameParams, poCallback);


  }
  function JSvCallPageSpaEdit() {
    FSvCMNSetMsgSucessDialog('Success');
    JSaAUDChangCompany($("#oetAudCodeF").val());
  }

</script>
