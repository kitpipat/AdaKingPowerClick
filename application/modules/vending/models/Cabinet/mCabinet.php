<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCabinet extends CI_Model {

    //Get Datatable
    public function FSaMVDCDataList($paData){
        $aRowLen                = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $tCabinetShpCode        = $paData['tCabinetShpCode'];
        $nLngID                 = $this->session->userdata("tLangEdit");
        $tSQL       = "SELECT c.* FROM(
                    SELECT  ROW_NUMBER() OVER(ORDER BY FNCabSeq DESC) AS rtRowID,* FROM
                        (SELECT
                            SCB.FTBchCode ,
                            SCB.FTShpCode ,
                            SCB.FNCabSeq ,
                            SCB.FNCabMaxRow ,
                            SCB.FNCabMaxCol ,
                            -- SCB.FNCabType ,
                            SCB.FTShtCode ,
                            SCB.FDLastUpdOn ,
                            SCB.FTLastUpdBy ,
                            SCB.FDCreateOn ,
                            SCB.FTCreateBy ,
                            SPT.FTShtName ,
                            CabinetL.FTCabName ,
                            CabinetL.FTCabRmk
                        FROM [TVDMShopCabinet] SCB WITH(NOLOCK)
                        LEFT JOIN  [TVDMShopType_L] SPT ON SCB.FTShtCode = SPT.FTShtCode AND SPT.FNLngID = $nLngID
                        LEFT JOIN  [TVDMShopCabinet_L] CabinetL ON  CabinetL.FTBchCode = SCB.FTBchCode AND CabinetL.FTShpCode = SCB.FTShpCode AND SCB.FNCabSeq = CabinetL.FNCabSeq AND CabinetL.FNLngID = $nLngID 
                        WHERE 1=1 ";
        
        $tSQL .= " AND (SCB.FTShpCode ='$tCabinetShpCode')";
        $tSQL .= " AND (SCB.FTBchCode = '".$paData['tCabinetBchCode']."' )";
        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            $tSQL .= " AND (SPT.FTShtName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR SCB.FNCabSeq LIKE '%$tSearchList%' ";
            $tSQL .= " OR SCB.FNCabMaxRow LIKE '%$tSearchList%' ";
            $tSQL .= " OR CabinetL.FTCabName LIKE '%$tSearchList%' ";
            $tSQL .= " OR SCB.FNCabMaxCol LIKE '%$tSearchList%' )";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList      = $oQuery->result();
            $aFoundRow  = $this->FSnMCabinetGetPageAll($tSearchList,$tCabinetShpCode,$paData['tCabinetBchCode']);
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
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        }else{
            //No Data
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        }
        return $aResult;
    }

    //Count Page
    public function FSnMCabinetGetPageAll($ptSearchList,$tCabinetShpCode,$tBCH){
        $nLngID  = $this->session->userdata("tLangEdit");
        $tSQL = "SELECT COUNT (SCB.FTBchCode) AS counts
                 FROM TVDMShopCabinet SCB WITH(NOLOCK)
                 LEFT JOIN  [TVDMShopType_L] SPT ON SCB.FTShtCode = SPT.FTShtCode AND SPT.FNLngID = $nLngID
                 LEFT JOIN  [TVDMShopCabinet_L] CabinetL ON CabinetL.FTBchCode = SCB.FTBchCode AND CabinetL.FTShpCode = SCB.FTShpCode AND SCB.FNCabSeq = CabinetL.FNCabSeq AND CabinetL.FNLngID = $nLngID 
                 WHERE 1=1 ";

        $tSQL .= " AND (SCB.FTShpCode = '$tCabinetShpCode')";
        $tSQL .= " AND (SCB.FTBchCode = '".$tBCH."' )";
        
        if($ptSearchList != ''){
            $tSQL .= " AND (SPT.FTShtName COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= " OR SCB.FNCabSeq LIKE '%$ptSearchList%' ";
            $tSQL .= " OR SCB.FNCabMaxRow LIKE '%$ptSearchList%' ";
            $tSQL .= " OR CabinetL.FTCabName LIKE '%$ptSearchList%' ";
            $tSQL .= " OR SCB.FNCabMaxCol LIKE '%$ptSearchList%' )";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //Get Name Table 
    public function FSaMVDCGetNameShop($nCodeShop,$tBCHCode){
        $tSQL  = "SELECT DISTINCT FTShpName FROM TCNMShop_L WITH(NOLOCK) WHERE 1=1 ";
        $tSQL .= " AND FTShpCode = '$nCodeShop' AND FTBchCode = '$tBCHCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //Get Data By ID
    public function FSaMVDCGetDataByID($pnShop,$pnBCH,$pnSeq){
        $nLngID     = $this->session->userdata("tLangEdit");
        $tSQL       = "SELECT 
                        SCB.FTBchCode ,
                        SCB.FTShpCode ,
                        SCB.FNCabSeq ,
                        SCB.FNCabMaxRow ,
                        SCB.FNCabMaxCol ,
                        -- SCB.FNCabType ,
                        SCB.FTShtCode ,
                        SCB.FDLastUpdOn ,
                        SCB.FTLastUpdBy ,
                        SCB.FDCreateOn ,
                        SCB.FTCreateBy ,
                        /*SCB.FNCabShwRow,
                        SCB.FNCabShwCol,*/
                        SPT.FTShtName ,
                        CabinetL.FTCabName ,
                        CabinetL.FTCabRmk   
                    FROM [TVDMShopCabinet] SCB WITH(NOLOCK)
                    LEFT JOIN  [TVDMShopType_L] SPT ON SCB.FTShtCode = SPT.FTShtCode AND SPT.FNLngID = $nLngID
                    LEFT JOIN  [TVDMShopCabinet_L] CabinetL ON SCB.FTBchCode = CabinetL.FTBchCode AND CabinetL.FTShpCode = SCB.FTShpCode AND SCB.FNCabSeq = CabinetL.FNCabSeq AND CabinetL.FNLngID = $nLngID 
                    WHERE 1=1 ";
        $tSQL .= " AND (SCB.FTShpCode = '$pnShop')";
        $tSQL .= " AND (SCB.FTBchCode = '$pnBCH')";
        $tSQL .= " AND (SCB.FNCabSeq = '$pnSeq')";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList      = $oQuery->result();
            $aResult    = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        }else{
            $aResult = array(
                'raItems'       => '',
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
        }
        return $aResult;
    }

    //Run Seq Cabinet
    public function FSaMVDCRunSeqByShop($nCodeShop,$tBCHCode){
        $tSQL  = "SELECT TOP 1 FNCabSeq FROM TVDMShopCabinet WITH(NOLOCK) WHERE 1=1 ";
        $tSQL .= " AND FTShpCode = '$nCodeShop' AND FTBchCode = '$tBCHCode' ORDER BY FNCabSeq DESC ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            return false;
        }
    }

    //Insert Cabinet
    public function FSaMVDCInsertCabinet($paPackData){
       
        $this->db->insert('TVDMShopCabinet',array(
            'FTBchCode'     => $paPackData['FTBchCode'],
            'FTShpCode'     => $paPackData['FTShpCode'],
            'FNCabSeq'      => $paPackData['FNCabSeq'],
            'FNCabMaxRow'   => $paPackData['FNCabMaxRow'],
            'FNCabMaxCol'   => $paPackData['FNCabMaxCol'],
            // 'FNCabType'     => $paPackData['FNCabType'],
            'FTShtCode'     => $paPackData['FTShtCode'],
            'FDLastUpdOn'   => $paPackData['FDLastUpdOn'],
            'FTLastUpdBy'   => $paPackData['FTLastUpdBy'],
            'FDCreateOn'    => $paPackData['FDCreateOn'],
            'FTCreateBy'    => $paPackData['FTCreateBy'],
            // 'FNCabShwRow'   => $paPackData['FNCabShwRow'],
            // 'FNCabShwCol'   => $paPackData['FNCabShwCol'],
        ));

        $this->db->insert('TVDMShopCabinet_L',array(
            'FTShpCode'     => $paPackData['FTShpCode'],
            'FTBchCode'     => $paPackData['FTBchCode'],
            'FNCabSeq'      => $paPackData['FNCabSeq'],
            'FNLngID'       => $paPackData['FNLngID'],
            'FTCabName'     => $paPackData['FTCabName'],
            'FTCabRmk'      => $paPackData['FTCabRmk']  
        ));

        if($this->db->affected_rows() > 0 ){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Insert Success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Insert Master.',
            );
        }
        return $aStatus;
    }

    //Update Cabinet
    public function FSaMVDCUpdateCabinet($paPackData){
		$this->db->set('FNCabMaxRow'    , $paPackData['FNCabMaxRow']);
		$this->db->set('FNCabMaxCol'    , $paPackData['FNCabMaxCol']);
		// $this->db->set('FNCabType'      , $paPackData['FNCabType']);
        $this->db->set('FTShtCode'      , $paPackData['FTShtCode']);
		$this->db->set('FDLastUpdOn'    , $paPackData['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy'    , $paPackData['FTLastUpdBy']);
        // $this->db->set('FNCabShwRow'    , $paPackData['FNCabShwRow']);
        // $this->db->set('FNCabShwCol'    , $paPackData['FNCabShwCol']);
		$this->db->where('FNCabSeq'     , $paPackData['FNCabSeq']);
        $this->db->where('FTShpCode'    , $paPackData['FTShpCode']);
        $this->db->where('FTBchCode'    , $paPackData['FTBchCode']);
        $this->db->update('TVDMShopCabinet');

        $this->db->set('FTCabName'      , $paPackData['FTCabName']);
        $this->db->set('FTCabRmk'       , $paPackData['FTCabRmk']);
        $this->db->set('FNLngID'        , $paPackData['FNLngID']);
        $this->db->where('FNCabSeq'     , $paPackData['FNCabSeq']);
        $this->db->where('FTShpCode'    , $paPackData['FTShpCode']);
        $this->db->where('FTBchCode'    , $paPackData['FTBchCode']);
        $this->db->update('TVDMShopCabinet_L');

		if($this->db->affected_rows() > 0) {
			$aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update success'
			);
		}else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Update Master.',
            );
        }
        return $aStatus;
    }

    //Delete Cabinet
    public function FSaMVDCDeleteCabinet($paPackData){
        $nSeq = explode(',',$paPackData['FNCabSeq']);

        $this->db->where_in('FTShpCode',$paPackData['FTShpCode']);
        $this->db->where_in('FNCabSeq',$nSeq);
        $this->db->where_in('FTBchCode',$paPackData['FTBchCode']);
        $this->db->delete('TVDMShopCabinet');

        $this->db->where_in('FTShpCode',$paPackData['FTShpCode']);
        $this->db->where_in('FTBchCode',$paPackData['FTBchCode']);
        $this->db->where_in('FNCabSeq',$nSeq);
        $this->db->delete('TVDMShopCabinet_L');

		if($this->db->affected_rows() > 0) {
			$aStatus = array(
					'rtCode' => '1',
					'rtDesc' => 'success',
			);
			$jStatus = json_encode($aStatus);
			$aStatus = json_decode($jStatus, true);
	
		} else {
			$aStatus = array(
					'rtCode' => '905',
					'rtDesc' => 'cannot Delete Item.',
			);
			$jStatus = json_encode($aStatus);
			$aStatus = json_decode($jStatus, true);
		}
		return $aStatus;
    }
}