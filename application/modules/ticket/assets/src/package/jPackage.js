$('document').ready(function () {

    // หาความสูงของหน้าจอ
    // nHeight = $( window ).height();
    // nHeight = nHeight-220;
    //
    // $('#oResultPackage').css('height',nHeight);

    FSxCheckPkgHavePdt();

    $('#ocmAddPkgType').change(function () {
        alert('1');
    });

});

function JSxPKGPkgSpcPriHLDSave() {
    nPpkID = $('#ohdPpkID').val();
    dPphCheckIn = $('#ohdPphCheckIn').val();
    nPphSign = $('#ocmPphSign').val();
    nPphAdjType = $('#ocmPphAdjType').val();
    nPphValue = $('#oetPphValue').val();

    if (dPphCheckIn == '') {
        tMsgPlsSelDate = $('#ohdMsgPlsSelDate').val();
        // กรุณาเลือกวันที่
        alert(tMsgPlsSelDate);
    } else if (nPphValue == '' || nPphValue == '0') {
        $('#oetGphValue').focus();
        if (nPphValue == '') {
            tMsgPlsEntAmtPerBht = $('#ohdMsgPlsEntAmtPerBht').val();
            // กรุณาใส่จำนวน/บาท
            alert(tMsgPlsEntAmtPerBht);
        } else if (nPphValue == 0) {
            // กรอกจำนวน ที่ไม่ใช่ 0
            tMsgEntNot0 = $('#ohdMsgEntNot0').val();
            alert(tMsgEntNot0);
        }
    } else {
        $.ajax({
            type: "POST",
            url: "EticketPackage_AddPkgSpcPriHLD",
            data: {
                nPpkID: nPpkID,
                dPphCheckIn: dPphCheckIn,
                nPphSign: nPphSign,
                nPphAdjType: nPphAdjType,
                nPphValue: nPphValue
            },
            cache: false,
            success: function (tResult) {

                tResult = tResult.trim();
                aResult = tResult.split(',');

                alert(aResult[1]);

                if (aResult[0] == '1') {
                    $('#olaTabPkgPriHoliday').click();
                }

            },
            error: function (data) {
                console.log(data);
            }
        });
    }
}

function JSnPKGDelPkgHoliday(nPpkID, dPphCheckIn) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_DelPkgSpcPriHLD",
        data: {
            nPpkID: nPpkID,
            dPphCheckIn: dPphCheckIn
        },
        cache: false,
        success: function (tResult) {

            tResult = tResult.trim();
            aResult = tResult.split(',');
            alert(aResult[1]);

            if (aResult[0] == '1') {
                $('#olaTabPkgPriHoliday').click();
            }

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function FSxCallPagePkgSpcPriByHLD(nPkgID, nPpkID) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPagePkgPriByHLDPanal",
        data: {
            nPkgID: nPkgID,
            nPpkID: nPpkID
        },
        cache: false,
        success: function (tResult) {

            $('#odvTabPkgPriHLDPanal').html(tResult);

        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSnClickPdtPanal(nPkgID) {

    JSxCallPageModelAndPdtPanal(nPkgID);

    setTimeout(function () {
        $('#olaTabPkgProduct').click();
    }, 450);

}

function JSxPKGGrpSpcPriHLDSave() {

    nPgpGrpID = $('#ohdPgpGrpID').val();
    dGphCheckIn = $('#ohdGphCheckIn').val();
    nGphSign = $('#ocmGphSign').val();
    nGphAdjType = $('#ocmGphAdjType').val();
    nGphValue = $('#oetGphValue').val();

    if (dGphCheckIn == '') {
        tMsgPlsSelDate = $('#ohdMsgPlsSelDate').val();
        // กรุณาเลือกวันที่
        alert(tMsgPlsSelDate);
    } else if (nGphValue == '' || nGphValue == '0') {
        $('#oetGphValue').focus();
        if (nGphValue == '') {
            tMsgPlsEntAmtPerBht = $('#ohdMsgPlsEntAmtPerBht').val();
            // กรุณาใส่จำนวน/บาท
            alert(tMsgPlsEntAmtPerBht);
        } else if (nGphValue == 0) {
            tMsgEntNot0 = $('#ohdMsgEntNot0').val();
            alert(tMsgEntNot0);
        }
    } else {

        $.ajax({
            type: "POST",
            url: "EticketPackage_AddGrpSpcPriHLD",
            data: {
                nPgpGrpID: nPgpGrpID,
                dGphCheckIn: dGphCheckIn,
                nGphSign: nGphSign,
                nGphAdjType: nGphAdjType,
                nGphValue: nGphValue
            },
            cache: false,
            success: function (tResult) {

                tResult = tResult.trim();
                aResult = tResult.split(',');

                alert(aResult[1]);

                if (aResult[0] == '1') {
                    $('#olaTabGrpPriSpcPriByHLD').click();
                }

            },
            error: function (data) {
                console.log(data);
            }
        });
    }

}

function JSnPKGDelGrpHoliday(nPgpGrpID, dGphCheckIn) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_DelGrpSpcPriHLD",
        data: {
            nPgpGrpID: nPgpGrpID,
            dGphCheckIn: dGphCheckIn
        },
        cache: false,
        success: function (tResult) {

            tResult = tResult.trim();
            aResult = tResult.split(',');
            alert(aResult[1]);

            if (aResult[0] == '1') {
                $('#olaTabGrpPriSpcPriByHLD').click();
            }

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function JSnPKGDelPdtHoliday(nPkgPdtID, dPphCheckIn) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_DelPdtSpcPriHLD",
        data: {
            nPkgPdtID: nPkgPdtID,
            dPphCheckIn: dPphCheckIn
        },
        cache: false,
        success: function (tResult) {

            tResult = tResult.trim();
            aResult = tResult.split(',');
            alert(aResult[1]);

            if (aResult[0] == '1') {
                $('#olaTabPdtPriSpcPriByHLD').click();
            }

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function JSxPKGPdtSpcPriHLDSave() {

    nPkgPdtID = $('#ohdPkgPdtID').val();
    dPphCheckIn = $('#ohdPphCheckIn').val();
    nPphSign = $('#ocmPphSign').val();
    nPphAdjType = $('#ocmPphAdjType').val();
    nPphValue = $('#oetPphValue').val();

    if (dPphCheckIn == '') {
        tMsgPlsSelDate = $('#ohdMsgPlsSelDate').val();
        // กรุณาเลือกวันที่
        alert(tMsgPlsSelDate);
    } else if (nPphValue == '' || nPphValue == '0') {
        $('#oetPphValue').focus();
        if (nPphValue == '') {
            tMsgPlsEntAmtPerBht = $('#ohdMsgPlsEntAmtPerBht').val();
            // กรุณาใส่จำนวน/บาท
            alert(tMsgPlsEntAmtPerBht);
        } else if (nPphValue == 0) {
            tMsgEntNot0 = $('#ohdMsgEntNot0').val();
            alert(tMsgEntNot0);
        }
    } else {

        $.ajax({
            type: "POST",
            url: "EticketPackage_AddPdtSpcPriHLD",
            data: {
                nPkgPdtID: nPkgPdtID,
                dPphCheckIn: dPphCheckIn,
                nPphSign: nPphSign,
                nPphAdjType: nPphAdjType,
                nPphValue: nPphValue
            },
            cache: false,
            success: function (tResult) {

                tResult = tResult.trim();
                aResult = tResult.split(',');
                bootbox.alert({
                    title: aLocale['tWarning'],
                    message: aResult[1],
                    buttons: {
                        ok: {
                            label: aLocale['tOK'],
                            className: 'xCNBTNPrimery'
                        }
                    },
                    callback: function () {
                        $('.bootbox').modal('hide');
                    }
                });
                if (aResult[0] == '1') {
                    $('#olaTabPdtPriSpcPriByHLD').click();
                }

            },
            error: function (data) {
                console.log(data);
            }
        });
    }

}

function JSxBtnAddPKGPriBooking() {

    $("#ofmAddPKGPriBooking").validate({
        rules: {
            oetPpbDayFrm: "required",
            oetPpbDayTo: "required",
            ocmPpbSign: "required",
            ocmPpbAdjType: "required",
            oetPpbValue: "required",
        },
        errorClass: "input-invalid",
        validClass: "input-valid",
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        },
        submitHandler: function (form) {

            $.ajax({
                type: "POST",
                url: "EticketPackage_AddPkgPriBKG",
                data: $("#ofmAddPKGPriBooking").serialize(),
                cache: false,
                success: function (tResult) {
                    tResult = tResult.trim();
                    aResult = tResult.split(',');
                    bootbox.alert({
                        title: aLocale['tWarning'],
                        message: aResult[1],
                        buttons: {
                            ok: {
                                label: aLocale['tOK'],
                                className: 'xCNBTNPrimery'
                            }
                        },
                        callback: function () {
                            $('.bootbox').modal('hide');
                        }
                    });
                    $('#olaTabPkgPriBooking').click();

                },
                error: function (data) {
                    console.log(data);
                }
            });
            return false;

        }
    });

}

function JSxBtnAddPKGGrpPriBooking() {

    $("#ofmAddPKGGrpPriBooking").validate({
        rules: {
            oetGpbDayFrm: "required",
            oetGpbDayTo: "required",
            ocmPpbSign: "required",
            ocmGpbAdjType: "required",
            oetGpbValue: "required",
        },
        errorClass: "input-invalid",
        validClass: "input-valid",
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        },
        submitHandler: function (form) {

            $.ajax({
                type: "POST",
                url: "EticketPackage_AddPkgGrpPriBKG",
                data: $("#ofmAddPKGGrpPriBooking").serialize(),
                cache: false,
                success: function (tResult) {

                    tResult = tResult.trim();
                    aResult = tResult.split(',');
                    if (aResult[0] == '1') {
                        $('#olaTabGrpPriSpcPriByBKG').click();
                    } else {
                        // มี BKG แล้วในระบบ
                        bootbox.alert({
                            title: aLocale['tWarning'],
                            message: aResult[1],
                            buttons: {
                                ok: {
                                    label: aLocale['tOK'],
                                    className: 'xCNBTNPrimery'
                                }
                            },
                            callback: function () {
                                $('.bootbox').modal('hide');
                            }
                        });
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
            return false;

        }
    });

}

function JSxBtnAddPKGPdtPriBooking() {

    $("#ofmAddPKGPdtPriBooking").validate({
        rules: {
            oetPpbDayFrm: "required",
            oetPpbDayTo: "required",
            ocmPpbSign: "required",
            ocmPpbAdjType: "required",
            oetPpbValue: "required",
        },
        errorClass: "input-invalid",
        validClass: "input-valid",
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        },
        submitHandler: function (form) {

            $.ajax({
                type: "POST",
                url: "EticketPackage_AddPkgPdtPriBKG",
                data: $("#ofmAddPKGPdtPriBooking").serialize(),
                cache: false,
                success: function (tResult) {

                    tResult = tResult.trim();
                    aResult = tResult.split(',');

                    if (aResult[0] == '1') {
                        $('#olaTabPdtPriSpcPriByBKG').click();
                    } else {
                        // มี BKG แล้วในระบบ
                        bootbox.alert({
                            title: aLocale['tWarning'],
                            message: aResult[1],
                            buttons: {
                                ok: {
                                    label: aLocale['tOK'],
                                    className: 'xCNBTNPrimery'
                                }
                            },
                            callback: function () {
                                $('.bootbox').modal('hide');
                            }
                        });
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
            return false;

        }
    });

}

function JSxPkgEditClickPpbPriBKGTR(nRowID) {

    if (localStorage.nRowIDGrpPriBKG != '') {
        if (localStorage.nRowIDGrpPriBKG != nRowID) {
            oldId = localStorage.nRowIDGrpPriBKG;
            $('#oetGpbValue' + oldId).val(localStorage.nGpbValue);
        }
    }

    if (nRowID != localStorage.nRowIDGrpPriBKG) {

        $('.xWoet').css('display', 'none');
        $('.xWGpbShow').css('display', 'block');

        $('.xWSaveBtn').css('display', 'none');
        $('.xWEditBtn').css('display', '');
    }

}

function JSxPkgDelPdtPriBKG(nPkgPdtID, nRowID) {

    nPdtDayFrm = $('#ospPdtDayFrm' + nRowID).text();
    nPdtDayTo = $('#ospPdtDayTo' + nRowID).text();

    $.ajax({
        type: "POST",
        url: "EticketPackage_DelPkgPdtPriBKG",
        data: {
            nPkgPdtID: nPkgPdtID,
            nPdtDayFrm: nPdtDayFrm,
            nPdtDayTo: nPdtDayTo
        },
        cache: false,
        success: function (tResult) {
            nResult = tResult.trim();
            // alert(nResult)
            if (nResult == '1') {
                $('#olaTabPdtPriSpcPriByBKG').click();
            } else {

            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxPkgDelPpbPriBKG(nPgpGrpID, nRowID) {

    nGpbDayFrm = $('#ospGpbDayFrm' + nRowID).text();
    nGpbDayTo = $('#ospGpbDayTo' + nRowID).text();

    $.ajax({
        type: "POST",
        url: "EticketPackage_DelPkgGrpPriBKG",
        data: {
            nPgpGrpID: nPgpGrpID,
            nGpbDayFrm: nGpbDayFrm,
            nGpbDayTo: nGpbDayTo
        },
        cache: false,
        success: function (tResult) {
            nResult = tResult.trim();
            // alert(nResult)
            if (nResult == '1') {
                $('#olaTabGrpPriSpcPriByBKG').click();
            } else {

            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxPkgEditPdtPriBKGBtn(nPkgPdtID, nRowID) {

    JSxPkgEditClickPdtPriBKGTR(nRowID);

    nHidePdtAdjType = $('#ohdPdtAdjType' + nRowID).val();

    setTimeout(function () {
        $('#ospPdtValue' + nRowID).css('display', 'none');
        $('#oetPdtValue' + nRowID).css('display', 'block');

        $('#ospPdtAdjType' + nRowID).css('display', 'none');
        $('#ocmEditPdtAdjType' + nRowID).parent().parent().css('display', 'block');

        $('.xWEdtPdtAdjType' + nHidePdtAdjType).attr('selected', 'selected');
        $('.xWEdtPdtAdjType' + nHidePdtAdjType).prop('selected', true);
        $('.selectpicker').selectpicker('refresh');

        $('#othEditPdtBtn' + nRowID).css('display', 'none');
        $('#othSavePdtBtn' + nRowID).css('display', '');


    }, 200);

    nPdtValue = $('#oetPdtValue' + nRowID).val();

    localStorage.nRowIDPdtPriBKG = nRowID;
    localStorage.nPdtValue = nPdtValue;

}

function JSxPkgEditClickPdtPriBKGTR(nRowID) {

    if (localStorage.nRowIDPdtPriBKG != '') {
        if (localStorage.nRowIDPdtPriBKG != nRowID) {
            oldId = localStorage.nRowIDPdtPriBKG;
            $('#oetPdtValue' + oldId).val(localStorage.nPdtValue);
        }
    }

    if (nRowID != localStorage.nRowIDPdtPriBKG) {

        $('.xWoet').css('display', 'none');
        $('.xWPdtShow').css('display', 'block');

        $('.xWSaveBtn').css('display', 'none');
        $('.xWEditBtn').css('display', '');
    }

}

function JSxPkgSavePdtPriBKG(nPkgPdtID, nRowID) {

    nPdtDayFrm = $('#ospPdtDayFrm' + nRowID).text();
    nPdtDayTo = $('#ospPdtDayTo' + nRowID).text();

    nPdtAdjType = $('#ocmEditPdtAdjType' + nRowID).val();
    nPdtValue = $('#oetPdtValue' + nRowID).val();

    if (nPdtAdjType == '') {
        $('#ocmEditPdtAdjType' + nRowID).addClass('input-invalid');
    } else if (nPdtValue == '' || nPdtValue == '0') {
        $('#oetPdtValue' + nRowID).addClass('input-invalid');
    } else {

        $.ajax({
            type: "POST",
            url: "EticketPackage_EditPkgPdtPriBKG",
            data: {
                nPkgPdtID: nPkgPdtID,
                nPdtDayFrm: nPdtDayFrm,
                nPdtDayTo: nPdtDayTo,
                nPdtAdjType: nPdtAdjType,
                nPdtValue: nPdtValue
            },
            cache: false,
            success: function (tResult) {

                nResult = tResult.trim();

                if (nResult == '1') {
                    $('#olaTabPdtPriSpcPriByBKG').click();
                }

            },
            error: function (data) {
                console.log(data);
            }
        });

    }

}

function JSxPkgSavePkgPriBKG(nPpkID, nRowID) {

    nPkgDayFrm = $('#ospPkgDayFrm' + nRowID).text();
    nPkgDayTo = $('#ospPkgDayTo' + nRowID).text();

    nPkgAdjType = $('#ocmEditPkgAdjType' + nRowID).val();
    nPkgValue = $('#oetPkgValue' + nRowID).val();

    if (nPkgAdjType == '') {
        $('#ocmEditPkgAdjType' + nRowID).addClass('input-invalid');
    } else if (nPkgValue == '' || nPkgValue == '0') {
        $('#oetPkgValue' + nRowID).addClass('input-invalid');
    } else {

        $.ajax({
            type: "POST",
            url: "EticketPackage_EditPkgPriBKG",
            data: {
                nPpkID: nPpkID,
                nPkgDayFrm: nPkgDayFrm,
                nPkgDayTo: nPkgDayTo,
                nPkgAdjType: nPkgAdjType,
                nPkgValue: nPkgValue
            },
            cache: false,
            success: function (tResult) {

                nResult = tResult.trim();

                if (nResult == '1') {
                    $('#olaTabPkgPriBooking').click();
                }

            },
            error: function (data) {
                console.log(data);
            }
        });

    }

}

function JSnPKGPriSpcPriByDOWFocusOut() {
    $('#olaTabPkgPriDOW').click();
}

function JSnPKGGrpPriSpcPriByDOWFocusOut() {
    $('#oliTabGrpPriSpcPriByDOW').click();
}

function JSnPKGPdtPriSpcPriByDOWFocusOut() {
    $('#olaTabPdtPriSpcPriByDOW').click();
}

function JSnPKGEditPkgPriByDOW(nPpkID, nPpdDayOfWeek) {

    cPpdPrice = $('#oetEditPkgPrice' + nPpdDayOfWeek).val();

    $.ajax({
        type: "POST",
        url: "EticketPackage_EditPkgPriSpcPriByDOW",
        data: {
            nPpkID: nPpkID,
            nPpdDayOfWeek: nPpdDayOfWeek,
            cPpdPrice: cPpdPrice
        },
        cache: false,
        success: function (tResult) {
            tResult = tResult.trim();
            aResult = tResult.split(',');
            // alert(nResult);
            if (aResult[0] == '1') {
                $('#olaTabPkgPriDOW').click();
            } else {
                bootbox.alert({
                    title: aLocale['tWarning'],
                    message: aResult[1],
                    buttons: {
                        ok: {
                            label: aLocale['tOK'],
                            className: 'xCNBTNPrimery'
                        }
                    },
                    callback: function () {
                        $('.bootbox').modal('hide');
                    }
                });
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSnPKGEditGrpPriSpcPriByDOW(nPgpGrpID, nGpdDayOfWeek) {

    cGpdPrice = $('#oetEditGpdPrice' + nGpdDayOfWeek).val();

    $.ajax({
        type: "POST",
        url: "EticketPackage_EditGrpPriSpcPriByDOW",
        data: {
            nPgpGrpID: nPgpGrpID,
            nGpdDayOfWeek: nGpdDayOfWeek,
            cGpdPrice: cGpdPrice
        },
        cache: false,
        success: function (tResult) {

            tResult = tResult.trim();
            aResult = tResult.split(',');
            // alert(nResult);
            if (aResult[0] == '1') {
                $('#oliTabGrpPriSpcPriByDOW').click();
            } else {
                bootbox.alert({
                    title: aLocale['tWarning'],
                    message: aResult[1],
                    buttons: {
                        ok: {
                            label: aLocale['tOK'],
                            className: 'xCNBTNPrimery'
                        }
                    },
                    callback: function () {
                        $('.bootbox').modal('hide');
                    }
                });
            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSnPKGEditPdtPriSpcPriByDOW(nPkgPdtID, nPpdDayOfWeek) {

    cPpdPrice = $('#oetEditPdtPrice' + nPpdDayOfWeek).val();

    $.ajax({
        type: "POST",
        url: "EticketPackage_EditPdtPriSpcPriByDOW",
        data: {
            nPkgPdtID: nPkgPdtID,
            nPpdDayOfWeek: nPpdDayOfWeek,
            cPpdPrice: cPpdPrice
        },
        cache: false,
        success: function (tResult) {

            tResult = tResult.trim();
            aResult = tResult.split(',');
            // alert(nResult);
            if (aResult[0] == '1') {
                $('#olaTabPdtPriSpcPriByDOW').click();
            } else {
                bootbox.alert({
                    title: aLocale['tWarning'],
                    message: aResult[1],
                    buttons: {
                        ok: {
                            label: aLocale['tOK'],
                            className: 'xCNBTNPrimery'
                        }
                    },
                    callback: function () {
                        $('.bootbox').modal('hide');
                    }
                });
            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxApprovePkg(nPkgID) {
    $.ajax({
        type: "POST",
        url: "EticketPackage_ApprovePkg",
        data: {
            nPkgID: nPkgID
        },
        cache: false,
        success: function (oResult) {
            oResult = oResult.trim();
            aResult = oResult.split(',');
            $nSttApv = aResult[0];
            $tMsgSttApv = aResult[1];
            if ($nSttApv == '1') {
                bootbox.alert({
                    title: aLocale['tWarning'],
                    message: $tMsgSttApv,
                    buttons: {
                        ok: {
                            label: aLocale['tOK'],
                            className: 'xCNBTNPrimery'
                        }
                    },
                    callback: function () {
                        $('.bootbox').modal('hide');
                    }
                });
                JSxCallPagePkgDetail(nPkgID);
            } else {
                bootbox.alert({
                    title: aLocale['tWarning'],
                    message: $tMsgSttApv,
                    buttons: {
                        ok: {
                            label: aLocale['tOK'],
                            className: 'xCNBTNPrimery'
                        }
                    },
                    callback: function () {
                        $('.bootbox').modal('hide');
                    }
                });
            }
        },
        error: function (data) {
            console.log(data);
        }
    });

}

function FSxEncodeBase64PkgEdit() {

    var filesSelected = document.getElementById("oflEditPkgImg").files;
    if (filesSelected.length > 0) {
        var fileToLoad = filesSelected[0];
        var fileReader = new FileReader();
        fileReader.onload = function (fileLoadedEvent) {
            var tContents = document.getElementById("ohdEditPkgImg");
            tContents.value = fileLoadedEvent.target.result;
            var tImages = document.getElementById("oimPkgImgShow");
            tImages.setAttribute('src', fileLoadedEvent.target.result);
        };
        fileReader.readAsDataURL(fileToLoad);
    }
}

function FSxDelImgPkg(nPkgID) {
    bootbox.confirm({
        title: 'ยืนยันการลบข้อมูล',
        message: 'Are you sure to delete this item?',
        buttons: {
            cancel: {
                label: aLocale['tBtnConfirm'],
                className: 'xCNBTNPrimery'
            },
            confirm: {
                label: aLocale['tBtnClose'],
                className: 'xCNBTNDefult'
            }
        },
        callback: function (result) {
            if (result == false) {
                $.ajax({
                    type: "POST",
                    url: "EticketPackage_DelImgPkg",
                    data: {
                        nPkgID: nPkgID
                    },
                    cache: false,
                    success: function (msg) {
                        $('#oimImgMasterMain').attr("src", "application/modules/common/assets/images/Noimage.png");
						$('#oDelImgPrk').hide();
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    });
}

function JSxPKGDelImg(nImgID, tImgObj, tMsg) {
    bootbox.confirm({
        title: 'ยืนยันการลบข้อมูล',
        message: 'Are you sure to delete this item?',
        buttons: {
            cancel: {
                label: '<i class="fa fa-times-circle" aria-hidden="true"></i> ' + aLocale['tBtnClose'],
                className: 'xCNBTNDefult'
            },
            confirm: {
                label: '<i class="fa fa-check-circle" aria-hidden="true"></i> ' + aLocale['tBtnConfirm'],
                className: 'xCNBTNPrimery'
            }
        },
        callback: function (result) {
            if (result == true) {
                $.ajax({
                    type: "POST",
                    url: "EticketDelImgPrk",
                    data: {
                        tImgID: nImgID,
                        tNameImg: tImgObj,
                        tImgType: 4
                    },
                    cache: false,
                    success: function (msg) {
                        $('#oimImgMasterMain').attr("src", "application/modules/common/assets/images/Noimage.png");
                        $('#oDelImgPrk').hide();
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }
    });
}

function FSxCallPagePdtPriSpcPriByDOW(nPkgID, nPkgPdtID) {
    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPagePdtPriSpcPriByDOWPanal",
        data: {
            nPkgID: nPkgID,
            nPkgPdtID: nPkgPdtID
        },
        cache: false,
        success: function (tResult) {

            $('#odvTabPdtPriSpcPriByDOWPanal').html(tResult);

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function FSxCallPagePdtPriSpcPriByHLD(nPkgID, nPkgPdtID) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPagePdtPriSpcPriByHLDPanal",
        data: {
            nPkgID: nPkgID,
            nPkgPdtID: nPkgPdtID
        },
        cache: false,
        success: function (tResult) {

            $('#odvTabSpcPriByHLDPanal').html(tResult)

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function FSxCallPagePdtPriSpcPriByBKG(nPkgID, nPkgPdtID) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPagePdtPriSpcPriByBKGPanal",
        data: {
            nPkgID: nPkgID,
            nPkgPdtID: nPkgPdtID
        },
        cache: false,
        success: function (tResult) {

            $('#odvTabSpcPriByBKGPanal').html(tResult);

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function FSxCallPageGrpPriSpcPriByDOW(nPkgID, nPgpGrpID) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPagePkgGrpPriSpcPriByDOWPanal",
        data: {
            nPkgID: nPkgID,
            nPgpGrpID: nPgpGrpID
        },
        cache: false,
        success: function (tResult) {

            $('#odvTabGrpPriSpcPriByDOWPanal').html(tResult);

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function FSxCallPageGrpPriSpcPriByHLD(nPkgID, nPgpGrpID) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPagePkgGrpPriSpcPriByHLDPanal",
        data: {
            nPkgID: nPkgID,
            nPgpGrpID: nPgpGrpID
        },
        cache: false,
        success: function (tResult) {

            $('#odvTabGrpPriSpcPriByHLDPanal').html(tResult);

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function FSxCallPageGrpPriSpcPriByBKG(nPkgID, nPgpGrpID) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPagePkgGrpPriSpcPriByBKGPanal",
        data: {
            nPkgID: nPkgID,
            nPgpGrpID: nPgpGrpID
        },
        cache: false,
        success: function (tResult) {

            $('#odvTabGrpPriSpcPriByBKGPanal').html(tResult);

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function FSxCallPagePkgPriByDOW(nPkgID, nPpkID) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPagePkgPriByDOWPanal",
        data: {
            nPkgID: nPkgID,
            nPpkID: nPpkID
        },
        cache: false,
        success: function (tResult) {

            $('#odvTabPkgPriDOWPanal').html(tResult);

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function FSxCallPagePkgPriByBKG(nPkgID, nPpkID) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPagePkgPriByBKGPanal",
        data: {
            nPkgID: nPkgID,
            nPpkID: nPpkID
        },
        cache: false,
        success: function (tResult) {

            $('#odvTabPkgPriBKGPanal').html(tResult);

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function JSxClickGotoTabHLD() {
    $('#olaTabGrpPriSpcPriByHLD').click();
}

function JSxClickGotoTabBKG() {
    $('#olaTabGrpPriSpcPriByBKG').click();
}

function JSxPkgCallPagePdtPriSpcPri(nPkgPdtID, tPdtName) {

    // alert(nPkgPdtID);

    nPkgID = $('#oetHidePckID').val();

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPagePdtPriSpcPri",
        data: {
            nPkgID: nPkgID,
            nPkgPdtID: nPkgPdtID
        },
        cache: false,
        success: function (tResult) {

            $('#odvPkgDetailPanal').html(tResult);

            $('#olaPdtNameHeader').text(tPdtName);

            $('#olaTabPdtPriSpcPriByDOW').click();

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function JSxPkgCallPageGrpPriSpcPri(nPgpGrpID, tGrpName, tZneName, nPpkID,
        nStaPage) {

    nPkgID = $('#oetHidePckID').val();

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPagePkgGrpPriSpcPri",
        data: {
            nPkgID: nPkgID,
            nPgpGrpID: nPgpGrpID,
            tGrpName: tGrpName,
            tZneName: tZneName,
            nPpkID: nPpkID,
            nStaPage: nStaPage
        },
        cache: false,
        success: function (tResult) {

            // alert(tResult)

            $('#odvPkgDetailPanal').html(tResult);

            // คลิก Tab ราคาตามสัปหาห์
            $('#oliTabGrpPriSpcPriByDOW').click();
            $('#oliTabGrpPriSpcPriByDOW').addClass('active');

        },
        error: function (data) {
            console.log(data);
        }
    });

}

// ราคาพิเศษ ตาม Zone
function JSxPkgCallPagePpkPriSpcPri(nPpkID, tZneName) {

    nPkgID = $('#oetHidePckID').val();

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPagePpkPriSpcPri",
        data: {
            nPkgID: nPkgID,
            nPpkID: nPpkID,
            tZneName: tZneName
        },
        cache: false,
        success: function (tResult) {

            // alert(tResult)
            $('#odvPkgDetailPanal').html(tResult);

            // คลิก Tab ราคาตามสัปหาห์
            $('#olaTabPkgPriDOW').click();

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function JSxPkgCallPagePdtGrpPri(nPkgPdtID, tPdtName) {

    nPkgID = $('#oetHidePckID').val();

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPagePdtGrpPri",
        data: {
            nPkgID: nPkgID,
            nPkgPdtID: nPkgPdtID,
            tPdtName: tPdtName
        },
        cache: false,
        success: function (tResult) {

            $('#odvPkgDetailPanal').html(tResult);

            $('#olaPdtNameHeader').text(tPdtName);

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function JSxCheckAddPkgModalZone() {

    nPkgLocID = $("#ocmPkgLocation").val();
    nPpkPrice = $("#oetEditPpkPrice").val();
    nPkgType = $("#ohdPkgType").val();
    nEvnID = $("#ohdPkgEvnID").val();
    
    if (nPkgLocID == '') {
        // ไม่มีข้อมูล Location
        // alert('ไม่มีข้อมูล Location');
        tMsgDontHaveLocation = $("#ohdMsgDontHaveLocation").val();
        bootbox.alert({
            title: aLocale['tWarning'],
            message: tMsgDontHaveLocation,
            buttons: {
                ok: {
                    label: aLocale['tOK'],
                    className: 'xCNBTNPrimery'
                }
            },
            callback: function () {
                $('.bootbox').modal('hide');
            }
        });
    } else {
        
        nPkgID = $("#oetHidePckID").val();
        nPmoID = $("#oetHidePmoID").val();
        var nZneID = []
        var aZnePriID = []
        var nCheckPriNull = ''
        $("input[name='ordZone[]']:checked").each(function () {
            nZneID.push($(this).val());

            aZnePriID.push($('#oetZonePri' + $(this).val()).val());

            aZnePri = $('#oetZonePri' + $(this).val()).val();

            if (aZnePri == '' && nPkgType == 2) {
                nCheckPriNull = 1;
                $('#oetZonePri' + $(this).val()).focus();
            }
        });

        if (nZneID == '' || nPkgLocID == '' || nPkgID == '' || nPmoID == '') {
            // ข้อมูลไม่ครบกรุณาเลือกโซน
            // alert('ข้อมูลไม่ครบกรุณาเลือก Zone');
            tMsgPlsSelectZone = $("#ohdMsgPlsSelectZone").val();

            bootbox.alert({
                title: aLocale['tWarning'],
                message: tMsgPlsSelectZone,
                buttons: {
                    ok: {
                        label: aLocale['tOK'],
                        className: 'xCNBTNPrimery'
                    }
                },
                callback: function () {
                    $('.bootbox').modal('hide');
                }
            });
        } else if (nPkgType == '2' && nCheckPriNull == 1) {
            // alert('กรุณากรอก ราคา');
            tMsgPlsEnterPrice = $("#ohdMsgPlsEnterPrice").val();
            bootbox.alert({
                title: aLocale['tWarning'],
                message: tMsgPlsEnterPrice,
                buttons: {
                    ok: {
                        label: aLocale['tOK'],
                        className: 'xCNBTNPrimery'
                    }
                },
                callback: function () {
                    $('.bootbox').modal('hide');
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: "EticketPackage_CheckPkgModelZoneMore2",
                data: {
                    nZneID: nZneID,
                    nPkgLocID: nPkgLocID,
                    nPkgID: nPkgID,
                    nPmoID: nPmoID,
                    aZnePriID: aZnePriID
                },
                cache: false,
                success: function (tResult) {
                    
                    tResult = tResult.trim();
                    aResult = tResult.split(',');

                    // Insert ได้
                    if (tResult == 1) {
                        if (nEvnID != '') {
                            JSxCheckHaveLocShowTime(nZneID, nPkgLocID, nPkgID,
                                    nPmoID, aZnePriID);
                        } else {
                            $('.close').click();
                            JSxCheckAddPkgModalZoneStep2(nZneID, nPkgLocID,
                                    nPkgID, nPmoID, aZnePriID);
                        }

                    } else if (tResult == 0) {
                        // BookimgType ไม่ตรงกันจะไม่สามารถ Insert ได้
                        // alert('กรุณาเลือก Zone ที่มี BookingType เหมือนกัน');
                        tMsgPlsSelZneSameTypePrevious = $("#ohdMsgPlsSelZneSameTypePrevious").val();
                        bootbox.alert({
                            title: aLocale['tWarning'],
                            message: tMsgPlsSelZneSameTypePrevious,
                            buttons: {
                                ok: {
                                    label: aLocale['tOK'],
                                    className: 'xCNBTNPrimery'
                                }
                            },
                            callback: function () {
                                $('.bootbox').modal('hide');
                            }
                        });

                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    }

}

function JSxCheckAddPkgModalZoneStep2(nZneID, nPkgLocID, nPkgID, nPmoID, aZnePriID) {    
    var nBookingType = $('.xWSelcectordZone:checked').data('zonetype');
    $.ajax({
        type: "POST",
        url: "EticketPackage_AddPkgModelZoneStep2",
        data: {
            nZneID: nZneID,
            nPkgLocID: nPkgLocID,
            nPkgID: nPkgID,
            nPmoID: nPmoID,
            aZnePriID: aZnePriID,
            nBookingType: nBookingType
        },
        cache: false,
        success: function (tResult) {
            tResult = tResult.trim();
            aResult = tResult.split(',');
            // ถ้าว่าง Add ได้ แล้วส่งไป Check Showtime ต่อ
            if (tResult == '') {
                $('.close').click();
                $('#olaTabPkgModel').click();
            }
            if (aResult[0] == '0') {
                // 0 ไม่สามารถ Insert ได้ จะแจ้งเตือน User ให้ไปลบ
                setTimeout(function () {
                    var txt;
                    var r = confirm(aResult[1]);
                    if (r == true) {
                        // $('.close').click();
                        // $('#olaTabPkgModel').click();
                    } else {
                        // $('#olaTabPkgModel').click();
                    }
                }, 500);
            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxCheckHaveLocShowTime(nZneID, nPkgLocID, nPkgID, nPmoID, nPpkPrice) {

    nEvnID = $("#ohdPkgEvnID").val();

    $.ajax({
        type: "POST",
        url: "EticketPackage_CheckLocHaveShowTime",
        data: {
            nPkgLocID: nPkgLocID,
            nEvnID: nEvnID
        },
        cache: false,
        success: function (tResult) {

            tResult = tResult.trim();
            aResult = tResult.split(',');
            // alert(tResult)

            if (aResult[0] == '0') {
                bootbox.alert({
                    title: aLocale['tWarning'],
                    message: aResult[1],
                    buttons: {
                        ok: {
                            label: aLocale['tOK'],
                            className: 'xCNBTNPrimery'
                        }
                    },
                    callback: function () {
                        $('.bootbox').modal('hide');
                    }
                });
                $('#olaTabPkgShowTime').click();
                // $('.xWBtnAddPkgModel').attr('onclick','JSxCheckHaveLocShowTime('+nZneID+','+nPkgLocID+')')
            } else {

                JSxCheckAddPkgModalZoneStep2(nZneID, nPkgLocID, nPkgID, nPmoID,
                        nPpkPrice);
                // $('#olaTabPkgModel').click();
                // $('.close').click();
                // ส่งไป Add
                // JSxAddPkgModalZone(nZneID, nPkgLocID, nPkgID,
                // nPmoID,nPpkPrice);
            }

        },
        error: function (data) {
            console.log(data);
        }
    });

    // JSxAddPkgModalZone(nZneID, nPkgLocID, nPkgID, nPmoID,nPpkPrice);

}

// function JSxAddPkgModalZone(nZneID, nPkgLocID, nPkgID, nPmoID,nPpkPrice){
//
// $.ajax({
// type : "POST",
// url : "Package_AddPkgModelZone",
// data : {
// nZneID : nZneID,
// nPkgLocID : nPkgLocID,
// nPkgID : nPkgID,
// nPmoID : nPmoID,
// nPpkPrice : nPpkPrice
// },
// cache : false,
// success : function(tResult) {
//
// nResult = tResult.trim();
//			
// if (nResult == '1') {
// $('.close').click();
// alert('บันทึกสำเร็จ')
// $('#oliTabPkgModel').click();
// } else {
// alert('มีอยู่ในระบบแล้ว')
// }
//
// },
// error : function(data) {
// console.log(data);
// }
// });
// }

function JSxBtnAddPkgModelProduct() {

    $("#ofmAddPackageProduct").validate({
        rules: {
            ocmPkgTchGroup: "required",
            ocmPkgProduct: "required",
            oetPkgPdtPrice: "required",
            oetPdtMaxPerson: "required",
        },
        errorClass: "input-invalid",
        validClass: "input-valid",
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        },
        submitHandler: function (form) {

            nPkgID = $('#oetHidePkgID').val();
            nTchGroupID = $('#ocmPkgTchGroup').val();
            nPkgPdtID = $('#ocmPkgProduct').val();
            nPkgPdtPrice = $('#oetPkgPdtPrice').val();
            nPdtMaxPerson = $('#oetPdtMaxPerson').val();

            $.ajax({
                type: "POST",
                url: "EticketPackage_AddPkgModelProduct",
                data: {
                    nPkgID: nPkgID,
                    nTchGroupID: nTchGroupID,
                    nPkgPdtID: nPkgPdtID,
                    nPkgPdtPrice: nPkgPdtPrice,
                    nPdtMaxPerson: nPdtMaxPerson
                },
                cache: false,
                success: function (tResult) {
                    tResult = tResult.trim();
                    aResult = tResult.split(',');
                    // alert(nResult)
                    if (aResult[0] == '1') {
                        $('#oliTabPkgProduct').click();
                    } else {
                        bootbox.alert({
                            title: aLocale['tWarning'],
                            message: aResult[1],
                            buttons: {
                                ok: {
                                    label: aLocale['tOK'],
                                    className: 'xCNBTNPrimery'
                                }
                            },
                            callback: function () {
                                $('.bootbox').modal('hide');
                            }
                        });
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
            return false;
        }
    });

}

function JSxBtnAddPkgSpcGrpPri() {

    $("#ofmAddPackagePkgSpcGrpPri").validate({
        rules: {
            ocmPkgGrpPriType: "required",
            ocmPkgGrpPriTypeList: "required",
            oetPgpPdtPrice: "required",

        },
        errorClass: "input-invalid",
        validClass: "input-valid",
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        },
        submitHandler: function (form) {
            nPkgID = $('#oetHidePkgID').val();
            nPpkID = $('#oetHidePpkID').val();
            nPkgGrpPriType = $('#ocmPkgGrpPriType').val();
            nPkgGrpPriTypeList = $('#ocmPkgGrpPriTypeList').val();
            nPkgPgpPdtPrice = $('#oetPgpPdtPrice').val();

            tZneName = $('#olaZneName').text();

            // alert(nPpkID+" "+nPkgGrpPriType+" "+nPkgGrpPriTypeList+"
            // "+nPkgPgpPdtPrice)
            $.ajax({
                type: "POST",
                url: "EticketPackage_AddPkgGrpPri",
                data: {
                    nPpkID: nPpkID,
                    nPkgGrpPriType: nPkgGrpPriType,
                    nPkgGrpPriTypeList: nPkgGrpPriTypeList,
                    nPkgPgpPdtPrice: nPkgPgpPdtPrice
                },
                cache: false,
                success: function (tResult) {

                    tResult = tResult.trim();
                    aResult = tResult.split(',');

                    if (aResult[0] == '1') {
                        // $('#oliTabPkgSpcPriByGrp').click();
                        JSxCallPagePkgSpcPriByGrp(nPkgID, nPpkID, tZneName);
                    } else {
                        // alert('มีกลุ่มอยู่แล้ว');
                        bootbox.alert({
                            title: aLocale['tWarning'],
                            message: aResult[1],
                            buttons: {
                                ok: {
                                    label: aLocale['tOK'],
                                    className: 'xCNBTNPrimery'
                                }
                            },
                            callback: function () {
                                $('.bootbox').modal('hide');
                            }
                        });
                    }

                },
                error: function (data) {
                    console.log(data);
                }
            });
            return false;
        }
    });

}

function JSxBtnAddPkgPdtGrpPri() {

    $("#ofmAddPackagePdtGrpPri").validate({
        rules: {
            ocmPkgGrpPriType: "required",
            ocmPkgGrpPriTypeList: "required",
            oetPgpPdtPrice: "required",

        },
        errorClass: "input-invalid",
        validClass: "input-valid",
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        },
        submitHandler: function (form) {

            nPkgID = $('#oetHidePkgID').val();
            nPkgGrpPriType = $('#ocmPkgGrpPriType').val();
            nPkgGrpPriTypeList = $('#ocmPkgGrpPriTypeList').val();
            nPkgPgpPdtPrice = $('#oetPgpPdtPrice').val();
            nPkgPdtID = $('#oetHidePkgPdtID').val();

            tPdtName = $('#olaPdtNameHeader').text();

            $.ajax({
                type: "POST",
                url: "EticketPackage_AddPkgPdtGrpPri",
                data: {
                    nPkgID: nPkgID,
                    nPkgGrpPriType: nPkgGrpPriType,
                    nPkgGrpPriTypeList: nPkgGrpPriTypeList,
                    nPkgPgpPdtPrice: nPkgPgpPdtPrice,
                    nPkgPdtID: nPkgPdtID

                },
                cache: false,
                success: function (tResult) {

                    tResult = tResult.trim();
                    aResult = tResult.split(',');

                    if (aResult[0] == '1') {
                        JSxPkgCallPagePdtGrpPri(nPkgPdtID, tPdtName);
                    } else {
                        // alert('มีกลุ่มอยู่แล้ว');    
                        bootbox.alert({
                            title: aLocale['tWarning'],
                            message: aResult[1],
                            buttons: {
                                ok: {
                                    label: aLocale['tOK'],
                                    className: 'xCNBTNPrimery'
                                }
                            },
                            callback: function () {
                                $('.bootbox').modal('hide');
                            }
                        });
                    }

                },
                error: function (data) {
                    console.log(data);
                }
            });
            return false;
        }
    });

}

function JSxPkgCstGetTchGrpByPmoHTML(nPmoID, nPkgID) {
    $.ajax({
        type: "POST",
        url: "EticketPackage_GetSelectTchGrpByPmoHTML",
        data: {
            nPmoID: nPmoID,
            nPkgID: nPkgID
        },
        cache: false,
        success: function (tResult) {
            console.log(tResult);

            $('#ocmPkgTchGroup').html(tResult);
            $('#ocmPkgTchGroup').selectpicker('refresh');

            // Controll Icon Loading
            $('.xWLoading').css('display', 'none');
            $('#ocmPkgTchGroup').attr('disabled', false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxPkgCstGetSelectPdtHTML(nTchID, nPkgID) {
    // Controll Icon Loading
    $('.xWLoading').css('display', 'block');
    $('#ocmPkgTchGroup').attr('disabled', true);
    $.ajax({
        type: "POST",
        url: "EticketPackage_GetSelectPdtHTML",
        data: {
            nTchID: nTchID,
            nPkgID: nPkgID
        },
        cache: false,
        success: function (tResult) {
            $('#ocmPkgProduct').html(tResult);
            $('#ocmPkgProduct').selectpicker('refresh');
            // Controll Icon Loading
            $('.xWLoading').css('display', 'none');
            $('#ocmPkgTchGroup').attr('disabled', false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JStPkgGetSelectPkgGrpPriHTML(nPgpType) {

    // Controll Icon Loading
    $('.xWLoading').css('display', 'block');
    $('#ocmPkgGrpPriType').attr('disabled', true);

    $.ajax({
        type: "POST",
        url: "EticketPackage_GetSelectPkgGrpPriHTML",
        data: {
            nPgpType: nPgpType
        },
        cache: false,
        success: function (tResult) {
            $('#ocmPkgGrpPriTypeList').html(tResult);
            // Controll Icon Loading
            $('.xWLoading').css('display', 'none');
            $('#ocmPkgGrpPriType').attr('disabled', false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function JSxPkgCstGetSelectModelHTML(nPvnID) {

    // Controll Icon Loading
    $('.xWLoading').css('display', 'block');
    $('#ocmPkgProvince').attr('disabled', true);

    $.ajax({
        type: "POST",
        url: "EticketPackage_GetSelectModelHTML",
        data: {
            nPvnID: nPvnID
        },
        cache: false,
        success: function (tResult) {
            
            $('#ocmPkgPmoID').html(tResult);
            $('#ocmPkgPmoID').selectpicker('refresh');
            
            // Controll Icon Loading
            $('.xWLoading').css('display', 'none');
            $('#ocmPkgProvince').attr('disabled', false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function JSxPkgDelModelCustomer(nPpkID, nPkgID) {
    $.ajax({
        type: "POST",
        url: "EticketPackage_DelPkgModelCustomer",
        data: {
            nPpkID: nPpkID,
            nPkgID: nPkgID
        },
        cache: false,
        success: function (tResult) {
            console.log(tResult);
            $('#oliTabPkgModel').click();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

// ลบ สาขา Model ใน PkgModel
function JSxPkgDelModelAdmin(nPkgID, nPmoID) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_DelPkgModelAdmin",
        data: {
            nPkgID: nPkgID,
            nPmoID: nPmoID
        },
        cache: false,
        success: function (tResult) {

            tResult = tResult.trim();
            aResult = tResult.split(',');

            if (aResult[0] == '1') {
                $('#oliTabPkgModel').click();
            } else {
                bootbox.alert({
                    title: aLocale['tWarning'],
                    message: aResult[1],
                    buttons: {
                        ok: {
                            label: aLocale['tOK'],
                            className: 'xCNBTNPrimery'
                        }
                    },
                    callback: function () {
                        $('.bootbox').modal('hide');
                    }
                });
            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}

// ลบ สินค้าในแพ็คเกจ
function JSxPkgDelPkgProduct(nPkgPdtID) {

    nPkgID = $('#oetHidePckID').val();

    $.ajax({
        type: "POST",
        url: "EticketPackage_DelPkgProduct",
        data: {
            nPkgPdtID: nPkgPdtID,
            nPkgID: nPkgID
        },
        cache: false,
        success: function (tResult) {
            tResult = tResult.trim();
            aResult = tResult.split(',');
            // alert(nResult)
            if (aResult[0] == '1') {
                $('#oliTabPkgProduct').click();
            } else {
                // alert('สินค้าใน Package ต้องมีอย่างน้อย 1 ชิ้น');
                bootbox.alert({
                    title: aLocale['tWarning'],
                    message: aResult[1],
                    buttons: {
                        ok: {
                            label: aLocale['tOK'],
                            className: 'xCNBTNPrimery'
                        }
                    },
                    callback: function () {
                        $('.bootbox').modal('hide');
                    }
                });
            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}

// ลบ กลุ่มพิเศษในแพ็คเกจ
function JSxPkgDelPkgSpcPriByGrp(nPgpGrpID) {

    nPkgID = $('#oetHidePkgID').val();
    tPpkID = $('#oetHidePpkID').val();
    tZneName = $('#olaZneName').text();

    $.ajax({
        type: "POST",
        url: "EticketPackage_DelPkgSpcGrpPri",
        data: {
            nPgpGrpID: nPgpGrpID,
            nPkgID: nPkgID
        },
        cache: false,
        success: function (tResult) {

            nResult = tResult.trim();
            // alert(nResult)
            if (nResult == '1') {
                JSxCallPagePkgSpcPriByGrp(nPkgID, tPpkID, tZneName);
                // $('#oliTabPkgSpcPriByGrp').click();
            } else {
                // alert('สินค้าใน Package ต้องมีอย่างน้อย 1 ชิ้น');
            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}

// ลบ กลุ่มพิเศษของสินค้าในแพ็คเกจ
function JSxPkgDelPkgPdtPriByGrp(nPgpGrpID) {

    nPkgID = $('#oetHidePckID').val();

    $.ajax({
        type: "POST",
        url: "EticketPackage_DelPkgPdtGrpPri",
        data: {
            nPgpGrpID: nPgpGrpID,
            nPkgID: nPkgID
        },
        cache: false,
        success: function (tResult) {

            tResult = tResult.trim();
            aResult = tResult.split(',');

            if (aResult[0] == '1') {
                tPdtName = $('#olaPdtNameHeader').text();
                nPkgPdtID = $('#oetHidePkgPdtID').val();
                JSxPkgCallPagePdtGrpPri(nPkgPdtID, tPdtName);
            } else {
                // alert('ไม่สามารถลบ กลุ่มของสินค้าในแพ็คเกจได้');                
                bootbox.alert({
                    title: aLocale['tWarning'],
                    message: aResult[1],
                    buttons: {
                        ok: {
                            label: aLocale['tOK'],
                            className: 'xCNBTNPrimery'
                        }
                    },
                    callback: function () {
                        $('.bootbox').modal('hide');
                    }
                });
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxPkgEditPdtBtn(nPkgPdtID, nRowID) {

    JSxPkgEditClickTR(nRowID);

    setTimeout(function () {

        $('#ospPdtMaxPerson' + nRowID).css('display', 'none');
        $('#ospPdtPdtPrice' + nRowID).css('display', 'none');

        $('#oetEditPdtMaxPerson' + nRowID).css('display', 'block');
        $('#oetEditPdtPdtPrice' + nRowID).css('display', 'block');

        $('#othEditPdtBtn' + nPkgPdtID).css('display', 'none');
        $('#othSavePdtBtn' + nPkgPdtID).css('display', '');

        $('#oetEditPdtMaxPerson' + nRowID).attr('disabled', false);
        $('#oetEditPdtPdtPrice' + nRowID).attr('disabled', false);

    }, 200);

    nMaxPerson = $('#oetEditPdtMaxPerson' + nRowID).val();
    nPdtPrice = $('#oetEditPdtPdtPrice' + nRowID).val();

    localStorage.nRowID = nRowID;
    localStorage.nMaxPerson = nMaxPerson;
    localStorage.nPdtPrice = nPdtPrice;

}

// แก้ไข กลุ่มในราคาพิเศษตามกลุ่มแพ็คเกจ
function JSxPkgEditPkgSpcPriByGrp(nPgpGrpID, nRowID) {

    nPgpPdtPrice = $('#oetEditPgpPdtPrice' + nRowID).val();

    $.ajax({
        type: "POST",
        url: "EticketPackage_EditPkgSpcGrpPri",
        data: {
            nPgpGrpID: nPgpGrpID,
            nPgpPdtPrice: nPgpPdtPrice
        },
        cache: false,
        success: function (tResult) {

            tResult = tResult.trim();
            aResult = tResult.split(',');
            // alert(nResult)
            if (aResult[0] == '1') {
                localStorage.SpcPriByGrpnRowID = '';
                $('#ospRefreshPagePkgGrpPri').click();
                // $('#oliTabPkgSpcPriByGrp').click();
            } else {
                bootbox.alert({
                    title: aLocale['tWarning'],
                    message: aResult[1],
                    buttons: {
                        ok: {
                            label: aLocale['tOK'],
                            className: 'xCNBTNPrimery'
                        }
                    },
                    callback: function () {
                        $('.bootbox').modal('hide');
                    }
                });
            }

        },
        error: function (data) {
            console.log(data);
        }
    });

}

// แก้ไข กลุ่มในราคาพิเศษตามกลุ่มแพ็คเกจ
function JSxPkgEditPkgPdtPriByGrp(nPgpGrpID, nRowID) {

    nPgpPdtPrice = $('#oetEditPgpPdtPrice' + nRowID).val();

    $.ajax({
        type: "POST",
        url: "EticketPackage_EditPkgSpcGrpPri",
        data: {
            nPgpGrpID: nPgpGrpID,
            nPgpPdtPrice: nPgpPdtPrice
        },
        cache: false,
        success: function (tResult) {

            tResult = tResult.trim();
            aResult = tResult.split(',');
            // alert(nResult)
            if (aResult[0] == '1') {
                localStorage.PdtPriByGrpnRowID = '';

                tPdtName = $('#olaPdtNameHeader').text();
                nPkgPdtID = $('#oetHidePkgPdtID').val();
                JSxPkgCallPagePdtGrpPri(nPkgPdtID, tPdtName);
            } else {
                bootbox.alert({
                    title: aLocale['tWarning'],
                    message: aResult[1],
                    buttons: {
                        ok: {
                            label: aLocale['tOK'],
                            className: 'xCNBTNPrimery'
                        }
                    },
                    callback: function () {
                        $('.bootbox').modal('hide');
                    }
                });
            }

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function JSxPkgEditSpcPriByGrpBtn(nFNPgpGrpID, nRowID) {

    JSxPkgClickAthROWSpcPriByGrp(nRowID);

    setTimeout(function () {

        $('#ospEditPgpPdtPrice' + nRowID).css('display', 'none');
        $('#oetEditPgpPdtPrice' + nRowID).css('display', 'block');

        $('#othEditSpcPriByGrpBtn' + nFNPgpGrpID).css('display', 'none');
        $('#othSaveSpcPriByGrpBtn' + nFNPgpGrpID).css('display', 'block');

        $('#oetEditPgpPdtPrice' + nRowID).attr('disabled', false);
    }, 200);

    nPgpPdtPrice = $('#oetEditPgpPdtPrice' + nRowID).val();

    localStorage.SpcPriByGrpnRowID = nRowID;
    localStorage.nPgpPdtPrice = nPgpPdtPrice;

}

function JSxPkgEditPdtPriByGrpBtn(nFNPgpGrpID, nRowID) {

    JSxPkgClickAthROWPdtPriByGrp(nRowID);

    setTimeout(function () {
        $('#othEditPdtPriByGrpBtn' + nFNPgpGrpID).css('display', 'none');
        $('#othSavePdtPriByGrpBtn' + nFNPgpGrpID).css('display', 'block');

        $('#ospEditPgpPdtPrice' + nRowID).css('display', 'none');
        $('#oetEditPgpPdtPrice' + nRowID).css('display', 'block');

        $('#oetEditPgpPdtPrice' + nRowID).attr('disabled', false);
    }, 200);

    nPgpPdtPrice = $('#oetEditPgpPdtPrice' + nRowID).val();

    localStorage.PdtPriByGrpnRowID = nRowID;
    localStorage.nPgpPdtPrice = nPgpPdtPrice;

}

function JSxPkgEditClickTR(nRowID) {

    if (localStorage.nRowID != '') {
        if (localStorage.nRowID != nRowID) {
            oldId = localStorage.nRowID;
            $('#oetEditPdtMaxPerson' + oldId).val(localStorage.nMaxPerson);
            $('#oetEditPdtPdtPrice' + oldId).val(localStorage.nPdtPrice);
        }
    }

    if (nRowID != localStorage.nRowID) {

        $('.xWoet').attr('disabled', true);
        $('.xWoet').attr('disabled', true);

        $('.xWPdtMaxPerson').css('display', 'block');
        $('.xWPdtPdtPrice').css('display', 'block');

        $('.xWoet').css('display', 'none');

        $('.xWSaveBtn').css('display', 'none');
        $('.xWEditBtn').css('display', '');
    }

    nPdtMaxPerson = $('#oetEditPdtMaxPerson' + nRowID).val();
    nPdtPdtPrice = $('#oetEditPdtPdtPrice' + nRowID).val();

    // alert(nPdtMaxPerson+" "+nPdtPdtPrice);

}

function JSxPkgClickAthROWSpcPriByGrp(nRowID) {

    if (localStorage.SpcPriByGrpnRowID != '') {
        if (localStorage.SpcPriByGrpnRowID != nRowID) {
            oldId = localStorage.SpcPriByGrpnRowID;
            $('#oetEditPgpPdtPrice' + oldId).val(localStorage.nPgpPdtPrice);
        }
    }

    if (nRowID != localStorage.SpcPriByGrpnRowID) {
        $('.xWoet').attr('disabled', true);
        $('.xWoet').attr('disabled', true);

        $('.xWoet').css('display', 'none');
        $('.xWEditPgpPdtPrice').css('display', 'block');

        $('.xWSaveBtn').css('display', 'none');
        $('.xWEditBtn').css('display', '');
    }

}

function JSxPkgClickAthROWPdtPriByGrp(nRowID) {

    if (localStorage.PdtPriByGrpnRowID != '') {
        if (localStorage.PdtPriByGrpnRowID != nRowID) {
            oldId = localStorage.PdtPriByGrpnRowID;
            $('#oetGpbValue' + oldId).val(localStorage.nPgpPdtPrice);
        }
    }

    if (nRowID != localStorage.PdtPriByGrpnRowID) {
        $('.xWoet').attr('disabled', true);
        $('.xWoet').attr('disabled', true);

        $('.xWoet').css('display', 'none');
        $('.xWEditPgpPdtPrice').css('display', 'block');

        $('.xWSaveBtn').css('display', 'none');
        $('.xWEditBtn').css('display', '');
    }

}

// ////////////////////////////////////////////////////
// ////////////////////////////////////////////////////

function JSxPkgEditPkgPriBKGBtn(nPpkID, nRowID) {

    JSxPkgEditClickPkgPriBKGTR(nRowID);

    nHidePkgAdjType = $('#ohdPkgAdjType' + nRowID).val();

    setTimeout(function () {
        $('#ospPkgValue' + nRowID).css('display', 'none');
        $('#oetPkgValue' + nRowID).css('display', 'block');

        $('#ospPkgAdjType' + nRowID).css('display', 'none');
        $('#ocmEditPkgAdjType' + nRowID).parent().parent().css('display', 'block');

        $('.xWEdtPkgAdjType' + nHidePkgAdjType).attr('selected', 'selected');
        $('.xWEdtPkgAdjType' + nHidePkgAdjType).prop('selected', true);
        $('.selectpicker').selectpicker('refresh');

        $('#othEditPkgBtn' + nRowID).css('display', 'none');
        $('#othSavePkgBtn' + nRowID).css('display', '');
    }, 200);

    nPkgValue = $('#oetPkgValue' + nRowID).val();

    localStorage.nRowIDPkgPriBKG = nRowID;
    localStorage.nPkgValue = nPkgValue;

}


function JSxPkgEditClickPkgPriBKGTR(nRowID) {

    if (localStorage.nRowIDPkgPriBKG != '') {
        if (localStorage.nRowIDPkgPriBKG != nRowID) {
            oldId = localStorage.nRowIDPkgPriBKG;
            $('#oetPkgValue' + oldId).val(localStorage.nPkgValue);
        }
    }

    if (nRowID != localStorage.nRowIDPkgPriBKG) {

        $('.xWoet').css('display', 'none');
        $('.xWPkgShow').css('display', 'block');

        $('.xWSaveBtn').css('display', 'none');
        $('.xWEditBtn').css('display', '');
    }

}
// ////////////////////////////////////////////////////
// ////////////////////////////////////////////////////

function JSxPkgEditGrpPriBKGBtn(nPgpGrpID, nRowID) {

    JSxPkgEditClickGrpPriBKGTR(nRowID);

    nHideGpbAdjType = $('#ohdGpbAdjType' + nRowID).val();
    
    setTimeout(function () {
        $('#ospGpbValue' + nRowID).css('display', 'none');
        $('#oetGpbValue' + nRowID).css('display', 'block');

        $('#ospGpbAdjType' + nRowID).css('display', 'none');
        $('#ocmEditGpbAdjType' + nRowID).parent().parent().css('display', 'block');

        $('.xWEdtGpbAdjType' + nHideGpbAdjType).attr('selected', 'selected');
        $('.xWEdtGpbAdjType' + nHideGpbAdjType).prop('selected', true);
        $('.selectpicker').selectpicker('refresh');

        $('#othEditPdtBtn' + nRowID).css('display', 'none');
        $('#othSavePdtBtn' + nRowID).css('display', '');
    }, 200);

    nGpbValue = $('#oetGpbValue' + nRowID).val();

    localStorage.nRowIDGrpPriBKG = nRowID;
    localStorage.nGpbValue = nGpbValue;

}

function JSxPkgEditClickGrpPriBKGTR(nRowID) {

    if (localStorage.nRowIDGrpPriBKG != '') {
        if (localStorage.nRowIDGrpPriBKG != nRowID) {
            oldId = localStorage.nRowIDGrpPriBKG;
            $('#oetGpbValue' + oldId).val(localStorage.nGpbValue);
        }
    }

    if (nRowID != localStorage.nRowIDGrpPriBKG) {

        $('.xWoet').css('display', 'none');
        $('.xWGpbShow').css('display', 'block');

        $('.xWSaveBtn').css('display', 'none');
        $('.xWEditBtn').css('display', '');
    }

}

// แก้ไข BKG
function JSxPkgSaveGrpPriBKG(nPgpGrpID, nRowID) {

    nGpbDayFrm = $('#ospGpbDayFrm' + nRowID).text();
    nGpbDayTo = $('#ospGpbDayTo' + nRowID).text();

    nGpbAdjType = $('#ocmEditGpbAdjType' + nRowID).val();
    nGpbValue = $('#oetGpbValue' + nRowID).val();

    if (nGpbAdjType == '') {
        $('#ocmEditGpbAdjType' + nRowID).addClass('input-invalid');
    } else if (nGpbValue == '' || nGpbValue == '0') {
        $('#oetGpbValue' + nRowID).addClass('input-invalid');
    } else {

        $.ajax({
            type: "POST",
            url: "EticketPackage_EditPkgGrpPriBKG",
            data: {
                nPgpGrpID: nPgpGrpID,
                nGpbDayFrm: nGpbDayFrm,
                nGpbDayTo: nGpbDayTo,
                nGpbAdjType: nGpbAdjType,
                nGpbValue: nGpbValue
            },
            cache: false,
            success: function (tResult) {

                nResult = tResult.trim();

                if (nResult == '1') {
                    $('#olaTabGrpPriSpcPriByBKG').click();
                }

            },
            error: function (data) {
                console.log(data);
            }
        });

    }

}

function JSxPkgDelPpkPriBKG(nPpkID, nPpbDayFrm, nPpbDayTo) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_DelPkgPriBKG",
        data: {
            nPpkID: nPpkID,
            nPpbDayFrm: nPpbDayFrm,
            nPpbDayTo: nPpbDayTo
        },
        cache: false,
        success: function (tResult) {
            tResult = tResult.trim();
            aResult = tResult.split(',');
            bootbox.alert({
                title: aLocale['tWarning'],
                message: aResult[1],
                buttons: {
                    ok: {
                        label: aLocale['tOK'],
                        className: 'xCNBTNPrimery'
                    }
                },
                callback: function () {
                    $('.bootbox').modal('hide');
                }
            });
            $('#olaTabPkgPriBooking').click();

        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxPkgDelGrpPriBKG(nPgpGrpID, nRowID) {

    nGpbDayFrm = $('#ospGpbDayFrm' + nRowID).text();
    nGpbDayTo = $('#ospGpbDayTo' + nRowID).text();

    $.ajax({
        type: "POST",
        url: "EticketPackage_DelPkgGrpPriBKG",
        data: {
            nPgpGrpID: nPgpGrpID,
            nGpbDayFrm: nGpbDayFrm,
            nGpbDayTo: nGpbDayTo
        },
        cache: false,
        success: function (tResult) {
            nResult = tResult.trim();
            // alert(nResult)
            if (nResult == '1') {
                $('#olaTabGrpPriSpcPriByBKG').click();
            } else {

            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}

// แก้ไข สินค้าในแพ็คเกจ
function JSxPkgEditPkgProduct(nPkgPdtID, nRowID) {

    nPdtMaxPerson = $('#oetEditPdtMaxPerson' + nRowID).val();
    nPdtPdtPrice = $('#oetEditPdtPdtPrice' + nRowID).val();

    $.ajax({
        type: "POST",
        url: "EticketPackage_EditPkgProduct",
        data: {
            nPkgPdtID: nPkgPdtID,
            nPdtMaxPerson: nPdtMaxPerson,
            nPdtPdtPrice: nPdtPdtPrice
        },
        cache: false,
        success: function (tResult) {

            tResult = tResult.trim();
            aResult = tResult.split(',');
            // alert(nResult)
            if (aResult[0] == '1') {
                localStorage.nRowID = '';
                $('#oliTabPkgProduct').click();
            } else {
                bootbox.alert({
                    title: aLocale['tWarning'],
                    message: aResult[1],
                    buttons: {
                        ok: {
                            label: aLocale['tOK'],
                            className: 'xCNBTNPrimery'
                        }
                    },
                    callback: function () {
                        $('.bootbox').modal('hide');
                    }
                });
            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxCallPagePkgModalCstZone(nLocID, nPkgID) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPagePkgModalCstZone",
        data: {
            nLocID: nLocID,
            nPkgID: nPkgID
        },
        cache: false,
        success: function (tResult) {

            $('#odvModalZonePanal').html(tResult);

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function JSxCallPagePkgModalCstShowTime(nLocID, nPkgID) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPagePkgModalCstShowTime",
        data: {
            nLocID: nLocID,
            nPkgID: nPkgID
        },
        cache: false,
        success: function (tResult) {
            // alert(tResult)
            $('#odvModalShowTimePanal').html(tResult);

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function JSxPkgAddLocShowTime(nTmhID) {

    nPkgID = $('#oetHidePkgID').val();
    nLocID = $('#ocmPkgLocation').val();

    $.ajax({
        type: "POST",
        url: "EticketPackage_AddLocShowTime",
        data: {
            nLocID: nLocID,
            nTmhID: nTmhID,
            nPkgID: nPkgID
        },
        cache: false,
        success: function (tResult) {
            bootbox.alert({
                title: aLocale['tWarning'],
                message: tResult,
                buttons: {
                    ok: {
                        label: aLocale['tOK'],
                        className: 'xCNBTNPrimery'
                    }
                },
                callback: function () {
                    $('.bootbox').modal('hide');
                }
            });
        JSxPkgLocShowTimePanal(nLocID);
        },
        error: function (data) {
            console.log(data);
        }
    });

}

function JSxPkgLocShowTimePanal(nLocID) {

    nPkgID = $('#oetHidePkgID').val();

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPageLocShowTimePanal",
        data: {
            nLocID: nLocID,
            nPkgID: nPkgID
        },
        cache: false,
        success: function (tResult) {

            $('#odvPkgLocShowTimePanal').html(tResult);

        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxPkgViewDetailLocShowTime(nTmhID) {

    // nLocID = $('#ocmPkgLocation').val();
    // alert(nLocID);

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPageViewDetailLocShowTime",
        data: {
            nTmhID: nTmhID
        },
        cache: false,
        success: function (tResult) {

            $('#odvPkgLocTimeTableHDPanal').html(tResult);

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function JSxPkgModalShowTimeBack() {

    nPkgID = $('#oetHidePkgID').val();

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPageTimeTableHDPanal",
        data: {
            nPkgID: nPkgID
        },
        cache: false,
        success: function (tResult) {

            $('#odvPkgLocTimeTableHDPanal').html(tResult);

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function JSxPkgDelLocShowTime(nEvnID, nLocID, nTmhID) {
//    bootbox.alert({
//        title: 'แจ้งเตือน',
//        message: nEvnID + " " + nLocID + " " + nTmhID,
//        buttons: {
//            ok: {
//                label: aLocale['tOK'],
//                className: 'xCNBTNPrimery'
//            }
//        },
//        callback: function () {
//            $('.bootbox').modal('hide');
//        }
//    });
    $.ajax({
        url: 'EticketPackage_DelPkgLocShowTimePanal',
        data: {
            nEvnID: nEvnID,
            nLocID: nLocID,
            nTmhID: nTmhID
        },
        method: "POST"
    }).done(function (tRes) {

        tRes = tRes.trim();

        if (tRes == '1') {
            JSxPkgLocShowTimePanal(nLocID);
        }

    }).fail(function (data) {
        console.log(data);
    });

}

// get หน้า html PkgModel
function FSxCallPagePkgModel(nPkgID) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPagePkgModel",
        data: {
            nPkgID: nPkgID
        },
        cache: false,
        success: function (tResult) {

            $('#odvTabPkgModelPanal').html(tResult);
            // alert(localStorage.ModelnPmoID);
            if (localStorage.ModelnPmoID) {

                $('select[name="ocmPkgProvince"]').val(
                        localStorage.ModelnProvince);
                $('#select2-ocmPkgProvince-container').text(
                        localStorage.ModeltProvinceName);

                JSxPkgCstGetSelectModelHTML(localStorage.ModelnProvince);
                localStorage.ModelnPmoIDOld = localStorage.ModelnPmoID;
                setTimeout(function () {

                    $('select[name="ocmPkgPmoID"]').val(
                            localStorage.ModelnPmoIDOld);
                    $('#select2-ocmPkgPmoID-container').text(
                            localStorage.ModeltPmoName);

                }, 300);

                // เปลี่ยนปุ่ม
                if (localStorage.ModelnPpkType == '1') {
                    // ถ้า 1 จะเปลี่ยน Onclick ปุ่มเป็น Add
                    // JSxPkgAddModelCustomer()
                    $('.xWBtnAddPkgModel').attr('onclick',
                            'JSxPkgAddModelCustomer()');
                } else if (localStorage.ModelnPpkType == '2') {
                    // ถ้า 2 จะเปลี่ยน Onclick ปุ่มเป็น Add
                    // JSxBtnAddPkgModelAdmin()
                    $('.xWBtnAddPkgModel').attr('onclick',
                            'JSxBtnAddPkgModelAdmin()');
                }

                $('select[name="ocmPkgPpkType"]').val(
                        localStorage.ModelnPpkType);

                localStorage.ModelnPmoID = '';
            }

        },
        error: function (data) {
            console.log(data);
        }
    });

}

// get หน้า html PkgModel
function FSxCallPagePkgProduct(nPkgID) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPagePkgProduct",
        data: {
            nPkgID: nPkgID
        },
        cache: false,
        success: function (tResult) {

            $('#odvTabPkgProductPanal').html(tResult);

        },
        error: function (data) {
            console.log(data);
        }
    });

}

// get หน้า html PkgModel
function JSxCallPagePkgSpcPriByGrp(nPkgID, nPpkID, tZneName) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPagePkgSpcPriByGrp",
        data: {
            nPkgID: nPkgID,
            nPpkID: nPpkID,
            tZneName: tZneName
        },
        cache: false,
        success: function (tResult) {

            // $('#odvTabPkgSpcPriByGrpPanal').html(tResult);
            $('#odvPkgDetailPanal').html(tResult);

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function JSxPkgAddModelCustomer() {
   
    nProvince     = $('#ocmPkgProvince').val();
    tProvinceName = $('#ocmPkgProvince option:selected').text();
    nPmoID        = $('#ocmPkgPmoID').val();
    tPmoName = $('#ocmPkgPmoID option:selected').text();
    nPpkType = $('#ocmPkgPpkType').val();
    tPpkName = $('#ocmPkgPpkType option:selected').text();
    nPkgID = $('#oetHidePkgID').val();
    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPageModalModelCustomer",
        data: {
            nPmoID: nPmoID,
            nPkgID: nPkgID
        },
        cache: false,
        success: function (tResult) {
            $('#odvModalPkgCustomer').html(tResult);
            $('.xWNameTitleMod').text(tPmoName);
            $('#obtHideModalModelCst').click();

            localStorage.ModelnProvince = nProvince
            localStorage.ModeltProvinceName = tProvinceName
            localStorage.ModelnPmoID = nPmoID
            localStorage.ModeltPmoName = tPmoName
            localStorage.ModelnPpkType = nPpkType
            localStorage.ModeltPpkName = tPpkName

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function JSxBtnAddPkgModelAdmin() {
    $("#ofmAddPackageModel").validate({
        rules: {
            ocmPkgPmoID: "required",
            ocmPkgPpkType: "required",
        },
        messages: {
            ocmPkgPmoID: "Please Select Model",
            ocmPkgPpkType: "Please Select Type",
        },
        errorClass: "input-invalid",
        validClass: "input-valid",
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        },
        submitHandler: function (form) {

            nProvince = $('#ocmPkgProvince').val();
            tProvinceName = $('#ocmPkgProvince option:selected').text();
            nPmoID = $('#ocmPkgPmoID').val();
            tPmoName = $('#ocmPkgPmoID option:selected').text();
            nPpkType = $('#ocmPkgPpkType').val();
            tPpkName = $('#ocmPkgPpkType option:selected').text();

            $.ajax({
                type: "POST",
                url: "EticketPackage_AddPkgModel",
                data: $("#ofmAddPackageModel").serialize(),
                cache: false,
                success: function (tResult) {

                    tResult = tResult.trim();
                    aResult = tResult.split(',');

                    if (aResult[0] == '500') {                    
                        bootbox.alert({
                            title: aLocale['tWarning'],
                            message: aResult[1],
                            buttons: {
                                ok: {
                                    label: aLocale['tOK'],
                                    className: 'xCNBTNPrimery'
                                }
                            },
                            callback: function () {
                                $('.bootbox').modal('hide');
                            }
                        });
                    }

                    localStorage.ModelnProvince = nProvince
                    localStorage.ModeltProvinceName = tProvinceName
                    localStorage.ModelnPmoID = nPmoID
                    localStorage.ModeltPmoName = tPmoName
                    localStorage.ModelnPpkType = nPpkType
                    localStorage.ModeltPpkName = tPpkName

                    $('#oliTabPkgModel').click();
                    // console.log(tResult);

                },
                error: function (data) {
                    console.log(data);
                }
            });
            return false;
        }
    });

}

function JSxBtnAddPkgSave() {

    $("#ofmAddPackage").validate({
        rules: {
            oetAddPkgName: "required",
            oetAddPkgTchGroup: "required",
            oetAddPkgMaxPark: "required",
        },
        messages: {
            oetAddPkgName: "Please enter package name"
        },
        errorClass: "alert-validate",
        validClass: "",
        highlight: function (element, errorClass, validClass) {
            $(element).parent('.validate-input').addClass(errorClass).removeClass(validClass);
            $(element).parent().parent('.validate-input').addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parent('.validate-input').removeClass(errorClass).addClass(validClass);
            $(element).parent().parent('.validate-input').removeClass(errorClass).addClass(validClass);
        },
        submitHandler: function (form) {

            nPkgMaxPark = $('#oetAddPkgMaxPark').val();

            nPkgType = $('#ocmAddPkgType').val();
            nPkgMinGrpQty = $('#oetAddPkgMinGrpQty').val();

            if (parseFloat(nPkgMaxPark) == 0 || nPkgMaxPark == '') {
                $('#oetAddPkgMaxPark').focus();
                $('#oetAddPkgMaxPark').addClass('input-invalid');
                $('#oetAddPkgMaxPark').val('');
                $('#oetAddPkgMaxPark').attr('placeholder', 'Not 0');
            } else if (nPkgMinGrpQty == '' || parseFloat(nPkgMinGrpQty) == 0) {
                $('#oetAddPkgMinGrpQty').focus();
                $('#oetAddPkgMinGrpQty').addClass('input-invalid');
                $('#oetAddPkgMinGrpQty').val('');
            } else {
                $('button[type=submit]').attr('disabled', true);
                
                console.log($("#ofmAddPackage").serialize());
                
                
                $.ajax({
                    type: "POST",
                    url: "EticketPackage_AddPackage",
                    data: $("#ofmAddPackage").serialize(),
                    cache: false,
                    success: function (tResult) {
                        nPkgID = tResult.trim();
                        if (nPkgID != '') {
                            var nDataId = $('.xWBtnSaveActive').data('id');
                            if (nDataId == '1') {
                                JSxCallPageEditPkg(nPkgID);
                            } else if (nDataId == '2') {
                                JSxCallPageAddPkg();
                            } else if (nDataId == '3') {
                                JSxCallPagePkgDetail(nPkgID);
                            }
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }

            return false;
        }
    });
}

function JSxBtnEditPkgSave() {

    $("#ofmEditPackage").validate(
            {
                rules: {
                    oetEditPkgName: "required",
                    oetEditPkgTchGroup: "required",
                    oetEditPkgMaxPark: "required",
                },
                messages: {
                    oetEditPkgName: "Please enter package name"
                },
                errorClass: "alert-validate",
                validClass: "",
                highlight: function (element, errorClass, validClass) {
                    $(element).parent('.validate-input').addClass(errorClass).removeClass(validClass);
                    $(element).parent().parent('.validate-input').addClass(errorClass).removeClass(validClass);
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parent('.validate-input').removeClass(errorClass).addClass(validClass);
                    $(element).parent().parent('.validate-input').removeClass(errorClass).addClass(validClass);
                },
                submitHandler: function (form) {

                    nPkgMaxPark = $('#oetEditPkgMaxPark').val();
                    tPkgName = $('#oetEditPkgName').val();

                    nPkgType = $('#ocmEditPkgType').val();
                    nPkgMinGrpQty = $('#oetEditPkgMinGrpQty').val();

                    if (parseFloat(nPkgMaxPark) == 0 || nPkgMaxPark == '' || tPkgName == '') {
                        $('#oetEditPkgMaxPark').focus();
                        $('#oetEditPkgMaxPark').addClass('input-invalid');
                        $('#oetEditPkgMaxPark').val('');
                        $('#oetEditPkgMaxPark').attr('placeholder', 'Not 0');
                    } else if (nPkgMinGrpQty == '' || parseFloat(nPkgMinGrpQty) == 0) {
                        $('#oetEditPkgMinGrpQty').focus();
                        $('#oetEditPkgMinGrpQty').addClass('input-invalid');
                        $('#oetEditPkgMinGrpQty').val('');
                    } else {
                        $('button[type=submit]').attr('disabled', true);
                        $.ajax({
                            type: "POST",
                            url: "EticketPackage_EditPackage",
                            data: $("#ofmEditPackage").serialize(),
                            cache: false,
                            success: function (tResult) {
                                tResult = tResult.trim();
                                aResult = tResult.split(',');

                                nPkgID = aResult[0];
                                nStatus = aResult[1];

                                if (nStatus == 1) {
                                    var nDataId = $('.xWBtnSaveActive').data('id');
                                    if (nDataId == '1') {
                                        JSxCallPageEditPkg(nPkgID);
                                    } else if (nDataId == '2') {
                                        JSxCallPageAddPkg();
                                    } else if (nDataId == '3') {
                                        JSxCallPagePkgDetail(nPkgID);
                                    }
                                }
                                var nStaLimitBy = $('#oetEditPkgStaLimitBy').val();
                                if (nStaLimitBy == 1) {
                                    $('#oInputFTZneBookingType').remove();
                                    $('body').append('<input type="hidden" id="oInputFTZneBookingType" value="0" />');
                                }
                            },
                            error: function (data) {
                                console.log(data);
                            }
                        });
                    }

                    return false;
                }
            });
}

function JSxCallPagePkgDetail(nPkgID) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPagePkgDetail",
        data: {
            nPkgID: nPkgID
        },
        cache: false,
        success: function (tResult) {

            $('.odvMainContent').html(tResult);

            // วาด ลง Panal Detail
            JSxCallPageModelAndPdtPanal(nPkgID);

        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxCallPageModelAndPdtPanal(nPkgID) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPageModelAndPdtPanal",
        data: {
            nPkgID: nPkgID
        },
        cache: false,
        success: function (tResult) {

            $('#odvPkgDetailPanal').html(tResult);

            $('#olaTabPkgModel').click();

            // $('#oliTabPkgModel').click();
            // $('#oliTabPkgModel').addClass('active');

        },
        error: function (data) {
            console.log(data);
        }
    });
}

// เรียกหน้า tab Model และ Product และคลิก Tab GrpPri
function JSxCallPageModelAndPdtPanalClickGrpPri(nPkgID) {

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPageModelAndPdtPanal",
        data: {
            nPkgID: nPkgID
        },
        cache: false,
        success: function (tResult) {

            $('#odvPkgDetailPanal').html(tResult);

            $('#olaTabPkgProduct').click();

        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxCallPageEditPkg(nPkgID) {

    JCNUnLockScolling();
    $('.xCNOverlay').css('display', 'none');
    $('.xWodvDialogCheckPkg').css('display', 'none');

    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPageEditPkg",
        data: {
            nPkgID: nPkgID
        },
        cache: false,
        success: function (tResult) {
            $('.odvMainContent').html(tResult);

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function JSxCallPageAddPkg() {

    JCNUnLockScolling();
    $('.xCNOverlay').css('display', 'none');
    $('.xWodvDialogCheckPkg').css('display', 'none');
    $.ajax({
        type: "POST",
        url: "EticketPackage_CallPageAddPkg",
        data: {},
        cache: false,
        success: function (tResult) {
            $('.odvMainContent').html(tResult);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

// ลบ Pakage ธรรมดา
// ลบ Package ที่ไม่มีสินค้าผูกไว้
function JSxDeletePkgNoPdt(pnPage,nPkgID,tMsg) {

    bootbox.confirm({
        title: aLocale['tConfirmDelete'],
        message: aLocale['tConfirmDeletionOf'] + ' ' + nPkgID + ' ('+tMsg+')',
        buttons: {
            cancel: {
                label:  aLocale['tBtnConfirm'],
                className: 'xCNBTNPrimery'
            },
            confirm: {
                label: aLocale['tBtnClose'],
                className: 'xCNBTNDefult'
            }
        },
        callback: function (result) {
            if (result == false) {

                $.ajax({
                    type: "POST",
                    url: "EticketPackage_DelPkgNoPdt",
                    data: {
                        nPkgID: nPkgID
                    },
                    cache: false,
                    success: function (tResult) {
                        tResult = tResult.trim();
                        aResult = tResult.split(',');
                        nStatus = aResult[0];
                        tMsg = aResult[1];

                        if (nStatus == 1) {
                            $('#ospPageActive').text(pnPage);
                            FSxCheckPkgHavePdt();
                        }else{
                            bootbox.alert({
                                title: aLocale['tWarning'],
                                message: tMsg,
                                buttons: {
                                    ok: {
                                        label: aLocale['tOK'],
                                        className: 'xCNBTNPrimery'
                                    }
                                },
                                callback: function () {
                                    $('.bootbox').modal('hide');
                                }
                            });
                        }

                    },
                    error: function (data) {
                        console.log(data);
                    }
                });

            }
        }
    });
}

//Functionality : (event) Delete All
//Parameters : Button Event 
//Creator : P'Nut
//Update: 22/01/2019 Krit
//Return : Event Delete All Select List
//Return Type : -
function FSxDelAllOnCheck(pnPage) {
    var ocbListItem = [];
    var ocbListName = [];
    $('.ocbListItem:checked').each(function (i, e) {
        ocbListName.push($(this).data('name'));
    });

    $('.ocbListItem:checked').each(function (i, e) {
        ocbListItem.push($(this).val());
    });
    $.ajax({
        type: "POST",
        url: "EticketPackage_DelPkgNoPdt",
        data: {
            'nPkgID': ocbListItem.join()
        },
        cache: false,
        success: function (msg) {
            $('#ospPageActive').text(pnPage);
            FSxCheckPkgHavePdt();
            
            $('.modal-backdrop').remove(); 
            $('.obtChoose').hide(); 
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        },
        error: function (data) {
            console.log(data);
        }
    });
}



function FSxCheckPkgHavePdt() {

    $.ajax({
        type: "POST",
        url: "EticketPackage_CountCheckPkgNoPdt",
        data: {},
        cache: false,
        success: function (tResult) {

            nResult = tResult.trim();

            if (nResult != 0) {
                // กดปุ่ม ปุ่ม Search
                JSxPKGCountSearch();

                JCNLockScolling();
                $('.xCNOverlay').css('display', 'block');
                $('.xWodvDialogCheckPkg').css('display', 'block');

                // วาด hmtl
                JSxGETPageDialogPkgHavePdt();

            } else {
                JCNUnLockScolling();
                JSxPKGCountSearch();
                $('.xCNOverlay').css('display', 'none');
                $('.xWodvDialogCheckPkg').css('display', 'none');

            }

        },
        error: function (data) {
            console.log(data);
        }
    });

}

function JSxPKGCloseDialogWarning() {
    JCNUnLockScolling();
    JSxPKGCountSearch();
    $('.xCNOverlay').css('display', 'none');
    $('.xWodvDialogCheckPkg').css('display', 'none');
}

function JSxGETPageDialogPkgHavePdt() {

    $.ajax({
        type: "POST",
        url: "EticketPackage_GETPageDialogPkgNoPdt",
        data: {},
        cache: false,
        success: function (tResult) {

            $('#odvCheckPkgPanal').html(tResult);

        },
        error: function (data) {
            console.log(data);
        }
    });

}

// เมื่อกดปุ่ม Add
function JSxAddPkg() {

    localStorage.tPdtSelected = ''
    $('#otbPdtSelectedPanal').html('');

}

function JSxRemovePdt(tPdtCode, tValue) {

    $('#otr' + tPdtCode).remove();
    alert(localStorage.tPdtSelected)
    // alert(tValue)
    tCalVal = localStorage.tPdtSelected.split(tValue)

    alert(tCalVal)
    localStorage.tPdtSelected = tCalVal

}

// Create : Krit
// Fs เลือก Pdt ตอนสร้าง Pkg
function JSxBtnSelectPdt() {

    var aValues = new Array();
    $.each($("input[name='pdt_group[]']:checked"), function () {
        aValues.push($(this).val());

        // or you can do something to the actual checked checkboxes by working
        // directly with 'this'
        // something like $(this).hide() (only something useful, probably) :P
    });
    localStorage.tPdtSelected = aValues;
    JSxPdtSelectedPanalList(aValues);
}

// ตอนเลือก Pdt แล้วให้ไปวาดอีกหน้า
function JSxPdtSelectedPanalList(ptValues) {
    alert('-*-*-')
    $.ajax({
        type: "POST",
        url: "EticketPackage_PdtSelectedList",
        data: {
            ptValues: ptValues
        },
        cache: false,
        success: function (tResult) {
            // Panal Search Pdt
            $('#otbPdtSelectedPanal').html(tResult);

            if ($('#ocmAddPickTypePrice').val() == '2') {

                $('#oetAddPkgPdtPrice').attr('disabled', false);
                $('.xCNDkk').hide();
                $('.xCNDkkB').hide();
                $('.xWPackage').show();
            } else if ($('#ocmAddPickTypePrice').val() == '1') {
                $('#oetAddPkgPdtPrice').attr('disabled', true);
                $('.xCNDkk').show();
                $('.xCNDkkB').show();
                $('.xWPackage').hide();
            }

            $('#btnPdtSelectClose').click();

        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxPKGModalAddPdtSearch() {
    tTchGroupName = $('#oetSchTchGroupName').val();
    tSchPdtName = $('#oetSchPdtName').val();
    tPdtSelected = localStorage.tPdtSelected;
    $.ajax({
        type: "POST",
        url: "EticketPackage_PdtSearch",
        data: {
            tTchGroupName: tTchGroupName,
            tSchPdtName: tSchPdtName
        },
        cache: false,
        success: function (msg) {
            // Panal Search Pdt
            $('#otbSchPdtListPanal').html(msg);
            if (tPdtSelected != '') {
                aPdtSelected = tPdtSelected.split(",");
                for (i = 0; i < aPdtSelected.length; i++) {
                    aSplit = aPdtSelected[i].split("^");
                    $('#oet' + aSplit[0]).attr('checked', true).prop('checked',
                            true)
                }
            } else {
                // alert('ไม่มีค่า')
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function JSxPKGGrpEdit(tPkgName, tTcgName, cPkgPdtPrice) {
    $('.form-group').addClass('focused');
    $('#modal-addgrp-day #myModalLabel span').text(tPkgName);
    $('#oetPdtName').val(tPkgName);
    $('#oetPdtGrp').val(tTcgName);

    $('#oetPkgPdtPrice').val(cPkgPdtPrice);

}

// Create : Krit
// นับจำนวนค้นหา Package
function JSxPKGCountSearch(nStaSearch) {

    nHeight = $(window).height();
    nHeight = nHeight - 220;
    nPkgPanal = $('#oResultPackage').height();
    nSum = nPkgPanal / 110;
    nRow = Math.floor(nSum)
    if (nStaSearch == 1) {
        $('#ospPageActive').text('1');
    }
    var tFTPkgPmoID = $('#ocmPkgPmoID').val();
    var tFTPkgName = $('#oetFTPkgName').val();
    var tFTPkgStaPrcDoc = $('#ocmPkgStaPrcDoc').val();

    JSxPKGListView();
}

function JSxClickSearchPdt() {
    JSxPKGModalAddPdtSearch()
}

function FSxEncodePrkAdd() {
    var filesSelected = document.getElementById("ofilePhotoAdd").files;
    if (filesSelected.length > 0) {
        var fileToLoad = filesSelected[0];
        var fileReader = new FileReader();
        fileReader.onload = function (fileLoadedEvent) {
            var tContents = document.getElementById("ohdPhotoAdd");
            tContents.value = fileLoadedEvent.target.result;
            var tImages = document.getElementById("thumbnail-image");
            tImages.setAttribute('src', fileLoadedEvent.target.result);
        };
        fileReader.readAsDataURL(fileToLoad);
    }
}

function FSxEncodePrkEdit() {
    var filesSelected = document.getElementById("ofilePhotoEdit").files;
    if (filesSelected.length > 0) {
        var fileToLoad = filesSelected[0];
        var fileReader = new FileReader();
        fileReader.onload = function (fileLoadedEvent) {
            var tContents = document.getElementById("ohdPhotoEdit");
            tContents.value = fileLoadedEvent.target.result;
            var tImages = document.getElementById("thumbnail-edit");
            tImages.setAttribute('src', fileLoadedEvent.target.result);
        };
        fileReader.readAsDataURL(fileToLoad);
    }
}

/**
 * FS โหลดข้อมูลหน้าสาขา
 */
function JSxParkDetail(ptParkId) {
    // JCNhtmlLoadController('ParkDetail','odvMainContent');
    var tParkId = ptParkId;
    $.ajax({
        url: 'EticketParkDetail',
        data: {
            tParkId: tParkId
        },
        method: "POST"
    }).success(function (tResault) {
        $('#odvMainContent').html(tResault);
    }).error(function (data) {
        console.log(data);
    });
}

function FSSetShow() {
    $('#modal-show-seat').modal('show');
}

/**
 * ลบPackage
 */
function JSnPkgCheckValidateDel(pnPkgId) {

    bootbox.confirm({
        message: "Are you sure to delete this Package?",
        callback: function (tResult) {
            if (tResult == true) {
                JSxPKGDel(pnPkgId);
            }
        }
    });
}

function JSxPKGDel(pnPkgId) {

    $('.icon-loading').show();
    $.ajax({
        url: 'EticketDeletePackage',
        data: {
            pnPkgId: pnPkgId
        },
        method: "GET"
    }).done(function (tRes) {
        nRes = tRes.trim();
        bootbox.alert({
            title: aLocale['tWarning'],
            message: nRes,
            buttons: {
                ok: {
                    label: aLocale['tOK'],
                    className: 'xCNBTNPrimery'
                }
            },
            callback: function () {
                $('.bootbox').modal('hide');
            }
        });
        if (nRes == 1) {
            JSxPKGListView();
        } else {
            alert('ไม่ได้');
        }
        JCNhtmlLoadController('Park', 'odvMainContent');
        $('.icon-loading').hide();
    }).fail(function (data) {
        console.log(data);
    });
}

/**
 * สาขา pagination และ ค้นหา
 */

// ข้อมูลหน้า ก่อนหน้า
function JSxPKGPreviousPage() {
    // alert('PreviousPage');
    var nCurrentPage = $('#ospPageActive').text();

    var nPreviousPage
    if (nCurrentPage == 1) {
        nPreviousPage = 1;
    } else {
        nPreviousPage = parseInt(nCurrentPage) - 1;
    }

    $('#ospPageActive').text(nPreviousPage);

    JSxPKGListView();
}

// ข้อมูลหน้า หน้าถัดไป
function JSxPKGForwardPage() {
    // alert('ForwardPage');
    var nCurrentPage = $('#ospPageActive').text();
    var nTotalPage = $('#ospTotalPage').text();
    var nForwardPage
    if (nCurrentPage == nTotalPage) {
        nForwardPage = nTotalPage;
    } else {
        nForwardPage = parseInt(nCurrentPage) + 1;
    }
    $('#ospPageActive').text(nForwardPage);
    JSxPKGListView();
}
function JSvPClickPage(tNumPage) {
    $('#ospPageActive').text(tNumPage);
    JSxPKGListView();
}

// แสดงแพ็คเกจ
function JSxPKGListView() {
    $('#oResultPackage').height('css', nHeight);

    var tFTPkgPmoID = $('#ocmPkgPmoID').val();
    var tFTPkgName = $('#oetFTPkgName').val();
    var tFTPkgStaPrcDoc = $('#ocmPkgStaPrcDoc').val();
    var nPageNo = $('#ospPageActive').text();

    if (nPageNo == '') {
        nPageNo = 1;
    }

    $('.icon-loading').show();
    $.ajax({
        type: "POST",
        url: "EticketPackageList",
        data: {
            tFTPkgPmoID: tFTPkgPmoID,
            tFTPkgName: tFTPkgName,
            tFTPkgStaPrcDoc: tFTPkgStaPrcDoc,
            nPageNo: nPageNo,
            nRow: 5
        },
        cache: false,
        success: function (msg) {
            $('#oResultPackage').html(msg);
            $('.icon-loading').hide();
            var ospPageActive = $('#ospPageActive').text();
            var ospTotalPage = $('#ospTotalPage').text();
            var tHtml = '';

            tHtml = '<div class="xWPageBranch btn-toolbar pull-right">';
            tHtml += '<button class="btn btn-white btn-sm" id="oPreviousPage" onclick="return JSxPKGPreviousPage();"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>';
            var i;
            var l;
            for (i = 0; i < parseInt(ospTotalPage); i++) {
                l = i + 1;
                if (parseInt(ospPageActive) == l) {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation active" disabled="">' + l + '</button>';
                } else {
                    tHtml += '<button onclick="JSvPClickPage(\'' + l + '\');" type="button" class="btn xCNBTNNumPagenation">' + l + '</button>';
                }
            }
            tHtml += '<button class="btn btn-white btn-sm" id="oForwardPage" onclick="return JSxPKGForwardPage();"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>';
            tHtml += '</div>';

            $('.xWGridFooter').html(tHtml);
            if (ospPageActive == '1') {
                $('#oPreviousPage').attr('disabled',true);
            } else {
                $('#oPreviousPage').attr('disabled',false);
            }
            if (ospPageActive == ospTotalPage) {
                $('#oForwardPage').attr('disabled',true);
            } else {
                $('#oForwardPage').attr('disabled',false);
            }
            JSxCheckPinMenuClose();
            $('.xCNOverlay').hide();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

// โหลดอำเภอ
function JSxPKGDistrict(tID) {
    $.ajax({
        type: "POST",
        url: "EticketDistrict",
        data: {
            ocmFNPvnID: tID
        },
        cache: false,
        success: function (msg) {
            $('#ocmFNDstID').html(msg);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

// window.onload = JSxPKGCountSearch();
function JSxPKGAddAre() {
    $tFNAreID = $('#ocmFNAreID :selected');
    $tFNPvnID = $('#ocmFNPvnID :selected');
    $tFNDstID = $('#ocmFNDstID :selected');
    $tHtml = '<tr id="otr'
            + $tFNAreID.val()
            + $tFNPvnID.val()
            + $tFNDstID.val()
            + '"><td>'
            + $tFNAreID.text()
            + '<input type="hidden" name="ohdFNAreID[]" value="'
            + $tFNAreID.val()
            + '"></td><td>'
            + $tFNPvnID.text()
            + '<input type="hidden" name="ohdFNPvnID[]" value="'
            + $tFNPvnID.val()
            + '"></td><td>'
            + $tFNDstID.text()
            + '<input type="hidden" name="ohdFNDstID[]" value="'
            + $tFNDstID.val()
            + '"></td><td><a href="#" onclick="javascript: $(\'#otr'
            + $tFNAreID.val()
            + $tFNPvnID.val()
            + $tFNDstID.val()
            + '\').remove();"><i class="fa fa-trash-o" aria-hidden="true" style="color: #087380"></i> ลบ</a></td></tr>';
    $('#otbAre tbody').append($tHtml);
    $('#otbAre tbody #otr').hide();
    $('#modal-area').modal('hide');
}

function JCNLockScolling() {
    $('body').css('overflow', 'hidden');
}

function JCNUnLockScolling() {
    $('body').css('overflow', 'auto');
}

function JSxPKGCheckMaxPark(tID) {
    $.ajax({
        type: "POST",
        url: "EticketPackage_CheckMaxPark",
        data: {
            FNPkgID: tID
        },
        cache: false,
        success: function (msg) {
            if (msg == 1) {
                var oetEditPkgStaLimitBy = $('#oetEditPkgStaLimitBy').val();
                var ocmEditPkgType = $('#ocmEditPkgType').val();
                if (oetEditPkgStaLimitBy == '1' && ocmEditPkgType == '2') {
                    $('#oetEditPkgMaxPark').removeAttr('max');
                } else {
                    $('#oetEditPkgMaxPark').val('1');
                    $('#oetEditPkgMaxPark').attr('max', '1');
                }
                $('#oInputCheckMaxPark').remove();
                $('body').append('<input type="hidden" id="oInputCheckMaxPark" value="' + msg.trim() + '" />');
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function JSxPKGCheckPkgZone(tID) {
    $.ajax({
        type: "POST",
        url: "EticketPackage_CheckPkgZone",
        data: {
            FNPkgID: tID
        },
        cache: false,
        success: function (oData) {
            oBj = JSON.parse(oData);
            if (oBj.FTPkgStaLimitBy == '2') {
                $('#oInputFTZneBookingType').remove();
                $('body').append('<input type="hidden" id="oInputFTZneBookingType" value="' + oBj.FTZneBookingType + '" />');
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 18/01/2019 Krit
//Return: -
//Return Type: -
function JSxTextinModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tText = '';
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tText += aArrayConvert[0][$i].tName + '(' + aArrayConvert[0][$i].nCode + ') ';
            tText += ' , ';
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
        }
        var tTexts = tText.substring(0, tText.length - 2);
        $('#ospConfirmDelete').text('ท่านต้องการลบข้อมูลทั้งหมดหรือไม่ ?');
        $('#ospConfirmIDDelete').val(tTextCode);
    }
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 18/01/2019 Krit
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
        } else {
             $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        }
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 18/01/2019 Krit
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