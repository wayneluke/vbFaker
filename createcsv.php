<?php

// require the autoloader to start Faker
require_once __DIR__ . '/vendor/autoload.php';

function createUser() {
    $faker = Faker\Factory::create($locale);

    $newUser['username'] = $faker->firstname . ' ' . $faker->lastname;
    $newUser['password'] = $faker->password;

    // encourage a mix of free email providers and random domains.
    $percentage = mt_rand (1,100);
    $emailType = $percentage < 60 ? 'freeEmailDomain' : 'domainName';
    $email = str_replace([' ', '\''],['.',''],$newUser['username']) . '@' . $faker->$emailType;
    setlocale(LC_ALL, 'de_DE');
    $newUser['email'] = strtolower(iconv('UTF-8', 'utf-8//TRANSLIT', $email));

    $birthday = $faker->dateTimeBetween('-80 years','-15 years');
    $newUser['birthday'] = $birthday->format('m-d-Y');

    $percentage = mt_rand (1,100);
    $ipType = $percentage < 85 ? 'ipv4' : 'ipv6';
    $newUser['ipaddress'] = $faker->$ipType;

    return $newUser;
}


// Create an array to store the CSV data
$csvData = array();

// Generate and add headers to the CSV data
$headers = array('Name', 'Email', 'Age');
$csvData[] = $headers;

// Generate and add individual records to the CSV data
for ($i = 1; $i <= $numRecords; $i++) {
    $name = "Person $i";
    $email = "person$i@example.com";
    $age = rand(18, 70); // Random age between 18 and 70

    $record = array($name, $email, $age);
    $csvData[] = $record;
}

// Create a file pointer for writing
$fp = fopen('people.csv', 'w');

// Loop through the CSV data and write it to the file
foreach ($csvData as $row) {
    fputcsv($fp, $row);
}

// Close the file pointer
fclose($fp);

echo "CSV file 'people.csv' with 100 records has been created.";

?>