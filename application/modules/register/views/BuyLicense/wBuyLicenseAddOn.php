<style>

    #otbListPos thead th, #otbListPos>thead>tr>th, #otbListPos tbody tr, #otbListPos>tbody>tr>td{
        border: 1px solid #FFF !important;
    }

    .xCNSeletedPosActive{
        background      : #179bfd !important;
        cursor          : pointer;
    }
</style>

<div class="panel-heading">
    <!--ข้อมูลส่วนบน-->
	<div class="row">
        <!--หัวข้อ ข้อมูลผู้ติดต่อ-->
		<div class="col-xs-12 col-md-12 col-lg-12">
			<div class="form-group">
				<label class="xCNLabelFrm"><?=language('register/buylicense/buylicense','tTitleInformation')?></label>
			</div>
            <div><hr></div>
		</div>

        <!--ข้อมูลผู้ติดต่อ-->
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="row">
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYNameCustomer') ?></label></div>
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=$aItemCustomer['rtRegBusName']?></label></div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYEmailCustomer') ?></label></div>
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=$aItemCustomer['rtCstMail']?></label></div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYTelCustomer') ?></label></div>
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=$aItemCustomer['rtCstTel']?></label></div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYCountbch') ?></label></div>
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=$aItemCustomer['rnRegQtyBch']?> <?=language('register/buylicense/buylicense', 'tBUYbch') ?></label></div>
            </div>
		</div>

        <!--ธุรกิจที่สนใจ-->
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"></div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="row">
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYTypeRegister') ?></label></div>
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=($aItemCustomer['rtRegLicType'] == 2) ? language('register/buylicense/buylicense', 'tBUYTypeReal') : language('register/buylicense/buylicense', 'tBUYTypeDemo') ?></label></div>
            </div>

            <?php if($aItemCustomer['rtRegBusOth'] != '' || $aItemCustomer['rtRegBusOth'] != null){ ?>
                <div class="row">
                    <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYTypeBusiness') ?></label></div>
                    <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm">
                    <?=$aItemCustomer['rtRegBusOth'];?>
                    </label></div>
                </div>  
            <?php } ?>

            <?php if($aPackageList['rtCode'] == 1){ ?>
                <div class="row">
                    <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYPackage') ?></label></div>
                    <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=$aPackageList['raItems'][0]['FTBuyLicenseTextPackage']?></label></div>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYCount') ?></label></div>
                    <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=$aPackageList['raItems'][0]['FTBuyLicenseTextPackageMonth']?></label></div>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYPrice') ?></label></div>
                    <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=number_format($aPackageList['raItems'][0]['FTBuyLicenseTextPackagePrice'],2)?></label></div>
                </div>
            <?php } ?>
            
        </div>

        <!--เก็บข้อมูลลูกค้า-->
        <input type="hidden" id="ohdCustomerInfo" name="ohdCustomerInfo" value='<?=json_encode($aItemCustomer)?>'>

        <div class="col-xs-12 col-md-12 col-lg-12">
            <div><hr></div>
        </div>
	</div>

    <!--ข้อมูลส่วนล่าง-->
    <div class="row">
        <!--หัวข้อ เลือกฟิเจอร์-->
		<div class="col-xs-12 col-md-12 col-lg-12">
			<div class="form-group">
				<label class="xCNLabelFrm"><?=language('register/buylicense/buylicense','tTitleFeatues')?>
                <?=language('register/buylicense/buylicense','tTitleFeatues2')?></label>
			</div>
		</div>

        <!--ค้นหาฟิเจอร์-->
        <div class="col-xs-8 col-sm-8 col-md-4 col-lg-4">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('common/main/main','tSearch')?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNInputWithoutSpc" id="oetSearchFeatues" name="oetSearchFeatues" placeholder="<?=language('common/main/main','tPlaceholder')?>">
                    <span class="input-group-btn">
                        <button class="btn xCNBtnSearch" type="button">
                            <img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <!--ตารางฟิเจอร์-->
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="table-responsive">
                <table id="otbFeatues" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center xCNTextBold" style="width:5%;"><?= language('register/buylicense/buylicense','tTBSelected')?></th>
                            <th class="text-center xCNTextBold" style="width:20%;"><?= language('register/buylicense/buylicense','tTBFeatues')?></th>
                            <th class="text-center xCNTextBold" ><?= language('register/buylicense/buylicense','tTBDetail')?></th>
                            <th class="text-center xCNTextBold" style="width:15%;"><?= language('register/buylicense/buylicense','tTBQty')?></th>
                            <th class="text-center xCNTextBold text-right" style="width:15%;"><?= language('register/buylicense/buylicense','tTBPrice')?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($aFeature['rtCode'] == '001'){ ?>
                            <?php for($i=0; $i<FCNnHSizeOf($aFeature['roItem']['raoDataFeature']); $i++){ ?>
                                <?php 
                                    $aItem = $aFeature['roItem']['raoDataFeature'][$i]; 
                                    $tFeatureCode = $aItem['rtPdtCode'];
                                    $tFeatureName = $aItem['rtPdtName'];
                                    $tFeatureRmk  = ($aItem['rtPdtRmk'] == '') ? '-' : $aItem['rtPdtRmk'];
                                ?>
                                <tr class="xCNFeature<?=$tFeatureCode?>" data-featurecode='<?=$tFeatureCode?>' data-detailfeature='<?=json_encode($aItem)?>'>
                                    <td nowrap class="text-center">
                                        <label class="fancy-checkbox ">
                                            <input id="ocbListItem_<?=$tFeatureCode?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                            <span class="">&nbsp;</span>
                                        <label>
                                    </td>
                                    <td nowrap class="text-left"><?=$tFeatureName?></td>
                                    <td nowrap class="text-left"><?=$tFeatureRmk?></td>
                                    
                                    <?php $tShowMonth = '' ?>
                                    <?php for($w=0; $w<FCNnHSizeOf($aItem['raoPrice']); $w++){ ?>
                                        <?php 
                                            $tPunCode     = $aItem['raoPrice'][$w]['rtPunCode']; 
                                            $tPunName     = $aItem['raoPrice'][$w]['rtPunName']; 
                                            $nPrice       = $aItem['raoPrice'][$w]['rcPgdPriceRet']; 
                                            $nFactor      = $aItem['raoPrice'][$w]['rcUnitFact']; 
                                        ?>
                                        <?php $tShowPrice = number_format($nPrice,2); ?>
                                        <?php $tShowMonth  .= '<option selected value="'.$tPunCode.'" data-factor="'.$nFactor.'" data-unit="'.$tPunCode.'" data-price="'.$tShowPrice.'">'.$tPunName.'</option>'; ?>
                                    <?php } ?>

                                    <td nowrap class="text-center">
                                        <select class="selectpicker form-control xCNFeaturemonth" id="ocmFeaturemonth" name="ocmFeaturemonth" maxlength="1" onchange="JSxFeatureMonthSelect(this,this.value)">
                                            <option value="0" data-price="0.00">- โปรดเลือก -</option>
                                            <?=$tShowMonth?>
                                        </select>
                                    </td>
                                    <td nowrap class="text-right xCNPriceFeature"><?=$tShowPrice?></td>
                                    <?php $tShowPrice = '0.00'; ?>
                                </tr>
                            <?php } ?>
                        <?php }else{ ?>
                            <!-- ไม่พบข้อมูล -->
                            <tr><td class='text-center xCNTextDetail2' colspan='5'><?= language('common/main/main','tMainRptNotFoundDataInDB')?></td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!--หัวข้อ เลือกจุดขาย-->
		<div class="col-xs-6 col-md-6 col-lg-6">
			<div class="form-group">
                <label class="xCNLabelFrm"><?=language('register/buylicense/buylicense','tTitlePosValidate')?>
                <?=language('register/buylicense/buylicense','tTitlePosValidate2')?></label>
			</div>
		</div>

        <!--เพิ่ม เลือกจุดขาย-->
		<div class="col-xs-6 col-md-6 col-lg-6 text-right">
			<div class="form-group">
                <button class="xCNBTNPrimeryPlus" type="button" onclick="JSxPopUpForAddOnPos()">+</button>
			</div>
		</div>

        <!--ตารางจุดขาย-->
        <div class="col-xs-12 col-md-12 col-lg-12" style="margin-top:10px;">
            <div class="table-responsive">
                <table id="otbBuyPos" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center xCNTextBold" style="width:5%;"><?= language('register/buylicense/buylicense','tTBSelected')?></th>
                            <th class="text-center xCNTextBold" style="width:5%;"><?= language('common/main/main','tModalDel')?></th>
                            <th class="text-center xCNTextBold" ><?= language('register/buylicense/buylicense','tTBList')?></th>
                            <th class="text-center xCNTextBold" style="width:15%;"><?= language('register/buylicense/buylicense','tTBQty')?></th>
                            <th class="text-center xCNTextBold text-right" style="width:15%;"><?= language('register/buylicense/buylicense','tTBPrice')?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="otrBuyPosEmpty"><td class='text-center xCNTextDetail2' colspan='5'><?= language('common/main/main','tMainRptNotFoundDataInDB')?></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>          
</div>

<!--Modal สำหรับเลือกเครื่องจุดขาย-->
<div class="modal fade" id="odvModalForAddOnPos">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('common/main/main', 'tTitlePos')?></label>
			</div>
			<div class="modal-body">
                <div class="row">
                    <!--ซ้ายเลือก-->
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <label class="xCNLabelFrm" style="margin-bottom:10px;"><?=language('register/buylicense/buylicense','tTitlePosSelect')?></label>
                        <div class="table-responsive">
                            <table id="otbPOS" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center xCNTextBold" style="width:8%;"><?= language('register/buylicense/buylicense','tCMNSequence')?></th>
                                        <th class="text-center xCNTextBold" ><?= language('register/buylicense/buylicense','tTBList')?></th>
                                        <th class="text-center xCNTextBold" style="width:20%;"><?= language('register/buylicense/buylicense','tBUYCount')?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($aPOS['rtCode'] == '001'){ ?>
                                        <?php $nNumber = 1; ?>
                                        <?php for($i=0; $i<FCNnHSizeOf($aPOS['roItem']['raoDataClientPos']); $i++){ ?>
                                            <?php $aItem = $aPOS['roItem']['raoDataClientPos'][$i]; ?>
                                            <tr class="xCNSeletedPos" data-codepos="<?=$aItem['rtPdtCode']?>" data-namepos="<?=$aItem['rtPdtName']?>">
                                                <td class='text-center'><?=$nNumber++?></td>
                                                <td class='text-left'><?=$aItem['rtPdtName']?></td>
                                                <td class='text-left'>
                                                    <div>
                                                        <input type="text" class="form-control xCNInputNumeric xCNValueCountPos" style="text-align: right;" maxlength="3" value="0">
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php }else{ ?>
                                        <tr><td class='text-center xCNTextDetail2' colspan='5'><?= language('common/main/main','tMainRptNotFoundDataInDB')?></td></tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!--ขวาสรุป-->
                    <!-- <div class="col-xs-6 col-md-6 col-lg-6">
                        <div class="table-responsive" style="margin-top:35px;">
                            <table id="otbListPos" class="table">
                                <thead style="border-bottom: 2px solid #e2e7eb  !important;">
                                    <tr>
                                        <th class="text-left xCNTextBold"><?= language('register/buylicense/buylicense','tTBInputList')?></th>
                                        <th class="text-right xCNTextBold" style="width:30%;"><?= language('register/buylicense/buylicense','tTBInputQty')?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class='otrListPosEmpty'><td class='text-center xCNTextDetail2' colspan='5'><?= language('common/main/main','tMainRptNotFoundDataInDB')?></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div> -->
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNPrimery" onclick="JSxConfirmBuyPos()"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<!--Modal จุดขายแต่ละตัว มีค่ามากกว่าหนึ่ง ต้องเเจ้งเตือน-->
<div class="modal fade" id="odvModalPosMoreOne" data-toggle="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('register/buylicense/buylicense', 'tTitlewarning')?></label>
			</div>
			<div class="modal-body">
                    <label class="xCNLabelFrm"> <?=language('register/buylicense/buylicense','tTBMorePosConfirmOrCancle')?></label>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNPrimery obtModalPosMoreOne_Confirm" data-dismiss="modal"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult obtModalPosMoreOne_Cancle" data-dismiss="modal"><?=language('common/main/main', 'tCancel')?></button>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
      
<script>    
    var aNotInFeature = '<?=json_encode($aNotInFeature); ?>';
    var aNotInFeature = JSON.parse(aNotInFeature);
    for(var i=0; i<aNotInFeature.length; i++){
        var tItem = aNotInFeature[i];
        $('.xCNFeature'+tItem).remove();

        var nLangTable = $("#otbFeatues tbody tr").length;
        if(nLangTable == 0){
            var tLangEmpty = '<?= language('common/main/main','tMainRptNotFoundDataInDB')?>';
            $("#otbFeatues tbody").append("<tr><td class='text-center xCNTextDetail2' colspan='5'>"+tLangEmpty+"</td></tr>")
        }
    }

    $('.selectpicker').selectpicker({
        dropupAuto: false
    });

    //เลือกจำนวนเดือน
    function JSxFeatureMonthSelect(elem,pnValue){
        if(pnValue == 0){
            $(elem).parent().parent().parent().find('.xCNPriceFeature').text('0.00');
            $(elem).parent().parent().parent().eq(0).find('.ocbListItem').prop('checked', false);
        }else{
            var nPrice = $(elem).find('option:selected').data('price');
            $(elem).parent().parent().parent().find('.xCNPriceFeature').text(nPrice);
        }
    }         
    
    //ค้นหา
    $("#oetSearchFeatues").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#otbFeatues tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    
    //เลือกเครื่องจุดขาย
    function JSxPopUpForAddOnPos(){
        //เปิด popup จุดขาย
        $('#odvModalForAddOnPos').modal('show');
        $('.xCNValueCountPos').val(0);
    }

    //เลือกจุดขาย
    $('.xCNSeletedPos').click(function(e) {
        // var nCodepos = $(this).data('codepos');
        // var tNamepos = $(this).data('namepos');
        // var tElem    = $(this);

        // //AddClass Hilight
        // var tTextOpenFilter = $(this).hasClass('openFilter');
		// if(tTextOpenFilter == true){
        //     $(this).removeClass('xCNSeletedPosActive');
        //     $(this).find('td').attr('style', 'color:#232C3D !important');
        //     $(this).removeClass('openFilter');

        //     //ลบ pos ลงตาราง list ด้านขวา
        //     JSxAddPosToTableList('-',nCodepos,tNamepos);
        // }else{
        //     $(this).addClass('xCNSeletedPosActive');
        //     $(this).find('td').attr('style', 'color:#FFF !important');
        //     $(this).addClass('openFilter');

        //     //เพิ่ม pos ลงตาราง list ด้านขวา
        //     // JSxAddPosToTableList('+',nCodepos,tNamepos);
        // }
    });

    //เพิ่ม pos ลงตาราง list ด้านขวา
    function JSxAddPosToTableList(ptType,pnCodePos,ptNamePos){
        // if(ptType == '+'){
        //     var tHTMLPos = '<tr data-codepos='+pnCodePos+' data-id="otrPosType'+pnCodePos+'">';
        //         tHTMLPos += '<td>';
        //         tHTMLPos += ptNamePos;
        //         tHTMLPos += '</td>';
        //         tHTMLPos += '<td class="text-right">';
        //         tHTMLPos += '<input type="text" id="oetTextCountPosType'+pnCodePos+'" class="form-control xCNInputNumericWithoutDecimal text-right" maxlength="5" value="1">';
        //         tHTMLPos += '</td>';
        //         tHTMLPos += '</tr>';

        //     //เพิ่มข้อมูลใหม่
        //     var bCheckClassFirst = $('#otbListPos tbody tr').hasClass('otrListPosEmpty');
        //     if(bCheckClassFirst == true){ $('#otbListPos tbody').empty(); }
        //     $('#otbListPos tbody').append(tHTMLPos);
        // }else if(ptType == '-'){
        //     var tIDRemove = 'otrPosType' + pnCodePos;

        //     //วนลูปตาราง ถ้าเจอตัวที่เอาออก ต้องเอาออก
        //     for(var i=0; i<$('#otbListPos tbody tr').length; i++){
        //         var tResult = $('#otbListPos tbody tr').eq(i).data('id');
        //         if(tIDRemove == tResult){
        //             $('#otbListPos tbody tr').eq(i).remove();
        //         }
        //     }

        //     //ถ้าลบจนเหลือตัวสุดท้าย ต้องเพิ่มให้เป็นค่าว่าง
        //     if($('#otbListPos tbody tr').length == 0){ 
        //         var tHTMLPos = '<tr class="otrListPosEmpty">';
        //             tHTMLPos += '<td class="text-center xCNTextDetail2" colspan="5"><?= language('common/main/main','tMainRptNotFoundDataInDB')?></td>';
        //             tHTMLPos += '</tr>';
        //         $('#otbListPos tbody').append(tHTMLPos);
        //     }
        // }
    }

    //ยืนยันเลือกเครื่องจุดขาย ลงตาราง
    function JSxConfirmBuyPos(){
        //ซ่อน popup จุดขาย
        $('#odvModalForAddOnPos').modal('hide');

        //ล้างค่าใหม่เสมอ
        $('#otbBuyPos tbody').empty();
        
        var bAppend = false;     
        for(var i=0; i<$('#otbPOS tbody tr').length; i++){ //loop ของจำนวนที่เลือก
            var nCountPos = $('#otbPOS tbody tr:eq('+i+') td').eq(2).find('input').val();
            if(nCountPos > 0){
                bAppend = true;  
                continue;
            }
        }

        //ถ้ามีค่าจะ ให้ table ล่าง แต่ถ้าไม่มี จะให้เพิ่มข้อมูลว่างๆ
        if(bAppend == true){
            $('#otbBuyPos tbody').empty();
        }else{
            var tHTMLPos = '<tr class="otrBuyPosEmpty">';
                tHTMLPos += '<td class="text-center xCNTextDetail2" colspan="5"><?= language('common/main/main','tMainRptNotFoundDataInDB')?></td>';
                tHTMLPos += '</tr>';
            $('#otbBuyPos tbody').append(tHTMLPos); 
        }

        //ถ้ามีค่ามาจะต้องเอาไป insert
        var aPosInJS            = '<?=json_encode($aPOS['roItem']['raoDataClientPos'])?>';
        var aPosInJS            = JSON.parse(aPosInJS);
        var nNumber             = 1;
        var oDelete             = "onclick='JSxClickDeletePos(this);'"
        var tObjectImageDelete  = "<img class='xCNDeletePos xCNIconTable xCNIconDel' " + oDelete + " src='<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>'>";
        var tHTMLPos            = '';
        for(var i=0; i<$('#otbPOS tbody tr').length; i++){ //loop ของจำนวนที่เลือก
            var nCountPos = $('#otbPOS tbody tr:eq('+i+') td').eq(2).find('input').val();
            if(nCountPos > 0){
                var tCodePos  = $('#otbPOS tbody tr:eq('+i+')').data('codepos');
                //เอาจำนวนที่กรอกมา วนลูป
                for(var j=0; j<nCountPos; j++){ //loop ของจำนวนที่เลือก + ของจำนวนที่คีย์
                    tHTMLPos += '<tr>';
                    tHTMLPos += '<td class="text-center">' + nNumber + '</td>';
                    tHTMLPos += '<td class="text-center">' + tObjectImageDelete + '</td>';
                    tHTMLPos += '<td class="text-left">' + $('#otbPOS tbody tr:eq('+i+') td').eq(1).text() + '</td>';

                    for(var w=0; w<aPosInJS.length; w++){ //loop ของจำนวนเดือน
                        var tArrayCodePos = aPosInJS[w].rtPdtCode;
                        if(tCodePos == tArrayCodePos){
                            var tArrayPrice     = aPosInJS[w].raoPrice;
                            var tStaVat         = aPosInJS[w].rtStaVat;
                            var tVatCode        = aPosInJS[w].rtVatCode;
                            var cVatRate        = aPosInJS[w].rcVatRate;
                            var tStaAlwDis      = aPosInJS[w].rtStaAlwDis;
                            var tStaSet         = aPosInJS[w].rtStaSet;
                            var tVATInOrEx      = aPosInJS[w].rtVATInOrEx;
                            var tPosOption      = '';
                            var tPriceShow      = number_format(tArrayPrice[0].rcPgdPriceRet,2);
                            for(var b=0; b<tArrayPrice.length; b++){ //loop ของจำนวนเดือน + ราคา
                                tPosPrice   = number_format(tArrayPrice[b].rcPgdPriceRet,2);
                                tPosOption  += '<option value="'+tArrayPrice[b].rtPunCode+'" ';
                                tPosOption  += 'data-tPdtCode="'+tArrayCodePos+'" ';
                                tPosOption  += 'data-tVATInOrEx="'+tVATInOrEx+'" ';
                                tPosOption  += 'data-tStaVat="'+tStaVat+'" ';
                                tPosOption  += 'data-tVatCode="'+tVatCode+'" ';
                                tPosOption  += 'data-cVatRate="'+cVatRate+'" ';
                                tPosOption  += 'data-tStaAlwDis="'+tStaAlwDis+'" ';
                                tPosOption  += 'data-tStaSet="'+tStaSet+'" ';
                                tPosOption  += 'data-nFactor="'+tArrayPrice[b].rcUnitFact+'" ';
                                tPosOption  += 'data-unitcode="'+tArrayPrice[b].rtPunCode+'" data-price="'+tPosPrice+'">'+tArrayPrice[b].rtPunName+'</option>';
                            }
                        }
                    }

                    tHTMLPos += '<td class="text-center">';
                    tHTMLPos += '<select class="selectpicker form-control xCNPosmonth" id="ocmPosmonth" name="ocmPosmonth" maxlength="1" onchange="JSxPosMonthSelect(this,this.value)">';
                    tHTMLPos += tPosOption
                    tHTMLPos += '</select>';
                    tHTMLPos += '</td>';
                    tHTMLPos += '<td class="text-right xCNPricePos">' + tPriceShow + '</td>';
                    tHTMLPos += '</tr>';
                    nNumber++;
                }
            }
        }

        $('#otbBuyPos tbody').append(tHTMLPos);
        $('.selectpicker').selectpicker({
            dropupAuto: false
        });
    }

    //ลบ Pos
    function JSxClickDeletePos(elem){
        $(elem).parent().parent().remove();

        var nCheckTobody = $('#otbBuyPos tbody tr').length;
        if(nCheckTobody == 0){
            var tLangEmpty = '<?= language('common/main/main','tMainRptNotFoundDataInDB')?>';
            $("#otbBuyPos tbody").append("<tr><td class='text-center xCNTextDetail2' colspan='5'>"+tLangEmpty+"</td></tr>");
        }else{
            var nNumber = 1;
            for(var i=0; i<nCheckTobody; i++){
                $("#otbBuyPos tbody tr:eq("+i+") td").eq(0).text(nNumber);
                nNumber++;
            }
        }
    }

    //เลือกจำนวนเดือน
    function JSxPosMonthSelect(elem,pnValue){
        if(pnValue == 0){
            $(elem).parent().parent().parent().find('.xCNPricePos').text('0.00');
        }else{
            var nPrice = $(elem).find('option:selected').data('price');
            $(elem).parent().parent().parent().find('.xCNPricePos').text(nPrice);
        }
    }    

    //Number_Format In JS
    function number_format(number, decimals, decPoint, thousandsSep) { 
		number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
		const n = !isFinite(+number) ? 0 : +number
		const prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
		const sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
		const dec = (typeof decPoint === 'undefined') ? '.' : decPoint
		let s = ''
		const toFixedFix = function (n, prec) {
			if (('' + n).indexOf('e') === -1) {
			return +(Math.round(n + 'e+' + prec) + 'e-' + prec)
			} else {
			const arr = ('' + n).split('e')
			let sig = ''
			if (+arr[1] + prec > 0) {
				sig = '+'
			}
			return (+(Math.round(+arr[0] + 'e' + sig + (+arr[1] + prec)) + 'e-' + prec)).toFixed(prec)
			}
		}
		// @todo: for IE parseFloat(0.55).toFixed(0) = 0;
		s = (prec ? toFixedFix(n, prec).toString() : '' + Math.round(n)).split('.')
		if (s[0].length > 3) {
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
		}
		if ((s[1] || '').length < prec) {
			s[1] = s[1] || ''
			s[1] += new Array(prec - s[1].length + 1).join('0')
		}
		return s.join(dec)
	}
</script>