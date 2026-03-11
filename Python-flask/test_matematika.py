import time
from flask import Flask, jsonify

app = Flask(__name__)

@app.route('/matematika')
def test_matematika():
    limit = 1000000 # Zvýšený limit na milion
    iterace = 100    # Počet opakování pro přesný průměr
    casy = []
    prvocisla_pocet = 0
    
    for k in range(iterace):
        start_time = time.time()
        
        sito = [True] * (limit + 1)
        sito[0] = False
        sito[1] = False
        
        p = 2
        while p * p <= limit:
            if sito[p]:
                for i in range(p * p, limit + 1, p):
                    sito[i] = False
            p += 1
            
        prvocisla = []
        for p in range(2, limit + 1):
            if sito[p]:
                prvocisla.append(p)
                
        end_time = time.time()
        casy.append((end_time - start_time) * 1000)
        prvocisla_pocet = len(prvocisla)
        
    # Výpočet průměru
    prumerny_cas = sum(casy) / len(casy)
    
    return jsonify({
        'jazyk': 'Python Flask',
        'test': f'Generování prvočísel do {limit}',
        'pocet_iteraci': iterace,
        'nalezeno_prvocisel': prvocisla_pocet,
        'prumerny_cas_ms': round(prumerny_cas, 2)
    })

if __name__ == '__main__':
    app.run(port=5000)