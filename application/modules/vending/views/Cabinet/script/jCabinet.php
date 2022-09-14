<script>
    $('ducument').ready(function() {
        JSvVDCabinetList();
    });

    //List Cabinet 
    function JSvVDCabinetList(pnPage) {
        var tSearchAll = $('#oetShopCabinetSearch').val();
        $.ajax({
            type: "POST",
            url: "VendingCabinetList",
            data: {
                nPageCurrent: pnPage,
                tSearchAll: tSearchAll,
                tBchCode: $('#ohdShopCabinetPDTBch').val(),
                tShpCode: $('#ohdShopCabinetPDTShp').val()
            },
            success: function(oResult) {
                $('#odvContentCabinet').html(oResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Page Edit
    function JSvCallPageCabinetEdit(pnShop, pnSeq) {
        $.ajax({
            type: "POST",
            url: "VendingCabinetPageAdd",
            data: {
                tBchCode: $('#ohdShopCabinetPDTBch').val(),
                tShpCode: $('#ohdShopCabinetPDTShp').val(),
                nSeq: pnSeq,
                tPageEvent: 'PageEdit'
            },
            success: function(oResult) {
                $('#odvSetionCabinet').html(oResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Click Page 
    function JSvClickPageCabinet(ptPage) {
        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPageCabinet .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWPageCabinet .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }
        JCNxOpenLoading();
        JSvVDCabinetList(nPageCurrent);
    }

    //Delete Cabinet
    function JSaCabinetDelete(tCurrentPage, tShpCode, tSeqCode) {
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tShpCode + ' ( ลำดับ : ' + tSeqCode + ' ) ');
        $('#odvModalDelCabinet').modal('show');
        // $('#osmConfirm').off('click');
        $('#ohdConfirmIDDelete').val(tSeqCode);
    }

    //Delete Cabinet Single
    function JSxCabinetDeleteSingle() {
        $.ajax({
            type: "POST",
            url: "VendingCabinetEventDelete",
            data: {
                'tShpCode': $('#ohdShopCabinetPDTShp').val(),
                'tSeqCode': $('#ohdConfirmIDDelete').val(),
                'tBCH': $('#ohdShopCabinetPDTBch').val()
            },
            cache: false,
            success: function(oResult) {
                var aReturn = JSON.parse(oResult);
                if (aReturn['nStaEvent'] == '1') {
                    $('#odvModalDelCabinet').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');

                    setTimeout(function() {
                        JSxGetSHPContentCabinet();
                    }, 500);
                } else {
                    JCNxCloseLoading();
                    alert(aReturn['tStaMessg']);
                }
            },
            error: function(data) {
                console.log(data)
            }
        });
    }

    //Delete Muti 
    function JSxPaseCodeDelInModalCabinet() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
            var tTextCode = '';
            for ($i = 0; $i < aArrayConvert[0].length; $i++) {
                tTextCode += aArrayConvert[0][$i].nSEQ;
                tTextCode += ',';

                if ($i == aArrayConvert[0].length - 1) {
                    tTextCode = tTextCode.substring(0, tTextCode.length - 1);
                }
            }
            $('#ospConfirmDeleteMuti').text($('#oetTextComfirmDeleteMulti').val());
            $('#ohdConfirmIDDeleteMuti').val(tTextCode);
        }
    }

    //Event Delete Muti
    function JSxCabinetDeleteMuti() {
        var tSeqCode = $('#ohdConfirmIDDeleteMuti').val();
        var tShpCode = $('#ohdShopCabinetPDTShp').val();
        var tBCH = $('#ohdShopCabinetPDTBch').val();
        $.ajax({
            type: "POST",
            url: "VendingCabinetEventDelete",
            data: {
                'tShpCode': tShpCode,
                'tSeqCode': tSeqCode,
                'tBCH': tBCH
            },
            cache: false,
            success: function(oResult) {
                var aReturn = JSON.parse(oResult);
                if (aReturn['nStaEvent'] == '1') {
                    $('#odvModalDelCabinetMuti').modal('hide');
                    $('#ospConfirmDeleteMuti').empty();
                    $('#ohdConfirmIDDeleteMuti').empty();
                    localStorage.removeItem('LocalItemData');

                    setTimeout(function() {
                        JSxGetSHPContentCabinet();
                    }, 500);
                } else {
                    JCNxCloseLoading();
                    alert(aReturn['tStaMessg']);
                }
            },
            error: function(data) {
                console.log(data)
            }
        });
    }
</script>