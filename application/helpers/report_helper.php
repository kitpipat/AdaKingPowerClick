<?php
    // Functionality: ฟังก์ชั่น Load View In Folder Datasources
    // Parameters:  Function Parameter
    // Creator: 19/07/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: View Report
    // ReturnType: View
    function JCNoHLoadViewAdvanceTable($tModuleName,$tViewName,$aDataViewRpt){
        ob_start();
        if(isset($aDataViewRpt)){
            extract($aDataViewRpt);
        }

        include('application/modules/'.$tModuleName.'/'.$tViewName.'.php');

        $oViewContents  = ob_get_contents();
        @ob_end_clean();
        return $oViewContents;
    }

    //สั่ง Grouping
    function FCNtHRPTHeadGroupping($pnRowPartID,$paGrouppingData){
        if($pnRowPartID == 1){
            echo "<tr class='xCNHeaderGroup'>";
            for($i = 0;$i<FCNnHSizeOf($paGrouppingData);$i++){
                if($paGrouppingData[$i] !== 'N'){
                    echo "<td style='padding: 5px;'>".$paGrouppingData[$i]."</td>";
                }else{
                    echo "<td></td>";
                }
            }
            echo "</tr>";
        }
    }

    //สั่ง Summary Sub Footer
    function FCNtHRPTSumSubFooter($pnGroupMember,$pnRowPartID,$paSumFooter){
        if($pnRowPartID == $pnGroupMember){
            echo '<tr class="xCNTrSubFooter">';
            for($i = 0;$i<FCNnHSizeOf($paSumFooter);$i++){
                if($i==0){
                $tStyle = 'text-align:left;border-top:1px solid #333;border-bottom:1px solid #333;background-color: #CFE2F3;';
                }else{
                $tStyle = 'text-align:right;border-top:1px solid #333;border-bottom:1px solid #333;background-color: #CFE2F3;';
                }
                if($paSumFooter[$i] !='N'){
                $tFooterVal =   $paSumFooter[$i];           
                }else{
                    $tFooterVal =   '';
                }
                echo '<td style="'.$tStyle.' ;padding: 4px;">'.$tFooterVal.'</td>';
            }
            echo '</tr>';
        }
    }

    //สั่ง Summary Sub Footer
    function FCNtHRPTSumSubFooter2($pnGroupMember,$pnRowPartID,$paSumFooter){
        if($pnRowPartID == $pnGroupMember){
            echo '<tr class="xCNTrSubFooter2">';
            for($i = 0;$i<FCNnHSizeOf($paSumFooter);$i++){
                if($i==0){
                $tStyle = 'color: #232C3D !important; font-size: 18px !important; font-weight: bold; text-align:left;border-top:1px solid #333;border-bottom:1px solid #333;';
                }else{
                $tStyle = 'color: #232C3D !important; font-size: 18px !important; font-weight: bold; text-align:right;border-top:1px solid #333;border-bottom:1px solid #333;';
                }
                if($paSumFooter[$i] !='N'){
                $tFooterVal =   $paSumFooter[$i];           
                }else{
                    $tFooterVal =   '';
                }
                echo '<td style="'.$tStyle.' ;padding: 4px;">'.$tFooterVal.'</td>';
            }
            echo '</tr>';
        }
    }
    
    //สั่ง Sum Footer
    function FCNtHRPTSumFooter($pnPangNo,$pnTotalPage, $paFooterData){
        if($pnPangNo == $pnTotalPage){
             echo "<tr class='xCNTrFooter'>";
          
             for($i= 0;$i<FCNnHSizeOf($paFooterData);$i++){
                if($i==0){
                     $tStyle = 'text-align:left;border-top:1px solid #333;border-bottom:1px solid #333; font-weight: bold;';
                }else{
                     $tStyle = 'text-align:right;border-top:1px solid #333;border-bottom:1px solid #333; font-weight: bold;';
                }
                if($paFooterData[$i] !='N'){
                    $tFooterVal =   $paFooterData[$i];           
                    }else{
                        $tFooterVal =   '';
                }
                echo "<td class='xCNRptSubFooter' style='$tStyle;padding: 4px;'>".$tFooterVal."</td>";
             }
            echo "<tr>";
        }
    }

    //สั่ง Sum Footer
    function FCNtHRPTSumFooter2($pnPangNo,$pnTotalPage, $paFooterData){
        if($pnPangNo == $pnTotalPage){
             echo "<tr class='xCNTrFooter2'>";
          
             for($i= 0;$i<FCNnHSizeOf($paFooterData);$i++){
                 if($i==0){
                     $tStyle = 'color: #232C3D !important; font-size: 18px !important; font-weight: bold; text-align:left;border-top:1px solid #333;border-bottom:1px solid #333;background-color: #CFE2F3;';
                     }else{
                     $tStyle = 'color: #232C3D !important; font-size: 18px !important; font-weight: bold; text-align:right;border-top:1px solid #333;border-bottom:1px solid #333;background-color: #CFE2F3;';
                 }
                 if($paFooterData[$i] !='N'){
                     $tFooterVal =   $paFooterData[$i];           
                     }else{
                         $tFooterVal =   '';
                 }
                 echo "<td style='$tStyle;padding: 4px;'>".$tFooterVal."</td>";
             }
            echo "<tr>";
        }
    }

    //สั่ง Grouping reportsaleshopgroup
    function FCNtHRPTHeadSSGGroupping($pnRowPartID,$paGrouppingData){
        $tPosShop = language('report/report/report','tRptTaxSaleLockerPos');
        if($pnRowPartID == 1){
            echo "<tr class='xCNRptDetail xCNHeaderGroup' style='width:15%;  padding: 15px;'>";
            for($i = 0;$i<FCNnHSizeOf($paGrouppingData);$i++){
                if($paGrouppingData[$i] !== 'N'){
                    echo "<td style='padding: 5px;'>".$tPosShop." : ".$paGrouppingData[$i]."</td>";
                }else{
                    echo "<td></td>";
                }
            }
            echo "</tr>";
        }
    }

    // สั่ง Grouping รายงาน - ภาษีขาย Banch
function FCNtHRPTHeadGrouppingRptTSPBch($pnRowPartID,$paGrouppingData){
    if($pnRowPartID == 1){
        echo "<tr>";
        for($i = 0;$i<FCNnHSizeOf($paGrouppingData);$i++){
            if($paGrouppingData[$i] == $paGrouppingData[0] ){
                echo "<td class='xCNRptGrouPing  text-left' colspan='3' style='padding: 5px;'>".$paGrouppingData[$i]."</td>";
            }else{
                echo "<td class='xCNRptGrouPing text-right'  style='padding: 5px;'>".$paGrouppingData[$i]."</td>";
            }
        }
        echo "</tr>";
    }
}

// สั่ง Grouping รายงาน Level1
function FCNtHRPTHeadGrouppingRptLevel1($pnRowPartID,$paGrouppingData){
    if($pnRowPartID == 1){
        echo '<tr style="border-bottom: dashed 1px #333 !important; border-top: solid 1px #333 !important;">';
        for($i = 0;$i<FCNnHSizeOf($paGrouppingData);$i++){
            if($paGrouppingData[$i] == $paGrouppingData[0] ){
                echo "<td class='xCNRptGrouPing  text-left' colspan='3' style='padding: 5px;'>".$paGrouppingData[$i]."</td>";
            }else{
                echo "<td class='xCNRptGrouPing text-right'  style='padding: 5px;'>".$paGrouppingData[$i]."</td>";
            }
        }
        echo '</tr>';
    }
}


// สั่ง Grouping รายงาน Level2
function FCNtHRPTHeadGrouppingRptLevel2($pnRowPartID,$paGrouppingData){
    if($pnRowPartID == 1){
        echo '<tr style="border-top: dashed 1px #333 !important;">';
        for($i = 0;$i<FCNnHSizeOf($paGrouppingData);$i++){
            if($paGrouppingData[$i] == $paGrouppingData[0] ){
                echo "<td class='xCNRptGrouPing  text-left' colspan='3' style='padding: 5px;'>".$paGrouppingData[$i]."</td>";
            }else{
                echo "<td class='xCNRptGrouPing text-right'  style='padding: 5px;'>".$paGrouppingData[$i]."</td>";
            }
        }
        echo '</tr>';
    }
}


// สั่ง Grouping รายงาน Level2
// Create By Witsarut 20-11-2020
function FCNtHRPTHeadGrouppingWah($pnRowPartID,$paGrouppingData){
    if($pnRowPartID == 1){
        echo '<tr style="border-top: dashed 1px #333 !important;">';
        for($i = 0;$i<FCNnHSizeOf($paGrouppingData);$i++){
            if($paGrouppingData[$i] == $paGrouppingData[0] ){
                echo "<td class='xCNRptGrouPing  text-left' colspan='1' style='padding: 5px;'>".$paGrouppingData[$i]."</td>";
            }else{
                echo "<td class='xCNRptGrouPing text-right'  style='padding: 5px;'>".$paGrouppingData[$i]."</td>";
            }
        }
        echo '</tr>';
    }
}

// สั่ง Summary Sub Footer
function FCNtHRPTSumSubFooter3($pnGroupMember, $pnRowPartID, $paSumFooter, $pnColSpan)
{
    if ($pnRowPartID == $pnGroupMember) {
        echo '<tr class="xCNTrSubFooter2" style="border-top:1px dashed #333 !important;border-bottom:1px dashed #333 !important;">';
        for ($i = 0; $i < FCNnHSizeOf($paSumFooter); $i++) {
            if ($i == 0) {
                $tStyle = 'text-align:left;';
            } else {
                $tStyle = 'text-align:right;';
            }
            if ($paSumFooter[$i] != 'N') {
                $tFooterVal = $paSumFooter[$i];
            } else {
                $tFooterVal = '';
            }
            if($pnColSpan != 0 && $i == 0){
                $tColSpan = "colspan='$pnColSpan'";
            }else{
                $tColSpan = "";
            }
            echo '<td '.$tColSpan.' class="xCNRptSubFooter" style="' . $tStyle . ' ;padding: 4px;">' . $tFooterVal . '</td>';
        }
        echo '</tr>';
    }
}

/*  Function : Clear Data All Report Temp
    create : 05-03-2019 piya
*/
function FCNoHDOCClearRptTmp()
{

    $ci = &get_instance();
    $ci->load->database();
    $tUserSesstionID = $ci->session->userdata("tSesSessionID");
    $tDateNow = date('Y-m-d');

    $aTableReportTmp = [
        "TRPTSalPdtBillTmp",
        "TRPTSalDTTmp",
        "TRPTSalRCTmp",
        "TRPTPSTaxHDTmp",
        "TRPTPSTaxHDDateTmp",
        "TRPTPSTSaleProfitTmp",
        "TRPTSalDailyByPosTmp",
        "TRPTSalDailyByCashierTmp",
        "TRPTSalMthQtyByPdtTmp",
        "TRPTSalPdtRetTmp",
        "TRPTPdtStkBalTmp",
        "TRPTPTTSpcSaleAmountTmp",
        "TRPTPSTaxDailyTmp",
        "TRPTPTTSpcPdtSaleDet",
        "TRPTPTTSpcPSSaleDailyTmp",
        "TRPTPTTSpcPSSaleWeeklyTmp",
        "TRPTSpcSalPosSrvTmp",
        "TRPTPTTSpcPSSaleMonthlyTmp",
        "TRPTPTTSpcPSVDDailySaleTmp",
        "TRPTPTTSpcPSVDMonthlySaleTmp",
        "TRPTPTTSpcPSVDWeeklySaleTmp",
        "TRPTVDTaxHDTmp",
        "TRPTVDSalRCTmp",
        "TRPTVDTopSaleTmp",
        "TRPTVDTSaleProfitTmp",
        "TRPTVDTSaleByBillTemp",
        "TRPTVDTSaleByProductTemp",
        "TRPTVDPdtStkBalTmp",
        "TRPTPdtAdjStkTmp",
        "TRPTVDPdtTwxTmp",
        "TRPTPdtStkCrdTmp",
        "TRPTRTHisChgStaLockerTmp",
        "TRPTRTOpenLockerHisAdminTmp",
        "TRPTRTTaxHDTmp",
        "TRPTRTSalRCTmp",
        "TRPTRTDepositAccordingSlotSizeTmp",
        "TRPTRTSalHDTmp",
        "TRPTRTSalDTTmp",
        "TRPTRTTimeDepositTmp",
        "TRPTRTBookingTmp",
        "TRPTLockerDetailDepositAmountTmp",
        "TRPTRTRecePtionByTimeTmp",
        "TRPTRTDropByDateTemp",
        "TRPTRTPickByDateTemp",
        "TFCTRptCrdAnalysisTmp",
        "TRPTBnkDplTmp_Moshi",
        "TRPTMnyShotOverTmp_Moshi",
        "TRPTMnyShotOverDailyDTTmp_Moshi",
        "TRPTMnyShotOverMonthlyTmp_Moshi",

        "TRPTSalByPdtSetTmp",
        "TRPTMnyShotOverDailyDTTmp",
        "TRPTMnyShotOverMonthlyTmp",
        "TRPTMnyShotOverTmp",
        "TRPTPSTTaxDateFullTmp",
        "TRPTSalByCashierAndPosTmp",
        "TRPTSalByCstTmp",
        "TRPTSalDailyTmp",
        "TRPTSalPdtBillTmp",
        "TRPTSalShiftTmp",
        "TRPTVDPayTmp",
        "TRPTVDSumPayByDateTmp",
        "TRPTAdjPriceTmp",
        "TTRPTPSByPeriodTmpAda062",
        "TRPTPdtStkCrdSumTmp",
        "TRPTPSCompareMTDTmp",
        "TRPTPSCompareYTDTmp",
        "TRPTSalByBillPdtTmp",
        "TRPTPSSDailyBySChnTmp",
    ];

    foreach ($aTableReportTmp as $tItem) {
        $ci->db->where('FDTmpTxnDate <', $tDateNow);
        $ci->db->delete($tItem);
    }
    
    if ($ci->db->affected_rows() > 0) {
        return 'success';
    } else {
        return 'fail';
    }
}

function FCNnGetNumeric($pnVal) {
    $nOptDecimalShow = get_cookie('nOptDecimalShow');
    if (is_numeric($pnVal)) {
      return str_replace(",","",number_format($pnVal,$nOptDecimalShow))+0;
    }
    return 0;
}


  
?>