<script>


    //function edit
    function JSvCallPageTimeStampEdit(poElement, poEvent , pnSeq) {
        try {
            var tRecordId = $(poElement).parents('.xWTimeStampDataSource').attr('id');
            var oRecord = {
                tClockIN    : $(poElement).parents('.xWTimeStampDataSource').find('.xWTimeStampClockIN input[type=text]').val(),
                tClockOUT   : $(poElement).parents('.xWTimeStampDataSource').find('.xWTimeStampClockOut input[type=text]').val(),
            };
            // Backup Seft Record
            localStorage.setItem(tRecordId, JSON.stringify(oRecord));

            // Visibled icons
            
            JSxTimeStampDataSourceVisibledOperationIcon(poElement, 'edit', false);      // Itself hidden(edit)
            JSxTimeStampDataSourceVisibledOperationIcon(poElement, 'cancel', true);     // hidden cancel icon
            JSxTimeStampDataSourceVisibledOperationIcon(poElement, 'save', true);       // hidden save icon

            $(poElement) // Active Time Clockin
                    .parents('.xWTimeStampDataSource')
                    .find('.xWTimeStampClockIN input[type=text]')
                    .removeAttr('disabled')
                    .addClass('text')
                    .attr('maxlength', 18)
                    .addClass('xCNInputMaskTime');

            $(poElement) // Active Time Clockout
                    .parents('.xWTimeStampDataSource')
                    .find('.xWTimeStampClockOut input[type=text]')
                    .removeAttr('disabled')
                    .addClass('text')
                    .attr('maxlength', 18)
                    .addClass('xCNInputMaskTime');

        } catch (err) {
            console.log('JSxEditOperator Error: ', err);
        }
    }

    //Save 
    function JSxTimeStampDataSourceSaveOperator(poElement, poEvent){
        try {
            var tRecordId = $(poElement).parents('.xWTimeStampDataSource').attr('id');
            var oRecord = {
                nSeq      : $(poElement).parents('.xWTimeStampDataSource').data('seq'),
                tClockIN  : $(poElement).parents('.xWTimeStampDataSource').find('.xWTimeStampClockIN input[type=text]').val(),
                tClockOut : $(poElement).parents('.xWTimeStampDataSource').find('.xWTimeStampClockOut input[type=text]').val()
            };
            
            // Update in document temp
            JSxTimeStampUpdateDataOnTemp(oRecord.nSeq , oRecord.tClockIN , oRecord.tClockOut);
            
            // // Remove Seft Record Backup
            localStorage.removeItem(tRecordId);

            // // Visibled icons
            JSxTimeStampDataSourceVisibledOperationIcon(poElement, 'save', false); // Itself hidden(save)
            JSxTimeStampDataSourceVisibledOperationIcon(poElement, 'cancel', false); // hidden cancel icon
            JSxTimeStampDataSourceVisibledOperationIcon(poElement, 'edit', true); // show edit icon

            $(poElement) // remove TEXT Clockin
                    .parents('.xWTimeStampDataSource')
                    .find('.xWTimeStampClockIN input[type=text]')
                    .attr('disabled', true);

            $(poElement)  // remove TEXT Clockout
                    .parents('.xWTimeStampDataSource')
                    .find('.xWTimeStampClockOut input[type=text]')
                    .attr('disabled', true);


        } catch (err) {
            console.log('JSxCardShiftTopUpDataSourceSaveOperator Error: ', err);
        }
    }

    //Cancle
    function JSxPageTimeStampDataSourceCancelOperator(poElement, poEvent){
        try {
            var tRecordId = $(poElement).parents('.xWTimeStampDataSource').attr('id');

            // Restore Seft Record
            var oBackupRecord = JSON.parse(localStorage.getItem(tRecordId));
            $(poElement).parents('.xWTimeStampDataSource').find('.xWTimeStampClockIN input[type=text]').val(oBackupRecord.tClockIN);
            $(poElement).parents('.xWTimeStampDataSource').find('.xWTimeStampClockOut input[type=text]').val(oBackupRecord.tClockOUT);

            // Remove Seft Record Backup
            localStorage.removeItem(tRecordId);

            // Visibled icons
            JSxTimeStampDataSourceVisibledOperationIcon(poElement, 'cancel', false); // Itself hidden(cancel)
            JSxTimeStampDataSourceVisibledOperationIcon(poElement, 'save', false); // hidden save icon
            JSxTimeStampDataSourceVisibledOperationIcon(poElement, 'edit', true); // show edit icon

            $(poElement) // remove TEXT Clockin
                    .parents('.xWTimeStampDataSource')
                    .find('.xWTimeStampClockIN input[type=text]')
                    .attr('disabled', true);

            $(poElement)  // remove TEXT Clockout
                    .parents('.xWTimeStampDataSource')
                    .find('.xWTimeStampClockOut input[type=text]')
                    .attr('disabled', true);

        } catch (err) {
            console.log('JSxCancelOperator Error: ', err);
        }
    }

    //Hidden BTN / Show BTN
    function JSxTimeStampDataSourceVisibledOperationIcon(poElement, ptOperation, pbVisibled) {
        try {
            switch (ptOperation) {
                case 'edit' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWTimeStampDataSource')
                                .find('.xWTimeStampEdit'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWTimeStampDataSource')
                                .find('.xWTimeStampEdit'))
                                .addClass('hidden');
                    }
                    break;
                }
                case 'cancel' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWTimeStampDataSource')
                                .find('.xWTimeStampCancel'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWTimeStampDataSource')
                                .find('.xWTimeStampCancel'))
                                .addClass('hidden');
                    }
                    break;
                }
                case 'save' :
                {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWTimeStampDataSource')
                                .find('.xWTimeStampSave'))
                                .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWTimeStampDataSource')
                                .find('.xWTimeStampSave'))
                                .addClass('hidden');
                    }
                    break;
                }
                default :
                {
                }
            }
        } catch (err) {
            console.log('JSxTimeStampDataSourceVisibledOperationIcon Error: ', err);
        }
    }

    //Update Inline
    function JSxTimeStampUpdateDataOnTemp(pnSeq,ptTimeIN,ptTimeOut){
      
        try{

            var pnPage     = $('#ohdPageCurrent').val();
            var ptDateIN   = $('#oetDateIN' + pnSeq).val();
            var ptDateOut  = $('#oetDateOut' + pnSeq).val();

            $.ajax({
                type    : "POST",
                url     : "timeStampMainUpdate",
                data    : {
                    ptDateIN       : ptDateIN,
                    ptDateOut      : ptDateOut, 
                    ptTimeIN       : ptTimeIN,
                    ptTimeOut      : ptTimeOut,
                    pnSeq          : pnSeq
                },
                cache: false,
                success: function(tResult) {
                    try{
                        JSxCallDataTableDetailAll(pnPage);
                    }catch(err){}
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   console.log('error');
                }
            });
        }catch(err){
            console.log("JSxTimeStampUpdateDataOnTemp Error: ", err);
        }
    }


</script>