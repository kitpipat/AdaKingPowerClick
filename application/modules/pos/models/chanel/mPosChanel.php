<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mPosChanel extends CI_Model
{

    /**
     * Functionality : Search UsrDepart By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMCHNSearchByID($ptAPIReq, $ptMethodReq, $paData)
    {

        $tChnCode = $paData['FTChnCode'];
        // $tChnBchCode = $paData['FTBchCode'];
        $nLngID = $paData['FNLngID'];

        //  query
        $tHDSQL =   "SELECT
                        CHN.FTChnCode   AS rtChnCode,
                        CHNL.FTChnName AS rtChnName,
                        CHNS.FTBchCode AS rtChnBchCode,
                        BCHL.FTBchName AS rtChnBchName,
                        CHNS.FTAgnCode AS rtChnAgnCode,
                        AGNL.FTAgnName AS rtChnAgnName,
                        CHN.FTAppCode AS rtChnAppCode,
                        APPL.FTAppName AS rtChnAppName,
                        CHN.FTPplCode AS rtChnPplCode,
                        PPLL.FTPplName AS rtChnPplName,
                        CHN.FTChnStaUse AS rtChnStaUse,
                        CHN.FTWahCode AS rtChnWahCode,
                        WAHL.FTWahName AS rtChnWahName,
                        CHN.FTChnRefCode AS rtChnRefCode,
                        CHN.FDCreateOn,
                        CHN.FNChnSeq   AS rtChnSeq,
                        CHN.FTChnWahDO AS rtChnWahDO,
                        WAHLDO.FTWahName AS rtChnWahDOName,
                        CHN.FTChnStaUseDO AS rtChnStaUseDO,
                        CHN.FTChnStaAlwSNPL AS rtChnStaAlwSNPL

                            FROM [TCNMChannel] CHN WITH(NOLOCK)
                    LEFT JOIN   TCNMChannel_L CHNL WITH(NOLOCK) ON CHN.FTChnCode = CHNL.FTChnCode AND CHNL.FNLngID = $nLngID
                    LEFT JOIN   TCNMChannelSpc CHNS WITH(NOLOCK) ON CHN.FTChnCode = CHNS.FTChnCode
                    LEFT JOIN   TCNMAgency_L AGNL WITH(NOLOCK) ON CHNS.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                    LEFT JOIN   TCNMBranch_L BCHL WITH(NOLOCK) ON CHNS.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                    LEFT JOIN   TSysApp_L APPL WITH(NOLOCK) ON CHN.FTAppCode = APPL.FTAppCode  AND APPL.FNLngID = $nLngID
                    LEFT JOIN   TCNMPdtPriList_L PPLL WITH(NOLOCK) ON CHN.FTPplCode = PPLL.FTPplCode AND PPLL.FNLngID = $nLngID
                    LEFT JOIN   TCNMWaHouse_L WAHL WITH(NOLOCK) ON CHNS.FTBchCode =  WAHL.FTBchCode AND CHN.FTWahCode = WAHL.FTWahCode AND WAHL.FNLngID = $nLngID
                    LEFT JOIN  TCNMWaHouse_L WAHLDO WITH(NOLOCK) ON WAHLDO.FTWahCode =  CHN.FTChnWahDO AND WAHLDO.FNLngID = $nLngID
                    WHERE CHN.FTChnCode = '$tChnCode'";
        $oHDQuery = $this->db->query($tHDSQL);
        if ($oHDQuery->num_rows() > 0) { // Have slip

            $oHDDetail = $oHDQuery->result();
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
     * Functionality : List department
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCHNList($ptAPIReq, $ptMethodReq, $paData)
    {
        // return null;
        $aRowLen            = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID             = $paData['FNLngID'];
        $tWhereCondition    = "";

        if ($this->session->userdata("tSesUsrLevel") != "HQ") {

            $tSesUsrAgnCode         = $this->session->userdata("tSesUsrAgnCode");
            $tSesUsrBchCodeMulti    = $this->session->userdata("tSesUsrBchCodeMulti");
            $tSesUsrShpCodeMulti    = $this->session->userdata("tSesUsrShpCodeMulti");

            if( isset($tSesUsrAgnCode) && !empty($tSesUsrAgnCode) ){
                $tWhereCondition .= " AND ( CHNS.FTAgnCode = '$tSesUsrAgnCode' OR ISNULL(CHNS.FTAgnCode,'') = '' ) ";
            }

            if( isset($tSesUsrBchCodeMulti) && !empty($tSesUsrBchCodeMulti) ){
                $tWhereCondition .= " AND ( CHNS.FTBchCode IN ($tSesUsrBchCodeMulti) OR ISNULL(CHNS.FTBchCode,'') = '' ) ";
            }

            if( isset($tSesUsrShpCodeMulti) && !empty($tSesUsrShpCodeMulti) ){
                $tWhereCondition .= " AND ( CHNS.FTShpCode IN ($tSesUsrShpCodeMulti) OR ISNULL(CHNS.FTShpCode,'') = '' ) ";
            }

        }

        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != '') {
            $tWhereCondition .= " AND (CHN.FTChnCode LIKE '%$tSearchList%' ";
            $tWhereCondition .= " OR CHN.FTAppCode LIKE '%$tSearchList%' ";
            $tWhereCondition .= " OR APPL.FTAppName LIKE '%$tSearchList%' ";

            $tWhereCondition .= " OR CHNS.FTBchCode LIKE '%$tSearchList%' ";
            $tWhereCondition .= " OR BCHL.FTBchName LIKE '%$tSearchList%' ";

            $tWhereCondition .= " OR CHN.FTWahCode LIKE '%$tSearchList%' ";
            $tWhereCondition .= " OR WAHL.FTWahName LIKE '%$tSearchList%' ";

            $tWhereCondition .= " OR CHN.FTPplCode LIKE '%$tSearchList%' ";
            $tWhereCondition .= " OR PPLL.FTPplName LIKE '%$tSearchList%' ";

            $tWhereCondition .= " OR CHNL.FTChnName LIKE '%$tSearchList%') ";
        }

        $tSQL1 = " SELECT c.* FROM( SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtChnCode DESC) AS rtRowID,* FROM ( ";
        $tSQL2 = " SELECT DISTINCT
                        CHN.FTChnCode   AS rtChnCode,
                        CHNL.FTChnName AS rtChnName,
                        CHNS.FTBchCode AS rtChnBchCode,
                        BCHL.FTBchName AS rtChnBchName,
                        CHNS.FTAgnCode AS rtChnAgnCode,
                        AGNL.FTAgnName AS rtChnAgnName,
                        CHN.FTAppCode AS rtChnAppCode,
                        APPL.FTAppName AS rtChnAppName,
                        CHN.FTPplCode AS rtChnPplCode,
                        PPLL.FTPplName AS rtChnPplName,
                        CHN.FTChnStaUse AS rtChnStaUse,
                        CHN.FTWahCode AS rtChnWahCode,
                        WAHL.FTWahName AS rtChnWahName,
                        CHN.FTChnRefCode AS rtChnRefCode,
                        CHN.FDCreateOn,
                        CASE WHEN REF.FTChnCode IS NULL THEN '2' ELSE '1' END AS FTRefChnCode
                    FROM [TCNMChannel] CHN WITH(NOLOCK)
                    LEFT JOIN TCNMChannel_L       CHNL WITH(NOLOCK) ON CHN.FTChnCode = CHNL.FTChnCode AND CHNL.FNLngID = $nLngID
                    LEFT JOIN TCNMChannelSpc      CHNS WITH(NOLOCK) ON CHN.FTChnCode = CHNS.FTChnCode
                    LEFT JOIN TCNMAgency_L        AGNL WITH(NOLOCK) ON CHNS.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID = $nLngID
                    LEFT JOIN TCNMBranch_L        BCHL WITH(NOLOCK) ON CHNS.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                    LEFT JOIN TSysApp_L           APPL WITH(NOLOCK) ON CHN.FTAppCode = APPL.FTAppCode  AND APPL.FNLngID = $nLngID
                    LEFT JOIN TCNMPdtPriList_L    PPLL WITH(NOLOCK) ON CHN.FTPplCode = PPLL.FTPplCode AND PPLL.FNLngID = $nLngID
                    LEFT JOIN TCNMWaHouse_L       WAHL WITH(NOLOCK) ON CHNS.FTBchCode =  WAHL.FTBchCode AND CHN.FTWahCode = WAHL.FTWahCode AND WAHL.FNLngID = $nLngID
                    LEFT JOIN (
                        SELECT FTChnCode FROM TCNMPos WITH(NOLOCK) WHERE ISNULL(FTChnCode,'') != ''
                        UNION
                        SELECT FTChnCode FROM TCNMAgency WITH(NOLOCK) WHERE ISNULL(FTChnCode,'') != ''
                        UNION
                        SELECT FTChnCode FROM TCNTPdtPmtHDChn WITH(NOLOCK) WHERE ISNULL(FTChnCode,'') != ''
                    ) REF ON CHN.FTChnCode = REF.FTChnCode
                    WHERE 1=1
                    $tWhereCondition
                 ";
        $tSQL3 = " ) Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";


        $tFullQuery  = $tSQL1.$tSQL2.$tSQL3;
        $tCountQuery = $tSQL2;
        // print_r($tSQL);

        $oQuery = $this->db->query($tFullQuery);
        // echo $this->db->last_query();exit;
        if ( $oQuery->num_rows() > 0 ) {
            $oCount = $this->db->query($tSQL2);
            // $oList = $oQuery->result();
            // $aFoundRow = $this->FSnMCHNGetPageAll(/*$tWhereCode,*/$tSearchList, $nLngID);
            // $nFoundRow = $aFoundRow[0]->counts;
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
     * Functionality : All Page Of Slip Message
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMCHNGetPageAll(/*$ptWhereCode,*/$ptSearchList, $ptLngID)
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
     * Parameters : $ptDstCode
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMCHNCheckDuplicate($ptChnCode)
    {
        $tSQL = "SELECT COUNT(FTChnCode) AS counts
                 FROM TCNMChannel
                 WHERE FTChnCode = '$ptChnCode'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
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
    public function FSaMCHNAddUpdateHD($paData)
    {
        try {
            if ($paData['tTypeInsertUpdate'] == 'Update') {
                // Update
                $this->db->set('FTAppCode', $paData['FTAppCode']);
                $this->db->set('FTChnStaUse', $paData['FTChnStaUse']);
                $this->db->set('FTChnRefCode', $paData['FTChnRefCode']);
                $this->db->set('FTPplCode', $paData['FTPplCode']);
                $this->db->set('FTWahCode', $paData['FTWahCode']);
                $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
                $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
                $this->db->set('FTChnWahDO', $paData['FTChnWahDO']);
                $this->db->set('FTChnStaUseDO', $paData['FTChnStaUseDO']);
                $this->db->set('FTChnStaAlwSNPL', $paData['FTChnStaAlwSNPL']);
                $this->db->where('FTChnCode', $paData['FTChnCode']);
                $this->db->update('TCNMChannel');

                $this->db->set('FNLngID', $paData['FNLngID']);
                $this->db->set('FTChnName', $paData['FTChnName']);
                $this->db->where('FTChnCode', $paData['FTChnCode']);
                $this->db->update('TCNMChannel_L');

                if ( $paData['FTAgnCode'] != '' || $paData['FTBchCode'] != '' || $paData['FTAppCode'] != '' ) {
                    $this->db->select('FTChnCode');
                    $this->db->from('TCNMChannelSpc');
                    $this->db->where('FTChnCode', $paData['FTChnCode']);
                    $oGetChn = $this->db->get();
                    $nDataChn = $oGetChn->num_rows();
                    if ($nDataChn > 0) {
                        $this->db->set('FTAgnCode', $paData['FTAgnCode']);
                        $this->db->set('FTAppCode', $paData['FTAppCode']);
                        $this->db->set('FTBchCode', $paData['FTBchCode']);
                        $this->db->where('FTChnCode', $paData['FTChnCode']);
                        $this->db->update('TCNMChannelSpc');
                    } else {
                        $this->db->insert('TCNMChannelSpc', array(
                            'FTChnCode'     => $paData['FTChnCode'],
                            'FTAgnCode'    => $paData['FTAgnCode'],
                            'FTAppCode'    => $paData['FTAppCode'],
                            'FNChnSeq'   => $paData['FNChnSeq'],
                            'FTBchCode'     => $paData['FTBchCode'],
                        ));
                    }
                }else{
                    $this->db->where('FTChnCode', $paData['FTChnCode']);
                    $this->db->delete('TCNMChannelSpc');
                }

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
                $this->db->insert('TCNMChannel', array(
                    'FTChnCode'     => $paData['FTChnCode'],
                    'FTAppCode'    => $paData['FTAppCode'],
                    'FNChnSeq'   => $paData['FNChnSeq'],
                    'FTChnStaUse'   => $paData['FTChnStaUse'],
                    'FTChnRefCode'   => $paData['FTChnRefCode'],
                    'FTPplCode'     => $paData['FTPplCode'],
                    'FTWahCode'    => $paData['FTWahCode'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                    'FTChnWahDO'   => $paData['FTChnWahDO'],
                    'FTChnStaUseDO'   => $paData['FTChnStaUseDO'],
                    'FTChnStaAlwSNPL' => $paData['FTChnStaAlwSNPL']
                    // 'FTChnGroup'   => $paData['FTChnGroup'],
                ));
                $this->db->insert('TCNMChannel_L', array(
                    'FTChnCode'     => $paData['FTChnCode'],
                    'FNLngID' => $paData['FNLngID'],
                    'FTChnName'    => $paData['FTChnName'],
                    'FTChnRmk'    => '',
                    // 'FTBchCode'     => $paData['FTBchCode'],
                ));

                if ($paData['FTAgnCode'] != '' || $paData['FTBchCode'] != '') {
                    $this->db->insert('TCNMChannelSpc', array(
                        'FTChnCode'     => $paData['FTChnCode'],
                        'FTAgnCode'    => $paData['FTAgnCode'],
                        'FTAppCode'    => $paData['FTAppCode'],
                        'FNChnSeq'   => $paData['FNChnSeq'],
                        'FTBchCode'     => $paData['FTBchCode'],
                    ));
                }

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
     * Functionality : Update Lang Slip Message
     * Parameters : $paData is data for update
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    // public function FSaMCHNAddUpdateDT($paData)
    // {
    //     try {
    //         // Add Detail
    //         $this->db->insert('TCNMSlipMsgDT_L', array(
    //             'FTSmgCode' => $paData['FTSmgCode'],
    //             'FTSmgType' => $paData['FTSmgType'],
    //             'FNLngID'   => $paData['FNLngID'],
    //             'FNSmgSeq'  => $paData['FNSmgSeq'],
    //             'FTSmgName' => $paData['FTSmgName']
    //         ));

    //         // Set Response status
    //         if ($this->db->affected_rows() > 0) {
    //             $aStatus = array(
    //                 'rtCode' => '1',
    //                 'rtDesc' => 'Add Lang Success',
    //             );
    //         } else {
    //             $aStatus = array(
    //                 'rtCode' => '905',
    //                 'rtDesc' => 'Error Cannot Add/Edit Lang.',
    //             );
    //         }

    //         // Response status
    //         return $aStatus;
    //     } catch (Exception $Error) {
    //         return $Error;
    //     }
    // }

    /**
     * Functionality : Delete Slip Message
     * Parameters : $paDataFSnMCHNDelHD
     * Creator : 05/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSnMCHNDelHD($paData)
    {
        // $this->db->where_in('FTBchCode', $paData['FTBchCode']);
        $this->db->where('FTChnCode', $paData['FTChnCode']);
        $this->db->delete('TCNMChannel');

        // $this->db->where_in('FTBchCode', $paData['FTBchCode']);
        $this->db->where('FTChnCode', $paData['FTChnCode']);
        $this->db->delete('TCNMChannel_L');

        $this->db->where('FTChnCode', $paData['FTChnCode']);
        $this->db->delete('TCNMChannelSpc');

        $this->db->where('FTChnCode', $paData['FTChnCode']);
        $this->db->delete('TCNMChannelSpcWah');
        
        // print_r($this->db->affected_rows());
        // exit();
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

    /**
     * Functionality : {description}
     * Parameters : {params}
     * Creator : dd/mm/yyyy piya
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    // public function FSnMCHNDelDT($paData)
    // {

    //     $this->db->where('FTSmgCode', $paData['FTSmgCode']);
    //     $this->db->delete('TCNMSlipMsgDT_L');

    //     /*if($this->db->affected_rows() > 0){
    //         // Success
    //         $aStatus = array(
    //             'rtCode' => '1',
    //             'rtDesc' => 'success',
    //         );
    //     }else{
    //         // Ploblem
    //         $aStatus = array(
    //             'rtCode' => '905',
    //             'rtDesc' => 'cannot Delete Item.',
    //         );
    //     }
    //     $jStatus = json_encode($aStatus);
    //     $aStatus = json_decode($jStatus, true);
    //     return $aStatus;*/

    //     return $aStatus = array(
    //         'rtCode' => '1',
    //         'rtDesc' => 'success',
    //     );
    // }



    //Functionality : get all row data from pdt location
    //Parameters : -
    //Creator : 1/04/2019 Pap
    //Return : array result from db
    //Return Type : array

    public function FSnMLOCGetAllNumRow()
    {
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMChannel";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        } else {
            $aResult = false;
        }
        return $aResult;
    }



    public function  FSaMChnDeleteMultiple($paDataDelete)
    {
        // print_r($paDataDelete); die();

        // $this->db->where_in('FTBchCode', $paDataDelete['FTBchCode']);
        $this->db->where_in('FTChnCode', $paDataDelete['FTChnCode']);
        $this->db->delete('TCNMChannel');


        // $this->db->where_in('FTBchCode', $paDataDelete['FTBchCode']);
        $this->db->where_in('FTChnCode', $paDataDelete['FTChnCode']);
        $this->db->delete('TCNMChannel_L');


        $this->db->where_in('FTChnCode', $paDataDelete['FTChnCode']);
        $this->db->delete('TCNMChannelSpc');

        $this->db->where_in('FTChnCode', $paDataDelete['FTChnCode']);
        $this->db->delete('TCNMChannelSpcWah');


        if ($this->db->affected_rows() == 0) {
            //Success
            $aStatus   = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            //Ploblem
            $aStatus = array(
                'rtCode' => '1',
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
    public function FSnMChnCountSeq($ptAppCode)
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

    // Create By : Napat(Jame) 13/06/2022
    public function FSaMCHNGetDataSpcWah($paSearch){

        $tType      = $paSearch['tType'];
        $tChnCode   = $paSearch['tChnCode'];
        $nLngID     = $paSearch['FNLngID'];

        $tSesUsrLevel        = $this->session->userdata("tSesUsrLevel");
        $tSesUsrBchCodeMulti = $this->session->userdata("tSesUsrBchCodeMulti");

        if( $tType == 'List' ){
            $aRowLen    = FCNaHCallLenData($paSearch['nRow'], $paSearch['nPage']);
            $tSQL1 = " SELECT c.* FROM( SELECT  ROW_NUMBER() OVER(ORDER BY FTAgnCode,FTBchCode,FTWahCode ASC) AS rtRowID,* FROM ( ";
        }

        $tSQL2 = "   SELECT 
                        AGNL.FTAgnName,
                        BCHL.FTBchName,
                        WAHL.FTWahName,
                        CSW.FTAgnCode,
                        CSW.FTBchCode,
                        CSW.FTWahCode,
                        CSW.FTChnCode,
                        CSW.FTChnStaDoc 
                    FROM TCNMChannelSpcWah CSW WITH(NOLOCK)
                    LEFT JOIN TCNMAgency_L AGNL WITH(NOLOCK) ON AGNL.FTAgnCode = CSW.FTAgnCode AND AGNL.FNLngID = $nLngID 
                    LEFT JOIN TCNMBranch_L BCHL WITH(NOLOCK) ON BCHL.FTBchCode = CSW.FTBchCode AND BCHL.FNLngID = $nLngID
                    LEFT JOIN TCNMWaHouse_L WAHL WITH(NOLOCK) ON WAHL.FTWahCode = CSW.FTWahCode AND WAHL.FTBchCode = CSW.FTBchCode AND WAHL.FNLngID = $nLngID 
                    WHERE CSW.FTChnCode = '$tChnCode' ";

        if( $tSesUsrLevel != "HQ" ){
            $tSQL2 .= " AND CSW.FTBchCode IN ($tSesUsrBchCodeMulti) ";
        }

        if( isset($paSearch['tBchCode']) && !empty($paSearch['tBchCode']) ){
            $tSQL2 .= " AND CSW.FTBchCode = '".$paSearch['tBchCode']."' ";
        }

        if( isset($paSearch['tWahCode']) && !empty($paSearch['tWahCode']) ){
            $tSQL2 .= " AND CSW.FTWahCode = '".$paSearch['tWahCode']."' ";
        }

        if( $tType == 'List' ){
            $tSQL3 = " ) Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";
            $tMainQuery  = $tSQL1.$tSQL2.$tSQL3;
        }else{
            $tMainQuery  = $tSQL2;
        }

        $oMainQuery = $this->db->query($tMainQuery);
        if( $tType == 'List' ){
            if( $oMainQuery->num_rows() > 0 ){
                $oPageQuery = $this->db->query($tSQL2);
                $nFoundRow  = $oPageQuery->num_rows();
                $nPageAll   = ceil($nFoundRow / $paSearch['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult = array(
                    'aItems'        => $oMainQuery->result_array(),
                    'nAllRow'       => $nFoundRow,
                    'nCurrentPage'  => $paSearch['nPage'],
                    'nAllPage'      => $nPageAll,
                    'tCode'         => '1',
                    'tDesc'         => 'success',
                );
            }else{
                $aResult = array(
                    'nAllRow'       => 0,
                    'nCurrentPage'  => $paSearch['nPage'],
                    "nAllPage"      => 0,
                    'tCode'         => '800',
                    'tDesc'         => 'data not found.',
                );
            }
        }else{
            if( $oMainQuery->num_rows() > 0 ){
                $aResult = array(
                    'aItems'        => $oMainQuery->result_array(),
                    'tCode'         => '1',
                    'tDesc'         => 'success',
                );
            }else{
                $aResult = array(
                    'tCode'         => '800',
                    'tDesc'         => 'data not found.',
                );
            }
        }
        return $aResult;
    }

    
    // Create By : Napat(Jame) 13/06/2022
    public function FSxMCHNEventSpcWahAdd($paData){
        $this->db->insert('TCNMChannelSpcWah', $paData);
    }

    // Create By : Napat(Jame) 13/06/2022
    public function FSxMCHNEventUpdDate($paData){
        $dDate          =  date('Y-m-d H:i:s');
        $tSesUsername   = $this->session->userdata("tSesUsername");

        $this->db->set('FDLastUpdOn', $dDate);
        $this->db->set('FTLastUpdBy', $tSesUsername);
        $this->db->where('FTChnCode', $paData['FTChnCode']);
        $this->db->update('TCNMChannel');
    }

    // Create By : Napat(Jame) 13/06/2022
    public function FSaMCHNEventSpcWahChkDup($paData){
        $tSQL = "   SELECT 1 FROM TCNMChannelSpcWah WITH(NOLOCK) 
                    WHERE FTChnCode = '".$paData['FTChnCode']."' 
                      AND FTBchCode = '".$paData['FTBchCode']."' 
                      AND FTWahCode = '".$paData['FTWahCode']."' ";
        $oQuery = $this->db->query($tSQL);
        if( $oQuery->num_rows() > 0 ){
            $aResult = array(
                'tCode'    => '1',
                'tDesc'    => 'duplicate data',
            );
        }else{
            $aResult = array(
                'tCode' => '800',
                'tDesc' => 'no duplicate',
            );
        }
        return $aResult;
    }
    
    // Create By : Napat(Jame) 13/06/2022
    public function FSaMCHNEventGetDataSpcWahByPK($paData){
        $tSQL = "   SELECT 1 FROM TCNMChannelSpcWah WITH(NOLOCK) 
                    WHERE FTChnCode = '".$paData['FTChnCode']."' 
                      AND FTBchCode = '".$paData['FTBchCode']."' 
                      AND FTWahCode = '".$paData['FTWahCode']."' ";
        $oQuery = $this->db->query($tSQL);
        if( $oQuery->num_rows() > 0 ){
            $aResult = array(
                'tCode'    => '1',
                'tDesc'    => 'duplicate data',
            );
        }else{
            $aResult = array(
                'tCode' => '800',
                'tDesc' => 'no duplicate',
            );
        }
        return $aResult;
    }

    // Create By : Napat(Jame) 13/06/2022
    public function FSxMCHNEventSpcWahEdit($paDataSearch,$paDataEdit){
        $this->db->where($paDataSearch);
        $this->db->update('TCNMChannelSpcWah', $paDataEdit);
    }

    // Create By : Napat(Jame) 13/06/2022
    public function FSxMCHNEventSpcWahDel($paDataDel){
        $this->db->where($paDataDel);
        $this->db->delete('TCNMChannelSpcWah');
    }

    // Create By : Napat(Jame) 14/06/2022
    public function FSaMCHNEventChkSpcWah($paData){
        $tSQL = "   SELECT 1 FROM TCNMChannelSpcWah WITH(NOLOCK) 
                    WHERE ( FTBchCode != '".$paData['FTBchCode']."' OR FTAgnCode != '".$paData['FTAgnCode']."' )
                      AND FTChnCode = '".$paData['FTChnCode']."' ";
        $oQuery = $this->db->query($tSQL);
        if( $oQuery->num_rows() > 0 ){
            $aResult = array(
                'tCode'    => '1',
                'tDesc'    => 'found data',
            );
        }else{
            $aResult = array(
                'tCode' => '800',
                'tDesc' => 'not found data',
            );
        }
        return $aResult;
    }

    // Create By : Napat(Jame) 14/06/2022
    public function FSxMCHNEventClearSpcWah($paData){
        $tSQL = "   DELETE FROM TCNMChannelSpcWah
                    WHERE ( FTBchCode != '".$paData['FTBchCode']."' OR FTAgnCode != '".$paData['FTAgnCode']."' )
                      AND FTChnCode = '".$paData['FTChnCode']."' ";
        $this->db->query($tSQL);
    }
    
    
}
