<?php

defined('BASEPATH') or exit('No direct script access allowed');

class cLocation extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('eticket/location/mLocation', 'mLocation');
        $this->load->library("session");
    }

    public function FSxCLocLocation($nID) {
        $oAuthen = FCNaHCheckAlwFunc('EticketBranch');
        $oLocL = $this->mLocation->FSxMLocPrkDetail($nID);
        $oArea = $this->mLocation->FSxMLocPrkDetailArea($nID);
        $oModelImg = $this->mLocation->FSxMLocModelImg($nID);
        $this->load->view('eticket/location/wLocation', array(
            'oLocL' => $oLocL,
            'oArea' => $oArea,
            'oModelImg' => $oModelImg,
            'oAuthen' => $oAuthen,
            'nID' => $nID
        ));
    }

    // โหลดรายการสาขา Ajax
    public function FSxCLOCList() {
        $tFTLocName = $this->input->post('tFTLocName');
        $tParkId = $this->input->post('tParkId');
        $nPageNo = $this->input->post('nPageNo');
        $nPageActive = $nPageNo;
        $oLocList = $this->mLocation->FSaMLOCList($tFTLocName, $tParkId, $nPageActive);
        $oAuthen = FCNaHCheckAlwFunc('EticketBranch');
        $this->load->view('eticket/location/wLocList', array(
            'oLocList' => $oLocList,
            'oAuthen' => $oAuthen
        ));
    }

    // นับจำนวนสาขา
    public function FStCLOCAjaxSearch() {
        $tFTLocName = $this->input->post('tFTLocName');
        $nParkId = $this->input->post('nParkId');

        $oParkCntSh = $this->mLocation->FSaMLOCSearchCount($tFTLocName, $nParkId);
        $tParkCount = $oParkCntSh [0]->counts;
        echo $tParkCount;
    }

    /**
     * FS เพิ่มสถานที่
     */
    public function FSxCLOCAdd($tID) {
        $oArea = $this->mLocation->FSxMLocArea();
        $oProvince = $this->mLocation->FSxMLocProvince();
        $oDistrict = $this->mLocation->FSxMLocDistrict();
        $oModel = $this->mLocation->FSxMLocModel();
        $oLocModel = $this->mLocation->FSxMLocModelImg($tID);
        $this->load->view('eticket/location/wAdd', array(
            'aArea' => $oArea,
            'aProvince' => $oProvince,
            'aDistrict' => $oDistrict,
            'aModel' => $oModel,
            'aLocModel' => $oLocModel,
            'tID' => $tID
        ));
    }

    public function FSxCLocAddAjax() {
        if ($this->input->post('ocmSelectFNPmoID')) {
            $oLocCodeRef = $this->mLocation->FSaMLocLocationCodeRef();
            $tFNPmoID = $this->input->post('ocmSelectFNPmoID');
            $tFTLocName = $this->input->post('oetFTLocName');
            $tFNLocLimit = $this->input->post('oetFNLocLimit');
            $tTimeOpening = $this->input->post('oetFTLocTimeOpening');
            $tTimeOpening = $this->input->post('oetFTLocTimeClosing');
            
            if (@$oLocCodeRef [0]->FTLocCodeRef == '') {
                $tCodeRef = 'RF-00001';
            } else {
                $tCodeRef = 'RF-' . str_pad(str_replace('RF-', '', $oLocCodeRef [0]->FTLocCodeRef) + 1, 5, '0', STR_PAD_LEFT);
            }
            foreach ($tFNPmoID as $key => $tValue) {
                $tData = array(
                    'FNPmoID' => $tValue, // รหัสสาขา
                    'FTLocName' => $tFTLocName, // ชื่อสถานที่
                    'FTLocCodeRef' => $tCodeRef,
                    'FNLocLimit' => $tFNLocLimit, // จำนวนรองรับ Default 0 ไม่จำกัด
                    'FTLocTimeOpening' => $tTimeOpening, // เวลาเปิดทำการ เช่น 08:00:00
                    'FTLocTimeClosing' => $tTimeOpening, // เวลาปิดทำการ เช่น 20:00:00
                );
                $nLocID = $this->mLocation->FSxMLocSaveLoc($tData);
                // if ($this->input->post('ohdLocImg')) {
                //     $tImg = $this->input->post('ohdLocImg');
                //     FSaHAddImgObj($nLocID, 1, 'TTKMImgObj', 2, 'main', $tImg, 'location');
                // }

                if ($this->input->post('ohdLocImg')) {
                    $tImg = $this->input->post('ohdLocImg');
                    $aImageUplode = array(
                        'tModuleName'       => 'ticket',
                        'tImgFolder'        => 'ticketlocation',
                        'tImgRefID'         => $$tData['FNLocID'],
                        'tImgObj'           => $tImg,
                        'tImgTable'         => 'TTKMLocation',
                        'tTableInsert'      => 'TTKMImgObj',
                        'tImgKey'           => 'main',
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1
                    );
                    $aResAddImgObj = FCNnHAddImgObj($aImageUplode);
                }

            }
            if ($this->input->post('ohdFNAreID')) {
                $tFNAreID = $this->input->post('ohdFNAreID');
                $tFNPvnID = $this->input->post('ohdFNPvnID');
                $tFNDstID = $this->input->post('ohdFNDstID');
                foreach ($tFNAreID as $key => $tValue) {
                    $aData = array(
                        'FTAreCode' => $tFNAreID [$key],
                        'FTPvnCode' => $tFNPvnID [$key],
                        'FTDstCode' => $tFNDstID [$key]
                    );
                    $this->mLocation->FSxMLocAddAre($aData);
                }
            }
            echo $nLocID;
        }
    }

    /**
     * FS แก้ไขสถานที่
     */
    public function FSxCLOCEdit($nID, $nPrk) {
        $oArea = $this->mLocation->FSxMLocArea($nID);
        $oProvince = $this->mLocation->FSxMLocProvince($nID);
        $oDistrict = $this->mLocation->FSxMLocDistrict($nID);
        $oLocModel = $this->mLocation->FSxMLocModelImg($nPrk);
        $oAreas = $this->mLocation->FSxMLOCLoadArea($nID);
        $oEdit = $this->mLocation->FSxMLocShowEdit($nID);
        $this->load->view('eticket/location/wEdit', array(
            'aArea' => $oArea,
            'aProvince' => $oProvince,
            'aDistrict' => $oDistrict,
            'aLocModel' => $oLocModel,
            'oAreas' => $oAreas,
            'oEdit' => $oEdit,
            'nPrk' => $nPrk
        ));
    }

    public function FSxCLOCEditAjax() {
        if ($this->input->post('ohdEditLocID')) {
            $tFTLocImg = $this->input->post('ohdLocImgEdit');
            $tData = array(
                'FNLocID' => $this->input->post('ohdEditLocID'),
                'FNPmoID' => $this->input->post('ohdFNPmoID'),
                'FTLocName' => $this->input->post('oetFTLocNameEdit'),
                'FNLocLimit' => $this->input->post('oetFNLocEditLimit'),
                'FTLocTimeOpening' => $this->input->post('oetFTLocTimeEditOpening'),
                'FTLocTimeClosing' => $this->input->post('oetFTLocTimeEditClosing')
            );
            $this->mLocation->FSxMLocEditLoc($tData);
            // if ($this->input->post('ohdLocImg')) {
            //     $tImg = $this->input->post('ohdLocImg');
            //     FSaHUpdateImgObj($tData['FNLocID'], 'TTKMImgObj', 2, 'main', $tImg, 'location');
                
            // }
            if ($this->input->post('ohdAgcImg')) {
            $tImg = $this->input->post('ohdAgcImg');
            $aImageUplode = array(
                'tModuleName'       => 'ticket',
                'tImgFolder'        => 'ticketlocation',
                'tImgRefID'         => $tData['FNLocID'],
                'tImgObj'           => $tImg,
                'tImgTable'         => 'TTKMLocation',
                'tTableInsert'      => 'TTKMImgObj',
                'tImgKey'           => 'main',
                'dDateTimeOn'       => date('Y-m-d H:i:s'),
                'tWhoBy'            => $this->session->userdata('tSesUsername'),
                'nStaDelBeforeEdit' => 1
            );
            $aResAddImgObj = FCNnHAddImgObj($aImageUplode);
        }
            if ($this->input->post('ohdFNAreID')) {
                $tFNAreID = $this->input->post('ohdFNAreID');
                $tFNPvnID = $this->input->post('ohdFNPvnID');
                $tFNDstID = $this->input->post('ohdFNDstID');
                $tFNLocID = $this->input->post('ohdEditLocID');
                foreach ($tFNDstID as $key => $tValue) {
                    $aData = array(
                        'FTAreCode' => $tFNAreID [$key],
                        'FTPvnCode' => $tFNPvnID [$key],
                        'FTDstCode' => $tFNDstID [$key],
                        'FNLocID' => $tFNLocID
                    );
                    $this->mLocation->FSxMLocAddAre2($aData);
                }
            }

            echo 'Success';
        }
    }

    /**
     * FS ลบสถานที่
     */
    public function FSxCLocDeleteLocation() {
        if ($this->input->post('tId')) {
            $ocbListItem = $this->input->post('tId');
            $aCode = explode(',', $ocbListItem);
            foreach ($aCode as $key => $oValue) {
                $o = $this->mLocation->FSxMLocDelLoc($oValue);
                $aJson = array(
                    'count' => $o,
                    'msg' => language('ticket/center/center', 'CheckDel')
                );
                if ($o == 0) {
                    FSaDelImg($oValue, 'TTKMImgObj', 2, 'main', 'location');
                }
                echo json_encode($aJson);
            }
        }
    }

    /**
     * Load Zone Select
     */
    public function FSxCLOCLoadZoneSlc($id) {
        if (isset($id)) {
            $oRow = $this->mLocation->FSxMLOCLoadZoneSlc($id);
            foreach ($oRow as $tValue) {
                echo '<option value="' . $tValue->FNZneID . '">' . ($this->session->userdata("lang") == "th" ? $tValue->FTZneName : $tValue->FTZneNameOth) . '</option>';
            }
        }
    }

    /**
     * Load Area
     */
    public function FSxCLOCLoadArea() {
        if ($this->input->post('nId')) {
            $nId = $this->input->post('nId');
            $oRow = $this->mLocation->FSxMLOCLoadArea($nId);
            $this->load->view('eticket/location/wArea', array(
                'oRow' => $oRow
            ));
        }
    }

    /**
     * Del Area
     */
    public function FSxCLOCDelAre() {
        if ($this->input->post('tID')) {
            $tID = $this->input->post('tID');
            $this->mLocation->FSxMLOCDelAre($tID);
        }
    }

    /**
     * ลบรูปสถานที่
     */
    public function FSxCLOCDelImg() {
        if ($this->input->post('tImgID')) {
            $ptNameImg = $this->input->post('tNameImg');
            $ptImgID = $this->input->post('tImgID');  

            $aDeleteImage = array(
                'tModuleName'  => 'ticket',
                'tImgFolder'   => 'ticketlocation',
                'tImgRefID'    => $ptImgID,
                'tTableDel'    => 'TTKMImgObj',
                'tImgTable'    => 'TTKMLocation'
            );
            $nStaDelImgInDB =   FSnHDelectImageInDB($aDeleteImage);
            if($nStaDelImgInDB == 1){
                FSnHDeleteImageFiles($aDeleteImage);
            }
        }
    }

    public function FSxCLOCCheck() {
        if ($this->input->post('oetFTLocName')) {
            $tData = array(
                'FTLocName' => $this->input->post('oetFTLocName'),
                'FNPmoID' => $this->input->post('ocmSelectFNPmoID')
            );
            $tCheck = $this->mLocation->FSxMLOCCheck($tData);
            if (@$tCheck [0]->counts > 0) {
                echo 'false';
            } else {
                echo 'true';
            }
        }
    }

}
