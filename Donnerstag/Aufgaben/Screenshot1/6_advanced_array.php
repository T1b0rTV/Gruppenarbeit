<?php
// 6. Fortgeschrittene Array-Manipulation: assoziatives Array und Sortieren nach Alter absteigend
$users = [
    ['name' => 'Max', 'alter' => 25, 'stadt' => 'Berlin'],
    ['name' => 'Anna', 'alter' => 32, 'stadt' => 'Hamburg'],
    ['name' => 'Tim', 'alter' => 19, 'stadt' => 'München'],
];

usort($users, function($a, $b){
    return $b['alter'] <=> $a['alter'];
});

echo "Benutzer sortiert nach Alter (absteigend):\n";
foreach ($users as $u){
    echo "{$u['name']} ist {$u['alter']} Jahre alt und wohnt in {$u['stadt']}\n";
}
?>
