<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Pdtfashion_model extends CI_Model {


     //Functionality : check Data Userlogin
    //Parameters : function parameters
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMPFHFGetMaster($paData){
        try{
           
            $tPdtCode     = $paData['FTPdtCode'];
            $nLngID       = $paData['FNLngID'];

            $tSQL   = "SELECT
                            CAT.FTPdtCode,
                            PDTL.FTPdtName,
                            CATL1.FTCatCode         AS FTDepCode,
                            CATL1.FTCatName         AS FTDepName,
                            CATL2.FTCatCode         AS FTClsCode,
                            CATL2.FTCatName         AS FTClsName,
                            CATL3.FTCatCode         AS FTSclCode,
                            CATL3.FTCatName         AS FTSclName,
                            CATL4.FTCatCode         AS FTPgpCode,
                            CATL4.FTCatName         AS FTPgpName,
                            CATL5.FTCatCode         AS FTCmlCode,
                            CATL5.FTCatName         AS FTCmlName,
                            CAT.FTPdtModNo          AS FTFhnModNo,
                            CAT.FTPdtGender         AS FTFhnGender
                        FROM TCNMPdtCategory CAT WITH(NOLOCK)
                        INNER JOIN TCNMPdt_L        PDTL   WITH(NOLOCK) ON CAT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = $nLngID
                        LEFT OUTER JOIN TCNMPdtCatInfo_L CATL1  WITH(NOLOCK) ON CATL1.FTCatCode = CAT.FTPdtCat1 AND CATL1.FNCatLevel = 1 AND CATL1.FNLngID = $nLngID
                        LEFT OUTER JOIN TCNMPdtCatInfo_L CATL2  WITH(NOLOCK) ON CATL2.FTCatCode = CAT.FTPdtCat2 AND CATL2.FNCatLevel = 2 AND CATL2.FNLngID = $nLngID
                        LEFT OUTER JOIN TCNMPdtCatInfo_L CATL3  WITH(NOLOCK) ON CATL3.FTCatCode = CAT.FTPdtCat3 AND CATL3.FNCatLevel = 3 AND CATL3.FNLngID = $nLngID
                        LEFT OUTER JOIN TCNMPdtCatInfo_L CATL4  WITH(NOLOCK) ON CATL4.FTCatCode = CAT.FTPdtCat4 AND CATL4.FNCatLevel = 4 AND CATL4.FNLngID = $nLngID
                        LEFT OUTER JOIN TCNMPdtCatInfo_L CATL5  WITH(NOLOCK) ON CATL5.FTCatCode = CAT.FTPdtCat5 AND CATL5.FNCatLevel = 5 AND CATL5.FNLngID = $nLngID

                        /*LEFT OUTER JOIN TFHMPdtF1Depart_L PDTDPL WITH(NOLOCK) ON PdtFhn.FTDepCode = PDTDPL.FTDepCode AND PDTL.FNLngID = $nLngID
                        LEFT OUTER JOIN TFHMPdtF2Class_L PDTClSL WITH(NOLOCK) ON PdtFhn.FTClsCode = PDTClSL.FTClsCode AND PDTClSL.FNLngID = $nLngID
                        LEFT OUTER JOIN TFHMPdtF3SubClass_L PDTSClSL WITH(NOLOCK) ON PdtFhn.FTSclCode = PDTSClSL.FTSclCode AND PDTSClSL.FNLngID = $nLngID
                        LEFT OUTER JOIN TFHMPdtF4Group_L PDTGRPL WITH(NOLOCK) ON PdtFhn.FTPgpCode = PDTGRPL.FTPgpCode AND PDTGRPL.FNLngID = $nLngID
                        LEFT OUTER JOIN TFHMPdtF5ComLines_L PDTCML WITH(NOLOCK) ON PdtFhn.FTCmlCode = PDTCML.FTCmlCode AND PDTCML.FNLngID = $nLngID*/
    
                        WHERE 1=1 AND CAT.FTPdtCode = '$tPdtCode'";    
            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0){
                $oDetail    = $oQuery->result();
                $aResult= array(
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
        }catch(Exception $Error){
            echo $Error;
        }

    }


    //Functionality : Add PdtFashion
    //Parameters : function parameters
    //Creator : 27/04/2021 Nattakit
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMPFHAddUpdateMaster($paData){
        try{

            //ต้องไปอัพเดท วันที่ + เวลา ที่ตาราง TCNMPdt ว่ามีการเปลี่ยนแปลงด้วย
            $this->db->set('FDLastUpdOn',$paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy',$paData['FTLastUpdBy']);
            $this->db->update('TCNMPdt');

            //Update Master
            $this->db->set('FTPdtCat1'        ,$paData['FTDepCode']);
            $this->db->set('FTPdtCat2'        ,$paData['FTClsCode']);
            $this->db->set('FTPdtCat3'        ,$paData['FTSclCode']);
            $this->db->set('FTPdtCat4'       ,$paData['FTPgpCode']);
            $this->db->set('FTPdtCat5'       ,$paData['FTCmlCode']);
            $this->db->set('FTPdtModNo'       ,$paData['FTFhnModNo']);
            $this->db->set('FTPdtGender'      ,$paData['FTFhnGender']);
            // $this->db->set('FTLastUpdBy'      ,$paData['FTLastUpdBy']);
            // $this->db->set('FDLastUpdOn'      ,$paData['FDLastUpdOn']);
            $this->db->where('FTPdtCode'      ,$paData['FTPdtCode']);
            $this->db->update('TCNMPdtCategory');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            }else{
                $aResult = array(
                    'FTPdtCode'             => $paData['FTPdtCode'],
                    'FTPdtCat1'             => $paData['FTDepCode'], 
                    'FTPdtCat2'             => $paData['FTClsCode'],
                    'FTPdtCat3'             => $paData['FTSclCode'],
                    'FTPdtCat4'            => $paData['FTPgpCode'],
                    'FTPdtCat5'            => $paData['FTCmlCode'],
                    'FTPdtModNo'            => $paData['FTFhnModNo'],
                    'FTPdtGender'           => $paData['FTFhnGender'],
                    // 'FDLastUpdOn'           => $paData['FDLastUpdOn'],
                    // 'FTLastUpdBy'           => $paData['FTLastUpdBy'],
                    // 'FDCreateOn'            => $paData['FDCreateOn'],
                    // 'FTCreateBy'            => $paData['FTCreateBy'],
                );

                // Add Data Master
                $this->db->insert('TCNMPdtCategory',$aResult);

                if($this->db->affected_rows() > 0){
                    $aStatus   = array(
                        'reCode'    => '1',
                        'rtDesc'    => 'Add Master Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode'    => '905',
                        'rtDesc'    => 'Error Cannot Add MAster',
                    );
                }

            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }


    
    //Functionality : Add PdtFashion
    //Parameters : function parameters
    //Creator : 27/04/2021 Nattakit
    //Return : Array Stutus Add Update
    //Return Type : Array

    public function FSaMPFHFGetDataTable($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $tPdtCode     = $paData['FTPdtCode'];
            $tSearchFhnPdtColorSze = $paData['tSearchFhnPdtColorSze'];
            $nLngID       = $paData['FNLngID'];

            $tConditionWhere ='';
            if(!empty($tSearchFhnPdtColorSze)){
                $tConditionWhere.= " AND ( PdtClrSze.FTFhnRefCode LIKE '%$tSearchFhnPdtColorSze%'  " ;
                $tConditionWhere.= " OR  PdtClrSze.FTSeaCode LIKE '%$tSearchFhnPdtColorSze%' OR PdtSea_L.FTSeaName LIKE '%$tSearchFhnPdtColorSze%'  " ;
                $tConditionWhere.= " OR  PdtClrSze.FTFabCode LIKE '%$tSearchFhnPdtColorSze%' OR PdtFab_L.FTFabName LIKE '%$tSearchFhnPdtColorSze%'  " ;
                $tConditionWhere.= " OR  PdtClrSze.FTClrCode LIKE '%$tSearchFhnPdtColorSze%' OR PdtColor_L.FTClrName LIKE '%$tSearchFhnPdtColorSze%'  " ;
                $tConditionWhere.= " OR  PdtClrSze.FTPszCode LIKE '%$tSearchFhnPdtColorSze%' OR PdtSize_L.FTPszName LIKE '%$tSearchFhnPdtColorSze%'  " ;
                $tConditionWhere.= "  ) " ;
            }
            $tSQLHeader = "SELECT c.* FROM ( SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC ) AS rtRowID,* FROM ( ";
            $tSQL   = "SELECT
                        PdtImg.FTImgObj AS FTImgObj,
                        PdtClrSze.FTPdtCode,
                        PdtClrSze.FTFhnRefCode,
                        ( SELECT TOP 1 PDTBar.FTBarCode FROM TCNMPdtBar PDTBar WITH (NOLOCK) WHERE PDTBar.FTPdtCode = PdtClrSze.FTPdtCode AND PDTBar.FTFhnRefCode = PdtClrSze.FTFhnRefCode AND PDTBar.FNBarRefSeq = PdtClrSze.FNFhnSeq  ORDER BY PDTBar.FDCreateOn DESC  ) AS FTBarCode,
                        PdtClrSze.FNFhnSeq,
                        PdtClrSze.FTSeaCode,
                        PdtSea_L.FTSeaName,
                        PdtClrSze.FTFabCode,
                        PdtFab_L.FTFabName,
                        PdtClrSze.FTClrCode,
                        PdtColor_L.FTClrName,
                        PdtClrSze.FTPszCode,
                        PdtSize_L.FTPszName,
                        PdtClrSze.FTFhnStaActive,
                        PdtClrSze.FDLastUpdOn,
                        PdtClrSze.FTLastUpdBy,
                        PdtClrSze.FDCreateOn,
                        PdtClrSze.FTCreateBy
                        FROM
                            TFHMPdtColorSize PdtClrSze WITH(NOLOCK)
                        LEFT OUTER JOIN TFHMPdtSeason PdtSea WITH(NOLOCK) ON PdtClrSze.FTSeaCode = PdtSea.FTSeaCode 
                        LEFT OUTER JOIN TFHMPdtSeason_L PdtSea_L WITH(NOLOCK) ON PdtSea.FTSeaCode = PdtSea_L.FTSeaCode AND PdtSea.FTSeaChain = PdtSea_L.FTSeaChain AND PdtSea_L.FNLngID = $nLngID
                        LEFT OUTER JOIN TFHMPdtFabric_L PdtFab_L WITH(NOLOCK) ON PdtClrSze.FTFabCode = PdtFab_L.FTFabCode AND PdtFab_L.FNLngID = $nLngID
                        LEFT OUTER JOIN TCNMPdtColor_L PdtColor_L WITH(NOLOCK) ON PdtClrSze.FTClrCode = PdtColor_L.FTClrCode AND PdtColor_L.FNLngID = $nLngID
                        LEFT OUTER JOIN TCNMPdtSize_L PdtSize_L WITH(NOLOCK) ON PdtClrSze.FTPszCode = PdtSize_L.FTPszCode AND PdtSize_L.FNLngID = $nLngID
                        LEFT OUTER JOIN TCNMImgPdt PdtImg WITH (NOLOCK) ON PdtClrSze.FTPdtCode + PdtClrSze.FTFhnRefCode + CONVERT(VARCHAR(18),PdtClrSze.FNFhnSeq) = PdtImg.FTImgRefID AND PdtImg.FTImgTable = 'TFHMPdtColorSize'
                        WHERE 1=1 
                        AND PdtClrSze.FTPdtCode = '$tPdtCode'
                        $tConditionWhere
                        ";    
            $tSQLFooter = " ) Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";


            $tSQLMain = $tSQLHeader.$tSQL.$tSQLFooter;
            $tSQLSub  = $tSQL;

            $oQuery = $this->db->query($tSQLMain);

            if ($oQuery->num_rows() > 0){
                $oQuerySub  = $this->db->query($tSQLSub);
                $oDetail    = $oQuery->result();
                $nFoundRow  = $oQuerySub->num_rows();
                $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult= array(
                    'raItems'   => $oDetail,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paData['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            }else{
                //if data not found
                $aResult    = array(
                    'rnAllRow'      => 0,
                    'rnCurrentPage' => $paData['nPage'],
                    "rnAllPage"     => 0,
                    'rtCode'    => '800',
                    'rtDesc'    => 'data not found',
                );
            }    
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }


    }

    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaMPFHFGetClrSzeById($paData){
        try{
           
            $tPdtCode     = $paData['FTPdtCode'];
            $tFhnRefCode     = $paData['FTFhnRefCode'];
            $nFhnSeq     = $paData['FNFhnSeq'];
            $nLngID       = $paData['FNLngID'];

            $tSQL   = "SELECT
                        PdtImg.FTImgObj AS FTImgObj,
                        PdtClrSze.FTPdtCode,
                        PdtClrSze.FTFhnRefCode,
                        PdtClrSze.FNFhnSeq,
                        PdtClrSze.FTSeaCode,
                        PdtSea_L.FTSeaName,
                        PdtClrSze.FTFabCode,
                        PdtFab_L.FTFabName,
                        PdtClrSze.FTClrCode,
                        PdtColor_L.FTClrName,
                        PdtClrSze.FTPszCode,
                        PdtSize_L.FTPszName,
                        PdtClrSze.FDFhnStart,
                        PdtClrSze.FTFhnStaActive,
                        PdtClrSze.FDLastUpdOn,
                        PdtClrSze.FTLastUpdBy,
                        PdtClrSze.FDCreateOn,
                        PdtClrSze.FTCreateBy
                        FROM
                            TFHMPdtColorSize PdtClrSze WITH(NOLOCK)
                        LEFT OUTER JOIN TFHMPdtSeason PdtSea WITH(NOLOCK) ON PdtClrSze.FTSeaCode = PdtSea.FTSeaCode 
                        LEFT OUTER JOIN TFHMPdtSeason_L PdtSea_L WITH(NOLOCK) ON PdtSea.FTSeaCode = PdtSea_L.FTSeaCode AND PdtSea.FTSeaChain = PdtSea_L.FTSeaChain AND PdtSea_L.FNLngID = $nLngID
                        LEFT OUTER JOIN TFHMPdtFabric_L PdtFab_L WITH(NOLOCK) ON PdtClrSze.FTFabCode = PdtFab_L.FTFabCode AND PdtFab_L.FNLngID = $nLngID
                        LEFT OUTER JOIN TCNMPdtColor_L PdtColor_L WITH(NOLOCK) ON PdtClrSze.FTClrCode = PdtColor_L.FTClrCode AND PdtColor_L.FNLngID = $nLngID
                        LEFT OUTER JOIN TCNMPdtSize_L PdtSize_L WITH(NOLOCK) ON PdtClrSze.FTPszCode = PdtSize_L.FTPszCode AND PdtSize_L.FNLngID = $nLngID
                        LEFT OUTER JOIN TCNMImgPdt PdtImg WITH (NOLOCK) ON PdtClrSze.FTPdtCode + PdtClrSze.FTFhnRefCode + CONVERT(VARCHAR(18),PdtClrSze.FNFhnSeq) = PdtImg.FTImgRefID AND PdtImg.FTImgTable = 'TFHMPdtColorSize'
                        WHERE 1=1 AND PdtClrSze.FTPdtCode = '$tPdtCode' AND PdtClrSze.FTFhnRefCode = '$tFhnRefCode' AND PdtClrSze.FNFhnSeq = '$nFhnSeq' ";    

            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0){
                $oDetail    = $oQuery->row_array();
                $aResult= array(
                    'raItems'   => $oDetail,
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
        }catch(Exception $Error){
            echo $Error;
        }

    }

    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSvMPFHClrSzeEventAdd($paData){
        try{

            //ต้องไปอัพเดท วันที่ + เวลา ที่ตาราง TCNMPdt ว่ามีการเปลี่ยนแปลงด้วย
            $this->db->set('FDLastUpdOn',$paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy',$paData['FTLastUpdBy']);
            $this->db->update('TCNMPdt');

                $aResult = array(
                    'FTPdtCode'             => $paData['FTPdtCode'],
                    'FTFhnRefCode'          => $paData['FTFhnRefCode'], 
                    'FNFhnSeq'              => $paData['FNFhnSeq'],
                    'FTSeaCode'             => $paData['FTSeaCode'],
                    'FTFabCode'             => $paData['FTFabCode'],
                    'FTClrCode'             => $paData['FTClrCode'],
                    'FTPszCode'             => $paData['FTPszCode'],
                    'FDFhnStart'            => $paData['FDFhnStart'],
                    'FTFhnStaActive'        => $paData['FTFhnStaActive'],
                    'FDLastUpdOn'           => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'           => $paData['FTLastUpdBy'],
                    'FDCreateOn'            => $paData['FDCreateOn'],
                    'FTCreateBy'            => $paData['FTCreateBy'],
                );

                // Add Data Master
                $this->db->insert('TFHMPdtColorSize',$aResult);

                if($this->db->affected_rows() > 0){
                    $aStatus   = array(
                        'reCode'    => '1',
                        'rtDesc'    => 'Add Master Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode'    => '905',
                        'rtDesc'    => 'Error Cannot Add MAster',
                    );
                }

            
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }  
    }




    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSvMPFHClrSzeEventEdit($paData){
        try{

            //ต้องไปอัพเดท วันที่ + เวลา ที่ตาราง TCNMPdt ว่ามีการเปลี่ยนแปลงด้วย
            $this->db->set('FDLastUpdOn',$paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy',$paData['FTLastUpdBy']);
            $this->db->update('TCNMPdt');

                //Update Master
                $this->db->set('FTSeaCode'        ,$paData['FTSeaCode']);
                $this->db->set('FTFabCode'        ,$paData['FTFabCode']);
                $this->db->set('FTClrCode'        ,$paData['FTClrCode']);
                $this->db->set('FTPszCode'        ,$paData['FTPszCode']);
                $this->db->set('FDFhnStart'        ,$paData['FDFhnStart']);
                $this->db->set('FTFhnStaActive'   ,$paData['FTFhnStaActive']);
                $this->db->set('FTLastUpdBy'      ,$paData['FTLastUpdBy']);
                $this->db->set('FDLastUpdOn'      ,$paData['FDLastUpdOn']);
                $this->db->where('FTPdtCode'      ,$paData['FTPdtCode']);
                $this->db->where('FTFhnRefCode'   ,$paData['FTFhnRefCodeOld']);
                $this->db->where('FNFhnSeq'   ,$paData['FNFhnSeq']);
                $this->db->update('TFHMPdtColorSize');

                if($this->db->affected_rows() > 0){
                    $aStatus   = array(
                        'reCode'    => '1',
                        'rtDesc'    => 'Update Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode'    => '905',
                        'rtDesc'    => 'Error Cannot Add MAster',
                    );
                }

            
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }  
    }


    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSvMPFHClrSzeEventDelete($paData){
        //ต้องไปอัพเดท วันที่ + เวลา ที่ตาราง TCNMPdt ว่ามีการเปลี่ยนแปลงด้วย
        $this->db->set('FDLastUpdOn',$paData['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy',$paData['FTLastUpdBy']);
        $this->db->update('TCNMPdt');

        $this->db->where('FTPdtCode', $paData['FTPdtCode']);
        $this->db->where('FTFhnRefCode', $paData['FTFhnRefCode']);
        $this->db->where('FNFhnSeq', $paData['FNBarRefSeq']);
        $this->db->delete('TFHMPdtColorSize');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aStatus = array(
                'tCode' => '500',
                'tDesc' => 'Error Cannot Delete Product.',
            );
        } else {
            $this->db->trans_commit();
            $aStatus = array(
                'tCode' => '1',
                'tDesc' => 'Delete Product Success.',
            );
        }
        return $aStatus;
    }

    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaMPFHGetDataTableBarCodeByID($paDataWhere)
    {
        $nLangEdit     = $paDataWhere['nLangEdit'];
        $tPdtCode       = $paDataWhere['FTPdtCode'];
        $tFhnRefCode    = $paDataWhere['FTFhnRefCode'];
        $nBarRefSeq        = $paDataWhere['FNBarRefSeq'];
        $tSQL       = "SELECT
                            PDTBar.FTPdtCode,
                            PDTBar.FTBarCode,
                            PDTBar.FTFhnRefCode,
                            PDTBar.FNBarRefSeq,
                            PDTBar.FTPunCode,
                            PDTUnt_L.FTPunName,
                            PAKZ.FCPdtUnitFact,
                            PDTBar.FTPlcCode,
                            PDTLoc_L.FTPlcName,
                            PDTSpl.FTSplCode,
                            TCNMSpl_L.FTSplName,
                            PDTSpl.FTSplStaAlwPO,
                            PDTBar.FTBarStaUse,
                            PDTBar.FTBarStaAlwSale
                        FROM
                            TCNMPdtBar PDTBar WITH(NOLOCK)
                        LEFT OUTER JOIN TCNMPdtSpl PDTSpl WITH(NOLOCK) ON PDTBar.FTPdtCode = PDTSpl.FTPdtCode AND PDTBar.FTBarCode = PDTSpl.FTBarCode
                        LEFT OUTER JOIN TCNMSpl_L TCNMSpl_L WITH(NOLOCK) ON PDTSpl.FTSplCode = TCNMSpl_L.FTSplCode AND TCNMSpl_L.FNLngID = $nLangEdit
                        LEFT OUTER JOIN TCNMPdtLoc_L PDTLoc_L WITH(NOLOCK) ON PDTBar.FTPlcCode = PDTLoc_L.FTPlcCode AND PDTLoc_L.FNLngID = $nLangEdit
                        LEFT OUTER JOIN TCNMPdtUnit_L PDTUnt_L WITH(NOLOCK) ON PDTBar.FTPunCode = PDTUnt_L.FTPunCode AND PDTUnt_L.FNLngID = $nLangEdit
                        LEFT OUTER JOIN TCNMPdtPackSize PAKZ WITH(NOLOCK) ON PDTBar.FTPdtCode = PAKZ.FTPdtCode AND PDTBar.FTPunCode = PAKZ.FTPunCode
                        WHERE
                            PDTBar.FTPdtCode = '$tPdtCode' AND PDTBar.FTFhnRefCode = '$tFhnRefCode' AND PDTBar.FNBarRefSeq = '$nBarRefSeq'
                        ORDER BY PDTBar.FDLastUpdOn DESC
                        ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataQuery = $oQuery->result_array();
            $aResult    =  array(
                'raItems'   => $aDataQuery,
                'rtCode'    => '1',
                'rtDesc'    => 'success'
            );
        } else {
            $aResult =  array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found'
            );
        }
        return $aResult;
    }



    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaMPFHCheckBarCodeByID($paData)
    {
        $tSQL = "SELECT FTBarCode 
        FROM TCNMPdtBar 
        WHERE 1=1 
        AND FTPdtCode = '$paData[FTPdtCode]' 
        AND FTBarCode = '$paData[FTBarCode]'
        AND FNBarRefSeq = $paData[FNBarRefSeq]
        ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult    =  array(
                'tSQL'      => $tSQL,
                'rtCode'    => '1',
                'rtDesc'    => 'success'
            );
        } else {
            $aResult =  array(
                'tSQL'      => $tSQL,
                'rtCode'    => '800',
                'rtDesc'    => 'data not found'
            );
        }
        return $aResult;
    }


    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSxMPFHAddUpdateBarCodeByID($paDataPackSize)
    {
        $FTMttTableKey          = $paDataPackSize['FTMttTableKey'];
        $FTMttRefKey            = $paDataPackSize['FTMttRefKey'];
        $FTPdtCode              = $paDataPackSize['FTPdtCode'];
        $FTBarCode              = $paDataPackSize['FTBarCode'];
        $tOldBarCode            = $paDataPackSize['tOldBarCode'];
        $FTFhnPdtRefCode        = $paDataPackSize['FTFhnPdtRefCode'];
        $FNBarRefSeq            = $paDataPackSize['FNBarRefSeq'];
        $FTPunCode              = $paDataPackSize['FTPunCode'];
        $FTSplCode              = $paDataPackSize['FTSplCode'];
        $FTSplName              = $paDataPackSize['FTSplName'];
        $FTPlcCode              = $paDataPackSize['FTPlcCode'];
        $FTPlcName              = $paDataPackSize['FTPlcName'];
        $FTBarStaUse            = $paDataPackSize['FTBarStaUse'];
        $FTBarStaAlwSale        = $paDataPackSize['FTBarStaAlwSale'];
        $FTSplStaAlwPO          = $paDataPackSize['FTSplStaAlwPO'];
        $FTMttSessionID         = $paDataPackSize['FTMttSessionID'];

        $tSQL       = "SELECT FTBarCode
                        FROM TCNMPdtBar
                        WHERE  FTPdtCode = '$FTPdtCode'
                         AND FTBarCode   = '$tOldBarCode' 
                         AND FNBarRefSeq = '$FNBarRefSeq'   ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDataBarCode = array(
                'FTBarCode'         => $FTBarCode,
                'FTPlcCode'         => $FTPlcCode,
                'FTPunCode'         => $FTPunCode,
                'FTBarStaUse'       => $FTBarStaUse,
                'FTBarStaAlwSale'   => $FTBarStaAlwSale,
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
            );
            $this->db->where('FTPdtCode', $FTPdtCode);
            $this->db->where('FTBarCode', $tOldBarCode);
            $this->db->where('FNBarRefSeq', $FNBarRefSeq);
            $this->db->update('TCNMPdtBar', $aDataBarCode);
        } else {
            $aDataBarCode   = array(
                'FTPdtCode'         => $FTPdtCode,
                'FTBarCode'         => $FTBarCode,
                'FTFhnRefCode'      => $FTFhnPdtRefCode,
                'FNBarRefSeq'       => $FNBarRefSeq,
                'FTPlcCode'         => $FTPlcCode,
                'FTPunCode'         => $FTPunCode,
                'FTBarStaUse'       => $FTBarStaUse,
                'FTBarStaAlwSale'   => $FTBarStaAlwSale,
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
            );
            $aDataPdtSpl   = array(
                'FTPdtCode'         => $FTPdtCode,
                'FTBarCode'         => $FTBarCode,
                'FNBarRefSeq'       => $FNBarRefSeq,
                'FTSplCode'         => $FTSplCode,
                'FTSplStaAlwPO'     => $FTSplStaAlwPO,
            );
            $this->db->insert('TCNMPdtBar', $aDataBarCode);

            if($aDataPdtSpl['FTSplCode']!=''){
                $tSQL       = "     SELECT FTBarCode
                                        FROM TCNMPdtSpl
                                    WHERE  FTPdtCode = '$FTPdtCode'
                                    AND FTBarCode    = '$FTBarCode' 
                                    AND FNBarRefSeq  = '$FNBarRefSeq'
                                    AND FTSplCode    = '$FTSplCode'   ";
                $oQuery = $this->db->query($tSQL);
                if ($oQuery->num_rows() == 0) {
                $this->db->insert('TCNMPdtSpl', $aDataPdtSpl);
                }
            }

        }

        $aResult    =  array(
            'rtCode'    => '1',
            'rtDesc'    => 'success'
        );
        return $aResult;
    }

    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSxMPFHDeleteBarCode($paDataDel)
    {
        // Delete Table PDT
        $this->db->where('FTPdtCode', $paDataDel['FTPdtCode']);
        $this->db->where('FTBarCode', $paDataDel['FTBarCode']);
        $this->db->where('FNBarRefSeq', $paDataDel['FNBarRefSeq']);
        $this->db->delete('TCNMPdtBar');
     
        // Delete Supplier 
        $this->db->where('FTPdtCode', $paDataDel['FTPdtCode']);
        $this->db->where('FTBarCode', $paDataDel['FTBarCode']);
        $this->db->where('FNBarRefSeq', $paDataDel['FNBarRefSeq']);
        $this->db->delete('TCNMPdtSpl');

    }

    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaMPFHCheckBarOldCodeByID($paData)
    {
        $tSQL = "SELECT FTBarCode 
        FROM TCNMPdtBar 
        WHERE 1=1 
        AND FTPdtCode    = '$paData[FTPdtCode]' 
        AND FTBarCode    = '$paData[tOldBarCode]'
        AND FNBarRefSeq  = $paData[FNBarRefSeq]
        ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult    =  array(
                'tSQL'      => $tSQL,
                'rtCode'    => '1',
                'rtDesc'    => 'success'
            );
        } else {
            $aResult =  array(
                'tSQL'      => $tSQL,
                'rtCode'    => '800',
                'rtDesc'    => 'data not found'
            );
        }
        return $aResult;
    }
 

    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSxMPFHInsertDefaultBarCode($paData){
    try{

         $nNumRowPdtBarByRefCode = $this->db->where('FTPdtCode',$paData['FTPdtCode'])->where('FTBarCode',$paData['FTBarCode'])->where('FNBarRefSeq',$paData['FNBarRefSeq'])->get('TCNMPdtBar')->num_rows();
         if($nNumRowPdtBarByRefCode==0){
            $aDataBarCode   = array(
                'FTPdtCode'         => $paData['FTPdtCode'],
                'FTBarCode'         => $paData['FTBarCode'],
                'FTFhnRefCode'      => $paData['FTFhnRefCode'],
                'FNBarRefSeq'       => $paData['FNBarRefSeq'],
                'FTPlcCode'         => $paData['FTPlcCode'],
                'FTBarStaUse'       => $paData['FTBarStaUse'],
                'FTBarStaAlwSale'   => $paData['FTBarStaAlwSale'],
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
            );

            $this->db->insert('TCNMPdtBar', $aDataBarCode);

            if($this->db->affected_rows() > 0){
                $aStatus   = array(
                    'reCode'    => '1',
                    'rtDesc'    => 'Add Master Success',
                );
            }else{
                $aStatus = array(
                    'rtCode'    => '905',
                    'rtDesc'    => 'Error Cannot Add MAster',
                );
            }

         }else{
            $aStatus = array(
                'rtCode'    => '800',
                'rtDesc'    => 'Bar Code Is Dup',
            );

         }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
        }catch(Exception $Error){
            return $Error;
        } 
    }

    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaMPFHGetPdtColorMaxSeq($paData){
    try{

        $tPdtCode  = $paData['FTPdtCode'];
        $tFhnRefCode  = $paData['FTFhnRefCode'];


        $tSQL ="SELECT
                    PDTCLR.FTPdtCode,
                    MAX (PDTCLR.FNFhnSeq) AS FNFhnSeq
                FROM
                    TFHMPdtColorSize PDTCLR
                WHERE
                    PDTCLR.FTPdtCode = '$tPdtCode'
                --AND PDTCLR.FTFhnRefCode = '$tFhnRefCode'
                GROUP BY
                    PDTCLR.FTPdtCode
                    --PDTCLR.FTFhnRefCode 
        ";
        $oQuery = $this->db->query($tSQL);
           if ($oQuery->num_rows() > 0) {
               $aResult    =  array(
                   'rnFhnSeq'      => $oQuery->row_array()['FNFhnSeq'],
                   'rtCode'    => '1',
                   'rtDesc'    => 'success'
               );
           } else {
               $aResult =  array(
                   'rnFhnSeq'  => 0,
                   'rtCode'    => '800',
                   'rtDesc'    => 'data not found'
               );
           }
           return $aResult;
        }catch(Exception $Error){
            return $Error;
        } 
    }


    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaMPFHCheckPdtUnitFactB4RemoveData($paData){
        try{

            $tPdtCode  = $paData['FTPdtCode'];
            $tFhnRefCode  = $paData['FTFhnRefCode'];

            $tSQL = "SELECT
                        PDTPACK.FTPdtCode,
                        PDTPACK.FTPunCode,
                        PDTPACK.FCPdtUnitFact
                        FROM TCNMPdtPackSize PDTPACK WITH(NOLOCK)
                        WHERE PDTPACK.FTPunCode IN (
                                SELECT
                                PDTBar.FTPunCode
                                FROM TCNMPdtBar PDTBar
                                WHERE PDTBar.FTPdtCode = '$tPdtCode'
                                AND PDTBar.FTFhnRefCode!='$tFhnRefCode' 
                                GROUP BY PDTBar.FTPunCode
                            )
                        AND PDTPACK.FTPdtCode = '$tPdtCode'
                        AND PDTPACK.FCPdtUnitFact = 1
                        ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                $aResult    =  array(
                    'rtCode'    => '1',
                    'rtDesc'    => 'success'
                );
            } else {
                $aResult =  array(
                    'rtCode'    => '800',
                    'rtDesc'    => 'data not found'
                );
            }
            return $aResult;
        }catch(Exception $Error){
            return $Error;
        } 
    }


    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaMPFHInsertPackSize($paData){
        try{
            $nNumRowPdtPackSize = $this->db->where('FTPdtCode',$paData['FTPdtCode'])->where('FTPunCode',$paData['FTPunCode'])->get('TCNMPdtPackSize')->num_rows();
            if($nNumRowPdtPackSize==0){
 
            $this->db->insert('TCNMPdtPackSize', $paData);

            if($this->db->affected_rows() > 0){
                $aStatus   = array(
                    'reCode'    => '1',
                    'rtDesc'    => 'Add Master Success',
                );
            }else{
                $aStatus = array(
                    'rtCode'    => '905',
                    'rtDesc'    => 'Error Cannot Add MAster',
                );
            }

            }else{
            $aStatus = array(
                'rtCode'    => '800',
                'rtDesc'    => 'Bar Code Is Dup',
            );

            }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
        }catch(Exception $Error){
            return $Error;
        } 
        
    }

   //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function  FSaMPFHClearPackSizeNotUse($paData){
        try{
            $tPdtCode  = $paData['FTPdtCode'];
            $tFhnRefCode  = $paData['FTFhnRefCode'];

            $tSQL ="DELETE FROM TCNMPdtPackSize WHERE FTPdtCode = '$tPdtCode' AND FTPunCode NOT IN (
                SELECT
                    PDTBar.FTPunCode
                FROM
                    TCNMPdtBar PDTBar
                WHERE
                    PDTBar.FTPdtCode = '$tPdtCode'
                AND PDTBar.FTFhnRefCode != '$tFhnRefCode'
                GROUP BY
                    PDTBar.FTPunCode
                )";

            if($this->db->affected_rows() > 0){
                $aStatus   = array(
                    'reCode'    => '1',
                    'rtDesc'    => 'Add Master Success',
                );
            }else{
                $aStatus = array(
                    'rtCode'    => '905',
                    'rtDesc'    => 'Error Cannot Add MAster',
                );
            }

        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
        }catch(Exception $Error){
            return $Error;
        } 
    }


    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function  FSaMPFHUpdateBarCodeOnUnit($paData){
        try{

            $tPdtCode  = $paData['FTPdtCode'];
       
            $tSQL ="INSERT INTO TCNMPdtBar (
                        FTPdtCode,
                        FTBarCode,
                        FTPunCode,
                        FNBarRefSeq,
                        FTFhnRefCode,
                        FTBarStaUse,
                        FTBarStaAlwSale,
                        FDLastUpdOn,
                        FTLastUpdBy,
                        FDCreateOn,
                        FTCreateBy
                    )
                    SELECT
                        PDTPACK.FTPdtCode,
                        PDTPACK.FTPdtCode + PDTPACK.FTPunCode AS FTBarCode,
                        PDTPACK.FTPunCode,
                        (SELECT TOP 1 FNFhnSeq FROM TFHMPdtColorSize WHERE FTPdtCode = '$tPdtCode'  ORDER BY FDCreateOn DESC) AS FNBarRefSeq,
                        (SELECT TOP 1 FTFhnRefCode FROM TFHMPdtColorSize WHERE FTPdtCode = '$tPdtCode'  ORDER BY FDCreateOn DESC) AS FTFhnRefCode,
                        1 AS FTBarStaUse,
                        2 AS FTBarStaUse,
                        '' AS FDLastUpdOn,
                        '' AS FTLastUpdBy,
                        '' AS FDCreateOn,
                        '' AS FTCreateBy
                    FROM TCNMPdtPackSize PDTPACK WITH(NOLOCK)
                    WHERE FTPdtCode = '$tPdtCode' 
                    AND FTPunCode NOT IN (
                            SELECT
                                PDTBar.FTPunCode
                            FROM
                                TCNMPdtBar PDTBar
                            WHERE
                                PDTBar.FTPdtCode = '$tPdtCode'
                            GROUP BY
                                PDTBar.FTPunCode
                            )
                      ";
            $oQuery = $this->db->query($tSQL);
            if($this->db->affected_rows() > 0){
                $aStatus   = array(
                    'reCode'    => '1',
                    'rtDesc'    => 'Add Master Success',
                );
            }else{
                $aStatus = array(
                    'rtCode'    => '905',
                    'rtDesc'    => 'Error Cannot Add MAster',
                );
            }

        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
        }catch(Exception $Error){
            return $Error;
        } 
    }



    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSvMPFHCheckModelNo($tFhnPdtModelNo,$tPdtCode){
        try{
    
            $oQuery =  $this->db->where('FTFhnModNo',$tFhnPdtModelNo)->where('FTPdtCode !=',$tPdtCode)->get('TFHMPdtFhn');
            if ($oQuery->num_rows() > 0) {
                $aResult    =  array(
                    'rtCode'    => '1',
                    'rtDesc'    => 'Data ModelNo Duplicate'
                );
            } else {
                $aResult =  array(
                    'rtCode'    => '800',
                    'rtDesc'    => 'data not found'
                );
            }
            return $aResult;
        }catch(Exception $Error){
            return $Error;
        } 
    }

}