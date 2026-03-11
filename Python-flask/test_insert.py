import time
import random
from flask import Flask, jsonify
import mysql.connector

app = Flask(__name__)

@app.route('/insert')
def test_insert():
    iterace = 100
    casy = []
    
    db_config = {
        'host': '127.0.0.1',
        'user': 'root',
        'password': '',
        'database': 'bp_srovnani'
    }
    
    conn = mysql.connector.connect(**db_config)

    for _ in range(iterace):
        start_time = time.time()
        
        cursor = conn.cursor()
        # V každé iteraci vložíme 10 záznamů
        for _ in range(10):
            text = f"Benchmark test zprávy {random.randint(1, 10000)}"
            sql = f"INSERT INTO zpravy (id_uzivatele, id_kategorie, text_zpravy) VALUES (1, 1, '{text}')"
            cursor.execute(sql)
            
        conn.commit() # Uložení změn do databáze
        cursor.close()
        
        end_time = time.time()
        casy.append((end_time - start_time) * 1000)
        
    conn.close()
        
    prumerny_cas = sum(casy) / len(casy)
    
    return jsonify({
        'jazyk': 'Python Flask',
        'test': 'Hromadný zápis (INSERT 10x na iteraci)',
        'pocet_iteraci': iterace,
        'celkem_zapsano_radku': iterace * 10,
        'prumerny_cas_ms': round(prumerny_cas, 2)
    })

if __name__ == '__main__':
    app.run(port=5000)