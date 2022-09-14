<?php
if (isset($nStaAddOrEdit) && $nStaAddOrEdit == 1) {
    $tRoute             = "salemachinedeviceEventEdit";
    $tPhwCode           = $aPhwData['raItems']['rtPhwCode'];
    $tPhwName           = $aPhwData['raItems']['rtPhwName'];
    $tConnType          = $aPhwData['raItems']['rtConnType'];
    $tConnRef           = $aPhwData['raItems']['rtConnRef'];
    $tShwNamePrinter    = $aPhwData['raItems']['rtShwName'];
    $tPosCodeMachinedevice  = $tPosCode;
    $tPhwCodePrinter    = $aPhwData['raItems']['rtCodeRef'];
    $tPhwNamePrinter    = $aPhwData['raItems']['rtCodeRef'];
    $tShwCode           = substr($aPhwData['raItems']['rtShwCode'], 2, 3);
    $tNamePrinter       = $aPhwData['raItems']['rtNamePrinter'];
    $tFTPhwCustom       = $aPhwData['raItems']['FTPhwCustom'];
    $tNameEDC           = $aPhwData['raItems']['NameEDC'];
    $tPosCode           = $tPosCode;
    $tPosName           = $aPhwData['raItems']['rtPosName'];
    // $tBchCodedevice     = $tBchCode[0]->FTBchCode;
    $tBchCodedevice     = $aPhwData['raItems']['rtBchCode'];
    // print_r(explode(";", $aPhwData['raItems']['FTPhwCustom']));
    // die();
    if ($aPhwData['raItems']['rtShwCode'] == 5) {
        @$tFTPhwCustomModal = explode(";", $aPhwData['raItems']['FTPhwCustom']);

        @$tFTPhwCustomModal0 =  @$tFTPhwCustomModal[0];
        @$tFTPhwCustomModal1 =  @$tFTPhwCustomModal[1];
        @$tFTPhwCustomModal2 =  @$tFTPhwCustomModal[2];
        @$tFTPhwCustomModal3 =  @$tFTPhwCustomModal[3];
        @$tFTPhwCustomModal4 =  @$tFTPhwCustomModal[4];
    } else {
        $tFTPhwCustomModal = '';
        $tFTPhwCustomModal0 =  '';
        $tFTPhwCustomModal1 =  '';
        $tFTPhwCustomModal2 =  '';
        $tFTPhwCustomModal3 =  '';
        $tFTPhwCustomModal4 =  '';
    }
} else {
    $tRoute             = "salemachinedeviceEventAdd";
    $tPhwCode           = "";
    $tPhwName           = "";
    $tConnType          = "";
    $tConnRef           = "";
    $tShwNamePrinter    = "";
    $tPosCodeMachinedevice  = $tPosCode;
    $tPhwCodePrinter    = "";
    $tPhwNamePrinter    = "";
    $tShwCode           = "";
    $tNamePrinter       = "";
    $tFTPhwCustom       = "";
    $tNameEDC           = "";
    $tPosCode           = $tPosCode;
    $tBchCodedevice     = $tBchCode;
    $tPosName           = '';
    // if ($aPhwData['raItems']['rtShwCode'] == 5) {
    $tFTPhwCustomModal = '';
    $tFTPhwCustomModal0 =  '';
    $tFTPhwCustomModal1 =  '';
    $tFTPhwCustomModal2 =  '';
    $tFTPhwCustomModal3 =  '';
    $tFTPhwCustomModal4 =  '';
    // }

    // if($this->session->userdata("tSesUsrLevel") == "BCH" || $this->session->userdata("tSesUsrLevel") == "SHP"){
    //     $tBchCodedevice = $this->session->userdata("tSesUsrBchCode");
    // }else{
    //     $tBchCodedevice = "";
    // }

}
// print_r($tFTPhwCustomModal);
// die();
?>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddSaleMachineDevice">
    <button style="display:none" type="submit" id="obtSubmitSaleMachineDevice" onclick="JSoAddEditSaleMachineDevice('<?= $tRoute ?>')"></button>
    <input type="hidden" id="ohdPhwRoute" name="ohdPhwRoute" value="<?php echo $tRoute; ?>">
    <input type="hidden" id="ohdSMDBchCode" name="ohdSMDBchCode" value="<?php echo $tBchCodedevice; ?>">
    <input type="hidden" id="ohdPosCodeMachinedevice" name="ohdPosCodeMachinedevice" value="<?php echo $tPosCodeMachinedevice; ?>">

    <div class="">
        <!-- เพิ่มมาใหม่ -->
        <div class="">
            <!-- เพิ่มมาใหม่ -->
            <div class="row">

                <div class="col-xs-12 col-md-5 col-lg-5">
                    <!-- เปลี่ยน Col Class -->
                    <div class="form-group">
                        <input type="hidden" value="0" id="ohdCheckPhwClearValidate" name="ohdCheckPhwClearValidate">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('pos/salemachine/salemachine', 'tPOSCodeDevice') ?><?= language('pos/salemachine/salemachine', 'tPOSTitleDevice') ?></label> <!-- เปลี่ยนชื่อ Class -->
                        <?php
                        if ($tRoute == "salemachinedeviceEventAdd") {
                        ?>
                            <div class="form-group" id="odvPunAutoGenCode">
                                <div class="validate-input">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbPhwAutoGenCode" name="ocbPhwAutoGenCode" checked="true" value="1">
                                        <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group" id="odvPhwCodeForm">
                                <input type="hidden" id="ohdCheckDuplicatePhwCode" name="ohdCheckDuplicatePhwCode" value="2">
                                <input type="text" class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" maxlength="5" id="oetPhwCode" name="oetPhwCode" data-is-created="<?php  ?>" placeholder="<?= language('pos/salemachine/salemachine', 'tPOSCodeDevice') ?><?= language('pos/salemachine/salemachine', 'tPOSTitleDevice') ?>" value="<?php $tPhwCode; ?>" data-validate-required="<?php echo language('product/pdtunit/pdtunit', 'tPunVldCode') ?>" data-validate-dublicateCode="<?php echo language('product/pdtunit/pdtunit', 'tPunVldCodeDuplicate') ?>" readonly onfocus="this.blur()">
                                <!-- <input type="hidden" value="2" id="ohdCheckDuplicatePhwCode" name="ohdCheckDuplicatePhwCode">  -->
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="form-group" id="odvPhwCodeForm">
                                <div class="validate-input">
                                    <label class="fancy-checkbox">
                                        <input type="text" class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" maxlength="5" id="oetPhwCode" name="oetPhwCode" data-is-created="<?php  ?>" placeholder="<?= language('pos/salemachine/salemachine', 'tPOSCodeDevice') ?>" value="<?php echo $tPhwCode; ?>" readonly onfocus="this.blur()">
                                    </label>
                                </div>
                            <?php
                        }
                            ?>


                            </div>

                            <!-- ชื่อ จากตาราง TCNMPOSHW  -->
                            <!-- ชื่ออุปกรณ์ -->
                            <div class="form-group">
                                <label class="xCNLabelFrm"><span class="text-danger">*</span><?= language('pos/salemachine/salemachine', 'tPOSNameDevice') ?></label>
                                <input type="text" class="form-control" maxlength="50" id="oetPhwName" name="oetPhwName" placeholder="<?= language('pos/salemachine/salemachine', 'tPOSNameDevice') ?>" value="<?= $tPhwName ?>" data-validate-required="<?= language('pos/salemachine/salemachine', 'tPOSValidName') ?>">
                            </div>

                            <!-- ชื่อเครื่องปริ้นเตอร์ จากตาราง TSysPosHW -->
                            <!-- ประเภทอุปกรณ์ -->
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?= language('pos/salemachine/salemachine', 'tPOSNamePrinter') ?></label>
                                <select class="selectpicker form-control" id="ocmShwPrinter" name="ocmShwPrinter" data-live-search="true">
                                    <!-- เครื่องพิมพ์ -->
                                    <option value='1' show='#odvModelPrinter,#odvConnType,#odvReferConn,#odvRefer' hide='#odvRefer' <?= (isset($tShwCode) && !empty($tShwCode) && $tShwCode == '1') ? "selected" : "" ?>>
                                        <?= language('pos/salemachine/salemachine', 'tPOSHWPrinter') ?>
                                    </option>
                                    <!-- จอแสดงภาพราคา -->
                                    <option value='2' show='#odvModelPrinter,#odvConnType,#odvReferConn,#odvRefer' hide='#odvModelPrinter,#odvConnType,#odvRefer,#odvReferConn' <?= (isset($tShwCode) && !empty($tShwCode) && $tShwCode == '2') ? "selected" : "" ?>>
                                        <?= language('pos/salemachine/salemachine', 'tPOSCusdisplay') ?>
                                    </option>
                                    <!-- ลิ้นชัก -->
                                    <option value='3' show='#odvModelPrinter,#odvConnType,#odvReferConn,#odvRefer' hide='#odvModelPrinter,#odvConnType,#odvRefer,#odvReferConn' <?= (isset($tShwCode) && !empty($tShwCode) && $tShwCode == '3') ? "selected" : "" ?>>
                                        <?= language('pos/salemachine/salemachine', 'tPOSDrawer') ?>
                                    </option>
                                    <!-- บัตรเครดิต -->
                                    <option value='4' show='#odvModelPrinter,#odvConnType,#odvReferConn,#odvRefer' hide='#odvRefer' <?= (isset($tShwCode) && !empty($tShwCode) && $tShwCode == '4') ? "selected" : "" ?>>
                                        <?= language('pos/salemachine/salemachine', 'tPOSHWEDC') ?>
                                    </option>
                                    <!-- เเถบเเม่เหล็ก -->
                                    <option value='5' show='#odvModelPrinter,#odvConnType,#odvReferConn,#odvRefer' hide='#odvModelPrinter,#odvConnType,#odvReferConn' <?= (isset($tShwCode) && !empty($tShwCode) && $tShwCode == '5') ? "selected" : "" ?>>
                                        <?= language('pos/salemachine/salemachine', 'tPOSHWMagReader') ?>
                                    </option>
                                    <!-- RFID -->
                                    <option value='6' show='#odvModelPrinter,#odvConnType,#odvReferConn,#odvRefer' hide='#odvRefer' <?= (isset($tShwCode) && !empty($tShwCode) && $tShwCode == '6') ? "selected" : "" ?>>
                                        <?= language('pos/salemachine/salemachine', 'tPOSHWRFIDReader') ?>
                                    </option>
                                    <!--ตู้ขายสินค้า -->
                                    <option value='9' show='' hide='#odvConnType' <?= (isset($tShwCode) && !empty($tShwCode) && $tShwCode == '9') ? "selected" : "" ?>>
                                        <?= language('pos/salemachine/salemachine', 'tPageAddTabVd') ?>
                                    </option>
                                </select>
                            </div>
                            <!-- เครื่องจุดขาย -->
                            <div class="form-group" id="odvTypePosVD">
                                <label class="xCNLabelFrm" id="odlposName"><?php echo language('pos/salemachine/salemachine', 'tPOSTitle') ?></label>
                                <div class="input-group">

                                    <?php

                                    if ($tShwCode == '9') {
                                        $tName  = $tPosName;
                                        $tValue = $tPhwCodePrinter;
                                    } else {
                                        $tName  = '';
                                        $tValue = '';
                                    }
                                    ?>
                                    <input type="text" class="form-control xCNHide" id="oetCodePos" name="oetCodePos" value="<?php echo $tValue; ?>" data-validate="<?php echo  language('pos/salemachine/salemachine', 'tPOSName'); ?>">
                                    <input type="text" class="form-control" id="oetNamePos" name="oetNamePos" value="<?php echo $tName; ?>" data-validate-required="กรุณาระบุอุปกรณ์" readonly>
                                    <input type="hidden" class="form-control" id="oetHiddenPrnType" name="oetHiddenPrnType" value="<?= $tFTPhwCustom ?>">
                                    <span class="input-group-btn">
                                        <button id="obtBrowsePos" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <!-- ชื่อเครื่องพิมพ์ ชื่อEDC ชื่อRFID -->
                            <div class="form-group" id="odvModelPrinter">
                                <label class="xCNLabelFrm" id="odlPrinterName"><?php echo language('pos/salemachine/salemachine', 'tPOSModelPrinter') ?></label>
                                <div class="input-group">

                                    <?php
                                    if ($tShwCode == '6') { //RFID
                                        $tName  = $tPhwCodePrinter;
                                        $tValue = $tPhwCodePrinter;
                                    } else if ($tShwCode == '1') { //Print
                                        $tName  = $tNamePrinter;
                                        $tValue = $tPhwCodePrinter;
                                    } else if ($tShwCode == '4') { //EDC
                                        $tName  = $tNameEDC;
                                        $tValue = $tPhwCodePrinter;
                                    } else {
                                        $tName  = '';
                                        $tValue = '';
                                    }
                                    ?>

                                    <input type="text" class="form-control xCNHide" id="oetCodePrinter" name="oetCodePrinter" value="<?php echo $tValue; ?>" data-validate="<?php echo  language('pos/salemachine/salemachine', 'tPOSNameDevice'); ?>">
                                    <input type="text" class="form-control" id="oetNamePrinter" name="oetNamePrinter" value="<?php echo $tName; ?>" data-validate-required="กรุณาระบุอุปกรณ์" readonly>
                                    <input type="hidden" class="form-control" id="oetHiddenPrnType" name="oetHiddenPrnType" value="<?= $tFTPhwCustom ?>">
                                    <span class="input-group-btn">
                                        <button id="obtBrowsePrinter" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>

                            <!-- ประเภทการเชื่อมต่อ FTPhwConnType -->
                            <div class="form-group" id="odvConnType">
                                <label class="xCNLabelFrm"><?= language('pos/salemachine/salemachine', 'tPOSConTypeDevice') ?> <?php echo $tConnType; ?></label>
                                <input type="hidden" name="ohdConnType" id="ohdConnType" value="<?php echo $tConnType; ?>">
                                <select class="selectpicker form-control" id="ocmPhwConnType" name="ocmPhwConnType" data-live-search="true">
                                    <!-- <option value="">ประเภทการเชื่อมต่อ</option>  -->
                                    <option value='1' <?= (isset($tConnType) && !empty($tConnType) && $tConnType == '1') ? "selected" : "" ?>>
                                        <?= language('pos/salemachine/salemachine', 'tPOSPrinter') ?>
                                    </option>
                                    <option value='2' <?= (isset($tConnType) && !empty($tConnType) && $tConnType == '2') ? "selected" : "" ?>>
                                        <?= language('pos/salemachine/salemachine', 'tPOSComport') ?>
                                    </option>
                                    <option value='3' <?= (isset($tConnType) && !empty($tConnType) && $tConnType == '3') ? "selected" : "" ?>>
                                        <?= language('pos/salemachine/salemachine', 'tPOSTcp') ?>
                                    </option>
                                    <option value='4' <?= (isset($tConnType) && !empty($tConnType) && $tConnType == '4') ? "selected" : "" ?>>
                                        <?= language('pos/salemachine/salemachine', 'tPOSBt') ?>
                                    </option>
                                    <option value='5' <?= (isset($tConnType) && !empty($tConnType) && $tConnType == '5') ? "selected" : "" ?>>
                                        <?= language('pos/salemachine/salemachine', 'USB') ?>
                                    </option>
                                    <option value='6' <?= (isset($tConnType) && !empty($tConnType) && $tConnType == '6') ? "selected" : "" ?>>
                                        <?= language('pos/salemachine/salemachine', 'Offline') ?>
                                    </option>
                                </select>
                            </div>

                            <!-- อ้างอิงเชื่อมต่อ -->
                            <div class="form-group" id="odvReferConn">
                                <!-- SELECT : TCP -->
                                <div id="odvTypeTCP">
                                    <label class="xCNLabelFrm" id="tPHWConnTypes"><?= language('pos/salemachine/salemachine', 'tReferConTCP') ?></label>
                                    <input type="text" class="form-control" maxlength="50" id="oetPhwConRef" name="oetPhwConRef" value="<?= $tConnRef ?>" placeholder='xxx.xxx.xx' data-validate="<?= language('pos/salemachine/salemachine', 'tPOSValidName') ?>">
                                </div>

                                <!-- SELECT : Bluetooth -->
                                <div id="odvTypeBluetooth">
                                    <label class="xCNLabelFrm" id="tPHWConnTypes"><?= language('pos/salemachine/salemachine', 'tReferBluetooth') ?></label>
                                    <input type="text" class="form-control" maxlength="50" id="oetBluetooth" name="oetBluetooth" value="<?= $tConnRef ?>" placeholder='Bluetooth name'>
                                </div>

                                <!-- SELECT : COMPORT -->
                                <div id="odvTypeComport">
                                    <label class="xCNLabelFrm" id="tPHWConnTypes"><?= language('pos/salemachine/salemachine', 'tPOSConRefDrawer') ?></label>
                                    <select class="selectpicker form-control" id="ocmComport" name="ocmComport" data-size="5" data-live-search="true">
                                        <?php for ($i = 1; $i <= 99; $i++) {
                                            if ($i == $tConnRef) {
                                                $tSelected = "selected";
                                            } else {
                                                $tSelected = '';
                                            }
                                        ?>
                                            <option <?= $tSelected ?> value='<?= $i ?>'><?= $i ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <!-- อ้างอิง Baud Rate -->
                            <div class="form-group" id="odvRefer">
                                <label class="xCNLabelFrm" id="odlBaudRate"><?php echo language('pos/salemachine/salemachine', 'tPOSModelBaudrate') ?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="oetBaudRate" name="oetBaudRate" value="<?php echo $tFTPhwCustom; ?>" data-validate-required="<?php echo language('pos/salemachine/salemachine', 'tPOSPleaseEnterBaudrate') ?>">
                                    <span class="input-group-btn">
                                        <button id="obtBrowseBaudRate" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/setting_new.png' ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <input type="hidden" name="ohdPosCode" id="ohdPosCode" value="<?php echo $tPosCode; ?>">


                    </div>
                </div>
            </div>
        </div>
</form>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>

<!-- Baud Rate -->
<div class="modal fade" id="odvModalBaudRate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('pos/salemachine/salemachine', 'tInsertBaudRate') ?></label>
            </div>
            <div class="modal-body">

                <!--Baud rate-->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('pos/salemachine/salemachine', 'tInputBaudrate') ?></label>
                    <input type="text" class="form-control" maxlength="50" id="oetBaudrate" name="oetBaudrate" value="<?php echo $tFTPhwCustomModal0; ?>">
                </div>

                <!--Parity-->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('pos/salemachine/salemachine', 'tInputParity') ?></label>
                    <input type="text" class="form-control" maxlength="50" id="oetParity" name="oetParity" value="<?php echo $tFTPhwCustomModal1; ?>">
                </div>

                <!--Length-->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('pos/salemachine/salemachine', 'tInputLength') ?></label>
                    <input type="text" class="form-control" maxlength="50" id="oetLength" name="oetLength" value="<?php echo $tFTPhwCustomModal2; ?>">
                </div>

                <!--Stop bits-->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('pos/salemachine/salemachine', 'tInputStopbits') ?></label>
                    <input type="text" class="form-control" maxlength="50" id="oetStopbits" name="oetStopbits" value="<?php echo $tFTPhwCustomModal3; ?>">
                </div>

                <!--Flow control-->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('pos/salemachine/salemachine', 'tInputFlowcontrol') ?></label>
                    <input type="text" class="form-control" maxlength="50" id="oetFlowcontrol" name="oetFlowcontrol" value="<?php echo $tFTPhwCustomModal4; ?>">
                </div>

            </div>
            <div class="modal-footer">
                <button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSxInsertTextBaudRate();"><?= language('common/main/main', 'tModalConfirm') ?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script>
    $(document).ready(function() {
      // var tOption = '<?php echo $tConnType; ?>';
      // $('#ocmPhwConnType option[value=' + tOption + ']').attr('selected', 'selected');
      // $("#ocmPhwConnType").selectpicker("refresh");
      
        //####### เข้ามาแบบ edit #######
        var tTypeOption = '<?= $tShwCode ?>';
        if (tTypeOption == '2' || tTypeOption == '3' || tTypeOption == '5') {
            var show = $("select#ocmShwPrinter option:selected").attr("show"),
                hide = $("select#ocmShwPrinter option:selected").attr("hide");
            $(show).slideDown(0);
            $(hide).slideUp(0);
        }
        $("#odvTypePosVD").hide();

        if (tTypeOption == '9') {
            // console.log('เข้า 9');
            //Browse
            $("#obtBrowsePos").unbind("click");
            $("#obtBrowsePos").bind("click", function() {
              // Create By mos 24/01/2022
              JSxCheckPinMenuClose();
              // Create By mos 24/01/2022
              JCNxBrowseData('oCmpBrowsePosDevice');
            });

           $('#odvTypePosVD').show();
           $('#odvTypeTCP').hide();
           $('#odvTypeBluetooth').hide();
           $('#odvTypeComport').hide();

           $('#odvModelPrinter').hide();
           $('#odvRefer').hide();
           $('#odvConnType').hide();
        }
        
        //RFID
        if (tTypeOption == '6') {
            // $('#odvRefer').show();
            $('#odlPrinterName').text('<?php echo language('pos/salemachine/salemachine', 'tPOSModelRFID') ?>');
            $('#obtBrowsePrinter').click(function() {
                // Create By Witsarut 04/10/2019
                JSxCheckPinMenuClose();
                // Create By Witsarut 04/10/2019
                JCNxBrowseData('oCmpBrowsePortRFID');
            });

            var tOption = '<?= $tConnType ?>';
            $('#ocmPhwConnType option[value=' + tOption + ']').attr('selected', 'selected');
            
            if (tOption == '2') { //comport
                $('#odvTypeTCP').hide();
                $('#odvTypeBluetooth').hide();
                $('#odvTypeComport').show();
                var tComport = '<?= $tConnRef ?>';
                $('#ocmComport option[value='+tComport+']').attr('selected','selected');

            } else if (tOption == '4') { //bluetooth

                $('#odvTypeTCP').hide();
                $('#odvTypeBluetooth').show();
                $('#odvTypeComport').hide();
            } else {
                $('#odvTypeTCP').hide();
                $('#odvTypeBluetooth').hide();
                $('#odvTypeComport').hide();
            }

            $('#odvRefer').hide();

        }

        //EDC
        if (tTypeOption == '4') {
            $('#odlPrinterName').text('<?php echo language('pos/salemachine/salemachine', 'tPOSModelEDC') ?>');
            $('#obtBrowsePrinter').click(function() {
                // Create By Witsarut 04/10/2019
                JSxCheckPinMenuClose();
                // Create By Witsarut 04/10/2019
                JCNxBrowseData('oCmpBrowsePortEDC');
            });

            var tOption = '<?= $tConnType ?>';
            $('#ocmPhwConnType option[value=' + tOption + ']').attr('selected', 'selected');

            if (tOption == '2') { //comport
                $('#odvTypeTCP').hide();
                $('#odvTypeBluetooth').hide();
                $('#odvTypeComport').show();
                var tComport = '<?= $tConnRef ?>';
                $('#ocmComport option[value='+tComport+']').attr('selected','selected');

            } else if (tOption == '3') { //tcp
                $('#odvTypeTCP').show();
                $('#odvTypeBluetooth').hide();
                $('#odvTypeComport').hide();
            } else if (tOption == '4') { //bluetooth
                $('#odvTypeTCP').hide();
                $('#odvTypeBluetooth').show();
                $('#odvTypeComport').hide();
            } else {
                $('#odvTypeTCP').hide();
                $('#odvTypeBluetooth').hide();
                $('#odvTypeComport').hide();
            }
            $('#odvRefer').hide();
        }

        if (tTypeOption == '1') {
            $('#tPHWConnType').text('<?php echo language('pos/salemachine/salemachine', 'tPOSConRef'); ?>');
            $('#obtBrowsePrinter').click(function() {
                // Create By Witsarut 04/10/2019
                JSxCheckPinMenuClose();
                // Create By Witsarut 04/10/2019
                JCNxBrowseData('oCmpBrowsePortPrintDevice');
            });
            // alert('1');
            var tOption = '<?= $tConnType ?>';
            $('#ocmPhwConnType option[value=' + tOption + ']').attr('selected', 'selected');
            $("#ocmPhwConnType").selectpicker("refresh");
            if (tOption == '2') { //comport
                $('#odvTypeTCP').hide();
                $('#odvTypeBluetooth').hide();
                $('#odvTypeComport').show();
                var tComport = '<?= $tConnRef ?>';
                // $('#ocmComport option[value='+tComport+']').attr('selected','selected');
            } else if (tOption == '3') { //tcp
                $('#odvTypeTCP').show();
                $('#odvTypeBluetooth').hide();
                $('#odvTypeComport').hide();
            } else if (tOption == '4') { //bluetooth
                $('#odvTypeTCP').hide();
                $('#odvTypeBluetooth').show();
                $('#odvTypeComport').hide();
            } else {
                $('#odvTypeTCP').hide();
                $('#odvTypeBluetooth').hide();
                $('#odvTypeComport').hide();
            }
            $('#odvRefer').hide();
        }
        //########### จบ #############


        //####### เข้ามาแบบ add#######
        var tStaPage = '<?= $nStaAddOrEdit ?>';
        if (tStaPage == 99) {
            $('#odvModelPrinter').show();
            $('#odvConnType').show();
            $("#obtBrowsePrinter").bind("click", function() {
                // Create By Witsarut 04/10/2019
                JSxCheckPinMenuClose();
                // Create By Witsarut 04/10/2019
                JCNxBrowseData('oCmpBrowsePortPrintDevice');
            });
            $('#odvReferConn').hide();
            $('#odvRefer').hide();
        }
        $("select#ocmShwPrinter").change(function() {
            var show = $("option:selected", this).attr("show"),
                hide = $("option:selected", this).attr("hide");
            $(show).slideDown(0);
            $(hide).slideUp(0);
        });
        $('#ocmPhwConnType').change(function() {

            $('#oetPhwConRef').val('');
            $('#oetBluetooth').val('');

            var nValue = $("#ocmPhwConnType").val();
            switch (nValue) {
                case '1': //printer
                    $('#odvTypeTCP').hide();
                    $('#odvTypeBluetooth').hide();
                    $('#odvTypeComport').hide();
                    break;

                case '2': //comport
                    $('#odvReferConn').show();

                    $('#odvTypeTCP').hide();
                    $('#odvTypeBluetooth').hide();
                    $('#odvTypeComport').show();
                    break;

                case '3': //tcp
                    $('#odvReferConn').show();

                    $('#odvTypeTCP').show();
                    $('#odvTypeBluetooth').hide();
                    $('#odvTypeComport').hide();
                    break;

                case '4': //bluetooth
                    $('#odvReferConn').show();

                    $('#odvTypeTCP').hide();
                    $('#odvTypeBluetooth').show();
                    $('#odvTypeComport').hide();
                    break;

                default:
                    $('#odvTypeTCP').hide();
                    $('#odvTypeBluetooth').hide();
                    $('#odvTypeComport').hide();
            }

        });
        //########### จบ #############
    });

    $('#obtGenCodeSaleMachineDevice').click(function() {
        JStGenerateSaleMachineDeviceCode();
    });

    $('#ocmShwPrinter').selectpicker();
    $('#ocmPhwConnType').selectpicker();
    $('#ocmBotRate').selectpicker();
    $('#ocmComport').selectpicker();

    //Browse PRINTER
    var nLangEdits = <?php echo $this->session->userdata("tLangEdit"); ?>;
    var oCmpBrowsePortPrintDevice = {
        Title: ['pos/setprinter/Setprinter', 'tBrowsePrnTitle'],
        Table: {
            Master: 'TCNMPrinter',
            PK: 'FTPrnCode'
        },
        Join: {
            Table: ['TCNMPrinter_L'],
            On: ['TCNMPrinter_L.FTPrnCode = TCNMPrinter.FTPrnCode AND TCNMPrinter_L.FNLngID = ' + nLangEdits, ]
        },
        GrideView: {
            ColumnPathLang: 'pos/setprinter/Setprinter',
            ColumnKeyLang: ['tSprCode', 'tSprName', 'tSprTypePrint'],
            ColumnsSize: ['10%', '60%', '30%'],
            DataColumns: ['TCNMPrinter.FTPrnCode', 'TCNMPrinter_L.FTPrnName', 'TCNMPrinter.FTPrnType'],
            DataColumnsFormat: ['', '', ''],
            WidthModal: 50,
            // Perpage			: 10,
            // OrderBy			: ['TCNMPrinter.FTPrnCode'],
            // SourceOrder		: "ASC"
            Perpage: 10,
            OrderBy: ['TCNMPrinter.FDCreateOn DESC'],

        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetCodePrinter", "TCNMPrinter.FTPrnCode"],
            Text: ["oetNamePrinter", "TCNMPrinter_L.FTPrnName"],
        },
        NextFunc: {
            FuncName: 'JsxSetFieldFTPhwCustom',
            ArgReturn: ['FTPrnType']
        },
        RouteAddNew: 'setprinter',
        BrowseLev: $('#oetPosStaBrowse').val()
    }

    //Browse POS
    var nLangEdits      = <?php echo $this->session->userdata("tLangEdit"); ?>;
    var tBchCodedevice  = $('#oetPosBchCode').val();
    var tPosCodePC      = $('#oetPosCode').val();

    var oCmpBrowsePosDevice = {
        Title: ['pos/salemachine/salemachine', 'tPOSTitle'],
        Table: {
            Master: 'TCNMPos',
            PK: 'FTPosCode'
        },
        Join: {
            Table   : [ 'TCNMPos_L','TCNMBranch_L','TCNMPosHW' ],
            On      : [ 
                'TCNMPos_L.FTBchCode = TCNMPos.FTBchCode AND TCNMPos_L.FTPosCode = TCNMPos.FTPosCode AND TCNMPos_L.FNLngID = ' + nLangEdits ,
                'TCNMBranch_L.FTBchCode = TCNMPos.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits ,
                "TCNMPosHW.FTBchCode = TCNMPos.FTBchCode AND TCNMPosHW.FTPosCode = '"+tPosCodePC+"' AND TCNMPosHW.FTPhwConnType = '9' AND TCNMPosHW.FTPhwCodeRef = TCNMPos.FTPosCode "
            ]
        },
        Where: {
            Condition: [
                " AND TCNMPos.FTPosType = '4' AND TCNMPos.FTBchCode = '"+tBchCodedevice+"' ",
                " AND TCNMPosHW.FTPhwCodeRef IS NULL "
            ]
        },
        GrideView: {
            ColumnPathLang: 'pos/salemachine/salemachine',
            ColumnKeyLang: ['tPOSCode', 'tPOSName'],
            ColumnsSize: ['20%','30%'],
            DataColumns: ['TCNMPos.FTPosCode', 'TCNMPos_L.FTPosName'],
            DataColumnsFormat: ['', ''],
            WidthModal: 50,
            // Perpage			: 10,
            // OrderBy			: ['TCNMPrinter.FTPrnCode'],
            // SourceOrder		: "ASC"
            Perpage: 10,
            OrderBy: ['TCNMPos.FDCreateOn DESC'],

        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetCodePos", "TCNMPos.FTPosCode"],
            Text: ["oetNamePos", "TCNMPos_L.FTPosName"],
        },
        NextFunc: {
            FuncName: 'JsxSetFieldFTPosCustom',
            ArgReturn: ['FTPosCode']
        },
        // DebugSQL: true
        // RouteAddNew: 'setprinter',
        //BrowseLev: $('#oetPosStaBrowse').val()
    }

    //Browse EDC
    var nLangEdits = <?php echo $this->session->userdata("tLangEdit"); ?>;

    var oCmpBrowsePortEDC = {
        FormName: "Edc",
        AddNewRouteName: "Edc",
        Title: ['pos/salemachine/salemachine', 'tPOSModelEDCName'],
        Table: {
            Master: 'TFNMEdc',
            PK: 'FTEdcCode'
        },
        Join: {
            Table: ['TFNMEdc_L'],
            On: ['TFNMEdc_L.FTEdcCode = TFNMEdc.FTEdcCode AND TFNMEdc_L.FNLngID = ' + nLangEdits, ]
        },
        GrideView: {
            ColumnPathLang: 'pos/salemachine/salemachine',
            ColumnKeyLang: ['tBrowseCodeEDC', 'tPOSModelEDC', 'tBrowseCodeBank'],
            ColumnsSize: ['10%', '75%'],
            DataColumns: ['TFNMEdc.FTEdcCode', 'TFNMEdc_L.FTEdcName', 'TFNMEdc.FTBnkCode'],
            DataColumnsFormat: ['', '', ''],
            WidthModal: 50,
            // Perpage			: 10,
            // OrderBy			: ['TFNMEdc.FTEdcCode'],
            // SourceOrder		: "ASC"
            Perpage: 10,
            OrderBy: ['TFNMEdc.FDCreateOn DESC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetCodePrinter", "TFNMEdc.FTEdcCode"],
            Text: ["oetNamePrinter", "TFNMEdc_L.FTEdcName"],
        },
        //DebugSQL : true,
        RouteAddNew: 'posEdc',
        BrowseLev: $('#oetPosStaBrowse').val()
    }

    //Browse RFID
    var nLangEdits = <?php echo $this->session->userdata("tLangEdit"); ?>;
    var oCmpBrowsePortRFID = {
        Title: ['pos/salemachine/salemachine', 'tBrowseRFID'],
        Table: {
            Master: 'TSysPortPrn',
            PK: 'FTSppCode'
        },
        Join: {
            Table: ['TSysPortPrn_L'],
            On: ['TSysPortPrn_L.FTSppCode = TSysPortPrn.FTSppCode AND TSysPortPrn_L.FNLngID = ' + nLangEdits, ]
        },
        Where: {
            Condition: ["AND TSysPortPrn.FTSppType  = 'BRD' "]
        },
        GrideView: {
            ColumnPathLang: 'pos/salemachine/salemachine',
            ColumnKeyLang: ['tBrowseCodeRFID', 'tBrowseNameRFID', 'tBrowseRFID'],
            ColumnsSize: ['10%', '75%'],
            DataColumns: ['TSysPortPrn.FTSppCode', 'TSysPortPrn_L.FTSppName', 'TSysPortPrn.FTSppRef'],
            DataColumnsFormat: ['', '', ''],
            DisabledColumns: [2],
            WidthModal: 50,
            // Perpage			: 10,
            // OrderBy			: ['TSysPortPrn.FTSppCode'],
            // SourceOrder		: "ASC"
            Perpage: 10,
            OrderBy: ['TSysPortPrn.FDCreateOn DESC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetCodePrinter", "TSysPortPrn.FTSppCode"],
            Text: ["oetNamePrinter", "TSysPortPrn_L.FTSppName"],
        },

    }

    // var oCmpBrowsePortRFID = {
    //     FormName : "Printer",
    //     AddNewRouteName : "Printer",
    //     Table:{Master:'TSysPortPrn',PK:'FTSppCode'},
    //     Table:{Master:'TFNMRate',PK:'FTRteCode'},
    //     Join :{
    //         Table:	['TSysPortPrn_L'],
    //         On:['TSysPortPrn_L.FTSppCode = TSysPortPrn.FTSppCode AND TSysPortPrn_L.FNLngID = '+nLangEdits,]
    //     },
    //     Where :{
    //         Condition : ["AND TSysPortPrn.FTSppType  = 'BRD' "]
    //     },
    //     GrideView:{
    //         ColumnPathLang	: 'pos/salemachine/salemachine',
    //         ColumnKeyLang	: ['tBrowseCodeRFID','tBrowseNameRFID'],
    //         ColumnsSize     : ['10%','75%'],
    //         DataColumns		: ['TSysPortPrn.FTSppCode','TSysPortPrn_L.FTSppName','TSysPortPrn.FTSppRef'],
    //         DataColumnsFormat : ['',''],
    //         WidthModal      : 50,
    //         Perpage			: 10,
    //         OrderBy			: ['TSysPortPrn.FTSppCode'],
    //         SourceOrder		: "ASC"
    //     },
    //     CallBack:{

    //         Value		: ["oetCodePrinter","TSysPortPrn.FTSppCode"],
    //         Text		: ["oetNamePrinter","TSysPortPrn_L.FTSppName"],
    //     },
    //     NextFunc:{
    //         // FuncName:'JSvCallPageRateAdd',
    //         // ArgReturn:['FTRteCode','FTRteName']
    //     },
    //     RouteAddNew : 'Printer',
    //     BrowseLev : nStaPhwBrowseType
    // }



    //เพิ่มอัตราเรด
    $('#obtBrowseBaudRate').click(function() {
        $('#odvModalBaudRate').modal('show');
    });

    //Text Baud Rate
    function JSxInsertTextBaudRate() {
        var tBaudrate = $('#oetBaudrate').val();
        var tParity = $('#oetParity').val();
        var tLength = $('#oetLength').val();
        var tStopbits = $('#oetStopbits').val();
        var tFlowcontrol = $('#oetFlowcontrol').val();

        if (tBaudrate != '') {
            tNBaudrate = tBaudrate + ';'
        } else {
            tNBaudrate = '-' + ';';
        }
        if (tParity != '') {
            tNParity = tParity + ';'
        } else {
            tNParity = '-' + ';';
        }
        if (tLength != '') {
            tNLength = tLength + ';'
        } else {
            tNLength = '-' + ';';
        }
        if (tStopbits != '') {
            tNStopbits = tStopbits + ';'
        } else {
            tNStopbits = '-' + ';';
        }
        if (tFlowcontrol != '') {
            tNFlowcontrol = tFlowcontrol + ';'
        } else {
            tNFlowcontrol = '-' + ';';
        }

        var tValueBaudRate = tNBaudrate + tNParity + tNLength + tNStopbits + tNFlowcontrol;
        var tValueBaudRate = tValueBaudRate.substring(0, (tValueBaudRate.length - 1));
        $('#oetBaudRate').val(tValueBaudRate);
        $('#odvModalBaudRate').modal('hide');
    }

    $('#ocmShwPrinter').change(function() {
        var nPHWConnType = $(this).val();
        switch (nPHWConnType.toString()) {
            case '1': //เครื่องพิมพ์
                $('#tPHWConnType').text('<?php echo language('pos/salemachine/salemachine', 'tPOSConRef'); ?>');
                JSxConditionByShwPrint('1');
                break;
            case '2': //จอแสดงภาพราคา
                $('#tPHWConnType').text('<?php echo language('pos/salemachine/salemachine', 'tPOSConRefCusDisplay'); ?>');
                JSxConditionByShwPrint('2');
                break;
            case '3': //ลิ้นชัก
                $('#tPHWConnType').text('<?php echo language('pos/salemachine/salemachine', 'tPOSConRefDrawer'); ?>');
                JSxConditionByShwPrint('3');
                break;
            case '4': //บัตรเครดิต
                $('#tPHWConnType').text('<?php echo language('pos/salemachine/salemachine', 'tPOSConRefEDC'); ?>');
                JSxConditionByShwPrint('4');
                break;
            case '5': //เเถบเเม่เหล็ก
                $('#tPHWConnType').text('<?php echo language('pos/salemachine/salemachine', 'tPOSConRefMagReader'); ?>');
                JSxConditionByShwPrint('5');
                break;
            case '6': //RFID
                $('#tPHWConnType').text('<?php echo language('pos/salemachine/salemachine', 'tPOSConRefRFIDReader'); ?>');
                JSxConditionByShwPrint('6');
                break;
            case '9': //VD
                $('#tPHWConnType').text('<?php echo language('pos/salemachine/salemachine', 'tPOSTitle'); ?>');
                JSxConditionByShwPrint('9');
                break;
            default:
                $('#tPHWConnType').text('<?php echo language('pos/salemachine/salemachine', 'tPOSConRef'); ?>');
        }
    });

    //New control input ปุ่ม browse เครื่องพิมพ์ - Supawat
    function JSxConditionByShwPrint(pnTypeShwPrint) {
        $('#oetCodePrinter').val('');
        $('#oetNamePrinter').val('');

        //Default
        $("#ocmPhwConnType option").each(function() {
            $(this).remove();
        });
        $('#ocmPhwConnType').append('<option value="1"><?= language('pos/setprinter/Setprinter', 'tPOSPrinter') ?></option>');
        $('#ocmPhwConnType').append('<option value="2"><?= language('pos/setprinter/Setprinter', 'tPOSComport') ?></option>');
        $('#ocmPhwConnType').append('<option value="3"><?= language('pos/setprinter/Setprinter', 'tPOSTcp') ?></option>');
        $('#ocmPhwConnType').append('<option value="4"><?= language('pos/setprinter/Setprinter', 'tPOSBt') ?></option>');
        $('#ocmPhwConnType').append('<option value="5"><?= language('pos/setprinter/Setprinter', 'USB') ?></option>');
        $('#ocmPhwConnType').append('<option value="6"><?= language('pos/setprinter/Setprinter', 'Offline') ?></option>');
        $("#ocmPhwConnType").selectpicker("refresh");

        //Label
        $('#odlPrinterName').text('<?php echo language('pos/salemachine/salemachine', 'tPOSModelPrinter') ?>');

        //remove value in buad rate
        $('#oetBaudRate').val('');

        switch (pnTypeShwPrint) {
            case '1': //เครื่องพิมพ์
                //Label
                $('#tPHWConnType').text('<?php echo language('pos/salemachine/salemachine', 'tPOSConRef'); ?>');

                //Browse
                $("#obtBrowsePrinter").unbind("click");
                $("#obtBrowsePrinter").bind("click", function() {
                    // Create By Witsarut 04/10/2019
                    JSxCheckPinMenuClose();
                    // Create By Witsarut 04/10/2019
                    JCNxBrowseData('oCmpBrowsePortPrintDevice');
                });
                $('#ocmPhwConnType').selectpicker('val', '1');

                $('#odvTypeTCP').hide();
                $('#odvTypeBluetooth').hide();
                $('#odvTypeComport').hide();
                $("#odvTypePosVD").hide();
                break;
            case '2': //จอแสดงภาพราคา
                //ไม่มี browse ปุ่มพิมพ์
                // $('#odvConnType').show();
                break;
            case '3': //ลิ้นชัก
                //ไม่มี browse ปุ่มพิมพ์
                // $('#odvConnType').show();
                break;
            case '4': //บัตรเครดิต
                //Label
                $('#odlPrinterName').text('<?php echo language('pos/salemachine/salemachine', 'tPOSModelEDC') ?>');

                //Browse
                $("#obtBrowsePrinter").unbind("click");
                $("#obtBrowsePrinter").bind("click", function() {
                    // Create By Witsarut 04/10/2019
                    JSxCheckPinMenuClose();
                    // Create By Witsarut 04/10/2019
                    JCNxBrowseData('oCmpBrowsePortEDC');
                });
                //Select
                $("#ocmPhwConnType option").each(function() {
                    $(this).remove();
                });

                $('#ocmPhwConnType').append('<option value="2"><?= language('pos/setprinter/Setprinter', 'tPOSComport') ?></option>');
                $('#ocmPhwConnType').append('<option value="3"><?= language('pos/setprinter/Setprinter', 'tPOSTcp') ?></option>');
                $('#ocmPhwConnType').append('<option value="4"><?= language('pos/setprinter/Setprinter', 'tPOSBt') ?></option>');
                $('#ocmPhwConnType').append('<option value="5"><?= language('pos/setprinter/Setprinter', 'USB') ?></option>');
                $('#ocmPhwConnType').append('<option value="6"><?= language('pos/setprinter/Setprinter', 'Offline') ?></option>');
                $("#ocmPhwConnType").selectpicker("refresh");
                $('#ocmPhwConnType').selectpicker('val', '2');

                $('#odvTypeTCP').hide();
                $('#odvTypeBluetooth').hide();
                $('#odvTypeComport').show();
                $("#odvTypePosVD").hide();
                break;
            case '5': //เเถบเเม่เหล็ก
                //ไม่มี browse ปุ่มพิมพ์
                // $('#odvConnType').show();
                //Browse
                $("#obtBrowsePrinter").unbind("click");
                $("#obtBrowsePrinter").bind("click", function() {
                    // Create By Witsarut 04/10/2019
                    JSxCheckPinMenuClose();
                    // Create By Witsarut 04/10/2019
                    JCNxBrowseData('oCmpBrowsePortRFID');

                });
                break;
            case '6': //RFID
                //Label
                $('#odlPrinterName').text('<?php echo language('pos/salemachine/salemachine', 'tPOSModelRFID') ?>');

                //Browse
                $("#obtBrowsePrinter").unbind("click");
                $("#obtBrowsePrinter").bind("click", function() {
                    // Create By Witsarut 04/10/2019
                    JSxCheckPinMenuClose();
                    // Create By Witsarut 04/10/2019
                    JCNxBrowseData('oCmpBrowsePortRFID');

                });

                //Select
                $("#ocmPhwConnType option").each(function() {
                    $(this).remove();
                });

                $('#ocmPhwConnType').append('<option value="2"><?= language('pos/setprinter/Setprinter', 'tPOSComport') ?></option>');
                $('#ocmPhwConnType').append('<option value="4"><?= language('pos/setprinter/Setprinter', 'tPOSBt') ?></option>');
                $('#ocmPhwConnType').append('<option value="5"><?= language('pos/setprinter/Setprinter', 'USB') ?></option>');
                $('#ocmPhwConnType').append('<option value="6"><?= language('pos/setprinter/Setprinter', 'Offline') ?></option>');
                $("#ocmPhwConnType").selectpicker("refresh");
                $('#ocmPhwConnType').selectpicker('val', '2');

                $('#odvTypeComport').show();
                $('#odvTypeTCP').hide();
                $('#odvTypeBluetooth').hide();
                $('#odvConnType').show();
                $("#odvTypePosVD").hide();
                break;
          case '9': //VD

                //Browse
                $("#obtBrowsePos").unbind("click");
                $("#obtBrowsePos").bind("click", function() {
                  // Create By mos 24/01/2022
                  JSxCheckPinMenuClose();
                  // Create By mos 24/01/2022
                  JCNxBrowseData('oCmpBrowsePosDevice');
                });


               $("#odvTypePosVD").show();
               $('#odvTypeTCP').hide();
               $('#odvTypeBluetooth').hide();
               $('#odvTypeComport').hide();
               $('#odvConnType').hide();
               $('#odvModelPrinter').hide();
                break;
            default:

        }
    }


    //Set field phwcustom
    function JsxSetFieldFTPhwCustom(oParameter) {
        var aData = JSON.parse(oParameter);
        $('#oetHiddenPrnType').val(aData);
    }

    //Set field
    function JsxSetFieldFTPosCustom(oParameter) {
        var aData = JSON.parse(oParameter);
        $('#ocmPhwConnType').val('9');
        $('#oetHiddenPrnType').val('9');
    }
</script>
