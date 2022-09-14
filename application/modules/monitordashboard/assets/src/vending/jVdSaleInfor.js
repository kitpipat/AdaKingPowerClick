$('ducument').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    $('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });
    $('.selectpicker').selectpicker();
    $("#oetDateFillter").change(function(){
        JSxLoadNewFillter();
    });
    JSxLoadNewFillter();
    $("#ocmListBCH").bind("change",function(){
        JSxMerChantChange();
        
    });
    $("#ocmListMCH").bind("change",function(){
        JSxShopChange();
        
    });
    $("#ocmListSPH").bind("change",function(){
        JSxLoadNewFillter();
    });
    $("#ocmWriteGraphCompare").change(function(){
        var tRoute = "";
        if($(this).val()==1){
            tRoute = "posSaleInforDashboard";
        }else if($(this).val()==2){
            tRoute = "";
        }else if($(this).val()==3){
            tRoute = "VdSaleInforDashboard";
        }else if($(this).val()==4){
            tRoute = "";
        }else if($(this).val()==5){
            tRoute = "";
        }
        JCNxOpenLoading();
        $.ajax({
            url: tRoute,
            type: "GET",
            data: {
                tRoute : $("#ocmWriteGraphCompare").val()
            },
            success : function(ptResult){
                
                $('.odvMainContent').html(ptResult);
                JCNxCloseLoading();
            },
            error : function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
            }
        });
    });
});
function JSxLoadNewFillter(){
    JCNxOpenLoading();
    $.ajax({
        url: "VdSaleInforGetInfor",
        type: "POST",
        data: {
            dDateFilter : $("#oetDateFillter").val(),
            tBCH : $("#ocmListBCH").val(),
            tMCH : $("#ocmListMCH").val(),
            tSPH : $("#ocmListSPH").val()
        },
        success : function(ptResult){
            var tResult = JSON.parse(ptResult);
            if(tResult["aNumSaleBill"]["tFNCountBill"] || tResult["aNumSaleBill"]["tFNSumCountBill"] ||
               tResult["aNumReturnBill"]["tFNCountBill"] || tResult["aNumReturnBill"]["tFNSumCountBill"]){
                var tBufferNum = '';
                $("#olbCountSaleBill").html(tResult["aNumSaleBill"]["tFNCountBill"]);
                if(tResult["aNumSaleBill"]["tFNSumCountBill"]=='.00' || tResult["aNumSaleBill"]["tFNSumCountBill"]=='0'){
                    tBufferNum = '0.00';
                }else{
                    tBufferNum = tResult["aNumSaleBill"]["tFNSumCountBill"];
                }
                $("#olbSumSaleGross").html(tBufferNum);
                $("#olbCountReturnBill").html(tResult["aNumReturnBill"]["tFNCountBill"]);
                if(tResult["aNumReturnBill"]["tFNSumCountBill"]=='.00' || tResult["aNumReturnBill"]["tFNSumCountBill"]=='0'){
                    tBufferNum = '0.00';
                }else{
                    tBufferNum = tResult["aNumReturnBill"]["tFNSumCountBill"];
                }
                $("#olbSumReturnGross").html(tBufferNum);
                $("#odvShowGraph").html(
                    "<iframe src=\""+$("#ohdBaseURL").val()+"VdSaleInforChart\" class=\"xCNWidth-100per xCNHeight-800px\"></iframe>"
                );
            }else{
                $("#olbCountSaleBill").html("0");
                $("#olbSumSaleGross").html("0.00");
                $("#olbCountReturnBill").html("0");
                $("#olbSumReturnGross").html("0.00");
                $("#odvShowGraph").html("");
                $("#odvShowGraph").html(
                    "<iframe src=\""+$("#ohdBaseURL").val()+"VdSaleInforChart\" class=\"xCNWidth-100per xCNHeight-800px\"></iframe>"
                );
            }
            $.ajax({
                url: "VdSaleInforLoadPdtBestSale",
                type: "POST",
                data: {
                    dDateFilter : $("#oetDateFillter").val(),
                    tBCH : $("#ocmListBCH").val(),
                    tMCH : $("#ocmListMCH").val(),
                    tSPH : $("#ocmListSPH").val()
                },
                success : function(ptResult){
                    var tNotFoundData = $('#oetNotFoundDataInDB').val();
                
                    var tResult = JSON.parse(ptResult);
                    var tHtmlPdt = "";
                    if(tResult){
                        tHtmlPdt += "<tr>";
                        for(var nI = 0;nI<tResult.length;nI++){
                            tHtmlPdt += "   <td class=\"text-center\">";
                            tHtmlPdt += "       <div>";
                            tHtmlPdt += "           <img class=\"xWSizeImgPdt\" src=\""+$("#ohdBaseUrl").val()+"/"+JSxSetUrlImgPdtBestSale(tResult[nI]["FTImgObj"])+"\">";
                            tHtmlPdt += "       </div>";
                            tHtmlPdt += "       <div>";
                            tHtmlPdt += "           <label>"+tResult[nI]["FTPdtName"]+"</label>";
                            tHtmlPdt += "       </div>";
                            tHtmlPdt += "       <div>";
                            tHtmlPdt += "           <label>"+parseInt(tResult[nI]["FNXdtSaleQty"])+" "+tResult[nI]["FTPunName"]+"</label>";
                            tHtmlPdt += "       </div>";
                            tHtmlPdt += "   </td>";
                        }
                        tHtmlPdt     +="</tr>";
                    }else{
                        tHtmlPdt += "<tr>";
                        tHtmlPdt += "   <td class=\"text-center\">";
                        tHtmlPdt += "       <label>"+tNotFoundData+"</label>";
                        tHtmlPdt += "   </td>";
                        tHtmlPdt +="</tr>";
                    }
                    $("#otbBestSalePdt").html(tHtmlPdt);
                    $.ajax({
                        url: "VdSaleInforLoadHistoryPosSale",
                        type: "POST",
                        data: {
                            dDateFilter : $("#oetDateFillter").val(),
                            tBCH : $("#ocmListBCH").val(),
                            tMCH : $("#ocmListMCH").val(),
                            tSPH : $("#ocmListSPH").val()
                        },
                        success : function(ptResult){
                            $.ajax({
                                url: "VdSaleInforGetHistoryPosSale",
                                type: "POST",
                                data: {
                                    tPage : 1
                                },
                                success : function(ptResult){
                                    //console.log(ptResult);
                                    var tResult = JSON.parse(ptResult);
                                    var aInfor = tResult["aInfor"];
                                    var tHtml = "";
                                  
                                    if(aInfor){
                                        for(var nI=0;nI<aInfor.length;nI++){
                                            tHtml += "<tr>";
                                            tHtml += "  <td>";
                                            tHtml += "      <label>"+aInfor[nI]["tPosCode"]+"</label>";
                                            tHtml += "  </td>";
                                            tHtml += "  <td>";
                                            tHtml += "      <label>"+aInfor[nI]["tNumBillSale"]+"</label>";
                                            tHtml += "  </td>";
                                            tHtml += "  <td>";
                                            tHtml += "      <label>"+aInfor[nI]["tGrossSale"]+"</label>";
                                            tHtml += "  </td>";
                                            tHtml += "  <td>";
                                            tHtml += "      <a onclick=\"JSxViewVDDetail('"+aInfor[nI]["tPosCode"]+"');\">เพิ่มเติม</a>";
                                            tHtml += "  </td>";
                                            tHtml += "</tr>";
                                        }
                                        var tPage = tResult["tPage"];
                                        var nPerPage = tResult["nPerPage"];
                                        var nPageAll = tResult["nPageAll"];
                                        var tPagination   = "<div class=\"xWPageProduct btn-toolbar pull-right\">";
                                        var tDisabledLeft = '';
                                        if(tPage == 1){ 
                                            tDisabledLeft = 'disabled'; 
                                        }
                                        tPagination     += " <button onclick=\"JSxSelectPaginationPosHis('previous');\" data-page=\"previous\" class=\"btn btn-white btn-sm xCNBtnPagenation\" "+tDisabledLeft+">";
                                        tPagination     += "    <i class=\"fa fa-chevron-left f-s-14 t-plus-1\"></i>";
                                        tPagination     += " </button>";
                                        var tActive = "";
                                        var tDisPageNumber = "";
                                        for(var nI=Math.max(tPage-2, 1); nI<=Math.max(0, Math.min(nPageAll,tPage+2)); nI++){
                                            if(tPage == nI){ 
                                                tActive = 'active'; 
                                                tDisPageNumber = 'disabled';
                                            }else{ 
                                                tActive = '';
                                                tDisPageNumber = '';
                                            }
                                            tPagination += " <button onclick=\"JSxSelectPaginationPosHis('"+nI+"');\" data-page=\""+nI+"\" type=\"button\" class=\"btn xCNBtnPagenation xCNBTNNumPagenation "+tActive+"\" "+tDisPageNumber+">"+nI+"</button>";
                                        }
                                        var tDisabledRight = '';
                                        if(tPage >= nPageAll){  
                                            tDisabledRight = 'disabled'; 
                                        }else{  
                                            tDisabledRight = '';  
                                        }
                                        tPagination     += " <button onclick=\"JSxSelectPaginationPosHis('next');\" data-page=\"next\" class=\"btn btn-white btn-sm xCNBtnPagenation\" "+tDisabledRight+">";
                                        tPagination     += "   <i class=\"fa fa-chevron-right f-s-14 t-plus-1\"></i>";
                                        tPagination     += " </button>";
                                        tPagination     += "</div>";
                                        $("#odvPaginationTable").html(tPagination);
                                    }else{
                                        // tVenDodata         = language('dashboard/vending', 'tVenDodata');
                                        tHtml += "<tr>";
                                        tHtml += "  <td colspan=\"4\" class=\"text-center\">";
                                        tHtml += " <label>"+tNotFoundData+"</label>";
                                        tHtml += "  </td>";
                                        tHtml += "</tr>";
                                    }
                                    $("#otbInforSaleVD").html(tHtml);


                                    
                                    JCNxCloseLoading();
                                },
                                error : function(xhr, status, error) {
                                    var err = eval("(" + xhr.responseText + ")");
                                    alert(err.Message);
                                }
                            });
                        },
                        error : function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            alert(err.Message);
                        }
                    });
                },
                error : function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            });
        },
        error : function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
        }
    });

}
function JSxSelectPaginationPosHis(pnPage){
    JCNxOpenLoading();
    var tPageCheck;
    if(pnPage=='previous'){
        tPageCheck = parseInt($("button.xCNBtnPagenation.xCNBTNNumPagenation.active").attr("data-page"))-1;
    }else if(pnPage=='next'){
        tPageCheck = parseInt($("button.xCNBtnPagenation.xCNBTNNumPagenation.active").attr("data-page"))+1;
    }else{
        tPageCheck = pnPage;
    }
    $.ajax({
        url: "VdSaleInforGetHistoryPosSale",
        type: "POST",
        data: {
            tPage : tPageCheck
        },
        success : function(ptResult){
            var tNotFoundData = $('#oetNotFoundDataInDB').val();
            var tResult = JSON.parse(ptResult);
            var aInfor = tResult["aInfor"];
            var tHtml = "";
            
            if(aInfor){
                for(var nI=0;nI<aInfor.length;nI++){
                    tHtml += "<tr>";
                    tHtml += "  <td>";
                    tHtml += "      <label>"+aInfor[nI]["tPosCode"]+"</label>";
                    tHtml += "  </td>";
                    tHtml += "  <td>";
                    tHtml += "      <label>"+aInfor[nI]["tNumBillSale"]+"</label>";
                    tHtml += "  </td>";
                    tHtml += "  <td>";
                    tHtml += "      <label>"+aInfor[nI]["tGrossSale"]+"</label>";
                    tHtml += "  </td>";
                    tHtml += "  <td>";
                    tHtml += "      <a onclick=\"JSxViewVDDetail('"+aInfor[nI]["tPosCode"]+"');\">เพิ่มเติม</a>";
                    tHtml += "  </td>";
                    tHtml += "</tr>";
                }
                var tPage = tResult["tPage"];
                var nPerPage = tResult["nPerPage"];
                var nPageAll = tResult["nPageAll"];
                var tPagination   = "<div class=\"xWPageProduct btn-toolbar pull-right\">";
                var tDisabledLeft = '';
                if(tPage == 1){ 
                    tDisabledLeft = 'disabled'; 
                }
                tPagination     += " <button onclick=\"JSxSelectPaginationPosHis('previous');\" data-page=\"previous\" class=\"btn btn-white btn-sm xCNBtnPagenation\" "+tDisabledLeft+">";
                tPagination     += "    <i class=\"fa fa-chevron-left f-s-14 t-plus-1\"></i>";
                tPagination     += " </button>";
                var tActive = "";
                var tDisPageNumber = "";
                for(var nI=Math.max(tPage-2, 1); nI<=Math.max(0, Math.min(nPageAll,tPage+2)); nI++){
                    if(tPage == nI){ 
                        tActive = 'active'; 
                        tDisPageNumber = 'disabled';
                    }else{ 
                        tActive = '';
                        tDisPageNumber = '';
                    }
                    tPagination += " <button onclick=\"JSxSelectPaginationPosHis('"+nI+"');\" data-page=\""+nI+"\" type=\"button\" class=\"btn xCNBtnPagenation xCNBTNNumPagenation "+tActive+"\" "+tDisPageNumber+">"+nI+"</button>";
                }
                var tDisabledRight = '';
                if(tPage >= nPageAll){  
                    tDisabledRight = 'disabled'; 
                }else{  
                    tDisabledRight = '';  
                }
                tPagination     += " <button onclick=\"JSxSelectPaginationPosHis('next');\" data-page=\"next\" class=\"btn btn-white btn-sm xCNBtnPagenation\" "+tDisabledRight+">";
                tPagination     += "   <i class=\"fa fa-chevron-right f-s-14 t-plus-1\"></i>";
                tPagination     += " </button>";
                tPagination     += "</div>";
                $("#odvPaginationTable").html(tPagination);
            }else{
                tHtml += "<tr>";
                tHtml += "  <td colspan=\"4\" class=\"text-center\">";
                tHtml += "      <label>"+tNotFoundData+"</label>";
                tHtml += "  </td>";
                tHtml += "</tr>";
            }
            $("#otbInforSaleVD").html(tHtml);
            JCNxCloseLoading();
        },
        error : function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
        }
    });
}

function JSxViewVDDetail(tPosCode){
    JCNxOpenLoading();
    $.ajax({
        url: "VdSaleInforVDDetail",
        type: "POST",
        data: {
            dDateFilter : $("#oetDateFillter").val(),
            tBCH : $("#ocmListBCH").val(),
            tMCH : $("#ocmListMCH").val(),
            tSPH : $("#ocmListSPH").val(),
            tPOS : tPosCode
        },
        success : function(ptResult){
            
            $('.odvMainContent').html(ptResult);
            JCNxCloseLoading();
        },
        error : function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
        }
    });
}
function JSxSetUrlImgPdtBestSale(tFTImgObj){
    var tFTImgObjBuffer = '';
    if(tFTImgObj){
        tFTImgObjBuffer = tFTImgObj.substring(tFTImgObj.indexOf("application/"));
    }else{
        tFTImgObjBuffer = 'application/modules/monitordashboard/assets/images/NoPic.png';
    }
    return tFTImgObjBuffer;
}
function JSxMerChantChange(){
    $("#ocmListMCH").unbind("change");
    $("#ocmListSPH").unbind("change");
    $.ajax({
        url: "VdSaleInforGetMerChant",
        type: "POST",
        data:{
            tBranch : $("#ocmListBCH").val()
        },
        success : function(ptResult){
            var tVenAllbusgroup = $('#oetAllBusGroup').val();
            var tVenAllstores = $('#oetAllShopVending').val();
            var tResult = JSON.parse(ptResult);
            if(tResult){
                var tHtml = "<select class=\"xCNWidth-100per selectpicker form-control\" tabindex=\"-98\" id=\"ocmListMCH\">";
                tHtml += "      <option value=\"0\">"+tVenAllbusgroup+"</option>";
                for(var nI = 0;nI<tResult.length;nI++){
                    tHtml += "  <option value=\""+tResult[nI]["FTMerCode"]+"\"";
                    if(nI == 0){
                        tHtml += " selected";
                    }
                    tHtml += "  >"+tResult[nI]["FTMerName"]+"</option>";
                }
                tHtml += "   </select>";
                $("#odvListMCH").html(tHtml);
                $('.selectpicker').selectpicker();
                $.ajax({
                    url: "VdSaleInforGetShop",
                    type: "POST",
                    data:{
                        tBranch : $("#ocmListBCH").val(),
                        tMerChant : tResult[0]["FTMerCode"]
                    },
                    success : function(ptResult){
                       var tResult = JSON.parse(ptResult);
                       if(tResult){
                            var tHtml = "<select class=\"xCNWidth-100per selectpicker form-control\" tabindex=\"-98\" id=\"ocmListSPH\">";
                            tHtml += "      <option value=\"0\">"+tVenAllstores+"</option>";
                            for(var nI = 0;nI<tResult.length;nI++){
                                tHtml += "  <option value=\""+tResult[nI]["FTShpCode"]+"\"";
                                if(nI == 0){
                                    tHtml += " selected";
                                }
                                tHtml += "  >"+tResult[nI]["FTShpName"]+"</option>";
                            }
                            tHtml += "   </select>";
                            $("#odvListSPH").html(tHtml);
                            $('.selectpicker').selectpicker();
                       }else{
                            var tHtml = "<select class=\"xCNWidth-100per selectpicker form-control\" tabindex=\"-98\" id=\"ocmListSPH\">";
                            tHtml += "      <option value=\"0\">"+tVenAllstores+"</option>";
                            tHtml += "   </select>";
                            $("#odvListSPH").html(tHtml);
                            $('.selectpicker').selectpicker();
                       }
                       JSxLoadNewFillter();
                        $("#ocmListMCH").bind("change",function(){
                            JSxShopChange();
                        });
                        $("#ocmListSPH").bind("change",function(){
                            JSxLoadNewFillter();
                        });
                    },
                    error : function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        alert(err.Message);
                    }
                });
            }else{
                var tHtml = "<select class=\"xCNWidth-100per selectpicker form-control\" tabindex=\"-98\" id=\"ocmListMCH\">";
                tHtml += "       <option value=\"0\">"+tVenAllbusgroup+"</option>";
                tHtml += "   </select>";
                $("#odvListMCH").html(tHtml);
                var tHtml = "<select class=\"xCNWidth-100per selectpicker form-control\" tabindex=\"-98\" id=\"ocmListSPH\">";
                tHtml += "      <option value=\"0\"";
                if(nI == 0){
                    tHtml += "selected";
                }
                tHtml += "  >"+tVenAllstores+"</option>";
                tHtml += "   </select>";
                $("#odvListSPH").html(tHtml);
                $('.selectpicker').selectpicker();
                JSxLoadNewFillter();
                $("#ocmListMCH").bind("change",function(){
                    JSxShopChange();
                });
                $("#ocmListSPH").bind("change",function(){
                    JSxLoadNewFillter();
                });
            }
            
            
        },
        error : function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
        }
    });
}
function JSxShopChange(){
    $("#ocmListSPH").unbind("change");
    $.ajax({
        url: "VdSaleInforGetShop",
        type: "POST",
        data:{
            tBranch : $("#ocmListBCH").val(),
            tMerChant : $("#ocmListMCH").val()
        },
        success : function(ptResult){
            var tVenAllstores = $('#oetAllShopVending').val();
           var tResult = JSON.parse(ptResult);
           if(tResult){
                var tHtml = "<select class=\"xCNWidth-100per selectpicker form-control\" tabindex=\"-98\" id=\"ocmListSPH\">";
                tHtml += "      <option value=\"0\">"+tVenAllstores+"</option>";
                for(var nI = 0;nI<tResult.length;nI++){
                    tHtml += "  <option value=\""+tResult[nI]["FTShpCode"]+"\"";
                    if(nI == 0){
                        tHtml += " selected";
                    }
                    tHtml += "  >"+tResult[nI]["FTShpName"]+"</option>";
                }
                tHtml += "   </select>";
                $("#odvListSPH").html(tHtml);
                $('.selectpicker').selectpicker();
           }else{
                var tHtml = "<select class=\"xCNWidth-100per selectpicker form-control\" tabindex=\"-98\" id=\"ocmListSPH\">";
                tHtml += "      <option value=\"0\">"+tVenAllstores+"</option>";
                tHtml += "   </select>";
                $("#odvListSPH").html(tHtml);
                $('.selectpicker').selectpicker();
           }
           JSxLoadNewFillter();
            $("#ocmListSPH").bind("change",function(){
                JSxLoadNewFillter();
            });
        },
        error : function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
        }
    });
}