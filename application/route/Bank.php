<?php defined ('BASEPATH') or exit ( 'No direct script access allowed' );

$route ['bankindex/(:any)/(:any)']    = 'bank/bank/cBank/index/$1/$2';
$route ['banklist']                   = 'bank/bank/cBank/FSvCBNKListPage';
$route ['bankDataTable']              = 'bank/bank/cBank/FSvCBNKDataTable';
$route ['bankPageAdd']                = 'bank/bank/cBank/FSvCBNKPageAdd';
$route ['bankPageAddinfo1']           = 'bank/bank/cBank/FSvCBNKPInfomationTab1';
$route ['bankEventAdd']               = 'bank/bank/cBank/FSoCBNKAddEvent';
$route ['bankEventDelete']            = 'bank/bank/cBank/FSoCBNKDeleteEvent';
$route ['bankPageEdit']               = 'bank/bank/cBank/FSvCBNKEditPage';
$route ['bankEventEdit']              = 'bank/bank/cBank/FSoCBNKEditEvent';

//ข้อมูล ส่วนการผ่อนชำระ
$route ['bankPageinfoTable2']          = 'bank/bank/cBank/FSvCBNKAddPageTable2';
$route ['bankPageBnkAddInfo2']         = 'bank/bank/cBank/FSvCBNKAddInfo2';
$route ['bankEventAddinfo2']           = 'bank/bank/cBank/FSoCBNKAddEventInfo2';
$route ['bankEventDeleteinfo2']        = 'bank/bank/cBank/FSoCBNKDeleteInfo2Event';
