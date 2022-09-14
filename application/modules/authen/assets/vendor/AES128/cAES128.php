<?php

class CAES128 {

	function __construct() {

	}
	public function C_CALtEncrypt($ptPlainText, $ptKey, $ptIV) {
		$tStrEncrypt = "";
		
		try {
			$ptKey = mb_convert_encoding($ptKey,"UTF-8");
			$ptIV = mb_convert_encoding($ptIV,"UTF-8");
			$tStrUTF8 = mb_convert_encoding($ptPlainText,"UTF-8");
			$tStrDataPad7 = $this->pad_PKCS7($tStrUTF8, 16);
			$tStrEncrypt = base64_encode(@mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $ptKey, $tStrDataPad7, MCRYPT_MODE_CBC, $ptIV));
		} catch (Exception $e) {
			
		}

		return $tStrEncrypt;
	}

	public function C_CALtDecrypt($ptEncryptedText, $ptKey, $ptIV) {
		$tStrDecrypt = "";
	
		try {
			// $ptKey = mb_convert_encoding($ptKey,"UTF-8");
			// $ptIV = mb_convert_encoding($ptIV,"UTF-8");
			// $tBase64Decode = base64_decode($ptEncryptedText);
			// $tStrDecrypt = $this->unpad_PKCS7(@mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $ptKey, $tBase64Decode, MCRYPT_MODE_CBC, $ptIV));

			// PHP 7.2
			// Create By : Napat(Jame) 20/07/2021
			// $ciphertext = 'zUl9he7HpH2HPtMj6XP24Q==';
			// $key =  '5YpPTypXtwMML$u@';
			// $iv =  'zNhQ$D%arP6U8waL';
			$tStrDecrypt = openssl_decrypt($ptEncryptedText, 'AES-128-CBC', $ptKey, 0, $ptIV);
				
		} catch(Exception $e) {
				
		}
	
		return $tStrDecrypt;
	}
	
	public static function pad_PKCS7($data, $block_size)
	{
		$padding = $block_size - (strlen($data) % $block_size);
		$pattern = chr($padding);
		return $data . str_repeat($pattern, $padding);
	}
	
	public static function unpad_PKCS7($data)
	{
		$pattern = substr($data, -1);
		$length = ord($pattern);
		$padding = str_repeat($pattern, $length);
		$pattern_pos = strlen($data) - $length;
	
		if(substr($data, $pattern_pos) == $padding)
		{
			return substr($data, 0, $pattern_pos);
		}
	
		return $data;
	}
}

?>