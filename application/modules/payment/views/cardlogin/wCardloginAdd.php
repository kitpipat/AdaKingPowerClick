<style>

    .wCNInnerPDT{
        width           : 90%;
        height          : 90%;
        border-radius   : 2px;
        top             : 5%;
        left            : 5%;
        background      : #D8D8D8 ;
        position        : absolute;
    }

    .wCNOuterPDT{
        border-radius   : 2px;
        width           : 200px !important;
        height          : 200px !important;
        border          : 2px solid #D8D8D8 ;
        background      : #FFF;
        margin          : 4px;
        position        : relative;
        display         : inline-block;
    }

    .wCNOuterPDT:hover{
        border-color    : #0081c2;
    }

    .wCNOuterPDT:hover .wCNInnerPDT{
        background      : #0081c2; 
        cursor          : pointer;
    }

    .wCNFontInsertPDT{
        display         : block;
        margin          : 16% 20%;
        text-align      : center;
        font-size       : 4.5rem !important;
    }

    .wCNOuterPDT:hover .wCNFontInsertPDT{
        color           : #FFF;
    }

    .xCNBtnDelete{
        background-color: #f36767;
        border-radius   : 50px;
        width           : 20px;
        height          : 20px;
        position        : absolute;
        z-index         : 99;
        right           : -10px;
        top             : -10px;
        display         : none;
        color           : #FFF;
        border          : 1px solid #f17575;
        box-shadow      : 2px 2px 3px 0px rgb(173, 173, 173);
    }

    .xCNBtnDeleteShow{
        display         : block;
        cursor          : pointer;
    }

    .xCNFontBtnDelete{
        text-align      : center;
        display         : block;
        font-size       : 0.8rem !important;
        font-weight     : bold;
    }

</style>


<?php
    if($aResult['rtCode'] == 1){
        $tCrdLogType       	= $aResult['raItems']['FTCrdLogType'];
        $tCrdPwdStart       = $aResult['raItems']['FDCrdPwdStart'];
        $tCrdExpired       	= $aResult['raItems']['FDCrdPwdExpired'];
        $tCrdlogin       	= $aResult['raItems']['FTCrdLogin'];

        $tCrdLoginPwd       = $aResult['raItems']['FTCrdLoginPwd'];
        $Crdlog             = '******';

        $tRemark      	    = $aResult['raItems']['FTCrdRmk'];
        $tCrdStaActive      = $aResult['raItems']['FTCrdStaActive'];

        //route for edit
        $tRoute         	= "cardloginEventEdit";
    }else{

        $tCrdLogType        = "";
        $tCrdPwdStart       = "";
        $tCrdExpired        = "";
        $tCrdlogin          = "";

        $tCrdLoginPwd       = "";
        $Crdlog             = "";

      
        $tRemark            = "";
      

        $tCrdStaActive      = "";

        //route for add
        $tRoute             = "cardloginEventAdd";
    }
?>

<!--  ที่กำลังจะสร้างข้อมูลล็อกอิน -->
<?php 
    $tCrdCode    = $aCrdCode['tCrdCode'];
?>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddEditCrdLogin">
    <input type="hidden" value="<?php echo $tRoute; ?>" id="ohdTRoute">

    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <label class="xCNLabelFrm" style="color: #179bfd !important; cursor:pointer;" onclick="JSxCrdloginGetContent();" ><?php echo language('payment/cardlogin/cardlogin','tDetailLogin')?></label>
            <label class="xCNLabelFrm">
            <label class="xCNLabelFrm xWPageAdd" style="color: #aba9a9 !important;"> / <?php echo language('payment/cardlogin/cardlogin','tCrdloginAdd')?> </label> 
            <label class="xCNLabelFrm xWPageEdit" style="color: #aba9a9 !important;"> / <?php echo language('payment/cardlogin/cardlogin','tCrdloginEdit')?> </label>   
        </div>

        <!--ปุ่มเพิ่ม-->
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  text-right">
            <button type="button" onclick="JSxCrdloginGetContent();" class="btn" style="background-color: #D4D4D4; color: #000000;">
                <?php echo language('common/main/main', 'tCancel')?>
            </button>
            <?php if($aAlwEventCrdlogin['tAutStaFull'] == 1 || ($aAlwEventCrdlogin['tAutStaAdd'] == 1 || $aAlwEventCrdlogin['tAutStaEdit'] == 1)) : ?>
                <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" id="obtCrdloginSave" onclick="JSxCrdSaveAddEdit('<?=$tRoute?>')"> <?php echo  language('common/main/main', 'tSave')?></button>
            <?php endif; ?>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

            <!-- ประเภทการเข้าใช้งาน -->
            <div class="form-group">
                <label class="xCNLabelFrm"><?=language('payment/cardlogin/cardlogin','tLoginType')?></label>

                <!-- Witsarut 19/08/2019-->
                <!-- กรณีเปลี่ยนประเภทการเข้าใช้งานรูปแบบการกรอกข้อมูล Username/Password จะเปลี่ยนไปดังนี้
                    1 รหัสผ่าน ให้กรอก ชื่อผู้ใช้ และ รหัสผ่าน
                    2 PIN ให้กรอกเบอร์โทรศัพท์ และ PIN
                    3 RFID ให้กรอก RFID Code และทำการ Coppy ไปลงคอลัม รหัสผ่าน(Password)
                    4 QR ให้กรอก QR Code และทำการ Coppy ไปลงคอลัม รหัสผ่าน(Password) 
                    Validate รูปแบบการเลือกที่ Function JSxCURCheckLoginTypeUsed
                -->

                <?php if(isset($tCrdLogType) && !empty($tCrdLogType)){ ?>

                    <input type="hidden" id="ohdTypeAddloginType" name="ohdTypeAddloginType" value="1">
                    <input type="hidden" id="ohdTypeAddloginTypeVal" name="ohdTypeAddloginTypeVal" value="<?php echo $tCrdLogType ?>">

                    <input type="hidden" id="ocmlogintypeEdit" name="ocmlogintypeEdit" value="<?php echo $tCrdLogType ?>">

                    <select class="selectpicker form-control" id="ocmlogintype" name="ocmlogintype" maxlength="1" onchange="JSxCRDLCheckLoginTypeUsed('insert')" 
                        <?=  "disabled"?>>
                        <option value = "0" <?=(!empty($tCrdLogType) && $tCrdLogType == '0')? "selected":""?>>
                            <?php echo language('payment/cardlogin/cardlogin', 'tCrdTypeNotCheck');?>
                        </option>
                        <option value = "1" <?= (!empty($tCrdLogType) && $tCrdLogType == '1')? "selected":""?>>
                            <?php echo language('payment/cardlogin/cardlogin','tCrdTypePwd');?>
                        </option>
                        <option value = "2" <?= (!empty($tCrdLogType) && $tCrdLogType == '2')? "selected":""?>>
                            <?php echo language('payment/cardlogin/cardlogin','tCrdTypePin');?>
                        </option>
                        <option value = "3" <?= (!empty($tCrdLogType) && $tCrdLogType == '3')? "selected":""?>>
                            <?php echo language('payment/cardlogin/cardlogin','tCrdTypeRFID');?>
                        </option>
                        <option value = "4" <?= (!empty($tCrdLogType) && $tCrdLogType == '4')? "selected":""?>>
                            <?php echo language('payment/cardlogin/cardlogin','tCrdTypeQR');?>
                        </option>
                        <option value = "5" <?=  (!empty($tCrdLogType) && $tCrdLogType == '5')? "selected":""?>>
                            <?php echo language('payment/cardlogin/cardlogin','tCrdTypeFace');?>
                        </option>
                    </select>

                <?php }else{ ?>
                    <input type="hidden" id="ocmlogintypeEdit" name="ocmlogintypeEdit" value="<?php echo $tCrdLogType ?>">
                    <input type="hidden" id="ohdTypeAddloginType" name="ohdTypeAddloginType" value="0">
                    <select class="selectpicker form-control" id="ocmlogintype" name="ocmlogintype" maxlength="1" onchange="JSxCRDLCheckLoginTypeUsed('insert')">
                        <option value = "0">
                            <?php echo language('payment/cardlogin/cardlogin', 'tCrdTypeNotCheck');?>
                        </option>
                        <option value = "1">
                            <?php echo language('payment/cardlogin/cardlogin','tCrdTypePwd');?>
                        </option>
                        <option value = "2">
                            <?php echo language('payment/cardlogin/cardlogin','tCrdTypePin');?>
                        </option>
                        <option value = "3">
                            <?php echo language('payment/cardlogin/cardlogin','tCrdTypeRFID');?>
                        </option>
                        <option value = "4">
                            <?php echo language('payment/cardlogin/cardlogin','tCrdTypeQR');?>
                        </option>
                        <option value = "5">
                            <?php echo language('payment/cardlogin/cardlogin','tCrdTypeFace');?>
                        </option>
                    </select>
                <?php } ?>
            </div>
                

            <!-- Panal face -->
            <div class="form-group" id="odvCRDFace">
                <!-- สแกนใบหน้า -->
                <label class="xCNLabelFrm XCNHide" id="olbCRDLLocinFace">
                    <!-- <?php //echo language('payment/cardlogin/cardlogin', 'tCrdTypeFace');?> -->
                </label>

                <!-- ------------Do Something----------------- -->

                <!--  Browser Face ที่นี้ -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:0px;">>
                    <div id="odvTabRegisFace"></div>
                </div>

                <!-- ซ่อนไว้เพื่อเก็บ รหัสFace ที่ get มาจากบัตร -->
                <input type="hidden" class="form-control"
                    id="oetFaceCode"
                    name="oetFaceCode"
                    maxlength="5"
                    autocomplete="off"
                    value="<?php echo $tCrdCode;?>"
                    placeholder="<?php echo language('payment/cardlogin/cardlogin','tCrdCode')?>"
                >
                <!-- ------------Do Something----------------- -->
            </div>    



            <div class="form-group" id="odvCRDCardCode">
                <!-- รหัสบัตร -->
                <label class="xCNLabelFrm XCNShow" id="olbCRDLLocinCardCode">
                    <span class="text-danger">*</span>
                    <?= language('payment/cardlogin/cardlogin','tCrdCode'); ?>
                </label>

                <?php
                    if($tRoute == "cardloginEventAdd"){
                        $tReadOnly   = '';
                    }else{
                        $tReadOnly   = 'readonly';
                    }

                ?>
                <!-- เพิ่มรหัสบัตร  -->
                <!-- Create BY Witsarut 10-09-2020 -->
                <input type="text" class="form-control XCNHideinputCard"
                    id="oetCardCode"
                    name="oetCardCode"
                    maxlength="5"
                    autocomplete="off"
                    value="<?php echo $tCrdCode;?>"
                    placeholder="<?php echo language('payment/cardlogin/cardlogin','tCrdCode')?>" <?=$tReadOnly;?>>
            </div>


            <div class="form-group" id="odvCRDLLoginID">
                <!-- ชื่อผู้เข้าใช้ -->
                <label class="xCNLabelFrm XCNHide" id="olbCRDLLocinAcc">
                    <span class="text-danger">*</span>
                    <?= language('payment/cardlogin/cardlogin','tCrdloginAcc'); ?>
                </label>

            
                <!-- เบอร์โทรศัพท์ -->  
                <label class="xCNLabelFrm XCNHide" id="olbCRDLTelNo">
                    <span class="text-danger">*</span>
                    <?= language('payment/cardlogin/cardlogin','tCrdTelNo'); ?>
                </label>

                <!-- RFID -->
                <label class="xCNLabelFrm XCNHide" id="olbCRDLRFID">
                    <span class="text-danger">*</span>
                    <?= language('payment/cardlogin/cardlogin','tCrdTypeRFID'); ?>
                </label>

                <!-- QR Code -->
                <label class="xCNLabelFrm XCNHide" id="olbCRDLQRCode">
                    <span class="text-danger">*</span>
                    <?= language('payment/cardlogin/cardlogin','tCrdTypeQR'); ?>
                </label>

                <input type="text" class="form-control"
                    id= "oetidCrdlogin"
                    name="oetidCrdlogin"
                    maxlength="30"
                    autocomplete="off"
                    value="<?php 
                        echo $tCrdlogin; 
                    ?>" 
                    placeholder="<?php echo language('payment/cardlogin/cardlogin','tCrdloginAcc')?>"
                    data-validate-required = "<?= language('payment/cardlogin/cardlogin','tValiCrdloginAcc')?> "
                    <?= (isset($tCrdLogType) && !empty($tCrdLogType))? "readonly":""?>
                >

            </div>

            <div class="form-group" id="odvCRDLPwsPanel">
                <!-- *รหัสผ่าน -->
                <label class="xCNLabelFrm XCNHide" id="olbCRDLPassword">
                    <span class="text-danger">*</span>
                    <?= language('payment/cardlogin/cardlogin','tCrdloginPwd'); ?>
                </label>
            
                <!-- *PIN -->
                <label class="xCNLabelFrm XCNHide" id="olbCRDLPin">
                    <span class="text-danger">*</span>
                    <?= language('payment/cardlogin/cardlogin','tCrdTypePin'); ?>
                </label>

                <!-- Update การเข้ารหัส -->
                <!-- Create By Witsarut 1/09/2019 -->
                <input 
                    type="hidden" 
                    id="oetCrdloginPasswordOld"  
                    name="oetCrdloginPasswordOld" 
                    placeholder="<?= language('payment/cardlogin/cardlogin','tCrdEnCode')?>"
                    value="<?=$tCrdLoginPwd;?>" >
               
                <!-- ตรวจสอบ รหัสซ้ำ 13/03/2020 Saharat --> 
                <input 
                    type="hidden"
                    id="oetCrdloginPasswordCheck"
                    name="oetCrdloginPasswordCheck"
                    placeholder="<?= language('authen/user/user','tUSREnCode')?>"
                    value="<?=$tCrdLoginPwd;?>">

                <!-- Update การเข้ารหัส -->
                <!-- Create By Witsarut 1/09/2019 -->
                <input type="password" 
                    class="form-control xWCanEnterkeyDegit" 
                    autocomplete="off" 
                    onblur="JSxCheckDegitPassword(this)"
                    id="oetidCrdlogPw" 
                    name="oetidCrdlogPw" 
                    maxlength="50"  
                    value = "<?=$tCrdLoginPwd;?>"
                    placeholder="<?php echo language('payment/cardlogin/cardlogin','tCrdloginPwd')?>"
                    data-validate-required = "<?php echo language('payment/cardlogin/cardlogin','tValiCrdloginPass')?>"
                    <?= (isset($tCrdLogType) && !empty($tCrdLogType) && ($tCrdLogType == 3 || $tCrdLogType == 4))? "readonly":""?>
                >
                <span id="ospChkTypePassword" style="float:right; color: #f95353 !important;"><?php echo language('authen/user/user', 'tCheckDegitPassword');?></span>
                <span id="ospChkTypePin" style="float:right; color: #f95353 !important;"><?php echo language('authen/user/user', 'tCheckUsrloginDegitPin');?></span>
            </div>
            <div class="row"></div>
            
            <?php
                //Time Start
                if(isset($tCrdPwdStart)){
                    $aPasswordStart = explode(" ",$tCrdPwdStart);
                    if(isset($aPasswordStart[1])) {
                        $tCrdtimestart  = substr($aPasswordStart[1],0,8);
                    }else{
                        $tCrdtimestart = "";
                    }
                }else{
                    $tCrdtimestart = "";
                }
            ?>

            <!-- วันที่เริ่ม และ วันที่สิ้นสุด -->
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('payment/cardlogin/cardlogin','tCrdDateStart');?></label>
                        <div class="input-group">
                            <input type="text" style="display:none" id="oetCrdtimestart" name="oetCrdtimestart" value="<?php echo $tCrdtimestart;?>">
                            <input type="text" style="display:none" id="oetCrdtimestartOld" name="oetCrdtimestartOld" value="<?php echo $tCrdtimestart;?>">
                            <input type="hidden" class="form-control xCNDatePicker" id="oetCrdlogStartOld" name="oetCrdlogStartOld" value="<?php if($tCrdPwdStart != ""){ echo date_format(date_create($tCrdPwdStart),"Y-m-d"); }else{ echo date_format(date_create($dGetDataNow),"Y-m-d"); }?>" >
                            <input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-left" id="oetCrdlogStart" name="oetCrdlogStart" value="<?php if($tCrdPwdStart != ""){ echo date_format(date_create($tCrdPwdStart),"Y-m-d"); }else{ echo date_format(date_create($dGetDataNow),"Y-m-d"); }?>" >
                            <span class="input-group-btn">
                                <button id="obtCrdlogStart" type="button" class="btn xCNBtnDateTime">
                                    <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>

                <?php
                    //Time Expire
                    if(isset($tCrdExpired)){
                        $aPasswordExpire = explode(" ",$tCrdExpired);
                    if(isset($aPasswordExpire[1])) {
                        $tCrdtimesExpire  = substr($aPasswordExpire[1],0,8);
                    }else{
                        $tCrdtimesExpire = "";
                    }
                    }else{
                        $tCrdtimesExpire = "";
                    }
                ?>

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('payment/cardlogin/cardlogin','tCrdDateStop')?></label>
                        <div class="input-group">
                            <input type="text" style="display:none" id="oetCrdtimeExpire" name="oetCrdtimeExpire" value="<?php echo $tCrdtimesExpire;?>">
                            <input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-left" id="oetCrdlogStop" name="oetCrdlogStop" value="<?php if($tCrdExpired != ""){ echo date_format(date_create($tCrdExpired),"Y-m-d"); }else{ echo date_format(date_create($dGetDataFuture),"Y-m-d"); }?>">
                            <span class="input-group-btn">
                                <button id="obtCrdlogStop" type="button" class="btn xCNBtnDateTime">
                                    <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- หมายเหตุ -->
            <div class="form-group">
                <label class="xCNLabelFrm"><?= language('payment/cardlogin/cardlogin','tCrdLRemark'); ?></label>
                <textarea class="form-group" rows="4" maxlength="100" id="oetCrdlogRemark" name="oetCrdlogRemark" autocomplete="off"   placeholder="<?php echo language('payment/cardlogin/cardlogin','tCrdLRemark')?>"><?php echo $tRemark;?></textarea>
            </div>

            <!-- สถานะ -->
            <div class="form-group">
                <label class="xCNLabelFrm"><?=language('authen/user/user','tStaActiveNew')?></label>
                <select class="selectpicker form-control" id="ocmCrdlogStaUse" name="ocmCrdlogStaUse" maxlength="1">
                    <option value="1" <?php echo ($tCrdStaActive == '1' ? 'selected' : '') ?>><?php echo language('authen/user/user','tStaActiveNew1');?></option>
                    <option value="2" <?php echo ($tCrdStaActive == '2' ? 'selected' : '') ?>><?php echo language('authen/user/user','tStaActiveNew2');?></option>
                </select>
            </div>
        </div>
    </div>


    <input type="hidden" id="ohdCrdLogCode" name="ohdCrdLogCode" value="<?=$tCrdCode?>">
    <input type="hidden" id="ohdValidateDuplicate" name="ohdValidateDuplicate" value="0"><!-- 0 คือ ไม่เกิด validate  และ 1 เกิด validate -->
</form>

<!--กรณีรูปภาพไม่สำเร็จ-->
<div class="modal fade" id="odvModalImageRecogNoneProcess">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" style="display:inline-block; color: #FFF;"><?=language('customer/customer/customer', 'tCSTModalHeadRegisFace')?></h5>
			</div>
			<div class="modal-body">
				<span id="ospImageRecogNoneProcess"><?=language('customer/customer/customer', 'tCSTModalContentRegisFace')?></span>
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery"  data-dismiss="modal">
					<i class="fa fa-check-circle" aria-hidden="true"></i> <?=language('common/main/main', 'tModalConfirm')?>
				</button>
			</div>
		</div>
	</div>
</div>

<!--กรณีไม่ได้ตั้งค่า API-->
<div class="modal fade" id="odvModalDontConfigAPI">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" style="display:inline-block; color: #FFF;"><?=language('customer/customer/customer', 'tCSTDontConfigAPI')?></h5>
			</div>
			<div class="modal-body">
				<span id="ospDontConfigAPI"><?=language('customer/customer/customer', 'tCSTContentDontConfigAPI')?></span>
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery"  data-dismiss="modal">
					<i class="fa fa-check-circle" aria-hidden="true"></i> <?=language('common/main/main', 'tModalConfirm')?>
				</button>
			</div>
		</div>
	</div>
</div>

<script>
    $('document').ready(function(){
        $('#ospChkTypePassword').hide();
        $('#ospChkTypePin').hide();
    });

    if("<?php echo $aResult['rtCode'];?>" == 1){
        var tCrdLogType  = '<?php  echo $tCrdLogType;?>';
        $('#ocmlogintype').val(tCrdLogType);
        JSxCRDLCheckLoginTypeUsed('edit');
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
        var nLen = $('#oetidCrdlogPw').val();
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

  
// ยกระบบ สแกนใบหน้ามาเรียกใช้ที่นี่ Type 5 = สแกนใบหน้า 
//  ********************************************************************************************************************************

    //Get ความกว้างมาก่อน
    nWidth = 0;
    $(function() {
        //สร้าง Diagram รูปภาพ
        var nWidth = $('#odvTabRegisFace').width();
        JSxCreateImageLayout(nWidth,1);

        //ไปดึงข้อมูลมา
        var tCustomerCode = $('#oetFaceCode').val();
        JSaGetDataImg(tCustomerCode);
    });

    //ดึงข้อมูลมา
    function JSaGetDataImg(ptCustomerCode){
        $.ajax({
            type    : "POST",
            url     : "customerRegisFaceGetImage",
            data    : { 
                'CustomerCode' : ptCustomerCode,
                'tTable'  : 'TCNMCrdLogin' 
            },
            cache   : false,
            timeout : 0,
            success : function(tResult) {
                JCNxCloseLoading();
                var tPackData = JSON.parse(tResult);
                if(tPackData.rtCode == 1){
                    //มีข้อมูล
                    $('#odvTabRegisFace').empty();
                    var nCount = tPackData.raItems.length;
                    var pnSeq  = 1;
                    for(i=0; i<nCount; i++){
                        var pnSeq = pnSeq;
                        var tHTML =  "<div class='wCNOuterPDT' data-UseThisColumn='true'>";
                            tHTML += "<div class='xCNBtnDelete' onclick='JSxDeleteImage(this)'><span class='xCNFontBtnDelete'> X </span></div>";
                            tHTML += "<div class='wCNInnerPDT'>";
                            tHTML += "<input type='text' class='xCNHide' data-seq='"+pnSeq+"' id='oetImgInputRegisterFace"+pnSeq+"'  name='oetImgInputRegisterFace"+pnSeq+"' value=''>";
                            tHTML += "<img id='oimImgMasterRegisterFace"+pnSeq+"' style='height:100%; width:100%; display:none;'>";
                            tHTML += "<span id='ospMessageRegisterFace"+pnSeq+"'  class='wCNFontInsertPDT'>+</span>";
                            tHTML += "</div>";
                            tHTML += "</div>";
                        $('#odvTabRegisFace').append(tHTML);

                        var tPathImage  = tPackData.raItems[i].FTImgObj;
                        var tPathImage  = tPathImage.split("application");
                        var tNPathImage = '<?=base_url()?>'+'/application/'+tPathImage[1];
                        $('#oimImgMasterRegisterFace'+pnSeq).attr('src', tNPathImage);
                        $('#oimImgMasterRegisterFace'+pnSeq).css('display','block');
                        $('#ospMessageRegisterFace'+pnSeq).css('display','none');
                        pnSeq++;

                        JSxColumnDeleteHover();
                    }

                    //ถ้ามีครบ 10 ช่องแล้วไม่ต้องเพิ่ม
                    if(pnSeq != 11){
                        var tHTML =  "<div class='wCNOuterPDT' data-UseThisColumn='false'>";
                            tHTML += "<div class='xCNBtnDelete' onclick='JSxDeleteImage(this)'><span class='xCNFontBtnDelete'> X </span></div>";
                            tHTML += "<div class='wCNInnerPDT' onclick=JSvImageCallTempNEW('','99','RegisterFace"+pnSeq+"')>";
                            tHTML += "<input type='text' class='xCNHide' data-seq='"+pnSeq+"' id='oetImgInputRegisterFace"+pnSeq+"'  name='oetImgInputRegisterFace"+pnSeq+"' value=''>";
                            tHTML += "<img id='oimImgMasterRegisterFace"+pnSeq+"' style='height:100%; width:100%; display:none;'>";
                            tHTML += "<span id='ospMessageRegisterFace"+pnSeq+"'  class='wCNFontInsertPDT'>+</span>";
                            tHTML += "</div>";
                            tHTML += "</div>";
                        $('#odvTabRegisFace').append(tHTML);
                    }
                }else{
                    //ไม่มีข้อมูล
                    $('#odvTabRegisFace').empty();
                    var pnSeq = 1;
                    var tHTML =  "<div class='wCNOuterPDT' data-UseThisColumn='false'>";
                        tHTML += "<div class='xCNBtnDelete' onclick='JSxDeleteImage(this)'><span class='xCNFontBtnDelete'> X </span></div>";
                        tHTML += "<div class='wCNInnerPDT' onclick=JSvImageCallTempNEW('','99','RegisterFace"+pnSeq+"')>";
                        tHTML += "<input type='text' class='xCNHide' data-seq='"+pnSeq+"' id='oetImgInputRegisterFace"+pnSeq+"'  name='oetImgInputRegisterFace"+pnSeq+"' value=''>";
                        tHTML += "<img id='oimImgMasterRegisterFace"+pnSeq+"' style='height:100%; width:100%; display:none;'>";
                        tHTML += "<span id='ospMessageRegisterFace"+pnSeq+"'  class='wCNFontInsertPDT'>+</span>";
                        tHTML += "</div>";
                        tHTML += "</div>";
                    $('#odvTabRegisFace').append(tHTML);
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
    
    //ลบข้อมูลในช่อง
    function JSxColumnDeleteHover(){
        $('.wCNOuterPDT').hover(
            function() {
                var oElm = $(this).attr('data-UseThisColumn').toString();
                if(oElm == 'true'){
                    $(this).children('.xCNBtnDelete').addClass('xCNBtnDeleteShow');
                }
            }, function() {
                $(this).children('.xCNBtnDelete').removeClass('xCNBtnDeleteShow');
            }
        );
    }

    //ฟังก์ชั่นลบรูปภาพในช่อง
    function JSxDeleteImage(elem){
        var nSeqOld         = $(elem).parent().find('.wCNInnerPDT .xCNHide').attr('data-seq');
        var tCustomerCode   = $('#oetFaceCode').val();
        $.ajax({
            type    : "POST",
            url     : "customerRegisFaceDeleteImage",
            data    : { 'CustomerCode' : tCustomerCode ,
                        'nSeqOld' : nSeqOld ,
                        'tTable'  : 'TCNMCrdLogin'
                    },
            cache   : false,
            timeout : 0,
            success : function(oResult) {
                console.log(oResult);
                JCNxOpenLoading();
                var tResult = oResult.trim();
                if(tResult == 'refresh'){
                    JSxDeleteImage(elem)
                }else{
                    JSaGetDataImg(tCustomerCode);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //ปุ่มช่อง
    function JSxCreateImageLayout(pnWidth,pnSeq){
        var tHTML =  "<div class='wCNOuterPDT' data-UseThisColumn='false'>";
            tHTML += "<div class='xCNBtnDelete' onclick='JSxDeleteImage(this)'><span class='xCNFontBtnDelete'> X </span></div>";
            tHTML += "<div class='wCNInnerPDT' onclick=JSvImageCallTempNEW('','99','RegisterFace"+pnSeq+"')>";
            tHTML += "<input type='text' class='xCNHide' data-seq='"+pnSeq+"' id='oetImgInputRegisterFace"+pnSeq+"'  name='oetImgInputRegisterFace"+pnSeq+"' value=''>";
            tHTML += "<img id='oimImgMasterRegisterFace"+pnSeq+"' style='height:100%; width:100%; display:none;'>";
            tHTML += "<span id='ospMessageRegisterFace"+pnSeq+"'  class='wCNFontInsertPDT'>+</span>";
            tHTML += "</div>";
            tHTML += "</div>";
        $('#odvTabRegisFace').append(tHTML);
        var nNewWidth = parseInt(pnWidth) - 200;
        var tImage = $('#oetImgInputRegisterFace'+pnSeq).val();
        
        //ถ้ามีภาพเเล้ว ให้เด้งลบ
        JSxColumnDeleteHover();
    }

    //หลังจากเลือกรูปแล้ว ให้ยิง API
    function JSxOnCallNextFunction(ptFullPatch,ptImgName,ptIDElm){
        
        JCNxOpenLoading();
        //รหัสลูกค้า
        var tCustomerCode = $('#oetFaceCode').val();
        $.ajax({
            type    : "POST",
            url     : "customerRegisFace",
            data    : { 'CustomerCode' : tCustomerCode , 'ImageFullPath' : ptFullPatch , 'ImageName' : ptImgName,  'tTable'  : 'TCNMCrdLogin' },
            cache   : false,
            timeout : 0,
            success : function(tResult) {
                console.log(tResult);
                JCNxCloseLoading();
                var tResult = tResult.trim();
                // console.log(tResult);
                if(tResult == 'refresh'){
                    JSxOnCallNextFunction(ptFullPatch,ptImgName,ptIDElm)
                }else if(tResult == 'ConfigFail'){
                    $('#odvModalDontConfigAPI').modal('show');
                }else if(tResult == 'fail'){
                    var tHeadModalNotFound = '<?=language('customer/customer/customer', 'tCSTModalContentRegisFace')?>';
                    $('#odvModalImageRecogNoneProcess').modal('show');
                    $('#ospImageRecogNoneProcess').text(tHeadModalNotFound + ' ไม่พบใบหน้า ' + ' กรุณาลองใหม่อีกครั้ง');
                }else if(tResult == 'success'){
                    var tElementID = $('#odvTabRegisFace > .wCNOuterPDT:last-child > .wCNInnerPDT').children().attr('data-seq');
                    var nSeqBefore = tElementID;
                    var nSeqNew    = parseInt(nSeqBefore) + 1;

                    //ลบ event ไม่ให้มันทำงาน
                    $('#odvTabRegisFace > .wCNOuterPDT:last-child > .wCNInnerPDT').prop("onclick", null).off("click");

                    //เอารูปมาโชว์ + ซ่อนข้อความปุ่มเพิ่ม
                    $('#oimImgMasterRegisterFace'+nSeqBefore).css('display','block');
                    $('#ospMessageRegisterFace'+nSeqBefore).css('display','none');
                    $('#odvTabRegisFace > .wCNOuterPDT').attr('data-UseThisColumn','true');
                    if(nSeqNew == 11){
                        //Break เพิ่มไม่ได้เเล้ว
                    }else{
                        //ข้อมูลน้อยกว่า 10 ให้เพิ่มอัตโนมัติ
                        var nWidth = $('#odvTabRegisFace').width();
                        JSxCreateImageLayout(nWidth,nSeqNew);
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

// ยกระบบ สแกนใบหน้ามาเรียกใช้ที่นี่ Type 5 = สแกนใบหน้า 
//  ********************************************************************************************************************************
</script>

<?php include "script/jCardloginMain.php"; ?>
<link rel="stylesheet" href="<?php echo base_url('application/modules/common/assets/css/localcss/ada.component.css')?>">
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>