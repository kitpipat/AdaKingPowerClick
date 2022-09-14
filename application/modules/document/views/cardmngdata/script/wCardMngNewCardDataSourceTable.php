<script type="text/javascript">


    // Functionality : control ปุ่ม เซฟ ยกเลิก บันทึก
    // Parameters : [poElement] is seft element in scope(<tr class="xWCardMngNewCardDataSource">), 
    //              [ptOperation] is icon type(edit, cancel, save), [pbVisibled] is true = show, false = hide
    // Creator : 09/01/2019 wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JSxCardMngNewCardDataSourceVisibledOperationIcon(poElement, ptOperation, pbVisibled) {
        try {
            switch (ptOperation) {
                case 'edit' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardMngNewCardDataSource')
                                .find('.xWCardMngNewCardEdit'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardMngNewCardDataSource')
                                .find('.xWCardMngNewCardEdit'))
                                .addClass('hidden');
                    }
                    break;
                }
                case 'cancel' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardMngNewCardDataSource')
                                .find('.xWCardMngNewCardCancel'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardMngNewCardDataSource')
                                .find('.xWCardMngNewCardCancel'))
                                .addClass('hidden');
                    }
                    break;
                }
                case 'save' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardMngNewCardDataSource')
                                .find('.xWCardMngNewCardSave'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardMngNewCardDataSource')
                                .find('.xWCardMngNewCardSave'))
                                .addClass('hidden');
                    }
                    break;
                }
                default :
                {
                }
            }
        } catch (err) {
            console.log('JJSxCardMngNewCardDataSourceVisibledOperationIcon Error: ', err);
        }
    }

    // Functionality : Edit Record Before to Save.
    // Parameters : poElement is Itself element, poEvent is Itself event
    // Creator : 09/01/2019 wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JSxCardMngNewCardDataSourceEditOperator(poElement, poEvent){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tRecordId   = $(poElement).parents('.xWCardMngNewCardDataSource').attr('id');
            var oRecord     = {
                tNewCardCode    : $(poElement).parents('.xWCardMngNewCardDataSource').find('.xWCardMngNewCardCardCode input[type=text]').val(),
                tNewCardName    : $(poElement).parents('.xWCardMngNewCardDataSource').find('.xWCardMngNewCardCardName input[type=text]').val(),
                tCardTypeCode   : $(poElement).parents('.xWCardMngNewCardDataSource').find('.xWCardMngNewCardCty input[type=hidden]').val(),
                tCardTypeName   : $(poElement).parents('.xWCardMngNewCardDataSource').find('.xWCardMngNewCardCty input[type=text]').val(),
                tDepartmentCode : $(poElement).parents('.xWCardMngNewCardDataSource').find('.xWCardMngNewCardDepart input[type=hidden]').val(),
                tDepartmentName : $(poElement).parents('.xWCardMngNewCardDataSource').find('.xWCardMngNewCardDepart input[type=text]').val()
            };

            // Backup Seft Record
            localStorage.setItem(tRecordId, JSON.stringify(oRecord));

            // Visibled icons
            JSxCardMngNewCardDataSourceVisibledOperationIcon(poElement, 'edit', false); // Itself hidden(edit)
            JSxCardMngNewCardDataSourceVisibledOperationIcon(poElement, 'cancel', true); // hidden cancel icon
            JSxCardMngNewCardDataSourceVisibledOperationIcon(poElement, 'save', true); // hidden save icon

            $(poElement) // Active New Card Code Field.
                .parents('.xWCardMngNewCardDataSource')
                .find('.xWCardMngNewCardCardCode input[type=text]')
                .removeAttr('disabled')
                .addClass('active');

            $(poElement) // Active New Card Name Field.
                .parents('.xWCardMngNewCardDataSource')
                .find('.xWCardMngNewCardCardName input[type=text]')
                .removeAttr('disabled')
                .addClass('active');    

            $(poElement) // Active Card Type Field.
                .parents('.xWCardMngNewCardDataSource')
                .find('.xWCardMngNewCardCty input[type=text]')
                .removeAttr('disabled')
                .attr('readonly', true)
                .addClass('btn');

            $(poElement) // Active Department Field.
                .parents('.xWCardMngNewCardDataSource')
                .find('.xWCardMngNewCardDepart input[type=text]')
                .removeAttr('disabled')
                .attr('readonly', true)
                .addClass('btn');
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // Functionality : กดปุ่ม save 
    // Parameters : poElement is Itself element, poEvent is Itself event, pnSeq is index in loop
    // Creator : 09/01/2019 wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JSxCardMngNewCardDataSourceSaveOperator(poElement, poEvent, pnSeq, pnPage) {
        var tRecordId           = $(poElement).parents('.xWCardMngNewCardDataSource').attr('id');
        var oPrefixNumber       = tRecordId.match(/\d+/);
        var oDataChkValidateRow = {
            'nPage'                 : $('#ohdCardMngNewCardDataSourceCurrentPage').val(),
            'nSeq'                  : $(poElement).parents('.xWCardMngNewCardDataSource').data('seq'),
            'tCrdMngNewCardCode'    : $(poElement).parents('.xWCardMngNewCardDataSource').find('.xWCardMngNewCardCardCode input[type=text]').val(),
            'tCrdMngNewCardName'    : $(poElement).parents('.xWCardMngNewCardDataSource').find('.xWCardMngNewCardCardName input[type=text]').val(),
            'tCrdMngNewCtyCode'     : $(poElement).parents('.xWCardMngNewCardDataSource').find('.xWCardMngNewCardCty input[type=hidden]').val(),
            'tCrdMngNewCtyName'     : $(poElement).parents('.xWCardMngNewCardDataSource').find('.xWCardMngNewCardCty input[type=text]').val(),
            'tCrdMngNewDptCode'     : $(poElement).parents('.xWCardMngNewCardDataSource').find('.xWCardMngNewCardDepart input[type=hidden]').val(),
            'tCrdMngNewDptName'     : $(poElement).parents('.xWCardMngNewCardDataSource').find('.xWCardMngNewCardDepart input[type=text]').val()
        };

        JSxCardMngNewCardUpdateDataOnTemp(oDataChkValidateRow, pnSeq, pnPage);

        // Remove Seft Record Backup
        localStorage.removeItem(tRecordId);

        // Visibled icons
        JSxCardMngNewCardDataSourceVisibledOperationIcon(poElement, 'save', false);    // Itself hidden(save)
        JSxCardMngNewCardDataSourceVisibledOperationIcon(poElement, 'cancel', false);  // hidden cancel icon
        JSxCardMngNewCardDataSourceVisibledOperationIcon(poElement, 'edit', true);     // show edit icon

        $(poElement) // Remove Active New Card Code Field.
                .parents('.xWCardMngNewCardDataSource')
                .find('.xWCardShiftNewCardCardCode input[type=text]')
                .attr('disabled', true)
                .removeClass('active');
        
        $(poElement) // Remove Active HolderID Field.
            .parents('.xWCardMngNewCardDataSource')
            .find('.xWCardShiftNewCardHolderID input[type=text]')
            .attr('disabled', true)
            .removeClass('active'); 
    
        $(poElement) // Remove Active New Card Name Field.
            .parents('.xWCardMngNewCardDataSource')
            .find('.xWCardShiftNewCardCardName input[type=text]')
            .attr('disabled', true)
            .removeClass('active');    

        $(poElement) // Remove Active Card Type Field.
            .parents('.xWCardMngNewCardDataSource')
            .find('.xWCardShiftNewCardCty input[type=text]')
            .attr('disabled', true)
            .removeAttr('readonly')
            .removeClass('btn');

        $(poElement) // Remove Active Department Field.
                .parents('.xWCardMngNewCardDataSource')
                .find('.xWCardShiftNewCardDepart input[type=text]')
                .attr('disabled', true)
                .removeAttr('readonly')
                .removeClass('btn');
    }
 
    // Functionality : Update card on document temp
    // Parameters : tCardCode, tNewCardCode, tReasonCode, pnPage
    // Creator : 09/01/2019 wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JSxCardMngNewCardUpdateDataOnTemp(poNewCard, pnSeq, pnPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "cardmngdataNewCardUpdateInlineOnTemp",
                data: {
                    tNewCard: JSON.stringify(poNewCard),
                    nSeq: pnSeq,
                },
                cache: false,
                Timeout: 0,
                success: function(tResult){
                    var tDocType    = 'NewCard';
                    var tIDElement  = 'odvPanelCmdMngDataDetail';
                    JSvClickCallTableTemp(tDocType,pnPage,tIDElement);
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    
    // Functionality : Cancel Edit Record Before to Save.
    // Parameters : poElement is Itself element, poEvent is Itself event
    // Creator : 09/01/2019 wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JSxCardMngNewCardDataSourceCancelOperator(poElement, poEvent){
        var tRecordId = $(poElement).parents('.xWCardMngNewCardDataSource').attr('id');
        // Restore Seft Record
        var oBackupRecord = JSON.parse(localStorage.getItem(tRecordId));
        $(poElement).parents('.xWCardMngNewCardDataSource').find('.xWCardMngNewCardCardCode input[type=text]').val(oBackupRecord.tNewCardCode);
        $(poElement).parents('.xWCardMngNewCardDataSource').find('.xWCardMngNewCardCardName input[type=text]').val(oBackupRecord.tNewCardName);
        $(poElement).parents('.xWCardMngNewCardDataSource').find('.xWCardMngNewCardCty input[type=hidden]').val(oBackupRecord.tCardTypeCode);
        $(poElement).parents('.xWCardMngNewCardDataSource').find('.xWCardMngNewCardCty input[type=text]').val(oBackupRecord.tCardTypeName);
        $(poElement).parents('.xWCardMngNewCardDataSource').find('.xWCardMngNewCardDepart input[type=hidden]').val(oBackupRecord.tDepartmentCode);
        $(poElement).parents('.xWCardMngNewCardDataSource').find('.xWCardMngNewCardDepart input[type=text]').val(oBackupRecord.tDepartmentName);

        // Remove Seft Record Backup
        localStorage.removeItem(tRecordId);

        // Visibled icons
        JSxCardMngNewCardDataSourceVisibledOperationIcon(poElement, 'cancel', false); // Itself hidden(cancel)
        JSxCardMngNewCardDataSourceVisibledOperationIcon(poElement, 'save', false); // hidden save icon
        JSxCardMngNewCardDataSourceVisibledOperationIcon(poElement, 'edit', true); // show edit icon

        $(poElement) // Active New Card Code Field.
            .parents('.xWCardMngNewCardDataSource')
            .find('.xWCardMngNewCardCardCode input[type=text]')
            .attr('disabled', true)
            .removeClass('active');

        $(poElement) // Active New Card Name Field.
            .parents('.xWCardMngNewCardDataSource')
            .find('.xWCardMngNewCardCardName input[type=text]')
            .attr('disabled', true)
            .removeClass('active');    

        $(poElement) // Active Card Type Field.
            .parents('.xWCardMngNewCardDataSource')
            .find('.xWCardMngNewCardCty input[type=text]')
            .attr('disabled', true)
            .removeAttr('readonly')
            .removeClass('btn');

        $(poElement) // Active Department Field.
            .parents('.xWCardMngNewCardDataSource')
            .find('.xWCardMngNewCardDepart input[type=text]')
            .attr('disabled', true)
            .removeAttr('readonly')
            .removeClass('btn');  
    }

    
    // Functionality : Function Click Page Data Table List
    // Parameters : poElement is Itself element, poEvent is Itself event
    // Creator : 09/01/2019 wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JSvCardMngNewCardDataSourceClickPage(ptPage, tDocType, ptIDElement) {
        JCNxOpenLoading();

        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                nPageOld = $('.xWCardMngNewCardDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWCardMngNewCardDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }

        var tDocType    = 'NewCard';
        var tIDElement  = 'odvPanelCmdMngDataDetail';
        JSvClickCallTableTemp(tDocType,nPageCurrent,tIDElement);
    }

    
    // Functionality : Delete Record Before to Save.
    // Parameters : poElement is Itself element, poEvent is Itself event
    // Creator : 09/01/2019 wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JSxCardMngNewCardDataSourceDeleteOperator(poElement, poEvent, pnPage, ptOldCardCode, pnSeq) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#ospCardMngNewCardConfirDelMessage').html(ptOldCardCode);
            $('#odvCardMngNewCardModalConfirmDelRecord').modal({backdrop: 'static', keyboard: false});
            $('#odvCardMngNewCardModalConfirmDelRecord').modal('show');

            $('#osmCardMngNewCardConfirmDelRecord').unbind().click(function(evt) {
                $('#odvCardMngNewCardModalConfirmDelRecord').modal('hide');
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "CallDeleteTemp",
                    data: {ptID: ptOldCardCode, pnSeq: pnSeq, ptDocType:"NewCard"},
                    cache: false,
                    success: function (tResult) {
                        var tDocType    = 'NewCard';
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
    }
</script>
    
    

