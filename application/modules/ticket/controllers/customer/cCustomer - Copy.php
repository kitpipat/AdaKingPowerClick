<?php

defined('BASEPATH') or exit('No direct script access allowed');

class cCustomer extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ticket/customer/mCustomer', 'mCustomer');
        $this->load->model('ticket/user/mUser', 'mUser');
        $this->load->library("session");
        $this->load->library('password/PasswordStorage');
    }

    public function FSxCCST() {
        $oAuthen = FCNaHCheckAlwFunc('EticketCustomer');
        $this->load->view('ticket/customer/wCustomer', array(
            'oAuthen' => $oAuthen
        ));
    }

    public function FSxCCSTAjaxList() {
        $oAuthen = FCNaHCheckAlwFunc('EticketCustomer');
        $tCstName = $this->input->post('tCstName');

        $tCardID = $this->input->post('tCardID');
        $tPhone = $this->input->post('tPhone');

        $nPageNo = $this->input->post('nPageNo');
        $nPageActive = $nPageNo;
        $oCstList = $this->mCustomer->FSxMCSTList($tCstName, $tCardID, $tPhone, $nPageActive);
        $this->load->view('ticket/customer/wCustomerList', array(
            'oAuthen' => $oAuthen,
            'oCstList' => $oCstList,
            'nPageNo'  => $nPageNo
        ));
    }

    public function FStCCSTCount() {
        $tCstName = $this->input->post('tCstName');
        $tCardID = $this->input->post('tCardID');
        $tPhone = $this->input->post('tPhone');
        $oCstCnt = $this->mCustomer->FStMCSTCount($tCstName, $tCardID, $tPhone);
        $oCstCount = $oCstCnt [0]->counts;
        echo $oCstCount;
    }

    public function FSxCCSTDelete() {
        if ($this->input->post('nFNCstID')) {
            $ocbListItem = $this->input->post('nFNCstID');
            $aCode = explode(',', $ocbListItem);
            foreach ($aCode as $key => $oValue) {
                $nFNCstID = $oValue;
                FSaDelImg($nFNCstID, 'TTKMImgPerson', 1, 'main', 'customer');
                $o = $this->mCustomer->FSxMCSTDel($nFNCstID);
                $aData = array(
                    'status' => $o,
                    'msg' => language('ticket/center/center', 'CheckDel')
                );
                echo json_encode($aData);
            }
        }
    }

    public function FSxCCSTAdd() {
        $oGrp = $this->mCustomer->FSxMCSTGRP();
        $oTye = $this->mCustomer->FSxMCSTTYPE();
        $this->load->view('eticket/customer/wAdd', array(
            'oTye' => $oTye,
            'oGrp' => $oGrp
        ));
    }

    public function FSxCCSTDelImg() {
        if ($this->input->post('tImgID')) {
            $ptNameImg = $this->input->post('tNameImg');
            $ptImgID = $this->input->post('tImgID');
            FSaHDelImgObj($ptImgID, 'TTKMImgPerson', $ptNameImg);
        }
    }

    public function FSxCCSTAddAjax() {
        if ($this->input->post('oetFTCstName')) {
            $tPwd = explode('6:', PasswordStorage::create_hash(trim($this->input->post('opwFTCstPwd'))));
            $aData = array(
                'FTCstName' => $this->input->post('oetFTCstName'),
                'FTCstCardID' => $this->input->post('oetFTCstCardID'),
                'FTCstTel' => $this->input->post('oetFTCstTel'),
                'FTCstFax' => $this->input->post('oetFTCstFax'),
                'FTCstMo' => $this->input->post('oetFTCstMo'),
                'FTCstEmail' => $this->input->post('oetFTCstEmail'),
                'FTCstPwd' => $tPwd[1],
                'FTCstTaxNo' => $this->input->post('oetFTCstTaxNo'),
                'FDCstDob' => ($this->input->post('oetFDCstDob') == "" ? NULL : $this->input->post('oetFDCstDob')),
                'FTCstCareer' => $this->input->post('oetFTCstCareer'),
                'FTCstCrdNo' => $this->input->post('oetFTCstCrdNo'),
                'FDCstApply' => date('Y-m-d'),
                'FDCstCrdIssue' => date('Y-m-d'),
                'FDCstCrdExpire' => ($this->input->post('oetFDCstCrdExpire') == "" ? NULL : $this->input->post('oetFDCstCrdExpire')),
                'FTCstSex' => $this->input->post('ocmFTCstSex'),
                'FTCstStaLocal' => $this->input->post('ocmFTCstStaLocal'),
                'FTCstBusiness' => $this->input->post('ocmFTCstBusiness'),
                'FTCstStaAge' => $this->input->post('ocmFTCstStaAge'),
                'FTCstStaActive' => $this->input->post('ocmFTCstStaActive'),
                'FNCtyID' => $this->input->post('ocmFNCtyID'),
                'FNCgpID' => $this->input->post('ocmFNCgpID')
            );
            
            $tCheckEmail = $this->mCustomer->FSxMCSTCheckEmail($aData['FTCstEmail']);            
            if ($tCheckEmail == 'true') {
                $nCstID = $this->mCustomer->FSxMCSTAdd($aData);
                if ($this->input->post('ohdCstImg')) {
                    $tImg = $this->input->post('ohdCstImg');
                    FSaHAddImgObj($nCstID, 1, 'TTKMImgPerson', 1, 'main', $tImg, 'customer');
                }
                $this->load->library('email');
                $this->email->initialize(array(
                    'protocol' => $this->config->item('protocol'),
                    'smtp_host' => $this->config->item('smtp_host'),
                    'smtp_user' => $this->config->item('smtp_user'),
                    'smtp_pass' => $this->config->item('smtp_pass'),
                    'smtp_port' => $this->config->item('smtp_port'),
                    'crlf' => "\r\n",
                    'newline' => "\r\n"
                ));
                $this->email->from($this->config->item('smtp_user'), language('eticket/about', 'tAboutuser') . '');
                $this->email->to($this->input->post('oetFTCstEmail'));
                $this->email->subject(language('eticket/about', 'tAboutuser') . '');
                $message = '<!DOCTYPE html>
                    <html>
                    <head>
                    <meta name="viewport" content="width=device-width" />
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <title>' . language('eticket/about', 'tAboutuser') . '</title>
                    <style>
                    hr { border: 0; height: 1px; margin-top: 10px; margin-bottom: 10px; background-image: -webkit-linear-gradient(left, transparent, rgba(0, 0, 0, 0.2), transparent); background-image: -moz-linear-gradient(left, transparent, rgba(0, 0, 0, 0.2), transparent); background-image: -ms-linear-gradient(left, transparent, rgba(0, 0, 0, 0.2), transparent); background-image: -o-linear-gradient(left, transparent, rgba(0, 0, 0, 0.2), transparent); background-image: linear-gradient(left, transparent, rgba(0, 0, 0, 0.2), transparent); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#d6d6d6\', endColorstr=\'#d6d6d6\', GradientType=0); }img { border: none; -ms-interpolation-mode: bicubic; max-width: 100%; } body { background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; } table { border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; } table td { font-family: sans-serif; font-size: 14px; vertical-align: top; } .body { background-color: #f6f6f6; width: 100%; } .container { display: block; Margin: 0 auto !important; max-width: 580px; padding: 10px; width: 580px; } .content { box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; } .main { background: #ffffff; border-radius: 3px; width: 100%; } .wrapper { box-sizing: border-box; padding: 20px; } .content-block { padding-bottom: 10px; padding-top: 10px; } .footer { clear: both; Margin-top: 10px; text-align: center; width: 100%; } .footer td, .footer p, .footer span, .footer a { color: #999999; font-size: 12px; text-align: center; } p, ul, ol { font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px; } p li, ul li, ol li { list-style-position: inside; margin-left: 5px; } a { color: #3498db; text-decoration: underline; } .btn { box-sizing: border-box; width: 100%; } .btn > tbody > tr > td { padding-bottom: 15px; } .btn table { width: auto; } .btn table td { background-color: #ffffff; border-radius: 5px; text-align: center; } .btn a { background-color: #ffffff; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; color: #3498db; cursor: pointer; display: inline-block; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-decoration: none; text-transform: capitalize; } .btn-primary table td { background-color: #3498db; } .btn-primary a { background-color: #3498db; border-color: #3498db; color: #ffffff; } .last { margin-bottom: 0; } .first { margin-top: 0; } .align-center { text-align: center; } .align-right { text-align: right; } .align-left { text-align: left; } .clear { clear: both; } .mt0 { margin-top: 0; } .mb0 { margin-bottom: 0; } .preheader { color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0; } .powered-by a { text-decoration: none; }
                    </style>
                    </head>
                    <body class="">
                    <table border="0" cellpadding="0" cellspacing="0" class="body">
                    <tr>
                    <td>&nbsp;</td>
                    <td class="container">
                    <div class="content">
                    <span class="preheader">This is preheader text. Some clients will show this text as a preview.</span>
                    <table class="main">
                    <tr>
                    <td class="wrapper">
                    <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                    <td>
                    <p>' . language('eticket/about', 'tHi') . ' ' . $this->input->post('oetFTCstName') . ',</p>
                    <hr>
                    <p>' . language('eticket/about', 'tName') . ' : ' . $this->input->post('oetFTCstName') . '</p>
                    <p>' . language('eticket/about', 'tEmail') . ' : ' . $this->input->post('oetFTCstEmail') . '</p>
                    <p>' . language('eticket/about', 'tPassword') . ' : ' . $this->input->post('opwFTCstPwd') . '</p>
                    <p>' . language('eticket/about', 'tTelephoneNumber') . ' : ' . $this->input->post('oetFTCstTel') . '</p>
                    </td>
                    </tr>
                    </table>
                    </td>
                    </tr>
                    </table>
                    <div class="footer">
                    <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                    <td class="content-block">
                    <span class="apple-link">Copyright © ' . date('Y') . '</span>
                    </td>
                    </tr>
                    </table>
                    </div>
                    </div>
                    </td>
                    <td>&nbsp;</td>
                    </tr>
                    </table>
                    </body>
                    </html>';
                $this->email->message($message);
                $this->email->send();
                echo $nCstID;
            }
        }
    }

    public function FSxCCSTEdit($nCstID) {
        $oGrp = $this->mCustomer->FSxMCSTGRP();
        $oTye = $this->mCustomer->FSxMCSTTYPE();
        $oCSTShow = $this->mCustomer->FSxMCSTShow($nCstID);
        $this->load->view('eticket/customer/wEdit', array(
            'oTye' => $oTye,
            'oCSTShow' => $oCSTShow,
            'oGrp' => $oGrp
        ));
    }

    public function FSxCCSTEditAjax() {
        if ($this->input->post('ohdFNCstID')) {
            $aData = array(
                'FNCstID' => $this->input->post('ohdFNCstID'),
                'FTCstName' => $this->input->post('oetFTCstName'),
                'FTCstCardID' => $this->input->post('oetFTCstCardID'),
                'FTCstTel' => $this->input->post('oetFTCstTel'),
                'FTCstFax' => $this->input->post('oetFTCstFax'),
                'FTCstMo' => $this->input->post('oetFTCstMo'),
                'FTCstEmail' => $this->input->post('oetFTCstEmail'),
                'FTCstTaxNo' => $this->input->post('oetFTCstTaxNo'),
                'FDCstDob' => ($this->input->post('oetFDCstDob') == "" ? NULL : $this->input->post('oetFDCstDob')),
                'FTCstCareer' => $this->input->post('oetFTCstCareer'),
                'FTCstCrdNo' => $this->input->post('oetFTCstCrdNo'),
                'FDCstCrdExpire' => ($this->input->post('oetFDCstCrdExpire') == "" ? NULL : $this->input->post('oetFDCstCrdExpire')),
                'FTCstSex' => $this->input->post('ocmFTCstSex'),
                'FTCstStaLocal' => $this->input->post('ocmFTCstStaLocal'),
                'FTCstBusiness' => $this->input->post('ocmFTCstBusiness'),
                'FTCstStaAge' => $this->input->post('ocmFTCstStaAge'),
                'FTCstStaActive' => $this->input->post('ocmFTCstStaActive'),
                'FNCtyID' => $this->input->post('ocmFNCtyID'),
                'FNCgpID' => $this->input->post('ocmFNCgpID')
            );
            $this->mCustomer->FSxMCSTEdit($aData);
            if ($this->input->post('opwFTCstPwd') != '!@#$%&*') {
                $tPwd = explode('6:', PasswordStorage::create_hash(trim($this->input->post('opwFTCstPwd'))));
                $aPwd = array(
                    'FTCstPwd' => $tPwd[1],
                    'FNCstID' => $this->input->post('ohdFNCstID')
                );
                $this->mCustomer->FSxMCSTEditPwd($aPwd);
            }

            if ($this->input->post('ohdCstImg')) {
                $tImg = $this->input->post('ohdCstImg');
                FSaHUpdateImgObj($aData['FNCstID'], 'TTKMImgPerson', 1, 'main', $tImg, 'customer');
            }

            $this->load->library('email');
            $this->email->initialize(array(
                'protocol' => $this->config->item('protocol'),
                'smtp_host' => $this->config->item('smtp_host'),
                'smtp_user' => $this->config->item('smtp_user'),
                'smtp_pass' => $this->config->item('smtp_pass'),
                'smtp_port' => $this->config->item('smtp_port'),
                'crlf' => "\r\n",
                'newline' => "\r\n"
            ));
            $this->email->from($this->config->item('smtp_user'), language('eticket/about', 'tAboutuser') . '');
            $this->email->to($this->input->post('oetFTCstEmail'));
            $this->email->subject(language('eticket/about', 'tAboutuser') . '');
            $message = '<!DOCTYPE html>
              <html>
              <head>
              <meta name="viewport" content="width=device-width" />
              <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
              <title>' . language('eticket/about', 'tAboutuser') . '</title>
              <style>
              hr { border: 0; height: 1px; margin-top: 10px; margin-bottom: 10px; background-image: -webkit-linear-gradient(left, transparent, rgba(0, 0, 0, 0.2), transparent); background-image: -moz-linear-gradient(left, transparent, rgba(0, 0, 0, 0.2), transparent); background-image: -ms-linear-gradient(left, transparent, rgba(0, 0, 0, 0.2), transparent); background-image: -o-linear-gradient(left, transparent, rgba(0, 0, 0, 0.2), transparent); background-image: linear-gradient(left, transparent, rgba(0, 0, 0, 0.2), transparent); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#d6d6d6\', endColorstr=\'#d6d6d6\', GradientType=0); }img { border: none; -ms-interpolation-mode: bicubic; max-width: 100%; } body { background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; } table { border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; } table td { font-family: sans-serif; font-size: 14px; vertical-align: top; } .body { background-color: #f6f6f6; width: 100%; } .container { display: block; Margin: 0 auto !important; max-width: 580px; padding: 10px; width: 580px; } .content { box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; } .main { background: #ffffff; border-radius: 3px; width: 100%; } .wrapper { box-sizing: border-box; padding: 20px; } .content-block { padding-bottom: 10px; padding-top: 10px; } .footer { clear: both; Margin-top: 10px; text-align: center; width: 100%; } .footer td, .footer p, .footer span, .footer a { color: #999999; font-size: 12px; text-align: center; } p, ul, ol { font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px; } p li, ul li, ol li { list-style-position: inside; margin-left: 5px; } a { color: #3498db; text-decoration: underline; } .btn { box-sizing: border-box; width: 100%; } .btn > tbody > tr > td { padding-bottom: 15px; } .btn table { width: auto; } .btn table td { background-color: #ffffff; border-radius: 5px; text-align: center; } .btn a { background-color: #ffffff; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; color: #3498db; cursor: pointer; display: inline-block; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-decoration: none; text-transform: capitalize; } .btn-primary table td { background-color: #3498db; } .btn-primary a { background-color: #3498db; border-color: #3498db; color: #ffffff; } .last { margin-bottom: 0; } .first { margin-top: 0; } .align-center { text-align: center; } .align-right { text-align: right; } .align-left { text-align: left; } .clear { clear: both; } .mt0 { margin-top: 0; } .mb0 { margin-bottom: 0; } .preheader { color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0; } .powered-by a { text-decoration: none; }
              </style>
              </head>
              <body class="">
              <table border="0" cellpadding="0" cellspacing="0" class="body">
              <tr>
              <td>&nbsp;</td>
              <td class="container">
              <div class="content">
              <span class="preheader">This is preheader text. Some clients will show this text as a preview.</span>
              <table class="main">
              <tr>
              <td class="wrapper">
              <table border="0" cellpadding="0" cellspacing="0">
              <tr>
              <td>
              <p>' . language('eticket/about', 'tHi') . ' ' . $this->input->post('oetFTCstName') . ',</p>
              <hr>
              <p>' . language('eticket/about', 'tName') . ' : ' . $this->input->post('oetFTCstName') . '</p>
              <p>' . language('eticket/about', 'tEmail') . ' : ' . $this->input->post('oetFTCstEmail') . '</p>
              <p>' . language('eticket/about', 'tPassword') . ' : ' . ($this->input->post('opwFTCstPwd') != '!@#$%&*' ? $this->input->post('opwFTCstPwd') : "-") . '</p>
              <p>' . language('eticket/about', 'tTelephoneNumber') . ' : ' . $this->input->post('oetFTCstTel') . '</p>
              </td>
              </tr>
              </table>
              </td>
              </tr>
              </table>
              <div class="footer">
              <table border="0" cellpadding="0" cellspacing="0">
              <tr>
              <td class="content-block">
              <span class="apple-link">Copyright © ' . date('Y') . '</span>
              </td>
              </tr>
              </table>
              </div>
              </div>
              </td>
              <td>&nbsp;</td>
              </tr>
              </table>
              </body>
              </html>';
            $this->email->message($message);
            $this->email->send();
        }
    }

    public function FSxCCSTCheckEmail() {
        if ($this->input->post('email')) {
            $tEmail = $this->input->post('email');
            $tCheckEmail = $this->mCustomer->FSxMCSTCheckEmail($tEmail);
            echo $tCheckEmail;
        }
    }

    /**
     * ** ประเภทลูกค้า ***
     */
    public function FSxCCSTCategory() {
        $oAuthen = FCNaHCheckAlwFunc('EticketCustomer/category');
        $this->load->view('eticket/customer/category/wCategory', array(
            'oAuthen' => $oAuthen
        ));
    }

    public function FSxCCSTCategoryAjaxList() {
        $oAuthen = FCNaHCheckAlwFunc('EticketCustomer/category');
        $tFTCtyName = $this->input->post('tFTCtyName');
        $nPageNo = $this->input->post('nPageNo');
        $nPageActive = $nPageNo;
        $oCstTyList = $this->mCustomer->FSxMCSTCategoryAjaxList($tFTCtyName, $nPageActive);
        $this->load->view('eticket/customer/category/wCategoryList', array(
            'oAuthen' => $oAuthen,
            'oCstTyList' => $oCstTyList,
            'nPageNo' => $nPageNo
        ));
    }

    public function FSxCCSTCategoryCount() {
        $tFTCtyName = $this->input->post('tFTCtyName');
        $oCstCnt = $this->mCustomer->FStMCSTCategoryCount($tFTCtyName);
        $oCstCount = $oCstCnt [0]->counts;
        echo $oCstCount;
    }

    public function FSxCCSTCategoryDelete() {
        if ($this->input->post('nFNCtyID')) {
            $ocbListItem = $this->input->post('nFNCtyID');
            $aCode = explode(',', $ocbListItem);
            foreach ($aCode as $key => $oValue) {
                $nFNCtyID = $oValue;
                $o = $this->mCustomer->FSxMCSTCategoryDelete($nFNCtyID);
                $aData = array(
                    'count' => $o,
                    'msg' => language('ticket/center/center', 'CheckDel')
                );
                echo json_encode($aData);
            }
        }
    }

    public function FSxCCSTCategoryAdd() {
        $this->load->view('eticket/customer/category/wAdd', array());
    }

    public function FSxCCSTCategoryAddAjax() {
        if ($this->input->post('oetFTCtyName')) {
            $aData = array(
                'FTCtyName' => $this->input->post('oetFTCtyName')
            );
            $nFNCtyID = $this->mCustomer->FSxMCSTCategoryAddAjax($aData);
            echo $nFNCtyID;
        }
    }

    public function FSxCCSTCategoryEdit($nFNCtyID) {
        $oCategory = $this->mCustomer->FSxMCSTCategoryEdit($nFNCtyID);
        $this->load->view('eticket/customer/category/wEdit', array(
            'oCategory' => $oCategory
        ));
    }

    public function FSxCCSTCategoryEditAjax() {
        if ($this->input->post('ohdFNCtyID')) {
            $aData = array(
                'FNCtyID' => $this->input->post('ohdFNCtyID'),
                'FTCtyName' => $this->input->post('oetFTCtyName')
            );
            $this->mCustomer->FSxMCSTCategoryEditAjax($aData);
        }
    }

    /**
     * ** กลุ่มลูกค้า ***
     */
    public function FSxCCSTGroup() {
        $oAuthen = FCNaHCheckAlwFunc('EticketCustomer/group');
        $this->load->view('eticket/customer/group/wGroup', array(
            'oAuthen' => $oAuthen
        ));
    }

    public function FSxCCSTGroupAjaxList() {
        $oAuthen = FCNaHCheckAlwFunc('EticketCustomer/group');
        $tFTCgpName = $this->input->post('tFTCgpName');
        $nPageNo = $this->input->post('nPageNo');
        $nPageActive = $nPageNo;
        $oCstGpList = $this->mCustomer->FSxMCSTGroupAjaxList($tFTCgpName, $nPageActive);
        $this->load->view('eticket/customer/group/wGroupList', array(
            'oAuthen' => $oAuthen,
            'oCstGpList' => $oCstGpList,
            'nPageNo' => $nPageNo

        ));
    }

    public function FSxCCSTGroupCount() {
        $tFTCgpName = $this->input->post('tFTCgpName');
        $oCstCnt = $this->mCustomer->FStMCSTGroupCount($tFTCgpName);
        $oCstCount = $oCstCnt [0]->counts;
        echo $oCstCount;
    }

    public function FSxCCSTGroupDelete() {
        if ($this->input->post('nFNCgpID')) {
            $ocbListItem = $this->input->post('nFNCgpID');
            $aCode = explode(',', $ocbListItem);
            foreach ($aCode as $key => $oValue) {
                $nFNCgpID = $oValue;
                $o = $this->mCustomer->FSxMCSTGroupDelete($nFNCgpID);
                $aData = array(
                    'count' => $o,
                    'msg' => language('ticket/center/center', 'CheckDel')
                );
                echo json_encode($aData);
            }
        }
    }

    public function FSxCCSTGroupAdd() {
        $this->load->view('eticket/customer/group/wAdd', array());
    }

    public function FSxCCSTGroupAddAjax() {
        if ($this->input->post('oetFTCgpName')) {
            $aData = array(
                'FTCgpName' => $this->input->post('oetFTCgpName')
            );
            $nFNCgpID = $this->mCustomer->FSxMCSTGroupAddAjax($aData);
            echo $nFNCgpID;
        }
    }

    public function FSxCCSTGroupEdit($nFNCgpID) {
        $oGroup = $this->mCustomer->FSxMCSTGroupEdit($nFNCgpID);
        $this->load->view('eticket/customer/group/wEdit', array(
            'oGroup' => $oGroup
        ));
    }

    public function FSxCCSTGroupEditAjax() {
        if ($this->input->post('ohdFNCgpID')) {
            $aData = array(
                'FNCgpID' => $this->input->post('ohdFNCgpID'),
                'FTCgpName' => $this->input->post('oetFTCgpName')
            );
            $this->mCustomer->FSxMCSTGroupEditAjax($aData);
        }
    }

}
