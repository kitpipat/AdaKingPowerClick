<?php
    
    // ตรวจสอบโหมดการทำงานว่าเป็น โหมดเพิ่มใหม่ หรือแก้ไข

    if($aResult['rtCode'] == "1"){
        
        $tManLogType       	= $aResult['raItems']['FTManLogType'];
        $tManPwdStart       = $aResult['raItems']['FDManPwdStart'];
        $tPwdExpired       	= $aResult['raItems']['FDManPwdExpired'];
        $tManlogin       	= $aResult['raItems']['FTManLogin'];
        $tRemark      	    = $aResult['raItems']['FTManRmk'];
        $tManStaActive      = $aResult['raItems']['FTManStaActive'];
                
        $tManLoginPwd       = $aResult['raItems']['FTManLoginPwd'];

        $tCurlog            = '******';

        //route for edit
        $tRoute         	= "courierloginEventEdit";

             //Event Control
             if(isset($aAlwEventCURL)){
                if($aAlwEventCURL['tAutStaFull'] == 1 || $aAlwEventCURL['tAutStaEdit'] == 1){
                    $nAutStaEdit = 1;
                }else{
                    $nAutStaEdit = 0;
                }
            }else{
                $nAutStaEdit = 0;
            }

    }else{

        $tManLogType        = "";
        $tManPwdStart       = "";
        $tPwdExpired        = "";
        $tManlogin          = "";
        $tRemark            = "";
        $tManStaActive      = "";
        
        $tManLoginPwd       = "";
        $tCurlog            = "";

        //route for add
        $tRoute             = "courierloginEventAdd";
        $nAutStaEdit        = 0; //Event Control
    }

?>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddEditCourierManLogin">
<input type="hidden" value="<?php echo $tRoute; ?>" id="ohdTRoute">
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <label class="xCNLabelFrm" style="color: #179bfd !important; cursor:pointer;" onclick="JSxCMLGetContent();" ><?php echo language('courier/courier/courier','tDetailLogin')?></label>
        <label class="xCNLabelFrm">
        <label class="xCNLabelFrm xWPageAdd" style="color: #aba9a9 !important;"> / <?php echo language('courier/courier/courier','tCurloginAdd')?> </label> 
        <label class="xCNLabelFrm xWPageEdit hidden" style="color: #aba9a9 !important;"> / <?php echo language('courier/courier/courier','tCurloginEdit')?> </label>   
    </div>

    <!--ปุ่มเพิ่ม-->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  text-right">
        <button type="button" onclick="JSxCMLGetContent();" class="btn" style="background-color: #D4D4D4; color: #000000;">
            <?php echo language('company/shopgpbypdt/shopgpbypdt', 'tSGPPBTNCancel')?>
        </button>
            <?php if($aAlwEventCURL['tAutStaFull'] == 1 || ($aAlwEventCURL['tAutStaAdd'] == 1 || $aAlwEventCURL['tAutStaEdit'] == 1)) : ?>
                <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" id="obtGpShopBySHPSave" onclick="JSxCMLSaveAddEdit('<?=$tRoute?>')"> <?php echo  language('common/main/main', 'tSave')?></button>
            <?php endif; ?>
        </div>
    </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

        <!-- End GenCode -->
        <div class="col-lg-6 col-md-6 col-xs-6">
            <div class="form-group">
            </div>

             <!-- ประเภทการเข้าใช้งาน -->
             <div class="form-group">
                <label class="xCNLabelFrm"><?=language('courier/courier/courier','tLoginType')?></label>

                <!-- Kitpipat 18/08/2019-->
                <!-- กรณีเปลี่ยนประเภทการเข้าใช้งานรูปแบบการกรอกข้อมูล Username/Password จะเปลี่ยนไปดังนี้
                     1 รหัสผ่าน ให้กรอก ชื่อผู้ใช้ และ รหัสผ่าน
                     2 PIN ให้กรอกเบอร์โทรศัพท์ และ PIN
                     3 RFID ให้กรอก RFID Code และทำการ Coppy ไปลงคอลัม รหัสผ่าน(Password)
                     4 QR ให้กรอก QR Code และทำการ Coppy ไปลงคอลัม รหัสผ่าน(Password) 
                     Validate รูปแบบการเลือกที่ Function JSxCURCheckLoginTypeUsed
                 -->
                
                <?php
                if(isset($tManLogType) && !empty($tManLogType)){
                ?>
                 <input type="hidden" id="ohdTypeAddloginType" name="ohdTypeAddloginType" value="1">
                 <input type="hidden" id="ohdTypeAddloginTypeVal" name="ohdTypeAddloginTypeVal" value="<?php echo $tManLogType ?>">
                 <select class="selectpicker form-control" id="ocmlogintype" name="ocmlogintype" maxlength="1" onchange="JSxCLICheckLoginTypeUsed('insert')" 
                    <?=  "disabled"?>>
                    <option value = "1" <?= (!empty($tManLogType) && $tManLogType == '1')? "selected":""?>>
                        <?php echo language('courier/courier/courier','tTypePwd');?>
                    </option>
                    <option value = "2" <?= (!empty($tManLogType) && $tManLogType == '2')? "selected":""?>>
                        <?php echo language('courier/courier/courier','tTypePin');?>
                    </option>
                    <option value = "3" <?= (!empty($tManLogType) && $tManLogType == '3')? "selected":""?>>
                        <?php echo language('courier/courier/courier','tTypeRFID');?>
                    </option>
                    <option value = "4" <?= (!empty($tManLogType) && $tManLogType == '4')? "selected":""?>>
                        <?php echo language('courier/courier/courier','tTypeQR');?>
                    </option>
                </select>
                <?php
                }else{
                ?>
                <input type="hidden" id="ohdTypeAddloginType" name="ohdTypeAddloginType" value="0">
                <select class="selectpicker form-control" id="ocmlogintype" name="ocmlogintype" maxlength="1" onchange="JSxCLICheckLoginTypeUsed('insert')">
                    <option value = "1">
                        <?php echo language('courier/courier/courier','tTypePwd');?>
                    </option>
                    <option value = "2">
                        <?php echo language('courier/courier/courier','tTypePin');?>
                    </option>
                    <option value = "3">
                        <?php echo language('courier/courier/courier','tTypeRFID');?>
                    </option>
                    <option value = "4">
                        <?php echo language('courier/courier/courier','tTypeQR');?>
                    </option>
                </select>
                <?php
                }
                ?>
                
            </div>
            
            <!-- *รหัสพนักงาน -->
            <div class="form-group" id="odvCLILoginID">

                <label class="xCNLabelFrm XCNShow" id="olbCLILocinAcc">
                       <span class="text-danger">*</span>
                       <?= language('courier/courier/courier','tCurloginAcc'); ?>
                </label>

                <!-- เบอร์โทรศัพท์ -->
                <label class="xCNLabelFrm XCNHide" id="olbCLITelNo">
                       <span class="text-danger">*</span>
                       <?= language('courier/courier/courier','tCurTelNo'); ?>
                </label>

                <!-- RFID -->
                <label class="xCNLabelFrm XCNHide" id="olbCLIRFID">
                       <span class="text-danger">*</span>
                       <?= language('courier/courier/courier','tTypeRFID'); ?>
                </label>

                <!-- QR Code -->
                <label class="xCNLabelFrm XCNHide" id="olbCLIQRCode">
                       <span class="text-danger">*</span>
                       <?= language('courier/courier/courier','tTypeQR'); ?>
                </label>

           
                <input type="text" class="form-control" 
                    id="oetidCurlogin" 
                    name="oetidCurlogin" 
                    maxlength="30" 
                    autocomplete="off"
                    value="<?php 
                        echo $tManlogin;
                    ?>"  
                    placeholder="<?php echo language('courier/courier/courier','tCurloginAcc')?>"
                    data-validate-required = "<?= language('courier/courier/courier','tValiCurloginAcc')?> "
                    <?= (isset($tManLogType) && !empty($tManLogType))? "readonly":""?>
                >

            </div>

            <!-- *รหัสผ่าน -->
            <div class="form-group" id="odvCLIPwsPanel">

                 <!-- *รหัสผ่าน -->
                 <label class="xCNLabelFrm XCNShow" id="olbCLIPassword">
                   <span class="text-danger">*</span>
                   <?= language('courier/courier/courier','tCurloginPwd'); ?>
                </label>

                <!-- *PIN -->
                <label class="xCNLabelFrm XCNHide" id="olbCLIPin">
                   <span class="text-danger">*</span>
                   <?= language('courier/courier/courier','tTypePin'); ?>
                </label>

                <!-- Update การเข้ารหัส -->
                <!-- Create By Witsarut 1/09/2019 -->
                <input type="hidden" 
                    id="oetCurloginPasswordOld" 
                    name="oetCurloginPasswordOld" 
                    placeholder="<?= language('authen/user/user','tUSRPassword')?>"
                    value=""
                >
                
                <!-- Create By Witsarut 1/09/2019 -->

                <input type="password" 
                       class="form-control" 
                       autocomplete="off" 
                       id="oetidCurlogPw" 
                       name="oetidCurlogPw" 
                       maxlength="30"  
                       value = "<?=$tCurlog?>"
                       placeholder="<?php echo language('courier/courier/courier','tCurloginPwd')?>"
                       data-validate-required = "<?php echo language('courier/courier/courier','tValiCurloginAcc')?>"
                       <?= (isset($tManLogType) && !empty($tManLogType) && ($tManLogType == 3 || $tManLogType == 4))? "readonly":""?>
                >
            </div>

            <!--  Update TimeStamp -->
            <!-- Create By Witsarut 09/09/2019 -->
            <?php
                //Time Start
                if(isset($tManPwdStart)){
                    $aPasswordStart = explode(" ",$tManPwdStart);
                    if(isset($aPasswordStart[1])) {
                        $tCurtimestart  = substr($aPasswordStart[1],0,8);
                    }else{
                        $tCurtimestart = "";
                    }
                }else{
                    $tCurtimestart = "";
                }
            ?>
           	
            <!-- วันที่เริ่ม และ วันที่สิ้นสุด -->
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">	
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tDateStart');?></label>
                        <div class="input-group">
                            <input type="text" style="display:none" id="oetCurtimestart" name="oetCurtimestart" value="<?php echo $tCurtimestart;?>">
                            <input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-left" id="oetCurlogStart" name="oetCurlogStart" value="<?php if($tManPwdStart != ""){ echo $tManPwdStart;}else{echo $dGetDataNow;}?>" >
                            <span class="input-group-btn">
                                <button id="obtCurlogStart" type="button" class="btn xCNBtnDateTime">
                                    <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>

                <!--  Update TimeStamp -->
                <!-- Create By Witsarut 09/09/2019 -->
                <?php
                    //Time Expire
                    if(isset($tPwdExpired)){
                        $aPasswordExpire = explode(" ",$tPwdExpired);
                    if(isset($aPasswordExpire[1])) {
                        $tCurtimesExpire  = substr($aPasswordExpire[1],0,8);
                    }else{
                        $tCurtimesExpire = "";
                    }
                    }else{
                        $tCurtimesExpire = "";
                    }
                ?>

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">	
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tDateStop')?></label>
                        <div class="input-group">
                            <input type="text" style="display:none" id="oetCurtimeexpire" name="oetCurtimeexpire" value="<?php echo $tCurtimesExpire;?>">
                            <input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-left" id="oetCurlogStop" name="oetCurlogStop" value="<?php if($tPwdExpired != ""){ echo $tPwdExpired;}else{echo $dGetDataFuture;}?>">
                            <span class="input-group-btn">
                                <button id="obtCurlogStop" type="button" class="btn xCNBtnDateTime">
                                    <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="xCNLabelFrm"><?= language('courier/courier/courier','tCURLRemark'); ?></label>
                <textarea class="form-group" rows="4" maxlength="100" id="oetCurlogRemark" name="oetCurlogRemark" autocomplete="off"   placeholder="<?php echo language('courier/courier/courier','tCURLRemark')?>"><?php echo $tRemark;?></textarea>
            </div>

            <div class="form-group">
                <label class="fancy-checkbox">
                    <input type="checkbox" name="ocbCurlogStaUse" <?php 
                    if($tRoute=="courierloginEventAdd"){
                        echo "checked";
                    }else{
                        echo ($tManStaActive == '1') ? "checked" : ''; 
                    } ?> value="1">
                    <span> <?php echo language('courier/courier/courier','tStaActive'); ?></span>
                </label>
            </div>

        </div>
    
    </div>
</div>

<!--Courier Man ที่กำลังจะสร้างข้อมูลล็อกอิน -->
<?php 
    // Debug
    //var_dump($aCryManInfo);
    $tCryLogCode    = $aCryManInfo['tCryCode'];
    $tCryManCardID  = $aCryManInfo['tCryManCardID'];
?>
<input type="hidden" id="ohdCryLogCode" name="ohdCryLogCode" value="<?=$tCryLogCode?>">
<input type="hidden" id="ohdCryLogCryManCardID" name="ohdCryLogCryManCardID" value="<?=$tCryManCardID?>">
<input type="hidden" id="ohdValidateDuplicate" name="ohdValidateDuplicate" value="0"><!-- 0 คือ ไม่เกิด validate  และ 1 เกิด validate -->
</form>

<script>
    if("<?php echo $aResult['rtCode'];?>" == 1){
        var tManLogType  = '<?php  echo $tManLogType;?>';
        $('#ocmlogintype').val(tManLogType);
        JSxCLICheckLoginTypeUsed('edit');
    }
</script>

<?php include "script/jCourierloginMain.php"; ?>
<link rel="stylesheet" href="<?php echo base_url('application/modules/common/assets/css/localcss/ada.component.css')?>">
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
