<script type="text/javascript">
    
    $(document).ready(function(){
        var oSetQtySucessAllRow = {
            'tQtyAllRow'    : $('#ohdCardMngShiftClearCountRowFromTemp').val(),
            'tQtySucessRow' : $('#ohdCardMngShiftClearCountSuccess').val()
        }
        JSxSetQtyCardAllAndAllRow(oSetQtySucessAllRow);
    });
    
    /**
     * Functionality : control ปุ่ม เซฟ ยกเลิก บันทึก
     * Parameters : [poElement] is seft element in scope(<tr class="xWCardMngClearDataSource">)
     * [ptOperation] is icon type(edit, cancel, save), [pbVisibled] is true = show, false = hide
     * Creator : 07/12/2018 Wasin(Yoshi)
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardMngClearDataSourceVisibledOperationIcon(poElement, ptOperation, pbVisibled) {
        try {
            switch (ptOperation) {
                case 'edit' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardMngClearDataSource')
                                .find('.xWCardMngClearEdit'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardMngClearDataSource')
                                .find('.xWCardMngClearEdit'))
                                .addClass('hidden');
                    }
                    break;
                }
                case 'cancel' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardMngClearDataSource')
                                .find('.xWCardMngClearCancel'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardMngClearDataSource')
                                .find('.xWCardMngClearCancel'))
                                .addClass('hidden');
                    }
                    break;
                }
                case 'save' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardMngClearDataSource')
                                .find('.xWCardMngClearSave'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardMngClearDataSource')
                                .find('.xWCardMngClearSave'))
                                .addClass('hidden');
                    }
                    break;
                }
                default :
                {
                }
            }
        } catch (err) {
            console.log('JJSxCardMngClearDataSourceVisibledOperationIcon Error: ', err);
        }
    }
    
    /**
     * Functionality : กดปุ่ม edit
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 08/01/2019 Wasin(Yoshi)
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardMngClearDataSourceEditOperator(poElement, poEvent, pnSeq){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tRecordId   = $(poElement).parents('.xWCardMngClearDataSource').attr('id');
            var oRecord     = {
                tCode       : $(poElement).parents('.xWCardMngClearDataSource').find('.xWCardMngClearCardCode input[type=hidden]').val(),
                tCodeName   : $(poElement).parents('.xWCardMngClearDataSource').find('.xWCardMngClearCardCode input[type=text]').val()
            };

            // Set Local Storage
            localStorage.setItem(tRecordId, JSON.stringify(oRecord));

            // Visibled icons
            JSxCardMngClearDataSourceVisibledOperationIcon(poElement, 'edit', false); // Itself hidden(edit)
            JSxCardMngClearDataSourceVisibledOperationIcon(poElement, 'cancel', true); // hidden cancel icon
            JSxCardMngClearDataSourceVisibledOperationIcon(poElement, 'save', true); // hidden save icon
            
            $(poElement) // Active BTN
                    .parents('.xWCardMngClearDataSource')
                    .find('.xWCardMngClearCardCode input[type=text]')
                    .removeAttr('disabled')
                    .attr('readonly', true)
                    .addClass('btn');

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
    
    /**
     * Functionality : กดปุ่ม save 
     * Parameters : poElement is Itself element, poEvent is Itself event, pnSeq is index in loop
     * Creator : 24/12/2018 Wasin(Yoshi)
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardMngClearDataSourceSaveOperator(poElement, poEvent) {
        var tRecordId       = $(poElement).parents('.xWCardMngClearDataSource').attr('id');
        var oPrefixNumber   = tRecordId.match(/\d+/);
        
        var oRecord = {
            nPage   : $('#ohdCardMngClearDataSourceCurrentPage').val(),
            nSeq    : $(poElement).parents('.xWCardMngClearDataSource').data('seq'),
            tCode   : $(poElement).parents('.xWCardMngClearDataSource').find('.xWCardMngClearCardCode input[type=text]').val()
        };
        
        // Update in document temp
        JSxCardMngClearUpdateDataOnTemp(oRecord.tCode, oRecord.nSeq, oRecord.nPage);

        // Remove Seft Record Backup
        localStorage.removeItem(tRecordId);

        // Visibled icons
        JSxCardMngClearDataSourceVisibledOperationIcon(poElement, 'save', false); // Itself hidden(save)
        JSxCardMngClearDataSourceVisibledOperationIcon(poElement, 'cancel', false); // hidden cancel icon
        JSxCardMngClearDataSourceVisibledOperationIcon(poElement, 'edit', true); // show edit icon

        $(poElement)  // Active BTN
                .parents('.xWCardMngClearDataSource')
                .find('.xWCardMngClearCardCode input[type=text]')
                .attr('disabled', true)
                .removeAttr('readonly')
                .removeClass('btn');
    }

    /**
     * Functionality : กดปุ่ม cancle
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 24/12/2018 Wasin(Yoshi)
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardMngClearDataSourceCancelOperator(poElement, poEvent) {
        try {
            var tRecordId = $(poElement).parents('.xWCardMngClearDataSource').attr('id');

            // Restore Seft Record
            var oBackupRecord = JSON.parse(localStorage.getItem(tRecordId));
            $(poElement).parents('.xWCardMngClearDataSource').find('.xWCardMngClearCardCode input[type=hidden]').val(oBackupRecord.tCode);
            $(poElement).parents('.xWCardMngClearDataSource').find('.xWCardMngClearCardCode input[type=text]').val(oBackupRecord.tCodeName);

            // Remove Seft Record Backup
            localStorage.removeItem(tRecordId);

            // Visibled icons
            JSxCardMngClearDataSourceVisibledOperationIcon(poElement, 'cancel', false); // Itself hidden(cancel)
            JSxCardMngClearDataSourceVisibledOperationIcon(poElement, 'save', false); // hidden save icon
            JSxCardMngClearDataSourceVisibledOperationIcon(poElement, 'edit', true); // show edit icon


            $(poElement) // Active BTN
                    .parents('.xWCardMngClearDataSource')
                    .find('.xWCardMngClearCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

        }catch (err) {
            console.log('JSxCardMngClearDataSourceCancelOperator Error: ', err);
        }
    }
    
    /**
     * Functionality : ฟังก์ชั่น save edit in line
     * Parameters : tCardCode, tNewCardCode, tReasonCode, pnPage
     * Creator : 27/12/2018 Wasin(Yoshi)
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardMngClearUpdateDataOnTemp(ptCardCode, pnSeq, pnPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "cardmngdataClearUpdateInlineOnTemp",
                data: {
                    tCardCode       : ptCardCode,
                    nSeq            : pnSeq
                },
                cache: false,
                Timeout: 0,
                success: function(tResult) {
                    var tDocType    = 'Clear';
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
    
    /**
     * Functionality : กด Delete
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 24/12/2018 Wasin(Yoshi)
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardMngClearDataSourceDeleteOperator(poElement, poEvent, pnPage, ptOldCardCode, pnSeq) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#ospCardMngClearConfirDelMessage').html(ptOldCardCode);
            $('#odvCardMngClearModalConfirmDelRecord').modal({backdrop: 'static', keyboard: false});
            $('#odvCardMngClearModalConfirmDelRecord').modal('show');
            $('#osmCardMngClearConfirmDelRecord').unbind().click(function(evt) {
                $('#odvCardMngClearModalConfirmDelRecord').modal('hide');
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "CallDeleteTemp",
                    data: {ptID: ptOldCardCode, pnSeq: pnSeq, ptDocType: "ClearCard"},
                    cache: false,
                    success: function (tResult) {
                        var tDocType    = 'Clear';
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
    
    /**
     * Functionality : Btn Click Page Data
     * Parameters : -
     * Creator : 24/12/2018 Wasin(Yoshi)
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSvCardMngClearDataSourceClickPage(ptPage, tDocType, ptIDElement) {
        JCNxOpenLoading();
        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                nPageOld = $('.xWCardMngClearDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWCardMngClearDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }
        var tDocType    = 'Clear';
        var tIDElement  = 'odvPanelCmdMngDataDetail';
        JSvClickCallTableTemp(tDocType,nPageCurrent,tIDElement);
    }
</script>

