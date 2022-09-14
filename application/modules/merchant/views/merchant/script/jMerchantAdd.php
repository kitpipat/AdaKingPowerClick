<script type="text/javascript">
    var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';

    $(document).ready(function() {
        $('.selection-2').selectpicker();

        if (JSbMerchantIsCreatePage()) {
            // Merchant Code
            $("#oetMcnCode").attr("disabled", true);
            $('#ocbMerchantAutoGenCode').change(function() {
                if ($('#ocbMerchantAutoGenCode').is(':checked')) {
                    $('#oetMcnCode').val('');
                    $("#oetMcnCode").attr("disabled", true);
                    $('#odvMerchantCodeForm').removeClass('has-error');
                    $('#odvMerchantCodeForm em').remove();
                } else {
                    $("#oetMcnCode").attr("disabled", false);
                }
            });
            JSxMerchantVisibleComponent('#odvMerchantAutoGenCode', true);
        }

        if (JSbMerchantIsUpdatePage()) {
            // Sale Person Code
            $("#oetMcnCode").attr("readonly", true);
            $('#odvMerchantAutoGenCode input').attr('disabled', true);
            JSxMerchantVisibleComponent('#odvMerchantAutoGenCode', false);
        }

        $('#oetMcnCode').blur(function() {
            JSxCheckMerchantCodeDupInDB();
        });
    });

    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckMerchantCodeDupInDB() {
        if (!$('#ocbMerchantAutoGenCode').is(':checked')) {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: {
                    tTableName: "TCNMMerchant",
                    tFieldName: "FTMerCode",
                    tCode: $("#oetMcnCode").val()
                },
                async: false,
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateMcnCode").val(aResult["rtCode"]);
                    JSxMerchantSetValidEventBlur();
                    $('#ofmAddMerchant').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }

    //Functionality: Set Validate Event Blur
    //Parameters: Validate Event Blur
    //Creator: 26/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxMerchantSetValidEventBlur() {
        $('#ofmAddMerchant').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if ($("#ohdCheckDuplicateMcnCode").val() == 1) {
                return false;
            } else {
                return true;
            }
        }, '');

        // From Summit Validate
        $('#ofmAddMerchant').validate({
            rules: {
                oetMcnCode: {
                    "required": {
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if ($('#ocbMerchantAutoGenCode').is(':checked')) {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    },
                    "dublicateCode": {}
                },
                oetMcnName: {
                    "required": {}
                }
            },
            messages: {
                oetMcnCode: {
                    "required": $('#oetMcnCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetMcnCode').attr('data-validate-dublicateCode')
                },
                oetMcnName: {
                    "required": $('#oetMcnName').attr('data-validate-required')
                }
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");
                if (element.prop("type") === "checkbox") {
                    error.appendTo(element.parent("label"));
                } else {
                    var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                    if (tCheck == 0) {
                        error.appendTo(element.closest('.form-group')).trigger('change');
                    }
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
            },
            unhighlight: function(element, errorClass, validClass) {
                var nStaCheckValid = $(element).parents('.form-group').find('.help-block').length
                if (nStaCheckValid != 0) {
                    $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
                }
            },
            submitHandler: function(form) {}
        });
    }

    //function : Call  tab -> กลุ่มสินค้า
    //Parameters : Ajax Success Event 
    //Creator:	13/09/2018 Saharat(Golf)
    //Return : View
    //Return Type : View
    function JSxGetMGPContentInfo() {
        JCNxOpenLoading();
        var tMgpCode = $('#ohdMerchantcode').val();
        $.ajax({
            type: "POST",
            url: "MerPdtGroupList",
            data: {
                tMgpCode: tMgpCode,
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvMGPContentInfo').html(tResult);
                JSvMgpGroupDataTable(1);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //function : Call Product Unit Data List
    //Parameters : Ajax Success Event 
    //Creator:	13/09/2018 Saharat(Golf)
    //Return : View
    //Return Type : View
    function JSvMgpGroupDataTable(pnPage) {
        JCNxOpenLoading();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        var tMerCode = $('#ohdMerchantcode').val();
        var tSearchAll = $('#oetSearchAll').val();
        var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
        $.ajax({
            type: "POST",
            url: "MerPdtGroupDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent,
                tMerCode: tMerCode
            },
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                $('.xCNMgpAdd').addClass('xCNHide');
                $('.xCNMgpTitle').removeClass('xCNHide');
                $('.xCNMgpPageAdd').removeClass('xCNHide');
                $('.xCNMgpPageAdd').removeClass('xCNHide');
                $('#odvBtnMGPInfo').removeClass('xCNHide');
                if (tResult != "") {
                    $('#ostDataProductGroup').html(tResult);
                }
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Functionality : Call Credit Page Add  
    //Parameters : -
    //Creator : 10/06/2019 saharat(Golf)
    //Return : View
    //Return Type : View
    function JSvCallPageProductGroupAdd() {
        $('.xCNMgpTitle').addClass('xCNHide');
        var tMerCode = $('#ohdMerchantcode').val();
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "MerPdtGroupPageAdd",
            data: {
                'tMerCode': tMerCode
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvBtnMGPInfo').addClass('xCNHide');
                $('.xCNMgpPageAdd').addClass('xCNHide');
                $('.xCNMgpAdd').removeClass('xCNHide');
                $('.xCNMgpTitleAdd').removeClass('xCNHide');
                $('#ostDataProductGroup').html(tResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Functionality : Call MerProductGroup Page Edit
    //Parameters : -
    //Creator : 10/06/2019 Krit(golf)
    //Return : View
    //Return Type : View
    function JSvCallPageMerProductGroupEdit(ptMgpCode) {
        JStCMMGetPanalLangSystemHTML('JSvCallPageProductGroupEdit', ptMgpCode);
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "MerPdtGroupPageEdit",
            data: {
                tMgpCode: ptMgpCode
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvBtnMGPInfo').addClass('xCNHide');
                $('.xCNMgpTitle').addClass('xCNHide');
                $('.xCNMgpAdd').removeClass('xCNHide');
                $('.xCNMgpTitleAdd').addClass('xCNHide');
                $('.xCNMgpTitleEdit').removeClass('xCNHide');
                $('.xCNMgpPageAdd').addClass('xCNHide');
                $('#ostDataProductGroup').html(tResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Functionality: Function Chack And Show Button Delete All
    //Parameters: LocalStorage Data
    //Creator: 30/07/2019 Saharat(Golf)
    //Return: - 
    //Return Type: -
    function JSxShowButtonChoose() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        } else {
            nNumOfArr = aArrayConvert[0].length;
            if (nNumOfArr > 1) {
                $('#odvMngTableList #oliBtnDeleteAll').removeClass('disabled');
                $('.xCNIconDel').addClass('xCNDisabled');
            } else {
                $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
                $('.xCNIconDel').removeClass('xCNDisabled');
            }
        }
    }

    //Functionality: Insert Text In Modal Delete
    //Parameters: LocalStorage Data
    //Creator: 30/07/2019 Saharat(Golf)
    //Return: -
    //Return Type: -
    function JSxPaseCodeDelInModal() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
            var tTextCode = '';
            for ($i = 0; $i < aArrayConvert[0].length; $i++) {
                tTextCode += aArrayConvert[0][$i].nCode;
                tTextCode += ' , ';
            }
            $('#odvModalDeleteMutirecord #ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
            $('#odvModalDeleteMutirecord #ohdConfirmIDDelete').val(tTextCode);
        }
    }

    //Functionality: Function Chack Value LocalStorage
    //Parameters: Event Select List Branch
    //Creator: 30/07/2019 Saharat(Golf)
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

    //Functionality : Event Single Delete
    //Parameters : Event Icon Delete
    //Creator : 23/07/2019 saharat(Golf)
    //Return : object Status Delete
    //Return Type : object
    function JSnMerchantGroupDel(pnPage, ptMgpCode, ptMerName) {
        var aData = $('#ohdConfirmIDDelete').val();
        var YesOrNot = $('#oetTextComfirmDeleteYesOrNot').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        if (aDataSplitlength == '1') {
            $('#odvModalDelMerPdt').modal('show');
            $('#odvModalDelMerPdt #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptMgpCode + ' ( ' + ptMerName + ' ) ' + YesOrNot);
            $('#odvModalDelMerPdt #osmConfirm').on('click', function(evt) {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "MerchantProductEventDelete",
                    data: {
                        'tIDCode': ptMgpCode
                    },
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var aReturn = $.parseJSON(tResult);
                        $('#odvModalDelMerPdt').modal('hide');
                        $('#odvModalDelMerPdt #ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        $('#odvModalDelMerPdt #ohdConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                        if (aReturn["nNumRowPdtPUN"] != 0) {
                            if (aReturn["nNumRowPdtPUN"] > 10) {
                                nNumPage = Math.ceil(aReturn["nNumRowPdtPUN"] / 10);
                                if (tCurrentPage <= nNumPage) {
                                    JSvMgpGroupDataTable(tCurrentPage);
                                } else {
                                    JSvMgpGroupDataTable(nNumPage);
                                }
                            } else {
                                JSvMgpGroupDataTable(1);
                            }
                        } else {
                            JSvMgpGroupDataTable(1);
                        }
                        JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });
        }
    }

    //Functionality : (event) Delete All
    //Parameters :
    //Creator : 30/07/2019 saharat(golf)
    //Return : 
    //Return Type :
    function JSxMGPDeleteMutirecord() {
        var aData = $('#odvModalDeleteMutirecord #ohdConfirmIDDelete').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
        }
        if (aDataSplitlength > 1) {
            localStorage.StaDeleteArray = '1';
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "MerchantProductEventDelete",
                data: {
                    'FTMgpCode': aNewIdDelete,
                },
                cache: false,
                timeout: 0,
                success: function(aReturn) {
                    var tReturn = $.parseJSON(aReturn);
                    $('#odvModalDeleteMutirecord #ospConfirmDelete').text($('#odvModalDeleteMutirecord').val());
                    $('#odvModalDeleteMutirecord #ohdConfirmIDeleteMutirecord').val('');
                    localStorage.removeItem('LocalItemData');
                    $('.modal-backdrop').remove();
                    $('#odvModalDeleteMutirecord #odvModalDeleteMutirecord').modal('hide');
                    if (tReturn["nNumRowPdtPUN"] != 0) {
                        if (tReturn["nNumRowPdtPUN"] > 10) {
                            nNumPage = Math.ceil(tReturn["nNumRowPdtPUN"] / 10);
                            if (tCurrentPage <= nNumPage) {
                                JSvMgpGroupDataTable(tCurrentPage);
                            } else {
                                JSvMgpGroupDataTable(nNumPage);
                            }
                        } else {
                            JSvMgpGroupDataTable(1);
                        }
                    } else {
                        JSvMgpGroupDataTable(1);
                    }
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            localStorage.StaDeleteArray = '0';
            return false;
        }
    }


    /*===== Begin Browse Option ========================================================*/
    // Price Group(กลุ่มราคา)
    $('#obtMerPriceGroup').on('click', function() {
        window.oMerBrowsePriceGroup = {
            Title: ['product/pdtpricelist/pdtpricelist', 'tPPLTitle'],
            Table: {
                Master: 'TCNMPdtPriList',
                PK: 'FTPplCode',
                PKName: 'FTPplName'
            },
            Join: {
                Table: ['TCNMPdtPriList_L'],
                On: ['TCNMPdtPriList.FTPplCode = TCNMPdtPriList_L.FTPplCode AND TCNMPdtPriList_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [
                    function() {
                        return "";
                    }
                ]
            },
            GrideView: {
                ColumnPathLang: 'product/pdtpricelist/pdtpricelist',
                ColumnKeyLang: ['tPPLTBCode', 'tPPLTBName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMPdtPriList.FTPplCode', 'TCNMPdtPriList_L.FTPplName'],
                DataColumnsFormat: ['', ''],
                Perpage			: 10,
                OrderBy			: ['TCNMPdtPriList.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetMerPriceGroupCode", "TCNMPdtPriList.FTPplCode"],
                Text: ["oetMerPriceGroupName", "TCNMPdtPriList_L.FTPplName"],
            },
            /* NextFunc: {
                FuncName: '',
                ArgReturn: ['FTPplCode', 'FTPplName']
            }, */
            BrowseLev: 1,
            // DebugSQL : true
        }
        JCNxBrowseData("oMerBrowsePriceGroup");
    });
    /*===== End Browse Option ==========================================================*/
</script>