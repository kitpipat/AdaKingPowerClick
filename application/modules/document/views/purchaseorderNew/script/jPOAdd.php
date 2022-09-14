
<script>

    $("document").ready(function () {
        JSvDPOLoadPdtDataTableTmp();

        $('.selectpicker').selectpicker('refresh');
    });

    //โหลดตาราง Tmp
    function JSvDPOLoadPdtDataTableTmp(){
        $.ajax({
            type    : "POST",
            url     : "docPOLoadPDTTmp",
            cache   : false,
            timeout : 0,
            success: function(oResult) {
                var aReturnData = JSON.parse(oResult);
                if(aReturnData['nStaEvent'] == '1') {
                    $('#odvPODataPdtTableDTTemp').html(aReturnData['tTableHtml']);
                    JCNxCloseLoading();
                }else{
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxTRNResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //เลือกสินค้า
    $('#obtPODocBrowsePdt').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            JCNvPIBrowsePdt();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    //เลือกสินค้า
    function JCNvPIBrowsePdt(){
        // var aMulti = [];
        // $.ajax({
        //     type    : "POST",
        //     url     : "BrowseDataPDT",
        //     data    : {
        //         Qualitysearch   : [],
        //         PriceType       : ["Cost","tCN_Cost","Company","1"],
        //         SelectTier      : ["Barcode"],
        //         ShowCountRecord : 10,
        //         NextFunc        : "FSvPOAddPdtIntoDocDTTemp",
        //         ReturnType      : "M",
        //         SPL             : [$("#oetPIFrmSplCode").val(),$("#oetPIFrmSplCode").val()],
        //         BCH             : [$("#oetPIFrmBchCode").val(),$("#oetPIFrmBchCode").val()],
        //         MCH             : [$("#oetPIFrmMerCode").val(),$("#oetPIFrmMerCode").val()],
        //         SHP             : [$("#oetPIFrmShpCode").val(), $("#oetPIFrmShpCode").val()]
        //     },
        //     cache: false,
        //     timeout: 0,
        //     success: function(tResult){
        //         $("#odvModalDOCPDT").modal({backdrop: "static", keyboard: false});
        //         $("#odvModalDOCPDT").modal({show: true});
        //         //remove localstorage
        //         localStorage.removeItem("LocalItemDataPDT");
        //         $("#odvModalsectionBodyPDT").html(tResult);
        //         $("#odvModalDOCPDT #oliBrowsePDTSupply").css('display','none');
        //     },
        //     error: function (jqXHR,textStatus,errorThrown){
        //         JCNxResponseError(jqXHR,textStatus,errorThrown);
        //     }
        // });
        $('#olbDisChgHD').text('-100%,-50.95,-50.276%');
        var     jsontest = '[{"pnPdtCode":"00012","ptPunCode":"00004","ptBarCode":"ca2020010006","packData":{"SHP":null,"BCH":null,"PDTCode":"00012","PDTName":"ขนม_06","PUNCode":"00004","Barcode":"ca2020010006","PUNName":"ชิ้น","IMAGE":"D:/xampp/htdocs/Moshi-Moshi/application/modules/product/assets/systemimg/product/00012/Img200410093345UOURBXZX.jpg","Price":500,"LOCSEQ":"","AlwDis":1,"AlwVat":1,"Vat":7}},';
                jsontest += '{"pnPdtCode":"DIM0019060A-005","ptPunCode":"EA","ptBarCode":"123456","packData":{"SHP":null,"BCH":null,"PDTCode":"DIM0019060A-005","PDTName":"น้ำเปล่า A","PUNCode":"EA","Barcode":"123456","PUNName":"EA","IMAGE":null,"Price":100,"LOCSEQ":"","AlwDis":1,"AlwVat":0,"Vat":8}},';
                jsontest += '{"pnPdtCode":"DIM0019060A-004","ptPunCode":"EA","ptBarCode":"123457","packData":{"SHP":null,"BCH":null,"PDTCode":"DIM0019060A-004","PDTName":"น้ำเปล่า B","PUNCode":"EA","Barcode":"1234567","PUNName":"EA","IMAGE":null,"Price":200,"LOCSEQ":"","AlwDis":1,"AlwVat":1,"Vat":8}},';
                jsontest += '{"pnPdtCode":"DIM0019060A-003","ptPunCode":"EA","ptBarCode":"123455","packData":{"SHP":null,"BCH":null,"PDTCode":"DIM0019060A-003","PDTName":"น้ำเปล่า C","PUNCode":"EA","Barcode":"1234568","PUNName":"EA","IMAGE":null,"Price":200,"LOCSEQ":"","AlwDis":1,"AlwVat":1,"Vat":7}},';
                jsontest += '{"pnPdtCode":"DIM0019060A-001","ptPunCode":"EA","ptBarCode":"123451","packData":{"SHP":null,"BCH":null,"PDTCode":"DIM0019060A-001","PDTName":"น้ำเปล่า E","PUNCode":"EA","Barcode":"1234561","PUNName":"EA","IMAGE":null,"Price":50,"LOCSEQ":"","AlwDis":1,"AlwVat":1,"Vat":4}},';
                jsontest += '{"pnPdtCode":"DIM0019060A-002","ptPunCode":"EA","ptBarCode":"123454","packData":{"SHP":null,"BCH":null,"PDTCode":"DIM0019060A-002","PDTName":"น้ำเปล่า D","PUNCode":"EA","Barcode":"5155555","PUNName":"EA","IMAGE":null,"Price":0,"LOCSEQ":"","AlwDis":0,"AlwVat":0,"Vat":7}}]';
        FSvPOAddPdtIntoDocDTTemp(jsontest);
    }

    //************************************************************************************************************************** */

    //หลังจากเลือกสินค้าเสร็จแล้ว
    function FSvPOAddPdtIntoDocDTTemp(ptPdtData){
        JCNxCloseLoading();
        var aPackData = JSON.parse(ptPdtData);

        var tCheckIteminTable = $('#otbTablePDTTmp tbody tr td').hasClass('xCNTextNotfoundDataPdtTable');
        if(tCheckIteminTable == true){
            $('#otbTablePDTTmp tbody').html('');
        }

        var nLen    = aPackData.length;
        var tHTML   = '';
        var nKey    = parseInt($('#otbTablePDTTmp tbody tr').length) + parseInt(1);
        for(var i=0; i<nLen; i++){

            var oData           = aPackData[i];
            var oResult         = oData.packData;
            var tBarCode        = oResult.Barcode;          //บาร์โค้ด
            var tProductCode    = oResult.PDTCode;          //รหัสสินค้า
            var tProductName    = oResult.PDTName;          //ชื่อสินค้า
            var tUnitName       = oResult.PUNName;          //ชื่อหน่วยสินค้า
            var nPrice          = oResult.Price;            //ราคา
            var nGrandTotal     = (nPrice * 1).toFixed(2);  //ราคารวม
            var nAlwDiscount    = oResult.AlwDis;           //อนุญาติคำนวณลด
            var nAlwVat         = oResult.AlwVat;           //อนุญาติคำนวณภาษี
            var nVat            = oResult.Vat;              //ภาษี

            var tDuplicate = $('#otbTablePDTTmp tbody tr').hasClass('otr'+tProductCode+tBarCode);
            if(tDuplicate == true){
                //ถ้าสินค้าซ้ำ ให้เอา Qty +1
                var nValOld     = $('.otr'+tProductCode+tBarCode).find('.xCNQty').val();
                var nNewValue   = parseInt(nValOld) + parseInt(1);
                $('.otr'+tProductCode+tBarCode).find('.xCNQty').val(nNewValue);

                var nGrandOld   = $('.otr'+tProductCode+tBarCode).find('.xCNPrice').val();
                var nGrand      = parseInt(nNewValue) * parseFloat(nGrandOld);
                var nSeqOld     = $('.otr'+tProductCode+tBarCode).find('.xCNPrice').attr('data-seq');
                $('#ospGrandTotal'+nSeqOld).text(numberWithCommas(nGrand.toFixed(2)));
            }else{
                //ถ้าสินค้าไม่ซ้ำ ก็บวกเพิ่มต่อเลย
                if(nAlwDiscount == 1){ //อนุญาติลด
                    var oAlwDis = '<div>';
                        oAlwDis += '<button class="xCNBTNPrimeryDisChgPlus" onclick="JCNvDisChgCallModalDT(this)" type="button">+</button>';
                        oAlwDis += '<label class="xWDisChgDTTmp" id="xWDisChgDTTmp'+nKey+'">&nbsp;</label>';
                        oAlwDis += '</div>';
                }else{
                    var oAlwDis = 'ไม่อนุญาติให้ส่วนลด';
                }

                //ราคา
                var oPrice = '<div class="xWEditInLine'+nKey+'">';
                    oPrice += '<input ';
                    oPrice += 'type="text" ';
                    oPrice += 'class="xCNPrice form-control xCNInputNumericWithDecimal xCNPdtEditInLine text-right xWValueEditInLine'+nKey+' "';
                    oPrice += 'id="ohdPrice'+nKey+'" ';
                    oPrice += 'name="ohdPrice'+nKey+'" '; 
                    oPrice += 'maxlength="10" '; 
                    oPrice += 'data-alwdis='+nAlwDiscount+' ';
                    oPrice += 'data-seq='+nKey+' ';
                    oPrice += 'value="'+nPrice+'" >';
                    oPrice += '</div>';  

                //จำนวน
                var oQty = '<div class="xWEditInLine'+nKey+'">';
                    oQty += '<input ';
                    oQty += 'type="text" ';
                    oQty += 'class="xCNQty form-control xCNInputNumericWithDecimal xCNPdtEditInLine text-right xWValueEditInLine'+nKey+' "';
                    oQty += 'id="ohdQty'+nKey+'" ';
                    oQty += 'name="ohdQty'+nKey+'" '; 
                    oQty += 'data-seq='+nKey+' ';
                    oQty += 'maxlength="10" '; 
                    oQty += 'value="'+1+'" >';
                    oQty += '</div>';  

                tHTML += '<tr class="otr'+tProductCode+''+tBarCode+'" data-alwvat="'+nAlwVat+'" data-vat="'+nVat+'" data-key="'+nKey+'" >';
                tHTML += '<td>'+'x'+'</td>';
                tHTML += '<td>'+nKey+'</td>';
                tHTML += '<td>'+tProductCode+'</td>';
                tHTML += '<td>'+tProductName+'</td>';
                tHTML += '<td>'+tBarCode+'</td>';
                tHTML += '<td>'+tUnitName+'</td>';
                tHTML += '<td class="otdQty">'+oQty+'</td>';
                tHTML += '<td class="otdPrice">'+oPrice+'</td>';
                tHTML += '<td>'+oAlwDis+'</td>';
                tHTML += '<td class="text-right"><span id="ospGrandTotal'+nKey+'">'+nGrandTotal+'</span>';
                tHTML += '    <span id="ospnetAfterHD'+nKey+'" style="display: none;"></span>';
                tHTML += '</td>';    
                tHTML += '<td><span>[x]</span></td>';
                tHTML += '</tr>';
                nKey++;
            }
        }

        //สร้างตาราง
        $('#otbTablePDTTmp tbody').append(tHTML);
        JSxRendercalculate();
        JSxEditQtyAndPrice();
    }

    //คำนวณจำนวนเงินจากตางราง DT
    function JSxRendercalculate(){
        var nTotal                  = 0;
        var nTotal_alwDiscount      = 0;

        $(".xCNPrice").each(function(e) {
            var nSeq   = $(this).attr('data-seq');
            var nValue = $('#ospGrandTotal'+nSeq).text();
            var nValue = nValue.replace(/,/g, '');

            nTotal = parseFloat(nTotal) + parseFloat(nValue);
            if($(this).attr('data-alwdis') == 1){
                nTotal_alwDiscount = parseFloat(nTotal_alwDiscount) + parseFloat(nValue);
            };
        });

        //จำนวนเงินรวม
        $('#olbSumFCXtdNet').text(numberWithCommas(parseFloat(nTotal).toFixed(2)));

        //จำนวนเงินรวม ที่อนุญาติลด
        $('#olbSumFCXtdNetAlwDis').val(nTotal_alwDiscount);

        //คิดส่วนลดใหม่
        var tChgHD          = $('#olbDisChgHD').text();
        var nNewDiscount    = 0;
        if(tChgHD != '' || tChgHD != null){ //มีส่วนลดท้ายบิล
            var aChgHD      = tChgHD.split(",");
            var nNetAlwDis  = $('#olbSumFCXtdNetAlwDis').val();
            for(var i=0; i<aChgHD.length; i++){
                // console.log('ยอดที่มันเอาไปคิดทำส่วนลด : ' + nNetAlwDis);
                if(aChgHD[i] != '' || aChgHD[i] != null){
                    if(aChgHD[i].search("%") == -1){ 
                        //ไม่เจอ = ต้องคำนวณแบบบาท
                        var nVal        = aChgHD[i];
                        var nCal        = (parseFloat(nNetAlwDis) + parseInt(nVal));
                        // console.log('ลดเเล้วเหลือ : ' + nCal)
                        nNewDiscount    = parseFloat(nCal);
                        nNetAlwDis      = nNewDiscount;
                        nNewDiscount    = 0;
                    }else{ 
                        //เจอ = ต้องคำนวณแบบ %
                        var nPercent    = aChgHD[i];
                        var nPercent    = nPercent.replace("%", "");
                        var tCondition  = nPercent.substr(0, 1);
                        var nValPercent = Math.abs(nPercent);
                        if(tCondition == '-'){
                            var nCal        = parseFloat(nNetAlwDis) - ((parseFloat(nNetAlwDis) * nValPercent) / 100);
                            if(nCal == 0){
                                var nCal        = -nNetAlwDis;
                            }else{
                                var nCal        = nCal;
                            }
                        }else if(tCondition == '+'){
                            var nCal        = parseFloat(nNetAlwDis) + ((parseFloat(nNetAlwDis) * nValPercent) / 100);
                        }

                        // console.log('ลดเเล้วเหลือ : ' + nCal);
                        nNewDiscount    = parseFloat(nCal);
                        nNetAlwDis      = nNewDiscount;
                        nNewDiscount    = 0;
                    }
                }
            }
            $('#olbSumFCXtdAmt').text(numberWithCommas(parseFloat(nNetAlwDis).toFixed(2)));

            //Prorate
            JSxProrate();
        }

        //ยอดรวมหลังลด/ชาร์จ
        var nTotalFisrt = $('#olbSumFCXtdNet').text().replace(/,/g, '');
        var nDiscount   = $('#olbSumFCXtdAmt').text().replace(/,/g, '');
        var nResult     = parseFloat(Math.abs(nTotalFisrt))+parseFloat(nDiscount);
        $('#olbSumFCXtdNetAfHD').text(numberWithCommas(parseFloat(nResult).toFixed(2)));

        //คำนวณภาษี
        JSxCalculateVat();
    }

    //เเก้ไขจำนวน และ ราคา
    function JSxEditQtyAndPrice(){

        //แก้ไขจำนวน
        $('.xCNQty').change(function(e){
            var nValue      = $(this).val();
            var nSeq        = $(this).attr('data-seq');
            var nNewValue   = parseInt(nValue) * parseFloat($('#ohdPrice'+nSeq).val());
            $('#ospGrandTotal'+nSeq).text(numberWithCommas(nNewValue.toFixed(2)));
            JSxRendercalculate();
        });

        //แก้ไขราคา
        $('.xCNPrice').change(function(e){
            var nValue      = $(this).val();
            var nSeq        = $(this).attr('data-seq');
            var nNewValue   = parseFloat(nValue) * parseInt($('#ohdQty'+nSeq).val());
            $('#ospGrandTotal'+nSeq).text(numberWithCommas(nNewValue.toFixed(2)));
            JSxRendercalculate();
        });
    }

    //พวกตัวเลขใส่ comma ให้มัน
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }

    //Prorate ส่วนลดเฉลี่ยท้ายบิล
    function JSxProrate(){
        //pnSumDiscount         : ส่วนลดท้ายบิลทั้งหมด
        //pnSum                 : ราคาทั้งหมดหลังหักส่วนลดต่อชิ้น
        var pnSumDiscount       = $('#olbSumFCXtdAmt').text().replace(/,/g, '');
        var pnSum               = $('#olbSumFCXtdNetAlwDis').val().replace(/,/g, '');
        var length              = $(".xCNPrice").length;
        var nSumProrate         = 0;
        var nDifferenceProrate  = 0;
        $(".xCNPrice").each(function(index,e) {
            var nSeq    = $(this).attr('data-seq');
            var nValue  = $('#ospGrandTotal'+nSeq).text();
            var nValue  = nValue.replace(/,/g, '');
           var nProrate = (pnSumDiscount * nValue) / pnSum;

           //ผลรวม prorate ที่เหลือต้องเอาไป + ตัวสุดท้าย
           nSumProrate     = parseFloat(nSumProrate) + parseFloat(nProrate);
           if(index === (length - 1)){
                nDifferenceProrate = pnSumDiscount - nSumProrate;
                nProrate = nProrate + nDifferenceProrate;
            }else{
                nProrate = nProrate;
            }

           $('#ospnetAfterHD'+nSeq).text(numberWithCommas(Math.abs(parseFloat(nProrate).toFixed(2))));
        });    
    }

    //คำนวณภาษี
    $('#ocmVatInOrEx').change(function (){ JSxCalculateVat(); });  
    function JSxCalculateVat(){
        var tVatList  = '';
        var aVat      = [];
        $('#otbTablePDTTmp tbody tr').each(function(){
            var nAlwVat  = $(this).attr('data-alwvat');
            var nVat     = parseFloat($(this).attr('data-vat'));
            var nKey     = $(this).attr('data-key');
            var tTypeVat = $('#ocmVatInOrEx option:selected').val();

            if(nAlwVat == 1){ 
                //อนุญาติคิด VAT
                if(tTypeVat == 1){ 
                    // ภาษีรวมใน tSoot = net - ((net * 100) / (100 + rate));
                    var net       = parseFloat($('#ospGrandTotal'+nKey).text().replace(/,/g, ''));
                    var nTotalVat = net - (net * 100 / (100 + nVat));
                    var nResult   = parseFloat(nTotalVat);
                }else if(tTypeVat == 2){
                    // ภาษีแยกนอก tSoot = net - (net * (100 + 7) / 100) - net;
                    var net       = parseFloat($('#ospGrandTotal'+nKey).text().replace(/,/g, ''));
                    var nTotalVat = (net * (100 + nVat) / 100) - net;
                    var nResult   = parseFloat(nTotalVat);
                }

                var oVat = { VAT: nVat , VALUE: nResult };
                aVat.push(oVat);
            }
        });


        //เรียงลำดับ array ใหม่
        aVat.sort(function (a, b) {
            return a.VAT - b.VAT;
        });

        //รวมค่าใน array กรณี vat ซ้ำ
        var nVATStart       = 0;
        var nSumValueVat    = 0;
        var aSumVat         = [];
        for(var i=0; i<aVat.length; i++){
            if(nVATStart == aVat[i].VAT){
                nSumValueVat = nSumValueVat + parseFloat(aVat[i].VALUE);
                aSumVat.pop();
            }else{
                nSumValueVat = 0;
                nSumValueVat = nSumValueVat + parseFloat(aVat[i].VALUE);
                nVATStart    = aVat[i].VAT;
            }

            var oSum = { VAT: nVATStart , VALUE: nSumValueVat };
            aSumVat.push(oSum);
        }

        
        //เอา VAT ไปทำในตาราง
        var nSumVat         = 0;
        for(var j=0; j<aSumVat.length; j++){
            var tVatRate    = aSumVat[j].VAT;
            var tSumVat     = parseFloat(aSumVat[j].VALUE).toFixed(2) == 0 ? '0.00' : parseFloat(aSumVat[j].VALUE).toFixed(2);
                tVatList    += '<li class="list-group-item"><label class="pull-left">'+ tVatRate + '%</label><label class="pull-right">' + tSumVat + '</label><div class="clearfix"></div></li>';
            nSumVat += parseFloat(aSumVat[j].VALUE);
        }

        $('#oulDataListVat').html(tVatList);

        //ยอดรวมภาษีมูลค่าเพิ่ม
        $('#olbVatSum').text(numberWithCommas(parseFloat(nSumVat).toFixed(2)));

        //ยอดรวมภาษีมูลค่าเพิ่ม
        $('#olbSumFCXtdVat').text(numberWithCommas(parseFloat(nSumVat).toFixed(2)));

        //สรุปราคารวม
        var tTypeVat = $('#ocmVatInOrEx option:selected').val();
        if(tTypeVat == 1){ //คิดแบบรวมใน
            var nTotal          = parseFloat($('#olbSumFCXtdNetAfHD').text().replace(/,/g, ''));
            var nResultTotal    = nTotal;
        }else if(tTypeVat == 2){ //คิดแบบแยกนอก
            var nTotal          = parseFloat($('#olbSumFCXtdNetAfHD').text().replace(/,/g, ''));
            var nVat            = parseFloat($('#olbSumFCXtdVat').text().replace(/,/g, ''));
            var nResultTotal    = parseFloat(nTotal) + parseFloat(nVat);
        }

        //จำนวนเงินรวมทั้งสิ้น
        $('#olbCalFCXphGrand').text(numberWithCommas(parseFloat(nResultTotal).toFixed(2)));

        //ราคารวมทั้งหมด ตัวเลขบาท
        var tTextTotal  = $('#olbCalFCXphGrand').text().replace(/,/g, '');
        var tThaibath 	= ArabicNumberToText(tTextTotal);
        $('#odvDataTextBath').text(tThaibath);
    }

    //************************************************************************************************************************** */

    //Modal กำหนดส่วนลด HD
    function JCNLoadPanelDisChagHD(){
        $('#odvModalDiscount').modal({backdrop: 'static', keyboard: false})  
        $('#odvModalDiscount').modal('show');
    }

    //เพิ่มส่วนลด
    function JCNvAddDisChgRow(){
        var tDuplicate = $('#otbDisChgDataDocHDList tbody tr').hasClass('otrDisChgHDNotFound');
        if(tDuplicate == true){
            //ล้างค่า
            $('#otbDisChgDataDocHDList tbody').html('');
        }

        //เพิ่มค่า
        var nKey = parseInt($('#otbDisChgDataDocHDList tbody tr').length) + parseInt(1);

        //จำนวนเงินรวม ที่อนุญาติลด
        var nRowCount   = $('.xWDiscountChgTrTag').length;
        if(nRowCount > 0){
            var oLastRow   = $('.xWDiscountChgTrTag').last();
            var nNetAlwDis = oLastRow.find('td label.xCNDisChgAfterDisChg').text();
        }else{
            var nNetAlwDis = ($('#olbSumFCXtdNetAlwDis').val() == 0) ? '0.00' : $('#olbSumFCXtdNetAlwDis').val();
        }

        var     tSelectTypeDiscount =  '<td nowrap style="padding-left: 5px !important;">';
                tSelectTypeDiscount += '<div class="form-group" style="margin-bottom: 0px !important;">';
                tSelectTypeDiscount += '<select class="dischgselectpicker form-control xCNDisChgType" onchange="JSxCalculateDiscountChg(this);">';
                tSelectTypeDiscount += '<option value="1"><?=language('common/main/main', 'ลดบาท'); ?></option>';
                tSelectTypeDiscount += '<option value="2"><?=language('common/main/main', 'ลด %'); ?></option>';
                tSelectTypeDiscount += '<option value="3"><?=language('common/main/main', 'ชาร์จบาท'); ?></option>';
                tSelectTypeDiscount += '<option value="4"><?=language('common/main/main', 'ชาร์ท %'); ?></option>';
                tSelectTypeDiscount += '</select>';
                tSelectTypeDiscount += '</div>';
                tSelectTypeDiscount += '</td>';

        var     tDiscount =  '<td nowrap style="padding-left: 5px !important;">';
                tDiscount += '<div class="form-group" style="margin-bottom: 0px !important;">';
                tDiscount += '<input class="form-control xCNInputNumericWithDecimal xCNDisChgNum" onchange="JSxCalculateDiscountChg(this);" onkeyup="javascript:if(event.keyCode==13) JSxCalculateDiscountChg(this);" type="text">';
                tDiscount += '</div>';
                tDiscount += '</td>';

        var     tHTML = '';
                tHTML += '<tr class="xWDiscountChgTrTag" >';
                tHTML += '<td>'+nKey+'</td>';
                tHTML += '<td class="text-right"><label class="xCNBeforeDisChg">'+numberWithCommas(parseFloat(nNetAlwDis).toFixed(2))+'</label></td>';
                tHTML += '<td class="text-right"><label class="xCNDisChgValue">'+'0.00'+'</label></td>';
                tHTML += '<td class="text-right"><label class="xCNDisChgAfterDisChg">'+'0.00'+'</label></td>'; 
                tHTML += tSelectTypeDiscount;
                tHTML += tDiscount;
                tHTML += '<td nowrap="" class="text-center">';
                tHTML += '<label class="xCNTextLink">';
                tHTML += '<img class="xCNIconTable xWDisChgRemoveIcon" src="<?=base_url('application/modules/common/assets/images/icons/delete.png')?>" title="Remove" onclick="JSxRemoveDiscountRow(this)">';
                tHTML += '</label>';
                tHTML += '</td>';
                tHTML += '</tr>';
        $('#otbDisChgDataDocHDList tbody').append(tHTML);
        JSxCalculateDiscountChg();
    }

    //ลบส่วนลด
    function JSxRemoveDiscountRow(elem){

    }

    //คีย์ส่วนลด
    function JSxCalculateDiscountChg(){
        $('.xWDiscountChgTrTag').each(function(index){
            if($('.xWDiscountChgTrTag').length == 1){
                // $('img.xWPIDisChgRemoveIcon').first().attr('onclick','JSxPIResetDisChgRemoveRow(this)').css('opacity', '1');
            }else{
                // $('img.xWPIDisChgRemoveIcon').first().attr('onclick','').css('opacity','0.2');
            }

            var cBeforeDisChg = $('#olbSumFCXtdNetAlwDis').val();
            $(this).find('td label.xCNBeforeDisChg').first().text(accounting.formatNumber(cBeforeDisChg, 2, ','));
            
            var cCalc;
            var nDisChgType         = $(this).find('td select.xCNDisChgType').val();
            var cDisChgNum          = $(this).find('td input.xCNDisChgNum').val();
            var cDisChgBeforeDisChg = accounting.unformat($(this).find('td label.xCNBeforeDisChg').text());
            var cDisChgValue        = $(this).find('td label.xCNDisChgValue').text();
            var cDisChgAfterDisChg  = $(this).find('td label.xCNDisChgAfterDisChg').text();

            if(nDisChgType == 1){ // ลดบาท
                cCalc = parseFloat(cDisChgBeforeDisChg) - parseFloat(cDisChgNum);
                $(this).find('td label.xCNDisChgValue').text(accounting.formatNumber(cDisChgNum, 2, ','));
            }
            
            if(nDisChgType == 2){ // ลด %
                var cDisChgPercent  = (cDisChgBeforeDisChg * parseFloat(cDisChgNum)) / 100;
                cCalc = parseFloat(cDisChgBeforeDisChg) - cDisChgPercent;
                $(this).find('td label.xCNDisChgValue').text(accounting.formatNumber(cDisChgPercent, 2, ','));
            }
            
            if(nDisChgType == 3){ // ชาร์จบาท
                cCalc = parseFloat(cDisChgBeforeDisChg) + parseFloat(cDisChgNum);
                $(this).find('td label.xCNDisChgValue').text(accounting.formatNumber(cDisChgNum, 2, ','));
            }
            
            if(nDisChgType == 4){ // ชาร์ท %
                var cDisChgPercent = (parseFloat(cDisChgBeforeDisChg) * parseFloat(cDisChgNum)) / 100;
                cCalc = parseFloat(cDisChgBeforeDisChg) + cDisChgPercent;
                $(this).find('td label.xCNDisChgValue').text(accounting.formatNumber(cDisChgPercent, 2, ','));
            }

            $(this).find('td label.xCNDisChgAfterDisChg').text(accounting.formatNumber(cCalc, 2, ','));
            $(this).next().find('td label.xCNBeforeDisChg').text(accounting.formatNumber(cCalc, 2, ','));
        });
    }

</script>