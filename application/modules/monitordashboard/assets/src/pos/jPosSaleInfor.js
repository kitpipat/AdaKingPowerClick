$('ducument').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    $('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });
    $('.selectpicker').selectpicker();
    JSxLoadNewFillter();
    $("#oetDateFillter,#ocmTypeWriteGraph,#ocmTypeCalDisplayGraph").change(function(){
        JSxLoadNewFillter();
    });
    //JSxTestMQ();
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
function JSxSetUrlImgPdtBestSale(tFTImgObj){
    var tFTImgObjBuffer = '';
    if(tFTImgObj){
        tFTImgObjBuffer = tFTImgObj.substring(tFTImgObj.indexOf("application/"));
    }else{
        tFTImgObjBuffer = 'application/modules/monitordashboard/assets/images/NoPic.png';
    }
    return tFTImgObjBuffer;
}
function JSxLoadNewFillter(){
    JCNxOpenLoading();
    $.ajax({
        url: "posSaleInforGetInfor",
        type: "POST",
        data: {
            tConditionWritGraph : $("#ohdConditionWritGraph").val(),
            tTypeWriteGraph : $("#ocmTypeWriteGraph").val(),
            tWriteGraphCompare : $("#ocmWriteGraphCompare").val(),
            dDateFilter : $("#oetDateFillter").val(),
            tTypeCalDisplayGraph : $("#ocmTypeCalDisplayGraph").val()
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
                    "<iframe src=\""+$("#ohdBaseURL").val()+"posSaleInforChart\" class=\"xCNWidth-100per xCNHeight-400px\"></iframe>"
                );
            }else{
                $("#olbCountSaleBill").html("0");
                $("#olbSumSaleGross").html("0.00");
                $("#olbCountReturnBill").html("0");
                $("#olbSumReturnGross").html("0.00");
                $("#odvShowGraph").html("");
                $("#odvShowGraph").html(
                    "<iframe src=\""+$("#ohdBaseURL").val()+"posSaleInforChart\" class=\"xCNWidth-100per xCNHeight-400px\"></iframe>"
                );
            }
            JCNxCloseLoading();
        },
        error : function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
        }
    });
    $.ajax({
        url: "posSaleInforLoadPdtBestSale",
        type: "POST",
        data: {
            dDateFilter : $("#oetDateFillter").val()
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
        },
        error : function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
        }
    });
}
function JSxSearchControlGraph(pelement){
    $($($(pelement).parent()).children()).removeClass("xWBtnControlSearchActive");
    $(pelement).addClass("xWBtnControlSearchActive");
    $("#ohdConditionWritGraph").val($(pelement).attr("data-value"));
    JSxLoadNewFillter();
}

// function JSxTestMQ(){
//     var poMqConfig = {
//         tQName: "TEST_DASHBOARD",
//         host: "ws://202.44.55.96:15674/ws",
//         username: "Admin",
//         password: "Admin",
//         vHost: "/"
//     };
//     var oClient = Stomp.client(poMqConfig.host);
//     var on_connect = function (x) {
//         oClient.subscribe(poMqConfig.tQName, function (res) {
//             try {
//                 console.log(res.body);
//                 alert("ทดสอบ");
//             } catch (err) {
//                 console.log("Listening rabbit mq server: ", err);
//             }
//         });
//     };
//     var on_error = function () {
//         console.log('error');
//     };
//     oClient.connect(poMqConfig.username, poMqConfig.password, on_connect, on_error, poMqConfig.vHost);
    
    
// }