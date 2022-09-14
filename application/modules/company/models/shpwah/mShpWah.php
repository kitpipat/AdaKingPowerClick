<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mShpWah extends CI_Model {
    /**
     * Functionality: Function List  TCNMShpWah
     * Parameters:  From Ajax File ShpWah
     * Creator: 22/07/2019 Witsarut
     * LastUpdate: -
     * Return:  String View
     * ReturnType: View
    */
    public function FSaMShpWahDataList($paData){
        try{
            $tBchCode      = $paData['FTBchCode'];
            $tShopCode      = $paData['FTShpCode'];
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID       = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];

            $tSQL    = " SELECT c.* FROM(SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , FTBchCode DESC) AS rtRowID,*
                            FROM(
                                SELECT 	
                                    SHPWAH.FTBchCode,
                                    SHPWAH.FTShpCode,
                                    SHPWAH.FTWahCode,
                                    SHPWAH.FDCreateOn,
                                    WAH_L.FTWahName
                                FROM [TCNMShpWah] SHPWAH WITH(NOLOCK)
                                LEFT JOIN [TCNMWaHouse_L]  WAH_L ON SHPWAH.FTWahCode = WAH_L.FTWahCode AND SHPWAH.FTBchCode = WAH_L.FTBchCode AND WAH_L.FNLngID = $nLngID 
                                WHERE 1=1
                            AND SHPWAH.FTShpCode  = '$tShopCode'
                            AND SHPWAH.FTBchCode  = '$tBchCode' 
            ";
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

            $oQuery = $this->db->query($tSQL);

            if($oQuery->num_rows() > 0){
                $aList      = $oQuery->result_array();
                $oFoundRow  = $this->FSoMSHPWAHGetPageAll($tSearchList,$paData);
                $nFoundRow  = $oFoundRow[0]->counts;
                $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult    = array(
                    'raItems'       => $aList,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paData['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success'
                );
            }else{
                  //No Data
                  $aResult = array(
                    'rnAllRow'      => 0,
                    'rnCurrentPage' => $paData['nPage'],
                    "rnAllPage"     => 0,
                    'rtCode'        => '800',
                    'rtDesc'        => 'data not found'
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    /**
     * Functionality: Function Count ShpWah
     * Parameters:  From Ajax File 
     * Creator: 22/07/2019 Witsarut
     * LastUpdate: -
     * Return:  String View
     * ReturnType: View
    */
    public function FSoMSHPWAHGetPageAll($ptSearchList,$paData){
        try{

            $tShopCode      = $paData['FTShpCode'];
            $tBchCode       = $paData['FTBchCode'];
            $tSQL       = " SELECT
                        COUNT (SHPWAH.FTBchCode) AS counts
                    FROM [TCNMShpWah] SHPWAH WITH(NOLOCK)
                    WHERE 1=1
                    AND SHPWAH.FTBchCode  = '$tBchCode' 
                    AND SHPWAH.FTShpCode    = '$tShopCode'
            ";

            $oQuery  = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            }else{
                return false;
            }
        }catch(Exception $Error){
            echo $Error;
        }
    }

    /**
     * Functionality: Checkduplicate Data
     * Parameters:  From Ajax File 
     * Creator: 22/07/2019 Witsarut
     * LastUpdate: -
     * Return:  String View
     * ReturnType: View
    */
    public function FSaMShpWahCheckCode($paData){

        $tBchCode       = $paData['FTBchCode'];
        $tShpCode       = $paData['FTShpCode'];
        $tWahCode       = $paData['FTWahCode'];

        $tSQL = "SELECT 
                    SHPWAH.FTBchCode,
                    SHPWAH.FTShpCode,
                    SHPWAH.FTWahCode
                FROM [TCNMShpWah] SHPWAH WITH(NOLOCK)
                WHERE 1=1
                AND SHPWAH.FTShpCode = '$tShpCode'
                AND SHPWAH.FTWahCode = '$tWahCode'
                AND SHPWAH.FTBchCode = '$tBchCode'
        ";
        $oQuery = $this->db->query($tSQL);
    
        if($oQuery->num_rows() > 0){
            $oDetail    = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //if data not found
            $aResult    = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;

    } 

     /**
     * Functionality: Add Update Data
     * Parameters:  From Ajax File 
     * Creator: 22/07/2019 Witsarut
     * LastUpdate: -
     * Return:  String View
     * ReturnType: View
    */
    public function FSaMRShpWahAddMaster($paData){
        $aResult = array(
            'FTBchCode'     => $paData['FTBchCode'],
            'FTShpCode'     => $paData['FTShpCode'],
            'FTWahCode'     => $paData['FTWahCode'],
            'FDLastUpdOn'   => $paData['FDLastUpdOn'],
            'FTLastUpdBy'   => $paData['FTLastUpdBy'],
            'FDCreateOn'    => $paData['FDCreateOn'],
            'FTCreateBy'    => $paData['FTCreateBy']
        );
        $this->db->insert('TCNMShpWah',$aResult);
        return;
    }

    //Functionality : Delete 
    //Parameters : function parameters
    //Creator : 04/07/2019 Witsarut (Bell)
    //Return : response
    //Return Type : array
    public function FSnMUShpWahDel($paData){

        $this->db->where_in('FTShpCode', $paData['FTShpCode']);
        $this->db->where_in('FTWahCode', $paData['FTWahCode']);
        $this->db->where_in('FTBchCode', $paData['FTBchCode']);
        $this->db->delete('TCNMShpWah');
        if($this->db->affected_rows() > 0){
            //Success
            $aStatus = array(
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



    //Functionality : Delete Mutiple Object
    //Parameters : function parameters
    //Creator : 26/07/2019 Witsarut
    //Return : data
    //Return Type : Arra
    public function FSaMShpWahDeleteMultiple($paData){

        $this->db->where_in('FTBchCode', $paData['tBchCode']);
        $this->db->where_in('FTShpCode', $paData['tShpCode']);
        $this->db->where_in('FTWahCode', $paData['tWahCode']);
        $this->db->delete('TCNMShpWah');
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
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNMShpWah";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        }else{
            $aResult = false;
        }
        return $aResult;
    }

     //เดียวจะวิ่งไปเช็คก่อนว่าในร้านค้า นั้น มี wah หรือยัง ถ้ายังไม่มีต้องเอาไป update
    public function FSaMRShpWahCheckWahCodeINShop($ptType,$paData){
        if($ptType == 'ADD'){
            $tBCH       = $paData['FTBchCode'];
            $tSHP       = $paData['FTShpCode'];
            $tWAH       = $paData['FTWahCode'];
            $tSQL       = "SELECT FTWahCode FROM TCNMShop WHERE FTShpCode = '$tSHP' ";
            $oQuery     = $this->db->query($tSQL);
            $tWahCode   = $oQuery->row_array()["FTWahCode"];
            if ($tWahCode != '' || $tWahCode != null){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Have Wah',
                );
            }else{
                $this->db->set('FTWahCode', $tWAH);
                $this->db->where('FTShpCode', $tSHP);
                $this->db->update('TCNMShop');
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update Master Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }
        }else if($ptType == 'DEL'){
            $tBCH       = $paData['FTBchCode'];
            $tSHP       = $paData['FTShpCode'];
            $tWAH       = $paData['FTWahCode'];
            $tSQL       = "SELECT FTWahCode FROM TCNMShop WHERE FTShpCode = '$tSHP' ";
            $oQuery     = $this->db->query($tSQL);
            $tWahCode   = $oQuery->row_array()["FTWahCode"];

            if($tWahCode == $tWAH){
                $tSQL       = "SELECT TOP 1 FTWahCode FROM TCNMShpWah WHERE FTShpCode = '$tSHP' ORDER BY FTWahCode ASC";
                $oQuery     = $this->db->query($tSQL);
                $tWahCodeNew   = $oQuery->row_array()["FTWahCode"];

           
                if ($tWahCodeNew != '' || $tWahCodeNew != null){
                    //ลบตัวมันเอง
                    $this->db->set('FTWahCode', $tWahCodeNew);
                    $this->db->where('FTShpCode', $tSHP);
                    $this->db->update('TCNMShop');
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update wah new',
                    );
                }else{
                    //ลบจนไม่เหลือรายการเเล้ว
                    $this->db->set('FTWahCode', '');
                    $this->db->where('FTShpCode', $tSHP);
                    $this->db->update('TCNMShop');
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Update null',
                    );
                }
            }else{
                //ไม่ต้องทำอะไร เพราะ ค่า wah นั้นยังไม่ถูกลบ
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Not Update',
                );
            }
        }else if($ptType == 'DELMULTI'){
            $tBCH       = $paData['tBchCode'];
            $tSHP       = $paData['tShpCode'];
            $tWAH       = $paData['tWahCode'];
            
            //หาว่าถูกลบทั้งหมดไหม
            $tSQL           = "SELECT TOP 1 FTWahCode FROM TCNMShpWah WHERE FTShpCode = '$tSHP[0]' ORDER BY FTWahCode ASC";
            $oQuery         = $this->db->query($tSQL);
            $tWahCodeNew    = $oQuery->row_array()["FTWahCode"];

            if($tWahCodeNew == '' ||  $tWahCodeNew == null){
                //คือโดนลบทั้งหมด
                $this->db->set('FTWahCode', '');
                $this->db->where('FTShpCode', $tSHP[0]);
                $this->db->update('TCNMShop');
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update null',
                );
            }else{
                //ยังเหลือ wah อยู่จะต้องหาว่ามันลบโดนตัวมันเองไหม
                $tSQL       = "SELECT FTWahCode FROM TCNMShop WHERE FTShpCode = '$tSHP[0]' ";
                $oQuery     = $this->db->query($tSQL);
                $tWahCode   = $oQuery->row_array()["FTWahCode"];
                if(FCNnHSizeOf($tWAH) > 0){
                    for($i=0; $i<FCNnHSizeOf($tWAH); $i++){
                        if($tWahCode == $tWAH[$i]){
                            //ลบไปเจอกัน
                            $this->db->set('FTWahCode', $tWahCodeNew);
                            $this->db->where('FTShpCode', $tSHP[0]);
                            $this->db->update('TCNMShop');
                            $aStatus = array(
                                'rtCode' => '1',
                                'rtDesc' => 'Update null',
                            );
                        }
                    }
                }else{

                }
            }
        }

        return $aStatus;
    }
  
 }


