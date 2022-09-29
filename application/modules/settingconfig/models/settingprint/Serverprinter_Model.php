<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Serverprinter_Model extends CI_Model
{

    /**
     * Functionality : Search Server Printer By ID
     * Parameters : $paData
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMSrvPriSearchByID($paData)
    {
        $tSrvPriCode    = $paData['tSrvCode'];
        $tAgnCode       = $paData['tAgnCode'];
        $nLngID         = $paData['FNLngID'];


        $tSQL       = "SELECT
                            PrnSrv.FTAgnCode   AS rtPrnSrvAgnCode,
                            AGN_L.FTAgnName AS rtPrnSrvAgnName,
                            PrnSrv.FTSrvCode   AS rtPrnSrvCode,
                            PrnSrvL.FTSrvName  AS rtPrnSrvName,
                            PrnSrvL.FTSrvRmk   AS rtPrnSrvRmk,
                            PrnSrv.FTSrvStaUse   AS rtPrnSrvStaUse
                       FROM [TCNMPrnServer] PrnSrv
                       LEFT JOIN [TCNMPrnServer_L]  PrnSrvL ON PrnSrv.FTSrvCode = PrnSrvL.FTSrvCode AND PrnSrvL.FTAgnCode = PrnSrv.FTAgnCode  AND PrnSrvL.FNLngID = $nLngID
                       LEFT JOIN [TCNMAgency_L] AGN_L ON AGN_L.FTAgnCode = PrnSrv.FTAgnCode  AND AGN_L.FNLngID = $nLngID
                       WHERE 1=1 ";
        if ($tSrvPriCode != "") {
            $tSQL .= "AND PrnSrv.FTSrvCode = '$tSrvPriCode'";
        }
        if ($tAgnCode != "") {
            $tSQL .= "AND PrnSrv.FTAgnCode = '$tAgnCode'";
        }

      
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
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

    /**
     * Functionality : List Server Printer
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMSrvPriList($paData)
    {
        // return null;
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID     = $paData['FNLngID'];

        $tSesAgnCode = $paData['tSesAgnCode'];
        $tSQL       = "SELECT c.* FROM(
                       SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , rtPrnSrvCode DESC) AS rtRowID,*
                       FROM
                       (SELECT DISTINCT
                       PrnSrv.FTAgnCode   AS rtPrnSrvAgnCode,
                       AGN_L.FTAgnName AS rtPrnSrvAgnName,
                       PrnSrv.FTSrvCode   AS rtPrnSrvCode,
                       PrnSrvL.FTSrvName  AS rtPrnSrvName,
                                PrnSrv.FDCreateOn,
                        PrnSrv.FTSrvStaUse   AS   rtPrnSrvSta
                        FROM [TCNMPrnServer] PrnSrv
                        LEFT JOIN [TCNMPrnServer_L] PrnSrvL ON PrnSrvL.FTSrvCode = PrnSrv.FTSrvCode AND PrnSrvL.FTAgnCode = PrnSrv.FTAgnCode  AND PrnSrvL.FNLngID = $nLngID
                        LEFT JOIN [TCNMAgency_L] AGN_L ON AGN_L.FTAgnCode = PrnSrv.FTAgnCode  AND AGN_L.FNLngID = $nLngID
                        WHERE 1=1";

        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != '') {
            $tSQL .= " AND PrnSrv.FTSrvCode COLLATE THAI_BIN LIKE '%$tSearchList%'  OR PrnSrvL.FTSrvName COLLATE THAI_BIN LIKE '%$tSearchList%'";
        }

        if($tSesAgnCode!=''){
            $tSQL .= " AND PrnSrv.FTAgnCode ='$tSesAgnCode' ";
        }

        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMSrvPriGetPageAll(/*$tWhereCode,*/$tSearchList, $nLngID, $tSesAgnCode);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
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
     * Functionality : All Page Of Server Printer
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMSrvPriGetPageAll($ptSearchList, $ptLngID, $tSesAgnCode)
    {
        $tSQL = "SELECT COUNT (PrnSrv.FTSrvCode) AS counts
                FROM [TCNMPrnServer] PrnSrv
                LEFT JOIN [TCNMPrnServer_L] PrnSrvL ON PrnSrvL.FTSrvCode = PrnSrv.FTSrvCode AND PrnSrvL.FNLngID = $ptLngID
                WHERE 1=1 ";

        if ($ptSearchList != '') {
            $tSQL .= " AND (PrnSrv.FTSrvCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR PrnSrvL.FTSrvName LIKE '%$ptSearchList%')";
        }

        if($tSesAgnCode!=''){
            $tSQL .= " AND PrnSrv.FTAgnCode ='$tSesAgnCode' ";
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
     * Parameters : $ptSrvPriCode
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMSrvPriCheckDuplicate($ptPrnSrvCode,$ptPrnSrvAgnCode)
    {
        $tSQL = "SELECT COUNT(FTSrvCode) AS counts
                 FROM TCNMPrnServer
                 WHERE FTSrvCode = '$ptPrnSrvCode' AND  FTAgnCode= '$ptPrnSrvAgnCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    /**
     * Functionality : Update Server Printer
     * Parameters : $paData is data for update
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMSrvPriAddUpdateMaster($paData)
    {

        try {
            // Update Master
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
            $this->db->set('FTSrvStaUse', $paData['FTSrvPriStaUse']);
            $this->db->where('FTSrvCode', $paData['FTSrvPriCode']);
            $this->db->where('FTAgnCode', $paData['FTAgnCode']);
            $this->db->update('TCNMPrnServer');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            } else {
                // Add Master
                $this->db->insert('TCNMPrnServer', array(
                    'FTAgnCode'     => $paData['FTAgnCode'],
                    'FTSrvCode'     => $paData['FTSrvPriCode'],
                    'FDCreateOn'    => $paData['FDCreateOn'],
                    'FTCreateBy'    => $paData['FTCreateBy'],
                    'FDLastUpdOn'   => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paData['FTLastUpdBy'],
                    'FTSrvStaUse'   => $paData['FTSrvPriStaUse']

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

    /**
     * Functionality : Update Lang Server Printer
     * Parameters : $paData is data for update
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMSrvPriAddUpdateLang($paData)
    {
        try {
            // Update Lang
            $this->db->set('FTSrvName', $paData['FTSrvPriName']);
            $this->db->set('FTSrvRmk', $paData['FTSrvPriRmk']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTSrvCode', $paData['FTSrvPriCode']);
            $this->db->where('FTAgnCode', $paData['FTAgnCode']);
            $this->db->update('TCNMPrnServer_L');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            } else { // Add Lang
                $this->db->insert('TCNMPrnServer_L', array(
                    'FTAgnCode' => $paData['FTAgnCode'],
                    'FTSrvCode' => $paData['FTSrvPriCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTSrvName' => $paData['FTSrvPriName'],
                    'FTSrvRmk'  => $paData['FTSrvPriRmk']
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

    /**
     * Functionality : Delete Server Printer
     * Parameters : $paData
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    /* LastUpdate By Napat(Jame) 29/09/2022 เพิ่มลบตาราง Spc */
    public function FSnMSrvPriDel($paData)
    {
        $this->db->where('FTSrvCode', $paData['FTSrvPriCode']);
        $this->db->where('FTAgnCode', $paData['FTAgnCode']);
        $this->db->delete('TCNMPrnServer');

        $this->db->where('FTSrvCode', $paData['FTSrvPriCode']);
        $this->db->where('FTAgnCode', $paData['FTAgnCode']);
        $this->db->delete('TCNMPrnServer_L');

        $this->db->where('FTSrvCode', $paData['FTSrvPriCode']);
        $this->db->where('FTAgnCode', $paData['FTAgnCode']);
        $this->db->delete('TCNMPrnServerSpc');

        return $aStatus = array(
            'rtCode' => '1',
            'rtDesc' => 'success',
        );
    }

    // Create By : Napat(Jame) 26/09/2022
    public function FSaMSrvPriSpcList($paData){

        $nLngID     = $this->session->userdata("tLangEdit");
        $tAgnCode   = $paData['tAgnCode'];
        $tSrvCode   = $paData['tSrvCode'];

        $tSQL       = " SELECT
                            PSS.FTAgnCode,
                            PSS.FTSrvCode,
                            PSS.FTPlbCode,
                            PLBL.FTPblName,
                            PSS.FTLblCode,
                            LBFL.FTLblName
                        FROM TCNMPrnServerSpc PSS WITH(NOLOCK)
                        INNER JOIN TCNMPrnLabel  PLB  WITH(NOLOCK) ON PLB.FTAgnCode = PSS.FTAgnCode AND PLB.FTPlbCode = PSS.FTPlbCode
                        LEFT JOIN TCNMPrnLabel_L PLBL WITH(NOLOCK) ON PLBL.FTAgnCode = PLB.FTAgnCode AND PLBL.FTPlbCode = PLB.FTPlbCode AND PLBL.FNLngID = $nLngID
                        LEFT JOIN TCNSLabelFmt_L LBFL WITH(NOLOCK) ON LBFL.FTLblCode = PSS.FTLblCode AND LBFL.FNLngID = $nLngID
                        WHERE PSS.FTSrvCode <> '' ";

        if( isset($tAgnCode) && !empty($tAgnCode) ){
            $tSQL .= " AND (PSS.FTAgnCode = '$tAgnCode' OR ISNULL(PSS.FTAgnCode,'') = '') ";
        }

        if( isset($tSrvCode) && !empty($tSrvCode) ){
            $tSQL .= " AND PSS.FTSrvCode = '$tSrvCode' ";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = array(
                'aItems'        => $oQuery->result_array(),
                'tCode'        => '1',
                'tDesc'        => 'found data',
            );
        } else {
            $aResult = array(
                'tCode' => '800',
                'tDesc' => 'data not found',
            );
        }

        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    // Create By : Napat(Jame) 27/09/2022
    public function FSaMSrvPriSpcAddData($paPackData){
        $this->db->insert_batch('TCNMPrnServerSpc', $paPackData);
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'tCode' => '1',
                'tDesc' => 'Add Success',
            );
        } else {
            $aStatus = array(
                'tCode' => '905',
                'tDesc' => 'Add Unsuccess',
            );
        }
        return $aStatus;
    }

    // Create By : Napat(Jame) 28/09/2022
    public function FSaMSrvPriSpcDelData($paDelData){
        $this->db->delete('TCNMPrnServerSpc', $paDelData);
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'tCode' => '1',
                'tDesc' => 'Delete Success',
            );
        } else {
            $aStatus = array(
                'tCode' => '905',
                'tDesc' => 'Delete Unsuccess',
            );
        }
        return $aStatus;
    }

    // Create By : Napat(Jame) 28/09/2022
    public function FSaMSrvPriGetPrnLabelExport($ptAgnCode,$ptSrvCode,$pnLngID){
        $tSQL = "   SELECT
                        PLB.FTAgnCode,
                        PLB.FTPlbCode,
                        PLB.FTLblCode,
                        PLB.FTSppCode,
                        PLB.FTPlbStaUse,
                        PLB.FDLastUpdOn,
                        PLB.FTLastUpdBy,
                        PLB.FDCreateOn,
                        PLB.FTCreateBy
                    FROM TCNMPrnServerSpc     PSS  WITH(NOLOCK)
                    INNER JOIN TCNMPrnLabel   PLB  WITH(NOLOCK) ON PLB.FTAgnCode = PSS.FTAgnCode AND PLB.FTPlbCode = PSS.FTPlbCode
                    WHERE PSS.FTAgnCode = '$ptAgnCode' 
                      AND PSS.FTSrvCode = '$ptSrvCode' ";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aResult = array(
                'raItems'       => $oQuery->result_array(),
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aResult = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found.',
            );
        }
        return $aResult;
    }

    // Create By : Napat(Jame) 28/09/2022
    public function FSaMSrvPriGetPrnLabelLExport($ptAgnCode,$ptSrvCode,$pnLngID){
        $tSQL = "   SELECT
                        PLBL.FTAgnCode,
                        PLBL.FTPlbCode,
                        PLBL.FNLngID,
                        PLBL.FTPblName,
                        PLBL.FTPblRmk
                    FROM TCNMPrnServerSpc     PSS  WITH(NOLOCK)
                    LEFT JOIN TCNMPrnLabel_L  PLBL WITH(NOLOCK) ON PLBL.FTAgnCode = PSS.FTAgnCode AND PLBL.FTPlbCode = PSS.FTPlbCode AND PLBL.FNLngID = $pnLngID
                    WHERE PSS.FTAgnCode = '$ptAgnCode' 
                      AND PSS.FTSrvCode = '$ptSrvCode' ";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aResult = array(
                'raItems'       => $oQuery->result_array(),
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aResult = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found.',
            );
        }
        return $aResult;
    }

    // Create By : Napat(Jame) 28/09/2022
    public function FSaMSrvPriGetLabelFmtExport($ptAgnCode,$ptSrvCode,$pnLngID){
        $tSQL = "   SELECT
                        LBF.FTLblCode,
                        LBF.FTLblRptNormal,
                        LBF.FTLblRptPmt,
                        LBF.FTLblStaUse,
                        LBF.FDLastUpdOn,
                        LBF.FTLastUpdBy,
                        LBF.FDCreateOn,
                        LBF.FTCreateBy
                    FROM TCNMPrnServerSpc PSS WITH(NOLOCK)
                    INNER JOIN TCNMPrnLabel PLB WITH(NOLOCK) ON PLB.FTAgnCode = PSS.FTAgnCode AND PLB.FTPlbCode = PSS.FTPlbCode
                    INNER JOIN TCNSLabelFmt LBF WITH(NOLOCK) ON LBF.FTLblCode = PLB.FTLblCode
                    WHERE PSS.FTAgnCode = '$ptAgnCode' 
                      AND PSS.FTSrvCode = '$ptSrvCode' ";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aResult = array(
                'raItems'       => $oQuery->result_array(),
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aResult = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found.',
            );
        }
        return $aResult;
    }

    // Create By : Napat(Jame) 28/09/2022
    public function FSaMSrvPriGetLabelFmtLExport($ptAgnCode,$ptSrvCode,$pnLngID){
        $tSQL = "   SELECT
                        LBFL.FTLblCode,
                        LBFL.FNLngID,
                        LBFL.FTLblName,
                        LBFL.FTLblRmk
                    FROM TCNMPrnServerSpc     PSS  WITH(NOLOCK)
                    INNER JOIN TCNMPrnLabel   PLB  WITH(NOLOCK) ON PLB.FTAgnCode = PSS.FTAgnCode AND PLB.FTPlbCode = PSS.FTPlbCode
                    INNER JOIN TCNSLabelFmt_L LBFL WITH(NOLOCK) ON LBFL.FTLblCode = PLB.FTLblCode AND LBFL.FNLngID = $pnLngID
                    WHERE PSS.FTAgnCode = '$ptAgnCode' 
                      AND PSS.FTSrvCode = '$ptSrvCode' ";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aResult = array(
                'raItems'       => $oQuery->result_array(),
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aResult = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found.',
            );
        }
        return $aResult;
    }

    // Create By : Napat(Jame) 28/09/2022
    public function FSaMSrvPriGetDataUrlObjectExport(){
        $tSQL = " SELECT * FROM TCNTUrlObject WITH(NOLOCK) ";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aResult = array(
                'raItems'       => $oQuery->result_array(),
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aResult = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found.',
            );
        }
        return $aResult;
    }

    // Create By : Napat(Jame) 28/09/2022
    public function FSaMSrvPriGetDataUrlObjectLoginExport(){
        $tSQL = " SELECT * FROM TCNTUrlObjectLogin WITH(NOLOCK) ";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aResult = array(
                'raItems'       => $oQuery->result_array(),
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aResult = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found.',
            );
        }
        return $aResult;
    }

    public function FSnMSrvPriCountDataSpc($paData){
        $tAgnCode = $paData['tAgnCode'];
        $tSrvCode = $paData['tSrvCode'];

        $tSQL = " SELECT FTSrvCode FROM TCNMPrnServerSpc WITH(NOLOCK) WHERE FTAgnCode = '$tAgnCode' AND FTSrvCode = '$tSrvCode' ";
        $oQuery = $this->db->query($tSQL);
        $nCount = $oQuery->num_rows();
        return $nCount;
    }

}
