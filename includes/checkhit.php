<?php

declare(strict_types=1);

function check_for_hits(object $pdo, int $resident_id){
    $sqlquery="CALL CountResidentBlotterEntries(?)";
    $stmt = $pdo->prepare($sqlquery);
    $stmt->execute(array($resident_id));
    $count = $stmt->fetchColumn();

    return $count;
}