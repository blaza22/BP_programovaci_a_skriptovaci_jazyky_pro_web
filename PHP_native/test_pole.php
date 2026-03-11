<?php
set_time_limit(300);

$iterace = 100;
$casy = [];
$velikost_pole = 100000;

for ($i = 0; $i < $iterace; $i++) {
    // 1. Vygenerování pole s náhodnými čísly (příprava dat - neměříme)
    $pole = [];
    for ($j = 0; $j < $velikost_pole; $j++) {
        $pole[] = rand(1, 1000000);
    }
    
    // 2. Start stopek - Měříme POUZE samotné třídění
    $start_time = microtime(true);
    
    // Nativní funkce PHP pro seřazení pole
    sort($pole);
    
    $end_time = microtime(true);
    // 3. Stop stopek
    
    $casy[] = ($end_time - $start_time) * 1000;
    
    // Uvolnění paměti pro další iteraci
    unset($pole);
}

$prumerny_cas = array_sum($casy) / count($casy);

header('Content-Type: application/json');
echo json_encode([
    'jazyk' => 'PHP Nativní',
    'test' => 'Třídění pole (' . $velikost_pole . ' prvků)',
    'pocet_iteraci' => $iterace,
    'prumerny_cas_ms' => round($prumerny_cas, 2)
]);
?>