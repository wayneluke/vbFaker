<?php
<?php

// The location of your vBulletin Core directory.
$core='/volumes/secondary/sites/vbulletin/core/';

// The following values are used to retrieve a random user for posting content.

$DB['servername'] = "localhost";  // replace with your MySQL server name
$DB['username'] = "dbadmin";     // replace with your MySQL username
$DB['password'] = "6BHgyl2iLaEjlxkpL0GY";     // replace with your MySQL password
$DB['dbname'] = "vb5_forum";  // replace with your MySQL database name

$log_errors=TRUE;

///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////
// Do Not Edit Below...
///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

if ($log_errors) {
    if (file_exists('./error_log.txt')) { 
        unlink('./error_log.txt');
    }
    error_reporting(E_ALL); // Error/Exception engine, always use E_ALL
    ini_set('ignore_repeated_errors', TRUE); // always use TRUE
    ini_set('display_errors', TRUE); // Error/Exception display, use FALSE only in production environment or real server. Use TRUE in development environment
    ini_set('log_errors', TRUE); // Error/Exception file logging engine.
    ini_set('error_log', './error_log.txt'); // Logging file path
}
