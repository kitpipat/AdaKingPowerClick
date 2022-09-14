<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function FCNaHCalllanguage($tFile, $tString) {
	
	$obj = & get_instance();

	if (@$_SESSION['lang'] == '' || @$_SESSION['lang'] == 'th') {
		@$_SESSION['lang'] = 'th';
		@$_SESSION ['tLangID'] = '1';
		$lang = 'th';
	} else {
		$lang = $_SESSION['lang'];
	}
	$obj->lang->load($tFile,$lang);
	$aRs = $obj->lang->line($tString);
	if ($aRs) {
		return $aRs;
	} else {
		return $tString;
	}
}


//Functionality: Get Lang Edit
//Parameters:  Function Parameter
//Creator: 19/11/2018 Krit(Copter)
//Last Modified :
//Return : 
//Return Type: Array
function FCNaHGetLangEdit() {
	//Lang ภาษา
	$nLangResort    = $_SESSION['tLangID'];
	// $nLangEdit      = $_SESSION['tLangEdit'];
	// $aLangHave		= FCNaHGetAllLangByTable();
	// $nLangHave      = FCNnHSizeOf($aLangHave);
	// if($nLangHave > 1){
	// 	if($nLangEdit != ''){
	// 		$nLangEdit = $nLangEdit;
	// 	}else{
	// 		$nLangEdit = $nLangResort;
	// 	}
	// }else{
	// 	if(@$aLangHave[0]->nLangList == ''){
	// 		$nLangEdit = '1';
	// 	}else{
	// 		$nLangEdit = $aLangHave[0]->nLangList;
	// 	}
	// }
	return $nLangResort;
}



// function language($file, $string, $sprintf = '') {
// 	$obj = & get_instance ();
// 	if (@$_SESSION ['lang'] == '' || @$_SESSION ['lang'] == 'th') {
// 		@$_SESSION ['lang'] = 'th';
// 		$lang = 'th';
// 	} else {
// 		$lang = $_SESSION ['lang'];
// 	}
// 	$obj->lang->load ( $file, $lang );
// 	$rs = sprintf ( $obj->lang->line ( $string ), $sprintf );
// 	if ($rs) {
// 		return $rs;
// 	} else {
// 		return $string;
// 	}
// }