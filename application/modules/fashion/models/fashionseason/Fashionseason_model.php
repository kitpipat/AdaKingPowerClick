<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fashionseason_model extends CI_Model
{

    /**
     * Functionality : Search Usr Season By ID
     * Parameters : $paData
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMFSSSearchByID($paData)
    {

        $tSeaCode = $paData['FTSeaCode'];
        $nLngID = $paData['FNLngID'];

        //  query
        $tHDSQL = "SELECT
                    FSS.FTSeaCode   AS rtSeaCode,
                    FSS.FNSeaLevel AS rnSeaLevel,
                    FSS.FTSeaChain AS rtSeaChain,
                    FSS.FTSeaParent AS rtSeaParent,
                    FSS.FTAgnCode AS rtAgnCode,
                    FSSL.FTSeaName AS rtSeaName,
                    FSSL.FTSeaChainName AS rtSeaChainName,
                    FSSL.FTSeaRmk AS rtSeaRmk,
                    AGNL.FTAgnName As   rtAgnName,
                    FSS.FDCreateOn
                        FROM [TFHMPdtSeason] FSS WITH(NOLOCK)
                    LEFT JOIN TFHMPdtSeason_L   FSSL WITH(NOLOCK) ON FSS.FTSeaCode = FSSL.FTSeaCode AND FSS.FTSeaChain = FSSL.FTSeaChain AND FSSL.FNLngID = $nLngID
                    LEFT JOIN  TCNMAgency_L AGNL WITH(NOLOCK) ON FSS.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                    WHERE 1=1 
                    AND FSS.FTSeaCode = '$tSeaCode'";






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
     * Functionality : List Season
     * Parameters :  $paData is data for select filter
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMFSSList($ptAPIReq, $ptMethodReq, $paData)
    {
        // return null;
        $aRowLen            = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID             = $paData['FNLngID'];
        $tWhereCondition    = "";

        if ($this->session->userdata("tSesUsrLevel") != "HQ") {

            $tSesUsrAgnCode         = $this->session->userdata("tSesUsrAgnCode");


            if (isset($tSesUsrAgnCode) && !empty($tSesUsrAgnCode)) {
                $tWhereCondition .= " AND ( SEA.FTAgnCode = '$tSesUsrAgnCode' OR ISNULL(SEA.FTAgnCode,'') = '' ) ";
            }
        }

        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != '') {
            $tWhereCondition .= " AND (SEA.FTSeaCode LIKE '%$tSearchList%' ";
            $tWhereCondition .= " OR SEAL.FTSeaName LIKE '%$tSearchList%') ";
        }

        $tSQL1 = " SELECT c.* FROM( SELECT  ROW_NUMBER() OVER(ORDER BY  rtSeaCode DESC) AS rtRowID,* FROM ( ";
        // $tSQL2 = " SELECT DISTINCT
        //                 FSS.FTSeaCode   AS rtSeaCode,
        //                 FSS.FTAgnCode AS rtAgnCode,
        //                 FSSL.FTSeaName AS rtSeaName,
        //                 FSSL.FTSeaRmk AS rtSeaRmk,
        //                 AGNL.FTAgnName As   rtAgnName,
        //                 FDCreateOn
        //             FROM [TFHMPdtSeason] FSS WITH(NOLOCK)
        //             LEFT JOIN TFHMPdtSeason_L   FSSL WITH(NOLOCK) ON FSS.FTSeaCode = FSSL.FTSeaCode AND FSSL.FNLngID = $nLngID
        //             LEFT JOIN   TCNMAgency_L AGNL WITH(NOLOCK) ON FSS.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
        //             WHERE 1=1
        //             $tWhereCondition
        //          ";
        $tSQL2 = "SELECT 
        SEA.FTSeaCode AS rtSeaCode,
        SEAL.FTSeaChain AS rtSeaChain,
        SEAL.FTSeaName AS rtSeaName,
        SEA.FNSeaLevel AS rtSeaLevel,
        (SELECT COUNT(*) FROM TFHMPdtSeason SEASB WITH (NOLOCK) WHERE SEASB.FTSeaParent = SEA.FTSeaCode AND SEASB.FTSeaCode !=SEA.FTSeaCode ) AS rnStaChrl
        FROM TFHMPdtSeason SEA WITH(NOLOCK)
        LEFT JOIN TFHMPdtSeason_L SEAL WITH(NOLOCK) ON SEA.FTSeaCode = SEAL.FTSeaCode
        AND SEA.FTSeaChain = SEAL.FTSeaChain
        AND SEAL.FNLngID =  $nLngID 
        WHERE SEA.FNSeaLevel =  1 $tWhereCondition";
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
     * Functionality : All Page Of  Fashion Season
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMFSSGetPageAll(/*$ptWhereCode,*/$ptSearchList, $ptLngID)
    {
        $tSQL = "SELECT COUNT (CHN.FTChnCode) AS counts
                FROM [TCNMChannel] CHN
                WHERE 1=1 ";
        //  AND CHN.FNLngID = $ptLngID";

        if($ptSearchList != ''){
            $tSQL .= " AND (FSS.FTSeaCode LIKE '%$ptSearchList%' ";
            $tSQL .= " OR FSSL.FTSeaName LIKE '%$ptSearchList%') ";
        }

        if ($this->session->userdata("tSesUsrLevel") != "HQ") {

            $tSesUsrAgnCode         = $this->session->userdata("tSesUsrAgnCode");


            if (isset($tSesUsrAgnCode) && !empty($tSesUsrAgnCode)) {
                $tSQL .= " AND ( FSS.FTAgnCode = '$tSesUsrAgnCode' OR ISNULL(FSS.FTAgnCode,'') = '' ) ";
            }
        }

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
     * Parameters : $ptSeaCode
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMFSSCheckDuplicate($ptSeaCode)
    {
        $tSQL = "SELECT COUNT(FTSeaCode) AS counts
                 FROM TFHMPdtSeason
                 WHERE FTSeaCode = '$ptSeaCode'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    /**
     * Functionality : Update  Fashion Season
     * Parameters : $paData is data for update
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMFSSAddUpdateHD($paData)
    {
        try {
            if ($paData['tTypeInsertUpdate'] == 'Update') {
                // Update
                $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
                $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
                $this->db->set('FTAgnCode', $paData['FTAgnCode']);
                $this->db->where('FTSeaCode', $paData['FTSeaCode']);
                $this->db->where('FTSeaChain', $paData['FTSeaChain']);
                $this->db->update('TFHMPdtSeason');

                $this->db->set('FNLngID', $paData['FNLngID']);
                $this->db->set('FTSeaName', $paData['FTSeaName']);
                $this->db->set('FTSeaRmk', $paData['FTSeaRmk']);
                $this->db->where('FTSeaCode', $paData['FTSeaCode']);
                $this->db->where('FTSeaChain', $paData['FTSeaChain']);
                $this->db->update('TFHMPdtSeason_L');



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
                $this->db->insert('TFHMPdtSeason', array(
                    'FTSeaCode'   => $paData['FTSeaCode'],
                    'FTSeaChain'   =>   $paData['FTSeaChain'],
                    'FNSeaLevel'   =>   $paData['FNSeaLevel'],
                    'FTSeaParent'   =>   $paData['FTSeaParent'],
                    'FTAgnCode'   => $paData['FTAgnCode'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],



                ));
                $this->db->insert('TFHMPdtSeason_L', array(
                    'FTSeaCode'   => $paData['FTSeaCode'],
                    'FTSeaChain'   =>   $paData['FTSeaChain'],
                    'FNLngID' => $paData['FNLngID'],
                    'FTSeaName'   => $paData['FTSeaName'],
                    'FTSeaChainName'  => $paData['FTSeaChainName'],
                    'FTSeaRmk'   => $paData['FTSeaRmk'],
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
     * Functionality : Delete  Fashion Season
     * Parameters : $paData
     * Creator : 26/04/2021 Worakorn
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMFSSDelHD($paData)
    {
        $tChain = $paData['FTSeaCode'];
        $this->db->where_in('FTSeaCode', $paData['FTSeaCode']);
        $this->db->delete('TFHMPdtSeason');


        $this->db->where_in('FTSeaCode', $paData['FTSeaCode']);
        $this->db->delete('TFHMPdtSeason_L');


        $tSQL ="DELETE FROM TFHMPdtSeason  WHERE LEFT(TFHMPdtSeason.FTSeaChain, LEN('$tChain')) = '$tChain'";
        $this->db->query($tSQL);

        $tSQL1 ="DELETE FROM TFHMPdtSeason_L WHERE LEFT(TFHMPdtSeason_L.FTSeaChain, LEN('$tChain')) = '$tChain'";
        $this->db->query($tSQL1);

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
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TFHMPdtSeason";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        } else {
            $aResult = false;
        }
        return $aResult;
    }



    public function  FSaMFSSDeleteMultiple($paDataDelete)
    {
        // print_r($paDataDelete); die();

    //    $tChain = $paDataDelete['FTSeaCode'];
        $this->db->where_in('FTSeaCode', $paDataDelete['FTSeaCode']);
        $this->db->delete('TFHMPdtSeason');

        $this->db->where_in('FTSeaCode', $paDataDelete['FTSeaCode']);
        $this->db->delete('TFHMPdtSeason_L');

        foreach($paDataDelete['FTSeaCode'] AS $tChain){
    
        $tSQL ="DELETE FROM TFHMPdtSeason  WHERE LEFT(TFHMPdtSeason.FTSeaChain, LEN('$tChain')) = '$tChain'";
        $this->db->query($tSQL);

        $tSQL1 ="DELETE FROM TFHMPdtSeason_L WHERE LEFT(TFHMPdtSeason_L.FTSeaChain, LEN('$tChain')) = '$tChain'";
        $this->db->query($tSQL1);
        }
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
    public function FSnMFSSCountSeq($ptAppCode)
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


    public function FSaMFSSListChain($ptSeaChain, $ptSeaLevel)
    {
        $tLangEdit = $this->session->userdata("tLangEdit");

        $tSQL = "SELECT 
        SEA.FTSeaCode,
        SEAL.FTSeaChain,
        SEAL.FTSeaName,
        SEA.FNSeaLevel, 
        SEA.FTSeaParent,
        (SELECT COUNT(*) FROM TFHMPdtSeason SEASB WITH (NOLOCK) WHERE SEASB.FTSeaParent = SEA.FTSeaCode AND SEASB.FTSeaCode !=SEA.FTSeaCode ) AS rnStaChrl
        FROM TFHMPdtSeason SEA
        LEFT JOIN TFHMPdtSeason_L SEAL ON SEA.FTSeaCode = SEAL.FTSeaCode
        AND SEA.FTSeaChain = SEAL.FTSeaChain
        AND SEAL.FNLngID = $tLangEdit
        WHERE SEA.FNSeaLevel = $ptSeaLevel + 1
       AND LEFT(SEA.FTSeaChain, LEN('$ptSeaChain')) = '$ptSeaChain'
        ORDER BY SEA.FTSeaCode ASC ";

        //    print_r($tSQL); die();

        $oHDQuery = $this->db->query($tSQL);

        if ($oHDQuery->num_rows() > 0) {

            $oHDDetail = $oHDQuery->result();


            // Found
            $aResult = array(
                'raHDItems'   => $oHDDetail,
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

        // return $aResult;
        return $jResult;
    }
}
