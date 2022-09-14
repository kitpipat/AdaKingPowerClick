<style>
    .xCNFilterFmt{
        padding             : 10px;
    }

    .xCNFilterFmt:hover{
        background-color    : #179bfd;
        color               : #FFF; 
        cursor              : pointer;
    }

    .xCNFilterLine{
        border-top          : 1px solid #e4e4e4;
    }

    .xCNResultFmt{
        background-color    : #f0f0f0;
        padding             : 10px;
    }

    .xCNLineResult{
        background          : #d5d5d5;
        width               : 1px;
    }

    #ospFormatResult{
        margin-left         : 10px;
        background-color    : transparent;
        border              : transparent;
        box-shadow          : inset 0 0px 0px rgba(0, 0, 0, .0);
        border-left         : 1px solid #d5d5d5; 
    }
</style>

<?php
//ดักว่าเข้ามาแบบ มีข้อมูล หรือ ยัง
if($aAllowItem['raItems'][0]['FormatCustom'] == ''){
    $tEventControlNullorCustom = 'NULL';
}else{
    $tEventControlNullorCustom = 'CUSTOM';
}
?>

<?php $tTableAuto = $aAllowItem['raItems'][0]['FTSatTblName']; ?>
<?php $tFiledAuto = $aAllowItem['raItems'][0]['FTSatFedCode']; ?>
<?php $tDocType   = $aAllowItem['raItems'][0]['FTSatStaDocType']; ?>

<div class="row">
    <!--รายละเอียด-->
    <div class="col-lg-12" style="margin-bottom: 15px;">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <label class="xCNLabelFrm" style="color: #179bfd !important; cursor:pointer;" onclick="JSvSettingNumberLoadViewSearch();">
                    <?=language('settingconfig/settingconfig/settingconfig','tTitleTab2Settingconfig');?>
                </label>

                <label class="xCNLabelFrm" style="color: #aba9a9 !important;">
                    / <?=$aAllowItem['raItems'][0]['FTSatTblDesc']?>
                </label>
            </div>

            <div class="col-lg-4 col-md-4">
                <div class="text-right">
                <div class="text-right">
                    <button type="button" onclick="JSvSettingNumberLoadViewSearch();" class="btn" style="background-color: #D4D4D4; color: #000000;">
                        <?=language('common/main/main','tCancel');?>
                    </button>
                    <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" onclick="JSoEventSaveAutoNumber()">
                        <?=language('common/main/main','tSave');?>
                    </button>
                </div>
                </div>
            </div>
        </div>
    </div>

    <!--เลือกข้อมูล-->
    <div class="col-lg-3 col-md-4">
        <div class="panel panel-default" style="margin-bottom: 25px;"> 
            <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?=language('settingconfig/settingconfig/settingconfig','tPageUpdatePanel1TableFormat');?></label>
            </div>
            <div id="odvTableFormat">
                <div class="panel-body">
                    <?php foreach($aAllowItem['raItems'] AS $key=>$aValue){ ?>
                        <!--รหัสตัวอักษร-->
                        <?php if($aValue['FTSatStaAlwChr'] != '' || $aValue['FTSatStaAlwChr'] != null){ ?>
                            <div class="xCNFilterFmt xCNAlwChr" data-CharVal='<?=$aValue['FTSatDefChar']?>' data-Filter='CHAR' data-FilterName='<?=language('settingconfig/settingconfig/settingconfig','tPageUpdateFilterCHAR');?>'>
                                <span><?=language('settingconfig/settingconfig/settingconfig','tPageUpdateFilterCHAR');?></span>
                            </div>
                        <?php } ?>

                        <!--สาขา-->
                        <?php if($aValue['FTSatStaAlwBch'] == 1){ ?>
                            <div class="xCNFilterLine"></div>
                            <div class="xCNFilterFmt xCNAlwBch" data-Filter='BCH' data-FilterName='<?=language('settingconfig/settingconfig/settingconfig','tPageUpdateFilterBCH');?>'>
                                <span><?=language('settingconfig/settingconfig/settingconfig','tPageUpdateFilterBCH');?></span>
                            </div>
                        <?php } ?>
                        
                        <!--เครื่องจุดขาย-->
                        <?php if($aValue['FTSatStaAlwPosShp'] == 1){ ?>
                            <div class="xCNFilterLine"></div>
                            <div class="xCNFilterFmt xCNAlwPos" data-Filter='POSSHP' data-FilterName='<?=language('settingconfig/settingconfig/settingconfig','tPageUpdateFilterPOSShp');?>'>
                                <span><?=language('settingconfig/settingconfig/settingconfig','tPageUpdateFilterPOSShp');?></span>
                            </div>
                        <?php } ?>

                        <!--ปี-->
                        <?php if($aValue['FTSatStaAlwYear'] == 1){ ?>
                            <div class="xCNFilterLine"></div>
                            <div class="xCNFilterFmt xCNAlwYear" data-Filter='YEAR' data-FilterName='<?=language('settingconfig/settingconfig/settingconfig','tPageUpdateFilterYear');?>'>
                                <span><?=language('settingconfig/settingconfig/settingconfig','tPageUpdateFilterYear');?></span>
                            </div>
                        <?php } ?>

                        <!--เดือน-->
                        <?php if($aValue['FTSatStaAlwMonth'] == 1){ ?>
                            <div class="xCNFilterLine"></div>
                            <div class="xCNFilterFmt xCNAlwMonth" data-Filter='MONTH' data-FilterName='<?=language('settingconfig/settingconfig/settingconfig','tPageUpdateFilterMonth');?>'>
                                <span><?=language('settingconfig/settingconfig/settingconfig','tPageUpdateFilterMonth');?></span>
                            </div>
                        <?php } ?>

                        <!--วัน-->
                        <?php if($aValue['FTSatStaAlwDay'] == 1){ ?>
                            <div class="xCNFilterLine"></div>
                            <div class="xCNFilterFmt xCNAlwDay" data-Filter='DAY' data-FilterName='<?=language('settingconfig/settingconfig/settingconfig','tPageUpdateFilterDay');?>'>
                                <span><?=language('settingconfig/settingconfig/settingconfig','tPageUpdateFilterDay');?></span>
                            </div>
                        <?php } ?>

                        <!--ไม่พบข้อมูล-->
                        <?php if($aValue['FTSatStaAlwBch'] == 0 &&
                                 $aValue['FTSatStaAlwPosShp'] == 0 &&
                                 $aValue['FTSatStaAlwYear'] == 0 &&
                                 $aValue['FTSatStaAlwMonth'] == 0 &&
                                 $aValue['FTSatStaAlwDay'] == 0){ ?>
                            <div class="xCNFilterFmt">
                                <span><?=language('common/main/main','tCMNNotFoundData');?></span>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>    
        </div>
    </div>

    <!--จัดรูปแบบ-->
    <div class="col-lg-9 col-md-8">
        <div class="panel panel-default" style="margin-bottom: 25px;"> 
            <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?=language('settingconfig/settingconfig/settingconfig','tPageUpdatePanel2TableFormat');?></label>
            </div>
            <div id="odvDataFormat">
                <div class="panel-body">
                    <table id="otbFmt" class="table table-striped" style="width:100%">
                        <thead>
                            <tr class="xCNCenter">
                                <th class="xCNTextBold" style="text-align:left; width:50px;"><?= language('settingconfig/settingconfig/settingconfig','tTableNumber')?></th>
                                <th class="xCNTextBold" style="text-align:left; width:300px;"><?= language('settingconfig/settingconfig/settingconfig','tTableData')?></th>
                                <th class="xCNTextBold" style="text-align:left;"><?= language('settingconfig/settingconfig/settingconfig','tTableFormat')?></th>
                                <th class="xCNTextBold" style="text-align:center; width:90px;"><?= language('settingconfig/settingconfig/settingconfig','tTableReset')?></th>
                                <th class="xCNTextBold" style="text-align:center; width:90px;"><?= language('settingconfig/settingconfig/settingconfig','tTableDelete')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="otrEmpty">
                                <td class='text-center xCNTextDetail2' colspan='10'><?= language('common/main/main','tCMNNotFoundData')?></td>
                            </tr>
                        </tbody>
                    </table>            
                </div>
            </div>
        </div>
    </div>

    <?php $nMaxSizeAll = $aAllowItem['raItems'][0]['FNSatMaxFedSize']; ?>
    <?php $MaxRunning  = strlen($aAllowItem['raItems'][0]['FTSatDefNum']); ?>
    <?php if($nMaxFiledSizeBCH['rtCode'] == 1){ $nMaxSizeBCH = $nMaxFiledSizeBCH['raItems'][0]['FNSatMaxFedSize']; }else{ $nMaxSizeBCH = 0; }?>
    <?php if($nMaxFiledSizePOS['rtCode'] == 1){ $nMaxSizePOS = $nMaxFiledSizePOS['raItems'][0]['FNSatMaxFedSize']; }else{ $nMaxSizePOS = 0; }?>

    <!--ผลลัพท์-->
    <div class="col-lg-3"></div>
    <div class="col-lg-9 col-md-8">
        <div class="panel panel-default" style="margin-bottom: 25px;"> 
            <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?=language('settingconfig/settingconfig/settingconfig','tPageUpdatePanel3TableFormat');?></label>
            </div>
            <div id="odvResultFormat">
                <div class="panel-body">
                                    
                    <!--ใช้รหัสเริ่มต้นเท่าไหร่-->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?=language('settingconfig/settingconfig/settingconfig', 'tFmtUserStart'); ?></label>
                        <div class="input-group" style="width: 100%;">
                            <input class="xCNInputNumericWithDecimal" style="text-align: right;" name="oetFmtUsrNum" id="oetFmtUsrNum" maxlength="<?=$MaxRunning?>" type="text" value="<?=$aAllowItem['raItems'][0]['FTSatDefNum']?>" autocomplete="off" placeholder="<?=language('settingconfig/settingconfig/settingconfig', 'tFmtUserStart'); ?>">
                        </div>
                    </div>

                    <!--ความกว้าง-->
                    <!-- <div class="form-group">
                        <label class="xCNLabelFrm"><?=language('settingconfig/settingconfig/settingconfig', 'tAllowFmtWidth'); ?></label>
                        <div class="input-group" style="width: 100%;"> -->
                            <input class="xCNInputNumericWithDecimal" style="text-align: right;" name="oetFmtWidth" id="oetFmtWidth" maxlength="2" type="hidden" value="<?=$aAllowItem['raItems'][0]['FNSatMinRunning']?>" autocomplete="off" placeholder="<?=language('settingconfig/settingconfig/settingconfig', 'tAllowFmtWidth'); ?>">
                            <input name="oetFmtWidthOld" id="oetFmtWidthOld" maxlength="2" type="hidden" value="<?=$aAllowItem['raItems'][0]['FNSatMinRunning']?>">
                        <!-- </div>
                    </div> -->

                    <!--อนุญาติให้ใช้คั่น-->
                    <?php if($aAllowItem['raItems'][0]['FTSatStaDefUsage'] == '1'){ $tCheck = 'checked'; }else{ $tCheck = ''; } ?>
                    <label class="fancy-checkbox">
                        <input type="checkbox" id="ocbUseFmtSpc" name="ocbUseFmtSpc" <?=$tCheck;?> value="1">
                        <span><?=language('settingconfig/settingconfig/settingconfig', 'tAllowFmtHaveDis'); ?></span>
                    </label> 

                    <div class="xCNResultFmt" style="margin:10px 0px;">
                        <div class="row">
                            <div class="col-lg-4 col-md-4"><span style="font-weight: bold;"><?=language('settingconfig/settingconfig/settingconfig', 'tFmtTypeUsr'); ?></span></div>
                            <div class="col-lg-8 col-md-8">
                                <input type="text" id="ospFormatResult" readonly>
                                <input type="hidden" id="ospFormatResultLen" value="" >
                            </div>
                        </div>
                    </div>

                    <!--อนุญาติให้ใช้คั่น-->
                    <label class="fancy-checkbox">
                        <input type="checkbox" id="ocbUseFmtDefault" name="ocbUseFmtDefault"  value="1">
                        <span><?=language('settingconfig/settingconfig/settingconfig', 'tFmtTypeDef'); ?></span>
                    </label> 

                    <div class="xCNResultFmt" style="margin:10px 0px;">
                        <div class="row">
                            <div class="col-lg-4 col-md-4"><span style="font-weight: bold;"><?=language('settingconfig/settingconfig/settingconfig', 'tFmtTypeDef'); ?></span></div>
                            <div class="col-lg-8 col-md-8">
                                <input type="text" id="ospFormatDefault" readonly value="<?= $aAllowItem['raItems'][0]['FTSatDefFmtAll'] ?>">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    //รูปแบบ Format ที่ถูกต้อง
    var tFmtCustomCodeOld   = 0;
    var tLenCode            = 0;
</script>

<!--U P D A T E-->
<script>
    var tCustom = '<?=$tEventControlNullorCustom;?>';
    if(tCustom == 'CUSTOM'){

        //รหัสเริ่มต้น
        var tStartCode  =   '<?=$aAllowItem['raItems'][0]['FTSatUsrNum'];?>';
        var tStartCode  =   $('#oetFmtUsrNum').val(tStartCode);
        var tDemoCode   =   $('#oetFmtWidth').val(tStartCode.length);
                            $('#oetFmtWidthOld').val(tStartCode.length)
        $('#oetFmtUsrNum').change(function() { 
            var tStartCode = $('#oetFmtUsrNum').val();
            var tDemoCode = $('#oetFmtWidth').val(tStartCode.length);

            $('#oetFmtWidth').change();
        });

        //ใช้อะไรได้บ้าง
        var tFmtCustominDB = '<?=$aAllowItem['raItems'][0]['FTAhmFmtPst'];?>';
        if(tFmtCustominDB != '' || tFmtCustominDB != null){
            var aResult = tFmtCustominDB.split(",");

            if(aResult[0] == '' || aResult[0] == null){
                //ไม่มีค่า
                
            }else{
                if($('#otbFmt tbody tr').hasClass('otrEmpty') == true){
                    $('#otbFmt tbody').html('');
                }
            }

            var tMaxLength_char     = 0;
            var tMaxLength_bch      = 0;
            var tMaxLength_year     = 0;
            var tMaxLength_month    = 0;
            var tMaxLength_day      = 0;
            var tLastInTable        = 0;
            if(aResult.length >= 1){
                for(i=0; i<aResult.length; i++){
                    var tFilter         = aResult[i];
                    var nCount          = i + 1;
                    switch (tFilter) {
                        case 'CHA' :
                            var tConvertFilterText = 'CHAR';
                        break;
                        case 'BCH' :
                            var tConvertFilterText = 'BCH';
                        break;
                        case 'YYYY':
                        case 'YY':
                            var tConvertFilterText = 'YEAR';
                        break;
                        case 'MM':
                            var tConvertFilterText = 'MONTH';
                        break;
                        case 'DD':
                            var tConvertFilterText = 'DAY';
                        break;
                        default:
                            var tConvertFilterText = '';
                    }

                    switch (tConvertFilterText) {
                        case 'CHAR':
                            var tFilterName   = '<?=language('settingconfig/settingconfig/settingconfig','tPageUpdateFilterCHAR');?>';
                            var tCharVal =  '<?=$aAllowItem['raItems'][0]['FTAhmFmtChar']?>'; 
                                tMaxLength_char = tCharVal.length;
                                tLastInTable = tCharVal.length;
                            var tHTML_TD = '<td>'+nCount+'</td>';
                                tHTML_TD += '<td>'+tFilterName+'</td>';
                                tHTML_TD += '<td><div class="input-group" style="width: 100%;"><input onchange="JSxChangeChar();" name="oetFmtChar" id="oetFmtChar" type="Text" maxlength="5" value="'+tCharVal+'"></div></td>';
                                tHTML_TD += '<input name="oetFmtCharOld" id="oetFmtCharOld" type="hidden" maxlength="5" value="'+tCharVal+'">'
                                tHTML_TD += '<td class="text-center">-</td>';
                                tHTML_TD += '<td nowarp class="text-center"><img class="xCNIconTable xCNIconDelete" onclick="JSxDeleteRow(this)"></td>';
                        break;
                        case 'BCH':
                            var tFilterName   = '<?=language('settingconfig/settingconfig/settingconfig','tPageUpdateFilterBCH');?>';
                                tMaxLength_bch = '<?=$nMaxSizeBCH?>';
                                tLastInTable = '<?=$nMaxSizeBCH?>';
                            var tHTML_TD = '<td>'+nCount+'</td>';
                                tHTML_TD += '<td>'+tFilterName+'</td>';
                                tHTML_TD += '<td><div class="input-group" style="width: 100%;"><input type="Text" readonly></div></td>';
                                tHTML_TD += '<td class="text-center"><label class="fancy-checkbox"><input type="checkbox" id="ocbResetBCH" name="ocbResetBCH" value="1"><span></span></label></td>';
                                tHTML_TD += '<td nowarp class="text-center"><img class="xCNIconTable xCNIconDelete" onclick="JSxDeleteRow(this)"></td>';
                        break;
                        case 'YEAR':
                            var tFmtYear = '<?=$aAllowItem['raItems'][0]['FTAhmFmtYear'];?>';
                            if(tFmtYear == 1){var tFmtYearYY = 'selected'; tMaxLength_year = 2; tLastInTable = 2;}else{ var tFmtYearYY = '';  }
                            if(tFmtYear == 2){var tFmtYearYYYY = 'selected'; tMaxLength_year = 4; tLastInTable = 4;}else{var tFmtYearYYYY = '';  }

                            var tFilterName   = '<?=language('settingconfig/settingconfig/settingconfig','tPageUpdateFilterYear');?>';
                            var tHTML_TD = '<td>'+nCount+'</td>';
                                tHTML_TD += '<td>'+tFilterName+'</td>';
                                tHTML_TD += '<td><select class="selectpicker form-control" onchange="JSxChangeYear();" id="ocmFmtYearType" name="ocmFmtYearType" maxlength="1" readonly>';
                                tHTML_TD += '<option value="YYYY" '+tFmtYearYYYY+'>YYYY</option>';
                                tHTML_TD += '<option value="YY" '+tFmtYearYY+'>YY</option>';
                                tHTML_TD += '</select></td>';
                                tHTML_TD += '<td class="text-center"><label class="fancy-checkbox"><input type="checkbox" id="ocbResetYear" name="ocbResetYear" value="1"><span></span></label></td>';
                                tHTML_TD += '<td nowarp class="text-center"><img class="xCNIconTable xCNIconDelete" onclick="JSxDeleteRow(this)"></td>';
                        break;
                        case 'MONTH':
                            var tFilterName   = '<?=language('settingconfig/settingconfig/settingconfig','tPageUpdateFilterMonth');?>';
                            tMaxLength_month  = 2;
                            tLastInTable = 2;
                            var tHTML_TD = '<td>'+nCount+'</td>';
                                tHTML_TD += '<td>'+tFilterName+'</td>';
                                tHTML_TD += '<td><div class="input-group" style="width: 100%;"><input name="oetFmtMonth" id="oetFmtMonth" type="Text" maxlength="5" value="MM" readonly></div></td>';
                                tHTML_TD += '<td class="text-center"><label class="fancy-checkbox"><input type="checkbox" id="ocbResetMonth" name="ocbResetMonth" value="1"><span></span></label></td>';
                                tHTML_TD += '<td nowarp class="text-center"><img class="xCNIconTable xCNIconDelete" onclick="JSxDeleteRow(this)"></td>';
                        break;
                        case 'DAY':
                            var tFilterName   = '<?=language('settingconfig/settingconfig/settingconfig','tPageUpdateFilterDay');?>';
                            tMaxLength_day    = 2;
                            tLastInTable = 2;
                            var tHTML_TD = '<td>'+nCount+'</td>';
                                tHTML_TD += '<td>'+tFilterName+'</td>';
                                tHTML_TD += '<td><div class="input-group" style="width: 100%;"><input name="oetFmtDay" id="oetFmtDay" type="Text" maxlength="5" value="DD" readonly></div></td>';
                                tHTML_TD += '<td class="text-center"><label class="fancy-checkbox"><input type="checkbox" id="ocbResetDay" name="ocbResetDay" value="1"><span></span></label></td>';
                                tHTML_TD += '<td nowarp class="text-center"><img class="xCNIconTable xCNIconDelete" onclick="JSxDeleteRow(this)"></td>';
                        break;
                        default:
                            var tHTML_TD = '';
                    }

                    if(tConvertFilterText == '' || tConvertFilterText == null){

                    }else{
                        var tHTML = '<tr class="otr'+tConvertFilterText+'" data-Filter="'+tConvertFilterText+'">';
                        tHTML += tHTML_TD;
                        tHTML += '</tr>';
                        $('#otbFmt tbody').append(tHTML);
                        $('.selectpicker').selectpicker();
                    }
                }
            }
        }

        //อนุญาต reset 
        var tFiledReset = '<?=$aAllowItem['raItems'][0]['FTAhmFmtReset'];?>';
        if(tFiledReset != '' || tFiledReset != null){
            var aResultReset = tFiledReset.split(",");
            if(aResultReset.length >= 1){
                for(i=0; i<aResultReset.length; i++){
                    switch (aResultReset[i]) {
                        case 'BCH' :
                            $('#ocbResetBCH').prop( "checked", true );
                        break;
                        case 'YYYY':
                        case 'YY':
                            $('#ocbResetYear').prop( "checked", true );
                        break;
                        case 'MM':
                            $('#ocbResetMonth').prop( "checked", true ); 
                        break;
                        case 'DD':
                            $('#ocbResetDay').prop( "checked", true ); 
                        break;
                    }
                }
            }
        }

        //อนุญาตขีด
        var tFmtSep = '<?=$aAllowItem['raItems'][0]['FTSatStaAlwSep'];?>';
        tMaxLength_Sep = 0;
        if(tFmtSep == 1 ){
            $('#ocbUseFmtSpc').prop("checked",true);
            tMaxLength_Sep = 1;
        }

        //รหัส number ######
        var tCustomCodeAllResult    = '<?=$aAllowItem['raItems'][0]['FNAhmNumSize'];?>';
        $('#oetFmtWidth').val(tCustomCodeAllResult);
        $('#oetFmtWidthOld').val(tCustomCodeAllResult);
        
        //ตัวเลขในช่อง
        var tFmtSize = parseInt(tMaxLength_Sep) + parseInt(tCustomCodeAllResult) + parseInt(tMaxLength_char) + parseInt(tMaxLength_bch) + parseInt(tMaxLength_year) + parseInt(tMaxLength_month) + parseInt(tMaxLength_day);
        $('#ospFormatResultLen').val(tFmtSize);

        var tNumberUse = parseInt(tMaxLength_char) + parseInt(tMaxLength_bch) + parseInt(tMaxLength_year) + parseInt(tMaxLength_month) + parseInt(tMaxLength_day);
        tFmtCustomCodeOld = parseInt(tFmtSize) - parseInt(Math.abs(tLastInTable));
    }
</script>

<!--I N S E R T-->
<script>

    //รหัสเริ่มต้น
    var tStartCode  =   $('#oetFmtUsrNum').val();
    var tDemoCode   =   $('#oetFmtWidth').val(tStartCode.length);
                        $('#oetFmtWidthOld').val(tStartCode.length)
    $('#oetFmtUsrNum').change(function() { 
        var tStartCode = $('#oetFmtUsrNum').val();
        var tDemoCode = $('#oetFmtWidth').val(tStartCode.length);

        $('#oetFmtWidth').change();
    });


    $('.xCNFilterFmt').click(function(e) {
        var tFilter         = $(this).attr("data-Filter");
        var tFilterName     = $(this).attr("data-FilterName");

        //Check ค่าก่อนถ้าในตารางมีต้องล้างค่า
        if($('#otbFmt tbody tr').hasClass('otrEmpty') == true){
            $('#otbFmt tbody').html('');
        }

        //Check ค่าว่าถ้ามีซ้ำ ให้เพิ่มไม่ได้
        if($('#otbFmt tbody tr').hasClass('otr'+tFilter) == true){
            //เจอค่าซ้ำ
        }else{
            var nCount = $('#otbFmt tbody tr').length + 1;
            switch (tFilter) {
                case 'CHAR':
                    var tCharVal = $(this).attr("data-CharVal"); 
                    var tHTML_TD = '<td>'+nCount+'</td>';
                        tHTML_TD += '<td>'+tFilterName+'</td>';
                        tHTML_TD += '<td><div class="input-group" style="width: 100%;"><input onchange="JSxChangeChar();" name="oetFmtChar" id="oetFmtChar" type="Text" maxlength="5" value="'+tCharVal+'"></div></td>';
                        tHTML_TD += '<input name="oetFmtCharOld" id="oetFmtCharOld" type="hidden" maxlength="5" value="'+tCharVal+'">'
                        tHTML_TD += '<td class="text-center">-</td>';
                        tHTML_TD += '<td nowarp class="text-center"><img class="xCNIconTable xCNIconDelete" onclick="JSxDeleteRow(this)"></td>';
                break;
                case 'BCH':
                    var tHTML_TD = '<td>'+nCount+'</td>';
                        tHTML_TD += '<td>'+tFilterName+'</td>';
                        tHTML_TD += '<td><div class="input-group" style="width: 100%;"><input type="Text" readonly></div></td>';
                        tHTML_TD += '<td class="text-center"><label class="fancy-checkbox"><input type="checkbox" id="ocbResetBCH" name="ocbResetBCH" value="1"><span></span></label></td>';
                        tHTML_TD += '<td nowarp class="text-center"><img class="xCNIconTable xCNIconDelete" onclick="JSxDeleteRow(this)"></td>';
                break;
                case 'POSSHP':
                    var tHTML_TD = '<td>'+nCount+'</td>';
                        tHTML_TD += '<td>'+tFilterName+'</td>';
                        tHTML_TD += '<td><div class="input-group" style="width: 100%;"><input type="Text" readonly></div></td>';
                        tHTML_TD += '<td class="text-center"><label class="fancy-checkbox"><input type="checkbox" id="ocbResetPOS" name="ocbResetPOS" value="1"><span></span></label></td>';
                        tHTML_TD += '<td nowarp class="text-center"><img class="xCNIconTable xCNIconDelete" onclick="JSxDeleteRow(this)"></td>';
                break;
                case 'YEAR':
                    var tHTML_TD = '<td>'+nCount+'</td>';
                        tHTML_TD += '<td>'+tFilterName+'</td>';
                        tHTML_TD += '<td><select class="selectpicker form-control" onchange="JSxChangeYear();" id="ocmFmtYearType" name="ocmFmtYearType" maxlength="1" readonly>';
						tHTML_TD += '<option value="YYYY">YYYY</option>';
						tHTML_TD += '<option value="YY">YY</option>';
						tHTML_TD += '</select></td>';
                        tHTML_TD += '<td class="text-center"><label class="fancy-checkbox"><input type="checkbox" id="ocbResetYear" name="ocbResetYear" value="1"><span></span></label></td>';
                        tHTML_TD += '<td nowarp class="text-center"><img class="xCNIconTable xCNIconDelete" onclick="JSxDeleteRow(this)"></td>';
                break;
                case 'MONTH':
                    var tHTML_TD = '<td>'+nCount+'</td>';
                        tHTML_TD += '<td>'+tFilterName+'</td>';
                        tHTML_TD += '<td><div class="input-group" style="width: 100%;"><input name="oetFmtMonth" id="oetFmtMonth" type="Text" maxlength="5" value="MM" readonly></div></td>';
                        tHTML_TD += '<td class="text-center"><label class="fancy-checkbox"><input type="checkbox" id="ocbResetMonth" name="ocbResetMonth" value="1"><span></span></label></td>';
                        tHTML_TD += '<td nowarp class="text-center"><img class="xCNIconTable xCNIconDelete" onclick="JSxDeleteRow(this)"></td>';
                break;
                case 'DAY':
                    var tHTML_TD = '<td>'+nCount+'</td>';
                        tHTML_TD += '<td>'+tFilterName+'</td>';
                        tHTML_TD += '<td><div class="input-group" style="width: 100%;"><input name="oetFmtDay" id="oetFmtDay" type="Text" maxlength="5" value="DD" readonly></div></td>';
                        tHTML_TD += '<td class="text-center"><label class="fancy-checkbox"><input type="checkbox" id="ocbResetDay" name="ocbResetDay" value="1"><span></span></label></td>';
                        tHTML_TD += '<td nowarp class="text-center"><img class="xCNIconTable xCNIconDelete" onclick="JSxDeleteRow(this)"></td>';
                break;
            }

            var tHTML = '<tr class="otr'+tFilter+'" data-Filter="'+tFilter+'">';
                tHTML += tHTML_TD;
                tHTML += '</tr>';
            $('#otbFmt tbody').append(tHTML);
            $('.selectpicker').selectpicker();	
            JSxReaderFormat('');
        }
    });

    //ลบข้อมูลแถว
    function JSxDeleteRow(e){

        //ใส่ค่าใหม่
        var tFilter = $(e).parent().parent().attr('data-Filter');
        switch (tFilter) {
            case 'CHAR':
                var nCountFilter = parseInt($('#oetFmtChar').val().length);
            break;
            case 'BCH':
                var nCountFilter = parseInt('<?=$nMaxSizeBCH;?>');
                break;
            case 'POSSHP':
                var nCountFilter = parseInt('<?=$nMaxSizePOS;?>');
            break;
            case 'YEAR':
                var nCountFilter = $('#ocmFmtYearType option:selected').val().length;
            break;
            case 'MONTH':
                var nCountFilter = $('#oetFmtMonth').val().length;
            break;
            case 'DAY':
                var nCountFilter = $('#oetFmtDay').val().length;
            break;
            default:
                var nCountFilter = 0;
        }

        tFmtCustomCodeOld = tFmtCustomCodeOld - nCountFilter;
        $('#ospFormatResultLen').val(tFmtCustomCodeOld);
        $(e).parent().parent().remove();

        //รันรหัสใหม่
        var nCountTable = $('#otbFmt tbody tr').length;
        if(nCountTable == 0){
            var tHTMLEmpty =  '<tr class="otrEmpty">';
                tHTMLEmpty += '<td class="text-center xCNTextDetail2" colspan="10"><?= language('common/main/main','tCMNNotFoundData')?></td>';
                tHTMLEmpty += '</tr>';
            $('#otbFmt tbody').append(tHTMLEmpty);
        }else{  
            var nCount = $('#otbFmt tbody tr').length;
            var nKeyColumn = 1;
            for(var i=0; i<nCount; i++){
                $("#otbFmt tbody tr:eq("+i+") td:eq(0)").text(nKeyColumn);
                nKeyColumn++;
            }
        }

        JSxReaderFormat('renderonly'); 
    }

    //เมื่อกำหนด หรือ event ถูกเปลี่ยน
    $('#oetFmtWidth').change(function(e) { 
        if($(this).val() > 30){
            $(this).val(30);
        }else{
            if($('#oetFmtWidth').val() == 0){
                $(this).val(1);
            }

            var tNewFmtWidth = parseInt($('#oetFmtWidth').val());
            var tOldFmtWidth = parseInt($('#oetFmtWidthOld').val()); 
            tFmtCustomCodeOld = tFmtCustomCodeOld - tOldFmtWidth;
            tFmtCustomCodeOld = tFmtCustomCodeOld + tNewFmtWidth;
            $('#oetFmtWidthOld').val($('#oetFmtWidth').val());
            $('#ospFormatResultLen').val(tFmtCustomCodeOld);
            JSxReaderFormat('renderonly'); 
        }
    });

    //อนุญาติใช้คั่น
    $('#ocbUseFmtSpc').change(function() { 
        var tTypeCheck  = $('#ocbUseFmtSpc:checked').val();
        var tFmtOrg     = $('#ospFormatResult').val();
        if(tTypeCheck == 1){
            tFmtCustomCodeOld   =  tFmtCustomCodeOld + 1;
            var tSpc            = '-';
        }else{
            tFmtCustomCodeOld   =  tFmtCustomCodeOld - 1;
            var tSpc            = '';
            var tFmtOrg         = tFmtOrg.replace("-", "");
        }

        var aFmtResult      = tFmtOrg.split("#");
        var tWidthSize      = $('#oetFmtWidth').val();
        if(tWidthSize > 0){
            var tFmtSTD = '';
            for(i=0; i<tWidthSize; i++){
                tFmtSTD += '#';
            }
        }
        var tFmtResult = aFmtResult[0] + tSpc + tFmtSTD;
        $('#ospFormatResult').val(tFmtResult);
        $('#ospFormatResultLen').val(tFmtCustomCodeOld);
    });

    JSxReaderFormat('first');
    function JSxReaderFormat(ptType){

        if(ptType == 'first'){
            if('<?=$tEventControlNullorCustom?>' == 'CUSTOM'){

            }else{
                var tNewFmtWidth = parseInt($('#oetFmtWidth').val());
                tFmtCustomCodeOld = tNewFmtWidth;
                $('#ospFormatResultLen').val(tFmtCustomCodeOld);
            }
        }

        //อนุญาติ - 
        var tTypeCheck = $('#ocbUseFmtSpc:checked').val();
        if(tTypeCheck == 1){
            var tUseDisinFmt    = '-';
        }else{
            var tUseDisinFmt    = '';
        }

        //รหัส
        var tWidthSize      = $('#oetFmtWidth').val();
        if(tWidthSize > 0){
            var tFmtSTD = '';
            for(i=0; i<tWidthSize; i++){
                tFmtSTD += '#';
            }
        }

        var tFmtCustom          = '';
        if($('#otbFmt tbody tr').hasClass('otrEmpty') == true){
            tFmtCustom = '';
        }else{
            var nCount = $('#otbFmt tbody tr').length;
            if(nCount > 0){
                for(j=0; j<nCount; j++){
                    //แสดงข้อความ
                    var tCustom = $("#otbFmt tbody tr:eq("+j+") td:eq(1)").text();
                    tFmtCustom += tCustom;

                    if(j != nCount - 1){
                        tFmtCustom += '+';
                    }

                    if(ptType != 'renderonly'){
                        //เก็บค่า
                        var tFilter = $("#otbFmt tbody tr:eq("+j+")").attr('data-Filter');
                        switch (tFilter) {
                            case 'CHAR':
                                var nCountFilter = parseInt($('#oetFmtChar').val().length);
                               
                            break;
                            case 'BCH':
                                var nCountFilter = parseInt('<?=$nMaxSizeBCH;?>');
                                break;
                            case 'POSSHP':
                                var nCountFilter = parseInt('<?=$nMaxSizePOS;?>');
                            break;
                            case 'YEAR':
                                var nCountFilter = $('#ocmFmtYearType option:selected').val().length;
                            break;
                            case 'MONTH':
                                var nCountFilter = $('#oetFmtMonth').val().length;
                            break;
                            case 'DAY':
                                var nCountFilter = $('#oetFmtDay').val().length;
                            break;
                            default:
                                var nCountFilter = 0;
                        }
                    }   
                }

                if(ptType != 'renderonly' ){
                    tFmtCustomCodeOld = parseInt(tFmtCustomCodeOld) + parseInt(nCountFilter);
                }
            }
        }
        
        var tFmtResult = tFmtCustom + tUseDisinFmt + tFmtSTD;
        $('#ospFormatResult').val(tFmtResult);

        if(ptType != 'renderonly'){
            $('#ospFormatResultLen').val(tFmtCustomCodeOld);
        }
    }   

    //เปลี่ยนรหัสอักษร
    function JSxChangeChar(){
        //ทุกครั้งที่เปลี่ยน จะต้องเอาค่าไปใส่ค่าเก่า
        var nLenValue       = $('#oetFmtCharOld').val().length;
        tFmtCustomCodeOld   = tFmtCustomCodeOld - nLenValue;
        tFmtCustomCodeOld   = tFmtCustomCodeOld + $('#oetFmtChar').val().length;
        $('#ospFormatResultLen').val(tFmtCustomCodeOld);
        var tValueNew = $('#oetFmtCharOld').val($('#oetFmtChar').val());
    }

    //เปลี่ยนปี
    function JSxChangeYear(){
        var nYear = $('#ocmFmtYearType option:selected').val().length;
        if(nYear == 2){
            tFmtCustomCodeOld   = tFmtCustomCodeOld - 4;
            tFmtCustomCodeOld   = tFmtCustomCodeOld + 2;
        }else{
            tFmtCustomCodeOld   = tFmtCustomCodeOld - 2;
            tFmtCustomCodeOld   = tFmtCustomCodeOld + 4;
        }
        $('#ospFormatResultLen').val(tFmtCustomCodeOld);
    }   

    //บันทึก
    function JSoEventSaveAutoNumber(){
        var nMaxSize    = '<?=$nMaxSizeAll;?>';
        var nFmtSize    = $('#ospFormatResultLen').val();
        var tTableAuto  = '<?=$tTableAuto;?>';
        var tFiledAuto  = '<?=$tFiledAuto;?>';
        var tDocType    = '<?=$tDocType;?>';
        var aPackData   = [tTableAuto,tFiledAuto,tDocType];

        var tUseDefault = $('#ocbUseFmtDefault:checked').val();
        if(tUseDefault == 1){//คือใช้ค่ารูปแบบปกติ
            var tTypedefault = 'default';
        }else{
            var tTypedefault = 'customs';
            if(parseInt(nFmtSize) > parseInt(nMaxSize)){
                alert('รูปแบบที่ถูกจัดรวมแล้ว มากกว่า ' + nMaxSize + ' อักษร กรุณาจัดรูปแบบใหม่อีกครั้ง');
                return;
            }else{
                var nCount = $('#otbFmt tbody tr').length;
                if(nCount > 0){
                    var tFmtFull        = '';
                    var tFmtPosition    = '';
                    var tPerfix         = '';
                    var tUseBCH         = 0;
                    var tUseYear        = 0;
                    var tUseMonth       = 0;
                    var tUseDay         = 0;
                    var tUseSep         = 0;
                    var tResetBy        = '';
                    for(j=0; j<nCount; j++){
                        //เก็บค่า
                        var tFilter = $("#otbFmt tbody tr:eq("+j+")").attr('data-Filter');
                        switch (tFilter) {
                            case 'CHAR':
                                tFmtFull        += $('#oetFmtChar').val();
                                tFmtPosition    += 'CHA,';
                                tPerfix         = $('#oetFmtChar').val();
                            break;
                            case 'BCH':
                                tFmtFull        += 'BCH';
                                tFmtPosition    += 'BCH,';
                                tUseBCH         = 1;
                                if($('#ocbResetBCH:checked').val() == 1){
                                    tResetBy  += 'BCH,';
                                }
                                break;
                            case 'POSSHP':
                                //ไม่มี pos 
                            break;
                            case 'YEAR':
                                var nYear = $('#ocmFmtYearType option:selected').val().length;
                                if(nYear == 2){
                                    tFmtFull        += 'YY';
                                    tFmtPosition    += 'YY,';
                                    tUseYear        = 1;
                                }else{
                                    tFmtFull        += 'YYYY';
                                    tFmtPosition    += 'YYYY,';
                                    tUseYear        = 2;
                                }
                                if($('#ocbResetYear:checked').val() == 1){
                                    tResetBy  += 'YYYY,';
                                }
                            break;
                            case 'MONTH':
                                tFmtFull        += 'MM';
                                tFmtPosition    += 'MM,';
                                tUseMonth       = 1;
                                if($('#ocbResetMonth:checked').val() == 1){
                                    tResetBy  += 'MM,';
                                }
                            break;
                            case 'DAY':
                                tFmtFull        += 'DD';
                                tFmtPosition    += 'DD,';
                                tUseDay         = 1;
                                if($('#ocbResetDay:checked').val() == 1){
                                    tResetBy  += 'DD,';
                                }
                            break;
                            default:
                                tFmtFull        += '';
                                tFmtPosition    += '';
                        }
                    }


                    //อนุญาติ - 
                    var tTypeCheck = $('#ocbUseFmtSpc:checked').val();
                    if(tTypeCheck == 1){
                        tFmtFull += '-';
                        tUseSep  = 1;
                    }else{
                        tFmtFull += '';
                        tUseSep = 0;
                    }

                    //รหัส
                    var tWidthSize = $('#oetFmtWidth').val();
                    if(tWidthSize > 0){
                        for(i=0; i<tWidthSize; i++){
                            tFmtFull += '#';
                        }
                    }

                    var tFmtPositionResult  = tFmtPosition.substring(0,tFmtPosition.length - 1);
                    var tFmtResetBy         = tResetBy.substring(0,tResetBy.length - 1);
                    var nFiledLenFmt        = $('#ospFormatResultLen').val();

                    if(tFmtResetBy.length > 1){
                        var FTAhmStaReset = 1;
                    }else{
                        var FTAhmStaReset = 0;
                    }

                    var aSubPackData = {
                        'FTAhmFmtAll'       : tFmtFull,
                        'FTAhmFmtPst'       : tFmtPositionResult,
                        'FNAhmFedSize'      : nMaxSize,
                        'FTAhmFmtChar'      : tPerfix,
                        'FTAhmStaBch'       : tUseBCH,
                        'FTAhmFmtYear'      : tUseYear,
                        'FTAhmFmtMonth'     : tUseMonth, 
                        'FTAhmFmtDay'       : tUseDay,
                        'FTSatStaAlwSep'    : tUseSep,
                        'FNAhmLastNum'      : 0,
                        'FTAhmStaReset'     : FTAhmStaReset,
                        'FTAhmFmtReset'     : tFmtResetBy,
                        'FTAhmLastRun'      : 0,
                        'FNAhmNumSize'      : $('#oetFmtWidth').val(),
                        'FTSatUsrNum'       : $('#oetFmtUsrNum').val()
                    };

                    aPackData.push(aSubPackData);
                }
            }
        }


        $.ajax({
            type    : "POST",
            url     : "SettingAutonumberSave",
            data    : { 'tTypedefault' : tTypedefault , 'aPackData' : aPackData , 'tAgnCode' : $('#oetAgnCode').val() },
            cache   : false,
            timeout : 5000,
            success : function (tResult) {
                JSvSettingNumberLoadViewSearch();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
</script>
