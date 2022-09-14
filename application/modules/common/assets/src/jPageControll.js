//Loading URL Page
$(function () {

    var noEmailError = "<?php echo $this->lang->line('enter_your_email'); ?>";

    $("ul.get-menu li > a").unbind().click(function () {
        localStorage.GrpBothNumItem = ''; //Remove Local Storage
        var tURL    = $(this).data('mnrname');

        // Create By : Napat(Jame) 14/01/2021
        // ถ้าเมนูหมดอายุ จะกดเมนูไม่ได้
        var tExpire = $(this).data('expire');
        if( tExpire == '1' ){
            return false;
        }

        if(tURL == '' || tURL == null){
            JCNxCloseLoading();
            $('#odvMenuNotFound').modal({ show: true });
            return;
        }

        // ฟังก์ชั่น Check Session
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

            if ( typeof(oDOVEventChkNewData) !== 'undefined' ){
                clearInterval(oDOVEventChkNewData);
            }
            
            $.ajax({
                url: tURL,
                type: "POST",
                error: function (jqXHR, textStatus, errorThrown) {
    
                    JCNxCloseLoading();
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                },
                success: function (tView) {

                    //console.log(tView);
                    $(window).scrollTop(0);
                    $('.odvMainContent').html(tView);

                    // Chk Status Favorite
                    JSxChkStaDisFavorite(tURL);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    //Control Navibar
    var nNavibarHeight = $('.navbar').height();
    $('#odvNavibarClearfixed').css('height', nNavibarHeight);

});

$(window).resize(function () {
    var nNavibarHeight = $('.navbar').height();
    $('#odvNavibarClearfixed').css('height', nNavibarHeight);

    JCNxLayoutControll();
});



function JCNxLayoutControll() {
    //Control Height MenuCump
    var nCumpBarHeight = $('.main-menu').height();
    nCumpBarHeight = nCumpBarHeight + 15;
    $('#odvMenuCump').css('height', nCumpBarHeight);
}


// Create By Witsarut 13/01/2020
//ChkStatus rDisble 1 and 2
function JSxChkStaDisFavorite(ptStadissable){
    $.ajax({
        type: "POST",
        url: "ChkStafavorite",
        dataType : "json",
        cache: false,
        data: {
            tStadissable  :   ptStadissable
        },
        success: function (tResult){
            // console.log(tResult)
            if(tResult.rDisable == 2){
                $('#oimImgFavicon').removeClass('xCNDisabled');
                $('#oimImgFavicon').removeClass('xWImgDisable');
            }else{
                $('#oimImgFavicon').addClass('xCNDisabled');
                $('#oimImgFavicon').addClass('xWImgDisable');
            }
        },
        timeout: 0,
        error: function (data) {
            console.log(data);
        }
    });
}

/*
* Functionality : ปุ่ม กด menu fav
* Parameters : poEvent = route 
* Creator : 14/1/2020 nonpaiwch(petch)
* Last Modified : -
* Return : -
* Return Type : -
*/  
function JSxCallmenuFav(poEvent){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var tURL = $(poEvent).attr('data-menu');
        $.ajax({
            url: tURL,
            type: "POST",
            success: function (tView) {
                $(window).scrollTop(0);
                $('.odvMainContent').html(tView);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxCloseLoading();
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            },
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

