<?php
// $AdaStoreBackCookies = json_decode(base64_decode(get_cookie('AdaStoreBackCookies')), TRUE);
// echo "<pre>"; 
// var_dump(get_cookie('tBtnSaveStaActivea'));
// var_dump(get_cookie('AdaStoreBackCookies'));
// // print_r($AdaStoreBackCookies); 
// // echo $_SERVER['SERVER_NAME']."<br>";
// // echo $_SERVER['SCRIPT_NAME']."<br>"; 
// echo "</pre>";
// phpinfo();

if (is_null(get_cookie('FTUsrLogin')) && is_null(get_cookie('FTUsrCode'))) {
        $tUsername = '';
        $tUsrCode = '';
   }else{
        $tUsername = base64_decode(get_cookie('FTUsrLogin'));
        $tUsrCode  = base64_decode(get_cookie('FTUsrCode'));
   }
?>
<!doctype html>
<html lang="th" class="fullscreen-bg">
<head>
    <title>Login | <?php echo BASE_TITLE; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url();?>application/modules/common/assets/images/AdaLogo-ico.ico?v=1">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>application/modules/common/assets/images/AdaLogo-ico.ico?v=1">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>application/modules/authen/assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>application/modules/authen/assets/vendor/bootstrap/css/bootstrap.custom.css">
	<link rel="stylesheet" href="<?php echo base_url();?>application/modules/authen/assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>application/modules/authen/assets/vendor/linearicons/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>application/modules/authen/assets/vendor/chartist/css/chartist-custom.css">
    <!-- MAIN CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>application/modules/authen/assets/css/main.css">
    <!-- Login CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>application/modules/authen/assets/css/localcss/ada.login.css">
    <link rel="stylesheet" href="<?php echo base_url();?>application/modules/common/assets/css/localcss/ada.component.css">
    <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
    <link rel="stylesheet" href="<?php echo base_url();?>application/modules/authen/assets/css/demo.css">
    <!-- jquery -->
    <script src="<?php echo base_url();?>application/modules/authen/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>application/modules/authen/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <style>
        body{
            background-image: url('application/modules/common/assets/images/bg/Backoffice.jpg?v=1.0.0');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        .xWLoginBox{
            border-radius: 5px !important;
        }

        .xWLoginBox {
            -webkit-box-shadow: 0px 0px 105px -23px rgba(0,0,0,1);
            -moz-box-shadow: 0px 0px 105px -23px rgba(0,0,0,1);
            box-shadow: 0px 0px 43px -25px rgba(0,0,0,1)
        }

        li {
            display:inline-block;
            list-style-type:none;
            margin-right:-4px;
            padding:10px;
            cursor: pointer;
        }


        .active {
            color: #0081c2;
        }

        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
        }

        .xCNThumbnail img{
            width: 130px;
            height: 130px;
            margin: 16px auto;
            display: block;
            object-fit: cover;
            border-radius: 50%;

        }

        .table tbody tr, .table>tbody>tr>td {
            color: #232C3D !important;
            font-size: 18px !important;
        }

        .xCNBTNDefult {
            font-size: 18px!important;
            font-weight: normal !important;
        }
    </style>
</head>
<body class="xCNBody layout-fullwidth">
    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="vertical-align-wrap">
            <div class="vertical-align-middle">
                <div class="auth-box lockscreen clearfix xWLoginBox">
                    <div class="content">
                        <div>

                        </div>
                        <div id="odvPasswordImg" class="logo text-center">
                            <img src="<?php echo base_url();?>application/modules/authen/assets/images/AdaStatDose.PNG" alt="Ada Logo" >
                        </div>
                        <div id="odvPinImg" style="margin-bottom: 8px;" class="logo text-center">
                            <img class="avatar" src="https://drgsearch.com/wp-content/uploads/2020/01/no-photo.png" alt="Ada Logo">
                        </div>
                        <!-- <form class="form-auth-small" onclick="JSxCheckLogin();" action="Checklogin" method="POST"> -->
                        <form class="form-auth-small" method="POST">
                            <input type="hidden" id="ohdLOGUsrLogType" name="ohdLOGUsrLogType" value="1" > <!-- FTUsrLogType : 1 = รหัสผ่าน, 2 = PIN, 3 = RFID, 4 = QRCode --> 
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group d-flex justify-content-center">
                                        <div id="odvUsernamePin" class="text-center row" style="margin-bottom: 26px;">
                                            <label id="oetUserNamePin" style="font-weight: bold !important; font-size: 24px !important;margin-bottom: 0 !important;" class="xCNLabelFrm"></label>
                                            <br>
                                        <?php if($tUsername == '' && $tUsrCode == ''){?>
                                            <span id="obBrowseAcc" style="cursor: pointer;color: #0081c2;"><?php echo language('authen/login/login', 'tSignin');?></span>
                                        <?php } else {?>
                                            <span id="obBrowseAcc" style="cursor: pointer;color: #0081c2;"><?php echo language('authen/login/login', 'tChangeUserName');?></span>                                            
                                        <?php } ?>
                                        </div>
                                    <div>
			
                                    <div id="odvUsername" class="form-group">
                                        <label for="signin-email" class="control-label sr-only"><?php echo language('authen/login/login', 'tUsernameCode');?></label>
                                        <input type="text" required  class="form-control xWCtlForm xWCanEnter" id="oetUsername" name="oetUsername" style="height: 38px !important;" placeholder="<?php echo language('authen/login/login', 'tUsernameCode');?>">
                                        <span id="ospvalidateName" style="float:right; color: #f95353 !important;"><?php echo language('common/main/main', 'tCommonPlsEnterUserName');?></span>
                                    </div>

                                    <div id="odvPasswordPin" class="form-group" id="odvPasswordPin">
                                        <input type="hidden"  class="form-control xWCtlForm xWCanEnter" id="oetUsrCode" name="oetUsrCode" style="height: 38px !important;" value="<?php echo $tUsrCode ?>">
                                        <input type="hidden"  class="form-control xWCtlForm xWCanEnter" id="oetUsrLogin" name="oetUsrLogin" style="height: 38px !important;" value="<?php echo $tUsername ?>">
                                        <label for="signin-password" class="control-label sr-only"><?php echo language('authen/login/login', 'tPassword');?></label>
                                        <input type="password" required class="form-control xWCtlForm xWCanEnter" id="oetPasswordPin" name="oetPasswordPin" style="height: 38px !important;" placeholder="<?php echo language('authen/login/login', 'PIN');?>" maxlength="6">
                                        <span id="ospvalidatePasswordPin" style="float:right; color: #f95353 !important;"><?php echo language('common/main/main', 'กรุณากรอกรหัสผ่าน');?></span>
                                    </div>

                                    <div id="odvPassword"  class="form-group" id="odvPassword">
                                        <label for="signin-password" class="control-label sr-only"><?php echo language('authen/login/login', 'tPassword');?></label>
                                        <input type="password" required class="form-control xWCtlForm xWCanEnter" id="oetPassword" name="oetPassword" style="height: 38px !important;" placeholder="<?php echo language('authen/login/login', 'tPassword');?>">
                                        <input type="hidden" id="oetPasswordhidden" name="oetPasswordhidden">
                                        <span id="ospvalidatePassword" style="float:right; color: #f95353 !important;"><?php echo language('common/main/main', 'กรุณากรอกรหัสผ่าน');?></span>
                                    </div>
                                    
                                </div>

                                <div style="padding:0" class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-left">
                                    <!-- <div class="form-group clearfix">
                                        <label class="fancy-checkbox element-left">
                                            <input type="checkbox">
                                            <span><?php echo language('authen/login/login', 'tRememberMe');?></span>
                                        </label>
                                    </div> -->
                                    <div  style="margin-left:20px;">
                                        <span id="ospLOGChangePassword" class="text-muted" style="cursor: pointer;"><?php echo language('authen/login/login', 'tChangePassWord');?></span>
                                    </div>
                                </div>
                                <div style="padding:0" class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                                    <div class="form-group dropdown" style="margin-right:25px;margin-bottom: 5px !important;">
                                        <?php
                                            $nPicLang = @$_SESSION["tLangEdit"];
                                            if($nPicLang == ''){
                                                $nPicLang = '1';
                                            }
                                        ?>
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                            <!-- <img src="<?php echo  base_url('application/modules/authen/assets/images/use/').$nPicLang.'.png' ?>" style="height: 20px; width: 20px;">  -->
                                            <?php echo language('authen/login/login', 'tLanguageType');?> <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="<?php echo  base_url('ChangeLang/th/1'); ?>">
                                                    <!-- <img src="<?php echo  base_url('application/modules/authen/assets/images/flags/th.png')?>" style="height: 20px; width: 20px;"> -->
                                                    <?php echo language('authen/login/login', 'tLanguageType1');?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo  base_url('ChangeLang/en/2'); ?>">
                                                    <!-- <img src="<?php echo  base_url('application/modules/authen/assets/images/flags/en.png')?>" style="height: 20px; width: 20px;"> -->
                                                    <?php echo language('authen/login/login', 'tLanguageType2');?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div style="padding-right: 21px;" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                                    <span id="ospUsrOrPwNotCorrect" style="float:right; color: #f95353 !important;"><?php echo language('common/main/main', 'tValiNameOrPasswordNotCorrect');?></span>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>

                                <div style="padding:0" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <!-- <button type="submit" class="btn xWCtlBtn"><span style="color:#0081c2;"><?php echo language('authen/login/login', 'tLogin');?></span></button> -->
                                    <button type="button" id="obtLOGConfirmLogin" class="btn xWCtlBtn"><span style="color:#0081c2;"><?php echo language('authen/login/login', 'tLogin');?></span></button>
                                </div>
                            </div>
                        </form>                                
                        <div style = "margin-top:10px" class="d-flex justify-content-center text-center">
                                <li id="oetPasswordSwitch" class="active"><?php echo language('authen/login/login', 'tPassWord');?></li>
                                <label>|</label>
                                <li id="oetPinSwitch">PIN</li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END WRAPPER -->

    <!-- Create By Witsarut 18/06/20
    Modal Info Message Confirm
    Message Modal Confirm for login and ChangePassword -->
    <div class="modal fade" id="odvModalInfoMessageFrm" data-toggle="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
        <div class="modal-dialog" role="document" style="width: 450px; margin: 1.75rem auto;top:20%;">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <h3 style="font-size:20px;color:#08f93e;font-weight: 1000;"><i class="fa fa-check"></i> 
                        <span><?=language('common/main/main', 'tTitleModalSuccess');?></span>
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="xCNMessage"></div>
                    <div class="clearfix"></div>
                    <div class="text-center">
                        <div 
                            class="ldBar label-center"
                            style="width:50%;height:50%;margin:auto;"
                            data-value="0"
                            data-preset="circle"
                            data-stroke="#21bd35"
                            data-stroke-trail="#b2f5be"
                            id="odvIdBar">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="xCNTextResponse"></div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="modal fade" id="odvSMPModalAddEditModule" data-toggle="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
        <div class="modal-dialog" role="document" style="width: 450px; margin: 1.75rem auto;top:20%;">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <h3 style="font-size:20px;color:#08f93e;font-weight: 1000;"><i class="fa fa-info"></i> <span id="ospHeader"></span></h3>
                </div>
                <div class="modal-body">
                    <div class="xCNMessage"></div>
                    <div class="clearfix"></div>
                    <div class="text-center">
                        <div 
                            class="ldBar label-center"
                            style="width:50%;height:50%;margin:auto;"
                            data-value="0"
                            data-preset="circle"
                            data-stroke="#21bd35"
                            data-stroke-trail="#b2f5be"
                            id="odvIdBar">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="xCNTextResponse"></div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div> -->
    <div class="modal fade" id="odvSMPModalAddEditModule">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard"
                                style="font-weight: bold; font-size: 20px;">บัญชีผู้ใช้</label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-5 col-lg-5">
                            <div class="form-group">
                                <div class="input-group"><input class="form-control"
                                    id="oetTextFilter"
                                    type="text"
                                    onkeypress="Javascript:if(event.keyCode==13 ) JSxLOGGetAccount()"
                                    autocomplete="off" placeholder="กรอกคำค้นหา"><span
                                    class="input-group-btn"><button id="obtBrowseModalSearch"
                                    class="btn xCNBtnSearch" type="button"
                                    onclick="JSxLOGGetAccount()"><i
                                    class="fa fa-search"></i></button></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="xCNOverlay">
                        <img src="<?php echo base_url() ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
                    </div>
                        <div id="odvAccout">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jBrowseModal.js"></script>
<!--Key Password-->
<script type="text/javascript" src="<?php echo base_url() ?>application/modules/authen/assets/js/global/PasswordAES128/aes.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>application/modules/authen/assets/js/global/PasswordAES128/cAES128.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>application/modules/authen/assets/js/global/PasswordAES128/AESKeyIV.js"></script>
<script>    

    $('document').ready(function(){
        var tUsrCode     = $('#oetUsrCode').val();

        $('#ospUsrOrPwNotCorrect').hide();  // ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง
        $('#ospvalidateName').hide(); // กรุณากรอกชื่อผู้ใช้
        $('#ospvalidatePassword').hide();  //กรุณากรอกรหัสผ่าน
        $('#ospvalidatePasswordPin').hide();  //กรุณากรอกรหัสผ่าน
        $('#oetUsername').focus();
        if(tUsrCode != ''){
            JSxLOGGetUsrNameAndImg()
        }
        
    });
    
    $('.xWCanEnter').on('keypress',function(){
        $('#ospUsrOrPwNotCorrect').hide(); // ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง
        $('#ospvalidateName').hide();  // กรุณากรอกชื่อผู้ใช้
        $('#ospvalidatePassword').hide(); //กรุณากรอกรหัสผ่าน
        $('#ospvalidatePasswordPin').hide();  //กรุณากรอกรหัสผ่าน
        if(event.keyCode == 13){
            $('#obtLOGConfirmLogin').click();
        }
    });

    // function JSxCheckLogin(){
    //     var tOldPassword = $('#oetPassword').val();
    //     var tEncPassword = JCNtAES128EncryptData(tOldPassword, tKey, tIV);
    //     $('#oetPasswordhidden').val(tEncPassword);
    // }

    // Last Update By Napat(Jame) 22/05/2020
    // เพิ่มเช็คเงื่อนไข input username and password ต้องไม่ใช่เท่ากับว่าง
    $('#obtLOGConfirmLogin').off('click');
    $('#obtLOGConfirmLogin').on('click',function(){
        var tUsrLogType = $('#ohdLOGUsrLogType').val();
        var tUsername = '';
        var tOldPassword = '';

        if(tUsrLogType == 1){
            tUsername    = $('#oetUsername').val();
            tOldPassword = $('#oetPassword').val();
            JSxLOGConfirmLogin(tUsername,tOldPassword);
        }else if(tUsrLogType == 2){
            if($('#oetUsrLogin').val() != ''){
                tUsername    = $('#oetUsrLogin').val();
                tOldPassword = $('#oetPasswordPin').val();
                JSxLOGConfirmLogin(tUsername,tOldPassword);
            }else{
                JSxLOGGetUsrLoginPin();
            }
            
        }
    });

    function JSxLOGNextFuncLoginPin(poElem){
        var aReturn = $.parseJSON(poElem);
        tUsername    = aReturn[0];
        tOldPassword = $('#oetPasswordPin').val();
        JSxLOGConfirmLogin(tUsername,tOldPassword);
    }
    
    function JSxLOGConfirmLogin(tUsername,tOldPassword){
        var tUsrLogType = $('#ohdLOGUsrLogType').val();
        var tUsrCode    = $('#oetUsrCode').val();
        var tEncPassword = JCNtAES128EncryptData(tOldPassword, tKey, tIV);

        if(tUsername != "" && tOldPassword != ""){
            $.ajax({
                type: "POST",
                url: "Checklogin",
                data: {
                    'oetUsername'           : tUsername,
                    'oetPasswordhidden'     : tEncPassword,
                    'tUsrLogType'           : tUsrLogType,
                    'tUsrCode'              : tUsrCode,
                },
                cache: false,
                timeout	: 0,
                success: function (oResult){
                    var aReturn = $.parseJSON(oResult);
                    console.log(aReturn);
                    
                    if(aReturn['nStaReturn'] == '1'){
                        location.reload();
                    }else if(aReturn['nStaReturn'] == '3'){
                        var tUsrLoginType = aReturn['tUsrLogType'];
                        JCNxCallModalChangePassword(3,tUsrLoginType,tUsername);
                        //FTUsrLogType : 1 = รหัสผ่าน // 2 = PIN // 3 = RFID // 4 = QRCode
                        //Clear - ค่า
                        // $('.xCNTextModalHeard').text('<?=language('common/main/main', 'tMNUChangePassword')?>');
                        // $('#ohdtypeChangePassword').val('');
                        // $('#oetPasswordNew').attr('maxlength','25');
                        // $('#oetPasswordNew').attr('minlength','8');

                        //Set - ค่า
                        // switch(aReturn.tUsrLogType) {
                        //     case "1":
                        //         var tChangeType = 'รหัสผ่าน';
                        //         break;
                        //     case "2":
                        //         var tChangeType = 'PIN';
                        //         $('#oetPasswordNew').attr('maxlength','6');
                        //         $('#oetPasswordNew').attr('minlength','6');
                        //         break;
                        //     case "3":
                        //         var tChangeType = 'RFID';
                        //         break;
                        //     case "4":
                        //         var tChangeType = 'QRCode';
                        //         break;
                        //     default:
                        //         var tChangeType = 'รหัสผ่าน';
                        // }
                        // $('#ohdtypeChangePassword').val(aReturn.tUsrLogType);
                    }else{
                        // console.log(aReturn);
                        var tMsgError = '<?php echo language('authen/login/login', 'tErrorNotFoundUser');?>';
                        // console.log(aReturn['aItems'].length);
                        if( aReturn['aItems'].length > 0 ){
                            switch(aReturn['aItems'][0]['FTStaError']){
                                case '1': /*PASS FAIL*/
                                    var tMsgError = '<?php echo language('authen/login/login', 'tErrorPassIncorrect');?>';
                                    break;
                                case '2': /*EXPIRED*/
                                    var tMsgError = '<?php echo language('authen/login/login', 'tErrorUserExpired');?>';
                                    break;
                                case '3': /*Not Started*/
                                    var tMsgError = '<?php echo language('authen/login/login', 'tErrorNotFoundUser');?>';
                                    break;
                                case '4': /*NOT ACTIVE*/
                                    var tMsgError = '<?php echo language('authen/login/login', 'tErrorUserDisabled');?>';
                                    break;
                            }
                        }
                        $('#ospUsrOrPwNotCorrect').text(tMsgError);
                        $('#ospUsrOrPwNotCorrect').show();  // ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง
                        // location.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            // Last Update : 05/11/2020 Napat(Jame) กลับมาใช้เหมือนเดิม เมื่อ enter ให้ focus input ถัดไป
            if(tUsername == ""){
                // $('#ospvalidateName').show();   // กรุณากรอกชื่อผู้ใช้
                // $('#ospUsrOrPwNotCorrect').hide();  // ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง
                $('#oetUsername').focus();
            }else{
                // $('#ospvalidatePassword').show();  //กรุณากรอกรหัสผ่าน
                // $('#ospUsrOrPwNotCorrect').hide();  // ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง
                $('#oetPassword').focus();
            }
        }

    }


    $('#ospLOGChangePassword').off('click').on('click',function(){
        var tUsrLoginType = $('#ohdLOGUsrLogType').val();
        JCNxCallModalChangePassword(1,tUsrLoginType);
    })

    if ($("#oetPasswordSwitch").hasClass("active")) {
        $('#oetPassword').show();
        $('#odvPinImg').hide();
        $('#odvUsername').show();
        $('#odvUsernamePin').hide();

        $('#odvPassword').show();
        $('#odvPasswordPin').hide();
    }

    $('li').on('click', function(){
        $('li').removeClass('active');
        $(this).addClass('active');
    });

    $('#oetPinSwitch').on('click', function(){
        $('#odvPasswordImg').hide('fast');
        $('#odvPinImg').show('fast');
        $('#odvUsername').hide('fast');
        $('#odvUsernamePin').show('fast');
        $('#ohdLOGUsrLogType').val(2);

        $('#odvPassword').hide('fast');
        $('#odvPasswordPin').show('fast');

        var tChangePin = "<?php echo language('authen/login/login', 'tChangePin');?>";
        $('#ospLOGChangePassword').text(tChangePin)
    });

    $('#oetPasswordSwitch').on('click', function(){
        $('#odvPasswordImg').show('fast');
        $('#odvPinImg').hide('fast');
        $('#odvUsername').show('fast');
        $('#odvUsernamePin').hide('fast');
        $('#ohdLOGUsrLogType').val(1);

        $('#odvPassword').show('fast');
        $('#odvPasswordPin').hide('fast');

        var tChangePassWord = "<?php echo language('authen/login/login', 'tChangePassWord');?>";
        $('#ospLOGChangePassword').text(tChangePassWord)
    });

    $('#obBrowseAcc').on('click', function(){
        JSxLOGGetAccount();
        $('#odvSMPModalAddEditModule').modal('show')
    });

    function JSxLOGGetAccount(){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "BrowseUserName",
            async: false,
            cache: false,
            timeout: 0,
            data: {
                'tTextFilter'  : $('#oetTextFilter').val(),
            },
            success: function(tResult) {
                $("#odvAccout").html(tResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    function JSxLOGSelectUsr(tUsrCode){
        $('#oetUsrLogin').val('');
        var tUsrimg = $('#oetUsrimg'+tUsrCode).val()
        var tUsrname = $('#oetUsrname'+tUsrCode).val()
        var tUsrCodePin = $('#oetUsrCodePin'+tUsrCode).val()
        $('#odvPinImg').html('<img class="avatar" src="'+tUsrimg+'" alt="Ada Logo">')
        $("#oetUserNamePin").text(tUsrname);
        $('#oetUsrCode').val(tUsrCodePin)
        $('#obBrowseAcc').text('เปลี่ยนชื่อผู้ใช้')
        $('#odvSMPModalAddEditModule').modal('hide');
    }

    function JSxLOGGetUsrLoginPin(){
        var tUsrCode     = $('#oetUsrCode').val();
        var tOldPassword = $('#oetPasswordPin').val();

        var tEncPassword = JCNtAES128EncryptData(tOldPassword, tKey, tIV);

        $.ajax({
            type: "POST",
            url: "GetUsrLoginPin",
            data: {
                'oetUsrCode'         : tUsrCode,
                'oetPasswordhidden'  : tEncPassword,
            },
            async: false,
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var aResult = JSON.parse(tResult);
                var aItems  = aResult['aItems']['raItems'];
                if(aResult['nStaReturn'] != 99){
                    if(aItems.length > 1){
                        window.oLOGBrowseTel = oBrowseTel({
                            'tReturnInputName': 'oetUsrLogin',
                            'tReturnInputPassword': tEncPassword,
                        });
                        JCNxBrowseData('oLOGBrowseTel');
                    }else if(aItems.length == 1){
                        tUsername    = aResult['aItems']['raItems'][0]['FTUsrLogin'];
                        tOldPassword = $('#oetPasswordPin').val();
                        JSxLOGConfirmLogin(tUsername,tOldPassword);
                    }                    
                }else{
                    var tMsgError = '<?php echo language('authen/login/login', 'tErrorPassIncorrect');?>';
                    $('#ospUsrOrPwNotCorrect').text(tMsgError);
                    $('#ospUsrOrPwNotCorrect').show();
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    var oBrowseTel = function(poReturnInput) {
    var tInputReturnName = poReturnInput.tReturnInputName;
    var tInputReturnPassword = poReturnInput.tReturnInputPassword;

    var oLOGBrowseTel = {
        Title: ['settingconfig/settingmenu/settingmenu', 'เบอร์โทร'],
        Table: {
            Master: 'TCNMUsrLogin',
            PK: 'FTUsrLogin'
        },
        Where: {
            Condition: ["AND TCNMUsrLogin.FTUsrCode = "+$('#oetUsrCode').val()+" AND TCNMUsrLogin.FTUsrLoginPwd = '"+tInputReturnPassword+"' "]
        },
        GrideView: {
            ColumnPathLang: 'settingconfig/settingmenu/settingmenu',
            ColumnKeyLang: ['tModalModuleCode', 'เบอร์โทร'],
            ColumnsSize: ['15%', '85%'],
            WidthModal: 30,
            DataColumns: ['TCNMUsrLogin.FTUsrCode', 'TCNMUsrLogin.FTUsrLogin'],
            DataColumnsFormat: ['', ''],
            DisabledColumns: [0],
            Perpage: 10,
            OrderBy: ['TCNMUsrLogin.FTUsrLogin ASC'],
        },
        CallBack: {
            ReturnType: 'S',
            Text: [tInputReturnName, "TCNMUsrLogin.FTUsrLogin"],
        },
        NextFunc: {
            FuncName: 'JSxLOGNextFuncLoginPin',
            ArgReturn:['FTUsrLogin']
        },
    }
    return oLOGBrowseTel;
}


    function JSxLOGGetUsrNameAndImg(){
        var tUsrCode     = $('#oetUsrCode').val();

        $.ajax({
            type: "POST",
            url: "GetUsrNameAndImg",
            data: {
                'tUsrCode'  : tUsrCode,
            },
            async: false,
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var aResult = JSON.parse(tResult);
                if(aResult['nStaReturn'] == 1){
                    var tImage = aResult['aItems']['raItems'][0]['FTImgObj'];
                        tImage = tImage.split('application/modules');
                        tPatchImg = '<?php echo base_url('application/modules/')?>'+tImage[1];
                    $('#odvPinImg').html('<img class="avatar" src="'+tPatchImg+'" alt="Ada Logo">')
                    // $('#oetUserNamePin').val(aResult['aItems']['raItems'][0]['FTUsrName']);
                    $("#oetUserNamePin").text(aResult['aItems']['raItems'][0]['FTUsrName']);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    function JCNxCloseLoading() {
        $('.xCNOverlay').delay(10).fadeOut();
    }

    function JCNxOpenLoading() {
        $('.xCNOverlay').delay(5).fadeIn();
    }
</script>

<?php include('application/modules/common/views/script/jChangePassword.php'); ?>