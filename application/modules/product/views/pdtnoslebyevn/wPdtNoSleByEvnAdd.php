<link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/product/assets/css/product/ada.product.css"> 
<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "pdtnoslebyevnEventEdit";
        $tEvnCode   = $aEvnData['raItems']['rtEvnCode1'];
        $tEvnName   = $aEvnData['raItems']['rtEvnName'];
        $tEvnRmk    = $aEvnData['raItems']['rtEvnRmk'];
        $aDataList  = $aEvnData['raItems']['raDataList'];
    }else{
        $tRoute     = "pdtnoslebyevnEventAdd";
        $tEvnCode   = "";
        $tEvnName   = "";
        $tEvnRmk    = "";
        $aDataList  = "";
    }
?>
<div class="panel panel-headline">
    <div class="panel-body" style="padding-top:20px !important;">
        <div class="custom-tabs-line tabs-line-bottom left-aligned">
            <ul class="nav" role="tablist">
                <li class="nav-item  active" id="oliNameEventTap">
                    <a class="nav-link flat-buttons active" data-toggle="tab" href="#odvNameEventTap" role="tab" aria-expanded="false" onclick="JSxSetStatusCurrentTab(1);">
                        <?= language('product/pdtnoslebyevn/pdtnoslebyevn', 'tEVNTabNameEVN') ?> 
                    </a>
                </li>
                <li class="nav-item" id="oliEventTimeTap">
                    <a class="nav-link flat-buttons" data-toggle="tab" href="#odvEventTimeTap" role="tab" aria-expanded="false" onclick="JSxSetStatusCurrentTab(2);">
                        <?= language('product/pdtnoslebyevn/pdtnoslebyevn', 'tEVNTabTimeEVN') ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmPdtNoSleByEvnAdd">
                    <button style="display:none" type="submit" id="obtSubmitPdtNoSleByEvn" onclick="JSoAddEditPdtNoSleByEvn();"></button>
                    <input type="hidden" id="ohdEvnRoute" value="<?php echo $tRoute; ?>">
                    <div class="tab-content">
                        <div class="tab-pane active" style="margin-top:10px;" id="odvNameEventTap" role="tabpanel" aria-expanded="true" >



                            <div class="row">
                                <div class="col-xs-12 col-md-5 col-lg-5">
                                    <input type="hidden" value="0" id="ohdCheckEvnSubmitByButton" name="ohdCheckEvnSubmitByButton"> 
                                    <input type="hidden" value="0" id="ohdCheckEvnClearValidate" name="ohdCheckEvnClearValidate"> 
                                    <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBCode')?></label>
                                    <?php
                                    if($tRoute=="pdtnoslebyevnEventAdd"){
                                    ?>
                                    <div class="form-group" id="odvPunAutoGenCode">
                                        <div class="validate-input">
                                            <label class="fancy-checkbox">
                                                <input type="checkbox" id="ocbEvnAutoGenCode" name="ocbEvnAutoGenCode" checked="true" value="1">
                                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group" id="odvEvnCodeForm">
                                       <input 
                                            type="text" 
                                            class="form-control xCNInputWithoutSpcNotThai" 
                                            maxlength="5" 
                                            id="oetEvnCode" 
                                            name="oetEvnCode"
                                            data-is-created="<?php  ?>"
                                            placeholder="<?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBCode')?>"
                                            value="<?php  ?>" 
                                            data-validate-required="<?php echo language('product/pdtnoslebyevn/pdtnoslebyevn','tEvnValidCode')?>"
                                            data-validate-dublicateCode="<?php echo language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBDuplicateNosaleByEvenCode')?>"
                                            readonly
                                            onfocus="this.blur()">
                                        <input type="hidden" value="2" id="ohdCheckDuplicateEvnCode" name="ohdCheckDuplicateEvnCode"> 
                                    </div>
                                    <?php
                                    }else{
                                    ?>
                                    <div class="form-group" id="odvEvnCodeForm">
                                        <div class="validate-input">
                                            <label class="fancy-checkbox">
                                            <input 
                                                type="text" 
                                                class="form-control xCNInputWithoutSpcNotThai" 
                                                maxlength="5" 
                                                id="oetEvnCode" 
                                                name="oetEvnCode"
                                                data-is-created="<?php  ?>"
                                                placeholder="<?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBCode')?>"
                                                value="<?php echo $tEvnCode; ?>" 
                                                readonly
                                                onfocus="this.blur()">
                                            </label>
                                        </div>
                                    </div>    
                                    <?php
                                    }
                                    ?>

                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNFrmEvnName')?></label>
                                        <input type="text" class="form-control xCNInputWithoutSpc" maxlength="50" id="oetEvnName" name="oetEvnName" data-validate-required="<?php echo language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNValidName')?>" value="<?php echo $tEvnName ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNFrmEvnRmk')?></label>
                                        <textarea class="form-control" maxlength="100" rows="5" id="otaEvnRmk" name="otaEvnRmk"><?=$tEvnRmk?></textarea>
                                    </div>

                                </div>
                            </div>



                        </div>
                        <div class="tab-pane" style="margin-top:10px;" id="odvEventTimeTap" role="tabpanel" aria-expanded="true" >
                            <div class="row">
                                <div class="col-xs-12 xCNMargin-top-20px text-right">
                                    <button class="xCNBTNPrimeryPlus" type="button" onclick="JSxAddDateTimeToPdtNosaleShowModal();">+</button>
                            
                                </div>
                                <div class="col-xs-12 xCNMargin-top-20px">
                                    
                                    <input type="hidden" id="ohdIconPathDelete" value="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>">
                                    <div class="table-responsive">
                                        <table id="otbEvnDataAddList" class="table table-striped" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center xCNTextBold"><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBType')?></th>
                                                    <th class="text-center xCNTextBold"><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBDStart')?></th>
                                                    <th class="text-center xCNTextBold"><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBTStart')?></th>
                                                    <th class="text-center xCNTextBold"><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBDFinish')?></th>
                                                    <th class="text-center xCNTextBold"><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBTFinish')?></th>
                                                    <th class="text-center xCNTextBold"><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBDelete')?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="otbNosaleDateTimeOrder">
                                            <?php
                                            if($tRoute=="pdtnoslebyevnEventEdit"){
                                                
                                                if(FCNnHSizeOf($aDataList)!=0){
                                                    for($nI=0;$nI<FCNnHSizeOf($aDataList);$nI++){
                                            ?>
                                                        
                                                            <tr>
                                                                <td class="text-center">
                                                                    <?php
                                                                    if($aDataList[$nI]["rtEvnType"]==1){
                                                                    ?>
                                                                    <span>ตามช่วงเวลา</span>
                                                                    <?php
                                                                    }else{
                                                                    ?>
                                                                    <span>ตามช่วงวันที่</span>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php
                                                                    if($aDataList[$nI]["rtEvnDStart"]!=""){
                                                                    ?>
                                                                    <span><?php echo date("Y-m-d",strtotime($aDataList[$nI]["rtEvnDStart"])); ?></span>
                                                                    <?php
                                                                    }else{
                                                                    ?>
                                                                    <span>-</span>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php
                                                                    if($aDataList[$nI]["rtEvnTStart"]!=""){
                                                                    ?>
                                                                    <span><?php echo $aDataList[$nI]["rtEvnTStart"]; ?></span>
                                                                    <?php
                                                                    }else{
                                                                    ?>
                                                                    <span>-</span>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php
                                                                    if($aDataList[$nI]["rtEvnDFinish"]!=""){
                                                                    ?>
                                                                    <span><?php echo date("Y-m-d",strtotime($aDataList[$nI]["rtEvnDFinish"])); ?></span>
                                                                    <?php
                                                                    }else{
                                                                    ?>
                                                                    <span>-</span>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td class="text-center"> 
                                                                    <?php
                                                                    if($aDataList[$nI]["rtEvnTFinish"]!=""){
                                                                    ?>
                                                                    <span><?php echo $aDataList[$nI]["rtEvnTFinish"]; ?></span>
                                                                    <?php
                                                                    }else{
                                                                    ?>
                                                                    <span>-</span>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSxDeleteNoSaleItemBack('<?php echo $aDataList[$nI]["rtEvnSeqNo"]; ?>');">
                                                                </td>
                                                            </tr>
                                                        
                                            <?php
                                                    }
                                                }else{
                                            ?>
                                                    
                                                        <tr id="otrEvnFrmNoData"><td class='text-center xCNTextDetail2' colspan='6'><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEvnFrmNoData')?></td></tr>
                                                    
                                            <?php        
                                                }
                                            }else{
                                            ?>
                                                
                                                    <tr id="otrEvnFrmNoData"><td class='text-center xCNTextDetail2' colspan='6'><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEvnFrmNoData')?></td></tr>
                                                
                                            <?php
                                            }
                                            ?>
                                            </tbody> 
                                        </table>
                                        <input type="hidden" value="<?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEvnFrmNoData')?>" id="ohdEvnFrmNoData">
                                    </div>
                                    


                                </div>
                            </div>
                        






                    
                        </div> 
                    </div>
                


                  

















                </form>
                <div id="odvModalAddDataPdtNoSleByEvn" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form id="ofmModalNosaleSetDateTimeInfor" class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                        <button style="display:none" type="submit" id="obtSubmiModalNosaleSetDateTimeInfor" onclick="JSxAddDateTimeOrderFromModal('<?php echo $tRoute; ?>');"></button>
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="row">
                                    <div class=" col-xs-12 col-md-6 col-lg-6">
                                        <!-- <h4 class="modal-title xCNTextModalHeard">เพิ่มข้อมูลเหตุการณ์</h4> -->
                                        <label class="xCNTextModalHeard">เพิ่มข้อมูลเหตุการณ์</label>
                                        <input type="hidden" value="0" id="ohdCheckDuplicateEvnDateTime" name="ohdCheckDuplicateEvnDateTime"> <!-- 0 คือ ไม่เกิด validate และ 1 คือเกิด validate --> 
                                        <input type="hidden" value="0"  id="ohdCheckDateFormat" name="ohdCheckDateFormat"> <!-- 0 คือ ไม่เกิด validate และ 1 คือเกิด validate -->
                                        <input type="hidden" value="0"  id="ohdCheckTimeFormat" name="ohdCheckTimeFormat"> <!-- 0 คือ ไม่เกิด validate และ 1 คือเกิด validate -->
                                    </div>
                                    <div class=" col-xs-12 col-md-6 col-lg-6">
                                        <div class="demo-button xCNPdtModalBtn text-right">
                                            <button id="obtAddPdtNoSleByEvn" type="button" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="$('#obtSubmiModalNosaleSetDateTimeInfor').click()">บันทึก</button>
                                            <button type="button" class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal">ย้อนกลับ</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label class="xCNLabelFrm">ประเภทเหตุการณ์</label>
                                        <select class="form-control" id="ocmEvnType" name="ocmEvnType" onchange="JSxChangePdtEvnType()" tabindex="-98">
                                            <option value="1" selected>ตามช่วงเวลา</option>
                                            <option value="2">ตามช่วงวันที่</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="odvDateBtw" class="row hidden">
                                    <div class="col-md-6">
                                        <div class="">
                                            <div class="form-group">
                                                <div class="validate-input">
                                                    <label class="xCNTextDetail1">วันที่เริ่มต้น</label>
                                                    <input type="text" class="form-control input100 xCNDatePicker xCNInputMaskDate" id="oetEvnDStart" name="oetEvnDStart" value="" maxlength="10"
                                                    data-validate-required="<?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNValidDStart')?>"
                                                    data-validate-maxlength="<?= language('product/pdtnoslebyevn/pdtnoslebyevn','tValidMaxLeangth10')?>"
                                                    data-validate-compareFormatDate="<?= language('product/pdtnoslebyevn/pdtnoslebyevn','tValidCompareDate')?>">
                                                    <span class="focus-input100"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="">
                                            <div class="form-group">
                                                <div class="validate-input">
                                                    <label class="xCNTextDetail1">วันที่สิ้นสุด</label>
                                                    <input type="text" class="form-control input100 xCNDatePicker xCNInputMaskDate" id="oetEvnDFinish" name="oetEvnDFinish" value="" maxlength="10"
                                                    data-validate-required="<?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNValidDFinish')?>"
                                                    data-validate-maxlength="<?= language('product/pdtnoslebyevn/pdtnoslebyevn','tValidMaxLeangth10')?>">
                                                    <span class="focus-input100"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                                <div id="odvTimeBtw" class="row">
                                    <div class="col-md-6">
                                        <div class="">
                                            <div class="form-group">
                                                <div class="validate-input">
                                                    <label class="xCNTextDetail1 active">เวลาเริ่มต้น</label>
                                                    <input type="text" class="form-control input100 xCNTimePicker xCNInputMaskTime" id="oetEvnTStart" name="oetEvnTStart" value="" maxlength="8"
                                                    data-validate-required="<?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNValidTStart')?>"
                                                    data-validate-maxlength="<?= language('product/pdtnoslebyevn/pdtnoslebyevn','tValidMaxLeangth8')?>"
                                                    data-validate-compareFormatTime="<?= language('product/pdtnoslebyevn/pdtnoslebyevn','tValidCompareTime')?>">
                                                    <span class="focus-input100"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="">
                                            <div class="form-group">
                                                <div class="validate-input">
                                                    <label class="xCNTextDetail1 active">เวลาสิ้นสุด</label>
                                                    <input type="text" class="form-control input100 xCNTimePicker xCNInputMaskTime" id="oetEvnTFinish" name="oetEvnTFinish" value="" maxlength="8"
                                                    data-validate-required="<?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNValidTFinish')?>"
                                                    data-validate-maxlength="<?= language('product/pdtnoslebyevn/pdtnoslebyevn','tValidMaxLeangth8')?>">
                                                    <span class="focus-input100"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="odvStaAllDay" class="form-group row hidden">
                                    <div class="col-md-6">
                                        <div class="validate-input">
                                            <label class="fancy-checkbox">
                                                <input id="ocbEvnStaAllDay" class="ocbEvnStaAllDay" name="ocbEvnStaAllDay" type="checkbox">
                                                <span class="xCNTextDetail1"> ทั้งวัน</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>





<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script type="text/javascript">
    var aDataTypeByTimeCompare = [];
    var aDataTypeByDateAndAllDayCompare = [];
    var aDataTypeByDateAndNoAllDayCompare = [];
    var bStatusValidDateTimeNosale = 0;
    $( document ).ready(function() {
        $("#ocbEvnStaAllDay").change(function(){
            if($('#ocbEvnStaAllDay').prop('checked')) {
                $("#odvTimeBtw").removeClass("show");
                $("#odvTimeBtw").addClass("hidden");
            } else {
                $("#odvTimeBtw").removeClass("hidden");
                $("#odvTimeBtw").addClass("show");
            }
        });
        $('.xCNSelectBox').selectpicker();
        $('.xCNDatePicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('.xCNTimePicker').datetimepicker({
            format: 'HH:mm:ss'
        });
        <?php
        if($tRoute=="pdtnoslebyevnEventEdit"){
            if(FCNnHSizeOf($aDataList)!=0){
                for($nI=0;$nI<FCNnHSizeOf($aDataList);$nI++){
                    if($aDataList[$nI]["rtEvnType"]==1){
        ?>
                    aDataTypeByTimeCompare.push( {
                                                    "evnTStartSend" : "<?php echo $aDataList[$nI]["rtEvnTStart"]; ?>", 
                                                    "evnTFinishSend" : "<?php echo $aDataList[$nI]["rtEvnTFinish"]; ?>"
                                                });
                    aDataTypeByDateAndAllDayCompare.push( {
                                                    "evnDStart" : "",
                                                    "evnDFinish" : ""
                                                });
                    aDataTypeByDateAndNoAllDayCompare.push( {
                                                    "evnTStartSend" : "",
                                                    "evnTFinishSend" : "",
                                                    "evnDStart" : "",
                                                    "evnDFinish" : ""
                                                });
        <?php
                    }else{
                        if($aDataList[$nI]["rtEvnStaAllDay"]==1){
        ?>
                            aDataTypeByTimeCompare.push( {
                                                            "evnTStartSend" : "", 
                                                            "evnTFinishSend" : ""
                                                        });
                            aDataTypeByDateAndAllDayCompare.push( {
                                                            "evnDStart" : "<?php echo $aDataList[$nI]["rtEvnDStart"]; ?>", 
                                                            "evnDFinish" : "<?php echo $aDataList[$nI]["rtEvnDFinish"]; ?>"
                                                        });
                            aDataTypeByDateAndNoAllDayCompare.push( {
                                                            "evnTStartSend" : "",
                                                            "evnTFinishSend" : "",
                                                            "evnDStart" : "",
                                                            "evnDFinish" : ""
                                                        });
        <?php
                        }else{
        ?>
                            aDataTypeByTimeCompare.push( {
                                                            "evnTStartSend" : "",
                                                            "evnTFinishSend" : ""
                                                        });
                            aDataTypeByDateAndAllDayCompare.push( {
                                                            "evnDStart" : "",
                                                            "evnDFinish" : ""
                                                        });
                            aDataTypeByDateAndNoAllDayCompare.push( {
                                                            "evnTStartSend" : "<?php echo $aDataList[$nI]["rtEvnTStart"]; ?>",
                                                            "evnTFinishSend" : "<?php echo $aDataList[$nI]["rtEvnTFinish"]; ?>",
                                                            "evnDStart" : "<?php echo $aDataList[$nI]["rtEvnDStart"]; ?>", 
                                                            "evnDFinish" : "<?php echo $aDataList[$nI]["rtEvnDFinish"]; ?>"
                                                        });

                   
        <?php
                        }
                    }
                }
            }
        }
        ?>
        
    });
    
    function JSxChangePdtEvnType(){
        if($("#ocmEvnType").val()==1){
            $("#odvDateBtw").removeClass("show");
            $("#odvDateBtw").addClass("hidden");
            $("#odvTimeBtw").removeClass("hidden");
            $("#odvTimeBtw").addClass("show");
            $("#odvStaAllDay").removeClass("show");
            $("#odvStaAllDay").addClass("hidden");
            $('#ocbEvnStaAllDay').prop('checked',false);
        }else{
            $("#odvDateBtw").removeClass("hidden");
            $("#odvDateBtw").addClass("show");
            $("#odvTimeBtw").removeClass("hidden");
            $("#odvTimeBtw").addClass("show");
            $("#odvStaAllDay").removeClass("hidden");
            $("#odvStaAllDay").addClass("show");
        }
    }
    // //Function Chack Date Start-Finish Input Blur
    // //Parameters : Event Button Click 
    // //Creator : 27/09/2018 wasin
    // //Return : Alert Date Input
    // //Return Type : -
    // function JSxChackDateStartEnd(event){
    //     var dDateStart     = $("#oetEvnDStart").val();
    //     var dDateFinish    = $("#oetEvnDFinish").val();
    //     if(dDateStart != "" && dDateFinish != ""){
    //         if(dDateFinish < dDateStart){
    //             $(event).val('');
    //             $(event).parent().attr('data-validate'," //language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNValidCheckDate')");
    //             $(event).parent().addClass('alert-validate');
    //         }else{
    //             $(event).parent().removeClass('alert-validate');
    //         }
    //     }
    // }
    // //Function Chack Date Start-Finish Input Blur
    // //Parameters : Event Button Click 
    // //Creator : 27/09/2018 wasin
    // //Return : Alert Date Input
    // //Return Type : -
    // function JSxChackTimeStartEnd(event){
    //     var tTimeStart     = $("#oetEvnTStart").val();
    //     var tTimeFinish    = $("#oetEvnTFinish").val();
    //     if(tTimeStart != "" && tTimeFinish != ""){
    //         if(tTimeFinish < tTimeStart){
    //             $(event).val('');
    //             $(event).parent().attr('data-validate'," //language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNValidCheckTime')");
    //             $(event).parent().addClass('alert-validate');
    //         }else{
    //             $(event).parent().removeClass('alert-validate');
    //         }
    //     }
    // }
    // $('.xCNSelectBox').selectpicker();
    // $(".selection-2").select2({
    //     minimumResultsForSearch: 20,
    //     dropdownParent: $('#dropDownSelect1')
    // });

    // $('.xCNDatePicker').datetimepicker({
    //     format: 'YYYY-MM-DD'
    // });

    // $('.xCNTimePicker').datetimepicker({
    //     format: 'HH:mm:ss'
    // });
    
    // $('#ocbEvnStaAllDay').click(function(){
    //     var tStaClick = ($(this).is(':checked'))? 1 : 0 ;
    //     if(tStaClick == 1){
    //         $('.xCNDatePicker,.xCNTimePicker').val('');
    //         $('.xCNDatePicker,.xCNTimePicker').parent().removeClass('alert-validate');
    //         $(".xCNDatePicker").attr('disabled', false);
    //         $(".xCNDatePicker").removeClass('xCNDisable');
    //         $(".xCNTimePicker").addClass('xCNDisable');
    //         $('.xCNTimePicker').attr('disabled', true);
    //     }else{
    //         $('.xCNDatePicker,.xCNTimePicker').parent().removeClass('alert-validate');
    //         $(".xCNTimePicker").val('');
    //         $(".xCNTimePicker").removeClass('xCNDisable');
    //         $('.xCNTimePicker').attr('disabled', false);
    //     }
    // });
    
    

    // //Functionality : Function Event Change Event Type
    // //Parameters : Event Button Click 
    // //Creator : 24/09/2018 wasin
    // //Return : Disable Input
    // //Return Type : -
    // function JSxChangePdtEvnType(){
    //     var tStaEventTyep = $('#ocmEvnType').val();
    //     if(tStaEventTyep == 1){
    //         $('.xCNDatePicker,.xCNTimePicker').val('');
    //         $('.xCNDatePicker,.xCNTimePicker').parent().removeClass('alert-validate');
    //         $("#ocbEvnStaAllDay").prop("checked",false);
    //         $("#odvStaAllDay").addClass('xCNHide');

    //         $(".xCNDatePicker").addClass('xCNDisable');
    //         $('.xCNDatePicker').attr('disabled', true);

    //         $(".xCNTimePicker").removeClass('xCNDisable');
    //         $('.xCNTimePicker').attr('disabled', false);
    //     }else{
    //         $('.xCNDatePicker,.xCNTimePicker').val('');
    //         $('.xCNDatePicker,.xCNTimePicker').parent().removeClass('alert-validate');
    //         $("#ocbEvnStaAllDay").prop("checked",false);
    //         $('#odvStaAllDay').removeClass('xCNHide');
    //         $('.xCNDatePicker').attr('disabled', false);
    //         $(".xCNDatePicker").removeClass('xCNDisable');
    //     }
    // }

    // //Functionality : Function Call Modal Form Insert List Data
    // //Parameters : Event Button Click 
    // //Creator : 24/09/2018 wasin
    // //Return : -
    // //Return Type : -
    // function JSxAddDataPdtNoSleByEvn(){
    //     var tEvnCode = $('#oetEvnCode').val();
    //     if(tEvnCode != ""){
    //         $('#odvModalAddDataPdtNoSleByEvn').modal({backdrop: 'static', keyboard: false}).modal("show");
    //         JSxChangePdtEvnType();
    //         $('#obtAddPdtNoSleByEvn').click(function(){
    //             $('#ofmAddPdtNoSleByEvnDetail').validate({
    //                 rules: {
    //                     oetEvnDStart    : "required",
    //                     oetEvnDFinish   : "required",
    //                     oetEvnTStart    : "required",
    //                     oetEvnTFinish   : "required"
    //                 },
    //                 messages: {
    //                     oetEvnDStart    : "",
    //                     oetEvnDFinish   : "",
    //                     oetEvnTStart    : "",
    //                     oetEvnTFinish   : ""
    //                 },
    //                 errorClass: "alert-validate",
    //                 validClass: "",
    //                 highlight: function(element, errorClass, validClass) {
    //                     $(element).parent().addClass(errorClass).removeClass(validClass);
    //                 },
    //                 unhighlight: function(element, errorClass, validClass) {
    //                     $(element).parent().removeClass(errorClass).addClass(validClass);
    //                 },
    //                 submitHandler: function(form){
    //                     $('#otbEvnDataAddList tbody #otrEvnFrmNoData').remove();
    //                     var tEvnCode        = $("#oetEvnCode").val();
    //                     var nStaEvnType     = $('#ocmEvnType').val();
    //                     var tStaEvnType     = (nStaEvnType == 1)? '//language('product/pdtnoslebyevn/pdtnoslebyevn','tEvnFrmTypeTime')' : '<?=language('product/pdtnoslebyevn/pdtnoslebyevn','tEvnFrmTypeDay')?>';
    //                     var nEvnStaAllDay   = ($('#ocbEvnStaAllDay').is(':checked'))? 1 : 0;
    //                     var tEvnDStart      = $("#oetEvnDStart").val();
    //                     var tEvnDFinish     = $("#oetEvnDFinish").val();
    //                     var tEvnTStart      = $("#oetEvnTStart").val();
    //                     var tEvnTFinish     = $("#oetEvnTFinish").val();
    //                     $('#otbEvnDataAddList tbody').append($('<tr>')
    //                     .attr('class','text-center xWPdtNoSleByEvnList')
    //                     .attr('data-evntype',nStaEvnType)
    //                     .attr('data-evndstart',tEvnDStart)
    //                     .attr('data-evndfinish',tEvnDFinish)
    //                     .attr('data-evntstart',tEvnTStart)
    //                     .attr('data-evntfinish',tEvnTFinish)
    //                     .attr('data-evntstaallday',nEvnStaAllDay)
    //                         .append($('<td>')
    //                         .text(tEvnCode)
    //                         )
    //                         .append($('<td>')
    //                         .attr('class','text-left')
    //                         .text(tStaEvnType)
    //                         )
    //                         .append($('<td>')
    //                         .text((tEvnDStart != "")? tEvnDStart : "-")
    //                         )
    //                         .append($('<td>')
    //                         .text((tEvnTStart != "")? tEvnTStart : "-")
    //                         )
    //                         .append($('<td>')
    //                         .text((tEvnDFinish != "")? tEvnDFinish : "-")
    //                         )
    //                         .append($('<td>')
    //                         .text((tEvnTFinish != "")? tEvnTFinish : "-")
    //                         )
    //                         .append($('<td>')
    //                             .append($('<i>')
    //                             .attr('class','fa fa-trash-o fa-lg xCNTextLink')
    //                                 .click(function(){
    //                                     JSxPdtNoSleByEvnDellist(this);
    //                                 })
    //                             )
    //                         )
    //                     ).delay('500').fadeIn('slow');
    //                     $('#odvModalAddDataPdtNoSleByEvn').modal('hide');
    //                 },
    //                 errorPlacement: function(error, element){
    //                     return true;
    //                 }
    //             });
    //         });
    //     }else{
    //         $('#oetEvnCode').parent().addClass('alert-validate');
    //     }
    // }

    // //Functionality : Function Delete DataList From
    // //Parameters : Event Button Click 
    // //Creator : 24/09/2018 wasin
    // //Return : -
    // //Return Type : -
    // function JSxPdtNoSleByEvnDellist(event){
    //     $(event).parent().parent().fadeOut('slow',function(){
    //         $(this).remove();
    //         var nCountRow = $('#otbEvnDataAddList tbody .xWPdtNoSleByEvnList').length;
    //         if(nCountRow == 0){
    //             $('#otbEvnDataAddList tbody').append($('<tr>')
    //             .attr('id','otrEvnFrmNoData')
    //                 .append($('<td>')
    //                 .attr('class','text-center xCNTextDetail2')
    //                 .attr('colspan','7')
    //                 .text(' //language('product/pdtnoslebyevn/pdtnoslebyevn','tEvnFrmNoData')')
    //                 )
    //             )
    //         }
    //     });
    // }

</script>