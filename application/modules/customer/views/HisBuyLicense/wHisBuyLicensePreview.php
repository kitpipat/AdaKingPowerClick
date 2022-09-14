<div class="panel-heading">
	<div class="row">

        <!--ตารางรายละเอียด-->
        <?php
            $FTPtyName = "";
            if(!empty($aResultPdtDT['raItems'])){
            foreach($aResultPdtDT['raItems'] as $nKey => $aDataDetail){
        ?>
        <?php if($FTPtyName!=$aDataDetail['FTPtyName']){ ?>
            <div class="col-xs-12 col-md-12 col-lg-12">
                <label class="xCNLabelFrm"><?= $aDataDetail['FTPtyName']?></label>
                <div class="table-responsive">
                    <table id="otbRecheckPackage" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center xCNTextBold" style="width:5%;"><?= language('common/main/main','tModalAdvNo')?></th>
                                <th class="text-center xCNTextBold"><?= $aDataDetail['FTPtyName']?></th>
                                <th class="text-center xCNTextBold" style="width:15%;"><?= language('customerlicense/customerlicense/customerlicense','tTBTime')?></th>
                                <th class="text-center xCNTextBold text-right" style="width:15%;"><?= language('customerlicense/customerlicense/customerlicense','tTBTotal')?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php } ?>
                            <tr>
                                <td class="text-center"><?=$aDataDetail['row_num']?></td>
                                <td class="text-left"><?=$aDataDetail['FTXsdPdtName']?></td>
                                <td class="text-center"><?=$aDataDetail['FTPunName']?></td>
                                <td class="text-right"><?=number_format($aDataDetail['FCXsdNetAfHD'],$nDecimalShow)?></td>
                            </tr>
                            <?php  if($aDataDetail['row_num']==$aDataDetail['LastPdtPty']){  ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php  } ?>
            <?php 
                $FTPtyName = $aDataDetail['FTPtyName'];
            }
        } ?>

        <!--สรุปบิลรวมเงิน-->
        <div class="col-xs-12 col-md-12 col-lg-12" style="margin-top:10px;">
            <div class="row">
                <div class="col-xs-8 col-md-8 col-lg-8"></div>
                <!--รวมเงิน-->
                <div class="col-xs-4 col-md-4 col-lg-4">
                    <div class="table-responsive">
                        <table id="otbTotalPrice" class="table">
                            <tbody> 
                                <tr>
                                    <?php $nPrice = $aSumFooter[0]['FCXshTotal']; ?>
                                    <td class='text-left'><?= language('register/buylicense/buylicense','tTBMoneyTotal')?></td>
                                    <td class='text-right'><?=number_format($nPrice,2)?></td>
                                </tr>
                                <tr>
                                    <?php $nPriceVat = $aSumFooter[0]['nVat']; ?>
                                    <td class='text-left'><?= language('register/buylicense/buylicense','tTBMoneyVat')?></td>
                                    <td class='text-right'><?=number_format($nPriceVat,2)?></td>
                                </tr>
                                <tr>
                                    <?php $nPriceGrand = $aSumFooter[0]['FCXshGrand']; ?>
                                    <td class='text-left'><?= language('register/buylicense/buylicense','tTBMoneyGrand')?></td>
                                    <td class='text-right'><?=number_format($nPriceGrand,2)?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>