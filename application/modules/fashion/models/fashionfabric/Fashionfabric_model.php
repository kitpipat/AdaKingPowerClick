<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fashionfabric_model extends CI_Model
{

    /**
     * Functionality : Search Usr Fabric By ID
     * Parameters : $paData
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMFSFSearchByID($paData)
    {

        $tFabCode = $paData['FTFabCode'];
        $nLngID = $paData['FNLngID'];

        //  query
        $tHDSQL = "SELECT
FSF.FTFabCode   AS rtFabCode,
FSF.FTAgnCode AS rtAgnCode,
FSFL.FTFabName AS rtFabName,
FSFL.FTFabRmk AS rtFabRmk,
      AGNL.FTAgnName As   rtAgnName,
      FDCreateOn
      FROM [TFHMPdtFabric] FSF WITH(NOLOCK)
  LEFT JOIN TFHMPdtFabric_L   FSFL WITH(NOLOCK) ON FSF.FTFabCode = FSFL.FTFabCode AND FSFL.FNLngID = $nLngID
  LEFT JOIN   TCNMAgency_L AGNL WITH(NOLOCK) ON FSF.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
  WHERE 1=1 
  AND FSF.FTFabCode = '$tFabCode'";






        $oHDQuery = $this->db->query($tHDSQL);


        if ($oHDQuery->num_rows() > 0) {

            $oHDDetail = $oHDQuery->result();


            // Found
            $aResult = array(
                'raHDItems'   => $oHDDetail[0],
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

    /**
     * Functionality : List Fabric
     * Parameters :  $paData is data for select filter
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMFSFList($ptAPIReq, $ptMethodReq, $paData)
    {
        // return null;
        $aRowLen            = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID             = $paData['FNLngID'];
        $tWhereCondition    = "";

        if ($this->session->userdata("tSesUsrLevel") != "HQ") {

            $tSesUsrAgnCode         = $this->session->userdata("tSesUsrAgnCode");


            if (isset($tSesUsrAgnCode) && !empty($tSesUsrAgnCode)) {
                $tWhereCondition .= " AND ( FSF.FTAgnCode = '$tSesUsrAgnCode' OR ISNULL(FSF.FTAgnCode,'') = '' ) ";
            }
        }

        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != '') {
            $tWhereCondition .= " AND (FSF.FTFabCode LIKE '%$tSearchList%' ";
            $tWhereCondition .= " OR FSFL.FTFabName LIKE '%$tSearchList%') ";
        }

        $tSQL1 = " SELECT c.* FROM( SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtFabCode DESC) AS rtRowID,* FROM ( ";
        $tSQL2 = " SELECT DISTINCT
                        FSF.FTFabCode   AS rtFabCode,
                        FSF.FTAgnCode AS rtAgnCode,
                        FSFL.FTFabName AS rtFabName,
                        FSFL.FTFabRmk AS rtFabRmk,
                        AGNL.FTAgnName As   rtAgnName,
                        FDCreateOn
                    FROM [TFHMPdtFabric] FSF WITH(NOLOCK)
                    LEFT JOIN TFHMPdtFabric_L   FSFL WITH(NOLOCK) ON FSF.FTFabCode = FSFL.FTFabCode AND FSFL.FNLngID = $nLngID
                    LEFT JOIN   TCNMAgency_L AGNL WITH(NOLOCK) ON FSF.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                    WHERE 1=1
                    $tWhereCondition
                 ";
        $tSQL3 = " ) Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";


        $tFullQuery  = $tSQL1 . $tSQL2 . $tSQL3;
        $tCountQuery = $tSQL2;
        // print_r($tSQL);

        $oQuery = $this->db->query($tFullQuery);
        // echo $this->db->last_query();exit;
        if ($oQuery->num_rows() > 0) {
            $oCount = $this->db->query($tSQL2);

            $nFoundRow = $oCount->num_rows();
            $nPageAll  = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oQuery->result(),
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

        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /**
     * Functionality : All Page Of  Fashion Fabric
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMFSFGetPageAll(/*$ptWhereCode,*/$ptSearchList, $ptLngID)
    {
        $tSQL = "SELECT COUNT (CHN.FTChnCode) AS counts
                FROM [TCNMChannel] CHN
                WHERE 1=1 ";
        //  AND CHN.FNLngID = $ptLngID";

        // if($ptSearchList != ''){
        //     $tSQL .= " AND (SMGHD.FTSmgCode LIKE '%$ptSearchList%'";
        //     $tSQL .= " OR SMGHD.FTSmgTitle  LIKE '%$ptSearchList%')";
        // }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            //No Data
            return false;
        }
    }

    /**
     * Functionality : Checkduplicate
     * Parameters : $ptFabCode
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMFSFCheckDuplicate($ptFabCode)
    {
        $tSQL = "SELECT COUNT(FTFabCode) AS counts
                 FROM TFHMPdtFabric
                 WHERE FTFabCode = '$ptFabCode'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    /**
     * Functionality : Update  Fashion Fabric
     * Parameters : $paData is data for update
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMFSFAddUpdateHD($paData)
    {
        try {
            if ($paData['tTypeInsertUpdate'] == 'Update') {
                // Update
                $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
                $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
                $this->db->set('FTAgnCode', $paData['FTAgnCode']);
                $this->db->where('FTFabCode', $paData['FTFabCode']);
                $this->db->update('TFHMPdtFabric');

                $this->db->set('FNLngID', $paData['FNLngID']);
                $this->db->set('FTFabName', $paData['FTFabName']);
                $this->db->set('FTFabRmk', $paData['FTFabRmk']);
                $this->db->where('FTFabCode', $paData['FTFabCode']);
                $this->db->update('TFHMPdtFabric_L');



                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Master Success',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Update Master.',
                    );
                }
            } else if ($paData['tTypeInsertUpdate'] == 'Insert') {
                // Insert
                $this->db->insert('TFHMPdtFabric', array(
                    'FTFabCode'   => $paData['FTFabCode'],
                    'FTAgnCode'   => $paData['FTAgnCode'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                ));
                $this->db->insert('TFHMPdtFabric_L', array(
                    'FTFabCode'   => $paData['FTFabCode'],
                    'FNLngID' => $paData['FNLngID'],
                    'FTFabName'   => $paData['FTFabName'],
                    'FTFabRmk'   => $paData['FTFabRmk'],
                ));

                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Master Success',
                    );
                } else {
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add Master.',
                    );
                }
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }


    /**
     * Functionality : Delete  Fashion Fabric
     * Parameters : $paData
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMFSFDelHD($paData)
    {

        $this->db->where_in('FTFabCode', $paData['FTFabCode']);
        $this->db->delete('TFHMPdtFabric');


        $this->db->where_in('FTFabCode', $paData['FTFabCode']);
        $this->db->delete('TFHMPdtFabric_L');


        if ($this->db->affected_rows() > 0) {
            // Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
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




    //Functionality : get all row data from pdt location
    //Parameters : -
    //Creator : 26/04/2021 Worakorn
    //Return : array result from db
    //Return Type : array

    public function FSnMLOCGetAllNumRow()
    {
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TFHMPdtFabric";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        } else {
            $aResult = false;
        }
        return $aResult;
    }



    public function  FSaMFSFDeleteMultiple($paDataDelete)
    {
        // print_r($paDataDelete); die();


        $this->db->where_in('FTFabCode', $paDataDelete['FTFabCode']);
        $this->db->delete('TFHMPdtFabric');

        $this->db->where_in('FTFabCode', $paDataDelete['FTFabCode']);
        $this->db->delete('TFHMPdtFabric_L');

        if ($this->db->affected_rows() > 0) {
            //Success
            $aStatus   = array(
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

    //Functionality : Count Seq
    //Parameters : function parameters
    //Creator : 06/01/2021 Worakorn
    //Return : data
    //Return Type : Array
    public function FSnMFSFCountSeq($ptAppCode)
    {
        $tSQL = "SELECT COUNT(FNChnSeq) AS counts
                FROM TCNMChannel
                WHERE FTAppCode = '$ptAppCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->row_array()["counts"];
        } else {
            return FALSE;
        }
    }
}
