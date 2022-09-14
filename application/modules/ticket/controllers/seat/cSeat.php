<?php

defined('BASEPATH') or exit('No direct script access allowed');

class cSeat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('eticket/zone/mZone', 'mZone');
        $this->load->library("session");
    }

    public function FSxCSETSeat($nLocID, $nZneID, $nLevID) {
        $oHeader = $this->mZone->FSxMZNEHeader($nLocID);
        $oArea = $this->mZone->FSxMZNEArea($nLocID);
        $oShow = $this->mZone->FSxMZNEShowEdit($nZneID);
        $oAuthen = FCNaHCheckAlwFunc('EticketBranch');

        $aData = array(
            'FNLocID' => $nLocID,
            'FNLevID' => $nLevID,
            'FNZneID' => $nZneID
        );
        $oRow = $this->mZone->FSxMZNESeat($aData);
        $this->load->view('eticket/seat/wSeat', array(
            'oAuthen' => $oAuthen,
            'oHeader' => $oHeader,
            'oArea' => $oArea,
            'nLocID' => $nLocID,
            'nZneID' => $nZneID,
            'nLevID' => $nLevID,
            'oShow' => $oShow,
            'oRow' => $oRow
        ));
    }

    /**
     * FS แสดงที่นั่ง
     */
    public function FSxCSETSeatList() {
        if ($this->input->post('tFNZneID')) {
            $aData = array(
                'FNLocID' => $this->input->post('tFNLocID'),
                'FNLevID' => ($this->input->post('tFNLevID') == "" ? 0 : $this->input->post('tFNLevID')),
                'FNZneID' => $this->input->post('tFNZneID')
            );
            $oRow = $this->mZone->FSxMZNESeat($aData);
            $oShow = $this->mZone->FSxMZNEShow($aData);
        }
        $oAuthen = FCNaHCheckAlwFunc('EticketBranch');
        $this->load->view('eticket/seat/wSeatList', array(
            'oAuthen' => $oAuthen,
            'oRow' => @$oRow,
            'oShow' => @$oShow
        ));
    }

    /**
     * FS สร้างที่นั่ง
     */
    public function FSxCSETCreateSeat() {
        if ($this->input->post('ohdFNZneRow')) {
            $nTotalRows = $this->input->post('ohdFNZneRow'); // จำนวนแถว
            $nSeatStartNo = $this->input->post('ohdFNZneRowStart'); // แถวที่นั่งนับเริ่มจาก
            $nSeatPerCol = $this->input->post('ohdFNZneCol'); // จำนวนที่นั่ง
            $nColStart = $this->input->post('ohdFNZneColStart'); // เลขที่นั่งนับเริ่มจาก

            $nTotalRows = $nTotalRows + $nSeatStartNo - 1;
            $nTotalSeat = $nSeatPerCol * $nTotalRows; // จำนวนแถวทั้งหมด
            $nSeatPerRows = ceil($nTotalSeat / $nTotalRows);
            $t = $nSeatStartNo - 1;
            for ($t; $t < $nTotalRows; $t ++) {
                $tSignName = GenSignName($t);
                for ($i = 0; $i < $nSeatPerCol; $i ++) {
                    $nSeatNo = $nSeatStartNo ++;
                    $n = $i + 1;
                    $nCol = $nColStart - 1;
                    if ($i < $nCol) {
                        $tSeat = array(
                            'FNLevID' => $this->input->post('ohdFNLevIDSet'),
                            'FNLocID' => $this->input->post('ohdFNLocIDSet'),
                            'FNZneID' => $this->input->post('ohdFNZneIDSet'),
                            'FTSetRowChr' => $tSignName,
                            'FNSetRowSeq' => $t + 1,
                            'FTSetColChr' => $i + 1,
                            'FNSetColSeq' => $i + 1,
                            'FTSetName' => $tSignName . $n,
                            'FTSetStaAlw' => '4'
                        );
                        $this->mZone->FSxMZNEAddSeat($tSeat);
                    } else {
                        $tSeat = array(
                            'FNLevID' => $this->input->post('ohdFNLevIDSet'),
                            'FNLocID' => $this->input->post('ohdFNLocIDSet'),
                            'FNZneID' => $this->input->post('ohdFNZneIDSet'),
                            'FTSetRowChr' => $tSignName,
                            'FNSetRowSeq' => $t + 1,
                            'FTSetColChr' => $i + 1,
                            'FNSetColSeq' => $i + 1,
                            'FTSetName' => $tSignName . $n,
                            'FTSetStaAlw' => '1'
                        );
                        $this->mZone->FSxMZNEAddSeat($tSeat);
                    }
                }
            }
        }
    }

    /**
     * FS แก้ไขที่นั่ง
     */
    public function FSxCSETEditSeat() {
        if ($this->input->post('ohdFNSetID')) {
            $aData = array(
                'FNSetID' => $this->input->post('ohdFNSetID'),
                // /'FTSetName' => $this->input->post ( 'oetFTSetName' ),
                'FTSetStaAlw' => $this->input->post('ocmFTSetStaAlw')
            );
            $this->mZone->FSxMZNEEditSeat($aData);
        }
    }

    /**
     * FS แก้ไข FTSetRowChr
     */
    public function FSxCSETEditRowChr() {
        if ($this->input->post('oetFTSetRowChr')) {
            $aRowChr = $this->input->post('oetFTSetRowChr');
            $aRowChrHD = $this->input->post('ohdFTSetRowChr');
            $aSetID = $this->input->post('ohdFNSetID');
            foreach ($aSetID as $key => $oSet) {
                $tKeyNumber = $key + 1;
                $aData = array(
                    'FNSetID' => $oSet,
                    'FTSetRowChr' => $aRowChr,
                    'ohdFTSetRowChr' => $aRowChrHD,
                    'FNLocID' => $this->input->post('ohdFNLocID'),
                    'FNLevID' => $this->input->post('ohdFNLevID'),
                    'FNZneID' => $this->input->post('ohdFNZneID'),
                    'FTSetName' => $aRowChr . $tKeyNumber
                );
                $this->mZone->FSxMZNEEditRowChr($aData);
            }
        }
    }

    public function FStCSETCheckSeat() {
        if ($this->input->post('oetFTSetRowChr')) {
            $tData = array(
                'FTSetRowChr' => $this->input->post('oetFTSetRowChr'),
                'FNLocID' => $this->input->post('ohdFNLocID'),
                'FNLevID' => $this->input->post('ohdFNLevID'),
                'FNZneID' => $this->input->post('ohdFNZneID')
            );
            $tCheck = $this->mZone->FStMZNECheckSeat($tData);
            if (@$tCheck [0]->counts > 0) {
                echo 'false';
            } else {
                echo 'true';
            }
        }
    }

    public function FStCSETCheckEdtSeat() {
        if ($this->input->post('oetFTSetName')) {
            $aData = array(
                'FTSetName' => $this->input->post('oetFTSetName'),
                'FNLocID' => $this->input->post('ohdFNLocIDSet'),
                'FNLevID' => $this->input->post('ohdFNLevIDSet'),
                'FNZneID' => $this->input->post('ohdFNZneIDSet')
            );
            $tCheck = $this->mZone->FStMZNECheckEdtSeat($aData);
            if (@$tCheck [0]->counts > 0) {
                echo 'false';
            } else {
                echo 'true';
            }
        }
    }

    public function FSxCSETAjaxSaveSeat() {
        if ($this->input->post('ocmType') == '1') {
            $aData = array(
                'FNLocID' => $this->input->post('ohdFNLocID'),
                'FNLevID' => $this->input->post('ohdFNLevID'),
                'FNZneID' => $this->input->post('ohdFNZneID'),
                'FNSetRowChr' => $this->input->post('ocmFNSetRowChr'),
                'FNZneRow' => $this->input->post('oetFNZneRow'),
                'FNZneCol' => $this->input->post('oetFNZneCol'),
                'FNZneColStart' => $this->input->post('oetFNZneColStart')
            );
            $oAmount = $this->mZone->FSxMZNECheckAmountSeat($aData);
            $oColStart = $this->mZone->FSxMZNEColStart($aData);
            $nAmount = (int) FCNnHSizeOf($oAmount);
            $nZneCol = (int) $aData ['FNZneCol'];
            $nRowSeq = $nAmount + 1;
            for ($i = 0; $i < $nZneCol; $i ++) {
                $n = $nRowSeq + $i;
                $aSeat = array(
                    'FNLocID' => $this->input->post('ohdFNLocID'),
                    'FNLevID' => $this->input->post('ohdFNLevID'),
                    'FNZneID' => $this->input->post('ohdFNZneID'),
                    'FTSetRowChr' => $aData ['FNSetRowChr'],
                    'FNSetRowSeq' => $oAmount [0]->FNSetRowSeq,
                    'FTSetColChr' => $n,
                    'FNSetColSeq' => $n,
                    'FTSetName' => $aData ['FNSetRowChr'] . $n,
                    'FTSetStaAlw' => 1
                );
                $this->mZone->FSxMZNEAddSeat($aSeat);
            }
        } elseif ($this->input->post('ocmType') == '2') {
            $aData = array(
                'FNLocID' => $this->input->post('ohdFNLocID'),
                'FNLevID' => $this->input->post('ohdFNLevID'),
                'FNZneID' => $this->input->post('ohdFNZneID'),
                'FNSetRowChr' => $this->input->post('ocmFNSetRowChr'),
                'FNZneRow' => $this->input->post('oetFNZneRow'),
                'FNZneCol' => $this->input->post('oetFNZneCol'),
                'FNZneColStart' => $this->input->post('oetFNZneColStart')
            );
            $oSeat = $this->mZone->FSxMZNESeat($aData);
            $nTotalRows = $this->input->post('oetFNZneRow'); // จำนวนแถว
            $nSeatPerCol = $this->input->post('oetFNZneCol'); // จำนวนที่นั่ง
            $nColStart = $this->input->post('oetFNZneColStart'); // เลขที่นั่งนับเริ่มจาก
            $t = (int) FCNnHSizeOf($oSeat);
            $nTotal = $nTotalRows + $t; // 5
            for ($t; $t < $nTotal; $t ++) {
                $tSignName = GenSignName($t);
                for ($i = 0; $i < $nSeatPerCol; $i ++) {
                    // $nSeatNo = $nSeatStartNo ++;
                    $nCol = $nColStart - 1;
                    $n = $i + 1;
                    if ($i < $nCol) {
                        $aSeat = array(
                            'FNLocID' => $this->input->post('ohdFNLocID'),
                            'FNLevID' => $this->input->post('ohdFNLevID'),
                            'FNZneID' => $this->input->post('ohdFNZneID'),
                            'FTSetRowChr' => $tSignName,
                            'FNSetRowSeq' => $t + 1,
                            'FTSetColChr' => $i + 1,
                            'FNSetColSeq' => $i + 1,
                            'FTSetName' => $tSignName . $n,
                            'FTSetStaAlw' => 4
                        );
                        $this->mZone->FSxMZNEAddSeat($aSeat);
                    } else {
                        $aSeat = array(
                            'FNLocID' => $this->input->post('ohdFNLocID'),
                            'FNLevID' => $this->input->post('ohdFNLevID'),
                            'FNZneID' => $this->input->post('ohdFNZneID'),
                            'FTSetRowChr' => $tSignName,
                            'FNSetRowSeq' => $t + 1,
                            'FTSetColChr' => $i + 1,
                            'FNSetColSeq' => $i + 1,
                            'FTSetName' => $tSignName . $n,
                            'FTSetStaAlw' => 1
                        );
                        $this->mZone->FSxMZNEAddSeat($aSeat);
                    }
                }
            }
        } else {
            
        }
    }

}
