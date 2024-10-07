<?php 
function sanitizeData($input){
    $removedSpecialChar = trim ($input, "!@#$%^&*()=[]{};:`~'<>,./\?| "); 
    $removedSpecialCharinthemiddle= preg_replace('/[^a-zA-Z0-9\s\-ñÑ#]/u','', $removedSpecialChar);

    $sanatizedData=htmlspecialchars($removedSpecialCharinthemiddle, ENT_QUOTES, 'UTF-8'); 


    return $sanatizedData;

}
?>