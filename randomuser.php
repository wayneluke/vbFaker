<?php

function get_first_row($query) {
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Execute query
    $result = $conn->query($query);
    
    // Get first row
    $row = $result->fetch_assoc();
    
    // Close connection
    $conn->close();
    
    // Return first row
    return $row;
}


// Example usage
$query = "SELECT userid, username, usergroupid FROM USER WHERE usergroupid IN (2,14,15) ORDER BY RAND() LIMIT 1";
$first_row = get_first_row($query);

// Display first row
print_r($first_row);
