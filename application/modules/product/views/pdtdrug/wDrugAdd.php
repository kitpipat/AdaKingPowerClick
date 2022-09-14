
<input id="oetDrugStaBrowse" type="hidden" value="<?php echo $nDrugBrowseType?>">
<input id="oetDrugCallBackOption" type="hidden" value="<?php echo $tDrugBrowseOption?>">

<?php 
    $nDecShow           =  FCNxHGetOptionDecimalShow();
    $tRoute             = "pdtDrugEventAdd";
    $dGetDataNow        = date('Y-m-d');
    $dGetDataFuture     = date('Y-m-d', strtotime('+1 year'));

    if($aCheckID['rtCode'] == 1){

        $tDrugRegis         = $aCheckID['raItems']['FTPdgRegNo'];
        $tGenericName       = $aCheckID['raItems']['FTPdgGenericName'];
        $tDrugBrand         = $aCheckID['raItems']['FTPdgBrandName'];
        $tDrugType          = $aCheckID['raItems']['FTPdgCategory'];
        $tPdtDrugType1      = $aCheckID['raItems']['FTPdgType'];
        $tPdtDosage         = $aCheckID['raItems']['FTPdgForm'];
        $tDrugExpirePeriod  = number_format($aCheckID['raItems']['FCPdgAge'],$nDecShow);
        $tUnitName          = $aCheckID['raItems']['FTPdgVolume'];
        $dPdtDrugStart      = $aCheckID['raItems']['FDPdgCreate'];
        $dPdtDrugExpire     = $aCheckID['raItems']['FDPdgExpired'];
        $tPdtIngredient     = $aCheckID['raItems']['FTPdgActIngredient'];
        $tPdtProperties     = $aCheckID['raItems']['FTPdgProperties'];
        $tPdtHowtoUse       = $aCheckID['raItems']['FTPdgHowtoUse'];
        $tPdtDoseMaximum    = number_format($aCheckID['raItems']['FCPdgDoseSchedule'],$nDecShow);
        $tPdtMaxintake      = number_format($aCheckID['raItems']['FCPdgMaxIntake'],$nDecShow);
        $tPdtContraindications    = $aCheckID['raItems']['FTPdgCtd'];
        $tPdtCautionAdvice        = $aCheckID['raItems']['FTPdgWarn'];
        $tPdtStopUse              = $aCheckID['raItems']['FTPdgStopUse'];
        $tPdtHowtoPreserve        = $aCheckID['raItems']['FTPdgStorage'];
        $tPdtProducedby           = $aCheckID['raItems']['FTPdgManufacturer'];
        // $tConditionCode           = $aCheckID['raItems']['FTRolCode'];
        // $tConditionName           = $aCheckID['raItems']['FTRolName'];

    }

    
    

?>

<style>
    .xCNPdtDrug{
        padding: 10px 0px;
    }

</style>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddEditDrug">
    <input type="hidden" value="<?php echo @$tRoute; ?>" id="ohdTRoute">
    <div class="panel-body" style="padding-top:10px !important;"> <!-- เพิ่มมาใหม่ -->  
        <div class="row">
            <!--ปุ่มเพิ่ม-->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  text-right">
                <button type="button" id="obtPdtCancel" class="btn" style="background-color: #D4D4D4; color: #000000;">
                    <?php echo language('common/main/main', 'tCancel')?>
                </button>
                <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" id="obtPdtDrugSave" onclick="JSxDrugSaveAddEdit('<?=$tRoute?>')"> <?php echo  language('common/main/main', 'tSave')?></button>
            </div>

            <!-- เลขทะเบียนยา -->
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('product/pdtdrug/pdtdrug','tPdtDrugRegisNo');?></label>
                    <input 
                        type="text"
                        class="form-control"
                        maxlength="20"
                        id="oetDrugRegis"
                        name="oetDrugRegis"
                        value="<?php echo @$tDrugRegis;?>"
                        placeholder="<?php echo language('product/pdtdrug/pdtdrug','tPdtDrugRegisNo');?>"
                        autocomplete="off"
                        data-validate-required = "<?php echo language('product/pdtdrug/pdtdrug','tPDTValidDrugRegisNo');?>"
                    >
                </div>

                <!-- ชื่อสามัญทางยา -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('product/pdtdrug/pdtdrug','tPDtGenericName');?></label>
                    <input 
                        type="text"
                        class="form-control"
                        maxlength="100"
                        id="oetGenericName"
                        name="oetGenericName"
                        value="<?php echo @$tGenericName;?>"
                        placeholder="<?php echo language('product/pdtdrug/pdtdrug','tPDtGenericName');?>"
                        autocomplete="off"
                        data-validate-required = "<?php echo language('product/pdtdrug/pdtdrug','tPDTValidGenericName');?>"
                    >
                </div>
                <!-- ชื่อแบรณด์ -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('product/pdtdrug/pdtdrug','tPdtDrugBrand');?></label>
                    <input 
                        type="text"
                        class="form-control"
                        maxlength="100"
                        id="oetDrugBrand"
                        name="oetDrugBrand"
                        value="<?php echo @$tDrugBrand;?>"
                        placeholder="<?php echo language('product/pdtdrug/pdtdrug','tPdtDrugBrand');?>"
                        autocomplete="off"
                        data-validate-required = "<?php echo language('product/pdtdrug/pdtdrug','tPDTValidDrugBrand');?>"
                    >
                </div>

                <!-- ประเภทยา -->
                <div class="form-group"> 
                    <label class="xCNLabelFrm"><?php echo language('product/pdtdrug/pdtdrug','tPdtDrugType');?></label>
                    <input type="text"
                    class="form-control"
                    maxlength="50"
                    id="oetDrugType"
                    name="oetDrugType"
                    value="<?php echo @$tDrugType;?>"
                    placeholder="<?php echo language('product/pdtdrug/pdtdrug','tPdtDrugType');?>"
                    autocomplete="off"
                    data-validate-required = "<?php echo language('product/pdtdrug/pdtdrug','tPDTValidDrugType');?>"
                    >
                </div>

                <!-- ชนิดยา -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('product/pdtdrug/pdtdrug','tPdtDrugType1')?></label>
                    <select  required  class="selectpicker form-control" id="ocmPdtDrugType1" name="ocmPdtDrugType1">
                        <option value='ยาใช้ภายใน' <?php echo  (isset($tPdtDrugType1) && !empty($tPdtDrugType1) && $tPdtDrugType1 == 'ยาใช้ภายใน')? "selected":""?>>
                            <?php echo language('product/pdtdrug/pdtdrug','tPdtInternalDrug')?>
                        </option>
                        <option value='ยาใช้ภายนอก' <?php echo  (isset($tPdtDrugType1) && !empty($tPdtDrugType1) && $tPdtDrugType1 == 'ยาใช้ภายนอก')? "selected":""?>>
                            <?php echo language('product/pdtdrug/pdtdrug','tPdtExternalDrug')?>
                        </option>
                    </select>
                </div>

                <!-- รูปแบบยา -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('product/pdtdrug/pdtdrug','tPdtDosageform')?></label>
                    <select required class="selectpicker form-control" id="ocmPdtDosage" name="ocmPdtDosage">
                        <option value='ชนิดเม็ด' <?php echo  (isset($tPdtDosage) && !empty($tPdtDosage) && $tPdtDosage == 'ชนิดเม็ด')? "selected":""?>>
                            <?php echo language('product/pdtdrug/pdtdrug','tPdtGrain');?>
                        </option>
                        <option value='ชนิดน้ำเชื่อม' <?php echo  (isset($tPdtDosage) && !empty($tPdtDosage) && $tPdtDosage == 'ชนิดน้ำเชื่อม')? "selected":""?>>
                            <?php echo language('product/pdtdrug/pdtdrug','tPdtSyrup');?>
                        </option>
                        <option value='แคปซูน' <?php echo  (isset($tPdtDosage) && !empty($tPdtDosage) && $tPdtDosage == 'แคปซูน')? "selected":""?>>
                            <?php echo language('product/pdtdrug/pdtdrug','tPdtCapsule');?>
                        </option>
                        <option value='ครีมสำหรับทา' <?php echo  (isset($tPdtDosage) && !empty($tPdtDosage) && $tPdtDosage == 'ครีมสำหรับทา')? "selected":""?>>
                            <?php echo language('product/pdtdrug/pdtdrug','tPdtApply');?>
                        </option>
                    </select>
                </div>

                <!-- อายุยา -->
                <div class="form-group"> 
                    <label class="xCNLabelFrm"><?php echo language('product/pdtdrug/pdtdrug','tPdtAgeDrug');?></label>
                    <input 
                        type="text" 
                        class="form-control xCNInputNumericWithDecimal text-right" 
                        id="oetDrugExpirePeriod" 
                        name="oetDrugExpirePeriod" 
                        value="<?php echo @$tDrugExpirePeriod?>" 
                        placeholder = "<?php echo language('product/pdtdrug/pdtdrug','tPdtAge');?>"
                        data-validate="<?php echo language('product/pdtdrug/pdtdrug','tDrugValidExpirePeriod')?>">
                </div>

                <!-- หน่วย -->
                <div class="form-group"> 
                    <label class="xCNLabelFrm"><?php echo language('product/pdtdrug/pdtdrug','tPDTUnit');?></label>
                    <input type="text"
                    class="form-control"
                    maxlength="50"
                    id="oetPdtVolumCode"
                    name="oetPdtVolumName"
                    value="<?php echo @$tUnitName;?>"
                    placeholder="<?php echo language('product/pdtdrug/pdtdrug','tPDTUnit');?>"
                    autocomplete="off"
                    data-validate-required = "<?php echo language('product/pdtdrug/pdtdrug','tPDTValidDrugType');?>"
                    >
                </div>
                
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                <!-- วันที่ผลิต -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('product/pdtdrug/pdtdrug','tPdtDrugStartDate')?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-center" id="oetPdtDrugStartDate" name="oetPdtDrugStartDate" value="<?php if(@$dPdtDrugStart != ""){ echo @$dPdtDrugStart;}else{echo $dGetDataNow;}?>" >
                        <span class="input-group-btn">
                            <button id="obtPdtDrugStartDate" type="button" class="btn xCNBtnDateTime">
                                <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                            </button>
                        </span>
                    </div>
                </div>

                <!-- วันที่หมดอายุ -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('product/pdtdrug/pdtdrug','tPdtDrugExpire')?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-center" id="oetDrugExpire" name="oetDrugExpire" value="<?php if(@$dPdtDrugExpire != ""){ echo @$dPdtDrugExpire;}else{echo $dGetDataNow;}?>" >
                        <span class="input-group-btn">
                            <button id="obtPdtDrugExpire" type="button" class="btn xCNBtnDateTime">
                                <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ส่วน Tab -->
        <div class="xWPdtDrugHeadTab custom-tabs-line tabs-line-bottom left-aligned">
            <ul class="nav" role="tablist">
                <!-- ส่วนประกอบ -->
                <li id="oliPdtIngredient" class="xWMenu active" data-menutype="MN">
                    <a role="tab" data-toggle="tab" data-target="#odvPdtIngredient" aria-expanded="true"><?php echo language('product/pdtdrug/pdtdrug','tPdtIngredient');?></a>
                </li>

                <!-- สรรพคุณ -->
                <li id="oliPdtProperties" class="xWMenu" data-menutype="MN">
                    <a role="tab" data-toggle="tab" data-target="#odvPdtProperties" aria-expanded="false"><?php echo language('product/product/product','tPdtProperties');?></a>
                </li>

                <!-- วิธีการใช้/ข้อบ่งชี้ -->
                <li id="oliPdtHowtouse" class="xWMenu" data-menutype="MN">
                    <a id="oahPdtHowtouse" role="tab" data-toggle="tab" data-target="#odvPdtHowtouse" aria-expanded="false"><?php echo language('product/product/product','tPdtHowtouse');?></a>
                </li>

                <!-- อื่นๆ -->
                <li id="oliPdtOther" class="xWMenu" data-menutype="MN">
                    <a role="tab" data-toggle="tab" data-target="#odvPdtOther" aria-expanded="false"><?php echo language('product/product/product','tPdtOther');?></a>
                </li>

            </ul>
        </div>

        <div class="tab-content xWPdtDrugDetailTab">
            <!-- ส่วนประกอบ -->
            <div  id="odvPdtIngredient" class="tab-pane fade active in xCNPdtDrug">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('product/pdtdrug/pdtdrug','tPdtIngredient')?></label>
                            <textarea class="form-control" maxlength="200" rows="3" id="otaIngredient" name="otaIngredient"><?=@$tPdtIngredient?></textarea>
                        </div>
                    </div> 
                </div>
            </div>
            <!-- สรรพคุณ -->
            <div id="odvPdtProperties" class="tab-pane fade xCNPdtDrug">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('product/pdtdrug/pdtdrug','tPdtProperties')?></label>
                            <textarea class="form-control" maxlength="200" rows="3" id="otaProperties" name="otaProperties"><?=@$tPdtProperties?></textarea>
                        </div>
                    </div>
                </div>
            </div>   
            <!-- วิธีการใช้/ข้อบ่งชี้ -->
            <div id="odvPdtHowtouse" class="tab-pane fade xCNPdtDrug">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <!-- วิธีการใช้/ข้อบ่งชี้ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('product/pdtdrug/pdtdrug','tPdtHowtouse')?></label>
                            <textarea class="form-control" maxlength="200" rows="3" id="otaHowtouse" name="otaHowtouse"><?=@$tPdtHowtoUse?></textarea>
                        </div>
                        
                        <!-- ปริมาณสูงสุดตามประเภทที่ใช้ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('product/pdtdrug/pdtdrug','tPdtDoseMaximum')?></label>
                            <input 
                                type="text" 
                                class="form-control xCNInputNumericWithDecimal text-right" 
                                id="oetMaximum" 
                                name="oetDoseMaximum" 
                                value="<?php echo @$tPdtDoseMaximum?>" 
                                placeholder = "<?php echo language('product/pdtdrug/pdtdrug','tPdtDoseMaximum');?>"
                            >
                        </div>
                        <!-- ปริมาณที่แนะนำ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('product/pdtdrug/pdtdrug','tPdtMaxintake')?></label>
                            <input 
                                type="text" 
                                class="form-control xCNInputNumericWithDecimal text-right" 
                                id="oetMaxintake" 
                                name="oetMaxintake" 
                                value="<?php echo @$tPdtMaxintake?>" 
                                placeholder = "<?php echo language('product/pdtdrug/pdtdrug','tPdtMaxintake');?>"
                            >
                        </div>
                        <!-- ข้อห้ามในการใช้ยา -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('product/pdtdrug/pdtdrug','tPdtContraindications')?></label>
                            <textarea class="form-control" maxlength="200" rows="3" id="otaContraindications" name="otaContraindications"><?=@$tPdtContraindications?></textarea>
                        </div>
                        <!-- ข้อควรระวัง คำแนะนำข้อห้าม -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('product/pdtdrug/pdtdrug','tPdtCautionAdvice')?></label>
                            <textarea class="form-control" maxlength="200" rows="3" id="otaCautionAdvice" name="otaCautionAdvice"><?=@$tPdtCautionAdvice?></textarea>
                        </div>
                        <!-- หยุดใช้ยาเมื่อ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('product/pdtdrug/pdtdrug','tPdtStopUse')?></label>
                            <textarea class="form-control" maxlength="200" rows="3" id="otaPdtStopUse" name="otaPdtStopUse"><?=@$tPdtStopUse?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- อื่นๆ -->
            <div id="odvPdtOther" class="tab-pane fade xCNPdtDrug">
                <div class="row">    
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <!-- วิธีเก็บรักษา -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('product/pdtdrug/pdtdrug','tPdtHowtoPreserve')?></label>
                            <textarea class="form-control" maxlength="200" rows="3" id="otaHowtoPreserve" name="otaHowtoPreserve"><?=@$tPdtHowtoPreserve?></textarea>
                        </div>

                        <!-- เงื่อนไขควบคุมการจ่ายโดย -->
                        <!-- <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('product/pdtdrug/pdtdrug','tPdtConditionsControl')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNHide" id="oetConditionControlCode" name="oetConditionControlCode" value="<?php echo @$tConditionCode?>">
                                <input type="text" class="form-control xWPointerEventNone" id="oetConditionControlName" name="oetConditionControlName" 
                                placeholder="<?php echo language('product/pdtdrug/pdtdrug','tPdtConditionsControl')?>"
                                value="<?php echo @$tConditionName?>" readonly>
                                <span class="input-group-btn">
                                    <button id="oimBrowseConControl" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div> -->

                        <!-- ผลิตโดย -->
                        <div class="form-group"> 
                            <label class="xCNLabelFrm"><?= language('product/pdtdrug/pdtdrug','tPdtProducedby')?></label>
                            <textarea class="form-control" maxlength="200" rows="3" id="otaProductBy" name="otaProductBy"><?=@$tPdtProducedby?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Get Data PdtCode -->
        <?php 
            $tPdtCode   = $aGetDataPdtCode['tPdtCode'];
        ?>

        <input type="hidden" id="ohdPdtCode" name="ohdPdtCode" value="<?=$tPdtCode?>">

    </div>
</form>




<script>

    var dDatNow    = '<?php echo date('Y-m-d')?>';

    $(document).ready(function(){

        $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            startDate :'1900-01-01',
            disableTouchKeyboard : true,
            autoclose: true
        });

     });

        //ชนิดยา       
       $('#ocmPdtDrugType1').selectpicker();
        
       //รูปแบบยา
       $('#ocmPdtDosage').selectpicker();

       //เงื่อนไขการควบคุมยา
       $('#ocmPdtConditionControl').selectpicker();


       //วันที่ผลิตยา
       $('#obtPdtDrugStartDate').click(function(event){
            $('#oetPdtDrugStartDate').datepicker('show');
            event.preventDefault();
       });


       //วันที่หมดอายุ
       $('#obtPdtDrugExpire').click(function(event){
            $('#oetDrugExpire').datepicker('show');
            event.preventDefault();
       });


</script>

<?php include "script/jDrugMain.php"; ?>
<link rel="stylesheet" href="<?php echo base_url('application/modules/common/assets/css/localcss/ada.component.css')?>">
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script src="<?php echo base_url('application/modules/product/assets/src/pdtdrug/jPdtDrug.js'); ?>"></script>