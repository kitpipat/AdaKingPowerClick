<?php

//Functionality: Gen Coupon Code
//Parameters:  Function Parameter
//Creator: 25/12/2019 Napat(Jame)
//Last Modified : -
//Return : Coupon Code
//Return Type: Array
function FCNaHGenCoupon($nLength,$tPrefix,$nQty,$nStartNo){

    $aResult = array();
    $nGapLen = $nLength - strlen($tPrefix);

    for($i=0;$i<$nQty;$i++){
        if(isset($tPrefix) && !empty($tPrefix)){
            array_push($aResult,sprintf($tPrefix."%0".$nGapLen."d",$nStartNo++));
        }else{
            array_push($aResult,sprintf("%0".$nLength."d",$nStartNo++));
        }
    }

    return $aResult;

}

/**
 * Functionality: Gen Coupon Code
 * Parameters:   Function Parameter
 * Creator:  25/12/2019 Saharat(Golf)
 * LastUpdate: -
 * Return: Coupon Code
 * ReturnType: Array
 */
function FCNaRunningNumber($pnLenge,$pnQty){

    $aResultNumber  = array();
    $nLenght = $pnLenge;
    for($i = 0; $i <= $pnQty; $i++){
        $nResult = sprintf("%0".$nLenght."d", mt_rand(100000,9999999999999));
        $aResultNumber[$i] = $nResult;
    }

    return   $aResultNumber; 
}
