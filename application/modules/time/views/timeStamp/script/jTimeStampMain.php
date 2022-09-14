<script>

    $(function(){
        setInterval(JSxCallUpdateTime, 1000);

        //BTN Input
        $('#obtTimeStampInput').click(function() {
            //BTN - Input Add Active
            $('#oetTimeStampInputorOutput').val(1);
            $('#obtTimeStampInput').removeClass('xCNBTNTimeStampOutput');
            $('#obtTimeStampInput').addClass('xCNBTNTimeStampInput');
            
            //BTN - Output Remove Active
            $('#obtTimeStampOutput').removeClass('xCNBTNTimeStampInput');
            $('#obtTimeStampOutput').addClass('xCNBTNTimeStampOutput');
        });

        //BTN Output
        $('#obtTimeStampOutput').click(function() {
            //BTN - Output Add Active
            $('#oetTimeStampInputorOutput').val(2);
            $('#obtTimeStampOutput').removeClass('xCNBTNTimeStampOutput');
            $('#obtTimeStampOutput').addClass('xCNBTNTimeStampInput');
            
            //BTN - Input Remove Active
            $('#obtTimeStampInput').removeClass('xCNBTNTimeStampInput');
            $('#obtTimeStampInput').addClass('xCNBTNTimeStampOutput');
        });

        //Call Table Last
        JSxCallTableGetLastInputandOutput();

        //กดตรวจสอบ ไปหน้าแสดงข้อมูล
        $('#obtCheckDetail').click(function() {
            JSxCallPageCheckDetail();
        });
    });

    //Get Time and Date
    function JSxCallUpdateTime(){
        
        var oFormatDay  = new Date();
        var tDayText    = oFormatDay.getDay();
        var nDay        = oFormatDay.getDate();
        var nMonth      = oFormatDay.getMonth() + 1;
        var nYear       = oFormatDay.getFullYear();
        
        var nHours      = oFormatDay.getHours();
        var nMinutes    = oFormatDay.getMinutes();
        var nSeconds    = oFormatDay.getSeconds();

        var tFormateTime = nHours + ':' + nMinutes + ':' + nSeconds;
        $('#ospTimeStampTime').html( tFormateTime );

        //Switch วัน
        switch(tDayText) {
        case 0:
            tResultGetDay = '<?= language('time/timeStamp/timeStamp','tTimeStampD01')?>';
            break;
        case 1:
            tResultGetDay = '<?= language('time/timeStamp/timeStamp','tTimeStampD02')?>';
            break;
        case 2:
            tResultGetDay = '<?= language('time/timeStamp/timeStamp','tTimeStampD03')?>';
            break;
        case 3:
            tResultGetDay = '<?= language('time/timeStamp/timeStamp','tTimeStampD04')?>';
            break;
        case 4:
            tResultGetDay = '<?= language('time/timeStamp/timeStamp','tTimeStampD05')?>';
            break;
        case 5:
            tResultGetDay = '<?= language('time/timeStamp/timeStamp','tTimeStampD06')?>';
            break;
        case 6:
            tResultGetDay = '<?= language('time/timeStamp/timeStamp','tTimeStampD07')?>';
            break;
        default:
        }
        
        //Switch เดือน
        switch(nMonth) {
        case 1:
            nMonth = '<?= language('time/timeStamp/timeStamp','tTimeStampM01')?>';
            break;
        case 2:
            nMonth = '<?= language('time/timeStamp/timeStamp','tTimeStampM02')?>';
            break;
        case 3:
            nMonth = '<?= language('time/timeStamp/timeStamp','tTimeStampM03')?>';
            break;
        case 4:
            nMonth = '<?= language('time/timeStamp/timeStamp','tTimeStampM04')?>';
            break;
        case 5:
            nMonth = '<?= language('time/timeStamp/timeStamp','tTimeStampM05')?>';
            break;
        case 6:
            nMonth = '<?= language('time/timeStamp/timeStamp','tTimeStampM06')?>';
            break;
        case 7:
            nMonth = '<?= language('time/timeStamp/timeStamp','tTimeStampM07')?>';
            break;
        case 8:
            nMonth = '<?= language('time/timeStamp/timeStamp','tTimeStampM08')?>';
            break;
        case 9:
            nMonth = '<?= language('time/timeStamp/timeStamp','tTimeStampM09')?>';
            break;
        case 10:
            nMonth = '<?= language('time/timeStamp/timeStamp','tTimeStampM010')?>';
            break;
        case 11:
            nMonth = '<?= language('time/timeStamp/timeStamp','tTimeStampM011')?>';
            break;
        case 12:
            nMonth = '<?= language('time/timeStamp/timeStamp','tTimeStampM012')?>';
            break;
        default:
        }

        var tFormateDate = tResultGetDay + ' , ' + nDay + ' ' + nMonth + ' ' + nYear;
        $('#ospTimeStampDate').html( tFormateDate );
    }

    //Insert
    function JSxCallInsert(){
        var oetTimeStampUser        = $('#oetTimeStampUser').val();
        var oetTimeStampPassword    = $('#oetTimeStampPassword').val();
        var oetTypeInputOrOutput    = $('#oetTimeStampInputorOutput').val();
        var tOldPassword            = $('#oetTimeStampPassword').val();
		var tEncPassword            = JCNtAES128EncryptData(tOldPassword, tKey, tIV);

        $.ajax({
            type    : "POST",
            url     : "timeStampMainInsert",
            data    : { 
                'oetTimeStampUser'      : oetTimeStampUser,
                'oetTimeStampPassword'  : tEncPassword,
                'oetTypeInputOutput'    : oetTypeInputOrOutput
            },
            cache   : false,
            success: function(tResult) {
                if(tResult == 'UsernameorpasswordFail'){
                    //alert('Username or Password is Failed');
                    $('#ospMsgError').text('<?= language('time/timeStamp/timeStamp','tMsgUserPassFail')?>');
                    $('#oliLabelError').fadeIn();
                    $('#oliLabelError').css('display','block');
                    setTimeout(function(){  $('#oliLabelError').fadeOut(); }, 3000);
                }else if(tResult == 'CheckinIsDuplicate'){
                    //alert('ไม่สามารถ ลงเวลาเข้างานซ้ำ');
                    $('#ospMsgError').text('<?= language('time/timeStamp/timeStamp','tMsgCheckinDuplicate')?>');
                    $('#oliLabelError').fadeIn();
                    $('#oliLabelError').css('display','block');
                    setTimeout(function(){  $('#oliLabelError').fadeOut(); }, 3000);
                }else if(tResult == 'CheckoutIsDuplicate'){
                    //alert('ไม่สามารถ ลงเวลาออกซ้ำ');
                    $('#ospMsgError').text('<?= language('time/timeStamp/timeStamp','tMsgCheckoutDuplicate')?>');
                    $('#oliLabelError').fadeIn();
                    $('#oliLabelError').css('display','block');
                    setTimeout(function(){  $('#oliLabelError').fadeOut(); }, 3000);
                }else if(tResult == 'PleseCheckOut'){
                    $('#ospMsgError').text('<?= language('time/timeStamp/timeStamp','tMsgCheckinDuplicate')?>');
                    $('#oliLabelError').fadeIn();
                    $('#oliLabelError').css('display','block');
                    setTimeout(function(){  $('#oliLabelError').fadeOut(); }, 3000);
                }else{
                    $('#ospMsgSuccess').text('<?= language('time/timeStamp/timeStamp','tMsgTimeStampSuccess')?>');
                    $('#oliLabelSuccess').fadeIn();
                    $('#oliLabelSuccess').css('display','block');
                    setTimeout(function(){  $('#oliLabelSuccess').fadeOut(); }, 3000);
                    JSxCallTableGetLastInputandOutput();
                }

                JSxCallTableGetHistoryInputandOutput(oetTimeStampUser);

                //ล้างค่า
                //$('#oetTimeStampUser').val('');
                //$('#oetTimeStampPassword').val('');
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    //Get History Input and Output
    function JSxCallTableGetHistoryInputandOutput(pnUsercode){
        $.ajax({
            type    : "POST",
            url     : "timeStampMainGetHistoryCheckinCheckout",
            data    : { pnUsercode : pnUsercode },
            cache   : false,
            success: function(tResult) {
                $('#odvContentHistoryInputOutput').html(tResult);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    //Get Last Input and Output
    function JSxCallTableGetLastInputandOutput(){
        $.ajax({
            type    : "POST",
            url     : "timeStampMainGetLastCheckinCheckout",
            cache   : false,
            success: function(tResult) {
                $('#odvContentLastInputOutput').html(tResult);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

</script>