<!-- Last Update : Napat(Jame) 25/11/2022 เปลี่ยนการตรวจสอบ session เป็นการตรวจสอบ cookies -->

<div class="table-responsive" style="background-color: white;">
    <table class="table" id="otbPBPdtTemp">
        <thead class="xCNPanelHeadColor">
            <tr>
                <th class="xCNTextBold" style="width:2%;color:white !important;vertical-align: middle;">
                    <label class="fancy-checkbox">
                        <input id="ocbListItemAll" checked type="checkbox" class="ocbListItemAll" name="ocbListItemAll[]" onchange="">
                        <span></span>
                    </label>
                </th>
                <?php foreach($aShwColums as $tKey => $aValue){ ?>
                    <?php if( $tKey == 'FTPbnDesc' && $tPlbCode != 'L003' ){ ?>
                    <?php }else if( $tKey == 'FTPlbStaImport' && $bSeleteImport != 1 ){ ?>
                    <?php }else{ ?>
                        <th class="xCNTextBold xCNTextDetail1 text-center" style="<?=$aValue['tStyle']?> color:white !important;vertical-align: middle;"><?php echo language('product/settingprinter/settingprinter', $aValue['tLang']) ?></th>
                    <?php } ?>
                <?php } ?>
            </tr>
        </thead>
        <tbody id="odvPBCList">
            <?php if ($aDataList['rtCode'] == 1) : ?>
                <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                    <?php
                    $FTTmpRemark = '';
                    $aRemark =  explode("$&", $aValue['FTPlbImpDesc']);
                    if ($aRemark[0] !== 'undefined') {
                        if ($aRemark[0] == '' || $aRemark[0] == null) {
                            $FTTmpRemark = '';
                        } else {
                            if (strpos($aRemark[0], "[") !== -1) {
                                $aRemarkIndex = explode("[", $aRemark[0]);
                                $aRemarkIndex =   explode("]", $aRemarkIndex[1]);
                                $FTTmpRemark = $aRemarkIndex[1];
                            }
                        }
                    }

                    if ($aValue['FTPlbStaImport'] != 1) {
                        $tDisCheck = 'disabled';
                        $tClassChkMQ = '';
                    } else {
                        $tDisCheck = '';
                        $tClassChkMQ = 'xWCheckMQ';
                    }

                    $aValue['FCPdtPrice']       = number_format($aValue['FCPdtPrice'], 2);
                    $aValue['FTPlbStaImport']   = $FTTmpRemark;
                    $tPriType                   = $aValue['FTPlbPriType']; 

                    switch($aValue['FTPlbPriType']){
                        case '2':
                            $aValue['FTPlbPriType'] = language('product/settingprinter/settingprinter', 'tPRNPreviewPromotionPrice');
                            break;
                        default:
                            $aValue['FTPlbPriType'] = language('product/settingprinter/settingprinter', 'tPRNPreviewNormalPrice');
                    }

                    ?>
                    <tr class="xWProductList">
                        <td class="xCNTextBold" style="width:5%;color:white !important;">
                            <label class="fancy-checkbox">
                                <?php 
                                if ($aValue['FTPlbStaSelect'] == 1) {
                                    $tChecked = 'checked';
                                } else {
                                    $tChecked = '';
                                }
                                ?>
                                <input type="checkbox" <?php echo $tDisCheck; ?> <?php echo $tChecked; ?> class="ocbListItem <?php echo $tClassChkMQ;  ?>" data-key="<?php echo $key; ?>" data-pdtcode="<?php echo $aValue['FTPdtCode']; ?>" data-barcode="<?php echo $aValue['FTBarCode']; ?>" data-pritype="<?=$tPriType?>">
                                <span></span>
                            </label>
                        </td>
                        <?php foreach($aShwColums as $tKeyColum => $aValueColum){ ?>
                            <?php if( $tKeyColum == 'FTPbnDesc' && $tPlbCode != 'L003' ){ ?>
                            <?php }else if( $tKeyColum == 'FTPlbStaImport' && $bSeleteImport != 1 ){ ?> 
                            <?php }else if( $tKeyColum == 'FNPlbQty' ){ ?>
                                <td><input type="text" onchange="JSvPriBarEditInLineQTYPrint($(this).val(),'<?php echo $aValue['FTPdtCode']; ?>','<?php echo $aValue['FTBarCode']; ?>','<?=$tPriType?>')" value="<?php echo $aValue['FNPlbQty']; ?>" class="form-control text-right xCNInputNumericWithoutDecimal  xCNPdtEditInLine xCNInputWithoutSpc xCNValueMon"></td>
                            <?php }else{ ?>
                                <td class="<?=$aValueColum['tdClass']?>"><?=$aValue[$tKeyColum]?></td>
                            <?php } ?>
                        <?php } ?>
                    </tr>
                <?php } ?>
            <?php else : ?>
                <tr>
                    <td class='text-center xCNTextDetail2 xCNTextNotfoundDataPdtTable' colspan='100%'><?php echo language('product/settingprinter/settingprinter', 'tLPRTNotFoundData') ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<!-- </div> -->
<!-- </div> -->
<div class="row">
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <p><?= language('common/main/main', 'tResultTotalRecord') ?> <?= $aDataList['rnAllRow'] ?> <?= language('common/main/main', 'tRecord') ?> <?= language('common/main/main', 'tCurrentPage') ?> <?= $aDataList['rnCurrentPage'] ?> / <?= $aDataList['rnAllPage'] ?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPagePriBar btn-toolbar pull-right">
            <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ -->
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSvPriBarClickPage('previous','<?php echo $tPlbCode; ?>')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for ($i = max($nPage - 2, 1); $i <= max(0, min($aDataList['rnAllPage'], $nPage + 2)); $i++) { ?>
                <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ -->
                <?php
                if ($nPage == $i) {
                    $tActive = 'active';
                    $tDisPageNumber = 'disabled';
                } else {
                    $tActive = '';
                    $tDisPageNumber = '';
                }
                ?>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <button onclick="JSvPriBarClickPage('<?php echo $i ?>','<?php echo $tPlbCode; ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aDataList['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvPriBarClickPage('next','<?php echo $tPlbCode; ?>')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        if ($('#otbPBPdtTemp tbody tr td').hasClass('xCNTextNotfoundDataPdtTable') != true) { //มีสินค้าในตาราง
            $('#odvDataPromotion .xWPRNDisabledOnPdt').prop('disabled', true);
            $('#odvDataPromotion .xCNDatePicker').prop('disabled', true);
            $('#odvDataPromotion #ocbPrnBarStaStartDate').prop('disabled', true);
            $('#odvDataPromotion #ocbPrnBarSheet').prop('disabled', true);
            $('#odvDataPromotion #oetPrnBarTotalPrint').prop('disabled', true);
            $('#oetShowDataTableProduct').prop('disabled', true);
            $('.xWDisBtnMQ').prop('disabled', false);
        } else {
            $('#odvDataPromotion .xWPRNDisabledOnPdt').prop('disabled', false);
            $('#odvDataPromotion .xCNDatePicker').prop('disabled', false);
            $('#odvDataPromotion #ocbPrnBarStaStartDate').prop('disabled', false);
            $('#odvDataPromotion #ocbPrnBarSheet').prop('disabled', false);
            $('#odvDataPromotion #oetPrnBarTotalPrint').prop('disabled', false);
            $('#oetShowDataTableProduct').prop('disabled', false);
            $('.xWDisBtnMQ').prop('disabled', true);
        }
    });

    $('#otbPBPdtTemp #ocbListItemAll').click(function() {
        $('#otbPBPdtTemp .xWCheckMQ').prop('checked', this.checked);
        JSvPriBarUpdateCheckedAll(this.checked);
    });

    function JSvPriBarEditInLineQTYPrint(pnValue, ptPdtCode, ptPdtBarCode, ptPriType) {
        // try {
        var nStaSession = JCNnCheckCookiesExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            $.ajax({
                type: "POST",
                url: "PrintBarCodeUpdateEditInLine",
                data: {
                    nValue: pnValue,
                    tPdtCode: ptPdtCode,
                    tPdtBarCode: ptPdtBarCode,
                    tPriType: ptPriType
                },
                cache: false,
                Timeout: 0,
                success: function(tResult) {},
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
            
        // } catch (err) {
        //     console.log('JSvPriBarEditInLineQTYPrint Error: ', err);
        // }

    }


    function JSvPriBarUpdateCheckedAll(pbChecked) {
        var nStaSession = JCNnCheckCookiesExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            $.ajax({
                type: "POST",
                url: "PrintBarCodeUpdateCheckedAll",
                data: {
                    bCheckedAll: pbChecked,
                },
                cache: false,
                Timeout: 0,
                success: function(tResult) {},
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }


    $('.xWCheckMQ').click(function() {
        var nStaSession = JCNnCheckCookiesExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            if ($('.xWCheckMQ:checked').length == $('.xWCheckMQ').length) {
                $('#otbPBPdtTemp #ocbListItemAll').prop('checked', true);
            } else {
                $('#otbPBPdtTemp #ocbListItemAll').prop('checked', false);
            }

            var tPdtCode = $(this).attr('data-pdtcode');
            var tBarCode = $(this).attr('data-barcode');
            var tPriType = $(this).attr('data-pritype');

            if ($(this).is(":checked")) {
                var tValueChecked = 'true'; 
            } else {
                var tValueChecked = 'false';
            }

            $.ajax({
                type: "POST",
                url: "PrintBarCodeUpdateChecked",
                data: {
                    tValueChecked: tValueChecked,
                    tPdtCode: tPdtCode,
                    tBarCode: tBarCode,
                    tPriType: tPriType
                },
                cache: false,
                Timeout: 0,
                // success: function(tResult) {},
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    });
</script>