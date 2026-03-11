<?php
$host = '127.0.0.1';
$db   = 'bp_srovnani'; // Upraveno přesně podle tvé databáze
$user = 'root';
$pass = '';

// Připojení k databázi (PDO)
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$pdo = new PDO($dsn, $user, $pass);

$iterace = 100;
$casy = [];

// Složitý SQL dotaz využívající 2x JOIN
$sql = "SELECT z.id, z.text_zpravy, u.jmeno, u.email, k.nazev as kategorie, z.cas_vytvoreni 
        FROM zpravy z 
        JOIN uzivatele u ON z.id_uzivatele = u.id 
        JOIN kategorie k ON z.id_kategorie = k.id";

for ($i = 0; $i < $iterace; $i++) {
    $start_time = microtime(true);
    
    // Provedení dotazu a uložení všech dat do paměti (pole)
    $stmt = $pdo->query($sql);
    $vysledky = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $end_time = microtime(true);
    $casy[] = ($end_time - $start_time) * 1000;
}

$prumerny_cas = array_sum($casy) / count($casy);

header('Content-Type: application/json');
echo json_encode([
    'jazyk' => 'PHP Nativní',
    'test' => 'Složitý databázový dotaz (2x JOIN)',
    'pocet_iteraci' => $iterace,
    'nacteno_radku_v_jednom_behu' => count($vysledky),
    'prumerny_cas_ms' => round($prumerny_cas, 2)
]);
?>