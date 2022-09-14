$('document').ready(function() {
    var tEmailURL = $('#oetUnsendEmailCstEmailURL').val();
    var tDecrytEmail = JCNtAES128DecryptData(tEmailURL, '5YpPTypXtwMML$u@', 'zNhQ$D%arP6U8waL');
    $('#oetUnsendEmailCstEmailShow').val(tDecrytEmail)
    $('#oetUnsendEmailCstEmail').val(tDecrytEmail)
    var tBaseURL = $('#ohdbaseurlunsub').val();
    $('.xWUnSubShow').css('backgroundImage', 'url(' + tBaseURL + 'application/modules/common/assets/images/bg/Backoffice.jpg)');


    if (tDecrytEmail == '' || tDecrytEmail == null) {
        $("#obtUnsendEmailSubmit").attr("disabled", true);
    }

});


//Functionality : Event Call API
//Parameters : 
//Creator : 18/02//2021  Worakorn
//Return : -
//Return Type : -
function JSxUEMSubmit() {
    var tEmail = $('#oetUnsendEmailCstEmail').val()
    var tBaseURL = $('#ohdbaseurlunsub').val();

    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: tBaseURL + "/UnsendEmailSubmit",
        data: {
            tCstEmail: tEmail,
        },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            console.log(tResult);
            var aReturn = JSON.parse(tResult);
            if (aReturn['rtCode'] == 1) {
                $('#ofmUnsendEmail').append("<div id='odvsuccessunsub' name='odvsuccessunsub' style='padding:0; text-align:center; margin-top:10px;' class='col-xs-12 col-sm-12 col-md-12 col-lg-12' ><label style='color:green;'>ยกเลิกการรับข่าวสารเรียบร้อย</label></div>");
                // setTimeout(function() {
                //     $('#odvsuccessunsub').fadeOut('fast');
                // }, 3000);
            } else {
                alert('Error');
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

}