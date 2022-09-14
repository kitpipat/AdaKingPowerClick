<?php defined ('BASEPATH') or exit ( 'No direct script access allowed' );

$route ['bankdeptype/(:any)/(:any)']              = 'bankdeptype/bankdeptype/cBankdeptype/index/$1/$2';
$route ['bankdeptypelist']                        = 'bankdeptype/bankdeptype/cBankdeptype/FSxCBDTGetDatalist';
$route ['bankdeptypedatatable']                   = 'bankdeptype/bankdeptype/cBankdeptype/FSxCBDTDataTable';
$route ['bankdeptypecallpageadd']                 = 'bankdeptype/bankdeptype/cBankdeptype/FSxCBDTAddPage';
$route ['bankdeptypeaddevent']                    = 'bankdeptype/bankdeptype/cBankdeptype/FSaCBDTAddEvent';
$route ['bankdeptypecallpageedit']                = 'bankdeptype/bankdeptype/cBankdeptype/FSvCBDTEditPage';
$route ['bankdeptypeupdateevent']                 = 'bankdeptype/bankdeptype/cBankdeptype/FSaCBNKEditEvent';
$route ['bankdeptypedelevent']                    = 'bankdeptype/bankdeptype/cBankdeptype/FSaCBDTDeleteEvent';
