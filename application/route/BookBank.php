<?php defined ('BASEPATH') or exit ( 'No direct script access allowed' );

//สมุดบัญชีธนาคาร
$route ['BookBank/(:any)/(:any)']               = 'BookBank/BookBank/cBookBank/index/$1/$2';
$route ['BookBankList']                         = 'BookBank/BookBank/cBookBank/FSxCBBKCallPageList';
$route ['BookBankDataTable']                    = 'BookBank/BookBank/cBookBank/FSxCBBKDataTable';
$route ['BookBankEventPageAdd']                 = 'BookBank/BookBank/cBookBank/FSxCBBKPageAdd';
$route ['BookBankEventAddContentDetail']        = 'BookBank/BookBank/cBookBank/FSaCBBKAddEvent';
$route ['BookBankEventEditContentDetail']       = 'BookBank/BookBank/cBookBank/FSaCBBKEditEvent';
$route ['BookBankEventPageEdit']                = 'BookBank/BookBank/cBookBank/FSvCBBKEditPage';
$route ['BookBankEventDelete']                  = 'BookBank/BookBank/cBookBank/FSaCBBKDeleteEvent';
// $route ['BookBankEventCallPageContentDetail']   = 'BookBank/BookBank/cBookBank/FSxCBBKPageContentDetail';
// $route ['BookBankEventCallPageContentAccountActivity']   = 'BookBank/BookBank/cBookBank/FSxCBBKPageContentAccountActivity';