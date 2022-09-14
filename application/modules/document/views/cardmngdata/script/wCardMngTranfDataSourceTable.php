<script type="text/javascript">

    $(document).ready(function(){
        var oSetQtySucessAllRow = {
            'tQtyAllRow'    : $('#ohdCardMngShiftChangeCountRowFromTemp').val(),
            'tQtySucessRow' : $('#ohdCardMngShiftChangeCountSuccess').val()
        }
        JSxSetQtyCardAllAndAllRow(oSetQtySucessAllRow);
    });
    
    // Functionality : control ปุ่ม เซฟ ยกเลิก บันทึก
    // Parameters : [poElement] is seft element in scope(<tr class="xWCardShiftChangeDataSource">), 
    //              [ptOperation] is icon type(edit, cancel, save), [pbVisibled] is true = show, false = hide
    // Creator : 07/12/2018 Wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JSxCardMngShiftChangeDataSourceVisibledOperationIcon(poElement, ptOperation, pbVisibled) {
        try {
            switch (ptOperation) {
                case 'edit' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftChangeDataSource')
                                .find('.xWCardShiftChangeEdit'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftChangeDataSource')
                                .find('.xWCardShiftChangeEdit'))
                                .addClass('hidden');
                    }
                    break;
                }
                case 'cancel' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftChangeDataSource')
                                .find('.xWCardShiftChangeCancel'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftChangeDataSource')
                                .find('.xWCardShiftChangeCancel'))
                                .addClass('hidden');
                    }
                    break;
                }
                case 'save' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftChangeDataSource')
                                .find('.xWCardShiftChangeSave'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftChangeDataSource')
                                .find('.xWCardShiftChangeSave'))
                                .addClass('hidden');
                    }
                    break;
                }
                default :
                {
                }
            }
        } catch (err) {
            console.log('JJSxCardShiftChangeDataSourceVisibledOperationIcon Error: ', err);
        }
    }

    // Functionality : กดปุ่ม edit
    // Parameters : poElement is Itself element, poEvent is Itself event
    // Creator : 08/01/2019 Wasin(Yoshi)
    // Last Modified : 15/01/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : -
    function JSxCardMngShiftChangeDataSourceEditOperator(poElement, poEvent, pnSeq){
        poElement = (typeof poElement !== 'undefined') ? poElement : null; 
        poEvent = (typeof poEvent !== 'undefined') ? poEvent : null;
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tRecordId = $(poElement).parents('.xWCardShiftChangeDataSource').attr('id');
            var oRecord = {
                tNewCardCode: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeNewCardCode input[type=hidden]').val(),
                tNewCardName: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeNewCardCode input[type=text]').val(),
                tOldCardCode: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeCardCode input[type=hidden]').val(),
                tOldCardName: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeCardCode input[type=text]').val(),
                tReasonCode: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeReason input[type=hidden]').val(),
                tReasonName: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeReason input[type=text]').val()
            };

            //Set Local Storage
            localStorage.setItem(tRecordId, JSON.stringify(oRecord));

            // Visibled icons
            JSxCardMngShiftChangeDataSourceVisibledOperationIcon(poElement, 'edit', false); // Itself hidden(edit)
            JSxCardMngShiftChangeDataSourceVisibledOperationIcon(poElement, 'cancel', true); // hidden cancel icon
            JSxCardMngShiftChangeDataSourceVisibledOperationIcon(poElement, 'save', true); // hidden save icon
            
            $(poElement) // Active Old Card Code Field.
                    .parents('.xWCardShiftChangeDataSource')
                    .find('.xWCardShiftChangeCardCode input[type=text]')
                    .removeAttr('disabled')
                    .attr('readonly', true)
                    .addClass('btn');

            $(poElement) // Active New Card Name Field.
                    .parents('.xWCardShiftChangeDataSource')
                    .find('.xWCardShiftChangeNewCardCode input[type=text]')
                    .removeAttr('disabled')
                    .attr('readonly', true)
                    .addClass('btn');

            $(poElement) // Active Reason Name Field.
                    .parents('.xWCardShiftChangeDataSource')
                    .find('.xWCardShiftChangeReason input[type=text]')
                    .removeAttr('disabled')
                    .attr('readonly', true)
                    .addClass('btn');
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // Functionality : กดปุ่ม save 
    // Parameters : poElement is Itself element, poEvent is Itself event, pnSeq is index in loop
    // Creator : 08/01/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JSxCardMngShiftChangeDataSourceSaveOperator(poElement, poEvent) {
        try{
            poElement = (typeof poElement !== 'undefined') ? poElement : null; 
            poEvent = (typeof poEvent !== 'undefined') ? poEvent : null;
            var tRecordId       = $(poElement).parents('.xWCardShiftChangeDataSource').attr('id');
            var oPrefixNumber   = tRecordId.match(/\d+/);
            
            var oRecord = {
                nPage: $('#ohdCardShiftChangeDataSourceCurrentPage').val(),
                nSeq: $(poElement).parents('.xWCardShiftChangeDataSource').data('seq'),
                tNewCardCode: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeNewCardCode input[type=hidden]').val(),
                tNewCardName: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeNewCardCode input[type=text]').val(),
                tOldCardCode: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeCardCode input[type=hidden]').val(),
                tOldCardName: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeCardCode input[type=text]').val(),
                tReasonCode: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeReason input[type=hidden]').val(),
                tReasonName: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeReason input[type=text]').val()
            };


            // Update in document temp
            JSxCardMngShiftChangeUpdateDataOnTemp(oRecord.tOldCardCode, oRecord.tNewCardCode, oRecord.tReasonCode, oRecord.nSeq, oRecord.nPage);

            // Remove Seft Record Backup
            localStorage.removeItem(tRecordId);

            // Visibled icons
            JSxCardMngShiftChangeDataSourceVisibledOperationIcon(poElement, 'save', false); // Itself hidden(save)
            JSxCardMngShiftChangeDataSourceVisibledOperationIcon(poElement, 'cancel', false); // hidden cancel icon
            JSxCardMngShiftChangeDataSourceVisibledOperationIcon(poElement, 'edit', true); // show edit icon

            $(poElement) // Remove Active Old Card Code Field.
                    .parents('.xWCardShiftChangeDataSource')
                    .find('.xWCardShiftChangeCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

            $(poElement) // Remove Active New Card Name Field.
                    .parents('.xWCardShiftChangeDataSource')
                    .find('.xWCardShiftChangeNewCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

            $(poElement) // Remove Active Reason Name Field.
                    .parents('.xWCardShiftChangeDataSource')
                    .find('.xWCardShiftChangeReason input[type=text]')
                    .attr('disabled', true)
                    .attr('readonly', true)
                    .removeClass('btn');

        } catch(err){
            console.log('JSxCardMngShiftChangeDataSourceSaveOperator Error: ', err);
        }
    }
    
    // Functionality : กดปุ่ม cancle
    // Parameters : poElement is Itself element, poEvent is Itself event
    // Creator : 08/01/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JSxCardMngShiftChangeDataSourceCancelOperator(poElement, poEvent) {
        try {
            var tRecordId = $(poElement).parents('.xWCardShiftChangeDataSource').attr('id');

            // Restore Seft Record
            var oBackupRecord = JSON.parse(localStorage.getItem(tRecordId));
            $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeNewCardCode input[type=hidden]').val(oBackupRecord.tNewCardCode);
            $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeNewCardCode input[type=text]').val(oBackupRecord.tNewCardName);
            $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeCardCode input[type=hidden]').val(oBackupRecord.tOldCardCode);
            $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeCardCode input[type=text]').val(oBackupRecord.tOldCardName);
            $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeReason input[type=hidden]').val(oBackupRecord.tReasonCode);
            $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeReason input[type=text]').val(oBackupRecord.tReasonName);

            // Remove Seft Record Backup
            localStorage.removeItem(tRecordId);

            // Visibled icons
            JSxCardMngShiftChangeDataSourceVisibledOperationIcon(poElement, 'cancel', false); // Itself hidden(cancel)
            JSxCardMngShiftChangeDataSourceVisibledOperationIcon(poElement, 'save', false); // hidden save icon
            JSxCardMngShiftChangeDataSourceVisibledOperationIcon(poElement, 'edit', true); // show edit icon


            $(poElement) // Remove Active Old Card Code Field.
                    .parents('.xWCardShiftChangeDataSource')
                    .find('.xWCardShiftChangeCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

            $(poElement) // Remove Active New Card Name Field.
                    .parents('.xWCardShiftChangeDataSource')
                    .find('.xWCardShiftChangeNewCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

            $(poElement) // Remove Active Reason Name Field.
                    .parents('.xWCardShiftChangeDataSource')
                    .find('.xWCardShiftChangeReason input[type=text]')
                    .attr('disabled', true)
                    .attr('readonly', true)
                    .removeClass('btn');

        }catch (err) {
            console.log('JSxCardMngShiftChangeDataSourceCancelOperator Error: ', err);
        }
    }
    
    // Functionality : ฟังก์ชั่น save edit in line  
    // Parameters : tCardCode, tNewCardCode, tReasonCode, pnPage
    // Creator : 08/01/2019 Wasin(Yoshi)
    // Last Modified : 15/01/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : -
    function JSxCardMngShiftChangeUpdateDataOnTemp(ptCardCode, ptNewCardCode, ptReasonCode, pnSeq, pnPage) {
        try{
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "cardShiftChangeUpdateInlineOnTemp",
                    data: {
                        tCardNumber     : ptCardCode,
                        tNewCardNumber  : ptNewCardCode,
                        tReasonCode     : ptReasonCode,
                        nSeq            : pnSeq
                    },
                    cache: false,
                    Timeout: 5000,
                    success: function(tResult) {
                        var tDocType    = 'CardTnfChangeCard';
                        var tIDElement  = 'odvPanelCmdMngDataDetail';
                        JSvClickCallTableTemp(tDocType,pnPage,tIDElement);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        }catch(err){
            console.log('JSxCardMngShiftChangeUpdateDataOnTemp Error: ', err);
        }
    }

    // Functionality : กด Delete
    // Parameters : poElement is Itself element, poEvent is Itself event
    // Creator : 08/01/2019 Wasin(Yoshi)
    // Last Modified : 15/01/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : -
    function JSxCardMngShiftChangeDataSourceDeleteOperator(poElement, poEvent, pnPage, ptOldCardCode, pnSeq) {
        try{
            poElement = (typeof poElement !== 'undefined') ? poElement : null; 
            poEvent = (typeof poEvent !== 'undefined') ? poEvent : null;
            pnPage = (typeof pnPage !== 'undefined') ? pnPage : 1;
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                $('#ospCardShiftChangeConfirDelMessage').html(ptOldCardCode);
                $('#odvCardShiftChangeModalConfirmDelRecord').modal({backdrop: 'static', keyboard: false});
                $('#odvCardShiftChangeModalConfirmDelRecord').modal('show');
                $('#osmCardShiftChangeConfirmDelRecord').unbind().click(function(evt) {
                    $('#odvCardShiftChangeModalConfirmDelRecord').modal('hide');
                    JCNxOpenLoading();
                    $.ajax({
                        type: "POST",
                        url: "CallDeleteTemp",
                        data: {ptID: ptOldCardCode, pnSeq: pnSeq, ptDocType: "CardTnfChangeCard"},
                        cache: false,
                        success: function (tResult) {
                            var tDocType    = 'CardTnfChangeCard';
                            var tIDElement  = 'odvPanelCmdMngDataDetail';
                            JSvClickCallTableTemp(tDocType,pnPage,tIDElement);
                            JCNxCloseLoading();
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        }catch(err){
            console.log('JSxCardMngShiftChangeDataSourceDeleteOperator Error: ', err);
        }
    }

    // Functionality : Fiction Click Page DataTemp
    // Parameters : poElement is Itself element, poEvent is Itself event
    // Creator : 09/01/2019 wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JSvCardShiftChangeDataSourceClickPage(ptPage, tDocType, ptIDElement) {
        try{
            JCNxOpenLoading();

            var nPageCurrent = '';
            switch (ptPage) {
                case 'next': //กดปุ่ม Next
                    nPageOld = $('.xWCardShiftChangeDataSourcePage .active').text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent = nPageNew
                    break;
                case 'previous': //กดปุ่ม Previous
                    nPageOld = $('.xWCardShiftChangeDataSourcePage .active').text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent = nPageNew
                    break;
                default:
                    nPageCurrent = ptPage
            }

            var tDocType    = 'CardTnfChangeCard';
            var tIDElement  = 'odvPanelCmdMngDataDetail';
            JSvClickCallTableTemp(tDocType,nPageCurrent,tIDElement);
        }catch(err){
            console.log('JSvCardShiftChangeDataSourceClickPage Error: ', err);
        }
    }
    
    /**
    * Functionality : Set card code temp
    * Parameters : -
    * Creator : 16/10/2018 piya
    * Last Modified : -
    * Return : -
    * Return Type : -
    */
    function JSxCardMngChangeSetCardCodeTemp(){
        try{
            $("#ospCardShiftChangeCardCodeTemp").val("");
            setTimeout(function() {
                $("#ospCardShiftChangeCardCodeTemp").val(JSaCardMngChangeGetDataSourceCode("oldCardCode", true).toString());
            }, 800);
        }catch(err){
            console.log("JSxCardMngChangeSetCardCodeTemp Error: ", err);
        }
    }
    
    /**
    * Functionality : Get card code temp
    * Parameters : -
    * Creator : 16/10/2018 piya
    * Last Modified : -
    * Return : Card code in table record
    * Return Type : string
    */
    function JStCardMngChangeGetCardCodeTemp(){
        try{
            return $("#ospCardShiftChangeCardCodeTemp").val();
        }catch(err){
            console.log("JStCardMngChangeGetCardCodeTemp Error: ", err);
        }
    }

    /**
    * Functionality : Set doc code in table to array
    * Parameters : ptGetMode is "oldCardCode", "newCardCode", "all", "cardPack", "oldCardValue", pbWrapText is true use '', false not use ''
    * Creator : 11/10/2018 piya
    * Last Modified : -
    * Return : Doc code
    * Return Type : array
    */
    function JSaCardMngChangeGetDataSourceCode(ptGetMode, pbWrapText){
        try{
            ptGetMode = (typeof ptGetMode !== 'undefined') ?  ptGetMode : "all";
            pbWrapText = (typeof pbWrapText !== 'undefined') ?  pbWrapText : false;

            // Set data
            let aAll = [];
            let aOldCardCode = [];
            let aNewCardCode = [];
            let aOldCardBal = [];
            let aCardPack = [];

            let oRecord = JSON.parse($("#ospCardShiftChangeCardCodeTemp").text());
            // console.log("Data source: ", oRecord);
            $.each(oRecord.raItems, function(pnIndex, poElement) {
                // console.log("pnIndex: ", pnIndex);
                console.log("poElement: ", poElement.FTCvdOldCode);
                if(pbWrapText){
                    aOldCardCode.push("'" + poElement.FTCvdOldCode + "'");
                    aNewCardCode.push("'" + poElement.FTCvdNewCode + "'");
                    aAll.push("'" + poElement.FTCvdOldCode + "'");
                    aAll.push("'" + poElement.FTCvdNewCode + "'");
                    aOldCardBal.push("'" + poElement.FCCvdOldBal + "'");

                    aCardPack.push(
                        {
                            "oldCardCode" : "'" + poElement.FTCvdOldCode + "'", 
                            "oldCardBal" : "'" + poElement.FCCvdOldBal + "'",
                            "newCardCode" : "'" + poElement.FTCvdNewCode + "'",
                            "reasonCode" : "'" + $(poElement).find('.xWCardShiftChangeReasonCodeTemp').val() + "'",
                            "cardStatus" : poElement.FTCvdNewCode,
                            "cardStatusRmk" : poElement.FTCvdRmk
                        }
                    );         
                }else{
                    aOldCardCode.push(poElement.FTCvdOldCode);
                    aNewCardCode.push(poElement.FTCvdNewCode);
                    aAll.push(poElement.FTCvdOldCode);
                    aAll.push(poElement.FTCvdNewCode);
                    aOldCardBal.push(poElement.FCCvdOldBal);

                    aCardPack.push(
                        {
                            "oldCardCode" : poElement.FTCvdOldCode, 
                            "oldCardBal" : poElement.FCCvdOldBal,
                            "newCardCode" : poElement.FTCvdNewCode,
                            "reasonCode" : $(poElement).find('.xWCardShiftChangeReasonCodeTemp').val(),
                            "cardStatus" : poElement.FTCvdNewCode,
                            "cardStatusRmk" : poElement.FTCvdRmk
                        }
                    ); 
                }
            });

            if(ptGetMode == "oldCardCode"){
                return aOldCardCode;
            }
            if(ptGetMode == "oldCardValue"){
                return aOldCardBal;
            }
            if(ptGetMode == "newCardCode"){
                return aNewCardCode;
            }
            if(ptGetMode == "cardPack"){
                return aCardPack;
            }
            if(ptGetMode == "all"){
                return aAll;
            }
        }catch(err){
            console.log("JSaCardMngChangeGetDataSourceCode Error: ", err);
        }
    }
</script>







