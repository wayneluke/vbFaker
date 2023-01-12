<?php

$core='/volumes/secondary/sites/vbulletin/forum/core/';

$log_errors=TRUE;

if ($log_errors) {
    unlink('./error_log.txt');
    error_reporting(E_ALL); // Error/Exception engine, always use E_ALL
    ini_set('ignore_repeated_errors', TRUE); // always use TRUE
    ini_set('display_errors', TRUE); // Error/Exception display, use FALSE only in production environment or real server. Use TRUE in development environment
    ini_set('log_errors', TRUE); // Error/Exception file logging engine.
    ini_set('error_log', './error_log.txt'); // Logging file path
}