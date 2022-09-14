<?php

use MongoDB\Exception\Exception;

defined('BASEPATH') or exit('No direct script access allowed');

class cBookingLocker extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('sale/bookinglocker/mBookingLocker');
    }

    public function index($nBKLBrowseType,$tBKLBrowseOption) {
        $aDataConfigView    = [
            'nBKLBrowseType'    => $nBKLBrowseType,
            'tBKLBrowseOption'  => $tBKLBrowseOption,
            'aAlwEventBKL'      => FCNaHCheckAlwFunc('salBookingLocker/0/0'),
            'vBtnSave'          => FCNaHBtnSaveActiveHTML('salBookingLocker/0/0'),
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
        ];
        $this->load->view('sale/bookinglocker/wBookingLocker',$aDataConfigView);
    }

    // Functionality: Function Call Page Booking Locker Main
    // Parameters: Ajax and Function Parameter
    // Creator: 29/10/2019 wasin(Yoshi)
    // Return: String View
    // ReturnType: View
    public function FSvCBKLCallPageMain(){
        $aDataConfigView    =  [
            'aAlwEventBKL'      => FCNaHCheckAlwFunc('salBookingLocker/0/0'),
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave()
        ];
        $this->load->view('sale/bookinglocker/wBookingLockerMain',$aDataConfigView);
    }

    // Functionality:  Get Data View Rack
    // Parameters: Ajax and Function Parameter
    // Creator: 31/10/2019 Wasin(Yoshi)
    // Return: String View
    // ReturnType: View
    public function FSvCBKLGetViewRack(){
        $nLangEdit  = $this->session->userdata("tLangEdit");

        // Check Time Booking Expire Back Office
        $aConfigBookingOnlineExp    = $this->mBookingLocker->FSaMBKLGetSysConfigBookingOnlineExpire();
        if(isset($aConfigBookingOnlineExp) && !empty($aConfigBookingOnlineExp)){
            if(isset($aConfigBookingOnlineExp['FTSysStaUsrValue']) && !empty($aConfigBookingOnlineExp['FTSysStaUsrValue'])){
                $tTimeBookingOlExpire   = $aConfigBookingOnlineExp['FTSysStaUsrValue'];
            }else{
                $tTimeBookingOlExpire   = $aConfigBookingOnlineExp['FTSysStaDefValue'];
            }
        }else{
            $tTimeBookingOlExpire = 180;
        }

        // Check Time Booking Expire Smart Locker
        $aConfigBookingOfflineExp   = $this->mBookingLocker->FSaMBKLGetSysConfigBookingOfflineExpire();
        if(isset($aConfigBookingOfflineExp) && !empty($aConfigBookingOfflineExp)){
            if(isset($aConfigBookingOfflineExp['FTSysStaUsrValue']) && !empty($aConfigBookingOfflineExp['FTSysStaUsrValue'])){
                $tTimeBookingOfExpire = $aConfigBookingOfflineExp['FTSysStaUsrValue'];
            }else{
                $tTimeBookingOfExpire = $aConfigBookingOfflineExp['FTSysStaDefValue'];
            }
        }else{
            $tTimeBookingOfExpire = 5;
        }

        $aDataFilter    = [
            'FTBchCode'         => $this->input->post('oetBKLBchCode'),
            'FTShpCode'         => $this->input->post('oetBKLShpCode'),
            'FTPosCode'         => $this->input->post('oetBKLPosCode'),
            'FTRakCode'         => $this->input->post('oetBKLRakCode'),
            'FNTimeExpOnline'   => $tTimeBookingOlExpire,
            'FNTimeExpOffline'  => $tTimeBookingOfExpire,
            'FNLngID'           => $nLangEdit,
        ];
        $aResultData        = $this->mBookingLocker->FSaMBKLGetDetailDataRack($aDataFilter);
        $aDataConfigView    = [
            'aResultData'   => $aResultData
        ];
        // Return Data View
        $this->load->view('sale/bookinglocker/wBookingLockerViewStatus',$aDataConfigView);
    }

    // Functionality:  Call Page Modal Add Booking
    // Parameters: Ajax and Function Parameter
    // Creator: 01/11/2019 Wasin(Yoshi)
    // Return: String View
    // ReturnType: View
    public function FSvCBKLGetViewBooking(){
        $nStaEventCallPage  = $this->input->post('oetBKLDataStaPageEvent');
        $nLangEdit          = $this->session->userdata("tLangEdit");

        // Check Time Booking Expire Back Office
        $aConfigBookingOnlineExp    = $this->mBookingLocker->FSaMBKLGetSysConfigBookingOnlineExpire();
        if(isset($aConfigBookingOnlineExp) && !empty($aConfigBookingOnlineExp)){
            if(isset($aConfigBookingOnlineExp['FTSysStaUsrValue']) && !empty($aConfigBookingOnlineExp['FTSysStaUsrValue'])){
                $tTimeBookingOlExpire   = $aConfigBookingOnlineExp['FTSysStaUsrValue'];
            }else{
                $tTimeBookingOlExpire   = $aConfigBookingOnlineExp['FTSysStaDefValue'];
            }
        }else{
            $tTimeBookingOlExpire = 180;
        }

        // Check Time Booking Expire Smart Locker
        $aConfigBookingOfflineExp   = $this->mBookingLocker->FSaMBKLGetSysConfigBookingOfflineExpire();
        if(isset($aConfigBookingOfflineExp) && !empty($aConfigBookingOfflineExp)){
            if(isset($aConfigBookingOfflineExp['FTSysStaUsrValue']) && !empty($aConfigBookingOfflineExp['FTSysStaUsrValue'])){
                $tTimeBookingOfExpire = $aConfigBookingOfflineExp['FTSysStaUsrValue'];
            }else{
                $tTimeBookingOfExpire = $aConfigBookingOfflineExp['FTSysStaDefValue'];
            }
        }else{
            $tTimeBookingOfExpire = 5;
        }
        
        $aDataFilter        = [
            'FTBchCode'         => $this->input->post('oetBKLBchCode'),
            'FTShpCode'         => $this->input->post('oetBKLShpCode'),
            'FTPosCode'         => $this->input->post('oetBKLPosCode'),
            'FTRakCode'         => $this->input->post('oetBKLRakCode'),
            'FNLayNo'           => $this->input->post('oetBKLDataLayNoSelect'),
            'FNTimeExpOnline'   => $tTimeBookingOlExpire,
            'FNTimeExpOffline'  => $tTimeBookingOfExpire,
            'FNLngID'           => $nLangEdit,
        ];
        $aDataModaDetail    = $this->mBookingLocker->FSaMBKLGetDataDetailLayOut($aDataFilter);
        $aDataConfigView    = [
            'nStaEventCallPage' => $nStaEventCallPage,
            'aDataModaDetail'   => $aDataModaDetail,
        ];
        $this->load->view('sale/bookinglocker/wBookingLockerModalDetail',$aDataConfigView);
    }

    // Functionality:  Confirm Booking Locker
    // Parameters: Ajax and Function Parameter
    // Creator: 04/11/2019 Wasin(Yoshi)
    // Return: Object Status Send Rabbit MQ Confirm Booking Locker
    // ReturnType: Object
    public function FSoCBKLConfirmBookingLocker(){
        try{
            $tBookingRequestName    = "RT_QREQBooking".$this->input->post('ohdBKLModalPosCode');
            $tBookingResponseName   = "RT_QRETBooking".$this->input->post('ohdBKLModalPosCode').$this->input->post('ohdBKLModalLayNo').$this->input->post('oetBKLBkgRefCstLogin');
            $tBookingConfirmParams  = [
                'ptFunction'    => 'Booking',
                'ptSource'      => 'AdaStoreBack',
                'ptDest'        => 'AdaSmartLocker',
                'ptData'        => [
                    'ptFNBkgToLayNo'        => $this->input->post('ohdBKLModalLayNo'),
                    'ptFTBkgToSize'         => $this->input->post('ohdBKLModalPzeCode'),
                    'ptFTBkgToRate'         => $this->input->post('oetBKLRthCode'),
                    'ptFTBkgRefCst'         => $this->input->post('oetBKLBkgRefCst'),
                    'ptFTBkgRefCstLogin'    => $this->input->post('oetBKLBkgRefCstLogin'),
                    'ptFTBkgRefCstDoc'      => $this->input->post('oetBKLBkgRefCstDoc'),
                ]
            ];
            FCNxHConfirmEventBookingLocker([
                'ptQueuesName'  => $tBookingRequestName,
                'paParams'      => $tBookingConfirmParams,
            ]);
            $aDataRetrun    = [
                'ptStatusSendMQ'    => 1,
                'ptTextResponse'    => 'Success Send Rabbit MQ',
                'paDataSubScribe'   => [
                    'tTitleModalResponse'   => language('sale/bookinglocker/bookinglocker','tBKLResponseBookingLockerTitle'),
                    'tLabelModalResponse'   => language('sale/bookinglocker/bookinglocker','tBKLResponseBookingLockerLable'),
                    'tSubScribeQueues'      => $tBookingResponseName
                ]
            ];
        }catch(Exception $Error){
            $aDataRetrun    = [
                'ptStatusSendMQ' => 500,
                'ptTextResponse' => 'Error Cannot Send Rabbit MQ',
            ];
        }
        echo json_encode($aDataRetrun);
    }

    // Functionality:  Cancel Booking Locker
    // Parameters: Ajax and Function Parameter
    // Creator: 04/11/2019 Wasin(Yoshi)
    // Return: Object Status Send Rabbit MQ Confirm Booking Locker
    // ReturnType: Object
    public function FSoCBKLCancelBookingLocker(){
        try{
            $tBookingRequestName    = "RT_QREQBooking".$this->input->post('ohdBKLModalPosCode');
            $tBookingResponseName   = "RT_QRETBooking".$this->input->post('ohdBKLModalPosCode').$this->input->post('ohdBKLModalLayNo').$this->input->post('oetBKLBkgRefCstLogin');
            $tBookingCancelParams   = [
                'ptFunction'    => 'Cancel',
                'ptSource'      => 'AdaStoreBack',
                'ptDest'        => 'AdaSmartLocker',
                'ptData'        => [
                    'ptFNBkgToLayNo'        => $this->input->post('ohdBKLModalLayNo'),
                    'ptFTBkgRefCstLogin'    => $this->input->post('oetBKLBkgRefCstLogin'),
                ]
            ];
            FCNxHConfirmEventBookingLocker([
                'ptQueuesName'  => $tBookingRequestName,
                'paParams'      => $tBookingCancelParams,
            ]);
            $aDataRetrun    = [
                'ptStatusSendMQ'    => 1,
                'ptTextResponse'    => 'Success Send Cancel Booking Rabbit MQ',
                'paDataSubScribe'   => [
                    'tTitleModalResponse'   => language('sale/bookinglocker/bookinglocker','tBKLResponseBookingLockerTitle'),
                    'tLabelModalResponse'   => language('sale/bookinglocker/bookinglocker','tBKLResponseCancelLockerLable'),
                    'tSubScribeQueues'      => $tBookingResponseName
                ]
            ];
        }catch(Exception $Error){
            $aDataRetrun    = [
                'ptStatusSendMQ' => 500,
                'ptTextResponse' => 'Error Cannot Cancel Booking Rabbit MQ !!!',
            ];
        }
        echo json_encode($aDataRetrun);
    }

    // Functionality:  Delete Queues Booking
    // Parameters: Ajax and Function Parameter
    // Creator: 04/11/2019 Wasin(Yoshi)
    // Return: Delete Queues
    // ReturnType: None
    public function FSoCBKLDeleteQueue(){
        try{
            $aBKLQueuesData = ['ptQueuesName' => $this->input->post('ptQueuesName')];
            FCNxHConfirmEventDeleteBookingLocker($aBKLQueuesData);
            $aResponseReturn    = [
                'tStatus'   => '1',
                'tMessage'  => 'Delete MQ Booking Locker Sucess.'
            ];
        }catch(Exception $Error){
            $aResponseReturn    = [
                'tStatus'   => '500',
                'tMessage'  => 'Error Delete MQ Booking Locker.'
            ];
        }
        echo json_encode($aResponseReturn);
    }



}