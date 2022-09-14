<style>
    .xCNClickforModalPDT{
        cursor: pointer;
    }

    .xCNActivePDT > td{
        background-color: #179bfd !important;
        color : #FFF !important;
    }

    .xCNTbodyodd > .panel-heading{
        background : #f8f8f8 !important;
    }

    .xCNTbodyeven > .panel-heading{
        background : #FFF !important;
    }

    .XCNPosition {
        display: block;
        background:#f5f5f5;
        width:330px;
        height:155px;
        position : absolute;
        left:30px;
        border: 1px solid #070708;
        padding  : 10px;
        margin-top : -192px;
    }

    .xCNPositionBtn {
        width: 70px;
        height: 30px;
        position: absolute;
        left: 83px;
        top: 0px;
    }

</style>

<?php
    if($aPriceType[0] == 'Pricesell' && $tSelectTier == 'PDT'){
        $tNewClassStyle = 'xCNClickforModalPDT';
        
    }else{
        $tNewClassStyle = '';
    }

    //หาว่าใช้ต้นทุนแบบไหน
    if($aTSysconfig == null || $aTSysconfig == ''){
        $bCheckPrice    = false;
        $nPriceon       = 0;
    }else{
        $bCheckPrice    = true;
        $nPriceon       = $aTSysconfig;
    }
?>

<!--layout table-->
<table id='otbBrowserListPDT' class='table table-striped' style='width:100%'>
    <thead>
        <tr>
            <?php if($aPriceType[0] == 'Cost'){ ?>
                <th class='xCNTextBold' style='text-align:center; width:220px;'><?=language('common/main/main','tModalcodePDT')?></th>
                <th class='xCNTextBold' style='text-align:center; width:220px;'><?=language('common/main/main','tModalnamePDT')?></th>
                <th class='xCNTextBold' style='text-align:center; width:220px;'><?=language('common/main/main','tModalPriceUnit')?></th>
                <th class='xCNTextBold' style='text-align:center; width:220px;'><?=language('common/main/main','tModalbarcodePDT')?></th>
                <th class='xCNTextBold' style='text-align:center; width:220px; display:none;'><?=language('common/main/main','tModalPricecost')?></th>
            <?php }else if($aPriceType[0] == 'Pricesell'){ ?>
                <th class='xCNTextBold' style='text-align:center; width:120px;'><?=language('common/main/main','tModalcodePDT')?></th>
                <th class='xCNTextBold' style='text-align:center; width:160px;'><?=language('common/main/main','tModalnamePDT')?></th>
                <th class='xCNTextBold' style='text-align:center; width:120px;'><?=language('common/main/main','tModalPriceUnit')?></th>
                <th class='xCNTextBold' style='text-align:center; width:160px;'><?=language('common/main/main','tModalbarcodePDT')?></th>
                <th class='xCNTextBold' style='text-align:center; width:120px; display:none;'><?=language('common/main/main','tModalPriceSellPLE')?></th>
            <?php }else if($aPriceType[0] == 'Price4Cst'){ ?>
                <th class='xCNTextBold' style='text-align:center; width:120px;'><?=language('common/main/main','tModalcodePDT')?></th>
                <th class='xCNTextBold' style='text-align:center; width:160px;'><?=language('common/main/main','tModalnamePDT')?></th>
                <th class='xCNTextBold' style='text-align:center; width:120px;'><?=language('common/main/main','tModalPriceUnit')?></th>
                <th class='xCNTextBold' style='text-align:center; width:160px;'><?=language('common/main/main','tModalbarcodePDT')?></th>
                <th class='xCNTextBold' style='text-align:center; width:120px;'><?=language('common/main/main','tModalPriceSellPLE')?></th>
            <?php } ?>
        </tr>
    </thead>    

    <?php if($aProduct['rtCode'] != 1){ ?>
        <tr><td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
    <?php }else{ ?>
        <?php foreach($aProduct['raItems'] AS $key => $aValue){ ?>
        <?php 
            if ($key & 1) {
                $tClassColor = 'xCNTbodyodd';
            } else { 
                $tClassColor = 'xCNTbodyeven';
            }

            //สินค้าแฟชั่น
            if($aValue['FTPdtForSystem'] == 5){
                $tPDTFaishion = 'FH';
            }else{
                $tPDTFaishion = '-';
            }


            if($aPriceType[0] == 'Pricesell' || $aPriceType[0] == 'Price4Cst'){ 
                $aPackData = array(
                    'SHP'       => $aValue['FTShpCode'],
                    'BCH'       => $aValue['FTPdtSpcBch'],
                    'PDTCode'   => $aValue['FTPdtCode'],
                    'PDTName'   => str_replace("'",' ',$aValue['FTPdtName']),
                    'Barcode'   => $aValue['FTBarCode'],
                    'PUNCode'   => $aValue['FTPunCode'],
                    'PUNName'   => $aValue['FTPunName'],
                    'UnitFact'  => $aValue['FCPdtUnitFact'],
                    'PriceRet'  => number_format($aValue['FCPgdPriceRet'], $nOptDecimalShow, '.', ','),
                    'PriceWhs'  => number_format($aValue['FCPgdPriceWhs'], $nOptDecimalShow, '.', ','),
                    'PriceNet'  => number_format($aValue['FCPgdPriceNet'], $nOptDecimalShow, '.', ','),
                    'IMAGE'     => $aValue['FTImgObj'],
                    'LOCSEQ'    => '',
                    'Remark'    => str_replace("'",' ',$aValue['FTPdtName']),
                    'CookTime'  => ($aValue['FCPdtCookTime'] == '') ? 0 : $aValue['FCPdtCookTime'],
                    'CookHeat'  => ($aValue['FCPdtCookHeat'] == '') ? 0 : $aValue['FCPdtCookHeat'],
                    'AlwDis'    => ($aValue['FTPdtStaAlwDis'] == '' || $aValue['FTPdtStaAlwDis'] == null ) ? 2 : $aValue['FTPdtStaAlwDis'],
                    'AlwVat'    => $aValue['FTPdtStaVat'],
                    'nVat'      => $aValue['FCVatRate'],
                    'NetAfHD'   => number_format($aValue['FCPgdPriceRet'], $nOptDecimalShow, '.', ','),
                    'PDTSpc'    => $tPDTFaishion
                );
                $aPackData = JSON_encode($aPackData);
                $tNameFunctionClickPDT      = 'JSxPDTClickData(this,'.$aPackData.')';
                $tNameFunctionDBClickPDT    = 'JSxPDTDBClickData(this,'.$aPackData.')';
                $tNewClassControl           = 'JSxPDTClickMuti'.$aValue['FTPdtCode'].$aValue['FTBarCode'];
            }else if($aPriceType[0] == 'Cost'){
                //หาราคาต้นทุน
                $aDataFind = array(
                    'nINDEX'             => $nPriceon,
                    'nVATSPL'            => $tVatInorEx,
                    'nCostAvgIn'         => str_replace(",",'',$aValue['FCPdtCostAVGIN']),
                    'nCostAvgEX'         => str_replace(",",'',$aValue['FCPdtCostAVGEx']),
                    'nCostLast'          => str_replace(",",'',$aValue['FCPdtCostLast']),
                    'nCostFiFoIn'        => str_replace(",",'',$aValue['FCPdtCostFIFOIN']),
                    'nCostFiFoEx'        => str_replace(",",'',$aValue['FCPdtCostFIFOEx']),
                    'nCostSTD'           => str_replace(",",'',$aValue['FCPdtCostStd'])
                );

                $nCost = GetTotalByConfig($aDataFind); 
                $nCost = $nCost * $aValue['FCPdtUnitFact']; 

                $aPackData = array(
                    'SHP'       => $aValue['FTShpCode'],
                    'BCH'       => $aValue['FTPdtSpcBch'],
                    'PDTCode'   => $aValue['FTPdtCode'],
                    'PDTName'   => str_replace("'",' ',$aValue['FTPdtName']),
                    'PUNCode'   => $aValue['FTPunCode'],
                    'Barcode'   => $aValue['FTBarCode'],
                    'PUNName'   => $aValue['FTPunName'],
                    'IMAGE'     => $aValue['FTImgObj'],
                    'Price'     => $nCost,
                    'LOCSEQ'    => '',
                    'AlwDis'    => ($aValue['FTPdtStaAlwDis'] == '' || $aValue['FTPdtStaAlwDis'] == null ) ? 2 : $aValue['FTPdtStaAlwDis'],
                    'AlwVat'    => $aValue['FTPdtStaVat'],
                    'nVat'      => $aValue['FCVatRate'],
                    'NetAfHD'   => $nCost,
                    'PDTSpc'    => $tPDTFaishion,
                    'UnitFact'  => $aValue['FCPdtUnitFact']
                );
                $aPackData = JSON_encode($aPackData);
                $tNameFunctionClickPDT      = 'JSxPDTClickData(this,'.$aPackData.')';
                $tNameFunctionDBClickPDT    = 'JSxPDTDBClickData(this,'.$aPackData.')';
                $tNewClassControl           = 'JSxPDTClickMuti'.$aValue['FTPdtCode'].$aValue['FTBarCode'];
            }else{
                $tNameFunctionClickPDT      = '';
                $tNameFunctionDBClickPDT    = '';
                $tNewClassControl           = '';
            }
        ?>

        <tbody id="otbodyPdt<?=$aValue['FTPdtCode']?><?=$aValue['FTPunCode']?>" class="xCNEventClick <?=$tClassColor?> <?=$tNewClassStyle?>" ondblclick='<?=$tNameFunctionDBClickPDT?>'  onclick='<?=$tNameFunctionClickPDT?>'>
            <tr class="panel-heading <?=$tNewClassControl?>">
                <td class="text-left"><?=$aValue['FTPdtCode']; ?></td>
                <td class="text-left"><?=$aValue['FTPdtName']; ?></td>
                <td class="text-left"><?=$aValue['FTPunName'];?></td>
                <td class="text-left"><?=$aValue['FTBarCode']; ?></td>
                <?php if($aPriceType[0] == 'Cost'){ ?>
                    <!-- <td class="text-right"><?=number_format($nCost, $nOptDecimalShow, '.', ',');?></td>  -->
                <?php }else if($aPriceType[0] == 'Pricesell'){ ?>
                    <!-- <td class="text-right"><?//=number_format($aValue['FCPgdPriceRet'], $nOptDecimalShow, '.', ',');?></td> -->
                <?php }else if($aPriceType[0] == 'Price4Cst'){ ?>
                    <td class="text-right"><?=number_format($aValue['FCPgdPriceRet'], $nOptDecimalShow, '.', ',');?></td>
                <?php } ?>
            </tr>
        </tbody>
        <?php } ?>  
    <?php } ?>
</table>
<!--end table-->

<!-- GetAllRow เพื่อหาจำนวนสินค้าทั้งหมด -->
<?php $this->session->userdata("tSesGetAllRow"); ?>

<!--pagenation-->
<div class="row">
    <div class="col-md-6">
        <input type="hidden" id="ohdProductAllRow" name="ohdProductAllRow" value="<?=$aProduct['rnAllRow']?>" >
        <input type="hidden" id="ohdPDTEndPage" name="ohdPDTEndPage" value="<?=$aProduct['rnAllPage']?>" >
        <input type="hidden" id="ohdPDTRowPage" name="ohdPDTRowPage" value="<?=$aProduct['nRow']?>" >
        <?php if($this->session->userdata("tSesGetAllRow") > 5000) : ?>
            <!-- กรณีที่มีข้อมูลไม่ถึง 5000 รายการ ระบบจะแสดงข้อความดังนี้ พบข้อมูล 320 รายการ หน้า 1/32 -->
            <i class="glyphicon glyphicon-list" style="cursor:pointer; font-size:15px;" id="ospClickShowPDTConfig"></i>
            <p style="display: inline;"><?php echo language('common/main/main','tCommonShowAllRecord')?></p><p id="ospAllPDTRow" style="display: inline; padding: 5px;"><?php echo ($aProduct['rnAllRow'])?></p><p style="display: inline;"><?php echo language('common/main/main','tRecord')?>  [<?php echo language('common/main/main','tCommonAllRecord');?> <?php echo ($this->session->userdata("tSesGetAllRow"));?> <?php echo language('common/main/main','tRecord');?> ] <?php echo language('common/main/main', 'tCommonPage');?> <?php echo $aProduct['rnCurrentPage']; ?> / <?php echo $aProduct['rnAllPage']; ?></p>
        <?php else : ?>
            <!-- กรณีมีข้อมูลมากกว่า 5000 รายการ ระบบจะแสดงข้อความดังนี้ แสดงรายการสูงสุด 5000 รายการ [จากรายการทั้งหมด 72500 รายการ ] หน้า 1/500 -->
            <i  class="glyphicon glyphicon-list" style="cursor:pointer; font-size:15px;" id="ospClickShowPDTConfig"></i>
            <p style="display: inline;"><?php echo language('common/main/main','tResultTotalRecord')?></p><p id="ospAllPDTRow" style="display: inline; padding: 5px;"><?=$aProduct['rnAllRow']?></p><p style="display: inline;"><?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aProduct['rnCurrentPage']; ?> / <?php echo $aProduct['rnAllPage']; ?> </p>
        <?php endif;?>
    </div>
    <div class="col-md-6">
        <div class="xWPagePrinter btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvPDTBrowseClickPage('Fisrt')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?> style="padding: 5px 10px;">
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i><i class="fa fa-chevron-left f-s-14 t-plus-1" style="margin-left: -3px;"></i>
            </button>
            <button onclick="JSvPDTBrowseClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>  style="padding: 5px 10px;"> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aProduct['rnAllPage'],$nPage+2)); $i++){?> 
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvPDTBrowseClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aProduct['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvPDTBrowseClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?> style="padding: 5px 10px;"> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
            <button onclick="JSvPDTBrowseClickPage('Last')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?> style="padding: 5px 10px;">
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i><i class="fa fa-chevron-right f-s-14 t-plus-1" style="margin-left: -3px;"></i>
            </button>
        </div>
    </div>
</div>
<!--end pagenation-->

<div class="XCNPosition xWCanEnter" id="odvModalAddPdtConfig"> 
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <label class="xCNLabelFrm"><?php echo language('common/main/main','tCommonShowDetail')?></label>
    </div> 
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
        <button id="obtPdtConfigSave" class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNPositionBtn" type="button" onclick="JSxAdjustPage(<?=$aProduct['rnAllRow']?>,<?=$aProduct['nRow']?>);"><?php echo language('common/main/main','tSave')?></button>
    </div><hr style="border-top: 1px solid black; margin-top: 35px; width:100%;" > 
    <form id="ofmAddPdtConfig" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
        <div class="row"> <!--จำนวน Top Page-->
            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                <label class="xCNLabelFrm"><?php echo language('common/main/main','tCommonShowAllRecord')?></label>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                </label><input class="form-control text-right xCNInputNumericWithDecimal" style="width:170%; position: relative; top:-6px; left:-15px;" type="text" id="oetMaxPage" name="oetMaxPage" value="<?=number_format($aProduct['rnAllRow'])?>">
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right">
                <label class="xCNLabelFrm" style="position: relative; left:-15px;">(<?php echo language('common/main/main','tCommonlabelShow')?>)</label>
            </div>
        </div>
        <div class="row">  <!--จำนวน PerPage-->
            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                <label class="xCNLabelFrm"><?php echo language('common/main/main','tCommonPerPage')?></label>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                </label><input class="form-control text-right xCNInputNumericWithDecimal" style="width:170%; position: relative; left:-15px;" type="text" id="oetPerPage" name="oetPerPage" value="<?=number_format($aProduct['nRow'])?>">
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right">
                <label class="xCNLabelFrm" style="position: relative; left:-15px;">(<?php echo language('common/main/main','tCommonlabelShow')?>)</label>
            </div>
        </div>
    </form>
</div>

<?php 
    //หาว่าใช้ราคาแบบไหน
    function GetTotalByConfig($aData){

        $nINDEXConfig       = explode(',',$aData['nINDEX']); 
        $nVATSPL            = $aData['nVATSPL'];
        $nCostAvgIn         = $aData['nCostAvgIn'];
        $nCostAvgEX         = $aData['nCostAvgEX'];
        $nCostLast          = $aData['nCostLast'];
        $nCostFiFoIn        = $aData['nCostFiFoIn'];
        $nCostFiFoEx        = $aData['nCostFiFoEx'];
        $nCostSTD           = $aData['nCostSTD'];
        $nResultCost        = "";

        for($i=0; $i<FCNnHSizeOf($nINDEXConfig); $i++){
            switch ($nINDEXConfig[$i]) {
                case 1: //ต้นทุนเฉลี่ย
                    if($nVATSPL == 1){
                        $nResultCost = $nCostAvgIn;
                    }else if($nVATSPL == 2){
                        $nResultCost = $nCostAvgEX;
                    }
                    break;
                case 2: //ต้นทุนสุดท้าย
                    $nResultCost = $nCostLast;
                    break;
                case 3: //ต้นทุนมาตราฐาน
                    $nResultCost = $nCostSTD;
                    break;
                case 4: //ต้นทุน FiFo
                    if($nVATSPL == 1){
                        $nResultCost = $nCostFiFoIn;
                    }else if($nVATSPL == 2){
                        $nResultCost = $nCostFiFoEx;
                    }
                    break;
                default:
                    $nResultCost = 'EMPTY';
            }

            if($nResultCost == '' || $nResultCost == null){

            }else{
                break;  
            }
        }
        return $nResultCost;
    }
?>

<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>

<script>

    // $("#odvModalAddPdtConfig").focusout(function(){
    //     $('#odvModalAddPdtConfig').hide();
    // });
    
    $(document).ready(function(){
        $('#odvModalAddPdtConfig').hide();

        $("#ospClickShowPDTConfig").click(function(){
            $("#odvModalAddPdtConfig").toggle();
            $("#oetMaxPage").focus();
        });

        //Enter ได้
        $('.xWCanEnter').on('keypress',function(){
            if(event.keyCode == 13){
                $('#obtPdtConfigSave').click();
            }
        });

    });

    var tTimer;
    var nStatus = 1;
    var tEventWhenDelete = 0;

    //เลือกสินค้าแล้วกด ยืนยัน
    function JSxPDTClickData(elem , packData){
        nStatus = 1;
        tTimer = setTimeout(function() {
            if (nStatus == 1) {
                var aPriceType      = '<?=$aPriceType[0]?>';
                var tSelectTier     = '<?=$tSelectTier?>';
                var tTimeStorage    = $('#odhTimeStorage').val();
                if((aPriceType == 'Pricesell' || aPriceType == 'Cost' || aPriceType == 'Price4Cst')){
                    var tReturnType = $('#odhEleReturnType').val();
                    if(tReturnType == 'S'){
                        //remove ค่าเก่าเสมอ
                        pnPdtCode = packData.PDTCode;
                        ptPunCode = packData.PUNCode;
                        ptBarCode = packData.Barcode;

                        var obj = [];
                        localStorage.removeItem("LocalItemDataPDT" + tTimeStorage);
                        $('.panel-heading').removeClass('xCNActivePDT');
                        $('.panel-heading').find('td').attr('style', 'color: #232C3D !important;');

                        //insert ค่าใหม่
                        $(elem).children().addClass('xCNActivePDT');
                        $(elem).children().find('td').attr('style', 'color: #FFF !important;');

                        obj.push({"pnPdtCode": pnPdtCode, "ptBarCode": ptBarCode, "ptPunCode": ptPunCode  , "packData" : packData });
                        localStorage.setItem("LocalItemDataPDT" + tTimeStorage,JSON.stringify(obj));
                    }else if(tReturnType == 'M'){
                        pnPdtCode = packData.PDTCode;
                        ptPunCode = packData.PUNCode;
                        ptBarCode = packData.Barcode;
                        aNewStore = [];
                        var nDataSelected = $('span.olbVal'+pnPdtCode+ptPunCode+ptBarCode).length;
                        if (nDataSelected == 0) {
                            $('#odvPDTDataSelection').append($('<span>')
                                .append('<label>')
                                .attr('class', 'olbVal'+pnPdtCode+ptPunCode+ptBarCode)
                                .attr('data-pdtcode', pnPdtCode)
                                .attr('data-puncode', ptPunCode)
                                .attr('data-barcode', ptBarCode)
                            );
                            $(elem).children().addClass('xCNActivePDT');

                            $(elem).children().find('td').attr('style', 'color: #FFF !important;');

                            //ถ้าข้อมูลถูกลบ ต้องเพิ่มข้อมูลทุกตัวของตัวเดิม เข้าที่เดิม
                            if(tEventWhenDelete == 1){
                                var tStoreDataOld   = localStorage.getItem("LocalItemDataPDT" + tTimeStorage);
                                var tStorePDT       = JSON.parse(tStoreDataOld);
                                var nLength         = tStorePDT.length; 
                                for($i=0; $i<nLength; $i++){
                                    aNewStore.push({"pnPdtCode": tStorePDT[$i].pnPdtCode , "ptPunCode": tStorePDT[$i].ptPunCode , "ptBarCode": tStorePDT[$i].ptBarCode , "packData" : tStorePDT[$i].packData});
                                }

                                aNewStore.push({"pnPdtCode": pnPdtCode , "ptPunCode": ptPunCode , "ptBarCode": ptBarCode , "packData" : packData });
                                localStorage.setItem("LocalItemDataPDT" + tTimeStorage,JSON.stringify(aNewStore));

                            }else{
                                aMulti.push({"pnPdtCode": pnPdtCode , "ptPunCode": ptPunCode , "ptBarCode": ptBarCode , "packData" : packData });
                                localStorage.setItem("LocalItemDataPDT" + tTimeStorage,JSON.stringify(aMulti));
                            }
                        } else {
                            $('span.olbVal'+pnPdtCode+ptPunCode+ptBarCode).remove();
                            $(elem).children().removeClass('xCNActivePDT');
                            $(elem).children().find('td').attr('style', 'color: #232C3D !important;');

                            //Remove localstorage and New add
                            var tStorePDT   = localStorage.getItem("LocalItemDataPDT" + tTimeStorage);
                            if(tStorePDT == '' || tStorePDT == null){
                                localStorage.removeItem("LocalItemDataPDT" + tTimeStorage);
                            }else{
                                var tStorePDT       = JSON.parse(tStorePDT);
                                var nLength         = tStorePDT.length;   
                                var aNewStore       = []; 
                                var aNewarraydata   = [];
                        
                                for($i=0; $i<nLength; $i++){
                                    aNewStore.push({"pnPdtCode": tStorePDT[$i].pnPdtCode, "ptPunCode": tStorePDT[$i].ptPunCode , "ptBarCode":  tStorePDT[$i].ptBarCode , "packData" : tStorePDT[$i].packData});
                                }
                                
                                //ลบ array ชุดเดิม
                                var nLengthStore = aNewStore.length; 
                                for($i=0; $i<nLengthStore; $i++){
                                    if(aNewStore[$i].pnPdtCode == pnPdtCode && aNewStore[$i].ptPunCode == ptPunCode && aNewStore[$i].ptBarCode == ptBarCode){
                                        delete aNewStore[$i];
                                    }
                                    if(aNewStore[$i] != undefined){
                                        aNewarraydata.push(aNewStore[$i]);
                                    }
                                }

                                aMulti = [];
                                localStorage.setItem("LocalItemDataPDT" + tTimeStorage,JSON.stringify(aNewarraydata));
                                tEventWhenDelete = 1;
                            }
                        }
                    }else{
                        alert(" you can't select type return single(S) or multiselect(M)");
                    }
                }else{
                    return;
                }
            }
        }, 100);
    }

    //ดับเบิ้ลคลิก คือเลือกสินค้าเลย
    function JSxPDTDBClickData(elem , packData){
        clearTimeout(tTimer);
        nStatus = 0;
        var aPriceType      = '<?=$aPriceType[0]?>';
        var tSelectTier     = '<?=$tSelectTier?>';
        var tTimeStorage    = $('#odhTimeStorage').val();
        if((aPriceType == 'Pricesell' || aPriceType == 'Cost' || aPriceType == 'Price4Cst')){
            var tReturnType = $('#odhEleReturnType').val();
            if(tReturnType == 'S'){
                //remove ค่าเก่าเสมอ
                pnPdtCode = packData.PDTCode;
                ptPunCode = packData.PUNCode;
                ptBarCode = packData.Barcode;

                var obj = [];
                localStorage.removeItem("LocalItemDataPDT" + tTimeStorage);
                $('.panel-heading').removeClass('xCNActivePDT');
                $('.panel-heading').find('td').attr('style', 'color: #232C3D !important;');

                //insert ค่าใหม่
                $(elem).children().addClass('xCNActivePDT');
                $(elem).children().find('td').attr('style', 'color: #FFF !important;');

                obj.push({"pnPdtCode": pnPdtCode, "ptBarCode": ptBarCode, "ptPunCode": ptPunCode  , "packData" : packData });
                localStorage.setItem("LocalItemDataPDT" + tTimeStorage,JSON.stringify(obj));

                JCNxConfirmSelectedPDT();
            }
        }else{
            return;
        }
    }

</script>