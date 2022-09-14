<?php
//Credit (บัตรเครดิต)
$route ['creditcard/(:any)/(:any)']     = 'creditcard/creditcard/cCreditcard/index/$1/$2';
$route ['creditcardFormSearchList']     = 'creditcard/creditcard/cCreditcard/FSxCCDCFormSearchList';
$route ['creditcardPageAdd']            = 'creditcard/creditcard/cCreditcard/FSxCCDCAddPage';
$route ['creditcardDataTable']          = 'creditcard/creditcard/cCreditcard/FSxCCDCDataTable';
$route ['creditcardPageEdit']           = 'creditcard/creditcard/cCreditcard/FSvCCDCEditPage';
$route ['creditcardEventAdd']           = 'creditcard/creditcard/cCreditcard/FSaCCDCAddEvent';
$route ['creditcardEventEdit']          = 'creditcard/creditcard/cCreditcard/FSaCCDCEditEvent';
$route ['creditcardEventDelete']        = 'creditcard/creditcard/cCreditcard/FSaCCDCDeleteEvent';

// //Bank (ธนาคาร)
// $route ['bank/(:any)/(:any)']       = 'bank/bank/cBank/index/$1/$2';
// $route ['bankFormSearchList']       = 'bank/bank/cBank/FSxCBNKFormSearchList';
// $route ['bankDataTable']            = 'bank/bank/cBank/FSxCBNKDataTable';
// $route ['bankPageAdd']              = 'bank/bank/cBank/FSaCAGNAddEvent';
// $route ['bankEventAdd']             = 'bank/bank/cBank/FSaCBNKAddEvent';
// $route ['bankPageEdit']             = 'bank/bank/cBank/FSvCBNKEditPage';
// $route ['bankEventEdit']            = 'bank/bank/cBank/FSaCBNKEditEvent';
$route ['bankEventDelete']          = 'bank/bank/cBank/FSaCBNKDeleteEvent';
// $route ['bankGetdata2']          = 'bank/bank/cBank/FSxCBNKDataTable';
