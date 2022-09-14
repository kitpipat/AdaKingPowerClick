<div class="panel-heading">

    <!--ข้อมูลส่วนล่าง-->
    <div class="row">

        <!--ตารางแพ็คเกจ-->
        <?php if($aPackageList['rtCode'] == 1){ ?>
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div class="table-responsive">
                    <table id="otbRecheckPackage" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center xCNTextBold" style="width:5%;"><?= language('common/main/main','tModalAdvNo')?></th>
                                <th class="text-center xCNTextBold"><?= language('register/buylicense/buylicense','tTitlePackage')?></th>
                                <th class="text-center xCNTextBold" style="width:15%;"><?= language('register/buylicense/buylicense','tTBTime')?></th>
                                <th class="text-center xCNTextBold text-right" style="width:15%;"><?= language('register/buylicense/buylicense','tTBTotal')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($aPackageList['rtCode'] == 1){ ?>
                                <?php 
                                    $nNumber = 1;
                                    for($i=0; $i<FCNnHSizeOf($aPackageList['raItems']); $i++){ ?>
                                        <tr>
                                            <td class="text-center"><?=$nNumber++?></td>
                                            <td class="text-left"><?=$aPackageList['raItems'][$i]['FTBuyLicenseTextPackage']?></td>
                                            <td class="text-center"><?=$aPackageList['raItems'][$i]['FTBuyLicenseTextPackageMonth']?></td>
                                            <td class="text-right"><?=number_format($aPackageList['raItems'][$i]['FTBuyLicenseTextPackagePrice'],2)?></td>
                                        </tr>
                                <?php } ?>
                            <?php }else{ ?>
                                <tr><td class='text-center xCNTextDetail2' colspan='5'><?= language('common/main/main','tMainRptNotFoundDataInDB')?></td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>

        <!--ตารางฟิเจอร์-->
        <?php if($aFeatuesList['rtCode'] == 1){ ?>
            <div class="col-xs-12 col-md-12 col-lg-12" style="margin-top:10px;">
                <div class="table-responsive">
                    <table id="otbRecheckFeatues" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center xCNTextBold" style="width:5%;"><?= language('common/main/main','tModalAdvNo')?></th>
                                <th class="text-center xCNTextBold"                  ><?= language('register/buylicense/buylicense','tTBFeatues')?></th>
                                <th class="text-center xCNTextBold" style="width:15%;"><?= language('register/buylicense/buylicense','tTBTime')?></th>
                                <th class="text-center xCNTextBold text-right" style="width:15%;"><?= language('register/buylicense/buylicense','tTBTotal')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($aFeatuesList['rtCode'] == 1){ ?>
                                <?php 
                                    $nNumber = 1;
                                    for($i=0; $i<FCNnHSizeOf($aFeatuesList['raItems']); $i++){ ?>
                                        <tr>
                                            <td class="text-center"><?=$nNumber++?></td>
                                            <td class="text-left"><?=$aFeatuesList['raItems'][$i]['FTBuyLicenseTextFeatues']?></td>
                                            <td class="text-center"><?=$aFeatuesList['raItems'][$i]['FTBuyLicenseTextFeatuesQty']?></td>
                                            <td class="text-right"><?=number_format($aFeatuesList['raItems'][$i]['FTBuyLicenseTextFeatuesPrice'],2)?></td>
                                        </tr>
                                <?php } ?>
                            <?php }else{ ?>
                                <tr><td class='text-center xCNTextDetail2' colspan='5'><?= language('common/main/main','tMainRptNotFoundDataInDB')?></td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>

        <!--จุดขาย-->
        <?php if($aPosList['rtCode'] == 1){ ?>
            <div class="col-xs-12 col-md-12 col-lg-12" style="margin-top:10px;">
                <div class="table-responsive">
                    <table id="otbRecheckPos" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center xCNTextBold" style="width:5%;"><?= language('common/main/main','tModalAdvNo')?></th>
                                <th class="text-center xCNTextBold"                  ><?= language('register/buylicense/buylicense','tTBPos')?></th>
                                <th class="text-center xCNTextBold" style="width:15%;"><?= language('register/buylicense/buylicense','tTBTime')?></th>
                                <th class="text-center xCNTextBold text-right" style="width:15%;"><?= language('register/buylicense/buylicense','tTBTotal')?></th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php if($aPosList['rtCode'] == 1){ ?>
                                <?php 
                                    $nNumber = 1;
                                    for($i=0; $i<FCNnHSizeOf($aPosList['raItems']); $i++){ ?>
                                        <tr>
                                            <td class="text-center"><?=$nNumber++?></td>
                                            <td class="text-left"><?=$aPosList['raItems'][$i]['FTBuyLicenseTextPos']?></td>
                                            <td class="text-center"><?=$aPosList['raItems'][$i]['FTBuyLicenseTextPosQty']?></td>
                                            <td class="text-right"><?=number_format($aPosList['raItems'][$i]['FTBuyLicenseTextPosPrice'],2)?></td>
                                        </tr>
                                <?php } ?>
                            <?php }else{ ?>
                                <tr><td class='text-center xCNTextDetail2' colspan='5'><?= language('common/main/main','tMainRptNotFoundDataInDB')?></td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
    </div>  
</div>