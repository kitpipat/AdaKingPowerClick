<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mBranch extends CI_Model {

    //Functionality : ดึงข้อมูล ของ ที่อยู่
    //Parameters : function parameters
    //Creator : 10/05/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSvMBCHGetAddress($ptData) {

        $tAddRefCode = $ptData['FTAddRefCode'];
        $tAddGrpType = $ptData['FTAddGrpType'];

        $nLngID = $ptData['FNLngID'];

        $tSQL   = " SELECT
                        FTAddVersion,
						FTAddV1No,
						FTAddV1Soi,
						FTAddV1Village,
						FTAddV1Road,
						FTAddV1SubDist,
						FTAddV1DstCode,
						DSTL.FTDstName,
						SUBDSTL.FTSudName,
						ADDL.FTAddV1PvnCode,
						ADDL.FTAddCountry,
						PVNL.FTPvnName,
						FTAddV1PostCode,
						FTAddV2Desc1,
						FTAddV2Desc2,
						ZNE.FTZneChain,
						ZNE.FNZneID,
						ZNEL.FTZneName
				    FROM TCNMAddress_L ADDL
				    LEFT JOIN TCNMZoneObj ZNE ON ADDL.FTAddRefCode = ZNE.FTZneRefCode
				    LEFT JOIN TCNMZone_L ZNEL ON ZNE.FTZneChain = ZNEL.FTZneChain
				    LEFT JOIN TCNMProvince_L PVNL ON ADDL.FTAddV1PvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $nLngID
				    LEFT JOIN TCNMDistrict_L DSTL ON ADDL.FTAddV1DstCode = DSTL.FTDstCode AND DSTL.FNLngID = $nLngID
				    LEFT JOIN TCNMSubDistrict_L SUBDSTL ON ADDL.FTAddV1SubDist = SUBDSTL.FTSudCode AND SUBDSTL.FNLngID = $nLngID
				    WHERE 1=1
                    AND ADDL.FTAddRefCode   = '$tAddRefCode'
				    AND ADDL.FTAddGrpType   = '$tAddGrpType'
				    AND ADDL.FNLngID        = '$nLngID' ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {

            return $oQuery->result();
        } else {
            //No Data
            return false;
        }
    }

    //Functionality : หา ประเภท ของ ที่อยู่
    //Parameters : function parameters
    //Creator : 09/05/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSvMBCHGenViewAddress() {

        $tSQL = "SELECT  FTSysStaDefValue,
						FTSysStaUsrValue

				FROM TSysConfig
				WHERE FTSysCode = 'tCN_AddressType'
				AND FTSysKey = 'TCNMBranch'
				";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {

            return $oQuery->result();
        } else {
            //No Data
            return false;
        }
    }

    //Functionality : Search Branch By ID
    //Parameters : function parameters
    //Creator : 09/03/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMBchSearchByID($paData) {
        $tBchCode = $paData['FTBchCode'];
        $nLngID = $paData['FNLngID'];

        if (@$tBchCode) {

            $tSQL   =   "   SELECT
                                BCH.FTBchCode AS rtBchCode,
                                BCH.FTPplCode AS rtPplCode,
                                BCH.FTAgnCode AS FTAgnCode,
                                AGNL.FTAgnName AS FTAgnName,
                                -- BCH.FTMerCode AS rtMerCode,
                                -- MERL.FTMerName AS rtMerName,
                                PRL.FTPplName AS rtPplName,
                                BCH.FTBchType AS rtBchType,
                                BCH.FTWahCode AS rtWahCode,
                                WAHL.FTWahName AS rtWahName,
                                BCH.FTBchPriority AS rtBchPriority,
                                BCH.FTBchRegNo AS rtBchRegNo,
                                BCH.FTBchRefID AS rtBchRefID,
                                CONVERT(CHAR(10),BCH.FDBchStart,120) AS rdBchStart,
                                CONVERT(CHAR(10),BCH.FDBchStop,120) AS rdBchStop,
                                BCH.FDBchSaleStart AS rdBchSaleStart,
                                BCH.FDBchSaleStop AS rdBchSaleStop,
                                BCH.FTBchStaActive AS rtBchStaActive,
                                BCHL.FTBchName AS rtBchName,
                                BCHL.FTBchRmk AS rtBchRmk,
                                BCH.FTBchStaHQ AS rtBchStaHQ,
                                IMGO.FTImgObj AS rtImgObj,
				BCH.FNBchDefLang
                            FROM [TCNMBranch]            BCH     WITH(NOLOCK)
                            LEFT JOIN [TCNMBranch_L]     BCHL    WITH(NOLOCK) ON BCH.FTBchCode = BCHL.FTBchCode  AND BCHL.FNLngID = $nLngID
                            LEFT JOIN [TCNMWaHouse_L]    WAHL    WITH(NOLOCK) ON BCH.FTWahCode = WAHL.FTWahCode AND BCH.FTBchCode = WAHL.FTBchCode  AND WAHL.FNLngID = $nLngID
                            LEFT JOIN [TCNMPdtPriList_L] PRL     WITH(NOLOCK) ON BCH.FTPplCode = PRL.FTPplCode  AND PRL.FNLngID = $nLngID
                            LEFT JOIN TCNMAgency_L       AGNL     WITH(NOLOCK) ON BCH.FTAgnCode = AGNL.FTAgnCode  AND AGNL.FNLngID = $nLngID
                            -- LEFT JOIN TCNMMerchant_L    MERL     WITH(NOLOCK) ON BCH.FTMerCode = MERL.FTMerCode  AND MERL.FNLngID = $nLngID
                            LEFT JOIN [TCNMImgObj]       IMGO    WITH(NOLOCK) ON BCH.FTBchCode = IMGO.FTImgRefID AND IMGO.FTImgTable = 'TCNMBranch'
            ";

            if ($tBchCode != '') {
                $tSQL .= " WHERE BCH.FTBchCode = '$tBchCode'";
            }
            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {

                $aDetail = $oQuery->result();
            } else {
                //No Data
                $aDetail = '';
            }
        }

        if (@$aDetail) {

            $aResult = array(
                'roItem' => $aDetail[0],
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);

        return $aResult;
    }

    //Functionality : list Branch
    //Parameters : function parameters
    //Creator : 09/03/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMBCHList($paData) {

        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID = $paData['FNLngID'];

        $tSQL   =   "   SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY rtCreateOn DESC , rtBchCode DESC) AS rtRowID,* FROM (
                                SELECT DISTINCT
                                    BCH.FTBchCode                           AS rtBchCode,
                                    FTBchName                               AS rtBchName,
                                    FTBchType                               AS rtBchType,
                                    BCH.FDCreateOn                          AS rtCreateOn,
                                    BCH.FTBchPriority                       AS rtBchPriority,
                                    CONVERT(CHAR(10),FDBchStart,120)        AS rdBchStart,
                                    CONVERT(CHAR(10),FDBchStop,120)         AS rdBchStop,
                                    IMGO.FTImgObj                           AS rtImgObj,
                                    rnCountLang = (SELECT COUNT (DISTINCT(FNLngID)) FROM TCNMBranch_L),
                                    SALHD.FTBchCode                        AS rtUseInSaleHD
                                FROM TCNMBranch         BCH     WITH(NOLOCK)
                                LEFT JOIN TCNMBranch_L  BCHL    WITH(NOLOCK) ON BCH.FTBchCode = BCHL.FTBchCode  AND BCHL.FNLngID = $nLngID
                                LEFT JOIN TPSTSalHD     SALHD    WITH(NOLOCK) ON BCH.FTBchCode = SALHD.FTBchCode 
                                LEFT JOIN TCNMImgObj    IMGO    WITH(NOLOCK) ON BCH.FTBchCode = IMGO.FTImgRefID AND IMGO.FTImgTable = 'TCNMBranch' AND IMGO.FNImgSeq = 1
                                WHERE 1 = 1 ";

        $tSearchList    = $paData['tSearchAll'];
        if($this->session->userdata("tSesUsrLevel") != "HQ"){
            $tBchCode    = $this->session->userdata("tSesUsrBchCodeMulti");
            $tSQL       .= " AND BCH.FTBchCode IN ($tBchCode) ";
        }

        if ($tSearchList != '') {
            $tSQL   .= " AND (BCH.FTBchCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL   .= " OR BCHL.FTBchName  COLLATE THAI_BIN LIKE '%$tSearchList%')";
        }

        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {

            $aList = $oQuery->result();
            $aFoundRow = $this->JSnMBCHGetPageAll($tSearchList, $nLngID);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า

            $aResult = array(
                'raItems' => $aList,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage" => $nPageAll,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        } else {
            //No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        }
        return $aResult;
    }

    //Functionality : All Page Of Branch
    //Parameters : function parameters
    //Creator : 09/03/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    function JSnMBCHGetPageAll($ptSearchList, $ptLngID) {

        $tSQL = "   SELECT
                        COUNT (BCH.FTBchCode) AS counts
                    FROM TCNMBranch BCH WITH(NOLOCK)
                    LEFT JOIN TCNMBranch_L BCHL ON BCH.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $ptLngID
                    WHERE 1 = 1";

        // if ($ptBchCode != '') {
        //     $tSQL .= " AND BCH.FTBchCode = '$ptBchCode' ";
        // }
        if($this->session->userdata("tSesUsrLevel") != "HQ"){
            $tBchCode    = $this->session->userdata("tSesUsrBchCodeMulti");
            $tSQL       .= " AND BCH.FTBchCode IN ($tBchCode) ";
        }

        if ($ptSearchList != '') {
            $tSQL .= " AND (BCH.FTBchCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR BCHL.FTBchName LIKE '%$ptSearchList%')";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {

            return $oQuery->result();
        } else {
            //No Data
            return false;
        }
    }

    //Functionality : Add Branch
    //Parameters : function parameters
    //Creator : 09/03/2018 Krit(Copter)
    //Last Modified : -
    //Return : response
    //Return Type : Array
    public function FSaMBCHAdd($paDataMaster) {
        $tStaDup = $this->FSnMBCHCheckduplicate($paDataMaster['FTBchCode']); //ส่งค่าไปหา duplicate
        $nStaDup = $tStaDup[0]->counts;
        if($nStaDup == 0){
            if( $paDataMaster['FTBchStaHQ'] == '1' ){ // Napat(Jame) 17/05/2021 ถ้าติ๊กเลือกให้สาขานี้เป็น HQ ต้องเคลียร์ค่า สาขา HQ ที่อยู่ภายใต้ตัวเองออกก่อน
                // $tSesUsrAgnCode = $this->session->userdata("tSesUsrAgnCode");
                $this->db->set('FTBchStaHQ', ' ');
                // $this->db->where('FTBchType', '4');
                // if( $paDataMaster['FTBchType'] == '4' ){
                //     $this->db->where('FTAgnCode', $tSesUsrAgnCode);
                // }

                if( $paDataMaster['FTBchType'] == '4' ){ // Napat(Jame) 17/05/2021 ต้องเป็น Type 4 เท่านั้น ถึงจะ Where Agency Code
                    $this->db->where('FTAgnCode', $paDataMaster['FTAgnCode']);
                }
    
                $this->db->where('FTBchType', $paDataMaster['FTBchType']);
                $this->db->update('TCNMBranch');
            }

            $this->db->insert('TCNMBranch', array(
                'FTBchCode'         => $paDataMaster['FTBchCode'],
                'FTWahCode'         => $paDataMaster['FTWahCode'],
                'FTPplCode'         => $paDataMaster['FTPplCode'],
                'FTAgnCode'         => $paDataMaster['FTAgnCode'],
                // 'FTMerCode'         => $paDataMaster['FTMerCode'],
                'FNBchDefLang'      => $paDataMaster['FNBchDefLang'],
                'FTBchType'         => $paDataMaster['FTBchType'],
                'FTBchPriority'     => $paDataMaster['FTBchPriority'],
                'FTBchRegNo'        => $paDataMaster['FTBchRegNo'],
                'FTBchRefID'        => $paDataMaster['FTBchRefID'],
                'FDBchStart'        => $paDataMaster['FDBchStart'],
                'FDBchStart'        => $paDataMaster['FDBchStart'],
                'FDBchStop'         => $paDataMaster['FDBchStop'],
                'FDBchSaleStart'    => $paDataMaster['FDBchSaleStart'],
                'FDBchSaleStop'     => $paDataMaster['FDBchSaleStop'],
                'FTBchStaActive'    => $paDataMaster['FTBchStaActive'],
                'FTBchStaHQ'        => $paDataMaster['FTBchStaHQ'],
                'FDCreateOn'        => $paDataMaster['FDCreateOn'],
                'FTCreateBy'        => $paDataMaster['FTCreateBy'],
                'FDLastUpdOn'       => $paDataMaster['FDLastUpdOn'],
                'FTLastUpdBy'       => $paDataMaster['FTLastUpdBy'],
            ));

            if ($this->db->affected_rows() > 0) {
                $nBchID     = $this->db->insert_id();
                $StaAddLang = $this->FSnMBchAddLang($paDataMaster); // Add Language
                if ($StaAddLang != '1') {
                    //Ploblem
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'cannot insert database.',
                    );
                    $jStatus = json_encode($aStatus);
                    $aStatus = json_decode($jStatus, true);
                } else {
                    //Success
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'success',
                        'nStaCallBack' => $paDataMaster['FTBchCode']
                    );
                    $jStatus = json_encode($aStatus);
                    $aStatus = json_decode($jStatus, true);
                }
            } else {
                return 0;
            }
        } else {
            //Duplicate
            $aStatus = array(
                'rtCode' => '801',
                'rtDesc' => 'data is duplicate.',
            );
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
        }

        return $aStatus;
    }

    //Functionality : Add Lang Branch
    //Parameters : function parameters
    //Creator : 09/03/2018 Krit(Copter)
    //Last Modified : -
    //Return : response
    //Return Type : num
    public function FSnMBchAddLang($paData) {

        $this->db->insert('TCNMBranch_L', array(
            'FTBchCode' => $paData['FTBchCode'],
            'FNLngID' => $paData['FNLngID'],
            'FTBchName' => $paData['FTBchName'],
        ));

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    //Functionality : Checkduplicate
    //Parameters : function parameters
    //Creator : 09/03/2018 Krit(Copter)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSnMBCHCheckduplicate($ptBchCode) {

        $tSQL = "SELECT COUNT(FTBchCode)AS counts
		FROM TCNMBranch
		WHERE FTBchCode = '$ptBchCode' ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    //Functionality : insert Wahouse Default 00001-00003
    //Parameters : function parameters
    //Creator : 10/03/2020 nale
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMBCHWahDefaultInsert($paDataMaster){

    //    $FTWahCode1 = FCNaHGenCodeV5('TCNMWaHouse','0',$paDataMaster['FTBchCode']);
    //    $FTWahCode2 = FCNaHGenCodeV5('TCNMWaHouse','0',$paDataMaster['FTBchCode']);
    //    $FTWahCode3 = FCNaHGenCodeV5('TCNMWaHouse','0',$paDataMaster['FTBchCode']);

        $aDataWahDefualt[0] = array(
            'FTBchCode'         => $paDataMaster['FTBchCode'],
            'FTWahCode'         => '00001',
            'FTWahStaType'      => 1,
            'FTWahRefCode'      => '',
            'FTWahStaChkStk'    => '1',
            'FTWahStaPrcStk'    => '2', //ตัดสต็อก
            'FDCreateOn'        => date('Y-m-d H:i:s'),
            'FTCreateBy'        => $paDataMaster['FTCreateBy'],
            'FDLastUpdOn'       => date('Y-m-d H:i:s'),
            'FTLastUpdBy'       => $paDataMaster['FTLastUpdBy']
        );
        // $aDataWahDefualt[1] = array(
        //     'FTBchCode'         => $paDataMaster['FTBchCode'],
        //     'FTWahCode'         => '00002',
        //     'FTWahStaType'      => 1,
        //     'FTWahRefCode'      => $paDataMaster['FTBchCode'],
        //     'FDCreateOn'        => date('Y-m-d H:i:s'),
        //     'FTCreateBy'        => $paDataMaster['FTCreateBy'],
        //     'FDLastUpdOn'       => date('Y-m-d H:i:s'),
        //     'FTLastUpdBy'       => $paDataMaster['FTLastUpdBy']
        // );
        // $aDataWahDefualt[2] = array(
        //     'FTBchCode'         => $paDataMaster['FTBchCode'],
        //     'FTWahCode'         => '00003',
        //     'FTWahStaType'      => 1,
        //     'FTWahRefCode'      => $paDataMaster['FTBchCode'],
        //     'FDCreateOn'        => date('Y-m-d H:i:s'),
        //     'FTCreateBy'        => $paDataMaster['FTCreateBy'],
        //     'FDLastUpdOn'       => date('Y-m-d H:i:s'),
        //     'FTLastUpdBy'       => $paDataMaster['FTLastUpdBy']
        // );
        $this->db->insert_batch('TCNMWaHouse',$aDataWahDefualt);

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
            } else {
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot insert database.',
            );
            }

    }


    //Functionality : insert Wahouse Default 00001-00003
    //Parameters : function parameters
    //Creator : 10/03/2020 nale
    //Last Modified : Napat(Jame) 2020/08/31 สร้างแค่คลังขาย อย่างเดียว คลังอื่นไม่ได้ใช้งานจริง #พี่ที
    //Return : data
    //Return Type : Array
    public function FSaMBCHWahDefaultInsert_L($paDataMaster){
        $aDataWahDefualt = array();
        array_push($aDataWahDefualt,array(
            'FTBchCode'         => $paDataMaster['FTBchCode'],
            'FTWahCode'         => '00001',
            'FNLngID'           => 1,
            'FTWahName'         => 'คลังขาย',
        ));
        array_push($aDataWahDefualt,array(
            'FTBchCode'         => $paDataMaster['FTBchCode'],
            'FTWahCode'         => '00001',
            'FNLngID'           => 2,
            'FTWahName'         => 'Sales warehouse',
        ));
        // $aDataWahDefualt[0] = array(
        //     'FTBchCode'         => $paDataMaster['FTBchCode'],
        //     'FTWahCode'         => '00001',
        //     'FNLngID'           => 1,
        //     'FTWahName'         => 'คลังขาย',
        // );
        // $aDataWahDefualt[1] = array(
        //     'FTBchCode'         => $paDataMaster['FTBchCode'],
        //     'FTWahCode'         => '00002',
        //     'FNLngID'           => 1,
        //     'FTWahName'         => 'คลังของเสีย',
        // );
        // $aDataWahDefualt[2] = array(
        //     'FTBchCode'         => $paDataMaster['FTBchCode'],
        //     'FTWahCode'         => '00003',
        //     'FNLngID'           => 1,
        //     'FTWahName'         => 'คลังของแถม',
        // );
        // $aDataWahDefualt[3] = array(
        //     'FTBchCode'         => $paDataMaster['FTBchCode'],
        //     'FTWahCode'         => '00001',
        //     'FNLngID'           => 2,
        //     'FTWahName'         => 'Sales warehouse',
        // );
        // $aDataWahDefualt[4] = array(
        //     'FTBchCode'         => $paDataMaster['FTBchCode'],
        //     'FTWahCode'         => '00002',
        //     'FNLngID'           => 2,
        //     'FTWahName'         => 'Waste warehouse',
        // );
        // $aDataWahDefualt[5] = array(
        //     'FTBchCode'         => $paDataMaster['FTBchCode'],
        //     'FTWahCode'         => '00003',
        //     'FNLngID'           => 2,
        //     'FTWahName'         => 'Free inventory',
        // );

        $this->db->insert_batch('TCNMWaHouse_L',$aDataWahDefualt);

        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
            } else {
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot insert database.',
            );
            }

    }


    //Functionality : Update Zone
    //Parameters : function parameters
    //Creator : 09/03/2018 Krit(Copter)
    //Last Modified : -
    //Return : response
    //Return Type : Array
    public function FSaMZneUpdateAddress($paData) {
        try {
            //Update Master
            $this->db->set('FTZneTable', $paData['FTZneTable']);
            // $this->db->set('FTZneCode' , $paData['FTZneCode']);
            $this->db->set('FTZneRefCode', $paData['FTAddRefCode']);
            $this->db->set('FTZneKey', $paData['FTZneCode']);
            $this->db->set('FTZneChain', $paData['FTZneChain']);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTCreateBy', $paData['FTCreateBy']);
            $this->db->where('FTZneRefCode', $paData['FTAddRefCode']);
            $this->db->update('TCNMZoneObj');

            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            } else {
                //Add Master
                $this->db->insert('TCNMZoneObj', array(
                    'FTZneTable' => $paData['FTZneTable'],
                    'FTZneKey' => $paData['FTZneCode'],
                    'FTZneRefCode' => $paData['FTAddRefCode'],
                    'FTZneChain' => $paData['FTZneChain'],
                    'FDLastUpdOn' => $paData['FDLastUpdOn'],
                    'FDCreateOn' => $paData['FDCreateOn'],
                    'FTCreateBy' => $paData['FTCreateBy']
                ));
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Master Success',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //Functionality : Update Branch
    //Parameters : function parameters
    //Creator : 09/03/2018 Krit(Copter)
    //Last Modified : -
    //Return : response
    //Return Type : Array
    public function FSaMBCHUpdateAddress($paData) {
        $this->db->set('FTAddV1No', $paData['FTAddV1No']);
        $this->db->set('FTAddV1Soi', $paData['FTAddV1Soi']);
        $this->db->set('FTAddV1Village', $paData['FTAddV1Village']);
        $this->db->set('FTAddV1Road', $paData['FTAddV1Road']);
        $this->db->set('FTAddV1SubDist', $paData['FTAddV1SubDist']);
        $this->db->set('FTAddV1DstCode', $paData['FTAddV1DstCode']);
        $this->db->set('FTAddV1PvnCode', $paData['FTAddV1PvnCode']);
        $this->db->set('FTAddV1PostCode', $paData['FTAddV1PostCode']);
        $this->db->set('FTAddV2Desc1', $paData['FTAddV2Desc1']);
        $this->db->set('FTAddV2Desc2', $paData['FTAddV2Desc2']);
        // $this->db->set('FTAreCode' , $paData['FTAreCode']);
        // $this->db->set('FTZneCode' , $paData['FTZneCode']);

        $this->db->where('FTAddGrpType', $paData['FTAddGrpType']);
        $this->db->where('FTAddRefCode', $paData['FTAddRefCode']);
        $this->db->where('FNLngID', $paData['FNLngID']);
        $this->db->update('TCNMAddress_L');


        if ($this->db->affected_rows() > 0) {
            //Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {

            $this->db->insert('TCNMAddress_L', array(
                'FTAddV1No' => $paData['FTAddV1No'],
                'FTAddV1Soi' => $paData['FTAddV1Soi'],
                'FTAddV1Village' => $paData['FTAddV1Village'],
                'FTAddV1Road' => $paData['FTAddV1Road'],
                'FTAddV1SubDist' => $paData['FTAddV1SubDist'],
                'FTAddV1DstCode' => $paData['FTAddV1DstCode'],
                'FTAddV1PvnCode' => $paData['FTAddV1PvnCode'],
                'FTAddV1PostCode' => $paData['FTAddV1PostCode'],
                'FTAddV2Desc1' => $paData['FTAddV2Desc1'],
                'FTAddV2Desc2' => $paData['FTAddV2Desc2'],
                'FTAddGrpType' => $paData['FTAddGrpType'],
                'FTAddVersion' => $paData['FTAddVersion'],
                'FTAddRefCode' => $paData['FTAddRefCode'],
                'FNLngID' => $paData['FNLngID'],
                    // 'FTAreCode' => $paData['FTAreCode'],
                    // 			'FTZneCode' => $paData['FTZneCode'],
            ));



            if ($this->db->affected_rows() > 0) {
                //Success
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'success',
                );
            } else {
                //Ploblem
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'cannot Insert database.',
                );
            }
        }

        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }

    //Functionality : Update Branch
    //Parameters : function parameters
    //Creator : 09/03/2018 Krit(Copter)
    //Last Modified : -
    //Return : response
    //Return Type : Array
    public function FSaMBCHUpdate($paData) {

        // เคลียค่า StaHQ AD อื่นๆ ให้เป็นค่าว่างเปล่า Sooksanti (Nont) 12/01/2021
        if( $paData['FTBchStaHQ'] == '1' ){ // Napat(Jame) 17/05/2021 ถ้าติ๊กเลือกให้สาขานี้เป็น HQ ต้องเคลียร์ค่า สาขา HQ ที่อยู่ภายใต้ตัวเองออกก่อน 
            $this->db->set('FTBchStaHQ', ' ');

            if( $paData['FTBchType'] == '4' ){ // Napat(Jame) 17/05/2021 ต้องเป็น Type 4 เท่านั้น ถึงจะ Where Agency Code
                $this->db->where('FTAgnCode', $paData['FTAgnCode']);
            }

            $this->db->where('FTBchType', $paData['FTBchType']);
            $this->db->update('TCNMBranch');
        }

	    $this->db->set('FNBchDefLang', $paData['FNBchDefLang']);
        $this->db->set('FTBchType', $paData['FTBchType']);
        $this->db->set('FTPplCode', $paData['FTPplCode']);
        $this->db->set('FTAgnCode', $paData['FTAgnCode']);
        // $this->db->set('FTBchType', $paData['FTBchType']);
        // $this->db->set('FTMerCode', $paData['FTMerCode']);
        $this->db->set('FTWahCode', $paData['FTWahCode']);
        $this->db->set('FTBchPriority', $paData['FTBchPriority']);
        $this->db->set('FTBchRegNo', $paData['FTBchRegNo']);
        $this->db->set('FTBchRefID', $paData['FTBchRefID']);
        $this->db->set('FDBchStart', $paData['FDBchStart']);
        $this->db->set('FDBchStop', $paData['FDBchStop']);
        $this->db->set('FDBchSaleStart', $paData['FDBchSaleStart']);
        $this->db->set('FDBchSaleStop', $paData['FDBchSaleStop']);
        $this->db->set('FTBchStaActive', $paData['FTBchStaActive']);
        if($paData['FTBchStaHQ'] == '1'){
            $this->db->set('FTBchStaHQ', $paData['FTBchStaHQ']);
        }

        $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        //$this->db->where('FTBchType', '4');
        // if($paData['FTAgnCode'] != ''){
        //     $this->db->where('FTAgnCode', $paData['FTAgnCode']);
        // }

        $this->db->update('TCNMBranch');

        if ($this->db->affected_rows() > 0) {
            $StaUpdLang = $this->FSnMBCHUpdateLang($paData); // Add Language
            if ($StaUpdLang != 1) { //หาภาษาที่จะแก้ไขไม่เจอ
                $StaAddLang = $this->FSnMBchAddLang($paData);
                if ($StaAddLang != 1) {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'cannot update database.',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'success',
                    );
                }
            }else{
                //Success
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'success',
                );
            }
        }else{
            //Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot update database',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }

    //Functionality : Update Lang Branch
    //Parameters : function parameters
    //Creator : 09/03/2018 Krit(Copter)
    //Last Modified : -
    //Return : response
    //Return Type : num
    public function FSnMBCHUpdateLang($paData) {
        $this->db->set('FTBchName', $paData['FTBchName']);
        $this->db->set('FTBchRmk', $paData['FTBchRmk']);
        $this->db->where('FNLngID', $paData['FNLngID']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->update('TCNMBranch_L');
        if($this->db->affected_rows() > 0) {
            return 1;
        }else{
            return 0;
        }
    }

    //Functionality : delete Branch
    //Parameters : function parameters
    //Creator : 09/03/2018 Krit(Copter)
    //Return : response
    //Return Type : array
    public function FSnMBCHDel($paParamMaster) {

        try {
            $this->db->trans_begin();

            $this->db->where_in('FTBchCode', $paParamMaster['FTBchCode']);
            $this->db->delete('TCNMBranch');

            $this->db->where_in('FTBchCode', $paParamMaster['FTBchCode']);
            $this->db->delete('TCNMBranch_L');

            $this->db->where_in('FTBchCode', $paParamMaster['FTBchCode']);
            $this->db->delete('TCNMWaHouse');

            $this->db->where_in('FTBchCode', $paParamMaster['FTBchCode']);
            $this->db->delete('TCNMWaHouse_L');

            $this->db->where_in('FTImgRefID', $paParamMaster['FTBchCode']);
            $this->db->where_in('FTImgTable', 'TCNMBranch');
            $this->db->delete('TCNMImgObj');

            $this->db->where_in('FTBchCode', $paParamMaster['FTBchCode']);
            $this->db->delete('TCNTUsrGroup');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Cannot Delete Item.',
                );
            } else {
                $this->db->trans_commit();
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Delete Complete.',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //Save Imgage
    public function FSaMBCHAddImgObj($ptImgRefID, $pnImgType, $ptImgObj) {


        $this->db->set('FTImgObj', $ptImgObj);

        $this->db->where('FTImgRefID', $ptImgRefID);
        $this->db->where('FTImgTable', $pnImgType);
        $this->db->update('TCNMImgObj');

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            $this->db->insert('TCNMImgObj', array(
                'FTImgRefID' => $ptImgRefID,
                'FNImgSeq' => '1',
                'FTImgTable' => $pnImgType,
                'FTImgObj' => $ptImgObj,
            ));

            if ($this->db->affected_rows() > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    /**
     * Functionality : Get Branch Info by Code
     * Parameters : function parameters
     * Creator :  31/07/2019 Piya
     * Return : data
     * Return Type : Array
     */
    public function FSaMCMPGetBchInfo($paParams){
        $nLangID = $paParams['nLngID'];
        $tBchCode = $paParams['tBchCode'];

        $tSQL = "
            SELECT TOP 1
		*
            FROM TCNMBranch BCH WITH (NOLOCK)
            LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON BCHL.FTBchCode = BCH.FTBchCode AND BCHL.FNLngID = $nLangID
            LEFT JOIN TCNMAddress_L ADDL WITH (NOLOCK) ON ADDL.FTAddRefCode = BCH.FTBchCode AND ADDL.FTAddGrpType = '1'
            WHERE BCH.FTBchCode = '$tBchCode'
        ";

        $oQuery = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0) {
            $aItems = $oQuery->row_array();
            $aResult = array(
                'raItems'       => $aItems,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else {
            // No Data
            $aResult = array(
                'raItems' => '',
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }

        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //เอาข้อมูลภาษาของเครื่อง
    function FSvMBCHGetSyslangSystems(){
        $tSQL = " SELECT * FROM TSysLanguage WITH (NOLOCK)";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0) {
            $aItems = $oQuery->result_array();
            $aResult = array(
                'raItems'       => $aItems,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else {
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        return $aResult;
    }


        /**
     * Functionality : Get Branch Detail By User
     * Parameters : function parameters
     * Creator :  19/02/2020 Nale
     * Return : data
     * Return Type : Array
     */
    public function FSaMCMPGetDetailUserBranch($paBchCode){
        if(!empty($paBchCode)){
          $aReustl = $this->db->where('FTBchCode',$paBchCode)->get('TCNMBranch')->row_array();
        //   $oQuery = $this->db->query($oSql);
        //   $aReustl =  $oQuery->row_array();
          $aReulst['item'] = $aReustl;
          $aReulst['code'] = 1;
          $aReulst['msg'] = 'Success !';
        }else{
          $aReulst['code'] = 2;
          $aReulst['msg'] = 'Error !';
        }
       return $aReulst;
    }

    public function FSaMBCHGetTempData($paDataSearch){
        $nLngID             = $paDataSearch['nLangEdit'];
        $tTableKey          = $paDataSearch['tTableKey'];
        $tSessionID         = $paDataSearch['tSessionID'];
        $tTextSearch        = $paDataSearch['tTextSearch'];

        $tSQL   = " SELECT
                        IMP.FNTmpSeq,
                        IMP.FTBchCode,
                        IMP.FTBchName,
                        IMP.FTAgnCode,
                        AGN_L.FTAgnName,
                        IMP.FTPplCode,
                        PRI_L.FTPplName,
                        IMP.FTTmpStatus,
                        IMP.FTTmpRemark
                    FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                    LEFT JOIN TCNMAgency_L		AGN_L WITH(NOLOCK) ON IMP.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                    LEFT JOIN TCNMPdtPriList_L	PRI_L WITH(NOLOCK) ON IMP.FTPplCode = PRI_L.FTPplCode AND PRI_L.FNLngID = $nLngID
                    WHERE 1=1
                        AND IMP.FTSessionID     = '$tSessionID'
                        AND FTTmpTableKey       = '$tTableKey'
        ";

        if($tTextSearch != '' || $tTextSearch != null){
            $tSQL .= " AND (IMP.FTBchCode LIKE '%$tTextSearch%' ";
            $tSQL .= " OR IMP.FTBchName LIKE '%$tTextSearch%' ";
            $tSQL .= " OR IMP.FTAgnCode LIKE '%$tTextSearch%' ";
            $tSQL .= " OR AGN_L.FTAgnName LIKE '%$tTextSearch%' ";
            $tSQL .= " OR IMP.FTPplCode LIKE '%$tTextSearch%' ";
            $tSQL .= " OR PRI_L.FTPplName LIKE '%$tTextSearch%' ";
            $tSQL .= " )";
        }

        $tSQL .= " ORDER BY IMP.FTBchCode";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aStatus = array(
                'tCode'     => '1',
                'tDesc'     => 'success',
                'aResult'   => $oQuery->result_array(),
                'numrow'    => $oQuery->num_rows()
            );
        }else{
            $aStatus = array(
                'tCode'     => '99',
                'tDesc'     => 'Error',
                'aResult'   => array(),
                'numrow'    => 0
            );
        }
        return $aStatus;
    }

    //Functionality : Delete Import Branch
    //Parameters : function parameters
    //Create By : 09/07/2020 Napat(Jame)
    //Return : response
    //Return Type : array
    public function FSaMBCHImportDelete($paParamMaster) {
        try{
            $this->db->where_in('FNTmpSeq', $paParamMaster['FNTmpSeq']);
            $this->db->delete('TCNTImpMasTmp');

            if($this->db->trans_status() === FALSE){
                $aStatus = array(
                    'tCode' => '905',
                    'tDesc' => 'Cannot Delete Item.',
                );
            }else{
                $aStatus = array(
                    'tCode' => '1',
                    'tDesc' => 'Delete Complete.',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    public function FSaMBCHImportMove2Master($paDataSearch){
        try{
            $nLngID         = $paDataSearch['nLangEdit'];
            $tTableKey      = $paDataSearch['tTableKey'];
            $tSessionID     = $paDataSearch['tSessionID'];
            $dDateOn        = $paDataSearch['dDateOn'];
            $tUserBy        = $paDataSearch['tUserBy'];

            $dBchDateStart  = $paDataSearch['dBchDateStart'];
            $dBchDateStop  = $paDataSearch['dBchDateStop'];

            $tSQL   = " INSERT INTO TCNMBranch (
                            FTBchCode,FTAgnCode,FTPplCode,FTWahCode,FTBchType,FTBchPriority,FTBchStaActive,
                            FDBchStart,FDBchStop,FDBchSaleStart,FDBchSaleStop,
                            FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy
                        )
                        SELECT
                            IMP.FTBchCode,
                            IMP.FTAgnCode,
                            IMP.FTPplCode,
                            '00001',
                            CASE WHEN ISNULL(IMP.FTAgnCode,'') = '' THEN '1' ELSE '4' END AS FTBchType,
                            '1',
                            '1',
                            '$dBchDateStart',
                            '$dBchDateStop',
                            '$dBchDateStart',
                            '$dBchDateStop',
                            '$dDateOn',
                            '$tUserBy',
                            '$dDateOn',
                            '$tUserBy'
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID       = '$tSessionID'
                          AND IMP.FTTmpTableKey     = '$tTableKey'
                          AND IMP.FTTmpStatus       = '1'
            ";
            $this->db->query($tSQL);

            $tSQL   = " INSERT INTO TCNMBranch_L (FTBchCode,FNLngID,FTBchName)
                        SELECT
                            IMP.FTBchCode,
                            $nLngID,
                            IMP.FTBchName
                        FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                        WHERE IMP.FTSessionID       = '$tSessionID'
                          AND IMP.FTTmpTableKey     = '$tTableKey'
                          AND IMP.FTTmpStatus       = '1'
            ";
            $this->db->query($tSQL);

            if($this->db->trans_status() === FALSE){
                $aStatus = array(
                    'tCode'     => '99',
                    'tDesc'     => 'Error'
                );
            }else{
                $aStatus = array(
                    'tCode'     => '1',
                    'tDesc'     => 'success'
                );
            }
            return $aStatus;
        }catch(Exception $Error) {
            return $Error;
        }
    }

    //เพิ่มคลังกรณี import file สาขา
    public function FSaMBCHImportMove2MasterAndInsWah($paDataSearch){
        try{
            $tSessionID     = $paDataSearch['tSessionID'];
            $dDateOn        = $paDataSearch['dDateOn'];
            $tUserBy        = $paDataSearch['tUserBy'];
            $tTableKey      = $paDataSearch['tTableKey'];

            //Insert ลงตาราง TCNMWaHouse
            $tSQL   = " INSERT INTO TCNMWaHouse (FTBchCode,FTWahCode,FTWahStaType,FTWahRefCode,FTWahStaChkStk,FTWahStaPrcStk,FDCreateOn,FTCreateBy,FDLastUpdOn,FTLastUpdBy)
                        SELECT PACKDATA.*
                        FROM TCNTImpMasTmp Tmp
                        CROSS APPLY (
                            VALUES
                                (FTBchCode,'00001',1,FTBchCode,'1','2','$dDateOn','$tUserBy','$dDateOn','$tUserBy')
                        ) PACKDATA (FTBchCode,FTWahCode,FTWahStaType,FTWahRefCode,FTWahStaChkStk,FTWahStaPrcStk,FDCreateOn,FTCreateBy,FDLastUpdOn,FTLastUpdBy)
                        WHERE Tmp.FTSessionID = '$tSessionID' AND Tmp.FTTmpStatus = '1' ";
                        /*
                        , (FTBchCode,'00002',1,FTBchCode,'$dDateOn','$tUserBy','$dDateOn','$tUserBy')
                        , (FTBchCode,'00003',1,FTBchCode,'$dDateOn','$tUserBy','$dDateOn','$tUserBy')
                        */
            $this->db->query($tSQL);

            //Insert ลงตาราง TCNMWaHouse_L
            $tSQL   = " INSERT INTO TCNMWaHouse_L (FTBchCode,FTWahCode,FNLngID,FTWahName)
                        SELECT PACKDATA.*
                        FROM TCNTImpMasTmp Tmp
                        CROSS APPLY (
                            VALUES
                                (FTBchCode,'00001','1','คลังขาย'),
                                (FTBchCode,'00001','2','Sales Warehouse')
                        ) PACKDATA (FTBchCode,FTWahCode,FNLngID,FTWahName)
                        WHERE Tmp.FTSessionID = '$tSessionID' AND Tmp.FTTmpStatus = '1' ";
                        /*
                        , (FTBchCode,'00002','1','คลังของเสีย')
                        , (FTBchCode,'00003','1','คลังของแถม')
                        , (FTBchCode,'00002','2','Waste warehouse')
                        , (FTBchCode,'00003','2','Free inventory')
                        */
            $this->db->query($tSQL);

        }catch(Exception $Error) {
            return $Error;
        }
    }

    //เช็คกรณีข้อมูลซ้ำ
    public function FSaMBCHImportMove2MasterAndReplaceOrInsert($paDataSearch){
        try{
            $tSessionID         = $paDataSearch['tSessionID'];
            $dDateOn            = $paDataSearch['dDateOn'];
            $tUserBy            = $paDataSearch['tUserBy'];
            $tTableKey          = $paDataSearch['tTableKey'];
            $tTypeCaseDuplicate = $paDataSearch['tTypeCaseDuplicate'];
            $nLngID             = $paDataSearch['nLangEdit'];
            $dBchDateStart      = $paDataSearch['dBchDateStart'];
            $dBchDateStop       = $paDataSearch['dBchDateStop'];

            if($tTypeCaseDuplicate == 2){
                //อัพเดทรายการเดิม

                //อัพเดทชื่อที่ตาราง L
                $tSQLUpdate_L = "UPDATE
                                    TCNMBranch_L
                                SET
                                    TCNMBranch_L.FTBchName = TCNTImpMasTmp.FTBchName
                                FROM
                                    TCNMBranch_L
                                INNER JOIN
                                    TCNTImpMasTmp
                                ON
                                    TCNMBranch_L.FTBchCode = TCNTImpMasTmp.FTBchCode
                                WHERE
                                    TCNTImpMasTmp.FTSessionID = '$tSessionID'
                                AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMBranch'
                                AND TCNTImpMasTmp.FTTmpStatus = '6' ";
                $this->db->query($tSQLUpdate_L);

                //อัพเดทตัวแทนขาย กับ กลุ่มราคา
                $tSQLUpdate = "UPDATE
                                    TCNMBranch
                                SET
                                    TCNMBranch.FTPplCode = TCNTImpMasTmp.FTPplCode,
                                    TCNMBranch.FTAgnCode = TCNTImpMasTmp.FTAgnCode,
                                    TCNMBranch.FDLastUpdOn = '$dDateOn',
                                    TCNMBranch.FTLastUpdBy = '$tUserBy'
                                FROM
                                    TCNMBranch
                                INNER JOIN
                                    TCNTImpMasTmp
                                ON
                                    TCNMBranch.FTBchCode = TCNTImpMasTmp.FTBchCode
                                WHERE
                                    TCNTImpMasTmp.FTSessionID = '$tSessionID'
                                AND TCNTImpMasTmp.FTTmpTableKey = 'TCNMBranch'
                                AND TCNTImpMasTmp.FTTmpStatus = '6' ";
                $this->db->query($tSQLUpdate);
            }else if($tTypeCaseDuplicate == 1){
                //ใช้รายการใหม่

                //ลบข้อมูลในตาราง L
                $tSQLDeleteBch_L = "DELETE FROM TCNMBranch_L WHERE FTBchCode IN (
                                    SELECT FTBchCode
                                    FROM TCNTImpMasTmp
                                    WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMBranch'
                                )";
                $this->db->query($tSQLDeleteBch_L);

                //ลบข้อมูลในตารางจริง
                $tSQLDeleteBch = "DELETE FROM TCNMBranch WHERE FTBchCode IN (
                                        SELECT FTBchCode
                                        FROM TCNTImpMasTmp
                                        WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6 AND FTTmpTableKey = 'TCNMBranch'
                                    )";
                $this->db->query($tSQLDeleteBch);

                /*
                    //ลบข้อมูลในตารางคลังสินค้า L
                    $tSQLDeleteWah_L = "DELETE FROM TCNMWaHouse_L WHERE FTBchCode IN (
                                        SELECT FTBchCode
                                        FROM TCNTImpMasTmp
                                        WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6
                                    )";
                    $this->db->query($tSQLDeleteWah_L);

                    //ลบข้อมูลในตารางคลังสินค้า
                    $tSQLDeleteWah = "DELETE FROM TCNMWaHouse WHERE FTBchCode IN (
                                        SELECT FTBchCode
                                        FROM TCNTImpMasTmp
                                        WHERE FTSessionID = '$tSessionID' AND FTTmpStatus = 6
                                    )";
                    $this->db->query($tSQLDeleteWah);

                    //Insert ลงตาราง TCNMWaHouse
                    $tSQL   = " INSERT INTO TCNMWaHouse (FTBchCode,FTWahCode,FTWahStaType,FTWahRefCode,FDCreateOn,FTCreateBy,FDLastUpdOn,FTLastUpdBy)
                                SELECT PACKDATA.*
                                FROM TCNTImpMasTmp Tmp
                                CROSS APPLY (
                                    VALUES
                                        (FTBchCode,'00001',1,'00001','$dDateOn','$tUserBy','$dDateOn','$tUserBy')
                                        , (FTBchCode,'00002',1,'00002','$dDateOn','$tUserBy','$dDateOn','$tUserBy')
                                        , (FTBchCode,'00003',1,'00003','$dDateOn','$tUserBy','$dDateOn','$tUserBy')
                                ) PACKDATA (FTBchCode,FTWahCode,FTWahStaType,FTWahRefCode,FDCreateOn,FTCreateBy,FDLastUpdOn,FTLastUpdBy)
                                WHERE Tmp.FTSessionID = '$tSessionID' AND Tmp.FTTmpStatus = '6' ";
                    $this->db->query($tSQL);

                    //Insert ลงตาราง TCNMWaHouse_L
                    $tSQL   = " INSERT INTO TCNMWaHouse_L (FTBchCode,FTWahCode,FNLngID,FTWahName)
                                SELECT PACKDATA.*
                                FROM TCNTImpMasTmp Tmp
                                CROSS APPLY (
                                    VALUES
                                        (FTBchCode,'00001','1','คลังขาย')
                                        , (FTBchCode,'00002','1','คลังของเสีย')
                                        , (FTBchCode,'00003','1','คลังของแถม')
                                        , (FTBchCode,'00001','2','Sales warehouse')
                                        , (FTBchCode,'00002','2','Waste warehouse')
                                        , (FTBchCode,'00003','2','Free inventory')
                                ) PACKDATA (FTBchCode,FTWahCode,FNLngID,FTWahName)
                                WHERE Tmp.FTSessionID = '$tSessionID' AND Tmp.FTTmpStatus = '6' ";
                    $this->db->query($tSQL);
                */

                //เพิ่มข้อมูลที่เป็น BCH Type 6
                $tSQL   = " INSERT INTO TCNMBranch (
                                FTBchCode,FTAgnCode,FTPplCode,FTWahCode,
                                FDBchStart,FDBchStop,FDBchSaleStart,FDBchSaleStop,
                                FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy
                            )
                            SELECT
                                IMP.FTBchCode,
                                IMP.FTAgnCode,
                                IMP.FTPplCode,
                                '',
                                '$dBchDateStart',
                                '$dBchDateStop',
                                '$dBchDateStart',
                                '$dBchDateStop',
                                '$dDateOn',
                                '$tUserBy',
                                '$dDateOn',
                                '$tUserBy'
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID     = '$tSessionID'
                            AND IMP.FTTmpTableKey     = '$tTableKey'
                            AND IMP.FTTmpStatus       = '6'
                ";
                $this->db->query($tSQL);

                //เพิ่มข้อมูลที่เป็น BCH_L Type 6
                $tSQL   = " INSERT INTO TCNMBranch_L (FTBchCode,FNLngID,FTBchName)
                            SELECT
                                IMP.FTBchCode,
                                $nLngID,
                                IMP.FTBchName
                            FROM TCNTImpMasTmp IMP WITH(NOLOCK)
                            WHERE IMP.FTSessionID       = '$tSessionID'
                            AND IMP.FTTmpTableKey     = '$tTableKey'
                            AND IMP.FTTmpStatus       = '6'
                ";
                $this->db->query($tSQL);
            }
        }catch(Exception $Error) {
            return $Error;
        }
    }

    //ลบข้อมูลใน Temp
    public function FSaMBCHImportMove2MasterDeleteTemp($paDataSearch){
        try{
            $tSessionID     = $paDataSearch['tSessionID'];
            $dDateOn        = $paDataSearch['dDateOn'];
            $tUserBy        = $paDataSearch['tUserBy'];
            $tTableKey      = $paDataSearch['tTableKey'];

            // ลบรายการใน Temp
            $this->db->where('FTSessionID', $tSessionID);
            $this->db->where('FTTmpTableKey', $tTableKey);
            $this->db->delete('TCNTImpMasTmp');
        }catch(Exception $Error) {
            return $Error;
        }

    }

    //Get ข้อมูลใน Temp ทั้งหมด
    public function FSaMBCHGetTempDataAtAll(){
        try{
            $tSesSessionID = $this->session->userdata("tSesSessionID");
            $tSQL   = "SELECT TOP 1
                        (SELECT COUNT(FTTmpTableKey) AS TYPESIX FROM TCNTImpMasTmp IMP
                        WHERE IMP.FTSessionID     = '$tSesSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMBranch'
                        AND IMP.FTTmpStatus       = '6') AS TYPESIX ,

                        (SELECT COUNT(FTTmpTableKey) AS TYPEONE FROM TCNTImpMasTmp IMP
                        WHERE IMP.FTSessionID     = '$tSesSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMBranch'
                        AND IMP.FTTmpStatus       = '1') AS TYPEONE ,

                        (SELECT COUNT(FTTmpTableKey) AS TYPEONE FROM TCNTImpMasTmp IMP
                        WHERE IMP.FTSessionID     = '$tSesSessionID'
                        AND IMP.FTTmpTableKey     = 'TCNMBranch'
                        ) AS ITEMALL
                    FROM TCNTImpMasTmp ";
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array();
        }catch(Exception $Error) {
            return $Error;
        }
    }

   //Functionality : Update Branch ให้กับ user ของของดีลเลอร์ ในกรณีที่สร้างสาขาใหม่ และมีผู้ใช้ ผูกกับ ดีลเลอร์ไว้อยู่แล้ว
    //Parameters : function parameters
    //Create By : 14/08/2020 Nattakit (Nale)
    //Return : response
    //Return Type : array
    public function FSxMBCHUpdateUsrGrp($paDataMaster){
        try{
            $tAgnCode = $paDataMaster['FTAgnCode'];
            $tBchCode = $paDataMaster['FTBchCode'];
            $dLastUpdOn = $paDataMaster['FDLastUpdOn'];
            $dCreateOn = $paDataMaster['FDCreateOn'];
            $tCreateBy = $paDataMaster['FTCreateBy'];
            $tLastUpdBy = $paDataMaster['FTLastUpdBy'];
            $tSesUserCode  =  $this->session->userdata('tSesUserCode');
              $tSQL = "INSERT INTO TCNTUsrGroup
                                   (FTUsrCode,FTBchCode,FTShpCode,FTMerCode,FTAgnCode,FDCreateOn,FTCreateBy,FDLastUpdOn,FTLastUpdBy)
                            VALUES ('$tSesUserCode','$tBchCode','','','$tAgnCode','$dCreateOn','$tCreateBy','$dLastUpdOn','$tLastUpdBy')
                          ";
         $oQuery = $this->db->query($tSQL);

        //  echo $this->db->last_query();
        //  die();
        }catch(Exception $Error) {
            return $Error;
        }
    }


}
