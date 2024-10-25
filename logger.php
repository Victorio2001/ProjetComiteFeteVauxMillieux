<?php

function log_access($message) {
    $logFile = __DIR__ . '/access.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "$timestamp - $message\n", FILE_APPEND);
}
?>

