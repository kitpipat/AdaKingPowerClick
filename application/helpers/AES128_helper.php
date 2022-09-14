<?php

    //Functionality: AES128 Encrypt
    //Parameters:  PlainText, Key, IV
    //Creator: 13/01/2020 Napat (Jame)
    //Last Modified :
    //Return : Encrypt Text
    //Return Type: Text
    function FCNtHAES128Encrypt($ptPlainText){

        require_once('application\modules\authen\assets\vendor\AES128\cAES128.php');
        include('application\modules\authen\assets\vendor\AES128\AESKeyIV.php');

        $oAES = new CAES128;
        return $oAES->C_CALtEncrypt($ptPlainText,$tKey,$tIV);

    }

    //Functionality: AES128 Decrypt
    //Parameters:  PlainText, Key, IV
    //Creator: 13/01/2020 Napat (Jame)
    //Last Modified :
    //Return : Decrypt Text
    //Return Type: Text
    function FCNtHAES128Decrypt($ptEncryptedText){

        require_once('application\modules\authen\assets\vendor\AES128\cAES128.php');
        include('application\modules\authen\assets\vendor\AES128\AESKeyIV.php');

        $oAES = new CAES128;
        return $oAES->C_CALtDecrypt($ptEncryptedText,$tKey,$tIV);

    }

?>