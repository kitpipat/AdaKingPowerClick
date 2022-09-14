<script type="text/javascript">
    $('.selectpicker').selectpicker();

	$('#obtSearchProduct').click(function(){
		JCNxOpenLoading();
		JSvCallPageProductDataTable();
    });
    
	$('#oetSearchProduct').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvCallPageProductDataTable();
		}
    });
    
    $('#oliManagePdtColum').click(function(event){
        JSvPdtOpenModalMngTable();
        event.preventDefault();
    });

    $('#odvPdtShowOrderColumn #obtPdtSaveMngTable').click(function(event){
        JSxPdtSaveColumsMngTable();
        event.preventDefault();
    });

    $('#odvModalDeletePdtMultiple #osmConfirmDelMultiple').unbind().click(function(){
        JSoProductDeleteMultiple();
    });

    // Function : Call Open Modal Manage Table
    // Parameters : Event Button Click
    // Creator :	01/02/2019 wasin(Yoshi)
    // Return : Show Modal Manage Table
    // Return Type : View
    function JSvPdtOpenModalMngTable(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "productAdvTableShwColList",
                cache: false,
                Timeout: 0,
                async: false,
                success: function(oResult){
                    var aReturnData = JSON.parse(oResult);
                    if(aReturnData['nStaEvent'] == '1'){
                        // Clear Data IN Table
                        $('#odvPdtShowOrderColumn #odvPdtDetailShowColumn #otbPdtOrderListDetail tbody').empty();
                        // Loop Append Data Advance Table In Modal
                        $.each(aReturnData['aAvailableColumn'],function( nKey , aValue){
                            $('#odvPdtShowOrderColumn #odvPdtDetailShowColumn #otbPdtOrderListDetail tbody').append($('<tr>')
                                .append($('<td>')
                                    .text(nKey+1)
                                )
                                .append($('<td>')
                                    .append($('<label>')
                                    .attr('contenteditable',"true")
                                    .attr('class','olbColumnLabelName')
                                    .text(aValue['FTShwNameUsr'])
                                    )
                                )
                                .append($('<td>')
                                .attr('class','text-center')
                                    .append($('<input>')
                                    .attr('class','ocbColStaShow')
                                    .attr('type','checkbox')
                                    .attr('data-id',aValue['FTShwFedShw'])
                                    )
                                )
                            )
                            if(aValue['FTShwFedSetByUsr'] == 1){
                                $('#odvPdtShowOrderColumn #odvPdtDetailShowColumn #otbPdtOrderListDetail tbody').find("[data-id='" + aValue['FTShwFedShw'] + "']")
                                .prop("checked",true);
                            }else{
                                $('#odvPdtShowOrderColumn #odvPdtDetailShowColumn #otbPdtOrderListDetail tbody').find("[data-id='" + aValue['FTShwFedShw'] + "']")
                                .prop("checked",false);
                            }
                        });
                        $('#odvPdtShowOrderColumn #odvPdtDetailShowColumn #otbPdtOrderListDetail').tableDnD();
                        $("#odvPdtShowOrderColumn").modal({backdrop: 'static',keyboard: false});
                        $("#odvPdtShowOrderColumn").modal({show:true});
                        JCNxCloseLoading();
                    }else if(aReturnData['nStaEvent'] == '800'){
                        $('#odvPdtShowOrderColumn #otbPdtOrderListDetail tbody').append($('<tr>')
                            .append($('<td>')
                            .attr('class','text-center xCNTextDetail2 xWPdtMdAdvNoData')
                            .attr('colspan',3)
                            .text('<?php echo language("common/main/main","tModalAdvMngTableNotFoundData");?>')
                            )
                        )
                        $("#odvPdtShowOrderColumn").modal({backdrop: 'static',keyboard: false});
                        $("#odvPdtShowOrderColumn").modal({show:true});
                        JCNxCloseLoading();
                    }else{
                        var tMessageError   = aReturnData['tStaMessg'];
                        FSvCMNSetMsgErrorDialog(tMessageError);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // Function: Save Product Colums Table Management
    // Parameters: Event Button Click
    // Creator: 01/02/2019 wasin(Yoshi)
    // Return: Hide Modal And Reflase Table
    // Return Type: none
    function JSxPdtSaveColumsMngTable(){
        var nChkMngTableNoData  = $('#odvPdtShowOrderColumn #odvPdtDetailShowColumn #otbPdtOrderListDetail tbody .xWPdtMdAdvNoData').length;
        if(nChkMngTableNoData == 0){
            //  Loop Get Data Col Table Setting 
            var aColShowSet = [];
            $("#odvPdtShowOrderColumn #odvPdtDetailShowColumn #otbPdtOrderListDetail .ocbColStaShow:checked").each(function(){
                aColShowSet.push($(this).data('id'));
            })

            //  Loop Get Data Col Table All
            var aColShowAllList = [];
            $("#odvPdtShowOrderColumn #odvPdtDetailShowColumn #otbPdtOrderListDetail .ocbColStaShow").each(function(){
                aColShowAllList.push($(this).data('id'));
            });
            
            // Loop Get Data Label Head Table
            var aColumnLabelName = [];
            $("#odvPdtShowOrderColumn #odvPdtDetailShowColumn #otbPdtOrderListDetail .olbColumnLabelName").each(function(){
                aColumnLabelName.push($(this).text());
            });
            
            // Status Check Set Defult
            var nStaSetDef  = ($('#odvPdtShowOrderColumn #odvPdtDetailShowColumn #ocbPdtSetColDef').is(':checked'))? 1 : 0;

            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "productAdvTableShwColSave",
                data: {
                    aColShowSet      : aColShowSet,
                    aColShowAllList  : aColShowAllList,
                    aColumnLabelName : aColumnLabelName,
                    nStaSetDef       : nStaSetDef
                },
                cache: false,
                Timeout: 0,
                async: false,
                success: function(oResult){
                    var aReturnData = JSON.parse(oResult);
                    if(aReturnData['nStaEvent'] == 1){
                        $('#odvPdtShowOrderColumn').modal('hide');
                        $('.modal-backdrop').remove();
                        JSvCallPageProductDataTable();
                    }else{
                        $('#odvPdtShowOrderColumn').modal('hide');
                        $('.modal-backdrop').remove();
                        var tMessageError   = aReturnData['tStaMessg'];
                        FSvCMNSetMsgErrorDialog(tMessageError);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }

</script>