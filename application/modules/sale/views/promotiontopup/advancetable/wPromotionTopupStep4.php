<?php if ($aDataList['tCode'] == 1) { ?>

    <!-- ประเภทบัตร -->
    <div class="row" style="margin-top:30px;" >
        <div class="col-md-6">
            <h3 style="margin-bottom:10px;font-weight: bold;"><?php echo language('sale/promotiontopup/promotiontopup', 'tPTUCardTypeInclude'); ?></h3>
            <?php 
                $nCountCtyType1 = 0;
                foreach ($aDataList['aItems'] as $key => $aValue) { 
                    if( $aValue['FTDocKey'] == 'TFNTCrdPmtDT' && $aValue['FTPmdStaType'] == '1' ){
                        echo "<div style='padding-left:20px;'>".$aValue['FTCtyName']."</div>";
                        $nCountCtyType1++;
                    }
                }
                if( $nCountCtyType1 == 0 ){
                    echo "<div style='padding-left:20px;'>-</div>";
                }
            ?>
        </div>
        <div class="col-md-6">
            <h3 style="margin-bottom:10px;font-weight: bold;"><?php echo language('sale/promotiontopup/promotiontopup', 'tPTUCardTypeExclude'); ?></h3>
            <?php 
                $nCountCtyType2 = 0;
                foreach ($aDataList['aItems'] as $key => $aValue) { 
                    if( $aValue['FTDocKey'] == 'TFNTCrdPmtDT' && $aValue['FTPmdStaType'] == '2' ){
                        echo "<div style='padding-left:20px;'>".$aValue['FTCtyName']."</div>";
                        $nCountCtyType2++;
                    }
                } 
                if( $nCountCtyType2 == 0 ){
                    echo "<div style='padding-left:20px;'>-</div>";
                }
            ?>
        </div>
    </div>
    <!-- ประเภทบัตร -->

    <hr>

    <!-- เงื่อนไขโปรโมชั่น -->
    <div class="row">
        <div class="col-md-12">
            <h3 style="margin-bottom:10px;font-weight: bold;" ><?php echo language('sale/promotiontopup/promotiontopup', 'tPTUPromotionCondition'); ?></h3>
            
                <?php 
                    foreach ($aDataList['aItems'] as $key => $aValue) { 
                        if( $aValue['FTDocKey'] == 'TFNTCrdPmtCD' ){ 
                            echo '<div class="row" style="margin-bottom:10px;padding-left:20px;">';

                                echo '<div class="col-md-2">';
                                echo "<span style='font-weight: bold;'>".language('sale/promotiontopup/promotiontopup', 'tPTUTopup')."</span> ";
                                echo number_format($aValue['FCPmcAmtPay'],$nOptDecimalShow);
                                echo "</div>";

                                if( $aValue['FCPmcAmtGet'] != 0 ){
                                    echo '<div class="col-md-3">';
                                    echo "<span style='font-weight: bold;'>".language('sale/promotiontopup/promotiontopup', 'tPTUGet')."</span> ";
                                    echo language('sale/promotiontopup/promotiontopup', 'tPTUGet2')." ";
                                    echo number_format($aValue['FCPmcAmtGet'],$nOptDecimalShow);
                                    echo "</div>";
                                }

                                if( $aValue['FTPmcRefIn'] != "" ){
                                    echo '<div class="col-md-3">';
                                    echo "<span style='font-weight: bold;'>".language('sale/promotiontopup/promotiontopup', 'tPTUGet')."</span> ";
                                    echo $aValue['FTPmcRefInName'];
                                    echo "</div>";
                                }

                            echo '</div>';
                        }
                    } 
                ?>
            </div>
        </div>
    </div>
    <!-- เงื่อนไขโปรโมชั่น -->

    <hr>

    <!-- มีผลเฉพาะ -->
    <div class="row">
        <div class="col-md-12">
            <h3 style="margin-bottom:10px;font-weight: bold;" ><?php echo language('sale/promotiontopup/promotiontopup', 'tPTUBchInclude'); ?></h3>
            
                <?php 
                    $nCountCrdPmtHDBch = 0;
                    foreach ($aDataList['aItems'] as $key => $aValue) { 
                        if( $aValue['FTDocKey'] == 'TFNTCrdPmtHDBch' && $aValue['FTPmhStaType'] == '1' ){ 
                            echo '<div class="row" style="margin-bottom:10px;padding-left:20px;">';

                                if( !empty($aValue['FTPmhAgnTo']) ){
                                    echo '<div class="col-md-3">';
                                    echo "<span style='font-weight: bold;'>".language('sale/promotiontopup/promotiontopup', 'tPTUStep3Agency')."</span> ";
                                    echo $aValue['FTAgnName'];
                                    echo "</div>";
                                }

                                if( !empty($aValue['FTPmhBchTo']) ){
                                    echo '<div class="col-md-3">';
                                    echo "<span style='font-weight: bold;'>".language('sale/promotiontopup/promotiontopup', 'tBCH')."</span> ";
                                    echo $aValue['FTBchName'];
                                    echo "</div>";
                                }

                                if( !empty($aValue['FTPmhMerTo']) ){
                                    echo '<div class="col-md-3">';
                                    echo "<span style='font-weight: bold;'>".language('sale/promotiontopup/promotiontopup', 'tBusinessGroup')."</span> ";
                                    echo $aValue['FTMerName'];
                                    echo "</div>";
                                }

                                if( !empty($aValue['FTPmhShpTo']) ){
                                    echo '<div class="col-md-3">';
                                    echo "<span style='font-weight: bold;'>".language('sale/promotiontopup/promotiontopup', 'tTBShp')."</span> ";
                                    echo $aValue['FTShpName'];
                                    echo "</div>";
                                }

                            echo '</div>';
                            $nCountCrdPmtHDBch++;
                        }
                    } 

                    if( $nCountCrdPmtHDBch == 0 ){
                        echo "<div style='padding-left:20px;'>-</div>";
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- มีผลเฉพาะ -->

    <hr>

    <!-- ยกเว้น -->
    <div class="row">
        <div class="col-md-12">
            <h3 style="margin-bottom:10px;font-weight: bold;" ><?php echo language('sale/promotiontopup/promotiontopup', 'tPTUBchExclude'); ?></h3>
            
                <?php 
                    $nCountCrdPmtHDBch2 = 0;
                    foreach ($aDataList['aItems'] as $key => $aValue) { 
                        if( $aValue['FTDocKey'] == 'TFNTCrdPmtHDBch' && $aValue['FTPmhStaType'] == '2' ){ 
                            echo '<div class="row" style="margin-bottom:10px;padding-left:20px;">';

                                if( !empty($aValue['FTPmhAgnTo']) ){
                                    echo '<div class="col-md-3">';
                                    echo "<span style='font-weight: bold;'>".language('sale/promotiontopup/promotiontopup', 'tPTUStep3Agency')."</span> ";
                                    echo $aValue['FTAgnName'];
                                    echo "</div>";
                                }

                                if( !empty($aValue['FTPmhBchTo']) ){
                                    echo '<div class="col-md-3">';
                                    echo "<span style='font-weight: bold;'>".language('sale/promotiontopup/promotiontopup', 'tBCH')."</span> ";
                                    echo $aValue['FTBchName'];
                                    echo "</div>";
                                }

                                if( !empty($aValue['FTPmhMerTo']) ){
                                    echo '<div class="col-md-3">';
                                    echo "<span style='font-weight: bold;'>".language('sale/promotiontopup/promotiontopup', 'tBusinessGroup')."</span> ";
                                    echo $aValue['FTMerName'];
                                    echo "</div>";
                                }

                                if( !empty($aValue['FTPmhShpTo']) ){
                                    echo '<div class="col-md-3">';
                                    echo "<span style='font-weight: bold;'>".language('sale/promotiontopup/promotiontopup', 'tTBShp')."</span> ";
                                    echo $aValue['FTShpName'];
                                    echo "</div>";
                                }

                            echo '</div>';
                            $nCountCrdPmtHDBch2++;
                        }
                    } 

                    if( $nCountCrdPmtHDBch2 == 0 ){
                        echo "<div style='padding-left:20px;'>-</div>";
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- ยกเว้น -->

<?php } ?>