<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mSwitchLang extends CI_Model {

    public function FSaMGetFiledName($ptTableMaster){
        $aFieldAll      = $this->db->field_data($ptTableMaster);
        $aField         = array();
        foreach ($aFieldAll as $tField){   
            array_push($aField , $tField->name);
        }
        return $aField;
    }

    public function FSaMGetSystemLang(){
        $tSQL = "SELECT * FROM TSysLanguage";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result_array();
        }else{
            $oDetail = '';
        }
        return $oDetail;
    }

    //Insert
    public function FSaMInsertLang($paPackData){
        $tFiledPK       = $paPackData['FiledPK'];
        $tPK            = $paPackData['PK'];
        $nLang          = $paPackData['nLang'];
        $tTable         = $paPackData['tTable'];
        $tFiled         = $paPackData['tFiled'];
        $tValue         = $paPackData['tValue'];

        $aInsData = array(
            $tFiledPK   => $tPK,
            $nLang      => $nLang,
            $tFiled     => $tValue
        );
        $this->db->insert($tTable, $aInsData);

    }
}