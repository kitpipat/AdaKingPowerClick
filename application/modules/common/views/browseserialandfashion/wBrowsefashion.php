<style>
    .xCNBTNActivity{
        float           : right;
        margin-left     : 10px;
    }
</style>

<?php
    $tDetailPDT             = $aDetailPDT[$nNumberArray];
    $tPDTName               = $oObjectResult[0]['FTPdtName'];   //ชื่อสินค้าแฟชั่น
    $tPDTCode               = $tDetailPDT->PDTCode;             //รหัสสินค้าแฟชั่น
    $nAll                   = $nAll;                            //จำนวนสินค้าแฟชั่น ที่เลือกมาทั้งหมด
    $tNameNextFunc          = $tNameNextFunc;                   //ชื่อฟังก์ชั่นสำหรับ nextfunct
    $tPDTType               = $tPDTType;                        //สินค้าเป็นประเภทไหน แฟชั่น หรือ ซีเรียล
    $tEventType             = $tEventType;                      //รูปแบบของการเลือกข้อมูล insert (pageadd) หรือ update (pageupdate)  
    $oOptionForFashion      = $oOptionForFashion;               //การเพิ่มสินค้าแฟชั่นแบบ พิเศษ
    if(!empty($oOptionForFashion['tStaEdit'])){                  //สถานะแก้ไข
        $tStaEdit           = $oOptionForFashion['tStaEdit']; 
    }else{
        $tStaEdit           = 1;           
    }
    $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
   
?>

<div class="row">
    <div class="col-lg-12">

        <div class="row">
            <div class="col-md-7 col-lg-7">
                <span><b><?= language('common/main/main', 'tModalnamePDT') ?> : </b></span>(<?=$tPDTCode?>) <?=$tPDTName?>
            </div>
            <div class="col-md-5 col-lg-5 text-right">
                <?php if($nAll != 1){//ถ้ามีสินค้าแค่ตัวเดียวไม่ต้องโชว์สรุปว่ามีกี่รายการ ?>
                    <span><b> <?= language('common/main/main', 'tPDTNumber') ?> <?=$nNumberArray+1?> <?= language('common/main/main', 'tCommonAllRecord') ?> <?=$nAll?> <?= language('common/main/main', 'tCommonlabelShow') ?> </b></span>
                <?php } ?>
            </div>
        </div>

        <?php 
            //เอาไว้ control ว่าแต่ละ option ที่ส่งมาต้องโชว์อะไรบ้าง 
            //[0] : เอาแต่จำนวน
            //[1] : ตรวจนับ ครั้งที่ 1
            //[2] : ตรวจนับ ครั้งที่ 2
            //[3] : ตรวจนับ แบบกำหนดเอง
            if(isset($oOptionForFashion['tSpcControl'])){
                $nOptionShow = $oOptionForFashion['tSpcControl'];
            }else{
                $nOptionShow = 0;
            };
        ?>

        <!--ส่วนตาราง-->
        <div class="row" style="margin-top: 10px;">
            <div class="col-lg-12">
                <div> <!--style="overflow-x: scroll;"-->
                    <table class="table table-striped" id="otbTableFashion">
                        <thead>
                            <tr>
                                <th class="text-center" style="min-width: 20px;"><?= language('common/main/main', 'tModalAdvNo') ?></th>
                                <th class="text-center"><?= language('product/product/product','tPDTFhnSeason')?></th>
                                <th class="text-center" style="min-width: 100px; white-space: nowrap;"><?= language('product/product/product','tPDTFhnArticle')?></th>
                                <th class="text-center"><?= language('product/product/product','tPDTFhnColor')?></th>
                                <th class="text-center"><?= language('product/product/product','tPDTFhnSize')?></th>
                                <th class="text-center" style="min-width: 100px; white-space: nowrap;"><?= language('common/main/main','tPDTControlSTK')?></th>

                                <?php 
                                    switch ($nOptionShow) {
                                        case "0":
                                            echo "<th class='text-right'  style='width: 10%;'>" . language('product/product/product','tPDTSetPstQty') ."</th>";
                                        break;
                                        case "1":
                                        case "2":
                                        case "3":
                                            echo "<th class='text-center' style='width: 10%;'>" . language('document/adjuststocksum/adjuststocksum','tAdjStkSumDateCount') ."</th>";
                                            echo "<th class='text-center' style='width: 10%;'>" . language('document/adjuststocksum/adjuststocksum','tAdjStkSumTimeCount') ."</th>";

                                            if($nOptionShow == 1){
                                                $tNameShow = language('document/adjuststocksum/adjuststocksum','tAdjStkSumCount1');
                                            }else if($nOptionShow == 2){
                                                $tNameShow = language('document/adjuststocksum/adjuststocksum','tAdjStkSumCount2');
                                            }else{
                                                $tNameShow = language('document/adjuststocksum/adjuststocksum','tAdjStkSumUseDesionMy');
                                            }
                                            echo "<th class='text-right'  style='width: 10%;'>" . $tNameShow ."</th>";
                                        break;
                                        default:
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $tRefControlSTK   = ''; ?>
                            <?php $nRowspan         = 0; ?>
                            <?php if (!empty($oObjectResult)){ ?>
                                <?php foreach($oObjectResult AS $key=>$aValue){ ?>
                                    <tr 
                                    data-refcontrolstk="<?=$aValue['FTFhnRefCode']?>" 
                                    data-seqItem="<?=$aValue['FNFhnSeq']?>"
                                    data-pdtcode="<?=$aValue['RetPdtCode']?>"
                                    data-puncode="<?=$aValue['RetPunCode']?>"
                                    data-barcode="<?=$aValue['RetBarCode']?>"
                                    data-dtseq="<?=$aValue['RenDTSeq']?>"
                                    >


                                        <th class="text-center"><?=$key+1?></th>
                                        <td class="text-left" style="white-space: nowrap;"><?=($aValue['FTSeaName'] == '') ? '-' : $aValue['FTSeaName']?></td>
                                        <td class="text-left" style="white-space: nowrap;"><?=($aValue['FTFabName'] == '') ? '-' : $aValue['FTFabName']?></td>
                                        <td class="text-left" style="white-space: nowrap;"><?=($aValue['FTClrName'] == '') ? '-' : $aValue['FTClrName']?></td>
                                        <td class="text-left" style="white-space: nowrap;"><?=($aValue['FTPszName'] == '') ? '-' : $aValue['FTPszName']?></td>
                                    
                                        <?php 

                                            switch ($nOptionShow) {
                                                case "0":
                                                    //จำนวน
                                                    if($aValue['FCXtdQty'] == '' || $aValue['FCXtdQty'] == null){
                                                        $nQty = '';
                                                        $nQtyShow = 0;
                                                    }else{
                                                        $nQty = number_format($aValue['FCXtdQty']);
                                                        $nQtyShow = $aValue['FCXtdQty'];
                                                    }
                                                    if($tRefControlSTK != $aValue['FTFhnRefCode']){
                                                        $nCountRefCode = $aValue['nCountRefCode'];
                                                        echo "<td rowspan='$nCountRefCode' class='text-left' style='white-space: nowrap; vertical-align: middle;'>".$aValue['FTFhnRefCode']."</td>";
                                                     if($tStaEdit==1){
                                                        echo "<td rowspan='$nCountRefCode' class='text-right' style='vertical-align: middle;'><input type='text' class='form-control text-right xCNInputNumericWithoutDecimal' maxlength='18' value='".$nQty."' autocomplete='off' ></td>";
                                                     }else{
                                                        echo "<td rowspan='$nCountRefCode' class='text-right' style='vertical-align: middle;'>".number_format($nQtyShow,$nOptDecimalShow)."</td>";
                                                     }
                                                    }

                                                    $tRefControlSTK = $aValue['FTFhnRefCode'];
                                                break;
                                                case "1":
                                                case "2":
                                                case "3":
                                                    if($tEventType == 'update'){
                                                        if($nOptionShow == 1){
                                                            $tFieldDate = 'FDAjdDateTimeC1';
                                                            $tFieldQty  = 'FCAjdUnitQtyC1';
                                                        }else if($nOptionShow == 2){
                                                            $tFieldDate = 'FDAjdDateTimeC2';
                                                            $tFieldQty  = 'FCAjdUnitQtyC2';
                                                        }else if($nOptionShow == 3){
                                                            $tFieldDate = 'FDAjdDateTime';
                                                            $tFieldQty  = 'FCAjdUnitQty';
                                                        }

                                                        //วันที่ - เวลา
                                                        if($aValue[$tFieldDate] == '' || $aValue[$tFieldDate] == null){
                                                            $dDate      = '';
                                                            $dTime      = '';
                                                        }else{
                                                            $aDateTime = explode(" ",$aValue[$tFieldDate]);
                                                            $dDate      = $aDateTime[0];
                                                            $dTime      = $aDateTime[1];
                                                        }

                                                        //จำนวน
                                                        if($aValue[$tFieldQty] == '' || $aValue[$tFieldQty] == null){
                                                            $nQty = '';
                                                            $nQtyShow = 0;
                                                        }else{
                                                            $nQty = number_format($aValue[$tFieldQty]);
                                                            $nQtyShow = $aValue[$tFieldQty];
                                                        }
                                                    }
                                                    
                                                    if($tRefControlSTK != $aValue['FTFhnRefCode']){
                                                        $nCountRefCode = $aValue['nCountRefCode'];
                                                        echo "<td rowspan='$nCountRefCode' class='text-left' style='white-space: nowrap; vertical-align: middle;'>".$aValue['FTFhnRefCode']."</td>";
                                                        if($tStaEdit==1){
                                                            echo "<td rowspan='$nCountRefCode' class='text-center' style='vertical-align: middle;'><input type='text' class='form-control text-center xWDatePicker' value='".@$dDate."' autocomplete='off' ></td>";
                                                            echo "<td rowspan='$nCountRefCode' class='text-center' style='vertical-align: middle;'><input type='text' class='form-control text-center xWTimepicker' value='".@$dTime."' autocomplete='off' ></td>";
                                                            echo "<td rowspan='$nCountRefCode' class='text-right'  style='vertical-align: middle;'><input type='text' class='form-control text-right xCNInputNumericWithoutDecimal xCNValue' maxlength='18' value='".@$nQty."' autocomplete='off' ></td>";
                                                        }else{
                                                            echo "<td rowspan='$nCountRefCode' class='text-center' style='vertical-align: middle;'>".@$dDate."</td>";
                                                            echo "<td rowspan='$nCountRefCode' class='text-center' style='vertical-align: middle;'>".@$dTime."</td>";
                                                            echo "<td rowspan='$nCountRefCode' class='text-right'  style='vertical-align: middle;'>".@number_format($nQtyShow,$nOptDecimalShow)."</td>";
                                                        }
                                                    }

                                                    $tRefControlSTK = $aValue['FTFhnRefCode'];
                                                break;
                                                default:
                                            }
                                        ?>
                                    </tr>
                                <?php } ?>
                            <?php }else{ ?>
                                <td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--ส่วนปุ่มล่างสุด-->
        <div class="row">
            <div class="col-lg-12">
                <div><hr></div>
                <?php if($tStaEdit==1){ ?>
                    <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNBTNActivity" onclick="JSxConfirmPDTFashion('<?=$tPDTCode?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
                    <button class="btn xCNBTNDefult xCNBTNDefult2Btn xCNBTNActivity" onclick="JSxCanclePDTFashion('<?=$tPDTCode?>')"><?=language('common/main/main', 'tCancel')?></button>
                <?php }else{ ?>
                    <button class="btn xCNBTNDefult xCNBTNDefult2Btn xCNBTNActivity" data-dismiss="modal" ><?=language('common/main/main', 'tCMNOK')?></button>
                <?php  } ?>
            </div>
        </div>
    </div>
</div>

<script>    

    //วันที่
    $(".xWDatePicker").datepicker({
        format          		: 'yyyy-mm-dd',
        todayHighlight  		: true,
        enableOnReadonly		: false,
        disableTouchKeyboard 	: true,
        autoclose       		: true,
        orientation     		: 'bottom' 
    });

    //เวลา
    $('.xWTimepicker').datetimepicker({
        format                  : 'HH:mm:ss'
    })

    //กดปิดที่ modal ยืนยันว่าต้องกรอก
    $('#obtCantKeyISNull').click(function() {
        $('#odvModalCantKeyISNull').modal('hide');
    });                    

    //กดปิดที่ modal
    $('#obtCancleFashion').click(function() {
        $('#odvModalCancleFashion').modal('hide');
    });                    
    
    //หน้าต่างยกเลิก
    function JSxCanclePDTFashion(ptPDTCode){

        if('<?=$tEventType?>' == 'insert'){ //ถ้ากดยกเลิกในรูปแบบหน้าจอ insert ต้องส่งค่ากลับไปให้ลบ

            //modal โชว์
            $('#odvModalCancleFashion').modal('show');

            //กดยืนยันหลังจาก modal 
            $('#obtConfirmFashion').off();
            $('#obtConfirmFashion').click(function() {

                //ซ่อน modal ยกเลิกไป
                $('#odvModalCancleFashion').modal('hide');

                if('<?=$nAll?>' > 1){ //มีสินค้าตัวถัดไปรอให้กรอกอยู่
                    if(<?=$nNumberArray+1?> == <?=$nAll?>){ //ถ้าเป็นตัวสุดท้ายก็ออกจากลูป
                        setTimeout(function(){ 
                            JSxCloseModalBrowse_Fahsion();
                        }, 1000);
                    }else{ //สินค้าตัวถัดไป
                        JSxNextPDTFahsion();
                    }
                }else{
                    setTimeout(function(){ 
                        JSxCloseModalBrowse_Fahsion();
                    }, 1000);
                }

                //แพ็คข้อมูลส่งกับไป nextfunc
                var aNewResult  = JSON.stringify({
                    'tType'         : 'delete' , 
                    'nStaLastSeq'   : '<?=($nNumberArray+1 == $nAll) ? 1 : 0; ?>', //สินค้าแฟชั่นตัวสุดท้าย 1:ตัวสุดท้าย 0:ไม่ใช่ตัวสุดท้าย
                    'aResult'       :  { 'tPDTCode' : ptPDTCode } , 
                    'tRemark'       : '[dev] เอารหัสสินค้านี้ไปลบใน TCNTDocDTTmp และใน Grid ให้ด้วยครับ' 
                });

                return window['<?=$tNameNextFunc?>'](aNewResult);
            });
        }else if('<?=$tEventType?>' == 'update'){ //ถ้ากดยกเลิกในรูปแบบหน้าจอ update ไม่ต้องทำอะไร
            //ซ่อน modal ยกเลิกไป
            setTimeout(function(){ 
                JSxCloseModalBrowse_Fahsion();
            }, 1000);
        }
    }

    //หน้าต่างยืนยัน 
    function JSxConfirmPDTFashion(ptPDTCode){

        //แพ็คข้อมูล
        var aResult = [];
        $("#otbTableFashion tbody tr").each(function() {
            switch ('<?=$nOptionShow?>') {
                case '0':
                    if($(this).find('td:eq(5) input').val() > 0){
                        var aFashion = { 
                            'tPDTCode'  : ptPDTCode , 
                            'tRefCode'  : $(this).attr('data-refcontrolstk') , 
                            'nSeqItem'  : $(this).attr('data-seqItem') , 
                            'tPunCode'  : $(this).attr('data-puncode') , 
                            'tBarCode'  : $(this).attr('data-barcode') , 
                            'nDTSeq'    : $(this).attr('data-dtseq') , 
                            'nQty'      : $(this).find('td:eq(5) input').val() 
                        }
                        aResult.push(aFashion);
                    }
                    break;
                case '1':
                case '2':
                case '3':
                    if($(this).find('td:eq(5) input').val() && $(this).find('td:eq(6) input').val() && $(this).find('td:eq(7) input').val()){
                        var aFashion = { 
                            'tPDTCode'   : ptPDTCode , 
                            'tRefCode'   : $(this).attr('data-refcontrolstk') , 
                            'nSeqItem'   : $(this).attr('data-seqItem') , 
                            'tPunCode'  : $(this).attr('data-puncode') , 
                            'tBarCode'  : $(this).attr('data-barcode') , 
                            'nDTSeq'    : $(this).attr('data-dtseq') , 
                            'tDateAdj'   : $(this).find('td:eq(5) input').val(),
                            'tTimeAdj'   : $(this).find('td:eq(6) input').val(),
                            'nQtyAdj'    : $(this).find('td:eq(7) input').val() 
                        }
                        aResult.push(aFashion);
                    }
                    break;
            }
        });

        //ถ้าเป็นค่าว่างหมด จะไม่อนุญาตให้นำเข้า
        if(aResult.length == 0){
            //บังคับให้กรอกอย่างน้อย หนึ่งตัว
            $('#odvModalCantKeyISNull').modal('show');
            return;
        }

        if(<?=$nAll?> > 1){ //มีสินค้าตัวถัดไปรอให้กรอกอยู่
            if(<?=$nNumberArray+1?> == <?=$nAll?>){ //ถ้าเป็นตัวสุดท้ายก็ออกจากลูป
                setTimeout(function(){ 
                    JSxCloseModalBrowse_Fahsion();
                }, 1000);
            }else{ //สินค้าตัวถัดไป
                JSxNextPDTFahsion();
            }
        }else{
            setTimeout(function(){ 
                JSxCloseModalBrowse_Fahsion();
            }, 1000);
        }

        //แพ็คข้อมูลส่งกับไป nextfunc
        var aNewResult  = JSON.stringify({
            'tType'         : 'confirm' , 
            'nStaLastSeq'   : '<?=($nNumberArray+1 == $nAll) ? 1 : 0; ?>', //สินค้าแฟชั่นตัวสุดท้าย 1:ตัวสุดท้าย 0:ไม่ใช่ตัวสุดท้าย
            'aResult'       : aResult , 
            'tRemark'       : '[dev] เอาข้อมูลไปลงตาราง TCNTDocDTFhnTmp ระบบจะส่งสินค้าลูกกลับไป เฉพาะตัวที่ระบุจำนวนให้เท่านั้น'
        });
        return window['<?=$tNameNextFunc?>'](aNewResult);
    }

    //โหลดสินค้าตัวถัดไป
    function JSxNextPDTFahsion(){
        $.ajax({
            type    : "POST",
            url     : 'LoadViewProductSerialandFashion',
            data    : {
                        'aData'             : '<?=json_encode($aDetailPDT)?>' , 
                        'tPDTType'          : '<?=$tPDTType?>' , 
                        'tEventType'        : '<?=$tEventType?>' ,
                        'nNumber'           : '<?=$nNumberArray+1?>' , 
                        'tNameNextFunc'     : '<?=$tNameNextFunc?>',
                        'oOptionForFashion' : JSON.parse('<?=json_encode($oOptionForFashion)?>')
                    },
            cache   : false,
            timeout : 0,
            success: function(tResult) {
                //ตัว รีโหลดเวลาโหลดสินค้า
                var tImage = "<img src='<?= base_url() ?>application/modules/common/assets/images/ada.loading.gif' class='xWImgLoading'>";
                $('#odvModalFahisonsectionBodyPDT').html(tImage);
                $('#odvModalFahisonsectionBodyPDT').css('height', '200px');

                setTimeout(function(){ 
                    var aDataReturn = JSON.parse(tResult);
                    $('#odvModalFahisonsectionBodyPDT').html(aDataReturn['tHTML']); 
                    $('#odvModalFahisonsectionBodyPDT').css('height', 'auto');
                }, 500);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
                JCNxCloseLoading();
            }
        });
    }

</script>