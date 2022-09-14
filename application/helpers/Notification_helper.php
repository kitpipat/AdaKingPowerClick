<?php

    //Functionality: Notifications (กระดิ่ง)
    // Create By Witsarut 03/03/2020
    function FCNxHNotifications(){
        $ci = &get_instance();
        $ci->load->database();

        $tMessageAlert = language('common/main/main', 'tMessageAlert');

        $oOnclick = "JSxEventClickNotiRead()";
        $tNotifications = '<li id="oliContainer" >';
        $tNotifications .='<div id="odvCntMessage"></div>';
        //$tNotifications .='< button id="obtNotibtn" class="dropdown-toggle" data-toggle="dropdown" style="color: white;margin-top: 10px;margin-right:30px;" onclick="'.$oOnclick.'">';
        //$tNotifications .='<img hidden src="application/modules/common/assets/images/icons/Bell.png" alt="AdaFC Logo" class="img-responsive logo" style="padding:5px;width:30px;">';
        //$tNotifications .='</button >';
        $tNotifications .='<div id="odvNotiMessageAlert">';
        $tNotifications .='<div class="xCNMessageAlert">'.$tMessageAlert.'</div>';
        $tNotifications .='<div id="odvMessageShow" style="height:350px;  overflow-y: scroll;"></div>';
        $tNotifications .='<div class="xCNShwAllMessage"></div>';
        $tNotifications .='</div>';
        $tNotifications .= '</li>';

        echo $tNotifications;
    }


    //Functionality: Mapping เอกสารหา รหัส NotID
    // Create By Witsarut 03/03/2020
    function FCNtHNotiGetNotiIDByDocRef($tDocRef){
        $ci = &get_instance();
        $ci->load->database();
        $aDataNotiDoc = $ci->session->userdata("aDataNotiDoc");
        $tNotID = '';
        if(!empty($aDataNotiDoc)){
            foreach($aDataNotiDoc as $aData){
                if(!empty($aData['FTNotDocRef'])){
                    if($aData['FTNotDocRef']==$tDocRef){
                        $tNotID = $aData['FTNotID'];
                        break;
                    }
                }
            }
        }else{
            $tNotID = '';
        }
        return $tNotID;
    }

    //Functionality: Notifications (กระดิ่ง)
    // Create By Witsarut 03/03/2020
    function FCNxHNotiNumRows(){
        $ci = &get_instance();
        $ci->load->database();
        $aDataNotiDoc = $ci->session->userdata("aDataNotiDoc");
        $aDataNotiDoc4Read = array();
        if(!empty($aDataNotiDoc)){
            foreach($aDataNotiDoc as $aData){
                    if($aData['FTStaRead']!='1'){
                        $aDataNotiDoc4Read[$aData['FTNotID']] = 1;
                    }
            }
        }else{
            $aDataNotiDoc4Read = array();
        }
        $ci->session->set_userdata("aDataNotiDoc4Read",$aDataNotiDoc4Read);

        $aDataNotiNews = $ci->session->userdata("aDataNotiNews");
        $aDataNotiNews4Read = array();
        if(!empty($aDataNotiNews)){
            foreach($aDataNotiNews as $aData){
                    if($aData['FTStaRead']!='1'){
                        $aDataNotiNews4Read[$aData['FTNotID']] = 1;
                    }
            }
        }else{
            $aDataNotiNews4Read = array();
        }
        $ci->session->set_userdata("aDataNotiNews4Read",$aDataNotiNews4Read);

    }

?>
