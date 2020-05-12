<?php

class CStringEncDec {
    /*
     * 
     * new
     */

    const encrypt_method = "AES-256-CBC";
    const secret_key = 'aasksoft123';
    const secret_iv = 'aasksoft1iv';

    function encdata($message) {
//        $output = false;
//        $key = hash('sha256', self::secret_key);
//        $iv = substr(hash('sha256', self::secret_iv), 0, 16);
//        $output = openssl_encrypt($message, self::encrypt_method, $key, 0, $iv);
//        $output = base64_encode($output);
//        return $output;
        return $message;
    }

    function decdata($message) {
//        $output= false;
//        $key = hash('sha256', self::secret_key);
//        $iv = substr(hash('sha256', self::secret_iv), 0, 16);
//        $output = openssl_decrypt(base64_decode($message), self::encrypt_method, $key, 0, $iv);
//        return $output;
        return $message;
    }

    public function encTxt($message) {
        $output = false;
        $key = hash('sha256', self::secret_key);
        $iv = substr(hash('sha256', self::secret_iv), 0, 16);
        $output = openssl_encrypt($message, self::encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
        // return $message;
    }

    public function decTxt($message) {
        $output = false;
        $key = hash('sha256', self::secret_key);
        $iv = substr(hash('sha256', self::secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($message), self::encrypt_method, $key, 0, $iv);
        return $output;
        //   return $message;
    }

}

/* $obj = new CStringEncDec();

  echo "whore<br>";
  $data = $obj->encdata("kishor");
  echo $data . "<br>";
  echo $obj->decdata($data); */
?>