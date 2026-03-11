<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

// Načtení frameworku (toho batohu, co jsi právě stáhl)
require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

// Naše místnost "databaze" úplně stejně jako v Pythonu
$app->get('/databaze', function (Request $request, Response $response, $args) {
    // Připojení k tvé DB
    $dsn = "mysql:host=127.0.0.1;dbname=bp_srovnani;charset=utf8mb4";
    $pdo = new PDO($dsn, 'root', '');
    
    $iterace = 100;
    $casy = [];
    $sql = "SELECT z.id, z.text_zpravy, u.jmeno, u.email, k.nazev as kategorie, z.cas_vytvoreni 
            FROM zpravy z 
            JOIN uzivatele u ON z.id_uzivatele = u.id 
            JOIN kategorie k ON z.id_kategorie = k.id";

    for ($i = 0; $i < $iterace; $i++) {
        $start = microtime(true);
        $stmt = $pdo->query($sql);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $casy[] = (microtime(true) - $start) * 1000;
    }

    $prumerny_cas = array_sum($casy) / count($casy);

    $payload = json_encode([
        'jazyk' => 'PHP Slim Framework',
        'test' => 'Složitý databázový dotaz (2x JOIN)',
        'pocet_iteraci' => $iterace,
        'prumerny_cas_ms' => round($prumerny_cas, 2)
    ]);
    
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
?>