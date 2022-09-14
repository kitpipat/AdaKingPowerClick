<script type="text/javascript">

    // CML = CourierMan Login

    function JSxCMLGetContent(){
        var tRoutepage = '<?=$tRoute?>';

        if(tRoutepage == 'courierManEventAdd'){
            return;
        }else{
            $('#odvBtnAddEdit').hide(); // ซ่อนปุ่มบันทึกใหญ่ เนื่องจากหน้าจอนี้มีบันทึกย่อย 09/11/2020 Napat(Jame)
            var tCryCode        = '<?php echo @$tCryCode?>';
            var tCryManCardID   = '<?php echo @$tCryEmp?>';
            // Check Login Expried
            var nStaSession = JCNxFuncChkSessionExpired();

            // If has Session 
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                $.ajax({
                    type	: "POST",
                    url		: "courierlogin",
                    data	: {
                        tCryCode        : tCryCode,
                        tCryManCardID   : tCryManCardID
                    },
                    cache	: false,
                    timeout	: 0,
                    success	: function(tResult){
                        $('#odvCourierLoginData').html(tResult);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
            // End Check Login Exprie

        }
    }

    // Create By : Kitpipat
    // Create Date : 10/08/2019
    // Functional : Save And Edit CourireMan Login
    // Return : -
    // Return Type : -
    // Parameter : Route Name
    function JSxGetCurManContentCurLoginAdd(ptRouteName){
            
            tActionToRoute = ptRouteName.trim(); //Route Name
            // alert(tActionToRoute);

            nStaSession = JCNxFuncChkSessionExpired(); //Check Session Login

            // Check Session Expried
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

               // IF Has Session Go To Process
               // Get Data Form Input 
               oDataCouierManAccount = $( "#ofmAddEditCourierManLogin" ).serialize();
               console.log(oDataCouierManAccount);
                    
               $.ajax({
                    type	: "POST",
                    url		: tActionToRoute,
                    data	: oDataCouierManAccount,
                    cache	: false,
                    timeout	: 0,
                    success	: function(tResult){
                        console.log(tResult);
                        // alert(tResult);
                        $('#odvCourierLoginData').html(tResult);

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });

            }else{

               //IF Empty Session Expried Alter Message
               JCNxShowMsgSessionExpired();

            } 
     
    }

   

</script>