<?php

//Functionality: row length
//Parameters:  Function Parameter
//Creator: 27/02/2018 Phisan(Arm)
//Last Modified : 
//Return : row length
//Return Type: Array
function FCNaHCallLenData($pnPerPage, $pnPage){
	$nPerPage = intval($pnPerPage);
	if (isset($pnPage)) {
		$nPage = intval($pnPage);
	} else {
		$nPage = 1;
	}

	$nRowStart = (($nPerPage * $nPage) - $nPerPage);
	
	$nRowEnd = $nPerPage * $nPage;
	
	$aLenData = array($nRowStart, $nRowEnd);
	return $aLenData;
}
