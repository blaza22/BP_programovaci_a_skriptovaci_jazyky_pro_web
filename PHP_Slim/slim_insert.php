<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

// Načtení Slim frameworku
require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

$app->get('/insert', function (Request $request, Response $response, $args) {
    // Připojení k DB
    $dsn = "mysql:host=127.0.0.1;dbname=bp_srovnani;charset=utf8mb4";
    $pdo = new PDO($dsn, 'root', '');
    
    $iterace = 100;
    $casy = [];

    for ($i = 0; $i < $iterace; $i++) {
        $start = microtime(true);
        
        // V každé iteraci vložíme 10 záznamů
        for ($j = 0; $j < 10; $j++) {
            $text = "Benchmark test zprávy " . rand(1, 10000);
            $sql = "INSERT INTO zpravy (id_uzivatele, id_kategorie, text_zpravy) VALUES (1, 1, '$text')";
            $pdo->exec($sql);
        }
        
        $casy[] = (microtime(true) - $start) * 1000;
    }

    $prumerny_cas = array_sum($casy) / count($casy);

    $payload = json_encode([
        'jazyk' => 'PHP Slim Framework',
        'test' => 'Hromadný zápis (INSERT 10x na iteraci)',
        'pocet_iteraci' => $iterace,
        'prumerny_cas_ms' => round($prumerny_cas, 2)
    ]);
    
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
?>