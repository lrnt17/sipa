<?php

function generateAccessCode($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $accessCode = '';

    $max = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $accessCode .= $characters[random_int(0, $max)];
    }

    $accessCode = strtoupper($accessCode); // Convert letters to uppercase

    return $accessCode;
}
$verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
// Example usage:
$accessCode = generateAccessCode();
echo $verification_code;

?>
