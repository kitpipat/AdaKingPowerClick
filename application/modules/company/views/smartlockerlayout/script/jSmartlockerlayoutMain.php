<script type="text/javascript">

    $(document).ready(function () {
        JSvSMLList(1);
        $("#odvMngTableList #oliBtnDeleteAll").addClass("disabled");

        //Search
        $('#obtSearchSMLLayout').click(function(){ 
            aDataSearch = [];
            var tGroup          = $('#osmSMLLayoutGroup option:selected').val(); 
            var tLayoutColumn   = $('#osmSMLLayoutColumn option:selected').val(); 
            var tFloor          = $('#oetSearchSMLFloor').val();
            var tColumn         = $('#oetSearchSMLColumn').val();
            aSMLLayout         = [tGroup,tLayoutColumn,tFloor,tColumn];
            aDataSearch.push(aSMLLayout);
            JSvSMLList(1);
        });
    });

    //Call list
    var aDataSearch = [];
    function JSvSMLList(nPage){
        var tBchCode = $('#oetSMLBranch').val();
        var tShpCode = $('#oetSMLShop').val();

        $.ajax({
            type    : "POST",
            url     : "SHPSmartLockerLayoutDataTable",
            data    : {
                tBchCode        : tBchCode,
                tShpCode        : tShpCode,
                nPageCurrent    : nPage,
                tSearchAll      : aDataSearch
            },
            cache   : false,
            Timeout : 0,
            async   : false,
            success : function(tView){
                $('#odvContentSMLLayoutDataTable').html(tView);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //เปลี่ยนหน้า pagenation
    function JSvSMLClickPage(ptPage) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xWBtnNext").addClass("disabled");
                nPageOld = $(".xWSMLPagePaging .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
            break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xWSMLPagePaging .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
            break;
            default:
            nPageCurrent = ptPage;
        }
        JSvSMLList(nPageCurrent);
    }

    //Event ลบข้อมูลรายการเดียว
    function JSxSMLDelete(pnLayno,pnBch,pnShp){
        $('#odvModalDeleteSingleSmartLockerLayout').modal('show');
        $('#ospConfirmDeleteSmartLockerLayout').html($('#oetTextComfirmDeleteSingle').val() + ' <?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableBox')?> ' +  pnLayno + ' ' + $('#oetTextComfirmDeleteYesOrNot').val());
        $('.osmConfirmDeleteSmartLockerLayout').on('click', function(evt) {
            $.ajax({
                type: "POST",
                url: "SHPSmartLockerLayoutDelete",
                data: { 
                    pnLayno : pnLayno,
                    pnBch   : pnBch,
                    pnShp   : pnShp
                },
                cache: false,
                success: function(tResult) {
                    $('#odvModalDeleteSingleSmartLockerLayout').modal('hide');
                    setTimeout(function(){
                        JCNvReturnSearch();
                        JSvSMLList(1);
                    }, 500);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });

        $('.osmCancleDeleteSmartLockerLayout').on('click', function(evt) {
            pnLayno = '';
            pnBch   = '';
            pnShp   = '';

        });

        // alert(pnLayno + ' ' + pnBch + ' ' + pnShp)
    }

    //เปิดปุ่มลบหลายรายการ
    function JSxSMLShowButtonChoose() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
            $("#odvMngTableList #oliBtnDeleteAll").addClass("disabled");
        } else {
            nNumOfArr = aArrayConvert[0].length;
            if (nNumOfArr > 1) {
                $("#odvMngTableList #oliBtnDeleteAll").removeClass("disabled");
            } else {
                $("#odvMngTableList #oliBtnDeleteAll").addClass("disabled");
            }
            if (nNumOfArr > 1) {
                $('.xCNIconDel').addClass('xCNDisabledDelete');
            } else {
                $('.xCNIconDel').removeClass('xCNDisabledDelete');
            }
        }
    }

    //กำหนดข้อความตรงส่วนลบ แบบหลายรายการ
    function JSxSMLPaseCodeDelInModal() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
   
        if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
            var nbch        = '';
            var nshp        = '';
            var nlayno      = '';
            for ($i = 0; $i < aArrayConvert[0].length; $i++) {
                nbch += aArrayConvert[0][$i].nbch;
                nbch += ',';

                nshp += aArrayConvert[0][$i].nshp;
                nshp += ',';

                nlayno += aArrayConvert[0][$i].nlayno;
                nlayno += ',';
            }
            $('#ospConfirmDeleteMutirecord').text($('#oetTextComfirmDeleteMulti').val());

            //เก็บรหัสช่อง
            $('#ohdConfirmIDDeleteMutirecordLayno').val(nlayno);

            //เก็บสาขา
            $('#ohdConfirmIDDeleteMutirecordBCH').val(nbch);

            //เก็บร้านค้า
            $('#ohdConfirmIDDeleteMutirecordSHP').val(nshp);
        }
    }

    //Event ลบแบบเลือกหลายรายการ
    function JSxSMLDeleteMutirecord() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var aDataLaynoMultiple      = $("#ohdConfirmIDDeleteMutirecordLayno").val();
            var aDataBchMultiple        = $("#ohdConfirmIDDeleteMutirecordBCH").val();
            var aTextLaynoMultiple      = aDataLaynoMultiple.substring(0,aDataLaynoMultiple.length - 1);
            var aTextBchMultiple        = aDataBchMultiple.substring(0,aDataBchMultiple.length - 1);

            var nDataSplitlength        = aTextLaynoMultiple.length;
            JCNxOpenLoading();
            if (nDataSplitlength > 1) {
                $.ajax({
                    type: "POST",
                    url : "SHPSmartLockerLayoutDeleteMutirecord",
                    data: { 
                            aTextLaynoMultiple      : aTextLaynoMultiple ,
                            aTextBchMultiple        : aTextBchMultiple ,
                            tSMLShop                : $('#oetSMLShop').val()
                        },
                    success: function(tResult) {
                        JCNxCloseLoading();
                        $('#odvModalDeleteMutirecord').modal('hide');
                        setTimeout(function(){
                            JSvSMLList(1);
                            JCNvReturnSearch();
                        }, 500);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        }
    }

    //Edit page
    function JSxSMLEdit(paPackData){
        $('#odvModalInsertSMLLayout').modal('show');
        $('.NumberDuplicate').hide();
        $('.xCNTextModalHeadInsert').text('<?=language('company/smartlockerlayout/smartlockerlayout', 'tSMLLayoutModalTitleEdit')?>');
        $('#ohdSMLEventpage').val('Edit');

        //เก็บค่าเก่า
        $('#ohdSMLOldLayno').val(paPackData.FNLayNo);
        $('#ohdSMLOldBch').val(paPackData.FTBchCode);
        $('#ohdSMLOldShp').val(paPackData.FTShpCode);

        //สาขา
        $('#oetInputSMLBchName').val(paPackData.FTBchName);
        $('#oetInputSMLBchCode').val(paPackData.FTBchCode);

        //กลุ่มช่อง
        $('#oetInputSMLGroupName').val(paPackData.FTRakName);
        $('#oetInputSMLGroupCode').val(paPackData.FTRakCode);

        //ขนาด
        $('#oetInputSMLSizeName').val(paPackData.FTSizName);
        $('#oetInputSMLSizeCode').val(paPackData.FTPzeCode);

        //ชื่อช่อง
        $('#oetSMLName').val(paPackData.FTLayName);

        //หมายเลขช่อง
        $('#oetSMLLayno').val(paPackData.FNLayNo);

        //สัดส่วนแนวตั้ง
        $('#oetSMLScaleVertical').val(paPackData.FNLayScaleX);

        //สัดส่วนแนวนอน
        $('#oetSMLScaleHorizontal').val(paPackData.FNLayScaleY);

        //ชั้นที่
        $('#oetSMLFloor').val(paPackData.FNLayRow);

        //คอลัมน์
        $('#oetSMLColumn').val(paPackData.FNLayCol);

        //หมายเหตุ
        $('#otaSMLRemark').val(paPackData.FTLayRemark);

        //สถานะ
        if(paPackData.FTLayStaUse == 1){
            $('#ocbSMLStatus').prop('checked', true);
        }else if(paPackData.FTLayStaUse == 0){
            $('#ocbSMLStatus').prop('checked', false);
        }

    }

    //Return View
    function JCNvReturnSearch(){
        $.ajax({
            type: "POST",
            url : "SHPSmartLockerLayoutGetSearch",
            data: { 
                tBchCode      : $('#oetSMLBranch').val() ,
                tShpCode      : $('#oetSMLShop').val() 
            },
            success: function(tResult) {
                var tResult = JSON.parse(tResult);
                var tGetLayoutGroup     = tResult.GetLayoutGroup.aList;
                var tGetLayoutColumn    = tResult.GetLayoutColumn.aList;

                //[Select opion] ล้างค่า กลุ่มช่อง
                $('#osmSMLLayoutGroup option').remove();
                $('#osmSMLLayoutGroup').append(
                    $('<option>', { 
                        value: '',
                        text : '<?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutPleaseSelect')?>'
                    })
                );
                $('#osmSMLLayoutGroup').append(
                    $('<option>', { 
                        value: '',
                        text : '<?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutSelectAll')?>'
                    })
                );

                //[Select opion] ล้างค่า ช่อง
                $('#osmSMLLayoutColumn option').remove();
                $('#osmSMLLayoutColumn').append(
                    $('<option>', { 
                        value: '',
                        text : '<?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutPleaseSelect')?>'
                    })
                );
                $('#osmSMLLayoutColumn').append(
                    $('<option>', { 
                        value: '',
                        text : '<?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutSelectAll')?>'
                    })
                );


                if(tGetLayoutGroup != undefined && tGetLayoutColumn != undefined){

                    //loop gen [Select opion] กลุ่มช่อง
                    for(i=0; i<tGetLayoutGroup.length; i++){
                        $('#osmSMLLayoutGroup').append(
                            $('<option>', { 
                                value: tGetLayoutGroup[i].FTRakCode,
                                text : tGetLayoutGroup[i].FTRakName
                            })
                        );
                    }

                    //loop gen [Select opion] ช่อง
                    for(k=0; k<tGetLayoutColumn.length; k++){
                        $('#osmSMLLayoutColumn').append(
                            $('<option>', { 
                                value: tGetLayoutColumn[k].FNLayNo,
                                text : tGetLayoutColumn[k].FNLayNo
                            })
                        );
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Close Modal
    function JSxSMLCloseModal(){
        JCNxCloseLoading();
    }

</script>