<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fashiongroup_model extends CI_Model
{

    /**
     * Functionality : Search Usr Class By ID
     * Parameters : $paData
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMFSCSearchByID($paData)
    {

        $tPgpCode = $paData['FTPgpCode'];
        $nLngID = $paData['FNLngID'];

        //  query
        $tHDSQL = "SELECT
FSC.FTPgpCode   AS rtPgpCode,
FSC.FTAgnCode AS rtAgnCode,
FSCL.FTPgpName AS rtPgpName,
FSCL.FTPgpRmk AS rtPgpRmk,
      AGNL.FTAgnName As   rtAgnName,
      FDCreateOn
      FROM [TFHMPdtF4Group] FSC WITH(NOLOCK)
  LEFT JOIN TFHMPdtF4Group_L   FSCL WITH(NOLOCK) ON FSC.FTPgpCode = FSCL.FTPgpCode AND FSCL.FNLngID = $nLngID
  LEFT JOIN   TCNMAgency_L AGNL WITH(NOLOCK) ON FSC.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
  WHERE 1=1
  AND FSC.FTPgpCode = '$tPgpCode'";






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
     * Functionality : List class
     * Parameters :  $paData is data for select filter
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMFSCList($ptAPIReq, $ptMethodReq, $paData)
    {
        // return null;
        $aRowLen            = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID             = $paData['FNLngID'];
        $tWhereCondition    = "";

        if ($this->session->userdata("tSesUsrLevel") != "HQ") {

            $tSesUsrAgnCode         = $this->session->userdata("tSesUsrAgnCode");


            if (isset($tSesUsrAgnCode) && !empty($tSesUsrAgnCode)) {
                $tWhereCondition .= " AND ( FSC.FTAgnCode = '$tSesUsrAgnCode' OR ISNULL(FSC.FTAgnCode,'') = '' ) ";
            }
        }

        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != '') {
            $tWhereCondition .= " AND (FSC.FTPgpCode LIKE '%$tSearchList%' ";
            $tWhereCondition .= " OR FSCL.FTPgpName LIKE '%$tSearchList%') ";
        }

        $tSQL1 = " SELECT c.* FROM( SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtPgpCode DESC) AS rtRowID,* FROM ( ";
        $tSQL2 = " SELECT DISTINCT
                        FSC.FTPgpCode   AS rtPgpCode,
                        FSC.FTAgnCode AS rtAgnCode,
                        FSCL.FTPgpName AS rtPgpName,
                        FSCL.FTPgpRmk AS rtPgpRmk,
                        AGNL.FTAgnName As   rtAgnName,
                        FDCreateOn
                    FROM [TFHMPdtF4Group] FSC WITH(NOLOCK)
                    LEFT JOIN TFHMPdtF4Group_L   FSCL WITH(NOLOCK) ON FSC.FTPgpCode = FSCL.FTPgpCode AND FSCL.FNLngID = $nLngID
                    LEFT JOIN   TCNMAgency_L AGNL WITH(NOLOCK) ON FSC.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
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
     * Functionality : All Page Of  Fashion Class
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMFSCGetPageAll(/*$ptWhereCode,*/$ptSearchList, $ptLngID)
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
     * Parameters : $ptPgpCode
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMFSCCheckDuplicate($ptPgpCode)
    {
        $tSQL = "SELECT COUNT(FTPgpCode) AS counts
                 FROM TFHMPdtF4Group
                 WHERE FTPgpCode = '$ptPgpCode'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    /**
     * Functionality : Update  Fashion Class
     * Parameters : $paData is data for update
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMFSCAddUpdateHD($paData)
    {
        try {
            if ($paData['tTypeInsertUpdate'] == 'Update') {
                // Update
                $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
                $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
                $this->db->set('FTAgnCode', $paData['FTAgnCode']);
                $this->db->where('FTPgpCode', $paData['FTPgpCode']);
                $this->db->update('TFHMPdtF4Group');

                $this->db->set('FNLngID', $paData['FNLngID']);
                $this->db->set('FTPgpName', $paData['FTPgpName']);
                $this->db->set('FTPgpRmk', $paData['FTPgpRmk']);
                $this->db->where('FTPgpCode', $paData['FTPgpCode']);
                $this->db->update('TFHMPdtF4Group_L');



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
                $this->db->insert('TFHMPdtF4Group', array(
                    'FTPgpCode'   => $paData['FTPgpCode'],
                    'FTAgnCode'   => $paData['FTAgnCode'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                ));
                $this->db->insert('TFHMPdtF4Group_L', array(
                    'FTPgpCode'   => $paData['FTPgpCode'],
                    'FNLngID' => $paData['FNLngID'],
                    'FTPgpName'   => $paData['FTPgpName'],
                    'FTPgpRmk'   => $paData['FTPgpRmk'],
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
     * Functionality : Delete  Fashion Class
     * Parameters : $paData
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMFSCDelHD($paData)
    {

        $this->db->where_in('FTPgpCode', $paData['FTPgpCode']);
        $this->db->delete('TFHMPdtF4Group');


        $this->db->where_in('FTPgpCode', $paData['FTPgpCode']);
        $this->db->delete('TFHMPdtF4Group_L');


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
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TFHMPdtF4Group";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        } else {
            $aResult = false;
        }
        return $aResult;
    }



    public function  FSaMFSCDeleteMultiple($paDataDelete)
    {
        // print_r($paDataDelete); die();


        $this->db->where_in('FTPgpCode', $paDataDelete['FTPgpCode']);
        $this->db->delete('TFHMPdtF4Group');

        $this->db->where_in('FTPgpCode', $paDataDelete['FTPgpCode']);
        $this->db->delete('TFHMPdtF4Group_L');

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
    public function FSnMFSCCountSeq($ptAppCode)
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
