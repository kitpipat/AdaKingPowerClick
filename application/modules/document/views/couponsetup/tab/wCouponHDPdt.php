<div id="odvTabCouponHDPdt" class="tab-pane fade">
    <div class="row">
        <div class="table-responsive">

            <div style="padding-bottom: 20px;">
                <button id="obtTabCouponHDPdtInclude" class="xCNBTNPrimeryPlus xCNInputWhenStaCancelDoc" type="button">+</button>
            </div>
            <div>
                <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup', 'tCPHTabCouponHDPdtInclude') ?></label>
            </div>

            <table class="table xWPdtTableFont">
                <thead>
                    <tr class="xCNCenter">
                        <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/couponsetup/couponsetup', 'tCPHTabCouponHDPdtCode') ?></th>
                        <th nowrap class="xCNTextBold" style="width:60%;"><?php echo language('document/couponsetup/couponsetup', 'tCPHTabCouponHDPdtName') ?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/couponsetup/couponsetup', 'tCPHTabCouponHDPdtPunCode') ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="otbCouponHDPdtInclude">
                    <?php if (!empty($aDataDocHD['raCouponDetailInOrEx']['aCouponHDPdt'][1])) {
                        foreach ($aDataDocHD['raCouponDetailInOrEx']['aCouponHDPdt'][1] as $nKey => $aValue) {
                            $nI = strtotime(date('Y-m-d H:i:s')) . $nKey;
                    ?>
                            <tr class='otrInclude' id='otrCPHcouponIncludePdt<?= $nI ?>'>
                                <td>
                                    <input type='hidden' name='ohdCPHCouponIncludePdtCode[<?= $nI ?>]' class='ohdCPHCouponIncludePdtCode' value='<?= $aValue['FTPdtCode'] ?>'>
                                    <input type='hidden' name='ohdCPHCouponIncludePdtUnitCode[<?= $nI ?>]' class='ohdCPHCouponIncludePdtUnitCode' value='<?= $aValue['FTPunCode'] ?>'>
                                    <?= $aValue['FTPdtCode'] ?>
                                </td>
                                <td><?= $aValue['FTPdtName'] ?></td>
                                <td><?= $aValue['FTPunName'] ?></td>
                                <td align='center'><img onclick='JSxCPHcouponRemoveTRIncludePdt(<?= $nI ?>)' class='xCNIconTable xCNIconDel' src='<?php echo  base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>'></td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
        </div>

        <div class="table-responsive">
            <div style="padding-bottom: 20px;">
                <button id="obtTabCouponHDPdtExclude" class="xCNBTNPrimeryPlus xCNInputWhenStaCancelDoc" type="button">+</button>
            </div>
            <div>
                <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup', 'tCPHTabCouponHDPdtExclude') ?></label>
            </div>
            <table class="table xWPdtTableFont">
                <thead>
                    <tr class="xCNCenter">
                        <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/couponsetup/couponsetup', 'tCPHTabCouponHDPdtCode') ?></th>
                        <th nowrap class="xCNTextBold" style="width:60%;"><?php echo language('document/couponsetup/couponsetup', 'tCPHTabCouponHDPdtName') ?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/couponsetup/couponsetup', 'tCPHTabCouponHDPdtPunCode') ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="otbCouponHDPdtExclude">
                    <?php if (!empty($aDataDocHD['raCouponDetailInOrEx']['aCouponHDPdt'][2])) {
                        foreach ($aDataDocHD['raCouponDetailInOrEx']['aCouponHDPdt'][2] as $nKey => $aValue) {
                            $nI = strtotime(date('Y-m-d H:i:s')) . $nKey;
                    ?>
                            <tr class='otrExclude' id='otrCPHcouponExcludePdt<?= $nI ?>'>
                                <td>
                                    <input type='hidden' name='ohdCPHCouponExcludePdtCode[<?= $nI ?>]' class='ohdCPHCouponExcludePdtCode' value='<?= $aValue['FTPdtCode'] ?>'>
                                    <input type='hidden' name='ohdCPHCouponExcludePdtUnitCode[<?= $nI ?>]' class='ohdCPHCouponExcludePdtUnitCode' value='<?= $aValue['FTPunCode'] ?>'>
                                    <?= $aValue['FTPdtCode'] ?>
                                </td>
                                <td><?= $aValue['FTPdtName'] ?></td>
                                <td><?= $aValue['FTPunName'] ?></td>
                                <td align='center'><img onclick='JSxCPHcouponRemoveTRExcludePdt(<?= $nI ?>)' class='xCNIconTable xCNIconDel' src='<?php echo  base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>'></td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>



<div class="modal fade" id="odvCPHCouponHDPdt" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?= language('document/couponsetup/couponsetup', 'tCPHTabCouponHDPdtSelect') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="ohdCPHcouponModalTypeIncludeHDPdt" id="ohdCPHcouponModalTypeIncludeHDPdt">
                <div class='row'>
                    <div class='col-lg-12'>
                        <div class='form-group'>
                            <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup', 'tCPHTabCouponHDPdtTitle') ?></label>
                            <div class='input-group'>
                                <input type='text' class='form-control xCNHide xWCPHAllInput' id='oetCPHCouponPdtCode' name='oetCPHCouponPdtCode' maxlength='5'>
                                <input type='text' class='form-control xWPointerEventNone xWCPHAllInput' id='oetCPHCouponPdtName' name='oetCPHCouponPdtName' readonly>
                                <span class='input-group-btn'>
                                    <button id='obtCPHBrowseCouponPdtTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class='col-lg-12'>
                        <div class='form-group'>
                            <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup', 'tCPHTabCouponHDPdtPunCode') ?></label>
                            <div class='input-group'>
                                <input type='text' class='form-control xCNHide xWCPHAllInput' id='ohdCPHPdtUnitCode' name='ohdCPHPdtUnitCode' maxlength='5'>
                                <input type='text' class='form-control xWPointerEventNone xWCPHAllInput' id='ohdCPHPdtUnitName' name='ohdCPHPdtUnitName' readonly>
                                <span class='input-group-btn'>
                                    <button id='obtCPHAddProductUnit' type='button' class='btn xCNBtnBrowseAddOn' disabled><img class='xCNIconFind'></button>
                                </span>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn xCNBTNPrimery" id="obtCPHCouponSelectPdt"><?= language('common/main/main', 'tModalAdvChoose') ?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?= language('common/main/main', 'tModalAdvClose') ?></button>
            </div>
        </div>
    </div>
</div>


<script>
    // $('#obtCPHCouponSelectPdt').unbind().click(function(){
    //     var nStaSession = JCNxFuncChkSessionExpired();
    //         if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
    //             let tCouponModalTypeInclude = $('#ohdCPHcouponModalTypeIncludeHDPdt').val();
    //             let tCPHCouponPdtCode             = $('#oetCPHCouponPdtCode').val();
    //             let tCPHCouponPdtName             = $('#oetCPHCouponPdtName').val();
    //             let tCPHPdtUnitCode         = $('#ohdCPHPdtUnitCode').val();
    //             let tCPHPdtUnitName         = $('#ohdCPHPdtUnitName').val();
    //           if(tCPHCouponPdtCode!=''){
    //           let aData = { 
    //                         tCPHCouponPdtCode:tCPHCouponPdtCode,
    //                         tCPHCouponPdtName:tCPHCouponPdtName,
    //                         tCPHPdtUnitCode:tCPHPdtUnitCode,
    //                         tCPHPdtUnitName:tCPHPdtUnitName,
    //                          }

    //         let nAproveSta = JSnCHPCheckDuplicationRowHDPdt(aData);

    //             if(nAproveSta==0){

    //                 if(tCouponModalTypeInclude==1){
    //                     JSxConsNextFuncBrowsePdtInclude(aData);
    //                 }else{
    //                     JSxConsNextFuncBrowsePdtExclude(aData);
    //                 }
    //                 $("#odvCPHCouponHDPdt").modal('hide');

    //             }else{
    //              alert('Data Select Duplicate.');
    //             }

    //         }else{
    //             alert('Please Select Product');
    //         }

    //         }
    // });

    $('#obtCPHBrowseCouponPdtTo').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oCPHProductCouponOptionTo = undefined;
            oCPHProductCouponOptionTo = oCPHProductCouponOption({
                'tReturnInputCode': 'oetCPHCouponPdtCode',
                'tReturnInputName': 'oetCPHCouponPdtName',
                'tNextFuncName': 'JSxCPHConsNextFuncBrowsePdt',
                'aArgReturn': ['FTPdtCode', 'FTPdtName']
            });
            JCNxBrowseData('oCPHProductCouponOptionTo');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });


    //Click Browse Poduct Unit
    $('#obtCPHAddProductUnit').click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            // Create By Witsarut 04/10/2019
            JSxCheckPinMenuClose();
            // Create By Witsarut 04/10/2019
            window.oPdtBrowseUnitOption = oPdtBrowseUnit({
                'tReturnInputCode': 'ohdCPHPdtUnitCode',
                'tReturnInputName': 'ohdCPHPdtUnitName',
                'tNextFuncName': 'JSxAddDataUnitPackSizeToTable'
            });
            JCNxBrowseData('oPdtBrowseUnitOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });




    /*===== Begin Browse Option ======================================================= */
    var oCPHProductCouponOption = function(poReturnInputPdtCo) {
        let tNextFuncNamePdt = poReturnInputPdtCo.tNextFuncName;
        let aArgReturnPdt = poReturnInputPdtCo.aArgReturn;
        let tInputReturnCodePdt = poReturnInputPdtCo.tReturnInputCode;
        let tInputReturnNamePdt = poReturnInputPdtCo.tReturnInputName;

        let tBchCodeSess = "<?= $this->session->userdata('tSesUsrBchCodeMulti') ?>";
        let nSesUsrBchCount = "<?= $this->session->userdata('nSesUsrBchCount') ?>";
        nSesUsrBchCount
        // let tBchCodeSess    = $('#oetMmtBchCodeSelect').val();
        let tCondition = '';
        if (nSesUsrBchCount != 0) {
            if (tBchCodeSess != '') {
                tCondition += " AND ( TCNMPdtSpcBch.FTBchCode IN(" + tBchCodeSess + ") OR ( TCNMPdtSpcBch.FTBchCode IS NULL OR TCNMPdtSpcBch.FTBchCode ='' ) )";
            }
        }


        let oOptionReturnPdt = {
            Title: ['document/couponsetup/couponsetup', 'tCPHTabCouponHDPdtTitle'],
            Table: {
                Master: 'TCNMPdt',
                PK: 'FTPdtCode'
            },
            Join: {
                Table: ['TCNMPdt_L', 'TCNMPdtSpcBch'],
                On: [
                    'TCNMPdt_L.FTPdtCode = TCNMPdt.FTPdtCode AND TCNMPdt_L.FNLngID = ' + nLangEdits,
                    'TCNMPdtSpcBch.FTPdtCode = TCNMPdt.FTPdtCode'
                ]
            },
            Where: {
                Condition: [tCondition]
            },
            GrideView: {
                ColumnPathLang: 'document/couponsetup/couponsetup',
                ColumnKeyLang: ['tCPHTabCouponHDPdtCode', 'tCPHTabCouponHDPdtName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMPdt.FTPdtCode', 'TCNMPdt_L.FTPdtName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMPdt.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCodePdt, "TCNMPdt.FTPdtCode"],
                Text: [tInputReturnNamePdt, "TCNMPdt_L.FTPdtName"]
            },
            NextFunc: {
                FuncName: tNextFuncNamePdt,
                ArgReturn: aArgReturnPdt
            },
            RouteAddNew: 'product',
            BrowseLev: 0
        };
        return oOptionReturnPdt;
    };



    // Option Add Browse Product Unit 
    var oPdtBrowseUnit = function(poReturnInput) {
        let tInputReturnCode = poReturnInput.tReturnInputCode;
        let tInputReturnName = poReturnInput.tReturnInputName;
        let tNextFuncName = poReturnInput.tNextFuncName;
        let tCPHCouponPdtCode = $('#oetCPHCouponPdtCode').val();
        let oOptionReturn = {
            Title: ['product/pdtunit/pdtunit', 'tPUNTitle'],
            Table: {
                Master: 'TCNMPdtPackSize',
                PK: 'FTPunCode',
                PKName: 'FTPunName'
            },
            Join: {
                Table: ['TCNMPdtUnit_L'],
                On: ['TCNMPdtUnit_L.FTPunCode = TCNMPdtPackSize.FTPunCode AND TCNMPdtUnit_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: ["AND TCNMPdtPackSize.FTPdtCode='" + tCPHCouponPdtCode + "'"]
            },
            GrideView: {
                ColumnPathLang: 'product/pdtunit/pdtunit',
                ColumnKeyLang: ['tPUNCode', 'tPUNName'],
                ColumnsSize: ['10%', '90%'],
                WidthModal: 50,
                DataColumns: ['TCNMPdtPackSize.FTPunCode', 'TCNMPdtUnit_L.FTPunName'],
                DataColumnsFormat: ['', ''],
                Perpage: 5,
                OrderBy: ['TCNMPdtPackSize.FTPunCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMPdtPackSize.FTPunCode"],
                Text: [tInputReturnName, "TCNMPdtUnit_L.FTPunName"],

            },

            RouteAddNew: 'pdtunit',
            BrowseLev: 0
        }
        return oOptionReturn;
    }




    /*===== Begin Event Next Function Browse ========================================== */
    // Functionality : Next Function Branch And Check Data Shop And Clear Data
    // Parameter : Event Next Func Modal
    // Create : 30/09/2019 Wasin(Yoshi)
    // update : 03/10/2019 Saharat(Golf)
    // Return : Clear Velues Data
    // Return Type : -
    function JSxCPHConsNextFuncBrowsePdt(poDataNextFunc) {
        $('#ohdCPHPdtUnitCode').val('');
        $('#ohdCPHPdtUnitName').val('');
        if (typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL") {
            let aDataNextFunc = JSON.parse(poDataNextFunc);
            tPdtCode = aDataNextFunc[0];
            tPdtName = aDataNextFunc[1];
            console.log(aDataNextFunc);

            $('#obtCPHAddProductUnit').attr('disabled', false);

        } else {
            $('#obtCPHAddProductUnit').attr('disabled', true);
        }

    }



    // Functionality : Next Function MerChant And Check Data 
    // Parameter : Event Next Func Modal
    // Create : 04/10/2019 Saharat(Golf)
    // Return : Clear Velues Data
    // Return Type : -
    function JSxCPHConsNextFuncBrowseMerChant(poDataNextFunc) {

        if (typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL") {
            let aDataNextFunc = JSON.parse(poDataNextFunc);
            tMerCode = aDataNextFunc[0];
            tMerName = aDataNextFunc[1];
        }


    }


    // =========================================== Event Browse Multi Branch ===========================================
    $('#obtTabCouponHDPdtInclude').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            // $('#oetCPHCouponPdtCode').val('');
            // $('#oetCPHCouponPdtName').val('');
            // $('#ohdCPHPdtUnitCode').val('');
            // $('#ohdCPHPdtUnitName').val('');
            // $('#ohdCPHcouponModalTypeIncludeHDPdt').val(1);
            // $('#obtCPHAddProductUnit').attr('disabled',true);
            // $("#odvCPHCouponHDPdt").modal({backdrop: "static", keyboard: false});
            // $("#odvCPHCouponHDPdt").modal({show: true});

            // Last Update : 09/11/2020 Napat(Jame) เปลี่ยนเป็น Browse สินค้าจาก Center
            var dTime = new Date();
            var dTimelocalStorage = dTime.getTime();


            var aDataNotINItem = [];
            var arrIn = window.document.getElementsByClassName("ohdCPHCouponIncludePdtCode");
            var arrEx = window.document.getElementsByClassName("ohdCPHCouponExcludePdtCode");

            for (var i = 0; i < arrIn.length; i++) {
                var tPdtCodeSet = " AND Products.FTPdtCode != '" + arrIn[i].value + "' "
                aDataNotINItem.push(tPdtCodeSet);
            }

            for (var i = 0; i < arrEx.length; i++) {
                var tPdtCodeSet = " AND Products.FTPdtCode != '" + arrEx[i].value + "' "
                aDataNotINItem.push(tPdtCodeSet);
            }

            $.ajax({
                type: "POST",
                url: "BrowseDataPDT",
                data: {
                    'Qualitysearch': ['SUP', 'NAMEPDT', 'CODEPDT', 'FromToBCH', 'FromToSHP', 'FromToPGP', 'FromToPTY'],
                    'PriceType': ['Pricesell'],
                    'SelectTier': ['PDT'], //PDT, Barcode
                    'Elementreturn': ['oetInputTestValue', 'oetInputTestName'],
                    'ShowCountRecord': 10,
                    'NextFunc': 'JSxConsNextFuncBrowsePdtInclude',
                    'ReturnType': 'M', //S = Single M = Multi
                    'SPL': ['', ''],
                    'BCH': [$('#ohdCPHUsrBchCode').val(), ''], //Code, Name
                    'SHP': ['', ''],
                    'TimeLocalstorage': dTimelocalStorage,
                    'Where': aDataNotINItem
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $('#odvModalDOCPDT').modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                    $('#odvModalDOCPDT').modal({
                        show: true
                    });

                    //remove localstorage
                    localStorage.removeItem("LocalItemDataPDT");
                    $('#odvModalsectionBodyPDT').html(tResult);
                },
                error: function(data) {
                    console.log(data);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    });




    // =========================================== Event Browse Multi Branch ===========================================
    $('#obtTabCouponHDPdtExclude').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            // $('#oetCPHCouponPdtCode').val('');
            // $('#oetCPHCouponPdtName').val('');
            // $('#ohdCPHPdtUnitCode').val('');
            // $('#ohdCPHPdtUnitName').val('');
            // $('#ohdCPHcouponModalTypeIncludeHDPdt').val(2);
            // $('#obtCPHAddProductUnit').attr('disabled',true);
            // $("#odvCPHCouponHDPdt").modal({backdrop: "static", keyboard: false});
            //  $("#odvCPHCouponHDPdt").modal({show: true});

            // Last Update : 09/11/2020 Napat(Jame) เปลี่ยนเป็น Browse สินค้าจาก Center
            var dTime = new Date();
            var dTimelocalStorage = dTime.getTime();


            var aDataNotINItem = [];
            var arrIn = window.document.getElementsByClassName("ohdCPHCouponIncludePdtCode");
            var arrEx = window.document.getElementsByClassName("ohdCPHCouponExcludePdtCode");

            for (var i = 0; i < arrIn.length; i++) {
                var tPdtCodeSet = " AND Products.FTPdtCode != '" + arrIn[i].value + "' "
                aDataNotINItem.push(tPdtCodeSet);
            }

            for (var i = 0; i < arrEx.length; i++) {
                var tPdtCodeSet = " AND Products.FTPdtCode != '" + arrEx[i].value + "' "
                aDataNotINItem.push(tPdtCodeSet);
            }

            $.ajax({
                type: "POST",
                url: "BrowseDataPDT",
                data: {
                    'Qualitysearch': ['SUP', 'NAMEPDT', 'CODEPDT', 'FromToBCH', 'FromToSHP', 'FromToPGP', 'FromToPTY'],
                    'PriceType': ['Pricesell'],
                    'SelectTier': ['PDT'], //PDT, Barcode
                    'Elementreturn': ['oetInputTestValue', 'oetInputTestName'],
                    'ShowCountRecord': 10,
                    'NextFunc': 'JSxConsNextFuncBrowsePdtExclude',
                    'ReturnType': 'M', //S = Single M = Multi
                    'SPL': ['', ''],
                    'BCH': [$('#ohdCPHUsrBchCode').val(), ''], //Code, Name
                    'SHP': ['', ''],
                    'TimeLocalstorage': dTimelocalStorage,
                    'Where': aDataNotINItem
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $('#odvModalDOCPDT').modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                    $('#odvModalDOCPDT').modal({
                        show: true
                    });

                    //remove localstorage
                    localStorage.removeItem("LocalItemDataPDT");
                    $('#odvModalsectionBodyPDT').html(tResult);
                },
                error: function(data) {
                    console.log(data);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    });




    function JSnCHPCheckDuplicationRowHDPdt(paData) {

        let nLenIn = $('input[name^="ohdCPHCouponIncludePdtCode["]').length
        let aEchDataIn = JSxCreateArray(nLenIn, 2);
        //Include
        $('input[name^="ohdCPHCouponIncludePdtCode["]').each(function(index) {
            let tPdtCode = $(this).val();
            aEchDataIn[index][0] = tPdtCode;
        });
        $('input[name^="ohdCPHCouponIncludePdtUnitCode["]').each(function(index) {
            let tUnitCode = $(this).val();
            aEchDataIn[index][1] = tUnitCode;
        });

        let nLenEx = $('input[name^="ohdCPHCouponExcludePdtCode["]').length
        let aEchDataEx = JSxCreateArray(nLenEx, 3);
        //Exclude
        $('input[name^="ohdCPHCouponExcludePdtCode["]').each(function(index) {
            let tPdtCode = $(this).val();
            aEchDataEx[index][0] = tPdtCode;
        });
        $('input[name^="ohdCPHCouponExcludePdtUnitCode["]').each(function(index) {
            let tUnitCode = $(this).val();
            aEchDataEx[index][1] = tUnitCode;
        });
        // console.log("aEchDataIn",aEchDataIn);
        // console.log("aEchDataEx",aEchDataEx);

        let nAproveAppend = 0;
        for (i = 0; i < aEchDataIn.length; i++) {
            if (aEchDataIn[i][0] == paData.tCPHCouponPdtCode && aEchDataIn[i][1] == paData.tCPHPdtUnitCode) {
                nAproveAppend++;
            }
        }
        for (i = 0; i < aEchDataEx.length; i++) {
            if (aEchDataEx[i][0] == paData.tCPHCouponPdtCode && aEchDataEx[i][1] == paData.tCPHPdtUnitCode) {
                nAproveAppend++;
            }
        }
        // console.log(nAproveAppend);
        return nAproveAppend;

    }
    /*===== Begin Event Next Function Browse ========================================== */
    // Functionality : 
    // Parameter : Event Next Func Modal
    // Create : 11/02/2020 Nattakit(Nale)
    // Last Update : 09/11/2020 Napat(Jame) เปลี่ยนเป็น Browse สินค้าจาก Center
    // Return : Set Element And value
    // Return Type : -
    function JSxConsNextFuncBrowsePdtInclude(poDataNextFunc) {
        var aDataPdt = JSON.parse(poDataNextFunc);
        var nCount = $('#otbCouponHDPdtInclude tr').length;
        var tMarkUp = "";
        for (var i = 0; i < aDataPdt.length; i++) {
            var nNextRow = nCount + (i+1);
            // tMarkUp += "<tr class='otrInclude' id='otrCPHcouponIncludePdt" + i + "'>";
            tMarkUp += "<tr class='otrInclude' id='otrCPHcouponIncludePdt" + aDataPdt[i]['packData']['PDTCode'] + "'>";
            tMarkUp += "<td><input type='hidden' name='ohdCPHCouponIncludePdtCode[" + nNextRow + "]' class='ohdCPHCouponIncludePdtCode' value='" + aDataPdt[i]['packData']['PDTCode'] + "'>" + aDataPdt[i]['packData']['PDTCode'] + "</td>";
            tMarkUp += "<td>" + aDataPdt[i]['packData']['PDTName'] + "</td>";
            tMarkUp += "<td><input type='hidden' name='ohdCPHCouponIncludePdtUnitCode[" + nNextRow + "]' class='ohdCPHCouponIncludePdtUnitCode' value='" + aDataPdt[i]['packData']['PUNCode'] + "'>" + aDataPdt[i]['packData']['PUNName'] + "</td>";
            // tMarkUp += "<td align='center'><img onclick='JSxCPHcouponRemoveTRIncludePdt(" + i + ")' class='xCNIconTable xCNIconDel' src='<?php echo  base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>' ></td>";
            tMarkUp += "<td align='center'><img onclick='JSxCPHcouponRemoveTRIncludePdt(\"" + aDataPdt[i]['packData']['PDTCode'] + "\")' class='xCNIconTable xCNIconDel' src='<?php echo  base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>' ></td>";
            tMarkUp += "</tr>";
        }
        $('#otbCouponHDPdtInclude').append(tMarkUp);

        // if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
        // var i = Date.now();
        // var tMarkUp ="";
        //     tMarkUp +="<tr class='otrInclude' id='otrCPHcouponIncludePdt"+i+"'>";
        //     tMarkUp +="<td><input type='hidden' name='ohdCPHCouponIncludePdtCode["+i+"]' class='ohdCPHCouponIncludePdtCode' value='"+poDataNextFunc.tCPHCouponPdtCode+"'>"+poDataNextFunc.tCPHCouponPdtCode+"</td>";
        //     tMarkUp +="<td>"+poDataNextFunc.tCPHCouponPdtName+"</td>";
        //     tMarkUp +="<td><input type='hidden' name='ohdCPHCouponIncludePdtUnitCode["+i+"]' class='ohdCPHCouponIncludePdtUnitCode' value='"+poDataNextFunc.tCPHPdtUnitCode+"'>"+poDataNextFunc.tCPHPdtUnitName+"</td>";
        //     tMarkUp +="<td align='center'><img onclick='JSxCPHcouponRemoveTRIncludePdt("+i+")' class='xCNIconTable xCNIconDel' src='<?php echo  base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>' ></td>";
        //     tMarkUp +="</tr>";
        // $('#otbCouponHDPdtInclude').append(tMarkUp);
        // }
    }

    function JSxCPHcouponRemoveTRIncludePdt(ptCode) {
        $('#otrCPHcouponIncludePdt' + ptCode).remove();

    }

    /*===== Begin Event Next Function Browse ========================================== */
    // Functionality : 
    // Parameter : Event Next Func Modal
    // Create : 11/02/2020 Nattakit(Nale)
    // Last Update : 09/11/2020 Napat(Jame) เปลี่ยนเป็น Browse สินค้าจาก Center
    // Return : Set Element And value
    // Return Type : -
    function JSxConsNextFuncBrowsePdtExclude(poDataNextFunc) {
        var aDataPdt = JSON.parse(poDataNextFunc);
        var nCount = $('#otbCouponHDPdtExclude tr').length;

        // console.log(aDataPdt);
        var tMarkUp = "";
        for (var i = 0; i < aDataPdt.length; i++) {
            var nNextRow = nCount + (i+1);
            // tMarkUp += "<tr class='otrInclude' id='otrCPHcouponExcludePdt" + i + "'>";
            tMarkUp += "<tr class='otrInclude' id='otrCPHcouponExcludePdt" + aDataPdt[i]['packData']['PDTCode'] + "'>";
            tMarkUp += "<td><input type='hidden' name='ohdCPHCouponExcludePdtCode[" + nNextRow + "]' class='ohdCPHCouponExcludePdtCode' value='" + aDataPdt[i]['packData']['PDTCode'] + "'>" + aDataPdt[i]['packData']['PDTCode'] + "</td>";
            tMarkUp += "<td>" + aDataPdt[i]['packData']['PDTName'] + "</td>";
            tMarkUp += "<td><input type='hidden' name='ohdCPHCouponExcludePdtUnitCode[" + nNextRow + "]' class='ohdCPHCouponExcludePdtUnitCode' value='" + aDataPdt[i]['packData']['PUNCode'] + "'>" + aDataPdt[i]['packData']['PUNName'] + "</td>";
            // tMarkUp += "<td align='center'><img onclick='JSxCPHcouponRemoveTRExcludePdt(" + i + ")' class='xCNIconTable xCNIconDel' src='<?php echo  base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>' ></td>";
            tMarkUp += "<td align='center'><img onclick='JSxCPHcouponRemoveTRExcludePdt(\"" + aDataPdt[i]['packData']['PDTCode'] + "\")' class='xCNIconTable xCNIconDel' src='<?php echo  base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>' ></td>";
            tMarkUp += "</tr>";
        }
        $('#otbCouponHDPdtExclude').append(tMarkUp);

        // if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
        //     var i = Date.now();
        //     var tMarkUp ="";
        //     tMarkUp +="<tr class='otrExclude' id='otrCPHcouponExcludePdt"+i+"'>";
        //     tMarkUp +="<td><input type='hidden' name='ohdCPHCouponExcludePdtCode["+i+"]' class='ohdCPHCouponExcludePdtCode' value='"+poDataNextFunc.tCPHCouponPdtCode+"'>"+poDataNextFunc.tCPHCouponPdtCode+"</td>";
        //     tMarkUp +="<td>"+poDataNextFunc.tCPHCouponPdtName+"</td>";
        //     tMarkUp +="<td><input type='hidden' name='ohdCPHCouponExcludePdtUnitCode["+i+"]' class='ohdCPHCouponExcludePdtUnitCode' value='"+poDataNextFunc.tCPHPdtUnitCode+"'>"+poDataNextFunc.tCPHPdtUnitName+"</td>";
        //     tMarkUp +="<td align='center'><img onclick='JSxCPHcouponRemoveTRExcludePdt("+i+")' class='xCNIconTable xCNIconDel' src='<?php echo  base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>' ></td>";
        //     tMarkUp +="</tr>";
        //     $('#otbCouponHDPdtExclude').append(tMarkUp);
        // }
    }

    function JSxCPHcouponRemoveTRExcludePdt(ptCode) {
        $('#otrCPHcouponExcludePdt' + ptCode).remove();

    }
</script>