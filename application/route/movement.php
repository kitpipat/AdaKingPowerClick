<?php defined ('BASEPATH') or exit ( 'No direct script access allowed' );

// คลังสินค้า >> คลัง >> ความเคลื่อนไหว
$route ['movement/(:any)/(:any)']    = 'movement/movement/cMovement/index/$1/$2';
$route ['movementList']              = 'movement/movement/cMovement/FSvCMovementListPage';
$route ['movementDataTable']         = 'movement/movement/cMovement/FSvCMovementDataList';

$route['mmtMMTPageContentTab']       = 'movement/movement/cMovement/FSxMmtContentTab';
$route['mmtINV/(:any)/(:any)']       = 'movement/inventory/cInv/index/$1/$2';
$route['mmtINVPageList']             = 'movement/inventory/cInv/FSxCInvPageList';
$route['mmtINVDataTableList']        = 'movement/inventory/cInv/FSxCInvDataTableList';
$route['mmtINVPdtFhnDataTableList']  = 'movement/inventory/cInv/FSxCInvPdtFhnDataTableList';


