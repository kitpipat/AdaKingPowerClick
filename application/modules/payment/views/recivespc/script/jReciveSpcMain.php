<script type="text/javascript">
    var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;
    var nStaRcvSpcBrowseType = $('#oetRcvSpcStaBrowse').val();
    var tCallRecSpcBackOption = $('#oetRcvSpcCallBackOption').val();

    $(document).ready(function() {
        // alert(nStaRcvSpcBrowseType)
        if (nStaRcvSpcBrowseType != 1) {
            JSvReciveSpcList(1);
        } else {
            JSvCallPageReciveSpcAdd();
        }

        // JSvReciveSpcList(1);
        
        // $("#oimRcvSpcBrowseAgg").attr("disabled", true);  //ตัวแทน
        // $("#oimRcvSpcBrowseBch").attr("disabled", true);  //สาขา
        // $("#oimRcvSpcBrowseMer").attr("disabled", true);  //ธุรกิจ
        // $("#oimRcvSpcBrowseShp").attr("disabled", true);  //ร้านค้า
        // $("#oimRcvSpcBrowsePos").attr("disabled", true);  //จุดขาย

        var bIsShpEnabled = '<?= FCNbGetIsShpEnabled() ? 1 : 0 ?>';
        // console.log('bIsShpEnabled '+bIsShpEnabled);
        // if (bIsShpEnabled == '0') {
        //     // console.log([$("#oetRcvSpcAppCode").val(), $("#oetRcvSpcBchCode").val()]);
        //     if ($("#oetRcvSpcAppCode").val() != '') {
        //         $("#oimRcvSpcBrowseBch").attr("disabled", false);
        //         // $("#oimRcvSpcBrowseAgg").attr("disabled",true);
        //     }
        //     if ($("#oetRcvSpcBchCode").val() != '') {
        //         // console.log('unlock agg');
        //         $("#oimRcvSpcBrowseAgg").attr("disabled", false);
        //     }
        // } else {
        //     if ($("#oetRcvSpcAppCode").val() != '') {
        //         $("#oimRcvSpcBrowseBch").attr("disabled", false);
        //         $("#oimRcvSpcBrowseMer").attr("disabled", true);
        //         $("#oimRcvSpcBrowseShp").attr("disabled", true);
        //         $("#oimRcvSpcBrowseAgg").attr("disabled", true);
        //     }
        //     if ($("#oetRcvSpcBchCode").val() != '') {
        //         $("#oimRcvSpcBrowseMer").attr("disabled", false);
        //         $("#oimRcvSpcBrowseShp").attr("disabled", true);
        //         $("#oimRcvSpcBrowseAgg").attr("disabled", true);
        //     }
        //     if ($("#oetRcvSpcMerName").val() != '') {
        //         $("#oimRcvSpcBrowseShp").attr("disabled", false);
        //         $("#oimRcvSpcBrowseAgg").attr("disabled", true);
        //     }
        //     if ($("#oetRcvSpcShpName").val() != '') {
        //         $("#oimRcvSpcBrowseAgg").attr("disabled", false);
        //     }
        // }

    });

    //function : Call PosAds Page list  
    //Parameters : Document Redy And Event Button
    //Creator :	25/11/2019 Witsarut (Bell)
    //Return : View
    //Return Type : View
    function JSvReciveSpcList(nPage) {
        var tRcvSpcCode = $('#ohdRcvSpcCode').val();
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "recivespcDataTable",
            data: {
                tRcvSpcCode: tRcvSpcCode,
                nPageCurrent: nPage,
                tSearchAll: ''
            },
            cache: false,
            Timeout: 0,
            async: false,
            success: function(tView) {
                $('#odvContentRcvSpcDataTable').html(tView);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Functionality : Call Credit Page Add  
    //Parameters : -
    //Creator : 25/11/2019 Witsarut(Bell)
    //Return : View
    //Return Type : View
    function JSvCallPageReciveSpcAdd() {
        var tRcvSpcCode = $('#ohdRcvSpcCode').val();
        var tRcvSpcName = $('#ohdRcvSpcName').val();

        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "recivespcPageAdd",
            data: {
                tRcvSpcCode: tRcvSpcCode,
                tRcvSpcName: tRcvSpcName
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvRcvSpcData').html(tResult);
                $('.xWPageAdd').removeClass('hidden');
                $('.xWPageEdit').addClass('hidden');
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }


    //Functionality : Call Credit Page Edit  
    //Parameters : -
    //Creator : 26/11/2019 witsarut (Bell)
    //Return : View
    //Return Type : View
    function JSvCallPageRcvSpcEdit(paDataWhereEdit) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "recivespcPageEdit",
            data: {
                'paDataWhereEdit': paDataWhereEdit
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvRcvSpcData').html(tResult);
                $('.xWPageAdd').removeClass('hidden');
                $('.xWPageEdit').addClass('hidden');

                // $("#oimRcvSpcBrowseBch").attr("disabled", true);
                // $("#oimRcvSpcBrowseMer").attr("disabled", true);
                // $("#oimRcvSpcBrowseShp").attr("disabled", true);
                // $("#oimRcvSpcBrowseAgg").attr("disabled", true);
                var bIsShpEnabled = '<?= FCNbGetIsShpEnabled() ? 1 : 0 ?>';
                // console.log('bIsShpEnabled '+bIsShpEnabled);
                // if (bIsShpEnabled == '0') {
                //     // console.log([$("#oetRcvSpcAppCode").val(), $("#oetRcvSpcBchCode").val()]);
                //     if ($("#oetRcvSpcAppCode").val() != '') {
                //         $("#oimRcvSpcBrowseBch").attr("disabled", false);
                //         // $("#oimRcvSpcBrowseAgg").attr("disabled",true);
                //     }
                //     if ($("#oetRcvSpcBchCode").val() != '') {
                //         // console.log('unlock agg');
                //         $("#oimRcvSpcBrowseAgg").attr("disabled", false);
                //     }
                // } else {
                //     if ($("#oetRcvSpcAppCode").val() != '') {
                //         $("#oimRcvSpcBrowseBch").attr("disabled", false);
                //         $("#oimRcvSpcBrowseMer").attr("disabled", true);
                //         $("#oimRcvSpcBrowseShp").attr("disabled", true);
                //         $("#oimRcvSpcBrowseAgg").attr("disabled", true);
                //     }
                //     if ($("#oetRcvSpcBchCode").val() != '') {
                //         $("#oimRcvSpcBrowseMer").attr("disabled", false);
                //         $("#oimRcvSpcBrowseShp").attr("disabled", true);
                //         $("#oimRcvSpcBrowseAgg").attr("disabled", true);
                //     }
                //     if ($("#oetRcvSpcMerName").val() != '') {
                //         $("#oimRcvSpcBrowseShp").attr("disabled", false);
                //         $("#oimRcvSpcBrowseAgg").attr("disabled", true);
                //     }
                //     if ($("#oetRcvSpcShpName").val() != '') {
                //         $("#oimRcvSpcBrowseAgg").attr("disabled", false);
                //     }
                // }
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Functionality: (event) Delete
    //Parameters: Button Event [tIDCode tCrdCode]
    //Creator: 26/11/2019 Witsarut (Bell)
    //Update: -
    //Return: Event Delete Reason List
    //Return Type: -
    function JSxRCVSpcDelete(paDataWhere) {
        $('#odvModalDeleteSingle').modal('show');
        $('#odvModalDeleteSingle #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ' ' + paDataWhere.ptRcvName + ' (' + paDataWhere.ptAppName + ')' + ' ' + $('#oetTextComfirmDeleteYesOrNot').val());
        $('#odvModalDeleteSingle #osmConfirmDelete').on('click', function(evt) {
            $.ajax({
                type: "POST",
                url: "recivespcEventDelete",
                data: {
                    'paDataWhere': paDataWhere
                },
                cache: false,
                success: function(tResult) {
                    $('#odvModalDeleteSingle').modal('hide');
                    setTimeout(function() {
                        JSvReciveSpcList(1);
                    }, 500);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    }

    //Functionality : (event) Delete All
    //Parameters :
    //Creator : 28/11/2019 Witsarut (Bell)
    //Return : 
    //Return Type :
    function JSxRCVSpcDeleteMutirecord(pnPage) {
        var tRevCodeWhere = $('#oetRcvCode').val();

        var tRcvSpcStaAlwCfg = $('#ohdtRcvSpcStaAlwCfg').val();
        let nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            // JCNxOpenLoading();
            let aDataRcvCode = [];
            let aDataAppCode = [];
            let aDataRcvSeq = [];
            let aDataBchCode = [];
            let aDataMerCode = [];
            let aDataShpCode = [];
            let aDataAggCode = [];
            let aDataPosCode = [];
            let ocbListItem = $(".ocbListItem");
            for (var nI = 0; nI < ocbListItem.length; nI++) {
                if ($($(".ocbListItem").eq(nI)).prop('checked')) {
                    aDataRcvCode.push($($(".ocbListItem").eq(nI)).parents('.xWRcvSpcItems').data('rcvcode'));
                    aDataAppCode.push($($(".ocbListItem").eq(nI)).parents('.xWRcvSpcItems').data('appcode'));
                    aDataRcvSeq.push($($(".ocbListItem").eq(nI)).parents('.xWRcvSpcItems').data('rcvseq'));
                    aDataBchCode.push($($(".ocbListItem").eq(nI)).parents('.xWRcvSpcItems').data('bchcode'));
                    aDataMerCode.push($($(".ocbListItem").eq(nI)).parents('.xWRcvSpcItems').data('mercode'));
                    aDataShpCode.push($($(".ocbListItem").eq(nI)).parents('.xWRcvSpcItems').data('shpcode'));
                    aDataAggCode.push($($(".ocbListItem").eq(nI)).parents('.xWRcvSpcItems').data('aggcode'));
                    aDataPosCode.push($($(".ocbListItem").eq(nI)).parents('.xWRcvSpcItems').data('poscode'));
                }
            }
            let aDataWhere = {
                'paRcvCode': aDataRcvCode,
                'paAppCode': aDataAppCode,
                'paRcvSeq': aDataRcvSeq,
                'paBchCode': aDataBchCode,
                'paMerCode': aDataMerCode,
                'paShpCode': aDataShpCode,
                'paAggCode': aDataAggCode,
                'paPosCode': aDataPosCode,
                'pntRcvSpcStaAlwCfg': tRcvSpcStaAlwCfg
            };
            $.ajax({
                type: "POST",
                url: "recivespcEventDeleteMultiple",
                data: {
                    'paDataWhere': aDataWhere,
                    'ptRevCodeWhere': tRevCodeWhere
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    tResult = tResult.trim();
                    var aReturn = $.parseJSON(tResult);
                    if (aReturn['nStaEvent'] == '1') {
                        $('#odvModalDeleteMutirecord').modal('hide');
                        $('#ospConfirmDelete').empty();
                        localStorage.removeItem('LocalItemData');
                        setTimeout(function() {
                            JSvReciveSpcList(pnPage);
                        }, 500);
                    } else {
                        alert(aReturn['tStaMessg']);
                    }
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //Functionality: Function Chack And Show Button Delete All
    //Parameters: LocalStorage Data
    //Creator: 2//11/2019 witsarut (Bell)
    //Return: - 
    //Return Type: -
    function JSxRCVSPCShowButtonChoose() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        } else {
            nNumOfArr = aArrayConvert[0].length;
            if (nNumOfArr > 1) {
                $('#odvMngTableList #oliBtnDeleteAll').removeClass('disabled');
            } else {
                $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
            }
        }
    }

    //Functionality: Function Chack Value LocalStorage
    //Parameters: Event Select List Branch
    //Creator: 26/11/2019 witsarut (Bell)
    //Return: Duplicate/none
    //Return Type: string
    function findObjectByKey(array, key, value) {
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return 'Dupilcate';
            }
        }
        return 'None';
    }

    //Functionality: Insert Text In Modal Delete
    //Parameters: LocalStorage Data
    //Creator: 05/07/2019 witsarut (Bell)
    //Return: -
    //Return Type: -
    function JSxRCVSPCPaseCodeDelInModal() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
            var tTextCode = '';
            for ($i = 0; $i < aArrayConvert[0].length; $i++) {
                tTextCode += aArrayConvert[0][$i].nCode;
                tTextCode += ' , ';
            }
            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
            $('#ohdConfirmIDDelete').val(tTextCode);
        }
    }

    //Functionality: เปลี่ยนหน้า pagenation
    //Parameters: -
    //Creator: 26/11/2019 Witsarut
    //Update: -
    //Return: View
    //Return Type: View
    function JSvRCVSPCClickPage(ptPage) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xWBtnNext").addClass("disabled");
                nPageOld = $(".xWRcbvSpcPaging .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xWRcbvSpcPaging .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSvReciveSpcList(nPageCurrent);
    }
</script>