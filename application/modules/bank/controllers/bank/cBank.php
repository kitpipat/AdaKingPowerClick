<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class cBank extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('bank/bank/mBank');
        date_default_timezone_set("Asia/Bangkok");
        // Test XSS Load Helper Security
        // $this->load->helper("security");
        // if ($this->security->xss_clean($this->input->post(), TRUE) === FALSE){
        //     echo "ERROR XSS Filter";
        // }
    }

    //ฟังก์ชั่นหลัก
    public function index($nBnkBrowseType, $tBnkBrowseOption){
        $nMsgResp = array('title' => "bank");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if (!$isXHR) {
            $this->load->view('common/wHeader', $nMsgResp);
            $this->load->view('common/wTopBar', array('nMsgResp' => $nMsgResp));
            $this->load->view('common/wMenu', array('nMsgResp' => $nMsgResp));
        }
        $vBtnSave           = FCNaHBtnSaveActiveHTML('bankindex/0/0');
        $this->load->view('bank/bank/wBank', array(
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nBnkBrowseType'    => $nBnkBrowseType,
            'tBnkBrowseOption'  => $tBnkBrowseOption,
            'aAlwEventBank'	    => FCNaHCheckAlwFunc('bankindex/0/0')
        ));
    }

    public function FSvCBNKListPage(){
        $aAlwEventBank	    = FCNaHCheckAlwFunc('bankindex/0/0');
        $this->load->view('bank/bank/wBankList', array(
            'aAlwEventBank' => $aAlwEventBank
        ));
    }

    //Datatable
    public function FSvCBNKDataTable(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');
            $nLangEdit      = $this->session->userdata("tLangEdit");

            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll
            );

            $aBnkDataList     = $this->mBank->FSaMBNKList($aData);

            $aAlwEventBank	    = FCNaHCheckAlwFunc('bankindex/0/0');
            $aGenTable  = array(
                'aBnkDataList'      => $aBnkDataList,
                'nPage'             => $nPage,
                'tSearchAll'        => $tSearchAll,
                'aAlwEventBank'     => $aAlwEventBank
            );

            $this->load->view('bank/bank/wBankDataTable', $aGenTable);

        }catch(Exception $Error){
            echo $Error;
        }
    }

    //หน้าจอเพิ่มข้อมูล
    public function FSvCBNKPageAdd(){
        $this->load->view('bank/bank/wBankAdd');
    }

    //หน้าจอแก้ไขข้อมูล
    public function FSvCBNKEditPage(){
        try{
            $aData = array(
                'tBnkCode'    => $this->input->post('tBnkCode'),
                'nLangResort' => $this->session->userdata("tLangID"),
                'nLangEdit'   =>  $this->session->userdata("tLangEdit")
            );

            $aBnkData   = $this->mBank->FSaMBnkGetDataByID($aData);
            $aData      = array(
                'nStaAddOrEdit' => 1,
                'aBnkData'      => $aBnkData,
                'tImgObjAll'    => $aBnkData['raItems']['rtBnkImage'],
            );
            $this->load->view('bank/bank/wBankAdd', $aData);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Form : Tab 1
    public function FSvCBNKPInfomationTab1(){
        try{
            $aData = array(
                'tBnkCode'    => $this->input->post('tBnkCode'),
                'nLangResort' => $this->session->userdata("tLangID"),
                'nLangEdit'   => $this->session->userdata("tLangEdit")
            );

            $aBnkData   = $this->mBank->FSaMBnkGetDataByID($aData);

            if (isset($aBnkData['raItems']['rtBnkImage'])) {
                $tBnkImage = $aBnkData['raItems']['rtBnkImage'];
            }else {
                $tBnkImage ="";
            }
            $aData   = array(
                'nStaAddOrEdit' => 1,
                'aBnkData'      => $aBnkData,
                'tImgObjAll'    => $tBnkImage,
            );

            $this->load->view('bank/bank/wBankInfo1', $aData);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Event Add : Tab 1
    public function FSoCBNKAddEvent(){
        try{
            /** ==================== Input Image Data ==================== */
            $tImgInputBank      = $this->input->post('oetImgInputBank');
            $tImgInputBankOld   = $this->input->post('oetImgInputBankOld');
            /** ==================== Input Image Data ==================== */

            $tBnkCodeOld      = $this->input->post('oetBnkCodeOld');

            $aDataMaster = array(
                'tBnkCodeOld'   => $tBnkCodeOld,
                'FTBnkCode'     => $this->input->post('oetBnkCode'),
                'FTBnkName'     => $this->input->post('oetBnkName'),
                // 'FTBnkRefExt'   => $this->input->post('oetBnkRefIN'),
                'FTBnkRmk'      => $this->input->post('otaBnkRmk'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTAgnCode'     => $this->input->post('oetBNKUsrAgnCode'),
            );

            $oCountDup  = $this->mBank->FSnMBNKCheckDuplicate($aDataMaster['FTBnkCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if($nStaDup == 0){
                $this->db->trans_begin();
                $aStaEventMaster  = $this->mBank->FSaMBNKAddUpdateMaster($aDataMaster);
                $aStaEventLang    = $this->mBank->FSaMBNKAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event 1"
                    );
                }else{
                    $this->db->trans_commit();
                    if($tImgInputBank != $tImgInputBankOld){
                        $aImageData = [
                            'tModuleName'       => 'bank',
                            'tImgFolder'        => 'bank',
                            'tImgRefID'         => $this->input->post('oetBnkCode'),
                            'tImgObj'           => $tImgInputBank,
                            'tImgTable'         => 'TFNMBank',
                            'tTableInsert'      => 'TCNMImgObj',
                            'tImgKey'           => 'main',
                            'dDateTimeOn'       => date('Y-m-d H:i:s'),
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 1
                        ];
                        $aImgReturn = FCNnHAddImgObj($aImageData);
                    }

                    $aReturn = array(
                        'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTBnkCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Event'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => language('bank/bank/bank', 'tBnkDataDupicate')
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Event Edit : Tab 1
    public function FSoCBNKEditEvent(){
        try{
            $this->db->trans_begin();

            /** ==================== Input Image Data ==================== */
            $tImgInputBank      = $this->input->post('oetImgInputBank');
            $tImgInputBankOld   = $this->input->post('oetImgInputBankOld');
            /** ==================== Input Image Data ==================== */

            $tBnkCodeOld      = $this->input->post('oetBnkCodeOld');

            $aDataMaster = array(
                'tBnkCodeOld'   => $tBnkCodeOld,
                'FTBnkCode'     => $this->input->post('oetBnkCode'),
                'FTBnkName'     => $this->input->post('oetBnkName'),
                'FTBnkRmk'      => $this->input->post('otaBnkRmk'),
                // 'FTBnkRefExt'   => $this->input->post('oetBnkRefIN'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTAgnCode'     => $this->input->post('oetBNKUsrAgnCode'),
            );

            $this->mBank->FSaMBNKAddUpdateMaster($aDataMaster);
            $this->mBank->FSaMBNKAddUpdateLang($aDataMaster);
            $this->mBank->FSaMBNKAddImgObj($aDataMaster);
            $this->mBank->FSaMBNKUpdateInstallment($aDataMaster);

            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit Product Brand"
                );
            }else{
                $this->db->trans_commit();

                if($tImgInputBank != $tImgInputBankOld){
                    $aImageUplode = array(
                        'tModuleName'       => 'bank',
                        'tImgFolder'        => 'bank',
                        'tImgRefID'         => $aDataMaster['FTBnkCode'],
                        'tImgObj'           => $tImgInputBank,
                        'tImgTable'         => 'TFNMBank',
                        'tTableInsert'      => 'TCNMImgObj',
                        'tImgKey'           => 'main',
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1
                    );
                    $aImgReturn = FCNnHAddImgObj($aImageUplode);
                }
                $aReturn = array(
                    'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTBnkCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit Product Brand'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Event Delete
    public function FSoCBNKDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTBnkCode' => $tIDCode
        );
        $aResDel    = $this->mBank->FSaMBNKDelAll($aDataMaster);
        $nNumRowBnk = $this->mBank->FSnMBNKGetAllNumRow();

        if($nNumRowBnk!==false){
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc'],
                'nNumRowBnk' => $nNumRowBnk
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }
    }

    //////////////////////////////////////*************************///////////////////////////////////////

    //Form : Tab 2
    public function FSvCBNKAddPageTable2(){
        try{
            $aData = array(
                'tBnkCode'    => $this->input->post('tBnkCode'),
                'nLangResort' => $this->session->userdata("tLangID"),
                'nLangEdit'   => $this->session->userdata("tLangEdit")
            );

            $aBnkData  = $this->mBank->FSaMBnkGetDataInfo2ByID($aData);

            $aData   = array(
                'tBnkCode'      => $this->input->post('tBnkCode'),
                'nStaAddOrEdit' => 1,
                'aBnkData'      => $aBnkData
            );
            $this->load->view('bank/bank/installment/wBankInfoTable2',$aData);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Form : Tab 2
    public function FSvCBNKAddInfo2(){
        try{
            $aDataWhere = array(
                'nStmSeq'     => $this->input->post('nStmSeq'),
                'tBnkCode'    => $this->input->post('tBnkCode'),
                'nLangResort' => $this->session->userdata("tLangID"),
                'nLangEdit'   =>  $this->session->userdata("tLangEdit")
            );

            $aBnkData   = $this->mBank->FSaMBnkGetDataEditInfo2ByID($aDataWhere);
            $aData      = array(
                'nStaAddOrEdit' => 1,
                'aBnkData'      => $aBnkData,
                'tBnkCode'      => $this->input->post('tBnkCode'),
            );
            $this->load->view('bank/bank/installment/wBankAddInfo2',$aData);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Event Add : Tab 2
    public function FSoCBNKAddEventInfo2(){
      try{
          $aStmSeq = $this->mBank->FSaMBNKGetStmSeq($this->input->post('oetBnkCodeInfo2'));
          if ($aStmSeq['rtCode']=="800") {
            $nStmSeq = "1";
          }else {
            $nStmSeq = intval($aStmSeq['raItems']['FNStmSeq'])+1;
          }
          if ($this->input->post('oetBnkStmSeq') !='') {
            $nStmSeq = $this->input->post('oetBnkStmSeq');
          }

          $aDataMaster = array(
              'FTBnkCode'      => $this->input->post('oetBnkCodeInfo2'),
              'FNStmSeq'       => $nStmSeq,
              'FTStmName'      => $this->input->post('oetBnkStmName'),
              'FCStmLimit'     => ($this->input->post('oetBnkStmLimit') == '') ? '0' : $this->input->post('oetBnkStmLimit'),
              'FCStmQty'       => ($this->input->post('oetBnkStmQty') == '') ? '0' : $this->input->post('oetBnkStmQty'),
              'FTStmStaUnit'   => $this->input->post('ocmBnkStmStaUnit'),
              'FCStmRate'      => ($this->input->post('oetBnkStmRate') == '') ? '0' : $this->input->post('oetBnkStmRate')
          );
          $oCountDup  = $this->mBank->FSnMBNKInfo2CheckDuplicate($aDataMaster['FTBnkCode'],$aDataMaster['FTStmName'],$nStmSeq);
          $nStaDup    = $oCountDup[0]->counts;
          if($nStaDup == 0){
              $this->db->trans_begin();
              $this->mBank->FSaMBNKInfo2AddUpdateMaster($aDataMaster);
              if($this->db->trans_status() === false){
                  $this->db->trans_rollback();
                  $aReturn = array(
                      'nStaEvent'    => '900',
                      'tStaMessg'    => "Unsucess Add Event 1"
                  );
              }else{
                  $this->db->trans_commit();
                  $aReturn = array(
                      'tCodeReturn'	=> $aDataMaster['FNStmSeq'],
                      'nStaEvent'	    => '1',
                      'tStaMessg'		=> 'Success Add Event'
                  );
              }
          }else{
              $aReturn = array(
                  'nStaEvent'    => '801',
                  'tStaMessg'    => language('bank/bank/bank', 'tBnkDataDupicateInfo2')
              );
          }
          echo json_encode($aReturn);
      }catch(Exception $Error){
          echo $Error;
      }
    }

    //Event Delete : Tab 2
    public function FSoCBNKDeleteInfo2Event(){
        $nStmSeq    = $this->input->post('nStmSeq');
        $tBnkCode   = $this->input->post('tBnkCode');
        $aDataMaster = array(
            'FNStmSeq'    => $nStmSeq,
            'FTBnkCode'   => $tBnkCode
        );
        $aResDel    = $this->mBank->FSaMBNKDelAllInfo2($aDataMaster);

        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
      }

}
