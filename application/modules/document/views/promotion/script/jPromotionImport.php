<script>
// หน้าจอ pop-up
function JSxPromotionImportPopUp(poPackdata){

    // ล้างค่า สรุปว่าสามารถนำเข้าได้กี่อัน
    $('#ospPromotionTextSummaryImport').text('');

    var tNameModule = poPackdata.tNameModule.toLowerCase();
    var tTypeModule = poPackdata.tTypeModule.toLowerCase();
    var tAfterRoute = poPackdata.tAfterRoute;
    var tFlagClearTmp = poPackdata.tFlagClearTmp;

    // เซตค่า สำหรับ import 
    $('#ohdPromotionImportNameModule').val(tNameModule);
    $('#ohdPromotionImportAfterRoute').val(tAfterRoute);
    $('#ohdPromotionImportTypeModule').val(tTypeModule);
    $('#ohdPromotionImportClearTempOrInsCon').val(tFlagClearTmp);

    // สั้งให้ pop-up โชว์
    $('#odvPromotionModalImportFile').modal('show');
    $('.xCNPromotionImportConfirmBtn').hide();

    // ขนาดความกว้างของ pop-up
    $('#odvPromotionModalImportFile .modal-dialog').css({
        'width': '80%', 
        'top': '5%'
    });

    // Clear ค่า
    $('#oetPromotionFileNameImport').val('');
    $('#oefPromotionFileImportExcel').val('');
    $("#odvPromotionModalImportFile .modal-body").css("min-height", "70vh");
    $('#odvPromotionContentRenderHTMLImport').html('<div class="xCNImportBefore"><label><?php echo language('document/promotion/promotion','tLabel57'); ?></label></div>');
}

// Import File
function JSxPromotionCheckFileImportFile(poElement, poEvent) {
    try {
        var oFile = $(poElement)[0].files[0];
        if(oFile == undefined){
            $("#oetPromotionFileNameImport").val("");
        }else{
            $("#oetPromotionFileNameImport").val(oFile.name);
        }
        
    } catch (err) {
        console.log("JSxPromotionStep1SetImportFile Error: ", err);
    }
}

// กดปุ่มยืนยัน
function JSxPromotionImportFileExcel(){
    $('#ospPromotionTextSummaryImport').text('');

    var tNameFile = $("#oetPromotionFileNameImport").val();
    if(tNameFile != '' && tNameFile != null){// มีการเลือกไฟล์แล้ว
        JCNxOpenLoading();
        $('#odvPromotionContentRenderHTMLImport').html('<div class="xCNImportBefore"><label><?php echo language('document/promotion/promotion','tLabel58'); ?></label></div>'); 
        setTimeout(function(){
            JSxPromotionWirteImportFile();
        }, 50);
    }
}

function JSxPromotionWirteImportFile(evt) {
    var oFile = $('#oefPromotionFileImportExcel')[0].files[0];
    if (oFile) {
        var oReadFile = new FileReader();
        oReadFile.onload = e => {
            var contents = JSoPromotionProcessExcel(e.target.result);
            var aJSON = JSON.parse(contents);
            var tNameModule = $('#ohdPromotionImportNameModule').val().toLowerCase();

        /*===== Begin ตรวจสอบชื่อชิทว่าถูกต้องไหม ===========================================*/  
            if(
                (typeof(aJSON['Summary-HD']) == 'undefined') 
                || 
                (typeof(aJSON['Productgroup']) == 'undefined')
                ||
                (typeof(aJSON['Condition-กลุ่มซื้อ']) == 'undefined')
                ||
                (typeof(aJSON['Option1-กลุ่มรับ(กรณีส่วนลด)']) == 'undefined')
                ||
                (typeof(aJSON['Option2-กลุ่มรับ(กรณีcoupon)']) == 'undefined')
                ||
                (typeof(aJSON['Option3-กลุ่มรับ(กรณีแต้ม)']) == 'undefined')
            ){
                var tHDWarningMsg = "<?php echo language('document/promotion/promotion','tWarMsg29'); ?>"; // รูปแบบเอกสารไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง
                FSvCMNSetMsgWarningDialog(tHDWarningMsg, '', '', false);
                JSxPromotionFileFailFormat();
                return;
            }
        /*===== End ตรวจสอบชื่อชิทว่าถูกต้องไหม =============================================*/  

        /*===== Begin Summary HD =======================================================*/
            var aJSONDataHD = aJSON["Summary-HD"];
            console.log("Summary-HD: ", aJSONDataHD);
            var nCount = aJSONDataHD.length;
            var aNewPackData = [];
            var aError = [];
            var aPmhStaLimitCst = [1,2];
            var aPbyStaBuyCond = [1,2,3,4,5,6];
            var aPmhStaGrpPriority = [0,1,2];
            var aPmhStaChkQuota = [1,2];
            var aPmhStaGetPri = [1,2];
            var aPmhStaGetPdt = [1,2,3];
            var aPmhStaChkCst = [1,2];
            var aPbyStaCalSum = [1,2];
            var aPgtStaGetEffect = [1,2,3];

            // ตรวจสอบ excel cell ที่มันเป็นค่าว่าง
            for(var k=0; k<nCount; k++){
                if(aJSONDataHD[k].length > 0){
                    aNewPackData.push(aJSONDataHD[k]);
                }
            }
            var nCount = aNewPackData.length;
            var aJSONDataHD = aNewPackData;

            console.log('aJSONDataHD After:', aJSONDataHD);

            for(var j=1; j<nCount; j++){

                // 0 Template_Filed_ชื่อโปรโมชั่น
                if(aJSONDataHD[j][0] != null){
                    if(aJSONDataHD[j][0].toString().length > 200){
                        var tValueOld   = aJSONDataHD[j][0];
                        aJSONDataHD[j][0] = aJSONDataHD[j][0].toString().substring(0, 200);
                        aError.push('4','[0]'+'$&ชื่อโปรโมชั่นยาวเกินกำหนด$&'+tValueOld);
                    }
                }else{
                    aJSONDataHD[j][0] = 'N/A';
                    aError.push('7','[0]'+'$&ชื่อโปรโมชั่นไม่ได้ระบุข้อมูล$&'+'N/A');
                }

                // 1 Template_Filed_วันที่เริ่ม
                if(aJSONDataHD[j][1] != null){
                    var tValueOld = aJSONDataHD[j][1].toString();
                    var Letters = /^([12]\d{3}\/(0[1-9]|1[0-2])\/(0[1-9]|[12]\d|3[01]))+$/g;
                    if(!tValueOld.match(Letters)){
                        aJSONDataHD[j][1] = '<?php echo date('Y-m-d'); ?>';
                        aError.push('4','[1]'+'$&วันที่เริ่ม ไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataHD[j][1] = '<?php echo date('Y-m-d'); ?>';
                    aError.push('7','[1]'+'$&วันที่เริ่มไม่ได้ระบุข้อมูล$&'+'N/A');
                }

                // 2 Template_Filed_วันที่สิ้นสุด
                if(aJSONDataHD[j][2] != null){
                    var tValueOld = aJSONDataHD[j][2].toString();
                    var Letters = /^([12]\d{3}\/(0[1-9]|1[0-2])\/(0[1-9]|[12]\d|3[01]))+$/g;
                    if(!tValueOld.match(Letters)){
                        aJSONDataHD[j][2] = '<?php echo date('Y-m-d'); ?>';
                        aError.push('4','[2]'+'$&วันที่สิ้นสุด ไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataHD[j][2] = '<?php echo date('Y-m-d'); ?>';
                    aError.push('7','[2]'+'$&วันที่สิ้นสุดไม่ได้ระบุข้อมูล$&'+'N/A');
                }

                // 3 Template_Filed_เวลาเริ่ม
                if(aJSONDataHD[j][3] != null){
                    var tValueOld = aJSONDataHD[j][3].toString();
                    var Letters = /^([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]+$/g;
                    if(!tValueOld.match(Letters)){
                        aJSONDataHD[j][3] = '00:00:00';
                        aError.push('4','[3]'+'$&เวลาเริ่ม ไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataHD[j][3] = '00:00:00';
                }

                // 4 Template_Filed_เวลาสิ้นสุด
                if(aJSONDataHD[j][4] != null){
                    var tValueOld = aJSONDataHD[j][4].toString();
                    var Letters = /^([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]+$/g;
                    if(!tValueOld.match(Letters)){
                        aJSONDataHD[j][4] = '23:59:59';
                        aError.push('4','[4]'+'$&เวลาสิ้นสุด ไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataHD[j][4] = '23:59:59';
                }

                // 5 Template_Filed_มีผลกับ
                if(aJSONDataHD[j][5] != null){
                    if(aPmhStaLimitCst.includes(aJSONDataHD[j][5]) != true){
                        var tValueOld = aJSONDataHD[j][5];
                        aJSONDataHD[j][5] = 1;
                        aError.push('4','[5]'+'$&มีผลกับไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataHD[j][5] = 1;
                }

                // 6 Template_Filed_ประเภทการคำนวนโปรโมชั่น
                if(aJSONDataHD[j][6] != null){
                    if(aPbyStaBuyCond.includes(aJSONDataHD[j][6]) != true){
                        var tValueOld = aJSONDataHD[j][6];
                        aJSONDataHD[j][6] = 1;
                        aError.push('4','[6]'+'$&ประเภทการคำนวนโปรโมชั่นไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataHD[j][6] = 1;
                }

                // 7 Template_Filed_กลุ่มการคำนวนโปรโมชั่น
                if(aJSONDataHD[j][7] != null){
                    if(aPmhStaGrpPriority.includes(aJSONDataHD[j][7]) != true){
                        var tValueOld = aJSONDataHD[j][7];
                        aJSONDataHD[j][7] = 1;
                        aError.push('4','[7]'+'$&กลุ่มการคำนวนโปรโมชั่นไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataHD[j][7] = 1;
                }

                // 8 Template_Filed_เงื่อนไขการได้โปรโมชั่น(กรณีได้ โปรโมชั่นซ้อน)
                if(aJSONDataHD[j][8] != null){
                    if(aPmhStaGetPdt.includes(aJSONDataHD[j][8]) != true){
                        var tValueOld = aJSONDataHD[j][8];
                        aJSONDataHD[j][8] = 1;
                        aError.push('4','[8]'+'$&เงื่อนไขการได้โปรโมชั่น(กรณีได้ โปรโมชั่นซ้อน) ไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataHD[j][8] = 1;
                }

                // 9 Template_Filed_เงื่อนไขการตรวจสอบ Quota จากระบบอื่น
                if(aJSONDataHD[j][9] != null){
                    if(aPmhStaChkQuota.includes(aJSONDataHD[j][9]) != true){
                        var tValueOld = aJSONDataHD[j][9];
                        aJSONDataHD[j][9] = 1;
                        aError.push('4','[9]'+'$&เงื่อนไขการตรวจสอบ Quota จากระบบอื่น ไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataHD[j][9] = 2;
                }

                // 10 Template_Filed_ราคาที่ใช้คำนวน
                if(aJSONDataHD[j][10] != null){
                    if(aPmhStaGetPri.includes(aJSONDataHD[j][10]) != true){
                        var tValueOld = aJSONDataHD[j][10];
                        aJSONDataHD[j][10] = 1;
                        aError.push('4','[10]'+'$&ราคาที่ใช้คำนวน ไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataHD[j][10] = 1;
                }

                // 11 Template_Filed_เล่นโปรโมชั่นสมาชิก
                if(aJSONDataHD[j][11] != null){
                    if(aPmhStaChkCst.includes(aJSONDataHD[j][11]) != true){
                        var tValueOld = aJSONDataHD[j][11];
                        aJSONDataHD[j][11] = 1;
                        aError.push('4','[11]'+'$&เล่นโปรโมชั่นสมาชิก ไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataHD[j][11] = 2;
                }

                // 12 Template_Filed_A ตามอายุสมาชิก
                if(aJSONDataHD[j][12] != null){
                    var tValueOld = aJSONDataHD[j][12].toString();
                    var Letters = /^(<|<=|=|>|>=),[0-9]+$/g;
                    if(!tValueOld.match(Letters)){
                        aError.push('4','[12]'+'$&A ตามอายุสมาชิก ไม่ถูกต้อง$&'+tValueOld);
                    }

                    if(aJSONDataHD[j][12].toString().length > 10){
                        var tValueOld = aJSONDataHD[j][12];
                        aJSONDataHD[j][12] = aJSONDataHD[j][12].toString().substring(0, 10);
                        aError.push('4','[12]'+'$&A ตามอายุสมาชิก ยาวเกินกำหนด$&'+tValueOld);
                    }
                }else{
                    aJSONDataHD[j][12] = '<,0';
                }

                // 13 Template_Filed_B ตามเดือนเกิด
                if(aJSONDataHD[j][13] != null){
                    var tValueOld = aJSONDataHD[j][13].toString();
                    var Letters = /^[0-9]+,(Y|N),[0-9]+$/g;
                    if(!tValueOld.match(Letters)){
                        aError.push('4','[13]'+'$&B ตามเดือนเกิด ไม่ถูกต้อง$&'+tValueOld);
                    }

                    if(aJSONDataHD[j][13].toString().length > 10){
                        var tValueOld = aJSONDataHD[j][13];
                        aJSONDataHD[j][13] = aJSONDataHD[j][13].toString().substring(0, 10);
                        aError.push('4','[13]'+'$&B ตามเดือนเกิด ยาวเกินกำหนด$&'+tValueOld);
                    }
                }else{
                    aJSONDataHD[j][13] = '0,Y,0';
                }

                // 14 Template_Filed_เงื่อนไขคำนวนกลุ่มซื้อ
                if(aJSONDataHD[j][14] != null){
                    if(aPbyStaCalSum.includes(aJSONDataHD[j][14]) != true){
                        var tValueOld = aJSONDataHD[j][14];
                        aJSONDataHD[j][14] = 1;
                        aError.push('4','[14]'+'$&เงื่อนไขคำนวนกลุ่มซื้อ ไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    if ([1,2].includes(aJSONDataHD[j][6])) {
                        aJSONDataHD[j][14] = 1;
                    }
                    if ([3,4,5,6].includes(aJSONDataHD[j][6])) {
                        aJSONDataHD[j][14] = 1;
                    }
                }

                // 15 Template_Filed_เงื่อนไขคำนวนกลุ่มรับ
                if(aJSONDataHD[j][15] != null){
                    if(aPgtStaGetEffect.includes(aJSONDataHD[j][15]) != true){
                        var tValueOld = aJSONDataHD[j][15];
                        aJSONDataHD[j][15] = 1;
                        aError.push('4','[15]'+'$&เงื่อนไขคำนวนกลุ่มรับ ไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    if ([1,2].includes(aJSONDataHD[j][6])) {
                        aJSONDataHD[j][15] = 1;
                    }
                    if ([3,4,5,6].includes(aJSONDataHD[j][6])) {
                        aJSONDataHD[j][15] = 3;
                    }
                }

                // ถ้าผ่านทุกอัน
                if(aError.length > 0){
                    aJSONDataHD[j].push(aError[0],aError[1]);
                    aError = [];
                }else{
                    aJSONDataHD[j].push('1','');
                }
            }
        /*===== End Summary HD =========================================================*/

        /*===== Begin Product Group ====================================================*/
            var aJSONDataPdtGroup = aJSON["Productgroup"];
            var nCount = aJSONDataPdtGroup.length;
            var aNewPackData = [];
            var aError = [];
            var aPmdStaType = [1,2,3];

            // ตรวจสอบ excel cell ที่มันเป็นค่าว่าง
            for(var k=0; k<nCount; k++){
                if(aJSONDataPdtGroup[k].length > 0){
                    aNewPackData.push(aJSONDataPdtGroup[k]);
                }
            }
            var nCount = aNewPackData.length;
            var aJSONDataPdtGroup = aNewPackData;

            for(var j=1; j<nCount; j++){

                // Template_Filed_ประเภทกลุ่ม
                if(aJSONDataPdtGroup[j][0] != null){
                    if(aPmdStaType.includes(aJSONDataPdtGroup[j][0]) != true){
                        var tValueOld = aJSONDataPdtGroup[j][0];
                        aJSONDataPdtGroup[j][0] = 1;
                        aError.push('4','[0]'+'$&ประเภทกลุ่มไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataPdtGroup[j][0] = 1;
                    aError.push('7','[0]'+'$&ประเภทกลุ่มไม่ได้ระบุข้อมูล$&'+'N/A');
                }

                // Template_Filed_ชื่อกลุ่มจัดรายการ
                if(aJSONDataPdtGroup[j][1] != null){
                    if(aJSONDataPdtGroup[j][1].toString().length > 50){
                        var tValueOld = aJSONDataPdtGroup[j][1];
                        aJSONDataPdtGroup[j][1] = aJSONDataPdtGroup[j][1].toString().substring(0, 50);
                        aError.push('4','[1]'+'$&ชื่อกลุ่มจัดรายการยาวเกินกำหนด$&'+tValueOld);
                    }
                }else{
                    aJSONDataPdtGroup[j][1] = 'N/A';
                    aError.push('7','[1]'+'$&ชื่อกลุ่มจัดรายการไม่ได้ระบุข้อมูล$&'+'N/A');
                }
                
                // Template_Filed_บาร์โค้ดสินค้า
                if(aJSONDataPdtGroup[j][2] != null){
                    if(aJSONDataPdtGroup[j][2].toString().length > 20){
                        var tValueOld = aJSONDataPdtGroup[j][2];
                        aJSONDataPdtGroup[j][2] = aJSONDataPdtGroup[j][2].toString().substring(0, 20);
                        aError.push('4','[2]'+'$&บาร์โค้ดสินค้ายาวเกินกำหนด$&'+tValueOld);
                    }
                }else{
                    aJSONDataPdtGroup[j][2] = 'N/A';
                    aError.push('7','[2]'+'$&บาร์โค้ดสินค้าไม่ได้ระบุข้อมูล$&'+'N/A');
                }

                // Template_Filed_รหัสหน่วย
                if(aJSONDataPdtGroup[j][3] != null){
                    if(aJSONDataPdtGroup[j][3].toString().length > 5){
                        var tValueOld = aJSONDataPdtGroup[j][3];
                        aJSONDataPdtGroup[j][3] = aJSONDataPdtGroup[j][3].toString().substring(0, 5);
                        aError.push('4','[3]'+'$&รหัสหน่วยยาวเกินกำหนด$&'+tValueOld);
                    }
                }else{
                    aJSONDataPdtGroup[j][3] = 'N/A';
                    aError.push('7','[3]'+'$&รหัสหน่วยไม่ได้ระบุข้อมูล$&'+'N/A');
                }

                // ถ้าผ่านทุกอัน
                if(aError.length > 0){
                    aJSONDataPdtGroup[j].push(aError[0],aError[1]);
                    aError = [];
                }else{
                    aJSONDataPdtGroup[j].push('1','');
                }
            }
        /*===== End Product Group ======================================================*/

        /*===== Begin Condition กลุ่มซื้อ =================================================*/
            var aJSONDataBuyGroup = aJSON["Condition-กลุ่มซื้อ"];
            console.log("Condition-กลุ่มซื้อ: ", aJSONDataBuyGroup);
            var nCount = aJSONDataBuyGroup.length;
            var aNewPackData = [];
            var aError = [];
            var aPbyStaBuyCond = [1,2,3,4,5];

            // ตรวจสอบ excel cell ที่มันเป็นค่าว่าง
            for(var k=0; k<nCount; k++){
                if(aJSONDataBuyGroup[k].length > 0){
                    aNewPackData.push(aJSONDataBuyGroup[k]);
                }
            }
            var nCount = aNewPackData.length;
            var aJSONDataBuyGroup = aNewPackData;

            for(var j=1; j<nCount; j++){

                // Template_Filed_ชื่อกลุ่มจัดรายการ
                if(aJSONDataBuyGroup[j][0] != null){
                    if(aJSONDataBuyGroup[j][0].toString().length > 50){
                        var tValueOld = aJSONDataBuyGroup[j][0];
                        aJSONDataBuyGroup[j][0] = aJSONDataBuyGroup[j][0].toString().substring(0, 50);
                        aError.push('4','[0]'+'$&ชื่อกลุ่มจัดรายการยาวเกินกำหนด$&'+tValueOld);
                    }
                }else{
                    aJSONDataBuyGroup[j][0] = 'N/A';
                    aError.push('7','[0]'+'$&ชื่อกลุ่มจัดรายการไม่ได้ระบุข้อมูล$&'+'N/A');
                }

                // Template_Filed_เงื่อนไขการซื้อ
                if(aJSONDataBuyGroup[j][1] != null){
                    if(aPbyStaBuyCond.includes(aJSONDataBuyGroup[j][1]) != true){
                        var tValueOld = aJSONDataBuyGroup[j][1];
                        aJSONDataBuyGroup[j][1] = 1;
                        aError.push('4','[1]'+'$&เงื่อนไขการซื้อ ไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataBuyGroup[j][1] = 1;
                }

                // Template_Filed_จำนวน / มูลค่า
                if(aJSONDataBuyGroup[j][2] != null){
                    var tValueOld = aJSONDataBuyGroup[j][2].toString().replace(" ", "");
                    var Letters = /^[ก-๛A-Za-z]+$/;
                    if(tValueOld.match(Letters)){
                        aJSONDataBuyGroup[j][2] = 0;
                        aError.push('4','[2]'+'$&จำนวน / มูลค่า ไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataBuyGroup[j][2] = 0;
                }

                // Template_Filed_ไม่เกิน จำนวน/มูลค่า
                if(aJSONDataBuyGroup[j][3] != null){
                    var tValueOld = aJSONDataBuyGroup[j][3].toString().replace(" ", "");
                    var Letters = /^[ก-๛A-Za-z]+$/;
                    if(tValueOld.match(Letters)){
                        aJSONDataBuyGroup[j][3] = 0;
                        aError.push('4','[3]'+'$&ไม่เกิน จำนวน/มูลค่า ไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataBuyGroup[j][3] = 0;
                }

                // Template_Filed_ราคาขั่นต่ำต่อหน่วย
                if(aJSONDataBuyGroup[j][4] != null){
                    var tValueOld = aJSONDataBuyGroup[j][4].toString().replace(" ", "");
                    var Letters = /^[ก-๛A-Za-z]+$/;
                    if(tValueOld.match(Letters)){
                        aJSONDataBuyGroup[j][4] = 0;
                        aError.push('4','[4]'+'$&ราคาขั่นต่ำต่อหน่วย ไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataBuyGroup[j][4] = 0;
                }

                // ถ้าผ่านทุกอัน
                if(aError.length > 0){
                    aJSONDataBuyGroup[j].push(aError[0],aError[1]);
                    aError = [];
                }else{
                    aJSONDataBuyGroup[j].push('1','');
                }
            }
        /*===== End Condition กลุ่มซื้อ ===================================================*/

        /*===== Begin Option1-กลุ่มรับ(กรณีส่วนลด) =========================================*/
            var aJSONDataGetGroup = aJSON["Option1-กลุ่มรับ(กรณีส่วนลด)"];
            var nCount = aJSONDataGetGroup.length;
            var aNewPackData = [];
            var aError = [];
            var aPgtStaGetType = [1,2,3,4,5,6];

            // ตรวจสอบ excel cell ที่มันเป็นค่าว่าง
            for(var k=0; k<nCount; k++){
                if(aJSONDataGetGroup[k].length > 0){
                    aNewPackData.push(aJSONDataGetGroup[k]);
                }
            }
            var nCount = aNewPackData.length;
            var aJSONDataGetGroup = aNewPackData;

            for(var j=1; j<nCount; j++){

                // Template_Filed_ชื่อกลุ่มจัดรายการ
                if(aJSONDataGetGroup[j][0] != null){
                    if(aJSONDataGetGroup[j][0].toString().length > 50){
                        var tValueOld = aJSONDataGetGroup[j][0];
                        aJSONDataGetGroup[j][0] = aJSONDataGetGroup[j][0].toString().substring(0, 50);
                        aError.push('4','[0]'+'$&ชื่อกลุ่มจัดรายการยาวเกินกำหนด$&'+tValueOld);
                    }
                }else{
                    aJSONDataGetGroup[j][0] = 'N/A';
                    aError.push('7','[0]'+'$&ชื่อกลุ่มจัดรายการไม่ได้ระบุข้อมูล$&'+'N/A');
                }

                // Template_Filed_เงื่อนไขรับ
                if(aJSONDataGetGroup[j][1] != null){
                    if(aPgtStaGetType.includes(aJSONDataGetGroup[j][1]) != true){
                        var tValueOld = aJSONDataGetGroup[j][1];
                        aJSONDataGetGroup[j][1] = 1;
                        aError.push('4','[1]'+'$&เงื่อนไขรับ ไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataGetGroup[j][1] = 1; 
                }

                // Template_Filed_จำนวน / มูลค่า
                if(aJSONDataGetGroup[j][2] != null){
                    var tValueOld = aJSONDataGetGroup[j][2].toString().replace(" ", "");
                    var Letters = /^[ก-๛A-Za-z]+$/;
                    if(tValueOld.match(Letters)){
                        aJSONDataGetGroup[j][2] = 0;
                        aError.push('4','[2]'+'$&จำนวน / มูลค่า ไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataGetGroup[j][2] = 0;
                }

                // Template_Filed_จำนวนที่ได้รับฟรี
                if(aJSONDataGetGroup[j][3] != null){
                    var tValueOld = aJSONDataGetGroup[j][3].toString().replace(" ", "");
                    var Letters = /^[ก-๛A-Za-z]+$/;
                    if(tValueOld.match(Letters)){
                        aJSONDataGetGroup[j][3] = 0;
                        aError.push('4','[3]'+'$&จำนวนที่ได้รับฟรี ไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataGetGroup[j][3] = 0;
                }

                // ถ้าผ่านทุกอัน
                if(aError.length > 0){
                    aJSONDataGetGroup[j].push(aError[0],aError[1]);
                    aError = [];
                }else{
                    aJSONDataGetGroup[j].push('1','');
                }
            }
        /*===== End Option1-กลุ่มรับ(กรณีส่วนลด) ===========================================*/

        /*===== Begin Option2-กลุ่มรับ(กรณีcoupon) ========================================*/
            var aJSONDataGetCoupon = aJSON["Option2-กลุ่มรับ(กรณีcoupon)"];
            var nCount = aJSONDataGetCoupon.length;
            var aNewPackData = [];
            var aError = [];
            var aPgtStaCoupon = [2,3];

            // ตรวจสอบ excel cell ที่มันเป็นค่าว่าง
            for(var k=0; k<nCount; k++){
                if(aJSONDataGetCoupon[k].length > 0){
                    aNewPackData.push(aJSONDataGetCoupon[k]);
                }
            }
            var nCount = aNewPackData.length;
            var aJSONDataGetCoupon = aNewPackData;

            for(var j=1; j<nCount; j++){

                // Template_Filed_รับสิทธิ์
                if(aJSONDataGetCoupon[j][0] != null){
                    if(aPgtStaCoupon.includes(aJSONDataGetCoupon[j][0]) != true){
                        var tValueOld = aJSONDataGetCoupon[j][0];
                        aJSONDataGetCoupon[j][0] = 1;
                        aError.push('4','[0]'+'$&รับสิทธิ์ ไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataGetCoupon[j][0] = 1;
                }

                // Template_Filed_รหัสคูปอง
                if(aJSONDataGetCoupon[j][1] != null){
                }else{
                    aJSONDataGetCoupon[j][1] = "";
                }

                // Template_Filed_ข้อความสิทธิ์
                if(aJSONDataGetCoupon[j][1] != null){
                }else{
                    aJSONDataGetCoupon[j][1] = "";
                }

                // ถ้าผ่านทุกอัน
                if(aError.length > 0){
                    aJSONDataGetCoupon[j].push(aError[0],aError[1]);
                    aError = [];
                }else{
                    aJSONDataGetCoupon[j].push('1','');
                }
            }
        /*===== End Option2-กลุ่มรับ(กรณีcoupon) ==========================================*/

        /*===== Begin Option3-กลุ่มรับ(กรณีแต้ม) ===========================================*/
            var aJSONDataGetPoint = aJSON["Option3-กลุ่มรับ(กรณีแต้ม)"];
            var nCount = aJSONDataGetPoint.length;
            var aNewPackData = [];
            var aError = [];
            var aPgtStaPoint = [1,2];
            var aPgtStaPntCalType = [1,2];

            // ตรวจสอบ excel cell ที่มันเป็นค่าว่าง
            for(var k=0; k<nCount; k++){
                if(aJSONDataGetPoint[k].length > 0){
                    aNewPackData.push(aJSONDataGetPoint[k]);
                }
            }
            var nCount = aNewPackData.length;
            var aJSONDataGetPoint = aNewPackData;

            // ในลูปนี้จะเช็ค 2 step status 3:เช็ค MaxLen ,status 4:เช็ค DataType
            for(var j=1; j<nCount; j++){

                // Template_Filed_ให้แต้ม
                if(aJSONDataGetPoint[j][0] != null){
                    if(aPgtStaPoint.includes(aJSONDataGetPoint[j][0]) != true){
                        var tValueOld = aJSONDataGetPoint[j][0];
                        aJSONDataGetPoint[j][0] = 1;
                        aError.push('4','[0]'+'$&ให้แต้ม ไม่ถูกต้อง$&'+tValueOld);
                    }
                }

                // Template_Filed_เงื่อนไขคำนวนแต้ม
                if(aJSONDataGetPoint[j][1] != null){
                    if(aPgtStaPntCalType.includes(aJSONDataGetPoint[j][1]) != true){
                        var tValueOld = aJSONDataGetPoint[j][1];
                        aJSONDataGetPoint[j][1] = 1;
                        aError.push('4','[0]'+'$&เงื่อนไขคำนวนแต้ม ไม่ถูกต้อง$&'+tValueOld);
                    }
                }

                // Template_Filed_อัตราส่วน มูลค่า / จำนวน
                if(aJSONDataGetPoint[j][2] != null){
                    var tValueOld = aJSONDataGetPoint[j][2].toString().replace(" ", "");
                    var Letters = /^[ก-๛A-Za-z]+$/;
                    if(tValueOld.match(Letters)){
                        aJSONDataGetPoint[j][2] = 0;
                        aError.push('4','[2]'+'$&อัตราส่วน มูลค่า / จำนวน ไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataGetPoint[j][2] = 0;
                }

                // Template_Filed_จำนวนแต้มที่ได้รับ
                if(aJSONDataGetPoint[j][3] != null){
                    var tValueOld = aJSONDataGetPoint[j][3].toString().replace(" ", "");
                    var Letters = /^[ก-๛A-Za-z]+$/;
                    if(tValueOld.match(Letters)){
                        aJSONDataGetPoint[j][3] = 0;
                        aError.push('4','[2]'+'$&จำนวนแต้มที่ได้รับ ไม่ถูกต้อง$&'+tValueOld);
                    }
                }else{
                    aJSONDataGetPoint[j][3] = 0;
                }

                // ถ้าผ่านทุกอัน
                if(aError.length > 0){
                    aJSONDataGetPoint[j].push(aError[0],aError[1]);
                    aError = [];
                }else{
                    aJSONDataGetPoint[j].push('1','');
                }
            }
        /*===== End Option3-กลุ่มรับ(กรณีแต้ม) =============================================*/

            var oPromotionData = {
                aJSONDataHD: aJSONDataHD,
                aJSONDataPdtGroup: aJSONDataPdtGroup,
                aJSONDataBuyGroup: aJSONDataBuyGroup,
                aJSONDataGetGroup: aJSONDataGetGroup,
                aJSONDataGetCoupon: aJSONDataGetCoupon,
                aJSONDataGetPoint: aJSONDataGetPoint
            };

            JSxPromotionProcessImportExcel(oPromotionData);
        }
        oReadFile.readAsBinaryString(oFile);
    } else {
        JCNxCloseLoading();
        console.log("Failed to load file");
    }
}

function JSoPromotionProcessExcel(data) {
    var workbook = XLSX.read(data, {
        type: 'binary'
    });

    var firstSheet = workbook.SheetNames[0];
    var data = JStPromotionToJson(workbook);
    return data
};

function JStPromotionToJson(workbook) {
    var result = {};
    workbook.SheetNames.forEach(function(sheetName) {
        var roa = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {
            header: 1
        });
        if (roa.length) result[sheetName] = roa;
    });
    return JSON.stringify(result, 2, 2);
};

// ฟังก์ชั่นสำหรับ import excel -> controller -> modal
function JSxPromotionProcessImportExcel(aJSONData){
    $.ajax({
        type: "POST",
        url: "promotionImportExcelToTmp",
        data: { 'aPackData' : aJSONData },
        async: false,
        success: function (aResult) {
            // ถ้าเป็นหน้าจอมาสเตอร์ จะโหลด HTML มา
            var tRouteMaster = $('#ohdPromotionImportAfterRoute').val();
            JSxPromotionRenderHTMLForImport(tRouteMaster);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('ERROR');
            JCNxCloseLoading();
        }
    });
}

// ไฟล์ผิด รุปแบบผิดพลาด
function JSxPromotionFileFailFormat(){
    JCNxCloseLoading();
    $('#odvPromotionContentRenderHTMLImport').html('<div class="xCNImportBefore"><label><?php echo language('document/promotion/promotion','tLabel57'); ?></label></div>');
}

function JSxPromotionRenderHTMLForImport(ptRouteMaster){
    $.ajax({
        type: "POST",
        url: ptRouteMaster,
        data: {},
        async: false,
        success: function (oResponse){
            $('#odvPromotionContentRenderHTMLImport').html(oResponse.html);   // นำ DataTable มาวางทับ
            $('.xCNPromotionImportConfirmBtn').show();
            JCNxCloseLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('JSxPromotionRenderHTMLForImport ERROR');
            JCNxCloseLoading();
        }
    });
}
</script>