<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mSlipMessage extends CI_Model {

    /**
     * Functionality : Search UsrDepart By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMSMGSearchByID($ptAPIReq, $ptMethodReq, $paData){
        $tDstCode   = $paData['FTSmgCode'];
        $nLngID     = $paData['FNLngID'];
        // Slip query
        $tHDSQL     = "SELECT
                SMGHD.FTSmgCode AS rtSmgCode,
                SMGHD.FTSmgTitle AS rtSmgTitle,
                SMGHD.FTAgnCode AS rtAgnCode,
                AGN_L.FTAgnName AS rtAgnName
            FROM [TCNMSlipMsgHD_L] SMGHD WITH(NOLOCK)
            LEFT JOIN TCNMAgency_L AGN_L ON SMGHD.FTAgnCode     = AGN_L.FTAgnCode AND AGN_L.FNLngID = ".$this->db->escape($nLngID)."
            WHERE 1=1
            AND SMGHD.FNLngID   = ".$this->db->escape($nLngID)."
            AND SMGHD.FTSmgCode = ".$this->db->escape($tDstCode)."
        ";
        $oHDQuery   = $this->db->query($tHDSQL);
        // Head of receipt and End of receipt query
        $tDTSQL     =   "
            SELECT
                SMGDT.FTSmgName  AS rtSmgName,
                SMGDT.FTSmgType AS rtSmgType,
                SMGDT.FNSmgSeq AS rtSmgSeq
            FROM [TCNMSlipMsgDT_L] SMGDT WITH(NOLOCK)
            WHERE SMGDT.FNLngID = ".$this->db->escape($nLngID)."
            AND SMGDT.FTSmgCode = ".$this->db->escape($tDstCode)." ORDER BY SMGDT.FNSmgSeq
        ";
        $oDTQuery   = $this->db->query($tDTSQL);
        $tImgSQL    = "
            SELECT
                IMG.FNImgID,
                IMG.FTImgRefID,
                IMG.FNImgSeq,
                IMG.FTImgObj
            FROM TCNMImgObj IMG WITH(NOLOCK)
            WHERE IMG.FDCreateOn <> ''
            AND IMG.FTImgRefID  = ".$this->db->escape($tDstCode)."
            AND IMG.FTImgTable  = 'TCNMSlipMsgHD_L'
            ORDER BY IMG.FNImgSeq ASC
        ";
        $oImgQuery = $this->db->query($tImgSQL);
        if ($oHDQuery->num_rows() > 0){ // Have slip
            $oHDDetail  = $oHDQuery->result();
            $oDTDetail  = $oDTQuery->result();
            $aImgDetail = $oImgQuery->result_array();
            // Prepare Head of receipt and End of receipt data
            $aDTHeadItems   = [];
            $aDTEndItems    = [];
            foreach ($oDTDetail as $nIndex => $oItem){
                if($oItem->rtSmgType == 1){ // Head of receipt type
                    $aDTHeadItems[] = $oItem->rtSmgName;
                }
                if($oItem->rtSmgType == 2){ // End of receipt type
                    $aDTEndItems[] = $oItem->rtSmgName;
                }
            }
            // Found
            $aResult = array(
                'raHDItems'     => $oHDDetail[0],
                'raDTHeadItems' => $aDTHeadItems,
                'raDTEndItems'  => $aDTEndItems,
                'aImgItems'     => $aImgDetail,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );

        }else{
            // Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult    = json_encode($aResult);
        $aResult    = json_decode($jResult, true);
        return $aResult;
    }

    /**
     * Functionality : List department
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMSMGList($ptAPIReq, $ptMethodReq, $paData){
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $tAgnCode   = $paData['tAgnCode'];
        $tSQL       = "
            SELECT c.* FROM(
                SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtSmgCode DESC) AS rtRowID,*
                    FROM (
                        SELECT DISTINCT
                            POS.FTPosCode   AS rtPosCode,
                            SMGHD.FTSmgCode     AS rtSmgCode,
                            SMGHD.FTSmgTitle    AS rtSmgTitle,
                            SMGHD.FDCreateOn,
                            IMG.FTImgObj
                        FROM [TCNMSlipMsgHD_L] SMGHD WITH(NOLOCK)
                        LEFT JOIN TCNMImgObj IMG WITH(NOLOCK) ON IMG.FTImgRefID = SMGHD.FTSmgCode AND IMG.FTImgTable = 'TCNMSlipMsgHD_L' AND IMG.FNImgSeq = 1
                        LEFT JOIN (
                            SELECT A.* FROM (
                                SELECT 
                                    ROW_NUMBER() OVER (PARTITION BY FTSmgCode ORDER BY FTSmgCode) rtPartitionCode,
                                    FTPosCode,
                                    FTSmgCode
                                FROM
                                    TCNMPos WITH (NOLOCK)
                                WHERE ISNULL(FTSmgCode,'') != ''
                            ) A WHERE A.rtPartitionCode = 1 
                        ) POS ON POS.FTSmgCode = SMGHD.FTSmgCode
                        WHERE SMGHD.FDCreateOn <> ''
                        AND SMGHD.FNLngID   = ".$this->db->escape($nLngID)."
        ";
        if($tAgnCode != ''){
            $tSQL   .= "AND SMGHD.FTAgnCode = ".$this->db->escape($tAgnCode)." ";
        }
        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            $tSQL   .= " AND (SMGHD.FTSmgCode LIKE '%".$this->db->escape_like_str($tSearchList)."%'";
            $tSQL   .= " OR SMGHD.FTSmgTitle  LIKE '%".$this->db->escape_like_str($tSearchList)."%')";
        }
        $tSQL   .= ") Base) AS c WHERE c.rtRowID > ".$this->db->escape($aRowLen[0])." AND c.rtRowID <= ".$this->db->escape($aRowLen[1])." ";
        $oQuery  = $this->db->query($tSQL);

        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aFoundRow  = $this->FSnMSMGGetPageAll(/*$tWhereCode,*/ $tSearchList, $nLngID,$tAgnCode);
            $nFoundRow  = $aFoundRow[0]->counts;
            $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult    = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            //No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"=> 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        $jResult    = json_encode($aResult);
        $aResult    = json_decode($jResult, true);
        return $aResult;
    }

    /**
     * Functionality : All Page Of Slip Message
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMSMGGetPageAll(/*$ptWhereCode,*/ $ptSearchList, $ptLngID,$tAgnCode){
        $tSQL   = "
            SELECT COUNT (SMGHD.FTSmgCode) AS counts
            FROM [TCNMSlipMsgHD_L] SMGHD WITH(NOLOCK)
            WHERE SMGHD.FDCreateOn <> ''
            AND SMGHD.FNLngID   = ".$this->db->escape($ptLngID)."
        ";
        if($tAgnCode != ''){
            $tSQL   .= "AND SMGHD.FTAgnCode = ".$this->db->escape($tAgnCode)." ";
        }
        if($ptSearchList != ''){
            $tSQL   .= " AND (SMGHD.FTSmgCode LIKE '%".$this->db->escape_like_str($ptSearchList)."%'";
            $tSQL   .= " OR SMGHD.FTSmgTitle  LIKE '%".$this->db->escape_like_str($ptSearchList)."%')";
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }

    /**
     * Functionality : Checkduplicate
     * Parameters : $ptDstCode
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMSMGCheckDuplicate($ptDstCode){
        $tSQL   = "
            SELECT COUNT(FTSmgCode) AS counts
            FROM TCNMSlipMsgHD_L WITH(NOLOCK)
            WHERE FTSmgCode = ".$this->db->escape($ptDstCode)."
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    /**
     * Functionality : Update Slip Message
     * Parameters : $paData is data for update
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMSMGAddUpdateHD($paData){
        try{
            // Update Header
            $this->db->set('FTSmgTitle' , $paData['FTSmgTitle']);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
            $this->db->set('FTAgnCode', $paData['FTAgnCode']);
            $this->db->where('FTSmgCode', $paData['FTSmgCode']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->update('TCNMSlipMsgHD_L');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                // Add Header
                $this->db->insert('TCNMSlipMsgHD_L',array(
                    'FTSmgCode'     => $paData['FTSmgCode'],
                    'FTSmgTitle'    => $paData['FTSmgTitle'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                    'FNLngID'       => $paData['FNLngID'],
                    'FTAgnCode'     => $paData['FTAgnCode'],
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Master Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    /**
     * Functionality : Update Lang Slip Message
     * Parameters : $paData is data for update
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMSMGAddUpdateDT($paData){
        try{
            // Add Detail
            $this->db->insert('TCNMSlipMsgDT_L', array(
                'FTSmgCode' => $paData['FTSmgCode'],
                'FTSmgType' => $paData['FTSmgType'],
                'FNLngID'   => $paData['FNLngID'],
                'FNSmgSeq'  => $paData['FNSmgSeq'],
                'FTSmgName' => $paData['FTSmgName']
            ));

            // Set Response status
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Lang Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Lang.',
                );
            }
            // Response status
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    /**
     * Functionality : Delete Slip Message
     * Parameters : $paData
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMSMGDelHD($paData){
        $this->db->where_in('FTSmgCode', $paData['FTSmgCode']);
        $this->db->delete('TCNMSlipMsgHD_L');

        $this->db->where_in('FTSmgCode', $paData['FTSmgCode']);
        $this->db->delete('TCNMSlipMsgDT_L');
        if($this->db->affected_rows() > 0){
            // Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            // Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }

    /**
     * Functionality : {description}
     * Parameters : {params}
     * Creator : dd/mm/yyyy piya
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    public function FSnMSMGDelDT($paData){
        $this->db->where('FTSmgCode', $paData['FTSmgCode']);
        $this->db->delete('TCNMSlipMsgDT_L');
        return $aStatus = array(
            'rtCode' => '1',
            'rtDesc' => 'success',
        );
    }



    //Functionality : get all row data from pdt location
    //Parameters : -
    //Creator : 1/04/2019 Pap
    //Return : array result from db
    //Return Type : array

    public function FSnMLOCGetAllNumRow(){
        $tSQL = " SELECT COUNT(*) AS FNAllNumRow FROM TCNMSlipMsgHD_L WITH(NOLOCK) ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

}
