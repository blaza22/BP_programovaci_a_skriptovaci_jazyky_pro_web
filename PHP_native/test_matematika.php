<?php
set_time_limit(300); // Dali jsme mu víc času, milion už dá zabrat

$limit = 1000000; // Zvýšený limit na milion
$iterace = 100;    // Počet opakování pro přesný průměr
$casy = [];
$prvocisla_pocet = 0;

for ($k = 0; $k < $iterace; $k++) {
    $start_time = microtime(true);
    
    $sito = array_fill(0, $limit + 1, true);
    $sito[0] = false;
    $sito[1] = false;

    for ($p = 2; $p * $p <= $limit; $p++) {
        if ($sito[$p] == true) {
            for ($i = $p * $p; $i <= $limit; $i += $p) {
                $sito[$i] = false;
            }
        }
    }

    $prvocisla = [];
    for ($p = 2; $p <= $limit; $p++) {
        if ($sito[$p]) {
            $prvocisla[] = $p;
        }
    }
    
    $end_time = microtime(true);
    $casy[] = ($end_time - $start_time) * 1000;
    $prvocisla_pocet = count($prvocisla);
}

// Výpočet průměru
$prumerny_cas = array_sum($casy) / count($casy);

header('Content-Type: application/json');
echo json_encode([
    'jazyk' => 'PHP Nativní',
    'test' => "Generování prvočísel do $limit",
    'pocet_iteraci' => $iterace,
    'nalezeno_prvocisel' => $prvocisla_pocet,
    'prumerny_cas_ms' => round($prumerny_cas, 2)
]);
?>