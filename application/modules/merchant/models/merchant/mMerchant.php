<?php
defined('BASEPATH') or exit('No direct script access allowed');
class mMerchant extends CI_Model{

    //Functionality : list SupplierLevel
    //Parameters : function parameters
    //Creator :  09/10/2018 witsarut
    //Return : data
    //Return Type : Array
    public function FSaMMerchantList($paData)
    {
        try {
            $aRowLen        = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL       = "SELECT c.* FROM(
                                SELECT  ROW_NUMBER() OVER(ORDER BY rtFDCreateOn DESC,rtFTMerCode DESC) AS rtRowID,* FROM
                                    (SELECT DISTINCT
                                        MCN.FTMerCode       AS rtFTMerCode,
                                        MCN.FTMerRefCode    AS rtFTMerRefCode,
                                        MCN.FTMerEmail      AS rtFTMerEmail,
                                        MCN.FTMerMo         AS rtFTMerTel,
                                        MCN.FTMerFax        AS rtFTMerFax,
                                        MCN_L.FTMerName     AS rtFTMerName,
                                        MCN.FTMerStaActive  AS rtFTMerStaActive,
                                        IMG.FTImgObj        AS rtFTImgObj,
                                        MCN.FDCreateOn      AS rtFDCreateOn,
                                        USEMER.FTMercode    AS rtUseMerchant
                                    FROM [TCNMMerchant] MCN
                                    LEFT JOIN [TCNMMerchant_L]  MCN_L ON MCN.FTMerCode = MCN_L.FTMerCode AND MCN_L.FNLngID = $nLngID
                                    LEFT JOIN [TCNMImgObj] IMG ON MCN.FTMerCode = IMG.FTImgRefID AND IMG.FTImgTable = 'TCNMMerchant'
                                    LEFT JOIN (SELECT DISTINCT FTMercode FROM TCNMShop) AS USEMER ON USEMER.FTMercode = MCN.FTMercode
                                    WHERE 1=1 ";
            if (isset($tSearchList) && !empty($tSearchList)) {
                $tSQL .= " AND MCN.FTMerCode COLLATE THAI_BIN LIKE '%$tSearchList%'  OR MCN_L.FTMerName COLLATE THAI_BIN LIKE '%$tSearchList%'";
                // $tSQL .= " AND (MCN.FTMerCode LIKE '%$tSearchList%'";
                // $tSQL .= " OR MCN_L.FTMerName  LIKE '%$tSearchList%')";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMMerchantGetPageAll($tSearchList, $nLngID);
                $nFoundRow = $oFoundRow[0]->counts;
                $nPageAll = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult = array(
                    'raItems'       => $aList,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paData['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                );
            } else {
                //No Data
                $aResult = array(
                    'rnAllRow' => 0,
                    'rnCurrentPage' => $paData['nPage'],
                    "rnAllPage" => 0,
                    'rtCode' => '800',
                    'rtDesc' => 'data not found',
                );
            }
            return $aResult;
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : All Page Of SupplierLevel
    //Parameters : function parameters
    //Creator :  09/10/2018 witsarut
    //Return : object Count All SupplierLevel
    //Return Type : Object
    public function FSoMMerchantGetPageAll($ptSearchList, $ptLngID){
        try {
            $tSQL = "SELECT COUNT (MCN.FTMerCode) AS counts
                     FROM [TCNMMerchant] MCN
                     LEFT JOIN [TCNMMerchant_L]  MCN_L ON MCN.FTMerCode = MCN_L.FTMerCode AND MCN_L.FNLngID = $ptLngID
                     WHERE 1=1 ";
            if (isset($ptSearchList) && !empty($ptSearchList)) {
                $tSQL .= " AND (MCN.FTMerCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR MCN_L.FTMerName  LIKE '%$ptSearchList%')";
            }
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            } else {
                return false;
            }
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Get Data SupplierLevel By ID
    //Parameters : function parameters
    //Creator : 09/10/2018 witsarut
    //Return : data
    //Return Type : Array
    public function FSaMSLVGetDataByID($paData){
        try {
            $tSlvCode   = $paData['FTSlvCode'];
            $nLngID     = $paData['FNLngID'];
            $tSQL       = " SELECT 
                                SLV.FTSlvCode   AS rtSlvCode,
                                SLV_L.FTSlvName AS rtSlvName,
                                SLV_L.FTSlvRmk  AS rtSlvRmk
                            FROM TCNMSplLev SLV
                            LEFT JOIN TCNMSplLev_L SLV_L ON SLV.FTSlvCode = SLV_L.FTSlvCode AND SLV_L.FNLngID = $nLngID 
                            WHERE 1=1 AND SLV.FTSlvCode = '$tSlvCode' ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                $aDetail = $oQuery->row_array();
                $aResult = array(
                    'raItems'   => $aDetail,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            } else {
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'Data not found.',
                );
            }
            return $aResult;
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Checkduplicate SupplierLevel 
    //Parameters : function parameters
    //Creator : 09/10/2018 witsarut
    //Return : data
    //Return Type : Array
    public function FSnMSLVCheckDuplicate($ptSlvCode){
        $tSQL = "SELECT COUNT(SLV.FTSlvCode) AS counts
                 FROM TCNMSplLev SLV 
                 WHERE SLV.FTSlvCode = '$ptSlvCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->row_array();
        } else {
            return FALSE;
        }
    }

    //Functionality : Update SupplierLevel (TCNMSplLev)
    //Parameters : function parameters
    //Creator : 09/10/2018 witsarut
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMSLVAddUpdateMaster($paDataSupplierLevel){
        try {
            // Update TCNMSplLev
            $this->db->where('FTSlvCode', $paDataSupplierLevel['FTSlvCode']);
            $this->db->update('TCNMSplLev', array(
                'FDLastUpdOn'   => $paDataSupplierLevel['FDLastUpdOn'],
                'FTLastUpdBy'   => $paDataSupplierLevel['FTLastUpdBy']
            ));
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update SupplierLevel Success',
                );
            } else {
                //Add TCNMSplLev
                $this->db->insert('TCNMSplLev', array(
                    'FTSlvCode'     => $paDataSupplierLevel['FTSlvCode'],
                    'FDCreateOn'    => $paDataSupplierLevel['FDCreateOn'],
                    'FTCreateBy'    => $paDataSupplierLevel['FTCreateBy']
                ));
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add SupplierLevel Success',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit SupplierLevel.',
                    );
                }
            }
            return $aStatus;
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Update SupplierLevel Lang (TCNMSplLev_L)
    //Parameters : function parameters
    //Creator : 09/10/2018 witsarut
    //Return : Array Stutus Add Update
    //Return Type : array
    public function FSaMSLVAddUpdateLang($paDataSupplierLevel){
        try {
            //Update Pdt Type Lang
            $this->db->where('FNLngID', $paDataSupplierLevel['FNLngID']);
            $this->db->where('FTSlvCode', $paDataSupplierLevel['FTSlvCode']);
            $this->db->update('TCNMSplLev_L', array(
                'FTSlvName' => $paDataSupplierLevel['FTSlvName'],
                'FTSlvRmk'  => $paDataSupplierLevel['FTSlvRmk']
            ));
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update SupplierLevel Lang Success.',
                );
            } else {
                //Add Pdt Type Lang
                $this->db->insert('TCNMSplLev_L', array(
                    'FTSlvCode' => $paDataSupplierLevel['FTSlvCode'],
                    'FNLngID'   => $paDataSupplierLevel['FNLngID'],
                    'FTSlvName' => $paDataSupplierLevel['FTSlvName'],
                    'FTSlvRmk'  => $paDataSupplierLevel['FTSlvRmk']
                ));
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add SupplierLevel Lang Success',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit SupplierLevel Lang.',
                    );
                }
            }
            return $aStatus;
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Delete SupplierLevel
    //Parameters : function parameters
    //Creator : 09/10/2018 witsarut
    //Return : Status Delete
    //Return Type : array
    public function FSaMSLVDelAll($paData){
        try {
            $this->db->trans_begin();

            $this->db->where_in('FTSlvCode', $paData['FTSlvCode']);
            $this->db->delete('TCNMSplLev');

            $this->db->where_in('FTSlvCode', $paData['FTSlvCode']);
            $this->db->delete('TCNMSplLev_L');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Delete Unsuccess.',
                );
            } else {
                $this->db->trans_commit();
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Delete Success.',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    public function FSoMMCNCheckDuplicate($ptMcnCode){
        $tSQL   = "SELECT COUNT(FTMerCode)AS counts
                   FROM TCNMMerchant
                   WHERE FTMerCode = '$ptMcnCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    //Functionality : Add or Update
    //Parameters : function parameters array
    //Creator : 11/06/2019 Sarun
    //Return : Status Update or Add
    //Return Type : array
    public function FSaMMCNAddUpdateMaster($paData){
        try {
            // Update Master
            $this->db->set('FTPplCode', $paData['FTPplCode']);
            $this->db->set('FTMerRefCode', $paData['FTMerRefCode']);
            $this->db->set('FTMerEmail', $paData['FTMcnEmail']);
            $this->db->set('FTMerTel', $paData['FTMcnTel']);
            $this->db->set('FTMerFax', $paData['FTMcnFax']);
            $this->db->set('FTMerMo',  $paData['FTMcnMo']);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
            $this->db->set('FDCreateOn', $paData['FDCreateOn']);
            $this->db->set('FTCreateBy', $paData['FTCreateBy']);

            $this->db->where('FTMerCode', $paData['FTMcnCode']);
            $this->db->update('TCNMMerchant');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            } else {
                // Add Master
                $this->db->insert('TCNMMerchant', array(
                    'FTMerCode'     => $paData['FTMcnCode'],
                    'FTPplCode'     => $paData['FTPplCode'],
                    'FTMerRefCode'  => $paData['FTMerRefCode'],
                    'FTMerEmail'    => $paData['FTMcnEmail'],
                    'FTMerTel'      => $paData['FTMcnTel'],
                    'FTMerFax'      => $paData['FTMcnFax'],
                    'FTMerMo'       => $paData['FTMcnMo'],
                    'FTMerStaActive' => '1',
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy']
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

    //Functionality : Functio Add/Update Lang
    //Parameters : function parameters
    //Creator :  11/06/2019 Sarun
    //Return : Status Add Update Lang
    //Return Type : Array
    public function FSaMMCNAddUpdateLang($paData){
        try {
            // Update Lang
            $this->db->set('FTMerName', $paData['FTMcnName']);
            $this->db->set('FTMerRmk', $paData['FTMcnRmk']);
            $this->db->where('FTMerCode', $paData['FTMcnCode']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->update('TCNMMerchant_L');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            } else {
                //Add Lang
                $this->db->insert('TCNMMerchant_L', array(
                    'FTMerCode'     => $paData['FTMcnCode'],
                    'FNLngID'       => $paData['FNLngID'],
                    'FTMerName'     => $paData['FTMcnName'],
                    'FTMerRmk'      => $paData['FTMcnRmk']
                ));
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Lang Success',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Lang.',
                    );
                }
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    public function FSaMMCNSearchByID($ptAPIReq, $ptMethodReq, $paData){
        $tMcnCode   = $paData['FTMcnCode'];
        $nLngID     = $paData['FNLngID'];

        $tSQL = "
            SELECT
                MCN.FTMerCode   AS rtMcnCode,
                MCN.FTPplCode   AS rtPplCode,
                MCN.FTMerRefCode  AS rtFTMerRefCode,
                MCN.FTMerEmail  AS rtMcnEmail,
                MCN.FTMerTel    AS rtMcnTel,
                MCN.FTMerFax    AS rtMcnFax,
                MCN.FTMerMo     AS rtMcnMo,
                MCNL.FTMerName  AS rtMcnName,
                PPLL.FTPplName  AS rtPplName,
                MCNL.FTMerRmk   AS rtMcnRmk,
                IMG.FTImgObj    AS rtImgObj
            FROM [TCNMMerchant] MCN WITH (NOLOCK)
            LEFT JOIN [TCNMMerchant_L] MCNL WITH (NOLOCK) ON MCN.FTMerCode = MCNL.FTMerCode AND MCNL.FNLngID = $nLngID
            LEFT JOIN [TCNMPdtPriList_L] PPLL WITH (NOLOCK) ON PPLL.FTPplCode = MCN.FTPplCode AND PPLL.FNLngID = $nLngID
            LEFT JOIN [TCNMImgObj] IMG WITH (NOLOCK) ON MCN.FTMerCode = IMG.FTImgRefID AND FTImgTable = 'TCNMMerchant'
            WHERE 1=1 
        ";

        if ($tMcnCode != "") {
            $tSQL .= "AND MCN.FTMerCode = '$tMcnCode'";
        }

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) { // Found
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            // Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }

        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Functionality : Delete Reason
    //Parameters : function parameters
    //Creator : 12/06/2019 Sarun
    //Return : response
    //Return Type : array
    public function FSnMMCNDel($ptAPIReq, $ptMethodReq, $paData){
        $this->db->where_in('FTMerCode', $paData['FTMcnCode']);
        $this->db->delete('TCNMMerchant');

        $this->db->where_in('FTMerCode', $paData['FTMcnCode']);
        $this->db->delete('TCNMMerchant_L');

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
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }

    //Functionality : get all row data from pdt location
    //Parameters : -
    //Creator : 12/06/2019 Sarun
    //Return : array result from db
    //Return Type : array

    public function FSnMLOCGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMMerchant";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        } else {
            $aResult = false;
        }
        return $aResult;
    }

    //Functionality : list Data Merchant address
    //Parameters : function parameters
    //Creator :  09/07/2019 Sarun
    //Return : data
    //Return Type : Array
    public function FSaMSPLAddType(){
        $tSQL = " 
            SELECT
                FTSysStaDefValue,
                FTSysStaUsrValue  
            FROM TSysConfig WITH(NOLOCK)
            WHERE 1=1
            AND FTSysCode ='tCN_AddressType' 
            AND FTSysKey = 'TCNMMerchant'
        ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult    = $oQuery->row_array();
        } else {
            $aResult    = array();
        }
        return $aResult;
    }

    //Functionality : Get Data Merchant Address By ID
    //Parameters : function parameters
    //Creator : 08/07/2019 Sarun
    //Return : data
    //Return Type : Array
    public function FSnMMCNGetDataAddress($paData){
        try {
            $tMerchantCode = $paData;

            $tSQL = " 
                SELECT 
                    * 
                FROM TCNMAddress_L 
                WHERE FTAddRefCode = '$tMerchantCode' AND FTAddGrpType = '7'
                ORDER BY FNAddSeqNo
            ";
            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                $aDetail = $oQuery->result_array();
                $aResult = array(
                    'raItems'   => $aDetail,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            } else {
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'Data not found.',
                );
            }
            return $aResult;
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    // Functionality : Get Data Merchant Address By ID
    // Parameters : function parameters
    // Creator : 08/07/2019 Sarun
    // Last Update: 09/09/2019 Wasin(Yoshi)
    // Return : data
    // Return Type : Array
    public function FSaMMerchantAddressGetDataID($paDataWhereAddress){
        $tSQL = " 
            SELECT DISTINCT
                ADDL.FNLngID,
                ADDL.FTAddGrpType,
                ADDL.FTAddRefCode,
                ADDL.FNAddSeqNo,
                ADDL.FTAddRefNo,
                ADDL.FTAddName,
                ADDL.FTAddTaxNo,
                ADDL.FTAddRmk,
                ADDL.FTAddCountry,
                ADDL.FTAddVersion,
                ADDL.FTAddV1No,
                ADDL.FTAddV1Soi,
                ADDL.FTAddV1Village,
                ADDL.FTAddV1Road,
                ADDL.FTAddV1SubDist AS FTSudCode,
                SDSTL.FTSudName,
                ADDL.FTAddV1DstCode AS FTDstCode,
                DSTL.FTDstName,
                ADDL.FTAddV1PvnCode AS FTPvnCode,
                PVNL.FTPvnName,
                ADDL.FTAddV1PostCode,
                ADDL.FTAddV2Desc1,
                ADDL.FTAddV2Desc2,
                ADDL.FTAddWebsite,
                ADDL.FTAddLongitude,
                ADDL.FTAddLatitude
            FROM TCNMAddress_L          ADDL    WITH(NOLOCK)
            LEFT JOIN TCNMSubDistrict_L SDSTL   WITH(NOLOCK) ON ADDL.FTAddV1SubDist = SDSTL.FTSudCode   AND SDSTL.FNLngID   = '" . $paDataWhereAddress['FNLngID'] . "'
            LEFT JOIN TCNMDistrict_L    DSTL    WITH(NOLOCK) ON ADDL.FTAddV1DstCode = DSTL.FTDstCode    AND DSTL.FNLngID    = '" . $paDataWhereAddress['FNLngID'] . "'
            LEFT JOIN TCNMProvince_L    PVNL    WITH(NOLOCK) ON ADDL.FTAddV1PvnCode = PVNL.FTPvnCode    AND PVNL.FNLngID    = '" . $paDataWhereAddress['FNLngID'] . "'
            WHERE 1=1
            AND ADDL.FNLngID         = '" . $paDataWhereAddress['FNLngID'] . "'
            AND ADDL.FTAddGrpType    = '" . $paDataWhereAddress['FTAddGrpType'] . "'
            AND ADDL.FTAddRefCode    = '" . $paDataWhereAddress['FTAddRefCode'] . "'
            AND ADDL.FNAddSeqNo      = '" . $paDataWhereAddress['FNAddSeqNo'] . "'
        ";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aDataReturn = $oQuery->row_array();
        } else {
            $aDataReturn = array();
        }
        unset($tSQL);
        unset($oQuery);
        return $aDataReturn;
    }

    //Functionality : Merchant Update Seq Address
    //Parameters : function parameters
    //Creator : 09/09/2019 Wasin(Yoshi)
    //Return : data
    //Return Type : Array
    public function FSxMMerchantAddressUpdateSeq($paDataAddress){
        $tSQL   = " 
            UPDATE ADDRUPD 
                SET	ADDRUPD.FTAddRefNo = DATARUNSEQ.FTAddRefNo
            FROM TCNMAddress_L AS ADDRUPD WITH(NOLOCK)
            INNER JOIN (
                SELECT
                    ROW_NUMBER() OVER(ORDER BY FNAddSeqNo ASC) AS FTAddRefNo,
                    FNLngID,
                    FTAddGrpType,
                    FTAddRefCode,
                    FNAddSeqNo
                FROM TCNMAddress_L WITH(NOLOCK)
                WHERE 1=1
                AND FNLngID         = '" . $paDataAddress['FNLngID'] . "'
                AND FTAddRefCode    = '" . $paDataAddress['FTAddRefCode'] . "'
                AND FTAddGrpType    = '" . $paDataAddress['FTAddGrpType'] . "'
            ) AS DATARUNSEQ
            ON 1=1
            AND ADDRUPD.FNLngID         = DATARUNSEQ.FNLngID
            AND ADDRUPD.FTAddGrpType	= DATARUNSEQ.FTAddGrpType
            AND ADDRUPD.FTAddRefCode	= DATARUNSEQ.FTAddRefCode
            AND ADDRUPD.FNAddSeqNo		= DATARUNSEQ.FNAddSeqNo
        ";
        $this->db->query($tSQL);
    }

    //Functionality : Merchant Add Data Address
    //Parameters : function parameters
    //Creator : 09/09/2019 Wasin(Yoshi)
    //Return : data
    //Return Type : Array
    public function FSxMMerchantAddressAddData($paDataAddress){
        $tMerAddVersion = $paDataAddress['FTAddVersion'];
        if (isset($tMerAddVersion) && $tMerAddVersion == 1) {
            $tSQL = " 
                INSERT INTO TCNMAddress_L (
                    FNLngID,FTAddGrpType,FTAddRefCode,
                    FTAddName,FTAddTaxNo,FTAddRmk,
                    FTAddVersion,FTAddV1No,FTAddV1Soi,
                    FTAddV1Village,FTAddV1Road,FTAddV1SubDist,
                    FTAddV1DstCode,FTAddV1PvnCode,FTAddV1PostCode,
                    FTAddWebsite,FTAddLongitude,FTAddLatitude,
                    FDLastUpdOn,FDCreateOn,FTLastUpdBy,FTCreateBy
                )
                VALUES (
                    '" . $paDataAddress['FNLngID'] . "',
                    '" . $paDataAddress['FTAddGrpType'] . "',
                    '" . $paDataAddress['FTAddRefCode'] . "',
                    '" . $paDataAddress['FTAddName'] . "',
                    '" . $paDataAddress['FTAddTaxNo'] . "',
                    '" . $paDataAddress['FTAddRmk'] . "',
                    '" . $paDataAddress['FTAddVersion'] . "',
                    '" . $paDataAddress['FTAddV1No'] . "',
                    '" . $paDataAddress['FTAddV1Soi'] . "',
                    '" . $paDataAddress['FTAddV1Village'] . "',
                    '" . $paDataAddress['FTAddV1Road'] . "',
                    '" . $paDataAddress['FTAddV1SubDist'] . "',
                    '" . $paDataAddress['FTAddV1DstCode'] . "',
                    '" . $paDataAddress['FTAddV1PvnCode'] . "',
                    '" . $paDataAddress['FTAddV1PostCode'] . "',
                    '" . $paDataAddress['FTAddWebsite'] . "',
                    '" . $paDataAddress['FTAddLongitude'] . "',
                    '" . $paDataAddress['FTAddLatitude'] . "',
                    GETDATE(),
                    GETDATE(),
                    '" . $paDataAddress['FTLastUpdBy'] . "',
                    '" . $paDataAddress['FTCreateBy'] . "'
                )
            ";
        } else {
            $tSQL = " 
                INSERT INTO TCNMAddress_L (
                    FNLngID,FTAddGrpType,FTAddRefCode,
                    FTAddName,FTAddTaxNo,FTAddRmk,
                    FTAddVersion,FTAddV2Desc1,FTAddV2Desc2,
                    FTAddWebsite,FTAddLongitude,FTAddLatitude,
                    FDCreateOn,FTCreateBy
                )
                VALUES (
                    '" . $paDataAddress['FNLngID'] . "',
                    '" . $paDataAddress['FTAddGrpType'] . "',
                    '" . $paDataAddress['FTAddRefCode'] . "',
                    '" . $paDataAddress['FTAddName'] . "',
                    '" . $paDataAddress['FTAddTaxNo'] . "',
                    '" . $paDataAddress['FTAddRmk'] . "',
                    '" . $paDataAddress['FTAddVersion'] . "',
                    '" . $paDataAddress['FTAddV2Desc1'] . "',
                    '" . $paDataAddress['FTAddV2Desc2'] . "',
                    '" . $paDataAddress['FTAddWebsite'] . "',
                    '" . $paDataAddress['FTAddLongitude'] . "',
                    '" . $paDataAddress['FTAddLatitude'] . "',
                    GETDATE(),
                    GETDATE(),
                    '" . $paDataAddress['FTLastUpdBy'] . "',
                    '" . $paDataAddress['FTCreateBy'] . "'
                )
            ";
        }
        $this->db->query($tSQL);
    }

    //Functionality : Merchant Update Data Address
    //Parameters : function parameters
    //Creator : 09/09/2019 Wasin(Yoshi)
    //Return : data
    //Return Type : Array
    public function FSxMMerchantAddressUpdateData($paDataAddress){
        $tMerAddVersion = $paDataAddress['FTAddVersion'];
        if (isset($tMerAddVersion) && $tMerAddVersion == 1) {
            $tSQL = " 
                UPDATE TCNMAddress_L
                SET
                    FTAddName       = '" . $paDataAddress['FTAddName'] . "',
                    FTAddTaxNo      = '" . $paDataAddress['FTAddTaxNo'] . "',
                    FTAddRmk        = '" . $paDataAddress['FTAddRmk'] . "',
                    FTAddVersion    = '" . $paDataAddress['FTAddVersion'] . "',
                    FTAddV1No       = '" . $paDataAddress['FTAddV1No'] . "',
                    FTAddV1Soi      = '" . $paDataAddress['FTAddV1Soi'] . "',
                    FTAddV1Village  = '" . $paDataAddress['FTAddV1Village'] . "',
                    FTAddV1Road     = '" . $paDataAddress['FTAddV1Road'] . "',
                    FTAddV1SubDist  = '" . $paDataAddress['FTAddV1SubDist'] . "',
                    FTAddV1DstCode  = '" . $paDataAddress['FTAddV1DstCode'] . "',
                    FTAddV1PvnCode  = '" . $paDataAddress['FTAddV1PvnCode'] . "',
                    FTAddV1PostCode = '" . $paDataAddress['FTAddV1PostCode'] . "',
                    FTAddWebsite    = '" . $paDataAddress['FTAddWebsite'] . "',
                    FTAddLongitude  = '" . $paDataAddress['FTAddLongitude'] . "',
                    FTAddLatitude   = '" . $paDataAddress['FTAddLatitude'] . "',
                    FDLastUpdOn     = GETDATE(),
                    FTLastUpdBy     = '" . $paDataAddress['FTLastUpdBy'] . "'
                WHERE 1=1
                AND FNLngID         = '" . $paDataAddress['FNLngID'] . "'
                AND FTAddGrpType    = '" . $paDataAddress['FTAddGrpType'] . "'
                AND FTAddRefCode    = '" . $paDataAddress['FTAddRefCode'] . "'
                AND FNAddSeqNo      = '" . $paDataAddress['FNAddSeqNo'] . "'
            ";
        } else {
            $tSQL = " 
                UPDATE TCNMAddress_L
                SET
                    FTAddName       = '" . $paDataAddress['FTAddName'] . "',
                    FTAddTaxNo      = '" . $paDataAddress['FTAddTaxNo'] . "',
                    FTAddVersion    = '" . $paDataAddress['FTAddVersion'] . "',
                    FTAddV2Desc1    = '" . $paDataAddress['FTAddV2Desc1'] . "',
                    FTAddV2Desc2    = '" . $paDataAddress['FTAddV2Desc1'] . "',
                    FTAddWebsite    = '" . $paDataAddress['FTAddWebsite'] . "',
                    FTAddLongitude  = '" . $paDataAddress['FTAddLongitude'] . "',
                    FTAddLatitude   = '" . $paDataAddress['FTAddLatitude'] . "',
                    FDLastUpdOn     = GETDATE(),
                    FTLastUpdBy     = '" . $paDataAddress['FTLastUpdBy'] . "'
                WHERE 1=1 
                AND FNLngID         = '" . $paDataAddress['FNLngID'] . "'
                AND FTAddGrpType    = '" . $paDataAddress['FTAddGrpType'] . "'
                AND FTAddRefCode    = '" . $paDataAddress['FTAddRefCode'] . "'
                AND FNAddSeqNo      = '" . $paDataAddress['FNAddSeqNo'] . "'
            ";
        }
        $this->db->query($tSQL);
    }


    //Functionality : Merchant Delete Data Address
    //Parameters : function parameters
    //Creator : 09/09/2019 Wasin(Yoshi)
    //Return : data
    //Return Type : Array
    public function FSaMMerchantAddressDelete($paDataWhereDelete){
        $this->db->where('FNAddSeqNo', $paDataWhereDelete['FNAddSeqNo']);
        $this->db->where('FTAddRefCode', $paDataWhereDelete['FTAddRefCode']);
        $this->db->where('FTAddGrpType', $paDataWhereDelete['FTAddGrpType']);
        $this->db->where('FNLngID', $paDataWhereDelete['FNLngID']);
        $this->db->delete('TCNMAddress_L');
    }
}
