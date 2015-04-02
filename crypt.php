<?php

define('IV_SIZE', mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));
define('KEY','mysecretkey');

function encrypt ($payload) {
  $iv = mcrypt_create_iv(IV_SIZE, MCRYPT_DEV_URANDOM);
  $crypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, KEY, $payload, MCRYPT_MODE_CBC, $iv);
  $combo = $iv . $crypt;
  $garble = base64_encode($iv . $crypt);
  return $garble;
}

function decrypt ($garble) {
  $combo = base64_decode($garble);
  $iv = substr($combo, 0, IV_SIZE);
  $crypt = substr($combo, IV_SIZE, strlen($combo));
  $payload = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, KEY, $crypt, MCRYPT_MODE_CBC, $iv);
  return $payload;
}


//:::::::::::: TESTING ::::::::::::


$key = "secret-key-is-secret";
$payload = "In 1435 the church came into conflict with the townspeople of Bamberg and was plundered.";

// ENCRYPTION
$garble = encrypt($payload);

// DECRYPTION
$end_result = decrypt($garble);

// Outputting Results
echo "Encrypted: ", var_dump($garble), "<br/><br/>";
echo "Decrypted: ", var_dump($end_result);

?>