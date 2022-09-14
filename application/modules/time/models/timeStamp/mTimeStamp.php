<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mTimeStamp extends CI_Model {

    //Get History Checkin Checkout
    public function FSaMTsmGetHistoryCheckinCheckOut($pnUsercode){
        $ptLngID = $this->session->userdata("tLangID");

        $tSQL = "SELECT TOP 5 WT.FNWrtID , WT.FTWrtClockIn , WT.FTUsrCode , USRL.FTUsrName , WT.FDWrtDate , WT.FDWrtDateOut , 'IN' AS FTWrtType 
                FROM TCNTWorkTime WT
                LEFT JOIN [TCNMUser_L] USRL ON WT.FTUsrCode = USRL.FTUsrCode AND USRL.FNLngID = $ptLngID
                where WT.FTWrtClockIn != '' AND WT.FTUsrCode = $pnUsercode
                UNION
                SELECT TOP 5 WT.FNWrtID , WT.FTWrtClockOut , WT.FTUsrCode , USRL.FTUsrName , WT.FDWrtDate , WT.FDWrtDateOut , 'OUT' AS FTWrtType 
                FROM TCNTWorkTime WT 
                LEFT JOIN [TCNMUser_L] USRL ON WT.FTUsrCode = USRL.FTUsrCode AND USRL.FNLngID = $ptLngID
                where WT.FTWrtClockOut != '' AND WT.FTUsrCode = $pnUsercode 
                ORDER BY WT.FNWrtID DESC , WT.FTWrtClockIn DESC";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
        $oList = $oQuery->result();
        $aResult = array(
            'raItems'   => $oList,
            'rtCode'    => '1',
            'rtDesc'    => 'success',
        );
        }else{
        //No Data
        $aResult = array(
            'rtCode' => '800',
            'rtDesc' => 'data not found',
        );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Get Last Checkin Checkout
    public function FSaMTsmGetLastCheckinCheckOut(){
        $ptLngID = $this->session->userdata("tLangID");

        $tSQL = "SELECT TOP 5 ResultData.*
                FROM 
                (
                    SELECT DISTINCT MAIN.FTUsrCode,USRL.FTUsrName,IMGP.FTImgObj,
                        ( SELECT TOP 1 SUB.FNWrtID
                            FROM [TCNTWorkTime] AS SUB 
                            WHERE MAIN.FTUsrCode = SUB.FTUsrCode order by SUB.FNWrtID DESC ) as SUBS 
                    FROM [TCNTWorkTime] AS MAIN	
                
                    LEFT JOIN [TCNMUser_L] USRL ON MAIN.FTUsrCode = USRL.FTUsrCode AND USRL.FNLngID = $ptLngID 
                    LEFT JOIN [TCNMImgPerson] IMGP ON IMGP.FTImgRefID = MAIN.FTUsrCode		
                ) ResultData ORDER BY SUBS DESC";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
        $oList = $oQuery->result();
        $aResult = array(
            'raItems'   => $oList,
            'rtCode'    => '1',
            'rtDesc'    => 'success'
        );
        }else{
        //No Data
        $aResult = array(
            'rtCode' => '800',
            'rtDesc' => 'data not found',
        );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Insert Checkin
    public function FSaMTsmInsertCheckinCheckOut($aData){
        $tSql = "INSERT INTO TCNTWorkTime
            ([FTBchCode],[FTUsrCode],[FDWrtDate],[FTWrtClockIn],[FDWrtDateOut],[FTWrtClockOut],[FTWrtRemark],[FDCreateOn],[FTCreateBy])
        VALUES 
            (
             '".$aData['FTBchCode']."',
             '".$aData['FTUsrCode']."',
             '".$aData['FDWrtDate']."',
             '".$aData['FTWrtClockIn']."',
             '".$aData['FDWrtDateOut']."',
             '".$aData['FTWrtClockOut']."',
             '".$aData['FTWrtRemark']."',
             '".$aData['FDCreateOn']."',
             '".$aData['FTCreateBy']."'
            )";
        $this->db->query($tSql);
    }

    //Get Last ID FNWrtID
    public function FSaTsmGetIDLast($aData){
        $tSQL = "SELECT TOP 1 FNWrtID FROM TCNTWorkTime
        WHERE FTUsrCode = '".$aData['FTUsrCode']."' ORDER BY FNWrtID DESC ";
        $oQuery         = $this->db->query($tSQL);
        $oList          = $oQuery->result_array();
        return $oList;
    }

    //Update Checkout
    public function FSaMTsmUpdateCheckOut($aData,$pnSeq,$dCurrentDate){
        $tSQL = " UPDATE TCNTWorkTime SET ";
		$tSQL .= " FDWrtDateOut   = '".$aData['FDWrtDateOut']."' , ";
		$tSQL .= " FTWrtClockOut  = '".$aData['FTWrtClockOut']."' , ";
        $tSQL .= " FDLastUpdOn    = '".$aData['FDLastUpdOn']."' , ";
        $tSQL .= " FTLastUpdBy    = '".$aData['FTCreateBy']."' ";
        $tSQL .= " WHERE FNWrtID  = '".$pnSeq."' ";
        $tSQL .= " AND CONVERT(varchar(25), FDWrtDate,126) LIKE '".$dCurrentDate."%' ";
        $tSQL .= " AND FTUsrCode = '".$aData['FTUsrCode']."' ";
        $oQuery = $this->db->query($tSQL);
    }

    //Check : Username and Password
    public function FSaMTsmCheckUsernameandPassword($ptUsername,$ptPassword){
        $tSQL = "SELECT * FROM TCNMUser
        WHERE TCNMUser.FTUsrCode = '$ptUsername' AND TCNMUser.FTUsrPwd = '$ptPassword' ";
        $oQuery         = $this->db->query($tSQL);
        $oList          = $oQuery->result_array();
        return $oList;
    }

    //Check : Input จะมีแค่ 1 record ลงชื่อขาเข้าได้เเค่รอบเดียว 
    public function FSaMTsmCheckInputWithoutOutput($ptUsername,$ptCurrentDate){
        $tSQL = "SELECT TOP 1 FTWrtClockIn , FTWrtClockOut , FDWrtDate FROM TCNTWorkTime
        WHERE FTUsrCode = '$ptUsername' ORDER BY FNWrtID DESC  ";
        //AND CONVERT(varchar(25), FDWrtDate,126) LIKE '$ptCurrentDate%'
        $oQuery         = $this->db->query($tSQL);
        $oList          = $oQuery->result_array();
        return $oList;
    }

    //Get Datatable
    public function FSaMTsmGetDetailAll($paData){
        $aRowLen    = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FNWrtID DESC) AS rtRowID,* FROM
                (SELECT 
                        WT.FNWrtID,
                        WT.FTBchCode,
                        WT.FTUsrCode,
                        WT.FDWrtDate,
                        WT.FTWrtClockIn,
                        WT.FDWrtDateOut,
                        WT.FTWrtClockOut,
                        WT.FTWrtRemark,
                        BCHL.FTBchName,
                        USRL.FTUsrName
                FROM [TCNTWorkTime] WT
                LEFT JOIN [TCNMUser_L] USRL ON WT.FTUsrCode = USRL.FTUsrCode AND USRL.FNLngID = $nLngID 
                LEFT JOIN [TCNMBranch_L] BCHL ON WT.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                WHERE 1=1 ";

        $tSearchList = '';

        $ptDateCheckin                      = $paData['ptDateCheckin'];
        $ptDateCheckout                     = $paData['ptDateCheckout'];
        $ptBranch                           = $paData['ptBranch'];
        $ptUsername                         = $paData['ptUsername'];
        $ptTypeSearchCheckinorCheckout      = $paData['ptTypeSearchCheckinorCheckout'];

        //Condition Search
        if($ptUsername == '' && $ptBranch  != '' && $ptDateCheckin  == '' && $ptDateCheckout == ''){
            $tSQL .= "  AND ( BCHL.FTBchCode = '$ptBranch' ) ";
        }

        if($ptUsername != '' && $ptBranch  == '' && $ptDateCheckin  == '' && $ptDateCheckout == ''){
            $tSQL .= "  AND ( USRL.FTUsrName LIKE '%$ptUsername%' ) ";
        }

        if($ptUsername != '' && $ptBranch  != '' && $ptDateCheckin  == '' && $ptDateCheckout == ''){
            $tSQL .= "  AND ( BCHL.FTBchCode = '$ptBranch'  ";
            $tSQL .= "  AND USRL.FTUsrName LIKE '%$ptUsername%' ) ";
        }

        if($ptUsername == '' && $ptBranch  == '' && $ptDateCheckin  != '' && $ptDateCheckout != ''){
            if($ptTypeSearchCheckinorCheckout == 1){ //วันที่เข้า 
                $tSQL .= "  AND ( CONVERT(varchar(10), WT.FDWrtDate,121) BETWEEN '$ptDateCheckin'  ";
                $tSQL .= "  AND '$ptDateCheckout%' ) ";
            }else if($ptTypeSearchCheckinorCheckout  == 2){ //วันที่ออก
                $tSQL .= "  AND ( CONVERT(varchar(10), WT.FDWrtDateOut,121) BETWEEN '$ptDateCheckin'  ";
                $tSQL .= "  AND '$ptDateCheckout%' ) ";
            }
        }

        if($ptUsername != '' && $ptBranch  != '' && $ptDateCheckin  != '' && $ptDateCheckout != ''){
            $tSQL .= "  AND ( BCHL.FTBchCode = '$ptBranch'  ";
            $tSQL .= "  AND USRL.FTUsrName LIKE '%$ptUsername%' ";

            if($ptTypeSearchCheckinorCheckout == 1){ //วันที่เข้า 
                $tSQL .= "  AND CONVERT(varchar(10), WT.FDWrtDate,121) BETWEEN '$ptDateCheckin'  ";
                $tSQL .= "  AND '$ptDateCheckout%' ) ";
            }else if($ptTypeSearchCheckinorCheckout  == 2){ //วันที่ออก
                $tSQL .= "  AND CONVERT(varchar(10), WT.FDWrtDateOut,121) BETWEEN '$ptDateCheckin'  ";
                $tSQL .= "  AND '$ptDateCheckout%' ) ";
            }else{
                $tSQL .= " ) ";
            }
        }
        //End Condition

        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList      = $oQuery->result();
            $aFoundRow  = $this->FSnMTsmGetPageAll($tSearchList,$nLngID,$ptDateCheckin,$ptDateCheckout,$ptBranch,$ptUsername,$ptTypeSearchCheckinorCheckout);
            $nFoundRow  = $aFoundRow[0]->counts;
            $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => $nPageAll, 
                'rtCode'        => '1',
                'rtDesc'        => 'success',
                'tSQL'          => $tSQL
            );

        }else{
            //No Data
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
                'tSQL'          => $tSQL
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //count checkin and checkout
    public function FSnMTsmGetPageAll($ptSearchList,$ptLngID,$ptDateCheckin,$ptDateCheckout,$ptBranch,$ptUsername,$ptTypeSearchCheckinorCheckout){
        $tSQL = "SELECT COUNT (WT.FNWrtID) AS counts

                FROM [TCNTWorkTime] WT
                LEFT JOIN [TCNMUser_L] USRL ON WT.FTUsrCode = USRL.FTUsrCode AND USRL.FNLngID = $ptLngID 
                LEFT JOIN [TCNMBranch_L] BCHL ON WT.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $ptLngID
                WHERE 1=1 ";

        //Condition Search
        if($ptUsername == '' && $ptBranch  != '' && $ptDateCheckin  == '' && $ptDateCheckout == ''){
            $tSQL .= "  AND ( BCHL.FTBchCode = '$ptBranch' ) ";
        }

        if($ptUsername != '' && $ptBranch  == '' && $ptDateCheckin  == '' && $ptDateCheckout == ''){
            $tSQL .= "  AND ( USRL.FTUsrName LIKE '%$ptUsername%' ) ";
        }

        if($ptUsername != '' && $ptBranch  != '' && $ptDateCheckin  == '' && $ptDateCheckout == ''){
            $tSQL .= "  AND ( BCHL.FTBchCode = '$ptBranch'  ";
            $tSQL .= "  AND USRL.FTUsrName LIKE '%$ptUsername%' ) ";
        }

        if($ptUsername == '' && $ptBranch  == '' && $ptDateCheckin  != '' && $ptDateCheckout != ''){
            if($ptTypeSearchCheckinorCheckout == 1){ //วันที่เข้า 
                $tSQL .= "  AND ( CONVERT(varchar(10), WT.FDWrtDate,121) BETWEEN '$ptDateCheckin'  ";
                $tSQL .= "  AND '$ptDateCheckout%' ) ";
            }else if($ptTypeSearchCheckinorCheckout  == 2){ //วันที่ออก
                $tSQL .= "  AND ( CONVERT(varchar(10), WT.FDWrtDateOut,121) BETWEEN '$ptDateCheckin'  ";
                $tSQL .= "  AND '$ptDateCheckout%' ) ";
            }
        }

        if($ptUsername != '' && $ptBranch  != '' && $ptDateCheckin  != '' && $ptDateCheckout != ''){
            $tSQL .= "  AND ( BCHL.FTBchCode = '$ptBranch'  ";
            $tSQL .= "  AND USRL.FTUsrName LIKE '%$ptUsername%' ";

            if($ptTypeSearchCheckinorCheckout == 1){ //วันที่เข้า 
                $tSQL .= "  AND CONVERT(varchar(10), WT.FDWrtDate,121) BETWEEN '$ptDateCheckin'  ";
                $tSQL .= "  AND '$ptDateCheckout%' ) ";
            }else if($ptTypeSearchCheckinorCheckout  == 2){ //วันที่ออก
                $tSQL .= "  AND CONVERT(varchar(10), WT.FDWrtDateOut,121) BETWEEN '$ptDateCheckin'  ";
                $tSQL .= "  AND '$ptDateCheckout%' ) ";
            }else{
                $tSQL .= " ) ";
            }
        }
        //End Condition

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }

    //Update inline
    public function FSaMTsmUpdateinline($paData){
        $this->db->set('FDWrtDate'      , $paData['FDWrtDate']);
        $this->db->set('FTWrtClockIn'   , $paData['FTWrtClockIn']);
        $this->db->set('FTWrtClockOut'  , $paData['FTWrtClockOut']);
        $this->db->set('FDWrtDateOut'   , $paData['FDWrtDateOut']);
        $this->db->where('FNWrtID'      , $paData['FNWrtID']);
        $this->db->update('TCNTWorkTime');
    }

    //Get Bch
    public function FSaMTsmGetBchforUserCode($tUser){
        $tSQL = "SELECT FTBchCode FROM TCNTUsrGroup WHERE FTUsrCode = '$tUser' ";
        $oQuery         = $this->db->query($tSQL);
        $oList          = $oQuery->result_array();
        return $oList;
    }
}

