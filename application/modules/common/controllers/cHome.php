<?php defined('BASEPATH') or exit('No direct script access allowed');

class cHome extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library("session");
        // if (@$_SESSION['tSesUsername'] == false) {
        //     redirect('login', 'refresh');
        //     exit();
        // }
        if( get_cookie('AdaStoreBackCookies') === NULL ){
            redirect('login', 'refresh');
            exit();
        }
        $this->load->model('common/mMenu');
        $this->load->model('favorite/favorite/mFavorites');
        $this->load->model('common/mNotification');
        $this->load->model('document/purchaseorder/mPurchaseOrder');
        $this->load->model('document/purchaseinvoice/mPurchaseInvoice');
    }

    public function index($nMsgResp = '')
    {
        $nMsgResp       =  array('title' => "Home");
        $tUsrID         =  FCNoGetCookieVal("tSesUsername");
        $nLngID         =  FCNoGetCookieVal("tLangID");
        $nOwner         =  FCNoGetCookieVal('tSesUserCode');

        $aAlwNoti       =  $this->mNotification->FSaMMENUChkAlwNoti();
        if ($aAlwNoti['tCode'] == '1') {
            foreach ($aAlwNoti['aItems'] as $aValue) {

                if ($aValue['FTAlwActive'] == 'Y') {
                    $bAlwActive = true;
                } else {
                    $bAlwActive = false;
                }

                switch ($aValue['FTGrpNoti']) {
                    case 'NEWS':
                        $this->session->set_userdata("bSesAlwNews", $bAlwActive);
                        FCNxAddCookie("bSesAlwNews",$bAlwActive);
                        break;
                    default:
                        $this->session->set_userdata("bSesAlwNoti", $bAlwActive);
                        FCNxAddCookie("bSesAlwNoti",$bAlwActive);
                        break;
                }
            }
        }
        // echo "<pre>";
        // echo $this->session->userdata("bSesAlwNoti");
        // exit;

        $this->load->view('common/wHeader', $nMsgResp);
        $this->load->view('common/wTopBar', array('nMsgResp' => $nMsgResp));

        if (isset($nLngID) && !empty($nLngID)) {
            $nLngID = FCNoGetCookieVal("tLangID");
        } else {
            $nLngID = 1;
        }

        $tBranchHQ      = $this->mMenu->FStMMENUGetBranchHQ(); // Get HQBch from Table Agency or Company
        $aChkLic        = $this->mMenu->FSaMMENUCheckLicense($tBranchHQ);


        //set seesion HQBch
        $this->session->set_userdata("tSesHQBchCode", $tBranchHQ);
        FCNxAddCookie("tSesHQBchCode",$tBranchHQ);

        // echo "<pre>";
        // print_r($tBranchHQ);
        // print_r($aChkLic);
        // echo $this->session->userdata("tSesSessionID");
        // exit;


        //$aChkLic['tCode'] = 1;
        // ????????????????????? TRGTLicKey
        if ($aChkLic['tCode'] == '1') {
            // ????????????????????????????????? + ??????????????????????????????
            $tCstKey = $aChkLic['aItems'][0]['FTCstKey'];
            $this->session->set_userdata("bSesRegStaLicense", true);
            FCNxAddCookie("bSesRegStaLicense",true);
            //$tCstKey = '7a05f6eb2e9e';

            $this->session->set_userdata("tSesCstKey", $tCstKey);
            FCNxAddCookie("tSesCstKey",$tCstKey);

            $aMenuFav       = $this->mFavorites->FSaFavGetdataList($nOwner, $nLngID);
            $oGrpModules    = $this->mMenu->FSaMMENUGetMenuGrpModulesName($tUsrID, $nLngID);
            $oMenuList      = $this->mMenu->FSoMMENUGetMenuList($tUsrID, $nLngID, $tCstKey);
            $aChkBuyPackage = $this->mMenu->FSaMMENUCheckBuyPackage($tCstKey);

            if ($aChkBuyPackage['tCode'] == '1') {
                $this->session->set_userdata("bSesRegStaBuyPackage", true);
                FCNxAddCookie("bSesRegStaBuyPackage",true);
            } else {
                $this->session->set_userdata("bSesRegStaBuyPackage", false);
                FCNxAddCookie("bSesRegStaBuyPackage",false);
            }
        } else {
            // ????????????????????????????????? + ??????????????????????????????????????? ???????????? ????????????????????????????????????????????????????????????
            $this->session->set_userdata("bSesRegStaLicense", false);
            $this->session->set_userdata("bSesRegStaBuyPackage", false);
            $this->session->set_userdata("tSesCstKey", '');

            FCNxAddCookie("bSesRegStaLicense",false);
            FCNxAddCookie("bSesRegStaBuyPackage",false);
            FCNxAddCookie("tSesCstKey",'');

            $aMenuFav       = false;
            $oGrpModules    = false;
            $oMenuList         = false;
            // $aAlwMnuLic     = array();
        }

        $this->load->view('common/wMenu', array(
            'aMenuFav'        => $aMenuFav,
            'nMsgResp'        => $nMsgResp,
            'oGrpModules'   => $oGrpModules,
            'oMenuList'     => $oMenuList,
            'tUsrID'        => $tUsrID
        ));


        $this->load->view('common/wWellcome', $nMsgResp);
        $this->load->view('common/wFooter', array('nMsgResp' => $nMsgResp));
    }

    //Create by witsarut 04/03/2020
    //function ???????????????????????? Insdata Insert ?????? ??????????????? Notification
    public function FSxAddDataNoti()
    {
        try {

            $aResData =  $this->input->post('tDataNoti');

            foreach ($aResData['ptData']['paContents'] as $nKey => $aValue) {
                $tSubTopic  =  $aValue['ptFTSubTopic'];
                $tMsg       =  $aValue['ptFTMsg'];
            }

            $aData = array(
                'FTMsgID'       => $aResData['ptFunction'],
                'FTBchCode'     => FCNoGetCookieVal('tSesUsrBchCom'),
                'FDNtiSendDate' => $aResData['ptData']['ptFDSendDate'],
                'FTNtiID'       => $aResData['ptData']['ptFTNotiId'],
                'FTNtiTopic'    => $aResData['ptData']['ptFTTopic'],
                'FTNtiContents' => json_encode($aResData['ptData']['paContents']),
                'FTNtiUsrRole'  => $aResData['ptData']['ptFTUsrRole'],
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => FCNoGetCookieVal('tSesUsername'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTCreateBy'    => FCNoGetCookieVal('tSesUsername'),
                'tSource'       => $aResData['ptSource'],
                'tDest'         => $aResData['ptDest'],
                'tFilter'       => $aResData['ptFilter']
            );


            $this->db->trans_begin();

            // Check ??????????????????????????? TCNTNoti (FTMsgID)
            // ???????????????????????? : ????????? Check ?????????????????????????????????????????????????????????????????? Insert TCNTNoti
            $aChkDupNotiMsgID   = $this->mNotification->FSaMCheckNotiMsgID($aData);

            if ($aChkDupNotiMsgID['rtCode'] == 1) {
                $aReturn = array(
                    'nStaEvent'    => '905',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            } else {
                $aResult = $this->mNotification->FSaMAddNotification($aData);

                if ($this->db->trans_status() == false) {
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Success Add Data"
                    );
                } else {
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'     => get_cookie('tBtnSaveStaActive'),
                        'nStaEvent'        => '1',
                        'tStaMessg'        => 'Success Add Data',
                    );
                }
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Create by witsarut 04/03/2020
    //function ???????????????????????? Getdata Insert ?????? ??????????????? Notification
    public function FSxGetDataNoti()
    {

        $aData = $this->mNotification->FSaMGetNotification();
        if ($aData['rtCode'] == 900) {
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess Success Add Data"
            );
        } else {
            $aReturn = array(
                'nStaEvent'        => '1',
                'tStaMessg'        => 'Success Add Data',
                'aData'         => $aData['raItems']
            );
        }
        echo json_encode($aReturn);
    }

    //Create by witsarut 04/03/2020
    //function ???????????????????????? Getdata Read 
    public function FSxGetDataNotiRead()
    {
        $this->mNotification->FSaMMoveDataTableNotiToTableRead();
    }

    //Create by supawat 03/07/2020
    public function FSxImpImportFileExcel()
    {
        $this->load->model('common/mCommon');
        $this->load->model('document/adjuststock/mAdjustStock'); // ??????????????????????????? - ??????????????????????????????????????????????????????

        $aPackData      = $this->input->post('aPackdata');
        $tNameModule    = $this->input->post('tNameModule');
        $tTypeModule    = $this->input->post('tTypeModule');
        $tFlagClearTmp  = $this->input->post('tFlagClearTmp');
        $tImportDocumentNo  = $this->input->post('tImportDocumentNo');
        $tImportFrmBchCode  = $this->input->post('tImportFrmBchCode');
        $tImportSplVatRate  = $this->input->post('tImportSplVatRate');
        $tImportSplVatCode  = $this->input->post('tImportSplVatCode');
        // $tLblCode  = $this->input->post('tLblCode');
        $aImportParams = $this->input->post('aImportParams');
        if( isset($aImportParams) ){
            $aImportParams = json_decode($aImportParams, JSON_FORCE_OBJECT);
        }
        // echo "<pre>";
        // print_r($aPackData);exit;
        $nPackData      = FCNnHSizeOf($aPackData);

        //???????????????????????????????????????
        if ($tTypeModule == 'document') {
            //????????????????????????????????????????????????????????????????????? TCNTDocDTTmp
            if ($tNameModule == 'printbarcode') {
                $tTableName = 'TCNTPrnLabelTmp';
                $tTableFhnName = '';
            } else {
                $tTableName = 'TCNTDocDTTmp';
                $tTableFhnName = 'TCNTDocDTFhnTmp';
            }
        } else if ($tTypeModule == 'master') {
            //?????????????????????????????????????????????????????????????????????????????? TCNTImpMasTmp
            $tTableName = 'TCNTImpMasTmp';
            $tTableFhnName = '';
        }

        //???????????????????????? ?????????????????????????????????????????????
        switch ($tNameModule) {
            case "branch":
                $aTableRefPK = ['TCNMBranch'];
                $tTableRefPK = $aTableRefPK[0];
                break;
            case "adjprice":
                $aTableRefPK = ['TCNTPdtAdjPriHD'];
                $tTableRefPK = $aTableRefPK[0];
                break;
            case "user":
                $aTableRefPK = ['TCNMUser'];
                $tTableRefPK = $aTableRefPK[0];
                break;
            case "pos":
                $aTableRefPK = ['TCNMPos'];
                $tTableRefPK = $aTableRefPK[0];
                break;
            case "product":
                $aTableRefPK = ['TCNMPDT', 'TCNMPdtUnit', 'TCNMPdtBrand', 'TCNMPdtTouchGrp', 'TCNMPdtSpcBch'];
                $tTableRefPK = $aTableRefPK;
                break;
            case "purchaseorder":
                $aTableRefPK = ['TAPTPoHD'];
                $tTableRefPK = $aTableRefPK[0];
                break;
            case "purchaseinvoice":
                $aTableRefPK = ['TAPTPiHD'];
                $tTableRefPK = $aTableRefPK[0];
                break;
            case "adjcost":
                $aTableRefPK = ['TCNTPdtAdjCostHD'];
                $tTableRefPK = $aTableRefPK[0];
                break;
            case "printbarcode":
                $aTableRefPK = ['TCNTPrnLabelTmp'];
                $tTableRefPK = $aTableRefPK[0];
                break;
            case "coupon":
                $tTableName  = 'TCNTImpCouponTmp';
                $aTableRefPK = ['TFNTCouponHD','TFNTCouponDT'];
                $tTableRefPK = $aTableRefPK;
                break;
            case "adjstkconfirm":
                $aTableRefPK = ['TCNTPdtAdjStkHD'];
                $tTableRefPK = $aTableRefPK[0];
                break;
        }

        //???????????????????????? ?????????????????????????????????????????????
        $aWhereData = array(
            'tTableRefPK'       => $tTableRefPK,
            'tTableNameTmp'     => $tTableName,
            'tTableFhnNameTmp'  => $tTableFhnName,
            'tFlagClearTmp'     => $tFlagClearTmp,
            'tTypeModule'       => $tTypeModule,
            'tNameModule'       => $tNameModule,
            'tSessionID'        => FCNoGetCookieVal("tSesSessionID"), //$this->session->userdata("tSesSessionID")
        );


        //????????????????????????????????????????????????????????????????????????????????????????????? ??????????????????????????????????????????????????????
        if ($tNameModule == 'product') {

            $this->mCommon->FCNaMCMMDeleteTmpExcelCasePDT($aWhereData);

            //??????????????? ????????????????????????
            $aSumSheetTGroup = array();
            if (isset($aPackData[7])) {
                for ($tTGROUP = 0; $tTGROUP < FCNnHSizeOf($aPackData[7]); $tTGROUP++) {
                    $aTGroup = array(
                        'FTTmpTableKey'     => 'TCNMPdtTouchGrp',
                        'FTAgnCode'         => FCNoGetCookieVal("tSesUsrAgnCode"),
                        'FNTmpSeq'          => $tTGROUP + 1,
                        'FTTcgCode'         => $aPackData[7][$tTGROUP][0],
                        'FTTcgName'         => $aPackData[7][$tTGROUP][1],
                        'FTSessionID'       => FCNoGetCookieVal("tSesSessionID"),
                        'FTTmpStatus'       => (isset($aPackData[7][$tTGROUP][2]) == '') ? '' : $aPackData[7][$tTGROUP][2],
                        'FTTmpRemark'       => (isset($aPackData[7][$tTGROUP][3]) == '') ? '' : $aPackData[7][$tTGROUP][3],
                        'FDCreateOn'        => date('Y-m-d')
                    );
                    array_push($aSumSheetTGroup, $aTGroup);
                }

                //Insert ?????? Tmp ????????????
                $this->mCommon->FCNaMCMMImportExcelToTmp($aWhereData, $aSumSheetTGroup);

                //validate ???????????????????????????????????????????????? Tmp _ ????????????????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTTcgCode'
                );
                FCNnMasTmpChkCodeDupInTemp($aValidateData);

                //validate ???????????????????????????????????????????????????????????????????????????????????? _ ????????????????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTTcgCode',
                    'tTableName'        => 'TCNMPdtTouchGrp'
                );
                FCNnMasTmpChkCodeDupInDB($aValidateData);
            }

            //??????????????? ?????????????????????????????????
            $aSumSheetPdtGroup = array();
            if (isset($aPackData[6])) {
                for ($tPdtGroup = 0; $tPdtGroup < FCNnHSizeOf($aPackData[6]); $tPdtGroup++) {
                    $aPdtGroup = array(
                        'FTTmpTableKey'     => 'TCNMPdtGrp',
                        'FTAgnCode'         => FCNoGetCookieVal("tSesUsrAgnCode"),
                        'FNTmpSeq'          => $tPdtGroup + 1,
                        'FTPgpChain'        => $aPackData[6][$tPdtGroup][0],
                        'FTPgpName'         => $aPackData[6][$tPdtGroup][1],
                        'FTSessionID'       => FCNoGetCookieVal("tSesSessionID"),
                        'FTTmpStatus'       => (isset($aPackData[6][$tPdtGroup][2]) == '') ? '' : $aPackData[6][$tPdtGroup][2],
                        'FTTmpRemark'       => (isset($aPackData[6][$tPdtGroup][3]) == '') ? '' : $aPackData[6][$tPdtGroup][3],
                        'FDCreateOn'        => date('Y-m-d')
                    );
                    array_push($aSumSheetPdtGroup, $aPdtGroup);
                }

                //Insert ?????? Tmp ????????????
                $this->mCommon->FCNaMCMMImportExcelToTmp($aWhereData, $aSumSheetPdtGroup);

                //validate ???????????????????????????????????????????????? Tmp _ ?????????????????????????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPgpChain'
                );
                FCNnMasTmpChkCodeDupInTemp($aValidateData);

                //validate ???????????????????????????????????????????????????????????????????????????????????? _ ?????????????????????????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPgpChain',
                    'tTableName'        => 'TCNMPdtGrp'
                );
                FCNnMasTmpChkCodeDupInDB($aValidateData);
            }

            //??????????????? ??????????????????????????????
            $aSumSheetPdtModel = array();
            if (isset($aPackData[5])) {
                for ($tPdtModel = 0; $tPdtModel < FCNnHSizeOf($aPackData[5]); $tPdtModel++) {
                    $aPdtModel = array(
                        'FTTmpTableKey'     => 'TCNMPdtModel',
                        'FTAgnCode'         => FCNoGetCookieVal("tSesUsrAgnCode"),
                        'FNTmpSeq'          => $tPdtModel + 1,
                        'FTPmoCode'         => $aPackData[5][$tPdtModel][0],
                        'FTPmoName'         => $aPackData[5][$tPdtModel][1],
                        'FTSessionID'       => FCNoGetCookieVal("tSesSessionID"),
                        'FTTmpStatus'       => (isset($aPackData[5][$tPdtModel][2]) == '') ? '' : $aPackData[5][$tPdtModel][2],
                        'FTTmpRemark'       => (isset($aPackData[5][$tPdtModel][3]) == '') ? '' : $aPackData[5][$tPdtModel][3],
                        'FDCreateOn'        => date('Y-m-d')
                    );
                    array_push($aSumSheetPdtModel, $aPdtModel);
                }

                //Insert ?????? Tmp ????????????
                $this->mCommon->FCNaMCMMImportExcelToTmp($aWhereData, $aSumSheetPdtModel);

                //validate ???????????????????????????????????????????????? Tmp _ ??????????????????????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPmoCode'
                );
                FCNnMasTmpChkCodeDupInTemp($aValidateData);

                //validate ???????????????????????????????????????????????????????????????????????????????????? _ ??????????????????????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPmoCode',
                    'tTableName'        => 'TCNMPdtModel'
                );
                FCNnMasTmpChkCodeDupInDB($aValidateData);
            }

            //??????????????? ????????????????????????????????????
            $aSumSheetPdtType = array();
            if (isset($aPackData[4])) {
                for ($tPdtType = 0; $tPdtType < FCNnHSizeOf($aPackData[4]); $tPdtType++) {
                    $aPdtType = array(
                        'FTTmpTableKey'     => 'TCNMPdtType',
                        'FTAgnCode'         => FCNoGetCookieVal("tSesUsrAgnCode"),
                        'FNTmpSeq'          => $tPdtType + 1,
                        'FTPtyCode'         => $aPackData[4][$tPdtType][0],
                        'FTPtyName'         => $aPackData[4][$tPdtType][1],
                        'FTSessionID'       => FCNoGetCookieVal("tSesSessionID"),
                        'FTTmpStatus'       => (isset($aPackData[4][$tPdtType][2]) == '') ? '' : $aPackData[4][$tPdtType][2],
                        'FTTmpRemark'       => (isset($aPackData[4][$tPdtType][3]) == '') ? '' : $aPackData[4][$tPdtType][3],
                        'FDCreateOn'        => date('Y-m-d')
                    );
                    array_push($aSumSheetPdtType, $aPdtType);
                }

                //Insert ?????? Tmp ????????????
                $this->mCommon->FCNaMCMMImportExcelToTmp($aWhereData, $aSumSheetPdtType);

                //validate ???????????????????????????????????????????????? Tmp _ ????????????????????????????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPtyCode'
                );
                FCNnMasTmpChkCodeDupInTemp($aValidateData);

                //validate ???????????????????????????????????????????????????????????????????????????????????? _ ????????????????????????????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPtyCode',
                    'tTableName'        => 'TCNMPdtType'
                );
                FCNnMasTmpChkCodeDupInDB($aValidateData);
            }

            //??????????????? ??????????????????
            $aSumSheetBrand = array();
            if (isset($aPackData[3])) {
                for ($tBrand = 0; $tBrand < FCNnHSizeOf($aPackData[3]); $tBrand++) {
                    $aBrand = array(
                        'FTTmpTableKey'     => 'TCNMPdtBrand',
                        'FTAgnCode'         => FCNoGetCookieVal("tSesUsrAgnCode"),
                        'FNTmpSeq'          => $tBrand + 1,
                        'FTPbnCode'         => $aPackData[3][$tBrand][0],
                        'FTPbnName'         => $aPackData[3][$tBrand][1],
                        'FTSessionID'       => FCNoGetCookieVal("tSesSessionID"),
                        'FTTmpStatus'       => (isset($aPackData[3][$tBrand][2]) == '') ? '' : $aPackData[3][$tBrand][2],
                        'FTTmpRemark'       => (isset($aPackData[3][$tBrand][3]) == '') ? '' : $aPackData[3][$tBrand][3],
                        'FDCreateOn'        => date('Y-m-d')
                    );
                    array_push($aSumSheetBrand, $aBrand);
                }

                //Insert ?????? Tmp ????????????
                $this->mCommon->FCNaMCMMImportExcelToTmp($aWhereData, $aSumSheetBrand);

                //validate ???????????????????????????????????????????????? Tmp _ ??????????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPbnCode'
                );
                FCNnMasTmpChkCodeDupInTemp($aValidateData);

                //validate ???????????????????????????????????????????????????????????????????????????????????? _ ??????????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPbnCode',
                    'tTableName'        => 'TCNMPdtBrand'
                );
                FCNnMasTmpChkCodeDupInDB($aValidateData);
            }

            //??????????????? ?????????????????????????????????
            $aSumSheetUnit = array();
            if (isset($aPackData[2])) {
                for ($tUnit = 0; $tUnit < FCNnHSizeOf($aPackData[2]); $tUnit++) {
                    $aUnit = array(
                        'FTTmpTableKey'     => 'TCNMPdtUnit',
                        'FTAgnCode'         => FCNoGetCookieVal("tSesUsrAgnCode"),
                        'FNTmpSeq'          => $tUnit + 1,
                        'FTPunCode'         => $aPackData[2][$tUnit][0],
                        'FTPunName'         => $aPackData[2][$tUnit][1],
                        'FTSessionID'       => FCNoGetCookieVal("tSesSessionID"),
                        'FTTmpStatus'       => (isset($aPackData[2][$tUnit][2]) == '') ? '' : $aPackData[2][$tUnit][2],
                        'FTTmpRemark'       => (isset($aPackData[2][$tUnit][3]) == '') ? '' : $aPackData[2][$tUnit][3],
                        'FDCreateOn'        => date('Y-m-d')
                    );
                    array_push($aSumSheetUnit, $aUnit);
                }

                //Insert ?????? Tmp ????????????
                $this->mCommon->FCNaMCMMImportExcelToTmp($aWhereData, $aSumSheetUnit);

                //validate ???????????????????????????????????????????????? Tmp _ ?????????????????????????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPunCode'
                );
                FCNnMasTmpChkCodeDupInTemp($aValidateData);

                //validate ???????????????????????????????????????????????????????????????????????????????????? _ ?????????????????????????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPunCode',
                    'tTableName'        => 'TCNMPdtUnit'
                );
                FCNnMasTmpChkCodeDupInDB($aValidateData);
            }

            //??????????????? ????????????????????????????????????
            $aSumSheetPDT   = array();
            $aPackPdtSpcBch = array();
            $aPdtCallBackFunction = array();
            $aPdtDupBarCallBackFunction = array();
            if (isset($aPackData[1])) {
                for ($tPDT = 0; $tPDT < FCNnHSizeOf($aPackData[1]); $tPDT++) {
                    $aPDT = array(
                        'FTTmpTableKey'     => 'TCNMPdt',
                        'FTAgnCode'         => FCNoGetCookieVal("tSesUsrAgnCode"),
                        'FNTmpSeq'          => $tPDT + 1,
                        'FTPdtCode'         => (isset($aPackData[1][$tPDT][0]) == '') ? '' : trim($aPackData[1][$tPDT][0]),
                        'FTPdtName'         => (isset($aPackData[1][$tPDT][1]) == '') ? '' : $aPackData[1][$tPDT][1],
                        'FTPdtNameABB'      => (isset($aPackData[1][$tPDT][2]) == '') ? '' : $aPackData[1][$tPDT][2],
                        'FTPunCode'         => (isset($aPackData[1][$tPDT][3]) == '') ? '' : $aPackData[1][$tPDT][3],
                        'FCPdtUnitFact'     => (isset($aPackData[1][$tPDT][4]) == '') ? '' : $aPackData[1][$tPDT][4],
                        'FTBarCode'         => (isset($aPackData[1][$tPDT][5]) == '') ? '' : $aPackData[1][$tPDT][5],
                        'FTPbnCode'         => (isset($aPackData[1][$tPDT][6]) == '') ? '' : $aPackData[1][$tPDT][6],
                        'FTPdtStaVat'       => (isset($aPackData[1][$tPDT][7]) == '') ? '' : $aPackData[1][$tPDT][7],
                        'FTPtyCode'         => (isset($aPackData[1][$tPDT][8]) == '') ? '' : $aPackData[1][$tPDT][8],
                        'FTPmoCode'         => (isset($aPackData[1][$tPDT][9]) == '') ? '' : $aPackData[1][$tPDT][9],
                        'FTPgpChain'        => (isset($aPackData[1][$tPDT][10]) == '') ? '' : $aPackData[1][$tPDT][10],
                        'FTTcgCode'         => (isset($aPackData[1][$tPDT][11]) == '') ? '' : $aPackData[1][$tPDT][11],
                        'FTSessionID'       => FCNoGetCookieVal("tSesSessionID"),
                        'FTTmpStatus'       => (isset($aPackData[1][$tPDT][12]) == '') ? '' : $aPackData[1][$tPDT][12],
                        'FTTmpRemark'       => (isset($aPackData[1][$tPDT][13]) == '') ? '' : $aPackData[1][$tPDT][13],
                        'FDCreateOn'        => date('Y-m-d')
                    );
                    array_push($aSumSheetPDT, $aPDT);

                    if (FCNoGetCookieVal("bIsHaveAgn")) {
                        $aPdtSpcBch = array(
                            'FTTmpTableKey'     => 'TCNMPdtSpcBch',
                            'FTPdtCode'         => (isset($aPackData[1][$tPDT][0]) == '') ? '' : trim($aPackData[1][$tPDT][0]),
                            'FTTmpStatus'       => (isset($aPackData[1][$tPDT][12]) == '') ? '' : $aPackData[1][$tPDT][12],
                            'FTAgnCode'         => FCNoGetCookieVal("tSesUsrAgnCode"),
                            'FTSessionID'       => FCNoGetCookieVal("tSesSessionID"),
                            'FDCreateOn'        => date('Y-m-d')
                        );
                        array_push($aPackPdtSpcBch, $aPdtSpcBch);
                    }
                }



                //Insert ?????? Tmp ????????????
                $this->mCommon->FCNaMCMMImportExcelToTmp($aWhereData, $aSumSheetPDT);

                //????????????????????????????????? SpcBCH
                if (FCNnHSizeOf($aPackPdtSpcBch) > 0) {
                    $this->mCommon->FCNaMCMMImportExcelToTmp($aWhereData, $aPackPdtSpcBch);
                }

                //validate ???????????????????????????????????????????????? Tmp - ?????????????????????????????????????????????????????? ?????? PDT ???????????????????????? 
                // $aValidateData = array(
                //     'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                //     'aFieldName'        => ['FTPdtCode','FTBarCode']
                // );
                // FCNnDocTmpChkCodeMultiDupInTemp($aValidateData,$aWhereData);

                //validate ?????????????????????????????????????????????????????????????????????????????????????????????????????? AD ????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPdtCode',
                    'tTableCheck'       => 'TCNMPdt'
                );
                FCNnMasTmpChkCodeDupInDBSpecial($aValidateData);

                //validate ????????????????????????????????????????????? AD ??????????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPdtCode',
                    'tTableCheck'       => 'TCNMPdt_AD'
                );
                FCNnMasTmpChkCodeDupInDBSpecial($aValidateData);

                // Check ???????????????????????????????????????????????? Temp ???????????????????????????????????????????????????????????? master (?????????????????????????????????)
                // $aValidateData = array(
                //     'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                //     'tFieldName'        => 'FTPdtCode',
                //     'tTableCheck'       => 'TCNMPdtPackSize'
                // );
                // FCNnMasTmpChkCodeDupInDBSpecial($aValidateData);

                // Check ??????????????????????????????????????????????????????????????? Temp ???????????????????????????????????????????????????????????? master (?????????????????????????????????)
                // $aValidateData = array(
                //     'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                //     'tFieldName'        => 'FTPdtCode',
                //     'tTableCheck'       => 'TCNMPdtBar'
                // );
                // FCNnMasTmpChkCodeDupInDBSpecial($aValidateData);

                //Check ?????????????????????????????????????????? Temp ???????????????????????????????????????????????????????????? master (?????????????????????????????????????????????????????????????????????)
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPunCode',
                    'tTableCheck'       => 'TCNMPdtUnit'
                );
                FCNnMasTmpChkCodeDupInDBSpecial($aValidateData);

                // Check ????????????????????????????????????????????????????????? Temp ???????????????????????????????????????????????????????????? master
                // $aValidateData = array(
                //     'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                //     'tFieldName'        => 'FTTcgCode',
                //     'tTableCheck'       => 'TCNMPdtTouchGrp'
                // );
                // FCNnMasTmpChkCodeDupInDBSpecial($aValidateData);

                //Check ?????????????????????????????? Temp ???????????????????????????????????????????????????????????? master
                // $aValidateData = array(
                //     'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                //     'tFieldName'        => 'FTPbnCode',
                //     'tTableCheck'       => 'TCNMPdtBrand'
                // );
                // FCNnMasTmpChkCodeDupInDBSpecial($aValidateData);
            }
        } else if( $tNameModule == 'printbarcode' ){

            // Last Update : Napat(Jame) 15/12/2022 ?????????????????????????????????????????? ?????????????????????????????? Excel ??????????????????????????????????????????????????????????????? ??????????????? 471 rows
            // ????????? loop insert ???????????? record ????????????????????? 1.4 ????????????
            // ????????????????????????????????? loop ????????? string ???????????? insert ?????????????????????????????? ????????? move ????????? Tmp ????????? ?????? Tmp ???????????? ????????????????????? 2.77 ??????????????????

            // 1. ????????????????????????????????? tmp ????????????????????????
            $this->mCommon->FCNaMCMMClearImportExcelInTmp($aWhereData); 

            // 2. ????????????????????? tmp ????????? ????????? insert ???????????????????????? excel ?????? tmp ?????????
            $this->mCommon->FCNaMCMMPrintBarInsertDatatoTmp($aPackData);
          
            // 3. ????????????????????????????????? Tmp ????????? ?????? insert ?????? Tmp ????????????
            $this->mCommon->FCNaMCMMListDataPrintBarCode($aImportParams);

            // 4. ???????????????????????????????????????????????????????????????????????? ???????????????????????????????????????????????? ?????????????????????????????????????????????????????????
            $aImpBarCut = $this->mCommon->FCNaMCMMPrintBarGetDataNotIn();
            $aReturnData = array(
                'aImpBarCut' => $aImpBarCut,
            );
            echo json_encode($aReturnData);
        } else if( $tNameModule == 'adjstkconfirm' ){
            for ($i = 1; $i < $nPackData; $i++) {
                $this->mAdjustStock->FSxMASTImportGetDTProduct($aPackData[$i],$aImportParams,$i);
            }
        } else {
            $aInsPackdata = array();
            $aInsFhnPackdata = array();
            $aPdtCallBackFunction = array();
            $aObjectPdtCallBack = array();
            $aPdtDupBarCallBackFunction = array();
            $aObjectPdtDupBaCallBack = array();
            if ($nPackData > 1) {

                $tDefAgnCode = FCNoGetCookieVal("tSesUsrAgnCode");
                $tStaUsrAgn  = FCNoGetCookieVal("tSesUsrLoginAgency");

                
                for ($i = 1; $i < $nPackData; $i++) {
                    switch ($tNameModule) {
                        case "branch":

                            // Create By : 17/11/2020 Napat(jame)
                            // ????????? Login ?????????????????? AD ??????????????? Session AD ?????? insert auto ????????????????????????????????????????????? insert ????????? AD ????????????
                            if ($tStaUsrAgn == '1') {
                                $tAgnCode = $tDefAgnCode;
                            } else {
                                $tAgnCode = $aPackData[$i][2];
                            }

                            $aObject = array(
                                'FTTmpTableKey'     => $tTableRefPK,
                                'FNTmpSeq'          => $i,
                                'FTBchCode'         => $aPackData[$i][0],
                                'FTBchName'         => (isset($aPackData[$i][1]) == '') ? '' : $aPackData[$i][1],
                                'FTAgnCode'         => $tAgnCode,
                                'FTPplCode'         => (isset($aPackData[$i][3]) == '') ? '' : $aPackData[$i][3],
                                'FTTmpStatus'       => (isset($aPackData[$i][4]) == '') ? '' : $aPackData[$i][4],
                                'FTTmpRemark'       => (isset($aPackData[$i][5]) == '') ? '' : $aPackData[$i][5],
                                'FTSessionID'       => FCNoGetCookieVal("tSesSessionID"),
                                'FDCreateOn'        => date('Y-m-d')
                            );
                            // print_r($aObject);
                            // die();
                            break;
                        case "adjprice":
                            $aObject = array(
                                'FTBchCode'         => FCNoGetCookieVal("tSesUsrBchCodeDefault"),
                                'FTXthDocKey'       => $tTableRefPK,
                                'FNXtdSeqNo'        => $i,
                                'FTPdtCode'         => $aPackData[$i][0],
                                'FTPunCode'         => (isset($aPackData[$i][1]) == '') ? '' : $aPackData[$i][1],
                                'FCXtdPriceRet'     => (isset($aPackData[$i][2]) == '') ? '' : $aPackData[$i][2],
                                'FTTmpStatus'       => (isset($aPackData[$i][3]) == '') ? '' : $aPackData[$i][3],
                                'FTTmpRemark'       => (isset($aPackData[$i][4]) == '') ? '' : $aPackData[$i][4],
                                'FTSessionID'       => FCNoGetCookieVal("tSesSessionID"),
                                'FDCreateOn'        => date('Y-m-d')
                            );
                            break;
                        case "user":

                            // Create By : 17/11/2020 Napat(jame)
                            // ????????? Login ?????????????????? AD ??????????????? Session AD ?????? insert auto ????????????????????????????????????????????? insert ????????? AD ????????????
                            if ($tStaUsrAgn == '1') {
                                $tAgnCode = $tDefAgnCode;
                            } else {
                                $tAgnCode = $aPackData[$i][4];
                            }

                            $aObject = array(
                                'FTTmpTableKey'     => $tTableRefPK,
                                'FNTmpSeq'          => $i,
                                'FTUsrCode'         => $aPackData[$i][0],
                                'FTUsrName'         => (isset($aPackData[$i][1]) == '') ? '' : $aPackData[$i][1],
                                'FTBchCode'         => (isset($aPackData[$i][2]) == '') ? '' : $aPackData[$i][2],
                                'FTRolCode'         => (isset($aPackData[$i][3]) == '') ? '' : $aPackData[$i][3],
                                'FTAgnCode'         => $tAgnCode,
                                'FTMerCode'         => (isset($aPackData[$i][5]) == '') ? '' : $aPackData[$i][5],
                                'FTShpCode'         => (isset($aPackData[$i][6]) == '') ? '' : $aPackData[$i][6],
                                'FTDptCode'         => (isset($aPackData[$i][7]) == '') ? '' : $aPackData[$i][7],
                                'FTUsrTel'          => (isset($aPackData[$i][8]) == '') ? '' : $aPackData[$i][8],
                                'FTUsrEmail'        => (isset($aPackData[$i][9]) == '') ? '' : $aPackData[$i][9],
                                'FTTmpStatus'       => (isset($aPackData[$i][10]) == '') ? '' : $aPackData[$i][10],
                                'FTTmpRemark'       => (isset($aPackData[$i][11]) == '') ? '' : $aPackData[$i][11],
                                'FTSessionID'       => FCNoGetCookieVal("tSesSessionID"),
                                'FDCreateOn'        => date('Y-m-d')
                            );
                            break;
                        case "pos":
                            $aObject = array(
                                'FTTmpTableKey'     => $tTableRefPK,
                                'FNTmpSeq'          => $i,
                                'FTBchCode'         => $aPackData[$i][0],
                                'FTPosCode'         => $aPackData[$i][1],
                                'FTPosName'         => (isset($aPackData[$i][2]) == '') ? '' : $aPackData[$i][2],
                                'FTPosType'         => (isset($aPackData[$i][3]) == '') ? '' : $aPackData[$i][3],
                                'FTPosRegNo'        => (isset($aPackData[$i][4]) == '') ? '' : $aPackData[$i][4],
                                'FTTmpStatus'       => (isset($aPackData[$i][5]) == '') ? '' : $aPackData[$i][5],
                                'FTTmpRemark'       => (isset($aPackData[$i][6]) == '') ? '' : $aPackData[$i][6],
                                'FTSessionID'       => FCNoGetCookieVal("tSesSessionID"),
                                'FDCreateOn'        => date('Y-m-d')
                            );
                            break;
                        case "purchaseorder":

                            $tPdtCode = (isset($aPackData[$i][0]) == '') ? '' : $aPackData[$i][0];
                            $tPunCode = (isset($aPackData[$i][1]) == '') ? '' : $aPackData[$i][1];
                            $tBarCode = (isset($aPackData[$i][2]) == '') ? '' : $aPackData[$i][2];
                            $nSeqNo   = $i;
                            $cQty     = (isset($aPackData[$i][3]) == '') ? 0 : $aPackData[$i][3];
                            $cPrice   = (isset($aPackData[$i][4]) == '') ? 0 : $aPackData[$i][4];
                            $tErrType   = (isset($aPackData[$i][5]) == '') ? 0 : $aPackData[$i][5];
                            $tErrDes   = (isset($aPackData[$i][6]) == '') ? 0 : $aPackData[$i][6];
                            if ($tErrType == '1') {
                                $nSrnCode = '1';
                            } else {
                                $nSrnCode = '0';
                            }
                            $aDataPdtParams = array(
                                'tDocNo'            => '',
                                'tBchCode'          => FCNoGetCookieVal("tSesUsrBchCodeDefault"),
                                'tPdtCode'          => $tPdtCode,
                                'tBarCode'          => $tBarCode,
                                'tPunCode'          => $tPunCode,
                                'nLngID'            => FCNaHGetLangEdit()
                            );
                            $aDataPdtMaster = $this->mPurchaseOrder->FSaMPOGetDataPdt($aDataPdtParams);
                            if ($aDataPdtMaster['rtCode'] == '1') {
                                $aObject    = array(
                                    'FTBchCode'         => $tImportFrmBchCode,
                                    'FTXthDocNo'        => $tImportDocumentNo,
                                    'FNXtdSeqNo'        => $nSeqNo,
                                    'FTXthDocKey'       => $tTableRefPK,
                                    'FTPdtCode'         => $aDataPdtMaster['raItem']['FTPdtCode'],
                                    'FTXtdPdtName'      => $aDataPdtMaster['raItem']['FTPdtName'],
                                    'FCXtdFactor'       => $aDataPdtMaster['raItem']['FCPdtUnitFact'],
                                    'FTPunCode'         => $aDataPdtMaster['raItem']['FTPunCode'],
                                    'FTPunName'         => $aDataPdtMaster['raItem']['FTPunName'],
                                    'FTXtdBarCode'      => $tBarCode,
                                    'FTXtdVatType'      => $aDataPdtMaster['raItem']['FTPdtStaVatBuy'],
                                    // 'FTXtdVatType'      => $aDataPdtMaster['raItem']['FTPdtStaVat'],
                                    'FTVatCode'         => $tImportSplVatCode,
                                    'FCXtdVatRate'      => $tImportSplVatRate,
                                    'FTXtdStaAlwDis'    => $aDataPdtMaster['raItem']['FTPdtStaAlwDis'],
                                    'FTXtdSaleType'     => $aDataPdtMaster['raItem']['FTPdtSaleType'],
                                    'FCXtdSalePrice'    => $cPrice,
                                    'FCXtdQty'          => $cQty,
                                    'FCXtdQtyAll'       => $cQty * $aDataPdtMaster['raItem']['FCPdtUnitFact'],
                                    'FCXtdSetPrice'     => $cPrice * 1,
                                    'FCXtdNet'          => $cPrice * $cQty,
                                    'FCXtdNetAfHD'      => $cPrice * $cQty,
                                    'FTSrnCode'         => $nSrnCode,
                                    'FTSessionID'       => FCNoGetCookieVal("tSesSessionID"),
                                    'FDLastUpdOn'       => date('Y-m-d h:i:s'),
                                    'FTLastUpdBy'       => FCNoGetCookieVal('tSesUsername'),
                                    'FDCreateOn'        => date('Y-m-d h:i:s'),
                                    'FTCreateBy'        => FCNoGetCookieVal('tSesUsername'),
                                    'FTTmpRemark'       => $tErrDes,
                                );
                            } else {
                                $aObject    = array(
                                    'FTBchCode'         => $tImportFrmBchCode,
                                    'FTXthDocNo'        => $tImportDocumentNo,
                                    'FNXtdSeqNo'        => $nSeqNo,
                                    'FTXthDocKey'       => $tTableRefPK,
                                    'FTPdtCode'         => $tPdtCode,
                                    'FTXtdPdtName'      => NULL,
                                    'FCXtdFactor'       => NULL,
                                    'FTPunCode'         => $tPunCode,
                                    'FTPunName'         => NULL,
                                    'FTXtdBarCode'      => $tBarCode,
                                    'FTXtdVatType'      => '1',
                                    // 'FTXtdVatType'      => $aDataPdtMaster['raItem']['FTPdtStaVat'],
                                    'FTVatCode'         => $tImportSplVatCode,
                                    'FCXtdVatRate'      => $tImportSplVatRate,
                                    'FTXtdStaAlwDis'    => 0,
                                    'FTXtdSaleType'     => '1',
                                    'FCXtdSalePrice'    => $cPrice,
                                    'FCXtdQty'          => $cQty,
                                    'FCXtdQtyAll'       => $cQty * 1,
                                    'FCXtdSetPrice'     => $cPrice * 1,
                                    'FCXtdNet'          => $cPrice * $cQty,
                                    'FCXtdNetAfHD'      => $cPrice * $cQty,
                                    'FTSrnCode'         => '0',
                                    'FTSessionID'       => FCNoGetCookieVal("tSesSessionID"),
                                    'FDLastUpdOn'       => date('Y-m-d h:i:s'),
                                    'FTLastUpdBy'       => FCNoGetCookieVal('tSesUsername'),
                                    'FDCreateOn'        => date('Y-m-d h:i:s'),
                                    'FTCreateBy'        => FCNoGetCookieVal('tSesUsername'),
                                    'FTTmpRemark'       => language('document/purchaseorder/purchaseorder', 'tPONotFoundPdtCodeAndBarcodeImp'),
                                );
                            }
                            break;
                        case "purchaseinvoice":

                            $tPdtCodeOrBarCode = (isset($aPackData[$i][0]) == '') ? '' : $aPackData[$i][0];
                            $nSeqNo   = $i;
                            $cQty     = (isset($aPackData[$i][1]) == '') ? 0 : $aPackData[$i][1];
                            $cPrice   = (isset($aPackData[$i][2]) == '') ? 0 : $aPackData[$i][2];
                            $aObjectPdtCallBack = array();
                            $aObjectPdtDupBaCallBack = array();
                            $aDataPdtParams = array(
                                'tDocNo'            => '',
                                'tBchCode'          => $tImportFrmBchCode,
                                'tPdtCodeOrBarCode' => $tPdtCodeOrBarCode,
                                'nLngID'            => FCNaHGetLangEdit()
                            );

                            $aDataPdtMaster  = $this->mPurchaseInvoice->FSaMPIGetDataPdtByBarCode($aDataPdtParams);

                            if ($aDataPdtMaster['rtCode'] == '1') { //?????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????? ????????????????????????????????? ?????????????????????????????????????????????

                                if ($aDataPdtMaster['raItem']['FTPdtForSystem'] == '5') { //????????????????????????????????????????????????????????????

                                    $aResult = $this->mPurchaseInvoice->FSaMPIGetDuplicateBarCodeByPdtCode($aDataPdtParams);

                                    if ($aResult['rtCode'] != '800') { //?????????????????????????????????????????????????????????
                                        if ($aResult['rtCode'] == '1' && $aResult['raItem']['rnCountPdt'] > 1 && $aResult['raItem']['rnCountPdtRef'] > 1) { //?????????????????????????????????????????????????????????????????????????????? ????????????????????????????????????????????????????????? ????????????????????????????????????????????????????????????

                                            $aObjectPdtCallBack['pnPdtCode'] = $aDataPdtMaster['raItem']['FTPdtCode'];
                                            $aObjectPdtCallBack['ptPunCode'] = $aDataPdtMaster['raItem']['FTPunCode'];
                                            $aObjectPdtCallBack['ptBarCode'] = $aDataPdtMaster['raItem']['FTBarCode'];
                                            $aObjectPdtCallBack['packData'] = array(
                                                "PDTCode" => $aDataPdtMaster['raItem']['FTPdtCode'],
                                                'PUNCode' => $aDataPdtMaster['raItem']['FTPunCode'],
                                                'Barcode' => $aDataPdtMaster['raItem']['FTBarCode'],
                                                "PDTName" => $aDataPdtMaster['raItem']['FTPdtName'],
                                                "PDTSpc" => $aDataPdtMaster['raItem']['PDTSpc'],
                                            );
                                        }

                                        if ($aResult['rtCode'] == '2') {  //??????????????????????????????????????????????????????????????????????????????????????????
                                            $aObjectPdtDupBaCallBack['ptBarCode'] = $tPdtCodeOrBarCode;
                                            $aObjectPdtDupBaCallBack['pcQty']     = $cQty;
                                            $aObjectPdtDupBaCallBack['pcPrice']   = $cPrice;
                                            continue 2;
                                        }
                                    }
                                }
                            }

                            // echo $this->db->last_query();
                            if ($aDataPdtMaster['rtCode'] != '1') {
                                $aDataPdtMaster  = $this->mPurchaseInvoice->FSaMPIGetDataPdtByPdtCode($aDataPdtParams);
                                if ($aDataPdtMaster['rtCode'] == '1' && $aDataPdtMaster['raItem']['FTPdtForSystem'] == '5') {
                                    if ($aDataPdtMaster['raItem']['rnCountRefCode'] > 1) { //??????????????????????????????????????????????????????????????? 1 ??????????????????????????????????????????
                                        $aObjectPdtCallBack['pnPdtCode'] = $aDataPdtMaster['raItem']['FTPdtCode'];
                                        $aObjectPdtCallBack['ptPunCode'] = $aDataPdtMaster['raItem']['FTPunCode'];
                                        $aObjectPdtCallBack['ptBarCode'] = $aDataPdtMaster['raItem']['FTBarCode'];
                                        $aObjectPdtCallBack['packData'] = array(
                                            "PDTCode" => $aDataPdtMaster['raItem']['FTPdtCode'],
                                            'PUNCode' => $aDataPdtMaster['raItem']['FTPunCode'],
                                            'Barcode' => $aDataPdtMaster['raItem']['FTBarCode'],
                                            "PDTName" => $aDataPdtMaster['raItem']['FTPdtName'],
                                            "PDTSpc" => $aDataPdtMaster['raItem']['PDTSpc'],
                                        );
                                    }
                                }
                            }
                            // echo $this->db->last_query();
                            // die();


                            //  echo $this->db->last_query();
                            //  die();
                            $aObjectFahsion = array();

                            if ($aDataPdtMaster['rtCode'] == '1') {

                                $aObject    = array(
                                    'FTBchCode'         => $tImportFrmBchCode,
                                    'FTXthDocNo'        => $tImportDocumentNo,
                                    'FNXtdSeqNo'        => $nSeqNo,
                                    'FTXthDocKey'       => $tTableRefPK,
                                    'FTPdtCode'         => $aDataPdtMaster['raItem']['FTPdtCode'],
                                    'FTXtdPdtName'      => $aDataPdtMaster['raItem']['FTPdtName'],
                                    'FCXtdFactor'       => $aDataPdtMaster['raItem']['FCPdtUnitFact'],
                                    'FTPunCode'         => $aDataPdtMaster['raItem']['FTPunCode'],
                                    'FTPunName'         => $aDataPdtMaster['raItem']['FTPunName'],
                                    'FTXtdBarCode'      => $aDataPdtMaster['raItem']['FTBarCode'],
                                    'FTXtdVatType'      => $aDataPdtMaster['raItem']['FTPdtStaVatBuy'],
                                    // 'FTXtdVatType'      => $aDataPdtMaster['raItem']['FTPdtStaVat'],
                                    'FTVatCode'         => $aDataPdtMaster['raItem']['FTVatCode'],
                                    'FCXtdVatRate'      => $aDataPdtMaster['raItem']['FCVatRate'],
                                    'FTXtdStaAlwDis'    => $aDataPdtMaster['raItem']['FTPdtStaAlwDis'],
                                    'FTXtdSaleType'     => $aDataPdtMaster['raItem']['FTPdtSaleType'],
                                    'FCXtdSalePrice'    => $cPrice,
                                    'FCXtdQty'          => $cQty,
                                    'FCXtdQtyAll'       => $cQty * $aDataPdtMaster['raItem']['FCPdtUnitFact'],
                                    'FCXtdSetPrice'     => $cPrice * 1,
                                    'FCXtdNet'          => $cPrice * $cQty,
                                    'FCXtdNetAfHD'      => $cPrice * $cQty,
                                    'FTSrnCode'         => 1,
                                    'FTTmpStatus'       => $aDataPdtMaster['raItem']['FTPdtForSystem'],
                                    'FTSessionID'       => FCNoGetCookieVal("tSesSessionID"),
                                    'FDLastUpdOn'       => date('Y-m-d h:i:s'),
                                    'FTLastUpdBy'       => FCNoGetCookieVal('tSesUsername'),
                                    'FDCreateOn'        => date('Y-m-d h:i:s'),
                                    'FTCreateBy'        => FCNoGetCookieVal('tSesUsername'),
                                );

                                if ($aDataPdtMaster['raItem']['FTPdtForSystem'] == '5') { //???????????????????????????????????????????????????????????? ????????????????????? DTFhn ????????????
                                    $tFhnRefCode = $aDataPdtMaster['raItem']['FTFhnRefCode'];
                                    $aObjectFahsion = array(
                                        'FTBchCode'         => $tImportFrmBchCode,
                                        'FTXshDocNo'        => $tImportDocumentNo,
                                        'FNXsdSeqNo'        => $nSeqNo,
                                        'FTXthDocKey'       => $tTableRefPK,
                                        'FTPdtCode'         => $aDataPdtMaster['raItem']['FTPdtCode'],
                                        'FTXtdPdtName'      => $aDataPdtMaster['raItem']['FTPdtName'],
                                        'FCXtdQty'          => $cQty,
                                        'FTFhnRefCode'      => $tFhnRefCode,
                                        'FTSessionID'       => FCNoGetCookieVal("tSesSessionID"),
                                        'FDCreateOn'        => date('Y-m-d h:i:s'),
                                        'FTCreateBy'        => FCNoGetCookieVal('tSesUsername'),
                                    );
                                }
                            } else {
                                $aObject    = array(
                                    'FTBchCode'         => $tImportFrmBchCode,
                                    'FTXthDocNo'        => $tImportDocumentNo,
                                    'FNXtdSeqNo'        => $nSeqNo,
                                    'FTXthDocKey'       => $tTableRefPK,
                                    'FTPdtCode'         => $tPdtCodeOrBarCode,
                                    'FTXtdPdtName'      => NULL,
                                    'FCXtdFactor'       => NULL,
                                    'FTPunCode'         => NULL,
                                    'FTPunName'         => NULL,
                                    'FTXtdBarCode'      => $tPdtCodeOrBarCode,
                                    'FTXtdVatType'      => '1',
                                    'FTVatCode'         => NULL,
                                    'FCXtdVatRate'      => '7.0000',
                                    'FTXtdStaAlwDis'    => 0,
                                    'FTXtdSaleType'     => '1',
                                    'FCXtdSalePrice'    => $cPrice,
                                    'FCXtdQty'          => $cQty,
                                    'FCXtdQtyAll'       => $cQty * 1,
                                    'FCXtdSetPrice'     => $cPrice * 1,
                                    'FCXtdNet'          => $cPrice * $cQty,
                                    'FCXtdNetAfHD'      => $cPrice * $cQty,
                                    'FTSrnCode'         => 0,
                                    'FTTmpStatus'       => 1,
                                    'FTSessionID'       => FCNoGetCookieVal("tSesSessionID"),
                                    'FDLastUpdOn'       => date('Y-m-d h:i:s'),
                                    'FTLastUpdBy'       => FCNoGetCookieVal('tSesUsername'),
                                    'FDCreateOn'        => date('Y-m-d h:i:s'),
                                    'FTCreateBy'        => FCNoGetCookieVal('tSesUsername'),
                                );
                            }
                            break;
                        case "adjcost":
                            $aObject = array(
                                'FTBchCode'         => FCNoGetCookieVal("tSesUsrBchCodeDefault"),
                                'FTXthDocKey'       => $tTableRefPK,
                                'FNXtdSeqNo'        => $i,
                                'FTPdtCode'         => $aPackData[$i][0],
                                'FTPunCode'         => (isset($aPackData[$i][1]) == '') ? '' : $aPackData[$i][1],
                                'FCXtdCostEx'       => (isset($aPackData[$i][2]) == '') ? '' : $aPackData[$i][2],
                                'FTTmpStatus'       => (isset($aPackData[$i][3]) == '') ? '' : $aPackData[$i][3],
                                'FTTmpRemark'       => (isset($aPackData[$i][4]) == '') ? '' : $aPackData[$i][4],
                                'FTSessionID'       => FCNoGetCookieVal("tSesSessionID"),
                                'FDCreateOn'        => date('Y-m-d')
                            );
                            break;
                        // case "printbarcode":
                        //     $tIP = $this->input->ip_address();
                        //     $tFullHost = gethostbyaddr($tIP);

                        //     // if ($tLblCode == 'L003') {
                        //     //     $nLangPrint = 2;
                        //     // } else {
                        //     //     $nLangPrint = 1;
                        //     // }
                        //     $aDataPdt = $this->mCommon->FCNaMCMMListDataPrintBarCode($aPackData[$i], $aImportParams);

                        //     // if ($aPackData[$i][2] != 1) {
                        //     //     $nPlbStaSelect = null;
                        //     // } else {
                        //     //     $nPlbStaSelect = 1;
                        //     // }

                        //     // $aDataPdt['FTPlbStaImport'] = (isset($aPackData[$i][2]) == '') ? '' : $aPackData[$i][2];
                        //     // $aDataPdt['FTPlbImpDesc']   = (isset($aPackData[$i][3]) == '') ? '' : $aPackData[$i][3];
                        //     // $aDataPdt['FNPlbQty']       = (isset($aPackData[$i][1]) == '') ? '' : $aPackData[$i][1];
                        //     $aObject = $aDataPdt;

                        //     // $aObject = array(
                        //     //     'FTComName' =>  $tFullHost,
                        //     //     'FTPdtCode'         =>  $aDataPdt[0]['FTPdtCode'],
                        //     //     'FNPlbQty'         => (isset($aPackData[$i][1]) == '') ? '' : $aPackData[$i][1],
                        //     //     'FTPdtName' =>  $aDataPdt[0]['FTPdtName'],
                        //     //     'FTBarCode' => $aPackData[$i][0],
                        //     //     'FCPdtPrice' =>  $aDataPdt[0]['FCPdtPrice'],
                        //     //     'FDPrnDate' =>  $aDataPdt[0]['FDPrnDate'],
                        //     //     'FTPdtContentUnit' =>  $aDataPdt[0]['FTPdtContentUnit'],
                        //     //     'FTPlbCode' =>  $aDataPdt[0]['FTPlbCode'],
                        //     //     'FTPbnDesc' =>  $aDataPdt[0]['FTPbnDesc'],
                        //     //     'FTPdtTime' =>  $aDataPdt[0]['FTPdtTime'],
                        //     //     'FTPdtMfg' =>  $aDataPdt[0]['FTPdtMfg'],
                        //     //     'FTPdtImporter' =>  $aDataPdt[0]['FTPdtImporter'],
                        //     //     'FTPdtRefNo' =>  $aDataPdt[0]['FTPdtRefNo'],
                        //     //     'FTPdtValue' =>  $aDataPdt[0]['FTPdtValue'],
                        //     //     'FTPlbUrl' =>  $aDataPdt[0]['FTPlbUrl'],
                        //     //     'FTPlbPriType' => $aDataPdt[0]['FTPlbPriType'],
                        //     //     'FTPlcCode' => $aDataPdt[0]['FTPlcCode'],
                        //     //     'FTPdtNameOth' => $aDataPdt[0]['FTPdtNameOth'],
                        //     //     'FTPlbSubDept' => $aDataPdt[0]['FTPlbSubDept'],
                        //     //     'FTPlbRepleType' => $aDataPdt[0]['FTPlbRepleType'],
                        //     //     'FTPlbPriStatus' => $aDataPdt[0]['FTPlbPriStatus'],
                        //     //     'FTPlbSellingUnit' => $aDataPdt[0]['FTPlbSellingUnit'],
                        //     //     'FCPdtOldPrice' => $aDataPdt[0]['FCPdtOldPrice'],
                        //     //     'FTPlbPhasing' => $aDataPdt[0]['FTPlbPhasing'],
                        //     //     'FTPlbPriPerUnit' => $aDataPdt[0]['FTPlbPriPerUnit'],
                        //     //     'FTPlbCapFree' => $aDataPdt[0]['FTPlbCapFree'],
                        //     //     'FTPlbPdtChain' => $aDataPdt[0]['FTPlbPdtChain'],
                        //     //     // 'FTPlbCapNamePmt' => $aDataPdt[0]['FTPlbCapNamePmt'],
                        //     //     // 'FTPlbPmtInterval' => $aDataPdt[0]['FTPlbCapNamePmt'],
                        //     //     // 'FCPlbPmtGetCond' => $aDataPdt[0]['FCPlbPmtGetCond'],
                        //     //     // 'FCPlbPmtGetValue' => $aDataPdt[0]['FCPlbPmtGetCond'],
                        //     //     'FDPlbPmtDStart' => $aDataPdt[0]['FDPlbPmtDStart'],
                        //     //     'FDPlbPmtDStop' => $aDataPdt[0]['FDPlbPmtDStop'],
                        //     //     // 'FTPlbPmtCode' => $aDataPdt[0]['FTPlbPmtCode'],
                        //     //     // 'FCPlbPmtBuyQty' => $aDataPdt[0]['FCPlbPmtBuyQty'],
                        //     //     'FTPlbClrName' => $aDataPdt[0]['FTPlbClrName'],
                        //     //     'FTPlbPszName' => $aDataPdt[0]['FTPlbPszName'],
                        //     //     // 'FTPlbStaSelect' =>  $aDataPdt[0]['FTPlbStaSelect'],
                        //     //     'FTPlbStaSelect' =>  $nPlbStaSelect,
                        //     //     'FTPlbStaImport'       => (isset($aPackData[$i][2]) == '') ? '' : $aPackData[$i][2],
                        //     //     'FTPlbImpDesc'       => (isset($aPackData[$i][3]) == '') ? '' : $aPackData[$i][3],
                        //     // );

                        //     break;
                        case "coupon":

                            $aStoreParam = array(
                                "tTblName"    => 'TFNTCouponHD',                           
                                "tDocType"    => 0,                                          
                                "tBchCode"    => FCNoGetCookieVal("tSesUsrBchCodeDefault"),                                 
                                "tShpCode"    => "",                               
                                "tPosCode"    => "",                     
                                "dDocDate"    => date("Y-m-d H:i:s")       
                            );
                            $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);

                            $this->mCommon->FCNaMCMMClearImportExcelInTmp($aWhereData); // ????????????????????????????????? tmp ????????????
                            $aWhereData['tFlagClearTmp'] = 2; // ???????????????????????????????????????????????? tmp

                            // echo "<pre>"; print_r($aPackData); echo "</pre>";

                            if (isset($aPackData[0])) { // ???????????? ????????????????????????
                                $aSumSheet0 = array();
                                for ($nIndex = 0; $nIndex < FCNnHSizeOf($aPackData[0]); $nIndex++) {
                                    $aTab0 = array(
                                        'FTBchCode'             => FCNoGetCookieVal("tSesUsrBchCodeDefault"),
                                        'FTCphDocNo'            => $aAutogen[0]["FTXxhDocNo"],
                                        'FTCptCode'             => $aPackData[0][$nIndex][0],
                                        'FTCpnName'             => $aPackData[0][$nIndex][1],
                                        'FTCphRefAccCode'	    => $aPackData[0][$nIndex][2],
                                        'FTCpnMsg1'             => $aPackData[0][$nIndex][3],
                                        'FTCpnMsg2'             => $aPackData[0][$nIndex][4],
                                        'FTCphDisType'	        => $aPackData[0][$nIndex][5],
                                        'FTPplCode'	            => $aPackData[0][$nIndex][6],
                                        'FCCphDisValue'	        => (empty($aPackData[0][$nIndex][7])) ? 0 : $aPackData[0][$nIndex][7],
                                        'FDCphDateStart'	    => (empty($aPackData[0][$nIndex][8])) ? date("Y-m-d") : $aPackData[0][$nIndex][8],
                                        'FDCphDateStop'	        => (empty($aPackData[0][$nIndex][9])) ? date("Y-m-d") : $aPackData[0][$nIndex][9],
                                        'FTCphTimeStart'	    => (empty($aPackData[0][$nIndex][10])) ? '00:00:00' : $aPackData[0][$nIndex][10],
                                        'FTCphTimeStop'	        => (empty($aPackData[0][$nIndex][11])) ? '23:59:00' : $aPackData[0][$nIndex][11],
                                        'FCCphMinValue'	        => (empty($aPackData[0][$nIndex][12])) ? 0 : $aPackData[0][$nIndex][12],
                                        'FNCphLimitUsePerBill'  => (empty($aPackData[0][$nIndex][13])) ? 0 : $aPackData[0][$nIndex][13],
                                        'FTCphStaOnTopPmt'      => $aPackData[0][$nIndex][14],
                                        'FTStaChkMember'        => $aPackData[0][$nIndex][15],
                                        'FTCphStaClosed'        => '1',
                                        'FTUsrCode'             => FCNoGetCookieVal("tSesUsername"),
                                        'FDCphDocDate'          => date("Y-m-d H:i:s"),
                                        'FTCphUsrApv'           => null,
                                        'FTCphStaDoc'           => '1',
                                        'FTCphStaApv'           => '',
                                        'FTCphStaPrcDoc'	    => '',
                                        'FTCphStaDelMQ'	        => '',
                                        'FTTmpStatus'           => (empty($aPackData[0][$nIndex][16])) ? '' : $aPackData[0][$nIndex][16],
                                        'FTTmpRemark'           => (empty($aPackData[0][$nIndex][17])) ? '' : $aPackData[0][$nIndex][17],
                                        'FTSessionID'           => FCNoGetCookieVal("tSesSessionID"),
                                        'FDCreateOn'            => date("Y-m-d H:i:s"),
                                        'FTTmpTableKey'         => 'TFNTCouponHD',
                                        'FNTmpSeq'              => $nIndex + 1,
                                    );
                                    array_push($aSumSheet0, $aTab0);
                                }
                                $this->mCommon->FCNaMCMMImportExcelToTmp($aWhereData, $aSumSheet0);
                            }

                            if (isset($aPackData[1])) { // ???????????? ??????????????????????????????
                                $aSumSheet1 = array();
                                for ($nIndex = 0; $nIndex < FCNnHSizeOf($aPackData[1]); $nIndex++) {
                                    $aTab1 = array(
                                        'FTBchCode'             => FCNoGetCookieVal("tSesUsrBchCodeDefault"),
                                        'FTCphDocNo'            => $aAutogen[0]["FTXxhDocNo"],
                                        'FTCpdBarCpn'           => (empty($aPackData[1][$nIndex][0])) ? '' : $aPackData[1][$nIndex][0],
                                        'FNCpdSeqNo'            => $nIndex + 1,
                                        'FNCpdAlwMaxUse'        => (empty($aPackData[1][$nIndex][1])) ? '' : $aPackData[1][$nIndex][1],
                                        'FTTmpStatus'           => (empty($aPackData[1][$nIndex][2])) ? '' : $aPackData[1][$nIndex][2],
                                        'FTTmpRemark'           => (empty($aPackData[1][$nIndex][3])) ? '' : $aPackData[1][$nIndex][3],
                                        'FTSessionID'           => FCNoGetCookieVal("tSesSessionID"),
                                        'FDCreateOn'            => date("Y-m-d H:i:s"),
                                        'FTTmpTableKey'         => 'TFNTCouponDT',
                                        'FNTmpSeq'              => $nIndex + 1,
                                    );
                                    array_push($aSumSheet1, $aTab1);
                                }
                                $this->mCommon->FCNaMCMMImportExcelToTmp($aWhereData, $aSumSheet1);
                            }
                            break;
                        // case "adjstkconfirm":
                           
                        //     $tUserLogin = $this->session->userdata('tSesUsername');
                        //     $aDataPdt = $this->mAdjustStock->FSaMASTImportGetDTProduct($aPackData[$i],$aImportParams);
                            
                        //     if( $aDataPdt['tCode'] == '1' ){
                        //         $aObject = array(
                        //             'FTBchCode'         => $aDataPdt['aItems']['FTBchCode'],
                        //             'FTXthDocNo'        => $aDataPdt['aItems']['FTXthDocNo'],
                        //             'FNXtdSeqNo'        => $i,
                        //             'FTXthDocKey'       => $tTableRefPK,
                        //             'FTPdtCode'         => $aDataPdt['aItems']['FTPdtCode'],
                        //             'FTXtdPdtName'      => $aDataPdt['aItems']['FTPdtName'],
                        //             'FTPunCode'         => $aDataPdt['aItems']['FTPunCode'],
                        //             'FTPunName'         => $aDataPdt['aItems']['FTPunName'],
                        //             'FTXtdBarCode'      => $aDataPdt['aItems']['FTBarCode'],
                        //             'FCPdtUnitFact'     => intval($aDataPdt['aItems']['FCPdtUnitFact']),
                        //             'FCAjdUnitQtyC1'    => intval($aDataPdt['aItems']['FCAjdUnitQtyC1']),
                        //             'FCAjdQtyAllC1'     => intval($aDataPdt['aItems']['FCAjdQtyAllC1']),
                        //             'FTAjdPlcCode'      => $aDataPdt['aItems']['FTAjdPlcCode'],
                        //             'FTSessionID'       => $this->session->userdata("tSesSessionID"),
                        //             'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                        //             'FDCreateOn'        => date('Y-m-d H:i:s'),
                        //             'FTLastUpdBy'       => $tUserLogin,
                        //             'FTCreateBy'        => $tUserLogin,
                        //             'FTTmpStatus'       => (empty($aPackData[$i][2])) ? '' : $aPackData[1][2],
                        //             'FTTmpRemark'       => (empty($aPackData[$i][3])) ? '' : $aPackData[1][3],
                        //         );
                        //     }else{
                        //         $aObject = array(
                        //             'FTBchCode'         => $aImportParams['tBchCode'],
                        //             'FTXthDocNo'        => $aImportParams['tDocNo'],
                        //             'FNXtdSeqNo'        => $i,
                        //             'FTXthDocKey'       => $tTableRefPK,
                        //             'FTPdtCode'         => 'N/A',
                        //             'FTXtdPdtName'      => 'N/A',
                        //             'FTPunCode'         => 'N/A',
                        //             'FTPunName'         => 'N/A',
                        //             'FTXtdBarCode'      => $aPackData[$i][0],
                        //             'FCPdtUnitFact'     => 0,
                        //             'FCAjdUnitQtyC1'    => intval($aPackData[$i][1]),
                        //             'FCAjdQtyAllC1'     => intval($aPackData[$i][1]),
                        //             'FTAjdPlcCode'      => 'N/A',
                        //             'FTSessionID'       => $this->session->userdata("tSesSessionID"),
                        //             'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                        //             'FDCreateOn'        => date('Y-m-d H:i:s'),
                        //             'FTLastUpdBy'       => $tUserLogin,
                        //             'FTCreateBy'        => $tUserLogin,
                        //             'FTTmpStatus'       => '3',
                        //             'FTTmpRemark'       => '???????????????????????????????????? VD',
                        //         );
                        //     }
                        //     break;
                    }


                    array_push($aInsPackdata, $aObject);
                    if (!empty($aObjectFahsion)) {
                        array_push($aInsFhnPackdata, $aObjectFahsion);
                    }

                    if (!empty($aObjectPdtCallBack)) {
                        array_push($aPdtCallBackFunction, $aObjectPdtCallBack);
                    }
                    if (!empty($aObjectPdtDupBaCallBack)) {
                        array_push($aPdtDupBarCallBackFunction, $aObjectPdtDupBaCallBack);
                    }
                }
            }


            // echo "<pre>"; print_r($aInsPackdata); exit;
            //Insert ?????? Tmp ????????????
            $this->mCommon->FCNaMCMMImportExcelToTmp($aWhereData, $aInsPackdata);
            if (!empty($aInsFhnPackdata)) {
                //Insert ?????? Tmp ????????????
                $this->mCommon->FCNaMCMMImportExcelToFhnTmp($aWhereData, $aInsFhnPackdata);
            }

            // if ($tNameModule == 'printbarcode') {
            //     $this->mCommon->FCNaMCMMListDataPrintBarCodeCheckValidate();
            // }

            $aReturnData = array(
                'aInsPackdata' => $aInsPackdata,
                'aInsFhnPackdata' => $aInsFhnPackdata,
                'aPdtCallBackFunction' => $aPdtCallBackFunction,
                'aPdtDupBarCallBackFunction' => $aPdtDupBarCallBackFunction,
            );
            // echo '<pre>';
            // print_r($aReturnData);
            // echo '</pre>';
            echo json_encode($aReturnData);
        }
        

        //Validate ???????????????????????????????????????????????? + ???????????????????????????????????????????????????????????????????????????
        switch ($tNameModule) {
            case "branch":
                //validate ???????????????????????????????????????????????? Tmp
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTBchCode'
                );
                FCNnMasTmpChkCodeDupInTemp($aValidateData);

                //validate ????????????????????????????????????????????????????????????????????????????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTBchCode',
                    'tTableName'        => 'TCNMBranch'
                );
                FCNnMasTmpChkCodeDupInDB($aValidateData);

                //validate ?????????????????????????????????????????????????????????????????? _ FTPplCode
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPplCode',
                    'tTableName'        => 'TCNMPdtPriList',
                    'tErrMsg'           => '????????????????????????????????????????????????????????????'
                );
                FCNnMasTmpChkCodeInDB($aValidateData);

                //validate ??????????????????????????????????????????????????????????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTAgnCode',
                    'tTableName'        => 'TCNMAgency',
                    'tErrMsg'           => '????????????????????????????????????????????????????????????'
                );
                FCNnMasTmpChkCodeInDB($aValidateData);
                break;
            case "adjprice":
                //validate ?????????????????????????????????????????????????????????????????? _ FTPdtCode
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPdtCode',
                    'tTableName'        => 'TCNMPDT',
                    'tErrMsg'           => '???????????????????????????????????????????????????'
                );
                FCNnDocTmpChkCodeInDB($aValidateData);

                //validate ?????????????????????????????????????????????????????????????????? _ FTPunCode
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPunCode',
                    'tTableName'        => 'TCNMPdtUnit',
                    'tErrMsg'           => '??????????????????????????????????????????????????????????????????'
                );
                FCNnDocTmpChkCodeInDB($aValidateData);

                //validate ???????????????????????????????????? temp
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'aFieldName'        => ['FTPdtCode', 'FTPunCode']
                );
                FCNnDocTmpChkCodeMultiDupInTemp($aValidateData, $aWhereData);
                break;
            case "user":

                //validate ???????????????????????????????????????????????? Tmp _ ??????????????????????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTUsrCode'
                );
                FCNnMasTmpChkCodeDupInTemp($aValidateData);

                //validate ???????????????????????????????????????????????????????????????????????????????????? _ ??????????????????????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTUsrCode',
                    'tTableName'        => 'TCNMUser'
                );
                FCNnMasTmpChkCodeDupInDB($aValidateData);

                //validate ?????????????????????????????????????????????????????????????????? _ ????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTBchCode',
                    'tTableName'        => 'TCNMBranch',
                    'tErrMsg'           => '?????????????????????????????????????????????????????????'
                );
                FCNnMasTmpChkCodeInDB($aValidateData);

                // Create By : 17/11/2020 Napat(jame) ????????????????????????????????????????????? ?????????????????????????????? Agency Code
                // validate ?????????????????????????????????????????????????????????????????? _ ???????????? + ???????????????????????????
                $aValidateData = array(
                    'tImportFrom'       => 'user',
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tTableName'        => 'TCNMBranch',
                    'aFieldName'        => ['FTBchCode', 'FTAgnCode'],
                    'tErrMsg'           => '???????????????????????????????????????????????????????????????????????????????????????????????????????????????'
                );
                FCNnMasTmpChkCodeMultiInDB($aValidateData, $aWhereData);

                //validate ?????????????????????????????????????????????????????????????????? _ ??????????????????????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTRolCode',
                    'tTableName'        => 'TCNMUsrRole',
                    'tErrMsg'           => '??????????????????????????????????????????????????????????????????'
                );
                FCNnMasTmpChkCodeInDB($aValidateData);

                //validate ?????????????????????????????????????????????????????????????????? _ ???????????????????????????????????????	
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTAgnCode',
                    'tTableName'        => 'TCNMAgency',
                    'tErrMsg'           => '????????????????????????????????????????????????????????????'
                );
                FCNnMasTmpChkCodeInDB($aValidateData);

                //validate ?????????????????????????????????????????????????????????????????? _ ?????????????????????????????????	
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTMerCode',
                    'tTableName'        => 'TCNMMerchant',
                    'tErrMsg'           => '??????????????????????????????????????????????????????????????????'
                );
                FCNnMasTmpChkCodeInDB($aValidateData);

                //validate ?????????????????????????????????????????????????????????????????? _ ?????????????????????	
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTShpCode',
                    'tTableName'        => 'TCNMShop_L',
                    'tErrMsg'           => '??????????????????????????????????????????????????????'
                );
                FCNnMasTmpChkCodeInDB($aValidateData);

                //validate ?????????????????????????????????????????????????????????????????? _ ????????????	
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTDptCode',
                    'tTableName'        => 'TCNMUsrDepart_L',
                    'tErrMsg'           => '?????????????????????????????????????????????'
                );
                FCNnMasTmpChkCodeInDB($aValidateData);
                break;
            case "pos":

                // ?????????????????????????????????????????????????????????????????????????????????????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTBchCode',
                    'tTableName'        => 'TCNMBranch',
                    'tErrMsg'           => '?????????????????????????????????????????????'
                );
                FCNnMasTmpChkCodeInDB($aValidateData);

                // ????????????????????????????????????????????????????????????????????? Temp
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'aFieldName'        => ['FTBchCode', 'FTPosCode']
                );
                FCNnMasTmpChkCodeMultiDupInTemp($aValidateData);

                // ????????????????????????????????????????????????????????????????????? Master
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tTableName'        => 'TCNMPos',
                    'aFieldName'        => ['FTBchCode', 'FTPosCode']
                );
                FCNnMasTmpChkCodeMultiDupInDB($aValidateData);
                break;
            case "purchaseorder":
                //validate ?????????????????????????????????????????????????????????????????? _ FTPdtCode
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPdtCode',
                    'tTableName'        => 'TCNMPDT',
                    'tErrMsg'           => '???????????????????????????????????????????????????'
                );
                FCNnDocTmpChkCodeInDB($aValidateData);

                //validate ?????????????????????????????????????????????????????????????????? _ FTPunCode
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPunCode',
                    'tTableName'        => 'TCNMPdtUnit',
                    'tErrMsg'           => '??????????????????????????????????????????????????????????????????'
                );
                FCNnDocTmpChkCodeInDB($aValidateData);

                //validate ?????????????????????????????????????????????????????????????????? _ FTBarCode
                // $aValidateData = array(
                //     'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                //     'tFieldName'        => 'FTXtdBarCode',
                //     'tTableName'        => 'TCNMPdtBar',
                //     'tErrMsg'           => '??????????????????????????????????????????????????????'
                // );
                // FCNnDocTmpChkCodeInDB($aValidateData);

                //validate ???????????????????????????????????? temp
                // $aValidateData = array(
                //     'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                //     'aFieldName'        => ['FTPdtCode','FTPunCode']
                // );
                // FCNnDocTmpChkCodeMultiDupInTemp($aValidateData,$aWhereData);
                break;
            case "purchaseinvoice":
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPdtCode',
                    'tTableName'        => 'TCNMPDT',
                    'tErrMsg'           => '???????????????????????????????????????????????????'
                );
                FCNnDocTmpChkCodeInDB($aValidateData);

                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPunCode',
                    'tTableName'        => 'TCNMPdtUnit',
                    'tErrMsg'           => '??????????????????????????????????????????????????????????????????'
                );
                FCNnDocTmpChkCodeInDB($aValidateData);
                break;
            case "adjcost":
                //validate ?????????????????????????????????????????????????????????????????? _ FTPdtCode
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPdtCode',
                    'tTableName'        => 'TCNMPDT',
                    'tErrMsg'           => '???????????????????????????????????????????????????'
                );
                FCNnDocTmpChkCodeInDB($aValidateData);

                //validate ?????????????????????????????????????????????????????????????????? _ FTPunCode
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTPunCode',
                    'tTableName'        => 'TCNMPdtUnit',
                    'tErrMsg'           => '??????????????????????????????????????????????????????????????????'
                );
                FCNnDocTmpChkCodeInDB($aValidateData);

                //validate ???????????????????????????????????? temp
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'aFieldName'        => ['FTPdtCode', 'FTPunCode']
                );
                FCNnDocTmpChkCodeMultiDupInTemp($aValidateData, $aWhereData);
                break;
            case "printbarcode":

                // $this->mCommon->FCNaMCMMListDataPrintBarCodeCheckValidate();
                //validate ?????????????????????????????????????????????????????????????????? _ FTPdtCode
                // $aValidateData = array(
                //     'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                //     'tFieldName'        => 'FTPdtCode',
                //     'tTableName'        => 'TCNMPDT',
                //     'tErrMsg'           => '???????????????????????????????????????????????????'
                // );
                // FCNnDocTmpChkCodeInDB($aValidateData);


                // //validate ???????????????????????????????????? temp
                // $aValidateData = array(
                //     'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
                //     'aFieldName'        => ['FTPdtCode', 'FTPunCode']
                // );
                // FCNnDocTmpChkCodeMultiDupInTemp($aValidateData, $aWhereData);
                break;
            case 'coupon':
                //Validate ???????????????????????????????????????????????? Tmp ???????????????????????????
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTCpdBarCpn',
                    'tTableKey'         => 'TFNTCouponDT',
                    'tTableTmp'         => 'TCNTImpCouponTmp'
                );
                FCNnMasTmpChkCodeDupInTemp($aValidateData);
                break;
        }
    }
}
