<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCustomerLicense extends CI_Model {

    /**
     * Functionality : Search UsrDepart By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMCSTSearchByID($ptAPIReq, $ptMethodReq, $paData){
        $tCstCode   = $paData['FTCstCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT
                            CST.FTCstCode               AS rtCstCode,
                            CST.FTCstCardID             AS rtCstCardID,
                            CST.FDCstDob                AS rtCstDob,
                            CST.FTCstSex                AS rtCstSex,
                            CST.FTCstBusiness           AS rtCstBusiness,
                            CST.FTCstTaxNo              AS rtCstTaxNo,
                            CST.FTCstStaActive          AS rtCstStaActive,
                            CST.FTCstEmail              AS rtCstEmail,
                            CST.FTCstTel                AS rtCstTel,
                            CSTL.FTCstName              AS rtCstName,
                            CSTL.FTCstRmk               AS rtCstRmk,
                            CST.FTCgpCode               AS rtCstCgpCode,
                            CSTGL.FTCgpName             AS rtCstCgpName,
                            CST.FTCtyCode               AS rtCstCtyCode,
                            CSTTL.FTCtyName             AS rtCstCtyName,
                            CST.FTClvCode               AS rtCstClvCode,
                            CSTLevL.FTClvName           AS rtCstClvName,
                            CST.FTOcpCode               AS rtCstOcpCode,
                            CSTOL.FTOcpName             AS rtCstOcpName,
                            CST.FTPplCodeRet            AS rtCstPplCodeRet,
                            CST.FTPplCodeWhs            AS rtCstPplCodeWhs,
                            PDTPriLWhs.FTPplName        AS rtCstPplNameWhs,
                            CST.FTPplCodenNet           AS rtPplCodeNet,
                            PDTPriLNet.FTPplName        AS rtPplNameNet,
                            PDTPriL.FTPplName           AS rtCstPplNameRet,
                            CST.FTPmgCode               AS rtCstPmgCode,
                            PDTPmtGL.FTPmgName          AS rtCstPmgName,
                            CST.FTCstDiscRet            AS rtCstDiscRet,
                            CST.FTCstDiscWhs            AS rtCstDiscWhs,
                            CST.FTCstBchHQ              AS rtCstBchHQ,
                            CST.FTCstBchCode            AS rtCstBchCode,
                            BCHL.FTBchName              AS rtCstBchName,
                            CST.FTCstStaAlwPosCalSo     AS rtCstStaAlwPosCalSo,
                            IMGP.FTImgObj               AS rtImgObj,
                            AGN_L.FTAgnCode             AS FTAgnCode,
                            AGN_L.FTAgnName             AS FTAgnName
                        FROM [TCNMCst] CST WITH(NOLOCK)
                        LEFT JOIN [TCNMAgency_L] AGN_L WITH(NOLOCK) ON CST.FTAgnCode = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                        LEFT JOIN [TCNMCst_L]  CSTL WITH(NOLOCK) ON CST.FTCstCode = CSTL.FTCstCode AND CSTL.FNLngID = $nLngID
                        LEFT JOIN [TCNMCstGrp_L] CSTGL WITH(NOLOCK) ON CSTGL.FTCgpCode = CST.FTCgpCode AND CSTGL.FNLngID = $nLngID
                        LEFT JOIN [TCNMCstType_L] CSTTL WITH(NOLOCK) ON CSTTL.FTCtyCode = CST.FTCtyCode AND CSTTL.FNLngID = $nLngID
                        LEFT JOIN [TCNMCstLev_L] CSTLevL WITH(NOLOCK) ON CSTLevL.FTClvCode = CST.FTClvCode AND CSTLevL.FNLngID = $nLngID
                        LEFT JOIN [TCNMCstOcp_L] CSTOL WITH(NOLOCK) ON CSTOL.FTOcpCode = CST.FTOcpCode AND CSTOL.FNLngID = $nLngID
                        LEFT JOIN [TCNMPdtPriList_L] PDTPriL WITH(NOLOCK) ON PDTPriL.FTPplCode = CST.FTPplCodeRet AND PDTPriL.FNLngID = $nLngID
                        LEFT JOIN [TCNMPdtPriList_L] PDTPriLWhs WITH(NOLOCK) ON PDTPriLWhs.FTPplCode = CST.FTPplCodeWhs AND PDTPriLWhs.FNLngID = $nLngID
                        LEFT JOIN [TCNMPdtPriList_L] PDTPriLNet WITH(NOLOCK) ON PDTPriLNet.FTPplCode = CST.FTPplCodenNet AND PDTPriLNet.FNLngID = $nLngID
                        LEFT JOIN [TCNMPdtPmtGrp_L] PDTPmtGL WITH(NOLOCK) ON PDTPmtGL.FTPmgCode = CST.FTPmgCode AND PDTPmtGL.FNLngID = $nLngID
                        LEFT JOIN [TCNMBranch_L]  BCHL WITH(NOLOCK) ON CST.FTCstBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                        LEFT JOIN [TCNMImgPerson] IMGP WITH(NOLOCK) ON IMGP.FTImgRefID = CST.FTCstCode AND IMGP.FNImgSeq = 1
                        WHERE 1=1
        ";
        if($tCstCode!= ""){
            $tSQL .= "AND CST.FTCstCode = '$tCstCode'";
        }
        $oQuery = $this->db->query($tSQL);



        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();

            $aResult = array(
                'raItems'       => @$oDetail[0],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
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


    /**
     * Functionality : List department
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCSTList($ptAPIReq, $ptMethodReq, $paData){
    	// return null;
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $tSQL     = "SELECT c.* FROM(
                    SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC, rtCstCode ASC) AS rtRowID,*
                        FROM
                        (SELECT DISTINCT
                            CST.FTCstCode AS rtCstCode,
                            CST.FTCstEmail AS rtCstEmail,
                            CST.FTCstTel AS rtCstTel,
                            CSTL.FTCstName AS rtCstName,
                            CSTL.FTCstRmk AS rtCstRmk,
                            CSTGL.FTCgpName AS rtCgpName,
                            IMGP.FTImgObj AS rtImgObj,
                            CST.FDCreateOn
                        FROM [TCNMCst] CST
                        LEFT JOIN [TCNMCst_L]  CSTL ON CST.FTCstCode = CSTL.FTCstCode AND CSTL.FNLngID = $nLngID
                        LEFT JOIN [TCNMCstGrp] CSTG ON CSTG.FTCgpCode = CST.FTCgpCode
                        LEFT JOIN [TCNMCstGrp_L] CSTGL ON CSTGL.FTCgpCode = CST.FTCgpCode AND CSTGL.FNLngID = $nLngID
                        LEFT JOIN [TCNMImgPerson] IMGP ON IMGP.FTImgRefID = CST.FTCstCode
                        WHERE 1=1";

        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            $tSQL .= " AND (CST.FTCstCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR CSTL.FTCstName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR CSTGL.FTCgpName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR CST.FTCstEmail COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR CST.FTCstCardID COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR CST.FTPplCodeRet COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR CST.FTPplCodeWhs COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR CST.FTCstTel COLLATE THAI_BIN LIKE '%$tSearchList%')";
        }

        //ค้นหาตัวแทนขายของตัวเอง
        $tAgnCode = $this->session->userdata("tSesUsrAgnCode");
        if($tAgnCode != ""){
            $tSQL .= "AND CST.FTAgnCode = '$tAgnCode'";
        }

        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCSTGetPageAll(/*$tWhereCode,*/ $tSearchList, $nLngID);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paData['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            //No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"=> 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }

        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /**
     * Functionality : All Page Of Customer
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMCSTGetPageAll(/*$ptWhereCode,*/ $ptSearchList, $ptLngID){
        $tSQL = "SELECT COUNT (CST.FTCstCode) AS counts
                FROM [TCNMCst] CST
                LEFT JOIN [TCNMCst_L]  CSTL ON CST.FTCstCode = CSTL.FTCstCode AND CSTL.FNLngID = $ptLngID
                LEFT JOIN [TCNMCstGrp] CSTG ON CSTG.FTCgpCode = CST.FTCgpCode
                LEFT JOIN [TCNMCstGrp_L] CSTGL ON CSTGL.FTCgpCode = CST.FTCgpCode AND CSTGL.FNLngID = $ptLngID
                LEFT JOIN [TCNMImgPerson] IMGP ON IMGP.FTImgRefID = CST.FTCstCode
                WHERE 1=1 ";

        if($ptSearchList != ''){
            $tSQL .= " AND (CST.FTCstCode COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= " OR CSTL.FTCstName COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= " OR CSTGL.FTCgpName COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= " OR CST.FTCstCardID COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= " OR CST.FTPplCodeRet COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= " OR CST.FTPplCodeWhs COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= " OR CST.FTCstEmail COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= " OR CST.FTCstTel COLLATE THAI_BIN LIKE '%$ptSearchList%')";
        }

        //ค้นหาตัวแทนขายของตัวเอง
        $tAgnCode = $this->session->userdata("tSesUsrAgnCode");
        if($tAgnCode != ""){
            $tSQL .= "AND CST.FTAgnCode = '$tAgnCode'";
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
     * Functionality : Update Sale Person
     * Parameters : $paData is data
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : response
     * Return Type : array
     */
    public function FSaMCSTAddUpdateMaster($paData){

        try{
            // Update Master
            $this->db->set('FTCstTel', $paData['FTCstTel']);
            $this->db->set('FTCstEmail', $paData['FTCstEmail']);
            $this->db->set('FTCstCardID', $paData['FTCstCardID']);
            $this->db->set('FDCstDob', $paData['FDCstDob']);
            $this->db->set('FTCstSex', $paData['FTCstSex']);
            $this->db->set('FTCstBusiness', $paData['FTCstBusiness']);
            $this->db->set('FTCstTaxNo', $paData['FTCstTaxNo']);
            $this->db->set('FTCstStaActive', $paData['FTCstStaActive']);
            $this->db->set('FTCstStaAlwPosCalSo', $paData['FTCstStaAlwPosCalSo']);
            $this->db->set('FTCgpCode', $paData['FTCgpCode']);
            $this->db->set('FTCtyCode', $paData['FTCtyCode']);
            $this->db->set('FTClvCode', $paData['FTClvCode']);
            $this->db->set('FTOcpCode', $paData['FTOcpCode']);
            $this->db->set('FTPplCodeRet', $paData['FTPplCodeRet']);
            $this->db->set('FTPplCodeWhs', $paData['FTPplCodeWhs']);   // รหัสกลุ่มราคา สำหรับ ขายส่ง
            $this->db->set('FTPplCodenNet', $paData['FTPplCodenNet']); // รหัสกลุ่มราคา สำหรับ ขายผ่าน Web
            $this->db->set('FTPmgCode', $paData['FTPmgCode']);
            $this->db->set('FTCstDiscRet', $paData['FTCstDiscRet']);
            $this->db->set('FTCstDiscWhs', $paData['FTCstDiscWhs']);
            $this->db->set('FTCstBchHQ', $paData['FTCstBchHQ']);
            $this->db->set('FTCstBchCode', $paData['FTCstBchCode']);
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->set('FTAgnCode' , $paData['FTAgnCode']);
            $this->db->where('FTCstCode', $paData['FTCstCode']);
            $this->db->update('TCNMCst');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                // Add Master
                $this->db->insert('TCNMCst',array(
                    'FTCstCode'             => $paData['FTCstCode'],
                    'FTCstTel'              => $paData['FTCstTel'],
                    'FTCstEmail'            => $paData['FTCstEmail'],
                    'FTCstCardID'           => $paData['FTCstCardID'],
                    'FDCstDob'              => $paData['FDCstDob'],
                    'FTCstSex'              => $paData['FTCstSex'],
                    'FTCstBusiness'         => $paData['FTCstBusiness'],
                    'FTCstTaxNo'            => $paData['FTCstTaxNo'],
                    'FTCstStaActive'        => $paData['FTCstStaActive'],
                    'FTCstStaAlwPosCalSo'   => $paData['FTCstStaAlwPosCalSo'],
                    'FTCgpCode'             => $paData['FTCgpCode'],
                    'FTCtyCode'             => $paData['FTCtyCode'],
                    'FTClvCode'             => $paData['FTClvCode'],
                    'FTOcpCode'             => $paData['FTOcpCode'],
                    'FTPplCodeRet'          => $paData['FTPplCodeRet'],
                    'FTPplCodeWhs'          => $paData['FTPplCodeWhs'],   // รหัสกลุ่มราคา สำหรับ ขายส่ง
                    'FTPplCodenNet'         => $paData['FTPplCodenNet'], // รหัสกลุ่มราคา สำหรับ ขายผ่าน Web
                    'FTPmgCode'             => $paData['FTPmgCode'],
                    'FTCstDiscRet'          => $paData['FTCstDiscRet'],
                    'FTCstDiscWhs'          => $paData['FTCstDiscWhs'],
                    'FTCstBchHQ'            => $paData['FTCstBchHQ'],
                    'FTCstBchCode'          => $paData['FTCstBchCode'],
                    'FTAgnCode'             => $paData['FTAgnCode'],
                    'FDCreateOn'            => $paData['FDCreateOn'],
                    'FTCreateBy'            => $paData['FTCreateBy']
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

    /**
     * Functionality : Update Lang Sale Person
     * Parameters : $paData is data for update
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMCSTAddUpdateLang($paData){
        try{
            // Update Lang
            $this->db->set('FTCstName', $paData['FTCstName']);
            $this->db->set('FTCstRmk', $paData['FTCstRmk']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTCstCode', $paData['FTCstCode']);
            $this->db->update('TCNMCst_L');
            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{ // Add Lang
                $this->db->insert('TCNMCst_L',array(
                    'FTCstCode' => $paData['FTCstCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTCstName' => $paData['FTCstName'],
                    'FTCstRmk'  => $paData['FTCstRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    /**
     * Functionality : Update Customer Master
     * Parameters : $paData is data
     * Creator : 25/09/2018 piya
     * Last Modified : -
     * Return : response
     * Return Type : array
     */
    public function FSaMCSTUpdateDateMaster($paData){
        try{
            // Update Master
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->where('FTCstCode', $paData['FTCstCode']);
            $this->db->update('TCNMCst');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Date Master Success',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

      /**
     * Functionality : FSnMCSTGetAmtActive
     * Parameters : $paData
     * Creator : 01/04/2020 Nale
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FScMCSTGetAmtActive($ptCstCode){
      $tCgpCode   = $this->db->where('FTSysCode','AMQMember')->where('FTSysSeq',1)->get('TSysConfig')->row_array()['FTSysStaUsrValue'];
      $cTxnBuyTotal = $this->db->where('FTCgpCode',$tCgpCode)->where('FTMemCode',$ptCstCode)->get('TCNTMemAmtActive')->row_array()['FCTxnBuyTotal'];
      return $cTxnBuyTotal;
    }

    /**
     * Functionality : FSnMCSTGetAmtActive
     * Parameters : $paData
     * Creator : 01/04/2020 Nale
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FScMCSTGetPntActive($ptCstCode){
        $tCgpCode   = $this->db->where('FTSysCode','AMQMember')->where('FTSysSeq',1)->get('TSysConfig')->row_array()['FTSysStaUsrValue'];
        $cTxnPntQty = $this->db->where('FTCgpCode',$tCgpCode)->where('FTMemCode',$ptCstCode)->get('TCNTMemPntActive')->row_array()['FCTxnPntQty'];
        return $cTxnPntQty;
      }

          /**
     * Functionality : FScMCSTGetPntExp
     * Parameters : $paData
     * Creator : 01/04/2020 Nale
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FScMCSTGetPntExp($ptCstCode){
        $tCgpCode   = $this->db->where('FTSysCode','AMQMember')->where('FTSysSeq',1)->get('TSysConfig')->row_array()['FTSysStaUsrValue'];
        $cTxnPnt2ExpYear = $this->db->where('FTCgpCode',$tCgpCode)->where('FTMemCode',$ptCstCode)->get('TCNTMemPntActive')->row_array()['FCTxnPnt2ExpYear'];
        return $cTxnPnt2ExpYear;
      }


     /**
     * Functionality : FScMCSTGetPntExp
     * Parameters : $paData
     * Creator : 01/04/2020 Nale
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
      public function FSaMCLNGetDataExport($ptCstCode){
        try{
            $tSQL = "SELECT
                        CSTREGIS.FTRegBusName,
                        CSTREGIS.FNRegQtyBch,
                        CST.FTCstEmail,
                        CST.FTCstTel,
                        CSTREGIS.FTRegRefCst,
                        SRVP.FTSrvStaCenter,
                        SRVP.FTSrvRefSBUrl
                        FROM TRGMCstRegis CSTREGIS
                        LEFT OUTER JOIN TCNMCst CST ON CSTREGIS.FTRegRefCst = CST.FTCstCode
                        LEFT OUTER JOIN (
                                SELECT
                                    SRV.FTSrvStaCenter,SRV.FTSrvRefSBUrl,CSTB.FNCbrSeq,CSTB.FTCstCode
                                    FROM TRGMCstBch CSTB
                                    INNER JOIN TRGMPosSrv SRV ON CSTB.FTSrvCode = SRV.FTSrvCode
                        ) SRVP ON CSTREGIS.FTRegRefCst = SRVP.FTCstCode AND SRVP.FNCbrSeq = 1
                        WHERE CSTREGIS.FTRegRefCst ='$ptCstCode'
                    ";

                $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0){
                $oDetail = $oQuery->row_array();

                $aResult = array(
                    'raItems'       => @$oDetail,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                );
            }else{
                //Not Found
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'data not found.',
                );
            }
            return $aResult;
        }catch(Exception $Error){
            return $Error;
        }

      }

}
