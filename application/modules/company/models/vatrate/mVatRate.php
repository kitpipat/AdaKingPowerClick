<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
date_default_timezone_set("Asia/Bangkok");
class mVatrate extends CI_Model {
    
    private $tTable = 'TCNMVatRate';
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Functionality : Query by vatcode, vatrate, vatstart
     * Parameters : $ptVatCode is vat code, $ptVatRate is vat rate, $ptVatStart is vat date start
     * Creator : 23/08/2018 piya
     * Last Modified : 28/08/2018 piya
     * Return : Vat Rate Record
     * Return Type : Object
     */
    public function FSoMVATGetByVCodeVRateVStart($ptVatCode = '', $ptVatRate = '', $ptVatStart = ''){
        $tSQL = "SELECT VR.* 
                FROM TCNMVatRate VR
                WHERE VR.FTVatCode = ?
                AND convert(varchar(10),VR.FDVatStart,121) = ?";
        if($ptVatRate != ''){
            $tSQL .= "AND VR.FCVatRate = ?";
            $oQuery = $this->db->query($tSQL, array($ptVatCode, $ptVatRate, $ptVatStart));
        }else{
            $oQuery = $this->db->query($tSQL, array($ptVatCode, $ptVatStart));
        }
        return $oQuery;
    }
    
    /**
     * Functionality : Insert or Update Vat Rate
     * Parameters : $ptVatCode is vat code, $poData is vat rate data
     * Creator : 23/08/2018 piya
     * Last Modified : 27/08/2018 piya
     * Return : Vat rate record
     * Return Type : Object
     */
    public function FSoMVATCreateOrUpdate($ptVatCode, $poData){
        $tCurrentUser = $this->session->userdata('tSesUsername');
        $tSQL = "INSERT INTO TCNMVatRate
                    (FTVatCode, 
                    FCVatRate, 
                    FDVatStart,
                    FDCreateOn,
                    FTCreateBy, 
                    FDLastUpdOn, 
                    FTLastUpdBy)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $oQuery = $this->db->query($tSQL, 
            [
                $ptVatCode, 
                $poData->vatRate, 
                $poData->vatStart, 
                date('Y-m-d H:i:s'), 
                $tCurrentUser, 
                date('Y-m-d H:i:s'), 
                $tCurrentUser
            ]
        );
        return $oQuery;
    }
    
    /**
     * Functionality : Delete vat rate
     * Parameters : $ptVatCode is vat code
     * Creator : 23/08/2018 piya
     * Last Modified : -
     * Return : Vat rate record
     * Return Type : Object
     */
    public function FSoMVATDelete($ptVatCode){
        $oquery = $this->db->delete($this->tTable, array('FTVatCode' => $ptVatCode));
        return $oquery;
    }
    
    /**
     * Functionality : Query by vat code
     * Parameters : $ptVatCode is vat code
     * Creator : 24/08/2018 piya
     * Last Modified : -
     * Return : Vat rate record
     * Return Type : Object
     */
    public function FSoMVATGetByVCode($ptVatCode = ''){
        $tSQL = "SELECT VR.* 
                FROM TCNMVatRate VR
                WHERE VR.FTVatCode = ?";
        
        $oQuery = $this->db->query($tSQL, array($ptVatCode));
        return $oQuery;
    }

    /**
     * Functionality : Search Vatrate By ID
     * Parameters : function parameters
     * Creator : 13/06/2018 Wasin
     * Last Modified : 30/08/2018 piya
     * Return : Vat rate record
     * Return Type : array
     */
    public function FSaMVATSearchByID ($paData){
        $tVatCode   = $paData['FTVatCode'];
        $tSQL   = "SELECT c.* FROM(
                        SELECT ROW_NUMBER() OVER(ORDER BY rtVatCode ASC , rtVatStart ASC) AS rtRowID, * 
                        FROM (
                            SELECT DISTINCT 
                                VAT.FTVatCode 	AS rtVatCode,
                                VAT.FCVatRate	AS rtVatRate,
                                VAT.FDVatStart	AS rtVatStart
                            FROM TCNMVatRate VAT
                            WHERE 1=1 ";
        if ($tVatCode != '') {
            $tSQL .= "AND VAT.FTVatCode = '$tVatCode'";
        }
        
        $tSQL .= ") Base) AS c ";
        $oQuery = $this->db->query($tSQL);
        
        if ($oQuery->num_rows() > 0) { // Found
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems' => $oDetail,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{ // Not Found
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
     * Functionality : List vat rate
     * Parameters : $paData is data for query
     * Creator : 13/06/2018 Wasin
     * Last Modified : -
     * Return : Vat rate data
     * Return Type : array
     */
    public function FSaMVATList($paData){
        $aRowLen    = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $tSQL       = "SELECT c.* FROM(
                       SELECT DISTINCT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC, rtVatCode DESC) AS rtRowID,* 
                       FROM
                       (SELECT DISTINCT
                            VAT.FTVatCode   AS rtVatCode,
                            VAT.FCVatRate   AS rtVatRate,
                            VAT.FDVatStart  AS rtVatDateStart,
                            VAT.FDCreateOn,
                            CASE
                                WHEN ISNULL(COMP.FTVatCode,'')  != '' THEN '1'
                                WHEN ISNULL(ASPC.FTVatCode,'')  != '' THEN '1'
                                WHEN ISNULL(PSSAL.FTVatCode,'') != '' THEN '1'
                                WHEN ISNULL(VDSAL.FTVatCode,'') != '' THEN '1'
                            ELSE
                                '2'
                            END AS FTStaRef
                        FROM [TCNMVatRate] VAT WITH(NOLOCK)
                        LEFT JOIN TCNMComp COMP WITH(NOLOCK) ON VAT.FTVatCode = COMP.FTVatCode
                        LEFT JOIN (
                            SELECT DISTINCT FTVatCode FROM TCNMAgencySpc WITH(NOLOCK)
                        ) ASPC ON VAT.FTVatCode = ASPC.FTVatCode
                        LEFT JOIN (
                            SELECT DISTINCT FTVatCode FROM TPSTSalDT WITH(NOLOCK)
                        ) PSSAL ON VAT.FTVatCode = PSSAL.FTVatCode
                        LEFT JOIN (
                            SELECT DISTINCT FTVatCode FROM TVDTSalDT WITH(NOLOCK)
                        ) VDSAL ON VAT.FTVatCode = VDSAL.FTVatCode
                       WHERE 1=1";
        
        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            $tSQL .= " AND (VAT.FTVatCode LIKE '%$tSearchList%'";
            $tSQL .= " OR VAT.FCVatRate LIKE '%$tSearchList%')";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        // echo $tSQL;
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList      = $oQuery->result();
            $aFoundRow  = $this->FSaMVATGetPageAll($tSearchList);
            $nFoundRow  = $aFoundRow[0]->counts;
            $nPageAll   = ceil($nFoundRow/$paData['nRow']);
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => $nPageAll, 
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            //No Data
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /**
     * Functionality : All Page Of VatRate
     * Parameters : $ptSearchList is value for search
     * Creator : 13/06/2018 Wasin
     * Last Modified : -
     * Return : Vat rate record
     * Return Type : array
     */
    public function FSaMVATGetPageAll($ptSearchList){
        $tSQL = "SELECT  COUNT(DISTINCT(VAT.FTVatCode)) AS counts
                    FROM TCNMVatRate VAT
                    WHERE 1=1 ";
        if($ptSearchList != ''){
            $tSQL .= " AND (VAT.FTVatCode LIKE '%$ptSearchList%'";
            $tSQL .= " OR VAT.FCVatRate LIKE '%$ptSearchList%')";
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
     * Functionality : Function Chack Duplicate Date Vat
     * Parameters : $pdDateStart is for search by vat start
     * Creator : 18/06/2018 Wasin
     * Last Modified : -
     * Return : Vat rate record
     * Return Type : object
     */
    public function FSoMVATChkDup($pdDateStart){
        $tSQL = "SELECT COUNT(FTVatCode) AS counts
                    FROM TCNMVatRate
                    WHERE 1 = 1";
        if($pdDateStart != ""){
            $tSQL .= " AND FDVatStart = '$pdDateStart'";
        }
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }
}

