<?php defined ('BASEPATH') or exit ( 'No direct script access allowed' );


$route ['BookCheque/(:any)/(:any)']                = 'bookcheque/bookcheque/cBookCheque/index/$1/$2';
$route ['BookChequeList']                          = 'bookcheque/bookcheque/cBookCheque/FSvCBCQList';
$route ['BookChequeDatatable']                     = 'bookcheque/bookcheque/cBookCheque/FSvCBCQGetDataTable';
$route ['BookChequeAddPage']                       = 'bookcheque/bookcheque/cBookCheque/FSvCBCQAddPage';
$route ['BookChequeAddevent']                      = 'bookcheque/bookcheque/cBookCheque/FSaCBCQAddEvent';
$route ['BookChequeUpdatPage']                     = 'bookcheque/bookcheque/cBookCheque/FSvCBCQEditPage';
$route ['BookChequeUpdateevent']                   = 'bookcheque/bookcheque/cBookCheque/FSaCBCQEditEvent';
$route ['BookChequeDelevent']                      = 'bookcheque/bookcheque/cBookCheque/FSaCBCQDeleteEvent';