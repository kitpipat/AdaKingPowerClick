<script type="text/javascript">

    // Functionality : control ปุ่ม เซฟ ยกเลิก บันทึก
    // Parameters : [poElement] is seft element in scope(<tr class="xWCardMngTopUpDataSource">), 
    //              [ptOperation] is icon type(edit, cancel, save), [pbVisibled] is true = show, false = hide
    // Creator : 08/01/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JSxCardMngTopUpDataSourceVisibledOperationIcon(poElement, ptOperation, pbVisibled) {
        try {
            switch (ptOperation) {
                case 'edit' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardMngTopUpDataSource')
                                .find('.xWCardMngTopUpEdit'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardMngTopUpDataSource')
                                .find('.xWCardMngTopUpEdit'))
                                .addClass('hidden');
                    }
                    break;
                }
                case 'cancel' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardMngTopUpDataSource')
                                .find('.xWCardMngTopUpCancel'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardMngTopUpDataSource')
                                .find('.xWCardMngTopUpCancel'))
                                .addClass('hidden');
                    }
                    break;
                }
                case 'save' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardMngTopUpDataSource')
                                .find('.xWCardMngTopUpSave'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardMngTopUpDataSource')
                                .find('.xWCardMngTopUpSave'))
                                .addClass('hidden');
                    }
                    break;
                }
                default :
                {
                }
            }
        } catch (err) {
            console.log('JJSxCardMngTopUpDataSourceVisibledOperationIcon Error: ', err);
        }
    }

    // Functionality : กดปุ่ม edit
    // Parameters : poElement is Itself element, poEvent is Itself event
    // Creator : 08/01/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JSxCardMngTopUpDataSourceEditOperator(poElement, poEvent, pnSeq){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tRecordId   = $(poElement).parents('.xWCardMngTopUpDataSource').attr('id');
            var oRecord     = {
                tCode       : $(poElement).parents('.xWCardMngTopUpDataSource').find('.xWCardMngTopUpCardCode input[type=hidden]').val(),
                tCodeName   : $(poElement).parents('.xWCardMngTopUpDataSource').find('.xWCardMngTopUpCardCode input[type=text]').val(),
                tValue      : $(poElement).parents('.xWCardMngTopUpDataSource').find('.xWCardMngTopUpValue input[type=hidden]').val(),
                tValueName  : $(poElement).parents('.xWCardMngTopUpDataSource').find('.xWCardMngTopUpValue input[type=text]').val()
            };

            // Set Local Storage
            localStorage.setItem(tRecordId, JSON.stringify(oRecord));

            // Visibled icons
            JSxCardMngTopUpDataSourceVisibledOperationIcon(poElement, 'edit', false); // Itself hidden(edit)
            JSxCardMngTopUpDataSourceVisibledOperationIcon(poElement, 'cancel', true); // hidden cancel icon
            JSxCardMngTopUpDataSourceVisibledOperationIcon(poElement, 'save', true); // hidden save icon
            
            $(poElement) // Active BTN
                    .parents('.xWCardMngTopUpDataSource')
                    .find('.xWCardMngTopUpCardCode input[type=text]')
                    .removeAttr('disabled')
                    .attr('readonly', true)
                    .addClass('btn');

            $(poElement) // Active TEXT
                    .parents('.xWCardMngTopUpDataSource')
                    .find('.xWCardMngTopUpValue input[type=text]')
                    .removeAttr('disabled')
                    .addClass('text')
                    .attr('maxlength', 18)
                    .addClass('xCNInputMaskCurrency');

            $('.xCNInputMaskCurrency').on("blur", function() {
                var tInputVal = $(this).val();
                tInputVal += '';
                tInputVal = tInputVal.replace(',', '');
                tInputVal = tInputVal.split('.');
                tValCurency = tInputVal[0];
                tDegitInput = tInputVal.length > 1 ? '.' + tInputVal[1] : '';
                var tCharecterComma = /(\d+)(\d{3})/;
                while (tCharecterComma.test(tValCurency))
                    tValCurency = tValCurency.replace(tCharecterComma, '$1' + ',' + '$2');
                var tInputReplaceComma = tValCurency + tDegitInput;
                var tSearch = ".";
                var tStrinreplace = ".00";
                var tInputCommaDegit = ""
                if (tInputReplaceComma.indexOf(tSearch) == -1 && tInputReplaceComma != "") {
                    tInputCommaDegit = tInputReplaceComma.concat(tStrinreplace);
                } else {
                    tInputCommaDegit = tInputReplaceComma;
                }
                $(this).val(tInputCommaDegit);
            });
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
    function JSxCardMngTopUpDataSourceSaveOperator(poElement, poEvent) {
        try{
            var tRecordId       = $(poElement).parents('.xWCardMngTopUpDataSource').attr('id');
            var oPrefixNumber   = tRecordId.match(/\d+/);
            
            var oRecord = {
                nPage   : $('#ohdCardMngTopUpDataSourceCurrentPage').val(),
                nSeq    : $(poElement).parents('.xWCardMngTopUpDataSource').data('seq'),
                tCode   : $(poElement).parents('.xWCardMngTopUpDataSource').find('.xWCardMngTopUpCardCode input[type=text]').val(),
                tValue  : $(poElement).parents('.xWCardMngTopUpDataSource').find('.xWCardMngTopUpValue input[type=text]').val()
            };

            // Update in document temp
            JSxCardMngTopUpUpdateDataOnTemp(oRecord.tCode, oRecord.tValue, oRecord.nSeq, oRecord.nPage);

            // Remove Seft Record Backup
            localStorage.removeItem(tRecordId);

            // Visibled icons
            JSxCardMngTopUpDataSourceVisibledOperationIcon(poElement, 'save', false); // Itself hidden(save)
            JSxCardMngTopUpDataSourceVisibledOperationIcon(poElement, 'cancel', false); // hidden cancel icon
            JSxCardMngTopUpDataSourceVisibledOperationIcon(poElement, 'edit', true); // show edit icon

            $(poElement)  // Active BTN
                    .parents('.xWCardMngTopUpDataSource')
                    .find('.xWCardMngTopUpCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

            $(poElement) // Active TEXT
                    .parents('.xWCardMngTopUpDataSource')
                    .find('.xWCardMngTopUpValue input[type=text]')
                    .attr('disabled', true)
                    .removeClass('text');

        } catch(err){
            console.log('JSxCardMngTopUpDataSourceSaveOperator Error: ', err);
        }
    }

    // Functionality : กดปุ่ม cancle
    // Parameters : poElement is Itself element, poEvent is Itself event
    // Creator : 08/01/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JSxCardMngTopUpDataSourceCancelOperator(poElement, poEvent) {
        try {
            var tRecordId = $(poElement).parents('.xWCardMngTopUpDataSource').attr('id');

            // Restore Seft Record
            var oBackupRecord = JSON.parse(localStorage.getItem(tRecordId));
            $(poElement).parents('.xWCardMngTopUpDataSource').find('.xWCardMngTopUpCardCode input[type=hidden]').val(oBackupRecord.tCode);
            $(poElement).parents('.xWCardMngTopUpDataSource').find('.xWCardMngTopUpCardCode input[type=text]').val(oBackupRecord.tCodeName);
            $(poElement).parents('.xWCardMngTopUpDataSource').find('.xWCardMngTopUpValue input[type=hidden]').val(oBackupRecord.tValue);
            $(poElement).parents('.xWCardMngTopUpDataSource').find('.xWCardMngTopUpValue input[type=text]').val(oBackupRecord.tValueName);

            // Remove Seft Record Backup
            localStorage.removeItem(tRecordId);

            // Visibled icons
            JSxCardMngTopUpDataSourceVisibledOperationIcon(poElement, 'cancel', false); // Itself hidden(cancel)
            JSxCardMngTopUpDataSourceVisibledOperationIcon(poElement, 'save', false); // hidden save icon
            JSxCardMngTopUpDataSourceVisibledOperationIcon(poElement, 'edit', true); // show edit icon


            $(poElement) // Active BTN
                    .parents('.xWCardMngTopUpDataSource')
                    .find('.xWCardMngTopUpCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

            $(poElement)  // Active TEXT
                    .parents('.xWCardMngTopUpDataSource')
                    .find('.xWCardMngTopUpValue input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly', true)
                    .removeClass('text');

        }catch (err) {
            console.log('JSxCardMngTopUpDataSourceCancelOperator Error: ', err);
        }
    }
    
    
    // Functionality : ฟังก์ชั่น save edit in line  
    // Parameters : tCardCode, tNewCardCode, tReasonCode, pnPage
    // Creator : 08/01/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JSxCardMngTopUpUpdateDataOnTemp(ptCardCode, pnValue, pnSeq, pnPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "cardmngdataTopUpUpdateInlineOnTemp",
                data: {
                    tCardCode       : ptCardCode,
                    nValue          : pnValue,
                    nSeq            : pnSeq
                },
                cache: false,
                Timeout: 0,
                success: function(tResult) {
                    var tDocType    = 'TopUp';
                    var tIDElement  = 'odvPanelCmdMngDataDetail';
                    JSvClickCallTableTemp(tDocType, pnPage, tIDElement);
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardMngTopUpResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // Functionality : กด Delete
    // Parameters : poElement is Itself element, poEvent is Itself event
    // Creator : 08/01/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JSxCardMngTopUpDataSourceDeleteOperator(poElement, poEvent, pnPage, ptOldCardCode, pnSeq) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#ospCardMngTopUpConfirDelMessage').html(ptOldCardCode);
            $('#odvCardMngTopUpModalConfirmDelRecord').modal({backdrop: 'static', keyboard: false});
            $('#odvCardMngTopUpModalConfirmDelRecord').modal('show');
            $('#osmCardMngTopUpConfirmDelRecord').unbind().click(function(evt) {
                $('#odvCardMngTopUpModalConfirmDelRecord').modal('hide');
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "CallDeleteTemp",
                    data: {ptID: ptOldCardCode, pnSeq: pnSeq, ptDocType: "TopUp"},
                    cache: false,
                    success: function (tResult) {
                        var tDocType    = 'TopUp';
                        var tIDElement  = 'odvPanelCmdMngDataDetail';
                        JSvClickCallTableTemp(tDocType, pnPage, tIDElement);
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

    // Functionality : Delete Record Before to Save.
    // Parameters : poElement is Itself element, poEvent is Itself event
    // Creator : 09/01/2019 wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JSvCardMngTopUpDataSourceClickPage(ptPage, tDocType, ptIDElement) {
        JCNxOpenLoading();

        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                nPageOld = $('.xWCardMngTopUpDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWCardMngTopUpDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }

        var tDocType    = 'TopUp';
        var tIDElement  = 'odvPanelCmdMngDataDetail';
        JSvClickCallTableTemp(tDocType,nPageCurrent,tIDElement);
    }
</script>

