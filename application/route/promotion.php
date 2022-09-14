<?php

//Voucher (วอร์เชอร์)
$route ['voucher/(:any)/(:any)']     = 'promotion/voucher/cVoucher/index/$1/$2';
$route ['voucherFormSearchList']     = 'promotion/voucher/cVoucher/FSxCVOCFormSearchList';
$route ['voucherPageAdd']            = 'promotion/voucher/cVoucher/FSxCVOCAddPage';
$route ['voucherDataTable']          = 'promotion/voucher/cVoucher/FSxCVOCDataTable';
$route ['voucherPageEdit']           = 'promotion/voucher/cVoucher/FSvCVOCEditPage';
$route ['voucherEventAdd']           = 'promotion/voucher/cVoucher/FSaCVOCAddEvent';
$route ['voucherEventEdit']          = 'promotion/voucher/cVoucher/FSaCVOCEditEvent';
$route ['voucherEventDelete']        = 'promotion/voucher/cVoucher/FSaCVOCDeleteEvent';

//type voucher (ประเภทวอร์เชอร)
$route ['vouchertype/(:any)/(:any)']     = 'promotion/vouchertype/cVouchertype/index/$1/$2';
$route ['vouchertypeFormSearchList']     = 'promotion/vouchertype/cVouchertype/FSxCVOCFormSearchList';
$route ['VoucherTypePageAdd']            = 'promotion/vouchertype/cVouchertype/FSxCVOCAddPage';
$route ['vouchertypeDataTable']          = 'promotion/vouchertype/cVouchertype/FSxCVOTDataTable';
$route ['vouchertypePageEdit']           = 'promotion/vouchertype/cVouchertype/FSvCVOTEditPage';
$route ['vouchertypeEventAdd']           = 'promotion/vouchertype/cVouchertype/FSaCVOTAddEvent';
$route ['vouchertypeEventEdit']          = 'promotion/vouchertype/cVouchertype/FSaCVOTEditEvent';
$route ['vouchertypeEventDelete']        = 'promotion/vouchertype/cVouchertype/FSaCVOTDeleteEvent';


//Coupon (คูปอง)
$route ['coupon/(:any)/(:any)']     = 'coupon/coupon/cCoupon/index/$1/$2';
$route ['couponFormSearchList']     = 'coupon/coupon/cCoupon/FSxCCPNFormSearchList';
$route ['couponPageAdd']            = 'coupon/coupon/cCoupon/FSxCCPNAddPage';
$route ['couponDataTable']          = 'coupon/coupon/cCoupon/FSxCCPNDataTable';
$route ['couponPageEdit']           = 'coupon/coupon/cCoupon/FSvCCPNEditPage';
$route ['couponEventAdd']           = 'coupon/coupon/cCoupon/FSaCCPNAddEvent';
$route ['couponEventEdit']          = 'coupon/coupon/cCoupon/FSaCCPNEditEvent';
$route ['couponEventDelete']        = 'coupon/coupon/cCoupon/FSaCCPNDeleteEvent';


//type Coupon (ประเภทคูปอง)
$route ['coupontype/(:any)/(:any)']      = 'coupon/coupontype/cCoupontype/index/$1/$2';
$route ['CoupontypeFormSearchList']      = 'coupon/coupontype/cCoupontype/FSxCCPTFormSearchList';
$route ['CoupontypePageAdd']             = 'coupon/coupontype/cCoupontype/FSxCCPTAddPage';
$route ['CoupontypeDataTable']           = 'coupon/coupontype/cCoupontype/FSxCCPTDataTable';
$route ['CoupontypePageEdit']            = 'coupon/coupontype/cCoupontype/FSvCCPTEditPage';
$route ['CoupontypeEventAdd']            = 'coupon/coupontype/cCoupontype/FSaCCPTAddEvent';
$route ['CoupontypeEventEdit']           = 'coupon/coupontype/cCoupontype/FSaCCPTEditEvent';
$route ['CoupontypeEventDelete']         = 'coupon/coupontype/cCoupontype/FSaCCPTDeleteEvent';


//cardcoupon (คูปองบัตร)
$route ['cardcoupon/(:any)/(:any)']         = 'coupon/cardcoupon/cCardcoupon/index/$1/$2';
$route ['CardCouponPageAdd']                = 'coupon/cardcoupon/cCardcoupon/FSxCCCLAddPage';
$route ['CardCouponEventAdd']               = 'coupon/cardcoupon/cCardcoupon/FSaCCCLAddEvent';
$route ['CardCouponPageEdit']               = 'coupon/cardcoupon/cCardcoupon/FSvCCCLEditPage';
$route ['CardCouponFormSearchList']         = 'coupon/cardcoupon/cCardcoupon/FSxCCCLFormSearchList';
$route ['CardCouponDataTable']              = 'coupon/cardcoupon/cCardcoupon/FSxCCCLDataTable';
$route ['CardCouponEventEdit']              = 'coupon/cardcoupon/cCardcoupon/FSaCCCLEditEvent';
$route ['CardCouponEventDelete']            = 'coupon/cardcoupon/cCardcoupon/FSaCCCLDeleteEvent';



