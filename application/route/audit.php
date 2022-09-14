<?php
defined ('BASEPATH') or exit ( 'No direct script access allowed' );
$route['Audit']                                     = 'audit/audit/cAudit/index';
$route['AuditDelete']                               = 'audit/audit/cAudit/FSvADIDeleteData';
$route['AuditDataList']                             = 'audit/audit/cAudit/FSvADIDataList';
$route['AuditDefult']                               = 'audit/audit/cAudit/FSvADIDefult';
$route['AuditPageAdd']                              = 'audit/audit/cAudit/FSvCAUDCallPageAdd';
$route['AuditPageEdit']                             = 'audit/audit/cAudit/FSvCAUDCallPageAdd';
$route['AuditMovedata']                             = 'audit/audit/cAudit/FSvADIPageMovedata';
$route['Audit_newpage']                             = 'audit/audit/cAudit/FSvADIPageMovedataDoc';
$route['AuditEventAdd']                             = 'audit/audit/cAudit/FSaCAUDAddEvent';
$route['AuditSearchComB']                           = 'audit/audit/cAudit/FSaCAUDSearchComB';
$route['AuditGetTranferMaster']                     = 'audit/audit/cAudit/FSaCAUDGetTranferMaster';
$route['AuditSearchListDoc']                        = 'audit/audit/cAudit/FSaCAUDGetListDoc';
$route['AuditGetMoverMaster']                       = 'audit/audit/cAudit/FSaCAUDMoverMaster';
$route['AuditGetBch']                               = 'audit/audit/cAudit/FSaCAUDGetBch';
$route['AuditGetNewDoc']                            = 'audit/audit/cAudit/FSaCAUDGetNewDoc';

 ?>
