<style>
    .xCNBTNGenSerial{
        width           : 100%;
        margin-top      : 25px;
    }

    .xCNBTNActivity{
        float           : right;
        margin-left     : 10px;
    }

    #odvcustomSNFix , #odvcustomSNBetween{
        padding-bottom  : 5px;
    }

    #otbTableSerial thead {
        width           : calc( 100% - 1em )
    }

    #otbTableSerial tbody {
        display         : block;
        max-height      : 400px;
        overflow        : auto;
    }

    #otbTableSerial thead, #otbTableSerial  tbody tr {
        display         : table;
        width           : 100%;
        table-layout    : fixed;
    }

    .xCNThColumnNumber , .xCNTdColumnDelete , .xCNTdColumnEdit{
        width           : 10%;
    }

</style>

<?php
    $tDetailPDT             = $aDetailPDT[$nNumberArray];
    $tPDTName               = $tDetailPDT['PDTName'];
    $tPDTCode               = $tDetailPDT['PDTCode'];
    $nAllSerial             = $nAllSerial;
    $tNameNextFuncSerial    = $tNameNextFuncSerial;
?>

<div class="row">
    <div class="col-lg-12">

        <span><b> ชื่อสินค้า : </b></span>(<?=$tPDTCode?>) <?=$tPDTName?>
        <div class="custom-tabs-line tabs-line-bottom left-aligned">
            <ul class="nav" role="tablist">
                <li class="xWMenu active">
                    <a role="tab" data-toggle="tab" data-target="#odvcustomSNFix" aria-expanded="true">กำหนด S/N</a>
                </li>
            
                <li class="xWMenu">
                    <a role="tab" data-toggle="tab" data-target="#odvcustomSNBetween" aria-expanded="true">กำหนด S/N แบบช่วง</a>
                </li>
            </ul>
        </div>

        <!--ส่วนเงื่อนไข-->
        <div class="row">
            <div class="tab-content">
                <div id="odvcustomSNFix" class="tab-pane fade active in"> 
                    <!--เงื่อนไขการเพิ่มข้อมูลแบบที่ละอัน-->
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="form-group">
                                <label class="xCNLabelFrm"> หมายเลขซีเรียล</label>
                                <input type="text" class="form-control" maxlength="50" id="oetSerialNumber" name="oetSerialNumber" 
                                placeholder="กรุณาระบุรหัสซีเรียล" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNBTNGenSerial" 
                            onclick="JSxGenSerialToTable('single')">สร้างรหัส</button>
                        </div>
                    </div>
                </div>

                <div id="odvcustomSNBetween" class="tab-pane fade">
                    <!--เงื่อนไขการเพิ่มข้อมูลแบบช่วง-->
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="xCNLabelFrm">อักขระนำหน้า</label>
                                <input type="text" class="form-control" maxlength="5" id="oetSerialBetween_char" name="oetSerialBetween_char" 
                                placeholder="อักขระนำหน้า" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="xCNLabelFrm">เลขเริ่มต้น</label>
                                <input type="text" class="form-control xCNInputNumericWithoutDecimal text-right" maxlength="4" id="oetSerialBetween_numberstart" name="oetSerialBetween_numberstart" 
                                placeholder="เลขเริ่มต้น" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="xCNLabelFrm">จำนวนชิ้น</label>
                                <input type="text" class="form-control xCNInputNumericWithoutDecimal text-right" maxlength="2" id="oetSerialBetween_item" name="oetSerialBetween_item" 
                                placeholder="จำนวนชิ้น" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNBTNGenSerial" 
                            onclick="JSxGenSerialToTable('between')">สร้างรหัส</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--ส่วนตาราง-->
        <div class="row">
            <div class="col-lg-12">
                <label class="xCNLabelFrm xCNNumberDuplicate" style="color:red !important; display:none; float: right;"> * หมายเลขซีเรียลที่กรอกซ้ำ กรุณาลองใหม่อีกครั้ง</label>
                <table class="table table-striped" id="otbTableSerial">
                    <thead>
                        <tr>
                            <th style="width: 10%;"><?= language('common/main/main', 'tModalAdvNo') ?></th>
                            <th >หมายเลขซีเรียล</th>
                            <th class="text-center" style="width:10%"><?= language('common/main/main', 'tCMNActionDelete') ?></th>
                            <th class="text-center xCNThEdit" style="width:10%"><?= language('common/main/main', 'tCMNActionEdit') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class='text-center xCNTextDetail2 xCNEmpty' colspan='4'><?= language('common/main/main','tCMNNotFoundData')?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--ส่วนปุ่มล่างสุด-->
        <div class="row">
            <div class="col-lg-12">
                <div><hr></div>
                <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNBTNActivity" onclick="JSxConfirmPDTSerial('<?=$tPDTCode?>')">ตกลง</button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn xCNBTNActivity" onclick="JSxCanclePDTSerial('<?=$tPDTCode?>')">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>

<script>
    
    //ทุกครั้งที่จิ้มที่ input ตัว waring จะหาย
    $('#oetSerialNumber').focus(function() {
        $('.xCNNumberDuplicate').hide();
    });

    var oOnclickDelete  = 'JSxEventDeleteSerial(this)'; //ฟังก์ชั่นสำหรับลบข้อมูล
    var oOnclickEdit    = 'JSxEventEditSerial(this)';   //ฟังก์ชั่นสำหรับกดปุ่มแก้ไข
    var oOnclickSave    = 'JSxEventSaveSerial(this)';   //ฟังก์ชั่นสำหรับกดบันทึกใหม่อีกรอบหลังจากแก้ไข
    var tValueSerialOld = '';                           //เอาไว้เก็บค่าเวลา กดบันทึกทีจะเเก้ไข เเล้วไม่ผ่าน จะได้ดึงข้อมูลตัวเดิมออกมาใช่งานเเทน

    //เพิ่มข้อมูลซีเรีบลลงในตาราง grid
    function JSxGenSerialToTable(ptTypeInsert){

        //เช็คก่อนว่าในตารางมีข้อมูลไหม
        if($('#otbTableSerial tbody tr td').hasClass('xCNEmpty') == true){
            $('#otbTableSerial tbody').empty();
            //ถ้าไม่มี ให้เริ่มต้นลำดับที่หนึ่ง
            var nNumberNext     = 1;
        }else{
            //ถ้าในตารางมีข้อมูลเเล้ว ให้เอามาบวกหนึ่ง
            var nNumberNext     = parseInt($('#otbTableSerial tbody tr th:last').eq(0).text()) + 1;
        }

        var tTextSerial     = $('#oetSerialNumber').val();
        var tHTML           = '';

        if(ptTypeInsert == 'single'){//เพิ่มข้อมูลแบบตัวเดียว

            //ถ้าไม่ได้กรอกข้อมูลของแบบตัวเดียว ยังไม่ให้ผ่าน
            if($('#oetSerialNumber').val() == ''){
                $('#oetSerialNumber').focus();
                return;
            }

            //เช็ครหัสว่ามีอยู่เเล้วไหม ถ้ามีห้ามกรอกซ้ำ
            var bCheck = JSxCheckNumberSerialDuplicate(tTextSerial);
            if(bCheck == true){
                return;
            }

            tHTML += '<tr>';
            tHTML += '<th class="text-center xCNThColumnNumber">'+nNumberNext+'</th>';
            tHTML += '<td class="text-left">'+tTextSerial+'</td>';
            tHTML += '<td class="text-center xCNTdColumnDelete"><img class="xCNIconTable xCNIconDel" onclick="'+oOnclickDelete+'" src="<?=base_url('application/modules/common/assets/images/icons/delete.png')?>"></td>';
            tHTML += '<td class="text-center xCNTdColumnEdit"><img class="xCNIconTable" onclick="'+oOnclickEdit+'" src="<?=base_url('application/modules/common/assets/images/icons/edit.png')?>"></td>';
            tHTML += '</tr>';

            //ล้างข้อมูล
            $('#oetSerialNumber').val('');
        }else if(ptTypeInsert == 'between'){ //เพิ่มข้อมูลแบบช่วง
            //ถ้าไม่ได้กรอกข้อมูลของแบบตัวเดียว ยังไม่ให้ผ่าน
            if($('#oetSerialBetween_numberstart').val() == ''){
                $('#oetSerialBetween_numberstart').focus();
                return;
            }

            //ถ้าไม่ได้กรอกข้อมูลของแบบตัวเดียว ยังไม่ให้ผ่าน
            if($('#oetSerialBetween_item').val() == ''){
                $('#oetSerialBetween_item').focus();
                return;
            }

            //ลูปเพิ่มข้อมูล
            var tSerial_char   = $('#oetSerialBetween_char').val();
            var nNumberBetween = 0;
            for(var k=0; k<$('#oetSerialBetween_item').val(); k++){
                var nNumberBetween  = parseInt($('#oetSerialBetween_numberstart').val()) + k;
                var tTextSerial     = tSerial_char + nNumberBetween;

                 //เช็ครหัสว่ามีอยู่เเล้วไหม ถ้ามีห้ามกรอกซ้ำ
                var bCheck = JSxCheckNumberSerialDuplicate(tTextSerial);
                if(bCheck == true){
                    return;
                }
                
                tHTML += '<tr>';
                tHTML += '<th class="text-center xCNThColumnNumber">'+nNumberNext+'</th>';
                tHTML += '<td class="text-left">'+tTextSerial+'</td>';
                tHTML += '<td class="text-center xCNTdColumnDelete"><img class="xCNIconTable xCNIconDel" onclick="'+oOnclickDelete+'" src="<?=base_url('application/modules/common/assets/images/icons/delete.png')?>"></td>';
                tHTML += '<td class="text-center xCNTdColumnEdit"><img class="xCNIconTable" onclick="'+oOnclickEdit+'" src="<?=base_url('application/modules/common/assets/images/icons/edit.png')?>"></td>';
                tHTML += '</tr>';
                nNumberNext++;
            }

            //ล้างข้อมูล
            $('#oetSerialBetween_char , #oetSerialBetween_numberstart , #oetSerialBetween_item').val('');
        }

        //เอาไปลงตาราง
        $('#otbTableSerial').append(tHTML);

        $('.xCNNumberDuplicate').hide();

        //เช็คว่ามีปุ่มบันทึกเปิดอยู่ไหม จะอนุญาตให้ทำได้แค่ event เดียวต่อเหตุการณ์เท่านั้น
        JSxCheckRecordOpenBTNSave();

        //ถ้าหน้าจอมีสกอร์บาร์ Thead จะต้องมีพื้นที่ว่างสำหรับ scroll
        JSxControlTableTheadWhenHaveScroll('insert');
    }

    //ลบข้อมูลซีเรียล
    function JSxEventDeleteSerial(elem){

        //ไม่อนุญาตให้กดปุ่มแก้ไขทิ้งไว้ ทำได้ที่ละเหตุการณ์
        JSxCheckRecordOpenBTNSave();

        //ลบตัวมันเอง
        $(elem).parent().parent().remove();

        //เรียงลำดับใหม่
        let nNewNumer = 1;
        for(var i=0; i<$('#otbTableSerial tbody tr').length; i++){
            $('#otbTableSerial tbody tr th').eq(i).text(nNewNumer);
            nNewNumer++;
        }

        //ถ้าลบข้อมูลจนหมดเเล้ว ต้องเพิ่มให้ Table มีค่าดีฟอล
        if($('#otbTableSerial tbody tr').length == 0 || $('#otbTableSerial tbody').length == null){
            $('#otbTableSerial').append("<tr><td class='text-center xCNTextDetail2 xCNEmpty' colspan='4'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>");
        }

        //ถ้าหน้าจอมีสกอร์บาร์ Thead จะต้องมีพื้นที่ว่างสำหรับ scroll
        JSxControlTableTheadWhenHaveScroll('delete');
    }

    //แก้ไขข้อมูล
    function JSxEventEditSerial(elem){

        //ไม่อนุญาตให้กดปุ่มแก้ไขทิ้งไว้ ทำได้ที่ละเหตุการณ์
        JSxCheckRecordOpenBTNSave();

        $('.xCNNumberDuplicate').hide();

        //หาค่าเดิมของมัน
        tValueSerialOld = $(elem).parent().parent().find('td:eq(0)').text();
        $(elem).parent().parent().find('td:eq(0)').html('<input type="text" class="form-control xCNNewValueSerial" maxlength="50" value="'+tValueSerialOld+'" autocomplete="off">');
        $(elem).parent().parent().find('td:eq(2)').html('<img class="xCNIconTable xCNImageSaveIsOpen" onclick="'+oOnclickSave+'" src="<?=base_url('application/modules/common/assets/images/icons/save.png')?>">');
    }

    //บันทึกข้อมูลใหม่
    function JSxEventSaveSerial(elem){

        //หาค่าใหม่ของมัน
        var tValueSerialNew = $(elem).parent().parent().find('td:eq(0) input').val();

        //เช็ครหัสว่ามีอยู่เเล้วไหม ถ้ามีห้ามกรอกซ้ำ
        var bCheck = JSxCheckNumberSerialDuplicate(tValueSerialNew);
        if(bCheck == true){
            //ถ้าค่าใหม่ซ้ำ ให้เอาค่าเก่าไปใส่แทน
            tValueSerialNew = tValueSerialOld;
        }

        $(elem).parent().parent().find('td:eq(0)').html(tValueSerialNew);
        $(elem).parent().parent().find('td:eq(2)').html('<img class="xCNIconTable" onclick="'+oOnclickEdit+'" src="<?=base_url('application/modules/common/assets/images/icons/edit.png')?>">');
    }

    //เช็คว่ามีปุ่มบันทึกเปิดอยู่ไหม จะอนุญาตให้ทำได้แค่ event เดียวต่อเหตุการณ์เท่านั้น
    function JSxCheckRecordOpenBTNSave(){
        for(var i=0; i<$('#otbTableSerial tbody tr').length; i++){
            var bCheckSaveIsOpen = $('#otbTableSerial tbody tr').eq(i).find('td:eq(2) img').hasClass('xCNImageSaveIsOpen');
            if(bCheckSaveIsOpen == true){
                //วิ่งกลับฟังก์ชั่นเดิม ที่หลังจากเปลี่ยนข้อมูลเเล้ว
                var oObjectElem = $('#otbTableSerial tbody tr').eq(i).find('td:eq(2) img');

                //ไม่อนุญาตให้กดปุ่มแก้ไขทิ้งไว้ ทำได้ที่ละเหตุการณ์
                JSxEventSaveSerial(oObjectElem);
            }
        }
    }

    //ถ้าหน้าจอมีสกอร์บาร์ Thead จะต้องมีพื้นที่ว่างสำหรับ scroll
    function JSxControlTableTheadWhenHaveScroll(ptType){
        var nCountItemTableBody = $('#otbTableSerial tbody tr').length;
        if(nCountItemTableBody > 10){ //มันต้องมีพื้นที่ให้ position มัน fixed 
            $('.xCNThEdit').css('width','10.70%');

            //สั้งให้ไป focus ตัวสุดท้าย
            if(ptType == 'insert'){
                $('#otbTableSerial tbody').scrollTop($('#otbTableSerial tbody')[0].scrollHeight);
            }
        }else{
            $('.xCNThEdit').css('width','10%');
        }
    }

    //เช็ครหัสซีเรียลห้ามซ้ำ
    function JSxCheckNumberSerialDuplicate(ptNumberSerial){
        var bCheckDup = false;
        $("#otbTableSerial tbody tr").each(function() {
            if($(this).find('td:eq(0)').text() == ptNumberSerial){
                bCheckDup = true;
            }
        });

        if(bCheckDup == true){
            $('.xCNNumberDuplicate').show();
        }

        return bCheckDup;
    }

    //หน้าต่างยกเลิก
    function JSxCanclePDTSerial(ptPDTCode){
        if('<?=$nAllSerial?>' > 1){ //มีสินค้าตัวถัดไปรอให้กรอกอยู่
            
        }
    }

    //หน้าต่างยืนยัน 
    function JSxConfirmPDTSerial(ptPDTCode){
        if('<?=$nAllSerial?>' > 1){ //มีสินค้าตัวถัดไปรอให้กรอกอยู่
            
        }

        //แพ็คข้อมูล
        var aPackdataSerial = [];
        $("#otbTableSerial tbody tr").each(function() {
            aPackdataSerial.push($(this).find('td:eq(0)').text());
        });

        var aResult     = {'tPDTCode' : ptPDTCode , 'tSerial' : aPackdataSerial};
        var aNewResult  = JSON.stringify(aResult);

        //Packdata ส่งกลับไป
        return window['<?=$tNameNextFuncSerial?>'](aNewResult);
    }


</script>