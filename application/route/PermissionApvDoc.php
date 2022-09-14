<?php defined ('BASEPATH') or exit ( 'No direct script access allowed' );

//สิทธิ์การอนุมัติเอกสาร
$route ['PermissionApproveDoc/(:any)/(:any)']       = 'PermissionApvDoc/PermissionApvDoc/cPermissionApvDoc/index/$1/$2';
$route ['PermissionApproveDocList']                 = 'PermissionApvDoc/PermissionApvDoc/cPermissionApvDoc/FSxCPADCallPageList';
$route ['PermissionApproveDocDataTable']            = 'PermissionApvDoc/PermissionApvDoc/cPermissionApvDoc/FSxCPADDataTable';
$route ['PermissionApproveDocPageEdit']             = 'PermissionApvDoc/PermissionApvDoc/cPermissionApvDoc/FSvCPADEditPage';
$route ['PermissionApproveDocEventAdd']             = 'PermissionApvDoc/PermissionApvDoc/cPermissionApvDoc/FSvCPADEventAdd';
