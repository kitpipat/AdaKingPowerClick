<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class UploadFile_Model extends CI_Model {
 
    // Functionality : Function Clear Data In Tmp
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : -
    // Return Type : -
    public function FCNxMUPFCealDataInTmp($ptParam){

        $tBchCode   = $ptParam['tBchCode'];
        $tDocNo     = $ptParam['tDocNo'];
        $tDocKey    = $ptParam['tDocKey'];
        $tSessionID = $ptParam['tSessionID'];

        $this->db->where('FTSessionID',$tSessionID);
        $this->db->delete('TCNMFleObjTmp');

    }

    // Functionality : Function Move Data To Temp
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : Object  Move Data To Temp
    // Return Type : object
    public function FCNaMUPFIMoveDataToTmp($ptParam){

        $tBchCode   = $ptParam['tBchCode'];
        $tDocNo     = $ptParam['tDocNo'];
        $tDocKey    = $ptParam['tDocKey'];
        $tSessionID = $ptParam['tSessionID'];

        $tSQL ="INSERT INTO TCNMFleObjTmp (
                            FTFleRefTable,
                            FTFleRefID1,
                            FTFleRefID2,
                            FNFleSeq,
                            FTFleType,
                            FTFleObj,
                            FTFleName,
                            FDCreateOn,
                            FTSessionID,
                            FTFleStaUpd
                        )
                        SELECT 
                            FTFleRefTable,
                            FTFleRefID1,
                            FTFleRefID2,
                            FNFleSeq,
                            FTFleType,
                            FTFleObj,
                            FTFleName,
                            GETDATE(),
                            '$tSessionID' AS FTSessionID,
                            1 AS FTFleStaUpd
                        FROM TCNMFleObj FLE WITH(NOLOCK)
                        WHERE  1=1
                        AND FLE.FTFleRefTable = '$tDocKey'
                        AND FLE.FTFleRefID1 = '$tDocNo'
                        AND FLE.FTFleRefID2 = '$tBchCode'
        ";

             $this->db->query($tSQL);
            // $this->db->last_query();  
            // die();
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode'    => '1',
                    'rtDesc'    => 'Add Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode'    => '905',
                    'rtDesc'    => 'Error Cannot Add.',
                );
            }
            
    }

    // Functionality : Function Get Data To Delete
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : Object Get Data To Delete
    // Return Type : object
    public function FCNaMUPFGetDataDelete($ptParam){

        $tBchCode   = $ptParam['tBchCode'];
        $tDocNo     = $ptParam['tDocNo'];
        $tDocKey    = $ptParam['tDocKey'];
        $tSessionID = $ptParam['tSessionID'];

        $tSQL ="    SELECT
                            OJBFLE.FTFleObj
                        FROM
                            TCNMFleObj OJBFLE
                        WHERE
                            1 = 1
                        AND OJBFLE.FTFleRefTable = '$tDocKey'
                        AND OJBFLE.FTFleRefID1 = '$tDocNo'
                        AND OJBFLE.FTFleRefID2 = '$tBchCode'
                        AND OJBFLE.FTFleObj NOT IN (
                    SELECT
                            OJBTmp.FTFleObj
                        FROM
                            TCNMFleObjTmp OJBTmp
                        WHERE
                            1 = 1
                        AND OJBTmp.FTSessionID = '$tSessionID'
                        AND OJBTmp.FTFleRefTable = '$tDocKey'
                        AND OJBTmp.FTFleRefID1 = '$tDocNo'
                        AND OJBTmp.FTFleRefID2 = '$tBchCode'
                        )
        ";

             $oQuery = $this->db->query($tSQL);
    
             if($oQuery->num_rows() > 0){
                $aStatus = array(
                    'rtCode'    => '1',
                    'raItems'   => $oQuery->result_array(),
                    'rtDesc'    => 'Add Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode'    => '905',
                    'rtDesc'    => 'Error Cannot Add.',
                );
            }
            return $aStatus;
    }


    // Functionality : Function Get Data 
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : Object Get Data 
    // Return Type : object
    public function FCNaMUPFICallData($ptParam){

        $tBchCode   = $ptParam['tBchCode'];
        $tDocNo     = $ptParam['tDocNo'];
        $tDocKey    = $ptParam['tDocKey'];
        $tSessionID = $ptParam['tSessionID'];

        $this->db->where('FTFleRefTable',$tDocKey);
        $this->db->where('FTFleRefID1',$tDocNo);
        $this->db->where('FTFleRefID2',$tBchCode);
        $this->db->where('FTSessionID',$tSessionID);
        $aResult =  $this->db->order_by('FNFleSeq','ASC')->get('TCNMFleObjTmp')->result_array();

        return $aResult;

    }
    
    // Functionality : Function Get Data Url Api 
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : Object Get Data Url Api 
    // Return Type : object
    public function FCNaMUPFGetObjectUrl(){

        $tSQL       = "SELECT TOP 1 FTUrlAddress FROM TCNTUrlObject WITH(NOLOCK) WHERE FTUrlKey = 'FILE' AND FTUrlTable = 'TCNMComp' AND FTUrlRefID = 'CENTER' ORDER BY FNUrlSeq ASC";
		$oQuery     = $this->db->query($tSQL);
		if($oQuery->num_rows() > 0){
			$oList      = $oQuery->result_array();
			$tUrlAddr   = $oList[0]['FTUrlAddress'];
		}else{
			$aReturn = array(
				'nStaEvent'    => 900,
				'tStaMessg'    => 'เกิดข้อผิดพลาด ไม่พบ API ในการเชื่อมต่อ'
			);
			return $aReturn;
		}

        return $tUrlAddr;

    }

    // Functionality : Function Get Seq In Temp
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : Object Get Seq In Temp
    // Return Type : object
    public function FCaMUPFGetSeqInTmp($ptParam){
        $tBchCode   = $ptParam['tBchCode'];
        $tDocNo     = $ptParam['tDocNo'];
        $tDocKey    = $ptParam['tDocKey'];
        $tSessionID = $ptParam['tSessionID'];

        $tSQL = "SELECT
                        MAX(FLETMP.FNFleSeq) AS FNFleSeq
                    FROM
                        TCNMFleObjTmp FLETMP WITH(NOLOCK)
                    WHERE 1=1
                    AND FLETMP.FTFleRefTable = '$tDocKey'
                    AND FLETMP.FTFleRefID1 = '$tDocNo'
                    AND FLETMP.FTFleRefID2 = '$tBchCode'
                    AND FLETMP.FTSessionID = '$tSessionID'
                    ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail = $oQuery->row_array();
            $aResult = array(
                'FNFleSeq'    => $aDetail['FNFleSeq'],
                'rtCode'    => '1',
                'rtDesc'    => 'success'
            );
        } else {
            $aResult = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found'
            );
        }
        return $aResult;     
    }

    // Functionality : Function Insert Data To Temp
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : Object Insert Data To Temp
    // Return Type : object
    public function FCNaMUPFInsertDataToTmp($paParam){

        $this->db->insert('TCNMFleObjTmp',$paParam);
        if ($this->db->affected_rows() > 0) {
            $aStatus    = array(
                'rtCode' => '1',
                'rtDesc' => 'Add File Success',
            );
        } else {
            $aStatus    = array(
                'rtCode' => '801',
                'rtDesc' => 'Error Cannot Add File.',
            );
        }
        return $aStatus;
    }

    // Functionality : Function Delete Data To Temp
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : Object Delete Data To Temp
    // Return Type : object
    public function FCNaMUPFDeleteDataToTmp($paParam){

        $tBchCode   = $paParam['tBchCode'];
        $tDocNo     = $paParam['tDocNo'];
        $tDocKey    = $paParam['tDocKey'];
        $nSeq       = $paParam['nSeq'];
        $tSessionID = $paParam['tSessionID'];

        $this->db->where('FTFleRefTable',$tDocKey);
        $this->db->where('FTFleRefID1',$tDocNo);
        $this->db->where('FTFleRefID2',$tBchCode);
        $this->db->where('FNFleSeq',$nSeq);
        $this->db->where('FTSessionID',$tSessionID);
        $this->db->delete('TCNMFleObjTmp');

        if($this->db->affected_rows() > 0){

            $tSQL = "UPDATE TCNMFleObjTmp
            SET FNFleSeq = FNFleSeq - 1
            WHERE FNFleSeq >$nSeq 
            AND FTFleRefTable = '$tDocKey'
            AND FTFleRefID1 = '$tDocNo'
            AND FTFleRefID2 = '$tBchCode'
            AND FTSessionID = '$tSessionID'
             ";
            $this->db->query($tSQL); 

            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        return $aStatus;
    }


    // Functionality : Function Update Data To Temp
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : Object Update Data To Temp
    // Return Type : object
    public function FCNaMUPFUpdateDataToTmp($paParam){

        $tBchCode   = $paParam['tBchCode'];
        $tDocNo     = $paParam['tDocNo'];
        $tDocKey    = $paParam['tDocKey'];
        $nRowIdFrom = $paParam['nRowIdFrom'];
        $nRowIdTo   = $paParam['nRowIdTo'];
        $tSessionID = $paParam['tSessionID'];

        $this->db->set('FNFleSeq',0);
        $this->db->where('FTFleRefTable',$tDocKey);
        $this->db->where('FTFleRefID1',$tDocNo);
        $this->db->where('FTFleRefID2',$tBchCode);
        $this->db->where('FNFleSeq',$nRowIdFrom);
        $this->db->where('FTSessionID',$tSessionID);
        $this->db->update('TCNMFleObjTmp');


        if($nRowIdFrom>$nRowIdTo){
         $tSQL = "UPDATE TCNMFleObjTmp
                    SET FNFleSeq = FNFleSeq + 1
                    WHERE FNFleSeq BETWEEN $nRowIdTo AND $nRowIdFrom
                    AND FTFleRefTable = '$tDocKey'
                    AND FTFleRefID1 = '$tDocNo'
                    AND FTFleRefID2 = '$tBchCode'
                    AND FTSessionID = '$tSessionID'
            ";
           $this->db->query($tSQL);

        }else{
            $tSQL = "UPDATE TCNMFleObjTmp
            SET FNFleSeq = FNFleSeq - 1
            WHERE FNFleSeq BETWEEN $nRowIdFrom AND $nRowIdTo
            AND FTFleRefTable = '$tDocKey'
            AND FTFleRefID1 = '$tDocNo'
            AND FTFleRefID2 = '$tBchCode'
            AND FTSessionID = '$tSessionID'
                ";
            $this->db->query($tSQL);
        }

        $this->db->set('FNFleSeq',$nRowIdTo);
        $this->db->where('FTFleRefTable',$tDocKey);
        $this->db->where('FTFleRefID1',$tDocNo);
        $this->db->where('FTFleRefID2',$tBchCode);
        $this->db->where('FNFleSeq',0);
        $this->db->where('FTSessionID',$tSessionID);
        $this->db->update('TCNMFleObjTmp');

        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        return $aStatus;

    }
    
    // Functionality : Function Update DocNo  To Temp
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : Object Update DocNo To Temp
    // Return Type : object
    public function FCNaMUPFUpdateDocNoToTmp($paParam){
        $tBchCode   = $paParam['tBchCode'];
        $tDocNo     = $paParam['tDocNo'];
        $tDocKey    = $paParam['tDocKey'];
        $nEvent     = $paParam['nEvent'];
        $tSessionID = $paParam['tSessionID'];

        if($nEvent==1){//ถ้าเป็นขาเพิ่มต้องอัพเดทเลขที่เอกสารก่อน
            $this->db->set('FTFleRefID1',$tDocNo);
            $this->db->where('FTFleRefTable',$tDocKey);
            $this->db->where('FTFleRefID1','');
            $this->db->where('FTFleRefID2',$tBchCode);
            $this->db->where('FTSessionID',$tSessionID);
            $this->db->update('TCNMFleObjTmp');
    
        }
    }

    // Functionality : Function Move Temp To Table
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : Object Move Temp To Table
    // Return Type : object
    public function FCNaMUPFMoveTmpToFleTable($paParam){

        $tBchCode   = $paParam['tBchCode'];
        $tDocNo     = $paParam['tDocNo'];
        $tDocKey    = $paParam['tDocKey'];
        $tSessionID = $paParam['tSessionID'];
        $tSesUsername = $this->session->userdata('tSesUsername');


        $this->db->where('FTFleRefTable',$tDocKey);
        $this->db->where('FTFleRefID1',$tDocNo);
        $this->db->where('FTFleRefID2',$tBchCode);
        $this->db->delete('TCNMFleObj');

        $tSQL = "INSERT INTO TCNMFleObj (
                            FTFleRefTable,
                            FTFleRefID1,
                            FTFleRefID2,
                            FNFleSeq,
                            FTFleType,
                            FTFleObj,
                            FTFleName,
                            FDLastUpdOn,
                            FTLastUpdBy,
                            FDCreateOn,
                            FTCreateBy
                        )
                        SELECT 
                            FTFleRefTable,
                            FTFleRefID1,
                            FTFleRefID2,
                            FNFleSeq,
                            FTFleType,
                            FTFleObj,
                            FTFleName,
                            GETDATE() AS FDLastUpdOn,
                            '$tSesUsername' AS FTLastUpdBy,
                            GETDATE() AS FDCreateOn,
                            '$tSesUsername' AS FTCreateBy
                       
                        FROM TCNMFleObjTmp FLE WITH(NOLOCK)
                        WHERE  1=1
                        AND FLE.FTFleRefTable = '$tDocKey'
                        AND FLE.FTFleRefID1 = '$tDocNo'
                        AND FLE.FTFleRefID2 = '$tBchCode'
                        AND FLE.FTSessionID = '$tSessionID'
        ";

             $this->db->query($tSQL);
            // $this->db->last_query();  
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode'    => '1',
                    'rtDesc'    => 'Add Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode'    => '905',
                    'rtDesc'    => 'Error Cannot Add.',
                );
            }
            return $aStatus;

    }


    // Functionality : Function GetData By BchCode
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : Object GetData By BchCode
    // Return Type : object
    public function FCNaMUPFCheckFile($paParam){

        $tBchCode   = $paParam['tBchCode'];
        $tDocKey    = $paParam['tDocKey'];


    
            $tSQL ="  SELECT 
                    FTFleRefTable,
                    FTFleRefID1,
                    FTFleRefID2,
                    FNFleSeq,
                    FTFleType,
                    FTFleObj,
                    FTFleName
                FROM TCNMFleObj FLE WITH(NOLOCK)
                WHERE  1=1
                AND FLE.FTFleRefTable = '$tDocKey'
                AND FLE.FTFleRefID2 = '$tBchCode'
           
            ";
           $oQuery = $this->db->query($tSQL);
           if ($oQuery->num_rows() > 0) {
            $aStatus = array(
                'rtCode'    => '1',
                'raItems'   => $oQuery->result_array(),
                'rtDesc'    => 'Add Success.',
            );
        }else{
            $aStatus = array(
                'rtCode'    => '905',
                'rtDesc'    => 'Error Cannot Add.',
            );
        }
        return $aStatus;
    }

    // Functionality : Function GetData Non Upload
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : Object GetData Non Upload
    // Return Type : object
    public function FCNaMUPFGetDataNonUpload($paParam){

    $tBchCode   = $paParam['tBchCode'];
    $tDocNo     = $paParam['tDocNo'];
    $tDocKey    = $paParam['tDocKey'];
    $tSessionID = $paParam['tSessionID'];

        $tSQL ="  SELECT 
                FTFleRefTable,
                FTFleRefID1,
                FTFleRefID2,
                FNFleSeq,
                FTFleType,
                FTFleObj,
                FTFleName
            FROM TCNMFleObjTmp FLE WITH(NOLOCK)
            WHERE  1=1
            AND FLE.FTFleRefTable = '$tDocKey'
            AND FLE.FTFleRefID1 = '$tDocNo'
            AND FLE.FTFleRefID2 = '$tBchCode'
            AND FLE.FTSessionID = '$tSessionID'
            AND ISNULL(FLE.FTFleStaUpd,'') = ''
        ";
       $oQuery = $this->db->query($tSQL);
       if ($oQuery->num_rows() > 0) {
            $aStatus = array(
                'rtCode'    => '1',
                'raItems'   => $oQuery->result_array(),
                'rtDesc'    => 'Add Success.',
            );
        }else{
            $aStatus = array(
                'rtCode'    => '905',
                'rtDesc'    => 'Error Cannot Add.',
            );
        }
        return $aStatus;
    }

    // Functionality : Function Upload To Api
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : Object Upload To Api
    // Return Type : object
    public function FCNaMUPFCallApiUpload($paParam){

            $aResult = $this->FCNaMUPFGetDataNonUpload($paParam);


            if($aResult['rtCode']=='1'){
            $tSessionID = $paParam['tSessionID'];
            $tBchCode   = $paParam['tBchCode'];
            $tUrlAddr   = $this->FCNaMUPFGetObjectUrl();
            $tUrlApi    = $tUrlAddr.'/Upload/File';
            $aAPIKey    = array(
                'tKey'      => 'X-Api-Key',
                'tValue'    => '12345678-1111-1111-1111-123456789410'
            );

            $aFiles = $aResult['raItems'];

            if(!empty($aFiles)){

                foreach($aFiles as $aFile){

                    $tPath = $aFile['FTFleName'];
                    $tExt = pathinfo($tPath, PATHINFO_EXTENSION);
                    $tFileName = basename($tPath,".".$tExt);
                

                    $aParam     = array(
                        'ptContent'		=> new CURLFILE($aFile['FTFleObj'],$aFile['FTFleType'],$aFile['FTFleName']),
                        'ptRef1'        => 'branch_'.$tBchCode,
                        'ptRef2'        => 'saleorder',
                        'ptRefName'     => $tFileName,
                    );
                    //  echo $tUrlApi;
                    // print_r($aParam);
                    $oReuslt = FCNaHCallAPIBasic($tUrlApi,'POST',$aParam,$aAPIKey,'file');
                
                    if($oReuslt['rtCode'] != "99" ){
                        $aDataUpdate = array(
                            'FTFleRefTable' => $aFile['FTFleRefTable'],
                            'FTFleRefID1'   => $aFile['FTFleRefID1'],
                            'FTFleRefID2'   => $aFile['FTFleRefID2'],
                            'FNFleSeq'      => $aFile['FNFleSeq'],
                            'FTFleType'     => $tExt,
                            'FTFleObj'      => $oReuslt['rtData'],
                            'FTFleName'     => $aFile['FTFleName'],
                            'FDCreateOn'    => date('Y-m-d H:i:s'),
                            'FTSessionID'   => $tSessionID
                        );
                        // print_r($aDataUpdate);
                    //    $aStatus = $this->FCNaMUPFUpdateFileDataToTmp($aDataUpdate);
                    $aReturn = array(
                        'nStaEvent'    => $oReuslt['rtCode'],
                        'tStaMessg'    => $oReuslt['rtDesc']
                    );
                    }else{
                        $aReturn = array(
                            'nStaEvent'    => $oReuslt['rtCode'],
                            'tStaMessg'    => $oReuslt['rtDesc']
                        );
                    }


                }


            }

            }else{

                $aReturn = array(
                    'nStaEvent'    => $aResult['rtCode'],
                    'tStaMessg'    => $aResult['rtDesc']
                    
                );
            }

            return $aReturn;
    
    }


    // Functionality : Function Update Data File To Temp
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : Object Update Data File To Temp
    // Return Type : object
    public function FCNaMUPFUpdateFileDataToTmp($paParam){

        $tFleRefTable   = $paParam['FTFleRefTable'];
        $tFleRefID1     = $paParam['FTFleRefID1'];
        $tFleRefID2     = $paParam['FTFleRefID2'];
        $nFleSeq        = $paParam['FNFleSeq'];
        $tSessionID     = $paParam['FTSessionID'];

        $tFleType       = $paParam['FTFleType'];
        $tFleObj        = $paParam['FTFleObj'];

        $this->db->set('FTFleType',$tFleType);
        $this->db->set('FTFleObj',$tFleObj);
        $this->db->where('FTFleRefTable',$tFleRefTable);
        $this->db->where('FTFleRefID1',$tFleRefID1);
        $this->db->where('FTFleRefID2',$tFleRefID2);
        $this->db->where('FNFleSeq',$nFleSeq);
        $this->db->where('FTSessionID',$tSessionID);
        $this->db->update('TCNMFleObjTmp');

        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        return $aStatus;
    }






}