<?php
$host = '127.0.0.1';
$db   = 'bp_srovnani';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$pdo = new PDO($dsn, $user, $pass);

$iterace = 100;
$casy = [];

for ($i = 0; $i < $iterace; $i++) {
    $start_time = microtime(true);
    
    // V každé iteraci vložíme 10 záznamů
    for ($j = 0; $j < 10; $j++) {
        $text = "Benchmark test zprávy " . rand(1, 10000);
        // Předpokládáme, že uživatel s ID 1 a kategorie s ID 1 v DB existují (z předchozího plnění)
        $sql = "INSERT INTO zpravy (id_uzivatele, id_kategorie, text_zpravy) VALUES (1, 1, '$text')";
        $pdo->exec($sql);
    }
    
    $end_time = microtime(true);
    $casy[] = ($end_time - $start_time) * 1000;
}

$prumerny_cas = array_sum($casy) / count($casy);

header('Content-Type: application/json');
echo json_encode([
    'jazyk' => 'PHP Nativní',
    'test' => 'Hromadný zápis (INSERT 10x na iteraci)',
    'pocet_iteraci' => $iterace,
    'celkem_zapsano_radku' => $iterace * 10,
    'prumerny_cas_ms' => round($prumerny_cas, 2)
]);
?>