<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Posspccat_modal extends CI_Model {
    public function __construct(){
        parent::__construct ();
        date_default_timezone_set("Asia/Bangkok");
    }

    // Create By : Napat(Jame) 05/05/2022
    public function FSaMPSCEventGetDataList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tSearchList    = $paData['tSearchAll'];
            $nLngID         = $paData['FNLngID'];
            
            $tBchCode       = $paData['tBchCode'];
            $tPosCode       = $paData['tPosCode'];
            $tShpCode       = $paData['tShpCode'];

            $tSQL1 = "  SELECT c.* FROM ( SELECT  ROW_NUMBER() OVER(ORDER BY FNCatSeq ASC) AS rtRowID,* FROM ( ";
            $tSQL2 = "      SELECT 
                                PSC.*,
                                C1L.FTCatName AS FTPdtCatName1,
                                C2L.FTCatName AS FTPdtCatName2,
                                C3L.FTCatName AS FTPdtCatName3,
                                C4L.FTCatName AS FTPdtCatName4,
                                C5L.FTCatName AS FTPdtCatName5,
                                PGPL.FTPgpName,
                                PTYL.FTPtyName,
                                PBNL.FTPbnName,
                                PMOL.FTPmoName,
                                TCGL.FTTcgName
                            FROM TCNMPosSpcCat PSC WITH(NOLOCK)
                            LEFT JOIN TCNMPdtCatInfo_L	C1L  WITH(NOLOCK) ON PSC.FTPdtCat1 = C1L.FTCatCode AND C1L.FNCatLevel = 1 AND C1L.FNLngID = $nLngID
                            LEFT JOIN TCNMPdtCatInfo_L	C2L  WITH(NOLOCK) ON PSC.FTPdtCat2 = C2L.FTCatCode AND C2L.FNCatLevel = 2 AND C2L.FNLngID = $nLngID
                            LEFT JOIN TCNMPdtCatInfo_L	C3L  WITH(NOLOCK) ON PSC.FTPdtCat3 = C3L.FTCatCode AND C3L.FNCatLevel = 3 AND C3L.FNLngID = $nLngID
                            LEFT JOIN TCNMPdtCatInfo_L	C4L  WITH(NOLOCK) ON PSC.FTPdtCat4 = C4L.FTCatCode AND C4L.FNCatLevel = 4 AND C4L.FNLngID = $nLngID
                            LEFT JOIN TCNMPdtCatInfo_L	C5L  WITH(NOLOCK) ON PSC.FTPdtCat5 = C5L.FTCatCode AND C5L.FNCatLevel = 5 AND C5L.FNLngID = $nLngID
                            LEFT JOIN TCNMPdtGrp_L		PGPL WITH(NOLOCK) ON PSC.FTPgpChain = PGPL.FTPgpChain AND PGPL.FNLngID = $nLngID
                            LEFT JOIN TCNMPdtType_L		PTYL WITH(NOLOCK) ON PSC.FTPtyCode = PTYL.FTPtyCode AND PTYL.FNLngID = $nLngID
                            LEFT JOIN TCNMPdtBrand_L	PBNL WITH(NOLOCK) ON PSC.FTPbnCode = PBNL.FTPbnCode AND PBNL.FNLngID = $nLngID
                            LEFT JOIN TCNMPdtModel_L	PMOL WITH(NOLOCK) ON PSC.FTPmoCode = PMOL.FTPmoCode AND PMOL.FNLngID = $nLngID
                            LEFT JOIN TCNMPdtTouchGrp_L	TCGL WITH(NOLOCK) ON PSC.FTTcgCode = TCGL.FTTcgCode AND TCGL.FNLngID = $nLngID
                            WHERE PSC.FTPosCode <> ''
                    ";

            if( isset($tBchCode) && !empty($tBchCode) ){
                $tSQL2 .= " AND PSC.FTBchCode = ".$this->db->escape($tBchCode);
            }

            if( isset($tPosCode) && !empty($tPosCode) ){
                $tSQL2 .= " AND PSC.FTPosCode = ".$this->db->escape($tPosCode);
            }

            if( isset($tShpCode) && !empty($tShpCode) ){
                $tSQL2 .= " AND PSC.FTShpCode = ".$this->db->escape($tShpCode);
            }

            if( isset($tSearchList) && !empty($tSearchList) ){
                $tSQL2 .= " AND ( ";

                $tSQL2 .= " C1L.FTCatName LIKE '%".$this->db->escape_like_str($tSearchList)."%' ";
                $tSQL2 .= " OR C2L.FTCatName LIKE '%".$this->db->escape_like_str($tSearchList)."%' ";
                $tSQL2 .= " OR C3L.FTCatName LIKE '%".$this->db->escape_like_str($tSearchList)."%' ";
                $tSQL2 .= " OR C4L.FTCatName LIKE '%".$this->db->escape_like_str($tSearchList)."%' ";
                $tSQL2 .= " OR C5L.FTCatName LIKE '%".$this->db->escape_like_str($tSearchList)."%' ";

                $tSQL2 .= " OR PGPL.FTPgpName LIKE '%".$this->db->escape_like_str($tSearchList)."%' ";
                $tSQL2 .= " OR PTYL.FTPtyName LIKE '%".$this->db->escape_like_str($tSearchList)."%' ";
                $tSQL2 .= " OR PBNL.FTPbnName LIKE '%".$this->db->escape_like_str($tSearchList)."%' ";
                $tSQL2 .= " OR PMOL.FTPmoName LIKE '%".$this->db->escape_like_str($tSearchList)."%' ";
                $tSQL2 .= " OR TCGL.FTTcgName LIKE '%".$this->db->escape_like_str($tSearchList)."%' ";

                $tSQL2 .= " )";
            }

            $tSQL3 = ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

            $tSQLMain = $tSQL1.$tSQL2.$tSQL3;
            $oQuery = $this->db->query($tSQLMain);
            // echo $this->db->last_query();exit;
            if( $oQuery->num_rows() > 0 ){
                $aList       = $oQuery->result_array();
                $oQueryCount = $this->db->query($tSQL2);
                $nFoundRow   = $oQueryCount->num_rows();
                $nPageAll    = ceil($nFoundRow/$paData['nRow']);
                $aResult     = array(
                    'aItems'        => $aList,
                    'nAllRow'       => $nFoundRow,
                    'nCurrentPage'  => $paData['nPage'],
                    'nAllPage'      => $nPageAll,
                    'tCode'         => '1',
                    'tDesc'         => 'success',
                );
            }else{
                //No Data
                $aResult = array(
                    'nAllRow'       => 0,
                    'nCurrentPage'  => $paData['nPage'],
                    "nAllPage"      => 0,
                    'tCode'         => '800',
                    'tDesc'         => 'data not found',
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Create By : Napat(Jame) 06/05/2022
    public function FSnMPSCEventGetNextSeq($paDataWhere){
        $tBchCode = $paDataWhere['FTBchCode'];
        $tPosCode = $paDataWhere['FTPosCode'];
        $tShpCode = $paDataWhere['FTShpCode'];

        $tSQL = " SELECT ISNULL(MAX(FNCatSeq),0) + 1 AS FNCatNextSeq FROM TCNMPosSpcCat WITH(NOLOCK) WHERE FTPosCode <> '' ";

        if( isset($tBchCode) && !empty($tBchCode) ){
            $tSQL .= " AND FTBchCode = ".$this->db->escape($tBchCode);
        }

        if( isset($tPosCode) && !empty($tPosCode) ){
            $tSQL .= " AND FTPosCode = ".$this->db->escape($tPosCode);
        }

        if( isset($tShpCode) && !empty($tShpCode) ){
            $tSQL .= " AND FTShpCode = ".$this->db->escape($tShpCode);
        }

        $oQuery = $this->db->query($tSQL);
        if( $oQuery->num_rows() > 0 ){
            $nNextSeq = $oQuery->row_array()['FNCatNextSeq'];
        }else{
            $nNextSeq = 1;
        }
        return $nNextSeq;
    }

    // Create By : Napat(Jame) 06/05/2022
    public function FSnMPSCEventCheckDuplicate($paDataAddEdit){

        $tBchCode = $paDataAddEdit['FTBchCode'];
        $tPosCode = $paDataAddEdit['FTPosCode'];
        $tShpCode = $paDataAddEdit['FTShpCode'];

        $tPdtCat1 = $paDataAddEdit['FTPdtCat1'];
        $tPdtCat2 = $paDataAddEdit['FTPdtCat2'];
        $tPdtCat3 = $paDataAddEdit['FTPdtCat3'];
        $tPdtCat4 = $paDataAddEdit['FTPdtCat4'];
        $tPdtCat5 = $paDataAddEdit['FTPdtCat5'];
        $tPgpChain = $paDataAddEdit['FTPgpChain'];
        $tPtyCode = $paDataAddEdit['FTPtyCode'];
        $tPbnCode = $paDataAddEdit['FTPbnCode'];
        $tPmoCode = $paDataAddEdit['FTPmoCode'];
        $tTcgCode = $paDataAddEdit['FTTcgCode'];

        $tSQL = "SELECT COUNT(FTPosCode) AS counts FROM TCNMPosSpcCat WITH(NOLOCK) WHERE FTPosCode <> '' ";

        if( isset($tBchCode) && !empty($tBchCode) ){
            $tSQL .= " AND FTBchCode = ".$this->db->escape($tBchCode);
        }
        if( isset($tPosCode) && !empty($tPosCode) ){
            $tSQL .= " AND FTPosCode = ".$this->db->escape($tPosCode);
        }
        if( isset($tShpCode) && !empty($tShpCode) ){
            $tSQL .= " AND FTShpCode = ".$this->db->escape($tShpCode);
        }

        if( isset($tPdtCat1) && !empty($tPdtCat1) ){
            $tSQL .= " AND FTPdtCat1 = ".$this->db->escape($tPdtCat1);
        }
        if( isset($tPdtCat2) && !empty($tPdtCat2) ){
            $tSQL .= " AND FTPdtCat2 = ".$this->db->escape($tPdtCat2);
        }
        if( isset($tPdtCat3) && !empty($tPdtCat3) ){
            $tSQL .= " AND FTPdtCat3 = ".$this->db->escape($tPdtCat3);
        }
        if( isset($tPdtCat4) && !empty($tPdtCat4) ){
            $tSQL .= " AND FTPdtCat4 = ".$this->db->escape($tPdtCat4);
        }
        if( isset($tPdtCat5) && !empty($tPdtCat5) ){
            $tSQL .= " AND FTPdtCat5 = ".$this->db->escape($tPdtCat5);
        }
        if( isset($tPgpChain) && !empty($tPgpChain) ){
            $tSQL .= " AND FTPgpChain = ".$this->db->escape($tPgpChain);
        }
        if( isset($tPtyCode) && !empty($tPtyCode) ){
            $tSQL .= " AND FTPtyCode = ".$this->db->escape($tPtyCode);
        }
        if( isset($tPbnCode) && !empty($tPbnCode) ){
            $tSQL .= " AND FTPbnCode = ".$this->db->escape($tPbnCode);
        }
        if( isset($tPmoCode) && !empty($tPmoCode) ){
            $tSQL .= " AND FTPmoCode = ".$this->db->escape($tPmoCode);
        }
        if( isset($tTcgCode) && !empty($tTcgCode) ){
            $tSQL .= " AND FTTcgCode = ".$this->db->escape($tTcgCode);
        }

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array()['counts'];
        }else{
            return 0;
        }
    }

    // Create By : Napat(Jame) 06/05/2022
    public function FSxMPSCEventAdd($paDataAddEdit){
        $this->db->insert('TCNMPosSpcCat',$paDataAddEdit);
    }

    // Create By : Napat(Jame) 06/05/2022
    public function FSnMPSCEventGetDataBySeq($aDataWhere){

        $tBchCode       = $aDataWhere['tBchCode'];
        $tPosCode       = $aDataWhere['tPosCode'];
        $tShpCode       = $aDataWhere['tShpCode'];
        $nCatSeq        = $aDataWhere['nCatSeq'];
        $nLngID         = $aDataWhere['FNLngID'];

        $tSQL = "   SELECT 
                        PSC.*,
                        C1L.FTCatName AS FTPdtCatName1,
                        C2L.FTCatName AS FTPdtCatName2,
                        C3L.FTCatName AS FTPdtCatName3,
                        C4L.FTCatName AS FTPdtCatName4,
                        C5L.FTCatName AS FTPdtCatName5,
                        PGPL.FTPgpName,
                        PTYL.FTPtyName,
                        PBNL.FTPbnName,
                        PMOL.FTPmoName,
                        TCGL.FTTcgName
                    FROM TCNMPosSpcCat PSC WITH(NOLOCK)
                    LEFT JOIN TCNMPdtCatInfo_L	C1L  WITH(NOLOCK) ON PSC.FTPdtCat1 = C1L.FTCatCode AND C1L.FNCatLevel = 1 AND C1L.FNLngID = $nLngID
                    LEFT JOIN TCNMPdtCatInfo_L	C2L  WITH(NOLOCK) ON PSC.FTPdtCat2 = C2L.FTCatCode AND C2L.FNCatLevel = 2 AND C2L.FNLngID = $nLngID
                    LEFT JOIN TCNMPdtCatInfo_L	C3L  WITH(NOLOCK) ON PSC.FTPdtCat3 = C3L.FTCatCode AND C3L.FNCatLevel = 3 AND C3L.FNLngID = $nLngID
                    LEFT JOIN TCNMPdtCatInfo_L	C4L  WITH(NOLOCK) ON PSC.FTPdtCat4 = C4L.FTCatCode AND C4L.FNCatLevel = 4 AND C4L.FNLngID = $nLngID
                    LEFT JOIN TCNMPdtCatInfo_L	C5L  WITH(NOLOCK) ON PSC.FTPdtCat5 = C5L.FTCatCode AND C5L.FNCatLevel = 5 AND C5L.FNLngID = $nLngID
                    LEFT JOIN TCNMPdtGrp_L		PGPL WITH(NOLOCK) ON PSC.FTPgpChain = PGPL.FTPgpChain AND PGPL.FNLngID = $nLngID
                    LEFT JOIN TCNMPdtType_L		PTYL WITH(NOLOCK) ON PSC.FTPtyCode = PTYL.FTPtyCode AND PTYL.FNLngID = $nLngID
                    LEFT JOIN TCNMPdtBrand_L	PBNL WITH(NOLOCK) ON PSC.FTPbnCode = PBNL.FTPbnCode AND PBNL.FNLngID = $nLngID
                    LEFT JOIN TCNMPdtModel_L	PMOL WITH(NOLOCK) ON PSC.FTPmoCode = PMOL.FTPmoCode AND PMOL.FNLngID = $nLngID
                    LEFT JOIN TCNMPdtTouchGrp_L	TCGL WITH(NOLOCK) ON PSC.FTTcgCode = TCGL.FTTcgCode AND TCGL.FNLngID = $nLngID
                    WHERE PSC.FTPosCode <> '' ";

        if( isset($tBchCode) && !empty($tBchCode) ){
            $tSQL .= " AND PSC.FTBchCode = ".$this->db->escape($tBchCode);
        }

        if( isset($tPosCode) && !empty($tPosCode) ){
            $tSQL .= " AND PSC.FTPosCode = ".$this->db->escape($tPosCode);
        }

        if( isset($tShpCode) && !empty($tShpCode) ){
            $tSQL .= " AND PSC.FTShpCode = ".$this->db->escape($tShpCode);
        }

        if( isset($nCatSeq) && !empty($nCatSeq) ){
            $tSQL .= " AND PSC.FNCatSeq = ".$this->db->escape($nCatSeq);
        }

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aResult     = array(
                'aItems'        => $oQuery->row_array(),
                'tCode'         => '1',
                'tDesc'         => 'Found Data',
            );
        }else{
            $aResult     = array(
                'aItems'        => array(),
                'tCode'         => '900',
                'tDesc'         => 'Not Found Data',
            );
        }
        return $aResult;
    }
    
    // Create By : Napat(Jame) 09/05/2022
    public function FSxMPSCEventEdit($paDataWhere,$paDataAddEdit){

        $tBchCode       = $paDataWhere['FTBchCode'];
        $tPosCode       = $paDataWhere['FTPosCode'];
        $tShpCode       = $paDataWhere['FTShpCode'];
        $nCatSeq        = $paDataWhere['FNCatSeq'];

        if( isset($tBchCode) && !empty($tBchCode) ){
            $this->db->where('FTBchCode', $tBchCode);
        }

        if( isset($tPosCode) && !empty($tPosCode) ){
            $this->db->where('FTPosCode', $tPosCode);
        }

        if( isset($tShpCode) && !empty($tShpCode) ){
            $this->db->where('FTShpCode', $tShpCode);
        }

        if( isset($nCatSeq) && !empty($nCatSeq) ){
            $this->db->where('FNCatSeq', $nCatSeq);
        }

        $this->db->update('TCNMPosSpcCat',$paDataAddEdit);
    }

    // Create By : Napat(Jame) 09/05/2022
    public function FSxMPSCEventDelete($paDataWhere){

        $tBchCode       = $paDataWhere['FTBchCode'];
        $tPosCode       = $paDataWhere['FTPosCode'];
        $tShpCode       = $paDataWhere['FTShpCode'];
        $aCatSeq        = $paDataWhere['FNCatSeq'];
        $tWhereCond1    = "";
        $tWhereCond2    = "";

        if( isset($tBchCode) && !empty($tBchCode) ){
            $this->db->where('FTBchCode', $tBchCode);
            $tWhereCond1 .= " AND FTBchCode = ".$this->db->escape($tBchCode)." ";
            $tWhereCond2 .= " AND PSC.FTBchCode = ".$this->db->escape($tBchCode)." ";
        }

        if( isset($tPosCode) && !empty($tPosCode) ){
            $this->db->where('FTPosCode', $tPosCode);
            $tWhereCond1 .= " AND FTPosCode = ".$this->db->escape($tPosCode)." ";
            $tWhereCond2 .= " AND PSC.FTPosCode = ".$this->db->escape($tPosCode)." ";
        }

        if( isset($tShpCode) && !empty($tShpCode) ){
            $this->db->where('FTShpCode', $tShpCode);
            $tWhereCond1 .= " AND FTShpCode = ".$this->db->escape($tShpCode)." ";
            $tWhereCond2 .= " AND PSC.FTShpCode = ".$this->db->escape($tShpCode)." ";
        }

        if( isset($aCatSeq) && !empty($aCatSeq) ){
            $this->db->where_in('FNCatSeq', $aCatSeq);
        }

        $this->db->delete('TCNMPosSpcCat');


        // อัพเดท ลำดับใหม่ทุกครั้งที่ลบข้อมูล
        $tSQL = "   UPDATE PSC
                    SET PSC.FNCatSeq = NEW.FNNewCatSeq
                    FROM TCNMPosSpcCat PSC WITH(NOLOCK)
                    LEFT JOIN (
                        SELECT 
                            FTBchCode,
                            FTPosCode,
                            FTShpCode,
                            FNCatSeq,
                            ROW_NUMBER() OVER(ORDER BY FNCatSeq ASC) AS FNNewCatSeq
                        FROM TCNMPosSpcCat WITH(NOLOCK)
                        WHERE FTPosCode <> '' $tWhereCond1
                    ) AS NEW ON NEW.FTBchCode = PSC.FTBchCode AND NEW.FTPosCode = PSC.FTPosCode AND NEW.FTShpCode = PSC.FTShpCode AND NEW.FNCatSeq = PSC.FNCatSeq
                    WHERE PSC.FTPosCode <> '' $tWhereCond2
                ";
        $this->db->query($tSQL);

    }

    public function FSxMPSCEventUpdMasPos($paDataWhere,$paDataAddEdit){
        $this->db->where('FTBchCode', $paDataWhere['FTBchCode']);
        $this->db->where('FTPosCode', $paDataWhere['FTPosCode']);
        $this->db->set('FDLastUpdOn', $paDataAddEdit['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy', $paDataAddEdit['FTLastUpdBy']);
        $this->db->update('TCNMPos');
    }

}
