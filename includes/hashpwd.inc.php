<?php 

$sensitiveData ="Robert";

$salt = bin2hex(random_bytes(16)); // Generate random salt

$pepper = "ASecretPaperString";

$dataToHash = $sensitiveData . $salt .$pepper;

$hash = hash("sha256", $dataToHash);

echo "<br>" . $hash;

$sensitiveData = "Salas";
$storedHash = $hash;
$pepper = "ASecretPapperString";
$dataToHash = $sensitiveData . $salt .$pepper;

$verificationHash = hash("sha256", $dataToHash);

echo '<br>'. $verificationHash;

if($storedHash === $verificationHash){

    echo "The Data are the same!";

}else{
    echo "The Data are not the same";
}
