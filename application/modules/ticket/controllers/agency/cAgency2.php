<?php
defined('BASEPATH') or exit('No direct script access allowed');
// ตัวแทนขาย
class cAgency extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ticket/agency/mAgency', 'oAgency');
        $this->load->model('ticket/user/mUser', 'mUser');
        $this->load->library('password/PasswordStorage');
    }

   
    // public function index() {
    //     $oAuthen = FCNaHCheckAlwFunc('EticketAgency');
    //     $this->load->view('ticket/agency/wAgency', array(
    //         'oAuthen' => $oAuthen
    //     ));
    // }

    
    // Functionality : โหลด View หลัก และแสดงข้อมูลตัวแทนขาย
    // Parameters :  route
    // Creator : 07/06/2019 saharat(Golf)
    // Last Modified : -
    // Return : view
    // Return Type : view
    public function index($nBrowseType,$tBrowseOption){

        $aData['nBrowseType']       = $nBrowseType;
        $aData['tBrowseOption']     = $tBrowseOption;
	    $aData['aAlwEventAgency']     = FCNaHCheckAlwFunc('agency/0/0'); //Controle Event
        $aData['vBtnSave']          = FCNaHBtnSaveActiveHTML('agency/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('ticket/agency/wAgency',$aData);

    }


    public function FSnCAGNRandomAPI() {
        $tDigitSet1 = FSxCGENGetRandAlphanumeric(8); // Numbers and Letters
        $tDigitSet2 = FSxCGENGetRandAlphanumeric(4); // Numbers and Letters
        $tDigitSet3 = FSxCGENGetRandAlphanumeric(4); // Numbers and Letters
        $tDigitSet4 = FSxCGENGetRandAlphanumeric(4); // Numbers and Letters
        $tDigitSet5 = FSxCGENGetRandAlphanumeric(12); // Numbers and Letters
        echo strtoupper($tDigitSet1) . '-' . strtoupper($tDigitSet2) . '-' . strtoupper($tDigitSet3) . '-' . strtoupper($tDigitSet4) . '-' . strtoupper($tDigitSet5);
    }

    /**
     * ลบรูป
     */
    public function FSnCAGNDelImg() {
        if ($this->input->post('tImgID')) {
            $ptImgID = $this->input->post('tImgID');
            $ptNameImg = $this->input->post('tNameImg');
            $aDeleteImage = array(
                'tImgFolder'   => 'ticketagency',
                'tImgRefID'    => $ptImgID,
                'tTableDel'    => 'TCNMImgPerson',
                'tImgTable'    => 'TTKMAgency'
            );
            $nStaDelImgInDB =   FSnHDelectImageInDB($aDeleteImage);
            if($nStaDelImgInDB == 1){
                FSnHDeleteImageFiles($aDeleteImage);
            }
        }      
    }

    public function FSnCAGNDel() {
        if ($this->input->post('nAgnID')) {
            $ocbListItem = $this->input->post('nAgnID');
            $aCode = explode(',', $ocbListItem);
            foreach ($aCode as $key => $nAgnID) {
                $o = $this->oAgency->FSnMAGNDel($nAgnID);
                $aJson = array(
                    'count' => $o,
                    'msg' => language('ticket/center/center', 'CheckDel')
                );
                $this->oAgency->FSxMAGEAgencyRcvDel($nAgnID);
                if ($o != 0) {
                    $aDeleteImage = array(
                        'tImgFolder'   => 'ticketagency',
                        'tImgRefID'    => $nAgnID,
                        'tTableDel'    => 'TCNMImgPerson',
                        'tImgTable'    => 'TTKMAgency'
                    );
                    FSnHDeleteImageFiles($aDeleteImage);
                } 
            }
        }
    }

    //Functionality : Function Call DataTables Rate
    //Parameters : from ofmAddAgn
    //Creator : 07/06/2016 saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSnCAGNAddSave() {
        $tAgnName = $this->input->post('oetAgnName');
        // $tAgnKeyAPI = $this->input->post('oetAgnKeyAPI');
        $tAgnEmail = $this->input->post('oetAgnEmail');
        $tAgnTel = $this->input->post('oetAgnTel');
        $tAgnMo = $this->input->post('oetAgnMo');
        $tAgnFax = $this->input->post('oetAgnFax');
        $nAgnStaApv = $this->input->post('ocmAgnStaApv');
        $nAgnStaActive = $this->input->post('ocmAgnStaActive');
        $nAtyCode = $this->input->post('ocmFTAtyCode');
        $nAgnAggID = $this->input->post('ocmAgnAggID');
        $tAgnPwd = explode('6:', PasswordStorage::create_hash(trim($this->input->post('opwAgnPwd'))));

        // $nCodeID = FsxCodeID('FTAgnCode', 'TCNMAgency', 3);
        $aData = array(
            // 'FTAgnKeyAPI' => $tAgnKeyAPI,
            'tIsAutoGenCode' => $this->input->post('ocbAgencyAutoGenCode'),
            'FTAgnCode'      => $this->input->post('oetAgnCode'),
            'FTAgnPwd'       => $tAgnPwd [1],
            'FTAgnEmail'     => $tAgnEmail,
            'FTAgnTel'       => $tAgnTel,
            'FTAgnFax'       => $tAgnFax,
            'FTAgnMo'        => $tAgnMo,
            'FTAgnTel'       => $tAgnTel,
            'FTAgnStaApv'    => $nAgnStaApv,
            'FTAgnStaActive' => $nAgnStaActive,
            'FTAtyCode'      => $nAtyCode,
            'FTAggCode'      => $nAgnAggID,
            'FDLastUpdOn'    => date('Y-m-d h:i'),
            'FTLastUpdBy'    => $this->session->userdata("username"),
            'FDCreateOn'     => date('Y-m-d h:i'),
            'FTCreateBy'     => $this->session->userdata("username")
        );
        $nCodeID = $aData['FTAgnCode'];
        $aDataAgnList_L = array(
            'FTAgnCode' => $nCodeID,
            'FTAgnName' => $tAgnName
        );
        
        if($aData['tIsAutoGenCode'] == '1'){ // Check Auto Gen Department Code?
            // Auto Gen Department Code
            $aStoreParam = array(
                "tTblName"    => 'TCNMAgency',                           
                "tDocType"    => 0,                                          
                "tBchCode"    => "",                                 
                "tShpCode"    => "",                               
                "tPosCode"    => "",                     
                "dDocDate"    => date("Y-m-d")       
            );
            $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
            $aData['FTAgnCode']   = $aAutogen[0]["FTXxhDocNo"];

            // $aGenCode = FCNaHGenCodeV5('TCNMAgency','0');
            // if($aGenCode['rtCode'] == '1'){
            //     $aData['FTAgnCode'] = $aGenCode['rtAgnCode'];
            // }
        }
 

        $tCheckEmail = $this->oAgency->FSxMAGNCheckEmail($aData['FTAgnEmail']);
        if ($tCheckEmail == 'true') {
            $this->oAgency->FSxMAGNAddAgency($aData, $aDataAgnList_L);
            $aFTRcvCode = $this->input->post('ocmFTRcvCode[]');
            $i = 0;
            foreach ($aFTRcvCode as $key => $aValue) {
                $i ++;
                $aRCV = array(
                    'FTAgnCode' => $nCodeID,
                    'FTRcvCode' => $aValue
            );
        // $this->oAgency->FSxMAGNAddRCV($aRCV);
    }  
    if ($this->input->post('ohdAgcImg')) {
        $tImg = $this->input->post('ohdAgcImg');
        $aImageUplode = array(
            'tModuleName'       => 'ticket',
            'tImgFolder'        => 'ticketagency',
            'tImgRefID'         => $nCodeID,
            'tImgObj'           => $tImg,
            'tImgTable'         => 'TTKMAgency',
            'tTableInsert'      => 'TCNMImgPerson',
            'tImgKey'           => 'main',
            'dDateTimeOn'       => date('Y-m-d H:i:s'),
            'tWhoBy'            => $this->session->userdata('tSesUsername'),
            'nStaDelBeforeEdit' => 1
        );
        $aResAddImgObj = FCNnHAddImgObj($aImageUplode);
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
        $this->email->from($this->config->item('smtp_user'), language('ticket/about/about', 'tAboutuser') . '');
        $this->email->to($tAgnEmail);
        $this->email->subject(language('ticket/about/about', 'tAboutuser') . '');
        $message = 
        '<!DOCTYPE html>
        <html>
        <head>
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>' . language('ticket/about/about', 'tAboutuser') . '</title>
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
        <p>' . language('ticket/about/about', 'tHi') . ' ' . $tAgnName . ',</p>
        <hr>
        <p>' . language('ticket/about/about', 'tName') . ' : ' . $tAgnName . '</p>
        <p>' . language('ticket/about/about', 'tEmail') . ' : ' . $tAgnEmail . '</p>
        <p>' . language('ticket/about/about', 'tPassword') . ' : ' . $this->input->post('opwAgnPwd') . '</p>
        <p>' . language('ticket/about/about', 'tTelephoneNumber') . ' : ' . $tAgnTel . '</p>
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
            echo $nCodeID;
        }
    }

    public function FStCAGNAddPage() {
        $oRCV = $this->oAgency->FSxMAGERCV();
        $oPvlHD = $this->oAgency->FSxMUsrPvlHD();
        $oAgnGroup = $this->oAgency->FStMAAGNGetAgnGroup();
        $oAgnTy = $this->oAgency->FStMAAGNGetAgnTy();
        $this->load->view('ticket/agency/wAgencyAdd', array(
            'oRCV' => $oRCV,
            'oPvlHD' => $oPvlHD,
            'oAgnGroup' => $oAgnGroup,
            'oAgnTy' => $oAgnTy
        ));
    }

    public function FSnCAGNEditSave() {
        $nAgnID = $this->input->post('ohdAgnID');
        $tAgnName = $this->input->post('oetAgnName');
        // $tAgnKeyAPI = $this->input->post('oetAgnKeyAPI');
        $tAgnEmail = $this->input->post('oetAgnEmail');
        $tAgnTel = $this->input->post('oetAgnTel');
        $tAgnMo = $this->input->post('oetAgnMo');
        $tAgnFax = $this->input->post('oetAgnFax');
        $nAgnStaApv = $this->input->post('ocmAgnStaApv');
        $nAgnStaActive = $this->input->post('ocmAgnStaActive');
        $nAtyCode = $this->input->post('ocmFTAtyCode');
        $nAgnAggID = $this->input->post('ocmAgnAggID');
        $aData = array(
            // 'FTAgnKeyAPI' => $tAgnKeyAPI,
            // 'FTAgnEmail' => $tAgnEmail,
            'FTAgnTel' => $tAgnTel,
            'FTAgnFax' => $tAgnFax,
            'FTAgnMo' => $tAgnMo,
            'FTAgnTel' => $tAgnTel,
            'FTAgnStaApv' => $nAgnStaApv,
            'FTAgnStaActive' => $nAgnStaActive,
            'FTAtyCode' => $nAtyCode,
            'FTAggCode' => $nAgnAggID,
            'FDLastUpdOn' => date('Y-m-d h:i'),
            'FTLastUpdBy' => $this->session->userdata("username")
        );
        $nStaEditAgn = $this->oAgency->FSxMAGNEditAgency($nAgnID, $aData, $tAgnName); 
        if ($this->input->post('opwAgnPwd') != '!@#$%&*') {
            $tPwd = explode('6:', PasswordStorage::create_hash(trim($this->input->post('opwAgnPwd'))));
            $aPwd = array(
                'FTAgnPwd' => $tPwd [1],
                'FTAgnCode' => $nAgnID
            );
            $this->oAgency->FSxMAGNEditPwd($aPwd);
        }

        $this->oAgency->FSxMAGEAgencyRcvDel($nAgnID);
        $aFTRcvCode = $this->input->post('ocmFTRcvCode[]');
        $i = 0;
        foreach ($aFTRcvCode as $key => $aValue) {
            $i ++;
            $aRCV = array(
                'FTRcvCode' => $aValue,
                'FTAgnCode' => $nAgnID,
            );
            $this->oAgency->FSxMAGNEditRCV($aRCV);
        }

   
        if ($this->input->post('ohdAgcImg')) {
            $tImg = $this->input->post('ohdAgcImg');
            $aImageUplode = array(
                'tModuleName'       => 'ticket',
                'tImgFolder'        => 'ticketagency',
                'tImgRefID'         => $nAgnID,
                'tImgObj'           => $tImg,
                'tImgTable'         => 'TTKMAgency',
                'tTableInsert'      => 'TCNMImgPerson',
                'tImgKey'           => 'main',
                'dDateTimeOn'       => date('Y-m-d H:i:s'),
                'tWhoBy'            => $this->session->userdata('tSesUsername'),
                'nStaDelBeforeEdit' => 1
            );
            $aResAddImgObj = FCNnHAddImgObj($aImageUplode);
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
        $this->email->from($this->config->item('smtp_user'), language('ticket/about/about', 'tAboutuser') . '');
        $this->email->to($tAgnEmail);
        $this->email->subject(language('ticket/about/about', 'tAboutuser') . '');
        $message = '<!DOCTYPE html>
          <html>
          <head>
          <meta name="viewport" content="width=device-width" />
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
          <title>' . language('ticket/about/about', 'tAboutuser') . '</title>
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
          <p>' . language('ticket/about/about', 'tHi') . ' ' . $tAgnName . ',</p>
          <hr>
          <p>' . language('ticket/about/about', 'tName') . ' : ' . $tAgnName . '</p>
          <p>' . language('ticket/about/about', 'tEmail') . ' : ' . $tAgnEmail . '</p>
          <p>' . language('ticket/about/about', 'tPassword') . ' : ' . ($this->input->post('opwAgnPwd') != '!@#$%&*' ? $this->input->post('opwAgnPwd') : "-") . '</p>
          <p>' . language('ticket/about/about', 'tTelephoneNumber') . ' : ' . $tAgnTel . '</p>
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
        echo $nStaEditAgn;
    }

    // 'FTAgnLogo'=> $tAgnDirector,
    // public function FStCAGNList() {
    //     $oAuthen = FCNaHCheckAlwFunc('EticketAgency');
    //     $tAgnName = $this->input->post('tAgnName');
    //     $nPageNo = $this->input->post('nPageNo');
    //     if ($nPageNo == '') {
    //         $nPageActive = 1;
    //     } else {
    //         $nPageActive = $nPageNo;
    //     }
    //     $oAgnList = $this->oAgency->FSaMAGNList($tAgnName, $nPageActive);
    //     $this->load->view('ticket/agency/wAgencyList', array(
    //         'oAgnList' => $oAgnList,
    //         'oAuthen' => $oAuthen,
    //         'nPageNo'   => $nPageNo
    //     ));
    // }
    public function FSxCCPNFormSearchList(){
        $this->load->view('coupon/coupon/wCouponFormSearchList');
    }
    

    public function FSxCAGECount() {
        $tAgnName = $this->input->post('tAgnName');
        $oCnt = $this->oAgency->FStMAGEFCNnHSizeOf($tAgnName);
        $oCnt = $oCnt [0]->counts;
        echo $oCnt;
    }

    public function FSnCAGNEdit($tAgnCode) {
        $oRCV = $this->oAgency->FSxMAGERCV();
        $oAgnEdit = $this->oAgency->FSaMGetEditAgn($tAgnCode);
        $oAgencyRcv = $this->oAgency->FSxMAGEAgencyRcv($tAgnCode);
        $oPvlHD = $this->oAgency->FSxMUsrPvlHD();
        $oAgnGroup = $this->oAgency->FStMAAGNGetAgnGroup();
        $oAgnTy = $this->oAgency->FStMAAGNGetAgnTy();
        $this->load->view('ticket/agency/wAgencyEdit', array(
            'oRCV' => $oRCV,
            'oAgencyRcv' => $oAgencyRcv,
            'nAgnID' => $tAgnCode,
            'oAgnEdit' => $oAgnEdit,
            'oPvlHD' => $oPvlHD,
            'oAgnTy' => $oAgnTy,
            'oAgnGroup' => $oAgnGroup
        ));
    }

    // บันทึกข้อมูล agency
    public function FSxCAGESaveAgency() {
        $tAgcUserName = $this->input->post('oetFTAgcUserName');
        $tAgcUserPass = $this->input->post('oetFTAgcPass');
        $tAgcName = $this->input->post('oetFTAgcName');
        $tAgcLastName = $this->input->post('oetAgcLastName');
        $$tAgcName = $tAgcName . ' ' . $tAgcLastName;
        $tAgnEmail = $this->input->post('oetAgcEmail');

        echo $tAgcUserName . '=>' . $tAgcUserPass . "=>" . $tAgcName;

        $aData = array(
            'FTAgnPwd' => $tAgcUserPass,
            'FTAgnName' => $$tAgcName,
            'FTAgnEmail' => $tAgnEmail,
            'FDDateIns' => date('Y-m-d'),
            'FTTimeIns' => date('h:i:s')
        );

        $this->mAgency->FSxMAGESaveAgency($aData);
    }

    // บันทึกข้อมูลการเข้าถึง API ในฟอร์มแก้ไขตัวแทนขาย
    public function FSxCAGESaveAPIAccess() {
        try {

            $tAgenId = $this->input->post('tAgencyId'); // รหัสตัวแทนขาย
            $aAPIFun = $this->input->post('aAPIFun'); // สิทธิ์การเข้าถึง API
            // echo "<pre>";
            // echo var_dump($aAPIFun);
            // echo "<pre>";
            // ลบข้อมูลการเข้าถึง API ของตัวแทนขาย
            $this->mAgency->FSaMAGDelEAPIFeatuer($tAgenId);

            // Loop บันทึกข้อมูล
            for ($i = 0; $i < FCNnHSizeOf($aAPIFun); $i ++) {

                $aData = array(
                    'FTAgnKeyAPI' => $tAgenId,
                    'FNAgaApiRef' => $aAPIFun [$i]
                );
                // บันทึกข้อมูลการเข้าถึง API ในฟอร์มกำหนดสิทธิ์การเข้าถึง API ของตัวแทนขาย
                $this->mAgency->FSaMAGSaveEAPIFeatuer($aData);
            }
        } catch (Exception $e) {
            echo 'Had someting error' + $e;
        }
    }

    // ดึงข้อมูลการเข้าถึง API ของแต่ละตัวแทนขาย
    public function FSxCAGEGetAPIFuncAcc() {
        $tAgenId = $this->input->post('tAgencyId'); // รหัสตัวแทนขาย
        // ดึงข้อมูลการเข้าถึง API ของแต่ละตัวแทนขาย
        $aAPIRow = $this->mAgency->FSxMAGEGetAPIFuncAcc($tAgenId);

        // echo "<pre>".var_dump($aAPIRow)."</pre>";

        if (is_array($aAPIRow)) {
            $i = 0;
            foreach ($aAPIRow as $aRows) {
                // 1 Login Ok
                $aAPIList [$i] = $aRows->FNAgaApiRef;

                $i ++;
            } // end foreach
        } else {

            $aAPIList [0] = 0;
        } // end else

        echo implode(',', $aAPIList);
    }

    // บันทึกข้อมูลในหน้าจอแก้ไขตัวแทนขาย
    public function FSxCAGEEdit() {
        $tAgenId = $this->input->post('tAgencyId'); // รหัสตัวแทนขาย
        $tAgencyAddress = $this->input->post('tAgencyAddress'); // ที่อยู่
        $tAgencySubDistric = $this->input->post('tAgencySubDistric'); // แขวง/ตำบล
        $tAgencyDistric = $this->input->post('tAgencyDistric'); // เขต/อำเภอ
        $tAgencyProvince = $this->input->post('tAgencyProvince'); // จังหวัด
        $tAgencyTel = $this->input->post('tAgencyTel'); // เบอร์โทร
        $tAgencyEmail = $this->input->post('tAgencyEmail'); // อีเมล
        $tAgencyCmp = $this->input->post('tAgencyCmp'); // บริษัท เจ้าของกิจการ
        $nAgenApv = $this->input->post('nAgenApv'); // สถานะ การอนุมัติข้อมูล

        $aAgenData = array(
            "tAgencyId" => $tAgenId,
            "tAgencyAddress" => $tAgencyAddress,
            "tAgencySubDistric" => $tAgencySubDistric,
            "tAgencyDistric" => $tAgencyDistric,
            "tAgencyProvince" => $tAgencyProvince,
            "tAgencyTel" => $tAgencyTel,
            "tAgencyEmail" => $tAgencyEmail,
            "tAgencyCmp" => $tAgencyCmp,
            "nAgenApv" => $nAgenApv
        );

        // echo "<pre>";
        // var_dump($aAgenData);
        // echo "</pre>";
        // บันทึกข้อมูลในหน้าจอแก้ไขตัวแทนขาย
        $this->mAgency->FSxMAGEEdit($aAgenData);
    }

    //ลบข้อมูลตัวแทนขาย
    public function FSxCAGEDelete() {
        if ($this->input->post('ptAgenId')) {
            $ocbListItem = $this->input->post('ptAgenId');
            $aCode = explode(',', $ocbListItem);
            foreach ($aCode as $key => $oValue) {
                $ptAgenId = $oValue;
                $o = $this->oAgency->FSxMAGEDelete($ptAgenId);
                $aData = array(
                    'count' => $o,
                    'msg' => language('ticket/center/center', 'CheckDel')
                );
                if ($o != 0) {
					$aDeleteImage = array(
                        'tModuleName'  => 'ticket',
						'tImgFolder'   => 'ticketagency',
						'tImgRefID'    => $ocbListItem ,
						'tTableDel'    => 'TCNMImgPerson',
						'tImgTable'    => 'TTKMAgency'
					);
					FSnHDeleteImageFiles($aDeleteImage);
				} 
                echo json_encode($aData);
            }
        }
    }

    /**
     * ** กลุ่มตัวแทนขาย***
     */
    public function FSxCAGEGroup() {
        $oAuthen = FCNaHCheckAlwFunc('EticketAgency/group');
        $this->load->view('ticket/agency/group/wGroup', array(
            'oAuthen' => $oAuthen
        ));
    }

    public function FSxCAGEGroupAjaxList() {
        $oAuthen = FCNaHCheckAlwFunc('EticketAgency/group');
        $tFTAggName = $this->input->post('tFTAggName');
        $nPageNo = $this->input->post('nPageNo');
        $nPageActive = $nPageNo;
        $oGpList = $this->oAgency->FSxMAGEGroupAjaxList($tFTAggName, $nPageActive);
        $this->load->view('ticket/agency/group/wGroupList', array(
            'oAuthen' => $oAuthen,
            'oGpList' => $oGpList,
            'nPageNo' => $nPageNo

        ));
    }

    public function FSxCAGEGroupCount() {
        $tFTAggName = $this->input->post('tFTAggName');
        $oCnt = $this->oAgency->FStMAGEGroupFCNnHSizeOf($tFTAggName);
        $oCnt = $oCnt [0]->counts;
        echo $oCnt;
    }

    public function FSxCAGEGroupDelete() {
        if ($this->input->post('nFTAggCode')) {
            $ocbListItem = $this->input->post('nFTAggCode');
            $aCode = explode(',', $ocbListItem);
            foreach ($aCode as $key => $oValue) {
                $nFTAggCode = $oValue;
                $o = $this->oAgency->FSxMAGEGroupDelete($nFTAggCode);
                $aData = array(
                    'status' => $o,
                    'msg' => language('ticket/center/center', 'CheckDel')
                );
                echo json_encode($aData);
            }
        }
    }

    public function FSxCAGEGroupAdd() {
        $this->load->view('ticket/agency/group/wAdd', array());
    }

    public function FSxCAGEGroupAddAjax() {
        if ($this->input->post('oetFTAggName')) {
            $nCodeID = FsxCodeID('FTAggCode', 'TCNMAgencyGrp', 5);
            $aData = array(
                'FTAggCode' => $nCodeID,
                'FTAggName' => $this->input->post('oetFTAggName')
            );
            $this->oAgency->FSxMAGEGroupAddAjax($aData);
            echo $nCodeID;
        }
    }

    public function FSxCAGEGroupEdit($nFNCgpID) {
        $oGroup = $this->oAgency->FSxMAGEGroupEdit($nFNCgpID);
        $this->load->view('ticket/agency/group/wEdit', array(
            'oGroup' => $oGroup
        ));
    }

    public function FSxCAGEGroupEditAjax() {
        if ($this->input->post('ohdFTAggCode')) {
            $aData = array(
                'FTAggCode' => $this->input->post('ohdFTAggCode'),
                'FTAggName' => $this->input->post('oetFTAggName')
            );
            $this->oAgency->FSxMAGEGroupEditAjax($aData);
        }
    }

    // @Natt Add Fn
    public function FSxCAGNCheckEmail() {
        if ($this->input->post('email')) {
            $tEmail = $this->input->post('email');
            $tCheckEmail = $this->oAgency->FSxMAGNCheckEmail($tEmail);
            echo $tCheckEmail;
        }
    }

    // Agency Type
    public function FSxCAGEType() {
        $oAuthen = FCNaHCheckAlwFunc('EticketAgency/Type');
        $this->load->view('ticket/agency/type/wType', array(
            'oAuthen' => $oAuthen
        ));
    }

    public function FSxCAGETypeAjaxList() {
        $oAuthen = FCNaHCheckAlwFunc('EticketAgency/Type');
        $tFTAtyName = $this->input->post('tFTAtyName');
        $nPageNo = $this->input->post('nPageNo');
        $nPageActive = $nPageNo;
        $oTypeList = $this->oAgency->FSxMAGETypeAjaxList($tFTAtyName, $nPageActive);
        $this->load->view('ticket/agency/type/wTypeList', array(
            'oAuthen' => $oAuthen,
            'oTypeList' => $oTypeList,
            'nPageNo' => $nPageNo
        ));
    }

    public function FSxCAGETypeCount() {
        $tFTAtyName = $this->input->post('tFTAtyName');
        $oCnt = $this->oAgency->FStMAGETypeFCNnHSizeOf($tFTAtyName);
        $oCnt = $oCnt [0]->counts;
        echo $oCnt;
    }

    public function FSxCAGETypeDelete() {
        if ($this->input->post('nFTAtyCode')) {
            $ocbListItem = $this->input->post('nFTAtyCode');
            $aCode = explode(',', $ocbListItem);
            foreach ($aCode as $key => $oValue) {
                $nFTAtyCode = $oValue;
                $o = $this->oAgency->FSxMAGETypeDelete($nFTAtyCode);
                $aData = array(
                    'count' => $o,
                    'msg' => language('ticket/center/center', 'CheckDel')
                );
                echo json_encode($aData);
            }
        }
    }

    public function FSxCAGETypeAdd() {
        $this->load->view('ticket/agency/type/wAdd', array());
    }

    public function FSxCAGETypeAddAjax() {
        if ($this->input->post('oetFTAtyName')) {
            $nCodeID = FsxCodeID('FTAtyCode', 'TCNMAgencyType', 5);
            $aData = array(
                'FTAtyCode' => $nCodeID,
                'FTAtyName' => $this->input->post('oetFTAtyName')
            );
            $this->oAgency->FSxMAGETypeAddAjax($aData);
            echo $nCodeID;
        }
    }

    public function FSxCAGETypeEdit($nFTAtyCode) {
        $oType = $this->oAgency->FSxMAGETypeEdit($nFTAtyCode);
        $this->load->view('ticket/agency/type/wEdit', array(
            'oType' => $oType
        ));
    }


    public function FSxCAGETypeEditAjax() {
            if ($this->input->post('ohdFTAtyCode')) {
                $aData = array(
                    'FTAtyCode' => $this->input->post('ohdFTAtyCode'),
                    'FTAtyName' => $this->input->post('oetFTAtyName')
                );
                $this->oAgency->FSxMAGETypeEditAjax($aData);
            }
        }
    }
