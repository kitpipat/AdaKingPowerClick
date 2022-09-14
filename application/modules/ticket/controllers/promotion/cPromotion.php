<?php

defined('BASEPATH') or exit('No direct script access allowed');

class cPromotion extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ticket/promotion/mPromotion', 'mPromotion');
        $this->load->library("session");
        date_default_timezone_set("Asia/Bangkok");
    }

    public function FSxCPMT() {
        $oAuthen = FCNaHCheckAlwFunc('EticketPromotion');
        $this->load->view('ticket/promotion/wPromotion', array(
            'oAuthen' => $oAuthen
        ));
    }

    public function FSxCPMTList() {
        $tFTPmtName = $this->input->post('tFTPmtName');
        $nPageNo = $this->input->post('nPageNo');
        $nPageActive = $nPageNo;
        $oPmtList = $this->mPromotion->FSxMPMTList($tFTPmtName, $nPageActive);
        $oAuthen = FCNaHCheckAlwFunc('EticketPromotion');
        $this->load->view('ticket/promotion/wPromotionList', array(
            'oAuthen' => $oAuthen,
            'oPmtList' => $oPmtList,
            'nPageNo'   => $nPageNo
        ));
    }

    public function FSxCPMTCount() {
        $tFTPmtName = $this->input->post('tFTPmtName');
        $oPMTCntSh = $this->mPromotion->FStMPMTCount($tFTPmtName);
        $tPMTCount = $oPMTCntSh [0]->counts;
        echo $tPMTCount;
    }

    public function FSxCPMTAdd() {
        $oBranch = $this->mPromotion->FSxMPMTBranch();
        $this->load->view('ticket/promotion/wAdd', array(
            'oBranch' => $oBranch,
        ));
    }

    public function FSxCPMTAddAjax() {
        if ($this->input->post('oetFTPmhName')) {
            $aData = array(
                'FTPmhCode'             => $this->input->post('oetFTPmhCode'),
                'FTPmhName'             => $this->input->post('oetFTPmhName'),
                'FCPmhBuyAmt'           => $this->input->post('oetFCPmhBuyAmt'),
                'FCPmhGetValue'         => $this->input->post('oetFCPmhGetValue'),
                'FCPmhGetCond'          => $this->input->post('ohdFCPmhGetCond'),
                'FTPmhClosed'           => $this->input->post('ocmFTPmhClosed'),
                'FDPmhActivate'         => FsxDate($this->input->post('oetFDPmhActivate')),
                'FDPmhExpired'          => FsxDate($this->input->post('oetFDPmhExpired')),
                'FDPmhTActivate'        => date('Y-m-d') . ' ' . $this->input->post('oetFDPmhTActivate'),
                'FDPmhTExpired'         => date('Y-m-d') . ' ' . $this->input->post('oetFDPmhTExpired'),
                'FTPmhStaSpcPdt'        => $this->input->post('ohdFTPmhStaSpcPdt'),
                'FTPmhStaSpcPark'       => $this->input->post('ohdFTPmhStaSpcPark'),
                'FTPmhStaSpcGrp'        => $this->input->post('ohdFTPmhStaSpcGrp')
            );

            $nPmtId = $this->mPromotion->FSxMPMTAdd($aData);
            $ohdFTPspStaExcludePkg = $this->input->post('ohdFTPspStaExcludePkg');
            $ohdFNPkgID = $this->input->post('ohdFNPkgID');
            if ($ohdFNPkgID != '') {
                foreach (@$ohdFNPkgID as $key => $tValue) {
                    $aSpcPdt = array(
                        'FNPmhID' => $nPmtId,
                        'FTPspRefType' => 2,
                        'FTPspStaExclude' => $ohdFTPspStaExcludePkg,
                        'FNPspCodeRef' => $ohdFNPkgID[$key],
                    );
                    $this->mPromotion->FSxMPMTSpcPdt($aSpcPdt);
                }
            }

            $ohdFTPspStaExcludeBch = $this->input->post('ohdFTPspStaExcludeBch');
            $ohdFNPmoID = $this->input->post('ohdFNPmoID');
            if ($ohdFNPmoID != '') {
                foreach (@$ohdFNPmoID as $key => $tValue) {
                    $aSpcPark = array(
                        'FNPmhID' => $nPmtId,
                        'FTPspStaExclude' => $ohdFTPspStaExcludeBch,
                        'FNPmoID' => $ohdFNPmoID[$key],
                    );
                    $this->mPromotion->FSxMPMTSpcPark($aSpcPark);
                }
            }

            $ohdFTPsgRefID = $this->input->post('ohdFTPsgRefID');
            $ohdFTPsgStaExcludeGrp = $this->input->post('ohdFTPsgStaExcludeGrp');
            $ohdFTPsgType = $this->input->post('ohdFTPsgType');
            if ($ohdFTPsgRefID != '') {
                foreach (@$ohdFTPsgRefID as $key => $tValue) {
                    $aSpcGrp = array(
                        'FNPmhID' => $nPmtId,
                        'FTPsgType' => $ohdFTPsgType[$key],
                        'FTPsgStaExclude' => $ohdFTPsgStaExcludeGrp,
                        'FTPsgRefID' => $ohdFTPsgRefID[$key],
                    );
                    $this->mPromotion->FSxMPMTSpcGrp($aSpcGrp);
                }
            }
            if ($this->input->post('ohdPmtImg')) {
                $tImg = $this->input->post('ohdPmtImg');
                // FSxPMTAddImg($nPmtId, 1, 'TTKMImgPdt', 'Promotion', $tImg, 'promotion', 'TTKTPmtList', $aData['FTPmhCode']);
                $aImageUplode = array(
                    'tModuleName'       => 'ticket',
                    'tImgFolder'        => 'ticketpromotion',
                    'tImgRefID'         => $nPmtId,
                    'tImgObj'           => $tImg,
                    'tImgTable'         => 'TTKTPmtList',
                    'tTableInsert'      => 'TCNMImgObj',
                    'tImgKey'           => 'main',
                    'dDateTimeOn'       => date('Y-m-d H:i:s'),
                    'tWhoBy'            => $this->session->userdata('tSesUsername'),
                    'nStaDelBeforeEdit' => 1
                );
                // print_r($aImageUplode);
                 $aResAddImgObj = FCNnHAddImgObj($aImageUplode);
            }
            echo $nPmtId;
        }
    }

    public function FSxCPMTEdit($nID) {
        $oBranch = $this->mPromotion->FSxMPMTSBranch($nID);
        $oPdt = $this->mPromotion->FSxMPMTSPdt($nID);
        $oAgn = $this->mPromotion->FSxMPMTSAgn($nID);
        $oCst = $this->mPromotion->FSxMPMTSCst($nID);
        $oPmt = $this->mPromotion->FSxMPMTSPmt($nID);
        $oAuthen = FCNaHCheckAlwFunc('EticketPromotion');
        $this->load->view('ticket/promotion/wEdit', array(
            'oPmt' => $oPmt,
            'oBranch' => $oBranch,
            'oPdt' => $oPdt,
            'oAgn' => $oAgn,
            'oCst' => $oCst,
            'oAuthen' => $oAuthen
        ));
    }

    public function FSxCPMTEditAjax() {
        if ($this->input->post('ohdFNPmhID')) {
            $aData = array(
                'FNPmhID' => $this->input->post('ohdFNPmhID'),
                'FTPmhCode' => $this->input->post('oetFTPmhCode'),
                'FTPmhName' => $this->input->post('oetFTPmhName'),
                'FCPmhBuyAmt' => $this->input->post('oetFCPmhBuyAmt'),
                'FCPmhGetValue' => $this->input->post('oetFCPmhGetValue'),
                'FCPmhGetCond' => $this->input->post('ohdFCPmhGetCond'),
                'FTPmhClosed' => $this->input->post('ocmFTPmhClosed'),
                'FDPmhActivate' => FsxDate($this->input->post('oetFDPmhActivate')),
                'FDPmhExpired' => FsxDate($this->input->post('oetFDPmhExpired')),
                'FDPmhTActivate' => date('Y-m-d') . ' ' . $this->input->post('oetFDPmhTActivate'),
                'FDPmhTExpired' => date('Y-m-d') . ' ' . $this->input->post('oetFDPmhTExpired'),
                'FTPmhStaSpcPdt' => $this->input->post('ohdFTPmhStaSpcPdt'),
                'FTPmhStaSpcPark' => $this->input->post('ohdFTPmhStaSpcPark'),
                'FTPmhStaSpcGrp' => $this->input->post('ohdFTPmhStaSpcGrp'),
            );
            $this->mPromotion->FSxMPMTEdit($aData);
            $ohdFTPspStaExcludePkg = $this->input->post('ohdFTPspStaExcludePkg');
            $ohdFNPkgID = $this->input->post('ohdFNPkgID');
            if (!empty($ohdFNPkgID)) {
                foreach (@$ohdFNPkgID as $key => $tValue) {
                    $aSpcPdt = array(
                        'FNPmhID' => $aData['FNPmhID'],
                        'FTPspRefType' => 2,
                        'FTPspStaExclude' => $ohdFTPspStaExcludePkg,
                        'FNPspCodeRef' => $ohdFNPkgID[$key],
                    );
                    $this->mPromotion->FSxMPMTSpcPdt($aSpcPdt);
                }
            }
            $ohdFTPspStaExcludeBch = $this->input->post('ohdFTPspStaExcludeBch');
            $ohdFNPmoID = $this->input->post('ohdFNPmoID');
            if (!empty($ohdFNPmoID)) {
                foreach (@$ohdFNPmoID as $key => $tValue) {
                    $aSpcPark = array(
                        'FNPmhID' => $aData['FNPmhID'],
                        'FTPspStaExclude' => $ohdFTPspStaExcludeBch,
                        'FNPmoID' => $ohdFNPmoID[$key],
                    );
                    $this->mPromotion->FSxMPMTSpcPark($aSpcPark);
                }
            }
            $ohdFTPsgRefID = $this->input->post('ohdFTPsgRefID');
            $ohdFTPsgStaExcludeGrp = $this->input->post('ohdFTPsgStaExcludeGrp');
            $ohdFTPsgType = $this->input->post('ohdFTPsgType');
            if (!empty($ohdFTPsgRefID)) {
                foreach (@$ohdFTPsgRefID as $key => $tValue) {
                    $aSpcGrp = array(
                        'FNPmhID' => $aData['FNPmhID'],
                        'FTPsgType' => $ohdFTPsgType[$key],
                        'FTPsgStaExclude' => $ohdFTPsgStaExcludeGrp,
                        'FTPsgRefID' => $ohdFTPsgRefID[$key],
                    );
                    $this->mPromotion->FSxMPMTSpcGrp($aSpcGrp);
                }
            }
            if ($this->input->post('ohdPmtImg')) {
                $tImg = $this->input->post('ohdPmtImg');
                // FSxPMTAddImg($aData['FNPmhID'], 1, 'TTKMImgPdt', 'Promotion', $tImg, 'promotion', 'TTKTPmtList', $aData['FTPmhCode']);
                $aImageUplode = array(
                    'tModuleName'       => 'ticket',
                    'tImgFolder'        => 'ticketpromotion',
                    'tImgRefID'         => $aData['FNPmhID'],
                    'tImgObj'           => $tImg,
                    'tImgTable'         => 'TTKTPmtList',
                    'tTableInsert'      => 'TCNMImgObj',
                    'tImgKey'           => 'main',
                    'dDateTimeOn'       => date('Y-m-d H:i:s'),
                    'tWhoBy'            => $this->session->userdata('tSesUsername'),
                    'nStaDelBeforeEdit' => 1
                );
                $aResAddImgObj = FCNnHAddImgObj($aImageUplode);
            }
        }
    }

    public function FSxCPMTPkgList() {
        $tFTPkgName = $this->input->post('FTPkgName');
        $tListItem = $this->input->post('aListItem');
        $nPageNo = $this->input->post('nPageNo');
        $nPageActive = $nPageNo;
        $oPkgList = $this->mPromotion->FSxMPMTPkgList($tFTPkgName, $tListItem, $nPageActive);
        if (@$oPkgList[0]->FNPkgID != '') {
            foreach (@$oPkgList as $key => $oValue) {
                $n = $key + 1;
                echo '<tr class="xBoxPkgTable" onclick="javascript: $(this).toggleClass(\'active\')">
				<td>' . $oValue->RowID . '</td>
				<td>' . $oValue->FTPkgName . '<input type="hidden" id="ohdPkgList" data-id="' . $oValue->FNPkgID . '" value="' . $oValue->FTPkgName . '"></td>
				</tr>';
            }
        } else {
            echo '<tr><td align="center" colspan="2">' . language('ticket/promotion/promotion', 'tNoInformationAvailable') . '</td></tr>';
        }
    }

    public function FSxCPMTPkgCount() {
        $tFTPkgName = $this->input->post('FTPkgName');
        $tListItem = $this->input->post('aListItem');
        $oPMTCntSh = $this->mPromotion->FSxMPMTPkgCount($tFTPkgName, $tListItem);
        $tPMTCount = $oPMTCntSh [0]->counts;
        echo $tPMTCount;
    }

    public function FSxCPMTBchList() {
        $tFTPmoName = $this->input->post('FTPmoName');
        $tListItem = $this->input->post('aListItem');
        $nPageNo = $this->input->post('nPageNo');
        $nPageActive = $nPageNo;
        $oBchList = $this->mPromotion->FSxMPMTBchList($tFTPmoName, $tListItem, $nPageActive);
        if (@$oBchList[0]->FNPmoID) {
            foreach ($oBchList as $key => $oValue) {
                $n = $key + 1;
                echo '<tr class="xBoxBchTable" onclick="javascript: $(this).toggleClass(\'active\')">
				<td>' . $oValue->RowID . '</td>
				<td>' . $oValue->FTPmoName . '<input type="hidden" id="ohdModel" data-id="' . $oValue->FNPmoID . '" value="' . $oValue->FTPmoName . '"></td>
				</tr>';
            }
        } else {
            echo '<tr><td align="center" colspan="2">' . language('ticket/promotion/promotion', 'tNoInformationAvailable') . '</td></tr>';
        }
    }

    public function FSxCPMTBchCount() {
        $tFTPmoName = $this->input->post('FTPmoName');
        $tListItem = $this->input->post('aListItem');
        $oPMTCntSh = $this->mPromotion->FSxMPMTBchCount($tFTPmoName, $tListItem);
        $tPMTCount = $oPMTCntSh [0]->counts;
        echo $tPMTCount;
    }

    public function FSxCPMTAgnList() {
        $tFTAggName = $this->input->post('FTAggName');
        $tListItem = $this->input->post('aListItem');
        $nPageNo = $this->input->post('nPageNo');
        $nPageActive = $nPageNo;
        $oAgnList = $this->mPromotion->FSxMPMTAgnList($tFTAggName, $tListItem, $nPageActive);
        if (@$oAgnList[0]->FTAggCode != '') {
            foreach ($oAgnList as $key => $oValue) {
                $n = $key + 1;
                echo '<tr class="xBoxAggTable" onclick="javascript: $(this).toggleClass(\'active\')">
				<td>' . $oValue->RowID . '</td>
				<td>' . $oValue->FTAggName . '<input type="hidden" id="ohdAgg" data-id="' . $oValue->FTAggCode . '" value="' . $oValue->FTAggName . '"></td>
				</tr>';
            }
        } else {
            echo '<tr><td align="center" colspan="2">' . language('ticket/promotion/promotion', 'tNoInformationAvailable') . '</td></tr>';
        }
    }

    public function FSxCPMTAgnCount() {
        $tFTAggName = $this->input->post('FTAggName');
        $tListItem = $this->input->post('aListItem');
        $oPMTCntSh = $this->mPromotion->FSxMPMTAgnCount($tFTAggName, $tListItem);
        $tPMTCount = $oPMTCntSh [0]->counts;
        echo $tPMTCount;
    }

    public function FSxCPMTCstList() {
        $tFTCgpName = $this->input->post('FTCgpName');
        $tListItem = $this->input->post('aListItem');
        $nPageNo = $this->input->post('nPageNo');
        $nPageActive = $nPageNo;
        $oCstList = $this->mPromotion->FSxMPMTCstList($tFTCgpName, $tListItem, $nPageActive);
        if (@$oCstList[0]->FNCgpID != '') {
            foreach ($oCstList as $key => $oValue) {
                $n = $key + 1;
                echo '<tr class="xBoxCgpTable" onclick="javascript: $(this).toggleClass(\'active\')">
				<td>' . $oValue->RowID . '</td>
				<td>' . $oValue->FTCgpName . '<input type="hidden" id="ohdCgp" data-id="' . $oValue->FNCgpID . '" value="' . $oValue->FTCgpName . '"></td>
				</tr>';
            }
        } else {
            echo '<tr><td align="center" colspan="2">' . language('ticket/promotion/promotion', 'tNoInformationAvailable') . '</td></tr>';
        }
    }

    public function FSxCPMTCstCount() {
        $tFTCgpName = $this->input->post('FTCgpName');
        $tListItem = $this->input->post('aListItem');
        $oPMTCntSh = $this->mPromotion->FSxMPMTCstCount($tFTCgpName, $tListItem);
        $tPMTCount = $oPMTCntSh [0]->counts;
        echo $tPMTCount;
    }

    public function FSxCPMTDel() {
        if ($this->input->post('tPmtID')) {
            $ocbListItem = $this->input->post('tPmtID');
            $aCode = explode(',', $ocbListItem);
            foreach ($aCode as $key => $oValue) {
                $aData = array(
                    'FNPmhID' => $oValue
                );
                $this->mPromotion->FSxMPMTDel($aData);
                // FSxCNDelImg($aData['FNPmhID'], 'TTKMImgPdt', 'Promotion', 'promotion', 'TTKTPmtList');
                $aDeleteImage = array(
                    'tModuleName'  => 'ticket',
                    'tImgFolder'   => 'ticketpromotion',
                    'tImgRefID'    => $aData['FNPmhID'],
                    'tTableDel'    => 'TCNMImgObj',
                    'tImgTable'    => 'TTKTPmtList'
                );
                $nStaDelImgInDB =   FSnHDelectImageInDB($aDeleteImage);
                if($nStaDelImgInDB == 1){
                    FSnHDeleteImageFiles($aDeleteImage);
                }
            }
        }
    }

    public function FSxCPMTDelPkg() {
        if ($this->input->post('tFNPspID')) {
            $aData = array(
                'FNPmhID' => $this->input->post('tFNPmhID'),
                'FNPspID' => $this->input->post('tFNPspID')
            );
            $this->mPromotion->FSxMPMTDelSpcPdt($aData);
        }
    }

    public function FSxCPMTDelBch() {
        if ($this->input->post('tFNPspID')) {
            $aData = array(
                'FNPmhID' => $this->input->post('tFNPmhID'),
                'FNPspID' => $this->input->post('tFNPspID')
            );
            $this->mPromotion->FSxMPMTDelSpcPark($aData);
        }
    }

    public function FSxCPMTDelGrp() {
        if ($this->input->post('tFNPsgGrpID')) {
            $aData = array(
                'FNPmhID' => $this->input->post('tFNPmhID'),
                'FNPsgGrpID' => $this->input->post('tFNPsgGrpID')
            );
            $this->mPromotion->FSxMPMTDelSpcGrp($aData);
        }
    }

    public function FSxCPMTApv() {
        if ($this->input->post('tFNPmhID')) {
            $aData = array(
                'FNPmhID' => $this->input->post('tFNPmhID')
            );
            $this->mPromotion->FSxMPMTApv($aData);
        }
    }

    public function FSxCPMTGenKey() {
        $tRandom = $this->FSxCRandomString(10);
        $nChkCode = $this->mPromotion->FSxMPMTChkCode($tRandom);
        if ((int) $nChkCode[0]->FNCount > 0) {
            $tCode = $this->FSxCRandomString(10);
        } else {
            $tCode = $tRandom;
        }
        echo $tRandom;
    }

    public function FSxCPMTChkCode() {
        $tPmhCode = $this->input->post('oetFTPmhCode');
        $nChkCode = $this->mPromotion->FSxMPMTChkCode($tPmhCode);
        if ((int) $nChkCode[0]->FNCount > 0) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    private function FSxCRandomString($length) {
        $oKeys = array_merge(range(0, 9), range('A', 'Z'));
        $tKey = "";
        for ($i = 0; $i < $length; $i++) {
            $tKey .= $oKeys[mt_rand(0, FCNnHSizeOf($oKeys) - 1)];
        }
        return $tKey;
    }

}
