<?php

    //Functionality: Addfavorite
    //Parameters:  Function Parameter
    //Creator: 10/01/2020 Witsarut (Bell)
    //Last Modified :
    //Return : 
    //Return Type: Array
    function FCNxHADDfavorite($ptAddfavorit){
        $ci = &get_instance();
        $ci->load->database();
        $oOnclick = "JSxAddfavorit('$ptAddfavorit')";
        $tAddfavorite = '<li style="cursor:pointer;" onclick="'.$oOnclick.'"   >';
        $tAddfavorite .= '<img id="oimImgFavicon" style="cursor:pointer; margin-top: -10px;" width="20px;" height="20px;" src="application/modules/common/assets/images/icons/favorit.PNG">';
        $tAddfavorite .= '</li>';
        echo $tAddfavorite;
    }

?>