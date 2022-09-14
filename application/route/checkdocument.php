<?php defined ('BASEPATH') or exit ( 'No direct script access allowed' );

//Information Register
$route ['mntDocSta/(:any)']              = 'checkdocument/Checkdocument_controller/index/$1';
$route ['mntDocStaPageForm']             = 'checkdocument/Checkdocument_controller/FSvCMNTGetPageForm';
$route ['mntDocStaPageSumary']           = 'checkdocument/Checkdocument_controller/FSvCMNTGetPageSumary';
$route ['mntDocStaPageDataTable']        = 'checkdocument/Checkdocument_controller/FSvCMNTGetPageDataTable';
$route ['mntDocStaPageAdd']              = 'checkdocument/Checkdocument_controller/FSvCMNTAddPage';
$route ['mntStaDocEventAdd']             = 'checkdocument/Checkdocument_controller/FSaCMNTAddEvent';

$route ['mntNewSta/(:any)']              = 'checknews/Checknews_controller/index/$1';
$route ['mntNewStaPageForm']             = 'checknews/Checknews_controller/FSvCNWKGetPageForm';
$route ['mntNewStaPageDataTable']        = 'checknews/Checknews_controller/FSvCNWKGetPageDataTable';