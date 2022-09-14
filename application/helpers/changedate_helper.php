<?php

function FCNdHConverDate($pdDate){
	
	$dDateSelect    = str_replace('/', '-', $pdDate);
	$dDateStart     = date('Y-m-d', strtotime($dDateSelect));
	return $dDateStart;
	
}




