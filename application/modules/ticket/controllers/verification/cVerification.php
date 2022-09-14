<?php

defined('BASEPATH') or exit('No direct script access allowed');

class cVerification extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('ticket/verification/mVerification', 'mVerification');
        $this->load->library("session");
    }

    public function FSxCVFN() {
        $oAuthen = FCNaHCheckAlwFunc('EticketVerification');
        $oBank = $this->mVerification->FSxMVFNBankMaster();
        $this->load->view('ticket/verification/wVerification', array(
            'oAuthen' => $oAuthen,
            'oBank' => $oBank,
        ));
    }

    //  FS แสดงข้อมูล Table ในโซน
    public function FSxCVFNAjaxList() {
        $tFTBnkCode = $this->input->post('tFTBnkCode');
        $tFDDate = $this->input->post('tFDDate');
        $tFTShdDocNo = $this->input->post('tFTShdDocNo');
        $nPageNo = $this->input->post('nPageNo');
        $nPageActive = $nPageNo;
        $oRCVM = $this->mVerification->FSxMVFNRCVM();
        $oVFNList = $this->mVerification->FSxCVFNList($tFTBnkCode, FsxDate($tFDDate), $tFTShdDocNo, $oRCVM[0]->FTRcvCode, $nPageActive);
        $oAuthen = FCNaHCheckAlwFunc('EticketVerification');
        $this->load->view('ticket/verification/wVerificationList', array(
            'oAuthen'  => $oAuthen,
            'oVFNList' => $oVFNList,
            'nPageNo'  => $nPageNo
        ));
    }

    public function FSxCVFNCount() {
        $tFTBnkCode = $this->input->post('tFTBnkCode');
        $tFDDate = $this->input->post('tFDDate');
        $tFTShdDocNo = $this->input->post('tFTShdDocNo');
        $oRCVM = $this->mVerification->FSxMVFNRCVM();
        $oVFNCntSh = $this->mVerification->FStMVFNCount($tFTBnkCode, FsxDate($tFDDate), $tFTShdDocNo, $oRCVM[0]->FTRcvCode);
        $tVFNCount = $oVFNCntSh [0]->counts;
        echo $tVFNCount;
    }

    public function FSxCVFNApprove() {
        $aData = array(
            'FTShdDocNo' => $this->input->post('tFTShdDocNo'),
            'FCSrcNet' => $this->input->post('tFCSrcNet'),
        );
        $aOrder = $this->mVerification->FSxMVFNOrder($aData['FTShdDocNo']);
        $this->mVerification->FSxMVFNApprove($aData);
        //Payment/Complete
        $poPaymentInfo = '{
            "ptAgnKeyAPI": "' . $this->config->item('APIAuthKey') . '",
            "ptCstKeyAccess": "' . $this->input->post('tFTCstKeyAccess') . '",
            "ptShdDocNo": "' . $this->input->post('tFTShdDocNo') . '",
            "ptStaPaid": "3",
            "ptComplete4Inform": "1",
            "paoPayRcvInfo": [
              {
                "pnSrcSeqNo": "1",
                "ptRcvCode": "' . $aOrder[0]->FTRcvCode . '",
                "ptSrcRef": "",
                "ptBnkCode": "",
                "ptSrcBnkBch": "xxxx",
                "pdSrcRefDate": "' . date('Y-m-d') . '",
                "pcSrcCardChg": 0,
                "pcSrcFAmt": ' . $aOrder[0]->FCSrcFAmt . ',
                "pcSrcAmt": ' . $aOrder[0]->FCSrcAmt . ',
                "pcSrcNet": ' . $aOrder[0]->FCSrcNet . '
              }
            ]
        }';
        $tPayment = "/API2TKOrder/V1/Payment/Complete";
        FSaCVFNCall($tPayment, 'POST', $poPaymentInfo);

        // send email
        $poData = array(
            'ptTxhDocRef' => $aData['FTShdDocNo'],
            'ptCstKeyAccess' => $this->input->post('tFTCstKeyAccess'),
            'ptEmail' => $this->input->post('tFTCstEmail'),
            'pnSendABB' => '1',
            'pnLang' => '1'
        );
        $oJson = json_encode($poData);
        $tAPIRequest = "/API2TKOrder/V1/Email/Ticket";
        FSaCVFNCall($tAPIRequest, 'POST', $oJson);
    }

    public function FSxCVFNTicketCancellation() {
        $oAuthen = FCNaHCheckAlwFunc('EticketVerification');
        $oRSN = $this->mVerification->FSxMVFNRsn();
        $nPageNo = $this->input->post('nPageNo');
        $this->load->view('ticket/verification/cancel/wTicketCancellation', array(
            'oAuthen' => $oAuthen,
            'oRSN' => $oRSN,
            'nPageNo'  => $nPageNo
        ));
    }

    public function FSxCVFNCancellationCount() {
        $oAuthen = FCNaHCheckAlwFunc('EticketVerification');
        $oRCVM = $this->mVerification->FSxMVFNRCVM();
        $aData = array(
            'FTShdDocNo' => $this->input->post('tFTShdDocNo'),
            'FTRcvCode' => $oRCVM[0]->FTRcvCode,
        );
        $oCnt = $this->mVerification->FStMVFNCancellationCount($aData);
        $oCnt = $oCnt [0]->counts;
        echo $oCnt;
    }


    public function FSxCVFNTicketCancellationAjax() {
        $oRSN = $this->mVerification->FSxMVFNRsn();
        $oAuthen = FCNaHCheckAlwFunc('EticketVerification');
        $oRCVM = $this->mVerification->FSxMVFNRCVM();
        $nPageNo = $this->input->post('nPageNo');
        $nPageActive = $nPageNo;
        $aData = array(
            'FTShdDocNo' => $this->input->post('tFTShdDocNo'),
            'FTRcvCode' => $oRCVM[0]->FTRcvCode
        );
        $oVFNList = $this->mVerification->FSxCVFNCheckTicketCancellation($aData,$nPageActive);
        $this->load->view('ticket/verification/cancel/wTicketCancellationList', array(
            'oAuthen'  => $oAuthen,
            'oVFNList' => $oVFNList,
            'oRSN'     => $oRSN,
            'nPageNo'  =>  $nPageNo
        ));

    }


    //  Functionality : ยกเลิกข้อมูลจองตั๋ว/ส่งเมล์
    //  Parameters : -
    //  Creator : 13/02/2562 (แก้ saharat)
    //  Last Modified : -  
    //  Return : -
    //  Return Type : -
    public function FSxCVFNCancelTicket() {
            if ($this->input->post('tFTShdDocNo')) {
                $ocbListItem  =  $this->input->post('tFTShdDocNo');
                $FTTxhRsnCode = $this->input->post('tFTTxhRsnCode');
                $aCode        = explode(',', $ocbListItem);
                foreach ($aCode as $key => $oValue) {
                $FTSDocNo = $oValue;
                $o = $this->mVerification->FSxMVFNCancelTicket($FTSDocNo,$FTTxhRsnCode);
                $aData = array(
                        'status' => $o,
                    );
                      echo json_encode($aData);
                }
            }
            $aDataUserEmail = $this->mVerification->FSaMVFEmail();
            if (isset($aDataUserEmail)) {
            $tConfig = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.googlemail.com',
                'smtp_port' => 465,
                'smtp_user' => 'adapayadasoft@gmail.com',
                'smtp_pass' => 'AdasoftAdapay',
                'mailtype'  => 'html',
                'charset'   => 'utf-8'
                );
            $this->load->library('email', $tConfig);
            $this->email->set_newline("\r\n");
            
            // Set to, from, message, etc.
            $this->email->from('saharat@ada-soft.com', 'Admin');
            $this->email->to($aDataUserEmail[0] ['FTUsrEmail']);
            $this->email->subject('Test_CancelTicket');
            $this->email->message('<p>'.$ocbListItem.'Test_MessageCancelTicket : '.$aDataUserEmail[0] ['FTUsrName'].'</p>');
            $this->email->send();
            }
        }
    }
?>



