<script>

//function: function Set Modal Text In Msg Success
//Parameters: Text Message Return
//Creator: 23/01/2020 ฺBell
//Return: View Alert success Massage
//Return Type: -
function FSvCMNMsgSucessDialog(tMsgBody) {
    $('#odvModalInfoMessageFrm .modal-body ').html(tMsgBody);
    $('#odvModalInfoMessageFrm').modal({ backdrop: 'static', keyboard: false })
    JCNxCloseLoading();
    $('#odvModalInfoMessageFrm').modal({ show: true });
}

//function : function Close Lodding
//Parameters : - 
//Creator : 03/05/2018 wasin
//Return : Close Lodding
//Return Type : -
function JCNxCloseLoading() {
    $('.xCNOverlay').delay(10).fadeOut();
}


// Create By Napat(Jame) 14/05/2020
// Last Update : 16/11/2020 Napat(Jame) เพิ่ม Input Username ใช้สำหรับเปลี่ยนรหัสผ่านหน้าจอล็อคอิน
// Call Modal
function JCNxCallModalChangePassword(pnStaAct,ptStaLogType,ptUsername){

    $.ajax({
        type: "POST",
        url: "comGetPrivacy",
        timeout: 0,
        success: function(oResult) {
            var aResult = JSON.parse(oResult);
            // console.log(aResult['roItem']['rtURLPADA']);
            $('#odvmodalChangePassword').remove();

            var tSesUserLogin = '<?=$this->session->userdata("tSesUserLogin")?>';
            var tURLPADA = aResult['roItem']['rtURLPADA'];
            var tUsrMaxLength = "50";
            var tPwdMaxLength = "50";
            var tPwdMinLength = "8";
            var tLang = '';
            var tLangHeader = '';
            var tLangPassWord = '';
            var tChangePasswordNew = '';
            var tChangePasswordConfirm = '';
            var tCheckDegitPassword = '';
            var tChangePasswordConfirmIncorrect = '';
            var tStyleInputUsrLogin = "display: none;";

            switch(ptStaLogType) {
                case "1": //รหัสผ่าน
                    tLang = '<label class="xCNLabelFrm"><?php echo language('common/main/main','tMNUChangeUserLogin')?></label>';
                    tLangHeader = '<?php echo language('common/main/main', 'tMNUChangePassword')?>';
                    tLangPassWord = '<?php echo language('common/main/main','tMNUChangePasswordOld')?>';
                    tChangePasswordNew = '<?php echo language('common/main/main','tMNUChangePasswordNew')?>';
                    tChangePasswordConfirm = '<?php echo language('common/main/main','tMNUChangePasswordConfirm')?>';
                    tCheckDegitPassword = '<?= language('common/main/main','tCheckDegitPassword')?>';
                    tChangePasswordNoMatch = '<?= language('common/main/main','tMNUChangePasswordNoMatch')?>';
                    tChangePasswordConfirmIncorrect = '<?= language('common/main/main','tMNUChangePasswordConfirmIncorrect')?>';
                    break;
                case "2": //PIN
                    tPwdMaxLength = "6";
                    tLang = '<label class="xCNLabelFrm"><?php echo language('common/main/main','tMNUChangeUserLoginPin')?></label>';
                    tLangHeader = '<?php echo language('common/main/main', 'tMNUChangePasswordPIN')?>';
                    tLangPassWord = '<?php echo language('common/main/main','tMNUChangePasswordOldPin')?>';
                    tChangePasswordNew = '<?php echo language('common/main/main','tMNUChangePasswordNewPin')?>';
                    tChangePasswordConfirm = '<?php echo language('common/main/main','tMNUChangePasswordConfirmPin')?>';
                    tCheckDegitPassword = '<?= language('common/main/main','tCheckDegitPasswordPin')?>';
                    tChangePasswordNoMatch = '<?= language('common/main/main','tMNUChangePasswordNoMatchPin')?>';
                    tChangePasswordConfirmIncorrect = '<?= language('common/main/main','tMNUChangePasswordConfirmIncorrectPin')?>';
                    break;
                case "3": //RFID
                    break;
                case "4": //QRCode
                    break;
                default:
                    tLang = '<label class="xCNLabelFrm"><?php echo language('common/main/main','tMNUChangeUserLogin')?></label>';
                    tLangHeader = '<?php echo language('common/main/main', 'tMNUChangePassword')?>';
                    tLangPassWord = '<?php echo language('common/main/main','tMNUChangePasswordOld')?>';
                    tChangePasswordNew = '<?php echo language('common/main/main','tMNUChangePasswordNew')?>';
                    tChangePasswordConfirm = '<?php echo language('common/main/main','tMNUChangePasswordConfirm')?>';
                    tCheckDegitPassword = '<?= language('common/main/main','tCheckDegitPassword')?>';
                    tChangePasswordNoMatch = '<?= language('common/main/main','tMNUChangePasswordNoMatch')?>';
                    tChangePasswordConfirmIncorrect = '<?= language('common/main/main','tMNUChangePasswordConfirmIncorrect')?>';
            }

            let tHTML = '';
            tHTML += '<div class="modal fade" id="odvmodalChangePassword" style="z-index: 1050 !important;">';
            tHTML += '  <div class="modal-dialog" style="width: 400px;">';
            tHTML += '      <div class="modal-content">';
            tHTML += '          <div class="modal-header xCNModalHead">';
            tHTML += '              <label class="xCNTextModalHeard">'+tLangHeader+'</label>';
            tHTML += '              <input type="hidden" id="ohdtypeChangePassword" name="ohdtypeChangePassword" value="'+ptStaLogType+'"></input>';
            tHTML += '          </div>';
            tHTML += '          <div class="modal-body">';
            if(pnStaAct != 3){
                tStyleInputUsrLogin = "display: block;";
                if( tSesUserLogin != '' ){
                    ptUsername          = tSesUserLogin;
                    tStyleInputUsrLogin = "display: none;";
                }else{
                    ptUsername = '';
                }
            }else{
                tStyleInputUsrLogin = "display: none;";
            }
            tHTML += '              <div class="form-group" style="'+tStyleInputUsrLogin+'">';
            tHTML += tLang
            tHTML += '                  <input class="form-control xWCanEnterChgPass" type="text" id="oetUserLogin" name="oetUserLogin" maxlength="'+tUsrMaxLength+'" value="'+ptUsername+'">';
            tHTML += '              </div>';
            tHTML += '              <div class="form-group">';
            tHTML += '                  <label class="xCNLabelFrm">'+tLangPassWord+'</label>';
            tHTML += '                  <input class="form-control xWCanEnterChgPass" type="password" id="oetPasswordOld" name="oetPasswordOld" minlength="'+tPwdMinLength+'" maxlength="'+tPwdMaxLength+'" value="">';
            tHTML += '              </div>';
            tHTML += '              <div class="form-group">';
            tHTML += '                  <label class="xCNLabelFrm">'+tChangePasswordNew+'</label>';
            tHTML += '                  <input class="form-control xWCanEnterChgPass" type="password" id="oetPasswordNew" name="oetPasswordNew" minlength="'+tPwdMinLength+'" maxlength="'+tPwdMaxLength+'" value="">';
            tHTML += '              </div>';
            tHTML += '              <div class="form-group">';
            tHTML += '                  <label class="xCNLabelFrm">'+tChangePasswordConfirm+'</label>';
            tHTML += '                  <input class="form-control xWCanEnterChgPass" type="password" id="oetPasswordConf" name="oetPasswordConf" minlength="'+tPwdMinLength+'" maxlength="'+tPwdMaxLength+'" value="">';
            tHTML += '              </div>';
            tHTML += '              <div class="form-group">';
            tHTML += '                  <label id="oblAccpetAgree" class="fancy-checkbox xCNDisabled" style="display: inline;">';
            tHTML += '                      <input id="ocbCPWAccpetAgree" name="ocbCPWAccpetAgree[]" type="checkbox" disabled>';
            tHTML += '                      <span ></span>';
            tHTML += '                   </label>';
            tHTML += '                  <?=language('register/buylicense/buylicense', 'tTextAgreement') ?> <a target="_blank" id="oahCPWPolicy" href="'+tURLPADA+'"><u><?=language('register/buylicense/buylicense', 'tTextPrivacypolicy') ?></u></a> ';
            tHTML += '              </div>';
            tHTML += '              <div style="text-align:right;">';
            tHTML += '                  <label id="odlChkDegitPassword" class="xCNLabelFrm" style="display:block; color: #f95353 !important;">'+tCheckDegitPassword+'</label>';
            tHTML += '                  <label id="odlPasswordNomatch" class="xCNLabelFrm" style="display:none; color: #f95353 !important;">'+tChangePasswordNoMatch+'</label>';
            tHTML += '                  <label id="odlChgPassword" class="xCNLabelFrm" style="display:block; color: #f95353 !important;"><?= language('common/main/main','รหัสผ่านใหม่เหมือนกับรหัสผ่านเก่าไม่อนุญาตให้ใช้')?></label>';
            tHTML += '                  <label id="odlChgPasswordConf" class="xCNLabelFrm" style="display:block; color: #f95353 !important;">'+tChangePasswordConfirmIncorrect+'</label>';
            tHTML += '              </div>';
            tHTML += '          </div>';
            tHTML += '          <div class="modal-footer">';
            tHTML += '              <button id="obtConfirmPassword" onClick="JCNxCheckPassword('+pnStaAct+','+ptStaLogType+')" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" disabled>';
            tHTML += '                  <?php echo language('common/main/main', 'tModalConfirm')?>';
            tHTML += '              </button>';
            tHTML += '              <button id="obtCancelPassword" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">';
            tHTML += '                  <?php echo language('common/main/main', 'tModalCancel')?>';
            tHTML += '              </button>';
            tHTML += '          </div>';
            tHTML += '      </div>';
            tHTML += '  </div>';
            tHTML += '</div>';
            $('body').append(tHTML);

            let tHTMLAlert = '';
            tHTMLAlert += '<div class="modal fade" id="odvmodalAlertPolicyChangePassword" style="z-index: 1200 !important;">';
            tHTMLAlert += '  <div class="modal-dialog">';
            tHTMLAlert += '      <div class="modal-content">';
            tHTMLAlert += '          <div class="modal-header xCNModalHead">';
            tHTMLAlert += '              <label class="xCNTextModalHeard">'+'<?=language('common/main/main', 'tModalWarning')?>'+'</label>'; 
            tHTMLAlert += '          </div>';
            tHTMLAlert += '          <div class="modal-body">'+'<?=language('common/main/main', 'tCNWarningPADA')?>'+'</div>';
            tHTMLAlert += '          <div class="modal-footer">';
            tHTMLAlert += '              <button id="obtCancelPassword" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">';
            tHTMLAlert += '                  <?php echo language('common/main/main', 'tModalCancel')?>';
            tHTMLAlert += '              </button>';
            tHTMLAlert += '          </div>';
            tHTMLAlert += '      </div>';
            tHTMLAlert += '  </div>';
            tHTMLAlert += '</div>';
            $('body').append(tHTMLAlert);

            setTimeout(function(){
                $('#oetPasswordOld').val('');
                $('#oetPasswordNew').val('');
                $('#odlPasswordNomatch').css("display", "none");
                $('#odlChgPasswordConf').css("display", "none");
                $('#odlChgPassword').hide();  // ถ้าเปลี่ยน Password ใหม่ แล้ว เหมือนกับ Password เก่า จะไม่อณุญาติ (Bell)
                $('#odlChkDegitPassword').hide();  // เช็ค Password ถ้า key ถึง 8 degit (Bell)
                $('#odvmodalChangePassword').modal("toggle");

                $('#oahCPWPolicy').off('click').on('click',function(){
                    $('#ocbCPWAccpetAgree').attr('disabled',false);
                    $('#oblAccpetAgree').removeClass('xCNDisabled');
                });

                $('#oblAccpetAgree').off('click').on('click',function(){
                    if( $('#ocbCPWAccpetAgree').attr('disabled') === 'disabled' ){
                        $('#odvmodalAlertPolicyChangePassword').modal('show');
                    }
                });
                

                $('#ocbCPWAccpetAgree').off('change').on('change',function(){
                    if( $('#ocbCPWAccpetAgree').prop('checked') === true ){
                        $('#obtConfirmPassword').attr('disabled',false);
                    }else{
                        $('#obtConfirmPassword').attr('disabled',true);
                    }
                });

                setTimeout(function(){
                    $('.xWCanEnterChgPass:not(:hidden):eq(0)').focus();
                    // $(".intro:eq(1)").css("background-color","yellow");
                    $('.xWCanEnterChgPass').on('keypress',function(){
                        $('#odlPasswordNomatch').css("display", "none");
                        $('#odlChgPasswordConf').css("display", "none");
                        $('#odlChgPassword').hide();  // ถ้าเปลี่ยน Password ใหม่ แล้ว เหมือนกับ Password เก่า จะไม่อณุญาติ (Bell)
                        $('#odlChkDegitPassword').hide();  // เช็ค Password ถ้า key ถึง 8 degit (Bell)
                        // console.log(event.keyCode);
                        if(event.keyCode == 13){
                            if( $('#obtConfirmPassword').attr('disabled') === 'disabled' ){
                                $('#odvmodalAlertPolicyChangePassword').modal('show');
                            }else{
                                $('#obtConfirmPassword').click();
                            }
                        }
                    });
                }, 600);
            }, 500);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

    
    
}

// Create By Napat(Jame) 14/05/2020
// Last Update : 16/11/2020 Napat(Jame) เพิ่มการแสดง Error Message หลายเคส และรับค่าจาก input username
// เปลี่ยนรหัสผ่าน
function JCNxCheckPassword(pnStaAct,ptStaLogType){
    var tUsrLogin       = $('#oetUserLogin').val();
    var tPassOld        = $('#oetPasswordOld').val();
    var tPassNew        = $('#oetPasswordNew').val();
    var tPassConf       = $('#oetPasswordConf').val();
    var tConfirmlogin   = '<?=language('common/main/main','tModalConfirmlogin');?>';
    var tMsgConfirm     = tConfirmlogin;

    if( tUsrLogin == '' || tUsrLogin == null ){
        $('#oetUserLogin').focus();
    }else if(tPassOld == '' || tPassOld == null){
        $('#oetPasswordOld').focus();
    }else if( tPassNew == '' || tPassNew == null ){
        $('#oetPasswordNew').focus(); 
    }else if(tPassOld == tPassNew){   // ถ้าเปลี่ยน Password ใหม่ แล้ว เหมือนกับ Password เก่า จะไม่อณุญาติ  (Request จาก Tester พี่เล้ง) 
        $('#odlChgPassword').show();
    }else if(tPassNew != tPassConf){
        $('#odlChgPasswordConf').show();
    }else{

        tApprove = false;
        //ถ้า TYPE : PIN
        if($('#ohdtypeChangePassword').val() == 2){
            if($('#oetPasswordNew').val().length < 6){
                $('#odlChkDegitPassword').text('กรุณากรอกรหัสขั้นต่ำ 6 ตัวอักษร');
                $('#odlChkDegitPassword').show(); // เช็ค Password ถ้า key ถึง 6 degit (Bell)
                return;
            }else{
                var tApprove = true;
            }
        }else{
            //ถ้า TYPE : PASSWORD + OTHER
            if($('#oetPasswordNew').val().length < 8){   
                $('#odlChkDegitPassword').text('กรุณากรอกรหัสขั้นต่ำ 8 ตัวอักษร');
                $('#odlChkDegitPassword').show(); // เช็ค Password ถ้า key ถึง 8 degit (Bell)
                return;
            }else{
                var tApprove = true;
            }
        }


        if(tApprove == true){
            var tEncPasswordOld = JCNtAES128EncryptData(tPassOld, tKey, tIV);
            var tEncPasswordNew = JCNtAES128EncryptData(tPassNew, tKey, tIV);

            $.ajax({
                type: "POST",
                url: "cmmUSREventChangePassword",
                data: { 
                    ptPasswordOld : tEncPasswordOld,
                    ptPasswordNew : tEncPasswordNew,
                    pnChkUsrSta   : pnStaAct,
                    ptUsrLogin    : tUsrLogin,
                    ptStaLogType  : ptStaLogType,
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturn = JSON.parse(oResult);
                    // console.log(aReturn);
                    if(aReturn['nCode'] == '1'){
                        console.log('LOG >> change password success');
                        $('#odlPasswordNomatch').css("display", "none");
                        $('#odvmodalChangePassword').modal("toggle");
                        var tMsgConfirm   = tConfirmlogin;
                        FSvCMNMsgSucessDialog('<p class="text-left">'+tMsgConfirm+'</p>');
                        setTimeout(function(){
                            document.location = 'logout';
                        }, 2000);
                    }else{
                        // alert(aReturn['nCode']);
                        console.log('LOG >> error change password');

                        var tMsgErr = "";
                        switch(aReturn['nCode']){
                            case '999':
                                tMsgErr = '<?php echo language('common/main/main','tMNUUserNotFound')?>';           /*ไม่พบชื่อผู้ใช้*/
                                break;
                            case '998':
                                tMsgErr = '<?php echo language('common/main/main','tMNUChangePasswordNoMatch')?>';  /*รหัสผ่านเดิมไม่ถูกต้อง*/
                                break;
                            case '997':
                                tMsgErr = '<?php echo language('common/main/main','tMNUUserDisabled')?>';           /*สถานะไม่ใช้งาน ไม่สามารถเปลี่ยนรหัสผ่าน*/
                                break;
                            case '996':
                                tMsgErr = '<?php echo language('common/main/main','tMNUUserExpire')?>';             /*หมดอายุไม่สามารถเปลี่ยนรหัสผ่าน*/
                                break;
                            default:
                                tMsgErr = '<?php echo language('common/main/main','tMNUChangePasswordNoMatch')?>';
                        }
                        
                        $('#odlPasswordNomatch').text(tMsgErr);
                        $('#odlPasswordNomatch').css("display", "block");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    (jqXHR, textStatus, errorThrown);
                }
            });
        }
    }
}

</script>
