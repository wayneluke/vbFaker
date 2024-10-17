<?php

function weightedRandom($values) {
    // Calculate the total weight of all values in the array
    $totalWeight = array_sum(array_column($values, 'weight'));

    // Generate a random number between 0 and the total weight
    $randomNumber = mt_rand(0, $totalWeight - 1);

    // Loop through the values array and find the chosen value
    foreach ($values as $value) {
        $randomNumber -= $value['weight'];
        if ($randomNumber < 0) {
            return $value['value'];
        }
    }

    // This should not happen, but just in case
    return null;
}

// Example usage:
$groups = [
    ['value' => '2', 'weight' => 10],
    ['value' => '14', 'weight' => 10],
    ['value' => '15', 'weight' => 1],
];
for ($i=1; $i<=100; $i++) {
    $selectedValue = weightedRandom($groups);
    echo "Selected value: $selectedValue\n";
}