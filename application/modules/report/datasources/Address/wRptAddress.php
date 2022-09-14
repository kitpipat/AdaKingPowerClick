<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
    <?php if (isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>
        <!-- START ชื่อบริษัท -->
        <div class="text-left">
            <label class="xCNRptCompany"><?= $aCompanyInfo['FTCmpName'] ?></label>
        </div>
        <!-- END ชื่อบริษัท -->


        <!-- START ที่อยู่ -->
        <?php if($aCompanyInfo['FTAddVersion'] == '1'){ // ที่อยู่แบบแยก ?>
            <div class="text-left xCNRptAddress">
                <label class="xCNRptLabel"><?=$aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Village'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi'].' '.$aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode']?></label>
            </div>
        <?php } ?>

        <?php if($aCompanyInfo['FTAddVersion'] == '2'){ // ที่อยู่แบบรวม ?>
            <div class="text-left xCNRptAddress">
                <label><?=$aCompanyInfo['FTAddV2Desc1']?></label>
            </div>
            <div class="text-left xCNRptAddress">
                <label><?=$aCompanyInfo['FTAddV2Desc2']?></label>
            </div>
        <?php } ?>
        <!-- END ที่อยู่ -->



        <!-- START โทรศัพท์ -->
        <?php if (isset($aDataTextRef['tRptAddrTel'])) {
                  if (isset($aDataTextRef['tRptAddrFax'])) { ?>
                    <div class="text-left xCNRptAddress">
                        <label>
                          <?= $aDataTextRef['tRptAddrTel'] . $aCompanyInfo['FTCmpTel']?>
                          <?= $aDataTextRef['tRptAddrFax'] . $aCompanyInfo['FTCmpFax']?>
                        </label>
                    </div>
                  <?php }else { ?>
                    <div class="text-left xCNRptAddress">
                        <label>
                          <?php $aNewTextRptTel = explode(":",$aDataTextRef['tRptTel']); ?>
                          <?= $aNewTextRptTel[0]." : ". $aCompanyInfo['FTCmpTel'] ?>
                          <?= $aDataTextRef['tRptFaxNo'] ." ". $aCompanyInfo['FTCmpFax'] ?>
                        </label>
                    </div>
                  <?php } ?>
        <?php }else if(isset($aDataTextRef['tRptTel'])){ ?>
          <div class="text-left xCNRptAddress">
              <label><?= $aDataTextRef['tRptTel'] . $aCompanyInfo['FTCmpTel'] ?> <?= $aDataTextRef['tRptFaxNo'] . $aCompanyInfo['FTCmpFax'] ?></label>
          </div>
        <?php } ?>
        <!-- END โทรศัพท์ -->

        <!-- START สาขา -->
        <?php if (isset($aDataTextRef['tRptAddrBranch'])) { ?>
          <div class="text-left xCNRptAddress">
              <label><?=$aDataTextRef['tRptAddrBranch'] . $aCompanyInfo['FTBchName']?></label>
          </div>
        <?php }else { ?>
          <div class="text-left xCNRptAddress">
              <label><?= $aDataTextRef['tRptBranch'] ." ". $aCompanyInfo['FTBchName'] ?></label>
          </div>
        <?php } ?>
        <!-- END สาขา -->

        <!-- START เลขประจำตัวผู้เสียภาษี -->
        <?php if (isset($aDataTextRef['tRptTaxSalePosTaxId'])) { ?>
          <div class="text-left xCNRptAddress">
              <label><?=$aDataTextRef['tRptTaxSalePosTaxId'] ." : ". $aCompanyInfo['FTAddTaxNo']?></label>
          </div>
        <?php }else if(isset($aDataTextRef['tRPCTaxNo'])) { ?>
          <div class="text-left xCNRptAddress">
                <label ><?=$aDataTextRef['tRPCTaxNo'] ." : ".$aCompanyInfo['FTAddTaxNo']?></label>
          </div>
        <?php }else if(isset($aDataTextRef['tRptSalByPaymentTaxId'])) { ?>
          <div class="text-left xCNRptAddress">
              <label><?=$aDataTextRef['tRptSalByPaymentTaxId']." ".$aCompanyInfo['FTAddTaxNo']?></label>
          </div>
        <?php }else if(isset($aDataTextRef['tRptAddrTaxNo'])) { ?>
          <div class="text-left xCNRptAddress">
              <label><?php echo $aDataTextRef['tRptAddrTaxNo'] . $aCompanyInfo['FTAddTaxNo']?></label>
          </div>
        <?php }else if(isset($aDataTextRef['tRptAdjStkVDTaxNo'])) { ?>
          <div class="text-left xCNRptAddress">
            <?php $aNewText =  explode(":",$aDataTextRef['tRptAdjStkVDTaxNo']); ?>
              <label><?php echo $aNewText[0]." : ".$aCompanyInfo['FTAddTaxNo']?></label>
          </div>
        <?php }else if(isset($aDataTextRef['tRptSaleShopGroupVDTaxNo'])) { ?>
          <div class="text-left xCNRptAddress">
              <label><?php echo $aDataTextRef['tRptSaleShopGroupVDTaxNo'] ." : ". $aCompanyInfo['FTAddTaxNo']?></label>
          </div>
        <?php }else if(isset($aDataTextRef['tRptTaxNo'])) { ?>
          <div class="text-left xCNRptAddress">
              <label><?= $aDataTextRef['tRptTaxNo'] . ' : ' . $aCompanyInfo['FTAddTaxNo'] ?></label>
          </div>
        <?php }?>
        <!-- END เลขประจำตัวผู้เสียภาษี -->






    <?php } ?>
</div>
