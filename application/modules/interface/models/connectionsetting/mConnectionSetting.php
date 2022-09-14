<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mConnectionSetting extends CI_Model {

    //Functionality : แสดงข้อมูล คลัง ข้างบน
    //Parameters : function parameters
    //Creator : 14/05/202020 saharat(Golf)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCCSListDataUP($paData){

                $tBchCodeMulti = $this->session->userdata("tSesUsrBchCodeMulti");
                $nLngID    = $paData['FNLngID'];
                $tSearchAllNotSet  = $paData['tSearchAllNotSet'];

                $tSQL  = " SELECT
                            ISNULL(AGN.FTAgnName,'N/A') AS FTAgnName
                            ,WH.FTBchCode
                            ,BCHL.FTBchName
                            ,WH.FTWahCode
                            ,WHL.FTWahName
                            ,FTWahStaType
                        FROM  TCNMWaHouse WH
                        INNER JOIN TCNMWaHouse_L WHL ON WH.FTBchCode = WHL.FTBchCode AND WH.FTWahCode = WHL.FTWahCode AND WHL.FNLngID = $nLngID
                        LEFT JOIN  TLKMWaHouse LKWH ON  WH.FTBchCode = LKWH.FTBchCode AND WH.FTWahCode = LKWH.FTWahCode
                        LEFT JOIN  TCNMBranch BCH   ON  WH.FTBchCode = BCH.FTBchCode AND WH.FTWahCode = BCH.FTWahCode
                        LEFT JOIN  TCNMBranch_L BCHL ON WH.FTBchCode = BCHL.FTBchCode  AND BCHL.FNLngID = $nLngID
                        LEFT JOIN  TCNMAgency_L AGN ON BCH.FTAgnCode = AGN.FTAgnCode AND AGN.FNLngID = $nLngID
                        WHERE ((WH.FTWahStaType = 1 AND WH.FTWahCode = '00001') OR WH.FTWahStaType = 2)
                        AND ISNULL(LKWH.FTWahCode,'') = ''
                        -- AND WH.FTBchCode IN($tBchCodeMulti)
                ";

                if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
                    $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
                    $tSQL .= " AND WH.FTBchCode IN ($tBchCode) ";
                }


                if(isset($tSearchAllNotSet) && !empty($tSearchAllNotSet)){
                    $tSQL .= " AND (WH.FTBchCode  LIKE '%$tSearchAllNotSet%'";
                    $tSQL .= " OR BCHL.FTBchName LIKE '%$tSearchAllNotSet%'";
                    $tSQL .= " OR WH.FTWahCode LIKE '%$tSearchAllNotSet%'";
                    $tSQL .= " OR WHL.FTWahName LIKE '%$tSearchAllNotSet%')";
                }

            $tSQL .= "ORDER BY WH.FTBchCode , WH.FTWahCode ASC";
            $oQuery = $this->db->query($tSQL);

            if($oQuery->num_rows() > 0){
                $oList = $oQuery->result();
                $aResult = array(
                    'raItems'       => $oList,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
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


    //Functionality : แสดงข้อมูล คลังข้างล่าง
    //Parameters : function parameters
    //Creator : 14/05/202020 saharat(Golf)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCCSListDataDown($paData){

        $tUsrAgnCode = $this->session->userdata("tSesUsrAgnCode");

        $tWhere = "";

        if(!empty($paData['tStaUsrLevel']) && $paData['tStaUsrLevel'] != "HQ"){
            if(!empty($paData['tUsrBchCode'])){
                $tUsrBchCode = $paData['tUsrBchCode'];
                $tWhere .=  " AND TWH.FTBchCode IN ($tUsrBchCode) ";
            }
        }

        $nLngID = $paData['FNLngID'];
        $tSearchAllSetUp  = $paData['tSearchAllSetUp'];

        $tSQL       = " SELECT
                            TWH.FTAgnCode,
                            TWH.FTBchCode,
                            TWH.FTShpCode,
                            SHPL.FTShpName,
                            TWH.FTWahCode,
                            TWH.FTWahRefNo,
                            TWH.FTWahStaChannel,
                            AGNL.FTAgnName,
                            TBL.FTBchName,
                            TWHL.FTWahName
                    FROM TLKMWaHouse TWH
                    LEFT JOIN TCNMAgency_L AGNL ON TWH.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID =  $nLngID
                    LEFT JOIN TCNMBranch_L TBL ON TWH.FTBchCode = TBL.FTBchCode AND TBL.FNLngID      =  $nLngID
                    LEFT JOIN TCNMShop_L SHPL ON TWH.FTBchCode = SHPL.FTBchCode AND TWH.FTShpCode = SHPL.FTShpCode AND SHPL.FNLngID      =  $nLngID
                    LEFT JOIN TCNMWaHouse_L TWHL ON TWH.FTWahCode = TWHL.FTWahCode AND TWH.FTBchCode = TWHL.FTBchCode
                    AND TWHL.FNLngID  =  $nLngID
                    WHERE 1=1
                    $tWhere ";

        if(isset($tSearchAllSetUp) && !empty($tSearchAllSetUp)){
            if($tSearchAllSetUp == 'Counter'){
                $tSQL .= "AND (TWH.FTWahStaChannel = 1) ";
            }else if($tSearchAllSetUp == 'Event'){
                $tSQL .= "AND (TWH.FTWahStaChannel = 2) ";
            }else if($tSearchAllSetUp == 'Vansale'){
                $tSQL .= "AND (TWH.FTWahStaChannel = 3) ";
            }else{
                $tSQL .= " AND (AGNL.FTAgnName  LIKE '%$tSearchAllSetUp%'";
                $tSQL .= " OR TBL.FTBchName LIKE '%$tSearchAllSetUp%'";
                $tSQL .= " OR TWH.FTWahCode LIKE '%$tSearchAllSetUp%'";
                $tSQL .= " OR TWHL.FTWahName LIKE '%$tSearchAllSetUp%'";
                $tSQL .= " OR TWH.FTWahRefNo LIKE '%$tSearchAllSetUp%')";
            }
        }

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aResult = array(
                'raItems'       => $oList,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            //No Data
            $aResult = array(
                'raItems'=>  '',
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }


    //Functionality : Update&insert connectionsetting
    //Parameters : function parameters
    //Creator : 15/05/2020 saharat(Golf)
    //Last Modified : -
    //Return : response
    //Return Type : Array
    public function FSaMCSSAddUpdateMaster($paData){
        try{
            //Update Master
            $this->db->set('FTWahRefNo' , $paData['FTWahRefNo']);
            $this->db->set('FTWahStaOnline' , $paData['FTWahStaOnline']);
            $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
            $this->db->set('FDCreateOn' , $paData['FDCreateOn']);
            $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
            $this->db->set('FTCreateBy' , $paData['FTCreateBy']);
            $this->db->where('FTAgnCode', $paData['FTAgnCode']);
            $this->db->where('FTBchCode', $paData['FTBchCode']);
            $this->db->where('FTShpCode', $paData['FTShpCode']);
            $this->db->where('FTWahCode', $paData['FTWahCode']);
            $this->db->update('TLKMWaHouse');

            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                //Add Master
                $this->db->insert('TLKMWaHouse',array(
                    'FTAgnCode'         => $paData['FTAgnCode'],
                    'FTBchCode'         => $paData['FTBchCode'],
                    'FTShpCode'         => $paData['FTShpCode'],
                    'FTWahCode'         => $paData['FTWahCode'],
                    'FTWahRefNo'        => $paData['FTWahRefNo'],
                    'FTWahStaOnline'   => $paData['FTWahStaOnline'],

                    'FDLastUpdOn'       => $paData['FDLastUpdOn'],
                    'FDCreateOn'        => $paData['FDCreateOn'],
                    'FTLastUpdBy'       => $paData['FTLastUpdBy'],
                    'FTCreateBy'        => $paData['FTCreateBy'],

                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Master Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    public function FSaMCUSAddUpdateMaster($paData){
        try{
            //Update Master
            $this->db->set('FTCbrSoldTo', $paData['FTCbrSoldTo']);
            $this->db->where('FTChnCode', $paData['FTChnCode']);
            $this->db->where('FTBchCode', $paData['FTBchCode']);
            $this->db->update('TLKMCstBch');

            if( $this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                //Add Master
                $this->db->insert('TLKMCstBch',array(
                    'FTCbrSoldTo'   => $paData['FTCbrSoldTo'],
                    'FTBchCode'     => $paData['FTBchCode'],
                    'FTChnCode'     => $paData['FTChnCode']
                ));
                if( $this->db->affected_rows() > 0 ){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Master Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }



    //Functionality : Search connectionsetting By ID
    //Parameters : function parameters
    //Creator : 15/05/2020 saharat(Golf)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCCGetDataDown($paData){
        $tMerCode   = $paData['FTAgnCode'];
        $tBchCode   = $paData['FTBchCode'];
        $tShpCode   = $paData['FTShpCode'];
        $tWahCode   = $paData['FTWahCode'];

        $nLngID     = $paData['FNLngID'];
        $tSQL       = " SELECT
                            TWH.FTAgnCode,
                            TWH.FTBchCode,
                            TWH.FTShpCode,
                            SHPL.FTShpName,
                            TWH.FTWahCode,
                            TWH.FTWahRefNo,
                            TWH.FTWahStaChannel,
                            AGNL.FTAgnName,
                            TBL.FTBchName,
                            TWHL.FTWahName,
                            TWH.FTWahStaOnline
                        FROM TLKMWaHouse TWH
                        LEFT JOIN TCNMAgency_L AGNL ON TWH.FTAgnCode = AGNL.FTAgnCode AND AGNL.FNLngID =  $nLngID
                        LEFT JOIN TCNMBranch_L TBL ON TWH.FTBchCode = TBL.FTBchCode AND TBL.FNLngID      =  $nLngID
                        LEFT JOIN TCNMShop_L SHPL ON TWH.FTBchCode = SHPL.FTBchCode AND TWH.FTShpCode = SHPL.FTShpCode AND SHPL.FNLngID      =  $nLngID
                        LEFT JOIN TCNMWaHouse_L TWHL ON TWH.FTWahCode = TWHL.FTWahCode AND TWH.FTBchCode = TWHL.FTBchCode
                        AND TWHL.FNLngID  =  $nLngID
                        WHERE 1=1 ";

        if($tMerCode!= ""){
            $tSQL .= "AND TWH.FTAgnCode = '$tMerCode'";
        }
        if($tBchCode!= ""){
            $tSQL .= "AND TWH.FTBchCode = '$tBchCode'";
        }
        if($tShpCode!= ""){
            $tSQL .= "AND TWH.FTShpCode = '$tShpCode'";
        }
        if($tWahCode!= ""){
            $tSQL .= "AND TWH.FTWahCode = '$tWahCode'";
        }
        $oQuery = $this->db->query($tSQL);


        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
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


    // function delete siggle
    // Create BY Witsarut 21/05/2020
    public function FSnMConnSetDel($paData){

        $this->db->where('FTAgnCode', $paData['FTAgnCode']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->where('FTShpCode', $paData['FTShpCode']);
        $this->db->where('FTWahCode', $paData['FTWahCode']);
        $this->db->delete('TLKMWaHouse');

        if($this->db->affected_rows() > 0){
            $aStatus  = array(
                'rtCode' => 1,
                'rtDesc' => 'success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }

        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }

    public function FSnMCusSetDel($paData){

        $this->db->where('FTCbrSoldTo', $paData['FTCbrSoldTo']);
        $this->db->where('FTBchCode', $paData['FTBchCode']);
        $this->db->delete('TLKMCstBch');

        if($this->db->affected_rows() > 0){
            $aStatus  = array(
                'rtCode' => 1,
                'rtDesc' => 'success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }

        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }


    //Functionality : Delete  Ads Multiple
    //Parameters : Ajax ()
    //Creator : 20/08/2019 Witsarut
    //Return : array Data Return Status Delete
    //Return Type : array
    public function FSaMConnDeleteMultiple($paDataDelete){

        $this->db->where_in('FTAgnCode' ,$paDataDelete['aDataAgnCode']);
        $this->db->where_in('FTBchCode' ,$paDataDelete['aDataBchCode']);
        $this->db->where_in('FTShpCode' ,$paDataDelete['aDataShpCode']);
        $this->db->where_in('FTWahCode' ,$paDataDelete['aDataWahCode']);
        $this->db->delete('TLKMWaHouse');

        if($this->db->affected_rows() > 0){
            //Success
            $aStatus   = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
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

    //Functionality : Delete  Ads Multiple
    //Parameters : Ajax ()
    //Creator : 20/08/2019 Witsarut
    //Return : array Data Return Status Delete
    //Return Type : array
    public function FSaMCusDeleteMultiple($paDataDelete){

        $this->db->where_in('FTCbrSoldTo' ,$paDataDelete['aDataCusCode']);
        $this->db->where_in('FTBchCode' ,$paDataDelete['aDataBchCode']);
        $this->db->delete('TLKMCstBch');

        if($this->db->affected_rows() > 0){
            //Success
            $aStatus   = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
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


    //Functionality : Get all row
    //Parameters : -
    //Creator : 04/07/2019 Witsarut (Bell)
    //Return : array result from db
    //Return Type : array
    public function FSnMLOCGetAllNumRow(){
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TLKMWaHouse";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

    public function FSaMCCSListDataCustomer($paData){
      $tKeyword = $paData['tKeyword'];
      $nLngID   = $paData['FNLngID'];
      $tSQL     = " SELECT 
                        TLKMCstBch.*,
                        TCNMBranch_L.FTBchName,
                        TCNMChannel_L.FTChnName
                    FROM TLKMCstBch WITH(NOLOCK)
                    INNER JOIN TCNMBranch_L WITH(NOLOCK) ON TLKMCstBch.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = $nLngID
                    LEFT JOIN TCNMChannel_L WITH(NOLOCK) ON TLKMCstBch.FTChnCode = TCNMChannel_L.FTChnCode AND TCNMChannel_L.FNLngID = $nLngID
                  ";
      if ( $tKeyword != "" ) {
        $tSQL  .= " WHERE (TLKMCstBch.FTBchCode     LIKE '%".$tKeyword."%' OR 
                           TCNMBranch_L.FTBchName   LIKE '%".$tKeyword."%' OR 
                           TLKMCstBch.FTCbrSoldTo   LIKE '%".$tKeyword."%' OR
                           TLKMCstBch.FTChnCode     LIKE '%".$tKeyword."%' OR
                           TCNMChannel_L.FTChnName  LIKE '%".$tKeyword."%' ) ";
      }
      $oQuery   = $this->db->query($tSQL);

      if($oQuery->num_rows() > 0){
          $oList = $oQuery->result();
          $aResult = array(
              'raItems'       => $oList,
              'rtCode'        => '1',
              'rtDesc'        => 'success',
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

    public function FSaMCCSListDataCustomerByid($paData){

      $tBchCode     = $paData["tBchCode"];
      $tCbrSoldTo   = $paData["tCbrSoldTo"];
      $tChnCode     = $paData["tChnCode"];
      $nLngID       = $paData['FNLngID'];

      $tSQL = " SELECT 
                    TLKMCstBch.*,
                    TCNMBranch_L.FTBchName,
                    TCNMChannel_L.FTChnName
                FROM TLKMCstBch WITH(NOLOCK)
                INNER JOIN TCNMBranch_L WITH(NOLOCK) ON TLKMCstBch.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = $nLngID
                LEFT JOIN TCNMChannel_L WITH(NOLOCK) ON TLKMCstBch.FTChnCode = TCNMChannel_L.FTChnCode AND TCNMChannel_L.FNLngID = $nLngID
                WHERE TLKMCstBch.FTBchCode = '$tBchCode' 
                  AND TLKMCstBch.FTCbrSoldTo = '$tCbrSoldTo' 
                  AND TLKMCstBch.FTChnCode = '$tChnCode' ";
      $oQuery = $this->db->query($tSQL);

      if($oQuery->num_rows() > 0){
          $oList = $oQuery->result();
          $aResult = array(
              'raItems'       => $oList,
              'rtCode'        => '1',
              'rtDesc'        => 'success',
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



    // public function FSaMCCSListDataCustomerSheach($paData)
    // {
    //   $tKeyword = $paData['tKeyword'];
    //   $nLngID    = $paData['FNLngID'];
    //   if ($tKeyword !="") {
    //     $tCondition = "TCNMBranch_L.FTBchCode LIKE '%".$tKeyword."%' OR TCNMBranch_L.FTBchName LIKE '%".$tKeyword."%'  OR TLKMCstBch.FTCbrSoldTo LIKE '%".$tKeyword."%'";
    //   }else {
    //     $tCondition = "1=1";
    //   }
    //   $tSQL = "SELECT TLKMCstBch.*,TCNMBranch_L.FTBchName FROM TLKMCstBch
    //   INNER JOIN  TCNMBranch_L  ON TLKMCstBch.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID ='$nLngID'
    //   WHERE $tCondition ";
    //   $oQuery = $this->db->query($tSQL);

    //   if($oQuery->num_rows() > 0){
    //       $oList = $oQuery->result();
    //       $aResult = array(
    //           'raItems'       => $oList,
    //           'rtCode'        => '1',
    //           'rtDesc'        => 'success',
    //       );
    //   }else{
    //       //No Data
    //       $aResult = array(
    //           'rtCode' => '800',
    //           'rtDesc' => 'data not found',
    //       );
    //   }
    //   $jResult = json_encode($aResult);
    //   $aResult = json_decode($jResult, true);
    //   return $aResult;
    // }

}
