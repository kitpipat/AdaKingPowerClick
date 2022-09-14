<script type="text/javascript">

    $(document).ready(function(){
        localStorage.removeItem('LocalItemData');
        JSxCheckPinMenuClose();
        JSxHisBuyLicesnseNavDefault();
        JSvCallPageHisBuyLicesnse();
    });


    //control เมนู
    function JSxHisBuyLicesnseNavDefault() {
        try{
            $('#oliHisBuyLicenseTitle').show();
            $('#oliHisBuyLicenseTitleReview').hide();
        }catch(err){
            console.log('JSxHisBuyLicesnseNavDefault Error: ', err);
        }
    }

    //Page List
    function JSvCallPageHisBuyLicesnse(){
        $.ajax({
            type    : "POST",
            url     : "HisBuyLicenseList",
            data    : { },
            cache   : false,
            timeout : 0,
            success : function(tResult){
                $('#odvContentPageHisBuyLicense').html(tResult);
                JSvHisBuyDataTable(1);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Page Datatable
    function JSvHisBuyDataTable(pnPage){
        var oAdvanceSearch = JSoHisBuyGetAdvanceSearchData();
        var tSearchAll      = $('#oetSearchAll').val();
        var nPageCurrent    = pnPage;
        if (nPageCurrent    == undefined || nPageCurrent == '') {
            nPageCurrent    = '1';
        }

        $.ajax({
            type    : "POST",
            url     : "HisBuyLicenseDataTable",
            data: {
                tSearchAll      : tSearchAll,
                nPageCurrent    : nPageCurrent,
                oAdvanceSearch  : oAdvanceSearch
            },
            cache   : false,
            timeout : 0,
            success : function(tResult){
                $('#ostDataHisBuyLicenseList').html(tResult);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Click page
    function JSxHisBuyClickPage(ptType,ptPage) {
        try{
            var nPageCurrent = '';
            var nPageNew;
            switch (ptType) {
                case 'Fisrt': //กดหน้าแรก
                    nPageCurrent = 1;
                    break;
                case 'next': //กดปุ่ม Next
                    $('.xWBtnNext').addClass('disabled');
                    nPageOld = $('.xWPageBuyLicense .active').text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                case 'previous': //กดปุ่ม Previous
                    nPageOld = $('.xWPageBuyLicense .active').text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                case 'Last': //กดหน้าสุดท้าย
                    nPageCurrent = ptPage;
                    break;
                default:
                    nPageCurrent = ptPage;
            }
            JSvHisBuyDataTable(nPageCurrent);
        }catch(err){
            console.log('JSxHisBuyClickPage Error: ', err);
        }
    }

    //Clear value ในข้อมูลขั้นสูง
    function JSxHisBuyClearSearchData() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            try {
                $("#oetSearchAll").val("");
                $("#oetSearchDocDateFrom").val("");
                $("#oetSearchDocDateTo").val("");
                $('#oetCstName , #oetCstCode').val("");
                $(".xCNDatePicker").datepicker("setDate", null);
                $(".selectpicker").val("0").selectpicker("refresh");
                JSvHisBuyDataTable(1);
            } catch (err) {
                console.log("JSxHisBuyClearSearchData Error: ", err);
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //ฟังก์ชั่น get ค่า INPUT Search
    function JSoHisBuyGetAdvanceSearchData() {
        var oAdvanceSearchData = {
            tSearchAll          : $("#oetSearchAll").val(),
            tSearchDocDateFrom  : $("#oetSearchDocDateFrom").val(),
            tSearchDocDateTo    : $("#oetSearchDocDateTo").val(),
            tSearchCustomer     : $("#oetCstCode").val(),
            tSearchStaTypeDoc   : $("#ocmStaTypeDoc").val(),
            tSearchStaPayment   : $("#ocmStaPayment").val()
        };
        return oAdvanceSearchData;
    }

    //Call Page Preview
    function JSvCallPageHisBuyPreview(ptDocumentNumber){
        try{
            JCNxOpenLoading();
            $.ajax({
                type    : "POST",
                url     : "HisBuyLicensePagePreview",
                data    : { ptDocumentNumber : ptDocumentNumber },
                cache   : false,
                timeout : 0,
                success : function(tResult) {
                    $('#odvContentPageHisBuyLicense').html(tResult);
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }catch(err){
            console.log('JSvCallPageHisBuyPreview Error: ', err);
        }
    }


</script>