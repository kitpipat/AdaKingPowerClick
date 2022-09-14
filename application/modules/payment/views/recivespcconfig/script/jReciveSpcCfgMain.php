<script type="text/javascript">
    var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;
    var nStaRcvSpcBrowseType = $('#oetRcvSpcStaBrowse').val();
    var tCallRecSpcBackOption = $('#oetRcvSpcCallBackOption').val();
    
    $(document).ready(function() {
        if (nStaRcvSpcBrowseType != 1) {
            JSvReciveSpcCfgList(1);
        } else {
            JSvCallPageReciveSpcCfgAdd();
        }

    
        // JSvReciveSpcCfgList(1);
        var tUsrLevel = '<?= $this->session->userdata('tSesUsrLevel') ?>';
        if (tUsrLevel == 'HQ') {
            $("#oimRcvSpcBrowseBch").attr("disabled", true); //สาขา
            $("#oimRcvSpcBrowseMer").attr("disabled", true); //ธุรกิจ
            $("#oimRcvSpcBrowseShp").attr("disabled", true);
            $("#oimRcvSpcBrowsePos").attr("disabled", true);
        } else {
            $("#oimRcvSpcBrowseAgg").attr("disabled", true); //ตัวแทน
            $("#oimRcvSpcBrowseMer").attr("disabled", true); //ธุรกิจ
            $("#oimRcvSpcBrowseShp").attr("disabled", true); //ร้านค้า
            $("#oimRcvSpcBrowsePos").attr("disabled", true); //จุดขาย

            if ($('#oetRcvSpcBchCode').val() != '') {
                $("#oimRcvSpcBrowseBch").attr("disabled", true);
            }
        }

        if ($('#oetRcvSpcBchCode').val() != '') {
            $("#oimRcvSpcBrowseMer").attr("disabled", false);
        }

        if ($('#oetRcvSpcMerCode').val() != '') {
            $("#oimRcvSpcBrowseShp").attr("disabled", false);
        }

        if ($('#oetRcvSpcShpCode').val() != '') {
            $("#oimRcvSpcBrowsePos").attr("disabled", false);
        }
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
    function JSvReciveSpcCfgList(nPage) {
        var tRcvSpcCode = $('#ohdRcvSpcCode').val();
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "recivespcconfigDataTable",
            data: {
                tRcvSpcCode: tRcvSpcCode,
                nPageCurrent: nPage,
                tSearchAll: ''
            },
            cache: false,
            Timeout: 0,
            async: false,
            success: function(tView) {
                $('#odvContentRcvSpcCfgDataTable').html(tView);
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
    function JSvCallPageReciveSpcCfgAdd() {
        var tRcvSpcCode = $('#ohdRcvSpcCode').val();
        var tRcvSpcName = $('#ohdRcvSpcName').val();

        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "recivespcconfigPageAdd",
            data: {
                tRcvSpcCode: tRcvSpcCode,
                tRcvSpcName: tRcvSpcName
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvRcvSpcConfig').html(tResult);
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
    function JSvCallPageRcvSpcCfgEdit(paDataWhereEdit) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "recivespcconfigPageEdit",
            data: {
                'paDataWhereEdit': paDataWhereEdit
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvRcvSpcConfig').html(tResult);
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

    //Functionality : Add Data Agency Add/Edit  
    //Parameters : from ofmAddEditCrdLogin
    //Creator : 04/07/2019 witsarut (Bell)
    //Return : View
    //Return Type : View
    function JSxRcvSpvCfgSaveAddEdit(ptRoute) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JCNxOpenLoading();
            // alert(ptRoute);
            $.ajax({
                type: "POST",
                url: ptRoute,
                data: $('#ofmAddEditRcvSpcCfg').serialize(),
                catch: false,
                timeout: 0,
                success: function(tResult) {
                    // console.log(tResult);
                    var aData = JSON.parse(tResult);
                    if (aData["nStaEvent"] == 1) {
                        JSxRcvSpcGetConfig();
                        JCNxCloseLoading();
                    } else if (aData["nStaEvent"] == 900) {
                        JCNxCloseLoading();
                    } else {
                        var tMsgErrorFunction = aData['tStaMessg'];
                        FSvCMNSetMsgErrorDialog('<p class="text-left">' + tMsgErrorFunction + '</p>');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }
    }


    //Functionality: (event) Delete
    //Parameters: Button Event [tIDCode tCrdCode]
    //Creator: 26/11/2019 Witsarut (Bell)
    //Update: -
    //Return: Event Delete Reason List
    //Return Type: -
    function JSxRCVSpcCfgDelete(paDataWhere) {
        $('#odvModalDeleteSingleCfg').modal('show');
        $('#odvModalDeleteSingleCfg #ospConfirmDeleteCfg').html($('#oetTextComfirmDeleteSingle').val() + ' ' + paDataWhere.ptRcvCode + ' (ประเถทการเชื่อมต่อ ' + paDataWhere.pnRcvSeq + ')' + ' ' + $('#oetTextComfirmDeleteYesOrNot').val());
        $('#odvModalDeleteSingleCfg #osmConfirmDeleteCfg').on('click', function(evt) {
            $.ajax({
                type: "POST",
                url: "recivespcconfigEventDelete",
                data: {
                    'paDataWhere': paDataWhere
                },
                cache: false,
                success: function(tResult) {
                    $('#odvModalDeleteSingleCfg').modal('hide');
                    setTimeout(function() {
                        JSvReciveSpcCfgList(1);
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
    function JSxRCVSpcCfgDeleteMutirecord(pnPage) {
        let nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            // JCNxOpenLoading();
            let aDataRcvCode = [];
            let aDataRcvSeq = [];
            var nRcvCode = $(".ohdRevCodeDel").val();
            let ocbListItem = $(".ocbListItemCfg");
            for (var nI = 0; nI < ocbListItem.length; nI++) {
                if ($($(".ocbListItemCfg").eq(nI)).prop('checked')) {
                    // aDataRcvCode.push($($(".ocbListItemCfg").eq(nI)).parents('.xWRcvSpcItems').data('rcvcode'));
                    aDataRcvSeq.push($($(".ocbListItemCfg").eq(nI)).parents('.xWRcvSpcItems').data('rcvseq'));
                }
            }
            let aDataWhere = {
                // 'paRcvCode': aDataRcvCode,
                'paRcvSeq': aDataRcvSeq,
            };
            $.ajax({
                type: "POST",
                url: "recivespcconfigEventDeleteMultiple",
                data: {
                    'paDataWhere': aDataWhere,
                    'pnRcvCode': nRcvCode
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    tResult = tResult.trim();
                    var aReturn = $.parseJSON(tResult);
                    if (aReturn['nStaEvent'] == '1') {
                        $('#odvModalDeleteMutirecordCfg').modal('hide');
                        $('#ospConfirmDeleteCfg').empty();
                        localStorage.removeItem('LocalItemData');
                        setTimeout(function() {
                            JSvReciveSpcCfgList(pnPage);
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
    function JSxRCVSPCPaseCodeDelInModalCfg() {

        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
            var tTextCode = '';
            for ($i = 0; $i < aArrayConvert[0].length; $i++) {
                tTextCode += aArrayConvert[0][$i].pnRcvSeq;
                tTextCode += ' , ';
            }
            $('#ospConfirmDeleteCfg').text($('#oetTextComfirmDeleteMulti').val());
            $('#ohdConfirmIDDeleteCfg').val(tTextCode);
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
        JSvReciveSpcCfgList(nPageCurrent);
    }


    // *******************************************************************************
    // ระบบ
    $('#oimRcvSpcBrowseApp').click(function() {
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowsetSysApp');
    });

    //สาขา
    $('#oimRcvSpcBrowseBch').click(function() {
        JSxCheckPinMenuClose();
        oRcvSpcBrwOption = oBrowseBranch({
            'tHiddenRcvSpc': $('#ohdRcvAgg').val()
        });
        JCNxBrowseData('oRcvSpcBrwOption');
    });

    // กลุ่มธุรกิจ
    $('#oimRcvSpcBrowseMer').click(function() {
        JSxCheckPinMenuClose();
        oRcvSpcBchBrwOption = oBrowseMer({
            'tHiddenRcvSpcMer': $('#ohdRcvSpcBch').val()
        });
        JCNxBrowseData('oRcvSpcBchBrwOption');
    });

    // ร้านค้า
    $('#oimRcvSpcBrowseShp').click(function() {
        JSxCheckPinMenuClose();
        oRcvSpcMerBrwOption = oBrowseShop({
            'tHiddenRcvSpcShp': $('#ohdRcvSpcMer').val()
        });
        JCNxBrowseData('oRcvSpcMerBrwOption');
    });

    // กลุ่มตัวแทน
    $('#oimRcvSpcBrowseAgg').click(function() {
        JSxCheckPinMenuClose();
        oRcvSpcShpBrwOption = oBrowseAgg({
            'tHiddenRcvSpcAgg': $('#ohdRcvSpc').val()
        });
        JCNxBrowseData('oRcvSpcShpBrwOption');
    });

    // จุดขาย
    $('#oimRcvSpcBrowsePos').click(function() {
        JSxCheckPinMenuClose();
        oRcvSpcShpBrwOption = oBrowsePos({
            'tHiddenRcvSpcPos': $('#ohdRcvSpcPos').val()
        });
        JCNxBrowseData('oRcvSpcShpBrwOption');
    });

    // ระบบ
    var oBrowsetSysApp = {
        Title: ['payment/recivespc/recivespc', 'tBrowseAppTitle'],
        Table: {
            Master: 'TSysApp',
            PK: 'FTAppCode'
        },
        Join: {
            Table: ['TSysApp_L'],
            On: ['TSysApp_L.FTAppCode = TSysApp.FTAppCode AND TSysApp_L.FNLngID =' + nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'payment/recivespc/recivespc',
            ColumnKeyLang: ['tBrowseAppCode', 'tBrowseAppName'],
            ColumnsSize: ['15%', '75%'],
            DataColumns: ['TSysApp.FTAppCode', 'TSysApp_L.FTAppName'],
            DataColumnsFormat: ['', ''],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TSysApp.FDCreateOn DESC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetRcvSpcAppCode", "TSysApp.FTAppCode"],
            Text: ["oetRcvSpcAppName", "TSysApp_L.FTAppName"]
        },
        // NextFunc: {
        //     FuncName: 'JSxNextFuncRcvSpc',
        //     ArgReturn: ['FTAppCode']
        // },
    };

    // function JSxNextFuncRcvSpc(paDataReturn){
    //     $("#oimRcvSpcBrowseAgg").attr("disabled", true);  //ตัวแทน
    //     $("#oimRcvSpcBrowseBch").attr("disabled", true);  //สาขา
    //     $("#oimRcvSpcBrowseMer").attr("disabled", true);  //ธุรกิจ
    //     $("#oimRcvSpcBrowseShp").attr("disabled", true);
    //     $("#oimRcvSpcBrowsePos").attr("disabled", true);
    //     // console.log('JSxNextFuncRcvSpc Clear Data');
    //     // console.log(paDataReturn);
    //     if(paDataReturn != 'NULL'){
    //         var aRcvSpc = JSON.parse(paDataReturn);
    //         $("#oimRcvSpcBrowseAgg").attr("disabled",false);
    //         $('#ohdRcvSpc').val(aRcvSpc[0]);
    //     } else {
    //         $('#ohdRcvSpc').val('');
    //     }

    //     $('#oetRcvSpcBchCode').val('');
    //     $('#oetRcvSpcBchName').val('');

    //     $('#oetRcvSpcMerCode').val('');
    //     $('#oetRcvSpcMerName').val('');

    //     $('#oetRcvSpcShpCode').val('');
    //     $('#oetRcvSpcShpName').val('');

    //     $('#oetRcvSpcAggCode').val('');
    //     $('#oetRcvSpcAggName').val('');
    // }

    // สาขา
    var oBrowseBranch = function(poDataFnc) {
        var tWhereModal = poDataFnc.tHiddenRcvSpc;
        var tWhere = '';
        var nAggCode = $('#oetRcvSpcAggCode').val();
        if (nAggCode != '') {
            tWhere = ' AND TCNMBranch.FTAgnCode = ' + nAggCode + ' '
        }

        var oOptionReturn = {
            Title: ['authen/user/user', 'tBrowseBCHTitle'],
            Table: {
                Master: 'TCNMBranch',
                PK: 'FTBchCode'
            },
            Join: {
                Table: ['TCNMBranch_L'],
                On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: ['AND 1=1 ' + tWhere + ' ']
            },
            GrideView: {
                ColumnPathLang: 'authen/user/user',
                ColumnKeyLang: ['tBrowseBCHCode', 'tBrowseBCHName'],
                ColumnsSize: ['10%', '75%'],
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMBranch.FDCreateOn DESC'],
                // SourceOrder	: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetRcvSpcBchCode", "TCNMBranch.FTBchCode"],
                Text: ["oetRcvSpcBchName", "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName: 'JSxNextFuncRcvSpcBch',
                ArgReturn: ['FTBchCode']
            },
            RouteAddNew: 'branch',
            BrowseLev: nStaRcvBrowseType
        };
        return oOptionReturn;
    }

    function JSxNextFuncRcvSpcBch(paDataReturn) {
        // console.log('JSxNextFuncRcvSpcBch');
        // $("#oimRcvSpcBrowseMer").attr("disabled", true);
        $("#oimRcvSpcBrowseShp").attr("disabled", true);
        // $("#oimRcvSpcBrowseAgg").attr("disabled", true);
        $("#oimRcvSpcBrowsePos").attr("disabled", true);
        if (paDataReturn != 'NULL') {
            var aRcvSpcBch = JSON.parse(paDataReturn);
            $("#oimRcvSpcBrowseMer").attr("disabled", false);
            $('#ohdRcvSpcBch').val(aRcvSpcBch[0]);

            if ($('#ohdRcvSpcIsShpEnabled').val() == '0') {
                $("#oimRcvSpcBrowseAgg").attr("disabled", false);
            }
            if ($('#oetRcvSpcMerCode').val() != '') {
                $("#oimRcvSpcBrowseShp").attr("disabled", false);
            }
        } else {
            $('#ohdRcvSpcBch').val('');
        }
        // $('#oetRcvSpcMerCode').val('');
        // $('#oetRcvSpcMerName').val('');

        $('#oetRcvSpcShpCode').val('');
        $('#oetRcvSpcShpName').val('');

        $('#oetRcvSpcPosCode').val('');
        $('#oetRcvSpcPosName').val('');

        // $("#oimRcvSpcBrowseShp").attr("disabled", true); //ร้านค้า
        // $("#oimRcvSpcBrowsePos").attr("disabled", true); //จุดขาย
    }

    // Option กลุ่มธุรกิจ
    var oBrowseMer = function(poDataFnc) {
        var tWhereModal = poDataFnc.tHiddenRcvSpcMer;
        var tWhere = "";
        var nBchCode = $('#oetRcvSpcBchCode').val();

        // if(nBchCode != '')
        // if (typeof(nBchCode) != undefined && nBchCode != "") {
        //     tWhere += " AND ((SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '" + nBchCode + "') != 0)";
        // }
        var oOptionReturn = {
            Title: ['company/merchant/merchant', 'tMerchantTitle'],
            Table: {
                Master: 'TCNMMerchant',
                PK: 'FTMerCode'
            },
            Join: {
                Table: ['TCNMMerchant_L'],
                On: ['TCNMMerchant_L.FTMerCode = TCNMMerchant.FTMerCode AND TCNMMerchant_L.FNLngID = ' + nLangEdits, ]
            },
            Where: {
                Condition: [tWhere]
            },
            GrideView: {
                ColumnPathLang: 'company/merchant/merchant',
                ColumnKeyLang: ['tMerCode', 'tMerName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMMerchant.FTMerCode', 'TCNMMerchant_L.FTMerName'],
                DataColumnsFormat: ['', ''],
                // Perpage			: 5,
                // OrderBy			: ['TCNMMerchant_L.FTMerName'],
                // SourceOrder		: "ASC"
                Perpage: 10,
                OrderBy: ['TCNMMerchant.FDCreateOn DESC'],

            },
            // DebugSQL: true,
            CallBack: {
                ReturnType: 'S',
                Value: ["oetRcvSpcMerCode", "TCNMMerchant.FTMerCode"],
                Text: ["oetRcvSpcMerName", "TCNMMerchant_L.FTMerName"],
            },
            NextFunc: {
                FuncName: 'JSxNextFuncRcvSpcMer',
                ArgReturn: ['FTMerCode']
            },
            // RouteFrom : 'shop',
            RouteAddNew: 'merchant',
            BrowseLev: nStaRcvBrowseType
        };
        return oOptionReturn;
    }

    function JSxNextFuncRcvSpcMer(paDataReturn) {
        $("#oimRcvSpcBrowseShp").attr("disabled", true);
        // $("#oimRcvSpcBrowseAgg").attr("disabled", true);
        if (paDataReturn != 'NULL') {
            var aRcvSpcMer = JSON.parse(paDataReturn);
            $("#oimRcvSpcBrowseShp").attr("disabled", false);
            $('#ohdRcvSpcMer').val(aRcvSpcMer[0]);
        } else {
            $('#ohdRcvSpcMer').val('');
            $("#oimRcvSpcBrowsePos").attr("disabled", true);
        }

        $('#oetRcvSpcShpCode').val('');
        $('#oetRcvSpcShpName').val('');

        $('#oetRcvSpcPosCode').val('');
        $('#oetRcvSpcPosName').val('');

        // $('#oetRcvSpcAggCode').val('');
        // $('#oetRcvSpcAggName').val('');

    }

    //ร้านค้า
    var oBrowseShop = function(poDataFnc) {
        var tWhereModal = poDataFnc.tHiddenRcvSpcShp;
        var nBchCode = $('#oetRcvSpcBchCode').val();
        var nMerCode = $('#oetRcvSpcMerCode').val();
        var tWhereBchCode = '';
        var tWhereMerCode = '';
        if (nBchCode != '') {
            tWhereBchCode = ' AND TCNMShop.FTBchCode = ' + nBchCode + ' '
        }

        if (nMerCode != '') {
            tWhereMerCode = ' AND TCNMShop.FTMerCode = ' + nMerCode + ' '
        }
        var oOptionReturn = {
            Title: ['authen/user/user', 'tBrowseSHPTitle'],
            Table: {
                Master: 'TCNMShop',
                PK: 'FTShpCode'
            },
            Join: {
                Table: ['TCNMShop_L'],
                On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: ['AND 1=1 ' + tWhereBchCode + tWhereMerCode + ' ']
            },
            GrideView: {
                ColumnPathLang: 'authen/user/user',
                ColumnKeyLang: ['tBrowseSHPCode', 'tBrowseSHPName'],
                ColumnsSize: ['10%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName', 'TCNMShop.FTShpType'],
                DisabledColumns: [2],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMShop.FDCreateOn DESC'],
                // OrderBy			: ['TCNMShop.FTShpCode'],
                // SourceOrder		: "ASC"
            },
            //  DebugSQL: true,
            CallBack: {
                StaSingItem: '1',
                ReturnType: 'S',
                Value: ["oetRcvSpcShpCode", "TCNMShop.FTShpCode"],
                Text: ["oetRcvSpcShpName", "TCNMShop_L.FTShpName"]
            },
            NextFunc: {
                FuncName: 'JSxNextFuncRcvSpcShp',
                ArgReturn: ['FTShpCode', 'FTShpType']
            },
            // RouteAddNew: 'shop',
            // BrowseLev: nStaRcvBrowseType
        };
        return oOptionReturn;
    }
    // var nShpType = '';

    function JSxNextFuncRcvSpcShp(paDataReturn) {

        $("#oimRcvSpcBrowsePos").attr("disabled", true);
        if (paDataReturn != 'NULL') {
            var aRcvSpcShp = JSON.parse(paDataReturn);
            $("#oimRcvSpcBrowsePos").attr("disabled", false);
            $('#ohdRcvSpcShp').val(aRcvSpcShp[0]);

            $('#ohdRcvSpcShpType').val(aRcvSpcShp[1]);
            // alert(nShpType);
        } else {
            $('#ohdRcvSpcShp').val('');
        }
        $('#oetRcvSpcPosCode').val('');
        $('#oetRcvSpcPosName').val('');


    }

    // *******************************************************************************



    //กลุ่มตัวแทน
    var oBrowseAgg = function(poDataFnc) {
        var tWhereModal = poDataFnc.tHiddenRcvSpcAgg;
        var oOptionReturn = {
            Title: ['payment/recivespc/recivespc', 'tBrowseAggGrp'],
            Table: {
                Master: 'TCNMAgency',
                PK: 'FTAgnCode'
            },
            Join: {
                Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID =' + nLangEdits]
            },
            GrideView: {
                ColumnPathLang: 'payment/recivespc/recivespc',
                ColumnKeyLang: ['tBrowseAggCode', 'tBrowseAggName'],
                ColumnsSize: ['15%', '75%'],
                DataColumns: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMAgency.FDCreateOn DESC'],
                // SourceOrder	: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetRcvSpcAggCode", "TCNMAgency.FTAgnCode"],
                Text: ["oetRcvSpcAggName", "TCNMAgency_L.FTAgnName"]
            },
            NextFunc: {
                FuncName: 'JSxNextFuncRcvAgg',
                ArgReturn: ['FTAgnCode']
            },
        };
        return oOptionReturn;
    }

    function JSxNextFuncRcvAgg(paDataReturn) {
        $("#oimRcvSpcBrowseBch").attr("disabled", true); //สาขา
        $("#oimRcvSpcBrowseMer").attr("disabled", true); //ธุรกิจ
        $("#oimRcvSpcBrowseShp").attr("disabled", true);
        $("#oimRcvSpcBrowsePos").attr("disabled", true);
        // console.log('JSxNextFuncRcvSpc Clear Data');
        // console.log(paDataReturn);
        if (paDataReturn != 'NULL') {
            var aRcvSpc = JSON.parse(paDataReturn);
            $("#oimRcvSpcBrowseBch").attr("disabled", false);
            $('#ohdRcvAgg').val(aRcvSpc[0]);
        } else {
            $('#ohdRcvAgg').val('');
        }

        $('#oetRcvSpcBchCode').val('');
        $('#oetRcvSpcBchName').val('');

        $('#oetRcvSpcMerCode').val('');
        $('#oetRcvSpcMerName').val('');

        $('#oetRcvSpcShpCode').val('');
        $('#oetRcvSpcShpName').val('');

    }

    // Browse Pos (เครื่องจุดขาย) 
    var oBrowsePos = function(poDataFnc) {
        var tWhereModal = poDataFnc.tHiddenRcvSpcPos;
        var nBchCode = $('#oetRcvSpcBchCode').val();
        var nShpCode = $('#oetRcvSpcShpCode').val();
        var tWhereBch = '';
        var tWhereShp = '';
        var nShpType = $('#ohdRcvSpcShpType').val();
        // alert(nShpType)

        if (nShpCode != '' && nBchCode != '') {
            if (nShpType == 4) {
                if (nBchCode != '') {
                    tWhereBch = ' AND TCNMPos.FTBchCode = ' + nBchCode + ' '
                }
                var oOptionReturn = {
                    Title: ['company/warehouse/warehouse', 'tSalemachinePOS'],
                    Table: {
                        Master: 'TCNMPos',
                        PK: 'FTPosCode'
                    },
                    Join: {
                        Table: ['TCNMPos_L'],
                        On: ['TCNMPos_L.FTPosCode = TCNMPos.FTPosCode AND TCNMPos.FTBchCode = TCNMPos_L.FTBchCode AND TCNMPos_L.FNLngID =' + nLangEdits]
                    },
                    Where: {
                        Condition: ["AND 1 = '1' " + tWhereBch]
                    },
                    GrideView: {
                        ColumnPathLang: 'pos/salemachine/salemachine',
                        ColumnKeyLang: ['tPOSCode', 'tPOSName'],
                        ColumnsSize: ['15%', '75%'],
                        WidthModal: 50,
                        DataColumns: ['TCNMPos.FTPosCode', 'TCNMPos_L.FTPosName'],
                        DataColumnsFormat: ['', ''],
                        Perpage: 5,
                        OrderBy: ['TCNMPos.FTPosCode'],
                        SourceOrder: "ASC"
                    },
                    // DebugSQL: true,
                    CallBack: {
                        ReturnType: 'S',
                        Value: ["oetRcvSpcPosCode", "TCNMPos.FTPosCode"],
                        Text: ["oetRcvSpcPosName", "TCNMPos_L.FTPosName"],
                    },
                    // RouteAddNew: 'salemachine',
                    // BrowseLev: nStaZneBrowseType
                };
            } else if (nShpType == 5) {
                if (nBchCode != '') {
                    tWhereBch = ' AND TRTMShopPos.FTBchCode = ' + nBchCode + ' '
                }
                var oOptionReturn = {
                    Title: ['company/warehouse/warehouse', 'tSalemachinePOS'],
                    Table: {
                        Master: 'TRTMShopPos',
                        PK: 'FTPosCode'
                    },
                    Join: {
                        Table: ['TCNMPos_L'],
                        On: ['TCNMPos_L.FTPosCode = TRTMShopPos.FTPosCode AND TRTMShopPos.FTBchCode = TCNMPos_L.FTBchCode AND TCNMPos_L.FNLngID =' + nLangEdits]
                    },
                    Where: {
                        Condition: ["AND 1 = '1' " + tWhereBch]
                    },
                    GrideView: {
                        ColumnPathLang: 'pos/salemachine/salemachine',
                        ColumnKeyLang: ['tPOSCode', 'tPOSName'],
                        ColumnsSize: ['15%', '75%'],
                        WidthModal: 50,
                        DataColumns: ['TRTMShopPos.FTPosCode', 'TCNMPos_L.FTPosName'],
                        DataColumnsFormat: ['', ''],
                        Perpage: 5,
                        OrderBy: ['TRTMShopPos.FTPosCode'],
                        SourceOrder: "ASC"
                    },
                    // DebugSQL: true,
                    CallBack: {
                        ReturnType: 'S',
                        Value: ["oetRcvSpcPosCode", "TRTMShopPos.FTPosCode"],
                        Text: ["oetRcvSpcPosName", "TCNMPos_L.FTPosName"],
                    },
                    // RouteAddNew: 'salemachine',
                    // BrowseLev: nStaZneBrowseType
                };
            }
        } else {
            if (nBchCode != '') {
                tWhereBch = ' AND TCNMPos.FTBchCode = ' + nBchCode + ' '
            }
            var oOptionReturn = {
                Title: ['company/warehouse/warehouse', 'tSalemachinePOS'],
                Table: {
                    Master: 'TCNMPos',
                    PK: 'FTPosCode'
                },
                Join: {
                    Table: ['TCNMPos_L'],
                    On: ['TCNMPos_L.FTPosCode = TCNMPos.FTPosCode AND TCNMPos.FTBchCode = TCNMPos_L.FTBchCode AND TCNMPos_L.FNLngID =' + nLangEdits]
                },
                Where: {
                    Condition: ["AND 1 = '1' " + tWhereBch]
                },
                GrideView: {
                    ColumnPathLang: 'pos/salemachine/salemachine',
                    ColumnKeyLang: ['tPOSCode', 'tPOSName'],
                    ColumnsSize: ['15%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMPos.FTPosCode', 'TCNMPos_L.FTPosName'],
                    DataColumnsFormat: ['', ''],
                    Perpage: 5,
                    OrderBy: ['TCNMPos.FTPosCode'],
                    SourceOrder: "ASC"
                },
                // DebugSQL: true,
                CallBack: {
                    ReturnType: 'S',
                    Value: ["oetRcvSpcPosCode", "TCNMPos.FTPosCode"],
                    Text: ["oetRcvSpcPosName", "TCNMPos_L.FTPosName"],
                },
                // RouteAddNew: 'salemachine',
                // BrowseLev: nStaZneBrowseType
            };
        }


        return oOptionReturn;
    }
</script>