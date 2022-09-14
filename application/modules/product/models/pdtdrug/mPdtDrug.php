<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPdtDrug extends CI_Model {


     //Functionality : check Data Userlogin
    //Parameters : function parameters
    //Creator : 20/08/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMDrugCheckID($paData){
        try{
           
            $tPdtCode     = $paData['FTPdtCode'];
            $nLngID       = $paData['FNLngID'];

            $tSQL   = "SELECT
                            DRUG.FTPdtCode,
                            DRUG.FCPdgAge,
                            DRUG.FDPdgCreate,
                            DRUG.FDPdgExpired,
                            DRUG.FTPdgHowtoUse,
                            DRUG.FTPdgActIngredient,
                            DRUG.FTPdgProperties,
                            DRUG.FTPdgCtd,
                            DRUG.FTPdgWarn,
                            DRUG.FTPdgStopUse,
                            DRUG.FCPdgDoseSchedule,
                            DRUG.FCPdgMaxIntake,
                            DRUG.FTPdgBrandName,
                            DRUG.FTPdgGenericName,
                            DRUG.FTPdgCategory,
                            DRUG.FTPdgType,
                            DRUG.FTPdgRegNo,
                            DRUG.FTPdgStorage,
                            DRUG.FTPdgVolume,
                            DRUG.FTPdgForm,
                            -- DRUG.FTPdgCtrlRole,
                            DRUG.FTPdgManufacturer,
                            PUNL.FTPunName
                            -- ROLEL.FTRolName,
                            -- ROLEL.FTRolCode
                        FROM [TCNMPdtDrug] DRUG
                        LEFT JOIN [TCNMPdtUnit_L]  PUNL ON DRUG.FTPdgVolume = PUNL.FTPunCode AND PUNL.FNLngID = $nLngID
                        -- LEFT JOIN [TCNMUsrRole_L] ROLEL ON  DRUG.FTPdgCtrlRole = ROLEL.FTRolCode AND ROLEL.FNLngID = $nLngID
                        WHERE 1=1 AND DRUG.FTPdtCode = '$tPdtCode'";    
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


    //Functionality : Add PdtDrug
    //Parameters : function parameters
    //Creator : 13/10/2020 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function FSaMDrugAddUpdateMaster($paData){

        try{

            //ต้องไปอัพเดท วันที่ + เวลา ที่ตาราง TCNMPdt ว่ามีการเปลี่ยนแปลงด้วย
            $this->db->set('FDLastUpdOn',$paData['FDLastUpdOn']);
            $this->db->set('FTLastUpdBy',$paData['FTLastUpdBy']);
            $this->db->update('TCNMPdt');

            //Update Master
            $this->db->set('FCPdgAge'         ,$paData['FCPdgAge']);
            $this->db->set('FTPdgRegNo'       ,$paData['FTPdgRegNo']);
            $this->db->set('FTPdgGenericName' ,$paData['FTPdgGenericName']);
            $this->db->set('FTPdgBrandName'   ,$paData['FTPdgBrandName']);
            $this->db->set('FTPdgCategory'    ,$paData['FTPdgCategory']);
            $this->db->set('FTPdgType'        ,$paData['FTPdgType']);
            $this->db->set('FTPdgForm'        ,$paData['FTPdgForm']);
            $this->db->set('FTPdgVolume'      ,$paData['FTPdgVolume']);
            $this->db->set('FDPdgCreate'      ,$paData['FDPdgCreate']);
            $this->db->set('FDPdgExpired'     ,$paData['FDPdgExpired']);
            $this->db->set('FTPdgActIngredient',$paData['FTPdgActIngredient']);
            $this->db->set('FTPdgProperties'  ,$paData['FTPdgProperties']);
            $this->db->set('FTPdgHowtoUse'    ,$paData['FTPdgHowtoUse']);
            $this->db->set('FCPdgDoseSchedule',$paData['FCPdgDoseSchedule']);
            $this->db->set('FCPdgMaxIntake'   ,$paData['FCPdgMaxIntake']);
            $this->db->set('FTPdgCtd'         ,$paData['FTPdgCtd']);
            $this->db->set('FTPdgStopUse'     ,$paData['FTPdgStopUse']);
            $this->db->set('FTPdgStorage'     ,$paData['FTPdgStorage']);
            // $this->db->set('FTPdgCtrlRole'    ,$paData['FTPdgCtrlRole']);
            $this->db->set('FTPdgManufacturer',$paData['FTPdgManufacturer']);
            $this->db->set('FTPdgWarn'        ,$paData['FTPdgWarn']);
            $this->db->set('FDCreateOn'       ,$paData['FDCreateOn']);
            $this->db->set('FTLastUpdBy'      ,$paData['FTLastUpdBy']);
            $this->db->set('FTCreateBy'       ,$paData['FTCreateBy']);
            $this->db->set('FDLastUpdOn'      ,$paData['FDLastUpdOn']);
            $this->db->where('FTPdtCode'      ,$paData['FTPdtCode']);
            $this->db->update('TCNMPdtDrug');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            }else{
                $aResult = array(
                    'FTPdtCode'             => $paData['FTPdtCode'],
                    'FCPdgAge'              => $paData['FCPdgAge'], 
                    'FDPdgCreate'           => $paData['FDPdgCreate'],
                    'FDPdgExpired'          => $paData['FDPdgExpired'],
                    'FTPdgHowtoUse'         => $paData['FTPdgHowtoUse'],
                    'FTPdgActIngredient'    => $paData['FTPdgActIngredient'],
                    'FTPdgProperties'       => $paData['FTPdgProperties'],
                    'FTPdgCtd'              => $paData['FTPdgCtd'],
                    'FTPdgWarn'             => $paData['FTPdgWarn'],
                    'FTPdgStopUse'          => $paData['FTPdgStopUse'],
                    'FCPdgDoseSchedule'     => $paData['FCPdgDoseSchedule'],
                    'FCPdgMaxIntake'        => $paData['FCPdgMaxIntake'],
                    'FTPdgBrandName'        => $paData['FTPdgBrandName'],
                    'FTPdgGenericName'      => $paData['FTPdgGenericName'],
                    'FTPdgCategory'         => $paData['FTPdgCategory'],
                    'FTPdgType'             => $paData['FTPdgType'],
                    'FTPdgRegNo'            => $paData['FTPdgRegNo'],
                    'FTPdgStorage'          => $paData['FTPdgStorage'],
                    'FTPdgVolume'           => $paData['FTPdgVolume'],
                    'FTPdgForm'             => $paData['FTPdgForm'],
                    // 'FTPdgCtrlRole'         => $paData['FTPdgCtrlRole'],
                    'FTPdgManufacturer'     => $paData['FTPdgManufacturer'],
                    'FDLastUpdOn'           => $paData['FDLastUpdOn'],
                    'FTLastUpdBy'           => $paData['FTLastUpdBy'],
                    'FDCreateOn'            => $paData['FDCreateOn'],
                    'FTCreateBy'            => $paData['FTCreateBy'],
                );

                // Add Data Master
                $this->db->insert('TCNMPdtDrug',$aResult);

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
 
}