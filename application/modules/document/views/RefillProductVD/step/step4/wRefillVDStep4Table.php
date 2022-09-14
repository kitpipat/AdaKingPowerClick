<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            <p><b> <?= language('document/RefillProductVD/RefillProductVD', 'tRVDDocumentTranfer') ?> </b></p>
        </div>
        <?php foreach($aDataListHD['raItemsHD'] AS $nKey => $aValue){ ?>
            <div class="col-lg-12">
                <?php   
                    if(isset($aValue['FTXthRefInt'])){
                        if($aValue['FTXthRefInt'] == 'WAIT-APPROVED'){
                            $tDocumentWahouse = "<label class='xCNTDTextStatus text-warning'>" . language('document/RefillProductVD/RefillProductVD', 'tRVDStaApv') ."</label>";  
                        }else{
                            $tDocumentRefInt  = trim($aValue['FTXthRefInt']);
                            $tDocumentWahouse = "<label class='xCNTDTextStatus text-success' style='text-decoration: underline; font-weight: bold; cursor: pointer;' onclick=JSxRVDGoToPageTranferWahouse('".$tDocumentRefInt."') >" . $aValue['FTXthRefInt'] ."</label>"; 
                        }
                    }else{
                        $tDocumentWahouse = "<label class='xCNTDTextStatus text-warning'>" . language('document/RefillProductVD/RefillProductVD', 'tRVDStaApv') ."</label>"; 
                    }
                ?>
                <p style="padding-left: 20px;"><?=$nKey+1?>. <?=$tDocumentWahouse?>  <?=language('document/RefillProductVD/RefillProductVD', 'tRVDAdvSearchFrom')?><?=$aValue['FTWahName']?> <?=language('document/RefillProductVD/RefillProductVD', 'tRVDTo')?> <label class="xCNNameClassStep4"></label></p>
            </div>
        <?php } ?>
    </div>
</div>
<div class="col-lg-12" style="margin-top: 20px;">
    <div class="row">
        <div class="col-lg-12">
            <p><b> <?= language('document/RefillProductVD/RefillProductVD', 'tRVDDocumentTopup') ?> </b></p>
        </div>
        <?php $tBCHCode = ''; ?>
        <input type="hidden" name="ohdCountPOS" id="ohdCountPOS" value="<?=FCNnHSizeOf($aDataListHD['raItemsDT'])?>" >
        <?php foreach($aDataListHD['raItemsHD'] AS $nKey => $aValue){ ?>
            <?php if($aValue['FTBchCode'] != $tBCHCode){ ?>
                <div class="col-lg-12">
                    <div class="row" style="border:1px solid #b2b8c1; margin: 10px 0px;">
                        <div class="col-lg-2"  style="padding: 15px;"><p style="text-align: center; display: block;"><b><?= language('document/RefillProductVD/RefillProductVD', 'tRVDAdvSearchBranch') ?><?=$aValue['FTBchName']?></b></p></div>
                        <div class="col-lg-10" style="padding: 15px; border-left:1px solid #b2b8c1;">
                            <?php $nNumber = 0; ?>
                            <?php foreach($aDataListHD['raItemsDT'] AS $nKey => $aDTValue){ ?>
                                <?php   
                                    if(isset($aDTValue['FTXthRefInt'])){
                                        if($aDTValue['FTXthRefInt'] == 'WAIT-APPROVED'){
                                            $tClassRefInf = $aDTValue['FTXthRefInt'];
                                            $oStyle = "display:block;";
                                            $tDocumentTopUp  = "<label class='xCNTDTextStatus text-warning'>" .language('document/RefillProductVD/RefillProductVD', 'tRVDStaApv') ."</label>";  
                                        }else{
                                            $tClassRefInf = $aDTValue['FTXthRefInt'];
                                            $oStyle = "display:block;";
                                            $tDocumentRefInt = trim($aDTValue['FTXthRefInt']);
                                            $tDocumentTopUp  = "<label class='xCNTDTextStatus text-success' style='text-decoration: underline; font-weight: bold; cursor: pointer;' onclick=JSxRVDGoToPageTopupVending('".$tDocumentRefInt."') >". $tDocumentRefInt ."</label>"; 
                                        }
                                    }else{
                                        $tClassRefInf = 'documentnull';
                                        $oStyle = "display:block;";
                                        $tDocumentTopUp = "<label class='xCNTDTextStatus xCNDTTopup text-warning'>" . language('document/RefillProductVD/RefillProductVD', 'tRVDStaApv') ."</label>"; 
                                    }
                                ?>
                                <p style="<?=$oStyle?>" class="<?=$tClassRefInf?>"><?=$nKey+1?>. <?=$tDocumentTopUp?> <b><?=$aDTValue['FTShpName']?></b> - <?=$aDTValue['FTPosName']?> (<?=$aDTValue['FTPosCode']?>)</p>

                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php $tBCHCode = $aValue['FTBchCode']; ?>
            <?php } ?>
            
        <?php } ?>
    </div>
</div>

<script>
    //เช็คว่าเอกสารอนุมัติ หรือ ยกเลิกหรือเปล่า
    JSxControlWhenApproveOrCancel();
    
    var tNameClass = $('#oetRVDWahTransferName').val();
    $('.xCNNameClassStep4').text(' ' + tNameClass);

    //กดลิงค์ไปเอกสารใบโอนสินค้าระหว่างคลัง
    function JSxRVDGoToPageTranferWahouse(ptDocumentTrensferWahouse){
        JCNxOpenLoading();

        $.ajax({
            url     : 'TFW/0/0',
            type    : "POST",
            error   : function (jqXHR, textStatus, errorThrown) {
                JCNxCloseLoading();
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            },
            success : function (tView) {
                $(window).scrollTop(0);
                $('.odvMainContent').html(tView);

                //ไปเอกสารแบบหน้าจอแก้ไข
                JSxRefillVDToTransferWahousePageEdit(ptDocumentTrensferWahouse);
            }
        });
    }

    //กดลิงค์ไปเอกสารใบเติม
    function JSxRVDGoToPageTopupVending(ptDocumentTopup){
        $.ajax({
            url     : 'TWXVD/0/0',
            type    : "POST",
            error   : function (jqXHR, textStatus, errorThrown) {
                JCNxCloseLoading();
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            },
            success: function (tView) {
                $(window).scrollTop(0);
                $('.odvMainContent').html(tView);

                //ไปเอกสารแบบหน้าจอแก้ไข
                JSxRefillVDToTopUpVendingPageEdit(ptDocumentTopup);
            }
        });
    }

    //ถ้าเป็นเอกสารขาเพิ่มต้องโชว์หมด
    if($('#ohdRVDRoute').val() == 'docRVDRefillPDTVDEventAdd'){
        $('.xCNDTTopup').show();
    }else{
        $('.documentnull').hide();
        
    }
</script>