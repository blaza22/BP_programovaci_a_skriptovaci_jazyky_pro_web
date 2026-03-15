# BP_programovaci_a_skriptovaci_jazyky_pro_web

DOKUMENTACE K MĚŘICÍM SKRIPTŮM - BAKALÁŘSKÁ PRÁCE

Autor: Filip Blažek

Tento archiv obsahuje kompletní zdrojové kódy pro reprodukci zátěžových 
testů popsaných v praktické části bakalářské práce.

1. POŽADAVKY NA PROSTŘEDÍ
--------------------------------------------------------------------
- Lokální server: XAMPP s PHP 8.x a MySQL/MariaDB
- Python: verze 3.8 nebo novější
- Správce balíčků: Composer (pro PHP Slim) a pip (pro Python)

2. PŘÍPRAVA DATABÁZE
--------------------------------------------------------------------
1. Spusťte MySQL server (např. přes XAMPP Control Panel).
2. Otevřete phpMyAdmin nebo jiný databázový klient.
3. Vytvořte prázdnou databázi s názvem "bp_srovnani" (nebo upravte 
   připojovací údaje v testovacích skriptech).
4. Naimportujte přiložený soubor "export_databaze.sql", který vytvoří 
   tabulky "uzivatele", "zpravy", "kategorie" a naplní je testovacími daty.

3. SPUŠTĚNÍ TESTŮ: PHP NATIVE
--------------------------------------------------------------------
Nevyžaduje žádnou instalaci závislostí. 
Složku "PHP_native" nakopírujte do složky "htdocs" (v XAMPP) a skripty 
spouštějte přímo přes prohlížeč (např. http://localhost/PHP_native/test_db.php).

4. SPUŠTĚNÍ TESTŮ: PHP SLIM
--------------------------------------------------------------------
1. Otevřete příkazovou řádku ve složce "PHP_Slim".
2. Spusťte příkaz: "composer install" (tím se stáhne framework Slim do 
   složky vendor).
3. Následně složku přesuňte do "htdocs" a testy spouštějte přes prohlížeč.

5. SPUŠTĚNÍ TESTŮ: PYTHON FLASK
--------------------------------------------------------------------
Pro zajištění čistého prostředí doporučuji využít virtuální prostředí (venv):
1. Otevřete příkazovou řádku ve složce "Python-flask".
2. Vytvořte virtuální prostředí: "python -m venv venv"
3. Aktivujte prostředí:
   - Windows: "venv\Scripts\activate"
   - Linux/Mac: "source venv/bin/activate"
4. Nainstalujte potřebné knihovny: "pip install -r requirements.txt"
5. Skripty spusťte z konzole (např. "python test_db.py") a výsledky 
   sledujte na příslušném lokálním portu v prohlížeči (typicky localhost:5000).
====================================================================
