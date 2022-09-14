<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mAgency extends CI_Model {

    public $nAgrID;

    // หาจำนวนช่วงของข้อมูลแต่ละหน้า
    private function FCNMaAGECallLenData($pnPerPage = 10, $pnPage) {
        $nPerPage = $pnPerPage; // Per Page

        if (isset($pnPage)) {
            $nPage = $pnPage;
        } else {
            $nPage = 1;
        }

        $nRowStart = (($nPerPage * $nPage) - $nPerPage);

        $nRowEnd = $nPerPage * $nPage;

        $aLenData = array(
            $nRowStart,
            $nRowEnd
        );
        return $aLenData;
    }

    // ลบรูป edit Agency
    public function FSxMAGNDelImg($aData) {
        $this->db->where('FTImgRefID', $aData ['FTImgRefID']);
        $this->db->where('FTImgTable', $aData ['FTImgTable']);
        $this->db->delete('TCNMImgPerson');
        if ($this->db->affected_rows() > 0) {
            Return 1;
        } else {
            Return 0;
        }
    }

    public function FSnMAGNDel($nAgnID) {
        // print_r($nAgnID);
        $tSQL = "SELECT COUNT(FTAgnKeyAPI) AS count
        FROM TCNMAgency
        WHERE FTAgnCode = '$nAgnID'";
        $query = $this->db->query($tSQL);
        $oResult = $query->result();
        if ($oResult [0]->count != 0) {
            $this->db->where('FTAgnCode', $nAgnID);
            $this->db->delete('TCNMAgency');
    
            $this->db->where('FTAgnCode', $nAgnID);
            $this->db->delete('TCNMAgency_L');
    
            $this->db->where('FTImgRefID', $nAgnID);
            // $this->db->where('FTImgType', TTKMAgency);
            $this->db->delete('TCNMImgPerson');

            return 1;
        } else {
            return 0;
        }

    }

    public function FSxMAGNAddAgency($aData, $aDataAgnList_L) {
        // TTKMAgency
        print_r($aData);
        $this->db->insert('TCNMAgency', $aData);
        // TTKMAgency_L
        $this->db->insert('TCNMAgency_L', array(
            'FTAgnCode' => $aDataAgnList_L ['FTAgnCode'],
            'FNLngID' => $this->session->userdata("tLangEdit"),
            'FTAgnName' => $aDataAgnList_L ['FTAgnName']
        ));
        return $aDataAgnList_L ['FTAgnCode'];
    }

    public function FSxMAGNEditAgency($nAgnID, $aData, $tAgnName) {
        $this->db->where('FTAgnCode', $nAgnID);
        $this->db->update('TCNMAgency', $aData);
        $nChk = FSnCheckUpdateLang('TCNMAgency_L', 'FTAgnCode', $nAgnID);
        // if(isset($nChk [0]->counts) && !empty($nChk [0]->counts)){
        if ($nChk[0]->counts == 0) {
            $this->db->insert('TCNMAgency_L', array(
                'FTAgnCode' => $nAgnID,
                'FTAgnName' => $tAgnName,
                'FNLngID' => $this->session->userdata("tLangEdit")
            ));
        } else {
            $this->db->where('FTAgnCode', $nAgnID);
            $this->db->where('FNLngID', $this->session->userdata("tLangEdit"));
            $this->db->update('TCNMAgency_L', array('FTAgnName' => $tAgnName
            ));
        }
            return 1;
        }
     
    

    public function FSxMAGNEditPwd($aData) {
        $this->db->where('FTAgnCode', $aData ['FTAgnCode']);
        $this->db->update('TCNMAgency', array(
            'FTAgnPwd' => $aData ['FTAgnPwd']
        ));
    }

    public function FSxMAGNEditImg($aImgData) {
        $this->db->where('FNImgRefID', $aImgData ['FNImgRefID']);
        $this->db->where('FTImgType', $aImgData ['FTImgType']);
        $tDB = $this->db->update('TCNMImgPerson', array(
            'FTImgObj' => $aImgData ['FTImgObj'],
            'FNImgSeq' => $aImgData ['FNImgSeq']
        ));

        if ($this->db->affected_rows() > 0) {
            
        } else {
            $aData = array(
                'FNImgRefID' => $aImgData ['FNImgRefID'],
                'FTImgType' => $aImgData ['FTImgType'],
                'FNImgSeq' => $aImgData ['FNImgSeq'],
                'FTImgObj' => $aImgData ['FTImgObj']
            );
            $this->db->insert('TCNMImgPerson', $aData);
        }
    }

    public function FStMAAGNGetAgnGroup() {
        $tSQL = "  SELECT AGN.FTAggCode,AGNL.FTAggName
                   FROM TCNMAgencyGrp AGN
                   LEFT JOIN TCNMAgencyGrp_L AGNL ON AGNL.FTAggCode = AGN.FTAggCode AND AGNL.FNLngID = " . $this->session->userdata("tLangEdit") . "";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FStMAAGNGetAgnTy() {
        $tSQL = "  SELECT TY.FTAtyCode, TYL.FTAtyName
		   FROM TCNMAgencyType TY
		   LEFT JOIN TCNMAgencyType_L TYL ON TYL.FTAtyCode = TY.FTAtyCode AND TYL.FNLngID = " . $this->session->userdata("tLangEdit") . "";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    // ดึงข้อมูล Package List
    public function FSaMGetEditAgn($nAngID) {
        $tSQL = "SELECT c.* FROM(SELECT ROW_NUMBER() OVER(ORDER BY AGN.FTAgnCode DESC) AS RowID,
                 	AGN.FTAgnCode,
			AGNL.FTAgnName,
                        FTAgnKeyAPI,
                        FTAgnPwd,
                        FTAgnEmail,
                        FTAgnTel,
                        FTAgnFax,
                        FTAgnMo,
                        FTAgnRmk,
                        FTAgnStaApv,
                        FTAgnStaActive,
                        FTAtyCode,
                        FTAggCode,
                        IMP.FNImgID,
                        IMP.FTImgObj,
                        IMP.FTImgRefID      			
                      FROM TCNMAgency AGN
             	      LEFT JOIN TCNMAgency_L AGNL ON AGNL.FTAgnCode = AGN.FTAgnCode AND AGNL.FNLngID = " . $this->session->userdata("tLangEdit") . "
             	      LEFT JOIN TCNMImgPerson IMP ON IMP.FTImgRefID = AGN.FTAgnCode AND IMP.FTImgTable = 'TTKMAgency'
             		  WHERE 1=1 
             	      AND AGN.FTAgnCode = $nAngID
             	      ) AS c ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    // ดึงข้อมูล Agency
    // public function FSaMAGNList($tAgencyEmailFilter='',$tAgencyNameFilter='',$tAgencyStaFilter='',$nPageNo=1){
    public function FSaMAGNList($tAgnName, $nPageActive) {
        $aRowLen = $this->FCNMaAGECallLenData(8, $nPageActive); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
        $tSQLtAgnName = '';
        if ($tAgnName != '') {
            $tSQLtAgnName = " AND (AGNL.FTAgnName LIKE '%$tAgnName%')";
        }
        $tSQL = "SELECT c.* FROM(SELECT ROW_NUMBER() OVER(ORDER BY AGN.FTAgnCode DESC) AS RowID,
                             AGN.FTAgnCode,
			                 AGNL.FTAgnName,
                             FTAgnEmail,
                             FTAgnTel,
                             CASE FTAgnStaApv
	                             WHEN '1' THEN 'อนุม้ติแล้ว'
	                             WHEN '2' THEN 'ยังไม่'
                             ELSE 'ไม่ระบุ' END AS  FTAgnStaApvText,
                             FTAgnStaApv,
                             IMP.FTImgRefID,
             				 IMP.FTImgObj,
             		    				(SELECT COUNT (DISTINCT AGN.FTAgnCode) AS c FROM TCNMAgency AGN
	    									LEFT JOIN TCNMAgency_L AGNL ON AGNL.FTAgnCode = AGN.FTAgnCode AND AGNL.FNLngID = " . $this->session->userdata("tLangEdit") . "
             	      						LEFT JOIN TCNMImgPerson IMP ON IMP.FTImgRefID = AGN.FTAgnCode AND IMP.FTImgTable = 'TTKMAgency'
	    									WHERE 1 = 1 $tSQLtAgnName 
                                        ) AS counts
                            
                      FROM TCNMAgency AGN
             	      LEFT JOIN TCNMAgency_L AGNL ON AGNL.FTAgnCode = AGN.FTAgnCode AND AGNL.FNLngID = " . $this->session->userdata("tLangEdit") . "
             	      LEFT JOIN TCNMImgPerson IMP ON IMP.FTImgRefID = AGN.FTAgnCode AND IMP.FTImgTable = 'TTKMAgency'
             		  WHERE 1=1 ";
        // if ($tAgencyEmailFilter != '') {
        // $tSQL.=" AND FTAgnEmail LIKE '%$tAgencyEmailFilter%'";
        // }
        if ($tAgnName != '') {
            $tSQL .= " AND FTAgnName LIKE '%$tAgnName%'";
        }
        // if ($tAgencyStaFilter !='') {
        // $tSQL.=" AND FTAgnStaApv = '$tAgencyStaFilter'";
        // }
        $tSQL .= " ) AS c ";
        $tSQL .= " WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1]";
        // echo $tSQL;
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }
    
    public function FStMAGECount($tAgnName) {
        $tSQL = "SELECT COUNT(AG.FTAgnCode) AS counts
		FROM TCNMAgency AS AG
        	LEFT JOIN TCNMAgency_L AS AGL ON AGL.FTAgnCode = AG.FTAgnCode AND AGL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
        	";
        if ($tAgnName != '') {
            $tSQL .= " WHERE AGL.FTAgnName LIKE '%$tAgnName%'";
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }
    

    // บันทึกข้อมูลหลัก Agency
    public function FSxMAGESaveAgency($paData) {
        $a = $this->db->insert('TCNMAgency', $paData);
        if ($a) {
            return 'Success';
        } else {
            return 'Fail';
        }
    }

    // ดึงข้อมูล API ฟีทเจอร์ ทั้งหมด
    public function FSaMAGEAPIFeatuer() {
        $tSQL = "SELECT
                            dbo.TSysAPI2Ticket.FNApiID,
                            dbo.TSysAPI2Ticket.FTApiClass,
                            dbo.TSysAPI2Ticket.FTApiMethod,
                            dbo.TSysAPI2Ticket.FTApiDesc,
                            dbo.TSysAPI2Ticket.FTApiStaActive
                 FROM  dbo.TSysAPI2Ticket";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    // ลบข้อมูลสิทธิ์ API ของ Agency
    public function FSaMAGDelEAPIFeatuer($ptAgenId) {
        $this->db->where('FTAgnKeyAPI', $ptAgenId);
        $this->db->delete('TCNMAgencyAPI');
    }

    public function FSaMAGSaveEAPIFeatuer($paData) {
        if ($this->db->insert('TCNMAgencyAPI', $paData)) {
            return 'Success';
        } else {
            return 'Fail';
        }
    }

    public function FSxMAGEGetAPIFuncAcc($ptAgenId) {
        $tSQL = "SELECT FNAgaApiRef
                      FROM   TCNMAgencyAPI
                      WHERE  FTAgnKeyAPI = '$ptAgenId' ";
        // echo $tSQL;
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }

        // $this->db->select("FTAgaRefApi");
        // $this->db->where("FNAgaID", $ptAgenId);
        // $query = $this->db->get("TTKMAgencyAPI",1,0);
        //
		// if($query->num_rows() > 0) {
        // $variable = $query->row("FTApiCode");
        // return $variable;
        // } else {
        // return FALSE;
        // }
    }

    // Update Agency
    public function FSxMAGEEdit($paData) {
        $this->db->where('FTAgnCode', $paData ['tAgencyId']);
        $this->db->update('TCNMAgency', array(
            'FTAgnSubDist' => $paData ['tAgencySubDistric'],
            'FTDstCode' => $paData ['tAgencyDistric'],
            'FTPvnCode' => $paData ['tAgencyProvince'],
            'FTAgnEmail' => $paData ['tAgencyEmail'],
            'FTAgnTel' => $paData ['tAgencyTel'],
            'FTAgnStaApv' => $paData ['nAgenApv']
        ));
    }

    // public function FSxMAGEDelete($pnAgcID) {
    //     $this->db->where('FTAgnCode', $pnAgcID);
    //     $this->db->delete('TCNMAgency');
    // }

    public function FSxMAGEDelete($ptAgenId) {
        $tSQL = "SELECT COUNT(FTAgnCode) AS count
		FROM TCNMAgency
		WHERE FTAgnCode = '$ptAgenId'";
        $query = $this->db->query($tSQL);
        $oResult = $query->result();
        if ($oResult [0]->count != 0) {
            $this->db->where('FTAgnCode', $ptAgenId);
            $this->db->delete('TCNMAgency');

            $this->db->where('FTAgnCode', $ptAgenId);
            $this->db->delete('TCNMAgency_L');

            $this->db->where('FTImgRefID', $ptAgenId);
            $this->db->delete('TCNMImgPerson');


            return 1;
        } else {
            return 0;
        }
    }



    public function FSxMUsrPvlHD() {
        $this->db->select('*');
        $this->db->from('TTKMGrpAlwHD');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * * กลุ่มตัวแทน **
     */
    public function FSxMAGEGroupAjaxList($tFTAggName, $nPageNo = 1) {
        $aRowLen = $this->FCNMaAGECallLenData(8, $nPageNo); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
        $tSQL = "SELECT c.FTAggName ,c.FTAggCode, RowID FROM(
				 SELECT ROW_NUMBER() OVER(ORDER BY GRP.FTAggCode DESC) AS RowID,
						GRP.*,
	        			GRPL.FTAggName
				 FROM TCNMAgencyGrp AS GRP
        		 LEFT JOIN TCNMAgencyGrp_L AS GRPL ON GRPL.FTAggCode = GRP.FTAggCode AND GRPL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
        		";
        if ($tFTAggName != '') {
            $tSQL .= " WHERE GRPL.FTAggName LIKE '%$tFTAggName%'";
        }
        $tSQL .= ") AS c WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1] ORDER BY c.FTAggCode DESC";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FStMAGEGroupCount($tFTAggName) {
        $tSQL = "SELECT COUNT(GRP.FTAggCode) AS counts
				 FROM TCNMAgencyGrp AS GRP
        		 LEFT JOIN TCNMAgencyGrp_L AS GRPL ON GRPL.FTAggCode = GRP.FTAggCode AND GRPL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
        		";
        if ($tFTAggName != '') {
            $tSQL .= " WHERE GRPL.FTAggName LIKE '%$tFTAggName%'";
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMAGEGroupDelete($nFTAggCode) {
        $tSQL = "SELECT COUNT(FTAggCode) AS count
		FROM TCNMAgency
		WHERE FTAggCode = '$nFTAggCode'";
        $query = $this->db->query($tSQL);
        $oResult = $query->result();
        if ($oResult [0]->count == 0) {
            $this->db->where('FTAggCode', $nFTAggCode);
            $this->db->delete('TCNMAgencyGrp');
            $this->db->where('FTAggCode', $nFTAggCode);
            $this->db->delete('TCNMAgencyGrp_L');
            return 1;
        } else {
            return 0;
        }
    }

    public function FSxMAGEGroupAddAjax($aData) {
        $this->db->insert('TCNMAgencyGrp', array(
            'FTAggCode' => $aData['FTAggCode'],
            'FTCreateBy' => $this->session->userdata("tSesUsername"),
            'FDCreateOn' => date('Y-m-d h:i')
        ));
        $this->db->insert('TCNMAgencyGrp_L', array(
            'FTAggCode' => $aData['FTAggCode'],
            'FTAggName' => $aData ['FTAggName'],
            'FNLngID' => $this->session->userdata("tLangEdit")
        ));
    }

    public function FSxMAGEGroupEditAjax($aData) {
        $nChk = FSnCheckUpdateLang('TCNMAgencyGrp_L', 'FTAggCode', $aData ['FTAggCode']);
        $this->db->where('FTAggCode', $aData ['FTAggCode']);
        $this->db->update('TCNMAgencyGrp', array(
            'FTLastUpdBy' => $this->session->userdata("tSesUsername"),
            'FDLastUpdOn' => date('Y-m-d h:i')
        ));
        if ($nChk [0]->counts == 0) {
            $this->db->insert('TCNMAgencyGrp_L', array(
                'FTAggCode' => $aData ['FTAggCode'],
                'FTAggName' => $aData ['FTAggName'],
                'FNLngID' => $this->session->userdata("tLangEdit")
            ));
        } else {
            $this->db->where('FTAggCode', $aData ['FTAggCode']);
            $this->db->where('FNLngID', $this->session->userdata("tLangEdit"));
            $this->db->update('TCNMAgencyGrp_L', array(
                'FTAggName' => $aData ['FTAggName']
            ));
        }
    }

    public function FSxMAGEGroupEdit($nFTAggCode) {
        $tSQL = "SELECT GRP.*, GRPL.FTAggName
				 FROM TCNMAgencyGrp AS GRP
        		 LEFT JOIN TCNMAgencyGrp_L AS GRPL ON GRPL.FTAggCode = GRP.FTAggCode AND GRPL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
              	 WHERE GRP.FTAggCode = '$nFTAggCode'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMAGEAuthen($nGadRefID) {
        $tSQL = "SELECT FTGadStaAlwR, FTGadStaAlwW, FTGadStaAlwDel, FTGadStaAlwApv FROM TTKMGrpAlwDT WHERE FTGadType = '1' AND FNGadRefID = '$nGadRefID' AND FNGahID = '" . $this->session->userdata("FNGahID") . "'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMAGNCheckEmail($tEmail) {
        $this->db->select('FTAgnEmail');
        $this->db->from('TCNMAgency');
        $this->db->where('FTAgnEmail', $tEmail);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return 'false';
        } else {
            return 'true';
        }
    }

    public function FSxMAGERCV() {
        $tSQL = "SELECT RCV.FTRcvCode, RCVL.FTRcvName
		FROM TSysRcvFmt AS FMT
                INNER JOIN TFNMRcv AS RCV ON RCV.FTFmtCode = FMT.FTFmtCode
        	LEFT JOIN TFNMRcv_L AS RCVL ON RCVL.FTRcvCode = RCV.FTRcvCode AND RCVL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
        	WHERE RCV.FTRcvStaUse = '1'
        		 ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMAGEAgencyRcv($tAgnCode) {
        $tSQL = "SELECT AGR.FTRcvCode 
                 FROM TCNMAgency AG
                --  LEFT JOIN TTKMAgencyRcv AGR ON AGR.FTAgnKeyAPI = AG.FTAgnKeyAPI
                 WHERE AG.FTAgnCode = '$tAgnCode'
                ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }
    

    public function FSxMAGEAgencyRcvDel($nAgnID) {
        $tSQL = "SELECT FTAgnKeyAPI FROM TCNMAgency WHERE FTAgnCode = '$nAgnID' ";
        $oQuery = $this->db->query($tSQL);
        $oResult = $oQuery->result();        
        if(isset($oResult[0]->FTAgnKeyAPI) && !empty($oResult[0]->FTAgnKeyAPI)){
            $this->db->where('FTAgnKeyAPI', $oResult[0]->FTAgnKeyAPI);
            $this->db->delete('TTKMAgencyRcv');
        }
    }


    // public function FSxMAGNAddRCV($aData) {
    //     $tSQL = "SELECT FTAgnKeyAPI FROM TCNMAgency WHERE FTAgnCode = '" . $aData ['FTAgnCode'] . "'";
    //     $oQuery = $this->db->query($tSQL);
    //     $oResult = $oQuery->result();
    //     if ($this->db->insert('TTKMAgencyRcv', array(
    //                 'FTRcvCode' => $aData ['FTRcvCode'],
    //                 'FTAgnKeyAPI' => $oResult[0]->FTAgnKeyAPI
    //             ))) {
    //         return 'Success';
    //     } else {
    //         return 'Fail';
    //     }
    // }

    public function FSxMAGNEditRCV($aData) {
        $tSQL = "SELECT FTAgnKeyAPI FROM TCNMAgency WHERE FTAgnCode = '" . $aData['FTAgnCode'] . "'";
        $oQuery = $this->db->query($tSQL);
        $oResult = $oQuery->result();
        if ($this->db->insert('TTKMAgencyRcv', array(
                    'FTRcvCode' => $aData ['FTRcvCode'],
                    'FTAgnKeyAPI' => $oResult[0]->FTAgnKeyAPI
                ))) {
            return 'Success';
        } else {
            return 'Fail';
        }
    }

    /**
     * * กลุ่มตัวแทน **
     */
    public function FSxMAGETypeAjaxList($tFTAtyName, $nPageNo = 1) {
        $aRowLen = $this->FCNMaAGECallLenData(8, $nPageNo); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
        $tSQL = "SELECT c.FTAtyName ,c.FTAtyCode, RowID FROM(
		SELECT ROW_NUMBER() OVER(ORDER BY TY.FTAtyCode DESC) AS RowID,
		TY.*,
	        TYL.FTAtyName
		FROM TCNMAgencyType AS TY
        	LEFT JOIN TCNMAgencyType_L AS TYL ON TYL.FTAtyCode = TY.FTAtyCode AND TYL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
        		";
        if ($tFTAtyName != '') {
            $tSQL .= " WHERE TYL.FTAtyName LIKE '%$tFTAtyName%'";
        }
        $tSQL .= ") AS c WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1] ORDER BY c.FTAtyCode DESC";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FStMAGETypeCount($tFTAtyName) {
        $tSQL = "SELECT COUNT(TY.FTAtyCode) AS counts
		FROM TCNMAgencyType AS TY
        	LEFT JOIN TCNMAgencyType_L AS TYL ON TYL.FTAtyCode = TY.FTAtyCode AND TYL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
        	";
        if ($tFTAtyName != '') {
            $tSQL .= " WHERE TYL.FTAtyName LIKE '%$tFTAtyName%'";
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMAGETypeDelete($nFTAtyCode) {
        $tSQL = "SELECT COUNT(FTAtyCode) AS count
		 FROM TCNMAgency
		 WHERE FTAtyCode = '$nFTAtyCode'";
        $query = $this->db->query($tSQL);
        $oResult = $query->result();
        if ($oResult [0]->count == 0) {
            $this->db->where('FTAtyCode', $nFTAtyCode);
            $this->db->delete('TCNMAgencyType');
            $this->db->where('FTAtyCode', $nFTAtyCode);
            $this->db->delete('TCNMAgencyType_L');
            return 1;
        } else {
            return 0;
        }
    }

    public function FSxMAGETypeAddAjax($aData) {
        $this->db->insert('TCNMAgencyType', array(
            'FTAtyCode' => $aData['FTAtyCode'],
            'FTCreateBy' => $this->session->userdata("tSesUsername"),
            'FDCreateOn' => date('Y-m-d h:i')
        ));
        $this->db->insert('TCNMAgencyType_L', array(
            'FTAtyCode' => $aData['FTAtyCode'],
            'FTAtyName' => $aData ['FTAtyName'],
            'FNLngID' => $this->session->userdata("tLangEdit")
        ));
    }

    public function FSxMAGETypeEditAjax($aData) {
        $nChk = FSnCheckUpdateLang('TCNMAgencyType_L', 'FTAtyCode', $aData ['FTAtyCode']);
        $this->db->where('FTAtyCode', $aData ['FTAtyCode']);
        $this->db->update('TCNMAgencyType', array(
            'FTLastUpdBy' => $this->session->userdata("tSesUsername"),
            'FDLastUpdOn' => date('Y-m-d h:i')
        ));
        if ($nChk [0]->counts == 0) {
            $this->db->insert('TCNMAgencyType_L', array(
                'FTAtyCode' => $aData ['FTAtyCode'],
                'FTAtyName' => $aData ['FTAtyName'],
                'FNLngID' => $this->session->userdata("tLangEdit")
            ));
        } else {
            $this->db->where('FTAtyCode', $aData ['FTAtyCode']);
            $this->db->where('FNLngID', $this->session->userdata("tLangEdit"));
            $this->db->update('TCNMAgencyType_L', array(
                'FTAtyName' => $aData ['FTAtyName']
            ));
        }
    }

    public function FSxMAGETypeEdit($nFTAtyCode) {
        $tSQL = "SELECT TY.*, TYL.FTAtyName
		 FROM TCNMAgencyType AS TY
        	 LEFT JOIN TCNMAgencyType_L AS TYL ON TYL.FTAtyCode = TY.FTAtyCode AND TYL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
              	 WHERE TY.FTAtyCode = '$nFTAtyCode'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

}
