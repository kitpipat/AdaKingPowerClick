<?php

//Card
$route['card/(:any)/(:any)']       = 'payment/card/cCard/index/$1/$2';
$route['cardList']                 = 'payment/card/cCard/FSvCCRDListPage';
$route['cardDataTable']            = 'payment/card/cCard/FSvCCRDDataList';
$route['cardPageAdd']              = 'payment/card/cCard/FSvCCRDAddPage';
$route['cardPageEdit']             = 'payment/card/cCard/FSvCCRDEditPage';
$route['cardEventAdd']             = 'payment/card/cCard/FSoCCRDAddEvent';
$route['cardEventEdit']            = 'payment/card/cCard/FSoCCRDEditEvent';
$route['cardEventDelete']          = 'payment/card/cCard/FSoCCRDDeleteEvent';
$route['checkStatusActive']        = "payment/card/cCard/FSvCCRDChkStaAct";
$route['cardGetHisDataTable'] = "payment/card/cCard/FSvCCRDGetHisDataTable";

//CardType (ประเภทบัตร)
$route['cardtype/(:any)/(:any)']   = 'payment/cardtype/cCardType/index/$1/$2';
$route['cardtypeList']             = 'payment/cardtype/cCardType/FSvCCTYListPage';
$route['cardtypeDataTable']        = 'payment/cardtype/cCardType/FSvCCTYDataList';
$route['cardtypePageAdd']          = 'payment/cardtype/cCardType/FSvCCTYAddPage';
$route['cardtypePageEdit']         = 'payment/cardtype/cCardType/FSvCCTYEditPage';
$route['cardtypeEventAdd']         = 'payment/cardtype/cCardType/FSoCCTYAddEvent';
$route['cardtypeEventEdit']        = 'payment/cardtype/cCardType/FSoCCTYEditEvent';
$route['cardtypeEventDelete']      = 'payment/cardtype/cCardType/FSoCCTYDeleteEvent';

//Recive (ประเภทการชำระเงิน)
$route['recive/(:any)/(:any)']      = 'payment/recive/cRecive/index/$1/$2';
$route['reciveList']                = 'payment/recive/cRecive/FSvRCVListPage';
$route['reciveDataTable']           = 'payment/recive/cRecive/FSvRCVDataList';
$route['recivePageAdd']             = 'payment/recive/cRecive/FSvRCVAddPage';
$route['reciveEventAdd']            = 'payment/recive/cRecive/FSaRCVAddEvent';
$route['recivePageEdit']            = 'payment/recive/cRecive/FSvRCVEditPage';
$route['reciveEventEdit']           = 'payment/recive/cRecive/FSaRCVEditEvent';
$route['reciveEventDelete']         = 'payment/recive/cRecive/FSaRCVDeleteEvent';
$route['recivespcGetRcvConfig']     = 'payment/recive/cRecive/FSaCRCVGetRcvConfig';

//BankNote (ธนบัตร)
$route['banknote/(:any)/(:any)']   = 'payment/banknote/cBanknote/index/$1/$2';
$route['banknoteList']             = 'payment/banknote/cBanknote/FSvCBNTListPage';
$route['banknoteDataTable']        = 'payment/banknote/cBanknote/FSvCBNTDataList';
$route['banknotePageAdd']          = 'payment/banknote/cBanknote/FSvCBNTAddPage';
$route['banknotePageEdit']         = 'payment/banknote/cBanknote/FSvCBNTEditPage';
$route['banknoteEventAdd']         = 'payment/banknote/cBanknote/FSoCBNTAddEvent';
$route['banknoteEventEdit']        = 'payment/banknote/cBanknote/FSoCBNTEditEvent';
$route['banknoteEventDelete']      = 'payment/banknote/cBanknote/FSoCBNTDeleteEvent';
$route['banknoteUniqueValidate']   = 'payment/banknote/cBanknote/FStCBanknoteUniqueValidate';
$route['banknoteChkStaShw']        = 'payment/banknote/cBanknote/FSaCBNTChkStaShw';

//Rate สกุลเงิน
$route['rate/(:any)/(:any)']       = 'payment/rate/cRate/index/$1/$2';
$route['rateFormSearchList']       = 'payment/rate/cRate/FSxCRTEFormSearchList';
$route['ratePageAdd']              = 'payment/rate/cRate/FSxCRTEAddPage';
$route['rateDataTable']            = 'payment/rate/cRate/FSxCRTEDataTable';
$route['ratePageEdit']             = 'payment/rate/cRate/FSvCRTEEditPage';
$route['rateEventAdd']             = 'payment/rate/cRate/FSaCRTEAddEvent';
$route['rateEventEdit']            = 'payment/rate/cRate/FSaCRTEEditEvent';
$route['rateEventDelete']          = 'payment/rate/cRate/FSaCRTEDeleteEvent';

//CardLogin
$route['cardlogin']                     = 'payment/cardlogin/cCardlogin/FSvCCardloginMainPage';
$route['cardloginDataTable']            = 'payment/cardlogin/cCardlogin/FSvCCardLogDataList';
$route['cardloginPageAdd']              = 'payment/cardlogin/cCardlogin/FSvCCardlogPageAdd';
$route['cardloginEventAdd']             = 'payment/cardlogin/cCardlogin/FSaCCardlogAddEvent';
$route['cardloginPageEdit']             = 'payment/cardlogin/cCardlogin/FSvCCardlogPageEdit';
$route['cardloginEventEdit']            = 'payment/cardlogin/cCardlogin/FSaCCardlogEditEvent';
$route['cardloginEventDelete']          = 'payment/cardlogin/cCardlogin/FSaCCardlogDeleteEvent';
$route['cardloginEventDeleteMultiple']  = 'payment/cardlogin/cCardlogin/FSoCCardlogDelMultipleEvent';

// Create By Witsarut 27/11/2019
//ReciveSpc
$route['recivespc/(:any)/(:any)']       = 'payment/recivespc/cReciveSpc/FSvCReciveSpcMainPage/$1/$2';
$route['recivespcDataTable']            = 'payment/recivespc/cReciveSpc/FSvCReciveSpcDataList';
$route['recivespcPageAdd']              = 'payment/recivespc/cReciveSpc/FSvCReciveSpcPageAdd';
$route['recivespcEventAdd']             = 'payment/recivespc/cReciveSpc/FSaCReciveSpcAddEvent';
$route['recivespcPageEdit']             = 'payment/recivespc/cReciveSpc/FSvCReciveSpcPageEdit';
$route['recivespcEventEdit']            = 'payment/recivespc/cReciveSpc/FSaCReciveSpcEditEvent';
$route['recivespcEventDelete']          = 'payment/recivespc/cReciveSpc/FSaCReciveSpcDeleteEvent';
$route['recivespcEventDeleteMultiple']  = 'payment/recivespc/cReciveSpc/FSoCReciveSpcDelMultipleEvent';


// Create By Worakorn 04/11/2020
//ReciveSpc
$route['recivespcconfig/(:any)/(:any)']       = 'payment/recivespcconfig/cReciveSpcCfg/FSvCReciveSpcCfgMainPage/$1/$2';
$route['recivespcconfigDataTable']            = 'payment/recivespcconfig/cReciveSpcCfg/FSvCReciveSpcCfgDataList';
$route['recivespcconfigPageAdd']              = 'payment/recivespcconfig/cReciveSpcCfg/FSvCReciveSpcCfgPageAdd';

$route['recivespcconfigEventAdd']             = 'payment/recivespcconfig/cReciveSpcCfg/FSaCReciveSpcCfgAddEvent';
$route['recivespcconfigPageEdit']             = 'payment/recivespcconfig/cReciveSpcCfg/FSvCReciveSpcCfgPageEdit';
$route['recivespcconfigEventEdit']            = 'payment/recivespcconfig/cReciveSpcCfg/FSaCReciveSpcCfgEditEvent';
$route['recivespcconfigEventDelete']          = 'payment/recivespcconfig/cReciveSpcCfg/FSaCReciveSpcCfgDeleteEvent';
$route['recivespcconfigEventDeleteMultiple']  = 'payment/recivespcconfig/cReciveSpcCfg/FSoCReciveSpcCfgDelMultipleEvent';


// ประวัติบัตรเงินสด
// Create By Witsarut 05/01/2020
$route['cardhistory/(:any)/(:any)']       = 'payment/cardhistory/cCardHistory/index/$1/$2';
$route['cardhistorylist']                 = 'payment/cardhistory/cCardHistory/FSvCCRDHISListPage';
$route['cardhistorydatatable']            = 'payment/cardhistory/cCardHistory/FSvCCRDHISDataList';
$route['cardgethisdatatable']             = "payment/cardhistory/cCardHistory/FSvCCRDGetHisDataTable";


// Installment Terms (เงื่อนไขการผ่อนชำระ)
// Create By Napat(Jame) 04/11/2021
$route ['masInstallmentTerms/(:any)/(:any)']  = 'payment/installmentterms/Installmentterms_controller/index/$1/$2';
$route ['masInstallmentTermsList']            = 'payment/installmentterms/Installmentterms_controller/FSvCSTMListPage';
$route ['masInstallmentTermsDataTable']       = 'payment/installmentterms/Installmentterms_controller/FSvCSTMDataList';
$route ['masInstallmentTermsPageAdd']         = 'payment/installmentterms/Installmentterms_controller/FSvCSTMAddPage';
$route ['masInstallmentTermsPageEdit']        = 'payment/installmentterms/Installmentterms_controller/FSvCSTMEditPage';
$route ['masInstallmentTermsEventAdd']        = 'payment/installmentterms/Installmentterms_controller/FSoCSTMAddEvent';
$route ['masInstallmentTermsEventEdit']       = 'payment/installmentterms/Installmentterms_controller/FSoCSTMEditEvent';
$route ['masInstallmentTermsEventDelete']     = 'payment/installmentterms/Installmentterms_controller/FSoCSTMDeleteEvent';
$route ['masInstallmentTermsSubDataTable']    = 'payment/installmentterms/Installmentterms_controller/FSvCSTMSubDataList';
$route ['masInstallmentTermsSubEventAddEdit'] = 'payment/installmentterms/Installmentterms_controller/FSoCSTMSubEventAddEdit';
$route ['masInstallmentTermsSubEventDelete']  = 'payment/installmentterms/Installmentterms_controller/FSoCSTMSubEventDelete';
