<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Loghistory_model extends CI_Model {

    public function FSaMLGHGetDataList($paData){
        $aRowLen            = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID             = $paData['FNLngID'];
        $aAdvanceSearch     = $paData['aAdvanceSearch'];
        
        $tSQL1  = "SELECT c.* FROM( SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC) AS FNRowID,* FROM ( ";
        $tSQL2  = " SELECT 
                        LGH.FTAgnCode,LGH.FTBchCode,BCHL.FTBchName,LGH.FTPosCode,POSL.FTPosName,LGH.FTLogType,
                        LGH.FDLogDateReq,LGH.FDLogFileDate,LGH.FTLogUrlFile,LGH.FTLogStatus,LGH.FTLogRmk,LGH.FDCreateOn
                    FROM TLGTFileHis LGH WITH(NOLOCK)
                    LEFT JOIN TCNMBranch_L BCHL WITH(NOLOCK) ON BCHL.FTBchCode = LGH.FTBchCode AND BCHL.FNLngID = ".$this->db->escape($nLngID)."
                    INNER JOIN TCNMPos POS WITH(NOLOCK) ON POS.FTBchCode = LGH.FTBchCode AND POS.FTPosCode = LGH.FTPosCode  
                    LEFT JOIN TCNMPos_L POSL WITH(NOLOCK) ON POSL.FTBchCode = POS.FTBchCode AND POSL.FTPosCode = POS.FTPosCode AND POSL.FNLngID = ".$this->db->escape($nLngID)."
                    WHERE LGH.FTBchCode != ''
        ";

        // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
        if ( $this->session->userdata('tSesUsrLevel') != "HQ" ) { 
            $tSesUsrBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL2 .= " AND LGH.FTBchCode IN ($tSesUsrBchCodeMulti) ";
        }

        // ค้นหาสาขา
        $tLGHBchCode = $aAdvanceSearch['tLGHBchCode'];
        if( isset($tLGHBchCode) && !empty($tLGHBchCode) ){
            $tSQL2 .= " AND LGH.FTBchCode = ".$this->db->escape($tLGHBchCode);
        }

        
        // ค้นหาประเภทจุดขาย
        $tLGHPosType = $aAdvanceSearch['tLGHPosType'];
        if( isset($tLGHPosType) && !empty($tLGHPosType) ){
            $tSQL2 .= " AND POS.FTPosType = ".$this->db->escape($tLGHPosType);
        }

        // ค้นหาเครื่องจุดขาย
        $tLGHPosCode = $aAdvanceSearch['tLGHPosCode'];
        if( isset($tLGHPosCode) && !empty($tLGHPosCode) ){
            $tSQL2 .= " AND LGH.FTPosCode = ".$this->db->escape($tLGHPosCode);
        }

        // ค้นหาประเภท
        $tLGHType = $aAdvanceSearch['tLGHType'];
        if( isset($tLGHType) && !empty($tLGHType) ){
            $tSQL2 .= " AND LGH.FTLogType = ".$this->db->escape($tLGHType);
        }

        // ค้นหาสถานะ
        $tLGHStatus = $aAdvanceSearch['tLGHStatus'];
        if( isset($tLGHStatus) && !empty($tLGHStatus) ){
            $tSQL2 .= " AND LGH.FTLogStatus = ".$this->db->escape($tLGHStatus);
        }

        $tLGHDocDateForm    = $aAdvanceSearch['tLGHDocDateForm'];
        $tLGHDocDateTo      = $aAdvanceSearch['tLGHDocDateTo'];

        if( empty($tLGHDocDateForm) && !empty($tLGHDocDateTo) ){
            $tLGHDocDateForm = $tLGHDocDateTo;
        }

        if( empty($tLGHDocDateTo) && !empty($tLGHDocDateForm) ){
            $tLGHDocDateTo = $tLGHDocDateForm;
        }

        if( isset($tLGHDocDateForm) && !empty($tLGHDocDateForm) && isset($tLGHDocDateTo) && !empty($tLGHDocDateTo) ){
            $tSQL2 .= " AND ( LGH.FDLogFileDate BETWEEN ".$this->db->escape($tLGHDocDateForm)." AND ".$this->db->escape($tLGHDocDateTo);
            $tSQL2 .= "    OR LGH.FDLogFileDate BETWEEN ".$this->db->escape($tLGHDocDateTo)."   AND ".$this->db->escape($tLGHDocDateForm)." ) ";
        }
        
        $tSQL3 =  " ) Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1] ";
        
        $tSQLMain   = $tSQL1.$tSQL2.$tSQL3;
        $oQueryMain = $this->db->query($tSQLMain);
        // echo $this->db->last_query();
        if( $oQueryMain->num_rows() > 0 ){
            $aDetail        = $oQueryMain->result_array();
            $tSQLPage       = $tSQL2;
            $oQueryPage     = $this->db->query($tSQLPage);
            $nFoundRow      = $oQueryPage->num_rows();
            $nPageAll       = ceil($nFoundRow/$paData['nRow']);

            $aResult = array(
                'aItems'        => $aDetail,
                'nAllRow'       => $nFoundRow,
                'nCurrentPage'  => $paData['nPage'],
                'nAllPage'      => $nPageAll,
                'tCode'         => '1',
                'tDesc'         => 'success',
            );
        }else{
            $aResult = array(
                'nAllRow'       => 0,
                'nCurrentPage'  => $paData['nPage'],
                "nAllPage"      => 0,
                'tCode'         => '800',
                'tDesc'         => 'Data not found.',
            );
        }
        return $aResult;
    }
}
?>