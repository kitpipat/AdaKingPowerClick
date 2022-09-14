
<?php

    //Courier
    $route ['courier/(:any)/(:any)']        = 'courier/courier/cCourier/index/$1/$2';
    $route ['courierList']                  = 'courier/courier/cCourier/FSvCCRYListPage';
    $route ['courierDataTable']             = 'courier/courier/cCourier/FSvCCRYDataList';
    $route ['courierPageAdd']               = 'courier/courier/cCourier/FSvCCRYAddPage';
    $route ['courierPageEdit']              = 'courier/courier/cCourier/FSvCCRYEditPage';
    $route ['courierEventAdd']              = 'courier/courier/cCourier/FSoCCRYAddEvent';
    $route ['courierEventEdit']             = 'courier/courier/cCourier/FSoCCRYEditEvent';
    $route ['courierEventDelete']           = 'courier/courier/cCourier/FSoCCRYDeleteEvent';

    // //Courier Address
    $route ['courierAddressData']           = 'courier/courier/cCourierAddress/FSvCCRYAddressData';
    $route ['courierAddressDataTable']      = 'courier/courier/cCourierAddress/FSvCCRYAddressDataTable';
    $route ['courierAddressPageAdd']        = 'courier/courier/cCourierAddress/FSvCCRYAddressCallPageAdd';
    $route ['courierAddressPageEdit']       = 'courier/courier/cCourierAddress/FSvCCRYAddressCallPageEdit';
    $route ['courierAddressAddEvent']       = 'courier/courier/cCourierAddress/FSoCCRYAddressAddEvent';
    $route ['courierAddressEditEvent']      = 'courier/courier/cCourierAddress/FSoCCRYAddressEditEvent';
    $route ['courierAddressDeleteEvent']    = 'courier/courier/cCourierAddress/FSoCCRYAddressDeleteEvent';

    //CourierGrp
    $route ['courierGrp/(:any)/(:any)']     = 'courier/couriergrp/cCourierGrp/index/$1/$2';
    $route ['courierGrpList']               = 'courier/couriergrp/cCourierGrp/FSvCCGPListPage';
    $route ['courierGrpDataTable']          = 'courier/couriergrp/cCourierGrp/FSvCCGPDataList';
    $route ['courierGrpPageAdd']            = 'courier/couriergrp/cCourierGrp/FSvCCGPAddPage';
    $route ['courierGrpPageEdit']           = 'courier/couriergrp/cCourierGrp/FSvCCGPEditPage';
    $route ['courierGrpEventAdd']           = 'courier/couriergrp/cCourierGrp/FSoCCGPAddEvent';
    $route ['courierGrpEventEdit']          = 'courier/couriergrp/cCourierGrp/FSoCCGPEditEvent';
    $route ['courierGrpEventDelete']        = 'courier/couriergrp/cCourierGrp/FSoCCGPDeleteEvent';


    //CourierType
    $route ['courierType/(:any)/(:any)']     = 'courier/couriertype/cCourierType/index/$1/$2';
    $route ['courierTypeList']               = 'courier/couriertype/cCourierType/FSvCCTYListPage';
    $route ['courierTypeDataTable']          = 'courier/couriertype/cCourierType/FSvCCTYDataList';
    $route ['courierTypePageAdd']            = 'courier/couriertype/cCourierType/FSvCCTYAddPage';
    $route ['courierTypePageEdit']           = 'courier/couriertype/cCourierType/FSvCCTYEditPage';
    $route ['courierTypeEventAdd']           = 'courier/couriertype/cCourierType/FSoCCTYAddEvent';
    $route ['courierTypeEventEdit']          = 'courier/couriertype/cCourierType/FSoCCTYEditEvent';
    $route ['courierTypeEventDelete']        = 'courier/couriertype/cCourierType/FSoCCTYDeleteEvent';

    //CourierMan
    $route ['courierMan/(:any)/(:any)']      = 'courier/courierman/cCourierMan/index/$1/$2';
    $route ['courierManList']                = 'courier/courierman/cCourierMan/FSvCCurmanListPage';
    $route ['courierManDataTable']           = 'courier/courierman/cCourierMan/FSvCCurmanDataList';
    $route ['courierManPageAdd']             = 'courier/courierman/cCourierMan/FSvCCurAddPage';
    $route ['courierManEventAdd']            = 'courier/courierman/cCourierMan/FSoCCurAddEvent';
    $route ['courierManPageEdit']            = 'courier/courierman/cCourierMan/FSvCCurEditPage';
    $route ['courierManEventEdit']           = 'courier/courierman/cCourierMan/FSoCCurEditEvent';
    $route ['courierManEventDelete']        = 'courier/courierman/cCourierMan/FSoCCurDeleteEvent';
    $route ['courierManCheckTelDup']        = 'courier/courierman/cCourierMan/FSoCCheckDuplicateTel';

    //Courier Login
    $route ['courierlogin']                 = 'courier/courierlogin/cCourierlogin/FSvCCourierloginMainPage';
    $route ['courierloginDataTable']        = 'courier/courierlogin/cCourierlogin/FSvCCURLogDataList';
    $route ['courierloginPageAdd']          = 'courier/courierlogin/cCourierlogin/FSvCCURlogPageAdd';
    $route ['courierloginEventAdd']         = 'courier/courierlogin/cCourierlogin/FSaCCURlogAddEvent';
    $route ['courierloginPageEdit']         = 'courier/courierlogin/cCourierlogin/FSvCCURlogPageEdit';
    $route ['courierloginEventEdit']        = 'courier/courierlogin/cCourierlogin/FSaCCURlogEditEvent';
    $route ['courierloginEventDelete']      = 'courier/courierlogin/cCourierlogin/FSaCCURlogDeleteEvent';
    $route ['courierloginEventDeleteMultiple']  = 'courier/courierlogin/cCourierlogin/FSoCCURLogDelMultipleEvent';
    
    //Validate
    $route ['courierloginCheckInputGenCode']    = 'courier/courierlogin/cCourierlogin/FSaMCURCheckDuplicate';