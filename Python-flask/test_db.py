import time
from flask import Flask, jsonify
import mysql.connector

app = Flask(__name__)

@app.route('/databaze')
def test_databaze():
    iterace = 100
    casy = []
    
    # Připojení k databázi
    db_config = {
        'host': '127.0.0.1',
        'user': 'root',
        'password': '',
        'database': 'bp_srovnani' # Upraveno přesně podle tvé databáze
    }
    
    # Složitý SQL dotaz využívající 2x JOIN
    sql = """SELECT z.id, z.text_zpravy, u.jmeno, u.email, k.nazev as kategorie, z.cas_vytvoreni 
             FROM zpravy z 
             JOIN uzivatele u ON z.id_uzivatele = u.id 
             JOIN kategorie k ON z.id_kategorie = k.id"""

    conn = mysql.connector.connect(**db_config)

    for _ in range(iterace):
        start_time = time.time()
        
        # Provedení dotazu a uložení všech dat do paměti (slovník)
        cursor = conn.cursor(dictionary=True)
        cursor.execute(sql)
        vysledky = cursor.fetchall()
        cursor.close()
        
        end_time = time.time()
        casy.append((end_time - start_time) * 1000)
        
    conn.close()
        
    prumerny_cas = sum(casy) / len(casy)
    
    return jsonify({
        'jazyk': 'Python Flask',
        'test': 'Složitý databázový dotaz (2x JOIN)',
        'pocet_iteraci': iterace,
        'nacteno_radku_v_jednom_behu': len(vysledky),
        'prumerny_cas_ms': round(prumerny_cas, 2)
    })

if __name__ == '__main__':
    app.run(port=5000)