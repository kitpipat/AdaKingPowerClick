<?php

    // ตรวจสอบโหมดการทำงานว่าเป็น โหมดเพิ่มใหม่ หรือแก้ไข
    if($aResult['rtCode'] == 1){

        $tUsrLogType       	= $aResult['raItems']['FTUsrLogType'];
        $tUsrPwdStart       = $aResult['raItems']['FDUsrPwdStart'];
        $tPwdExpired       	= $aResult['raItems']['FDUsrPwdExpired'];
        $tUsrlogin       	= $aResult['raItems']['FTUsrLogin'];
        
        $tUsrLoginPwd       = $aResult['raItems']['FTUsrLoginPwd'];
        $userlog            = '******'; 
        
        $tRemark      	    = $aResult['raItems']['FTUsrRmk'];
        $tUsrStaActive      = $aResult['raItems']['FTUsrStaActive'];

        //route for edit
        $tRoute         	= "userloginEventEdit";
    }else{
        $tUsrLogType        = "";
        $tUsrPwdStart       = "";
        $tPwdExpired        = "";
        $tUsrlogin          = "";
        
        $tUsrLoginPwd       = "";
        $userlog            = "";
        
        $tRemark            = "";
        $tUsrStaActive      = "";
        //route for add
        $tRoute             = "userloginEventAdd";
    }

?>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddEditUserLogin">
    <input type="hidden" value="<?php echo $tRoute; ?>" id="ohdTRoute">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <label class="xCNLabelFrm" style="color: #179bfd !important; cursor:pointer;" onclick="JSxUsrloginGetContent();" ><?php echo language('authen/user/user','tDetailLogin')?></label>
            <label class="xCNLabelFrm">
            <label class="xCNLabelFrm xWPageAdd" style="color: #aba9a9 !important;"> / <?php echo language('authen/user/user','tUsrloginAdd')?> </label> 
            <label class="xCNLabelFrm xWPageEdit hidden" style="color: #aba9a9 !important;"> / <?php echo language('authen/user/user','tUsrloginEdit')?> </label>   
        </div>

        <!--ปุ่มเพิ่ม-->
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  text-right">
            <button type="button" onclick="JSxUsrloginGetContent();" class="btn" style="background-color: #D4D4D4; color: #000000;">
                <?php echo language('common/main/main', 'tCancel')?>
            </button>
                <?php //if($aAlwEventUsrlogin['tAutStaFull'] == 1 || ($aAlwEventUsrlogin['tAutStaAdd'] == 1 || $aAlwEventUsrlogin['tAutStaEdit'] == 1)) : ?>
                    <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" id="obtUsrloginSave" onclick="JSxUSRLSaveAddEdit('<?=$tRoute?>')"> <?php echo  language('common/main/main', 'tSave')?></button>
                <?php //endif; ?>
            </div>
    

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            
            <!-- End GenCode -->
            <!-- <div class="col-lg-6 col-md-6 col-xs-6"> -->
           

                 <!-- ประเภทการเข้าใช้งาน -->
                 <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('authen/user/user','tLoginType')?></label>
                 
                    <!-- Witsarut 19/08/2019-->
                    <!-- กรณีเปลี่ยนประเภทการเข้าใช้งานรูปแบบการกรอกข้อมูล Username/Password จะเปลี่ยนไปดังนี้
                        1 รหัสผ่าน ให้กรอก ชื่อผู้ใช้ และ รหัสผ่าน
                        2 PIN ให้กรอกเบอร์โทรศัพท์ และ PIN
                        3 RFID ให้กรอก RFID Code และทำการ Coppy ไปลงคอลัม รหัสผ่าน(Password)
                        4 QR ให้กรอก QR Code และทำการ Coppy ไปลงคอลัม รหัสผ่าน(Password) 
                        Validate รูปแบบการเลือกที่ Function JSxCURCheckLoginTypeUsed
                    -->

                    <?php if(isset($tUsrLogType) && !empty($tUsrLogType)){ ?>
                        <input type="hidden" id="ohdTypeAddloginType" name="ohdTypeAddloginType" value="1">
                        <input type="hidden" id="ohdTypeAddloginTypeVal" name="ohdTypeAddloginTypeVal" value="<?php echo $tUsrLogType ?>">
                        <select class="selectpicker form-control" id="ocmlogintype" name="ocmlogintype" maxlength="1" onchange="JSxUSRLCheckLoginTypeUsed('insert')" 
                            <?=  "disabled"?>>
                            <option value = "1" <?= (!empty($tUsrLogType) && $tUsrLogType == '1')? "selected":""?>>
                                <?php echo language('authen/user/user','tTypePwd');?>
                            </option>
                            <option value = "2" <?= (!empty($tUsrLogType) && $tUsrLogType == '2')? "selected":""?>>
                                <?php echo language('authen/user/user','tTypePin');?>
                            </option>
                            <option value = "3" <?= (!empty($tUsrLogType) && $tUsrLogType == '3')? "selected":""?>>
                                <?php echo language('authen/user/user','tTypeRFID');?>
                            </option>
                            <option value = "4" <?= (!empty($tUsrLogType) && $tUsrLogType == '4')? "selected":""?>>
                                <?php echo language('authen/user/user','tTypeQR');?>
                            </option>
                        </select>
                    <?php }else{ ?>
                        <input type="hidden" id="ohdTypeAddloginType" name="ohdTypeAddloginType" value="0">
                        <select class="selectpicker form-control" id="ocmlogintype" name="ocmlogintype" maxlength="1" onchange="JSxUSRLCheckLoginTypeUsed('insert')">
                            <option value = "1">
                                <?php echo language('authen/user/user','tTypePwd');?>
                            </option>
                            <option value = "2">
                                <?php echo language('authen/user/user','tTypePin');?>
                            </option>
                            <option value = "3">
                                <?php echo language('authen/user/user','tTypeRFID');?>
                            </option>
                            <option value = "4">
                                <?php echo language('authen/user/user','tTypeQR');?>
                            </option>
                        </select>
                    <?php } ?>
                 </div>

                <!-- *รหัสพนักงาน -->
                <div class="form-group" id="odvUSRLLoginID">

                    <label class="xCNLabelFrm XCNShow" id="olbUSRLLocinAcc">
                        <span class="text-danger">*</span>
                        <?= language('authen/user/user','tUsrloginAcc'); ?>
                    </label>

                    <!-- เบอร์โทรศัพท์ -->  
                    <label class="xCNLabelFrm XCNHide" id="olbUSRLTelNo">
                        <span class="text-danger">*</span>
                        <?= language('authen/user/user','tUsrTelNo'); ?>
                    </label>

                    <!-- RFID -->
                    <label class="xCNLabelFrm XCNHide" id="olbUSRLRFID">
                        <span class="text-danger">*</span>
                        <?= language('authen/user/user','tTypeRFID'); ?>
                    </label>

                    <!-- QR Code -->
                    <label class="xCNLabelFrm XCNHide" id="olbUSRLQRCode">
                        <span class="text-danger">*</span>
                        <?= language('authen/user/user','tTypeQR'); ?>
                    </label>

                    <input type="text" class="form-control"
                        id= "oetidUsrlogin"
                        name="oetidUsrlogin"
                        maxlength="30"
                        autocomplete="off"
                        value="<?php 
                            echo $tUsrlogin; 
                        ?>" 
                        placeholder="<?php echo language('authen/user/user','tUsrloginAcc')?>"
                        data-validate-required = "<?= language('authen/user/user','tValiUsrloginAcc')?> "
                       <?= (isset($tUsrLogType) && !empty($tUsrLogType))? "readonly":""?>
                    >
                </div>

                <!-- *รหัสผ่าน -->
                <div class="form-group" id="odvUSRLPwsPanel">

                    <!-- *รหัสผ่าน -->
                    <label class="xCNLabelFrm XCNShow" id="olbUSRLPassword">
                        <span class="text-danger">*</span>
                        <?= language('authen/user/user','tUsrloginPwd'); ?>
                    </label>

                    <!-- *PIN -->
                    <label class="xCNLabelFrm XCNHide" id="olbUSRLPin">
                        <span class="text-danger">*</span>
                        <?= language('authen/user/user','tTypePin'); ?>
                    </label>

                    <!-- Update การเข้ารหัส -->
                    <!-- Create By Witsarut 1/09/2019 -->
                    <input type="hidden" 
                            id="oetUsrloginPasswordOld" 
                            name="oetUsrloginPasswordOld" 
                            placeholder="<?= language('authen/user/user','tUSREnCode')?>"
                            value="<?=$tUsrLoginPwd?>"
                    >

                    <!-- ตรวจสอบ รหัสซ้ำ 13/03/2020 Saharat --> 
                    <input type="hidden" 
                            id="oetUsrloginPasswordCheck" 
                            name="oetUsrloginPasswordCheck" 
                            placeholder="<?= language('authen/user/user','tUSREnCode')?>"
                            value="<?=$tUsrLoginPwd?>"
                    >

                    <!-- Update การเข้ารหัส -->
                    <!-- Create By Witsarut 1/09/2019 -->
                    <input type="password" 
                            class="form-control xWCanEnterkeyDegit" 
                            autocomplete="off" 
                            onblur="JSxCheckDegitPassword(this)"
                            id="oetidUsrlogPw" 
                            name="oetidUsrlogPw" 
                            maxlength="50"  
                            value = "<?=$tUsrLoginPwd?>"
                            placeholder="<?php echo language('authen/user/user','tUsrloginPwd')?>"
                            data-validate-required = "<?php echo language('authen/user/user','tValiUsrloginPass')?>"
                            <?= (isset($tUsrLogType) && !empty($tUsrLogType) && ($tUsrLogType == 3 || $tUsrLogType == 4))? "readonly":""?>
                    >
                    <span id="ospChkTypePassword" style="float:right; color: #f95353 !important;"><?php echo language('authen/user/user', 'tCheckDegitPassword');?></span>
                    <span id="ospChkTypePin" style="float:right; color: #f95353 !important;"><?php echo language('authen/user/user', 'tCheckUsrloginDegitPin');?></span>
                </div>
                <div class="row"></div>

                <?php
                    //Time Start
                    if(isset($tUsrPwdStart)){
                        $aPasswordStart = explode(" ",$tUsrPwdStart);
                       if(isset($aPasswordStart[1])) {
                         $tUsrtimestart  = substr($aPasswordStart[1],0,8);
                       }else{
                           $tUsrtimestart = "";
                       }
                    }else{
                        $tUsrtimestart = "";
                    }
                ?>

                <!-- วันที่เริ่ม และ วันที่สิ้นสุด -->
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">	
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('authen/user/user','tDateStart');?></label>
                            <div class="input-group">
                                <input type="text" style="display:none" id="oetUsrtimestart" name="oetUsrtimestart" value="<?php echo $tUsrtimestart;?>">
                                <input type="text" style="display:none" id="oetUsrtimestartOld" name="oetUsrtimestartOld" value="<?php echo $tUsrtimestart;?>">
                                <input type="hidden" class="form-control xCNDatePicker" id="oetUsrlogStartOld" name="oetUsrlogStartOld" value="<?php if($tUsrPwdStart != ""){ echo date_format(date_create($tUsrPwdStart),"Y-m-d"); }else{ echo date_format(date_create($dGetDataNow),"Y-m-d"); }?>" >
                                <input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-left" id="oetUsrlogStart" name="oetUsrlogStart" value="<?php if($tUsrPwdStart != ""){ echo date_format(date_create($tUsrPwdStart),"Y-m-d"); }else{ echo date_format(date_create($dGetDataNow),"Y-m-d"); }?>" >
                                <span class="input-group-btn">
                                    <button id="obtUsrlogStart" type="button" class="btn xCNBtnDateTime">
                                        <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <?php
                        //Time Expire
                        if(isset($tPwdExpired)){
                            $aPasswordExpire = explode(" ",$tPwdExpired);
                        if(isset($aPasswordExpire[1])) {
                            $tUsrtimesExpire  = substr($aPasswordExpire[1],0,8);
                        }else{
                            $tUsrtimesExpire = "";
                        }
                        }else{
                            $tUsrtimesExpire = "";
                        }
                    ?>

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">	
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('authen/user/user','tDateStop')?></label>
                            <div class="input-group">
                                <input type="text" style="display:none" id="oetUsrtimeExpire" name="oetUsrtimeExpire" value="<?php echo $tUsrtimesExpire;?>">
                                <input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-left" id="oetUsrlogStop" name="oetUsrlogStop" value="<?php if($tPwdExpired != ""){ echo date_format(date_create($tPwdExpired),"Y-m-d"); }else{ echo date_format(date_create($dGetDataFuture),"Y-m-d"); }?>">
                                <span class="input-group-btn">
                                    <button id="obtUsrlogStop" type="button" class="btn xCNBtnDateTime">
                                        <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('authen/user/user','tUSRLRemark'); ?></label>
                    <textarea class="form-group" rows="4" maxlength="100" id="oetUsrlogRemark" name="oetUsrlogRemark" autocomplete="off"   placeholder="<?php echo language('authen/user/user','tUSRLRemark')?>"><?php echo $tRemark;?></textarea>
                </div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('authen/user/user','tStaActiveNew')?></label>
                    <select class="selectpicker form-control" id="ocmUsrlogStaUse" name="ocmUsrlogStaUse" maxlength="1">
                        <option value="1" <?php echo ($tUsrStaActive == '1' ? 'selected' : '') ?>><?php echo language('authen/user/user','tStaActiveNew1');?></option>
                        <option value="3" <?php echo ($tUsrStaActive == '3' || $tRoute == "userloginEventAdd" ? 'selected' : '') ?>><?php echo language('authen/user/user','tStaActiveNew3');?></option>
                        <option value="2" <?php echo ($tUsrStaActive == '2' ? 'selected' : '') ?>><?php echo language('authen/user/user','tStaActiveNew2');?></option>
                    </select>
                    <!-- <label class="fancy-checkbox">
                        <input type="checkbox" name="ocbUsrlogStaUse" <?php 
                        if($tRoute=="userloginEventAdd"){
                            echo "checked";
                        }else{
                            echo ($tUsrStaActive == '1') ? "checked" : ''; 
                        } ?> value="1">
                        <span> <?php echo language('authen/user/user','tStaActive'); ?></span>
                    </label> -->
                </div>
            </div>
        </div>
    </div>
        <!--USer  ที่กำลังจะสร้างข้อมูลล็อกอิน -->
        <?php 
            $tUsrCode    = $aUsrCodeSetAuthen['tUsrCode'];
        ?>
        <input type="hidden" id="ohdUsrLogCode" name="ohdUsrLogCode" value="<?=$tUsrCode?>">
        <input type="hidden" id="ohdValidateDuplicate" name="ohdValidateDuplicate" value="0"><!-- 0 คือ ไม่เกิด validate  และ 1 เกิด validate -->
</form>

<script>

    $('document').ready(function(){
        $('#ospChkTypePassword').hide();
        $('#ospChkTypePin').hide();
    });


    if("<?php echo $aResult['rtCode'];?>" == 1){
        var tUsrLogType  = '<?php  echo $tUsrLogType;?>';
        $('#ocmlogintype').val(tUsrLogType);
        JSxUSRLCheckLoginTypeUsed('edit');
    }

    $('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        startDate: new Date(),
    });


    $('.xWCanEnterkeyDegit').on('keypress',function(){
        $('#ospChkTypePassword').hide();
        $('#ospChkTypePin').hide();
    });

    //function check degit Pin And Passsword
    // Create By Witsarut 24062020
    function JSxCheckDegitPassword(e){
        var nLen = $('#oetidUsrlogPw').val();
        var nPassword   = nLen.length;
        var nTypeLogin  = $('#ocmlogintype').val();

       if(nTypeLogin == 1){
            if(nPassword < 8){
                $('#ospChkTypePassword').show();
                return 1;
            }else{
                $('#ospChkTypePassword').hide();
            }
       }else if(nTypeLogin == 2){
            if(nPassword != 6){
                $('#ospChkTypePin').show();
                return 1;
            }else{
                $('#ospChkTypePin').hide();
            }
        }
    }



</script>

<?php include "script/jUserloginMain.php"; ?>
<link rel="stylesheet" href="<?php echo base_url('application/modules/common/assets/css/localcss/ada.component.css')?>">
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>