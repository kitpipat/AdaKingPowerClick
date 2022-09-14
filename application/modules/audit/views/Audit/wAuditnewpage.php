<style type="text/css">
.my-custom-scrollbar {
  position: relative;
  height: 400px;
  overflow: auto;
}
.table-wrapper-scroll-y {
  display: block;
}
.tableFixHead thead th {
  position: sticky; top: 0;
  background-color: #FFF;
 }
</style>

<div id="odvAuditMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNDepositVMaster">
                <div class="col-xs-12 col-md-6">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <li style="cursor:pointer;" onclick="JSxAddfavorit('deposit/0/0')"><img id="oimImgFavicon" style="cursor:pointer; margin-top: -10px;" width="20px;" height="20px;" src="application/modules/common/assets/images/icons/favorit.PNG" class="xCNDisabled xWImgDisable"></li>
                        <li id="oliAuditTitle" class="xCNLinkClick" onclick="JSvDepositCallPageList()"><?= language('audit/audit/audit','tAUDTitleCreateDoc')?></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                      <div class="demo-button xCNBtngroup" style="width:100%;">
                        <a data-mnrname="Audit_newpage"><button class="btn xCNBTNDefult xCNBTNDefult2Btn" id="obtAUDback"  type="button">ยกเลิก</button></a>
                        <button class="btn xWBtnGrpSaveLeft xCNBTNPrimery" id="obtAUDSave" onclick="JSxAudutSave();" type="button">โอนข้อมูล</button>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="main-content" id="odvMainContent" style="background-color: #F0F4F7;">
	<div>
    <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
      <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?= language('audit/audit/audit','tAUDTitleDo')?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvAUDDataStatusInfo" aria-expanded="false">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvAUDDataStatusInfo" class="panel-collapse in" role="tabpanel" aria-expanded="true" >
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                  <label class="fancy-radio xCNRadioMain">
                                    <input type="radio" id="orbAUDConSaveData" name="orbAUDSaveDel" checked>
                                    <span><i></i><?= language('audit/audit/audit','tAUDTitleUNDele')?></span>
                                  </label>
                                </div>
                                <div class="form-group">
                                  <label class="fancy-radio xCNRadioMain">
                                    <input type="radio" id="orbAUDConDelData" name="orbAUDSaveDel">
                                    <span><i></i><?= language('audit/audit/audit','tAUDTitleDele')?></span>
                                  </label>
                                </div>
                              </div>
                        </div>
                        <div class="row">
                            <hr>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                              <div class="form-group">
                                <label class="fancy-radio xCNRadioMain">
                                  <input type="radio" id="orbAUDConition0" name="orbAUDConition" >
                                  <span><i></i>เลือกทั้งหมด</span>
                                </label>
                              </div>
                                <div class="form-group">
                                  <label class="fancy-radio xCNRadioMain">
                                    <input type="radio" id="orbAUDConition1" name="orbAUDConition" checked>
                                    <span><i></i>เฉพาะเอกสารที่เลือก</span>
                                  </label>
                                </div>
                                <div class="form-group">
                                  <label class="fancy-radio xCNRadioMain">
                                    <input type="radio" id="orbAUDConition2" name="orbAUDConition">
                                    <span><i></i>ยกเว้นเอกสารที่เลือก</span>
                                  </label>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div  id="odvAUDHeadCondition" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?= language('audit/audit/audit','tAUDTitleRuu')?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvAUDDataConditionDoc" aria-expanded="false">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvAUDDataConditionDoc" class="panel-collapse in" role="tabpanel" aria-expanded="true" >
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                              <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDTitleFrom')?></label>
                                    <select class="selectpicker form-control" name="ocmAUDDocByType" id="ocmAUDDocByType" >
                                      <option value="2"><?= language('audit/audit/audit','tAUDTitleProductname')?></option>
                                      <option value="1"><?= language('audit/audit/audit','tAUDTitleProductcode')?></option>
                                    </select>
                              </div>
                              <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDTitleChar')?></label>
                                    <div class="form-group">
                                      <label class="fancy-radio xCNRadioMain">
                                        <input type="radio" id="orbAUDChar1" name="orbAUDChar">
                                        <span><i></i><?= language('audit/audit/audit','tAUDTitleCharStart')?></span>
                                      </label>
                                    </div>
                                    <div class="form-group">
                                      <label class="fancy-radio xCNRadioMain">
                                        <input type="radio" id="orbAUDChar2" name="orbAUDChar">
                                        <span><i></i><?= language('audit/audit/audit','tAUDTitleCharEnd')?></span>
                                      </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDTitleCharT')?></label>
                                        <input type="text" class="form-control xCNInputWithoutSpc" id="oetAUDCharText" name="oetAUDCharText" maxlength="50" value="">
                                    </div>
                              </div>
                              <hr>
                              <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDTitleCommodityTax')?></label>
                                    <div class="form-group">
                                      <label class="fancy-radio xCNRadioMain">
                                        <input type="radio" id="orbAUDVat1" name="orbAUDVat">
                                        <span><i></i><?= language('audit/audit/audit','tAUDTitleWithtax')?></span>
                                      </label>
                                    </div>
                                    <div class="form-group">
                                      <label class="fancy-radio xCNRadioMain">
                                        <input type="radio" id="orbAUDVat2" name="orbAUDVat">
                                        <span><i></i><?= language('audit/audit/audit','tAUDTitleNotax')?></span>
                                      </label>
                                    </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default" style="margin-bottom:25px;position:relative;min-height:200px;">
                        <div class="panel-collapse in" role="tabpanel" data-grpname="Condition">
                            <div class="panel-body">
                                <div style="margin-top: 10px;">
                                    <div class="row p-t-10">
                                      <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                        <div class="form-group">
                                           <input type="hidden" id="obtAUDAgnFrm" value="<?php echo $tFTAgnFrm; ?>">
                                            <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDTitleDocumentBchF')?></label>
                                            <select class="selectpicker form-control" id="obtAUDDocBchF">
                                              <?php foreach ($aDataBranchF as $nkey => $aValue): ?>
                                                  <option value="<?php echo  $aValue['FTBchCode']; ?>"><?php echo $aValue['FTBchName']; ?></option>
                                              <?php endforeach; ?>
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                        <input type="hidden" id="obtAUDAgnTo"  value="<?php echo $tFTAgnTo; ?>">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDTitleDocumentBchT')?></label>
                                            <select class="selectpicker form-control" id="obtAUDDocBchT">
                                              <?php foreach ($aDataBranchT as $nkey => $aValue): ?>
                                                  <option value="<?php echo  $aValue['FTBchCode']; ?>"><?php echo $aValue['FTBchName']; ?></option>
                                              <?php endforeach; ?>
                                            </select>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row p-t-10">
                                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                          <div class="form-group">
                                              <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDTitleDocDate')?></label>
                                              <div class="input-group">
                                                  <input id="obtAUDDocDateA" type="text" class="form-control xCNDatePicker xCNInputMaskDate text-center"
                                                  value="" maxlength="10">
                                                  <input type="hidden" name="oetAUDDocDateStart" id="oetAUDDocDateStart" value="">
                                                  <span class="input-group-btn">
                                                      <button  type="button" id="obtAUDBtnDateA"  class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                                  </span>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                          <div class="form-group">
                                              <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDTitleUptodateofdoc')?></label>
                                              <div class="input-group">
                                                  <input id="obtAUDDocDateB" type="text" class="form-control xCNDatePicker xCNInputMaskDate text-center"
                                                  value="" maxlength="10">
                                                  <input type="hidden" name="oetAUDDocDateStop" id="oetAUDDocDateStop" value="">
                                                  <span class="input-group-btn">
                                                      <button  type="button" id="obtAUDBtnDateB" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                                  </span>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                          <div class="form-group">
                                              <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDTitleDocumenttype')?></label>
                                              <select class="selectpicker form-control" id="obtAUDDocType">
                                                <option value="1">เอกสารขาย</option>
                                                <option value="9">เอกสารคืน</option>
                                              </select>
                                          </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                          <div class="form-group">
                                            <label class="xCNLabelFrm"><font color="#FFFFFF">.</font></label>
                                            <div class="input-group">
                                            <button type="button" onclick="JSvAUDTListItem();" class="btn btn-primary xCNApvOrCanCelDisabled"><?= language('audit/audit/audit','tAUDTitleUpdatelist')?></button>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                    <!--ตาราง-->
                            <div class="row p-t-10" id="odvTWIDataPdtTableDTTemp">
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="table-responsive">
                                  <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                    <table id="otbAUDDocTableList" class="table xWPdtTableFont tableFixHead">
                                      <thead >
                                       <tr class="xCNCenter">
                                        <th>
                                          <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbAUDCheckAll" name="ocbAUDCheckAll">
                                            <span class="xCNLabelFrm"></span>
                                          </label>

                                        </th>
                                        <th><?= language('audit/audit/audit','tAUDTitleNo')?></th>
                                        <th><?= language('audit/audit/audit','tAUDTitleBranch')?></th>
                                        <th><?= language('audit/audit/audit','tAUDTitleDocumentNo')?></th>
                                        <th><?= language('audit/audit/audit','tAUDTitleUptodateofdoc')?></th>
                                        <th><?= language('audit/audit/audit','tAUDTitleDocbalance')?></th>
                                        <th><?= language('audit/audit/audit','tAUDTitleTaxinvoir')?></th>

                                      </tr>
                                    </thead>
                                      <tbody id="odvAUDListItems">

                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <table class="table">
                          <tr>
                            <td><?= language('audit/audit/audit','tAUDTitleNumberList')?></td>
                            <td id="otdAUDSumSelect" class="text-right">0</td>
                          </tr>
                        </table>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <script type="text/javascript">
              $('document').ready(function(){
                //console.log($("#odvAUDDataStatusInfo").valueOf());
                  JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
                  $("#ocmAUDDocByType").selectpicker();
                  $("#obtAUDDocByType").selectpicker();
                  $("#obtAUDDocType").selectpicker();
                  $("#obtAUDDocBchF").selectpicker();
                  $("#obtAUDDocBchT").selectpicker();
                  $('.xCNDatePicker').datepicker({
                      format: 'yyyy-mm-dd',
                      autoclose: true,
                      todayHighlight: true,
                      stopDate: new Date(),
                  });
                  $("#oetAUDDocDateStart").val("");
                  $("#oetAUDDocDateStop").val("");
              });
              $("#obtAUDback").click(function () {
                $("#odvAUDListItems").html("");
              })

              $('#obtAUDBtnDateA').click(function() {
                  $("#obtAUDDocDateA").datepicker('show');
              });
              $('#obtAUDBtnDateB').click(function() {
                  $("#obtAUDDocDateB").datepicker('show');
              });
              $("#obtAUDDocDateA").change(function () {
                //$("#oetAUDDocDateStart").val($(this).val());
              })
              $("#obtAUDDocDateB").change(function () {
                //$("#oetAUDDocDateStop").val($(this).val());
              })
              function JSvAUDTListItem() {
                var nlen = $('input[name="ocbAUDCheck[]"]').valueOf().length;
                console.log(nlen);
                var aLocale = [];
                 aLocale['tConfirmDelete'] = "กรุณาตรวจสอบ";
                 aLocale['tConfirmDeletionOf']= "หลังจากที่มีการเปลี่ยนเงื่อนไข ข้อมูลจะต้องถูกดึงมาใหม่";
                 aLocale['tBtnConfirm']= "ตกลง";
                 aLocale['tBtnCancel'] = "ยกเลิก";
                 console.log($("#obtAUDDocDateA").val());
                 console.log($("#oetAUDDocDateStart").val());
                 console.log($("#obtAUDDocDateB").val());
                 console.log($("#oetAUDDocDateStop").val());
                 if (($("#obtAUDDocDateA").val() != $("#oetAUDDocDateStart").val()) || ($("#obtAUDDocDateB").val() != $("#oetAUDDocDateStop").val())) {
                   $("#oetAUDDocDateStart").val($("#obtAUDDocDateA").val());
                   $("#oetAUDDocDateStop").val($("#obtAUDDocDateB").val());
                   if (nlen==0) {
                      JSxAUDTListItem();
                   }else {
                     bootbox.confirm({
                         title: aLocale['tConfirmDelete'],
                         message: aLocale['tConfirmDeletionOf'],
                         buttons: {
                             cancel: {
                                 label: aLocale['tBtnConfirm'],
                                 className: 'xCNBTNPrimery'
                             },
                             confirm: {
                                 label: aLocale['tBtnCancel'],
                                 className: 'xCNBTNDefult'
                             }
                         },
                         callback: function (result) {
                             if (result == false) {
                               JSxAUDTListItem();
                             }
                         }
                     });
                   }


                 }else {
                   JSxAUDTListItem();
                 }


              }
              function JSxAUDTListItem() {

                $.ajax({
                    type: "POST",
                    url: "AuditSearchListDoc",
                    data:{
                      tDocDateA:$("#obtAUDDocDateA").val(),
                      tDocDateB:$("#obtAUDDocDateB").val(),
                      tAUDDocType:$("#obtAUDDocType").val(),
                      tDocBchF:$("#obtAUDDocBchF").val(),
                      tDocBchT:$("#obtAUDDocBchT").val()
                    },
                    cache: false,
                    timeout: 0,
                    success: function(tResult){
                        var aResult =  JSON.parse(tResult);
                        var tRow = "";
                        var nNumItem = 0;
                        if (aResult['aData'] !=false) {
                          for (var i = 0; i < aResult['aData'].length; i++) {
                            tRow+="<tr>";
                            if (aResult['aData'][i]['FTXshDocVatFull'] != null) {

                              tRow+="<td class='text-center'>";
                              tRow+="<label class='fancy-checkbox'>";
                              tRow+="<input disabled checked   class='xWItems' type='checkbox' name='ocbAUDCheck[]' onclick='JSxAUDTSelectListItem("+i+");'  id='ocbAUDCheck"+i+"'><span class='xCNLabelFrm'></span>";
                              tRow+="<input  type='hidden' value='"+aResult['aData'][i]['FTXshDocVatFull']+"'   id='ocbAUDFTXshDocVatFull"+i+"' name='ocbAUDFTXshDocVatFull[]'>";
                              tRow+="<input  type='hidden' value='"+aResult['aData'][i]['FTXshDocNo']+"'   id='ocbAUDFTXshDocNo"+i+"' name='ocbAUDFTXshDocNo[]'>";
                              tRow+="</label></td>";
                              nNumItem++;
                            }else {
                              tRow+="<td class='text-center'>";
                              tRow+="<label class='fancy-checkbox'>";
                              tRow+="<input class='xWItems' type='checkbox' name='ocbAUDCheck[]' onclick='JSxAUDTSelectListItem("+i+");'  id='ocbAUDCheck"+i+"'><span class='xCNLabelFrm'></span>";
                              tRow+="<input  type='hidden' value='"+aResult['aData'][i]['FTXshDocVatFull']+"'   id='ocbAUDFTXshDocVatFull"+i+"' name='ocbAUDFTXshDocVatFull[]'>";
                              tRow+="<input  type='hidden' value='"+aResult['aData'][i]['FTXshDocNo']+"'   id='ocbAUDFTXshDocNo"+i+"' name='ocbAUDFTXshDocNo[]'>";
                              tRow+="</label></td>";
                            }

                            var nNumber = 0;
                            tRow+="<td>"+(i+1)+"</td>";
                            tRow+="<td>"+aResult['aData'][i]['FTBchName']+"</td>";
                            tRow+="<td>"+aResult['aData'][i]['FTXshDocNo']+"</td>";
                            tRow+="<td>"+aResult['aData'][i]['FDXshDocDate']+"</td>";
                            tRow+="<td class='text-right'>"+((parseFloat(aResult['aData'][i]['FCXshTotal'])).toFixed(2))+"</td>";
                            if (aResult['aData'][i]['FTXshDocVatFull'] != null) {
                              tRow+="<td>"+aResult['aData'][i]['FTXshDocVatFull']+"</td>";
                            }else {
                              tRow+="<td></td>";
                            }
                            //tRow+="<td  id='otdAUDDoc"+aResult['aData'][i]['FTXshDocNo']+"'></td>";
                            tRow+="</tr>";
                          }
                        }else {
                          tRow = "<tr>";
                          tRow+="<tr><td class='text-center xCNTextDetail2' colspan='7'><?= language('bank/bank/bank','tBnkNoData')?></td></tr>";
                          tRow+="</tr>";
                        }

                        $("#otdAUDSumSelect").html(nNumItem);
                        $("#odvAUDListItems").html(tRow);
                        JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                        JCNxCloseLoading();
                    }
                });
              }
              $("#orbAUDConition0").click(function () {
                var bStatus = $("#ocbAUDCheckAll").prop("checked");
                var nNumItem = 0;
                if (bStatus == false) {
                  var nlen = $('input[name="ocbAUDCheck[]"]').valueOf().length;
                  var nNumItem = 0;
                  for (var i = 0; i < nlen; i++) {
                    if ($("#ocbAUDFTXshDocVatFull"+i+"").val() != "null" ) {
                      $("#ocbAUDCheck"+i+"").prop("checked",true);
                      nNumItem++;
                    }else {
                      $("#ocbAUDCheck"+i+"").prop("checked",false);
                    }
                  }
                }else {
                  var nlen = $('input[name="ocbAUDCheck[]"]').valueOf().length;
                  for (var i = 0; i < nlen; i++) {
                    if ($("#ocbAUDFTXshDocVatFull"+i+"").val() != "null" ) {
                      if (nNumItem < 1000) {
                        $("#ocbAUDCheck"+i+"").prop("checked",true);
                        nNumItem++;
                      }
                    }else {
                      if (nNumItem < 1000) {
                        $("#ocbAUDCheck"+i+"").prop("checked",true);
                        nNumItem++;
                      }
                    }
                  }
                }

                $("#otdAUDSumSelect").html(nNumItem);
              })
              $("#orbAUDConition0").click(function () {
                $("#ocbAUDCheckAll").prop("checked",true);
                $('.xWItems').prop("checked",true);
                $('.xWItems').prop("disabled",true);
              })
              $("#orbAUDConition1").click(function () {
                $("#ocbAUDCheckAll").prop("checked",false);
                $('.xWItems').prop("disabled",false);
              })
              $("#orbAUDConition2").click(function () {
                $("#ocbAUDCheckAll").prop("checked",false);
                $('.xWItems').prop("disabled",false);
              })
              $("#ocbAUDCheckAll").click(function () {
                var bStatus = $(this).prop("checked");
                var nNumItem = 0;
                if (bStatus == false) {
                  $('.xWItems').prop("disabled",false);
                  $("#orbAUDConition1").prop("checked",true);
                  var nlen = $('input[name="ocbAUDCheck[]"]').valueOf().length;
                  var nNumItem = 0;
                  for (var i = 0; i < nlen; i++) {
                    if ($("#ocbAUDFTXshDocVatFull"+i+"").val() != "null" ) {
                      $("#ocbAUDCheck"+i+"").prop("checked",true);
                      nNumItem++;
                    }else {
                      $("#ocbAUDCheck"+i+"").prop("checked",false);
                    }
                  }
                }else {
                  $('.xWItems').prop("disabled",true);
                  $("#orbAUDConition0").prop("checked",true);
                  var nlen = $('input[name="ocbAUDCheck[]"]').valueOf().length;
                  for (var i = 0; i < nlen; i++) {
                    if ($("#ocbAUDFTXshDocVatFull"+i+"").val() != "null" ) {
                      if (nNumItem < 1000) {
                        $("#ocbAUDCheck"+i+"").prop("checked",true);
                        nNumItem++;
                      }
                    }else {
                      if (nNumItem < 1000) {
                        $("#ocbAUDCheck"+i+"").prop("checked",true);
                        nNumItem++;
                      }
                    }
                  }
                }

                $("#otdAUDSumSelect").html(nNumItem);
              })
              function JSxAUDTSelectListItem(pnItemid) {

                var tStatus = $("#ocbAUDCheck"+pnItemid+"").prop("checked");
                var nlen = $('input[name="ocbAUDCheck[]"]').valueOf().length;
                var nNumItem = 0;
                for (var i = 0; i < nlen; i++) {
                  if ($("#ocbAUDCheck"+i+"").prop("checked")==true) {
                    nNumItem++;
                  }
                }
                if (tStatus ==true && nNumItem < 1000) {
                  $("#ocbAUDCheck"+pnItemid+"").prop("checked",true);
                }
                if (tStatus ==false) {
                  $("#ocbAUDCheck"+pnItemid+"").prop("checked",false);
                }

                if (nNumItem > 1000) {
                  $("#otdAUDSumSelect").html("1000");
                }else {
                  $("#otdAUDSumSelect").html(nNumItem);
                }
              }
              function JSxAudutSave() {
                var tTypePrc = "";
                var tCondFmt = "";
                var tTypePdt = "";
                if ($("#orbAUDConSaveData").prop("checked")== true) {
                  tTypePrc = "1";
                }else {
                  tTypePrc = "2";
                }
                if ($("#orbAUDChar1").prop("checked")==true) {
                  tCondFmt = "1";
                }
                if ($("#orbAUDChar2").prop("checked")==true) {
                  tCondFmt = "2";
                }
                if ($("#orbAUDVat1").prop("checked")==true) {
                  tTypePdt = "1";
                }
                if ($("#orbAUDVat2").prop("checked")==true) {
                  tTypePdt = "2";
                }
                var aPoCondPdt = {
                  'ptTypePrc' :  tTypePrc,//1:เก็บข้อมูล 2:ลบข้อมูล
                  'ptCondType' : $("#ocmAUDDocByType").val(), //1:รหัสสินค้า 2:ชื่อสินค้า
                  'ptCondFmt' : tCondFmt,//1:ขึ้นต้นตัวอักษร 2:ลงท้ายตัวอักษร
                  'ptStrFind' : $("#oetAUDCharText").val(),//ตัวอักษรที่ใช้กรองข้อมูล
                  'ptTypePdt' :  tTypePdt//1:มีภาษี 2:ไม่มีภาษี
                };

                var aData  = [];
                var aPoCondDoc = {
                  'pdDateFrom' : $("#obtAUDDocDateA").val(), //วันที่เริ่มต้น
                  'pdDateTo' : $("#obtAUDDocDateB").val(), //วันที่สิ้นสุด
                  'pnLngID' : "",  //1:THA 2:ENG
                  'ptAgnCodeFrm' : $("#obtAUDAgnFrm").val(), // Agency ต้นทาง
                  'ptAgnCodeTo' : $("#obtAUDAgnTo").val(), // Agency ปลายทาง
                  'ptBchCodeFrm' : $("#obtAUDDocBchF").val(), // สาขา ต้นทาง
                  'ptBchCodeTo' : $("#obtAUDDocBchT").val(), // สาขา ปลายทาง
                };


                aData['ptListDocIn'] = ""; //เฉพาะเอกสาร
                aData['ptListDocNotIn'] = ""; //ยกเว้นเอกสาร
                var nlen = $('input[name="ocbAUDCheck[]"]').valueOf().length;

                for (var i = 0; i < nlen; i++) {
                  if ($("#ocbAUDCheckAll").prop("checked")==true) {

                  }else {
                    if ($("#ocbAUDCheck"+i+"").prop("checked")==true) {
                      if ($("#orbAUDConition1").prop("checked")==true) {
                        aData['ptListDocIn']+= "'"+$("#ocbAUDFTXshDocNo"+i+"").val()+"',";
                      }
                      if ($("#orbAUDConition2").prop("checked")==true) {
                        aData['ptListDocNotIn']+= "'"+$("#ocbAUDFTXshDocNo"+i+"").val()+"',";
                      }
                    }
                  }
                }
                if (aData['ptListDocIn']!="") {
                  aData['ptListDocIn'] = aData['ptListDocIn'].substring(0, aData['ptListDocIn'].length-1);
                }
                if (aData['ptListDocNotIn']!="") {
                  aData['ptListDocNotIn'] = aData['ptListDocNotIn'].substring(0, aData['ptListDocNotIn'].length-1);
                }

                if (($("#obtAUDDocDateA").val() != $("#oetAUDDocDateStart").val()) || ($("#obtAUDDocDateB").val() != $("#oetAUDDocDateStop").val()) ) {
                    FSvCMNSetMsgErrorDialog('ปรับปรุงรายการใหม่อีกครั้งเนื่องจากมีการเปลี่ยนแปลงเงื่อนไขวันที่เอกสาร');
                }else if (aData['ptListDocIn'].length == 0 && aData['ptListDocNotIn'].length == 0 && $("#ocbAUDCheckAll").prop("checked")==false) {
                    FSvCMNSetMsgErrorDialog('ยังไม่ได้เลือกรายการ');
                }else {
                    var aResultDocIn =  aData['ptListDocIn'];
                    var aResultDocNotIn=  aData['ptListDocNotIn'];
                    JSaAUDGetNewDoc(aPoCondPdt,aPoCondDoc,aResultDocIn,aResultDocNotIn);
                }
              }
              function JSaAUDGetNewDoc(paPoCondPdt,paPoCondDoc,paResultDocIn,paResultDocNotIn) {
                $.ajax({
                    type: "POST",
                    url: "AuditGetNewDoc",
                    data:{paPoCondPdt:paPoCondPdt,paPoCondDoc:paPoCondDoc,paResultDocIn:paResultDocIn,paResultDocNotIn:paResultDocNotIn},
                    cache: false,
                    timeout: 0,
                    success: function(tResult){
                      console.log(tResult);
                      //$('#odvModalInfoMessage').modal('show');
                      JSoADCCallSubscribeMQ();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                        JCNxCloseLoading();
                    }
                });
              }
              function JSoADCCallSubscribeMQ() {
                  // RabbitMQ
                  /*===========================================================================*/
                  // Document variable

                  var tPrefix = "RESAUDIT";
                  var tQName = tPrefix + "_" + $("#obtAUDAgnFrm").val() + "_" + '<?php echo $this->session->userdata('tSesSessionID'); ?>';

                  // MQ Message Config
                  var poDocConfig = {
                      tVhostType:"A",
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
                FSvCMNSetMsgSucessDialog('การส่งข้อมูลเสร็จสิ้น');
              }
              </script>
