<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nation_model extends CI_Model
{

    // LastUpdate By : Napat(Jame) 15/03/2022
    public function FSaMNATList($paData)
    {
        $aRowLen = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID = $paData['FNLngID'];

        $tSQL1 = "  SELECT c.* FROM ( SELECT  ROW_NUMBER() OVER(ORDER BY rtFDCreateOn DESC, rtNatCode DESC) AS rtRowID,* FROM ( ";
        $tSQL2 = "      SELECT DISTINCT
                            NAT.FTNatCode   AS rtNatCode,
                            NATL.FTNatName  AS rtNatName,
                            NAT.FDCreateOn  AS rtFDCreateOn
                        FROM TCNMNation NAT WITH(NOLOCK)
                        LEFT JOIN TCNMNation_L NATL WITH(NOLOCK) ON NAT.FTNatCode = NATL.FTNatCode AND NATL.FNLngID = $nLngID
                        WHERE NAT.FTNatCode <> '' ";

        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != '') {
            $tSQL2 .= " AND (NAT.FTNatCode COLLATE THAI_BIN LIKE '%$tSearchList%' ";
            $tSQL2 .= " OR NATL.FTNatName COLLATE THAI_BIN LIKE '%$tSearchList%')";
        }
        $tSQL3 = " ) Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";

        $tSQLMain = $tSQL1.$tSQL2.$tSQL3;
        $oQuery = $this->db->query($tSQLMain);
        if ($oQuery->num_rows() > 0) {
            $oQueryCount    = $this->db->query($tSQL2);
            $nFoundRow      = $oQueryCount->num_rows();
            $nPageAll       = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult        = array(
                'raItems'       => $oQuery->result(),
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        } else {
            //No Data
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        }

        return $aResult;
    }

}
