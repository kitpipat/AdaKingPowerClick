<style>
    .xWTableSettingHeight{
        margin-bottom       : 0px !important;
    }

    .xWTableSettingHeight thead{
        background          : #222b3c;
    }

    .xWTableSettingHeight>thead:first-child>tr:first-child>td, .xWTableSettingHeight>thead:first-child>tr:first-child>th{
        color               : #FFF !important;
    }

    .xWInputHeight{
        text-align          : right;
    }

    #xWStatusVending{
        color               : #FFF;
    }
</style>

<script>
    $('ducument').ready(function() {
        JSvVEDDataList();
    });

    //วิ่งเข้าฟังก์ชั่นแรก
    function JSvVEDDataList(){
        $.ajax({
            type    : "POST",
            url     : "VendingLayoutList",
            data    : { 
                tShpCode : $('#ohdShpCode').val() , 
                tBchCode : $('#ohdBchCode').val() 
            },
            cache   : false,
            timeout : 0,
            success : function(tResult) {
                $('#odvContentVedingShopLayout').html(tResult);
                JCNxCloseLoading();
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
</script>

<input type="hidden" name="ohdShpCode" id="ohdShpCode" value="<?=$tShpCode?>" >
<input type="hidden" name="ohdBchCode" id="ohdBchCode" value="<?=$tBchCode?>" >
<div id="odvContentVedingShopLayout"></div>

<!--กำหนดความสูง-->
<input type="hidden" id="oetVedSettingHidden" name="oetVedSettingHidden" value="EDIT">
<div class="modal fade" id="odvModalVendingLayout">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" style="display:inline-block">
                    <label class="xCNLabelFrm" style="color:#FFF !important;"><?=language('vending/vendingshoplayout/vendingmanage', 'tVendingInsertHeadLayout')?> </label>
                </h5>
			</div>
			<div class="modal-body">

                <div class="row">
                    <div class="col-lg-7 xWDivLineLeft" style="border-right: 1px solid #eaeaea;"> 
                        <!--ชื่อตู้-->
                        <div class="form-group">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><?=language('vending/vendingshoplayout/vendingmanage', 'tVendingNameLayout')?></label>
                                <input type="text" class="form-control" maxlength="255" id="oetVedNameLayout" name="oetVedNameLayout" value="" data-validate="กรุณากรอกชื่อตู้">
                                <input type="hidden" id="oetVedNameLayoutHidden" name="oetVedNameLayoutHidden" value="0">
                            </div>
                        </div>

                        <!--จำนวนชั้น-->
                        <div class="form-group">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><span style="color:red">*</span><?=language('vending/vendingshoplayout/vendingmanage', 'tCountRowShopLayout')?></label>
                                <input type="text" class="form-control xCNInputNumericWithoutDecimal" maxlength="2" style="text-align: right;"  id="oetVedFloorLayout" name="oetVedFloorLayout" value="" placeholder="กรุณากรอกจำนวนชั้น">
                                <input type="hidden" id="oetVedFloorLayoutHidden" name="oetVedFloorLayoutHidden" value="0">
                            </div>
                        </div>

                        <!--จำนวนช่อง-->
                        <div class="form-group">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><span style="color:red">*</span><?=language('vending/vendingshoplayout/vendingmanage', 'tCountColShopLayout')?></label>
                                <input type="text" class="form-control xCNInputNumericWithoutDecimal" maxlength="2" style="text-align: right;"  id="oetVedColumnLayout" name="oetVedColumnLayout" value="" placeholder="กรุณากรอกจำนวนช่อง">
                                <input type="hidden" id="oetVedColumnLayoutHidden" name="oetVedColumnLayoutHidden" value="0">
                            </div>
                        </div>

                        <!--เหตุผล-->
                        <div class="form-group">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><?=language('vending/vendingshoplayout/vendingmanage', 'tVendingReasonLayout')?></label>
                                <input type="text" class="form-control" maxlength="255" id="oetVedReasonLayout" name="oetVedReasonLayout" value="" data-validate="">
                                <input type="hidden" id="oetVedReasonLayoutHidden" name="oetVedReasonLayoutHidden" value="0">

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 xWDivLineRight" style="border-left: 1px solid #eaeaea; overflow: scroll; overflow-x: auto; height: 350px; padding: 0px; padding-left: 10px;">
                        <table class="table xWTableSettingHeight">
                            <thead>
                                <tr>
                                    <th style="width: 50px; text-align: center;"><?=language('vending/vendingshoplayout/vendingmanage', 'tRowShopLayout')?></th>
                                    <th style="width: 50px; text-align: center;"><?=language('vending/vendingshoplayout/vendingmanage', 'tVendingHeightLayout')?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan='2' style="text-align: center;"><?=language('vending/vendingshoplayout/vendingmanage', 'tVendingWaringHeight')?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

			</div>
            <div class="modal-footer">
                <button id="obtVendingConfirmCreateDiagram" type="button" class="btn xCNBTNPrimery" onClick="JSxVendingConfirmCreateDiagram()"><?=language('common/main/main', 'tModalConfirm'); ?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel'); ?></button>
            </div>
		</div>
	</div>
</div>
<!--กำหนดความสูง-->

<!--ลดขนาด ลดชั้นยืนยันไหม-->
<div class="modal fade" id="odvModalFloorAndColumnReduce">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <h3 style="font-size:20px;color:#FFFF00;font-weight: 1000;">
                    <i class="fa fa-exclamation-triangle"></i> 
                    <?=language('vending/vendingshoplayout/vendingmanage', 'tVendingWaringChangeColumn')?>
                </h3>

				<!-- <h5 class="modal-title" style="display:inline-block">
                    <label class="xCNLabelFrm" style="color:#FFF !important;">จำนวนชั้น และจำนวนช่องมีการเปลี่ยนแปลง</label>
                </h5> -->
			</div>
			<div class="modal-body">
                 <span><?=language('vending/vendingshoplayout/vendingmanage', 'tVendingWaringChangeColumnDetail')?></span>
			</div>
            <div class="modal-footer">
                <button id="odvModalFloorAndColumnReduceConfirm" type="button" class="btn xCNBTNPrimery"><?=language('common/main/main', 'tModalConfirm'); ?></button>
                <button id="odvModalFloorAndColumnReduceCancle" type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel'); ?></button>
            </div>
		</div>
	</div>
</div>
<!--ลดขนาด ลดชั้นยืนยันไหม-->

<!--กรุณาเลือก cabinet-->
<div class="modal fade" id="odvModalSelectCabinet">
	<div class="modal-dialog">
		<div class="modal-content">
            <div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('vending/vendingshoplayout/vendingmanage', 'tVendingSelectCabinet')?></label>
            </div>
			<div class="modal-body">
                 <span><?=language('vending/vendingshoplayout/vendingmanage', 'tVendingSelectCabinetDetail')?></span>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn xCNBTNPrimery" data-dismiss="modal"><?=language('common/main/main', 'tModalConfirm'); ?></button>
                <!-- <button id="odvModalFloorAndColumnReduceCancle" type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel'); ?></button> -->
            </div>
		</div>
	</div>
</div>
<!--กรุณาเลือก cabinet-->

<!--ลบตู้สินค้า-->
<div class="modal fade" id="odvModalDeleteLayout">
	<div class="modal-dialog">
		<div class="modal-content">
            <div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('vending/vendingshoplayout/vendingmanage', 'tCancelLayout')?> ? </label>
            </div>
			<div class="modal-body">
                 <span><?=language('vending/vendingshoplayout/vendingmanage', 'tCancelLayoutDetail')?></span>
			</div>
            <div class="modal-footer">
                <button id="ocmCancelShopLayout" type="button" class="btn xCNBTNPrimery" data-dismiss="modal"><?=language('common/main/main', 'tModalConfirm'); ?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel'); ?></button>
            </div>
		</div>
	</div>
</div>
<!--ลบตู้สินค้า-->

<script>

    //ทำการกำหนดดวามสูงและความกว้างของชั้น
    function JSxSettingVendingLayout(ptType){
        nValCabinet = $( "#osmSelectCabinet option:selected" ).val();
        if(nValCabinet == "null"){
            //ต้องเลือก cabinet ก่อน
            $('#odvModalSelectCabinet').modal('show');
        }else{
            $('#odvModalVendingLayout').modal('show');

            $('#oetVedNameLayout').val($('#ohdCabinetNameHidden').val());
            $('#oetVedFloorLayout').val($('#ospDetailCabinetRow').text());
            $('#oetVedColumnLayout').val($('#ospDetailCabinetColumn').text());
            $('#oetVedReasonLayout').val($('#ohdCabinetReasonHidden').val());

            JSxSettingHeight($('#ospDetailCabinetRow').text());
            //เก็บเอาไว้ว่าเข้ามาแบบ insert ข้อมูลว่าง หรือเข้ามาแบบ Edit ที่ควรมีข้อมูล
            if(ptType == 'EDIT'){
                JSxSelectShopSize();
            }
        }
    }

    //ถ้ามีข้อมูลเเล้วให่ไปเอา ข้อมูลในตาราง ความสูง กลับมาโชว์
    function JSxSelectShopSize(){
        $.ajax({
            type    : "POST",
            url     : "VendingLayoutSelectSetting",
            data    : { 
                tShpCode    : $('#ohdShpCode').val() , 
                tBchCode    : $('#ohdBchCode').val() ,
                nSeqCabinet : $('#ohdCabinetValue').val()
            },
            cache   : false,
            timeout : 0,
            success : function(tResult) {
                var aData = JSON.parse(tResult);
                $('#oetVedSettingHidden').val('EDIT');
                
                //ในส่วนของข้อมูลความสูง
                $('.xWTableSettingHeight > tbody').html('');
                var nCountFloor = $('#oetVedFloorLayout').val();
                for(j=1; j<=nCountFloor; j++){
                    var nValue = parseInt(100);
                    tHTMLAppend = '<tr>';
                    tHTMLAppend += '<th>'+j+'</th>';
                    tHTMLAppend += '<td>'+'<input type="text" class="form-control xCNInputNumericWithoutDecimal xWInputHeight" maxlength="4" id="oetVedHeight'+j+'" name="oetVedHeight'+j+'" value="'+nValue+'">'+'</td>';
                    tHTMLAppend += '</tr>';
                    $('.xWTableSettingHeight > tbody:last-child').append(tHTMLAppend);
                }

                //เอาความสูงจากฐานข้อมูลก่อน
                for(y=0; y<aData['aGetDataHeightTemp'].length; y++){
                    var tRowNumber      = aData['aGetDataHeightTemp'][y].FTRefPdtCode;
                    var tHeightNumber   = aData['aGetDataHeightTemp'][y].FTPdtCode;
                    $('#oetVedHeight'+tRowNumber).val(parseInt(tHeightNumber));
                }

                //เอาความสูงจากตารางสินค้า
                for(l=0; l<aData['aGetDataHeightFloor'].length; l++){
                    var tRowNumber      = aData['aGetDataHeightFloor'][l].FNLayRow;
                    var tHeightNumber   = aData['aGetDataHeightFloor'][l].FCLayHigh;
                    $('#oetVedHeight'+tRowNumber).val(parseInt(tHeightNumber));
                }

                $('#oetVedSettingHidden').val('EDIT');
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    //กำหนดความสูง
    function JSxSettingHeight(pnFloor){
        //กรณีเข้ามาครั้งเเรก
        $('.xWTableSettingHeight > tbody').html('');
        $('#oetVedFloorLayout').val(pnFloor);
        for(j=1; j<=pnFloor; j++){
            tHTMLAppend = '<tr>';
            tHTMLAppend += '<th>'+j+'</th>';
            tHTMLAppend += '<td>'+'<input type="text" class="form-control xCNInputNumericWithoutDecimal xWInputHeight" maxlength="4" id="oetVedHeight'+j+'" name="oetVedHeight'+j+'" value="100">'+'</td>';
            tHTMLAppend += '</tr>';
            $('.xWTableSettingHeight > tbody:last-child').append(tHTMLAppend);
        }

        //อีเว้นทุก key
        $('#oetVedFloorLayout').keyup(function() {
            //ล้างค่า
            $('.xWTableSettingHeight > tbody').html('');
            var nCountFloor = $('#oetVedFloorLayout').val();

            //ถ้าค่าว่างหรือ 0 กำหนดให้มี 1 ชั้น
            if(nCountFloor == '' || nCountFloor == null || nCountFloor == 0 ){
                nCountFloor = 1;
            }

            //วนลูปแล้วเพิ่มลงตารางกำหนดชั้น
            $('#oetVedFloorLayout').val(nCountFloor);
            for(j=1; j<=nCountFloor; j++){
                tHTMLAppend = '<tr>';
                tHTMLAppend += '<th>'+j+'</th>';
                tHTMLAppend += '<td>'+'<input type="text" class="form-control xCNInputNumericWithoutDecimal xWInputHeight" maxlength="4" id="oetVedHeight'+j+'" name="oetVedHeight'+j+'" value="100">'+'</td>';
                tHTMLAppend += '</tr>';
                $('.xWTableSettingHeight > tbody:last-child').append(tHTMLAppend);
            }
        });
    }

    //กดปุ่มยืนยันสร้าง Plan Diagram
    function JSxVendingConfirmCreateDiagram(){
        tRefresh = '';
        if($('#oetVedNameLayout').val() == ''){ $('#oetVedNameLayout').focus(); return; }
        if($('#oetVedColumnLayout').val() == '' || $('#oetVedColumnLayout').val() == 0){ $('#oetVedColumnLayout').focus();  return; }

        var tVBName     = $('#oetVedNameLayout').val();
        var nVBFloor    = parseInt($('#oetVedFloorLayout').val());
        var nVBColumn   = parseInt($('#oetVedColumnLayout').val());
        var tVBReason   = $('#oetVedReasonLayout').val();
        var aHeight     = [];
        for(k=1; k<=nVBFloor; k++){
            aHeight.push($('#oetVedHeight'+k).val());
        }
        
        if($('#oetVedSettingHidden').val() == 'EDIT'){

            var nFloorHidden    = parseInt($('#ospDetailCabinetRow').text());
            var nColumnHidden   = parseInt($('#ospDetailCabinetColumn').text());

            if(nVBFloor < nFloorHidden || nVBColumn < nColumnHidden){
                $('#odvModalVendingLayout').modal('hide');
                $('#odvModalFloorAndColumnReduce').modal('show');

                //ประเภทการ ถอย
                if(nVBFloor  < nFloorHidden){
                    var tDisType = 'FLOOR';
                }
                
                if(nVBColumn < nColumnHidden){
                    var tDisType = 'COLUMN';
                }

                //กดยืนยันคือต้องไปลบช้อมูลเก่า
                // console.log('คุณลดจำนวน : ' + tDisType);
                $('#odvModalFloorAndColumnReduceConfirm').off('click').on('click', function(){
                    $.ajax({
                        type    : "POST",
                        url     : "VendingLayoutInsertSetting",
                        data    : { 
                            tShpCode            : $('#ohdShpCode').val() , 
                            tBchCode            : $('#ohdBchCode').val() ,
                            tCabinetSeq         : $('#ohdCabinetValue').val(),
                            tVBName             : tVBName ,
                            nVBFloor            : nVBFloor ,
                            nVBColumn           : nVBColumn ,
                            tVBReason           : tVBReason ,
                            aHeight             : aHeight ,
                            tTypePage           : 'CONFIRM',
                            tDisType            : tDisType
                        },
                        cache   : false,
                        timeout : 0,
                        success : function(tResult) {
                            // console.log(tResult);
                            JCNxOpenLoading();
                            $('#odvModalFloorAndColumnReduce').modal('hide');
                            $('#odvModalVendingLayout').modal('hide');
                            setTimeout(function(){ JSvVEDDataList();  JCNxCloseLoading(); }, 1000);
                            var tDisType = '';
                            $('#odvModalFloorAndColumnReduceConfirm').off();
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                });

                //กดยกเลิกก็จะให้ text มันขึ้นแบบนี้
                $('#odvModalFloorAndColumnReduceCancle').click(function() {
                    $('#odvModalVendingLayout').modal('show');
                });
            }else{
                var bInsertSetting = true;
            }
        }else{
            var bInsertSetting = true;
        }

        if(bInsertSetting == true){
            $.ajax({
                type    : "POST",
                url     : "VendingLayoutInsertSetting",
                data    : { 
                    tShpCode            : $('#ohdShpCode').val() , 
                    tBchCode            : $('#ohdBchCode').val() ,
                    tCabinetSeq         : $('#ohdCabinetValue').val(),
                    tVBName             : tVBName ,
                    nVBFloor            : nVBFloor ,
                    nVBColumn           : nVBColumn ,
                    tVBReason           : tVBReason ,
                    aHeight             : aHeight ,
                    tTypePage           : $('#oetVedSettingHidden').val(),
                    tDisType            : ''
                },
                cache   : false,
                timeout : 0,
                success : function(tResult) {
                    // console.log(tResult);
                    JCNxOpenLoading();
                    $('#odvModalVendingLayout').modal('hide');

                    //ถ้าชื่อ และ เหตุผลไม่มีการเปลี่ยนแปลง จะไม่ต้องมีการ refresh
                    if( $('#ohdCabinetReasonHidden').val() == tVBReason || $('#ohdCabinetNameHidden').val() == tVBName ){
                        //ถ้าค่าใหม่ชื่อ เท่ากับ ค่าเก่า และ เหตุผลใหม่ เท่ากับ เหตุผลเก่าไม่ถูกเปลี่ยน
                        //ไม่อนุญาติให้รีเฟรส
                        if(nVBFloor != nFloorHidden || nVBColumn != nColumnHidden){
                            var tRefresh = true;
                        }else{
                            var tRefresh = false;
                        }
                    }else{
                        var tRefresh = true;
                    }

                    setTimeout(function(){ 
                        if(tRefresh == true){
                            JSvVEDDataList();  
                        }
                        JCNxCloseLoading(); 
                    }, 1000);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    }
</script>